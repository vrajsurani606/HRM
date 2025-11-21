@extends('layouts.macos')
@section('page_title', 'Invoice Details')
@section('content')

<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Invoice Details</h2>
            <div class="flex gap-2">
                <a href="{{ route('invoices.print', $invoice->id) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Print Invoice
                </a>
                <a href="{{ route('invoices.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    Back to List
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="font-semibold text-lg mb-3 text-gray-700">Invoice Information</h3>
                <p class="mb-2"><strong>Invoice No:</strong> {{ $invoice->unique_code }}</p>
                <p class="mb-2"><strong>Invoice Date:</strong> {{ $invoice->invoice_date ? $invoice->invoice_date->format('d-m-Y') : '-' }}</p>
                @if($invoice->proforma)
                <p class="mb-2"><strong>Proforma No:</strong> {{ $invoice->proforma->unique_code }}</p>
                @endif
            </div>

            <div>
                <h3 class="font-semibold text-lg mb-3 text-gray-700">Customer Information</h3>
                <p class="mb-2"><strong>Company:</strong> {{ $invoice->company_name }}</p>
                <p class="mb-2"><strong>Mobile:</strong> {{ $invoice->mobile_no ?? '-' }}</p>
                <p class="mb-2"><strong>GST No:</strong> {{ $invoice->gst_no ?? '-' }}</p>
                @if($invoice->address)
                <p class="mb-2"><strong>Address:</strong> {{ $invoice->address }}</p>
                @endif
            </div>
        </div>

        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-gray-700">Items</h3>
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">Description</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">SAC</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Qty</th>
                        <th class="border border-gray-300 px-4 py-2 text-right">Rate</th>
                        <th class="border border-gray-300 px-4 py-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $descriptions = is_array($invoice->description) ? $invoice->description : [];
                        $sacCodes = is_array($invoice->sac_code) ? $invoice->sac_code : [];
                        $quantities = is_array($invoice->quantity) ? $invoice->quantity : [];
                        $rates = is_array($invoice->rate) ? $invoice->rate : [];
                        $totals = is_array($invoice->total) ? $invoice->total : [];
                        $maxCount = max(count($descriptions), count($sacCodes), count($quantities), count($rates), count($totals));
                    @endphp
                    
                    @for($i = 0; $i < $maxCount; $i++)
                    @if(!empty($descriptions[$i]) || !empty($quantities[$i]))
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $descriptions[$i] ?? '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $sacCodes[$i] ?? '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $quantities[$i] ?? '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-right">₹{{ isset($rates[$i]) ? number_format($rates[$i], 2) : '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-right">₹{{ isset($totals[$i]) ? number_format($totals[$i], 2) : '-' }}</td>
                    </tr>
                    @endif
                    @endfor
                </tbody>
            </table>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div></div>
            <div>
                <table class="w-full">
                    <tr>
                        <td class="py-2 text-right pr-4">Subtotal:</td>
                        <td class="py-2 text-right font-semibold">₹{{ number_format($invoice->sub_total ?? 0, 2) }}</td>
                    </tr>
                    @if($invoice->discount_amount > 0)
                    <tr>
                        <td class="py-2 text-right pr-4">Discount ({{ $invoice->discount_percent }}%):</td>
                        <td class="py-2 text-right font-semibold">₹{{ number_format($invoice->discount_amount, 2) }}</td>
                    </tr>
                    @endif
                    @if(isset($invoice->retention_amount) && $invoice->retention_amount > 0)
                    <tr>
                        <td class="py-2 text-right pr-4">Retention ({{ $invoice->retention_percent }}%):</td>
                        <td class="py-2 text-right font-semibold">₹{{ number_format($invoice->retention_amount, 2) }}</td>
                    </tr>
                    @endif
                    @if($invoice->cgst_amount > 0)
                    <tr>
                        <td class="py-2 text-right pr-4">CGST ({{ $invoice->cgst_percent }}%):</td>
                        <td class="py-2 text-right font-semibold">₹{{ number_format($invoice->cgst_amount, 2) }}</td>
                    </tr>
                    @endif
                    @if($invoice->sgst_amount > 0)
                    <tr>
                        <td class="py-2 text-right pr-4">SGST ({{ $invoice->sgst_percent }}%):</td>
                        <td class="py-2 text-right font-semibold">₹{{ number_format($invoice->sgst_amount, 2) }}</td>
                    </tr>
                    @endif
                    <tr class="border-t-2 border-gray-300">
                        <td class="py-2 text-right pr-4 font-bold text-lg">Total Amount:</td>
                        <td class="py-2 text-right font-bold text-lg">₹{{ number_format($invoice->final_amount ?? 0, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
