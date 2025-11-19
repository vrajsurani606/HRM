@php
$company_name = 'CHITRI ENLARGE SOFT IT HUB PVT. LTD.';
$company_address = 'Shop No. 28, Shagun Building, NH-4, Old Mumbai-Pune Highway, Dehu Road, Kiwale, Dist. Pune - 412101';
$background_url = asset('letters/back.png');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotion Letter - {{ $letter->employee->name }}</title>
    <style>
        body, html { margin:0 !important; padding:0 !important; font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif !important; }
        @page { margin: 0; }
        .letter-container {
            width: 100vw; min-width: 100vw; height: 100vh; margin: 0;
            position: relative; overflow: hidden; border: none; page-break-inside: avoid;
            display: flex; flex-direction: column; justify-content: flex-start;
        }
        .letter-container .bg-cover {
            position:absolute; inset:0; width:100%; height:100%; z-index:0;
        }
        .letter-container .bg-cover img { width:100%; height:100%; object-fit:cover; display:block; }
        .letter-content { position:relative; z-index:1; width:100%; max-width:800px; margin:0 auto; margin-top:150px; padding:40px 30px 20px 30px; border-radius:8px; box-sizing:border-box; }
        .letter-meta, .recipient, .subject, .body, .signature { margin-bottom:16px; }
        .letter-meta { display:flex; justify-content:space-between; font-size:16px; color:#222; font-weight:500; }
        .subject { font-size:17px; font-weight:700; color:#222; text-align:center; }
        .body { font-size:13.2px; color:#222; line-height:1.7; }
        .body .company { color:#456DB5; font-weight:700; }
        .body .highlight { font-weight:700; }
        .signature { font-size:16px; color:#222; text-align:left; }
        .signature .name { font-weight:700; font-size:16px; }
        .signature .company { font-size:16px; color:#456DB5; font-weight:700; }
        .signature .sign { margin:6px 0 6px 0; }
        .signature .sign img { height:62px; width:auto; display:block; object-fit:contain; }
        @media print {
            .print-btn { display:none; }
            body { background:none; }
            .letter-container { box-shadow:none; border:none; }
        }
        @media screen {
            body, html { background:#f5f5f5; min-height:100vh; min-width:100vw; margin:0; padding:0; }
            .letter-container { width:794px; min-width:794px; max-width:794px; height:1123px; min-height:1123px; max-height:1123px; margin:40px auto; box-shadow:0 4px 24px rgba(44,108,164,0.10); position:relative; overflow:hidden; border:1.5px solid #dbe6f7; display:block; }
        }
        .print-btn {
            position: fixed; right: 24px; top: 20px; z-index: 9999;
            background: #1f2937; color: #fff; border: 0; padding: 10px 14px; border-radius: 6px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15); cursor: pointer; font-weight: 700;
        }
        .print-btn:hover { background: #111827; }
        .note-rectangle {
            background: #fffde7;
            border-left: 4px solid #456DB5;
            padding: 15px 20px;
            margin: 20px 0;
            font-size: 14px;
            border-radius: 4px;
        }
        .note-rectangle b { color: #333; }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">Print</button>
    <div class="letter-container">
        <div class="bg-cover"><img src="{{ $background_url }}" alt="" /></div>
        <div class="letter-content">
            <div class="letter-meta">
                <div><b>Ref No.:</b> {{ $letter->reference_number }}</div>
                <div><b>Date:</b> {{ $letter->issue_date->format('d-m-Y') }}</div>
            </div>
            <div class="recipient">
                <div><b>To,</b></div>
                <div>Mr. / Mrs. {{ $letter->employee->name }}</div>
                <div>Employee ID: {{ $letter->employee->employee_id }}</div>
            </div>
            <div class="subject">Subject: {{ $letter->title }}</div>
            <div class="body">
                <p>Dear <b>{{ $letter->employee->name }}</b>,</p>
                <p>We are pleased to inform you that based on your excellent performance and dedication, you have been promoted in <span class="company">{{ $company_name }}</span>.</p>
                
                <p><b>Your promotion details are as follows:</b></p>
                <ul>
                    <li><b>Current Designation:</b> {{ $letter->employee->designation ?? 'Current Position' }}</li>
                    <li><b>New Designation:</b> {{ $letter->content['new_designation'] ?? 'New Position' }}</li>
                    <li><b>Department:</b> {{ $letter->content['department'] ?? $letter->employee->department ?? 'As assigned' }}</li>
                    <li><b>Effective Date:</b> {{ isset($letter->content['effective_date']) ? \Carbon\Carbon::parse($letter->content['effective_date'])->format('d-m-Y') : 'As mentioned' }}</li>
                    <li><b>New Salary:</b> {{ $letter->content['new_salary'] ?? 'As per revised structure' }}</li>
                    <li><b>Reporting Manager:</b> {{ $letter->content['reporting_manager'] ?? 'As assigned' }}</li>
                </ul>

                <p>This promotion is in recognition of your hard work, commitment, and valuable contributions to the organization. We are confident that you will continue to excel in your new role and contribute to the company's growth.</p>

                <p>Please report to the HR department to complete the necessary formalities related to your promotion.</p>

                <p>Congratulations on your well-deserved promotion!</p>
                
                @php
                    $cleanNotes = trim(strip_tags($letter->notes ?? ''));
                @endphp
                
                @if(!empty($cleanNotes))
                    <div class="note-rectangle">
                        <b>Note: {!! strip_tags($letter->notes) !!}</b>
                    </div>
                @endif
            </div>
            <div class="signature">
                <div><b>Best Regards,</b></div>
                <div class="sign">
                    <img src="{{ asset('letters/signature.png') }}" alt="Signature">
                </div>
                <div class="name">Mr. Chintan Kachhadiya</div>
                <div class="company">{{ $company_name }}</div>
            </div>
        </div>
    </div>
</body>
</html>