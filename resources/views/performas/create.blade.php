@extends('layouts.macos')
@section('page_title', 'Add Proforma')
@section('content')
<div class="hrp-card">
  <div class="Rectangle-30 hrp-compact">
    <form method="POST" action="{{ route('performas.store') }}" id="performaForm" class="hrp-form">
      @csrf
      
      <!-- Row 1: Basic Information - 4 equal columns -->
      <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
        <div>
          <label class="hrp-label">Unique Code:</label>
          <input type="text" class="Rectangle-29" name="unique_code" value="CMS/LEAD/OO22" readonly>
        </div>
        <div>
          <label class="hrp-label">Proforma Date:</label>
          <input type="date" class="Rectangle-29" name="proforma_date" placeholder="dd/mm/yyyy">
        </div>
        <div>
          <label class="hrp-label">Type Of Billing:</label>
          <select class="Rectangle-29-select" name="billing_type">
            <option value="">Select</option>
            <option>ADVANCE</option>
            <option>AMC</option>
            <option>HALF</option>
            <option>FINAL</option>
            <option>RETENTION</option>
          </select>
        </div>
        <div>
          <label class="hrp-label">Bill To :</label>
          <input type="text" class="Rectangle-29" name="bill_to" placeholder="Enter Bill to..">
        </div>
      </div>

      <!-- Row 2: Company Information - 2 columns each -->
      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
        <div>
          <label class="hrp-label">Select Company:</label>
          <select class="Rectangle-29-select" name="company_id">
            <option value="">-- Select Company --</option>
          </select>
        </div>
        <div>
          <label class="hrp-label">Address :</label>
          <textarea class="Rectangle-29 Rectangle-29-textarea" name="address" placeholder="Enter Your Address." style="min-height:80px"></textarea>
        </div>
      </div>

      <!-- Row 3: GST and Mobile - 2 columns each -->
      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
        <div>
          <label class="hrp-label">GST No :</label>
          <input type="text" class="Rectangle-29" name="gst_no" placeholder="Enter GS no.">
        </div>
        <div>
          <label class="hrp-label">Mobile No :</label>
          <input type="text" class="Rectangle-29" name="mobile" placeholder="Enter Mobile No..">
        </div>
      </div>
    </form>
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
        <tr class="item-row" data-index="0">
          <td style="padding: 12px; border-bottom: 1px solid #eee;">
            <input class="Rectangle-29" name="items[0][description]" placeholder="Enter Description" style="border: none; background: transparent; margin: 0;">
          </td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;">
            <input class="Rectangle-29" name="items[0][sac]" placeholder="Enter SAC Code" style="border: none; background: transparent; margin: 0;">
          </td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;">
            <input type="number" min="0" step="1" class="Rectangle-29 js-qty" name="items[0][qty]" placeholder="Enter SAC Code" style="border: none; background: transparent; margin: 0;">
          </td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;">
            <input type="number" min="0" step="0.01" class="Rectangle-29 js-rate" name="items[0][rate]" placeholder="Enter SAC Code" style="border: none; background: transparent; margin: 0;">
          </td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;">
            <input type="number" class="Rectangle-29 js-line-total" name="items[0][total]" placeholder="Enter SAC Code" style="border: none; background: transparent; margin: 0;" readonly>
          </td>
          <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: center;">
            <button type="button" class="js-remove-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer;">×</button>
          </td>
        </tr>
        <tr class="item-row" data-index="1">
          <td style="padding: 12px; border-bottom: 1px solid #eee;">
            <input class="Rectangle-29" name="items[1][description]" placeholder="Enter Description" style="border: none; background: transparent; margin: 0;">
          </td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;">
            <input class="Rectangle-29" name="items[1][sac]" placeholder="Enter SAC Code" style="border: none; background: transparent; margin: 0;">
          </td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;">
            <input type="number" min="0" step="1" class="Rectangle-29 js-qty" name="items[1][qty]" placeholder="Enter SAC Code" style="border: none; background: transparent; margin: 0;">
          </td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;">
            <input type="number" min="0" step="0.01" class="Rectangle-29 js-rate" name="items[1][rate]" placeholder="Enter SAC Code" style="border: none; background: transparent; margin: 0;">
          </td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;">
            <input type="number" class="Rectangle-29 js-line-total" name="items[1][total]" placeholder="Enter SAC Code" style="border: none; background: transparent; margin: 0;" readonly>
          </td>
          <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: center;">
            <button type="button" class="js-remove-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer;">×</button>
          </td>
        </tr>
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
      <input class="Rectangle-29" name="sub_total" id="subTotal" placeholder="1000" readonly>
    </div>
    <div>
      <label class="hrp-label">Discount Per(%):</label>
      <input type="number" class="Rectangle-29 js-discount-per" name="discount_per" placeholder="000">
    </div>
    <div>
      <label class="hrp-label">Discount Amount:</label>
      <input class="Rectangle-29" name="discount_amount" id="discountAmount" placeholder="000000" readonly>
    </div>
    <div>
      <label class="hrp-label">Retention per(%):</label>
      <input type="number" class="Rectangle-29 js-retention-per" name="retention_per" placeholder="000">
    </div>
    <div>
      <label class="hrp-label">Retention Amount:</label>
      <input class="Rectangle-29" name="retention_amount" id="retentionAmount" placeholder="000" readonly>
    </div>
    <div>
      <label class="hrp-label">Grand Total:</label>
      <input class="Rectangle-29" name="grand_total" id="grandTotal" placeholder="1000" readonly>
    </div>
  </div>

  <!-- Row 2: Tax Information - 6 fields in one row -->
  <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
    <div>
      <label class="hrp-label">CGST Per(%):</label>
      <input type="number" class="Rectangle-29 js-cgst-per" name="cgst_per" placeholder="1000">
    </div>
    <div>
      <label class="hrp-label">CGST Amount:</label>
      <input class="Rectangle-29" name="cgst_amount" id="cgstAmount" placeholder="000" readonly>
    </div>
    <div>
      <label class="hrp-label">SGST Per(%):</label>
      <input type="number" class="Rectangle-29 js-sgst-per" name="sgst_per" placeholder="000000">
    </div>
    <div>
      <label class="hrp-label">SGST Amount:</label>
      <input class="Rectangle-29" name="sgst_amount" id="sgstAmount" placeholder="000" readonly>
    </div>
    <div>
      <label class="hrp-label">IGST Per(%):</label>
      <input type="number" class="Rectangle-29 js-igst-per" name="igst_per" placeholder="000">
    </div>
    <div>
      <label class="hrp-label">IGST Amount:</label>
      <input class="Rectangle-29" name="igst_amount" id="igstAmount" placeholder="0000" readonly>
    </div>
  </div>

  <!-- Row 3: Final Calculations -->
  <div style="display: grid; grid-template-columns: 1fr 1fr 4fr; gap: 1rem;">
    <div>
      <label class="hrp-label">TDS Amount:</label>
      <input type="number" class="Rectangle-29 js-tds-amount" name="tds_amount" placeholder="1000">
    </div>
    <div>
      <label class="hrp-label">Final Amount:</label>
      <input class="Rectangle-29" name="final_amount" id="finalAmount" placeholder="1000" readonly>
    </div>
    <div>
      <label class="hrp-label">Billing Note:</label>
      <input class="Rectangle-29" name="billing_note" placeholder="Enter Billing Note">
    </div>
  </div>
