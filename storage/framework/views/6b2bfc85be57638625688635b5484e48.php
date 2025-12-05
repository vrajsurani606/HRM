<?php $__env->startSection('page_title', 'Receipt List'); ?>
<?php $__env->startSection('content'); ?>

<!-- Filter Row -->
<form method="GET" action="<?php echo e(route('receipts.index')); ?>" class="jv-filter performa-filter">
  <input type="text" name="search" placeholder="Search Receipt No, Company..." class="filter-pill" value="<?php echo e(request('search')); ?>" />
  <select name="invoice_type" class="filter-pill">
    <option value="">All Types</option>
    <option value="gst" <?php echo e(request('invoice_type') == 'gst' ? 'selected' : ''); ?>>GST Invoice</option>
    <option value="without_gst" <?php echo e(request('invoice_type') == 'without_gst' ? 'selected' : ''); ?>>Without GST Invoice</option>
  </select>
  <input type="text" name="from_date" placeholder="From : dd/mm/yyyy" class="filter-pill date-picker" value="<?php echo e(request('from_date')); ?>" autocomplete="off" />
  <input type="text" name="to_date" placeholder="To : dd/mm/yyyy" class="filter-pill date-picker" value="<?php echo e(request('to_date')); ?>" autocomplete="off" />
  <button type="submit" class="filter-search" aria-label="Search">
    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
    </svg>
  </button>
  <div class="filter-right">
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Receipts Management.export receipt')): ?>
      <a href="<?php echo e(route('receipts.export.csv', request()->only(['search','invoice_type','from_date','to_date']))); ?>" class="pill-btn pill-success">Excel</a>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Receipts Management.create receipt')): ?>
      <a href="<?php echo e(route('receipts.create')); ?>" class="pill-btn pill-success">+ Add</a>
    <?php endif; ?>
  </div>
</form>

<!-- Data Table -->
<div class="JV-datatble JV-datatble--zoom striped-surface striped-surface--full table-wrap pad-none">
  <table>
    <thead>
      <tr>
        <th>Action</th>
        <th>Serial No.</th>
        <th><?php if (isset($component)) { $__componentOriginal9f94e1f2665f26428c518049f3c9052b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f94e1f2665f26428c518049f3c9052b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sortable-header','data' => ['column' => 'unique_code','title' => 'Receipt No']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sortable-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'unique_code','title' => 'Receipt No']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f94e1f2665f26428c518049f3c9052b)): ?>
<?php $attributes = $__attributesOriginal9f94e1f2665f26428c518049f3c9052b; ?>
<?php unset($__attributesOriginal9f94e1f2665f26428c518049f3c9052b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f94e1f2665f26428c518049f3c9052b)): ?>
<?php $component = $__componentOriginal9f94e1f2665f26428c518049f3c9052b; ?>
<?php unset($__componentOriginal9f94e1f2665f26428c518049f3c9052b); ?>
<?php endif; ?></th>
        <th><?php if (isset($component)) { $__componentOriginal9f94e1f2665f26428c518049f3c9052b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f94e1f2665f26428c518049f3c9052b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sortable-header','data' => ['column' => 'receipt_date','title' => 'Receipt Date']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sortable-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'receipt_date','title' => 'Receipt Date']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f94e1f2665f26428c518049f3c9052b)): ?>
<?php $attributes = $__attributesOriginal9f94e1f2665f26428c518049f3c9052b; ?>
<?php unset($__attributesOriginal9f94e1f2665f26428c518049f3c9052b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f94e1f2665f26428c518049f3c9052b)): ?>
<?php $component = $__componentOriginal9f94e1f2665f26428c518049f3c9052b; ?>
<?php unset($__componentOriginal9f94e1f2665f26428c518049f3c9052b); ?>
<?php endif; ?></th>
        <th><?php if (isset($component)) { $__componentOriginal9f94e1f2665f26428c518049f3c9052b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f94e1f2665f26428c518049f3c9052b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sortable-header','data' => ['column' => 'invoice_type','title' => 'Invoice Type']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sortable-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'invoice_type','title' => 'Invoice Type']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f94e1f2665f26428c518049f3c9052b)): ?>
<?php $attributes = $__attributesOriginal9f94e1f2665f26428c518049f3c9052b; ?>
<?php unset($__attributesOriginal9f94e1f2665f26428c518049f3c9052b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f94e1f2665f26428c518049f3c9052b)): ?>
<?php $component = $__componentOriginal9f94e1f2665f26428c518049f3c9052b; ?>
<?php unset($__componentOriginal9f94e1f2665f26428c518049f3c9052b); ?>
<?php endif; ?></th>
        <th><?php if (isset($component)) { $__componentOriginal9f94e1f2665f26428c518049f3c9052b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f94e1f2665f26428c518049f3c9052b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sortable-header','data' => ['column' => 'company_name','title' => 'Company Name']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sortable-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'company_name','title' => 'Company Name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f94e1f2665f26428c518049f3c9052b)): ?>
