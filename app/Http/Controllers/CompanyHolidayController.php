<?php

namespace App\Http\Controllers;

use App\Models\CompanyHoliday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyHolidayController extends Controller
{
    /**
     * Display a listing of company holidays
     */
    public function index()
    {
        // Permission check - all authenticated users can view holidays
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Company Holidays Management.view holiday'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $currentYear = now()->year;
        $holidays = CompanyHoliday::where('year', $currentYear)
            ->orderBy('date')
            ->get();

        return view('holidays.index', compact('holidays', 'currentYear'));
    }

    /**
     * Show the form for creating a new holiday
     */
    public function create()
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Company Holidays Management.create holiday'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        return view('holidays.create');
    }

    /**
     * Store a newly created holiday
     */
    public function store(Request $request)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Company Holidays Management.create holiday'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        $date = \Carbon\Carbon::parse($validated['date']);
        
        CompanyHoliday::create([
            'name' => $validated['name'],
            'date' => $date,
            'year' => $date->year,
            'description' => $validated['description'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('holidays.index')
            ->with('success', 'Holiday added successfully.');
    }

    /**
     * Show the form for editing the specified holiday
     */
    public function edit(CompanyHoliday $holiday)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Company Holidays Management.edit holiday'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        return view('holidays.edit', compact('holiday'));
    }

    /**
     * Update the specified holiday
     */
    public function update(Request $request, CompanyHoliday $holiday)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Company Holidays Management.edit holiday'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $date = \Carbon\Carbon::parse($validated['date']);
        
        $holiday->update([
            'name' => $validated['name'],
            'date' => $date,
            'year' => $date->year,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('holidays.index')
            ->with('success', 'Holiday updated successfully.');
    }

    /**
     * Remove the specified holiday
     */
    public function destroy(CompanyHoliday $holiday)
    {
        // Permission check
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Company Holidays Management.delete holiday'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $holiday->delete();

        return redirect()->route('holidays.index')
            ->with('success', 'Holiday deleted successfully.');
    }
}
