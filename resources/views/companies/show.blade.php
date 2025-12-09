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
<div class="inquiry-index-container">
    @php
      $allowedTabs = ['quotation','template','proforma','invoice','receipt','project','ticket'];
      $reqTab = request()->get('tab');
      $activeTab = in_array($reqTab, $allowedTabs) ? $reqTab : 'quotation';
    @endphp

    @if(session('success'))
        <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 10px 15px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Top two-column details -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2px; margin-bottom: 30px; background: #d1d5db; border-radius: 8px; overflow: hidden;">
      <div style="background: #ffffff; padding: 0; display: flex; flex-direction: column; align-items: center;">
        <h3 style="font-weight: 600; font-size: 14px; margin: 0 0 20px 0; color: #000; background: #F0F0F0; padding: 12px 20px; text-align: center; width: 100%;">Company Details</h3>
        <div style="padding: 0 40px 25px 40px; width: 100%;">
        <div style="display: flex; flex-direction: column; gap: 0px; max-width: 600px; width: 100%;">
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Unique Code</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->unique_code ?? '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Company Name</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->company_name ? $company->company_name : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Company Address</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->company_address ? $company->company_address : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Company Gst No</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->gst_no ? $company->gst_no : '---' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Company Pan No</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->pan_no ? $company->pan_no : '---' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Other</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->other_details ? $company->other_details : '---' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Company Type</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->company_type ? $company->company_type : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Company Email</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->company_email ? $company->company_email : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Company Password</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->company_password ? '••••••••' : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Company Employee Email</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->company_employee_email ? $company->company_employee_email : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Company Employee Password</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->company_employee_password ? '••••••••' : '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Company City</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->city ? $company->city : '-' }}</span>
          </div>
        </div>
        </div>
      </div>
      <div style="background: #ffffff; padding: 0; display: flex; flex-direction: column; align-items: center;">
        <h3 style="font-weight: 600; font-size: 14px; margin: 0 0 20px 0; color: #000; background: #F0F0F0; padding: 12px 20px; text-align: center; width: 100%;">Person's Details</h3>
        <div style="padding: 0 40px 25px 40px; width: 100%;">
        <div style="display: flex; flex-direction: column; gap: 0px; max-width: 600px; width: 100%;">
          @if($company->person_name_1 || $company->person_number_1 || $company->person_position_1)
          <!-- Person 1 -->
          <div style="font-weight: 600; color: #374151; font-size: 13px; padding: 8px 0px; border-bottom: 1px solid #e5e7eb; margin-bottom: 5px;">Contact Person 1</div>
          @if($company->person_name_1)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Person Name</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->person_name_1 }}</span>
          </div>
          @endif
          @if($company->person_number_1)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Person Number</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->person_number_1 }}</span>
          </div>
          @endif
          @if($company->person_position_1)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Person Position</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->person_position_1 }}</span>
          </div>
          @endif
          @endif

          @if($company->person_name_2 || $company->person_number_2 || $company->person_position_2)
          <!-- Person 2 -->
          <div style="font-weight: 600; color: #374151; font-size: 13px; padding: 8px 0px; border-bottom: 1px solid #e5e7eb; margin-bottom: 5px; margin-top: 10px;">Contact Person 2</div>
          @if($company->person_name_2)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Person Name</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->person_name_2 }}</span>
          </div>
          @endif
          @if($company->person_number_2)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Person Number</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->person_number_2 }}</span>
          </div>
          @endif
          @if($company->person_position_2)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Person Position</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->person_position_2 }}</span>
          </div>
          @endif
          @endif

          @if($company->person_name_3 || $company->person_number_3 || $company->person_position_3)
          <!-- Person 3 -->
          <div style="font-weight: 600; color: #374151; font-size: 13px; padding: 8px 0px; border-bottom: 1px solid #e5e7eb; margin-bottom: 5px; margin-top: 10px;">Contact Person 3</div>
          @if($company->person_name_3)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Person Name</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->person_name_3 }}</span>
          </div>
          @endif
          @if($company->person_number_3)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Person Number</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->person_number_3 }}</span>
          </div>
          @endif
          @if($company->person_position_3)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Person Position</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $company->person_position_3 }}</span>
          </div>
          @endif
          @endif

          @if(!$company->person_name_1 && !$company->person_number_1 && !$company->person_position_1 && !$company->person_name_2 && !$company->person_number_2 && !$company->person_position_2 && !$company->person_name_3 && !$company->person_number_3 && !$company->person_position_3)
          <div style="padding: 20px; text-align: center; color: #6b7280;">No contact persons added.</div>
          @endif
        </div>
        </div>
      </div>
    </div>

    <!-- Documents Row -->
    <div style="margin-bottom: 30px; padding: 15px 20px; background: #ffffff; border-radius: 8px; border: 1px solid #e5e7eb;">
      <div style="font-weight: 600; margin-bottom: 15px; color: #1f2937; font-size: 14px;">All Documents :</div>
      <div id="documents-grid" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px;">
        <!-- Company Logo -->
        <div style="background: white; border-radius: 8px; padding: 15px; border: 1px solid #e5e7eb;">
          <div style="font-size: 14px; margin-bottom: 10px; color: #666;">Company Logo</div>
          <div style="border: 1px solid #e5e7eb; border-radius: 6px; display: flex; align-items: center; justify-content: center; height: 120px; background: #f9fafb; position: relative;">
            @if($company->company_logo)
              <a href="{{ $company->logo_url }}" target="_blank">
                <img src="{{ $company->logo_url }}" alt="Company Logo" style="max-height: 100px; max-width: 100px; object-fit: contain;">
              </a>
            @else
              <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; color: #666;">
                <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24" style="margin-bottom: 8px;">
                  <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                </svg>
                <span style="font-size: 12px;">No Logo</span>
              </div>
            @endif
            @if($company->logo_url)
            <a href="{{ $company->logo_url }}" target="_blank" style="position: absolute; top: 8px; right: 8px; background: #000; border-radius: 4px; padding: 6px; cursor: pointer;" title="Download">
              <svg width="16" height="16" fill="white" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
            </a>
            @endif
          </div>
        </div>
        
        <!-- SOP Upload -->
        <div style="background: white; border-radius: 8px; padding: 15px; border: 1px solid #e5e7eb;">
          <div style="font-size: 14px; margin-bottom: 10px; color: #666;">SOP Upload</div>
          <div style="border: 1px solid #e5e7eb; border-radius: 6px; display: flex; align-items: center; justify-content: center; height: 120px; background: #f9fafb; position: relative;">
            @if($company->sop_upload)
              @php
                $sopExt = strtolower(pathinfo($company->sop_upload, PATHINFO_EXTENSION));
                $sopIsImage = in_array($sopExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
              @endphp
              <a href="{{ $company->sop_url }}" target="_blank" style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none;">
                @if($sopIsImage)
                  <img src="{{ $company->sop_url }}" alt="SOP Document" style="max-height: 100px; max-width: 100px; object-fit: contain;">
                @else
                  <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; color: #666;">
                    <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24" style="margin-bottom: 8px;">
                      <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                    </svg>
                    <span style="font-size: 12px;">{{ strtoupper($sopExt) }}</span>
                  </div>
                @endif
              </a>
              <a href="{{ $company->sop_url }}" target="_blank" style="position: absolute; top: 8px; right: 8px; background: #000; border-radius: 4px; padding: 6px; cursor: pointer;" title="Download">
                <svg width="16" height="16" fill="white" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
              </a>
            @else
              <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; color: #666;">
                <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24" style="margin-bottom: 8px;">
                  <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                </svg>
                <span style="font-size: 12px;">No SOP</span>
              </div>
            @endif
          </div>
        </div>
        
        <!-- Quotation Upload -->
        <div style="background: white; border-radius: 8px; padding: 15px; border: 1px solid #e5e7eb;">
          <div style="font-size: 14px; margin-bottom: 10px; color: #666;">Quotation Upload</div>
          <div style="border: 1px solid #e5e7eb; border-radius: 6px; display: flex; align-items: center; justify-content: center; height: 120px; background: #f9fafb; position: relative;">
            @if($company->quotation_upload)
              @php
                $quotExt = strtolower(pathinfo($company->quotation_upload, PATHINFO_EXTENSION));
                $quotIsImage = in_array($quotExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
              @endphp
              <a href="{{ $company->quotation_url }}" target="_blank" style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none;">
                @if($quotIsImage)
                  <img src="{{ $company->quotation_url }}" alt="Quotation Document" style="max-height: 100px; max-width: 100px; object-fit: contain;">
                @else
                  <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; color: #666;">
                    <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24" style="margin-bottom: 8px;">
                      <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                    </svg>
                    <span style="font-size: 12px;">{{ strtoupper($quotExt) }}</span>
                  </div>
                @endif
              </a>
              <a href="{{ $company->quotation_url }}" target="_blank" style="position: absolute; top: 8px; right: 8px; background: #000; border-radius: 4px; padding: 6px; cursor: pointer;" title="Download">
                <svg width="16" height="16" fill="white" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
              </a>
            @else
              <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; color: #666;">
                <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24" style="margin-bottom: 8px;">
                  <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                </svg>
                <span style="font-size: 12px;">No Document</span>
              </div>
            @endif
          </div>
        </div>
        
        <!-- Additional Uploaded Documents -->
        @foreach($documents as $document)
        <div class="document-card" data-document-id="{{ $document->id }}" style="background: white; border-radius: 8px; padding: 15px; border: 1px solid #e5e7eb;">
          <div style="font-size: 14px; margin-bottom: 10px; color: #666; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $document->document_name }}">{{ Str::limit($document->document_name, 15) }}</div>
          <div style="border: 1px solid #e5e7eb; border-radius: 6px; display: flex; align-items: center; justify-content: center; height: 120px; background: #f9fafb; position: relative;">
            <a href="{{ $document->file_url }}" target="_blank" style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none;">
              @if($document->isImage())
                <img src="{{ $document->file_url }}" alt="{{ $document->document_name }}" style="max-height: 100px; max-width: 100px; object-fit: contain;">
              @else
                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; color: #666;">
                  <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24" style="margin-bottom: 8px;">
                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                  </svg>
                  <span style="font-size: 12px;">{{ strtoupper($document->document_type) }}</span>
                </div>
              @endif
            </a>
            <a href="{{ $document->file_url }}" target="_blank" style="position: absolute; top: 8px; right: 36px; background: #000; border-radius: 4px; padding: 6px; cursor: pointer;" title="Download">
              <svg width="16" height="16" fill="white" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
            </a>
            @can('Companies Management.edit company')
            <button type="button" onclick="deleteDocument({{ $document->id }})" style="position: absolute; top: 8px; right: 8px; background: #ef4444; border-radius: 4px; padding: 6px; cursor: pointer; border: none;" title="Delete">
              <svg width="16" height="16" fill="white" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/></svg>
            </button>
            @endcan
          </div>
        </div>
        @endforeach
        
        <!-- Upload Button -->
        @can('Companies Management.edit company')
        <div style="background: white; border-radius: 8px; padding: 15px; border: 1px solid #e5e7eb;">
          <div style="font-size: 14px; margin-bottom: 10px; color: #666;">Add Document</div>
          <div id="upload-area" style="border: 2px dashed #d1d5db; border-radius: 6px; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 120px; background: #4b5563; cursor: pointer;" onclick="document.getElementById('fileUpload').click()">
            <svg width="24" height="24" fill="white" viewBox="0 0 24 24" style="margin-bottom: 8px;">
              <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
              <path d="M12,11L16,15H13V19H11V15H8L12,11Z"/>
            </svg>
            <span style="color: white; font-size: 14px; font-weight: 600;">Upload</span>
          </div>
          <form id="uploadForm" style="display: none;">
            @csrf
            <input type="file" id="fileUpload" name="documents[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp,.xls,.xlsx">
          </form>
        </div>
        @endcan
      </div>
    </div>

    <!-- Enhanced Tabs -->
    <style>
      .company-tab-btn {
        background: transparent;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 12px 16px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 6px;
        color: #6b7280;
        font-weight: 500;
        white-space: nowrap;
      }
      .company-tab-btn:hover {
        color: #000000;
        background: #f8fafc;
      }
      .company-tab-btn.active {
        color: #000000;
        border-bottom: 2px solid #000000;
        background: transparent;
        font-weight: 600;
      }
      .company-tab-btn svg {
        stroke: currentColor;
      }
      .enhanced-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
      }
      .enhanced-table thead tr {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
      }
      .enhanced-table th {
        text-align: left;
        padding: 14px 16px;
        font-weight: 600;
        color: #1e293b;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
      }
      .enhanced-table td {
        padding: 14px 16px;
        color: #475569;
        font-size: 14px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
      }
      .enhanced-table tbody tr {
        transition: all 0.15s ease;
      }
      .enhanced-table tbody tr:hover {
        background: #f8fafc;
      }
      .enhanced-table tbody tr:last-child td {
        border-bottom: none;
      }
      .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
      }
      .status-confirmed { background: #dcfce7; color: #166534; }
      .status-pending { background: #fef3c7; color: #92400e; }
      .status-completed { background: #dbeafe; color: #1e40af; }
      .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
      }
      .action-btn:hover {
        background: #e2e8f0;
        transform: translateY(-1px);
      }
      .action-btn img {
        width: 16px;
        height: 16px;
      }
      .amount-cell {
        font-weight: 600;
        color: #0f172a;
        font-family: 'SF Mono', 'Monaco', monospace;
      }
      .link-cell {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.15s;
      }
      .link-cell:hover {
        color: #1d4ed8;
        text-decoration: underline;
      }
      .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: #94a3b8;
      }
      .empty-state svg {
        width: 48px;
        height: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
      }
      .empty-state p {
        font-size: 14px;
        margin: 0;
      }
      .tab-content-card {
        background: white;
        overflow: hidden;
      }
    </style>
    <div id="company-tabs" style="margin-bottom: 20px; background: #ffffff; border-radius: 8px; border: 1px solid #e5e7eb; overflow: hidden;">
      <div style="display: flex; align-items: center; gap: 0; overflow-x: auto; background: #fff; border-bottom: 1px solid #e5e7eb; padding: 0 10px;">
        <button class="company-tab-btn" data-tab="quotation">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
          <span>Quotation List</span>
        </button>
        <button class="company-tab-btn" data-tab="template">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/></svg>
          <span>Template List</span>
        </button>
        <button class="company-tab-btn" data-tab="proforma">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          <span>Proforma Mana.</span>
        </button>
        <button class="company-tab-btn" data-tab="invoice">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
          <span>Invoice Mana.</span>
        </button>
        <button class="company-tab-btn" data-tab="receipt">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
          <span>The Receipt</span>
        </button>
        <button class="company-tab-btn" data-tab="ticket">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
          <span>Ticket</span>
        </button>
      </div>

      <!-- Tab contents -->
      <div id="tab-quotation" style="padding: 0; display: none;">
        <div class="tab-content-card">
          <div style="overflow-x: auto;">
            <table class="enhanced-table">
              <thead>
                <tr>
                  <th style="width: 80px;">Status</th>
                  <th style="width: 60px;">#</th>
                  <th>Quotation No</th>
                  <th>Amount</th>
                  <th>AMC Start</th>
                  <th>AMC Amount</th>
                  <th style="width: 100px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($quotations as $index => $quotation)
                <tr>
                  <td>
                    @if(in_array($quotation->id, $confirmedQuotationIds))
                      <span class="status-badge status-confirmed">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                        Confirmed
                      </span>
                    @else
                      <span class="status-badge status-pending">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                        Pending
                      </span>
                    @endif
                  </td>
                  <td style="font-weight: 600; color: #64748b;">{{ $index + 1 }}</td>
                  <td>
                    <a href="{{ route('quotations.show', $quotation->id) }}" class="link-cell">{{ $quotation->unique_code ?? '-' }}</a>
                  </td>
                  <td class="amount-cell">₹{{ number_format($quotation->service_contract_amount ?? 0, 2) }}</td>
                  <td>{{ $quotation->amc_start_date ? $quotation->amc_start_date->format('d M, Y') : '-' }}</td>
                  <td class="amount-cell">₹{{ number_format($quotation->amc_amount ?? 0, 2) }}</td>
                  <td>
                    <div style="display: flex; gap: 6px;">
                      <a href="{{ route('quotations.show', $quotation->id) }}" class="action-btn" title="View">
                        <img src="{{ asset('action_icon/show.svg') }}" alt="view">
                      </a>
                      @can('Quotations Management.edit quotation')
                      <a href="{{ route('quotations.edit', $quotation->id) }}" class="action-btn" title="Edit">
                        <img src="{{ asset('action_icon/edit.svg') }}" alt="edit">
                      </a>
                      @endcan
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7">
                    <div class="empty-state">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                      <p>No quotations found for this company</p>
                    </div>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Template List Tab -->
      <div id="tab-template" style="padding: 0; display: none;">
        <div class="tab-content-card">

          <div style="overflow-x: auto;">
            <table class="enhanced-table">
              <thead>
                <tr>
                  <th style="width: 80px;">Status</th>
                  <th style="width: 60px;">#</th>
                  <th>Billing No</th>
                  <th>Description</th>
                  <th>Amount</th>
                  <th>Completion %</th>
                  <th>Term</th>
                  <th style="width: 80px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                @php $templateIndex = 0; @endphp
                @forelse($quotations as $quotation)
                  @if(!empty($quotation->terms_description) && is_array($quotation->terms_description))
                    @foreach($quotation->terms_description as $tIndex => $desc)
                      @if(!empty($desc))
                      @php $templateIndex++; @endphp
                      <tr>
                        <td>
                          @if(in_array($quotation->id, $confirmedQuotationIds))
                            <span class="status-badge status-confirmed">✓</span>
                          @else
                            <span class="status-badge status-pending">○</span>
                          @endif
                        </td>
                        <td style="font-weight: 600; color: #64748b;">{{ $templateIndex }}</td>
                        <td><a href="{{ route('quotations.template-list', $quotation->id) }}" class="link-cell">{{ $quotation->unique_code ?? '-' }}</a></td>
                        <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $desc }}">{{ Str::limit($desc, 35) }}</td>
                        <td class="amount-cell">₹{{ number_format($quotation->terms_total[$tIndex] ?? 0, 2) }}</td>
                        <td>
                          <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 50px; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden;">
                              <div style="width: {{ $quotation->terms_completion[$tIndex] ?? 0 }}%; height: 100%; background: linear-gradient(90deg, #22c55e, #16a34a);"></div>
                            </div>
                            <span style="font-size: 12px; font-weight: 600; color: #475569;">{{ $quotation->terms_completion[$tIndex] ?? 0 }}%</span>
                          </div>
                        </td>
                        <td>{{ $quotation->completion_terms[$tIndex] ?? '-' }}</td>
                        <td>
                          <a href="{{ route('quotations.template-list', $quotation->id) }}" class="action-btn" title="View Templates">
                            <img src="{{ asset('action_icon/show.svg') }}" alt="view">
                          </a>
                        </td>
                      </tr>
                      @endif
                    @endforeach
                  @endif
                @empty
                <tr>
                  <td colspan="8">
                    <div class="empty-state">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                      <p>No templates found for this company</p>
                    </div>
                  </td>
                </tr>
                @endforelse
                @if($templateIndex == 0 && $quotations->count() > 0)
                <tr>
                  <td colspan="8">
                    <div class="empty-state">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                      <p>No templates found for this company</p>
                    </div>
                  </td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Proforma Tab -->
      <div id="tab-proforma" style="padding: 0; display: none;">
        <div class="tab-content-card">
          <div style="overflow-x: auto;">
            <table class="enhanced-table">
              <thead>
                <tr>
                  <th style="width: 60px;">#</th>
                  <th style="width: 100px;">Status</th>
                  <th>Proforma No</th>
                  <th>Bill No</th>
                  <th>Date</th>
                  <th>Type</th>
                  <th>Sub Total</th>
                  <th>Final Amount</th>
                  <th style="width: 120px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($proformas as $index => $proforma)
                <tr>
                  <td style="font-weight: 600; color: #64748b;">{{ $index + 1 }}</td>
                  <td>
                    @if($proforma->hasInvoice())
                      <span class="status-badge status-completed">✓ Converted</span>
                    @else
                      <span class="status-badge status-pending">○ Pending</span>
                    @endif
                  </td>
                  <td><a href="{{ route('performas.show', $proforma->id) }}" class="link-cell">{{ $proforma->unique_code ?? '-' }}</a></td>
                  <td>{{ $proforma->bill_no ?? '-' }}</td>
                  <td>{{ $proforma->proforma_date ? $proforma->proforma_date->format('d M, Y') : '-' }}</td>
                  <td><span style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-size: 12px;">{{ $proforma->type_of_billing ?? '-' }}</span></td>
                  <td class="amount-cell">₹{{ number_format($proforma->sub_total ?? 0, 2) }}</td>
                  <td class="amount-cell" style="color: #16a34a;">₹{{ number_format($proforma->final_amount ?? 0, 2) }}</td>
                  <td>
                    <div style="display: flex; gap: 6px;">
                      <a href="{{ route('performas.print', $proforma->id) }}" target="_blank" class="action-btn" title="Print" style="background: #fef3c7;">
                        <img src="{{ asset('action_icon/generate.svg') }}" alt="print">
                      </a>
                      @if($proforma->canConvert())
                      <a href="{{ route('performas.convert', $proforma->id) }}" class="action-btn" title="Convert" style="background: #dcfce7;">
                        <img src="{{ asset('action_icon/convert.svg') }}" alt="convert">
                      </a>
                      @endif
                      <a href="{{ route('performas.show', $proforma->id) }}" class="action-btn" title="View">
                        <img src="{{ asset('action_icon/show.svg') }}" alt="view">
                      </a>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="9">
                    <div class="empty-state">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                      <p>No proformas found for this company</p>
                    </div>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Invoice Management Tab -->
      <div id="tab-invoice" style="padding: 0; display: none;">
        <div class="tab-content-card">
          <div style="overflow-x: auto;">
            <table class="enhanced-table">
              <thead>
                <tr>
                  <th style="width: 60px;">#</th>
                  <th style="width: 90px;">Type</th>
                  <th>Invoice No</th>
                  <th>Date</th>
                  <th>Company</th>
                  <th>Mobile</th>
                  <th>Sub Total</th>
                  <th>Final Amount</th>
                  <th style="width: 100px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($invoices as $index => $invoice)
                <tr>
                  <td style="font-weight: 600; color: #64748b;">{{ $index + 1 }}</td>
                  <td style="white-space: nowrap;">
                    @if($invoice->invoice_type == 'gst')
                      <span style="background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #166534; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; white-space: nowrap; display: inline-block;">GST</span>
                    @else
                      <span style="background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; white-space: nowrap; display: inline-block;">Non-GST</span>
                    @endif
                  </td>
                  <td><a href="{{ route('invoices.show', $invoice->id) }}" class="link-cell">{{ $invoice->unique_code ?? '-' }}</a></td>
                  <td>{{ $invoice->invoice_date ? $invoice->invoice_date->format('d M, Y') : '-' }}</td>
                  <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Str::limit($invoice->company_name ?? $company->company_name, 20) }}</td>
                  <td style="font-family: monospace; font-size: 13px;">{{ display_mobile($invoice->mobile_no) ?? '-' }}</td>
                  <td class="amount-cell">₹{{ number_format($invoice->sub_total ?? 0, 2) }}</td>
                  <td class="amount-cell" style="color: #16a34a;">₹{{ number_format($invoice->final_amount ?? 0, 2) }}</td>
                  <td>
                    <div style="display: flex; gap: 6px;">
                      <a href="{{ route('invoices.print', $invoice->id) }}" target="_blank" class="action-btn" title="Print" style="background: #fef3c7;">
                        <img src="{{ asset('action_icon/generate.svg') }}" alt="print">
                      </a>
                      <a href="{{ route('invoices.show', $invoice->id) }}" class="action-btn" title="View">
                        <img src="{{ asset('action_icon/show.svg') }}" alt="view">
                      </a>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="9">
                    <div class="empty-state">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                      <p>No invoices found for this company</p>
                    </div>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Receipt Tab -->
      <div id="tab-receipt" style="padding: 0; display: none;">
        <div style="overflow-x: auto; background: white; border-radius: 8px; border: 1px solid #e5e7eb;">
          <table style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Serial No</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Receipt No</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Receipt Date</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Company</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Invoice Type</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Received Amount</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Payment Type</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Trans Code</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($receipts as $index => $receipt)
              <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 12px; color: #374151;">{{ $index + 1 }}</td>
                <td style="padding: 12px; color: #374151;">
                  <a href="{{ route('receipts.show', $receipt->id) }}" style="color: #3b82f6; text-decoration: none;">
                    {{ $receipt->unique_code ?? '-' }}
                  </a>
                </td>
                <td style="padding: 12px; color: #374151;">{{ $receipt->receipt_date ? $receipt->receipt_date->format('d/m/Y') : '-' }}</td>
                <td style="padding: 12px; color: #374151;">{{ Str::limit($receipt->company_name ?? $company->company_name, 25) }}</td>
                <td style="padding: 12px; color: #374151; white-space: nowrap;">
                  @if($receipt->invoice_type == 'gst')
                    <span style="background: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 4px; font-size: 12px; white-space: nowrap; display: inline-block;">GST</span>
                  @else
                    <span style="background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 4px; font-size: 12px; white-space: nowrap; display: inline-block;">Non-GST</span>
                  @endif
                </td>
                <td style="padding: 12px; color: #374151;">{{ number_format($receipt->received_amount ?? 0, 2) }}</td>
                <td style="padding: 12px; color: #374151;">{{ ucfirst($receipt->payment_type ?? '-') }}</td>
                <td style="padding: 12px; color: #374151;">{{ $receipt->trans_code ?? '-' }}</td>
                <td style="padding: 12px;">
                  <div style="display: flex; gap: 8px; align-items: center;">
                    <a href="{{ route('receipts.print', $receipt->id) }}" target="_blank" style="width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Print">
                      <img src="{{ asset('action_icon/generate.svg') }}" alt="print" style="width: 14px; height: 14px;">
                    </a>
                    <a href="{{ route('receipts.show', $receipt->id) }}" style="width: 24px; height: 24px; border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="View">
                      <img src="{{ asset('action_icon/show.svg') }}" alt="view" style="width: 14px; height: 14px;">
                    </a>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="9" style="padding: 20px; text-align: center; color: #6b7280;">No receipts found for this company.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <!-- Project Tab -->
      <div id="tab-project" style="padding: 0 20px; display: none;">
        <div style="overflow-x: auto; background: white; border-radius: 8px; border: 1px solid #e5e7eb;">
          <table style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Serial No</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Project Name</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Status</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Priority</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Start Date</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Due Date</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Progress</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Budget</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($projects as $index => $project)
              <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 12px; color: #374151;">{{ $index + 1 }}</td>
                <td style="padding: 12px; color: #374151;">
                  <a href="{{ route('projects.show', $project->id) }}" style="color: #3b82f6; text-decoration: none;">
                    {{ Str::limit($project->name, 30) }}
                  </a>
                </td>
                <td style="padding: 12px; color: #374151;">
                  @php
                    $statusColors = [
                      'pending' => 'background: #fef3c7; color: #92400e;',
                      'in_progress' => 'background: #dbeafe; color: #1e40af;',
                      'completed' => 'background: #dcfce7; color: #166534;',
                      'on_hold' => 'background: #fee2e2; color: #991b1b;',
                    ];
                    $statusColor = $statusColors[$project->status] ?? 'background: #f3f4f6; color: #374151;';
                  @endphp
                  <span style="{{ $statusColor }} padding: 2px 8px; border-radius: 4px; font-size: 12px;">{{ ucfirst(str_replace('_', ' ', $project->status ?? 'N/A')) }}</span>
                </td>
                <td style="padding: 12px; color: #374151;">
                  @php
                    $priorityColors = [
                      'low' => 'background: #dcfce7; color: #166534;',
                      'medium' => 'background: #fef3c7; color: #92400e;',
                      'high' => 'background: #fee2e2; color: #991b1b;',
                    ];
                    $priorityColor = $priorityColors[$project->priority] ?? 'background: #f3f4f6; color: #374151;';
                  @endphp
                  <span style="{{ $priorityColor }} padding: 2px 8px; border-radius: 4px; font-size: 12px;">{{ ucfirst($project->priority ?? 'N/A') }}</span>
                </td>
                <td style="padding: 12px; color: #374151;">{{ $project->start_date ? $project->start_date->format('d/m/Y') : '-' }}</td>
                <td style="padding: 12px; color: #374151;">{{ $project->due_date ? $project->due_date->format('d/m/Y') : '-' }}</td>
                <td style="padding: 12px; color: #374151;">
                  <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 60px; height: 6px; background: #e5e7eb; border-radius: 3px; overflow: hidden;">
                      <div style="width: {{ $project->progress }}%; height: 100%; background: #22c55e;"></div>
                    </div>
                    <span style="font-size: 12px;">{{ $project->progress }}%</span>
                  </div>
                </td>
                <td style="padding: 12px; color: #374151;">{{ $project->budget ? number_format($project->budget, 2) : '-' }}</td>
                <td style="padding: 12px;">
                  <div style="display: flex; gap: 8px; align-items: center;">
                    <a href="{{ route('projects.show', $project->id) }}" style="width: 24px; height: 24px; border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="View">
                      <img src="{{ asset('action_icon/show.svg') }}" alt="view" style="width: 14px; height: 14px;">
                    </a>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="9" style="padding: 20px; text-align: center; color: #6b7280;">No projects found for this company.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <!-- Ticket Tab -->
      <div id="tab-ticket" style="padding: 0; display: none;">
        <div style="overflow-x: auto; background: white; border-radius: 8px; border: 1px solid #e5e7eb;">
          <table style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Serial No</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Ticket No</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Status</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Work Status</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Category</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Priority</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Title</th>
                <th style="text-align: left; padding: 12px; font-weight: 600; color: #374151;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($tickets as $index => $ticket)
              <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 12px; color: #374151;">{{ $index + 1 }}</td>
                <td style="padding: 12px; color: #374151;">
                  <a href="{{ route('tickets.show', $ticket->id) }}" style="color: #3b82f6; text-decoration: none;">
                    {{ $ticket->ticket_no ?? '-' }}
                  </a>
                </td>
                <td style="padding: 12px;">
                  @php
                    $ticketStatusColors = [
                      'open' => 'color: #3b82f6;',
                      'pending' => 'color: #ef4444;',
                      'needs_approval' => 'color: #3b82f6;',
                      'closed' => 'color: #22c55e;',
                      'resolved' => 'color: #22c55e;',
                    ];
                    $ticketStatusColor = $ticketStatusColors[strtolower($ticket->status ?? '')] ?? 'color: #374151;';
                  @endphp
                  <span style="{{ $ticketStatusColor }} font-weight: 600;">{{ ucfirst(str_replace('_', ' ', $ticket->status ?? 'N/A')) }}</span>
                </td>
                <td style="padding: 12px;">
                  @php
                    $workStatusColors = [
                      'completed' => 'color: #22c55e;',
                      'in_progress' => 'color: #3b82f6;',
                      'work_not_assigned' => 'color: #f59e0b;',
                      'not_started' => 'color: #f59e0b;',
                    ];
                    $workStatusColor = $workStatusColors[strtolower($ticket->work_status ?? '')] ?? 'color: #374151;';
                  @endphp
                  <span style="{{ $workStatusColor }}">{{ ucfirst(str_replace('_', ' ', $ticket->work_status ?? 'N/A')) }}</span>
                </td>
                <td style="padding: 12px; color: #374151;">{{ $ticket->category ?? '-' }}</td>
                <td style="padding: 12px; color: #374151;">
                  @php
                    $ticketPriorityColors = [
                      'low' => 'background: #dcfce7; color: #166534;',
                      'medium' => 'background: #fef3c7; color: #92400e;',
                      'high' => 'background: #fee2e2; color: #991b1b;',
                      'urgent' => 'background: #fee2e2; color: #991b1b;',
                    ];
                    $ticketPriorityColor = $ticketPriorityColors[strtolower($ticket->priority ?? '')] ?? 'background: #f3f4f6; color: #374151;';
                  @endphp
                  <span style="{{ $ticketPriorityColor }} padding: 2px 8px; border-radius: 4px; font-size: 12px;">{{ ucfirst($ticket->priority ?? 'N/A') }}</span>
                </td>
                <td style="padding: 12px; color: #374151;">{{ Str::limit($ticket->title ?? $ticket->subject, 25) }}</td>
                <td style="padding: 12px;">
                  <div style="display: flex; gap: 4px; align-items: center;">
                    <a href="{{ route('tickets.show', $ticket->id) }}" style="width: 24px; height: 24px; border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="View">
                      <img src="{{ asset('action_icon/show.svg') }}" alt="view" style="width: 14px; height: 14px;">
                    </a>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="8" style="padding: 20px; text-align: center; color: #6b7280;">No tickets found for this company.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Tab switching
  var tabButtons = document.querySelectorAll('[data-tab]');
  var allTabIds = ['tab-quotation', 'tab-template', 'tab-proforma', 'tab-invoice', 'tab-receipt', 'tab-project', 'tab-ticket'];
  
  function switchTo(tabName) {
    if (!tabName) return;
    
    // Force hide all tabs with !important
    allTabIds.forEach(function(tabId) {
      var tab = document.getElementById(tabId);
      if (tab) {
        tab.style.setProperty('display', 'none', 'important');
      }
    });

    // Update button styles - remove active class from all, add to selected
    tabButtons.forEach(function(b) {
      b.classList.remove('active');
      b.style.background = 'transparent';
      b.style.color = '#6b7280';
      b.style.borderBottom = '2px solid transparent';
      b.style.fontWeight = '500';
      
      if (b.getAttribute('data-tab') === tabName) {
        b.classList.add('active');
        b.style.color = '#000000';
        b.style.borderBottom = '2px solid #000000';
        b.style.fontWeight = '600';
      }
    });

    // Show selected tab with !important
    var selectedTab = document.getElementById('tab-' + tabName);
    if (selectedTab) {
      selectedTab.style.setProperty('display', 'block', 'important');
    }

    // Persist selection in URL and storage
    try {
      var url = new URL(window.location.href);
      url.searchParams.set('tab', tabName);
      history.replaceState(null, '', url.toString());
      localStorage.setItem('companyViewActiveTab', tabName);
    } catch (e) { /* noop */ }
  }

  // Wire click handlers
  tabButtons.forEach(function(btn) {
    btn.addEventListener('click', function() {
      var tabName = this.getAttribute('data-tab');
      switchTo(tabName);
    });
  });

  // Initial tab selection: ?tab=, #tab-<name>, localStorage, default
  var initialTab = (function() {
    try {
      var url = new URL(window.location.href);
      var q = url.searchParams.get('tab');
      if (q) return q;
      if (window.location.hash && window.location.hash.indexOf('#tab-') === 0) {
        return window.location.hash.replace('#tab-', '');
      }
      var saved = localStorage.getItem('companyViewActiveTab');
      if (saved) return saved;
    } catch (e) { /* noop */ }
    return 'quotation';
  })();

  switchTo(initialTab);
  
  // File upload
  var fileUpload = document.getElementById('fileUpload');
  if (fileUpload) {
    fileUpload.addEventListener('change', function(e) {
      if (this.files.length > 0) {
        uploadDocuments(this.files);
      }
    });
  }
});

