@extends('layouts.macos')
@section('page_title', $page_title)

@section('content')
<div class="hrp-card">
  <div class="hrp-card-body">
    <form id="filterForm" method="GET" action="{{ route('hiring.index') }}" class="jv-filter">
      <select name="status" class="filter-pill" onchange="this.form.submit()">
        <option value="all_active" {{ request('status', 'all_active') == 'all_active' ? 'selected' : '' }}>All Active</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
        <option value="hold" {{ request('status') == 'hold' ? 'selected' : '' }}>On Hold</option>
        <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>Converted</option>
        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Records</option>
      </select>
      <input type="text" name="from_date" class="filter-pill date-picker" placeholder="From : dd/mm/yyyy" value="{{ request('from_date') }}" autocomplete="off">
      <input type="text" name="to_date" class="filter-pill date-picker" placeholder="To : dd/mm/yyyy" value="{{ request('to_date') }}" autocomplete="off">
      <select name="gender" class="filter-pill">
        <option value="" {{ !request('gender') ? 'selected' : '' }}>All Genders</option>
        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
        <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>Other</option>
      </select>
      <select name="experience" class="filter-pill">
        <option value="" {{ !request('experience') ? 'selected' : '' }}>All Experience</option>
        <option value="fresher" {{ request('experience') == 'fresher' ? 'selected' : '' }}>Fresher</option>
        <option value=">0" {{ request('experience') == '>0' ? 'selected' : '' }}>0+</option>
        <option value=">1" {{ request('experience') == '>1' ? 'selected' : '' }}>1+</option>
        <option value=">2" {{ request('experience') == '>2' ? 'selected' : '' }}>2+</option>
        <option value=">3" {{ request('experience') == '>3' ? 'selected' : '' }}>3+</option>
      </select>
      <button type="submit" class="filter-search" aria-label="Search">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
        </svg>
      </button>
      <div class="filter-right">
        <div class="view-toggle-group" style="margin-right:8px;">
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
        <input type="text" name="search" class="filter-pill" placeholder="Search by name, mobile, code..." value="{{ request('search') }}">
        <a href="{{ route('hiring.index') }}" class="pill-btn pill-secondary">Reset</a>
        @can('Leads Management.create lead')
          <a href="{{ route('hiring.create') }}" class="pill-btn pill-success">+ Add</a>
        @endcan
      </div>
    </form>
  </div>
  <!-- Grid View -->
  <div class="hiring-grid-view">
    @forelse($leads as $lead)
      @php($initial = strtoupper(mb_substr((string)($lead->person_name ?? 'U'), 0, 1)))
      <div class="hiring-grid-card" onclick="window.location.href='{{ route('hiring.edit', $lead) }}'" title="Edit lead">
        <div class="hiring-grid-header">
          <div class="hiring-grid-id">
            <div class="hiring-avatar">{{ $initial }}</div>
            <div class="hiring-name-role">
              <h3 class="hiring-grid-title">{{ $lead->person_name }}</h3>
              <div class="hiring-role">{{ $lead->position ?? '-' }}</div>
            </div>
          </div>
          <div class="hiring-chips">
            @php($leadStatus = $lead->status ?? 'pending')
            <span class="chip chip-status-{{ $leadStatus }}">{{ ucfirst($leadStatus) }}</span>
            <span class="chip chip-{{ $lead->is_experience ? 'exp' : 'fresh' }}">{{ $lead->is_experience ? (($lead->experience_count ?? 0).' yrs') : 'Fresher' }}</span>
            <span class="chip chip-gender">{{ ucfirst($lead->gender ?? '-') }}</span>
          </div>
        </div>
        <p class="hiring-grid-sub">Code: {{ $lead->unique_code }} • Mobile: {{ display_mobile($lead->mobile_no) ?? '-' }}</p>
        <div class="hiring-grid-meta">
          <div class="hiring-grid-left">
            @if($lead->address)
            <div class="meta-row"><span class="meta-label">Address</span><span class="meta-value">{{ Str::limit($lead->address, 40) }}</span></div>
            @endif
          </div>
          <div class="hiring-grid-actions" onclick="event.stopPropagation()">
            @can('Leads Management.edit lead')
              {{-- Approve - show for pending/hold/rejected (not converted/accepted) --}}
              @if(!in_array($leadStatus, ['converted', 'accepted']))
                <img src="{{ asset('action_icon/approve.svg') }}" alt="Approve" class="action-icon-btn" onclick="acceptLead({{ $lead->id }}, '{{ addslashes($lead->person_name) }}')" title="Approve">
              @endif
              {{-- Reject - show for pending/hold/accepted (not converted/rejected) --}}
              @if(!in_array($leadStatus, ['converted', 'rejected']))
                <img src="{{ asset('action_icon/reject.svg') }}" alt="Reject" class="action-icon-btn" onclick="rejectLead({{ $lead->id }}, '{{ addslashes($lead->person_name) }}')" title="Reject">
              @endif
              {{-- Hold - show for pending/accepted/rejected (not converted/hold) --}}
              @if(!in_array($leadStatus, ['converted', 'hold']))
                <img src="{{ asset('action_icon/hold.svg') }}" alt="Hold" class="action-icon-btn" onclick="holdLead({{ $lead->id }}, '{{ addslashes($lead->person_name) }}')" title="Hold" onerror="this.style.display='none'">
              @endif
              {{-- Edit - always show --}}
              <a href="{{ route('hiring.edit', $lead) }}" title="Edit" aria-label="Edit">
                <img src="{{ asset('action_icon/edit.svg') }}" alt="Edit" class="action-icon-btn">
              </a>
            @endcan
            {{-- Delete - always show --}}
            @can('Leads Management.delete lead')
              <form method="POST" action="{{ route('hiring.destroy', $lead) }}" class="delete-form" style="display:inline">
                @csrf @method('DELETE')
                <button type="button" onclick="confirmDeleteLead(this); event.stopPropagation();" title="Delete" aria-label="Delete" style="background:transparent;border:0;padding:0;cursor:pointer;">
                  <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete" class="action-icon-btn">
                </button>
              </form>
            @endcan
            {{-- Convert & Print - only for accepted status --}}
            @if($leadStatus === 'accepted')
              @can('Leads Management.convert lead')
                <a href="javascript:void(0)" 
                   class="convert-btn" 
                   data-no-loader
                   data-id="{{ $lead->id }}"
                   data-url="{{ route('hiring.convert', $lead->id) }}"
                   data-name="{{ $lead->person_name }}"
                   title="Convert to Employee">
                  <img src="{{ asset('action_icon/convert.svg') }}" alt="Convert" class="action-icon-btn">
                </a>
              @endcan
              @can('Leads Management.print lead')
                <a href="{{ route('hiring.print', ['id' => $lead->id, 'type' => 'offerletter']) }}" target="_blank" title="Print Offer Letter">
                  <img src="{{ asset('action_icon/print.svg') }}" alt="Print" class="action-icon-btn">
                </a>
              @endcan
            @endif
          </div>
        </div>
      </div>
    @empty
      <x-empty-state-grid 
          title="No hiring records found" 
          message="Try adjusting your filters or create a new hiring record"
      />
    @endforelse
  </div>

  <!-- List View -->
  <div class="hiring-list-view active">
    <div class="JV-datatble JV-datatble--zoom striped-surface striped-surface--full table-wrap pad-none">
      <table>
        <thead>
          <tr>
            <th>Action</th>
            <th>Status</th>
            <th>Sr.</th>
            <th>Code</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Position</th>
            <th>Experience</th>
            <th>Gender</th>
            <th>Resume</th>
          </tr>
        </thead>
        <tbody>
          @forelse($leads as $i => $lead)
          @php($leadStatus = $lead->status ?? 'pending')
          <tr>
            <td>
              <div class="action-icons">
                @can('Leads Management.edit lead')
                  {{-- Approve - show for pending/hold/rejected (not converted/accepted) --}}
                  @if(!in_array($leadStatus, ['converted', 'accepted']))
                    <img src="{{ asset('action_icon/approve.svg') }}" alt="Approve" class="action-icon" style="cursor:pointer;" onclick="acceptLead({{ $lead->id }}, '{{ addslashes($lead->person_name) }}')" title="Approve">
                  @endif
                  {{-- Reject - show for pending/hold/accepted (not converted/rejected) --}}
                  @if(!in_array($leadStatus, ['converted', 'rejected']))
                    <img src="{{ asset('action_icon/reject.svg') }}" alt="Reject" class="action-icon" style="cursor:pointer;" onclick="rejectLead({{ $lead->id }}, '{{ addslashes($lead->person_name) }}')" title="Reject">
                  @endif
                  {{-- Hold - show for pending/accepted/rejected (not converted/hold) --}}
                  @if(!in_array($leadStatus, ['converted', 'hold']))
                    <img src="{{ asset('action_icon/hold.svg') }}" alt="Hold" class="action-icon" style="cursor:pointer;" onclick="holdLead({{ $lead->id }}, '{{ addslashes($lead->person_name) }}')" title="Hold" onerror="this.style.display='none'">
                  @endif
                  {{-- Edit - always show --}}
                  <a href="{{ route('hiring.edit', $lead) }}" title="Edit" aria-label="Edit">
                    <img src="{{ asset('action_icon/edit.svg') }}" alt="Edit" class="action-icon">
                  </a>
                @endcan
                {{-- Delete - always show --}}
                @can('Leads Management.delete lead')
                  <form method="POST" action="{{ route('hiring.destroy', $lead) }}" class="delete-form" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="button" onclick="confirmDeleteLead(this)" title="Delete" aria-label="Delete" style="background:transparent;border:0;padding:0;line-height:0;cursor:pointer">
                      <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete" class="action-icon">
                    </button>
                  </form>
                @endcan
                {{-- Convert & Print - only for accepted status --}}
                @if($leadStatus === 'accepted')
                  @can('Leads Management.convert lead')
                    <a href="javascript:void(0)"
                          class="convert-btn"
                          data-no-loader
                          data-id="{{ $lead->id }}"
                          data-url="{{ route('hiring.convert', $lead->id) }}"
                          data-name="{{ $lead->person_name }}"
                          title="Convert to Employee">
                            <img src="{{ asset('action_icon/convert.svg') }}" class="action-icon">
                      </a>
                  @endcan
                  @can('Leads Management.print lead')
                    <a href="{{ route('hiring.print', ['id' => $lead->id, 'type' => 'offerletter']) }}" title="Print Offer Letter" target="_blank" aria-label="Print Offer Letter">
                      <img src="{{ asset('action_icon/print.svg') }}" alt="Print Offer Letter" class="action-icon">
                    </a>
                  @endcan
                @endif
              </div>
            </td>
            <td>
              <span class="status-badge status-{{ $leadStatus }}">
                {{ ucfirst($leadStatus) }}
              </span>
              @if($leadStatus === 'rejected' && $lead->reject_reason)
                <button type="button" class="reason-tooltip" onclick="showRejectReason('{{ addslashes($lead->reject_reason) }}')" title="View Reason">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                </button>
              @endif
            </td>
            <td>{{ ($leads->currentPage()-1) * $leads->perPage() + $i + 1 }}</td>
            <td><span style="font-weight:600;color:#3b82f6;">{{ $lead->unique_code }}</span></td>
            <td><span style="font-weight:600;">{{ $lead->person_name }}</span></td>
            <td>{{ display_mobile($lead->mobile_no) }}</td>
            <td>{{ $lead->position }}</td>
            <td>
              @if($lead->is_experience)
              <span style="display:inline-flex;align-items:center;gap:4px;background:#dcfce7;color:#166534;font-weight:600;font-size:12px;padding:4px 10px;border-radius:9999px;">
                {{ $lead->experience_count ?? 0 }} yrs
              </span>
              @else
              <span style="display:inline-flex;align-items:center;gap:4px;background:#f3f4f6;color:#6b7280;font-weight:600;font-size:12px;padding:4px 10px;border-radius:9999px;">
                Fresher
              </span>
              @endif
            </td>
            <td class="capitalize">{{ ucfirst($lead->gender) }}</td>
            <td>
              @if($lead->resume_path)
                @can('Leads Management.view resume')
                  <a class="hrp-link" href="{{ route('hiring.resume', $lead->id) }}" target="_blank">View</a>
                @else
                  <span style="color:#9ca3af;">—</span>
                @endcan
              @else
                —
              @endif
            </td>
          </tr>
          @empty
            <x-empty-state 
                colspan="10" 
                title="No hiring records found" 
                message="Try adjusting your filters or create a new hiring record"
            />
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  const csrf = '{{ csrf_token() }}';
  const baseUrl = '{{ url('/') }}';

  // SweetAlert delete confirmation for hiring leads
  function confirmDeleteLead(button) {
    Swal.fire({
      title: 'Delete this lead?',
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
        popup: 'perfect-swal-popup'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        button.closest('form').submit();
      }
    });
  }

  // Accept Lead
  function acceptLead(leadId, name) {
    Swal.fire({
      title: `Accept ${name}?`,
      text: "This will mark the lead as accepted and redirect to create offer letter.",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#10b981',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Yes, Accept!',
      cancelButtonText: 'Cancel',
      width: '400px',
      customClass: { popup: 'perfect-swal-popup' }
    }).then((result) => {
      if (result.isConfirmed) {
        fetch(`${baseUrl}/hiring/${leadId}/accept`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': csrf,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          }
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            Swal.fire('Accepted!', data.message, 'success').then(() => {
              if (data.redirect) {
                window.location.href = data.redirect;
              } else {
                location.reload();
              }
            });
          } else {
            Swal.fire('Error!', data.message, 'error');
          }
        })
        .catch(() => Swal.fire('Error!', 'Something went wrong', 'error'));
      }
    });
  }

  // Reject Lead with reason
  function rejectLead(leadId, name) {
    Swal.fire({
      title: `Reject ${name}?`,
      html: `
        <div style="text-align: left; margin: 20px 0;">
          <label class="hrp-label">Rejection Reason:</label>
          <textarea id="reject-reason" class="hrp-input Rectangle-29" rows="4" 
                    placeholder="Enter reason for rejection (required for HR records)" 
                    style="color: #000; resize: vertical;"></textarea>
        </div>
      `,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Reject',
      cancelButtonText: 'Cancel',
      width: '450px',
      customClass: { popup: 'perfect-swal-popup' },
      preConfirm: () => {
        const reason = document.getElementById('reject-reason').value.trim();
        if (!reason) {
          Swal.showValidationMessage('Please enter rejection reason');
          return false;
        }
        return { reject_reason: reason };
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const formData = new FormData();
        formData.append('reject_reason', result.value.reject_reason);
        formData.append('_token', csrf);

        fetch(`${baseUrl}/hiring/${leadId}/reject`, {
          method: 'POST',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          },
          body: formData
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            Swal.fire('Rejected!', data.message, 'success').then(() => location.reload());
          } else {
            Swal.fire('Error!', data.message, 'error');
          }
        })
        .catch(() => Swal.fire('Error!', 'Something went wrong', 'error'));
      }
    });
  }

  // Hold Lead
  function holdLead(leadId, name) {
    Swal.fire({
      title: `Put ${name} on Hold?`,
      text: "This lead will be marked as on hold.",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#f59e0b',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Yes, Hold!',
      cancelButtonText: 'Cancel',
      width: '400px',
      customClass: { popup: 'perfect-swal-popup' }
    }).then((result) => {
      if (result.isConfirmed) {
        fetch(`${baseUrl}/hiring/${leadId}/hold`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': csrf,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          }
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            Swal.fire('On Hold!', data.message, 'success').then(() => location.reload());
          } else {
            Swal.fire('Error!', data.message, 'error');
          }
        })
        .catch(() => Swal.fire('Error!', 'Something went wrong', 'error'));
      }
    });
  }

  // Show reject reason popup
  function showRejectReason(reason) {
    Swal.fire({
      title: 'Rejection Reason',
      text: reason,
      icon: 'info',
      confirmButtonColor: '#3b82f6',
      width: '400px',
      customClass: { popup: 'perfect-swal-popup' }
    });
  }

