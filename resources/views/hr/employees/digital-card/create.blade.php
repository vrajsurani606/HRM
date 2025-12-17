@extends('layouts.macos')
@section('page_title', isset($isEdit) && $isEdit ? 'Edit Digital Card - ' . $employee->name : 'Create Digital Card - ' . $employee->name)

@push('styles')
<style>
.digital-card-form {
    animation: slideInUp 0.6s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-section {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.form-section:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}

.section-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #f3f4f6;
}

.section-icon {
    width: 24px;
    height: 24px;
    margin-right: 12px;
    color: #3b82f6;
}

.section-title {
    font-size: 18px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.dynamic-field {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 12px;
    transition: all 0.3s ease;
    animation: fadeInScale 0.4s ease-out;
}

@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.dynamic-field:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
}

.add-btn {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.add-btn:hover {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

.remove-btn {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.remove-btn:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    transform: scale(1.05);
}

.file-upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.file-upload-area:hover {
    border-color: #3b82f6;
    background: #f8fafc;
}

.file-upload-area.dragover {
    border-color: #10b981;
    background: #ecfdf5;
}

.progress-bar {
    width: 100%;
    height: 4px;
    background: #e5e7eb;
    border-radius: 2px;
    overflow: hidden;
    margin: 20px 0;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #3b82f6, #10b981);
    border-radius: 2px;
    transition: width 0.3s ease;
    width: 0%;
}

.form-actions {
    position: sticky;
    bottom: 0;
    background: white;
    padding: 20px;
    border-top: 1px solid #e5e7eb;
    margin: 0 -24px -24px;
    border-radius: 0 0 12px 12px;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border: none;
    padding: 12px 32px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-right: 12px;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
    padding: 12px 32px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #e5e7eb;
    transform: translateY(-2px);
}

.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.loading-spinner {
    width: 50px;
    height: 50px;
    border: 4px solid #f3f4f6;
    border-top: 4px solid #3b82f6;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Error states */
.hrp-input.error,
.hrp-textarea.error {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* Success states */
.hrp-input.success,
.hrp-textarea.success {
    border-color: #10b981 !important;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
}

/* Notification styles */
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 16px 20px;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    z-index: 10000;
    max-width: 400px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    animation: slideInRight 0.3s ease-out;
}

.notification.success {
    background: linear-gradient(135deg, #10b981, #059669);
}

.notification.error {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

.notification.warning {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

/* Form field focus effects */
.hrp-input:focus,
.hrp-textarea:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
    outline: none;
}

/* Character counter styling */
.text-muted {
    color: #6b7280;
    font-size: 0.875rem;
    margin-top: 4px;
    display: block;
}

/* Required field indicator */
.hrp-label span[style*="color: red"] {
    color: #ef4444 !important;
    font-weight: bold;
}

/* Improved button hover effects */
.btn-primary:disabled {
    background: #9ca3af !important;
    cursor: not-allowed;
    transform: none !important;
}

.btn-primary:disabled:hover {
    background: #9ca3af !important;
    transform: none !important;
    box-shadow: none !important;
}

/* Grid system improvements */
.grid {
    display: grid;
}

.grid-cols-1 {
    grid-template-columns: repeat(1, minmax(0, 1fr));
}

.grid-cols-2 {
    grid-template-columns: repeat(2, minmax(0, 1fr));
}

.grid-cols-3 {
    grid-template-columns: repeat(3, minmax(0, 1fr));
}

.grid-cols-4 {
    grid-template-columns: repeat(4, minmax(0, 1fr));
}

.gap-3 {
    gap: 0.75rem;
}

.gap-4 {
    gap: 1rem;
}

.flex {
    display: flex;
}

.items-end {
    align-items: flex-end;
}

.items-center {
    align-items: center;
}

/* Responsive grid */
@media (min-width: 768px) {
    .md\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    
    .md\:grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
    
    .md\:grid-cols-4 {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
    
    .md\:col-span-2 {
        grid-column: span 2 / span 2;
    }
}

/* File upload area improvements */
.file-upload-area {
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 120px;
}

.file-upload-area:hover {
    transform: translateY(-2px);
}

/* Dynamic field animations */
.dynamic-field {
    animation: slideInUp 0.4s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endpush

@section('content')
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<div class="hrp-card digital-card-form">
    <div class="Rectangle-30 hrp-compact">
      
      <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success" style="background:#d4edda;color:#155724;padding:12px;border-radius:6px;margin-bottom:20px;border:1px solid #c3e6cb;animation:slideInDown 0.5s ease-out;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger" style="background:#f8d7da;color:#721c24;padding:12px;border-radius:6px;margin-bottom:20px;border:1px solid #f5c6cb;animation:slideInDown 0.5s ease-out;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger" style="background:#f8d7da;color:#721c24;padding:12px;border-radius:6px;margin-bottom:20px;border:1px solid #f5c6cb;animation:slideInDown 0.5s ease-out;">
                <i class="fas fa-exclamation-triangle"></i> Please fix the following errors:
                <ul style="margin:8px 0 0 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="progress-bar">
            <div class="progress-fill" id="progressFill"></div>
        </div>
      <form method="POST" action="{{ isset($isEdit) && $isEdit ? route('employees.digital-card.update', $employee) : route('employees.digital-card.store', $employee) }}" enctype="multipart/form-data" class="hrp-form" id="digitalCardForm">
        @csrf
        @if(isset($isEdit) && $isEdit)
            @method('PUT')
        @endif
          
        <!-- Basic Information -->
        <div class="form-section">
            <div class="section-header">
                <i class="fas fa-user section-icon"></i>
                <h3 class="section-title">Basic Information</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
                <div>
                    <label class="hrp-label">Full Name: <span style="color: red;">*</span></label>
                    <input name="full_name" value="{{ old('full_name', $digitalCard->full_name ?? $employee->name) }}" placeholder="Enter Full Name" class="hrp-input Rectangle-29" required pattern="[A-Za-z\s]+" title="Only letters and spaces allowed">
                    @error('full_name')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                
                <div>
                    <label class="hrp-label">Current Position: <span style="color: red;">*</span></label>
                    <input name="current_position" value="{{ old('current_position', $digitalCard->current_position ?? $employee->position) }}" placeholder="Enter Current Position" class="hrp-input Rectangle-29" required>
                    @error('current_position')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                
                <div>
                    <label class="hrp-label">Company Name: <span style="color: red;">*</span></label>
                    <input name="company_name" value="{{ old('company_name', $digitalCard->company_name ?? '') }}" placeholder="Enter Company Name" class="hrp-input Rectangle-29" required>
                    @error('company_name')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                
                <div>
                    <label class="hrp-label">Years of Experience: <span style="color: red;">*</span></label>
                    <input name="years_experience" value="{{ old('years_experience', $digitalCard->years_of_experience ?? '') }}" placeholder="e.g. 3.5" class="hrp-input Rectangle-29" type="number" step="0.1" min="0" max="50" required>
                    @error('years_experience')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>
        
        <!-- Contact Information -->
        <div class="form-section" style="margin-top: 20px;">
            <div class="section-header">
                <i class="fas fa-address-book section-icon"></i>
                <h3 class="section-title">Contact Information</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
                <div>
                    <label class="hrp-label">Email: <span style="color: red;">*</span></label>
                    <input name="email" value="{{ old('email', $digitalCard->email ?? $employee->email) }}" placeholder="Enter Email" class="hrp-input Rectangle-29" type="email" required>
                    @error('email')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                
                <div>
                    <label class="hrp-label">Phone: <span style="color: red;">*</span></label>
                    <input name="phone" value="{{ old('phone', $digitalCard->phone ?? '') }}" placeholder="Enter Phone Number" class="hrp-input Rectangle-29" pattern="[\+]?[0-9\s\-\(\)]+" title="Please enter a valid phone number" required>
                    @error('phone')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                
                <div>
                    <label class="hrp-label">LinkedIn Profile:</label>
                    <input name="linkedin" value="{{ old('linkedin', $digitalCard->linkedin ?? '') }}" placeholder="https://linkedin.com/in/username" class="hrp-input Rectangle-29" pattern="https?://(www\.)?linkedin\.com/.*" title="Please enter a valid LinkedIn URL">
                    @error('linkedin')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                
                <div>
                    <label class="hrp-label">Portfolio Website:</label>
                    <input name="portfolio" value="{{ old('portfolio', $digitalCard->portfolio ?? '') }}" placeholder="https://yourportfolio.com" class="hrp-input Rectangle-29" type="url">
                    @error('portfolio')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                
                <div>
                    <label class="hrp-label">Facebook:</label>
                    <input name="facebook" value="{{ old('facebook', $digitalCard->facebook ?? '') }}" placeholder="https://facebook.com/username" class="hrp-input Rectangle-29" pattern="https?://(www\.)?facebook\.com/.*" title="Please enter a valid Facebook URL">
                    @error('facebook')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                
                <div>
                    <label class="hrp-label">Twitter:</label>
                    <input name="twitter" value="{{ old('twitter', $digitalCard->twitter ?? '') }}" placeholder="https://twitter.com/username" class="hrp-input Rectangle-29" pattern="https?://(www\.)?twitter\.com/.*" title="Please enter a valid Twitter URL">
                    @error('twitter')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                
                <div>
                    <label class="hrp-label">Instagram:</label>
                    <input name="instagram" value="{{ old('instagram', $digitalCard->instagram ?? '') }}" placeholder="https://instagram.com/username" class="hrp-input Rectangle-29" pattern="https?://(www\.)?instagram\.com/.*" title="Please enter a valid Instagram URL">
                    @error('instagram')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                
                <div>
                    <label class="hrp-label">GitHub:</label>
                    <input name="github" value="{{ old('github', $digitalCard->github ?? '') }}" placeholder="https://github.com/username" class="hrp-input Rectangle-29" pattern="https?://(www\.)?github\.com/.*" title="Please enter a valid GitHub URL">
                    @error('github')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>
        
        <!-- Location & Preferences -->
        <div class="form-section" style="margin-top: 20px;">
            <div class="section-header">
                <i class="fas fa-map-marker-alt section-icon"></i>
                <h3 class="section-title">Location & Preferences</h3>
            </div>
            <div>
                <label class="hrp-label">Location: <span style="color: red;">*</span></label>
                <input name="location" value="{{ old('location', $digitalCard->location ?? '') }}" placeholder="Enter Location (City, Country)" class="hrp-input Rectangle-29" required>
                @error('location')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            
            <div>
                <label class="hrp-label">Willing To:</label>
                <input name="willing_to" value="{{ old('willing_to', $digitalCard->willing_to ?? '') }}" placeholder="e.g., Open to opportunities, Available for freelance" class="hrp-input Rectangle-29" maxlength="255">
                @error('willing_to')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
        </div>
        
        <!-- Skills & Summary -->
        <div class="form-section" style="margin-top: 20px;">
            <div class="section-header">
                <i class="fas fa-code section-icon"></i>
                <h3 class="section-title">Skills & Summary</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="hrp-label">Skills (comma separated): <span style="color: red;">*</span></label>
                    <textarea name="skills" placeholder="PHP, Laravel, JavaScript, React, Node.js, etc." class="hrp-textarea Rectangle-29 Rectangle-29-textarea" required maxlength="500">{{ old('skills', $digitalCard->skills ?? '') }}</textarea>
                    <small class="text-muted">Separate skills with commas. Max 500 characters.</small>
                    @error('skills')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                
                <div>
                    <label class="hrp-label">Hobbies & Interests (comma separated):</label>
                    <textarea name="hobbies" placeholder="Reading, Traveling, Photography, Gaming, etc." class="hrp-textarea Rectangle-29 Rectangle-29-textarea" maxlength="300">{{ old('hobbies', $digitalCard->hobbies ?? '') }}</textarea>
                    <small class="text-muted">Separate hobbies with commas. Max 300 characters.</small>
                    @error('hobbies')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
            </div>
            
            <div style="margin-top: 16px;">
                <label class="hrp-label">Professional Summary: <span style="color: red;">*</span></label>
                <textarea name="summary" placeholder="Write a brief professional summary about yourself, your experience, and career goals. This will be prominently displayed on your digital card." class="hrp-textarea Rectangle-29 Rectangle-29-textarea" required minlength="50" maxlength="1000" rows="4">{{ old('summary', $digitalCard->summary ?? '') }}</textarea>
                <small class="text-muted">Minimum 50 characters, maximum 1000 characters. <span id="summaryCount">0</span>/1000</small>
                @error('summary')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
        </div>
        
        <!-- Previous Roles -->
        <div class="form-section" style="margin-top: 20px;">
            <div class="section-header">
                <i class="fas fa-briefcase section-icon"></i>
                <h3 class="section-title">Previous Roles</h3>
            </div>
          <div id="previousRoles">
            <div class="dynamic-field role-item">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div>
                        <label class="hrp-label">Job Title:</label>
                        <input name="roles[0][title]" placeholder="Job Title" class="hrp-input Rectangle-29">
                    </div>
                    <div>
                        <label class="hrp-label">Company:</label>
                        <input name="roles[0][company]" placeholder="Company Name" class="hrp-input Rectangle-29">
                    </div>
                    <div>
                        <label class="hrp-label">Year:</label>
                        <input name="roles[0][year]" placeholder="2020-2023" class="hrp-input Rectangle-29">
                    </div>
                    <div class="flex items-end">
                        <button type="button" onclick="addRole()" class="add-btn">
                            <i class="fas fa-plus"></i> Add Role
                        </button>
                    </div>
                </div>
                <div style="margin-top: 12px;">
                    <label class="hrp-label">Description:</label>
                    <textarea name="roles[0][description]" placeholder="Brief description of your role and responsibilities" class="hrp-textarea Rectangle-29" rows="2"></textarea>
                </div>
            </div>
          </div>
        </div>
        
        <!-- Education -->
        <div class="form-section" style="margin-top: 20px;">
            <div class="section-header">
                <i class="fas fa-graduation-cap section-icon"></i>
                <h3 class="section-title">Education</h3>
            </div>
          <div id="education">
            <div class="dynamic-field education-item">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div>
                        <label class="hrp-label">Degree:</label>
                        <input name="education[0][degree]" placeholder="Bachelor's, Master's, PhD" class="hrp-input Rectangle-29">
                    </div>
                    <div>
                        <label class="hrp-label">Institute:</label>
                        <input name="education[0][institute]" placeholder="Institute Name" class="hrp-input Rectangle-29">
                    </div>
                    <div>
                        <label class="hrp-label">Year:</label>
                        <input name="education[0][year]" placeholder="2020" class="hrp-input Rectangle-29">
                    </div>
                    <div class="flex items-end">
                        <button type="button" onclick="addEducation()" class="add-btn">
                            <i class="fas fa-plus"></i> Add Education
                        </button>
                    </div>
                </div>
                <div style="margin-top: 12px;">
                    <label class="hrp-label">Description:</label>
                    <textarea name="education[0][description]" placeholder="Additional details about your education" class="hrp-textarea Rectangle-29" rows="2"></textarea>
                </div>
            </div>
          </div>
        </div>
        
        <!-- Certifications -->
        <div class="form-section" style="margin-top: 20px;">
            <div class="section-header">
                <i class="fas fa-certificate section-icon"></i>
                <h3 class="section-title">Certifications</h3>
            </div>
          <div id="certifications">
            <div class="dynamic-field cert-item">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div>
                        <label class="hrp-label">Certificate Name:</label>
                        <input name="certifications[0][name]" placeholder="Certificate Name" class="hrp-input Rectangle-29">
                    </div>
                    <div>
                        <label class="hrp-label">Issuing Authority:</label>
                        <input name="certifications[0][authority]" placeholder="Issuing Authority" class="hrp-input Rectangle-29">
                    </div>
                    <div>
                        <label class="hrp-label">Year:</label>
                        <input name="certifications[0][year]" placeholder="2023" class="hrp-input Rectangle-29">
                    </div>
                    <div class="flex items-end">
                        <button type="button" onclick="addCertification()" class="add-btn">
                            <i class="fas fa-plus"></i> Add Certification
                        </button>
                    </div>
                </div>
            </div>
          </div>
        </div>
        
        <!-- Gallery -->
        <div class="form-section" style="margin-top: 20px;">
            <div class="section-header">
                <i class="fas fa-images section-icon"></i>
                <h3 class="section-title">Gallery</h3>
            </div>
          <label class="hrp-label">Upload Images:</label>
          <div class="file-upload-area" onclick="document.getElementById('galleryInput').click()">
            <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #6b7280; margin-bottom: 1rem;"></i>
            <p style="margin: 0; color: #6b7280; font-weight: 600;">Click to upload images or drag and drop</p>
            <p style="margin: 0; color: #9ca3af; font-size: 0.875rem;">PNG, JPG, GIF, WebP up to 5MB each</p>
            <div class="filename" id="galleryFileName" style="margin-top: 1rem; font-weight: 600; color: #374151;">No Files Chosen</div>
            <input id="galleryInput" name="gallery[]" type="file" accept="image/*" multiple style="display: none;">
          </div>
          @error('gallery')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <!-- Achievements & Awards -->
        <div class="form-section" style="margin-top: 20px;">
            <div class="section-header">
                <i class="fas fa-trophy section-icon"></i>
                <h3 class="section-title">Achievements & Awards</h3>
            </div>
          <div id="achievements">
            <div class="dynamic-field achievement-item">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div>
                        <label class="hrp-label">Title:</label>
                        <input name="achievements[0][title]" placeholder="Achievement Title" class="hrp-input Rectangle-29">
                    </div>
                    <div>
                        <label class="hrp-label">Year:</label>
                        <input name="achievements[0][year]" placeholder="2023" class="hrp-input Rectangle-29">
                    </div>
                    <div class="md:col-span-2 flex items-end">
                        <button type="button" onclick="addAchievement()" class="add-btn">
                            <i class="fas fa-plus"></i> Add Achievement
                        </button>
                    </div>
                </div>
                <div style="margin-top: 12px;">
                    <label class="hrp-label">Description:</label>
                    <textarea name="achievements[0][description]" placeholder="Describe your achievement and its impact" class="hrp-textarea Rectangle-29" rows="2"></textarea>
                </div>
            </div>
          </div>
        </div>
        
        <!-- Languages -->
        <div class="form-section" style="margin-top: 20px;">
            <div class="section-header">
                <i class="fas fa-language section-icon"></i>
                <h3 class="section-title">Languages</h3>
            </div>
          <div id="languages">
            <div class="dynamic-field language-item">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="hrp-label">Language:</label>
                        <input name="languages[0][name]" placeholder="e.g., English, Spanish, French" class="hrp-input Rectangle-29">
                    </div>
                    <div>
                        <label class="hrp-label">Proficiency:</label>
                        <select name="languages[0][proficiency]" class="hrp-input Rectangle-29">
                            <option value="">Select Proficiency</option>
                            <option value="Native">Native</option>
                            <option value="Fluent">Fluent</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Basic">Basic</option>
                        </select>
                    </div>
                </div>
                <div style="margin-top: 12px;">
                    <button type="button" onclick="addLanguage()" class="add-btn">
                        <i class="fas fa-plus"></i> Add Language
                    </button>
                </div>
            </div>
          </div>
        </div>
        
        <!-- Projects / Portfolio -->
        <div class="form-section" style="margin-top: 20px;">
            <div class="section-header">
                <i class="fas fa-project-diagram section-icon"></i>
                <h3 class="section-title">Projects / Portfolio</h3>
            </div>
          <div id="projects">
            <div class="dynamic-field project-item">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="hrp-label">Project Name:</label>
                        <input name="projects[0][name]" placeholder="Project Name" class="hrp-input Rectangle-29">
                    </div>
                    <div>
                        <label class="hrp-label">Technologies:</label>
                        <input name="projects[0][technologies]" placeholder="React, Node.js, MongoDB" class="hrp-input Rectangle-29">
                    </div>
                    <div>
                        <label class="hrp-label">Project URL:</label>
                        <input name="projects[0][link]" placeholder="https://project-url.com" class="hrp-input Rectangle-29" type="url">
                    </div>
                    <div>
                        <label class="hrp-label">Duration:</label>
                        <input name="projects[0][duration]" placeholder="3 months" class="hrp-input Rectangle-29">
                    </div>
                </div>
                <div style="margin-top: 12px;">
                    <label class="hrp-label">Description:</label>
                    <textarea name="projects[0][description]" placeholder="Brief description of the project and your role" class="hrp-textarea Rectangle-29" rows="2"></textarea>
                </div>
                <div style="margin-top: 12px;">
                    <button type="button" onclick="addProject()" class="add-btn">
                        <i class="fas fa-plus"></i> Add Project
                    </button>
                </div>
            </div>
          </div>
        </div>
        
        <!-- Upload Resume -->
        <div class="form-section" style="margin-top: 20px;">
            <div class="section-header">
                <i class="fas fa-file-pdf section-icon"></i>
                <h3 class="section-title">Upload Resume</h3>
            </div>
          <label class="hrp-label">Resume Upload:</label>
          <div class="file-upload-area" onclick="document.getElementById('resumeInput').click()">
            <i class="fas fa-file-upload" style="font-size: 2rem; color: #6b7280; margin-bottom: 1rem;"></i>
            <p style="margin: 0; color: #6b7280; font-weight: 600;">Click to upload resume or drag and drop</p>
            <p style="margin: 0; color: #9ca3af; font-size: 0.875rem;">PDF, DOC, DOCX up to 10MB</p>
            <div class="filename" id="resumeFileName" style="margin-top: 1rem; font-weight: 600; color: #374151;">No File Chosen</div>
            <input id="resumeInput" name="resume" type="file" accept=".pdf,.doc,.docx" style="display: none;">
          </div>
          @error('resume')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-primary" id="submitBtn">
                <i class="fas fa-save"></i>
                {{ isset($isEdit) && $isEdit ? 'Update Digital Card' : 'Create Digital Card' }}
            </button>
            <a href="{{ route('employees.digital-card.show', $employee) }}" class="btn-secondary">
                <i class="fas fa-times"></i>
                Cancel
            </a>
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

// Initialize form progress tracking
let totalFields = 0;
let filledFields = 0;

// Enhanced form validation
function validateForm() {
    const form = document.getElementById('digitalCardForm');
    let isValid = true;
    let errors = [];

    // Required field validation
    const requiredFields = [
        { name: 'full_name', label: 'Full Name', pattern: /^[A-Za-z\s]+$/ },
        { name: 'current_position', label: 'Current Position' },
        { name: 'company_name', label: 'Company Name' },
        { name: 'years_experience', label: 'Years of Experience', min: 0, max: 50 },
        { name: 'email', label: 'Email', type: 'email' },
        { name: 'phone', label: 'Phone', pattern: /^[\+]?[0-9\s\-\(\)]+$/ },
        { name: 'location', label: 'Location' },
        { name: 'summary', label: 'Professional Summary', minLength: 50, maxLength: 1000 },
        { name: 'skills', label: 'Skills', maxLength: 500 }
    ];

    requiredFields.forEach(field => {
        const input = form.querySelector(`[name="${field.name}"]`);
        const value = input.value.trim();

        if (!value) {
            errors.push(`${field.label} is required.`);
            input.classList.add('error');
            isValid = false;
        } else {
            input.classList.remove('error');

            // Pattern validation
            if (field.pattern && !field.pattern.test(value)) {
                errors.push(`${field.label} format is invalid.`);
                input.classList.add('error');
                isValid = false;
            }

            // Email validation
            if (field.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                errors.push(`${field.label} format is invalid.`);
                input.classList.add('error');
                isValid = false;
            }

            // Length validation
            if (field.minLength && value.length < field.minLength) {
                errors.push(`${field.label} must be at least ${field.minLength} characters.`);
                input.classList.add('error');
                isValid = false;
            }

            if (field.maxLength && value.length > field.maxLength) {
                errors.push(`${field.label} must not exceed ${field.maxLength} characters.`);
                input.classList.add('error');
                isValid = false;
            }

            // Number validation
            if (field.min !== undefined && parseFloat(value) < field.min) {
                errors.push(`${field.label} must be at least ${field.min}.`);
                input.classList.add('error');
                isValid = false;
            }

            if (field.max !== undefined && parseFloat(value) > field.max) {
                errors.push(`${field.label} must not exceed ${field.max}.`);
                input.classList.add('error');
                isValid = false;
            }
        }
    });

    // URL validation for social links
    const urlFields = ['linkedin', 'github', 'twitter', 'instagram', 'facebook', 'portfolio'];
    urlFields.forEach(fieldName => {
        const input = form.querySelector(`[name="${fieldName}"]`);
        const value = input.value.trim();
        
        if (value) {
            if (fieldName === 'linkedin' && !/^https?:\/\/(www\.)?linkedin\.com\/.*/.test(value)) {
                errors.push('LinkedIn URL format is invalid.');
                input.classList.add('error');
                isValid = false;
            } else if (fieldName === 'github' && !/^https?:\/\/(www\.)?github\.com\/.*/.test(value)) {
                errors.push('GitHub URL format is invalid.');
                input.classList.add('error');
                isValid = false;
            } else if (fieldName === 'twitter' && !/^https?:\/\/(www\.)?twitter\.com\/.*/.test(value)) {
                errors.push('Twitter URL format is invalid.');
                input.classList.add('error');
                isValid = false;
            } else if (fieldName === 'instagram' && !/^https?:\/\/(www\.)?instagram\.com\/.*/.test(value)) {
                errors.push('Instagram URL format is invalid.');
                input.classList.add('error');
                isValid = false;
            } else if (fieldName === 'facebook' && !/^https?:\/\/(www\.)?facebook\.com\/.*/.test(value)) {
                errors.push('Facebook URL format is invalid.');
                input.classList.add('error');
                isValid = false;
            } else if (fieldName === 'portfolio' && !/^https?:\/\/.*/.test(value)) {
                errors.push('Portfolio URL must start with http:// or https://');
                input.classList.add('error');
                isValid = false;
            } else {
                input.classList.remove('error');
            }
        }
    });

    if (!isValid) {
        showNotification('Please fix the following errors:\n' + errors.join('\n'), 'error');
    }

    return isValid;
}

// Character counting for summary
document.addEventListener('DOMContentLoaded', function() {
    const summaryTextarea = document.querySelector('textarea[name="summary"]');
    const summaryCount = document.getElementById('summaryCount');
    
    if (summaryTextarea && summaryCount) {
        function updateCount() {
            const count = summaryTextarea.value.length;
            summaryCount.textContent = count;
            
            if (count < 50) {
                summaryCount.style.color = '#ef4444';
            } else if (count > 900) {
                summaryCount.style.color = '#f59e0b';
            } else {
                summaryCount.style.color = '#10b981';
            }
        }
        
        summaryTextarea.addEventListener('input', updateCount);
        updateCount(); // Initial count
    }
});

// Form submission handling with enhanced animations
document.getElementById('digitalCardForm').addEventListener('submit', function(e) {
    // Validate form
    if (!validateForm()) {
        e.preventDefault();
        return false;
    }
    
    // Show loading overlay
    document.getElementById('loadingOverlay').style.display = 'flex';
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    
    // Re-enable after 15 seconds as fallback
    setTimeout(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-save"></i> {{ isset($isEdit) && $isEdit ? "Update Digital Card" : "Create Digital Card" }}';
        document.getElementById('loadingOverlay').style.display = 'none';
    }, 15000);
});

// Progress tracking
function updateProgress() {
    const inputs = document.querySelectorAll('input, textarea, select');
    totalFields = inputs.length;
    filledFields = 0;
    
    inputs.forEach(input => {
        if (input.value.trim() !== '') {
            filledFields++;
        }
    });
    
    const progress = (filledFields / totalFields) * 100;
    document.getElementById('progressFill').style.width = progress + '%';
}

// Add event listeners to all form inputs
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('input', updateProgress);
        input.addEventListener('change', updateProgress);
    });
    
    // Initial progress calculation
    updateProgress();
});

// Notification system
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'}"></i>
        ${message}
    `;
    
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'error' ? '#ef4444' : '#10b981'};
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        z-index: 10000;
        animation: slideInRight 0.3s ease-out;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-in';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Add CSS for notifications
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    @keyframes slideInDown {
        from { transform: translateY(-100%); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
`;
document.head.appendChild(style);

function addRole() {
    const html = `
        <div class="dynamic-field role-item">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div>
                    <label class="hrp-label">Job Title:</label>
                    <input name="roles[${roleCount}][title]" placeholder="Job Title" class="hrp-input Rectangle-29">
                </div>
                <div>
                    <label class="hrp-label">Company:</label>
                    <input name="roles[${roleCount}][company]" placeholder="Company Name" class="hrp-input Rectangle-29">
                </div>
                <div>
                    <label class="hrp-label">Year:</label>
                    <input name="roles[${roleCount}][year]" placeholder="2020-2023" class="hrp-input Rectangle-29">
                </div>
                <div class="flex items-end">
                    <button type="button" onclick="removeRole(this)" class="remove-btn">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
            </div>
            <div style="margin-top: 12px;">
                <label class="hrp-label">Description:</label>
                <textarea name="roles[${roleCount}][description]" placeholder="Brief description of your role and responsibilities" class="hrp-textarea Rectangle-29" rows="2"></textarea>
            </div>
        </div>`;
    document.getElementById('previousRoles').insertAdjacentHTML('beforeend', html);
    roleCount++;
    updateProgress();
    showNotification('Role field added successfully!', 'success');
}

function addEducation() {
    const html = `
        <div class="dynamic-field education-item">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div>
                    <label class="hrp-label">Degree:</label>
                    <input name="education[${educationCount}][degree]" placeholder="Bachelor's, Master's, PhD" class="hrp-input Rectangle-29">
                </div>
                <div>
                    <label class="hrp-label">Institute:</label>
                    <input name="education[${educationCount}][institute]" placeholder="Institute Name" class="hrp-input Rectangle-29">
                </div>
                <div>
                    <label class="hrp-label">Year:</label>
                    <input name="education[${educationCount}][year]" placeholder="2020" class="hrp-input Rectangle-29">
                </div>
                <div class="flex items-end">
                    <button type="button" onclick="removeEducation(this)" class="remove-btn">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
            </div>
            <div style="margin-top: 12px;">
                <label class="hrp-label">Description:</label>
                <textarea name="education[${educationCount}][description]" placeholder="Additional details about your education" class="hrp-textarea Rectangle-29" rows="2"></textarea>
            </div>
        </div>`;
    document.getElementById('education').insertAdjacentHTML('beforeend', html);
    educationCount++;
    updateProgress();
    showNotification('Education field added successfully!', 'success');
}

function addCertification() {
    const html = `
        <div class="dynamic-field cert-item">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div>
                    <label class="hrp-label">Certificate Name:</label>
                    <input name="certifications[${certCount}][name]" placeholder="Certificate Name" class="hrp-input Rectangle-29">
                </div>
                <div>
                    <label class="hrp-label">Issuing Authority:</label>
                    <input name="certifications[${certCount}][authority]" placeholder="Issuing Authority" class="hrp-input Rectangle-29">
                </div>
                <div>
                    <label class="hrp-label">Date:</label>
                    <input name="certifications[${certCount}][date]" placeholder="Jan 2023" class="hrp-input Rectangle-29">
                </div>
                <div class="flex items-end">
                    <button type="button" onclick="removeCertification(this)" class="remove-btn">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
            </div>
        </div>`;
    document.getElementById('certifications').insertAdjacentHTML('beforeend', html);
    certCount++;
    updateProgress();
    showNotification('Certification field added successfully!', 'success');
}

function addAchievement() {
    const html = `
        <div class="dynamic-field achievement-item">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div>
                    <label class="hrp-label">Title:</label>
                    <input name="achievements[${achievementCount}][title]" placeholder="Achievement Title" class="hrp-input Rectangle-29">
                </div>
                <div>
                    <label class="hrp-label">Year:</label>
                    <input name="achievements[${achievementCount}][year]" placeholder="2023" class="hrp-input Rectangle-29">
                </div>
                <div class="md:col-span-2 flex items-end">
                    <button type="button" onclick="removeAchievement(this)" class="remove-btn">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
            </div>
            <div style="margin-top: 12px;">
                <label class="hrp-label">Description:</label>
                <textarea name="achievements[${achievementCount}][description]" placeholder="Describe your achievement and its impact" class="hrp-textarea Rectangle-29" rows="2"></textarea>
            </div>
        </div>`;
    document.getElementById('achievements').insertAdjacentHTML('beforeend', html);
    achievementCount++;
    updateProgress();
    showNotification('Achievement field added successfully!', 'success');
}

function addLanguage() {
    const html = `
        <div class="dynamic-field language-item">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <label class="hrp-label">Language:</label>
                    <input name="languages[${languageCount}][name]" placeholder="e.g., English, Spanish" class="hrp-input Rectangle-29">
                </div>
                <div>
                    <label class="hrp-label">Proficiency:</label>
                    <select name="languages[${languageCount}][proficiency]" class="hrp-input Rectangle-29">
                        <option value="">Select Proficiency</option>
                        <option value="Native">Native</option>
                        <option value="Fluent">Fluent</option>
                        <option value="Advanced">Advanced</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Basic">Basic</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="button" onclick="removeLanguage(this)" class="remove-btn">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
            </div>
        </div>`;
    document.getElementById('languages').insertAdjacentHTML('beforeend', html);
    languageCount++;
    updateProgress();
    showNotification('Language field added successfully!', 'success');
}

function addProject() {
    const html = `
        <div class="dynamic-field project-item">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="hrp-label">Project Name:</label>
                    <input name="projects[${projectCount}][name]" placeholder="Project Name" class="hrp-input Rectangle-29">
                </div>
                <div>
                    <label class="hrp-label">Technologies:</label>
                    <input name="projects[${projectCount}][technologies]" placeholder="React, Node.js, MongoDB" class="hrp-input Rectangle-29">
                </div>
                <div>
                    <label class="hrp-label">Project URL:</label>
                    <input name="projects[${projectCount}][link]" placeholder="https://project-url.com" class="hrp-input Rectangle-29" type="url">
                </div>
                <div>
                    <label class="hrp-label">Duration:</label>
                    <input name="projects[${projectCount}][duration]" placeholder="3 months" class="hrp-input Rectangle-29">
                </div>
            </div>
            <div style="margin-top: 12px;">
                <label class="hrp-label">Description:</label>
                <textarea name="projects[${projectCount}][description]" placeholder="Brief description of the project and your role" class="hrp-textarea Rectangle-29" rows="2"></textarea>
            </div>
            <div style="margin-top: 12px;">
                <button type="button" onclick="removeProject(this)" class="remove-btn">
                    <i class="fas fa-trash"></i> Remove Project
                </button>
            </div>
        </div>`;
    document.getElementById('projects').insertAdjacentHTML('beforeend', html);
    projectCount++;
    updateProgress();
    showNotification('Project field added successfully!', 'success');
}

// Drag and drop functionality
function setupDragAndDrop() {
    const fileAreas = document.querySelectorAll('.file-upload-area');
    
    fileAreas.forEach(area => {
        area.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });
        
        area.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });
        
        area.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            const input = this.querySelector('input[type="file"]');
            
            if (input && files.length > 0) {
                input.files = files;
                input.dispatchEvent(new Event('change'));
            }
        });
    });
}

