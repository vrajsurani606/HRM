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
          <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:16px;margin-top:8px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
              <label class="hrp-label" style="margin:0">
                Additional User Permissions 
                <small style="color:#6b7280;font-weight:normal">(These are added to role permissions)</small>
              </label>
              <button type="button" onclick="togglePermissions()" class="hrp-btn" style="padding:4px 12px;font-size:13px">
                <span id="toggleText">Show Permissions</span>
              </button>
            </div>
            
            <div id="permissionsContainer" style="display:none">
              <div style="background:white;border:1px solid #e5e7eb;border-radius:6px;padding:12px;max-height:400px;overflow-y:auto">
                @foreach($allPermissions as $module => $permissions)
                  <div style="margin-bottom:16px">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;padding-bottom:6px;border-bottom:2px solid #e5e7eb">
                      <input 
                        type="checkbox" 
                        id="module-{{ Str::slug($module) }}" 
                        onchange="toggleModule(this, '{{ Str::slug($module) }}')"
                        style="width:16px;height:16px;cursor:pointer"
                      >
                      <label for="module-{{ Str::slug($module) }}" style="font-weight:600;color:#1f2937;cursor:pointer;margin:0">
                        {{ $module }}
                      </label>
                      <span style="color:#6b7280;font-size:12px">({{ $permissions->count() }} permissions)</span>
                    </div>
                    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:8px;padding-left:24px">
                      @foreach($permissions as $permission)
                        @php
                          $isFromRole = in_array($permission->name, $rolePermissions);
                          $isDirectPermission = in_array($permission->name, old('permissions', $userDirectPermissions));
                        @endphp
                        <label style="display:flex;align-items:center;gap:6px;padding:4px;cursor:{{ $isFromRole && !$isDirectPermission ? 'default' : 'pointer' }};border-radius:4px;transition:background 0.2s;{{ $isFromRole && !$isDirectPermission ? 'background:#f9fafb;' : '' }}" 
                               onmouseover="if(!this.querySelector('input').disabled) this.style.background='#f3f4f6'" 
                               onmouseout="if(!this.querySelector('input').disabled) this.style.background='{{ $isFromRole && !$isDirectPermission ? '#f9fafb' : 'transparent' }}'">
                          <input 
                            type="checkbox" 
                            name="permissions[]" 
                            value="{{ $permission->name }}"
                            class="permission-checkbox module-{{ Str::slug($module) }} {{ $isFromRole && !$isDirectPermission ? 'from-role' : '' }}"
                            {{ $isFromRole ? 'checked' : '' }}
                            {{ $isDirectPermission ? 'checked' : '' }}
                            {{ $isFromRole && !$isDirectPermission ? 'disabled' : '' }}
                            onchange="updateModuleCheckbox('{{ Str::slug($module) }}')"
                            style="width:14px;height:14px;cursor:{{ $isFromRole && !$isDirectPermission ? 'not-allowed' : 'pointer' }}"
                            title="{{ $isFromRole && !$isDirectPermission ? 'This permission comes from the user\'s role' : '' }}"
                          >
                          <span style="font-size:13px;color:{{ $isFromRole && !$isDirectPermission ? '#6b7280' : '#374151' }}">
                            {{ explode('.', $permission->name)[1] ?? $permission->name }}
                            @if($isFromRole && !$isDirectPermission)
                              <span style="font-size:11px;color:#9ca3af;font-style:italic">(from role)</span>
                            @endif
                          </span>
                        </label>
                      @endforeach
                    </div>
                  </div>
                @endforeach
              </div>
              <div style="margin-top:8px;padding:8px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:4px">
                <p style="margin:0;font-size:13px;color:#1e40af;line-height:1.5">
                  <strong>Legend:</strong><br>
                  • <strong>Checked & Enabled</strong> = Additional user permission (can be removed)<br>
                  • <strong>Checked & Disabled</strong> = Permission from role (cannot be removed here)<br>
                  • <strong>Unchecked</strong> = Not assigned (can be added)
                </p>
              </div>
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

@push('scripts')
<script>
function togglePermissions() {
  const container = document.getElementById('permissionsContainer');
  const toggleText = document.getElementById('toggleText');
  
  if (container.style.display === 'none') {
    container.style.display = 'block';
    toggleText.textContent = 'Hide Permissions';
  } else {
    container.style.display = 'none';
    toggleText.textContent = 'Show Permissions';
  }
}

function toggleModule(checkbox, moduleSlug) {
  const moduleCheckboxes = document.querySelectorAll(`.module-${moduleSlug}`);
  moduleCheckboxes.forEach(cb => {
    // Only toggle checkboxes that are not disabled (not from role)
    if (!cb.disabled) {
      cb.checked = checkbox.checked;
    }
  });
}

function updateModuleCheckbox(moduleSlug) {
  const moduleCheckboxes = document.querySelectorAll(`.module-${moduleSlug}`);
  const moduleHeaderCheckbox = document.getElementById(`module-${moduleSlug}`);
  
  // Only consider non-disabled checkboxes for module header state
  const enabledCheckboxes = Array.from(moduleCheckboxes).filter(cb => !cb.disabled);
  
  if (enabledCheckboxes.length === 0) {
    // All permissions are from role, disable module checkbox
    moduleHeaderCheckbox.disabled = true;
    moduleHeaderCheckbox.checked = true;
    return;
  }
  
  const allChecked = enabledCheckboxes.every(cb => cb.checked);
  const someChecked = enabledCheckboxes.some(cb => cb.checked);
  
  if (allChecked) {
    moduleHeaderCheckbox.checked = true;
    moduleHeaderCheckbox.indeterminate = false;
  } else if (someChecked) {
    moduleHeaderCheckbox.checked = false;
    moduleHeaderCheckbox.indeterminate = true;
  } else {
    moduleHeaderCheckbox.checked = false;
    moduleHeaderCheckbox.indeterminate = false;
  }
}

// Initialize module checkboxes on page load
document.addEventListener('DOMContentLoaded', function() {
  @foreach($allPermissions as $module => $permissions)
    updateModuleCheckbox('{{ Str::slug($module) }}');
  @endforeach
});
</script>
@endpush