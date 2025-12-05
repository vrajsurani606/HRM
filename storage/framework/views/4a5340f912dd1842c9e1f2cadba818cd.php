<?php $__env->startSection('page_title', 'Quotation Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="inquiry-index-container">
  
  <!-- Header Section -->
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
      <h2 style="margin: 0; font-size: 24px; font-weight: 700; color: #111827;"></h2>
      <p style="margin: 4px 0 0 0; color: #6b7280; font-size: 14px;"></p>
    </div>
    <div style="display: flex; gap: 10px;">
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Quotations Management.edit quotation')): ?>
        <a href="<?php echo e(route('quotations.edit', $quotation->id)); ?>" class="pill-btn" style="background:#3b82f6;color:#ffffff;padding:10px 20px;">
          Edit
        </a>
      <?php endif; ?>
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Quotations Management.print quotation')): ?>
        <a href="<?php echo e(route('quotations.download', $quotation->id)); ?>" class="pill-btn pill-success" style="padding:10px 20px;" target="_blank">
          Print PDF
        </a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Main Content Grid -->
  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
    
    <!-- Company Information Card -->
    <div class="Rectangle-30 hrp-compact">
      <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 600; color: #111827; border-bottom: 2px solid #e5e7eb; padding-bottom: 12px;">
        Company Information
      </h3>
      <div style="display: grid; gap: 12px;">
        <div>
          <label style="font-size: 12px; color: #6b7280; font-weight: 500;">Company Name</label>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: #111827;"><?php echo e($quotation->company_name ?? 'N/A'); ?></p>
        </div>
        <div>
          <label style="font-size: 12px; color: #6b7280; font-weight: 500;">GST No</label>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: #111827;"><?php echo e($quotation->gst_no ?? 'N/A'); ?></p>
        </div>
        <div>
          <label style="font-size: 12px; color: #6b7280; font-weight: 500;">PAN No</label>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: #111827;"><?php echo e($quotation->pan_no ?? 'N/A'); ?></p>
        </div>
        <div>
          <label style="font-size: 12px; color: #6b7280; font-weight: 500;">Address</label>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: #111827;"><?php echo e($quotation->address ?? 'N/A'); ?></p>
        </div>
        <div>
          <label style="font-size: 12px; color: #6b7280; font-weight: 500;">City</label>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: #111827;"><?php echo e($quotation->city ?? 'N/A'); ?></p>
        </div>
      </div>
    </div>

    <!-- Quotation Details Card -->
    <div class="Rectangle-30 hrp-compact">
      <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 600; color: #111827; border-bottom: 2px solid #e5e7eb; padding-bottom: 12px;">
        Quotation Details
      </h3>
      <div style="display: grid; gap: 12px;">
        <div>
          <label style="font-size: 12px; color: #6b7280; font-weight: 500;">Quotation Code</label>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: #111827; font-weight: 600;"><?php echo e($quotation->unique_code ?? 'N/A'); ?></p>
        </div>
        <div>
          <label style="font-size: 12px; color: #6b7280; font-weight: 500;">Quotation Date</label>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: #111827;"><?php echo e($quotation->quotation_date ? \Carbon\Carbon::parse($quotation->quotation_date)->format('d/m/Y') : 'N/A'); ?></p>
        </div>
        <div>
          <label style="font-size: 12px; color: #6b7280; font-weight: 500;">Status</label>
          <p style="margin: 4px 0 0 0;">
            <span style="display: inline-block; padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; background: <?php echo e($quotation->status === 'confirmed' ? '#d1fae5' : '#fef3c7'); ?>; color: <?php echo e($quotation->status === 'confirmed' ? '#065f46' : '#92400e'); ?>;">
              <?php echo e(ucfirst($quotation->status ?? 'Draft')); ?>

            </span>
          </p>
        </div>
        <div>
          <label style="font-size: 12px; color: #6b7280; font-weight: 500;">Contract Amount</label>
          <p style="margin: 4px 0 0 0; font-size: 18px; color: #111827; font-weight: 700;"><?php echo e($quotation->contract_amount ? '₹ ' . number_format($quotation->contract_amount, 2) : 'N/A'); ?></p>
        </div>
        <div>
          <label style="font-size: 12px; color: #6b7280; font-weight: 500;">Tentative Completion</label>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: #111827;"><?php echo e($quotation->tentative_complete_date ? \Carbon\Carbon::parse($quotation->tentative_complete_date)->format('d/m/Y') : 'N/A'); ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Contact Information -->
  <div class="Rectangle-30 hrp-compact" style="margin-bottom: 24px;">
    <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 600; color: #111827; border-bottom: 2px solid #e5e7eb; padding-bottom: 12px;">
      Contact Information
    </h3>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
      <div style="display: grid; gap: 12px;">
        <div>
          <label style="font-size: 12px; color: #6b7280; font-weight: 500;">Contact Person</label>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: #111827;"><?php echo e($quotation->contact_person_1 ?? 'N/A'); ?></p>
        </div>
        <div>
          <label style="font-size: 12px; color: #6b7280; font-weight: 500;">Position</label>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: #111827;"><?php echo e($quotation->position_1 ?? 'N/A'); ?></p>
        </div>
        <div>
          <label style="font-size: 12px; color: #6b7280; font-weight: 500;">Contact Number</label>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: #111827;"><?php echo e($quotation->contact_number_1 ?? 'N/A'); ?></p>
        </div>
      </div>
      <div style="display: grid; gap: 12px;">
        <div>
          <label style="font-size: 12px; color: #6b7280; font-weight: 500;">Email</label>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: #111827;"><?php echo e($quotation->company_email ?? 'N/A'); ?></p>
        </div>
        <div>
          <label style="font-size: 12px; color: #6b7280; font-weight: 500;">Project Start Date</label>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: #111827;"><?php echo e($quotation->project_start_date ? \Carbon\Carbon::parse($quotation->project_start_date)->format('d/m/Y') : 'N/A'); ?></p>
        </div>
        <div>
          <label style="font-size: 12px; color: #6b7280; font-weight: 500;">Nature of Work</label>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: #111827;"><?php echo e($quotation->nature_of_work ?? 'N/A'); ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Scope of Work -->
  <?php if($quotation->scope_of_work): ?>
  <div class="Rectangle-30 hrp-compact" style="margin-bottom: 24px;">
    <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 600; color: #111827; border-bottom: 2px solid #e5e7eb; padding-bottom: 12px;">
      Scope of Work
    </h3>
    <div style="padding: 16px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
      <p style="margin: 0; font-size: 14px; color: #374151; line-height: 1.6; white-space: pre-wrap;"><?php echo e($quotation->scope_of_work); ?></p>
    </div>
  </div>
  <?php endif; ?>

  <!-- Contract Document -->
  <?php if($quotation->contract_copy_path): ?>
  <div class="Rectangle-30 hrp-compact" style="margin-bottom: 24px;">
    <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 600; color: #111827; border-bottom: 2px solid #e5e7eb; padding-bottom: 12px;">
      Contract Document
    </h3>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Quotations Management.contract generate')): ?>
      <a href="<?php echo e(route('quotations.view-contract-file', $quotation->id)); ?>" target="_blank" class="pill-btn pill-success" style="padding:10px 20px;">
        View Contract Document
      </a>
    <?php endif; ?>
  </div>
  <?php endif; ?>

  <!-- Custom Terms & Conditions -->
  <?php if($quotation->custom_terms_and_conditions && count($quotation->custom_terms_and_conditions) > 0): ?>
  <div class="Rectangle-30 hrp-compact" style="margin-bottom: 24px;">
    <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 600; color: #111827; border-bottom: 2px solid #e5e7eb; padding-bottom: 12px;">
      Custom Terms & Conditions
    </h3>
    <div style="padding: 16px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
      <ol style="margin: 0; padding-left: 20px; font-size: 14px; color: #374151; line-height: 1.8;">
        <?php $__currentLoopData = $quotation->custom_terms_and_conditions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if(trim($term)): ?>
            <li style="margin-bottom: 8px;"><?php echo e(trim($term)); ?></li>
          <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ol>
    </div>
  </div>
  <?php endif; ?>

  <!-- Action Buttons -->
  <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 30px;">
    <a href="<?php echo e(route('quotations.index')); ?>" class="pill-btn" style="background:#6b7280;color:#ffffff;padding:10px 20px;">
      ← Back to List
    </a>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Quotations Management.follow up create')): ?>
      <a href="<?php echo e(route('quotation.follow-up', $quotation->id)); ?>" class="pill-btn" style="background:#f59e0b;color:#ffffff;padding:10px 20px;">
        Follow Up
      </a>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Quotations Management.template list')): ?>
      <a href="<?php echo e(route('quotations.template-list', $quotation->id)); ?>" class="pill-btn pill-success" style="padding:10px 20px;">
        View Templates
      </a>
    <?php endif; ?>
  </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
  <a class="hrp-bc-home" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="<?php echo e(route('quotations.index')); ?>" style="font-weight:800;color:#0f0f0f;text-decoration:none">Quotation Management</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current"><?php echo e($quotation->unique_code); ?></span>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/quotations/show.blade.php ENDPATH**/ ?>