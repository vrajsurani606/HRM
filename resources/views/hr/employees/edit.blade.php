@extends('layouts.macos')
@section('page_title', $page_title)

@section('content')
  <div class="hrp-card">
      <div class="Rectangle-30 hrp-compact">
      <form method="POST" action="{{ route('employees.update', $employee) }}" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3" id="employeeForm">
        @csrf
        @method('PUT')
        
        <!-- Employee Code -->
        <div>
          <label class="hrp-label">Employee Code:</label>
          <input name="code" value="{{ old('code', $employee->code) }}" class="hrp-input Rectangle-29" readonly>
          @error('code')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Name -->
        <div>
          <label class="hrp-label">Employee Name:</label>
          <input name="name" value="{{ old('name', $employee->name ?? optional($employee->user)->name) }}" placeholder="Enter Full Name" class="hrp-input Rectangle-29" required>
          @error('name')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Mobile No -->
        <div>
          <label class="hrp-label">Employee Mobile No:</label>
          <input name="mobile_no" value="{{ old('mobile_no', $employee->mobile_no ?? optional($employee->user)->mobile_no) }}" placeholder="Enter Mobile Number" class="hrp-input Rectangle-29">
          @error('mobile_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Address -->
        <div>
          <label class="hrp-label">Employee Address:</label>
          <textarea name="address" placeholder="Enter Address" class="hrp-textarea Rectangle-29 Rectangle-29-textarea">{{ old('address', $employee->address ?? optional($employee->user)->address) }}</textarea>
          @error('address')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Position -->
        <div>
          <label class="hrp-label">Employee Position:</label>
          <select name="position" class="Rectangle-29 Rectangle-29-select">
            <option value="">Select Position</option>
            @if(isset($positions))
              @foreach($positions as $pos)
                <option value="{{ $pos }}" {{ old('position', $employee->position) === $pos ? 'selected' : '' }}>{{ $pos }}</option>
              @endforeach
            @endif
          </select>
          @error('position')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Email -->
        <div>
          <label class="hrp-label">Employee Email:</label>
          <input name="email" type="email" value="{{ old('email', $employee->email ?? optional($employee->user)->email) }}" placeholder="Enter Email" class="hrp-input Rectangle-29" required>
          @error('email')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Password -->
        <div>
          <label class="hrp-label">Employee Password:</label>
          <div class="password-wrapper" style="position: relative;">
            <input name="password" id="passwordInput" type="password" placeholder="Leave blank to keep current password" class="hrp-input Rectangle-29" style="padding-right: 45px;">
            <button type="button" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #666; font-size: 18px; padding: 5px;">
              <i class="fa fa-eye" id="eyeIcon"></i>
            </button>
          </div>
          <small style="color: #666; font-size: 12px; display: block; margin-top: 4px;">Leave blank to keep the current password unchanged</small>
          @error('password')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Reference Name -->
        <div>
          <label class="hrp-label">Employee Reference Name:</label>
          <input name="reference_name" value="{{ old('reference_name', $employee->reference_name) }}" placeholder="Enter Employee Reference Name" class="hrp-input Rectangle-29">
          @error('reference_name')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Reference No -->
        <div>
          <label class="hrp-label">Employee Reference No:</label>
          <input name="reference_no" value="{{ old('reference_no', $employee->reference_no) }}" placeholder="Enter Employee Reference No" class="hrp-input Rectangle-29">
          @error('reference_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Aadhaar No -->
        <div>
          <label class="hrp-label">Employee Aadhaar No:</label>
          <input name="aadhaar_no" value="{{ old('aadhaar_no', $employee->aadhaar_no) }}" placeholder="Enter Aadhaar No" class="hrp-input Rectangle-29" maxlength="12" pattern="[0-9]{12}">
          @error('aadhaar_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Pan No -->
        <div>
          <label class="hrp-label">Employee PAN No:</label>
          <input name="pan_no" value="{{ old('pan_no', $employee->pan_no) }}" placeholder="Enter PAN No" class="hrp-input Rectangle-29" style="text-transform: uppercase;" maxlength="10" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}">
          @error('pan_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Aadhaar Photo 1 -->
        <div>
          <label class="hrp-label">Employee Aadhaar Photo 1:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="aadhaarFrontFileName">{{ $employee->aadhaar_photo_front ? 'Current file selected' : 'No file chosen' }}</div>
            <input id="aadhaarFrontInput" name="aadhaar_photo_front" type="file" accept="image/*">
          </div>
          @if($employee->aadhaar_photo_front)
            <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
              <img src="{{ storage_asset($employee->aadhaar_photo_front) }}" alt="Aadhaar Front" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
              <a href="{{ storage_asset($employee->aadhaar_photo_front) }}" target="_blank" class="hrp-link" style="font-size: 13px; color: #ef4444; text-decoration: none; font-weight: 600;">
                <i class="fa fa-eye"></i> View Full Image
              </a>
            </div>
          @endif
          @error('aadhaar_photo_front')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Aadhaar Photo 2 -->
        <div>
          <label class="hrp-label">Employee Aadhaar Photo 2:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="aadhaarBackFileName">{{ $employee->aadhaar_photo_back ? 'Current file selected' : 'No file chosen' }}</div>
            <input id="aadhaarBackInput" name="aadhaar_photo_back" type="file" accept="image/*">
          </div>
          @if($employee->aadhaar_photo_back)
            <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
              <img src="{{ storage_asset($employee->aadhaar_photo_back) }}" alt="Aadhaar Back" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
              <a href="{{ storage_asset($employee->aadhaar_photo_back) }}" target="_blank" class="hrp-link" style="font-size: 13px; color: #ef4444; text-decoration: none; font-weight: 600;">
                <i class="fa fa-eye"></i> View Full Image
              </a>
            </div>
          @endif
          @error('aadhaar_photo_back')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Pan Photo -->
        <div>
          <label class="hrp-label">Employee Pan Photo:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="panPhotoFileName">{{ $employee->pan_photo ? 'Current file selected' : 'No file chosen' }}</div>
            <input id="panPhotoInput" name="pan_photo" type="file" accept="image/*">
          </div>
          @if($employee->pan_photo)
            <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
              <img src="{{ storage_asset($employee->pan_photo) }}" alt="PAN Photo" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
              <a href="{{ storage_asset($employee->pan_photo) }}" target="_blank" class="hrp-link" style="font-size: 13px; color: #ef4444; text-decoration: none; font-weight: 600;">
                <i class="fa fa-eye"></i> View Full Image
              </a>
            </div>
          @endif
          @error('pan_photo')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Bank Name -->
        <div>
          <label class="hrp-label">Employee Bank Name:</label>
          <input name="bank_name" value="{{ old('bank_name', $employee->bank_name) }}" placeholder="Enter Employee Bank Name" class="hrp-input Rectangle-29">
          @error('bank_name')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Account No -->
        <div>
          <label class="hrp-label">Employee Account No:</label>
          <input name="bank_account_no" value="{{ old('bank_account_no', $employee->bank_account_no) }}" placeholder="Enter Account No" class="hrp-input Rectangle-29">
          @error('bank_account_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Ifsc Code -->
        <div>
          <label class="hrp-label">Employee Ifsc Code:</label>
          <input name="bank_ifsc" value="{{ old('bank_ifsc', $employee->bank_ifsc) }}" placeholder="Enter Ifsc Code" class="hrp-input Rectangle-29">
          @error('bank_ifsc')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Cheque Photo -->
        <div>
          <label class="hrp-label">Employee Cheque Photo:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="chequePhotoFileName">{{ $employee->cheque_photo ? 'Current file selected' : 'No file chosen' }}</div>
            <input id="chequePhotoInput" name="cheque_photo" type="file" accept="image/*">
          </div>
          @if($employee->cheque_photo)
            <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
              <img src="{{ storage_asset($employee->cheque_photo) }}" alt="Cheque Photo" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
              <a href="{{ storage_asset($employee->cheque_photo) }}" target="_blank" class="hrp-link" style="font-size: 13px; color: #ef4444; text-decoration: none; font-weight: 600;">
                <i class="fa fa-eye"></i> View Full Image
              </a>
            </div>
          @endif
          @error('cheque_photo')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Marksheet -->
        <div>
          <label class="hrp-label">Employee Marksheet:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="marksheetFileName">{{ $employee->marksheet_photo ? 'Current file selected' : 'No file chosen' }}</div>
            <input id="marksheetInput" name="marksheet_photo" type="file" accept="image/*">
          </div>
          @if($employee->marksheet_photo)
            <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
              <img src="{{ storage_asset($employee->marksheet_photo) }}" alt="Marksheet" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
              <a href="{{ storage_asset($employee->marksheet_photo) }}" target="_blank" class="hrp-link" style="font-size: 13px; color: #ef4444; text-decoration: none; font-weight: 600;">
                <i class="fa fa-eye"></i> View Full Image
              </a>
            </div>
          @endif
          @error('marksheet_photo')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Photo -->
        <div>
          <label class="hrp-label">Employee Photo:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="photoFileName">{{ $employee->photo_path ? 'Current photo selected' : 'No file chosen' }}</div>
            <input id="photoInput" name="photo" type="file" accept="image/*">
          </div>
          @if($employee->photo_path)
            <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
              <img src="{{ storage_asset($employee->photo_path) }}" alt="Employee Photo" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
              <a href="{{ storage_asset($employee->photo_path) }}" target="_blank" class="hrp-link" style="font-size: 13px; color: #ef4444; text-decoration: none; font-weight: 600;">
                <i class="fa fa-eye"></i> View Full Image
              </a>
            </div>
          @endif
          @error('photo')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Experience Type -->
        <div>
          <label class="hrp-label">Employee Experience Type:</label>
          @php($et = old('experience_type', $employee->experience_type))
          <select name="experience_type" id="experience_type" class="Rectangle-29 Rectangle-29-select">
            <option value="">Select Experience Type</option>
            <option value="YES" {{ $et==='YES'?'selected':'' }}>YES</option>
            <option value="NO" {{ $et==='NO'?'selected':'' }}>NO</option>
          </select>
          @error('experience_type')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div id="experienceFieldsWrap" style="display:none" class="md:col-span-2">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
            <!-- Employee Previous Company Name -->
            <div>
              <label class="hrp-label">Employee Previous Company Name:</label>
              <input name="previous_company_name" id="previous_company_name" value="{{ old('previous_company_name', $employee->previous_company_name) }}" placeholder="Enter Previous Company Name" class="hrp-input Rectangle-29">
              @error('previous_company_name')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            
            <!-- Employee Previous Salary -->
            <div>
              <label class="hrp-label">Employee Previous Salary:</label>
              <input name="previous_salary" id="previous_salary" type="number" step="0.01" min="0" value="{{ old('previous_salary', $employee->previous_salary) }}" placeholder="Enter Previous Salary" class="hrp-input Rectangle-29">
              @error('previous_salary')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>
        </div>
        
        <!-- Employee Current Offer Amount -->
        <div>
          <label class="hrp-label">Employee Current Offer Amount:</label>
          <input name="current_offer_amount" type="number" step="0.01" min="0" value="{{ old('current_offer_amount', $employee->current_offer_amount) }}" placeholder="Enter Employee Current Offer Amount" class="hrp-input Rectangle-29">
          @error('current_offer_amount')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Incentive -->
        <div>
          <label class="hrp-label">Employee Incentive:</label>
          @php($hi = old('has_incentive', $employee->has_incentive ? 'YES' : 'NO'))
          <select name="has_incentive" id="has_incentive" class="Rectangle-29 Rectangle-29-select">
            <option value="">Select Incentive</option>
            <option value="YES" {{ $hi==='YES'?'selected':'' }}>YES</option>
            <option value="NO" {{ $hi==='NO'?'selected':'' }}>NO</option>
          </select>
          @error('has_incentive')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Incentive Amount -->
        <div id="incentiveAmountWrap" style="display:none">
          <label class="hrp-label">Employee Incentive Amount:</label>
          <input name="incentive_amount" id="incentive_amount" type="number" step="0.01" min="0" value="{{ old('incentive_amount', $employee->incentive_amount) }}" placeholder="Enter Employee Incentive Amount" class="hrp-input Rectangle-29">
          @error('incentive_amount')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Gender -->
        <div>
          <label class="hrp-label">Employee Gender:</label>
          @php($g = old('gender', $employee->gender))
          <select name="gender" class="Rectangle-29 Rectangle-29-select">
            <option value="">Select Gender</option>
            <option value="male" {{ $g==='male'?'selected':'' }}>Male</option>
            <option value="female" {{ $g==='female'?'selected':'' }}>Female</option>
            <option value="other" {{ $g==='other'?'selected':'' }}>Other</option>
          </select>
          @error('gender')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Date of Birth -->
        <div>
          <label class="hrp-label">Employee Date of Birth:</label>
          <input name="date_of_birth" type="text" value="{{ old('date_of_birth', optional($employee->date_of_birth)->format('d/m/Y')) }}" class="hrp-input Rectangle-29 date-picker" placeholder="dd/mm/yyyy" autocomplete="off">
          @error('date_of_birth')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Marital Status -->
        <div>
          <label class="hrp-label">Employee Marital Status:</label>
          @php($ms = old('marital_status', $employee->marital_status))
          <select name="marital_status" class="Rectangle-29 Rectangle-29-select">
            <option value="">Select Marital Status</option>
            <option value="single" {{ $ms==='single'?'selected':'' }}>Single</option>
            <option value="married" {{ $ms==='married'?'selected':'' }}>Married</option>
            <option value="other" {{ $ms==='other'?'selected':'' }}>Other</option>
          </select>
          @error('marital_status')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Father Name -->
        <div>
          <label class="hrp-label">Father Name:</label>
          <input name="father_name" value="{{ old('father_name', $employee->father_name ?? '') }}" placeholder="Enter Father Name" class="hrp-input Rectangle-29">
          @error('father_name')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Father Mobile Number -->
        <div>
          <label class="hrp-label">Father Mobile Number:</label>
          <input name="father_mobile" value="{{ old('father_mobile', $employee->father_mobile ?? '') }}" placeholder="10 digit mobile" class="hrp-input Rectangle-29" inputmode="numeric" pattern="\d{10}" maxlength="10">
          @error('father_mobile')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Mother Name -->
        <div>
          <label class="hrp-label">Mother Name:</label>
          <input name="mother_name" value="{{ old('mother_name', $employee->mother_name ?? '') }}" placeholder="Enter Mother Name" class="hrp-input Rectangle-29">
          @error('mother_name')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Mother Mobile Number -->
        <div>
          <label class="hrp-label">Mother Mobile Number:</label>
          <input name="mother_mobile" value="{{ old('mother_mobile', $employee->mother_mobile ?? '') }}" placeholder="10 digit mobile" class="hrp-input Rectangle-29" inputmode="numeric" pattern="\d{10}" maxlength="10">
          @error('mother_mobile')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Joining Date -->
        <div>
          <label class="hrp-label">Employee Joining Date:</label>
          <input name="joining_date" type="text" value="{{ old('joining_date', optional($employee->joining_date)->format('d/m/Y')) }}" class="hrp-input Rectangle-29 date-picker" placeholder="dd/mm/yyyy" autocomplete="off">
          @error('joining_date')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div class="md:col-span-2">
          <div class="hrp-actions">
            <button class="hrp-btn hrp-btn-primary">Update Employee</button>
          </div>
        </div>
      </form>
      </div>
    </div>
@endsection

@push('scripts')
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
  
  // Password toggle functionality
  var togglePassword = document.getElementById('togglePassword');
  var passwordInput = document.getElementById('passwordInput');
  var eyeIcon = document.getElementById('eyeIcon');
  
  if(togglePassword && passwordInput && eyeIcon){
    togglePassword.addEventListener('click', function(){
      if(passwordInput.type === 'password'){
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
      }
    });
  }
  
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
@endpush

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('employees.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Employee</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Edit Employee</span>
@endsection
