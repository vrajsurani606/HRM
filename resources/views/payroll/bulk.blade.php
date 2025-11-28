@extends('layouts.macos')
@section('page_title', 'Bulk Salary Generator')

@section('content')
@push('styles')
<style>
  .bulk-wrap { padding: 8px; }
  .bulk-header { display:flex; align-items:center; justify-content:space-between; padding: 10px 12px; border:1px solid #e5e7eb; border-radius:10px; background:#f8fafc; margin-bottom:14px; }
  .bulk-title { margin:0; font-size:15px; font-weight:800; color:#111827; }
  .bulk-sub { color:#6b7280; font-size:12px; }
  .grid-2 { display:grid; grid-template-columns: 1fr 1fr; gap:12px; }
  .grid-3 { display:grid; grid-template-columns: repeat(3, 1fr); gap:12px; }
  @media (max-width: 768px){ .grid-2, .grid-3 { grid-template-columns: 1fr; } }
  .panel { background:#ffffff; border:1px solid #e5e7eb; border-radius:10px; padding:12px; }
  .panel h5 { margin:0 0 8px 0; font-size:13px; color:#111827; font-weight:700; }
  .hint { color:#6b7280; font-size:12px; }
  .toolbar { display:flex; gap:8px; align-items:center; }
  .btn-mini { background:#e5e7eb; color:#111827; border:none; padding:6px 10px; border-radius:8px; font-size:12px; cursor:pointer; }
  .btn-mini:hover { background:#d1d5db; }
  .badge { background:#eef2ff; color:#3730a3; padding:4px 8px; border-radius:999px; font-weight:700; font-size:12px; }
</style>
@endpush
<div class="hrp-card bulk-wrap">
  <div class="Rectangle-30 hrp-compact">
    <div class="bulk-header">
      <div>
        <div class="bulk-title">Bulk Salary Generator</div>
        <div class="bulk-sub">Create or update salaries for a specific month and year</div>
      </div>
      <div class="toolbar">
        <span class="badge">Step 1: Month & Year</span>
        <span class="badge" style="background:#ecfeff;color:#075985;">Step 2: Employees</span>
        <span class="badge" style="background:#f0fdf4;color:#065f46;">Step 3: Generate</span>
      </div>
    </div>
    <form method="POST" action="{{ route('payroll.bulk-generate') }}" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
      @csrf

      <div class="md:col-span-2" style="border-bottom: 2px solid #e5e7eb; padding-bottom: 8px; margin-bottom: 15px; display:flex; align-items:center; justify-content:space-between;">
        <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #111827;">Bulk Salary Generator</h4>
        <small style="color:#6b7280">Generate salaries for a month & year for selected or all employees</small>
      </div>

      <div class="panel">
        <h5>Month</h5>
        <select name="month" class="Rectangle-29 Rectangle-29-select" required>
          <option value="">Select Month</option>
          @foreach($months as $m)
            <option value="{{ $m }}" {{ $m == date('F') ? 'selected' : '' }}>{{ $m }}</option>
          @endforeach
        </select>
        @error('month')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>

      <div class="panel">
        <h5>Year</h5>
        <select name="year" class="Rectangle-29 Rectangle-29-select" required>
          @for($y = date('Y'); $y >= date('Y') - 5; $y--)
            <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
          @endfor
        </select>
        @error('year')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>

      <div class="md:col-span-2 panel" style="margin-top: 4px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
          <h5 style="margin:0;">Employees</h5>
          <div class="toolbar">
            <button type="button" class="btn-mini" onclick="selectAllEmployees()">Select All</button>
            <button type="button" class="btn-mini" onclick="clearAllEmployees()">Clear</button>
          </div>
        </div>
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
          <label style="display:inline-flex; align-items:center; gap:8px; font-size:13px;">
            <input type="checkbox" name="all_employees" value="1" id="all_employees" onclick="toggleEmployeeMulti(this)">
            All Employees
          </label>
          <small class="hint">Uncheck to select specific employees below</small>
        </div>
        <select name="employee_ids[]" id="employee_ids" class="Rectangle-29 Rectangle-29-select" multiple size="10" style="min-height: 220px;">
          @foreach($employees as $emp)
            <option value="{{ $emp->id }}">{{ $emp->name }} - {{ $emp->code }}</option>
          @endforeach
        </select>
        <div style="display:flex; align-items:center; justify-content:space-between; margin-top:6px;">
          <small class="hint">Hold Ctrl (Windows) or Cmd (Mac) to select multiple.</small>
          <small class="hint">Selected: <span id="selected_count">0</span></small>
        </div>
        @error('employee_ids')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>

      <div class="panel">
        <h5>Status</h5>
        <select name="status" class="Rectangle-29 Rectangle-29-select">
          <option value="pending">Pending</option>
          <option value="paid">Paid</option>
          <option value="cancelled">Cancelled</option>
        </select>
      </div>

      <div class="panel">
        <h5>Payment Date</h5>
        <input type="date" name="payment_date" class="hrp-input Rectangle-29">
      </div>

      <div class="panel">
        <h5>Payment Method</h5>
        <select name="payment_method" class="Rectangle-29 Rectangle-29-select">
          <option value="">Select Method</option>
          <option value="Bank Transfer">Bank Transfer</option>
          <option value="Cash">Cash</option>
          <option value="Cheque">Cheque</option>
          <option value="UPI">UPI</option>
        </select>
      </div>

      <div class="md:col-span-2" style="margin-top:6px;">
        <div class="hrp-actions">
          <button type="submit" class="hrp-btn hrp-btn-primary">Generate Salaries</button>
          <a href="{{ route('payroll.index') }}" class="hrp-btn" style="background:#e5e7eb; color:#111827;">Back to List</a>
        </div>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  function toggleEmployeeMulti(cb){
    const multi = document.getElementById('employee_ids');
    if(multi){
      multi.disabled = cb.checked;
      if(cb.checked){ multi.selectedIndex = -1; updateSelectedCount(); }
    }
  }

  function selectAllEmployees(){
    const multi = document.getElementById('employee_ids');
    const all = document.getElementById('all_employees');
    if(!multi || (all && all.checked)) return;
    for (let i=0;i<multi.options.length;i++){ multi.options[i].selected = true; }
    updateSelectedCount();
  }
  function clearAllEmployees(){
    const multi = document.getElementById('employee_ids');
    if(!multi) return;
    for (let i=0;i<multi.options.length;i++){ multi.options[i].selected = false; }
    updateSelectedCount();
  }
  function updateSelectedCount(){
    const multi = document.getElementById('employee_ids');
    const out = document.getElementById('selected_count');
    if(multi && out){
      let count = 0; for(let i=0;i<multi.options.length;i++){ if(multi.options[i].selected) count++; }
      out.textContent = count;
    }
  }
  (function(){
    const multi = document.getElementById('employee_ids');
    if(multi){ multi.addEventListener('change', updateSelectedCount); updateSelectedCount(); }
  })();
</script>
@endpush
@endsection
