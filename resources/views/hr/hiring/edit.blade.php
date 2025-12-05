@extends('layouts.macos')
@section('page_title', $page_title)

@section('content')
  <div class="hrp-card">
    <div class="hrp-card-body">
      <div class="Rectangle-30 hrp-compact">
      <form method="POST" action="{{ route('hiring.update', $lead) }}" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5" id="hiringEditForm">
        @csrf
        @method('PUT')
        <div>
          <label class="hrp-label">Unique Code:</label>
          <input name="unique_code" value="{{ $lead->unique_code }}" class="hrp-input Rectangle-29" readonly>
          @error('unique_code')<p class="hrp-error">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="hrp-label">Person Name:</label>
          <input name="person_name" value="{{ old('person_name', $lead->person_name) }}" placeholder="Enter Full Name" class="hrp-input Rectangle-29" required>
          @error('person_name')<p class="hrp-error">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="hrp-label">Mobile No:</label>
          <input name="mobile_no" value="{{ old('mobile_no', $lead->mobile_no) }}" placeholder="10 digit mobile" class="hrp-input Rectangle-29" inputmode="numeric" pattern="\d{10}" maxlength="10" required>
          @error('mobile_no')<p class="hrp-error">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="hrp-label">Address:</label>
          <textarea name="address" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" placeholder="Enter Your Address" required>{{ old('address', $lead->address) }}</textarea>
          @error('address')<p class="hrp-error">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="hrp-label">Position:</label>
          <select name="position" id="positionSelectEdit" class="Rectangle-29 Rectangle-29-select" required>
            <option value="">Select Position</option>
            <optgroup label="Development">
              <option value="Full Stack Developer" {{ old('position', $lead->position) === 'Full Stack Developer' ? 'selected' : '' }}>Full Stack Developer</option>
              <option value="Frontend Developer" {{ old('position', $lead->position) === 'Frontend Developer' ? 'selected' : '' }}>Frontend Developer</option>
              <option value="Backend Developer" {{ old('position', $lead->position) === 'Backend Developer' ? 'selected' : '' }}>Backend Developer</option>
              <option value="Mobile App Developer" {{ old('position', $lead->position) === 'Mobile App Developer' ? 'selected' : '' }}>Mobile App Developer</option>
              <option value="DevOps Engineer" {{ old('position', $lead->position) === 'DevOps Engineer' ? 'selected' : '' }}>DevOps Engineer</option>
              <option value="Quality Assurance Engineer" {{ old('position', $lead->position) === 'Quality Assurance Engineer' ? 'selected' : '' }}>Quality Assurance Engineer</option>
            </optgroup>
            <optgroup label="Design">
              <option value="UI/UX Designer" {{ old('position', $lead->position) === 'UI/UX Designer' ? 'selected' : '' }}>UI/UX Designer</option>
              <option value="Graphic Designer" {{ old('position', $lead->position) === 'Graphic Designer' ? 'selected' : '' }}>Graphic Designer</option>
            </optgroup>
            <optgroup label="Management">
              <option value="Project Manager" {{ old('position', $lead->position) === 'Project Manager' ? 'selected' : '' }}>Project Manager</option>
              <option value="Team Lead" {{ old('position', $lead->position) === 'Team Lead' ? 'selected' : '' }}>Team Lead</option>
              <option value="Operations Manager" {{ old('position', $lead->position) === 'Operations Manager' ? 'selected' : '' }}>Operations Manager</option>
            </optgroup>
            <optgroup label="Human Resources">
              <option value="HR Executive" {{ old('position', $lead->position) === 'HR Executive' ? 'selected' : '' }}>HR Executive</option>
              <option value="HR Manager" {{ old('position', $lead->position) === 'HR Manager' ? 'selected' : '' }}>HR Manager</option>
            </optgroup>
            <optgroup label="Sales & Marketing">
              <option value="Sales Executive" {{ old('position', $lead->position) === 'Sales Executive' ? 'selected' : '' }}>Sales Executive</option>
              <option value="Sales Manager" {{ old('position', $lead->position) === 'Sales Manager' ? 'selected' : '' }}>Sales Manager</option>
              <option value="Marketing Executive" {{ old('position', $lead->position) === 'Marketing Executive' ? 'selected' : '' }}>Marketing Executive</option>
              <option value="Digital Marketing Specialist" {{ old('position', $lead->position) === 'Digital Marketing Specialist' ? 'selected' : '' }}>Digital Marketing Specialist</option>
              <option value="Content Writer" {{ old('position', $lead->position) === 'Content Writer' ? 'selected' : '' }}>Content Writer</option>
              <option value="SEO Specialist" {{ old('position', $lead->position) === 'SEO Specialist' ? 'selected' : '' }}>SEO Specialist</option>
            </optgroup>
            <optgroup label="Finance & Accounting">
              <option value="Accountant" {{ old('position', $lead->position) === 'Accountant' ? 'selected' : '' }}>Accountant</option>
              <option value="Finance Manager" {{ old('position', $lead->position) === 'Finance Manager' ? 'selected' : '' }}>Finance Manager</option>
            </optgroup>
            <optgroup label="Other Roles">
              <option value="Business Analyst" {{ old('position', $lead->position) === 'Business Analyst' ? 'selected' : '' }}>Business Analyst</option>
              <option value="System Administrator" {{ old('position', $lead->position) === 'System Administrator' ? 'selected' : '' }}>System Administrator</option>
              <option value="Customer Support Executive" {{ old('position', $lead->position) === 'Customer Support Executive' ? 'selected' : '' }}>Customer Support Executive</option>
              <option value="Receptionist" {{ old('position', $lead->position) === 'Receptionist' ? 'selected' : '' }}>Receptionist</option>
              <option value="Intern" {{ old('position', $lead->position) === 'Intern' ? 'selected' : '' }}>Intern</option>
              <option value="Other" {{ old('position', $lead->position) === 'Other' ? 'selected' : '' }}>Other</option>
            </optgroup>
          </select>
          @error('position')<p class="hrp-error">{{ $message }}</p>@enderror
        </div>
        <div id="otherPositionWrapEdit" style="display:none">
          <label class="hrp-label">Specify Position:</label>
          <input name="other_position" id="otherPositionInputEdit" value="{{ old('other_position') }}" placeholder="Enter position name" class="hrp-input Rectangle-29">
          @error('other_position')<p class="hrp-error">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="hrp-label">Is experience ?:</label>
          @php($exp = old('is_experience', $lead->is_experience ? '1' : '0'))
          <select name="is_experience" id="is_experience" class="Rectangle-29 Rectangle-29-select" required>
            <option value="" disabled {{ $exp==='' ? 'selected' : '' }}>Select Experience</option>
            <option value="0" {{ $exp==='0' ? 'selected' : '' }}>No</option>
            <option value="1" {{ $exp==='1' ? 'selected' : '' }}>Yes</option>
          </select>
          @error('is_experience')<p class="hrp-error">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="hrp-label">Experience Count:</label>
          <input name="experience_count" id="experience_count" value="{{ old('experience_count', $lead->experience_count) }}" placeholder="Enter No. of Exp. e.g. 2.5" class="hrp-input Rectangle-29" type="number" step="0.1" min="0">
          @error('experience_count')<p class="hrp-error">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="hrp-label">Previous Company:</label>
          <input name="experience_previous_company" id="experience_previous_company" value="{{ old('experience_previous_company', $lead->experience_previous_company) }}" placeholder="Enter Previous Company Name" class="hrp-input Rectangle-29">
          @error('experience_previous_company')<p class="hrp-error">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="hrp-label">Previous Salary:</label>
          <input name="previous_salary" value="{{ old('previous_salary', $lead->previous_salary) }}" placeholder="Enter Salary" class="hrp-input Rectangle-29" type="number" step="0.01" min="0">
          @error('previous_salary')<p class="hrp-error">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="hrp-label">Resume Upload:</label>
          <div class="upload-pill">
            <div class="choose">Choose File</div>
            <div class="filename" id="resumeFileNameEdit">No File Chosen</div>
            <input id="resumeInputEdit" name="resume" type="file" accept=".pdf,.doc,.docx">
          </div>
          @error('resume')<p class="hrp-error">{{ $message }}</p>@enderror
          @if($lead->resume_path)
            <div class="text-sm" style="margin-top:6px">Current: <a class="hrp-link" href="{{ route('hiring.resume', $lead->id) }}" target="_blank">View</a></div>
          @endif
        </div>
        <div>
          <label class="hrp-label">Gender:</label>
          @php($g = old('gender', $lead->gender))
          <div class="hrp-segment">
            <input id="g-male-edit" type="radio" name="gender" value="male" {{ $g==='male' ? 'checked' : '' }} required><label for="g-male-edit">Male</label>
            <input id="g-female-edit" type="radio" name="gender" value="female" {{ $g==='female' ? 'checked' : '' }} required><label for="g-female-edit">Female</label>
          </div>
          @error('gender')<p class="hrp-error">{{ $message }}</p>@enderror
        </div>
        <div class="md:col-span-2">
          <div class="hrp-actions" style="gap:8px">
            <a href="{{ route('hiring.index') }}" class="hrp-btn" style="background:#e5e7eb">Cancel</a>
            <button class="hrp-btn hrp-btn-primary">Update Hiring Lead</button>
            @php($hasOffer = $lead->offerLetter)
            @if($hasOffer)
              <a href="{{ route('hiring.offer.edit', $lead->id) }}" class="hrp-btn">Edit Offer Letter</a>
              <a href="{{ route('hiring.print', ['id' => $lead->id, 'type' => 'offerletter']) }}" target="_blank" class="hrp-btn">Print Offer Letter</a>
            @else
              <a href="{{ route('hiring.offer.create', $lead->id) }}" class="hrp-btn">Create Offer Letter</a>
            @endif
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
  @push('scripts')
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

      // Handle "Other" position
      var posSel = document.getElementById('positionSelectEdit');
      var otherWrap = document.getElementById('otherPositionWrapEdit');
      var otherInput = document.getElementById('otherPositionInputEdit');
      
      // Check if current position is not in the list (custom position)
      var isCustomPosition = false;
      if(posSel){
        var currentValue = posSel.value;
        var optionExists = Array.from(posSel.options).some(opt => opt.value === currentValue);
        if(currentValue && !optionExists){
          isCustomPosition = true;
          // Set to "Other" and populate the custom field
          posSel.value = 'Other';
          if(otherInput){ otherInput.value = currentValue; }
        }
      }
      
      function toggleOtherPosition(){
        var isOther = posSel && posSel.value === 'Other';
        if(otherWrap){ otherWrap.style.display = isOther ? '' : 'none'; }
        if(otherInput){ 
          otherInput.required = isOther; 
          otherInput.disabled = !isOther;
          if(!isOther && !isCustomPosition){ otherInput.value = ''; }
        }
      }
      if(posSel){ posSel.addEventListener('change', toggleOtherPosition); toggleOtherPosition(); }

      var form = document.getElementById('hiringEditForm');
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
  @endpush
@endsection
