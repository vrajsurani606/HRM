@extends('layouts.macos')
@section('page_title', $page_title)

@section('content')
  <div class="employee-container">
    <form method="GET" action="{{ route('employees.index') }}" class="jv-filter">
      <input type="text" name="name" class="filter-pill" placeholder="Name" value="{{ request('name') }}">
      <input type="text" name="email" class="filter-pill" placeholder="Email" value="{{ request('email') }}">
      <input type="text" name="code" class="filter-pill" placeholder="Employee Code" value="{{ request('code') }}">
      <button type="submit" class="filter-search" aria-label="Search">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
        </svg>
      </button>
      <div class="filter-right">
        <div class="view-toggle-group" style="margin-right:8px;">
          <button class="view-toggle-btn" data-view="grid" title="Grid View" aria-label="Grid View">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="3" width="7" height="7" rx="1"></rect>
              <rect x="14" y="3" width="7" height="7" rx="1"></rect>
              <rect x="3" y="14" width="7" height="7" rx="1"></rect>
              <rect x="14" y="14" width="7" height="7" rx="1"></rect>
            </svg>
          </button>
          <button class="view-toggle-btn active" data-view="list" title="List View" aria-label="List View">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="8" y1="6" x2="21" y2="6"></line>
              <line x1="8" y1="12" x2="21" y2="12"></line>
              <line x1="8" y1="18" x2="21" y2="18"></line>
              <line x1="3" y1="6" x2="3.01" y2="6"></line>
              <line x1="3" y1="12" x2="3.01" y2="12"></line>
              <line x1="3" y1="18" x2="3.01" y2="18"></line>
            </svg>
          </button>
        </div>
        <input type="text" name="search" class="filter-pill" placeholder="Search here..." value="{{ request('search') }}">
        <a href="{{ route('employees.index') }}" class="pill-btn pill-secondary">Reset</a>
        @can('Employees Management.create employee')
          <a href="{{ route('employees.create') }}" class="pill-btn pill-success">+ Add</a>
        @endcan
      </div>
    </form>

    <!-- Grid View -->
    <div class="employees-grid-view active">
      <div class="employee-grid"> 
        
        @forelse($employees as $emp)
          <div class="emp-card">
            <!-- Top Row: Badge and Actions -->
            <div class="card-header">
              @php(
                $isModel = $emp instanceof \App\Models\Employee
              )
              @php(
                $rawType = $emp->experience_type ?? ''
              )
              @php(
                $displayType = $rawType === 'YES' ? 'Experience' : ($rawType === 'NO' ? 'Fresher' : ($rawType ?: 'Full - Time'))
              )
              @php(
                $etype = strtolower(trim($displayType))
              )
              @php(
                $badge = [
                  'bg' => '#f3f4f6',
                  'fg' => '#374151',
                  'text' => $displayType,
                ]
              )
              @php(
                $map = [
                  'experience' => ['#fce7f3', '#be185d'], // pink
                  'fresher' => ['#dcfce7', '#166534'],     // green
                  'trainee' => ['#dbeafe', '#1d4ed8'],     // blue
                  'intern' => ['#e0e7ff', '#3730a3'],      // indigo
                  'contract' => ['#fee2e2', '#b91c1c'],    // red
                ]
              )
              @if(isset($map[$etype]))
                @php($badge['bg'] = $map[$etype][0])
                @php($badge['fg'] = $map[$etype][1])
              @endif
              <span class="emp-badge" style="background: {{ $badge['bg'] }}; color: {{ $badge['fg'] }}">{{ $badge['text'] }}</span>
              
              <div class="dropdown">
                <button class="dropdown-toggle" onclick="toggleDropdown({{ $loop->index }})" title="More options">⋮</button>
                <div id="dropdown-{{ $loop->index }}" class="dropdown-menu">
                  @if($isModel)
                    @can('Employees Management.view employee')
                      <a href="{{ route('employees.show', $emp) }}">
                        <img src="{{ asset('action_icon/view.svg') }}" width="16" height="16"> View
                      </a>
                    @endcan
                    @can('Employees Management.edit employee')
                      <a href="{{ route('employees.edit', $emp) }}">
                        <img src="{{ asset('action_icon/edit.svg') }}" width="16" height="16"> Edit
                      </a>
                    @endcan
                    @can('Employees Management.delete employee')
                      <form method="POST" action="{{ route('employees.destroy', $emp) }}" class="delete-form">
                        @csrf @method('DELETE')
                        <button type="button" class="delete-btn" onclick="confirmDelete(this)">
                          <img src="{{ asset('action_icon/delete.svg') }}" width="16" height="16"> Delete
                        </button>
                      </form>
                    @endcan
                    @can('Employees Management.letters')
                      <a href="{{ route('employees.letters.index', $emp) }}">
                        <img src="{{ asset('action_icon/print.svg') }}" width="16" height="16"> Letter
                      </a>
                    @endcan
                    @can('Employees Management.digital card')
                      <a href="{{ route('employees.digital-card.create', $emp) }}">
                        <img src="{{ asset('action_icon/pluse.svg') }}" width="16" height="16"> Add Dig. Card
                      </a>
                    @endcan
                  @endif
                </div>
              </div>
            </div>
            
            <!-- Section Separator -->
            <div class="section-separator"></div>

            <!-- Profile Section -->
            <div class="profile-section">
              <div class="profile-image">
                @php($initial = strtoupper(mb_substr((string)($emp->name ?? 'U'), 0, 1)))
                @if(isset($emp->photo_path) && $emp->photo_path)
                  <img src="{{ storage_asset(''.$emp->photo_path) }}" alt="{{ $emp->name }}">
                @else
                  <span style="
                    width:100%;height:100%;display:flex;align-items:center;justify-content:center;
                    font-weight:700;font-size:20px;color:#fff;background:linear-gradient(135deg,#3b82f6,#9333ea);">
                    {{ $initial }}
                  </span>
                @endif
              </div>
              <div class="profile-info">
                <h3 class="profile-name">{{ $emp->name }}</h3>
                <p class="profile-email">{{ $emp->email }}</p>
              </div>
            </div>

            <!-- Role Section -->
            <div class="role-section">
              <div class="role-badge">
                <div class="role-dot"></div>
                <span class="role-title">{{ $emp->position ?: '-' }}</span>
              </div>
              <span class="role-description">{{ $emp->position ?: '-' }}</span>
            </div>

            <!-- Bottom Info -->
            <div class="bottom-info">
              <div class="info-labels">
                <div>Payroll</div>
                <div>Join Date</div>
              </div>
              <div class="info-values">
                <div>{{ $emp->code ?: '-' }} | ₹{{ isset($emp->current_offer_amount) ? number_format($emp->current_offer_amount,0) : '-' }}</div>
                <div>{{ !empty($emp->joining_date) ? \Carbon\Carbon::parse($emp->joining_date)->format('d M,Y') : '-' }}</div>
              </div>
            </div>
          </div>
        @empty
          <div class="empty-state">No employees found</div>
        @endforelse
      </div>
    </div>

    <!-- List View -->
    <div class="employees-list-view">
      <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
        <table>
          <thead>
            <tr>
              <th>Action</th>
              <th>Code</th>
              <th>Name</th>
              <th>Email</th>
              <th>Position</th>
              <th>Payroll</th>
              <th>Join Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse($employees as $emp)
            <tr>
              <td>
                <div class="action-icons">
                  @can('Employees Management.view employee')
                    <a href="{{ route('employees.show', $emp) }}" title="View"><img src="{{ asset('action_icon/view.svg') }}" class="action-icon" alt="View"></a>
                  @endcan
                  @can('Employees Management.edit employee')
                    <a href="{{ route('employees.edit', $emp) }}" title="Edit"><img src="{{ asset('action_icon/edit.svg') }}" class="action-icon" alt="Edit"></a>
                  @endcan
                  @can('Employees Management.delete employee')
                    <form method="POST" action="{{ route('employees.destroy', $emp) }}" class="delete-form" style="display:inline">
                      @csrf @method('DELETE')
                      <button type="button" onclick="confirmDelete(this)" title="Delete" aria-label="Delete" style="background:transparent;border:0;padding:0;line-height:1;cursor:pointer">
                        <img src="{{ asset('action_icon/delete.svg') }}" class="action-icon" alt="Delete">
                      </button>
                    </form>
                  @endcan
                  @can('Employees Management.letters')
                    <a href="{{ route('employees.letters.index', $emp) }}" title="Letter"><img src="{{ asset('action_icon/print.svg') }}" class="action-icon" alt="Letter"></a>
                  @endcan
                  @can('Employees Management.digital card')
                    <a href="{{ route('employees.digital-card.create', $emp) }}" title="Add Digital Card"><img src="{{ asset('action_icon/pluse.svg') }}" class="action-icon" alt="Add Digital Card"></a>
                  @endcan
                </div>
              </td>
              <td>{{ $emp->code ?: '-' }}</td>
              <td>{{ $emp->name ?: '-' }}</td>
              <td>{{ $emp->email ?: '-' }}</td>
              <td>{{ $emp->position ?: '-' }}</td>
              <td>{{ isset($emp->current_offer_amount) ? ('₹'.number_format($emp->current_offer_amount,0)) : '-' }}</td>
              <td>{{ !empty($emp->joining_date) ? \Carbon\Carbon::parse($emp->joining_date)->format('d M, Y') : '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-3">No employees found</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    
    <!-- Pagination -->
    @if($employees->hasPages())
      <div class="pagination-wrapper">
        {{ $employees->links() }}
      </div>
    @endif
  </div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/employee-grid.css') }}">
<style>
  /* View toggle and list/grid visibility */
  .view-toggle-group { display:flex; gap:4px; background:#f3f4f6; padding:4px; border-radius:8px; }
  .view-toggle-btn { padding:8px 12px; background:transparent; border:none; border-radius:6px; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; }
  .view-toggle-btn:hover { background:#e5e7eb; }
  .view-toggle-btn.active { background:#fff; box-shadow:0 1px 3px rgba(0,0,0,0.1); }
  .view-toggle-btn svg { color:#6b7280; }
  .view-toggle-btn.active svg { color:#3b82f6; }

  .employees-grid-view { display:none; padding:12px 12px 8px; }
  .employees-grid-view.active { display:block; }
  .employees-list-view { display:none; padding: 0 0 12px; }
  .employees-list-view.active { display:block; }

  .JV-datatble table td { vertical-align: middle; }
  .action-icons { display:inline-flex; align-items:center; gap:8px; }
  .action-icons form { margin:0; padding:0; display:inline-flex; }
  .action-icons button { display:inline-flex; align-items:center; justify-content:center; padding:0; margin:0; line-height:1; background:transparent; border:0; cursor:pointer; }
  .pagination-wrapper {
    margin-top: 32px;
    display: flex;
    justify-content: center;
  }
  
  .pagination-wrapper .pagination {
    display: flex;
    gap: 8px;
    align-items: center;
  }
  
  .pagination-wrapper .pagination a,
  .pagination-wrapper .pagination span {
    padding: 8px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    color: #374151;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
  }
  
  .pagination-wrapper .pagination a:hover {
    background: #f3f4f6;
  }
  
  .pagination-wrapper .pagination .active span {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
  }
  
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
  
  .large-swal-popup .swal2-confirm,
  .large-swal-popup .swal2-cancel {
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
  // Close all other dropdowns
  document.querySelectorAll('.dropdown-menu').forEach(menu => {
    if (menu.id !== `dropdown-${index}`) {
      menu.style.display = 'none';
    }
  });
  
  // Toggle current dropdown
  const dropdown = document.getElementById(`dropdown-${index}`);
  dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
  if (!event.target.closest('.dropdown')) {
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
      menu.style.display = 'none';
    });
  }
});

// SweetAlert delete confirmation
function confirmDelete(button) {
  Swal.fire({
    title: 'Delete this employee?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel',
    width: '400px',
    padding: '1.5rem',
    customClass: {
      popup: 'large-swal-popup'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      button.closest('form').submit();
    }
  });
}

  // Employees view toggle with persistence
  document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.view-toggle-btn');
    const grid = document.querySelector('.employees-grid-view');
    const list = document.querySelector('.employees-list-view');
    if (!buttons.length || !grid || !list) return;

    function applyView(view) {
      if (view === 'grid') { grid.classList.add('active'); list.classList.remove('active'); }
      else { list.classList.add('active'); grid.classList.remove('active'); }
      buttons.forEach(b => b.classList.toggle('active', b.getAttribute('data-view') === view));
    }
    const saved = localStorage.getItem('employees_view') || 'grid';
    applyView(saved);
    buttons.forEach(btn => btn.addEventListener('click', function(){
      const v = this.getAttribute('data-view');
      localStorage.setItem('employees_view', v);
      applyView(v);
    }));
  });
</script>
@endpush