<?php

namespace App\Http\Controllers\Receipt;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReceiptController extends Controller
{
    public function index(Request $request): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Receipts Management.view receipt'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user = auth()->user();
        $query = Receipt::query();
        
        // Filter by role: customers see only their company's receipts
        if ($user->hasRole('customer') && $user->company_id) {
            $company = $user->company;
            if ($company) {
                $query->where('company_name', $company->company_name);
            }
        }
        
        // Handle sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        // Validate sort column
        $allowedSorts = ['unique_code', 'company_name', 'receipt_date', 'received_amount', 'invoice_type', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        
        // Validate sort direction
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }
        
        $query->orderBy($sortBy, $sortDirection);
        
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
            $query->whereDate('receipt_date', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->whereDate('receipt_date', '<=', $request->to_date);
        }
        
        $perPage = $request->get('per_page', 10);
        $receipts = $query->paginate($perPage)->appends($request->query());
        
        return view('receipts.index', compact('receipts'));
    }
    
    public function export(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Receipts Management.export receipt'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        try {
            $user = auth()->user();
            $query = Receipt::query()->orderBy('created_at', 'desc');
            
            // Filter by role: customers see only their company's receipts
            if ($user->hasRole('customer') && $user->company_id) {
                $company = $user->company;
                if ($company) {
                    $query->where('company_name', $company->company_name);
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
                $query->whereDate('receipt_date', '>=', $request->from_date);
            }
            
            if ($request->filled('to_date')) {
                $query->whereDate('receipt_date', '<=', $request->to_date);
            }
            
            $receipts = $query->get();
            
            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\ReceiptsExport($receipts), 
                'receipts_' . date('Y-m-d_His') . '.xlsx'
            );
        } catch (\Exception $e) {
            \Log::error('Error exporting receipts: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error exporting receipts: ' . $e->getMessage());
        }
    }

    public function exportCsv(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Receipts Management.export receipt'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $user = auth()->user();
        $query = Receipt::query()->latest();

        // Filter by role: customers see only their company's receipts
        if ($user->hasRole('customer') && $user->company_id) {
            $company = $user->company;
            if ($company) {
                $query->where('company_name', $company->company_name);
            }
        }

        if ($request->filled('from_date')) {
            $query->whereDate('receipt_date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('receipt_date', '<=', $request->input('to_date'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('unique_code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('invoice_type')) {
            $query->where('invoice_type', $request->invoice_type);
        }

        $receipts = $query->get();

        $fileName = 'receipts_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () use ($receipts) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'ID',
                'Receipt No',
                'Receipt Date',
                'Invoice Type',
                'Company Name',
                'Received Amount',
                'Payment Type',
                'Trans Code',
                'Narration',
                'Created At',
                'Updated At',
            ]);

            foreach ($receipts as $receipt) {
                fputcsv($handle, [
                    $receipt->id,
                    $receipt->unique_code,
                    optional($receipt->receipt_date)->format('d/m/Y'),
                    $receipt->invoice_type == 'gst' ? 'GST' : 'Without GST',
                    $receipt->company_name,
                    number_format($receipt->received_amount ?? 0, 2),
                    $receipt->payment_type,
                    $receipt->trans_code,
                    $receipt->narration,
                    optional($receipt->created_at)->format('d/m/Y H:i:s'),
                    optional($receipt->updated_at)->format('d/m/Y H:i:s'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function create(): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Receipts Management.create receipt'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        // Note: Receipt code will be generated after invoice type is selected
        // For now, show placeholder
        $nextCode = 'Automaticlly generated based on invoice type';
        
        // Get unique company names from all invoices
        $companies = Invoice::select('company_name')
            ->distinct()
            ->orderBy('company_name')
            ->pluck('company_name');
        
        // Get all invoices for selection
        $invoices = Invoice::with('proforma')
            ->latest()
            ->get();
        
        return view('receipts.create', compact('nextCode', 'companies', 'invoices'));
    }
    
    /**
     * Generate unique receipt code based on invoice type
     */
    private function generateReceiptCode(string $invoiceType): string
    {
        if ($invoiceType === 'gst') {
            // Get last GST receipt (CMS/REC/XXXX)
            $lastReceipt = Receipt::where('invoice_type', 'gst')
                ->where('unique_code', 'like', 'CMS/REC/%')
                ->where('unique_code', 'not like', 'CMS/WGREC/%')
                ->orderByDesc('id')
                ->first();
            
            $nextNumber = 1;
            if ($lastReceipt && !empty($lastReceipt->unique_code)) {
                if (preg_match('/CMS\/REC\/(\d+)$/', $lastReceipt->unique_code, $matches)) {
                    $nextNumber = ((int) $matches[1]) + 1;
                }
            }
            
            return 'CMS/REC/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        } else {
            // Get last Non-GST receipt (CMS/WGREC/XXXX)
            $lastReceipt = Receipt::where('invoice_type', 'without_gst')
                ->where('unique_code', 'like', 'CMS/WGREC/%')
                ->orderByDesc('id')
                ->first();
            
            $nextNumber = 1;
            if ($lastReceipt && !empty($lastReceipt->unique_code)) {
                if (preg_match('/CMS\/WGREC\/(\d+)$/', $lastReceipt->unique_code, $matches)) {
                    $nextNumber = ((int) $matches[1]) + 1;
                }
            }
            
            return 'CMS/WGREC/' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }
    }

    public function store(Request $request): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Receipts Management.create receipt'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        try {
            $validated = $request->validate([
                'receipt_date' => ['required', 'date_format:d/m/Y'],
                'company_name' => ['required', 'string', 'max:255'],
                'invoice_type' => ['required', 'string', 'in:gst,without_gst'],
                'invoice_ids' => ['nullable', 'array'],
                'invoice_ids.*' => ['integer', 'exists:invoices,id'],
                'partial_amounts' => ['nullable', 'array'],
                'partial_amounts.*' => ['nullable', 'numeric', 'min:0'],
                'received_amount' => ['required', 'numeric', 'min:0.01'],
                'payment_type' => ['nullable', 'string', 'max:255'],
                'narration' => ['nullable', 'string', 'max:1000'],
                'trans_code' => ['nullable', 'string', 'max:255'],
            ]);
            
            // Convert receipt_date from dd/mm/yyyy to Y-m-d
            if (!empty($validated['receipt_date'])) {
                try {
                    $validated['receipt_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['receipt_date'])->format('Y-m-d');
                } catch (\Exception $e) {
                    // If parsing fails, leave as is
                }
            }
            
            // Generate unique code based on invoice type
            $validated['unique_code'] = $this->generateReceiptCode($validated['invoice_type']);
            
            $receipt = Receipt::create($validated);
            
            // Update paid amounts for selected invoices with partial payment support
            if (!empty($validated['invoice_ids']) && $validated['received_amount'] > 0) {
                $partialAmounts = $request->input('partial_amounts', []);
                
                \Log::info('Updating invoice paid amounts with partial payments', [
                    'receipt_id' => $receipt->id,
                    'invoice_ids' => $validated['invoice_ids'],
                    'partial_amounts' => $partialAmounts,
                    'received_amount' => $validated['received_amount']
                ]);
                
                foreach ($validated['invoice_ids'] as $invoiceId) {
                    $invoice = Invoice::find($invoiceId);
                    if (!$invoice) continue;
                    
                    $oldPaidAmount = $invoice->paid_amount;
                    $invoiceBalance = $invoice->final_amount - $invoice->paid_amount;
                    
                    // Use partial amount if specified, otherwise use full balance
                    $paymentForThisInvoice = isset($partialAmounts[$invoiceId]) && $partialAmounts[$invoiceId] > 0
                        ? min((float)$partialAmounts[$invoiceId], $invoiceBalance)
                        : min($validated['received_amount'], $invoiceBalance);
                    
                    $invoice->paid_amount = ($invoice->paid_amount ?? 0) + $paymentForThisInvoice;
                    $invoice->save();
                    
                    \Log::info('Invoice payment updated', [
                        'invoice_id' => $invoice->id,
                        'invoice_code' => $invoice->unique_code,
                        'old_paid' => $oldPaidAmount,
                        'new_paid' => $invoice->paid_amount,
                        'payment_applied' => $paymentForThisInvoice,
                        'was_partial' => isset($partialAmounts[$invoiceId])
                    ]);
                }
            }
            
            return redirect()->route('receipts.index')
                ->with('status', 'Receipt created successfully with ID: ' . $receipt->unique_code);
                
        } catch (\Exception $e) {
            \Log::error('Error creating receipt: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Error creating receipt: ' . $e->getMessage());
        }
    }

    public function show(int $id): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Receipts Management.view receipt'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $receipt = Receipt::findOrFail($id);
        return view('receipts.show', compact('receipt'));
    }

    public function edit(int $id): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Receipts Management.edit receipt'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $receipt = Receipt::findOrFail($id);
        
        // Get unique company names from all invoices
        $companies = Invoice::select('company_name')
            ->distinct()
            ->orderBy('company_name')
            ->pluck('company_name');
        
        // Get all invoices for selection
        $invoices = Invoice::with('proforma')
            ->latest()
            ->get();
        
        return view('receipts.edit', compact('receipt', 'companies', 'invoices'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Receipts Management.edit receipt'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        try {
            $receipt = Receipt::findOrFail($id);
            
            $validated = $request->validate([
                'receipt_date' => ['required', 'date_format:d/m/Y'],
                'company_name' => ['required', 'string', 'max:255'],
                'invoice_type' => ['required', 'string', 'in:gst,without_gst'],
                'invoice_ids' => ['nullable', 'array'],
                'invoice_ids.*' => ['integer', 'exists:invoices,id'],
                'received_amount' => ['required', 'numeric', 'min:0.01'],
                'payment_type' => ['nullable', 'string', 'max:255'],
                'narration' => ['nullable', 'string', 'max:1000'],
                'trans_code' => ['nullable', 'string', 'max:255'],
            ]);
            
            // Convert receipt_date from dd/mm/yyyy to Y-m-d
            if (!empty($validated['receipt_date'])) {
                try {
                    $validated['receipt_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['receipt_date'])->format('Y-m-d');
                } catch (\Exception $e) {
                    // If parsing fails, leave as is
                }
            }
            
            // Get old invoice IDs before update
            $oldInvoiceIds = $receipt->invoice_ids ?? [];
            $newInvoiceIds = $validated['invoice_ids'] ?? [];
            $oldReceivedAmount = $receipt->received_amount;
            $newReceivedAmount = $validated['received_amount'];
            
            \Log::info('Updating receipt', [
                'receipt_id' => $receipt->id,
                'old_invoice_ids' => $oldInvoiceIds,
                'new_invoice_ids' => $newInvoiceIds,
                'old_amount' => $oldReceivedAmount,
                'new_amount' => $newReceivedAmount
            ]);
            
            // Step 1: Reverse old payments (subtract from invoices that were previously selected)
            if (!empty($oldInvoiceIds) && $oldReceivedAmount > 0) {
                $oldInvoices = Invoice::whereIn('id', $oldInvoiceIds)->get();
                $remainingAmount = $oldReceivedAmount;
                
                foreach ($oldInvoices as $invoice) {
                    if ($remainingAmount <= 0) break;
                    
                    $invoiceBalance = $invoice->final_amount - ($invoice->paid_amount - $oldReceivedAmount);
                    $paymentToReverse = min($remainingAmount, $oldReceivedAmount);
                    
                    // Subtract the old payment
                    $invoice->paid_amount = max(0, ($invoice->paid_amount ?? 0) - $paymentToReverse);
                    $invoice->save();
                    
                    \Log::info('Reversed payment for invoice', [
                        'invoice_id' => $invoice->id,
                        'invoice_code' => $invoice->unique_code,
                        'amount_reversed' => $paymentToReverse,
                        'new_paid' => $invoice->paid_amount
                    ]);
                    
                    $remainingAmount -= $paymentToReverse;
                }
            }
            
            // Step 2: Apply new payments (add to newly selected invoices)
            if (!empty($newInvoiceIds) && $newReceivedAmount > 0) {
                $newInvoices = Invoice::whereIn('id', $newInvoiceIds)->get();
                $remainingAmount = $newReceivedAmount;
                
                foreach ($newInvoices as $invoice) {
                    if ($remainingAmount <= 0) break;
                    
                    $invoiceBalance = $invoice->final_amount - $invoice->paid_amount;
                    $paymentForThisInvoice = min($remainingAmount, $invoiceBalance);
                    
                    // Add the new payment
                    $invoice->paid_amount = ($invoice->paid_amount ?? 0) + $paymentForThisInvoice;
                    $invoice->save();
                    
                    \Log::info('Applied payment to invoice', [
                        'invoice_id' => $invoice->id,
                        'invoice_code' => $invoice->unique_code,
                        'payment_applied' => $paymentForThisInvoice,
                        'new_paid' => $invoice->paid_amount
                    ]);
                    
                    $remainingAmount -= $paymentForThisInvoice;
                }
            }
            
            // Step 3: Update the receipt
            $receipt->update($validated);
            
            return redirect()->route('receipts.index')
                ->with('status', 'Receipt updated successfully');
                
        } catch (\Exception $e) {
            \Log::error('Error updating receipt: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Error updating receipt: ' . $e->getMessage());
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Receipts Management.delete receipt'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        try {
            $receipt = Receipt::findOrFail($id);
            
            // Reverse payments before deleting receipt
            $invoiceIds = $receipt->invoice_ids ?? [];
            $receivedAmount = $receipt->received_amount;
            
            if (!empty($invoiceIds) && $receivedAmount > 0) {
                $invoices = Invoice::whereIn('id', $invoiceIds)->get();
                $remainingAmount = $receivedAmount;
                
                \Log::info('Reversing payments for deleted receipt', [
                    'receipt_id' => $receipt->id,
                    'receipt_code' => $receipt->unique_code,
                    'invoice_ids' => $invoiceIds,
                    'amount_to_reverse' => $receivedAmount
                ]);
                
                foreach ($invoices as $invoice) {
                    if ($remainingAmount <= 0) break;
                    
                    $invoiceBalance = $invoice->final_amount - ($invoice->paid_amount - $receivedAmount);
                    $paymentToReverse = min($remainingAmount, $receivedAmount);
                    
                    // Subtract the payment
                    $oldPaidAmount = $invoice->paid_amount;
                    $invoice->paid_amount = max(0, ($invoice->paid_amount ?? 0) - $paymentToReverse);
                    $invoice->save();
                    
                    \Log::info('Reversed payment for invoice', [
                        'invoice_id' => $invoice->id,
                        'invoice_code' => $invoice->unique_code,
                        'old_paid' => $oldPaidAmount,
                        'new_paid' => $invoice->paid_amount,
                        'amount_reversed' => $paymentToReverse
                    ]);
                    
                    $remainingAmount -= $paymentToReverse;
                }
            }
            
            $receipt->delete();
            
            return redirect()->route('receipts.index')
                ->with('status', 'Receipt deleted successfully');
                
        } catch (\Exception $e) {
            \Log::error('Error deleting receipt: ' . $e->getMessage());
            return back()->with('error', 'Error deleting receipt');
        }
    }

    public function print(int $id): View
    {
        if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Receipts Management.print receipt'))) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        
        $receipt = Receipt::findOrFail($id);
        return view('receipts.print', compact('receipt'));
    }
}
