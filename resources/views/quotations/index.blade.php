@extends('layouts.macos')
@section('page_title', 'Quotation List')

@push('head')
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
@endpush

@push('styles')
<style>
.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-draft {
    background-color: #fef3c7;
    color: #92400e;
}

.status-pending {
    background-color: #fef3c7;
    color: #92400e;
}

.status-confirmed {
    background-color: #d1fae5;
    color: #065f46;
}

.status-completed {
    background-color: #dbeafe;
    color: #1e40af;
}

.status-cancelled {
    background-color: #fee2e2;
    color: #991b1b;
}
</style>
@endpush

@section('content')
<div class="inquiry-index-container">
  <!-- JV Filter -->
  <form method="GET" action="{{ route('quotations.index') }}" class="jv-filter" id="filterForm">
    <input type="text" placeholder="Quotation No" class="filter-pill" name="quotation_no" value="{{ request('quotation_no') }}">
    <input type="text" placeholder="From : dd/mm/yyyy" class="filter-pill date-picker" name="from_date" value="{{ request('from_date') }}" autocomplete="off">
    <input type="text" placeholder="To : dd/mm/yyyy" class="filter-pill date-picker" name="to_date" value="{{ request('to_date') }}" autocomplete="off">
    <button type="submit" class="filter-search" aria-label="Search">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
        <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" />
        <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" />
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
      <input type="text" id="globalSearch" placeholder="Search here.." class="filter-pill" name="search" value="{{ request('search') }}">
      <a href="{{ route('quotations.export.csv', request()->only(['quotation_no','from_date','to_date','search'])) }}" class="pill-btn pill-success">Excel</a>
      <a href="{{ route('quotations.create') }}" class="pill-btn pill-success">+ Add</a>
    </div>
  </form>

  <!-- Grid View -->
  <div class="quotations-grid-view">
    @forelse($quotations as $quotation)
      <div class="quotation-grid-card" onclick="window.location.href='{{ route('quotations.show', $quotation->id) }}'" title="View quotation">
        <div class="quotation-grid-header">
          <h3 class="quotation-grid-title">{{ $quotation->company_name ?? 'N/A' }}</h3>
          <span class="quotation-grid-badge">{{ ucfirst($quotation->status ?? 'Draft') }}</span>
        </div>
        <p class="quotation-grid-sub">Code: {{ $quotation->unique_code ?? 'N/A' }} • Updated: {{ $quotation->updated_at ? $quotation->updated_at->format('d M, Y') : 'N/A' }}</p>
        <div class="quotation-grid-meta">
          <div class="quotation-grid-left">
            <div class="meta-row"><span class="meta-label">Mobile</span><span class="meta-value">
              @if($quotation->contact_number_1)
                @php
                  $mobile = $quotation->contact_number_1;
                  // Remove +91 prefix if present
                  $mobile = preg_replace('/^\+91/', '', $mobile);
                  echo $mobile;
                @endphp
              @else
                N/A
              @endif
            </span></div>
            <div class="meta-row"><span class="meta-label">Next</span><span class="meta-value">{{ $quotation->tentative_complete_date ? $quotation->tentative_complete_date->format('d M, Y') : '-' }}</span></div>
            <div class="meta-row">
              <span class="meta-label">Confirm</span>
              <span class="meta-value">
                @if(in_array($quotation->id, $confirmedQuotationIds ?? []))
                  <span style="color: #10b981; font-weight: 600;">✓ Yes</span>
                @else
                  <span style="color: #ef4444; font-weight: 600;">✗ No</span>
                @endif
              </span>
            </div>
          </div>
          <div class="quotation-grid-actions" onclick="event.stopPropagation()">
            <a class="quotation-grid-action-btn btn-view" href="{{ route('quotations.show', $quotation->id) }}" title="View" aria-label="View">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </a>
            <a class="quotation-grid-action-btn btn-edit" href="{{ route('quotations.edit', $quotation->id) }}" title="Edit" aria-label="Edit">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            </a>
            <a class="quotation-grid-action-btn btn-print" href="{{ route('quotations.download', $quotation->id) }}" target="_blank" title="Print" aria-label="Print">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            </a>
            @if($quotation->customer_type === 'new' && !$quotation->customer_id && $quotation->company_email && !in_array(strtolower(trim($quotation->company_email)), $existingCompanyEmails))
            <button type="button" class="quotation-grid-action-btn btn-convert" onclick="confirmConvertToCompany({{ $quotation->id }}, '{{ addslashes($quotation->company_name) }}', '{{ addslashes($quotation->company_email) }}', '{{ addslashes($quotation->company_password ?? '') }}')" title="Convert to Company" aria-label="Convert to Company">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            </button>
            @endif
          </div>
        </div>
      </div>
    @empty
      <div class="text-center py-3">No quotations found</div>
    @endforelse
  </div>

  <!-- List View -->
  <div>
    <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
      <table style="table-layout: auto; width: 100%;">
        <thead>
          <tr>
            <th style="text-align: center; width: 180px;">Action</th>
            <th style="width: 70px;">Sr.No.</th>
            <th style="width: 140px;">Code</th>
            <th style="min-width: 200px;">Company Name</th>
            <th style="width: 120px;">Mobile</th>
            <th style="width: 110px;">Update</th>
            <th style="width: 110px;">Next Update</th>
            <th style="width: 80px; text-align: center;">Confirm</th>
          </tr>
        </thead>
        <tbody>
          @forelse($quotations as $index => $quotation)
          @php
            $isConfirmed = in_array($quotation->id, $confirmedQuotationIds ?? []);
          @endphp
          <tr>
            <td style="text-align: center; vertical-align: middle;">
              <div class="action-icons">
                <a href="{{ route('quotations.show', $quotation->id) }}" title="View Quotation" aria-label="View Quotation">
                  <img class="action-icon" src="{{ asset('action_icon/view.svg') }}" alt="View">
                </a>

                <a href="{{ route('quotations.edit', $quotation->id) }}" title="Edit Quotation" aria-label="Edit Quotation">
                  <img class="action-icon" src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
                </a>

                <a href="{{ route('quotations.download', $quotation->id) }}" title="Print Quotation" aria-label="Print Quotation" target="_blank">
                  <img class="action-icon" src="{{ asset('action_icon/print.svg') }}" alt="Print">
                </a>

                @if($isConfirmed)
                  <a href="{{ route('quotations.template-list', $quotation->id) }}" title="View Template List" aria-label="View Template List">
                    <img class="action-icon" src="{{ asset('action_icon/view_temp_list.svg') }}" alt="Template List">
                  </a>
                @else
                  <a href="{{ route('quotation.follow-up', $quotation->id) }}" title="Follow Up" aria-label="Follow Up">
                    <img class="action-icon" src="{{ asset('action_icon/follow-up.svg') }}" alt="Follow Up">
                  </a>
                @endif
                
                <button type="button" onclick="confirmDelete({{ $quotation->id }})" title="Delete Quotation" aria-label="Delete Quotation" >
                  <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
                </button>

                 @if($quotation->customer_type === 'new' && !$quotation->customer_id && $quotation->company_email && !in_array(strtolower(trim($quotation->company_email)), $existingCompanyEmails))
                <button type="button" onclick="confirmConvertToCompany({{ $quotation->id }}, '{{ addslashes($quotation->company_name) }}', '{{ addslashes($quotation->company_email) }}', '{{ addslashes($quotation->company_password ?? '') }}')" title="Convert to Company" aria-label="Convert to Company">
                  <img src="{{ asset('action_icon/convert.svg') }}" alt="Convert to Company" class="action-icon">
                </button>
              @endif
              </div>
            </td>
            <td>{{ $quotations->firstItem() + $index }}</td>
            <td>{{ $quotation->unique_code ?? 'N/A' }}</td> 
            <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $quotation->company_name ?? 'N/A' }}">{{ $quotation->company_name ?? 'N/A' }}</td>
            <td>
              @if($quotation->contact_number_1)
                @php
                  $mobile = $quotation->contact_number_1;
                  // Remove +91 prefix if present
                  $mobile = preg_replace('/^\+91/', '', $mobile);
                  echo $mobile;
                @endphp
              @else
                N/A
              @endif
            </td>
            <td>{{ $quotation->updated_at ? $quotation->updated_at->format('d/m/Y') : 'N/A' }}</td>
            <td>{{ $quotation->tentative_complete_date ? $quotation->tentative_complete_date->format('d/m/Y') : 'N/A' }}</td>
            <td style="text-align: center;">
              @if($isConfirmed)
                <div style="width: 24px; height: 24px; background: #10b981; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;" title="Confirmed - ID: {{ $quotation->id }}">
                  <span style="color: white; font-size: 14px; font-weight: bold;">✓</span>
                </div>
              @else
                <div style="width: 24px; height: 24px; background: #ef4444; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;" title="Not Confirmed - ID: {{ $quotation->id }}">
                  <span style="color: white; font-size: 14px; font-weight: bold;">✗</span>
                </div>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" style="text-align: center; padding: 20px;">No quotations found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('footer_pagination')
  @if(isset($quotations) && method_exists($quotations,'links'))
  <form method="GET" class="hrp-entries-form" action="{{ route('quotations.index') }}">
    <span>Entries</span>
    @php($currentPerPage = (int) request()->get('per_page', 10))
    <select name="per_page" onchange="console.log('Selected:', this.value); console.log('Form action:', this.form.action); this.form.submit()">
      @foreach([10,25,50,100] as $size)
      <option value="{{ $size }}" {{ $currentPerPage === $size ? 'selected' : '' }}>{{ $size }}</option>
      @endforeach
    </select>
    @foreach(request()->except(['per_page','page']) as $k => $v)
    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
    @endforeach
  </form>
  {{ $quotations->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv') }}
  @endif
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Quotation List</span>
@endsection

@push('scripts')
<script>
// Check for success message with credentials
document.addEventListener('DOMContentLoaded', function() {
  @if(session('success'))
    const successMessage = "{{ session('success') }}";
    
    // Check if message contains company credentials
    if (successMessage.includes('|||COMPANY_CREATED|||')) {
      const parts = successMessage.split('|||');
      const message = parts[0];
      const companyEmail = parts[2];
      const companyPassword = parts[3];
      
      let employeeEmail = '';
      let employeePassword = '';
      let hasEmployeeCredentials = false;
      
      if (parts.length > 4 && parts[4] === 'EMPLOYEE_CREATED') {
        employeeEmail = parts[5];
        employeePassword = parts[6];
        hasEmployeeCredentials = true;
      }
      
      let credentialsHtml = `
        <div style="text-align: left; padding: 10px;">
          <p style="margin-bottom: 15px; color: #1f2937;">${message}</p>
          
          <!-- Company Credentials -->
          <div style="background: #eff6ff; border: 2px solid #3b82f6; padding: 15px; border-radius: 8px; margin-top: 15px;">
            <p style="margin: 0 0 10px 0; font-weight: 700; color: #1e40af; font-size: 15px;">🏢 Company Login Credentials</p>
            <div style="background: white; padding: 12px; border-radius: 6px; margin-top: 10px;">
              <p style="margin: 8px 0; color: #374151; font-size: 14px;">
                <strong>Email:</strong> <span style="color: #3b82f6; font-family: monospace;">${companyEmail}</span>
              </p>
              <p style="margin: 8px 0; color: #374151; font-size: 14px;">
                <strong>Password:</strong> <span style="color: #3b82f6; font-family: monospace;">${companyPassword}</span>
              </p>
            </div>
          </div>`;
      
      if (hasEmployeeCredentials) {
        credentialsHtml += `
          <!-- Employee Credentials -->
          <div style="background: #f0fdf4; border: 2px solid #10b981; padding: 15px; border-radius: 8px; margin-top: 15px;">
            <p style="margin: 0 0 10px 0; font-weight: 700; color: #065f46; font-size: 15px;">👤 Employee Login Credentials</p>
            <div style="background: white; padding: 12px; border-radius: 6px; margin-top: 10px;">
              <p style="margin: 8px 0; color: #374151; font-size: 14px;">
                <strong>Email:</strong> <span style="color: #10b981; font-family: monospace;">${employeeEmail}</span>
              </p>
              <p style="margin: 8px 0; color: #374151; font-size: 14px;">
                <strong>Password:</strong> <span style="color: #10b981; font-family: monospace;">${employeePassword}</span>
              </p>
            </div>
          </div>`;
      }
      
      credentialsHtml += `
          <p style="margin: 15px 0 0 0; color: #6b7280; font-size: 12px; text-align: center;">
            ⚠️ Please save these credentials securely. They can be used to login to the portal.
          </p>
        </div>`;
      
      Swal.fire({
        icon: 'success',
        title: 'Company Created Successfully!',
        html: credentialsHtml,
        confirmButtonColor: '#10b981',
        confirmButtonText: 'Got it!',
        width: '600px',
        customClass: {
          popup: 'perfect-swal-popup'
        }
      }).then(() => {
        // Reload page to update the convert button visibility
        window.location.reload();
      });
    } else {
      // Regular success message
      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: successMessage,
        confirmButtonColor: '#10b981',
        width: '400px',
        customClass: {
          popup: 'perfect-swal-popup'
        }
      }).then(() => {
        // Reload page to update the list
        window.location.reload();
      });
    }
  @endif
  
  @if(session('status'))
    // Show status message (from follow-up confirmation, etc.)
    Swal.fire({
      icon: 'success',
      title: 'Success!',
      text: "{{ session('status') }}",
      confirmButtonColor: '#10b981',
      width: '400px',
      timer: 2000,
      showConfirmButton: true
    });
  @endif
});

