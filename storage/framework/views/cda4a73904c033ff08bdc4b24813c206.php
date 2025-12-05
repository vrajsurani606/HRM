<?php $__env->startSection('page_title', $page_title); ?>

<?php $__env->startSection('content'); ?>
  <div class="hrp-card">
      <div class="Rectangle-30 hrp-compact">
      <form method="POST" action="<?php echo e(route('hiring.store')); ?>" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3" id="hiringForm">
        <?php echo csrf_field(); ?>
        <div>
          <label class="hrp-label">Unique Code:</label>
          <input name="unique_code" value="<?php echo e(old('unique_code', $nextCode)); ?>" class="hrp-input Rectangle-29" readonly>
          <?php $__errorArgs = ['unique_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
  <?php $__env->startPush('scripts'); ?>
  <script>
    (function(){
      var input = document.getElementById('resumeInput');
      var label = document.getElementById('resumeFileName');
      if(input && label){
        input.addEventListener('change', function(){
          var name = this.files && this.files.length ? this.files[0].name : 'No File Chosen';
          label.textContent = name;
        });
      }

      var expSel = document.getElementById('is_experience');
      var expCnt = document.getElementById('experience_count');
      var expComp = document.getElementById('experience_previous_company');
      var prevSal = document.getElementById('previous_salary');
      var expFlds = document.getElementById('expFieldsWrap');
      function toggleExpReq(){
        var yes = expSel && expSel.value === '1';
        if(expCnt){ expCnt.required = yes; expCnt.disabled = !yes; if(!yes){ expCnt.value = ''; } }
        if(expComp){ expComp.required = yes; expComp.disabled = !yes; if(!yes){ expComp.value = ''; } }
        if(prevSal){ prevSal.required = yes; prevSal.disabled = !yes; if(!yes){ prevSal.value = ''; } }
        if(expFlds){ expFlds.style.display = yes ? '' : 'none'; }
      }
      if(expSel){ expSel.addEventListener('change', toggleExpReq); toggleExpReq(); }

      // Handle "Other" position
      var posSel = document.getElementById('positionSelect');
      var otherWrap = document.getElementById('otherPositionWrap');
      var otherInput = document.getElementById('otherPositionInput');
      function toggleOtherPosition(){
        var isOther = posSel && posSel.value === 'Other';
        if(otherWrap){ otherWrap.style.display = isOther ? '' : 'none'; }
        if(otherInput){ 
          otherInput.required = isOther; 
          otherInput.disabled = !isOther;
          if(!isOther){ otherInput.value = ''; }
        }
      }
      if(posSel){ posSel.addEventListener('change', toggleOtherPosition); toggleOtherPosition(); }

      var form = document.getElementById('hiringForm');
      if(form){
        form.addEventListener('submit', function(e){
          // If "Other" is selected, use the custom position value
          if(posSel && posSel.value === 'Other' && otherInput && otherInput.value.trim()){
            posSel.value = otherInput.value.trim();
          }
          
          if(!form.checkValidity()){
            e.preventDefault();
            form.reportValidity();
          }
        });
      }
    })();
  </script>
  <?php $__env->stopPush(); ?>
        <div>
          <label class="hrp-label">Person Name:</label>
          <input name="person_name" value="<?php echo e(old('person_name')); ?>" placeholder="Enter Full Name" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['person_name'];
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
          <input name="mobile_no" value="<?php echo e(old('mobile_no')); ?>" placeholder="10 digit mobile" class="hrp-input Rectangle-29" inputmode="numeric" pattern="\d{10}" maxlength="10">
          <?php $__errorArgs = ['mobile_no'];
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
          <select name="position" id="positionSelect" class="Rectangle-29 Rectangle-29-select" required>
            <option value="">Select Position</option>
            <optgroup label="Development">
              <option value="Full Stack Developer" <?php echo e(old('position') === 'Full Stack Developer' ? 'selected' : ''); ?>>Full Stack Developer</option>
              <option value="Frontend Developer" <?php echo e(old('position') === 'Frontend Developer' ? 'selected' : ''); ?>>Frontend Developer</option>
              <option value="Backend Developer" <?php echo e(old('position') === 'Backend Developer' ? 'selected' : ''); ?>>Backend Developer</option>
              <option value="Mobile App Developer" <?php echo e(old('position') === 'Mobile App Developer' ? 'selected' : ''); ?>>Mobile App Developer</option>
              <option value="DevOps Engineer" <?php echo e(old('position') === 'DevOps Engineer' ? 'selected' : ''); ?>>DevOps Engineer</option>
              <option value="Quality Assurance Engineer" <?php echo e(old('position') === 'Quality Assurance Engineer' ? 'selected' : ''); ?>>Quality Assurance Engineer</option>
            </optgroup>
            <optgroup label="Design">
              <option value="UI/UX Designer" <?php echo e(old('position') === 'UI/UX Designer' ? 'selected' : ''); ?>>UI/UX Designer</option>
              <option value="Graphic Designer" <?php echo e(old('position') === 'Graphic Designer' ? 'selected' : ''); ?>>Graphic Designer</option>
            </optgroup>
            <optgroup label="Management">
              <option value="Project Manager" <?php echo e(old('position') === 'Project Manager' ? 'selected' : ''); ?>>Project Manager</option>
              <option value="Team Lead" <?php echo e(old('position') === 'Team Lead' ? 'selected' : ''); ?>>Team Lead</option>
              <option value="Operations Manager" <?php echo e(old('position') === 'Operations Manager' ? 'selected' : ''); ?>>Operations Manager</option>
            </optgroup>
            <optgroup label="Human Resources">
              <option value="HR Executive" <?php echo e(old('position') === 'HR Executive' ? 'selected' : ''); ?>>HR Executive</option>
              <option value="HR Manager" <?php echo e(old('position') === 'HR Manager' ? 'selected' : ''); ?>>HR Manager</option>
            </optgroup>
            <optgroup label="Sales & Marketing">
              <option value="Sales Executive" <?php echo e(old('position') === 'Sales Executive' ? 'selected' : ''); ?>>Sales Executive</option>
              <option value="Sales Manager" <?php echo e(old('position') === 'Sales Manager' ? 'selected' : ''); ?>>Sales Manager</option>
              <option value="Marketing Executive" <?php echo e(old('position') === 'Marketing Executive' ? 'selected' : ''); ?>>Marketing Executive</option>
              <option value="Digital Marketing Specialist" <?php echo e(old('position') === 'Digital Marketing Specialist' ? 'selected' : ''); ?>>Digital Marketing Specialist</option>
              <option value="Content Writer" <?php echo e(old('position') === 'Content Writer' ? 'selected' : ''); ?>>Content Writer</option>
              <option value="SEO Specialist" <?php echo e(old('position') === 'SEO Specialist' ? 'selected' : ''); ?>>SEO Specialist</option>
            </optgroup>
            <optgroup label="Finance & Accounting">
              <option value="Accountant" <?php echo e(old('position') === 'Accountant' ? 'selected' : ''); ?>>Accountant</option>
              <option value="Finance Manager" <?php echo e(old('position') === 'Finance Manager' ? 'selected' : ''); ?>>Finance Manager</option>
            </optgroup>
            <optgroup label="Other Roles">
              <option value="Business Analyst" <?php echo e(old('position') === 'Business Analyst' ? 'selected' : ''); ?>>Business Analyst</option>
              <option value="System Administrator" <?php echo e(old('position') === 'System Administrator' ? 'selected' : ''); ?>>System Administrator</option>
              <option value="Customer Support Executive" <?php echo e(old('position') === 'Customer Support Executive' ? 'selected' : ''); ?>>Customer Support Executive</option>
              <option value="Receptionist" <?php echo e(old('position') === 'Receptionist' ? 'selected' : ''); ?>>Receptionist</option>
              <option value="Intern" <?php echo e(old('position') === 'Intern' ? 'selected' : ''); ?>>Intern</option>
              <option value="Other" <?php echo e(old('position') === 'Other' ? 'selected' : ''); ?>>Other</option>
            </optgroup>
          </select>
          <?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div id="otherPositionWrap" style="display:none">
          <label class="hrp-label">Specify Position:</label>
          <input name="other_position" id="otherPositionInput" value="<?php echo e(old('other_position')); ?>" placeholder="Enter position name" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['other_position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label class="hrp-label">Is experience ?:</label>
          <?php ($exp = old('is_experience', '')); ?>
          <select name="is_experience" id="is_experience" class="Rectangle-29 Rectangle-29-select">
            <option value="" disabled <?php echo e($exp==='' ? 'selected' : ''); ?>>Select Experience</option>
            <option value="0" <?php echo e($exp==='0' ? 'selected' : ''); ?>>No</option>
            <option value="1" <?php echo e($exp==='1' ? 'selected' : ''); ?>>Yes</option>
          </select>
          <?php $__errorArgs = ['is_experience'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div id="expFieldsWrap" class="md:col-span-2" style="display:none">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5">
            <div>
              <label class="hrp-label">Experience Count:</label>
              <input name="experience_count" id="experience_count" value="<?php echo e(old('experience_count')); ?>" placeholder="Enter No. of Exp. e.g. 2.5" class="hrp-input Rectangle-29" type="number" step="0.1" min="0">
              <?php $__errorArgs = ['experience_count'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
              <label class="hrp-label">Previous Company:</label>
              <input name="experience_previous_company" id="experience_previous_company" value="<?php echo e(old('experience_previous_company')); ?>" placeholder="Enter Previous Company Name" class="hrp-input Rectangle-29">
              <?php $__errorArgs = ['experience_previous_company'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
              <label class="hrp-label">Previous Salary:</label>
              <input name="previous_salary" id="previous_salary" value="<?php echo e(old('previous_salary')); ?>" placeholder="Enter Salary" class="hrp-input Rectangle-29" type="number" step="0.01" min="0">
              <?php $__errorArgs = ['previous_salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
          </div>
        </div>
        <div>
          <label class="hrp-label">Resume Upload:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="resumeFileName">No File Chosen</div>
            <input id="resumeInput" name="resume" type="file" accept=".pdf,.doc,.docx">
          </div>
          <?php $__errorArgs = ['resume'];
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
            <input id="g-male" type="radio" name="gender" value="male" <?php echo e($g==='male' ? 'checked' : ''); ?> ><label for="g-male">Male</label>
            <input id="g-female" type="radio" name="gender" value="female" <?php echo e($g==='female' ? 'checked' : ''); ?> ><label for="g-female">Female</label>
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
        <div class="md:col-span-2">
          <div class="hrp-actions">
            <button type="submit" class="hrp-btn hrp-btn-primary">Add Hiring Lead Master</button>
          </div>
        </div>
      </form>
      </div>

  
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
  <a class="hrp-bc-home" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="<?php echo e(route('hiring.index')); ?>" style="font-weight:800;color:#0f0f0f;text-decoration:none">HRM</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Add New Hiring Lead</span>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/hr/hiring/create.blade.php ENDPATH**/ ?>