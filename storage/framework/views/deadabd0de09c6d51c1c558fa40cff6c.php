
<?php $__env->startSection('page_title', 'Quotation Follow Up'); ?>

<?php $__env->startSection('content'); ?>
<div class="Rectangle-30 hrp-compact" style="margin-bottom: 16px;">
  <!-- Quotation Details (readonly) -->
  <div class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
    <div>
      <label class="hrp-label">Quotation Code:</label>
      <input class="hrp-input Rectangle-29" value="<?php echo e($quotation->unique_code); ?>" readonly />
    </div>
    <div>
      <label class="hrp-label">Quotation Date:</label>
      <input
        class="hrp-input Rectangle-29"
        value="<?php echo e(optional($quotation->quotation_date)->format('d-m-Y')); ?>"
        readonly
      />
    </div>

    <div>
      <label class="hrp-label">Company Name:</label>
      <input class="hrp-input Rectangle-29" value="<?php echo e($quotation->company_name); ?>" readonly />
    </div>
    <div>
      <label class="hrp-label">Quotation Title:</label>
      <input class="hrp-input Rectangle-29" value="<?php echo e($quotation->quotation_title); ?>" readonly />
    </div>

    <div>
      <label class="hrp-label">Contact Person:</label>
      <input class="hrp-input Rectangle-29" value="<?php echo e($quotation->contact_person_1); ?>" readonly />
    </div>
    <div>
      <label class="hrp-label">Contact Number:</label>
      <input class="hrp-input Rectangle-29" value="<?php echo e($quotation->contact_number_1); ?>" readonly />
    </div>

    <div>
      <label class="hrp-label">Email:</label>
      <input class="hrp-input Rectangle-29" type="email" value="<?php echo e($quotation->company_email); ?>" readonly />
    </div>
    <div>
      <label class="hrp-label">Contract Amount:</label>
      <input class="hrp-input Rectangle-29" value="₹ <?php echo e(number_format($quotation->service_contract_amount, 2)); ?>" readonly />
    </div>

    <div>
      <label class="hrp-label">City:</label>
      <input class="hrp-input Rectangle-29" value="<?php echo e($quotation->city); ?>" readonly />
    </div>
    <div>
      <label class="hrp-label">State:</label>
      <input class="hrp-input Rectangle-29" value="<?php echo e($quotation->state); ?>" readonly />
    </div>

    <div class="md:col-span-2">
      <label class="hrp-label">Address:</label>
      <textarea class="hrp-textarea Rectangle-29 Rectangle-29-textarea" style="height:58px;resize:none;" readonly><?php echo e($quotation->address); ?></textarea>
    </div>
  </div>
</div>

<div class="Rectangle-30 hrp-compact" style="margin-bottom: 16px;">
  <h3 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 600; color: #111827;">Previous Followup List</h3>
  <div style="font-size:12px;color:#4b5563;margin-bottom:8px;display:flex;flex-wrap:wrap;gap:16px;">
    <div><strong>Action:</strong> <span style="background:#2196f3;color:#ffffff;border-radius:999px;padding:2px 10px;font-size:11px;">MAKE CONFIRM</span> = pending, click to confirm.</div>
    <div><strong>Is Confirm:</strong> <span style="color:#16a34a;font-weight:600;">Confirmed</span>, <span style="color:#dc2626;font-weight:600;">No</span></div>
  </div>
  <div style="max-height: 260px; overflow-y: auto; overflow-x: hidden; border-radius: 8px; border: 1px solid #e5e7eb;">
    <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none followup-table" style="margin:0; border-radius:0;">
      <table>
      <thead>
        <tr>
          <th>Serial No.</th>
          <th>Action</th>
          <th>Is Confirm</th>
          <th>Remark</th>
          <th>Followup Date</th>
          <th>Next Date</th>
          <th>Code</th>
        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $followUps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $followUp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr data-followup-id="<?php echo e($followUp->id); ?>" <?php if($followUp->is_confirm): ?> style="background:#ecfdf3;" <?php endif; ?>>
          <td><?php echo e($index + 1); ?></td>
          <td>
            <?php if($followUp->is_confirm): ?>
              <span class="text-green-600" style="color:#16a34a;font-weight:600;">Confirmed</span>
            <?php else: ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Quotations Management.follow up confirm')): ?>
                <button type="button" class="make-confirm-btn" style="background:#2196f3;color:#ffffff;border:none;border-radius:999px;padding:4px 16px;font-size:12px;font-weight:600;cursor:pointer;">MAKE CONFIRM</button>
              <?php endif; ?>
            <?php endif; ?>
          </td>
          <td>
            <?php if($followUp->is_confirm): ?>
              <span class="text-green-600" style="color:#16a34a;font-weight:600;">Confirmed</span>
            <?php else: ?>
              <span style="color:#dc2626;font-weight:600;">No</span>
            <?php endif; ?>
          </td>
          <td><?php echo e($followUp->remark); ?></td>
          <td><?php echo e(optional($followUp->followup_date)->format('d-m-Y')); ?></td>
          <td><?php echo e(optional($followUp->next_followup_date)->format('d-m-Y')); ?></td>
          <td><?php echo e($quotation->unique_code); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
          <td colspan="7" style="text-align:center;">No follow-ups found</td>
        </tr>
        <?php endif; ?>
      </tbody>
      </table>
    </div>
  </div>
