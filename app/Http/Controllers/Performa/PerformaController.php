<?php
namespace App\Http\Controllers\Performa;

use App\Http\Controllers\Controller;
use App\Models\Proforma;
use App\Models\Quotation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PerformaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Proforma::with('quotation')->latest();
        
        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('unique_code', 'like', '%' . $search . '%')
                  ->orWhere('company_name', 'like', '%' . $search . '%')
                  ->orWhere('bill_no', 'like', '%' . $search . '%');
            });
        }
        
        if ($request->filled('company_name')) {
            $query->where('company_name', 'like', '%' . $request->company_name . '%');
        }
        
        if ($request->filled('unique_code')) {
            $query->where('unique_code', 'like', '%' . $request->unique_code . '%');
        }
        
        if ($request->filled('mobile_no')) {
            $query->where('mobile_no', 'like', '%' . $request->mobile_no . '%');
        }
        
        if ($request->filled('from_date')) {
            $query->whereDate('proforma_date', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->whereDate('proforma_date', '<=', $request->to_date);
        }
        
        $perPage = $request->get('per_page', 25);
        $performas = $query->paginate($perPage)->appends($request->query());
        
        return view('performas.index', compact('performas'));
    }

    public function create(Request $request): View
    {
        // Generate next proforma code
        $lastProforma = Proforma::orderByDesc('id')->first();
        $nextNumber = 1;
        if ($lastProforma && !empty($lastProforma->unique_code)) {
            if (preg_match('/(\d+)$/', $lastProforma->unique_code, $matches)) {
                $nextNumber = ((int) $matches[1]) + 1;
            }
        }
        $nextCode = 'CMS/PROF/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        
        // Get quotation if quotation_id is provided
        $quotation = null;
        if ($request->filled('quotation_id')) {
            $quotation = Quotation::find($request->quotation_id);
        }
        
        // Get template data if provided
        $templateData = null;
        $templateIndex = null;
        if ($request->filled('template_data')) {
            $templateData = json_decode($request->template_data, true);
        }
        if ($request->filled('template_index')) {
            $templateIndex = $request->template_index;
        }
        
        return view('performas.create', compact('nextCode', 'quotation', 'templateData', 'templateIndex'));
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'quotation_id' => ['nullable', 'integer', 'exists:quotations,id'],
                'template_index' => ['nullable', 'integer'],
                'proforma_date' => ['required', 'date'],
                'company_name' => ['required', 'string', 'max:255'],
                'bill_no' => ['nullable', 'string', 'max:255'],
                'address' => ['nullable', 'string', 'max:500'],
                'gst_no' => ['nullable', 'string', 'max:50'],
                'mobile_no' => ['nullable', 'regex:/^\d{10}$/'],
                'type_of_billing' => ['nullable', 'string', 'max:255'],
                'sub_total' => ['nullable', 'numeric', 'min:0'],
                'discount_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'discount_amount' => ['nullable', 'numeric', 'min:0'],
                'retention_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'retention_amount' => ['nullable', 'numeric', 'min:0'],
                'cgst_percent' => ['nullable', 'numeric', 'min:0'],
                'cgst_amount' => ['nullable', 'numeric', 'min:0'],
                'sgst_percent' => ['nullable', 'numeric', 'min:0'],
                'sgst_amount' => ['nullable', 'numeric', 'min:0'],
                'igst_percent' => ['nullable', 'numeric', 'min:0'],
                'igst_amount' => ['nullable', 'numeric', 'min:0'],
                'final_amount' => ['nullable', 'numeric', 'min:0'],
                'tds_amount' => ['nullable', 'numeric', 'min:0'],
                'remark' => ['nullable', 'string', 'max:1000'],
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
            
            // Handle repeater fields - filter out empty rows
            $descriptions = $request->input('description', []);
            $sacCodes = $request->input('sac_code', []);
            $quantities = $request->input('quantity', []);
            $rates = $request->input('rate', []);
            $totals = $request->input('total', []);
            
            $filteredDescriptions = [];
            $filteredSacCodes = [];
            $filteredQuantities = [];
            $filteredRates = [];
            $filteredTotals = [];
            
            foreach ($descriptions as $index => $description) {
                // Only include rows that have at least a description or quantity
                if (!empty($description) || !empty($quantities[$index])) {
                    $filteredDescriptions[] = $description ?? '';
                    $filteredSacCodes[] = $sacCodes[$index] ?? '';
                    $filteredQuantities[] = $quantities[$index] ?? 0;
                    $filteredRates[] = $rates[$index] ?? 0;
                    $filteredTotals[] = $totals[$index] ?? 0;
                }
            }
            
            $validated['description'] = $filteredDescriptions;
            $validated['sac_code'] = $filteredSacCodes;
            $validated['quantity'] = $filteredQuantities;
            $validated['rate'] = $filteredRates;
            $validated['total'] = $filteredTotals;
            
            // Calculate total tax amount
            $validated['total_tax_amount'] = ($validated['cgst_amount'] ?? 0) + 
                                            ($validated['sgst_amount'] ?? 0) + 
                                            ($validated['igst_amount'] ?? 0);
            
            $proforma = Proforma::create($validated);
            
            return redirect()->route('performas.index')
                ->with('status', 'Proforma created successfully with ID: ' . $proforma->unique_code);
                
        } catch (\Exception $e) {
            \Log::error('Error creating proforma: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Error creating proforma: ' . $e->getMessage());
        }
    }

    public function show(int $id): View
    {
        $proforma = Proforma::with('quotation')->findOrFail($id);
        return view('performas.show', compact('proforma'));
    }

    public function edit(int $id): View
    {
        $proforma = Proforma::with('quotation')->findOrFail($id);
        return view('performas.edit', compact('proforma'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        try {
            $proforma = Proforma::findOrFail($id);
            
            $validated = $request->validate([
                'quotation_id' => ['nullable', 'integer', 'exists:quotations,id'],
                'proforma_date' => ['required', 'date'],
                'company_name' => ['required', 'string', 'max:255'],
                'bill_no' => ['nullable', 'string', 'max:255'],
                'address' => ['nullable', 'string', 'max:500'],
                'gst_no' => ['nullable', 'string', 'max:50'],
                'mobile_no' => ['nullable', 'regex:/^\d{10}$/'],
                'type_of_billing' => ['nullable', 'string', 'max:255'],
                'sub_total' => ['nullable', 'numeric', 'min:0'],
                'discount_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'discount_amount' => ['nullable', 'numeric', 'min:0'],
                'retention_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'retention_amount' => ['nullable', 'numeric', 'min:0'],
                'cgst_percent' => ['nullable', 'numeric', 'min:0'],
                'cgst_amount' => ['nullable', 'numeric', 'min:0'],
                'sgst_percent' => ['nullable', 'numeric', 'min:0'],
                'sgst_amount' => ['nullable', 'numeric', 'min:0'],
                'igst_percent' => ['nullable', 'numeric', 'min:0'],
                'igst_amount' => ['nullable', 'numeric', 'min:0'],
                'final_amount' => ['nullable', 'numeric', 'min:0'],
                'tds_amount' => ['nullable', 'numeric', 'min:0'],
                'remark' => ['nullable', 'string', 'max:1000'],
            ]);
            
            // Handle repeater fields - filter out empty rows
            $descriptions = $request->input('description', []);
            $sacCodes = $request->input('sac_code', []);
            $quantities = $request->input('quantity', []);
            $rates = $request->input('rate', []);
            $totals = $request->input('total', []);
            
            $filteredDescriptions = [];
            $filteredSacCodes = [];
            $filteredQuantities = [];
            $filteredRates = [];
            $filteredTotals = [];
            
            foreach ($descriptions as $index => $description) {
                // Only include rows that have at least a description or quantity
                if (!empty($description) || !empty($quantities[$index])) {
                    $filteredDescriptions[] = $description ?? '';
                    $filteredSacCodes[] = $sacCodes[$index] ?? '';
                    $filteredQuantities[] = $quantities[$index] ?? 0;
                    $filteredRates[] = $rates[$index] ?? 0;
                    $filteredTotals[] = $totals[$index] ?? 0;
                }
            }
            
            $validated['description'] = $filteredDescriptions;
            $validated['sac_code'] = $filteredSacCodes;
            $validated['quantity'] = $filteredQuantities;
            $validated['rate'] = $filteredRates;
            $validated['total'] = $filteredTotals;
            
            // Calculate total tax amount
            $validated['total_tax_amount'] = ($validated['cgst_amount'] ?? 0) + 
                                            ($validated['sgst_amount'] ?? 0) + 
                                            ($validated['igst_amount'] ?? 0);
            
            $proforma->update($validated);
            
            return redirect()->route('performas.index')
                ->with('status', 'Proforma updated successfully');
                
        } catch (\Exception $e) {
            \Log::error('Error updating proforma: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Error updating proforma: ' . $e->getMessage());
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $proforma = Proforma::findOrFail($id);
            $proforma->delete();
            
            return redirect()->route('performas.index')
                ->with('status', 'Proforma deleted successfully');
                
        } catch (\Exception $e) {
            \Log::error('Error deleting proforma: ' . $e->getMessage());
            return back()->with('error', 'Error deleting proforma');
        }
    }

    public function print(int $id): View
    {
        $proforma = Proforma::with('quotation')->findOrFail($id);
        return view('performas.print', compact('proforma'));
    }
}