function confirmDelete(id) {
  Swal.fire({
    title: 'Delete this quotation?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel',
    width: '400px',
    customClass: {
      popup: 'perfect-swal-popup'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: 'Deleting...',
        text: 'Please wait',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });
      
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = `/GitVraj/HrPortal/quotations/${id}`;
      form.innerHTML = `
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="DELETE">
      `;
      document.body.appendChild(form);
      form.submit();
    }
  });
}

function confirmConvertToCompany(id, companyName, companyEmail, companyPassword) {
  // Build the HTML content for the confirmation
  let htmlContent = `
    <div style="text-align: left; padding: 10px;">
      <p style="margin-bottom: 15px; font-weight: 600; color: #1f2937;">This will:</p>
      <ul style="list-style: none; padding-left: 0; margin-bottom: 15px;">
        <li style="padding: 5px 0; color: #4b5563;">✓ Create a new company record</li>
        <li style="padding: 5px 0; color: #4b5563;">✓ ${companyPassword ? 'Create a user account' : 'No user account (password not provided)'}</li>
        <li style="padding: 5px 0; color: #4b5563;">✓ Link the quotation to the new company</li>
        <li style="padding: 5px 0; color: #4b5563;">✓ Change customer type from "New" to "Existing"</li>
      </ul>
      <div style="background: #f3f4f6; padding: 12px; border-radius: 8px; margin-top: 15px;">
        <p style="margin: 0 0 8px 0; font-weight: 600; color: #374151; font-size: 14px;">Company Details:</p>
        <p style="margin: 5px 0; color: #6b7280; font-size: 13px;"><strong>Email:</strong> ${companyEmail}</p>
        ${companyPassword ? `<p style="margin: 5px 0; color: #6b7280; font-size: 13px;"><strong>Password:</strong> ${companyPassword}</p>` : '<p style="margin: 5px 0; color: #ef4444; font-size: 13px;"><strong>Password:</strong> Not provided</p>'}
      </div>
    </div>
  `;
  
  Swal.fire({
    title: `Convert "${companyName}" to Company?`,
    html: htmlContent,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3b82f6',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Yes, Convert',
    cancelButtonText: 'Cancel',
    width: '500px',
    customClass: {
      popup: 'perfect-swal-popup'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      // Show loading state
      const button = event.target.closest('button');
      if (button) {
        const originalContent = button.innerHTML;
        button.innerHTML = '<span style="color: #ffa500;">Converting...</span>';
        button.disabled = true;
      }
      
      // Show loading alert
      Swal.fire({
        title: 'Converting...',
        text: 'Please wait while we create the company',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });
      
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = `/GitVraj/HrPortal/quotations/${id}/convert-to-company`;
      form.innerHTML = `
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      `;
      document.body.appendChild(form);
      form.submit();
    }
  });
}