// Upload documents function
function uploadDocuments(files) {
  var formData = new FormData();
  formData.append('_token', '{{ csrf_token() }}');
  
  for (var i = 0; i < files.length; i++) {
    formData.append('documents[]', files[i]);
  }
  
  var uploadArea = document.getElementById('upload-area');
  if (uploadArea) {
    uploadArea.innerHTML = '<span style="color: white; font-size: 14px;">Uploading...</span>';
  }
  
  fetch('{{ route("companies.documents.upload", $company->id) }}', {
    method: 'POST',
    body: formData,
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Reload page to show new documents
      window.location.reload();
    } else {
      alert(data.message || 'Error uploading documents');
      resetUploadArea();
    }
  })
  .catch(error => {
    console.error('Upload error:', error);
    alert('Error uploading documents. Please try again.');
    resetUploadArea();
  });
}

function resetUploadArea() {
  var uploadArea = document.getElementById('upload-area');
  if (uploadArea) {
    uploadArea.innerHTML = `
      <svg width="24" height="24" fill="white" viewBox="0 0 24 24" style="margin-bottom: 8px;">
        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
        <path d="M12,11L16,15H13V19H11V15H8L12,11Z"/>
      </svg>
      <span style="color: white; font-size: 14px; font-weight: 600;">Upload</span>
    `;
  }
  document.getElementById('fileUpload').value = '';
}

// Delete document function
function deleteDocument(documentId) {
  if (!confirm('Are you sure you want to delete this document?')) {
    return;
  }
  
  fetch('{{ url("companies/" . $company->id . "/documents") }}/' + documentId, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'application/json'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Remove the document card from DOM
      var card = document.querySelector('.document-card[data-document-id="' + documentId + '"]');
      if (card) {
        card.remove();
      }
    } else {
      alert(data.message || 'Error deleting document');
    }
  })
  .catch(error => {
    console.error('Delete error:', error);
    alert('Error deleting document. Please try again.');
  });
}
</script>

@endsection
