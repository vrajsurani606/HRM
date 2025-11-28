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
      <a href="{{ route('quotations.export', request()->only(['quotation_no','from_date','to_date','search'])) }}" class="pill-btn pill-success">Excel</a>
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
            <div class="meta-row"><span class="meta-label">Mobile</span><span class="meta-value">{{ $quotation->contact_number_1 ?? 'N/A' }}</span></div>
            <div class="meta-row"><span class="meta-label">Next</span><span class="meta-value">{{ $quotation->tentative_complete_date ? $quotation->tentative_complete_date->format('d M, Y') : '-' }}</span></div>
            <div class="meta-row"><span class="meta-label">Confirm</span><span class="meta-value">{{ (isset($confirmedQuotationIds) && in_array($quotation->id, $confirmedQuotationIds)) ? 'Yes' : 'No' }}</span></div>
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
          </div>
        </div>
      </div>
    @empty
      <div class="text-center py-3">No quotations found</div>
    @endforelse
  </div>

  <!-- List View -->
  <div class="quotations-list-view active">
    <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
      <table style="table-layout: auto; width: 100%; min-width: 1200px;">
        <colgroup>
          <col style="width: 140px; min-width: 140px;">
          <col style="width: 70px; min-width: 70px;">
          <col style="width: 140px; min-width: 140px;">
          <col style="width: auto; min-width: 200px;">
          <col style="width: 110px; min-width: 110px;">
          <col style="width: 100px; min-width: 100px;">
          <col style="width: 110px; min-width: 110px;">
          <col style="width: 90px; min-width: 90px;">
          <col style="width: 80px; min-width: 80px;">
        </colgroup>
        <thead>
          <tr>
            <th style="text-align: center;">Action</th>
            <th>Sr.No.</th>
            <th>Code</th>
            <th>Company Name</th>
            <th>Mobile</th>
            <th>Update</th>
            <th>Next Update</th>
            <th>Remark</th>
            <th>Confirm</th>
          </tr>
        </thead>
        <tbody>
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
              </div>
            </td>
            <td>{{ $quotations->firstItem() + $index }}</td>
            <td>{{ $quotation->unique_code ?? 'N/A' }}</td> 
            <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $quotation->company_name ?? 'N/A' }}">{{ $quotation->company_name ?? 'N/A' }}</td>
            <td>{{ $quotation->contact_number_1 ?? 'N/A' }}</td>
            <td>{{ $quotation->updated_at ? $quotation->updated_at->format('d/m/Y') : 'N/A' }}</td>
            <td>{{ $quotation->tentative_complete_date ? $quotation->tentative_complete_date->format('d/m/Y') : 'N/A' }}</td>
            <td>{{ ucfirst($quotation->status ?? 'Draft') }}</td>
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
      </table>
    </div>
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
</style>
@endpush
