<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;

class SystemPasswordController extends Controller
{
    /**
     * Display all user passwords
     */
    public function index(Request $request)
    {
        // Check if user has permission
        if (!auth()->check() || !auth()->user()->can('Users Management.view user')) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $query = User::with('roles');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('mobile_no', 'like', '%' . $search . '%');
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('system-passwords.index', compact('users'));
    }

    /**
     * Display all employee passwords
     */
    public function employees(Request $request)
    {
        // Check if user has permission
        if (!auth()->check() || !auth()->user()->can('Employees Management.view employee')) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $query = Employee::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%')
                  ->orWhere('mobile_no', 'like', '%' . $search . '%');
            });
        }
        
        $employees = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('system-passwords.employees', compact('employees'));
    }

    /**
     * Display all company passwords
     */
    public function companies(Request $request)
    {
        // Check if user has permission
        if (!auth()->check() || !auth()->user()->can('Company Management.view company')) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $query = Company::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('company_email', 'like', '%' . $search . '%')
                  ->orWhere('company_employee_email', 'like', '%' . $search . '%');
            });
        }
        
        $companies = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('system-passwords.companies', compact('companies'));
    }
}