<?php $attributes = $__attributesOriginal9f94e1f2665f26428c518049f3c9052b; ?>
<?php unset($__attributesOriginal9f94e1f2665f26428c518049f3c9052b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f94e1f2665f26428c518049f3c9052b)): ?>
<?php $component = $__componentOriginal9f94e1f2665f26428c518049f3c9052b; ?>
<?php unset($__componentOriginal9f94e1f2665f26428c518049f3c9052b); ?>
<?php endif; ?></th>
        <th><?php if (isset($component)) { $__componentOriginal9f94e1f2665f26428c518049f3c9052b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f94e1f2665f26428c518049f3c9052b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sortable-header','data' => ['column' => 'received_amount','title' => 'Received Amount']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sortable-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'received_amount','title' => 'Received Amount']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f94e1f2665f26428c518049f3c9052b)): ?>
<?php $attributes = $__attributesOriginal9f94e1f2665f26428c518049f3c9052b; ?>
<?php unset($__attributesOriginal9f94e1f2665f26428c518049f3c9052b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f94e1f2665f26428c518049f3c9052b)): ?>
<?php $component = $__componentOriginal9f94e1f2665f26428c518049f3c9052b; ?>
<?php unset($__componentOriginal9f94e1f2665f26428c518049f3c9052b); ?>
<?php endif; ?></th>
        <th>Payment Type</th>
        <th>Trans Code</th>
      </tr>
    </thead>
    <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $receipts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $receipt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <tr>
        <td>
          <div class="action-icons">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Receipts Management.view receipt')): ?>
              <a href="<?php echo e(route('receipts.show', $receipt->id)); ?>">
                <img class="action-icon" src="<?php echo e(asset('action_icon/view.svg')); ?>" alt="View">
              </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Receipts Management.edit receipt')): ?>
              <a href="<?php echo e(route('receipts.edit', $receipt->id)); ?>">
                <img class="action-icon" src="<?php echo e(asset('action_icon/edit.svg')); ?>" alt="Edit">
              </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Receipts Management.print receipt')): ?>
              <a href="<?php echo e(route('receipts.print', $receipt->id)); ?>" target="_blank">
                <img class="action-icon" src="<?php echo e(asset('action_icon/print.svg')); ?>" alt="Print">
              </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Receipts Management.delete receipt')): ?>
              <form action="<?php echo e(route('receipts.destroy', $receipt->id)); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this receipt?');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" style="border:none;background:none;padding:0;cursor:pointer;">
                  <img class="action-icon" src="<?php echo e(asset('action_icon/delete.svg')); ?>" alt="Delete">
                </button>
              </form>
            <?php endif; ?>
          </div>
        </td>
        <td><?php echo e($receipts->firstItem() + $index); ?></td>
        <td><?php echo e($receipt->unique_code); ?></td>
        <td><?php echo e($receipt->receipt_date ? $receipt->receipt_date->format('d-m-Y') : '-'); ?></td>
        <td>
          <?php if($receipt->invoice_type == 'gst'): ?>
            <span style="display: inline-block; padding: 4px 8px; background: #DBEAFE; color: #1E40AF; border-radius: 4px; font-size: 12px; font-weight: 600;">GST</span>
          <?php elseif($receipt->invoice_type == 'without_gst'): ?>
            <span style="display: inline-block; padding: 4px 8px; background: #FEF3C7; color: #92400E; border-radius: 4px; font-size: 12px; font-weight: 600;">Without GST</span>
          <?php else: ?>
            <span style="color: #9ca3af;">-</span>
          <?php endif; ?>
        </td>
        <td><?php echo e($receipt->company_name); ?></td>
        <td>₹<?php echo e(number_format($receipt->received_amount ?? 0, 2)); ?></td>
        <td><?php echo e($receipt->payment_type ?? '-'); ?></td>
        <td><?php echo e($receipt->trans_code ?? '-'); ?></td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <tr>
        <td colspan="9" class="text-center py-4">No receipts found</td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_pagination'); ?>
  <?php if(isset($receipts) && method_exists($receipts,'links')): ?>
  <form method="GET" class="hrp-entries-form">
    <span>Entries</span>
    <?php ($currentPerPage = (int) request()->get('per_page', 10)); ?>
    <select name="per_page" onchange="this.form.submit()">
      <?php $__currentLoopData = [10,25,50,100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($size); ?>" <?php echo e($currentPerPage === $size ? 'selected' : ''); ?>><?php echo e($size); ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <?php $__currentLoopData = request()->except(['per_page','page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <input type="hidden" name="<?php echo e($k); ?>" value="<?php echo e($v); ?>">
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </form>
  <?php echo e($receipts->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv')); ?>

  <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
// Initialize jQuery datepicker
$(document).ready(function() {
    $('.date-picker').datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '-10:+10',
        showButtonPanel: true,
        beforeShow: function(input, inst) {
            setTimeout(function() {
                inst.dpDiv.css({ marginTop: '2px', marginLeft: '0px' });
            }, 0);
        }
    });
});

// Convert dates before form submission
document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('.performa-filter');
    if(form){
        form.addEventListener('submit', function(e){
            var fromDate = document.querySelector('input[name="from_date"]');
            var toDate = document.querySelector('input[name="to_date"]');
            
            if(fromDate && fromDate.value){
                var parts = fromDate.value.split('/');
                if(parts.length === 3) fromDate.value = parts[2] + '-' + parts[1] + '-' + parts[0];
            }
            if(toDate && toDate.value){
                var parts = toDate.value.split('/');
                if(parts.length === 3) toDate.value = parts[2] + '-' + parts[1] + '-' + parts[0];
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/receipts/index.blade.php ENDPATH**/ ?>