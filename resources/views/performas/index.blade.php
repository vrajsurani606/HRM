@extends('layouts.macos')
@section('page_title', 'Proforma List')
@section('content')

<!-- Filter Row -->
<div class="performa-filter hrp-compact" style="background: #f8f9fa; padding: 12px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
  <input type="text" placeholder="Bill Name" class="Rectangle-29 hrp-compact" style="width: 150px;">
  <input type="text" placeholder="Proforma No." class="Rectangle-29 hrp-compact" style="width: 150px;">
  <input type="text" placeholder="Mobile No." class="Rectangle-29 hrp-compact" style="width: 150px;">
  <input type="text" placeholder="From : dd/mm/yyyy" class="Rectangle-29 hrp-compact" style="width: 170px;">
  <input type="text" placeholder="To : dd/mm/yyyy" class="Rectangle-29 hrp-compact" style="width: 170px;">
  <button style="background: #333; color: white; border: none; border-radius: 50%; width: 35px; height: 35px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
    </svg>
  </button>
  <div style="margin-left: auto; display: flex; gap: 8px;">
    <input type="text" placeholder="Search here.." class="Rectangle-29 hrp-compact" style="padding: 6px 12px; min-width: 160px; background: white;">
    <a href="#" style="background: #28a745; color: white; border: none; border-radius: 20px; padding: 8px 14px; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none;">Excel</a>
    <a href="{{ route('performas.create') }}" style="background: #28a745; color: white; border: none; border-radius: 20px; padding: 8px 14px; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none;">+ Add</a>
  </div>
