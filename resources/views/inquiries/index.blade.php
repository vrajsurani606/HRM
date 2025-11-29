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
  <form method="GET" action="{{ route('inquiries.index') }}" class="jv-filter">
    <input type="date" id="start_date" name="from_date" class="filter-pill" placeholder="From: dd/mm/yyyy" value="{{ request('from_date') }}">
    <input type="date" id="end_date" name="to_date" class="filter-pill" placeholder="To: dd/mm/yyyy" value="{{ request('to_date') }}">
    <button type="submit" class="filter-search" id="filter_btn" aria-label="Search">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
      </svg>
    </button>
    <div class="filter-right">
      <input type="text" class="filter-pill" placeholder="Search here..." id="custom_search" name="search" value="{{ request('search') }}">
      <a href="{{ route('inquiries.export', request()->only(['from_date','to_date','search'])) }}" class="pill-btn pill-success" id="excel_btn">Excel</a>
      <a href="{{ route('inquiries.create') }}" class="pill-btn pill-success">+ Add</a>
    </div>
  </form>

  @if(!empty($todayScheduledInquiryIds))
  <div style="margin-bottom:8px;font-size:12px;color:#374151;display:flex;align-items:center;gap:8px;">
    <span style="display:inline-block;width:12px;height:12px;border-radius:2px;background:#fff7ed;border:1px solid #fed7aa;"></span>
    <span>Rows highlighted indicate <strong>Scheduled Demo Today</strong>.</span>
  </div>
  @endif

  <!-- JV Table -->
  <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
    <table>
      <thead>
        <tr>
          <th>Action</th>
          <th>Serial No.</th>
          <th><x-sortable-header column="unique_code" title="Code" /></th>
          <th><x-sortable-header column="inquiry_date" title="Inq. Date" /></th>
          <th><x-sortable-header column="company_name" title="Comp. Name" /></th>
          <th>Mo.No.</th>
          <th>Address</th>
          <th><x-sortable-header column="contact_name" title="Person Name" /></th>
          <th>Person Position</th>
          <th><x-sortable-header column="industry_type" title="Industry Type" /></th>
          <th>Next Follow Up</th>
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
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('inquiries.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Inquiry Management</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Inquiry List</span>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
      var params = new URLSearchParams(new FormData(form));
      var url = form.getAttribute('action') + '?' + params.toString();

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
      fetchInquiries();
    });

    var searchInput = document.getElementById('custom_search');
    if (searchInput) {
      searchInput.addEventListener('input', function() {
        fetchInquiries();
      });
    }
  });
</script>
@endpush