</div>

<div style="display:flex;justify-content:end;margin-top:40px;">
  <button type="submit" form="performaForm" class="inquiry-submit-btn" style="padding: 15px 40px; font-size: 16px; width: fit-content;">Add Proforma</button>
</div>
</div>

@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('performas.index') }}">Performas</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Add Proforma</span>
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
          <input class="Rectangle-29" name="items[${idx}][description]" placeholder="Enter Description" style="border: none; background: transparent; margin: 0;">
        </td>
        <td style="padding: 12px; border-bottom: 1px solid #eee;">
          <input class="Rectangle-29" name="items[${idx}][sac]" placeholder="Enter SAC Code" style="border: none; background: transparent; margin: 0;">
        </td>
        <td style="padding: 12px; border-bottom: 1px solid #eee;">
          <input type="number" min="0" step="1" class="Rectangle-29 js-qty" name="items[${idx}][qty]" placeholder="Enter SAC Code" style="border: none; background: transparent; margin: 0;">
        </td>
        <td style="padding: 12px; border-bottom: 1px solid #eee;">
          <input type="number" min="0" step="0.01" class="Rectangle-29 js-rate" name="items[${idx}][rate]" placeholder="Enter SAC Code" style="border: none; background: transparent; margin: 0;">
        </td>
        <td style="padding: 12px; border-bottom: 1px solid #eee;">
          <input type="number" class="Rectangle-29 js-line-total" name="items[${idx}][total]" placeholder="Enter SAC Code" style="border: none; background: transparent; margin: 0;" readonly>
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
  })();
</script>
@endpush