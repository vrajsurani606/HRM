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
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">GST No</label>
              <input name="gst_no" type="text" placeholder="Enter GST No" value="{{ old('gst_no') }}" class="hrp-input Rectangle-29" maxlength="15" style="font-size: 14px; line-height: 1.5;">
              @error('gst_no')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Pan No</label>
              <input name="pan_no" type="text" placeholder="Enter PAN No" value="{{ old('pan_no') }}" class="hrp-input Rectangle-29" maxlength="10" style="text-transform: uppercase; font-size: 14px; line-height: 1.5;">
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
            cursor:pointer; text-transform:uppercase; width:100%;
            background-image:url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%236b7280\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpolyline points=\'6 9 12 15 18 9\'/%3E%3C/svg%3E');">

            <option value="" disabled {{ old('company_type') ? '' : 'selected' }}>SELECT COMPANY TYPE</option>
            <option value="AUTOMOBILE" {{ old('company_type') == 'AUTOMOBILE' ? 'selected' : '' }}>AUTOMOBILE</option>
            <option value="FMCG" {{ old('company_type') == 'FMCG' ? 'selected' : '' }}>FMCG (FAST-MOVING CONSUMER GOODS)</option>
            <option value="IT" {{ old('company_type') == 'IT' ? 'selected' : '' }}>INFORMATION TECHNOLOGY</option>
            <option value="MANUFACTURING" {{ old('company_type') == 'MANUFACTURING' ? 'selected' : '' }}>MANUFACTURING</option>
            <option value="CONSTRUCTION">CONSTRUCTION</option>
            <option value="HEALTHCARE">HEALTHCARE</option>
            <option value="EDUCATION">EDUCATION</option>
            <option value="FINANCE">FINANCE & BANKING</option>
            <option value="RETAIL">RETAIL</option>
            <option value="TELECOM">TELECOMMUNICATIONS</option>
            <option value="HOSPITALITY">HOSPITALITY</option>
            <option value="TRANSPORT">TRANSPORT & LOGISTICS</option>
            <option value="ENERGY">ENERGY & UTILITIES</option>
            <option value="MEDIA">MEDIA & ENTERTAINMENT</option>
            <option value="REAL_ESTATE">REAL ESTATE</option>
            <option value="OTHER">OTHER</option>
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
        <select name="state" class="hrp-input Rectangle-29"
            style="padding-right:32px; appearance:none; background-repeat:no-repeat;
            background-position:right 12px center; background-size:16px;
            cursor:pointer; width:100%; text-transform:capitalize;
            background-image:url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%236b7280\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpolyline points=\'6 9 12 15 18 9\'/%3E%3C/svg%3E');">

            <option value="" disabled {{ old('state') ? '' : 'selected' }}>SELECT STATE</option>
            <option value="andhra_pradesh">Andhra Pradesh</option>
            <option value="arunachal_pradesh">Arunachal Pradesh</option>
            <option value="assam">Assam</option>
            <option value="bihar">Bihar</option>
            <option value="chhattisgarh">Chhattisgarh</option>
            <option value="goa">Goa</option>
            <option value="gujarat">Gujarat</option>
            <option value="haryana">Haryana</option>
            <option value="himachal_pradesh">Himachal Pradesh</option>
            <option value="jharkhand">Jharkhand</option>
            <option value="karnataka">Karnataka</option>
            <option value="kerala">Kerala</option>
            <option value="maharashtra">Maharashtra</option>
            <option value="madhya_pradesh">Madhya Pradesh</option>
            <option value="odisha">Odisha</option>
            <option value="punjab">Punjab</option>
            <option value="rajasthan">Rajasthan</option>
            <option value="tamil_nadu">Tamil Nadu</option>
            <option value="telangana">Telangana</option>
            <option value="uttar_pradesh">Uttar Pradesh</option>
            <option value="uttarakhand">Uttarakhand</option>
            <option value="west_bengal">West Bengal</option>
            <option value="other">Other</option>
        </select>
    </div>
    @error('state') <small class="hrp-error">{{ $message }}</small> @enderror
