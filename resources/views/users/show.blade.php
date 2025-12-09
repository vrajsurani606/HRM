@extends('layouts.macos')

@section('content')
  <div class="hrp-card">
    <div class="Rectangle-30 hrp-compact">
      <div class="hrp-actions" style="justify-content: space-between; padding: 0 4px 10px;">
        <div class="hrp-label" style="margin:0">User Details</div>
        <div>
          {{-- <a class="hrp-btn" href="{{ route('users.index') }}">Back</a> --}}

             <a href="{{ route('users.index') }}" class="pill-btn back-btn" title="Back to Users">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Back
      </a>
          {{-- @can('users.create')
            <a class="hrp-btn hrp-btn-primary" href="{{ route('users.create') }}" style="margin-left:6px">Create User</a>
          @endcan --}}
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-5">
        <div style="display:flex; align-items:center; gap:16px">
          <div class="profile-image" style="width:80px;height:80px;border-radius:50%;overflow:hidden;background:#f3f4f6;border:2px solid #e5e7eb; flex:0 0 80px; display:flex;align-items:center;justify-content:center; font-weight:800; color:#0f172a">
            {{ strtoupper(substr($user->name, 0, 2)) }}
          </div>
          <div style="min-width:0">
            <div style="font-weight:800;font-size:18px;color:#1e293b;line-height:1.3">{{ $user->name }}</div>
            <div style="color:#64748b;font-weight:600;font-size:13px;word-break:break-all">{{ $user->email }}</div>
            <div style="margin-top:8px; display:flex; gap:6px; flex-wrap:wrap">
              @foreach($user->roles as $role)
                <span style="background:#f1f5f9;border:1px solid #e2e8f0;border-radius:8px;padding:6px 10px;font-size:12px;font-weight:700;color:#1e293b">{{ ucfirst($role->name) }}</span>
              @endforeach
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          <div>
            <label class="hrp-label">Mobile</label>
            <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px">{{ display_mobile($user->mobile_no) ?? 'N/A' }}</div>
          </div>
          <div>
            <label class="hrp-label">Joined</label>
            <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px">{{ $user->created_at->format('d M Y, h:i A') }}</div>
          </div>
          <div class="md:col-span-2">
            <label class="hrp-label">Address</label>
            <div class="hrp-textarea Rectangle-29 Rectangle-29-textarea" style="display:flex;align-items:center;min-height:58px">{{ $user->address ?? 'N/A' }}</div>
          </div>
        </div>
      </div>

      <div style="margin-top:16px">
        <div class="hrp-label" style="margin:0 0 8px 4px">Permissions</div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          @forelse($user->getAllPermissions()->groupBy(function($permission) { return explode('.', $permission->name)[0]; }) as $module => $permissions)
            <div class="hrp-card" style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px">
              <div style="font-weight:800;font-size:14px;margin-bottom:8px">{{ ucfirst($module) }}</div>
              <div style="display:flex; gap:8px; flex-wrap:wrap">
                @foreach($permissions as $permission)
                  <span style="background:#ecfdf5;color:#065f46;border:1px solid #d1fae5;border-radius:8px;padding:6px 10px;font-size:12px;font-weight:700">{{ explode('.', $permission->name)[1] }}</span>
                @endforeach
              </div>
            </div>
          @empty
            <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px">No permissions assigned</div>
          @endforelse
        </div>
      </div>

      {{-- <div class="hrp-actions" style="padding-top:12px">
        @can('users.edit')
          <a class="hrp-btn" href="{{ route('users.edit', $user) }}">Edit User</a>
        @endcan
        @can('users.delete')
          <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline-block; margin-left:8px" onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="hrp-btn" style="background:#fff;color:#ef4444;border:1px solid #f2d7d7">Delete User</button>
          </form>
        @endcan
      </div> --}}
    </div>
  </div>
@endsection