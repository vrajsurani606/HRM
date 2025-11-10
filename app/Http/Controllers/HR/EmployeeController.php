<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;

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
        if ($employees->total() === 0) {
            $demo = collect([
                [
                    'experience_type' => 'Full - Time',
                    'photo_path' => null,
                    'name' => 'Dipesh Vasoya',
                    'email' => 'dipeshvasoya22@gmail.com',
                    'position' => 'Sr. UI/UX Designer',
                    'gender' => 'male',
                    'code' => 'ABDPF1835R',
                    'current_offer_amount' => 27000,
                    'joining_date' => Carbon::parse('2025-02-23'),
                ],
                [
                    'experience_type' => 'Internship',
                    'photo_path' => null,
                    'name' => 'Anju Tarak Ram',
                    'email' => 'ToddReed@armyscp.com',
                    'position' => 'Sr. Tele caller',
                    'gender' => 'female',
                    'code' => 'ABDPF1835R',
                    'current_offer_amount' => 27000,
                    'joining_date' => Carbon::parse('2025-02-23'),
                ],
                [
                    'experience_type' => 'Full - Time',
                    'photo_path' => null,
                    'name' => 'Nehal Ashvin Bhai Gajera',
                    'email' => 'gajeranehal9@gmail.com',
                    'position' => 'Sr. Web Developer',
                    'gender' => 'female',
                    'code' => 'ABDPF1835R',
                    'current_offer_amount' => 27000,
                    'joining_date' => Carbon::parse('2025-02-23'),
                ],
                [
                    'experience_type' => 'Remote',
                    'photo_path' => null,
                    'name' => 'Savalaiya Krupali Dilipbhai',
                    'email' => 'k@gmail.com',
                    'position' => 'Jr. UI/UX Designer',
                    'gender' => 'female',
                    'code' => 'ABDPF1835R',
                    'current_offer_amount' => 27000,
                    'joining_date' => Carbon::parse('2025-02-23'),
                ],
                [
                    'experience_type' => 'Internship',
                    'photo_path' => null,
                    'name' => 'Vaghani Pruthvi Vijaybhai',
                    'email' => 'pruthvivaghani02@gmail.com',
                    'position' => 'Jr. Web Developer',
                    'gender' => 'male',
                    'code' => 'ABDPF1835R',
                    'current_offer_amount' => 27000,
                    'joining_date' => Carbon::parse('2025-02-23'),
                ],
                [
                    'experience_type' => 'Freelance',
                    'photo_path' => null,
                    'name' => 'Vaadhavana Nikunj Hareshbhai',
                    'email' => 'nikunjvadhavana3@gmail.com',
                    'position' => 'Jr. Web Developer',
                    'gender' => 'male',
                    'code' => 'ABDPF1835R',
                    'current_offer_amount' => 27000,
                    'joining_date' => Carbon::parse('2025-02-23'),
                ],
            ])->map(function ($a) {
                // cast to object-like for Blade access
                return (object) $a;
            });

            $employees = new LengthAwarePaginator(
                $demo,
                $demo->count(),
                12,
                1,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }
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
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:employees,email,'.$employee->id,
            'photo' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('employees', 'public');
        }
        $employee->update($data);
        return redirect()->route('employees.index')->with('success', 'Employee updated');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return back()->with('success', 'Employee deleted');
    }
}
