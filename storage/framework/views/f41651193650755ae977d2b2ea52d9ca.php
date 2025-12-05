<?php $__env->startSection('page_title','Edit Inquiry'); ?>

<?php $__env->startSection('content'); ?>
<style>
  .Rectangle-29::placeholder,
  .Rectangle-29-textarea::placeholder {
    color: #9ca3af;
  }
</style>
<div class="Rectangle-30 hrp-compact">

  <form id="inquiryForm" method="POST" action="<?php echo e(route('inquiries.update', $inquiry->id)); ?>" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <!-- Row 1: Unique Code and Inquiry Date -->
    <div>
      <label class="hrp-label">Unique Code:</label>
      <input class="hrp-input Rectangle-29" name="unique_code" value="<?php echo e(old('unique_code', $inquiry->unique_code)); ?>" readonly />
      <?php $__errorArgs = ['unique_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
      <label class="hrp-label">Inquiry Date (dd/mm/yy) :</label>
      <input
        type="text"
        class="hrp-input Rectangle-29 date-picker"
        name="inquiry_date"
        value="<?php echo e(old('inquiry_date', optional($inquiry->inquiry_date)->format('d/m/Y'))); ?>"
        placeholder="dd/mm/yyyy"
        autocomplete="off"
        readonly
      />
      <?php $__errorArgs = ['inquiry_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- Row 2: Company Name and Company Address -->
    <div>
      <label class="hrp-label">Company Name :</label>
      <input class="hrp-input Rectangle-29" name="company_name" value="<?php echo e(old('company_name', $inquiry->company_name)); ?>" placeholder="Enter your company name" />
      <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
      <label class="hrp-label">Company Address:</label>
      <textarea class="hrp-textarea Rectangle-29 Rectangle-29-textarea" name="company_address" placeholder="Enter Your Address" style="height:58px;resize:none;"><?php echo e(old('company_address', $inquiry->company_address)); ?></textarea>
      <?php $__errorArgs = ['company_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- Row 3: Industry Type and Email -->
    <div>
      <label class="hrp-label">Industry Type :</label>
      <?php
        $industries = [
          'Information Technology',
          'Business Process Outsourcing (BPO)',
          'Manufacturing',
          'Automobile',
          'Textiles & Apparel',
          'Pharmaceuticals & Healthcare',
          'Banking, Financial Services & Insurance (BFSI)',
          'Retail & E-commerce',
          'Telecommunications',
          'Real Estate & Construction',
          'Education & Training',
          'Hospitality & Tourism',
          'Logistics & Transportation',
          'Agriculture & Agritech',
          'Media & Entertainment',
        ];
      ?>
      <select class="Rectangle-29 Rectangle-29-select" name="industry_type">
        <option value="">Select Industry Type</option>
        <?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $industry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($industry); ?>" <?php echo e(old('industry_type', $inquiry->industry_type) == $industry ? 'selected' : ''); ?>><?php echo e($industry); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      <?php $__errorArgs = ['industry_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
      <label class="hrp-label">Email :</label>
      <input class="hrp-input Rectangle-29" type="email" name="email" value="<?php echo e(old('email', $inquiry->email)); ?>" placeholder="Enter Company Email" />
      <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- Row 4: Company Mo. No. and City -->
    <div>
      <label class="hrp-label">Company Mo. No. :</label>
      <input
        class="hrp-input Rectangle-29"
        name="company_phone"
        type="tel"
        inputmode="numeric"
        pattern="\d{10}"
        maxlength="10"
        value="<?php echo e(old('company_phone', $inquiry->company_phone)); ?>"
        placeholder="Enter 10 digit mobile number"
      />
      <?php $__errorArgs = ['company_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
      <label class="hrp-label">City</label>
      <?php
        $cities = [
          'Ahmedabad','Surat','Vadodara','Rajkot','Mumbai','Pune','Delhi','Bengaluru',
          'Chennai','Hyderabad','Kolkata','Jaipur','Indore','Nagpur','Nashik','Lucknow',
          'Chandigarh','Bhopal','Coimbatore','Kochi','Noida','Gurugram'
        ];
      ?>
      <select class="Rectangle-29 Rectangle-29-select" name="city">
        <option value="">Select City</option>
        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($city); ?>" <?php echo e(old('city', $inquiry->city) == $city ? 'selected' : ''); ?>><?php echo e($city); ?></option>
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

    <!-- Row 5: State and Contact Person Mobile No -->
    <div>
      <label class="hrp-label">State</label>
      <?php
        $states = [
          'Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat',
          'Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh',
          'Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab',
          'Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh',
          'Uttarakhand','West Bengal','Andaman and Nicobar Islands','Chandigarh',
          'Dadra and Nagar Haveli and Daman and Diu','Delhi','Jammu and Kashmir',
          'Ladakh','Lakshadweep','Puducherry'
        ];
      ?>
      <select class="Rectangle-29 Rectangle-29-select" name="state">
        <option value="">Select State</option>
        <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($state); ?>" <?php echo e(old('state', $inquiry->state) == $state ? 'selected' : ''); ?>><?php echo e($state); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    <div>
      <label class="hrp-label">Contact Person Mobile No:</label>
      <input
        class="hrp-input Rectangle-29"
        name="contact_mobile"
        type="tel"
        inputmode="numeric"
        pattern="\d{10}"
        maxlength="10"
        value="<?php echo e(old('contact_mobile', $inquiry->contact_mobile)); ?>"
        placeholder="Enter 10 digit mobile number"
      />
      <?php $__errorArgs = ['contact_mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- Row 6: Contact Person Name and Scope Link -->
    <div>
      <label class="hrp-label">Contact Person Name:</label>
      <input class="hrp-input Rectangle-29" name="contact_name" value="<?php echo e(old('contact_name', $inquiry->contact_name)); ?>" placeholder="Enter Contact Person Name" />
      <?php $__errorArgs = ['contact_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
      <label class="hrp-label">Scope Link:</label>
      <input class="hrp-input Rectangle-29" name="scope_link" value="<?php echo e(old('scope_link', $inquiry->scope_link)); ?>" placeholder="Enter Scope Link" />
      <?php $__errorArgs = ['scope_link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- Row 7: Contact Person Position and Quotation Upload -->
    <div>
      <label class="hrp-label">Contact Person Position:</label>
      <input class="hrp-input Rectangle-29" name="contact_position" value="<?php echo e(old('contact_position', $inquiry->contact_position)); ?>" placeholder="Enter Contact Person Position" />
      <?php $__errorArgs = ['contact_position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
      <label class="hrp-label">Quotation Upload:</label>
      <div class="upload-pill Rectangle-29">
        <div class="choose">Choose File</div>
        <div class="filename"><?php echo e($inquiry->quotation_file ? basename($inquiry->quotation_file) : 'No File Chosen'); ?></div>
        <input type="file" id="quotation_file" name="quotation_file">
      </div>
      <?php $__errorArgs = ['quotation_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <!-- Row 8: Quotation Sent -->
    <div>
      <label class="hrp-label">Quotation Sent:</label>
      <select class="Rectangle-29-select" name="quotation_sent">
        <option value="">Select Option</option>
        <option value="Yes" <?php echo e(old('quotation_sent', $inquiry->quotation_sent) === 'Yes' ? 'selected' : ''); ?>>Yes</option>
        <option value="No" <?php echo e(old('quotation_sent', $inquiry->quotation_sent) === 'No' ? 'selected' : ''); ?>>No</option>
      </select>
      <?php $__errorArgs = ['quotation_sent'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="md:col-span-2">
      <div style="display:flex;justify-content:flex-end;margin-top:30px;">
        <button type="submit" class="hrp-btn hrp-btn-primary">Update Inquiry</button>
      </div>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
  <a class="hrp-bc-home" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="<?php echo e(route('inquiries.index')); ?>" style="font-weight:800;color:#0f0f0f;text-decoration:none">Inquiry Management</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Edit Inquiry</span>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
// Initialize jQuery datepicker with dd/mm/yyyy format (same as quotation)
$(document).ready(function() {
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
});

document.addEventListener('DOMContentLoaded', function() {
  const fileInput = document.getElementById('quotation_file');
  const filenameSpan = document.querySelector('.filename');
  const form = document.getElementById('inquiryForm');
  const submitBtn = document.getElementById('submitBtn');
  const companyPhoneInput = document.querySelector('input[name="company_phone"]');
  const contactMobileInput = document.querySelector('input[name="contact_mobile"]');
  
  if (fileInput && filenameSpan) {
    fileInput.addEventListener('change', function() {
      if (this.files && this.files[0]) {
        filenameSpan.textContent = this.files[0].name;
        filenameSpan.style.color = '#374151';
      } else {
        filenameSpan.textContent = '<?php echo e($inquiry->quotation_file ? basename($inquiry->quotation_file) : 'No File Chosen'); ?>';
        filenameSpan.style.color = '#9ca3af';
      }
    });
  }

  // Enforce digit-only input for mobile fields (typing and paste)
  function attachDigitOnly(input) {
    if (!input) return;
    input.addEventListener('keypress', function (e) {
      const char = String.fromCharCode(e.which || e.keyCode);
      if (!/\d/.test(char)) {
        e.preventDefault();
      }
    });
    input.addEventListener('input', function () {
      this.value = this.value.replace(/\D+/g, '').slice(0, 10);
    });
  }

  attachDigitOnly(companyPhoneInput);
  attachDigitOnly(contactMobileInput);

  // HTML5 validation-style check: just prevent submit if invalid and show browser messages
  if (form) {
    form.addEventListener('submit', function(e) {
      // Convert date from dd/mm/yyyy to yyyy-mm-dd before submission
      var dateInput = document.querySelector('input[name="inquiry_date"]');
      if(dateInput && dateInput.value){
        var parts = dateInput.value.split('/');
        if(parts.length === 3){
          var day = parts[0];
          var month = parts[1];
          var year = parts[2];
          dateInput.value = year + '-' + month + '-' + day;
        }
      }
      
      if (!form.checkValidity()) {
        e.preventDefault();
        form.reportValidity();
      }
    });
  }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/inquiries/edit.blade.php ENDPATH**/ ?>