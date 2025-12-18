@extends('layouts.macos')
@section('page_title', 'Make Quotation')

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
    <form id="quotationForm" method="POST" action="{{ route('quotations.store') }}" enctype="multipart/form-data"
      class="hrp-form grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5">
      @csrf
      <input type="hidden" name="inquiry_id" value="{{ isset($inquiry) ? $inquiry->id : '' }}">

      <!-- Row 1 -->
      <div>
        <label class="hrp-label">Unique Code</label>
        <div class="Rectangle-29" style="display: flex; align-items: center; background: #f3f4f6;">
          {{ $nextCode ?? 'CMS/QUAT/0001' }}
          <input type="hidden" name="unique_code" value="{{ $nextCode ?? 'CMS/QUAT/0001' }}">
        </div>
      </div>
      <div>
        <label class="hrp-label">Quotation Title: <span class="text-red-500">*</span></label>
        <input class="Rectangle-29 @error('quotation_title') is-invalid @enderror" name="quotation_title" placeholder="Enter your Title" value="{{ old('quotation_title') }}" required>
        @error('quotation_title')
            <small class="hrp-error">{{ $message }}</small>
        @enderror
      </div>
      <div>
        <label class="hrp-label">Quotation Date: <span class="text-red-500">*</span></label>
        <input type="text" class="Rectangle-29 date-picker @error('quotation_date') is-invalid @enderror" name="quotation_date" placeholder="dd/mm/yyyy" value="{{ old('quotation_date', date('d/m/Y')) }}" autocomplete="off" required>
        @error('quotation_date')
            <small class="hrp-error">{{ $message }}</small>
        @enderror
      </div>

      <!-- Row 2: Which Customer / Select Customer -->
      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Which Customer: <span class="text-red-500">*</span></label>
          @php
              $customerType = old('customer_type', $quotationData['customer_type'] ?? 'new');
          @endphp
          <select class="Rectangle-29-select @error('customer_type') is-invalid @enderror" name="customer_type" id="customer_type" required>
            <option value="new" {{ $customerType == 'new' ? 'selected' : '' }}>New Customer</option>
            <option value="existing" {{ $customerType == 'existing' ? 'selected' : '' }}>Existing Customer</option>
          </select>
          @error('customer_type')
              <small class="hrp-error">{{ $message }}</small>
          @enderror
        </div>
        <div class="lg:col-span-1 {{ $customerType == 'existing' ? '' : 'hidden' }}" id="existing_customer_field">
          <label class="hrp-label">Select Customer: <span class="text-red-500">*</span></label>
          @php
              $selectedCustomerId = old('customer_id', $quotationData['customer_id'] ?? '');
          @endphp
          <select class="Rectangle-29-select @error('customer_id') is-invalid @enderror" name="customer_id" id="customer_id" {{ $customerType == 'existing' ? 'required' : '' }}>
            <option value="">Select Customer</option>
            @if(isset($companies))
              @foreach($companies as $company)
              <option value="{{ $company->id }}" {{ $selectedCustomerId == $company->id ? 'selected' : '' }}>
                {{ $company->company_name }}
              </option>
              @endforeach
            @endif
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
          <input class="Rectangle-29 @error('gst_no') is-invalid @enderror" name="gst_no" placeholder="e.g., 22ABCDE1234F1Z5" value="{{ old('gst_no', $quotationData['gst_no'] ?? '') }}" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 15)" maxlength="15" pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9A-Z]{1}[Z]{1}[0-9A-Z]{1}" title="Enter valid 15-character GST No. (e.g., 22ABCDE1234F1Z5)">
          @error('gst_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">PAN No:</label>
          <input class="Rectangle-29 @error('pan_no') is-invalid @enderror" name="pan_no" placeholder="e.g., ABCDE1234F" value="{{ old('pan_no') }}" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 10)" maxlength="10" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" title="Enter valid 10-character PAN No. (e.g., ABCDE1234F)">
          @error('pan_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>

      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Company Name: <span class="text-red-500">*</span></label>
          <input class="Rectangle-29 @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name', $quotationData['company_name'] ?? '') }}" placeholder="Enter company name" required>
          @error('company_name')
              <small class="hrp-error">{{ $message }}</small>
          @enderror
        </div>
        @php
          $selectedCompanyType = old('company_type', $quotationData['company_type'] ?? '');
        @endphp
        <div>
          <label class="hrp-label">Company Type</label>
          <select name="company_type" class="Rectangle-29-select">
            <option value="" {{ $selectedCompanyType ? '' : 'selected' }}>SELECT COMPANY TYPE</option>
            <option value="INFORMATION_TECHNOLOGY" {{ $selectedCompanyType == 'INFORMATION_TECHNOLOGY' ? 'selected' : '' }}>Information Technology (IT)</option>
            <option value="SOFTWARE_DEVELOPMENT" {{ $selectedCompanyType == 'SOFTWARE_DEVELOPMENT' ? 'selected' : '' }}>Software Development</option>
            <option value="HARDWARE_ELECTRONICS" {{ $selectedCompanyType == 'HARDWARE_ELECTRONICS' ? 'selected' : '' }}>Hardware & Electronics</option>
            <option value="TELECOMMUNICATIONS" {{ $selectedCompanyType == 'TELECOMMUNICATIONS' ? 'selected' : '' }}>Telecommunications</option>
            <option value="E_COMMERCE" {{ $selectedCompanyType == 'E_COMMERCE' ? 'selected' : '' }}>E-Commerce</option>
            <option value="MANUFACTURING" {{ $selectedCompanyType == 'MANUFACTURING' ? 'selected' : '' }}>Manufacturing</option>
            <option value="AUTOMOBILE" {{ $selectedCompanyType == 'AUTOMOBILE' ? 'selected' : '' }}>Automobile</option>
            <option value="AEROSPACE_DEFENSE" {{ $selectedCompanyType == 'AEROSPACE_DEFENSE' ? 'selected' : '' }}>Aerospace & Defense</option>
            <option value="CONSTRUCTION_INFRASTRUCTURE" {{ $selectedCompanyType == 'CONSTRUCTION_INFRASTRUCTURE' ? 'selected' : '' }}>Construction & Infrastructure</option>
            <option value="REAL_ESTATE" {{ $selectedCompanyType == 'REAL_ESTATE' ? 'selected' : '' }}>Real Estate</option>
            <option value="BANKING_FINANCIAL" {{ $selectedCompanyType == 'BANKING_FINANCIAL' ? 'selected' : '' }}>Banking & Financial Services</option>
            <option value="INSURANCE" {{ $selectedCompanyType == 'INSURANCE' ? 'selected' : '' }}>Insurance</option>
            <option value="INVESTMENT_ASSET" {{ $selectedCompanyType == 'INVESTMENT_ASSET' ? 'selected' : '' }}>Investment & Asset Management</option>
            <option value="HEALTHCARE" {{ $selectedCompanyType == 'HEALTHCARE' ? 'selected' : '' }}>Healthcare</option>
            <option value="PHARMACEUTICALS" {{ $selectedCompanyType == 'PHARMACEUTICALS' ? 'selected' : '' }}>Pharmaceuticals</option>
            <option value="BIOTECHNOLOGY" {{ $selectedCompanyType == 'BIOTECHNOLOGY' ? 'selected' : '' }}>Biotechnology</option>
            <option value="MEDICAL_DEVICES" {{ $selectedCompanyType == 'MEDICAL_DEVICES' ? 'selected' : '' }}>Medical Devices</option>
            <option value="EDUCATION_TRAINING" {{ $selectedCompanyType == 'EDUCATION_TRAINING' ? 'selected' : '' }}>Education & Training</option>
            <option value="RETAIL" {{ $selectedCompanyType == 'RETAIL' ? 'selected' : '' }}>Retail</option>
            <option value="WHOLESALE_DISTRIBUTION" {{ $selectedCompanyType == 'WHOLESALE_DISTRIBUTION' ? 'selected' : '' }}>Wholesale & Distribution</option>
            <option value="LOGISTICS_SUPPLY" {{ $selectedCompanyType == 'LOGISTICS_SUPPLY' ? 'selected' : '' }}>Logistics & Supply Chain</option>
            <option value="TRANSPORTATION" {{ $selectedCompanyType == 'TRANSPORTATION' ? 'selected' : '' }}>Transportation (Air, Road, Rail, Sea)</option>
            <option value="FOOD_BEVERAGE" {{ $selectedCompanyType == 'FOOD_BEVERAGE' ? 'selected' : '' }}>Food & Beverages</option>
            <option value="HOSPITALITY" {{ $selectedCompanyType == 'HOSPITALITY' ? 'selected' : '' }}>Hospitality</option>
            <option value="TOURISM_TRAVEL" {{ $selectedCompanyType == 'TOURISM_TRAVEL' ? 'selected' : '' }}>Tourism & Travel</option>
            <option value="MEDIA_ENTERTAINMENT" {{ $selectedCompanyType == 'MEDIA_ENTERTAINMENT' ? 'selected' : '' }}>Media & Entertainment</option>
            <option value="ADVERTISING_MARKETING" {{ $selectedCompanyType == 'ADVERTISING_MARKETING' ? 'selected' : '' }}>Advertising & Marketing</option>
            <option value="PUBLISHING" {{ $selectedCompanyType == 'PUBLISHING' ? 'selected' : '' }}>Publishing</option>
            <option value="OIL_GAS" {{ $selectedCompanyType == 'OIL_GAS' ? 'selected' : '' }}>Oil & Gas</option>
            <option value="MINING_METALS" {{ $selectedCompanyType == 'MINING_METALS' ? 'selected' : '' }}>Mining & Metals</option>
            <option value="CHEMICALS" {{ $selectedCompanyType == 'CHEMICALS' ? 'selected' : '' }}>Chemicals</option>
            <option value="ENERGY_POWER" {{ $selectedCompanyType == 'ENERGY_POWER' ? 'selected' : '' }}>Energy & Power</option>
            <option value="RENEWABLE_ENERGY" {{ $selectedCompanyType == 'RENEWABLE_ENERGY' ? 'selected' : '' }}>Renewable Energy (Solar, Wind)</option>
            <option value="AGRICULTURE" {{ $selectedCompanyType == 'AGRICULTURE' ? 'selected' : '' }}>Agriculture</option>
            <option value="ENVIRONMENTAL_SERVICES" {{ $selectedCompanyType == 'ENVIRONMENTAL_SERVICES' ? 'selected' : '' }}>Environmental Services</option>
            <option value="LEGAL_SERVICES" {{ $selectedCompanyType == 'LEGAL_SERVICES' ? 'selected' : '' }}>Legal Services</option>
            <option value="CONSULTING_ADVISORY" {{ $selectedCompanyType == 'CONSULTING_ADVISORY' ? 'selected' : '' }}>Consulting & Advisory</option>
            <option value="HUMAN_RESOURCES" {{ $selectedCompanyType == 'HUMAN_RESOURCES' ? 'selected' : '' }}>Human Resources Services</option>
            <option value="BPO_KPO" {{ $selectedCompanyType == 'BPO_KPO' ? 'selected' : '' }}>BPO / KPO</option>
            <option value="SECURITY_SERVICES" {{ $selectedCompanyType == 'SECURITY_SERVICES' ? 'selected' : '' }}>Security Services</option>
            <option value="FASHION_APPAREL" {{ $selectedCompanyType == 'FASHION_APPAREL' ? 'selected' : '' }}>Fashion & Apparel</option>
            <option value="TEXTILES" {{ $selectedCompanyType == 'TEXTILES' ? 'selected' : '' }}>Textiles</option>
            <option value="SPORTS_FITNESS" {{ $selectedCompanyType == 'SPORTS_FITNESS' ? 'selected' : '' }}>Sports & Fitness</option>
            <option value="NON_PROFIT_NGO" {{ $selectedCompanyType == 'NON_PROFIT_NGO' ? 'selected' : '' }}>Non-Profit / NGO</option>
            <option value="GOVERNMENT_PUBLIC" {{ $selectedCompanyType == 'GOVERNMENT_PUBLIC' ? 'selected' : '' }}>Government & Public Sector</option>
            <option value="OTHER" {{ $selectedCompanyType == 'OTHER' ? 'selected' : '' }}>Other</option>
          </select>
        </div>
      </div>

      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Nature Of Work:</label>
          <input class="Rectangle-29 @error('nature_of_work') is-invalid @enderror" name="nature_of_work" placeholder="Enter Nature" value="{{ old('nature_of_work') }}">
          @error('nature_of_work')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        @php
          $selectedState = old('state', $quotationData['state'] ?? '');
        @endphp
        <div>
          <label class="hrp-label">State:</label>
          <select class="Rectangle-29-select @error('state') is-invalid @enderror" name="state" id="state_select">
            <option value="" disabled {{ $selectedState ? '' : 'selected' }}>SELECT STATE</option>
            <option value="andhra_pradesh" {{ $selectedState == 'andhra_pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
            <option value="arunachal_pradesh" {{ $selectedState == 'arunachal_pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
            <option value="assam" {{ $selectedState == 'assam' ? 'selected' : '' }}>Assam</option>
            <option value="bihar" {{ $selectedState == 'bihar' ? 'selected' : '' }}>Bihar</option>
            <option value="chhattisgarh" {{ $selectedState == 'chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
            <option value="delhi" {{ $selectedState == 'delhi' ? 'selected' : '' }}>Delhi</option>
            <option value="goa" {{ $selectedState == 'goa' ? 'selected' : '' }}>Goa</option>
            <option value="gujarat" {{ $selectedState == 'gujarat' ? 'selected' : '' }}>Gujarat</option>
            <option value="haryana" {{ $selectedState == 'haryana' ? 'selected' : '' }}>Haryana</option>
            <option value="himachal_pradesh" {{ $selectedState == 'himachal_pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
            <option value="jammu_kashmir" {{ $selectedState == 'jammu_kashmir' ? 'selected' : '' }}>Jammu & Kashmir</option>
            <option value="jharkhand" {{ $selectedState == 'jharkhand' ? 'selected' : '' }}>Jharkhand</option>
            <option value="karnataka" {{ $selectedState == 'karnataka' ? 'selected' : '' }}>Karnataka</option>
            <option value="kerala" {{ $selectedState == 'kerala' ? 'selected' : '' }}>Kerala</option>
            <option value="ladakh" {{ $selectedState == 'ladakh' ? 'selected' : '' }}>Ladakh</option>
            <option value="madhya_pradesh" {{ $selectedState == 'madhya_pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
            <option value="maharashtra" {{ $selectedState == 'maharashtra' ? 'selected' : '' }}>Maharashtra</option>
            <option value="manipur" {{ $selectedState == 'manipur' ? 'selected' : '' }}>Manipur</option>
            <option value="meghalaya" {{ $selectedState == 'meghalaya' ? 'selected' : '' }}>Meghalaya</option>
            <option value="mizoram" {{ $selectedState == 'mizoram' ? 'selected' : '' }}>Mizoram</option>
            <option value="nagaland" {{ $selectedState == 'nagaland' ? 'selected' : '' }}>Nagaland</option>
            <option value="odisha" {{ $selectedState == 'odisha' ? 'selected' : '' }}>Odisha</option>
            <option value="punjab" {{ $selectedState == 'punjab' ? 'selected' : '' }}>Punjab</option>
            <option value="rajasthan" {{ $selectedState == 'rajasthan' ? 'selected' : '' }}>Rajasthan</option>
            <option value="sikkim" {{ $selectedState == 'sikkim' ? 'selected' : '' }}>Sikkim</option>
            <option value="tamil_nadu" {{ $selectedState == 'tamil_nadu' ? 'selected' : '' }}>Tamil Nadu</option>
            <option value="telangana" {{ $selectedState == 'telangana' ? 'selected' : '' }}>Telangana</option>
            <option value="tripura" {{ $selectedState == 'tripura' ? 'selected' : '' }}>Tripura</option>
            <option value="uttar_pradesh" {{ $selectedState == 'uttar_pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
            <option value="uttarakhand" {{ $selectedState == 'uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
            <option value="west_bengal" {{ $selectedState == 'west_bengal' ? 'selected' : '' }}>West Bengal</option>
            {{-- Union Territories --}}
            <option value="andaman_nicobar" {{ $selectedState == 'andaman_nicobar' ? 'selected' : '' }}>Andaman & Nicobar Islands</option>
            <option value="chandigarh" {{ $selectedState == 'chandigarh' ? 'selected' : '' }}>Chandigarh</option>
            <option value="dadra_nagar_haveli_daman_diu" {{ $selectedState == 'dadra_nagar_haveli_daman_diu' ? 'selected' : '' }}>Dadra & Nagar Haveli and Daman & Diu</option>
            <option value="lakshadweep" {{ $selectedState == 'lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
            <option value="puducherry" {{ $selectedState == 'puducherry' ? 'selected' : '' }}>Puducherry</option>
            <option value="other" {{ $selectedState == 'other' ? 'selected' : '' }}>Other</option>
          </select>
          <input type="text" name="state_other" id="state_other_input" class="Rectangle-29-select" placeholder="Enter State Name" value="{{ old('state_other', $quotationData['state_other'] ?? '') }}" style="display: {{ $selectedState == 'other' ? 'block' : 'none' }}; margin-top: 8px;">
          @error('state')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">City:</label>
          <select class="Rectangle-29-select @error('city') is-invalid @enderror" name="city" id="city_select">
            <option value="" disabled selected>SELECT STATE FIRST</option>
          </select>
          <input type="hidden" id="old_city" value="{{ old('city', $quotationData['city'] ?? '') }}">
          <input type="text" name="city_other" id="city_other_input" class="Rectangle-29-select" placeholder="Enter City Name" value="{{ old('city_other', $quotationData['city_other'] ?? '') }}" style="display: none; margin-top: 8px;">
          @error('city')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>

      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Scope of Work:</label>
          <textarea class="Rectangle-29 Rectangle-29-textarea @error('scope_of_work') is-invalid @enderror" name="scope_of_work" placeholder="Enter Scope" style="min-height:80px">{{ old('scope_of_work') }}</textarea>
          @error('scope_of_work')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Address:</label>
          <textarea class="Rectangle-29 Rectangle-29-textarea @error('address') is-invalid @enderror" name="address" placeholder="Enter Address" style="min-height:80px">{{ old('address', $quotationData['address'] ?? '') }}</textarea>
          @error('address')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>

      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Contact Person 1: <span class="text-red-500">*</span></label>
          <input class="Rectangle-29 @error('contact_person_1') is-invalid @enderror" name="contact_person_1" placeholder="Enter Contact Person Name" value="{{ old('contact_person_1', $quotationData['contact_person'] ?? '') }}" required>
          @error('contact_person_1')
              <small class="hrp-error">{{ $message }}</small>
          @enderror
        </div>
        <div>
          <label class="hrp-label">Gender 1:</label>
          <select class="Rectangle-29 Rectangle-29-select @error('contact_gender_1') is-invalid @enderror" name="contact_gender_1">
            <option value="">Select Gender</option>
            <option value="Male" {{ old('contact_gender_1') == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('contact_gender_1') == 'Female' ? 'selected' : '' }}>Female</option>
          </select>
          @error('contact_gender_1')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Contact Number 1 <span style="color: red;">*</span></label>
          <input
            class="hrp-input Rectangle-29"
            name="contact_number_1"
            type="tel"
            inputmode="numeric"
            pattern="\d{10}"
            maxlength="10"
            value="{{ old('contact_number_1', strip_country_code($quotationData['contact_number_1'] ?? '')) }}"
            placeholder="Enter 10 digit mobile number"
            required
          />
          @error('contact_number_1')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>

      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Position 1:</label>
          <input class="Rectangle-29 @error('position_1') is-invalid @enderror" name="position_1" placeholder="Enter Position" value="{{ old('position_1', $quotationData['contact_position'] ?? '') }}">
          @error('position_1')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Contract Copy:</label>
          <div class="upload-pill Rectangle-29 @error('contract_copy') is-invalid @enderror">
            <div class="choose">Choose File</div>
            <div class="filename" id="contractCopyName">No File Chosen</div>
            <input id="contractCopyInput" name="contract_copy" type="file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
          </div>
          @error('contract_copy')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>

      <div>
        <label class="hrp-label">Contract Short Details:</label>
        <textarea class="Rectangle-29 Rectangle-29-textarea @error('contract_details') is-invalid @enderror" name="contract_details" placeholder="Enter Your Details" style="height:58px;resize:none;">{{ old('contract_details') }}</textarea>
        @error('contract_details')<small class="hrp-error">{{ $message }}</small>@enderror
      </div>
      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Company Email: <span class="text-red-500">*</span></label>
          <div style="position: relative;">
            <input class="Rectangle-29 @error('company_email') is-invalid @enderror" type="email" name="company_email" id="company_email" value="{{ old('company_email', $quotationData['email'] ?? '') }}" placeholder="Add Mail-Id" required style="padding-right: 100px;">
            <button type="button" onclick="generateEmail()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
          </div>
          @error('company_email')
              <small class="hrp-error">{{ $message }}</small>
          @enderror
        </div>
        <div>
          <label class="hrp-label">Company Password: <span class="text-red-500 password-required-indicator">*</span></label>
          <div style="position: relative;">
            <input class="Rectangle-29 @error('company_password') is-invalid @enderror" type="text" name="company_password" id="company_password" placeholder="Auto-generated password" value="{{ old('company_password') }}" style="padding-right: 100px;">
            <button type="button" onclick="generatePassword()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #3b82f6; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
          </div>
          @error('company_password')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>

      {{-- <!-- Employee Credentials Section -->
      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Company Employee Email: <span style="color: #6b7280; font-size: 12px;">(Optional)</span></label>
          <div style="position: relative;">
            <input class="Rectangle-29 @error('company_employee_email') is-invalid @enderror" type="email" name="company_employee_email" id="company_employee_email" placeholder="Auto-generated email (optional)" value="{{ old('company_employee_email') }}" style="padding-right: 100px;">
            <button type="button" onclick="generateEmployeeEmail()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
          </div>
          @error('company_employee_email')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Company Employee Password: <span style="color: #6b7280; font-size: 12px;">(Optional)</span></label>
          <div style="position: relative;">
            <input class="Rectangle-29 @error('company_employee_password') is-invalid @enderror" type="text" name="company_employee_password" id="company_employee_password" placeholder="Auto-generated password (optional)" value="{{ old('company_employee_password') }}" style="padding-right: 100px;">
            <button type="button" onclick="generateEmployeePassword()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
          </div>
          @error('company_employee_password')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div> --}}
      <input type="hidden" name="contract_amount" id="hidden_contract_amount" value="{{ old('contract_amount') }}">
  </div>
</div>

<!-- Services Table -->
<div style="margin: 30px 0;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3 style="margin-left: 20px; font-size: 18px; font-weight: 600;">Services</h3>
    <div>
      <button type="button" class="inquiry-submit-btn premium-quotation-btn"
        style="background: #ffa500; margin-right: 10px; width: fit-content;">Premium Quotation</button>
      <button type="button" class="inquiry-submit-btn add-more-services-1" style="background: #28a745;">+ Add
        More</button>
    </div>
  </div>

  <!-- Premium Quotation Section -->

  <div id="premiumSection" class="Rectangle-30 hrp-compact" style="display: none;">
    <h3 style="margin: 0 0 20px 0; font-size: 18px; font-weight: 600;">Key Features Selection</h3>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 30px;">
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="sample_management" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Sample Management
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="user_friendly_interface" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        User-Friendly Interface
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="contact_management" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Contact Management
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="test_management" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Test Management
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="employee_management" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Employee Management
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="lead_opportunity_management" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Lead and Opportunity Management
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="data_integrity_security" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Data Integrity and Security
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="recruitment_onboarding" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Recruitment and Onboarding
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="sales_automation" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Sales Automation
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="reporting_analytics" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Reporting and Analytics
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="payroll_management" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Payroll Management
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="customer_service_management" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Customer Service Management
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="inventory_management" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Inventory Management
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="training_development" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Training and Development
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="reporting_analytics_2" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Reporting and Analytics
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="integration_capabilities_lab" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Integration Capabilities (Lab)
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="employee_self_service" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Employee Self-Service Portal
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="marketing_automation" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Marketing Automation
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="regulatory_compliance" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Regulatory Compliance
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="analytics_reporting" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Analytics and Reporting
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="integration_capabilities_crm" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Integration Capabilities (CRM)
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="workflow_automation" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Workflow Automation
      </label>
      <label style="display: flex; align-items: center; cursor: pointer; position: relative;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="integration_capabilities_hr" style="display: none;">
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: white; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: none;">✓</span>
        </div>
        Integration Capabilities (HR)
      </label>
    </div>

    <div style="margin-bottom: 20px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h4 style="margin: 0;">Basic Cost</h4>
        <button type="button" class="inquiry-submit-btn add-basic-cost"
          style="background: #28a745; padding: 5px 15px;">+ Add</button>
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
          <tr>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29"
                name="basic_cost[description][]" placeholder="Enter Description" style="border: none; background: transparent;"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 basic-quantity"
                type="number" min="0" step="1" name="basic_cost[quantity][]" placeholder="000" style="border: none; background: transparent;"
                oninput="calculateBasicTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 basic-rate"
                type="number" min="0" step="0.01" name="basic_cost[rate][]" placeholder="₹ 000" style="border: none; background: transparent;"
                oninput="calculateBasicTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 basic-total"
                type="number" min="0" step="0.01" name="basic_cost[total][]" placeholder="₹ 0000000" style="border: none; background: transparent;"
                readonly></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button"
                class="remove-basic-row"
                style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button>
            </td>
          </tr>
        </tbody>
      </table>

      <div id="basicCostTotal" style="font-weight: 600; text-align: right; margin-top: 10px;">Total: ₹0.00</div>
    </div>

    <div style="margin-bottom: 20px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h4 style="margin: 0;">Additional Cost</h4>
        <button type="button" class="inquiry-submit-btn add-additional-cost"
          style="background: #28a745; padding: 5px 15px;">+ Add</button>
      </div>

      <table id="additionalCostTable"
        style="width: 100%;">
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
          <tr>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29"
                name="additional_cost[description][]" placeholder="Enter Description"
                style="border: none; background: transparent;"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-quantity"
                type="number" min="0" step="1" name="additional_cost[quantity][]" placeholder="000" style="border: none; background: transparent;"
                oninput="calculateAdditionalTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-rate"
                type="number" min="0" step="0.01" name="additional_cost[rate][]" placeholder="₹ 000" style="border: none; background: transparent;"
                oninput="calculateAdditionalTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-total"
                type="number" min="0" step="0.01" name="additional_cost[total][]" placeholder="₹ 0000000" style="border: none; background: transparent;"
                readonly></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button"
                class="remove-additional-row"
                style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button>
            </td>
          </tr>
        </tbody>
      </table>

      <div id="additionalCostTotal" style="font-weight: 600; text-align: right; margin-top: 10px;">Total: ₹0.00</div>
    </div>

    <div>
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h4 style="margin: 0;">Annual Maintenance / Visiting / Manpower Support</h4>
        <button type="button" class="inquiry-submit-btn add-maintenance-cost"
          style="background: #28a745; padding: 5px 15px;">+ Add</button>
      </div>

      <table id="maintenanceCostTable"
        style="width: 100% ">
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
          <tr>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29"
                name="maintenance_cost[description][]" placeholder="Enter Description"
                style="border: none; background: transparent;"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-quantity"
                type="number" min="0" step="1" name="maintenance_cost[quantity][]" placeholder="000" style="border: none; background: transparent;"
                oninput="calculateMaintenanceTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-rate"
                type="number" min="0" step="0.01" name="maintenance_cost[rate][]" placeholder="₹ 000" style="border: none; background: transparent;"
                oninput="calculateMaintenanceTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-total"
                type="number" min="0" step="0.01" name="maintenance_cost[total][]" placeholder="₹ 0000000" style="border: none; background: transparent;"
                readonly></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button"
                class="remove-maintenance-row"
                style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button>
            </td>
          </tr>
        </tbody>
      </table>

      <div id="maintenanceCostTotal" style="font-weight: 600; text-align: right; margin-top: 10px;">Total: ₹0.00</div>
    </div>
  </div>










  <!-- First Services Table -->
  <div id="services-section" class="Rectangle-30 hrp-compact @if(session('error') && str_contains(session('error'), 'service')) service-error @endif" style="@if(session('error') && str_contains(session('error'), 'service')) border: 2px solid #dc3545; @endif">
    @if(session('error') && str_contains(session('error'), 'service'))
      <div style="background: #fee; border-left: 4px solid #dc3545; padding: 12px; margin-bottom: 15px; border-radius: 4px;">
        <small class="hrp-error" style="font-size: 14px; font-weight: 600;">{{ session('error') }}</small>
      </div>
    @endif
    <table class="services-table-1"
      style="width: 100%;">
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
        <tr>
          <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 @if(session('error') && str_contains(session('error'), 'service')) is-invalid @endif"
              name="services_1[description][]" placeholder="Enter Description" style="border: none; background: transparent;"></td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 quantity @if(session('error') && str_contains(session('error'), 'service')) is-invalid @endif"
              type="number" min="0" step="1" name="services_1[quantity][]" placeholder="Enter Quantity" style="border: none; background: transparent;" oninput="calculateRowTotal(this)"></td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 rate @if(session('error') && str_contains(session('error'), 'service')) is-invalid @endif"
              type="number" min="0" step="0.01" name="services_1[rate][]" placeholder="Enter Rate" style="border: none; background: transparent;" oninput="calculateRowTotal(this)"></td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 total"
              type="number" min="0" step="0.01" name="services_1[total][]" placeholder="Total Rate" style="border: none; background: transparent;" readonly></td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-row"
              style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
        </tr>
      </tbody>
    </table>
    @error('services_1')<small class="hrp-error">{{ $message }}</small>@enderror
    @error('services_1.description')<small class="hrp-error">Please fill all service descriptions</small>@enderror
    @error('services_1.quantity')<small class="hrp-error">Please fill all service quantities</small>@enderror
    @error('services_1.rate')<small class="hrp-error">Please fill all service rates</small>@enderror

    <!-- Contract Amount Section -->
    <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <label class="hrp-label" style="margin: 0; font-weight: 600;">Contract Amount :</label>
        <input id="contract_amount" class="Rectangle-29" type="number" min="0" step="0.01" name="contract_amount" placeholder="Total Rate" style="width: 200px;" readonly value="{{ old('contract_amount') }}">
      </div>
    </div>
  </div>
</div>

<!-- AMC Details -->
<div class="Rectangle-30 hrp-compact">

  <div class="hrp-form grid grid-cols-1 md:grid-cols-5 gap-4 md:gap-5" style="margin: 30px 0;">
    <div>
      <label class="hrp-label">AMC Start From:</label>
      <input type="text" class="Rectangle-29 date-picker" name="amc_start_date" placeholder="dd/mm/yyyy" value="{{ old('amc_start_date') }}" autocomplete="off">
    </div>
    <div>
      <label class="hrp-label">AMC Amount:</label>
      <input class="Rectangle-29" name="amc_amount" placeholder="Enter Amount" value="{{ old('amc_amount') }}">
    </div>
    <div>
      <label class="hrp-label">Project Start Date:</label>
      <input type="text" class="Rectangle-29 date-picker" name="project_start_date" placeholder="dd/mm/yyyy" value="{{ old('project_start_date') }}" autocomplete="off">
    </div>
    <div>
      <label class="hrp-label">Completion Time:</label>
      <input class="Rectangle-29" name="completion_time" placeholder="Enter Time" value="{{ old('completion_time') }}">
    </div>
    <div>
      <label class="hrp-label">Retention Time:</label>
      <input class="Rectangle-29" name="retention_time" placeholder="Enter Time" value="{{ old('retention_time') }}">
    </div>
       <div>
      <label class="hrp-label">Retention %:</label>
      <input class="Rectangle-29" id="retention_percent" name="retention_percent" type="number" min="0" max="100" step="0.1" placeholder="Enter %" oninput="calculateRetentionAmount()" value="{{ old('retention_percent') }}">
    </div>
    <div>
      <label class="hrp-label">Retention Amount:</label>
      <input id="retention_amount" class="Rectangle-29" name="retention_amount" placeholder="Enter Amount" readonly value="{{ old('retention_amount') }}">
    </div>
   
    <div>
      <label class="hrp-label">Tentative Complete Date:</label>
      <input type="text" class="Rectangle-29 date-picker" name="tentative_complete_date" placeholder="dd/mm/yyyy" value="{{ old('tentative_complete_date') }}" autocomplete="off">
    </div>
    <div></div>
    <div></div>
    <div></div>
  </div>
</div>
<!-- Second Services Table -->
<div style="margin: 30px 0;">
  <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
    <button type="button" class="inquiry-submit-btn add-more-services-2" style="background: #28a745;">+ Add
      More</button>
  </div>
  <div class="Rectangle-30 hrp-compact">

    <table class="services-table-2"
      style="width: 100%;">
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
        <tr>
          <td style="padding: 12px; border-bottom: 1px solid #eee;"><select class="Rectangle-29-select"
              name="services_2[description][]" style="border: none; background: transparent;">
              <option value="">Select Service</option>
              <option value="ADVANCE">ADVANCE</option>
              <option value="ON INSTALLATION">ON INSTALLATION</option>
              <option value="COMPLETION">COMPLETION</option>
              <option value="RETENTION">RETENTION</option>
            </select></td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 quantity"
              type="number" min="0" step="1" name="services_2[quantity][]" placeholder="Enter Quantity" style="border: none; background: transparent;" oninput="calculateRowTotal(this)">
          </td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 rate"
              type="number" min="0" step="0.01" name="services_2[rate][]" placeholder="Enter Rate" style="border: none; background: transparent;" oninput="calculateRowTotal(this)"></td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 total"
              type="number" min="0" step="0.01" name="services_2[total][]" placeholder="Total Amount" style="border: none; background: transparent;" readonly></td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 completion-percent"
              type="number" min="0" max="100" step="1" name="services_2[completion_percent][]" placeholder="Enter %"
              style="border: none; background: transparent;" oninput="calculatePercentageAmount(this)"></td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29"
              name="services_2[completion_terms][]" placeholder="Enter Terms"
              style="border: none; background: transparent;"></td>
          <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-row"
              style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5" style="margin-top: 20px;">
      <div>
        <label class="hrp-label">Services Total Amount:</label>
        <input type="text" class="Rectangle-29" id="services_total_amount" name="services_total_amount" placeholder="Auto-calculated" readonly value="{{ old('services_total_amount') }}" style="background-color: #f3f4f6; font-weight: 600;">
      </div>
      <div></div>
    </div>
  </div>
</div>
<!-- Terms & Conditions -->
<div class="Rectangle-30 hrp-compact">

  <div class="hrp-form" style="margin: 30px 0;">
    <!-- Custom Terms & Conditions and Prepared By Section -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
      <h4 style="font-size: 16px; font-weight: 600; color: #1e293b; margin: 0 0 20px 0; display: flex; align-items: center; gap: 8px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
          <polyline points="14,2 14,8 20,8"></polyline>
          <line x1="16" y1="13" x2="8" y2="13"></line>
          <line x1="16" y1="17" x2="8" y2="17"></line>
          <polyline points="10,9 9,9 8,9"></polyline>
        </svg>
        Additional Information
      </h4>
      
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Column -->
        <div>
          <div style="margin-bottom: 20px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">
              Custom Terms & Conditions
            </label>
            
            <!-- Terms Input Area -->
            <div style="border: 1px solid #d1d5db; border-radius: 8px; overflow: hidden; background: white;">
              <div style="background: #f9fafb; padding: 12px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: between; align-items: center;">
                <span style="font-size: 13px; font-weight: 500; color: #6b7280;">Terms & Conditions Editor</span>
                <div style="display: flex; gap: 8px;">
                  <button type="button" onclick="addNewTerm()" style="padding: 4px 8px; background: #3b82f6; color: white; border: none; border-radius: 4px; font-size: 11px; cursor: pointer;">+ Add Term</button>
                  <button type="button" onclick="togglePreview()" style="padding: 4px 8px; background: #10b981; color: white; border: none; border-radius: 4px; font-size: 11px; cursor: pointer;">👁 Preview</button>
                </div>
              </div>
              
              <!-- Input Mode -->
              <div id="termsInputMode" style="padding: 0;">
                <textarea 
                  name="custom_terms_text" 
                  id="custom_terms_text" 
                  class="hrp-input" 
                  rows="6" 
                  placeholder="Enter custom terms and conditions (one per line)&#10;Example:&#10;• Payment terms: 30 days from invoice date&#10;• Delivery within 15 working days&#10;• Warranty: 12 months from delivery date" 
                  style="width: 100%; border: none; resize: vertical; font-size: 14px; line-height: 1.6; padding: 16px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"
                  oninput="updatePreview()">{{ old('custom_terms_text', isset($quotation) && is_array($quotation->custom_terms_and_conditions) ? implode("\n", $quotation->custom_terms_and_conditions) : '') }}</textarea>
              </div>
              
              <!-- Preview Mode -->
              <div id="termsPreviewMode" style="display: none; padding: 16px; background: #fefefe; min-height: 120px;">
                <div id="termsPreviewContent" style="font-size: 14px; line-height: 1.6; color: #374151;">
                  <!-- Preview content will be populated by JavaScript -->
                </div>
              </div>
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px;">
              <small class="text-gray-500" style="font-size: 12px;">Enter each term on a new line. Use • or - for bullet points</small>
              <small id="termCount" style="font-size: 11px; color: #6b7280; background: #f3f4f6; padding: 2px 6px; border-radius: 4px;">0 terms</small>
            </div>
          </div>
          
          <div style="margin-bottom: 20px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">
              Mobile No.
            </label>
            <input
              class="hrp-input Rectangle-29"
              name="mobile_no"
              type="tel"
              inputmode="numeric"
              pattern="\d{10}"
              maxlength="10"
              value="{{ old('mobile_no') }}"
              placeholder="Enter 10 digit mobile number"
              style="font-size: 14px; line-height: 1.5;"
            />
            @error('mobile_no')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
        </div>
        
        <!-- Right Column -->
        <div>
          <div style="margin-bottom: 20px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">
              Prepared By
            </label>
            <input 
              class="hrp-input Rectangle-29" 
              name="prepared_by" 
              placeholder="Enter Name" 
              value="{{ old('prepared_by') }}"
              style="font-size: 14px; line-height: 1.5;">
            @error('prepared_by')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 20px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">
              Prepared By Gender
            </label>
            <div class="relative">
              <select 
                class="hrp-input Rectangle-29 @error('prepared_by_gender') is-invalid @enderror" 
                name="prepared_by_gender"
                style="padding-right: 32px; appearance: none; background-repeat: no-repeat; background-position: right 12px center; background-size: 16px; cursor: pointer; width: 100%; font-size: 14px; line-height: 1.5; background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%236b7280\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpolyline points=\'6 9 12 15 18 9\'/%3E%3C/svg%3E');">
                <option value="">Select Gender</option>
                <option value="Male" {{ old('prepared_by_gender') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('prepared_by_gender') == 'Female' ? 'selected' : '' }}>Female</option>
              </select>
            </div>
            @error('prepared_by_gender')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 20px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">
              Company Name
            </label>
            <input 
              class="hrp-input Rectangle-29" 
              name="footer_company_name" 
              value="{{ old('footer_company_name', 'CHITRI ENLARGE SOFT IT HUB PVT LTD (CEIHPL)') }}"
              style="font-size: 14px; line-height: 1.5;">
            @error('footer_company_name')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Standard Terms -->
  <div style="margin: 30px 0;">
    <div id="standardTermsList">
      <!-- Terms will be populated from custom terms input -->
    </div>
  </div>
</div>

<div class="hrp-actions" style="margin-top: 40px;">
  <button type="button" onclick="debugFormSubmission();" class="hrp-btn hrp-btn-primary">Add Quotation</button>
</div>

<!-- Hidden inputs for subtotals -->
<input type="hidden" name="basic_subtotal" id="hidden_basic_subtotal" value="0">
<input type="hidden" name="additional_subtotal" id="hidden_additional_subtotal" value="0">
<input type="hidden" name="maintenance_subtotal" id="hidden_maintenance_subtotal" value="0">

    </form>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
//
// ---------------------------------------------------------------------
// STATE-CITY DATA - Using stateCityData from state-city-dropdown.js
// ---------------------------------------------------------------------
//

// State-City data and functions are loaded from state-city-dropdown.js (included in layout)
// No need to declare stateCityData, toggleOtherInput, or populateCities here

// Page-specific initialization
document.addEventListener('DOMContentLoaded', function() {
    // Scroll to services section if there's a service validation error
    const servicesSection = document.getElementById('services-section');
    if (servicesSection && servicesSection.classList.contains('service-error')) {
        setTimeout(function() {
            servicesSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
            const firstInput = servicesSection.querySelector('input[name="services_1[description][]"]');
            if (firstInput) {
                firstInput.focus();
            }
        }, 500);
    }

    // Scroll to first validation error field
    const firstErrorField = document.querySelector('.is-invalid');
    if (firstErrorField) {
        setTimeout(function() {
            firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstErrorField.focus();
        }, 300);
    }
});

//
// ---------------------------------------------------------------------
// GLOBAL CALCULATION FUNCTIONS
// ---------------------------------------------------------------------
//

function calculateRowTotal(input) {
    const row = input.closest('tr');
    const quantity = parseFloat(row.querySelector('.quantity')?.value) || 0;
    const rate = parseFloat(row.querySelector('.rate')?.value) || 0;
    const total = quantity * rate;
    row.querySelector('.total').value = total.toFixed(2);
    
    // If this is services_2 table and has completion percentage, calculate percentage amount
    const percentInput = row.querySelector('.completion-percent');
    if (percentInput && percentInput.value) {
        calculatePercentageAmount(percentInput);
    }
    
    calculateContractAmount();
    calculateServicesTotalAmount();
}

function calculateServicesTotalAmount() {
    let servicesTotal = 0;
    
    // Sum ONLY totals from services_2 table (Service Terms with Completion %)
    document.querySelectorAll('.services-table-2 .total').forEach(input => {
        servicesTotal += parseFloat(input.value) || 0;
    });
    
    // Update the Services Total Amount field
    const servicesTotalField = document.getElementById('services_total_amount');
    if (servicesTotalField) {
        servicesTotalField.value = '₹ ' + servicesTotal.toFixed(2);
    }
}

function calculatePercentageAmount(input) {
    const row = input.closest('tr');
    const percentage = parseFloat(input.value) || 0;
    const quantityInput = row.querySelector('.quantity');
    const rateInput = row.querySelector('.rate');
    const totalInput = row.querySelector('.total');
    
    // Get the quantity (if not set, default to 1)
    const quantity = parseFloat(quantityInput?.value) || 1;
    
    // Get contract amount for percentage calculation
    const contractAmount = parseFloat(document.getElementById('contract_amount')?.value) || 0;
    
    if (percentage > 0 && contractAmount > 0) {
        // Calculate percentage of contract amount
        const percentageAmount = (contractAmount * percentage) / 100;
        
        // Calculate rate per quantity
        const ratePerUnit = percentageAmount / quantity;
        
        // Update rate and total
        if (rateInput) rateInput.value = ratePerUnit.toFixed(2);
        if (totalInput) totalInput.value = percentageAmount.toFixed(2);
    } else if (percentage === 0) {
        // Reset if percentage is cleared
        if (rateInput) rateInput.value = '';
        if (totalInput) totalInput.value = '';
    }
}

function calculateContractAmount() {
    // Check if premium section is visible
    const premiumSection = document.getElementById('premiumSection');
    if (premiumSection && premiumSection.style.display === 'block') {
        updateContractAmountWithPremium();
    } else {
        let total = 0;
        document.querySelectorAll('.services-table-1 .total').forEach(i => total += parseFloat(i.value) || 0);
        document.getElementById('contract_amount').value = total.toFixed(2);
        document.getElementById('hidden_contract_amount').value = total.toFixed(2);
        
        // Recalculate all percentage-based amounts in services_2
        document.querySelectorAll('.services-table-2 .completion-percent').forEach(input => {
            if (input.value) calculatePercentageAmount(input);
        });
        
        // Recalculate retention amount
        calculateRetentionAmount();
    }
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
    updateContractAmountWithPremium();
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
    updateContractAmountWithPremium();
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
    updateContractAmountWithPremium();
}

function calculateTotalPremiumCost() {
    let basicTotal = 0;
    let additionalTotal = 0;
    let maintenanceTotal = 0;
    
    document.querySelectorAll('.basic-total').forEach(i => basicTotal += parseFloat(i.value) || 0);
    document.querySelectorAll('.additional-total').forEach(i => additionalTotal += parseFloat(i.value) || 0);
    document.querySelectorAll('.maintenance-total').forEach(i => maintenanceTotal += parseFloat(i.value) || 0);
    
    return basicTotal + additionalTotal + maintenanceTotal;
}

function updateContractAmountWithPremium() {
    let baseTotal = 0;
    document.querySelectorAll('.services-table-1 .total').forEach(i => baseTotal += parseFloat(i.value) || 0);
    
    const premiumTotal = calculateTotalPremiumCost();
    const finalTotal = baseTotal + premiumTotal;
    
    document.getElementById('contract_amount').value = finalTotal.toFixed(2);
    document.getElementById('hidden_contract_amount').value = finalTotal.toFixed(2);
    
    // Recalculate percentage-based amounts
    document.querySelectorAll('.services-table-2 .completion-percent').forEach(input => {
        if (input.value) calculatePercentageAmount(input);
    });
    
    // Recalculate retention amount
    calculateRetentionAmount();
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

//
// ---------------------------------------------------------------------
// CUSTOMER TYPE & CUSTOMER DETAILS HANDLING
// ---------------------------------------------------------------------
//

function toggleCustomerFields(type) {
    const field = document.getElementById('existing_customer_field');
    if (field) field.classList.toggle('hidden', type !== 'existing');
    
    // Toggle password field requirement based on customer type
    const passwordField = document.getElementById('company_password');
    const passwordIndicator = document.querySelector('.password-required-indicator');
    
    if (passwordField) {
        if (type === 'new') {
            passwordField.setAttribute('required', 'required');
            if (passwordIndicator) passwordIndicator.style.display = 'inline';
        } else {
            passwordField.removeAttribute('required');
            if (passwordIndicator) passwordIndicator.style.display = 'none';
        }
    }
    
    // Toggle required attribute and visual indicator for city and state
    const citySelect = document.getElementById('city_select');
    const stateSelect = document.getElementById('state_select');
    const cityIndicator = document.querySelector('.city-required-indicator');
    const stateIndicator = document.querySelector('.state-required-indicator');
    
    if (type === 'new') {
        if (citySelect) citySelect.setAttribute('required', 'required');
        if (stateSelect) stateSelect.setAttribute('required', 'required');
        if (cityIndicator) cityIndicator.style.display = 'inline';
        if (stateIndicator) stateIndicator.style.display = 'inline';
    } else {
        if (citySelect) citySelect.removeAttribute('required');
        if (stateSelect) stateSelect.removeAttribute('required');
        if (cityIndicator) cityIndicator.style.display = 'none';
        if (stateIndicator) stateIndicator.style.display = 'none';
    }
}

function clearCustomerFields() {
    const fields = [
        'gst_no','pan_no','company_name','company_type','city','address',
        'contact_person_1','contact_number_1','position_1','company_email',
        'nature_of_work','scope_of_work'
    ];

    fields.forEach(f => {
        const el = document.querySelector(`[name="${f}"]`);
        if (el) el.value = '';
    });
}

//
// MAIN AJAX FETCH COMPANY DETAILS
//
async function fetchCustomerDetails(companyId) {
    if (!companyId) return;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const baseUrl = '{{ url('/') }}';

    // 1st API
    let response = await fetch(`${baseUrl}/quotations/company/${companyId}`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    });

    // If 404, try alternative API
    if (response.status === 404) {
        response = await fetch(`${baseUrl}/company/${companyId}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        });
    }

    const data = await response.json().catch(() => ({}));
    if (!data.success || !data.data) {
        toastr.error('No company data found');
        return;
    }

    const form = document.getElementById('quotationForm');
    const company = data.data;

    // STATE SPECIAL HANDLING
    const stateSelect = form.querySelector('select[name="state"]');
    if (stateSelect && company.state) {
        const value = company.state.trim().toLowerCase().replace(/\s+/g, '_');
        let found = false;

        // First try exact match with option value
        [...stateSelect.options].forEach((opt, i) => {
            if (opt.value.toLowerCase() === value) {
                stateSelect.selectedIndex = i;
                found = true;
            }
        });

        // If not found, try matching with option text
        if (!found) {
            [...stateSelect.options].forEach((opt, i) => {
                if (opt.text.trim().toLowerCase().replace(/\s+/g, '_') === value) {
                    stateSelect.selectedIndex = i;
                    found = true;
                }
            });
        }

        // If still not found, try partial match
        if (!found) {
            [...stateSelect.options].forEach((opt, i) => {
                if (opt.text.toLowerCase().includes(value.replace(/_/g, ' ')) || value.replace(/_/g, ' ').includes(opt.text.toLowerCase())) {
                    stateSelect.selectedIndex = i;
                    found = true;
                }
            });
        }
        
        // Populate cities based on selected state
        if (stateSelect.value) {
            populateCities(stateSelect.value, company.city ? company.city.trim().toLowerCase().replace(/\s+/g, '_') : null);
        }
    }

    // CITY SPECIAL HANDLING - Now handled by populateCities function above
    // If state was not set but city exists, try to find and set it
    const citySelect = form.querySelector('select[name="city"]');
    if (citySelect && company.city && !stateSelect?.value) {
        const value = company.city.trim().toLowerCase().replace(/\s+/g, '_');
        let found = false;

        [...citySelect.options].forEach((opt, i) => {
            if (opt.value.toLowerCase() === value || opt.text.trim().toLowerCase() === value.replace(/_/g, ' ')) {
                citySelect.selectedIndex = i;
                found = true;
            }
        });

        if (!found) {
            [...citySelect.options].forEach((opt, i) => {
                if (opt.text.toLowerCase().includes(value.replace(/_/g, ' '))) {
                    citySelect.selectedIndex = i;
                    found = true;
                }
            });
        }
    }

    // Set other fields
    const fields = {
        company_name: company.company_name,
        company_type: company.company_type,
        gst_no: company.gst_no,
        pan_no: company.pan_no,
        address: company.address || company.company_address,
        company_email: company.company_email,
        company_employee_email: company.company_employee_email || '',
        nature_of_work: company.nature_of_work || company.other_details,
        contact_person_1: company.contact_person_1 || company.contact_person_name,
        contact_number_1: company.contact_number_1 || company.contact_person_mobile,
        position_1: company.position_1 || company.contact_person_position
    };

    Object.entries(fields).forEach(([field, value]) => {
        const el = form.querySelector(`[name="${field}"]`);
        if (el) el.value = value || '';
    });
    
    // For existing customers, clear and disable password field requirement
    const passwordField = form.querySelector('[name="company_password"]');
    if (passwordField) {
        passwordField.value = ''; // Clear password field for existing customers
        passwordField.removeAttribute('required');
        passwordField.placeholder = 'Password already set for this company';
    }
}

//
// ---------------------------------------------------------------------
// DOM READY – ALL EVENT BINDINGS
// ---------------------------------------------------------------------
//

// Add form submission handler to filter out empty service rows
function filterEmptyServiceRows() {
    // Process services_1 table
    const services1Rows = document.querySelectorAll('.services-table-1 tbody tr');
    services1Rows.forEach((row) => {
        const description = row.querySelector('input[name="services_1[description][]"]')?.value.trim();
        const quantity = row.querySelector('input[name="services_1[quantity][]"]')?.value.trim();
        const rate = row.querySelector('input[name="services_1[rate][]"]')?.value.trim();
        
        // If all fields are empty, remove the row
        if (!description && (!quantity || quantity === '0') && (!rate || rate === '0')) {
            row.remove();
        }
    });

    // Process services_2 table
    const services2Rows = document.querySelectorAll('.services-table-2 tbody tr');
    services2Rows.forEach((row) => {
        const description = row.querySelector('select[name="services_2[description][]"]')?.value;
        const quantity = row.querySelector('input[name="services_2[quantity][]"]')?.value.trim();
        const rate = row.querySelector('input[name="services_2[rate][]"]')?.value.trim();
        
        // If all fields are empty, remove the row
        if (!description && (!quantity || quantity === '0') && (!rate || rate === '0')) {
            row.remove();
        }
    });
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
                contractCopyName.textContent = 'No File Chosen';
            }
        });
    }

    //
    // REPOPULATE OLD DATA FOR REPEATERS
    //
    @if(old('services_1'))
        const services1Data = @json(old('services_1'));
        if(services1Data && services1Data.description) {
            const tbody1 = document.querySelector('.services-table-1 tbody');
            tbody1.innerHTML = '';
            for(let i = 0; i < services1Data.description.length; i++) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td style="padding: 12px; border-bottom: 1px solid #eee;">
                        <input class="Rectangle-29" name="services_1[description][]" placeholder="Enter Description" style="border: none; background: transparent; width: 100%;" value="${services1Data.description[i] || ''}">
                    </td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;">
                        <input class="Rectangle-29 quantity" type="number" min="0" step="1" name="services_1[quantity][]" placeholder="Enter Quantity" style="border: none; background: transparent; width: 100%;" oninput="calculateRowTotal(this)" value="${services1Data.quantity[i] || ''}">
                    </td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;">
                        <input class="Rectangle-29 rate" type="number" min="0" step="0.01" name="services_1[rate][]" placeholder="Enter Rate" style="border: none; background: transparent; width: 100%;" oninput="calculateRowTotal(this)" value="${services1Data.rate[i] || ''}">
                    </td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;">
                        <input class="Rectangle-29 total" type="number" min="0" step="0.01" name="services_1[total][]" placeholder="Total Rate" style="border: none; background: transparent; width: 100%;" readonly value="${services1Data.total[i] || ''}">
                    </td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: center;">
                        <button type="button" class="remove-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button>
                    </td>
                `;
                tbody1.appendChild(row);
            }
        }
    @endif

    @if(old('services_2'))
        const services2Data = @json(old('services_2'));
        if(services2Data && services2Data.description) {
            const tbody2 = document.querySelector('.services-table-2 tbody');
            tbody2.innerHTML = '';
            for(let i = 0; i < services2Data.description.length; i++) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td style="padding: 12px; border-bottom: 1px solid #eee;">
                        <select class="Rectangle-29-select" name="services_2[description][]" style="border: none; background: transparent; width: 100%;">
                            <option value="">Select Service</option>
                            <option value="ADVANCE" ${services2Data.description[i] === 'ADVANCE' ? 'selected' : ''}>ADVANCE</option>
                            <option value="ON INSTALLATION" ${services2Data.description[i] === 'ON INSTALLATION' ? 'selected' : ''}>ON INSTALLATION</option>
                            <option value="COMPLETION" ${services2Data.description[i] === 'COMPLETION' ? 'selected' : ''}>COMPLETION</option>
                            <option value="RETENTION" ${services2Data.description[i] === 'RETENTION' ? 'selected' : ''}>RETENTION</option>
                        </select>
                    </td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;">
                        <input class="Rectangle-29 quantity" type="number" min="0" step="1" name="services_2[quantity][]" placeholder="Enter Quantity" style="border: none; background: transparent; width: 100%;" oninput="calculateRowTotal(this)" value="${services2Data.quantity[i] || ''}">
                    </td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;">
                        <input class="Rectangle-29 rate" type="number" min="0" step="0.01" name="services_2[rate][]" placeholder="Enter Rate" style="border: none; background: transparent; width: 100%;" oninput="calculateRowTotal(this)" value="${services2Data.rate[i] || ''}">
                    </td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;">
                        <input class="Rectangle-29 total" type="number" min="0" step="0.01" name="services_2[total][]" placeholder="Total Amount" style="border: none; background: transparent; width: 100%;" readonly value="${services2Data.total[i] || ''}">
                    </td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;">
                        <input class="Rectangle-29 completion-percent" type="number" min="0" max="100" step="1" name="services_2[completion_percent][]" placeholder="Enter %" style="border: none; background: transparent; width: 100%;" oninput="calculatePercentageAmount(this)" value="${services2Data.completion_percent[i] || ''}">
                    </td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;">
                        <input class="Rectangle-29" name="services_2[completion_terms][]" placeholder="Enter Terms" style="border: none; background: transparent; width: 100%;" value="${services2Data.completion_terms[i] || ''}">
                    </td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: center;">
                        <button type="button" class="remove-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button>
                    </td>
                `;
                tbody2.appendChild(row);
            }
        }
    @endif

    @if(old('basic_cost'))
        const basicCostData = @json(old('basic_cost'));
        if(basicCostData && basicCostData.description) {
            const tbodyBasic = document.querySelector('#basicCostTable tbody');
            tbodyBasic.innerHTML = '';
            for(let i = 0; i < basicCostData.description.length; i++) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29" name="basic_cost[description][]" placeholder="Enter Description" style="border: none; background: transparent;" value="${basicCostData.description[i] || ''}"></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 basic-quantity" type="number" min="0" step="1" name="basic_cost[quantity][]" placeholder="000" style="border: none; background: transparent;" oninput="calculateBasicTotal(this)" value="${basicCostData.quantity[i] || ''}"></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 basic-rate" type="number" min="0" step="0.01" name="basic_cost[rate][]" placeholder="₹ 000" style="border: none; background: transparent;" oninput="calculateBasicTotal(this)" value="${basicCostData.rate[i] || ''}"></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 basic-total" type="number" min="0" step="0.01" name="basic_cost[total][]" placeholder="₹ 0000000" style="border: none; background: transparent;" readonly value="${basicCostData.total[i] || ''}"></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-basic-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
                `;
                tbodyBasic.appendChild(row);
            }
        }
    @endif

    @if(old('additional_cost'))
        const additionalCostData = @json(old('additional_cost'));
        if(additionalCostData && additionalCostData.description) {
            const tbodyAdditional = document.querySelector('#additionalCostTable tbody');
            tbodyAdditional.innerHTML = '';
            for(let i = 0; i < additionalCostData.description.length; i++) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29" name="additional_cost[description][]" placeholder="Enter Description" style="border: none; background: transparent;" value="${additionalCostData.description[i] || ''}"></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-quantity" type="number" min="0" step="1" name="additional_cost[quantity][]" placeholder="000" style="border: none; background: transparent;" oninput="calculateAdditionalTotal(this)" value="${additionalCostData.quantity[i] || ''}"></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-rate" type="number" min="0" step="0.01" name="additional_cost[rate][]" placeholder="₹ 000" style="border: none; background: transparent;" oninput="calculateAdditionalTotal(this)" value="${additionalCostData.rate[i] || ''}"></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-total" type="number" min="0" step="0.01" name="additional_cost[total][]" placeholder="₹ 0000000" style="border: none; background: transparent;" readonly value="${additionalCostData.total[i] || ''}"></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-additional-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
                `;
                tbodyAdditional.appendChild(row);
            }
        }
    @endif

    @if(old('maintenance_cost'))
        const maintenanceCostData = @json(old('maintenance_cost'));
        if(maintenanceCostData && maintenanceCostData.description) {
            const tbodyMaintenance = document.querySelector('#maintenanceCostTable tbody');
            tbodyMaintenance.innerHTML = '';
            for(let i = 0; i < maintenanceCostData.description.length; i++) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29" name="maintenance_cost[description][]" placeholder="Enter Description" style="border: none; background: transparent;" value="${maintenanceCostData.description[i] || ''}"></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-quantity" type="number" min="0" step="1" name="maintenance_cost[quantity][]" placeholder="000" style="border: none; background: transparent;" oninput="calculateMaintenanceTotal(this)" value="${maintenanceCostData.quantity[i] || ''}"></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-rate" type="number" min="0" step="0.01" name="maintenance_cost[rate][]" placeholder="₹ 000" style="border: none; background: transparent;" oninput="calculateMaintenanceTotal(this)" value="${maintenanceCostData.rate[i] || ''}"></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-total" type="number" min="0" step="0.01" name="maintenance_cost[total][]" placeholder="₹ 0000000" style="border: none; background: transparent;" readonly value="${maintenanceCostData.total[i] || ''}"></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-maintenance-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
                `;
                tbodyMaintenance.appendChild(row);
            }
        }
    @endif

    // Restore selected features
    @if(old('features'))
        const selectedFeatures = @json(old('features'));
        selectedFeatures.forEach(feature => {
            const checkbox = document.querySelector(`input[value="${feature}"]`);
            if(checkbox) {
                checkbox.checked = true;
                const box = checkbox.closest('.custom-checkbox').querySelector('.checkbox-box');
                const mark = checkbox.closest('.custom-checkbox').querySelector('.checkmark');
                box.style.background = '#000';
                mark.style.display = 'block';
            }
        });
    @endif

    // Recalculate all totals after repopulating data
    setTimeout(() => {
        calculateContractAmount();
        calculateBasicCostTotal();
        calculateAdditionalCostTotal();
        calculateMaintenanceCostTotal();
        calculateRetentionAmount();
    }, 100);

    //
    // CUSTOMER TYPE CHANGE
    //
    const customerType = document.getElementById('customer_type');
    const customerSelect = document.getElementById('customer_id');

    if (customerType) {
        toggleCustomerFields(customerType.value);

        customerType.addEventListener('change', function() {
            toggleCustomerFields(this.value);
            if (this.value !== 'existing') clearCustomerFields();
        });
    }

    if (customerSelect) {
        customerSelect.addEventListener('change', function() {
            if (this.value && customerType.value === 'existing') {
                fetchCustomerDetails(this.value);
            }
        });
    }

    //
    // ADD MORE ROW – SERVICES 1
    //
    document.querySelector('.add-more-services-1')?.addEventListener('click', function() {
        const tbody = document.querySelector('.services-table-1 tbody');
        const row = document.createElement('tr');

        row.innerHTML = `
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29" name="services_1[description][]" placeholder="Enter Description" style="border: none; background: transparent; width: 100%;">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29 quantity" type="number" min="0" step="1" name="services_1[quantity][]" placeholder="Enter Quantity" style="border: none; background: transparent; width: 100%;" oninput="calculateRowTotal(this)">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29 rate" type="number" min="0" step="0.01" name="services_1[rate][]" placeholder="Enter Rate" style="border: none; background: transparent; width: 100%;" oninput="calculateRowTotal(this)">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29 total" type="number" min="0" step="0.01" name="services_1[total][]" placeholder="Total Rate" style="border: none; background: transparent; width: 100%;" readonly>
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: center;">
                <button type="button" class="remove-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; padding: 0; font-size: 16px; line-height: 1; cursor: pointer;">×</button>
            </td>
        `;
        tbody.appendChild(row);
    });

    //
    // ADD MORE ROW – SERVICES 2
    //
    document.querySelector('.add-more-services-2')?.addEventListener('click', function() {
        const tbody = document.querySelector('.services-table-2 tbody');
        const row = document.createElement('tr');

        // Create elements individually to ensure proper form field creation
        const td1 = document.createElement('td');
        td1.style.cssText = 'padding: 12px; border-bottom: 1px solid #eee;';
        const select = document.createElement('select');
        select.className = 'Rectangle-29-select';
        select.name = 'services_2[description][]';
        select.style.cssText = 'border: none; background: transparent; width: 100%;';
        select.innerHTML = `
            <option value="">Select Service</option>
            <option value="ADVANCE">ADVANCE</option>
            <option value="ON INSTALLATION">ON INSTALLATION</option>
            <option value="COMPLETION">COMPLETION</option>
            <option value="RETENTION">RETENTION</option>
        `;
        td1.appendChild(select);

        const td2 = document.createElement('td');
        td2.style.cssText = 'padding: 12px; border-bottom: 1px solid #eee;';
        const qtyInput = document.createElement('input');
        qtyInput.className = 'Rectangle-29 quantity';
        qtyInput.type = 'number';
        qtyInput.min = '0';
        qtyInput.step = '1';
        qtyInput.name = 'services_2[quantity][]';
        qtyInput.placeholder = 'Enter Quantity';
        qtyInput.style.cssText = 'border: none; background: transparent; width: 100%;';
        qtyInput.oninput = function() { calculateRowTotal(this); };
        td2.appendChild(qtyInput);

        const td3 = document.createElement('td');
        td3.style.cssText = 'padding: 12px; border-bottom: 1px solid #eee;';
        const rateInput = document.createElement('input');
        rateInput.className = 'Rectangle-29 rate';
        rateInput.type = 'number';
        rateInput.min = '0';
        rateInput.step = '0.01';
        rateInput.name = 'services_2[rate][]';
        rateInput.placeholder = 'Enter Rate';
        rateInput.style.cssText = 'border: none; background: transparent; width: 100%;';
        rateInput.oninput = function() { calculateRowTotal(this); };
        td3.appendChild(rateInput);

        const td4 = document.createElement('td');
        td4.style.cssText = 'padding: 12px; border-bottom: 1px solid #eee;';
        const totalInput = document.createElement('input');
        totalInput.className = 'Rectangle-29 total';
        totalInput.type = 'number';
        totalInput.min = '0';
        totalInput.step = '0.01';
        totalInput.name = 'services_2[total][]';
        totalInput.placeholder = 'Total Amount';
        totalInput.style.cssText = 'border: none; background: transparent; width: 100%;';
        totalInput.readOnly = true;
        td4.appendChild(totalInput);

        const td5 = document.createElement('td');
        td5.style.cssText = 'padding: 12px; border-bottom: 1px solid #eee;';
        const percentInput = document.createElement('input');
        percentInput.className = 'Rectangle-29 completion-percent';
        percentInput.type = 'number';
        percentInput.min = '0';
        percentInput.max = '100';
        percentInput.step = '1';
        percentInput.name = 'services_2[completion_percent][]';
        percentInput.placeholder = 'Enter %';
        percentInput.style.cssText = 'border: none; background: transparent; width: 100%;';
        percentInput.oninput = function() { calculatePercentageAmount(this); };
        td5.appendChild(percentInput);

        const td6 = document.createElement('td');
        td6.style.cssText = 'padding: 12px; border-bottom: 1px solid #eee;';
        const termsInput = document.createElement('input');
        termsInput.className = 'Rectangle-29';
        termsInput.name = 'services_2[completion_terms][]';
        termsInput.placeholder = 'Enter Terms';
        termsInput.style.cssText = 'border: none; background: transparent; width: 100%;';
        td6.appendChild(termsInput);

        const td7 = document.createElement('td');
        td7.style.cssText = 'padding: 12px; border-bottom: 1px solid #eee; text-align: center;';
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'remove-row';
        removeBtn.style.cssText = 'background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; padding: 0; font-size: 16px; line-height: 1; cursor: pointer;';
        removeBtn.innerHTML = '×';
        td7.appendChild(removeBtn);

        row.appendChild(td1);
        row.appendChild(td2);
        row.appendChild(td3);
        row.appendChild(td4);
        row.appendChild(td5);
        row.appendChild(td6);
        row.appendChild(td7);
        
        tbody.appendChild(row);
    });
    //
    // REMOVE ANY ROW
    //
    document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-row')) {
            // Check if this is from services_2 table (has completion-percent)
            const row = e.target.closest('tr');
            const tbody = row.closest('tbody');
            const rowCount = tbody.querySelectorAll('tr').length;
            
            // Prevent removing the last row
            if (rowCount <= 1) {
                alert('At least one service item must exist. You cannot remove all items.');
                return;
            }
            
            const isServices2 = row.querySelector('.completion-percent') !== null;
            row.remove();
            calculateContractAmount();
            if (isServices2) {
                calculateServicesTotalAmount();
            }
        }
    });

    //
    // PREMIUM QUOTATION TOGGLE
    //
    document.querySelector('.premium-quotation-btn')?.addEventListener('click', function() {
        const sec = document.getElementById('premiumSection');
        const show = sec.style.display !== 'block';
        sec.style.display = show ? 'block' : 'none';
        this.textContent = show ? 'Hide Premium' : 'Premium Quotation';
        this.style.background = show ? '#dc3545' : '#ffa500';
    });

    //
    // ADD MORE STANDARD TERMS
    //
    document.querySelector('.add-standard-term')?.addEventListener('click', function() {
        const container = document.getElementById('standardTermsList');
        const item = document.createElement('div');
        item.className = 'standard-term-item';
        item.style.cssText = 'display: flex; align-items: center; margin-bottom: 15px;';
        item.innerHTML = `
            <span style="margin-right: 10px;">⚫</span>
            <input type="text" name="standard_terms[]" placeholder="Enter term" style="flex: 1; border: none; background: transparent; font-size: 14px;">
            <button type="button" class="remove-standard-term" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; margin-left: 10px;">×</button>
        `;
        container.appendChild(item);
    });

    //
    // ADD MORE CUSTOM TERMS
    //
    // Custom terms now handled by simple textarea - no JavaScript needed

    //
    // REMOVE TERMS
    //
    document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-standard-term')) {
            e.target.closest('.standard-term-item').remove();
            updateTermNumbers();
        }
    });
    
    function updateTermNumbers() {
        const container = document.getElementById('customTermsList');
        Array.from(container.children).forEach((item, index) => {
            const numberSpan = item.querySelector('span:first-child');
            numberSpan.textContent = (index + 1) + '.';
        });
    }

    //
    // ADD MORE BASIC COST
    //
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

    //
    // ADD MORE ADDITIONAL COST
    //
    document.querySelector('.add-additional-cost')?.addEventListener('click', function() {
        const tbody = document.querySelector('#additionalCostTable tbody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29" name="additional_cost[description][]" placeholder="Enter Description" style="border: none; background: transparent;"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-quantity" type="number" min="0" step="1" name="additional_cost[quantity][]" placeholder="000" style="border: none; background: transparent;" oninput="calculateAdditionalTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-rate" type="number" min="0" step="0.01" name="additional_cost[rate][]" placeholder="₹ 000" style="border: none; background: transparent;" oninput="calculateAdditionalTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 additional-total" type="number" min="0" step="0.01" name="additional_cost[total][]" placeholder="₹ 0000000" style="border: none; background: transparent;" readonly></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-additional-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
        `;
        tbody.appendChild(row);
    });

    //
    // ADD MORE MAINTENANCE COST
    //
    document.querySelector('.add-maintenance-cost')?.addEventListener('click', function() {
        const tbody = document.querySelector('#maintenanceCostTable tbody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29" name="maintenance_cost[description][]" placeholder="Enter Description" style="border: none; background: transparent;"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-quantity" type="number" min="0" step="1" name="maintenance_cost[quantity][]" placeholder="000" style="border: none; background: transparent;" oninput="calculateMaintenanceTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-rate" type="number" min="0" step="0.01" name="maintenance_cost[rate][]" placeholder="₹ 000" style="border: none; background: transparent;" oninput="calculateMaintenanceTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 maintenance-total" type="number" min="0" step="0.01" name="maintenance_cost[total][]" placeholder="₹ 0000000" style="border: none; background: transparent;" readonly></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-maintenance-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
        `;
        tbody.appendChild(row);
    });

    //
    // REMOVE BASIC, ADDITIONAL & MAINTENANCE ROWS
    //
    document.addEventListener('click', e => {
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

    //
    // CUSTOM CHECKBOX
    //
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

});

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
        errorDiv.innerHTML = '<strong>Validation Error:</strong><br>Please add at least one service before submitting the quotation.';
        document.body.appendChild(errorDiv);
        
        // Scroll to services section
        document.querySelector('.services-table-1')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Remove error after 5 seconds
        setTimeout(() => errorDiv.remove(), 5000);
        
        return false;
    }
    
    console.log(`Submitting quotation with ${validServiceCount} service(s)`);
    
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
    
    // Debug: Check custom terms textarea before submission
    const customTermsTextarea = form.querySelector('textarea[name="custom_terms_text"]');
    console.log('=== CUSTOM TERMS DEBUG ===');
    console.log('Custom terms textarea found:', !!customTermsTextarea);
    console.log('Custom terms textarea value:', customTermsTextarea?.value);
    
    // List all form data
    const formData = new FormData(form);
    console.log('All form data:');
    for (let [key, value] of formData.entries()) {
        if (key.includes('custom_terms')) {
            console.log(`FOUND: ${key} = ${value}`);
        }
    }
    
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

// Filter out empty service rows before form submission
document.getElementById('quotationForm').addEventListener('submit', function(e) {
    // Prevent the default form submission
    e.preventDefault();
    
    // Process services_1 table - disable inputs in empty rows
    const services1Rows = document.querySelectorAll('.services-table-1 tbody tr');
    let hasValidRows = false;
    
    services1Rows.forEach((row) => {
        const descInput = row.querySelector('input[name="services_1[description][]"]');
        const qtyInput = row.querySelector('input[name="services_1[quantity][]"]');
        const rateInput = row.querySelector('input[name="services_1[rate][]"]');
        const totalInput = row.querySelector('input[name="services_1[total][]"]');
        
        const description = descInput?.value.trim();
        const quantity = qtyInput?.value.trim();
        const rate = rateInput?.value.trim();
        
        // If description is empty, disable all inputs in this row so they won't be submitted
        if (!description || description === '') {
            if (descInput) descInput.disabled = true;
            if (qtyInput) qtyInput.disabled = true;
            if (rateInput) rateInput.disabled = true;
            if (totalInput) totalInput.disabled = true;
        } else {
            hasValidRows = true;
        }
    });

    // If no valid rows in services_1, ensure at least one empty row is present
    if (!hasValidRows && services1Rows.length === 0) {
        const tbody = document.querySelector('.services-table-1 tbody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29" name="services_1[description][]" placeholder="Enter Description" style="border: none; background: transparent; width: 100%;">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29 quantity" type="number" min="0" step="1" name="services_1[quantity][]" placeholder="Enter Quantity" style="border: none; background: transparent; width: 100%;" oninput="calculateRowTotal(this)" value="0">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29 rate" type="number" min="0" step="0.01" name="services_1[rate][]" placeholder="Enter Rate" style="border: none; background: transparent; width: 100%;" oninput="calculateRowTotal(this)" value="0">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                <input class="Rectangle-29 total" type="number" min="0" step="0.01" name="services_1[total][]" placeholder="Total Rate" style="border: none; background: transparent; width: 100%;" readonly value="0.00">
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: center;">
                <button type="button" class="remove-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; padding: 0; font-size: 16px; line-height: 1; cursor: pointer;">×</button>
            </td>`;
        tbody.appendChild(row);
    }

    // Process services_2 table - disable inputs in empty rows
    const services2Rows = document.querySelectorAll('.services-table-2 tbody tr');
    let hasValidRows2 = false;
    
    services2Rows.forEach((row) => {
        const descSelect = row.querySelector('select[name="services_2[description][]"]');
        const qtyInput = row.querySelector('input[name="services_2[quantity][]"]');
        const rateInput = row.querySelector('input[name="services_2[rate][]"]');
        const totalInput = row.querySelector('input[name="services_2[total][]"]');
        const percentInput = row.querySelector('input[name="services_2[completion_percent][]"]');
        const termsInput = row.querySelector('input[name="services_2[completion_terms][]"]');
        
        const description = descSelect?.value;
        
        // If description is empty, disable all inputs in this row
        if (!description || description === '') {
            if (descSelect) descSelect.disabled = true;
            if (qtyInput) qtyInput.disabled = true;
            if (rateInput) rateInput.disabled = true;
            if (totalInput) totalInput.disabled = true;
            if (percentInput) percentInput.disabled = true;
            if (termsInput) termsInput.disabled = true;
        }
    });
    
    // Continue with form submission
    return true;
});

// Email duplicate check for new customers
const companyEmailInput = document.getElementById('company_email');
const emailCheckMessage = document.getElementById('email_check_message');
const customerTypeSelect = document.getElementById('customer_type');

if (companyEmailInput && customerTypeSelect) {
    let emailCheckTimeout;
    
    companyEmailInput.addEventListener('input', function() {
        clearTimeout(emailCheckTimeout);
        
        // Only check if customer type is "new"
        if (customerTypeSelect.value !== 'new') {
            emailCheckMessage.style.display = 'none';
            return;
        }
        
        const email = this.value.trim();
        
        if (!email || !email.includes('@')) {
            emailCheckMessage.style.display = 'none';
            return;
        }
        
        emailCheckTimeout = setTimeout(() => {
            // Check if email exists
            fetch(`/api/check-company-email?email=${encodeURIComponent(email)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        emailCheckMessage.textContent = 'This email is already registered. Please use "Existing Customer" or a different email.';
                        emailCheckMessage.style.display = 'block';
                        emailCheckMessage.style.color = '#dc3545';
                    } else {
                        emailCheckMessage.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error checking email:', error);
                });
        }, 500);
    });
    
    // Hide message when switching to existing customer
    customerTypeSelect.addEventListener('change', function() {
        if (this.value === 'existing') {
            emailCheckMessage.style.display = 'none';
        }
    });
}



// Initialize date pickers with dd/mm/yyyy format
$(document).ready(function() {
    $('.date-picker').datepicker({
        dateFormat: 'dd/mm/yy', // In jQuery UI, 'yy' means 4-digit year
        changeMonth: true,
        changeYear: true,
        yearRange: '-10:+10',
        showButtonPanel: true,
        beforeShow: function(input, inst) {
            setTimeout(function() {
                inst.dpDiv.css({
                    marginTop: '2px',
                    marginLeft: '0px'
                });
            }, 0);
        }
    });
});

// Test function to manually add a custom term
function testAddTerm() {
    console.log('Test button clicked');
    const container = document.getElementById('customTermsList');
    console.log('Container found:', container);
    const item = document.createElement('div');
    item.className = 'standard-term-item';
    item.style.cssText = 'display: flex; align-items: center; margin-bottom: 15px; padding: 15px; background: #f8f9fa; border-radius: 8px;';
    const termNumber = container.children.length + 1;
    item.innerHTML = `
        <span style="margin-right: 15px; font-weight: bold; color: #333;">${termNumber}.</span>
        <span style="flex: 1; font-size: 14px; color: #333;">Test Custom Term ${termNumber}</span>
        <input type="hidden" name="custom_terms[]" value="Test Custom Term ${termNumber}">
        <button type="button" class="remove-standard-term" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; margin-left: 10px; cursor: pointer;">×</button>
    `;
    container.appendChild(item);
    console.log('Test term added. Container now has', container.children.length, 'children');
    
    // Verify the hidden input was created
    const hiddenInputs = document.querySelectorAll('input[name="custom_terms[]"]');
    console.log('Total custom_terms[] inputs:', hiddenInputs.length);
}

// Auto-generate email based on company name
function generateEmail() {
    const companyNameInput = document.querySelector('input[name="company_name"]');
    const emailInput = document.getElementById('company_email');
    
    if (!companyNameInput || !companyNameInput.value) {
        Swal.fire({
            icon: 'warning',
            title: 'Company Name Required',
            text: 'Please enter company name first to generate email',
            confirmButtonColor: '#10b981'
        });
        return;
    }
    
    const companyName = companyNameInput.value.trim();
    
    // Generate email: company name (lowercase, no spaces) + random 3 digits + @example.com
    const emailPrefix = companyName.replace(/[^a-zA-Z0-9]/g, '').toLowerCase();
    const randomNum = Math.floor(100 + Math.random() * 900);
    const email = emailPrefix + randomNum + '@example.com';
    
    emailInput.value = email;
    
    // Show success message
    Swal.fire({
        icon: 'success',
        title: 'Email Generated!',
        html: `<p>Email: <strong style="color: #10b981; font-size: 18px;">${email}</strong></p><p style="color: #6b7280; font-size: 13px; margin-top: 10px;">You can edit this email if needed.</p>`,
        confirmButtonColor: '#10b981',
        width: '400px'
    });
}

// Auto-generate password based on company name
function generatePassword() {
    const companyNameInput = document.querySelector('input[name="company_name"]');
    const passwordInput = document.getElementById('company_password');
    
    if (!companyNameInput || !companyNameInput.value) {
        Swal.fire({
            icon: 'warning',
            title: 'Company Name Required',
            text: 'Please enter company name first to generate password',
            confirmButtonColor: '#3b82f6'
        });
        return;
    }
    
    const companyName = companyNameInput.value.trim();
    
    // Generate password: First 3 letters of company name + random 4 digits + special char
    const prefix = companyName.replace(/[^a-zA-Z]/g, '').substring(0, 3).toLowerCase();
    const randomNum = Math.floor(1000 + Math.random() * 9000);
    const specialChars = ['@', '#', '$', '!'];
    const specialChar = specialChars[Math.floor(Math.random() * specialChars.length)];
    
    const password = prefix + randomNum + specialChar;
    
    passwordInput.value = password;
    
    // Show success message
    Swal.fire({
        icon: 'success',
        title: 'Password Generated!',
        html: `<p>Password: <strong style="color: #3b82f6; font-size: 18px;">${password}</strong></p><p style="color: #6b7280; font-size: 13px; margin-top: 10px;">Please save this password securely.</p>`,
        confirmButtonColor: '#3b82f6',
        width: '400px'
    });
}

// Generate both email and password together
function generateBoth() {
    generateEmail();
    setTimeout(() => {
        generatePassword();
    }, 500);
}

// Auto-generate employee email based on company name
function generateEmployeeEmail() {
    const companyNameInput = document.querySelector('input[name="company_name"]');
    const emailInput = document.getElementById('company_employee_email');
    
    if (!companyNameInput || !companyNameInput.value) {
        Swal.fire({
            icon: 'warning',
            title: 'Company Name Required',
            text: 'Please enter company name first to generate employee email',
            confirmButtonColor: '#10b981'
        });
        return;
    }
    
    const companyName = companyNameInput.value.trim();
    
    // Generate email: company name (alphanumeric only) + "emp" + random 3 digits + @example.com
    const emailPrefix = companyName.replace(/[^a-zA-Z0-9]/g, '').toLowerCase();
    const randomNum = Math.floor(100 + Math.random() * 900);
    const email = emailPrefix + 'emp' + randomNum + '@example.com';
    
    emailInput.value = email;
    
    // Show success message
    Swal.fire({
        icon: 'success',
        title: 'Employee Email Generated!',
        html: `<p>Email: <strong style="color: #10b981; font-size: 16px;">${email}</strong></p>`,
        confirmButtonColor: '#10b981',
        width: '400px'
    });
}

// Auto-generate employee password based on company name
function generateEmployeePassword() {
    const companyNameInput = document.querySelector('input[name="company_name"]');
    const passwordInput = document.getElementById('company_employee_password');
    
    if (!companyNameInput || !companyNameInput.value) {
        Swal.fire({
            icon: 'warning',
            title: 'Company Name Required',
            text: 'Please enter company name first to generate employee password',
            confirmButtonColor: '#10b981'
        });
        return;
    }
    
    const companyName = companyNameInput.value.trim();
    
    // Generate password: "Emp" + First 3 letters of company name + random 4 digits + special char
    const prefix = 'Emp' + companyName.replace(/[^a-zA-Z]/g, '').substring(0, 3);
    const randomNum = Math.floor(1000 + Math.random() * 9000);
    const specialChars = ['@', '#', '$', '!'];
    const specialChar = specialChars[Math.floor(Math.random() * specialChars.length)];
    
    const password = prefix + randomNum + specialChar;
    
    passwordInput.value = password;
    
    // Show success message
    Swal.fire({
        icon: 'success',
        title: 'Employee Password Generated!',
        html: `<p>Password: <strong style="color: #10b981; font-size: 18px;">${password}</strong></p><p style="color: #6b7280; font-size: 13px; margin-top: 10px;">Please save this password securely.</p>`,
        confirmButtonColor: '#10b981',
        width: '400px'
    });
}

// Auto-generate email and password when company name changes (for new customers only)
document.addEventListener('DOMContentLoaded', function() {
    const companyNameInput = document.querySelector('input[name="company_name"]');
    const customerTypeSelect = document.getElementById('customer_type');
    const emailInput = document.getElementById('company_email');
    const passwordInput = document.getElementById('company_password');
    
    if (companyNameInput && customerTypeSelect && emailInput && passwordInput) {
        companyNameInput.addEventListener('blur', function() {
            // Only auto-generate for new customers and if fields are empty
            if (customerTypeSelect.value === 'new' && this.value.trim()) {
                // Generate email if empty
                if (!emailInput.value) {
                    const companyName = this.value.trim();
                    const emailPrefix = companyName.replace(/[^a-zA-Z0-9]/g, '').toLowerCase();
                    const randomNum = Math.floor(100 + Math.random() * 900);
                    emailInput.value = emailPrefix + randomNum + '@example.com';
                }
                
                // Generate password if empty
                if (!passwordInput.value) {
                    const companyName = this.value.trim();
                    const prefix = companyName.replace(/[^a-zA-Z]/g, '').substring(0, 3).toLowerCase();
                    const randomNum = Math.floor(1000 + Math.random() * 9000);
                    const specialChars = ['@', '#', '$', '!'];
                    const specialChar = specialChars[Math.floor(Math.random() * specialChars.length)];
                    passwordInput.value = prefix + randomNum + specialChar;
                }
            }
        });
    }
});

// Custom Terms & Conditions Functions
function addNewTerm() {
    const textarea = document.getElementById('custom_terms_text');
    const currentValue = textarea.value.trim();
    const newTerm = '• ';
    
    if (currentValue === '') {
        textarea.value = newTerm;
    } else {
        textarea.value = currentValue + '\n' + newTerm;
    }
    
    // Focus at the end of the new term
    textarea.focus();
    textarea.setSelectionRange(textarea.value.length, textarea.value.length);
    updatePreview();
}

function togglePreview() {
    const inputMode = document.getElementById('termsInputMode');
    const previewMode = document.getElementById('termsPreviewMode');
    const toggleBtn = event.target;
    
    if (inputMode.style.display === 'none') {
        // Switch to input mode
        inputMode.style.display = 'block';
        previewMode.style.display = 'none';
        toggleBtn.textContent = '👁 Preview';
        toggleBtn.style.background = '#10b981';
    } else {
        // Switch to preview mode
        updatePreview();
        inputMode.style.display = 'none';
        previewMode.style.display = 'block';
        toggleBtn.textContent = '✏️ Edit';
        toggleBtn.style.background = '#f59e0b';
    }
}

function updatePreview() {
    const textarea = document.getElementById('custom_terms_text');
    const previewContent = document.getElementById('termsPreviewContent');
    const termCount = document.getElementById('termCount');
    
    const text = textarea.value.trim();
    const lines = text.split('\n').filter(line => line.trim() !== '');
    
    // Update term count
    termCount.textContent = `${lines.length} term${lines.length !== 1 ? 's' : ''}`;
    
    if (lines.length === 0) {
        previewContent.innerHTML = '<p style="color: #9ca3af; font-style: italic;">No terms entered yet...</p>';
        return;
    }
    
    // Generate preview HTML
    let html = '<div style="font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif;">';
    html += '<h4 style="margin: 0 0 12px 0; font-size: 15px; font-weight: 600; color: #1f2937;">Terms & Conditions:</h4>';
    html += '<ul style="margin: 0; padding-left: 0; list-style: none;">';
    
    lines.forEach((line, index) => {
        let cleanLine = line.trim();
        
        // Remove existing bullet points and add consistent formatting
        cleanLine = cleanLine.replace(/^[•\-\*]\s*/, '');
        
        if (cleanLine) {
            html += `<li style="margin-bottom: 8px; padding-left: 20px; position: relative; line-height: 1.5; color: #374151;">`;
            html += `<span style="position: absolute; left: 0; color: #3b82f6; font-weight: bold;">•</span>`;
            html += `${cleanLine}`;
            html += `</li>`;
        }
    });
    
    html += '</ul></div>';
    previewContent.innerHTML = html;
}

// Initialize Custom Terms & Conditions on page load
document.addEventListener('DOMContentLoaded', function() {
    updatePreview();
    
    // Update preview when typing
    const textarea = document.getElementById('custom_terms_text');
    if (textarea) {
        textarea.addEventListener('input', updatePreview);
    }
});

</script>
@endpush
@endsection
