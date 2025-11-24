@extends('layouts.macos')
@section('page_title', 'Employee Details')

@section('content')
  <div style="padding:24px 40px;background:white">
    <div style="display:flex;align-items:center;gap:20px;justify-content:space-between;flex-wrap:wrap;width:100%">
      <div style="flex-shrink:0">
        <div style="font-size:12px;color:#64748b;font-weight:500;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;margin-bottom:2px">Employee Code</div>
        <div style="font-size:16px;color:#1e293b;font-weight:700;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">#{{ $employee->code ?: 'N/A' }}</div>
      </div>
      <div style="width:1px;height:36px;background:#e5e7eb"></div>
      <div style="display:flex;align-items:center;gap:8px">
        <div style="width:56px;height:56px;border-radius:50%;overflow:hidden;background:#fbbf24;flex-shrink:0">
          @if($employee->photo_path)
            <img src="{{ asset('storage/'.$employee->photo_path) }}" style="width:100%;height:100%;object-fit:cover" alt="{{ $employee->name }}">
          @else
            @php $initial = strtoupper(mb_substr((string)($employee->name ?? 'U'), 0, 1)); @endphp
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
      <div style="width:1px;height:36px;background:#e5e7eb"></div>
      <div style="display:flex;align-items:center;gap:16px;background:{{ $employee->status === 'active' ? '#158f00' : '#ef4444' }};color:#ffffff;font-weight:700;font-size:14px;padding:6px 14px;border-radius:9999px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;flex-shrink:0">
        <div style="width:8px;height:8px;background:#ffffff;border-radius:50%"></div>
        {{ ucfirst($employee->status) }}
      </div>
      <div style="width:1px;height:36px;background:#e5e7eb"></div>
      <div style="display:flex;flex-direction:column;gap:8px;flex-shrink:0">
        <div style="display:flex;align-items:center;gap:6px;color:#000000;font-size:14px;font-weight:600;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
          {{ $employee->mobile_no ?: 'N/A' }}
        </div>
        <div style="display:flex;align-items:center;gap:6px;color:#000000;font-size:14px;font-weight:600;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
          {{ $employee->email }}
        </div>
      </div>
      <div style="width:1px;height:36px;background:#e5e7eb"></div>
      <div style="flex-shrink:0">
        <div style="font-size:14px;color:#000000;font-weight:600;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;margin-bottom:2px">Join Date:</div>
        <div style="font-size:16px;color:#000000;font-weight:700;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
          {{ $employee->joining_date ? \Carbon\Carbon::parse($employee->joining_date)->format('d / m / Y') : 'N/A' }}
        </div>
      </div>
    </div>
  </div>
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

  <div id="documents" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
    <div style="padding:24px 32px">
     
      @php
        $docs = [
          ['key' => 'photo_path', 'label' => 'Profile Photo', 'path' => $employee->photo_path],
          ['key' => 'aadhaar_photo_front', 'label' => 'Aadhaar - Front', 'path' => $employee->aadhaar_photo_front],
          ['key' => 'aadhaar_photo_back', 'label' => 'Aadhaar - Back', 'path' => $employee->aadhaar_photo_back],
          ['key' => 'pan_photo', 'label' => 'PAN Card', 'path' => $employee->pan_photo],
          ['key' => 'cheque_photo', 'label' => 'Cancelled Cheque', 'path' => $employee->cheque_photo],
          ['key' => 'marksheet_photo', 'label' => 'Marksheet', 'path' => $employee->marksheet_photo],
        ];
        $docs = array_values(array_filter($docs, fn($d) => !empty($d['path'])));
      @endphp

      @if(count($docs) === 0)
        <div style="display:flex;align-items:center;justify-content:center;min-height:300px;text-align:center">
          <div style="color:#6b7280;font-size:16px;font-weight:500">No documents found for this employee</div>
        </div>
      @else
        <div class="document-grid" style="display:grid;grid-template-columns:repeat(auto-fit, minmax(350px, 1fr));gap:20px;align-items:start">
          @foreach($docs as $doc)
            <div class="document-item" style="width:350px;max-width:100%;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;background:white;box-shadow:0 1px 3px rgba(0,0,0,0.1)">
              @php 
                $path = $doc['path'];
                $url = asset('storage/'.$path);
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                $type = strtoupper($ext ?: 'FILE');
                try {
                  $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($path);
                  $bytes = $exists ? \Illuminate\Support\Facades\Storage::disk('public')->size($path) : null;
                } catch (\Throwable $e) {
                  $bytes = null;
                }
                $size = $bytes !== null ? ($bytes >= 1048576 ? number_format($bytes/1048576, 2).' MB' : ($bytes >= 1024 ? number_format($bytes/1024, 0).' KB' : $bytes.' B')) : null;
              @endphp
              <div style="height:180px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;position:relative;cursor:pointer" onclick="viewDocument('{{ $url }}','{{ $doc['label'] }}')">
                <img src="{{ $url }}" style="width:100%;height:100%;object-fit:cover" alt="{{ $doc['label'] }}">
              </div>
              <div style="padding:16px">
                <h3 style="font-size:16px;font-weight:600;color:#374151;margin:0 0 4px 0">{{ $doc['label'] }}</h3>
                <p style="font-size:12px;color:#6b7280;margin:0 0 16px 0">{{ $type }}@if($size) • {{ $size }}@endif</p>
                <div style="display:flex;gap:8px">
                  <a href="{{ $url }}" download style="flex:1;background:#374151;color:white;padding:8px 16px;border:none;border-radius:6px;font-size:12px;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;text-decoration:none">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="white"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"></path></svg>
                    Download
                  </a>
                  <button type="button" onclick="viewDocument('{{ $url }}','{{ $doc['label'] }}')" style="width:36px;height:36px;background:#6b7280;border:none;border-radius:6px;cursor:pointer;display:flex;align-items:center;justify-content:center">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="white" aria-hidden="true">
                      <path d="M12 5C5 5 1 12 1 12s4 7 11 7 11-7 11-7-4-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>
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
        <div style="color:#6b7280;font-size:16px;font-weight:500">No payslips found for this employee</div>
      </div>
    @endif
  </div>

  <div id="leaves" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
    <div style="display:flex;align-items:center;justify-content:center;min-height:400px;text-align:center">
      <div style="color:#6b7280;font-size:16px;font-weight:500">No leave records found for this employee</div>
    </div>
  </div>

  <div id="attendance" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
    <div style="display:flex;justify-content:space-between;align-items:center;padding:16px 32px 0">
      <div style="font-weight:700;color:#1f2937">Attendance Overview</div>
      <form method="get" action="{{ route('employees.show', $employee) }}" style="display:flex;gap:8px;align-items:center">
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

  <div id="bank" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
    <div style="background:#ffffff;border-bottom:1px solid #e5e7eb;padding:24px 32px">
      <div style="display:flex;justify-content:space-between;align-items:center">
        <div>
          <h3 style="font-size:20px;font-weight:700;color:#1e293b;margin:0 0 4px 0">Banking Information</h3>
          <p style="color:#6b7280;margin:0;font-size:14px">Manage employee banking details for payroll processing</p>
        </div>
        <button onclick="editBankDetails()" style="background:#3b82f6;color:white;padding:12px 20px;border:none;border-radius:8px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:8px;transition:all 0.2s">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z"/></svg>
          Edit Details
        </button>
      </div>
    </div>

    <div style="padding:32px">
      <div style="max-width:800px">
        <div style="background:white;border:1px solid #e5e7eb;border-radius:16px;padding:24px 24px;box-shadow:0 6px 18px rgba(0,0,0,0.06);margin-bottom:24px">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
            <div style="display:flex;align-items:center;gap:12px">
              <div style="width:52px;height:52px;background:linear-gradient(135deg,#dbeafe,#bfdbfe);border-radius:14px;display:flex;align-items:center;justify-content:center">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="#2563eb"><path d="M11.5,1L2,6V8H21V6M16,10V17H19V19H5V17H8V10H10V17H14V10"/></svg>
              </div>
              <div>
                <div style="font-size:18px;font-weight:800;color:#0f172a;margin-bottom:2px">{{ $employee->bank_name ?? 'Not Available' }}</div>
                <div style="display:flex;align-items:center;gap:8px">
                  <span style="font-size:12px;color:#0ea5e9;background:#e0f2fe;border:1px solid #bae6fd;border-radius:9999px;padding:2px 8px">IFSC: {{ $employee->bank_ifsc ?? 'N/A' }}</span>
                  <span style="font-size:12px;color:#475569;background:#f1f5f9;border:1px solid #e2e8f0;border-radius:9999px;padding:2px 8px">{{ strtoupper($employee->account_type ?? 'Savings') }}</span>
                </div>
              </div>
            </div>
            <div style="display:flex;gap:8px">
              @if($employee->bank_ifsc)
              <button type="button" onclick="copyText('{{ $employee->bank_ifsc }}')" style="height:36px;padding:0 12px;background:#f3f4f6;border:1px solid #d1d5db;border-radius:8px;font-size:12px;color:#111827;cursor:pointer;display:flex;align-items:center;gap:6px">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19,21H8V7H19M19,3H8A2,2 0 0,0 6,5V21A2,2 0 0,0 8,23H19A2,2 0 0,0 21,21V5A2,2 0 0,0 19,3M5,3H4A2,2 0 0,0 2,5V19A2,2 0 0,0 4,21H5V3Z"/></svg>
                Copy IFSC
              </button>
              @endif
              <button type="button" onclick="editBankDetails()" style="height:36px;padding:0 12px;background:#2563eb;color:white;border:none;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="white"><path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z"/></svg>
                Edit
              </button>
            </div>
          </div>

          <div style="padding:18px;border:1px dashed #e2e8f0;background:#ffffff;border-radius:12px;display:flex;align-items:center;justify-content:space-between">
            <div style="display:flex;align-items:center;gap:12px">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="#64748b"><path d="M6,2A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2H6M6,4H13V9H18V20H6V4Z"/></svg>
              <div style="font-size:18px;font-weight:800;color:#0f172a;letter-spacing:1px">
                <span id="accountNumber">{{ $employee->bank_account_no ? str_repeat('*', strlen($employee->bank_account_no) - 4) . substr($employee->bank_account_no, -4) : 'Not Available' }}</span>
              </div>
            </div>
            @if($employee->bank_account_no)
            <button id="toggleAccBtn" onclick="toggleAccountNumber()" style="padding:8px 12px;background:#ffffff;border:1px solid #d1d5db;border-radius:8px;font-size:12px;color:#111827;cursor:pointer">Show</button>
            @endif
          </div>
        </div>
        @if(!$employee->bank_name)
        <div style="text-align:center;padding:60px 20px;color:#6b7280;border:2px dashed #e5e7eb;border-radius:16px;margin-top:24px">
          <div style="font-size:18px;font-weight:600;margin-bottom:8px">No Banking Details Available</div>
          <div style="font-size:14px;margin-bottom:20px">Add banking information to enable payroll processing</div>
          <button onclick="editBankDetails()" style="background:#3b82f6;color:white;padding:12px 24px;border:none;border-radius:8px;font-weight:600;cursor:pointer">Add Bank Details</button>
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
  html, body { background:#ffffff !important; }
  /* Force common layout wrappers to white */
  #app, .app, .wrapper, .layout, .container, .container-fluid, .content, .page-content, main, body > div { background:#ffffff !important; }
  .tab-btn.active{color:#000000ff!important;border-bottom-color:#000000ff!important}
  .tabbar .tab-ico{display:inline-flex;align-items:center;justify-content:center;width:26px;height:18px;border:1px solid #d1d5db;border-radius:6px;background:#ffffff;box-shadow:inset 0 1px 0 #ffffff}
  .tabbar .tab-ico svg{width:14px;height:14px;fill:currentColor}
  .tabbar .tab-sep{width:1px;height:24px;background:#e5e7eb}
  .tab-content{display:none}
  /* Active tab fills viewport height */
  .tab-content.active{display:block; background:#ffffff !important; min-height:100vh;}
  .info-value{padding:12px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;color:#374151;font-weight:500;min-height:20px}
  .hrp-label{display:block;font-weight:600;color:#374151;margin-bottom:8px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif}
  @media (max-width:768px){#personal>div{grid-template-columns:1fr!important}.tabbar{overflow-x:auto;white-space:nowrap}.tab-btn{flex-shrink:0}}
  .document-item:hover{box-shadow:0 4px 12px rgba(0,0,0,0.15)!important;transform:translateY(-2px)}
  /* Remove card borders/radius so content blends with full white page */
  #personal, #payslips, #leaves, #attendance, #documents, #bank {
    border:0 !important;
    border-radius:0 !important;
    box-shadow:none !important;
    margin:0 !important;
    background:#ffffff !important;
  }
</style>
@endpush

@push('scripts')
<script>
  let accountNumberVisible=false;
  const fullAccountNumber='{{ $employee->bank_account_no ?? "" }}';
  function switchTab(tabName){document.querySelectorAll('.tab-content').forEach(t=>{t.classList.remove('active');t.style.display='none'});document.querySelectorAll('.tab-btn').forEach(b=>{b.classList.remove('active');b.style.color='#718096';b.style.borderBottomColor='transparent'});const tab=document.getElementById(tabName);if(tab){tab.classList.add('active');tab.style.display='block'};const btn=document.querySelector(`[onclick="switchTab('${tabName}')"]`);if(btn){btn.classList.add('active');btn.style.color='#0ea5e9';btn.style.borderBottomColor='#0ea5e9'}}
  function editBankDetails(){toastr.info('Bank details update form to be implemented');}
  async function copyText(text){
    const buttons = document.querySelectorAll('button');
    try{
      if(navigator.clipboard && window.isSecureContext){
        await navigator.clipboard.writeText(text);
      } else {
        const ta=document.createElement('textarea');
        ta.value=text;ta.style.position='fixed';ta.style.left='-9999px';document.body.appendChild(ta);ta.select();document.execCommand('copy');document.body.removeChild(ta);
      }
      const btn = Array.from(buttons).find(b=>b.textContent && b.textContent.trim().startsWith('Copy IFSC'));
      if(btn){ const prev=btn.innerHTML; btn.innerHTML='Copied'; setTimeout(()=>{btn.innerHTML=prev;},1200); }
    }catch(e){ console.error('Copy failed',e); }
  }
  function toggleAccountNumber(){
    const el=document.getElementById('accountNumber');
    const btn=document.getElementById('toggleAccBtn');
    if(!el||!fullAccountNumber)return;
    accountNumberVisible=!accountNumberVisible;
    el.textContent=accountNumberVisible?fullAccountNumber:'*'.repeat(fullAccountNumber.length-4)+fullAccountNumber.slice(-4);
    if(btn){ btn.textContent = accountNumberVisible ? 'Hide' : 'Show'; }
  }
  function viewDocument(url, name) {
    const overlay = document.createElement('div');
    overlay.style.cssText = 'position:fixed;inset:0;background:rgba(2,6,23,0.75);display:flex;align-items:center;justify-content:center;z-index:1000;padding:24px;';

    const isImage = /(jpg|jpeg|png|gif|webp|bmp)$/i.test(url);

    const close = () => {
      document.body.style.overflow = '';
      overlay.remove();
      document.removeEventListener('keydown', onKey);
    };
    const onKey = (e) => { if (e.key === 'Escape') close(); };

    if (isImage) {
      const probe = new Image();
      probe.onload = () => {
        const maxW = Math.max(200, window.innerWidth - 80);
        const maxH = Math.max(200, window.innerHeight - 80);
        const scale = Math.min(1, maxW / probe.naturalWidth, maxH / probe.naturalHeight);
        const dispW = Math.round(probe.naturalWidth * scale);
        const dispH = Math.round(probe.naturalHeight * scale);

        const wrap = document.createElement('div');
        wrap.style.cssText = 'position:relative;border-radius:12px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,0.3);background:#ffffff;display:inline-block;';

        const img = document.createElement('img');
        img.src = url;
        img.alt = name;
        img.style.cssText = `width:${dispW}px;height:${dispH}px;display:block;object-fit:contain;background:#ffffff;`;

        const btn = document.createElement('button');
        btn.innerHTML = '&times;';
        btn.setAttribute('aria-label','Close');
        btn.style.cssText = 'position:absolute;top:8px;right:8px;width:32px;height:32px;border:none;border-radius:9999px;background:rgba(0,0,0,0.5);color:#fff;font-size:18px;cursor:pointer;display:flex;align-items:center;justify-content:center;line-height:1;';
        btn.addEventListener('click', close);

        wrap.appendChild(img);
        wrap.appendChild(btn);
        overlay.appendChild(wrap);
        document.body.appendChild(overlay);

        overlay.addEventListener('click', (e) => { if (e.target === overlay) close(); });
        document.addEventListener('keydown', onKey);
        document.body.style.overflow = 'hidden';
      };
      probe.src = url;
    } else {
      // Non-image: keep framed viewer
      const modal = document.createElement('div');
      modal.style.cssText = 'background:#ffffff;border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,0.25);max-width:900px;width:90vw;max-height:85vh;display:flex;flex-direction:column;overflow:hidden;';

      const header = document.createElement('div');
      header.style.cssText = 'display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid #e5e7eb;background:#f8fafc;';
      const title = document.createElement('h3');
      title.textContent = name;
      title.style.cssText = 'margin:0;font-size:15px;font-weight:800;color:#0f172a;';
      const closeBtn = document.createElement('button');
      closeBtn.innerHTML = '&times;';
      closeBtn.setAttribute('aria-label','Close');
      closeBtn.style.cssText = 'background:none;border:none;font-size:22px;color:#6b7280;cursor:pointer;line-height:1;padding:4px;';
      header.appendChild(title);
      header.appendChild(closeBtn);

      const body = document.createElement('div');
      body.style.cssText = 'padding:0;overflow:hidden;display:flex;align-items:stretch;justify-content:center;background:#ffffff;';
      const frame = document.createElement('iframe');
      frame.src = url;
      frame.style.cssText = 'width:90vw;height:70vh;border:none;background:#f8fafc;';
      body.appendChild(frame);

      modal.appendChild(header);
      modal.appendChild(body);
      overlay.appendChild(modal);
      document.body.appendChild(overlay);

      const closePdf = () => close();
      closeBtn.addEventListener('click', closePdf);
      overlay.addEventListener('click', (e) => { if (e.target === overlay) closePdf(); });
      document.addEventListener('keydown', onKey);
      document.body.style.overflow = 'hidden';
    }
  }
</script>
@endpush

