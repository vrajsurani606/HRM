<?php
namespace App\Http\Controllers\Quotation;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Quotation;
use App\Models\Company;
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
            $query = Quotation::select('id', 'unique_code', 'company_name', 'contact_number_1', 'quotation_date', 'service_contract_amount', 'created_at', 'updated_at', 'tentative_complete_date')
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
            
            return view('quotations.index', compact('quotations'));
        } catch (\Exception $e) {
            Log::error('Quotations index error: ' . $e->getMessage());
            $quotations = Quotation::paginate(25);
            return view('quotations.index', compact('quotations'))->with('error', 'Error loading quotations');
        }
    }
    
    /**
     * Export quotations to Excel
     */
    public function export()
    {
        return redirect()->back()->with('info', 'Excel export feature will be available soon.');
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
        // Filter out empty service rows
        $services1 = [
            'description' => [],
            'quantity' => [],
            'rate' => [],
            'total' => []
        ];

        if ($request->has('services_1.description')) {
            foreach ($request->services_1['description'] as $index => $description) {
                $quantity = $request->services_1['quantity'][$index] ?? '0';
                $rate = $request->services_1['rate'][$index] ?? '0';
                $total = $request->services_1['total'][$index] ?? '0';
                
                // Only add if at least one field has a value
                if (!empty($description) || $quantity !== '0' || $rate !== '0') {
                    $services1['description'][] = $description;
                    $services1['quantity'][] = $quantity;
                    $services1['rate'][] = $rate;
                    $services1['total'][] = $total;
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
            
            // Debug: Log the request data (can be removed in production)
            \Log::info('Basic cost data received:', [
                'basic_cost_raw' => $request->input('basic_cost'),
            ]);
            
            // Basic validation
            $request->validate([
                'quotation_title' => 'required|string|max:255',
                'quotation_date' => 'required|date',
                'customer_type' => 'required|string|in:new,existing',
                'company_name' => 'required|string|max:255',
            ]);
            
            // Validate file only if uploaded
            if ($request->hasFile('contract_copy')) {
                $request->validate([
                    'contract_copy' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:20480',
                ]);
            }

            // Prepare data for database
            $data = [
                'unique_code' => $nextCode,
                'quotation_title' => $request->quotation_title,
                'quotation_date' => $request->quotation_date,
                'customer_type' => $request->customer_type,
                'customer_id' => $request->customer_id,
                'gst_no' => $request->gst_no,
                'pan_no' => $request->pan_no,
                'company_name' => $request->company_name,
                'company_type' => $request->company_type,
                'nature_of_work' => $request->nature_of_work,
                'city' => $request->city,
                'state' => $request->state,
                'scope_of_work' => $request->scope_of_work,
                'address' => $request->address,
                'contact_person_1' => $request->contact_person_1,
                'contact_number_1' => $request->contact_number_1,
                'position_1' => $request->position_1,
                'contact_person_2' => $request->contact_person_2,
                'contact_number_2' => $request->contact_number_2,
                'position_2' => $request->position_2,
                'contact_person_3' => $request->contact_person_3,
                'contact_number_3' => $request->contact_number_3,
                'position_3' => $request->position_3,
                'contract_details' => $request->contract_details,
                'company_email' => $request->company_email,
                'company_password' => $request->company_password,
                'amc_start_date' => $request->amc_start_date,
                'amc_amount' => $request->amc_amount,
                'project_start_date' => $request->project_start_date,
                'completion_time' => $request->completion_time,
                'retention_time' => $request->retention_time,
                'retention_amount' => $request->retention_amount,
                'retention_percent' => $request->retention_percent,
                'tentative_complete_date' => $request->tentative_complete_date,
                'prepared_by' => $request->prepared_by,
                'mobile_no' => $request->mobile_no,
                'own_company_name' => $request->footer_company_name,
                
                // Service data (from services_1 table) - using filtered data
                'service_description' => $services1['description'] ?? [],
                'service_quantity' => $services1['quantity'] ?? [],
                'service_rate' => $services1['rate'] ?? [],
                'service_total' => $services1['total'] ?? [],
                'service_contract_amount' => $request->contract_amount ?? 0,
                
                // Terms data (from services_2 table) - preserve all array values
                'terms_description' => $request->input('services_2.description', []),
                'terms_quantity' => $request->input('services_2.quantity', []),
                'terms_rate' => $request->input('services_2.rate', []),
                'terms_total' => $request->input('services_2.total', []),
                'terms_completion' => $request->input('services_2.completion_percent', []),
                'completion_terms' => $request->input('services_2.completion_terms', []),
                'terms_tentative_complete_date' => $request->tentative_complete_date_2,
                
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
                'basic_cost_total_amount' => $request->basic_subtotal ?? 0,
                
                // Additional cost data - preserve all array values including empty ones
                'additional_cost_description' => $request->input('additional_cost.description', []),
                'additional_cost_quantity' => $request->input('additional_cost.quantity', []),
                'additional_cost_rate' => $request->input('additional_cost.rate', []),
                'additional_cost_total' => $request->input('additional_cost.total', []),
                'additional_cost_total_amount' => $request->additional_subtotal ?? 0,
                
                // Support/Maintenance cost data - preserve all array values including empty ones
                'support_description' => $request->input('maintenance_cost.description', []),
                'support_quantity' => $request->input('maintenance_cost.quantity', []),
                'support_rate' => $request->input('maintenance_cost.rate', []),
                'support_total' => $request->input('maintenance_cost.total', []),
                'support_total_amount' => $request->maintenance_subtotal ?? 0,
            ];
            
            // Handle file upload
            if ($request->hasFile('contract_copy')) {
                $data['contract_copy'] = $request->file('contract_copy')->store('quotations/contracts', 'public');
            }

            // Debug log - remove in production
            \Log::info('All repeater data to be saved:', [
                'terms_description' => $data['terms_description'],
                'basic_cost_description' => $data['basic_cost_description'],
                'additional_cost_description' => $data['additional_cost_description'],
                'support_description' => $data['support_description'],
            ]);

            // Create quotation
            $quotation = Quotation::create($data);

            return redirect()->route('quotations.index')
                ->with('success', 'Quotation created successfully with ID: ' . $quotation->unique_code);

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
        return view('quotations.edit', compact('quotation'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $quotation = Quotation::findOrFail($id);

        $validated = $request->validate([
            'quotation_title' => 'required|string|max:255',
            'quotation_date' => 'required|date',
            'customer_type' => 'required|string|in:new,existing',
            'customer_id' => 'nullable|integer',
            'gst_no' => 'nullable|string|max:255',
            'pan_no' => 'nullable|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_type' => 'nullable|string|max:255',
            'nature_of_work' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'scope_of_work' => 'nullable|string',
            'address' => 'nullable|string',
            'contact_person_1' => 'required|string|max:255',
            'contact_number_1' => 'required|string|regex:/^[0-9]{10}$/',
            'position_1' => 'nullable|string|max:255',
            'contract_copy' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:4096',
            'contract_details' => 'nullable|string',
            'company_email' => 'required|email|max:255',
            'company_password' => 'nullable|string|max:255',
            'amc_start_date' => 'nullable|date',
            'amc_amount' => 'nullable|numeric',
            'project_start_date' => 'nullable|date',
            'completion_time' => 'nullable|string|max:255',
            'retention_time' => 'nullable|string|max:255',
            'retention_amount' => 'nullable|numeric',
            'tentative_complete_date' => 'nullable|date',
            'tentative_complete_date_2' => 'nullable|date',
            'contract_amount' => 'nullable|numeric|min:0',
            'retention_percent' => 'nullable|numeric|min:0|max:100',
            'custom_terms' => 'nullable|string',
            'prepared_by' => 'nullable|string|max:255',
            'mobile_no' => 'nullable|string|regex:/^[0-9]{10}$/',
            'footer_company_name' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
            
            'services_1' => 'nullable|array',
            'services_2' => 'nullable|array',
            'features' => 'nullable|array',
            'basic_cost' => 'nullable|array',
            'additional_cost' => 'nullable|array',
            'maintenance_cost' => 'nullable|array',
        ]);

        if ($request->hasFile('contract_copy')) {
            $validated['contract_copy_path'] = $request->file('contract_copy')->store('quotations/contracts', 'public');
        }

        $validated['services_1'] = json_encode($validated['services_1'] ?? []);
        $validated['services_2'] = json_encode($validated['services_2'] ?? []);
        $validated['features'] = json_encode($validated['features'] ?? []);
        $validated['basic_cost'] = json_encode($validated['basic_cost'] ?? []);
        $validated['additional_cost'] = json_encode($validated['additional_cost'] ?? []);
        $validated['maintenance_cost'] = json_encode($validated['maintenance_cost'] ?? []);

        $quotation->update($validated);

        return redirect()
            ->route('quotations.show', $quotation->id)
            ->with('success', 'Quotation updated');
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
        $inquiry = Inquiry::findOrFail($id);
        return view('quotations.create', compact('inquiry'));
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
        
        $pdf = Pdf::loadView('quotations.pdf', compact('quotation'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);
        
        $filename = 'quotation-' . $quotation->unique_code . '.pdf';
        
        return $pdf->download($filename);
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
}