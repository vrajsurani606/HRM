@extends('layouts.macos')
@section('page_title', 'Bulk Salary Generator')

@section('content')
@push('styles')
<!-- jQuery UI CSS for Datepicker -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<style>
  /* Page Header */
  .page-header-bulk {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    padding: 24px;
    border-radius: 12px;
    margin-bottom: 24px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  }
  .page-header-bulk h1 {
    margin: 0 0 8px 0;
    font-size: 24px;
    font-weight: 700;
    color: #ffffff;
  }
  .page-header-bulk p {
    margin: 0;
    font-size: 14px;
    color: #dbeafe;
  }
  
  /* Step Cards */
  .step-card {
    background: #ffffff;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 20px;
    position: relative;
    transition: all 0.3s ease;
  }
  .step-card:hover {
    border-color: #3b82f6;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
  }
  .step-number {
    position: absolute;
    top: -12px;
    left: 24px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: #ffffff;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 16px;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.4);
  }
  .step-header {
    margin-bottom: 20px;
    padding-left: 48px;
  }
  .step-title {
    margin: 0 0 4px 0;
    font-size: 18px;
    font-weight: 700;
    color: #111827;
  }
  .step-desc {
    margin: 0;
    font-size: 13px;
    color: #6b7280;
  }
  
  /* Form Layout */
  .form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
  }
  .form-grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
  }
  @media (max-width: 768px) {
    .form-grid-2, .form-grid-3 {
      grid-template-columns: 1fr;
    }
  }
  .form-field {
    margin-bottom: 0;
  }
  .field-label {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
  }
  .field-label .required-star {
    color: #ef4444;
    font-size: 14px;
  }
  .field-icon {
    width: 16px;
    height: 16px;
    color: #6b7280;
  }
  
  /* Employee Selection Box */
  .employee-box {
    background: linear-gradient(to bottom, #f8fafc 0%, #f1f5f9 100%);
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 24px;
    width: 100%;
  }
  .employee-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
    align-items: start;
  }
  @media (max-width: 968px) {
    .employee-grid {
      grid-template-columns: 1fr;
    }
  }
  .employee-left {
    width: 100%;
  }
  .employee-right {
    width: 100%;
  }
  .checkbox-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 18px;
    background: #ffffff;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    margin-bottom: 16px;
    cursor: pointer;
    transition: all 0.2s;
  }
  .checkbox-card:hover {
    border-color: #3b82f6;
    background: #eff6ff;
  }
  .checkbox-card input[type="checkbox"] {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: #3b82f6;
  }
  .checkbox-card label {
    font-size: 15px;
    font-weight: 600;
    color: #111827;
    cursor: pointer;
    margin: 0;
    flex: 1;
  }
  .checkbox-badge {
    background: #dbeafe;
    color: #1e40af;
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 700;
  }
  .info-card {
    background: #ffffff;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 16px;
  }
  .info-card-title {
    font-size: 14px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 12px;
  }
  .info-card-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f3f4f6;
  }
  .info-card-item:last-child {
    border-bottom: none;
  }
  .info-card-label {
    font-size: 13px;
    color: #6b7280;
  }
  .info-card-value {
    font-size: 20px;
    font-weight: 800;
    color: #3b82f6;
  }
  
  /* Toolbar Buttons */
  .button-toolbar {
    display: flex;
    gap: 10px;
    margin-bottom: 14px;
    flex-wrap: wrap;
  }
  .btn-tool {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #ffffff;
    color: #374151;
    border: 1px solid #d1d5db;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
  }
  .btn-tool:hover {
    background: #3b82f6;
    color: #ffffff;
    border-color: #3b82f6;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
  }
  .btn-tool svg {
    width: 14px;
    height: 14px;
  }
  
  /* Employee List */
  .employee-list-box {
    width: 100%;
    background: #ffffff;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    min-height: 320px;
    padding: 12px;
    font-size: 14px;
    line-height: 1.6;
  }
  .employee-list-box:disabled {
    background: #f9fafb;
    cursor: not-allowed;
    opacity: 0.6;
  }
  .employee-list-box option {
    padding: 12px 10px;
    border-radius: 4px;
    margin: 3px 0;
    cursor: pointer;
  }
  .employee-list-box option:hover {
    background: #eff6ff;
  }
  
  /* Stats Bar */
  .stats-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    background: #ffffff;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    margin-top: 12px;
  }
  .stat-box {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .stat-label {
    font-size: 12px;
    color: #6b7280;
  }
  .stat-number {
    font-size: 18px;
    font-weight: 800;
    color: #3b82f6;
  }
  
  /* Info Box */
  .info-alert {
    display: flex;
    gap: 12px;
    padding: 12px 16px;
    background: #eff6ff;
    border-left: 4px solid #3b82f6;
    border-radius: 6px;
    margin-top: 12px;
  }
  .info-alert svg {
    width: 20px;
    height: 20px;
    color: #3b82f6;
    flex-shrink: 0;
  }
  .info-alert-text {
    font-size: 12px;
    color: #1e40af;
    line-height: 1.5;
  }
  
  /* Action Bar */
  .action-bar {
    display: flex;
    gap: 12px;
    align-items: center;
    padding: 20px 24px;
    background: #f9fafb;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    margin-top: 24px;
  }
  .btn-generate {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
  }
  .btn-generate:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
  }
  .btn-generate svg {
    width: 18px;
    height: 18px;
  }
