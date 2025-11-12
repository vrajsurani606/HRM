@section('footer_pagination')
  @include('partials.footer')
@endsection
@extends('layouts.macos')
@section('page_title', 'Inquiries')
@section('content')
<div class="inquiry-index-container">
  <!-- JV Filter -->
  <div class="jv-filter">
    <input type="date" id="start_date" class="filter-pill" placeholder="From: dd/mm/yyyy">
    <input type="date" id="end_date" class="filter-pill" placeholder="To: dd/mm/yyyy">
    <select id="gender_filter" class="filter-pill" required>
      <option value="" disabled selected>Select Gender</option>
      <option value="male">Male</option>
      <option value="female">Female</option>
      <option value="other">Other</option>
    </select>
    <select id="experience_filter" class="filter-pill" required>
      <option value="" disabled selected>Select Experience</option>
      <option value="0-1">0-1 Years</option>
      <option value="1-3">1-3 Years</option>
      <option value="3+">3+ Years</option>
    </select>
    <button type="button" class="filter-search" id="filter_btn" aria-label="Search">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
      </svg>
    </button>
    <div class="filter-right">
      <input type="text" class="filter-pill" placeholder="Search here..." id="custom_search">
      <a href="#" class="pill-btn pill-success" id="excel_btn">Excel</a>
      <a href="{{ route('inquiries.create') }}" class="pill-btn pill-success">+ Add</a>
    </div>
  </div>

  <!-- JV Table -->
  <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
    <table>
      <thead>
        <tr>
          <th>Action</th>
          <th>Serial No.</th>
          <th>Is Confirm</th>
          <th>Code</th>
          <th>Inq. Date</th>
          <th>Comp. Name</th>
          <th>Mo.No.</th>
          <th>Address</th>
          <th>Person Name</th>
          <th>Person Position</th>
          <th>Industry Type</th>
          <th>Scope</th>
          <th>Next Date</th>
          <th>Demo Status</th>
          <th>Demo Date & Time</th>
        </tr>
      </thead>
      <tbody>
        @forelse($inquiries as $index => $inquiry)
        <tr>
          <td>
            <div class="action-icons">
              <img class="action-icon" src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
              <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
              <img class="action-icon" src="{{ asset('action_icon/follow-up.svg') }}" alt="Follow Up">
              <img class="action-icon" src="{{ asset('action_icon/make-quatation.svg') }}" alt="Make Quotation">
            </div>
          </td>
          <td>{{ $index + 1 }}</td>
          <td><span class="status-badge confirmed">Confirmed</span></td>
          <td>{{ $inquiry->unique_code }}</td>
          <td>{{ $inquiry->inquiry_date->format('d-m-Y') }}</td>
          <td>{{ $inquiry->company_name }}</td>
          <td>{{ $inquiry->company_phone }}</td>
          <td>{{ Str::limit($inquiry->company_address, 30) }}</td>
          <td>{{ $inquiry->contact_name }}</td>
          <td>{{ $inquiry->contact_position }}</td>
          <td>{{ $inquiry->industry_type }}</td>
          <td><a href="{{ $inquiry->scope_link }}" class="scope-link">View</a></td>
          <td>{{ $inquiry->created_at->addDays(7)->format('d-m-Y') }}</td>
          <td><span class="status-badge scheduled">Scheduled</span></td>
          <td>{{ $inquiry->created_at->addDays(3)->format('d/m/Y') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="15" class="no-data">No inquiries found</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Inquiries</span>
@endsection

@push('scripts')
@endpush
