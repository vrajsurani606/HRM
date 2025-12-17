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
        // Enhanced server-side validation
        $request->validate([
            'full_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'current_position' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'years_experience' => 'required|numeric|min:0|max:50',
            'email' => 'required|email|max:255|unique:digital_cards,email,' . ($employee->digitalCard->id ?? 'NULL'),
            'phone' => 'required|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/',
            'location' => 'required|string|max:255',
            'summary' => 'required|string|min:50|max:1000',
            'skills' => 'required|string|max:500',
            'linkedin' => 'nullable|url|max:255|regex:/^https?:\/\/(www\.)?linkedin\.com\/.*/',
            'github' => 'nullable|url|max:255|regex:/^https?:\/\/(www\.)?github\.com\/.*/',
            'portfolio' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255|regex:/^https?:\/\/(www\.)?twitter\.com\/.*/',
            'instagram' => 'nullable|url|max:255|regex:/^https?:\/\/(www\.)?instagram\.com\/.*/',
            'facebook' => 'nullable|url|max:255|regex:/^https?:\/\/(www\.)?facebook\.com\/.*/',
            'hobbies' => 'nullable|string|max:300',
            'willing_to' => 'nullable|string|max:255',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'roles.*.position' => 'nullable|string|max:255',
            'roles.*.company' => 'nullable|string|max:255',
            'roles.*.duration' => 'nullable|string|max:100',
            'roles.*.description' => 'nullable|string|max:500',
            'education.*.degree' => 'nullable|string|max:255',
            'education.*.institution' => 'nullable|string|max:255',
            'education.*.year' => 'nullable|string|max:50',
            'education.*.description' => 'nullable|string|max:300',
            'certifications.*.name' => 'nullable|string|max:255',
            'certifications.*.issuer' => 'nullable|string|max:255',
            'certifications.*.date' => 'nullable|string|max:50',
            'projects.*.name' => 'nullable|string|max:255',
            'projects.*.description' => 'nullable|string|max:500',
            'projects.*.technologies' => 'nullable|string|max:255',
            'projects.*.duration' => 'nullable|string|max:100',
            'projects.*.link' => 'nullable|url|max:255',
            'languages.*.name' => 'nullable|string|max:100',
            'languages.*.proficiency' => 'nullable|string|max:50',
            'achievements.*.title' => 'nullable|string|max:255',
            'achievements.*.description' => 'nullable|string|max:500',
        ], [
            'full_name.required' => 'Full name is required.',
            'full_name.regex' => 'Full name should only contain letters and spaces.',
            'current_position.required' => 'Current position is required.',
            'company_name.required' => 'Company name is required.',
            'years_experience.required' => 'Years of experience is required.',
            'years_experience.max' => 'Years of experience cannot exceed 50 years.',
            'email.required' => 'Email address is required.',
            'email.unique' => 'This email is already used by another digital card.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Please enter a valid phone number.',
            'location.required' => 'Location is required.',
            'summary.required' => 'Professional summary is required.',
            'summary.min' => 'Professional summary must be at least 50 characters.',
            'skills.required' => 'Skills are required.',
            'linkedin.regex' => 'Please enter a valid LinkedIn URL.',
            'github.regex' => 'Please enter a valid GitHub URL.',
            'twitter.regex' => 'Please enter a valid Twitter URL.',
            'instagram.regex' => 'Please enter a valid Instagram URL.',
            'facebook.regex' => 'Please enter a valid Facebook URL.',
            'resume.mimes' => 'Resume must be a PDF, DOC, or DOCX file.',
            'resume.max' => 'Resume file size cannot exceed 10MB.',
            'gallery.*.mimes' => 'Gallery images must be JPEG, PNG, JPG, GIF, or WebP format.',
            'gallery.*.max' => 'Each gallery image cannot exceed 5MB.',
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
            
            // Create or update digital card
            $digitalCard = $employee->digitalCard()->updateOrCreate(
                ['employee_id' => $employee->id],
                $cleanData
            );

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
        
        // Fix data structure for proper display
        $previous_roles = array_map(function($role) {
            if (is_array($role)) {
                return [
                    'position' => $role['title'] ?? $role['position'] ?? 'Position',
                    'company' => $role['company'] ?? 'Company',
                    'duration' => $role['year'] ?? $role['duration'] ?? 'Duration',
                    'description' => $role['description'] ?? ''
                ];
            }
            return $role;
        }, $previous_roles);
        
        $education = array_map(function($edu) {
            if (is_array($edu)) {
                return [
                    'degree' => $edu['degree'] ?? 'Degree',
                    'institution' => $edu['institute'] ?? $edu['institution'] ?? 'Institution',
                    'year' => $edu['year'] ?? 'Year',
                    'description' => $edu['description'] ?? ''
                ];
            }
            return $edu;
        }, $education);
        
        $certifications = array_map(function($cert) {
            if (is_array($cert)) {
                return [
                    'name' => $cert['name'] ?? 'Certification',
                    'issuer' => $cert['authority'] ?? $cert['issuer'] ?? 'Issuer',
                    'date' => $cert['year'] ?? $cert['date'] ?? 'Date'
                ];
            }
            return $cert;
        }, $certifications);
        
        $projects = array_map(function($project) {
            if (is_array($project)) {
                return [
                    'name' => $project['name'] ?? 'Project',
                    'description' => $project['description'] ?? '',
                    'technologies' => $project['technologies'] ?? '',
                    'duration' => $project['duration'] ?? '',
                    'link' => $project['link'] ?? ''
                ];
            }
            return $project;
        }, $projects);

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
        $profile_image = asset('assets/images/blank_user.webp'); // Default fallback
        
        if (!empty($gallery) && is_array($gallery)) {
            foreach ($gallery as $img) {
                if (!empty($img)) {
                    $profile_image = asset('storage/' . $img);
                    break;
                }
            }
        } elseif ($employee && $employee->photo_path) {
            $profile_image = asset('storage/' . $employee->photo_path);
        }
        
        // Create a default avatar if no image exists
        if ($profile_image === asset('assets/images/blank_user.webp')) {
            $profile_image = 'data:image/svg+xml;base64,' . base64_encode('
                <svg width="200" height="200" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="200" height="200" fill="#F3F4F6"/>
                    <circle cx="100" cy="75" r="30" fill="#9CA3AF"/>
                    <path d="M100 120C130 120 155 140 155 165V200H45V165C45 140 70 120 100 120Z" fill="#9CA3AF"/>
                </svg>
            ');
        }

        return view('digital-card-premium', [
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
        // Enhanced server-side validation for update
        $request->validate([
            'full_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'current_position' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'years_experience' => 'required|numeric|min:0|max:50',
            'email' => 'required|email|max:255|unique:digital_cards,email,' . ($employee->digitalCard->id ?? 'NULL'),
            'phone' => 'required|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/',
            'location' => 'required|string|max:255',
            'summary' => 'required|string|min:50|max:1000',
            'skills' => 'required|string|max:500',
            'linkedin' => 'nullable|url|max:255|regex:/^https?:\/\/(www\.)?linkedin\.com\/.*/',
            'github' => 'nullable|url|max:255|regex:/^https?:\/\/(www\.)?github\.com\/.*/',
            'portfolio' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255|regex:/^https?:\/\/(www\.)?twitter\.com\/.*/',
            'instagram' => 'nullable|url|max:255|regex:/^https?:\/\/(www\.)?instagram\.com\/.*/',
            'facebook' => 'nullable|url|max:255|regex:/^https?:\/\/(www\.)?facebook\.com\/.*/',
            'hobbies' => 'nullable|string|max:300',
            'willing_to' => 'nullable|string|max:255',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'roles.*.position' => 'nullable|string|max:255',
            'roles.*.company' => 'nullable|string|max:255',
            'roles.*.duration' => 'nullable|string|max:100',
            'roles.*.description' => 'nullable|string|max:500',
            'education.*.degree' => 'nullable|string|max:255',
            'education.*.institution' => 'nullable|string|max:255',
            'education.*.year' => 'nullable|string|max:50',
            'education.*.description' => 'nullable|string|max:300',
            'certifications.*.name' => 'nullable|string|max:255',
            'certifications.*.issuer' => 'nullable|string|max:255',
            'certifications.*.date' => 'nullable|string|max:50',
            'projects.*.name' => 'nullable|string|max:255',
            'projects.*.description' => 'nullable|string|max:500',
            'projects.*.technologies' => 'nullable|string|max:255',
            'projects.*.duration' => 'nullable|string|max:100',
            'projects.*.link' => 'nullable|url|max:255',
            'languages.*.name' => 'nullable|string|max:100',
            'languages.*.proficiency' => 'nullable|string|max:50',
            'achievements.*.title' => 'nullable|string|max:255',
            'achievements.*.description' => 'nullable|string|max:500',
        ], [
            'full_name.required' => 'Full name is required.',
            'full_name.regex' => 'Full name should only contain letters and spaces.',
            'current_position.required' => 'Current position is required.',
            'company_name.required' => 'Company name is required.',
            'years_experience.required' => 'Years of experience is required.',
            'years_experience.max' => 'Years of experience cannot exceed 50 years.',
            'email.required' => 'Email address is required.',
            'email.unique' => 'This email is already used by another digital card.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Please enter a valid phone number.',
            'location.required' => 'Location is required.',
            'summary.required' => 'Professional summary is required.',
            'summary.min' => 'Professional summary must be at least 50 characters.',
            'skills.required' => 'Skills are required.',
            'linkedin.regex' => 'Please enter a valid LinkedIn URL.',
            'github.regex' => 'Please enter a valid GitHub URL.',
            'twitter.regex' => 'Please enter a valid Twitter URL.',
            'instagram.regex' => 'Please enter a valid Instagram URL.',
            'facebook.regex' => 'Please enter a valid Facebook URL.',
            'resume.mimes' => 'Resume must be a PDF, DOC, or DOCX file.',
            'resume.max' => 'Resume file size cannot exceed 10MB.',
            'gallery.*.mimes' => 'Gallery images must be JPEG, PNG, JPG, GIF, or WebP format.',
            'gallery.*.max' => 'Each gallery image cannot exceed 5MB.',
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
                // Delete old resume if exists
                if ($digitalCard->resume_path && file_exists(public_path('storage/' . $digitalCard->resume_path))) {
                    unlink(public_path('storage/' . $digitalCard->resume_path));
                }
                $data['resume_path'] = $request->file('resume')->store('digital-cards/resumes', 'public');
            }

            if ($request->hasFile('gallery')) {
                // Keep existing gallery and add new images
                $existingGallery = is_array($digitalCard->gallery) ? $digitalCard->gallery : [];
                $galleryFiles = $existingGallery;
                
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
            
            // Update digital card
            $digitalCard->update($cleanData);

            return redirect()->route('employees.digital-card.show', $employee)
                ->with('success', 'Digital card updated successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Digital Card Update Error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Failed to update digital card. Please try again.']);
        }
    }

    public function destroy(Employee $employee)
    {
        try {
            $digitalCard = $employee->digitalCard;
            if (!$digitalCard) {
                return redirect()->route('employees.index')
                    ->with('error', 'Digital card not found.');
            }

            $digitalCard->delete();

            return redirect()->route('employees.index')
                ->with('success', 'Digital card deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Digital Card Delete Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete digital card. Please try again.']);
        }
    }

    public function quickEdit(Request $request, Employee $employee)
    {
        $digitalCard = $employee->digitalCard;
        if (!$digitalCard) {
            return response()->json(['error' => 'Digital card not found'], 404);
        }

        // Validate allowed fields for quick edit
        $allowedFields = [
            'full_name', 'current_position', 'company_name', 'email', 'phone',
            'location', 'summary', 'skills', 'hobbies', 'linkedin', 'github',
            'twitter', 'instagram', 'facebook', 'portfolio', 'willing_to'
        ];

        try {
            // Check if it's a single field update or bulk update
            if ($request->has('field') && $request->has('value')) {
                // Single field update
                $field = $request->input('field');
                $value = $request->input('value');

                if (!in_array($field, $allowedFields)) {
                    return response()->json(['error' => 'Field not allowed for quick edit'], 400);
                }

                $digitalCard->update([$field => $value]);
                return response()->json(['success' => true, 'message' => 'Field updated successfully']);
            } else {
                // Bulk update - validate and update multiple fields
                $updateData = [];
                
                foreach ($allowedFields as $field) {
                    if ($request->has($field)) {
                        $value = $request->input($field);
                        if (!empty($value) || $value === '') { // Allow empty strings to clear fields
                            $updateData[$field] = $value;
                        }
                    }
                }

                if (empty($updateData)) {
                    return response()->json(['error' => 'No valid fields to update'], 400);
                }

                // Basic validation
                if (isset($updateData['email']) && !empty($updateData['email']) && !filter_var($updateData['email'], FILTER_VALIDATE_EMAIL)) {
                    return response()->json(['error' => 'Invalid email format'], 400);
                }

                $digitalCard->update($updateData);
                return response()->json(['success' => true, 'message' => 'Digital card updated successfully']);
            }
        } catch (\Exception $e) {
            \Log::error('Quick Edit Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update digital card'], 500);
        }
    }
    
    public function getCardData(Employee $employee)
    {
        $digitalCard = $employee->digitalCard;
        
        if (!$digitalCard) {
            return response()->json(['error' => 'Digital card not found'], 404);
        }
        
        // Return essential data for quick edit
        $data = [
            'full_name' => $digitalCard->full_name ?? '',
            'current_position' => $digitalCard->current_position ?? '',
            'company_name' => $digitalCard->company_name ?? '',
            'email' => $digitalCard->email ?? '',
            'phone' => $digitalCard->phone ?? '',
            'location' => $digitalCard->location ?? '',
            'summary' => $digitalCard->summary ?? '',
            'skills' => $digitalCard->skills ?? '',
            'hobbies' => $digitalCard->hobbies ?? '',
            'linkedin' => $digitalCard->linkedin ?? '',
            'github' => $digitalCard->github ?? '',
            'twitter' => $digitalCard->twitter ?? '',
            'instagram' => $digitalCard->instagram ?? '',
            'facebook' => $digitalCard->facebook ?? '',
            'portfolio' => $digitalCard->portfolio ?? '',
            'willing_to' => $digitalCard->willing_to ?? ''
        ];
        
        return response()->json(['success' => true, 'data' => $data]);
    }







    /**
     * Download digital card as HTML file
     */
    public function downloadHtml(Employee $employee)
    {
        $digitalCard = $employee->digitalCard;
        
        if (!$digitalCard) {
            return redirect()->back()->with('error', 'Digital card not found.');
        }

        // Get the same data as show method
        $previous_roles = is_array($digitalCard->previous_roles) ? $digitalCard->previous_roles : [];
        $education = is_array($digitalCard->education) ? $digitalCard->education : [];
        $certifications = is_array($digitalCard->certifications) ? $digitalCard->certifications : [];
        $gallery = is_array($digitalCard->gallery) ? $digitalCard->gallery : [];
        $achievements = is_array($digitalCard->achievements) ? $digitalCard->achievements : [];
        $languages = is_array($digitalCard->languages) ? $digitalCard->languages : [];
        $projects = is_array($digitalCard->projects) ? $digitalCard->projects : [];
        $skills = !empty($digitalCard->skills) ? array_map('trim', explode(',', $digitalCard->skills)) : [];
        $hobbies = !empty($digitalCard->hobbies) ? array_map('trim', explode(',', $digitalCard->hobbies)) : [];
        
        // Fix data structure for proper display
        $previous_roles = array_map(function($role) {
            if (is_array($role)) {
                return [
                    'position' => $role['title'] ?? $role['position'] ?? 'Position',
                    'company' => $role['company'] ?? 'Company',
                    'duration' => $role['year'] ?? $role['duration'] ?? 'Duration',
                    'description' => $role['description'] ?? ''
                ];
            }
            return $role;
        }, $previous_roles);
        
        $education = array_map(function($edu) {
            if (is_array($edu)) {
                return [
                    'degree' => $edu['degree'] ?? 'Degree',
                    'institution' => $edu['institute'] ?? $edu['institution'] ?? 'Institution',
                    'year' => $edu['year'] ?? 'Year',
                    'description' => $edu['description'] ?? ''
                ];
            }
            return $edu;
        }, $education);
        
        $certifications = array_map(function($cert) {
            if (is_array($cert)) {
                return [
                    'name' => $cert['name'] ?? 'Certification',
                    'issuer' => $cert['authority'] ?? $cert['issuer'] ?? 'Issuer',
                    'date' => $cert['year'] ?? $cert['date'] ?? 'Date'
                ];
            }
            return $cert;
        }, $certifications);
        
        $projects = array_map(function($project) {
            if (is_array($project)) {
                return [
                    'name' => $project['name'] ?? 'Project',
                    'description' => $project['description'] ?? '',
                    'technologies' => $project['technologies'] ?? '',
                    'duration' => $project['duration'] ?? '',
                    'link' => $project['link'] ?? ''
                ];
            }
            return $project;
        }, $projects);

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
                if (!empty($img) && file_exists(public_path('storage/' . $img))) {
                    $profile_image = asset('storage/' . $img);
                    break;
                }
            }
        } elseif ($employee && $employee->photo_path && file_exists(public_path('storage/' . $employee->photo_path))) {
            $profile_image = asset('storage/' . $employee->photo_path);
        } else {
            $profile_image = asset('assets/images/blank_user.webp');
        }

        // Render the downloadable HTML view
        $html = view('digital-card-premium', [
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
        ])->render();

        // Create filename
        $filename = str_replace(' ', '_', $profile['name']) . '_Digital_Card.html';

        // Return as download
        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Display employee ID card
     */
    public function showIdCard(Employee $employee)
    {
        // Check permissions
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.view employee'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        return view('hr.employees.id-card-professional', [
            'employee' => $employee,
            'page_title' => 'Employee ID Card - ' . $employee->name,
        ]);
    }

    /**
     * Display compact employee ID card
     */
    public function showCompactIdCard(Employee $employee)
    {
        // Check permissions
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.view employee'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        return view('hr.employees.id-card-compact', [
            'employee' => $employee,
            'page_title' => 'Compact ID Card - ' . $employee->name,
        ]);
    }

    /**
     * Generate ID card as PDF
     */
    public function downloadIdCardPdf(Employee $employee)
    {
        // Check permissions
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Employees Management.view employee'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        try {
            // Generate PDF using DomPDF
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('hr.employees.id-card-pdf', [
                'employee' => $employee,
                'page_title' => 'Employee ID Card - ' . $employee->name,
            ]);

            // Set paper size to ID card dimensions (85.6mm x 54mm)
            $pdf->setPaper([0, 0, 242.65, 153.07], 'landscape'); // Points conversion

            $fileName = 'ID_Card_' . str_replace(' ', '_', $employee->name) . '.pdf';

            return $pdf->download($fileName);
        } catch (\Exception $e) {
            \Log::error('ID Card PDF generation failed: ' . $e->getMessage());
            
            // Fallback to regular view with print styles
            return view('hr.employees.id-card-print', [
                'employee' => $employee,
                'page_title' => 'Employee ID Card - ' . $employee->name,
            ]);
        }
    }

    /**
     * Show ID Card showcase with examples
     */
    public function showcase()
    {
        // Get some sample employees for demonstration
        $employees = Employee::with('user')->take(10)->get();
        
        if ($employees->isEmpty()) {
            // Create sample data if no employees exist
            $employees = collect([
                (object) [
                    'id' => 1,
                    'name' => 'John Doe',
                    'email' => 'john.doe@company.com',
                    'position' => 'Software Engineer',
                    'department' => 'IT',
                    'mobile_no' => '+1 (555) 123-4567',
                    'code' => 'EMP-0001',
                    'joining_date' => now()->subYears(2),
                    'photo_path' => null,
                    'user' => null
                ],
                (object) [
                    'id' => 2,
                    'name' => 'Jane Smith',
                    'email' => 'jane.smith@company.com',
                    'position' => 'Product Manager',
                    'department' => 'Product',
                    'mobile_no' => '+1 (555) 987-6543',
                    'code' => 'EMP-0002',
                    'joining_date' => now()->subYears(1),
                    'photo_path' => null,
                    'user' => null
                ]
            ]);
        }
        
        return view('hr.employees.id-card-showcase', [
            'employees' => $employees,
            'page_title' => 'Employee ID Card Showcase'
        ]);
    }
}