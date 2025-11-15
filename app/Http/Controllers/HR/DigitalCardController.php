<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\DigitalCard;
use Illuminate\Http\Request;

class DigitalCardController extends Controller
{
    public function create(Employee $employee)
    {
        // Check if digital card already exists
        $digitalCard = $employee->digitalCard;
        
        return view('hr.employees.digital-card.create', [
            'employee' => $employee,
            'digitalCard' => $digitalCard,
            'page_title' => 'Digital Card - ' . $employee->name,
        ]);
    }

    public function store(Request $request, Employee $employee)
    {
        try {
            // Get all form data
            $data = $request->all();
            
            // Handle file uploads
            if ($request->hasFile('resume')) {
                $data['resume_path'] = $request->file('resume')->store('digital-cards/resumes', 'public');
            }

            if ($request->hasFile('gallery')) {
                $galleryFiles = [];
                foreach ($request->file('gallery') as $file) {
                    $galleryFiles[] = $file->store('digital-cards/gallery', 'public');
                }
                $data['gallery'] = $galleryFiles;
            }
            
            // Remove files from data array
            unset($data['resume'], $data['_token']);
            
            // Clean empty values
            $cleanData = [];
            foreach ($data as $key => $value) {
                if ($value !== null && $value !== '' && $value !== []) {
                    $cleanData[$key] = $value;
                }
            }
            
            // Create or update digital card
            $employee->digitalCard()->updateOrCreate(
                ['employee_id' => $employee->id],
                $cleanData
            );

            return redirect()->route('employees.index')->with('success', 'Digital card created successfully!');
            
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Failed to create digital card: ' . $e->getMessage()]);
        }
    }

    public function show(Employee $employee)
    {
        $digitalCard = $employee->digitalCard;
        
        if (!$digitalCard) {
            return redirect()->route('employees.digital-card.create', $employee)
                ->with('info', 'No digital card found. Please create one.');
        }

        return view('hr.employees.digital-card.show', [
            'employee' => $employee,
            'digitalCard' => $digitalCard,
            'page_title' => 'Digital Card - ' . $employee->name,
        ]);
    }
}