</div>

<div class="Rectangle-30 hrp-compact">
  <h3 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 600; color: #111827;">Add Followup</h3>
  <form method="POST" action="<?php echo e(route('quotation.follow-up.store', $quotation->id)); ?>" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
    <?php echo csrf_field(); ?>

    <div>
      <label class="hrp-label">Code:</label>
      <input class="hrp-input Rectangle-29" name="code" value="<?php echo e($quotation->unique_code); ?>" readonly />
    </div>
    <div>
      <label class="hrp-label">Follow Up Date:</label>
      <input
        type="text"
        class="hrp-input Rectangle-29"
        name="followup_date"
        value="<?php echo e(optional($quotation->quotation_date)->format('d/m/y')); ?>"
        readonly
      />
      <?php $__errorArgs = ['followup_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
      <label class="hrp-label">Next Follow Up Date:</label>
      <input 
        type="text" 
        class="hrp-input Rectangle-29 date-picker" 
        name="next_followup_date" 
        placeholder="dd/mm/yyyy" 
        value="<?php echo e(old('next_followup_date')); ?>" 
        autocomplete="off"
      >
      <?php $__errorArgs = ['next_followup_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="md:col-span-2">
      <label class="hrp-label">Remark:</label>
      <textarea class="hrp-textarea Rectangle-29 Rectangle-29-textarea" name="remark" placeholder="Enter Remark" style="height:80px;resize:vertical;"><?php echo e(old('remark')); ?></textarea>
      <?php $__errorArgs = ['remark'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="md:col-span-2">
      <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:30px;">
        <a href="<?php echo e(route('quotations.index')); ?>" class="hrp-btn" style="background:#e5e7eb;color:#111827;">Cancel</a>
        <button type="submit" class="hrp-btn hrp-btn-primary">Add Follow Up</button>
      </div>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
  <a class="hrp-bc-home" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="<?php echo e(route('quotations.index')); ?>" style="font-weight:800;color:#0f0f0f;text-decoration:none">Quotation Management</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Follow Up</span>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
  .JV-datatble.followup-table td:first-child {
    display: table-cell !important;
    align-items: initial;
    gap: 0;
  }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Initialize date picker with dd/mm/yyyy format (same as quotation create)
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
    

    // MAKE CONFIRM actions
    var token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    document.querySelectorAll('.make-confirm-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var row = this.closest('tr');
        var followUpId = row.getAttribute('data-followup-id');
        if (!followUpId) return;

        Swal.fire({
          title: 'Are you sure to confirm?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#16a34a',
          cancelButtonColor: '#6b7280',
          confirmButtonText: 'Yes',
          cancelButtonText: 'Cancel',
          width: '380px',
        }).then(function (result) {
          if (!result.isConfirmed) return;

          fetch("<?php echo e(route('quotation.follow-up.confirm', ['followUp' => 'FOLLOWUP_ID'])); ?>".replace('FOLLOWUP_ID', followUpId), {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': token,
              'Accept': 'application/json',
            },
          })
          .then(function (res) { return res.json(); })
          .then(function (data) {
            if (data && data.success) {
              // Show success message and redirect to quotation list
              Swal.fire({
                title: 'Follow Up Confirmed Successfully!',
                text: 'Redirecting to quotation list...',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false,
                width: '400px',
              }).then(function() {
                // Redirect to quotation index page
                window.location.href = "<?php echo e(route('quotations.index')); ?>";
              });
            }
          })
          .catch(function () {
            Swal.fire('Error', 'Unable to confirm follow-up.', 'error');
          });
        });
      });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/quotations/follow_up.blade.php ENDPATH**/ ?>