@extends('layouts.macos')
@section('page_title', 'User Management')

@section('content')
  <div class="employee-container">
    <div class="hrp-actions" style="justify-content: flex-end; padding: 0 4px 8px;">
      @can('Users Management.create user')
        <a class="hrp-btn hrp-btn-primary" href="{{ route('users.create') }}">Create User</a>
      @endcan
    </div>
    <div class="employee-grid">
      @forelse($users as $user)
        @php
          // Get employee record if exists for better photo
          $employee = \App\Models\Employee::where('email', $user->email)->first();
          $photoUrl = $employee ? $employee->profile_photo_url : $user->profile_photo_url;
        @endphp
        <div class="emp-card">
          <div class="card-header">
            @php($badgeText = optional($user->roles->first())->name ?? 'User')
            <span class="emp-badge">{{ ucfirst($badgeText) }}</span>
            <div class="dropdown">
              <button class="dropdown-toggle" onclick="toggleDropdown({{ $loop->index }})" title="More options">⋮</button>
              <div id="dropdown-{{ $loop->index }}" class="dropdown-menu">
                @can('Users Management.edit user')
                  <a href="{{ route('users.edit', $user) }}">
                    <img src="{{ asset('action_icon/edit.svg') }}" width="16" height="16"> Edit
                  </a>
                @endcan
                @can('Users Management.delete user')
                  <form method="POST" action="{{ route('users.destroy', $user) }}" class="delete-form">
                    @csrf @method('DELETE')
                    <button type="button" class="delete-btn" onclick="confirmDelete(this)">
                      <img src="{{ asset('action_icon/delete.svg') }}" width="16" height="16"> Delete
                    </button>
                  </form>
                @endcan
                @can('Users Management.view user')
                  <a href="{{ route('users.show', $user) }}">
                    <img src="{{ asset('action_icon/view.svg') }}" width="16" height="16"> View
                  </a>
                @endcan
              </div>
            </div>
          </div>

          <div class="section-separator"></div>

          <div class="profile-section">
            <div class="profile-image">
              <x-profile-avatar :user="$user" :employee="$employee" size="lg" />
            </div>
            <div class="profile-info">
              <h3 class="profile-name">{{ $user->name }}</h3>
              <p class="profile-email">{{ $user->email }}</p>
            </div>
          </div>

          <div class="role-section">
            <div class="role-badge">
              <div class="role-dot"></div>
              <span class="role-title">{{ optional($user->roles->first())->name ? ucfirst(optional($user->roles->first())->name) : 'User' }}</span>
            </div>
            @if($user->roles && $user->roles->count() > 1)
              <span class="role-description">+{{ $user->roles->count() - 1 }} more</span>
            @else
              <span class="role-description">Application User</span>
            @endif
          </div>

          <div class="bottom-info">
            <div class="info-labels">
              <div>Mobile</div>
              <div>Joined</div>
            </div>
            <div class="info-values">
              <div>{{ display_mobile($user->mobile_no) ?? 'N/A' }}</div>
              <div>{{ optional($user->created_at)->format('d M, Y') }}</div>
            </div>
          </div>
        </div>
      @empty
        <x-empty-state-grid 
            title="No users found" 
            message="Try adjusting your filters or create a new user"
        />
      @endforelse
    </div>
  </div>
@endsection

@section('footer_pagination')
  @if(isset($users) && method_exists($users,'links'))
  <form method="GET" class="hrp-entries-form">
    <span>Entries</span>
    @php($currentPerPage = (int) request()->get('per_page', 12))
    <select name="per_page" onchange="this.form.submit()">
      @foreach([12,24,48,100] as $size)
      <option value="{{ $size }}" {{ $currentPerPage === $size ? 'selected' : '' }}>{{ $size }}</option>
      @endforeach
    </select>
    @foreach(request()->except(['per_page','page']) as $k => $v)
    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
    @endforeach
  </form>
  {{ $users->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv') }}
  @endif
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/employee-grid.css') }}">
<style>
  .large-swal-popup {
    font-size: 15px !important;
  }
  
  .large-swal-popup .swal2-title {
    font-size: 20px !important;
    font-weight: 600 !important;
    margin-bottom: 1rem !important;
  }
  
  .large-swal-popup .swal2-content {
    font-size: 15px !important;
    margin-bottom: 1.5rem !important;
    line-height: 1.4 !important;
  }
  
  .large-swal-popup .swal2-actions {
    gap: 0.75rem !important;
    margin-top: 1rem !important;
  }
  
  .large-swal-popup .swal2-actions .swal2-styled {
    font-size: 14px !important;
    padding: 8px 16px !important;
    border-radius: 6px !important;
  }
  
  .large-swal-popup .swal2-icon {
    margin: 0.5rem auto 1rem !important;
  }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function toggleDropdown(index) {
  document.querySelectorAll('.dropdown-menu').forEach(menu => {
    if (menu.id !== `dropdown-${index}`) menu.style.display = 'none';
  });
  const dropdown = document.getElementById(`dropdown-${index}`);
  if(dropdown){ dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none'; }
}
document.addEventListener('click', function(event) {
  if (!event.target.closest('.dropdown')) {
    document.querySelectorAll('.dropdown-menu').forEach(menu => { menu.style.display = 'none'; });
  }
});
function confirmDelete(button) {
  Swal.fire({
    title: 'Delete this user?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel',
    width: '400px',
    padding: '1.5rem',
    customClass: { popup: 'large-swal-popup' }
  }).then((result) => {
    if (result.isConfirmed) {
      button.closest('form').submit();
    }
  });
}
</script>
@endpush