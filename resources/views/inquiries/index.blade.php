@section('footer_pagination')
  @if(isset($inquiries) && method_exists($inquiries,'links'))
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
  {{ $inquiries->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv') }}
  @endif
@endsection
@extends('layouts.macos')
@section('page_title', 'Inquiry List')
@section('content')
<div class="inquiry-index-container">
  <!-- JV Filter -->
  <form method="GET" action="{{ route('inquiries.index') }}" class="jv-filter" id="filterForm">
    <input type="text" id="start_date" name="from_date" class="filter-pill date-picker" placeholder="From: dd/mm/yyyy" value="{{ request('from_date') }}" autocomplete="off">
    <input type="text" id="end_date" name="to_date" class="filter-pill date-picker" placeholder="To: dd/mm/yyyy" value="{{ request('to_date') }}" autocomplete="off">
    <button type="submit" class="filter-search" id="filter_btn" aria-label="Search">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
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
      <input type="text" class="filter-pill live-search" placeholder="Search here..." id="custom_search" name="search" value="{{ request('search') }}">
      @can('Inquiries Management.export inquiry')
        <a href="{{ route('inquiries.export', request()->only(['from_date','to_date','search'])) }}" class="pill-btn pill-success" id="excel_btn">Excel</a>
      @endcan
      @can('Inquiries Management.create inquiry')
        <a href="{{ route('inquiries.create') }}" class="pill-btn pill-success">+ Add</a>
      @endcan
    </div>
  </form>

  @if(!empty($todayScheduledInquiryIds))
  <div style="margin-bottom:8px;font-size:12px;color:#374151;display:flex;align-items:center;gap:8px;">
    <span style="display:inline-block;width:12px;height:12px;border-radius:2px;background:#fff7ed;border:1px solid #fed7aa;"></span>
    <span>Rows highlighted indicate <strong>Scheduled Demo Today</strong>.</span>
  </div>
  @endif

  <!-- Grid View -->
  <div class="inquiries-grid-view">
    @forelse($inquiries as $inq)
      <div class="inquiry-grid-card" onclick="window.location.href='{{ route('inquiries.show', $inq->id) }}'" title="View inquiry">
        <div class="inq-grid-header">
          <h3 class="inq-grid-title">{{ $inq->company_name ?? 'N/A' }}</h3>
          <span class="inq-grid-badge">{{ $inq->industry_type ?? '—' }}</span>
        </div>
        <p class="inq-grid-sub">Code: {{ $inq->code ?? '-' }} • Inq. Date: {{ isset($inq->inquiry_date) ? \Carbon\Carbon::parse($inq->inquiry_date)->format('d M, Y') : '-' }}</p>
        <div class="inq-grid-meta">
          <div class="inq-grid-left">
            <div class="meta-row"><span class="meta-label">Contact</span><span class="meta-value">{{ $inq->person_name ?? '-' }} {{ !empty($inq->mobile_no) ? '• '.$inq->mobile_no : '' }}</span></div>
            <div class="meta-row"><span class="meta-label">Address</span><span class="meta-value">{{ $inq->address ?? '-' }}</span></div>
            <div class="meta-row"><span class="meta-label">Next FU</span><span class="meta-value">{{ isset($inq->next_follow_up) ? \Carbon\Carbon::parse($inq->next_follow_up)->format('d M, Y') : '-' }}</span></div>
          </div>
          <div class="inq-grid-actions" onclick="event.stopPropagation()">
            @can('Inquiries Management.view inquiry')
              <a class="inq-grid-action-btn btn-view" href="{{ route('inquiries.show', $inq->id) }}" title="View" aria-label="View">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
              </a>
            @endcan
            @can('Inquiries Management.edit inquiry')
              <a class="inq-grid-action-btn btn-edit" href="{{ route('inquiries.edit', $inq->id) }}" title="Edit" aria-label="Edit">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
              </a>
            @endcan
            @can('Inquiries Management.delete inquiry')
              <form method="POST" action="{{ route('inquiries.destroy', $inq->id) }}" class="delete-form" style="display:inline">
                @csrf @method('DELETE')
                <button type="button" onclick="confirmDeleteInquiry(this); event.stopPropagation();" class="inq-grid-action-btn btn-delete" title="Delete" aria-label="Delete">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                </button>
              </form>
            @endcan
            @can('Inquiries Management.follow up')
              <a class="inq-grid-action-btn btn-followup" href="{{ route('inquiry.follow-up', $inq->id) }}" title="Follow Up" aria-label="Follow Up">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
              </a>
            @endcan
            @if(!empty($inq->quotation_sent) && strtolower($inq->quotation_sent) !== 'no')
              @can('Quotations Management.create quotation')
                <a class="inq-grid-action-btn btn-quotation" href="{{ route('quotation.create-from-inquiry', $inq->id) }}" title="Make Quotation" aria-label="Make Quotation">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </a>
              @endcan
            @endif
          </div>
        </div>
      </div>
    @empty
      <div class="text-center py-3">No inquiries found.</div>
    @endforelse
  </div>

  <!-- List View -->
  <div class="inquiries-list-view active">
    <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
      <table>
        <thead>
          <tr>
            <th>Action</th>
            <th>Serial No.</th>
            <th>Code</th>
            <th>Inq. Date</th>
            <th>Comp. Name</th>
            <th>Mo.No.</th>
            <th>Address</th>
            <th>Person Name</th>
            <th>Person Position</th>
            <th>Industry Type</th>
            <th>Next Follow Up</th>
            <th>Confirm Status</th>
            <th>Scope</th>
            <th>Quotation</th>
          </tr>
        </thead>
        <tbody id="inquiries-table-body">
          @include('inquiries.partials.table_rows', ['inquiries' => $inquiries])
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('inquiries.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Inquiry Management</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Inquiry List</span>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Initialize jQuery datepicker with dd/mm/yyyy format (same as quotation)
$(document).ready(function() {
    $('.date-picker').datepicker({
        dateFormat: 'dd/mm/yy', // In jQuery UI, 'yy' means 4-digit year
        changeMonth: true,
        changeYear: true,
        yearRange: '-10:+10',
        showButtonPanel: true,
        beforeShow: function(input, inst) {
            setTimeout(function() {
                inst.dpDiv.css({
                    marginTop: '2px',
                    marginLeft: '0px'
                });
            }, 0);
        }
    });
});
</script>

<script>
  // SweetAlert delete confirmation for inquiries
  function confirmDeleteInquiry(button) {
    Swal.fire({
      title: 'Delete this inquiry?',
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

  // AJAX live filter for Inquiry List (JV-style)
  document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('.jv-filter');
    var tbody = document.getElementById('inquiries-table-body');
    if (!form || !tbody) return;

    function fetchInquiries() {
      // Convert date format before fetching
      var fromDateInput = document.getElementById('start_date');
      var toDateInput = document.getElementById('end_date');
      
      // Store original values
      var originalFromDate = fromDateInput ? fromDateInput.value : '';
      var originalToDate = toDateInput ? toDateInput.value : '';
      
      // Convert dates from dd/mm/yyyy to yyyy-mm-dd for query
      if(fromDateInput && fromDateInput.value){
        var parts = fromDateInput.value.split('/');
        if(parts.length === 3){
          fromDateInput.value = parts[2] + '-' + parts[1] + '-' + parts[0];
        }
      }
      
      if(toDateInput && toDateInput.value){
        var parts = toDateInput.value.split('/');
        if(parts.length === 3){
          toDateInput.value = parts[2] + '-' + parts[1] + '-' + parts[0];
        }
      }
      
      var params = new URLSearchParams(new FormData(form));
      var url = form.getAttribute('action') + '?' + params.toString();
      
      // Restore original values
      if(fromDateInput) fromDateInput.value = originalFromDate;
      if(toDateInput) toDateInput.value = originalToDate;

      fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(function(res) { return res.text(); })
      .then(function(html) {
        tbody.innerHTML = html;
      })
      .catch(function(e) {
        console.error('Filter error', e);
      });
    }

    form.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Convert dates from dd/mm/yyyy to yyyy-mm-dd before submission
      var fromDateInput = document.getElementById('start_date');
      var toDateInput = document.getElementById('end_date');
      
      if(fromDateInput && fromDateInput.value){
        var parts = fromDateInput.value.split('/');
        if(parts.length === 3){
          fromDateInput.value = parts[2] + '-' + parts[1] + '-' + parts[0];
        }
      }
      
      if(toDateInput && toDateInput.value){
        var parts = toDateInput.value.split('/');
        if(parts.length === 3){
          toDateInput.value = parts[2] + '-' + parts[1] + '-' + parts[0];
        }
      }
      
      fetchInquiries();
    });

    var searchInput = document.getElementById('custom_search');
    if (searchInput) {
      searchInput.addEventListener('input', function() {
        fetchInquiries();
      });
    }
    
    // Handle Excel export button with date conversion
    var excelBtn = document.getElementById('excel_btn');
    if(excelBtn){
      excelBtn.addEventListener('click', function(e){
        e.preventDefault();
        
        var fromDateInput = document.getElementById('start_date');
        var toDateInput = document.getElementById('end_date');
        var searchInput = document.getElementById('custom_search');
        
        var params = new URLSearchParams();
        
        // Convert and add from_date
        if(fromDateInput && fromDateInput.value){
          var parts = fromDateInput.value.split('/');
          if(parts.length === 3){
            params.append('from_date', parts[2] + '-' + parts[1] + '-' + parts[0]);
          }
        }
        
        // Convert and add to_date
        if(toDateInput && toDateInput.value){
          var parts = toDateInput.value.split('/');
          if(parts.length === 3){
            params.append('to_date', parts[2] + '-' + parts[1] + '-' + parts[0]);
          }
        }
        
        // Add search parameter
        if(searchInput && searchInput.value){
          params.append('search', searchInput.value);
        }
        
        // Navigate to export URL with converted dates
        var exportUrl = this.href.split('?')[0] + '?' + params.toString();
        window.location.href = exportUrl;
      });
    }
  });

  // View toggle logic with persistence
  document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.view-toggle-btn');
    const grid = document.querySelector('.inquiries-grid-view');
    const list = document.querySelector('.inquiries-list-view');
    if (!buttons.length || !grid || !list) return;

    function applyView(view) {
      if (view === 'grid') { grid.classList.add('active'); list.classList.remove('active'); }
      else { list.classList.add('active'); grid.classList.remove('active'); }
      buttons.forEach(b => b.classList.toggle('active', b.getAttribute('data-view') === view));
    }
    const saved = localStorage.getItem('inquiries_view') || 'list';
    applyView(saved);
    buttons.forEach(btn => btn.addEventListener('click', function(){
      const v = this.getAttribute('data-view');
      localStorage.setItem('inquiries_view', v);
      applyView(v);
    }));
  });

  // Confirm Follow Up functionality
  document.addEventListener('DOMContentLoaded', function() {
    var token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    // Use event delegation for dynamically loaded content
    document.addEventListener('click', function(e) {
      if (e.target.closest('.confirm-followup-btn')) {
        var btn = e.target.closest('.confirm-followup-btn');
        var followUpId = btn.getAttribute('data-followup-id');
        if (!followUpId) return;

        Swal.fire({
          title: 'Confirm this follow-up?',
          text: "This will mark the latest follow-up as confirmed.",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#16a34a',
          cancelButtonColor: '#6b7280',
          confirmButtonText: 'Yes, Confirm',
          cancelButtonText: 'Cancel',
          width: '400px',
        }).then(function(result) {
          if (!result.isConfirmed) return;

          fetch("{{ route('inquiry.follow-up.confirm', ['followUp' => 'FOLLOWUP_ID']) }}".replace('FOLLOWUP_ID', followUpId), {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': token,
              'Accept': 'application/json',
            },
          })
          .then(function(res) { return res.json(); })
          .then(function(data) {
            if (data && data.success) {
              // Replace the pending badge with confirmed badge
              var cell = btn.closest('td');
              if(cell) {
                cell.innerHTML = '<span class="status-badge status-confirmed" style="display:inline-flex;align-items:center;gap:4px;"><img src="{{ asset("action_icon/completed.svg") }}" alt="Confirmed" style="width:14px;height:14px;">Confirmed</span>';
              }
              
              Swal.fire({
                title: 'Follow-up confirmed!',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false,
                width: '380px',
              });
            }
          })
          .catch(function() {
            Swal.fire('Error', 'Unable to confirm follow-up.', 'error');
          });
        });
      }
    });
  });
