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
              <input name="gst_no" type="text" placeholder="e.g., 22ABCDE1234F1Z5" value="{{ old('gst_no', $company->gst_no) }}" class="hrp-input Rectangle-29" maxlength="15" style="text-transform: uppercase; font-size: 14px; line-height: 1.5;" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 15)" pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9A-Z]{1}[Z]{1}[0-9A-Z]{1}" title="Enter valid 15-character GST No. (e.g., 22ABCDE1234F1Z5)">
              @error('gst_no')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Pan No</label>
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
                <option value="other" {{ old('state', $company->state) == 'other' ? 'selected' : '' }}>Other</option>
              </select>
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
            <small id="quotationErrorEdit" class="hrp-error" style="display: none;"></small>
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
            <div class="upload-pill Rectangle-29" onclick="document.getElementById('logoInputEdit').click()" style="cursor: pointer;">
              <div class="choose" style="font-size: 14px;">Choose File</div>
              <div class="filename" id="logoFileNameEdit" style="font-size: 14px;">No File Chosen</div>
              <input id="logoInputEdit" name="company_logo" type="file" accept=".jpeg,.jpg,.png" style="display: none;" onchange="validateLogoFileEdit(this)">
            </div>
            @if($company->company_logo)
              <div class="mt-2" id="currentLogoEdit">
                <p style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Current Logo:</p>
                <img src="{{ storage_asset('' . $company->company_logo) }}" alt="Company Logo" style="max-width: 100px; max-height: 100px; border-radius: 8px; border: 2px solid #e5e7eb;">
              </div>
            @endif
            <div id="logoPreviewEdit" style="margin-top: 10px; display: none;">
              <p style="font-size: 12px; color: #10b981; margin-bottom: 4px;">New Logo Preview:</p>
              <img id="logoPreviewImgEdit" src="" alt="Logo Preview" style="max-width: 150px; max-height: 100px; border-radius: 8px; border: 2px solid #10b981;">
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
            @can('Company Management.edit company')
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
            @can('Company Management.edit company')
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

