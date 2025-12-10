@extends('layouts.macos')

@section('content')
  <div class="hrp-card">
    <div class="Rectangle-30 hrp-compact">
      <div class="hrp-actions" style="justify-content: space-between; padding: 0 4px 10px;">
        <div class="hrp-label" style="margin:0">Role Details: {{ ucfirst($role->name) }}</div>
        <div>
<a href="{{ route('roles.index') }}" class="pill-btn back-btn" title="Back to Roles">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Back
      </a>          @can('Roles Management.create role')
            <a class="hrp-btn hrp-btn-primary" href="{{ route('roles.create') }}" style="margin-left:6px">Create Role</a>
          @endcan
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-5">
        <div class="grid grid-cols-1 gap-3">
          <div>
            <label class="hrp-label">Role Name</label>
            <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px">
              <span class="badge badge-primary">{{ ucfirst($role->name) }}</span>
            </div>
          </div>
          <div>
            <label class="hrp-label">Description</label>
            <div class="hrp-textarea Rectangle-29 Rectangle-29-textarea" style="display:flex;align-items:center;min-height:58px">{{ $role->description ?? 'No description' }}</div>
          </div>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div>
              <label class="hrp-label">Users</label>
              <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px">{{ $role->users->count() }}</div>
            </div>
            <div>
              <label class="hrp-label">Permissions</label>
              <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px">{{ $role->permissions->count() }}</div>
            </div>
            <div>
              <label class="hrp-label">Dashboard Type</label>
              <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px">
                @php
                  $dashboardColors = [
                    'admin' => ['bg' => '#dbeafe', 'color' => '#1e40af'],
                    'employee' => ['bg' => '#fef3c7', 'color' => '#92400e'],
                    'customer' => ['bg' => '#e0e7ff', 'color' => '#3730a3'],
                    'hr' => ['bg' => '#fce7f3', 'color' => '#9d174d'],
                    'receptionist' => ['bg' => '#d1fae5', 'color' => '#065f46'],
                  ];
                  $dt = $role->dashboard_type ?? 'admin';
                  $dtColor = $dashboardColors[$dt] ?? $dashboardColors['admin'];
                @endphp
                <span style="background:{{ $dtColor['bg'] }}; color:{{ $dtColor['color'] }}; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:700;">{{ ucfirst($dt) }}</span>
              </div>
            </div>
            <div>
              <label class="hrp-label">Data Access</label>
              <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px">
                @if($role->restrict_to_own_data)
                  <span style="background:#fef3c7; color:#92400e; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:700;">Own Data Only</span>
                @else
                  <span style="background:#d1fae5; color:#065f46; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:700;">All Data</span>
                @endif
              </div>
            </div>
          </div>
        </div>

        <div>
          <label class="hrp-label">Users with this role</label>
          <div class="hrp-card" style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px; max-height:260px; overflow:auto">
            @forelse($role->users as $user)
              <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px">
                <div style="width:30px;height:30px;border-radius:50%;background:#e5e7eb;display:flex;align-items:center;justify-content:center;font-weight:800;color:#0f172a;font-size:12px">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                <div style="min-width:0">
                  <div style="font-weight:800;font-size:13px;color:#1e293b;line-height:1.2">{{ $user->name }}</div>
                  <div style="color:#64748b;font-weight:600;font-size:12px;word-break:break-all">{{ $user->email }}</div>
                </div>
              </div>
            @empty
              <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px">No users assigned to this role</div>
            @endforelse
          </div>
        </div>
      </div>

      <div style="margin-top:16px">
        <div class="hrp-label" style="margin:0 0 8px 4px">Permissions</div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          @forelse($role->permissions->groupBy(function($permission) { return explode('.', $permission->name)[0]; }) as $module => $permissions)
            <div class="hrp-card" style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px">
              <div style="font-weight:800;font-size:14px;margin-bottom:8px">{{ ucfirst($module) }} ({{ $permissions->count() }})</div>
              <div style="display:flex; gap:8px; flex-wrap:wrap">
                @foreach($permissions as $permission)
                  <span style="background:#f3f4f6;color:#111827;border:1px solid #e5e7eb;border-radius:8px;padding:6px 10px;font-size:12px;font-weight:700">{{ explode('.', $permission->name)[1] }}</span>
                @endforeach
              </div>
            </div>
          @empty
            <div class="hrp-input Rectangle-29" style="display:flex;align-items:center;min-height:44px">No permissions assigned to this role</div>
          @endforelse
        </div>
      </div>

      <div class="hrp-actions" style="padding-top:12px">
        @can('Roles Management.edit role')
          <a class="hrp-btn" href="{{ route('roles.edit', $role) }}">Edit Role</a>
        @endcan
        @can('Roles Management.delete role')
          @if($role->users->count() == 0)
            <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline-block; margin-left:8px" onsubmit="return confirm('Are you sure?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="hrp-btn" style="background:#fff;color:#ef4444;border:1px solid #f2d7d7">Delete Role</button>
            </form>
          @endif
        @endcan
      </div>
    </div>
  </div>
@endsection