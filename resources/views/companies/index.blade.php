@section('footer_pagination')
  @if(isset($companies) && method_exists($companies,'links'))
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
  {{ $companies->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv') }}
  @endif
@endsection

@extends('layouts.macos')
@section('page_title', 'Companies')

@section('content')
<div class="hrp-card">
  <div class="hrp-card-body">
    <form id="filterForm" method="GET" action="{{ route('companies.index') }}" class="jv-filter">
      <input type="text" name="company_name" class="filter-pill" placeholder="Company name" value="{{ request('company_name') }}">
      <input type="text" name="gst_no" class="filter-pill" placeholder="GST No." value="{{ request('gst_no') }}">
      <input type="text" name="contact_person" class="filter-pill" placeholder="Contact Person" value="{{ request('contact_person') }}">
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
        <input type="text" name="search" class="filter-pill" placeholder="Search by company, contact, email..." value="{{ request('search') }}">
        <a href="{{ route('companies.index') }}" class="pill-btn pill-secondary">Reset</a>
        <a href="{{ route('companies.export', request()->query()) }}" class="pill-btn pill-success" id="excel_btn">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
            <path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/>
            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
          </svg>
          Excel
        </a>
        <a href="{{ route('companies.create') }}" class="pill-btn pill-success">+ Add</a>
      </div>
    </form>
  </div>

  <!-- Grid View -->
  <div class="companies-grid-view">
    @forelse($companies as $company)
      <div class="company-grid-card" onclick="window.location.href='{{ route('companies.show', $company->id) }}'" title="View company">
        <div class="company-grid-header">
          <h3 class="company-grid-title">{{ $company->company_name }}</h3>
          <span class="company-grid-badge">{{ ucfirst($company->company_type ?? 'N/A') }}</span>
        </div>
        <p class="company-grid-sub">Code: {{ $company->unique_code }} • GST: {{ $company->gst_no ?? 'N/A' }}</p>
        <div class="company-grid-meta">
          <div class="company-grid-left">
            <div class="meta-row">
              <span class="meta-label">Contact</span>
              <span class="meta-value">{{ $company->contact_person_name }} {{ $company->contact_person_mobile ? '• '.$company->contact_person_mobile : '' }}</span>
            </div>
            <div class="meta-row">
              <span class="meta-label">Email</span>
              <span class="meta-value">{{ $company->company_email ?: 'N/A' }}</span>
            </div>
            <div class="meta-row">
              <span class="meta-label">City</span>
              <span class="meta-value">{{ ucfirst($company->city) }}</span>
            </div>
          </div>
          <div class="company-grid-actions" onclick="event.stopPropagation()">
            <a class="company-grid-action-btn btn-view" href="{{ route('companies.show', $company->id) }}" title="View">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
              </svg>
            </a>
            <a class="company-grid-action-btn btn-edit" href="{{ route('companies.edit', $company->id) }}" title="Edit">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
              </svg>
            </a>
            <form method="POST" action="{{ route('companies.destroy', $company->id) }}" class="delete-form" style="display:inline">
              @csrf @method('DELETE')
              <button type="button" class="company-grid-action-btn btn-delete" onclick="confirmDelete(this); event.stopPropagation();" title="Delete">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polyline points="3 6 5 6 21 6"></polyline>
                  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
              </button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <div class="text-center py-4">No companies found.</div>
    @endforelse
  </div>

  <!-- List View -->
  <div class="companies-list-view active">
    <div class="JV-datatble JV-datatble--zoom striped-surface striped-surface--full table-wrap pad-none">
      <table>
        <thead>
          <tr>
            <th>Action</th>
            <th>Serial No.</th>
            <th>Company Code</th>
            <th>Company Name</th>
            <th>GST No.</th>
            <th>Contact Person</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Type</th>
            <th>City</th>
          </tr>
        </thead>
        <tbody>
          @forelse($companies as $i => $company)
          <tr>
            <td>
              <div class="action-icons">
                <a href="{{ route('companies.show', $company->id) }}" title="View" aria-label="View">
                  <img src="{{ asset('action_icon/view.svg') }}" alt="View" class="action-icon">
                </a>
                <a href="{{ route('companies.edit', $company->id) }}" title="Edit" aria-label="Edit">
                  <img src="{{ asset('action_icon/edit.svg') }}" alt="Edit" class="action-icon">
                </a>
                <form method="POST" action="{{ route('companies.destroy', $company->id) }}" class="delete-form" style="display:inline">
                  @csrf @method('DELETE')
                  <button type="button" onclick="confirmDelete(this)" title="Delete" aria-label="Delete" style="background:transparent;border:0;padding:0;line-height:0;cursor:pointer">
                    <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete" class="action-icon">
                  </button>
                </form>
              </div>
            </td>
            <td>{{ ($companies->currentPage() - 1) * $companies->perPage() + $i + 1 }}</td>
            <td>{{ $company->unique_code }}</td>
            <td>{{ $company->company_name }}</td>
            <td>{{ $company->gst_no ?? 'N/A' }}</td>
            <td>{{ $company->contact_person_name }}</td>
            <td>{{ $company->contact_person_mobile }}</td>
            <td>{{ $company->company_email }}</td>
            <td>{{ $company->company_type }}</td>
            <td>{{ ucfirst($company->city) }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="10" class="text-center py-4">No companies found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('companies.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Company Management</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Company List</span>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Check for success message with credentials
document.addEventListener('DOMContentLoaded', function() {
  @if(session('success'))
    const successMessage = "{{ session('success') }}";
    
    // Check if message contains user credentials
    if (successMessage.includes('|||COMPANY_USER_CREATED|||') || successMessage.includes('|||EMPLOYEE_USER_CREATED|||')) {
      const parts = successMessage.split('|||');
      const message = parts[0];
      
      let companyEmail = '';
      let companyPassword = '';
      let employeeEmail = '';
      let employeePassword = '';
      let hasCompanyUser = false;
      let hasEmployeeUser = false;
      
      // Parse company user credentials
      for (let i = 0; i < parts.length; i++) {
        if (parts[i] === 'COMPANY_USER_CREATED') {
          companyEmail = parts[i + 1];
          companyPassword = parts[i + 2];
          hasCompanyUser = true;
        }
        if (parts[i] === 'EMPLOYEE_USER_CREATED') {
          employeeEmail = parts[i + 1];
          employeePassword = parts[i + 2];
          hasEmployeeUser = true;
        }
      }
      
      let credentialsHtml = `
        <div style="text-align: left; padding: 10px;">
          <p style="margin-bottom: 15px; color: #1f2937;">${message}</p>`;
      
      if (hasCompanyUser) {
        credentialsHtml += `
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
      }
      
      if (hasEmployeeUser) {
        credentialsHtml += `
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
      });
    }
  @endif
});

function confirmDelete(form) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      form.closest('form').submit();
    }
  });
}

