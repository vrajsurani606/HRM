@extends('layouts.macos')
@section('page_title', 'Receipt List')
@section('content')

<!-- Filter Row -->
<form method="GET" action="{{ route('receipts.index') }}" class="jv-filter performa-filter" data-no-loader="true">
  <input type="text" name="search" placeholder="Search Receipt No, Company..." class="filter-pill live-search" value="{{ request('search') }}" />
  <select name="invoice_type" class="filter-pill">
    <option value="">All Types</option>
    <option value="gst" {{ request('invoice_type') == 'gst' ? 'selected' : '' }}>GST Invoice</option>
    <option value="without_gst" {{ request('invoice_type') == 'without_gst' ? 'selected' : '' }}>Without GST Invoice</option>
  </select>
  <input type="text" name="from_date" placeholder="From : dd/mm/yyyy" class="filter-pill date-picker" value="{{ request('from_date') }}" autocomplete="off" />
  <input type="text" name="to_date" placeholder="To : dd/mm/yyyy" class="filter-pill date-picker" value="{{ request('to_date') }}" autocomplete="off" />
  <button type="submit" class="filter-search" aria-label="Search">
    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
    </svg>
  </button>
  <div class="filter-right">
    @can('Receipts Management.export receipt')
      <a href="{{ route('receipts.export.csv', request()->only(['search','invoice_type','from_date','to_date'])) }}" class="pill-btn pill-success">Excel</a>
    @endcan
    @can('Receipts Management.create receipt')
      <a href="{{ route('receipts.create') }}" class="pill-btn pill-success">+ Add</a>
    @endcan
  </div>
</form>

<!-- Data Table -->
<div class="JV-datatble JV-datatble--zoom striped-surface striped-surface--full table-wrap pad-none">
  <table>
    <thead>
      <tr>
        @if(user_has_any_action_permission('Receipts Management', ['view receipt', 'edit receipt', 'delete receipt', 'print receipt']))
          <th>Action</th>
        @endif
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
        @if(user_has_any_action_permission('Receipts Management', ['view receipt', 'edit receipt', 'delete receipt', 'print receipt']))
          <td>
            <div class="action-icons">
              @can('Receipts Management.view receipt')
                <a href="{{ route('receipts.show', $receipt->id) }}">
                  <img class="action-icon" src="{{ asset('action_icon/view.svg') }}" alt="View">
                </a>
              @endcan
              @can('Receipts Management.edit receipt')
                <a href="{{ route('receipts.edit', $receipt->id) }}">
                  <img class="action-icon" src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
                </a>
              @endcan
              @can('Receipts Management.print receipt')
                <a href="{{ route('receipts.print', $receipt->id) }}" target="_blank">
                  <img class="action-icon" src="{{ asset('action_icon/print.svg') }}" alt="Print">
                </a>
              @endcan
              @can('Receipts Management.delete receipt')
                <form action="{{ route('receipts.destroy', $receipt->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this receipt?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" style="border:none;background:none;padding:0;cursor:pointer;">
                    <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
                  </button>
                </form>
              @endcan
            </div>
          </td>
        @endif
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
        <x-empty-state 
            colspan="{{ user_has_any_action_permission('Receipts Management', ['view receipt', 'edit receipt', 'delete receipt', 'print receipt']) ? '9' : '8' }}" 
            title="No receipts found" 
            message="Try adjusting your filters or create a new receipt"
        />
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

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
// Initialize jQuery datepicker
$(document).ready(function() {
    $('.date-picker').datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '-10:+10',
        showButtonPanel: true,
        beforeShow: function(input, inst) {
            setTimeout(function() {
                inst.dpDiv.css({ marginTop: '2px', marginLeft: '0px' });
            }, 0);
        }
    });
});

// Convert dates before form submission
document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('.performa-filter');
    if(form){
        form.addEventListener('submit', function(e){
            var fromDate = document.querySelector('input[name="from_date"]');
            var toDate = document.querySelector('input[name="to_date"]');
            
            if(fromDate && fromDate.value){
                var parts = fromDate.value.split('/');
                if(parts.length === 3) fromDate.value = parts[2] + '-' + parts[1] + '-' + parts[0];
            }
            if(toDate && toDate.value){
                var parts = toDate.value.split('/');
                if(parts.length === 3) toDate.value = parts[2] + '-' + parts[1] + '-' + parts[0];
            }
        });
    }
});
</script>
@endpush
