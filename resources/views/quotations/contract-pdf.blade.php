<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contract - {{ $quotation->unique_code }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; line-height: 1.4; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .company-name { font-size: 24px; font-weight: bold; color: #333; margin-bottom: 10px; }
        .contract-title { font-size: 18px; color: #666; }
        .section { margin-bottom: 25px; }
        .section-title { font-size: 14px; font-weight: bold; color: #333; margin-bottom: 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        .info-row { display: flex; margin-bottom: 8px; }
        .info-label { font-weight: bold; width: 150px; }
        .info-value { flex: 1; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; font-weight: bold; }
        .total-row { font-weight: bold; background-color: #f9f9f9; }
        .terms { margin-top: 30px; }
        .signature-section { margin-top: 50px; display: flex; justify-content: space-between; }
        .signature-box { width: 200px; text-align: center; }
        .signature-line { border-top: 1px solid #333; margin-top: 50px; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $quotation->footer_company_name ?? 'Company Name' }}</div>
        <div class="contract-title">CONTRACT AGREEMENT</div>
        <div style="margin-top: 10px; font-size: 14px;">Contract No: {{ $quotation->unique_code }}</div>
    </div>

    <div class="section">
        <div class="section-title">Client Information</div>
        <div class="info-row">
            <div class="info-label">Company Name:</div>
            <div class="info-value">{{ $quotation->company_name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Contact Person:</div>
            <div class="info-value">{{ $quotation->contact_person_1 }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Contact Number:</div>
            <div class="info-value">{{ $quotation->contact_number_1 }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Email:</div>
            <div class="info-value">{{ $quotation->company_email }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Address:</div>
            <div class="info-value">{{ $quotation->address }}</div>
        </div>
        @if($quotation->gst_no)
        <div class="info-row">
            <div class="info-label">GST No:</div>
            <div class="info-value">{{ $quotation->gst_no }}</div>
        </div>
        @endif
    </div>

    <div class="section">
        <div class="section-title">Project Details</div>
        <div class="info-row">
            <div class="info-label">Project Title:</div>
            <div class="info-value">{{ $quotation->quotation_title }}</div>
        </div>
        @if($quotation->scope_of_work)
        <div class="info-row">
            <div class="info-label">Scope of Work:</div>
            <div class="info-value">{{ $quotation->scope_of_work }}</div>
        </div>
        @endif
        @if($quotation->project_start_date)
        <div class="info-row">
            <div class="info-label">Start Date:</div>
            <div class="info-value">{{ $quotation->project_start_date->format('d/m/Y') }}</div>
        </div>
        @endif
        @if($quotation->completion_time)
        <div class="info-row">
            <div class="info-label">Completion Time:</div>
            <div class="info-value">{{ $quotation->completion_time }}</div>
        </div>
        @endif
    </div>

    @if($quotation->services_1 && count($quotation->services_1['description'] ?? []) > 0)
    <div class="section">
        <div class="section-title">Services & Pricing</div>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Rate (₹)</th>
                    <th>Total (₹)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotation->services_1['description'] as $index => $description)
                <tr>
                    <td>{{ $description }}</td>
                    <td>{{ $quotation->services_1['quantity'][$index] ?? 0 }}</td>
                    <td>{{ number_format($quotation->services_1['rate'][$index] ?? 0, 2) }}</td>
                    <td>{{ number_format($quotation->services_1['total'][$index] ?? 0, 2) }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3">Contract Amount</td>
                    <td>₹ {{ number_format($quotation->contract_amount ?? 0, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    @if($quotation->services_2 && count($quotation->services_2['description'] ?? []) > 0)
    <div class="section">
        <div class="section-title">Payment Terms</div>
        <table>
            <thead>
                <tr>
                    <th>Payment Stage</th>
                    <th>Percentage (%)</th>
                    <th>Amount (₹)</th>
                    <th>Terms</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotation->services_2['description'] as $index => $description)
                <tr>
                    <td>{{ $description }}</td>
                    <td>{{ $quotation->services_2['completion_percent'][$index] ?? 0 }}%</td>
                    <td>{{ number_format($quotation->services_2['total'][$index] ?? 0, 2) }}</td>
                    <td>{{ $quotation->services_2['completion_terms'][$index] ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if($quotation->amc_amount)
    <div class="section">
        <div class="section-title">AMC Details</div>
        <div class="info-row">
            <div class="info-label">AMC Start Date:</div>
            <div class="info-value">{{ $quotation->amc_start_date ? $quotation->amc_start_date->format('d/m/Y') : 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">AMC Amount:</div>
            <div class="info-value">₹ {{ number_format($quotation->amc_amount, 2) }}</div>
        </div>
    </div>
    @endif

    @if($quotation->retention_amount)
    <div class="section">
        <div class="section-title">Retention Details</div>
        <div class="info-row">
            <div class="info-label">Retention Amount:</div>
            <div class="info-value">₹ {{ number_format($quotation->retention_amount, 2) }}</div>
        </div>
        @if($quotation->retention_percent)
        <div class="info-row">
            <div class="info-label">Retention Percentage:</div>
            <div class="info-value">{{ $quotation->retention_percent }}%</div>
        </div>
        @endif
        @if($quotation->retention_time)
        <div class="info-row">
            <div class="info-label">Retention Period:</div>
            <div class="info-value">{{ $quotation->retention_time }}</div>
        </div>
        @endif
    </div>
    @endif

    <div class="terms">
        <div class="section-title">Terms & Conditions</div>
        @if($quotation->custom_terms)
            <div style="white-space: pre-line;">{{ $quotation->custom_terms }}</div>
        @else
            <p>1. Payment terms as specified above must be strictly followed.</p>
            <p>2. Any changes to the scope of work will be charged separately.</p>
            <p>3. The client is responsible for providing necessary access and cooperation.</p>
            <p>4. This contract is valid for the specified project duration only.</p>
        @endif
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line">Client Signature</div>
            <div style="margin-top: 10px;">{{ $quotation->contact_person_1 }}</div>
            <div>{{ $quotation->company_name }}</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">Company Representative</div>
            <div style="margin-top: 10px;">{{ $quotation->prepared_by ?? 'Authorized Signatory' }}</div>
            <div>{{ $quotation->footer_company_name ?? 'Company Name' }}</div>
        </div>
    </div>

    <div style="margin-top: 30px; text-align: center; font-size: 10px; color: #666;">
        Contract generated on {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>