<?php $__env->startSection('page_title', 'Invoice List'); ?>
<?php $__env->startSection('content'); ?>

<!-- Filter Row -->
<form method="GET" action="<?php echo e(route('invoices.index')); ?>" class="jv-filter performa-filter">
  <input type="text" name="search" placeholder="Search Invoice No, Company..." class="filter-pill" value="<?php echo e(request('search')); ?>" />
  <select name="invoice_type" class="filter-pill">
    <option value="">All Types</option>
    <option value="gst" <?php echo e(request('invoice_type') == 'gst' ? 'selected' : ''); ?>>GST Invoice</option>
    <option value="without_gst" <?php echo e(request('invoice_type') == 'without_gst' ? 'selected' : ''); ?>>Without GST</option>
  </select>
  <input type="text" name="from_date" placeholder="From : dd/mm/yyyy" class="filter-pill date-picker" value="<?php echo e(request('from_date')); ?>" autocomplete="off" />
  <input type="text" name="to_date" placeholder="To : dd/mm/yyyy" class="filter-pill date-picker" value="<?php echo e(request('to_date')); ?>" autocomplete="off" />
  <button type="submit" class="filter-search" aria-label="Search">
    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
    </svg>
  </button>
  <div class="filter-right">
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Invoices Management.export invoice')): ?>
      <a href="<?php echo e(route('invoices.export', request()->only(['search','invoice_type','from_date','to_date']))); ?>" class="pill-btn pill-success">Excel</a>
      <a href="<?php echo e(route('invoices.export.csv', request()->only(['search','invoice_type','from_date','to_date']))); ?>" class="pill-btn pill-success">CSV</a>
    <?php endif; ?>
  </div>
</form>

<!-- Data Table -->
<div class="JV-datatble JV-datatble--zoom striped-surface striped-surface--full table-wrap pad-none">
  <table>
    <thead>
      <tr>
        <th style="text-align: center;">Action</th>
        <th>Serial No.</th>
        <th><?php if (isset($component)) { $__componentOriginal9f94e1f2665f26428c518049f3c9052b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f94e1f2665f26428c518049f3c9052b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sortable-header','data' => ['column' => 'unique_code','title' => 'Invoice No']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sortable-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'unique_code','title' => 'Invoice No']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sortable-header','data' => ['column' => 'invoice_date','title' => 'Invoice Date']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sortable-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'invoice_date','title' => 'Invoice Date']); ?>
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
        <th>Proforma No</th>
        <th><?php if (isset($component)) { $__componentOriginal9f94e1f2665f26428c518049f3c9052b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f94e1f2665f26428c518049f3c9052b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sortable-header','data' => ['column' => 'company_name','title' => 'Bill To']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sortable-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'company_name','title' => 'Bill To']); ?>
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
        <th>Mobile No.</th>
        <th>Grand Total</th>
        <th><?php if (isset($component)) { $__componentOriginal9f94e1f2665f26428c518049f3c9052b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f94e1f2665f26428c518049f3c9052b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sortable-header','data' => ['column' => 'total_tax_amount','title' => 'Total Tax']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sortable-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'total_tax_amount','title' => 'Total Tax']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sortable-header','data' => ['column' => 'final_amount','title' => 'Total Amount']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sortable-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['column' => 'final_amount','title' => 'Total Amount']); ?>
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
      </tr>
    </thead>
    <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <tr>
        <td style="text-align: center; vertical-align: middle;">
          <div class="action-icons">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Invoices Management.view invoice')): ?>
              <a href="<?php echo e(route('invoices.show', $invoice->id)); ?>" title="View Invoice" aria-label="View Invoice">
                <img class="action-icon" src="<?php echo e(asset('action_icon/view.svg')); ?>" alt="View">
              </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Invoices Management.edit invoice')): ?>
              <a href="<?php echo e(route('invoices.edit', $invoice->id)); ?>" title="Edit Invoice" aria-label="Edit Invoice">
                <img class="action-icon" src="<?php echo e(asset('action_icon/edit.svg')); ?>" alt="Edit">
              </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Invoices Management.print invoice')): ?>
              <a href="<?php echo e(route('invoices.print', $invoice->id)); ?>" target="_blank" title="Print Invoice" aria-label="Print Invoice">
                <img class="action-icon" src="<?php echo e(asset('action_icon/print.svg')); ?>" alt="Print">
              </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Invoices Management.delete invoice')): ?>
              <button type="button" onclick="confirmDelete(<?php echo e($invoice->id); ?>)" title="Delete Invoice" aria-label="Delete Invoice">
                <img class="action-icon" src="<?php echo e(asset('action_icon/delete.svg')); ?>" alt="Delete">
              </button>
            <?php endif; ?>
          </div>
        </td>
        <td><?php echo e($invoices->firstItem() + $index); ?></td>
        <td><?php echo e($invoice->unique_code); ?></td>
        <td><?php echo e($invoice->invoice_date ? $invoice->invoice_date->format('d-m-Y') : '-'); ?></td>
        <td>
          <?php if($invoice->invoice_type == 'gst'): ?>
            <span style="background: #E8F0FC; color: #456DB5; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">GST</span>
          <?php else: ?>
            <span style="background: #FEF3C7; color: #92400E; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Without GST</span>
          <?php endif; ?>
        </td>
        <td><?php echo e($invoice->proforma ? $invoice->proforma->unique_code : '-'); ?></td>
        <td><?php echo e($invoice->company_name); ?></td>
        <td><?php echo e($invoice->mobile_no ?? '-'); ?></td>
        <td>₹<?php echo e(number_format($invoice->sub_total ?? 0, 2)); ?></td>
        <td>₹<?php echo e(number_format($invoice->total_tax_amount ?? 0, 2)); ?></td>
        <td>₹<?php echo e(number_format($invoice->final_amount ?? 0, 2)); ?></td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <tr>
        <td colspan="11" class="text-center py-4">No invoices found</td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_pagination'); ?>
  <?php if(isset($invoices) && method_exists($invoices,'links')): ?>
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
  <?php echo e($invoices->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv')); ?>

  <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
  <a class="hrp-bc-home" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="<?php echo e(route('invoices.index')); ?>">Invoices</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Invoice List</span>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

<script>
function confirmDelete(id) {
  Swal.fire({
    title: 'Delete this invoice?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel',
    width: '400px'
  }).then((result) => {
    if (result.isConfirmed) {
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = `/GitVraj/HrPortal/invoices/${id}`;
      form.innerHTML = `
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
        <input type="hidden" name="_method" value="DELETE">
      `;
      document.body.appendChild(form);
      form.submit();
    }
  });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/invoices/index.blade.php ENDPATH**/ ?>