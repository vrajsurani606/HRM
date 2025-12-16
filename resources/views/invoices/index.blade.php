@extends('layouts.macos')
@section('page_title', 'Invoice List')
@section('content')

@php
  $isCustomer = auth()->user()->hasRole('customer') || auth()->user()->hasRole('client') || auth()->user()->hasRole('company');
@endphp

<!-- Filter Row -->
<form method="GET" action="{{ route('invoices.index') }}" class="jv-filter performa-filter">
  <input type="text" name="search" placeholder="Search Invoice No, Company..." class="filter-pill live-search" value="{{ request('search') }}" />
  @if(!$isCustomer)
  <select name="invoice_type" class="filter-pill">
    <option value="">All Types</option>
    <option value="gst" {{ request('invoice_type') == 'gst' ? 'selected' : '' }}>GST Invoice</option>
    <option value="without_gst" {{ request('invoice_type') == 'without_gst' ? 'selected' : '' }}>Without GST</option>
  </select>
  @endif
  <input type="text" name="from_date" placeholder="From : dd/mm/yyyy" class="filter-pill date-picker" value="{{ request('from_date') }}" autocomplete="off" />
  <input type="text" name="to_date" placeholder="To : dd/mm/yyyy" class="filter-pill date-picker" value="{{ request('to_date') }}" autocomplete="off" />
  <button type="submit" class="filter-search" aria-label="Search">
    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
    </svg>
  </button>
  <div class="filter-right">
    @can('Invoices Management.export invoice')
      <a href="{{ route('invoices.export', request()->only(['search','invoice_type','from_date','to_date'])) }}" class="pill-btn pill-success">Excel</a>
      <a href="{{ route('invoices.export.csv', request()->only(['search','invoice_type','from_date','to_date'])) }}" class="pill-btn pill-success">CSV</a>
    @endcan
  </div>
</form>

<!-- Data Table -->
<div class="JV-datatble JV-datatble--zoom striped-surface striped-surface--full table-wrap pad-none">
  <table>
    <thead>
      <tr>
        <th style="text-align: center;">Action</th>
        <th>Serial No.</th>
        <th><x-sortable-header column="unique_code" title="Invoice No" /></th>
        <th><x-sortable-header column="invoice_date" title="Invoice Date" /></th>
        @if(!$isCustomer)
        <th><x-sortable-header column="invoice_type" title="Invoice Type" /></th>
        @endif
        <th>Proforma No</th>
        <th><x-sortable-header column="company_name" title="Bill To" /></th>
        <th>Mobile No.</th>
        <th>Grand Total</th>
        <th><x-sortable-header column="total_tax_amount" title="Total Tax" /></th>
        <th><x-sortable-header column="final_amount" title="Total Amount" /></th>
      </tr>
    </thead>
    <tbody>
      @forelse($invoices as $index => $invoice)
      <tr>
        <td style="text-align: center; vertical-align: middle;">
          <div class="action-icons">
            @can('Invoices Management.view invoice')
              <a href="{{ route('invoices.show', $invoice->id) }}" title="View Invoice" aria-label="View Invoice">
                <img class="action-icon" src="{{ asset('action_icon/view.svg') }}" alt="View">
              </a>
            @endcan
            @can('Invoices Management.edit invoice')
              <a href="{{ route('invoices.edit', $invoice->id) }}" title="Edit Invoice" aria-label="Edit Invoice">
                <img class="action-icon" src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
              </a>
            @endcan
            @can('Invoices Management.print invoice')
              <a href="{{ route('invoices.print', $invoice->id) }}" target="_blank" title="Print Invoice" aria-label="Print Invoice">
                <img class="action-icon" src="{{ asset('action_icon/print.svg') }}" alt="Print">
              </a>
            @endcan
            @can('Invoices Management.delete invoice')
              <button type="button" onclick="confirmDelete({{ $invoice->id }})" title="Delete Invoice" aria-label="Delete Invoice">
                <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
              </button>
            @endcan
          </div>
        </td>
        <td>{{ $invoices->firstItem() + $index }}</td>
        <td>{{ $invoice->unique_code }}</td>
        <td>{{ $invoice->invoice_date ? $invoice->invoice_date->format('d-m-Y') : '-' }}</td>
        @if(!$isCustomer)
        <td>
          @if($invoice->invoice_type == 'gst')
            <span style="background: #E8F0FC; color: #456DB5; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">GST</span>
          @else
            <span style="background: #FEF3C7; color: #92400E; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Without GST</span>
          @endif
        </td>
        @endif
        <td>{{ $invoice->proforma ? $invoice->proforma->unique_code : '-' }}</td>
        <td>{{ $invoice->company_name }}</td>
        <td>{{ display_mobile($invoice->mobile_no) ?? '-' }}</td>
        <td>₹{{ number_format($invoice->sub_total ?? 0, 2) }}</td>
        <td>₹{{ number_format($invoice->total_tax_amount ?? 0, 2) }}</td>
        <td>₹{{ number_format($invoice->final_amount ?? 0, 2) }}</td>
      </tr>
      @empty
        <x-empty-state 
            colspan="{{ $isCustomer ? '10' : '11' }}" 
            title="No invoices found" 
            message="Try adjusting your filters or create a new invoice"
        />
      @endforelse
    </tbody>
  </table>
</div>

@endsection

@section('footer_pagination')
  @if(isset($invoices) && method_exists($invoices,'links'))
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
  {{ $invoices->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv') }}
  @endif

@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('invoices.index') }}">Invoices</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Invoice List</span>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

<script>
function confirmDelete(id) {
  Swal.fire({
    title: 'Delete this invoice?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel',
    width: '400px'
  }).then((result) => {
    if (result.isConfirmed) {
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = `{{ url('invoices') }}/${id}`;
      form.innerHTML = `
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="DELETE">
      `;
      document.body.appendChild(form);
      form.submit();
    }
  });
}
</script>
@endpush
