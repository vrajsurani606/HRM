<?php
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo e($letter->type); ?> Letter - <?php echo e($employee->name); ?></title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
    
    * {
        font-family: 'Poppins', sans-serif !important;
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
        position: relative; overflow: hidden; border: none; page-break-inside: avoid;
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
    
    /* Content Area - Keep away from header (top 20%) and footer (bottom 20%) */
    .letter-content { 
        position:relative; z-index:1;
        width:100%; max-width:800px; margin:0 auto; 
        /* Top padding: ~200px for header, Bottom padding: ~220px for footer */
        padding: 200px 36px 220px 36px;
        box-sizing:border-box;
        min-height: 100vh;
    }
    
    /* Letter Elements */
    .letter-meta, .recipient, .subject, .body, .signature { 
        margin-bottom:10px; 
        font-family: 'Poppins', sans-serif !important;
    }
    .letter-meta { 
        display:flex; 
        justify-content:space-between; 
        font-size:14px; 
        color:#222; 
        font-weight:400;
        font-family: 'Poppins', sans-serif !important;
    }
    .letter-meta b {
        font-weight: 700 !important;
    }
    .recipient { 
        font-size:14px; 
        color:#222; 
        line-height:1.5;
        font-family: 'Poppins', sans-serif !important;
        font-weight: 400;
    }
    .recipient b {
        font-weight: 700 !important;
    }
    .subject { 
        font-size:16px; 
        font-weight:700 !important; 
        color:#222; 
        text-align:center; 
        text-decoration:underline;
        font-family: 'Poppins', sans-serif !important;
    }
    .body { 
        font-size:15px; 
        color:#222; 
        line-height:1.7; 
        text-align:justify;
        font-family: 'Poppins', sans-serif !important;
        font-weight: 400;
    }
    .body b, .body strong {
        font-weight: 700 !important;
    }
    .body p { 
        margin-bottom:6px; 
        page-break-inside:avoid;
        font-family: 'Poppins', sans-serif !important;
        font-weight: 400;
    }
    .body ol, .body ul { 
        margin:6px 0; 
        padding-left:20px;
        font-family: 'Poppins', sans-serif !important;
    }
    .body li { 
        margin-bottom:4px; 
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
        font-size:14px; 
        color:#222; 
        text-align:left; 
        margin-top:16px; 
        page-break-inside:avoid;
        font-family: 'Poppins', sans-serif !important;
        font-weight: 400;
    }
    .signature b {
        font-weight: 700 !important;
    }
    .signature .name { 
        font-weight:700 !important; 
        font-size:15px;
        font-family: 'Poppins', sans-serif !important;
    }
    .signature .company { 
        font-size:14px; 
        color:#456DB5; 
        font-weight:700 !important;
        font-family: 'Poppins', sans-serif !important;
    }
    .signature .sign { margin:6px 0 6px 0; }
    .signature .sign img { height:50px; width:auto; display:block; object-fit:contain; }
    
    .note-rectangle {
        background: #fffde7;
        border-left: 4px solid #456DB5;
        padding: 10px 14px;
        margin: 12px 0;
        font-size: 13px;
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
        font-size: 14px;
        font-family: 'Poppins', sans-serif !important;
    }
    .bullets-avoid-break { break-inside: avoid; page-break-inside: avoid; }
    
    /* Print Button */
    .print-btn {
        position: fixed; right: 24px; top: 20px; z-index: 9999;
        background: #1f2937; color: #fff; border: 0; padding: 10px 14px; border-radius: 6px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15); cursor: pointer; font-weight: 700;
    }
    .print-btn:hover { background: #111827; }
    
    /* Print Styles */
    @media print {
        @page {
            size: A4 portrait;
            margin: 0;
        }
        
        .print-btn { display:none !important; }
        body { background:none; margin:0; padding:0; }
        
        .offer-container { 
            box-shadow:none; border:none; 
            width: 210mm; height: 297mm;
            page-break-after: always;
        }
        
        .offer-container:last-child {
            page-break-after: auto;
        }
        
        .offer-container .bg-cover img {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .letter-content { 
            /* A4 height = 297mm = ~1123px
               Header: 25% = ~280px
               Footer: 20% = ~225px
               Content: 55% = ~618px */
            padding: 280px 30px 225px 30px;
            min-height: 618px;
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
    }
    
    /* Screen Preview */
    @media screen {
        body, html { background:#f5f5f5; min-height:100vh; min-width:100vw; margin:0; padding:0; }
        .offer-container { 
            width:794px; min-width:794px; max-width:794px; 
            height:1123px; min-height:1123px; max-height:1123px; 
            margin:40px auto; box-shadow:0 4px 24px rgba(44,108,164,0.10); 
            position:relative; overflow:hidden; border:1.5px solid #dbe6f7; display:block;
        }
        .letter-content { max-height:none !important; height:auto !important; overflow:visible !important; }
        .break-section { margin-top:32px; }
    }
</style>
</head>
<body>
<button class="print-btn" onclick="window.print()">Print</button>

<div class="offer-container">
    <div class="bg-cover"><img src="<?php echo e($background_url); ?>" alt="" /></div>
    <div class="letter-content">
        <?php switch($letter->type):
            case ('joining'): ?>
                <?php echo $__env->make('hr.employees.letters.templates.joining', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>

            <?php case ('confidentiality'): ?>
                <?php echo $__env->make('hr.employees.letters.templates.confidentiality', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>

            <?php case ('impartiality'): ?>
                <?php echo $__env->make('hr.employees.letters.templates.impartiality', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>

            <?php case ('experience'): ?>
                <?php echo $__env->make('hr.employees.letters.templates.experience', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>

            <?php case ('agreement'): ?>
                <?php echo $__env->make('hr.employees.letters.templates.agreement', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>

            <?php case ('warning'): ?>
                <?php echo $__env->make('hr.employees.letters.templates.warning', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>

            <?php case ('termination'): ?>
                <?php echo $__env->make('hr.employees.letters.templates.termination', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>
                
            <?php case ('promotion'): ?>
                <?php echo $__env->make('hr.employees.letters.templates.promotion', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>
                
            <?php case ('increment'): ?>
                <?php echo $__env->make('hr.employees.letters.templates.increment', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>
                
            <?php case ('internship_offer'): ?>
                <?php echo $__env->make('hr.employees.letters.templates.internship_offer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>
                
            <?php case ('internship_letter'): ?>
                <?php echo $__env->make('hr.employees.letters.templates.internship_letter', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>
                
            <?php case ('resignation'): ?>
                <?php echo $__env->make('hr.employees.letters.templates.resignation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>
            
            <?php case ('other'): ?>
                <?php echo $__env->make('hr.employees.letters.templates.other', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>

            <?php default: ?>
                <div class="letter-meta">
                    <div><b>Ref No.:</b> <?php echo e($letter->reference_number ?? 'REF001'); ?></div>
                    <div><b>Date:</b> <?php echo e(date('d-m-Y')); ?></div>
                </div>
                <div class="recipient">
                    <div><b>To,</b></div>
                    <div><?php echo e($employee->name); ?></div>
                    <?php if($employee->address): ?>
                    <div>Address :- <?php echo e($employee->address); ?></div>
                    <?php endif; ?>
                </div>
                <div class="subject"><?php echo e($letter->title ?? 'Subject: Employee Letter'); ?></div>
                <div class="body">
                    <p>Dear <b><?php echo e($employee->name); ?></b>,</p>
                    <p style="font-size:13px; font-weight:700;">Letter type not supported.</p>
                    
                    <?php
                        $cleanNotes = trim(strip_tags($letter->notes ?? ''));
                    ?>
                    
                    <?php if(!empty($cleanNotes)): ?>
                        <div class="note-rectangle">
                            <b>Note: <?php echo strip_tags($letter->notes); ?></b>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="signature">
                    <div><b>Sincerely,</b></div>
                    <div class="sign">
                        <img src="<?php echo e(asset('letters/signature.png')); ?>" alt="Signature">
                    </div>
                    <div class="name"><?php echo e($signatory_name ?? 'Mr. Chintan Kachhadiya'); ?></div>
                    <div class="company"><?php echo e($company_name); ?></div>
                </div>
        <?php endswitch; ?>
    </div>
</div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/hr/employees/letters/print.blade.php ENDPATH**/ ?>