</div>
<!-- Data Table -->
<div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
  <table style="width: 100%; border-collapse: collapse;">
    <thead>
      <tr style="background: #f8f9fa;">
        <th style="padding: 15px 12px; text-align: left; font-weight: 600; font-size: 14px; color: #333; border-bottom: 1px solid #dee2e6;">Action</th>
        <th style="padding: 15px 12px; text-align: left; font-weight: 600; font-size: 14px; color: #333; border-bottom: 1px solid #dee2e6;">Serial No.</th>
        <th style="padding: 15px 12px; text-align: left; font-weight: 600; font-size: 14px; color: #333; border-bottom: 1px solid #dee2e6;">Proforma No</th>
        <th style="padding: 15px 12px; text-align: left; font-weight: 600; font-size: 14px; color: #333; border-bottom: 1px solid #dee2e6;">Proforma Date.</th>
        <th style="padding: 15px 12px; text-align: left; font-weight: 600; font-size: 14px; color: #333; border-bottom: 1px solid #dee2e6;">Bill To</th>
        <th style="padding: 15px 12px; text-align: left; font-weight: 600; font-size: 14px; color: #333; border-bottom: 1px solid #dee2e6;">Mobile. No.</th>
        <th style="padding: 15px 12px; text-align: left; font-weight: 600; font-size: 14px; color: #333; border-bottom: 1px solid #dee2e6;">Grand Total</th>
        <th style="padding: 15px 12px; text-align: left; font-weight: 600; font-size: 14px; color: #333; border-bottom: 1px solid #dee2e6;">Total Tax</th>
        <th style="padding: 15px 12px; text-align: left; font-weight: 600; font-size: 14px; color: #333; border-bottom: 1px solid #dee2e6;">Total Amount</th>
      </tr>
    </thead>
    <tbody>
      <tr style="border-bottom: 1px solid #f1f5f9;">
          <td class="action-cell">
                <button class="action-btn edit" title="Edit"><img src="{{ asset('action_icon/edit.svg') }}" alt="Edit"></button>
                <button class="action-btn print" title="Print"><img src="{{ asset('action_icon/print.svg') }}" alt="Print"></button>
              </td>
        <td style="padding: 12px; font-size: 14px; color: #333;">1</td>
        <td style="padding: 12px; font-size: 14px; color: #333; font-weight: 600;">CMS/PFM/OO04</td>
        <td style="padding: 12px; font-size: 14px; color: #333;">16-07-2025</td>
        <td style="padding: 12px; font-size: 14px; color: #333;">Human Pathology & Clinical Lab</td>
        <td style="padding: 12px; font-size: 14px; color: #333;">9316187694</td>
        <td style="padding: 12px; font-size: 14px; color: #333; font-weight: 600;">80,000</td>
        <td style="padding: 12px; font-size: 14px; color: #333;">14400</td>
        <td style="padding: 12px; font-size: 14px; color: #28a745; font-weight: 600;">Scheduled</td>
      </tr>
      <tr style="border-bottom: 1px solid #f1f5f9;">
         <td class="action-cell">
                <button class="action-btn edit" title="Edit"><img src="{{ asset('action_icon/edit.svg') }}" alt="Edit"></button>
                <button class="action-btn print" title="Print"><img src="{{ asset('action_icon/print.svg') }}" alt="Print"></button>
              </td>
        <td style="padding: 12px; font-size: 14px; color: #333;">2</td>
        <td style="padding: 12px; font-size: 14px; color: #333; font-weight: 600;">CMS/PFM/OO05</td>
        <td style="padding: 12px; font-size: 14px; color: #333;">16-07-2025</td>
        <td style="padding: 12px; font-size: 14px; color: #333;">QC Chemist</td>
        <td style="padding: 12px; font-size: 14px; color: #333;">9316187694</td>
        <td style="padding: 12px; font-size: 14px; color: #333; font-weight: 600;">2,80,000</td>
        <td style="padding: 12px; font-size: 14px; color: #333;">0</td>
        <td style="padding: 12px; font-size: 14px; color: #dc3545; font-weight: 600;">No</td>
      </tr>
      <tr style="border-bottom: 1px solid #f1f5f9;">
         <td class="action-cell">
                <button class="action-btn edit" title="Edit"><img src="{{ asset('action_icon/edit.svg') }}" alt="Edit"></button>
                <button class="action-btn print" title="Print"><img src="{{ asset('action_icon/print.svg') }}" alt="Print"></button>
              </td>
        <td style="padding: 12px; font-size: 14px; color: #333;">3</td>
        <td style="padding: 12px; font-size: 14px; color: #333; font-weight: 600;">CMS/PFM/OO06</td>
        <td style="padding: 12px; font-size: 14px; color: #333;">16-07-2025</td>
        <td style="padding: 12px; font-size: 14px; color: #333;">Crest Data</td>
        <td style="padding: 12px; font-size: 14px; color: #333;">9316187694</td>
        <td style="padding: 12px; font-size: 14px; color: #333; font-weight: 600;">2,80,000</td>
        <td style="padding: 12px; font-size: 14px; color: #333;">0</td>
        <td style="padding: 12px; font-size: 14px; color: #28a745; font-weight: 600;">Scheduled</td>
      </tr>
      <tr style="border-bottom: 1px solid #f1f5f9;">
         <td class="action-cell">
                <button class="action-btn edit" title="Edit"><img src="{{ asset('action_icon/edit.svg') }}" alt="Edit"></button>
                <button class="action-btn print" title="Print"><img src="{{ asset('action_icon/print.svg') }}" alt="Print"></button>
              </td>
        <td style="padding: 12px; font-size: 14px; color: #333;">4</td>
        <td style="padding: 12px; font-size: 14px; color: #333; font-weight: 600;">CMS/PFM/OO07</td>
        <td style="padding: 12px; font-size: 14px; color: #333;">16-07-2025</td>
        <td style="padding: 12px; font-size: 14px; color: #333;">Narayan Infotech</td>
        <td style="padding: 12px; font-size: 14px; color: #333;">9316187694</td>
        <td style="padding: 12px; font-size: 14px; color: #333; font-weight: 600;">1,40,000</td>
        <td style="padding: 12px; font-size: 14px; color: #333;">50000</td>
        <td style="padding: 12px; font-size: 14px; color: #28a745; font-weight: 600;">Scheduled</td>
      </tr>
    </tbody>
  </table>
</div>

@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('performas.index') }}">Performas</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Proforma List</span>
@endsection
