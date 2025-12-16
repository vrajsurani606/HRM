@extends('layouts.macos')
@section('page_title', 'Add Company')



@section('content')
  <div class="hrp-card">
    {{-- <div class="hrp-card-header flex items-center justify-between gap-4">
      <h2 class="hrp-card-title">Add Company</h2>
    </div> --}}
    <div class="hrp-card-body">
      <div class="Rectangle-30 hrp-compact">
        <form method="POST" action="{{ route('companies.store') }}" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5" id="companyForm">
          @csrf
          
          <div class="md:col-span-2" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 8px;">
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Unique Code</label>
              <input name="unique_code" value="{{ $nextCode ?? '' }}" placeholder="{{ $nextCode ?? 'CMS/COM/0001' }}" class="hrp-input Rectangle-29" readonly style="font-size: 14px; line-height: 1.5; background-color: #f3f4f6;">
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">GST Number</label>
              <input name="gst_no" type="text" placeholder="e.g., 22ABCDE1234F1Z5" value="{{ old('gst_no') }}" class="hrp-input Rectangle-29" maxlength="15" style="text-transform: uppercase; font-size: 14px; line-height: 1.5;" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 15)" pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9A-Z]{1}[Z]{1}[0-9A-Z]{1}" title="Enter valid 15-character GST No. (e.g., 22ABCDE1234F1Z5)">
              @error('gst_no')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">PAN Number</label>
              <input name="pan_no" type="text" placeholder="e.g., ABCDE1234F" value="{{ old('pan_no') }}" class="hrp-input Rectangle-29" maxlength="10" style="text-transform: uppercase; font-size: 14px; line-height: 1.5;" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 10)" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" title="Enter valid 10-character PAN No. (e.g., ABCDE1234F)">
              @error('pan_no')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Name</label>
            <input name="company_name" type="text" placeholder="Enter your company name" value="{{ old('company_name') }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            @error('company_name')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Address</label>
            <textarea name="company_address" placeholder="Enter Your Address" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" rows="3" style="font-size: 14px; line-height: 1.5; resize: vertical;">{{ old('company_address') }}</textarea>
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

            <option value="" disabled {{ old('company_type') ? '' : 'selected' }}>SELECT COMPANY TYPE</option>
            <option value="INFORMATION_TECHNOLOGY">Information Technology (IT)</option>
            <option value="SOFTWARE_DEVELOPMENT">Software Development</option>
            <option value="HARDWARE_ELECTRONICS">Hardware & Electronics</option>
            <option value="TELECOMMUNICATIONS">Telecommunications</option>
            <option value="E_COMMERCE">E-Commerce</option>
            <option value="MANUFACTURING">Manufacturing</option>
            <option value="AUTOMOBILE">Automobile</option>
            <option value="AEROSPACE_DEFENSE">Aerospace & Defense</option>
            <option value="CONSTRUCTION_INFRASTRUCTURE">Construction & Infrastructure</option>
            <option value="REAL_ESTATE">Real Estate</option>
            <option value="BANKING_FINANCIAL">Banking & Financial Services</option>
            <option value="INSURANCE">Insurance</option>
            <option value="INVESTMENT_ASSET">Investment & Asset Management</option>
            <option value="HEALTHCARE">Healthcare</option>
            <option value="PHARMACEUTICALS">Pharmaceuticals</option>
            <option value="BIOTECHNOLOGY">Biotechnology</option>
            <option value="MEDICAL_DEVICES">Medical Devices</option>
            <option value="EDUCATION_TRAINING">Education & Training</option>
            <option value="RETAIL">Retail</option>
            <option value="WHOLESALE_DISTRIBUTION">Wholesale & Distribution</option>
            <option value="LOGISTICS_SUPPLY">Logistics & Supply Chain</option>
            <option value="TRANSPORTATION">Transportation (Air, Road, Rail, Sea)</option>
            <option value="FOOD_BEVERAGE">Food & Beverages</option>
            <option value="HOSPITALITY">Hospitality</option>
            <option value="TOURISM_TRAVEL">Tourism & Travel</option>
            <option value="MEDIA_ENTERTAINMENT">Media & Entertainment</option>
            <option value="ADVERTISING_MARKETING">Advertising & Marketing</option>
            <option value="PUBLISHING">Publishing</option>
            <option value="OIL_GAS">Oil & Gas</option>
            <option value="MINING_METALS">Mining & Metals</option>
            <option value="CHEMICALS">Chemicals</option>
            <option value="ENERGY_POWER">Energy & Power</option>
            <option value="RENEWABLE_ENERGY">Renewable Energy (Solar, Wind)</option>
            <option value="AGRICULTURE">Agriculture</option>
            <option value="ENVIRONMENTAL_SERVICES">Environmental Services</option>
            <option value="LEGAL_SERVICES">Legal Services</option>
            <option value="CONSULTING_ADVISORY">Consulting & Advisory</option>
            <option value="HUMAN_RESOURCES">Human Resources Services</option>
            <option value="BPO_KPO">BPO / KPO</option>
            <option value="SECURITY_SERVICES">Security Services</option>
            <option value="FASHION_APPAREL">Fashion & Apparel</option>
            <option value="TEXTILES">Textiles</option>
            <option value="SPORTS_FITNESS">Sports & Fitness</option>
            <option value="NON_PROFIT_NGO">Non-Profit / NGO</option>
            <option value="GOVERNMENT_PUBLIC">Government & Public Sector</option>
            <option value="OTHER">Other</option>
        </select>
    </div>
    @error('company_type') <small class="hrp-error">{{ $message }}</small> @enderror