// Auto-submit on search input
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('globalSearch');
  const filterForm = document.getElementById('filterForm');
  
  if (searchInput && filterForm) {
    let searchTimeout;
    searchInput.addEventListener('input', function() {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(() => {
        filterForm.submit();
      }, 500);
    });
  }
  
  // Auto-submit on filter changes
  const filterInputs = document.querySelectorAll('.filter-pill');
  filterInputs.forEach(input => {
    if (input.type === 'date' || input.name === 'quotation_no') {
      input.addEventListener('change', function() {
        filterForm.submit();
      });
    }
  });
  
  // Prevent form submission when clicking sortable headers
  const sortableHeaders = document.querySelectorAll('th a[href*="sort="]');
  sortableHeaders.forEach(header => {
    header.addEventListener('click', function(e) {
      e.stopPropagation();
      // Let the link work normally
    });
  });
  // View toggle persistence
  const buttons = document.querySelectorAll('.view-toggle-btn');
  const grid = document.querySelector('.quotations-grid-view');
  const list = document.querySelector('.quotations-list-view');
  function applyView(view){
    if (!grid || !list) return;
    if(view==='grid'){ grid.classList.add('active'); list.classList.remove('active'); }
    else { list.classList.add('active'); grid.classList.remove('active'); }
    buttons.forEach(b=>b.classList.toggle('active', b.getAttribute('data-view')===view));
  }
  const saved = localStorage.getItem('quotations_view') || 'list';
  applyView(saved);
  buttons.forEach(btn=>btn.addEventListener('click', function(){
    const v = this.getAttribute('data-view');
    localStorage.setItem('quotations_view', v);
    applyView(v);
  }));
});
</script>
@endpush

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
  .quotations-grid-view { display:none; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap:16px; padding:12px; }
  .quotations-grid-view.active { display:grid; }
  .quotations-list-view { display:none; padding: 0 12px 12px; }
  .quotations-list-view.active { display:block; }

  .quotation-grid-card { background:#fff; border-radius:12px; padding:16px 18px; box-shadow:0 1px 6px rgba(0,0,0,0.06); transition:transform .25s, box-shadow .25s; cursor:pointer; margin-top:4px; }
  .quotation-grid-card:hover { transform: translateY(-4px); box-shadow:0 4px 16px rgba(0,0,0,0.12); }
  .quotation-grid-header { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; margin-bottom:10px; }
  .quotation-grid-title { font-size:16px; font-weight:700; color:#0f172a; margin:0; line-height:1.2; max-width:72%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
  .quotation-grid-badge { font-size:11px; padding:4px 8px; border-radius:12px; font-weight:500; background:#eef2ff; color:#3730a3; }
  .quotation-grid-sub { font-size:12px; color:#6b7280; margin:0 0 12px; }
  .quotation-grid-meta { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; padding-top:12px; border-top:1px solid #f3f4f6; }
  .quotation-grid-left { flex:1; display:flex; flex-direction:column; gap:6px; }
  .meta-row { display:flex; gap:8px; align-items:center; }
  .meta-label { font-size:12px; color:#6b7280; min-width:56px; }
  .meta-value { font-size:13px; color:#111827; }
  .quotation-grid-actions { display:flex; gap:8px; }
  .quotation-grid-action-btn { padding:8px; border:1px solid #e5e7eb; background:#fff; border-radius:6px; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; width:32px; height:32px; }
  .quotation-grid-action-btn.btn-view { border-color:#3b82f6; background:#eff6ff; }
  .quotation-grid-action-btn.btn-view svg { color:#3b82f6; }
  .quotation-grid-action-btn.btn-view:hover { background:#3b82f6; }
  .quotation-grid-action-btn.btn-view:hover svg { color:#fff; }
  .quotation-grid-action-btn.btn-edit { border-color:#f59e0b; background:#fffbeb; }
  .quotation-grid-action-btn.btn-edit svg { color:#f59e0b; }
  .quotation-grid-action-btn.btn-edit:hover { background:#f59e0b; }
  .quotation-grid-action-btn.btn-edit:hover svg { color:#fff; }
  .quotation-grid-action-btn.btn-print { border-color:#6366f1; background:#eef2ff; }
  .quotation-grid-action-btn.btn-print svg { color:#6366f1; }
  .quotation-grid-action-btn.btn-print:hover { background:#6366f1; }
  .quotation-grid-action-btn.btn-print:hover svg { color:#fff; }
  .quotation-grid-action-btn.btn-convert { border-color:#10b981; background:#d1fae5; }
  .quotation-grid-action-btn.btn-convert svg { color:#10b981; }
  .quotation-grid-action-btn.btn-convert:hover { background:#10b981; }
  .quotation-grid-action-btn.btn-convert:hover svg { color:#fff; }
</style>
@endpush
@push('scripts')
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
