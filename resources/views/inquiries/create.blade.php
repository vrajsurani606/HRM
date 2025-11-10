@extends('layouts.macos')

@section('page_title','Add New Hiring Lead')

@section('content')
<div class="hrp-card">
  <div class="hrp-card-body">
    @if (session('status'))
      <div class="alert alert-success" style="border-radius:12px;">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('inquiries.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="hrp-grid">
        <div class="hrp-col-6">
          <label class="hrp-label">Unique Code:</label>
          <input class="hrp-input" name="unique_code" value="{{ old('unique_code','CMS/LEAD/0022') }}" placeholder="CMS/LEAD/0022" />
          @error('unique_code')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="hrp-col-6">
          <label class="hrp-label">Inquiry Date:</label>
          <input type="date" class="hrp-input" name="inquiry_date" value="{{ old('inquiry_date') }}" placeholder="Select your Date" />
        </div>

        <div class="hrp-col-6">
          <label class="hrp-label">Company Name:</label>
          <input class="hrp-input" name="company_name" value="{{ old('company_name') }}" placeholder="Enter your company name" />
          @error('company_name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="hrp-col-6">
          <label class="hrp-label">Company Address:</label>
          <textarea class="hrp-textarea" name="company_address" placeholder="Enter Your Address">{{ old('company_address') }}</textarea>
        </div>

        <div class="hrp-col-6">
          <label class="hrp-label">Industry Type:</label>
          <input class="hrp-input" name="industry_type" value="{{ old('industry_type') }}" placeholder="Enter Position" />
        </div>
        <div class="hrp-col-6">
          <label class="hrp-label">Email:</label>
          <input type="email" class="hrp-input" name="email" value="{{ old('email') }}" placeholder="Select your Option" />
          @error('email')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="hrp-col-6">
          <label class="hrp-label">Company Mo. No. :</label>
          <input class="hrp-input" name="company_phone" value="{{ old('company_phone') }}" placeholder="Enter Company Mobile" />
        </div>
        <div class="hrp-col-6">
          <label class="hrp-label">City</label>
          <input class="hrp-input" name="city" value="{{ old('city') }}" placeholder="Enter City" />
        </div>

        <div class="hrp-col-6">
          <label class="hrp-label">State</label>
          <input class="hrp-input" name="state" value="{{ old('state') }}" placeholder="Enter State" />
        </div>
        <div class="hrp-col-6">
          <label class="hrp-label">Contact Person Mobile No:</label>
          <input class="hrp-input" name="contact_mobile" value="{{ old('contact_mobile') }}" placeholder="Enter Contact Person Mobile No" />
        </div>

        <div class="hrp-col-6">
          <label class="hrp-label">Contact Person Name:</label>
          <input class="hrp-input" name="contact_name" value="{{ old('contact_name') }}" placeholder="Enter Contact Person Name" />
        </div>
        <div class="hrp-col-6">
          <label class="hrp-label">Scope Link:</label>
          <input class="hrp-input" name="scope_link" value="{{ old('scope_link') }}" placeholder="Enter Scope Link" />
        </div>

        <div class="hrp-col-6">
          <label class="hrp-label">Contact Person Position:</label>
          <input class="hrp-input" name="contact_position" value="{{ old('contact_position') }}" placeholder="Enter Contact Person Position" />
        </div>
        <div class="hrp-col-6">
          <label class="hrp-label">Quotation Upload:</label>
          <input type="file" class="hrp-file" name="quotation_file" />
        </div>

        <div class="hrp-col-6">
          <label class="hrp-label">Quotation Sent:</label>
          <input class="hrp-input" name="quotation_sent" value="{{ old('quotation_sent') }}" placeholder="Enter details" />
        </div>
      </div>

      <div class="hrp-actions">
        <button class="hrp-btn hrp-btn-primary" type="submit">Add Inquiry</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Add New Hiring Lead</span>
@endsection
