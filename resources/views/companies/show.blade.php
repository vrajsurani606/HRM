@extends('layouts.macos')
@section('page_title', $company->company_name . ' - Company Details')

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('companies.index') }}">Company Management</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">{{ $company->company_name }}</span>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 10px 15px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Top two-column details -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2px; margin-bottom: 30px; background: #e5e7eb;">
      <div style="background: white; padding: 20px; display: flex; flex-direction: column; align-items: center;">
        <h3 style="font-weight: 600; margin-bottom: 20px; color: #333; background: #F0F0F0; padding: 10px; text-align: center; border-radius: 6px; width: 100%;">Company Details</h3>
        <div style="display: flex; flex-direction: column; gap: 8px; width: 100%;">
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Unique Code</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->unique_code ? $company->unique_code : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Company Name</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->company_name ? $company->company_name : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Company Address</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->company_address ? $company->company_address : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Company Gst No</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->gst_no ? $company->gst_no : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Company Pan No</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->pan_no ? $company->pan_no : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Other</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->other_details ? $company->other_details : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Company Type</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->company_type ? $company->company_type : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Company Email</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->company_email ? $company->company_email : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Company Password</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->company_password ? $company->company_password : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Company Employee Email</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->company_employee_email ? $company->company_employee_email : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Company Employee Password</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->company_employee_password ? $company->company_employee_password : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Company City</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->city ? $company->city : '-' }}</span>
          </div>
        </div>
      </div>
      <div style="background: white; padding: 20px; display: flex; flex-direction: column; align-items: center;">
        <h3 style="font-weight: 600; margin-bottom: 20px; color: #333; background: #F0F0F0; padding: 10px; text-align: center; border-radius: 6px; width: 100%;">Person's Details</h3>
        <div style="display: flex; flex-direction: column; gap: 8px; width: 100%;">
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Person Name</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->person_name_1 ? $company->person_name_1 : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Person Number</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->person_number_1 ? $company->person_number_1 : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Person Position</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->person_position_1 ? $company->person_position_1 : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Person Name</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->person_name_2 ? $company->person_name_2 : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Person Number</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->person_number_2 ? $company->person_number_2 : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Person Position</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->person_position_2 ? $company->person_position_2 : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Person Name</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->person_name_3 ? $company->person_name_3 : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Person Number</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->person_number_3 ? $company->person_number_3 : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 6px 0;">
            <span style="color: #333; font-weight: 500; width: 320px; text-align: left;">Person Position</span>
            <span style="color: #333; width: 40px; text-align: center; font-weight: 600; display: flex; justify-content: center;">:</span>
            <span style="color: #333; font-weight: 600; text-align: left; flex: 1;">{{ $company->person_position_3 ? $company->person_position_3 : '-' }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Documents Row -->
    <div style="margin-bottom: 30px;">
      <div style="font-weight: 600; margin-bottom: 15px; color: #333;">All Documents :</div>
      <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px;">
        <!-- Company Logo -->
        <div style="background: white; border-radius: 8px; padding: 15px; border: 1px solid #e5e7eb;">
          <div style="font-size: 14px; margin-bottom: 10px; color: #666;">Company Logo</div>
          <div style="border: 1px solid #e5e7eb; border-radius: 6px; display: flex; align-items: center; justify-content: center; height: 120px; background: #f9fafb; position: relative;">
            @if($company->company_logo)
              <img src="{{ $company->logo_url }}" alt="Company Logo" style="max-height: 100px; max-width: 100px; object-fit: contain;">
            @else
              <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; color: #666;">
                <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24" style="margin-bottom: 8px;">
                  <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                </svg>
                <span style="font-size: 12px;">No Logo</span>
              </div>
            @endif
            <div style="position: absolute; top: 8px; right: 8px; background: #000; border-radius: 4px; padding: 6px; cursor: pointer;">
              <svg width="16" height="16" fill="white" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
            </div>
          </div>
        </div>
        
        <!-- SOP Upload -->
        <div style="background: white; border-radius: 8px; padding: 15px; border: 1px solid #e5e7eb;">
          <div style="font-size: 14px; margin-bottom: 10px; color: #666;">Sop Upload</div>
          <div style="border: 1px solid #e5e7eb; border-radius: 6px; display: flex; align-items: center; justify-content: center; height: 120px; background: #f9fafb; position: relative;">
            @if($company->sop_upload)
              @php
                $extension = strtolower(pathinfo($company->sop_upload, PATHINFO_EXTENSION));
                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
              @endphp
              @if($isImage)
                <img src="{{ $company->sop_url }}" alt="SOP Document" style="max-height: 100px; max-width: 100px; object-fit: contain;">
              @else
                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; color: #666;">
                  <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24" style="margin-bottom: 8px;">
                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                  </svg>
                  <span style="font-size: 12px;">{{ strtoupper($extension) }}</span>
                </div>
              @endif
            @else
              <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; color: #666;">
                <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24" style="margin-bottom: 8px;">
                  <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                </svg>
                <span style="font-size: 12px;">No SOP</span>
              </div>
            @endif
            <div style="position: absolute; top: 8px; right: 8px; background: #000; border-radius: 4px; padding: 6px; cursor: pointer;">
              <svg width="16" height="16" fill="white" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
            </div>
          </div>
        </div>
        
        <!-- Leaser Report Non-GST -->
        <div style="background: white; border-radius: 8px; padding: 15px; border: 1px solid #e5e7eb;">
          <div style="font-size: 14px; margin-bottom: 10px; color: #666;">Leaser Report ( Non-GST )</div>
          <div style="border: 1px solid #e5e7eb; border-radius: 6px; display: flex; align-items: center; justify-content: center; height: 120px; background: #f9fafb; position: relative;">
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; color: #666;">
              <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24" style="margin-bottom: 8px;">
                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
              </svg>
              <span style="font-size: 12px;">No Report</span>
            </div>
            <div style="position: absolute; top: 8px; right: 8px; background: #000; border-radius: 4px; padding: 6px; cursor: pointer;">
              <svg width="16" height="16" fill="white" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
            </div>
          </div>
        </div>
        
        <!-- Leaser Report GST 18% -->
        <div style="background: white; border-radius: 8px; padding: 15px; border: 1px solid #e5e7eb;">
          <div style="font-size: 14px; margin-bottom: 10px; color: #666;">Leaser Report ( GST 18% )</div>
          <div style="border: 1px solid #e5e7eb; border-radius: 6px; display: flex; align-items: center; justify-content: center; height: 120px; background: #f9fafb; position: relative;">
            @if($company->quotation_upload)
              @php
                $extension = strtolower(pathinfo($company->quotation_upload, PATHINFO_EXTENSION));
                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
              @endphp
              @if($isImage)
                <img src="{{ $company->quotation_url }}" alt="Quotation Document" style="max-height: 100px; max-width: 100px; object-fit: contain;">
              @else
                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; color: #666;">
                  <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24" style="margin-bottom: 8px;">
                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                  </svg>
                  <span style="font-size: 12px;">{{ strtoupper($extension) }}</span>
                </div>
              @endif
            @else
              <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; color: #666;">
                <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24" style="margin-bottom: 8px;">
                  <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                </svg>
                <span style="font-size: 12px;">No Report</span>
              </div>
            @endif
            <div style="position: absolute; top: 8px; right: 8px; background: #000; border-radius: 4px; padding: 6px; cursor: pointer;">
              <svg width="16" height="16" fill="white" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
            </div>
          </div>
        </div>
        
        <!-- Upload Button -->
        <div style="background: white; border-radius: 8px; padding: 15px; border: 1px solid #e5e7eb;">
          <div style="font-size: 14px; margin-bottom: 10px; color: #666;">&nbsp;</div>
          <div style="border: 2px dashed #d1d5db; border-radius: 6px; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 120px; background: #4b5563; cursor: pointer;" onclick="document.getElementById('fileUpload').click()">
            <svg width="24" height="24" fill="white" viewBox="0 0 24 24" style="margin-bottom: 8px;">
              <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
              <path d="M12,11L16,15H13V19H11V15H8L12,11Z"/>
            </svg>
            <span style="color: white; font-size: 14px; font-weight: 600;">Upload</span>
            <input type="file" id="fileUpload" style="display: none;" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
          </div>
        </div>
      </div>
    </div>

    <!-- Tabs -->
    <div style="margin-bottom: 20px;">
      <div style="display: flex; gap: 8px; overflow-x: auto; padding-bottom: 10px; border-bottom: 1px solid #e5e7eb;">
        <button style="background: #000; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 14px; cursor: pointer;" data-tab="quotation">🗂️ Quotation List</button>
        <button style="background: #f3f4f6; color: #374151; border: none; padding: 8px 16px; border-radius: 6px; font-size: 14px; cursor: pointer;" data-tab="template">📋 Template List</button>
        <button style="background: #f3f4f6; color: #374151; border: none; padding: 8px 16px; border-radius: 6px; font-size: 14px; cursor: pointer;" data-tab="proforma">📄 Proforma Mana.</button>
        <button style="background: #f3f4f6; color: #374151; border: none; padding: 8px 16px; border-radius: 6px; font-size: 14px; cursor: pointer;" data-tab="invoice">🧾 Invoice Mana.</button>
        <button style="background: #f3f4f6; color: #374151; border: none; padding: 8px 16px; border-radius: 6px; font-size: 14px; cursor: pointer;" data-tab="receipt">🧾 The Receipt</button>
        <button style="background: #f3f4f6; color: #374151; border: none; padding: 8px 16px; border-radius: 6px; font-size: 14px; cursor: pointer;" data-tab="project">📋 Project</button>
        <button style="background: #f3f4f6; color: #374151; border: none; padding: 8px 16px; border-radius: 6px; font-size: 14px; cursor: pointer;" data-tab="ticket">🎫 Ticket</button>
      </div>

      <!-- Tab contents -->
      <div id="tab-quotation" style="margin-top: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <input type="text" placeholder="Search here..." style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; width: 200px;">
          </div>
          <div style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 10px;">
      <a href="{{ route('companies.edit', $company->unique_code) }}" style="background: #3b82f6; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 5px; text-decoration: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        Edit
      </a>
      <form action="{{ route('companies.destroy', $company->unique_code) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" style="background: #ef4444; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 5px;" onclick="return confirm('Are you sure you want to delete this company?')">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
          Delete
        </button>
      </form>
    </div>      </div>
        </div>
        <div style="overflow-x: auto; background: white; border-radius: 8px; border: 1px solid #e5e7eb;">
          <table style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Status</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Serial No</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Unique No</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Quotation Amount</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">AMC Start Date</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">AMC Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 12px;">
                  <div style="display: flex; gap: 8px; align-items: center;">
                    <img src="{{ asset('action_icon/completed.svg') }}" alt="completed" style="width: 20px; height: 20px;">
                  </div>
                </td>
                <td style="padding: 12px; color: #374151;">1</td>
                <td style="padding: 12px; color: #374151;">CEI/QUAT/0001</td>
                <td style="padding: 12px; color: #374151;">3,80,000.00</td>
                <td style="padding: 12px; color: #374151;">30-10-2025</td>
                <td style="padding: 12px; color: #374151;">00.00</td>
              </tr>
              <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 12px;">
                  <div style="display: flex; gap: 8px; align-items: center;">
                    <img src="{{ asset('action_icon/pending.svg') }}" alt="pending" style="width: 20px; height: 20px;">
                  </div>
                </td>
                <td style="padding: 12px; color: #374151;">2</td>
                <td style="padding: 12px; color: #374151;">CEI/QUAT/0002</td>
                <td style="padding: 12px; color: #374151;">1,50,000.00</td>
                <td style="padding: 12px; color: #374151;">14-10-2025</td>
                <td style="padding: 12px; color: #374151;">00.00</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Template List Tab -->
      <div id="tab-template" style="margin-top: 20px; display: none;">
        <div style="overflow-x: auto; background: white; border-radius: 8px; border: 1px solid #e5e7eb;">
          <table style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Status</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Serial No</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Billing No</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Description</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Amount</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Completion Per</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Completion Term</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Actions</th>

              </tr>
            </thead>
            <tbody>
              <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 12px;">
                  <div style="display: flex; gap: 8px; align-items: center;">
                    <img src="{{ asset('action_icon/completed.svg') }}" alt="completed" style="width: 20px; height: 20px;">
                  </div>
                </td>
                <td style="padding: 12px; color: #374151;">1</td>
                <td style="padding: 12px; color: #374151;">CEI/QUAT/0001</td>
                <td style="padding: 12px; color: #374151;">XYZ, ABC</td>
                <td style="padding: 12px; color: #374151;">1,00,000</td>
                <td style="padding: 12px; color: #374151;">10</td>
                <td style="padding: 12px; color: #374151;">5,500</td>
                <td style="padding: 12px;">
                  <div style="display: flex; gap: 8px; align-items: center;">
                    <div style="width: 24px; height: 24px; border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Edit">
                      <img src="{{ asset('action_icon/edit.svg') }}" alt="edit" style="width: 14px; height: 14px;">
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Proforma Tab -->
      <div id="tab-proforma" style="margin-top: 20px; display: none;">
        <div style="overflow-x: auto; background: white; border-radius: 8px; border: 1px solid #e5e7eb;">
          <table style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Serial No</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Status</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Invoice No.</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Billing No.</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Billing Date</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Template Desc.</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Grand Total</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Total Amount</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 12px; color: #374151;">1</td>
                 <td style="padding: 12px;">
                  <div style="display: flex; gap: 8px; align-items: center;">
                    <img src="{{ asset('action_icon/completed.svg') }}" alt="completed" style="width: 20px; height: 20px;">
                  </div>
                </td>
                <td style="padding: 12px; color: #374151;">CEI/INV/001</td>
                <td style="padding: 12px; color: #374151;">CEI/QUAT/0001</td>
                <td style="padding: 12px; color: #374151;">25-09-2025</td>
                <td style="padding: 12px; color: #374151;">COMPLETION</td>
                <td style="padding: 12px; color: #374151;">85,000.00</td>
                <td style="padding: 12px; color: #374151;">1,00,300.00</td>
                <td style="padding: 12px;">
                  <div style="display: flex; gap: 8px; align-items: center;">
                    <div style="width: 24px; height: 24px;border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Generate">
                      <img src="{{ asset('action_icon/generate.svg') }}" alt="generate" style="width: 14px; height: 14px;">
                    </div>
                    <div style="width: 24px; height: 24px;border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Convert">
                      <img src="{{ asset('action_icon/convert.svg') }}" alt="convert" style="width: 14px; height: 14px;">
                    </div>
                    <div style="width: 24px; height: 24px; border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Edit">
                      <img src="{{ asset('action_icon/edit.svg') }}" alt="edit" style="width: 14px; height: 14px;">
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Invoice Management Tab -->
      <div id="tab-invoice" style="margin-top: 20px; display: none;">
        <div style="overflow-x: auto; background: white; border-radius: 8px; border: 1px solid #e5e7eb;">
          <table style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Serial No</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Status</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Invoice No.</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Invoice Date</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Company</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Mobile No</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Grand Total</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Total Amount</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 12px; color: #374151;">1</td>
                <td style="padding: 12px; color: #374151;">Invoice</td>
                <td style="padding: 12px; color: #374151;">CEI/INV/001</td>
                <td style="padding: 12px; color: #374151;">25/09/2025</td>
                <td style="padding: 12px; color: #374151;">Manglam Consultancy Se...</td>
                <td style="padding: 12px; color: #374151;">+91 1234567890</td>
                <td style="padding: 12px; color: #374151;">85,000.00</td>
                <td style="padding: 12px; color: #374151;">1,00,300.00</td>
                <td style="padding: 12px;">
                  <div style="display: flex; gap: 8px; align-items: center;">
                    <div style="width: 24px; height: 24px;border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Convert">
                      <img src="{{ asset('action_icon/convert.svg') }}" alt="convert" style="width: 14px; height: 14px;">
                    </div>
                    <div style="width: 24px; height: 24px;border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Edit">
                      <img src="{{ asset('action_icon/edit.svg') }}" alt="edit" style="width: 14px; height: 14px;">
                    </div>
                  </div>
                </td>
              </tr>
              <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 12px; color: #374151;">2</td>
                <td style="padding: 12px; color: #374151;">Invoice</td>
                <td style="padding: 12px; color: #374151;">-</td>
                <td style="padding: 12px; color: #374151;">-</td>
                <td style="padding: 12px; color: #374151;">Manglam Consultancy Se...</td>
                <td style="padding: 12px; color: #374151;">+91 1234567890</td>
                <td style="padding: 12px; color: #374151;">85,000.00</td>
                <td style="padding: 12px; color: #374151;">1,00,300.00</td>
                <td style="padding: 12px;">
                  <div style="display: flex; gap: 8px; align-items: center;">
                   <div style="width: 24px; height: 24px;border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Generate">
                      <img src="{{ asset('action_icon/generate.svg') }}" alt="generate" style="width: 14px; height: 14px;">
                    </div>
                    <div style="width: 24px; height: 24px;border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Convert">
                      <img src="{{ asset('action_icon/convert.svg') }}" alt="convert" style="width: 14px; height: 14px;">
                    </div>
                    <div style="width: 24px; height: 24px;border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Edit">
                      <img src="{{ asset('action_icon/edit.svg') }}" alt="edit" style="width: 14px; height: 14px;">
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Receipt Tab -->
      <div id="tab-receipt" style="margin-top: 20px; display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <input type="text" placeholder="Receipt No." style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; width: 120px;">
            <input type="text" placeholder="From: dd/mm/yyyy" style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; width: 140px;">
            <input type="text" placeholder="To: dd/mm/yyyy" style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; width: 140px;">
            <button style="background: #374151; color: white; border: none; padding: 8px 12px; border-radius: 6px; font-size: 14px; cursor: pointer;">
              <svg width="16" height="16" fill="white" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
            </button>
          </div>
        </div>
        <div style="overflow-x: auto; background: white; border-radius: 8px; border: 1px solid #e5e7eb;">
          <table style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Serial No</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Action</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Invoice Code</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Invoice Date</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Bill No.</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Bill No.</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Received Amount</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">A/C | Cash</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Trans Code</th>
              </tr>
            </thead>
            <tbody>
              <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 12px; color: #374151;">1</td>
                <td style="padding: 12px;">
                  <img src="{{ asset('action_icon/edit.svg') }}" alt="edit" style="width: 16px; height: 16px; cursor: pointer;">
                </td>
                <td style="padding: 12px; color: #374151;">CEI/INV/001</td>
                <td style="padding: 12px; color: #374151;">25/09/2025</td>
                <td style="padding: 12px; color: #374151;">2</td>
                <td style="padding: 12px; color: #374151;">5</td>
                <td style="padding: 12px; color: #374151;">50,000.00</td>
                <td style="padding: 12px; color: #374151;">A/C</td>
                <td style="padding: 12px; color: #374151;">CODE_001</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Project Tab -->
      <div id="tab-project" style="margin-top: 20px; display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <input type="text" placeholder="Receipt No." style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; width: 120px;">
            <input type="text" placeholder="From: dd/mm/yyyy" style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; width: 140px;">
            <input type="text" placeholder="To: dd/mm/yyyy" style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; width: 140px;">
            <button style="background: #374151; color: white; border: none; padding: 8px 12px; border-radius: 6px; font-size: 14px; cursor: pointer;">
              <svg width="16" height="16" fill="white" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
            </button>
          </div>
        </div>
        <div style="overflow-x: auto; background: white; border-radius: 8px; border: 1px solid #e5e7eb;">
          <table style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Serial No</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Action</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Project Code</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Project Name</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Work Start Date</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Work End Date</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Completion Time</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Nature</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Documents</th>
              </tr>
            </thead>
            <tbody>
              <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 12px; color: #374151;">1</td>
                <td style="padding: 12px;">
                  <img src="{{ asset('action_icon/edit.svg') }}" alt="edit" style="width: 16px; height: 16px; cursor: pointer;">
                </td>
                <td style="padding: 12px; color: #374151;">CEI/INV/001</td>
                <td style="padding: 12px; color: #374151;">25/09/2025</td>
                <td style="padding: 12px; color: #374151;">dd/mm/yyyy</td>
                <td style="padding: 12px; color: #374151;">dd/mm/yyyy</td>
                <td style="padding: 12px; color: #374151;">02:00</td>
                <td style="padding: 12px; color: #374151;">-</td>
                <td style="padding: 12px; color: #374151;">3.JPG</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Ticket Tab -->
      <div id="tab-ticket" style="margin-top: 20px; display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <select style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; width: 140px; color: #9ca3af;">
              <option>Select Company</option>
            </select>
            <select style="padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; width: 140px; color: #9ca3af;">
              <option>Select Ticket Type</option>
            </select>
            <button style="background: #374151; color: white; border: none; padding: 8px 12px; border-radius: 6px; font-size: 14px; cursor: pointer;">
              <svg width="16" height="16" fill="white" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
            </button>
          </div>
        </div>
        <div style="overflow-x: auto; background: white; border-radius: 8px; border: 1px solid #e5e7eb;">
          <table style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Serial No</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Action</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Ticket</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Work by Employee</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Category</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Customer</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Title</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Description</th>
              </tr>
            </thead>
            <tbody>
              <tr style="border-bottom: 1px solid #f3f4f6;">


                
                <td style="padding: 12px; color: #374151;">1</td>
                <td style="padding: 12px;">
                  <div style="display: flex; gap: 4px; align-items: center;">
                    <div style="width: 24px; height: 24px;border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Edit">
                      <img src="{{ asset('action_icon/show.svg') }}" alt="edit" style="width: 14px; height: 14px;">
                    </div>

                    <img src="{{ asset('action_icon/delete.svg') }}" alt="delete" style="width: 16px; height: 16px; cursor: pointer;">
                  </div>
                </td>
                <td style="padding: 12px; color: #22c55e; font-weight: 600;">Closed</td>
                <td style="padding: 12px; color: #22c55e;">Completed</td>
                <td style="padding: 12px; color: #374151;">General Inquiry</td>
                <td style="padding: 12px; color: #374151;">SHREEJI GEOTECH CONSULT...</td>
                <td style="padding: 12px; color: #374151;">Testing</td>
                <td style="padding: 12px; color: #374151;">OK</td>
              </tr>
              <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 12px; color: #374151;">2</td>
              <td style="padding: 12px;">
                  <div style="display: flex; gap: 4px; align-items: center;">
                    <div style="width: 24px; height: 24px;border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Edit">
                      <img src="{{ asset('action_icon/show.svg') }}" alt="edit" style="width: 14px; height: 14px;">
                    </div>

                    <img src="{{ asset('action_icon/delete.svg') }}" alt="delete" style="width: 16px; height: 16px; cursor: pointer;">
                  </div>
                </td>
                <td style="padding: 12px; color: #3b82f6; font-weight: 600;">Needs Approval</td>
                <td style="padding: 12px; color: #f59e0b;">Work Not Assigned</td>
                <td style="padding: 12px; color: #374151;">Billing</td>
                <td style="padding: 12px; color: #374151;">SHREEJI GEOTECH CONSULT...</td>
                <td style="padding: 12px; color: #374151;">Test</td>
                <td style="padding: 12px; color: #374151;">00</td>
              </tr>
              <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 12px; color: #374151;">3</td>
               <td style="padding: 12px;">
                  <div style="display: flex; gap: 4px; align-items: center;">
                    <div style="width: 24px; height: 24px;border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Edit">
                      <img src="{{ asset('action_icon/show.svg') }}" alt="edit" style="width: 14px; height: 14px;">
                    </div>

                    <img src="{{ asset('action_icon/delete.svg') }}" alt="delete" style="width: 16px; height: 16px; cursor: pointer;">
                  </div>
                </td>
                <td style="padding: 12px; color: #ef4444; font-weight: 600;">Pending</td>
                <td style="padding: 12px; color: #f59e0b;">Work Not Assigned</td>
                <td style="padding: 12px; color: #374151;">General Inquiry</td>
                <td style="padding: 12px; color: #374151;">SHREEJI GEOTECH CONSULT...</td>
                <td style="padding: 12px; color: #374151;">Test</td>
                <td style="padding: 12px; color: #374151;">OK_123</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Company Details</span>
@endsection

@push('scripts')
<script>
  document.querySelectorAll('[data-tab]').forEach(btn => {
    btn.addEventListener('click', () => {
      if (btn.hasAttribute('disabled')) return;
      const name = btn.getAttribute('data-tab');
      // toggle active button styles
      document.querySelectorAll('[data-tab]').forEach(b => {
        if (!b.hasAttribute('disabled')) {
          b.style.background = '#f3f4f6';
          b.style.color = '#374151';
        }
      });
      btn.style.background = '#000';
      btn.style.color = 'white';
      // toggle sections
      document.getElementById('tab-quotation').style.display = 'none';
      document.getElementById('tab-template').style.display = 'none';
      document.getElementById('tab-proforma').style.display = 'none';
      document.getElementById('tab-invoice').style.display = 'none';
      document.getElementById('tab-receipt').style.display = 'none';
      document.getElementById('tab-project').style.display = 'none';
      document.getElementById('tab-ticket').style.display = 'none';
      const map = { quotation: 'tab-quotation', template: 'tab-template', proforma: 'tab-proforma', invoice: 'tab-invoice', receipt: 'tab-receipt', project: 'tab-project', ticket: 'tab-ticket' };
      const target = map[name];
      if (target) document.getElementById(target).style.display = 'block';
    });
  });

  // File upload functionality
  document.getElementById('fileUpload').addEventListener('change', function(e) {
    const files = e.target.files;
    if (files.length > 0) {
      alert(`${files.length} file(s) selected for upload`);
      // Add your upload logic here
    }
  });

  // Print functionality
  window.printQuotationList = function() {
    const printContent = document.getElementById('tab-quotation').innerHTML;
    const originalContent = document.body.innerHTML;
    document.body.innerHTML = `
      <div style="padding: 20px;">
        <h2 style="text-align: center; margin-bottom: 20px;">Quotation List</h2>
        ${printContent}
      </div>
    `;
    window.print();
    document.body.innerHTML = originalContent;
    location.reload();
  };
</script>
@endpush
