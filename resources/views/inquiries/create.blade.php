@extends('layouts.macos')

@section('page_title','Add New Inquiry')

@section('content')
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
      <select class="Rectangle-29 Rectangle-29-select @error('industry_type') is-invalid @enderror" name="industry_type">
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
      @error('industry_type')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>
    <div>
      <label class="hrp-label">Email :</label>
      <input class="hrp-input Rectangle-29" type="email" name="email" value="{{ old('email') }}" placeholder="Enter Company Email" />
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
        value="{{ old('company_phone') }}"
        placeholder="Enter 10 digit mobile number"
      />
      @error('company_phone')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>
    <div>
      <label class="hrp-label">State</label>
      <select class="Rectangle-29 Rectangle-29-select" name="state" id="state_select">
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
      <input type="text" name="state_other" id="state_other_input" class="Rectangle-29 Rectangle-29-select" placeholder="Enter State Name" value="{{ old('state_other') }}" style="display: {{ old('state') == 'other' ? 'block' : 'none' }}; margin-top: 8px;">
      @error('state')<small class="hrp-error">{{ $message }}</small>@enderror
    </div>

    <!-- Row 5: City and Contact Person Mobile No -->
    <div>
      <label class="hrp-label">City</label>
      <select class="Rectangle-29 Rectangle-29-select" name="city" id="city_select">
        <option value="" disabled selected>SELECT STATE FIRST</option>
      </select>
      <input type="hidden" id="old_city" value="{{ old('city') }}">
      <input type="text" name="city_other" id="city_other_input" class="Rectangle-29 Rectangle-29-select" placeholder="Enter City Name" value="{{ old('city_other') }}" style="display: none; margin-top: 8px;">
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
  
  if (stateSelect) {
      // If state is already selected (e.g., from old input), populate cities and show other inputs
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
