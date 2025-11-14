@extends('layouts.macos')
@section('page_title', $page_title)

@section('content')
  <div class="hrp-card">
      <div class="Rectangle-30 hrp-compact">
      <form method="POST" action="{{ route('employees.update', $employee) }}" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3" id="employeeForm">
        @csrf
        @method('PUT')
        <div>
          <label class="hrp-label">Employee Code:</label>
          <input name="code" value="{{ old('code', $employee->code) }}" class="hrp-input Rectangle-29" readonly>
          @error('code')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Status:</label>
          @php($st = old('status', $employee->status))
          <select name="status" class="Rectangle-29 Rectangle-29-select">
            <option value="active" {{ $st==='active'?'selected':'' }}>Active</option>
            <option value="inactive" {{ $st==='inactive'?'selected':'' }}>Inactive</option>
          </select>
          @error('status')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Name:</label>
          <input name="name" value="{{ old('name', $employee->name) }}" placeholder="Enter Full Name" class="hrp-input Rectangle-29" required>
          @error('name')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Email:</label>
          <input name="email" type="email" value="{{ old('email', $employee->email) }}" placeholder="Enter Email" class="hrp-input Rectangle-29" required>
          @error('email')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Mobile No:</label>
          <input name="mobile_no" value="{{ old('mobile_no', $employee->mobile_no) }}" placeholder="10 digit mobile" class="hrp-input Rectangle-29" inputmode="numeric" pattern="\d{10}" maxlength="10">
          @error('mobile_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Position:</label>
          <input name="position" value="{{ old('position', $employee->position) }}" placeholder="Enter Position" class="hrp-input Rectangle-29">
          @error('position')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Experience Type:</label>
          @php($et = old('experience_type', $employee->experience_type))
          <select name="experience_type" class="Rectangle-29 Rectangle-29-select">
            <option value="">Select Experience</option>
            <option value="Experienced" {{ $et==='Experienced'?'selected':'' }}>Experienced</option>
            <option value="Fresher" {{ $et==='Fresher'?'selected':'' }}>Fresher</option>
            <option value="Trainee" {{ $et==='Trainee'?'selected':'' }}>Trainee</option>
            <option value="Intern" {{ $et==='Intern'?'selected':'' }}>Intern</option>
            <option value="Contract" {{ $et==='Contract'?'selected':'' }}>Contract</option>
          </select>
          @error('experience_type')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Joining Date:</label>
          <input name="joining_date" type="date" value="{{ old('joining_date', optional($employee->joining_date)->format('Y-m-d')) }}" class="hrp-input Rectangle-29">
          @error('joining_date')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Date of Birth:</label>
          <input name="date_of_birth" type="date" value="{{ old('date_of_birth', optional($employee->date_of_birth)->format('Y-m-d')) }}" class="hrp-input Rectangle-29">
          @error('date_of_birth')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Current Offer Amount (₹):</label>
          <input name="current_offer_amount" type="number" step="0.01" min="0" value="{{ old('current_offer_amount', $employee->current_offer_amount) }}" class="hrp-input Rectangle-29">
          @error('current_offer_amount')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Previous Salary (₹):</label>
          <input name="previous_salary" type="number" step="0.01" min="0" value="{{ old('previous_salary', $employee->previous_salary) }}" class="hrp-input Rectangle-29">
          @error('previous_salary')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Previous Company:</label>
          <input name="previous_company_name" value="{{ old('previous_company_name', $employee->previous_company_name) }}" class="hrp-input Rectangle-29" placeholder="Enter Previous Company">
          @error('previous_company_name')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Previous Designation:</label>
          <input name="previous_designation" value="{{ old('previous_designation', $employee->previous_designation) }}" class="hrp-input Rectangle-29" placeholder="Enter Previous Designation">
          @error('previous_designation')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div class="md:col-span-2">
          <label class="hrp-label">Address:</label>
          <textarea name="address" placeholder="Enter Address" class="hrp-textarea Rectangle-29 Rectangle-29-textarea">{{ old('address', $employee->address) }}</textarea>
          @error('address')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div class="md:col-span-2">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="hrp-label">Gender:</label>
              @php($g = old('gender', $employee->gender))
              <div class="hrp-segment">
                <input id="g-male" type="radio" name="gender" value="male" {{ $g==='male' ? 'checked' : '' }} ><label for="g-male">Male</label>
                <input id="g-female" type="radio" name="gender" value="female" {{ $g==='female' ? 'checked' : '' }} ><label for="g-female">Female</label>
                <input id="g-other" type="radio" name="gender" value="other" {{ $g==='other' ? 'checked' : '' }} ><label for="g-other">Other</label>
              </div>
              @error('gender')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label">Has Incentive:</label>
              @php($hi = old('has_incentive', $employee->has_incentive))
              <div class="hrp-segment">
                <input id="hi-yes" type="radio" name="has_incentive" value="1" {{ $hi ? 'checked' : '' }} ><label for="hi-yes">Yes</label>
                <input id="hi-no" type="radio" name="has_incentive" value="0" {{ !$hi ? 'checked' : '' }} ><label for="hi-no">No</label>
              </div>
              @error('has_incentive')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label">Incentive Amount (₹):</label>
              <input name="incentive_amount" type="number" step="0.01" min="0" value="{{ old('incentive_amount', $employee->incentive_amount) }}" class="hrp-input Rectangle-29" placeholder="Enter amount">
              @error('incentive_amount')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>
        </div>
        <div class="md:col-span-2">
          <label class="hrp-label">Photo Upload:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="photoFileName">{{ $employee->photo_path ? 'Current photo selected' : 'No File Chosen' }}</div>
            <input id="photoInput" name="photo" type="file" accept="image/*">
          </div>
          @if($employee->photo_path)
            <div class="text-sm" style="margin-top:8px;display:flex;align-items:center;gap:8px">
              <span>Current:</span>
              <img src="{{ asset('storage/'.$employee->photo_path) }}" alt="Photo" style="height:40px;width:40px;object-fit:cover;border-radius:6px;border:1px solid #e5e7eb">
            </div>
          @endif
          @error('photo')<small class="hrp-error">{{ $message }}</small>@enderror
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
  var photoInput = document.getElementById('photoInput');
  var photoLabel = document.getElementById('photoFileName');
  if(photoInput && photoLabel){
    photoInput.addEventListener('change', function(){
      var name = this.files && this.files.length ? this.files[0].name : 'No File Chosen';
      photoLabel.textContent = name;
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
