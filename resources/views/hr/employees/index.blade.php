@extends('layouts.macos')
@section('page_title', $page_title)

@section('content')
  <div class="hrp-card">
    <div class="hrp-card-body">
      <div class="flex flex-col sm:flex-row gap-2 sm:gap-0 justify-between items-start sm:items-center mb-3">
        <h2 class="hrp-page-title">{{ $page_title }}</h2>
        @can('employees.create')
        <a href="{{ route('employees.create') }}" class="hrp-btn hrp-btn-primary">Add Employee</a>
        @endcan
      </div>
      <div class="hrp-table-wrap">
        <table id="employees-table" class="display stripe hover w-full"></table>
      </div>
    </div>
  </div>

  <div class="hrp-breadcrumb">
    <div class="crumb">
      <a href="{{ route('dashboard') }}">Dashboard</a>  ›  Employee List
    </div>
  </div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    $('#employees-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('employees.index') }}',
      columns: [
        {title: '#', data: 'DT_RowIndex', orderable: false, searchable: false, width: '5%'},
        {title: 'Name', data: 'name'},
        {title: 'Email', data: 'email'},
        {title: 'Actions', data: 'actions', orderable: false, searchable: false, width:'18%'}
      ],
      order: [[1,'asc']],
      pageLength: 10
    });
  });
</script>
@endpush
