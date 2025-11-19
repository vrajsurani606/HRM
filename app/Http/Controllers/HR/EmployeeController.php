<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Models\EmployeeLetter;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function __construct()
    {
        // Example Spatie permission guards (optional until roles are seeded)
        // $this->middleware('permission:employees.view')->only(['index','show']);
        // $this->middleware('permission:employees.create')->only(['create','store']);
        // $this->middleware('permission:employees.edit')->only(['edit','update']);
        // $this->middleware('permission:employees.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Employee::query())
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    return view('hr.employees.partials.actions', compact('row'))->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        $employees = Employee::orderByDesc('id')->paginate(12);
        return view('hr.employees.index', [
            'page_title' => 'Employee List',
            'employees'  => $employees,
        ]);
    }

    public function create()
    {
        $positions = ['Developer', 'Designer', 'Manager', 'HR', 'Sales', 'Marketing', 'Accountant', 'Other'];
        $nextCode = Employee::nextCode();
        
        return view('hr.employees.create', [
            'page_title' => 'Add Employee',
            'positions' => $positions,
            'nextCode' => $nextCode,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:employees,email',
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
        
        // Generate employee code
        $data['code'] = Employee::nextCode();
        
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
        }
        unset($data['password'], $data['photo']);
        
        Employee::create($data);
        return redirect()->route('employees.index')->with('success', 'Employee created');
    }

    public function show(Employee $employee)
    {
        return view('hr.employees.show', [
            'employee'   => $employee,
            'page_title' => 'Employee Details - ' . $employee->name,
        ]);
    }

    public function edit(Employee $employee)
    {
        $positions = ['Developer', 'Designer', 'Manager', 'HR', 'Sales', 'Marketing', 'Accountant', 'Other'];
        $incentiveOptions = ['YES', 'NO'];
        
        return view('hr.employees.edit', [
            'employee'   => $employee,
            'page_title' => 'Edit Employee',
            'positions' => $positions,
            'incentiveOptions' => $incentiveOptions,
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'code' => 'nullable|string|max:100',
            'status' => 'nullable|in:active,inactive',
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:employees,email,'.$employee->id,
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
        }
        unset($data['password'], $data['photo']);

        $employee->update($data);
        return redirect()->route('employees.index')->with('success', 'Employee updated');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return back()->with('success', 'Employee deleted');
    }

    /**
     * Display a listing of the employee's letters.
     */
    public function lettersIndex(Employee $employee)
    {
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
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'nullable|string',
        'subject' => 'nullable|string|max:255',
        'type' => 'required|string|in:appointment,offer,joining,confidentiality,impartiality,experience,agreement,relieving,confirmation,warning,termination,increment,internship_offer,internship_letter,other',
        'subject' => 'required_if:type,other|string|max:255',
        'content' => 'required_if:type,other,warning,termination|string',
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
                return view('hr.employees.letters.print', [
                    'employee' => $employee,
                    'letter' => $letter,
                    'company' => $company
                ]);
        }
    }
}
