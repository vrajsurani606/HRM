<?php $__env->startSection('page_title', $page_title); ?>

<?php $__env->startPush('styles'); ?>
<!-- jQuery UI CSS for Datepicker -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
  <div class="hrp-card">
    <div class="Rectangle-30 hrp-compact">
      <form method="POST" action="<?php echo e($offer ? route('hiring.offer.update', $lead->id) : route('hiring.offer.store', $lead->id)); ?>" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3" id="offerForm">
        <?php echo csrf_field(); ?>
        <?php if($offer): ?>
          <?php echo method_field('PUT'); ?>
        <?php endif; ?>

        <div class="md:col-span-2">
          <div class="hrp-alert hrp-alert-info" role="alert">
            <strong>Hiring Lead:</strong> <?php echo e($lead->unique_code); ?> — <?php echo e($lead->person_name); ?> (<?php echo e($lead->position); ?>)
          </div>
        </div>

        <div>
          <label class="hrp-label">Letter Issue Date:</label>
          <input type="text" name="issue_date" id="issue_date" value="<?php echo e(old('issue_date', optional($offer->issue_date ?? null)->format('d/m/Y'))); ?>" class="hrp-input Rectangle-29 date-picker" placeholder="dd/mm/yyyy" autocomplete="off">
          <?php $__errorArgs = ['issue_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="hrp-label">Letter Note:</label>
          <input name="note" value="<?php echo e(old('note', $offer->note ?? '')); ?>" placeholder="Optional note" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="hrp-label">Monthly Salary:</label>
          <input type="number" step="0.01" min="0" name="monthly_salary" value="<?php echo e(old('monthly_salary', $offer->monthly_salary ?? '')); ?>" placeholder="e.g. 35000" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['monthly_salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="hrp-label">Annual CTC:</label>
          <input type="number" step="0.01" min="0" name="annual_ctc" value="<?php echo e(old('annual_ctc', $offer->annual_ctc ?? '')); ?>" placeholder="e.g. 420000" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['annual_ctc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="hrp-label">Reporting Manager:</label>
          <input name="reporting_manager" value="<?php echo e(old('reporting_manager', $offer->reporting_manager ?? '')); ?>" placeholder="Manager name" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['reporting_manager'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="hrp-label">Working Hours:</label>
          <input name="working_hours" value="<?php echo e(old('working_hours', $offer->working_hours ?? '')); ?>" placeholder="e.g. 9:30 AM - 6:30 PM" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['working_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="hrp-label">Date of Joining:</label>
          <input type="text" name="date_of_joining" id="date_of_joining" value="<?php echo e(old('date_of_joining', optional($offer->date_of_joining ?? null)->format('d/m/Y'))); ?>" class="hrp-input Rectangle-29 date-picker" placeholder="dd/mm/yyyy" autocomplete="off">
          <?php $__errorArgs = ['date_of_joining'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="md:col-span-2">
          <label class="hrp-label">Probation Period (bulleted lines):</label>
          <textarea name="probation_period" rows="4" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" placeholder="Enter each point on new line"><?php echo e(old('probation_period', $offer->probation_period ?? '')); ?></textarea>
          <?php $__errorArgs = ['probation_period'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="md:col-span-2">
          <label class="hrp-label">Salary & Increment (bulleted lines):</label>
          <textarea name="salary_increment" rows="4" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" placeholder="Enter each point on new line"><?php echo e(old('salary_increment', $offer->salary_increment ?? '')); ?></textarea>
          <?php $__errorArgs = ['salary_increment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="md:col-span-2">
          <div class="hrp-actions">
            <button class="hrp-btn hrp-btn-primary" name="save" value="1"><?php echo e($offer ? 'Update Offer Letter' : 'Save Offer Letter'); ?></button>
            <button class="hrp-btn" name="save_and_print" value="1">Save & Print</button>
            <a class="hrp-btn hrp-btn-ghost" href="<?php echo e(route('hiring.index')); ?>">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
  <a class="hrp-bc-home" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="<?php echo e(route('hiring.index')); ?>" style="font-weight:800;color:#0f0f0f;text-decoration:none">HRM</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current"><?php echo e($page_title); ?></span>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- jQuery UI JS for Datepicker -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize jQuery datepicker
    $('.date-picker').datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '-100:+10',
        showButtonPanel: true
    });
    
    // Set today's date as default for issue date if empty
    const issueDateEl = document.getElementById('issue_date');
    if (issueDateEl && !issueDateEl.value) {
        const today = new Date();
        const dd = String(today.getDate()).padStart(2, '0');
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const yyyy = today.getFullYear();
        issueDateEl.value = dd + '/' + mm + '/' + yyyy;
    }
    
    // Set default joining date to 7 days from now if empty
    const joiningEl = document.getElementById('date_of_joining');
    if (joiningEl && !joiningEl.value) {
        const nextWeek = new Date();
        nextWeek.setDate(nextWeek.getDate() + 7);
        const dd2 = String(nextWeek.getDate()).padStart(2, '0');
        const mm2 = String(nextWeek.getMonth() + 1).padStart(2, '0');
        const yyyy2 = nextWeek.getFullYear();
        joiningEl.value = dd2 + '/' + mm2 + '/' + yyyy2;
    }
});

// Convert dates from dd/mm/yyyy to yyyy-mm-dd before form submission
$('#offerForm').on('submit', function(e) {
    $('.date-picker').each(function() {
        const dateValue = $(this).val();
        if (dateValue && dateValue.match(/^\d{1,2}\/\d{1,2}\/\d{2,4}$/)) {
            const parts = dateValue.split('/');
            const day = parts[0].padStart(2, '0');
            const month = parts[1].padStart(2, '0');
            let year = parts[2];
            
            // Convert 2-digit year to 4-digit if needed
            if (year.length === 2) {
                const currentYear = new Date().getFullYear();
                const century = Math.floor(currentYear / 100) * 100;
                year = century + parseInt(year);
            }
            
            // Create hidden input with converted date
            const hiddenInput = $('<input>')
                .attr('type', 'hidden')
                .attr('name', $(this).attr('name'))
                .val(year + '-' + month + '-' + day);
            
            // Remove name from original input and add hidden input
            $(this).removeAttr('name');
            $(this).after(hiddenInput);
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/hr/hiring/offer_form.blade.php ENDPATH**/ ?>