</div>


<div class="mb-2">
    <label class="hrp-label"
        style="font-weight:500; margin-bottom:8px; display:block; color:#374151; font-size:14px;">
        State
    </label>

    <div class="relative">
        <select name="state" id="state_select" class="hrp-input Rectangle-29"
            style="padding-right:32px; appearance:none; background-repeat:no-repeat;
            background-position:right 12px center; background-size:16px;
            cursor:pointer; width:100%; text-transform:capitalize;
            background-image:url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%236b7280\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpolyline points=\'6 9 12 15 18 9\'/%3E%3C/svg%3E');">

            <option value="" disabled {{ old('state') ? '' : 'selected' }}>SELECT STATE</option>
            <option value="andhra_pradesh" {{ old('state') == 'andhra_pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
            <option value="arunachal_pradesh" {{ old('state') == 'arunachal_pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
            <option value="assam" {{ old('state') == 'assam' ? 'selected' : '' }}>Assam</option>
            <option value="bihar" {{ old('state') == 'bihar' ? 'selected' : '' }}>Bihar</option>
            <option value="chhattisgarh" {{ old('state') == 'chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
            <option value="delhi" {{ old('state') == 'delhi' ? 'selected' : '' }}>Delhi</option>
            <option value="goa" {{ old('state') == 'goa' ? 'selected' : '' }}>Goa</option>
            <option value="gujarat" {{ old('state') == 'gujarat' ? 'selected' : '' }}>Gujarat</option>
            <option value="haryana" {{ old('state') == 'haryana' ? 'selected' : '' }}>Haryana</option>
            <option value="himachal_pradesh" {{ old('state') == 'himachal_pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
            <option value="jammu_kashmir" {{ old('state') == 'jammu_kashmir' ? 'selected' : '' }}>Jammu & Kashmir</option>
            <option value="jharkhand" {{ old('state') == 'jharkhand' ? 'selected' : '' }}>Jharkhand</option>
            <option value="karnataka" {{ old('state') == 'karnataka' ? 'selected' : '' }}>Karnataka</option>
            <option value="kerala" {{ old('state') == 'kerala' ? 'selected' : '' }}>Kerala</option>
            <option value="ladakh" {{ old('state') == 'ladakh' ? 'selected' : '' }}>Ladakh</option>
            <option value="madhya_pradesh" {{ old('state') == 'madhya_pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
            <option value="maharashtra" {{ old('state') == 'maharashtra' ? 'selected' : '' }}>Maharashtra</option>
            <option value="manipur" {{ old('state') == 'manipur' ? 'selected' : '' }}>Manipur</option>
            <option value="meghalaya" {{ old('state') == 'meghalaya' ? 'selected' : '' }}>Meghalaya</option>
            <option value="mizoram" {{ old('state') == 'mizoram' ? 'selected' : '' }}>Mizoram</option>
            <option value="nagaland" {{ old('state') == 'nagaland' ? 'selected' : '' }}>Nagaland</option>
            <option value="odisha" {{ old('state') == 'odisha' ? 'selected' : '' }}>Odisha</option>
            <option value="punjab" {{ old('state') == 'punjab' ? 'selected' : '' }}>Punjab</option>
            <option value="rajasthan" {{ old('state') == 'rajasthan' ? 'selected' : '' }}>Rajasthan</option>
            <option value="sikkim" {{ old('state') == 'sikkim' ? 'selected' : '' }}>Sikkim</option>
            <option value="tamil_nadu" {{ old('state') == 'tamil_nadu' ? 'selected' : '' }}>Tamil Nadu</option>
            <option value="telangana" {{ old('state') == 'telangana' ? 'selected' : '' }}>Telangana</option>
            <option value="tripura" {{ old('state') == 'tripura' ? 'selected' : '' }}>Tripura</option>
            <option value="uttar_pradesh" {{ old('state') == 'uttar_pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
            <option value="uttarakhand" {{ old('state') == 'uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
            <option value="west_bengal" {{ old('state') == 'west_bengal' ? 'selected' : '' }}>West Bengal</option>
            {{-- Union Territories --}}
            <option value="andaman_nicobar" {{ old('state') == 'andaman_nicobar' ? 'selected' : '' }}>Andaman & Nicobar Islands</option>
            <option value="chandigarh" {{ old('state') == 'chandigarh' ? 'selected' : '' }}>Chandigarh</option>
            <option value="dadra_nagar_haveli_daman_diu" {{ old('state') == 'dadra_nagar_haveli_daman_diu' ? 'selected' : '' }}>Dadra & Nagar Haveli and Daman & Diu</option>
            <option value="lakshadweep" {{ old('state') == 'lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
            <option value="puducherry" {{ old('state') == 'puducherry' ? 'selected' : '' }}>Puducherry</option>
            <option value="other" {{ old('state') == 'other' ? 'selected' : '' }}>Other</option>
        </select>
        <input type="text" name="state_other" id="state_other_input" class="hrp-input Rectangle-29" placeholder="Enter State Name" value="{{ old('state_other') }}" style="display: {{ old('state') == 'other' ? 'block' : 'none' }}; margin-top: 8px; font-size: 14px; line-height: 1.5;">
    </div>
    @error('state') <small class="hrp-error">{{ $message }}</small> @enderror
</div>


<div class="mb-2">
    <label class="hrp-label"
        style="font-weight:500; margin-bottom:8px; display:block; color:#374151; font-size:14px;">
        City
    </label>

    <div class="relative">
        <select name="city" id="city_select" class="hrp-input Rectangle-29"
            style="padding-right:32px; appearance:none; background-repeat:no-repeat;
            background-position:right 12px center; background-size:16px;
            cursor:pointer; width:100%; text-transform:capitalize;
            background-image:url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%236b7280\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpolyline points=\'6 9 12 15 18 9\'/%3E%3C/svg%3E');">

            <option value="" disabled selected>SELECT STATE FIRST</option>
        </select>
        <input type="hidden" id="old_city" value="{{ old('city') }}">
        <input type="text" name="city_other" id="city_other_input" class="hrp-input Rectangle-29" placeholder="Enter City Name" value="{{ old('city_other') }}" style="display: none; margin-top: 8px; font-size: 14px; line-height: 1.5;">
    </div>
    @error('city') <small class="hrp-error">{{ $message }}</small> @enderror
</div>


<div class="mb-2">
    <label class="hrp-label"
        style="font-weight:500; margin-bottom:8px; display:block; color:#374151; font-size:14px;">
        Contact Person Name <span class="text-red-500">*</span>
    </label>

    <input name="contact_person_name" placeholder="Enter Contact Person Name"
        value="{{ old('contact_person_name') }}"
        class="hrp-input Rectangle-29" style="font-size:14px; line-height:1.5;">

    @error('contact_person_name') <small class="hrp-error">{{ $message }}</small> @enderror
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
              value="{{ old('contact_person_mobile') }}"
              placeholder="Enter 10 digit mobile number"
              style="font-size: 14px; line-height: 1.5;"
            />
            @error('contact_person_mobile')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Contact Person Position <span class="text-red-500">*</span></label>
            <input name="contact_person_position" placeholder="Enter Contact Person Position" value="{{ old('contact_person_position') }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            @error('contact_person_position')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Scope Link</label>
            <input name="scope_link" type="url" placeholder="Enter Scope Link" value="{{ old('scope_link') }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            @error('scope_link')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">SOP Upload</label>
            <div class="upload-pill Rectangle-29" onclick="document.getElementById('sopInput').click()">
              <div class="choose" style="font-size: 14px;">Choose File</div>
              <div class="filename" id="sopFileName" style="font-size: 14px;">No File Chosen</div>
              <input id="sopInput" name="sop_upload" type="file" style="display: none;" onchange="validateSopFile(this)" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
            </div>
            <small id="sopError" class="hrp-error" style="display: none;"></small>
            @error('sop_upload')<small class="hrp-error">{{ $message }}</small>@enderror
            <small class="text-gray-500 text-xs" style="display: block; margin-top: 4px;">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 5MB)</small>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Quotation Upload</label>
            <div class="upload-pill Rectangle-29" onclick="document.getElementById('quotationInput').click()">
              <div class="choose" style="font-size: 14px;">Choose File</div>
              <div class="filename" id="quotationFileName" style="font-size: 14px;">No File Chosen</div>
              <input id="quotationInput" name="quotation_upload" type="file" style="display: none;" onchange="validateQuotationFile(this)" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
            </div>
            <small id="quotationError" class="hrp-error" style="display: none;"></small>
            @error('quotation_upload')<small class="hrp-error">{{ $message }}</small>@enderror
            <small class="text-gray-500 text-xs" style="display: block; margin-top: 4px;">Accepted formats: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG (Max: 5MB)</small>
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
                  <input name="person_name_1" placeholder="Enter Name" value="{{ old('person_name_1') }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_name_1')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                <div>
                  <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 13px;">Person 1 - Mobile</label>
                  <input name="person_number_1" type="tel" inputmode="numeric" pattern="\d{10}" maxlength="10" placeholder="Enter Mobile Number" value="{{ old('person_number_1') }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_number_1')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                <div>
                  <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 13px;">Person 1 - Position</label>
                  <input name="person_position_1" placeholder="Enter Position" value="{{ old('person_position_1') }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_position_1')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
              </div>
              
              <!-- Person 2 -->
              <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px dashed #e2e8f0;">
                <div>
                  <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 13px;">Person 2 - Name</label>
                  <input name="person_name_2" placeholder="Enter Name" value="{{ old('person_name_2') }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_name_2')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                <div>
                  <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 13px;">Person 2 - Mobile</label>
                  <input name="person_number_2" type="tel" inputmode="numeric" pattern="\d{10}" maxlength="10" placeholder="Enter Mobile Number" value="{{ old('person_number_2') }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_number_2')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                <div>
                  <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 13px;">Person 2 - Position</label>
                  <input name="person_position_2" placeholder="Enter Position" value="{{ old('person_position_2') }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_position_2')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
              </div>
              
              <!-- Person 3 -->
              <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                <div>
                  <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 13px;">Person 3 - Name</label>
                  <input name="person_name_3" placeholder="Enter Name" value="{{ old('person_name_3') }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_name_3')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                <div>
                  <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 13px;">Person 3 - Mobile</label>
                  <input name="person_number_3" type="tel" inputmode="numeric" pattern="\d{10}" maxlength="10" placeholder="Enter Mobile Number" value="{{ old('person_number_3') }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_number_3')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
                <div>
                  <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 13px;">Person 3 - Position</label>
                  <input name="person_position_3" placeholder="Enter Position" value="{{ old('person_position_3') }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
                  @error('person_position_3')<small class="hrp-error">{{ $message }}</small>@enderror
                </div>
              </div>
            </div>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Logo</label>
            <div class="upload-pill Rectangle-29" onclick="document.getElementById('logoInput').click()">
              <div class="choose" style="font-size: 14px;">Choose File</div>
              <div class="filename" id="logoFileName" style="font-size: 14px;">No File Chosen</div>
              <input id="logoInput" name="company_logo" type="file" accept=".jpeg,.jpg,.png" style="display: none;" onchange="validateLogoFile(this)">
            </div>
            <div id="logoPreview" style="margin-top: 10px; display: none;">
              <img id="logoPreviewImg" src="" alt="Logo Preview" style="max-width: 150px; max-height: 100px; border-radius: 8px; border: 2px solid #e5e7eb;">
            </div>
            <small id="logoError" class="hrp-error" style="display: none;"></small>
            @error('company_logo')<small class="hrp-error">{{ $message }}</small>@enderror
            <small class="text-gray-500 text-xs" style="display: block; margin-top: 4px;">Accepted formats: JPEG, JPG, PNG (Max: 2MB)</small>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Other</label>
            <textarea name="other_details" placeholder="Enter other details" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" rows="3" style="font-size: 14px; line-height: 1.5; resize: vertical;">{{ old('other_details') }}</textarea>
            @error('other_details')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Email <span class="text-red-500">*</span></label>
            <div style="position: relative;">
              <input name="company_email" id="company_email" type="email" placeholder="Enter Company Email" value="{{ old('company_email') }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5; padding-right: 100px;">
              <button type="button" onclick="generateCompanyEmail()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
            </div>
            @error('company_email')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Password <span class="text-red-500">*</span></label>
            <div style="position: relative;">
              <input name="company_password" id="company_password" type="text" placeholder="Enter Company Password (min 6 characters)" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5; padding-right: 100px;" autocomplete="new-password">
              <button type="button" onclick="generateCompanyPassword()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #3b82f6; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
            </div>
            @error('company_password')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Confirm Password <span class="text-red-500">*</span></label>
            <input name="company_password_confirmation" id="company_password_confirmation" type="text" placeholder="Confirm Company Password" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;" autocomplete="new-password">
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Employee Email <span style="color: #6b7280; font-size: 12px;">(Optional)</span></label>
            <div style="position: relative;">
              <input name="company_employee_email" id="company_employee_email_create" type="email" placeholder="Enter Company Employee Email (optional)" value="{{ old('company_employee_email') }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5; padding-right: 100px;">
              <button type="button" onclick="generateEmployeeEmailCreate()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
            </div>
            @error('company_employee_email')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Employee Password <span style="color: #6b7280; font-size: 12px;">(Optional)</span></label>
            <div style="position: relative;">
              <input name="company_employee_password" id="company_employee_password_create" type="text" placeholder="Enter Employee Password (optional)" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5; padding-right: 100px;" autocomplete="new-password">
              <button type="button" onclick="generateEmployeePasswordCreate()" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; border: none; cursor: pointer;">Generate</button>
            </div>
            @error('company_employee_password')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Confirm Employee Password</label>
            <input name="company_employee_password_confirmation" id="company_employee_password_confirmation_create" type="text" placeholder="Confirm Employee Password" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
          </div>
          
          <div class="md:col-span-2" style="margin-top: 20px;">
            <div class="hrp-actions">
              <button type="submit" class="hrp-btn hrp-btn-primary" style="font-size: 14px; font-weight: 500; padding: 12px 24px;">Add Company</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
// SOP FILE VALIDATION FUNCTION
function validateSopFile(input) {
    const sopFileName = document.getElementById('sopFileName');
    const sopError = document.getElementById('sopError');
    
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

// QUOTATION FILE VALIDATION FUNCTION
function validateQuotationFile(input) {
    const quotationFileName = document.getElementById('quotationFileName');
    const quotationError = document.getElementById('quotationError');
    
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

// LOGO FILE VALIDATION FUNCTION
function validateLogoFile(input) {
    const logoFileName = document.getElementById('logoFileName');
    const logoPreview = document.getElementById('logoPreview');
    const logoPreviewImg = document.getElementById('logoPreviewImg');
    const logoError = document.getElementById('logoError');
    
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


// State-City functions (toggleOtherInput, populateCities) are loaded from state-city-dropdown.js
// Initialize state-city dropdown on page load
document.addEventListener('DOMContentLoaded', function() {
    const stateSelect = document.getElementById('state_select');
    const citySelect = document.getElementById('city_select');
    const stateOtherInput = document.getElementById('state_other_input');
    const cityOtherInput = document.getElementById('city_other_input');
    const oldCity = document.getElementById('old_city')?.value;
    
    if (stateSelect) {
        // If state is already selected (e.g., from old input), populate cities and show other inputs
        if (stateSelect.value) {
            // Show state other input if "other" is selected
            if (stateOtherInput && typeof toggleOtherInput === 'function') {
                toggleOtherInput(stateSelect, stateOtherInput);
            }
            if (typeof populateCities === 'function') {
                populateCities(stateSelect.value, oldCity);
            }
        }
        
        // Add change event listener for state
        stateSelect.addEventListener('change', function() {
            // Toggle state other input
            if (stateOtherInput && typeof toggleOtherInput === 'function') {
                toggleOtherInput(this, stateOtherInput);
            }
            if (typeof populateCities === 'function') {
                populateCities(this.value);
            }
        });
    }
    
    // Add change event listener for city "Other" option
    if (citySelect) {
        citySelect.addEventListener('change', function() {
            if (cityOtherInput && typeof toggleOtherInput === 'function') {
                toggleOtherInput(this, cityOtherInput);
            }
        });
    }
});

  // Auto-generate company email based on company name
  function generateCompanyEmail() {
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

  // Auto-generate company password based on company name
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
      html: `<p>Password: <strong style="color: #3b82f6; font-size: 18px;">${password}</strong></p><p style="color: #6b7280; font-size: 13px; margin-top: 10px;">Password has been copied to confirmation field.</p>`,
      confirmButtonColor: '#3b82f6',
      width: '400px'
    });
  }

  // Auto-copy password to confirmation field
  document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('company_password');
    const confirmPasswordInput = document.getElementById('company_password_confirmation');
    
    if (passwordInput && confirmPasswordInput) {
      passwordInput.addEventListener('input', function() {
        confirmPasswordInput.value = this.value;
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

  (function(){
    var sopInput = document.getElementById('sopInput');
    var sopLabel = document.getElementById('sopFileName');
    if(sopInput && sopLabel){
      sopInput.addEventListener('change', function(){
        var name = this.files && this.files.length ? this.files[0].name : 'No File Chosen';
        sopLabel.textContent = name;
      });
    }

    var quotationInput = document.getElementById('quotationInput');
    var quotationLabel = document.getElementById('quotationFileName');
    if(quotationInput && quotationLabel){
      quotationInput.addEventListener('change', function(){
        var name = this.files && this.files.length ? this.files[0].name : 'No File Chosen';
        quotationLabel.textContent = name;
      });
    }
    
    // Logo validation is handled by validateLogoFile function
  })();

  // Auto-generate employee email
  function generateEmployeeEmailCreate() {
    console.log('generateEmployeeEmailCreate called');
    const companyNameInput = document.querySelector('input[name="company_name"]');
    const emailInput = document.getElementById('company_employee_email_create');
    console.log('Company Name Input:', companyNameInput);
    console.log('Email Input:', emailInput);
    
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
  function generateEmployeePasswordCreate() {
    console.log('generateEmployeePasswordCreate called');
    const companyNameInput = document.querySelector('input[name="company_name"]');
    const passwordInput = document.getElementById('company_employee_password_create');
    const confirmPasswordInput = document.getElementById('company_employee_password_confirmation_create');
    console.log('Company Name Input:', companyNameInput);
    console.log('Password Input:', passwordInput);
    console.log('Confirm Password Input:', confirmPasswordInput);
    
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
</script>
@endpush

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('companies.index') }}" class="hrp-link">Company</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Add Company</span>
@endsection