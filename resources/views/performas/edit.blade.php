@extends('layouts.macos')
@section('page_title', 'Edit Proforma')

@section('content')

@if(session('error'))
<div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
    <strong>⚠ Error:</strong> {{ session('error') }}
</div>
@endif

<form method="POST" action="{{ route('performas.update', $proforma->id) }}" id="performaForm" class="hrp-form">
  @csrf
  @method('PUT')
  
  <input type="hidden" name="quotation_id" value="{{ $proforma->quotation_id }}">
  <input type="hidden" name="template_index" value="{{ $proforma->template_index }}">

<div class="hrp-card">
  <div class="Rectangle-30 hrp-compact">
      
      <!-- Row 1: Basic Information -->
      <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
        <div>
          <label class="hrp-label">Unique Code: <span class="text-red-500">*</span></label>
          <input type="text" class="Rectangle-29" name="unique_code" value="{{ $proforma->unique_code }}" readonly style="background: #f3f4f6;">
        </div>
        <div>
          <label class="hrp-label">Proforma Date: <span class="text-red-500">*</span></label>
          <input type="date" class="Rectangle-29 @error('proforma_date') is-invalid @enderror" name="proforma_date" value="{{ old('proforma_date', $proforma->proforma_date?->format('Y-m-d')) }}" required>
          @error('proforma_date')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Type Of Billing:</label>
          <select class="Rectangle-29-select @error('type_of_billing') is-invalid @enderror" name="type_of_billing">
            <option value="">Select</option>
            <option value="ADVANCE" {{ old('type_of_billing', $proforma->type_of_billing) == 'ADVANCE' ? 'selected' : '' }}>ADVANCE</option>
            <option value="ON INSTALLATION" {{ old('type_of_billing', $proforma->type_of_billing) == 'ON INSTALLATION' ? 'selected' : '' }}>ON INSTALLATION</option>
            <option value="COMPLETION" {{ old('type_of_billing', $proforma->type_of_billing) == 'COMPLETION' ? 'selected' : '' }}>COMPLETION</option>
            <option value="RETENTION" {{ old('type_of_billing', $proforma->type_of_billing) == 'RETENTION' ? 'selected' : '' }}>RETENTION</option>
            <option value="AMC" {{ old('type_of_billing', $proforma->type_of_billing) == 'AMC' ? 'selected' : '' }}>AMC</option>
          </select>
          @error('type_of_billing')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Bill No:</label>
          <input type="text" class="Rectangle-29 @error('bill_no') is-invalid @enderror" name="bill_no" value="{{ old('bill_no', $proforma->bill_no) }}" placeholder="Enter Bill No">
          @error('bill_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>

      <!-- Row 2: Company Information -->
      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
        <div>
          <label class="hrp-label">Company Name: <span class="text-red-500">*</span></label>
          <input type="text" class="Rectangle-29 @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name', $proforma->company_name) }}" placeholder="Enter Company Name" required>
          @error('company_name')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Address:</label>
          <textarea class="Rectangle-29 Rectangle-29-textarea @error('address') is-invalid @enderror" name="address" placeholder="Enter Address" style="min-height:80px">{{ old('address', $proforma->address) }}</textarea>
          @error('address')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>

      <!-- Row 3: GST and Mobile -->
      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
        <div>
          <label class="hrp-label">GST No :</label>
          <input type="text" class="Rectangle-29" name="gst_no" value="{{ old('gst_no', $proforma->gst_no) }}" placeholder="Enter GS no.">
        </div>
        <div>
          <label class="hrp-label">Mobile No :</label>
          <input type="text" class="Rectangle-29" name="mobile_no" value="{{ old('mobile_no', $proforma->mobile_no) }}" placeholder="Enter Mobile No..">
        </div>
      </div>
  </div>

<!-- Items Table Section -->
<div style="margin: 30px 0;">
  <div class="Rectangle-30 hrp-compact">
    <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
      <button type="button" class="inquiry-submit-btn" id="addItemBtn" style="background: #28a745;">+ Add More</button>
    </div>
    <table class="items-table" style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr>
          <th style="padding: 12px; text-align: left; font-weight: 600;">Description</th>
          <th style="padding: 12px; text-align: left; font-weight: 600;">SAC Code</th>
          <th style="padding: 12px; text-align: left; font-weight: 600;">Quantity</th>
          <th style="padding: 12px; text-align: left; font-weight: 600;">Rate</th>
          <th style="padding: 12px; text-align: left; font-weight: 600;">Total</th>
          <th style="padding: 12px; text-align: left; font-weight: 600;">Action</th>
        </tr>
      </thead>
      <tbody id="itemsWrap">
        @php
          $descriptions = is_array($proforma->description) ? $proforma->description : [];
          $sacCodes = is_array($proforma->sac_code) ? $proforma->sac_code : [];
          $quantities = is_array($proforma->quantity) ? $proforma->quantity : [];
          $rates = is_array($proforma->rate) ? $proforma->rate : [];
          $totals = is_array($proforma->total) ? $proforma->total : [];
          $maxCount = max(count($descriptions), count($sacCodes), count($quantities), count($rates), count($totals), 2);
        @endphp
        
        @for($i = 0; $i < $maxCount; $i++)
        <tr class="item-row" data-index="{{ $i }}">
          <td style="padding: 12px; border-bottom: 1px solid #eee;">
            <input class="Rectangle-29" name="description[]" value="{{ $descriptions[$i] ?? '' }}" placeholder="Enter Description" style="border: none; background: transparent; margin: 0;">
          </td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;">
            <input class="Rectangle-29" name="sac_code[]" value="{{ $sacCodes[$i] ?? '' }}" placeholder="Enter SAC Code" style="border: none; background: transparent; margin: 0;">
          </td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;">
            <input type="number" min="0" step="1" class="Rectangle-29 js-qty" name="quantity[]" value="{{ $quantities[$i] ?? '' }}" placeholder="Qty" style="border: none; background: transparent; margin: 0;">
          </td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;">
            <input type="number" min="0" step="0.01" class="Rectangle-29 js-rate" name="rate[]" value="{{ $rates[$i] ?? '' }}" placeholder="Rate" style="border: none; background: transparent; margin: 0;">
          </td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;">
            <input type="number" class="Rectangle-29 js-line-total" name="total[]" value="{{ $totals[$i] ?? '' }}" placeholder="Total" style="border: none; background: transparent; margin: 0;" readonly>
          </td>
          <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: center;">
            <button type="button" class="js-remove-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer;">×</button>
          </td>
        </tr>
        @endfor
      </tbody>
    </table>
  </div>
</div>

<!-- Calculations Section -->
<div class="Rectangle-30 hrp-compact">
  <!-- Row 1: Sub Total to Grand Total - 6 fields in one row -->
  <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
    <div>
      <label class="hrp-label">Sub Total</label>
      <input class="Rectangle-29" name="sub_total" id="subTotal" value="{{ old('sub_total', $proforma->sub_total) }}" placeholder="1000" readonly>
    </div>
    <div>
      <label class="hrp-label">Discount Per(%):</label>
      <input type="number" class="Rectangle-29 js-discount-per" name="discount_percent" value="{{ old('discount_percent', $proforma->discount_percent) }}" placeholder="000">
    </div>
    <div>
      <label class="hrp-label">Discount Amount:</label>
      <input class="Rectangle-29" name="discount_amount" id="discountAmount" value="{{ old('discount_amount', $proforma->discount_amount) }}" placeholder="000000" readonly>
    </div>
    <div>
      <label class="hrp-label">Retention per(%):</label>
      <input type="number" class="Rectangle-29 js-retention-per" name="retention_percent" value="{{ old('retention_percent', $proforma->retention_percent ?? 0) }}" placeholder="000">
    </div>
    <div>
      <label class="hrp-label">Retention Amount:</label>
      <input class="Rectangle-29" name="retention_amount" id="retentionAmount" value="{{ old('retention_amount', $proforma->retention_amount ?? 0) }}" placeholder="000" readonly>
    </div>
    <div>
      <label class="hrp-label">Grand Total:</label>
      <input class="Rectangle-29" name="grand_total" id="grandTotal" value="{{ old('sub_total', $proforma->sub_total) }}" placeholder="1000" readonly>
    </div>
  </div>

  <!-- Row 2: Tax Information - 6 fields in one row -->
  <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
    <div>
      <label class="hrp-label">CGST Per(%):</label>
      <input type="number" class="Rectangle-29 js-cgst-per" name="cgst_percent" value="{{ old('cgst_percent', $proforma->cgst_percent) }}" placeholder="1000">
    </div>
    <div>
      <label class="hrp-label">CGST Amount:</label>
      <input class="Rectangle-29" name="cgst_amount" id="cgstAmount" value="{{ old('cgst_amount', $proforma->cgst_amount) }}" placeholder="000" readonly>
    </div>
    <div>
      <label class="hrp-label">SGST Per(%):</label>
      <input type="number" class="Rectangle-29 js-sgst-per" name="sgst_percent" value="{{ old('sgst_percent', $proforma->sgst_percent) }}" placeholder="000000">
    </div>
    <div>
      <label class="hrp-label">SGST Amount:</label>
      <input class="Rectangle-29" name="sgst_amount" id="sgstAmount" value="{{ old('sgst_amount', $proforma->sgst_amount) }}" placeholder="000" readonly>
    </div>
    <div>
      <label class="hrp-label">IGST Per(%):</label>
      <input type="number" class="Rectangle-29 js-igst-per" name="igst_percent" value="{{ old('igst_percent', $proforma->igst_percent) }}" placeholder="000">
    </div>
    <div>
      <label class="hrp-label">IGST Amount:</label>
      <input class="Rectangle-29" name="igst_amount" id="igstAmount" value="{{ old('igst_amount', $proforma->igst_amount) }}" placeholder="0000" readonly>
    </div>
  </div>

  <!-- Row 3: Final Calculations -->
  <div style="display: grid; grid-template-columns: 1fr 1fr 4fr; gap: 1rem;">
    <div>
      <label class="hrp-label">TDS Amount:</label>
      <input type="number" class="Rectangle-29 js-tds-amount" name="tds_amount" value="{{ old('tds_amount', $proforma->tds_amount) }}" placeholder="1000">
    </div>
    <div>
      <label class="hrp-label">Final Amount:</label>
      <input class="Rectangle-29" name="final_amount" id="finalAmount" value="{{ old('final_amount', $proforma->final_amount) }}" placeholder="1000" readonly>
    </div>
    <div>
      <label class="hrp-label">Billing Note:</label>
      <input class="Rectangle-29" name="remark" value="{{ old('remark', $proforma->remark) }}" placeholder="Enter Billing Note">
    </div>
  </div>
</div>

<div style="display:flex;justify-content:end;margin-top:40px;">
  <button type="submit" class="inquiry-submit-btn" style="padding: 15px 40px; font-size: 16px; width: fit-content;">Update Proforma</button>
</div>
</div>

</form>

@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('performas.index') }}">Performas</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Edit Proforma</span>
@endsection

