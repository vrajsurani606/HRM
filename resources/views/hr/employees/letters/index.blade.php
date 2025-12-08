@extends('layouts.macos')
@section('page_title', $page_title)

@push('styles')
<style>
  /* Toggle */
  .view-toggle-group { display:flex; gap:4px; background:#f3f4f6; padding:4px; border-radius:8px; }
  .view-toggle-btn { padding:8px 12px; background:transparent; border:none; border-radius:6px; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; }
  .view-toggle-btn:hover { background:#e5e7eb; }
  .view-toggle-btn.active { background:#fff; box-shadow:0 1px 3px rgba(0,0,0,0.1); }
  .view-toggle-btn svg { color:#6b7280; }
  .view-toggle-btn.active svg { color:#3b82f6; }

  /* Grid */
  .letters-grid-view { display:none; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap:16px; padding:12px; }
  .letters-grid-view.active { display:grid; }
  .letters-list-view { display:none; }
  .letters-list-view.active { display:block; }

  .letter-grid-card { background:#fff; border-radius:12px; padding:16px 18px; box-shadow:0 1px 6px rgba(0,0,0,0.06); transition:transform .25s, box-shadow .25s; cursor:pointer; margin-top:4px; }
  .letter-grid-card:hover { transform: translateY(-4px); box-shadow:0 4px 16px rgba(0,0,0,0.12); }
  .letter-grid-header { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:10px; }
  .letter-grid-id { display:flex; align-items:center; gap:12px; min-width:0; }
  .letter-avatar { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-weight:700; color:#fff; background:linear-gradient(135deg,#3b82f6,#9333ea); font-size:18px; }
  .letter-name-type { min-width:0; }
  .letter-grid-title { font-size:16px; font-weight:700; color:#0f172a; margin:0; line-height:1.2; max-width:260px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
  .letter-type { font-size:12px; color:#6b7280; }
  .letter-chips { display:flex; gap:6px; flex-wrap:wrap; justify-content:flex-end; }
  .chip { font-size:11px; padding:4px 8px; border-radius:9999px; font-weight:600; border:1px solid #e5e7eb; background:#fff; color:#374151; }
  .chip-appointment { background:#dbeafe; border-color:#bfdbfe; color:#1e40af; }
  .chip-offer { background:#dcfce7; border-color:#bbf7d0; color:#166534; }
  .chip-joining { background:#fef3c7; border-color:#fde68a; color:#92400e; }
  .chip-experience { background:#cffafe; border-color:#a5f3fc; color:#155e75; }
  .chip-relieving { background:#ede9fe; border-color:#ddd6fe; color:#5b21b6; }
  .chip-confirmation { background:#dbeafe; border-color:#bfdbfe; color:#1e40af; }
  .chip-increment { background:#dcfce7; border-color:#bbf7d0; color:#166534; }
  .chip-warning { background:#fef3c7; border-color:#fde68a; color:#92400e; }
  .chip-termination { background:#fee2e2; border-color:#fecaca; color:#991b1b; }
  .chip-other { background:#f3f4f6; border-color:#e5e7eb; color:#374151; }
  .letter-grid-sub { font-size:12px; color:#6b7280; margin:0 0 12px; }
  .letter-grid-meta { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; padding-top:12px; border-top:1px solid #f3f4f6; }
  .letter-grid-left { flex:1; display:flex; flex-direction:column; gap:6px; }
  .meta-row { display:flex; gap:8px; align-items:flex-start; }
  .meta-label { font-size:12px; color:#6b7280; min-width:70px; }
  .meta-value { font-size:13px; color:#111827; line-height:1.4; }
  .letter-grid-actions { display:flex; gap:8px; }
  .letter-grid-action-btn { padding:8px; border:1px solid #e5e7eb; background:#fff; border-radius:6px; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; width:32px; height:32px; }
  .letter-grid-action-btn.btn-print { border-color:#10b981; background:#ecfdf5; }
  .letter-grid-action-btn.btn-print svg { color:#10b981; }
  .letter-grid-action-btn.btn-print:hover { background:#10b981; }
  .letter-grid-action-btn.btn-print:hover svg { color:#fff; }
  .letter-grid-action-btn.btn-edit { border-color:#f59e0b; background:#fffbeb; }
  .letter-grid-action-btn.btn-edit svg { color:#f59e0b; }
  .letter-grid-action-btn.btn-edit:hover { background:#f59e0b; }
  .letter-grid-action-btn.btn-edit:hover svg { color:#fff; }
  .letter-grid-action-btn.btn-delete { border-color:#ef4444; background:#fef2f2; }
  .letter-grid-action-btn.btn-delete svg { color:#ef4444; }
  .letter-grid-action-btn.btn-delete:hover { background:#ef4444; }
  .letter-grid-action-btn.btn-delete:hover svg { color:#fff; }

  /* List table alignments */
  .JV-datatble table td { vertical-align: middle; }
  .action-icons { display: inline-flex; align-items: center; gap: 8px; }
  .action-icons form { margin: 0; padding: 0; display: inline-flex; }
  .action-icons button { display: inline-flex; align-items: center; justify-content: center; padding: 0; margin: 0; line-height: 1; background: transparent; border: 0; cursor: pointer; }
  .action-icons img.action-icon { display: block; }

  /* SweetAlert styles */
  .perfect-swal-popup { font-size: 15px !important; }
  .perfect-swal-popup .swal2-title { font-size: 20px !important; font-weight: 600 !important; margin-bottom: 1rem !important; }
  .perfect-swal-popup .swal2-content { font-size: 15px !important; margin-bottom: 1.5rem !important; line-height: 1.4 !important; }
  .perfect-swal-popup .swal2-actions { gap: 0.75rem !important; margin-top: 1rem !important; }
  .perfect-swal-popup .swal2-confirm, .perfect-swal-popup .swal2-cancel { font-size: 14px !important; padding: 8px 16px !important; border-radius: 6px !important; }
  .perfect-swal-popup .swal2-icon { margin: 0.5rem auto 1rem !important; }
</style>
@endpush

@section('content')
<div class="hrp-card">
  <div class="hrp-card-body">
    <form id="filterForm" method="GET" action="{{ route('employees.letters.index', $employee) }}" class="jv-filter">
      <input type="text" name="search" class="filter-pill" placeholder="Search by title, reference..." value="{{ request('search') }}">
      <select name="type" class="filter-pill">
        <option value="" {{ !request('type') ? 'selected' : '' }}>All Types</option>
        <option value="appointment" {{ request('type') == 'appointment' ? 'selected' : '' }}>Appointment</option>
        <option value="offer" {{ request('type') == 'offer' ? 'selected' : '' }}>Offer</option>
        <option value="joining" {{ request('type') == 'joining' ? 'selected' : '' }}>Joining</option>
        <option value="experience" {{ request('type') == 'experience' ? 'selected' : '' }}>Experience</option>
        <option value="relieving" {{ request('type') == 'relieving' ? 'selected' : '' }}>Relieving</option>
        <option value="confirmation" {{ request('type') == 'confirmation' ? 'selected' : '' }}>Confirmation</option>
        <option value="increment" {{ request('type') == 'increment' ? 'selected' : '' }}>Increment</option>
        <option value="warning" {{ request('type') == 'warning' ? 'selected' : '' }}>Warning</option>
        <option value="termination" {{ request('type') == 'termination' ? 'selected' : '' }}>Termination</option>
        <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Other</option>
      </select>
      <button type="submit" class="filter-search" aria-label="Search">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
        </svg>
      </button>
      <div class="filter-right">
        <div class="view-toggle-group" style="margin-right:8px;">
          <button type="button" class="view-toggle-btn" data-view="grid" title="Grid View" aria-label="Grid View">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="3" width="7" height="7" rx="1"></rect>
              <rect x="14" y="3" width="7" height="7" rx="1"></rect>
              <rect x="3" y="14" width="7" height="7" rx="1"></rect>
              <rect x="14" y="14" width="7" height="7" rx="1"></rect>
            </svg>
          </button>
          <button type="button" class="view-toggle-btn active" data-view="list" title="List View" aria-label="List View">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="8" y1="6" x2="21" y2="6"></line>
              <line x1="8" y1="12" x2="21" y2="12"></line>
              <line x1="8" y1="18" x2="21" y2="18"></line>
              <line x1="3" y1="6" x2="3.01" y2="6"></line>
              <line x1="3" y1="12" x2="3.01" y2="12"></line>
              <line x1="3" y1="18" x2="3.01" y2="18"></line>
            </svg>
          </button>
        </div>
        <a href="{{ route('employees.letters.index', $employee) }}" class="pill-btn pill-secondary">Reset</a>
        <a href="{{ route('employees.letters.create', $employee) }}" class="pill-btn pill-success" target="_blank">+ Add</a>
      </div>
    </form>
  </div>

  <!-- Grid View -->
  <div class="letters-grid-view">
    @forelse($letters as $letter)
      @php($initial = strtoupper(mb_substr((string)($letter->title ?? 'L'), 0, 1)))
      <div class="letter-grid-card" onclick="window.open('{{ route('employees.letters.print', ['employee' => $employee, 'letter' => $letter]) }}', '_blank')" title="View letter">
        <div class="letter-grid-header">
          <div class="letter-grid-id">
            <div class="letter-avatar">{{ $initial }}</div>
            <div class="letter-name-type">
              <h3 class="letter-grid-title">{{ $letter->title }}</h3>
              <div class="letter-type">{{ $letter->reference_number }}</div>
            </div>
          </div>
          <div class="letter-chips">
            <span class="chip chip-{{ $letter->type ?? 'other' }}">{{ ucfirst(str_replace('_', ' ', $letter->type ?? 'other')) }}</span>
          </div>
        </div>
        <p class="letter-grid-sub">Issue Date: {{ $letter->issue_date->format('d M Y') }} • Generated: {{ $letter->created_at->format('d M Y') }}</p>
        <div class="letter-grid-meta">
          <div class="letter-grid-left">
            <div class="meta-row"><span class="meta-label">Employee</span><span class="meta-value">{{ $employee->name ?? 'N/A' }}</span></div>
            @if($letter->notes)
            <div class="meta-row"><span class="meta-label">Notes</span><span class="meta-value">{{ Str::limit($letter->notes, 80) }}</span></div>
            @endif
          </div>
          <div class="letter-grid-actions" onclick="event.stopPropagation()">
            <a href="{{ route('employees.letters.print', ['employee' => $employee, 'letter' => $letter]) }}" target="_blank" class="letter-grid-action-btn btn-print" title="Print" aria-label="Print">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            </a>
            <a href="{{ route('employees.letters.edit', ['employee' => $employee, 'letter' => $letter]) }}" target="_blank" class="letter-grid-action-btn btn-edit" title="Edit" aria-label="Edit">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            </a>
            <form method="POST" action="{{ route('employees.letters.destroy', ['employee' => $employee, 'letter' => $letter]) }}" class="delete-form" style="display:inline">
              @csrf @method('DELETE')
              <button type="button" class="letter-grid-action-btn btn-delete" onclick="confirmDeleteLetter(this); event.stopPropagation();" title="Delete" aria-label="Delete">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
              </button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <div class="text-center py-3">No letters found</div>
    @endforelse
  </div>

  <!-- List View -->
  <div class="letters-list-view active">
    <div class="JV-datatble JV-datatble--zoom striped-surface striped-surface--full table-wrap pad-none">
      <table>
        <thead>
          <tr>
            <th>Action</th>
            <th>Serial No.</th>
            <th>Reference No.</th>
            <th>Letter Name</th>
            <th>Type</th>
            <th>Issue Date</th>
            <th>Generated Date</th>
            <th>Employee</th>
            <th>Notes</th>
          </tr>
        </thead>
        <tbody>
          @forelse($letters as $i => $letter)
          <tr>
            <td>
              <div class="action-icons">
                <a href="{{ route('employees.letters.print', ['employee' => $employee, 'letter' => $letter]) }}" title="Print" target="_blank" aria-label="Print">
                  <img src="{{ asset('action_icon/print.svg') }}" alt="Print" class="action-icon">
                </a>
                <a href="{{ route('employees.letters.edit', ['employee' => $employee, 'letter' => $letter]) }}" title="Edit" target="_blank" aria-label="Edit">
                  <img src="{{ asset('action_icon/edit.svg') }}" alt="Edit" class="action-icon">
                </a>
                <form method="POST" action="{{ route('employees.letters.destroy', ['employee' => $employee, 'letter' => $letter]) }}" class="delete-form" style="display:inline">
                  @csrf @method('DELETE')
                  <button type="button" onclick="confirmDeleteLetter(this)" title="Delete" aria-label="Delete" style="background:transparent;border:0;padding:0;line-height:0;cursor:pointer">
                    <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete" class="action-icon">
                  </button>
                </form>
              </div>
            </td>
            <td>
              @php($sno = ($letters->currentPage()-1) * $letters->perPage() + $i + 1)
              {{ $sno }}
            </td>
            <td>{{ $letter->reference_number }}</td>
            <td>{{ $letter->title }}</td>
            <td class="capitalize">{{ str_replace('_', ' ', $letter->type ?? 'other') }}</td>
            <td>{{ $letter->issue_date->format('d M Y') }}</td>
            <td>{{ $letter->created_at->format('d M Y') }}</td>
            <td>{{ $employee->name ?? 'N/A' }}</td>
            <td>{{ $letter->notes ? Str::limit($letter->notes, 50) : '—' }}</td>
          </tr>
          @empty
            <x-empty-state 
                colspan="9" 
                title="No letters found" 
                message="Try adjusting your filters or create a new letter"
            />
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('breadcrumb')
<a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
<span class="hrp-bc-sep">›</span>
<a href="{{ route('employees.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">HRM</a>
<span class="hrp-bc-sep">›</span>
<a href="{{ route('employees.index') }}" style="color:#6b7280;text-decoration:none">Employees</a>
<span class="hrp-bc-sep">›</span>
<span class="hrp-bc-current">Employee Letters</span>
@endsection

@section('footer_pagination')
@if(isset($letters) && method_exists($letters,'links'))
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
{{ $letters->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv') }}
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // SweetAlert delete confirmation for letters
  function confirmDeleteLetter(button) {
    Swal.fire({
      title: 'Delete this letter?',
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

  // Toggle view
  document.addEventListener('DOMContentLoaded', function() {
    const viewToggleBtns = document.querySelectorAll('.view-toggle-btn');
    const lettersGridView = document.querySelector('.letters-grid-view');
    const lettersListView = document.querySelector('.letters-list-view');

    viewToggleBtns.forEach((btn) => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        const view = this.dataset.view;
        localStorage.setItem('employeeLetterView', view);

        if (view === 'grid') {
          lettersGridView.classList.add('active');
          lettersListView.classList.remove('active');
          this.classList.add('active');
          document.querySelector('.view-toggle-btn[data-view="list"]').classList.remove('active');
        } else {
          lettersGridView.classList.remove('active');
          lettersListView.classList.add('active');
          this.classList.add('active');
          document.querySelector('.view-toggle-btn[data-view="grid"]').classList.remove('active');
        }
      });
    });

    const storedView = localStorage.getItem('employeeLetterView');
    if (storedView === 'grid') {
      lettersGridView.classList.add('active');
      lettersListView.classList.remove('active');
      document.querySelector('.view-toggle-btn[data-view="grid"]').classList.add('active');
      document.querySelector('.view-toggle-btn[data-view="list"]').classList.remove('active');
    } else {
      lettersGridView.classList.remove('active');
      lettersListView.classList.add('active');
      document.querySelector('.view-toggle-btn[data-view="list"]').classList.add('active');
      document.querySelector('.view-toggle-btn[data-view="grid"]').classList.remove('active');
    }
  });
</script>
@endpush
