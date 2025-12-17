@extends('layouts.macos')
@section('page_title', 'Receipt Details')

@push('styles')
<style>
    :root {
        --receipt-primary: #456DB5;
        --receipt-border: #ddd;
    }
    
    .receipt-container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .receipt-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }
    
    .receipt-actions .btn-group {
        display: flex;
        gap: 10px;
    }
    
    .receipt-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
    }
    
    .receipt-btn-print {
        background: #2563eb;
        color: white;
    }
    
    .receipt-btn-print:hover {
        background: #1d4ed8;
        color: white;
    }
    
    .receipt-btn-edit {
        background: #f59e0b;
        color: white;
    }
    
    .receipt-btn-edit:hover {
        background: #d97706;
        color: white;
    }
    
    .receipt-btn-back {
        background: #e5e7eb;
        color: #374151;
    }
    
    .receipt-btn-back:hover {
        background: #d1d5db;
        color: #1f2937;
    }
    
    .receipt-page {
        padding: 30px;
        position: relative;
    }
    
    /* Watermark */
    .receipt-watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0.03;
        z-index: 0;
        pointer-events: none;
    }
    
    .receipt-watermark img {
        width: 400px;
        height: auto;
    }
    
    .receipt-content {
        position: relative;
        z-index: 1;
    }
    
    /* Logo Section */
    .receipt-logo {
        text-align: center;
        margin-bottom: 25px;
    }
    
    .receipt-logo img {
        max-width: 160px;
        height: auto;
    }
    
    /* Header Info */
    .receipt-header-info {
        text-align: right;
        margin-bottom: 20px;
        font-size: 13px;
        color: #666;
    }
    
    .receipt-header-info p {
        margin: 4px 0;
        line-height: 1.5;
    }
    
    .receipt-header-info strong {
        color: #333;
    }
    
    /* Title */
    .receipt-title {
        text-align: center;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 3px solid var(--receipt-primary);
    }
    
    .receipt-title h1 {
        font-size: 26px;
        font-weight: 700;
        color: var(--receipt-primary);
        letter-spacing: 2px;
        text-transform: uppercase;
        margin: 0;
    }
    
    /* Parties Section */
    .receipt-parties {
        display: flex;
        gap: 30px;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .receipt-party {
        flex: 1;
    }
    
    .receipt-party-heading {
        font-size: 13px;
        font-weight: 700;
        color: var(--receipt-primary);
        text-transform: uppercase;
        margin-bottom: 10px;
        letter-spacing: 1px;
    }
    
    .receipt-party-details {
        font-size: 13px;
        line-height: 1.7;
        color: #666;
    }
    
    .receipt-party-details p {
        margin: 3px 0;
    }
    
    .receipt-party-details strong {
        color: #333;
        font-weight: 600;
    }
    
    /* Items Table */
    .receipt-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 25px;
    }
    
    .receipt-table thead {
        background: var(--receipt-primary);
        color: white;
    }
    
    .receipt-table th {
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .receipt-table td {
        padding: 12px 15px;
        border: 1px solid #e9ecef;
        font-size: 13px;
        color: #333;
    }
    
    .receipt-table tbody tr:nth-child(even) {
        background: #f8f9fa;
    }
    
    .receipt-table .text-right {
        text-align: right;
    }
    
    /* Summary Section */
    .receipt-summary {
        display: flex;
        gap: 30px;
        margin-bottom: 30px;
    }
    
    .receipt-summary-left {
        flex: 1;
    }
    
    .receipt-summary-right {
        flex: 1;
    }
    
    /* Bank Details */
    .receipt-bank-heading {
        font-size: 13px;
        font-weight: 700;
        color: var(--receipt-primary);
        text-transform: uppercase;
        margin-bottom: 10px;
        letter-spacing: 1px;
    }
    
    .receipt-bank-details {
        font-size: 12px;
        line-height: 1.7;
        color: #666;
    }
    
    .receipt-bank-details p {
        margin: 3px 0;
    }
    
    .receipt-bank-details strong {
        color: #333;
    }
    
    /* Totals Table */
    .receipt-totals {
        width: 100%;
        margin-bottom: 15px;
    }
    
    .receipt-totals tr {
        border-bottom: 1px solid #f0f0f0;
    }
    
    .receipt-totals td {
        padding: 10px 12px;
        font-size: 13px;
    }
    
    .receipt-totals td:first-child {
        text-align: left;
        color: #666;
    }
    
    .receipt-totals td:last-child {
        text-align: right;
        font-weight: 600;
        color: #333;
    }
    
    .receipt-total-row {
        background: var(--receipt-primary);
        color: white !important;
    }
    
    .receipt-total-row td {
        font-weight: 700;
        font-size: 14px;
        padding: 12px;
        color: white !important;
        border: none;
    }
    
    /* Amount Box */
    .receipt-amount-box {
        background: linear-gradient(135deg, #E8F0FC 0%, #D4E4F7 100%);
        border: 2px solid #C5D9F2;
        border-radius: 8px;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .receipt-amount-box .label {
        font-size: 14px;
        font-weight: 700;
        color: var(--receipt-primary);
    }
    
    .receipt-amount-box .amount {
        font-size: 18px;
        font-weight: 700;
        color: var(--receipt-primary);
    }
    
    /* Narration Box */
    .receipt-narration {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 15px;
        margin-top: 15px;
    }
    
    .receipt-narration .label {
        font-size: 12px;
        font-weight: 700;
        color: var(--receipt-primary);
        text-transform: uppercase;
        margin-bottom: 8px;
        letter-spacing: 0.5px;
    }
    
    .receipt-narration .text {
        font-size: 13px;
        color: #555;
        line-height: 1.6;
    }
    
    /* Payment Info Box */
    .receipt-payment-info {
        background: #fff8e6;
        border: 1px solid #ffe0a3;
        border-radius: 6px;
        padding: 15px;
        margin-top: 15px;
    }
    
    .receipt-payment-info .label {
        font-size: 12px;
        font-weight: 700;
        color: #b8860b;
        text-transform: uppercase;
        margin-bottom: 8px;
        letter-spacing: 0.5px;
    }
    
    .receipt-payment-info .details {
        display: flex;
        gap: 30px;
        font-size: 13px;
        color: #555;
    }
    
    .receipt-payment-info .details span {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .receipt-payment-info .details strong {
        color: #333;
    }
    
    /* Signatures */
    .receipt-signatures {
        display: flex;
        justify-content: space-between;
        margin-top: 50px;
        padding-top: 20px;
    }
    
    .receipt-signature {
        text-align: center;
    }
    
    .receipt-signature-line {
        width: 150px;
        border-top: 1px solid #333;
        margin-bottom: 8px;
    }
    
    .receipt-signature-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--receipt-primary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* Status Badge */
    .receipt-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .receipt-status.gst {
        background: #e8f5e9;
        color: #2e7d32;
    }
    
    .receipt-status.non-gst {
        background: #fff3e0;
        color: #ef6c00;
    }
    
    @media print {
        .receipt-actions {
            display: none !important;
        }
        
        .receipt-container {
            box-shadow: none;
            border-radius: 0;
        }
    }
    
    @media (max-width: 768px) {
        .receipt-parties,
        .receipt-summary {
            flex-direction: column;
            gap: 20px;
        }
        
        .receipt-payment-info .details {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>
@endpush

@section('content')
@php
    // Get linked invoices for additional details
    $invoices = $receipt->invoices();
    $firstInvoice = $invoices->first();
    $clientAddress = $firstInvoice->address ?? null;
    $clientGstNo = $firstInvoice->gst_no ?? null;
    $clientMobile = $firstInvoice->mobile_no ?? null;
    $isGstReceipt = $receipt->invoice_type === 'gst';
    
    // Calculate total tax from all linked invoices
    $totalTax = 0;
    $totalInvoiceAmount = 0;
    
    foreach ($invoices as $inv) {
        if ($inv->invoice_type === 'gst') {
            $totalTax += ($inv->cgst_amount ?? 0) + ($inv->sgst_amount ?? 0) + ($inv->igst_amount ?? 0);
        }
        $totalInvoiceAmount += $inv->final_amount ?? 0;
    }
@endphp

<div class="container mx-auto px-4 py-6">
    <div class="receipt-container">
        <!-- Action Buttons -->
        <div class="receipt-actions">
            <div>
                <span class="receipt-status {{ $isGstReceipt ? 'gst' : 'non-gst' }}">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                    </svg>
                    {{ $isGstReceipt ? 'GST Receipt' : 'Non-GST Receipt' }}
                </span>
            </div>
            <div class="btn-group">
                <a href="{{ route('receipts.print', $receipt->id) }}" target="_blank" class="receipt-btn receipt-btn-print">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                        <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                    </svg>
                    Print
                </a>
                @if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Receipts Management.edit receipt'))
                <a href="{{ route('receipts.edit', $receipt->id) }}" class="receipt-btn receipt-btn-edit">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                    </svg>
                    Edit
                </a>
                @endif
                <a href="{{ route('receipts.index') }}" class="receipt-btn receipt-btn-back">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    Back
                </a>
            </div>
        </div>
        
        <!-- Receipt Content -->
        <div class="receipt-page">
            <!-- Watermark -->
            <div class="receipt-watermark">
                <img src="{{ asset('full_logo.jpeg') }}" alt="Watermark">
            </div>
            
            <div class="receipt-content">
                <!-- Logo -->
                <div class="receipt-logo">
                    <img src="{{ asset('full_logo.jpeg') }}" alt="Company Logo">
                </div>
                
                <!-- Header Info -->
                <div class="receipt-header-info">
                    <p><strong>Date:</strong> {{ $receipt->receipt_date ? $receipt->receipt_date->format('d-m-Y') : date('d-m-Y') }}</p>
                    <p><strong>Receipt No.:</strong> {{ $receipt->unique_code }}</p>
                    @if($invoices->count() > 0)
                    <p><strong>Invoice No.:</strong> {{ $invoices->pluck('unique_code')->implode(', ') }}</p>
                    @endif
                </div>
                
                <!-- Title -->
                <div class="receipt-title">
                    <h1>{{ $isGstReceipt ? 'Payment Receipt' : 'Receipt' }}</h1>
                </div>
                
                <!-- From and Received From -->
                <div class="receipt-parties">
                    <div class="receipt-party">
                        <div class="receipt-party-heading">From</div>
                        <div class="receipt-party-details">
                            <p><strong>CHITRI ENLARGE SOFT IT HUB PVT. LTD.</strong></p>
                            {{-- <p>401/B, RISE ON PLAZA, SARKHEJ JAKAT NAKA,</p>
                            <p>SURAT, 390006.</p> --}}
                            <p>244/45, Raj Imperia, Near Sarthana Police Station,</p>
                            <p>Vraj Chowk, Simada, Surat - 395006.</p>
                            @if($isGstReceipt)
                            <p>GST. NO.: 24AAMCC4413E1Z1</p>
                            @endif
                            <p>Mo. (+91) 72763 23999</p>
                        </div>
                    </div>
                    
                    <div class="receipt-party">
                        <div class="receipt-party-heading">Received From</div>
                        <div class="receipt-party-details">
                            <p><strong>{{ strtoupper($receipt->company_name) }}</strong></p>
                            @if($clientAddress)
                            <p>{{ $clientAddress }}</p>
                            @endif
                            @if($isGstReceipt && $clientGstNo)
                            <p>GST. NO.: {{ $clientGstNo }}</p>
                            @endif
                            @if($clientMobile)
                            <p>Mo. {{ display_mobile($clientMobile) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Payment Details Table -->
                <table class="receipt-table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th class="text-right" style="width: 180px;">Amount (INR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong>Payment Received</strong>
                                @if($invoices->count() > 0)
                                <br><small style="color: #666;">Against Invoice: {{ $invoices->pluck('unique_code')->implode(', ') }}</small>
                                @endif
                            </td>
                            <td class="text-right"><strong>₹{{ number_format($receipt->received_amount, 2) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
                
                <!-- Summary Section -->
                <div class="receipt-summary">
                    <!-- Bank Details -->
                    <div class="receipt-summary-left">
                        <div class="receipt-bank-heading">Bank Details</div>
                        <div class="receipt-bank-details">
                            <p><strong>Account No:</strong> 001161900016923</p>
                            <p><strong>IFSC Code:</strong> YESB0000011</p>
                            <p><strong>Branch:</strong> YES BANK LTD., GR FLOOR,</p>
                            <p>MANGALDEEP, RING ROAD,</p>
                            <p>NEAR MAHAVIR HOSPITAL, NEAR RTO,</p>
                            <p>SURAT 395001.</p>
                        </div>
                        
                        @if($receipt->payment_type || $receipt->trans_code)
                        <div class="receipt-payment-info">
                            <div class="label">Payment Information</div>
                            <div class="details">
                                @if($receipt->payment_type)
                                <span><strong>Mode:</strong> {{ $receipt->payment_type }}</span>
                                @endif
                                @if($receipt->trans_code)
                                <span><strong>Trans Code:</strong> {{ $receipt->trans_code }}</span>
                                @endif
                            </div>
                        </div>
                        @endif
                        
                        @if($receipt->narration)
                        <div class="receipt-narration">
                            <div class="label">Narration</div>
                            <div class="text">{{ $receipt->narration }}</div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Amount Received -->
                    <div class="receipt-summary-right">
                        <table class="receipt-totals">
                            @if($invoices->count() > 0)
                            <tr>
                                <td>Total Invoice Amount</td>
                                <td>₹{{ number_format($totalInvoiceAmount, 2) }}</td>
                            </tr>
                            @endif
                            @if($isGstReceipt && $totalTax > 0)
                            <tr>
                                <td>Total Tax (GST)</td>
                                <td>₹{{ number_format($totalTax, 2) }}</td>
                            </tr>
                            @endif
                            <tr class="receipt-total-row">
                                <td>Amount Received</td>
                                <td>₹{{ number_format($receipt->received_amount, 2) }}</td>
                            </tr>
                        </table>
                        
                        <div class="receipt-amount-box">
                            <div class="label">Total Received</div>
                            <div class="amount">₹{{ number_format($receipt->received_amount, 2) }} /-</div>
                        </div>
                    </div>
                </div>
                
                <!-- Signatures -->
                <div class="receipt-signatures">
                    <div class="receipt-signature">
                        <div class="receipt-signature-line"></div>
                        <div class="receipt-signature-label">Authorized Signature</div>
                    </div>
                    <div class="receipt-signature">
                        <div class="receipt-signature-line"></div>
                        <div class="receipt-signature-label">Received By</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
