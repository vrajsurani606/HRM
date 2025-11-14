<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function __construct()
    {
        // Apply permission middleware to all methods
        $this->middleware('permission:employees.manage');
        
        // Or apply to specific methods
        // $this->middleware('permission:employees.view')->only(['index', 'show']);
        // $this->middleware('permission:employees.create')->only(['create', 'store']);
        // $this->middleware('permission:employees.edit')->only(['edit', 'update']);
        // $this->middleware('permission:employees.delete')->only(['destroy']);
    }

    public function index()
    {
        // Method 1: Check permission in controller
        if (!auth()->user()->can('employees.view')) {
            abort(403, 'You do not have permission to view employees.');
        }

        // Method 2: Using gate
        $this->authorize('employees.view');

        // Method 3: Check role
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Admin access required.');
        }

        // Method 4: Check any role
        if (!auth()->user()->hasAnyRole(['admin', 'hr'])) {
            abort(403, 'Admin or HR access required.');
        }

        return view('employees.index');
    }

    public function create()
    {
        // Check permission before showing create form
        if (!auth()->user()->can('employees.create')) {
            return redirect()->route('employees.index')
                ->with('error', 'You do not have permission to create employees.');
        }

        return view('employees.create');
    }

    public function store(Request $request)
    {
        // Permission already checked by middleware
        // Your store logic here
        
        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }
}