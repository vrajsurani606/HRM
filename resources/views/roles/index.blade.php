@extends('layouts.macos')
@section('page_title', 'Roles Management')

@section('content')
  <div class="hrp-card">
    <div class="hrp-compact">

      @if(session('error'))
        <div class="hrp-alert hrp-alert-danger">{{ session('error') }}</div>
      @endif

      <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
        <div class="jv-filter">
          <div class="filter-right">
            <form method="GET" action="{{ route('roles.index') }}" class="filter-row">
              <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Search roles..." class="filter-pill">
              <select name="per_page" class="filter-pill" onchange="this.form.submit()">
                @foreach([10,25,50,100] as $n)
                  <option value="{{ $n }}" {{ (isset($perPage) && (int)$perPage === $n) ? 'selected' : '' }}>{{ $n }} / page</option>
                @endforeach
              </select>
              <button type="submit" class="filter-search" aria-label="Search">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                  <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" />
                  <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" />
                </svg>
              </button>
              @can('Roles Management.create role')
                <a href="{{ route('roles.create') }}" class="pill-btn pill-success">+ Add</a>
              @endcan
            </form>
          </div>
        </div>
        <table>
          <thead>
            <tr>
              <th>Actions</th>
              <th>ID</th>
              <th>Role Name</th>
              <th>Description</th>
              <th>Permissions</th>
              <th>Users</th>
            </tr>
          </thead>
          <tbody>
          @forelse($roles as $role)
            <tr>
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
              <td>{{ $role->id }}</td>
              <td>{{ ucfirst($role->name) }}</td>
              <td>{{ $role->description ?? 'No description' }}</td>
              <td>{{ $role->permissions->count() }}</td>
              <td>{{ $role->users->count() }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="6">No roles found</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>

      <div class="pagination-wrapper">
        {{ $roles->links() }}
      </div>
    </div>
  </div>
<style>

  .macos-theme .hrp-window .hrp-compact{ padding:0 10px; }
</style>
@endsection