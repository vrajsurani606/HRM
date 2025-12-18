@extends('layouts.macos')
@section('page_title', 'Roles Management')

@section('content')
  <div class="hrp-card">
    <div class="hrp-card-body">
      <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
        <div class="jv-filter">
          <div class="filter-right">
            <form method="GET" action="{{ route('roles.index') }}" class="filter-row" data-no-loader="true">
              <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Search roles..." class="filter-pill live-search">
              <button type="submit" class="filter-search" aria-label="Search">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                  <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" />
                  <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" />
                </svg>
              </button>
              <a href="{{ route('roles.index') }}" class="pill-btn pill-secondary">Reset</a>
              @can('Roles Management.create role')
                <a href="{{ route('roles.create') }}" class="pill-btn pill-success">+ Add</a>
              @endcan
            </form>
          </div>
        </div>
        <table>
          <thead>
            <tr>
              @if(user_has_any_action_permission('Roles Management', ['view role', 'edit role', 'delete role']))
                <th>Actions</th>
              @endif
              <th>ID</th>
              <th>Role Name</th>
              <th>Description</th>
              <th>Dashboard</th>
              <th>Data Access</th>
              <th>Permissions</th>
              <th>Users</th>
            </tr>
          </thead>
          <tbody>
          @forelse($roles as $role)
            <tr>
              @if(user_has_any_action_permission('Roles Management', ['view role', 'edit role', 'delete role']))
                <td>
                  <div class="action-icons">
                    @can('Roles Management.view role')
                      <a href="{{ route('roles.show', $role) }}" class="action-icon" title="View"><img src="{{ asset('action_icon/view.svg') }}" alt="view" width="16" height="16"></a>
                    @endcan
                    @can('Roles Management.edit role')
                      <a href="{{ route('roles.edit', $role) }}" class="action-icon" title="Edit"><img src="{{ asset('action_icon/edit.svg') }}" alt="edit" width="16" height="16"></a>
                    @endcan
                    @can('Roles Management.delete role')
                      @if($role->users->count() == 0)
                        <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="action-icon" title="Delete"><img src="{{ asset('action_icon/delete.svg') }}" alt="delete" width="16" height="16"></button>
                        </form>
                      @endif
                    @endcan
                  </div>
                </td>
              @endif
              <td>{{ $role->id }}</td>
              <td>{{ ucfirst($role->name) }}</td>
              <td>{{ $role->description ?? 'No description' }}</td>
              <td>
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
                <span style="background:{{ $dtColor['bg'] }}; color:{{ $dtColor['color'] }}; padding:2px 8px; border-radius:4px; font-size:12px; font-weight:600;">{{ ucfirst($dt) }}</span>
              </td>
              <td>
                @if($role->restrict_to_own_data)
                  <span style="background:#fef3c7; color:#92400e; padding:2px 8px; border-radius:4px; font-size:12px; font-weight:600;">Own Data Only</span>
                @else
                  <span style="background:#d1fae5; color:#065f46; padding:2px 8px; border-radius:4px; font-size:12px; font-weight:600;">All Data</span>
                @endif
              </td>
              <td>{{ $role->permissions->count() }}</td>
              <td>{{ $role->users->count() }}</td>
            </tr>
          @empty
            <x-empty-state 
                colspan="{{ user_has_any_action_permission('Roles Management', ['view role', 'edit role', 'delete role']) ? '8' : '7' }}" 
                title="No roles found" 
                message="Create a new role to get started"
            />
          @endforelse
          </tbody>
        </table>
      </div>

  </div>
</div>

@endsection

@section('footer_pagination')
  @if(isset($roles) && method_exists($roles,'links'))
  <form method="GET" class="hrp-entries-form">
    <span>Entries</span>
    @php($currentPerPage = (int) request()->get('per_page', 10))
    <select name="per_page" onchange="this.form.submit()">
      @foreach([10,25,50,100] as $size)
      <option value="{{ $size }}" {{ $currentPerPage === $size ? 'selected' : '' }}>{{ $size }}</option>
      @endforeach
    </select>
    @foreach(request()->except(['per_page','page']) as $k => $v)
    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
    @endforeach
  </form>
  {{ $roles->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv') }}
  @endif
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('roles.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Roles Management</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Roles List</span>
@endsection