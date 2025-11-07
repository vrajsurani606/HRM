<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
        return view('hr.employees.index', [
            'page_title' => 'Employee List',
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
