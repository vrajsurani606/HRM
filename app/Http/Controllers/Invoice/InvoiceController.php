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
        $query = Invoice::with('proforma')->latest();
        
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
        
        $perPage = $request->get('per_page', 25);
        $invoices = $query->paginate($perPage)->appends($request->query());
        
        return view('invoices.index', compact('invoices'));
    }

    public function convertForm(int $proformaId): View
    {
        $proforma = Proforma::findOrFail($proformaId);
        
        // Generate next GST invoice code (for display only)
        $lastGstInvoice = Invoice::where('invoice_type', 'gst')
            ->where('unique_code', 'like', 'CMS/INV/%')
            ->orderByDesc('id')
            ->first();
        $nextGstNumber = 1;
        if ($lastGstInvoice && !empty($lastGstInvoice->unique_code)) {
            if (preg_match('/(\d+)$/', $lastGstInvoice->unique_code, $matches)) {
                $nextGstNumber = ((int) $matches[1]) + 1;
            }
        }
        $nextGstCode = 'CMS/INV/' . str_pad($nextGstNumber, 4, '0', STR_PAD_LEFT);
        
        // Generate next Without GST invoice code
        $lastWgInvoice = Invoice::where('invoice_type', 'without_gst')
            ->where('unique_code', 'like', 'CMS/WGINV/%')
            ->orderByDesc('id')
            ->first();
        $nextWgNumber = 1;
        if ($lastWgInvoice && !empty($lastWgInvoice->unique_code)) {
            if (preg_match('/(\d+)$/', $lastWgInvoice->unique_code, $matches)) {
                $nextWgNumber = ((int) $matches[1]) + 1;
            }
        }
        $nextWgCode = 'CMS/WGINV/' . str_pad($nextWgNumber, 4, '0', STR_PAD_LEFT);
        
        return view('invoices.convert', compact('proforma', 'nextGstCode', 'nextWgCode'));
    }

    public function convert(Request $request, int $proformaId): RedirectResponse
    {
        try {
            $proforma = Proforma::findOrFail($proformaId);
            
            $validated = $request->validate([
                'invoice_date' => ['required', 'date'],
                'invoice_type' => ['required', 'in:gst,without_gst'],
            ]);
            
            // Generate unique code based on invoice type
            if ($validated['invoice_type'] === 'gst') {
                // GST Invoice: CMS/INV/0001
                $lastInvoice = Invoice::where('invoice_type', 'gst')
                    ->where('unique_code', 'like', 'CMS/INV/%')
                    ->orderByDesc('id')
                    ->first();
                $nextNumber = 1;
                if ($lastInvoice && !empty($lastInvoice->unique_code)) {
                    if (preg_match('/(\d+)$/', $lastInvoice->unique_code, $matches)) {
                        $nextNumber = ((int) $matches[1]) + 1;
                    }
                }
                $uniqueCode = 'CMS/INV/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            } else {
                // Without GST Invoice: CMS/WGINV/0001
                $lastInvoice = Invoice::where('invoice_type', 'without_gst')
                    ->where('unique_code', 'like', 'CMS/WGINV/%')
                    ->orderByDesc('id')
                    ->first();
                $nextNumber = 1;
                if ($lastInvoice && !empty($lastInvoice->unique_code)) {
                    if (preg_match('/(\d+)$/', $lastInvoice->unique_code, $matches)) {
                        $nextNumber = ((int) $matches[1]) + 1;
                    }
                }
                $uniqueCode = 'CMS/WGINV/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            }
            
            // Create invoice from proforma data
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
        $invoice = Invoice::with('proforma')->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    public function print(int $id): View
    {
        $invoice = Invoice::with('proforma')->findOrFail($id);
        return view('invoices.print', compact('invoice'));
    }

    public function destroy(int $id): RedirectResponse
    {
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
