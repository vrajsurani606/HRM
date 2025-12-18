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
        <input type="text" class="Rectangle-29 date-picker @error('quotation_date') is-invalid @enderror" name="quotation_date" placeholder="dd/mm/yyyy" value="{{ old('quotation_date', $quotation->quotation_date ? $quotation->quotation_date->format('d/m/Y') : '') }}" autocomplete="off" required>
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
          <input class="Rectangle-29 @error('gst_no') is-invalid @enderror" name="gst_no" placeholder="e.g., 22ABCDE1234F1Z5" value="{{ old('gst_no', $quotation->gst_no) }}" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 15)" maxlength="15" pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9A-Z]{1}[Z]{1}[0-9A-Z]{1}" title="Enter valid 15-character GST No. (e.g., 22ABCDE1234F1Z5)">
          @error('gst_no')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">PAN No:</label>
          <input class="Rectangle-29 @error('pan_no') is-invalid @enderror" name="pan_no" placeholder="e.g., ABCDE1234F" value="{{ old('pan_no', $quotation->pan_no) }}" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 10)" maxlength="10" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" title="Enter valid 10-character PAN No. (e.g., ABCDE1234F)">
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
            <option value="INFORMATION_TECHNOLOGY" {{ old('company_type', $quotation->company_type) == 'INFORMATION_TECHNOLOGY' ? 'selected' : '' }}>Information Technology (IT)</option>
            <option value="SOFTWARE_DEVELOPMENT" {{ old('company_type', $quotation->company_type) == 'SOFTWARE_DEVELOPMENT' ? 'selected' : '' }}>Software Development</option>
            <option value="HARDWARE_ELECTRONICS" {{ old('company_type', $quotation->company_type) == 'HARDWARE_ELECTRONICS' ? 'selected' : '' }}>Hardware & Electronics</option>
            <option value="TELECOMMUNICATIONS" {{ old('company_type', $quotation->company_type) == 'TELECOMMUNICATIONS' ? 'selected' : '' }}>Telecommunications</option>
            <option value="E_COMMERCE" {{ old('company_type', $quotation->company_type) == 'E_COMMERCE' ? 'selected' : '' }}>E-Commerce</option>
            <option value="MANUFACTURING" {{ old('company_type', $quotation->company_type) == 'MANUFACTURING' ? 'selected' : '' }}>Manufacturing</option>
            <option value="AUTOMOBILE" {{ old('company_type', $quotation->company_type) == 'AUTOMOBILE' ? 'selected' : '' }}>Automobile</option>
            <option value="AEROSPACE_DEFENSE" {{ old('company_type', $quotation->company_type) == 'AEROSPACE_DEFENSE' ? 'selected' : '' }}>Aerospace & Defense</option>
            <option value="CONSTRUCTION_INFRASTRUCTURE" {{ old('company_type', $quotation->company_type) == 'CONSTRUCTION_INFRASTRUCTURE' ? 'selected' : '' }}>Construction & Infrastructure</option>
            <option value="REAL_ESTATE" {{ old('company_type', $quotation->company_type) == 'REAL_ESTATE' ? 'selected' : '' }}>Real Estate</option>
            <option value="BANKING_FINANCIAL" {{ old('company_type', $quotation->company_type) == 'BANKING_FINANCIAL' ? 'selected' : '' }}>Banking & Financial Services</option>
            <option value="INSURANCE" {{ old('company_type', $quotation->company_type) == 'INSURANCE' ? 'selected' : '' }}>Insurance</option>
            <option value="INVESTMENT_ASSET" {{ old('company_type', $quotation->company_type) == 'INVESTMENT_ASSET' ? 'selected' : '' }}>Investment & Asset Management</option>
            <option value="HEALTHCARE" {{ old('company_type', $quotation->company_type) == 'HEALTHCARE' ? 'selected' : '' }}>Healthcare</option>
            <option value="PHARMACEUTICALS" {{ old('company_type', $quotation->company_type) == 'PHARMACEUTICALS' ? 'selected' : '' }}>Pharmaceuticals</option>
            <option value="BIOTECHNOLOGY" {{ old('company_type', $quotation->company_type) == 'BIOTECHNOLOGY' ? 'selected' : '' }}>Biotechnology</option>
            <option value="MEDICAL_DEVICES" {{ old('company_type', $quotation->company_type) == 'MEDICAL_DEVICES' ? 'selected' : '' }}>Medical Devices</option>
            <option value="EDUCATION_TRAINING" {{ old('company_type', $quotation->company_type) == 'EDUCATION_TRAINING' ? 'selected' : '' }}>Education & Training</option>
            <option value="RETAIL" {{ old('company_type', $quotation->company_type) == 'RETAIL' ? 'selected' : '' }}>Retail</option>
            <option value="WHOLESALE_DISTRIBUTION" {{ old('company_type', $quotation->company_type) == 'WHOLESALE_DISTRIBUTION' ? 'selected' : '' }}>Wholesale & Distribution</option>
            <option value="LOGISTICS_SUPPLY" {{ old('company_type', $quotation->company_type) == 'LOGISTICS_SUPPLY' ? 'selected' : '' }}>Logistics & Supply Chain</option>
            <option value="TRANSPORTATION" {{ old('company_type', $quotation->company_type) == 'TRANSPORTATION' ? 'selected' : '' }}>Transportation (Air, Road, Rail, Sea)</option>
            <option value="FOOD_BEVERAGE" {{ old('company_type', $quotation->company_type) == 'FOOD_BEVERAGE' ? 'selected' : '' }}>Food & Beverages</option>
            <option value="HOSPITALITY" {{ old('company_type', $quotation->company_type) == 'HOSPITALITY' ? 'selected' : '' }}>Hospitality</option>
            <option value="TOURISM_TRAVEL" {{ old('company_type', $quotation->company_type) == 'TOURISM_TRAVEL' ? 'selected' : '' }}>Tourism & Travel</option>
            <option value="MEDIA_ENTERTAINMENT" {{ old('company_type', $quotation->company_type) == 'MEDIA_ENTERTAINMENT' ? 'selected' : '' }}>Media & Entertainment</option>
            <option value="ADVERTISING_MARKETING" {{ old('company_type', $quotation->company_type) == 'ADVERTISING_MARKETING' ? 'selected' : '' }}>Advertising & Marketing</option>
            <option value="PUBLISHING" {{ old('company_type', $quotation->company_type) == 'PUBLISHING' ? 'selected' : '' }}>Publishing</option>
            <option value="OIL_GAS" {{ old('company_type', $quotation->company_type) == 'OIL_GAS' ? 'selected' : '' }}>Oil & Gas</option>
            <option value="MINING_METALS" {{ old('company_type', $quotation->company_type) == 'MINING_METALS' ? 'selected' : '' }}>Mining & Metals</option>
            <option value="CHEMICALS" {{ old('company_type', $quotation->company_type) == 'CHEMICALS' ? 'selected' : '' }}>Chemicals</option>
            <option value="ENERGY_POWER" {{ old('company_type', $quotation->company_type) == 'ENERGY_POWER' ? 'selected' : '' }}>Energy & Power</option>
            <option value="RENEWABLE_ENERGY" {{ old('company_type', $quotation->company_type) == 'RENEWABLE_ENERGY' ? 'selected' : '' }}>Renewable Energy (Solar, Wind)</option>
            <option value="AGRICULTURE" {{ old('company_type', $quotation->company_type) == 'AGRICULTURE' ? 'selected' : '' }}>Agriculture</option>
            <option value="ENVIRONMENTAL_SERVICES" {{ old('company_type', $quotation->company_type) == 'ENVIRONMENTAL_SERVICES' ? 'selected' : '' }}>Environmental Services</option>
            <option value="LEGAL_SERVICES" {{ old('company_type', $quotation->company_type) == 'LEGAL_SERVICES' ? 'selected' : '' }}>Legal Services</option>
            <option value="CONSULTING_ADVISORY" {{ old('company_type', $quotation->company_type) == 'CONSULTING_ADVISORY' ? 'selected' : '' }}>Consulting & Advisory</option>
            <option value="HUMAN_RESOURCES" {{ old('company_type', $quotation->company_type) == 'HUMAN_RESOURCES' ? 'selected' : '' }}>Human Resources Services</option>
            <option value="BPO_KPO" {{ old('company_type', $quotation->company_type) == 'BPO_KPO' ? 'selected' : '' }}>BPO / KPO</option>
            <option value="SECURITY_SERVICES" {{ old('company_type', $quotation->company_type) == 'SECURITY_SERVICES' ? 'selected' : '' }}>Security Services</option>
            <option value="FASHION_APPAREL" {{ old('company_type', $quotation->company_type) == 'FASHION_APPAREL' ? 'selected' : '' }}>Fashion & Apparel</option>
            <option value="TEXTILES" {{ old('company_type', $quotation->company_type) == 'TEXTILES' ? 'selected' : '' }}>Textiles</option>
            <option value="SPORTS_FITNESS" {{ old('company_type', $quotation->company_type) == 'SPORTS_FITNESS' ? 'selected' : '' }}>Sports & Fitness</option>
            <option value="NON_PROFIT_NGO" {{ old('company_type', $quotation->company_type) == 'NON_PROFIT_NGO' ? 'selected' : '' }}>Non-Profit / NGO</option>
            <option value="GOVERNMENT_PUBLIC" {{ old('company_type', $quotation->company_type) == 'GOVERNMENT_PUBLIC' ? 'selected' : '' }}>Government & Public Sector</option>
            <option value="OTHER" {{ old('company_type', $quotation->company_type) == 'OTHER' ? 'selected' : '' }}>Other</option>
          </select>
        </div>
      </div>

      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Nature Of Work:</label>
          <input class="Rectangle-29 @error('nature_of_work') is-invalid @enderror" name="nature_of_work" placeholder="Enter Nature" value="{{ old('nature_of_work', $quotation->nature_of_work) }}">
          @error('nature_of_work')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">State:</label>
          <select class="Rectangle-29-select @error('state') is-invalid @enderror" name="state" id="state_select">
            <option value="" disabled {{ old('state', $quotation->state) ? '' : 'selected' }}>SELECT STATE</option>
            <option value="andhra_pradesh" {{ old('state', $quotation->state) == 'andhra_pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
            <option value="arunachal_pradesh" {{ old('state', $quotation->state) == 'arunachal_pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
            <option value="assam" {{ old('state', $quotation->state) == 'assam' ? 'selected' : '' }}>Assam</option>
            <option value="bihar" {{ old('state', $quotation->state) == 'bihar' ? 'selected' : '' }}>Bihar</option>
            <option value="chhattisgarh" {{ old('state', $quotation->state) == 'chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
            <option value="delhi" {{ old('state', $quotation->state) == 'delhi' ? 'selected' : '' }}>Delhi</option>
            <option value="goa" {{ old('state', $quotation->state) == 'goa' ? 'selected' : '' }}>Goa</option>
            <option value="gujarat" {{ old('state', $quotation->state) == 'gujarat' ? 'selected' : '' }}>Gujarat</option>
            <option value="haryana" {{ old('state', $quotation->state) == 'haryana' ? 'selected' : '' }}>Haryana</option>
            <option value="himachal_pradesh" {{ old('state', $quotation->state) == 'himachal_pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
            <option value="jammu_kashmir" {{ old('state', $quotation->state) == 'jammu_kashmir' ? 'selected' : '' }}>Jammu & Kashmir</option>
            <option value="jharkhand" {{ old('state', $quotation->state) == 'jharkhand' ? 'selected' : '' }}>Jharkhand</option>
            <option value="karnataka" {{ old('state', $quotation->state) == 'karnataka' ? 'selected' : '' }}>Karnataka</option>
            <option value="kerala" {{ old('state', $quotation->state) == 'kerala' ? 'selected' : '' }}>Kerala</option>
            <option value="ladakh" {{ old('state', $quotation->state) == 'ladakh' ? 'selected' : '' }}>Ladakh</option>
            <option value="madhya_pradesh" {{ old('state', $quotation->state) == 'madhya_pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
            <option value="maharashtra" {{ old('state', $quotation->state) == 'maharashtra' ? 'selected' : '' }}>Maharashtra</option>
            <option value="manipur" {{ old('state', $quotation->state) == 'manipur' ? 'selected' : '' }}>Manipur</option>
            <option value="meghalaya" {{ old('state', $quotation->state) == 'meghalaya' ? 'selected' : '' }}>Meghalaya</option>
            <option value="mizoram" {{ old('state', $quotation->state) == 'mizoram' ? 'selected' : '' }}>Mizoram</option>
            <option value="nagaland" {{ old('state', $quotation->state) == 'nagaland' ? 'selected' : '' }}>Nagaland</option>
            <option value="odisha" {{ old('state', $quotation->state) == 'odisha' ? 'selected' : '' }}>Odisha</option>
            <option value="punjab" {{ old('state', $quotation->state) == 'punjab' ? 'selected' : '' }}>Punjab</option>
            <option value="rajasthan" {{ old('state', $quotation->state) == 'rajasthan' ? 'selected' : '' }}>Rajasthan</option>
            <option value="sikkim" {{ old('state', $quotation->state) == 'sikkim' ? 'selected' : '' }}>Sikkim</option>
            <option value="tamil_nadu" {{ old('state', $quotation->state) == 'tamil_nadu' ? 'selected' : '' }}>Tamil Nadu</option>
            <option value="telangana" {{ old('state', $quotation->state) == 'telangana' ? 'selected' : '' }}>Telangana</option>
            <option value="tripura" {{ old('state', $quotation->state) == 'tripura' ? 'selected' : '' }}>Tripura</option>
            <option value="uttar_pradesh" {{ old('state', $quotation->state) == 'uttar_pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
            <option value="uttarakhand" {{ old('state', $quotation->state) == 'uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
            <option value="west_bengal" {{ old('state', $quotation->state) == 'west_bengal' ? 'selected' : '' }}>West Bengal</option>
            {{-- Union Territories --}}
            <option value="andaman_nicobar" {{ old('state', $quotation->state) == 'andaman_nicobar' ? 'selected' : '' }}>Andaman & Nicobar Islands</option>
            <option value="chandigarh" {{ old('state', $quotation->state) == 'chandigarh' ? 'selected' : '' }}>Chandigarh</option>
            <option value="dadra_nagar_haveli_daman_diu" {{ old('state', $quotation->state) == 'dadra_nagar_haveli_daman_diu' ? 'selected' : '' }}>Dadra & Nagar Haveli and Daman & Diu</option>
            <option value="lakshadweep" {{ old('state', $quotation->state) == 'lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
            <option value="puducherry" {{ old('state', $quotation->state) == 'puducherry' ? 'selected' : '' }}>Puducherry</option>
            <option value="other" {{ old('state', $quotation->state) == 'other' ? 'selected' : '' }}>Other</option>
          </select>
          <input type="text" name="state_other" id="state_other_input" class="Rectangle-29-select" placeholder="Enter State Name" value="{{ old('state_other', $quotation->state_other ?? '') }}" style="display: {{ old('state', $quotation->state) == 'other' ? 'block' : 'none' }}; margin-top: 8px;">
          @error('state')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">City:</label>
          <select class="Rectangle-29-select @error('city') is-invalid @enderror" name="city" id="city_select">
            <option value="" disabled selected>SELECT STATE FIRST</option>
          </select>
          <input type="hidden" id="old_city" value="{{ old('city', $quotation->city) }}">
          <input type="text" name="city_other" id="city_other_input" class="Rectangle-29-select" placeholder="Enter City Name" value="{{ old('city_other', $quotation->city_other ?? '') }}" style="display: {{ old('city', $quotation->city) == 'other' ? 'block' : 'none' }}; margin-top: 8px;">
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

      <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Contact Person 1: <span class="text-red-500">*</span></label>
          <input class="Rectangle-29 @error('contact_person_1') is-invalid @enderror" name="contact_person_1" placeholder="Enter Contact Person Name" value="{{ old('contact_person_1', $quotation->contact_person_1) }}" required>
          @error('contact_person_1')
              <small class="hrp-error">{{ $message }}</small>
          @enderror
        </div>
        <div>
          <label class="hrp-label">Gender 1:</label>
          <select class="Rectangle-29 Rectangle-29-select @error('contact_gender_1') is-invalid @enderror" name="contact_gender_1">
            <option value="">Select Gender</option>
            <option value="Male" {{ old('contact_gender_1', $quotation->contact_gender_1) == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('contact_gender_1', $quotation->contact_gender_1) == 'Female' ? 'selected' : '' }}>Female</option>
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
            value="{{ old('contact_number_1', strip_country_code($quotation->contact_number_1)) }}"
            placeholder="Enter 10 digit mobile number"
            required
          />
          @error('contact_number_1')<small class="hrp-error">{{ $message }}</small>@enderror
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
            <a href="{{ route('quotations.contract.file', $quotation->id) }}" target="_blank" 
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
          <div style="position: relative;">
            <input class="Rectangle-29 @error('company_email') is-invalid @enderror" type="email" name="company_email" id="company_email" value="{{ old('company_email', $quotation->company_email) }}" placeholder="Add Mail-Id" required style="padding-right: 100px;">
            <button type="button" onclick="generateEmail()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
          </div>
          @error('company_email')
              <small class="hrp-error">{{ $message }}</small>
          @enderror
        </div>
        <div>
          <label class="hrp-label">Company Password: <span class="text-red-500">*</span></label>
          <div style="position: relative;">
            <input class="Rectangle-29 @error('company_password') is-invalid @enderror" type="text" name="company_password" id="company_password" placeholder="Enter Company Password" value="{{ old('company_password', $quotation->company_password) }}" required style="padding-right: 100px;">
            <button type="button" onclick="generatePassword()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #3b82f6; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
          </div>
          @error('company_password')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div>

      <!-- Employee Credentials Section -->
      {{-- <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
        <div>
          <label class="hrp-label">Company Employee Email: <span style="color: #6b7280; font-size: 12px;">(Optional)</span></label>
          <div style="position: relative;">
            <input class="Rectangle-29 @error('company_employee_email') is-invalid @enderror" type="email" name="company_employee_email" id="company_employee_email" placeholder="Auto-generated email (optional)" value="{{ old('company_employee_email', $quotation->company_employee_email) }}" style="padding-right: 100px;">
            <button type="button" onclick="generateEmployeeEmailEdit()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
          </div>
          @error('company_employee_email')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
        <div>
          <label class="hrp-label">Company Employee Password: <span style="color: #6b7280; font-size: 12px;">(Optional)</span></label>
          <div style="position: relative;">
            <input class="Rectangle-29 @error('company_employee_password') is-invalid @enderror" type="text" name="company_employee_password" id="company_employee_password" placeholder="Auto-generated password (optional)" value="{{ old('company_employee_password', $quotation->company_employee_password) }}" style="padding-right: 100px;">
            <button type="button" onclick="generateEmployeePasswordEdit()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
          </div>
          @error('company_employee_password')<small class="hrp-error">{{ $message }}</small>@enderror
        </div>
      </div> --}}

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
      // Map form field names to database column names (corrected mapping)
      $features = [
          'sample_management' => ['label' => 'Sample Management', 'db' => 'sample_management'],
          'user_friendly_interface' => ['label' => 'User-Friendly Interface', 'db' => 'user_friendly_interface'],
          'contact_management' => ['label' => 'Contact Management', 'db' => 'contact_management'],
          'test_management' => ['label' => 'Test Management', 'db' => 'test_management'],
          'employee_management' => ['label' => 'Employee Management', 'db' => 'employee_management'],
          'lead_opportunity_management' => ['label' => 'Lead and Opportunity Management', 'db' => 'lead_opportunity_management'],
          'data_integrity_security' => ['label' => 'Data Integrity and Security', 'db' => 'data_integrity_security'],
          'recruitment_onboarding' => ['label' => 'Recruitment and Onboarding', 'db' => 'recruitment_onboarding'],
          'sales_automation' => ['label' => 'Sales Automation', 'db' => 'sales_automation'],
          'reporting_analytics' => ['label' => 'Reporting and Analytics', 'db' => 'reporting_analytics'],
          'payroll_management' => ['label' => 'Payroll Management', 'db' => 'payroll_management'],
          'customer_service_management' => ['label' => 'Customer Service Management', 'db' => 'customer_service_management'],
          'inventory_management' => ['label' => 'Inventory Management', 'db' => 'inventory_management'],
          'training_development' => ['label' => 'Training and Development', 'db' => 'training_development'],
          'integration_capabilities_lab' => ['label' => 'Integration Capabilities (Lab)', 'db' => 'integration_lab'],
          'employee_self_service' => ['label' => 'Employee Self-Service Portal', 'db' => 'employee_self_service_portal'],
          'marketing_automation' => ['label' => 'Marketing Automation', 'db' => 'marketing_automation'],
          'regulatory_compliance' => ['label' => 'Regulatory Compliance', 'db' => 'regulatory_compliance'],
          'analytics_reporting' => ['label' => 'Analytics and Reporting', 'db' => 'analytics_reporting'],
          'integration_capabilities_crm' => ['label' => 'Integration Capabilities (CRM)', 'db' => 'integration_crm'],
          'workflow_automation' => ['label' => 'Workflow Automation', 'db' => 'workflow_automation'],
          'integration_capabilities_hr' => ['label' => 'Integration Capabilities (HR)', 'db' => 'integration_hr']
      ];
      @endphp

      @foreach($features as $key => $feature)
      @php
        $dbColumn = $feature['db'];
        $isChecked = (bool)($quotation->$dbColumn ?? false);
        
        // Debug: Log the checkbox values
        // error_log("Checkbox {$key} ({$dbColumn}): " . ($isChecked ? 'true' : 'false'));
      @endphp
      <label style="display: flex; align-items: center; cursor: pointer;" class="custom-checkbox">
        <input type="checkbox" name="features[]" value="{{ $key }}" style="display: none;" 
               {{ $isChecked ? 'checked' : '' }}>
        <div class="checkbox-box" style="width: 16px; height: 16px; border: 2px solid #000; background: {{ $isChecked ? '#000' : 'white' }}; margin-right: 8px; display: flex; align-items: center; justify-content: center;">
          <span class="checkmark" style="color: white; font-size: 12px; font-weight: bold; display: {{ $isChecked ? 'block' : 'none' }};">✓</span>
        </div>
        {{ $feature['label'] }}
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
  <div id="services-section" class="Rectangle-30 hrp-compact @if(session('error') && str_contains(session('error'), 'service')) service-error @endif" style="@if(session('error') && str_contains(session('error'), 'service')) border: 2px solid #dc3545; @endif">
    @if(session('error') && str_contains(session('error'), 'service'))
      <div style="background: #fee; border-left: 4px solid #dc3545; padding: 12px; margin-bottom: 15px; border-radius: 4px;">
        <small class="hrp-error" style="font-size: 14px; font-weight: 600;">{{ session('error') }}</small>
      </div>
    @endif
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
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 @if(session('error') && str_contains(session('error'), 'service')) is-invalid @endif" name="services_1[description][]" value="{{ $description }}" style="border: none; background: transparent;"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 quantity @if(session('error') && str_contains(session('error'), 'service')) is-invalid @endif" type="number" name="services_1[quantity][]" value="{{ $quotation->service_quantity[$index] ?? '' }}" style="border: none; background: transparent;" oninput="calculateRowTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 rate @if(session('error') && str_contains(session('error'), 'service')) is-invalid @endif" type="number" name="services_1[rate][]" value="{{ $quotation->service_rate[$index] ?? '' }}" style="border: none; background: transparent;" oninput="calculateRowTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 total" type="number" name="services_1[total][]" value="{{ $quotation->service_total[$index] ?? '' }}" style="border: none; background: transparent;" readonly></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><button type="button" class="remove-row" style="background: #dc3545; color: white; border: none; border-radius: 50%; width: 24px; height: 24px;">×</button></td>
          </tr>
          @endforeach
        @else
          <tr>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 @if(session('error') && str_contains(session('error'), 'service')) is-invalid @endif" name="services_1[description][]" placeholder="Enter Description" style="border: none; background: transparent;"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 quantity @if(session('error') && str_contains(session('error'), 'service')) is-invalid @endif" type="number" name="services_1[quantity][]" placeholder="Enter Quantity" style="border: none; background: transparent;" oninput="calculateRowTotal(this)"></td>
            <td style="padding: 12px; border-bottom: 1px solid #eee;"><input class="Rectangle-29 rate @if(session('error') && str_contains(session('error'), 'service')) is-invalid @endif" type="number" name="services_1[rate][]" placeholder="Enter Rate" style="border: none; background: transparent;" oninput="calculateRowTotal(this)"></td>
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
  <div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 20px;">
    <button type="button" onclick="recalculateAllServices2()" style="padding: 8px 15px; background: #3b82f6; color: white; border: none; border-radius: 4px; font-size: 12px; cursor: pointer;" title="Recalculate All Payment Terms">↻ Recalculate</button>
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
        <label class="hrp-label">Services Total Amount:</label>
        <div style="display: flex; gap: 10px; align-items: center;">
          <input type="text" class="Rectangle-29" id="services_total_amount" name="services_total_amount" placeholder="Auto-calculated" readonly value="{{ old('services_total_amount') }}" style="background-color: #f3f4f6; font-weight: 600; flex: 1;">
          <button type="button" onclick="calculateServicesTotalAmount()" style="padding: 8px 12px; background: #3b82f6; color: white; border: none; border-radius: 4px; font-size: 12px; cursor: pointer;" title="Recalculate Services Total">↻</button>
        </div>
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
      <input type="text" class="Rectangle-29 date-picker" name="amc_start_date" placeholder="dd/mm/yyyy" value="{{ old('amc_start_date', $quotation->amc_start_date ? $quotation->amc_start_date->format('d/m/Y') : '') }}" autocomplete="off">
    </div>
    <div>
      <label class="hrp-label">AMC Amount:</label>
      <input class="Rectangle-29" name="amc_amount" placeholder="Enter Amount" value="{{ old('amc_amount', $quotation->amc_amount) }}">
    </div>
    <div>
      <label class="hrp-label">Project Start Date:</label>
      <input type="text" class="Rectangle-29 date-picker" name="project_start_date" placeholder="dd/mm/yyyy" value="{{ old('project_start_date', $quotation->project_start_date ? $quotation->project_start_date->format('d/m/Y') : '') }}" autocomplete="off">
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
      <label class="hrp-label">Retention %:</label>
      <input class="Rectangle-29" id="retention_percent" name="retention_percent" type="number" min="0" max="100" step="0.1" placeholder="Enter %" oninput="calculateRetentionAmount()" value="{{ old('retention_percent', $quotation->retention_percent) }}">
    </div>
    <div>
      <label class="hrp-label">Retention Amount:</label>
      <input id="retention_amount" class="Rectangle-29" name="retention_amount" placeholder="Enter Amount" readonly value="{{ old('retention_amount', $quotation->retention_amount) }}">
    </div>
    
    <div>
      <label class="hrp-label">Tentative Complete Date:</label>
      <input type="text" class="Rectangle-29 date-picker" name="tentative_complete_date" placeholder="dd/mm/yyyy" value="{{ old('tentative_complete_date', $quotation->tentative_complete_date ? $quotation->tentative_complete_date->format('d/m/Y') : '') }}" autocomplete="off">
    </div>
    <div></div>
    <div></div>
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
              value="{{ old('mobile_no', strip_country_code($quotation->mobile_no)) }}"
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
              value="{{ old('prepared_by', $quotation->prepared_by) }}"
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
                <option value="Male" {{ old('prepared_by_gender', $quotation->prepared_by_gender) == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('prepared_by_gender', $quotation->prepared_by_gender) == 'Female' ? 'selected' : '' }}>Female</option>
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
              value="{{ old('footer_company_name', $quotation->own_company_name ?? 'CHITRI INFOTECH PVT LTD') }}"
              style="font-size: 14px; line-height: 1.5;">
            @error('footer_company_name')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
        </div>
      </div>
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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
//
// ---------------------------------------------------------------------
// STATE-CITY DEPENDENT DROPDOWN DATA
// ---------------------------------------------------------------------
//

// Function to toggle "Other" text input visibility
function toggleOtherInput(selectElement, otherInput) {
    if (!otherInput) return;
    
    if (selectElement.value === 'other') {
        otherInput.style.display = 'block';
        otherInput.required = selectElement.required;
    } else {
        otherInput.style.display = 'none';
        otherInput.required = false;
        otherInput.value = '';
    }
}

// Function to populate cities based on selected state
function populateCities(stateValue, selectedCity = null) {
    const citySelect = document.getElementById('city_select');
    const cityOtherInput = document.getElementById('city_other_input');
    if (!citySelect) return;
    
    // Clear existing options
    citySelect.innerHTML = '<option value="" disabled selected>SELECT CITY</option>';
    
    // Hide city other input when state changes
    if (cityOtherInput) {
        cityOtherInput.style.display = 'none';
        cityOtherInput.value = '';
    }
    
    if (stateValue && stateCityData[stateValue]) {
        const cities = stateCityData[stateValue];
        cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city.value;
            option.textContent = city.label;
            if (selectedCity && city.value === selectedCity) {
                option.selected = true;
            }
            citySelect.appendChild(option);
        });
        
        // If selected city is "other", show the other input
        if (selectedCity === 'other' && cityOtherInput) {
            cityOtherInput.style.display = 'block';
        }
    }
}

// Initialize state-city dropdown on page load with "Other" text box support
document.addEventListener('DOMContentLoaded', function() {
    const stateSelect = document.getElementById('state_select');
    const citySelect = document.getElementById('city_select');
    const stateOtherInput = document.getElementById('state_other_input');
    const cityOtherInput = document.getElementById('city_other_input');
    const oldCity = document.getElementById('old_city')?.value;
    
    if (stateSelect) {
        // If state is already selected (e.g., from old input or existing data), populate cities and show other inputs
        if (stateSelect.value) {
            // Show state other input if "other" is selected
            if (stateOtherInput) {
                toggleOtherInput(stateSelect, stateOtherInput);
            }
            populateCities(stateSelect.value, oldCity);
        }
        
        // Add change event listener for state
        stateSelect.addEventListener('change', function() {
            // Toggle state other input
            if (stateOtherInput) {
                toggleOtherInput(this, stateOtherInput);
            }
            populateCities(this.value);
        });
    }
    
    // Add change event listener for city "Other" option
    if (citySelect) {
        citySelect.addEventListener('change', function() {
            if (cityOtherInput) {
                toggleOtherInput(this, cityOtherInput);
            }
        });
    }

    // Scroll to services section if there's a service validation error
    const servicesSection = document.getElementById('services-section');
    if (servicesSection && servicesSection.classList.contains('service-error')) {
        setTimeout(function() {
            servicesSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
            // Focus on the first service input
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

// Copy all JavaScript functions from create.blade.php
function calculateRowTotal(input) {
    const row = input.closest('tr');
    const percentInput = row.querySelector('.completion-percent');
    
    // Check if this is services_2 table (has completion-percent)
    const isServices2 = percentInput !== null;
    
    if (isServices2 && percentInput && percentInput.value) {
        // For services_2, prioritize percentage-based calculation
        calculatePercentageAmount(percentInput);
    } else {
        // For services_1 or services_2 without percentage, use quantity * rate
        const quantity = parseFloat(row.querySelector('.quantity')?.value) || 0;
        const rate = parseFloat(row.querySelector('.rate')?.value) || 0;
        const total = quantity * rate;
        const totalInput = row.querySelector('.total');
        if (totalInput) {
            totalInput.value = total.toFixed(2);
        }
    }
    
    // Recalculate contract amount and services total
    calculateContractAmount();
    
    // Only recalculate services total if this is services_2 table
    if (isServices2) {
        calculateServicesTotalAmount();
    }
}

function calculateContractAmount() {
    // Check if premium section is visible
    const premiumSection = document.getElementById('premiumSection');
    if (premiumSection && premiumSection.style.display === 'block') {
        updateContractAmountWithPremium();
    } else {
        let total = 0;
        // Calculate total from services_1 table only (main services)
        document.querySelectorAll('.services-table-1 .total').forEach(i => {
            const value = parseFloat(i.value) || 0;
            if (value > 0) {
                total += value;
            }
        });
        
        const contractAmountField = document.getElementById('contract_amount');
        const hiddenContractAmountField = document.getElementById('hidden_contract_amount');
        
        if (contractAmountField) {
            contractAmountField.value = total.toFixed(2);
        }
        if (hiddenContractAmountField) {
            hiddenContractAmountField.value = total.toFixed(2);
        }
        
        console.log('Contract Amount calculated:', total);
        
        // Recalculate all percentage-based amounts in services_2
        document.querySelectorAll('.services-table-2 .completion-percent').forEach(input => {
            if (input.value) calculatePercentageAmount(input);
        });
        
        // Recalculate retention amount
        calculateRetentionAmount();
        
        // Recalculate services total amount with a small delay to ensure all calculations are complete
        setTimeout(function() {
            calculateServicesTotalAmount();
        }, 10);
    }
}

function calculateBasicTotal(input) {
    const row = input.closest('tr');
    const quantity = parseFloat(row.querySelector('.basic-quantity')?.value) || 0;
    const rate = parseFloat(row.querySelector('.basic-rate')?.value) || 0;
    row.querySelector('.basic-total').value = (quantity * rate).toFixed(2);
    calculateBasicCostTotal();
    
    // Recalculate contract amount since basic costs affect premium total
    const premiumSection = document.getElementById('premiumSection');
    if (premiumSection && premiumSection.style.display === 'block') {
        updateContractAmountWithPremium();
    }
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
    
    // Recalculate contract amount since additional costs affect premium total
    const premiumSection = document.getElementById('premiumSection');
    if (premiumSection && premiumSection.style.display === 'block') {
        updateContractAmountWithPremium();
    }
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
    
    // Recalculate contract amount since maintenance costs affect premium total
    const premiumSection = document.getElementById('premiumSection');
    if (premiumSection && premiumSection.style.display === 'block') {
        updateContractAmountWithPremium();
    }
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
    
    // Recalculate Services Total Amount after updating totals
    calculateServicesTotalAmount();
}

function recalculateAllServices2() {
    console.log('Manually recalculating all services_2 calculations...');
    
    // First recalculate contract amount
    calculateContractAmount();
    
    // Then recalculate all percentage-based amounts with a small delay
    setTimeout(function() {
        document.querySelectorAll('.services-table-2 .completion-percent').forEach(input => {
            if (input.value && parseFloat(input.value) > 0) {
                calculatePercentageAmount(input);
            }
        });
        
        // Finally recalculate services total amount
        setTimeout(function() {
            calculateServicesTotalAmount();
            console.log('Manual recalculation completed');
        }, 50);
    }, 50);
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
    
    // Recalculate services total amount
    calculateServicesTotalAmount();
}

function calculateServicesTotalAmount() {
    let servicesTotal = 0;
    let totalCount = 0;
    
    // Sum ONLY totals from services_2 table (Service Terms with Completion %)
    const services2Totals = document.querySelectorAll('.services-table-2 tbody .total');
    services2Totals.forEach(input => {
        if (input && input.value !== undefined) {
            const value = parseFloat(input.value) || 0;
            if (value > 0) {
                servicesTotal += value;
                totalCount++;
            }
        }
    });
    
    // Update the Services Total Amount field if it exists
    const servicesTotalField = document.getElementById('services_total_amount');
    if (servicesTotalField) {
        servicesTotalField.value = '₹ ' + servicesTotal.toFixed(2);
        console.log('Services Total Amount updated to:', servicesTotalField.value);
    } else {
        console.error('Services Total Amount field not found!');
    }
    
    console.log('Services Total Amount calculated:', servicesTotal, 'from', totalCount, 'valid inputs out of', services2Totals.length, 'total inputs');
}

function calculateTotalPremiumCost() {
    let total = 0;
    
    // Basic cost total
    document.querySelectorAll('.basic-total').forEach(i => total += parseFloat(i.value) || 0);
    
    // Additional cost total
    document.querySelectorAll('.additional-total').forEach(i => total += parseFloat(i.value) || 0);
    
    // Maintenance cost total
    document.querySelectorAll('.maintenance-total').forEach(i => total += parseFloat(i.value) || 0);
    
    return total;
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
    
    // Debug: Check custom terms textarea before submission
    const customTermsTextarea = form.querySelector('textarea[name="custom_terms_text"]');
    console.log('=== CUSTOM TERMS DEBUG ===');
    console.log('Custom terms textarea found:', !!customTermsTextarea);
    console.log('Custom terms textarea value:', customTermsTextarea?.value);
    
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
        if (e.target.classList.contains('remove-basic-row')) {
            e.target.closest('tr').remove();
            calculateBasicCostTotal();
            // Recalculate contract amount since basic costs affect premium total
            const premiumSection = document.getElementById('premiumSection');
            if (premiumSection && premiumSection.style.display === 'block') {
                updateContractAmountWithPremium();
            } else {
                calculateContractAmount();
            }
        }
        if (e.target.classList.contains('remove-additional-row')) {
            e.target.closest('tr').remove();
            calculateAdditionalCostTotal();
            // Recalculate contract amount since additional costs affect premium total
            const premiumSection = document.getElementById('premiumSection');
            if (premiumSection && premiumSection.style.display === 'block') {
                updateContractAmountWithPremium();
            } else {
                calculateContractAmount();
            }
        }
        if (e.target.classList.contains('remove-maintenance-row')) {
            e.target.closest('tr').remove();
            calculateMaintenanceCostTotal();
            // Recalculate contract amount since maintenance costs affect premium total
            const premiumSection = document.getElementById('premiumSection');
            if (premiumSection && premiumSection.style.display === 'block') {
                updateContractAmountWithPremium();
            } else {
                calculateContractAmount();
            }
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

    // Initial calculations - recalculate all existing values
    // Recalculate services_1 totals
    document.querySelectorAll('.services-table-1 tbody tr').forEach(row => {
        const quantity = parseFloat(row.querySelector('.quantity')?.value) || 0;
        const rate = parseFloat(row.querySelector('.rate')?.value) || 0;
        const totalInput = row.querySelector('.total');
        if (totalInput && (quantity > 0 || rate > 0)) {
            totalInput.value = (quantity * rate).toFixed(2);
        }
    });
    
    // Recalculate services_2 totals
    document.querySelectorAll('.services-table-2 tbody tr').forEach(row => {
        const quantity = parseFloat(row.querySelector('.quantity')?.value) || 0;
        const rate = parseFloat(row.querySelector('.rate')?.value) || 0;
        const totalInput = row.querySelector('.total');
        if (totalInput && (quantity > 0 || rate > 0)) {
            totalInput.value = (quantity * rate).toFixed(2);
        }
    });
    
    // Calculate contract amount first
    calculateContractAmount();
    
    // Then calculate services total amount with a small delay to ensure all totals are updated
    setTimeout(function() {
        calculateServicesTotalAmount();
    }, 50);
    calculateBasicCostTotal();
    calculateAdditionalCostTotal();
    calculateMaintenanceCostTotal();
    
    // Check if premium section should be visible (if there are existing premium costs)
    setTimeout(function() {
        const premiumSection = document.getElementById('premiumSection');
        const premiumBtn = document.querySelector('.premium-quotation-btn');
        
        if (premiumSection && premiumBtn) {
            // Check if any premium tables have data
            let hasData = false;
            let totalPremiumCost = 0;
            
            // Check basic costs
            document.querySelectorAll('.basic-total').forEach(input => {
                const value = parseFloat(input.value) || 0;
                if (value > 0) {
                    hasData = true;
                    totalPremiumCost += value;
                }
            });
            
            // Check additional costs
            document.querySelectorAll('.additional-total').forEach(input => {
                const value = parseFloat(input.value) || 0;
                if (value > 0) {
                    hasData = true;
                    totalPremiumCost += value;
                }
            });
            
            // Check maintenance costs
            document.querySelectorAll('.maintenance-total').forEach(input => {
                const value = parseFloat(input.value) || 0;
                if (value > 0) {
                    hasData = true;
                    totalPremiumCost += value;
                }
            });
            
            console.log('Premium costs found:', totalPremiumCost, 'hasData:', hasData);
            
            if (hasData) {
                premiumSection.style.display = 'block';
                premiumBtn.textContent = 'Hide Premium';
                premiumBtn.style.background = '#dc3545';
                // Recalculate with premium
                updateContractAmountWithPremium();
                console.log('Premium section shown and contract amount updated');
            }
        }
        
        // Force recalculate Services Total Amount after everything is loaded
        setTimeout(function() {
            calculateServicesTotalAmount();
            console.log('Final Services Total Amount calculation completed');
        }, 100);
    }, 200);
});

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
    const emailPrefix = companyName.replace(/[^a-zA-Z0-9]/g, '').toLowerCase();
    const randomNum = Math.floor(100 + Math.random() * 900);
    const email = emailPrefix + randomNum + '@example.com';
    
    emailInput.value = email;
    
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
    const prefix = companyName.replace(/[^a-zA-Z]/g, '').substring(0, 3).toLowerCase();
    const randomNum = Math.floor(1000 + Math.random() * 9000);
    const specialChars = ['@', '#', '$', '!'];
    const specialChar = specialChars[Math.floor(Math.random() * specialChars.length)];
    const password = prefix + randomNum + specialChar;
    
    passwordInput.value = password;
    
    Swal.fire({
        icon: 'success',
        title: 'Password Generated!',
        html: `<p>Password: <strong style="color: #3b82f6; font-size: 18px;">${password}</strong></p><p style="color: #6b7280; font-size: 13px; margin-top: 10px;">Please save this password securely.</p>`,
        confirmButtonColor: '#3b82f6',
        width: '400px'
    });
}

// Auto-generate employee email
function generateEmployeeEmailEdit() {
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

// Auto-generate employee password
function generateEmployeePasswordEdit() {
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