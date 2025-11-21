@extends('layouts.macos')
@section('page_title', 'Proforma Invoice')

@section('content')

<div id="printable-area" style="max-width: 900px; margin: 0 auto; background: white; padding: 40px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
  
  <!-- Company Logo and Header -->
  <div style="margin-bottom: 30px;">
    <div style="text-align: center; margin-bottom: 20px;">
      <img src="{{ asset('full_logo.jpeg') }}" alt="Company Logo" style="max-width: 180px; height: auto; display: inline-block;">
    </div>
    
    <div style="text-align: right;">
      <p style="margin: 4px 0; font-size: 14px; color: #374151;"><strong>Date:</strong> {{ $proforma->proforma_date ? $proforma->proforma_date->format('d-m-Y') : date('d-m-Y') }}</p>
      <p style="margin: 4px 0; font-size: 14px; color: #374151;"><strong>Proforma No.:</strong> {{ $proforma->unique_code }}</p>
    </div>
  </div>

  <!-- Title -->
  <div style="text-align: center; margin-bottom: 30px; padding-bottom: 15px; border-bottom: 3px solid #1e40af;">
    <h1 style="margin: 0; font-size: 28px; font-weight: 700; color: #1e40af; letter-spacing: 1px;">PROFORMA INVOICE</h1>
  </div>

  <!-- From and Bill To Section -->
  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 30px;">
    <!-- From Section -->
    <div>
      <h3 style="margin: 0 0 12px 0; font-size: 16px; font-weight: 700; color: #1e40af;">From</h3>
      <div style="font-size: 14px; line-height: 1.8; color: #374151;">
        <p style="margin: 0; font-weight: 600;">CHITRI ENLARGE SOFT IT HUB PVT. LTD.</p>
        <p style="margin: 0;">401/B, RISE ON PLAZA, SARKHEJ JAKAT NAKA,</p>
        <p style="margin: 0;">SURAT, 390006.</p>
        <p style="margin: 0;">GST. NO.: 24AAMCC4413E1Z1</p>
        <p style="margin: 0;">Mo. (+91) 72763 23999</p>
      </div>
    </div>

    <!-- Bill To Section -->
    <div>
      <h3 style="margin: 0 0 12px 0; font-size: 16px; font-weight: 700; color: #1e40af;">BILL TO</h3>
      <div style="font-size: 14px; line-height: 1.8; color: #374151;">
        <p style="margin: 0; font-weight: 600;">{{ strtoupper($proforma->company_name) }}</p>
        @if($proforma->address)
        <p style="margin: 0;">{{ $proforma->address }}</p>
        @endif
        @if($proforma->gst_no)
        <p style="margin: 0;">GST. NO.: {{ $proforma->gst_no }}</p>
        @endif
        @if($proforma->mobile_no)
        <p style="margin: 0;">Mo. {{ $proforma->mobile_no }}</p>
        @endif
      </div>
    </div>
  </div>

  <!-- Items Table -->
  <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
    <thead>
      <tr style="background: #1e40af; color: white;">
        <th style="padding: 12px; text-align: left; font-weight: 600; border: 1px solid #1e40af;">DESCRIPTION</th>
        <th style="padding: 12px; text-align: center; font-weight: 600; border: 1px solid #1e40af; width: 80px;">SAC</th>
        <th style="padding: 12px; text-align: center; font-weight: 600; border: 1px solid #1e40af; width: 80px;">QTY</th>
        <th style="padding: 12px; text-align: right; font-weight: 600; border: 1px solid #1e40af; width: 150px;">UNIT PRICE (INR)</th>
        <th style="padding: 12px; text-align: right; font-weight: 600; border: 1px solid #1e40af; width: 150px;">TOTAL</th>
      </tr>
    </thead>
    <tbody>
      @php
        $descriptions = is_array($proforma->description) ? $proforma->description : [];
        $sacCodes = is_array($proforma->sac_code) ? $proforma->sac_code : [];
        $quantities = is_array($proforma->quantity) ? $proforma->quantity : [];
        $rates = is_array($proforma->rate) ? $proforma->rate : [];
        $totals = is_array($proforma->total) ? $proforma->total : [];
        $maxCount = max(count($descriptions), count($sacCodes), count($quantities), count($rates), count($totals));
      @endphp
      
      @for($i = 0; $i < $maxCount; $i++)
      @if(!empty($descriptions[$i]) || !empty($quantities[$i]))
      <tr>
        <td style="padding: 12px; border: 1px solid #e5e7eb; font-size: 14px;">{{ $descriptions[$i] ?? '-' }}</td>
        <td style="padding: 12px; border: 1px solid #e5e7eb; text-align: center; font-size: 14px;">{{ $sacCodes[$i] ?? 'df' }}</td>
        <td style="padding: 12px; border: 1px solid #e5e7eb; text-align: center; font-size: 14px;">{{ $quantities[$i] ?? '-' }}</td>
        <td style="padding: 12px; border: 1px solid #e5e7eb; text-align: right; font-size: 14px;">{{ isset($rates[$i]) ? number_format($rates[$i], 2) : '-' }}</td>
        <td style="padding: 12px; border: 1px solid #e5e7eb; text-align: right; font-size: 14px; font-weight: 600;">{{ isset($totals[$i]) ? number_format($totals[$i], 2) : '-' }}</td>
      </tr>
      @endif
      @endfor
    </tbody>
  </table>

  <!-- Bank Details and Totals Section -->
  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px;">
    <!-- Bank Details -->
    <div>
      <h4 style="margin: 0 0 12px 0; font-size: 16px; font-weight: 700; color: #1e40af;">Bank Details</h4>
      <div style="font-size: 13px; line-height: 1.8; color: #374151;">
        <p style="margin: 0;"><strong>Account No:</strong> 001161900016923</p>
        <p style="margin: 0;"><strong>IFSC Code:</strong> YESB0000011</p>
        <p style="margin: 0;"><strong>Branch:</strong> YES BANK LTD., GR FLOOR,</p>
        <p style="margin: 0;">MANGALDEEP, RING ROAD,</p>
        <p style="margin: 0;">NEAR MAHAVIR HOSPITAL, NEAR RTO,</p>
        <p style="margin: 0;">SURAT 395001.</p>
      </div>
    </div>

    <!-- Totals -->
    <div>
      <table style="width: 100%; font-size: 14px;">
        <tr>
          <td style="padding: 8px 12px; text-align: right; color: #374151;">Subtotal</td>
          <td style="padding: 8px 12px; text-align: right; font-weight: 600;">₹{{ number_format($proforma->sub_total ?? 0, 2) }}</td>
        </tr>
        @if($proforma->discount_amount > 0)
        <tr>
          <td style="padding: 8px 12px; text-align: right; color: #374151;">Discount ({{ $proforma->discount_percent }}%)</td>
          <td style="padding: 8px 12px; text-align: right; font-weight: 600;">₹{{ number_format($proforma->discount_amount, 2) }}</td>
        </tr>
        @endif
        @if($proforma->cgst_amount > 0)
        <tr>
          <td style="padding: 8px 12px; text-align: right; color: #374151;">CGST ({{ $proforma->cgst_percent }}%)</td>
          <td style="padding: 8px 12px; text-align: right; font-weight: 600;">₹{{ number_format($proforma->cgst_amount, 2) }}</td>
        </tr>
        @endif
        @if($proforma->sgst_amount > 0)
        <tr>
          <td style="padding: 8px 12px; text-align: right; color: #374151;">SGST ({{ $proforma->sgst_percent }}%)</td>
          <td style="padding: 8px 12px; text-align: right; font-weight: 600;">₹{{ number_format($proforma->sgst_amount, 2) }}</td>
        </tr>
        @endif
        <tr style="background: #1e40af; color: white;">
          <td style="padding: 12px; text-align: right; font-weight: 700; font-size: 16px;">Total Amount</td>
          <td style="padding: 12px; text-align: right; font-weight: 700; font-size: 16px;">₹{{ number_format($proforma->final_amount ?? 0, 2) }}</td>
        </tr>
      </table>
      
      <div style="margin-top: 15px; padding: 12px; background: #dbeafe; text-align: center; border-radius: 4px;">
        <p style="margin: 0; font-size: 16px; font-weight: 700; color: #1e40af;">Balance Due</p>
        <p style="margin: 4px 0 0 0; font-size: 20px; font-weight: 700; color: #1e40af;">₹{{ number_format($proforma->final_amount ?? 0, 2) }} /-</p>
      </div>
    </div>
  </div>

  <!-- Signatures -->
  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 60px;">
    <div>
      <p style="margin: 0; font-size: 14px; font-weight: 600; color: #1e40af;">Company Signature</p>
      <div style="height: 60px; border-bottom: 1px solid #e5e7eb; margin-top: 40px;"></div>
    </div>
    <div style="text-align: right;">
      <p style="margin: 0; font-size: 14px; font-weight: 600; color: #1e40af;">Client Signature</p>
      <div style="height: 60px; border-bottom: 1px solid #e5e7eb; margin-top: 40px;"></div>
    </div>
  </div>

  <!-- Action Buttons (No Print) -->
  <div class="no-print" style="display: flex; justify-content: space-between; margin-top: 40px; padding-top: 20px; border-top: 2px solid #e5e7eb;">
    <a href="{{ route('performas.index') }}" class="pill-btn" style="background: #6b7280; color: white; padding: 12px 24px; text-decoration: none;">← Back to List</a>
    <div style="display: flex; gap: 10px;">
      <a href="{{ route('performas.edit', $proforma->id) }}" class="pill-btn" style="background: #3b82f6; color: white; padding: 12px 24px; text-decoration: none;">Edit</a>
      <button onclick="window.print()" class="pill-btn pill-success" style="padding: 12px 24px; border: none; cursor: pointer;">Print / PDF</button>
    </div>
  </div>
</div>

@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('performas.index') }}">Performas</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">{{ $proforma->unique_code }}</span>
@endsection

@push('styles')
<style>
@media print {
  .no-print {
    display: none !important;
  }
  @page {
    margin: 1cm;
    size: A4;
  }
}
</style>
@endpush
