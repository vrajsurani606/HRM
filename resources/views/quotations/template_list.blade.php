@extends('layouts.macos')
@section('page_title', 'Template List')

@section('content')
<div class="Rectangle-30 hrp-compact">
  <h3 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 600; color: #111827;">TEMPLATE LIST</h3>
  
  <div style="border-radius: 8px; border: 1px solid #e5e7eb; overflow: hidden;">
    <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
      <table>
        <thead>
          <tr>
            <th>SERIAL NO.</th>
            <th>ACTION</th>
            <th>IS CONFIRM</th>
            <th>COMPANY NAME</th>
            <th>GST NO</th>
            <th>DESCRIPTION</th>
            <th>AMOUNT</th>
            <th>COMPLETION TERM</th>
          </tr>
        </thead>
        <tbody>
          @forelse($quotation->followUps as $index => $followUp)
          <tr @if($followUp->is_confirm) style="background:#ecfdf3;" @endif>
            <td>{{ $index + 1 }}</td>
            <td>
              @if($followUp->is_confirm)
                <a href="{{ route('quotations.create-proforma', $quotation->id) }}" 
                   style="background:#2196f3;color:#ffffff;border:none;border-radius:999px;padding:4px 16px;font-size:12px;font-weight:600;text-decoration:none;display:inline-block;">
                  Proforma Generate
                </a>
              @else
                <span style="color:#9ca3af;">Pending</span>
              @endif
            </td>
            <td>
              @if($followUp->is_confirm)
                <span style="color:#16a34a;font-weight:600;">Confirmed</span>
              @else
                <span style="color:#dc2626;font-weight:600;">No</span>
              @endif
            </td>
            <td>{{ $quotation->company_name }}</td>
            <td>{{ $quotation->gst_no ?? 'N/A' }}</td>
            <td>
              @if($quotation->service_description && is_array($quotation->service_description))
                {{ implode(', ', array_slice($quotation->service_description, 0, 2)) }}
                @if(count($quotation->service_description) > 2)
                  ...
                @endif
              @else
                {{ $quotation->quotation_title }}
              @endif
            </td>
            <td>₹ {{ number_format($quotation->service_contract_amount, 2) }}</td>
            <td>{{ optional($quotation->tentative_complete_date)->format('d-m-Y') ?? 'N/A' }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="8" style="text-align:center;">No confirmed follow-ups found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @if($quotation->proformas->count() > 0)
  <div style="margin-top: 24px;">
    <h4 style="margin: 0 0 12px 0; font-size: 16px; font-weight: 600; color: #111827;">Generated Proformas</h4>
    <div style="border-radius: 8px; border: 1px solid #e5e7eb; overflow: hidden;">
      <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
        <table>
          <thead>
            <tr>
              <th>Proforma Code</th>
              <th>Date</th>
              <th>Company</th>
              <th>Amount</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($quotation->proformas as $proforma)
            <tr>
              <td>{{ $proforma->unique_code }}</td>
              <td>{{ $proforma->proforma_date->format('d-m-Y') }}</td>
              <td>{{ $proforma->company_name }}</td>
              <td>₹ {{ number_format($proforma->final_amount, 2) }}</td>
              <td>
                <a href="#" style="color:#2196f3;text-decoration:none;">View</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endif

  <div style="margin-top: 24px;">
    <a href="{{ route('quotations.index') }}" class="hrp-btn" style="background:#e5e7eb;color:#111827;">Back to Quotations</a>
  </div>
</div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('quotations.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Quotation Management</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Template List</span>
@endsection
