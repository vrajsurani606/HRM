<?php $__env->startSection('page_title', isset($payroll) ? 'Edit Payroll Entry' : 'Create Payroll Entry'); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>
<!-- Card 1: Employee Details -->
<div class="hrp-card">
  <div class="Rectangle-30 hrp-compact">
    <form method="POST" action="<?php echo e(isset($payroll) ? route('payroll.update', $payroll->id) : route('payroll.store')); ?>" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3" id="payrollForm">
      <?php echo csrf_field(); ?>
      <?php if(isset($payroll)): ?>
        <?php echo method_field('PUT'); ?>
      <?php endif; ?>
      
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
          <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($emp->id); ?>" <?php echo e((string)old('employee_id', isset($payroll)?$payroll->employee_id:'') === (string)$emp->id ? 'selected' : ''); ?>><?php echo e($emp->name); ?> - <?php echo e($emp->code); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div>
        <label class="hrp-label">Employee ID:</label>
        <input name="emp_code" id="emp_code" value="<?php echo e(old('emp_code', isset($payroll) && $payroll->employee ? $payroll->employee->code : '')); ?>" class="hrp-input Rectangle-29" readonly placeholder="Auto-filled">
        <?php $__errorArgs = ['emp_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <!-- Bank Details in One Row -->
      <div class="md:col-span-2">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-3">
          <div>
            <label class="hrp-label">Bank Name:</label>
            <input name="bank_name" id="bank_name" value="<?php echo e(old('bank_name', isset($payroll) && $payroll->employee ? ($payroll->employee->bank_name ?? '') : '')); ?>" placeholder="Auto-filled" class="hrp-input Rectangle-29" readonly>
            <?php $__errorArgs = ['bank_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label">Bank Account Number:</label>
            <input name="bank_account_no" id="bank_account_no" value="<?php echo e(old('bank_account_no', isset($payroll) && $payroll->employee ? ($payroll->employee->bank_account_no ?? '') : '')); ?>" placeholder="Auto-filled" class="hrp-input Rectangle-29" readonly>
            <?php $__errorArgs = ['bank_account_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label">IFSC Code:</label>
            <input name="ifsc_code" id="ifsc_code" value="<?php echo e(old('ifsc_code', isset($payroll) && $payroll->employee ? ($payroll->employee->bank_ifsc ?? '') : '')); ?>" placeholder="Auto-filled" class="hrp-input Rectangle-29" readonly>
            <?php $__errorArgs = ['ifsc_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
              <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php ($selMonth = old('month', isset($payroll)?$payroll->month:date('F'))); ?>
                <option value="<?php echo e($m); ?>" <?php echo e($m == $selMonth ? 'selected' : ''); ?>><?php echo e($m); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label">Salary Year:</label>
            <select name="year" id="year" class="Rectangle-29 Rectangle-29-select" onchange="loadEmployeeSalaryData()">
              <option value="">Select Year</option>
              <?php for($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                <?php ($selYear = old('year', isset($payroll)?$payroll->year:date('Y'))); ?>
                <option value="<?php echo e($y); ?>" <?php echo e((int)$y === (int)$selYear ? 'selected' : ''); ?>><?php echo e($y); ?></option>
              <?php endfor; ?>
            </select>
            <?php $__errorArgs = ['year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
              <?php for($d = 1; $d <= 31; $d++): ?>
                <option value="<?php echo e($d); ?>" <?php echo e((string)old('total_working_days', isset($payroll)?($payroll->total_working_days ?? ''):'') === (string)$d ? 'selected' : ''); ?>><?php echo e($d); ?></option>
              <?php endfor; ?>
            </select>
            <?php $__errorArgs = ['total_working_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label">Attended Working Days:</label>
            <select name="attended_working_days" id="attended_working_days" class="Rectangle-29 Rectangle-29-select" form="payrollForm">
              <option value="">Select Days</option>
              <?php for($d = 0; $d <= 31; $d++): ?>
                <option value="<?php echo e($d); ?>" <?php echo e((string)old('attended_working_days', isset($payroll)?($payroll->attended_working_days ?? ''):'') === (string)$d ? 'selected' : ''); ?>><?php echo e($d); ?></option>
              <?php endfor; ?>
            </select>
            <?php $__errorArgs = ['attended_working_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
        </div>
      </div>

      <!-- Leave Section (Grouped: Paid vs Unpaid) -->
      <div class="md:col-span-2 payroll-section">
        <div class="section-header">
          <h4>Leave Details</h4>
          <small>Paid: Casual/Medical/Holiday. Unpaid: Personal (deducted).</small>
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
                <select name="casual_leave" id="casual_leave" class="Rectangle-29 Rectangle-29-select" form="payrollForm" onchange="updateLeaveTotals()">
                  <?php for($d = 0; $d <= 30; $d++): ?>
                    <option value="<?php echo e($d); ?>" <?php echo e((string)old('casual_leave', isset($payroll)?($payroll->casual_leave ?? 0):0) === (string)$d ? 'selected' : ''); ?>><?php echo e($d); ?></option>
                  <?php endfor; ?>
                </select>
              </div>
              <div>
                <label class="hrp-label">Medical</label>
                <select name="medical_leave" id="medical_leave" class="Rectangle-29 Rectangle-29-select" form="payrollForm" onchange="updateLeaveTotals()">
                  <?php for($d = 0; $d <= 30; $d++): ?>
                    <option value="<?php echo e($d); ?>" <?php echo e((string)old('medical_leave', isset($payroll)?($payroll->medical_leave ?? 0):0) === (string)$d ? 'selected' : ''); ?>><?php echo e($d); ?></option>
                  <?php endfor; ?>
                </select>
              </div>
              <div>
                <label class="hrp-label">Holiday</label>
                <select name="holiday_leave" id="holiday_leave" class="Rectangle-29 Rectangle-29-select" form="payrollForm" onchange="updateLeaveTotals()">
                  <?php for($d = 0; $d <= 30; $d++): ?>
                    <option value="<?php echo e($d); ?>" <?php echo e((string)old('holiday_leave', isset($payroll)?($payroll->holiday_leave ?? 0):0) === (string)$d ? 'selected' : ''); ?>><?php echo e($d); ?></option>
                  <?php endfor; ?>
                </select>
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
                <label class="hrp-label">Personal (Unpaid)</label>
                <input type="number" name="personal_leave_unpaid" id="personal_leave_unpaid" value="<?php echo e(old('personal_leave_unpaid', isset($payroll)?($payroll->personal_leave_unpaid ?? 0):0)); ?>" class="hrp-input Rectangle-29" form="payrollForm" step="0.5" min="0" max="30" oninput="updateLeaveTotals()">
              </div>
              <div>
                <label class="hrp-label">Unpaid (Auto)</label>
                <input type="number" id="unpaid_leave_total" value="0" class="hrp-input Rectangle-29" readonly style="background:#f7fafc;">
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
            <input type="number" name="basic_salary" id="basic_salary" value="<?php echo e(old('basic_salary', isset($payroll)?$payroll->basic_salary:0)); ?>" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            <?php $__errorArgs = ['basic_salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label">City Compensatory Allowance:</label>
            <input type="number" name="city_allowance" id="city_allowance" value="<?php echo e(old('city_allowance', isset($payroll)?($payroll->city_allowance ?? 0):0)); ?>" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            <?php $__errorArgs = ['city_allowance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label">HRA:</label>
            <input type="number" name="hra" id="hra" value="<?php echo e(old('hra', isset($payroll)?($payroll->hra ?? 0):0)); ?>" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            <?php $__errorArgs = ['hra'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label">Medical Allowance:</label>
            <input type="number" name="medical_allowance" id="medical_allowance" value="<?php echo e(old('medical_allowance', isset($payroll)?($payroll->medical_allowance ?? 0):0)); ?>" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            <?php $__errorArgs = ['medical_allowance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label">Tiffin Allowance:</label>
            <input type="number" name="tiffin_allowance" id="tiffin_allowance" value="<?php echo e(old('tiffin_allowance', isset($payroll)?($payroll->tiffin_allowance ?? 0):0)); ?>" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            <?php $__errorArgs = ['tiffin_allowance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label">Assistant Allowance:</label>
            <input type="number" name="assistant_allowance" id="assistant_allowance" value="<?php echo e(old('assistant_allowance', isset($payroll)?($payroll->assistant_allowance ?? 0):0)); ?>" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            <?php $__errorArgs = ['assistant_allowance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label">Dearness Allowance:</label>
            <input type="number" name="dearness_allowance" id="dearness_allowance" value="<?php echo e(old('dearness_allowance', isset($payroll)?($payroll->dearness_allowance ?? 0):0)); ?>" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            <?php $__errorArgs = ['dearness_allowance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label">Bonuses:</label>
            <input type="number" name="bonuses" id="bonuses" value="<?php echo e(old('bonuses', isset($payroll)?($payroll->bonuses ?? 0):0)); ?>" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            <?php $__errorArgs = ['bonuses'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
            <input type="number" name="pf" id="pf" value="<?php echo e(old('pf', isset($payroll)?($payroll->pf ?? 0):0)); ?>" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            <?php $__errorArgs = ['pf'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label">TDS:</label>
            <input type="number" name="tds" id="tds" value="<?php echo e(old('tds', isset($payroll)?($payroll->tds ?? 0):0)); ?>" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            <?php $__errorArgs = ['tds'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label">Professional Tax:</label>
            <input type="number" name="professional_tax" id="professional_tax" value="<?php echo e(old('professional_tax', isset($payroll)?($payroll->professional_tax ?? 0):0)); ?>" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            <?php $__errorArgs = ['professional_tax'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label">ESIC:</label>
            <input type="number" name="esic" id="esic" value="<?php echo e(old('esic', isset($payroll)?($payroll->esic ?? 0):0)); ?>" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            <?php $__errorArgs = ['esic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label">Security Deposit:</label>
            <input type="number" name="security_deposit" id="security_deposit" value="<?php echo e(old('security_deposit', isset($payroll)?($payroll->security_deposit ?? 0):0)); ?>" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" step="0.01" min="0" oninput="calculateNetSalary()">
            <?php $__errorArgs = ['security_deposit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label">Leave Deduction:</label>
            <input type="number" name="leave_deduction" id="leave_deduction" value="<?php echo e(old('leave_deduction', isset($payroll)?($payroll->leave_deduction ?? 0):0)); ?>" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" readonly style="background: #fef2f2;">
            <?php $__errorArgs = ['leave_deduction'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

        </div>
      </div>

      <!-- Summary Row: Total Income + Total Deduction + Net Salary in One Row -->
      <div class="md:col-span-2" style="margin-top: 20px; padding: 20px; background: #f9fafb; border-radius: 8px; border: 2px solid #e5e7eb;">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
          <div>
            <label class="hrp-label" style="color: #10b981; font-weight: 700; font-size: 14px;">Total Income:</label>
            <input type="number" name="total_income" id="total_income" value="<?php echo e(old('total_income', isset($payroll)?($payroll->total_income ?? 0):0)); ?>" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" readonly style="background: #f0fff4; font-weight: 700; font-size: 16px; color: #10b981; border-color: #10b981; border-width: 2px;">
            <?php $__errorArgs = ['total_income'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label" style="color: #ef4444; font-weight: 700; font-size: 14px;">Total Deduction:</label>
            <input type="number" name="deduction_total" id="deduction_total" value="<?php echo e(old('deduction_total', isset($payroll)?($payroll->deduction_total ?? 0):0)); ?>" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" readonly style="background: #fef2f2; font-weight: 700; font-size: 16px; color: #ef4444; border-color: #ef4444; border-width: 2px;">
            <?php $__errorArgs = ['deduction_total'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div>
            <label class="hrp-label" style="color: #0891b2; font-weight: 700; font-size: 14px;">Net Salary:</label>
            <input type="number" name="net_salary" id="net_salary" value="<?php echo e(old('net_salary', isset($payroll)?$payroll->net_salary:0)); ?>" placeholder="0.00" class="hrp-input Rectangle-29" form="payrollForm" readonly style="background: #ecfeff; font-weight: 700; font-size: 18px; color: #0891b2; border-color: #0891b2; border-width: 2px;">
            <?php $__errorArgs = ['net_salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
          <?php ($selStatus = old('status', isset($payroll)?$payroll->status:'pending')); ?>
          <option value="pending" <?php echo e($selStatus==='pending'?'selected':''); ?>>Pending</option>
          <option value="paid" <?php echo e($selStatus==='paid'?'selected':''); ?>>Paid</option>
          <option value="cancelled" <?php echo e($selStatus==='cancelled'?'selected':''); ?>>Cancelled</option>
        </select>
        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div id="paymentTypeField" style="display: none;">
        <label class="hrp-label">Payment Method:</label>
        <select name="payment_method" id="payment_method" class="Rectangle-29 Rectangle-29-select" form="payrollForm" onchange="toggleTransactionField()">
          <option value="">Select Method</option>
          <?php ($pm = old('payment_method', isset($payroll)?$payroll->payment_method:'')); ?>
          <option value="Cash" <?php echo e($pm==='Cash'?'selected':''); ?>>Cash</option>
          <option value="Bank Transfer" <?php echo e($pm==='Bank Transfer'?'selected':''); ?>>Bank Transfer</option>
          <option value="Cheque" <?php echo e($pm==='Cheque'?'selected':''); ?>>Cheque</option>
          <option value="UPI" <?php echo e($pm==='UPI'?'selected':''); ?>>UPI</option>
        </select>
        <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div id="paymentDateField" style="display: none;">
        <label class="hrp-label">Payment Date:</label>
        <input type="date" name="payment_date" id="payment_date" value="<?php echo e(old('payment_date', isset($payroll)&&$payroll->payment_date ? optional($payroll->payment_date)->format('Y-m-d') : '')); ?>" class="hrp-input Rectangle-29" form="payrollForm">
        <?php $__errorArgs = ['payment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div id="transactionIdField" class="md:col-span-2" style="display: none;">
        <label class="hrp-label">Transaction ID / Reference:</label>
        <input name="transaction_id" id="transaction_id" value="<?php echo e(old('transaction_id', isset($payroll)?($payroll->transaction_id ?? ''):'')); ?>" placeholder="Enter Transaction ID or Reference Number" class="hrp-input Rectangle-29" form="payrollForm">
        <?php $__errorArgs = ['transaction_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="md:col-span-2">
        <div class="hrp-actions">
          <button type="submit" form="payrollForm" class="hrp-btn hrp-btn-primary"><?php echo e(isset($payroll) ? 'Update Payroll Entry' : 'Create Payroll Entry'); ?></button>
        </div>
      </div>

    </div>
  </div>
</div>

<?php $__env->startPush('scripts'); ?>
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
  calculateNetSalary();
}

// Initialize on page load
(function(){
  // If all 3 are set, load employee data on page load (for edit prefill)
  try {
    var eid = document.getElementById('employee_id')?.value;
    var m = document.getElementById('month')?.value;
    var y = document.getElementById('year')?.value;
    if (eid && m && y) {
      loadEmployeeSalaryData();
    }
  } catch(e) { /* no-op */ }

  // Initialize payment fields visibility based on current status
  try { togglePaymentFields(); } catch(e) {}

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
    
    fetch('<?php echo e(route("payroll.get-employee-salary")); ?>', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
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
            
            // Fill leave data (structured)
            setSelectValue('casual_leave', data.casual_leave_used || 0);
            setSelectValue('medical_leave', data.medical_leave_used || 0);
            setSelectValue('holiday_leave', data.holiday_leave_used || 0);
            const personal = parseFloat(data.personal_leave_used || 0);
            document.getElementById('personal_leave_unpaid').value = personal;
            updateLeaveTotals();
            
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
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
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
                window.location.href = '<?php echo e(route("payroll.index")); ?>';
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
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
  <a class="hrp-bc-home" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="<?php echo e(route('payroll.index')); ?>" style="font-weight:800;color:#0f0f0f;text-decoration:none">Payroll</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Create Payroll</span>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/payroll/create.blade.php ENDPATH**/ ?>