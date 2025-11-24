@extends('layouts.macos')
@section('page_title', 'Create Payroll Entry')

@section('content')
<!-- Card 1: Employee Details -->
<div class="hrp-card">
  <div class="Rectangle-30 hrp-compact">
    <form method="POST" action="{{ route('payroll.store') }}" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3" id="payrollForm">
      @csrf
      
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
            <option value="{{ $emp->id }}">{{ $emp->name }} - {{ $emp->code }}</option>
          @endforeach
        </select>
        @error('employee_id')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>

      <div>
        <label class="hrp-label">Employee ID:</label>
        <input name="emp_code" id="emp_code" value="{{ old('emp_code') }}" class="hrp-input Rectangle-29" readonly placeholder="Auto-filled">
        @error('emp_code')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>

      <!-- Bank Details in One Row -->
      <div class="md:col-span-2">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-3">
          <div>
            <label class="hrp-label">Bank Name:</label>
            <input name="bank_name" id="bank_name" value="{{ old('bank_name') }}" placeholder="Auto-filled" class="hrp-input Rectangle-29" readonly>
            @error('bank_name')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Bank Account Number:</label>
            <input name="bank_account_no" id="bank_account_no" value="{{ old('bank_account_no') }}" placeholder="Auto-filled" class="hrp-input Rectangle-29" readonly>
            @error('bank_account_no')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">IFSC Code:</label>
            <input name="ifsc_code" id="ifsc_code" value="{{ old('ifsc_code') }}" placeholder="Auto-filled" class="hrp-input Rectangle-29" readonly>
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
                <option value="{{ $m }}" {{ $m == date('F') ? 'selected' : '' }}>{{ $m }}</option>
              @endforeach
            </select>
            @error('month')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Salary Year:</label>
            <select name="year" id="year" class="Rectangle-29 Rectangle-29-select" onchange="loadEmployeeSalaryData()">
              <option value="">Select Year</option>
              @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
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
                <option value="{{ $d }}">{{ $d }}</option>
              @endfor
            </select>
            @error('total_working_days')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Attended Working Days:</label>
            <select name="attended_working_days" id="attended_working_days" class="Rectangle-29 Rectangle-29-select" form="payrollForm">
              <option value="">Select Days</option>
              @for($d = 0; $d <= 31; $d++)
                <option value="{{ $d }}">{{ $d }}</option>
              @endfor
            </select>
            @error('attended_working_days')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
        </div>
      </div>

      <!-- Leave Section -->
      <div class="md:col-span-2" style="margin-bottom: 15px;">
        <div style="border-bottom: 2px solid #e5e7eb; padding-bottom: 8px; margin-bottom: 15px;">
          <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #374151;">Leave Details</h4>
        </div>
        
        <!-- Total Leave -->
        <div style="margin-bottom: 12px;">
          <p style="margin: 0 0 8px 0; font-size: 13px; font-weight: 600; color: #6b7280;">Total Leave</p>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-3">
            <div>
              <label class="hrp-label">Casual Leave:</label>
              <select name="casual_leave" id="casual_leave" class="Rectangle-29 Rectangle-29-select" form="payrollForm">
                <option value="">Select Days</option>
                @for($d = 0; $d <= 30; $d++)
                  <option value="{{ $d }}">{{ $d }}</option>
                @endfor
              </select>
              @error('casual_leave')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>

            <div>
              <label class="hrp-label">Medical Leave:</label>
              <select name="medical_leave" id="medical_leave" class="Rectangle-29 Rectangle-29-select" form="payrollForm">
                <option value="">Select Days</option>
                @for($d = 0; $d <= 30; $d++)
                  <option value="{{ $d }}">{{ $d }}</option>
                @endfor
              </select>
              @error('medical_leave')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>

            <div>
              <label class="hrp-label">Personal Leave:</label>
              <input type="number" name="personal_leave_total" id="personal_leave_total" value="{{ old('personal_leave_total', 0) }}" placeholder="0.0" class="hrp-input Rectangle-29" form="payrollForm" step="0.5" min="0" max="30" readonly style="background: #f7fafc;">
              @error('personal_leave_total')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>
        </div>

        <!-- Paid Leave -->
        <div style="margin-bottom: 12px;">
          <p style="margin: 0 0 8px 0; font-size: 13px; font-weight: 600; color: #10b981;">Paid Leave</p>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
            <div>
              <label class="hrp-label">Casual Leave (Paid):</label>
              <select name="casual_leave_paid" id="casual_leave_paid" class="Rectangle-29 Rectangle-29-select" form="payrollForm">
                <option value="">Select Days</option>
                @for($d = 0; $d <= 30; $d++)
                  <option value="{{ $d }}">{{ $d }}</option>
                @endfor
              </select>
              @error('casual_leave_paid')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>

            <div>
              <label class="hrp-label">Medical Leave (Paid):</label>
              <select name="medical_leave_paid" id="medical_leave_paid" class="Rectangle-29 Rectangle-29-select" form="payrollForm">
                <option value="">Select Days</option>
                @for($d = 0; $d <= 30; $d++)
                  <option value="{{ $d }}">{{ $d }}</option>
                @endfor
              </select>
              @error('medical_leave_paid')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>
        </div>

        <!-- Unpaid Leave -->
        <div style="margin-bottom: 12px;">
          <p style="margin: 0 0 8px 0; font-size: 13px; font-weight: 600; color: #ef4444;">Unpaid Leave</p>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3">
            <div>
              <label class="hrp-label">Personal Leave (Unpaid):</label>
              <input type="number" name="personal_leave_unpaid" id="personal_leave_unpaid" value="{{ old('personal_leave_unpaid', 0) }}" placeholder="0.0" class="hrp-input Rectangle-29" form="payrollForm" step="0.5" min="0" max="30" oninput="calculateNetSalary()" readonly style="background: #fef2f2;">
              @error('personal_leave_unpaid')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>

            <div>
              <label class="hrp-label">Balance Leave:</label>
              <select name="balance_leave" id="balance_leave" class="Rectangle-29 Rectangle-29-select" form="payrollForm">
                <option value="">Select Days</option>
                @for($d = 0; $d <= 30; $d++)
                  <option value="{{ $d }}">{{ $d }}</option>
                @endfor
              </select>
              @error('balance_leave')<small class="hrp-error">{{ $message }}</small>@enderror
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
            <input type="number" name="basic_salary" id="basic_salary" value="{{ old('basic_salary', 0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('basic_salary')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">City Compensatory Allowance:</label>
            <input type="number" name="city_allowance" id="city_allowance" value="{{ old('city_allowance', 0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('city_allowance')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">HRA:</label>
            <input type="number" name="hra" id="hra" value="{{ old('hra', 0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('hra')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Medical Allowance:</label>
            <input type="number" name="medical_allowance" id="medical_allowance" value="{{ old('medical_allowance', 0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('medical_allowance')<small class="hrp-error">{{ $message }}</small>@enderror
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
            <input type="number" name="pf" id="pf" value="{{ old('pf', 0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('pf')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">TDS:</label>
            <input type="number" name="tds" id="tds" value="{{ old('tds', 0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('tds')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Professional Tax:</label>
            <input type="number" name="professional_tax" id="professional_tax" value="{{ old('professional_tax', 0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('professional_tax')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">ESIC:</label>
            <input type="number" name="esic" id="esic" value="{{ old('esic', 0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('esic')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Security Deposit:</label>
            <input type="number" name="security_deposit" id="security_deposit" value="{{ old('security_deposit', 0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            @error('security_deposit')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label">Leave Deduction:</label>
            <input type="number" name="leave_deduction" id="leave_deduction" value="{{ old('leave_deduction', 0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" readonly style="background: #fef2f2;">
            @error('leave_deduction')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

        </div>
      </div>

      <!-- Summary Row: Total Income + Total Deduction + Net Salary in One Row -->
      <div class="md:col-span-2" style="margin-top: 20px; padding: 20px; background: #f9fafb; border-radius: 8px; border: 2px solid #e5e7eb;">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
          <div>
            <label class="hrp-label" style="color: #10b981; font-weight: 700; font-size: 14px;">Total Income:</label>
            <input type="number" name="total_income" id="total_income" value="{{ old('total_income', 0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" readonly style="background: #f0fff4; font-weight: 700; font-size: 16px; color: #10b981; border-color: #10b981; border-width: 2px;">
            @error('total_income')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label" style="color: #ef4444; font-weight: 700; font-size: 14px;">Total Deduction:</label>
            <input type="number" name="deduction_total" id="deduction_total" value="{{ old('deduction_total', 0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" readonly style="background: #fef2f2; font-weight: 700; font-size: 16px; color: #ef4444; border-color: #ef4444; border-width: 2px;">
            @error('deduction_total')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div>
            <label class="hrp-label" style="color: #0891b2; font-weight: 700; font-size: 14px;">Net Salary:</label>
            <input type="number" name="net_salary" id="net_salary" value="{{ old('net_salary', 0) }}" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" readonly style="background: #ecfeff; font-weight: 700; font-size: 18px; color: #0891b2; border-color: #0891b2; border-width: 2px;">
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
          <option value="pending" selected>Pending</option>
          <option value="paid">Paid</option>
          <option value="cancelled">Cancelled</option>
        </select>
        @error('status')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>

      <div id="paymentTypeField" style="display: none;">
        <label class="hrp-label">Payment Method:</label>
        <select name="payment_method" id="payment_method" class="Rectangle-29 Rectangle-29-select" form="payrollForm" onchange="toggleTransactionField()">
          <option value="">Select Method</option>
          <option value="Cash">Cash</option>
          <option value="Bank Transfer">Bank Transfer</option>
          <option value="Cheque">Cheque</option>
          <option value="UPI">UPI</option>
        </select>
        @error('payment_method')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>

      <div id="paymentDateField" style="display: none;">
        <label class="hrp-label">Payment Date:</label>
        <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date') }}" class="hrp-input Rectangle-29" form="payrollForm">
        @error('payment_date')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>

      <div id="transactionIdField" class="md:col-span-2" style="display: none;">
        <label class="hrp-label">Transaction ID / Reference:</label>
        <input name="transaction_id" id="transaction_id" value="{{ old('transaction_id') }}" placeholder="Enter Transaction ID or Reference Number" class="hrp-input Rectangle-29" form="payrollForm">
        @error('transaction_id')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>

      <div class="md:col-span-2">
        <div class="hrp-actions">
          <button type="submit" form="payrollForm" class="hrp-btn hrp-btn-primary">Create Payroll Entry</button>
        </div>
      </div>

    </div>
  </div>
