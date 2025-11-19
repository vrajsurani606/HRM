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
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">GST No</label>
              <input name="gst_no" type="text" placeholder="Enter GST No" value="{{ old('gst_no', $company->gst_no) }}" class="hrp-input Rectangle-29" maxlength="15" style="font-size: 14px; line-height: 1.5;">
              @error('gst_no')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Pan No</label>
              <input name="pan_no" type="text" placeholder="Enter PAN No" value="{{ old('pan_no', $company->pan_no) }}" class="hrp-input Rectangle-29" maxlength="10" style="text-transform: uppercase; font-size: 14px; line-height: 1.5;">
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

          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Type</label>
            <div class="relative">
              <select name="company_type" class="hrp-input Rectangle-29" style="
                padding-right: 32px;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E\");
                background-repeat: no-repeat;
                background-position: right 12px center;
                background-size: 16px 16px;
                cursor: pointer;
                text-transform: uppercase;
                width: 100%;
                font-size: 14px;
                line-height: 1.5;
              ">
                <option value="" disabled {{ old('company_type', $company->company_type) ? '' : 'selected' }}>SELECT COMPANY TYPE</option>
                <option value="AUTOMOBILE" {{ old('company_type', $company->company_type) == 'AUTOMOBILE' ? 'selected' : '' }}>AUTOMOBILE</option>
                <option value="FMCG" {{ old('company_type', $company->company_type) == 'FMCG' ? 'selected' : '' }}>FMCG (FAST-MOVING CONSUMER GOODS)</option>
                <option value="IT" {{ old('company_type', $company->company_type) == 'IT' ? 'selected' : '' }}>INFORMATION TECHNOLOGY</option>
                <option value="MANUFACTURING" {{ old('company_type', $company->company_type) == 'MANUFACTURING' ? 'selected' : '' }}>MANUFACTURING</option>
                <option value="CONSTRUCTION" {{ old('company_type', $company->company_type) == 'CONSTRUCTION' ? 'selected' : '' }}>CONSTRUCTION</option>
                <option value="HEALTHCARE" {{ old('company_type', $company->company_type) == 'HEALTHCARE' ? 'selected' : '' }}>HEALTHCARE</option>
                <option value="EDUCATION" {{ old('company_type', $company->company_type) == 'EDUCATION' ? 'selected' : '' }}>EDUCATION</option>
                <option value="FINANCE" {{ old('company_type', $company->company_type) == 'FINANCE' ? 'selected' : '' }}>FINANCE & BANKING</option>
                <option value="RETAIL" {{ old('company_type', $company->company_type) == 'RETAIL' ? 'selected' : '' }}>RETAIL</option>
                <option value="TELECOM" {{ old('company_type', $company->company_type) == 'TELECOM' ? 'selected' : '' }}>TELECOMMUNICATIONS</option>
                <option value="HOSPITALITY" {{ old('company_type', $company->company_type) == 'HOSPITALITY' ? 'selected' : '' }}>HOSPITALITY</option>
                <option value="TRANSPORT" {{ old('company_type', $company->company_type) == 'TRANSPORT' ? 'selected' : '' }}>TRANSPORT & LOGISTICS</option>
                <option value="ENERGY" {{ old('company_type', $company->company_type) == 'ENERGY' ? 'selected' : '' }}>ENERGY & UTILITIES</option>
                <option value="MEDIA" {{ old('company_type', $company->company_type) == 'MEDIA' ? 'selected' : '' }}>MEDIA & ENTERTAINMENT</option>
                <option value="REAL_ESTATE" {{ old('company_type', $company->company_type) == 'REAL_ESTATE' ? 'selected' : '' }}>REAL ESTATE</option>
                <option value="OTHER" {{ old('company_type', $company->company_type) == 'OTHER' ? 'selected' : '' }}>OTHER</option>
              </select>
              @error('company_type')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>

          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">State</label>
            <div class="relative">
              <select name="state" class="hrp-input Rectangle-29" style="
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
                <option value="goa" {{ old('state', $company->state) == 'goa' ? 'selected' : '' }}>Goa</option>
                <option value="gujarat" {{ old('state', $company->state) == 'gujarat' ? 'selected' : '' }}>Gujarat</option>
                <option value="haryana" {{ old('state', $company->state) == 'haryana' ? 'selected' : '' }}>Haryana</option>
                <option value="himachal_pradesh" {{ old('state', $company->state) == 'himachal_pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
                <option value="jharkhand" {{ old('state', $company->state) == 'jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                <option value="karnataka" {{ old('state', $company->state) == 'karnataka' ? 'selected' : '' }}>Karnataka</option>
                <option value="kerala" {{ old('state', $company->state) == 'kerala' ? 'selected' : '' }}>Kerala</option>
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
                <option value="andaman_nicobar" {{ old('state', $company->state) == 'andaman_nicobar' ? 'selected' : '' }}>Andaman and Nicobar Islands</option>
                <option value="chandigarh" {{ old('state', $company->state) == 'chandigarh' ? 'selected' : '' }}>Chandigarh</option>
                <option value="dadra_nagar_haveli" {{ old('state', $company->state) == 'dadra_nagar_haveli' ? 'selected' : '' }}>Dadra and Nagar Haveli and Daman and Diu</option>
                <option value="delhi" {{ old('state', $company->state) == 'delhi' ? 'selected' : '' }}>Delhi</option>
                <option value="jammu_kashmir" {{ old('state', $company->state) == 'jammu_kashmir' ? 'selected' : '' }}>Jammu and Kashmir</option>
                <option value="ladakh" {{ old('state', $company->state) == 'ladakh' ? 'selected' : '' }}>Ladakh</option>
                <option value="lakshadweep" {{ old('state', $company->state) == 'lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
                <option value="puducherry" {{ old('state', $company->state) == 'puducherry' ? 'selected' : '' }}>Puducherry</option>
              </select>
              @error('state')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>

          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">City</label>
            <div class="relative">
              <select name="city" class="hrp-input Rectangle-29" style="
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
                <option value="" disabled {{ old('city', $company->city) ? '' : 'selected' }}>SELECT CITY</option>
                @php
                  $cities = [
                    'mumbai', 'delhi', 'bengaluru', 'hyderabad', 'ahmedabad', 'chennai', 'kolkata', 'surat',
                    'pune', 'jaipur', 'lucknow', 'kanpur', 'nagpur', 'indore', 'thane', 'bhopal', 'visakhapatnam',
                    'pimpri_chinchwad', 'patna', 'vadodara', 'ghaziabad', 'ludhiana', 'coimbatore', 'kochi', 'nashik',
                    'faridabad', 'gurgaon', 'noida', 'greater_noida', 'raipur', 'kota', 'chandigarh', 'bhubaneswar',
                    'guwahati', 'dehradun', 'ranchi', 'srinagar', 'jammu', 'thiruvananthapuram', 'shimla', 'itanagar',
                    'kohima', 'imphal', 'shillong', 'aizawl', 'gangtok', 'agartala', 'kavaratti', 'puducherry', 'daman',
                    'daman_and_diu', 'port_blair', 'silvassa'
                  ];
                  sort($cities);
                @endphp
                @foreach($cities as $city)
                  <option value="{{ $city }}" {{ old('city', $company->city) == $city ? 'selected' : '' }}>
                    {{ ucwords(str_replace('_', ' ', $city)) }}
                  </option>
                @endforeach
              </select>
              @error('city')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>

          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Contact Person Name</label>
            <input name="contact_person_name" type="text" placeholder="Enter Contact Person Name" value="{{ old('contact_person_name', $company->contact_person_name) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            @error('contact_person_name')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Contact Person Position</label>
            <input name="contact_person_position" placeholder="Enter Contact Person Position" value="{{ old('contact_person_position', $company->contact_person_position) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            @error('contact_person_position')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>

          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Contact Person Mobile No</label>
            <input name="contact_person_mobile" type="tel" placeholder="Enter Contact Person Mobile No" value="{{ old('contact_person_mobile', $company->contact_person_mobile) }}" class="hrp-input Rectangle-29" pattern="[0-9]{10}" maxlength="10" style="font-size: 14px; line-height: 1.5;">
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
              <input id="sopInput" name="sop_upload" type="file" style="display: none;" onchange="updateFileName(this, 'sopFileName')" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
            </div>
            @if($company->sop_upload)
              @php
                $extension = strtolower(pathinfo($company->sop_upload, PATHINFO_EXTENSION));
                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                $fileUrl = route('company.documents.view', ['type' => 'sop', 'filename' => basename($company->sop_upload)]);
              @endphp
              <div class="mt-2">
                @if($isImage)
                  <div class="mb-2">
                    <img src="{{ $fileUrl }}" alt="SOP Preview" class="max-w-xs border rounded p-1">
                  </div>
                @endif
                <div>
                  <a href="{{ $fileUrl }}" target="_blank" class="inline-flex items-center text-blue-500 hover:underline text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                    View Current File
                  </a>
                  <span class="text-gray-500 text-xs ml-2">({{ Str::upper($extension) }})</span>
                </div>
              </div>
            @endif
            @error('sop_upload')<small class="hrp-error">{{ $message }}</small>@enderror
            <small class="text-gray-500 text-xs block mt-1">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 5MB)</small>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Quotation Upload</label>
            <div class="upload-pill Rectangle-29" onclick="document.getElementById('quotationInput').click()">
              <div class="choose" style="font-size: 14px;">Choose File</div>
              <div class="filename" id="quotationFileName" style="font-size: 14px;">{{ $company->quotation_upload ? basename($company->quotation_upload) : 'No File Chosen' }}</div>
              <input id="quotationInput" name="quotation_upload" type="file" style="display: none;" onchange="updateFileName(this, 'quotationFileName')" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
            </div>
            @if($company->quotation_upload)
              @php
                $extension = strtolower(pathinfo($company->quotation_upload, PATHINFO_EXTENSION));
                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                $fileUrl = route('company.documents.view', ['type' => 'quotation', 'filename' => basename($company->quotation_upload)]);
              @endphp
              <div class="mt-2">
                @if($isImage)
                  <div class="mb-2">
                    <img src="{{ $fileUrl }}" alt="Quotation Preview" class="max-w-xs border rounded p-1">
                  </div>
                @endif
                <div>
                  <a href="{{ $fileUrl }}" target="_blank" class="inline-flex items-center text-blue-500 hover:underline text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                    View Current File
                  </a>
                  <span class="text-gray-500 text-xs ml-2">({{ Str::upper($extension) }})</span>
                </div>
              </div>
            @endif
            @error('quotation_upload')<small class="hrp-error">{{ $message }}</small>@enderror
            <small class="text-gray-500 text-xs block mt-1">Accepted formats: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG (Max: 5MB)</small>
          </div>
          <div>
            
          </div>

          <div class="md:col-span-2">
            <h3 class="text-lg font-medium text-gray-700 mb-3" style="font-size: 16px; font-weight: 500; color: #374151; margin-bottom: 12px;">Additional Contact Persons</h3>
          </div>

          <div class="md:col-span-2 grid grid-cols-3 gap-5" style="margin-bottom: 12px;">
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Name 1</label>
              <input name="person_name_1" placeholder="Enter Person Name 1" value="{{ old('person_name_1', $company->person_name_1) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_name_1')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Number 1</label>
              <input name="person_number_1" type="tel" placeholder="Enter Person Number 1" value="{{ old('person_number_1', $company->person_number_1) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_number_1')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Position 1</label>
              <input name="person_position_1" placeholder="Enter Person Position 1" value="{{ old('person_position_1', $company->person_position_1) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_position_1')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>

          <div class="md:col-span-2 grid grid-cols-3 gap-5" style="margin-bottom: 12px;">
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Name 2</label>
              <input name="person_name_2" placeholder="Enter Person Name 2" value="{{ old('person_name_2', $company->person_name_2) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_name_2')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Number 2</label>
              <input name="person_number_2" type="tel" placeholder="Enter Person Number 2" value="{{ old('person_number_2', $company->person_number_2) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_number_2')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Position 2</label>
              <input name="person_position_2" placeholder="Enter Person Position 2" value="{{ old('person_position_2', $company->person_position_2) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_position_2')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>

          <div class="md:col-span-2 grid grid-cols-3 gap-5" style="margin-bottom: 12px;">
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Name 3</label>
              <input name="person_name_3" placeholder="Enter Person Name 3" value="{{ old('person_name_3', $company->person_name_3) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_name_3')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Number 3</label>
              <input name="person_number_3" type="tel" placeholder="Enter Person Number 3" value="{{ old('person_number_3', $company->person_number_3) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_number_3')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Position 3</label>
              <input name="person_position_3" placeholder="Enter Person Position 3" value="{{ old('person_position_3', $company->person_position_3) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_position_3')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Logo</label>
            <input name="company_logo" type="file" class="hrp-input Rectangle-29" style="padding: 8px 12px; font-size: 14px; line-height: 1.5;">
            @if($company->company_logo)
              <div class="mt-2">
                <img src="{{ asset('storage/' . $company->company_logo) }}" alt="Company Logo" style="max-width: 100px; max-height: 100px;">
              </div>
            @endif
            @error('company_logo')<small class="hrp-error">{{ $message }}</small>@enderror
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
            <input name="company_password" type="password" placeholder="Leave blank to keep current password" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;" autocomplete="new-password">
            @error('company_password')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Confirm Password</label>
            <input name="company_password_confirmation" type="password" placeholder="Confirm Company Password" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;" autocomplete="new-password">
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Employee Email</label>
            <input name="company_employee_email" type="email" placeholder="Enter Company Employee Email" value="{{ old('company_employee_email', $company->company_employee_email) }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            @error('company_employee_email')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Employee Password</label>
            <input name="company_employee_password" type="password" placeholder="Leave blank to keep current password" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;" autocomplete="new-password">
            @error('company_employee_password')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Confirm Employee Password</label>
            <input name="company_employee_password_confirmation" type="password" placeholder="Confirm Employee Password" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;" autocomplete="new-password">
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

  // Existing code
  (function(){
    // Add any necessary JavaScript here
  })();
</script>
@endpush
