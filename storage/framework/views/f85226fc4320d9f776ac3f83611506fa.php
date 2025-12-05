<?php $__env->startSection('page_title', 'Payroll Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="inquiry-index-container">
  <!-- JV Filter -->
  <form method="GET" action="<?php echo e(route('payroll.index')); ?>" class="jv-filter">
    <select class="filter-pill" name="month">
      <option value="">All Months</option>
      <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($month); ?>" <?php echo e(request('month') == $month ? 'selected' : ''); ?>><?php echo e($month); ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <select class="filter-pill" name="year">
      <option value="">All Years</option>
      <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($year); ?>" <?php echo e(request('year') == $year ? 'selected' : ''); ?>><?php echo e($year); ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <select class="filter-pill" name="status">
      <option value="">All Status</option>
      <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
      <option value="paid" <?php echo e(request('status') == 'paid' ? 'selected' : ''); ?>>Paid</option>
      <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
    </select>

    <select class="filter-pill" name="employee_id">
      <option value="">All Employees</option>
      <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($emp->id); ?>" <?php echo e(request('employee_id') == $emp->id ? 'selected' : ''); ?>><?php echo e($emp->name); ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <button type="submit" class="filter-search" aria-label="Search">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
      </svg>
    </button>

    <a href="<?php echo e(route('payroll.index')); ?>" class="filter-search" style="background: #6b7280;" aria-label="Reset">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
      </svg>
    </a>

    <div class="filter-right">
      <input name="q" class="filter-pill" placeholder="Search employee..." value="<?php echo e(request('q')); ?>">
      
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Payroll Management.export payroll')): ?>
      <a href="<?php echo e(route('payroll.export-csv', request()->query())); ?>" class="pill-btn pill-success">CSV</a>
      <a href="<?php echo e(route('payroll.export-excel', request()->query())); ?>" class="pill-btn pill-success">Excel</a>
      <?php endif; ?>
      
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Payroll Management.create payroll')): ?>
      <a href="<?php echo e(route('payroll.create')); ?>" class="pill-btn pill-success">+ Add</a>
      <?php endif; ?>
      
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Payroll Management.bulk generate payroll')): ?>
      <a href="<?php echo e(route('payroll.bulk')); ?>" class="pill-btn" style="background:#2563eb; color:#fff;">Bulk Generate</a>
      <?php endif; ?>
    </div>
  </form>

  <!-- List View -->
  <div class="inquiries-list-view active">
    <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
      <table>
        <thead>
          <tr>
            <th style="width: 100px; text-align: center;">Action</th>
            <th style="width: 100px; text-align: center;">EMP Code</th>
            <th style="width: 180px; text-align: center;">Employee</th>
            <th style="width: 120px; text-align: center;">Month/Year</th>
            <th style="width: 120px; text-align: center;">Basic Salary</th>
            <th style="width: 130px; text-align: center;">Total Allowance</th>
            <th style="width: 130px; text-align: center;">Total Deduction</th>
            <th style="width: 130px; text-align: center;">Net Salary</th>
            <th style="width: 100px; text-align: center;">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $payrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
              // Calculate totals
              $totalAllowances = ($payroll->hra ?? 0) + ($payroll->medical_allowance ?? 0) + 
                                ($payroll->city_allowance ?? 0) + ($payroll->tiffin_allowance ?? 0) + 
                                ($payroll->assistant_allowance ?? 0) + ($payroll->dearness_allowance ?? 0);
              $totalDeductions = ($payroll->pf ?? 0) + ($payroll->professional_tax ?? 0) + 
                                ($payroll->tds ?? 0) + ($payroll->esic ?? 0) + 
                                ($payroll->security_deposit ?? 0) + ($payroll->leave_deduction ?? 0);
              $netSalary = ($payroll->basic_salary + $totalAllowances + ($payroll->bonuses ?? 0)) - $totalDeductions;
            ?>
            <tr>
              <td style="padding: 12px 8px; text-align: center;">
                <div style="display: flex; gap: 6px; align-items: center; justify-content: center;">
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Payroll Management.view payroll')): ?>
                  <img src="<?php echo e(asset('action_icon/view.svg')); ?>" alt="View" style="cursor: pointer; width: 16px; height: 16px;" onclick="window.location.href='<?php echo e(route('payroll.show', $payroll->id)); ?>'" title="View Salary Slip">
                  <?php endif; ?>
                  
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Payroll Management.edit payroll')): ?>
                  <a href="<?php echo e(route('payroll.edit', $payroll->id)); ?>" title="Edit">
                    <img src="<?php echo e(asset('action_icon/edit.svg')); ?>" alt="Edit" style="cursor: pointer; width: 16px; height: 16px;">
                  </a>
                  <?php endif; ?>
                  
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Payroll Management.delete payroll')): ?>
                  <img src="<?php echo e(asset('action_icon/delete.svg')); ?>" alt="Delete" style="cursor: pointer; width: 16px; height: 16px;" onclick="deletePayroll(<?php echo e($payroll->id); ?>)" title="Delete">
                  <?php endif; ?>
                </div>
              </td>
              <td style="padding: 12px 8px; text-align: center; font-weight: 600; color: #1e40af;"><?php echo e($payroll->employee->code ?? 'N/A'); ?></td>
              <td style="padding: 12px 8px; text-align: center;">
                <div style="font-weight: 600; color: #1f2937;"><?php echo e($payroll->employee->name ?? 'N/A'); ?></div>
                <div style="font-size: 11px; color: #6b7280;"><?php echo e($payroll->employee->position ?? 'N/A'); ?></div>
              </td>
              <td style="padding: 12px 8px; text-align: center;">
                <div style="font-weight: 600; color: #1f2937;"><?php echo e($payroll->month); ?></div>
                <div style="font-size: 11px; color: #6b7280;"><?php echo e($payroll->year); ?></div>
              </td>
              <td style="padding: 12px 8px; text-align: center !important; font-weight: 600; color: #1f2937;">₹<?php echo e(number_format($payroll->basic_salary, 0)); ?></td>
              <td style="padding: 12px 8px; text-align: center !important; font-weight: 600; color: #059669;">₹<?php echo e(number_format($totalAllowances, 0)); ?></td>
              <td style="padding: 12px 8px; text-align: center !important; font-weight: 600; color: #dc2626;">₹<?php echo e(number_format($totalDeductions, 0)); ?></td>
              <td style="padding: 12px 8px; text-align: center !important; font-weight: 700; color: #10b981; font-size: 15px;">₹<?php echo e(number_format($netSalary, 0)); ?></td>
              <td style="padding: 12px 8px; text-align: center;">
                <?php
                  $statusColors = [
                    'pending' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                    'paid' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                    'cancelled' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                  ];
                  $statusColor = $statusColors[$payroll->status] ?? ['bg' => '#f3f4f6', 'text' => '#6b7280'];
                ?>
                <span style="display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; background: <?php echo e($statusColor['bg']); ?>; color: <?php echo e($statusColor['text']); ?>;">
                  <?php echo e(ucfirst($payroll->status)); ?>

                </span>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="9" style="text-align: center; padding: 40px; color: #9ca3af;">
                <div style="font-weight: 600; margin-bottom: 8px;">No payroll records found</div>
                <div style="font-size: 14px;">Try adjusting your filters or create a new payroll record</div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php if($payrolls->hasPages()): ?>
  <div style="margin-top: 20px; display: flex; justify-content: center;">
    <?php echo e($payrolls->links()); ?>

  </div>
  <?php endif; ?>
</div>

<script>
function deletePayroll(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`<?php echo e(url('payroll')); ?>/${id}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          Swal.fire('Deleted!', data.message, 'success');
          setTimeout(() => location.reload(), 1000);
        } else {
          Swal.fire('Error!', data.message, 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error!', 'Failed to delete payroll', 'error');
      });
    }
  });
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/payroll/index.blade.php ENDPATH**/ ?>