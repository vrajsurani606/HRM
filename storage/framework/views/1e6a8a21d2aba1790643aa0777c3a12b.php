<?php $__env->startSection('page_title', 'Attendance Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="hrp-content">
  <!-- Filter Row -->
  <form method="GET" action="<?php echo e(route('attendance.report')); ?>" class="jv-filter" id="filterForm">
    <input type="text" name="start_date" class="filter-pill date-picker" placeholder="From : dd/mm/yy" value="<?php echo e(request('start_date')); ?>" autocomplete="off" style="min-width: 130px;">
    <input type="text" name="end_date" class="filter-pill date-picker" placeholder="To : dd/mm/yy" value="<?php echo e(request('end_date')); ?>" autocomplete="off" style="min-width: 130px;">
    
    <select name="employee_id" class="filter-pill" style="min-width: 200px;">
      <option value="">All Employees</option>
      <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($emp->id); ?>" <?php echo e(request('employee_id') == $emp->id ? 'selected' : ''); ?>>
          <?php echo e($emp->name); ?>

        </option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <select name="status" class="filter-pill">
      <option value="">All Status</option>
      <option value="present" <?php echo e(request('status') == 'present' ? 'selected' : ''); ?>>Present</option>
      <option value="absent" <?php echo e(request('status') == 'absent' ? 'selected' : ''); ?>>Absent</option>
      <option value="half_day" <?php echo e(request('status') == 'half_day' ? 'selected' : ''); ?>>Half Day</option>
      <option value="late" <?php echo e(request('status') == 'late' ? 'selected' : ''); ?>>Late</option>
    </select>

    <button type="submit" class="filter-search" aria-label="Search">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
      </svg>
    </button>
    
    <a href="<?php echo e(route('attendance.report')); ?>" class="filter-search" aria-label="Reset">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
      </svg>
    </a>
    
    <div class="filter-right">
      <?php if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.export attendance report')): ?>
        <a href="<?php echo e(route('attendance.reports.export', request()->all())); ?>" class="pill-btn pill-success">Export to Excel</a>
      <?php endif; ?>
    </div>
  </form>

  <!-- Data Table -->
  <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
    <style>
      .JV-datatble table td:first-child {
        text-align: center !important;
      }
      .JV-datatble table td:first-child > div {
        display: inline-flex !important;
        gap: 12px;
        align-items: center;
      }
    </style>
    <table>
      <thead>
        <tr>
          <th style="width: 100px; text-align: center;">Action</th>
          <th style="width: 120px;">Date</th>
          <th style="width: 100px;">EMP Code</th>
          <th style="width: 180px;">EMPLOYEE</th>
          <th style="width: 60px; text-align: center;">Entry</th>
          <th style="width: 280px;">Check IN & OUT</th>
          <th style="width: 80px; text-align: center;">Duration</th>
          <th style="width: 80px; text-align: center;">Total</th>
          <th style="width: 100px; text-align: center;">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
          // Group attendances by employee and date
          $grouped = $attendances->groupBy(function($item) {
            return $item->employee_id . '_' . $item->date->format('Y-m-d');
          });
        ?>
        
        <?php $__empty_1 = true; $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $dayEntries): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <?php
            $firstEntry = $dayEntries->first();
            $dayTotalSeconds = 0;
            $dayStatus = 'absent';
            $entrySecondsArr = [];
            
            foreach($dayEntries as $idx => $entry) {
              $secs = 0;
              if ($entry->check_in && $entry->check_out) {
                $inT = $entry->check_in instanceof \Carbon\Carbon ? $entry->check_in : \Carbon\Carbon::parse($entry->check_in);
                $outT = $entry->check_out instanceof \Carbon\Carbon ? $entry->check_out : \Carbon\Carbon::parse($entry->check_out);
                // Use timestamp difference for accurate calculation
                $secs = abs($outT->timestamp - $inT->timestamp);
              }
              $entrySecondsArr[$idx] = $secs;
              $dayTotalSeconds += $secs;
              if($entry->status) $dayStatus = $entry->status;
            }
            
            // Format total time as HH:MM:SS
            $totalH = floor($dayTotalSeconds / 3600);
            $totalM = floor(($dayTotalSeconds % 3600) / 60);
            $totalS = $dayTotalSeconds % 60;
            $dayTotalFormatted = sprintf('%02d:%02d:%02d', $totalH, $totalM, $totalS);
            
            $statusColors = [
              'present' => ['bg' => '#dcfce7', 'text' => '#166534'],
              'absent' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
              'half_day' => ['bg' => '#fef3c7', 'text' => '#92400e'],
              'late' => ['bg' => '#ffedd5', 'text' => '#9a3412'],
              'leave' => ['bg' => '#e0e7ff', 'text' => '#3730a3'],
              'early_leave' => ['bg' => '#fef3c7', 'text' => '#92400e'],
            ];
            $statusStyle = $statusColors[$dayStatus] ?? ['bg' => '#f3f4f6', 'text' => '#374151'];
          ?>
          
          <?php $__currentLoopData = $dayEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td style="vertical-align: middle; padding: 10px; text-align: center;">
              <div style="display: inline-flex; gap: 8px; align-items: center;">
                <?php if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.edit attendance')): ?>
                  <img src="<?php echo e(asset('action_icon/edit.svg')); ?>" alt="Edit" style="cursor: pointer; width: 16px; height: 16px;" onclick="editAttendance(<?php echo e($attendance->id); ?>)">
                <?php endif; ?>
                <?php if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.delete attendance')): ?>
                  <img src="<?php echo e(asset('action_icon/delete.svg')); ?>" alt="Delete" style="cursor: pointer; width: 16px; height: 16px;" onclick="deleteAttendance(<?php echo e($attendance->id); ?>)">
                <?php endif; ?>
                <?php if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.print attendance report')): ?>
                  <img src="<?php echo e(asset('action_icon/print.svg')); ?>" alt="Print" style="cursor: pointer; width: 16px; height: 16px;" onclick="printAttendance(<?php echo e($attendance->id); ?>)">
                <?php endif; ?>
              </div>
            </td>
            <td style="vertical-align: middle; font-weight: 600;">
              <?php echo e($attendance->date->format('d M Y')); ?>

            </td>
            <td style="vertical-align: middle; font-size: 12px;">
              <?php echo e($attendance->employee->code ?? 'EMP/' . str_pad($attendance->employee->id ?? '000', 4, '0', STR_PAD_LEFT)); ?>

            </td>
            <td style="vertical-align: middle;"><?php echo e($attendance->employee->name ?? 'N/A'); ?></td>
            <td style="vertical-align: middle; text-align: center;">
              <span style="display:inline-block;background:#e5e7eb;color:#374151;padding:2px 8px;border-radius:10px;font-size:11px;font-weight:600">
                #<?php echo e($index + 1); ?>

              </span>
            </td>
            <td style="vertical-align: middle; padding: 10px;">
              <?php
                $checkIn = $attendance->check_in ? ($attendance->check_in instanceof \Carbon\Carbon ? $attendance->check_in : \Carbon\Carbon::parse($attendance->check_in)) : null;
                $checkOut = $attendance->check_out ? ($attendance->check_out instanceof \Carbon\Carbon ? $attendance->check_out : \Carbon\Carbon::parse($attendance->check_out)) : null;
              ?>
              
              <div style="display: flex; justify-content: center; align-items: center; gap: 8px;">
                <?php if($checkIn): ?>
                  <span style="color:#059669; font-weight:600; font-size:13px;"><?php echo e($checkIn->format('h:i A')); ?></span>
                <?php else: ?>
                  <span style="color:#9ca3af;">--</span>
                <?php endif; ?>
                
                <span style="color:#d1d5db; font-size:12px;">→</span>
                
                <?php if($checkOut): ?>
                  <span style="color:#dc2626; font-weight:600; font-size:13px;"><?php echo e($checkOut->format('h:i A')); ?></span>
                <?php else: ?>
                  <span style="color:#9ca3af;">--</span>
                <?php endif; ?>
              </div>
            </td>
            <td style="vertical-align: middle; text-align: center;">
              <?php if($checkIn && $checkOut): ?>
                <?php
                  $entrySecs = $entrySecondsArr[$index] ?? 0;
                  $entryH = floor($entrySecs / 3600);
                  $entryM = floor(($entrySecs % 3600) / 60);
                  $entryS = $entrySecs % 60;
                  $entryFormatted = sprintf('%02d:%02d:%02d', $entryH, $entryM, $entryS);
                ?>
                <span style="font-weight:600; color:#374151; font-size:13px;">
                  <?php echo e($entryFormatted); ?>

                </span>
              <?php else: ?>
                <span style="color:#9ca3af;">-</span>
              <?php endif; ?>
            </td>
            <td style="vertical-align: middle; text-align: center;">
              <span style="display:inline-block;background:#dbeafe;color:#1e40af;padding:3px 10px;border-radius:6px;font-weight:700;font-size:12px">
                <?php echo e($dayTotalFormatted); ?>

              </span>
            </td>
            <td style="vertical-align: middle; text-align: center;">
              <span style="display:inline-block;background:<?php echo e($statusStyle['bg']); ?>;color:<?php echo e($statusStyle['text']); ?>;padding:3px 10px;border-radius:6px;font-weight:600;font-size:11px;text-transform:capitalize">
                <?php echo e(str_replace('_', ' ', $dayStatus)); ?>

              </span>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
          <td colspan="9" style="text-align: center; padding: 40px; color: #9ca3af;">
            <svg width="48" height="48" fill="currentColor" viewBox="0 0 24 24" style="margin-bottom: 12px; opacity: 0.5;">
              <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
            </svg>
            <p style="font-weight: 600; margin: 0;">No attendance records found</p>
            <p style="font-size: 14px; margin: 8px 0 0 0;">Try adjusting your filters</p>
          </td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <?php if($attendances->hasPages()): ?>
  <div style="margin-top: 20px; display: flex; justify-content: center;">
    <?php echo e($attendances->links()); ?>

  </div>
  <?php endif; ?>
</div>

<script>
function editAttendance(id) {
  // Redirect to edit page or open modal
  window.location.href = '<?php echo e(url("attendance")); ?>/' + id + '/edit';
}

function deleteAttendance(id) {
  if (confirm('Are you sure you want to delete this attendance record?')) {
    fetch('<?php echo e(url("attendance")); ?>/' + id, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        toastr.success('Attendance record deleted successfully!');
        location.reload();
      } else {
        toastr.error('Error deleting record: ' + (data.message || 'Unknown error'));
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Error deleting record');
    });
  }
}

function printAttendance(id) {
  // Open print view in new window
  window.open('<?php echo e(url("attendance")); ?>/' + id + '/print', '_blank');
}
</script>
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
// Date format dd/mm/yy is sent directly to server - controller handles parsing
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/hr/attendance/report.blade.php ENDPATH**/ ?>