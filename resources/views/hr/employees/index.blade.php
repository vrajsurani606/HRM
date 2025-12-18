@extends('layouts.macos')
@section('page_title', $page_title)

@section('content')
  <div class="employee-container">
    <form method="GET" action="{{ route('employees.index') }}" class="jv-filter" data-no-loader="true">
      <select name="status" class="filter-pill" onchange="this.form.submit()">
        <option value="active" {{ request('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Users</option>
      </select>
      <select name="position_group" class="filter-pill" onchange="this.form.submit()">
        <option value="">All Positions</option>
        @foreach($positionGroups ?? [] as $groupName => $positions)
          <option value="{{ $groupName }}" {{ request('position_group') == $groupName ? 'selected' : '' }}>{{ $groupName }}</option>
        @endforeach
      </select>
      <input type="text" name="name" class="filter-pill" placeholder="Name" value="{{ request('name') }}">
      <input type="text" name="email" class="filter-pill" placeholder="Email" value="{{ request('email') }}">
      <input type="text" name="code" class="filter-pill" placeholder="Employee Code" value="{{ request('code') }}">
      
      <button type="submit" class="filter-search" aria-label="Search">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
        </svg>
      </button>

      <a href="{{ route('employees.index') }}" class="filter-search" aria-label="Reset" title="Reset Filters">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
          <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
        </svg>
      </a>

      <div class="filter-right">
        <div class="view-toggle-group">
          <button type="button" class="view-toggle-btn" data-view="grid" title="Grid View" aria-label="Grid View">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="3" width="7" height="7" rx="1"></rect>
              <rect x="14" y="3" width="7" height="7" rx="1"></rect>
              <rect x="3" y="14" width="7" height="7" rx="1"></rect>
              <rect x="14" y="14" width="7" height="7" rx="1"></rect>
            </svg>
          </button>
          <button type="button" class="view-toggle-btn active" data-view="list" title="List View" aria-label="List View">
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

        <input type="text" name="search" class="filter-pill live-search" placeholder="Search here..." value="{{ request('search') }}">

        @can('Employees Management.create employee')
          <a href="{{ route('employees.create') }}" class="pill-btn pill-success">+ Add</a>
        @endcan
      </div>
    </form>

    <!-- Grid View -->
    <div class="employees-grid-view active">
      <div class="employee-grid"> 
        
        @forelse($employees as $emp)
          <div class="emp-card" data-employee-id="{{ $emp->id }}">
            <!-- Top Row: Badge and Actions -->
            <div class="card-header">
              @php(
                $isModel = $emp instanceof \App\Models\Employee
              )
              @php(
                // Top badge shows Experience/Fresher
                $rawType = $emp->experience_type ?? ''
              )
              @php(
                $displayType = $rawType === 'YES' ? 'Experience' : ($rawType === 'NO' ? 'Fresher' : 'Full - Time')
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
                  'full - time' => ['#dbeafe', '#1d4ed8'], // blue
                ]
              )
              @if(isset($map[$etype]))
                @php($badge['bg'] = $map[$etype][0])
                @php($badge['fg'] = $map[$etype][1])
              @endif
              <div style="display: flex; gap: 8px; align-items: center;">
                <span class="emp-badge" style="background: {{ $badge['bg'] }}; color: {{ $badge['fg'] }}">{{ $badge['text'] }}</span>
              </div>
              
              <div style="display: flex; gap: 8px; align-items: center;">
                @if(($emp->status ?? 'active') === 'inactive')
                  <img src="{{ asset('action_icon/block.svg') }}" width="20" height="20" title="Account Blocked" alt="Blocked">
                @endif
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
                        <form method="POST" action="{{ route('employees.toggle-status', $emp->id) }}" style="display:inline;margin:0;">
                          @csrf
                          <button type="submit" class="dropdown-item-btn">
                            @if(($emp->status ?? 'active') === 'active')
                              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                              </svg>
                              Mark Inactive
                            @else
                              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="9 11 12 14 22 4"></polyline>
                              </svg>
                              Mark Active
                            @endif
                          </button>
                        </form>
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
                        @if($emp->digitalCard)
                          <a href="{{ route('employees.digital-card.show', $emp) }}" title="View Digital Card">
                            <img src="{{ asset('action_icon/show.svg') }}" width="16" height="16"> Digital Card
                          </a>
                        @else
                          <a href="{{ route('employees.digital-card.create', $emp) }}" title="Create Digital Card">
                            <img src="{{ asset('action_icon/pluse.svg') }}" width="16" height="16"> Create Digital Card
                          </a>
                        @endif
                      @endcan
                      @can('Employees Management.view employee')
                        <a href="{{ route('employees.id-card.show', $emp) }}" title="Employee ID Card">
                          <i class="fas fa-id-card" style="width: 16px; margin-right: 4px; color: #6b7280;"></i> ID Card
                        </a>
                      @endcan
                    @endif
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Section Separator -->
            <div class="section-separator"></div>

            <!-- Profile Section -->
            <div class="profile-section">
              <div class="profile-image">
                <x-profile-avatar :employee="$emp" :user="$emp->user" size="lg" />
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
                @php($userRole = $emp->user && $emp->user->roles->first() ? $emp->user->roles->first()->name : null)
                @php($displayRole = $userRole ? ucwords(str_replace('-', ' ', $userRole)) : 'Employee')
                <span class="role-title">{{ $displayRole }}</span>
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
              @if(user_has_any_action_permission('Employees Management', ['view employee', 'edit employee', 'delete employee', 'letters', 'digital card']))
                <th>Action</th>
              @endif
              <th>Status</th>
              <th>Code</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Position</th>
              <th>Payroll</th>
              <th>Join Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse($employees as $emp)
            <tr data-employee-id="{{ $emp->id }}">
              @if(user_has_any_action_permission('Employees Management', ['view employee', 'edit employee', 'delete employee', 'letters', 'digital card']))
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
                      @if($emp->digitalCard)
                        <a href="{{ route('employees.digital-card.show', $emp) }}" title="View Digital Card"><img src="{{ asset('action_icon/show.svg') }}" class="action-icon" alt="Digital Card"></a>
                      @else
                        <a href="{{ route('employees.digital-card.create', $emp) }}" title="Create Digital Card"><img src="{{ asset('action_icon/pluse.svg') }}" class="action-icon" alt="Create Digital Card"></a>
                      @endif
                    @endcan
                    @can('Employees Management.view employee')
                      <a href="{{ route('employees.id-card.show', $emp) }}" title="Employee ID Card" style="display: inline-flex; align-items: center; padding: 2px;"><i class="fas fa-id-card" style="font-size: 14px; color: #6b7280;"></i></a>
                    @endcan
                  </div>
                </td>
              @endif
              <td>
                @can('Employees Management.edit employee')
                  <form method="POST" action="{{ route('employees.toggle-status', $emp->id) }}" style="display:inline;margin:0;">
                    @csrf
                    <button type="submit" class="status-toggle-btn" title="Click to toggle status">
                      @if(($emp->status ?? 'active') === 'active')
                        <span class="status-badge active-badge">
                          <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="10"></circle>
                          </svg>
                          Active
                        </span>
                      @else
                        <span class="status-badge inactive-badge">
                          <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="10"></circle>
                          </svg>
                          Inactive
                        </span>
                      @endif
                    </button>
                  </form>
                @else
                  @if(($emp->status ?? 'active') === 'active')
                    <span class="status-badge active-badge">
                      <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="12" cy="12" r="10"></circle>
                      </svg>
                      Active
                    </span>
                  @else
                    <span class="status-badge inactive-badge">
                      <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="12" cy="12" r="10"></circle>
                      </svg>
                      Inactive
                    </span>
                  @endif
                @endcan
              </td>
              <td>{{ $emp->code ?: '-' }}</td>
              <td>{{ $emp->name ?: '-' }}</td>
              <td>{{ $emp->email ?: '-' }}</td>
              <td>
                @php($userRole = $emp->user && $emp->user->roles->first() ? $emp->user->roles->first()->name : null)
                @php($displayRole = $userRole ? ucwords(str_replace('-', ' ', $userRole)) : 'Employee')
                <span class="role-badge-small">{{ $displayRole }}</span>
              </td>
              <td>{{ $emp->position ?: '-' }}</td>
              <td>{{ isset($emp->current_offer_amount) ? ('₹'.number_format($emp->current_offer_amount,0)) : '-' }}</td>
              <td>{{ !empty($emp->joining_date) ? \Carbon\Carbon::parse($emp->joining_date)->format('d M, Y') : '-' }}</td>
            </tr>
            @empty
            <x-empty-state 
                colspan="{{ user_has_any_action_permission('Employees Management', ['view employee', 'edit employee', 'delete employee', 'letters', 'digital card']) ? '9' : '8' }}" 
                title="No employees found" 
                message="Try adjusting your filters or add a new employee"
            />
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    
  </div>
@endsection

@section('footer_pagination')
  @if(isset($employees) && method_exists($employees,'links'))
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
  {{ $employees->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv') }}
  @endif
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
  
  /* Action icon styling */
  .action-icon {
    width: 16px;
    height: 16px;
    opacity: 0.7;
    transition: opacity 0.2s ease;
  }

  .action-icons a:hover .action-icon {
    opacity: 1;
  }

  /* FontAwesome icon styling in action buttons */
  .action-icons .fas {
    color: #6b7280;
    font-size: 14px;
    transition: color 0.2s ease;
  }

  .action-icons a:hover .fas {
    color: #374151;
  }

  /* Grid view dropdown icon styling */
  .dropdown-menu .fas {
    color: #6b7280;
    font-size: 14px;
    width: 16px;
    text-align: center;
  }
  
  /* Status badges */
  .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
    line-height: 1;
  }
  
  .status-badge.active-badge {
    background: #dcfce7;
    color: #166534;
  }
  
  .status-badge.inactive-badge {
    background: #fee2e2;
    color: #991b1b;
  }
  
  .status-toggle-btn {
    background: transparent;
    border: none;
    padding: 0;
    cursor: pointer;
    transition: opacity 0.2s;
  }
  
  .status-toggle-btn:hover {
    opacity: 0.7;
  }
  
  .role-badge-small {
    display: inline-block;
    padding: 4px 10px;
    background: #f3f4f6;
    color: #374151;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
  }
  

  
  .dropdown-item-btn {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: transparent;
    border: none;
    text-align: left;
    cursor: pointer;
    font-size: 14px;
    color: #374151;
    transition: background 0.2s;
  }
  
  .dropdown-item-btn:hover {
    background: #f3f4f6;
  }
  
  .dropdown-item-btn svg {
    flex-shrink: 0;
  }

  /* Digital Card Dropdown Styles */
  .digital-card-dropdown .dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    border-radius: 4px;
    transition: background-color 0.2s ease;
    text-decoration: none;
    color: inherit;
  }

  .digital-card-dropdown .dropdown-toggle:hover {
    background-color: #f3f4f6;
  }

  .digital-card-dropdown .dropdown-menu {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    padding: 4px 0;
    min-width: 200px;
  }

  .digital-card-dropdown .dropdown-item {
    padding: 8px 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #374151;
    text-decoration: none;
    transition: background-color 0.2s ease;
  }

  .digital-card-dropdown .dropdown-item:hover {
    background-color: #f3f4f6;
    color: #1f2937;
  }

  .digital-card-dropdown .dropdown-item i {
    width: 16px;
    text-align: center;
    color: #6b7280;
  }

  .digital-card-dropdown .dropdown-divider {
    margin: 4px 0;
    border-color: #e5e7eb;
  }

  /* Action button spacing */
  .action-buttons-group {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
  }

  .action-buttons-group > a,
  .action-buttons-group > form,
  .action-buttons-group > .dropdown {
    flex-shrink: 0;
  }
  
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

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('employees.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Employee Management</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Employee List</span>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function toggleDropdown(index) {
  // Close all other dropdowns and reset z-index on their parent cards
  document.querySelectorAll('.dropdown-menu').forEach(menu => {
    if (menu.id !== `dropdown-${index}`) {
      menu.style.display = 'none';
      const parentCard = menu.closest('.emp-card');
      if (parentCard) parentCard.style.zIndex = '';
    }
  });
  
  // Toggle current dropdown
  const dropdown = document.getElementById(`dropdown-${index}`);
  const isOpening = dropdown.style.display === 'none';
  dropdown.style.display = isOpening ? 'block' : 'none';
  
  // Set z-index on parent card when dropdown is open
  const parentCard = dropdown.closest('.emp-card');
  if (parentCard) {
    parentCard.style.zIndex = isOpening ? '100' : '';
  }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
  if (!event.target.closest('.dropdown')) {
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
      menu.style.display = 'none';
      const parentCard = menu.closest('.emp-card');
      if (parentCard) parentCard.style.zIndex = '';
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
    buttons.forEach(btn => btn.addEventListener('click', function(e){
      e.preventDefault();
      e.stopPropagation();
      const v = this.getAttribute('data-view');
      localStorage.setItem('employees_view', v);
      applyView(v);
    }));
  });

  // Toggle employee status - Using form submission for reliability
  function toggleEmployeeStatus(employeeId, currentStatus) {
    console.log('Toggle status called:', employeeId, currentStatus);
    
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    const actionText = newStatus === 'inactive' ? 'deactivate' : 'activate';
    
    Swal.fire({
      title: `${actionText.charAt(0).toUpperCase() + actionText.slice(1)} Employee?`,
      text: `Are you sure you want to ${actionText} this employee?`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: newStatus === 'inactive' ? '#ef4444' : '#10b981',
      cancelButtonColor: '#6b7280',
      confirmButtonText: `Yes, ${actionText}!`,
      cancelButtonText: 'Cancel',
      width: '400px',
      padding: '1.5rem',
      customClass: {
        popup: 'large-swal-popup'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        // Create and submit a form (more reliable than fetch for Laravel)
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/employees/${employeeId}/toggle-status`;
        form.style.display = 'none';
        
        // Add CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
          const tokenInput = document.createElement('input');
          tokenInput.type = 'hidden';
          tokenInput.name = '_token';
          tokenInput.value = csrfToken.getAttribute('content') || csrfToken.content;
          form.appendChild(tokenInput);
        }
        
        // Add a hidden input to indicate we want JSON response
        const ajaxInput = document.createElement('input');
        ajaxInput.type = 'hidden';
        ajaxInput.name = 'ajax';
        ajaxInput.value = '1';
        form.appendChild(ajaxInput);
        
        document.body.appendChild(form);
        
        // Show loading
        Swal.fire({
          title: 'Processing...',
          text: 'Updating employee status',
          allowOutsideClick: false,
          allowEscapeKey: false,
          showConfirmButton: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });
        
        // Submit form and handle response
        const formData = new FormData(form);
        
        fetch(form.action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          },
          credentials: 'same-origin'
        })
        .then(response => {
          console.log('Response status:', response.status);
          console.log('Content-Type:', response.headers.get('content-type'));
          
          return response.text().then(text => {
            console.log('Response (first 500 chars):', text.substring(0, 500));
            
            // Try to parse as JSON
            try {
              const data = JSON.parse(text);
              return { ok: response.ok, status: response.status, data: data };
            } catch (e) {
              // Not JSON, return as HTML error
              return { ok: false, status: response.status, html: text };
            }
          });
        })
        .then(result => {
          document.body.removeChild(form);
          
          if (result.html) {
            // Got HTML instead of JSON
            console.error('Received HTML response');
            throw new Error('Server error. Please refresh the page and try again.');
          }
          
          if (!result.ok) {
            if (result.status === 419) {
              throw new Error('Session expired. Please refresh the page.');
            }
            throw new Error(result.data.message || 'Failed to update status');
          }
          
          if (result.data.success) {
            Swal.fire({
              title: 'Success!',
              text: result.data.message,
              icon: 'success',
              timer: 1500,
              showConfirmButton: false
            }).then(() => {
              window.location.reload();
            });
          } else {
            throw new Error(result.data.message || 'Failed to update status');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          if (form.parentNode) {
            document.body.removeChild(form);
          }
          Swal.fire({
            title: 'Error!',
            text: error.message || 'An error occurred',
            icon: 'error',
            customClass: {
              popup: 'large-swal-popup'
            }
          });
        });
      }
    });
  }
</script>
@endpush