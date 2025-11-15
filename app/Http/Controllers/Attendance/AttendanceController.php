<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index()
    {
        $employee = Employee::where('user_id', Auth::id())->firstOrFail();
        $today = now()->toDateString();
        
        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->first();
            
        $attendanceHistory = Attendance::where('employee_id', $employee->id)
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        return view('attendance.index', [
            'attendance' => $attendance,
            'attendanceHistory' => $attendanceHistory,
            'employee' => $employee
        ]);
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $employee = Employee::where('user_id', Auth::id())->firstOrFail();
        $today = now()->toDateString();
        $now = now();

        // Check if already checked in today
        $existingAttendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->first();

        if ($existingAttendance && $existingAttendance->check_in) {
            return redirect()->back()->with('error', 'You have already checked in today.');
        }

        try {
            DB::beginTransaction();

            $attendance = $existingAttendance ?? new Attendance();
            $attendance->employee_id = $employee->id;
            $attendance->date = $today;
            $attendance->check_in = $now->toTimeString();
            $attendance->status = 'present';
            $attendance->notes = $request->notes;
            $attendance->check_in_ip = $request->ip();
            // You can add geolocation logic here for check_in_location
            
            $attendance->save();
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Successfully checked in at ' . $now->format('h:i A'));
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Check-in error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to check in. Please try again.');
        }
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $employee = Employee::where('user_id', Auth::id())->firstOrFail();
        $today = now()->toDateString();
        $now = now();

        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'Please check in first.');
        }

        if ($attendance->check_out) {
            return redirect()->back()->with('error', 'You have already checked out today.');
        }

        try {
            DB::beginTransaction();

            $attendance->check_out = $now->toTimeString();
            $attendance->total_working_hours = $attendance->calculateWorkingHours();
            $attendance->check_out_ip = $request->ip();
            // You can add geolocation logic here for check_out_location
            
            if ($request->notes) {
                $attendance->notes = $attendance->notes 
                    ? $attendance->notes . "\nCheck-out note: " . $request->notes
                    : "Check-out note: " . $request->notes;
            }
            
            $attendance->save();
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Successfully checked out at ' . $now->format('h:i A'));
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Check-out error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to check out. Please try again.');
        }
    }

    public function history()
    {
        $employee = Employee::where('user_id', Auth::id())->firstOrFail();
        
        $attendances = Attendance::where('employee_id', $employee->id)
            ->orderBy('date', 'desc')
            ->paginate(15);
            
        return view('attendance.history', [
            'attendances' => $attendances,
            'employee' => $employee
        ]);
    }
}
