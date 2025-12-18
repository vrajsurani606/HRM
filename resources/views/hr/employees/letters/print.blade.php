@php
$company_name = isset($company_name) ? $company_name : 'CHITRI ENLARGE SOFT IT HUB PVT. LTD.';
$company_address = '244-245, Arjj Imperio, Near By Sarthana Police Station, Vraj Chowk, Surat - 395006';
$company_phone = '+91 72763 23999';
$company_email = 'info@ceihpl.com';
$company_website = 'www.ceihpl.com';
$background_url = isset($background_url) && $background_url ? $background_url : asset('letters/back.png');

// Calculate content length and adjust font size dynamically
$contentLength = strlen(strip_tags($letter->content ?? ''));
$bodyFontSize = '12px';
$lineHeight = '1.6';

if ($contentLength > 3000) {
    $bodyFontSize = '10px';
    $lineHeight = '1.5';
} elseif ($contentLength > 2000) {
    $bodyFontSize = '11px';
    $lineHeight = '1.55';
}
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $letter->type }} Letter - {{ $employee->name }}</title>
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
    
    body, html { 
        margin:0 !important; 
        padding:0 !important; 
        font-family: 'Poppins', sans-serif !important;
        font-weight: 400;
    }
    
    b, strong {
        font-family: 'Poppins', sans-serif !important;
        font-weight: 700 !important;
    }
    @page { margin: 0; }
    
    /* Page Container */
    .offer-container {
        width: 100vw; min-width: 100vw; height: 100vh; margin: 0;
        position: relative; overflow: visible; border: none; page-break-inside: avoid;
        display: flex; flex-direction: column; justify-content: flex-start;
    }
    
    /* Full Page Background */
    .offer-container .bg-cover {
        position:absolute; inset:0; width:100%; height:100%; z-index:0;
    }
    .offer-container .bg-cover img { 
        width:100%; height:100%; object-fit:cover; display:block;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    /* Content Area - Keep away from header and footer */
    .letter-content { 
        position:relative; z-index:1;
        width:100%; max-width:800px; margin:0 auto; 
        /* Top padding for header, bottom padding for footer */
        padding: 190px 36px 120px 36px;
        box-sizing:border-box;
    }
    
    /* Letter Elements */
    .letter-meta, .recipient, .subject, .body, .signature { 
        margin-bottom:10px; 
        font-family: 'Poppins', sans-serif !important;
    }
    .letter-meta { 
        display:flex; 
        justify-content:space-between; 
        font-size:13px; 
        color:#222; 
        font-weight:400;
        font-family: 'Poppins', sans-serif !important;
        margin-bottom: 6px;
    }
    .letter-meta b {
        font-weight: 700 !important;
    }
    .recipient { 
        font-size:13px; 
        color:#222; 
        line-height:1.4;
        font-family: 'Poppins', sans-serif !important;
        font-weight: 400;
        margin-bottom: 6px;
    }
    .recipient b {
        font-weight: 700 !important;
    }
    .subject { 
        font-size:13px; 
        font-weight:700 !important; 
        color:#222; 
        text-align:center; 
        text-decoration:underline;
        font-family: 'Poppins', sans-serif !important;
        margin-bottom: 6px;
    }
    .body { 
        font-size:13px; 
        color:#222; 
        line-height:1.5; 
        text-align:justify;
        font-family: 'Poppins', sans-serif !important;
        font-weight: 400;
    }
    .body b, .body strong {
        font-weight: 700 !important;
    }
    .body p { 
        margin-bottom:4px; 
        page-break-inside:avoid;
        font-family: 'Poppins', sans-serif !important;
        font-weight: 400;
    }
    .body ol, .body ul { 
        margin:2px 0 6px 0; 
        padding-left:18px;
        font-family: 'Poppins', sans-serif !important;
    }
    .body li { 
        margin-bottom:2px; 
        page-break-inside:avoid;
        font-family: 'Poppins', sans-serif !important;
    }
    .body .company { 
        color:#456DB5; 
        font-weight:700 !important;
        font-family: 'Poppins', sans-serif !important;
    }
    .body .highlight { 
        font-weight:700 !important;
        font-family: 'Poppins', sans-serif !important;
    }
    
    .signature { 
        font-size:13px; 
        color:#222; 
        text-align:left; 
        margin-top:10px; 
        page-break-inside:avoid;
        font-family: 'Poppins', sans-serif !important;
        font-weight: 400;
    }
    .signature b {
        font-weight: 700 !important;
    }
    .signature .name { 
        font-weight:700 !important; 
        font-size:13px;
        font-family: 'Poppins', sans-serif !important;
    }
    .signature .company { 
        font-size:13px; 
        color:#456DB5; 
        font-weight:700 !important;
        font-family: 'Poppins', sans-serif !important;
    }
    .signature .sign { margin:4px 0 4px 0; }
    .signature .sign img { height:50px; width:auto; display:block; object-fit:contain; }
    
    .note-rectangle {
        background: #fffde7;
        border-left: 4px solid #456DB5;
        padding: 10px 14px;
        margin: 12px 0;
        font-size: 12px;
        border-radius: 4px;
        page-break-inside: avoid;
        font-family: 'Poppins', sans-serif !important;
        font-weight: 400;
    }
    .note-rectangle b { 
        color: #333; 
        font-weight: 700 !important;
        font-family: 'Poppins', sans-serif !important;
    }
    .font-weight-bold { 
        font-weight: 700 !important; 
        font-size: 13px;
        font-family: 'Poppins', sans-serif !important;
    }
    .bullets-avoid-break { break-inside: avoid; page-break-inside: avoid; }
    
    /* Button Container */
    .btn-container {
        position: fixed;
        right: 24px;
        top: 20px;
        z-index: 9999;
        display: flex;
        gap: 10px;
    }
    
    /* Print & Back Buttons */
    .print-btn {
        background: #1f2937; color: #fff; border: 0; padding: 10px 14px; border-radius: 6px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15); cursor: pointer; font-weight: 700;
        display: inline-flex;
        align-items: center;
    }
    .print-btn:hover { background: #111827; }
    
    .back-btn {
        background: #6b7280; color: #fff; border: 0; padding: 10px 14px; border-radius: 6px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15); cursor: pointer; font-weight: 700;
        display: inline-flex;
        align-items: center;
    }
    .back-btn:hover { background: #4b5563; }
    
    /* Print Styles */
    @media print {
        @page {
            size: A4 portrait;
            margin: 0;
        }
        
        .btn-container { display:none !important; }
        .print-btn, .back-btn { display:none !important; }
        body { background:none; margin:0; padding:0; }
        
        .offer-container { 
            box-shadow:none; border:none; 
            width: 210mm; height: 297mm;
            page-break-after: always;
            overflow: visible !important;
        }
        
        .offer-container:last-child {
            page-break-after: auto;
        }
        
        .offer-container .bg-cover img {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .letter-content { 
            /* Top padding for header, bottom padding for footer */
            padding: 190px 30px 120px 30px;
            max-height: none !important;
            overflow: visible !important;
        }
        
        .break-section { 
            page-break-before: always; 
            break-inside: avoid; 
        }
        
        /* Prevent content from breaking badly */
        .letter-meta, .recipient, .subject {
            page-break-after: avoid;
            page-break-inside: avoid;
        }
        
        .signature {
            page-break-before: avoid;
            page-break-inside: avoid;
        }
        
        .body p {
            orphans: 3;
            widows: 3;
        }
        
        .body ul, .body ol {
            page-break-inside: avoid;
        }
        
        .body li {
            page-break-inside: avoid;
        }
    }
    
    /* Screen Preview */
    @media screen {
        body, html { background:#f5f5f5; min-height:100vh; min-width:100vw; margin:0; padding:0; }
        .offer-container { 
            width:794px; min-width:794px; max-width:794px; 
            min-height:1123px;
            margin:40px auto; box-shadow:0 4px 24px rgba(44,108,164,0.10); 
            position:relative; overflow:visible; border:1.5px solid #dbe6f7; display:block;
        }
        /* Screen view - allow content to flow naturally */
        .letter-content { 
            max-height: none !important;
            overflow: visible !important;
            padding-top: 190px !important;
            padding-bottom: 120px !important;
        }
        
        .break-section { margin-top:32px; }
        
        /* Page 2 styling for screen */
        #page2 {
            margin-top: 40px;
        }
        #page2 .letter-content {
            padding-top: 190px !important;
            max-height: none !important;
        }
    }
    
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
@php
    // Count lines in content - each paragraph, list item counts as a line
    $contentHtml = $letter->content ?? '';
    $contentText = strip_tags($contentHtml);
    $lineCount = substr_count($contentText, "\n") + 1;
    
    // Also count <p>, <li>, <br> tags as lines
    $lineCount += substr_count($contentHtml, '<p>');
    $lineCount += substr_count($contentHtml, '<li>');
    $lineCount += substr_count($contentHtml, '<br');
    
    // Check if content needs page break (more than 35 lines)
    $needsPageBreak = $lineCount > 35;
@endphp

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
        // Default: go to employee letters index (don't rely on history.back)
        @if(isset($employee) && $employee)
        window.location.href = "{{ route('employees.letters.index', $employee) }}";
        @else
        window.location.href = "{{ route('employees.index') }}";
        @endif
    }
}
</script>

<div class="offer-container" id="page1">
    <div class="bg-cover"><img src="{{ $background_url }}" alt="" /></div>
    <div class="letter-content" id="content-page1">
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
                @include('hr.employees.letters.templates.resignation_acceptance')
                @break
            
            @case('resignation_acceptance')
                @include('hr.employees.letters.templates.resignation_acceptance')
                @break
            
            @case('salary_certificate')
                @include('hr.employees.letters.templates.salary_certificate')
                @break
            
            @case('offer')
                @include('hr.employees.letters.templates.offer')
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
                    <p style="font-size:13px; font-weight:700;">Letter type not supported.</p>
                    
                    {{-- Notes are for internal use only and should not appear in printed letters --}}
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

{{-- Second page container for overflow content --}}
<div class="offer-container" id="page2" style="display: none;">
    <div class="bg-cover"><img src="{{ $background_url }}" alt="" /></div>
    <div class="letter-content" id="content-page2">
        {{-- Overflow content will be moved here by JavaScript --}}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const page1 = document.getElementById('page1');
    const page1Content = document.getElementById('content-page1');
    const page2 = document.getElementById('page2');
    const page2Content = document.getElementById('content-page2');
    
    // Maximum content height before page break (in pixels)
    // A4 page height = 1123px
    // Header area (logo + company name) = ~140px from top
    // Footer area (contact info) = ~80px from bottom
    // Safe content area = 1123 - 140 - 80 = ~903px
    // With padding (190px top, 120px bottom) = content area ~613px
    // For 35 lines at ~17px per line = ~595px
    const MAX_CONTENT_HEIGHT = 595; // pixels - approximately 35 lines of body content
    
    function splitContentIfNeeded() {
        // Get actual rendered heights
        const body = page1Content.querySelector('.body');
        const signature = page1Content.querySelector('.signature');
        
        if (!body) return;
        
        // Calculate total content height (body + signature)
        const bodyHeight = body.offsetHeight;
        const signatureHeight = signature ? signature.offsetHeight : 0;
        const totalContentHeight = bodyHeight + signatureHeight;
        
        console.log('Body height:', bodyHeight, 'Signature height:', signatureHeight, 'Total:', totalContentHeight, 'Max allowed:', MAX_CONTENT_HEIGHT);
        
        // Only split if total content exceeds max height
        if (totalContentHeight > MAX_CONTENT_HEIGHT) {
            // Content overflows - need to split
            page2.style.display = 'block';
            
            // Get all paragraphs and elements in body
            const bodyChildren = Array.from(body.children);
            
            // Calculate available height for body (leave room for signature on page 2)
            const availableBodyHeight = MAX_CONTENT_HEIGHT - 20; // Small buffer
            
            // Find split point based on actual element heights
            let currentHeight = 0;
            let splitIndex = -1;
            
            for (let i = 0; i < bodyChildren.length; i++) {
                const child = bodyChildren[i];
                const childHeight = child.offsetHeight + 8; // Add margin
                
                if (currentHeight + childHeight > availableBodyHeight) {
                    splitIndex = i;
                    break;
                }
                currentHeight += childHeight;
            }
            
            console.log('Split at index:', splitIndex, 'Current height at split:', currentHeight);
            
            // If we found a split point, move content
            if (splitIndex >= 0 && splitIndex < bodyChildren.length) {
                // Create body container for page 2
                const page2Body = document.createElement('div');
                page2Body.className = 'body';
                page2Body.style.fontSize = '13px';
                page2Body.style.color = '#222';
                page2Body.style.lineHeight = '1.7';
                page2Body.style.textAlign = 'justify';
                
                // Move elements after split point to page 2
                for (let i = splitIndex; i < bodyChildren.length; i++) {
                    const child = bodyChildren[i];
                    page2Body.appendChild(child.cloneNode(true));
                    child.remove();
                }
                
                page2Content.appendChild(page2Body);
                
                // Move signature to page 2
                if (signature) {
                    const signatureClone = signature.cloneNode(true);
                    page2Content.appendChild(signatureClone);
                    signature.remove();
                }
            } else if (signature) {
                // All body content fits, just move signature to page 2
                const signatureClone = signature.cloneNode(true);
                page2Content.appendChild(signatureClone);
                signature.remove();
            }
        }
    }
    
    // Run after content is fully rendered
    setTimeout(splitContentIfNeeded, 200);
});
</script>

</body>
</html>