</script>
@endpush

@push('styles')
<style>
  /* Status Badges */
  .status-badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    white-space: nowrap;
  }

  .status-pending {
    background-color: #fef3c7;
    color: #92400e;
  }

  .status-confirmed {
    background-color: #d1fae5;
    color: #065f46;
  }

  /* Toggle */
  .view-toggle-group { display:flex; gap:4px; background:#f3f4f6; padding:4px; border-radius:8px; }
  .view-toggle-btn { padding:8px 12px; background:transparent; border:none; border-radius:6px; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; }
  .view-toggle-btn:hover { background:#e5e7eb; }
  .view-toggle-btn.active { background:#fff; box-shadow:0 1px 3px rgba(0,0,0,0.1); }
  .view-toggle-btn svg { color:#6b7280; }
  .view-toggle-btn.active svg { color:#3b82f6; }

  /* Grid */
  .inquiries-grid-view { display:none; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap:16px; padding:12px 12px 12px; }
  .inquiries-grid-view.active { display:grid; }
  .inquiries-list-view { display:none;  }
  .inquiries-list-view.active { display:block; }

  .inquiry-grid-card { background:#fff; border-radius:12px; padding:16px 18px; box-shadow:0 1px 6px rgba(0,0,0,0.06); transition:transform .25s, box-shadow .25s; cursor:pointer; margin-top:4px; }
  .inquiry-grid-card:hover { transform: translateY(-4px); box-shadow:0 4px 16px rgba(0,0,0,0.12); }
  .inq-grid-header { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; margin-bottom:10px; }
  .inq-grid-title { font-size:16px; font-weight:700; color:#0f172a; margin:0; line-height:1.2; max-width:72%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
  .inq-grid-badge { font-size:11px; padding:4px 8px; border-radius:12px; font-weight:500; background:#eef2ff; color:#3730a3; }
  .inq-grid-sub { font-size:12px; color:#6b7280; margin:0 0 12px; }
  .inq-grid-meta { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; padding-top:12px; border-top:1px solid #f3f4f6; }
  .inq-grid-left { flex:1; display:flex; flex-direction:column; gap:6px; }
  .meta-row { display:flex; gap:8px; align-items:center; }
  .meta-label { font-size:12px; color:#6b7280; min-width:64px; }
  .meta-value { font-size:13px; color:#111827; }
  .inq-grid-actions { display:flex; gap:8px; }
  .inq-grid-action-btn { padding:8px; border:1px solid #e5e7eb; background:#fff; border-radius:6px; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; width:32px; height:32px; }
  .inq-grid-action-btn.btn-view { border-color:#3b82f6; background:#eff6ff; }
  .inq-grid-action-btn.btn-view svg { color:#3b82f6; }
  .inq-grid-action-btn.btn-view:hover { background:#3b82f6; }
  .inq-grid-action-btn.btn-view:hover svg { color:#fff; }
  .inq-grid-action-btn.btn-edit { border-color:#f59e0b; background:#fffbeb; }
  .inq-grid-action-btn.btn-edit svg { color:#f59e0b; }
  .inq-grid-action-btn.btn-edit:hover { background:#f59e0b; }
  .inq-grid-action-btn.btn-edit:hover svg { color:#fff; }
  
  /* Delete button - Red */
  .inq-grid-action-btn.btn-delete { 
    border: 1px solid #ef4444 !important; 
    background: #fef2f2 !important; 
    padding: 8px !important;
    cursor: pointer !important;
    transition: all 0.2s !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 32px !important;
    height: 32px !important;
    border-radius: 6px !important;
  }
  .inq-grid-action-btn.btn-delete svg { color:#ef4444; }
  .inq-grid-action-btn.btn-delete:hover { background:#ef4444 !important; }
  .inq-grid-action-btn.btn-delete:hover svg { color:#fff; }
  
  /* Follow Up button - Purple */
  .inq-grid-action-btn.btn-followup { border-color:#8b5cf6; background:#f5f3ff; }
  .inq-grid-action-btn.btn-followup svg { color:#8b5cf6; }
  .inq-grid-action-btn.btn-followup:hover { background:#8b5cf6; }
  .inq-grid-action-btn.btn-followup:hover svg { color:#fff; }
  
  /* Make Quotation button - Green */
  .inq-grid-action-btn.btn-quotation { border-color:#10b981; background:#ecfdf5; }
  .inq-grid-action-btn.btn-quotation svg { color:#10b981; }
  .inq-grid-action-btn.btn-quotation:hover { background:#10b981; }
  .inq-grid-action-btn.btn-quotation:hover svg { color:#fff; }
</style>
@endpush
