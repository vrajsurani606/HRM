@php
$company_name = isset($company_name) ? $company_name : 'CHITRI ENLARGE SOFT IT HUB PVT. LTD.';
$company_address = 'Shop No. 28, Shagun Building, NH-4, Old Mumbai-Pune Highway, Dehu Road, Kiwale, Dist. Pune - 412101';
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
  <title>Joining Letter - {{ $letter->employee->name }}</title>

  <style>
    body, html { margin:0 !important; padding:0 !important; font-family: 'Palatino Linotype', serif !important; }
    @page { margin: 0; }

    .offer-container {
      width: 100vw; height: 100vh; min-width:100vw;
      margin: 0; overflow: hidden; border: none;
      position: relative;
      display: flex; justify-content: flex-start;
    }

    .bg-cover { position:absolute; inset:0; width:100%; height:100%; z-index:0; }
    .bg-cover img { width:100%; height:100%; object-fit:cover; display:block; }

    .letter-content {
      position:relative; z-index:1;
      width:100%; max-width:800px;
      margin:150px auto 0 auto;
      padding:40px 30px 20px 30px;
      box-sizing:border-box;
    }

    .letter-meta, .recipient, .subject, .body, .signature { margin-bottom:16px; }

    .body { font-size:13.5px; color:#222; line-height:1.7; }
    .company { color:#456DB5; font-weight:700; }

    .signature .sign img { height:62px; object-fit:contain; }

    /* PRINT MODE */
    @media print {
      .print-btn { display:none; }
      .offer-container { box-shadow:none; border:none; }
      .letter-content { page-break-after:always; }
      .bg-cover img { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }

    /* SCREEN MODE */
    @media screen {
      body, html { background:#f5f5f5; }
      .offer-container {
        width:794px; height:1123px;
        box-shadow:0 4px 24px rgba(44,108,164,0.10);
        border:1.5px solid #dbe6f7;
        margin:40px auto;
      }
    }

    .print-btn {
      position: fixed; right: 20px; top: 20px; z-index: 9999;
      background: #1f2937; color: #fff; font-weight:700;
      padding: 10px 14px; border-radius: 6px; border: none;
      cursor: pointer; box-shadow:0 4px 10px rgba(0,0,0,0.15);
    }
    .print-btn:hover { background:#111827; }
  </style>
</head>

<body>

<button class="print-btn" onclick="window.print()">Print</button>

<div class="offer-container">
  <div class="bg-cover">
    <img src="{{ $background_url }}" alt="">
  </div>

  <div class="letter-content">

      <!-- LETTER START -->
      <div class="body">

        <p>Dear <b>{{ $letter->employee->name }}</b>,</p>

        <p>We are pleased to welcome you to <span class="company">{{ $company_name }}</span>. 
        This letter serves as a confirmation of your joining our organization.</p>

        <p><b>Your Employment Details:</b></p>
        <ul style="list-style: disc; margin: 6px 0 0 20px;">
            <li><b>Employee ID:</b> {{ $letter->employee->employee_id }}</li>
            <li><b>Designation:</b> {{ $letter->employee->designation ?? 'As per offer letter' }}</li>
            <li><b>Department:</b> {{ $letter->employee->department ?? 'As assigned' }}</li>
            <li><b>Date of Joining:</b> 
                {{ $letter->employee->date_of_joining ? $letter->employee->date_of_joining->format('d-m-Y') : 'As per offer letter' }}
            </li>
            <li><b>Reporting Manager:</b> {{ $letter->employee->reporting_manager ?? 'As assigned' }}</li>
        </ul>

        <p>Please ensure you have completed all required documentation and formalities.</p>

        <p>We look forward to a long and mutually beneficial association with you.  
        Welcome to the <span class="company">{{ $company_name }}</span> family!</p>

      </div>

      <!-- SIGNATURE -->
      <div class="signature">
          <div><b>Sincerely,</b></div>
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
