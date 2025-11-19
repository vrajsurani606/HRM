@extends('layouts.macos')
@section('page_title', $page_title)

@section('content')
  <div class="hrp-card">
      <div class="Rectangle-30 hrp-compact">
      <form method="POST" action="{{ route('hiring.store') }}" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3" id="hiringForm">
        @csrf
        <div>
          <label class="hrp-label">Unique Code:</label>
          <input name="unique_code" value="{{ old('unique_code', $nextCode) }}" class="hrp-input Rectangle-29" readonly>
          @error('unique_code')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
  @push('scripts')
  <script>
    (function(){
      var input = document.getElementById('resumeInput');
      var label = document.getElementById('resumeFileName');
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
      var expFlds = document.getElementById('expFieldsWrap');
      function toggleExpReq(){
        var yes = expSel && expSel.value === '1';
        if(expCnt){ expCnt.required = yes; expCnt.disabled = !yes; if(!yes){ expCnt.value = ''; } }
        if(expComp){ expComp.required = yes; expComp.disabled = !yes; if(!yes){ expComp.value = ''; } }
        if(prevSal){ prevSal.required = yes; prevSal.disabled = !yes; if(!yes){ prevSal.value = ''; } }
        if(expFlds){ expFlds.style.display = yes ? '' : 'none'; }
      }
      if(expSel){ expSel.addEventListener('change', toggleExpReq); toggleExpReq(); }

      var form = document.getElementById('hiringForm');
      if(form){
        form.addEventListener('submit', function(e){
          // leverage HTML5 validation; only custom tweak could be added here if needed
          if(!form.checkValidity()){
            e.preventDefault();
            form.reportValidity();
          }
        });
      }
    })();
  </script>
  @endpush
        <div>
          <label class="hrp-label">Person Name:</label>
          <input name="person_name" value="{{ old('person_name') }}" placeholder="Enter Full Name" class="hrp-input Rectangle-29">
          @error('person_name')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div>
          <label class="hrp-label">Mobile No:</label>
          <input name="mobile_no" value="{{ old('mobile_no') }}" placeholder="10 digit mobile" class="hrp-input Rectangle-29" inputmode="numeric" pattern="\d{10}" maxlength="10">
          @error('mobile_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Address:</label>
          <textarea name="address" placeholder="Enter Your Address" class="hrp-textarea Rectangle-29 Rectangle-29-textarea">{{ old('address') }}</textarea>
          @error('address')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Position:</label>
          <input name="position" value="{{ old('position') }}" placeholder="Enter Position" class="hrp-input Rectangle-29">
          @error('position')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Is experience ?:</label>
          @php($exp = old('is_experience', ''))
          <select name="is_experience" id="is_experience" class="Rectangle-29 Rectangle-29-select">
            <option value="" disabled {{ $exp==='' ? 'selected' : '' }}>Select Experience</option>
            <option value="0" {{ $exp==='0' ? 'selected' : '' }}>No</option>
            <option value="1" {{ $exp==='1' ? 'selected' : '' }}>Yes</option>
          </select>
          @error('is_experience')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div id="expFieldsWrap" class="md:col-span-2" style="display:none">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5">
            <div>
              <label class="hrp-label">Experience Count:</label>
              <input name="experience_count" id="experience_count" value="{{ old('experience_count') }}" placeholder="Enter No. of Exp. e.g. 2.5" class="hrp-input Rectangle-29" type="number" step="0.1" min="0">
              @error('experience_count')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label">Experience previous Company:</label>
              <input name="experience_previous_company" id="experience_previous_company" value="{{ old('experience_previous_company') }}" placeholder="Enter Experience Previous Company Name" class="hrp-input Rectangle-29">
              @error('experience_previous_company')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label">Previous Salary:</label>
              <input name="previous_salary" id="previous_salary" value="{{ old('previous_salary') }}" placeholder="Enter Salary" class="hrp-input Rectangle-29" type="number" step="0.01" min="0">
              @error('previous_salary')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>
        </div>
        <div>
          <label class="hrp-label">Resume Upload:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="resumeFileName">No File Chosen</div>
            <input id="resumeInput" name="resume" type="file" accept=".pdf,.doc,.docx">
          </div>
          @error('resume')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div class="md:col-span-1">
          <label class="hrp-label">Gender:</label>
          @php($g = old('gender'))
          <div class="hrp-segment">
            <input id="g-male" type="radio" name="gender" value="male" {{ $g==='male' ? 'checked' : '' }} ><label for="g-male">Male</label>
            <input id="g-female" type="radio" name="gender" value="female" {{ $g==='female' ? 'checked' : '' }} ><label for="g-female">Female</label>
            <input id="g-other" type="radio" name="gender" value="other" {{ $g==='other' ? 'checked' : '' }} ><label for="g-other">Other</label>
          </div>
          @error('gender')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div class="md:col-span-2">
          <div class="hrp-actions">
            <button type="submit" class="hrp-btn hrp-btn-primary">Add Hiring Lead Master</button>
          </div>
        </div>
      </form>
      </div>

  
    </div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('hiring.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">HRM</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Add New Hiring Lead</span>
@endsection