@push('scripts')
<script>
  (function() {
    var wrap = document.getElementById('itemsWrap');
    if (!wrap) return;

    function fmt(n) {
      n = parseFloat(n || 0);
      return isFinite(n) ? n : 0;
    }

    function calcRow(row) {
      var qty = fmt(row.querySelector('.js-qty')?.value);
      var rate = fmt(row.querySelector('.js-rate')?.value);
      var total = (qty * rate).toFixed(2);
      var t = row.querySelector('.js-line-total');
      if (t) t.value = total;
    }

    function subtotal() {
      var sum = 0;
      wrap.querySelectorAll('.js-line-total').forEach(function(i) {
        sum += fmt(i.value);
      });
      document.getElementById('subTotal').value = sum.toFixed(2);
      recalcTaxes();
    }

    function recalcTaxes() {
      var sub = fmt(document.getElementById('subTotal').value);
      var dper = fmt(document.querySelector('.js-discount-per')?.value);
      var rper = fmt(document.querySelector('.js-retention-per')?.value);
      var damt = sub * dper / 100;
      document.getElementById('discountAmount').value = damt.toFixed(2);
      var ramt = (sub - damt) * rper / 100;
      document.getElementById('retentionAmount').value = ramt.toFixed(2);
      var base = sub - damt - ramt;
      var cgper = fmt(document.querySelector('.js-cgst-per')?.value);
      var sgper = fmt(document.querySelector('.js-sgst-per')?.value);
      var igper = fmt(document.querySelector('.js-igst-per')?.value);
      var cg = base * cgper / 100;
      var sg = base * sgper / 100;
      var ig = base * igper / 100;
      document.getElementById('cgstAmount').value = cg.toFixed(2);
      document.getElementById('sgstAmount').value = sg.toFixed(2);
      document.getElementById('igstAmount').value = ig.toFixed(2);
      var tds = fmt(document.querySelector('.js-tds-amount')?.value);
      var grand = base + cg + sg + ig - tds;
      document.getElementById('grandTotal').value = (base + cg + sg + ig).toFixed(2);
      document.getElementById('finalAmount').value = grand.toFixed(2);
    }

    // Event listeners
    wrap.addEventListener('input', function(e) {
      var row = e.target.closest('.item-row');
      if (!row) return;
      calcRow(row);
      subtotal();
    });

    document.addEventListener('input', function(e) {
      if (e.target.matches('.js-discount-per, .js-retention-per, .js-cgst-per, .js-sgst-per, .js-igst-per, .js-tds-amount')) {
        recalcTaxes();
      }
    });

    // Add More functionality
    document.getElementById('addItemBtn')?.addEventListener('click', function() {
      var idx = wrap.querySelectorAll('.item-row').length;
      var newRow = document.createElement('tr');
      newRow.className = 'item-row';
      newRow.setAttribute('data-index', idx);
      newRow.innerHTML = `
        <td style="padding: 12px; border-bottom: 1px solid #eee;">
          <input class="Rectangle-29" name="description[]" placeholder="Enter Description" style="border: none; background: transparent; margin: 0;">
        </td>
        <td style="padding: 12px; border-bottom: 1px solid #eee;">
          <input class="Rectangle-29" name="sac_code[]" placeholder="Enter SAC Code" style="border: none; background: transparent; margin: 0;">
        </td>
        <td style="padding: 12px; border-bottom: 1px solid #eee;">
          <input type="number" min="0" step="1" class="Rectangle-29 js-qty" name="quantity[]" placeholder="Qty" style="border: none; background: transparent; margin: 0;">
        </td>
        <td style="padding: 12px; border-bottom: 1px solid #eee;">
          <input type="number" min="0" step="0.01" class="Rectangle-29 js-rate" name="rate[]" placeholder="Rate" style="border: none; background: transparent; margin: 0;">
        </td>
        <td style="padding: 12px; border-bottom: 1px solid #eee;">
          <input type="number" class="Rectangle-29 js-line-total" name="total[]" placeholder="Total" style="border: none; background: transparent; margin: 0;" readonly>
        </td>
        <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: center;">
          <button type="button" class="js-remove-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer;">×</button>
        </td>
      `;
      wrap.appendChild(newRow);
    });

    // Remove row functionality
    wrap.addEventListener('click', function(e) {
      if (!e.target.classList.contains('js-remove-row')) return;
      var rows = wrap.querySelectorAll('.item-row');
      if (rows.length <= 1) return;
      e.target.closest('.item-row').remove();
      subtotal();
    });

    // Initial calculation
    wrap.querySelectorAll('.item-row').forEach(calcRow);
    subtotal();

    // Ensure calculations run before form submission
    var form = document.getElementById('performaForm');
    if (form) {
      form.addEventListener('submit', function(e) {
        // Recalculate everything before submitting
        wrap.querySelectorAll('.item-row').forEach(calcRow);
        subtotal();
      });
    }
  })();
</script>
@endpush
