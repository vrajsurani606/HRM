@extends('layouts.macos')
@section('page_title', 'Employee Details')

@section('content')
  <!-- Employee Profile Header -->
  <div style="padding:24px 40px;background:white">
    <div style="display:flex;align-items:center;gap:20px;justify-content:space-between;flex-wrap:wrap;width:100%">
      <!-- Employee Code -->
      <div style="flex-shrink:0">
        <div style="font-size:12px;color:#64748b;font-weight:500;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;margin-bottom:2px">Employee Code</div>
        <div style="font-size:16px;color:#1e293b;font-weight:700;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">#{{ $employee->code ?: 'N/A' }}</div>
      </div>
      
      <!-- Divider -->
      <div style="width:1px;height:36px;background:#e5e7eb"></div>
      
      <!-- Profile Info -->
      <div style="display:flex;align-items:center;gap:8px">
        <div style="width:56px;height:56px;border-radius:50%;overflow:hidden;background:#fbbf24;flex-shrink:0">
          @if($employee->photo_path)
            <img src="{{ asset('storage/'.$employee->photo_path) }}" style="width:100%;height:100%;object-fit:cover" alt="{{ $employee->name }}">
          @else
            @php($initial = strtoupper(mb_substr((string)($employee->name ?? 'U'), 0, 1)))
            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:20px;color:#fff;background:linear-gradient(135deg,#3b82f6,#9333ea);">
              {{ $initial }}
            </div>
          @endif
        </div>
        <div>
          <h2 style="font-size:24px;font-weight:700;color:#1e293b;margin:0 0 1px 0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">{{ $employee->name }}</h2>
          <p style="color:#64748b;margin:0;font-size:13px;font-weight:500;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">{{ $employee->position ?: 'N/A' }}</p>
        </div>
      </div>
      
      <!-- Divider -->
      <div style="width:1px;height:36px;background:#e5e7eb"></div>
      
      <!-- Status Badge -->
      <div style="display:flex;align-items:center;gap:16px;background:{{ $employee->status === 'active' ? '#158f00' : '#ef4444' }};color:#ffffff;font-weight:700;font-size:14px;padding:6px 14px;border-radius:9999px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;flex-shrink:0">
        <div style="width:8px;height:8px;background:#ffffff;border-radius:50%"></div>
        {{ ucfirst($employee->status) }}
      </div>
      
      <!-- Divider -->
      <div style="width:1px;height:36px;background:#e5e7eb"></div>
      
      <!-- Contact Info -->
      <div style="display:flex;flex-direction:column;gap:8px;flex-shrink:0">
        <div style="display:flex;align-items:center;gap:6px;color:#000000;font-size:14px;font-weight:600;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
          </svg>
          {{ $employee->mobile_no ?: 'N/A' }}
        </div>
        <div style="display:flex;align-items:center;gap:6px;color:#000000;font-size:14px;font-weight:600;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
          </svg>
          {{ $employee->email }}
        </div>
      </div>
      
      <!-- Divider -->
      <div style="width:1px;height:36px;background:#e5e7eb"></div>
      
      <!-- Join Date -->
      <div style="flex-shrink:0">
        <div style="font-size:14px;color:#000000;font-weight:600;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;margin-bottom:2px">Join Date:</div>
        <div style="font-size:16px;color:#000000;font-weight:700;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
          {{ $employee->joining_date ? \Carbon\Carbon::parse($employee->joining_date)->format('d / m / Y') : 'N/A' }}
        </div>
      </div>
    </div>
  </div>
  
  <!-- Tab Navigation -->
  <div class="tabbar" style="display:flex;border-bottom:1px solid #e5e7eb;padding:0 32px;background:white;align-items:center;margin-bottom:0">
    <button class="tab-btn active" onclick="switchTab('personal')" style="display:flex;align-items:center;gap:10px;padding:16px 20px;border:none;background:none;color:#0ea5e9;border-bottom:2px solid #0ea5e9;font-weight:700;cursor:pointer">
      <span class="tab-ico"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg></span>
      Personal Information
    </button>
    <div class="tab-sep"></div>
    <button class="tab-btn" onclick="switchTab('payslips')" style="display:flex;align-items:center;gap:10px;padding:16px 20px;border:none;background:none;color:#718096;border-bottom:2px solid transparent;font-weight:700;cursor:pointer">
      <span class="tab-ico"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg></span>
      Payslips
    </button>
    <div class="tab-sep"></div>
    <button class="tab-btn" onclick="switchTab('leaves')" style="display:flex;align-items:center;gap:10px;padding:16px 20px;border:none;background:none;color:#718096;border-bottom:2px solid transparent;font-weight:700;cursor:pointer">
      <span class="tab-ico"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M9 11H7v6h2v-6zm4 0h-2v6h2v-6zm4 0h-2v6h2v-6zm2-7h-3V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/></svg></span>
      Leaves
    </button>
    <div class="tab-sep"></div>
    <button class="tab-btn" onclick="switchTab('attendance')" style="display:flex;align-items:center;gap:10px;padding:16px 20px;border:none;background:none;color:#718096;border-bottom:2px solid transparent;font-weight:700;cursor:pointer">
      <span class="tab-ico"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg></span>
      Attendance
    </button>
    <div class="tab-sep"></div>
    <button class="tab-btn" onclick="switchTab('documents')" style="display:flex;align-items:center;gap:10px;padding:16px 20px;border:none;background:none;color:#718096;border-bottom:2px solid transparent;font-weight:700;cursor:pointer">
      <span class="tab-ico"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/></svg></span>
      Documents
    </button>
    <div class="tab-sep"></div>
    <button class="tab-btn" onclick="switchTab('bank')" style="display:flex;align-items:center;gap:10px;padding:16px 20px;border:none;background:none;color:#718096;border-bottom:2px solid transparent;font-weight:700;cursor:pointer">
      <span class="tab-ico"><svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M11.5,1L2,6V8H21V6M16,10V17H19V19H5V17H8V10H10V17H14V10"/></svg></span>
      Bank Details
    </button>
  </div>

  <!-- Personal Information Tab -->
  <div id="personal" class="tab-content active" style="background:white;border-radius:20px;box-shadow:0 2px 8px rgba(0,0,0,0.08);border:1px solid #e5e7eb;padding:30px;margin:12px 32px 24px">
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px 24px">
      <div>
        <label class="hrp-label">Full Name:</label>
        <div class="info-value">{{ $employee->name }}</div>
      </div>
      <div>
        <label class="hrp-label">Gender:</label>
        <div class="info-value">{{ ucfirst($employee->gender) ?: 'N/A' }}</div>
      </div>
      <div>
        <label class="hrp-label">Date of Birth:</label>
        <div class="info-value">{{ $employee->date_of_birth ? \Carbon\Carbon::parse($employee->date_of_birth)->format('d/m/Y') : 'N/A' }}</div>
      </div>
      <div>
        <label class="hrp-label">Mobile No:</label>
        <div class="info-value">{{ $employee->mobile_no ?: 'N/A' }}</div>
      </div>
      <div>
        <label class="hrp-label">Email:</label>
        <div class="info-value">{{ $employee->email }}</div>
      </div>
      <div>
        <label class="hrp-label">Position:</label>
        <div class="info-value">{{ $employee->position ?: 'N/A' }}</div>
      </div>
      <div>
        <label class="hrp-label">Experience Type:</label>
        <div class="info-value">{{ $employee->experience_type ?: 'N/A' }}</div>
      </div>
      <div>
        <label class="hrp-label">Current Salary:</label>
        <div class="info-value">₹{{ $employee->current_offer_amount ? number_format($employee->current_offer_amount) : 'N/A' }}</div>
      </div>
      <div>
        <label class="hrp-label">Previous Company:</label>
        <div class="info-value">{{ $employee->previous_company_name ?: 'N/A' }}</div>
      </div>
      <div style="grid-column:1/-1">
        <label class="hrp-label">Address:</label>
        <div class="info-value">{{ $employee->address ?: 'N/A' }}</div>
      </div>
    </div>
  </div>

  <!-- Payslips Tab -->
  <div id="payslips" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
    @if($employee->current_offer_amount)
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
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><img src="{{ asset('action_icon/print.svg') }}" alt="Print" class="action-icon" /></td>
              <td>1</td>
              <td>PAY/CMS/EMP/0012/001</td>
              <td>Nov - 2025</td>
              <td>14-11-2025</td>
              <td>₹40,000</td>
              <td>₹36,000</td>
            </tr>
          </tbody>
        </table>
      </div>
    @else
      <div style="display:flex;align-items:center;justify-content:center;min-height:400px;text-align:center">
        <div style="color:#6b7280;font-size:16px;font-weight:500">
          No payslips found for this employee
        </div>
      </div>
    @endif
  </div>

  <!-- Leaves Tab -->
  <div id="leaves" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
    <div style="display:flex;align-items:center;justify-content:center;min-height:400px;text-align:center">
      <div style="color:#6b7280;font-size:16px;font-weight:500">
        No leave records found for this employee
      </div>
    </div>
  </div>

  <!-- Attendance Tab -->
  <div id="attendance" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
    <!-- Stats Cards -->
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin:0 32px 30px">
      <div style="background:linear-gradient(135deg,#dbeafe 0%,#bfdbfe 100%);padding:20px;border-radius:12px;text-align:center">
        <div style="width:40px;height:40px;background:#3b82f6;border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
          </svg>
        </div>
        <div style="font-size:28px;font-weight:700;color:#1e40af;margin-bottom:4px">0</div>
        <div style="font-size:20px;color:#1e40af;font-weight:500">Present Days</div>
      </div>
      <div style="background:linear-gradient(135deg,#dcfce7 0%,#bbf7d0 100%);padding:20px;border-radius:12px;text-align:center">
        <div style="width:40px;height:40px;background:#10b981;border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
            <path d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z"/>
          </svg>
        </div>
        <div style="font-size:28px;font-weight:700;color:#059669;margin-bottom:4px">0</div>
        <div style="font-size:20px;color:#059669;font-weight:500">Working Hours</div>
      </div>
      <div style="background:linear-gradient(135deg,#fed7aa 0%,#fdba74 100%);padding:20px;border-radius:12px;text-align:center">
        <div style="width:40px;height:40px;background:#f97316;border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
            <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M12,6A6,6 0 0,1 18,12A6,6 0 0,1 12,18A6,6 0 0,1 6,12A6,6 0 0,1 12,6M12,8A4,4 0 0,0 8,12A4,4 0 0,0 12,16A4,4 0 0,0 16,12A4,4 0 0,0 12,8Z"/>
          </svg>
        </div>
        <div style="font-size:28px;font-weight:700;color:#ea580c;margin-bottom:4px">0</div>
        <div style="font-size:20px;color:#ea580c;font-weight:500">Late Entries</div>
      </div>
      <div style="background:linear-gradient(135deg,#fecaca 0%,#fca5a5 100%);padding:20px;border-radius:12px;text-align:center">
        <div style="width:40px;height:40px;background:#ef4444;border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
            <path d="M12,2C17.53,2 22,6.47 22,12C22,17.53 17.53,22 12,22C6.47,22 2,17.53 2,12C2,6.47 6.47,2 12,2M15.59,7L12,10.59L8.41,7L7,8.41L10.59,12L7,15.59L8.41,17L12,13.41L15.59,17L17,15.59L13.41,12L17,8.41L15.59,7Z"/>
          </svg>
        </div>
        <div style="font-size:28px;font-weight:700;color:#dc2626;margin-bottom:4px">0</div>
        <div style="font-size:20px;color:#dc2626;font-weight:500">Absent Days</div>
      </div>
    </div>
    
    <!-- Attendance Table -->
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
          <tr>
            <td colspan="5" style="text-align:center;padding:40px;color:#6b7280">No attendance records found for this employee</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Documents Tab -->
  <div id="documents" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
    <div style="display:flex;justify-content:space-between;align-items:center;padding:0 32px;margin-bottom:30px">
      <div style="position:relative;flex:1;max-width:400px">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="#9ca3af" style="position:absolute;left:16px;top:50%;transform:translateY(-50%)">
          <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
        </svg>
        <input type="text" placeholder="Search documents..." style="width:100%;padding:12px 16px 12px 48px;border:1px solid #e5e7eb;border-radius:8px;font-size:14px;background:#f9fafb;color:#374151;outline:none">
      </div>
      <button style="background:#1f2937;color:white;padding:12px 20px;border:none;border-radius:8px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:8px;margin-left:16px">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
          <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
        </svg>
        Add Document
      </button>
    </div>
    
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px;padding:0 32px 24px">
      <div style="text-align:center;padding:60px 20px;color:#6b7280;grid-column:1/-1">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="#d1d5db" style="margin:0 auto 16px">
          <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
        </svg>
        <div style="font-size:18px;font-weight:600;margin-bottom:8px">No Documents Found</div>
        <div style="font-size:14px">Upload documents for this employee</div>
      </div>
    </div>
  </div>

  <!-- Bank Details Tab -->
  <div id="bank" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
    <div style="max-width:500px;margin:0 32px 24px;background:white;border:1px solid #e5e7eb;border-radius:16px;padding:40px;box-shadow:0 4px 6px rgba(0,0,0,0.05)">
      <div style="margin-bottom:24px">
        <label style="display:block;font-weight:600;color:#374151;margin-bottom:8px;font-size:16px">Bank Name:</label>
        <div style="padding:14px 18px;border:1px solid #d1d5db;border-radius:8px;font-size:16px;background:#f9fafb;color:#374151">Not Available</div>
      </div>
      
      <div style="margin-bottom:24px">
        <label style="display:block;font-weight:600;color:#374151;margin-bottom:8px;font-size:16px">IFSC Code:</label>
        <div style="padding:14px 18px;border:1px solid #d1d5db;border-radius:8px;font-size:16px;background:#f9fafb;color:#374151">Not Available</div>
      </div>
      
      <div style="margin-bottom:32px">
        <label style="display:block;font-weight:600;color:#374151;margin-bottom:8px;font-size:16px">Account Number:</label>
        <div style="padding:14px 18px;border:1px solid #d1d5db;border-radius:8px;font-size:16px;background:#f9fafb;color:#374151">Not Available</div>
      </div>
      
      <button style="background:#6b7280;color:white;padding:12px 24px;border:none;border-radius:8px;font-weight:600;cursor:not-allowed;font-size:16px;width:100%" disabled>
        No Bank Details Available
      </button>
    </div>
  </div>

@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('employees.index') }}" style="font-weight:800;color:#0f0f0f;text-decoration:none">Employee</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">{{ $employee->name }}</span>
@endsection

@push('styles')
<style>
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

  .tab-content {
    display: none;
  }

  .tab-content.active {
    display: block;
  }

  .info-value {
    padding: 12px 16px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    color: #374151;
    font-weight: 500;
    min-height: 20px;
  }

  .hrp-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  }

  @media (max-width: 768px) {
    #personal > div {
      grid-template-columns: 1fr !important;
    }
  }
</style>
@endpush

@push('scripts')
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
</script>
@endpush