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
          <input name="mobile_no" id="hiring_mobile_no_edit" value="{{ old('mobile_no', strip_country_code($lead->mobile_no)) }}" placeholder="10 digit mobile" class="hrp-input Rectangle-29" inputmode="numeric" pattern="\d{10}" maxlength="10" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
          @error('mobile_no')<p class="hrp-error">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="hrp-label">Address:</label>
          <textarea name="address" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" placeholder="Enter Your Address" required>{{ old('address', $lead->address) }}</textarea>
          @error('address')<p class="hrp-error">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="hrp-label">Position:</label>
          <x-position-select name="position" id="positionSelectEdit" :value="old('position', $lead->position)" :required="true" />
          @error('position')<p class="hrp-error">{{ $message }}</p>@enderror
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
        <div id="expFieldsWrapEdit" style="display:none" class="md:col-span-2">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5">
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
              <input name="previous_salary" id="previous_salary" value="{{ old('previous_salary', $lead->previous_salary) }}" placeholder="Enter Salary" class="hrp-input Rectangle-29" type="number" step="0.01" min="0">
              @error('previous_salary')<p class="hrp-error">{{ $message }}</p>@enderror
            </div>
          </div>
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
      var prevSal = document.getElementById('previous_salary');
      var expFlds = document.getElementById('expFieldsWrapEdit');
      function toggleExpReq(){
        var yes = expSel && expSel.value === '1';
        if(expCnt){ expCnt.required = yes; expCnt.disabled = !yes; if(!yes){ expCnt.value = ''; } }
        if(expComp){ expComp.required = yes; expComp.disabled = !yes; if(!yes){ expComp.value = ''; } }
        if(prevSal){ prevSal.required = yes; prevSal.disabled = !yes; if(!yes){ prevSal.value = ''; } }
        if(expFlds){ expFlds.style.display = yes ? '' : 'none'; }
      }
      if(expSel){ expSel.addEventListener('change', toggleExpReq); toggleExpReq(); }

      var form = document.getElementById('hiringEditForm');
      if(form){
        form.addEventListener('submit', function(e){
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
