@php
$company_name = 'CHITRI ENLARGE SOFT IT HUB PVT. LTD.';
$company_address = 'Shop No. 28, Shagun Building, NH-4, Old Mumbai-Pune Highway, Dehu Road, Kiwale, Dist. Pune - 412101';
$company_phone = '+91 72763 23999';
$company_email = 'info@ceihpl.com';
$company_website = 'www.ceihpl.com';
$background_url = asset('letters/back.png');

// Format the letter type for display
$letter_type = ucfirst($letter->type);
if ($letter->type === 'agreement') {
    $letter_type = 'Agreement';
} elseif ($letter->type === 'confidentiality') {
    $letter_type = 'Confidentiality';
} elseif ($letter->type === 'impartiality') {
    $letter_type = 'Impartiality';
}

$employee = $letter->employee;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $letter_type }} Letter - {{ $employee->name }}</title>
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
    .letter-content { position:relative; z-index:1; }
    .letter-content { 
      width:100%; 
      max-width:800px; 
      margin: 40px auto 0; 
      padding: 80px 80px 60px; 
      box-sizing:border-box;
      display: flex;
      flex-direction: column;
      justify-content: center;
      min-height: 100%;
    }
    .letter-header {
      text-align: center;
      margin-bottom: 30px;
    }
    .company-name {
      font-size: 22px;
      font-weight: bold;
      color: #2c3e50;
      margin-bottom: 5px;
    }
    .company-address {
      font-size: 14px;
      color: #555;
      margin-bottom: 20px;
    }
    .letter-meta { 
      display:flex; 
      justify-content:space-between; 
      font-size:15px; 
      color:#222; 
      margin-bottom: 20px;
    }
    .recipient {
      margin-bottom: 20px;
    }
    .subject { 
      font-size:16px; 
      font-weight:bold; 
      color:#2c3e50; 
      margin-bottom: 20px;
      text-align: center;
      text-decoration: underline;
    }
    .body { 
      font-size:14px; 
      color:#333; 
      line-height:1.7; 
      margin-bottom: 30px;
      text-align: justify;
    }
    .body p {
      margin-bottom: 15px;
    }
    .signature { 
      margin-top: 40px;
      text-align: right;
    }
    .signature .name {
      font-weight: bold;
      margin-top: 40px;
    }
    .signature .designation {
      font-style: italic;
      color: #555;
    }
    .signature .company {
      font-weight: bold;
      color: #2c3e50;
    }
    .signature-line {
      border-top: 1px solid #333;
      width: 200px;
      margin: 40px 0 5px auto;
    }
    @media print {
      .print-btn { display:none; }
      body { background:none; }
      .letter-container { box-shadow:none; border:none; }
    }
    @media screen {
      body, html { 
        background:#f5f5f5; 
        min-height:100vh; 
        min-width:100vw; 
        margin:0; 
        padding:0; 
      }
      .letter-container { 
        width:794px; 
        min-width:794px; 
        max-width:794px; 
        min-height:1123px; 
        height: 100%;
        margin:40px auto; 
        box-shadow:0 4px 24px rgba(44,108,164,0.10); 
        position:relative; 
        overflow:hidden; 
        border:1.5px solid #dbe6f7;
        display: flex;
        align-items: center;
        justify-content: center;
      }
    }
    .print-btn {
      position: fixed; 
      right: 24px; 
      top: 20px; 
      z-index: 9999;
      background: #1f2937; 
      color: #fff; 
      border: 0; 
      padding: 10px 14px; 
      border-radius: 6px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15); 
      cursor: pointer; 
      font-weight: 700;
    }
    .print-btn:hover { 
      background: #111827; 
    }
    .letter-date {
      margin-bottom: 30px;
      text-align: right;
    }
    .reference-number {
      margin-bottom: 30px;
    }
  </style>
</head>
<body>
  <button class="print-btn" onclick="window.print()">Print Letter</button>
  <div class="letter-container">
    <div class="bg-cover"><img src="{{ $background_url }}" alt="" /></div>
    <div class="letter-content">
      <div class="letter-date">
        Date: {{ $letter->issue_date->format('F d, Y') }}
      </div>
      
      <div class="reference-number">
        <strong>Ref. No.:</strong> {{ $letter->reference_number }}
      </div>
      
      <div class="recipient">
        <div><strong>To,</strong></div>
        <div>Mr./Ms. {{ $employee->name }}</div>
        <div>Employee ID: {{ $employee->employee_id }}</div>
        <div>Designation: {{ $employee->designation->name ?? 'N/A' }}</div>
        @if(!empty($employee->current_address))
          <div>Address: {{ $employee->current_address }}</div>
        @endif
      </div>
      
      <div class="subject">
        Subject: {{ $letter->title }}
      </div>
      
      <div class="body">
        {!! $letter->content !!}
      </div>
      
      <div class="signature">
        <div class="signature-line"></div>
        <div class="name">For {{ $company_name }}</div>
        <div class="designation">Authorized Signatory</div>
      </div>
    </div>
  </div>
  
  <script>
    // Auto-print when the page loads (can be toggled if needed)
    // window.onload = function() {
    //   setTimeout(function() {
    //     window.print();
    //   }, 1000);
    // };
  </script>
</body>
</html>
