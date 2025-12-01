<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company as CompanyModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CompanyController extends Controller
{
    public function index(Request $request): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Companies Management.view company'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $query = CompanyModel::query();
        
        // Handle sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        // Validate sort column
        $allowedSorts = ['company_name', 'gst_no', 'contact_person_name', 'contact_person_mobile', 'company_email', 'unique_code', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        
        // Validate sort direction
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        // Filter by company name
        if ($request->filled('company_name')) {
            $query->where('company_name', 'like', '%' . $request->company_name . '%');
        }

        // Filter by GST number
        if ($request->filled('gst_no')) {
            $query->where('gst_no', 'like', '%' . $request->gst_no . '%');
        }

        // Filter by contact person
        if ($request->filled('contact_person')) {
            $query->where('contact_person_name', 'like', '%' . $request->contact_person . '%');
        }

        // General search across multiple fields
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('company_name', 'like', '%' . $search . '%')
                  ->orWhere('gst_no', 'like', '%' . $search . '%')
                  ->orWhere('contact_person_name', 'like', '%' . $search . '%')
                  ->orWhere('contact_person_mobile', 'like', '%' . $search . '%')
                  ->orWhere('company_email', 'like', '%' . $search . '%')
                  ->orWhere('unique_code', 'like', '%' . $search . '%');
            });
        }

        // Apply sorting and pagination
        $perPage = $request->get('per_page', 10);
        $companies = $query->orderBy($sortBy, $sortDirection)->paginate($perPage)->appends($request->query());

        return view('companies.index', compact('companies'));
    }

    public function create(): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Companies Management.create company'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $latestCompany = CompanyModel::latest('id')->first();
        $nextId = $latestCompany ? $latestCompany->id + 1 : 1;
        $nextCode = 'CMS/COM/' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
        
        return view('companies.create', ['nextCode' => $nextCode]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Companies Management.create company'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:190'],
            'gst_no' => ['nullable', 'string', 'max:50', 'regex:/^[0-9A-Z]{15}$/'],
            'pan_no' => ['nullable', 'string', 'max:20', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'],
            'company_address' => ['required', 'string', 'max:500'],
            'state' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:50'],
            'contact_person_name' => ['required', 'string', 'max:100'],
            'contact_person_mobile' => ['required', 'string', 'regex:/^[6-9]\d{9}$/'],
            'contact_person_position' => ['required', 'string', 'max:100'],
            'company_email' => ['required', 'email', 'max:100', 'unique:companies,company_email'],
            'company_password' => ['required', 'string', 'min:6', 'confirmed'],
            'company_phone' => ['nullable', 'string', 'regex:/^[0-9+\-\s]{10,15}$/'],
            'company_type' => ['required', 'string', 'max:50'],
            'other_details' => ['nullable', 'string', 'max:1000'],
            'company_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'sop_upload' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'quotation_upload' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png', 'max:5120'],
            'scope_link' => ['nullable', 'url', 'max:255'],
            'company_employee_email' => ['nullable', 'email', 'max:100', 'different:company_email'],
            'person_name_1' => ['required', 'string', 'max:100'],
            'person_number_1' => ['required', 'string', 'regex:/^[6-9]\d{9}$/'],
            'person_position_1' => ['required', 'string', 'max:100'],
            'person_name_2' => ['nullable', 'string', 'max:100'],
            'person_number_2' => ['nullable', 'string', 'regex:/^[6-9]\d{9}$/'],
            'person_position_2' => ['nullable', 'string', 'max:100'],
            'person_name_3' => ['nullable', 'string', 'max:100'],
            'person_number_3' => ['nullable', 'string', 'regex:/^[6-9]\d{9}$/'],
            'person_position_3' => ['nullable', 'string', 'max:100'],
        ], [
            'gst_no.regex' => 'The GST number must be a valid 15-digit alphanumeric code',
            'pan_no.regex' => 'The PAN number must be in the format: AAAAA9999A',
            'contact_person_mobile.regex' => 'Please enter a valid 10-digit mobile number',
            'company_phone.regex' => 'Please enter a valid phone number',
            'company_password.min' => 'The password must be at least 8 characters',
            'company_password.confirmed' => 'The password confirmation does not match',
            'company_employee_email.different' => 'Employee email must be different from company email',
            'company_logo.mimes' => 'The company logo must be a file of type: jpeg, png, jpg',
            'company_logo.max' => 'The company logo must not be greater than 2MB',
            'scope_link.url' => 'Please enter a valid URL for the scope link',
            'person_name_1.required' => 'Person 1 name is required',
            'person_number_1.required' => 'Person 1 mobile number is required',
            'person_number_1.regex' => 'Please enter a valid 10-digit mobile number for Person 1',
            'person_position_1.required' => 'Person 1 position is required',
            'person_number_2.regex' => 'Please enter a valid 10-digit mobile number for Person 2',
            'person_number_3.regex' => 'Please enter a valid 10-digit mobile number for Person 3',
        ]);

        // Handle file uploads
        if ($request->hasFile('company_logo')) {
            $path = $request->file('company_logo')->store('company-logos', 'public');
            $validated['company_logo'] = $path;
        }

        if ($request->hasFile('sop_upload')) {
            $file = $request->file('sop_upload');
            $filename = uniqid() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('company-documents/sop', $filename, 'public');
            
            // Ensure file is readable
            $fullPath = storage_path('app/public/' . $path);
            if (file_exists($fullPath)) {
                chmod($fullPath, 0644);
            }
            
            $validated['sop_upload'] = $path;
        }

        if ($request->hasFile('quotation_upload')) {
            $file = $request->file('quotation_upload');
            $filename = uniqid() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('company-documents/quotation', $filename, 'public');
            
            // Ensure file is readable
            $fullPath = storage_path('app/public/' . $path);
            if (file_exists($fullPath)) {
                chmod($fullPath, 0644);
            }
            
            $validated['quotation_upload'] = $path;
        }

        // Create company - the unique_code will be auto-generated by the model
        $company = CompanyModel::create($validated);

        // Create user accounts for login
        $companyUserCreated = false;
        $employeeUserCreated = false;
        $companyLoginEmail = '';
        $companyLoginPassword = '';
        $employeeLoginEmail = '';
        $employeeLoginPassword = '';
        
        // Create user account for company email
        if (!empty($validated['company_email']) && !empty($validated['company_password'])) {
            $existingUser = User::where('email', $validated['company_email'])->first();
            
            if (!$existingUser) {
                $user = User::create([
                    'name' => $validated['contact_person_name'] . ' (Company)',
                    'email' => $validated['company_email'],
                    'password' => Hash::make($validated['company_password']),
                    'mobile_no' => $validated['contact_person_mobile'] ?? '',
                    'address' => $validated['company_address'] ?? '',
                ]);
            
                // Assign customer role
                if (class_exists(\Spatie\Permission\Models\Role::class)) {
                    $customerRole = \Spatie\Permission\Models\Role::where('name', 'customer')
                        ->orWhere('id', 6)
                        ->first();
                    if ($customerRole) {
                        $user->assignRole($customerRole);
                    }
                }
                
                $companyUserCreated = true;
                $companyLoginEmail = $validated['company_email'];
                $companyLoginPassword = $validated['company_password'];
                
                \Log::info('Company user account created', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'company_id' => $company->id
                ]);
            }
        }
        
        // Create user account for employee email if provided
        if (!empty($validated['company_employee_email']) && !empty($request->company_employee_password)) {
            $existingEmployeeUser = User::where('email', $validated['company_employee_email'])->first();
            
            if (!$existingEmployeeUser) {
                $employeeUser = User::create([
                    'name' => $validated['contact_person_name'] . ' (Employee)',
                    'email' => $validated['company_employee_email'],
                    'password' => Hash::make($request->company_employee_password),
                    'mobile_no' => $validated['contact_person_mobile'] ?? '',
                    'address' => $validated['company_address'] ?? '',
                ]);
            
                // Assign customer role
                if (class_exists(\Spatie\Permission\Models\Role::class)) {
                    $customerRole = \Spatie\Permission\Models\Role::where('name', 'customer')
                        ->orWhere('id', 6)
                        ->first();
                    if ($customerRole) {
                        $employeeUser->assignRole($customerRole);
                    }
                }
                
                $employeeUserCreated = true;
                $employeeLoginEmail = $validated['company_employee_email'];
                $employeeLoginPassword = $request->company_employee_password;
                
                \Log::info('Employee user account created', [
                    'user_id' => $employeeUser->id,
                    'email' => $employeeUser->email,
                    'company_id' => $company->id
                ]);
            }
        }

        // Prepare success message with credentials
        $successMessage = 'Company created successfully with ID: ' . $company->unique_code;
        
        if ($companyUserCreated) {
            $successMessage .= '|||COMPANY_USER_CREATED|||' . $companyLoginEmail . '|||' . $companyLoginPassword;
        }
        
        if ($employeeUserCreated) {
            $successMessage .= '|||EMPLOYEE_USER_CREATED|||' . $employeeLoginEmail . '|||' . $employeeLoginPassword;
        }

        // Redirect to companies index page with success message
        return redirect()->route('companies.index')->with('success', $successMessage);

    }

    public function show(CompanyModel $company): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Companies Management.view company'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        // Load quotations with the company
        $company->load('quotations');
        
        return view('companies.show', compact('company'));
    }

    public function edit(CompanyModel $company): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Companies Management.edit company'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, CompanyModel $company): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Companies Management.edit company'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $validated = $request->validate([
            'unique_code' => ['required', 'string', 'max:50', 'unique:companies,unique_code,' . $company->id],
            'company_name' => ['required', 'string', 'max:190'],
            'gst_no' => ['nullable', 'string', 'max:50', 'regex:/^[0-9A-Z]{15}$/'],
            'pan_no' => ['nullable', 'string', 'max:20', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'],
            'company_address' => ['required', 'string', 'max:500'],
            'state' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:50'],
            'contact_person_name' => ['required', 'string', 'max:100'],
            'contact_person_mobile' => ['required', 'string', 'regex:/^[6-9]\d{9}$/'],
            'contact_person_position' => ['required', 'string', 'max:100'],
            'company_email' => ['required', 'email', 'max:100', 'unique:companies,company_email,' . $company->id],
            'company_phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]*$/'],
            'company_type' => ['required', 'string', 'max:50'],
            'other_details' => ['nullable', 'string', 'max:1000'],
            'scope_link' => ['nullable', 'url', 'max:255'],
            'company_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'sop_upload' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'quotation_upload' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png', 'max:5120'],
            'company_password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'company_employee_email' => ['nullable', 'email', 'max:100', 'different:company_email'],
            'person_name_1' => ['required', 'string', 'max:100'],
            'person_number_1' => ['required', 'string', 'regex:/^[6-9]\d{9}$/'],
            'person_position_1' => ['required', 'string', 'max:100'],
            'person_name_2' => ['nullable', 'string', 'max:100'],
            'person_number_2' => ['nullable', 'string', 'regex:/^[6-9]\d{9}$/'],
            'person_position_2' => ['nullable', 'string', 'max:100'],
            'person_name_3' => ['nullable', 'string', 'max:100'],
            'person_number_3' => ['nullable', 'string', 'regex:/^[6-9]\d{9}$/'],
            'person_position_3' => ['nullable', 'string', 'max:100'],
        ], [
            'gst_no.regex' => 'The GST number must be a valid 15-digit alphanumeric code',
            'pan_no.regex' => 'The PAN number must be in the format: AAAAA9999A',
            'contact_person_mobile.regex' => 'Please enter a valid 10-digit mobile number',
            'company_phone.regex' => 'Please enter a valid phone number',
            'company_password.min' => 'The password must be at least 8 characters',
            'company_password.confirmed' => 'The password confirmation does not match',
            'company_employee_email.different' => 'Employee email must be different from company email',
            'company_logo.mimes' => 'The company logo must be a file of type: jpeg, png, jpg',
            'company_logo.max' => 'The company logo must not be greater than 2MB',
            'scope_link.url' => 'Please enter a valid URL for the scope link',
            'person_name_1.required' => 'Person 1 name is required',
            'person_number_1.required' => 'Person 1 mobile number is required',
            'person_number_1.regex' => 'Please enter a valid 10-digit mobile number for Person 1',
            'person_position_1.required' => 'Person 1 position is required',
            'person_number_2.regex' => 'Please enter a valid 10-digit mobile number for Person 2',
            'person_number_3.regex' => 'Please enter a valid 10-digit mobile number for Person 3',
        ]);

        // Handle file uploads
        if ($request->hasFile('company_logo')) {
            // Delete old logo if exists
            if ($company->company_logo) {
                Storage::disk('public')->delete($company->company_logo);
            }
            $path = $request->file('company_logo')->store('company-logos', 'public');
            $validated['company_logo'] = $path;
        }

        if ($request->hasFile('sop_upload')) {
            // Delete old SOP file if exists
            if ($company->sop_upload && Storage::disk('public')->exists($company->sop_upload)) {
                Storage::disk('public')->delete($company->sop_upload);
            }
            
            // Store new file with original name and unique ID
            // Store new file
            $file = $request->file('sop_upload');
            $filename = uniqid() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('company-documents/sop', $filename, 'public');
            
            // Ensure file is readable
            $fullPath = storage_path('app/public/' . $path);
            if (file_exists($fullPath)) {
                chmod($fullPath, 0644);
            }
            
            $validated['sop_upload'] = $path;
        }

        if ($request->hasFile('quotation_upload')) {
            // Delete old quotation file if exists
            if ($company->quotation_upload && Storage::disk('public')->exists($company->quotation_upload)) {
                Storage::disk('public')->delete($company->quotation_upload);
            }
            
            // Store new file with original name and unique ID
            $file = $request->file('quotation_upload');
            $filename = uniqid() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('company-documents/quotation', $filename, 'public');
            
            // Ensure file is readable
            $fullPath = storage_path('app/public/' . $path);
            if (file_exists($fullPath)) {
                chmod($fullPath, 0644);
            }
            
            $validated['quotation_upload'] = $path;
        }

        // Store old email for user account lookup
        $oldCompanyEmail = $company->company_email;
        $oldEmployeeEmail = $company->company_employee_email;
        
        // Update company
        $company->update($validated);

        // Update or create user account for company email
        if (!empty($validated['company_email'])) {
            // Find user by old email or new email
            $companyUser = User::where('email', $oldCompanyEmail)
                ->orWhere('email', $validated['company_email'])
                ->first();
            
            if ($companyUser) {
                // Update existing user
                $updateData = [
                    'email' => $validated['company_email'],
                    'name' => $validated['contact_person_name'] . ' (Company)',
                    'mobile_no' => $validated['contact_person_mobile'] ?? '',
                    'address' => $validated['company_address'] ?? '',
                ];
                
                // Update password if provided
                if (!empty($request->company_password)) {
                    $updateData['password'] = Hash::make($request->company_password);
                }
                
                $companyUser->update($updateData);
                
                \Log::info('Company user account updated', [
                    'user_id' => $companyUser->id,
                    'old_email' => $oldCompanyEmail,
                    'new_email' => $validated['company_email']
                ]);
            } else {
                // Create new user if doesn't exist and password is provided
                if (!empty($request->company_password)) {
                    $newUser = User::create([
                        'name' => $validated['contact_person_name'] . ' (Company)',
                        'email' => $validated['company_email'],
                        'password' => Hash::make($request->company_password),
                        'mobile_no' => $validated['contact_person_mobile'] ?? '',
                        'address' => $validated['company_address'] ?? '',
                    ]);
                    
                    // Assign customer role
                    if (class_exists(\Spatie\Permission\Models\Role::class)) {
                        $customerRole = \Spatie\Permission\Models\Role::where('name', 'customer')
                            ->orWhere('id', 6)
                            ->first();
                        if ($customerRole) {
                            $newUser->assignRole($customerRole);
                        }
                    }
                    
                    \Log::info('New company user account created during update', [
                        'user_id' => $newUser->id,
                        'email' => $validated['company_email']
                    ]);
                }
            }
        }
        
        // Update or create user account for employee email
        if (!empty($validated['company_employee_email'])) {
            // Find user by old email or new email
            $employeeUser = User::where('email', $oldEmployeeEmail)
                ->orWhere('email', $validated['company_employee_email'])
                ->first();
            
            if ($employeeUser) {
                // Update existing user
                $updateData = [
                    'email' => $validated['company_employee_email'],
                    'name' => $validated['contact_person_name'] . ' (Employee)',
                    'mobile_no' => $validated['contact_person_mobile'] ?? '',
                    'address' => $validated['company_address'] ?? '',
                ];
                
                // Update password if provided
                if (!empty($request->company_employee_password)) {
                    $updateData['password'] = Hash::make($request->company_employee_password);
                }
                
                $employeeUser->update($updateData);
                
                \Log::info('Employee user account updated', [
                    'user_id' => $employeeUser->id,
                    'old_email' => $oldEmployeeEmail,
                    'new_email' => $validated['company_employee_email']
                ]);
            } else {
                // Create new user if doesn't exist and password is provided
                if (!empty($request->company_employee_password)) {
                    $newEmployeeUser = User::create([
                        'name' => $validated['contact_person_name'] . ' (Employee)',
                        'email' => $validated['company_employee_email'],
                        'password' => Hash::make($request->company_employee_password),
                        'mobile_no' => $validated['contact_person_mobile'] ?? '',
                        'address' => $validated['company_address'] ?? '',
                    ]);
                    
                    // Assign customer role
                    if (class_exists(\Spatie\Permission\Models\Role::class)) {
                        $customerRole = \Spatie\Permission\Models\Role::where('name', 'customer')
                            ->orWhere('id', 6)
                            ->first();
                        if ($customerRole) {
                            $newEmployeeUser->assignRole($customerRole);
                        }
                    }
                    
                    \Log::info('New employee user account created during update', [
                        'user_id' => $newEmployeeUser->id,
                        'email' => $validated['company_employee_email']
                    ]);
                }
            }
        }

        // Redirect to companies index page with success message
        return redirect()->route('companies.index')->with('success','Company updated successfully. Login credentials have been synchronized.');
    }

    /**
     * Display a file from storage
     *
     * @param string $type The type of file (sop or quotation)
     * @param string $filename The name of the file
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\Response
     */
    public function viewFile($type, $filename)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Companies Management.view documents'))) {
            abort(403);
        }
        
        try {
            // Clean and validate the filename
            $filename = basename($filename);
            $type = in_array($type, ['sop', 'quotation']) ? $type : 'sop';
            
            // Try to find the file in the storage directory
            $directory = storage_path('app/public/company-documents/' . $type . '/');
            $filePath = $directory . $filename;
            
            // If file doesn't exist, try to find it by name (case-insensitive)
            if (!file_exists($filePath)) {
                $files = glob($directory . '*');
                foreach ($files as $file) {
                    if (strtolower(basename($file)) === strtolower($filename)) {
                        $filePath = $file;
                        break;
                    }
                }
                
                if (!file_exists($filePath)) {
                    // Try with URL decoded filename
                    $decodedFilename = urldecode($filename);
                    if ($decodedFilename !== $filename) {
                        $filePath = $directory . $decodedFilename;
                        if (!file_exists($filePath)) {
                            return response('File not found: ' . $filename, 404);
                        }
                    } else {
                        return response('File not found: ' . $filename, 404);
                    }
                }
            }
            
            // Get file info
            $fileInfo = pathinfo($filePath);
            $mimeType = mime_content_type($filePath);
            
            // For images, use the actual file extension for MIME type
            if (strpos($mimeType, 'image/') === 0) {
                $extension = strtolower($fileInfo['extension'] ?? '');
                $imageMimeTypes = [
                    'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'bmp' => 'image/bmp',
                    'webp' => 'image/webp',
                ];
                
                if (isset($imageMimeTypes[$extension])) {
                    $mimeType = $imageMimeTypes[$extension];
                }
            }
            
            // Set appropriate headers
            $headers = [
                'Content-Type' => $mimeType,
                'Content-Length' => filesize($filePath),
                'Cache-Control' => 'public, max-age=31536000', // 1 year cache
                'Expires' => gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000), // 1 year
            ];
            
            // For PDFs, use inline, for images use inline, for others force download
            if (strpos($mimeType, 'image/') === 0 || $mimeType === 'application/pdf') {
                $headers['Content-Disposition'] = 'inline; filename="' . basename($filePath) . '"';
            } else {
                $headers['Content-Disposition'] = 'attachment; filename="' . basename($filePath) . '"';
            }
            
            // Return the file response with headers
            return response()->file($filePath, $headers);
            
        } catch (\Exception $e) {
            \Log::error('Error serving file: ' . $e->getMessage());
            return response('Error serving file: ' . $e->getMessage(), 500);
        }
    }

    public function destroy(CompanyModel $company): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Companies Management.delete company'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        // Delete company logo if exists
        if ($company->company_logo) {
            Storage::disk('public')->delete($company->company_logo);
        }

        $company->delete();

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company deleted successfully.');
    }

    /**
     * Export companies to CSV
     *
     * @param Request $request
     * @return Response
     */
    public function export(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Companies Management.export company'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $query = CompanyModel::query();

        // Apply filters
        if ($request->filled('company_name')) {
            $query->where('company_name', 'like', '%' . $request->company_name . '%');
        }

        if ($request->filled('gst_no')) {
            $query->where('gst_no', 'like', '%' . $request->gst_no . '%');
        }

        if ($request->filled('contact_person')) {
            $query->where('contact_person_name', 'like', '%' . $request->contact_person . '%');
        }

        // Apply search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('company_name', 'like', '%' . $search . '%')
                  ->orWhere('gst_no', 'like', '%' . $search . '%')
                  ->orWhere('contact_person_name', 'like', '%' . $search . '%')
                  ->orWhere('contact_person_mobile', 'like', '%' . $search . '%')
                  ->orWhere('company_email', 'like', '%' . $search . '%')
                  ->orWhere('unique_code', 'like', '%' . $search . '%');
            });
        }

        $companies = $query->latest()->get();

        $fileName = 'companies_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function() use ($companies) {
            $handle = fopen('php://output', 'w');
            
            // Add BOM for Excel compatibility
            fputs($handle, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
            
            // Header row
            fputcsv($handle, [
                'ID',
                'Unique Code',
                'Company Name',
                'GST No',
                'PAN No',
                'Company Address',
                'State',
                'City',
                'Company Type',
                'Contact Person Name',
                'Contact Position',
                'Contact Mobile',
                'Company Email',
                'Company Phone',
                'Scope Link',
                'Created At',
                'Updated At',
            ]);

            // Data rows
            foreach ($companies as $company) {
                fputcsv($handle, [
                    $company->id,
                    $company->unique_code,
                    $company->company_name,
                    $company->gst_no,
                    $company->pan_no,
                    $company->company_address,
                    $company->state,
                    $company->city,
                    $company->company_type,
                    $company->contact_person_name,
                    $company->contact_person_position,
                    $company->contact_person_mobile,
                    $company->company_email,
                    $company->company_phone,
                    $company->scope_link,
                    $company->created_at,
                    $company->updated_at,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
