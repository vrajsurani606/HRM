@extends('layouts.macos')
@section('page_title', $page_title)

@section('content')
  <div class="hrp-card">
      <div class="Rectangle-30 hrp-compact">
      <form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3" id="employeeForm">
        @csrf
        <div>
          <label class="hrp-label">Employee Code:</label>
          <input name="code" value="{{ old('code', $nextCode ?? '') }}" class="hrp-input Rectangle-29" readonly>
          @error('code')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Employee Name:</label>
          <input name="name" value="{{ old('name') }}" placeholder="Enter Full Name" class="hrp-input Rectangle-29" required>
          @error('name')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div>
          <label class="hrp-label">Email:</label>
          <input name="email" value="{{ old('email') }}" placeholder="Enter Email Address" class="hrp-input Rectangle-29" type="email" required>
          @error('email')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Mobile No:</label>
          <input name="mobile" value="{{ old('mobile') }}" placeholder="10 digit mobile" class="hrp-input Rectangle-29" inputmode="numeric" pattern="\d{10}" maxlength="10" required>
          @error('mobile')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Address:</label>
          <textarea name="address" placeholder="Enter Your Address" class="hrp-textarea Rectangle-29 Rectangle-29-textarea">{{ old('address') }}</textarea>
          @error('address')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Position:</label>
          <input name="position" value="{{ old('position') }}" placeholder="Enter Position" class="hrp-input Rectangle-29" required>
          @error('position')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Experience Type:</label>
          @php($expType = old('experience_type', ''))
          <select name="experience_type" class="Rectangle-29 Rectangle-29-select" required>
            <option value="" disabled {{ $expType==='' ? 'selected' : '' }}>Select Experience Type</option>
            <option value="YES" {{ $expType==='Fresher' ? 'selected' : '' }}>YES</option>
            <option value="NO" {{ $expType==='Experienced' ? 'selected' : '' }}>NO</option>
          </select>
          @error('experience_type')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Joining Date:</label>
          <input name="joining_date" value="{{ old('joining_date') }}" class="hrp-input Rectangle-29 date-picker" type="text" placeholder="dd/mm/yyyy" autocomplete="off" required>
          @error('joining_date')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Current Offer Amount:</label>
          <input name="current_offer_amount" value="{{ old('current_offer_amount') }}" placeholder="Enter Salary Amount" class="hrp-input Rectangle-29" type="number" step="0.01" min="0">
          @error('current_offer_amount')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Photo Upload:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="photoFileName">No File Chosen</div>
            <input id="photoInput" name="photo" type="file" accept=".jpg,.jpeg,.png,.gif">
          </div>
          @error('photo')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div class="md:col-span-1">
          <label class="hrp-label">Gender:</label>
          @php($g = old('gender'))
          <div class="hrp-segment">
            <input id="g-male" type="radio" name="gender" value="male" {{ $g==='male' ? 'checked' : '' }} required><label for="g-male">Male</label>
            <input id="g-female" type="radio" name="gender" value="female" {{ $g==='female' ? 'checked' : '' }} required><label for="g-female">Female</label>
            <input id="g-other" type="radio" name="gender" value="other" {{ $g==='other' ? 'checked' : '' }} required><label for="g-other">Other</label>
          </div>
          @error('gender')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div class="md:col-span-2">
          <div class="hrp-actions">
            <button type="submit" class="hrp-btn hrp-btn-primary">Add Employee</button>
          </div>
        </div>
      </form>
      </div>
  </div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('employees.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Employees</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Add New Employee</span>
@endsection

@push('scripts')
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
      // Convert date from dd/mm/yyyy to yyyy-mm-dd before submission
      var dateInput = document.querySelector('input[name="joining_date"]');
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
      
      if(!form.checkValidity()){
        e.preventDefault();
        form.reportValidity();
      }
    });
  }
})();
</script>
@endpush