</style>
@endpush
<div class="hrp-card">
  <div class="Rectangle-30 hrp-compact">
    
    <!-- Page Header -->
    <div class="page-header-bulk">
      <h1>Bulk Salary Generator</h1>
      <p>Generate salary records for multiple employees quickly and efficiently</p>
    </div>

    <form method="POST" action="{{ route('payroll.bulk-generate') }}" id="bulkSalaryForm">
      @csrf

      <!-- Step 1: Salary Period -->
      <div class="step-card">
        <div class="step-number">1</div>
        <div class="step-header">
          <h2 class="step-title">Select Salary Period</h2>
          <p class="step-desc">Choose the month and year for which you want to generate salaries</p>
        </div>
        
        <div class="form-grid-2">
          <div class="form-field">
            <label class="field-label">
              <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
              Month <span class="required-star">*</span>
            </label>
            <select name="month" id="month" class="Rectangle-29 Rectangle-29-select" required>
              <option value="">-- Select Month --</option>
              @foreach($months as $m)
                <option value="{{ $m }}" {{ $m == date('F') ? 'selected' : '' }}>{{ $m }}</option>
              @endforeach
            </select>
            @error('month')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div class="form-field">
            <label class="field-label">
              <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
              Year <span class="required-star">*</span>
            </label>
            <select name="year" id="year" class="Rectangle-29 Rectangle-29-select" required>
              <option value="">-- Select Year --</option>
              @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
              @endfor
            </select>
            @error('year')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
        </div>

        <div class="info-alert">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <div class="info-alert-text">
            The system will automatically calculate salaries based on employee's basic salary, allowances, and leave deductions for the selected period.
          </div>
        </div>
      </div>

      <!-- Step 2: Employee Selection -->
      <div class="step-card">
        <div class="step-number">2</div>
        <div class="step-header">
          <h2 class="step-title">Select Employees</h2>
          <p class="step-desc">Choose to generate for all employees or select specific ones</p>
        </div>

        <div class="employee-box">
          <!-- All Employees Option -->
          <div class="checkbox-card" onclick="document.getElementById('all_employees').click();">
            <input type="checkbox" name="all_employees" value="1" id="all_employees" onclick="event.stopPropagation(); toggleEmployeeMulti(this);" checked>
            <label for="all_employees" onclick="event.stopPropagation();">Generate for All Employees</label>
            <span class="checkbox-badge">{{ $employees->count() }} Total</span>
          </div>

          <div class="employee-grid">
            <!-- Left Side: Employee List -->
            <div class="employee-left">
              <!-- Toolbar -->
              <div class="button-toolbar">
                <button type="button" class="btn-tool" onclick="selectAllEmployees()">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  Select All
                </button>
                <button type="button" class="btn-tool" onclick="clearAllEmployees()">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  Clear All
                </button>
                <button type="button" class="btn-tool" onclick="searchEmployee()">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                  </svg>
                  Search
                </button>
              </div>

              <!-- Employee List -->
              <select name="employee_ids[]" id="employee_ids" class="employee-list-box" multiple size="15" disabled>
                @foreach($employees as $emp)
                  <option value="{{ $emp->id }}">{{ $emp->name }} ({{ $emp->code }}) - ₹{{ number_format($emp->current_offer_amount ?? 0, 0) }}</option>
                @endforeach
              </select>

              <div class="info-alert" style="margin-top: 12px;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="info-alert-text">
                  Hold <strong>Ctrl</strong> (Windows) or <strong>Cmd</strong> (Mac) to select multiple employees from the list.
                </div>
              </div>
              @error('employee_ids')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>

            <!-- Right Side: Stats & Info -->
            <div class="employee-right">
              <!-- Stats Card -->
              <div class="info-card">
                <div class="info-card-title">Selection Summary</div>
                <div class="info-card-item">
                  <span class="info-card-label">Selected Employees</span>
                  <span class="info-card-value" id="selected_count">{{ $employees->count() }}</span>
                </div>
                <div class="info-card-item">
                  <span class="info-card-label">Total Employees</span>
                  <span class="info-card-value">{{ $employees->count() }}</span>
                </div>
              </div>

              <!-- Quick Actions Info -->
              <div class="info-alert">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="info-alert-text">
                  <strong>Quick Actions:</strong><br>
                  • Use "Select All" to choose all employees<br>
                  • Use "Search" to find specific employees<br>
                  • Check "All Employees" for bulk generation
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Step 3: Payment Details -->
      <div class="step-card">
        <div class="step-number">3</div>
        <div class="step-header">
          <h2 class="step-title">Payment Details (Optional)</h2>
          <p class="step-desc">Set payment status and details if salaries are already paid</p>
        </div>

        <div class="form-grid-3">
          <div class="form-field">
            <label class="field-label">
              <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              Payment Status
            </label>
            <select name="status" id="status" class="Rectangle-29 Rectangle-29-select" onchange="togglePaymentDetails()">
              <option value="pending" selected>Pending</option>
              <option value="paid">Paid</option>
              <option value="hold">Hold</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>

          <div class="form-field" id="payment_date_group" style="display: none;">
            <label class="field-label">
              <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
              Payment Date
            </label>
            <input type="text" name="payment_date" id="payment_date" class="hrp-input Rectangle-29 date-picker" placeholder="dd/mm/yyyy" autocomplete="off">
          </div>

          <div class="form-field" id="payment_method_group" style="display: none;">
            <label class="field-label">
              <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
              </svg>
              Payment Method
            </label>
            <select name="payment_method" id="payment_method" class="Rectangle-29 Rectangle-29-select">
              <option value="">-- Select Method --</option>
              <option value="Bank Transfer">Bank Transfer</option>
              <option value="Cash">Cash</option>
              <option value="Cheque">Cheque</option>
              <option value="UPI">UPI</option>
            </select>
          </div>
        </div>

        <div class="info-alert">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <div class="info-alert-text">
            <strong>Note:</strong> If status is "Pending", salaries will be created but marked as unpaid. If "Paid", you can specify payment date and method. Existing salary records for the same period will be updated automatically.
          </div>
        </div>
      </div>

      <!-- Action Bar -->
      <div class="action-bar">
        <button type="submit" class="btn-generate">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
          Generate Salaries
        </button>
        <a href="{{ route('payroll.index') }}" class="hrp-btn" style="background:#e5e7eb; color:#111827;">
          <svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          Back to List
        </a>
      </div>
    </form>
  </div>
