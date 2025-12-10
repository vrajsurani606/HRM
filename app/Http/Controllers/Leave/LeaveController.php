<?php

namespace App\Http\Controllers\Leave;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display a listing of leaves
     */
    public function index()
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leave Management.view leave') || auth()->user()->can('Leave Management.view own leave'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user = Auth::user();
        $query = Leave::with('employee')->orderBy('created_at', 'desc');
        
        // Check if user is restricted to own data only (checkbox-based)
        if (user_restricted_to_own_data()) {
            $authEmployee = get_auth_employee();
            if (!$authEmployee) {
                return redirect()->back()->with('error', 'Employee profile not found.');
            }
            $query->where('employee_id', $authEmployee->id);
        }
        
        $leaves = $query->paginate(20);

        return view('leaves.index', compact('leaves'));
    }

    /**
     * Show the form for creating a new leave
     */
    public function create()
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leave Management.create leave'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->first();
        
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee profile not found.');
        }

        // Define leave types with paid/unpaid status
        $leaveTypes = [
            'casual' => [
                'name' => 'Casual Leave',
                'is_paid' => true,
                'description' => 'Paid leave for personal matters'
            ],
            'medical' => [
                'name' => 'Medical Leave',
                'is_paid' => true,
                'description' => 'Paid leave for health issues'
            ],
            'company_holiday' => [
                'name' => 'Company Holiday',
                'is_paid' => true,
                'description' => 'Paid company holidays'
            ],
            'personal' => [
                'name' => 'Personal Leave',
                'is_paid' => false,
                'description' => 'Unpaid leave for personal reasons'
            ]
        ];

        // Calculate leave balance
        $currentYear = now()->year;
        
        // Paid leave calculations (Casual + Medical)
        $casualUsed = Leave::where('employee_id', $employee->id)
            ->where('leave_type', 'casual')
            ->whereYear('start_date', $currentYear)
            ->where('status', '!=', 'rejected')
            ->sum('total_days');
            
        $medicalUsed = Leave::where('employee_id', $employee->id)
            ->where('leave_type', 'medical')
            ->whereYear('start_date', $currentYear)
            ->where('status', '!=', 'rejected')
            ->sum('total_days');
            
        $companyHolidayUsed = Leave::where('employee_id', $employee->id)
            ->where('leave_type', 'company_holiday')
            ->whereYear('start_date', $currentYear)
            ->where('status', '!=', 'rejected')
            ->sum('total_days');
        
        // Unpaid leave calculations
        $personalUsed = Leave::where('employee_id', $employee->id)
            ->where('leave_type', 'personal')
            ->whereYear('start_date', $currentYear)
            ->where('status', '!=', 'rejected')
            ->sum('total_days');
        
        $paidLeaveTotal = 12; // Total paid leave per year
        $paidLeaveUsed = $casualUsed + $medicalUsed;
        $paidLeaveBalance = $paidLeaveTotal - $paidLeaveUsed;
        
        $leaveBalance = (object) [
            'paid_leave_total' => $paidLeaveTotal,
            'paid_leave_used' => $paidLeaveUsed,
            'paid_leave_balance' => $paidLeaveBalance,
            'casual_leave_used' => $casualUsed,
            'medical_leave_used' => $medicalUsed,
            'company_holiday_used' => $companyHolidayUsed,
            'personal_leave_used' => $personalUsed,
            'holiday_leave_used' => $companyHolidayUsed
        ];

        return view('leaves.create', compact('leaveTypes', 'leaveBalance'));
    }

    /**
     * Store a newly created leave
     */
    public function store(Request $request)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leave Management.create leave'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user = Auth::user();
        
        // Validate request
        $validated = $request->validate([
            'leave_type' => 'required|in:casual,medical,personal,company_holiday',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_half_day' => 'nullable|boolean',
            'reason' => 'required|string|max:500',
            'employee_id' => 'nullable|exists:employees,id'
        ]);

        // Determine employee_id
        if ($user->hasRole(['admin', 'hr']) && $request->has('employee_id')) {
            $employeeId = $request->employee_id;
        } else {
            $employee = Employee::where('user_id', $user->id)->first();
            if (!$employee) {
                return redirect()->back()->with('error', 'Employee profile not found.');
            }
            $employeeId = $employee->id;
        }

        // Automatically determine if leave is paid based on leave type
        $paidLeaveTypes = ['casual', 'medical', 'company_holiday'];
        $isPaid = in_array($validated['leave_type'], $paidLeaveTypes);

        // Calculate total days
        $startDate = new \DateTime($validated['start_date']);
        $endDate = new \DateTime($validated['end_date']);
        
        if ($request->is_half_day) {
            $totalDays = 0.5;
        } else {
            // Calculate business days (excluding weekends)
            $totalDays = 0;
            $interval = new \DateInterval('P1D');
            $dateRange = new \DatePeriod($startDate, $interval, $endDate->modify('+1 day'));
            
            foreach ($dateRange as $date) {
                // Skip weekends (Saturday = 6, Sunday = 0)
                if ($date->format('N') < 6) {
                    $totalDays++;
                }
            }
        }

        // Create leave
        $leave = Leave::create([
            'employee_id' => $employeeId,
            'leave_type' => $validated['leave_type'],
            'is_paid' => $isPaid,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_days' => $totalDays,
            'reason' => $validated['reason'],
            'status' => 'pending'
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Leave request submitted successfully!',
                'leave' => $leave
            ]);
        }

        return redirect()->route('leaves.index')->with('success', 'Leave request submitted successfully!');
    }

    /**
     * Display the specified leave
     */
    public function show(Leave $leave)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leave Management.view leave'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        return view('leaves.show', compact('leave'));
    }

    /**
     * Update the specified leave
     */
    public function update(Request $request, Leave $leave)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leave Management.edit leave'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $validated = $request->validate([
            'leave_type' => 'required|in:casual,medical,personal,company_holiday',
            'is_paid' => 'required|boolean',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_days' => 'required|numeric|min:0.5',
            'reason' => 'required|string|max:500',
            'status' => 'nullable|in:pending,approved,rejected'
        ]);

        $leave->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Leave updated successfully!',
                'leave' => $leave
            ]);
        }

        return redirect()->route('leaves.index')->with('success', 'Leave updated successfully!');
    }

    /**
     * Remove the specified leave
     */
    public function destroy(Leave $leave)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leave Management.delete leave'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $leave->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Leave deleted successfully!'
            ]);
        }

        return redirect()->route('leaves.index')->with('success', 'Leave deleted successfully!');
    }

    /**
     * Get paid leave balance for an employee
     */
    public function getPaidLeaveBalance($employeeId)
    {
        $currentYear = now()->year;
        $currentMonth = now()->month;
        
        // Get yearly paid leave count
        $yearlyUsed = Leave::where('employee_id', $employeeId)
            ->where('is_paid', true)
            ->whereYear('start_date', $currentYear)
            ->where('status', '!=', 'rejected')
            ->sum('total_days');
        
        // Get current month paid leave count
        $monthUsed = Leave::where('employee_id', $employeeId)
            ->where('is_paid', true)
            ->whereYear('start_date', $currentYear)
            ->whereMonth('start_date', $currentMonth)
            ->where('status', '!=', 'rejected')
            ->sum('total_days');
        
        return response()->json([
            'success' => true,
            'yearly_used' => $yearlyUsed,
            'yearly_total' => 12,
            'yearly_available' => 12 - $yearlyUsed,
            'month_used' => $monthUsed,
            'month_total' => 1,
            'month_available' => 1 - $monthUsed
        ]);
    }

    /**
     * Approve a leave
     */
    public function approve(Request $request, Leave $leave)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leave Management.approve leave'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $leave->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now()
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Leave approved successfully!',
                'leave' => $leave
            ]);
        }

        return redirect()->back()->with('success', 'Leave approved successfully!');
    }

    /**
     * Reject a leave
     */
    public function reject(Request $request, Leave $leave)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Leave Management.reject leave'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $leave->update([
            'status' => 'rejected',
            'rejected_by' => Auth::id(),
            'rejected_at' => now()
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Leave rejected successfully!',
                'leave' => $leave
            ]);
        }

        return redirect()->back()->with('success', 'Leave rejected successfully!');
    }
}
