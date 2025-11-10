@extends('layouts.macos')
@section('page_title', $page_title)

@section('content')
  <div class="hrp-card">
    <div class="hrp-card-header flex items-center justify-between gap-4">
      <h2 class="hrp-card-title">Hiring Lead Master</h2>
    </div>
    <div class="hrp-card-body">
      <div class="flex flex-wrap items-center gap-3 mb-3">
        <input type="date" class="hrp-input Rectangle-29" style="max-width:220px" placeholder="From: dd/mm/yyyy">
        <input type="date" class="hrp-input Rectangle-29" style="max-width:220px" placeholder="To: dd/mm/yyyy">
        <select class="hrp-input Rectangle-29 Rectangle-29-select" style="max-width:220px">
          <option value="">Select Gender</option>
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>
        <select class="hrp-input Rectangle-29 Rectangle-29-select" style="max-width:220px">
          <option value="">Select Experience</option>
          <option value="fresher">Fresher</option>
          <option value=">0">0+</option>
          <option value=">1">1+</option>
          <option value=">2">2+</option>
          <option value=">3">3+</option>
        </select>
        <div class="ml-auto flex items-center gap-3" style="margin-left:auto">
          <input id="globalSearch" class="hrp-input Rectangle-29" style="max-width:320px" placeholder="Search here...">
          <a href="{{ route('hiring.create') }}" class="hrp-btn hrp-btn-primary">+ Add</a>
        </div>
      </div>
      <div class="hrp-table-wrap">
      <table id="hiringTable" class="table table-striped table-hover hrp-table" style="width:100%">
        <thead>
          <tr>
            <th>Action</th>
            <th>Serial No.</th>
            <th>Hiring Lead Code</th>
            <th>Person Name</th>
            <th>Mo. No.</th>
            <th>Address</th>
            <th>Position</th>
            <th>Is Exp.?</th>
            <th>Exp.</th>
            <th>Pre. Company</th>
            <th>Pre. Salary</th>
            <th>Gender</th>
            <th>Resume</th>
          </tr>
        </thead>
        <tbody>
          @forelse($leads as $i => $lead)
            <tr>
              <td class="whitespace-nowrap">
                <div style="display:inline-flex;align-items:center;gap:8px">
                  <a href="{{ route('hiring.edit', $lead) }}" title="Edit" aria-label="Edit" style="display:inline-flex;width:20px;height:20px;align-items:center;justify-content:center">
                    <img src="{{ asset('action_icon/edit.svg') }}" alt="Edit" width="17" height="18" style="display:block">
                  </a>
                  <a href="#" title="Print" aria-label="Print" style="display:inline-flex;width:20px;height:20px;align-items:center;justify-content:center">
                    <img src="{{ asset('action_icon/print.svg') }}" alt="Print" width="18" height="18" style="display:block">
                  </a>
                  <form method="POST" action="{{ route('hiring.destroy', $lead) }}" onsubmit="return confirm('Delete this lead?')" style="display:inline-flex;width:20px;height:20px;align-items:center;justify-content:center">
                    @csrf @method('DELETE')
                    <button type="submit" title="Delete" aria-label="Delete" style="background:transparent;border:0;padding:0;line-height:0;cursor:pointer;display:inline-flex;width:20px;height:20px;align-items:center;justify-content:center">
                      <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete" width="15" height="18" style="display:block">
                    </button>
                  </form>
                  <a href="#" title="Convert to Employee" aria-label="Convert to Employee" style="display:inline-flex;width:20px;height:20px;align-items:center;justify-content:center">
                    <img src="{{ asset('action_icon/convert.svg') }}" alt="Convert" width="18" height="18" style="display:block">
                  </a>
                </div>
              </td>
              <td>{{ ($leads->currentPage()-1) * $leads->perPage() + $i + 1 }}</td>
              <td>{{ $lead->unique_code }}</td>
              <td>{{ $lead->person_name }}</td>
              <td>{{ $lead->mobile_no }}</td>
              <td>{{ $lead->address }}</td>
              <td>{{ $lead->position }}</td>
              <td>{{ $lead->is_experience ? 'Yes' : 'No' }}</td>
              <td>{{ $lead->experience_count }}</td>
              <td>{{ $lead->experience_previous_company }}</td>
              <td>{{ $lead->previous_salary }}</td>
              <td class="capitalize">{{ $lead->gender }}</td>
              <td>
                @if($lead->resume_path)
                  <a class="hrp-link" href="{{ asset('storage/'.$lead->resume_path) }}" target="_blank">View</a>
                @else
                  —
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="13" class="text-center py-8">No records found</td></tr>
          @endforelse
        </tbody>
      </table>
      </div>
    </div>
    <div class="hrp-card-footer d-flex align-items-center justify-content-between gap-3 flex-wrap">
      <div id="dtLength" class="text-sm"></div>
      <div id="dtInfo" class="text-sm text-muted" style="margin-left:auto"></div>
      <div id="dtPagination"></div>
    </div>
  </div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('hiring.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">HRM</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Hiring Lead Master</span>
@endsection

@push('scripts')
  <script src="{{ asset('new_theme/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('new_theme/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
  <script>
    $(function(){
      var dt = $('#hiringTable').DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        pageLength: 25,
        order: [[1,'asc']],
        columnDefs: [
          { orderable:false, targets: [0] },
          { searchable:false, targets: [0] }
        ],
        language: {
          search: "",
          searchPlaceholder: "Search..."
        },
        dom: '<"row"<"col-sm-12"tr>>' // render table only; we'll place controls manually
      });
      // place DT controls into footer
      var $wrap = $('#hiringTable').closest('.dataTables_wrapper');
      $wrap.find('.dataTables_length').appendTo('#dtLength');
      $wrap.find('.dataTables_info').appendTo('#dtInfo');
      $wrap.find('.dataTables_paginate').appendTo('#dtPagination');

      $('#globalSearch').on('keyup change', function(){ dt.search(this.value).draw(); });
    });
  </script>
@endpush
