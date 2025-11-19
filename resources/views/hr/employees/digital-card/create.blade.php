@extends('layouts.macos')
@section('page_title', 'Create Digital Card - ' . $employee->name)

@section('content')
  <div class="hrp-card">
      <div class="Rectangle-30 hrp-compact">
      <form method="POST" action="{{ route('employees.digital-card.store', $employee) }}" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3" id="digitalCardForm">
        @csrf
          
        <!-- Basic Information -->
        <div class="md:col-span-2">
          <h3 style="font-weight:800;color:#0f0f0f;margin:20px 0 10px 0;font-size:18px;">Basic Information</h3>
        </div>
        
        <div>
          <label class="hrp-label">Full Name:</label>
          <input name="full_name" value="{{ old('full_name', $employee->name) }}" placeholder="Enter Full Name" class="hrp-input Rectangle-29" required>
          @error('full_name')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div>
          <label class="hrp-label">Current Position:</label>
          <input name="current_position" value="{{ old('current_position', $employee->position) }}" placeholder="Enter Current Position" class="hrp-input Rectangle-29">
          @error('current_position')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div>
          <label class="hrp-label">Company Name:</label>
          <input name="company_name" value="{{ old('company_name') }}" placeholder="Enter Company Name" class="hrp-input Rectangle-29">
          @error('company_name')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div>
          <label class="hrp-label">Years of Experience:</label>
          <input name="years_experience" value="{{ old('years_experience') }}" placeholder="e.g. 3.5" class="hrp-input Rectangle-29" type="number" step="0.1" min="0">
          @error('years_experience')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Contact Information -->
        <div class="md:col-span-2">
          <h3 style="font-weight:800;color:#0f0f0f;margin:20px 0 10px 0;font-size:18px;">Contact Information</h3>
        </div>
        
        <div>
          <label class="hrp-label">Email:</label>
          <input name="email" value="{{ old('email', $employee->email) }}" placeholder="Enter Email" class="hrp-input Rectangle-29" type="email">
          @error('email')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div>
          <label class="hrp-label">Phone:</label>
          <input name="phone" value="{{ old('phone') }}" placeholder="Enter Phone Number" class="hrp-input Rectangle-29">
          @error('phone')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div>
          <label class="hrp-label">LinkedIn Profile:</label>
          <input name="linkedin" value="{{ old('linkedin') }}" placeholder="LinkedIn Profile URL" class="hrp-input Rectangle-29">
          @error('linkedin')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div>
          <label class="hrp-label">Portfolio Website:</label>
          <input name="portfolio" value="{{ old('portfolio') }}" placeholder="Portfolio Website URL" class="hrp-input Rectangle-29">
          @error('portfolio')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div>
          <label class="hrp-label">Facebook:</label>
          <input name="facebook" value="{{ old('facebook') }}" placeholder="Facebook Profile URL" class="hrp-input Rectangle-29">
          @error('facebook')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div>
          <label class="hrp-label">Twitter:</label>
          <input name="twitter" value="{{ old('twitter') }}" placeholder="Twitter Profile URL" class="hrp-input Rectangle-29">
          @error('twitter')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div>
          <label class="hrp-label">Instagram:</label>
          <input name="instagram" value="{{ old('instagram') }}" placeholder="Instagram Profile URL" class="hrp-input Rectangle-29">
          @error('instagram')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div>
          <label class="hrp-label">GitHub:</label>
          <input name="github" value="{{ old('github') }}" placeholder="GitHub Profile URL" class="hrp-input Rectangle-29">
          @error('github')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Location & Preferences -->
        <div class="md:col-span-2">
          <h3 style="font-weight:800;color:#0f0f0f;margin:20px 0 10px 0;font-size:18px;">Location & Preferences</h3>
        </div>
        
        <div class="md:col-span-2">
          <label class="hrp-label">Location:</label>
          <input name="location" value="{{ old('location') }}" placeholder="Enter Location" class="hrp-input Rectangle-29">
          @error('location')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Skills & Summary -->
        <div class="md:col-span-2">
          <h3 style="font-weight:800;color:#0f0f0f;margin:20px 0 10px 0;font-size:18px;">Skills & Summary</h3>
        </div>
        
        <div>
          <label class="hrp-label">Skills (comma separated):</label>
          <textarea name="skills" placeholder="PHP, Laravel, JavaScript, etc." class="hrp-textarea Rectangle-29 Rectangle-29-textarea">{{ old('skills') }}</textarea>
          @error('skills')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div>
          <label class="hrp-label">Hobbies & Interests (comma separated):</label>
          <textarea name="hobbies" placeholder="Reading, Traveling, Photography, etc." class="hrp-textarea Rectangle-29 Rectangle-29-textarea">{{ old('hobbies') }}</textarea>
          @error('hobbies')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div class="md:col-span-2">
          <label class="hrp-label">Professional Summary:</label>
          <textarea name="summary" placeholder="Brief professional summary" class="hrp-textarea Rectangle-29 Rectangle-29-textarea">{{ old('summary') }}</textarea>
          @error('summary')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Previous Roles -->
        <div class="md:col-span-2">
          <h3 style="font-weight:800;color:#0f0f0f;margin:20px 0 10px 0;font-size:18px;">Previous Roles</h3>
          <div id="previousRoles">
            <div class="row role-item" style="margin-bottom:15px;align-items:end;">
              <div class="col-4">
                <label class="hrp-label">Job Title:</label>
                <input name="roles[0][title]" placeholder="Job Title" class="hrp-input Rectangle-29">
              </div>
              <div class="col-4">
                <label class="hrp-label">Company:</label>
                <input name="roles[0][company]" placeholder="Company Name" class="hrp-input Rectangle-29">
              </div>
              <div class="col-3">
                <label class="hrp-label">Year:</label>
                <input name="roles[0][year]" placeholder="2020-2023" class="hrp-input Rectangle-29">
              </div>
              <div class="col-1">
                <button type="button" onclick="addRole()" style="background:#10b981;color:#fff;border:none;padding:8px 12px;border-radius:6px;font-weight:600;width:100%;">+</button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Education -->
        <div class="md:col-span-2">
          <h3 style="font-weight:800;color:#0f0f0f;margin:20px 0 10px 0;font-size:18px;">Education</h3>
          <div id="education">
            <div class="row education-item" style="margin-bottom:15px;align-items:end;">
              <div class="col-4">
                <label class="hrp-label">Degree:</label>
                <input name="education[0][degree]" placeholder="Degree" class="hrp-input Rectangle-29">
              </div>
              <div class="col-4">
                <label class="hrp-label">Institute:</label>
                <input name="education[0][institute]" placeholder="Institute Name" class="hrp-input Rectangle-29">
              </div>
              <div class="col-3">
                <label class="hrp-label">Year:</label>
                <input name="education[0][year]" placeholder="2020" class="hrp-input Rectangle-29">
              </div>
              <div class="col-1">
                <button type="button" onclick="addEducation()" style="background:#10b981;color:#fff;border:none;padding:8px 12px;border-radius:6px;font-weight:600;width:100%;">+</button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Certifications -->
        <div class="md:col-span-2">
          <h3 style="font-weight:800;color:#0f0f0f;margin:20px 0 10px 0;font-size:18px;">Certifications</h3>
          <div id="certifications">
            <div class="row cert-item" style="margin-bottom:15px;align-items:end;">
              <div class="col-4">
                <label class="hrp-label">Certificate Name:</label>
                <input name="certifications[0][name]" placeholder="Certificate Name" class="hrp-input Rectangle-29">
              </div>
              <div class="col-4">
                <label class="hrp-label">Issuing Authority:</label>
                <input name="certifications[0][authority]" placeholder="Issuing Authority" class="hrp-input Rectangle-29">
              </div>
              <div class="col-3">
                <label class="hrp-label">Year:</label>
                <input name="certifications[0][year]" placeholder="2023" class="hrp-input Rectangle-29">
              </div>
              <div class="col-1">
                <button type="button" onclick="addCertification()" style="background:#10b981;color:#fff;border:none;padding:8px 12px;border-radius:6px;font-weight:600;width:100%;">+</button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Gallery -->
        <div class="md:col-span-2">
          <h3 style="font-weight:800;color:#0f0f0f;margin:20px 0 10px 0;font-size:18px;">Gallery</h3>
          <label class="hrp-label">Upload Images:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose Files</div>
            <div class="filename" id="galleryFileName">No Files Chosen</div>
            <input id="galleryInput" name="gallery[]" type="file" accept="image/*" multiple>
          </div>
          @error('gallery')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Achievements & Awards -->
        <div class="md:col-span-2">
          <h3 style="font-weight:800;color:#0f0f0f;margin:20px 0 10px 0;font-size:18px;">Achievements & Awards</h3>
          <div id="achievements">
            <div class="row achievement-item" style="margin-bottom:15px;align-items:end;">
              <div class="col-4">
                <label class="hrp-label">Title:</label>
                <input name="achievements[0][title]" placeholder="Achievement Title" class="hrp-input Rectangle-29">
              </div>
              <div class="col-4">
                <label class="hrp-label">Description:</label>
                <input name="achievements[0][description]" placeholder="Description" class="hrp-input Rectangle-29">
              </div>
              <div class="col-3">
                <label class="hrp-label">Year:</label>
                <input name="achievements[0][year]" placeholder="2023" class="hrp-input Rectangle-29">
              </div>
              <div class="col-1">
                <button type="button" onclick="addAchievement()" style="background:#10b981;color:#fff;border:none;padding:8px 12px;border-radius:6px;font-weight:600;width:100%;">+</button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Languages -->
        <div class="md:col-span-2">
          <h3 style="font-weight:800;color:#0f0f0f;margin:20px 0 10px 0;font-size:18px;">Languages</h3>
          <div id="languages">
            <div class="language-item" style="margin-bottom:10px;">
              <input name="languages[0]" placeholder="Language" class="hrp-input Rectangle-29">
            </div>
          </div>
          <button type="button" onclick="addLanguage()" style="margin-top:10px;background:#10b981;color:#fff;border:none;padding:8px 16px;border-radius:20px;font-weight:600;">+ Add Language</button>
        </div>
        
        <!-- Projects / Portfolio -->
        <div class="md:col-span-2">
          <h3 style="font-weight:800;color:#0f0f0f;margin:20px 0 10px 0;font-size:18px;">Projects / Portfolio</h3>
          <div id="projects">
            <div class="row project-item" style="margin-bottom:15px;align-items:end;">
              <div class="col-4">
                <label class="hrp-label">Project Name:</label>
                <input name="projects[0][name]" placeholder="Project Name" class="hrp-input Rectangle-29">
              </div>
              <div class="col-4">
                <label class="hrp-label">Description:</label>
                <input name="projects[0][description]" placeholder="Project Description" class="hrp-input Rectangle-29">
              </div>
              <div class="col-3">
                <label class="hrp-label">Link:</label>
                <input name="projects[0][link]" placeholder="Project URL" class="hrp-input Rectangle-29">
              </div>
              <div class="col-1">
                <button type="button" onclick="addProject()" style="background:#10b981;color:#fff;border:none;padding:8px 12px;border-radius:6px;font-weight:600;width:100%;">+</button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Upload Resume -->
        <div class="md:col-span-2">
          <h3 style="font-weight:800;color:#0f0f0f;margin:20px 0 10px 0;font-size:18px;">Upload Resume</h3>
          <label class="hrp-label">Resume Upload:</label>
          <div class="upload-pill Rectangle-29">
            <div class="choose">Choose File</div>
            <div class="filename" id="resumeFileName">No File Chosen</div>
            <input id="resumeInput" name="resume" type="file" accept=".pdf,.doc,.docx">
          </div>
          @error('resume')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div class="md:col-span-2">
          <div class="hrp-actions">
            <button class="hrp-btn hrp-btn-primary">Create Digital Card</button>
          </div>
        </div>
      </form>
      </div>
  </div>
