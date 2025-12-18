@php
$company_name = isset($company_name) ? $company_name : 'CHITRI ENLARGE SOFT IT HUB PVT. LTD.';
$company_address = 'Shop No. 28, Shagun Building, NH-4, Old Mumbai-Pune Highway, Dehu Road, Kiwale, Dist. Pune - 412101'; // You can update this
$company_phone = '+91 72763 23999';
$company_email = 'info@ceihpl.com';
$company_website = 'www.ceihpl.com';
// Default background for both print and screen
$background_url = isset($background_url) && $background_url ? $background_url : asset('letters/back.png');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Offer Letter - {{ $lead->person_name }}</title>
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
    
    *:not(.fa):not(.fas):not(.far):not(.fab):not(.fal):not(.fad):not([class^="fa-"]):not([class*=" fa-"]) {
        font-family: 'Poppins', sans-serif !important;
    }
    
    /* Ensure Font Awesome icons use their own font */
    .fa, .fas, .far, .fab, .fal, .fad, [class^="fa-"], [class*=" fa-"] {
        font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands" !important;
    }
    
    body, html { margin:0 !important; padding:0 !important; font-family: 'Poppins', sans-serif !important; font-weight: 400; }
    
    b, strong {
        font-family: 'Poppins', sans-serif !important;
        font-weight: 700 !important;
    }
    @page { margin: 0; }
    .offer-container {
      width: 100vw; min-width: 100vw; height: 100vh; margin: 0;
      position: relative; overflow: hidden; border: none; page-break-inside: avoid;
      display: flex; flex-direction: column; justify-content: flex-start;
    }
    .offer-container .bg-cover {
      position:absolute; inset:0; width:100%; height:100%; z-index:0;
    }
    .offer-container .bg-cover img { width:100%; height:100%; object-fit:cover; display:block; }
    .letter-content { position:relative; z-index:1; }
    .letter-content { width:100%; max-width:800px; margin:0 auto; margin-top:220px; padding:40px 30px 20px 30px; border-radius:8px; box-sizing:border-box; }
    .letter-meta, .recipient, .subject, .body, .signature { margin-bottom:16px; }
    .letter-meta { display:flex; justify-content:space-between; font-size:13.2px; color:#222; font-weight:500; }
    .recipient { font-size:13.2px; color:#222; }
    .subject { font-size:13.2px; font-weight:700; color:#222; text-align:center; }
    .body { font-size:13.2px; color:#222; line-height:1.7; }
    .body .company { color:#456DB5; font-weight:700; }
    .body .highlight { font-weight:700; }
    .signature { font-size:13.2px; color:#222; text-align:left; }
    .signature .name { font-weight:700; font-size:13.2px; }
    .signature .company { font-size:13.2px; color:#456DB5; font-weight:700; }
    .signature .sign { margin:6px 0 6px 0; }
    .signature .sign img { height:62px; width:auto; display:block; object-fit:contain; }
    @media print {
      @page {
        size: A4 portrait;
        margin: 0;
      }
      .print-btn, .back-btn, .btn-container { display:none !important; }
      body { background:none; }
      .offer-container { 
        box-shadow:none; 
        border:none;
        width: 210mm;
        height: 297mm;
        page-break-after: always;
      }
      .offer-container:last-child {
        page-break-after: auto;
      }
      .letter-content { 
        margin-top: 220px !important;
        padding: 40px 30px 20px 30px !important;
      }
      .letter-content.first-page { 
        page-break-after:always; 
        overflow:visible !important; 
        max-height:none !important; 
        height:auto !important;
        margin-top: 220px !important;
        padding: 0 36px 4px 36px !important;
      }
      .break-section { page-break-before: always; break-inside: avoid; }
      .bullets-avoid-break { break-inside: avoid; page-break-inside: avoid; }
      .offer-container .bg-cover img { 
        -webkit-print-color-adjust: exact; 
        print-color-adjust: exact; 
      }
    }
    @media screen {
      body, html { background:#f5f5f5; min-height:100vh; min-width:100vw; margin:0; padding:0; }
      .offer-container { width:794px; min-width:794px; max-width:794px; height:1123px; min-height:1123px; max-height:1123px; margin:40px auto; box-shadow:0 4px 24px rgba(44,108,164,0.10); position:relative; overflow:hidden; border:1.5px solid #dbe6f7; display:block; }
      .letter-content.first-page { max-height:none !important; height:auto !important; overflow:visible !important; }
      .break-section { margin-top:32px; }
    }
    .doc-table { width:100%; border-collapse:separate; border-spacing:0; font-size:14px; margin-bottom:18px; overflow:hidden; box-shadow:0 1px 6px rgba(44,108,164,0.06); background:transparent; }
    .doc-table th, .doc-table td { border:1.5px solid #b3b3b3; padding:10px 14px; background:transparent; }
    .doc-table th { font-weight:700; text-align:center; font-size:15px; background:transparent; padding:10px 0; }
    .doc-table .doc-table-header { border:2px solid #b3b3b3; font-weight:700; text-align:center; font-size:15px; background:rgba(69,108,181,0.18); padding:10px 0; }
    .letter-content.first-page { padding:0 36px 4px 36px !important; margin-top:220px !important; font-size:13.2px !important; }
    .print-btn {
      background: #1f2937; color: #fff; border: 0; padding: 10px 14px; border-radius: 6px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15); cursor: pointer; font-weight: 700;
    }
    .print-btn:hover { background: #111827; }
    .btn-container {
      position: fixed; right: 24px; top: 20px; z-index: 9999;
      display: flex; gap: 10px;
    }
    .back-btn {
      background: #6b7280; color: #fff; border: 0; padding: 10px 14px; border-radius: 6px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15); cursor: pointer; font-weight: 700;
    }
    .back-btn:hover { background: #4b5563; }
    .letter-content.first-page .letter-meta, .letter-content.first-page .recipient, .letter-content.first-page .subject, .letter-content.first-page .body, .letter-content.first-page .signature { margin-bottom:4px !important; }
    .letter-content.first-page .body p, .letter-content.first-page .body ol, .letter-content.first-page .body ul { margin-bottom:2px !important; }
    .letter-content.first-page .signature { margin-top:6px !important; }
    
    /* Font Awesome icons - must be at the end to override other font-family rules */
    .fa, .fas, .far, .fab, .fal, .fad,
    i[class^="fa-"], i[class*=" fa-"] {
        font-family: "Font Awesome 6 Free" !important;
        font-weight: 900;
    }
    .fab {
        font-family: "Font Awesome 6 Brands" !important;
    }
  </style>
</head>
<body>
  <div class="btn-container">
    <button class="back-btn" onclick="goBack()">
      <i class="fas fa-arrow-left" style="margin-right: 5px;"></i> Back
    </button>
    <button class="print-btn" onclick="window.print()">
      <i class="fas fa-print" style="margin-right: 5px;"></i> Print
    </button>
  </div>
  <script>
  function goBack() {
    // Check if there's a specific redirect URL in the query string
    const urlParams = new URLSearchParams(window.location.search);
    const redirectTo = urlParams.get('redirect_to');
    
    if (redirectTo) {
      window.location.href = redirectTo;
    } else {
      // Default: go to hiring leads index (don't rely on history.back as it may not work after form submissions)
      window.location.href = "{{ route('hiring.index') }}";
    }
  }
  </script>
  <div class="offer-container">
    <div class="bg-cover"><img src="{{ $background_url }}" alt="" /></div>
    <div class="letter-content first-page">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
        <div style="font-size: 13.2px;"><b>Ref No.:</b> {{ $offer->reference_number ?? $lead->unique_code ?? 'N/A' }}</div>
        <div style="font-size: 13.2px;"><b>Date:</b> {{ optional($offer->issue_date)->format('d-m-Y') ?? now()->format('d-m-Y') }}</div>
      </div>
      <div class="recipient" style="margin-bottom: 12px;">
        <div><b>To,</b></div>
        <div>{{ ($lead->gender == 'Female' || $lead->gender == 'female') ? 'Ms.' : 'Mr.' }} {{ $lead->person_name ?? $lead->name }}</div>
        <div>{{ $lead->position ?? $lead->designation ?? 'Candidate' }}</div>
        @if(!empty($lead->address))
        <div>{{ $lead->address }}</div>
        @endif
      </div>
      <div class="subject">Subject: Job Offer for {{ $lead->position ?? $lead->designation ?? 'N/A' }} Position</div>
      <div class="body">
        <p>Dear <b>{{ $lead->person_name ?? $lead->name }}</b>,</p>
        <p><b>Congratulations!</b> We are pleased to inform you that you have been selected to join <span class="company">{{ $company_name }}</span><br> as a <span class="highlight">{{ $lead->position ?? $lead->designation ?? 'N/A' }}</span>. We are delighted to extend the following job offer:</p>
        <div style="margin-top:8px;">
          <div style="margin-bottom:6px;"><b>1. Position & Compensation</b></div>
          <div style="margin-left:18px;">
            <div style="margin-bottom:2px;">• <b>Designation:</b> {{ $lead->position ?? $lead->designation ?? 'N/A' }}</div>
            <div style="margin-bottom:2px;">• <b>Monthly Salary:</b> ₹ {{ $offer->monthly_salary ? number_format($offer->monthly_salary, 2) : '__________' }}</div>
            <div style="margin-bottom:2px;">• <b>Annual Cost to Company (CTC):</b> ₹ {{ $offer->annual_ctc ? number_format($offer->annual_ctc, 2) : '__________' }}</div>
            <div style="margin-bottom:2px;">• <b>Reporting Manager:</b> {{ $offer->reporting_manager ?? '__________' }}</div>
            <div style="margin-bottom:2px;">• <b>Working Hours:</b> {{ $offer->working_hours ?? '9:30 AM to 6:30 PM' }}</div>
          </div>
          <div style="margin-top:8px; margin-bottom:6px;"><b>2. Probation Period</b></div>
          @if(!empty($probation_lines))
            <div style="margin-left:18px;">
              @foreach($probation_lines as $ln)
                <div style="margin-bottom:2px;">• {{ $ln }}</div>
              @endforeach
            </div>
          @endif
          <div style="margin-top:8px; margin-bottom:6px;"><b>3. Salary & Increment Structure</b></div>
          @if(!empty($salary_lines))
            <div style="margin-left:18px;">
              @foreach($salary_lines as $ln)
                <div style="margin-bottom:2px;">• {{ $ln }}</div>
              @endforeach
            </div>
          @endif
        </div>
        @if($break_after)
          </div>
          </div>
          </div>
          <div style="page-break-before: always;"></div>
          <div class="offer-container">
            <div class="bg-cover"><img src="{{ $background_url }}" alt="" /></div>
            <div class="letter-content">
        @endif
        <p style="margin-top:-0px;">
          Your joining date is
          <b>{{ data_get($joining, 'date_of_joining', '[Date of Joining]') }}</b>
          at 9:30 AM. Please report to  <b>{{ data_get($joining, 'reporting_person', 'Reporting person name') }}</b> 
          for documentation and orientation. If this date is not feasible, kindly inform us immediately.
        </p>
        <p style="margin-top:5px;">We are confident that you will make a valuable contribution to the success of <span class="company">{{ $company_name }}</span> and look forward to working with you.</p>
      </div>
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
  <div style="page-break-before: always;"></div>
  <div class="offer-container">
    <div class="bg-cover"><img src="{{ $background_url }}" alt="" /></div>
    <div class="letter-content">
      <div style="font-size:15px; margin-bottom:18px;">Please submit Résumé (<b>signed by recruiter</b>); Application form(<span style="color:#0056b3;font-weight:700;">Blue Form</span>); Expectation Check List &amp; BGC FORM along with photo copies (no original) of below documents</div>
      <table class="doc-table">
        <tr><td colspan="2" class="doc-table-header">MANDATORY DOCUMENT</td></tr>
        <tr><td style="width:3%; text-align:center;">1.</td><td>Pan Card / Pan Card application number</td></tr>
        <tr><td style="text-align:center;">2.</td><td>Proof of Citizenship &amp; Age (Birth Certificate / Passport / School Leaving Certificate)</td></tr>
        <tr><td style="text-align:center;">3.</td><td>2 Passport size photo of Candidate</td></tr>
      </table>
      <table class="doc-table">
        <tr><td colspan="2" class="doc-table-header">All documents for employment to be submitted</td></tr>
        <tr>
          <td style="width:18%; vertical-align:center; font-weight:700; text-align:center;">EMPLOYMENT</td>
          <td>
            <div style="font-weight:700; text-decoration:underline; margin-bottom:4px;">FOR CURRENT EMPLOYMENT:</div>
            <ol style="margin:0 0 8px 18px; padding:0;">
              <li style="margin-bottom:2px;">APPOINTMENT LETTER OR OFFER LETTER</li>
              <li style="margin-bottom:2px;">RELIEVING LETTER WITH F&amp;F STATEMENT OR SERVICE CERTIFICATE OR EXPERIENCE LETTER (Share Declaration if currently not available)</li>
              <li style="margin-bottom:2px;">RESIGNATION ACCEPTANCE LETTER</li>
              <li style="margin-bottom:2px;">Recruiter to sign the declaration with EMPLOYEE CODE if both relieving letter &amp; resignation letter is currently not available</li>
              <li style="margin-bottom:2px;">SALARY SLIPS (LAST 3 MONTHS) OR SALARY CERTIFICATE</li>
              <li>BANK STATEMENT OR FORM 16</li>
            </ol>
            <div style="font-weight:700; text-decoration:underline; margin-top:10px; margin-bottom:4px;">ALL PAST EMPLOYMENT POST HSC/12<sup>th</sup></div>
            <ol style="margin:0 0 0 18px; padding:0;">
              <li style="margin-bottom:2px;">RELIEVING LETTER OR SERVICE CERTIFICATE OR EXPERIENCE LETTER</li>
              <li style="margin-bottom:2px;">SALARY SLIPS (LAST 3 MONTHS) OR SALARY CERTIFICATE</li>
              <li>BANK STATEMENT OR FORM 16</li>
            </ol>
          </td>
        </tr>
      </table>
      <table class="doc-table">
        <tr><td colspan="2" class="doc-table-header">ALL DOCUMENTS FOR EDUCATION (HIGHEST QUALIFICATION) TO BE SUBMITTED</td></tr>
        <tr>
          <td style="width:18%; vertical-align:center; font-weight:700; text-align:center;">EDUCATION</td>
          <td>
            <ol style="margin:0 0 0 18px; padding:0;">
              <li style="margin-bottom:2px;">PASSING CERTIFICATE FOR GRADUATION (If undergraduate then till 12<sup>th</sup>)</li>
              <li>MARK SHEET FOR SSC , HSC &amp; GRADUATION (If undergraduate then till 12<sup>th</sup>)</li>
            </ol>
          </td>
        </tr>
      </table>
    </div>
  </div>
  <div style="page-break-before: always;"></div>
  <div class="offer-container">
    <div class="bg-cover"><img src="{{ $background_url }}" alt="" /></div>
    <div class="letter-content">
      <table class="doc-table">
        <tr>
          <td colspan="2" class="doc-table-header">ANY ONE (1) DOCUMENT FOR BOTH PRESENT &amp; PERMANENT ADDRESS TO BE SUBMITTED</td>
        </tr>
        <tr>
          <td style="width:22%; vertical-align:top; font-weight:700; text-align:center;">ADDRESS<br>(PRESENT<br>&amp;<br>PERMANENT)</td>
          <td>
            <ol style="margin:0 0 0 18px; padding:0;">
              <li>VALID PASSPORT</li>
              <li>AADHAAR CARD</li>
              <li>UTILITY BILL (Land Line Phone Bill's ; Electricity Bill)</li>
              <li>LIC POLICY DOCUMENT (Bearing Address)</li>
              <li>LEAVE AND LICENSE COPY or AGREEMENT COPY (Registered)</li>
              <li>BANK STATEMENT or PASSBOOK (Preferably Nationalized Banks with Address)</li>
              <li>RATION CARD</li>
              <li>DECLARATION OF CANDIDATES STAY FROM OWNER WITH UTILITY BILL</li>
            </ol>
          </td>
        </tr>
      </table>
      <table class="doc-table">
        <tr>
          <td colspan="2" class="doc-table-header">ANY ONE (1) DOCUMENTS FOR IDENTITY PROOF TO BE SUBMITTED</td>
        </tr>
        <tr>
          <td style="width:22%; vertical-align:top; font-weight:700; text-align:center;">IDENTITY<br>PROOF</td>
          <td>
            <ol style="margin:0 0 0 18px; padding:0;">
              <li>VALID PASSPORT</li>
              <li>PAN CARD</li>
              <li>DRIVER'S LICENSE</li>
              <li>VOTER'S ID or AADHAAR CARD</li>
              <li>BANK PASSBOOK (With Photograph)</li>
              <li>COLLEGE ID (For Fresher's)</li>
              <li>DEFENSE ID CARD (Issued By Govt. Of India For Defense Staff)</li>
            </ol>
          </td>
        </tr>
      </table>
    </div>
  </div>
</body>
</html>
