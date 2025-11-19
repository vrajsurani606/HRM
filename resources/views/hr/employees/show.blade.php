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
    <!-- Document Header -->
    <div style="background:#f8fafc;border-bottom:1px solid #e5e7eb;padding:24px 32px">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
        <h3 style="font-size:20px;font-weight:700;color:#1e293b;margin:0">Employee Documents</h3>
        <button onclick="openUploadModal()" style="background:#3b82f6;color:white;padding:12px 20px;border:none;border-radius:8px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:8px;transition:all 0.2s">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
          </svg>
          Upload Document
        </button>
      </div>
      
      <!-- Search and Filter -->
      <div style="display:flex;gap:16px;align-items:center">
        <div style="position:relative;flex:1;max-width:400px">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="#9ca3af" style="position:absolute;left:16px;top:50%;transform:translateY(-50%)">
            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
          </svg>
          <input type="text" id="documentSearch" placeholder="Search documents..." style="width:100%;padding:12px 16px 12px 48px;border:1px solid #e5e7eb;border-radius:8px;font-size:14px;background:white;color:#374151;outline:none">
        </div>
        <select style="padding:12px 16px;border:1px solid #e5e7eb;border-radius:8px;font-size:14px;background:white;color:#374151;outline:none;min-width:150px">
          <option value="">All Types</option>
          <option value="resume">Resume/CV</option>
          <option value="id">ID Documents</option>
          <option value="certificate">Certificates</option>
          <option value="contract">Contracts</option>
          <option value="other">Other</option>
        </select>
      </div>
    </div>
    
    <!-- Document Categories -->
    <div style="padding:32px">
      <!-- Essential Documents -->
      <div style="margin-bottom:40px">
        <h4 style="font-size:16px;font-weight:600;color:#374151;margin:0 0 20px 0;display:flex;align-items:center;gap:8px">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="#ef4444">
            <path d="M12,2L13.09,8.26L22,9L13.09,9.74L12,16L10.91,9.74L2,9L10.91,8.26L12,2Z"/>
          </svg>
          Essential Documents
        </h4>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:16px">
          <!-- Resume/CV -->
          <div style="border:2px dashed #e5e7eb;border-radius:12px;padding:24px;text-align:center;background:#fafafa;transition:all 0.2s;cursor:pointer" onclick="uploadDocument('resume')">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="#6b7280" style="margin:0 auto 12px">
              <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
            </svg>
            <div style="font-weight:600;color:#374151;margin-bottom:4px">Resume/CV</div>
            <div style="font-size:12px;color:#6b7280">Click to upload</div>
          </div>
          
          <!-- ID Proof -->
          <div style="border:2px dashed #e5e7eb;border-radius:12px;padding:24px;text-align:center;background:#fafafa;transition:all 0.2s;cursor:pointer" onclick="uploadDocument('id')">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="#6b7280" style="margin:0 auto 12px">
              <path d="M22,3H2C0.91,3.04 0.04,3.91 0,5V19C0.04,20.09 0.91,20.96 2,21H22C23.09,20.96 23.96,20.09 24,19V5C23.96,3.91 23.09,3.04 22,3M22,19H2V5H22V19M14,17V15.75C14,14.09 10.66,13.25 9,13.25C7.34,13.25 4,14.09 4,15.75V17H14M9,7A2.5,2.5 0 0,0 6.5,9.5A2.5,2.5 0 0,0 9,12A2.5,2.5 0 0,0 11.5,9.5A2.5,2.5 0 0,0 9,7M14,7V8H20V7H14M14,9V10H20V9H14M14,11V12H18V11H14"/>
            </svg>
            <div style="font-weight:600;color:#374151;margin-bottom:4px">ID Proof</div>
            <div style="font-size:12px;color:#6b7280">Aadhar, PAN, etc.</div>
          </div>
          
          <!-- Address Proof -->
          <div style="border:2px dashed #e5e7eb;border-radius:12px;padding:24px;text-align:center;background:#fafafa;transition:all 0.2s;cursor:pointer" onclick="uploadDocument('address')">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="#6b7280" style="margin:0 auto 12px">
              <path d="M12,3L2,12H5V20H19V12H22L12,3M12,8.75A2.25,2.25 0 0,1 14.25,11A2.25,2.25 0 0,1 12,13.25A2.25,2.25 0 0,1 9.75,11A2.25,2.25 0 0,1 12,8.75Z"/>
            </svg>
            <div style="font-weight:600;color:#374151;margin-bottom:4px">Address Proof</div>
            <div style="font-size:12px;color:#6b7280">Utility bills, etc.</div>
          </div>
        </div>
      </div>
      
      <!-- Educational Documents -->
      <div style="margin-bottom:40px">
        <h4 style="font-size:16px;font-weight:600;color:#374151;margin:0 0 20px 0;display:flex;align-items:center;gap:8px">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="#3b82f6">
            <path d="M12,3L1,9L12,15L21,10.09V17H23V9M5,13.18V17.18L12,21L19,17.18V13.18L12,17L5,13.18Z"/>
          </svg>
          Educational Certificates
        </h4>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px">
          <div style="border:2px dashed #e5e7eb;border-radius:12px;padding:24px;text-align:center;background:#fafafa;transition:all 0.2s;cursor:pointer" onclick="uploadDocument('education')">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="#6b7280" style="margin:0 auto 12px">
              <path d="M9,10H7V12H9V10M13,10H11V12H13V10M17,10H15V12H17V10M19,3H18V1H16V3H8V1H6V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M19,19H5V8H19V19Z"/>
            </svg>
            <div style="font-weight:600;color:#374151;margin-bottom:4px">Degree/Diploma</div>
            <div style="font-size:12px;color:#6b7280">Upload certificates</div>
          </div>
        </div>
      </div>
      
      <!-- Uploaded Documents List -->
      <div id="uploadedDocuments">
        <h4 style="font-size:16px;font-weight:600;color:#374151;margin:0 0 20px 0;display:flex;align-items:center;gap:8px">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="#10b981">
            <path d="M13,9H18.5L13,3.5V9M6,2H14L20,8V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V4C4,2.89 4.89,2 6,2M6,20H18V10H12V4H6V20Z"/>
          </svg>
          Uploaded Documents
        </h4>
        
        <!-- Sample Documents (Replace with dynamic content) -->
        <div style="display:grid;gap:12px">
          <!-- Document Item -->
          <div style="border:1px solid #e5e7eb;border-radius:8px;padding:16px;background:white;display:flex;align-items:center;gap:16px;transition:all 0.2s;box-shadow:0 1px 3px rgba(0,0,0,0.1)">
            <div style="width:40px;height:40px;background:#dbeafe;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="#3b82f6">
                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
              </svg>
            </div>
            <div style="flex:1">
              <div style="font-weight:600;color:#374151;margin-bottom:2px">Resume_{{ $employee->name }}.pdf</div>
              <div style="font-size:12px;color:#6b7280">Resume/CV • 2.4 MB • Uploaded 2 days ago</div>
            </div>
            <div style="display:flex;gap:8px">
              <button style="padding:6px 12px;background:#f3f4f6;border:1px solid #d1d5db;border-radius:6px;font-size:12px;color:#374151;cursor:pointer;display:flex;align-items:center;gap:4px">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/>
                </svg>
                View
              </button>
              <button style="padding:6px 12px;background:#f3f4f6;border:1px solid #d1d5db;border-radius:6px;font-size:12px;color:#374151;cursor:pointer;display:flex;align-items:center;gap:4px">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M5,20H19V18H5M19,9H15V3H9V9H5L12,16L19,9Z"/>
                </svg>
                Download
              </button>
              <button style="padding:6px 8px;background:#fef2f2;border:1px solid #fecaca;border-radius:6px;color:#dc2626;cursor:pointer">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"/>
                </svg>
              </button>
            </div>
          </div>
          
          <!-- Empty State -->
          <div style="text-align:center;padding:40px 20px;color:#6b7280;border:2px dashed #e5e7eb;border-radius:12px;margin-top:20px">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="#d1d5db" style="margin:0 auto 16px">
              <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
            </svg>
            <div style="font-size:16px;font-weight:600;margin-bottom:8px">No Documents Uploaded Yet</div>
            <div style="font-size:14px;margin-bottom:16px">Start by uploading essential documents above</div>
            <button onclick="openUploadModal()" style="background:#3b82f6;color:white;padding:8px 16px;border:none;border-radius:6px;font-size:14px;cursor:pointer">
              Upload First Document
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bank Details Tab -->
  <div id="bank" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
    <!-- Bank Header -->
    <div style="background:#f8fafc;border-bottom:1px solid #e5e7eb;padding:24px 32px">
      <div style="display:flex;justify-content:space-between;align-items:center">
        <div>
          <h3 style="font-size:20px;font-weight:700;color:#1e293b;margin:0 0 4px 0">Banking Information</h3>
          <p style="color:#6b7280;margin:0;font-size:14px">Manage employee banking details for payroll processing</p>
        </div>
        <button onclick="editBankDetails()" style="background:#3b82f6;color:white;padding:12px 20px;border:none;border-radius:8px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:8px;transition:all 0.2s">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
            <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z"/>
          </svg>
          Edit Details
        </button>
      </div>
    </div>
    
    <div style="padding:32px">
      <div style="max-width:800px">
        <!-- Bank Account Information -->
        <div style="background:white;border:1px solid #e5e7eb;border-radius:16px;padding:32px;box-shadow:0 4px 6px rgba(0,0,0,0.05);margin-bottom:24px">
          <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px">
            <div style="width:48px;height:48px;background:#dbeafe;border-radius:12px;display:flex;align-items:center;justify-content:center">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="#3b82f6">
                <path d="M11.5,1L2,6V8H21V6M16,10V17H19V19H5V17H8V10H10V17H14V10"/>
              </svg>
            </div>
            <div>
              <h4 style="font-size:18px;font-weight:600;color:#1e293b;margin:0 0 2px 0">Primary Bank Account</h4>
              <p style="color:#6b7280;margin:0;font-size:14px">Main account for salary deposits</p>
            </div>
          </div>
          
          <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:24px">
            <div>
              <label style="display:block;font-weight:600;color:#374151;margin-bottom:8px;font-size:14px">Bank Name</label>
              <div style="padding:16px;border:1px solid #e5e7eb;border-radius:8px;font-size:16px;background:#f9fafb;color:#374151;display:flex;align-items:center;gap:12px">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#6b7280">
                  <path d="M11.5,1L2,6V8H21V6M16,10V17H19V19H5V17H8V10H10V17H14V10"/>
                </svg>
                {{ $employee->bank_name ?? 'Not Available' }}
              </div>
            </div>
            
            <div>
              <label style="display:block;font-weight:600;color:#374151;margin-bottom:8px;font-size:14px">Branch Name</label>
              <div style="padding:16px;border:1px solid #e5e7eb;border-radius:8px;font-size:16px;background:#f9fafb;color:#374151;display:flex;align-items:center;gap:12px">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#6b7280">
                  <path d="M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12,2Z"/>
                </svg>
                {{ $employee->branch_name ?? 'Not Available' }}
              </div>
            </div>
            
            <div>
              <label style="display:block;font-weight:600;color:#374151;margin-bottom:8px;font-size:14px">IFSC Code</label>
              <div style="padding:16px;border:1px solid #e5e7eb;border-radius:8px;font-size:16px;background:#f9fafb;color:#374151;display:flex;align-items:center;gap:12px">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#6b7280">
                  <path d="M9,7H7V9H9V7M11,7V9H13V7H11M15,7V9H17V7H15M7,11V13H9V11H7M13,11V13H11V11H13M17,11V13H15V11H17M7,15V17H9V15H7M13,15V17H11V15H13M17,15V17H15V15H17Z"/>
                </svg>
                {{ $employee->ifsc_code ?? 'Not Available' }}
              </div>
            </div>
            
            <div>
              <label style="display:block;font-weight:600;color:#374151;margin-bottom:8px;font-size:14px">Account Type</label>
              <div style="padding:16px;border:1px solid #e5e7eb;border-radius:8px;font-size:16px;background:#f9fafb;color:#374151;display:flex;align-items:center;gap:12px">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#6b7280">
                  <path d="M17,18C15.89,18 15,18.89 15,20A3,3 0 0,0 18,23A3,3 0 0,0 21,20C21,18.89 20.1,18 19,18H17M12,3L1,9L12,15L21,10.09V17H23V9"/>
                </svg>
                {{ $employee->account_type ?? 'Savings Account' }}
              </div>
            </div>
            
            <div style="grid-column:1/-1">
              <label style="display:block;font-weight:600;color:#374151;margin-bottom:8px;font-size:14px">Account Number</label>
              <div style="padding:16px;border:1px solid #e5e7eb;border-radius:8px;font-size:16px;background:#f9fafb;color:#374151;display:flex;align-items:center;justify-content:space-between">
                <div style="display:flex;align-items:center;gap:12px">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="#6b7280">
                    <path d="M6,2A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2H6M6,4H13V9H18V20H6V4Z"/>
                  </svg>
                  <span id="accountNumber">{{ $employee->account_number ? str_repeat('*', strlen($employee->account_number) - 4) . substr($employee->account_number, -4) : 'Not Available' }}</span>
                </div>
                @if($employee->account_number)
                <button onclick="toggleAccountNumber()" style="padding:4px 8px;background:#f3f4f6;border:1px solid #d1d5db;border-radius:4px;font-size:12px;color:#374151;cursor:pointer">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/>
                  </svg>
                </button>
                @endif
              </div>
            </div>
          </div>
        </div>
        
        <!-- Bank Verification Status -->
        <div style="background:white;border:1px solid #e5e7eb;border-radius:16px;padding:24px;box-shadow:0 4px 6px rgba(0,0,0,0.05)">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
            <h4 style="font-size:16px;font-weight:600;color:#1e293b;margin:0">Verification Status</h4>
            @if($employee->bank_verified ?? false)
            <span style="background:#dcfce7;color:#166534;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;display:flex;align-items:center;gap:4px">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z"/>
              </svg>
              Verified
            </span>
            @else
            <span style="background:#fef3c7;color:#92400e;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;display:flex;align-items:center;gap:4px">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,17A1.5,1.5 0 0,1 10.5,15.5A1.5,1.5 0 0,1 12,14A1.5,1.5 0 0,1 13.5,15.5A1.5,1.5 0 0,1 12,17M12,10A1,1 0 0,1 13,11V13A1,1 0 0,1 12,14A1,1 0 0,1 11,13V11A1,1 0 0,1 12,10Z"/>
              </svg>
              Pending Verification
            </span>
            @endif
          </div>
          
          <div style="display:flex;gap:12px">
            @if(!($employee->bank_verified ?? false))
            <button style="background:#f59e0b;color:white;padding:8px 16px;border:none;border-radius:6px;font-size:14px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:6px">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="white">
                <path d="M9,20.42L2.79,14.21L5.62,11.38L9,14.77L18.88,4.88L21.71,7.71L9,20.42Z"/>
              </svg>
              Verify Account
            </button>
            @endif
            
            <button style="background:#6b7280;color:white;padding:8px 16px;border:none;border-radius:6px;font-size:14px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:6px">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="white">
                <path d="M5,20H19V18H5M19,9H15V3H9V9H5L12,16L19,9Z"/>
              </svg>
              Download Bank Form
            </button>
          </div>
        </div>
        
        @if(!$employee->bank_name)
        <!-- Empty State -->
        <div style="text-align:center;padding:60px 20px;color:#6b7280;border:2px dashed #e5e7eb;border-radius:16px;margin-top:24px">
          <svg width="64" height="64" viewBox="0 0 24 24" fill="#d1d5db" style="margin:0 auto 20px">
            <path d="M11.5,1L2,6V8H21V6M16,10V17H19V19H5V17H8V10H10V17H14V10"/>
          </svg>
          <div style="font-size:18px;font-weight:600;margin-bottom:8px">No Banking Details Available</div>
          <div style="font-size:14px;margin-bottom:20px">Add banking information to enable payroll processing</div>
          <button onclick="editBankDetails()" style="background:#3b82f6;color:white;padding:12px 24px;border:none;border-radius:8px;font-weight:600;cursor:pointer">
            Add Bank Details
          </button>
        </div>
        @endif
      </div>
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
  
  /* Document Upload Styles */
  .document-upload-area:hover {
    border-color: #3b82f6 !important;
    background: #eff6ff !important;
  }
  
  .document-item:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
    transform: translateY(-2px);
  }
  
  .document-category:hover {
    border-color: #3b82f6 !important;
    background: #eff6ff !important;
  }
  
  /* Button Hover Effects */
  button:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }
  
  button:active {
    transform: translateY(0);
  }
  
  /* Bank Details Styles */
  .bank-field {
    transition: all 0.2s ease;
  }
  
  .bank-field:hover {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }
  
  /* Search Input Styles */
  input[type="text"]:focus,
  select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }
  
  /* Status Badge Animations */
  .status-badge {
    animation: pulse 2s infinite;
  }
  
  @keyframes pulse {
    0%, 100% {
      opacity: 1;
    }
    50% {
      opacity: 0.8;
    }
  }
  
  /* Responsive Design */
  @media (max-width: 768px) {
    #personal > div {
      grid-template-columns: 1fr !important;
    }
    
    .tabbar {
      overflow-x: auto;
      white-space: nowrap;
    }
    
    .tab-btn {
      flex-shrink: 0;
    }
    
    /* Document grid responsive */
    #documents .document-grid {
      grid-template-columns: 1fr !important;
    }
    
    /* Bank details responsive */
    #bank .bank-grid {
      grid-template-columns: 1fr !important;
    }
  }
  
  @media (max-width: 640px) {
    /* Employee header responsive */
    .employee-header {
      flex-direction: column !important;
      gap: 16px !important;
    }
    
    .employee-header > div {
      width: 100% !important;
    }
    
    /* Tab content padding */
    .tab-content {
      padding: 16px !important;
    }
    
    /* Modal responsive */
    .modal-content {
      width: 95% !important;
      margin: 20px !important;
    }
  }
  
  /* Loading States */
  .loading {
    opacity: 0.6;
    pointer-events: none;
  }
  
  .loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid #3b82f6;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite;
  }
  
  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }
  
  /* Smooth transitions */
  * {
    transition: all 0.2s ease;
  }
  
  /* Custom scrollbar */
  ::-webkit-scrollbar {
    width: 8px;
  }
  
  ::-webkit-scrollbar-track {
    background: #f1f5f9;
  }
  
  ::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
  }
  
  ::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
  }
