@extends('layouts.macos')
@section('page_title', 'Create Payroll Entry')
@section('content')
  <div class="hrp-content">
    <form action="#" method="POST" class="hrp-form" enctype="multipart/form-data">
      @csrf
      <div class="Rectangle-30 hrp-compact">
        <!-- Row 1: Basic Info - 4 columns -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
          <div>
            <label class="hrp-label">Unique Code:</label>
            <input type="text" name="unique_code" class="Rectangle-29" value="CMS/LEAD/OO22" readonly>
          </div>
          <div>
            <label class="hrp-label">Pay Date :</label>
            <input type="date" name="pay_date" class="Rectangle-29" placeholder="dd/mm/yyyy" required>
          </div>
          <div>
            <label class="hrp-label">Pay Type :</label>
            <select name="pay_type" id="payType" class="Rectangle-29-select" required>
              <option value="">Select Pay Type</option>
              <option value="salary">Salary</option>
              <option value="lightbill">Light Bill</option>
              <option value="tea_expense">Tea Expense</option>
              <option value="transportation">Transportation</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div>
            <label class="hrp-label">Prepared By:</label>
            <select name="prepared_by" class="Rectangle-29-select" required>
              <option value="">Select Person</option>
              <option value="hr_manager">HR Manager</option>
              <option value="admin">Admin</option>
              <option value="accountant">Accountant</option>
            </select>
          </div>
        </div>

        <!-- Row 2: Employee & Payment Info - 4 columns -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
          <div>
            <label class="hrp-label">Employee :</label>
            <select name="employee_id" class="Rectangle-29-select" required>
              <option value="">Select Employee</option>
              <option value="1">John Doe</option>
              <option value="2">Jane Smith</option>
              <option value="3">Mike Johnson</option>
            </select>
          </div>
          <div>
            <label class="hrp-label">Payment Mode :</label>
            <select name="payment_mode" class="Rectangle-29-select" required>
              <option value="">In Account</option>
              <option value="bank_transfer">Bank Transfer</option>
              <option value="cash">Cash</option>
              <option value="cheque">Cheque</option>
            </select>
          </div>
          <div>
            <label class="hrp-label">Bank Name :</label>
            <input type="text" name="bank_name" class="Rectangle-29" placeholder="Enter Bank Name" required>
          </div>
          <div></div>
        </div>

        <!-- Row 3: Bank Details - 2 columns -->
        <div class="grid grid-cols-2 gap-4 mb-8">
          <div>
            <label class="hrp-label">Bank Account No:</label>
            <input type="text" name="bank_account_no" class="Rectangle-29" placeholder="Enter Bank Account No" required>
          </div>
          <div>
            <label class="hrp-label">Transaction No:</label>
            <input type="text" name="transaction_no" class="Rectangle-29" placeholder="Enter Transaction No" required>
          </div>
        </div>
      </div>

      <!-- Vendor Fields (Hidden by default) -->
      <div class="Rectangle-30 hrp-compact" id="vendorFields" style="margin-top: 2rem; display: none;">
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
          <div>
            <label class="hrp-label">Vendor Name:</label>
            <input type="text" name="vendor_name" class="Rectangle-29" placeholder="Enter Vendor Name">
          </div>
          <div>
            <label class="hrp-label">Vendor Address:</label>
            <input type="text" name="vendor_address" class="Rectangle-29" placeholder="Enter Vendor Address">
          </div>
          <div>
            <label class="hrp-label">Vendor Gst No:</label>
            <input type="text" name="vendor_gst_no" class="Rectangle-29" placeholder="Enter GST No">
          </div>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
          <div>
            <label class="hrp-label">Vendor Pan No:</label>
            <input type="text" name="vendor_pan_no" class="Rectangle-29" placeholder="Enter PAN No">
          </div>
          <div>
            <label class="hrp-label">Total Bill Amount:</label>
            <input type="number" name="total_bill_amount" class="Rectangle-29" placeholder="Enter Amount" step="0.01">
          </div>
          <div></div>
        </div>
      </div>

      <!-- Second Container: Attendance & Leave Info -->
      <div class="Rectangle-30 hrp-compact" id="salaryFields" style="margin-top: 2rem;">
        <!-- Row 1: Working Days - 4 columns -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
          <div>
            <label class="hrp-label">Salary Month:</label>
            <select name="salary_month" class="Rectangle-29-select" required>
              <option value="">Select Month</option>
              <option value="01">January</option>
              <option value="02">February</option>
              <option value="03">March</option>
              <option value="04">April</option>
              <option value="05">May</option>
              <option value="06">June</option>
              <option value="07">July</option>
              <option value="08">August</option>
              <option value="09">September</option>
              <option value="10">October</option>
              <option value="11">November</option>
              <option value="12">December</option>
            </select>
          </div>
          <div>
            <label class="hrp-label">Salary Year:</label>
            <select name="salary_year" class="Rectangle-29-select" required>
              <option value="">Select Month</option>
              <option value="2024">2024</option>
              <option value="2025">2025</option>
              <option value="2026">2026</option>
            </select>
          </div>
          <div>
            <label class="hrp-label">Total Working Days:</label>
            <select name="total_working_days" class="Rectangle-29-select" required>
              <option value="">Select Month</option>
              <option value="30">30</option>
              <option value="31">31</option>
              <option value="28">28</option>
              <option value="29">29</option>
            </select>
          </div>
          <div>
            <label class="hrp-label">Attended Working Days:</label>
            <select name="attended_working_days" class="Rectangle-29-select" required>
              <option value="">Select Month</option>
              <option value="30">30</option>
              <option value="29">29</option>
              <option value="28">28</option>
              <option value="27">27</option>
            </select>
          </div>
        </div>

        <!-- Row 2: Leave Details - 4 columns -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
          <div>
            <label class="hrp-label">Taken Leave Casual(P):</label>
            <select name="taken_leave_casual" class="Rectangle-29-select">
              <option value="">Select Month</option>
              <option value="0">0</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
          </div>
          <div>
            <label class="hrp-label">Taken Leave (S):</label>
            <select name="taken_leave_sick" class="Rectangle-29-select">
              <option value="">Select Month</option>
              <option value="0">0</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
          </div>
          <div>
            <label class="hrp-label">Medical Leave:</label>
            <select name="medical_leave" class="Rectangle-29-select">
              <option value="">Select Month</option>
              <option value="0">0</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
          </div>
          <div>
            <label class="hrp-label">Balance Leave (P):</label>
            <select name="balance_leave_casual" class="Rectangle-29-select">
              <option value="">Select Month</option>
              <option value="10">10</option>
              <option value="9">9</option>
              <option value="8">8</option>
              <option value="7">7</option>
            </select>
          </div>
        </div>

        <!-- Row 3: Balance Leave (S) - 1 column -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
          <div>
            <label class="hrp-label">Balance Leave (S):</label>
            <select name="balance_leave_sick" class="Rectangle-29-select">
              <option value="">Select Month</option>
              <option value="10">10</option>
              <option value="9">9</option>
              <option value="8">8</option>
              <option value="7">7</option>
            </select>
          </div>
          <div></div>
          <div></div>
          <div></div>
        </div>
        <!-- Row 1: Basic Salary & Allowances - 4 columns -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
          <div>
            <label class="hrp-label">Basic Salary:</label>
            <input type="number" name="basic_salary" class="Rectangle-29" placeholder="00" step="0.01" required>
          </div>
          <div>
            <label class="hrp-label">Dearness Allowance:</label>
            <input type="number" name="dearness_allowance" class="Rectangle-29" placeholder="00" step="0.01">
          </div>
          <div>
            <label class="hrp-label">HRA:</label>
            <input type="number" name="hra" class="Rectangle-29" placeholder="00" step="0.01">
          </div>
          <div>
            <label class="hrp-label">Tiffin Allowance:</label>
            <input type="number" name="tiffin_allowance" class="Rectangle-29" placeholder="00" step="0.01">
          </div>
        </div>

        <!-- Row 2: More Allowances - 4 columns -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
          <div>
            <label class="hrp-label">City Compensatory Allo...:</label>
            <input type="number" name="city_compensatory_allowance" class="Rectangle-29" placeholder="00" step="0.01">
          </div>
          <div>
            <label class="hrp-label">Assistant Allowance:</label>
            <input type="number" name="assistant_allowance" class="Rectangle-29" placeholder="00" step="0.01">
          </div>
          <div>
            <label class="hrp-label">Medical Allowance:</label>
            <input type="number" name="medical_allowance" class="Rectangle-29" placeholder="00" step="0.01">
          </div>
          <div>
            <label class="hrp-label">Total Income:</label>
            <input type="number" name="total_income" class="Rectangle-29" placeholder="00" step="0.01" readonly>
          </div>
        </div>

        <!-- Row 3: Deductions - 4 columns -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
          <div>
            <label class="hrp-label">PF:</label>
            <input type="number" name="pf" class="Rectangle-29" placeholder="00" step="0.01">
          </div>
          <div>
            <label class="hrp-label">Professional Tax:</label>
            <input type="number" name="professional_tax" class="Rectangle-29" placeholder="00" step="0.01">
          </div>
          <div>
            <label class="hrp-label">TDS:</label>
            <input type="number" name="tds" class="Rectangle-29" placeholder="00" step="0.01">
          </div>
          <div>
            <label class="hrp-label">ESIC:</label>
            <input type="number" name="esic" class="Rectangle-29" placeholder="00" step="0.01">
          </div>
        </div>

        <!-- Row 4: Final Calculations - 4 columns -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
          <div>
            <label class="hrp-label">Security Deposit:</label>
            <input type="number" name="security_deposit" class="Rectangle-29" placeholder="00" step="0.01">
          </div>
          <div>
            <label class="hrp-label">Leave Diduction:</label>
            <select name="leave_deduction" class="Rectangle-29-select">
              <option value="">Select Month</option>
              <option value="0">0</option>
              <option value="500">500</option>
              <option value="1000">1000</option>
            </select>
          </div>
          <div>
            <label class="hrp-label">Diducton Total:</label>
            <input type="number" name="deduction_total" class="Rectangle-29" placeholder="00" step="0.01" readonly>
          </div>
          <div>
            <label class="hrp-label">Net Salary:</label>
            <input type="number" name="net_salary" class="Rectangle-29" placeholder="00" step="0.01" readonly>
          </div>
        </div>

        <!-- Row 5: Resume Upload -->
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
          <div>
            <label class="hrp-label">Resume Upload:</label>
            <div class="upload-pill">
              <div class="choose">Choose File</div>
              <div class="filename">No File Chosen</div>
              <input type="file" name="resume" accept=".pdf,.doc,.docx">
            </div>
          </div>
          <div>
          <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
              <button type="button" class="inquiry-submit-btn" id="addItemBtn" style="background: #28a745;">+ Add Payroll</button>
          </div>
        </div>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Handle Pay Type Change
      const payTypeSelect = document.getElementById('payType');
      const vendorFields = document.getElementById('vendorFields');
      const salaryFields = document.getElementById('salaryFields');
      
      payTypeSelect.addEventListener('change', function() {
        if (this.value === 'salary') {
          vendorFields.style.display = 'none';
          salaryFields.style.display = 'block';
        } else if (this.value === 'lightbill' || this.value === 'tea_expense' || this.value === 'transportation' || this.value === 'other') {
          vendorFields.style.display = 'block';
          salaryFields.style.display = 'none';
        } else {
          vendorFields.style.display = 'none';
          salaryFields.style.display = 'none';
        }
      });
      // Calculate Total Income
      function calculateTotalIncome() {
        const basicSalary = parseFloat(document.querySelector('input[name="basic_salary"]').value) || 0;
        const dearnessAllowance = parseFloat(document.querySelector('input[name="dearness_allowance"]').value) || 0;
        const hra = parseFloat(document.querySelector('input[name="hra"]').value) || 0;
        const tiffinAllowance = parseFloat(document.querySelector('input[name="tiffin_allowance"]').value) || 0;
        const cityAllowance = parseFloat(document.querySelector('input[name="city_compensatory_allowance"]').value) || 0;
        const assistantAllowance = parseFloat(document.querySelector('input[name="assistant_allowance"]').value) || 0;
        const medicalAllowance = parseFloat(document.querySelector('input[name="medical_allowance"]').value) || 0;

        const totalIncome = basicSalary + dearnessAllowance + hra + tiffinAllowance + cityAllowance + assistantAllowance + medicalAllowance;
        document.querySelector('input[name="total_income"]').value = totalIncome.toFixed(2);
        calculateNetSalary();
      }

      // Calculate Deduction Total
      function calculateDeductionTotal() {
        const pf = parseFloat(document.querySelector('input[name="pf"]').value) || 0;
        const professionalTax = parseFloat(document.querySelector('input[name="professional_tax"]').value) || 0;
        const tds = parseFloat(document.querySelector('input[name="tds"]').value) || 0;
        const esic = parseFloat(document.querySelector('input[name="esic"]').value) || 0;
        const securityDeposit = parseFloat(document.querySelector('input[name="security_deposit"]').value) || 0;
        const leaveDeduction = parseFloat(document.querySelector('select[name="leave_deduction"]').value) || 0;

        const deductionTotal = pf + professionalTax + tds + esic + securityDeposit + leaveDeduction;
        document.querySelector('input[name="deduction_total"]').value = deductionTotal.toFixed(2);
        calculateNetSalary();
      }

      // Calculate Net Salary
      function calculateNetSalary() {
        const totalIncome = parseFloat(document.querySelector('input[name="total_income"]').value) || 0;
        const deductionTotal = parseFloat(document.querySelector('input[name="deduction_total"]').value) || 0;
        const netSalary = totalIncome - deductionTotal;
        document.querySelector('input[name="net_salary"]').value = netSalary.toFixed(2);
      }

      // Add event listeners for income fields
      const incomeFields = ['basic_salary', 'dearness_allowance', 'hra', 'tiffin_allowance', 'city_compensatory_allowance', 'assistant_allowance', 'medical_allowance'];
      incomeFields.forEach(field => {
        document.querySelector(`input[name="${field}"]`).addEventListener('input', calculateTotalIncome);
      });

      // Add event listeners for deduction fields
      const deductionFields = ['pf', 'professional_tax', 'tds', 'esic', 'security_deposit'];
      deductionFields.forEach(field => {
        document.querySelector(`input[name="${field}"]`).addEventListener('input', calculateDeductionTotal);
      });

      document.querySelector('select[name="leave_deduction"]').addEventListener('change', calculateDeductionTotal);
    });
  </script>
@endsection