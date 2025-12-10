<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeLetter;
use Illuminate\Http\Request;

class EmployeeLetterController extends Controller
{
    public function index()
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.letters'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $letters = EmployeeLetter::with('employee')->latest()->paginate(10);
        return view('employee-letters.index', compact('letters'));
    }

    public function create()
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.letters create'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $employees = Employee::select('id', 'name')->get();
        $letterTypes = EmployeeLetter::getLetterTypes();
        return view('employee-letters.create', compact('employees', 'letterTypes'));
    }

    public function store(Request $request)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.letters create'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'letter_type' => 'required|in:' . implode(',', array_keys(EmployeeLetter::getLetterTypes())),
            'letter_date' => 'required|date',
            'letter_note' => 'nullable|string',
            'letter_data' => 'nullable|array'
        ]);

        $validated['letter_no'] = EmployeeLetter::generateLetterNo($validated['letter_type'], $validated['employee_id']);
        EmployeeLetter::create($validated);

        return redirect()->route('employee-letters.index')->with('success', 'Letter created successfully');
    }

    public function show(EmployeeLetter $employeeLetter)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.letters view'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $employeeLetter->load('employee');
        return view('employee-letters.show', compact('employeeLetter'));
    }

    public function edit(EmployeeLetter $employeeLetter)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.letters edit'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $employees = Employee::select('id', 'name')->get();
        $letterTypes = EmployeeLetter::getLetterTypes();
        return view('employee-letters.edit', compact('employeeLetter', 'employees', 'letterTypes'));
    }

    public function update(Request $request, EmployeeLetter $employeeLetter)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.letters edit'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'letter_type' => 'required|in:' . implode(',', array_keys(EmployeeLetter::getLetterTypes())),
            'letter_date' => 'required|date',
            'letter_note' => 'nullable|string',
            'letter_data' => 'nullable|array'
        ]);

        $employeeLetter->update($validated);

        return redirect()->route('employee-letters.index')->with('success', 'Letter updated successfully');
    }

    public function destroy(EmployeeLetter $employeeLetter)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.letters delete'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $employeeLetter->delete();
        return redirect()->route('employee-letters.index')->with('success', 'Letter deleted successfully');
    }
}