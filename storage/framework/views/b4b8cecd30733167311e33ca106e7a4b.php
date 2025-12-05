<?php $__env->startSection('page_title', isset($isEdit) && $isEdit ? 'Edit Digital Card - ' . $employee->name : 'Create Digital Card - ' . $employee->name); ?>

<?php $__env->startPush('styles'); ?>
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
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<div class="hrp-card digital-card-form">
    <div class="Rectangle-30 hrp-compact">
      
      <!-- Success/Error Messages -->
        <?php if(session('success')): ?>
            <div class="alert alert-success" style="background:#d4edda;color:#155724;padding:12px;border-radius:6px;margin-bottom:20px;border:1px solid #c3e6cb;animation:slideInDown 0.5s ease-out;">
                <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        
        <?php if(session('error')): ?>
            <div class="alert alert-danger" style="background:#f8d7da;color:#721c24;padding:12px;border-radius:6px;margin-bottom:20px;border:1px solid #f5c6cb;animation:slideInDown 0.5s ease-out;">
                <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        
        <?php if($errors->any()): ?>
            <div class="alert alert-danger" style="background:#f8d7da;color:#721c24;padding:12px;border-radius:6px;margin-bottom:20px;border:1px solid #f5c6cb;animation:slideInDown 0.5s ease-out;">
                <i class="fas fa-exclamation-triangle"></i> Please fix the following errors:
                <ul style="margin:8px 0 0 20px;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <div class="progress-bar">
            <div class="progress-fill" id="progressFill"></div>
        </div>
      <form method="POST" action="<?php echo e(isset($isEdit) && $isEdit ? route('employees.digital-card.update', $employee) : route('employees.digital-card.store', $employee)); ?>" enctype="multipart/form-data" class="hrp-form" id="digitalCardForm">
        <?php echo csrf_field(); ?>
        <?php if(isset($isEdit) && $isEdit): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>
          
        <!-- Basic Information -->
        <div class="form-section">
            <div class="section-header">
                <i class="fas fa-user section-icon"></i>
                <h3 class="section-title">Basic Information</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
                <div>
                    <label class="hrp-label">Full Name:</label>
                    <input name="full_name" value="<?php echo e(old('full_name', $digitalCard->full_name ?? $employee->name)); ?>" placeholder="Enter Full Name" class="hrp-input Rectangle-29" required>
                    <?php $__errorArgs = ['full_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div>
                    <label class="hrp-label">Current Position:</label>
                    <input name="current_position" value="<?php echo e(old('current_position', $digitalCard->current_position ?? $employee->position)); ?>" placeholder="Enter Current Position" class="hrp-input Rectangle-29">
                    <?php $__errorArgs = ['current_position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div>
                    <label class="hrp-label">Company Name:</label>
                    <input name="company_name" value="<?php echo e(old('company_name', $digitalCard->company_name ?? '')); ?>" placeholder="Enter Company Name" class="hrp-input Rectangle-29">
                    <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div>
                    <label class="hrp-label">Years of Experience:</label>
                    <input name="years_experience" value="<?php echo e(old('years_experience', $digitalCard->years_of_experience ?? '')); ?>" placeholder="e.g. 3.5" class="hrp-input Rectangle-29" type="number" step="0.1" min="0">
                    <?php $__errorArgs = ['years_experience'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                    <label class="hrp-label">Email:</label>
                    <input name="email" value="<?php echo e(old('email', $digitalCard->email ?? $employee->email)); ?>" placeholder="Enter Email" class="hrp-input Rectangle-29" type="email">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div>
                    <label class="hrp-label">Phone:</label>
                    <input name="phone" value="<?php echo e(old('phone', $digitalCard->phone ?? '')); ?>" placeholder="Enter Phone Number" class="hrp-input Rectangle-29">
                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div>
                    <label class="hrp-label">LinkedIn Profile:</label>
                    <input name="linkedin" value="<?php echo e(old('linkedin', $digitalCard->linkedin ?? '')); ?>" placeholder="LinkedIn Profile URL" class="hrp-input Rectangle-29">
                    <?php $__errorArgs = ['linkedin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div>
                    <label class="hrp-label">Portfolio Website:</label>
                    <input name="portfolio" value="<?php echo e(old('portfolio', $digitalCard->portfolio ?? '')); ?>" placeholder="Portfolio Website URL" class="hrp-input Rectangle-29">
                    <?php $__errorArgs = ['portfolio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div>
                    <label class="hrp-label">Facebook:</label>
                    <input name="facebook" value="<?php echo e(old('facebook', $digitalCard->facebook ?? '')); ?>" placeholder="Facebook Profile URL" class="hrp-input Rectangle-29">
                    <?php $__errorArgs = ['facebook'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div>
                    <label class="hrp-label">Twitter:</label>
                    <input name="twitter" value="<?php echo e(old('twitter', $digitalCard->twitter ?? '')); ?>" placeholder="Twitter Profile URL" class="hrp-input Rectangle-29">
                    <?php $__errorArgs = ['twitter'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div>
                    <label class="hrp-label">Instagram:</label>
                    <input name="instagram" value="<?php echo e(old('instagram', $digitalCard->instagram ?? '')); ?>" placeholder="Instagram Profile URL" class="hrp-input Rectangle-29">
                    <?php $__errorArgs = ['instagram'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div>
                    <label class="hrp-label">GitHub:</label>
                    <input name="github" value="<?php echo e(old('github', $digitalCard->github ?? '')); ?>" placeholder="GitHub Profile URL" class="hrp-input Rectangle-29">
                    <?php $__errorArgs = ['github'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                <label class="hrp-label">Location:</label>
                <input name="location" value="<?php echo e(old('location', $digitalCard->location ?? '')); ?>" placeholder="Enter Location" class="hrp-input Rectangle-29">
                <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                    <label class="hrp-label">Skills (comma separated):</label>
                    <textarea name="skills" placeholder="PHP, Laravel, JavaScript, etc." class="hrp-textarea Rectangle-29 Rectangle-29-textarea"><?php echo e(old('skills', $digitalCard->skills ?? '')); ?></textarea>
                    <?php $__errorArgs = ['skills'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div>
                    <label class="hrp-label">Hobbies & Interests (comma separated):</label>
                    <textarea name="hobbies" placeholder="Reading, Traveling, Photography, etc." class="hrp-textarea Rectangle-29 Rectangle-29-textarea"><?php echo e(old('hobbies', $digitalCard->hobbies ?? '')); ?></textarea>
                    <?php $__errorArgs = ['hobbies'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            
            <div style="margin-top: 16px;">
                <label class="hrp-label">Professional Summary:</label>
                <textarea name="summary" placeholder="Brief professional summary" class="hrp-textarea Rectangle-29 Rectangle-29-textarea"><?php echo e(old('summary', $digitalCard->summary ?? '')); ?></textarea>
                <?php $__errorArgs = ['summary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        
        <!-- Previous Roles -->
        <div class="form-section" style="margin-top: 20px;">
            <div class="section-header">
                <i class="fas fa-briefcase section-icon"></i>
                <h3 class="section-title">Previous Roles</h3>
            </div>
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
          <?php $__errorArgs = ['gallery'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
          <?php $__errorArgs = ['resume'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-primary" id="submitBtn">
                <i class="fas fa-save"></i>
                <?php echo e(isset($isEdit) && $isEdit ? 'Update Digital Card' : 'Create Digital Card'); ?>

            </button>
            <a href="<?php echo e(route('employees.digital-card.show', $employee)); ?>" class="btn-secondary">
                <i class="fas fa-times"></i>
                Cancel
            </a>
        </div>
      </form>
      </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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

// Form submission handling with enhanced animations
document.getElementById('digitalCardForm').addEventListener('submit', function(e) {
    // Basic validation
    const fullName = this.querySelector('input[name="full_name"]').value.trim();
    if (!fullName) {
        showNotification('Please enter the full name.', 'error');
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
        submitBtn.innerHTML = '<i class="fas fa-save"></i> <?php echo e(isset($isEdit) && $isEdit ? "Update Digital Card" : "Create Digital Card"); ?>';
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
                    <input name="education[${educationCount}][degree]" placeholder="Degree" class="hrp-input Rectangle-29">
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
                    <label class="hrp-label">Year:</label>
                    <input name="certifications[${certCount}][year]" placeholder="2023" class="hrp-input Rectangle-29">
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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
  <a class="hrp-bc-home" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="<?php echo e(route('employees.index')); ?>" style="font-weight:800;color:#0f0f0f;text-decoration:none">Employees</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Create Digital Card</span>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/hr/employees/digital-card/create.blade.php ENDPATH**/ ?>