@extends('layouts.macos')
@section('page_title', 'Edit Invoice')

@section('content')

@if(session('error'))
<div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
    <strong>⚠ Error:</strong> {{ session('error') }}
</div>
@endif

<form method="POST" action="{{ route('invoices.update', $invoice->id) }}" class="hrp-form">
  @csrf
  @method('PUT')

<div class="hrp-card">
  <div class="Rectangle-30 hrp-compact">
      
      <!-- Invoice Details Section -->
      <div style="background: #E8F0FC; border: 1px solid #C5D9F2; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
        <h3 style="font-size: 16px; font-weight: 700; color: #456DB5; margin-bottom: 15px;">Invoice Information</h3>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
          <div>
            <p style="font-size: 13px; color: #666; margin-bottom: 5px;"><strong>Invoice Type:</strong></p>
            <p style="font-size: 14px; color: #000;">
              @if($invoice->invoice_type == 'gst')
                <span style="background: #E8F0FC; color: #456DB5; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">GST Invoice</span>
              @else
                <span style="background: #FEF3C7; color: #92400E; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Without GST</span>
              @endif
            </p>
          </div>
          @if($invoice->proforma)
          <div>
            <p style="font-size: 13px; color: #666; margin-bottom: 5px;"><strong>Proforma No:</strong></p>
            <p style="font-size: 14px; color: #000;">{{ $invoice->proforma->unique_code }}</p>
          </div>
          @endif
          <div>
            <p style="font-size: 13px; color: #666; margin-bottom: 5px;"><strong>Company:</strong></p>
            <p style="font-size: 14px; color: #000;">{{ $invoice->company_name }}</p>
          </div>
        </div>
      </div>

      <!-- Editable Fields -->
      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
        <div>
          <label class="hrp-label">Invoice No: <span class="text-red-500">*</span></label>
          <input type="text" class="Rectangle-29 @error('unique_code') is-invalid @enderror" name="unique_code" value="{{ old('unique_code', $invoice->unique_code) }}" required>
          @error('unique_code')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        
        <div>
          <label class="hrp-label">Invoice Date: <span class="text-red-500">*</span></label>
          <input type="date" class="Rectangle-29 @error('invoice_date') is-invalid @enderror" name="invoice_date" value="{{ old('invoice_date', $invoice->invoice_date ? $invoice->invoice_date->format('Y-m-d') : '') }}" required>
          @error('invoice_date')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>

      <!-- Read-only Information -->
      <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
        <h4 style="font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 15px;">Invoice Summary (Read-only)</h4>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
          <div>
            <p style="font-size: 12px; color: #6b7280; margin-bottom: 3px;">Subtotal</p>
            <p style="font-size: 14px; color: #111827; font-weight: 600;">₹{{ number_format($invoice->sub_total ?? 0, 2) }}</p>
          </div>
          @if($invoice->discount_amount > 0)
          <div>
            <p style="font-size: 12px; color: #6b7280; margin-bottom: 3px;">Discount</p>
            <p style="font-size: 14px; color: #111827; font-weight: 600;">₹{{ number_format($invoice->discount_amount, 2) }}</p>
          </div>
          @endif
          @if($invoice->invoice_type === 'gst' && $invoice->total_tax_amount > 0)
          <div>
            <p style="font-size: 12px; color: #6b7280; margin-bottom: 3px;">Total Tax</p>
            <p style="font-size: 14px; color: #111827; font-weight: 600;">₹{{ number_format($invoice->total_tax_amount, 2) }}</p>
          </div>
          @endif
          <div>
            <p style="font-size: 12px; color: #6b7280; margin-bottom: 3px;">Final Amount</p>
            <p style="font-size: 16px; color: #456DB5; font-weight: 700;">₹{{ number_format($invoice->final_amount ?? 0, 2) }}</p>
          </div>
        </div>
      </div>

  </div>
</div>

<!-- Action Buttons -->
<div class="hrp-actions" style="margin-top: 30px;">
  <button type="submit" class="hrp-btn hrp-btn-primary">
    Update Invoice
  </button>
  <a href="{{ route('invoices.index') }}" class="hrp-btn hrp-btn-secondary">
    Cancel
  </a>
</div>

</form>

@endsection
