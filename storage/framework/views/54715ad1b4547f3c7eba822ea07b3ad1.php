<?php $__env->startSection('page_title', $page_title); ?>

<?php $__env->startSection('content'); ?>
  <div class="hrp-card">
      <div class="Rectangle-30 hrp-compact">
      <form method="POST" action="<?php echo e(route('employees.store')); ?>" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3" id="employeeForm">
        <?php echo csrf_field(); ?>
        <div>
          <label class="hrp-label">Employee Code:</label>
          <input name="code" value="<?php echo e(old('code', $nextCode ?? '')); ?>" class="hrp-input Rectangle-29" readonly>
          <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="hrp-label">Employee Name:</label>
          <input name="name" value="<?php echo e(old('name')); ?>" placeholder="Enter Full Name" class="hrp-input Rectangle-29" required>
          <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <div>
          <label class="hrp-label">Email:</label>
          <input name="email" value="<?php echo e(old('email')); ?>" placeholder="Enter Email Address" class="hrp-input Rectangle-29" type="email" required>
          <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="hrp-label">Mobile No:</label>
          <input name="mobile" value="<?php echo e(old('mobile')); ?>" placeholder="10 digit mobile" class="hrp-input Rectangle-29" inputmode="numeric" pattern="\d{10}" maxlength="10" required>
          <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="hrp-label">Address:</label>
          <textarea name="address" placeholder="Enter Your Address" class="hrp-textarea Rectangle-29 Rectangle-29-textarea"><?php echo e(old('address')); ?></textarea>
          <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="hrp-label">Position:</label>
          <input name="position" value="<?php echo e(old('position')); ?>" placeholder="Enter Position" class="hrp-input Rectangle-29" required>
          <?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="hrp-label">Experience Type:</label>
          <?php ($expType = old('experience_type', '')); ?>
          <select name="experience_type" class="Rectangle-29 Rectangle-29-select" required>
            <option value="" disabled <?php echo e($expType==='' ? 'selected' : ''); ?>>Select Experience Type</option>
            <option value="YES" <?php echo e($expType==='Fresher' ? 'selected' : ''); ?>>YES</option>
            <option value="NO" <?php echo e($expType==='Experienced' ? 'selected' : ''); ?>>NO</option>
          </select>
          <?php $__errorArgs = ['experience_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="hrp-label">Joining Date:</label>
          <input name="joining_date" value="<?php echo e(old('joining_date')); ?>" class="hrp-input Rectangle-29 date-picker" type="text" placeholder="dd/mm/yyyy" autocomplete="off" required>
          <?php $__errorArgs = ['joining_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="hrp-label">Current Offer Amount:</label>
          <input name="current_offer_amount" value="<?php echo e(old('current_offer_amount')); ?>" placeholder="Enter Salary Amount" class="hrp-input Rectangle-29" type="number" step="0.01" min="0">
          <?php $__errorArgs = ['current_offer_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="hrp-label">Photo Upload:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="photoFileName">No File Chosen</div>
            <input id="photoInput" name="photo" type="file" accept=".jpg,.jpeg,.png,.gif">
          </div>
          <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="md:col-span-1">
          <label class="hrp-label">Gender:</label>
          <?php ($g = old('gender')); ?>
          <div class="hrp-segment">
            <input id="g-male" type="radio" name="gender" value="male" <?php echo e($g==='male' ? 'checked' : ''); ?> required><label for="g-male">Male</label>
            <input id="g-female" type="radio" name="gender" value="female" <?php echo e($g==='female' ? 'checked' : ''); ?> required><label for="g-female">Female</label>
            <input id="g-other" type="radio" name="gender" value="other" <?php echo e($g==='other' ? 'checked' : ''); ?> required><label for="g-other">Other</label>
          </div>
          <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
          <label class="hrp-label">Date of Birth:</label>
          <input name="date_of_birth" value="<?php echo e(old('date_of_birth')); ?>" class="hrp-input Rectangle-29 date-picker" type="text" placeholder="dd/mm/yyyy" autocomplete="off">
          <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="md:col-span-2">
          <div class="hrp-actions">
            <button type="submit" class="hrp-btn hrp-btn-primary">Add Employee</button>
          </div>
        </div>
      </form>
      </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
  <a class="hrp-bc-home" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="<?php echo e(route('employees.index')); ?>" style="font-weight:800;color:#0f0f0f;text-decoration:none">Employees</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Add New Employee</span>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
// Initialize jQuery datepicker with dd/mm/yyyy format
$(document).ready(function() {
    // For joining date - recent years
    $('input[name="joining_date"]').datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '-10:+10',
        showButtonPanel: true
    });
    
    // For date of birth - wider year range (18-70 years old)
    $('input[name="date_of_birth"]').datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '-70:-18',
        maxDate: '-18y',
        showButtonPanel: true
    });
});

(function(){
  var input = document.getElementById('photoInput');
  var label = document.getElementById('photoFileName');
  if(input && label){
    input.addEventListener('change', function(){
      var name = this.files && this.files.length ? this.files[0].name : 'No File Chosen';
      label.textContent = name;
    });
  }

  var form = document.getElementById('employeeForm');
  if(form){
    form.addEventListener('submit', function(e){
      // Convert dates from dd/mm/yyyy to yyyy-mm-dd before submission
      var dateFields = ['joining_date', 'date_of_birth'];
      dateFields.forEach(function(fieldName) {
        var dateInput = document.querySelector('input[name="' + fieldName + '"]');
        if(dateInput && dateInput.value){
          var parts = dateInput.value.split('/');
          if(parts.length === 3){
            // Convert dd/mm/yyyy to yyyy-mm-dd
            var day = parts[0];
            var month = parts[1];
            var year = parts[2];
            dateInput.value = year + '-' + month + '-' + day;
          }
        }
      });
      
      if(!form.checkValidity()){
        e.preventDefault();
        form.reportValidity();
      }
    });
  }
})();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/hr/employees/create.blade.php ENDPATH**/ ?>