@endsection

@push('scripts')
<script>
let roleCount = 1;
let educationCount = 1;
let certCount = 1;
let achievementCount = 1;
let languageCount = 1;
let projectCount = 1;

function addRole() {
  const html = `
    <div class="row role-item" style="margin-bottom:15px;align-items:end;">
      <div class="col-4"><input name="roles[${roleCount}][title]" placeholder="Job Title" class="hrp-input Rectangle-29"></div>
      <div class="col-4"><input name="roles[${roleCount}][company]" placeholder="Company Name" class="hrp-input Rectangle-29"></div>
      <div class="col-3"><input name="roles[${roleCount}][year]" placeholder="2020-2023" class="hrp-input Rectangle-29"></div>
      <div class="col-1"><button type="button" onclick="removeRole(this)" style="background:#ef4444;color:#fff;border:none;padding:8px 12px;border-radius:6px;font-weight:600;width:100%;">×</button></div>
    </div>`;
  document.getElementById('previousRoles').insertAdjacentHTML('beforeend', html);
  roleCount++;
}

function addEducation() {
  const html = `
    <div class="row education-item" style="margin-bottom:15px;align-items:end;">
      <div class="col-4"><input name="education[${educationCount}][degree]" placeholder="Degree" class="hrp-input Rectangle-29"></div>
      <div class="col-4"><input name="education[${educationCount}][institute]" placeholder="Institute Name" class="hrp-input Rectangle-29"></div>
      <div class="col-3"><input name="education[${educationCount}][year]" placeholder="2020" class="hrp-input Rectangle-29"></div>
      <div class="col-1"><button type="button" onclick="removeEducation(this)" style="background:#ef4444;color:#fff;border:none;padding:8px 12px;border-radius:6px;font-weight:600;width:100%;">×</button></div>
    </div>`;
  document.getElementById('education').insertAdjacentHTML('beforeend', html);
  educationCount++;
}

