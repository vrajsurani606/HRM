@extends('layouts.macos')
@section('page_title', 'Proforma')

@section('content')
<div class="Rectangle-30 hrp-compact">
  <h3 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 600; color: #111827;">PROFORMA</h3>
  
  <form method="POST" action="{{ route('quotations.store-proforma', $quotation->id) }}" class="hrp-form">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5" style="margin-bottom: 20px;">
      <div>
        <label class="hrp-label">Unique Code:</label>
        <input class="hrp-input Rectangle-29" name="unique_code" value="{{ $nextCode }}" readonly />
      </div>
      <div>
        <label class="hrp-label">Proforma Date:</label>
        <input type="date" class="hrp-input Rectangle-29" name="proforma_date" value="{{ old('proforma_date', date('Y-m-d')) }}" required />
        @error('proforma_date')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5" style="margin-bottom: 20px;">
      <div>
        <label class="hrp-label">Select Company:</label>
        <input class="hrp-input Rectangle-29" name="company_name" value="{{ old('company_name', $quotation->company_name) }}" required />
        @error('company_name')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>
      <div>
        <label class="hrp-label">Type of Billing:</label>
        <select class="Rectangle-29 Rectangle-29-select" name="type_of_billing">
          <option value="">Select</option>
          <option value="GST" {{ old('type_of_billing') == 'GST' ? 'selected' : '' }}>GST</option>
          <option value="Non-GST" {{ old('type_of_billing') == 'Non-GST' ? 'selected' : '' }}>Non-GST</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-5" style="margin-bottom: 20px;">
      <div>
        <label class="hrp-label">Bill No.:</label>
        <input class="hrp-input Rectangle-29" name="bill_no" value="{{ old('bill_no') }}" />
      </div>
      <div>
        <label class="hrp-label">Address:</label>
        <input class="hrp-input Rectangle-29" name="address" value="{{ old('address', $quotation->address) }}" />
      </div>
      <div>
        <label class="hrp-label">GST No.:</label>
        <input class="hrp-input Rectangle-29" name="gst_no" value="{{ old('gst_no', $quotation->gst_no) }}" />
      </div>
      <div>
        <label class="hrp-label">Mobile No.:</label>
        <input class="hrp-input Rectangle-29" name="mobile_no" value="{{ old('mobile_no', $quotation->contact_number_1) }}" />
      </div>
    </div>

    <div style="margin-bottom: 20px;">
      <button type="button" id="add-row-btn" class="hrp-btn hrp-btn-primary" style="margin-bottom: 12px;">Add Row</button>
      
      <div style="border-radius: 8px; border: 1px solid #e5e7eb; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
          <thead style="background: #f9fafb;">
            <tr>
              <th style="padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;">Description</th>
              <th style="padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;">SAC Code</th>
              <th style="padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;">Quantity</th>
              <th style="padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;">Rate</th>
              <th style="padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;">Total</th>
              <th style="padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;">ACTION</th>
            </tr>
          </thead>
          <tbody id="service-rows">
            <tr class="service-row">
              <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29" name="description[]" placeholder="Enter Description" style="border: none; background: transparent; width: 100%;">
              </td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29" name="sac_code[]" placeholder="Enter Code" style="border: none; background: transparent; width: 100%;">
              </td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29 quantity-input" type="number" min="0" step="1" name="quantity[]" placeholder="0" style="border: none; background: transparent; width: 100%;" oninput="calculateRowTotal(this)">
              </td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29 rate-input" type="number" min="0" step="0.01" name="rate[]" placeholder="₹ 0.00" style="border: none; background: transparent; width: 100%;" oninput="calculateRowTotal(this)">
              </td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29 total-input" type="number" min="0" step="0.01" name="total[]" placeholder="₹ 0.00" style="border: none; background: transparent; width: 100%;" readonly>
              </td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <button type="button" class="remove-row-btn" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: pointer;">×</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5" style="margin-bottom: 20px;">
      <div>
        <label class="hrp-label">Sub Total:</label>
        <input class="hrp-input Rectangle-29" type="number" step="0.01" name="sub_total" id="sub_total" value="0" readonly />
      </div>
      <div>
        <label class="hrp-label">Discount Per(%):</label>
        <input class="hrp-input Rectangle-29" type="number" step="0.01" name="discount_percent" id="discount_percent" value="0" oninput="calculateTotals()" />
      </div>
      <div>
        <label class="hrp-label">Discount Amount:</label>
        <input class="hrp-input Rectangle-29" type="number" step="0.01" name="discount_amount" id="discount_amount" value="0" readonly />
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5" style="margin-bottom: 20px;">
      <div>
        <label class="hrp-label">Cgst Per(%):</label>
        <input class="hrp-input Rectangle-29" type="number" step="0.01" name="cgst_percent" id="cgst_percent" value="0" oninput="calculateTotals()" />
      </div>
      <div>
        <label class="hrp-label">Cgst Amount:</label>
        <input class="hrp-input Rectangle-29" type="number" step="0.01" name="cgst_amount" id="cgst_amount" value="0" readonly />
      </div>
      <div>
        <label class="hrp-label">Sgst Per(%):</label>
        <input class="hrp-input Rectangle-29" type="number" step="0.01" name="sgst_percent" id="sgst_percent" value="0" oninput="calculateTotals()" />
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5" style="margin-bottom: 20px;">
      <div>
        <label class="hrp-label">Sgst Amount:</label>
        <input class="hrp-input Rectangle-29" type="number" step="0.01" name="sgst_amount" id="sgst_amount" value="0" readonly />
      </div>
      <div>
        <label class="hrp-label">Igst Per(%):</label>
        <input class="hrp-input Rectangle-29" type="number" step="0.01" name="igst_percent" id="igst_percent" value="0" oninput="calculateTotals()" />
      </div>
      <div>
        <label class="hrp-label">Igst Amount:</label>
        <input class="hrp-input Rectangle-29" type="number" step="0.01" name="igst_amount" id="igst_amount" value="0" readonly />
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5" style="margin-bottom: 20px;">
      <div>
        <label class="hrp-label">Total Tax Amount:</label>
        <input class="hrp-input Rectangle-29" type="number" step="0.01" name="total_tax_amount" id="total_tax_amount" value="0" readonly />
      </div>
      <div>
        <label class="hrp-label">Final Amount:</label>
        <input class="hrp-input Rectangle-29" type="number" step="0.01" name="final_amount" id="final_amount" value="0" readonly />
      </div>
      <div>
        <label class="hrp-label">Billing Item:</label>
        <input class="hrp-input Rectangle-29" type="number" step="0.01" name="billing_item" id="billing_item" value="0" />
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5" style="margin-bottom: 20px;">
      <div>
        <label class="hrp-label">TDS Amount:</label>
        <textarea class="hrp-textarea Rectangle-29 Rectangle-29-textarea" name="tds_amount" style="height:80px;resize:vertical;">{{ old('tds_amount') }}</textarea>
      </div>
      <div>
        <label class="hrp-label">Remark:</label>
        <textarea class="hrp-textarea Rectangle-29 Rectangle-29-textarea" name="remark" style="height:80px;resize:vertical;">{{ old('remark') }}</textarea>
      </div>
    </div>

    <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:30px;">
      <a href="{{ route('quotations.template-list', $quotation->id) }}" class="hrp-btn" style="background:#e5e7eb;color:#111827;">Cancel</a>
      <button type="submit" class="hrp-btn hrp-btn-primary">ADD PROFORMA</button>
    </div>
  </form>
