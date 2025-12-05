

<?php $__env->startSection('page_title','Inquiry Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="Rectangle-30 hrp-compact">
  <div class="mb-4 flex items-center justify-between">
    <h1 class="text-lg font-semibold">Inquiry Details - <?php echo e($inquiry->unique_code); ?></h1>
    <a href="<?php echo e(route('inquiries.index')); ?>" class="pill-btn pill-secondary">Back to List</a>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
    <div>
      <label class="hrp-label">Inquiry Date</label>
      <div class="Rectangle-29"><?php echo e(optional($inquiry->inquiry_date)->format('d-m-Y')); ?></div>
    </div>
    <div>
      <label class="hrp-label">Industry Type</label>
      <div class="Rectangle-29"><?php echo e($inquiry->industry_type); ?></div>
    </div>

    <div>
      <label class="hrp-label">Company Name</label>
      <div class="Rectangle-29"><?php echo e($inquiry->company_name); ?></div>
    </div>
    <div>
      <label class="hrp-label">Company Mobile</label>
      <div class="Rectangle-29"><?php echo e($inquiry->company_phone); ?></div>
    </div>

    <div class="md:col-span-2">
      <label class="hrp-label">Company Address</label>
      <div class="Rectangle-29 Rectangle-29-textarea"><?php echo e($inquiry->company_address); ?></div>
    </div>

    <div>
      <label class="hrp-label">City</label>
      <div class="Rectangle-29"><?php echo e($inquiry->city); ?></div>
    </div>
    <div>
      <label class="hrp-label">State</label>
      <div class="Rectangle-29"><?php echo e($inquiry->state); ?></div>
    </div>

    <div>
      <label class="hrp-label">Contact Person Name</label>
      <div class="Rectangle-29"><?php echo e($inquiry->contact_name); ?></div>
    </div>
    <div>
      <label class="hrp-label">Contact Person Mobile</label>
      <div class="Rectangle-29"><?php echo e($inquiry->contact_mobile); ?></div>
    </div>

    <div>
      <label class="hrp-label">Contact Person Position</label>
      <div class="Rectangle-29"><?php echo e($inquiry->contact_position); ?></div>
    </div>
    <div>
      <label class="hrp-label">Email</label>
      <div class="Rectangle-29"><?php echo e($inquiry->email); ?></div>
    </div>

    <div class="md:col-span-2">
      <label class="hrp-label">Scope Link</label>
      <div class="Rectangle-29">
        <?php if($inquiry->scope_link): ?>
          <a href="<?php echo e($inquiry->scope_link); ?>" target="_blank" class="scope-link"><?php echo e($inquiry->scope_link); ?></a>
        <?php else: ?>
          —
        <?php endif; ?>
      </div>
    </div>

    <div>
      <label class="hrp-label">Quotation Sent</label>
      <div class="Rectangle-29"><?php echo e($inquiry->quotation_sent ?: '—'); ?></div>
    </div>
    <div>
      <label class="hrp-label">Quotation File</label>
      <div class="Rectangle-29">
        <?php if($inquiry->quotation_file): ?>
          <a href="<?php echo e(url('public/storage/'.$inquiry->quotation_file)); ?>" target="_blank" class="scope-link">View File</a>
        <?php else: ?>
          —
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
  <a class="hrp-bc-home" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="<?php echo e(route('inquiries.index')); ?>" style="font-weight:800;color:#0f0f0f;text-decoration:none">Inquiries</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Inquiry Details</span>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/inquiries/show.blade.php ENDPATH**/ ?>