// Initialize drag and drop on page load
document.addEventListener('DOMContentLoaded', setupDragAndDrop);

// Enhanced file upload handlers with validation
document.getElementById('galleryInput').addEventListener('change', function() {
    const files = this.files;
    const filename = document.getElementById('galleryFileName');
    
    if (files.length > 0) {
        let validFiles = 0;
        let totalSize = 0;
        
        for (let file of files) {
            if (file.type.startsWith('image/')) {
                if (file.size <= 5 * 1024 * 1024) { // 5MB limit
                    validFiles++;
                    totalSize += file.size;
                } else {
                    showNotification(`File "${file.name}" is too large. Maximum size is 5MB.`, 'error');
                }
            } else {
                showNotification(`File "${file.name}" is not a valid image format.`, 'error');
            }
        }
        
        if (validFiles > 0) {
            filename.textContent = `${validFiles} valid image(s) selected (${(totalSize / 1024 / 1024).toFixed(1)}MB)`;
            filename.style.color = '#10b981';
        } else {
            filename.textContent = 'No valid files selected';
            filename.style.color = '#ef4444';
        }
    } else {
        filename.textContent = 'No Files Chosen';
        filename.style.color = '#6b7280';
    }
});

document.getElementById('resumeInput').addEventListener('change', function() {
    const file = this.files[0];
    const filename = document.getElementById('resumeFileName');
    
    if (file) {
        const validTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        const maxSize = 10 * 1024 * 1024; // 10MB
        
        if (validTypes.includes(file.type)) {
            if (file.size <= maxSize) {
                filename.textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(1)}MB)`;
                filename.style.color = '#10b981';
            } else {
                filename.textContent = 'File too large (max 10MB)';
                filename.style.color = '#ef4444';
                this.value = '';
                showNotification('Resume file size must not exceed 10MB.', 'error');
            }
        } else {
            filename.textContent = 'Invalid file type';
            filename.style.color = '#ef4444';
            this.value = '';
            showNotification('Resume must be a PDF, DOC, or DOCX file.', 'error');
        }
    } else {
        filename.textContent = 'No File Chosen';
        filename.style.color = '#6b7280';
    }
});

// Remove functions for dynamic fields with animations
function removeRole(btn) {
    const item = btn.closest('.role-item');
    item.style.animation = 'fadeOutScale 0.3s ease-in';
    setTimeout(() => {
        item.remove();
        updateProgress();
        showNotification('Role removed successfully!', 'info');
    }, 300);
}

function removeEducation(btn) {
    const item = btn.closest('.education-item');
    item.style.animation = 'fadeOutScale 0.3s ease-in';
    setTimeout(() => {
        item.remove();
        updateProgress();
        showNotification('Education removed successfully!', 'info');
    }, 300);
}

function removeCertification(btn) {
    const item = btn.closest('.cert-item');
    item.style.animation = 'fadeOutScale 0.3s ease-in';
    setTimeout(() => {
        item.remove();
        updateProgress();
        showNotification('Certification removed successfully!', 'info');
    }, 300);
}

function removeAchievement(btn) {
    const item = btn.closest('.achievement-item');
    item.style.animation = 'fadeOutScale 0.3s ease-in';
    setTimeout(() => {
        item.remove();
        updateProgress();
        showNotification('Achievement removed successfully!', 'info');
    }, 300);
}

function removeProject(btn) {
    const item = btn.closest('.project-item');
    item.style.animation = 'fadeOutScale 0.3s ease-in';
    setTimeout(() => {
        item.remove();
        updateProgress();
        showNotification('Project removed successfully!', 'info');
    }, 300);
}

function removeLanguage(btn) {
    const item = btn.closest('.language-item');
    item.style.animation = 'fadeOutScale 0.3s ease-in';
    setTimeout(() => {
        item.remove();
        updateProgress();
        showNotification('Language removed successfully!', 'info');
    }, 300);
}

// Add fadeOutScale animation
const fadeOutStyle = document.createElement('style');
fadeOutStyle.textContent = `
    @keyframes fadeOutScale {
        from {
            opacity: 1;
            transform: scale(1);
        }
        to {
            opacity: 0;
            transform: scale(0.95);
        }
    }
`;
document.head.appendChild(fadeOutStyle);
</script>
@endpush

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('employees.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Employees</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Create Digital Card</span>
@endsection