</style>
@endpush

@push('scripts')
<script>
  let accountNumberVisible = false;
  const fullAccountNumber = '{{ $employee->account_number ?? "" }}';
  
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
  
  function openUploadModal() {
    // Create modal for document upload
    const modal = document.createElement('div');
    modal.style.cssText = `
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    `;
    
    modal.innerHTML = `
      <div style="background: white; border-radius: 16px; padding: 32px; max-width: 500px; width: 90%; max-height: 80vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
          <h3 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0;">Upload Document</h3>
          <button onclick="closeModal()" style="background: none; border: none; font-size: 24px; color: #6b7280; cursor: pointer;">&times;</button>
        </div>
        
        <form id="documentUploadForm">
          <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Document Type</label>
            <select name="document_type" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
              <option value="resume">Resume/CV</option>
              <option value="id">ID Proof</option>
              <option value="address">Address Proof</option>
              <option value="education">Educational Certificate</option>
              <option value="contract">Contract</option>
              <option value="other">Other</option>
            </select>
          </div>
          
          <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Document Name</label>
            <input type="text" name="document_name" placeholder="Enter document name" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
          </div>
          
          <div style="margin-bottom: 24px;">
            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Select File</label>
            <div style="border: 2px dashed #e5e7eb; border-radius: 8px; padding: 40px; text-align: center; background: #f9fafb;">
              <input type="file" id="documentFile" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" style="display: none;">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="#6b7280" style="margin: 0 auto 12px;">
                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
              </svg>
              <div style="font-weight: 600; color: #374151; margin-bottom: 4px;">Click to upload or drag and drop</div>
              <div style="font-size: 12px; color: #6b7280;">PDF, DOC, DOCX, JPG, PNG (Max 10MB)</div>
              <button type="button" onclick="document.getElementById('documentFile').click()" style="background: #3b82f6; color: white; padding: 8px 16px; border: none; border-radius: 6px; margin-top: 12px; cursor: pointer;">Choose File</button>
            </div>
          </div>
          
          <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <button type="button" onclick="closeModal()" style="background: #f3f4f6; color: #374151; padding: 12px 24px; border: 1px solid #d1d5db; border-radius: 8px; font-weight: 600; cursor: pointer;">Cancel</button>
            <button type="submit" style="background: #3b82f6; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Upload Document</button>
          </div>
        </form>
      </div>
    `;
    
    document.body.appendChild(modal);
    
    // Add event listener for form submission
    document.getElementById('documentUploadForm').addEventListener('submit', function(e) {
      e.preventDefault();
      // Handle document upload here
      alert('Document upload functionality would be implemented here');
      closeModal();
    });
    
    window.closeModal = function() {
      document.body.removeChild(modal);
    };
  }
  
  function uploadDocument(type) {
    openUploadModal();
    // Pre-select document type
    setTimeout(() => {
      const select = document.querySelector('select[name="document_type"]');
      if (select) {
        select.value = type;
      }
    }, 100);
  }
  
  function editBankDetails() {
    // Create modal for bank details editing
    const modal = document.createElement('div');
    modal.style.cssText = `
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    `;
    
    modal.innerHTML = `
      <div style="background: white; border-radius: 16px; padding: 32px; max-width: 600px; width: 90%; max-height: 80vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
          <h3 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0;">Edit Bank Details</h3>
          <button onclick="closeBankModal()" style="background: none; border: none; font-size: 24px; color: #6b7280; cursor: pointer;">&times;</button>
        </div>
        
        <form id="bankDetailsForm">
          <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
            <div>
              <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Bank Name</label>
              <input type="text" name="bank_name" value="{{ $employee->bank_name ?? '' }}" placeholder="Enter bank name" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
            </div>
            <div>
              <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Branch Name</label>
              <input type="text" name="branch_name" value="{{ $employee->branch_name ?? '' }}" placeholder="Enter branch name" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
            </div>
          </div>
          
          <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
            <div>
              <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">IFSC Code</label>
              <input type="text" name="ifsc_code" value="{{ $employee->ifsc_code ?? '' }}" placeholder="Enter IFSC code" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; text-transform: uppercase;">
            </div>
            <div>
              <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Account Type</label>
              <select name="account_type" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                <option value="savings" {{ ($employee->account_type ?? '') == 'savings' ? 'selected' : '' }}>Savings Account</option>
                <option value="current" {{ ($employee->account_type ?? '') == 'current' ? 'selected' : '' }}>Current Account</option>
                <option value="salary" {{ ($employee->account_type ?? '') == 'salary' ? 'selected' : '' }}>Salary Account</option>
              </select>
            </div>
          </div>
          
          <div style="margin-bottom: 24px;">
            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Account Number</label>
            <input type="text" name="account_number" value="{{ $employee->account_number ?? '' }}" placeholder="Enter account number" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
          </div>
          
          <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <button type="button" onclick="closeBankModal()" style="background: #f3f4f6; color: #374151; padding: 12px 24px; border: 1px solid #d1d5db; border-radius: 8px; font-weight: 600; cursor: pointer;">Cancel</button>
            <button type="submit" style="background: #3b82f6; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Save Changes</button>
          </div>
        </form>
      </div>
    `;
    
    document.body.appendChild(modal);
    
    // Add event listener for form submission
    document.getElementById('bankDetailsForm').addEventListener('submit', function(e) {
      e.preventDefault();
      // Handle bank details update here
      alert('Bank details update functionality would be implemented here');
      closeBankModal();
    });
    
    window.closeBankModal = function() {
      document.body.removeChild(modal);
    };
  }
  
  function toggleAccountNumber() {
    const accountNumberElement = document.getElementById('accountNumber');
    if (!accountNumberElement || !fullAccountNumber) return;
    
    accountNumberVisible = !accountNumberVisible;
    
    if (accountNumberVisible) {
      accountNumberElement.textContent = fullAccountNumber;
    } else {
      const maskedNumber = '*'.repeat(fullAccountNumber.length - 4) + fullAccountNumber.slice(-4);
      accountNumberElement.textContent = maskedNumber;
    }
  }
  
  // Document search functionality
  document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('documentSearch');
    if (searchInput) {
      searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        // Implement document search functionality here
        console.log('Searching for:', searchTerm);
      });
    }
  });
</script>
@endpush