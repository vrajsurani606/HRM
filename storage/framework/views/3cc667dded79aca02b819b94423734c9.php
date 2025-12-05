<?php $__env->startSection('page_title', $page_title); ?>

<?php $__env->startSection('content'); ?>
  <div class="hrp-card">
      <div class="Rectangle-30 hrp-compact">
      <form method="POST" action="<?php echo e(route('employees.update', $employee)); ?>" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3" id="employeeForm">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <!-- Employee Code -->
        <div>
          <label class="hrp-label">Employee Code:</label>
          <input name="code" value="<?php echo e(old('code', $employee->code)); ?>" class="hrp-input Rectangle-29" readonly>
          <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Name -->
        <div>
          <label class="hrp-label">Employee Name:</label>
          <input name="name" value="<?php echo e(old('name', $employee->name ?? optional($employee->user)->name)); ?>" placeholder="Enter Full Name" class="hrp-input Rectangle-29" required>
          <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Mobile No -->
        <div>
          <label class="hrp-label">Employee Mobile No:</label>
          <input name="mobile_no" value="<?php echo e(old('mobile_no', $employee->mobile_no ?? optional($employee->user)->mobile_no)); ?>" placeholder="Enter Mobile Number" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['mobile_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Address -->
        <div>
          <label class="hrp-label">Employee Address:</label>
          <textarea name="address" placeholder="Enter Address" class="hrp-textarea Rectangle-29 Rectangle-29-textarea"><?php echo e(old('address', $employee->address ?? optional($employee->user)->address)); ?></textarea>
          <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Position -->
        <div>
          <label class="hrp-label">Employee Position:</label>
          <select name="position" class="Rectangle-29 Rectangle-29-select">
            <option value="">Select Position</option>
            <?php if(isset($positions)): ?>
              <?php $__currentLoopData = $positions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($pos); ?>" <?php echo e(old('position', $employee->position) === $pos ? 'selected' : ''); ?>><?php echo e($pos); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
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
        
        <!-- Employee Email -->
        <div>
          <label class="hrp-label">Employee Email:</label>
          <input name="email" type="email" value="<?php echo e(old('email', $employee->email ?? optional($employee->user)->email)); ?>" placeholder="Enter Email" class="hrp-input Rectangle-29" required>
          <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Password -->
        <div>
          <label class="hrp-label">Employee Password:</label>
          <div class="password-wrapper">
            <input name="password" type="password" placeholder="Enter Password" class="hrp-input Rectangle-29">
          </div>
          <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Reference Name -->
        <div>
          <label class="hrp-label">Employee Reference Name:</label>
          <input name="reference_name" value="<?php echo e(old('reference_name', $employee->reference_name)); ?>" placeholder="Enter Employee Reference Name" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['reference_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Reference No -->
        <div>
          <label class="hrp-label">Employee Reference No:</label>
          <input name="reference_no" value="<?php echo e(old('reference_no', $employee->reference_no)); ?>" placeholder="Enter Employee Reference No" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['reference_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Adhar No -->
        <div>
          <label class="hrp-label">Employee Adhar No:</label>
          <input name="aadhaar_no" value="<?php echo e(old('aadhaar_no', $employee->aadhaar_no)); ?>" placeholder="Enter Adhar No" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['aadhaar_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Pan No -->
        <div>
          <label class="hrp-label">Employee Pan No:</label>
          <input name="pan_no" value="<?php echo e(old('pan_no', $employee->pan_no)); ?>" placeholder="Enter Pan No" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['pan_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Adhar Photo 1 -->
        <div>
          <label class="hrp-label">Employee Adhar Photo 1:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="aadhaarFrontFileName"><?php echo e($employee->aadhaar_photo_front ? 'Current file selected' : 'No file chosen'); ?></div>
            <input id="aadhaarFrontInput" name="aadhaar_photo_front" type="file" accept="image/*">
          </div>
          <?php if($employee->aadhaar_photo_front): ?>
            <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
              <img src="<?php echo e(storage_asset($employee->aadhaar_photo_front)); ?>" alt="Aadhaar Front" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
              <a href="<?php echo e(storage_asset($employee->aadhaar_photo_front)); ?>" target="_blank" class="hrp-link" style="font-size: 13px; color: #ef4444; text-decoration: none; font-weight: 600;">
                <i class="fa fa-eye"></i> View Full Image
              </a>
            </div>
          <?php endif; ?>
          <?php $__errorArgs = ['aadhaar_photo_front'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Adhar Photo 2 -->
        <div>
          <label class="hrp-label">Employee Adhar Photo 2:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="aadhaarBackFileName"><?php echo e($employee->aadhaar_photo_back ? 'Current file selected' : 'No file chosen'); ?></div>
            <input id="aadhaarBackInput" name="aadhaar_photo_back" type="file" accept="image/*">
          </div>
          <?php if($employee->aadhaar_photo_back): ?>
            <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
              <img src="<?php echo e(storage_asset($employee->aadhaar_photo_back)); ?>" alt="Aadhaar Back" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
              <a href="<?php echo e(storage_asset($employee->aadhaar_photo_back)); ?>" target="_blank" class="hrp-link" style="font-size: 13px; color: #ef4444; text-decoration: none; font-weight: 600;">
                <i class="fa fa-eye"></i> View Full Image
              </a>
            </div>
          <?php endif; ?>
          <?php $__errorArgs = ['aadhaar_photo_back'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Pan Photo -->
        <div>
          <label class="hrp-label">Employee Pan Photo:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="panPhotoFileName"><?php echo e($employee->pan_photo ? 'Current file selected' : 'No file chosen'); ?></div>
            <input id="panPhotoInput" name="pan_photo" type="file" accept="image/*">
          </div>
          <?php if($employee->pan_photo): ?>
            <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
              <img src="<?php echo e(storage_asset($employee->pan_photo)); ?>" alt="PAN Photo" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
              <a href="<?php echo e(storage_asset($employee->pan_photo)); ?>" target="_blank" class="hrp-link" style="font-size: 13px; color: #ef4444; text-decoration: none; font-weight: 600;">
                <i class="fa fa-eye"></i> View Full Image
              </a>
            </div>
          <?php endif; ?>
          <?php $__errorArgs = ['pan_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Bank Name -->
        <div>
          <label class="hrp-label">Employee Bank Name:</label>
          <input name="bank_name" value="<?php echo e(old('bank_name', $employee->bank_name)); ?>" placeholder="Enter Employee Bank Name" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['bank_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Account No -->
        <div>
          <label class="hrp-label">Employee Account No:</label>
          <input name="bank_account_no" value="<?php echo e(old('bank_account_no', $employee->bank_account_no)); ?>" placeholder="Enter Account No" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['bank_account_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Ifsc Code -->
        <div>
          <label class="hrp-label">Employee Ifsc Code:</label>
          <input name="bank_ifsc" value="<?php echo e(old('bank_ifsc', $employee->bank_ifsc)); ?>" placeholder="Enter Ifsc Code" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['bank_ifsc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Cheque Photo -->
        <div>
          <label class="hrp-label">Employee Cheque Photo:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="chequePhotoFileName"><?php echo e($employee->cheque_photo ? 'Current file selected' : 'No file chosen'); ?></div>
            <input id="chequePhotoInput" name="cheque_photo" type="file" accept="image/*">
          </div>
          <?php if($employee->cheque_photo): ?>
            <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
              <img src="<?php echo e(storage_asset($employee->cheque_photo)); ?>" alt="Cheque Photo" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
              <a href="<?php echo e(storage_asset($employee->cheque_photo)); ?>" target="_blank" class="hrp-link" style="font-size: 13px; color: #ef4444; text-decoration: none; font-weight: 600;">
                <i class="fa fa-eye"></i> View Full Image
              </a>
            </div>
          <?php endif; ?>
          <?php $__errorArgs = ['cheque_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Marksheet -->
        <div>
          <label class="hrp-label">Employee Marksheet:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="marksheetFileName"><?php echo e($employee->marksheet_photo ? 'Current file selected' : 'No file chosen'); ?></div>
            <input id="marksheetInput" name="marksheet_photo" type="file" accept="image/*">
          </div>
          <?php if($employee->marksheet_photo): ?>
            <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
              <img src="<?php echo e(storage_asset($employee->marksheet_photo)); ?>" alt="Marksheet" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
              <a href="<?php echo e(storage_asset($employee->marksheet_photo)); ?>" target="_blank" class="hrp-link" style="font-size: 13px; color: #ef4444; text-decoration: none; font-weight: 600;">
                <i class="fa fa-eye"></i> View Full Image
              </a>
            </div>
          <?php endif; ?>
          <?php $__errorArgs = ['marksheet_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Photo -->
        <div>
          <label class="hrp-label">Employee Photo:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="photoFileName"><?php echo e($employee->photo_path ? 'Current photo selected' : 'No file chosen'); ?></div>
            <input id="photoInput" name="photo" type="file" accept="image/*">
          </div>
          <?php if($employee->photo_path): ?>
            <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
              <img src="<?php echo e(storage_asset($employee->photo_path)); ?>" alt="Employee Photo" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
              <a href="<?php echo e(storage_asset($employee->photo_path)); ?>" target="_blank" class="hrp-link" style="font-size: 13px; color: #ef4444; text-decoration: none; font-weight: 600;">
                <i class="fa fa-eye"></i> View Full Image
              </a>
            </div>
          <?php endif; ?>
          <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Experience Type -->
        <div>
          <label class="hrp-label">Employee Experience Type:</label>
          <?php ($et = old('experience_type', $employee->experience_type)); ?>
          <select name="experience_type" id="experience_type" class="Rectangle-29 Rectangle-29-select">
            <option value="">Select Experience Type</option>
            <option value="YES" <?php echo e($et==='YES'?'selected':''); ?>>YES</option>
            <option value="NO" <?php echo e($et==='NO'?'selected':''); ?>>NO</option>
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
        
        <div id="experienceFieldsWrap" style="display:none" class="md:col-span-2">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
            <!-- Employee Previous Company Name -->
            <div>
              <label class="hrp-label">Employee Previous Company Name:</label>
              <input name="previous_company_name" id="previous_company_name" value="<?php echo e(old('previous_company_name', $employee->previous_company_name)); ?>" placeholder="Enter Previous Company Name" class="hrp-input Rectangle-29">
              <?php $__errorArgs = ['previous_company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
            <!-- Employee Previous Salary -->
            <div>
              <label class="hrp-label">Employee Previous Salary:</label>
              <input name="previous_salary" id="previous_salary" type="number" step="0.01" min="0" value="<?php echo e(old('previous_salary', $employee->previous_salary)); ?>" placeholder="Enter Previous Salary" class="hrp-input Rectangle-29">
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
        
        <!-- Employee Current Offer Amount -->
        <div>
          <label class="hrp-label">Employee Current Offer Amount:</label>
          <input name="current_offer_amount" type="number" step="0.01" min="0" value="<?php echo e(old('current_offer_amount', $employee->current_offer_amount)); ?>" placeholder="Enter Employee Current Offer Amount" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['current_offer_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Incentive -->
        <div>
          <label class="hrp-label">Employee Incentive:</label>
          <?php ($hi = old('has_incentive', $employee->has_incentive ? 'YES' : 'NO')); ?>
          <select name="has_incentive" id="has_incentive" class="Rectangle-29 Rectangle-29-select">
            <option value="">Select Incentive</option>
            <option value="YES" <?php echo e($hi==='YES'?'selected':''); ?>>YES</option>
            <option value="NO" <?php echo e($hi==='NO'?'selected':''); ?>>NO</option>
          </select>
          <?php $__errorArgs = ['has_incentive'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Incentive Amount -->
        <div id="incentiveAmountWrap" style="display:none">
          <label class="hrp-label">Employee Incentive Amount:</label>
          <input name="incentive_amount" id="incentive_amount" type="number" step="0.01" min="0" value="<?php echo e(old('incentive_amount', $employee->incentive_amount)); ?>" placeholder="Enter Employee Incentive Amount" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['incentive_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Gender -->
        <div>
          <label class="hrp-label">Employee Gender:</label>
          <?php ($g = old('gender', $employee->gender)); ?>
          <select name="gender" class="Rectangle-29 Rectangle-29-select">
            <option value="">Select Gender</option>
            <option value="male" <?php echo e($g==='male'?'selected':''); ?>>Male</option>
            <option value="female" <?php echo e($g==='female'?'selected':''); ?>>Female</option>
            <option value="other" <?php echo e($g==='other'?'selected':''); ?>>Other</option>
          </select>
          <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Date of Birth -->
        <div>
          <label class="hrp-label">Employee Date of Birth:</label>
          <input name="date_of_birth" type="text" value="<?php echo e(old('date_of_birth', optional($employee->date_of_birth)->format('d/m/Y'))); ?>" class="hrp-input Rectangle-29 date-picker" placeholder="dd/mm/yyyy" autocomplete="off">
          <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Marital Status -->
        <div>
          <label class="hrp-label">Employee Marital Status:</label>
          <?php ($ms = old('marital_status', $employee->marital_status)); ?>
          <select name="marital_status" class="Rectangle-29 Rectangle-29-select">
            <option value="">Select Marital Status</option>
            <option value="single" <?php echo e($ms==='single'?'selected':''); ?>>Single</option>
            <option value="married" <?php echo e($ms==='married'?'selected':''); ?>>Married</option>
            <option value="other" <?php echo e($ms==='other'?'selected':''); ?>>Other</option>
          </select>
          <?php $__errorArgs = ['marital_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Father Name -->
        <div>
          <label class="hrp-label">Father Name:</label>
          <input name="father_name" value="<?php echo e(old('father_name', $employee->father_name ?? '')); ?>" placeholder="Enter Father Name" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['father_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Father Mobile Number -->
        <div>
          <label class="hrp-label">Father Mobile Number:</label>
          <input name="father_mobile" value="<?php echo e(old('father_mobile', $employee->father_mobile ?? '')); ?>" placeholder="10 digit mobile" class="hrp-input Rectangle-29" inputmode="numeric" pattern="\d{10}" maxlength="10">
          <?php $__errorArgs = ['father_mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Mother Name -->
        <div>
          <label class="hrp-label">Mother Name:</label>
          <input name="mother_name" value="<?php echo e(old('mother_name', $employee->mother_name ?? '')); ?>" placeholder="Enter Mother Name" class="hrp-input Rectangle-29">
          <?php $__errorArgs = ['mother_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Mother Mobile Number -->
        <div>
          <label class="hrp-label">Mother Mobile Number:</label>
          <input name="mother_mobile" value="<?php echo e(old('mother_mobile', $employee->mother_mobile ?? '')); ?>" placeholder="10 digit mobile" class="hrp-input Rectangle-29" inputmode="numeric" pattern="\d{10}" maxlength="10">
          <?php $__errorArgs = ['mother_mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Employee Joining Date -->
        <div>
          <label class="hrp-label">Employee Joining Date:</label>
          <input name="joining_date" type="text" value="<?php echo e(old('joining_date', optional($employee->joining_date)->format('d/m/Y'))); ?>" class="hrp-input Rectangle-29 date-picker" placeholder="dd/mm/yyyy" autocomplete="off">
          <?php $__errorArgs = ['joining_date'];
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
            <button class="hrp-btn hrp-btn-primary">Update Employee</button>
          </div>
        </div>
      </form>
      </div>
    </div>
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
  // File input handlers
  const fileInputs = [
    {input: 'photoInput', label: 'photoFileName'},
    {input: 'aadhaarFrontInput', label: 'aadhaarFrontFileName'},
    {input: 'aadhaarBackInput', label: 'aadhaarBackFileName'},
    {input: 'panPhotoInput', label: 'panPhotoFileName'},
    {input: 'chequePhotoInput', label: 'chequePhotoFileName'},
    {input: 'marksheetInput', label: 'marksheetFileName'}
  ];
  
  fileInputs.forEach(function(item) {
    var input = document.getElementById(item.input);
    var label = document.getElementById(item.label);
    if(input && label){
      input.addEventListener('change', function(){
        var name = this.files && this.files.length ? this.files[0].name : 'No file chosen';
        label.textContent = name;
      });
    }
  });
  
  // Handle Experience Type show/hide
  var expTypeSel = document.getElementById('experience_type');
  var expFieldsWrap = document.getElementById('experienceFieldsWrap');
  var prevCompany = document.getElementById('previous_company_name');
  var prevSalary = document.getElementById('previous_salary');
  
  function toggleExperienceFields(){
    var hasExp = expTypeSel && expTypeSel.value === 'YES';
    if(expFieldsWrap){ expFieldsWrap.style.display = hasExp ? '' : 'none'; }
    if(prevCompany){ prevCompany.disabled = !hasExp; if(!hasExp){ prevCompany.value = ''; } }
    if(prevSalary){ prevSalary.disabled = !hasExp; if(!hasExp){ prevSalary.value = ''; } }
  }
  if(expTypeSel){ expTypeSel.addEventListener('change', toggleExperienceFields); toggleExperienceFields(); }
  
  // Handle Incentive show/hide
  var incentiveSel = document.getElementById('has_incentive');
  var incentiveAmountWrap = document.getElementById('incentiveAmountWrap');
  var incentiveAmount = document.getElementById('incentive_amount');
  
  function toggleIncentiveAmount(){
    var hasIncentive = incentiveSel && incentiveSel.value === 'YES';
    if(incentiveAmountWrap){ incentiveAmountWrap.style.display = hasIncentive ? '' : 'none'; }
    if(incentiveAmount){ incentiveAmount.disabled = !hasIncentive; if(!hasIncentive){ incentiveAmount.value = ''; } }
  }
  if(incentiveSel){ incentiveSel.addEventListener('change', toggleIncentiveAmount); toggleIncentiveAmount(); }
  
  // Convert date format before form submission
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
    });
  }
})();
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
  <a class="hrp-bc-home" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="<?php echo e(route('employees.index')); ?>" style="font-weight:800;color:#0f0f0f;text-decoration:none">Employee</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Edit Employee</span>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/hr/employees/edit.blade.php ENDPATH**/ ?>