</div>

@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('payroll.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Payroll</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Bulk Salary Generator</span>
@endsection

@push('scripts')
<script>
  // Toggle employee selection based on "All Employees" checkbox
  function toggleEmployeeMulti(cb) {
    const multi = document.getElementById('employee_ids');
    if (multi) {
      multi.disabled = cb.checked;
      if (cb.checked) { 
        // Clear all selections when "All Employees" is checked
        for (let i = 0; i < multi.options.length; i++) {
          multi.options[i].selected = false;
        }
      }
      updateSelectedCount();
    }
  }

  // Select all employees in the list
  function selectAllEmployees() {
    const multi = document.getElementById('employee_ids');
    const all = document.getElementById('all_employees');
    if (!multi) return;
    
    // Uncheck "All Employees" and enable the list
    if (all && all.checked) {
      all.checked = false;
      multi.disabled = false;
    }
    
    // Select all options
    for (let i = 0; i < multi.options.length; i++) { 
      multi.options[i].selected = true; 
    }
    updateSelectedCount();
  }

  // Clear all employee selections
  function clearAllEmployees() {
    const multi = document.getElementById('employee_ids');
    const all = document.getElementById('all_employees');
    if (!multi) return;
    
    // Uncheck "All Employees" if checked
    if (all && all.checked) {
      all.checked = false;
      multi.disabled = false;
    }
    
    // Clear all selections
    for (let i = 0; i < multi.options.length; i++) { 
      multi.options[i].selected = false; 
    }
    updateSelectedCount();
  }

  // Search employee
  function searchEmployee() {
    const searchTerm = prompt('Enter employee name or code to search:');
    if (!searchTerm) return;
    
    const multi = document.getElementById('employee_ids');
    const all = document.getElementById('all_employees');
    if (!multi) return;
    
    // Uncheck "All Employees" and enable the list
    if (all && all.checked) {
      all.checked = false;
      multi.disabled = false;
    }
    
    // Clear current selection
    for (let i = 0; i < multi.options.length; i++) { 
      multi.options[i].selected = false; 
    }
    
    // Select matching employees
    const term = searchTerm.toLowerCase();
    let found = 0;
    for (let i = 0; i < multi.options.length; i++) { 
      const text = multi.options[i].text.toLowerCase();
      if (text.includes(term)) {
        multi.options[i].selected = true;
        found++;
      }
    }
    
    updateSelectedCount();
    
    if (found === 0) {
      Swal.fire({
        icon: 'info',
        title: 'No Results',
        text: 'No employees found matching "' + searchTerm + '"',
        width: '400px',
        padding: '1.5rem',
        customClass: { popup: 'perfect-swal-popup' }
      });
    } else {
      Swal.fire({
        icon: 'success',
        title: 'Found',
        text: found + ' employee(s) found and selected',
        timer: 2000,
        showConfirmButton: false,
        width: '400px',
        padding: '1.5rem',
        customClass: { popup: 'perfect-swal-popup' }
      });
    }
  }

  // Update selected count display
  function updateSelectedCount() {
    const multi = document.getElementById('employee_ids');
    const out = document.getElementById('selected_count');
    const all = document.getElementById('all_employees');
    
    if (multi && out) {
      if (all && all.checked) {
        out.textContent = multi.options.length;
      } else {
        let count = 0; 
        for (let i = 0; i < multi.options.length; i++) { 
          if (multi.options[i].selected) count++; 
        }
        out.textContent = count;
      }
    }
  }

  // Toggle payment details based on status
  function togglePaymentDetails() {
    const status = document.getElementById('status').value;
    const dateGroup = document.getElementById('payment_date_group');
    const methodGroup = document.getElementById('payment_method_group');
    
    if (status === 'paid') {
      dateGroup.style.display = 'block';
      methodGroup.style.display = 'block';
    } else {
      dateGroup.style.display = 'none';
      methodGroup.style.display = 'none';
      document.getElementById('payment_date').value = '';
      document.getElementById('payment_method').value = '';
    }
  }

  // Form submission with validation and confirmation
  document.getElementById('bulkSalaryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const month = document.getElementById('month').value;
    const year = document.getElementById('year').value;
    const all = document.getElementById('all_employees');
    const multi = document.getElementById('employee_ids');
    
    // Validation
    if (!month || !year) {
      Swal.fire({
        icon: 'error',
        title: 'Missing Information',
        text: 'Please select both month and year',
        confirmButtonColor: '#ef4444',
        width: '400px',
        padding: '1.5rem',
        customClass: { popup: 'perfect-swal-popup' }
      });
      return;
    }
    
    let empCount = 0;
    if (all && all.checked) {
      empCount = multi ? multi.options.length : 0;
    } else if (multi) {
      for (let i = 0; i < multi.options.length; i++) { 
        if (multi.options[i].selected) empCount++; 
      }
    }
    
    if (empCount === 0) {
      Swal.fire({
        icon: 'error',
        title: 'No Employees Selected',
        text: 'Please select at least one employee or check "All Employees"',
        confirmButtonColor: '#ef4444',
        width: '400px',
        padding: '1.5rem',
        customClass: { popup: 'perfect-swal-popup' }
      });
      return;
    }
    
    // Confirmation
    Swal.fire({
      icon: 'question',
      title: 'Confirm Bulk Generation',
      html: 'You are about to generate <strong>' + empCount + ' salary record(s)</strong> for <strong>' + month + ' ' + year + '</strong>.<br><br>Existing records will be updated. Continue?',
      showCancelButton: true,
      confirmButtonText: 'Yes, Generate',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#10b981',
      cancelButtonColor: '#6b7280',
      width: '450px',
      padding: '1.5rem',
      customClass: { popup: 'perfect-swal-popup' }
    }).then((result) => {
      if (result.isConfirmed) {
        // Show loading
        Swal.fire({
          title: 'Generating Salaries...',
          html: 'Please wait while we process the salary records',
          allowOutsideClick: false,
          allowEscapeKey: false,
          width: '400px',
          padding: '1.5rem',
          customClass: { popup: 'perfect-swal-popup' },
          didOpen: () => {
            Swal.showLoading();
          }
        });
        
        // Submit form
        this.submit();
      }
    });
  });

  // Initialize
  (function() {
    const multi = document.getElementById('employee_ids');
    
    if (multi) { 
      multi.addEventListener('change', updateSelectedCount);
      updateSelectedCount(); 
    }
  })();

  // jQuery UI Datepicker initialization
  $(document).ready(function() {
      $('.date-picker').datepicker({
          dateFormat: 'dd/mm/yy',
          changeMonth: true,
          changeYear: true,
          yearRange: '-10:+10',
          maxDate: '+10y'
      });
      
      // Convert date format before form submission
      $('form').on('submit', function(e) {
          $('.date-picker').each(function() {
              const dateValue = $(this).val();
              if (dateValue && dateValue.match(/^\d{1,2}\/\d{1,2}\/\d{2,4}$/)) {
                  const parts = dateValue.split('/');
                  const day = parts[0].padStart(2, '0');
                  const month = parts[1].padStart(2, '0');
                  let year = parts[2];
                  if (year.length === 2) {
                      year = (parseInt(year) > 50 ? '19' : '20') + year;
                  }
                  $(this).val(`${year}-${month}-${day}`);
              }
          });
      });
  });
</script>
<!-- jQuery UI JS for Datepicker -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
@endpush