function addCertification() {
  const html = `
    <div class="row cert-item" style="margin-bottom:15px;align-items:end;">
      <div class="col-4"><input name="certifications[${certCount}][name]" placeholder="Certificate Name" class="hrp-input Rectangle-29"></div>
      <div class="col-4"><input name="certifications[${certCount}][authority]" placeholder="Issuing Authority" class="hrp-input Rectangle-29"></div>
      <div class="col-3"><input name="certifications[${certCount}][year]" placeholder="2023" class="hrp-input Rectangle-29"></div>
      <div class="col-1"><button type="button" onclick="removeCertification(this)" style="background:#ef4444;color:#fff;border:none;padding:8px 12px;border-radius:6px;font-weight:600;width:100%;">×</button></div>
    </div>`;
  document.getElementById('certifications').insertAdjacentHTML('beforeend', html);
  certCount++;
}

function addAchievement() {
  const html = `
    <div class="row achievement-item" style="margin-bottom:15px;align-items:end;">
      <div class="col-4"><input name="achievements[${achievementCount}][title]" placeholder="Achievement Title" class="hrp-input Rectangle-29"></div>
      <div class="col-4"><input name="achievements[${achievementCount}][description]" placeholder="Description" class="hrp-input Rectangle-29"></div>
      <div class="col-3"><input name="achievements[${achievementCount}][year]" placeholder="2023" class="hrp-input Rectangle-29"></div>
      <div class="col-1"><button type="button" onclick="removeAchievement(this)" style="background:#ef4444;color:#fff;border:none;padding:8px 12px;border-radius:6px;font-weight:600;width:100%;">×</button></div>
    </div>`;
  document.getElementById('achievements').insertAdjacentHTML('beforeend', html);
  achievementCount++;
}

