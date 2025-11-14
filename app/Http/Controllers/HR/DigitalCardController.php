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
        $validated = $request->validate([
            'full_name' => 'nullable|string|max:255',
            'current_position' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'years_experience' => 'nullable|numeric|min:0',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'linkedin' => 'nullable|url|max:255',
            'portfolio' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'github' => 'nullable|url|max:255',
            'location' => 'nullable|string',
            'skills' => 'nullable|string',
            'hobbies' => 'nullable|string',
            'summary' => 'nullable|string',
            'roles' => 'nullable|array',
            'roles.*.title' => 'nullable|string|max:255',
            'roles.*.company' => 'nullable|string|max:255',
            'roles.*.year' => 'nullable|string|max:255',
            'education' => 'nullable|array',
            'education.*.degree' => 'nullable|string|max:255',
            'education.*.institute' => 'nullable|string|max:255',
            'education.*.year' => 'nullable|string|max:255',
            'certifications' => 'nullable|array',
            'certifications.*.name' => 'nullable|string|max:255',
            'certifications.*.authority' => 'nullable|string|max:255',
            'certifications.*.year' => 'nullable|string|max:255',
            'achievements' => 'nullable|array',
            'achievements.*.title' => 'nullable|string|max:255',
            'achievements.*.description' => 'nullable|string',
            'achievements.*.year' => 'nullable|string|max:255',
            'languages' => 'nullable|array',
            'languages.*' => 'nullable|string|max:255',
            'projects' => 'nullable|array',
            'projects.*.name' => 'nullable|string|max:255',
            'projects.*.description' => 'nullable|string',
            'projects.*.link' => 'nullable|url|max:255',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:10240',
        ]);

        // Handle file uploads
        if ($request->hasFile('resume')) {
            $validated['resume_path'] = $request->file('resume')->store('digital-cards/resumes', 'public');
        }

        if ($request->hasFile('gallery')) {
            $galleryFiles = [];
            foreach ($request->file('gallery') as $file) {
                $galleryFiles[] = $file->store('digital-cards/gallery', 'public');
            }
            $validated['gallery'] = $galleryFiles;
        }

        // Clean up empty arrays
        $validated = array_filter($validated, function($value) {
            if (is_array($value)) {
                return !empty(array_filter($value, function($item) {
                    return is_array($item) ? !empty(array_filter($item)) : !empty($item);
                }));
            }
            return $value !== null && $value !== '';
        });
        
        // Create or update digital card
        $employee->digitalCard()->updateOrCreate(
            ['employee_id' => $employee->id],
            $validated
        );

        return redirect()->route('employees.index')->with('success', 'Digital card saved successfully!');
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