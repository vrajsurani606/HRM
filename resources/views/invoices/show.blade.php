@extends('layouts.macos')
@section('page_title', 'Invoice Details')
@section('content')

<style>
    :root {
        --primary-color: #456DB5;
        --border-color: #ddd;
    }
    
    .invoice-page {
        max-width: 900px;
        margin: 0 auto;
        background: white;
        padding: 30px;
        border: 2px solid var(--border-color);
        position: relative;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        border-radius: 8px;
    }
    
    /* Background Watermark */
    .watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0.03;
        z-index: 0;
        pointer-events: none;
    }
    
    .watermark img {
        width: 500px;
        height: auto;
    }
    
    .invoice-content {
        position: relative;
        z-index: 1;
    }
    
    /* Logo Section */
    .logo-section {
        text-align: center;
        margin-bottom: 25px;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }
    
    .logo-section img {
        max-width: 160px;
        height: auto;
        display: block;
        margin: 0 auto;
    }
    
    /* Header Info */
    .header-info {
        text-align: right;
        margin-bottom: 20px;
        font-size: 13px;
        color: #666;
    }
    
    .header-info p {
        margin: 3px 0;
        line-height: 1.5;
    }
    
    .header-info strong {
        color: #000;
    }
    
    /* Title */
    .invoice-title {
        text-align: center;
        margin-bottom: 25px;
        padding-bottom: 8px;
        border-bottom: 2px solid var(--primary-color);
    }
    
    .invoice-title h1 {
        font-size: 26px;
        font-weight: 700;
        color: var(--primary-color);
        letter-spacing: 2px;
        text-transform: uppercase;
        margin: 0;
    }
    
    /* From and Bill To Section */
    .parties-section {
        display: flex;
        width: 100%;
        margin-bottom: 25px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 15px;
        gap: 20px;
    }
    
    .party-column {
        flex: 1;
    }
    
    .party-heading {
        font-size: 14px;
        font-weight: 700;
        color: var(--primary-color);
        text-transform: uppercase;
        margin-bottom: 10px;
    }
    
    .party-details {
        font-size: 13px;
        line-height: 1.7;
        color: #666;
    }
    
    .party-details p {
        margin: 2px 0;
    }
    
    .party-details strong {
        color: #000;
        font-weight: 700;
    }
    
    /* Table */
    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 25px;
    }
    
    .items-table thead {
        background: var(--primary-color);
        color: white;
    }
    
    .items-table th {
        padding: 12px 10px;
        text-align: left;
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        border: 1px solid var(--primary-color);
    }
    
    .items-table td {
        padding: 10px;
        border: 1px solid #ddd;
        font-size: 13px;
        color: #333;
    }
    
    .items-table tbody tr:nth-child(even) {
        background: #f9f9f9;
    }
    
    .text-center {
        text-align: center !important;
    }
    
    .text-right {
        text-align: right !important;
    }
    
    /* Summary Section */
    .summary-section {
        display: flex;
        width: 100%;
        margin-bottom: 30px;
        gap: 30px;
    }
    
    .summary-left {
        flex: 1;
    }
    
    .summary-right {
        flex: 1;
    }
    
    /* Bank Details */
    .bank-details-heading {
        font-size: 14px;
        font-weight: 700;
        color: var(--primary-color);
        text-transform: uppercase;
        margin-bottom: 10px;
    }
    
    .bank-details-text {
        font-size: 12px;
        line-height: 1.7;
        color: #666;
    }
    
    .bank-details-text p {
        margin: 2px 0;
    }
    
    .bank-details-text strong {
        color: #000;
    }
    
    /* Totals Table */
    .totals-table {
        width: 100%;
        margin-bottom: 15px;
    }
    
    .totals-table tr {
        border-bottom: 1px solid #f0f0f0;
    }
    
    .totals-table td {
        padding: 8px 10px;
        font-size: 13px;
    }
    
    .totals-table td:first-child {
        text-align: left;
        color: #666;
    }
    
    .totals-table td:last-child {
        text-align: right;
        font-weight: 700;
        color: #000;
    }
    
    .total-amount-row {
        background: var(--primary-color);
        color: white !important;
    }
    
    .total-amount-row td {
        font-weight: 700;
        font-size: 14px;
        padding: 10px;
        color: white !important;
        border: none;
    }
    
    /* Balance Due */
    .balance-due-box {
        background: #E8F0FC;
        border: 1px solid #C5D9F2;
        border-radius: 4px;
        padding: 12px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .balance-due-box .label {
        font-size: 15px;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .balance-due-box .amount {
        font-size: 16px;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    /* Signatures */
    .signatures-section {
        display: flex;
        width: 100%;
        margin-top: 50px;
        justify-content: space-between;
    }
    
    .signature-box {
        text-align: center;
    }
    
    .signature-label {
        font-size: 13px;
        font-weight: 700;
        color: var(--primary-color);
        text-transform: uppercase;
        padding-top: 50px;
        border-top: 1px solid #ddd;
        display: inline-block;
        min-width: 180px;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-bottom: 20px;
    }
    
    .action-buttons .btn {
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    
    .btn-print {
        background: var(--primary-color);
        color: white;
    }
    
    .btn-print:hover {
        background: #3a5a9a;
        color: white;
    }
    
    .btn-back {
        background: #6b7280;
        color: white;
    }
    
    .btn-back:hover {
        background: #4b5563;
        color: white;
    }
</style>

<div style="padding: 20px;">
    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('invoices.print', $invoice->id) }}" target="_blank" class="btn btn-print">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                <rect x="6" y="14" width="12" height="8"></rect>
            </svg>
            Print Invoice
        </a>
        <a href="{{ route('invoices.index') }}" class="btn btn-back">
            ← Back to List
        </a>
    </div>

    <div class="invoice-page">
        <!-- Background Watermark -->
        <div class="watermark">
            <img src="{{ asset('full_logo.jpeg') }}" alt="Watermark">
        </div>
        
        <div class="invoice-content">
            <!-- Logo -->
            <div class="logo-section">
                <img src="{{ asset('full_logo.jpeg') }}" alt="Company Logo">
            </div>
            
            <!-- Header Info -->
            <div class="header-info">
                <p><strong>Date:</strong> {{ $invoice->invoice_date ? $invoice->invoice_date->format('d-m-Y') : date('d-m-Y') }}</p>
                <p><strong>Invoice No.:</strong> {{ $invoice->unique_code }}</p>
                @if($invoice->proforma)
                <p><strong>Proforma No.:</strong> {{ $invoice->proforma->unique_code }}</p>
                @endif
            </div>
            
            <!-- Title -->
            <div class="invoice-title">
                @if($invoice->invoice_type === 'gst')
                <h1>Tax Invoice</h1>
                @else
                <h1>Invoice</h1>
                @endif
            </div>
            
            <!-- From and Bill To -->
            <div class="parties-section">
                <div class="party-column">
                    <div class="party-heading">From</div>
                    <div class="party-details">
                        <p><strong>CHITRI ENLARGE SOFT IT HUB PVT. LTD.</strong></p>
                        {{-- <p>401/B, RISE ON PLAZA, SARKHEJ JAKAT NAKA,</p>
                        <p>SURAT, 390006.</p> --}}
                        <p>244/45, Raj Imperia, Near Sarthana Police Station,</p>
                        <p>Vraj Chowk, Simada, Surat - 395006.</p>
                        @if($invoice->invoice_type === 'gst')
                        <p>GST. NO.: 24AAMCC4413E1Z1</p>
                        @endif
                        <p>Mo. (+91) 72763 23999</p>
                    </div>
                </div>
                
                <div class="party-column">
                    <div class="party-heading">Bill To</div>
                    <div class="party-details">
                        <p><strong>{{ strtoupper($invoice->company_name) }}</strong></p>
                        @if($invoice->address)
                        <p>{{ $invoice->address }}</p>
                        @endif
                        @if($invoice->invoice_type === 'gst' && $invoice->gst_no)
                        <p>GST. NO.: {{ $invoice->gst_no }}</p>
                        @endif
                        @if($invoice->mobile_no)
                        <p>Mo. {{ display_mobile($invoice->mobile_no) }}</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Items Table -->
            <table class="items-table">
                <thead>
                    <tr>
                        <th>DESCRIPTION</th>
                        <th class="text-center" style="width: 80px;">HSN/SAC</th>
                        <th class="text-center" style="width: 60px;">QTY</th>
                        <th class="text-right" style="width: 130px;">UNIT PRICE (INR)</th>
                        <th class="text-right" style="width: 130px;">TOTAL</th>
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
                        <td><strong>{{ strtoupper($descriptions[$i] ?? '-') }}</strong></td>
                        <td class="text-center">{{ $sacCodes[$i] ?? '-' }}</td>
                        <td class="text-center">{{ $quantities[$i] ?? '-' }}</td>
                        <td class="text-right">₹{{ isset($rates[$i]) ? number_format($rates[$i], 0) : '-' }}</td>
                        <td class="text-right"><strong>₹{{ isset($totals[$i]) ? number_format($totals[$i], 2) : '-' }}</strong></td>
                    </tr>
                    @endif
                    @endfor
                </tbody>
            </table>

            <!-- Summary Section -->
            <div class="summary-section">
                <!-- Bank Details -->
                <div class="summary-left">
                    <div class="bank-details-heading">Bank Details</div>
                    <div class="bank-details-text">
                        <p><strong>Account No:</strong> 001161900016923</p>
                        <p><strong>IFSC Code:</strong> YESB0000011</p>
                        <p><strong>Branch:</strong> YES BANK LTD., GR FLOOR,</p>
                        <p>MANGALDEEP, RING ROAD,</p>
                        <p>NEAR MAHAVIR HOSPITAL, NEAR RTO,</p>
                        <p>SURAT 395001.</p>
                    </div>
                </div>
                
                <!-- Totals -->
                <div class="summary-right">
                    <table class="totals-table">
                        <tr>
                            <td>Subtotal</td>
                            <td>₹{{ number_format($invoice->sub_total ?? 0, 2) }}</td>
                        </tr>
                        @if($invoice->discount_amount > 0)
                        <tr>
                            <td>Discount ({{ $invoice->discount_percent }}%)</td>
                            <td>₹{{ number_format($invoice->discount_amount, 2) }}</td>
                        </tr>
                        @endif
                        @if(isset($invoice->retention_amount) && $invoice->retention_amount > 0)
                        <tr>
                            <td>Retention ({{ number_format($invoice->retention_percent ?? 0, 2) }}%)</td>
                            <td>₹{{ number_format($invoice->retention_amount, 2) }}</td>
                        </tr>
                        @endif
                        @if($invoice->invoice_type === 'gst' && $invoice->cgst_amount > 0)
                        <tr>
                            <td>CGST ({{ $invoice->cgst_percent }}%)</td>
                            <td>₹{{ number_format($invoice->cgst_amount, 2) }}</td>
                        </tr>
                        @endif
                        @if($invoice->invoice_type === 'gst' && $invoice->sgst_amount > 0)
                        <tr>
                            <td>SGST ({{ $invoice->sgst_percent }}%)</td>
                            <td>₹{{ number_format($invoice->sgst_amount, 2) }}</td>
                        </tr>
                        @endif
                        @if($invoice->invoice_type === 'gst' && $invoice->igst_amount > 0)
                        <tr>
                            <td>IGST ({{ $invoice->igst_percent }}%)</td>
                            <td>₹{{ number_format($invoice->igst_amount, 2) }}</td>
                        </tr>
                        @endif
                        <tr class="total-amount-row">
                            <td>Total Amount</td>
                            <td>₹{{ number_format($invoice->final_amount ?? 0, 2) }}</td>
                        </tr>
                    </table>
                    
                    <div class="balance-due-box">
                        <div class="label">Balance Due</div>
                        <div class="amount">₹{{ number_format($invoice->final_amount ?? 0, 2) }} /-</div>
                    </div>
                </div>
            </div>
            
            <!-- Signatures -->
            <div class="signatures-section">
                <div class="signature-box">
                    <div class="signature-label">Company Signature</div>
                </div>
                <div class="signature-box">
                    <div class="signature-label">Client Signature</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
