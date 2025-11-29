@extends('layouts.macos')
@section('page_title', 'Profile')

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
          <div style="width:56px;height:56px;border-radius:50%;overflow:hidden;background:#fbbf24;flex-shrink:0">
            @php($photo = $employee?->photo_path ? asset('storage/' . $employee->photo_path) : null)
            <img src="{{ $photo ?? 'https://ui-avatars.com/api/?name=' . urlencode($employee->name ?? $user->name) . '&background=f59e0b&color=fff&size=60' }}" style="width:100%;height:100%;object-fit:cover" alt="{{ $employee->name ?? $user->name }}">
          </div>
          <div>
            <h2 style="font-size:24px;font-weight:700;color:#1e293b;margin:0 0 1px 0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">{{ $employee->name ?? $user->name }}</h2>
            <p style="color:#64748b;margin:0;font-size:13px;font-weight:500;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">{{ $employee->position ?? '—' }}</p>
          </div>
        </div>
        
        <!-- Divider -->
        <div style="width:1px;height:36px;background:#e5e7eb"></div>
        
        <!-- Status Badge -->
        @php($status = strtolower($employee->status ?? 'active'))
        @php($badgeBg = $status === 'active' ? '#158f00' : '#6b7280')
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
            {{ $employee->mobile_no ?? ($user->mobile_no ?? '—') }}
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
      </div>
    </div>
    
    <!-- Tab Navigation -->
    <div class="tabbar" style="display:flex;border-bottom:1px solid #e5e7eb;padding:0 32px;background:white;align-items:center;margin-bottom:0">
      <button class="tab-btn active" onclick="switchTab('personal')"
        style="display:flex;align-items:center;gap:10px;padding:16px 20px;border:none;background:none;color:#0ea5e9;border-bottom:2px solid #0ea5e9;font-weight:700;cursor:pointer">
        <span class="tab-ico"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg></span>
        Personal Information
      </button>
      <div class="tab-sep"></div>
      <button class="tab-btn" onclick="switchTab('payroll')"
        style="display:flex;align-items:center;gap:10px;padding:16px 20px;border:none;background:none;color:#718096;border-bottom:2px solid transparent;font-weight:700;cursor:pointer">
        <span class="tab-ico"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg></span>
        Payroll
      </button>
      <div class="tab-sep"></div>
      <button class="tab-btn" onclick="switchTab('attendance')"
        style="display:flex;align-items:center;gap:10px;padding:16px 20px;border:none;background:none;color:#718096;border-bottom:2px solid transparent;font-weight:700;cursor:pointer">
        <span class="tab-ico"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg></span>
        Attendance Management
      </button>
      <div class="tab-sep"></div>
      <button class="tab-btn" onclick="switchTab('documents')"
        style="display:flex;align-items:center;gap:10px;padding:16px 20px;border:none;background:none;color:#718096;border-bottom:2px solid transparent;font-weight:700;cursor:pointer">
        <span class="tab-ico"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/></svg></span>
        Documents
      </button>
      <div class="tab-sep"></div>
      <button class="tab-btn" onclick="switchTab('bank')"
        style="display:flex;align-items:center;gap:10px;padding:16px 20px;border:none;background:none;color:#718096;border-bottom:2px solid transparent;font-weight:700;cursor:pointer">
        <span class="tab-ico"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M11.5,1L2,6V8H21V6M16,10V17H19V19H5V17H8V10H10V17H14V10"/></svg></span>
        Bank Details
      </button>
    </div>

    <!-- Tab Content -->
    <div id="personal" class="tab-content active" style="background:white;border-radius:20px;box-shadow:0 2px 8px rgba(0,0,0,0.08);border:1px solid #e5e7eb;padding:30px;margin:12px 32px 24px">
      <div style="display:flex;gap:30px">
        <!-- Left Column - Profile Image -->
        <div style="flex:0 0 200px">
          <div style="width:200px;height:200px;border-radius:50%;overflow:hidden;background:#fbbf24;margin-bottom:20px">
            @php($photo = $employee?->photo_path ? asset('storage/' . $employee->photo_path) : null)
            <img src="{{ $photo ?? 'https://ui-avatars.com/api/?name=' . urlencode($employee->name ?? $user->name) . '&background=f59e0b&color=fff&size=200' }}"
              style="width:100%;height:100%;object-fit:cover" alt="{{ $employee->name ?? $user->name }}">
          </div>
        </div>

        <!-- Right Column - Form -->
        <div style="flex:1">
          <div class="hrp-compact">
            <form method="POST" action="{{ route('profile.update') }}" style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px 24px;align-items:start">
              <!-- Full Name -->
              <div>
                <label class="hrp-label">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $employee->name ?? $user->name) }}" class="hrp-input Rectangle-29" required>
              </div>

              <!-- Gender -->
              <div>
                <label class="hrp-label">Gender :</label>
                <div style="margin-top:8px; display:flex; align-items:center; justify-content:center;">
                  <div class="gender-toggle Rectangle-29">
                    <label class="gender-option">
                      <input class="gender-radio" type="radio" name="gender" value="male" {{ old('gender', $employee->gender ?? 'male') === 'male' ? 'checked' : '' }}>
                      <span class="gender-text">Male</span>
                      <span class="gender-dot"></span>
                    </label>
                    <label class="gender-option">
                      <input class="gender-radio" type="radio" name="gender" value="female" {{ old('gender', $employee->gender) === 'female' ? 'checked' : '' }}>
                      <span class="gender-text">Female</span>
                      <span class="gender-dot"></span>
                    </label>
                  </div>
                </div>
              </div>

              <!-- Date of Birth -->
              <div>
                <x-date-input 
                  name="date_of_birth" 
                  label="Date of Birth" 
                  :value="old('date_of_birth', $employee->date_of_birth)" 
                />
              </div>

              <!-- Mobile No -->
              <div>
                <label class="hrp-label">Mobile No:</label>
                <input type="text" name="mobile_no" value="{{ old('mobile_no', $employee->mobile_no ?? $user->mobile_no) }}" class="hrp-input Rectangle-29">
              </div>

              <!-- Marital Status -->
              <div>
                <label class="hrp-label">Marital Status :</label>
                <select name="marital_status" class="Rectangle-29 Rectangle-29-select">
                  <option value="">Select Status</option>
                  <option value="single" {{ old('marital_status', $employee->marital_status) === 'single' ? 'selected' : '' }}>Single</option>
                  <option value="married" {{ old('marital_status', $employee->marital_status) === 'married' ? 'selected' : '' }}>Married</option>
                  <option value="divorced" {{ old('marital_status', $employee->marital_status) === 'divorced' ? 'selected' : '' }}>Divorced</option>
                  <option value="widowed" {{ old('marital_status', $employee->marital_status) === 'widowed' ? 'selected' : '' }}>Widowed</option>
                </select>
              </div>

              <!-- Email ID -->
              <div>
                <label class="hrp-label">Email ID :</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="hrp-input Rectangle-29" required>
              </div>

              <!-- Address -->
              <div style="grid-column:1/-1">
                <label class="hrp-label">Address:</label>
                <textarea name="address" placeholder="Enter Your Address" class="Rectangle-29-textarea">{{ old('address', $employee->address ?? $user->address) }}</textarea>
              </div>

              <!-- Aadhaar Card Number -->
              <div>
                <label class="hrp-label">Aadhaar Card Number :</label>
                <input type="text" name="aadhaar_no" value="{{ old('aadhaar_no', $employee->aadhaar_no) }}" placeholder="XXXX XXXX XXXX" class="hrp-input Rectangle-29" maxlength="12">
              </div>

              <!-- PAN Number -->
              <div>
                <label class="hrp-label">PAN Number :</label>
                <input type="text" name="pan_no" value="{{ old('pan_no', $employee->pan_no) }}" placeholder="XXXXX0000X" class="hrp-input Rectangle-29" style="text-transform: uppercase;" maxlength="10">
              </div>

              <!-- Highest Qualification (long) + Previous Designation stacked left, Year of Passing short right -->
              <div style="grid-column:1/-1">
                <div style="display:grid;grid-template-columns:2fr 1fr;gap:20px 24px;align-items:start">
                  <div>
                    <label class="hrp-label">Highest Qualification</label>
                    <input type="text" name="highest_qualification" value="{{ old('highest_qualification', $employee->highest_qualification) }}" placeholder="Enter your Highest Qualification" class="hrp-input Rectangle-29" style="margin-bottom:14px">
                    <label class="hrp-label">Previous Designation</label>
                    <input type="text" name="previous_designation" value="{{ old('previous_designation', $employee->previous_designation) }}" placeholder="Enter your Last Designation" class="hrp-input Rectangle-29">
                  </div>
                  <div>
                    <label class="hrp-label">Year of Passing</label>
                    <input type="text" name="year_of_passing" value="{{ old('year_of_passing', $employee->year_of_passing) }}" placeholder="Passing Year" class="hrp-input Rectangle-29" maxlength="4">
                  </div>
                </div>
              </div>

              <!-- Previous Company Name -->
              <div>
                <label class="hrp-label">Previous Company Name :</label>
                <input type="text" name="previous_company_name" value="{{ old('previous_company_name', $employee->previous_company_name) }}" placeholder="Enter your Last Company Name" class="hrp-input Rectangle-29">
              </div>

              <!-- Duration + Reason for Leaving on same row -->
              <div style="grid-column:1/-1; display:grid; grid-template-columns:1fr 2fr; gap:20px 24px; align-items:start">
                <div>
                  <label class="hrp-label">Duration :</label>
                  <input type="text" name="duration" value="{{ old('duration', $employee->duration) }}" placeholder="Add Time Duration" class="hrp-input Rectangle-29">
                </div>
                <div>
                  <label class="hrp-label">Reason for Leaving</label>
                  <textarea name="reason_for_leaving" placeholder="Enter Reason for Leaving" class="Rectangle-29-textarea">{{ old('reason_for_leaving', $employee->reason_for_leaving) }}</textarea>
                </div>
              </div>

              <!-- Save Button -->
              <div style="grid-column:1/-1;margin-top:20px">
                @csrf
                @method('PATCH')
                <button type="submit"
                  style="background:#10b981;color:white;padding:12px 24px;border:none;border-radius:8px;font-weight:600;cursor:pointer">
                  💾 SAVE CHANGES
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Payroll Tab Content -->
    <div id="payroll" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
      <div class="JV-datatble JV-datatble--zoom striped-surface striped-surface--full table-wrap pad-none">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Payslip ID</th>
              <th>Salary Month</th>
              <th>Payment Date</th>
              <th>Gross Amount</th>
              <th>Net Amount</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if(isset($payslips) && count($payslips))
              @foreach($payslips as $i => $p)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $p->code ?? ('PSL-'.$p->id) }}</td>
                  <td>{{ isset($p->salary_month) ? \Carbon\Carbon::parse($p->salary_month)->format('M - Y') : '-' }}</td>
                  <td>{{ isset($p->payment_date) ? \Carbon\Carbon::parse($p->payment_date)->format('d-m-Y') : '-' }}</td>
                  <td>{{ isset($p->gross_amount) ? '₹'.number_format($p->gross_amount,2) : '-' }}</td>
                  <td>{{ isset($p->net_amount) ? '₹'.number_format($p->net_amount,2) : '-' }}</td>
                  <td>
                    @if(!empty($p->file_path))
                      <a href="{{ asset('storage/'.$p->file_path) }}" target="_blank" style="color:#0ea5e9;font-weight:700;text-decoration:none">View</a>
                    @else
                      —
                    @endif
                  </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="7" style="text-align:center;padding:40px;color:#6b7280">No payslips found</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>

    <!-- Attendance Tab Content -->
    <div id="attendance" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
      <div style="display:flex;justify-content:space-between;align-items:center;padding:16px 32px 0">
        <div style="font-weight:700;color:#1f2937">Attendance Overview</div>
        <form method="get" action="{{ route('profile.edit') }}" style="display:flex;gap:8px;align-items:center">
          <select name="month" onchange="this.form.submit()" style="padding:8px 10px;border:1px solid #d1d5db;border-radius:8px;background:#fff;color:#111827">
            @for($m=1;$m<=12;$m++)
              <option value="{{ $m }}" {{ (int)$month === $m ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$m,1)) }}</option>
            @endfor
          </select>
          <select name="year" onchange="this.form.submit()" style="padding:8px 10px;border:1px solid #d1d5db;border-radius:8px;background:#fff;color:#111827">
            @for($y=now()->year-3;$y<=now()->year+1;$y++)
              <option value="{{ $y }}" {{ (int)$year === $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
          </select>
        </form>
      </div>
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin:0 32px 30px">
        <div style="background:linear-gradient(135deg,#dbeafe 0%,#bfdbfe 100%);padding:20px;border-radius:12px;text-align:center">
          <div style="width:40px;height:40px;background:#3b82f6;border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>
          </div>
          <div style="font-size:28px;font-weight:700;color:#1e40af;margin-bottom:4px">{{ $attSummary['present'] ?? 0 }}</div>
          <div style="font-size:20px;color:#1e40af;font-weight:500">Present Days</div>
        </div>
        <div style="background:linear-gradient(135deg,#dcfce7 0%,#bbf7d0 100%);padding:20px;border-radius:12px;text-align:center">
          <div style="width:40px;height:40px;background:#10b981;border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z"/></svg>
          </div>
          <div style="font-size:28px;font-weight:700;color:#059669;margin-bottom:4px">{{ $attSummary['hours'] ?? '00:00' }}</div>
          <div style="font-size:20px;color:#059669;font-weight:500">Working Hours</div>
        </div>
        <div style="background:linear-gradient(135deg,#fed7aa 0%,#fdba74 100%);padding:20px;border-radius:12px;text-align:center">
          <div style="width:40px;height:40px;background:#f97316;border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M12,6A6,6 0 0,1 18,12A6,6 0 0,1 12,18A6,6 0 0,1 6,12A6,6 0 0,1 12,6M12,8A4,4 0 0,0 8,12A4,4 0 0,0 12,16A4,4 0 0,0 16,12A4,4 0 0,0 12,8Z"/></svg>
          </div>
          <div style="font-size:28px;font-weight:700;color:#ea580c;margin-bottom:4px">{{ $attSummary['late'] ?? 0 }}</div>
          <div style="font-size:20px;color:#ea580c;font-weight:500">Late Entries</div>
        </div>
        <div style="background:linear-gradient(135deg,#fecaca 0%,#fca5a5 100%);padding:20px;border-radius:12px;text-align:center">
          <div style="width:40px;height:40px;background:#ef4444;border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M12,2C17.53,2 22,6.47 22,12C22,17.53 17.53,22 12,22C6.47,22 2,17.53 2,12C2,6.47 6.47,2 12,2M15.59,7L12,10.59L8.41,7L7,8.41L10.59,12L7,15.59L8.41,17L12,13.41L15.59,17L17,15.59L13.41,12L17,8.41L15.59,7Z"/></svg>
          </div>
          <div style="font-size:28px;font-weight:700;color:#dc2626;margin-bottom:4px">{{ $attSummary['absent'] ?? 0 }}</div>
          <div style="font-size:20px;color:#dc2626;font-weight:500">Absent Days</div>
        </div>
      </div>
      <div class="striped-surface table-wrap pad-attn">
        <table class="flat-table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Check IN</th>
              <th>Check OUT</th>
              <th>Working Hours</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($attendances as $row)
            <tr>
              <td>{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
              <td>{{ $row->check_in ? \Carbon\Carbon::parse($row->check_in)->format('h:i A') : '-' }}</td>
              <td>{{ $row->check_out ? \Carbon\Carbon::parse($row->check_out)->format('h:i A') : '-' }}</td>
              <td>
                @if($row->total_working_hours)
                  {{ $row->total_working_hours }}
                @elseif($row->check_in && $row->check_out)
                  @php($mins=\Carbon\Carbon::parse($row->check_in)->diffInMinutes(\Carbon\Carbon::parse($row->check_out)))
                  @php($h=floor($mins/60))
                  @php($m=$mins%60)
                  {{ sprintf('%02d:%02d:00',$h,$m) }}
                @else
                  -
                @endif
              </td>
              <td style="text-transform:capitalize">{{ $row->status ?? '-' }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="5" style="text-align:center;padding:40px;color:#6b7280">No attendance records found for this month</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div id="documents" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:24px;padding:24px 32px">
        @php($hasAny=false)
        @foreach([
          ['key' => 'photo_path', 'label' => 'Profile Photo'],
          ['key' => 'aadhaar_photo_front', 'label' => 'Aadhaar Front'],
          ['key' => 'aadhaar_photo_back', 'label' => 'Aadhaar Back'],
          ['key' => 'pan_photo', 'label' => 'PAN Card'],
          ['key' => 'cheque_photo', 'label' => 'Cheque'],
          ['key' => 'marksheet_photo', 'label' => 'Marksheet'],
        ] as $doc)
          @php($path = $employee?->{$doc['key']} ?? null)
          @php($exists = $path && Storage::disk('public')->exists($path))
          @if($exists)
            @php($hasAny=true)
            @php($url = asset('storage/'.$path))
            @php($ext = strtolower(pathinfo($path, PATHINFO_EXTENSION)))
            @php($isImage = in_array($ext, ['jpg','jpeg','png','gif','webp','bmp']))
            @php($size = Storage::disk('public')->size($path))
            @php($human = $size >= 1048576 ? round($size/1048576,2).' MB' : ($size >= 1024 ? round($size/1024,2).' KB' : $size.' B'))
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
        @if(!$hasAny)
          <div style="grid-column:1/-1;text-align:center;color:#6b7280;padding:40px">No documents found</div>
        @endif
      </div>
    </div>

    <div id="bank" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
      <div style="margin:0 32px 24px">
        @include('profile.partials.bank-details')
      </div>
    </div>
  </div>

  @section('footer_pagination')
  @if(isset($payrolls) && method_exists($payrolls,'links'))
      <form method="GET" class="hrp-entries-form" style="display:inline-flex;align-items:center;gap:6px;margin-right:10px">
        <span>Entries</span>
        <select name="per_page" onchange="this.form.submit()" style="border:1px solid #E5E5E5;border-radius:6px;padding:2px 8px;height:26px">
          @php($currentPerPage = (int) request()->get('per_page', 10))
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

      /* Form input focus states */
      input:focus,
      select:focus,
      textarea:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
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
    </script>
@endsection
