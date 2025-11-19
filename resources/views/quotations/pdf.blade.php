<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation - {{ $quotation->unique_code }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .company-name { font-size: 20px; font-weight: bold; margin-bottom: 10px; }
        .section { margin-bottom: 20px; }
        .section-title { font-size: 14px; font-weight: bold; margin-bottom: 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        .info-row { margin-bottom: 5px; }
        .info-label { font-weight: bold; display: inline-block; width: 120px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; font-weight: bold; }
        .total-row { font-weight: bold; background-color: #f9f9f9; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $quotation->footer_company_name ?? 'Company Name' }}</div>
        <div>QUOTATION</div>
        <div>{{ $quotation->unique_code }}</div>
    </div>

    <div class="section">
        <div class="section-title">Client Information</div>
        <div class="info-row">
            <span class="info-label">Company:</span>
            {{ $quotation->company_name }}
        </div>
        <div class="info-row">
            <span class="info-label">Contact:</span>
            {{ $quotation->contact_person_1 }}
        </div>
        <div class="info-row">
            <span class="info-label">Email:</span>
            {{ $quotation->company_email }}
        </div>
        <div class="info-row">
            <span class="info-label">Phone:</span>
            {{ $quotation->contact_number_1 }}
        </div>
    </div>

    <div class="section">
        <div class="section-title">Quotation Details</div>
        <div class="info-row">
            <span class="info-label">Title:</span>
            {{ $quotation->quotation_title }}
        </div>
        <div class="info-row">
            <span class="info-label">Date:</span>
            {{ $quotation->quotation_date ? $quotation->quotation_date->format('d/m/Y') : 'N/A' }}
        </div>
        <div class="info-row">
            <span class="info-label">Amount:</span>
            ₹ {{ number_format($quotation->contract_amount ?? 0, 2) }}
        </div>
    </div>

    @if($quotation->scope_of_work)
    <div class="section">
        <div class="section-title">Scope of Work</div>
        <div>{{ $quotation->scope_of_work }}</div>
    </div>
    @endif

    <div style="margin-top: 50px; text-align: center; font-size: 10px; color: #666;">
        Generated on {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>