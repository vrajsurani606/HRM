@extends('layouts.macos')

@section('content')
  <div class="hrp-card">
    <div class="Rectangle-30 hrp-compact">
      <div class="hrp-actions" style="justify-content: space-between; padding: 0 4px 10px;">
        <div class="hrp-label" style="margin:0">Edit Role: {{ $role->name }}</div>
<a href="{{ route('roles.index') }}" class="pill-btn back-btn" title="Back to Roles">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Back
      </a>      </div>
      <form action="{{ route('roles.update', $role) }}" method="POST" class="grid grid-cols-1 gap-3">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          <div>
            <label class="hrp-label">Name<span style="color:#ef4444"> *</span></label>
            <input type="text" name="name" value="{{ old('name', $role->name) }}" placeholder="Enter Role Name" class="hrp-input Rectangle-29" required>
            @error('name')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          <div>
            <label class="hrp-label">Description</label>
            <textarea name="description" rows="1" placeholder="Role description" class="hrp-textarea Rectangle-29 Rectangle-29-textarea">{{ old('description', $role->description) }}</textarea>
            @error('description')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
        </div>
        <div class="permissions-panel">
          <div class="permissions-header" style="display:flex;align-items:center;justify-content:space-between">
            <div class="hrp-label" style="margin:0">Manage Permissions</div>
            <div style="display:flex;align-items:center;gap:16px">
              <label class="custom-checkbox" style="margin:0">
                <input type="checkbox" id="select_all_modules">
                <div class="checkbox-box"><span class="checkmark">✓</span></div>
                Select All Permissions
              </label>
            </div>
          </div>
          <div class="perm-subtitle">
            Select permissions for this role. You can select all permissions at once or manage them by module.
            <div class="perm-note">Note: Only permissions for modules available to your role are shown.</div>
          </div>
          <div class="perm-accordion">
            @foreach($permissions as $module => $modulePermissions)
              <div class="perm-item" data-module="{{ $module }}">
                <div class="perm-head">
                  <div class="perm-toggle" aria-expanded="true" style="pointer-events:none">
                    <span class="title">{{ ucfirst($module) }}</span>
                  </div>
                  <div class="perm-head-right">
                    <span class="perm-count" data-module="{{ $module }}">0/0 selected</span>
                    <label class="custom-checkbox perm-select-all" style="margin:0">
                      <input type="checkbox" class="module-checkbox" data-module="{{ $module }}">
                      <div class="checkbox-box"><span class="checkmark">✓</span></div>
                      Select all
                    </label>
                  </div>
                </div>
                <div class="perm-body">
                  <div class="perm-grid">
                    @foreach($modulePermissions as $permission)
                      <label class="custom-checkbox">
                        <input type="checkbox" class="permission-checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission_{{ $permission->id }}" data-module="{{ $module }}" {{ in_array($permission->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                        <div class="checkbox-box"><span class="checkmark">✓</span></div>
                        {{ ucwords(str_replace('_',' ', explode('.', $permission->name)[1])) }}
                      </label>
                    @endforeach
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
        <div class="hrp-actions sticky-actions">
          <button class="hrp-btn hrp-btn-primary" type="submit">Update</button>
          <a class="hrp-btn" href="{{ route('roles.index') }}" style="margin-left:8px">Cancel</a>
        </div>
      </form>
    </div>
  </div>

<style>
.permissions-panel { border: 1px solid #e0e0e0; border-radius: 12px; background: white; }

.permissions-header { padding: 12px 15px; border-bottom: 1px solid #e0e0e0; background-color: #fafafa; }

.is-hidden { display: none; }

/* Accordion permissions */
.perm-accordion { display: grid; gap: 10px; }
.perm-item { border:1px solid #e5e7eb; border-radius:10px; background:#fff; overflow:hidden; }
.perm-head { display:flex; align-items:center; justify-content:space-between; padding:10px 12px; background:#fafafa; border-bottom:1px solid #e5e7eb; }
.perm-head-right { display:flex; align-items:center; gap:14px; }
.perm-count { font-weight:700; color:#6b7280; font-size:12px; }
.perm-toggle { display:flex; align-items:center; gap:8px; background:transparent; border:0; padding:0; font-weight:800; color:#111827; cursor:default; }
.perm-toggle .chev { display:none; }
.perm-toggle[aria-expanded="false"] .chev { display:none; }
.perm-toggle .title { font-weight:800; font-size:14px; color:#111827; letter-spacing:0.1px; }
.perm-select-all { display:flex; align-items:center; gap:8px; margin:0; font-weight:600; color:#374151; }
.perm-body { padding:12px; background:#fff; }
.perm-grid { display:grid; grid-template-columns: repeat(4, minmax(0, 1fr)); column-gap:18px; row-gap:8px; }
@media (max-width: 992px) { .perm-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
@media (max-width: 640px) { .perm-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
.custom-checkbox { display:flex; align-items:center; cursor:pointer; position:relative; font-weight:600; color:#374151; }
.custom-checkbox input { display:none; }
.custom-checkbox .checkbox-box { width:16px; height:16px; border:2px solid #9ca3af; background:#fff; margin-right:8px; display:flex; align-items:center; justify-content:center; border-radius:4px; }
.custom-checkbox .checkmark { color:#fff; font-size:12px; font-weight:700; display:none; line-height:1; }
.custom-checkbox input:checked + .checkbox-box { background:#10b981; border-color:#10b981; }
.custom-checkbox input:checked + .checkbox-box .checkmark { display:block; }
.form-check-input { accent-color: #000000; }
.custom-checkbox input:checked + .checkbox-box { background:#000000; border-color:#000000; }

.perm-subtitle { padding:10px 12px; color:#6b7280; font-weight:600; border-bottom:1px solid #e5e7eb; }
.perm-subtitle .perm-note { color:#f59e0b; margin-top:4px; font-weight:700; }
.sticky-actions { position: sticky; bottom: 0; background: #fff; padding-top: 12px; border-top: 1px solid #e5e7eb; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Global select all modules
    const globalSelectAll = document.getElementById('select_all_modules');
    if (globalSelectAll) {
        globalSelectAll.addEventListener('change', function(){
            const allModuleCheckboxes = document.querySelectorAll('.module-checkbox');
            const allPermissionCheckboxes = document.querySelectorAll('.permission-checkbox');
            allModuleCheckboxes.forEach(cb => { cb.checked = this.checked; cb.indeterminate = false; });
            allPermissionCheckboxes.forEach(cb => { cb.checked = this.checked; });
            updateAllCounts();
        });
    }

    // Permission checkbox functionality
    const moduleCheckboxes = document.querySelectorAll('.module-checkbox');
    const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
    
    // Initialize module checkboxes based on existing permissions
    moduleCheckboxes.forEach(moduleCheckbox => {
        const module = moduleCheckbox.dataset.module;
        const modulePermissions = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`);
        const checkedPermissions = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]:checked`);
        
        if (checkedPermissions.length === modulePermissions.length) {
            moduleCheckbox.checked = true;
        } else if (checkedPermissions.length > 0) {
            moduleCheckbox.indeterminate = true;
        }
        updateModuleCount(module);
    });
    
    moduleCheckboxes.forEach(moduleCheckbox => {
        moduleCheckbox.addEventListener('change', function() {
            const module = this.dataset.module;
            const modulePermissions = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`);
            
            modulePermissions.forEach(checkbox => { checkbox.checked = this.checked; });
            this.indeterminate = false;
            updateModuleCount(module);
        });
    });
    
    permissionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const module = this.dataset.module;
            const modulePermissions = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`);
            const checkedPermissions = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]:checked`);
            const moduleCheckbox = document.querySelector(`.module-checkbox[data-module="${module}"]`);
            
            if (checkedPermissions.length === modulePermissions.length) {
                moduleCheckbox.checked = true;
                moduleCheckbox.indeterminate = false;
            } else if (checkedPermissions.length > 0) {
                moduleCheckbox.checked = false;
                moduleCheckbox.indeterminate = true;
            } else {
                moduleCheckbox.checked = false;
                moduleCheckbox.indeterminate = false;
            }
            updateModuleCount(module);
        });
    });

    // Initialize counts and helpers
    function updateModuleCount(module){
        const total = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`).length;
        const checked = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]:checked`).length;
        const label = document.querySelector(`.perm-count[data-module="${module}"]`);
        if (label) label.textContent = `${checked}/${total} selected`;
    }
    function updateAllCounts(){
        document.querySelectorAll('.perm-item').forEach(item => {
            const module = item.getAttribute('data-module');
            updateModuleCount(module);
        });
    }
    updateAllCounts();
});
</script>
@endsection