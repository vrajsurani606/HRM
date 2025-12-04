<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceReportController extends Controller
{
    public function index(Request $request)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.view attendance report'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $user = auth()->user();
        $query = Attendance::with('employee.user');

        // Filter by role: employees see only their own attendance
        if ($user->hasRole('employee')) {
            $employee = Employee::where('email', $user->email)->first();
            if ($employee) {
                $query->where('employee_id', $employee->id);
            } else {
                // If no employee record, show empty results
                $query->where('employee_id', -1);
            }
        }

        // Filter by date range (From / To)
        if ($request->has('start_date') && $request->start_date) {
            try {
                // Try dd/mm/yy format first
                $startDate = Carbon::createFromFormat('d/m/y', $request->start_date)->format('Y-m-d');
                $query->whereDate('date', '>=', $startDate);
            } catch (\Exception $e) {
                try {
                    // Try dd/mm/yyyy format
                    $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
                    $query->whereDate('date', '>=', $startDate);
                } catch (\Exception $e2) {
                    try {
                        // Try standard format
                        $query->whereDate('date', '>=', Carbon::parse($request->start_date)->format('Y-m-d'));
                    } catch (\Exception $e3) {}
                }
            }
        }

        if ($request->has('end_date') && $request->end_date) {
            try {
                // Try dd/mm/yy format first
                $endDate = Carbon::createFromFormat('d/m/y', $request->end_date)->format('Y-m-d');
                $query->whereDate('date', '<=', $endDate);
            } catch (\Exception $e) {
                try {
                    // Try dd/mm/yyyy format
                    $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
                    $query->whereDate('date', '<=', $endDate);
                } catch (\Exception $e2) {
                    try {
                        // Try standard format
                        $query->whereDate('date', '<=', Carbon::parse($request->end_date)->format('Y-m-d'));
                    } catch (\Exception $e3) {}
                }
            }
        }

        // Filter by employee (only for non-employee roles)
        if ($request->has('employee_id') && $request->employee_id && !$user->hasRole('employee')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Order by date descending
        $attendances = $query->orderBy('date', 'desc')
            ->orderBy('check_in', 'desc')
            ->paginate(50);

        // Get employees for filter dropdown (only for non-employee roles)
        if ($user->hasRole('employee')) {
            $employee = Employee::where('email', $user->email)->first();
            $employees = $employee ? collect([$employee]) : collect([]);
        } else {
            $employees = Employee::with('user')->orderBy('name')->get();
        }

        return view('hr.attendance.report', compact('attendances', 'employees'));
    }

    public function generate(Request $request)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.view attendance report'))) {
            return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
        }

        $query = Attendance::with('employee.user');

        // Apply filters
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        if ($request->has('employee_id') && $request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('date', 'desc')
            ->orderBy('check_in', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $attendances
        ]);
    }

    public function export(Request $request)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.export attendance report'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $user = auth()->user();
        $query = Attendance::with('employee.user');

        // Filter by role: employees see only their own attendance
        if ($user->hasRole('employee')) {
            $employee = Employee::where('email', $user->email)->first();
            if ($employee) {
                $query->where('employee_id', $employee->id);
            } else {
                // If no employee record, return empty
                $query->where('employee_id', -1);
            }
        }

        // Filter by date range (From / To)
        if ($request->has('start_date') && $request->start_date) {
            try {
                $startDate = Carbon::createFromFormat('d/m/y', $request->start_date)->format('Y-m-d');
                $query->whereDate('date', '>=', $startDate);
            } catch (\Exception $e) {
                try {
                    $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
                    $query->whereDate('date', '>=', $startDate);
                } catch (\Exception $e2) {
                    try {
                        $query->whereDate('date', '>=', Carbon::parse($request->start_date)->format('Y-m-d'));
                    } catch (\Exception $e3) {}
                }
            }
        }

        if ($request->has('end_date') && $request->end_date) {
            try {
                $endDate = Carbon::createFromFormat('d/m/y', $request->end_date)->format('Y-m-d');
                $query->whereDate('date', '<=', $endDate);
            } catch (\Exception $e) {
                try {
                    $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
                    $query->whereDate('date', '<=', $endDate);
                } catch (\Exception $e2) {
                    try {
                        $query->whereDate('date', '<=', Carbon::parse($request->end_date)->format('Y-m-d'));
                    } catch (\Exception $e3) {}
                }
            }
        }

        // Filter by employee (only for non-employee roles)
        if ($request->has('employee_id') && $request->employee_id && !$user->hasRole('employee')) {
            $query->where('employee_id', $request->employee_id);
        }

        $attendances = $query->orderBy('date', 'desc')
            ->orderBy('check_in', 'desc')
            ->get();

        // Generate CSV
        $filename = 'attendance_report_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($attendances) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, ['Date', 'EMP Code', 'Employee Name', 'Entry #', 'Check In', 'Check Out', 'Duration', 'Day Total', 'Status']);

            // Group by employee and date to calculate entry numbers and day totals
            $grouped = $attendances->groupBy(function($item) {
                return $item->employee_id . '_' . Carbon::parse($item->date)->format('Y-m-d');
            });

            foreach ($grouped as $key => $dayEntries) {
                $dayTotalSeconds = 0;
                $entryDurations = [];
                
                // Calculate durations
                foreach ($dayEntries as $idx => $entry) {
                    $secs = 0;
                    if ($entry->check_in && $entry->check_out) {
                        $inT = Carbon::parse($entry->check_in);
                        $outT = Carbon::parse($entry->check_out);
                        $secs = abs($outT->timestamp - $inT->timestamp);
                    }
                    $entryDurations[$idx] = $secs;
                    $dayTotalSeconds += $secs;
                }
                
                // Format day total
                $totalH = floor($dayTotalSeconds / 3600);
                $totalM = floor(($dayTotalSeconds % 3600) / 60);
                $totalS = $dayTotalSeconds % 60;
                $dayTotalFormatted = sprintf('%02d:%02d:%02d', $totalH, $totalM, $totalS);
                
                // Add rows for each entry
                foreach ($dayEntries as $idx => $attendance) {
                    $durationSecs = $entryDurations[$idx] ?? 0;
                    $durH = floor($durationSecs / 3600);
                    $durM = floor(($durationSecs % 3600) / 60);
                    $durS = $durationSecs % 60;
                    $durationFormatted = sprintf('%02d:%02d:%02d', $durH, $durM, $durS);
                    
                    fputcsv($file, [
                        Carbon::parse($attendance->date)->format('d/m/Y'),
                        $attendance->employee->code ?? 'EMP/' . str_pad($attendance->employee->id ?? '000', 4, '0', STR_PAD_LEFT),
                        $attendance->employee->name ?? 'N/A',
                        '#' . ($idx + 1),
                        $attendance->check_in ? Carbon::parse($attendance->check_in)->format('h:i A') : '-',
                        $attendance->check_out ? Carbon::parse($attendance->check_out)->format('h:i A') : '-',
                        $attendance->check_in && $attendance->check_out ? $durationFormatted : '-',
                        $dayTotalFormatted,
                        ucfirst(str_replace('_', ' ', $attendance->status ?? '-'))
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