// View toggle logic
document.addEventListener('DOMContentLoaded', function() {
  const buttons = document.querySelectorAll('.view-toggle-btn');
  const grid = document.querySelector('.companies-grid-view');
  const list = document.querySelector('.companies-list-view');
  if (!buttons.length || !grid || !list) return;

  function applyView(view) {
    if (view === 'grid') {
      grid.classList.add('active');
      list.classList.remove('active');
    } else {
      list.classList.add('active');
      grid.classList.remove('active');
    }
    buttons.forEach(b => b.classList.toggle('active', b.getAttribute('data-view') === view));
  }

  // Initialize from localStorage (default to 'list')
  const saved = localStorage.getItem('companies_view') || 'list';
  applyView(saved);

  // Bind clicks and persist
  buttons.forEach(btn => {
    btn.addEventListener('click', function() {
      const view = this.getAttribute('data-view');
      localStorage.setItem('companies_view', view);
      applyView(view);
    });
  });
});
</script>
@endpush

<style>
.pagination-wrapper {
  padding: 1rem;
  display: flex;
  justify-content: center;
}

.pagination {
  display: flex;
  gap: 0.5rem;
  list-style: none;
  padding: 0;
  margin: 0;
}

.pagination li {
  display: inline-block;
}

.pagination a, .pagination span {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 2rem;
  height: 2rem;
  border-radius: 0.25rem;
  background: #fff;
  color: #4b5563;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.2s;
}

