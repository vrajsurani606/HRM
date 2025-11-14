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
        return view('hr.employees.create', [
            'page_title' => 'Add Employee',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:employees,email',
            'photo' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('employees', 'public');
        }
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
        return view('hr.employees.edit', [
            'employee'   => $employee,
            'page_title' => 'Edit Employee',
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
            'gender' => 'nullable|in:male,female,other',
            'position' => 'nullable|string|max:190',
            'experience_type' => 'nullable|in:Experienced,Fresher,Trainee,Intern,Contract',
            'joining_date' => 'nullable|date',
            'date_of_birth' => 'nullable|date',
            'current_offer_amount' => 'nullable|numeric|min:0',
            'previous_salary' => 'nullable|numeric|min:0',
            'previous_company_name' => 'nullable|string|max:190',
            'previous_designation' => 'nullable|string|max:190',
            'address' => 'nullable|string',
            'has_incentive' => 'nullable',
            'incentive_amount' => 'nullable|numeric|min:0',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data['has_incentive'] = $request->boolean('has_incentive');

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('employees', 'public');
        }
        unset($data['photo']);

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
        $letters = $employee->letters()->latest()->paginate(10);
        
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
            'content' => 'required|string',
            'type' => 'required|string|in:appointment,experience,relieving,other',
            'issue_date' => 'required|date',
        ]);

        $validated['reference_number'] = $this->generateLetterNumber();
        
        $employee->letters()->create($validated);

        return redirect()
            ->route('employees.letters.index', $employee)
            ->with('success', 'Letter created successfully');
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
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT) . '-' . $randomString;
    }
}