// STATE-CITY DEPENDENT DROPDOWN DATA
const stateCityData = {
    'andhra_pradesh': [
        {value: 'visakhapatnam', label: 'Visakhapatnam'},
        {value: 'vijayawada', label: 'Vijayawada'},
        {value: 'guntur', label: 'Guntur'},
        {value: 'nellore', label: 'Nellore'},
        {value: 'kurnool', label: 'Kurnool'},
        {value: 'tirupati', label: 'Tirupati'},
        {value: 'rajahmundry', label: 'Rajahmundry'},
        {value: 'kakinada', label: 'Kakinada'},
        {value: 'anantapur', label: 'Anantapur'},
        {value: 'other', label: 'Other'}
    ],
    'arunachal_pradesh': [
        {value: 'itanagar', label: 'Itanagar'},
        {value: 'naharlagun', label: 'Naharlagun'},
        {value: 'pasighat', label: 'Pasighat'},
        {value: 'other', label: 'Other'}
    ],
    'assam': [
        {value: 'guwahati', label: 'Guwahati'},
        {value: 'silchar', label: 'Silchar'},
        {value: 'dibrugarh', label: 'Dibrugarh'},
        {value: 'jorhat', label: 'Jorhat'},
        {value: 'nagaon', label: 'Nagaon'},
        {value: 'tinsukia', label: 'Tinsukia'},
        {value: 'other', label: 'Other'}
    ],
    'bihar': [
        {value: 'patna', label: 'Patna'},
        {value: 'gaya', label: 'Gaya'},
        {value: 'bhagalpur', label: 'Bhagalpur'},
        {value: 'muzaffarpur', label: 'Muzaffarpur'},
        {value: 'purnia', label: 'Purnia'},
        {value: 'darbhanga', label: 'Darbhanga'},
        {value: 'bihar_sharif', label: 'Bihar Sharif'},
        {value: 'other', label: 'Other'}
    ],
    'chhattisgarh': [
        {value: 'raipur', label: 'Raipur'},
        {value: 'bhilai', label: 'Bhilai'},
        {value: 'bilaspur', label: 'Bilaspur'},
        {value: 'korba', label: 'Korba'},
        {value: 'durg', label: 'Durg'},
        {value: 'rajnandgaon', label: 'Rajnandgaon'},
        {value: 'other', label: 'Other'}
    ],
    'delhi': [
        {value: 'new_delhi', label: 'New Delhi'},
        {value: 'delhi', label: 'Delhi'},
        {value: 'noida', label: 'Noida'},
        {value: 'gurgaon', label: 'Gurgaon'},
        {value: 'faridabad', label: 'Faridabad'},
        {value: 'ghaziabad', label: 'Ghaziabad'},
        {value: 'other', label: 'Other'}
    ],
    'goa': [
        {value: 'panaji', label: 'Panaji'},
        {value: 'margao', label: 'Margao'},
        {value: 'vasco_da_gama', label: 'Vasco da Gama'},
        {value: 'mapusa', label: 'Mapusa'},
        {value: 'ponda', label: 'Ponda'},
        {value: 'other', label: 'Other'}
    ],
    'gujarat': [
        {value: 'ahmedabad', label: 'Ahmedabad'},
        {value: 'surat', label: 'Surat'},
        {value: 'vadodara', label: 'Vadodara'},
        {value: 'rajkot', label: 'Rajkot'},
        {value: 'bhavnagar', label: 'Bhavnagar'},
        {value: 'jamnagar', label: 'Jamnagar'},
        {value: 'junagadh', label: 'Junagadh'},
        {value: 'gandhinagar', label: 'Gandhinagar'},
        {value: 'anand', label: 'Anand'},
        {value: 'nadiad', label: 'Nadiad'},
        {value: 'morbi', label: 'Morbi'},
        {value: 'mehsana', label: 'Mehsana'},
        {value: 'bharuch', label: 'Bharuch'},
        {value: 'vapi', label: 'Vapi'},
        {value: 'navsari', label: 'Navsari'},
        {value: 'veraval', label: 'Veraval'},
        {value: 'porbandar', label: 'Porbandar'},
        {value: 'godhra', label: 'Godhra'},
        {value: 'palanpur', label: 'Palanpur'},
        {value: 'valsad', label: 'Valsad'},
        {value: 'other', label: 'Other'}
    ],
    'haryana': [
        {value: 'faridabad', label: 'Faridabad'},
        {value: 'gurgaon', label: 'Gurgaon'},
        {value: 'panipat', label: 'Panipat'},
        {value: 'ambala', label: 'Ambala'},
        {value: 'yamunanagar', label: 'Yamunanagar'},
        {value: 'rohtak', label: 'Rohtak'},
        {value: 'hisar', label: 'Hisar'},
        {value: 'karnal', label: 'Karnal'},
        {value: 'sonipat', label: 'Sonipat'},
        {value: 'panchkula', label: 'Panchkula'},
        {value: 'other', label: 'Other'}
    ],
    'himachal_pradesh': [
        {value: 'shimla', label: 'Shimla'},
        {value: 'mandi', label: 'Mandi'},
        {value: 'solan', label: 'Solan'},
        {value: 'dharamshala', label: 'Dharamshala'},
        {value: 'kullu', label: 'Kullu'},
        {value: 'manali', label: 'Manali'},
        {value: 'other', label: 'Other'}
    ],
    'jammu_kashmir': [
        {value: 'srinagar', label: 'Srinagar'},
        {value: 'jammu', label: 'Jammu'},
        {value: 'anantnag', label: 'Anantnag'},
        {value: 'baramulla', label: 'Baramulla'},
        {value: 'other', label: 'Other'}
    ],
    'jharkhand': [
        {value: 'ranchi', label: 'Ranchi'},
        {value: 'jamshedpur', label: 'Jamshedpur'},
        {value: 'dhanbad', label: 'Dhanbad'},
        {value: 'bokaro', label: 'Bokaro'},
        {value: 'deoghar', label: 'Deoghar'},
        {value: 'hazaribagh', label: 'Hazaribagh'},
        {value: 'other', label: 'Other'}
    ],
    'karnataka': [
        {value: 'bengaluru', label: 'Bengaluru'},
        {value: 'mysuru', label: 'Mysuru'},
        {value: 'hubli', label: 'Hubli'},
        {value: 'mangaluru', label: 'Mangaluru'},
        {value: 'belgaum', label: 'Belgaum'},
        {value: 'gulbarga', label: 'Gulbarga'},
        {value: 'davanagere', label: 'Davanagere'},
        {value: 'bellary', label: 'Bellary'},
        {value: 'shimoga', label: 'Shimoga'},
        {value: 'tumkur', label: 'Tumkur'},
        {value: 'other', label: 'Other'}
    ],
    'kerala': [
        {value: 'thiruvananthapuram', label: 'Thiruvananthapuram'},
        {value: 'kochi', label: 'Kochi'},
        {value: 'kozhikode', label: 'Kozhikode'},
        {value: 'thrissur', label: 'Thrissur'},
        {value: 'kollam', label: 'Kollam'},
        {value: 'kannur', label: 'Kannur'},
        {value: 'alappuzha', label: 'Alappuzha'},
        {value: 'palakkad', label: 'Palakkad'},
        {value: 'other', label: 'Other'}
    ],
    'madhya_pradesh': [
        {value: 'indore', label: 'Indore'},
        {value: 'bhopal', label: 'Bhopal'},
        {value: 'jabalpur', label: 'Jabalpur'},
        {value: 'gwalior', label: 'Gwalior'},
        {value: 'ujjain', label: 'Ujjain'},
        {value: 'sagar', label: 'Sagar'},
        {value: 'dewas', label: 'Dewas'},
        {value: 'satna', label: 'Satna'},
        {value: 'ratlam', label: 'Ratlam'},
        {value: 'other', label: 'Other'}
    ],
    'maharashtra': [
        {value: 'mumbai', label: 'Mumbai'},
        {value: 'pune', label: 'Pune'},
        {value: 'nagpur', label: 'Nagpur'},
        {value: 'thane', label: 'Thane'},
        {value: 'nashik', label: 'Nashik'},
        {value: 'aurangabad', label: 'Aurangabad'},
        {value: 'solapur', label: 'Solapur'},
        {value: 'kolhapur', label: 'Kolhapur'},
        {value: 'navi_mumbai', label: 'Navi Mumbai'},
        {value: 'amravati', label: 'Amravati'},
        {value: 'sangli', label: 'Sangli'},
        {value: 'malegaon', label: 'Malegaon'},
        {value: 'jalgaon', label: 'Jalgaon'},
        {value: 'akola', label: 'Akola'},
        {value: 'latur', label: 'Latur'},
        {value: 'ahmednagar', label: 'Ahmednagar'},
        {value: 'other', label: 'Other'}
    ],
    'manipur': [
        {value: 'imphal', label: 'Imphal'},
        {value: 'thoubal', label: 'Thoubal'},
        {value: 'other', label: 'Other'}
    ],
    'meghalaya': [
        {value: 'shillong', label: 'Shillong'},
        {value: 'tura', label: 'Tura'},
        {value: 'other', label: 'Other'}
    ],
    'mizoram': [
        {value: 'aizawl', label: 'Aizawl'},
        {value: 'lunglei', label: 'Lunglei'},
        {value: 'other', label: 'Other'}
    ],
    'nagaland': [
        {value: 'kohima', label: 'Kohima'},
        {value: 'dimapur', label: 'Dimapur'},
        {value: 'other', label: 'Other'}
    ],
    'odisha': [
        {value: 'bhubaneswar', label: 'Bhubaneswar'},
        {value: 'cuttack', label: 'Cuttack'},
        {value: 'rourkela', label: 'Rourkela'},
        {value: 'berhampur', label: 'Berhampur'},
        {value: 'sambalpur', label: 'Sambalpur'},
        {value: 'puri', label: 'Puri'},
        {value: 'other', label: 'Other'}
    ],
    'punjab': [
        {value: 'ludhiana', label: 'Ludhiana'},
        {value: 'amritsar', label: 'Amritsar'},
        {value: 'jalandhar', label: 'Jalandhar'},
        {value: 'patiala', label: 'Patiala'},
        {value: 'bathinda', label: 'Bathinda'},
        {value: 'mohali', label: 'Mohali'},
        {value: 'pathankot', label: 'Pathankot'},
        {value: 'hoshiarpur', label: 'Hoshiarpur'},
        {value: 'other', label: 'Other'}
    ],
    'rajasthan': [
        {value: 'jaipur', label: 'Jaipur'},
        {value: 'jodhpur', label: 'Jodhpur'},
        {value: 'kota', label: 'Kota'},
        {value: 'bikaner', label: 'Bikaner'},
        {value: 'ajmer', label: 'Ajmer'},
        {value: 'udaipur', label: 'Udaipur'},
        {value: 'bhilwara', label: 'Bhilwara'},
        {value: 'alwar', label: 'Alwar'},
        {value: 'bharatpur', label: 'Bharatpur'},
        {value: 'sikar', label: 'Sikar'},
        {value: 'other', label: 'Other'}
    ],
    'sikkim': [
        {value: 'gangtok', label: 'Gangtok'},
        {value: 'namchi', label: 'Namchi'},
        {value: 'other', label: 'Other'}
    ],
    'tamil_nadu': [
        {value: 'chennai', label: 'Chennai'},
        {value: 'coimbatore', label: 'Coimbatore'},
        {value: 'madurai', label: 'Madurai'},
        {value: 'tiruchirappalli', label: 'Tiruchirappalli'},
        {value: 'salem', label: 'Salem'},
        {value: 'tirunelveli', label: 'Tirunelveli'},
        {value: 'tiruppur', label: 'Tiruppur'},
        {value: 'erode', label: 'Erode'},
        {value: 'vellore', label: 'Vellore'},
        {value: 'thoothukudi', label: 'Thoothukudi'},
        {value: 'other', label: 'Other'}
    ],
    'telangana': [
        {value: 'hyderabad', label: 'Hyderabad'},
        {value: 'warangal', label: 'Warangal'},
        {value: 'nizamabad', label: 'Nizamabad'},
        {value: 'karimnagar', label: 'Karimnagar'},
        {value: 'khammam', label: 'Khammam'},
        {value: 'ramagundam', label: 'Ramagundam'},
        {value: 'secunderabad', label: 'Secunderabad'},
        {value: 'other', label: 'Other'}
    ],
    'tripura': [
        {value: 'agartala', label: 'Agartala'},
        {value: 'other', label: 'Other'}
    ],
    'uttar_pradesh': [
        {value: 'lucknow', label: 'Lucknow'},
        {value: 'kanpur', label: 'Kanpur'},
        {value: 'ghaziabad', label: 'Ghaziabad'},
        {value: 'agra', label: 'Agra'},
        {value: 'meerut', label: 'Meerut'},
        {value: 'varanasi', label: 'Varanasi'},
        {value: 'prayagraj', label: 'Prayagraj'},
        {value: 'bareilly', label: 'Bareilly'},
        {value: 'aligarh', label: 'Aligarh'},
        {value: 'moradabad', label: 'Moradabad'},
        {value: 'saharanpur', label: 'Saharanpur'},
        {value: 'gorakhpur', label: 'Gorakhpur'},
        {value: 'noida', label: 'Noida'},
        {value: 'firozabad', label: 'Firozabad'},
        {value: 'jhansi', label: 'Jhansi'},
        {value: 'other', label: 'Other'}
    ],
    'uttarakhand': [
        {value: 'dehradun', label: 'Dehradun'},
        {value: 'haridwar', label: 'Haridwar'},
        {value: 'roorkee', label: 'Roorkee'},
        {value: 'haldwani', label: 'Haldwani'},
        {value: 'rudrapur', label: 'Rudrapur'},
        {value: 'kashipur', label: 'Kashipur'},
        {value: 'rishikesh', label: 'Rishikesh'},
        {value: 'other', label: 'Other'}
    ],
    'west_bengal': [
        {value: 'kolkata', label: 'Kolkata'},
        {value: 'howrah', label: 'Howrah'},
        {value: 'durgapur', label: 'Durgapur'},
        {value: 'asansol', label: 'Asansol'},
        {value: 'siliguri', label: 'Siliguri'},
        {value: 'bardhaman', label: 'Bardhaman'},
        {value: 'malda', label: 'Malda'},
        {value: 'kharagpur', label: 'Kharagpur'},
        {value: 'other', label: 'Other'}
    ],
    'other': [
        {value: 'other', label: 'Other'}
    ]
};

// Function to populate cities based on selected state
function populateCities(stateValue, selectedCity = null) {
    const citySelect = document.getElementById('city_select');
    if (!citySelect) return;
    
    // Clear existing options
    citySelect.innerHTML = '<option value="" disabled selected>SELECT CITY</option>';
    
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
    }
}

// Initialize state-city dropdown on page load
document.addEventListener('DOMContentLoaded', function() {
    const stateSelect = document.getElementById('state_select');
    const oldCity = document.getElementById('old_city')?.value;
    
    if (stateSelect) {
        // If state is already selected (e.g., from existing data or old input), populate cities
        if (stateSelect.value) {
            populateCities(stateSelect.value, oldCity);
        }
        
        // Add change event listener
        stateSelect.addEventListener('change', function() {
            populateCities(this.value);
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
