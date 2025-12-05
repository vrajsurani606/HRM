<?php $__env->startSection('page_title', 'Edit Company'); ?>
<?php $__env->startSection('content'); ?>
  <div class="hrp-card">
    <div class="hrp-card-body">
      <div class="Rectangle-30 hrp-compact">
        <form method="POST" action="<?php echo e(route('companies.update', $company->id)); ?>" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5" id="companyForm">
          <?php echo csrf_field(); ?>
          <?php echo method_field('PUT'); ?>
          
          <div class="md:col-span-2" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 8px;">
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Unique Code</label>
              <input name="unique_code" value="<?php echo e(old('unique_code', $company->unique_code)); ?>" class="hrp-input Rectangle-29" readonly style="font-size: 14px; line-height: 1.5; background-color: #f3f4f6;">
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">GST No</label>
              <input name="gst_no" type="text" placeholder="Enter GST No" value="<?php echo e(old('gst_no', $company->gst_no)); ?>" class="hrp-input Rectangle-29" maxlength="15" style="font-size: 14px; line-height: 1.5;">
              <?php $__errorArgs = ['gst_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Pan No</label>
              <input name="pan_no" type="text" placeholder="Enter PAN No" value="<?php echo e(old('pan_no', $company->pan_no)); ?>" class="hrp-input Rectangle-29" maxlength="10" style="text-transform: uppercase; font-size: 14px; line-height: 1.5;">
              <?php $__errorArgs = ['pan_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Name</label>
            <input name="company_name" type="text" placeholder="Enter your company name" value="<?php echo e(old('company_name', $company->company_name)); ?>" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Address</label>
            <textarea name="company_address" placeholder="Enter Your Address" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" rows="3" style="font-size: 14px; line-height: 1.5; resize: vertical;"><?php echo e(old('company_address', $company->company_address)); ?></textarea>
            <?php $__errorArgs = ['company_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Type</label>
            <div class="relative">
              <select name="company_type" class="hrp-input Rectangle-29" style="
                padding-right: 32px;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E\");
                background-repeat: no-repeat;
                background-position: right 12px center;
                background-size: 16px 16px;
                cursor: pointer;
                text-transform: uppercase;
                width: 100%;
                font-size: 14px;
                line-height: 1.5;
              ">
                <option value="" disabled <?php echo e(old('company_type', $company->company_type) ? '' : 'selected'); ?>>SELECT COMPANY TYPE</option>
                <option value="AUTOMOBILE" <?php echo e(old('company_type', $company->company_type) == 'AUTOMOBILE' ? 'selected' : ''); ?>>AUTOMOBILE</option>
                <option value="FMCG" <?php echo e(old('company_type', $company->company_type) == 'FMCG' ? 'selected' : ''); ?>>FMCG (FAST-MOVING CONSUMER GOODS)</option>
                <option value="IT" <?php echo e(old('company_type', $company->company_type) == 'IT' ? 'selected' : ''); ?>>INFORMATION TECHNOLOGY</option>
                <option value="MANUFACTURING" <?php echo e(old('company_type', $company->company_type) == 'MANUFACTURING' ? 'selected' : ''); ?>>MANUFACTURING</option>
                <option value="CONSTRUCTION" <?php echo e(old('company_type', $company->company_type) == 'CONSTRUCTION' ? 'selected' : ''); ?>>CONSTRUCTION</option>
                <option value="HEALTHCARE" <?php echo e(old('company_type', $company->company_type) == 'HEALTHCARE' ? 'selected' : ''); ?>>HEALTHCARE</option>
                <option value="EDUCATION" <?php echo e(old('company_type', $company->company_type) == 'EDUCATION' ? 'selected' : ''); ?>>EDUCATION</option>
                <option value="FINANCE" <?php echo e(old('company_type', $company->company_type) == 'FINANCE' ? 'selected' : ''); ?>>FINANCE & BANKING</option>
                <option value="RETAIL" <?php echo e(old('company_type', $company->company_type) == 'RETAIL' ? 'selected' : ''); ?>>RETAIL</option>
                <option value="TELECOM" <?php echo e(old('company_type', $company->company_type) == 'TELECOM' ? 'selected' : ''); ?>>TELECOMMUNICATIONS</option>
                <option value="HOSPITALITY" <?php echo e(old('company_type', $company->company_type) == 'HOSPITALITY' ? 'selected' : ''); ?>>HOSPITALITY</option>
                <option value="TRANSPORT" <?php echo e(old('company_type', $company->company_type) == 'TRANSPORT' ? 'selected' : ''); ?>>TRANSPORT & LOGISTICS</option>
                <option value="ENERGY" <?php echo e(old('company_type', $company->company_type) == 'ENERGY' ? 'selected' : ''); ?>>ENERGY & UTILITIES</option>
                <option value="MEDIA" <?php echo e(old('company_type', $company->company_type) == 'MEDIA' ? 'selected' : ''); ?>>MEDIA & ENTERTAINMENT</option>
                <option value="REAL_ESTATE" <?php echo e(old('company_type', $company->company_type) == 'REAL_ESTATE' ? 'selected' : ''); ?>>REAL ESTATE</option>
                <option value="OTHER" <?php echo e(old('company_type', $company->company_type) == 'OTHER' ? 'selected' : ''); ?>>OTHER</option>
              </select>
              <?php $__errorArgs = ['company_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
          </div>

          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">State</label>
            <div class="relative">
              <select name="state" class="hrp-input Rectangle-29" style="
                padding-right: 32px;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E\");
                background-repeat: no-repeat;
                background-position: right 12px center;
                background-size: 16px 16px;
                cursor: pointer;
                width: 100%;
                text-transform: capitalize;
                font-size: 14px;
                line-height: 1.5;
              ">
                <option value="" disabled <?php echo e(old('state', $company->state) ? '' : 'selected'); ?>>SELECT STATE</option>
                <option value="andhra_pradesh" <?php echo e(old('state', $company->state) == 'andhra_pradesh' ? 'selected' : ''); ?>>Andhra Pradesh</option>
                <option value="arunachal_pradesh" <?php echo e(old('state', $company->state) == 'arunachal_pradesh' ? 'selected' : ''); ?>>Arunachal Pradesh</option>
                <option value="assam" <?php echo e(old('state', $company->state) == 'assam' ? 'selected' : ''); ?>>Assam</option>
                <option value="bihar" <?php echo e(old('state', $company->state) == 'bihar' ? 'selected' : ''); ?>>Bihar</option>
                <option value="chhattisgarh" <?php echo e(old('state', $company->state) == 'chhattisgarh' ? 'selected' : ''); ?>>Chhattisgarh</option>
                <option value="goa" <?php echo e(old('state', $company->state) == 'goa' ? 'selected' : ''); ?>>Goa</option>
                <option value="gujarat" <?php echo e(old('state', $company->state) == 'gujarat' ? 'selected' : ''); ?>>Gujarat</option>
                <option value="haryana" <?php echo e(old('state', $company->state) == 'haryana' ? 'selected' : ''); ?>>Haryana</option>
                <option value="himachal_pradesh" <?php echo e(old('state', $company->state) == 'himachal_pradesh' ? 'selected' : ''); ?>>Himachal Pradesh</option>
                <option value="jharkhand" <?php echo e(old('state', $company->state) == 'jharkhand' ? 'selected' : ''); ?>>Jharkhand</option>
                <option value="karnataka" <?php echo e(old('state', $company->state) == 'karnataka' ? 'selected' : ''); ?>>Karnataka</option>
                <option value="kerala" <?php echo e(old('state', $company->state) == 'kerala' ? 'selected' : ''); ?>>Kerala</option>
                <option value="madhya_pradesh" <?php echo e(old('state', $company->state) == 'madhya_pradesh' ? 'selected' : ''); ?>>Madhya Pradesh</option>
                <option value="maharashtra" <?php echo e(old('state', $company->state) == 'maharashtra' ? 'selected' : ''); ?>>Maharashtra</option>
                <option value="manipur" <?php echo e(old('state', $company->state) == 'manipur' ? 'selected' : ''); ?>>Manipur</option>
                <option value="meghalaya" <?php echo e(old('state', $company->state) == 'meghalaya' ? 'selected' : ''); ?>>Meghalaya</option>
                <option value="mizoram" <?php echo e(old('state', $company->state) == 'mizoram' ? 'selected' : ''); ?>>Mizoram</option>
                <option value="nagaland" <?php echo e(old('state', $company->state) == 'nagaland' ? 'selected' : ''); ?>>Nagaland</option>
                <option value="odisha" <?php echo e(old('state', $company->state) == 'odisha' ? 'selected' : ''); ?>>Odisha</option>
                <option value="punjab" <?php echo e(old('state', $company->state) == 'punjab' ? 'selected' : ''); ?>>Punjab</option>
                <option value="rajasthan" <?php echo e(old('state', $company->state) == 'rajasthan' ? 'selected' : ''); ?>>Rajasthan</option>
                <option value="sikkim" <?php echo e(old('state', $company->state) == 'sikkim' ? 'selected' : ''); ?>>Sikkim</option>
                <option value="tamil_nadu" <?php echo e(old('state', $company->state) == 'tamil_nadu' ? 'selected' : ''); ?>>Tamil Nadu</option>
                <option value="telangana" <?php echo e(old('state', $company->state) == 'telangana' ? 'selected' : ''); ?>>Telangana</option>
                <option value="tripura" <?php echo e(old('state', $company->state) == 'tripura' ? 'selected' : ''); ?>>Tripura</option>
                <option value="uttar_pradesh" <?php echo e(old('state', $company->state) == 'uttar_pradesh' ? 'selected' : ''); ?>>Uttar Pradesh</option>
                <option value="uttarakhand" <?php echo e(old('state', $company->state) == 'uttarakhand' ? 'selected' : ''); ?>>Uttarakhand</option>
                <option value="west_bengal" <?php echo e(old('state', $company->state) == 'west_bengal' ? 'selected' : ''); ?>>West Bengal</option>
                <option value="andaman_nicobar" <?php echo e(old('state', $company->state) == 'andaman_nicobar' ? 'selected' : ''); ?>>Andaman and Nicobar Islands</option>
                <option value="chandigarh" <?php echo e(old('state', $company->state) == 'chandigarh' ? 'selected' : ''); ?>>Chandigarh</option>
                <option value="dadra_nagar_haveli" <?php echo e(old('state', $company->state) == 'dadra_nagar_haveli' ? 'selected' : ''); ?>>Dadra and Nagar Haveli and Daman and Diu</option>
                <option value="delhi" <?php echo e(old('state', $company->state) == 'delhi' ? 'selected' : ''); ?>>Delhi</option>
                <option value="jammu_kashmir" <?php echo e(old('state', $company->state) == 'jammu_kashmir' ? 'selected' : ''); ?>>Jammu and Kashmir</option>
                <option value="ladakh" <?php echo e(old('state', $company->state) == 'ladakh' ? 'selected' : ''); ?>>Ladakh</option>
                <option value="lakshadweep" <?php echo e(old('state', $company->state) == 'lakshadweep' ? 'selected' : ''); ?>>Lakshadweep</option>
                <option value="puducherry" <?php echo e(old('state', $company->state) == 'puducherry' ? 'selected' : ''); ?>>Puducherry</option>
              </select>
              <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
          </div>

          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">City</label>
            <div class="relative">
              <select name="city" class="hrp-input Rectangle-29" style="
                padding-right: 32px;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E\");
                background-repeat: no-repeat;
                background-position: right 12px center;
                background-size: 16px 16px;
                cursor: pointer;
                width: 100%;
                font-size: 14px;
                line-height: 1.5;
              ">
                <option value="" disabled <?php echo e(old('city', $company->city) ? '' : 'selected'); ?>>SELECT CITY</option>
                <?php
                  $cities = [
                    'mumbai', 'delhi', 'bengaluru', 'hyderabad', 'ahmedabad', 'chennai', 'kolkata', 'surat',
                    'pune', 'jaipur', 'lucknow', 'kanpur', 'nagpur', 'indore', 'thane', 'bhopal', 'visakhapatnam',
                    'pimpri_chinchwad', 'patna', 'vadodara', 'ghaziabad', 'ludhiana', 'coimbatore', 'kochi', 'nashik',
                    'faridabad', 'gurgaon', 'noida', 'greater_noida', 'raipur', 'kota', 'chandigarh', 'bhubaneswar',
                    'guwahati', 'dehradun', 'ranchi', 'srinagar', 'jammu', 'thiruvananthapuram', 'shimla', 'itanagar',
                    'kohima', 'imphal', 'shillong', 'aizawl', 'gangtok', 'agartala', 'kavaratti', 'puducherry', 'daman',
                    'daman_and_diu', 'port_blair', 'silvassa'
                  ];
                  sort($cities);
                ?>
                <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($city); ?>" <?php echo e(old('city', $company->city) == $city ? 'selected' : ''); ?>>
                    <?php echo e(ucwords(str_replace('_', ' ', $city))); ?>

                  </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
              <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
          </div>

          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Contact Person Name</label>
            <input name="contact_person_name" type="text" placeholder="Enter Contact Person Name" value="<?php echo e(old('contact_person_name', $company->contact_person_name)); ?>" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            <?php $__errorArgs = ['contact_person_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Contact Person Position</label>
            <input name="contact_person_position" placeholder="Enter Contact Person Position" value="<?php echo e(old('contact_person_position', $company->contact_person_position)); ?>" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            <?php $__errorArgs = ['contact_person_position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div style="margin-bottom: 8px;">
            <?php if (isset($component)) { $__componentOriginal7f129feca299ac4c0aa6a1d3bbb99a8a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7f129feca299ac4c0aa6a1d3bbb99a8a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.phone-input','data' => ['name' => 'contact_person_mobile','label' => 'Contact Person Mobile No','value' => old('contact_person_mobile', $company->contact_person_mobile),'placeholder' => '9876543210']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('phone-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'contact_person_mobile','label' => 'Contact Person Mobile No','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('contact_person_mobile', $company->contact_person_mobile)),'placeholder' => '9876543210']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7f129feca299ac4c0aa6a1d3bbb99a8a)): ?>
<?php $attributes = $__attributesOriginal7f129feca299ac4c0aa6a1d3bbb99a8a; ?>
<?php unset($__attributesOriginal7f129feca299ac4c0aa6a1d3bbb99a8a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7f129feca299ac4c0aa6a1d3bbb99a8a)): ?>
<?php $component = $__componentOriginal7f129feca299ac4c0aa6a1d3bbb99a8a; ?>
<?php unset($__componentOriginal7f129feca299ac4c0aa6a1d3bbb99a8a); ?>
<?php endif; ?>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Scope Link</label>
            <input name="scope_link" type="url" placeholder="Enter Scope Link" value="<?php echo e(old('scope_link', $company->scope_link)); ?>" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            <?php $__errorArgs = ['scope_link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">SOP Upload</label>
            <div class="upload-pill Rectangle-29" onclick="document.getElementById('sopInput').click()">
              <div class="choose" style="font-size: 14px;">Choose File</div>
              <div class="filename" id="sopFileName" style="font-size: 14px;"><?php echo e($company->sop_upload ? basename($company->sop_upload) : 'No File Chosen'); ?></div>
              <input id="sopInput" name="sop_upload" type="file" style="display: none;" onchange="updateFileName(this, 'sopFileName')" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
            </div>
            <?php if($company->sop_upload): ?>
              <?php
                $extension = strtolower(pathinfo($company->sop_upload, PATHINFO_EXTENSION));
                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                $fileUrl = route('company.documents.view', ['type' => 'sop', 'filename' => basename($company->sop_upload)]);
              ?>
              <div class="mt-2">
                <?php if($isImage): ?>
                  <div class="mb-2">
                    <img src="<?php echo e($fileUrl); ?>" alt="SOP Preview" class="max-w-xs border rounded p-1">
                  </div>
                <?php endif; ?>
                <div>
                  <a href="<?php echo e($fileUrl); ?>" target="_blank" class="inline-flex items-center text-blue-500 hover:underline text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                    View Current File
                  </a>
                  <span class="text-gray-500 text-xs ml-2">(<?php echo e(Str::upper($extension)); ?>)</span>
                </div>
              </div>
            <?php endif; ?>
            <?php $__errorArgs = ['sop_upload'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <small class="text-gray-500 text-xs block mt-1">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 5MB)</small>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Quotation Upload</label>
            <div class="upload-pill Rectangle-29" onclick="document.getElementById('quotationInput').click()">
              <div class="choose" style="font-size: 14px;">Choose File</div>
              <div class="filename" id="quotationFileName" style="font-size: 14px;"><?php echo e($company->quotation_upload ? basename($company->quotation_upload) : 'No File Chosen'); ?></div>
              <input id="quotationInput" name="quotation_upload" type="file" style="display: none;" onchange="updateFileName(this, 'quotationFileName')" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
            </div>
            <?php if($company->quotation_upload): ?>
              <?php
                $extension = strtolower(pathinfo($company->quotation_upload, PATHINFO_EXTENSION));
                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                $fileUrl = route('company.documents.view', ['type' => 'quotation', 'filename' => basename($company->quotation_upload)]);
              ?>
              <div class="mt-2">
                <?php if($isImage): ?>
                  <div class="mb-2">
                    <img src="<?php echo e($fileUrl); ?>" alt="Quotation Preview" class="max-w-xs border rounded p-1">
                  </div>
                <?php endif; ?>
                <div>
                  <a href="<?php echo e($fileUrl); ?>" target="_blank" class="inline-flex items-center text-blue-500 hover:underline text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                    View Current File
                  </a>
                  <span class="text-gray-500 text-xs ml-2">(<?php echo e(Str::upper($extension)); ?>)</span>
                </div>
              </div>
            <?php endif; ?>
            <?php $__errorArgs = ['quotation_upload'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <small class="text-gray-500 text-xs block mt-1">Accepted formats: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG (Max: 5MB)</small>
          </div>
          <div>
            
          </div>

          <div class="md:col-span-2">
            <h3 class="text-lg font-medium text-gray-700 mb-3" style="font-size: 16px; font-weight: 500; color: #374151; margin-bottom: 12px;">Additional Contact Persons</h3>
          </div>

          <div class="md:col-span-2 grid grid-cols-3 gap-5" style="margin-bottom: 12px;">
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Name 1</label>
              <input name="person_name_1" placeholder="Enter Person Name 1" value="<?php echo e(old('person_name_1', $company->person_name_1)); ?>" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              <?php $__errorArgs = ['person_name_1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Number 1</label>
              <input name="person_number_1" type="tel" placeholder="Enter Person Number 1" value="<?php echo e(old('person_number_1', $company->person_number_1)); ?>" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              <?php $__errorArgs = ['person_number_1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Position 1</label>
              <input name="person_position_1" placeholder="Enter Person Position 1" value="<?php echo e(old('person_position_1', $company->person_position_1)); ?>" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              <?php $__errorArgs = ['person_position_1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
          </div>

          <div class="md:col-span-2 grid grid-cols-3 gap-5" style="margin-bottom: 12px;">
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Name 2</label>
              <input name="person_name_2" placeholder="Enter Person Name 2" value="<?php echo e(old('person_name_2', $company->person_name_2)); ?>" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              <?php $__errorArgs = ['person_name_2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Number 2</label>
              <input name="person_number_2" type="tel" placeholder="Enter Person Number 2" value="<?php echo e(old('person_number_2', $company->person_number_2)); ?>" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              <?php $__errorArgs = ['person_number_2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Position 2</label>
              <input name="person_position_2" placeholder="Enter Person Position 2" value="<?php echo e(old('person_position_2', $company->person_position_2)); ?>" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              <?php $__errorArgs = ['person_position_2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
          </div>

          <div class="md:col-span-2 grid grid-cols-3 gap-5" style="margin-bottom: 12px;">
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Name 3</label>
              <input name="person_name_3" placeholder="Enter Person Name 3" value="<?php echo e(old('person_name_3', $company->person_name_3)); ?>" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              <?php $__errorArgs = ['person_name_3'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Number 3</label>
              <input name="person_number_3" type="tel" placeholder="Enter Person Number 3" value="<?php echo e(old('person_number_3', $company->person_number_3)); ?>" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              <?php $__errorArgs = ['person_number_3'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Position 3</label>
              <input name="person_position_3" placeholder="Enter Person Position 3" value="<?php echo e(old('person_position_3', $company->person_position_3)); ?>" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              <?php $__errorArgs = ['person_position_3'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
          </div>
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Logo</label>
            <input name="company_logo" type="file" class="hrp-input Rectangle-29" style="padding: 8px 12px; font-size: 14px; line-height: 1.5;">
            <?php if($company->company_logo): ?>
              <div class="mt-2">
                <img src="<?php echo e(storage_asset('' . $company->company_logo)); ?>" alt="Company Logo" style="max-width: 100px; max-height: 100px;">
              </div>
            <?php endif; ?>
            <?php $__errorArgs = ['company_logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Other Details</label>
            <textarea name="other_details" placeholder="Enter other details" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" rows="3" style="font-size: 14px; line-height: 1.5; resize: vertical;"><?php echo e(old('other_details', $company->other_details)); ?></textarea>
            <?php $__errorArgs = ['other_details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          
           <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Email</label>
            <input name="company_email" type="email" placeholder="Enter Company Email" value="<?php echo e(old('company_email', $company->company_email)); ?>" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            <?php $__errorArgs = ['company_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Password</label>
            <div style="position: relative;">
              <input name="company_password" id="company_password" type="text" placeholder="Leave blank to keep current password" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5; padding-right: 100px;" autocomplete="new-password">
              <button type="button" onclick="generateCompanyPassword()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #3b82f6; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
            </div>
            <?php $__errorArgs = ['company_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Confirm Password</label>
            <input name="company_password_confirmation" id="company_password_confirmation" type="text" placeholder="Confirm Company Password" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;" autocomplete="new-password">
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Employee Email</label>
            <div style="position: relative;">
              <input name="company_employee_email" id="company_employee_email" type="email" placeholder="Enter Company Employee Email" value="<?php echo e(old('company_employee_email', $company->company_employee_email)); ?>" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5; padding-right: 100px;">
              <button type="button" onclick="generateEmployeeEmailEdit()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
            </div>
            <?php $__errorArgs = ['company_employee_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Employee Password</label>
            <div style="position: relative;">
              <input name="company_employee_password" id="company_employee_password" type="text" placeholder="Leave blank to keep current password" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5; padding-right: 100px;" autocomplete="new-password">
              <button type="button" onclick="generateEmployeePasswordEdit()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
            </div>
            <?php $__errorArgs = ['company_employee_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Confirm Employee Password</label>
            <input name="company_employee_password_confirmation" id="company_employee_password_confirmation" type="text" placeholder="Confirm Employee Password" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;" autocomplete="new-password">
          </div> 
          
          <div class="md:col-span-2">
          <div class="hrp-actions" style="gap:8px">
            <a href="<?php echo e(route('companies.index')); ?>" class="hrp-btn" style="background:#e5e7eb">Cancel</a>
            <button class="hrp-btn hrp-btn-primary">Update Company</button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
  // Function to update file name display
  function updateFileName(input, targetId) {
    const fileName = input.files[0] ? input.files[0].name : 'No File Chosen';
    document.getElementById(targetId).textContent = fileName;
  }

  // Form validation before submission
  document.getElementById('companyForm').addEventListener('submit', function(e) {
    const sopInput = document.getElementById('sopInput');
    const quotationInput = document.getElementById('quotationInput');
    const validFileTypes = {
      'sop': ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/jpg', 'image/png'],
      'quotation': ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'image/jpeg', 'image/jpg', 'image/png']
    };
    let isValid = true;

    // Validate SOP file if selected
    if (sopInput.files.length > 0) {
      const fileType = sopInput.files[0].type;
      if (!validFileTypes.sop.includes(fileType)) {
        alert('Invalid file type for SOP. Please upload a PDF, DOC, DOCX, JPG, JPEG, or PNG file.');
        sopInput.value = '';
        document.getElementById('sopFileName').textContent = 'No File Chosen';
        isValid = false;
      } else if (sopInput.files[0].size > 5 * 1024 * 1024) { // 5MB limit
        alert('SOP file is too large. Maximum size is 5MB.');
        sopInput.value = '';
        document.getElementById('sopFileName').textContent = 'No File Chosen';
        isValid = false;
      }
    }

    // Validate Quotation file if selected
    if (quotationInput.files.length > 0) {
      const fileType = quotationInput.files[0].type;
      if (!validFileTypes.quotation.includes(fileType)) {
        alert('Invalid file type for Quotation. Please upload a PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, or PNG file.');
        quotationInput.value = '';
        document.getElementById('quotationFileName').textContent = 'No File Chosen';
        isValid = false;
      } else if (quotationInput.files[0].size > 5 * 1024 * 1024) { // 5MB limit
        alert('Quotation file is too large. Maximum size is 5MB.');
        quotationInput.value = '';
        document.getElementById('quotationFileName').textContent = 'No File Chosen';
        isValid = false;
      }
    }

    if (!isValid) {
      e.preventDefault();
      return false;
    }
  });

  // Auto-generate company password
  function generateCompanyPassword() {
    const companyNameInput = document.querySelector('input[name="company_name"]');
    const passwordInput = document.getElementById('company_password');
    const confirmPasswordInput = document.getElementById('company_password_confirmation');
    
    if (!companyNameInput || !companyNameInput.value) {
      Swal.fire({
        icon: 'warning',
        title: 'Company Name Required',
        text: 'Please enter company name first to generate password',
        confirmButtonColor: '#3b82f6'
      });
      return;
    }
    
    const companyName = companyNameInput.value.trim();
    
    // Generate password: First 3 letters of company name + random 4 digits + special char
    const prefix = companyName.replace(/[^a-zA-Z]/g, '').substring(0, 3).toLowerCase();
    const randomNum = Math.floor(1000 + Math.random() * 9000);
    const specialChars = ['@', '#', '$', '!'];
    const specialChar = specialChars[Math.floor(Math.random() * specialChars.length)];
    
    const password = prefix + randomNum + specialChar;
    
    passwordInput.value = password;
    confirmPasswordInput.value = password;
    
    // Show success message
    Swal.fire({
      icon: 'success',
      title: 'Password Generated!',
      html: `<p>Password: <strong style="color: #3b82f6; font-size: 18px;">${password}</strong></p><p style="color: #6b7280; font-size: 13px; margin-top: 10px;">Please save this password securely.</p>`,
      confirmButtonColor: '#3b82f6',
      width: '400px'
    });
  }

  // Auto-generate employee email
  function generateEmployeeEmailEdit() {
    const companyNameInput = document.querySelector('input[name="company_name"]');
    const emailInput = document.getElementById('company_employee_email');
    
    if (!companyNameInput || !companyNameInput.value) {
      Swal.fire({
        icon: 'warning',
        title: 'Company Name Required',
        text: 'Please enter company name first to generate employee email',
        confirmButtonColor: '#10b981'
      });
      return;
    }
    
    const companyName = companyNameInput.value.trim();
    
    // Generate email: company name (alphanumeric only) + "emp" + random 3 digits + @example.com
    const emailPrefix = companyName.replace(/[^a-zA-Z0-9]/g, '').toLowerCase();
    const randomNum = Math.floor(100 + Math.random() * 900);
    const email = emailPrefix + 'emp' + randomNum + '@example.com';
    
    emailInput.value = email;
    
    // Show success message
    Swal.fire({
      icon: 'success',
      title: 'Employee Email Generated!',
      html: `<p>Email: <strong style="color: #10b981; font-size: 16px;">${email}</strong></p>`,
      confirmButtonColor: '#10b981',
      width: '400px'
    });
  }

  // Auto-generate employee password
  function generateEmployeePasswordEdit() {
    const companyNameInput = document.querySelector('input[name="company_name"]');
    const passwordInput = document.getElementById('company_employee_password');
    const confirmPasswordInput = document.getElementById('company_employee_password_confirmation');
    
    if (!companyNameInput || !companyNameInput.value) {
      Swal.fire({
        icon: 'warning',
        title: 'Company Name Required',
        text: 'Please enter company name first to generate employee password',
        confirmButtonColor: '#10b981'
      });
      return;
    }
    
    const companyName = companyNameInput.value.trim();
    
    // Generate password: "Emp" + First 3 letters of company name + random 4 digits + special char
    const prefix = 'Emp' + companyName.replace(/[^a-zA-Z]/g, '').substring(0, 3);
    const randomNum = Math.floor(1000 + Math.random() * 9000);
    const specialChars = ['@', '#', '$', '!'];
    const specialChar = specialChars[Math.floor(Math.random() * specialChars.length)];
    
    const password = prefix + randomNum + specialChar;
    
    passwordInput.value = password;
    confirmPasswordInput.value = password;
    
    // Show success message
    Swal.fire({
      icon: 'success',
      title: 'Employee Password Generated!',
      html: `<p>Password: <strong style="color: #10b981; font-size: 18px;">${password}</strong></p><p style="color: #6b7280; font-size: 13px; margin-top: 10px;">Please save this password securely.</p>`,
      confirmButtonColor: '#10b981',
      width: '400px'
    });
  }

  // Existing code
  (function(){
    // Add any necessary JavaScript here
  })();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/companies/edit.blade.php ENDPATH**/ ?>