</div>

@push('scripts')
<script>
(function(){
  calculateNetSalary();
})();

function togglePaymentFields() {
    const status = document.getElementById('payment_status').value;
    const paymentTypeField = document.getElementById('paymentTypeField');
    const paymentDateField = document.getElementById('paymentDateField');
    const transactionIdField = document.getElementById('transactionIdField');
    
    if (status === 'paid') {
        paymentTypeField.style.display = 'block';
        paymentDateField.style.display = 'block';
    } else {
        paymentTypeField.style.display = 'none';
        paymentDateField.style.display = 'none';
        transactionIdField.style.display = 'none';
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

function loadEmployeeSalaryData() {
    const employeeId = document.getElementById('employee_id').value;
    const month = document.getElementById('month').value;
    const year = document.getElementById('year').value;
    
    console.log('Loading employee data:', { employeeId, month, year });
    
    if (!employeeId || !month || !year) {
        console.log('Missing required fields');
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
            setSelectValue('attended_working_days', data.working_days || 0);
            
            // Fill leave data
            console.log('Setting leave values:', {
                casual: data.casual_leave_used,
                medical: data.medical_leave_used,
                personal: data.personal_leave_used,
                balance: data.paid_leave_balance
            });
            
            // Total Leave section
            setSelectValue('casual_leave', data.casual_leave_used || 0);
            setSelectValue('medical_leave', data.medical_leave_used || 0);
            // Personal Leave - use direct value for decimal support (7.5, etc)
            document.getElementById('personal_leave_total').value = data.personal_leave_used || 0;
            
            // Paid Leave section
            setSelectValue('casual_leave_paid', data.casual_leave_used || 0);
            setSelectValue('medical_leave_paid', data.medical_leave_used || 0);
            
            // Unpaid Leave section - use direct value for decimal support
            document.getElementById('personal_leave_unpaid').value = data.personal_leave_used || 0;
            setSelectValue('balance_leave', data.paid_leave_balance || 12);
            
            // Fill salary - Basic Salary only, rest are manual entry (default 0)
            document.getElementById('basic_salary').value = data.basic_salary || 0;
            
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
                toastr.success('Employee data loaded successfully!');
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
    
    // Calculate total allowances (everything except basic salary)
    const allowances = hra + cityAllowance + medicalAllowance;
    const totalIncome = basicSalary + allowances;
    document.getElementById('total_income').value = totalIncome.toFixed(2);
    
    // Update hidden allowances field
    document.getElementById('allowances_hidden').value = allowances.toFixed(2);
    
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
        if (typeof toastr !== 'undefined') {
            toastr.error('Please fill all required fields');
        } else {
            toastr.error('Please fill all required fields');
        }
        return;
    }
    
    // Submit the form
    this.submit();
});
</script>
@endpush
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('payroll.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Payroll</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Create Payroll</span>
@endsection

