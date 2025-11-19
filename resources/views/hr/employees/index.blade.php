@extends('layouts.macos')
@section('page_title', $page_title)

@section('content')
  <div class="employee-container">
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
                    <a href="{{ route('employees.edit', $emp) }}">
                      <img src="{{ asset('action_icon/edit.svg') }}" width="16" height="16"> Edit
                    </a>
                    <form method="POST" action="{{ route('employees.destroy', $emp) }}" class="delete-form">
                      @csrf @method('DELETE')
                      <button type="button" class="delete-btn" onclick="confirmDelete(this)">
                        <img src="{{ asset('action_icon/delete.svg') }}" width="16" height="16"> Delete
                      </button>
                    </form>
                    <a href="{{ route('employees.show', $emp) }}">
                      <img src="{{ asset('action_icon/view.svg') }}" width="16" height="16"> View
                    </a>
                    <a href="{{ route('employees.letters.index', $emp) }}">
                      <img src="{{ asset('action_icon/print.svg') }}" width="16" height="16"> Letter
                    </a>
                    <a href="{{ route('employees.digital-card.create', $emp) }}">
                      <img src="{{ asset('action_icon/pluse.svg') }}" width="16" height="16"> Add Dig. Card
                    </a>
                  @else
                    <span><img src="{{ asset('action_icon/edit.svg') }}" width="16" height="16"> Edit</span>
                    <span><img src="{{ asset('action_icon/delete.svg') }}" width="16" height="16"> Delete</span>
                    <span><img src="{{ asset('action_icon/view.svg') }}" width="16" height="16"> View</span>
                    <span><img src="{{ asset('action_icon/print.svg') }}" width="16" height="16"> Letter</span>
                    <span><img src="{{ asset('action_icon/pluse.svg') }}" width="16" height="16"> Add Dig. Card</span>
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
                  <img src="{{ asset('storage/'.$emp->photo_path) }}" alt="{{ $emp->name }}">
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
</script>
@endpush