document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.convert-btn').forEach(function(btn) {

        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Hide global page loader if it was triggered
            if (window.hidePageLoader) {
                window.hidePageLoader();
            }

            const leadId = this.dataset.id;
            const name = this.dataset.name || 'this lead';
            const routeUrl = this.dataset.url;

            // Show popup immediately without waiting for fetch
            Swal.fire({
                title: `Convert ${name} to Employee`,
                html: `
                    <div style="text-align: left; margin: 20px 0;">
                        <label class="hrp-label">Email:</label>
                        <input type="email" id="convert-email" class="hrp-input Rectangle-29"
                               placeholder="Enter email" style="margin-bottom: 15px; color: #000;">

                        <label class="hrp-label">Password:</label>
                        <div class="password-wrapper">
                            <input type="password" id="convert-password" class="hrp-input Rectangle-29"
                                   placeholder="Enter password" style="color: #000;">
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Convert & Create Login',
                cancelButtonText: 'Cancel',
                width: '450px',
                customClass: { popup: 'perfect-swal-popup' },
                didOpen: () => {
                    // Fetch suggested email in background after popup opens
                    fetch(routeUrl, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        const emailInput = document.getElementById('convert-email');
                        if (emailInput && data.suggested_email && !emailInput.value) {
                            emailInput.value = data.suggested_email;
                        }
                    })
                    .catch(() => {});
                },
                preConfirm: () => {
                    const email = document.getElementById('convert-email').value.trim();
                    const password = document.getElementById('convert-password').value.trim();

                    if (!email || !password) {
                        Swal.showValidationMessage('Please fill all fields');
                        return false;
                    }

                    if (password.length < 6) {
                        Swal.showValidationMessage('Password must be at least 6 characters');
                        return false;
                    }

                    return { email, password };
                }
            })
            .then(result => {
                if (!result.isConfirmed) return;

                // Submit conversion (POST request)
                const formData = new FormData();
                formData.append('email', result.value.email);
                formData.append('password', result.value.password);
                formData.append('_token', csrf);
                
                fetch(routeUrl, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(res => {
                    if (!res.ok) {
                        return res.text().then(text => {
                            throw new Error(`HTTP ${res.status}: ${text}`);
                        });
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success!', data.message, 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error!', data.message || 'Conversion failed', 'error');
                    }
                })
                .catch(error => {
                    console.error('Conversion error:', error);
                    Swal.fire('Error!', error.message || 'Something went wrong', 'error');
                });
            });
        });

    });
});

// Toggle view
document.addEventListener('DOMContentLoaded', function() {
  const viewToggleBtns = document.querySelectorAll('.view-toggle-btn');
  const hiringGridView = document.querySelector('.hiring-grid-view');
  const hiringListView = document.querySelector('.hiring-list-view');

  viewToggleBtns.forEach((btn) => {
    btn.addEventListener('click', function() {
      const view = this.dataset.view;
      localStorage.setItem('hiringLeadView', view);

      if (view === 'grid') {
        hiringGridView.classList.add('active');
        hiringListView.classList.remove('active');
        this.classList.add('active');
        document.querySelector('.view-toggle-btn[data-view="list"]').classList.remove('active');
      } else {
        hiringGridView.classList.remove('active');
        hiringListView.classList.add('active');
        this.classList.add('active');
        document.querySelector('.view-toggle-btn[data-view="grid"]').classList.remove('active');
      }
    });
  });

  const storedView = localStorage.getItem('hiringLeadView');
  if (storedView === 'grid') {
    hiringGridView.classList.add('active');
    hiringListView.classList.remove('active');
    document.querySelector('.view-toggle-btn[data-view="grid"]').classList.add('active');
  } else {
    hiringGridView.classList.remove('active');
    hiringListView.classList.add('active');
    document.querySelector('.view-toggle-btn[data-view="list"]').classList.add('active');
  }
});
</script>

@push('styles')
<style>
  /* Toggle */
  .view-toggle-group { display:flex; gap:4px; background:#f3f4f6; padding:4px; border-radius:8px; }
  .view-toggle-btn { padding:8px 12px; background:transparent; border:none; border-radius:6px; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; }
  .view-toggle-btn:hover { background:#e5e7eb; }
  .view-toggle-btn.active { background:#fff; box-shadow:0 1px 3px rgba(0,0,0,0.1); }
  .view-toggle-btn svg { color:#6b7280; }
  .view-toggle-btn.active svg { color:#3b82f6; }

  /* Grid */
  .hiring-grid-view { display:none; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap:16px; padding:12px; }
  .hiring-grid-view.active { display:grid; }
  .hiring-list-view { display:none; }
  .hiring-list-view.active { display:block; }

  .hiring-grid-card { background:#fff; border-radius:12px; padding:16px 18px; box-shadow:0 1px 6px rgba(0,0,0,0.06); transition:transform .25s, box-shadow .25s; cursor:pointer; margin-top:4px; }
  .hiring-grid-card:hover { transform: translateY(-4px); box-shadow:0 4px 16px rgba(0,0,0,0.12); }
  .hiring-grid-header { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:10px; }
  .hiring-grid-id { display:flex; align-items:center; gap:12px; min-width:0; }
  .hiring-avatar { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-weight:700; color:#fff; background:linear-gradient(135deg,#3b82f6,#9333ea); }
  .hiring-name-role { min-width:0; }
  .hiring-grid-title { font-size:16px; font-weight:700; color:#0f172a; margin:0; line-height:1.2; max-width:260px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
  .hiring-role { font-size:12px; color:#6b7280; }
  .hiring-chips { display:flex; gap:6px; flex-wrap:wrap; justify-content:flex-end; }
  .chip { font-size:11px; padding:4px 8px; border-radius:9999px; font-weight:600; border:1px solid #e5e7eb; background:#fff; color:#374151; }
  .chip-exp { background:#dcfce7; border-color:#bbf7d0; color:#166534; }
  .chip-fresh { background:#f3f4f6; border-color:#e5e7eb; color:#374151; }
  .chip-gender { background:#e0e7ff; border-color:#c7d2fe; color:#3730a3; }
  .hiring-grid-sub { font-size:12px; color:#6b7280; margin:0 0 12px; }
  .hiring-grid-meta { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; padding-top:12px; border-top:1px solid #f3f4f6; }
  .hiring-grid-left { flex:1; display:flex; flex-direction:column; gap:6px; }
  .meta-row { display:flex; gap:8px; align-items:center; }
  .meta-label { font-size:12px; color:#6b7280; min-width:56px; }
  .meta-value { font-size:13px; color:#111827; }
  .hiring-grid-actions { display:flex; gap:8px; }
  .hiring-grid-action-btn { padding:8px; border:1px solid #e5e7eb; background:#fff; border-radius:6px; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; width:32px; height:32px; }
  .hiring-grid-action-btn.btn-edit { border-color:#f59e0b; background:#fffbeb; }
  .hiring-grid-action-btn.btn-edit svg { color:#f59e0b; }
  .hiring-grid-action-btn.btn-edit:hover { background:#f59e0b; }
  .hiring-grid-action-btn.btn-edit:hover svg { color:#fff; }
  .hiring-grid-action-btn.btn-print { border-color:#6366f1; background:#eef2ff; }
  .hiring-grid-action-btn.btn-print svg { color:#6366f1; }
  .hiring-grid-action-btn.btn-print:hover { background:#6366f1; }
  .hiring-grid-action-btn.btn-print:hover svg { color:#fff; }
  .hiring-grid-action-btn.btn-delete { border-color:#ef4444; background:#fef2f2; }
  .hiring-grid-action-btn.btn-delete svg { color:#ef4444; }
  .hiring-grid-action-btn.btn-delete:hover { background:#ef4444; }
  .hiring-grid-action-btn.btn-delete:hover svg { color:#fff; }
  .hiring-grid-action-btn.btn-convert { border-color:#10b981; background:#ecfdf5; }
  .hiring-grid-action-btn.btn-convert svg { color:#10b981; }
  .hiring-grid-action-btn.btn-convert:hover { background:#10b981; }
  .hiring-grid-action-btn.btn-convert:hover svg { color:#fff; }

  /* Accept/Reject/Hold buttons */
  .hiring-grid-action-btn.btn-accept { border-color:#10b981; background:#ecfdf5; }
  .hiring-grid-action-btn.btn-accept svg { color:#10b981; }
  .hiring-grid-action-btn.btn-accept:hover { background:#10b981; }
  .hiring-grid-action-btn.btn-accept:hover svg { color:#fff; }
  
  .hiring-grid-action-btn.btn-reject { border-color:#ef4444; background:#fef2f2; }
  .hiring-grid-action-btn.btn-reject svg { color:#ef4444; }
  .hiring-grid-action-btn.btn-reject:hover { background:#ef4444; }
  .hiring-grid-action-btn.btn-reject:hover svg { color:#fff; }
  
  .hiring-grid-action-btn.btn-hold { border-color:#f59e0b; background:#fffbeb; }
  .hiring-grid-action-btn.btn-hold svg { color:#f59e0b; }
  .hiring-grid-action-btn.btn-hold:hover { background:#f59e0b; }
  .hiring-grid-action-btn.btn-hold:hover svg { color:#fff; }

  /* Status chips for grid */
  .chip-status-pending { background:#fef3c7; border-color:#fcd34d; color:#92400e; }
  .chip-status-accepted { background:#dcfce7; border-color:#86efac; color:#166534; }
  .chip-status-rejected { background:#fee2e2; border-color:#fca5a5; color:#991b1b; }
  .chip-status-hold { background:#fef3c7; border-color:#fcd34d; color:#92400e; }
  .chip-status-converted { background:#dbeafe; border-color:#93c5fd; color:#1e40af; }

  /* Status badges for list */
  .status-badge { display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:9999px; font-size:12px; font-weight:600; }
  .status-pending { background:#fef3c7; color:#92400e; }
  .status-accepted { background:#dcfce7; color:#166534; }
  .status-rejected { background:#fee2e2; color:#991b1b; }
  .status-hold { background:#fef3c7; color:#92400e; }
  .status-converted { background:#dbeafe; color:#1e40af; }

  /* Small action buttons for list view */
  .action-btn-small { padding:4px; border:1px solid #e5e7eb; background:#fff; border-radius:4px; cursor:pointer; transition:all .2s; display:inline-flex; align-items:center; justify-content:center; width:24px; height:24px; }
  .btn-accept-small { border-color:#10b981; background:#ecfdf5; }
  .btn-accept-small svg { color:#10b981; }
  .btn-accept-small:hover { background:#10b981; }
  .btn-accept-small:hover svg { color:#fff; }
  .btn-reject-small { border-color:#ef4444; background:#fef2f2; }
  .btn-reject-small svg { color:#ef4444; }
  .btn-reject-small:hover { background:#ef4444; }
  .btn-reject-small:hover svg { color:#fff; }
  .btn-hold-small { border-color:#f59e0b; background:#fffbeb; }
  .btn-hold-small svg { color:#f59e0b; }
  .btn-hold-small:hover { background:#f59e0b; }
  .btn-hold-small:hover svg { color:#fff; }

  /* Reason tooltip button */
  .reason-tooltip { background:transparent; border:none; cursor:pointer; padding:2px; margin-left:4px; vertical-align:middle; }
  .reason-tooltip svg { color:#6b7280; }
  .reason-tooltip:hover svg { color:#3b82f6; }

  /* Action icon buttons (like leave approval) */
  .action-icon-btn { width:20px; height:20px; cursor:pointer; transition:transform .2s, opacity .2s; }
  .action-icon-btn:hover { transform:scale(1.1); opacity:0.8; }
  .hiring-grid-actions { display:flex; gap:10px; align-items:center; }
  .hiring-grid-actions a { display:inline-flex; }

  /* Fix orphaned CSS line and ensure swal styles remain intact */
  /* List table alignments */
  .JV-datatble table td { vertical-align: middle; }
  .action-icons { display: inline-flex; align-items: center; gap: 8px; }
  .action-icons form { margin: 0; padding: 0; display: inline-flex; }
  .action-icons button { display: inline-flex; align-items: center; justify-content: center; padding: 0; margin: 0; line-height: 1; background: transparent; border: 0; cursor: pointer; }
  .action-icons img.action-icon { display: block; }
  .perfect-swal-popup { font-size: 15px !important; }
  .perfect-swal-popup .swal2-title { font-size: 20px !important; font-weight: 600 !important; margin-bottom: 1rem !important; }
  .perfect-swal-popup .swal2-content { font-size: 15px !important; margin-bottom: 1.5rem !important; line-height: 1.4 !important; }
  .perfect-swal-popup .swal2-actions { gap: 0.75rem !important; margin-top: 1rem !important; }
  .perfect-swal-popup .swal2-confirm, .perfect-swal-popup .swal2-cancel { font-size: 14px !important; padding: 8px 16px !important; border-radius: 6px !important; }
  .perfect-swal-popup .swal2-icon { margin: 0.5rem auto 1rem !important; }
  .perfect-swal-popup .hrp-label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    color: #000 !important;
  }

  .perfect-swal-popup .Rectangle-29 {
    width: 100% !important;
    padding: 12px 16px !important;
    border: 1px solid #d1d5db !important;
    border-radius: 8px !important;
    font-size: 14px !important;
    color: #000 !important;
    background: #fff !important;
    margin: 0 !important;
  }

  .perfect-swal-popup .Rectangle-29:focus {
    outline: none !important;
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
  }

  .perfect-swal-popup .Rectangle-29::placeholder {
    color: #6b7280 !important;
  }
</style>
@endpush

@section('breadcrumb')
<a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
<span class="hrp-bc-sep">›</span>
<a href="{{ route('hiring.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">HRM</a>
<span class="hrp-bc-sep">›</span>
<span class="hrp-bc-current">Hiring Lead Master</span>
@endsection

@section('footer_pagination')
@if(isset($leads) && method_exists($leads,'links'))
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
{{ $leads->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv') }}
@endif
@endsection@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
// Initialize jQuery datepicker
$(document).ready(function() {
    $('.date-picker').datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '-10:+10',
        showButtonPanel: true,
        beforeShow: function(input, inst) {
            setTimeout(function() {
                inst.dpDiv.css({ marginTop: '2px', marginLeft: '0px' });
            }, 0);
        }
    });
});

// Convert dates before form submission
document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('.jv-filter, #filterForm');
    if(form){
        form.addEventListener('submit', function(e){
            var dateInputs = form.querySelectorAll('.date-picker');
            dateInputs.forEach(function(input){
                if(input.value){
                    var parts = input.value.split('/');
                    if(parts.length === 3) input.value = parts[2] + '-' + parts[1] + '-' + parts[0];
                }
            });
        });
    }
});
</script>
@endpush
