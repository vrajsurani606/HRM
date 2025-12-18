@extends('layouts.macos')
@section('page_title', 'Proforma List')
@section('content')

<!-- Filter Row (JV Datatable filter style) -->
<form method="GET" action="{{ route('performas.index') }}" class="jv-filter performa-filter" data-no-loader="true">
  <input type="text" name="company_name" placeholder="Bill Name" class="filter-pill" value="{{ request('company_name') }}" />
  <input type="text" name="unique_code" placeholder="Proforma No." class="filter-pill" value="{{ request('unique_code') }}" />
  <input type="text" name="mobile_no" placeholder="Mobile No." class="filter-pill" value="{{ request('mobile_no') }}" />
  <input type="text" name="from_date" placeholder="From : dd/mm/yyyy" class="filter-pill date-picker" value="{{ request('from_date') }}" autocomplete="off" />
  <input type="text" name="to_date" placeholder="To : dd/mm/yyyy" class="filter-pill date-picker" value="{{ request('to_date') }}" autocomplete="off" />
  <button type="submit" class="filter-search" aria-label="Search">
    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
    </svg>
  </button>
  <div class="filter-right">
    <input type="text" name="search" placeholder="Search here.." class="filter-pill live-search" value="{{ request('search') }}" />
    @can('Proformas Management.export proforma')
      <a href="{{ route('performas.export.csv', request()->only(['company_name','unique_code','mobile_no','from_date','to_date','search'])) }}" class="pill-btn pill-success">Excel</a>
    @endcan
    @can('Proformas Management.create proforma')
      <a href="{{ route('performas.create') }}" class="pill-btn pill-success">+ Add</a>
    @endcan
  </div>
</form>
<!-- Data Table -->
  <div class="JV-datatble JV-datatble--zoom striped-surface striped-surface--full table-wrap pad-none">
  <table>
    <thead>
      <tr>
        @if(user_has_any_action_permission('Proformas Management', ['view proforma', 'edit proforma', 'delete proforma', 'print proforma', 'convert proforma']))
          <th style="text-align: center;">Action</th>
        @endif
        <th>Serial No.</th>
        <th><x-sortable-header column="unique_code" title="Proforma No" /></th>
        <th><x-sortable-header column="proforma_date" title="Proforma Date" /></th>
        <th><x-sortable-header column="company_name" title="Bill To" /></th>
        <th>Mobile No.</th>
        <th><x-sortable-header column="sub_total" title="Grand Total" /></th>
        <th>Discount</th>
        <th>Total Tax</th>
        <th><x-sortable-header column="final_amount" title="Total Amount" /></th>
      </tr>
    </thead>
    <tbody>
      @forelse($performas as $index => $proforma)
      <tr>
        @if(user_has_any_action_permission('Proformas Management', ['view proforma', 'edit proforma', 'delete proforma', 'print proforma', 'convert proforma']))
          <td style="text-align: center; vertical-align: middle;">
            <div class="action-icons">
              @can('Proformas Management.view proforma')
                <a href="{{ route('performas.show', $proforma->id) }}" title="View Proforma" aria-label="View Proforma">
                  <img class="action-icon" src="{{ asset('action_icon/view.svg') }}" alt="View">
                </a>
              @endcan
              @can('Proformas Management.edit proforma')
                <a href="{{ route('performas.edit', $proforma->id) }}" title="Edit Proforma" aria-label="Edit Proforma">
                  <img class="action-icon" src="{{ asset('action_icon/edit.svg') }}" alt="Edit">
                </a>
              @endcan
              @can('Proformas Management.print proforma')
                <a href="{{ route('performas.print', $proforma->id) }}" target="_blank" title="Print Proforma" aria-label="Print Proforma">
                  <img class="action-icon" src="{{ asset('action_icon/print.svg') }}" alt="Print">
                </a>
              @endcan
              @can('Proformas Management.delete proforma')
                <button type="button" onclick="confirmDelete({{ $proforma->id }})" title="Delete Proforma" aria-label="Delete Proforma">
                  <img class="action-icon" src="{{ asset('action_icon/delete.svg') }}" alt="Delete">
                </button>
              @endcan
              @if($proforma->canConvert())
                @can('Proformas Management.convert proforma')
                  <a href="{{ route('performas.convert', $proforma->id) }}" title="Convert to Invoice" aria-label="Convert to Invoice">
                    <img src="{{ asset('action_icon/convert.svg') }}" alt="Convert" class="action-icon">
                  </a>
                @endcan
              @endif
            </div>
          </td>
        @endif
        <td>{{ $performas->firstItem() + $index }}</td>
        <td>{{ $proforma->unique_code }}</td>
        <td>{{ $proforma->proforma_date ? $proforma->proforma_date->format('d-m-Y') : '-' }}</td>
        <td>{{ $proforma->company_name }}</td>
        <td>{{ display_mobile($proforma->mobile_no) ?? '-' }}</td>
        <td>{{ number_format($proforma->sub_total ?? 0, 2) }}</td>
        <td>{{ number_format($proforma->discount_amount ?? 0, 2) }}</td>
        <td>{{ number_format($proforma->total_tax_amount ?? 0, 2) }}</td>
        <td>{{ number_format($proforma->final_amount ?? 0, 2) }}</td>
      </tr>
      @empty
        <x-empty-state 
            colspan="{{ user_has_any_action_permission('Proformas Management', ['view proforma', 'edit proforma', 'delete proforma', 'print proforma', 'convert proforma']) ? '10' : '9' }}" 
            title="No proformas found" 
            message="Try adjusting your filters or create a new proforma"
        />
      @endforelse
    </tbody>
  </table>
</div>

@endsection

@section('footer_pagination')
  @if(isset($performas) && method_exists($performas,'links'))
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
  {{ $performas->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv') }}
  @endif
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('performas.index') }}">Performas</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Proforma List</span>
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
    title: 'Delete this proforma?',
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
      form.action = `{{ url('performas') }}/${id}`;
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
