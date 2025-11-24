@extends('layouts.macos')
@section('page_title', $page_title)

@section('content')
  <div class="hrp-card">
      <div class="Rectangle-30 hrp-compact">
      <form method="POST" action="{{ route('hiring.convert', $lead->id) }}" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3" id="employeeForm">
        @csrf
        <div>
          <label class="hrp-label">Employee Code:</label>
          <input name="code" value="{{ old('code', $nextCode ?? '') }}" class="hrp-input Rectangle-29" readonly>
          @error('code')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Employee Name:</label>
          <input name="name" value="{{ old('name', $lead->person_name) }}" placeholder="Enter Full Name" class="hrp-input Rectangle-29" required>
          @error('name')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div>
          <label class="hrp-label">Email:</label>
          <input name="email" value="{{ old('email', '') }}" placeholder="Enter Email Address" class="hrp-input Rectangle-29" type="email" required>
          @error('email')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Mobile No:</label>
          <input name="mobile_no" value="{{ old('mobile_no', $lead->mobile_no) }}" placeholder="10 digit mobile" class="hrp-input Rectangle-29" inputmode="numeric" pattern="\d{10}" maxlength="10" required>
          @error('mobile_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Address:</label>
          <textarea name="address" placeholder="Enter Your Address" class="hrp-textarea Rectangle-29 Rectangle-29-textarea">{{ old('address', $lead->address) }}</textarea>
          @error('address')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Position:</label>
          <select name="position" class="Rectangle-29 Rectangle-29-select" required>
            <option value="" disabled>Select Position</option>
            @foreach($positions as $pos)
              <option value="{{ $pos }}" {{ old('position', $lead->position) === $pos ? 'selected' : '' }}>{{ $pos }}</option>
            @endforeach
          </select>
          @error('position')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Experience Type:</label>
          @php($expType = old('experience_type', ''))
          <select name="experience_type" class="Rectangle-29 Rectangle-29-select" required>
            <option value="" disabled {{ $expType==='' ? 'selected' : '' }}>Select Experience Type</option>
            <option value="YES" {{ $expType==='YES' ? 'selected' : '' }}>Experienced</option>
            <option value="NO" {{ $expType==='NO' ? 'selected' : '' }}>Fresher</option>
          </select>
          @error('experience_type')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Joining Date:</label>
          <input name="joining_date" value="{{ old('joining_date') }}" class="hrp-input Rectangle-29" type="date" required>
          @error('joining_date')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Current Offer Amount:</label>
          <input name="current_offer_amount" value="{{ old('current_offer_amount') }}" placeholder="Enter Salary Amount" class="hrp-input Rectangle-29" type="number" step="0.01" min="0">
          @error('current_offer_amount')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Password:</label>
          <input name="password" value="{{ old('password') }}" placeholder="Enter Password (optional)" class="hrp-input Rectangle-29" type="password" min="6">
          @error('password')<small class="hrp-error">{{ $message }}</small>@enderror
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

        <div class="md:col-span-2">
          <div class="hrp-actions">
            <button type="submit" class="hrp-btn hrp-btn-primary">Convert to Employee</button>
            <a href="{{ route('hiring.index') }}" class="hrp-btn hrp-btn-secondary">Cancel</a>
          </div>
        </div>
      </form>
      </div>
  </div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('hiring.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Hiring</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Convert to Employee</span>
@endsection

@push('scripts')
<script>
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
      if(!form.checkValidity()){
        e.preventDefault();
        form.reportValidity();
      }
    });
  }

  // Show success message if present
  @if(session('success'))
    toastr.success('{{ session('success') }}');
  @endif
})();
</script>
@endpush
