<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user has dashboard permissions (for full data access)
        $hasFullAccess = auth()->user()->hasRole('super-admin') || auth()->user()->can('Dashboard.view dashboard') || auth()->user()->can('Dashboard.manage dashboard');

        // ========== EMPLOYEE DASHBOARD ==========
        // If user has 'employee' role, show employee-specific dashboard
        if (auth()->user()->hasRole('employee')) {
            return $this->employeeDashboard();
        }

        // ========== HR DASHBOARD ==========
        // If user has 'hr' role, show HR-specific dashboard
        if (auth()->user()->hasRole('hr')) {
            return $this->hrDashboard();
        }

        // ========== RECEPTIONIST DASHBOARD ==========
        // If user has 'receptionist' role, show receptionist-specific dashboard
        if (auth()->user()->hasRole('receptionist')) {
            return $this->receptionistDashboard();
        }

        // ========== CUSTOMER/CLIENT DASHBOARD ==========
        // If user has 'customer', 'client', or 'company' role, show customer-specific dashboard
        if (auth()->user()->hasRole('customer') || auth()->user()->hasRole('client') || auth()->user()->hasRole('company')) {
            return $this->customerDashboard();
        }

        // ========== KPI STATS - ALL DYNAMIC ==========
        
        // 1. EMPLOYEES - Real count with growth
        $totalEmployees = Employee::count();
        $lastMonthEmployees = Employee::where('created_at', '<', now()->startOfMonth())->count();
        $employeeDelta = $lastMonthEmployees > 0 ? round((($totalEmployees - $lastMonthEmployees) / $lastMonthEmployees) * 100) : 0;

        // 2. PROJECTS - Real count (check if table exists)
        $totalProjects = 0;
        $projectDelta = 0;
        try {
            if (DB::getSchemaBuilder()->hasTable('projects')) {
                $totalProjects = DB::table('projects')->count();
                $lastMonthProjects = DB::table('projects')->where('created_at', '<', now()->startOfMonth())->count();
                $projectDelta = $lastMonthProjects > 0 ? round((($totalProjects - $lastMonthProjects) / $lastMonthProjects) * 100) : 0;
            }
        } catch (\Exception $e) {
            $totalProjects = 0;
        }

        // 3. PENDING TASKS - Real ticket counts
        $pendingTasks = Ticket::whereIn('status', ['pending', 'open'])->count();
        $urgentTasks = Ticket::whereIn('priority', ['urgent', 'high'])->count();

        // 4. ATTENDANCE TODAY - Real attendance data
        $today = now()->toDateString();
        $presentToday = Attendance::whereDate('date', $today)
            ->whereIn('status', ['present', 'late', 'early_leave'])
            ->count();
        $attendancePercent = $totalEmployees > 0 ? round(($presentToday / $totalEmployees) * 100) : 0;

        $stats = [
            'employees' => $totalEmployees,
            'delta_employees' => ($employeeDelta >= 0 ? '+' : '') . $employeeDelta . '%',
            'projects' => $totalProjects,
            'delta_projects' => ($projectDelta >= 0 ? '+' : '') . $projectDelta . '%',
            'open_positions' => $pendingTasks,
            'urgent_priority' => $urgentTasks,
            'attendance_percent' => $attendancePercent . '%',
            'attendance_present' => $presentToday . '/' . $totalEmployees,
        ];

        // ========== NOTIFICATIONS - DYNAMIC ==========
        $notifications = [];
        
        // Pending leaves
        $pendingLeaves = Leave::where('status', 'pending')->count();
        if ($pendingLeaves > 0) {
            $notifications[] = [
                'title' => $pendingLeaves . ' pending leave request' . ($pendingLeaves > 1 ? 's' : ''),
                'time' => 'Now'
            ];
        }
        
        // Recent tickets (last 24 hours)
        $recentTicketsCount = Ticket::where('created_at', '>=', now()->subHours(24))->count();
        if ($recentTicketsCount > 0) {
            $notifications[] = [
                'title' => $recentTicketsCount . ' new ticket' . ($recentTicketsCount > 1 ? 's' : ''),
                'time' => '24h'
            ];
        }

        // Absent employees today
        $absentToday = $totalEmployees - $presentToday;
        if ($absentToday > 0) {
            $notifications[] = [
                'title' => $absentToday . ' employee' . ($absentToday > 1 ? 's' : '') . ' absent today',
                'time' => 'Today'
            ];
        }

        // ========== RECENT INQUIRIES - DYNAMIC ==========
        $recentInquiries = [];
        try {
            if (DB::getSchemaBuilder()->hasTable('inquiries')) {
                $inquiries = DB::table('inquiries')
                    ->orderBy('created_at', 'desc')
                    ->limit(6)
                    ->get();
                
                foreach ($inquiries as $inq) {
                    $recentInquiries[] = [
                        'company' => $inq->company_name ?? 'N/A',
                        'person' => $inq->person_name ?? '—',
                        'phone' => $inq->phone ?? '—',
                        'date' => isset($inq->created_at) ? Carbon::parse($inq->created_at)->format('M d') : '—',
                        'next' => isset($inq->next_followup_date) ? Carbon::parse($inq->next_followup_date)->format('M d') : '—',
                        'status' => $inq->status ?? 'New',
                        'demo' => isset($inq->demo_date) ? Carbon::parse($inq->demo_date)->format('M d, Y | h:i A') : '—',
                    ];
                }
            }
        } catch (\Exception $e) {
            // Table doesn't exist - leave empty
        }

        // ========== RECENT TICKETS - DYNAMIC ==========
        $recentTickets = [];
        $tickets = Ticket::with('assignedEmployee')->orderBy('created_at', 'desc')->limit(6)->get();
        
        foreach ($tickets as $idx => $ticket) {
            // Determine priority color based on actual data
            $priorityColor = 'blue'; // default
            if (in_array($ticket->priority, ['urgent', 'high'])) {
                $priorityColor = 'orange';
            } elseif ($ticket->status === 'closed') {
                $priorityColor = 'green';
            }

            $recentTickets[] = [
                'id' => $ticket->id,
                'serial' => $idx + 1,
                'title' => $ticket->title ?? $ticket->subject ?? 'Untitled',
                'desc' => $ticket->description ?? 'No description',
                'status' => ucfirst($ticket->status ?? 'Open'),
                'work' => $ticket->assignedEmployee ? $ticket->assignedEmployee->name : 'Work Not Assigned',
                'priority' => $priorityColor,
                'category' => $ticket->category ?? 'General Inquiry',
                'customer' => $ticket->customer ?? 'Customer',
            ];
        }

        // ========== COMPANY CHART DATA - DYNAMIC ==========
        $companyData = [];
        try {
            if (DB::getSchemaBuilder()->hasTable('inquiries')) {
                // Get top companies by inquiry count
                $topCompanies = DB::table('inquiries')
                    ->select('company_name', DB::raw('COUNT(*) as count'))
                    ->whereNotNull('company_name')
                    ->groupBy('company_name')
                    ->orderByDesc('count')
                    ->limit(4)
                    ->get();
                
                foreach ($topCompanies as $company) {
                    $companyData[] = [
                        'name' => $company->company_name,
                        'value' => $company->count
                    ];
                }
            }
        } catch (\Exception $e) {
            // Fallback to default data if table doesn't exist
            $companyData = [
                ['name' => 'Geo Research', 'value' => 32],
                ['name' => 'Pure Dental', 'value' => 26],
                ['name' => 'Acme', 'value' => 22],
                ['name' => 'Globex', 'value' => 20],
            ];
        }

        // ========== NOTES - DYNAMIC FROM DATABASE ==========
        $users = Employee::select('id', 'name', 'photo_path')->orderBy('name')->get()->map(function($emp) {
            return [
                'id' => $emp->id, 
                'name' => $emp->name,
                'photo' => $emp->photo_path ? asset('storage/' . $emp->photo_path) : asset('new_theme/dist/img/avatar.png')
            ];
        })->toArray();

        // Check if notes table exists
        $systemNotes = [];
        $empNotes = [];
        
        try {
            if (DB::getSchemaBuilder()->hasTable('notes')) {
                // Get system notes
                $systemNotesData = DB::table('notes')
                    ->where('type', 'system')
                    ->orderBy('created_at', 'desc')
                    ->limit(4)
                    ->get();
                
                foreach ($systemNotesData as $note) {
                    $systemNotes[] = [
                        'text' => $note->content ?? $note->text ?? '',
                        'date' => isset($note->created_at) ? Carbon::parse($note->created_at)->format('M d, Y g:i A') : now()->format('M d, Y g:i A')
                    ];
                }

                // Get employee notes
                $empNotesData = DB::table('notes')
                    ->where('type', 'employee')
                    ->orderBy('created_at', 'desc')
                    ->limit(4)
                    ->get();
                
                foreach ($empNotesData as $note) {
                    $empNotes[] = [
                        'text' => $note->content ?? $note->text ?? '',
                        'date' => isset($note->created_at) ? Carbon::parse($note->created_at)->format('M d, Y') : now()->format('M d, Y'),
                        'assignees' => isset($note->assignees) ? json_decode($note->assignees, true) : array_slice(array_column($users, 'name'), 0, 2)
                    ];
                }
            }
        } catch (\Exception $e) {
            // Fallback to dynamic data based on actual system activity
            $systemNotes = [
                [
                    'text' => "Total " . $totalEmployees . " employees in the system. " . $pendingLeaves . " leave requests pending approval.",
                    'date' => now()->format('M d, Y g:i A')
                ],
                [
                    'text' => "Today's attendance: " . $presentToday . " out of " . $totalEmployees . " employees present (" . $attendancePercent . "%).",
                    'date' => now()->subHours(2)->format('M d, Y g:i A')
                ],
            ];

            $empNotes = [
                [
                    'text' => "Review and approve " . $pendingLeaves . " pending leave requests.",
                    'date' => now()->format('M d, Y'),
                    'assignees' => array_slice(array_column($users, 'name'), 0, 2)
                ],
                [
                    'text' => "Follow up on " . $urgentTasks . " urgent priority tickets.",
                    'date' => now()->addDays(1)->format('M d, Y'),
                    'assignees' => array_slice(array_column($users, 'name'), 0, 2)
                ],
            ];
        }

        $notes = [
            'notes' => $systemNotes,
            'emp' => $empNotes,
        ];

        return view('dashboard', compact('stats', 'notifications', 'recentInquiries', 'recentTickets', 'users', 'notes', 'companyData'));
    }

    /**
     * Employee-specific dashboard
     */
    private function employeeDashboard()
    {
        $employee = Employee::where('user_id', auth()->id())->first();
        
        if (!$employee) {
            // If no employee record, show basic message
            return view('dashboard-employee', [
                'employee' => null,
                'stats' => [],
                'birthdays' => [],
                'notes' => [],
                'todayBirthdays' => [],
                'upcomingBirthdays' => [],
                'todayLeaves' => []
            ]);
        }

        // Get current month attendance stats for this employee
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $attendances = Attendance::where('employee_id', $employee->id)
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->get();

        // Calculate stats
        $presentDays = $attendances->whereIn('status', ['present'])->count();
        $absentDays = $attendances->where('status', 'absent')->count();
        $workingHours = $attendances->sum(function($att) {
            if ($att->check_in && $att->check_out) {
                $checkIn = Carbon::parse($att->check_in);
                $checkOut = Carbon::parse($att->check_out);
                return $checkIn->diffInHours($checkOut);
            }
            return 0;
        });
        
        $lateEntries = $attendances->where('status', 'late')->count();
        $earlyExits = $attendances->where('status', 'early_leave')->count();

        // Get active projects count for this employee
        $activeProjects = 0;
        try {
            if (DB::getSchemaBuilder()->hasTable('project_members')) {
                $activeProjects = DB::table('project_members')
                    ->join('projects', 'project_members.project_id', '=', 'projects.id')
                    ->where('project_members.employee_id', $employee->id)
                    ->whereIn('projects.status', ['active', 'in_progress'])
                    ->count();
            }
        } catch (\Exception $e) {
            $activeProjects = 0;
        }

        $stats = [
            'present_days' => str_pad($presentDays, 2, '0', STR_PAD_LEFT),
            'absent_days' => str_pad($absentDays, 2, '0', STR_PAD_LEFT),
            'working_hours' => number_format($workingHours, 0),
            'active_projects' => str_pad($activeProjects, 2, '0', STR_PAD_LEFT),
            'late_entries' => str_pad($lateEntries, 3, '0', STR_PAD_LEFT),
            'early_exits' => str_pad($earlyExits, 3, '0', STR_PAD_LEFT),
        ];

        // Get TODAY's birthdays
        $todayBirthdays = Employee::whereMonth('date_of_birth', now()->month)
            ->whereDay('date_of_birth', now()->day)
            ->get()
            ->map(function($emp) {
                return [
                    'name' => $emp->name,
                    'date' => Carbon::parse($emp->date_of_birth)->day,
                    'photo' => $emp->photo_path ? asset('storage/' . $emp->photo_path) : asset('new_theme/dist/img/avatar.png'),
                    'age' => Carbon::parse($emp->date_of_birth)->age
                ];
            });

        // Get UPCOMING birthdays (next 7 days in current month)
        $upcomingBirthdays = Employee::whereMonth('date_of_birth', now()->month)
            ->whereDay('date_of_birth', '>', now()->day)
            ->whereDay('date_of_birth', '<=', now()->addDays(7)->day)
            ->orderByRaw('DAY(date_of_birth)')
            ->get()
            ->map(function($emp) {
                $birthday = Carbon::parse($emp->date_of_birth)->setYear(now()->year);
                return [
                    'name' => $emp->name,
                    'date' => $birthday->day,
                    'photo' => $emp->photo_path ? asset('storage/' . $emp->photo_path) : asset('new_theme/dist/img/avatar.png'),
                    'daysUntil' => now()->diffInDays($birthday)
                ];
            });

        // Get TODAY's leaves (employees on leave today)
        $todayLeaves = Leave::with('employee')
            ->where('status', 'approved')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get()
            ->map(function($leave) {
                return [
                    'name' => $leave->employee->name ?? 'Unknown',
                    'type' => ucfirst($leave->leave_type ?? 'Leave'),
                    'photo' => $leave->employee && $leave->employee->photo_path 
                        ? asset('storage/' . $leave->employee->photo_path) 
                        : asset('new_theme/dist/img/avatar.png'),
                    'start_date' => Carbon::parse($leave->start_date)->format('M d'),
                    'end_date' => Carbon::parse($leave->end_date)->format('M d')
                ];
            });

        // Get employee birthdays for current month (for calendar)
        $birthdays = Employee::whereMonth('date_of_birth', now()->month)
            ->orderByRaw('DAY(date_of_birth)')
            ->get()
            ->map(function($emp) {
                return [
                    'name' => $emp->name,
                    'date' => Carbon::parse($emp->date_of_birth)->day,
                    'photo' => $emp->photo_path ? asset('storage/' . $emp->photo_path) : asset('new_theme/dist/img/avatar.png')
                ];
            });

        // Get pagination parameters
        $notesPage = request()->get('notes_page', 1);
        $empNotesPage = request()->get('emp_notes_page', 1);
        $perPage = 4;

        // Get system notes with pagination
        $systemNotes = [];
        $systemNotesTotal = 0;
        $systemNotesTotalPages = 1;
        
        try {
            if (DB::getSchemaBuilder()->hasTable('notes')) {
                $systemNotesTotal = DB::table('notes')
                    ->where('type', 'system')
                    ->where(function($query) use ($employee) {
                        $query->where('user_id', auth()->id())
                              ->orWhere('employee_id', $employee->id)
                              ->orWhereNull('user_id');
                    })
                    ->count();
                
                $systemNotesTotalPages = ceil($systemNotesTotal / $perPage);
                
                $systemNotesData = DB::table('notes')
                    ->where('type', 'system')
                    ->where(function($query) use ($employee) {
                        $query->where('user_id', auth()->id())
                              ->orWhere('employee_id', $employee->id)
                              ->orWhereNull('user_id');
                    })
                    ->orderBy('created_at', 'desc')
                    ->skip(($notesPage - 1) * $perPage)
                    ->take($perPage)
                    ->get();
                
                foreach ($systemNotesData as $note) {
                    $systemNotes[] = [
                        'id' => $note->id,
                        'text' => $note->content ?? '',
                        'date' => isset($note->created_at) ? Carbon::parse($note->created_at)->format('M d, Y g:i A') : now()->format('M d, Y g:i A')
                    ];
                }
            }
        } catch (\Exception $e) {
            // Fallback
        }

        // Get employee notes with pagination (includes admin-created notes)
        $empNotes = [];
        $empNotesTotal = 0;
        $empNotesTotalPages = 1;
        
        try {
            if (DB::getSchemaBuilder()->hasTable('notes')) {
                // Get all employee-type notes (including those created by admin for this employee)
                $empNotesTotal = DB::table('notes')
                    ->where('type', 'employee')
                    ->count();
                
                $empNotesTotalPages = ceil($empNotesTotal / $perPage);
                
                $empNotesData = DB::table('notes')
                    ->where('type', 'employee')
                    ->orderBy('created_at', 'desc')
                    ->skip(($empNotesPage - 1) * $perPage)
                    ->take($perPage)
                    ->get();
                
                foreach ($empNotesData as $note) {
                    $assignees = isset($note->assignees) ? json_decode($note->assignees, true) : [];
                    $assigneePhotos = [];
                    
                    if (is_array($assignees)) {
                        foreach ($assignees as $assigneeName) {
                            $assigneeEmp = Employee::where('name', $assigneeName)->first();
                            if ($assigneeEmp) {
                                $assigneePhotos[] = $assigneeEmp->photo_path ? asset('storage/' . $assigneeEmp->photo_path) : asset('new_theme/dist/img/avatar.png');
                            }
                        }
                    }
                    
                    $empNotes[] = [
                        'id' => $note->id,
                        'text' => $note->content ?? '',
                        'date' => isset($note->created_at) ? Carbon::parse($note->created_at)->format('M d, Y') : now()->format('M d, Y'),
                        'assignees' => $assignees,
                        'assignee_photos' => $assigneePhotos
                    ];
                }
            }
        } catch (\Exception $e) {
            // Fallback
        }

        // Get attendance calendar data for current month
        $attendanceCalendar = [];
        foreach ($attendances as $att) {
            $day = Carbon::parse($att->date)->day;
            $attendanceCalendar[$day] = $att->status; // present, late, early_leave, absent, leave
        }

        // Get leaves calendar data for current month
        $leavesCalendar = [];
        $monthLeaves = Leave::where('status', 'approved')
            ->where(function($query) use ($currentYear, $currentMonth) {
                $query->whereYear('start_date', $currentYear)
                      ->whereMonth('start_date', $currentMonth)
                      ->orWhere(function($q) use ($currentYear, $currentMonth) {
                          $q->whereYear('end_date', $currentYear)
                            ->whereMonth('end_date', $currentMonth);
                      });
            })
            ->with('employee')
            ->get();

        foreach ($monthLeaves as $leave) {
            $startDate = Carbon::parse($leave->start_date);
            $endDate = Carbon::parse($leave->end_date);
            
            // Mark all days in the leave period
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                if ($currentDate->month == $currentMonth && $currentDate->year == $currentYear) {
                    $day = $currentDate->day;
                    if (!isset($leavesCalendar[$day])) {
                        $leavesCalendar[$day] = [];
                    }
                    $leavesCalendar[$day][] = [
                        'name' => $leave->employee->name ?? 'Unknown',
                        'type' => $leave->leave_type ?? 'Leave'
                    ];
                }
                $currentDate->addDay();
            }
        }

        // Get birthdays calendar data for current month
        $birthdaysCalendar = [];
        foreach ($birthdays as $birthday) {
            $day = $birthday['date'];
            if (!isset($birthdaysCalendar[$day])) {
                $birthdaysCalendar[$day] = [];
            }
            $birthdaysCalendar[$day][] = [
                'name' => $birthday['name'],
                'photo' => $birthday['photo']
            ];
        }

        return view('dashboard-employee', compact(
            'employee', 
            'stats', 
            'birthdays', 
            'attendanceCalendar',
            'todayBirthdays',
            'upcomingBirthdays',
            'todayLeaves',
            'leavesCalendar',
            'birthdaysCalendar',
            'systemNotes',
            'empNotes',
            'notesPage',
            'empNotesPage',
            'systemNotesTotalPages',
            'empNotesTotalPages'
        ));
    }

    /**
     * Store a new note for employee
     */
    public function storeNote(Request $request)
    {
        $request->validate([
            'note_text' => 'required|string|max:1000',
            'note_type' => 'required|in:notes,empNotes'
        ]);

        try {
            // Check if notes table exists, if not create it
            if (!DB::getSchemaBuilder()->hasTable('notes')) {
                DB::statement("
                    CREATE TABLE notes (
                        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        user_id BIGINT UNSIGNED NULL,
                        employee_id BIGINT UNSIGNED NULL,
                        type VARCHAR(50) DEFAULT 'employee',
                        content TEXT,
                        assignees JSON NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                    )
                ");
            }

            // Get employee record
            $employee = Employee::where('user_id', auth()->id())->first();

            // Determine note type
            $noteType = $request->note_type === 'notes' ? 'system' : 'employee';

            // Insert note
            DB::table('notes')->insert([
                'user_id' => auth()->id(),
                'employee_id' => $employee ? $employee->id : null,
                'type' => $noteType,
                'content' => $request->note_text,
                'assignees' => json_encode([auth()->user()->name]),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->back()->with('success', 'Note added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add note: ' . $e->getMessage());
        }
    }

    /**
     * Delete a note
     */
    public function deleteNote($id)
    {
        try {
            $deleted = DB::table('notes')
                ->where('id', $id)
                ->where('user_id', auth()->id())
                ->delete();

            if ($deleted) {
                return redirect()->back()->with('success', 'Note deleted successfully!');
            } else {
                return redirect()->back()->with('error', 'Note not found or unauthorized.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete note: ' . $e->getMessage());
        }
    }

    /**
     * HR-specific dashboard
     */
    private function hrDashboard()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // HR KPIs
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('status', 'active')->count();
        $onLeaveToday = Leave::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->where('status', 'approved')
            ->count();
        
        $pendingLeaves = Leave::where('status', 'pending')->count();
        
        // Attendance today
        $today = now()->toDateString();
        $presentToday = Attendance::whereDate('date', $today)
            ->whereIn('status', ['present', 'late', 'early_leave'])
            ->count();
        $absentToday = $totalEmployees - $presentToday - $onLeaveToday;
        $attendanceRate = $totalEmployees > 0 ? round(($presentToday / $totalEmployees) * 100) : 0;

        // New hires this month
        $newHires = Employee::whereYear('joining_date', $currentYear)
            ->whereMonth('joining_date', $currentMonth)
            ->count();

        $stats = [
            'total_employees' => $totalEmployees,
            'active_employees' => $activeEmployees,
            'on_leave_today' => $onLeaveToday,
            'pending_leaves' => $pendingLeaves,
            'present_today' => $presentToday,
            'absent_today' => $absentToday,
            'attendance_rate' => $attendanceRate,
            'new_hires' => $newHires,
        ];

        // Recent leave requests
        $recentLeaves = Leave::with('employee')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($leave) {
                return [
                    'id' => $leave->id,
                    'employee' => $leave->employee->name ?? 'Unknown',
                    'type' => ucfirst($leave->leave_type ?? 'Leave'),
                    'from' => Carbon::parse($leave->start_date)->format('M d'),
                    'to' => Carbon::parse($leave->end_date)->format('M d'),
                    'days' => Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date)) + 1,
                    'status' => $leave->status,
                    'reason' => $leave->reason ?? 'No reason provided'
                ];
            });

        // Upcoming birthdays (next 30 days)
        $upcomingBirthdays = Employee::whereRaw('DATE_ADD(date_of_birth, INTERVAL YEAR(CURDATE())-YEAR(date_of_birth) + IF(DAYOFYEAR(CURDATE()) > DAYOFYEAR(date_of_birth),1,0) YEAR) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)')
            ->orderByRaw('DAYOFYEAR(date_of_birth)')
            ->limit(5)
            ->get()
            ->map(function($emp) {
                $nextBirthday = Carbon::parse($emp->date_of_birth)->setYear(now()->year);
                if ($nextBirthday->isPast()) {
                    $nextBirthday->addYear();
                }
                return [
                    'name' => $emp->name,
                    'date' => $nextBirthday->format('M d'),
                    'days_until' => now()->diffInDays($nextBirthday),
                    'photo' => $emp->photo_path ? asset('storage/' . $emp->photo_path) : asset('new_theme/dist/img/avatar.png')
                ];
            });

        // Department-wise employee count
        $departmentStats = collect([]);
        try {
            // Check if department column exists
            if (DB::getSchemaBuilder()->hasColumn('employees', 'department')) {
                $departmentStats = Employee::select('department', DB::raw('count(*) as count'))
                    ->whereNotNull('department')
                    ->groupBy('department')
                    ->orderByDesc('count')
                    ->limit(5)
                    ->get();
            }
        } catch (\Exception $e) {
            // If department column doesn't exist, return empty collection
            $departmentStats = collect([]);
        }

        // Attendance trends (last 7 days)
        $attendanceTrends = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $present = Attendance::whereDate('date', $date)
                ->whereIn('status', ['present', 'late', 'early_leave'])
                ->count();
            $attendanceTrends[] = [
                'date' => $date->format('D'),
                'count' => $present,
                'percentage' => $totalEmployees > 0 ? round(($present / $totalEmployees) * 100) : 0
            ];
        }

        return view('dashboard-hr', compact('stats', 'recentLeaves', 'upcomingBirthdays', 'departmentStats', 'attendanceTrends'));
    }

    /**
     * Receptionist-specific dashboard
     */
    private function receptionistDashboard()
    {
        $today = now()->toDateString();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Receptionist KPIs
        $todayInquiries = 0;
        $pendingInquiries = 0;
        $totalInquiriesMonth = 0;
        $followUpToday = 0;

        try {
            if (DB::getSchemaBuilder()->hasTable('inquiries')) {
                $todayInquiries = DB::table('inquiries')
                    ->whereDate('created_at', $today)
                    ->count();
                
                $pendingInquiries = DB::table('inquiries')
                    ->whereIn('status', ['new', 'pending', 'follow_up'])
                    ->count();
                
                $totalInquiriesMonth = DB::table('inquiries')
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $currentMonth)
                    ->count();
                
                $followUpToday = DB::table('inquiries')
                    ->whereDate('next_followup_date', $today)
                    ->count();
            }
        } catch (\Exception $e) {
            // Tables don't exist
        }

        // Visitors today
        $visitorsToday = 0;
        try {
            if (DB::getSchemaBuilder()->hasTable('visitors')) {
                $visitorsToday = DB::table('visitors')
                    ->whereDate('visit_date', $today)
                    ->count();
            }
        } catch (\Exception $e) {
            $visitorsToday = 0;
        }

        // Active tickets
        $activeTickets = Ticket::whereIn('status', ['open', 'pending', 'in_progress'])->count();
        
        // Appointments today
        $appointmentsToday = 0;
        try {
            if (DB::getSchemaBuilder()->hasTable('appointments')) {
                $appointmentsToday = DB::table('appointments')
                    ->whereDate('appointment_date', $today)
                    ->count();
            }
        } catch (\Exception $e) {
            $appointmentsToday = 0;
        }

        // Calls handled today
        $callsToday = 0;
        try {
            if (DB::getSchemaBuilder()->hasTable('call_logs')) {
                $callsToday = DB::table('call_logs')
                    ->whereDate('created_at', $today)
                    ->count();
            }
        } catch (\Exception $e) {
            $callsToday = 0;
        }

        $stats = [
            'today_inquiries' => $todayInquiries,
            'pending_inquiries' => $pendingInquiries,
            'visitors_today' => $visitorsToday,
            'active_tickets' => $activeTickets,
            'appointments_today' => $appointmentsToday,
            'calls_today' => $callsToday,
            'total_inquiries_month' => $totalInquiriesMonth,
            'follow_up_today' => $followUpToday,
        ];

        // Recent inquiries
        $recentInquiries = collect([]);
        try {
            if (DB::getSchemaBuilder()->hasTable('inquiries')) {
                $recentInquiries = DB::table('inquiries')
                    ->orderBy('created_at', 'desc')
                    ->limit(6)
                    ->get()
                    ->map(function($inq) {
                        return [
                            'id' => $inq->id,
                            'company' => $inq->company_name ?? 'N/A',
                            'person' => $inq->person_name ?? 'Unknown',
                            'phone' => $inq->phone ?? 'N/A',
                            'email' => $inq->email ?? 'N/A',
                            'status' => $inq->status ?? 'new',
                            'time' => isset($inq->created_at) ? Carbon::parse($inq->created_at)->diffForHumans() : 'Recently',
                            'next_followup' => isset($inq->next_followup_date) ? Carbon::parse($inq->next_followup_date)->format('M d, Y') : 'Not set'
                        ];
                    });
            }
        } catch (\Exception $e) {
            $recentInquiries = collect([]);
        }

        // Today's follow-ups
        $todayFollowUps = collect([]);
        try {
            if (DB::getSchemaBuilder()->hasTable('inquiries')) {
                $todayFollowUps = DB::table('inquiries')
                    ->whereDate('next_followup_date', $today)
                    ->orderBy('next_followup_date')
                    ->limit(5)
                    ->get()
                    ->map(function($inq) {
                        return [
                            'company' => $inq->company_name ?? 'N/A',
                            'person' => $inq->person_name ?? 'Unknown',
                            'phone' => $inq->phone ?? 'N/A',
                            'time' => isset($inq->next_followup_date) ? Carbon::parse($inq->next_followup_date)->format('h:i A') : 'TBD',
                            'status' => $inq->status ?? 'pending'
                        ];
                    });
            }
        } catch (\Exception $e) {
            $todayFollowUps = collect([]);
        }

        // Recent tickets
        $recentTickets = Ticket::orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($ticket) {
                return [
                    'id' => $ticket->id,
                    'title' => $ticket->title ?? $ticket->subject ?? 'Untitled',
                    'customer' => $ticket->customer ?? 'Unknown',
                    'status' => $ticket->status ?? 'open',
                    'priority' => $ticket->priority ?? 'normal',
                    'time' => $ticket->created_at->diffForHumans()
                ];
            });

        // Inquiry trends (last 7 days)
        $inquiryTrends = [];
        try {
            if (DB::getSchemaBuilder()->hasTable('inquiries')) {
                for ($i = 6; $i >= 0; $i--) {
                    $date = now()->subDays($i);
                    $count = DB::table('inquiries')
                        ->whereDate('created_at', $date)
                        ->count();
                    $inquiryTrends[] = [
                        'date' => $date->format('D'),
                        'count' => $count
                    ];
                }
            }
        } catch (\Exception $e) {
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $inquiryTrends[] = [
                    'date' => $date->format('D'),
                    'count' => 0
                ];
            }
        }

        return view('dashboard-receptionist', compact('stats', 'recentInquiries', 'todayFollowUps', 'recentTickets', 'inquiryTrends'));
    }

    /**
     * Customer/Client-specific dashboard
     */
    private function customerDashboard()
    {
        $userId = auth()->id();
        $user = auth()->user();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Get customer's company record using the company_id from users table
        $company = null;
        $companyId = $user->company_id;
        
        // Auto-link user to company if not linked yet
        if (!$companyId && DB::getSchemaBuilder()->hasTable('companies')) {
            try {
                // Try to find company by exact email match
                $matchingCompany = DB::table('companies')
                    ->where('company_email', $user->email)
                    ->first();
                
                if ($matchingCompany) {
                    // Auto-link the user
                    DB::table('users')->where('id', $userId)->update(['company_id' => $matchingCompany->id]);
                    $companyId = $matchingCompany->id;
                    $company = $matchingCompany;
                    
                    // Log the auto-linking
                    \Log::info("Auto-linked user {$userId} ({$user->email}) to company {$matchingCompany->id} ({$matchingCompany->company_name})");
                }
            } catch (\Exception $e) {
                \Log::error("Failed to auto-link user {$userId}: " . $e->getMessage());
            }
        }
        
        try {
            if ($companyId && DB::getSchemaBuilder()->hasTable('companies')) {
                $company = DB::table('companies')->where('id', $companyId)->first();
            }
        } catch (\Exception $e) {
            $company = null;
            $companyId = null;
        }

        // Customer KPIs
        $totalQuotations = 0;
        $pendingQuotations = 0;
        $totalInvoices = 0;
        $pendingPayments = 0;
        $totalProjects = 0;
        $activeProjects = 0;
        $openTickets = 0;
        $totalSpent = 0;

        // Quotations
        try {
            if (DB::getSchemaBuilder()->hasTable('quotations') && $companyId) {
                $totalQuotations = DB::table('quotations')
                    ->where('customer_id', $companyId)
                    ->count();
                
                $pendingQuotations = DB::table('quotations')
                    ->where('customer_id', $companyId)
                    ->whereIn('status', ['pending', 'sent'])
                    ->count();
            }
        } catch (\Exception $e) {}

        // Invoices (using company_name as text match)
        try {
            if (DB::getSchemaBuilder()->hasTable('invoices') && $company) {
                $totalInvoices = DB::table('invoices')
                    ->where('company_name', $company->company_name)
                    ->count();
                
                // Note: invoices table doesn't have status column, so we count all
                $pendingPayments = DB::table('invoices')
                    ->where('company_name', $company->company_name)
                    ->whereRaw('paid_amount < final_amount')
                    ->count();
                
                $totalSpent = DB::table('invoices')
                    ->where('company_name', $company->company_name)
                    ->sum('paid_amount');
            }
        } catch (\Exception $e) {}

        // Projects
        try {
            if (DB::getSchemaBuilder()->hasTable('projects') && $companyId) {
                $totalProjects = DB::table('projects')
                    ->where('company_id', $companyId)
                    ->count();
                
                $activeProjects = DB::table('projects')
                    ->where('company_id', $companyId)
                    ->whereIn('status', ['active', 'in_progress'])
                    ->count();
            }
        } catch (\Exception $e) {}

        // Tickets
        if ($companyId) {
            $openTickets = Ticket::where('company_id', $companyId)
                ->whereIn('status', ['open', 'pending', 'in_progress'])
                ->count();
        } else {
            $openTickets = Ticket::where('customer', $company->name ?? auth()->user()->name)
                ->whereIn('status', ['open', 'pending', 'in_progress'])
                ->count();
        }

        $stats = [
            'total_quotations' => $totalQuotations,
            'pending_quotations' => $pendingQuotations,
            'total_invoices' => $totalInvoices,
            'pending_payments' => $pendingPayments,
            'total_projects' => $totalProjects,
            'active_projects' => $activeProjects,
            'open_tickets' => $openTickets,
            'total_spent' => number_format($totalSpent, 2),
        ];

        // Recent Quotations
        $recentQuotations = collect([]);
        try {
            if (DB::getSchemaBuilder()->hasTable('quotations') && $companyId) {
                $recentQuotations = DB::table('quotations')
                    ->where('customer_id', $companyId)
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function($quot) {
                        return [
                            'id' => $quot->id,
                            'number' => $quot->quotation_number ?? 'Q-' . $quot->id,
                            'amount' => number_format($quot->total_amount ?? 0, 2),
                            'status' => $quot->status ?? 'pending',
                            'date' => isset($quot->created_at) ? Carbon::parse($quot->created_at)->format('M d, Y') : 'N/A',
                            'valid_until' => isset($quot->valid_until) ? Carbon::parse($quot->valid_until)->format('M d, Y') : 'N/A'
                        ];
                    });
            }
        } catch (\Exception $e) {}

        // Recent Invoices (using company_name)
        $recentInvoices = collect([]);
        try {
            if (DB::getSchemaBuilder()->hasTable('invoices') && $company) {
                $recentInvoices = DB::table('invoices')
                    ->where('company_name', $company->company_name)
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function($inv) {
                        $isPaid = isset($inv->paid_amount) && isset($inv->final_amount) && $inv->paid_amount >= $inv->final_amount;
                        $status = $isPaid ? 'paid' : 'pending';
                        
                        return [
                            'id' => $inv->id,
                            'number' => $inv->unique_code ?? 'INV-' . $inv->id,
                            'amount' => number_format($inv->final_amount ?? 0, 2),
                            'status' => $status,
                            'date' => isset($inv->created_at) ? Carbon::parse($inv->created_at)->format('M d, Y') : 'N/A',
                            'due_date' => isset($inv->invoice_date) ? Carbon::parse($inv->invoice_date)->format('M d, Y') : 'N/A'
                        ];
                    });
            }
        } catch (\Exception $e) {}

        // Active Projects
        $activeProjectsList = collect([]);
        try {
            if (DB::getSchemaBuilder()->hasTable('projects')) {
                // If we have a company ID, filter by it; otherwise show all projects for customer users
                $query = DB::table('projects')
                    ->whereIn('status', ['active', 'in_progress'])
                    ->orderBy('created_at', 'desc')
                    ->limit(4);
                
                // Only filter by company if we found one
                if ($companyId) {
                    $query->where('company_id', $companyId);
                }
                
                $projects = $query->get();
                
                $activeProjectsList = $projects->map(function($proj) {
                    // Calculate progress based on dates if progress column doesn't exist
                    $progress = 0;
                    if (isset($proj->start_date) && isset($proj->end_date)) {
                        try {
                            $start = Carbon::parse($proj->start_date);
                            $end = Carbon::parse($proj->end_date);
                            $now = Carbon::now();
                            
                            if ($now->greaterThan($end)) {
                                $progress = 100;
                            } elseif ($now->lessThan($start)) {
                                $progress = 0;
                            } else {
                                $totalDays = $start->diffInDays($end);
                                $elapsedDays = $start->diffInDays($now);
                                $progress = $totalDays > 0 ? round(($elapsedDays / $totalDays) * 100) : 0;
                            }
                        } catch (\Exception $e) {
                            $progress = 50; // Default progress if date calculation fails
                        }
                    }
                    
                    return [
                        'id' => $proj->id,
                        'name' => $proj->name ?? 'Untitled Project',
                        'status' => $proj->status ?? 'active',
                        'progress' => $progress,
                        'start_date' => isset($proj->start_date) ? Carbon::parse($proj->start_date)->format('M d, Y') : 'N/A',
                        'end_date' => isset($proj->end_date) ? Carbon::parse($proj->end_date)->format('M d, Y') : 'N/A'
                    ];
                });
            }
        } catch (\Exception $e) {
            // Keep empty collection
        }

        // Recent Tickets
        $ticketsQuery = Ticket::query();
        if ($companyId) {
            $ticketsQuery->where('company_id', $companyId);
        } else {
            $ticketsQuery->where('customer', $company->name ?? auth()->user()->name);
        }
        
        $recentTickets = $ticketsQuery->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($ticket) {
                return [
                    'id' => $ticket->id,
                    'title' => $ticket->title ?? $ticket->subject ?? 'Untitled',
                    'status' => $ticket->status ?? 'open',
                    'priority' => $ticket->priority ?? 'normal',
                    'created' => $ticket->created_at->format('M d, Y')
                ];
            });

        return view('dashboard-customer', compact('stats', 'recentQuotations', 'recentInvoices', 'activeProjectsList', 'recentTickets', 'company'));
    }
}