</div>


<div class="mb-2">
    <label class="hrp-label"
        style="font-weight:500; margin-bottom:8px; display:block; color:#374151; font-size:14px;">
        City
    </label>

    <div class="relative">
        <select name="city" class="hrp-input Rectangle-29"
            style="padding-right:32px; appearance:none; background-repeat:no-repeat;
            background-position:right 12px center; background-size:16px;
            cursor:pointer; width:100%; text-transform:capitalize;
            background-image:url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%236b7280\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpolyline points=\'6 9 12 15 18 9\'/%3E%3C/svg%3E');">

            <option value="" disabled {{ old('city') ? '' : 'selected' }}>SELECT CITY</option>
            <option value="mumbai">Mumbai</option>
            <option value="delhi">Delhi</option>
            <option value="bengaluru">Bengaluru</option>
            <option value="hyderabad">Hyderabad</option>
            <option value="ahmedabad">Ahmedabad</option>
            <option value="chennai">Chennai</option>
            <option value="kolkata">Kolkata</option>
            <option value="surat">Surat</option>
            <option value="pune">Pune</option>
            <option value="jaipur">Jaipur</option>
            <option value="lucknow">Lucknow</option>
            <option value="kanpur">Kanpur</option>
            <option value="nagpur">Nagpur</option>
            <option value="indore">Indore</option>
            <option value="thane">Thane</option>
            <option value="bhopal">Bhopal</option>
            <option value="visakhapatnam">Visakhapatnam</option>
            <option value="patna">Patna</option>
            <option value="vadodara">Vadodara</option>
            <option value="ghaziabad">Ghaziabad</option>
            <option value="ludhiana">Ludhiana</option>
            <option value="agra">Agra</option>
            <option value="nashik">Nashik</option>
            <option value="faridabad">Faridabad</option>
            <option value="meerut">Meerut</option>
            <option value="rajkot">Rajkot</option>
            <option value="varanasi">Varanasi</option>
            <option value="srinagar">Srinagar</option>
            <option value="aurangabad">Aurangabad</option>
            <option value="dhanbad">Dhanbad</option>
            <option value="amritsar">Amritsar</option>
            <option value="navi_mumbai">Navi Mumbai</option>
            <option value="ranchi">Ranchi</option>
            <option value="other">Other</option>
        </select>
    </div>
    @error('city') <small class="hrp-error">{{ $message }}</small> @enderror
</div>


<div class="mb-2">
    <label class="hrp-label"
        style="font-weight:500; margin-bottom:8px; display:block; color:#374151; font-size:14px;">
        Contact Person Name
    </label>

    <input name="contact_person_name" placeholder="Enter Contact Person Name"
        value="{{ old('contact_person_name') }}"
        class="hrp-input Rectangle-29" style="font-size:14px; line-height:1.5;">

    @error('contact_person_name') <small class="hrp-error">{{ $message }}</small> @enderror
