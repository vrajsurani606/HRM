@extends('layouts.macos')
@section('page_title', 'Profile')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/empty-state.css') }}">
<style>
  .border-red-500 {
    border-color: #ef4444 !important;
  }
</style>
@endpush

@section('content')
  <!-- Tabs Section -->
  <div>
    <!-- Employee Profile Header -->
    <div style="padding:24px 40px;background:white">
      <div style="display:flex;align-items:center;gap:20px;justify-content:space-between;flex-wrap:wrap;width:100%">
        <!-- Employee ID -->
        <div style="flex-shrink:0">
          <div style="font-size:12px;color:#64748b;font-weight:500;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;margin-bottom:2px">Employee ID</div>
          <div style="font-size:16px;color:#1e293b;font-weight:700;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">{{ $employee?->code ?? ('USR-' . $user->id) }}</div>
        </div>
        
        <!-- Divider -->
        <div style="width:1px;height:36px;background:#e5e7eb"></div>
        
        <!-- Profile Info -->
        <div style="display:flex;align-items:center;gap:8px">
          <x-profile-avatar :user="$user" :employee="$employee" size="lg" />
          <div>
            <h2 style="font-size:24px;font-weight:700;color:#1e293b;margin:0 0 1px 0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">{{ $employee->name ?? $user->name }}</h2>
            <p style="color:#64748b;margin:0;font-size:13px;font-weight:500;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">{{ $employee->position ?? '—' }}</p>
          </div>
        </div>
        
        <!-- Divider -->
        <div style="width:1px;height:36px;background:#e5e7eb"></div>
        
        <!-- Status Badge -->
        @php
          $status = strtolower($employee->status ?? 'active');
          $badgeBg = $status === 'active' ? '#158f00' : '#6b7280';
        @endphp
        <div style="display:flex;align-items:center;gap:16px;background:{{ $badgeBg }};color:#ffffff;font-weight:700;font-size:14px;padding:6px 14px;border-radius:9999px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;flex-shrink:0">
          <div style="width:8px;height:8px;background:#ffffff;border-radius:50%"></div>
          {{ ucfirst($status) }}
        </div>
        
        <!-- Divider -->
        <div style="width:1px;height:36px;background:#e5e7eb"></div>
        
        <!-- Contact Info -->
        <div style="display:flex;flex-direction:column;gap:8px;flex-shrink:0">
          <div style="display:flex;align-items:center;gap:6px;color:#000000;font-size:14px;font-weight:600;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
              <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
            </svg>
            {{ display_mobile($employee->mobile_no ?? $user->mobile_no) ?? '—' }}
          </div>
          <div style="display:flex;align-items:center;gap:6px;color:#000000;font-size:14px;font-weight:600;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
              <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
            </svg>
            {{ $user->email }}
          </div>
        </div>
        
        <!-- Divider -->
        <div style="width:1px;height:36px;background:#e5e7eb"></div>
        
        <!-- Company Join Date -->
        <div style="flex-shrink:0">
          <div style="font-size:14px;color:#000000;font-weight:600;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;margin-bottom:2px">Company Join Date:</div>
          <div style="font-size:16px;color:#000000;font-weight:700;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
            {{ isset($employee->joining_date) ? $employee->joining_date->format('d / m / Y') : '—' }}
          </div>
        </div>
        
        @if($employee)
        <!-- Divider -->
        <div style="width:1px;height:36px;background:#e5e7eb"></div>
        
        <!-- ID Card Quick Actions -->
        <div style="display:flex;flex-direction:column;gap:8px;flex-shrink:0">
          <a href="{{ route('id-cards.active', $employee) }}" target="_blank" 
             style="display:flex;align-items:center;gap:8px;background:linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);color:white;padding:8px 16px;border-radius:8px;text-decoration:none;font-size:13px;font-weight:600;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;transition:all 0.2s ease;box-shadow:0 2px 4px rgba(59, 130, 246, 0.3)">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
              <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zM4 6h16v2H4V6zm0 12v-6h16v6H4z"/>
            </svg>
            View ID Card
          </a>
          <a href="{{ route('id-cards.select-style', $employee) }}" 
             style="display:flex;align-items:center;gap:8px;background:linear-gradient(135deg, #10b981 0%, #059669 100%);color:white;padding:8px 16px;border-radius:8px;text-decoration:none;font-size:13px;font-weight:600;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;transition:all 0.2s ease;box-shadow:0 2px 4px rgba(16, 185, 129, 0.3)">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            Choose Style
          </a>
        </div>
        @endif
      </div>
    </div>
    
    <!-- Tab Navigation -->
    @php
      $canViewPayroll = auth()->user()->can('Profile Management.view own payroll') || auth()->user()->can('Payroll Management.view payroll');
      $canViewAttendance = auth()->user()->can('Profile Management.view own attendance');
      $canViewDocuments = auth()->user()->can('Profile Management.view own documents');
      $canViewBank = auth()->user()->can('Profile Management.view own bank details') || auth()->user()->can('Profile Management.update bank details');
    @endphp
    <div class="tabbar" style="display:flex;border-bottom:1px solid #e5e7eb;padding:0 32px;background:white;align-items:center;margin-bottom:0">
      <button class="tab-btn active" onclick="switchTab('personal')"
        style="display:flex;align-items:center;gap:10px;padding:16px 20px;border:none;background:none;color:#0ea5e9;border-bottom:2px solid #0ea5e9;font-weight:700;cursor:pointer">
        <span class="tab-ico"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg></span>
        Personal Information
      </button>
      @if($canViewPayroll)
      <div class="tab-sep"></div>
      <button class="tab-btn" onclick="switchTab('payroll')"
        style="display:flex;align-items:center;gap:10px;padding:16px 20px;border:none;background:none;color:#718096;border-bottom:2px solid transparent;font-weight:700;cursor:pointer">
        <span class="tab-ico"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg></span>
        Payroll
      </button>
      @endif
      @if($canViewAttendance)
      <div class="tab-sep"></div>
      <button class="tab-btn" onclick="switchTab('attendance')"
        style="display:flex;align-items:center;gap:10px;padding:16px 20px;border:none;background:none;color:#718096;border-bottom:2px solid transparent;font-weight:700;cursor:pointer">
        <span class="tab-ico"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg></span>
        Attendance Management
      </button>
      @endif
      @if($canViewDocuments)
      <div class="tab-sep"></div>
      <button class="tab-btn" onclick="switchTab('documents')"
        style="display:flex;align-items:center;gap:10px;padding:16px 20px;border:none;background:none;color:#718096;border-bottom:2px solid transparent;font-weight:700;cursor:pointer">
        <span class="tab-ico"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/></svg></span>
        Documents
      </button>
      @endif
      @if($canViewBank)
      <div class="tab-sep"></div>
      <button class="tab-btn" onclick="switchTab('bank')"
        style="display:flex;align-items:center;gap:10px;padding:16px 20px;border:none;background:none;color:#718096;border-bottom:2px solid transparent;font-weight:700;cursor:pointer">
        <span class="tab-ico"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M11.5,1L2,6V8H21V6M16,10V17H19V19H5V17H8V10H10V17H14V10"/></svg></span>
        Bank Details
      </button>
      @endif
    </div>

    <!-- Tab Content -->
    <div id="personal" class="tab-content active" style="background:white;border-radius:20px;box-shadow:0 2px 8px rgba(0,0,0,0.08);border:1px solid #e5e7eb;padding:30px;margin:12px 32px 24px">
      <div style="display:flex;gap:30px">
        <!-- Left Column - Profile Image -->
        <div style="flex:0 0 200px;text-align:center">
          <x-profile-avatar :user="$user" :employee="$employee" size="3xl" class="profile-main-avatar" />
        </div>

        <!-- Right Column - Form -->
        <div style="flex:1">
          <div class="hrp-compact">
            @php
              $canEdit = auth()->user()->can('Profile Management.edit own profile') || auth()->user()->can('Profile Management.edit profile');
            @endphp
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px 24px;align-items:start">
              @csrf
              @method('PATCH')
              
              <!-- Profile Photo Upload -->
              @if($canEdit)
              <div style="grid-column:1/-1">
                <label class="hrp-label">Profile Photo</label>
                <input type="file" name="photo" accept="image/*" class="hrp-input Rectangle-29 @error('photo') border-red-500 @enderror" onchange="previewPhoto(this)">
                <small style="color:#6b7280;font-size:12px">Upload a new profile photo (JPG, PNG, max 2MB)</small>
                @error('photo')<small style="color:#ef4444;font-size:12px;display:block;margin-top:4px">{{ $message }}</small>@enderror
              </div>
              @endif
              
              <!-- Full Name -->
              <div>
                <label class="hrp-label">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $employee->name ?? $user->name) }}" class="hrp-input Rectangle-29 @error('name') border-red-500 @enderror" {{ $canEdit ? 'required' : 'readonly' }}>
                @error('name')<small style="color:#ef4444;font-size:12px;display:block;margin-top:4px">{{ $message }}</small>@enderror
              </div>

              <!-- Gender -->
              <div>
                <label class="hrp-label">Gender :</label>
                <div style="margin-top:8px; display:flex; align-items:center; justify-content:center;">
                  <div class="gender-toggle Rectangle-29">
                    <label class="gender-option">
                      <input class="gender-radio" type="radio" name="gender" value="male" {{ old('gender', $employee->gender ?? 'male') === 'male' ? 'checked' : '' }} {{ $canEdit ? '' : 'disabled' }}>
                      <span class="gender-text">Male</span>
                      <span class="gender-dot"></span>
                    </label>
                    <label class="gender-option">
                      <input class="gender-radio" type="radio" name="gender" value="female" {{ old('gender', $employee->gender ?? null) === 'female' ? 'checked' : '' }} {{ $canEdit ? '' : 'disabled' }}>
                      <span class="gender-text">Female</span>
                      <span class="gender-dot"></span>
                    </label>
                  </div>
                </div>
                @error('gender')<small style="color:#ef4444;font-size:12px;display:block;margin-top:4px">{{ $message }}</small>@enderror
              </div>

              <!-- Date of Birth -->
              <div>
                <x-date-input 
                  name="date_of_birth" 
                  label="Date of Birth" 
                  :value="old('date_of_birth', $employee->date_of_birth ?? null)" 
                />
                @error('date_of_birth')<small style="color:#ef4444;font-size:12px;display:block;margin-top:4px">{{ $message }}</small>@enderror
              </div>

              <!-- Mobile No -->
              <div>
                <label class="hrp-label">Mobile No:</label>
                <input type="text" name="mobile_no" value="{{ old('mobile_no', strip_country_code($employee->mobile_no ?? $user->mobile_no)) }}" class="hrp-input Rectangle-29 @error('mobile_no') border-red-500 @enderror" {{ $canEdit ? '' : 'readonly' }}>
                @error('mobile_no')<small style="color:#ef4444;font-size:12px;display:block;margin-top:4px">{{ $message }}</small>@enderror
              </div>

              <!-- Marital Status -->
              <div>
                <label class="hrp-label">Marital Status :</label>
                <select name="marital_status" class="Rectangle-29 Rectangle-29-select @error('marital_status') border-red-500 @enderror" {{ $canEdit ? '' : 'disabled' }}>
                  <option value="">Select Status</option>
                  <option value="single" {{ old('marital_status', $employee->marital_status ?? null) === 'single' ? 'selected' : '' }}>Single</option>
                  <option value="married" {{ old('marital_status', $employee->marital_status ?? null) === 'married' ? 'selected' : '' }}>Married</option>
                  <option value="divorced" {{ old('marital_status', $employee->marital_status ?? null) === 'divorced' ? 'selected' : '' }}>Divorced</option>
                  <option value="widowed" {{ old('marital_status', $employee->marital_status ?? null) === 'widowed' ? 'selected' : '' }}>Widowed</option>
                </select>
                @error('marital_status')<small style="color:#ef4444;font-size:12px;display:block;margin-top:4px">{{ $message }}</small>@enderror
              </div>

              <!-- Email ID -->
              <div>
                <label class="hrp-label">Email ID :</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="hrp-input Rectangle-29 @error('email') border-red-500 @enderror" {{ $canEdit ? 'required' : 'readonly' }}>
                @error('email')<small style="color:#ef4444;font-size:12px;display:block;margin-top:4px">{{ $message }}</small>@enderror
              </div>

              <!-- Address -->
              <div style="grid-column:1/-1">
                <label class="hrp-label">Address:</label>
                <textarea name="address" placeholder="Enter Your Address" class="Rectangle-29-textarea @error('address') border-red-500 @enderror" {{ $canEdit ? '' : 'readonly' }}>{{ old('address', $employee->address ?? $user->address) }}</textarea>
                @error('address')<small style="color:#ef4444;font-size:12px;display:block;margin-top:4px">{{ $message }}</small>@enderror
              </div>

              <!-- Aadhaar Card Number -->
              <div>
                <label class="hrp-label">Aadhaar Card Number :</label>
                <input type="text" name="aadhaar_no" value="{{ old('aadhaar_no', $employee->aadhaar_no ?? null) }}" placeholder="XXXX XXXX XXXX" class="hrp-input Rectangle-29 @error('aadhaar_no') border-red-500 @enderror" maxlength="12" {{ $canEdit ? '' : 'readonly' }}>
                @error('aadhaar_no')<small style="color:#ef4444;font-size:12px;display:block;margin-top:4px">{{ $message }}</small>@enderror
              </div>

              <!-- PAN Number -->
              <div>
                <label class="hrp-label">PAN Number :</label>
                <input type="text" name="pan_no" value="{{ old('pan_no', $employee->pan_no ?? null) }}" placeholder="XXXXX0000X" class="hrp-input Rectangle-29 @error('pan_no') border-red-500 @enderror" style="text-transform: uppercase;" maxlength="10" {{ $canEdit ? '' : 'readonly' }}>
                @error('pan_no')<small style="color:#ef4444;font-size:12px;display:block;margin-top:4px">{{ $message }}</small>@enderror
              </div>

              <!-- Highest Qualification (long) + Previous Designation stacked left, Year of Passing short right -->
              <div style="grid-column:1/-1">
                <div style="display:grid;grid-template-columns:2fr 1fr;gap:20px 24px;align-items:start">
                  <div>
                    <label class="hrp-label">Highest Qualification</label>
                    <input type="text" name="highest_qualification" value="{{ old('highest_qualification', $employee->highest_qualification ?? null) }}" placeholder="Enter your Highest Qualification" class="hrp-input Rectangle-29 @error('highest_qualification') border-red-500 @enderror" style="margin-bottom:14px" {{ $canEdit ? '' : 'readonly' }}>
                    @error('highest_qualification')<small style="color:#ef4444;font-size:12px;display:block;margin-top:4px">{{ $message }}</small>@enderror
                    <label class="hrp-label">Previous Designation</label>
                    <input type="text" name="previous_designation" value="{{ old('previous_designation', $employee->previous_designation ?? null) }}" placeholder="Enter your Last Designation" class="hrp-input Rectangle-29 @error('previous_designation') border-red-500 @enderror" {{ $canEdit ? '' : 'readonly' }}>
                    @error('previous_designation')<small style="color:#ef4444;font-size:12px;display:block;margin-top:4px">{{ $message }}</small>@enderror
                  </div>
                  <div>
                    <label class="hrp-label">Year of Passing</label>
                    <input type="text" name="year_of_passing" value="{{ old('year_of_passing', $employee->year_of_passing ?? null) }}" placeholder="Passing Year" class="hrp-input Rectangle-29 @error('year_of_passing') border-red-500 @enderror" maxlength="4" {{ $canEdit ? '' : 'readonly' }}>
                    @error('year_of_passing')<small style="color:#ef4444;font-size:12px;display:block;margin-top:4px">{{ $message }}</small>@enderror
                  </div>
                </div>
              </div>

              <!-- Previous Company Name -->
              <div>
                <label class="hrp-label">Previous Company Name :</label>
                <input type="text" name="previous_company_name" value="{{ old('previous_company_name', $employee->previous_company_name ?? null) }}" placeholder="Enter your Last Company Name" class="hrp-input Rectangle-29 @error('previous_company_name') border-red-500 @enderror" {{ $canEdit ? '' : 'readonly' }}>
                @error('previous_company_name')<small style="color:#ef4444;font-size:12px;display:block;margin-top:4px">{{ $message }}</small>@enderror
              </div>

              <!-- Duration + Reason for Leaving on same row -->
              <div style="grid-column:1/-1; display:grid; grid-template-columns:1fr 2fr; gap:20px 24px; align-items:start">
                <div>
                  <label class="hrp-label">Duration :</label>
                  <input type="text" name="duration" value="{{ old('duration', $employee->duration ?? null) }}" placeholder="Add Time Duration" class="hrp-input Rectangle-29 @error('duration') border-red-500 @enderror" {{ $canEdit ? '' : 'readonly' }}>
                  @error('duration')<small style="color:#ef4444;font-size:12px;display:block;margin-top:4px">{{ $message }}</small>@enderror
                </div>
                <div>
                  <label class="hrp-label">Reason for Leaving</label>
                  <textarea name="reason_for_leaving" placeholder="Enter Reason for Leaving" class="Rectangle-29-textarea @error('reason_for_leaving') border-red-500 @enderror" {{ $canEdit ? '' : 'readonly' }}>{{ old('reason_for_leaving', $employee->reason_for_leaving ?? null) }}</textarea>
                  @error('reason_for_leaving')<small style="color:#ef4444;font-size:12px;display:block;margin-top:4px">{{ $message }}</small>@enderror
                </div>
              </div>

              <!-- Save Button -->
              @if($canEdit)
              <div style="grid-column:1/-1;margin-top:20px">
                <button type="submit"
                  style="background:#10b981;color:white;padding:12px 24px;border:none;border-radius:8px;font-weight:600;cursor:pointer">
                    SAVE CHANGES
                </button>
              </div>
              @endif
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Payroll Tab Content -->
    @if($canViewPayroll)
    <div id="payroll" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
      <div class="JV-datatble JV-datatble--zoom striped-surface striped-surface--full table-wrap pad-none">
        <table>
          <thead>
            <tr>
              <th>Action</th>
              <th>Serial No</th>
              <th>Payslip ID</th>
              <th>Salary Month</th>
              <th>Payment Date</th>
              <th>Gross Amount</th>
              <th>Net Amount</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($payslips ?? [] as $index => $payslip)
              @php
                $grossAmount = ($payslip->basic_salary ?? 0) + ($payslip->allowances ?? 0) + ($payslip->bonuses ?? 0);
                $empCode = $employee->code ?? 'EMP';
                $empId = $employee->id ?? 0;
                $payslipId = 'PAY/' . strtoupper(substr($empCode, 0, 3)) . '/' . str_pad($empId, 4, '0', STR_PAD_LEFT) . '/' . str_pad($payslip->id, 3, '0', STR_PAD_LEFT);
                $statusColors = ['pending' => '#f59e0b', 'paid' => '#10b981', 'cancelled' => '#ef4444'];
                $statusColor = $statusColors[$payslip->status] ?? '#6b7280';
              @endphp
              <tr>
                <td>
                  <a href="{{ route('payroll.show', $payslip->id) }}" target="_blank" title="View Payslip">
                    <img src="{{ asset('action_icon/print.svg') }}" alt="Print" class="action-icon" />
                  </a>
                </td>
                <td>{{ $index + 1 }}</td>
                <td>{{ $payslipId }}</td>
                <td>{{ $payslip->month }} - {{ $payslip->year }}</td>
                <td>{{ $payslip->payment_date ? $payslip->payment_date->format('d-m-Y') : 'N/A' }}</td>
                <td>₹{{ number_format($grossAmount, 0) }}</td>
                <td>₹{{ number_format($payslip->net_salary ?? 0, 0) }}</td>
                <td>
                  <span style="color: {{ $statusColor }}; font-weight: 600; font-size: 12px; padding: 4px 8px; border-radius: 12px; background: {{ $statusColor }}20;">
                    {{ ucfirst($payslip->status) }}
                  </span>
                </td>
              </tr>
          </tbody>
           @empty
              <tr>
                <td colspan="8" class="empty-state-wrapper">
                  <div class="empty-state-container">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="empty-state-icon">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="empty-state-title">No Payroll Records</div>
                    <div class="empty-state-message">Your salary payments will appear here once processed and paid by HR.</div>
                  </div>
                </td>
              </tr>
            @endforelse
        </table>
      </div>
    </div>
    @endif

    <!-- Attendance Tab Content -->
    @if($canViewAttendance)
    @php
      $isEmployee = auth()->user()->hasRole('employee');
    @endphp
    <div id="attendance" class="tab-content" style="display:none;background:#f7f4f1;border-radius:0;box-shadow:none;border:0;padding:20px;margin:0">
      <!-- KPI Cards Row - Same as Employee Dashboard -->
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:20px">
        <!-- Present Day Card -->
        <div style="background:linear-gradient(135deg,#dbeafe 0%,#93c5fd 100%);border-radius:20px;padding:16px 24px 16px 16px">
          <div style="display:flex;align-items:center;gap:16px">
            <div style="width:64px;height:64px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(0,0,0,0.1)">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="#005593"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>
            </div>
            <div>
              <div style="font-size:36px;font-weight:700;color:#005593;line-height:1;margin-bottom:4px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">O{{ $attSummary['present'] ?? 0 }}</div>
              <div style="font-size:14px;font-weight:600;color:#005593">Present Day</div>
            </div>
          </div>
        </div>

        <!-- Working Hours Card -->
        <div style="background:linear-gradient(135deg,#dcfce7 0%,#86efac 100%);border-radius:20px;padding:16px 24px 16px 16px">
          <div style="display:flex;align-items:center;gap:16px">
            <div style="width:64px;height:64px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(0,0,0,0.1)">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="#216D00"><path d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z"/></svg>
            </div>
            <div>
              <div style="font-size:36px;font-weight:700;color:#216D00;line-height:1;margin-bottom:4px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">{{ $attSummary['hours'] ?? '0' }}</div>
              <div style="font-size:14px;font-weight:600;color:#216D00">Working Hours</div>
            </div>
          </div>
        </div>

        <!-- Late Entries Card -->
        <div style="background:linear-gradient(135deg,#ffedd5 0%,#fdba74 100%);border-radius:20px;padding:16px 24px 16px 16px">
          <div style="display:flex;align-items:center;gap:16px">
            <div style="width:64px;height:64px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(0,0,0,0.1)">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="#DE5A00"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
            </div>
            <div>
              <div style="font-size:36px;font-weight:700;color:#DE5A00;line-height:1;margin-bottom:4px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">O{{ $attSummary['late'] ?? 0 }}</div>
              <div style="font-size:14px;font-weight:600;color:#DE5A00">Late Entries</div>
            </div>
          </div>
        </div>

        <!-- Early Exits Card -->
        <div style="background:linear-gradient(135deg,#fee2e2 0%,#fca5a5 100%);border-radius:20px;padding:16px 24px 16px 16px">
          <div style="display:flex;align-items:center;gap:16px">
            <div style="width:64px;height:64px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(0,0,0,0.1)">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="#DA0000"><path d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5c-1.11 0-2 .9-2 2v4h2V5h14v14H5v-4H3v4c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/></svg>
            </div>
            <div>
              <div style="font-size:36px;font-weight:700;color:#DA0000;line-height:1;margin-bottom:4px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">O{{ $attSummary['early_exit'] ?? 0 }}</div>
              <div style="font-size:14px;font-weight:600;color:#DA0000">Early Exits</div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Date Filter Row - Same as Attendance Reports -->
      <form method="GET" action="{{ route('profile.edit') }}" class="jv-filter" id="attendanceFilterForm" data-no-loader="true">
        <input type="hidden" name="tab" value="attendance">
        <input type="text" name="start_date" class="filter-pill date-picker" placeholder="From : dd/mm/yy" value="{{ request('start_date') }}" autocomplete="off" style="min-width: 130px;">
        <input type="text" name="end_date" class="filter-pill date-picker" placeholder="To : dd/mm/yy" value="{{ request('end_date') }}" autocomplete="off" style="min-width: 130px;">
        
        @if($isAdmin ?? false)
        <select name="employee_id" class="filter-pill" style="min-width: 200px;">
          <option value="">All Employees</option>
          @foreach($employees ?? [] as $emp)
            <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
              {{ $emp->name }}
            </option>
          @endforeach
        </select>
        @endif

        <button type="submit" class="filter-search" aria-label="Search">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
          </svg>
        </button>
        
        <a href="{{ route('profile.edit') }}?tab=attendance" class="filter-search" aria-label="Reset">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
          </svg>
        </a>
      </form>
      
      <!-- Attendance Table - JV Datatable Style -->
      <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none" style="background:white;border-radius:16px;overflow:hidden;box-shadow:0 2px 6px rgba(0,0,0,0.08)">
        <table>
          <thead>
            <tr>
              <th>Day</th>
              <th>Date</th>
              @if(!$isEmployee)
              <th>EMP Code</th>
              <th>EMPLOYEE</th>
              @endif
              <th>Check IN & OUT ⇅</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($attendances as $row)
              @php
                $date = \Carbon\Carbon::parse($row->date);
                $checkIn = $row->check_in ? \Carbon\Carbon::parse($row->check_in) : null;
                $checkOut = $row->check_out ? \Carbon\Carbon::parse($row->check_out) : null;
                
                // Calculate working hours
                $workedMinutes = 0;
                if ($checkIn && $checkOut) {
                    $workedMinutes = $checkIn->diffInMinutes($checkOut);
                }
                $workedHours = floor($workedMinutes / 60);
                $workedMins = $workedMinutes % 60;
                
                // Calculate overtime (over 9 hours = 540 minutes)
                $overtimeMinutes = max(0, $workedMinutes - 540);
                $overtimeHours = floor($overtimeMinutes / 60);
                $overtimeMins = $overtimeMinutes % 60;
                
                // Status colors - matching reference exactly
                $status = $row->status ?? 'present';
                $statusTextColors = [
                    'present' => '#16a34a',
                    'absent' => '#dc2626',
                    'half_day' => '#f59e0b',
                    'late' => '#ea580c',
                    'leave' => '#4f46e5',
                    'paid_leave' => '#db2777',
                ];
                $statusColor = $statusTextColors[$status] ?? '#374151';
              @endphp
              @php
                // Get employee data from the attendance row (for admin view) or from the logged-in user's employee
                $rowEmployee = $row->employee ?? $employee;
              @endphp
              <tr style="border-left:3px solid #16a34a">
                <td style="font-weight:600">{{ $date->format('l') }}</td>
                <td>{{ $date->format('d M, Y') }}</td>
                @if(!$isEmployee)
                <td>{{ $rowEmployee->code ?? 'EMP/' . str_pad($rowEmployee->id ?? 0, 4, '0', STR_PAD_LEFT) }}</td>
                <td style="font-weight:500">{{ $rowEmployee->name ?? 'N/A' }}</td>
                @endif
                <td style="text-align:center">
                  @if($status === 'paid_leave' || $status === 'leave')
                    <div style="display:flex;align-items:center;justify-content:center;gap:0">
                      <span style="color:#dc2626;font-size:6px">●</span>
                      <span style="display:inline-block;width:60px;height:1px;background:#dc2626;margin:0 4px"></span>
                      <span style="color:#db2777;font-weight:500;font-size:12px">Paid Leave</span>
                      <span style="display:inline-block;width:60px;height:1px;background:#dc2626;margin:0 4px"></span>
                      <span style="color:#dc2626;font-size:6px">●</span>
                    </div>
                  @elseif($checkIn || $checkOut)
                    <div style="display:flex;align-items:center;justify-content:center;gap:0">
                      <span style="color:#16a34a;font-weight:600;font-size:13px">{{ $checkIn ? $checkIn->format('h:i A') : '--' }}</span>
                      <span style="display:inline-block;width:30px;height:1px;background:#d1d5db;margin:0 6px"></span>
                      <span style="color:#9ca3af;font-size:11px">{{ $workedHours }}h {{ str_pad($workedMins, 2, '0', STR_PAD_LEFT) }}m</span>
                      <span style="display:inline-block;width:30px;height:1px;background:#d1d5db;margin:0 6px"></span>
                      <span style="color:#16a34a;font-size:12px">→</span>
                      <span style="color:#dc2626;font-weight:600;font-size:13px;margin-left:6px">{{ $checkOut ? $checkOut->format('h:i A') : '--' }}</span>
                    </div>
                  @else
                    <span style="color:#9ca3af">--</span>
                  @endif
                </td>
                <td style="text-align:center">
                  <span style="color:{{ $statusColor }};font-weight:600;font-size:13px;text-transform:capitalize">
                    {{ str_replace('_', ' ', ucfirst($status)) }}
                  </span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="{{ $isEmployee ? 4 : 6 }}" style="text-align:center;padding:60px;color:#9ca3af">
                  <svg width="48" height="48" fill="currentColor" viewBox="0 0 24 24" style="margin-bottom:12px;opacity:0.5">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                  </svg>
                  <p style="font-weight:600;margin:0">No attendance records found</p>
                  <p style="font-size:14px;margin:8px 0 0 0">No records for the selected period</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    @endif

    @if($canViewDocuments)
    <div id="documents" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
      <div style="padding: 24px 32px 16px 32px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb;">
        <div>
          <h3 style="font-size: 18px; font-weight: 800; color: #111; margin: 0 0 4px 0;">My Documents</h3>
          <p style="font-size: 14px; color: #6b7280; margin: 0;">Upload and manage your documents</p>
        </div>
        <button type="button" onclick="openUploadModal()" class="hrp-btn hrp-btn-primary" style="display: flex !important; align-items: center; gap: 8px; white-space: nowrap; cursor: pointer;">
          <i class="fa fa-plus"></i> Add Document
        </button>
      </div>
      
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:24px;padding:24px 32px">
        @php
          $hasAny = false;
        @endphp
        @foreach([
          ['key' => 'photo_path', 'label' => 'Profile Photo'],
          ['key' => 'aadhaar_photo_front', 'label' => 'Aadhaar Front'],
          ['key' => 'aadhaar_photo_back', 'label' => 'Aadhaar Back'],
          ['key' => 'pan_photo', 'label' => 'PAN Card'],
          ['key' => 'cheque_photo', 'label' => 'Cheque'],
          ['key' => 'marksheet_photo', 'label' => 'Marksheet'],
        ] as $doc)
          @php
            $path = $employee && isset($employee->{$doc['key']}) ? $employee->{$doc['key']} : null;
            $exists = $path && Storage::disk('public')->exists($path);
          @endphp
          @if($exists)
            @php
              $hasAny = true;
              $url = storage_asset($path);
              $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
              $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp','bmp']);
              $size = Storage::disk('public')->size($path);
              $human = $size >= 1048576 ? round($size/1048576,2).' MB' : ($size >= 1024 ? round($size/1024,2).' KB' : $size.' B');
            @endphp
            <div style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;background:white;box-shadow:0 1px 3px rgba(0,0,0,0.1)">
              <div style="height:180px;background:#f8fafc;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:center">
                @if($isImage)
                  <img src="{{ $url }}" alt="{{ $doc['label'] }}" style="max-width:100%;max-height:100%;object-fit:contain" />
                @else
                  <svg width="48" height="48" viewBox="0 0 24 24" fill="#94a3b8"><path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/></svg>
                @endif
              </div>
              <div style="padding:14px">
                <div style="font-weight:800;color:#0f172a;margin-bottom:6px">{{ $doc['label'] }}</div>
                <div style="font-size:12px;color:#64748b;margin-bottom:10px">{{ strtoupper($ext ?: 'FILE') }} • {{ $human }}</div>
                <div style="display:flex;gap:10px">
                  <a href="{{ $url }}" download style="flex:1;text-align:center;background:#0ea5e9;color:white;border:none;border-radius:8px;padding:8px 12px;font-weight:700;text-decoration:none">Download</a>
                  <button type="button" onclick="window.open('{{ $url }}','_blank')" style="width:36px;height:36px;background:#6b7280;border:none;border-radius:6px;cursor:pointer;display:flex;align-items:center;justify-content:center">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="white"><path d="M12 5C5 5 1 12 1 12s4 7 11 7 11-7 11-7-4-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"></path></svg>
                  </button>
                </div>
              </div>
            </div>
          @endif
        @endforeach
        
        {{-- Custom Uploaded Documents --}}
        @if($employee && $employee->documents)
          @foreach($employee->documents as $customDoc)
            @php
              $hasAny = true;
              $url = storage_asset($customDoc->file_path);
              $ext = strtolower($customDoc->file_type ?? 'file');
              $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp','bmp']);
            @endphp
            <div style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;background:white;box-shadow:0 1px 3px rgba(0,0,0,0.1);position:relative">
              <div style="height:180px;background:#f8fafc;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:center;position:relative">
                @if($isImage)
                  <img src="{{ $url }}" alt="{{ $customDoc->document_name }}" style="max-width:100%;max-height:100%;object-fit:contain" />
                @else
                  <svg width="48" height="48" viewBox="0 0 24 24" fill="#94a3b8"><path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/></svg>
                @endif
                @if($customDoc->document_type)
                  <span style="position:absolute;top:8px;right:8px;background:#0ea5e9;color:white;padding:4px 8px;border-radius:4px;font-size:10px;font-weight:700">{{ $customDoc->document_type }}</span>
                @endif
              </div>
              <div style="padding:14px">
                <div style="font-weight:800;color:#0f172a;margin-bottom:4px">{{ $customDoc->document_name }}</div>
                @if($customDoc->description)
                  <div style="font-size:11px;color:#64748b;margin-bottom:6px;line-height:1.4">{{ Str::limit($customDoc->description, 60) }}</div>
                @endif
                <div style="font-size:12px;color:#64748b;margin-bottom:10px">{{ strtoupper($ext) }} • {{ $customDoc->file_size_human }}</div>
                <div style="display:flex;gap:8px;align-items:center">
                  <a href="{{ $url }}" download style="flex:1;text-align:center;background:#0ea5e9 !important;color:white !important;border:none;border-radius:8px;padding:8px 12px;font-weight:700;text-decoration:none;font-size:13px;display:inline-block">Download</a>
                  <button type="button" onclick="window.open('{{ $url }}','_blank')" style="width:36px !important;height:36px !important;min-width:36px;background:#6b7280 !important;border:none !important;border-radius:6px;cursor:pointer;display:flex !important;align-items:center;justify-content:center;padding:0 !important;flex-shrink:0">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="white"><path d="M12 5C5 5 1 12 1 12s4 7 11 7 11-7 11-7-4-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"></path></svg>
                  </button>
                  <form method="POST" action="{{ route('profile.documents.delete', $customDoc->id) }}" style="margin:0 !important;padding:0 !important;display:inline-block" onsubmit="return confirm('Are you sure you want to delete this document?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="doc-delete-btn" style="width:36px !important;height:36px !important;min-width:36px;background:#ef4444 !important;border:none !important;border-radius:6px !important;cursor:pointer !important;display:flex !important;align-items:center !important;justify-content:center !important;padding:0 !important;flex-shrink:0 !important;transition:all 0.2s !important;box-shadow:0 1px 3px rgba(0,0,0,0.1) !important" onmouseover="this.style.setProperty('background', '#dc2626', 'important');this.style.setProperty('transform', 'scale(1.05)', 'important')" onmouseout="this.style.setProperty('background', '#ef4444', 'important');this.style.setProperty('transform', 'scale(1)', 'important')">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="white" style="pointer-events:none"><path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"/></svg>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
        @endif
        
        @if(!$hasAny)
          <div style="grid-column:1/-1;text-align:center;color:#6b7280;padding:40px">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="#d1d5db" style="margin:0 auto 16px"><path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/></svg>
            <p style="font-size:16px;font-weight:600;color:#6b7280;margin:0 0 8px 0">No documents uploaded yet</p>
            <p style="font-size:14px;color:#9ca3af;margin:0">Click "Add Document" to upload your first document</p>
          </div>
        @endif
      </div>
    </div>
    @endif

    @if($canViewBank)
    <div id="bank" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:10px;margin:0">
      <div style="margin:0 32px 24px">
        @include('profile.partials.bank-details')
      </div>
    </div>
    @endif
  </div>

  @section('footer_pagination')
  @if(isset($payrolls) && method_exists($payrolls,'links'))
      <form method="GET" class="hrp-entries-form" style="display:inline-flex;align-items:center;gap:6px;margin-right:10px">
        <span>Entries</span>
        <select name="per_page" onchange="this.form.submit()" style="border:1px solid #E5E5E5;border-radius:6px;padding:2px 8px;height:26px">
          @php
            $currentPerPage = (int) request()->get('per_page', 10);
          @endphp
          @foreach([10,25,50,100] as $size)
            <option value="{{ $size }}" {{ $currentPerPage === $size ? 'selected' : '' }}>{{ $size }}</option>
          @endforeach
        </select>
        @foreach(request()->except(['per_page','page']) as $key => $val)
          <input type="hidden" name="{{ $key }}" value="{{ $val }}" />
        @endforeach
      </form>
      {{ $payrolls->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.jv') }}
  @endif
@endsection

    <style>
      /* Import system fonts */
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

      /* Tab styling */
      .tab-btn:hover {
        color: #1e293b !important;
        border-bottom-color: #1e293b !important;
      }

      .tab-btn.active {
        color: #000000ff !important;
        border-bottom-color: #000000ff !important;
      }

      .tabbar .tab-ico{display:inline-flex;align-items:center;justify-content:center;width:26px;height:18px;border:1px solid #d1d5db;border-radius:6px;background:#ffffff;box-shadow:inset 0 1px 0 #ffffff}
      .tabbar .tab-ico svg{width:14px;height:14px;fill:currentColor}
      .tabbar .tab-sep{width:1px;height:24px;background:#e5e7eb}
      .tabbar .tab-btn.active .tab-ico{border-color:#000000ff;color:#000000ff}

      /* Table styles are defined globally in public/new_theme/css/datatable.css */

     

      .tab-content {
        display: none;
      }

      .tab-content.active {
        display: block;
      }

      /* Form input focus states - exclude filter-pill */
      input:focus:not(.filter-pill),
      select:focus:not(.filter-pill),
      textarea:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
      }
      
      /* Date picker filter styling - match attendance report */
      #attendanceFilterForm .filter-pill.date-picker {
        border: 1px solid #e8e8e8 !important;
        background: #F5F5F5 !important;
        color: #0f0f0f !important;
        outline: none !important;
        box-shadow: inset 0 2px 3px rgba(0,0,0,.12), 0 1px 0 #fff !important;
      }
      #attendanceFilterForm .filter-pill.date-picker:focus {
        border-color: #000000 !important;
        box-shadow: none !important;
        background: #F5F5F5 !important;
      }
      #attendanceFilterForm .filter-pill.date-picker::placeholder {
        color: #99a3ad !important;
      }
      /* Search button - green (same as attendance report) */
      #attendanceFilterForm button.filter-search {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 35px !important;
        height: 35px !important;
        min-width: 35px !important;
        min-height: 35px !important;
        border-radius: 50% !important;
        background: #00A65A !important;
        border: none !important;
        color: #ffffff !important;
        cursor: pointer !important;
        padding: 0 !important;
        margin: 0 !important;
        flex-shrink: 0 !important;
      }
      #attendanceFilterForm button.filter-search svg {
        width: 16px !important;
        height: 16px !important;
        fill: #ffffff !important;
        flex-shrink: 0 !important;
      }
      #attendanceFilterForm button.filter-search:hover {
        background: #008F4E !important;
      }
      /* Reset button - dark (same as attendance report) */
      #attendanceFilterForm a.filter-search {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 35px !important;
        height: 35px !important;
        min-width: 35px !important;
        min-height: 35px !important;
        border-radius: 50% !important;
        background: #111827 !important;
        border: none !important;
        color: #ffffff !important;
        cursor: pointer !important;
        text-decoration: none !important;
        padding: 0 !important;
        margin: 0 !important;
        flex-shrink: 0 !important;
      }
      #attendanceFilterForm a.filter-search svg {
        width: 16px !important;
        height: 16px !important;
        fill: #ffffff !important;
        flex-shrink: 0 !important;
      }
      #attendanceFilterForm a.filter-search:hover {
        background: #1f2937 !important;
      }

      /* Placeholder styling */
      input::placeholder,
      textarea::placeholder {
        color: #9ca3af !important;
        font-weight: 400;
      }

      /* Radio button styling */
      input[type="radio"] {
        width: 16px;
        height: 16px;
        border: 2px solid #d1d5db;
        border-radius: 50%;
        appearance: none;
        background: white;
        cursor: pointer;
        position: relative;
      }

      input[type="radio"]:checked {
        border-color: #374151;
        background: #374151;
      }

      input[type="radio"]:checked::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: white;
      }

      /* Select dropdown arrow */
      select {
        cursor: pointer;
      }

      /* Save button styling */
      button[type="submit"] {
        background: #10b981 !important;
        color: white !important;
        padding: 12px 24px !important;
        border: none !important;
        border-radius: 8px !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        transition: background-color 0.2s !important;
      }

      button[type="submit"]:hover {
        background: #059669 !important;
      }

      /* Responsive */
      @media (max-width: 768px) {
        .tab-content form {
          grid-template-columns: 1fr !important;
        }

        input,
        select,
        textarea {
          padding: 12px 16px !important;
        }
        
        /* Employee Profile Header Responsive */
        .employee-profile-header {
          padding: 16px !important;
          margin: 16px 20px !important;
        }
        
        .employee-profile-header > div {
          gap: 12px !important;
        }
        
        .employee-contact-info {
          font-size: 10px !important;
        }
        
        .employee-name {
          font-size: 14px !important;
        }
        
        .employee-role {
          font-size: 11px !important;
        }
      }

      /* Typography consistency */
      * {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      }

      /* HRP Input Classes - Rectangle-29 */
      .hrp-input.Rectangle-29 {
        width: 100%;
        padding: 14px 18px;
        border: 1px solid #d1d5db;
        border-radius: 25px;
        font-size: 14px;
        background: #ffffff;
        color: #374151;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        outline: none;
        transition: border-color 0.2s;
        box-shadow: inset 0 2px 3px rgba(0, 0, 0, .2), 0 1px 0 #fff;
      }

      .hrp-input.Rectangle-29:focus {
        border-color: #3b82f6;
        box-shadow: inset 0 2px 3px rgba(0, 0, 0, .2), 0 1px 0 #fff, 0 0 0 3px rgba(59, 130, 246, 0.1);
      }

      .hrp-input.Rectangle-29::placeholder {
        color: #9ca3af;
        font-weight: 400;
      }

      .Rectangle-29-select {
        width: 100%;
        padding: 14px 18px;
        border: 1px solid #d1d5db;
        border-radius: 25px;
        font-size: 14px;
        background: #ffffff;
        color: #374151;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        outline: none;
        appearance: none;
        background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="%23666" d="M2 0L0 2h4zm0 5L0 3h4z"/></svg>');
        background-repeat: no-repeat;
        background-position: right 18px center;
        background-size: 12px;
        cursor: pointer;
        transition: border-color 0.2s;
        box-shadow: inset 0 2px 3px rgba(0, 0, 0, .2), 0 1px 0 #fff;
      }

      .Rectangle-29-select:focus {
        border-color: #3b82f6;
        box-shadow: inset 0 2px 3px rgba(0, 0, 0, .2), 0 1px 0 #fff, 0 0 0 3px rgba(59, 130, 246, 0.1);
      }

      .Rectangle-29-textarea {
        width: 100%;
        padding: 14px 18px;
        border: 1px solid #d1d5db;
        border-radius: 20px;
        font-size: 14px;
        background: #ffffff;
        color: #374151;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        outline: none;
        min-height: 80px;
        resize: vertical;
        transition: border-color 0.2s;
        box-shadow: inset 0 2px 3px rgba(0, 0, 0, .2), 0 1px 0 #fff;
      }

      .Rectangle-29-textarea:focus {
        border-color: #3b82f6;
        box-shadow: inset 0 2px 3px rgba(0, 0, 0, .2), 0 1px 0 #fff, 0 0 0 3px rgba(59, 130, 246, 0.1);
      }

      .hrp-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      }
      
      .action-icon {
        width: 20px;
        height: 20px;
        cursor: pointer;
        transition: transform 0.2s;
      }
      
      .action-icon:hover {
        transform: scale(1.2);
      }
      
      /* Document delete button - force red color */
      .doc-delete-btn,
      .doc-delete-btn:hover,
      .doc-delete-btn:focus,
      .doc-delete-btn:active,
      .doc-delete-btn:visited {
        background: #ef4444 !important;
        color: white !important;
      }
      
      .doc-delete-btn:hover {
        background: #dc2626 !important;
        transform: scale(1.05) !important;
      }
      
      .doc-delete-btn:active {
        background: #b91c1c !important;
        transform: scale(0.98) !important;
      }
    </style>

    <script>
      function switchTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => {
          tab.classList.remove('active');
          tab.style.display = 'none';
        });

        // Remove active class from all tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
          btn.classList.remove('active');
          btn.style.color = '#718096';
          btn.style.borderBottomColor = 'transparent';
        });

        // Show selected tab content
        const selectedTab = document.getElementById(tabName);
        if (selectedTab) {
          selectedTab.classList.add('active');
          selectedTab.style.display = 'block';
        }

        // Activate selected tab button
        const selectedBtn = document.querySelector(`[onclick="switchTab('${tabName}')"]`);
        if (selectedBtn) {
          selectedBtn.classList.add('active');
          selectedBtn.style.color = '#0ea5e9';
          selectedBtn.style.borderBottomColor = '#0ea5e9';
        }
      }
      
      function copyBankDetails() {
        const bankDetails = `Bank Name: ICICI Bank\nIFSC Code: IBKL0045458\nAccount Number: 465776547675`;
        navigator.clipboard.writeText(bankDetails).then(() => {
          toastr.success('Bank details copied to clipboard!');
        });
      }
      
      function previewPhoto(input) {
        if (input.files && input.files[0]) {
          const reader = new FileReader();
          reader.onload = function(e) {
            // Update all profile images on the page
            document.querySelectorAll('img[alt*="{{ $employee->name ?? $user->name }}"]').forEach(img => {
              img.src = e.target.result;
            });
            toastr.success('Photo selected! Click SAVE CHANGES to upload.');
          };
          reader.readAsDataURL(input.files[0]);
        }
      }
      
      // Upload Document Modal Functions
      function openUploadModal() {
        document.getElementById('uploadModal').style.display = 'flex';
      }

      function closeUploadModal() {
        document.getElementById('uploadModal').style.display = 'none';
        document.getElementById('uploadDocumentForm').reset();
      }

      // Close modal when clicking outside
      document.getElementById('uploadModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
          closeUploadModal();
        }
      });
    </script>

    <!-- Upload Document Modal -->
    <div id="uploadModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
      <div style="background: white; border-radius: 12px; padding: 32px; max-width: 500px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
          <h3 style="font-size: 20px; font-weight: 700; color: #111; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            <i class="fa fa-upload"></i> Upload Document
          </h3>
          <button onclick="closeUploadModal()" style="background: none; border: none; font-size: 24px; color: #9ca3af; cursor: pointer; padding: 0; line-height: 1;">
            &times;
          </button>
        </div>
        
        <form id="uploadDocumentForm" method="POST" action="{{ route('profile.documents.upload') }}" enctype="multipart/form-data">
          @csrf
          
          <div style="margin-bottom: 16px;">
            <label class="hrp-label" style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">Document Name <span style="color: #ef4444;">*</span></label>
            <input type="text" name="document_name" id="documentName" class="hrp-input Rectangle-29" required style="width: 100%;" placeholder="e.g., Passport, Driving License, Certificate">
            <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">Give your document a name</small>
          </div>
          
          <div style="margin-bottom: 16px;">
            <label class="hrp-label" style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">Category (Optional)</label>
            <select name="document_type" id="documentType" class="Rectangle-29 Rectangle-29-select" style="width: 100%;">
              <option value="">Select Category</option>
              <option value="Identity">Identity Document</option>
              <option value="Education">Education Certificate</option>
              <option value="Experience">Experience Letter</option>
              <option value="Financial">Financial Document</option>
              <option value="Medical">Medical Certificate</option>
              <option value="Other">Other</option>
            </select>
          </div>
          
          <div style="margin-bottom: 16px;">
            <label class="hrp-label" style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">Description (Optional)</label>
            <textarea name="description" id="documentDescription" class="Rectangle-29-textarea" style="width: 100%; min-height: 60px;" placeholder="Add any notes about this document"></textarea>
          </div>
          
          <div style="margin-bottom: 24px;">
            <label class="hrp-label" style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">Select File <span style="color: #ef4444;">*</span></label>
            <input type="file" name="document" id="documentFile" accept="image/*,application/pdf,.doc,.docx" required class="hrp-input Rectangle-29" style="width: 100%; padding: 8px;">
            <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">Accepted: JPG, PNG, PDF, DOC, DOCX (Max: 10MB)</small>
          </div>
          
          <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <button type="button" onclick="closeUploadModal()" class="hrp-btn" style="background: #f3f4f6; color: #374151;">
              Cancel
            </button>
            <button type="submit" class="hrp-btn hrp-btn-primary">
              <i class="fa fa-upload"></i> Upload
            </button>
          </div>
        </form>
      </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
// Initialize jQuery datepicker - Same as Attendance Reports
$(document).ready(function() {
    $('#attendanceFilterForm .date-picker, #date_of_birth').datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '-100:+0',
        maxDate: '0',
        showButtonPanel: true,
        beforeShow: function(input, inst) {
            setTimeout(function() {
                inst.dpDiv.css({ marginTop: '2px', marginLeft: '0px' });
            }, 0);
        }
    });
    
    // Convert date format before personal info form submission
    $('form[action="{{ route('profile.update') }}"]').on('submit', function(e) {
        const dobInput = $('#date_of_birth');
        const dateValue = dobInput.val();
        if (dateValue && dateValue.match(/^\d{1,2}\/\d{1,2}\/\d{2,4}$/)) {
            const parts = dateValue.split('/');
            const day = parts[0].padStart(2, '0');
            const month = parts[1].padStart(2, '0');
            let year = parts[2];
            if (year.length === 2) {
                year = (parseInt(year) > 50 ? '19' : '20') + year;
            }
            dobInput.val(`${year}-${month}-${day}`);
        }
    });
});
</script>
@endpush
