@extends('layouts.macos')

@section('page_title','Edit Inquiry')

@section('content')
<script>
// File upload handler - runs immediately when DOM is ready
(function(){
  function initFileUpload() {
    var fileInput = document.getElementById('quotation_file');
    var filenameDisplay = document.getElementById('quotation_filename');
    var previewContainer = document.getElementById('quotation_preview_container');
    var previewImage = document.getElementById('quotation_preview');
    var fileIconContainer = document.getElementById('quotation_file_icon');
    var fileNameSpan = document.getElementById('quotation_file_name');
    var defaultFilename = filenameDisplay ? filenameDisplay.textContent : 'No File Chosen';
    
    if(fileInput && filenameDisplay){
      fileInput.addEventListener('change', function(){
        // Hide previews initially
        if(previewContainer) previewContainer.style.display = 'none';
        if(fileIconContainer) fileIconContainer.style.display = 'none';
        
        if(this.files && this.files.length > 0){
          var file = this.files[0];
          var fileName = file.name;
          var fileExt = fileName.split('.').pop().toLowerCase();
          var allowedExts = ['pdf', 'doc', 'docx', 'png', 'jpg', 'jpeg'];
          var imageExts = ['png', 'jpg', 'jpeg'];
          
          // Validate file type
          if(allowedExts.indexOf(fileExt) === -1){
            alert('Invalid file type. Please upload PDF, DOC, DOCX, PNG, JPG, or JPEG files only.');
            this.value = '';
            filenameDisplay.textContent = defaultFilename;
            filenameDisplay.style.color = '#9ca3af';
            return;
          }
          
          // Validate file size (2MB)
          if(file.size > 2 * 1024 * 1024){
            alert('File size exceeds 2MB limit.');
            this.value = '';
            filenameDisplay.textContent = defaultFilename;
            filenameDisplay.style.color = '#9ca3af';
            return;
          }
          
          // Update filename display
          filenameDisplay.textContent = fileName;
          filenameDisplay.style.color = '#374151';
          
          // Show image preview for images
          if(imageExts.indexOf(fileExt) !== -1){
            var reader = new FileReader();
            reader.onload = function(e){
              if(previewImage && previewContainer){
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
              }
            };
            reader.readAsDataURL(file);
          } else {
            // Show file icon for documents
            if(fileIconContainer && fileNameSpan){
              fileNameSpan.textContent = fileName;
              // Hide view link for new files
              var viewLink = fileIconContainer.querySelector('a');
              if(viewLink) viewLink.style.display = 'none';
              fileIconContainer.style.display = 'block';
            }
          }
        } else {
          filenameDisplay.textContent = defaultFilename;
          filenameDisplay.style.color = '#9ca3af';
        }
      });
    }
  }
  
  // Run when DOM is ready
  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', initFileUpload);
  } else {
    initFileUpload();
  }
})();
</script>
<style>
  .Rectangle-29::placeholder,
  .Rectangle-29-textarea::placeholder {
    color: #9ca3af;
  }
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
<div class="Rectangle-30 hrp-compact">

  <form id="inquiryForm" method="POST" action="{{ route('inquiries.update', $inquiry->id) }}" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
    @csrf
    @method('PUT')

    <!-- Row 1: Unique Code and Inquiry Date -->
    <div>
      <label class="hrp-label">Unique Code:</label>
      <input class="hrp-input Rectangle-29" name="unique_code" value="{{ old('unique_code', $inquiry->unique_code) }}" readonly />
      @error('unique_code')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>
    <div>
      <label class="hrp-label">Inquiry Date (dd/mm/yy) :</label>
      <input
        type="text"
        class="hrp-input Rectangle-29 date-picker"
        name="inquiry_date"
        value="{{ old('inquiry_date', optional($inquiry->inquiry_date)->format('d/m/Y')) }}"
        placeholder="dd/mm/yyyy"
        autocomplete="off"
        readonly
      />
      @error('inquiry_date')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <!-- Row 2: Company Name and Company Address -->
    <div>
      <label class="hrp-label">Company Name :</label>
      <input class="hrp-input Rectangle-29" name="company_name" value="{{ old('company_name', $inquiry->company_name) }}" placeholder="Enter your company name" />
      @error('company_name')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>
    <div>
      <label class="hrp-label">Company Address:</label>
      <textarea class="hrp-textarea Rectangle-29 Rectangle-29-textarea" name="company_address" placeholder="Enter Your Address" style="height:58px;resize:none;">{{ old('company_address', $inquiry->company_address) }}</textarea>
      @error('company_address')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <!-- Row 3: Industry Type and Email -->
    <div>
      <label class="hrp-label">Industry Type :</label>
      @php
        $industries = [
          'Information Technology',
          'Business Process Outsourcing (BPO)',
          'Manufacturing',
          'Automobile',
          'Textiles & Apparel',
          'Pharmaceuticals & Healthcare',
          'Banking, Financial Services & Insurance (BFSI)',
          'Retail & E-commerce',
          'Telecommunications',
          'Real Estate & Construction',
          'Education & Training',
          'Hospitality & Tourism',
          'Logistics & Transportation',
          'Agriculture & Agritech',
          'Media & Entertainment',
        ];
      @endphp
      <select class="Rectangle-29 Rectangle-29-select @error('industry_type') is-invalid @enderror" name="industry_type">
        <option value="">Select Industry Type</option>
        @foreach($industries as $industry)
          <option value="{{ $industry }}" {{ old('industry_type', $inquiry->industry_type) == $industry ? 'selected' : '' }}>{{ $industry }}</option>
        @endforeach
      </select>
      @error('industry_type')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>
    <div>
      <label class="hrp-label">Email :</label>
      <input class="hrp-input Rectangle-29" type="email" name="email" value="{{ old('email', $inquiry->email) }}" placeholder="Enter Company Email" />
      @error('email')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <!-- Row 4: Company Mo. No. and State -->
    <div>
      <label class="hrp-label">Company Mo. No. :</label>
      <input
        class="hrp-input Rectangle-29"
        name="company_phone"
        type="tel"
        inputmode="numeric"
        pattern="\d{10}"
        maxlength="10"
        value="{{ old('company_phone', strip_country_code($inquiry->company_phone)) }}"
        placeholder="Enter 10 digit mobile number"
      />
      @error('company_phone')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>
    <div>
      <label class="hrp-label">State</label>
      <select class="Rectangle-29 Rectangle-29-select" name="state" id="state_select">
        <option value="" disabled {{ old('state', $inquiry->state) ? '' : 'selected' }}>SELECT STATE</option>
        <option value="andhra_pradesh" {{ old('state', $inquiry->state) == 'andhra_pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
        <option value="arunachal_pradesh" {{ old('state', $inquiry->state) == 'arunachal_pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
        <option value="assam" {{ old('state', $inquiry->state) == 'assam' ? 'selected' : '' }}>Assam</option>
        <option value="bihar" {{ old('state', $inquiry->state) == 'bihar' ? 'selected' : '' }}>Bihar</option>
        <option value="chhattisgarh" {{ old('state', $inquiry->state) == 'chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
        <option value="delhi" {{ old('state', $inquiry->state) == 'delhi' ? 'selected' : '' }}>Delhi</option>
        <option value="goa" {{ old('state', $inquiry->state) == 'goa' ? 'selected' : '' }}>Goa</option>
        <option value="gujarat" {{ old('state', $inquiry->state) == 'gujarat' ? 'selected' : '' }}>Gujarat</option>
        <option value="haryana" {{ old('state', $inquiry->state) == 'haryana' ? 'selected' : '' }}>Haryana</option>
        <option value="himachal_pradesh" {{ old('state', $inquiry->state) == 'himachal_pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
        <option value="jammu_kashmir" {{ old('state', $inquiry->state) == 'jammu_kashmir' ? 'selected' : '' }}>Jammu & Kashmir</option>
        <option value="jharkhand" {{ old('state', $inquiry->state) == 'jharkhand' ? 'selected' : '' }}>Jharkhand</option>
        <option value="karnataka" {{ old('state', $inquiry->state) == 'karnataka' ? 'selected' : '' }}>Karnataka</option>
        <option value="kerala" {{ old('state', $inquiry->state) == 'kerala' ? 'selected' : '' }}>Kerala</option>
        <option value="ladakh" {{ old('state', $inquiry->state) == 'ladakh' ? 'selected' : '' }}>Ladakh</option>
        <option value="madhya_pradesh" {{ old('state', $inquiry->state) == 'madhya_pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
        <option value="maharashtra" {{ old('state', $inquiry->state) == 'maharashtra' ? 'selected' : '' }}>Maharashtra</option>
        <option value="manipur" {{ old('state', $inquiry->state) == 'manipur' ? 'selected' : '' }}>Manipur</option>
        <option value="meghalaya" {{ old('state', $inquiry->state) == 'meghalaya' ? 'selected' : '' }}>Meghalaya</option>
        <option value="mizoram" {{ old('state', $inquiry->state) == 'mizoram' ? 'selected' : '' }}>Mizoram</option>
        <option value="nagaland" {{ old('state', $inquiry->state) == 'nagaland' ? 'selected' : '' }}>Nagaland</option>
        <option value="odisha" {{ old('state', $inquiry->state) == 'odisha' ? 'selected' : '' }}>Odisha</option>
        <option value="punjab" {{ old('state', $inquiry->state) == 'punjab' ? 'selected' : '' }}>Punjab</option>
        <option value="rajasthan" {{ old('state', $inquiry->state) == 'rajasthan' ? 'selected' : '' }}>Rajasthan</option>
        <option value="sikkim" {{ old('state', $inquiry->state) == 'sikkim' ? 'selected' : '' }}>Sikkim</option>
        <option value="tamil_nadu" {{ old('state', $inquiry->state) == 'tamil_nadu' ? 'selected' : '' }}>Tamil Nadu</option>
        <option value="telangana" {{ old('state', $inquiry->state) == 'telangana' ? 'selected' : '' }}>Telangana</option>
        <option value="tripura" {{ old('state', $inquiry->state) == 'tripura' ? 'selected' : '' }}>Tripura</option>
        <option value="uttar_pradesh" {{ old('state', $inquiry->state) == 'uttar_pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
        <option value="uttarakhand" {{ old('state', $inquiry->state) == 'uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
        <option value="west_bengal" {{ old('state', $inquiry->state) == 'west_bengal' ? 'selected' : '' }}>West Bengal</option>
        {{-- Union Territories --}}
        <option value="andaman_nicobar" {{ old('state', $inquiry->state) == 'andaman_nicobar' ? 'selected' : '' }}>Andaman & Nicobar Islands</option>
        <option value="chandigarh" {{ old('state', $inquiry->state) == 'chandigarh' ? 'selected' : '' }}>Chandigarh</option>
        <option value="dadra_nagar_haveli_daman_diu" {{ old('state', $inquiry->state) == 'dadra_nagar_haveli_daman_diu' ? 'selected' : '' }}>Dadra & Nagar Haveli and Daman & Diu</option>
        <option value="lakshadweep" {{ old('state', $inquiry->state) == 'lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
        <option value="puducherry" {{ old('state', $inquiry->state) == 'puducherry' ? 'selected' : '' }}>Puducherry</option>
        <option value="other" {{ old('state', $inquiry->state) == 'other' ? 'selected' : '' }}>Other</option>
      </select>
      <input type="text" name="state_other" id="state_other_input" class="Rectangle-29 hrp-input" placeholder="Enter State Name" value="{{ old('state_other', $inquiry->state_other) }}" style="display: {{ old('state', $inquiry->state) == 'other' ? 'block' : 'none' }}; margin-top: 8px;">
      @error('state')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <!-- Row 5: City and Contact Person Mobile No -->
    <div>
      <label class="hrp-label">City</label>
      <select class="Rectangle-29 Rectangle-29-select" name="city" id="city_select">
        <option value="" disabled selected>SELECT STATE FIRST</option>
      </select>
      <input type="hidden" id="old_city" value="{{ old('city', $inquiry->city) }}">
      <input type="hidden" id="old_city_other" value="{{ old('city_other', $inquiry->city_other) }}">
      <input type="text" name="city_other" id="city_other_input" class="Rectangle-29 hrp-input" placeholder="Enter City Name" value="{{ old('city_other', $inquiry->city_other) }}" style="display: {{ old('city', $inquiry->city) == 'other' ? 'block' : 'none' }}; margin-top: 8px;">
      @error('city')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>
    <div>
      <label class="hrp-label">Contact Person Mobile No:</label>
      <input
        class="hrp-input Rectangle-29"
        name="contact_mobile"
        type="tel"
        inputmode="numeric"
        pattern="\d{10}"
        maxlength="10"
        value="{{ old('contact_mobile', strip_country_code($inquiry->contact_mobile)) }}"
        placeholder="Enter 10 digit mobile number"
      />
      @error('contact_mobile')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <!-- Row 6: Contact Person Name and Scope Link -->
    <div>
      <label class="hrp-label">Contact Person Name:</label>
      <input class="hrp-input Rectangle-29" name="contact_name" value="{{ old('contact_name', $inquiry->contact_name) }}" placeholder="Enter Contact Person Name" />
      @error('contact_name')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>
    <div>
      <label class="hrp-label">Scope Link:</label>
      <input class="hrp-input Rectangle-29" name="scope_link" value="{{ old('scope_link', $inquiry->scope_link) }}" placeholder="Enter Scope Link" />
      @error('scope_link')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <!-- Row 7: Contact Person Position and Quotation Upload -->
    <div>
      <label class="hrp-label">Contact Person Position:</label>
      <input class="hrp-input Rectangle-29" name="contact_position" value="{{ old('contact_position', $inquiry->contact_position) }}" placeholder="Enter Contact Person Position" />
      @error('contact_position')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>
    <div>
      <label class="hrp-label">Quotation Upload:</label>
      <div class="upload-pill Rectangle-29">
        <div class="choose">Choose File</div>
        <div class="filename" id="quotation_filename">{{ $inquiry->quotation_file ? basename($inquiry->quotation_file) : 'No File Chosen' }}</div>
        <input type="file" id="quotation_file" name="quotation_file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/png,image/jpeg">
      </div>
      <small class="text-muted" style="font-size:0.75rem;color:#6b7280;">Allowed: PDF, DOC, DOCX, PNG, JPG, JPEG (Max 2MB)</small>
      @error('quotation_file')<small class="hrp-error">{{ $message }}</small>@enderror
      <!-- Image Preview -->
      <div id="quotation_preview_container" style="{{ $inquiry->quotation_file && in_array(strtolower(pathinfo($inquiry->quotation_file, PATHINFO_EXTENSION)), ['png', 'jpg', 'jpeg']) ? 'display:block' : 'display:none' }};margin-top:10px;">
        @if($inquiry->quotation_file && in_array(strtolower(pathinfo($inquiry->quotation_file, PATHINFO_EXTENSION)), ['png', 'jpg', 'jpeg']))
          <img id="quotation_preview" src="{{ storage_asset($inquiry->quotation_file) }}" alt="Preview" style="max-width:150px;max-height:150px;border-radius:8px;border:1px solid #e5e7eb;">
        @else
          <img id="quotation_preview" src="" alt="Preview" style="max-width:150px;max-height:150px;border-radius:8px;border:1px solid #e5e7eb;">
        @endif
      </div>
      <!-- File Icon for non-image files -->
      <div id="quotation_file_icon" style="{{ $inquiry->quotation_file && !in_array(strtolower(pathinfo($inquiry->quotation_file, PATHINFO_EXTENSION)), ['png', 'jpg', 'jpeg']) ? 'display:block' : 'display:none' }};margin-top:10px;">
        <div style="display:flex;align-items:center;gap:8px;padding:8px 12px;background:#f3f4f6;border-radius:8px;max-width:fit-content;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
          </svg>
          <span id="quotation_file_name" style="font-size:0.875rem;color:#374151;">{{ $inquiry->quotation_file ? basename($inquiry->quotation_file) : '' }}</span>
          @if($inquiry->quotation_file)
            <a href="{{ storage_asset($inquiry->quotation_file) }}" target="_blank" style="color:#3b82f6;font-size:0.75rem;">View</a>
          @endif
        </div>
      </div>
    </div>

    <!-- Row 8: Quotation Sent -->
    <div>
      <label class="hrp-label">Quotation Sent:</label>
      <select class="Rectangle-29-select" name="quotation_sent">
        <option value="">Select Option</option>
        <option value="Yes" {{ old('quotation_sent', $inquiry->quotation_sent) === 'Yes' ? 'selected' : '' }}>Yes</option>
        <option value="No" {{ old('quotation_sent', $inquiry->quotation_sent) === 'No' ? 'selected' : '' }}>No</option>
      </select>
      @error('quotation_sent')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <div class="md:col-span-2">
      <div style="display:flex;justify-content:flex-end;margin-top:30px;">
        <button type="submit" class="hrp-btn hrp-btn-primary">Update Inquiry</button>
      </div>
    </div>
  </form>
</div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('inquiries.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Inquiry Management</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Edit Inquiry</span>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
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
function populateCities(stateValue, selectedCity = null, isInitialLoad = false) {
    const citySelect = document.getElementById('city_select');
    const cityOtherInput = document.getElementById('city_other_input');
    const oldCityOtherValue = document.getElementById('old_city_other')?.value;
    if (!citySelect) return;
    
    // Clear existing options
    citySelect.innerHTML = '<option value="" disabled selected>SELECT CITY</option>';
    
    // Only clear city other input when user changes state (not on initial load)
    if (cityOtherInput && !isInitialLoad) {
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
        
        // If selected city is "other", show the other input and restore value
        if (selectedCity === 'other' && cityOtherInput) {
            cityOtherInput.style.display = 'block';
            // On initial load, restore the saved city_other value
            if (isInitialLoad && oldCityOtherValue) {
                cityOtherInput.value = oldCityOtherValue;
            }
        }
    }
}

// Initialize jQuery datepicker with dd/mm/yyyy format (same as quotation)
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

document.addEventListener('DOMContentLoaded', function() {
  const fileInput = document.getElementById('quotation_file');
  const filenameSpan = document.querySelector('.filename');
  const form = document.getElementById('inquiryForm');
  const submitBtn = document.getElementById('submitBtn');
  const companyPhoneInput = document.querySelector('input[name="company_phone"]');
  const contactMobileInput = document.querySelector('input[name="contact_mobile"]');
  
  // Initialize state-city dropdown with "Other" text box support
  const stateSelect = document.getElementById('state_select');
  const citySelect = document.getElementById('city_select');
  const stateOtherInput = document.getElementById('state_other_input');
  const cityOtherInput = document.getElementById('city_other_input');
  const oldCity = document.getElementById('old_city')?.value;
  const oldCityOther = document.getElementById('old_city_other')?.value;
  
  if (stateSelect) {
      // If state is already selected (e.g., from old input or existing data), populate cities and show other inputs
      if (stateSelect.value) {
          // Show state other input if "other" is selected
          if (stateOtherInput) {
              toggleOtherInput(stateSelect, stateOtherInput);
          }
          // Populate cities on initial load (pass true to preserve city_other value)
          populateCities(stateSelect.value, oldCity, true);
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

  // Enforce digit-only input for mobile fields (typing and paste)
  function attachDigitOnly(input) {
    if (!input) return;
    input.addEventListener('keypress', function (e) {
      const char = String.fromCharCode(e.which || e.keyCode);
      if (!/\d/.test(char)) {
        e.preventDefault();
      }
    });
    input.addEventListener('input', function () {
      this.value = this.value.replace(/\D+/g, '').slice(0, 10);
    });
  }

  attachDigitOnly(companyPhoneInput);
  attachDigitOnly(contactMobileInput);

  // HTML5 validation-style check: just prevent submit if invalid and show browser messages
  if (form) {
    form.addEventListener('submit', function(e) {
      // Date conversion is now handled in the backend controller
      // The date is sent in dd/mm/yyyy format and converted server-side
      
      if (!form.checkValidity()) {
        e.preventDefault();
        form.reportValidity();
      }
    });
  }
});
</script>
@endpush
