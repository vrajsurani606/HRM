<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
// use Yajra\DataTables\Facades\DataTables; // Commented out until package is installed
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Models\EmployeeLetter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function __construct()
    {
        // Permission guards are now implemented in each method
    }

    public function index(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.view employee'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        // Build query with filters
        $query = Employee::with('user.roles');
        
        // Check if user is restricted to own data only
        if (user_restricted_to_own_data()) {
            $authEmployee = get_auth_employee();
            if ($authEmployee) {
                $query->where('id', $authEmployee->id);
            } else {
                // No linked employee, show nothing
                $query->whereRaw('1 = 0');
            }
        }
        
        // Apply filters
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        
        if ($request->filled('code')) {
            $query->where('code', 'like', '%' . $request->code . '%');
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%')
                  ->orWhere('position', 'like', '%' . $search . '%')
                  ->orWhere('mobile_no', 'like', '%' . $search . '%');
            });
        }
        
        // Get per_page from request, default to 12
        $perPage = $request->get('per_page', 12);
        $employees = $query->orderByDesc('id')->paginate($perPage)->withQueryString();
        
        return view('hr.employees.index', [
            'page_title' => 'Employee List',
            'employees'  => $employees,
        ]);
    }

    public function create()
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.create employee'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $nextCode = Employee::nextCode();
        
        return view('hr.employees.create', [
            'page_title' => 'Add Employee',
            'positions' => config('positions.all'),
            'nextCode' => $nextCode,
        ]);
    }

    public function store(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.create employee'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $data = $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:employees,email',
            'personal_email' => 'nullable|email|max:255',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'marital_status' => 'nullable|in:single,married,other',
            'mobile_no' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'position' => 'nullable|string|max:190',
            'password' => 'nullable|string|min:6',
            'reference_name' => 'nullable|string|max:190',
            'reference_no' => 'nullable|string|max:50',
            'aadhaar_no' => 'nullable|string|max:20',
            'pan_no' => 'nullable|string|max:20',
            'highest_qualification' => 'nullable|string|max:190',
            'year_of_passing' => 'nullable|integer|min:1900|max:2100',
            'bank_name' => 'nullable|string|max:190',
            'bank_account_no' => 'nullable|string|max:50',
            'bank_ifsc' => 'nullable|string|max:20',
            'experience_type' => 'nullable|in:YES,NO',
            'previous_company_name' => 'nullable|string|max:190',
            'previous_designation' => 'nullable|string|max:190',
            'duration' => 'nullable|string|max:190',
            'reason_for_leaving' => 'nullable|string',
            'previous_salary' => 'nullable|numeric|min:0',
            'current_offer_amount' => 'nullable|numeric|min:0',
            'has_incentive' => 'nullable|in:YES,NO',
            'incentive_amount' => 'nullable|numeric|min:0',
            'joining_date' => 'nullable|date',
            'aadhaar_photo_front' => 'nullable|image|max:2048',
            'aadhaar_photo_back' => 'nullable|image|max:2048',
            'pan_photo' => 'nullable|image|max:2048',
            'cheque_photo' => 'nullable|image|max:2048',
            'marksheet_photo' => 'nullable|image|max:2048',
            'photo' => 'nullable|image|max:2048',
        ]);
        
        // Generate employee code
        $data['code'] = Employee::nextCode();
        
        // Capitalize PAN number
        if (!empty($data['pan_no'])) {
            $data['pan_no'] = strtoupper($data['pan_no']);
        }
        
        // Handle file uploads
        $fileFields = ['aadhaar_photo_front', 'aadhaar_photo_back', 'pan_photo', 'cheque_photo', 'marksheet_photo', 'photo'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                if ($field === 'photo') {
                    $data['photo_path'] = $request->file($field)->store('employees', 'public');
                } else {
                    $data[$field] = $request->file($field)->store('employees', 'public');
                }
            }
        }
        
        // Convert YES/NO to boolean for has_incentive
        if (isset($data['has_incentive'])) {
            $data['has_incentive'] = $data['has_incentive'] === 'YES' ? 1 : 0;
        }
        
        // Hash password if provided
        $password = $data['password'] ?? 'password123';
        if (!empty($data['password'])) {
            $data['password_hash'] = bcrypt($data['password']);
        }
        
        // Store plain password for employee
        $data['plain_password'] = $password;
        
        DB::transaction(function () use ($data, $password) {
            // Create user account first
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($password),
                'plain_password' => $password, // Store plain password
                'mobile_no' => $data['mobile_no'] ?? null,
                'address' => $data['address'] ?? null,
                'photo_path' => $data['photo_path'] ?? null,
            ]);
            
            // Skip role assignment if Spatie package not available
            try {
                $user->assignRole('employee');
            } catch (\Exception $e) {
                // Role assignment failed, continue without it
            }
            
            // Link user to employee
            $data['user_id'] = $user->id;
            
            unset($data['password'], $data['photo']);
            Employee::create($data);
        });
        
        return redirect()->route('employees.index')->with('success', 'Employee and user account created successfully');
    }

    public function storeFromLead(Request $request, $leadId)
    {
        $lead = HiringLead::findOrFail($leadId);
        
        $data = $request->validate([
            'code' => 'nullable|string|max:100',
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:employees,email',
            'personal_email' => 'nullable|email|max:255',
            'mobile_no' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'position' => 'nullable|string|max:190',
            'password' => 'nullable|string|min:6',
            'reference_name' => 'nullable|string|max:190',
            'reference_no' => 'nullable|string|max:50',
            'aadhaar_no' => 'nullable|string|max:20',
            'pan_no' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:190',
            'bank_account_no' => 'nullable|string|max:50',
            'bank_ifsc' => 'nullable|string|max:20',
            'experience_type' => 'nullable|in:YES,NO',
            'previous_company_name' => 'nullable|string|max:190',
            'previous_salary' => 'nullable|numeric|min:0',
            'current_offer_amount' => 'nullable|numeric|min:0',
            'has_incentive' => 'nullable|in:YES,NO',
            'incentive_amount' => 'nullable|numeric|min:0',
            'joining_date' => 'nullable|date',
            'aadhaar_photo_front' => 'nullable|image|max:2048',
            'aadhaar_photo_back' => 'nullable|image|max:2048',
            'pan_photo' => 'nullable|image|max:2048',
            'cheque_photo' => 'nullable|image|max:2048',
            'marksheet_photo' => 'nullable|image|max:2048',
            'photo' => 'nullable|image|max:2048',
        ]);
        
        $data['code'] = Employee::nextCode();
        
        // Capitalize PAN number
        if (!empty($data['pan_no'])) {
            $data['pan_no'] = strtoupper($data['pan_no']);
        }
        
        // Handle file uploads
        $fileFields = ['aadhaar_photo_front', 'aadhaar_photo_back', 'pan_photo', 'cheque_photo', 'marksheet_photo', 'photo'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                if ($field === 'photo') {
                    $data['photo_path'] = $request->file($field)->store('employees', 'public');
                } else {
                    $data[$field] = $request->file($field)->store('employees', 'public');
                }
            }
        }
        
        if (isset($data['has_incentive'])) {
            $data['has_incentive'] = $data['has_incentive'] === 'YES' ? 1 : 0;
        }
        
        $password = $data['password'] ?? 'password123';
        if (!empty($data['password'])) {
            $data['password_hash'] = bcrypt($data['password']);
        }
        
        // Store plain password for employee
        $data['plain_password'] = $password;
        
        DB::transaction(function () use ($data, $password, $lead) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($password),
                'plain_password' => $password, // Store plain password
                'mobile_no' => $data['mobile_no'] ?? null,
                'address' => $data['address'] ?? null,
                'photo_path' => $data['photo_path'] ?? null,
            ]);
            
            // Skip role assignment if Spatie package not available
            try {
                $user->assignRole('employee');
            } catch (\Exception $e) {
                // Role assignment failed, continue without it
            }
            
            $data['user_id'] = $user->id;
            
            unset($data['password'], $data['photo']);
            Employee::create($data);
            
            // Update lead status if field exists
            try {
                $lead->update(['status' => 'converted']);
            } catch (\Exception $e) {
                // Status field might not exist, continue
            }
        });
        
        return redirect()->route('employees.index')
            ->with('success', 'Lead converted to employee successfully! Email: ' . $data['email'] . ', Password: ' . $password);
    }

    public function show(Employee $employee)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.view employee'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        // Month/year filters (default to current)
        $month = (int) request('month', now()->month);
        $year  = (int) request('year', now()->year);

        // Attendance for selected month
        $attendances = Attendance::where('employee_id', $employee->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date')
            ->get();

        // Summary
        $presentDays = $attendances->where('status', 'present')->count();
        $absentDays  = $attendances->where('status', 'absent')->count();
        $lateEntries = 0; // No clear late rule in model; keep 0 for now

        $totalMinutes = 0;
        foreach ($attendances as $a) {
            if ($a->check_in && $a->check_out) {
                $in  = \Carbon\Carbon::parse($a->check_in);
                $out = \Carbon\Carbon::parse($a->check_out);
                $totalMinutes += $in->diffInMinutes($out);
            } elseif (!empty($a->total_working_hours)) {
                // Parse HH:MM:SS
                [$h,$m] = array_map('intval', explode(':', substr($a->total_working_hours,0,5)) + [0,0]);
                $totalMinutes += ($h * 60) + $m;
            }
        }
        $hours = floor($totalMinutes / 60);
        $mins  = $totalMinutes % 60;
        $hoursFormatted = sprintf('%02d:%02d', $hours, $mins);

        $attSummary = [
            'present' => $presentDays,
            'absent'  => $absentDays,
            'late'    => $lateEntries,
            'hours'   => $hoursFormatted,
        ];

        return view('hr.employees.show', [
            'employee'     => $employee,
            'page_title'   => 'Employee Details - ' . $employee->name,
            'attendances'  => $attendances,
            'attSummary'   => $attSummary,
            'month'        => $month,
            'year'         => $year,
        ]);
    }

    public function edit(Employee $employee)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.edit employee'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $employee->load('user');
        $incentiveOptions = ['YES', 'NO'];
        
        return view('hr.employees.edit', [
            'employee'   => $employee,
            'page_title' => 'Edit Employee',
            'positions' => config('positions.all'),
            'incentiveOptions' => $incentiveOptions,
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.edit employee'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $data = $request->validate([
            'code' => 'nullable|string|max:100',
            'status' => 'nullable|in:active,inactive',
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:employees,email,'.$employee->id,
            'personal_email' => 'nullable|email|max:255',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'marital_status' => 'nullable|in:single,married,other',
            'mother_name' => 'nullable|string|max:190',
            'mother_mobile_no' => 'nullable|string|max:20',
            'father_name' => 'nullable|string|max:190',
            'father_mobile_no' => 'nullable|string|max:20',
            'mobile_no' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'position' => 'nullable|string|max:190',
            'password' => 'nullable|string|min:6',
            'reference_name' => 'nullable|string|max:190',
            'reference_no' => 'nullable|string|max:50',
            'aadhaar_no' => 'nullable|string|max:20',
            'pan_no' => 'nullable|string|max:20',
            'highest_qualification' => 'nullable|string|max:190',
            'year_of_passing' => 'nullable|integer|min:1900|max:2100',
            'bank_name' => 'nullable|string|max:190',
            'bank_account_no' => 'nullable|string|max:50',
            'bank_ifsc' => 'nullable|string|max:20',
            'experience_type' => 'nullable|in:YES,NO',
            'previous_company_name' => 'nullable|string|max:190',
            'previous_designation' => 'nullable|string|max:190',
            'duration' => 'nullable|string|max:190',
            'reason_for_leaving' => 'nullable|string',
            'previous_salary' => 'nullable|numeric|min:0',
            'current_offer_amount' => 'nullable|numeric|min:0',
            'has_incentive' => 'nullable|in:YES,NO',
            'incentive_amount' => 'nullable|numeric|min:0',
            'joining_date' => 'nullable|date',
            'aadhaar_photo_front' => 'nullable|image|max:2048',
            'aadhaar_photo_back' => 'nullable|image|max:2048',
            'pan_photo' => 'nullable|image|max:2048',
            'cheque_photo' => 'nullable|image|max:2048',
            'marksheet_photo' => 'nullable|image|max:2048',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Capitalize PAN number
        if (!empty($data['pan_no'])) {
            $data['pan_no'] = strtoupper($data['pan_no']);
        }
        
        // Handle file uploads
        $fileFields = ['aadhaar_photo_front', 'aadhaar_photo_back', 'pan_photo', 'cheque_photo', 'marksheet_photo', 'photo'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                if ($field === 'photo') {
                    $data['photo_path'] = $request->file($field)->store('employees', 'public');
                } else {
                    $data[$field] = $request->file($field)->store('employees', 'public');
                }
            }
        }
        
        // Convert YES/NO to boolean for has_incentive
        if (isset($data['has_incentive'])) {
            $data['has_incentive'] = $data['has_incentive'] === 'YES' ? 1 : 0;
        }
        
        // Hash password if provided
        if (!empty($data['password'])) {
            $data['password_hash'] = bcrypt($data['password']);
            $data['plain_password'] = $data['password']; // Store plain password
        }
        
        DB::transaction(function () use ($employee, $data) {
            // Update associated user account if exists
            if ($employee->user) {
                $employee->user->update([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'mobile_no' => $data['mobile_no'] ?? null,
                    'address' => $data['address'] ?? null,
                    'photo_path' => $data['photo_path'] ?? $employee->user->photo_path,
                ]);
                
                // Update password if provided
                if (!empty($data['password'])) {
                    $employee->user->update([
                        'password' => bcrypt($data['password']),
                        'plain_password' => $data['password'], // Store plain password
                    ]);
                }
            }
            
            unset($data['password'], $data['photo']);
            $employee->update($data);
        });
        
        return redirect()->route('employees.index')->with('success', 'Employee and user account updated successfully');
    }

    public function destroy(Employee $employee)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.delete employee'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $employee->delete();
        return back()->with('success', 'Employee deleted');
    }

    /**
     * Toggle employee status between active and inactive.
     */
    public function toggleStatus(Request $request, $employeeId)
    {
        try {
            // Log the request
            \Log::info('Toggle status request received', [
                'employee_id' => $employeeId,
                'method' => $request->method(),
                'is_ajax' => $request->ajax(),
                'user_id' => auth()->id()
            ]);
            
            // Check authentication
            if (!auth()->check()) {
                \Log::warning('Toggle status: User not authenticated');
                return response()->json(['success' => false, 'message' => 'Not authenticated.'], 401);
            }
            
            // Find employee
            $employee = Employee::find($employeeId);
            if (!$employee) {
                \Log::error('Toggle status: Employee not found', ['employee_id' => $employeeId]);
                return response()->json(['success' => false, 'message' => 'Employee not found.'], 404);
            }
            
            // Check permissions
            $user = auth()->user();
            $hasPermission = true; // Default to true for authenticated users
            
            try {
                if (method_exists($user, 'hasRole') && method_exists($user, 'can')) {
                    $hasPermission = $user->hasRole('super-admin') || $user->can('Employees Management.edit employee');
                }
            } catch (\Exception $e) {
                \Log::warning('Permission check failed, allowing access: ' . $e->getMessage());
            }
            
            if (!$hasPermission) {
                \Log::warning('Toggle status: Permission denied', ['user_id' => $user->id]);
                return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
            
            // Toggle status
            $currentStatus = $employee->status ?? 'active';
            $newStatus = $currentStatus === 'active' ? 'inactive' : 'active';
            
            \Log::info('Updating employee status', [
                'employee_id' => $employee->id,
                'from' => $currentStatus,
                'to' => $newStatus
            ]);
            
            $employee->status = $newStatus;
            $employee->save();
            
            \Log::info('Employee status updated successfully', [
                'employee_id' => $employee->id,
                'new_status' => $newStatus
            ]);
            
            return redirect()->back()->with('success', 'Employee status updated to ' . $newStatus);
            
        } catch (\Exception $e) {
            \Log::error('Error toggling employee status', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of the employee's letters.
     */
    public function lettersIndex(Employee $employee)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.letters'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $letters = $employee->letters()->latest()->paginate(50);
        
        return view('hr.employees.letters.index', [
            'employee' => $employee,
            'letters' => $letters,
            'page_title' => 'Employee Letters - ' . $employee->name,
        ]);
    }
    
    /**
     * Show the form for creating a new letter.
     */
    public function createLetter(Employee $employee)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.letters create'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $referenceNumber = $this->generateLetterNumber();
        
        return view('hr.employees.letters.create', [
            'employee' => $employee,
            'referenceNumber' => $referenceNumber,
            'page_title' => 'Create New Letter - ' . $employee->name,
        ]);
    }

    /**
     * Store a newly created letter in storage.
     */
   public function storeLetter(Request $request, Employee $employee)
{
    if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.letters create'))) {
        return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
    }
    
    // Normalize fields that sometimes come as arrays from the UI
    if (is_array($request->input('subject'))) {
        $request->merge(['subject' => implode(' ', array_filter($request->input('subject')))]);
    }
    if (is_array($request->input('content'))) {
        $request->merge(['content' => implode("\n\n", array_filter($request->input('content')))]);
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'type' => 'required|string|in:appointment,offer,joining,confidentiality,impartiality,experience,agreement,relieving,confirmation,warning,termination,increment,internship_offer,internship_letter,other',
        'subject' => 'nullable|string|max:255',
        'content' => 'nullable|string|max:10000',
        'use_default_content' => 'nullable|boolean',
        'issue_date' => 'required|date',
        'reference_number' => 'required|string|unique:employee_letters,reference_number',
        'notes' => 'nullable|string',
        'monthly_salary' => 'nullable|numeric|min:0',
        'annual_ctc' => 'nullable|numeric|min:0',
        'reporting_manager' => 'nullable|string|max:190',
        'working_hours' => 'nullable|string|max:190',
        'date_of_joining' => 'nullable|date',
        'probation_period' => 'nullable',
        'salary_increment' => 'nullable',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'termination_end_date' => 'nullable|date',
        'termination_end_date' => 'nullable|date',
        'increment_amount' => 'nullable|numeric|min:0',
        'increment_effective_date' => 'nullable|date',
        'internship_position' => 'nullable|string|max:190',
        'internship_start_date' => 'nullable|date',
        'internship_end_date' => 'nullable|date|after_or_equal:internship_start_date',
        'internship_address' => 'nullable|string',
        'warning_content' => 'nullable|string',
    ]);

    try {
        // If reference number is not provided, generate one
        if (empty($validated['reference_number'])) {
            $validated['reference_number'] = $this->generateLetterNumber();
        }
        
        // Convert arrays to JSON strings for database storage
        if (isset($validated['probation_period']) && is_array($validated['probation_period'])) {
            $validated['probation_period'] = json_encode(array_filter($validated['probation_period']));
        }
        
        if (isset($validated['salary_increment']) && is_array($validated['salary_increment'])) {
            $validated['salary_increment'] = json_encode(array_filter($validated['salary_increment']));
        }
        
        // Handle termination letter end_date mapping
        if ($validated['type'] === 'termination' && isset($validated['termination_end_date'])) {
            $validated['end_date'] = $validated['termination_end_date'];
            unset($validated['termination_end_date']);
        }
        
        // Set the created_by field
        $validated['created_by'] = auth()->id();
        
        // Create the letter
        $letter = $employee->letters()->create($validated);

        return response()->json([
            'success' => true,
            'redirect' => route('employees.letters.index', $employee)
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error saving letter: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        return response()->json([
            'success' => false,
            'message' => 'Failed to save letter. ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Generate a unique letter number.
     */
    public function generateLetterNumber()
    {
        $prefix = 'LTR-' . date('Y') . '-';
        $latest = \App\Models\EmployeeLetter::where('reference_number', 'like', $prefix . '%')
            ->orderBy('reference_number', 'desc')
            ->first();

        $number = $latest ? (int) str_replace($prefix, '', $latest->reference_number) + 1 : 1;
        
        // Generate a more unique reference number with random string
        $randomString = strtoupper(Str::random(3));
        $referenceNumber = $prefix . str_pad($number, 4, '0', STR_PAD_LEFT) . '-' . $randomString;
        
        // Return JSON response for AJAX calls
        if (request()->ajax()) {
            return response()->json(['reference_number' => $referenceNumber]);
        }
        
        return $referenceNumber;
    }
    
    /**
     * Display a specific letter (simple view placeholder).
     */
    public function viewLetter(Employee $employee, EmployeeLetter $letter)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.letters view'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        return view('hr.employees.letters.print', [
            'employee' => $employee,
            'letter' => $letter,
        ]);
    }

    /**
     * Show the form for editing a letter.
     */
    public function editLetter(Employee $employee, EmployeeLetter $letter)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.letters edit'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        return view('hr.employees.letters.create', [
            'employee' => $employee,
            'letter' => $letter,
            'referenceNumber' => $letter->reference_number,
            'page_title' => 'Edit Letter - ' . $employee->name,
        ]);
    }

    /**
     * Update an existing letter.
     */
    public function updateLetter(Request $request, Employee $employee, EmployeeLetter $letter)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.letters edit'))) {
            return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
        }
        
        // Normalize potential array inputs
        if (is_array($request->input('subject'))) {
            $request->merge(['subject' => implode(' ', array_filter($request->input('subject')))]);
        }
        if (is_array($request->input('content'))) {
            $request->merge(['content' => implode("\n\n", array_filter($request->input('content')))]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:appointment,offer,joining,confidentiality,impartiality,experience,agreement,relieving,confirmation,warning,termination,increment,internship_offer,internship_letter,other',
            'subject' => 'nullable|string|max:255',
            'content' => 'nullable|string|max:10000',
            'use_default_content' => 'nullable|boolean',
            'issue_date' => 'required|date',
            'reference_number' => 'required|string|unique:employee_letters,reference_number,' . $letter->id,
            'notes' => 'nullable|string',
            'monthly_salary' => 'nullable|numeric|min:0',
            'annual_ctc' => 'nullable|numeric|min:0',
            'reporting_manager' => 'nullable|string|max:190',
            'working_hours' => 'nullable|string|max:190',
            'date_of_joining' => 'nullable|date',
            'probation_period' => 'nullable',
            'salary_increment' => 'nullable',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'increment_amount' => 'nullable|numeric|min:0',
            'increment_effective_date' => 'nullable|date',
            'internship_position' => 'nullable|string|max:190',
            'internship_start_date' => 'nullable|date',
            'internship_end_date' => 'nullable|date|after_or_equal:internship_start_date',
            'internship_address' => 'nullable|string',
            'warning_content' => 'nullable|string',
        ]);

        try {
            if (isset($validated['probation_period']) && is_array($validated['probation_period'])) {
                $validated['probation_period'] = json_encode(array_filter($validated['probation_period']));
            }
            if (isset($validated['salary_increment']) && is_array($validated['salary_increment'])) {
                $validated['salary_increment'] = json_encode(array_filter($validated['salary_increment']));
            }
            
            // Handle termination letter end_date mapping
            if ($validated['type'] === 'termination' && isset($validated['termination_end_date'])) {
                $validated['end_date'] = $validated['termination_end_date'];
                unset($validated['termination_end_date']);
            }

            $letter->update($validated);

            return response()->json([
                'success' => true,
                'redirect' => route('employees.letters.index', $employee)
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating letter: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update letter. ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified letter from storage.
     */
    public function destroyLetter(Employee $employee, EmployeeLetter $letter)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.letters delete'))) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $letter->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('employees.letters.index', $employee)->with('success', 'Letter deleted');
    }
    // public function print(Employee $employee, EmployeeLetter $letter)
    // {
    //     $company = "Chaitri"; // or however you get company info
    //     dd($letter , $employee);

    //     if ($letter->type == 'offer') {
    //           $offer = $letter->offerLetter;
    //     if (!$offer) {
    //         // First time: capture details
    //         return redirect()->route('hiring.offer.create', $lead->id)
    //             ->with('info', 'Please fill offer letter details first.');
    //     }

    //     $probation = $offer->probation_period;
    //     $salary_increment = $offer->salary_increment;
    //     $probation_lines = array_values(array_filter(preg_split('/\r\n|\r|\n/', (string)($probation ?? '')), function($v){ return trim($v) !== ''; }));
    //     $salary_lines = array_values(array_filter(preg_split('/\r\n|\r|\n/', (string)($salary_increment ?? '')), function($v){ return trim($v) !== ''; }));
    //     $break_after = (count($probation_lines) > 5 || count($salary_lines) > 5);
    //     $joining = [
    //         'date_of_joining' => optional($offer->date_of_joining)->format('d-m-Y'),
    //         'reporting_person' => $offer->reporting_manager,
    //     ];

    //     return view('hr.hiring.print_offerletter', compact('lead','offer','probation','salary_increment','joining','probation_lines','salary_lines','break_after'));
   
    //     }else{
    //         return view('hr.employees.letters.print', compact('employee', 'letter', 'company'));
    //     }
    // }

    public function print(Employee $employee, EmployeeLetter $letter)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.letters print'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $company = json_decode(json_encode([
            'name' => 'CHITRI ENLARGE SOFT IT HUB PVT. LTD.',
            'address' => 'Shop No. 28, Shagun Building, NH-4, Old Mumbai-Pune Highway, Dehu Road, Kiwale, Dist. Pune - 412101',
            'phone' => '+91 72763 23999',
            'email' => 'info@ceihpl.com',
            'website' => 'www.ceihpl.com',
        ]));

        // Route to specific templates based on letter type
        switch ($letter->type) {
            case 'agreement':
                return redirect(asset('public/letters/Agreement.pdf'));
                
            case 'offer':
                $lead = $employee;
                $offer = $letter;
                $probation = $letter->probation_period;
                $salary_increment = $letter->salary_increment;
                $probation_lines = array_values(array_filter(preg_split('/\r\n|\r|\n/', (string)($probation ?? '')), function($v){ return trim($v) !== ''; }));
                $salary_lines = array_values(array_filter(preg_split('/\r\n|\r|\n/', (string)($salary_increment ?? '')), function($v){ return trim($v) !== ''; }));
                $break_after = (count($probation_lines) > 5 || count($salary_lines) > 5);
                $joining = [
                    'date_of_joining' => optional($offer->date_of_joining)->format('d-m-Y'),
                    'reporting_person' => $offer->reporting_manager,
                ];
                return view('hr.hiring.print_offerletter', compact('lead','offer','probation','salary_increment','joining','probation_lines','salary_lines','break_after'));
                
            default:
                // For other letter types, use the standard print view
                // Allow tuning offsets for background header/footer via query
                $screenTop = (int) request()->query('screen_top', 260);
                $screenBottom = (int) request()->query('screen_bottom', 120);
                $printTop = (int) request()->query('print_top', 60);
                $printBottom = (int) request()->query('print_bottom', 35);
                return view('hr.employees.letters.print', [
                    'employee' => $employee,
                    'letter' => $letter,
                    'company' => $company,
                    'screen_top_px' => $screenTop,
                    'screen_bottom_px' => $screenBottom,
                    'print_top_mm' => $printTop,
                    'print_bottom_mm' => $printBottom,
                ]);
        }
    }
}
