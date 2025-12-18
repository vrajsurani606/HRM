@extends('layouts.macos')
@section('page_title', isset($payroll) ? 'Edit Payroll Entry' : 'Create Payroll Entry')

@section('content')
@push('styles')
<!-- jQuery UI CSS for Datepicker -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<style>
  /* Layout polish */
  .payroll-section { margin-top: 20px; }
  .payroll-section .section-header { display:flex; align-items:center; justify-content:space-between; padding-bottom: 8px; margin-bottom: 12px; border-bottom: 2px solid #e5e7eb; }
  .payroll-section .section-header h4 { margin:0; font-size:14px; font-weight:700; color:#111827; }
  .payroll-section .section-header small { color:#6b7280; }
  .grid-2 { display:grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .grid-3 { display:grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
  @media (max-width: 768px){ .grid-2, .grid-3 { grid-template-columns: 1fr; } }
  .hrp-label { font-size:12px; font-weight:600; color:#374151; margin-bottom:6px; display:block; }
  .hrp-input, .Rectangle-29-select { height: 40px; }
  .summary-panel { background:#f9fafb; border:2px solid #e5e7eb; border-radius:8px; padding:14px; display:grid; grid-template-columns: repeat(3, 1fr); gap:12px; }
  .summary-panel .metric { display:flex; flex-direction:column; gap:6px; }
  .summary-panel .metric .title { font-size: 12px; color:#6b7280; font-weight:600; }
  .summary-panel .metric .value { font-size: 18px; font-weight:800; color:#111827; }
  .summary-panel .metric .value.net { color:#0891b2; }
</style>
@endpush
<!-- Card 1: Employee Details -->
<div class="hrp-card">
  <div class="Rectangle-30 hrp-compact">
    <form method="POST" action="{{ isset($payroll) ? route('payroll.update', $payroll->id) : route('payroll.store') }}" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3" id="payrollForm">
      @csrf
      @if(isset($payroll))
        @method('PUT')
      @endif
      
      <!-- Hidden fields for controller -->
      <input type="hidden" name="allowances" id="allowances_hidden" value="0">
      <input type="hidden" name="bonuses" id="bonuses_hidden" value="0">
      <input type="hidden" name="deductions" id="deductions_hidden" value="0">
      <input type="hidden" name="tax" id="tax_hidden" value="0">
      
      <!-- Employee Name and ID in One Row -->
      <div>
        <label class="hrp-label">Employee:</label>
        <select name="employee_id" id="employee_id" class="Rectangle-29 Rectangle-29-select" onchange="loadEmployeeSalaryData()">
          <option value="">Select Employee</option>
          @foreach($employees as $emp)
            <option value="{{ $emp->id }}" {{ (string)old('employee_id', isset($payroll)?$payroll->employee_id:'') === (string)$emp->id ? 'selected' : '' }}>{{ $emp->name }} - {{ $emp->code }}</option>
          @endforeach
        </select>
        @error('employee_id')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>

      <div>
        <label class="hrp-label">Employee ID:</label>
        <input name="emp_code" id="emp_code" value="{{ old('emp_code', isset($payroll) && $payroll->employee ? $payroll->employee->code : '') }}" class="hrp-input Rectangle-29" readonly placeholder="Auto-filled">
        @error('emp_code')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>

      <!-- Bank Details in One Row -->
      <div class="md:col-span-2">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-3">
          <div>
            <label class="hrp-label">Bank Name:</label>
            <input name="bank_name" id="bank_name" value="{{ old('bank_name', isset($payroll) && $payroll->employee ? ($payroll->employee->bank_name ?? '') : '') }}" placeholder="Auto-filled" class="hrp-input Rectangle-29" readonly>
            @error('bank_name')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Bank Account Number:</label>
            <input name="bank_account_no" id="bank_account_no" value="{{ old('bank_account_no', isset($payroll) && $payroll->employee ? ($payroll->employee->bank_account_no ?? '') : '') }}" placeholder="Auto-filled" class="hrp-input Rectangle-29" readonly>
            @error('bank_account_no')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">IFSC Code:</label>
            <input name="ifsc_code" id="ifsc_code" value="{{ old('ifsc_code', isset($payroll) && $payroll->employee ? ($payroll->employee->bank_ifsc ?? '') : '') }}" placeholder="Auto-filled" class="hrp-input Rectangle-29" readonly>
            @error('ifsc_code')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
        </div>
      </div>

      <!-- Salary Month and Year in One Row -->
      <div class="md:col-span-2">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
          <div>
            <label class="hrp-label">Salary Month:</label>
            <select name="month" id="month" class="Rectangle-29 Rectangle-29-select" onchange="loadEmployeeSalaryData()">
              <option value="">Select Month</option>
              @foreach($months as $m)
                @php($selMonth = old('month', isset($payroll)?$payroll->month:date('F')))
                <option value="{{ $m }}" {{ $m == $selMonth ? 'selected' : '' }}>{{ $m }}</option>
              @endforeach
            </select>
            @error('month')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Salary Year:</label>
            <select name="year" id="year" class="Rectangle-29 Rectangle-29-select" onchange="loadEmployeeSalaryData()">
              <option value="">Select Year</option>
              @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                @php($selYear = old('year', isset($payroll)?$payroll->year:date('Y')))
                <option value="{{ $y }}" {{ (int)$y === (int)$selYear ? 'selected' : '' }}>{{ $y }}</option>
              @endfor
            </select>
            @error('year')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
        </div>
      </div>

    </form>
  </div>
</div>

<!-- Card 2: Salary Details -->
<div class="hrp-card" style="margin-top: 20px;">
  <div class="Rectangle-30 hrp-compact">
    <div class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
      
      <!-- Attendance Section -->
      <div class="md:col-span-2" style="margin-bottom: 15px;">
        <div style="border-bottom: 2px solid #e5e7eb; padding-bottom: 8px; margin-bottom: 15px;">
          <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #374151;">Attendance</h4>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
          <div>
            <label class="hrp-label">Total Working Days:</label>
            <select name="total_working_days" id="total_working_days" class="Rectangle-29 Rectangle-29-select" form="payrollForm" onchange="calculateNetSalary()">
              <option value="">Select Days</option>
              @for($d = 1; $d <= 31; $d++)
                <option value="{{ $d }}" {{ (string)old('total_working_days', isset($payroll)?($payroll->total_working_days ?? ''):'') === (string)$d ? 'selected' : '' }}>{{ $d }}</option>
              @endfor
            </select>
            @error('total_working_days')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Attended Working Days:</label>
            <select name="attended_working_days" id="attended_working_days" class="Rectangle-29 Rectangle-29-select" form="payrollForm">
              <option value="">Select Days</option>
              @for($d = 0; $d <= 31; $d++)
                <option value="{{ $d }}" {{ (string)old('attended_working_days', isset($payroll)?($payroll->attended_working_days ?? ''):'') === (string)$d ? 'selected' : '' }}>{{ $d }}</option>
              @endfor
            </select>
            @error('attended_working_days')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
        </div>
      </div>

      <!-- Leave Section (Grouped: Paid vs Unpaid) -->
      <div class="md:col-span-2 payroll-section">
        <div class="section-header">
          <h4>Leave Details</h4>
          <div style="display: flex; align-items: center; gap: 10px;">
            <small>Paid: Casual/Medical/Holiday. Unpaid: Personal (deducted).</small>
            @if(isset($payroll))
            <button type="button" onclick="refreshLeaveData()" class="pill-btn" style="font-size: 11px; padding: 4px 10px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer;" title="Refresh leave data from Leave Management system">
              <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 4px;">
                <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
              </svg>
              Refresh from Leave System
            </button>
            @endif
          </div>
        </div>

        <!-- Summary Row -->
        <div class="summary-panel" style="margin-bottom:12px;">
          <div class="metric">
            <span class="title">Total Leave</span>
            <span class="value" id="badge_total_leave">0</span>
          </div>
          <div class="metric">
            <span class="title">Paid Leave</span>
            <span class="value" id="badge_paid_leave">0</span>
          </div>
          <div class="metric">
            <span class="title">Unpaid Leave</span>
            <span class="value" id="badge_unpaid_leave">0</span>
          </div>
        </div>

        <div class="grid-2">
          <!-- Paid Column -->
          <div style="background:#ffffff; border:1px solid #e5e7eb; border-radius:8px; padding:12px;">
            <div class="section-header" style="border-bottom:1px dashed #e5e7eb; margin-bottom:10px;">
              <h4 style="font-size:13px;">Paid Leave</h4>
              <small>Not deducted</small>
            </div>
            <div class="grid-3">
              <div>
                <label class="hrp-label">Casual</label>
                <input type="number" name="casual_leave" id="casual_leave" value="{{ old('casual_leave', isset($payroll)?($payroll->casual_leave ?? 0):0) }}" class="hrp-input Rectangle-29" form="payrollForm" step="0.5" min="0" max="30" oninput="updateLeaveTotals()" style="background:#f0fdf4;">
              </div>
              <div>
                <label class="hrp-label">Medical</label>
                <input type="number" name="medical_leave" id="medical_leave" value="{{ old('medical_leave', isset($payroll)?($payroll->medical_leave ?? 0):0) }}" class="hrp-input Rectangle-29" form="payrollForm" step="0.5" min="0" max="30" oninput="updateLeaveTotals()" style="background:#f0fdf4;">
              </div>
              <div>
                <label class="hrp-label">Holiday</label>
                <input type="number" name="holiday_leave" id="holiday_leave" value="{{ old('holiday_leave', isset($payroll)?($payroll->holiday_leave ?? 0):0) }}" class="hrp-input Rectangle-29" form="payrollForm" step="0.5" min="0" max="30" oninput="updateLeaveTotals()" style="background:#f0fdf4;">
              </div>
            </div>
          </div>

          <!-- Unpaid Column -->
          <div style="background:#ffffff; border:1px solid #e5e7eb; border-radius:8px; padding:12px;">
            <div class="section-header" style="border-bottom:1px dashed #e5e7eb; margin-bottom:10px;">
              <h4 style="font-size:13px;">Unpaid Leave</h4>
              <small>Deducted from salary</small>
            </div>
            <div class="grid-2">
              <div>
                <label class="hrp-label">Unpaid Leave Days</label>
                <input type="number" name="personal_leave_unpaid" id="personal_leave_unpaid" value="{{ old('personal_leave_unpaid', isset($payroll) ? ($payroll->personal_leave_unpaid ?? 0) : 0) }}" class="hrp-input Rectangle-29" form="payrollForm" step="0.5" min="0" max="30" oninput="updateLeaveTotals()">
                <small style="color: #6b7280; font-size: 10px;">Includes personal + excess casual/medical</small>
              </div>
              <div>
                <label class="hrp-label">Deduction Days</label>
                <input type="number" id="unpaid_leave_total" value="{{ isset($payroll) ? ($payroll->leave_deduction_days ?? $payroll->personal_leave_unpaid ?? 0) : 0 }}" class="hrp-input Rectangle-29" readonly style="background:#f7fafc;">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Allowances Section -->
      <div class="md:col-span-2" style="margin-bottom: 15px;">
        <div style="border-bottom: 2px solid #e5e7eb; padding-bottom: 8px; margin-bottom: 15px;">
          <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #10b981;">Allowances</h4>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
          <div>
            <label class="hrp-label">Basic Salary:</label>
            <input type="number" name="basic_salary" id="basic_salary" value="{{ old('basic_salary', isset($payroll)?$payroll->basic_salary:0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('basic_salary')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">City Compensatory Allowance:</label>
            <input type="number" name="city_allowance" id="city_allowance" value="{{ old('city_allowance', isset($payroll)?($payroll->city_allowance ?? 0):0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('city_allowance')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">HRA:</label>
            <input type="number" name="hra" id="hra" value="{{ old('hra', isset($payroll)?($payroll->hra ?? 0):0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('hra')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Medical Allowance:</label>
            <input type="number" name="medical_allowance" id="medical_allowance" value="{{ old('medical_allowance', isset($payroll)?($payroll->medical_allowance ?? 0):0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('medical_allowance')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Tiffin Allowance:</label>
            <input type="number" name="tiffin_allowance" id="tiffin_allowance" value="{{ old('tiffin_allowance', isset($payroll)?($payroll->tiffin_allowance ?? 0):0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('tiffin_allowance')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Assistant Allowance:</label>
            <input type="number" name="assistant_allowance" id="assistant_allowance" value="{{ old('assistant_allowance', isset($payroll)?($payroll->assistant_allowance ?? 0):0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('assistant_allowance')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Dearness Allowance:</label>
            <input type="number" name="dearness_allowance" id="dearness_allowance" value="{{ old('dearness_allowance', isset($payroll)?($payroll->dearness_allowance ?? 0):0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('dearness_allowance')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Bonuses:</label>
            <input type="number" name="bonuses" id="bonuses" value="{{ old('bonuses', isset($payroll)?($payroll->bonuses ?? 0):0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('bonuses')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

        </div>
      </div>

      <!-- Deductions Section -->
      <div class="md:col-span-2" style="margin-bottom: 15px;">
        <div style="border-bottom: 2px solid #e5e7eb; padding-bottom: 8px; margin-bottom: 15px;">
          <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #ef4444;">Deductions</h4>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
          <div>
            <label class="hrp-label">PF:</label>
            <input type="number" name="pf" id="pf" value="{{ old('pf', isset($payroll)?($payroll->pf ?? 0):0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('pf')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">TDS:</label>
            <input type="number" name="tds" id="tds" value="{{ old('tds', isset($payroll)?($payroll->tds ?? 0):0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('tds')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Professional Tax:</label>
            <input type="number" name="professional_tax" id="professional_tax" value="{{ old('professional_tax', isset($payroll)?($payroll->professional_tax ?? 0):0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('professional_tax')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">ESIC:</label>
            <input type="number" name="esic" id="esic" value="{{ old('esic', isset($payroll)?($payroll->esic ?? 0):0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('esic')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Security Deposit:</label>
            <input type="number" name="security_deposit" id="security_deposit" value="{{ old('security_deposit', isset($payroll)?($payroll->security_deposit ?? 0):0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('security_deposit')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Leave Deduction:</label>
            <input type="number" name="leave_deduction" id="leave_deduction" value="{{ old('leave_deduction', isset($payroll)?($payroll->leave_deduction ?? 0):0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" readonly style="background: #fef2f2;">
            @error('leave_deduction')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

        </div>
      </div>

      <!-- Summary Row: Total Income + Total Deduction + Net Salary in One Row -->
      <div class="md:col-span-2" style="margin-top: 20px; padding: 20px; background: #f9fafb; border-radius: 8px; border: 2px solid #e5e7eb;">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
          <div>
            <label class="hrp-label" style="color: #10b981; font-weight: 700; font-size: 14px;">Total Income:</label>
            <input type="number" name="total_income" id="total_income" value="{{ old('total_income', isset($payroll)?($payroll->total_income ?? 0):0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" readonly style="background: #f0fff4; font-weight: 700; font-size: 16px; color: #10b981; border-color: #10b981; border-width: 2px;">
            @error('total_income')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label" style="color: #ef4444; font-weight: 700; font-size: 14px;">Total Deduction:</label>
            <input type="number" name="deduction_total" id="deduction_total" value="{{ old('deduction_total', isset($payroll)?($payroll->deduction_total ?? 0):0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" readonly style="background: #fef2f2; font-weight: 700; font-size: 16px; color: #ef4444; border-color: #ef4444; border-width: 2px;">
            @error('deduction_total')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label" style="color: #0891b2; font-weight: 700; font-size: 14px;">Net Salary:</label>
            <input type="number" name="net_salary" id="net_salary" value="{{ old('net_salary', isset($payroll)?$payroll->net_salary:0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" readonly style="background: #ecfeff; font-weight: 700; font-size: 18px; color: #0891b2; border-color: #0891b2; border-width: 2px;">
            @error('net_salary')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
        </div>

      </div>

    </div>
  </div>
</div>

<!-- Card 3: Payment -->
<div class="hrp-card" style="margin-top: 20px;">
  <div class="Rectangle-30 hrp-compact">
    <div class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
      
      <div>
        <label class="hrp-label">Payment Status:</label>
        <select name="status" id="payment_status" class="Rectangle-29 Rectangle-29-select" form="payrollForm" onchange="togglePaymentFields()">
          @php($selStatus = old('status', isset($payroll)?$payroll->status:'pending'))
          <option value="pending" {{ $selStatus==='pending'?'selected':'' }}>Pending</option>
          <option value="paid" {{ $selStatus==='paid'?'selected':'' }}>Paid</option>
          <option value="hold" {{ $selStatus==='hold'?'selected':'' }}>Hold</option>
          <option value="cancelled" {{ $selStatus==='cancelled'?'selected':'' }}>Cancelled</option>
        </select>
        @error('status')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>

      <div id="paymentTypeField" style="display: none;">
        <label class="hrp-label">Payment Method:</label>
        <select name="payment_method" id="payment_method" class="Rectangle-29 Rectangle-29-select" form="payrollForm" onchange="toggleTransactionField()">
          <option value="">Select Method</option>
          @php($pm = old('payment_method', isset($payroll)?$payroll->payment_method:''))
          <option value="Cash" {{ $pm==='Cash'?'selected':'' }}>Cash</option>
          <option value="Bank Transfer" {{ $pm==='Bank Transfer'?'selected':'' }}>Bank Transfer</option>
          <option value="Cheque" {{ $pm==='Cheque'?'selected':'' }}>Cheque</option>
          <option value="UPI" {{ $pm==='UPI'?'selected':'' }}>UPI</option>
        </select>
        @error('payment_method')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>

      <div id="paymentDateField" style="display: none;">
        <label class="hrp-label">Payment Date:</label>
        <input type="text" name="payment_date" id="payment_date" value="{{ old('payment_date', isset($payroll)&&$payroll->payment_date ? optional($payroll->payment_date)->format('d/m/Y') : '') }}" class="hrp-input Rectangle-29 date-picker" placeholder="dd/mm/yyyy" autocomplete="off" form="payrollForm">
        @error('payment_date')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>

      <div id="transactionIdField" class="md:col-span-2" style="display: none;">
        <label class="hrp-label">Transaction ID / Reference:</label>
        <input name="transaction_id" id="transaction_id" value="{{ old('transaction_id', isset($payroll)?($payroll->transaction_id ?? ''):'') }}" placeholder="Enter Transaction ID or Reference Number" class="hrp-input Rectangle-29" form="payrollForm">
        @error('transaction_id')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>

      <div id="attachmentField" class="md:col-span-2" style="display: none;">
        <label class="hrp-label">Payment Attachment (Optional):</label>
        <input type="file" name="attachment" id="attachment" class="hrp-input Rectangle-29" form="payrollForm" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
        <small style="color: #6b7280; font-size: 11px;">Supported: PDF, JPG, PNG, DOC, DOCX (Max 5MB)</small>
        @if(isset($payroll) && $payroll->attachment)
          <div style="margin-top: 8px;">
            <a href="{{ asset($payroll->attachment) }}" target="_blank" style="color: #3b82f6; font-size: 13px; text-decoration: underline;">
              <svg style="display: inline; width: 14px; height: 14px; vertical-align: middle;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
              View Current Attachment
            </a>
          </div>
        @endif
        @error('attachment')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>

      <div class="md:col-span-2">
        <div class="hrp-actions">
          <button type="submit" form="payrollForm" class="hrp-btn hrp-btn-primary">{{ isset($payroll) ? 'Update Payroll Entry' : 'Create Payroll Entry' }}</button>
        </div>
      </div>

    </div>
  </div>
</div>

@push('scripts')
<script>
// Global functions that need to be accessible from inline handlers
function updateLeaveTotals(){
  const casual = parseFloat(document.getElementById('casual_leave')?.value || 0) || 0;
  const medical = parseFloat(document.getElementById('medical_leave')?.value || 0) || 0;
  const holiday = parseFloat(document.getElementById('holiday_leave')?.value || 0) || 0;
  const personalUnpaid = parseFloat(document.getElementById('personal_leave_unpaid')?.value || 0) || 0;
  const total = casual + medical + holiday + personalUnpaid;
  const totalEl = document.getElementById('total_leave_total');
  if (totalEl) totalEl.value = total.toFixed(1).replace(/\.0$/, '');
  
  // Summary badges
  const bTotal = document.getElementById('badge_total_leave');
  const bPaid = document.getElementById('badge_paid_leave');
  const bUnpaid = document.getElementById('badge_unpaid_leave');
  const unpaidBox = document.getElementById('unpaid_leave_total');
  const paid = casual + medical + holiday;
  if (bTotal) bTotal.textContent = total.toString();
  if (bPaid) bPaid.textContent = paid.toString();
  if (bUnpaid) bUnpaid.textContent = personalUnpaid.toString();
  if (unpaidBox) unpaidBox.value = personalUnpaid.toString();
  
  // Auto-calculate attended working days = Total Working Days - Total Leave Days
  const totalWorkingDays = parseFloat(document.getElementById('total_working_days')?.value || 0) || 0;
  if (totalWorkingDays > 0) {
    const attendedDays = Math.max(0, Math.round(totalWorkingDays - total));
    setSelectValue('attended_working_days', attendedDays);
  }
  
  calculateNetSalary();
}

// Check if we're in edit mode
const isEditMode = {{ isset($payroll) ? 'true' : 'false' }};

// Initialize on page load
(function(){
  // For CREATE mode: If all 3 are set, load employee data on page load
  // For EDIT mode: Don't auto-fetch, use saved database values
  try {
    var eid = document.getElementById('employee_id')?.value;
    var m = document.getElementById('month')?.value;
    var y = document.getElementById('year')?.value;
    
    if (!isEditMode && eid && m && y) {
      // Only auto-fetch for new payroll creation
      loadEmployeeSalaryData();
    } else if (isEditMode) {
      // For edit mode, initialize leave totals from saved database values
      // Don't auto-fetch - use the values already in the form
      setTimeout(function() {
        updateLeaveTotals();
        calculateNetSalary();
      }, 100);
    }
  } catch(e) { console.error('Init error:', e); }

  // Initialize payment fields visibility based on current status
  try { togglePaymentFields(); } catch(e) {}

  // Calculate net salary with current values
  setTimeout(function() {
    calculateNetSalary();
  }, 200);
})();

function togglePaymentFields() {
    const status = document.getElementById('payment_status').value;
    const paymentTypeField = document.getElementById('paymentTypeField');
    const paymentDateField = document.getElementById('paymentDateField');
    const transactionIdField = document.getElementById('transactionIdField');
    const attachmentField = document.getElementById('attachmentField');
    
    if (status === 'paid') {
        paymentTypeField.style.display = 'block';
        paymentDateField.style.display = 'block';
        attachmentField.style.display = 'block';
    } else {
        paymentTypeField.style.display = 'none';
        paymentDateField.style.display = 'none';
        transactionIdField.style.display = 'none';
        attachmentField.style.display = 'none';
        document.getElementById('payment_method').value = '';
        document.getElementById('payment_date').value = '';
        document.getElementById('transaction_id').value = '';
    }
}

function toggleTransactionField() {
    const method = document.getElementById('payment_method').value;
    const transactionIdField = document.getElementById('transactionIdField');
    
    if (method === 'Bank Transfer' || method === 'UPI' || method === 'Cheque') {
        transactionIdField.style.display = 'block';
    } else {
        transactionIdField.style.display = 'none';
        document.getElementById('transaction_id').value = '';
    }
}

function loadEmployeeSalaryData(forceRefresh = false) {
    const employeeId = document.getElementById('employee_id').value;
    const month = document.getElementById('month').value;
    const year = document.getElementById('year').value;
    
    console.log('Loading employee data:', { employeeId, month, year, isEditMode, forceRefresh });
    
    if (!employeeId || !month || !year) {
        console.log('Missing required fields');
        return;
    }
    
    // In edit mode, don't auto-fetch unless force refresh is requested
    if (isEditMode && !forceRefresh) {
        console.log('Edit mode: Using saved database values');
        // Just recalculate with existing values
        calculateNetSalary();
        return;
    }
    
    fetch('{{ route("payroll.get-employee-salary") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ employee_id: employeeId, month: month, year: year })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(result => {
        console.log('Result:', result);
        
        if (result.success) {
            const data = result.data;
            console.log('Employee data:', data);
            
            // Fill employee details
            document.getElementById('emp_code').value = data.emp_code || '';
            document.getElementById('bank_name').value = data.bank_name || '';
            document.getElementById('bank_account_no').value = data.bank_account_no || '';
            document.getElementById('ifsc_code').value = data.ifsc_code || '';
            
            // Fill attendance
            setSelectValue('total_working_days', data.days_in_month || 30);
            
            // Calculate attended days = total working days - total leave days
            const totalLeave = parseFloat(data.casual_leave_used || 0) + 
                              parseFloat(data.medical_leave_used || 0) + 
                              parseFloat(data.holiday_leave_used || 0) + 
                              parseFloat(data.personal_leave_used || 0);
            const attendedDays = Math.max(0, (data.days_in_month || 30) - totalLeave);
            setSelectValue('attended_working_days', Math.round(attendedDays));
            
            // Fill leave data (structured) - now using number inputs
            document.getElementById('casual_leave').value = parseFloat(data.casual_leave_used || 0);
            document.getElementById('medical_leave').value = parseFloat(data.medical_leave_used || 0);
            document.getElementById('holiday_leave').value = parseFloat(data.holiday_leave_used || 0);
            const personal = parseFloat(data.personal_leave_used || 0);
            document.getElementById('personal_leave_unpaid').value = personal;
            updateLeaveTotals();
            
            // Fill salary - Basic Salary only, rest are manual entry (default 0)
            // Only update basic salary if it's empty or zero (don't overwrite in edit mode)
            const currentBasic = parseFloat(document.getElementById('basic_salary').value) || 0;
            if (currentBasic === 0 || forceRefresh) {
                document.getElementById('basic_salary').value = data.basic_salary || 0;
            }
            
            // HRA, City Allowance, PF default to 0 - HR/Admin enters manually
            // Do NOT auto-calculate
            if (!document.getElementById('hra').value || document.getElementById('hra').value == '0.00') {
                document.getElementById('hra').value = '0.00';
            }
            if (!document.getElementById('city_allowance').value || document.getElementById('city_allowance').value == '0.00') {
                document.getElementById('city_allowance').value = '0.00';
            }
            if (!document.getElementById('pf').value || document.getElementById('pf').value == '0.00') {
                document.getElementById('pf').value = '0.00';
            }
            
            calculateNetSalary();
            
            if (typeof toastr !== 'undefined') {
                toastr.success(forceRefresh ? 'Leave data refreshed from system!' : 'Employee data loaded successfully!');
            }
            console.log('Data loaded successfully');
        } else {
            console.error('API returned success=false:', result);
            if (typeof toastr !== 'undefined') {
                toastr.error(result.message || 'Error loading employee data');
            }
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        if (typeof toastr !== 'undefined') {
            toastr.error('Error loading employee data');
        }
    });
}

// Function to manually refresh leave data from leave system
function refreshLeaveData() {
    if (confirm('This will refresh leave data from the Leave Management system. Your manually entered leave values will be overwritten. Continue?')) {
        loadEmployeeSalaryData(true);
    }
}

function setSelectValue(selectId, value) {
    const select = document.getElementById(selectId);
    if (select && select.tagName === 'SELECT') {
        for (let i = 0; i < select.options.length; i++) {
            if (select.options[i].value == value) {
                select.selectedIndex = i;
                break;
            }
        }
    } else if (select) {
        select.value = value;
    }
}

function calculateNetSalary() {
    // Get earnings
    const basicSalary = parseFloat(document.getElementById('basic_salary').value) || 0;
    const hra = parseFloat(document.getElementById('hra').value) || 0;
    const cityAllowance = parseFloat(document.getElementById('city_allowance').value) || 0;
    const medicalAllowance = parseFloat(document.getElementById('medical_allowance').value) || 0;
    const tiffinAllowance = parseFloat(document.getElementById('tiffin_allowance').value) || 0;
    const assistantAllowance = parseFloat(document.getElementById('assistant_allowance').value) || 0;
    const dearnessAllowance = parseFloat(document.getElementById('dearness_allowance').value) || 0;
    const bonuses = parseFloat(document.getElementById('bonuses').value) || 0;
    
    // Calculate total allowances (everything except basic salary)
    const allowances = hra + cityAllowance + medicalAllowance + tiffinAllowance + assistantAllowance + dearnessAllowance;
    const totalIncome = basicSalary + allowances + bonuses;
    document.getElementById('total_income').value = totalIncome.toFixed(2);
    
    // Update hidden allowances field
    document.getElementById('allowances_hidden').value = allowances.toFixed(2);
    document.getElementById('bonuses_hidden').value = bonuses.toFixed(2);
    
    // Get deductions
    const pf = parseFloat(document.getElementById('pf').value) || 0;
    const tds = parseFloat(document.getElementById('tds').value) || 0;
    const professionalTax = parseFloat(document.getElementById('professional_tax').value) || 0;
    const esic = parseFloat(document.getElementById('esic').value) || 0;
    const securityDeposit = parseFloat(document.getElementById('security_deposit').value) || 0;
    
    // Calculate leave deduction (only for unpaid personal leave)
    const personalLeaveUnpaid = parseFloat(document.getElementById('personal_leave_unpaid').value) || 0;
    const totalWorkingDays = parseFloat(document.getElementById('total_working_days').value) || 30;
    const perDaySalary = basicSalary / totalWorkingDays;
    const leaveDeductionAmount = perDaySalary * personalLeaveUnpaid;
    
    document.getElementById('leave_deduction').value = leaveDeductionAmount.toFixed(2);
    
    const totalDeductions = pf + tds + professionalTax + esic + securityDeposit + leaveDeductionAmount;
    document.getElementById('deduction_total').value = totalDeductions.toFixed(2);
    
    // Update hidden deductions and tax fields
    document.getElementById('deductions_hidden').value = totalDeductions.toFixed(2);
    document.getElementById('tax_hidden').value = professionalTax.toFixed(2);
    
    const netSalary = totalIncome - totalDeductions;
    document.getElementById('net_salary').value = netSalary.toFixed(2);
}

// Form submission handler
document.getElementById('payrollForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate required fields
    const employeeId = document.getElementById('employee_id').value;
    const month = document.getElementById('month').value;
    const year = document.getElementById('year').value;
    const basicSalary = document.getElementById('basic_salary').value;
    
    if (!employeeId || !month || !year || !basicSalary) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'Please fill all required fields',
            confirmButtonColor: '#ef4444',
            width: '400px',
            padding: '1.5rem',
            customClass: { popup: 'perfect-swal-popup' }
        });
        return;
    }
    
    // Get form data
    const formData = new FormData(this);
    const url = this.action;
    const method = this.querySelector('input[name="_method"]') ? 'PUT' : 'POST';
    
    // Show loading
    Swal.fire({
        title: 'Processing...',
        text: 'Please wait while we save the payroll',
        allowOutsideClick: false,
        allowEscapeKey: false,
        width: '400px',
        padding: '1.5rem',
        customClass: { popup: 'perfect-swal-popup' },
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Submit via AJAX
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: result.message || 'Payroll saved successfully!',
                confirmButtonColor: '#10b981',
                width: '400px',
                padding: '1.5rem',
                customClass: { popup: 'perfect-swal-popup' }
            }).then(() => {
                window.location.href = '{{ route("payroll.index") }}';
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Already Exists',
                text: result.message || 'This payroll entry already exists',
                confirmButtonColor: '#f59e0b',
                width: '400px',
                padding: '1.5rem',
                customClass: { popup: 'perfect-swal-popup' }
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An unexpected error occurred. Please try again.',
            confirmButtonColor: '#ef4444',
            width: '400px',
            padding: '1.5rem',
            customClass: { popup: 'perfect-swal-popup' }
        });
    });
});

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
    $('#payrollForm').on('submit', function(e) {
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
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('payroll.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Payroll</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Create Payroll</span>
@endsection

