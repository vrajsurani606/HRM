<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $receipt->unique_code }}</title>
    <style>
        :root {
            --primary-color: #456DB5;
            --border-color: #ddd;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
            padding: 20px;
            margin: 0;
        }
        
        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border: 2px solid var(--border-color);
            position: relative;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
            width: 600px;
            height: auto;
        }
        
        .content {
            position: relative;
            z-index: 1;
        }
        
        /* Logo Section */
        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo-section img {
            max-width: 180px;
            height: auto;
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
        .receipt-title {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--primary-color);
        }
        
        .receipt-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        
        /* From and Bill To Section */
        .parties-section {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }
        
        .party-column {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 0 10px;
        }
        
        .party-column:first-child {
            padding-left: 0;
        }
        
        .party-column:last-child {
            padding-right: 0;
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
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        /* Summary Section */
        .summary-section {
            display: table;
            width: 100%;
            margin-bottom: 40px;
        }
        
        .summary-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }
        
        .summary-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
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
        
        /* Amount Box */
        .amount-box {
            background: #E8F0FC;
            border: 1px solid #C5D9F2;
            border-radius: 4px;
            padding: 12px 15px;
            display: table;
            width: 100%;
        }
        
        .amount-box .label {
            display: table-cell;
            font-size: 15px;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .amount-box .amount {
            display: table-cell;
            text-align: right;
            font-size: 16px;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        /* Narration Box */
        .narration-box {
            background: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 12px 15px;
            margin-top: 15px;
        }
        
        .narration-box .label {
            font-size: 12px;
            font-weight: 700;
            color: var(--primary-color);
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .narration-box .text {
            font-size: 13px;
            color: #333;
            line-height: 1.6;
        }
        
        /* Signatures */
        .signatures-section {
            display: table;
            width: 100%;
            margin-top: 60px;
        }
        
        .signature-box {
            display: table-cell;
            width: 50%;
        }
        
        .signature-box:last-child {
            text-align: right;
        }
        
        .signature-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--primary-color);
            text-transform: uppercase;
            margin-bottom: 60px;
            display: inline-block;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
                background: white;
            }
            
            .page {
                margin: 0;
                padding: 10mm 8mm;
                width: 100%;
                max-width: 100%;
                min-height: 297mm;
                border: none;
                box-shadow: none;
            }
            
            @page {
                size: A4;
                margin: 0;
            }
            
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>
    @php
        // Get linked invoices for additional details
        $invoices = $receipt->invoices();
        $firstInvoice = $invoices->first();
        $clientAddress = $firstInvoice->address ?? null;
        $clientGstNo = $firstInvoice->gst_no ?? null;
        $clientMobile = $firstInvoice->mobile_no ?? null;
        $isGstReceipt = $receipt->invoice_type === 'gst' || ($firstInvoice && $firstInvoice->invoice_type === 'gst');
        
        // Calculate total tax from all linked invoices
        $totalCgst = 0;
        $totalSgst = 0;
        $totalIgst = 0;
        $totalTax = 0;
        $totalSubtotal = 0;
        $totalInvoiceAmount = 0;
        $cgstPercent = 0;
        $sgstPercent = 0;
        $igstPercent = 0;
        
        foreach ($invoices as $inv) {
            if ($inv->invoice_type === 'gst') {
                $totalCgst += $inv->cgst_amount ?? 0;
                $totalSgst += $inv->sgst_amount ?? 0;
                $totalIgst += $inv->igst_amount ?? 0;
                $totalTax += ($inv->cgst_amount ?? 0) + ($inv->sgst_amount ?? 0) + ($inv->igst_amount ?? 0);
                $totalSubtotal += $inv->sub_total ?? 0;
                $totalInvoiceAmount += $inv->final_amount ?? 0;
                // Get tax percentages from first GST invoice
                if ($cgstPercent == 0) $cgstPercent = $inv->cgst_percent ?? 0;
                if ($sgstPercent == 0) $sgstPercent = $inv->sgst_percent ?? 0;
                if ($igstPercent == 0) $igstPercent = $inv->igst_percent ?? 0;
            }
        }
    @endphp
    
    <div class="page">
        <!-- Background Watermark -->
        <div class="watermark">
            <img src="{{ asset('full_logo.jpeg') }}" alt="Watermark">
        </div>
        
        <div class="content">
            <!-- Logo -->
            <div class="logo-section">
                <img src="{{ asset('full_logo.jpeg') }}" alt="Enlargesoft Logo">
            </div>
            
            <!-- Header Info -->
            <div class="header-info">
                <p><strong>Date:</strong> {{ $receipt->receipt_date ? $receipt->receipt_date->format('d-m-Y') : date('d-m-Y') }}</p>
                <p><strong>Receipt No.:</strong> {{ $receipt->unique_code }}</p>
                @if($invoices->count() > 0)
                <p><strong>Invoice No.:</strong> {{ $invoices->pluck('unique_code')->implode(', ') }}</p>
                @endif
            </div>
            
            <!-- Title -->
            <div class="receipt-title">
                @if($isGstReceipt)
                <h1>Payment Receipt</h1>
                @else
                <h1>Receipt</h1>
                @endif
            </div>
            
            <!-- From and Bill To -->
            <div class="parties-section">
                <div class="party-column">
                    <div class="party-heading">From</div>
                    <div class="party-details">
                        <p><strong>CHITRI ENLARGE SOFT IT HUB PVT. LTD.</strong></p>
                        <p>401/B, RISE ON PLAZA, SARKHEJ JAKAT NAKA,</p>
                        <p>SURAT, 390006.</p>
                        @if($isGstReceipt)
                        <p>GST. NO.: 24AAMCC4413E1Z1</p>
                        @endif
                        <p>Mo. (+91) 72763 23999</p>
                    </div>
                </div>
                
                <div class="party-column">
                    <div class="party-heading">Received From</div>
                    <div class="party-details">
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
            <table class="items-table">
                <thead>
                    <tr>
                        <th>DESCRIPTION</th>
                        <th class="text-right" style="width: 180px;">AMOUNT (INR)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>PAYMENT RECEIVED</strong>
                            @if($invoices->count() > 0)
                            <br><small style="color: #666;">Against Invoice: {{ $invoices->pluck('unique_code')->implode(', ') }}</small>
                            @endif
                        </td>
                        <td class="text-right"><strong>₹{{ number_format($receipt->received_amount, 2) }}</strong></td>
                    </tr>
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
                
                <!-- Amount Received -->
                <div class="summary-right">
                    <table class="totals-table">
                        @if($isGstReceipt && $totalTax > 0)
                        <tr>
                            <td>Total Tax (GST)</td>
                            <td>₹{{ number_format($totalTax, 2) }}</td>
                        </tr>
                        @endif
                        <tr class="total-amount-row">
                            <td>Amount Received</td>
                            <td>₹{{ number_format($receipt->received_amount, 2) }}</td>
                        </tr>
                    </table>
                    
                    <div class="amount-box">
                        <div class="label">Total Received</div>
                        <div class="amount">₹{{ number_format($receipt->received_amount, 2) }} /-</div>
                    </div>
                </div>
            </div>
            
            <!-- Signatures -->
            <div class="signatures-section">
                <div class="signature-box">
                    <div class="signature-label">Authorized Signature</div>
                </div>
                <div class="signature-box">
                    <div class="signature-label">Received By</div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
