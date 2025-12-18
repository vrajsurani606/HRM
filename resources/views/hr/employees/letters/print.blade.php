@php
$company_name = isset($company_name) ? $company_name : 'CHITRI ENLARGE SOFT IT HUB PVT. LTD.';
$company_address = '244-245, Arjj Imperio, Near By Sarthana Police Station, Vraj Chowk, Surat - 395006';
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
    
    * {
        font-family: 'Poppins', sans-serif !important;
        box-sizing: border-box;
    }
    
    .fa, .fas, .far, .fab, .fal, .fad, [class^="fa-"], [class*=" fa-"] {
        font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands" !important;
    }
    
    body, html { 
        margin: 0; 
        padding: 0; 
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
        background: #f5f5f5;
    }
    
    b, strong {
        font-weight: 700 !important;
    }
    
    /* Page setup for print */
    @page { 
        size: A4 portrait;
        margin: 0; 
    }
    
    /* Main page container */
    .page {
        width: 210mm;
        min-height: 297mm;
        position: relative;
        background: white;
        margin: 0 auto 20px auto;
        overflow: visible;
    }
    
    /* Background image - fixed to each page */
    .page-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 297mm;
        z-index: 0;
        pointer-events: none;
    }
    
    .page-bg img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    /* Content wrapper */
    .content-wrapper {
        position: relative;
        z-index: 1;
        padding: 170px 40px 100px 40px;
        min-height: calc(297mm - 270px);
    }
    
    /* Letter elements */
    .letter-header {
        margin-bottom: 8px;
    }
    
    .letter-meta {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        color: #222;
        margin-bottom: 6px;
    }
    
    .recipient {
        font-size: 13px;
        color: #222;
        line-height: 1.4;
        margin-bottom: 6px;
    }
    
    .subject {
        font-size: 13px;
        font-weight: 700;
        color: #222;
        text-align: center;
        text-decoration: underline;
        margin-bottom: 10px;
    }
    
    .body {
        font-size: 13px;
        color: #222;
        line-height: 1.6;
        text-align: justify;
    }
    
    .body p {
        margin-bottom: 8px;
    }
    
    .body ul, .body ol {
        margin: 4px 0 10px 0;
        padding-left: 20px;
    }
    
    .body li {
        margin-bottom: 4px;
    }
    
    .body .company {
        color: #456DB5;
        font-weight: 700;
    }
    
    .signature {
        font-size: 13px;
        color: #222;
        margin-top: 15px;
    }
    
    .signature .name {
        font-weight: 700;
    }
    
    .signature .company {
        color: #456DB5;
        font-weight: 700;
    }
    
    .signature .sign {
        margin: 4px 0;
    }
    
    .signature .sign img {
        height: 50px;
        width: auto;
    }
    
    /* Button container */
    .btn-container {
        position: fixed;
        right: 24px;
        top: 20px;
        z-index: 9999;
        display: flex;
        gap: 10px;
    }
    
    .print-btn, .back-btn {
        border: 0;
        padding: 10px 14px;
        border-radius: 6px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        cursor: pointer;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        color: #fff;
    }
    
    .print-btn {
        background: #1f2937;
    }
    
    .print-btn:hover {
        background: #111827;
    }
    
    .back-btn {
        background: #6b7280;
    }
    
    .back-btn:hover {
        background: #4b5563;
    }
    
    /* Screen preview */
    @media screen {
        body {
            padding: 20px;
        }
        
        .page {
            box-shadow: 0 4px 24px rgba(44,108,164,0.15);
            border: 1px solid #dbe6f7;
        }
    }
    
    /* Print styles */
    @media print {
        body, html {
            background: none;
            margin: 0;
            padding: 0;
        }
        
        .btn-container {
            display: none !important;
        }
        
        .page {
            width: 210mm;
            height: 297mm;
            min-height: 297mm;
            max-height: 297mm;
            margin: 0;
            box-shadow: none;
            border: none;
            page-break-after: always;
            page-break-inside: avoid;
            overflow: hidden;
        }
        
        .page:last-child {
            page-break-after: auto;
        }
        
        .page-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 210mm;
            height: 297mm;
        }
        
        .page-bg img {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .content-wrapper {
            padding: 165px 35px 95px 35px;
            max-height: calc(297mm - 260px);
            overflow: hidden;
        }
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

<div id="pages-container"></div>

<div id="source-content" style="display: none;">
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
            <div class="letter-header">
                <div class="letter-meta">
                    <div><b>Ref No.:</b> {{ $letter->reference_number ?? 'REF001' }}</div>
                    <div><b>Date:</b> {{ date('d-m-Y') }}</div>
                </div>
                <div class="recipient">
                    <div><b>To,</b></div>
                    <div>{{ $employee->name }}</div>
                    @if($employee->address)
                    <div>{{ $employee->address }}</div>
                    @endif
                </div>
            </div>
            <div class="subject">{{ $letter->title ?? 'Subject: Employee Letter' }}</div>
            <div class="body">
                <p>Dear <b>{{ $employee->name }}</b>,</p>
                <p>Letter type not supported.</p>
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

<script>
function goBack() {
    const urlParams = new URLSearchParams(window.location.search);
    const redirectTo = urlParams.get('redirect_to');
    
    if (redirectTo) {
        window.location.href = redirectTo;
    } else {
        @if(isset($employee) && $employee)
        window.location.href = "{{ route('employees.letters.index', $employee) }}";
        @else
        window.location.href = "{{ route('employees.index') }}";
        @endif
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const pagesContainer = document.getElementById('pages-container');
    const sourceContent = document.getElementById('source-content');
    const backgroundUrl = '{{ $background_url }}';
    
    // A4 dimensions in pixels (at 96 DPI)
    // 297mm = ~1123px, but we need to account for header (~165px) and footer (~95px)
    // Available content height = 1123 - 165 - 95 = ~863px
    // Use slightly less for safety margin
    const MAX_CONTENT_HEIGHT = 750;
    
    function createPage(pageNum) {
        const page = document.createElement('div');
        page.className = 'page';
        page.id = 'page-' + pageNum;
        page.innerHTML = `
            <div class="page-bg"><img src="${backgroundUrl}" alt=""></div>
            <div class="content-wrapper" id="content-${pageNum}"></div>
        `;
        pagesContainer.appendChild(page);
        return page.querySelector('.content-wrapper');
    }
    
    function distributeContent() {
        // Get all top-level elements from source
        const elements = Array.from(sourceContent.children);
        
        if (elements.length === 0) return;
        
        let currentPageNum = 1;
        let currentContent = createPage(currentPageNum);
        let currentHeight = 0;
        
        // Separate header, body, and signature
        let headerElements = [];
        let bodyElement = null;
        let signatureElement = null;
        
        elements.forEach(el => {
            if (el.classList.contains('letter-header') || el.classList.contains('subject')) {
                headerElements.push(el.cloneNode(true));
            } else if (el.classList.contains('body')) {
                bodyElement = el;
            } else if (el.classList.contains('signature')) {
                signatureElement = el.cloneNode(true);
            }
        });
        
        // Add header elements to first page
        headerElements.forEach(el => {
            currentContent.appendChild(el);
        });
        
        // Measure header height
        currentHeight = currentContent.offsetHeight;
        
        // Process body content
        if (bodyElement) {
            const bodyChildren = Array.from(bodyElement.children);
            let currentBody = document.createElement('div');
            currentBody.className = 'body';
            currentContent.appendChild(currentBody);
            
            bodyChildren.forEach((child, index) => {
                // Clone and add to current body
                const clonedChild = child.cloneNode(true);
                currentBody.appendChild(clonedChild);
                
                // Check if we've exceeded the page height
                const totalHeight = currentContent.offsetHeight;
                
                // Reserve space for signature on last elements
                const isNearEnd = index >= bodyChildren.length - 3;
                const reserveForSignature = isNearEnd ? 120 : 0;
                
                if (totalHeight > MAX_CONTENT_HEIGHT - reserveForSignature) {
                    // Remove the element that caused overflow
                    currentBody.removeChild(clonedChild);
                    
                    // Create new page
                    currentPageNum++;
                    currentContent = createPage(currentPageNum);
                    currentBody = document.createElement('div');
                    currentBody.className = 'body';
                    currentContent.appendChild(currentBody);
                    
                    // Add the element to new page
                    currentBody.appendChild(clonedChild);
                }
            });
        }
        
        // Add signature to last page
        if (signatureElement) {
            currentContent.appendChild(signatureElement);
        }
        
        console.log('Letter distributed across', currentPageNum, 'page(s)');
    }
    
    // Wait for fonts and images to load
    setTimeout(distributeContent, 200);
});
</script>

</body>
</html>
