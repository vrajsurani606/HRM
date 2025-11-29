@extends('layouts.macos')
@section('page_title', 'Quotation List')

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
    <input type="text" placeholder="From : dd/mm/yyyy" class="filter-pill" name="from_date" value="{{ request('from_date') }}" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
    <input type="text" placeholder="To : dd/mm/yyyy" class="filter-pill" name="to_date" value="{{ request('to_date') }}" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
    <button type="submit" class="filter-search" aria-label="Search">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
        <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" />
        <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" />
      </svg>
    </button>

    <div class="filter-right">
      <input type="text" id="globalSearch" placeholder="Search here.." class="filter-pill" name="search" value="{{ request('search') }}">
      <a href="{{ route('quotations.export', request()->only(['quotation_no','from_date','to_date','search'])) }}" class="pill-btn pill-success">Excel</a>
      <a href="{{ route('quotations.create') }}" class="pill-btn pill-success">+ Add</a>
    </div>
  </form>

  <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
    <table style="table-layout: auto; width: 100%; min-width: 1200px;">
      <colgroup>
        <col style="width: 180px; min-width: 140px;">
        <col style="width: 70px; min-width: 70px;">
        <col style="width: 140px; min-width: 140px;">
        <col style="width: auto; min-width: 200px;">
        <col style="width: 110px; min-width: 110px;">
        <col style="width: 100px; min-width: 100px;">
        <col style="width: 110px; min-width: 110px;">
        <col style="width: 120px; min-width: 120px;">
      </colgroup>
      <thead>
        <tr>
          <th style="text-align: center;">Action</th>
          <th>Sr.No.</th>
          <th><x-sortable-header column="unique_code" title="Code" /></th>
          <th><x-sortable-header column="company_name" title="Company Name" /></th>
          <th>Mobile</th>
          <th><x-sortable-header column="updated_at" title="Update" /></th>
          <th><x-sortable-header column="tentative_complete_date" title="Next Update" /></th>
          <th>Confirm</th>
        </tr>
      </thead>
      <tbody>
        <!-- Debug Info: Showing {{ $quotations->count() }} of {{ $quotations->total() }} records (Page {{ $quotations->currentPage() }} of {{ $quotations->lastPage() }}) -->
        <!-- Per Page Debug: Requested={{ request('per_page', 'not-set') }}, Current={{ $quotations->perPage() }} -->
        @forelse($quotations as $index => $quotation)

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

              @if(in_array($quotation->id, $confirmedQuotationIds ?? []))
                <a href="{{ route('quotations.template-list', $quotation->id) }}" title="View Template List" aria-label="View Template List">
                  <img class="action-icon" src="{{ asset('action_icon/view_temp_list.svg') }}" alt="Template List">
                </a>
              @else
                <a href="{{ route('quotation.follow-up', $quotation->id) }}" title="Follow Up" aria-label="Follow Up">
                  <img class="action-icon" src="{{ asset('action_icon/follow-up.svg') }}" alt="Follow Up">
                </a>
              @endif
              <button type="button" onclick="confirmDelete({{ $quotation->id }})" title="Delete Quotation" aria-label="Delete Quotation" style="background:transparent;border:0;padding:0;line-height:0;cursor:pointer">
                <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
              </button>
               @if($quotation->customer_type === 'new' && !$quotation->customer_id && $quotation->company_email && !in_array(strtolower(trim($quotation->company_email)), $existingCompanyEmails))
                <button type="button" onclick="confirmConvertToCompany({{ $quotation->id }}, '{{ addslashes($quotation->company_name) }}')" title="Convert to Company" aria-label="Convert to Company" style="background:transparent;border:0;padding:0;line-height:0;cursor:pointer">
                  <img src="{{ asset('action_icon/convert.svg') }}" alt="Convert to Company" class="action-icon">
                </button>
              @endif
            </div>
          </td>
          <td>{{ $quotations->firstItem() + $index }}</td>
          <td>{{ $quotation->unique_code ?? 'N/A' }}</td> 
          <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $quotation->company_name ?? 'N/A' }}">{{ $quotation->company_name ?? 'N/A' }}</td>
          <td style="font-family: monospace; white-space: nowrap;">{{ $quotation->contact_number_1 ?? 'N/A' }}</td>
          <td>{{ $quotation->updated_at ? $quotation->updated_at->format('d/m/Y') : 'N/A' }}</td>
          <td>{{ $quotation->tentative_complete_date ? $quotation->tentative_complete_date->format('d/m/Y') : 'N/A' }}</td>    
          <td>
            @if(in_array($quotation->id, $confirmedQuotationIds ?? []))
              <div style="width: 20px; height: 20px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                <span style="color: white; font-size: 12px;">✓</span>
              </div>
            @else
              <div style="width: 20px; height: 20px; background: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                <span style="color: white; font-size: 12px;">✗</span>
              </div>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9" style="text-align: center; padding: 20px;">No quotations found</td>
        </tr>
        @endforelse
      </tbody>
      </tbody>
    </table>
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
function confirmDelete(id) {
  if(confirm('Are you sure you want to delete this quotation?')) {
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
}

function confirmConvertToCompany(id, companyName) {
  const message = `Convert "${companyName}" to Company?\n\nThis will:\n• Create a new company record\n• Create a user account (if email/password provided)\n• Link the quotation to the new company\n• Change customer type from "New" to "Existing"\n\nProceed?`;
  
  if(confirm(message)) {
    // Show loading state
    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    button.innerHTML = '<span style="color: #ffa500;">Converting...</span>';
    button.disabled = true;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/GitVraj/HrPortal/quotations/${id}/convert-to-company`;
    form.innerHTML = `
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
    `;
    document.body.appendChild(form);
    form.submit();
  }
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
});
</script>
@endpush
