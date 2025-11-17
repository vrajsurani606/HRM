<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $letter->title }} - {{ $employee->name }}</title>
    <style>
        @page {
            margin: 1in;
            size: A4;
        }
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .letterhead {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        .company-name {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .company-details {
            font-size: 10pt;
            margin-bottom: 3px;
        }
        .letter-header {
            margin: 30px 0;
        }
        .ref-date {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .letter-title {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            margin: 20px 0;
            text-decoration: underline;
        }
        .letter-content {
            text-align: justify;
            margin: 20px 0;
        }
        .signature-section {
            margin-top: 50px;
        }
        .signature-line {
            margin-top: 60px;
            text-align: right;
        }
        .print-only {
            display: block;
        }
        @media screen {
            .print-only {
                display: none;
            }
            body {
                max-width: 8.5in;
                margin: 0 auto;
                padding: 20px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
        }
    </style>
</head>
<body>
    <div class="letterhead">
        <div class="company-name">CHITRI ENLARGE SOFT IT HUB PVT. LTD.</div>
        <div class="company-details">Address Line 1, City, State - PIN Code</div>
        <div class="company-details">Phone: +91-XXXXXXXXXX | Email: info@company.com</div>
        <div class="company-details">Website: www.company.com</div>
    </div>

    <div class="letter-header">
        <div class="ref-date">
            <div><strong>Ref No:</strong> {{ $letter->reference_number }}</div>
            <div><strong>Date:</strong> {{ $letter->issue_date->format('d/m/Y') }}</div>
        </div>
        
        <div style="margin-bottom: 20px;">
            <strong>To,</strong><br>
            {{ $employee->name }}<br>
            Employee ID: {{ $employee->employee_id }}<br>
            @if($employee->email)
            Email: {{ $employee->email }}<br>
            @endif
        </div>
    </div>

    <div class="letter-title">{{ $letter->title }}</div>

    <div class="letter-content">
        {!! $letter->content !!}
    </div>

    @if($letter->notes)
    <div style="margin-top: 30px;">
        <strong>Additional Notes:</strong><br>
        {!! $letter->notes !!}
    </div>
    @endif

    <div class="signature-section">
        <div class="signature-line">
            <div>_________________________</div>
            <div><strong>Authorized Signatory</strong></div>
            <div>{{ config('app.name', 'CHITRI ENLARGE SOFT IT HUB PVT. LTD.') }}</div>
        </div>
    </div>

    <script>
        // Auto-print when page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>