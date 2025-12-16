@extends('layouts.macos')
@section('page_title', 'Edit Company')
@section('content')
  <div class="hrp-card">
    <div class="hrp-card-body">
      <div class="Rectangle-30 hrp-compact">
        <form method="POST" action="{{ route('companies.update', $company->id) }}" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5" id="companyForm">
          @csrf
          @method('PUT')
          
          <div class="md:col-span-2" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 8px;">
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Unique Code</label>
              <input name="unique_code" value="{{ old('unique_code', $company->unique_code) }}" class="hrp-input Rectangle-29" readonly style="font-size: 14px; line-height: 1.5; background-color: #f3f4f6;">
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">GST Number</label>
              <input name="gst_no" type="text" placeholder="e.g., 22ABCDE1234F1Z5" value="{{ old('gst_no', $company->gst_no) }}" class="hrp-input Rectangle-29" maxlength="15" style="text-transform: uppercase; font-size: 14px; line-height: 1.5;" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 15)" pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9A-Z]{1}[Z]{1}[0-9A-Z]{1}" title="Enter valid 15-character GST No. (e.g., 22ABCDE1234F1Z5)">
              @error('gst_no')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">PAN Number</label>
              <input name="pan_no" type="text" placeholder="e.g., ABCDE1234F" value="{{ old('pan_no', $company->pan_no) }}" class="hrp-input Rectangle-29" maxlength="10" style="text-transform: uppercase; font-size: 14px; line-height: 1.5;" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 10)" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" title="Enter valid 10-character PAN No. (e.g., ABCDE1234F)">
              @error('pan_no')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Name</label>
            <input name="company_name" type="text" placeholder="Enter your company name" value="{{ old('company_name', $company->company_name) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            @error('company_name')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Address</label>
            <textarea name="company_address" placeholder="Enter Your Address" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" rows="3" style="font-size: 14px; line-height: 1.5; resize: vertical;">{{ old('company_address', $company->company_address) }}</textarea>
            @error('company_address')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div class="mb-2">
            <label class="hrp-label"
                style="font-weight:500; margin-bottom:8px; display:block; color:#374151; font-size:14px;">
                Company Type
            </label>

            <div class="relative">
                <select name="company_type" class="hrp-input Rectangle-29"
                    style="padding-right:32px; appearance:none; background-repeat:no-repeat;
                    background-position:right 12px center; background-size:16px;
                    cursor:pointer; width:100%;
                    background-image:url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%236b7280\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpolyline points=\'6 9 12 15 18 9\'/%3E%3C/svg%3E');">

                    <option value="" disabled {{ old('company_type', $company->company_type) ? '' : 'selected' }}>SELECT COMPANY TYPE</option>
                    <option value="INFORMATION_TECHNOLOGY" {{ old('company_type', $company->company_type) == 'INFORMATION_TECHNOLOGY' ? 'selected' : '' }}>Information Technology (IT)</option>
                    <option value="SOFTWARE_DEVELOPMENT" {{ old('company_type', $company->company_type) == 'SOFTWARE_DEVELOPMENT' ? 'selected' : '' }}>Software Development</option>
                    <option value="HARDWARE_ELECTRONICS" {{ old('company_type', $company->company_type) == 'HARDWARE_ELECTRONICS' ? 'selected' : '' }}>Hardware & Electronics</option>
                    <option value="TELECOMMUNICATIONS" {{ old('company_type', $company->company_type) == 'TELECOMMUNICATIONS' ? 'selected' : '' }}>Telecommunications</option>
                    <option value="E_COMMERCE" {{ old('company_type', $company->company_type) == 'E_COMMERCE' ? 'selected' : '' }}>E-Commerce</option>
                    <option value="MANUFACTURING" {{ old('company_type', $company->company_type) == 'MANUFACTURING' ? 'selected' : '' }}>Manufacturing</option>
                    <option value="AUTOMOBILE" {{ old('company_type', $company->company_type) == 'AUTOMOBILE' ? 'selected' : '' }}>Automobile</option>
                    <option value="AEROSPACE_DEFENSE" {{ old('company_type', $company->company_type) == 'AEROSPACE_DEFENSE' ? 'selected' : '' }}>Aerospace & Defense</option>
                    <option value="CONSTRUCTION_INFRASTRUCTURE" {{ old('company_type', $company->company_type) == 'CONSTRUCTION_INFRASTRUCTURE' ? 'selected' : '' }}>Construction & Infrastructure</option>
                    <option value="REAL_ESTATE" {{ old('company_type', $company->company_type) == 'REAL_ESTATE' ? 'selected' : '' }}>Real Estate</option>
                    <option value="BANKING_FINANCIAL" {{ old('company_type', $company->company_type) == 'BANKING_FINANCIAL' ? 'selected' : '' }}>Banking & Financial Services</option>
                    <option value="INSURANCE" {{ old('company_type', $company->company_type) == 'INSURANCE' ? 'selected' : '' }}>Insurance</option>
                    <option value="INVESTMENT_ASSET" {{ old('company_type', $company->company_type) == 'INVESTMENT_ASSET' ? 'selected' : '' }}>Investment & Asset Management</option>
                    <option value="HEALTHCARE" {{ old('company_type', $company->company_type) == 'HEALTHCARE' ? 'selected' : '' }}>Healthcare</option>
                    <option value="PHARMACEUTICALS" {{ old('company_type', $company->company_type) == 'PHARMACEUTICALS' ? 'selected' : '' }}>Pharmaceuticals</option>
                    <option value="BIOTECHNOLOGY" {{ old('company_type', $company->company_type) == 'BIOTECHNOLOGY' ? 'selected' : '' }}>Biotechnology</option>
                    <option value="MEDICAL_DEVICES" {{ old('company_type', $company->company_type) == 'MEDICAL_DEVICES' ? 'selected' : '' }}>Medical Devices</option>
                    <option value="EDUCATION_TRAINING" {{ old('company_type', $company->company_type) == 'EDUCATION_TRAINING' ? 'selected' : '' }}>Education & Training</option>
                    <option value="RETAIL" {{ old('company_type', $company->company_type) == 'RETAIL' ? 'selected' : '' }}>Retail</option>
                    <option value="WHOLESALE_DISTRIBUTION" {{ old('company_type', $company->company_type) == 'WHOLESALE_DISTRIBUTION' ? 'selected' : '' }}>Wholesale & Distribution</option>
                    <option value="LOGISTICS_SUPPLY" {{ old('company_type', $company->company_type) == 'LOGISTICS_SUPPLY' ? 'selected' : '' }}>Logistics & Supply Chain</option>
                    <option value="TRANSPORTATION" {{ old('company_type', $company->company_type) == 'TRANSPORTATION' ? 'selected' : '' }}>Transportation (Air, Road, Rail, Sea)</option>
                    <option value="FOOD_BEVERAGE" {{ old('company_type', $company->company_type) == 'FOOD_BEVERAGE' ? 'selected' : '' }}>Food & Beverages</option>
                    <option value="HOSPITALITY" {{ old('company_type', $company->company_type) == 'HOSPITALITY' ? 'selected' : '' }}>Hospitality</option>
                    <option value="TOURISM_TRAVEL" {{ old('company_type', $company->company_type) == 'TOURISM_TRAVEL' ? 'selected' : '' }}>Tourism & Travel</option>
                    <option value="MEDIA_ENTERTAINMENT" {{ old('company_type', $company->company_type) == 'MEDIA_ENTERTAINMENT' ? 'selected' : '' }}>Media & Entertainment</option>
                    <option value="ADVERTISING_MARKETING" {{ old('company_type', $company->company_type) == 'ADVERTISING_MARKETING' ? 'selected' : '' }}>Advertising & Marketing</option>
                    <option value="PUBLISHING" {{ old('company_type', $company->company_type) == 'PUBLISHING' ? 'selected' : '' }}>Publishing</option>
                    <option value="OIL_GAS" {{ old('company_type', $company->company_type) == 'OIL_GAS' ? 'selected' : '' }}>Oil & Gas</option>
                    <option value="MINING_METALS" {{ old('company_type', $company->company_type) == 'MINING_METALS' ? 'selected' : '' }}>Mining & Metals</option>
                    <option value="CHEMICALS" {{ old('company_type', $company->company_type) == 'CHEMICALS' ? 'selected' : '' }}>Chemicals</option>
                    <option value="ENERGY_POWER" {{ old('company_type', $company->company_type) == 'ENERGY_POWER' ? 'selected' : '' }}>Energy & Power</option>
                    <option value="RENEWABLE_ENERGY" {{ old('company_type', $company->company_type) == 'RENEWABLE_ENERGY' ? 'selected' : '' }}>Renewable Energy (Solar, Wind)</option>
                    <option value="AGRICULTURE" {{ old('company_type', $company->company_type) == 'AGRICULTURE' ? 'selected' : '' }}>Agriculture</option>
                    <option value="ENVIRONMENTAL_SERVICES" {{ old('company_type', $company->company_type) == 'ENVIRONMENTAL_SERVICES' ? 'selected' : '' }}>Environmental Services</option>
                    <option value="LEGAL_SERVICES" {{ old('company_type', $company->company_type) == 'LEGAL_SERVICES' ? 'selected' : '' }}>Legal Services</option>
                    <option value="CONSULTING_ADVISORY" {{ old('company_type', $company->company_type) == 'CONSULTING_ADVISORY' ? 'selected' : '' }}>Consulting & Advisory</option>
                    <option value="HUMAN_RESOURCES" {{ old('company_type', $company->company_type) == 'HUMAN_RESOURCES' ? 'selected' : '' }}>Human Resources Services</option>
                    <option value="BPO_KPO" {{ old('company_type', $company->company_type) == 'BPO_KPO' ? 'selected' : '' }}>BPO / KPO</option>
                    <option value="SECURITY_SERVICES" {{ old('company_type', $company->company_type) == 'SECURITY_SERVICES' ? 'selected' : '' }}>Security Services</option>
                    <option value="FASHION_APPAREL" {{ old('company_type', $company->company_type) == 'FASHION_APPAREL' ? 'selected' : '' }}>Fashion & Apparel</option>
                    <option value="TEXTILES" {{ old('company_type', $company->company_type) == 'TEXTILES' ? 'selected' : '' }}>Textiles</option>
                    <option value="SPORTS_FITNESS" {{ old('company_type', $company->company_type) == 'SPORTS_FITNESS' ? 'selected' : '' }}>Sports & Fitness</option>
                    <option value="NON_PROFIT_NGO" {{ old('company_type', $company->company_type) == 'NON_PROFIT_NGO' ? 'selected' : '' }}>Non-Profit / NGO</option>
                    <option value="GOVERNMENT_PUBLIC" {{ old('company_type', $company->company_type) == 'GOVERNMENT_PUBLIC' ? 'selected' : '' }}>Government & Public Sector</option>
                    <option value="OTHER" {{ old('company_type', $company->company_type) == 'OTHER' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            @error('company_type') <small class="hrp-error">{{ $message }}</small> @enderror
          </div>

          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">State</label>
            <div class="relative">
              <select name="state" id="state_select" class="hrp-input Rectangle-29" style="
                padding-right: 32px;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E\");
                background-repeat: no-repeat;
                background-position: right 12px center;
                background-size: 16px 16px;
                cursor: pointer;
                width: 100%;
                text-transform: capitalize;
                font-size: 14px;
                line-height: 1.5;
              ">
                <option value="" disabled {{ old('state', $company->state) ? '' : 'selected' }}>SELECT STATE</option>
                <option value="andhra_pradesh" {{ old('state', $company->state) == 'andhra_pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
                <option value="arunachal_pradesh" {{ old('state', $company->state) == 'arunachal_pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
                <option value="assam" {{ old('state', $company->state) == 'assam' ? 'selected' : '' }}>Assam</option>
                <option value="bihar" {{ old('state', $company->state) == 'bihar' ? 'selected' : '' }}>Bihar</option>
                <option value="chhattisgarh" {{ old('state', $company->state) == 'chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
                <option value="delhi" {{ old('state', $company->state) == 'delhi' ? 'selected' : '' }}>Delhi</option>
                <option value="goa" {{ old('state', $company->state) == 'goa' ? 'selected' : '' }}>Goa</option>
                <option value="gujarat" {{ old('state', $company->state) == 'gujarat' ? 'selected' : '' }}>Gujarat</option>
                <option value="haryana" {{ old('state', $company->state) == 'haryana' ? 'selected' : '' }}>Haryana</option>
                <option value="himachal_pradesh" {{ old('state', $company->state) == 'himachal_pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
                <option value="jammu_kashmir" {{ old('state', $company->state) == 'jammu_kashmir' ? 'selected' : '' }}>Jammu & Kashmir</option>
                <option value="jharkhand" {{ old('state', $company->state) == 'jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                <option value="karnataka" {{ old('state', $company->state) == 'karnataka' ? 'selected' : '' }}>Karnataka</option>
                <option value="kerala" {{ old('state', $company->state) == 'kerala' ? 'selected' : '' }}>Kerala</option>
                <option value="ladakh" {{ old('state', $company->state) == 'ladakh' ? 'selected' : '' }}>Ladakh</option>
                <option value="madhya_pradesh" {{ old('state', $company->state) == 'madhya_pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                <option value="maharashtra" {{ old('state', $company->state) == 'maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                <option value="manipur" {{ old('state', $company->state) == 'manipur' ? 'selected' : '' }}>Manipur</option>
                <option value="meghalaya" {{ old('state', $company->state) == 'meghalaya' ? 'selected' : '' }}>Meghalaya</option>
                <option value="mizoram" {{ old('state', $company->state) == 'mizoram' ? 'selected' : '' }}>Mizoram</option>
                <option value="nagaland" {{ old('state', $company->state) == 'nagaland' ? 'selected' : '' }}>Nagaland</option>
                <option value="odisha" {{ old('state', $company->state) == 'odisha' ? 'selected' : '' }}>Odisha</option>
                <option value="punjab" {{ old('state', $company->state) == 'punjab' ? 'selected' : '' }}>Punjab</option>
                <option value="rajasthan" {{ old('state', $company->state) == 'rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                <option value="sikkim" {{ old('state', $company->state) == 'sikkim' ? 'selected' : '' }}>Sikkim</option>
                <option value="tamil_nadu" {{ old('state', $company->state) == 'tamil_nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                <option value="telangana" {{ old('state', $company->state) == 'telangana' ? 'selected' : '' }}>Telangana</option>
                <option value="tripura" {{ old('state', $company->state) == 'tripura' ? 'selected' : '' }}>Tripura</option>
                <option value="uttar_pradesh" {{ old('state', $company->state) == 'uttar_pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                <option value="uttarakhand" {{ old('state', $company->state) == 'uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
                <option value="west_bengal" {{ old('state', $company->state) == 'west_bengal' ? 'selected' : '' }}>West Bengal</option>
                {{-- Union Territories --}}
                <option value="andaman_nicobar" {{ old('state', $company->state) == 'andaman_nicobar' ? 'selected' : '' }}>Andaman & Nicobar Islands</option>
                <option value="chandigarh" {{ old('state', $company->state) == 'chandigarh' ? 'selected' : '' }}>Chandigarh</option>
                <option value="dadra_nagar_haveli_daman_diu" {{ old('state', $company->state) == 'dadra_nagar_haveli_daman_diu' ? 'selected' : '' }}>Dadra & Nagar Haveli and Daman & Diu</option>
                <option value="lakshadweep" {{ old('state', $company->state) == 'lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
                <option value="puducherry" {{ old('state', $company->state) == 'puducherry' ? 'selected' : '' }}>Puducherry</option>
                <option value="other" {{ old('state', $company->state) == 'other' ? 'selected' : '' }}>Other</option>
              </select>
              <input type="text" name="state_other" id="state_other_input" class="hrp-input Rectangle-29" placeholder="Enter State Name" value="{{ old('state_other', $company->state_other ?? '') }}" style="display: {{ old('state', $company->state) == 'other' ? 'block' : 'none' }}; margin-top: 8px; font-size: 14px; line-height: 1.5;">
              @error('state')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>

          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">City</label>
            <div class="relative">
              <select name="city" id="city_select" class="hrp-input Rectangle-29" style="
                padding-right: 32px;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E\");
                background-repeat: no-repeat;
                background-position: right 12px center;
                background-size: 16px 16px;
                cursor: pointer;
                width: 100%;
                font-size: 14px;
                line-height: 1.5;
              ">
                <option value="" disabled selected>SELECT STATE FIRST</option>
              </select>
              <input type="hidden" id="old_city" value="{{ old('city', $company->city) }}">
              <input type="text" name="city_other" id="city_other_input" class="hrp-input Rectangle-29" placeholder="Enter City Name" value="{{ old('city_other', $company->city_other ?? '') }}" style="display: {{ old('city', $company->city) == 'other' ? 'block' : 'none' }}; margin-top: 8px; font-size: 14px; line-height: 1.5;">
              @error('city')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>

          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Contact Person Name <span class="text-red-500">*</span></label>
            <input name="contact_person_name" type="text" placeholder="Enter Contact Person Name" value="{{ old('contact_person_name', $company->contact_person_name) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            @error('contact_person_name')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Contact Person Position <span class="text-red-500">*</span></label>
            <input name="contact_person_position" placeholder="Enter Contact Person Position" value="{{ old('contact_person_position', $company->contact_person_position) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            @error('contact_person_position')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Contact Person Mobile No <span class="text-red-500">*</span></label>
            <input
              class="hrp-input Rectangle-29"
              name="contact_person_mobile"
              type="tel"
              inputmode="numeric"
              pattern="\d{10}"
              maxlength="10"
              value="{{ old('contact_person_mobile', strip_country_code($company->contact_person_mobile)) }}"
              placeholder="Enter 10 digit mobile number"
              style="font-size: 14px; line-height: 1.5;"
            />
            @error('contact_person_mobile')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Scope Link</label>
            <input name="scope_link" type="url" placeholder="Enter Scope Link" value="{{ old('scope_link', $company->scope_link) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            @error('scope_link')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">SOP Upload</label>
            <div class="upload-pill Rectangle-29" onclick="document.getElementById('sopInput').click()">
              <div class="choose" style="font-size: 14px;">Choose File</div>
              <div class="filename" id="sopFileName" style="font-size: 14px;">{{ $company->sop_upload ? basename($company->sop_upload) : 'No File Chosen' }}</div>
              <input id="sopInput" name="sop_upload" type="file" style="display: none;" onchange="validateSopFileEdit(this)" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
            </div>
            @if($company->sop_upload && $company->sop_url)
              @php
                $sopExtension = strtolower(pathinfo($company->sop_upload, PATHINFO_EXTENSION));
                $sopIsImage = in_array($sopExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
              @endphp
              <div style="margin-top: 10px; padding: 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                <p style="font-size: 12px; color: #64748b; margin: 0 0 8px 0; font-weight: 500;">Current SOP Document:</p>
                @if($sopIsImage)
                  <div style="margin-bottom: 10px;">
                    <img src="{{ $company->sop_url }}" alt="SOP Preview" style="max-width: 150px; max-height: 100px; border-radius: 6px; border: 1px solid #e2e8f0;">
                  </div>
                @endif
                <div style="display: flex; align-items: center; gap: 8px;">
                  <a href="{{ $company->sop_url }}" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; color: #3b82f6; font-size: 13px; text-decoration: none;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View File
                  </a>
                  <span style="color: #94a3b8; font-size: 12px;">({{ strtoupper($sopExtension) }})</span>
                </div>
              </div>
            @endif
            <small id="sopErrorEdit" class="hrp-error" style="display: none;"></small>
            @error('sop_upload')<small class="hrp-error">{{ $message }}</small>@enderror
            <small class="text-gray-500 text-xs block mt-1">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 5MB)</small>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Quotation Upload</label>
            <div class="upload-pill Rectangle-29" onclick="document.getElementById('quotationInput').click()">
              <div class="choose" style="font-size: 14px;">Choose File</div>
              <div class="filename" id="quotationFileName" style="font-size: 14px;">{{ $company->quotation_upload ? basename($company->quotation_upload) : 'No File Chosen' }}</div>
              <input id="quotationInput" name="quotation_upload" type="file" style="display: none;" onchange="validateQuotationFileEdit(this)" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
            </div>
            @if($company->quotation_upload && $company->quotation_url)
              @php
                $quotExtension = strtolower(pathinfo($company->quotation_upload, PATHINFO_EXTENSION));
                $quotIsImage = in_array($quotExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
              @endphp
              <div style="margin-top: 10px; padding: 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                <p style="font-size: 12px; color: #64748b; margin: 0 0 8px 0; font-weight: 500;">Current Quotation Document:</p>
                @if($quotIsImage)
                  <div style="margin-bottom: 10px;">
                    <img src="{{ $company->quotation_url }}" alt="Quotation Preview" style="max-width: 150px; max-height: 100px; border-radius: 6px; border: 1px solid #e2e8f0;">
                  </div>
                @endif
                <div style="display: flex; align-items: center; gap: 8px;">
                  <a href="{{ $company->quotation_url }}" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; color: #3b82f6; font-size: 13px; text-decoration: none;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View File
                  </a>
                  <span style="color: #94a3b8; font-size: 12px;">({{ strtoupper($quotExtension) }})</span>
                </div>
              </div>
            @endif
            <small id="quotationErrorEdit" class="hrp-error" style="display: none;"></small>
            @error('quotation_upload')<small class="hrp-error">{{ $message }}</small>@enderror
            <small class="text-gray-500 text-xs block mt-1">Accepted formats: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG (Max: 5MB)</small>
          </div>
          <div>
            
          </div>

          <!-- Additional Contact Persons Section -->
          <div class="md:col-span-2" style="margin-top: 16px; margin-bottom: 8px;">
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px;">
              <h4 style="font-size: 14px; font-weight: 600; color: #1e293b; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                  <circle cx="9" cy="7" r="4"></circle>
                  <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                  <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                Additional Contact Persons
              </h4>
              
              <!-- Person 1 -->
              <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px dashed #e2e8f0;">
                <div>
                  <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 13px;">Person 1 - Name</label>
                  <input name="person_name_1" placeholder="Enter Name" value="{{ old('person_name_1', $company->person_name_1) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_name_1')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                <div>
                  <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 13px;">Person 1 - Mobile</label>
                  <input name="person_number_1" type="tel" inputmode="numeric" pattern="\d{10}" maxlength="10" placeholder="Enter Mobile Number" value="{{ old('person_number_1', $company->person_number_1) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_number_1')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                <div>
                  <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 13px;">Person 1 - Position</label>
                  <input name="person_position_1" placeholder="Enter Position" value="{{ old('person_position_1', $company->person_position_1) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_position_1')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
              </div>
              
              <!-- Person 2 -->
              <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px dashed #e2e8f0;">
                <div>
                  <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 13px;">Person 2 - Name</label>
                  <input name="person_name_2" placeholder="Enter Name" value="{{ old('person_name_2', $company->person_name_2) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_name_2')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                <div>
                  <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 13px;">Person 2 - Mobile</label>
                  <input name="person_number_2" type="tel" inputmode="numeric" pattern="\d{10}" maxlength="10" placeholder="Enter Mobile Number" value="{{ old('person_number_2', $company->person_number_2) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_number_2')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                <div>
                  <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 13px;">Person 2 - Position</label>
                  <input name="person_position_2" placeholder="Enter Position" value="{{ old('person_position_2', $company->person_position_2) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_position_2')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
              </div>
              
              <!-- Person 3 -->
              <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                <div>
                  <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 13px;">Person 3 - Name</label>
                  <input name="person_name_3" placeholder="Enter Name" value="{{ old('person_name_3', $company->person_name_3) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_name_3')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                <div>
                  <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 13px;">Person 3 - Mobile</label>
                  <input name="person_number_3" type="tel" inputmode="numeric" pattern="\d{10}" maxlength="10" placeholder="Enter Mobile Number" value="{{ old('person_number_3', $company->person_number_3) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_number_3')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                <div>
                  <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 13px;">Person 3 - Position</label>
                  <input name="person_position_3" placeholder="Enter Position" value="{{ old('person_position_3', $company->person_position_3) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_position_3')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
              </div>
            </div>
          </div>
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Logo</label>
            <div class="upload-pill Rectangle-29" onclick="document.getElementById('logoInputEdit').click()" style="cursor: pointer;">
              <div class="choose" style="font-size: 14px;">Choose File</div>
              <div class="filename" id="logoFileNameEdit" style="font-size: 14px;">No File Chosen</div>
              <input id="logoInputEdit" name="company_logo" type="file" accept=".jpeg,.jpg,.png" style="display: none;" onchange="validateLogoFileEdit(this)">
            </div>
            @if($company->company_logo && $company->logo_url)
              <div style="margin-top: 10px; padding: 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;" id="currentLogoEdit">
                <p style="font-size: 12px; color: #64748b; margin: 0 0 8px 0; font-weight: 500;">Current Logo:</p>
                <img src="{{ $company->logo_url }}" alt="Company Logo" style="max-width: 120px; max-height: 80px; border-radius: 6px; border: 1px solid #e2e8f0; object-fit: contain;">
              </div>
            @endif
            <div id="logoPreviewEdit" style="margin-top: 10px; padding: 12px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; display: none;">
              <p style="font-size: 12px; color: #16a34a; margin: 0 0 8px 0; font-weight: 500;">New Logo Preview:</p>
              <img id="logoPreviewImgEdit" src="" alt="Logo Preview" style="max-width: 120px; max-height: 80px; border-radius: 6px; border: 1px solid #bbf7d0; object-fit: contain;">
            </div>
            <small id="logoErrorEdit" class="hrp-error" style="display: none;"></small>
            @error('company_logo')<small class="hrp-error">{{ $message }}</small>@enderror
            <small class="text-gray-500 text-xs" style="display: block; margin-top: 4px;">Accepted formats: JPEG, JPG, PNG (Max: 2MB)</small>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Other Details</label>
            <textarea name="other_details" placeholder="Enter other details" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" rows="3" style="font-size: 14px; line-height: 1.5; resize: vertical;">{{ old('other_details', $company->other_details) }}</textarea>
            @error('other_details')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
           <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Email</label>
            <input name="company_email" type="email" placeholder="Enter Company Email" value="{{ old('company_email', $company->company_email) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            @error('company_email')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Password</label>
            <div style="position: relative;">
              <input name="company_password" id="company_password" type="text" placeholder="Leave blank to keep current password" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5; padding-right: 100px;" autocomplete="new-password">
              <button type="button" onclick="generateCompanyPassword()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #3b82f6; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
            </div>
            @can('Companies Management.edit company')
              @if($company->company_password)
              <small style="color:#6b7280;font-size:12px;display:block;margin-top:4px">Current: <strong>{{ $company->company_password }}</strong></small>
              @endif
            @endcan
            @error('company_password')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Confirm Password</label>
            <input name="company_password_confirmation" id="company_password_confirmation" type="text" placeholder="Confirm Company Password" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;" autocomplete="new-password">
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Employee Email</label>
            <div style="position: relative;">
              <input name="company_employee_email" id="company_employee_email" type="email" placeholder="Enter Company Employee Email" value="{{ old('company_employee_email', $company->company_employee_email) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5; padding-right: 100px;">
              <button type="button" onclick="generateEmployeeEmailEdit()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
            </div>
            @error('company_employee_email')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Employee Password</label>
            <div style="position: relative;">
              <input name="company_employee_password" id="company_employee_password" type="text" placeholder="Leave blank to keep current password" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5; padding-right: 100px;" autocomplete="new-password">
              <button type="button" onclick="generateEmployeePasswordEdit()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
            </div>
            @can('Companies Management.edit company')
              @if($company->company_employee_password)
              <small style="color:#6b7280;font-size:12px;display:block;margin-top:4px">Current: <strong>{{ $company->company_employee_password }}</strong></small>
              @endif
            @endcan
            @error('company_employee_password')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Confirm Employee Password</label>
            <input name="company_employee_password_confirmation" id="company_employee_password_confirmation" type="text" placeholder="Confirm Employee Password" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;" autocomplete="new-password">
          </div> 
          
          <div class="md:col-span-2">
          <div class="hrp-actions" style="gap:8px">
            <a href="{{ route('companies.index') }}" class="hrp-btn" style="background:#e5e7eb">Cancel</a>
            <button class="hrp-btn hrp-btn-primary">Update Company</button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
// SOP FILE VALIDATION FUNCTION FOR EDIT
function validateSopFileEdit(input) {
    const sopFileName = document.getElementById('sopFileName');
    const sopError = document.getElementById('sopErrorEdit');
    
    // Reset error
    sopError.style.display = 'none';
    sopError.textContent = '';
    
    if (!input.files || !input.files[0]) {
        sopFileName.textContent = 'No File Chosen';
        return;
    }
    
    const file = input.files[0];
    const fileName = file.name;
    const fileSize = file.size;
    const maxSize = 5 * 1024 * 1024; // 5MB
    const allowedExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
    
    // Get file extension
    const extension = fileName.split('.').pop().toLowerCase();
    
    // Validate file type
    if (!allowedExtensions.includes(extension)) {
        sopError.textContent = 'Invalid file type. Only PDF, DOC, DOCX, JPG, JPEG, and PNG files are allowed.';
        sopError.style.display = 'block';
        input.value = '';
        sopFileName.textContent = 'No File Chosen';
        return;
    }
    
    // Validate file size
    if (fileSize > maxSize) {
        const sizeMB = (fileSize / 1024 / 1024).toFixed(2);
        sopError.textContent = `File size (${sizeMB}MB) exceeds the maximum allowed size of 5MB.`;
        sopError.style.display = 'block';
        input.value = '';
        sopFileName.textContent = 'No File Chosen';
        return;
    }
    
    // Update filename display
    sopFileName.textContent = fileName;
}

// QUOTATION FILE VALIDATION FUNCTION FOR EDIT
function validateQuotationFileEdit(input) {
    const quotationFileName = document.getElementById('quotationFileName');
    const quotationError = document.getElementById('quotationErrorEdit');
    
    // Reset error
    quotationError.style.display = 'none';
    quotationError.textContent = '';
    
    if (!input.files || !input.files[0]) {
        quotationFileName.textContent = 'No File Chosen';
        return;
    }
    
    const file = input.files[0];
    const fileName = file.name;
    const fileSize = file.size;
    const maxSize = 5 * 1024 * 1024; // 5MB
    const allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png'];
    
    // Get file extension
    const extension = fileName.split('.').pop().toLowerCase();
    
    // Validate file type
    if (!allowedExtensions.includes(extension)) {
        quotationError.textContent = 'Invalid file type. Only PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, and PNG files are allowed.';
        quotationError.style.display = 'block';
        input.value = '';
        quotationFileName.textContent = 'No File Chosen';
        return;
    }
    
    // Validate file size
    if (fileSize > maxSize) {
        const sizeMB = (fileSize / 1024 / 1024).toFixed(2);
        quotationError.textContent = `File size (${sizeMB}MB) exceeds the maximum allowed size of 5MB.`;
        quotationError.style.display = 'block';
        input.value = '';
        quotationFileName.textContent = 'No File Chosen';
        return;
    }
    
    // Update filename display
    quotationFileName.textContent = fileName;
}

// LOGO FILE VALIDATION FUNCTION FOR EDIT
function validateLogoFileEdit(input) {
    const logoFileName = document.getElementById('logoFileNameEdit');
    const logoPreview = document.getElementById('logoPreviewEdit');
    const logoPreviewImg = document.getElementById('logoPreviewImgEdit');
    const logoError = document.getElementById('logoErrorEdit');
    
    // Reset error
    logoError.style.display = 'none';
    logoError.textContent = '';
    
    if (!input.files || !input.files[0]) {
        logoFileName.textContent = 'No File Chosen';
        logoPreview.style.display = 'none';
        return;
    }
    
    const file = input.files[0];
    const fileName = file.name;
    const fileSize = file.size;
    const fileType = file.type;
    const maxSize = 2 * 1024 * 1024; // 2MB
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    const allowedExtensions = ['jpeg', 'jpg', 'png'];
    
    // Get file extension
    const extension = fileName.split('.').pop().toLowerCase();
    
    // Validate file type
    if (!allowedTypes.includes(fileType) && !allowedExtensions.includes(extension)) {
        logoError.textContent = 'Invalid file type. Only JPEG, JPG, and PNG files are allowed.';
        logoError.style.display = 'block';
        input.value = '';
        logoFileName.textContent = 'No File Chosen';
        logoPreview.style.display = 'none';
        return;
    }
    
    // Validate file size
    if (fileSize > maxSize) {
        const sizeMB = (fileSize / 1024 / 1024).toFixed(2);
        logoError.textContent = `File size (${sizeMB}MB) exceeds the maximum allowed size of 2MB.`;
        logoError.style.display = 'block';
        input.value = '';
        logoFileName.textContent = 'No File Chosen';
        logoPreview.style.display = 'none';
        return;
    }
    
    // Update filename display
    logoFileName.textContent = fileName;
    
    // Show image preview
    const reader = new FileReader();
    reader.onload = function(e) {
        logoPreviewImg.src = e.target.result;
        logoPreview.style.display = 'block';
    };
    reader.readAsDataURL(file);
}

// State-City data is loaded from external JS file (state-city-dropdown.js)
// Using the global stateCityData variable

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
        // If state is already selected (e.g., from existing data or old input), populate cities and show other inputs
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
});

  // Function to update file name display
  function updateFileName(input, targetId) {
    const fileName = input.files[0] ? input.files[0].name : 'No File Chosen';
    document.getElementById(targetId).textContent = fileName;
  }

  // Form validation before submission
  document.getElementById('companyForm').addEventListener('submit', function(e) {
    const sopInput = document.getElementById('sopInput');
    const quotationInput = document.getElementById('quotationInput');
    const validFileTypes = {
      'sop': ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/jpg', 'image/png'],
      'quotation': ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'image/jpeg', 'image/jpg', 'image/png']
    };
    let isValid = true;

    // Validate SOP file if selected
    if (sopInput.files.length > 0) {
      const fileType = sopInput.files[0].type;
      if (!validFileTypes.sop.includes(fileType)) {
        alert('Invalid file type for SOP. Please upload a PDF, DOC, DOCX, JPG, JPEG, or PNG file.');
        sopInput.value = '';
        document.getElementById('sopFileName').textContent = 'No File Chosen';
        isValid = false;
      } else if (sopInput.files[0].size > 5 * 1024 * 1024) { // 5MB limit
        alert('SOP file is too large. Maximum size is 5MB.');
        sopInput.value = '';
        document.getElementById('sopFileName').textContent = 'No File Chosen';
        isValid = false;
      }
    }

    // Validate Quotation file if selected
    if (quotationInput.files.length > 0) {
      const fileType = quotationInput.files[0].type;
      if (!validFileTypes.quotation.includes(fileType)) {
        alert('Invalid file type for Quotation. Please upload a PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, or PNG file.');
        quotationInput.value = '';
        document.getElementById('quotationFileName').textContent = 'No File Chosen';
        isValid = false;
      } else if (quotationInput.files[0].size > 5 * 1024 * 1024) { // 5MB limit
        alert('Quotation file is too large. Maximum size is 5MB.');
        quotationInput.value = '';
        document.getElementById('quotationFileName').textContent = 'No File Chosen';
        isValid = false;
      }
    }

    if (!isValid) {
      e.preventDefault();
      return false;
    }
  });

  // Auto-generate company password
  function generateCompanyPassword() {
    const companyNameInput = document.querySelector('input[name="company_name"]');
    const passwordInput = document.getElementById('company_password');
    const confirmPasswordInput = document.getElementById('company_password_confirmation');
    
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
    confirmPasswordInput.value = password;
    
    // Show success message
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
    const confirmPasswordInput = document.getElementById('company_employee_password_confirmation');
    
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
    confirmPasswordInput.value = password;
    
    // Show success message
    Swal.fire({
      icon: 'success',
      title: 'Employee Password Generated!',
      html: `<p>Password: <strong style="color: #10b981; font-size: 18px;">${password}</strong></p><p style="color: #6b7280; font-size: 13px; margin-top: 10px;">Please save this password securely.</p>`,
      confirmButtonColor: '#10b981',
      width: '400px'
    });
  }

  // Existing code
  (function(){
    // Add any necessary JavaScript here
  })();
</script>
@endpush
