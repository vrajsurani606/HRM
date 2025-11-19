    @php
    $company_name = isset($company_name) ? $company_name : 'CHITRI ENLARGE SOFT IT HUB PVT. LTD.';
    $company_address = '';
    $company_phone = '+91 72763 23999';
    $company_email = 'info@ceihpl.com';
    $company_website = 'www.ceihpl.com';
    $background_url = isset($background_url) && $background_url ? $background_url : asset('letters/back.png');
    @endphp
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $letter->type }} Letter - {{ $employee->name }}</title>
    <style>
        body, html { margin:0 !important; padding:0 !important; font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif !important; }
        @page { margin: 0; size: A4 portrait; }
        .letter-container {
        width: 100vw; min-width: 100vw; height: 100vh; margin: 0;
        position: relative; overflow: hidden; border: none; page-break-inside: avoid;
        display: flex; flex-direction: column; justify-content: flex-start;
        }
        .letter-container .bg-cover {
        position:absolute; inset:0; width:100%; height:100%; z-index:0;
        }
        .letter-container .bg-cover img { width:100%; height:100%; object-fit:cover; display:block; }
        .letter-content { position:relative; z-index:1; width:100%; max-width:700px; margin:0 auto; padding:40px 50px 20px 50px; border-radius:8px; box-sizing:border-box; }
        .letter-meta, .recipient, .subject, .body, .signature { margin-bottom:20px; }
        .letter-meta { display:flex; justify-content:space-between; font-size:14px; color:#222; font-weight:500; }
        .recipient { font-size:14px; color:#222; line-height:1.5; }
        .subject { font-size:16px; font-weight:700; color:#222; text-align:center; margin:20px 0; }
        .body { font-size:14px; color:#222; line-height:1.6; text-align:justify; }
        .body p { margin-bottom:12px; }
        .body .company { color:#456DB5; font-weight:700; }
        .body .highlight { font-weight:700; }
        .signature { font-size:14px; color:#222; text-align:left; margin-top:30px; }
        .signature .name { font-weight:700; font-size:14px; }
        .signature .company { font-size:14px; color:#456DB5; font-weight:700; }
        .signature .sign { margin:10px 0; }
        .signature .sign img { height:50px; width:auto; display:block; object-fit:contain; }
        @media print {
        .print-btn { display:none; }
        body { background:none; }
        .letter-container { box-shadow:none; border:none; width: 210mm; height: 297mm; padding: 0; margin: 0; }
        .letter-content { padding: 15mm 20mm 10mm 20mm !important; margin-top: 40mm !important; font-size: 11px !important; }
        .letter-meta { font-size: 11px !important; margin-bottom: 8px !important; }
        .recipient { font-size: 11px !important; margin-bottom: 8px !important; }
        .subject { font-size: 13px !important; margin: 8px 0 !important; }
        .body { font-size: 11px !important; line-height: 1.4 !important; margin-bottom: 8px !important; }
        .body p { margin-bottom: 4px !important; }
        .signature { font-size: 11px !important; margin-top: 10mm !important; }
        .signature .sign img { height: 30px !important; }
        .note-rectangle { padding: 8px 12px !important; margin: 8px 0 !important; font-size: 10px !important; }
        }
        @media screen {
        body, html { background:#f5f5f5; min-height:100vh; min-width:100vw; margin:0; padding:0; }
        .letter-container { width:794px; min-width:794px; max-width:794px; height:1123px; min-height:1123px; max-height:1123px; margin:40px auto; box-shadow:0 4px 24px rgba(44,108,164,0.10); position:relative; overflow:hidden; border:1.5px solid #dbe6f7; display:block; }
        .letter-content.first-page { max-height:none !important; height:auto !important; overflow:visible !important; }
        }
        .letter-content.first-page { padding:0 36px 4px 36px !important; margin-top:230px !important; font-size:13.2px !important; }
        .print-btn {
        position: fixed; right: 24px; top: 20px; z-index: 9999;
        background: #1f2937; color: #fff; border: 0; padding: 10px 14px; border-radius: 6px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15); cursor: pointer; font-weight: 700;
        }
        .print-btn:hover { background: #111827; }
        @media print {
        .print-btn { display: none; }
        .letter-container .bg-cover img { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
        .letter-content.first-page .letter-meta, .letter-content.first-page .recipient, .letter-content.first-page .subject, .letter-content.first-page .body, .letter-content.first-page .signature { margin-bottom:4px !important; }
        .letter-content.first-page .body p, .letter-content.first-page .body ol, .letter-content.first-page .body ul { margin-bottom:2px !important; }
        .letter-content.first-page .signature { margin-top:6px !important; }
    .font-weight-bold { font-weight: bold; font-size: 16px; }
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
        <div class="letter-content first-page">
         
            @switch($letter->type)
                @case('joining')
                    @include('hr.employees.letters.templates.joining')
                    @break

                @case('confidentiality')
                    @include('hr.employees.letters.templates.confidentiality')
                    @break

                @case('impartiality')
                    @include('hr.employees.letters.templates.impartiality')
                    @break

                @case('experience')
                    @include('hr.employees.letters.templates.experience')
                    @break

                @case('agreement')
                    @include('hr.employees.letters.templates.agreement')
                    @break

                @case('warning')
                    @include('hr.employees.letters.templates.warning')
                    @break

                @case('termination')
                    @include('hr.employees.letters.templates.termination')
                    @break
                @case('promotion')
                    @include('hr.employees.letters.templates.promotion')
                    @break
                @case('increment')
                    @include('hr.employees.letters.templates.increment')
                @break
                @case('internship_offer')
                    @include('hr.employees.letters.templates.internship_offer')
                @break
                @case('internship_letter')
                    @include('hr.employees.letters.templates.internship_letter')
                @break
                @case('resignation')
                    @include('hr.employees.letters.templates.resignation')
                @break
                
                @case('other')
                    @include('hr.employees.letters.templates.other')
                @break

                @default
                    <div class="letter-meta">
                        <div><b>Ref No.:</b> {{ $letter->reference_number ?? 'REF001' }}</div>
                        <div><b>Date:</b> {{ date('d-m-Y') }}</div>
                    </div>
                    <div class="recipient">
                        <div><b>To,</b></div>
                        <div>{{ $employee->name }}</div>
                        @if($employee->address)
                        <div>Address :- {{ $employee->address }}</div>
                        @endif
                    </div>
                    <div class="subject">{{ $letter->title ?? 'Subject: Employee Letter' }}</div>
                    <div class="body">
                        <p>Dear <b>{{ $employee->name }}</b>,</p>
                        <p style="font-size:16px; font-weight:700;">Letter type not supported.</p>
                        
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
                        <div><b>Sincerely,</b></div>
                        <div class="sign">
                        <img src="{{ asset('letters/signature.png') }}" alt="Signature">
                        </div>
                        <div class="name">{{ $signatory_name ?? 'Mr. Chintan Kachhadiya' }}</div>
                        <div class="company">{{ $company_name }}</div>
                    </div>
            @endswitch
        </div>
    </div>
    </body>
    </html>