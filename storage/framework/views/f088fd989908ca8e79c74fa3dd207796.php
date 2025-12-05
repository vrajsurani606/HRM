
<?php $__env->startSection('page_title', 'Edit Invoice'); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('error')): ?>
<div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
    <strong>⚠ Error:</strong> <?php echo e(session('error')); ?>

</div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('invoices.update', $invoice->id)); ?>" class="hrp-form">
  <?php echo csrf_field(); ?>
  <?php echo method_field('PUT'); ?>

<div class="hrp-card">
  <div class="Rectangle-30 hrp-compact">
      
      <!-- Invoice Details Section -->
      <div style="background: #E8F0FC; border: 1px solid #C5D9F2; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
        <h3 style="font-size: 16px; font-weight: 700; color: #456DB5; margin-bottom: 15px;">Invoice Information</h3>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
          <div>
            <p style="font-size: 13px; color: #666; margin-bottom: 5px;"><strong>Invoice Type:</strong></p>
            <p style="font-size: 14px; color: #000;">
              <?php if($invoice->invoice_type == 'gst'): ?>
                <span style="background: #E8F0FC; color: #456DB5; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">GST Invoice</span>
              <?php else: ?>
                <span style="background: #FEF3C7; color: #92400E; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Without GST</span>
              <?php endif; ?>
            </p>
          </div>
          <?php if($invoice->proforma): ?>
          <div>
            <p style="font-size: 13px; color: #666; margin-bottom: 5px;"><strong>Proforma No:</strong></p>
            <p style="font-size: 14px; color: #000;"><?php echo e($invoice->proforma->unique_code); ?></p>
          </div>
          <?php endif; ?>
          <div>
            <p style="font-size: 13px; color: #666; margin-bottom: 5px;"><strong>Company:</strong></p>
            <p style="font-size: 14px; color: #000;"><?php echo e($invoice->company_name); ?></p>
          </div>
        </div>
      </div>

      <!-- Editable Fields -->
      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
        <div>
          <label class="hrp-label">Invoice No: <span class="text-red-500">*</span></label>
          <input type="text" class="Rectangle-29 <?php $__errorArgs = ['unique_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="unique_code" value="<?php echo e(old('unique_code', $invoice->unique_code)); ?>" required>
          <?php $__errorArgs = ['unique_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <div>
          <label class="hrp-label">Invoice Date: <span class="text-red-500">*</span></label>
          <input type="text" class="Rectangle-29 date-picker <?php $__errorArgs = ['invoice_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="invoice_date" placeholder="dd/mm/yyyy" value="<?php echo e(old('invoice_date', $invoice->invoice_date ? $invoice->invoice_date->format('d/m/Y') : '')); ?>" autocomplete="off" required>
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

      <!-- Read-only Information -->
      <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
        <h4 style="font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 15px;">Invoice Summary (Read-only)</h4>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
          <div>
            <p style="font-size: 12px; color: #6b7280; margin-bottom: 3px;">Subtotal</p>
            <p style="font-size: 14px; color: #111827; font-weight: 600;">₹<?php echo e(number_format($invoice->sub_total ?? 0, 2)); ?></p>
          </div>
          <?php if($invoice->discount_amount > 0): ?>
          <div>
            <p style="font-size: 12px; color: #6b7280; margin-bottom: 3px;">Discount</p>
            <p style="font-size: 14px; color: #111827; font-weight: 600;">₹<?php echo e(number_format($invoice->discount_amount, 2)); ?></p>
          </div>
          <?php endif; ?>
          <?php if($invoice->invoice_type === 'gst' && $invoice->total_tax_amount > 0): ?>
          <div>
            <p style="font-size: 12px; color: #6b7280; margin-bottom: 3px;">Total Tax</p>
            <p style="font-size: 14px; color: #111827; font-weight: 600;">₹<?php echo e(number_format($invoice->total_tax_amount, 2)); ?></p>
          </div>
          <?php endif; ?>
          <div>
            <p style="font-size: 12px; color: #6b7280; margin-bottom: 3px;">Final Amount</p>
            <p style="font-size: 16px; color: #456DB5; font-weight: 700;">₹<?php echo e(number_format($invoice->final_amount ?? 0, 2)); ?></p>
          </div>
        </div>
      </div>

  </div>
</div>

<!-- Action Buttons -->
<div class="hrp-actions" style="margin-top: 30px;">
  <button type="submit" class="hrp-btn hrp-btn-primary">
    Update Invoice
  </button>
  <a href="<?php echo e(route('invoices.index')); ?>" class="hrp-btn hrp-btn-secondary">
    Cancel
  </a>
</div>

</form>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
  // Initialize date picker
  $(document).ready(function() {
    $('.date-picker').datepicker({
      dateFormat: 'dd/mm/yy', // In jQuery UI, 'yy' means 4-digit year
      changeMonth: true,
      changeYear: true,
      yearRange: '-10:+10',
      showButtonPanel: true,
      beforeShow: function(input, inst) {
        setTimeout(function() {
          inst.dpDiv.css({
            marginTop: '2px',
            marginLeft: '0px'
          });
        }, 0);
      }
    });
  });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/invoices/edit.blade.php ENDPATH**/ ?>