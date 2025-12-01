@extends('layouts.macos')

@section('page_title','Add New Inquiry')

@section('content')
<style>
  .Rectangle-29::placeholder,
  .Rectangle-29-textarea::placeholder {
    color: #9ca3af;
  }
</style>
<div class="Rectangle-30 hrp-compact">


  <form id="inquiryForm" method="POST" action="{{ route('inquiries.store') }}" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
    @csrf

    <!-- Row 1: Unique Code and Inquiry Date -->
    <div>
      <label class="hrp-label">Unique Code:</label>
      <div class="Rectangle-29" style="display:flex;align-items:center;justify-content:space-between;background:#f3f4f6;">
        <span>{{ $nextCode ?? 'CMS/INQ/0001' }}</span>
      </div>
    </div>
    <div>
      <label class="hrp-label">Inquiry Date (dd/mm/yy) :</label>
      <input
        type="text"
        class="hrp-input Rectangle-29 date-picker"
        name="inquiry_date"
        value="{{ old('inquiry_date', now()->format('d/m/Y')) }}"
        placeholder="dd/mm/yyyy"
        autocomplete="off"
        readonly
      />
      @error('inquiry_date')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <!-- Row 2: Company Name and Company Address -->
    <div>
      <label class="hrp-label">Company Name :</label>
      <input class="hrp-input Rectangle-29" name="company_name" value="{{ old('company_name') }}" placeholder="Enter your company name" />
      @error('company_name')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>
    <div>
      <label class="hrp-label">Company Address:</label>
      <textarea class="hrp-textarea Rectangle-29 Rectangle-29-textarea" name="company_address" placeholder="Enter Your Address" style="height:58px;resize:none;">{{ old('company_address') }}</textarea>
      @error('company_address')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <!-- Row 3: Industry Type and Email -->
    <div>
      <label class="hrp-label">Industry Type :</label>
      <select class="Rectangle-29 Rectangle-29-select" name="industry_type">
        <option value="">Select Industry Type</option>
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
        @foreach($industries as $industry)
          <option value="{{ $industry }}" {{ old('industry_type') == $industry ? 'selected' : '' }}>{{ $industry }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label class="hrp-label">Email :</label>
      <input class="hrp-input Rectangle-29" type="email" name="email" value="{{ old('email') }}" placeholder="Enter Company Email" />
      @error('email')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <!-- Row 4: Company Mo. No. and City -->
    <div>
      <label class="hrp-label">Company Mo. No. :</label>
      <input
        class="hrp-input Rectangle-29"
        name="company_phone"
        type="tel"
        inputmode="numeric"
        pattern="\d{10}"
        maxlength="10"
        value="{{ old('company_phone') }}"
        placeholder="Enter 10 digit mobile number"
      />
      @error('company_phone')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>
    <div>
      <label class="hrp-label">City</label>
      @php
        $cities = [
          'Ahmedabad','Surat','Vadodara','Rajkot','Mumbai','Pune','Delhi','Bengaluru',
          'Chennai','Hyderabad','Kolkata','Jaipur','Indore','Nagpur','Nashik','Lucknow',
          'Chandigarh','Bhopal','Coimbatore','Kochi','Noida','Gurugram'
        ];
      @endphp
      <select class="Rectangle-29 Rectangle-29-select" name="city">
        <option value="">Select City</option>
        @foreach($cities as $city)
          <option value="{{ $city }}" {{ old('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
        @endforeach
      </select>
      @error('city')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <!-- Row 5: State and Contact Person Mobile No -->
    <div>
      <label class="hrp-label">State</label>
      @php
        $states = [
          'Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat',
          'Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh',
          'Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab',
          'Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh',
          'Uttarakhand','West Bengal','Andaman and Nicobar Islands','Chandigarh',
          'Dadra and Nagar Haveli and Daman and Diu','Delhi','Jammu and Kashmir',
          'Ladakh','Lakshadweep','Puducherry'
        ];
      @endphp
      <select class="Rectangle-29 Rectangle-29-select" name="state">
        <option value="">Select State</option>
        @foreach($states as $state)
          <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>{{ $state }}</option>
        @endforeach
      </select>
      @error('state')<small class="hrp-error">{{ $message }}</small>@enderror
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
        value="{{ old('contact_mobile') }}"
        placeholder="Enter 10 digit mobile number"
      />
      @error('contact_mobile')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <!-- Row 6: Contact Person Name and Scope Link -->
    <div>
      <label class="hrp-label">Contact Person Name:</label>
      <input class="hrp-input Rectangle-29" name="contact_name" value="{{ old('contact_name') }}" placeholder="Enter Contact Person Name" />
      @error('contact_name')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>
    <div>
      <label class="hrp-label">Scope Link:</label>
      <input class="hrp-input Rectangle-29" name="scope_link" value="{{ old('scope_link') }}" placeholder="Enter Scope Link" />
      @error('scope_link')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <!-- Row 7: Contact Person Position and Quotation Upload -->
    <div>
      <label class="hrp-label">Contact Person Position:</label>
      <input class="hrp-input Rectangle-29" name="contact_position" value="{{ old('contact_position') }}" placeholder="Enter Contact Person Position" />
      @error('contact_position')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>
    <div>
      <label class="hrp-label">Quotation Upload:</label>
      <div class="upload-pill Rectangle-29">
        <div class="choose">Choose File</div>
        <div class="filename">No File Chosen</div>
        <input type="file" id="quotation_file" name="quotation_file">
      </div>
      @error('quotation_file')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <!-- Row 8: Quotation Sent -->
    <div>
      <label class="hrp-label">Quotation Sent:</label>
      <select class="Rectangle-29-select" name="quotation_sent">
        <option value="">Select Option</option>
        <option value="Yes" {{ old('quotation_sent') === 'Yes' ? 'selected' : '' }}>Yes</option>
        <option value="No" {{ old('quotation_sent') === 'No' ? 'selected' : '' }}>No</option>
      </select>
    </div>

    <div class="md:col-span-2">
      <div style="display:flex;justify-content:flex-end;margin-top:30px;">
        <button type="submit" class="inquiry-submit-btn" id="submitBtn">Add Inquiry</button>
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
  <span class="hrp-bc-current">Add New Inquiry</span>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
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
  
  if (fileInput && filenameSpan) {
    fileInput.addEventListener('change', function() {
      if (this.files && this.files[0]) {
        filenameSpan.textContent = this.files[0].name;
        filenameSpan.style.color = '#374151';
      } else {
        filenameSpan.textContent = 'No file Chosen';
        filenameSpan.style.color = '#9ca3af';
      }
    });
  }
  
  // HTML5 validation on submit (same pattern as hiring/create)
  if (form) {
    form.addEventListener('submit', function(e) {
      // Convert date from dd/mm/yyyy to yyyy-mm-dd before submission
      var dateInput = document.querySelector('input[name="inquiry_date"]');
      if(dateInput && dateInput.value){
        var parts = dateInput.value.split('/');
        if(parts.length === 3){
          var day = parts[0];
          var month = parts[1];
          var year = parts[2];
          dateInput.value = year + '-' + month + '-' + day;
        }
      }
      
      if (!form.checkValidity()) {
        e.preventDefault();
        form.reportValidity();
      }
    });
  }
});
</script>
@endpush
