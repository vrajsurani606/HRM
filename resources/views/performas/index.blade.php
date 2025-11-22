@extends('layouts.macos')
@section('page_title', 'Proforma List')
@section('content')

<!-- Filter Row (JV Datatable filter style) -->
<form method="GET" action="{{ route('performas.index') }}" class="jv-filter performa-filter">
  <input type="text" name="company_name" placeholder="Bill Name" class="filter-pill" value="{{ request('company_name') }}" />
  <input type="text" name="unique_code" placeholder="Proforma No." class="filter-pill" value="{{ request('unique_code') }}" />
  <input type="text" name="mobile_no" placeholder="Mobile No." class="filter-pill" value="{{ request('mobile_no') }}" />
  <input type="date" name="from_date" placeholder="From : dd/mm/yyyy" class="filter-pill" value="{{ request('from_date') }}" />
  <input type="date" name="to_date" placeholder="To : dd/mm/yyyy" class="filter-pill" value="{{ request('to_date') }}" />
  <button type="submit" class="filter-search" aria-label="Search">
    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
    </svg>
  </button>
  <div class="filter-right">
    <input type="text" name="search" placeholder="Search here.." class="filter-pill" value="{{ request('search') }}" />
    <a href="#" class="pill-btn pill-success">Excel</a>
    <a href="{{ route('performas.create') }}" class="pill-btn pill-success">+ Add</a>
  </div>
</form>
<!-- Data Table -->
  <div class="JV-datatble JV-datatble--zoom striped-surface striped-surface--full table-wrap pad-none">
  <table>
    <thead>
      <tr>
        <th>Action</th>
        <th>Serial No.</th>
        <th>Proforma No</th>
        <th>Proforma Date</th>
        <th>Bill To</th>
        <th>Mobile No.</th>
        <th>Grand Total</th>
        <th>Total Tax</th>
        <th>Total Amount</th>
      </tr>
    </thead>
    <tbody>
      @forelse($performas as $index => $proforma)
      <tr>
        <td>
          <div class="action-icons">
            <a href="{{ route('performas.edit', $proforma->id) }}">
              <img class="action-icon" src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
            </a>
            <form action="{{ route('performas.destroy', $proforma->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this proforma?');">
              @csrf
              @method('DELETE')
              <button type="submit" style="border:none;background:none;padding:0;cursor:pointer;">
                <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
              </button>
            </form>
            <a href="{{ route('performas.print', $proforma->id) }}" target="_blank">
              <img class="action-icon" src="{{ asset('action_icon/print.svg') }}" alt="Print">
            </a>
            @if($proforma->canConvert())
            <a href="{{ route('performas.convert', $proforma->id) }}" title="Convert to Invoice ({{ $proforma->hasGstInvoice() ? 'Without GST available' : ($proforma->hasWithoutGstInvoice() ? 'GST available' : 'Both available') }})" aria-label="Convert to Invoice">
              <img src="{{ asset('action_icon/convert.svg') }}" alt="Convert" class="action-icon">
            </a>
            @else
            <span title="Both GST and Without GST invoices already generated" style="opacity: 0.3; cursor: not-allowed; display: inline-block;">
              <img src="{{ asset('action_icon/convert.svg') }}" alt="Converted" class="action-icon" style="pointer-events: none;">
            </span>
            @endif
          </div>
        </td>
        <td>{{ $performas->firstItem() + $index }}</td>
        <td>{{ $proforma->unique_code }}</td>
        <td>{{ $proforma->proforma_date ? $proforma->proforma_date->format('d-m-Y') : '-' }}</td>
        <td>{{ $proforma->company_name }}</td>
        <td>{{ $proforma->mobile_no ?? '-' }}</td>
        <td>{{ number_format($proforma->sub_total ?? 0, 2) }}</td>
        <td>{{ number_format($proforma->total_tax_amount ?? 0, 2) }}</td>
        <td>{{ number_format($proforma->final_amount ?? 0, 2) }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="9" style="text-align:center;">No proformas found</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Pagination -->
<div class="pagination-wrapper" style="margin-top: 20px; display: flex; justify-content: center;">
  {{ $performas->links() }}
</div>

@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('performas.index') }}">Performas</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Proforma List</span>
@endsection
