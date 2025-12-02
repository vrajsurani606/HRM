<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveApprovalController extends Controller
{
    /**
     * Display a listing of leave requests for approval
     */
    public function index(Request $request)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.view leave approval'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $user = auth()->user();
        $query = Leave::with('employee');

        // Filter by role: employees see only their own leave requests
        if ($user->hasRole('employee')) {
            $employee = Employee::where('email', $user->email)->first();
            if ($employee) {
                $query->where('employee_id', $employee->id);
            } else {
                // If no employee record, show empty results
                $query->where('employee_id', -1);
            }
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by employee (only for non-employee roles)
        if ($request->has('employee_id') && $request->employee_id && !$user->hasRole('employee')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        $leaves = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get employees for dropdowns (filtered by role)
        if ($user->hasRole('employee')) {
            $employee = Employee::where('email', $user->email)->first();
            $employees = $employee ? collect([$employee]) : collect([]);
        } else {
            $employees = Employee::orderBy('name')->get();
        }

        return view('hr.attendance.leave-approval', compact('leaves', 'employees'));
    }

    /**
     * Store a new leave request
     */
    public function store(Request $request)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.create leave approval'))) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|in:casual,medical,personal,company_holiday',
            'is_paid' => 'required|boolean',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_days' => 'required|numeric|min:0.5',
            'reason' => 'required|string|max:500',
        ]);

        // Check monthly limit for paid leaves
        if ($validated['is_paid']) {
            $startDate = \Carbon\Carbon::parse($validated['start_date']);
            $monthUsed = Leave::where('employee_id', $validated['employee_id'])
                ->where('is_paid', true)
                ->whereYear('start_date', $startDate->year)
                ->whereMonth('start_date', $startDate->month)
                ->where('status', '!=', 'rejected')
                ->sum('total_days');
            
            if ($monthUsed >= 1) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Monthly paid leave limit reached. Only 1 paid leave per month is allowed.'
                    ], 422);
                }
                return redirect()->back()->with('error', 'Monthly paid leave limit reached. Only 1 paid leave per month is allowed.');
            }
        }

        $leave = Leave::create([
            'employee_id' => $validated['employee_id'],
            'leave_type' => $validated['leave_type'],
            'is_paid' => $validated['is_paid'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_days' => (float) $validated['total_days'], // Cast to float to preserve decimals
            'reason' => $validated['reason'],
            'status' => 'pending'
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Leave request created successfully!',
                'leave' => $leave
            ]);
        }

        return redirect()->back()->with('success', 'Leave request created successfully!');
    }

    /**
     * Update the specified leave request
     */
    public function update(Request $request, $id)
    {
        $leave = Leave::findOrFail($id);

        // Check if this is a status update (approve/reject)
        if ($request->has('status') && !$request->has('employee_id')) {
            // Permission check for approve/reject
            $requiredPermission = $request->status === 'approved' ? 'Attendance Management.approve leave' : 'Attendance Management.reject leave';
            if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can($requiredPermission))) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
                }
                return redirect()->back()->with('error', 'Permission denied.');
            }
            $validated = $request->validate([
                'status' => 'required|in:approved,rejected',
            ]);

            if ($validated['status'] === 'approved') {
                $leave->update([
                    'status' => 'approved',
                    'approved_by' => Auth::id(),
                    'approved_at' => now()
                ]);
                $message = 'Leave approved successfully!';
            } else {
                $leave->update([
                    'status' => 'rejected',
                    'rejected_by' => Auth::id(),
                    'rejected_at' => now()
                ]);
                $message = 'Leave rejected successfully!';
            }
        } else {
            // Permission check for edit
            if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.edit leave approval'))) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
                }
                return redirect()->back()->with('error', 'Permission denied.');
            }

            // Full update
            $validated = $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'leave_type' => 'required|in:casual,medical,personal,company_holiday',
                'is_paid' => 'required|boolean',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'total_days' => 'required|numeric|min:0.5',
                'reason' => 'required|string|max:500',
                'status' => 'nullable|in:pending,approved,rejected'
            ]);

            $leave->update($validated);
            $message = 'Leave updated successfully!';
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'leave' => $leave
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove the specified leave request
     */
    public function destroy($id)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.delete leave approval'))) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $leave = Leave::findOrFail($id);
        $leave->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Leave deleted successfully!'
            ]);
        }

        return redirect()->back()->with('success', 'Leave deleted successfully!');
    }

    /**
     * Show the form for editing the specified leave
     */
    public function edit($id)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.edit leave approval'))) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $leave = Leave::findOrFail($id);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'leave' => $leave
            ]);
        }

        return view('hr.attendance.leave-edit', compact('leave'));
    }
}
