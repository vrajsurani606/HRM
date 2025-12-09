@extends('layouts.macos')

@section('page_title','Inquiry Details')

@section('content')
<div class="Rectangle-30 hrp-compact">
  <div class="mb-4 flex items-center justify-between">
    <h1 class="text-lg font-semibold">Inquiry Details - {{ $inquiry->unique_code }}</h1>
    <a href="{{ route('inquiries.index') }}" class="pill-btn pill-secondary">Back to List</a>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
    <div>
      <label class="hrp-label">Inquiry Date</label>
      <div class="Rectangle-29">{{ optional($inquiry->inquiry_date)->format('d-m-Y') }}</div>
    </div>
    <div>
      <label class="hrp-label">Industry Type</label>
      <div class="Rectangle-29">{{ $inquiry->industry_type }}</div>
    </div>

    <div>
      <label class="hrp-label">Company Name</label>
      <div class="Rectangle-29">{{ $inquiry->company_name }}</div>
    </div>
    <div>
      <label class="hrp-label">Company Mobile</label>
      <div class="Rectangle-29">{{ display_mobile($inquiry->company_phone) }}</div>
    </div>

    <div class="md:col-span-2">
      <label class="hrp-label">Company Address</label>
      <div class="Rectangle-29 Rectangle-29-textarea">{{ $inquiry->company_address }}</div>
    </div>

    <div>
      <label class="hrp-label">City</label>
      <div class="Rectangle-29">{{ $inquiry->city }}</div>
    </div>
    <div>
      <label class="hrp-label">State</label>
      <div class="Rectangle-29">{{ $inquiry->state }}</div>
    </div>

    <div>
      <label class="hrp-label">Contact Person Name</label>
      <div class="Rectangle-29">{{ $inquiry->contact_name }}</div>
    </div>
    <div>
      <label class="hrp-label">Contact Person Mobile</label>
      <div class="Rectangle-29">{{ display_mobile($inquiry->contact_mobile) }}</div>
    </div>

    <div>
      <label class="hrp-label">Contact Person Position</label>
      <div class="Rectangle-29">{{ $inquiry->contact_position }}</div>
    </div>
    <div>
      <label class="hrp-label">Email</label>
      <div class="Rectangle-29">{{ $inquiry->email }}</div>
    </div>

    <div class="md:col-span-2">
      <label class="hrp-label">Scope Link</label>
      <div class="Rectangle-29">
        @if($inquiry->scope_link)
          <a href="{{ $inquiry->scope_link }}" target="_blank" class="scope-link">{{ $inquiry->scope_link }}</a>
        @else
          —
        @endif
      </div>
    </div>

    <div>
      <label class="hrp-label">Quotation Sent</label>
      <div class="Rectangle-29">{{ $inquiry->quotation_sent ?: '—' }}</div>
    </div>
    <div>
      <label class="hrp-label">Quotation File</label>
      <div class="Rectangle-29">
        @if($inquiry->quotation_file)
          <a href="{{ url('public/storage/'.$inquiry->quotation_file) }}" target="_blank" class="scope-link">View File</a>
        @else
          —
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('inquiries.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Inquiries</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Inquiry Details</span>
@endsection
