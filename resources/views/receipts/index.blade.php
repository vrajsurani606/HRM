@extends('layouts.macos')
@section('page_title', 'Receipt List')
@section('content')

<!-- Filter Row -->
<form method="GET" action="{{ route('receipts.index') }}" class="jv-filter performa-filter">
  <input type="text" name="search" placeholder="Search Receipt No, Company..." class="filter-pill" value="{{ request('search') }}" />
  <select name="invoice_type" class="filter-pill">
    <option value="">All Types</option>
    <option value="gst" {{ request('invoice_type') == 'gst' ? 'selected' : '' }}>GST Invoice</option>
    <option value="without_gst" {{ request('invoice_type') == 'without_gst' ? 'selected' : '' }}>Without GST Invoice</option>
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
    <a href="{{ route('receipts.create') }}" class="pill-btn pill-success">+ Add</a>
  </div>
</form>

<!-- Data Table -->
<div class="JV-datatble JV-datatble--zoom striped-surface striped-surface--full table-wrap pad-none">
  <table>
    <thead>
      <tr>
        <th>Action</th>
        <th>Serial No.</th>
        <th><x-sortable-header column="unique_code" title="Receipt No" /></th>
        <th><x-sortable-header column="receipt_date" title="Receipt Date" /></th>
        <th><x-sortable-header column="invoice_type" title="Invoice Type" /></th>
        <th><x-sortable-header column="company_name" title="Company Name" /></th>
        <th><x-sortable-header column="received_amount" title="Received Amount" /></th>
        <th>Payment Type</th>
        <th>Trans Code</th>
      </tr>
    </thead>
    <tbody>
      @forelse($receipts as $index => $receipt)
      <tr>
        <td>
          <div class="action-icons">
            <a href="{{ route('receipts.edit', $receipt->id) }}">
              <img class="action-icon" src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
            </a>
            <a href="{{ route('receipts.show', $receipt->id) }}">
              <img class="action-icon" src="{{ asset('action_icon/view.svg') }}" alt="View">
            </a>
            <a href="{{ route('receipts.print', $receipt->id) }}" target="_blank">
              <img class="action-icon" src="{{ asset('action_icon/print.svg') }}" alt="Print">
            </a>
            <form action="{{ route('receipts.destroy', $receipt->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this receipt?');">
              @csrf
              @method('DELETE')
              <button type="submit" style="border:none;background:none;padding:0;cursor:pointer;">
                <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
              </button>
            </form>
          </div>
        </td>
        <td>{{ $receipts->firstItem() + $index }}</td>
        <td>{{ $receipt->unique_code }}</td>
        <td>{{ $receipt->receipt_date ? $receipt->receipt_date->format('d-m-Y') : '-' }}</td>
        <td>
          @if($receipt->invoice_type == 'gst')
            <span style="display: inline-block; padding: 4px 8px; background: #DBEAFE; color: #1E40AF; border-radius: 4px; font-size: 12px; font-weight: 600;">GST</span>
          @elseif($receipt->invoice_type == 'without_gst')
            <span style="display: inline-block; padding: 4px 8px; background: #FEF3C7; color: #92400E; border-radius: 4px; font-size: 12px; font-weight: 600;">Without GST</span>
          @else
            <span style="color: #9ca3af;">-</span>
          @endif
        </td>
        <td>{{ $receipt->company_name }}</td>
        <td>₹{{ number_format($receipt->received_amount ?? 0, 2) }}</td>
        <td>{{ $receipt->payment_type ?? '-' }}</td>
        <td>{{ $receipt->trans_code ?? '-' }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="9" class="text-center py-4">No receipts found</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

@endsection

@section('footer_pagination')
  @if(isset($receipts) && method_exists($receipts,'links'))
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
  {{ $receipts->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv') }}
  @endif

@if(session('status'))
<div class="alert alert-success mt-4">
  {{ session('status') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger mt-4">
  {{ session('error') }}
</div>
@endif

@endsection
