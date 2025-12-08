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

        // ========== NOTIFICATIONS - LATEST 5 TICKETS & INQUIRIES ==========
        $notifications = [];
        
        // Get latest 5 tickets (newest first)
        $latestTickets = Ticket::orderBy('created_at', 'desc')->limit(5)->get();
        foreach ($latestTickets as $ticket) {
            $notifications[] = [
                'id' => 'ticket_' . $ticket->id,
                'type' => 'ticket',
                'icon' => '🎫',
                'title' => 'New Ticket: ' . ($ticket->title ?? $ticket->subject ?? 'Untitled'),
                'subtitle' => $ticket->customer ?? 'Customer',
                'time' => Carbon::parse($ticket->created_at)->diffForHumans(),
                'timestamp' => $ticket->created_at->timestamp,
                'link' => route('tickets.show', $ticket->id),
            ];
        }
        
        // Get latest 5 inquiries (newest first)
        try {
            if (DB::getSchemaBuilder()->hasTable('inquiries')) {
                $latestInquiries = DB::table('inquiries')
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
                
                foreach ($latestInquiries as $inquiry) {
                    $notifications[] = [
                        'id' => 'inquiry_' . $inquiry->id,
                        'type' => 'inquiry',
                        'icon' => '📋',
                        'title' => 'New Inquiry: ' . ($inquiry->company_name ?? 'Unknown Company'),
                        'subtitle' => $inquiry->contact_name ?? 'Contact',
                        'time' => isset($inquiry->created_at) ? Carbon::parse($inquiry->created_at)->diffForHumans() : 'Recently',
                        'timestamp' => isset($inquiry->created_at) ? Carbon::parse($inquiry->created_at)->timestamp : 0,
                        'link' => route('inquiries.show', $inquiry->id),
                    ];
                }
            }
        } catch (\Exception $e) {
            // Ignore if inquiries table doesn't exist
        }
        
        // Sort all notifications by timestamp (newest first) and take only 5
        usort($notifications, function($a, $b) {
            return ($b['timestamp'] ?? 0) - ($a['timestamp'] ?? 0);
        });
        $notifications = array_slice($notifications, 0, 5);

        // ========== RECENT INQUIRIES - DYNAMIC ==========
        $recentInquiries = [];
        try {
            if (DB::getSchemaBuilder()->hasTable('inquiries')) {
                // Get inquiries with their latest follow-up data
                $inquiries = DB::table('inquiries')
                    ->leftJoin('inquiry_follow_ups', function($join) {
                        $join->on('inquiries.id', '=', 'inquiry_follow_ups.inquiry_id')
                             ->whereRaw('inquiry_follow_ups.id = (SELECT MAX(id) FROM inquiry_follow_ups WHERE inquiry_id = inquiries.id)');
                    })
                    ->select('inquiries.*', 
                             'inquiry_follow_ups.next_followup_date',
                             'inquiry_follow_ups.demo_date',
                             'inquiry_follow_ups.demo_time',
                             'inquiry_follow_ups.demo_status',
                             'inquiry_follow_ups.is_confirm')
                    ->orderBy('inquiries.created_at', 'desc')
                    ->limit(6)
                    ->get();
                
                foreach ($inquiries as $inq) {
                    // Determine demo status
                    $demoStatus = $inq->demo_status ?? ($inq->quotation_sent ? 'Quotation Sent' : 'Pending');
                    
                    // Check if confirmed from follow-up
                    $isConfirm = !empty($inq->is_confirm) ? 'YES' : 'NO';
                    
                    // Format demo date and time
                    $demoDateTime = '—';
                    if (!empty($inq->demo_date)) {
                        $demoDateTime = Carbon::parse($inq->demo_date)->format('M d, Y');
                        if (!empty($inq->demo_time)) {
                            $demoDateTime .= ' | ' . Carbon::parse($inq->demo_time)->format('h:i A');
                        }
                    }
                    
                    $recentInquiries[] = [
                        'id' => $inq->id,
                        'company' => $inq->company_name ?? 'N/A',
                        'person' => $inq->contact_name ?? '—',
                        'phone' => $inq->contact_mobile ?? $inq->company_phone ?? '—',
                        'date' => isset($inq->inquiry_date) ? Carbon::parse($inq->inquiry_date)->format('M d') : (isset($inq->created_at) ? Carbon::parse($inq->created_at)->format('M d') : '—'),
                        'next' => !empty($inq->next_followup_date) ? Carbon::parse($inq->next_followup_date)->format('M d') : '—',
                        'status' => ucfirst($demoStatus),
                        'demo' => $demoDateTime,
                        'is_confirm' => $isConfirm,
                    ];
                }
            }
        } catch (\Exception $e) {
            // Table doesn't exist or query error - leave empty
            \Log::error('Dashboard inquiries error: ' . $e->getMessage());
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

        // ========== AMC RENEWAL WARNINGS - FOR ADMIN DASHBOARD ==========
        $amcWarnings = [];
        try {
            if (DB::getSchemaBuilder()->hasTable('quotations')) {
                // Get all quotations with AMC that are expiring or expired within 15 days
                $quotationsWithAMC = DB::table('quotations')
                    ->whereNotNull('amc_start_date')
                    ->select('id', 'unique_code', 'company_name', 'amc_start_date', 'amc_amount')
                    ->get();
                
                foreach ($quotationsWithAMC as $quot) {
                    $amcStartDate = Carbon::parse($quot->amc_start_date);
                    $amcEndDate = $amcStartDate->copy()->addDays(365);
                    $daysUntilExpiry = now()->diffInDays($amcEndDate, false);
                    
                    // Only show if expiring within 15 days or already expired
                    if ($daysUntilExpiry <= 15) {
                        $amcWarnings[] = [
                            'id' => $quot->id,
                            'quotation_number' => $quot->unique_code ?? 'Q-' . $quot->id,
                            'company_name' => $quot->company_name,
                            'amc_start' => $amcStartDate->format('M d, Y'),
                            'amc_end' => $amcEndDate->format('M d, Y'),
                            'amc_amount' => $quot->amc_amount ?? 0,
                            'days_until_expiry' => (int)$daysUntilExpiry,
                            'is_expired' => $daysUntilExpiry < 0,
                            'status' => $daysUntilExpiry < 0 ? 'expired' : 'expiring'
                        ];
                    }
                }
                
                // Sort: EXPIRING first (by urgency), then EXPIRED
                usort($amcWarnings, function($a, $b) {
                    // If one is expiring and other is expired, expiring comes first
                    if (!$a['is_expired'] && $b['is_expired']) {
                        return -1; // a (expiring) comes before b (expired)
                    }
                    if ($a['is_expired'] && !$b['is_expired']) {
                        return 1; // b (expiring) comes before a (expired)
                    }
                    
                    // If both are same type, sort by days (most urgent first)
                    if (!$a['is_expired'] && !$b['is_expired']) {
                        // Both expiring: smaller days first (more urgent)
                        return $a['days_until_expiry'] - $b['days_until_expiry'];
                    } else {
                        // Both expired: more recently expired first (less negative)
                        return $b['days_until_expiry'] - $a['days_until_expiry'];
                    }
                });
            }
        } catch (\Exception $e) {
            \Log::error('Admin AMC Warnings Error: ' . $e->getMessage());
        }

        return view('dashboard', compact('stats', 'notifications', 'recentInquiries', 'recentTickets', 'users', 'notes', 'companyData', 'amcWarnings'));
    }

    /**
     * Employee-specific dashboard
     */
    private function employeeDashboard()
    {
        $employee = Employee::where('user_id', auth()->id())->first();
        
        if (!$employee) {
            // If no employee record, show basic message with default stats
            return view('dashboard-employee', [
                'employee' => null,
                'stats' => [
                    'present_days' => '00',
                    'absent_days' => '00',
                    'working_hours' => 0,
                    'active_projects' => '00',
                    'late_entries' => '00',
                    'early_exits' => '00',
                ],
                'birthdays' => [],
                'notes' => [],
                'todayBirthdays' => [],
                'upcomingBirthdays' => [],
                'todayLeaves' => [],
                'attendanceCalendar' => [],
                'leavesCalendar' => [],
                'birthdaysCalendar' => [],
                'anniversariesCalendar' => [],
                'pendingLeavesCalendar' => [],
                'rejectedLeavesCalendar' => [],
                'systemNotes' => [],
                'empNotes' => [],
                'notesPage' => 1,
                'empNotesPage' => 1,
                'systemNotesTotalPages' => 1,
                'empNotesTotalPages' => 1,
                'allEmployees' => []
            ]);
        }

        // Get current month attendance stats for this employee
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $attendances = Attendance::where('employee_id', $employee->id)
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->get();

        // Calculate stats - count UNIQUE dates since employee can check in/out multiple times per day
        // Present days = unique dates where employee has at least one attendance entry
        $presentDays = $attendances->pluck('date')->unique()->count();
        
        // Absent days calculation (optional - based on working days minus present)
        $absentDays = $attendances->where('status', 'absent')->pluck('date')->unique()->count();
        
        // Working hours - sum all durations from all entries
        $workingHours = $attendances->sum(function($att) {
            if ($att->check_in && $att->check_out) {
                $checkIn = Carbon::parse($att->check_in);
                $checkOut = Carbon::parse($att->check_out);
                return $checkIn->diffInMinutes($checkOut) / 60; // Return hours with decimals
            }
            return 0;
        });
        
        // Late entries - count unique dates with late status (first entry of day was late)
        $lateEntries = $attendances->where('status', 'late')->pluck('date')->unique()->count();
        
        // Early exits - count unique dates with early_leave status
        $earlyExits = $attendances->where('status', 'early_leave')->pluck('date')->unique()->count();

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
            'working_hours' => round($workingHours, 1), // Pass raw number for formatting in view
            'active_projects' => str_pad($activeProjects, 2, '0', STR_PAD_LEFT),
            'late_entries' => str_pad($lateEntries, 2, '0', STR_PAD_LEFT),
            'early_exits' => str_pad($earlyExits, 2, '0', STR_PAD_LEFT),
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

        // Get ALL system notes (no pagination - using horizontal scroll)
        $systemNotes = [];
        $notesPage = 1;
        $empNotesPage = 1;
        $systemNotesTotalPages = 1;
        
        try {
            if (DB::getSchemaBuilder()->hasTable('notes')) {
                $systemNotesData = DB::table('notes')
                    ->where('type', 'system')
                    ->where(function($query) use ($employee) {
                        $query->where('user_id', auth()->id())
                              ->orWhere('employee_id', $employee->id)
                              ->orWhereNull('user_id');
                    })
                    ->orderBy('created_at', 'desc')
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

        // Get ALL employee notes (no pagination - using horizontal scroll)
        $empNotes = [];
        $empNotesTotalPages = 1;
        
        try {
            if (DB::getSchemaBuilder()->hasTable('notes')) {
                // Get ALL employee-type notes assigned to THIS employee
                // Check both employee_id AND if employee name is in assignees JSON
                $empNotesData = DB::table('notes')
                    ->where('type', 'employee')
                    ->where(function($query) use ($employee) {
                        $query->where('employee_id', $employee->id)
                              ->orWhereRaw("JSON_CONTAINS(assignees, JSON_QUOTE(?), '$')", [$employee->name]);
                    })
                    ->orderBy('created_at', 'desc')
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
                    
                    // Check if current user can delete this note (only if they created it)
                    $canDelete = ($note->user_id == auth()->id());
                    
                    $empNotes[] = [
                        'id' => $note->id,
                        'text' => $note->content ?? '',
                        'date' => isset($note->created_at) ? Carbon::parse($note->created_at)->format('M d, Y') : now()->format('M d, Y'),
                        'assignees' => $assignees,
                        'assignee_photos' => $assigneePhotos,
                        'can_delete' => $canDelete
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

        // Get leaves calendar data for current month - ONLY FOR CURRENT EMPLOYEE
        $leavesCalendar = [];
        $monthStart = Carbon::create($currentYear, $currentMonth, 1)->startOfMonth();
        $monthEnd = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth();
        
        // Only get leaves for the current logged-in employee
        $monthLeaves = Leave::where('status', 'approved')
            ->where('employee_id', $employee->id) // Filter by current employee
            ->where(function($query) use ($monthStart, $monthEnd) {
                $query->where('start_date', '<=', $monthEnd)
                      ->where('end_date', '>=', $monthStart);
            })
            ->with('employee')
            ->get();

        foreach ($monthLeaves as $leave) {
            $startDate = Carbon::parse($leave->start_date);
            $endDate = Carbon::parse($leave->end_date);
            
            // Mark all days in the leave period within this month
            $loopDate = $startDate->copy();
            while ($loopDate->lte($endDate)) {
                if ($loopDate->month == $currentMonth && $loopDate->year == $currentYear) {
                    $day = $loopDate->day;
                    if (!isset($leavesCalendar[$day])) {
                        $leavesCalendar[$day] = [];
                    }
                    $leavesCalendar[$day][] = [
                        'name' => $leave->employee->name ?? 'You',
                        'type' => ucfirst($leave->leave_type ?? 'Leave')
                    ];
                }
                $loopDate->addDay();
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

        // Get work anniversaries for current month
        $anniversariesCalendar = [];
        $anniversaryEmployees = Employee::whereMonth('joining_date', $currentMonth)
            ->whereNotNull('joining_date')
            ->where('joining_date', '<', now()) // Only past joining dates
            ->get();
        
        foreach ($anniversaryEmployees as $emp) {
            $joiningDate = Carbon::parse($emp->joining_date);
            $yearsWorked = $joiningDate->diffInYears(now());
            
            // Only show if at least 1 year
            if ($yearsWorked >= 1) {
                $day = $joiningDate->day;
                if (!isset($anniversariesCalendar[$day])) {
                    $anniversariesCalendar[$day] = [];
                }
                $anniversariesCalendar[$day][] = [
                    'name' => $emp->name,
                    'years' => $yearsWorked,
                    'photo' => $emp->photo_path ? asset('storage/' . $emp->photo_path) : asset('new_theme/dist/img/avatar.png')
                ];
            }
        }

        // Get pending leaves for current month - ONLY FOR CURRENT EMPLOYEE
        $pendingLeavesCalendar = [];
        $pendingLeaves = Leave::where('status', 'pending')
            ->where('employee_id', $employee->id) // Filter by current employee
            ->where(function($query) use ($monthStart, $monthEnd) {
                $query->where('start_date', '<=', $monthEnd)
                      ->where('end_date', '>=', $monthStart);
            })
            ->with('employee')
            ->get();

        foreach ($pendingLeaves as $leave) {
            $startDate = Carbon::parse($leave->start_date);
            $endDate = Carbon::parse($leave->end_date);
            
            $loopDate = $startDate->copy();
            while ($loopDate->lte($endDate)) {
                if ($loopDate->month == $currentMonth && $loopDate->year == $currentYear) {
                    $day = $loopDate->day;
                    if (!isset($pendingLeavesCalendar[$day])) {
                        $pendingLeavesCalendar[$day] = [];
                    }
                    $pendingLeavesCalendar[$day][] = [
                        'name' => $leave->employee->name ?? 'You',
                        'type' => ucfirst($leave->leave_type ?? 'Leave')
                    ];
                }
                $loopDate->addDay();
            }
        }

        // Get rejected leaves for current month - ONLY FOR CURRENT EMPLOYEE
        $rejectedLeavesCalendar = [];
        $rejectedLeaves = Leave::where('status', 'rejected')
            ->where('employee_id', $employee->id) // Filter by current employee
            ->where(function($query) use ($monthStart, $monthEnd) {
                $query->where('start_date', '<=', $monthEnd)
                      ->where('end_date', '>=', $monthStart);
            })
            ->with('employee')
            ->get();

        foreach ($rejectedLeaves as $leave) {
            $startDate = Carbon::parse($leave->start_date);
            $endDate = Carbon::parse($leave->end_date);
            
            $loopDate = $startDate->copy();
            while ($loopDate->lte($endDate)) {
                if ($loopDate->month == $currentMonth && $loopDate->year == $currentYear) {
                    $day = $loopDate->day;
                    if (!isset($rejectedLeavesCalendar[$day])) {
                        $rejectedLeavesCalendar[$day] = [];
                    }
                    $rejectedLeavesCalendar[$day][] = [
                        'name' => $leave->employee->name ?? 'You',
                        'type' => ucfirst($leave->leave_type ?? 'Leave')
                    ];
                }
                $loopDate->addDay();
            }
        }

        // Get all employees for admin/hr to select when creating notes
        $allEmployees = [];
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr') || auth()->user()->hasRole('super-admin')) {
            $allEmployees = Employee::select('id', 'name')->orderBy('name')->get()->map(function($emp) {
                return [
                    'id' => $emp->id,
                    'name' => $emp->name
                ];
            })->toArray();
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
            'anniversariesCalendar',
            'pendingLeavesCalendar',
            'rejectedLeavesCalendar',
            'systemNotes',
            'empNotes',
            'notesPage',
            'empNotesPage',
            'systemNotesTotalPages',
            'empNotesTotalPages',
            'allEmployees'
        ));
    }

    /**
     * Get calendar data for a specific month (AJAX)
     */
    public function getCalendarData(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        
        $employee = Employee::where('user_id', auth()->id())->first();
        
        // Get birthdays for the requested month (all employees)
        $birthdaysCalendar = [];
        $birthdays = Employee::whereMonth('date_of_birth', $month)
            ->orderByRaw('DAY(date_of_birth)')
            ->get();
        
        foreach ($birthdays as $emp) {
            $day = Carbon::parse($emp->date_of_birth)->day;
            if (!isset($birthdaysCalendar[$day])) {
                $birthdaysCalendar[$day] = [];
            }
            $birthdaysCalendar[$day][] = [
                'name' => $emp->name,
                'photo' => $emp->photo_path ? asset('storage/' . $emp->photo_path) : asset('new_theme/dist/img/avatar.png')
            ];
        }
        
        // Get attendance for the requested month (current employee only)
        $attendanceCalendar = [];
        if ($employee) {
            $attendances = Attendance::where('employee_id', $employee->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get();
            
            foreach ($attendances as $att) {
                $day = Carbon::parse($att->date)->day;
                // Only store first entry status for the day (for the dot indicator)
                if (!isset($attendanceCalendar[$day])) {
                    $attendanceCalendar[$day] = $att->status;
                }
            }
        }
        
        // Get leaves for the requested month - ONLY FOR CURRENT EMPLOYEE
        $leavesCalendar = [];
        $monthStart = Carbon::create($year, $month, 1)->startOfMonth();
        $monthEnd = Carbon::create($year, $month, 1)->endOfMonth();
        
        if ($employee) {
            $monthLeaves = Leave::where('status', 'approved')
                ->where('employee_id', $employee->id) // Filter by current employee
                ->where(function($query) use ($monthStart, $monthEnd) {
                    $query->where('start_date', '<=', $monthEnd)
                          ->where('end_date', '>=', $monthStart);
                })
                ->with('employee')
                ->get();

            foreach ($monthLeaves as $leave) {
                $startDate = Carbon::parse($leave->start_date);
                $endDate = Carbon::parse($leave->end_date);
                
                $currentDate = $startDate->copy();
                while ($currentDate->lte($endDate)) {
                    if ($currentDate->month == $month && $currentDate->year == $year) {
                        $day = $currentDate->day;
                        if (!isset($leavesCalendar[$day])) {
                            $leavesCalendar[$day] = [];
                        }
                        $leavesCalendar[$day][] = [
                            'name' => $leave->employee->name ?? 'You',
                            'type' => ucfirst($leave->leave_type ?? 'Leave')
                        ];
                    }
                    $currentDate->addDay();
                }
            }
        }
        
        // Get work anniversaries for the requested month
        $anniversariesCalendar = [];
        $anniversaryEmployees = Employee::whereMonth('joining_date', $month)
            ->whereNotNull('joining_date')
            ->where('joining_date', '<', now())
            ->get();
        
        foreach ($anniversaryEmployees as $emp) {
            $joiningDate = Carbon::parse($emp->joining_date);
            $yearsWorked = $joiningDate->diffInYears(now());
            
            if ($yearsWorked >= 1) {
                $day = $joiningDate->day;
                if (!isset($anniversariesCalendar[$day])) {
                    $anniversariesCalendar[$day] = [];
                }
                $anniversariesCalendar[$day][] = [
                    'name' => $emp->name,
                    'years' => $yearsWorked,
                    'photo' => $emp->photo_path ? asset('storage/' . $emp->photo_path) : asset('new_theme/dist/img/avatar.png')
                ];
            }
        }

        // Get pending leaves for the requested month - ONLY FOR CURRENT EMPLOYEE
        $pendingLeavesCalendar = [];
        if ($employee) {
            $pendingLeaves = Leave::where('status', 'pending')
                ->where('employee_id', $employee->id) // Filter by current employee
                ->where(function($query) use ($monthStart, $monthEnd) {
                    $query->where('start_date', '<=', $monthEnd)
                          ->where('end_date', '>=', $monthStart);
                })
                ->with('employee')
                ->get();

            foreach ($pendingLeaves as $leave) {
                $startDate = Carbon::parse($leave->start_date);
                $endDate = Carbon::parse($leave->end_date);
                
                $currentDate = $startDate->copy();
                while ($currentDate->lte($endDate)) {
                    if ($currentDate->month == $month && $currentDate->year == $year) {
                        $day = $currentDate->day;
                        if (!isset($pendingLeavesCalendar[$day])) {
                            $pendingLeavesCalendar[$day] = [];
                        }
                        $pendingLeavesCalendar[$day][] = [
                            'name' => $leave->employee->name ?? 'You',
                            'type' => ucfirst($leave->leave_type ?? 'Leave')
                        ];
                    }
                    $currentDate->addDay();
                }
            }
        }

        // Get rejected leaves for the requested month - ONLY FOR CURRENT EMPLOYEE
        $rejectedLeavesCalendar = [];
        if ($employee) {
            $rejectedLeaves = Leave::where('status', 'rejected')
                ->where('employee_id', $employee->id) // Filter by current employee
                ->where(function($query) use ($monthStart, $monthEnd) {
                    $query->where('start_date', '<=', $monthEnd)
                          ->where('end_date', '>=', $monthStart);
                })
                ->with('employee')
                ->get();

            foreach ($rejectedLeaves as $leave) {
                $startDate = Carbon::parse($leave->start_date);
                $endDate = Carbon::parse($leave->end_date);
                
                $currentDate = $startDate->copy();
                while ($currentDate->lte($endDate)) {
                    if ($currentDate->month == $month && $currentDate->year == $year) {
                        $day = $currentDate->day;
                        if (!isset($rejectedLeavesCalendar[$day])) {
                            $rejectedLeavesCalendar[$day] = [];
                        }
                        $rejectedLeavesCalendar[$day][] = [
                            'name' => $leave->employee->name ?? 'You',
                            'type' => ucfirst($leave->leave_type ?? 'Leave')
                        ];
                    }
                    $currentDate->addDay();
                }
            }
        }
        
        return response()->json([
            'success' => true,
            'attendance' => $attendanceCalendar,
            'leaves' => $leavesCalendar,
            'birthdays' => $birthdaysCalendar,
            'anniversaries' => $anniversariesCalendar,
            'pendingLeaves' => $pendingLeavesCalendar,
            'rejectedLeaves' => $rejectedLeavesCalendar,
            'month' => $month,
            'year' => $year
        ]);
    }

    /**
     * Store a new note for employee (AJAX)
     */
    public function storeNote(Request $request)
    {
        $request->validate([
            'note_text' => 'required|string|max:10000',
            'note_type' => 'required|in:notes,empNotes',
            'employee_id' => 'nullable|exists:employees,id'
        ]);

        try {
            // Ensure notes table exists
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
                        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
                        FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE SET NULL,
                        INDEX (employee_id),
                        INDEX (user_id),
                        INDEX (type),
                        INDEX (created_at)
                    )
                ");
            }

            // Get current user's employee record
            $currentUserEmployee = Employee::where('user_id', auth()->id())->first();

            // Determine note type
            $noteType = $request->note_type === 'notes' ? 'system' : 'employee';

            // For employee notes, use the selected employee_id or current user's employee
            $targetEmployeeId = null;
            if ($noteType === 'employee') {
                // If admin is creating note for specific employee
                if ($request->has('employee_id') && $request->employee_id) {
                    $targetEmployeeId = $request->employee_id;
                } else {
                    // If employee is creating their own note
                    $targetEmployeeId = $currentUserEmployee ? $currentUserEmployee->id : null;
                }
            }

            // Insert note
            $noteId = DB::table('notes')->insertGetId([
                'user_id' => auth()->id(),
                'employee_id' => $targetEmployeeId,
                'type' => $noteType,
                'content' => $request->note_text,
                'assignees' => json_encode([auth()->user()->name]),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Return JSON response for AJAX
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Note saved successfully!',
                    'note' => [
                        'id' => $noteId,
                        'text' => $request->note_text,
                        'date' => now()->format('M d, Y g:i A'),
                        'assignees' => [auth()->user()->name]
                    ]
                ], 201);
            }

            return redirect()->back()->with('success', 'Note added successfully!');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add note: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Failed to add note: ' . $e->getMessage());
        }
    }

    /**
     * Get notes for current user (AJAX)
     */
    public function getNotes(Request $request)
    {
        $page = $request->get('page', 1);
        $type = $request->get('type', 'system'); // 'system' or 'employee'
        $perPage = $request->get('limit', 100); // Show all notes (default 100, can be overridden)

        try {
            if (!DB::getSchemaBuilder()->hasTable('notes')) {
                return response()->json([
                    'success' => true,
                    'notes' => [],
                    'total' => 0,
                    'pages' => 0
                ]);
            }

            // Get current user's employee record
            $currentUserEmployee = Employee::where('user_id', auth()->id())->first();

            // Build query based on user role and note type
            $query = DB::table('notes')->where('type', $type);

            // If employee is viewing, only show notes assigned to them
            if (auth()->user()->hasRole('employee') && $type === 'employee') {
                if ($currentUserEmployee) {
                    // Show notes where employee name is in assignees JSON OR employee_id matches
                    $query->where(function($q) use ($currentUserEmployee) {
                        $q->whereRaw("JSON_CONTAINS(assignees, JSON_QUOTE(?), '$')", [$currentUserEmployee->name])
                          ->orWhere('employee_id', $currentUserEmployee->id);
                    });
                } else {
                    // No employee record, show no notes
                    return response()->json([
                        'success' => true,
                        'notes' => [],
                        'total' => 0,
                        'pages' => 0,
                        'currentPage' => $page
                    ]);
                }
            }
            // If admin/hr is viewing, show all notes of that type
            // (they can see all employee notes)
            // For admin, we want to show DISTINCT notes (not duplicates)

            $total = $query->count();
            $totalPages = ceil($total / $perPage);

            $notes = $query->orderBy('created_at', 'desc')
                ->skip(($page - 1) * $perPage)
                ->take($perPage)
                ->get();

            $formattedNotes = $notes->map(function($note) {
                // Get sender name from user_id
                $senderName = 'Unknown';
                if ($note->user_id) {
                    $sender = User::find($note->user_id);
                    if ($sender) {
                        $senderName = $sender->name;
                    }
                }
                
                return [
                    'id' => $note->id,
                    'text' => $note->content,
                    'date' => Carbon::parse($note->created_at)->format('M d, Y g:i A'),
                    'assignees' => json_decode($note->assignees, true) ?? [],
                    'sender' => $senderName,
                    'sender_id' => $note->user_id
                ];
            })->toArray();

            return response()->json([
                'success' => true,
                'notes' => $formattedNotes,
                'total' => $total,
                'pages' => $totalPages,
                'currentPage' => $page
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch notes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a note
     */
    public function deleteNote($id)
    {
        try {
            // Only allow deletion by the note creator (admin/user who created it)
            $deleted = DB::table('notes')
                ->where('id', $id)
                ->where('user_id', auth()->id())
                ->delete();

            if ($deleted) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Note deleted successfully!'
                    ]);
                }
                return redirect()->back()->with('success', 'Note deleted successfully!');
            } else {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Note not found or unauthorized.'
                    ], 403);
                }
                return redirect()->back()->with('error', 'Note not found or unauthorized.');
            }
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete note: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Failed to delete note: ' . $e->getMessage());
        }
    }

    /**
     * Store admin note for multiple employees
     */
    public function storeAdminNote(Request $request)
    {
        try {
            $request->validate([
                'text' => 'required|string|max:10000',
                'assignees' => 'required|array|min:1',
                'assignees.*' => 'exists:employees,id'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', array_merge(...array_values($e->errors())))
            ], 422);
        }

        try {
            // Ensure notes table exists
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
                        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
                        FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE SET NULL,
                        INDEX (employee_id),
                        INDEX (user_id),
                        INDEX (type),
                        INDEX (created_at)
                    )
                ");
            }

            // Get employee names for assignees
            $employeeIds = $request->assignees;
            $employeeNames = Employee::whereIn('id', $employeeIds)
                ->pluck('name')
                ->toArray();

            // Create a SINGLE note with all assigned employees
            $noteId = DB::table('notes')->insertGetId([
                'user_id' => auth()->id(),
                'employee_id' => null,  // No single employee - it's for multiple
                'type' => 'employee',
                'content' => $request->text,
                'assignees' => json_encode($employeeNames),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Admin note saved successfully! ' . count($employeeIds) . ' employee(s) will see this on their dashboard.',
                'notes' => [[
                    'id' => $noteId,
                    'text' => $request->text,
                    'assignees' => $employeeNames,
                    'date' => now()->format('M d, Y g:i A')
                ]]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save admin note: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update admin note (admin/super-admin can update any note)
     */
    public function updateAdminNote(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string|max:10000'
        ]);

        try {
            // Check if user is admin/super-admin
            $isAdmin = auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin') || auth()->user()->can('Dashboard.manage dashboard');
            
            $query = DB::table('notes')->where('id', $id);
            
            // If not admin, only allow updating own notes
            if (!$isAdmin) {
                $query->where('user_id', auth()->id());
            }
            
            $updated = $query->update([
                'content' => $request->text,
                'updated_at' => now()
            ]);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Note updated successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Note not found or unauthorized.'
                ], 403);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update note: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete admin note (admin/super-admin can delete any note)
     */
    public function deleteAdminNote($id)
    {
        try {
            // Check if user is admin/super-admin
            $isAdmin = auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin') || auth()->user()->can('Dashboard.manage dashboard');
            
            $query = DB::table('notes')->where('id', $id);
            
            // If not admin, only allow deleting own notes
            if (!$isAdmin) {
                $query->where('user_id', auth()->id());
            }
            
            $deleted = $query->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Note deleted successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Note not found or unauthorized.'
                ], 403);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete note: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update note employees (add/remove)
     */
    public function updateNoteEmployees(Request $request, $id)
    {
        $request->validate([
            'assignees' => 'required|array|min:1',
            'assignees.*' => 'exists:employees,id'
        ]);

        try {
            // Get employee names for assignees
            $employeeIds = $request->assignees;
            $employeeNames = Employee::whereIn('id', $employeeIds)
                ->pluck('name')
                ->toArray();

            // Get the current note content
            $currentNote = DB::table('notes')->where('id', $id)->first();
            if (!$currentNote) {
                return response()->json([
                    'success' => false,
                    'message' => 'Note not found'
                ], 404);
            }

            // Update the note with new assignees (single update, not duplicates)
            DB::table('notes')->where('id', $id)->update([
                'assignees' => json_encode($employeeNames),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Note employees updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update note employees: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * HR-specific dashboard
     */
    private function hrDashboard()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $today = now()->toDateString();

        // ========== CORE HR KPIs ==========
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('status', 'active')->count();
        $onLeaveToday = Leave::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->where('status', 'approved')
            ->count();
        
        $pendingLeaves = Leave::where('status', 'pending')->count();
        
        // Attendance today
        $presentToday = Attendance::whereDate('date', $today)
            ->whereIn('status', ['present', 'late', 'early_leave'])
            ->count();
        $absentToday = max(0, $totalEmployees - $presentToday - $onLeaveToday);
        $attendanceRate = $totalEmployees > 0 ? round(($presentToday / $totalEmployees) * 100) : 0;

        // New hires this month
        $newHires = Employee::whereYear('joining_date', $currentYear)
            ->whereMonth('joining_date', $currentMonth)
            ->count();

        // ========== ADDITIONAL HR METRICS ==========
        
        // Open Tickets count
        $openTickets = Ticket::whereIn('status', ['open', 'pending', 'in_progress'])->count();
        
        // Total Projects
        $totalProjects = 0;
        $activeProjects = 0;
        try {
            if (DB::getSchemaBuilder()->hasTable('projects')) {
                $totalProjects = DB::table('projects')->count();
                $activeProjects = DB::table('projects')->whereIn('status', ['active', 'in_progress'])->count();
            }
        } catch (\Exception $e) {}

        // Payroll this month
        $monthlyPayroll = 0;
        $paidEmployees = 0;
        try {
            if (DB::getSchemaBuilder()->hasTable('payrolls')) {
                $payrollData = DB::table('payrolls')
                    ->where('month', $currentMonth)
                    ->where('year', $currentYear)
                    ->selectRaw('SUM(net_salary) as total, COUNT(*) as count')
                    ->first();
                $monthlyPayroll = $payrollData->total ?? 0;
                $paidEmployees = $payrollData->count ?? 0;
            }
        } catch (\Exception $e) {}

        // Late arrivals today
        $lateToday = Attendance::whereDate('date', $today)->where('status', 'late')->count();

        // Inquiries this month
        $monthlyInquiries = 0;
        try {
            if (DB::getSchemaBuilder()->hasTable('inquiries')) {
                $monthlyInquiries = DB::table('inquiries')
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $currentMonth)
                    ->count();
            }
        } catch (\Exception $e) {}

        $stats = [
            'total_employees' => $totalEmployees,
            'active_employees' => $activeEmployees,
            'on_leave_today' => $onLeaveToday,
            'pending_leaves' => $pendingLeaves,
            'present_today' => $presentToday,
            'absent_today' => $absentToday,
            'attendance_rate' => $attendanceRate,
            'new_hires' => $newHires,
            'open_tickets' => $openTickets,
            'total_projects' => $totalProjects,
            'active_projects' => $activeProjects,
            'monthly_payroll' => $monthlyPayroll,
            'paid_employees' => $paidEmployees,
            'late_today' => $lateToday,
            'monthly_inquiries' => $monthlyInquiries,
        ];

        // ========== PENDING LEAVE REQUESTS (for approval) ==========
        $pendingLeaveRequests = Leave::with('employee')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($leave) {
                return [
                    'id' => $leave->id,
                    'employee' => $leave->employee->name ?? 'Unknown',
                    'employee_id' => $leave->employee_id,
                    'photo' => $leave->employee && $leave->employee->photo_path 
                        ? asset('storage/' . $leave->employee->photo_path) 
                        : asset('new_theme/dist/img/avatar.png'),
                    'type' => ucfirst($leave->leave_type ?? 'Leave'),
                    'from' => Carbon::parse($leave->start_date)->format('M d'),
                    'to' => Carbon::parse($leave->end_date)->format('M d'),
                    'from_full' => Carbon::parse($leave->start_date)->format('M d, Y'),
                    'to_full' => Carbon::parse($leave->end_date)->format('M d, Y'),
                    'days' => Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date)) + 1,
                    'status' => $leave->status,
                    'reason' => $leave->reason ?? 'No reason provided',
                    'created_at' => Carbon::parse($leave->created_at)->diffForHumans()
                ];
            });
        
        // ========== RECENT LEAVE HISTORY (approved/rejected) ==========
        $recentLeaves = Leave::with('employee')
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($leave) {
                return [
                    'id' => $leave->id,
                    'employee' => $leave->employee->name ?? 'Unknown',
                    'photo' => $leave->employee && $leave->employee->photo_path 
                        ? asset('storage/' . $leave->employee->photo_path) 
                        : asset('new_theme/dist/img/avatar.png'),
                    'type' => ucfirst($leave->leave_type ?? 'Leave'),
                    'from' => Carbon::parse($leave->start_date)->format('M d'),
                    'to' => Carbon::parse($leave->end_date)->format('M d'),
                    'days' => Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date)) + 1,
                    'status' => $leave->status,
                    'reason' => $leave->reason ?? 'No reason provided'
                ];
            });

        // ========== UPCOMING BIRTHDAYS (next 30 days) ==========
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
                    'position' => $emp->position ?? 'Employee',
                    'date' => $nextBirthday->format('M d'),
                    'days_until' => now()->diffInDays($nextBirthday),
                    'photo' => $emp->photo_path ? asset('storage/' . $emp->photo_path) : asset('new_theme/dist/img/avatar.png')
                ];
            });

        // ========== WORK ANNIVERSARIES THIS MONTH ==========
        $workAnniversaries = Employee::whereMonth('joining_date', $currentMonth)
            ->whereNotNull('joining_date')
            ->where('joining_date', '<', now())
            ->get()
            ->map(function($emp) {
                $joiningDate = Carbon::parse($emp->joining_date);
                $yearsWorked = $joiningDate->diffInYears(now());
                return [
                    'name' => $emp->name,
                    'position' => $emp->position ?? 'Employee',
                    'years' => $yearsWorked,
                    'date' => $joiningDate->format('M d'),
                    'photo' => $emp->photo_path ? asset('storage/' . $emp->photo_path) : asset('new_theme/dist/img/avatar.png')
                ];
            })
            ->filter(fn($emp) => $emp['years'] >= 1)
            ->take(5);

        // ========== DEPARTMENT STATS ==========
        $departmentStats = collect([]);
        try {
            if (DB::getSchemaBuilder()->hasColumn('employees', 'department')) {
                $departmentStats = Employee::select('department', DB::raw('count(*) as count'))
                    ->whereNotNull('department')
                    ->groupBy('department')
                    ->orderByDesc('count')
                    ->limit(5)
                    ->get();
            }
        } catch (\Exception $e) {}

        // If no department data, use position-based stats
        if ($departmentStats->isEmpty()) {
            $departmentStats = Employee::select('position as department', DB::raw('count(*) as count'))
                ->whereNotNull('position')
                ->groupBy('position')
                ->orderByDesc('count')
                ->limit(5)
                ->get();
        }

        // ========== ATTENDANCE TRENDS (last 7 days) ==========
        $attendanceTrends = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $present = Attendance::whereDate('date', $date)
                ->whereIn('status', ['present', 'late', 'early_leave'])
                ->count();
            $attendanceTrends[] = [
                'date' => $date->format('D'),
                'full_date' => $date->format('M d'),
                'count' => $present,
                'percentage' => $totalEmployees > 0 ? round(($present / $totalEmployees) * 100) : 0
            ];
        }

        // ========== RECENT TICKETS ==========
        $recentTickets = Ticket::with('assignedEmployee')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($ticket) {
                return [
                    'id' => $ticket->id,
                    'ticket_no' => $ticket->ticket_no ?? '#' . $ticket->id,
                    'subject' => $ticket->subject ?? $ticket->title ?? 'No Subject',
                    'customer' => $ticket->customer ?? 'N/A',
                    'status' => $ticket->status ?? 'open',
                    'priority' => $ticket->priority ?? 'normal',
                    'assigned_to' => $ticket->assignedEmployee->name ?? 'Unassigned',
                    'created_at' => Carbon::parse($ticket->created_at)->diffForHumans()
                ];
            });

        // ========== ACTIVE PROJECTS ==========
        $projectsList = collect([]);
        try {
            if (DB::getSchemaBuilder()->hasTable('projects')) {
                $projectsList = DB::table('projects')
                    ->leftJoin('companies', 'projects.company_id', '=', 'companies.id')
                    ->select('projects.*', 'companies.name as company_name')
                    ->whereIn('projects.status', ['active', 'in_progress'])
                    ->orderBy('projects.due_date', 'asc')
                    ->limit(5)
                    ->get()
                    ->map(function($project) {
                        $progress = $project->total_tasks > 0 
                            ? round(($project->completed_tasks / $project->total_tasks) * 100) 
                            : 0;
                        return [
                            'id' => $project->id,
                            'name' => $project->name,
                            'company' => $project->company_name ?? 'N/A',
                            'status' => $project->status,
                            'priority' => $project->priority ?? 'normal',
                            'progress' => $progress,
                            'due_date' => $project->due_date ? Carbon::parse($project->due_date)->format('M d, Y') : 'No deadline',
                            'is_overdue' => $project->due_date && Carbon::parse($project->due_date)->isPast()
                        ];
                    });
            }
        } catch (\Exception $e) {}

        // ========== MONTHLY HIRING TREND (last 6 months) ==========
        $hiringTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = Employee::whereYear('joining_date', $month->year)
                ->whereMonth('joining_date', $month->month)
                ->count();
            $hiringTrend[] = [
                'month' => $month->format('M'),
                'year' => $month->format('Y'),
                'count' => $count
            ];
        }

        // ========== TODAY'S ATTENDANCE BREAKDOWN ==========
        $attendanceBreakdown = [
            'present' => Attendance::whereDate('date', $today)->where('status', 'present')->count(),
            'late' => Attendance::whereDate('date', $today)->where('status', 'late')->count(),
            'early_leave' => Attendance::whereDate('date', $today)->where('status', 'early_leave')->count(),
            'half_day' => Attendance::whereDate('date', $today)->where('status', 'half_day')->count(),
            'on_leave' => $onLeaveToday,
            'absent' => $absentToday
        ];

        // ========== LEAVE TYPE DISTRIBUTION ==========
        $leaveTypeStats = Leave::select('leave_type', DB::raw('count(*) as count'))
            ->whereYear('created_at', $currentYear)
            ->groupBy('leave_type')
            ->get()
            ->map(function($item) {
                return [
                    'type' => ucfirst($item->leave_type ?? 'Other'),
                    'count' => $item->count
                ];
            });

        // ========== RECENT ACTIVITIES ==========
        $recentActivities = collect([]);
        
        // Get recent leaves
        $recentLeaveActivities = Leave::with('employee')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function($leave) {
                return [
                    'type' => 'leave',
                    'icon' => '🏖️',
                    'title' => ($leave->employee->name ?? 'Employee') . ' requested ' . ucfirst($leave->leave_type ?? 'leave'),
                    'time' => Carbon::parse($leave->created_at)->diffForHumans(),
                    'timestamp' => $leave->created_at
                ];
            });

        // Get recent attendance
        $recentAttendanceActivities = Attendance::with('employee')
            ->whereDate('date', $today)
            ->orderBy('check_in', 'desc')
            ->limit(3)
            ->get()
            ->map(function($att) {
                return [
                    'type' => 'attendance',
                    'icon' => '✅',
                    'title' => ($att->employee->name ?? 'Employee') . ' checked in',
                    'time' => $att->check_in ? Carbon::parse($att->check_in)->format('h:i A') : 'N/A',
                    'timestamp' => $att->check_in ?? $att->created_at
                ];
            });

        // Merge and sort activities
        $recentActivities = $recentLeaveActivities->concat($recentAttendanceActivities)
            ->sortByDesc('timestamp')
            ->take(5)
            ->values();

        return view('dashboard-hr', compact(
            'stats', 
            'pendingLeaveRequests',
            'recentLeaves', 
            'upcomingBirthdays', 
            'workAnniversaries',
            'departmentStats', 
            'attendanceTrends',
            'recentTickets',
            'projectsList',
            'hiringTrend',
            'attendanceBreakdown',
            'leaveTypeStats',
            'recentActivities'
        ));
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

        // Invoices - Only GST invoices for customers (using company_name as text match)
        $totalOutstanding = 0;
        try {
            if (DB::getSchemaBuilder()->hasTable('invoices') && $company) {
                // Count only GST invoices for customers
                $totalInvoices = DB::table('invoices')
                    ->where('company_name', $company->company_name)
                    ->where('invoice_type', 'gst')
                    ->count();
                
                // Count GST invoices with pending payments
                $pendingPayments = DB::table('invoices')
                    ->where('company_name', $company->company_name)
                    ->where('invoice_type', 'gst')
                    ->whereRaw('paid_amount < final_amount')
                    ->count();
                
                // Calculate total outstanding amount from GST invoices only
                $invoices = DB::table('invoices')
                    ->where('company_name', $company->company_name)
                    ->where('invoice_type', 'gst')
                    ->select('final_amount', 'paid_amount')
                    ->get();
                
                foreach ($invoices as $invoice) {
                    $finalAmount = $invoice->final_amount ?? 0;
                    $paidAmount = $invoice->paid_amount ?? 0;
                    $outstanding = $finalAmount - $paidAmount;
                    if ($outstanding > 0) {
                        $totalOutstanding += $outstanding;
                    }
                }
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

        // Tickets - use company name since tickets table doesn't have company_id
        $openTickets = Ticket::where(function($query) use ($company) {
                $query->where('company', $company->company_name ?? '')
                      ->orWhere('customer', $company->name ?? auth()->user()->name);
            })
            ->whereIn('status', ['open', 'pending', 'in_progress'])
            ->count();

        // SIMPLIFIED: Only 4 essential KPIs for clients (no payment info)
        $stats = [
            'total_quotations' => $totalQuotations,
            'total_invoices' => $totalInvoices,
            'active_projects' => $activeProjects,
            'open_tickets' => $openTickets,
        ];

        // Recent Quotations (filtered by company_name)
        $recentQuotations = collect([]);
        try {
            if (DB::getSchemaBuilder()->hasTable('quotations') && $company) {
                $recentQuotations = DB::table('quotations')
                    ->where('company_name', $company->company_name)
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function($quot) {
                        // Get the actual amount from service_contract_amount
                        $amount = $quot->service_contract_amount ?? 0;
                        
                        // Determine status based on follow-ups or default to pending
                        $status = 'pending';
                        if (isset($quot->id)) {
                            $hasConfirmedFollowUp = DB::table('quotation_follow_ups')
                                ->where('quotation_id', $quot->id)
                                ->where('is_confirm', true)
                                ->exists();
                            $status = $hasConfirmedFollowUp ? 'confirmed' : 'pending';
                        }
                        
                        return [
                            'id' => $quot->id,
                            'number' => $quot->unique_code ?? 'Q-' . $quot->id,
                            'amount' => number_format($amount, 2),
                            'status' => $status,
                            'date' => isset($quot->quotation_date) ? Carbon::parse($quot->quotation_date)->format('M d, Y') : (isset($quot->created_at) ? Carbon::parse($quot->created_at)->format('M d, Y') : 'N/A'),
                            'company' => $quot->company_name ?? 'N/A'
                        ];
                    });
            }
        } catch (\Exception $e) {}

        // Recent GST Invoices only (customers see only GST invoices)
        $recentInvoices = collect([]);
        try {
            if (DB::getSchemaBuilder()->hasTable('invoices') && $company) {
                $recentInvoices = DB::table('invoices')
                    ->where('company_name', $company->company_name)
                    ->where('invoice_type', 'gst') // Only GST invoices for customers
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function($inv) {
                        $finalAmount = $inv->final_amount ?? 0;
                        $paidAmount = $inv->paid_amount ?? 0;
                        $isPaid = $paidAmount >= $finalAmount;
                        $status = $isPaid ? 'paid' : 'pending';
                        
                        return [
                            'id' => $inv->id,
                            'number' => $inv->unique_code ?? 'INV-' . $inv->id,
                            'amount' => number_format($finalAmount, 2),
                            'paid_amount' => number_format($paidAmount, 2),
                            'outstanding' => number_format(max(0, $finalAmount - $paidAmount), 2),
                            'status' => $status,
                            'date' => isset($inv->created_at) ? Carbon::parse($inv->created_at)->format('M d, Y') : 'N/A',
                            'due_date' => isset($inv->invoice_date) ? Carbon::parse($inv->invoice_date)->format('M d, Y') : 'N/A'
                        ];
                    });
            }
        } catch (\Exception $e) {}
        
        // AMC Renewal Warning - Check for quotations with AMC start date
        $amcRenewalWarning = null;
        try {
            if (DB::getSchemaBuilder()->hasTable('quotations') && $company) {
                // Find the latest quotation with AMC start date for this company
                $latestQuotation = DB::table('quotations')
                    ->where('company_name', $company->company_name)
                    ->whereNotNull('amc_start_date')
                    ->orderBy('amc_start_date', 'desc')
                    ->first();
                
                if ($latestQuotation && $latestQuotation->amc_start_date) {
                    $amcStartDate = Carbon::parse($latestQuotation->amc_start_date);
                    $amcEndDate = $amcStartDate->copy()->addDays(365); // 1 year AMC (365 days)
                    $daysUntilExpiry = now()->diffInDays($amcEndDate, false);
                    
                    // Show RED warning if AMC expired or expiring within 15 days
                    if ($daysUntilExpiry <= 15) {
                        $amcRenewalWarning = [
                            'quotation_id' => $latestQuotation->id,
                            'quotation_number' => $latestQuotation->unique_code ?? 'Q-' . $latestQuotation->id,
                            'company_name' => $latestQuotation->company_name,
                            'amc_start' => $amcStartDate->format('M d, Y'),
                            'amc_end' => $amcEndDate->format('M d, Y'),
                            'days_until_expiry' => (int)$daysUntilExpiry,
                            'is_expired' => $daysUntilExpiry < 0,
                            'status' => 'critical' // Always red/critical
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error('AMC Renewal Warning Error: ' . $e->getMessage());
        }

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

        // Recent Tickets - use company name since tickets table doesn't have company_id
        $ticketsQuery = Ticket::query();
        $ticketsQuery->where(function($query) use ($company) {
            $query->where('company', $company->company_name ?? '')
                  ->orWhere('customer', $company->name ?? auth()->user()->name);
        });
        
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

        return view('dashboard-customer', compact('stats', 'recentQuotations', 'recentInvoices', 'activeProjectsList', 'recentTickets', 'company', 'amcRenewalWarning'));
    }
}
