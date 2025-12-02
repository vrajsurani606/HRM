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

        $query = Attendance::with('employee.user');

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        // Filter by employee
        if ($request->has('employee_id') && $request->employee_id) {
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

        // Get all employees for filter dropdown
        $employees = Employee::with('user')->orderBy('name')->get();

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
            fputcsv($file, ['Date', 'Employee', 'Check In', 'Check Out', 'Working Hours', 'Status']);

            // Add data rows
            foreach ($attendances as $attendance) {
                fputcsv($file, [
                    Carbon::parse($attendance->date)->format('Y-m-d'),
                    $attendance->employee->name ?? 'N/A',
                    $attendance->check_in ? Carbon::parse($attendance->check_in)->format('H:i:s') : '-',
                    $attendance->check_out ? Carbon::parse($attendance->check_out)->format('H:i:s') : '-',
                    $attendance->total_working_hours ?? '-',
                    $attendance->status ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
