<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Proforma;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(Request $request): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Invoices Management.view invoice'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user = auth()->user();
        $query = Invoice::with('proforma');
        
        // Filter by role: customers/clients see only their company's invoices
        $isCustomer = $user->hasRole('customer') || $user->hasRole('client') || $user->hasRole('company');
        if ($isCustomer && $user->company_id) {
            $company = $user->company;
            if ($company) {
                $query->where('company_name', $company->company_name);
                // Customers see only GST invoices
                $query->where('invoice_type', 'gst');
            }
        }
        
        // Handle sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        // Validate sort column
        $allowedSorts = ['unique_code', 'company_name', 'invoice_date', 'invoice_type', 'final_amount', 'total_tax_amount', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        
        // Validate sort direction
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }
        
        $query->orderBy($sortBy, $sortDirection);
        
        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('unique_code', 'like', '%' . $search . '%')
                  ->orWhere('company_name', 'like', '%' . $search . '%')
                  ->orWhere('bill_no', 'like', '%' . $search . '%');
            });
        }
        
        if ($request->filled('invoice_type')) {
            $query->where('invoice_type', $request->invoice_type);
        }
        
        if ($request->filled('from_date')) {
            $query->whereDate('invoice_date', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->whereDate('invoice_date', '<=', $request->to_date);
        }
        
        $perPage = $request->get('per_page', 10);
        $invoices = $query->paginate($perPage)->appends($request->query());
        
        return view('invoices.index', compact('invoices'));
    }
    
    public function export(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Invoices Management.export invoice'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        try {
            $user = auth()->user();
            $query = Invoice::with('proforma')->orderBy('created_at', 'desc');
            
            // Filter by role: customers/clients see only their company's invoices
            $isCustomer = $user->hasRole('customer') || $user->hasRole('client') || $user->hasRole('company');
            if ($isCustomer && $user->company_id) {
                $company = $user->company;
                if ($company) {
                    $query->where('company_name', $company->company_name);
                    // Customers see only GST invoices
                    $query->where('invoice_type', 'gst');
                }
            }
            
            // Apply filters if provided
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('unique_code', 'like', '%' . $search . '%')
                      ->orWhere('company_name', 'like', '%' . $search . '%');
                });
            }
            
            if ($request->filled('invoice_type')) {
                $query->where('invoice_type', $request->invoice_type);
            }
            
            if ($request->filled('from_date')) {
                $query->whereDate('invoice_date', '>=', $request->from_date);
            }
            
            if ($request->filled('to_date')) {
                $query->whereDate('invoice_date', '<=', $request->to_date);
            }
            
            $invoices = $query->get();
            
            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\InvoicesExport($invoices), 
                'invoices_' . date('Y-m-d_His') . '.xlsx'
            );
        } catch (\Exception $e) {
            \Log::error('Error exporting invoices: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error exporting invoices: ' . $e->getMessage());
        }
    }

    public function exportCsv(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Invoices Management.export invoice'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user = auth()->user();
        $query = Invoice::with('proforma')->latest();

        // Filter by role: customers/clients see only their company's invoices
        $isCustomer = $user->hasRole('customer') || $user->hasRole('client') || $user->hasRole('company');
        if ($isCustomer && $user->company_id) {
            $company = $user->company;
            if ($company) {
                $query->where('company_name', $company->company_name);
                // Customers see only GST invoices
                $query->where('invoice_type', 'gst');
            }
        }

        if ($request->filled('from_date')) {
            $query->whereDate('invoice_date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('invoice_date', '<=', $request->input('to_date'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('unique_code', 'like', "%{$search}%")
                  ->orWhere('mobile_no', 'like', "%{$search}%");
            });
        }

        if ($request->filled('invoice_type')) {
            $query->where('invoice_type', $request->invoice_type);
        }

        $invoices = $query->get();

        $fileName = 'invoices_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () use ($invoices) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'ID',
                'Invoice No',
                'Invoice Date',
                'Invoice Type',
                'Proforma No',
                'Bill To',
                'Mobile No',
                'Address',
                'GST No',
                'Grand Total',
                'Discount',
                'Total Tax',
                'Total Amount',
                'Type of Billing',
                'Created At',
                'Updated At',
            ]);

            foreach ($invoices as $invoice) {
                fputcsv($handle, [
                    $invoice->id,
                    $invoice->unique_code,
                    optional($invoice->invoice_date)->format('d/m/Y'),
                    $invoice->invoice_type == 'gst' ? 'GST' : 'Without GST',
                    optional($invoice->proforma)->unique_code,
                    $invoice->company_name,
                    $invoice->mobile_no,
                    $invoice->address,
                    $invoice->gst_no,
                    number_format($invoice->sub_total ?? 0, 2),
                    number_format($invoice->discount_amount ?? 0, 2),
                    number_format($invoice->total_tax_amount ?? 0, 2),
                    number_format($invoice->final_amount ?? 0, 2),
                    $invoice->type_of_billing,
                    optional($invoice->created_at)->format('d/m/Y H:i:s'),
                    optional($invoice->updated_at)->format('d/m/Y H:i:s'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function convertForm(int $proformaId): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Proformas Management.convert proforma'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $proforma = Proforma::findOrFail($proformaId);
        
        // Check if both invoices already exist
        if ($proforma->hasBothInvoices()) {
            return redirect()->route('performas.index')
                ->with('error', 'This proforma has already been converted to both GST and Without GST invoices.');
        }
        
        // Generate next GST invoice code (for display only)
        $allGstInvoices = Invoice::where('unique_code', 'like', 'CMS/INV/%')
            ->pluck('unique_code');
        
        $maxGstNumber = 0;
        foreach ($allGstInvoices as $code) {
            if (preg_match('/(\d+)$/', $code, $matches)) {
                $num = (int) $matches[1];
                if ($num > $maxGstNumber) {
                    $maxGstNumber = $num;
                }
            }
        }
        $nextGstNumber = $maxGstNumber + 1;
        $nextGstCode = 'CMS/INV/' . str_pad($nextGstNumber, 4, '0', STR_PAD_LEFT);
        
        // Generate next Without GST invoice code
        $allWgInvoices = Invoice::where('unique_code', 'like', 'CMS/WGINV/%')
            ->pluck('unique_code');
        
        $maxWgNumber = 0;
        foreach ($allWgInvoices as $code) {
            if (preg_match('/(\d+)$/', $code, $matches)) {
                $num = (int) $matches[1];
                if ($num > $maxWgNumber) {
                    $maxWgNumber = $num;
                }
            }
        }
        $nextWgNumber = $maxWgNumber + 1;
        $nextWgCode = 'CMS/WGINV/' . str_pad($nextWgNumber, 4, '0', STR_PAD_LEFT);
        
        // Check which invoice types are already generated
        $hasGstInvoice = $proforma->hasGstInvoice();
        $hasWithoutGstInvoice = $proforma->hasWithoutGstInvoice();
        
        return view('invoices.convert', compact('proforma', 'nextGstCode', 'nextWgCode', 'hasGstInvoice', 'hasWithoutGstInvoice'));
    }

    public function convert(Request $request, int $proformaId): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Proformas Management.convert proforma'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        try {
            $proforma = Proforma::findOrFail($proformaId);
            
            $validated = $request->validate([
                'invoice_date' => ['required', 'date'],
                'invoice_type' => ['required', 'in:gst,without_gst'],
            ]);
            
            // Check if this invoice type already exists
            if ($validated['invoice_type'] === 'gst' && $proforma->hasGstInvoice()) {
                return redirect()->back()
                    ->with('error', 'A GST invoice has already been generated for this proforma.');
            }
            
            if ($validated['invoice_type'] === 'without_gst' && $proforma->hasWithoutGstInvoice()) {
                return redirect()->back()
                    ->with('error', 'A Without GST invoice has already been generated for this proforma.');
            }
            
            // Generate unique code based on invoice type
            if ($validated['invoice_type'] === 'gst') {
                // GST Invoice: CMS/INV/0001
                $allGstInvoices = Invoice::where('unique_code', 'like', 'CMS/INV/%')
                    ->pluck('unique_code');
                
                $maxNumber = 0;
                foreach ($allGstInvoices as $code) {
                    if (preg_match('/(\d+)$/', $code, $matches)) {
                        $num = (int) $matches[1];
                        if ($num > $maxNumber) {
                            $maxNumber = $num;
                        }
                    }
                }
                $nextNumber = $maxNumber + 1;
                $uniqueCode = 'CMS/INV/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            } else {
                // Without GST Invoice: CMS/WGINV/0001
                $allWgInvoices = Invoice::where('unique_code', 'like', 'CMS/WGINV/%')
                    ->pluck('unique_code');
                
                $maxNumber = 0;
                foreach ($allWgInvoices as $code) {
                    if (preg_match('/(\d+)$/', $code, $matches)) {
                        $num = (int) $matches[1];
                        if ($num > $maxNumber) {
                            $maxNumber = $num;
                        }
                    }
                }
                $nextNumber = $maxNumber + 1;
                $uniqueCode = 'CMS/WGINV/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            }
            
            // Create invoice from proforma data
            // For Without GST invoices, recalculate amounts excluding GST
            if ($validated['invoice_type'] === 'without_gst') {
                // Calculate final amount without GST
                $subTotal = $proforma->sub_total ?? 0;
                $discountAmount = $proforma->discount_amount ?? 0;
                $retentionAmount = $proforma->retention_amount ?? 0;
                
                // Final amount = Subtotal - Discount - Retention (NO GST)
                $finalAmount = $subTotal - $discountAmount - $retentionAmount;
                
                $invoiceData = [
                    'proforma_id' => $proforma->id,
                    'unique_code' => $uniqueCode,
                    'invoice_date' => $validated['invoice_date'],
                    'invoice_type' => $validated['invoice_type'],
                    'company_name' => $proforma->company_name,
                    'bill_no' => $proforma->bill_no,
                    'address' => $proforma->address,
                    'gst_no' => null, // No GST number for without_gst invoices
                    'mobile_no' => $proforma->mobile_no,
                    'description' => $proforma->description,
                    'sac_code' => $proforma->sac_code,
                    'quantity' => $proforma->quantity,
                    'rate' => $proforma->rate,
                    'total' => $proforma->total,
                    'sub_total' => $subTotal,
                    'discount_percent' => $proforma->discount_percent,
                    'discount_amount' => $discountAmount,
                    'retention_percent' => $proforma->retention_percent,
                    'retention_amount' => $retentionAmount,
                    'cgst_percent' => 0,
                    'cgst_amount' => 0,
                    'sgst_percent' => 0,
                    'sgst_amount' => 0,
                    'igst_percent' => 0,
                    'igst_amount' => 0,
                    'final_amount' => $finalAmount,
                    'total_tax_amount' => 0,
                    'billing_item' => $proforma->billing_item,
                    'type_of_billing' => $proforma->type_of_billing,
                    'tds_amount' => $proforma->tds_amount,
                    'remark' => $proforma->remark,
                ];
            } else {
                // GST Invoice - copy all data as is
                $invoiceData = [
                    'proforma_id' => $proforma->id,
                    'unique_code' => $uniqueCode,
                    'invoice_date' => $validated['invoice_date'],
                    'invoice_type' => $validated['invoice_type'],
                    'company_name' => $proforma->company_name,
                    'bill_no' => $proforma->bill_no,
                    'address' => $proforma->address,
                    'gst_no' => $proforma->gst_no,
                    'mobile_no' => $proforma->mobile_no,
                    'description' => $proforma->description,
                    'sac_code' => $proforma->sac_code,
                    'quantity' => $proforma->quantity,
                    'rate' => $proforma->rate,
                    'total' => $proforma->total,
                    'sub_total' => $proforma->sub_total,
                    'discount_percent' => $proforma->discount_percent,
                    'discount_amount' => $proforma->discount_amount,
                    'retention_percent' => $proforma->retention_percent,
                    'retention_amount' => $proforma->retention_amount,
                    'cgst_percent' => $proforma->cgst_percent,
                    'cgst_amount' => $proforma->cgst_amount,
                    'sgst_percent' => $proforma->sgst_percent,
                    'sgst_amount' => $proforma->sgst_amount,
                    'igst_percent' => $proforma->igst_percent,
                    'igst_amount' => $proforma->igst_amount,
                    'final_amount' => $proforma->final_amount,
                    'total_tax_amount' => $proforma->total_tax_amount,
                    'billing_item' => $proforma->billing_item,
                    'type_of_billing' => $proforma->type_of_billing,
                    'tds_amount' => $proforma->tds_amount,
                    'remark' => $proforma->remark,
                ];
            }
            
            $invoice = Invoice::create($invoiceData);
            
            return redirect()->route('invoices.index')
                ->with('status', 'Invoice created successfully with ID: ' . $invoice->unique_code);
                
        } catch (\Exception $e) {
            \Log::error('Error converting proforma to invoice: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error converting to invoice: ' . $e->getMessage());
        }
    }

    public function show(int $id): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Invoices Management.view invoice'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $invoice = Invoice::with('proforma')->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    public function edit(int $id): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Invoices Management.edit invoice'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $invoice = Invoice::with('proforma')->findOrFail($id);
        return view('invoices.edit', compact('invoice'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Invoices Management.edit invoice'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        try {
            $invoice = Invoice::findOrFail($id);
            
            $validated = $request->validate([
                'unique_code' => ['required', 'string', 'max:255', 'unique:invoices,unique_code,' . $id],
                'invoice_date' => ['required', 'date_format:d/m/Y'],
            ]);
            
            // Convert invoice_date from dd/mm/yyyy to Y-m-d
            if (!empty($validated['invoice_date'])) {
                try {
                    $validated['invoice_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['invoice_date'])->format('Y-m-d');
                } catch (\Exception $e) {
                    // If parsing fails, leave as is
                }
            }
            
            $invoice->update($validated);
            
            return redirect()->route('invoices.index')
                ->with('status', 'Invoice updated successfully');
                
        } catch (\Exception $e) {
            \Log::error('Error updating invoice: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Error updating invoice: ' . $e->getMessage());
        }
    }

    public function print(int $id): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Invoices Management.print invoice'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $invoice = Invoice::with('proforma')->findOrFail($id);
        return view('invoices.print', compact('invoice'));
    }

    public function destroy(int $id): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Invoices Management.delete invoice'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        try {
            $invoice = Invoice::findOrFail($id);
            $invoice->delete();
            
            return redirect()->route('invoices.index')
                ->with('status', 'Invoice deleted successfully');
                
        } catch (\Exception $e) {
            \Log::error('Error deleting invoice: ' . $e->getMessage());
            return back()->with('error', 'Error deleting invoice');
        }
    }
}