</div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('quotations.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Quotation Management</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('quotations.template-list', $quotation->id) }}">Template List</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Proforma</span>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Add row functionality
  document.getElementById('add-row-btn').addEventListener('click', function() {
    const tbody = document.getElementById('service-rows');
    const newRow = tbody.querySelector('.service-row').cloneNode(true);
    
    // Clear input values
    newRow.querySelectorAll('input').forEach(input => {
      input.value = '';
    });
    
    tbody.appendChild(newRow);
  });

  // Remove row functionality
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-row-btn')) {
      const rows = document.querySelectorAll('.service-row');
      if (rows.length > 1) {
        e.target.closest('.service-row').remove();
        calculateTotals();
      }
    }
  });
});

function calculateRowTotal(input) {
  const row = input.closest('.service-row');
  const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
  const rate = parseFloat(row.querySelector('.rate-input').value) || 0;
  const total = quantity * rate;
  
  row.querySelector('.total-input').value = total.toFixed(2);
  calculateTotals();
}

function calculateTotals() {
  // Calculate subtotal
  let subtotal = 0;
  document.querySelectorAll('.total-input').forEach(input => {
    subtotal += parseFloat(input.value) || 0;
  });
  document.getElementById('sub_total').value = subtotal.toFixed(2);

  // Calculate discount
  const discountPercent = parseFloat(document.getElementById('discount_percent').value) || 0;
  const discountAmount = (subtotal * discountPercent) / 100;
  document.getElementById('discount_amount').value = discountAmount.toFixed(2);

  const afterDiscount = subtotal - discountAmount;

  // Calculate CGST
  const cgstPercent = parseFloat(document.getElementById('cgst_percent').value) || 0;
  const cgstAmount = (afterDiscount * cgstPercent) / 100;
  document.getElementById('cgst_amount').value = cgstAmount.toFixed(2);

  // Calculate SGST
  const sgstPercent = parseFloat(document.getElementById('sgst_percent').value) || 0;
  const sgstAmount = (afterDiscount * sgstPercent) / 100;
  document.getElementById('sgst_amount').value = sgstAmount.toFixed(2);

  // Calculate IGST
  const igstPercent = parseFloat(document.getElementById('igst_percent').value) || 0;
  const igstAmount = (afterDiscount * igstPercent) / 100;
  document.getElementById('igst_amount').value = igstAmount.toFixed(2);

  // Total tax
  const totalTax = cgstAmount + sgstAmount + igstAmount;
  document.getElementById('total_tax_amount').value = totalTax.toFixed(2);

  // Final amount
  const finalAmount = afterDiscount + totalTax;
  document.getElementById('final_amount').value = finalAmount.toFixed(2);
}
</script>
@endpush
