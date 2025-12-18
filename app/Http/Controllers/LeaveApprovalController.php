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
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leave Approval Management.view leave approval'))) {
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
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by employee (only for non-employee roles)
        if ($request->filled('employee_id') && !$user->hasRole('employee')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by date range - handle both dd/mm/yyyy and yyyy-mm-dd formats
        if ($request->filled('start_date')) {
            $startDate = $request->start_date;
            // Convert dd/mm/yyyy to yyyy-mm-dd if needed
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $startDate)) {
                $parts = explode('/', $startDate);
                $startDate = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
            $query->whereDate('start_date', '>=', $startDate);
        }

        if ($request->filled('end_date')) {
            $endDate = $request->end_date;
            // Convert dd/mm/yyyy to yyyy-mm-dd if needed
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $endDate)) {
                $parts = explode('/', $endDate);
                $endDate = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
            $query->whereDate('end_date', '<=', $endDate);
        }

        $leaves = $query->orderBy('created_at', 'desc')->paginate(20)->appends($request->query());

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
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leave Approval Management.create leave approval'))) {
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
            $requiredPermission = $request->status === 'approved' ? 'Leave Approval Management.approve leave' : 'Leave Approval Management.reject leave';
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
                // Check monthly paid leave limit and auto-convert excess to unpaid
                $message = 'Leave approved successfully!';
                
                if ($leave->is_paid && $leave->total_days > 0) {
                    $startDate = \Carbon\Carbon::parse($leave->start_date);
                    
                    // Get already approved paid leaves for this month (excluding current leave)
                    $monthUsed = Leave::where('employee_id', $leave->employee_id)
                        ->where('is_paid', true)
                        ->whereYear('start_date', $startDate->year)
                        ->whereMonth('start_date', $startDate->month)
                        ->where('status', 'approved')
                        ->where('id', '!=', $leave->id)
                        ->sum('total_days');
                    
                    $monthlyLimit = 1; // Only 1 paid leave per month
                    $availablePaid = max(0, $monthlyLimit - $monthUsed);
                    
                    if ($availablePaid <= 0) {
                        // No paid leave available, convert entire leave to unpaid
                        $leave->update([
                            'status' => 'approved',
                            'is_paid' => false,
                            'approved_by' => Auth::id(),
                            'approved_at' => now()
                        ]);
                        $message = 'Leave approved as UNPAID (monthly paid leave limit of 1 already used).';
                    } elseif ($leave->total_days > $availablePaid) {
                        // Partial paid leave available - split into paid and unpaid
                        $paidDays = $availablePaid;
                        $unpaidDays = $leave->total_days - $availablePaid;
                        
                        // Update original leave as paid with reduced days
                        $leave->update([
                            'status' => 'approved',
                            'is_paid' => true,
                            'total_days' => $paidDays,
                            'approved_by' => Auth::id(),
                            'approved_at' => now()
                        ]);
                        
                        // Create new unpaid leave for remaining days
                        $unpaidStartDate = \Carbon\Carbon::parse($leave->start_date)->addDays((int)$paidDays);
                        Leave::create([
                            'employee_id' => $leave->employee_id,
                            'leave_type' => $leave->leave_type,
                            'is_paid' => false,
                            'start_date' => $unpaidStartDate,
                            'end_date' => $leave->end_date,
                            'total_days' => $unpaidDays,
                            'reason' => $leave->reason . ' (Auto-converted to unpaid - exceeded monthly limit)',
                            'status' => 'approved',
                            'approved_by' => Auth::id(),
                            'approved_at' => now()
                        ]);
                        
                        $message = "Leave approved: {$paidDays} day(s) PAID, {$unpaidDays} day(s) converted to UNPAID (monthly limit: 1 paid leave).";
                    } else {
                        // Full paid leave available
                        $leave->update([
                            'status' => 'approved',
                            'approved_by' => Auth::id(),
                            'approved_at' => now()
                        ]);
                    }
                } else {
                    // Already unpaid or zero days, just approve
                    $leave->update([
                        'status' => 'approved',
                        'approved_by' => Auth::id(),
                        'approved_at' => now()
                    ]);
                }
            } else {
                $leave->update([
                    'status' => 'rejected',
                    'rejected_by' => Auth::id(),
                    'rejected_at' => now()
                ]);
                $message = 'Leave rejected successfully!';
            }
        } else {
            // Permission check for edit - allow employees to edit their own pending leaves
            $user = auth()->user();
            $canEdit = $user->hasRole('super-admin') || $user->can('Leave Approval Management.edit leave approval');
            
            // Check if employee is editing their own pending leave
            $isOwnPendingLeave = false;
            if ($user->hasRole('employee') && $leave->status === 'pending') {
                $employee = Employee::where('email', $user->email)->first();
                if ($employee && $leave->employee_id === $employee->id) {
                    $isOwnPendingLeave = true;
                }
            }
            
            if (!auth()->check() || (!$canEdit && !$isOwnPendingLeave)) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
                }
                return redirect()->back()->with('error', 'Permission denied.');
            }
            
            // Employees can only edit pending leaves
            if ($isOwnPendingLeave && !$canEdit && $leave->status !== 'pending') {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'You can only edit pending leave requests.'], 403);
                }
                return redirect()->back()->with('error', 'You can only edit pending leave requests.');
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
            
            // Employees cannot change status
            if ($isOwnPendingLeave && !$canEdit) {
                unset($validated['status']);
            }

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
        $leave = Leave::findOrFail($id);
        $user = auth()->user();
        
        // Permission check - allow employees to delete their own pending leaves
        $canDelete = $user->hasRole('super-admin') || $user->can('Leave Approval Management.delete leave approval');
        
        // Check if employee is deleting their own pending leave
        $isOwnPendingLeave = false;
        if ($user->hasRole('employee') && $leave->status === 'pending') {
            $employee = Employee::where('email', $user->email)->first();
            if ($employee && $leave->employee_id === $employee->id) {
                $isOwnPendingLeave = true;
            }
        }
        
        if (!auth()->check() || (!$canDelete && !$isOwnPendingLeave)) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        // Employees can only delete pending leaves
        if ($isOwnPendingLeave && !$canDelete && $leave->status !== 'pending') {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'You can only delete pending leave requests.'], 403);
            }
            return redirect()->back()->with('error', 'You can only delete pending leave requests.');
        }

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
        $leave = Leave::findOrFail($id);
        $user = auth()->user();
        
        // Permission check - allow employees to edit their own pending leaves
        $canEdit = $user->hasRole('super-admin') || $user->can('Leave Approval Management.edit leave approval');
        
        // Check if employee is editing their own pending leave
        $isOwnPendingLeave = false;
        if ($user->hasRole('employee') && $leave->status === 'pending') {
            $employee = Employee::where('email', $user->email)->first();
            if ($employee && $leave->employee_id === $employee->id) {
                $isOwnPendingLeave = true;
            }
        }
        
        if (!auth()->check() || (!$canEdit && !$isOwnPendingLeave)) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
            return redirect()->back()->with('error', 'Permission denied.');
        }

        if (request()->ajax()) {
            // Return properly formatted data for the edit form
            return response()->json([
                'success' => true,
                'leave' => [
                    'id' => $leave->id,
                    'employee_id' => $leave->employee_id,
                    'leave_type' => $leave->leave_type,
                    'is_paid' => $leave->is_paid,
                    'start_date' => $leave->start_date ? $leave->start_date->format('Y-m-d') : null,
                    'end_date' => $leave->end_date ? $leave->end_date->format('Y-m-d') : null,
                    'total_days' => (float) $leave->total_days, // Ensure decimal is preserved
                    'reason' => $leave->reason,
                    'status' => $leave->status,
                ]
            ]);
        }

        return view('hr.attendance.leave-edit', compact('leave'));
    }
}
