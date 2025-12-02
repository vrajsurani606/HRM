<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $employee = Employee::where('user_id', Auth::id())->first();
        $attendance = $employee
            ? Attendance::where('employee_id', $employee->id)->whereDate('date', $today)->first()
            : null;

        return view('attendance.index', [
            'attendance' => $attendance,
            'employee' => $employee,
        ]);
    }

    public function checkPage()
    {
        // Check permission
        if (!auth()->user()->can('Attendance Management.check in') && 
            !auth()->user()->can('Attendance Management.check out') &&
            !auth()->user()->can('Attendance Management.view own attendance')) {
            abort(403, 'Unauthorized to access attendance check-in/out.');
        }
        
        $today = now()->toDateString();
        $employee = Employee::where('user_id', Auth::id())->first();
        $attendance = $employee
            ? Attendance::where('employee_id', $employee->id)->whereDate('date', $today)->first()
            : null;

        return view('attendance.check', [
            'attendance' => $attendance,
            'today' => $today,
            'employee' => $employee,
        ]);
    }
    /**
     * Check if user has already checked in today
     */
    public function checkStatus()
    {
        $today = now()->format('Y-m-d');
        $employee = Employee::where('user_id', auth()->id())->first();
        $attendance = $employee
            ? Attendance::where('employee_id', $employee->id)->whereDate('date', $today)->first()
            : null;

        return response()->json([
            'has_checked_in' => $attendance && $attendance->check_in !== null,
            'has_checked_out' => $attendance && $attendance->check_out !== null,
            'current_time' => now()->format('H:i:s'),
            'attendance' => $attendance
        ]);
    }

    /**
     * Check in the user
     */
    public function checkIn(Request $request)
    {
        // Check permission
        if (!auth()->user()->can('Attendance Management.check in') && 
            !auth()->user()->can('Attendance Management.create attendance')) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Unauthorized to check in'], 403)
                : back()->with('error', 'Unauthorized to check in');
        }
        
        $today = now()->format('Y-m-d');
        
        // Resolve current employee
        $employee = Employee::where('user_id', auth()->id())->first();
        
        // Check if already checked in today for this employee
        $existing = $employee ? Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->first() : null;

        if ($existing && $existing->check_in) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already checked in today.'
                ], 400);
            }
            return back()->with('error', 'You have already checked in today.');
        }

        if (!$employee) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Employee profile not found'], 400)
                : back()->with('error', 'Employee profile not found');
        }

        $attendance = $existing ?? new Attendance();
        $attendance->employee_id = $employee->id;
        $attendance->date = $today;
        $attendance->check_in = Carbon::now(); // Use Carbon::now() for current timestamp
        $attendance->status = 'present';
        $attendance->check_in_ip = $request->ip();
        try { $attendance->check_in_location = $this->getLocation($request->ip()); } catch (\Throwable $e) { $attendance->check_in_location = 'Location not available'; }
        $attendance->save();

        // If the client is AJAX (API), return JSON; otherwise redirect with flash
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Successfully checked in at ' . now()->format('h:i A'),
                'attendance' => $attendance
            ]);
        }
        return back()->with('success', 'Successfully checked in at ' . now()->format('h:i A'));
    }

    /**
     * Check out the user
     */
    public function checkOut(Request $request)
    {
        // Check permission
        if (!auth()->user()->can('Attendance Management.check out') && 
            !auth()->user()->can('Attendance Management.edit attendance')) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Unauthorized to check out'], 403)
                : back()->with('error', 'Unauthorized to check out');
        }
        
        $today = now()->format('Y-m-d');
        $employee = Employee::where('user_id', auth()->id())->first();
        $attendance = $employee ? Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->first() : null;

        if (!$attendance) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You need to check in first.'
                ], 400);
            }
            return back()->with('error', 'You need to check in first.');
        }

        if ($attendance->check_out) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already checked out today.'
                ], 400);
            }
            return back()->with('error', 'You have already checked out today.');
        }

        $checkOut = Carbon::now(); // Use Carbon::now() for current timestamp
        $attendance->check_out = $checkOut;
        // compute and store formatted total working hours
        $attendance->total_working_hours = $attendance->calculateWorkingHours();
        // Auto-calculate status based on check-in/out times
        $attendance->status = $attendance->autoCalculateStatus();
        $attendance->check_out_ip = $request->ip();
        try { $attendance->check_out_location = $this->getLocation($request->ip()); } catch (\Throwable $e) { $attendance->check_out_location = 'Location not available'; }
        $attendance->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Successfully checked out at ' . $checkOut->format('h:i A'),
                'total_hours' => $attendance->total_working_hours,
                'attendance' => $attendance
            ]);
        }
        return back()->with('success', 'Successfully checked out at ' . $checkOut->format('h:i A'));
    }

    /**
     * Get user's attendance history
     */
    public function history()
    {
        $employee = Employee::where('user_id', auth()->id())->first();
        $attendance = Attendance::when($employee, fn($q) => $q->where('employee_id', $employee->id))
            ->orderBy('date', 'desc')
            ->paginate(30);

        // If requested via API, return JSON; else load a simple view (optional)
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $attendance
            ]);
        }
        return view('attendance.history', ['attendances' => $attendance]);
    }

    /**
     * Helper to format seconds to H:i:s
     */
    private function formatSeconds($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;
        
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    /**
     * Helper to get location from IP (basic implementation)
     */
    private function getLocation($ip)
    {
        try {
            $data = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
            return $data->city . ', ' . $data->region . ', ' . $data->country;
        } catch (\Exception $e) {
            return 'Location not available';
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Print attendance record
     */
    public function print($id)
    {
        // Check permission
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.view attendance'))) {
            abort(403, 'Unauthorized to print attendance.');
        }

        $attendance = Attendance::with('employee.user')->findOrFail($id);

        // Check access: employees can only print their own attendance
        if (auth()->user()->hasRole('employee')) {
            $employee = Employee::where('user_id', auth()->id())->first();
            if (!$employee || $attendance->employee_id != $employee->id) {
                abort(403, 'Unauthorized to print this attendance record.');
            }
        }

        return view('attendance.print', compact('attendance'));
    }
}
