<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PayrollController extends Controller
{
    public function index(Request $request): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Payroll Management.view payroll'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $query = Payroll::with('employee');

        // Filter by month
        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Default to current month/year if no filters provided
        if (!$request->filled('month') && !$request->filled('year')) {
            $query->where('month', date('F'));
            $query->where('year', date('Y'));
        }

        // Search
        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('employee', function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%");
            });
        }

        // Handle sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        // Validate sort column
        $allowedSorts = ['month', 'year', 'status', 'basic_salary', 'total_salary', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        
        // Validate sort direction
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }
        
        $perPage = $request->get('per_page', 10);
        $payrolls = $query->orderBy($sortBy, $sortDirection)
                          ->paginate($perPage)
                          ->appends($request->query());

        $employees = Employee::orderBy('name')->get();
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 
                   'July', 'August', 'September', 'October', 'November', 'December'];
        $years = range(date('Y'), date('Y') - 5);

        return view('payroll.index', compact('payrolls', 'employees', 'months', 'years'));
    }

    /**
     * Show bulk salary generation form
     */
    public function bulkForm(): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Payroll Management.bulk generate payroll'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $employees = Employee::orderBy('name')->get();
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 
                   'July', 'August', 'September', 'October', 'November', 'December'];
        $years = range(date('Y'), date('Y') - 5);
        return view('payroll.bulk', compact('employees', 'months', 'years'));
    }

    /**
     * Generate payrolls in bulk for selected/all employees for a month/year
     */
    public function bulkGenerate(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Payroll Management.bulk generate payroll'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $data = $request->validate([
            'month' => 'required|string',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'employee_ids' => 'nullable|array',
            'employee_ids.*' => 'integer|exists:employees,id',
            'all_employees' => 'nullable|boolean',
            'status' => 'nullable|in:pending,paid,cancelled',
            'payment_date' => 'nullable|date',
            'payment_method' => 'nullable|string',
        ]);

        $month = $data['month'];
        $year = (int)$data['year'];
        $status = $data['status'] ?? 'pending';
        $paymentDate = $data['payment_date'] ?? null;
        $paymentMethod = $data['payment_method'] ?? null;

        // Get employees based on selection
        $employeesQuery = Employee::query();
        if (!($data['all_employees'] ?? false)) {
            $ids = $data['employee_ids'] ?? [];
            if (empty($ids)) {
                return redirect()->back()->with('error', 'Please select at least one employee or check "All Employees"');
            }
            $employeesQuery->whereIn('id', $ids);
        }
        $employees = $employeesQuery->get();

        if ($employees->isEmpty()) {
            return redirect()->back()->with('error', 'No employees found to generate salaries');
        }

        $created = 0; 
        $updated = 0; 
        $skipped = 0;
        $errors = [];
        
        foreach ($employees as $emp) {
            try {
                $basicSalary = $emp->current_offer_amount ?? 0;
                
                // Skip if no salary defined
                if ($basicSalary <= 0) {
                    $skipped++;
                    $errors[] = "{$emp->name} ({$emp->code}): No basic salary defined";
                    continue;
                }
                
                // Days in month
                $monthNumber = date('n', strtotime($month . ' 1'));
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $year);

                // Leave breakdown (paid vs unpaid)
                $casualLeave = \App\Models\Leave::where('employee_id', $emp->id)
                    ->where('leave_type', 'casual')->where('status', 'approved')
                    ->whereYear('start_date', $year)->whereMonth('start_date', $monthNumber)
                    ->sum('total_days') ?? 0;
                $medicalLeave = \App\Models\Leave::where('employee_id', $emp->id)
                    ->where('leave_type', 'medical')->where('status', 'approved')
                    ->whereYear('start_date', $year)->whereMonth('start_date', $monthNumber)
                    ->sum('total_days') ?? 0;
                $holidayLeave = \App\Models\Leave::where('employee_id', $emp->id)
                    ->where('leave_type', 'holiday')->where('status', 'approved')
                    ->whereYear('start_date', $year)->whereMonth('start_date', $monthNumber)
                    ->sum('total_days') ?? 0;
                $personalLeave = \App\Models\Leave::where('employee_id', $emp->id)
                    ->where('leave_type', 'personal')->where('status', 'approved')
                    ->whereYear('start_date', $year)->whereMonth('start_date', $monthNumber)
                    ->sum('total_days') ?? 0;

                // Earnings (only basic by default for bulk)
                $allowances = 0; 
                $bonuses = 0; 
                $tax = 0;

                // Deductions: unpaid personal leave only
                $perDay = $daysInMonth > 0 ? ($basicSalary / $daysInMonth) : 0;
                $leaveDeduction = $perDay * $personalLeave;
                $otherDeductions = 0;
                $deductions = $leaveDeduction + $otherDeductions;

                $net = ($basicSalary + $allowances + $bonuses) - ($deductions + $tax);

                $existing = Payroll::where('employee_id', $emp->id)
                    ->where('month', $month)
                    ->where('year', $year)
                    ->first();

                $payload = [
                    'employee_id' => $emp->id,
                    'month' => $month,
                    'year' => $year,
                    'basic_salary' => $basicSalary,
                    'allowances' => $allowances,
                    'bonuses' => $bonuses,
                    'leave_deduction' => $leaveDeduction,
                    'leave_deduction_days' => $personalLeave,
                    'deductions' => $deductions,
                    'tax' => $tax,
                    'net_salary' => $net,
                    'payment_date' => $paymentDate,
                    'payment_method' => $paymentMethod,
                    'status' => $status,
                    'notes' => 'Generated via bulk salary generator',
                ];

                if ($existing) {
                    $existing->update($payload);
                    $updated++;
                } else {
                    Payroll::create($payload);
                    $created++;
                }
            } catch (\Exception $e) {
                \Log::error('Bulk payroll generation error for employee ' . $emp->id, [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                $errors[] = "{$emp->name} ({$emp->code}): {$e->getMessage()}";
            }
        }

        // Build success message
        $msg = "✅ Bulk salary generation completed for {$month} {$year}!";
        $details = [];
        
        if ($created > 0) {
            $details[] = "Created: {$created}";
        }
        if ($updated > 0) {
            $details[] = "Updated: {$updated}";
        }
        if ($skipped > 0) {
            $details[] = "Skipped: {$skipped}";
        }
        
        if (!empty($details)) {
            $msg .= " (" . implode(', ', $details) . ")";
        }

        // Add error summary if any
        if (!empty($errors)) {
            $errorCount = count($errors);
            $msg .= " ⚠️ {$errorCount} error(s) occurred.";
            
            // Log all errors
            \Log::warning('Bulk payroll generation errors', ['errors' => $errors]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true, 
                'message' => $msg,
                'stats' => [
                    'created' => $created,
                    'updated' => $updated,
                    'skipped' => $skipped,
                    'errors' => count($errors)
                ]
            ]);
        }
        
        return redirect()->route('payroll.index')->with('success', $msg);
    }

    public function create(): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Payroll Management.create payroll'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $employees = Employee::orderBy('name')->get();
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 
                   'July', 'August', 'September', 'October', 'November', 'December'];
        
        return view('payroll.create', compact('employees', 'months'));
    }
    
    public function store(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Payroll Management.create payroll'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|string',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'basic_salary' => 'required|numeric|min:0',
            'hra' => 'nullable|numeric|min:0',
            'medical_allowance' => 'nullable|numeric|min:0',
            'city_allowance' => 'nullable|numeric|min:0',
            'tiffin_allowance' => 'nullable|numeric|min:0',
            'assistant_allowance' => 'nullable|numeric|min:0',
            'dearness_allowance' => 'nullable|numeric|min:0',
            'bonuses' => 'nullable|numeric|min:0',
            'pf' => 'nullable|numeric|min:0',
            'professional_tax' => 'nullable|numeric|min:0',
            'tds' => 'nullable|numeric|min:0',
            'esic' => 'nullable|numeric|min:0',
            'security_deposit' => 'nullable|numeric|min:0',
            'leave_deduction' => 'nullable|numeric|min:0',
            'leave_deduction_days' => 'nullable|numeric|min:0',
            'payment_date' => 'nullable|date',
            'payment_method' => 'nullable|string',
            'status' => 'required|in:pending,paid,cancelled',
            'notes' => 'nullable|string',
        ]);

        try {
            // Check if payroll already exists for this employee, month, and year
            $existingPayroll = Payroll::where('employee_id', $request->employee_id)
                ->where('month', $request->month)
                ->where('year', $request->year)
                ->first();

            if ($existingPayroll) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Salary for this employee has already been generated for ' . $request->month . ' ' . $request->year . '. Please edit the existing record instead.'
                    ], 422);
                }

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Salary for this employee has already been generated for ' . $request->month . ' ' . $request->year . '. Please edit the existing record instead.');
            }

            // Calculate net salary with detailed breakdown
            $basicSalary = $request->basic_salary ?? 0;
            $hra = $request->hra ?? 0;
            $medicalAllowance = $request->medical_allowance ?? 0;
            $cityAllowance = $request->city_allowance ?? 0;
            $tiffinAllowance = $request->tiffin_allowance ?? 0;
            $assistantAllowance = $request->assistant_allowance ?? 0;
            $dearnessAllowance = $request->dearness_allowance ?? 0;
            $totalAllowances = $hra + $medicalAllowance + $cityAllowance + $tiffinAllowance + $assistantAllowance + $dearnessAllowance;
            $bonuses = $request->bonuses ?? 0;
            
            $pf = $request->pf ?? 0;
            $professionalTax = $request->professional_tax ?? 0;
            $tds = $request->tds ?? 0;
            $esic = $request->esic ?? 0;
            $securityDeposit = $request->security_deposit ?? 0;
            $leaveDeduction = $request->leave_deduction ?? 0;
            $leaveDeductionDays = $request->leave_deduction_days ?? 0;
            
            $totalDeductions = $pf + $professionalTax + $tds + $esic + $securityDeposit + $leaveDeduction;
            $netSalary = ($basicSalary + $totalAllowances + $bonuses) - $totalDeductions;

            $payroll = Payroll::create([
                'employee_id' => $request->employee_id,
                'month' => $request->month,
                'year' => $request->year,
                'basic_salary' => $basicSalary,
                'hra' => $hra,
                'dearness_allowance' => $dearnessAllowance,
                'city_allowance' => $cityAllowance,
                'medical_allowance' => $medicalAllowance,
                'tiffin_allowance' => $tiffinAllowance,
                'assistant_allowance' => $assistantAllowance,
                'allowances' => $totalAllowances,
                'bonuses' => $bonuses,
                'pf' => $pf,
                'professional_tax' => $professionalTax,
                'tds' => $tds,
                'esic' => $esic,
                'security_deposit' => $securityDeposit,
                'leave_deduction' => $leaveDeduction,
                'leave_deduction_days' => $leaveDeductionDays,
                'deductions' => $totalDeductions,
                'tax' => $professionalTax + $tds,
                'net_salary' => $netSalary,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'status' => $request->status,
                'notes' => $request->notes,
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Payroll created successfully!',
                    'payroll' => $payroll
                ]);
            }

            return redirect()->route('payroll.index')->with('success', 'Payroll created successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle duplicate entry error
            if ($e->getCode() == 23000) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Salary for this employee has already been generated for ' . $request->month . ' ' . $request->year . '. Please edit the existing record instead.'
                    ], 422);
                }

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Salary for this employee has already been generated for ' . $request->month . ' ' . $request->year . '. Please edit the existing record instead.');
            }

            // Handle other database errors
            \Log::error('Payroll creation error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while creating the payroll. Please try again.'
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while creating the payroll. Please try again.');
        }
    }

    public function edit($id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Payroll Management.edit payroll'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $payroll = Payroll::findOrFail($id);
        $employees = Employee::orderBy('name')->get();
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 
                   'July', 'August', 'September', 'October', 'November', 'December'];

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'payroll' => $payroll
            ]);
        }

        // Use the same create view for edit mode to avoid modal popups
        return view('payroll.create', compact('payroll', 'employees', 'months'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Payroll Management.edit payroll'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $payroll = Payroll::findOrFail($id);

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|string',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'basic_salary' => 'required|numeric|min:0',
            'hra' => 'nullable|numeric|min:0',
            'medical_allowance' => 'nullable|numeric|min:0',
            'city_allowance' => 'nullable|numeric|min:0',
            'tiffin_allowance' => 'nullable|numeric|min:0',
            'assistant_allowance' => 'nullable|numeric|min:0',
            'dearness_allowance' => 'nullable|numeric|min:0',
            'bonuses' => 'nullable|numeric|min:0',
            'pf' => 'nullable|numeric|min:0',
            'professional_tax' => 'nullable|numeric|min:0',
            'tds' => 'nullable|numeric|min:0',
            'esic' => 'nullable|numeric|min:0',
            'security_deposit' => 'nullable|numeric|min:0',
            'leave_deduction' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'payment_date' => 'nullable|date',
            'payment_method' => 'nullable|string',
            'status' => 'required|in:pending,paid,cancelled',
            'notes' => 'nullable|string',
        ]);

        // Calculate net salary with detailed breakdown
        $basicSalary = $request->basic_salary ?? 0;
        $hra = $request->hra ?? 0;
        $medicalAllowance = $request->medical_allowance ?? 0;
        $cityAllowance = $request->city_allowance ?? 0;
        $tiffinAllowance = $request->tiffin_allowance ?? 0;
        $assistantAllowance = $request->assistant_allowance ?? 0;
        $dearnessAllowance = $request->dearness_allowance ?? 0;
        $totalAllowances = $hra + $medicalAllowance + $cityAllowance + $tiffinAllowance + $assistantAllowance + $dearnessAllowance;
        $bonuses = $request->bonuses ?? 0;
        
        $pf = $request->pf ?? 0;
        $professionalTax = $request->professional_tax ?? 0;
        $tds = $request->tds ?? 0;
        $esic = $request->esic ?? 0;
        $securityDeposit = $request->security_deposit ?? 0;
        $leaveDeduction = $request->leave_deduction ?? 0;
        $deductions = $request->deductions ?? 0;
        $tax = $request->tax ?? 0;
        
        $totalDeductions = $pf + $professionalTax + $tds + $esic + $securityDeposit + $leaveDeduction + $deductions + $tax;
        $netSalary = ($basicSalary + $totalAllowances + $bonuses) - $totalDeductions;

        $payroll->update([
            'employee_id' => $request->employee_id,
            'month' => $request->month,
            'year' => $request->year,
            'basic_salary' => $basicSalary,
            'hra' => $hra,
            'medical_allowance' => $medicalAllowance,
            'city_allowance' => $cityAllowance,
            'tiffin_allowance' => $tiffinAllowance,
            'assistant_allowance' => $assistantAllowance,
            'dearness_allowance' => $dearnessAllowance,
            'allowances' => $totalAllowances,
            'bonuses' => $bonuses,
            'pf' => $pf,
            'professional_tax' => $professionalTax,
            'tds' => $tds,
            'esic' => $esic,
            'security_deposit' => $securityDeposit,
            'leave_deduction' => $leaveDeduction,
            'deductions' => $totalDeductions,
            'tax' => $professionalTax + $tds,
            'net_salary' => $netSalary,
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Payroll updated successfully!',
                'payroll' => $payroll
            ]);
        }

        return redirect()->route('payroll.index')->with('success', 'Payroll updated successfully!');
    }

    public function show($id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Payroll Management.view payroll'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $payroll = Payroll::with('employee')->findOrFail($id);
        return view('payroll.show', compact('payroll'));
    }

    public function destroy($id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Payroll Management.delete payroll'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $payroll = Payroll::findOrFail($id);
        $payroll->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Payroll deleted successfully!'
            ]);
        }

        return redirect()->route('payroll.index')->with('success', 'Payroll deleted successfully!');
    }

    /**
     * Get employee salary details for auto-fill
     */
    public function getEmployeeSalary(Request $request)
    {
        try {
            $employeeId = $request->employee_id;
            $month = $request->month ?? date('F');
            $year = $request->year ?? date('Y');

            $employee = Employee::findOrFail($employeeId);
            
            // Get employee's basic salary from current_offer_amount field
            $basicSalary = $employee->current_offer_amount ?? 0;
            
            // Calculate working days in month
            $monthNumber = date('n', strtotime($month . ' 1'));
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $year);
            
            // Get leave data from leave system
            // Casual Leave (Paid - NO deduction from salary)
            $casualLeaveUsed = \App\Models\Leave::where('employee_id', $employeeId)
                ->where('leave_type', 'casual')
                ->where('status', 'approved')
                ->whereYear('start_date', $year)
                ->whereMonth('start_date', $monthNumber)
                ->sum('total_days') ?? 0;
            
            // Medical Leave (Paid - NO deduction from salary)
            $medicalLeaveUsed = \App\Models\Leave::where('employee_id', $employeeId)
                ->where('leave_type', 'medical')
                ->where('status', 'approved')
                ->whereYear('start_date', $year)
                ->whereMonth('start_date', $monthNumber)
                ->sum('total_days') ?? 0;
            
            // Personal Leave (Unpaid - WILL BE DEDUCTED from salary)
            $personalLeaveUsed = \App\Models\Leave::where('employee_id', $employeeId)
                ->where('leave_type', 'personal')
                ->where('status', 'approved')
                ->whereYear('start_date', $year)
                ->whereMonth('start_date', $monthNumber)
                ->sum('total_days') ?? 0;
            
            // Holiday Leave (Company holidays)
            $holidayLeaveUsed = \App\Models\Leave::where('employee_id', $employeeId)
                ->where('leave_type', 'holiday')
                ->where('status', 'approved')
                ->whereYear('start_date', $year)
                ->whereMonth('start_date', $monthNumber)
                ->sum('total_days') ?? 0;
            
            // Total paid leaves (Casual + Medical) - NOT deducted
            $paidLeavesUsed = $casualLeaveUsed + $medicalLeaveUsed;
            
            // Only personal leave is deducted from salary
            $leaveDaysDeducted = $personalLeaveUsed;
            
            // Calculate per day salary based on current_offer_amount
            $perDaySalary = $daysInMonth > 0 ? $basicSalary / $daysInMonth : 0;
            
            // Calculate leave deduction (ONLY for personal leave)
            $leaveDeduction = $perDaySalary * $leaveDaysDeducted;
            
            // Calculate working days (excluding all leaves)
            $totalLeaveDays = $paidLeavesUsed + $leaveDaysDeducted + $holidayLeaveUsed;
            $workingDays = $daysInMonth - $totalLeaveDays;
            
            // Get leave balance for the year
            $leaveBalance = \App\Models\LeaveBalance::where('employee_id', $employeeId)
                ->where('year', $year)
                ->first();
            
            $paidLeaveBalance = $leaveBalance ? ($leaveBalance->paid_leave_balance ?? 12) : 12;
            
            \Log::info('Payroll Employee Data Loaded', [
                'employee_id' => $employeeId,
                'month' => $month,
                'year' => $year,
                'casual_leave' => $casualLeaveUsed,
                'medical_leave' => $medicalLeaveUsed,
                'personal_leave' => $personalLeaveUsed,
                'holiday_leave' => $holidayLeaveUsed,
            ]);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'emp_code' => $employee->code ?? '',
                    'bank_name' => $employee->bank_name ?? '',
                    'bank_account_no' => $employee->bank_account_no ?? '',
                    'ifsc_code' => $employee->bank_ifsc ?? '',
                    'basic_salary' => number_format($basicSalary, 2, '.', ''),
                    
                    // Leave data - keep decimals for accurate leave counting (e.g., 7.5 days)
                    'casual_leave_used' => (int)$casualLeaveUsed,
                    'medical_leave_used' => (int)$medicalLeaveUsed,
                    'personal_leave_used' => (float)$personalLeaveUsed, // Keep decimal (7.5, etc)
                    'holiday_leave_used' => (int)$holidayLeaveUsed,
                    'paid_leave_balance' => (int)$paidLeaveBalance,
                    
                    // Working days
                    'days_in_month' => (int)$daysInMonth,
                    'working_days' => (int)$workingDays,
                    'per_day_salary' => number_format($perDaySalary, 2, '.', ''),
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Payroll Employee Data Load Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error loading employee data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export payrolls to CSV
     */
    public function exportCsv(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Payroll Management.export payroll'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $query = Payroll::with('employee');

        // Apply same filters as index
        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('employee', function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%");
            });
        }

        $payrolls = $query->orderBy('created_at', 'desc')->get();

        $filename = 'payrolls_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($payrolls) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for Excel UTF-8 support
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV Headers
            fputcsv($file, [
                'Employee Code',
                'Employee Name',
                'Month',
                'Year',
                'Basic Salary',
                'HRA',
                'Medical Allowance',
                'City Allowance',
                'Tiffin Allowance',
                'Assistant Allowance',
                'Dearness Allowance',
                'Total Allowances',
                'Bonuses',
                'PF',
                'Professional Tax',
                'TDS',
                'ESIC',
                'Security Deposit',
                'Leave Deduction',
                'Leave Days',
                'Total Deductions',
                'Net Salary',
                'Payment Date',
                'Payment Method',
                'Status',
                'Notes'
            ]);

            foreach ($payrolls as $payroll) {
                $totalAllowances = ($payroll->hra ?? 0) + ($payroll->medical_allowance ?? 0) + 
                                  ($payroll->city_allowance ?? 0) + ($payroll->tiffin_allowance ?? 0) + 
                                  ($payroll->assistant_allowance ?? 0) + ($payroll->dearness_allowance ?? 0);
                $totalDeductions = ($payroll->pf ?? 0) + ($payroll->professional_tax ?? 0) + 
                                  ($payroll->tds ?? 0) + ($payroll->esic ?? 0) + 
                                  ($payroll->security_deposit ?? 0) + ($payroll->leave_deduction ?? 0);
                $netSalary = ($payroll->basic_salary + $totalAllowances + ($payroll->bonuses ?? 0)) - $totalDeductions;

                fputcsv($file, [
                    $payroll->employee->code ?? 'N/A',
                    $payroll->employee->name ?? 'N/A',
                    $payroll->month,
                    $payroll->year,
                    number_format($payroll->basic_salary, 2, '.', ''),
                    number_format($payroll->hra ?? 0, 2, '.', ''),
                    number_format($payroll->medical_allowance ?? 0, 2, '.', ''),
                    number_format($payroll->city_allowance ?? 0, 2, '.', ''),
                    number_format($payroll->tiffin_allowance ?? 0, 2, '.', ''),
                    number_format($payroll->assistant_allowance ?? 0, 2, '.', ''),
                    number_format($payroll->dearness_allowance ?? 0, 2, '.', ''),
                    number_format($totalAllowances, 2, '.', ''),
                    number_format($payroll->bonuses ?? 0, 2, '.', ''),
                    number_format($payroll->pf ?? 0, 2, '.', ''),
                    number_format($payroll->professional_tax ?? 0, 2, '.', ''),
                    number_format($payroll->tds ?? 0, 2, '.', ''),
                    number_format($payroll->esic ?? 0, 2, '.', ''),
                    number_format($payroll->security_deposit ?? 0, 2, '.', ''),
                    number_format($payroll->leave_deduction ?? 0, 2, '.', ''),
                    $payroll->leave_deduction_days ?? 0,
                    number_format($totalDeductions, 2, '.', ''),
                    number_format($netSalary, 2, '.', ''),
                    $payroll->payment_date ?? '',
                    $payroll->payment_method ?? '',
                    ucfirst($payroll->status),
                    $payroll->notes ?? ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export payrolls to Excel
     */
    public function exportExcel(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Payroll Management.export payroll'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $query = Payroll::with('employee');

        // Apply same filters as index
        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('employee', function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%");
            });
        }

        $payrolls = $query->orderBy('created_at', 'desc')->get();

        $filename = 'payrolls_' . date('Y-m-d_His') . '.xlsx';
        
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\PayrollExport($payrolls), 
            $filename
        );
    }
}

