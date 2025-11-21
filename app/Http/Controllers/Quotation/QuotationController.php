<?php
namespace App\Http\Controllers\Quotation;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Quotation;
use App\Models\QuotationFollowUp;
use App\Models\Proforma;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        try {
            $perPage = $request->get('per_page', 25);
            $query = Quotation::with(['followUps' => function ($q) {
                $q->where('is_confirm', true)->latest();
            }])
                ->select('id', 'unique_code', 'company_name', 'contact_number_1', 'quotation_date', 'service_contract_amount', 'created_at', 'updated_at', 'tentative_complete_date')
                ->orderBy('created_at', 'desc');
            
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
            
            // Get quotation IDs with confirmed follow-ups
            $confirmedQuotationIds = QuotationFollowUp::where('is_confirm', true)
                ->pluck('quotation_id')
                ->unique()
                ->toArray();
            
            return view('quotations.index', compact('quotations', 'confirmedQuotationIds'));
        } catch (\Exception $e) {
            Log::error('Quotations index error: ' . $e->getMessage());
            $quotations = Quotation::paginate(25);
            $confirmedQuotationIds = [];
            return view('quotations.index', compact('quotations', 'confirmedQuotationIds'))->with('error', 'Error loading quotations');
        }
    }
    
    /**
     * Export quotations to Excel
     */
    public function export(Request $request)
    {
        try {
            $query = Quotation::query()->orderBy('created_at', 'desc');
            
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
                    'address' => $company->company_address ?? ($company->address ?? ''),
                    'company_email' => $company->company_email ?? '',
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
        //dd($request->all());
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

        // Debug: Uncomment to see filtered data
        // dd($request->all());

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
                'company_password' => ['nullable', 'string', 'max:255'],
                'gst_no' => ['nullable', 'string', 'max:50'],
                'pan_no' => ['nullable', 'string', 'max:50'],
                'nature_of_work' => ['nullable', 'string', 'max:500'],
                'city' => ['nullable', 'string', 'max:100'],
                'state' => ['nullable', 'string', 'max:100'],
                'address' => ['nullable', 'string', 'max:500'],
                'scope_of_work' => ['nullable', 'string', 'max:1000'],
                
                // Contact Information
                'contact_person_1' => ['required', 'string', 'max:255'],
                'contact_number_1' => ['required', 'regex:/^\d{10}$/'],
                'position_1' => ['nullable', 'string', 'max:255'],
                'contact_person_2' => ['nullable', 'string', 'max:255'],
                'contact_number_2' => ['nullable', 'regex:/^\d{10}$/'],
                'position_2' => ['nullable', 'string', 'max:255'],
                'contact_person_3' => ['nullable', 'string', 'max:255'],
                'contact_number_3' => ['nullable', 'regex:/^\d{10}$/'],
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
                'mobile_no' => ['nullable', 'regex:/^\d{10}$/'],
                'footer_company_name' => ['nullable', 'string', 'max:255'],
                
                // Service Amounts
                'contract_amount' => ['nullable', 'numeric', 'min:0'],
                'basic_subtotal' => ['nullable', 'numeric', 'min:0'],
                'additional_subtotal' => ['nullable', 'numeric', 'min:0'],
                'maintenance_subtotal' => ['nullable', 'numeric', 'min:0'],
            ]);
            
            // Validate that at least one service is provided
            if (empty($services1['description']) || count($services1['description']) === 0) {
                return redirect()->back()->withInput()
                    ->with('error', 'Please add at least one service to the quotation.');
            }

            // Prepare data for database using validated data
            $data = [
                'unique_code' => $nextCode,
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
                'amc_start_date' => $validated['amc_start_date'] ?? null,
                'amc_amount' => $validated['amc_amount'] ?? 0,
                'project_start_date' => $validated['project_start_date'] ?? null,
                'completion_time' => $validated['completion_time'] ?? null,
                'retention_time' => $validated['retention_time'] ?? null,
                'retention_amount' => $validated['retention_amount'] ?? 0,
                'retention_percent' => $validated['retention_percent'] ?? 0,
                'tentative_complete_date' => $validated['tentative_complete_date'] ?? null,
                'prepared_by' => $validated['prepared_by'] ?? null,
                'mobile_no' => $validated['mobile_no'] ?? null,
                'own_company_name' => $validated['footer_company_name'] ?? 'CHITRI INFOTECH PVT LTD',
                
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
                
                // Custom terms
                'custom_terms_and_conditions' => $request->input('custom_terms', []),
                
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

            return redirect()->route('quotations.index')
                ->with('status', 'Quotation created successfully with ID: ' . $quotation->unique_code);

        } catch (\Exception $e) {
            \Log::error('Error creating quotation: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Error creating quotation: ' . $e->getMessage());
        }
    }
    

    public function show(int $id): View
    {
        $quotation = Quotation::findOrFail($id);
        return view('quotations.show', compact('quotation'));
    }

    public function edit(int $id): View
    {
        $quotation = Quotation::findOrFail($id);
        $companies = Company::select('id', 'company_name')->orderBy('company_name')->get();
        return view('quotations.edit', compact('quotation', 'companies'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        try {
            $quotation = Quotation::findOrFail($id);
            
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
                'gst_no' => ['nullable', 'string', 'max:50'],
                'pan_no' => ['nullable', 'string', 'max:50'],
                'nature_of_work' => ['nullable', 'string', 'max:500'],
                'city' => ['nullable', 'string', 'max:100'],
                'state' => ['nullable', 'string', 'max:100'],
                'address' => ['nullable', 'string', 'max:500'],
                'scope_of_work' => ['nullable', 'string', 'max:1000'],
                
                // Contact Information
                'contact_person_1' => ['required', 'string', 'max:255'],
                'contact_number_1' => ['required', 'regex:/^\d{10}$/'],
                'position_1' => ['nullable', 'string', 'max:255'],
                'contact_person_2' => ['nullable', 'string', 'max:255'],
                'contact_number_2' => ['nullable', 'regex:/^\d{10}$/'],
                'position_2' => ['nullable', 'string', 'max:255'],
                'contact_person_3' => ['nullable', 'string', 'max:255'],
                'contact_number_3' => ['nullable', 'regex:/^\d{10}$/'],
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
                'mobile_no' => ['nullable', 'regex:/^\d{10}$/'],
                'footer_company_name' => ['nullable', 'string', 'max:255'],
                
                // Service Amounts
                'contract_amount' => ['nullable', 'numeric', 'min:0'],
                'basic_subtotal' => ['nullable', 'numeric', 'min:0'],
                'additional_subtotal' => ['nullable', 'numeric', 'min:0'],
                'maintenance_subtotal' => ['nullable', 'numeric', 'min:0'],
            ]);

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
                'mobile_no' => $validated['mobile_no'] ?? null,
                'own_company_name' => $validated['footer_company_name'] ?? 'CHITRI INFOTECH PVT LTD',
            ];

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

            // Handle custom terms
            $data['custom_terms_and_conditions'] = $request->input('custom_terms', []);
            
            // Handle file upload
            if ($request->hasFile('contract_copy')) {
                $data['contract_copy'] = $request->file('contract_copy')->store('quotations/contracts', 'public');
            }

            // Update quotation
            $quotation->update($data);

            return redirect()->route('quotations.index')
                ->with('status', 'Quotation updated successfully');

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
        
        // Pre-populate quotation data from inquiry
        $quotationData = [
            'company_name' => $inquiry->company_name,
            'address' => $inquiry->company_address,
            'contact_person' => $inquiry->contact_name,
            'contact_number_1' => $inquiry->company_phone,
            'email' => $inquiry->company_email ?? '',
            'gst_no' => $inquiry->gst_no ?? '',
            'industry_type' => $inquiry->industry_type,
            'quotation_date' => date('Y-m-d'),
            'inquiry_id' => $inquiry->id,
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
        $quotation = Quotation::findOrFail($id);
        $followUps = $quotation->followUps()->latest()->get();

        return view('quotations.follow_up', compact('quotation', 'followUps'));
    }

    public function storeFollowUp(Request $request, int $id)
    {
        $quotation = Quotation::findOrFail($id);
        
        $validated = $request->validate([
            'followup_date' => 'required|string',
            'next_followup_date' => 'nullable|date',
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

        QuotationFollowUp::create([
            'quotation_id' => $quotation->id,
            'followup_date' => $followupDate,
            'next_followup_date' => $validated['next_followup_date'] ?? null,
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

    public function templateList(int $id): View
    {
        $quotation = Quotation::with('proformas')->findOrFail($id);
        
        // Generate templates based on payment terms (services_2)
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
        
        return view('quotations.template_list', compact('quotation', 'templates'));
    }

    public function createProforma(Request $request, int $id)
    {
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
        try {
            $quotation = Quotation::findOrFail($id);
            
            $validated = $request->validate([
                'proforma_date' => 'required|date',
                'company_name' => 'required|string|max:255',
                'bill_no' => 'nullable|string|max:255',
                'address' => 'nullable|string',
                'gst_no' => 'nullable|string|max:255',
                'mobile_no' => 'nullable|string|max:20',
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
}