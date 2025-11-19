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