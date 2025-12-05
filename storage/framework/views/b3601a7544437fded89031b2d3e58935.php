<?php $__env->startSection('page_title', 'Add Receipt'); ?>

<?php $__env->startPush('styles'); ?>
<style>
  .custom-checkbox input[type="checkbox"] {
    display: none;
  }
  
  .custom-checkbox .checkbox-box {
    width: 18px;
    height: 18px;
    border: 2px solid #000;
    background: white;
    margin-right: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 3px;
    transition: all 0.2s;
  }
  
  .custom-checkbox input[type="checkbox"]:checked + .checkbox-box {
    background: #000;
  }
  
  .custom-checkbox .checkmark {
    color: white;
    font-size: 12px;
    font-weight: bold;
    display: none;
  }
  
  .custom-checkbox input[type="checkbox"]:checked + .checkbox-box .checkmark {
    display: block;
  }
  
  .custom-checkbox:hover .checkbox-box {
    border-color: #333;
  }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('error')): ?>
<div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
    <strong>⚠ Error:</strong> <?php echo e(session('error')); ?>

</div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('receipts.store')); ?>" class="hrp-form">
  <?php echo csrf_field(); ?>

<div class="hrp-card">
  <div class="Rectangle-30 hrp-compact">
      
      <!-- Row 1: Basic Information -->
      <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">
        <div>
          <label class="hrp-label">Unique Code:</label>
          <input type="text" class="Rectangle-29" value="<?php echo e($nextCode); ?>" readonly style="background: #949597 !important;" >
        </div>
 
        <div>
          <label class="hrp-label">Rec Date: <span class="text-red-500">*</span></label>
          <input type="text" class="Rectangle-29 date-picker <?php $__errorArgs = ['receipt_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="receipt_date" placeholder="dd/mm/yyyy" value="<?php echo e(old('receipt_date', date('d/m/Y'))); ?>" autocomplete="off" required>
          <?php $__errorArgs = ['receipt_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label class="hrp-label">Company Name: <span class="text-red-500">*</span></label>
          <select class="Rectangle-29-select <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="company_name" id="companySelect" required>
            <option value="">-- Select Company --</option>
            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($company); ?>" <?php echo e(old('company_name') == $company ? 'selected' : ''); ?>><?php echo e($company); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
          <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label class="hrp-label">Invoice Type: <span class="text-red-500">*</span></label>
          <select class="Rectangle-29-select <?php $__errorArgs = ['invoice_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="invoice_type" id="invoiceTypeSelect" required>
            <option value="">-- Select Type --</option>
            <option value="gst" <?php echo e(old('invoice_type') == 'gst' ? 'selected' : ''); ?>>GST Invoice</option>
            <option value="without_gst" <?php echo e(old('invoice_type') == 'without_gst' ? 'selected' : ''); ?>>Without GST Invoice</option>
          </select>
          <?php $__errorArgs = ['invoice_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
      </div>

      <!-- Row 2: Total, Paid, Remain -->
      <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
        <div>
          <label class="hrp-label">Total:</label>
          <input type="text" id="totalAmount" readonly style="background: #DBEAFE; border: 1px solid #93C5FD; border-radius: 8px; padding: 12px 16px; font-size: 16px; font-weight: 600; color: #1E40AF; text-align: center; width: 100%;" value="0.00">
        </div>
        <div>
          <label class="hrp-label">Paid:</label>
          <input type="text" id="paidAmount" readonly style="background: #D1FAE5; border: 1px solid #6EE7B7; border-radius: 8px; padding: 12px 16px; font-size: 16px; font-weight: 600; color: #047857; text-align: center; width: 100%;" value="0.00">
        </div>
        <div>
          <label class="hrp-label">Remain:</label>
          <input type="text" id="remainAmount" readonly style="background: #FEE2E2; border: 1px solid #FCA5A5; border-radius: 8px; padding: 12px 16px; font-size: 16px; font-weight: 600; color: #DC2626; text-align: center; width: 100%;" value="0.00">
        </div>
      </div>

      <!-- Invoice Selection Table -->
      <div style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 15px; color: #374151;">Select Invoices</h3>
        <div style="overflow-x: auto; border: 1px solid #e5e7eb; border-radius: 8px;">
          <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f9fafb;">
              <tr>
                <th style="padding: 12px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb;">Select</th>
                <th style="padding: 12px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb;">Sr</th>
                <th style="padding: 12px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb;">Invoice No</th>
                <th style="padding: 12px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb;">Grand Total</th>
                <th style="padding: 12px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb;">Total Tax</th>
                <th style="padding: 12px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb;">Total</th>
                <th style="padding: 12px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb;">Paid</th>
                <th style="padding: 12px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb;">Balance</th>
              </tr>
            </thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <?php
                $paidAmount = $invoice->paid_amount ?? 0;
                $balance = ($invoice->final_amount ?? 0) - $paidAmount;
              ?>
              <tr class="invoice-row" 
                  data-company="<?php echo e($invoice->company_name); ?>" 
                  data-type="<?php echo e($invoice->invoice_type); ?>" 
                  data-amount="<?php echo e($invoice->final_amount ?? 0); ?>"
                  data-paid="<?php echo e($paidAmount); ?>"
                  data-balance="<?php echo e($balance); ?>"
                  style="border-bottom: 1px solid #f3f4f6; display: none;">
                <td style="padding: 12px;">
                  <label class="custom-checkbox" style="display: flex; align-items: center; cursor: pointer; margin: 0;">
                    <input type="checkbox" name="invoice_ids[]" value="<?php echo e($invoice->id); ?>" class="invoice-checkbox" <?php echo e($balance <= 0 ? 'disabled' : ''); ?>>
                    <div class="checkbox-box">
                      <span class="checkmark">✓</span>
                    </div>
                  </label>
                </td>
                <td style="padding: 12px; font-size: 13px; color: #374151;"><?php echo e($index + 1); ?></td>
                <td style="padding: 12px; font-size: 13px; color: #374151;">
                  <?php echo e($invoice->unique_code); ?>

                  <span style="font-size: 11px; padding: 2px 6px; border-radius: 4px; margin-left: 5px; <?php echo e($invoice->invoice_type == 'gst' ? 'background: #DBEAFE; color: #1E40AF;' : 'background: #FEF3C7; color: #92400E;'); ?>">
                    <?php echo e($invoice->invoice_type == 'gst' ? 'GST' : 'Without GST'); ?>

                  </span>
                  <?php if($balance <= 0): ?>
                  <span style="font-size: 11px; padding: 2px 6px; border-radius: 4px; margin-left: 5px; background: #D1FAE5; color: #047857;">PAID</span>
                  <?php endif; ?>
                </td>
                <td style="padding: 12px; font-size: 13px; color: #374151;">₹<?php echo e(number_format($invoice->sub_total ?? 0, 2)); ?></td>
                <td style="padding: 12px; font-size: 13px; color: #374151;">₹<?php echo e(number_format($invoice->total_tax_amount ?? 0, 2)); ?></td>
                <td style="padding: 12px; font-size: 13px; font-weight: 600; color: #111827;">₹<?php echo e(number_format($invoice->final_amount ?? 0, 2)); ?></td>
                <td style="padding: 12px; font-size: 13px; color: #047857; font-weight: 600;">₹<?php echo e(number_format($paidAmount, 2)); ?></td>
                <td style="padding: 12px; font-size: 13px; font-weight: 600; color: <?php echo e($balance > 0 ? '#DC2626' : '#047857'); ?>;">₹<?php echo e(number_format($balance, 2)); ?></td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr id="noInvoicesRow">
                <td colspan="8" style="padding: 20px; text-align: center; color: #9ca3af;">Select invoice type and company to view invoices</td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Row 3: Payment Details -->
      <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">
        <div>
          <label class="hrp-label">Received Amount: <span class="text-red-500">*</span></label>
          <input type="number" step="0.01" class="Rectangle-29 <?php $__errorArgs = ['received_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="received_amount" id="receivedAmount" value="<?php echo e(old('received_amount')); ?>" placeholder="0.00" readonly style="background: #FEF3C7; border: 2px solid #F59E0B; font-weight: 600; color: #92400E;" required>
          <?php $__errorArgs = ['received_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label class="hrp-label">Payment Type:</label>
          <select class="Rectangle-29-select <?php $__errorArgs = ['payment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="payment_type">
            <option value="">Select Mode</option>
            <option value="In Account" <?php echo e(old('payment_type') == 'In Account' ? 'selected' : ''); ?>>In Account</option>
            <option value="Cash" <?php echo e(old('payment_type') == 'Cash' ? 'selected' : ''); ?>>Cash</option>
            <option value="Cheque" <?php echo e(old('payment_type') == 'Cheque' ? 'selected' : ''); ?>>Cheque</option>
            <option value="Online Transfer" <?php echo e(old('payment_type') == 'Online Transfer' ? 'selected' : ''); ?>>Online Transfer</option>
          </select>
          <?php $__errorArgs = ['payment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label class="hrp-label">Narration:</label>
          <input type="text" class="Rectangle-29 <?php $__errorArgs = ['narration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="narration" value="<?php echo e(old('narration')); ?>" placeholder="Enter Narration">
          <?php $__errorArgs = ['narration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="hrp-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
          <label class="hrp-label">Trans Code:</label>
          <input type="text" class="Rectangle-29 <?php $__errorArgs = ['trans_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="trans_code" value="<?php echo e(old('trans_code')); ?>" placeholder="Enter SAC Code">
          <?php $__errorArgs = ['trans_code'];
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

<!-- Action Buttons -->
<div style="margin-top: 30px; display: flex; justify-content: flex-end; gap: 15px;">
  <button type="submit" style="background: #10B981; color: white; padding: 12px 32px; border-radius: 8px; border: none; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10B981'">
    Add Receipt
  </button>
</div>

</form>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
// Initialize date picker
$(document).ready(function() {
  $('.date-picker').datepicker({
    dateFormat: 'dd/mm/yy', // In jQuery UI, 'yy' means 4-digit year
    changeMonth: true,
    changeYear: true,
    yearRange: '-10:+10',
    showButtonPanel: true,
    beforeShow: function(input, inst) {
      setTimeout(function() {
        inst.dpDiv.css({
          marginTop: '2px',
          marginLeft: '0px'
        });
      }, 0);
    }
  });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const invoiceTypeSelect = document.getElementById('invoiceTypeSelect');
  const companySelect = document.getElementById('companySelect');
  const invoiceRows = document.querySelectorAll('.invoice-row');
  const noInvoicesRow = document.getElementById('noInvoicesRow');
  const totalAmountInput = document.getElementById('totalAmount');
  const paidAmountInput = document.getElementById('paidAmount');
  const remainAmountInput = document.getElementById('remainAmount');
  const receivedAmountInput = document.getElementById('receivedAmount');
  const form = document.querySelector('form');
  
  // Filter invoices when company changes (FIRST)
  companySelect.addEventListener('change', filterInvoices);
  
  // Filter invoices when invoice type changes (SECOND)
  invoiceTypeSelect.addEventListener('change', filterInvoices);
  
  function filterInvoices() {
    const selectedCompany = companySelect.value;
    const selectedType = invoiceTypeSelect.value;
    let visibleCount = 0;
    
    // Hide all invoice rows first and uncheck
    invoiceRows.forEach(row => {
      row.style.display = 'none';
      const checkbox = row.querySelector('.invoice-checkbox');
      if (checkbox) checkbox.checked = false;
    });
    
    // Reset amounts
    updateAmounts();
    
    if (selectedCompany && selectedType) {
      // Show only invoices matching both company and type AND have balance > 0
      invoiceRows.forEach(row => {
        const balance = parseFloat(row.dataset.balance) || 0;
        
        if (row.dataset.company === selectedCompany && 
            row.dataset.type === selectedType && 
            balance > 0) {
          row.style.display = '';
          visibleCount++;
        }
      });
      
      // Show/hide no invoices message
      if (visibleCount === 0) {
        noInvoicesRow.querySelector('td').textContent = 'No unpaid invoices found for this company with selected type';
        noInvoicesRow.style.display = '';
      } else {
        noInvoicesRow.style.display = 'none';
      }
    } else if (selectedCompany || selectedType) {
      noInvoicesRow.querySelector('td').textContent = 'Please select both company name and invoice type';
      noInvoicesRow.style.display = '';
    } else {
      noInvoicesRow.querySelector('td').textContent = 'Select company name and invoice type to view invoices';
      noInvoicesRow.style.display = '';
    }
  }
  
  // Add event listeners to all checkboxes
  invoiceRows.forEach(row => {
    const checkbox = row.querySelector('.invoice-checkbox');
    if (checkbox) {
      checkbox.addEventListener('change', updateAmounts);
    }
  });
  
  function updateAmounts() {
    const selectedCompany = companySelect.value;
    const selectedType = invoiceTypeSelect.value;
    
    let totalInvoiceAmount = 0;
    let totalPaidAmount = 0;
    let checkedBalance = 0;
    let checkedCount = 0;
    let allInvoicesPaid = false;
    
    // Calculate totals for ALL invoices of this company and type (shown in table)
    if (selectedCompany && selectedType) {
      let hasUnpaidInvoices = false;
      
      invoiceRows.forEach(row => {
        if (row.dataset.company === selectedCompany && row.dataset.type === selectedType) {
          const amount = parseFloat(row.dataset.amount) || 0;
          const paid = parseFloat(row.dataset.paid) || 0;
          const balance = parseFloat(row.dataset.balance) || 0;
          
          // Add to totals for ALL invoices (including paid ones)
          totalInvoiceAmount += amount;
          totalPaidAmount += paid;
          
          // Check if there are unpaid invoices
          if (balance > 0) {
            hasUnpaidInvoices = true;
          }
        }
      });
      
      // All invoices are paid if no unpaid invoices exist and there's at least some payment
      allInvoicesPaid = !hasUnpaidInvoices && totalPaidAmount > 0;
    }
    
    // Calculate balance from CHECKED invoices for received amount
    invoiceRows.forEach(row => {
      if (row.style.display !== 'none') {
        const checkbox = row.querySelector('.invoice-checkbox');
        
        if (checkbox && checkbox.checked && !checkbox.disabled) {
          const balance = parseFloat(row.dataset.balance) || 0;
          checkedBalance += balance;
          checkedCount++;
        }
      }
    });
    
    // Calculate remain (Total Invoice Amount - Total Paid)
    const remainAmount = Math.max(0, totalInvoiceAmount - totalPaidAmount);
    
    // Auto-fill received amount with total balance of SELECTED invoices (READONLY)
    if (checkedCount > 0) {
      receivedAmountInput.value = checkedBalance.toFixed(2);
    } else {
      receivedAmountInput.value = '';
    }
    
    // Update display fields
    // Total = Sum of all invoice final_amount for this company + type
    // Paid = Sum of all invoice paid_amount for this company + type
    // Remain = Total - Paid
    totalAmountInput.value = totalInvoiceAmount.toFixed(2);
    paidAmountInput.value = totalPaidAmount.toFixed(2);
    remainAmountInput.value = remainAmount.toFixed(2);
    
    // Show message if all invoices are paid
    if (allInvoicesPaid && selectedCompany && selectedType) {
      noInvoicesRow.querySelector('td').textContent = '✓ All invoices for this company and type are fully paid!';
      noInvoicesRow.querySelector('td').style.color = '#047857';
      noInvoicesRow.querySelector('td').style.fontWeight = '600';
      noInvoicesRow.style.display = '';
    }
  }
  
  // Form validation before submit
  form.addEventListener('submit', function(e) {
    const receivedValue = parseFloat(receivedAmountInput.value) || 0;
    const remainValue = parseFloat(remainAmountInput.value) || 0;
    
    // Check if company is selected
    if (!companySelect.value) {
      e.preventDefault();
      toastr.warning('Please select a company name');
      companySelect.focus();
      return false;
    }
    
    // Check if invoice type is selected
    if (!invoiceTypeSelect.value) {
      e.preventDefault();
      toastr.warning('Please select an invoice type');
      invoiceTypeSelect.focus();
      return false;
    }
    
    // Check if at least one invoice is selected
    const checkedInvoices = Array.from(invoiceRows).filter(row => {
      const checkbox = row.querySelector('.invoice-checkbox');
      return checkbox && checkbox.checked && row.style.display !== 'none';
    });
    
    if (checkedInvoices.length === 0) {
      e.preventDefault();
      toastr.warning('Please select at least one unpaid invoice');
      return false;
    }
    
    // Check if received amount is valid
    if (receivedValue <= 0) {
      e.preventDefault();
      toastr.warning('Received amount must be greater than zero');
      return false;
    }
    
    return true;
  });
});
</script>
<?php $__env->stopPush(); ?>




<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/receipts/create.blade.php ENDPATH**/ ?>