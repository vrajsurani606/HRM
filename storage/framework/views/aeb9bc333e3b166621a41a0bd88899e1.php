<?php $__empty_1 = true; $__currentLoopData = $inquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $inquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php
  $highlightTodayDemo = in_array($inquiry->id, (array)($todayScheduledInquiryIds ?? []));
?>
<tr <?php if($highlightTodayDemo): ?> style="background-color:#fff7ed;" <?php endif; ?>>
  <td>
    <div class="action-icons">
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Inquiries Management.view inquiry')): ?>
        <a href="<?php echo e(route('inquiries.show', $inquiry->id)); ?>" title="View Inquiry" aria-label="View Inquiry">
          <img class="action-icon" src="<?php echo e(asset('action_icon/view.svg')); ?>" alt="Show">
        </a>
      <?php endif; ?>

      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Inquiries Management.edit inquiry')): ?>
        <a href="<?php echo e(route('inquiries.edit', $inquiry->id)); ?>" title="Edit Inquiry" aria-label="Edit Inquiry">
          <img class="action-icon" src="<?php echo e(asset('action_icon/edit.svg')); ?>" alt="Edit">
        </a>
      <?php endif; ?>

      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Inquiries Management.delete inquiry')): ?>
        <form method="POST" action="<?php echo e(route('inquiries.destroy', $inquiry->id)); ?>" class="delete-form" style="display:inline">
          <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
          <button type="button" onclick="confirmDeleteInquiry(this)" title="Delete Inquiry" aria-label="Delete Inquiry" style="background:transparent;border:0;padding:0;line-height:0;cursor:pointer">
            <img class="action-icon" src="<?php echo e(asset('action_icon/delete.svg')); ?>" alt="Delete">
          </button>
        </form>
      <?php endif; ?>

      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Inquiries Management.follow up')): ?>
        <a href="<?php echo e(route('inquiry.follow-up', $inquiry->id)); ?>" title="Follow Up" aria-label="Follow Up">
          <img class="action-icon" src="<?php echo e(asset('action_icon/follow-up.svg')); ?>" alt="Follow Up">
        </a>
      <?php endif; ?>

      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Quotations Management.create quotation')): ?>
        <a href="<?php echo e(route('quotation.create-from-inquiry', $inquiry->id)); ?>" title="Make Quotation" aria-label="Make Quotation">
          <img class="action-icon" src="<?php echo e(asset('action_icon/make-quatation.svg')); ?>" alt="Make Quotation">
        </a>
      <?php endif; ?>
    </div>
  </td>
  <td>
    <?php ($sno = ($inquiries->currentPage()-1) * $inquiries->perPage() + $index + 1); ?>
    <?php echo e($sno); ?>

  </td>
  <td><?php echo e($inquiry->unique_code); ?></td>
  <td><?php echo e($inquiry->inquiry_date->format('d-m-Y')); ?></td>
  <td><?php echo e($inquiry->company_name); ?></td>
  <td><?php echo e($inquiry->company_phone); ?></td>
  <td><?php echo e(Str::limit($inquiry->company_address, 30)); ?></td>
  <td><?php echo e($inquiry->contact_name); ?></td>
  <td><?php echo e($inquiry->contact_position); ?></td>
  <td><?php echo e($inquiry->industry_type); ?></td>
  <td>
    <?php echo e(optional(optional($inquiry->followUps->first())->next_followup_date)->format('d-m-Y')); ?>

  </td>
  <td style="text-align:center;">
    <?php if($inquiry->followUps && $inquiry->followUps->count() > 0): ?>
      <?php ($latestFollowUp = $inquiry->followUps->first()); ?>
      <?php if($latestFollowUp && $latestFollowUp->is_confirm): ?>
        <div style="width: 24px; height: 24px; background: #10b981; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;" title="Confirmed">
          <span style="color: white; font-size: 14px; font-weight: bold;">✓</span>
        </div>
      <?php elseif($latestFollowUp): ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Inquiries Management.follow up confirm')): ?>
          <button type="button" class="confirm-followup-btn" data-followup-id="<?php echo e($latestFollowUp->id); ?>" data-row-id="<?php echo e($inquiry->id); ?>" title="Click to Confirm" aria-label="Click to Confirm" style="background:transparent;border:0;padding:0;cursor:pointer;">
            <div style="width: 24px; height: 24px; background: #ef4444; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
              <span style="color: white; font-size: 14px; font-weight: bold;">✗</span>
            </div>
          </button>
        <?php else: ?>
          <div style="width: 24px; height: 24px; background: #ef4444; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;" title="Not Confirmed">
            <span style="color: white; font-size: 14px; font-weight: bold;">✗</span>
          </div>
        <?php endif; ?>
      <?php endif; ?>
    <?php else: ?>
      <div style="width: 24px; height: 24px; background: #ef4444; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;" title="No Follow Up">
        <span style="color: white; font-size: 14px; font-weight: bold;">✗</span>
      </div>
    <?php endif; ?>
  </td>
  <td><a href="<?php echo e($inquiry->scope_link); ?>" class="scope-link">View</a></td>
  <td>
    <?php if($inquiry->quotation_file): ?>
      <a href="<?php echo e(url('public/storage/'.$inquiry->quotation_file)); ?>" target="_blank" class="scope-link">View</a>
    <?php else: ?>
      —
    <?php endif; ?>
  </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr>
  <td colspan="14" class="no-data">No inquiries found</td>
</tr>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/inquiries/partials/table_rows.blade.php ENDPATH**/ ?>