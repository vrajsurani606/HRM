@extends('layouts.macos')
@section('page_title', 'Invoice List')
@section('content')

<!-- Filter Row -->
<form method="GET" action="{{ route('invoices.index') }}" class="jv-filter performa-filter">
  <input type="text" name="search" placeholder="Search Invoice No, Company..." class="filter-pill" value="{{ request('search') }}" />
  <select name="invoice_type" class="filter-pill">
    <option value="">All Types</option>
    <option value="gst" {{ request('invoice_type') == 'gst' ? 'selected' : '' }}>GST Invoice</option>
    <option value="without_gst" {{ request('invoice_type') == 'without_gst' ? 'selected' : '' }}>Without GST</option>
  </select>
  <input type="date" name="from_date" placeholder="From : dd/mm/yyyy" class="filter-pill" value="{{ request('from_date') }}" />
  <input type="date" name="to_date" placeholder="To : dd/mm/yyyy" class="filter-pill" value="{{ request('to_date') }}" />
  <button type="submit" class="filter-search" aria-label="Search">
    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
    </svg>
  </button>
  <div class="filter-right">
    <a href="#" class="pill-btn pill-success">Excel</a>
  </div>
</form>

<!-- Data Table -->
<div class="JV-datatble JV-datatble--zoom striped-surface striped-surface--full table-wrap pad-none">
  <table>
    <thead>
      <tr>
        <th>Action</th>
        <th>Serial No.</th>
        <th>Invoice No</th>
        <th>Invoice Date</th>
        <th>Invoice Type</th>
        <th>Proforma No</th>
        <th>Bill To</th>
        <th>Mobile No.</th>
        <th>Grand Total</th>
        <th>Total Tax</th>
        <th>Total Amount</th>
      </tr>
    </thead>
    <tbody>
      @forelse($invoices as $index => $invoice)
      <tr>
        <td>
          <div class="action-icons">
            <a href="{{ route('invoices.edit', $invoice->id) }}">
              <img class="action-icon" src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
            </a>
            <a href="{{ route('invoices.show', $invoice->id) }}">
              <img class="action-icon" src="{{ asset('action_icon/view.svg') }}" alt="View">
            </a>
            <a href="{{ route('invoices.print', $invoice->id) }}" target="_blank">
              <img class="action-icon" src="{{ asset('action_icon/print.svg') }}" alt="Print">
            </a>
            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this invoice?');">
              @csrf
              @method('DELETE')
              <button type="submit" style="border:none;background:none;padding:0;cursor:pointer;">
                <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
              </button>
            </form>
          </div>
        </td>
        <td>{{ $invoices->firstItem() + $index }}</td>
        <td>{{ $invoice->unique_code }}</td>
        <td>{{ $invoice->invoice_date ? $invoice->invoice_date->format('d-m-Y') : '-' }}</td>
        <td>
          @if($invoice->invoice_type == 'gst')
            <span style="background: #E8F0FC; color: #456DB5; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">GST</span>
          @else
            <span style="background: #FEF3C7; color: #92400E; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Without GST</span>
          @endif
        </td>
        <td>{{ $invoice->proforma ? $invoice->proforma->unique_code : '-' }}</td>
        <td>{{ $invoice->company_name }}</td>
        <td>{{ $invoice->mobile_no ?? '-' }}</td>
        <td>₹{{ number_format($invoice->sub_total ?? 0, 2) }}</td>
        <td>₹{{ number_format($invoice->total_tax_amount ?? 0, 2) }}</td>
        <td>₹{{ number_format($invoice->final_amount ?? 0, 2) }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="11" class="text-center py-4">No invoices found</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Pagination -->
<div class="pagination-wrapper">
  {{ $invoices->links() }}
</div>
@endsection
