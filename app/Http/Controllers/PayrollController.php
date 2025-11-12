<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PayrollController extends Controller
{
    public function index(): View
    {
        return view('payroll.index');
    }

    public function create(): View
    {
        return view('payroll.create');
    }
    
    public function store(Request $request)
    {
        // Handle form submission
        return redirect()->route('payroll.index')->with('success', 'Payroll entry created successfully');
    }
}
