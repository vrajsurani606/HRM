@extends('layouts.macos')
@section('page_title', 'Edit User')

@section('content')
  <div class="hrp-card">
    <div class="Rectangle-30 hrp-compact">
      <form action="{{ route('users.update', $user) }}" method="POST" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
        @csrf
        @method('PUT')
        <div>
          <label class="hrp-label">Name<span style="color:#ef4444"> *</span></label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Enter full name" class="hrp-input Rectangle-29" required>
          @error('name')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Email<span style="color:#ef4444"> *</span></label>
          <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="name@example.com" class="hrp-input Rectangle-29" required>
          @error('email')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Password <small style="color:#6b7280">(leave blank to keep current)</small></label>
          <div class="password-wrapper">
            <input type="password" name="password" class="hrp-input Rectangle-29">
          </div>
          @error('password')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Role<span style="color:#ef4444"> *</span></label>
          <select name="role" class="Rectangle-29 Rectangle-29-select" required>
            <option value="">Select Role</option>
            @foreach($roles as $role)
              <option value="{{ $role->name }}" {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
            @endforeach
          </select>
          @error('role')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <x-phone-input 
            name="mobile_no" 
            label="Mobile Number" 
            :value="old('mobile_no', $user->mobile_no)" 
          />
        </div>
        <div class="md:col-span-2">
          <label class="hrp-label">Address</label>
          <textarea name="address" rows="3" placeholder="Enter address" class="hrp-textarea Rectangle-29 Rectangle-29-textarea">{{ old('address', $user->address) }}</textarea>
          @error('address')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <!-- User-Specific Permissions Section -->
        <div class="md:col-span-2">
          <div class="permissions-panel">
            <div class="permissions-header" style="display:flex;align-items:center;justify-content:space-between">
              <div class="hrp-label" style="margin:0">Additional User Permissions</div>
              <div style="display:flex;align-items:center;gap:16px">
                <label class="custom-checkbox" style="margin:0">
                  <input type="checkbox" id="select_all_user_permissions">
                  <div class="checkbox-box"><span class="checkmark">✓</span></div>
                  Select All Permissions
                </label>
              </div>
            </div>
            <div class="perm-subtitle">
              Select additional permissions for this user. These are added to the permissions from their role.
              <div class="perm-note">Note: Permissions from role are shown as disabled and cannot be removed here.</div>
            </div>
            <div class="perm-accordion">
              @foreach($allPermissions as $module => $permissions)
                <div class="perm-item" data-module="{{ Str::slug($module) }}">
                  <div class="perm-head">
                    <div class="perm-toggle" aria-expanded="true" style="pointer-events:none">
                      <span class="title">{{ $module }}</span>
                    </div>
                    <div class="perm-head-right">
                      <span class="perm-count" data-module="{{ Str::slug($module) }}">0/0 selected</span>
                      <label class="custom-checkbox perm-select-all" style="margin:0">
                        <input type="checkbox" class="module-checkbox" data-module="{{ Str::slug($module) }}">
                        <div class="checkbox-box"><span class="checkmark">✓</span></div>
                        Select all
                      </label>
                    </div>
                  </div>
                  <div class="perm-body">
                    <div class="perm-grid">
                      @foreach($permissions as $permission)
                        @php
                          $isFromRole = in_array($permission->name, $rolePermissions);
                          $isDirectPermission = in_array($permission->name, old('permissions', $userDirectPermissions));
                        @endphp
                        <label class="custom-checkbox {{ $isFromRole && !$isDirectPermission ? 'from-role-perm' : '' }}">
                          <input 
                            type="checkbox" 
                            class="permission-checkbox" 
                            name="permissions[]" 
                            value="{{ $permission->name }}" 
                            data-module="{{ Str::slug($module) }}" 
                            {{ $isFromRole ? 'checked' : '' }}
                            {{ $isDirectPermission ? 'checked' : '' }}
                            {{ $isFromRole && !$isDirectPermission ? 'disabled' : '' }}
                            title="{{ $isFromRole && !$isDirectPermission ? 'This permission comes from the user\'s role' : '' }}"
                          >
                          <div class="checkbox-box"><span class="checkmark">✓</span></div>
                          {{ ucwords(str_replace('_',' ', explode('.', $permission->name)[1] ?? $permission->name)) }}
                          @if($isFromRole && !$isDirectPermission)
                            <span style="font-size:11px;color:#9ca3af;font-style:italic;margin-left:4px">(from role)</span>
                          @endif
                        </label>
                      @endforeach
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>

        <div class="md:col-span-2">
          <div class="hrp-actions">
            <button class="hrp-btn hrp-btn-primary" type="submit">Update User</button>
            <a class="hrp-btn" href="{{ route('users.index') }}" style="margin-left:8px">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('styles')
<style>
.permissions-panel { border: 1px solid #e0e0e0; border-radius: 12px; background: white; margin-top: 8px; }
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
.custom-checkbox input:checked + .checkbox-box { background:#000000; border-color:#000000; }
.custom-checkbox input:checked + .checkbox-box .checkmark { display:block; }
.custom-checkbox input:disabled + .checkbox-box { background:#e5e7eb; border-color:#d1d5db; cursor:not-allowed; }
.custom-checkbox input:disabled:checked + .checkbox-box { background:#9ca3af; border-color:#9ca3af; }
.custom-checkbox.from-role-perm { color:#6b7280; cursor:default; }
.form-check-input { accent-color: #000000; }

.perm-subtitle { padding:10px 12px; color:#6b7280; font-weight:600; border-bottom:1px solid #e5e7eb; }
.perm-subtitle .perm-note { color:#f59e0b; margin-top:4px; font-weight:700; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Global select all permissions
    const globalSelectAll = document.getElementById('select_all_user_permissions');
    if (globalSelectAll) {
        globalSelectAll.addEventListener('change', function(){
            const allModuleCheckboxes = document.querySelectorAll('.module-checkbox');
            const allPermissionCheckboxes = document.querySelectorAll('.permission-checkbox:not([disabled])');
            allModuleCheckboxes.forEach(cb => { 
                if (!cb.disabled) {
                    cb.checked = this.checked; 
                    cb.indeterminate = false; 
                }
            });
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
        const enabledPermissions = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]:not([disabled])`);
        const checkedEnabledPermissions = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]:not([disabled]):checked`);
        
        if (enabledPermissions.length === 0) {
            // All permissions are from role
            moduleCheckbox.disabled = true;
            moduleCheckbox.checked = true;
        } else if (checkedEnabledPermissions.length === enabledPermissions.length) {
            moduleCheckbox.checked = true;
        } else if (checkedEnabledPermissions.length > 0) {
            moduleCheckbox.indeterminate = true;
        }
        updateModuleCount(module);
    });
    
    moduleCheckboxes.forEach(moduleCheckbox => {
        moduleCheckbox.addEventListener('change', function() {
            const module = this.dataset.module;
            const modulePermissions = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]:not([disabled])`);
            
            modulePermissions.forEach(checkbox => { checkbox.checked = this.checked; });
            this.indeterminate = false;
            updateModuleCount(module);
        });
    });
    
    permissionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.disabled) return;
            
            const module = this.dataset.module;
            const modulePermissions = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]:not([disabled])`);
            const checkedPermissions = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]:not([disabled]):checked`);
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
        const total = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]:not([disabled])`).length;
        const checked = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]:not([disabled]):checked`).length;
        const totalAll = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`).length;
        const label = document.querySelector(`.perm-count[data-module="${module}"]`);
        if (label) label.textContent = `${checked}/${total} selected (${totalAll} total)`;
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
@endpush