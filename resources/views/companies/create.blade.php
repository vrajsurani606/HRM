@extends('layouts.macos')
@section('page_title', 'Add Company')
@section('content')
  <div class="hrp-card">
    {{-- <div class="hrp-card-header flex items-center justify-between gap-4">
      <h2 class="hrp-card-title">Add Company</h2>
    </div> --}}
    <div class="hrp-card-body">
      <div class="Rectangle-30 hrp-compact">
        <form method="POST" action="#" enctype="multipart/form-data" class="hrp-form grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5" id="companyForm">
          @csrf
          
          <div class="md:col-span-2" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 8px;">
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Unique Code</label>
              <input name="unique_code" value="CMS/LTD/0001" placeholder="CMS/LTD/0001" class="hrp-input Rectangle-29" readonly style="font-size: 14px; line-height: 1.5;">
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">GST No</label>
              <input name="gst_no" type="text" placeholder="Enter GST No" class="hrp-input Rectangle-29" maxlength="15" style="font-size: 14px; line-height: 1.5;">
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Pan No</label>
              <input name="pan_no" type="text" placeholder="Enter PAN No" class="hrp-input Rectangle-29" maxlength="10" style="text-transform: uppercase; font-size: 14px; line-height: 1.5;">
            </div>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Name</label>
            <input name="company_name" type="text" placeholder="Enter your company name" class="hrp-input Rectangle-29" required style="font-size: 14px; line-height: 1.5;">
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Address</label>
            <textarea name="company_address" placeholder="Enter Your Address" class="hrp-textarea Rectangle-29 Rectangle-29-textarea" rows="3" style="font-size: 14px; line-height: 1.5; resize: vertical;"></textarea>
          </div>

          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Type</label>
            <select name="company_type" class="Rectangle-29 Rectangle-29-select" style="font-size: 14px; line-height: 1.5;">
              <option value="" disabled selected>Select Company Type</option>
            </select>
          </div>
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">State</label>
            <input name="state" placeholder="Enter State" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">City</label>
            <input name="city" placeholder="Enter City Name" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Contact Person Name</label>
            <input name="contact_person_name" placeholder="Enter Contact Person Name" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Contact Person Mobile No</label>
            <input name="contact_person_mobile" type="tel" placeholder="Enter Contact Person Mobile No" class="hrp-input Rectangle-29" pattern="[0-9]{10}" maxlength="10" style="font-size: 14px; line-height: 1.5;">
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Contact Person Position</label>
            <input name="contact_person_position" placeholder="Enter Contact Person Position" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Scope Link</label>
            <input name="scope_link" type="url" placeholder="Enter Scope Link" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">SOP Upload</label>
            <div class="upload-pill Rectangle-29">
              <div class="choose" style="font-size: 14px;">Choose File</div>
              <div class="filename" id="sopFileName" style="font-size: 14px;">No File Chosen</div>
              <input id="sopInput" name="sop_upload" type="file">
            </div>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Quotation Upload</label>
            <div class="upload-pill Rectangle-29">
              <div class="choose" style="font-size: 14px;">Choose File</div>
              <div class="filename" id="quotationFileName" style="font-size: 14px;">No File Chosen</div>
              <input id="quotationInput" name="quotation_upload" type="file">
            </div>
          </div>
          
          <div class="md:col-span-2 grid grid-cols-3 gap-5" style="margin-bottom: 12px;">
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Name</label>
              <input name="person_name_1" placeholder="Enter Person Name" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Number</label>
              <input name="person_number_1" placeholder="Enter Person Number" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Position</label>
              <input name="person_position_1" placeholder="Enter Person Position" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            </div>
          </div>
          
          <div class="md:col-span-2 grid grid-cols-3 gap-5" style="margin-bottom: 12px;">
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Name</label>
              <input name="person_name_2" placeholder="Enter Person Name" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Number</label>
              <input name="person_number_2" placeholder="Enter Person Number" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Position</label>
              <input name="person_position_2" placeholder="Enter Person Position" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            </div>
          </div>
          
          <div class="md:col-span-2 grid grid-cols-3 gap-5" style="margin-bottom: 12px;">
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Name</label>
              <input name="person_name_3" placeholder="Enter Person Name" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Number</label>
              <input name="person_number_3" placeholder="Enter Person Number" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            </div>
            <div>
              <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Person Position</label>
              <input name="person_position_3" placeholder="Enter Person Position" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
            </div>
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Email</label>
            <input name="company_email" type="email" placeholder="Enter Company Email" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Password</label>
            <input name="company_password" type="password" placeholder="Enter Company Password" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Employee Email</label>
            <input name="company_employee_email" type="email" placeholder="Enter Company Employee Email" class="hrp-input Rectangle-29" style="font-size: 14px; line-height: 1.5;">
          </div>
          
          <div style="margin-bottom: 8px;">
            <label class="hrp-label" style="font-weight: 500; margin-bottom: 8px; display: block; color: #374151; font-size: 14px;">Company Employee Password</label>
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