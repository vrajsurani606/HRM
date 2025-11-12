@extends('layouts.macos')
@section('page_title', $page_title)

@section('content')
  <div class="hrp-card">
    
    <div class="hrp-card-body">
      <div class="jv-filter">
        <input type="date" class="filter-pill" placeholder="From : dd/mm/yyyy">
        <input type="date" class="filter-pill" placeholder="To : dd/mm/yyyy">
        <select class="filter-pill" required>
          <option value="" disabled selected>Select Gender</option>
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>
        <select class="filter-pill" required>
          <option value="" disabled selected>Select Experience</option>
          <option value="fresher">Fresher</option>
          <option value=">0">0+</option>
          <option value=">1">1+</option>
          <option value=">2">2+</option>
          <option value=">3">3+</option>
        </select>
        <button type="button" class="filter-search" aria-label="Search">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
          </svg>
        </button>
        <div class="filter-right">
          <input id="globalSearch" class="filter-pill" placeholder="Search here...">
          <a href="{{ route('hiring.create') }}" class="pill-btn pill-success">+ Add</a>
        </div>
      </div>
        <div class="JV-datatble JV-datatble--zoom striped-surface striped-surface--full table-wrap pad-none">
      <table>
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
              <td>
                <a href="{{ route('hiring.edit', $lead) }}" title="Edit" aria-label="Edit">
                  <img src="{{ asset('action_icon/edit.svg') }}" alt="Edit" class="action-icon">
                </a>
                @if(\Illuminate\Support\Facades\Route::has('hiring.print'))
                  <a href="{{ route('hiring.print', ['id' => $lead->id, 'type' => 'details']) }}" title="Print Details" target="_blank" aria-label="Print Details">
                    <img src="{{ asset('action_icon/print.svg') }}" alt="Print" class="action-icon">
                  </a>
                @endif
                <form method="POST" action="{{ route('hiring.destroy', $lead) }}" onsubmit="return confirm('Delete this lead?')" style="display:inline">
                  @csrf @method('DELETE')
                  <button type="submit" title="Delete" aria-label="Delete" style="background:transparent;border:0;padding:0;line-height:0;cursor:pointer">
                    <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete" class="action-icon">
                  </button>
                </form>
                <a href="#" title="Convert to Employee" aria-label="Convert to Employee">
                  <img src="{{ asset('action_icon/convert.svg') }}" alt="Convert" class="action-icon">
                </a>
              </td>
              <td>
                @php($sno = ($leads->currentPage()-1) * $leads->perPage() + $i + 1)
                {{ $sno }}
              </td>
              <td>{{ $lead->unique_code }}</td>
              <td>{{ $lead->person_name }}</td>
              <td>{{ $lead->mobile_no }}</td>
              <td>{{ $lead->address }}</td>
              <td>{{ $lead->position }}</td>
              <td>
                @if($lead->is_experience)
                  <span style="display:inline-flex;align-items:center;gap:6px;background:#e8f7ef;color:#0ea05d;font-weight:800;font-size:12px;padding:6px 10px;border-radius:9999px;">
                    <span style="width:8px;height:8px;border-radius:9999px;background:#0ea05d;display:inline-block"></span> Yes
                  </span>
                @else
                  <span style="display:inline-flex;align-items:center;gap:6px;background:#f3f4f6;color:#6b7280;font-weight:800;font-size:12px;padding:6px 10px;border-radius:9999px;">
                    <span style="width:8px;height:8px;border-radius:9999px;background:#9ca3af;display:inline-block"></span> No
                  </span>
                @endif
              </td>
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

@section('footer_pagination')
  @if(isset($leads) && method_exists($leads,'links'))
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
    {{ $leads->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv') }}
  @endif
@endsection
