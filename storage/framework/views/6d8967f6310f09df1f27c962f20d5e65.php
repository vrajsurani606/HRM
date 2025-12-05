<?php $__env->startSection('page_title', $page_title); ?>

<?php $__env->startSection('content'); ?>
  <div class="hrp-card">
    <div class="hrp-card-body">
      <div class="Rectangle-30 hrp-compact">
      <form method="POST" action="<?php echo e(route('hiring.update', $lead)); ?>" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5" id="hiringEditForm">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div>
          <label class="hrp-label">Unique Code:</label>
          <input name="unique_code" value="<?php echo e($lead->unique_code); ?>" class="hrp-input Rectangle-29" readonly>
          <?php $__errorArgs = ['unique_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="hrp-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label class="hrp-label">Person Name:</label>
          <input name="person_name" value="<?php echo e(old('person_name', $lead->person_name)); ?>" placeholder="Enter Full Name" class="hrp-input Rectangle-29" required>
          <?php $__errorArgs = ['person_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="hrp-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label class="hrp-label">Mobile No:</label>
          <input name="mobile_no" value="<?php echo e(old('mobile_no', $lead->mobile_no)); ?>" placeholder="10 digit mobile" class="hrp-input Rectangle-29" inputmode="numeric" pattern="\d{10}" maxlength="10" required>
          <?php $__errorArgs = ['mobile_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="hrp-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label class="hrp-label">Address:</label>
          <textarea name="address" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" placeholder="Enter Your Address" required><?php echo e(old('address', $lead->address)); ?></textarea>
          <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="hrp-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label class="hrp-label">Position:</label>
          <select name="position" class="Rectangle-29 Rectangle-29-select" required>
            <option value="">Select Position</option>
            <?php if(isset($positions)): ?>
              <?php $__currentLoopData = $positions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($pos); ?>" <?php echo e(old('position', $lead->position) === $pos ? 'selected' : ''); ?>><?php echo e($pos); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
          </select>
          <?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="hrp-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label class="hrp-label">Is experience ?:</label>
          <?php ($exp = old('is_experience', $lead->is_experience ? '1' : '0')); ?>
          <select name="is_experience" id="is_experience" class="Rectangle-29 Rectangle-29-select" required>
            <option value="" disabled <?php echo e($exp==='' ? 'selected' : ''); ?>>Select Experience</option>
            <option value="0" <?php echo e($exp==='0' ? 'selected' : ''); ?>>No</option>
            <option value="1" <?php echo e($exp==='1' ? 'selected' : ''); ?>>Yes</option>
          </select>
          <?php $__errorArgs = ['is_experience'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="hrp-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label class="hrp-label">Experience Count:</label>
          <input name="experience_count" id="experience_count" value="<?php echo e(old('experience_count', $lead->experience_count)); ?>" placeholder="Enter No. of Exp. e.g. 2.5" class="hrp-input Rectangle-29" type="number" step="0.1" min="0">
          <?php $__errorArgs = ['experience_count'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="hrp-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label class="hrp-label">Experience previous Company:</label>
          <input name="experience_previous_company" id="experience_previous_company" value="<?php echo e(old('experience_previous_company', $lead->experience_previous_company)); ?>" placeholder="Enter Experience Previous Company Name" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['experience_previous_company'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="hrp-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label class="hrp-label">Previous Salary:</label>
          <input name="previous_salary" value="<?php echo e(old('previous_salary', $lead->previous_salary)); ?>" placeholder="Enter Salary" class="hrp-input Rectangle-29" type="number" step="0.01" min="0">
          <?php $__errorArgs = ['previous_salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="hrp-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label class="hrp-label">Resume Upload:</label>
          <div class="upload-pill">
            <div class="choose">Choose File</div>
            <div class="filename" id="resumeFileNameEdit">No File Chosen</div>
            <input id="resumeInputEdit" name="resume" type="file" accept=".pdf,.doc,.docx">
          </div>
          <?php $__errorArgs = ['resume'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="hrp-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          <?php if($lead->resume_path): ?>
            <div class="text-sm" style="margin-top:6px">Current: <a class="hrp-link" href="<?php echo e(route('hiring.resume', $lead->id)); ?>" target="_blank">View</a></div>
          <?php endif; ?>
        </div>
        <div>
          <label class="hrp-label">Gender:</label>
          <?php ($g = old('gender', $lead->gender)); ?>
          <div class="hrp-segment">
            <input id="g-male-edit" type="radio" name="gender" value="male" <?php echo e($g==='male' ? 'checked' : ''); ?> required><label for="g-male-edit">Male</label>
            <input id="g-female-edit" type="radio" name="gender" value="female" <?php echo e($g==='female' ? 'checked' : ''); ?> required><label for="g-female-edit">Female</label>
            <input id="g-other-edit" type="radio" name="gender" value="other" <?php echo e($g==='other' ? 'checked' : ''); ?> required><label for="g-other-edit">Other</label>
          </div>
          <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="hrp-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="md:col-span-2">
          <div class="hrp-actions" style="gap:8px">
            <a href="<?php echo e(route('hiring.index')); ?>" class="hrp-btn" style="background:#e5e7eb">Cancel</a>
            <button class="hrp-btn hrp-btn-primary">Update Hiring Lead</button>
            <?php ($hasOffer = $lead->offerLetter); ?>
            <?php if($hasOffer): ?>
              <a href="<?php echo e(route('hiring.offer.edit', $lead->id)); ?>" class="hrp-btn">Edit Offer Letter</a>
              <a href="<?php echo e(route('hiring.print', ['id' => $lead->id, 'type' => 'offerletter'])); ?>" target="_blank" class="hrp-btn">Print Offer Letter</a>
            <?php else: ?>
              <a href="<?php echo e(route('hiring.offer.create', $lead->id)); ?>" class="hrp-btn">Create Offer Letter</a>
            <?php endif; ?>
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
  <?php $__env->startPush('scripts'); ?>
  <script>
    (function(){
      var input = document.getElementById('resumeInputEdit');
      var label = document.getElementById('resumeFileNameEdit');
      if(input && label){
        input.addEventListener('change', function(){
          var name = this.files && this.files.length ? this.files[0].name : 'No File Chosen';
          label.textContent = name;
        });
      }

      var expSel = document.getElementById('is_experience');
      var expCnt = document.getElementById('experience_count');
      var expComp = document.getElementById('experience_previous_company');
      function toggleExpReq(){
        var yes = expSel && expSel.value === '1';
        if(expCnt){ expCnt.required = yes; }
        if(expComp){ expComp.required = yes; }
      }
      if(expSel){ expSel.addEventListener('change', toggleExpReq); toggleExpReq(); }

      var form = document.getElementById('hiringEditForm');
      if(form){
        form.addEventListener('submit', function(e){
          if(!form.checkValidity()){
            e.preventDefault();
            form.reportValidity();
          }
        });
      }
    })();
  </script>
  <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/hr/hiring/edit.blade.php ENDPATH**/ ?>