.pagination a:hover {
  background: #f3f4f6;
}

.pagination .active span {
  background: #3b82f6;
  color: #fff;
}

.pagination .disabled span {
  opacity: 0.5;
  cursor: not-allowed;
}

/* View Toggle Buttons */
.view-toggle-group { display:flex; gap:4px; background:#f3f4f6; padding:4px; border-radius:8px; }
.view-toggle-btn { padding:8px 12px; background:transparent; border:none; border-radius:6px; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; }
.view-toggle-btn:hover { background:#e5e7eb; }
.view-toggle-btn.active { background:#fff; box-shadow:0 1px 3px rgba(0,0,0,0.1); }
.view-toggle-btn svg { color:#6b7280; }
.view-toggle-btn.active svg { color:#3b82f6; }

/* Grid View Styles */
.companies-grid-view { display:none; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap:16px; padding: 12px 12px 12px; }
.companies-grid-view.active { display:grid; }
.companies-list-view { display:none; }
.companies-list-view.active { display:block; }

.company-grid-card { background:#fff; border-radius:12px; padding:16px 18px; box-shadow:0 1px 6px rgba(0,0,0,0.06); transition:transform .25s, box-shadow .25s; cursor:pointer; margin-top:4px; box-sizing:border-box; }
.company-grid-card:hover { transform: translateY(-4px); box-shadow:0 4px 16px rgba(0,0,0,0.12); }
.company-grid-header { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; margin-bottom:10px; }
.company-grid-title { font-size:16px; font-weight:700; color:#0f172a; margin:0; line-height:1.2; max-width:72%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.company-grid-badge { font-size:11px; padding:4px 8px; border-radius:12px; font-weight:500; background:#eef2ff; color:#3730a3; }
.company-grid-sub { font-size:12px; color:#6b7280; margin:0 0 12px; }
.company-grid-meta { display:flex; align-items:flex-start; gap:12px; padding-top:12px; border-top:1px solid #f3f4f6; }
.company-grid-left { flex:1 1 auto; min-width:0; display:flex; flex-direction:column; gap:6px; }
.meta-row { display:flex; gap:8px; align-items:center; }
.meta-label { font-size:12px; color:#6b7280; min-width:56px; }
.meta-value { font-size:13px; color:#111827; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.company-grid-actions { display:flex; gap:8px; align-items:center; margin-left:auto; flex-shrink:0; }
.company-grid-action-btn { padding:8px; border:1px solid #e5e7eb; background:#fff; border-radius:6px; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; width:32px; height:32px; }
.company-grid-action-btn.btn-view { border-color:#3b82f6; background:#eff6ff; }
.company-grid-action-btn.btn-view svg { color:#3b82f6; }
.company-grid-action-btn.btn-view:hover { background:#3b82f6; }
.company-grid-action-btn.btn-view:hover svg { color:#fff; }
.company-grid-action-btn.btn-edit { border-color:#f59e0b; background:#fffbeb; }
.company-grid-action-btn.btn-edit svg { color:#f59e0b; }
.company-grid-action-btn.btn-edit:hover { background:#f59e0b; }
.company-grid-action-btn.btn-edit:hover svg { color:#fff; }
.company-grid-action-btn.btn-delete { border-color:#ef4444; background:#fef2f2; }
.company-grid-action-btn.btn-delete svg { color:#ef4444; }
.company-grid-action-btn.btn-delete:hover { background:#ef4444; }
.company-grid-action-btn.btn-delete:hover svg { color:#fff; }
</style>
@endsection
              

@push('scripts')
@endpush

@section('breadcrumb')
<a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
<span class="hrp-bc-sep">›</span>
<span class="hrp-bc-current">Companies</span>
@endsection

@section('footer_pagination')
  @include('partials.footer')
@endsection