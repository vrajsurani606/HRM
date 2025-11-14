@extends('layouts.macos')
@section('page_title', 'Create User')

@section('content')
  <div class="hrp-card">
    <div class="Rectangle-30 hrp-compact">
      <form action="{{ route('users.store') }}" method="POST" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
        @csrf
        <div>
          <label class="hrp-label">Name<span style="color:#ef4444"> *</span></label>
          <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter full name" class="hrp-input Rectangle-29" required>
          @error('name')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Email<span style="color:#ef4444"> *</span></label>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" class="hrp-input Rectangle-29" required>
          @error('email')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Password<span style="color:#ef4444"> *</span></label>
          <input type="password" name="password" class="hrp-input Rectangle-29" required>
          @error('password')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Role<span style="color:#ef4444"> *</span></label>
          <select name="role" class="Rectangle-29 Rectangle-29-select" required>
            <option value="">Select Role</option>
            @foreach($roles as $role)
              <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
            @endforeach
          </select>
          @error('role')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Mobile Number</label>
          <input type="text" name="mobile_no" value="{{ old('mobile_no') }}" placeholder="10 digit mobile" class="hrp-input Rectangle-29" inputmode="numeric" pattern="\d{10}" maxlength="10">
          @error('mobile_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div class="md:col-span-2">
          <label class="hrp-label">Address</label>
          <textarea name="address" rows="3" placeholder="Enter address" class="hrp-textarea Rectangle-29 Rectangle-29-textarea">{{ old('address') }}</textarea>
          @error('address')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div class="md:col-span-2">
          <div class="hrp-actions">
            <button class="hrp-btn hrp-btn-primary" type="submit">Create User</button>
            <a class="hrp-btn" href="{{ route('users.index') }}" style="margin-left:8px">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection