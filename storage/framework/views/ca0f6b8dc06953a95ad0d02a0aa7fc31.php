
<?php $__env->startSection('page_title', 'Template List'); ?>

<?php $__env->startSection('content'); ?>
<div class="inquiry-index-container">
  
  
  <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
    <table style="table-layout: auto; width: 100%;">
      <colgroup>
        <col style="width: 80px;">
        <col style="width: 180px;">
        <col style="width: 100px;">
        <col style="width: auto;">
        <col style="width: 150px;">
        <col style="width: 150px;">
        <col style="width: 120px;">
        <col style="width: 150px;">
      </colgroup>
        <thead>
          <tr>
            <th>Sr.No.</th>
            <th style="text-align: center;">Action</th>
            <th>Status</th>
            <th>Company Name</th>
            <th>GST No</th>
            <th>Description</th>
            <th>Amount</th>
            <th>Completion Term</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <?php
            $proformaGenerated = $quotation->proformas->where('type_of_billing', $template['description'])->first();
          ?>
          <tr>
            <td><?php echo e($loop->iteration); ?></td>
            <td style="text-align: center; vertical-align: middle;">
              <div class="action-icons">
                <?php if($proformaGenerated): ?>
                  <a href="<?php echo e(route('performas.show', $proformaGenerated->id)); ?>" title="View Proforma" aria-label="View Proforma">
                    <img class="action-icon" src="<?php echo e(asset('action_icon/view.svg')); ?>" alt="View">
                  </a>
                  <a href="<?php echo e(route('performas.edit', $proformaGenerated->id)); ?>" title="Edit Proforma" aria-label="Edit Proforma">
                    <img class="action-icon" src="<?php echo e(asset('action_icon/edit.svg')); ?>" alt="Edit">
                  </a>
                <?php else: ?>
                  <a href="<?php echo e(route('quotations.create-proforma', ['id' => $quotation->id, 'template' => $template['index']])); ?>" 
                     title="Generate Proforma" aria-label="Generate Proforma"
                     style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #10b981; border-radius: 50%; text-decoration: none;">
                    <svg width="16" height="16" fill="white" viewBox="0 0 24 24">
                      <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                  </a>
                <?php endif; ?>
              </div>
            </td>
            <td>
              <?php if($proformaGenerated): ?>
                <div style="width: 20px; height: 20px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                  <span style="color: white; font-size: 12px;">✓</span>
                </div>
              <?php else: ?>
                <div style="width: 20px; height: 20px; background: #f59e0b; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                  <span style="color: white; font-size: 12px;">⏳</span>
                </div>
              <?php endif; ?>
            </td>
            <td><?php echo e($quotation->company_name); ?></td>
            <td><?php echo e($quotation->gst_no ?? 'N/A'); ?></td>
            <td><?php echo e($template['description']); ?></td>
            <td>₹ <?php echo e(number_format($template['amount'], 2)); ?></td>
            <td>
              <?php if($template['completion_percent']): ?>
                <?php echo e($template['completion_percent']); ?>%
              <?php endif; ?>
              <?php if($template['completion_terms']): ?>
                - <?php echo e($template['completion_terms']); ?>

              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <?php endif; ?>
        </tbody>
      </table>
      
      <?php if(count($templates) === 0): ?>
      <div style="padding: 80px 20px; text-align: center; background: #ffffff;">
        <div style="max-width: 500px; margin: 0 auto;">
          <div style="width: 80px; height: 80px; background: #fef3c7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
            <svg width="40" height="40" fill="#f59e0b" viewBox="0 0 24 24">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
            </svg>
          </div>
          <h4 style="margin: 0 0 12px 0; font-size: 18px; font-weight: 600; color: #111827;">No Payment Terms Defined</h4>
          <p style="margin: 0 0 24px 0; font-size: 14px; color: #6b7280; line-height: 1.6;">
            Please add payment terms in the quotation to generate proforma templates.
          </p>
          <a href="<?php echo e(route('quotations.edit', $quotation->id)); ?>" class="pill-btn pill-success" style="padding: 12px 24px; font-size: 14px; text-decoration: none;">
            Add Payment Terms
          </a>
        </div>
      </div>
      <?php endif; ?>
    </div>
  
  <?php if(false): ?>
  <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
    <table style="table-layout: auto; width: 100%;">
      <tbody>
        <tr>
          <td></td>
        </tr>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
  
  <?php if($quotation->proformas->count() > 0): ?>
  <div style="margin-top: 30px;">
    <h3 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 600; color: #111827;">GENERATED PROFORMAS</h3>
    <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
      <table style="table-layout: auto; width: 100%;">
        <colgroup>
          <col style="width: 150px;">
          <col style="width: 120px;">
          <col style="width: auto;">
          <col style="width: 150px;">
          <col style="width: 120px;">
        </colgroup>
          <thead>
            <tr>
              <th>Proforma Code</th>
              <th>Date</th>
              <th>Company</th>
              <th>Amount</th>
              <th style="text-align: center;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $quotation->proformas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proforma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($proforma->unique_code); ?></td>
              <td><?php echo e($proforma->proforma_date->format('d-m-Y')); ?></td>
              <td><?php echo e($proforma->company_name); ?></td>
              <td>₹ <?php echo e(number_format($proforma->final_amount, 2)); ?></td>
              <td style="text-align: center; vertical-align: middle;">
                <div class="action-icons">
                  <a href="<?php echo e(route('performas.show', $proforma->id)); ?>" title="View Proforma" aria-label="View Proforma">
                    <img class="action-icon" src="<?php echo e(asset('action_icon/view.svg')); ?>" alt="View">
                  </a>
                  <a href="<?php echo e(route('performas.edit', $proforma->id)); ?>" title="Edit Proforma" aria-label="Edit Proforma">
                    <img class="action-icon" src="<?php echo e(asset('action_icon/edit.svg')); ?>" alt="Edit">
                  </a>
                </div>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
    </div>
  </div>
  <?php endif; ?>

  <div style="margin-top: 30px; display: flex; gap: 10px;">
    <a href="<?php echo e(route('quotations.index')); ?>" class="pill-btn" style="background:#6b7280;color:#ffffff;padding:10px 20px;">← Back to Quotations</a>
    <a href="<?php echo e(route('quotations.show', $quotation->id)); ?>" class="pill-btn pill-success" style="padding:10px 20px;">View Quotation</a>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
  <a class="hrp-bc-home" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="<?php echo e(route('quotations.index')); ?>" style="font-weight:800;color:#0f0f0f;text-decoration:none">Quotation Management</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Template List</span>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/quotations/template_list.blade.php ENDPATH**/ ?>