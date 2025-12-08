@extends('layouts.macos')
@section('page_title', 'Quotation Details')

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('quotations.index') }}">Quotation Management</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">{{ $quotation->unique_code }}</span>
@endsection

@section('content')
<div class="inquiry-index-container">
    @if(session('success'))
        <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 10px 15px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Top two-column details -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2px; margin-bottom: 30px; background: #d1d5db; border-radius: 8px; overflow: hidden;">
      <div style="background: #ffffff; padding: 0; display: flex; flex-direction: column; align-items: center;">
        <h3 style="font-weight: 600; font-size: 14px; margin: 0 0 20px 0; color: #000; background: #F0F0F0; padding: 12px 20px; text-align: center; width: 100%;">Quotation Details</h3>
        <div style="padding: 0 40px 25px 40px; width: 100%;">
        <div style="display: flex; flex-direction: column; gap: 0px; max-width: 600px; width: 100%;">
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Quotation Code</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->unique_code ?? '-' }}</span>
          </div>
          @if($quotation->quotation_title)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Quotation Title</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->quotation_title }}</span>
          </div>
          @endif
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Quotation Date</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->quotation_date ? \Carbon\Carbon::parse($quotation->quotation_date)->format('d/m/Y') : '-' }}</span>
          </div>
          @if($quotation->status)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Status</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">
              <span style="display: inline-block; padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; background: {{ $quotation->status === 'confirmed' ? '#d1fae5' : '#fef3c7' }}; color: {{ $quotation->status === 'confirmed' ? '#065f46' : '#92400e' }};">
                {{ ucfirst($quotation->status) }}
              </span>
            </span>
          </div>
          @endif
          @if($quotation->customer_type)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Customer Type</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ ucfirst($quotation->customer_type) }}</span>
          </div>
          @endif
          @if($quotation->service_contract_amount)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Service Contract Amount</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 600; text-align: left; flex: 1; font-size: 14px;">₹ {{ number_format($quotation->service_contract_amount, 2) }}</span>
          </div>
          @endif
          @if($quotation->project_start_date)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Project Start Date</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ \Carbon\Carbon::parse($quotation->project_start_date)->format('d/m/Y') }}</span>
          </div>
          @endif
          @if($quotation->tentative_complete_date)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Tentative Completion</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ \Carbon\Carbon::parse($quotation->tentative_complete_date)->format('d/m/Y') }}</span>
          </div>
          @endif
          @if($quotation->completion_time)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Completion Time</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->completion_time }}</span>
          </div>
          @endif
          @if($quotation->nature_of_work)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Nature of Work</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->nature_of_work }}</span>
          </div>
          @endif
          @if($quotation->prepared_by)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Prepared By</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->prepared_by }}</span>
          </div>
          @endif
          @if($quotation->mobile_no)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Mobile No</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->mobile_no }}</span>
          </div>
          @endif
          @if($quotation->own_company_name)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Own Company Name</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->own_company_name }}</span>
          </div>
          @endif
        </div>
        </div>
      </div>
      <div style="background: #ffffff; padding: 0; display: flex; flex-direction: column; align-items: center;">
        <h3 style="font-weight: 600; font-size: 14px; margin: 0 0 20px 0; color: #000; background: #F0F0F0; padding: 12px 20px; text-align: center; width: 100%;">Company Details</h3>
        <div style="padding: 0 40px 25px 40px; width: 100%;">
        <div style="display: flex; flex-direction: column; gap: 0px; max-width: 600px; width: 100%;">
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Company Name</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->company_name ?? '-' }}</span>
          </div>
          @if($quotation->company_type)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Company Type</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->company_type }}</span>
          </div>
          @endif
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Company Address</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->address ?? '-' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">City</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->city ?? '-' }}</span>
          </div>
          @if($quotation->state)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">State</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->state }}</span>
          </div>
          @endif
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">GST No</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->gst_no ?? '---' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">PAN No</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->pan_no ?? '---' }}</span>
          </div>
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Company Email</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->company_email ?? '-' }}</span>
          </div>
          @if($quotation->company_password)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Company Password</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">••••••••</span>
          </div>
          @endif
          @if($quotation->company_employee_email)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Employee Email</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->company_employee_email }}</span>
          </div>
          @endif
          @if($quotation->company_employee_password)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Employee Password</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">••••••••</span>
          </div>
          @endif
        </div>
        </div>
      </div>
    </div>

    <!-- Contact Information -->
    @if($quotation->contact_person_1 || $quotation->contact_person_2 || $quotation->contact_person_3)
    <div style="margin-bottom: 30px; padding: 0; background: #ffffff; border-radius: 8px; border: 1px solid #e5e7eb; overflow: hidden;">
      <h3 style="font-weight: 600; font-size: 14px; margin: 0 0 20px 0; color: #000; background: #F0F0F0; padding: 12px 20px; text-align: center; width: 100%;">Contact Information</h3>
      <div style="padding: 0 40px 25px 40px;">
        <div style="display: flex; flex-direction: column; gap: 0px; max-width: 100%;">
          @if($quotation->contact_person_1 || $quotation->contact_number_1 || $quotation->position_1)
          <!-- Contact Person 1 -->
          <div style="font-weight: 600; color: #374151; font-size: 13px; padding: 8px 0px; border-bottom: 1px solid #e5e7eb; margin-bottom: 5px;">Contact Person 1</div>
          @if($quotation->contact_person_1)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Person Name</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->contact_person_1 }}</span>
          </div>
          @endif
          @if($quotation->position_1)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Position</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->position_1 }}</span>
          </div>
          @endif
          @if($quotation->contact_number_1)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Contact Number</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->contact_number_1 }}</span>
          </div>
          @endif
          @endif

          @if($quotation->contact_person_2 || $quotation->contact_number_2 || $quotation->position_2)
          <!-- Contact Person 2 -->
          <div style="font-weight: 600; color: #374151; font-size: 13px; padding: 8px 0px; border-bottom: 1px solid #e5e7eb; margin-bottom: 5px; margin-top: 10px;">Contact Person 2</div>
          @if($quotation->contact_person_2)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Person Name</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->contact_person_2 }}</span>
          </div>
          @endif
          @if($quotation->position_2)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Position</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->position_2 }}</span>
          </div>
          @endif
          @if($quotation->contact_number_2)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Contact Number</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->contact_number_2 }}</span>
          </div>
          @endif
          @endif

          @if($quotation->contact_person_3 || $quotation->contact_number_3 || $quotation->position_3)
          <!-- Contact Person 3 -->
          <div style="font-weight: 600; color: #374151; font-size: 13px; padding: 8px 0px; border-bottom: 1px solid #e5e7eb; margin-bottom: 5px; margin-top: 10px;">Contact Person 3</div>
          @if($quotation->contact_person_3)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Person Name</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->contact_person_3 }}</span>
          </div>
          @endif
          @if($quotation->position_3)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Position</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->position_3 }}</span>
          </div>
          @endif
          @if($quotation->contact_number_3)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Contact Number</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->contact_number_3 }}</span>
          </div>
          @endif
          @endif
        </div>
      </div>
    </div>
    @endif

    <!-- AMC & Retention Details -->
    @if($quotation->amc_start_date || $quotation->amc_amount || $quotation->retention_amount || $quotation->retention_percent || $quotation->retention_time)
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2px; margin-bottom: 30px; background: #d1d5db; border-radius: 8px; overflow: hidden;">
      @if($quotation->amc_start_date || $quotation->amc_amount)
      <div style="background: #ffffff; padding: 0; display: flex; flex-direction: column; align-items: center;">
        <h3 style="font-weight: 600; font-size: 14px; margin: 0 0 20px 0; color: #000; background: #F0F0F0; padding: 12px 20px; text-align: center; width: 100%;">AMC Details</h3>
        <div style="padding: 0 40px 25px 40px; width: 100%;">
        <div style="display: flex; flex-direction: column; gap: 0px; max-width: 600px; width: 100%;">
          @if($quotation->amc_start_date)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">AMC Start Date</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ \Carbon\Carbon::parse($quotation->amc_start_date)->format('d/m/Y') }}</span>
          </div>
          @endif
          @if($quotation->amc_amount)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">AMC Amount</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 600; text-align: left; flex: 1; font-size: 14px;">₹ {{ number_format($quotation->amc_amount, 2) }}</span>
          </div>
          @endif
        </div>
        </div>
      </div>
      @endif
      @if($quotation->retention_amount || $quotation->retention_percent || $quotation->retention_time)
      <div style="background: #ffffff; padding: 0; display: flex; flex-direction: column; align-items: center;">
        <h3 style="font-weight: 600; font-size: 14px; margin: 0 0 20px 0; color: #000; background: #F0F0F0; padding: 12px 20px; text-align: center; width: 100%;">Retention Details</h3>
        <div style="padding: 0 40px 25px 40px; width: 100%;">
        <div style="display: flex; flex-direction: column; gap: 0px; max-width: 600px; width: 100%;">
          @if($quotation->retention_amount)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Retention Amount</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 600; text-align: left; flex: 1; font-size: 14px;">₹ {{ number_format($quotation->retention_amount, 2) }}</span>
          </div>
          @endif
          @if($quotation->retention_percent)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Retention Percent</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->retention_percent }}%</span>
          </div>
          @endif
          @if($quotation->retention_time)
          <div style="display: flex; align-items: center; padding: 8px 0px;">
            <span style="color: #000; font-weight: 600; width: 220px; text-align: left; font-size: 14px;">Retention Time</span>
            <span style="color: #1f2937; width: 30px; text-align: center; font-weight: 600;">:</span>
            <span style="color: #4b5563; font-weight: 400; text-align: left; flex: 1; font-size: 14px;">{{ $quotation->retention_time }}</span>
          </div>
          @endif
        </div>
        </div>
      </div>
      @endif
    </div>
    @endif



    <!-- Basic Cost Details -->
    @if($quotation->basic_cost_description && is_array($quotation->basic_cost_description) && count($quotation->basic_cost_description) > 0)
    <div style="margin-bottom: 30px; padding: 0; background: #ffffff; border-radius: 8px; border: 1px solid #e5e7eb; overflow: hidden;">
      <h3 style="font-weight: 600; font-size: 14px; margin: 0 0 20px 0; color: #000; background: #F0F0F0; padding: 12px 20px; text-align: center; width: 100%;">Basic Cost Details</h3>
      <div style="padding: 0 40px 25px 40px;">
        <table style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr style="background: #f9fafb;">
              <th style="padding: 10px; text-align: left; border-bottom: 2px solid #e5e7eb; font-size: 13px; color: #374151;">Description</th>
              <th style="padding: 10px; text-align: center; border-bottom: 2px solid #e5e7eb; font-size: 13px; color: #374151;">Quantity</th>
              <th style="padding: 10px; text-align: right; border-bottom: 2px solid #e5e7eb; font-size: 13px; color: #374151;">Rate</th>
              <th style="padding: 10px; text-align: right; border-bottom: 2px solid #e5e7eb; font-size: 13px; color: #374151;">Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($quotation->basic_cost_description as $index => $desc)
            <tr>
              <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; font-size: 14px; color: #4b5563;">{{ $desc }}</td>
              <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; text-align: center; font-size: 14px; color: #4b5563;">{{ $quotation->basic_cost_quantity[$index] ?? '-' }}</td>
              <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; text-align: right; font-size: 14px; color: #4b5563;">₹ {{ isset($quotation->basic_cost_rate[$index]) ? number_format($quotation->basic_cost_rate[$index], 2) : '0.00' }}</td>
              <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; text-align: right; font-size: 14px; color: #4b5563; font-weight: 600;">₹ {{ isset($quotation->basic_cost_total[$index]) ? number_format($quotation->basic_cost_total[$index], 2) : '0.00' }}</td>
            </tr>
            @endforeach
            @if($quotation->basic_cost_total_amount)
            <tr style="background: #f9fafb;">
              <td colspan="3" style="padding: 10px; border-top: 2px solid #e5e7eb; text-align: right; font-weight: 600; font-size: 14px; color: #111827;">Total Basic Cost:</td>
              <td style="padding: 10px; border-top: 2px solid #e5e7eb; text-align: right; font-weight: 700; font-size: 15px; color: #111827;">₹ {{ number_format($quotation->basic_cost_total_amount, 2) }}</td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
    @endif

    <!-- Additional Cost Details -->
    @if($quotation->additional_cost_description && is_array($quotation->additional_cost_description) && count($quotation->additional_cost_description) > 0)
    <div style="margin-bottom: 30px; padding: 0; background: #ffffff; border-radius: 8px; border: 1px solid #e5e7eb; overflow: hidden;">
      <h3 style="font-weight: 600; font-size: 14px; margin: 0 0 20px 0; color: #000; background: #F0F0F0; padding: 12px 20px; text-align: center; width: 100%;">Additional Cost Details</h3>
      <div style="padding: 0 40px 25px 40px;">
        <table style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr style="background: #f9fafb;">
              <th style="padding: 10px; text-align: left; border-bottom: 2px solid #e5e7eb; font-size: 13px; color: #374151;">Description</th>
              <th style="padding: 10px; text-align: center; border-bottom: 2px solid #e5e7eb; font-size: 13px; color: #374151;">Quantity</th>
              <th style="padding: 10px; text-align: right; border-bottom: 2px solid #e5e7eb; font-size: 13px; color: #374151;">Rate</th>
              <th style="padding: 10px; text-align: right; border-bottom: 2px solid #e5e7eb; font-size: 13px; color: #374151;">Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($quotation->additional_cost_description as $index => $desc)
            <tr>
              <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; font-size: 14px; color: #4b5563;">{{ $desc }}</td>
              <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; text-align: center; font-size: 14px; color: #4b5563;">{{ $quotation->additional_cost_quantity[$index] ?? '-' }}</td>
              <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; text-align: right; font-size: 14px; color: #4b5563;">₹ {{ isset($quotation->additional_cost_rate[$index]) ? number_format($quotation->additional_cost_rate[$index], 2) : '0.00' }}</td>
              <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; text-align: right; font-size: 14px; color: #4b5563; font-weight: 600;">₹ {{ isset($quotation->additional_cost_total[$index]) ? number_format($quotation->additional_cost_total[$index], 2) : '0.00' }}</td>
            </tr>
            @endforeach
            @if($quotation->additional_cost_total_amount)
            <tr style="background: #f9fafb;">
              <td colspan="3" style="padding: 10px; border-top: 2px solid #e5e7eb; text-align: right; font-weight: 600; font-size: 14px; color: #111827;">Total Additional Cost:</td>
              <td style="padding: 10px; border-top: 2px solid #e5e7eb; text-align: right; font-weight: 700; font-size: 15px; color: #111827;">₹ {{ number_format($quotation->additional_cost_total_amount, 2) }}</td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
    @endif

    <!-- Support Details -->
    @if($quotation->support_description && is_array($quotation->support_description) && count($quotation->support_description) > 0)
    <div style="margin-bottom: 30px; padding: 0; background: #ffffff; border-radius: 8px; border: 1px solid #e5e7eb; overflow: hidden;">
      <h3 style="font-weight: 600; font-size: 14px; margin: 0 0 20px 0; color: #000; background: #F0F0F0; padding: 12px 20px; text-align: center; width: 100%;">Support Details</h3>
      <div style="padding: 0 40px 25px 40px;">
        <table style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr style="background: #f9fafb;">
              <th style="padding: 10px; text-align: left; border-bottom: 2px solid #e5e7eb; font-size: 13px; color: #374151;">Description</th>
              <th style="padding: 10px; text-align: center; border-bottom: 2px solid #e5e7eb; font-size: 13px; color: #374151;">Quantity</th>
              <th style="padding: 10px; text-align: right; border-bottom: 2px solid #e5e7eb; font-size: 13px; color: #374151;">Rate</th>
              <th style="padding: 10px; text-align: right; border-bottom: 2px solid #e5e7eb; font-size: 13px; color: #374151;">Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($quotation->support_description as $index => $desc)
            <tr>
              <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; font-size: 14px; color: #4b5563;">{{ $desc }}</td>
              <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; text-align: center; font-size: 14px; color: #4b5563;">{{ $quotation->support_quantity[$index] ?? '-' }}</td>
              <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; text-align: right; font-size: 14px; color: #4b5563;">₹ {{ isset($quotation->support_rate[$index]) ? number_format($quotation->support_rate[$index], 2) : '0.00' }}</td>
              <td style="padding: 10px; border-bottom: 1px solid #f3f4f6; text-align: right; font-size: 14px; color: #4b5563; font-weight: 600;">₹ {{ isset($quotation->support_total[$index]) ? number_format($quotation->support_total[$index], 2) : '0.00' }}</td>
            </tr>
            @endforeach
            @if($quotation->support_total_amount)
            <tr style="background: #f9fafb;">
              <td colspan="3" style="padding: 10px; border-top: 2px solid #e5e7eb; text-align: right; font-weight: 600; font-size: 14px; color: #111827;">Total Support Cost:</td>
              <td style="padding: 10px; border-top: 2px solid #e5e7eb; text-align: right; font-weight: 700; font-size: 15px; color: #111827;">₹ {{ number_format($quotation->support_total_amount, 2) }}</td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
    @endif





    <!-- Custom Terms & Conditions -->
    @if($quotation->custom_terms_and_conditions && count($quotation->custom_terms_and_conditions) > 0)
    <div style="margin-bottom: 30px; padding: 0; background: #ffffff; border-radius: 8px; border: 1px solid #e5e7eb; overflow: hidden;">
      <h3 style="font-weight: 600; font-size: 14px; margin: 0 0 20px 0; color: #000; background: #F0F0F0; padding: 12px 20px; text-align: center; width: 100%;">Terms & Conditions</h3>
      <div style="padding: 0 40px 25px 40px;">
        <div style="padding: 16px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
          <ol style="margin: 0; padding-left: 20px; font-size: 14px; color: #374151; line-height: 1.8;">
            @foreach($quotation->custom_terms_and_conditions as $term)
              @if(trim($term))
                <li style="margin-bottom: 8px;">{{ trim($term) }}</li>
              @endif
            @endforeach
          </ol>
        </div>
      </div>
    </div>
    @endif

    <!-- Contract Document -->
    @if($quotation->contract_copy_path)
    <div style="margin-bottom: 30px; padding: 0; background: #ffffff; border-radius: 8px; border: 1px solid #e5e7eb; overflow: hidden;">
      <h3 style="font-weight: 600; font-size: 14px; margin: 0 0 20px 0; color: #000; background: #F0F0F0; padding: 12px 20px; text-align: center; width: 100%;">Contract Document</h3>
      <div style="padding: 0 40px 25px 40px;">
        @can('Quotations Management.contract generate')
          <a href="{{ route('quotations.view-contract-file', $quotation->id) }}" target="_blank" class="pill-btn pill-success" style="padding:10px 20px;">
            View Contract Document
          </a>
        @endcan
      </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 30px;">
      <a href="{{ route('quotations.index') }}" class="pill-btn" style="background:#6b7280;color:#ffffff;padding:10px 20px;">
        ← Back to List
      </a>
      @can('Quotations Management.edit quotation')
        <a href="{{ route('quotations.edit', $quotation->id) }}" class="pill-btn" style="background:#3b82f6;color:#ffffff;padding:10px 20px;">
          Edit
        </a>
      @endcan
      @can('Quotations Management.print quotation')
        <a href="{{ route('quotations.download', $quotation->id) }}" class="pill-btn pill-success" style="padding:10px 20px;" target="_blank">
          Print PDF
        </a>
      @endcan
      @can('Quotations Management.follow up create')
        <a href="{{ route('quotation.follow-up', $quotation->id) }}" class="pill-btn" style="background:#f59e0b;color:#ffffff;padding:10px 20px;">
          Follow Up
        </a>
      @endcan
      @can('Quotations Management.template list')
        <a href="{{ route('quotations.template-list', $quotation->id) }}" class="pill-btn pill-success" style="padding:10px 20px;">
          View Templates
        </a>
      @endcan
    </div>

</div>
@endsection
