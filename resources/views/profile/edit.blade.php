@extends('layouts.macos')
@section('page_title', 'Profile')

@section('content')
  <!-- Tabs Section -->
  <div>
    <!-- Employee Profile Header -->
    <div style="padding:20px 32px;background:white">
      <div style="display:flex;align-items:center;gap:16px;justify-content:space-between;flex-wrap:wrap;width:100%">
        <!-- Employee ID -->
        <div style="flex-shrink:0">
          <div style="font-size:10px;color:#64748b;font-weight:500;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;margin-bottom:2px">Employee ID</div>
          <div style="font-size:12px;color:#1e293b;font-weight:700;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">#Chitri_0024</div>
        </div>
        
        <!-- Divider -->
        <div style="width:1px;height:40px;background:#e5e7eb"></div>
        
        <!-- Profile Info -->
        <div style="display:flex;align-items:center;gap:8px">
          <div style="width:40px;height:40px;border-radius:50%;overflow:hidden;background:#fbbf24;flex-shrink:0">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=60&h=60&fit=crop&crop=face" style="width:100%;height:100%;object-fit:cover" alt="Dipesh Vasoya">
          </div>
          <div>
            <h2 style="font-size:20px;font-weight:700;color:#1e293b;margin:0 0 1px 0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">Dipesh Vasoya</h2>
            <p style="color:#64748b;margin:0;font-size:11px;font-weight:500;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">UI/UX Designer</p>
          </div>
        </div>
        
        <!-- Divider -->
        <div style="width:1px;height:40px;background:#e5e7eb"></div>
        
        <!-- Active Badge -->
        <div style="display:flex;align-items:center;gap:4px;background:#dcfce7;color:#16a34a;font-weight:600;font-size:10px;padding:3px 8px;border-radius:10px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;flex-shrink:0">
          <div style="width:5px;height:5px;background:#16a34a;border-radius:50%"></div>
          Active
        </div>
        
        <!-- Divider -->
        <div style="width:1px;height:40px;background:#e5e7eb"></div>
        
        <!-- Contact Info -->
        <div style="display:flex;flex-direction:column;gap:2px;flex-shrink:0">
          <div style="display:flex;align-items:center;gap:4px;color:#64748b;font-size:10px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
              <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
            </svg>
            +917359442073
          </div>
          <div style="display:flex;align-items:center;gap:4px;color:#64748b;font-size:10px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
              <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
            </svg>
            dipeshvasoya22@gmail.com
          </div>
        </div>
        
        <!-- Divider -->
        <div style="width:1px;height:40px;background:#e5e7eb"></div>
        
        <!-- Company Join Date -->
        <div style="flex-shrink:0">
          <div style="font-size:10px;color:#64748b;font-weight:500;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;margin-bottom:2px">Company Join Date :</div>
          <div style="font-size:12px;color:#1e293b;font-weight:600;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">23 / 12 / 2024</div>
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
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop&crop=face"
              style="width:100%;height:100%;object-fit:cover" alt="Dipesh Vasoya">
          </div>
        </div>

        <!-- Right Column - Form -->
        <div style="flex:1">
          <div class="hrp-compact">
            <form style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
              <!-- Full Name -->
              <div>
                <label class="hrp-label">Full Name</label>
                <input type="text" value="Vasoya Dipeshkumar Narendrabhai" class="hrp-input Rectangle-29">
              </div>

              <!-- Gender -->
              <div>
                <label class="hrp-label">Gender :</label>
                <div style="display:flex;gap:20px;align-items:center;margin-top:8px">
                  <label
                    style="display:flex;align-items:center;gap:8px;cursor:pointer;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
                    <input type="radio" name="gender" value="male" checked style="margin:0;accent-color:#374151">
                    <span style="color:#374151;font-weight:500">Male</span>
                    <div style="width:8px;height:8px;background:#374151;border-radius:50%;margin-left:4px"></div>
                  </label>
                  <label
                    style="display:flex;align-items:center;gap:8px;cursor:pointer;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
                    <input type="radio" name="gender" value="female" style="margin:0;accent-color:#9ca3af">
                    <span style="color:#9ca3af;font-weight:500">Female</span>
                  </label>
                </div>
              </div>

              <!-- Date of Birth -->
              <div>
                <label class="hrp-label">Date of Birth :</label>
                <input type="text" value="04/04/2000" class="hrp-input Rectangle-29">
              </div>

              <!-- Mobile No -->
              <div>
                <label class="hrp-label">Mobile No:</label>
                <input type="text" value="+91 9729724869" class="hrp-input Rectangle-29">
              </div>

              <!-- Marital Status -->
              <div>
                <label class="hrp-label">Marital Status :</label>
                <select class="Rectangle-29 Rectangle-29-select">
                  <option>Married</option>
                  <option>Single</option>
                </select>
              </div>

              <!-- Email ID -->
              <div>
                <label class="hrp-label">Email ID :</label>
                <input type="email" value="dipeshvasoya22@gmail.com" class="hrp-input Rectangle-29">
              </div>

              <!-- Address -->
              <div style="grid-column:1/-1">
                <label class="hrp-label">Address:</label>
                <textarea placeholder="Enter Your Address" class="Rectangle-29-textarea"></textarea>
              </div>

              <!-- Aadhaar Card Number -->
              <div>
                <label class="hrp-label">Aadhaar Card Number :</label>
                <input type="text" placeholder="XXXX XXXX XXXX" class="hrp-input Rectangle-29">
              </div>

              <!-- PAN Number -->
              <div>
                <label class="hrp-label">PAN Number :</label>
                <input type="text" placeholder="XXXXX0000X" class="hrp-input Rectangle-29">
              </div>

              <!-- Highest Qualification -->
              <div>
                <label class="hrp-label">Highest Qualification</label>
                <input type="text" placeholder="Enter your Highest Qualification" class="hrp-input Rectangle-29">
              </div>

              <!-- Year of Passing -->
              <div>
                <label class="hrp-label">Year of Passing</label>
                <input type="text" placeholder="Passing Year" class="hrp-input Rectangle-29">
              </div>

              <!-- Previous Company Name -->
              <div>
                <label class="hrp-label">Previous Company Name :</label>
                <input type="text" placeholder="Enter your Last Company Name" class="hrp-input Rectangle-29">
              </div>

              <!-- Previous Designation -->
              <div>
                <label class="hrp-label">Previous Designation :</label>
                <input type="text" placeholder="Enter your Last Designation" class="hrp-input Rectangle-29">
              </div>

              <!-- Duration -->
              <div>
                <label class="hrp-label">Duration :</label>
                <input type="text" placeholder="Add Time Duration" class="hrp-input Rectangle-29">
              </div>

              <!-- Reason for Leaving -->
              <div>
                <label class="hrp-label">Reason for Leaving</label>
                <textarea placeholder="Enter Reason for Leaving" class="Rectangle-29-textarea"></textarea>
              </div>

              <!-- Save Button -->
              <div style="grid-column:1/-1;margin-top:20px">
                <button type="submit"
                  style="background:#10b981;color:white;padding:12px 24px;border:none;border-radius:8px;font-weight:600;cursor:pointer">
                  SAVE
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Payroll Tab Content -->
    <div id="payroll" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
      <div class="striped-surface" style="overflow-x:hidden;padding:0">
        <table class="flat-table" style="width:100%;border-collapse:collapse;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
          <thead>
            <tr style="background:#f8f9fa;border-bottom:1px solid #e5e7eb">
              <th style="padding:8px 10px;text-align:center;font-weight:900;color:#000000;font-size:20px">Action</th>
              <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:20px;border-right:1px solid #e5e7eb">Serial No</th>
              <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:20px;border-right:1px solid #e5e7eb">Unique No</th>
              <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:20px;border-right:1px solid #e5e7eb">Salary Month</th>
              <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:20px;border-right:1px solid #e5e7eb">Format Type</th>
              <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:20px;border-right:1px solid #e5e7eb">Payment Date</th>
              <th style="padding:16px 12px;text-align:left;font-weight:600;color:#374151;font-size:20px">Payment Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr style="border-bottom:1px solid #f3f4f6">
              <td style="padding:8px 10px;text-align:center">
                <img src="{{ asset('action_icon/print.svg') }}" alt="Print" style="width:50px;height:20px;display:inline-block" />
              </td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">1</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">CMS/LEAD/0022</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">OCT - 2025</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">Salary</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">30-10-2025</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px">₹ 11,000</td>
            </tr>
            <tr style="border-bottom:1px solid #f3f4f6">
               <td style="padding:8px 10px;text-align:center">
                <img src="{{ asset('action_icon/print.svg') }}" alt="Print" style="width:50px;height:20px;display:inline-block" />
              </td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">2</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">CMS/LEAD/0023</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">Salary (OCT-25)</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">Salary</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">14-10-2025</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px">₹ 15,000</td>
            </tr>
            <tr style="border-bottom:1px solid #f3f4f6">
              <td style="padding:8px 10px;text-align:center">
                <img src="{{ asset('action_icon/print.svg') }}" alt="Print" style="width:50px;height:20px;display:inline-block" />
              </td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">3</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">CMS/LEAD/0024</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">Other</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">Salary</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">29-09-2025</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px">₹ 20,000</td>
            </tr>
            <tr style="border-bottom:1px solid #f3f4f6">
              <td style="padding:8px 10px;text-align:center">
                <img src="{{ asset('action_icon/print.svg') }}" alt="Print" style="width:50px;height:20px;display:inline-block" />
              </td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">4</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">CMS/LEAD/0025</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">Salary (JUN-25)</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">Salary</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px;border-right:1px solid #e5e7eb">28-08-2025</td>
              <td style="padding:16px 12px;color:#374151;font-weight:600;font-size:20px">₹ 12,000</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Attendance Tab Content -->
    <div id="attendance" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
      <!-- Stats Cards -->
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin:0 32px 30px">
        <div style="background:linear-gradient(135deg,#dbeafe 0%,#bfdbfe 100%);padding:20px;border-radius:12px;text-align:center">
          <div style="width:40px;height:40px;background:#3b82f6;border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
              <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
            </svg>
          </div>
          <div style="font-size:28px;font-weight:700;color:#1e40af;margin-bottom:4px">041</div>
          <div style="font-size:20px;color:#1e40af;font-weight:500">Present Day</div>
        </div>
        <div style="background:linear-gradient(135deg,#dcfce7 0%,#bbf7d0 100%);padding:20px;border-radius:12px;text-align:center">
          <div style="width:40px;height:40px;background:#10b981;border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
              <path d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z"/>
            </svg>
          </div>
          <div style="font-size:28px;font-weight:700;color:#059669;margin-bottom:4px">312.1</div>
          <div style="font-size:20px;color:#059669;font-weight:500">Working Hours</div>
        </div>
        <div style="background:linear-gradient(135deg,#fed7aa 0%,#fdba74 100%);padding:20px;border-radius:12px;text-align:center">
          <div style="width:40px;height:40px;background:#f97316;border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
              <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M12,6A6,6 0 0,1 18,12A6,6 0 0,1 12,18A6,6 0 0,1 6,12A6,6 0 0,1 12,6M12,8A4,4 0 0,0 8,12A4,4 0 0,0 12,16A4,4 0 0,0 16,12A4,4 0 0,0 12,8Z"/>
            </svg>
          </div>
          <div style="font-size:28px;font-weight:700;color:#ea580c;margin-bottom:4px">037</div>
          <div style="font-size:20px;color:#ea580c;font-weight:500">Late Entries</div>
        </div>
        <div style="background:linear-gradient(135deg,#fecaca 0%,#fca5a5 100%);padding:20px;border-radius:12px;text-align:center">
          <div style="width:40px;height:40px;background:#ef4444;border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
              <path d="M12,2C17.53,2 22,6.47 22,12C22,17.53 17.53,22 12,22C6.47,22 2,17.53 2,12C2,6.47 6.47,2 12,2M15.59,7L12,10.59L8.41,7L7,8.41L10.59,12L7,15.59L8.41,17L12,13.41L15.59,17L17,15.59L13.41,12L17,8.41L15.59,7Z"/>
            </svg>
          </div>
          <div style="font-size:28px;font-weight:700;color:#dc2626;margin-bottom:4px">001</div>
          <div style="font-size:20px;color:#dc2626;font-weight:500">Early Exits</div>
        </div>
      </div>
      
      <!-- Attendance Table -->
      <div class="striped-surface" style="overflow-x:hidden;padding:0 32px 8px">
        <table class="flat-table" style="width:100%;border-collapse:collapse;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif">
          <thead>
            <tr style="background:#f8f9fa;border-bottom:1px solid #e5e7eb">
              <th style="padding:16px 12px;text-align:center;font-weight:600;color:#374151;font-size:20px;border-right:1px solid #e5e7eb">Day</th>
              <th style="padding:16px 12px;text-align:center;font-weight:600;color:#374151;font-size:20px;border-right:1px solid #e5e7eb">Date</th>
              <th style="padding:16px 12px;text-align:center;font-weight:600;color:#374151;font-size:20px;border-right:1px solid #e5e7eb">Check IN & OUT</th>
              <th style="padding:16px 12px;text-align:center;font-weight:600;color:#374151;font-size:20px;border-right:1px solid #e5e7eb">Overtime</th>
              <th style="padding:16px 12px;text-align:center;font-weight:600;color:#374151;font-size:20px">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr style="border-bottom:1px solid #f3f4f6">
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">Monday</td>
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">27 Oct, 2025</td>
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">
                <span style="color:#f97316;font-weight:600">09:36 AM</span> - <span style="color:#ef4444;font-weight:600">06:25 PM</span>
              </td>
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">0h 19m</td>
              <td style="padding:16px 12px;text-align:center">
                <span style="background:#dcfce7;color:#059669;padding:4px 12px;border-radius:12px;font-size:12px;font-weight:600">Present</span>
              </td>
            </tr>
            <tr style="border-bottom:1px solid #f3f4f6">
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">Tuesday</td>
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">28 Oct, 2025</td>
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">
                <span style="color:#f97316;font-weight:600">09:40 AM</span> - <span style="color:#ef4444;font-weight:600">06:15 PM</span>
              </td>
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">--</td>
              <td style="padding:16px 12px;text-align:center">
                <span style="background:#fed7aa;color:#ea580c;padding:4px 12px;border-radius:12px;font-size:12px;font-weight:600">Half Day</span>
              </td>
            </tr>
            <tr style="border-bottom:1px solid #f3f4f6">
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">Wednesday</td>
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">29 Oct, 2025</td>
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">
                <span style="color:#f97316;font-weight:600">09:55 AM</span> - <span style="color:#10b981;font-weight:600">06:40 PM</span>
              </td>
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">0h 15m</td>
              <td style="padding:16px 12px;text-align:center">
                <span style="background:#dcfce7;color:#059669;padding:4px 12px;border-radius:12px;font-size:12px;font-weight:600">Present</span>
              </td>
            </tr>
            <tr style="border-bottom:1px solid #f3f4f6">
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">Thursday</td>
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">30 Oct, 2025</td>
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">
                <span style="color:#10b981;font-weight:600">09:17 AM</span> - <span style="color:#10b981;font-weight:600">07:20 PM</span>
              </td>
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">1h 33m</td>
              <td style="padding:16px 12px;text-align:center">
                <span style="background:#dcfce7;color:#059669;padding:4px 12px;border-radius:12px;font-size:12px;font-weight:600">Present</span>
              </td>
            </tr>
            <tr style="border-bottom:1px solid #f3f4f6">
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">Friday</td>
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">31 Oct, 2025</td>
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">
                <span style="color:#f97316;font-weight:600">09:36 AM</span> - <span style="color:#ef4444;font-weight:600">06:25 PM</span>
              </td>
              <td style="padding:16px 12px;text-align:center;color:#374151;font-weight:500;font-size:20px;border-right:1px solid #e5e7eb">0h 19m</td>
              <td style="padding:16px 12px;text-align:center">
                <span style="background:#dcfce7;color:#059669;padding:4px 12px;border-radius:12px;font-size:12px;font-weight:600">Present</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div id="documents" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
      <!-- Search and Add Section -->
      <div style="display:flex;justify-content:space-between;align-items:center;padding:0 32px;margin-bottom:30px">
        <div style="position:relative;flex:1;max-width:400px">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="#9ca3af" style="position:absolute;left:16px;top:50%;transform:translateY(-50%)">
            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
          </svg>
          <input type="text" placeholder="Type to search..." style="width:100%;padding:12px 16px 12px 48px;border:1px solid #e5e7eb;border-radius:8px;font-size:20px;background:#f9fafb;color:#374151;outline:none">
        </div>
        <button style="background:#1f2937;color:white;padding:12px 20px;border:none;border-radius:8px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:8px;margin-left:16px">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
          </svg>
          Add
        </button>
      </div>
      
      <!-- Documents Grid -->
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px;padding:0 32px 24px">
        <!-- Document Card 1 -->
        <div style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;background:white;box-shadow:0 1px 3px rgba(0,0,0,0.1)">
          <div style="height:180px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;position:relative">
            <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=250&h=150&fit=crop" style="width:100%;height:100%;object-fit:cover" alt="Aadhaar Card">
          </div>
          <div style="padding:16px">
            <h3 style="font-size:16px;font-weight:600;color:#374151;margin:0 0 4px 0">Aadhaarcard_Front</h3>
            <p style="font-size:12px;color:#6b7280;margin:0 0 16px 0">PDF • 1.32 MB</p>
            <div style="display:flex;gap:8px">
              <button style="flex:1;background:#374151;color:white;padding:8px 16px;border:none;border-radius:6px;font-size:12px;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="white">
                  <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                </svg>
                Download
              </button>
              <button style="width:36px;height:36px;background:#6b7280;border:none;border-radius:6px;cursor:pointer;display:flex;align-items:center;justify-content:center">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="white">
                  <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
              </button>
            </div>
          </div>
        </div>
        
        <!-- Document Card 2 -->
        <div style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;background:white;box-shadow:0 1px 3px rgba(0,0,0,0.1)">
          <div style="height:180px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;position:relative">
            <img src="https://images.unsplash.com/photo-1586953208448-b95a79798f07?w=250&h=150&fit=crop" style="width:100%;height:100%;object-fit:cover" alt="Aadhaar Back">
          </div>
          <div style="padding:16px">
            <h3 style="font-size:16px;font-weight:600;color:#374151;margin:0 0 4px 0">Aadhaarcard_Back</h3>
            <p style="font-size:12px;color:#6b7280;margin:0 0 16px 0">PDF • 4.7 MB</p>
            <div style="display:flex;gap:8px">
              <button style="flex:1;background:#374151;color:white;padding:8px 16px;border:none;border-radius:6px;font-size:12px;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="white">
                  <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                </svg>
                Download
              </button>
              <button style="width:36px;height:36px;background:#6b7280;border:none;border-radius:6px;cursor:pointer;display:flex;align-items:center;justify-content:center">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="white">
                  <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
              </button>
            </div>
          </div>
        </div>
        
        <!-- Document Card 3 -->
        <div style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;background:white;box-shadow:0 1px 3px rgba(0,0,0,0.1)">
          <div style="height:180px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;position:relative">
            <img src="https://images.unsplash.com/photo-1633265486064-086b219458ec?w=250&h=150&fit=crop" style="width:100%;height:100%;object-fit:cover" alt="PAN Card">
          </div>
          <div style="padding:16px">
            <h3 style="font-size:16px;font-weight:600;color:#374151;margin:0 0 4px 0">Pancard_Front</h3>
            <p style="font-size:12px;color:#6b7280;margin:0 0 16px 0">JPG • 9.8 KB</p>
            <div style="display:flex;gap:8px">
              <button style="flex:1;background:#374151;color:white;padding:8px 16px;border:none;border-radius:6px;font-size:12px;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="white">
                  <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                </svg>
                Download
              </button>
              <button style="width:36px;height:36px;background:#1f2937;border:none;border-radius:6px;cursor:pointer;display:flex;align-items:center;justify-content:center">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="white">
                  <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="bank" class="tab-content" style="display:none;background:white;border-radius:0;box-shadow:none;border:0;padding:0;margin:0">
      <!-- Bank Details Card -->
      <div style="max-width:500px;margin:0 32px 24px;background:white;border:1px solid #e5e7eb;border-radius:16px;padding:40px;box-shadow:0 4px 6px rgba(0,0,0,0.05)">
        <!-- Bank Name -->
        <div style="margin-bottom:24px">
          <label style="display:block;font-weight:600;color:#374151;margin-bottom:8px;font-size:16px">Bank Name :</label>
          <input type="text" value="ICICI Bank" readonly style="width:100%;padding:14px 18px;border:1px solid #d1d5db;border-radius:8px;font-size:20px;background:#f9fafb;color:#374151;outline:none">
        </div>
        
        <!-- IFSC Code -->
        <div style="margin-bottom:24px">
          <label style="display:block;font-weight:600;color:#374151;margin-bottom:8px;font-size:16px">IFSC Code :</label>
          <input type="text" value="IBKL0045458" readonly style="width:100%;padding:14px 18px;border:1px solid #d1d5db;border-radius:8px;font-size:20px;background:#f9fafb;color:#374151;outline:none">
        </div>
        
        <!-- Account Number -->
        <div style="margin-bottom:32px">
          <label style="display:block;font-weight:600;color:#374151;margin-bottom:8px;font-size:16px">Account Number :</label>
          <input type="text" value="465776547675" readonly style="width:100%;padding:14px 18px;border:1px solid #d1d5db;border-radius:8px;font-size:20px;background:#f9fafb;color:#374151;outline:none">
        </div>
        
        <!-- Copy Button -->
        <button style="background:#10b981;color:white;padding:12px 24px;border:none;border-radius:8px;font-weight:600;cursor:pointer;font-size:20px;width:100%" onclick="copyBankDetails()">
          Copy All Details
        </button>
      </div>
    </div>
  </div>

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

      /* Flat table to match screenshot (joined to tab bar) */
      .flat-table{ width:100%; border-collapse:collapse; table-layout:auto; font-family: 'Visby','Visby CF','VisbyCF',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif }
      .flat-table thead th{
        background:#ffffff;
        color:#000000 !important;
        font-weight:900;
        font-size:22px;
        letter-spacing:.2px;
        text-align:center !important;
        padding:14px 16px !important;
        border:0 !important; border-right:0 !important;
        border-bottom:1px solid #e5e7eb !important; /* header-only border */
        vertical-align:middle;
        position:relative;
      }
      .flat-table thead tr{ border:0 !important; background:#ffffff !important }
      /* thin vertical pipes between header titles */
      .flat-table thead th+th::before{
        content:"";
        position:absolute; left:0; top:50%; transform:translateY(-50%);
        width:1px; height:18px; background:#d1d5db;
      }
      .flat-table tbody td{
        color:#000000 !important;
        font-weight:500;
        font-size:20px;
        padding:8px 10px !important;
        border:0 !important;
        text-align:center !important;
        vertical-align:middle;
      }
      .flat-table tbody tr{ border:0 !important }
      .flat-table tbody tr:nth-child(odd){ background:#ffffff }
      .flat-table tbody tr:nth-child(even){ background:#F5F5F5 }
      .flat-table thead th, .flat-table tbody td{ height:56px; line-height:1.3 }

      /* Widen text-heavy columns but allow wrapping to avoid scroll */
      .flat-table thead th:nth-child(3), .flat-table tbody td:nth-child(3){ min-width: 140px; white-space: normal; word-break: break-word }
      .flat-table thead th:nth-child(4), .flat-table tbody td:nth-child(4){ min-width: 140px; white-space: normal; word-break: break-word }
      .flat-table thead th:nth-child(7), .flat-table tbody td:nth-child(7){ min-width: 120px; white-space: normal; word-break: break-word }
    

      /* Force center align for all headers and cells */
      .flat-table thead th, .flat-table tbody td{ text-align:center !important }

      /* Extra-tight spacing between Serial No (2) and Unique No (3) */
      .flat-table thead th:nth-child(2), .flat-table tbody td:nth-child(2),
      .flat-table thead th:nth-child(3), .flat-table tbody td:nth-child(3){
        padding-left: 6px !important;
        padding-right: 6px !important;
      }

      /* Always show table effect even without rows */
      .striped-surface{
        background-image: repeating-linear-gradient(
          to bottom,
          #ffffff 0, #ffffff 52px,
          #F5F5F5 52px, #F5F5F5 104px
        );
        background-color:#ffffff;
        min-height: auto;
      }

     

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
          alert('Bank details copied to clipboard!');
        });
      }
    </script>
@endsection