@extends('layouts.macos')
@section('page_title', 'Companies')
@section('content')
<div class="hrp-card">
  <!-- JV Filter -->
  <div class="jv-filter">
    <input type="text" placeholder="Company name..." class="filter-pill" />
    <input type="text" placeholder="GST No." class="filter-pill" />
    <button type="button" class="filter-search" aria-label="Search">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
      </svg>
    </button>
    <div class="filter-right">
      <input type="text" placeholder="Search here.." class="filter-pill" />
      <a href="#" class="pill-btn pill-success">Excel</a>
      <a href="{{ route('companies.create') }}" class="pill-btn pill-success">+ Add</a>
    </div>
  </div>
  <!-- JV Table -->
  <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
    <table>
      <thead>
        <tr>
          <th>Action</th>
          <th>Serial No</th>
          <th>Com. Code</th>
          <th>Company Name</th>
          <th>GST No.</th>
          <th>Person Name</th>
          <th>Mobile Number</th>
          <th>Position</th>
          <th>Address</th>
        </tr>
      </thead>
          <tbody>
            <tr>
              <td>
                <div class="action-icons">
                  <img class="action-icon" src="{{ asset('action_icon/view.svg') }}" alt="Show">
                  <img class="action-icon" src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
                  <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
                </div>
              </td>
              <td>1</td>
              <td>CMS/COM/0022</td>
              <td>Manglam Consultancy Services</td>
              <td>24ABAFM0105D1Z8</td>
              <td>Pratikbhai Desai</td>
              <td>9824042821</td>
              <td>Partner</td>
              <td>Vallabhkrupa, Ellora Park, Surat</td>
            </tr>
            <tr>
              <td>
                <div class="action-icons">
                  <img class="action-icon" src="{{ asset('action_icon/view.svg') }}" alt="Show">
                  <img class="action-icon" src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
                  <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
                </div>
              </td>
              <td>2</td>
              <td>CMS/COM/0023</td>
              <td>Manglam Consultancy Services</td>
              <td>24ABAFM0105D1Z8</td>
              <td>Pratikbhai Desai</td>
              <td>9824042821</td>
              <td>Partner</td>
              <td>Vallabhkrupa, Ellora Park, Surat</td>
            </tr>
            <tr>
              <td>
                <div class="action-icons">
                  <img class="action-icon" src="{{ asset('action_icon/view.svg') }}" alt="Show">
                  <img class="action-icon" src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
                  <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
                </div>
              </td>
              <td>3</td>
              <td>CMS/COM/0024</td>
              <td>Manglam Consultancy Services</td>
              <td>24ABAFM0105D1Z8</td>
              <td>Pratikbhai Desai</td>
              <td>9824042821</td>
              <td>Owner</td>
              <td>Vallabhkrupa, Ellora Park, Surat</td>
            </tr>
            <tr>
              <td>
                <div class="action-icons">
                  <img class="action-icon" src="{{ asset('action_icon/view.svg') }}" alt="Show">
                  <img class="action-icon" src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
                  <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
                </div>
              </td>
              <td>4</td>
              <td>CMS/COM/0025</td>
              <td>Manglam Consultancy Services</td>
              <td>24ABAFM0105D1Z8</td>
              <td>Pratikbhai Desai</td>
              <td>9824042821</td>
              <td>Partner</td>
              <td>Vallabhkrupa, Ellora Park, Surat</td>
            </tr>
          </tbody>
        </table>
  </div>
</div>
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