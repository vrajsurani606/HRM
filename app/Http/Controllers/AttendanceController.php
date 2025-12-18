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
        // Get the latest attendance entry for today
        $attendance = $employee
            ? Attendance::where('employee_id', $employee->id)->whereDate('date', $today)->latest('created_at')->first()
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
            !auth()->user()->can('Attendance Management.check out')) {
            abort(403, 'Unauthorized to access attendance check-in/out.');
        }
        
        $today = now()->toDateString();
        $employee = Employee::where('user_id', Auth::id())->first();
        // Get the latest attendance entry for today
        $attendance = $employee
            ? Attendance::where('employee_id', $employee->id)->whereDate('date', $today)->latest('created_at')->first()
            : null;

        return view('attendance.check', [
            'attendance' => $attendance,
            'today' => $today,
            'employee' => $employee,
        ]);
    }
    /**
     * Get current attendance status for the day
     */
    public function getCurrentStatus()
    {
        $today = now()->format('Y-m-d');
        $employee = Employee::where('user_id', auth()->id())->first();
        
        if (!$employee) {
            return response()->json([
                'has_checked_in' => false,
                'has_checked_out' => false,
                'can_check_in' => true,
                'message' => 'Employee profile not found'
            ]);
        }

        // Get the latest attendance record for today
        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->latest('created_at')
            ->first();

        if (!$attendance) {
            return response()->json([
                'has_checked_in' => false,
                'has_checked_out' => false,
                'can_check_in' => true,
                'message' => 'Ready to check in'
            ]);
        }

        $canCheckIn = true;
        $message = '';

        // If checked in but not checked out - currently working
        if ($attendance->check_in && !$attendance->check_out) {
            $canCheckIn = false;
            $message = 'Already checked in. Please check out first.';
        }
        // If checked out - check 5-minute cooldown
        elseif ($attendance->check_out) {
            $lastCheckOut = Carbon::parse($attendance->check_out);
            $now = now();
            $secondsSinceCheckOut = abs($now->diffInSeconds($lastCheckOut));
            
            if ($secondsSinceCheckOut < 300) { // 300 seconds = 5 minutes
                $canCheckIn = false;
                $remainingSeconds = 300 - $secondsSinceCheckOut;
                $remainingMinutes = ceil($remainingSeconds / 60);
                $message = "Please wait {$remainingMinutes} minute(s) before checking in again.";
            } else {
                // Cooldown expired - can check in again
                $canCheckIn = true;
                $message = 'Ready to check in again';
            }
        }

        // Get all attendance entries for today to calculate total hours
        $allAttendances = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->get();
        
        $totalMinutes = 0;
        foreach ($allAttendances as $att) {
            if ($att->check_in && $att->check_out) {
                $totalMinutes += Carbon::parse($att->check_in)->diffInMinutes(Carbon::parse($att->check_out));
            }
        }
        
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        $totalHours = sprintf('%02d:%02d', $hours, $minutes);

        return response()->json([
            'has_checked_in' => (bool) $attendance->check_in,
            'has_checked_out' => (bool) $attendance->check_out,
            'can_check_in' => $canCheckIn,
            'message' => $message,
            'total_hours' => $totalHours,
            'entries_count' => $allAttendances->count()
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
            ? Attendance::where('employee_id', $employee->id)->whereDate('date', $today)->latest('created_at')->first()
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
        
        if (!$employee) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Employee profile not found'], 400)
                : back()->with('error', 'Employee profile not found');
        }

        // Get the latest attendance record for today
        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->latest('created_at')
            ->first();

        // If no attendance record exists, create new one
        if (!$attendance) {
            $attendance = new Attendance();
            $attendance->employee_id = $employee->id;
            $attendance->date = $today;
            $attendance->check_in = Carbon::now();
            $attendance->status = 'present';
            $attendance->check_in_ip = $request->ip();
            try { $attendance->check_in_location = $this->getLocation($request->ip()); } catch (\Throwable $e) { $attendance->check_in_location = 'Location not available'; }
            $attendance->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully checked in at ' . now()->format('h:i A'),
                    'attendance' => $attendance
                ]);
            }
            return back()->with('success', 'Successfully checked in at ' . now()->format('h:i A'));
        }

        // If already checked in and not checked out, prevent re-check-in
        if ($attendance->check_in && !$attendance->check_out) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already checked in. Please check out first.'
                ], 400);
            }
            return back()->with('error', 'You are already checked in. Please check out first.');
        }

        // If already checked out, check 5-minute cooldown before re-check-in
        if ($attendance->check_out) {
            $lastCheckOut = Carbon::parse($attendance->check_out);
            $secondsSinceCheckOut = abs(now()->diffInSeconds($lastCheckOut));
            
            if ($secondsSinceCheckOut < 300) { // 300 seconds = 5 minutes
                $remainingSeconds = 300 - $secondsSinceCheckOut;
                $remainingMinutes = ceil($remainingSeconds / 60);
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Please wait {$remainingMinutes} minute(s) before checking in again."
                    ], 400);
                }
                return back()->with('error', "Please wait {$remainingMinutes} minute(s) before checking in again.");
            }

            // Re-check-in after checkout: create a new attendance entry for the new cycle
            $newAttendance = new Attendance();
            $newAttendance->employee_id = $employee->id;
            $newAttendance->date = $today;
            $newAttendance->check_in = Carbon::now();
            $newAttendance->status = 'present';
            $newAttendance->check_in_ip = $request->ip();
            try { $newAttendance->check_in_location = $this->getLocation($request->ip()); } catch (\Throwable $e) { $newAttendance->check_in_location = 'Location not available'; }
            $newAttendance->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully checked in at ' . now()->format('h:i A'),
                    'attendance' => $newAttendance
                ]);
            }
            return back()->with('success', 'Successfully checked in at ' . now()->format('h:i A'));
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid attendance state.'
            ], 400);
        }
        return back()->with('error', 'Invalid attendance state.');
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
        // Get the latest attendance entry for today (the active one)
        $attendance = $employee ? Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->latest('created_at')
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

        if (!$attendance->check_in) {
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
                    'message' => 'You have already checked out. Please check in again if needed.'
                ], 400);
            }
            return back()->with('error', 'You have already checked out. Please check in again if needed.');
        }

        $checkOut = Carbon::now();
        $attendance->check_out = $checkOut;
        
        // Calculate total working hours from all entries for today
        $allAttendances = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->get();
        
        $totalMinutes = 0;
        foreach ($allAttendances as $att) {
            if ($att->id === $attendance->id) {
                // For current entry, use the new check_out time
                $totalMinutes += Carbon::parse($att->check_in)->diffInMinutes($checkOut);
            } elseif ($att->check_in && $att->check_out) {
                // For other entries, use their stored times
                $totalMinutes += Carbon::parse($att->check_in)->diffInMinutes(Carbon::parse($att->check_out));
            }
        }
        
        // Convert to hours:minutes format
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        $attendance->total_working_hours = sprintf('%02d:%02d', $hours, $minutes);
        
        $attendance->status = 'present';
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
     * Calculate duration between two times in minutes
     */
    private function calculateDuration($checkIn, $checkOut)
    {
        try {
            $in = Carbon::parse($checkIn);
            $out = Carbon::parse($checkOut);
            return $in->diffInMinutes($out);
        } catch (\Exception $e) {
            return 0;
        }
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
     * Show the form for creating a new attendance record.
     */
    public function create()
    {
        // Check permission
        if (!auth()->user()->can('Attendance Management.create attendance')) {
            abort(403, 'Unauthorized to create attendance records.');
        }

        $employees = Employee::orderBy('name')->get();
        
        return view('attendance.create', [
            'employees' => $employees,
            'page_title' => 'Create Attendance Record'
        ]);
    }

    /**
     * Store a newly created attendance record in storage.
     */
    public function store(Request $request)
    {
        // Check permission
        if (!auth()->user()->can('Attendance Management.create attendance')) {
            return back()->with('error', 'Unauthorized to create attendance records.');
        }

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'required|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'status' => 'required|in:present,absent,half_day,late,early_leave',
            'notes' => 'nullable|string|max:500',
        ]);

        // Combine date with time
        $checkInDateTime = \Carbon\Carbon::parse($validated['date'] . ' ' . $validated['check_in']);
        $checkOutDateTime = !empty($validated['check_out']) 
            ? \Carbon\Carbon::parse($validated['date'] . ' ' . $validated['check_out']) 
            : null;

        // Calculate total working hours if check_out is provided
        $totalWorkingHours = null;
        if ($checkOutDateTime) {
            $totalMinutes = $checkInDateTime->diffInMinutes($checkOutDateTime);
            $hours = floor($totalMinutes / 60);
            $minutes = $totalMinutes % 60;
            $totalWorkingHours = sprintf('%02d:%02d', $hours, $minutes);
        }

        // Check if attendance already exists for this employee on this date
        $existingAttendance = Attendance::where('employee_id', $validated['employee_id'])
            ->whereDate('date', $validated['date'])
            ->first();

        if ($existingAttendance) {
            return back()
                ->withInput()
                ->with('error', 'Attendance record already exists for this employee on this date.');
        }

        // Create attendance record
        $attendance = Attendance::create([
            'employee_id' => $validated['employee_id'],
            'date' => $validated['date'],
            'check_in' => $checkInDateTime,
            'check_out' => $checkOutDateTime,
            'total_working_hours' => $totalWorkingHours,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
            'check_in_ip' => $request->ip(),
            'check_out_ip' => $checkOutDateTime ? $request->ip() : null,
            'check_in_location' => 'Manual Entry',
            'check_out_location' => $checkOutDateTime ? 'Manual Entry' : null,
        ]);

        return redirect()
            ->route('attendance.report')
            ->with('success', 'Attendance record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified attendance record.
     */
    public function edit($id)
    {
        // Check permission
        if (!auth()->user()->can('Attendance Management.edit attendance')) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized to edit attendance records.'], 403);
            }
            abort(403, 'Unauthorized to edit attendance records.');
        }

        $attendance = Attendance::with('employee')->findOrFail($id);

        if (request()->ajax()) {
            // Format dates for JSON response
            $attendanceData = $attendance->toArray();
            $attendanceData['date'] = $attendance->date ? $attendance->date->format('Y-m-d') : null;
            $attendanceData['check_in'] = $attendance->check_in ? Carbon::parse($attendance->check_in)->format('Y-m-d H:i:s') : null;
            $attendanceData['check_out'] = $attendance->check_out ? Carbon::parse($attendance->check_out)->format('Y-m-d H:i:s') : null;
            
            return response()->json([
                'success' => true,
                'attendance' => $attendanceData
            ]);
        }

        $employees = Employee::orderBy('name')->get();
        return view('attendance.edit', compact('attendance', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Check permission
        if (!auth()->user()->can('Attendance Management.edit attendance')) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized to edit attendance records.'], 403);
            }
            return back()->with('error', 'Unauthorized to edit attendance records.');
        }

        $attendance = Attendance::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'required|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'status' => 'required|in:present,absent,half_day,late,early_leave',
            'notes' => 'nullable|string|max:500',
        ]);

        // Combine date with time
        $checkInDateTime = \Carbon\Carbon::parse($validated['date'] . ' ' . $validated['check_in']);
        $checkOutDateTime = !empty($validated['check_out']) 
            ? \Carbon\Carbon::parse($validated['date'] . ' ' . $validated['check_out']) 
            : null;

        // Calculate total working hours if check_out is provided
        $totalWorkingHours = null;
        if ($checkOutDateTime) {
            $totalMinutes = $checkInDateTime->diffInMinutes($checkOutDateTime);
            $hours = floor($totalMinutes / 60);
            $minutes = $totalMinutes % 60;
            $totalWorkingHours = sprintf('%02d:%02d', $hours, $minutes);
        }

        // Update attendance record
        $attendance->update([
            'employee_id' => $validated['employee_id'],
            'date' => $validated['date'],
            'check_in' => $checkInDateTime,
            'check_out' => $checkOutDateTime,
            'total_working_hours' => $totalWorkingHours,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Attendance record updated successfully!',
                'attendance' => $attendance
            ]);
        }

        return redirect()
            ->route('attendance.report')
            ->with('success', 'Attendance record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Check permission
        if (!auth()->user()->can('Attendance Management.delete attendance')) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized to delete attendance records.'], 403);
            }
            return back()->with('error', 'Unauthorized to delete attendance records.');
        }

        try {
            $attendance = Attendance::findOrFail($id);
            $attendance->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Attendance record deleted successfully!'
                ]);
            }

            return redirect()
                ->route('attendance.report')
                ->with('success', 'Attendance record deleted successfully.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Attendance record not found or already deleted.'
                ], 404);
            }
            return back()->with('error', 'Attendance record not found or already deleted.');
        }
    }

    /**
     * Quick edit attendance record (AJAX)
     */
    public function quickEdit($id)
    {
        $attendance = Attendance::with('employee')->findOrFail($id);

        if (request()->ajax()) {
            $attendanceData = $attendance->toArray();
            $attendanceData['date'] = $attendance->date ? $attendance->date->format('Y-m-d') : null;
            $attendanceData['check_in'] = $attendance->check_in ? Carbon::parse($attendance->check_in)->format('Y-m-d H:i:s') : null;
            $attendanceData['check_out'] = $attendance->check_out ? Carbon::parse($attendance->check_out)->format('Y-m-d H:i:s') : null;
            
            return response()->json([
                'success' => true,
                'attendance' => $attendanceData
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid request'], 400);
    }

    /**
     * Quick update attendance record (AJAX)
     */
    public function quickUpdate(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'required|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'status' => 'required|in:present,absent,half_day,late,early_leave',
            'notes' => 'nullable|string|max:500',
        ]);

        // Combine date with time
        $checkInDateTime = \Carbon\Carbon::parse($validated['date'] . ' ' . $validated['check_in']);
        $checkOutDateTime = !empty($validated['check_out']) 
            ? \Carbon\Carbon::parse($validated['date'] . ' ' . $validated['check_out']) 
            : null;

        // Calculate total working hours if check_out is provided
        $totalWorkingHours = null;
        if ($checkOutDateTime) {
            $totalMinutes = $checkInDateTime->diffInMinutes($checkOutDateTime);
            $hours = floor($totalMinutes / 60);
            $minutes = $totalMinutes % 60;
            $totalWorkingHours = sprintf('%02d:%02d', $hours, $minutes);
        }

        // Update attendance record
        $attendance->update([
            'employee_id' => $validated['employee_id'],
            'date' => $validated['date'],
            'check_in' => $checkInDateTime,
            'check_out' => $checkOutDateTime,
            'total_working_hours' => $totalWorkingHours,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Updated successfully',
                'attendance' => $attendance
            ]);
        }

        return redirect()->route('attendance.report')->with('success', 'Updated successfully');
    }

    /**
     * Print attendance record
     */
    public function print($id)
    {
        // Check permission - allow if user has any of these permissions
        if (!auth()->check() || !(
            auth()->user()->hasRole('super-admin') || 
            auth()->user()->can('Attendance Management.view attendance')
        )) {
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
