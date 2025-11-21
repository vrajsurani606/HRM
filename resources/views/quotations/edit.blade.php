@extends('layouts.macos')
@section('page_title', 'Edit Quotation')

@push('styles')
<style>
    .hrp-error {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
    }
    .is-invalid {
        border-color: #dc3545 !important;
    }
</style>
@endpush

@section('content')

<div class="hrp-card">
  <div class="Rectangle-30 hrp-compact">
    <form id="quotationForm" method="POST" action="{{ route('quotations.update', $quotation->id) }}"
      class="hrp-form grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <!-- Row 1 -->
      <div>
        <label class="hrp-label">Unique Code</label>
        <div class="Rectangle-29" style="display: flex; align-items: center; background: #f3f4f6;">
          {{ $quotation->unique_code }}
        </div>
      </div>
      <div>
        <label class="hrp-label">Quotation Title: <span class="text-red-500">*</span></label>
        <input class="Rectangle-29 @error('quotation_title') is-invalid @enderror" name="quotation_title" placeholder="Enter your Title" value="{{ old('quotation_title', $quotation->quotation_title) }}" required>
        @error('quotation_title')
            <small class="hrp-error">{{ $message }}</small>
        @enderror
      </div>
      <div>
        <label class="hrp-label">Quotation Date: <span class="text-red-500">*</span></label>
        <input type="date" class="Rectangle-29 @error('quotation_date') is-invalid @enderror" name="quotation_date" value="{{ old('quotation_date', $quotation->quotation_date?->format('Y-m-d')) }}" required>
        @error('quotation_date')
            <small class="hrp-error">{{ $message }}</small>
        @enderror
      </div>

      <!-- Row 2: Which Customer / Select Customer -->
      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
        <div class="md:col-span-1">
          <label class="hrp-label">Which Customer: <span class="text-red-500">*</span></label>
          <select class="Rectangle-29-select @error('customer_type') is-invalid @enderror" name="customer_type" id="customer_type" required>
            <option value="new" {{ old('customer_type', $quotation->customer_type) == 'new' ? 'selected' : '' }}>New Customer</option>
            <option value="existing" {{ old('customer_type', $quotation->customer_type) == 'existing' ? 'selected' : '' }}>Existing Customer</option>
          </select>
          @error('customer_type')
              <small class="hrp-error">{{ $message }}</small>
          @enderror
        </div>
        <div class="lg:col-span-1 {{ $quotation->customer_type == 'existing' ? '' : 'hidden' }}" id="existing_customer_field">
          <label class="hrp-label">Select Customer: <span class="text-red-500">*</span></label>
          <select class="Rectangle-29-select @error('customer_id') is-invalid @enderror" name="customer_id" id="customer_id">
            <option value="">Select Customer</option>
            @foreach($companies as $company)
            <option value="{{ $company->id }}" {{ old('customer_id', $quotation->customer_id) == $company->id ? 'selected' : '' }}>
              {{ $company->company_name }}
            </option>
            @endforeach
          </select>
          @error('customer_id')
              <small class="hrp-error">{{ $message }}</small>
          @enderror
        </div>
      </div>

      <!-- Basic Information Fields -->
      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">GST No:</label>
          <input class="Rectangle-29 @error('gst_no') is-invalid @enderror" name="gst_no" placeholder="Enter GST No" value="{{ old('gst_no', $quotation->gst_no) }}">
          @error('gst_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">PAN No:</label>
          <input class="Rectangle-29 @error('pan_no') is-invalid @enderror" name="pan_no" placeholder="Enter PAN No" value="{{ old('pan_no', $quotation->pan_no) }}">
          @error('pan_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>

      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Company Name: <span class="text-red-500">*</span></label>
          <input class="Rectangle-29 @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name', $quotation->company_name) }}" placeholder="Enter company name" required>
          @error('company_name')
              <small class="hrp-error">{{ $message }}</small>
          @enderror
        </div>
        <div>
          <label class="hrp-label">Company Type</label>
          <select name="company_type" class="Rectangle-29-select">
            <option value="">SELECT COMPANY TYPE</option>
            <option value="AUTOMOBILE" {{ old('company_type', $quotation->company_type) == 'AUTOMOBILE' ? 'selected' : '' }}>AUTOMOBILE</option>
            <option value="FMCG" {{ old('company_type', $quotation->company_type) == 'FMCG' ? 'selected' : '' }}>FMCG</option>
            <option value="IT" {{ old('company_type', $quotation->company_type) == 'IT' ? 'selected' : '' }}>INFORMATION TECHNOLOGY</option>
            <option value="HEALTHCARE" {{ old('company_type', $quotation->company_type) == 'HEALTHCARE' ? 'selected' : '' }}>HEALTHCARE</option>
          </select>
        </div>
      </div>

      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Nature Of Work:</label>
          <input class="Rectangle-29 @error('nature_of_work') is-invalid @enderror" name="nature_of_work" placeholder="Enter Nature" value="{{ old('nature_of_work', $quotation->nature_of_work) }}">
          @error('nature_of_work')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">City:</label>
          <select class="Rectangle-29-select @error('city') is-invalid @enderror" name="city">
            <option value="">Select City</option>
            <option value="Ahmedabad" {{ old('city', $quotation->city) == 'Ahmedabad' ? 'selected' : '' }}>Ahmedabad</option>
            <option value="Surat" {{ old('city', $quotation->city) == 'Surat' ? 'selected' : '' }}>Surat</option>
            <option value="Mumbai" {{ old('city', $quotation->city) == 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
          </select>
          @error('city')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>

      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Scope of Work:</label>
          <textarea class="Rectangle-29 Rectangle-29-textarea @error('scope_of_work') is-invalid @enderror" name="scope_of_work" placeholder="Enter Scope" style="min-height:80px">{{ old('scope_of_work', $quotation->scope_of_work) }}</textarea>
          @error('scope_of_work')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Address:</label>
          <textarea class="Rectangle-29 Rectangle-29-textarea @error('address') is-invalid @enderror" name="address" placeholder="Enter Address" style="min-height:80px">{{ old('address', $quotation->address) }}</textarea>
          @error('address')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>

      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Contact Person 1: <span class="text-red-500">*</span></label>
          <input class="Rectangle-29 @error('contact_person_1') is-invalid @enderror" name="contact_person_1" placeholder="Enter Contact Person Name" value="{{ old('contact_person_1', $quotation->contact_person_1) }}" required>
          @error('contact_person_1')
              <small class="hrp-error">{{ $message }}</small>
          @enderror
        </div>
        <div>
          <label class="hrp-label">Contact Number 1: <span class="text-red-500">*</span></label>
          <input class="Rectangle-29 @error('contact_number_1') is-invalid @enderror" name="contact_number_1" placeholder="Enter Mobile No" type="tel" pattern="\\d{10}" maxlength="10" value="{{ old('contact_number_1', $quotation->contact_number_1) }}" required>
          @error('contact_number_1')
              <small class="hrp-error">{{ $message }}</small>
          @enderror
        </div>
      </div>

      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Position 1:</label>
          <input class="Rectangle-29 @error('position_1') is-invalid @enderror" name="position_1" placeholder="Enter Position" value="{{ old('position_1', $quotation->position_1) }}">
          @error('position_1')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Contract Copy:</label>
          
          @if($quotation->contract_copy)
          <div style="margin-bottom: 10px;">
            <a href="{{ asset('storage/' . $quotation->contract_copy) }}" target="_blank" 
               style="color: #3b82f6; text-decoration: underline; font-size: 14px;">
              📄 {{ basename($quotation->contract_copy) }}
            </a>
            <span style="color: #6b7280; font-size: 12px; margin-left: 10px;">
              (Click to view current file)
            </span>
          </div>
          @endif
          
          <div class="upload-pill Rectangle-29 @error('contract_copy') is-invalid @enderror">
            <div class="choose">{{ $quotation->contract_copy ? 'Change File' : 'Choose File' }}</div>
            <div class="filename" id="contractCopyName">{{ $quotation->contract_copy ? 'Upload new file to replace' : 'No File Chosen' }}</div>
            <input id="contractCopyInput" name="contract_copy" type="file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
          </div>
          @error('contract_copy')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>

      <div>
        <label class="hrp-label">Contract Short Details:</label>
        <textarea class="Rectangle-29 Rectangle-29-textarea @error('contract_details') is-invalid @enderror" name="contract_details" placeholder="Enter Your Details" style="height:58px;resize:none;">{{ old('contract_details', $quotation->contract_details) }}</textarea>
        @error('contract_details')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>

      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Company Email: <span class="text-red-500">*</span></label>
          <input class="Rectangle-29 @error('company_email') is-invalid @enderror" type="email" name="company_email" value="{{ old('company_email', $quotation->company_email) }}" placeholder="Add Mail-Id" required>
          @error('company_email')
              <small class="hrp-error">{{ $message }}</small>
          @enderror
        </div>
        <div>
          <label class="hrp-label">Company Password:</label>
          <input class="Rectangle-29 @error('company_password') is-invalid @enderror" type="password" name="company_password" placeholder="Enter Company Password" value="{{ old('company_password', $quotation->company_password) }}">
          @error('company_password')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>

      <input type="hidden" name="contract_amount" id="hidden_contract_amount" value="{{ old('contract_amount', $quotation->service_contract_amount) }}">
  </div>
</div>

<!-- Services Section -->
<div style="margin: 30px 0;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3 style="margin-left: 20px; font-size: 18px; font-weight: 600;">Services</h3>
    <div>
      <button type="button" class="inquiry-submit-btn premium-quotation-btn" style="background: #ffa500; margin-right: 10px; width: fit-content;">Premium Quotation</button>
      <button type="button" class="inquiry-submit-btn add-more-services-1" style="background: #28a745;">+ Add More</button>
    </div>
  </div>

  <!-- Premium Section -->
  <div id="premiumSection" class="Rectangle-30 hrp-compact" style="display: none;">
    <h3 style="margin: 0 0 20px 0; font-size: 18px; font-weight: 600;">Key Features Selection</h3>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 30px;">
      @php
      $features = [
          'sample_management' => 'Sample Management',
          'user_friendly_interface' => 'User-Friendly Interface',
          'contact_management' => 'Contact Management',
          'test_management' => 'Test Management',
          'employee_management' => 'Employee Management',
          'lead_opportunity_management' => 'Lead and Opportunity Management',
          'data_integrity_security' => 'Data Integrity and Security',
          'recruitment_onboarding' => 'Recruitment and Onboarding',
          'sales_automation' => 'Sales Automation',
          'reporting_analytics' => 'Reporting and Analytics',
          'payroll_management' => 'Payroll Management',
          'customer_service_management' => 'Customer Service Management',
          'inventory_management' => 'Inventory Management',
          'training_development' => 'Training and Development',
          'integration_capabilities_lab' => 'Integration Capabilities (Lab)',
          'employee_self_service' => 'Employee Self-Service Portal',
          'marketing_automation' => 'Marketing Automation',
          'regulatory_compliance' => 'Regulatory Compliance',
          'analytics_reporting' => 'Analytics and Reporting',
          'integration_capabilities_crm' => 'Integration Capabilities (CRM)',
          'workflow_automation' => 'Workflow Automation',
          'integration_capabilities_hr' => 'Integration Capabilities (HR)'
      ];
      @endphp

      @foreach($features as $key => $label)
      <label style="display: flex; align-items: center; cursor: pointer;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="{{ $key }}" style="display: none;" 
               {{ $quotation->$key ? 'checked' : '' }}>
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: {{ $quotation->$key ? '#000' : 'white' }}; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: {{ $quotation->$key ? 'block' : 'none' }};">✓</span>
        </div>
        {{ $label }}
      </label>
      @endforeach
    </div>

    <!-- Basic Cost Table -->
    <div style="margin-bottom: 20px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h4 style="margin: 0;">Basic Cost</h4>
        <button type="button" class="inquiry-submit-btn add-basic-cost" style="background: #28a745; padding: 5px 15px;">+ Add</button>
      </div>
      <table id="basicCostTable" style="width: 100%;">
        <thead>
          <tr style="background: #f8f9fa;">
            <th style="padding: 12px; text-align: left;">Description</th>
            <th style="padding: 12px; text-align: left;">Quantity</th>
            <th style="padding: 12px; text-align: left;">Rate</th>
            <th style="padding: 12px; text-align: left;">Total</th>
            <th style="padding: 12px; text-align: left;">Action</th>
          </tr>
        </thead>
        <tbody>
          @if($quotation->basic_cost_description && count($quotation->basic_cost_description) > 0)
            @foreach($quotation->basic_cost_description as $index => $description)
            <tr>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29" name="basic_cost[description][]" value="{{ $description }}" style="border: none; background: transparent;"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 basic-quantity" type="number" name="basic_cost[quantity][]" value="{{ $quotation->basic_cost_quantity[$index] ?? '' }}" style="border: none; background: transparent;" oninput="calculateBasicTotal(this)"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 basic-rate" type="number" name="basic_cost[rate][]" value="{{ $quotation->basic_cost_rate[$index] ?? '' }}" style="border: none; background: transparent;" oninput="calculateBasicTotal(this)"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 basic-total" type="number" name="basic_cost[total][]" value="{{ $quotation->basic_cost_total[$index] ?? '' }}" style="border: none; background: transparent;" readonly></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-basic-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
            </tr>
            @endforeach
          @else
            <tr>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29" name="basic_cost[description][]" placeholder="Enter Description" style="border: none; background: transparent;"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 basic-quantity" type="number" name="basic_cost[quantity][]" placeholder="000" style="border: none; background: transparent;" oninput="calculateBasicTotal(this)"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 basic-rate" type="number" name="basic_cost[rate][]" placeholder="₹ 000" style="border: none; background: transparent;" oninput="calculateBasicTotal(this)"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 basic-total" type="number" name="basic_cost[total][]" placeholder="₹ 0000000" style="border: none; background: transparent;" readonly></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-basic-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
            </tr>
          @endif
        </tbody>
      </table>
      <div id="basicCostTotal" style="font-weight: 600; text-align: right; margin-top: 10px;">Total: ₹{{ number_format($quotation->basic_cost_total_amount ?? 0, 2) }}</div>
    </div>

    <!-- Additional Cost Table -->
    <div style="margin-bottom: 20px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h4 style="margin: 0;">Additional Cost</h4>
        <button type="button" class="inquiry-submit-btn add-additional-cost" style="background: #28a745; padding: 5px 15px;">+ Add</button>
      </div>
      <table id="additionalCostTable" style="width: 100%;">
        <thead>
          <tr style="background: #f8f9fa;">
            <th style="padding: 12px; text-align: left;">Description</th>
            <th style="padding: 12px; text-align: left;">Quantity</th>
            <th style="padding: 12px; text-align: left;">Rate</th>
            <th style="padding: 12px; text-align: left;">Total</th>
            <th style="padding: 12px; text-align: left;">Action</th>
          </tr>
        </thead>
        <tbody>
          @if($quotation->additional_cost_description && count($quotation->additional_cost_description) > 0)
            @foreach($quotation->additional_cost_description as $index => $description)
            <tr>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29" name="additional_cost[description][]" value="{{ $description }}" style="border: none; background: transparent;"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-quantity" type="number" name="additional_cost[quantity][]" value="{{ $quotation->additional_cost_quantity[$index] ?? '' }}" style="border: none; background: transparent;" oninput="calculateAdditionalTotal(this)"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-rate" type="number" name="additional_cost[rate][]" value="{{ $quotation->additional_cost_rate[$index] ?? '' }}" style="border: none; background: transparent;" oninput="calculateAdditionalTotal(this)"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-total" type="number" name="additional_cost[total][]" value="{{ $quotation->additional_cost_total[$index] ?? '' }}" style="border: none; background: transparent;" readonly></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-additional-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
            </tr>
            @endforeach
          @else
            <tr>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29" name="additional_cost[description][]" placeholder="Enter Description" style="border: none; background: transparent;"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-quantity" type="number" name="additional_cost[quantity][]" placeholder="000" style="border: none; background: transparent;" oninput="calculateAdditionalTotal(this)"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-rate" type="number" name="additional_cost[rate][]" placeholder="₹ 000" style="border: none; background: transparent;" oninput="calculateAdditionalTotal(this)"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-total" type="number" name="additional_cost[total][]" placeholder="₹ 0000000" style="border: none; background: transparent;" readonly></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-additional-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
            </tr>
          @endif
        </tbody>
      </table>
      <div id="additionalCostTotal" style="font-weight: 600; text-align: right; margin-top: 10px;">Total: ₹{{ number_format($quotation->additional_cost_total_amount ?? 0, 2) }}</div>
    </div>

    <!-- Maintenance/Support Cost Table -->
    <div>
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h4 style="margin: 0;">Annual Maintenance / Visiting / Manpower Support</h4>
        <button type="button" class="inquiry-submit-btn add-maintenance-cost" style="background: #28a745; padding: 5px 15px;">+ Add</button>
      </div>
      <table id="maintenanceCostTable" style="width: 100%;">
        <thead>
          <tr style="background: #f8f9fa;">
            <th style="padding: 12px; text-align: left;">Description</th>
            <th style="padding: 12px; text-align: left;">Quantity</th>
            <th style="padding: 12px; text-align: left;">Rate</th>
            <th style="padding: 12px; text-align: left;">Total</th>
            <th style="padding: 12px; text-align: left;">Action</th>
          </tr>
        </thead>
        <tbody>
          @if($quotation->support_description && count($quotation->support_description) > 0)
            @foreach($quotation->support_description as $index => $description)
            <tr>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29" name="maintenance_cost[description][]" value="{{ $description }}" style="border: none; background: transparent;"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-quantity" type="number" name="maintenance_cost[quantity][]" value="{{ $quotation->support_quantity[$index] ?? '' }}" style="border: none; background: transparent;" oninput="calculateMaintenanceTotal(this)"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-rate" type="number" name="maintenance_cost[rate][]" value="{{ $quotation->support_rate[$index] ?? '' }}" style="border: none; background: transparent;" oninput="calculateMaintenanceTotal(this)"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-total" type="number" name="maintenance_cost[total][]" value="{{ $quotation->support_total[$index] ?? '' }}" style="border: none; background: transparent;" readonly></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-maintenance-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
            </tr>
            @endforeach
          @else
            <tr>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29" name="maintenance_cost[description][]" placeholder="Enter Description" style="border: none; background: transparent;"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-quantity" type="number" name="maintenance_cost[quantity][]" placeholder="000" style="border: none; background: transparent;" oninput="calculateMaintenanceTotal(this)"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-rate" type="number" name="maintenance_cost[rate][]" placeholder="₹ 000" style="border: none; background: transparent;" oninput="calculateMaintenanceTotal(this)"></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-total" type="number" name="maintenance_cost[total][]" placeholder="₹ 0000000" style="border: none; background: transparent;" readonly></td>
              <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-maintenance-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
            </tr>
          @endif
        </tbody>
      </table>
      <div id="maintenanceCostTotal" style="font-weight: 600; text-align: right; margin-top: 10px;">Total: ₹{{ number_format($quotation->support_total_amount ?? 0, 2) }}</div>
    </div>
  </div>

  <!-- Main Services Table -->
  <div class="Rectangle-30 hrp-compact">
    <table class="services-table-1" style="width: 100%;">
      <thead>
        <tr style="background: #f8f9fa;">
          <th style="padding: 12px; text-align: left; font-weight: 600;">Description</th>
          <th style="padding: 12px; text-align: left; font-weight: 600;">Quantity</th>
          <th style="padding: 12px; text-align: left; font-weight: 600;">Rate</th>
          <th style="padding: 12px; text-align: left; font-weight: 600;">Total</th>
          <th style="padding: 12px; text-align: left; font-weight: 600;">Action</th>
        </tr>
      </thead>
      <tbody>
        @if($quotation->service_description && count($quotation->service_description) > 0)
          @foreach($quotation->service_description as $index => $description)
          <tr>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29" name="services_1[description][]" value="{{ $description }}" style="border: none; background: transparent;"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 quantity" type="number" name="services_1[quantity][]" value="{{ $quotation->service_quantity[$index] ?? '' }}" style="border: none; background: transparent;" oninput="calculateRowTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 rate" type="number" name="services_1[rate][]" value="{{ $quotation->service_rate[$index] ?? '' }}" style="border: none; background: transparent;" oninput="calculateRowTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 total" type="number" name="services_1[total][]" value="{{ $quotation->service_total[$index] ?? '' }}" style="border: none; background: transparent;" readonly></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
          </tr>
          @endforeach
        @else
          <tr>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29" name="services_1[description][]" placeholder="Enter Description" style="border: none; background: transparent;"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 quantity" type="number" name="services_1[quantity][]" placeholder="Enter Quantity" style="border: none; background: transparent;" oninput="calculateRowTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 rate" type="number" name="services_1[rate][]" placeholder="Enter Rate" style="border: none; background: transparent;" oninput="calculateRowTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 total" type="number" name="services_1[total][]" placeholder="Total Rate" style="border: none; background: transparent;" readonly></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
          </tr>
        @endif
      </tbody>
    </table>

    <!-- Contract Amount Section -->
    <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <label class="hrp-label" style="margin: 0; font-weight: 600;">Contract Amount :</label>
        <input id="contract_amount" class="Rectangle-29" type="number" name="contract_amount" placeholder="Total Rate" style="width: 200px;" readonly value="{{ old('contract_amount', $quotation->service_contract_amount) }}">
      </div>
    </div>
  </div>
</div>

<!-- Second Services Table -->
<div style="margin: 30px 0;">
  <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
    <button type="button" class="inquiry-submit-btn add-more-services-2" style="background: #28a745;">+ Add More</button>
  </div>
  <div class="Rectangle-30 hrp-compact">
    <table class="services-table-2" style="width: 100%;">
      <thead>
        <tr>
          <th style="padding: 12px; text-align: left; font-weight: 600;">Description</th>
          <th style="padding: 12px; text-align: left; font-weight: 600;">Quantity</th>
          <th style="padding: 12px; text-align: left; font-weight: 600;">Rate</th>
          <th style="padding: 12px; text-align: left; font-weight: 600;">Total</th>
          <th style="padding: 12px; text-align: left; font-weight: 600;">Completion (%)</th>
          <th style="padding: 12px; text-align: left; font-weight: 600;">Completion Terms</th>
          <th style="padding: 12px; text-align: left; font-weight: 600;">Action</th>
        </tr>
      </thead>
      <tbody>
        @if($quotation->terms_description && count($quotation->terms_description) > 0)
          @foreach($quotation->terms_description as $index => $description)
          <tr>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
              <select class="Rectangle-29-select" name="services_2[description][]" style="border: none; background: transparent;">
                <option value="">Select Service</option>
                <option value="ADVANCE" {{ $description == 'ADVANCE' ? 'selected' : '' }}>ADVANCE</option>
                <option value="ON INSTALLATION" {{ $description == 'ON INSTALLATION' ? 'selected' : '' }}>ON INSTALLATION</option>
                <option value="COMPLETION" {{ $description == 'COMPLETION' ? 'selected' : '' }}>COMPLETION</option>
                <option value="RETENTION" {{ $description == 'RETENTION' ? 'selected' : '' }}>RETENTION</option>
              </select>
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
              <input class="Rectangle-29 quantity" type="number" name="services_2[quantity][]" value="{{ $quotation->terms_quantity[$index] ?? '' }}" style="border: none; background: transparent;" oninput="calculateRowTotal(this)">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
              <input class="Rectangle-29 rate" type="number" name="services_2[rate][]" value="{{ $quotation->terms_rate[$index] ?? '' }}" style="border: none; background: transparent;" oninput="calculateRowTotal(this)">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
              <input class="Rectangle-29 total" type="number" name="services_2[total][]" value="{{ $quotation->terms_total[$index] ?? '' }}" style="border: none; background: transparent;" readonly>
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
              <input class="Rectangle-29 completion-percent" type="number" min="0" max="100" name="services_2[completion_percent][]" value="{{ $quotation->terms_completion[$index] ?? '' }}" style="border: none; background: transparent;" oninput="calculatePercentageAmount(this)">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
              <input class="Rectangle-29" name="services_2[completion_terms][]" value="{{ $quotation->completion_terms[$index] ?? '' }}" placeholder="Enter Terms" style="border: none; background: transparent; width: 100%;">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
              <button type="button" class="remove-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button>
            </td>
          </tr>
          @endforeach
        @else
          <tr>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
              <select class="Rectangle-29-select" name="services_2[description][]" style="border: none; background: transparent;">
                <option value="">Select Service</option>
                <option value="ADVANCE">ADVANCE</option>
                <option value="ON INSTALLATION">ON INSTALLATION</option>
                <option value="COMPLETION">COMPLETION</option>
                <option value="RETENTION">RETENTION</option>
              </select>
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
              <input class="Rectangle-29 quantity" type="number" name="services_2[quantity][]" placeholder="Enter Quantity" style="border: none; background: transparent;" oninput="calculateRowTotal(this)">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
              <input class="Rectangle-29 rate" type="number" name="services_2[rate][]" placeholder="Enter Rate" style="border: none; background: transparent;" oninput="calculateRowTotal(this)">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
              <input class="Rectangle-29 total" type="number" name="services_2[total][]" placeholder="Total Amount" style="border: none; background: transparent;" readonly>
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
              <input class="Rectangle-29 completion-percent" type="number" min="0" max="100" name="services_2[completion_percent][]" placeholder="Enter %" style="border: none; background: transparent;" oninput="calculatePercentageAmount(this)">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
              <input class="Rectangle-29" name="services_2[completion_terms][]" placeholder="Enter Terms" style="border: none; background: transparent; width: 100%;">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
              <button type="button" class="remove-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button>
            </td>
          </tr>
        @endif
      </tbody>
    </table>

    <div class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5" style="margin-top: 20px;">
      <div>
        <label class="hrp-label">Tentative Complete Date:</label>
        <input type="date" class="Rectangle-29" name="tentative_complete_date_2" value="{{ old('tentative_complete_date_2', $quotation->terms_tentative_complete_date?->format('Y-m-d')) }}">
      </div>
      <div></div>
    </div>
  </div>
</div>

<!-- AMC Details -->
<div class="Rectangle-30 hrp-compact">
  <div class="hrp-form grid grid-cols-1 md:grid-cols-5 gap-4 md:gap-5" style="margin: 30px 0;">
    <div>
      <label class="hrp-label">AMC Start From:</label>
      <input type="date" class="Rectangle-29" name="amc_start_date" value="{{ old('amc_start_date', $quotation->amc_start_date?->format('Y-m-d')) }}">
    </div>
    <div>
      <label class="hrp-label">AMC Amount:</label>
      <input class="Rectangle-29" name="amc_amount" placeholder="Enter Amount" value="{{ old('amc_amount', $quotation->amc_amount) }}">
    </div>
    <div>
      <label class="hrp-label">Project Start Date:</label>
      <input type="date" class="Rectangle-29" name="project_start_date" value="{{ old('project_start_date', $quotation->project_start_date?->format('Y-m-d')) }}">
    </div>
    <div>
      <label class="hrp-label">Completion Time:</label>
      <input class="Rectangle-29" name="completion_time" placeholder="Enter Time" value="{{ old('completion_time', $quotation->completion_time) }}">
    </div>
    <div>
      <label class="hrp-label">Retention Time:</label>
      <input class="Rectangle-29" name="retention_time" placeholder="Enter Time" value="{{ old('retention_time', $quotation->retention_time) }}">
    </div>

    <div>
      <label class="hrp-label">Retention Amount:</label>
      <input id="retention_amount" class="Rectangle-29" name="retention_amount" placeholder="Enter Amount" readonly value="{{ old('retention_amount', $quotation->retention_amount) }}">
    </div>
    <div>
      <label class="hrp-label">Retention %:</label>
      <input class="Rectangle-29" id="retention_percent" name="retention_percent" type="number" min="0" max="100" step="0.1" placeholder="Enter %" oninput="calculateRetentionAmount()" value="{{ old('retention_percent', $quotation->retention_percent) }}">
    </div>
    <div>
      <label class="hrp-label">Tentative Complete Date:</label>
      <input type="date" class="Rectangle-29" name="tentative_complete_date" value="{{ old('tentative_complete_date', $quotation->tentative_complete_date?->format('Y-m-d')) }}">
    </div>
    <div></div>
    <div></div>
  </div>
</div>

<!-- Footer Section -->
<div class="Rectangle-30 hrp-compact">
  <div class="hrp-form grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5" style="margin: 30px 0;">
    <div>
      <label class="hrp-label">Prepared By:</label>
      <input class="Rectangle-29" name="prepared_by" placeholder="Enter Name" value="{{ old('prepared_by', $quotation->prepared_by) }}">
    </div>
    <div>
      <label class="hrp-label">Mobile No.:</label>
      <input class="Rectangle-29" name="mobile_no" placeholder="Add Mobile No" value="{{ old('mobile_no', $quotation->mobile_no) }}">
    </div>
    <div>
      <label class="hrp-label">Company Name:</label>
      <input class="Rectangle-29" name="footer_company_name" value="{{ old('footer_company_name', $quotation->own_company_name ?? 'CHITRI INFOTECH PVT LTD') }}">
    </div>
  </div>
</div>

<div class="hrp-actions" style="margin-top: 40px;">
  <button type="button" onclick="debugFormSubmission();" class="hrp-btn hrp-btn-primary">Update Quotation</button>
</div>

<!-- Hidden inputs for subtotals -->
<input type="hidden" name="basic_subtotal" id="hidden_basic_subtotal" value="{{ old('basic_subtotal', $quotation->basic_cost_total_amount ?? 0) }}">
<input type="hidden" name="additional_subtotal" id="hidden_additional_subtotal" value="{{ old('additional_subtotal', $quotation->additional_cost_total_amount ?? 0) }}">
<input type="hidden" name="maintenance_subtotal" id="hidden_maintenance_subtotal" value="{{ old('maintenance_subtotal', $quotation->support_total_amount ?? 0) }}">

</form>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Copy all JavaScript functions from create.blade.php
function calculateRowTotal(input) {
    const row = input.closest('tr');
    const quantity = parseFloat(row.querySelector('.quantity')?.value) || 0;
    const rate = parseFloat(row.querySelector('.rate')?.value) || 0;
    const total = quantity * rate;
    row.querySelector('.total').value = total.toFixed(2);
    calculateContractAmount();
}

function calculateContractAmount() {
    let total = 0;
    document.querySelectorAll('.services-table-1 .total').forEach(i => total += parseFloat(i.value) || 0);
    document.getElementById('contract_amount').value = total.toFixed(2);
    document.getElementById('hidden_contract_amount').value = total.toFixed(2);
}

function calculateBasicTotal(input) {
    const row = input.closest('tr');
    const quantity = parseFloat(row.querySelector('.basic-quantity')?.value) || 0;
    const rate = parseFloat(row.querySelector('.basic-rate')?.value) || 0;
    row.querySelector('.basic-total').value = (quantity * rate).toFixed(2);
    calculateBasicCostTotal();
}

function calculateBasicCostTotal() {
    let total = 0;
    document.querySelectorAll('.basic-total').forEach(i => total += parseFloat(i.value) || 0);
    document.getElementById('basicCostTotal').innerHTML = `Total: ₹${total.toFixed(2)}`;
    // Update hidden input
    const hiddenInput = document.getElementById('hidden_basic_subtotal');
    if (hiddenInput) hiddenInput.value = total.toFixed(2);
}

function calculateAdditionalTotal(input) {
    const row = input.closest('tr');
    const quantity = parseFloat(row.querySelector('.additional-quantity')?.value) || 0;
    const rate = parseFloat(row.querySelector('.additional-rate')?.value) || 0;
    row.querySelector('.additional-total').value = (quantity * rate).toFixed(2);
    calculateAdditionalCostTotal();
}

function calculateAdditionalCostTotal() {
    let total = 0;
    document.querySelectorAll('.additional-total').forEach(i => total += parseFloat(i.value) || 0);
    document.getElementById('additionalCostTotal').innerHTML = `Total: ₹${total.toFixed(2)}`;
    // Update hidden input
    const hiddenInput = document.getElementById('hidden_additional_subtotal');
    if (hiddenInput) hiddenInput.value = total.toFixed(2);
}

function calculateMaintenanceTotal(input) {
    const row = input.closest('tr');
    const quantity = parseFloat(row.querySelector('.maintenance-quantity')?.value) || 0;
    const rate = parseFloat(row.querySelector('.maintenance-rate')?.value) || 0;
    row.querySelector('.maintenance-total').value = (quantity * rate).toFixed(2);
    calculateMaintenanceCostTotal();
}

function calculateMaintenanceCostTotal() {
    let total = 0;
    document.querySelectorAll('.maintenance-total').forEach(i => total += parseFloat(i.value) || 0);
    document.getElementById('maintenanceCostTotal').innerHTML = `Total: ₹${total.toFixed(2)}`;
    // Update hidden input
    const hiddenInput = document.getElementById('hidden_maintenance_subtotal');
    if (hiddenInput) hiddenInput.value = total.toFixed(2);
}

function calculateRetentionAmount() {
    const retentionPercent = parseFloat(document.getElementById('retention_percent')?.value) || 0;
    const contractAmount = parseFloat(document.getElementById('contract_amount')?.value) || 0;
    
    if (retentionPercent > 0 && contractAmount > 0) {
        const retentionAmount = (contractAmount * retentionPercent) / 100;
        document.getElementById('retention_amount').value = retentionAmount.toFixed(2);
    } else {
        document.getElementById('retention_amount').value = '';
    }
}

function calculatePercentageAmount(input) {
    const row = input.closest('tr');
    const percentage = parseFloat(input.value) || 0;
    const contractAmount = parseFloat(document.getElementById('contract_amount')?.value) || 0;
    
    if (percentage > 0 && contractAmount > 0) {
        const percentageAmount = (contractAmount * percentage) / 100;
        const rateInput = row.querySelector('.rate');
        const quantityInput = row.querySelector('.quantity');
        const totalInput = row.querySelector('.total');
        
        if (quantityInput) quantityInput.value = 1;
        if (rateInput) rateInput.value = percentageAmount.toFixed(2);
        if (totalInput) totalInput.value = percentageAmount.toFixed(2);
    }
}

function debugFormSubmission() {
    const form = document.getElementById('quotationForm');
    
    // Validate that at least one service is entered
    const services1Rows = document.querySelectorAll('.services-table-1 tbody tr');
    let hasValidService = false;
    let validServiceCount = 0;
    
    services1Rows.forEach((row) => {
        const descInput = row.querySelector('input[name="services_1[description][]"]');
        if (descInput?.value && descInput.value.trim() !== '') {
            hasValidService = true;
            validServiceCount++;
        }
    });
    
    if (!hasValidService) {
        // Show error message
        const errorDiv = document.createElement('div');
        errorDiv.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #fee; border: 2px solid #fcc; color: #c33; padding: 20px; border-radius: 8px; z-index: 9999; max-width: 400px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);';
        errorDiv.innerHTML = '<strong>Validation Error:</strong><br>Please add at least one service before updating the quotation.';
        document.body.appendChild(errorDiv);
        
        // Scroll to services section
        document.querySelector('.services-table-1')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Remove error after 5 seconds
        setTimeout(() => errorDiv.remove(), 5000);
        
        return false;
    }
    
    console.log(`Updating quotation with ${validServiceCount} service(s)`);
    
    // Remove any existing hidden repeater inputs
    form.querySelectorAll('input[type="hidden"]').forEach(input => {
        if (input.name.includes('[description][]') || input.name.includes('[quantity][]') || 
            input.name.includes('[rate][]') || input.name.includes('[total][]') ||
            input.name.includes('[completion_percent][]') || input.name.includes('[completion_terms][]')) {
            input.remove();
        }
    });
    
    // Handle services_1 repeater - disable original inputs and create hidden ones
    const services1RowsForProcessing = document.querySelectorAll('.services-table-1 tbody tr');
    services1RowsForProcessing.forEach((row) => {
        const descInput = row.querySelector('input[name="services_1[description][]"]');
        const qtyInput = row.querySelector('input[name="services_1[quantity][]"]');
        const rateInput = row.querySelector('input[name="services_1[rate][]"]');
        const totalInput = row.querySelector('input[name="services_1[total][]"]');
        
        // Disable original inputs to prevent double submission
        if (descInput) descInput.disabled = true;
        if (qtyInput) qtyInput.disabled = true;
        if (rateInput) rateInput.disabled = true;
        if (totalInput) totalInput.disabled = true;
        
        // Only add hidden inputs if description has actual content
        if (descInput?.value && descInput.value.trim() !== '') {
            addHiddenInput(form, 'services_1[description][]', descInput.value);
            addHiddenInput(form, 'services_1[quantity][]', qtyInput?.value || '0');
            addHiddenInput(form, 'services_1[rate][]', rateInput?.value || '0');
            addHiddenInput(form, 'services_1[total][]', totalInput?.value || '0');
        }
    });
    
    // Handle services_2 repeater - disable original inputs and create hidden ones
    const services2Rows = document.querySelectorAll('.services-table-2 tbody tr');
    services2Rows.forEach((row) => {
        const descSelect = row.querySelector('select');
        const qtyInput = row.querySelector('input.quantity');
        const rateInput = row.querySelector('input.rate');
        const totalInput = row.querySelector('input.total');
        const percentInput = row.querySelector('input.completion-percent');
        const termsInput = row.querySelector('input[placeholder="Enter Terms"]');
        
        // Disable original inputs to prevent double submission
        if (descSelect) descSelect.disabled = true;
        if (qtyInput) qtyInput.disabled = true;
        if (rateInput) rateInput.disabled = true;
        if (totalInput) totalInput.disabled = true;
        if (percentInput) percentInput.disabled = true;
        if (termsInput) termsInput.disabled = true;
        
        // Only add hidden inputs if description is selected
        if (descSelect?.value && descSelect.value.trim() !== '') {
            addHiddenInput(form, 'services_2[description][]', descSelect.value);
            addHiddenInput(form, 'services_2[quantity][]', qtyInput?.value || '0');
            addHiddenInput(form, 'services_2[rate][]', rateInput?.value || '0');
            addHiddenInput(form, 'services_2[total][]', totalInput?.value || '0');
            addHiddenInput(form, 'services_2[completion_percent][]', percentInput?.value || '0');
            addHiddenInput(form, 'services_2[completion_terms][]', termsInput?.value || '');
        }
    });
    
    // Handle basic_cost repeater - disable original inputs and create hidden ones
    const basicRows = document.querySelectorAll('#basicCostTable tbody tr');
    basicRows.forEach((row) => {
        const descInput = row.querySelector('input[name="basic_cost[description][]"]');
        const qtyInput = row.querySelector('input[name="basic_cost[quantity][]"]');
        const rateInput = row.querySelector('input[name="basic_cost[rate][]"]');
        const totalInput = row.querySelector('input[name="basic_cost[total][]"]');
        
        // Disable original inputs
        if (descInput) descInput.disabled = true;
        if (qtyInput) qtyInput.disabled = true;
        if (rateInput) rateInput.disabled = true;
        if (totalInput) totalInput.disabled = true;
        
        // Only add hidden inputs if description has actual content
        if (descInput?.value && descInput.value.trim() !== '') {
            addHiddenInput(form, 'basic_cost[description][]', descInput.value);
            addHiddenInput(form, 'basic_cost[quantity][]', qtyInput?.value || '0');
            addHiddenInput(form, 'basic_cost[rate][]', rateInput?.value || '0');
            addHiddenInput(form, 'basic_cost[total][]', totalInput?.value || '0');
        }
    });
    
    // Handle additional_cost repeater - disable original inputs and create hidden ones
    const additionalRows = document.querySelectorAll('#additionalCostTable tbody tr');
    additionalRows.forEach((row) => {
        const descInput = row.querySelector('input[name="additional_cost[description][]"]');
        const qtyInput = row.querySelector('input[name="additional_cost[quantity][]"]');
        const rateInput = row.querySelector('input[name="additional_cost[rate][]"]');
        const totalInput = row.querySelector('input[name="additional_cost[total][]"]');
        
        // Disable original inputs
        if (descInput) descInput.disabled = true;
        if (qtyInput) qtyInput.disabled = true;
        if (rateInput) rateInput.disabled = true;
        if (totalInput) totalInput.disabled = true;
        
        // Only add hidden inputs if description has actual content
        if (descInput?.value && descInput.value.trim() !== '') {
            addHiddenInput(form, 'additional_cost[description][]', descInput.value);
            addHiddenInput(form, 'additional_cost[quantity][]', qtyInput?.value || '0');
            addHiddenInput(form, 'additional_cost[rate][]', rateInput?.value || '0');
            addHiddenInput(form, 'additional_cost[total][]', totalInput?.value || '0');
        }
    });
    
    // Handle maintenance_cost repeater - disable original inputs and create hidden ones
    const maintenanceRows = document.querySelectorAll('#maintenanceCostTable tbody tr');
    maintenanceRows.forEach((row) => {
        const descInput = row.querySelector('input[name="maintenance_cost[description][]"]');
        const qtyInput = row.querySelector('input[name="maintenance_cost[quantity][]"]');
        const rateInput = row.querySelector('input[name="maintenance_cost[rate][]"]');
        const totalInput = row.querySelector('input[name="maintenance_cost[total][]"]');
        
        // Disable original inputs
        if (descInput) descInput.disabled = true;
        if (qtyInput) qtyInput.disabled = true;
        if (rateInput) rateInput.disabled = true;
        if (totalInput) totalInput.disabled = true;
        
        // Only add hidden inputs if description has actual content
        if (descInput?.value && descInput.value.trim() !== '') {
            addHiddenInput(form, 'maintenance_cost[description][]', descInput.value);
            addHiddenInput(form, 'maintenance_cost[quantity][]', qtyInput?.value || '0');
            addHiddenInput(form, 'maintenance_cost[rate][]', rateInput?.value || '0');
            addHiddenInput(form, 'maintenance_cost[total][]', totalInput?.value || '0');
        }
    });
    
    console.log('Fixed all repeaters for form submission');
    form.submit();
}

function addHiddenInput(form, name, value) {
    const hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = name;
    hidden.value = value;
    form.appendChild(hidden);
}

document.addEventListener('DOMContentLoaded', function() {
    // Handle file input display
    const contractCopyInput = document.getElementById('contractCopyInput');
    const contractCopyName = document.getElementById('contractCopyName');
    
    if (contractCopyInput && contractCopyName) {
        contractCopyInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                contractCopyName.textContent = this.files[0].name;
            } else {
                contractCopyName.textContent = '{{ $quotation->contract_copy ? "Upload new file to replace" : "No File Chosen" }}';
            }
        });
    }

    // Customer type toggle
    const customerType = document.getElementById('customer_type');
    const customerField = document.getElementById('existing_customer_field');
    
    customerType.addEventListener('change', function() {
        customerField.classList.toggle('hidden', this.value !== 'existing');
    });

    // Premium quotation toggle
    document.querySelector('.premium-quotation-btn')?.addEventListener('click', function() {
        const sec = document.getElementById('premiumSection');
        const show = sec.style.display !== 'block';
        sec.style.display = show ? 'block' : 'none';
        this.textContent = show ? 'Hide Premium' : 'Premium Quotation';
        this.style.background = show ? '#dc3545' : '#ffa500';
    });

    // Add more services
    document.querySelector('.add-more-services-1')?.addEventListener('click', function() {
        const tbody = document.querySelector('.services-table-1 tbody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29" name="services_1[description][]" placeholder="Enter Description" style="border: none; background: transparent; width: 100%;">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29 quantity" type="number" name="services_1[quantity][]" placeholder="Enter Quantity" style="border: none; background: transparent; width: 100%;" oninput="calculateRowTotal(this)">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29 rate" type="number" name="services_1[rate][]" placeholder="Enter Rate" style="border: none; background: transparent; width: 100%;" oninput="calculateRowTotal(this)">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29 total" type="number" name="services_1[total][]" placeholder="Total Rate" style="border: none; background: transparent; width: 100%;" readonly>
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: center;">
                <button type="button" class="remove-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button>
            </td>
        `;
        tbody.appendChild(row);
    });

    // Add more basic cost
    document.querySelector('.add-basic-cost')?.addEventListener('click', function() {
        const tbody = document.querySelector('#basicCostTable tbody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29" name="basic_cost[description][]" placeholder="Enter Description" style="border: none; background: transparent;"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 basic-quantity" type="number" min="0" step="1" name="basic_cost[quantity][]" placeholder="000" style="border: none; background: transparent;" oninput="calculateBasicTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 basic-rate" type="number" min="0" step="0.01" name="basic_cost[rate][]" placeholder="₹ 000" style="border: none; background: transparent;" oninput="calculateBasicTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 basic-total" type="number" min="0" step="0.01" name="basic_cost[total][]" placeholder="₹ 0000000" style="border: none; background: transparent;" readonly></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-basic-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
        `;
        tbody.appendChild(row);
    });

    // Add more additional cost
    document.querySelector('.add-additional-cost')?.addEventListener('click', function() {
        const tbody = document.querySelector('#additionalCostTable tbody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29" name="additional_cost[description][]" placeholder="Enter Description" style="border: none; background: transparent;"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-quantity" type="number" name="additional_cost[quantity][]" placeholder="000" style="border: none; background: transparent;" oninput="calculateAdditionalTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-rate" type="number" name="additional_cost[rate][]" placeholder="₹ 000" style="border: none; background: transparent;" oninput="calculateAdditionalTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-total" type="number" name="additional_cost[total][]" placeholder="₹ 0000000" style="border: none; background: transparent;" readonly></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-additional-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
        `;
        tbody.appendChild(row);
    });

    // Add more services_2
    document.querySelector('.add-more-services-2')?.addEventListener('click', function() {
        const tbody = document.querySelector('.services-table-2 tbody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <select class="Rectangle-29-select" name="services_2[description][]" style="border: none; background: transparent; width: 100%;">
                    <option value="">Select Service</option>
                    <option value="ADVANCE">ADVANCE</option>
                    <option value="ON INSTALLATION">ON INSTALLATION</option>
                    <option value="COMPLETION">COMPLETION</option>
                    <option value="RETENTION">RETENTION</option>
                </select>
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29 quantity" type="number" name="services_2[quantity][]" placeholder="Enter Quantity" style="border: none; background: transparent; width: 100%;" oninput="calculateRowTotal(this)">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29 rate" type="number" name="services_2[rate][]" placeholder="Enter Rate" style="border: none; background: transparent; width: 100%;" oninput="calculateRowTotal(this)">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29 total" type="number" name="services_2[total][]" placeholder="Total Amount" style="border: none; background: transparent; width: 100%;" readonly>
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29 completion-percent" type="number" min="0" max="100" name="services_2[completion_percent][]" placeholder="Enter %" style="border: none; background: transparent; width: 100%;" oninput="calculatePercentageAmount(this)">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29" name="services_2[completion_terms][]" placeholder="Enter Terms" style="border: none; background: transparent; width: 100%;">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <button type="button" class="remove-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button>
            </td>
        `;
        tbody.appendChild(row);
    });

    // Add more maintenance cost
    document.querySelector('.add-maintenance-cost')?.addEventListener('click', function() {
        const tbody = document.querySelector('#maintenanceCostTable tbody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29" name="maintenance_cost[description][]" placeholder="Enter Description" style="border: none; background: transparent;"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-quantity" type="number" name="maintenance_cost[quantity][]" placeholder="000" style="border: none; background: transparent;" oninput="calculateMaintenanceTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-rate" type="number" name="maintenance_cost[rate][]" placeholder="₹ 000" style="border: none; background: transparent;" oninput="calculateMaintenanceTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-total" type="number" name="maintenance_cost[total][]" placeholder="₹ 0000000" style="border: none; background: transparent;" readonly></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-maintenance-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
        `;
        tbody.appendChild(row);
    });

    // Remove row
    document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
            calculateContractAmount();
        }
        if (e.target.classList.contains('remove-basic-row')) {
            e.target.closest('tr').remove();
            calculateBasicCostTotal();
        }
        if (e.target.classList.contains('remove-additional-row')) {
            e.target.closest('tr').remove();
            calculateAdditionalCostTotal();
        }
        if (e.target.classList.contains('remove-maintenance-row')) {
            e.target.closest('tr').remove();
            calculateMaintenanceCostTotal();
        }
    });

    // Custom checkbox
    document.querySelectorAll('.custom-checkbox').forEach(label => {
        label.addEventListener('click', function(e) {
            e.preventDefault();
            const checkbox = this.querySelector('input[type="checkbox"]');
            const box = this.querySelector('.checkbox-box');
            const mark = this.querySelector('.checkmark');

            checkbox.checked = !checkbox.checked;
            box.style.background = checkbox.checked ? '#000' : 'white';
            mark.style.display = checkbox.checked ? 'block' : 'none';
        });
    });

    // Initial calculations
    calculateContractAmount();
    calculateBasicCostTotal();
    calculateAdditionalCostTotal();
    calculateMaintenanceCostTotal();
});
</script>
@endpush
@endsection