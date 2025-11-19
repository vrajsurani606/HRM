<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\DigitalCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DigitalCardController extends Controller
{
    public function create(Employee $employee)
    {
        // Check if digital card already exists
        $digitalCard = $employee->digitalCard;
        
        // If digital card exists and has basic data, redirect to view page
        if ($digitalCard && $digitalCard->full_name) {
            return redirect()->route('employees.digital-card.show', $employee)
                ->with('info', 'Digital card already exists. Showing card view.');
        }
        
        return view('hr.employees.digital-card.create', [
            'employee' => $employee,
            'digitalCard' => $digitalCard,
            'page_title' => 'Digital Card - ' . $employee->name,
        ]);
    }

    public function store(Request $request, Employee $employee)
    {
        // Validate the request
        $request->validate([
            'full_name' => 'required|string|max:255',
            'current_position' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'years_experience' => 'nullable|numeric|min:0',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        try {
            // Get all form data
            $data = $request->all();
            
            // Fix field name mapping
            if (isset($data['years_experience'])) {
                $data['years_of_experience'] = $data['years_experience'];
                unset($data['years_experience']);
            }
            
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
            
            // Process array fields
            $arrayFields = ['roles', 'education', 'certifications', 'achievements', 'projects', 'languages'];
            foreach ($arrayFields as $field) {
                if (isset($data[$field]) && is_array($data[$field])) {
                    // Filter out empty entries
                    $filtered = array_filter($data[$field], function($item) {
                        if (is_array($item)) {
                            return !empty(array_filter($item, function($v) { return !empty($v); }));
                        }
                        return !empty($item);
                    });
                    $data[$field] = array_values($filtered); // Re-index array
                }
            }
            
            // Map field names for backward compatibility
            if (isset($data['roles'])) {
                $data['previous_roles'] = $data['roles'];
                unset($data['roles']);
            }
            
            // Remove unwanted fields
            unset($data['resume'], $data['_token'], $data['_method']);
            
            // Clean empty values but keep arrays
            $cleanData = [];
            foreach ($data as $key => $value) {
                if ($value !== null && $value !== '' && !($value === [] && !in_array($key, $arrayFields))) {
                    $cleanData[$key] = $value;
                }
            }
            
            // Debug: Log the data being saved
            \Log::info('Digital Card Data to Save:', $cleanData);
            
            // Create or update digital card
            $digitalCard = $employee->digitalCard()->updateOrCreate(
                ['employee_id' => $employee->id],
                $cleanData
            );
            
            // Debug: Log success
            \Log::info('Digital Card Saved Successfully', ['id' => $digitalCard->id]);

            return redirect()->route('employees.digital-card.show', $employee)
                ->with('success', 'Digital card saved successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Digital Card Store Error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Failed to save digital card. Please try again.']);
        }
    }

    public function show(Employee $employee)
    {
        $digitalCard = $employee->digitalCard;
        
        if (!$digitalCard) {
            return redirect()->route('employees.digital-card.create', $employee)
                ->with('info', 'No digital card found. Please create one.');
        }

        // Process data for the digital card view
        $previous_roles = is_array($digitalCard->previous_roles) ? $digitalCard->previous_roles : [];
        $education = is_array($digitalCard->education) ? $digitalCard->education : [];
        $certifications = is_array($digitalCard->certifications) ? $digitalCard->certifications : [];
        $gallery = is_array($digitalCard->gallery) ? $digitalCard->gallery : [];
        $achievements = is_array($digitalCard->achievements) ? $digitalCard->achievements : [];
        $languages = is_array($digitalCard->languages) ? $digitalCard->languages : [];
        $projects = is_array($digitalCard->projects) ? $digitalCard->projects : [];
        $skills = !empty($digitalCard->skills) ? array_map('trim', explode(',', $digitalCard->skills)) : [];
        $hobbies = !empty($digitalCard->hobbies) ? array_map('trim', explode(',', $digitalCard->hobbies)) : [];

        // Social links
        $socials = [
            'linkedin' => $digitalCard->linkedin ?? '',
            'github' => $digitalCard->github ?? '',
            'twitter' => $digitalCard->twitter ?? '',
            'instagram' => $digitalCard->instagram ?? '',
            'facebook' => $digitalCard->facebook ?? '',
            'portfolio' => $digitalCard->portfolio ?? ''
        ];

        // Profile data with employee fallback
        $profile = [
            'name' => $digitalCard->full_name ?: ($employee->name ?? 'N/A'),
            'position' => $digitalCard->current_position ?: ($employee->position ?? 'N/A'),
            'company' => $digitalCard->company_name ?: 'Company Name',
            'email' => $digitalCard->email ?: ($employee->email ?? 'N/A'),
            'phone' => $digitalCard->phone ?: ($employee->mobile_no ?? 'N/A'),
            'location' => $digitalCard->location ?? 'N/A',
            'summary' => $digitalCard->summary ?? 'No summary available',
            'experience_years' => $digitalCard->years_of_experience ?: $digitalCard->experience_years ?: '0',
            'willing_to' => $digitalCard->willing_to ?? 'Open to opportunities'
        ];

        // Profile image with proper fallback
        $profile_image = 'blank_user.webp';
        if (!empty($gallery) && is_array($gallery)) {
            foreach ($gallery as $img) {
                if (file_exists(public_path('storage/' . $img))) {
                    $profile_image = 'storage/' . $img;
                    break;
                }
            }
        } elseif ($employee && $employee->photo_path && file_exists(public_path('storage/' . $employee->photo_path))) {
            $profile_image = 'storage/' . $employee->photo_path;
        }

        return view('digital-card', [
            'employee' => $employee,
            'digitalCard' => $digitalCard,
            'profile' => $profile,
            'previous_roles' => $previous_roles,
            'education' => $education,
            'certifications' => $certifications,
            'gallery' => $gallery,
            'achievements' => $achievements,
            'languages' => $languages,
            'projects' => $projects,
            'skills' => $skills,
            'hobbies' => $hobbies,
            'socials' => $socials,
            'profile_image' => $profile_image,
            'page_title' => 'Digital Card - ' . $employee->name,
        ]);
    }

    public function edit(Employee $employee)
    {
        $digitalCard = $employee->digitalCard;
        
        return view('hr.employees.digital-card.create', [
            'employee' => $employee,
            'digitalCard' => $digitalCard,
            'page_title' => 'Edit Digital Card - ' . $employee->name,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        // Validate the request
        $request->validate([
            'full_name' => 'required|string|max:255',
            'current_position' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'years_experience' => 'nullable|numeric|min:0',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        try {
            $digitalCard = $employee->digitalCard;
            if (!$digitalCard) {
                return redirect()->route('employees.digital-card.create', $employee)
                    ->with('error', 'Digital card not found.');
            }

            // Get all form data
            $data = $request->all();
            
            // Fix field name mapping
            if (isset($data['years_experience'])) {
                $data['years_of_experience'] = $data['years_experience'];
                unset($data['years_experience']);
            }
            
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
            
            // Process array fields
            $arrayFields = ['roles', 'education', 'certifications', 'achievements', 'projects', 'languages'];
            foreach ($arrayFields as $field) {
                if (isset($data[$field]) && is_array($data[$field])) {
                    // Filter out empty entries
                    $filtered = array_filter($data[$field], function($item) {
                        if (is_array($item)) {
                            return !empty(array_filter($item, function($v) { return !empty($v); }));
                        }
                        return !empty($item);
                    });
                    $data[$field] = array_values($filtered); // Re-index array
                }
            }
            
            // Map field names for backward compatibility
            if (isset($data['roles'])) {
                $data['previous_roles'] = $data['roles'];
                unset($data['roles']);
            }
            
            // Remove unwanted fields
            unset($data['resume'], $data['_token'], $data['_method']);
            
            // Clean empty values but keep arrays
            $cleanData = [];
            foreach ($data as $key => $value) {
                if ($value !== null && $value !== '' && !($value === [] && !in_array($key, $arrayFields))) {
                    $cleanData[$key] = $value;
                }
            }
            
            // Debug: Log the data being updated
            \Log::info('Digital Card Data to Update:', $cleanData);
            
            // Update digital card
            $digitalCard->update($cleanData);
            
            // Debug: Log success
            \Log::info('Digital Card Updated Successfully', ['id' => $digitalCard->id]);

            return redirect()->route('employees.digital-card.show', $employee)
                ->with('success', 'Digital card updated successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Digital Card Update Error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Failed to update digital card. Please try again.']);
        }
    }
}