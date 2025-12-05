
<?php $__env->startSection('page_title', 'Convert to Invoice'); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('error')): ?>
<div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
    <strong>⚠ Error:</strong> <?php echo e(session('error')); ?>

</div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('performas.convert.store', $proforma->id)); ?>" class="hrp-form">
  <?php echo csrf_field(); ?>

<div class="hrp-card">
  <div class="Rectangle-30 hrp-compact">
      
      <!-- Proforma Details Section -->
      <div style="background: #E8F0FC; border: 1px solid #C5D9F2; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
        <h3 style="font-size: 16px; font-weight: 700; color: #456DB5; margin-bottom: 15px;">Proforma Details</h3>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
          <div>
            <p style="font-size: 13px; color: #666; margin-bottom: 5px;"><strong>Proforma No:</strong></p>
            <p style="font-size: 14px; color: #000;"><?php echo e($proforma->unique_code); ?></p>
          </div>
          <div>
            <p style="font-size: 13px; color: #666; margin-bottom: 5px;"><strong>Company:</strong></p>
            <p style="font-size: 14px; color: #000;"><?php echo e($proforma->company_name); ?></p>
          </div>
          <div>
            <p style="font-size: 13px; color: #666; margin-bottom: 5px;"><strong>Amount:</strong></p>
            <p style="font-size: 14px; color: #000; font-weight: 600;">₹<?php echo e(number_format($proforma->final_amount, 2)); ?></p>
          </div>
        </div>
      </div>

      <!-- Invoice Information -->
      <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
        <div>
          <label class="hrp-label">Invoice Type: <span class="text-red-500">*</span></label>
          <select class="Rectangle-29-select <?php $__errorArgs = ['invoice_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="invoice_type" id="invoiceType" required>
            <option value="">Select Type</option>
            <option value="gst" <?php echo e(old('invoice_type') == 'gst' ? 'selected' : ''); ?> <?php echo e($hasGstInvoice ? 'disabled' : ''); ?>>
              GST Invoice <?php echo e($hasGstInvoice ? '(Already Generated)' : ''); ?>

            </option>
            <option value="without_gst" <?php echo e(old('invoice_type') == 'without_gst' ? 'selected' : ''); ?> <?php echo e($hasWithoutGstInvoice ? 'disabled' : ''); ?>>
              Without GST Invoice <?php echo e($hasWithoutGstInvoice ? '(Already Generated)' : ''); ?>

            </option>
          </select>
          <?php $__errorArgs = ['invoice_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="hrp-label">Invoice No:</label>
          <input type="text" class="Rectangle-29" id="invoiceNo" value="Select invoice type first" readonly style="background: #f3f4f6;">
        </div>
        
        <div>
          <label class="hrp-label">Invoice Date: <span class="text-red-500">*</span></label>
          <input type="date" class="Rectangle-29 <?php $__errorArgs = ['invoice_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="invoice_date" value="<?php echo e(old('invoice_date', date('Y-m-d'))); ?>" required>
          <?php $__errorArgs = ['invoice_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
      </div>

  </div>
</div>

<!-- Action Buttons -->
<div class="hrp-actions" style="margin-top: 30px;">
  <button type="submit" class="hrp-btn hrp-btn-primary">
    Convert to Invoice
  </button>
  <a href="<?php echo e(route('performas.index')); ?>" class="hrp-btn hrp-btn-secondary">
    Cancel
  </a>
</div>

</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const invoiceTypeSelect = document.getElementById('invoiceType');
  const invoiceNoInput = document.getElementById('invoiceNo');
  
  const gstCode = '<?php echo e($nextGstCode); ?>';
  const wgCode = '<?php echo e($nextWgCode); ?>';
  
  invoiceTypeSelect.addEventListener('change', function() {
    if (this.value === 'gst') {
      invoiceNoInput.value = gstCode;
    } else if (this.value === 'without_gst') {
      invoiceNoInput.value = wgCode;
    } else {
      invoiceNoInput.value = 'Select invoice type first';
    }
  });
  
  // Set initial value if type is already selected
  if (invoiceTypeSelect.value === 'gst') {
    invoiceNoInput.value = gstCode;
  } else if (invoiceTypeSelect.value === 'without_gst') {
    invoiceNoInput.value = wgCode;
  }
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/invoices/convert.blade.php ENDPATH**/ ?>