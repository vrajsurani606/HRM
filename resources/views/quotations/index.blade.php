@extends('layouts.macos')
@section('page_title', 'Quotation List')
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
      <a href="{{ route('quotations.export') }}" class="pill-btn pill-success">Excel</a>
      <a href="{{ route('quotations.create') }}" class="pill-btn pill-success">+ Add</a>
    </div>
  </form>

  <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
    <table>
      <thead>
        <tr>
          <th>Action</th>
          <th>Serial No.</th>
          <th>Code</th>
          <th>Comp. Name</th>
          <th>Mo.No.</th>
          <th>Update</th>
          <th>Next Update</th>
          <th>Remark</th>
          <th>Is Confirm</th>
        </tr>
      </thead>
      <tbody>
        @forelse($quotations as $index => $quotation)
        <tr>
          <td>
             {{-- <a href="{{ route('quotations.print', $quotation->id) }}" title="Print Quotation" aria-label="Print Quotation">
              <img src="{{ asset('action_icon/print.svg') }}" alt="Print" class="action-icon">
            </a> --}}
            <a href="{{ route('quotations.edit', $quotation->id) }}" title="Edit" aria-label="Edit">
              <img src="{{ asset('action_icon/edit.svg') }}" alt="Edit" class="action-icon">
            </a>
            <a href="{{ route('quotations.download', $quotation->id) }}" title="Print Quotation" target="_blank">
              <img src="{{ asset('action_icon/print.svg') }}" alt="Print" class="action-icon">
            </a>
            
            @if(in_array($quotation->id, $confirmedQuotationIds ?? []))
              <a href="{{ route('quotations.template-list', $quotation->id) }}" title="View Template List" aria-label="View Template List">
                <img src="{{ asset('action_icon/temp_list_icon.svg') }}" alt="Template List" class="action-icon">
              </a>
            @else
              <a href="{{ route('quotation.follow-up', $quotation->id) }}" title="Follow Up" aria-label="Follow Up">
                <img src="{{ asset('action_icon/followup.svg') }}" alt="Follow Up" class="action-icon" style="width:20px;height:20px;">
              </a>
            @endif
            
            <button type="button" onclick="confirmDelete({{ $quotation->id }})" title="Delete" aria-label="Delete" style="background:transparent;border:0;padding:0;line-height:0;cursor:pointer">
              <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete" class="action-icon">
            </button>
            <a href="#" title="Create Company" target="_blank">
              <img src="{{ asset('action_icon/create_company.svg') }}" alt="Create Company" class="action-icon">
            </a>
          </td>
          <td>{{ $quotations->firstItem() + $index }}</td>
          <td>{{ $quotation->unique_code ?? 'N/A' }}</td> 
          <td>{{ Str::limit($quotation->company_name ?? 'N/A', 30) }}</td>
          <td>{{ $quotation->contact_number_1 ?? 'N/A' }}</td>
          <td>{{ $quotation->updated_at ? $quotation->updated_at->format('d/m/Y') : 'N/A' }}</td>
          <td>{{ $quotation->tentative_complete_date ? $quotation->tentative_complete_date->format('d/m/Y') : 'N/A' }}</td>
          <td>{{ ucfirst($quotation->status ?? 'Draft') }}</td>
          <td>
            <div style="width: 20px; height: 20px; background: {{ $quotation->status === 'confirmed' ? '#10b981' : '#10b981' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
              <span style="color: white; font-size: 12px;">✓</span>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9" style="text-align: center; padding: 20px;">No quotations found</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('footer_pagination')
  @if(isset($quotations) && method_exists($quotations,'links'))
  <form method="GET" class="hrp-entries-form">
    <span>Entries</span>
    @php($currentPerPage = (int) request()->get('per_page', 25))
    <select name="per_page" onchange="this.form.submit()">
      @foreach([10,25,50,100] as $size)
      <option value="{{ $size }}" {{ $currentPerPage === $size ? 'selected' : '' }}>{{ $size }}</option>
      @endforeach
    </select>
    @foreach(request()->except(['per_page','page']) as $k => $v)
    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
    @endforeach
  </form>
  <div class="pagination-info">
    <span>{{ $quotations->firstItem() ?? 0 }} - {{ $quotations->lastItem() ?? 0 }} of {{ $quotations->total() ?? 0 }}</span>
  </div>
  <div class="pagination-controls">
    @if($quotations->onFirstPage())
      <span class="page-btn disabled">01</span>
    @else
      <a href="{{ $quotations->url(1) }}" class="page-btn">01</a>
    @endif
    
    @if($quotations->currentPage() > 2)
      <a href="{{ $quotations->previousPageUrl() }}" class="page-btn">{{ str_pad($quotations->currentPage() - 1, 2, '0', STR_PAD_LEFT) }}</a>
    @endif
    
    @if($quotations->currentPage() > 1 && $quotations->hasMorePages())
      <span class="page-btn active">{{ str_pad($quotations->currentPage(), 2, '0', STR_PAD_LEFT) }}</span>
    @endif
    
    @if($quotations->hasMorePages())
      <a href="{{ $quotations->nextPageUrl() }}" class="page-btn">{{ str_pad($quotations->currentPage() + 1, 2, '0', STR_PAD_LEFT) }}</a>
    @endif
    
    @if($quotations->currentPage() < $quotations->lastPage() - 1)
      <span class="page-dots">...</span>
      <a href="{{ $quotations->url($quotations->lastPage()) }}" class="page-btn">{{ str_pad($quotations->lastPage(), 2, '0', STR_PAD_LEFT) }}</a>
    @endif
  </div>
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
});
</script>
@endpush
