<?php
namespace App\Http\Controllers\Quotation;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Quotation;
use App\Models\QuotationFollowUp;
use App\Models\Proforma;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class QuotationController extends Controller
{
    public function index(Request $request): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.view quotation'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        try {
            $perPage = (int) $request->get('per_page', 10);
            // Ensure per_page is within valid range
            $allowedPerPage = [10, 25, 50, 100];
            if (!in_array($perPage, $allowedPerPage)) {
                $perPage = 10;
            }
            
            // Ensure per_page is always set in request for consistency
            $request->merge(['per_page' => $perPage]);
            

            $user = auth()->user();
            $query = Quotation::with(['followUps' => function ($q) {
                $q->where('is_confirm', true)->latest();
            }])
                ->select('id', 'unique_code', 'company_name', 'contact_number_1', 'quotation_date', 'service_contract_amount', 'created_at', 'updated_at', 'tentative_complete_date', 'customer_type', 'company_email', 'customer_id');
            
            // Filter by role: customers/clients see only their company's quotations
            $isCustomer = $user->hasRole('customer') || $user->hasRole('client') || $user->hasRole('company');
            if ($isCustomer && $user->company_id) {
                $company = $user->company;
                if ($company) {
                    $query->where('company_name', $company->company_name);
                }
            }
            
            // Handle sorting
            $sortBy = $request->get('sort', 'created_at');
            $sortDirection = $request->get('direction', 'desc');
            
            // Validate sort column
            $allowedSorts = ['unique_code', 'company_name', 'quotation_date', 'service_contract_amount', 'tentative_complete_date', 'status', 'created_at', 'updated_at'];
            if (!in_array($sortBy, $allowedSorts)) {
                $sortBy = 'created_at';
            }
            
            // Validate sort direction
            if (!in_array($sortDirection, ['asc', 'desc'])) {
                $sortDirection = 'desc';
            }
            
            $query->orderBy($sortBy, $sortDirection);
            
            // Apply filters
            if ($request->filled('quotation_no')) {
                $query->where('unique_code', 'like', '%' . $request->quotation_no . '%');
            }
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('company_name', 'like', '%' . $search . '%')
                      ->orWhere('unique_code', 'like', '%' . $search . '%')
                      ->orWhere('contact_number_1', 'like', '%' . $search . '%');
                });
            }
            
            if ($request->filled('from_date')) {
                $query->whereDate('quotation_date', '>=', $request->from_date);
            }
            
            if ($request->filled('to_date')) {
                $query->whereDate('quotation_date', '<=', $request->to_date);
            }
            
            $quotations = $query->paginate($perPage)->appends($request->query());
            
            // Force per_page to be correct in pagination object
            $quotations->withPath($request->url())->appends(array_merge($request->query(), ['per_page' => $perPage]));
            

            
            // Check for orphaned quotations (customer_id points to deleted company)
            $orphanedQuotations = [];
            foreach ($quotations as $quotation) {
                if ($quotation->customer_type === 'existing' && $quotation->customer_id) {
                    $companyExists = Company::where('id', $quotation->customer_id)->exists();
                    if (!$companyExists) {
                        $orphanedQuotations[] = $quotation->id;
                        // Reset to new customer type so convert button shows
                        $quotation->customer_type = 'new';
                        $quotation->customer_id = null;
                    }
                }
            }
            
            // Update orphaned quotations in database
            if (!empty($orphanedQuotations)) {
                Quotation::whereIn('id', $orphanedQuotations)->update([
                    'customer_type' => 'new',
                    'customer_id' => null
                ]);
                
                \Log::info('Reset orphaned quotations to new customer type', [
                    'quotation_ids' => $orphanedQuotations,
                    'count' => count($orphanedQuotations)
                ]);
            }
            
            // Get quotation IDs with confirmed follow-ups
            $confirmedQuotationIds = QuotationFollowUp::where('is_confirm', true)
                ->pluck('quotation_id')
                ->unique()
                ->values()
                ->toArray();
            
            // Get emails of existing companies to check for duplicates
            $existingCompanyEmails = Company::whereNotNull('company_email')
                ->pluck('company_email')
                ->map(function($email) {
                    return strtolower(trim($email));
                })
                ->toArray();
            
            return view('quotations.index', compact('quotations', 'confirmedQuotationIds', 'existingCompanyEmails'));
        } catch (\Exception $e) {
            Log::error('Quotations index error: ' . $e->getMessage());
            $perPage = (int) $request->get('per_page', 10);
            $allowedPerPage = [10, 25, 50, 100];
            if (!in_array($perPage, $allowedPerPage)) {
                $perPage = 10;
            }
            $quotations = Quotation::paginate($perPage)->appends($request->query());
            $confirmedQuotationIds = [];
            $existingCompanyEmails = [];
            return view('quotations.index', compact('quotations', 'confirmedQuotationIds', 'existingCompanyEmails'))->with('error', 'Error loading quotations');
        }
    }
    
    /**
     * Export quotations to Excel
     */
    public function export(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.export quotation'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        try {
            $user = auth()->user();
            $query = Quotation::query()->orderBy('created_at', 'desc');
            
            // Filter by role: customers/clients see only their company's quotations
            $isCustomer = $user->hasRole('customer') || $user->hasRole('client') || $user->hasRole('company');
            if ($isCustomer && $user->company_id) {
                $company = $user->company;
                if ($company) {
                    $query->where('company_name', $company->company_name);
                }
            }
            
            // Apply filters if provided
            if ($request->filled('quotation_no')) {
                $query->where('unique_code', 'like', '%' . $request->quotation_no . '%');
            }
            
            if ($request->filled('from_date')) {
                $query->whereDate('created_at', '>=', $request->from_date);
            }
            
            if ($request->filled('to_date')) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('unique_code', 'like', '%' . $search . '%')
                      ->orWhere('company_name', 'like', '%' . $search . '%')
                      ->orWhere('contact_number_1', 'like', '%' . $search . '%');
                });
            }
            
            $quotations = $query->get();
            
            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\QuotationsExport($quotations), 
                'quotations_' . date('Y-m-d_His') . '.xlsx'
            );
        } catch (\Exception $e) {
            \Log::error('Error exporting quotations: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error exporting quotations: ' . $e->getMessage());
        }
    }
    
    /**
     * Export quotations to CSV
     */
    public function exportCsv(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.export quotation'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user = auth()->user();
        $query = Quotation::query()->latest();

        // Filter by role: customers/clients see only their company's quotations
        $isCustomer = $user->hasRole('customer') || $user->hasRole('client') || $user->hasRole('company');
        if ($isCustomer && $user->company_id) {
            $company = $user->company;
            if ($company) {
                $query->where('company_name', $company->company_name);
            }
        }

        if ($request->filled('from_date')) {
            $query->whereDate('quotation_date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('quotation_date', '<=', $request->input('to_date'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('unique_code', 'like', "%{$search}%")
                  ->orWhere('contact_number_1', 'like', "%{$search}%");
            });
        }

        if ($request->filled('quotation_no')) {
            $query->where('unique_code', 'like', '%' . $request->quotation_no . '%');
        }

        $quotations = $query->get();

        $fileName = 'quotations_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () use ($quotations) {
            $handle = fopen('php://output', 'w');

            // Header row
            fputcsv($handle, [
                'ID',
                'Unique Code',
                'Quotation Date',
                'Company Name',
                'Contact Person',
                'Contact Number',
                'Email',
                'Address',
                'City',
                'State',
                'GST No',
                'PAN No',
                'Contract Amount',
                'Tentative Complete Date',
                'Customer Type',
                'Created At',
                'Updated At',
            ]);

            foreach ($quotations as $quotation) {
                // Remove +91 prefix from mobile
                $mobile = $quotation->contact_number_1 ?? '';
                $mobile = preg_replace('/^\+91/', '', $mobile);
                
                fputcsv($handle, [
                    $quotation->id,
                    $quotation->unique_code,
                    optional($quotation->quotation_date)->format('d/m/Y'),
                    $quotation->company_name,
                    $quotation->contact_person_1,
                    $mobile,
                    $quotation->company_email,
                    $quotation->address,
                    $quotation->city,
                    $quotation->state,
                    $quotation->gst_no,
                    $quotation->pan_no,
                    number_format($quotation->service_contract_amount ?? 0, 2),
                    optional($quotation->tentative_complete_date)->format('d/m/Y'),
                    ucfirst($quotation->customer_type ?? 'new'),
                    optional($quotation->created_at)->format('d/m/Y H:i:s'),
                    optional($quotation->updated_at)->format('d/m/Y H:i:s'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function getCompanyDetails($id): JsonResponse
    {
        try {
            $company = Company::find($id);
            
            if (!$company) {
                return response()->json([
                    'success' => false,
                    'message' => 'Company not found'
                ], 404);
            }

            $responseData = [
                'success' => true,
                'data' => [
                    'company_name' => $company->company_name ?? '',
                    'company_type' => $company->company_type ?? '',
                    'gst_no' => $company->gst_no ?? '',
                    'pan_no' => $company->pan_no ?? '',
                    'city' => $company->city ?? '',
                    'state' => $company->state ?? '',
                    'address' => $company->company_address ?? ($company->address ?? ''),
                    'company_email' => $company->company_email ?? '',
                    'company_employee_email' => $company->company_employee_email ?? '',
                    'nature_of_work' => $company->nature_of_work ?? ($company->other_details ?? ''),
                    'contact_person_1' => $company->contact_person_1 ?? ($company->contact_person_name ?? ''),
                    'contact_number_1' => $company->contact_number_1 ?? ($company->contact_person_mobile ?? ''),
                    'position_1' => $company->position_1 ?? ($company->contact_person_position ?? ''),
                ]
            ];

            return response()->json($responseData);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading company details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function create(): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.create quotation'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $lastQuotation = Quotation::orderByDesc('id')->first();
        $nextNumber = 1;
        
        if ($lastQuotation && !empty($lastQuotation->unique_code)) {
            if (preg_match('/(\d+)$/', $lastQuotation->unique_code, $matches)) {
                $nextNumber = ((int) $matches[1]) + 1;
            }
        }
        
        $nextCode = 'CMS/QUAT/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        
        $companies = Company::select('id', 'company_name')
            ->orderBy('company_name')
            ->get();
        
        return view('quotations.create', compact('nextCode', 'companies'));
    }


    public function store(Request $request): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.create quotation'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        // Filter out empty service rows
        $services1 = [
            'description' => [],
            'quantity' => [],
            'rate' => [],
            'total' => []
        ];

        if ($request->has('services_1.description')) {
            foreach ($request->services_1['description'] as $index => $description) {
                $quantity = $request->services_1['quantity'][$index] ?? '';
                $rate = $request->services_1['rate'][$index] ?? '';
                $total = $request->services_1['total'][$index] ?? '';
                
                // Only add if description has a non-empty value (trim whitespace)
                if (!empty(trim($description))) {
                    $services1['description'][] = $description;
                    $services1['quantity'][] = $quantity ?: '0';
                    $services1['rate'][] = $rate ?: '0';
                    $services1['total'][] = $total ?: '0';
                }
            }
            $request->merge(['services_1' => $services1]);
        }

        try {
            // Generate next quotation code
            $lastQuotation = Quotation::orderByDesc('id')->first();
            $nextNumber = 1;
            if ($lastQuotation && !empty($lastQuotation->unique_code)) {
                if (preg_match('/(\d+)$/', $lastQuotation->unique_code, $matches)) {
                    $nextNumber = ((int) $matches[1]) + 1;
                }
            }
            $nextCode = 'CMS/QUAT/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            
            // Set customer ID (only for existing customers)
            $customerId = $request->customer_type === 'existing' ? $request->customer_id : null;
            
            // Convert date formats from dd/mm/yy to Y-m-d before validation
            $dateFields = ['quotation_date', 'amc_start_date', 'project_start_date', 'tentative_complete_date', 'tentative_complete_date_2'];
            foreach ($dateFields as $field) {
                if ($request->has($field) && !empty($request->$field)) {
                    $dateValue = $request->$field;
                    // Check if date is in dd/mm/yy or dd/mm/y format
                    if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{2,4})$/', $dateValue, $matches)) {
                        $day = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
                        $month = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
                        $year = $matches[3];
                        // Convert 2-digit year to 4-digit
                        if (strlen($year) == 2) {
                            $year = '20' . $year;
                        }
                        $request->merge([$field => "$year-$month-$day"]);
                    }
                }
            }
            
            // Validate request data
            $validated = $request->validate([
                // Basic Information
                'quotation_title' => ['required', 'string', 'max:255'],
                'quotation_date' => ['required', 'date'],
                'customer_type' => ['required', 'string', 'in:new,existing'],
                'customer_id' => ['nullable', 'integer', 'exists:companies,id'],
                
                // Company Information
                'company_name' => ['required', 'string', 'max:255'],
                'company_type' => ['nullable', 'string', 'max:255'],
                'company_email' => ['required', 'email', 'max:255'],
                'company_password' => [$request->customer_type === 'new' ? 'required' : 'nullable', 'string', 'min:6', 'max:255'],
                'company_employee_email' => ['nullable', 'email', 'max:255'],
                'company_employee_password' => ['nullable', 'string', 'min:6', 'max:255'],
                'gst_no' => ['nullable', 'string', 'max:50'],
                'pan_no' => ['nullable', 'string', 'max:50'],
                'nature_of_work' => ['nullable', 'string', 'max:500'],
                'city' => ['nullable', 'string', 'max:100'],
                'state' => ['nullable', 'string', 'max:100'],
                'address' => ['nullable', 'string', 'max:500'],
                'scope_of_work' => ['nullable', 'string', 'max:1000'],
                
                // Contact Information
                'contact_person_1' => ['required', 'string', 'max:255'],
                'contact_number_1' => ['required', 'string', 'max:20'],
                'position_1' => ['nullable', 'string', 'max:255'],
                'contact_person_2' => ['nullable', 'string', 'max:255'],
                'contact_number_2' => ['nullable', 'string', 'max:20'],
                'position_2' => ['nullable', 'string', 'max:255'],
                'contact_person_3' => ['nullable', 'string', 'max:255'],
                'contact_number_3' => ['nullable', 'string', 'max:20'],
                'position_3' => ['nullable', 'string', 'max:255'],
                
                // Contract Details
                'contract_details' => ['nullable', 'string', 'max:1000'],
                'contract_copy' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:20480'],
                
                // Project Details
                'amc_start_date' => ['nullable', 'date'],
                'amc_amount' => ['nullable', 'numeric', 'min:0'],
                'project_start_date' => ['nullable', 'date'],
                'completion_time' => ['nullable', 'string', 'max:255'],
                'retention_time' => ['nullable', 'string', 'max:255'],
                'retention_amount' => ['nullable', 'numeric', 'min:0'],
                'retention_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'tentative_complete_date' => ['nullable', 'date'],
                'tentative_complete_date_2' => ['nullable', 'date'],
                
                // Footer Information
                'prepared_by' => ['nullable', 'string', 'max:255'],
                'mobile_no' => ['nullable', 'string', 'max:20'],
                'footer_company_name' => ['nullable', 'string', 'max:255'],
                
                // Service Amounts
                'contract_amount' => ['nullable', 'numeric', 'min:0'],
                'basic_subtotal' => ['nullable', 'numeric', 'min:0'],
                'additional_subtotal' => ['nullable', 'numeric', 'min:0'],
                'maintenance_subtotal' => ['nullable', 'numeric', 'min:0'],
                
                // Custom Terms & Conditions
                'custom_terms_text' => ['nullable', 'string', 'max:2000'],
                
                // Remark
                'remark' => ['nullable', 'string', 'max:1000'],
            ]);
            
            // Validate that at least one service is provided
            if (empty($services1['description']) || count($services1['description']) === 0) {
                return redirect()->back()->withInput()
                    ->with('error', 'Please add at least one service to the quotation.');
            }

            // Contact numbers are already processed by the phone-input component with country code
            
            // Convert date formats from dd/mm/yy to Y-m-d
            $dateFields = ['quotation_date', 'amc_start_date', 'project_start_date', 'tentative_complete_date', 'tentative_complete_date_2'];
            foreach ($dateFields as $field) {
                if (!empty($validated[$field])) {
                    try {
                        $validated[$field] = \Carbon\Carbon::createFromFormat('d/m/y', $validated[$field])->format('Y-m-d');
                    } catch (\Exception $e) {
                        // If parsing fails, try to parse as Y-m-d (in case it's already in correct format)
                        try {
                            $validated[$field] = \Carbon\Carbon::createFromFormat('Y-m-d', $validated[$field])->format('Y-m-d');
                        } catch (\Exception $e2) {
                            // If both fail, leave as is
                        }
                    }
                }
            }

            // Prepare data for database using validated data
            $data = [
                'unique_code' => $nextCode,
                'quotation_title' => $validated['quotation_title'],
                'quotation_date' => $validated['quotation_date'],
                'customer_type' => $validated['customer_type'],
                'customer_id' => $customerId,
                'gst_no' => $validated['gst_no'] ?? null,
                'pan_no' => $validated['pan_no'] ?? null,
                'company_name' => $validated['company_name'],
                'company_type' => $validated['company_type'] ?? null,
                'nature_of_work' => $validated['nature_of_work'] ?? null,
                'city' => $validated['city'] ?? null,
                'state' => $validated['state'] ?? null,
                'scope_of_work' => $validated['scope_of_work'] ?? null,
                'address' => $validated['address'] ?? null,
                'contact_person_1' => $validated['contact_person_1'],
                'contact_number_1' => $validated['contact_number_1'],
                'position_1' => $validated['position_1'] ?? null,
                'contact_person_2' => $validated['contact_person_2'] ?? null,
                'contact_number_2' => $validated['contact_number_2'] ?? null,
                'position_2' => $validated['position_2'] ?? null,
                'contact_person_3' => $validated['contact_person_3'] ?? null,
                'contact_number_3' => $validated['contact_number_3'] ?? null,
                'position_3' => $validated['position_3'] ?? null,
                'contract_details' => $validated['contract_details'] ?? null,
                'company_email' => $validated['company_email'],
                'company_password' => $validated['company_password'] ?? null,
                'amc_start_date' => $validated['amc_start_date'] ?? null,
                'amc_amount' => $validated['amc_amount'] ?? 0,
                'project_start_date' => $validated['project_start_date'] ?? null,
                'completion_time' => $validated['completion_time'] ?? null,
                'retention_time' => $validated['retention_time'] ?? null,
                'retention_amount' => $validated['retention_amount'] ?? 0,
                'retention_percent' => $validated['retention_percent'] ?? 0,
                'tentative_complete_date' => $validated['tentative_complete_date'] ?? null,
                'prepared_by' => $validated['prepared_by'] ?? null,
                'mobile_no' => !empty($validated['mobile_no']) ? '+91' . $validated['mobile_no'] : null,
                'own_company_name' => $validated['footer_company_name'] ?? 'CHITRI INFOTECH PVT LTD',
                'remark' => $validated['remark'] ?? null,
                
                // Service data (from services_1 table) - using filtered data
                'service_description' => $services1['description'] ?? [],
                'service_quantity' => $services1['quantity'] ?? [],
                'service_rate' => $services1['rate'] ?? [],
                'service_total' => $services1['total'] ?? [],
                'service_contract_amount' => $validated['contract_amount'] ?? 0,
                
                // Terms data (from services_2 table) - preserve all array values
                'terms_description' => $request->input('services_2.description', []),
                'terms_quantity' => $request->input('services_2.quantity', []),
                'terms_rate' => $request->input('services_2.rate', []),
                'terms_total' => $request->input('services_2.total', []),
                'terms_completion' => $request->input('services_2.completion_percent', []),
                'completion_terms' => $request->input('services_2.completion_terms', []),
                'terms_tentative_complete_date' => $validated['tentative_complete_date_2'] ?? null,
                
                // Custom terms - convert textarea to array
                'custom_terms_and_conditions' => !empty($validated['custom_terms_text']) 
                    ? array_filter(array_map('trim', explode("\n", $validated['custom_terms_text']))) 
                    : [],
                
                // Feature booleans
                'sample_management' => in_array('sample_management', $request->input('features', [])),
                'user_friendly_interface' => in_array('user_friendly_interface', $request->input('features', [])),
                'contact_management' => in_array('contact_management', $request->input('features', [])),
                'test_management' => in_array('test_management', $request->input('features', [])),
                'employee_management' => in_array('employee_management', $request->input('features', [])),
                'lead_opportunity_management' => in_array('lead_opportunity_management', $request->input('features', [])),
                'data_integrity_security' => in_array('data_integrity_security', $request->input('features', [])),
                'recruitment_onboarding' => in_array('recruitment_onboarding', $request->input('features', [])),
                'sales_automation' => in_array('sales_automation', $request->input('features', [])),
                'reporting_analytics' => in_array('reporting_analytics', $request->input('features', [])),
                'payroll_management' => in_array('payroll_management', $request->input('features', [])),
                'customer_service_management' => in_array('customer_service_management', $request->input('features', [])),
                'inventory_management' => in_array('inventory_management', $request->input('features', [])),
                'training_development' => in_array('training_development', $request->input('features', [])),
                'integration_lab' => in_array('integration_capabilities_lab', $request->input('features', [])),
                'employee_self_service_portal' => in_array('employee_self_service', $request->input('features', [])),
                'marketing_automation' => in_array('marketing_automation', $request->input('features', [])),
                'regulatory_compliance' => in_array('regulatory_compliance', $request->input('features', [])),
                'analytics_reporting' => in_array('analytics_reporting', $request->input('features', [])),
                'integration_crm' => in_array('integration_capabilities_crm', $request->input('features', [])),
                'workflow_automation' => in_array('workflow_automation', $request->input('features', [])),
                'integration_hr' => in_array('integration_capabilities_hr', $request->input('features', [])),
                
                // Basic cost data - preserve all array values including empty ones
                'basic_cost_description' => $request->input('basic_cost.description', []),
                'basic_cost_quantity' => $request->input('basic_cost.quantity', []),
                'basic_cost_rate' => $request->input('basic_cost.rate', []),
                'basic_cost_total' => $request->input('basic_cost.total', []),
                'basic_cost_total_amount' => $validated['basic_subtotal'] ?? 0,
                
                // Additional cost data - preserve all array values including empty ones
                'additional_cost_description' => $request->input('additional_cost.description', []),
                'additional_cost_quantity' => $request->input('additional_cost.quantity', []),
                'additional_cost_rate' => $request->input('additional_cost.rate', []),
                'additional_cost_total' => $request->input('additional_cost.total', []),
                'additional_cost_total_amount' => $validated['additional_subtotal'] ?? 0,
                
                // Support/Maintenance cost data - preserve all array values including empty ones
                'support_description' => $request->input('maintenance_cost.description', []),
                'support_quantity' => $request->input('maintenance_cost.quantity', []),
                'support_rate' => $request->input('maintenance_cost.rate', []),
                'support_total' => $request->input('maintenance_cost.total', []),
                'support_total_amount' => $validated['maintenance_subtotal'] ?? 0,
            ];
            
            // Handle file upload
            if ($request->hasFile('contract_copy')) {
                $data['contract_copy'] = $request->file('contract_copy')->store('quotations/contracts', 'public');
            }

            // Create quotation
            $quotation = Quotation::create($data);

            $message = 'Quotation created successfully with ID: ' . $quotation->unique_code;

            return redirect()->route('quotations.index')
                ->with('status', $message);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw validation exceptions so Laravel can handle them properly
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error creating quotation: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Error creating quotation: ' . $e->getMessage());
        }
    }
    

    public function show(int $id): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.view quotation'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $quotation = Quotation::findOrFail($id);
        return view('quotations.show', compact('quotation'));
    }

    public function edit(int $id): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.edit quotation'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $quotation = Quotation::findOrFail($id);
        $companies = Company::select('id', 'company_name')->orderBy('company_name')->get();
        return view('quotations.edit', compact('quotation', 'companies'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.edit quotation'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        try {
            $quotation = Quotation::findOrFail($id);
            
            // Convert date formats from dd/mm/yy to Y-m-d before validation
            $dateFields = ['quotation_date', 'amc_start_date', 'project_start_date', 'tentative_complete_date', 'tentative_complete_date_2'];
            foreach ($dateFields as $field) {
                if ($request->has($field) && !empty($request->$field)) {
                    $dateValue = $request->$field;
                    // Check if date is in dd/mm/yy or dd/mm/y format
                    if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{2,4})$/', $dateValue, $matches)) {
                        $day = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
                        $month = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
                        $year = $matches[3];
                        // Convert 2-digit year to 4-digit
                        if (strlen($year) == 2) {
                            $year = '20' . $year;
                        }
                        $request->merge([$field => "$year-$month-$day"]);
                    }
                }
            }
            
            // Validate request data (same as create)
            $validated = $request->validate([
                // Basic Information
                'quotation_title' => ['required', 'string', 'max:255'],
                'quotation_date' => ['required', 'date'],
                'customer_type' => ['required', 'string', 'in:new,existing'],
                'customer_id' => ['nullable', 'integer', 'exists:companies,id'],
                
                // Company Information
                'company_name' => ['required', 'string', 'max:255'],
                'company_type' => ['nullable', 'string', 'max:255'],
                'company_email' => ['required', 'email', 'max:255'],
                'company_password' => ['nullable', 'string', 'max:255'],
                'company_employee_email' => ['nullable', 'email', 'max:255'],
                'company_employee_password' => ['nullable', 'string', 'max:255'],
                'gst_no' => ['nullable', 'string', 'max:50'],
                'pan_no' => ['nullable', 'string', 'max:50'],
                'nature_of_work' => ['nullable', 'string', 'max:500'],
                'city' => ['nullable', 'string', 'max:100'],
                'state' => ['nullable', 'string', 'max:100'],
                'address' => ['nullable', 'string', 'max:500'],
                'scope_of_work' => ['nullable', 'string', 'max:1000'],
                
                // Contact Information
                'contact_person_1' => ['required', 'string', 'max:255'],
                'contact_number_1' => ['required', 'string', 'max:20'],
                'position_1' => ['nullable', 'string', 'max:255'],
                'contact_person_2' => ['nullable', 'string', 'max:255'],
                'contact_number_2' => ['nullable', 'string', 'max:20'],
                'position_2' => ['nullable', 'string', 'max:255'],
                'contact_person_3' => ['nullable', 'string', 'max:255'],
                'contact_number_3' => ['nullable', 'string', 'max:20'],
                'position_3' => ['nullable', 'string', 'max:255'],
                
                // Contract Details
                'contract_details' => ['nullable', 'string', 'max:1000'],
                'contract_copy' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:20480'],
                
                // Project Details
                'amc_start_date' => ['nullable', 'date'],
                'amc_amount' => ['nullable', 'numeric', 'min:0'],
                'project_start_date' => ['nullable', 'date'],
                'completion_time' => ['nullable', 'string', 'max:255'],
                'retention_time' => ['nullable', 'string', 'max:255'],
                'retention_amount' => ['nullable', 'numeric', 'min:0'],
                'retention_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'tentative_complete_date' => ['nullable', 'date'],
                'tentative_complete_date_2' => ['nullable', 'date'],
                
                // Footer Information
                'prepared_by' => ['nullable', 'string', 'max:255'],
                'mobile_no' => ['nullable', 'string', 'max:20'],
                'footer_company_name' => ['nullable', 'string', 'max:255'],
                
                // Service Amounts
                'contract_amount' => ['nullable', 'numeric', 'min:0'],
                'basic_subtotal' => ['nullable', 'numeric', 'min:0'],
                'additional_subtotal' => ['nullable', 'numeric', 'min:0'],
                'maintenance_subtotal' => ['nullable', 'numeric', 'min:0'],
                
                // Custom Terms & Conditions
                'custom_terms_text' => ['nullable', 'string', 'max:2000'],
                
                // Remark
                'remark' => ['nullable', 'string', 'max:1000'],
            ]);

            // Contact numbers are already processed by the phone-input component with country code
            
            // Convert date formats from dd/mm/yy to Y-m-d
            $dateFields = ['quotation_date', 'amc_start_date', 'project_start_date', 'tentative_complete_date', 'tentative_complete_date_2'];
            foreach ($dateFields as $field) {
                if (!empty($validated[$field])) {
                    try {
                        $validated[$field] = \Carbon\Carbon::createFromFormat('d/m/y', $validated[$field])->format('Y-m-d');
                    } catch (\Exception $e) {
                        // If parsing fails, try to parse as Y-m-d (in case it's already in correct format)
                        try {
                            $validated[$field] = \Carbon\Carbon::createFromFormat('Y-m-d', $validated[$field])->format('Y-m-d');
                        } catch (\Exception $e2) {
                            // If both fail, leave as is
                        }
                    }
                }
            }

            // Prepare data using validated data
            $data = [
                'quotation_title' => $validated['quotation_title'],
                'quotation_date' => $validated['quotation_date'],
                'customer_type' => $validated['customer_type'],
                'customer_id' => $validated['customer_id'] ?? null,
                'gst_no' => $validated['gst_no'] ?? null,
                'pan_no' => $validated['pan_no'] ?? null,
                'company_name' => $validated['company_name'],
                'company_type' => $validated['company_type'] ?? null,
                'nature_of_work' => $validated['nature_of_work'] ?? null,
                'city' => $validated['city'] ?? null,
                'state' => $validated['state'] ?? null,
                'scope_of_work' => $validated['scope_of_work'] ?? null,
                'address' => $validated['address'] ?? null,
                'contact_person_1' => $validated['contact_person_1'],
                'contact_number_1' => $validated['contact_number_1'],
                'position_1' => $validated['position_1'] ?? null,
                'contact_person_2' => $validated['contact_person_2'] ?? null,
                'contact_number_2' => $validated['contact_number_2'] ?? null,
                'position_2' => $validated['position_2'] ?? null,
                'contact_person_3' => $validated['contact_person_3'] ?? null,
                'contact_number_3' => $validated['contact_number_3'] ?? null,
                'position_3' => $validated['position_3'] ?? null,
                'contract_details' => $validated['contract_details'] ?? null,
                'company_email' => $validated['company_email'],
                'company_password' => $validated['company_password'] ?? null,
                'company_employee_email' => $validated['company_employee_email'] ?? null,
                'company_employee_password' => $validated['company_employee_password'] ?? null,
                'amc_start_date' => $validated['amc_start_date'] ?? null,
                'amc_amount' => $validated['amc_amount'] ?? 0,
                'project_start_date' => $validated['project_start_date'] ?? null,
                'completion_time' => $validated['completion_time'] ?? null,
                'retention_time' => $validated['retention_time'] ?? null,
                'retention_amount' => $validated['retention_amount'] ?? 0,
                'retention_percent' => $validated['retention_percent'] ?? 0,
                'tentative_complete_date' => $validated['tentative_complete_date'] ?? null,
                'terms_tentative_complete_date' => $validated['tentative_complete_date_2'] ?? null,
                'prepared_by' => $validated['prepared_by'] ?? null,
                'mobile_no' => !empty($validated['mobile_no']) ? '+91' . $validated['mobile_no'] : null,
                'own_company_name' => $validated['footer_company_name'] ?? 'CHITRI INFOTECH PVT LTD',
                'remark' => $validated['remark'] ?? null,
            ];
            
            // Store old email values for user account lookup
            $oldCompanyEmail = $quotation->company_email;
            $oldEmployeeEmail = $quotation->company_employee_email;

            // Handle services_1 (main services)
            $services1 = $request->input('services_1', []);
            $data['service_description'] = $services1['description'] ?? [];
            $data['service_quantity'] = $services1['quantity'] ?? [];
            $data['service_rate'] = $services1['rate'] ?? [];
            $data['service_total'] = $services1['total'] ?? [];
            $data['service_contract_amount'] = $validated['contract_amount'] ?? 0;

            // Handle services_2 (payment terms)
            $services2 = $request->input('services_2', []);
            $data['terms_description'] = $services2['description'] ?? [];
            $data['terms_quantity'] = $services2['quantity'] ?? [];
            $data['terms_rate'] = $services2['rate'] ?? [];
            $data['terms_total'] = $services2['total'] ?? [];
            $data['terms_completion'] = $services2['completion_percent'] ?? [];
            $data['completion_terms'] = $services2['completion_terms'] ?? [];

            // Handle premium features
            $features = $request->input('features', []);
            $featureMap = [
                'sample_management' => 'sample_management',
                'user_friendly_interface' => 'user_friendly_interface', 
                'contact_management' => 'contact_management',
                'test_management' => 'test_management',
                'employee_management' => 'employee_management',
                'lead_opportunity_management' => 'lead_opportunity_management',
                'data_integrity_security' => 'data_integrity_security',
                'recruitment_onboarding' => 'recruitment_onboarding',
                'sales_automation' => 'sales_automation',
                'reporting_analytics' => 'reporting_analytics',
                'payroll_management' => 'payroll_management',
                'customer_service_management' => 'customer_service_management',
                'inventory_management' => 'inventory_management',
                'training_development' => 'training_development',
                'integration_capabilities_lab' => 'integration_lab',
                'employee_self_service' => 'employee_self_service_portal',
                'marketing_automation' => 'marketing_automation',
                'regulatory_compliance' => 'regulatory_compliance',
                'analytics_reporting' => 'analytics_reporting',
                'integration_capabilities_crm' => 'integration_crm',
                'workflow_automation' => 'workflow_automation',
                'integration_capabilities_hr' => 'integration_hr'
            ];
            
            foreach ($featureMap as $frontendKey => $dbKey) {
                $data[$dbKey] = in_array($frontendKey, $features);
            }

            // Handle basic cost
            $basicCost = $request->input('basic_cost', []);
            $data['basic_cost_description'] = $basicCost['description'] ?? [];
            $data['basic_cost_quantity'] = $basicCost['quantity'] ?? [];
            $data['basic_cost_rate'] = $basicCost['rate'] ?? [];
            $data['basic_cost_total'] = $basicCost['total'] ?? [];
            $data['basic_cost_total_amount'] = $validated['basic_subtotal'] ?? 0;

            // Handle additional cost
            $additionalCost = $request->input('additional_cost', []);
            $data['additional_cost_description'] = $additionalCost['description'] ?? [];
            $data['additional_cost_quantity'] = $additionalCost['quantity'] ?? [];
            $data['additional_cost_rate'] = $additionalCost['rate'] ?? [];
            $data['additional_cost_total'] = $additionalCost['total'] ?? [];
            $data['additional_cost_total_amount'] = $validated['additional_subtotal'] ?? 0;

            // Handle maintenance/support cost
            $maintenanceCost = $request->input('maintenance_cost', []);
            $data['support_description'] = $maintenanceCost['description'] ?? [];
            $data['support_quantity'] = $maintenanceCost['quantity'] ?? [];
            $data['support_rate'] = $maintenanceCost['rate'] ?? [];
            $data['support_total'] = $maintenanceCost['total'] ?? [];
            $data['support_total_amount'] = $validated['maintenance_subtotal'] ?? 0;

            // Handle custom terms - convert textarea to array
            $data['custom_terms_and_conditions'] = !empty($validated['custom_terms_text']) 
                ? array_filter(array_map('trim', explode("\n", $validated['custom_terms_text']))) 
                : [];
            
            // Handle file upload
            if ($request->hasFile('contract_copy')) {
                $data['contract_copy'] = $request->file('contract_copy')->store('quotations/contracts', 'public');
            }

            // Update quotation
            $quotation->update($data);
            
            // Only update user accounts if quotation is already converted to company (customer_type = 'existing')
            if ($quotation->customer_type === 'existing' && $quotation->customer_id) {
                // Update or create user account for company email
                if (!empty($validated['company_email'])) {
                    $companyUser = User::where('email', $oldCompanyEmail)
                        ->orWhere('email', $validated['company_email'])
                        ->first();
                    
                    if ($companyUser) {
                        // Update existing user
                        $updateData = [
                            'email' => $validated['company_email'],
                            'name' => $validated['contact_person_1'] . ' (Company)',
                            'mobile_no' => $validated['contact_number_1'] ?? '',
                            'address' => $validated['address'] ?? '',
                        ];
                        
                        // Update password if provided
                        if (!empty($validated['company_password'])) {
                            $updateData['password'] = Hash::make($validated['company_password']);
                            \Log::info('Updated company user password for existing company', [
                                'email' => $validated['company_email'],
                                'quotation_id' => $quotation->id
                            ]);
                        }
                        
                        $companyUser->update($updateData);
                    }
                }
                
                // Update or create user account for employee email
                if (!empty($validated['company_employee_email'])) {
                    $employeeUser = User::where('email', $oldEmployeeEmail)
                        ->orWhere('email', $validated['company_employee_email'])
                        ->first();
                    
                    if ($employeeUser) {
                        // Update existing user
                        $updateData = [
                            'email' => $validated['company_employee_email'],
                            'name' => $validated['contact_person_1'] . ' (Employee)',
                            'mobile_no' => $validated['contact_number_1'] ?? '',
                            'address' => $validated['address'] ?? '',
                        ];
                        
                        // Update password if provided
                        if (!empty($validated['company_employee_password'])) {
                            $updateData['password'] = Hash::make($validated['company_employee_password']);
                        }
                        
                        $employeeUser->update($updateData);
                    }
                }
            }

            // Prepare success message
            $message = 'Quotation updated successfully.';
            if ($quotation->customer_type === 'new') {
                $message .= ' Note: Login credentials will be created when you convert this quotation to a company.';
            } else if (!empty($validated['company_password'])) {
                $message .= ' Login credentials have been updated.';
            }

            return redirect()->route('quotations.index')
                ->with('status', $message);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw validation exceptions so Laravel can handle them properly
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error updating quotation: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Error updating quotation: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified quotation from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.delete quotation'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        try {
            $quotation = Quotation::findOrFail($id);
            
            // Delete associated files if they exist
            if ($quotation->contract_copy_path && Storage::disk('public')->exists($quotation->contract_copy_path)) {
                Storage::disk('public')->delete($quotation->contract_copy_path);
            }
            
            // Delete the quotation
            $quotation->delete();
            
            return redirect()
                ->route('quotations.index')
                ->with('success', 'Quotation deleted successfully');
                
        } catch (\Exception $e) {
            Log::error('Error deleting quotation: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Error deleting quotation. Please try again.');
        }
    }

    public function createFromInquiry(int $id): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.create quotation'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $inquiry = Inquiry::with('followUps')->findOrFail($id);
        
        // Generate next quotation code
        $lastQuotation = Quotation::orderByDesc('id')->first();
        $nextNumber = 1;
        if ($lastQuotation && !empty($lastQuotation->unique_code)) {
            if (preg_match('/(\d+)$/', $lastQuotation->unique_code, $matches)) {
                $nextNumber = ((int) $matches[1]) + 1;
            }
        }
        $nextCode = 'CMS/QUAT/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        
        // Get companies for dropdown
        $companies = Company::select('id', 'company_name')
            ->orderBy('company_name')
            ->get();
        
        // Try to find matching company by name
        $matchingCompany = Company::where('company_name', 'LIKE', '%' . $inquiry->company_name . '%')
            ->orWhere('company_name', $inquiry->company_name)
            ->first();
        
        // Map industry type to company type
        $companyType = '';
        if ($inquiry->industry_type) {
            $industryMapping = [
                'Information Technology' => 'INFORMATION_TECHNOLOGY',
                'Business Process Outsourcing (BPO)' => 'BPO_KPO',
                'Manufacturing' => 'MANUFACTURING',
                'Automobile' => 'AUTOMOBILE',
                'Textiles & Apparel' => 'TEXTILES',
                'Pharmaceuticals & Healthcare' => 'PHARMACEUTICALS',
                'Banking, Financial Services & Insurance (BFSI)' => 'BANKING_FINANCIAL',
                'Retail & E-commerce' => 'RETAIL',
                'Telecommunications' => 'TELECOMMUNICATIONS',
                'Real Estate & Construction' => 'REAL_ESTATE',
                'Education & Training' => 'EDUCATION_TRAINING',
                'Hospitality & Tourism' => 'HOSPITALITY',
                'Logistics & Transportation' => 'LOGISTICS_SUPPLY',
                'Agriculture & Agritech' => 'AGRICULTURE',
                'Media & Entertainment' => 'MEDIA_ENTERTAINMENT',
            ];
            $companyType = $industryMapping[$inquiry->industry_type] ?? '';
        }
        
        // Pre-populate quotation data from inquiry - map all available fields
        $quotationData = [
            'company_name' => $inquiry->company_name,
            'address' => $inquiry->company_address,
            'contact_person' => $inquiry->contact_name,
            'contact_number_1' => $inquiry->company_phone ?? $inquiry->contact_mobile,
            'contact_mobile' => $inquiry->contact_mobile,
            'email' => $inquiry->email ?? '',
            'gst_no' => $inquiry->gst_no ?? '',
            'industry_type' => $inquiry->industry_type,
            'company_type' => $companyType,
            'quotation_date' => date('d/m/Y'),
            'inquiry_id' => $inquiry->id,
            'customer_type' => $matchingCompany ? 'existing' : 'new',
            'customer_id' => $matchingCompany ? $matchingCompany->id : null,
            'state' => $inquiry->state,
            'city' => $inquiry->city,
            'scope_link' => $inquiry->scope_link,
            'contact_position' => $inquiry->contact_position,
        ];
        
        return view('quotations.create', compact('inquiry', 'nextCode', 'companies', 'quotationData'));
    }

    /**
     * Generate and download a PDF version of the quotation
     *
     * @param int $id Quotation ID
     * @return \Illuminate\Http\Response
     */
    public function download(int $id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.download quotation'))) {
            abort(403);
        }
        
        $quotation = Quotation::findOrFail($id);
        return view('quotations.pdf', compact('quotation'));

        // $pdf = Pdf::loadView('quotations.pdf', compact('quotation'))
        //     ->setPaper('a4', 'portrait')
        //     ->setOptions([
        //         'defaultFont' => 'sans-serif',
        //         'isHtml5ParserEnabled' => true,
        //         'isRemoteEnabled' => true,
        //     ]);
        
        // $filename = 'quotation-' . str_replace(['/', '\\'], '-', $quotation->unique_code) . '.pdf';
        
        // return $pdf->download($filename);
    }

    /**
     * View/Download contract file
     */
    public function viewContractFile(int $id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.contract generate'))) {
            abort(403);
        }
        
        $quotation = Quotation::findOrFail($id);
        
        if (!$quotation->contract_copy) {
            abort(404, 'Contract file not found');
        }
        
        $filePath = storage_path('app/public/' . $quotation->contract_copy);
        
        if (!file_exists($filePath)) {
            abort(404, 'Contract file not found');
        }
        
        return response()->file($filePath);
    }

    /**
     * Generate contract PDF (kept for backward compatibility)
     */
    public function generateContractPdf(int $id)
    {
        return $this->download($id);
    }

    public function generateContractPng(int $id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.contract generate'))) {
            abort(403);
        }
        
        $quotation = Quotation::findOrFail($id);
        
        // Generate PDF first
        $pdf = Pdf::loadView('quotations.contract-pdf', compact('quotation'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);
        
        // Save PDF temporarily
        $tempPdfPath = storage_path('app/temp/contract-' . $quotation->id . '.pdf');
        
        if (!file_exists(dirname($tempPdfPath))) {
            mkdir(dirname($tempPdfPath), 0755, true);
        }
        
        file_put_contents($tempPdfPath, $pdf->output());
        
        // Convert PDF to PNG using Imagick if available
        if (extension_loaded('imagick')) {
            $imagick = new \Imagick();
            $imagick->setResolution(300, 300);
            $imagick->readImage($tempPdfPath . '[0]'); // First page only
            $imagick->setImageFormat('png');
            $imagick->setImageBackgroundColor('white');
            $imagick->setImageAlphaChannel(\Imagick::ALPHACHANNEL_REMOVE);
            
            $filename = 'contract-' . $quotation->unique_code . '.png';
            
            // Clean up temp PDF
            unlink($tempPdfPath);
            
            return response($imagick->getImageBlob())
                ->header('Content-Type', 'image/png')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        }
        
        // Fallback: return PDF if Imagick not available
        unlink($tempPdfPath);
        return $this->generateContractPdf($id);
    }

    public function followUp(int $id): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.follow up'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $quotation = Quotation::findOrFail($id);
        $followUps = $quotation->followUps()->latest()->get();

        return view('quotations.follow_up', compact('quotation', 'followUps'));
    }

    public function storeFollowUp(Request $request, int $id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.follow up create'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $quotation = Quotation::findOrFail($id);
        
        $validated = $request->validate([
            'followup_date' => 'required|string',
            'next_followup_date' => 'nullable|date_format:d/m/Y',
            'demo_status' => 'nullable|string',
            'scheduled_demo_date' => 'nullable|date|required_if:demo_status,schedule',
            'scheduled_demo_time' => 'nullable|required_if:demo_status,schedule',
            'demo_date' => 'nullable|date|required_if:demo_status,yes',
            'demo_time' => 'nullable|required_if:demo_status,yes',
            'remark' => 'nullable|string',
            'quotation_note' => 'nullable|string',
        ]);

        // Parse followup_date from dd/mm/yy to Y-m-d
        $followupDate = null;
        if (!empty($validated['followup_date'])) {
            try {
                $followupDate = Carbon::createFromFormat('d/m/y', $validated['followup_date'])->format('Y-m-d');
            } catch (\Exception $e) {
                $followupDate = null;
            }
        }
        
        // Parse next_followup_date from dd/mm/yyyy to Y-m-d
        $nextFollowupDate = null;
        if (!empty($validated['next_followup_date'])) {
            try {
                $nextFollowupDate = Carbon::createFromFormat('d/m/Y', $validated['next_followup_date'])->format('Y-m-d');
            } catch (\Exception $e) {
                $nextFollowupDate = null;
            }
        }

        QuotationFollowUp::create([
            'quotation_id' => $quotation->id,
            'followup_date' => $followupDate,
            'next_followup_date' => $nextFollowupDate,
            'demo_status' => $validated['demo_status'] ?? null,
            'scheduled_demo_date' => $validated['scheduled_demo_date'] ?? null,
            'scheduled_demo_time' => $validated['scheduled_demo_time'] ?? null,
            'demo_date' => $validated['demo_date'] ?? null,
            'demo_time' => $validated['demo_time'] ?? null,
            'remark' => $validated['remark'] ?? null,
            'quotation_note' => $validated['quotation_note'] ?? null,
        ]);

        return back()->with('status', 'Follow-up added successfully!');
    }

    public function confirmFollowUp(Request $request, int $followUpId)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.follow up confirm'))) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Permission denied.'], 403);
            }
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $followUp = QuotationFollowUp::findOrFail($followUpId);
        $followUp->is_confirm = true;
        $followUp->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
            ]);
        }

        return back()->with('status', 'Follow-up confirmed successfully!');
    }

    /**
     * Helper method to get templates from quotation
     */
    private function getTemplatesFromQuotation($quotation): array
    {
        $templates = [];
        
        if ($quotation->terms_description && is_array($quotation->terms_description)) {
            foreach ($quotation->terms_description as $index => $description) {
                if (!empty($description)) {
                    $completionPercent = $quotation->terms_completion[$index] ?? 0;
                    $completionTerms = $quotation->completion_terms[$index] ?? '';
                    $amount = $quotation->terms_total[$index] ?? 0;
                    
                    $templates[] = [
                        'index' => $index,
                        'description' => $description,
                        'completion_percent' => $completionPercent,
                        'completion_terms' => $completionTerms,
                        'amount' => $amount,
                        'quantity' => $quotation->terms_quantity[$index] ?? 1,
                        'rate' => $quotation->terms_rate[$index] ?? 0,
                    ];
                }
            }
        }
        
        return $templates;
    }

    public function templateList(int $id): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.template list'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $quotation = Quotation::with('proformas')->findOrFail($id);
        
        // Generate templates based on payment terms (services_2)
        $templates = $this->getTemplatesFromQuotation($quotation);
        
        return view('quotations.template_list', compact('quotation', 'templates'));
    }

    public function createProforma(Request $request, int $id)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.create proforma'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $quotation = Quotation::findOrFail($id);
        $templateIndex = $request->get('template');
        
        // Generate next proforma code
        $lastProforma = Proforma::orderByDesc('id')->first();
        $nextNumber = 1;
        if ($lastProforma && !empty($lastProforma->unique_code)) {
            if (preg_match('/(\d+)$/', $lastProforma->unique_code, $matches)) {
                $nextNumber = ((int) $matches[1]) + 1;
            }
        }
        $nextCode = 'CMS/PROF/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        
        // Get template data if template index is provided
        $templateData = null;
        if ($templateIndex !== null && isset($quotation->terms_description[$templateIndex])) {
            $templateData = [
                'description' => $quotation->terms_description[$templateIndex] ?? '',
                'completion_percent' => $quotation->terms_completion[$templateIndex] ?? 0,
                'completion_terms' => $quotation->completion_terms[$templateIndex] ?? '',
                'amount' => $quotation->terms_total[$templateIndex] ?? 0,
                'quantity' => $quotation->terms_quantity[$templateIndex] ?? 1,
                'rate' => $quotation->terms_rate[$templateIndex] ?? 0,
            ];
        }
        
        // Redirect to performas.create with data
        return redirect()->route('performas.create', [
            'quotation_id' => $quotation->id,
            'template_data' => $templateData ? json_encode($templateData) : null,
            'template_index' => $templateIndex,
        ]);
    }

    public function storeProforma(Request $request, int $id): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.create proforma'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        try {
            $quotation = Quotation::findOrFail($id);
            
            $validated = $request->validate([
                'proforma_date' => 'required|date',
                'company_name' => 'required|string|max:255',
                'bill_no' => 'nullable|string|max:255',
                'address' => 'nullable|string',
                'gst_no' => 'nullable|string|max:255',
                'mobile_no' => 'nullable|string|max:50',
                'type_of_billing' => 'nullable|string',
            ]);

            // Generate unique code
            $lastProforma = Proforma::orderByDesc('id')->first();
            $nextNumber = 1;
            if ($lastProforma && !empty($lastProforma->unique_code)) {
                if (preg_match('/(\d+)$/', $lastProforma->unique_code, $matches)) {
                    $nextNumber = ((int) $matches[1]) + 1;
                }
            }
            $validated['unique_code'] = 'CMS/PROF/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            $validated['quotation_id'] = $quotation->id;

            // Handle repeater fields
            $validated['description'] = $request->input('description', []);
            $validated['sac_code'] = $request->input('sac_code', []);
            $validated['quantity'] = $request->input('quantity', []);
            $validated['rate'] = $request->input('rate', []);
            $validated['total'] = $request->input('total', []);

            // Handle calculations
            $validated['sub_total'] = $request->input('sub_total', 0);
            $validated['discount_percent'] = $request->input('discount_percent', 0);
            $validated['discount_amount'] = $request->input('discount_amount', 0);
            $validated['cgst_percent'] = $request->input('cgst_percent', 0);
            $validated['cgst_amount'] = $request->input('cgst_amount', 0);
            $validated['sgst_percent'] = $request->input('sgst_percent', 0);
            $validated['sgst_amount'] = $request->input('sgst_amount', 0);
            $validated['igst_percent'] = $request->input('igst_percent', 0);
            $validated['igst_amount'] = $request->input('igst_amount', 0);
            $validated['final_amount'] = $request->input('final_amount', 0);
            $validated['total_tax_amount'] = $request->input('total_tax_amount', 0);
            $validated['billing_item'] = $request->input('billing_item', 0);
            $validated['tds_amount'] = $request->input('tds_amount');
            $validated['remark'] = $request->input('remark');

            Proforma::create($validated);

            return redirect()->route('quotations.template-list', $quotation->id)
                ->with('success', 'Proforma created successfully');

        } catch (\Exception $e) {
            \Log::error('Error creating proforma: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Error creating proforma: ' . $e->getMessage());
        }
    }

    public function convertToCompany(int $id): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Quotations Management.convert to company'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        try {
            $quotation = Quotation::findOrFail($id);
            
            // Check if quotation is for a new customer
            if ($quotation->customer_type !== 'new') {
                return redirect()->back()
                    ->with('error', 'Only quotations with new customers can be converted to companies.');
            }
            
            // Check if all template lists are completed (all proformas generated)
            $templates = $this->getTemplatesFromQuotation($quotation);
            if (count($templates) > 0) {
                $pendingTemplates = [];
                foreach ($templates as $template) {
                    $proformaGenerated = $quotation->proformas()->where('type_of_billing', $template['description'])->first();
                    if (!$proformaGenerated) {
                        $pendingTemplates[] = $template['description'];
                    }
                }
                
                if (count($pendingTemplates) > 0) {
                    $pendingList = implode(', ', $pendingTemplates);
                    return redirect()->back()
                        ->with('error', 'Cannot convert to company. Please complete all template lists first. Pending: ' . $pendingList);
                }
            }
            
            // Check if required fields are provided
            if (empty($quotation->company_name)) {
                return redirect()->back()
                    ->with('error', 'Company name is required to convert to company.');
            }
            
            if (empty($quotation->company_email)) {
                return redirect()->back()
                    ->with('error', 'Company email is required to convert to company.');
            }
            
            if (empty($quotation->contact_person_1)) {
                return redirect()->back()
                    ->with('error', 'Contact person name is required to convert to company.');
            }
            
            if (empty($quotation->contact_number_1)) {
                return redirect()->back()
                    ->with('error', 'Contact person mobile number is required to convert to company.');
            }
            
            // Check if company with same email already exists
            $existingCompany = Company::where('company_email', $quotation->company_email)->first();
            if ($existingCompany) {
                return redirect()->back()
                    ->with('error', 'A company with email "' . $quotation->company_email . '" already exists.');
            }
            
            // Create company from quotation data
            $companyData = [
                'company_name' => $quotation->company_name,
                'company_type' => $quotation->company_type ?? 'OTHER',
                'gst_no' => $quotation->gst_no ?? '',
                'pan_no' => $quotation->pan_no ?? '',
                'other_details' => $quotation->nature_of_work ?? '',
                'city' => $quotation->city ?? 'Not Specified',
                'state' => $quotation->state ?? 'Not Specified',
                'company_address' => $quotation->address ?? 'Address not provided',
                'company_email' => $quotation->company_email,
                'company_password' => $quotation->company_password ?? '',
                'company_employee_email' => $quotation->company_employee_email ?? '',
                'company_employee_password' => $quotation->company_employee_password ?? '',
                'contact_person_name' => $quotation->contact_person_1,
                'contact_person_mobile' => $quotation->contact_number_1,
                'contact_person_position' => $quotation->position_1 ?? '',
                'person_name_1' => $quotation->contact_person_1,
                'person_number_1' => $quotation->contact_number_1,
                'person_position_1' => $quotation->position_1 ?? '',
                'person_name_2' => $quotation->contact_person_2,
                'person_number_2' => $quotation->contact_number_2,
                'person_position_2' => $quotation->position_2,
                'person_name_3' => $quotation->contact_person_3,
                'person_number_3' => $quotation->contact_number_3,
                'person_position_3' => $quotation->position_3,
            ];
            
            $newCompany = Company::create($companyData);
            
            \Log::info('Company created successfully from quotation conversion', [
                'company_id' => $newCompany->id,
                'company_name' => $newCompany->company_name,
                'unique_code' => $newCompany->unique_code,
                'quotation_id' => $quotation->id
            ]);
            
            // Create user accounts for login
            $companyUserCreated = false;
            $employeeUserCreated = false;
            
            // Create user account for company email
            if (!empty($quotation->company_email) && !empty($quotation->company_password)) {
                $existingUser = User::where('email', $quotation->company_email)->first();
                
                if (!$existingUser) {
                    $user = User::create([
                        'name' => $quotation->contact_person_1 . ' (Company)',
                        'email' => $quotation->company_email,
                        'password' => Hash::make($quotation->company_password),
                        'mobile_no' => $quotation->contact_number_1 ?? '',
                        'address' => $quotation->address ?? '',
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
                    
                    \Log::info('Company user account created from quotation conversion', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'company_id' => $newCompany->id
                    ]);
                }
            }
            
            // Create user account for employee email if provided
            if (!empty($quotation->company_employee_email) && !empty($quotation->company_employee_password)) {
                $existingEmployeeUser = User::where('email', $quotation->company_employee_email)->first();
                
                if (!$existingEmployeeUser) {
                    $employeeUser = User::create([
                        'name' => $quotation->contact_person_1 . ' (Employee)',
                        'email' => $quotation->company_employee_email,
                        'password' => Hash::make($quotation->company_employee_password),
                        'mobile_no' => $quotation->contact_number_1 ?? '',
                        'address' => $quotation->address ?? '',
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
                    
                    \Log::info('Employee user account created from quotation conversion', [
                        'user_id' => $employeeUser->id,
                        'email' => $employeeUser->email,
                        'company_id' => $newCompany->id
                    ]);
                }
            }
            
            // Update quotation to link to the new company
            $quotation->update([
                'customer_type' => 'existing',
                'customer_id' => $newCompany->id
            ]);
            
            // Prepare success message with credentials
            $successMessage = 'Company "' . $quotation->company_name . '" has been created successfully and linked to the quotation.';
            
            // Show company and employee credentials
            if ($companyUserCreated && !empty($quotation->company_email) && !empty($quotation->company_password)) {
                $successMessage .= '|||COMPANY_CREATED|||' . $quotation->company_email . '|||' . $quotation->company_password;
            }
            
            if ($employeeUserCreated && !empty($quotation->company_employee_email) && !empty($quotation->company_employee_password)) {
                $successMessage .= '|||EMPLOYEE_CREATED|||' . $quotation->company_employee_email . '|||' . $quotation->company_employee_password;
            }
            
            return redirect()->back()
                ->with('success', $successMessage);
                
        } catch (\Exception $e) {
            \Log::error('Error converting quotation to company: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error converting to company: ' . $e->getMessage());
        }
    }

    /**
     * Cleanup orphaned quotations (where customer_id points to deleted companies)
     */
    public function cleanupOrphanedQuotations(): RedirectResponse
    {
        try {
            // Find quotations with customer_id pointing to non-existent companies
            $orphanedQuotations = Quotation::where('customer_type', 'existing')
                ->whereNotNull('customer_id')
                ->whereNotExists(function ($query) {
                    $query->select('id')
                        ->from('companies')
                        ->whereColumn('companies.id', 'quotations.customer_id');
                })
                ->get();

            if ($orphanedQuotations->count() > 0) {
                // Reset orphaned quotations to new customer type
                $quotationIds = $orphanedQuotations->pluck('id')->toArray();
                
                Quotation::whereIn('id', $quotationIds)->update([
                    'customer_type' => 'new',
                    'customer_id' => null
                ]);

                \Log::info('Manual cleanup of orphaned quotations completed', [
                    'quotation_ids' => $quotationIds,
                    'count' => count($quotationIds)
                ]);

                return redirect()->back()
                    ->with('success', 'Cleaned up ' . count($quotationIds) . ' orphaned quotations. Convert buttons are now available.');
            } else {
                return redirect()->back()
                    ->with('info', 'No orphaned quotations found.');
            }
        } catch (\Exception $e) {
            \Log::error('Error cleaning up orphaned quotations: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error cleaning up orphaned quotations: ' . $e->getMessage());
        }
    }
}