function addLanguage() {
  const html = `
    <div class="language-item" style="margin-bottom:10px;">
      <input name="languages[${languageCount}]" placeholder="Language" class="hrp-input Rectangle-29">
    </div>`;
  document.getElementById('languages').insertAdjacentHTML('beforeend', html);
  languageCount++;
}

function addProject() {
  const html = `
    <div class="row project-item" style="margin-bottom:15px;align-items:end;">
      <div class="col-4"><input name="projects[${projectCount}][name]" placeholder="Project Name" class="hrp-input Rectangle-29"></div>
      <div class="col-4"><input name="projects[${projectCount}][description]" placeholder="Project Description" class="hrp-input Rectangle-29"></div>
      <div class="col-3"><input name="projects[${projectCount}][link]" placeholder="Project URL" class="hrp-input Rectangle-29"></div>
      <div class="col-1"><button type="button" onclick="removeProject(this)" style="background:#ef4444;color:#fff;border:none;padding:8px 12px;border-radius:6px;font-weight:600;width:100%;">×</button></div>
    </div>`;
  document.getElementById('projects').insertAdjacentHTML('beforeend', html);
  projectCount++;
}

// File upload handlers
document.getElementById('resumeInput').addEventListener('change', function() {
  document.getElementById('resumeFileName').textContent = this.files.length ? this.files[0].name : 'No File Chosen';
});

document.getElementById('galleryInput').addEventListener('change', function() {
  document.getElementById('galleryFileName').textContent = this.files.length ? `${this.files.length} files selected` : 'No Files Chosen';
});
</script>
@endpush

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('employees.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Employees</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Create Digital Card</span>
@endsection