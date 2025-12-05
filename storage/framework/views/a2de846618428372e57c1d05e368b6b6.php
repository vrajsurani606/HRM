<div class="letter-header">
    <div style="margin-bottom: 15px;"><b>Ref No.:</b> <?php echo e($letter->reference_number); ?></div>
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
        <div class="recipient" style="flex: 1;">
            <div><b>To,</b></div>
            <div><?php echo e(($employee->gender == 'Female' || $employee->gender == 'female') ? 'Ms.' : 'Mr.'); ?> <?php echo e($employee->name); ?></div>
            <div><?php echo e($employee->designation ?? $employee->position ?? 'Employee'); ?></div>
            <?php if($employee->address): ?>
            <div><?php echo e($employee->address); ?></div>
            <?php endif; ?>
        </div>
        <div class="letter-meta" style="text-align: right;">
            <div><b>Date:</b> <?php echo e(\Carbon\Carbon::parse($letter->issue_date)->format('d-m-Y')); ?></div>
        </div>
    </div>
</div>

<?php if($letter->subject): ?>
<div class="subject">Subject: <?php echo e($letter->subject); ?></div>
<?php else: ?>
<div class="subject">Subject: Appointment / Joining Letter</div>
<?php endif; ?>

<div class="body">
    <p>Dear <b><?php echo e($employee->name); ?></b>,</p>
    
    <?php if($letter->use_default_content ?? true): ?>
        <p>We are pleased to confirm your appointment as <b><?php echo e($employee->designation); ?></b> at 
        <b><?php echo e($company_name); ?></b>. Your joining date and other details will be communicated to you 
        by the HR department. We look forward to your valuable contribution to our organization.</p>
        
        <p>Please report to the HR department on your joining date for further formalities.</p>
    <?php endif; ?>
    
    <?php if($letter->content): ?>
        <?php echo $letter->content; ?>

    <?php endif; ?>
    
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
    <div class="name"><?php echo e($signatory_name ?? 'Authorized Signatory'); ?></div>
    <div class="company"><?php echo e($company_name); ?></div>
</div><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/hr/employees/letters/templates/joining.blade.php ENDPATH**/ ?>