</div>

          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Contact Person Mobile No</label>
            <input name="contact_person_mobile" type="tel" placeholder="Enter Contact Person Mobile No" value="{{ old('contact_person_mobile') }}" class="hrp-input Rectangle-29" pattern="[0-9]{10}" maxlength="10" style="font-size: 14px; line-height: 1.5;">
            @error('contact_person_mobile')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Contact Person Position</label>
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
              <input id="sopInput" name="sop_upload" type="file" style="display: none;" onchange="updateFileName(this, 'sopFileName')" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
            </div>
            @error('sop_upload')<small class="hrp-error">{{ $message }}</small>@enderror
            <small class="text-gray-500 text-xs">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 5MB)</small>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Quotation Upload</label>
            <div class="upload-pill Rectangle-29" onclick="document.getElementById('quotationInput').click()">
              <div class="choose" style="font-size: 14px;">Choose File</div>
              <div class="filename" id="quotationFileName" style="font-size: 14px;">No File Chosen</div>
              <input id="quotationInput" name="quotation_upload" type="file" style="display: none;" onchange="updateFileName(this, 'quotationFileName')" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
            </div>
            @error('quotation_upload')<small class="hrp-error">{{ $message }}</small>@enderror
            <small class="text-gray-500 text-xs">Accepted formats: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG (Max: 5MB)</small>
          </div>
          
          <div class="md:col-span-2 grid grid-cols-3 gap-5" style="margin-bottom: 12px;">
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Name1</label>
              <input name="person_name_1" placeholder="Enter Person Name1" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_name_1')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Number1</label>
              <input name="person_number_1" placeholder="Enter Person Number1" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_number_1')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Position1</label>
              <input name="person_position_1" placeholder="Enter Person Position1" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_position_1')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>
          
          <div class="md:col-span-2 grid grid-cols-3 gap-5" style="margin-bottom: 12px;">
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Name2</label>
              <input name="person_name_2" placeholder="Enter Person Name2" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_name_2')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Number2</label>
              <input name="person_number_2" placeholder="Enter Person Number2" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_number_2')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Position2</label>
              <input name="person_position_2" placeholder="Enter Person Position2" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_position_2')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>
          
          <div class="md:col-span-2 grid grid-cols-3 gap-5" style="margin-bottom: 12px;">
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Name3</label>
              <input name="person_name_3" placeholder="Enter Person Name3" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_name_3')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Number3</label>
              <input name="person_number_3" placeholder="Enter Person Number3" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_number_3')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Position3</label>
              <input name="person_position_3" placeholder="Enter Person Position3" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
              @error('person_position_3')<small class="hrp-error">{{ $message }}</small>@enderror
            </div>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Logo</label>
            <div class="upload-pill Rectangle-29">
              <div class="choose" style="font-size: 14px;">Choose File</div>
              <div class="filename" id="logoFileName" style="font-size: 14px;">No File Chosen</div>
              <input id="logoInput" name="company_logo" type="file" accept="image/*">
            </div>
            @error('company_logo')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Other</label>
            <textarea name="other_details" placeholder="Enter other details" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" rows="3" style="font-size: 14px; line-height: 1.5; resize: vertical;">{{ old('other_details') }}</textarea>
            @error('other_details')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Email</label>
            <input name="company_email" type="email" placeholder="Enter Company Email" value="{{ old('company_email') }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            @error('company_email')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Password</label>
            <input name="company_password" type="password" placeholder="Enter Company Password (min 8 characters)" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;" autocomplete="new-password">
            @error('company_password')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Confirm Password</label>
            <input name="company_password_confirmation" type="password" placeholder="Confirm Company Password" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;" autocomplete="new-password">
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Employee Email</label>
            <input name="company_employee_email" type="email" placeholder="Enter Company Employee Email (must be different from company email)" value="{{ old('company_employee_email') }}" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            @error('company_employee_email')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Employee Password</label>
            <input name="company_employee_password" type="password" placeholder="Enter Employee Password (min 8 characters)" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;" autocomplete="new-password">
            @error('company_employee_password')<small class="hrp-error">{{ $message }}</small>@enderror
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Confirm Employee Password</label>
            <input name="company_employee_password" type="password" placeholder="Enter Company Employee Password" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
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
    
    var logoInput = document.getElementById('logoInput');
    var logoLabel = document.getElementById('logoFileName');
    if(logoInput && logoLabel){
      logoInput.addEventListener('change', function(){
        var name = this.files && this.files.length ? this.files[0].name : 'No File Chosen';
        logoLabel.textContent = name;
        
        // Show image preview if an image is selected
        if (this.files && this.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            var preview = document.getElementById('logoPreview');
            if (!preview) {
              preview = document.createElement('img');
              preview.id = 'logoPreview';
              preview.style.maxWidth = '150px';
              preview.style.marginTop = '10px';
              preview.style.display = 'block';
              logoLabel.parentNode.insertAdjacentElement('afterend', preview);
            }
            preview.src = e.target.result;
          }
          reader.readAsDataURL(this.files[0]);
        }
      });
    }
  })();
</script>
@endpush

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('companies.index') }}" class="hrp-link">Company</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Add Company</span>
@endsection