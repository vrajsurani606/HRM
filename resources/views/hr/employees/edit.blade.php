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
          <input name="name" value="{{ old('name', $employee->name) }}" placeholder="Enter Full Name" class="hrp-input Rectangle-29" required>
          @error('name')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Mobile No -->
        <div>
          <label class="hrp-label">Employee Mobile No:</label>
          <input name="mobile_no" value="{{ old('mobile_no', $employee->mobile_no) }}" placeholder="Enter Mobile Number" class="hrp-input Rectangle-29">
          @error('mobile_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Address -->
        <div>
          <label class="hrp-label">Employee Address:</label>
          <textarea name="address" placeholder="Enter Address" class="hrp-textarea Rectangle-29 Rectangle-29-textarea">{{ old('address', $employee->address) }}</textarea>
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
          <input name="email" type="email" value="{{ old('email', $employee->email) }}" placeholder="Enter Email" class="hrp-input Rectangle-29" required>
          @error('email')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Password -->
        <div>
          <label class="hrp-label">Employee Password:</label>
          <input name="password" type="password" placeholder="Enter Password" class="hrp-input Rectangle-29">
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
        
        <!-- Employee Adhar No -->
        <div>
          <label class="hrp-label">Employee Adhar No:</label>
          <input name="aadhaar_no" value="{{ old('aadhaar_no', $employee->aadhaar_no) }}" placeholder="Enter Adhar No" class="hrp-input Rectangle-29">
          @error('aadhaar_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Pan No -->
        <div>
          <label class="hrp-label">Employee Pan No:</label>
          <input name="pan_no" value="{{ old('pan_no', $employee->pan_no) }}" placeholder="Enter Pan No" class="hrp-input Rectangle-29">
          @error('pan_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Adhar Photo 1 -->
        <div>
          <label class="hrp-label">Employee Adhar Photo 1:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="aadhaarFrontFileName">{{ $employee->aadhaar_photo_front ? 'Current file selected' : 'No file chosen' }}</div>
            <input id="aadhaarFrontInput" name="aadhaar_photo_front" type="file" accept="image/*">
          </div>
          @error('aadhaar_photo_front')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Adhar Photo 2 -->
        <div>
          <label class="hrp-label">Employee Adhar Photo 2:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="aadhaarBackFileName">{{ $employee->aadhaar_photo_back ? 'Current file selected' : 'No file chosen' }}</div>
            <input id="aadhaarBackInput" name="aadhaar_photo_back" type="file" accept="image/*">
          </div>
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
          @error('photo')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Experience Type -->
        <div>
          <label class="hrp-label">Employee Experience Type:</label>
          @php($et = old('experience_type', $employee->experience_type))
          <select name="experience_type" class="Rectangle-29 Rectangle-29-select">
            <option value="">Select Experience Type</option>
            <option value="YES" {{ $et==='YES'?'selected':'' }}>YES</option>
            <option value="NO" {{ $et==='NO'?'selected':'' }}>NO</option>
          </select>
          @error('experience_type')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Previous Company Name -->
        <div>
          <label class="hrp-label">Employee Previous Company Name:</label>
          <input name="previous_company_name" value="{{ old('previous_company_name', $employee->previous_company_name) }}" placeholder="Enter Previous Company Name" class="hrp-input Rectangle-29">
          @error('previous_company_name')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Previous Salary -->
        <div>
          <label class="hrp-label">Employee Previous Salary:</label>
          <input name="previous_salary" type="number" step="0.01" min="0" value="{{ old('previous_salary', $employee->previous_salary) }}" placeholder="Enter Previous Salary" class="hrp-input Rectangle-29">
          @error('previous_salary')<small class="hrp-error">{{ $message }}</small>@enderror
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
          <select name="has_incentive" class="Rectangle-29 Rectangle-29-select">
            <option value="">Select Incentive</option>
            <option value="YES" {{ $hi==='YES'?'selected':'' }}>YES</option>
            <option value="NO" {{ $hi==='NO'?'selected':'' }}>NO</option>
          </select>
          @error('has_incentive')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Incentive Amount -->
        <div>
          <label class="hrp-label">Employee Incentive Amount:</label>
          <input name="incentive_amount" type="number" step="0.01" min="0" value="{{ old('incentive_amount', $employee->incentive_amount) }}" placeholder="Enter Employee Incentive Amount" class="hrp-input Rectangle-29">
          @error('incentive_amount')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Employee Joining Date -->
        <div>
          <label class="hrp-label">Employee Joining Date:</label>
          <input name="joining_date" type="date" value="{{ old('joining_date', optional($employee->joining_date)->format('Y-m-d')) }}" class="hrp-input Rectangle-29">
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
<script>
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
