<div style="background:white;border-radius:20px;box-shadow:0 2px 8px rgba(0,0,0,0.08);border:1px solid #e5e7eb;padding:30px;margin:12px 0 24px">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:32px;padding-bottom:20px;border-bottom:2px solid #f3f4f6;">
    <div style="display:flex;align-items:center;gap:12px;">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="#3b82f6">
        <path d="M11.5,1L2,6V8H21V6M16,10V17H19V19H5V17H8V10H10V17H14V10"/>
      </svg>
      <div>
        <h2 style="font-size:24px;font-weight:700;color:#1e293b;margin:0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">
          Bank Account Details
        </h2>
        <p style="font-size:14px;color:#64748b;margin:0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">
          Your bank account information for salary payments
        </p>
      </div>
    </div>
    @if($employee)
      <button type="button" id="editBankBtn" onclick="toggleBankEdit()" 
              style="display:flex;align-items:center;gap:8px;background:#3b82f6;color:white;border:none;padding:10px 20px;border-radius:8px;font-weight:600;font-size:14px;cursor:pointer;transition:all 0.2s;"
              onmouseover="this.style.background='#2563eb';this.style.transform='translateY(-2px)'"
              onmouseout="this.style.background='#3b82f6';this.style.transform='translateY(0)'">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
          <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z"/>
        </svg>
        Edit Details
      </button>
    @endif
  </div>

  @if($employee)
  
  <!-- View Mode (Default) -->
  <div id="bankViewMode">
    <!-- Current Bank Information Display -->
    <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-bottom:32px;">
      <div style="background:linear-gradient(135deg,#f0f9ff 0%,#e0f2fe 100%);padding:24px;border-radius:12px;border:1px solid #bae6fd;">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
          <div style="width:40px;height:40px;background:#3b82f6;border-radius:10px;display:flex;align-items:center;justify-content:center;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
              <path d="M11.5,1L2,6V8H21V6M16,10V17H19V19H5V17H8V10H10V17H14V10"/>
            </svg>
          </div>
          <div>
            <div style="font-size:12px;color:#0369a1;font-weight:600;margin-bottom:2px;">BANK NAME</div>
            <div style="font-size:18px;color:#0c4a6e;font-weight:700;">{{ $employee->bank_name ?? 'Not Provided' }}</div>
          </div>
        </div>
      </div>

      <div style="background:linear-gradient(135deg,#f0fdf4 0%,#dcfce7 100%);padding:24px;border-radius:12px;border:1px solid #bbf7d0;">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
          <div style="width:40px;height:40px;background:#10b981;border-radius:10px;display:flex;align-items:center;justify-content:center;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
              <path d="M20,8H4V6H20M20,18H4V12H20M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"/>
            </svg>
          </div>
          <div>
            <div style="font-size:12px;color:#047857;font-weight:600;margin-bottom:2px;">ACCOUNT NUMBER</div>
            <div style="font-size:18px;color:#065f46;font-weight:700;font-family:monospace;">
              @if($employee->bank_account_no)
                {{ substr($employee->bank_account_no, 0, 4) }}••••{{ substr($employee->bank_account_no, -4) }}
              @else
                Not Provided
              @endif
            </div>
          </div>
        </div>
      </div>

      <div style="background:linear-gradient(135deg,#fef3c7 0%,#fde68a 100%);padding:24px;border-radius:12px;border:1px solid #fcd34d;">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
          <div style="width:40px;height:40px;background:#f59e0b;border-radius:10px;display:flex;align-items:center;justify-content:center;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
              <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M11,17V16H9V14H13V13H10A1,1 0 0,1 9,12V9A1,1 0 0,1 10,8H11V7H13V8H15V10H11V11H14A1,1 0 0,1 15,12V15A1,1 0 0,1 14,16H13V17H11Z"/>
            </svg>
          </div>
          <div>
            <div style="font-size:12px;color:#b45309;font-weight:600;margin-bottom:2px;">IFSC CODE</div>
            <div style="font-size:18px;color:#92400e;font-weight:700;font-family:monospace;">{{ $employee->bank_ifsc ?? 'Not Provided' }}</div>
          </div>
        </div>
      </div>

      <div style="background:linear-gradient(135deg,#fae8ff 0%,#f3e8ff 100%);padding:24px;border-radius:12px;border:1px solid #e9d5ff;">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
          <div style="width:40px;height:40px;background:#a855f7;border-radius:10px;display:flex;align-items:center;justify-content:center;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
              <path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z"/>
            </svg>
          </div>
          <div>
            <div style="font-size:12px;color:#7e22ce;font-weight:600;margin-bottom:2px;">ACCOUNT HOLDER</div>
            <div style="font-size:18px;color:#6b21a8;font-weight:700;">{{ $employee->name ?? $user->name }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Cheque Information -->
    <div style="background:#f9fafb;padding:20px;border-radius:12px;border:1px solid #e5e7eb;margin-bottom:24px;">
      <div style="display:flex;align-items:center;justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:12px;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="#6b7280">
            <path d="M19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M19,19H5V5H19V19M17,17H7V15H17V17M17,13H7V11H17V13M17,9H7V7H17V9Z"/>
          </svg>
          <div>
            <div style="font-weight:600;color:#374151;font-size:14px;">Cancelled Cheque</div>
            <div style="font-size:12px;color:#6b7280;">Required for salary processing</div>
          </div>
        </div>
        @if($employee->cheque_photo)
          <a href="{{ storage_asset($employee->cheque_photo) }}" target="_blank" 
             style="display:flex;align-items:center;gap:8px;background:#3b82f6;color:white;padding:8px 16px;border-radius:6px;text-decoration:none;font-weight:600;font-size:13px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="white">
              <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/>
            </svg>
            View Cheque
          </a>
        @else
          <span style="color:#ef4444;font-weight:600;font-size:13px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:middle;">
              <path d="M13,13H11V7H13M13,17H11V15H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
            </svg>
            Not Uploaded
          </span>
        @endif
      </div>
    </div>

    <!-- Account Status -->
    <div style="text-align:center;padding:32px 20px;background:{{ $employee->bank_name && $employee->bank_account_no && $employee->bank_ifsc ? 'linear-gradient(135deg,#dcfce7 0%,#bbf7d0 100%)' : 'linear-gradient(135deg,#fee2e2 0%,#fecaca 100%)' }};border-radius:12px;border:1px solid {{ $employee->bank_name && $employee->bank_account_no && $employee->bank_ifsc ? '#86efac' : '#fca5a5' }};">
      @if($employee->bank_name && $employee->bank_account_no && $employee->bank_ifsc)
        <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;">
          <svg width="64" height="64" viewBox="0 0 24 24" fill="#16a34a" style="margin-bottom:16px;display:block;">
            <path d="M12,2C17.52,2 22,6.48 22,12C22,17.52 17.52,22 12,22C6.48,22 2,17.52 2,12C2,6.48 6.48,2 12,2M11,16.5L18,9.5L16.59,8.09L11,13.67L7.91,10.59L6.5,12L11,16.5Z"/>
          </svg>
          <div style="font-size:20px;font-weight:700;color:#15803d;margin-bottom:8px;">Account Verified</div>
          <div style="font-size:14px;color:#166534;">Your bank details are complete and verified</div>
        </div>
      @else
        <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;">
          <svg width="64" height="64" viewBox="0 0 24 24" fill="#dc2626" style="margin-bottom:16px;display:block;">
            <path d="M13,13H11V7H13M13,17H11V15H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
          </svg>
          <div style="font-size:20px;font-weight:700;color:#991b1b;margin-bottom:8px;">Incomplete Information</div>
          <div style="font-size:14px;color:#b91c1c;">Please update your bank details to receive salary payments</div>
        </div>
      @endif
    </div>
  </div>

  <!-- Edit Mode (Hidden by default) -->
  <div id="bankEditMode" style="display:none;">
    <form method="post" action="{{ route('profile.bank.update') }}">
      @csrf
      @method('patch')

      <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:24px;">
      <div>
        <label style="display:block;font-weight:600;color:#374151;margin-bottom:8px;font-size:14px;">
          Bank Name <span style="color:#ef4444;">*</span>
        </label>
        <input type="text" id="bank_name" name="bank_name" 
               value="{{ old('bank_name', $employee->bank_name ?? '') }}" required 
               placeholder="Enter bank name"
               style="width:100%;padding:12px 16px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;transition:all 0.2s;"
               onfocus="this.style.borderColor='#3b82f6';this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)'"
               onblur="this.style.borderColor='#d1d5db';this.style.boxShadow='none'" />
        @if($errors->get('bank_name'))
          <div style="color:#ef4444;font-size:13px;margin-top:6px;">{{ $errors->first('bank_name') }}</div>
        @endif
      </div>

      <div>
        <label style="display:block;font-weight:600;color:#374151;margin-bottom:8px;font-size:14px;">
          Account Number <span style="color:#ef4444;">*</span>
        </label>
        <input type="text" id="bank_account_no" name="bank_account_no" 
               value="{{ old('bank_account_no', $employee->bank_account_no ?? '') }}" required 
               placeholder="Enter account number" maxlength="30"
               style="width:100%;padding:12px 16px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;transition:all 0.2s;"
               onfocus="this.style.borderColor='#3b82f6';this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)'"
               onblur="this.style.borderColor='#d1d5db';this.style.boxShadow='none'" />
        @if($errors->get('bank_account_no'))
          <div style="color:#ef4444;font-size:13px;margin-top:6px;">{{ $errors->first('bank_account_no') }}</div>
        @endif
      </div>

      <div>
        <label style="display:block;font-weight:600;color:#374151;margin-bottom:8px;font-size:14px;">
          IFSC Code <span style="color:#ef4444;">*</span>
        </label>
        <input type="text" id="bank_ifsc" name="bank_ifsc" 
               value="{{ old('bank_ifsc', $employee->bank_ifsc ?? '') }}" required 
               placeholder="Enter IFSC code" maxlength="11" 
               style="width:100%;padding:12px 16px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;text-transform:uppercase;transition:all 0.2s;"
               pattern="[A-Z]{4}0[A-Z0-9]{6}"
               onfocus="this.style.borderColor='#3b82f6';this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)'"
               onblur="this.style.borderColor='#d1d5db';this.style.boxShadow='none'" />
        @if($errors->get('bank_ifsc'))
          <div style="color:#ef4444;font-size:13px;margin-top:6px;">{{ $errors->first('bank_ifsc') }}</div>
        @endif
        <small style="color:#6b7280;font-size:12px;margin-top:6px;display:block;">Format: ABCD0123456</small>
      </div>

      <div>
        <label style="display:block;font-weight:600;color:#374151;margin-bottom:8px;font-size:14px;">
          Account Holder Name
        </label>
        <input type="text" value="{{ $employee->name ?? $user->name }}" readonly 
               style="width:100%;padding:12px 16px;border:1px solid #e5e7eb;border-radius:8px;font-size:14px;background:#f9fafb;cursor:not-allowed;color:#6b7280;" />
        <small style="color:#6b7280;font-size:12px;margin-top:6px;display:block;">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:middle;">
            <path d="M13,9H11V7H13M13,17H11V11H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
          </svg>
          Matches your profile name
        </small>
      </div>
    </div>

    <div style="margin-top:24px;">
      <label style="display:block;font-weight:600;color:#374151;margin-bottom:12px;font-size:14px;">
        Cancelled Cheque
      </label>
      @if($employee->cheque_photo)
        <div style="display:inline-flex;align-items:center;gap:12px;padding:12px 20px;background:#f0f9ff;border:1px solid #bae6fd;border-radius:8px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="#0284c7">
            <path d="M9,11.75A1.25,1.25 0 0,0 7.75,13A1.25,1.25 0 0,0 9,14.25A1.25,1.25 0 0,0 10.25,13A1.25,1.25 0 0,0 9,11.75M15,11.75A1.25,1.25 0 0,0 13.75,13A1.25,1.25 0 0,0 15,14.25A1.25,1.25 0 0,0 16.25,13A1.25,1.25 0 0,0 15,11.75M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,20C7.59,20 4,16.41 4,12C4,11.71 4,11.42 4.05,11.14C6.41,10.09 8.28,8.16 9.26,5.77C11.07,8.33 14.05,10 17.42,10C18.2,10 18.95,9.91 19.67,9.74C19.88,10.45 20,11.21 20,12C20,16.41 16.41,20 12,20Z"/>
          </svg>
          <span style="color:#0c4a6e;font-weight:600;font-size:14px;">Cheque Uploaded</span>
          <a href="{{ storage_asset($employee->cheque_photo) }}" target="_blank" 
             style="color:#0284c7;font-weight:600;text-decoration:none;font-size:14px;margin-left:8px;">
            View →
          </a>
        </div>
      @else
        <div style="display:inline-flex;align-items:center;gap:12px;padding:12px 20px;background:#fef2f2;border:1px solid #fecaca;border-radius:8px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="#dc2626">
            <path d="M13,13H11V7H13M13,17H11V15H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
          </svg>
          <span style="color:#991b1b;font-weight:600;font-size:14px;">Cheque not uploaded - Contact HR</span>
        </div>
      @endif
    </div>

    <!-- Current Bank Details Summary -->
    <div style="margin-top:32px;padding:24px;background:linear-gradient(135deg,#f0f9ff 0%,#e0f2fe 100%);border:1px solid #bae6fd;border-radius:12px;">
      <h3 style="font-size:16px;font-weight:700;color:#0c4a6e;margin:0 0 20px 0;display:flex;align-items:center;gap:8px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
          <path d="M13,9H11V7H13M13,17H11V11H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
        </svg>
        Current Bank Information
      </h3>
      <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;">
        <div style="background:white;padding:16px;border-radius:8px;border:1px solid #e0f2fe;">
          <div style="font-size:12px;color:#64748b;font-weight:600;margin-bottom:6px;">BANK NAME</div>
          <div style="font-size:16px;color:#0f172a;font-weight:700;">{{ $employee->bank_name ?? '—' }}</div>
        </div>
        <div style="background:white;padding:16px;border-radius:8px;border:1px solid #e0f2fe;">
          <div style="font-size:12px;color:#64748b;font-weight:600;margin-bottom:6px;">ACCOUNT NUMBER</div>
          <div style="font-size:16px;color:#0f172a;font-weight:700;font-family:monospace;">
            @if($employee->bank_account_no)
              {{ substr($employee->bank_account_no, 0, 4) }}••••{{ substr($employee->bank_account_no, -4) }}
            @else
              —
            @endif
          </div>
        </div>
        <div style="background:white;padding:16px;border-radius:8px;border:1px solid #e0f2fe;">
          <div style="font-size:12px;color:#64748b;font-weight:600;margin-bottom:6px;">IFSC CODE</div>
          <div style="font-size:16px;color:#0f172a;font-weight:700;font-family:monospace;">{{ $employee->bank_ifsc ?? '—' }}</div>
        </div>
        <div style="background:white;padding:16px;border-radius:8px;border:1px solid #e0f2fe;">
          <div style="font-size:12px;color:#64748b;font-weight:600;margin-bottom:6px;">STATUS</div>
          <div style="font-size:14px;font-weight:700;">
            @if($employee->bank_name && $employee->bank_account_no && $employee->bank_ifsc)
              <span style="color:#10b981;display:flex;align-items:center;gap:6px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12,2C17.53,2 22,6.47 22,12C22,17.53 17.53,22 12,22C6.47,22 2,17.53 2,12C2,6.47 6.47,2 12,2M15.59,7L12,10.59L8.41,7L7,8.41L10.59,12L7,15.59L8.41,17L12,13.41L15.59,17L17,15.59L13.41,12L17,8.41L15.59,7Z"/>
                </svg>
                Active & Verified
              </span>
            @else
              <span style="color:#ef4444;display:flex;align-items:center;gap:6px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M13,13H11V7H13M13,17H11V15H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                </svg>
                Incomplete
              </span>
            @endif
          </div>
        </div>
      </div>
    </div>

      <div style="margin-top:32px;padding-top:24px;border-top:2px solid #f3f4f6;display:flex;align-items:center;gap:16px;">
        <button type="submit" 
                style="background:#10b981;color:white;padding:14px 32px;border:none;border-radius:10px;font-weight:700;font-size:15px;cursor:pointer;display:flex;align-items:center;gap:10px;transition:all 0.2s;box-shadow:0 4px 6px rgba(16,185,129,0.2);"
                onmouseover="this.style.background='#059669';this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 12px rgba(16,185,129,0.3)'"
                onmouseout="this.style.background='#10b981';this.style.transform='translateY(0)';this.style.boxShadow='0 4px 6px rgba(16,185,129,0.2)'">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="white">
            <path d="M15,9H5V5H15M12,19A3,3 0 0,1 9,16A3,3 0 0,1 12,13A3,3 0 0,1 15,16A3,3 0 0,1 12,19M17,3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V7L17,3Z"/>
          </svg>
          Save Changes
        </button>

        <button type="button" onclick="toggleBankEdit()" 
                style="background:#6b7280;color:white;padding:14px 32px;border:none;border-radius:10px;font-weight:700;font-size:15px;cursor:pointer;display:flex;align-items:center;gap:10px;transition:all 0.2s;"
                onmouseover="this.style.background='#4b5563'"
                onmouseout="this.style.background='#6b7280'">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="white">
            <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/>
          </svg>
          Cancel
        </button>

        @if (session('status') === 'bank-updated')
          <div style="display:flex;align-items:center;gap:8px;color:#10b981;font-weight:600;font-size:14px;background:#dcfce7;padding:10px 20px;border-radius:8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12,2C17.53,2 22,6.47 22,12C22,17.53 17.53,22 12,22C6.47,22 2,17.53 2,12C2,6.47 6.47,2 12,2M15.59,7L12,10.59L8.41,7L7,8.41L10.59,12L7,15.59L8.41,17L12,13.41L15.59,17L17,15.59L13.41,12L17,8.41L15.59,7Z"/>
            </svg>
            Bank details updated successfully!
          </div>
        @endif
      </div>
    </form>
  </div>

  <script>
    function toggleBankEdit() {
      const viewMode = document.getElementById('bankViewMode');
      const editMode = document.getElementById('bankEditMode');
      const editBtn = document.getElementById('editBankBtn');
      
      if (viewMode.style.display === 'none') {
        viewMode.style.display = 'block';
        editMode.style.display = 'none';
        editBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z"/></svg> Edit Details';
      } else {
        viewMode.style.display = 'none';
        editMode.style.display = 'block';
        editBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/></svg> View Details';
      }
    }
  </script>
  @else
  <div style="text-align:center;padding:60px 40px;background:#f9fafb;border:2px dashed #e5e7eb;border-radius:12px;">
    <svg width="64" height="64" viewBox="0 0 24 24" fill="#9ca3af" style="margin-bottom:20px;">
      <path d="M13,9H11V7H13M13,17H11V11H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
    </svg>
    <h3 style="font-size:18px;font-weight:700;color:#374151;margin:0 0 8px 0;">No Bank Details Available</h3>
    <p style="color:#6b7280;font-size:14px;margin:0;">
      Please contact HR department to add your bank account information.
    </p>
  </div>
  @endif
</div>
