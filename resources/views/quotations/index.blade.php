@extends('layouts.macos')
@section('page_title', 'Quotation List')
@section('content')
<div class="inquiry-index-container">
  <!-- JV Filter -->
  <div class="jv-filter">
    <input type="text" placeholder="Quotation No" class="filter-pill">
    <input type="date" placeholder="From : dd/mm/yyyy" class="filter-pill">
    <input type="date" placeholder="To : dd/mm/yyyy" class="filter-pill">
    <button type="button" class="filter-search" aria-label="Search">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
        <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" />
        <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" />
      </svg>
    </button>

    <div class="filter-right">
      <input type="text" id="globalSearch" placeholder="Search here.." class="filter-pill">
      <a href="#" class="pill-btn pill-success">Excel</a>
      <a href="{{ route('quotations.create') }}" class="pill-btn pill-success">+ Add</a>
    </div>
  </div>

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
        <tr>
          <td>
            <div class="action-icons">
              <img class="action-icon" src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
              <img class="action-icon" src="{{ asset('action_icon/print.svg') }}" alt="Print">
              <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
              <img class="action-icon" src="{{ asset('action_icon/discount.svg') }}" alt="Discount">
              <img class="action-icon" src="{{ asset('action_icon/pluse.svg') }}" alt="Add">
            </div>
          </td>
          <td>1</td>
          <td>CMS/INQ/0004</td>
          <td>Manglam Consultancy Services</td>
          <td>9316187694</td>
          <td>20/06/2025</td>
          <td>20/06/2025</td>
          <td>Done</td>
          <td>
            <div
              style="width: 20px; height: 20px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
              <span style="color: white; font-size: 12px;">✓</span>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div class="action-icons">
              <img class="action-icon" src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
              <img class="action-icon" src="{{ asset('action_icon/print.svg') }}" alt="Print">
              <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
              <img class="action-icon" src="{{ asset('action_icon/discount.svg') }}" alt="Discount">
              <img class="action-icon" src="{{ asset('action_icon/pluse.svg') }}" alt="Add">
            </div>
          </td>
          <td>2</td>
          <td>CMS/INQ/0005</td>
          <td>OWN Company Surat</td>
          <td>9316187694</td>
          <td>20/06/2025</td>
          <td>20/06/2025</td>
          <td>Done</td>
          <td>
            <div
              style="width: 20px; height: 20px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
              <span style="color: white; font-size: 12px;">✓</span>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div class="action-icons">
              <img class="action-icon" src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
              <img class="action-icon" src="{{ asset('action_icon/print.svg') }}" alt="Print">
              <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
              <img class="action-icon" src="{{ asset('action_icon/discount.svg') }}" alt="Discount">
              <img class="action-icon" src="{{ asset('action_icon/pluse.svg') }}" alt="Add">
            </div>
          </td>
          <td>3</td>
          <td>CMS/INQ/0006</td>
          <td>SHREEJI GEOTECH CONSULTA...</td>
          <td>9316187694</td>
          <td>20/06/2025</td>
          <td>20/06/2025</td>
          <td>Done</td>
          <td>
            <div
              style="width: 20px; height: 20px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
              <span style="color: white; font-size: 12px;">✓</span>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div class="action-icons">
              <img class="action-icon" src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
              <img class="action-icon" src="{{ asset('action_icon/print.svg') }}" alt="Print">
              <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
              <img class="action-icon" src="{{ asset('action_icon/discount.svg') }}" alt="Discount">
              <img class="action-icon" src="{{ asset('action_icon/pluse.svg') }}" alt="Add">
            </div>
          </td>
          <td>4</td>
          <td>CMS/INQ/0007</td>
          <td>TECH FAB (INDIA) INDUSTRIES LTD.</td>
          <td>9316187694</td>
          <td>20/06/2025</td>
          <td>20/06/2025</td>
          <td>Done</td>
          <td>
            <div
              style="width: 20px; height: 20px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
              <span style="color: white; font-size: 12px;">✓</span>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>


</div>
@endsection



@push('scripts')
@endpush

@section('breadcrumb')
@endsection

@section('footer_pagination')
  @include('partials.footer')
@endsection