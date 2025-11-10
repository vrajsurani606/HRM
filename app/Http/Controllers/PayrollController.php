<?php

namespace App\Http\Controllers;

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
}
