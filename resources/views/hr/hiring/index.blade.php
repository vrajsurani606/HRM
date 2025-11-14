@extends('layouts.macos')
@section('page_title', $page_title)

@section('content')
  <div class="hrp-card">
    
    <div class="hrp-card-body">
      <form id="filterForm" method="GET" action="{{ route('hiring.index') }}" class="jv-filter">
        <input type="date" name="from_date" class="filter-pill" placeholder="From : dd/mm/yyyy" value="{{ request('from_date') }}">
        <input type="date" name="to_date" class="filter-pill" placeholder="To : dd/mm/yyyy" value="{{ request('to_date') }}">
        <select name="gender" class="filter-pill">
          <option value="" {{ !request('gender') ? 'selected' : '' }}>All Genders</option>
          <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
          <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
          <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>Other</option>
        </select>
        <select name="experience" class="filter-pill">
          <option value="" {{ !request('experience') ? 'selected' : '' }}>All Experience</option>
          <option value="fresher" {{ request('experience') == 'fresher' ? 'selected' : '' }}>Fresher</option>
          <option value=">0" {{ request('experience') == '>0' ? 'selected' : '' }}>0+</option>
          <option value=">1" {{ request('experience') == '>1' ? 'selected' : '' }}>1+</option>
          <option value=">2" {{ request('experience') == '>2' ? 'selected' : '' }}>2+</option>
          <option value=">3" {{ request('experience') == '>3' ? 'selected' : '' }}>3+</option>
        </select>
        <button type="submit" class="filter-search" aria-label="Search">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
          </svg>
        </button>
        <div class="filter-right">
          <input type="text" name="search" class="filter-pill" placeholder="Search by name, mobile, code..." value="{{ request('search') }}">
          <a href="{{ route('hiring.index') }}" class="pill-btn pill-secondary">Reset</a>
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
                  <a href="{{ route('hiring.print', ['id' => $lead->id, 'type' => 'offerletter']) }}" title="Print Offer Letter" target="_blank" aria-label="Print Offer Letter">
                    <img src="{{ asset('action_icon/print.svg') }}" alt="Print Offer Letter" class="action-icon">
                  </a>
                <form method="POST" action="{{ route('hiring.destroy', $lead) }}" class="delete-form" style="display:inline">
                  @csrf @method('DELETE')
                  <button type="button" onclick="confirmDeleteLead(this)" title="Delete" aria-label="Delete" style="background:transparent;border:0;padding:0;line-height:0;cursor:pointer">
                    <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete" class="action-icon">
                  </button>
                </form>
                <a href="#" class="convert-btn" data-id="{{ $lead->id }}" data-name="{{ $lead->person_name }}" data-action="{{ route('hiring.convert', $lead->id) }}" title="Convert to Employee" aria-label="Convert to Employee">
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
                  <a class="hrp-link" href="{{ route('hiring.resume', $lead->id) }}" target="_blank">View</a>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // SweetAlert delete confirmation for hiring leads
  function confirmDeleteLead(button) {
    Swal.fire({
      title: 'Delete this lead?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#6b7280',
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel',
      width: '400px',
      padding: '1.5rem',
      customClass: {
        popup: 'perfect-swal-popup'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        button.closest('form').submit();
      }
    });
  }

  document.addEventListener('DOMContentLoaded', function(){
    const csrf = '{{ csrf_token() }}';
    document.querySelectorAll('.convert-btn').forEach(function(el){
      el.addEventListener('click', function(e){
        e.preventDefault();
        const name = this.getAttribute('data-name') || 'this lead';
        const action = this.getAttribute('data-action');
        Swal.fire({
          title: 'Convert to Employee?',
          text: `Do you want to convert ${name} to Employee?`,
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#10b981',
          cancelButtonColor: '#6b7280',
          confirmButtonText: 'Yes, Convert',
          cancelButtonText: 'Cancel',
          width: '400px',
          padding: '1.5rem',
          customClass: {
            popup: 'perfect-swal-popup'
          }
        }).then((result) => {
          if(result.isConfirmed){
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = action;
            const token = document.createElement('input');
            token.type = 'hidden'; token.name = '_token'; token.value = csrf; form.appendChild(token);
            document.body.appendChild(form);
            form.submit();
          }
        });
      });
    });
  });
</script>

<style>
  .perfect-swal-popup {
    font-size: 15px !important;
  }
  
  .perfect-swal-popup .swal2-title {
    font-size: 20px !important;
    font-weight: 600 !important;
    margin-bottom: 1rem !important;
  }
  
  .perfect-swal-popup .swal2-content {
    font-size: 15px !important;
    margin-bottom: 1.5rem !important;
    line-height: 1.4 !important;
  }
  
  .perfect-swal-popup .swal2-actions {
    gap: 0.75rem !important;
    margin-top: 1rem !important;
  }
  
  .perfect-swal-popup .swal2-confirm,
  .perfect-swal-popup .swal2-cancel {
    font-size: 14px !important;
    padding: 8px 16px !important;
    border-radius: 6px !important;
  }
  
  .perfect-swal-popup .swal2-icon {
    margin: 0.5rem auto 1rem !important;
  }
</style>
@endpush

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
