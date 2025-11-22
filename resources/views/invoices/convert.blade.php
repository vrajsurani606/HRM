@extends('layouts.macos')
@section('page_title', 'Convert to Invoice')

@section('content')

@if(session('error'))
<div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
    <strong>⚠ Error:</strong> {{ session('error') }}
</div>
@endif

<form method="POST" action="{{ route('performas.convert.store', $proforma->id) }}" class="hrp-form">
  @csrf

<div class="hrp-card">
  <div class="Rectangle-30 hrp-compact">
      
      <!-- Proforma Details Section -->
      <div style="background: #E8F0FC; border: 1px solid #C5D9F2; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
        <h3 style="font-size: 16px; font-weight: 700; color: #456DB5; margin-bottom: 15px;">Proforma Details</h3>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
          <div>
            <p style="font-size: 13px; color: #666; margin-bottom: 5px;"><strong>Proforma No:</strong></p>
            <p style="font-size: 14px; color: #000;">{{ $proforma->unique_code }}</p>
          </div>
          <div>
            <p style="font-size: 13px; color: #666; margin-bottom: 5px;"><strong>Company:</strong></p>
            <p style="font-size: 14px; color: #000;">{{ $proforma->company_name }}</p>
          </div>
          <div>
            <p style="font-size: 13px; color: #666; margin-bottom: 5px;"><strong>Amount:</strong></p>
            <p style="font-size: 14px; color: #000; font-weight: 600;">₹{{ number_format($proforma->final_amount, 2) }}</p>
          </div>
        </div>
      </div>

      <!-- Invoice Information -->
      <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
        <div>
          <label class="hrp-label">Invoice Type: <span class="text-red-500">*</span></label>
          <select class="Rectangle-29-select @error('invoice_type') is-invalid @enderror" name="invoice_type" id="invoiceType" required>
            <option value="">Select Type</option>
            <option value="gst" {{ old('invoice_type') == 'gst' ? 'selected' : '' }} {{ $hasGstInvoice ? 'disabled' : '' }}>
              GST Invoice {{ $hasGstInvoice ? '(Already Generated)' : '' }}
            </option>
            <option value="without_gst" {{ old('invoice_type') == 'without_gst' ? 'selected' : '' }} {{ $hasWithoutGstInvoice ? 'disabled' : '' }}>
              Without GST Invoice {{ $hasWithoutGstInvoice ? '(Already Generated)' : '' }}
            </option>
          </select>
          @error('invoice_type')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>

        <div>
          <label class="hrp-label">Invoice No:</label>
          <input type="text" class="Rectangle-29" id="invoiceNo" value="Select invoice type first" readonly style="background: #f3f4f6;">
        </div>
        
        <div>
          <label class="hrp-label">Invoice Date: <span class="text-red-500">*</span></label>
          <input type="date" class="Rectangle-29 @error('invoice_date') is-invalid @enderror" name="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}" required>
          @error('invoice_date')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>

  </div>
</div>

<!-- Action Buttons -->
<div class="hrp-actions" style="margin-top: 30px;">
  <button type="submit" class="hrp-btn hrp-btn-primary">
    Convert to Invoice
  </button>
  <a href="{{ route('performas.index') }}" class="hrp-btn hrp-btn-secondary">
    Cancel
  </a>
</div>

</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const invoiceTypeSelect = document.getElementById('invoiceType');
  const invoiceNoInput = document.getElementById('invoiceNo');
  
  const gstCode = '{{ $nextGstCode }}';
  const wgCode = '{{ $nextWgCode }}';
  
  invoiceTypeSelect.addEventListener('change', function() {
    if (this.value === 'gst') {
      invoiceNoInput.value = gstCode;
    } else if (this.value === 'without_gst') {
      invoiceNoInput.value = wgCode;
    } else {
      invoiceNoInput.value = 'Select invoice type first';
    }
  });
  
  // Set initial value if type is already selected
  if (invoiceTypeSelect.value === 'gst') {
    invoiceNoInput.value = gstCode;
  } else if (invoiceTypeSelect.value === 'without_gst') {
    invoiceNoInput.value = wgCode;
  }
});
</script>

@endsection
