@extends('layouts.macos')

@section('page_title','Dashboard')

@push('styles')
<style>
  .dataTables_filter, .dataTables_length { display: none !important; }
  .top-right{ display:flex; align-items:center; gap:12px; justify-content:flex-end; }
  .notify-bell{ position:relative; display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:9999px; background:#fff; border:1px solid #ececec; transition: all 0.2s ease; }
  .notify-bell:hover { background: #f8fafc; transform: scale(1.05); }
  .notify-bell .badge-dot{ position:absolute; top:-3px; right:-3px; min-width:18px; height:18px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color:#fff; border-radius:9999px; font-size:10px; font-weight:700; display:flex; align-items:center; justify-content:center; padding: 0 4px; box-shadow: 0 2px 6px rgba(239,68,68,0.4); animation: pulse 2s infinite; }
  @keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
  }
  .notify-dropdown { animation: dropdownSlide 0.2s ease; }
  @keyframes dropdownSlide {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .notify-item:hover { background: #f8fafc !important; }
  #readAllBtn:hover { background: rgba(255,255,255,0.25) !important; }
  .search-wrap{ max-width:420px; border: none !important; }
  /* Dashboard: avoid double search icon and remove black border */
  .top-right #globalSearch{ background-image:none !important; padding-left:0 !important; border: none !important; outline: none !important; }
  .search-input { border: none !important; outline: none !important; box-shadow: none !important; }
  .search-wrap:focus-within { border: none !important; box-shadow: none !important; }
  
  /* Enhanced KPI Cards */
  .dash-kpi {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
    position: relative;
    overflow: hidden;
  }
  .dash-kpi::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    border-radius: 16px 16px 0 0;
  }
  .dash-kpi:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
  }
  .kpi-emp::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
  .kpi-proj::before { background: linear-gradient(90deg, #10b981, #34d399); }
  .kpi-task::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
  .kpi-attn::before { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }
  .dash-kpi .value {
    font-size: 32px;
    font-weight: 800;
    color: #1e293b;
    line-height: 1;
  }
  .dash-kpi .kpi-title {
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    margin-top: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .dash-kpi .kpi-sub {
    font-size: 12px;
    font-weight: 500;
    margin-top: 12px;
    padding: 6px 12px;
    border-radius: 20px;
    display: inline-block;
  }
  .dash-kpi .kpi-sub.green { background: #d1fae5; color: #065f46; }
  .dash-kpi .kpi-sub.red { background: #fee2e2; color: #991b1b; }
  .dash-kpi .kpi-sub.blue { background: #dbeafe; color: #1e40af; }
  .dash-kpi .kpi-ico {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
  }
  .kpi-emp .kpi-ico { background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
  .kpi-proj .kpi-ico { background: linear-gradient(135deg, #d1fae5, #a7f3d0); }
  .kpi-task .kpi-ico { background: linear-gradient(135deg, #fef3c7, #fde68a); }
  .kpi-attn .kpi-ico { background: linear-gradient(135deg, #ede9fe, #ddd6fe); }
  
  /* Enhanced Table Styling */
  .card-table {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: 1px solid #e2e8f0;
  }
  .card-table .table-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    color: white;
    padding: 16px 20px;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 0.5px;
  }
  .hrp-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border-bottom: 2px solid #e2e8f0;
  }
  .hrp-table td {
    padding: 14px 16px;
    font-size: 13px;
    color: #475569;
    border-bottom: 1px solid #f1f5f9;
  }
  .hrp-table tr:hover td {
    background: #f8fafc;
  }
  .hrp-table .text-green { color: #059669; font-weight: 600; }
  .hrp-table .text-orange { color: #d97706; font-weight: 600; }
  .hrp-table .link-blue { color: #2563eb; font-weight: 500; text-decoration: none; }
  .hrp-table .link-blue:hover { text-decoration: underline; }
  
  /* Admin Notes - Perfect Chip Design */
  .chip { 
    display: inline-flex; 
    align-items: center; 
    gap: 6px; 
    padding: 6px 12px; 
    border-radius: 6px; 
    font-size: 13px; 
    font-weight: 500;
    transition: all 0.2s ease;
  }
  .chip-blue { 
    background: #dbeafe; 
    color: #1e40af; 
    border: 1px solid #bfdbfe;
  }
  .chip button {
    background: none;
    border: none;
    color: inherit;
    cursor: pointer;
    padding: 0;
    margin-left: 4px;
    font-size: 18px;
    line-height: 1;
    font-weight: 700;
    opacity: 0.7;
    transition: opacity 0.2s ease;
  }
  .chip button:hover {
    opacity: 1;
  }
  .notes-assign-section label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 8px;
  }
  .notes-add:hover {
    background: #1d4ed8 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(38, 123, 245, 0.4) !important;
  }
  .btn-add-employees-round {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .btn-add-employees-round:hover {
    background: #059669 !important;
    transform: scale(1.1) rotate(90deg);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.6) !important;
  }
  .btn-add-employees-round:active {
    transform: scale(0.95) rotate(90deg);
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4) !important;
  }
  #adminChipsContainer {
    position: relative;
  }
  #adminChips {
    min-height: 40px;
    padding: 12px;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px dashed #cbd5e1;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
  }
  #btnSaveAdminNote:hover {
    background: #0f9d4f !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(20, 174, 92, 0.3);
  }
  
  /* Notes Pagination */
  .pager-num {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 12px 0;
    margin-top: 12px;
  }
  .pager-num .prev,
  .pager-num .next {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: #f1f5f9;
    color: #475569;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s ease;
  }
  .pager-num .prev:hover,
  .pager-num .next:hover {
    background: #267bf5;
    color: white;
  }
  .pager-num .pager-info {
    font-size: 13px;
    color: #64748b;
    font-weight: 500;
  }
  
  /* Note card delete button */
  .note-card .del {
    cursor: pointer;
    transition: transform 0.2s ease;
  }
  .note-card .del:hover {
    transform: scale(1.2);
  }
  
  /* Enhanced Notes Typography */
  .notes-title {
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 14px;
    letter-spacing: -0.3px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  }
  .notes-area {
    width: 100%;
    padding: 14px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    line-height: 1.6;
    color: #374151;
    background: #f8fafc;
    resize: vertical;
    transition: all 0.2s ease;
  }
  .notes-area:focus {
    outline: none;
    border-color: #3b82f6;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  }
  .notes-area::placeholder {
    color: #94a3b8;
    font-style: italic;
  }
  .notes-entry {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    margin-bottom: 16px;
  }
  .notes-send {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
  }
  .notes-send:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
  }
  .notes-send:active {
    transform: translateY(0);
  }
  .notes-grid {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }
  
  /* Employee Selection Modal */
  .employee-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
  }
  .modal-content {
    position: relative;
    background: white;
    border-radius: 16px;
    width: 90%;
    max-width: 800px;
    max-height: 85vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: modalSlideIn 0.3s ease-out;
  }
  @keyframes modalSlideIn {
    from {
      opacity: 0;
      transform: translateY(-20px) scale(0.95);
    }
    to {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }
  .modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid #e2e8f0;
  }
  .modal-close:hover {
    color: #ef4444 !important;
    background: #fee2e2 !important;
  }
  .modal-body {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
  }
  .employee-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 16px;
  }
  .employee-card {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 16px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    background: white;
  }
  .employee-card:hover {
    border-color: #267bf5;
    background: #f0f9ff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(38, 123, 245, 0.15);
  }
  .employee-card.selected {
    border-color: #267bf5;
    background: #dbeafe;
    box-shadow: 0 0 0 3px rgba(38, 123, 245, 0.1);
  }
  .employee-checkbox {
    position: absolute;
    top: 8px;
    right: 8px;
  }
  .employee-checkbox input[type="checkbox"] {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: #267bf5;
  }
  .employee-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    margin-bottom: 12px;
    border: 3px solid #e2e8f0;
    transition: border-color 0.2s ease;
  }
  .employee-card.selected .employee-avatar {
    border-color: #267bf5;
  }
  .employee-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .employee-name {
    font-size: 13px;
    font-weight: 600;
    color: #1e293b;
    text-align: center;
    line-height: 1.3;
  }
  .modal-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    border-radius: 0 0 16px 16px;
  }
  .selected-count {
    font-size: 14px;
    font-weight: 600;
    color: #475569;
  }
  .modal-actions {
    display: flex;
    gap: 12px;
  }
  .btn-cancel {
    padding: 10px 24px;
    background: white;
    color: #64748b;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
  }
  .btn-cancel:hover {
    background: #f1f5f9;
    border-color: #94a3b8;
  }
  .btn-confirm {
    padding: 10px 24px;
    background: #267bf5;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.2s ease;
  }
  .btn-confirm:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(38, 123, 245, 0.3);
  }
  .btn-confirm:disabled {
    background: #cbd5e1;
    cursor: not-allowed;
    transform: none;
  }
</style>
@endpush

@section('content')
  @php
    $stats = $stats ?? [];
    $empDelta = data_get($stats, 'delta_employees', '+0%');
    $empDeltaClass = (strpos($empDelta, '-') === 0) ? 'red' : 'green';
    $projDelta = data_get($stats, 'delta_projects', '+0%');
    $projDeltaClass = (strpos($projDelta, '-') === 0) ? 'red' : 'green';
    $urgentCount = data_get($stats, 'urgent_priority', 0);
  @endphp
  <div class="hrp-grid" style="padding:14px">
    <div class="hrp-col-12">
      <div class="top-right">
        <div class="search-wrap" style="max-width:420px">
          <span class="search-ico">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          </span>
          <input id="globalSearch" type="text" class="search-input" placeholder="Type to search..." />
        </div>
        <div class="notify-pill" title="Notifications" style="position: relative;">
          <span class="notify-bell" id="notifyBellBtn" style="cursor: pointer;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
              <path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/>
            </svg>
            <span class="badge-dot" id="notifyBadge">{{ (isset($notifications) && is_countable($notifications)) ? count($notifications) : 0 }}</span>
          </span>
          
          <!-- Notification Dropdown -->
          <div id="notifyDropdown" class="notify-dropdown" style="display: none; position: absolute; top: 48px; right: 0; width: 360px; background: white; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); z-index: 1000; overflow: hidden; border: 1px solid #e2e8f0;">
            <div style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%); color: white; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center;">
              <span style="font-weight: 700; font-size: 15px;">🔔 Notifications</span>
              <button type="button" id="readAllBtn" style="background: rgba(255,255,255,0.15); color: white; border: none; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                ✓ Read All
              </button>
            </div>
            <div id="notifyList" style="max-height: 350px; overflow-y: auto;">
              @forelse(($notifications ?? []) as $notif)
                <a href="{{ $notif['link'] ?? '#' }}" class="notify-item" style="display: flex; align-items: flex-start; gap: 12px; padding: 14px 20px; border-bottom: 1px solid #f1f5f9; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                  <span style="font-size: 24px; flex-shrink: 0;">{{ $notif['icon'] ?? '📌' }}</span>
                  <div style="flex: 1; min-width: 0;">
                    <div style="font-size: 13px; font-weight: 600; color: #1e293b; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $notif['title'] ?? 'Notification' }}</div>
                    <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">{{ $notif['subtitle'] ?? '' }}</div>
                    <div style="font-size: 11px; color: #94a3b8; display: flex; align-items: center; gap: 4px;">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                      {{ $notif['time'] ?? 'Just now' }}
                    </div>
                  </div>
                  <span style="width: 8px; height: 8px; background: #3b82f6; border-radius: 50%; flex-shrink: 0; margin-top: 6px;"></span>
                </a>
              @empty
                <div style="padding: 40px 20px; text-align: center; color: #94a3b8;">
                  <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 12px; opacity: 0.5;"><path d="M13.73 21a2 2 0 0 1-3.46 0"/><path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/></svg>
                  <div style="font-size: 13px;">No new notifications</div>
                </div>
              @endforelse
            </div>
            @if(count($notifications ?? []) > 0)
            <div style="padding: 12px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0; text-align: center;">
              <a href="{{ route('tickets.index') }}" style="font-size: 13px; color: #3b82f6; font-weight: 600; text-decoration: none;">View All Tickets →</a>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="hrp-col-12">
      <div class="hrp-grid">
        <div class="hrp-col-3">
          <div class="dash-kpi kpi-emp">
            <div class="kpi-top">
              <div class="kpi-left">
                <div class="kpi-ico"><img src="{{ asset('kpi_icon/kpi1.svg') }}" alt="Employees"></div>
              </div>
              <div class="value">{{ data_get($stats, 'employees', 0) }}</div>
            </div>
            <div class="kpi-title">Total Employees</div>
            <div class="kpi-sub {{ $empDeltaClass }}">{{ $empDelta }} From Last Month</div>
          </div>
        </div>
        <div class="hrp-col-3">
          <div class="dash-kpi kpi-proj">
            <div class="kpi-top">
              <div class="kpi-left">
                <div class="kpi-ico"><img src="{{ asset('kpi_icon/kpi2.svg') }}" alt="Projects"></div>
              </div>
              <div class="value">{{ data_get($stats, 'projects', 0) }}</div>
            </div>
            <div class="kpi-title">Active Projects</div>
            <div class="kpi-sub {{ $projDeltaClass }}">{{ $projDelta }} From Last Month</div>
          </div>
        </div>
        <div class="hrp-col-3">
          <div class="dash-kpi kpi-task">
            <div class="kpi-top">
              <div class="kpi-left">
                <div class="kpi-ico"><img src="{{ asset('kpi_icon/kpi3.svg') }}" alt="Open Positions"></div>
              </div>
              <div class="value">{{ data_get($stats, 'open_positions', 0) }}</div>
            </div>
            <div class="kpi-title">Pending Tasks</div>
            <div class="kpi-sub {{ $urgentCount > 0 ? 'red' : 'blue' }}">{{ $urgentCount }} Urgent Priority</div>
          </div>
        </div>
        <div class="hrp-col-3">
          <div class="dash-kpi kpi-attn">
            <div class="kpi-top">
              <div class="kpi-left">
                <div class="kpi-ico"><img src="{{ asset('kpi_icon/kpi4.svg') }}" alt="Attendance"></div>
              </div>
              <div class="value">{{ data_get($stats, 'attendance_percent', '0%') }}</div>
            </div>
            <div class="kpi-title">Attendance Today</div>
            <div class="kpi-sub blue">{{ data_get($stats, 'attendance_present', '0/0') }} Present</div>
          </div>
        </div>
      </div>
    </div>
    <div class="hrp-col-12">
      <div class="card-table">
        <div class="table-header">RECENT INQUIRIES</div>
        <div class="table-body">
          <div class="hrp-table-wrap">
            <table class="hrp-table">
              <thead>
              <tr>
                <th>Action</th>
                <th>Is Confirm</th>
                <th>Company Name</th>
                <th>Person Name</th>
                <th>Person No</th>
                <th>Next Date</th>
                <th>Demo Status</th>
                <th>Demo Date & Time</th>
              </tr>
              </thead>
              <tbody>
              @forelse(($recentInquiries ?? []) as $inq)
                @php
                  $isConfirm = strtoupper($inq['is_confirm'] ?? 'NO');
                  $confirmClass = ($isConfirm === 'YES') ? 'text-green' : 'text-orange';
                  $status = ucfirst($inq['status'] ?? 'New');
                  $statusClass = in_array(strtolower($status), ['confirmed', 'completed', 'done']) ? 'text-green' : 'link-blue';
                @endphp
                <tr>
                  <td>
                    <a href="{{ route('inquiries.show', $inq['id'] ?? 1) }}" class="action-icon view" title="View Inquiry" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; background: #eff6ff; border-radius: 6px; border: none;">
                      <img src="{{ asset('action_icon/view.svg') }}" alt="view" style="width: 16px; height: 16px;">
                    </a>
                  </td>
                  <td><span class="{{ $confirmClass }}" style="font-weight: 600;">{{ $isConfirm }}</span></td>
                  <td style="font-weight: 600; color: #1e293b;">{{ $inq['company'] ?? '—' }}</td>
                  <td style="color: #475569;">{{ $inq['person'] ?? '—' }}</td>
                  <td style="font-family: monospace; color: #64748b;">{{ $inq['phone'] ?? '—' }}</td>
                  <td style="color: #2563eb; font-weight: 500;">{{ $inq['next'] ?? $inq['date'] ?? '—' }}</td>
                  <td><span class="{{ $statusClass }}" style="font-weight: 500;">{{ $status }}</span></td>
                  <td style="font-size: 12px; color: #64748b;">{{ $inq['demo'] ?? '—' }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" style="text-align: center; color: #9ca3af; padding: 30px;">
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                      <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                      </svg>
                      <span>No recent inquiries found</span>
                    </div>
                  </td>
                </tr>
              @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="hrp-col-12">
      <div class="card-table" style="margin-top:12px">
        <div class="table-header">TICKET LIST</div>
        <div class="table-body">
          <div class="hrp-table-wrap">
            <table class="hrp-table">
              <thead>
              <tr>
                <th>Action</th>
                <th>Serial No.</th>
                <th>Ticket</th>
                <th>Work by Employee</th>
                <th>Category</th>
                <th>Customer</th>
                <th>Title</th>
                <th>Description</th>
              </tr>
              </thead>
              <tbody>
              @forelse(($recentTickets ?? []) as $idx => $t)
                <tr data-ticket-id="{{ $t['id'] ?? '' }}">
                  <td class="action-icons" style="display: flex; gap: 6px;">
                    <a href="{{ route('tickets.show', $t['id'] ?? 1) }}" class="action-icon view" title="View Ticket" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; background: #eff6ff; border-radius: 6px; border: none;">
                      <img src="{{ asset('action_icon/view.svg') }}" alt="view" style="width: 16px; height: 16px;">
                    </a>
                    <form action="{{ route('tickets.destroy', $t['id'] ?? 1) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="action-icon delete" title="Delete Ticket" style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; background: #fef2f2; border-radius: 6px; border: none; cursor: pointer;">
                        <img src="{{ asset('action_icon/delete.svg') }}" alt="delete" style="width: 16px; height: 16px;">
                      </button>
                    </form>
                  </td>
                  <td style="font-weight: 600;">{{ $idx + 1 }}</td>
                  <td><span class="link-blue" style="font-weight: 500;">{{ $t['status'] ?? 'Open' }}</span></td>
                  <td class="{{ ($t['priority'] ?? '') === 'green' ? 'text-green' : (($t['priority'] ?? '') === 'orange' ? 'text-orange' : '') }}" style="font-weight: 500;">{{ $t['work'] ?? 'Not Assigned' }}</td>
                  <td>{{ $t['category'] ?? 'General' }}</td>
                  <td>{{ $t['customer'] ?? '—' }}</td>
                  <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $t['title'] ?? '—' }}</td>
                  <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $t['desc'] ?? '—' }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" style="text-align: center; color: #9ca3af; padding: 20px;">No tickets found</td>
                </tr>
              @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="hrp-col-5">
      <div class="hrp-card card-p-0 chart-card">
        <div class="tabbar tabbar-chart">
          <div class="tab active" data-tab="company"><span class="ico">🏢</span> COMPANY LIST</div>
        </div>
        <div class="hrp-card-body chart-body">
          <div class="chart-wrap"><canvas id="chartCompany"></canvas></div>
          <div id="chartCompanyLegend" class="chart-legend"></div>
        </div>
      </div>
    </div>
    <div class="hrp-col-7">
      <div class="hrp-card card-p-0">
        <div class="tabbar">
          <div class="tab active" data-tab="notes"><span class="ico">📑</span> NOTES</div>
          <div class="tab" data-tab="admin"><span class="ico">👤</span> ADMIN NOTES</div>
          <div class="tab" data-tab="emp"><span class="ico">👥</span> EMP. NOTES</div>
        </div>
        <div class="hrp-card-body-note">
          <div class="tab-pane show" id="tab-notes">
            <div class="notes-title">Add New Notes</div>
            @can('Dashboard.manage dashboard')
            <div class="notes-entry">
              <textarea class="notes-area" id="systemNoteText" rows="3" placeholder="Enter your Note....."></textarea>
              <button class="notes-send" type="button" aria-label="Add">➤</button>
            </div>
            @endcan
            <div class="chips-wrap" style="display:none"></div>
            <div class="notes-grid" id="systemNotesGrid">
              <!-- Notes will be loaded dynamically -->
            </div>
            <div class="pager pager-num" id="notesPager">
              <a class="prev" href="#" onclick="changeSystemNotesPage(-1); return false;">«</a>
              <span class="pager-info" id="pagerInfo">Page 1</span>
              <a class="next" href="#" onclick="changeSystemNotesPage(1); return false;">»</a>
            </div>
          </div>
          <div class="tab-pane" id="tab-admin" hidden>
            @can('Dashboard.manage dashboard')
              <div class="notes-title">Add New Admin Notes</div>
              <textarea class="notes-area" id="adminNoteText" rows="3" placeholder="Enter your admin note....."></textarea>
              
              <div class="notes-assign-section" style="margin-top: 16px; position: relative;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                  <label style="font-size: 13px; font-weight: 600; color: #475569; margin: 0;">
                    Assigned Employees:
                  </label>
                  <button type="button" id="btnOpenEmployeeModal" class="btn-add-employees-round" style="width: 40px; height: 40px; background: #10b981; color: white; border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3); transition: all 0.3s ease;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                      <line x1="12" y1="5" x2="12" y2="19"></line>
                      <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                  </button>
                </div>
                
                <div id="adminChips" style="display: flex; flex-wrap: wrap; gap: 10px; min-height: 40px;">
                  <span id="emptyChipsMessage" style="color: #94a3b8; font-size: 13px; font-style: italic;">No employees assigned yet</span>
                </div>
              </div>

              <button type="button" id="btnSaveAdminNote" class="hrp-btn hrp-btn-primary" style="margin-top: 20px; padding: 12px 32px; background: #14ae5c; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600; width: 100%;">
                💾 Save Admin Note
              </button>

              <!-- Display Created Admin Notes - Hidden, shown in EMP. NOTES tab instead -->
              <div id="adminNotesDisplay" style="display: none;">
                <!-- Notes will be displayed in EMP. NOTES tab -->
              </div>
            @endcan
          </div>
          <div class="tab-pane" id="tab-emp" hidden>
            <div class="notes-list" id="adminEmpNotesList" style="max-height: 100%; height: 100%; overflow-y: auto; overflow-x: hidden; padding: 8px 12px 16px 4px; display: flex; flex-direction: column; gap: 14px;">
              <!-- Notes will be loaded dynamically -->
            </div>
            <!-- Scrollbar styling -->
            <style>
              #adminEmpNotesList {
                scrollbar-width: thin;
                scrollbar-color: #cbd5e1 #f1f5f9;
              }
              #adminEmpNotesList::-webkit-scrollbar {
                width: 10px;
              }
              #adminEmpNotesList::-webkit-scrollbar-track {
                background: #f1f5f9;
                border-radius: 10px;
                margin: 5px 0;
              }
              #adminEmpNotesList::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 10px;
                border: 2px solid #f1f5f9;
              }
              #adminEmpNotesList::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
              }
              #adminEmpNotesList::-webkit-scrollbar-thumb:active {
                background: #64748b;
              }
              .emp-note-card {
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                padding: 18px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.04);
                transition: all 0.25s ease;
                position: relative;
                overflow: hidden;
              }
              .emp-note-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
                background: linear-gradient(180deg, #3b82f6 0%, #8b5cf6 100%);
                border-radius: 14px 0 0 14px;
              }
              .emp-note-card:hover {
                box-shadow: 0 8px 24px rgba(0,0,0,0.1);
                transform: translateY(-2px);
              }
              .emp-note-text {
                font-size: 14px;
                color: #1e293b;
                line-height: 1.7;
                margin-bottom: 14px;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                font-weight: 500;
                letter-spacing: -0.2px;
              }
              .emp-note-assignees {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin-bottom: 14px;
              }
              .emp-note-chip {
                display: inline-flex;
                align-items: center;
                padding: 6px 14px;
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                color: white;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: 0.2px;
                box-shadow: 0 2px 6px rgba(59, 130, 246, 0.3);
              }
              .emp-note-meta {
                display: flex;
                align-items: center;
                gap: 16px;
                font-size: 12px;
                color: #64748b;
                font-weight: 500;
                padding-top: 12px;
                border-top: 1px solid #f1f5f9;
              }
              .emp-note-meta svg {
                opacity: 0.7;
              }
              .emp-note-actions {
                display: flex;
                gap: 10px;
                margin-top: 14px;
              }
              .emp-note-btn {
                padding: 8px 16px;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                font-size: 12px;
                font-weight: 600;
                transition: all 0.2s ease;
                display: inline-flex;
                align-items: center;
                gap: 6px;
              }
              .emp-note-edit {
                background: #eff6ff;
                color: #1e40af;
                border: 1px solid #bfdbfe;
              }
              .emp-note-edit:hover {
                background: #2563eb;
                color: white;
                border-color: #2563eb;
                transform: translateY(-1px);
              }
              .emp-note-delete {
                background: #fef2f2;
                color: #dc2626;
                border: 1px solid #fecaca;
              }
              .emp-note-delete:hover {
                background: #dc2626;
                color: white;
                border-color: #dc2626;
                transform: translateY(-1px);
              }
            </style>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Employee Selection Modal -->
  <div id="employeeModal" class="employee-modal" style="display: none;">
    <div class="modal-overlay" id="modalOverlay"></div>
    <div class="modal-content">
      <div class="modal-header">
        <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 8px;">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
          </svg>
          <span>Select Employees to Assign</span>
        </h3>
        <button type="button" id="btnCloseModal" class="modal-close" style="background: none; border: none; font-size: 32px; color: #94a3b8; cursor: pointer; padding: 0; line-height: 1; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 4px; transition: all 0.2s ease;">×</button>
      </div>
      
      <div class="modal-search" style="padding: 16px; border-bottom: 1px solid #e2e8f0;">
        <input type="text" id="employeeSearch" placeholder="🔍 Search employees by name..." style="width: 100%; padding: 10px 16px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px;">
      </div>

      <div class="modal-body">
        <div class="employee-grid" id="employeeGrid">
          @foreach(($users ?? []) as $user)
            <div class="employee-card" data-id="{{ $user['id'] }}" data-name="{{ $user['name'] }}">
              <div class="employee-checkbox">
                <input type="checkbox" id="emp_{{ $user['id'] }}" value="{{ $user['id'] }}">
              </div>
              <div class="employee-avatar">
                <img src="{{ $user['photo'] }}" alt="{{ $user['name'] }}" onerror="this.src='{{ asset('new_theme/dist/img/avatar.png') }}'">
              </div>
              <div class="employee-name">{{ $user['name'] }}</div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="modal-footer">
        <div class="selected-count">
          <span id="selectedCount">0</span> employee(s) selected
        </div>
        <div class="modal-actions">
          <button type="button" id="btnCancelModal" class="btn-cancel">Cancel</button>
          <button type="button" id="btnConfirmSelection" class="btn-confirm">✓ Confirm Selection</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script src="{{ asset('new_theme/bower_components/chart.js/Chart.js') }}"></script>
<script>
  // ========== NOTIFICATION DROPDOWN FUNCTIONALITY ==========
  (function() {
    var notifyBell = document.getElementById('notifyBellBtn');
    var notifyDropdown = document.getElementById('notifyDropdown');
    var notifyBadge = document.getElementById('notifyBadge');
    var readAllBtn = document.getElementById('readAllBtn');
    var notifyList = document.getElementById('notifyList');
    
    if (notifyBell && notifyDropdown) {
      // Toggle dropdown on bell click
      notifyBell.addEventListener('click', function(e) {
        e.stopPropagation();
        var isVisible = notifyDropdown.style.display === 'block';
        notifyDropdown.style.display = isVisible ? 'none' : 'block';
        
        // Add animation
        if (!isVisible) {
          notifyDropdown.style.opacity = '0';
          notifyDropdown.style.transform = 'translateY(-10px)';
          setTimeout(function() {
            notifyDropdown.style.transition = 'all 0.2s ease';
            notifyDropdown.style.opacity = '1';
            notifyDropdown.style.transform = 'translateY(0)';
          }, 10);
        }
      });
      
      // Close dropdown when clicking outside
      document.addEventListener('click', function(e) {
        if (!notifyDropdown.contains(e.target) && !notifyBell.contains(e.target)) {
          notifyDropdown.style.display = 'none';
        }
      });
      
      // Read All button functionality
      if (readAllBtn) {
        readAllBtn.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          
          // Hide badge
          if (notifyBadge) {
            notifyBadge.style.display = 'none';
          }
          
          // Remove blue dots from all items
          var blueDots = notifyList.querySelectorAll('span[style*="background: #3b82f6"]');
          blueDots.forEach(function(dot) {
            dot.style.display = 'none';
          });
          
          // Change button text
          this.innerHTML = '✓ All Read';
          this.style.background = 'rgba(16, 185, 129, 0.3)';
          
          // Store in localStorage that notifications are read
          localStorage.setItem('notificationsReadAt', Date.now());
          
          // Show toast if available
          if (window.toastr) {
            toastr.success('All notifications marked as read');
          }
        });
      }
      
      // Check if notifications were already read
      var lastReadAt = localStorage.getItem('notificationsReadAt');
      if (lastReadAt) {
        var readTime = parseInt(lastReadAt);
        var oneHourAgo = Date.now() - (60 * 60 * 1000); // 1 hour
        
        // If read within the last hour, keep badge hidden
        if (readTime > oneHourAgo) {
          if (notifyBadge) {
            notifyBadge.style.display = 'none';
          }
        }
      }
    }
  })();

  (function(){
    try{
      // Determine Chart.js major version once
      var __chartVer = (window.Chart && Chart.version ? Chart.version : '2.9.4').split('.')[0];
      var __isV3 = parseInt(__chartVer, 10) >= 3;

      // Hiring (bar)
      var ctx1 = document.getElementById('chartHiring');
      if (ctx1 && window.Chart) {
        var data1 = {
          labels: ['Applied','Screen','Interview','Offer','Joined'],
          datasets: [{ label: 'Candidates', data: [42,28,14,6,3], backgroundColor: '#267bf5' }]
        };
        var opts1 = __isV3 ? {
          plugins: { legend: { display: false } },
          scales: { y: { beginAtZero: true } }
        } : {
          legend: { display: false },
          scales: { yAxes: [{ ticks: { beginAtZero: true } }] }
        };
        new Chart(ctx1, { type: 'bar', data: data1, options: opts1 });
      }

      // Attendance (line)
      var ctx2 = document.getElementById('chartAttendance');
      if (ctx2 && window.Chart) {
        var data2 = {
          labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
          datasets: [{ label: 'Present %', data: [90,92,93,91,94,60,0], fill: false, borderColor: '#14ae5c', tension: 0.3 }]
        };
        var opts2 = __isV3 ? {
          plugins: { legend: { display: false } },
          scales: { y: { beginAtZero: true, max: 100 } }
        } : {
          legend: { display: false },
          scales: { yAxes: [{ ticks: { beginAtZero: true, max: 100 } }] }
        };
        new Chart(ctx2, { type: 'line', data: data2, options: opts2 });
      }
      var canvas3 = document.getElementById('chartCompany');
      if(canvas3 && window.Chart){
        requestAnimationFrame(function(){
          try{
            var ver = (Chart.version || '1.1.1').split('.')[0];
            var major = parseInt(ver,10) || 1;
            var ctx3 = canvas3.getContext('2d');
            
            // Dynamic company data from controller
            var companyData = @json($companyData ?? []);
            var colors = ['#267bf5', '#14ae5c', '#f59e0b', '#ef4444'];
            var highlights = ['#4c95f7', '#2acb77', '#f7b643', '#f36a6a'];
            
            if(major <= 1){
              // Chart.js v1 Doughnut API - Dynamic data
              var dataV1 = companyData.map(function(item, idx) {
                return {
                  value: item.value,
                  color: colors[idx % colors.length],
                  highlight: highlights[idx % highlights.length],
                  label: item.name
                };
              });
              var optsV1 = {
                responsive: true,
                animationSteps: 60,
                animationEasing: 'easeOutQuart',
                animateRotate: true,
                animateScale: false,
                percentageInnerCutout: 68,
                segmentStrokeColor: '#ffffff',
                segmentStrokeWidth: 2,
                tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
                onAnimationComplete: function(){
                  try{
                    var total = dataV1.reduce(function(s, it){ return s + (it.value||0); }, 0);
                    var cx = canvas3.width/2, cy = canvas3.height/2;
                    ctx3.save();
                    ctx3.fillStyle = '#0f172a';
                    ctx3.textAlign = 'center';
                    ctx3.textBaseline = 'middle';
                    ctx3.font = '700 16px Visby, Arial, sans-serif';
                    ctx3.fillText('Total', cx, cy-10);
                    ctx3.font = '900 20px Visby, Arial, sans-serif';
                    ctx3.fillText(String(total), cx, cy+12);
                    ctx3.restore();
                  }catch(_e){}
                }
              };
              var chartV1 = new Chart(ctx3).Doughnut(dataV1, optsV1);
              var legendEl = document.getElementById('chartCompanyLegend');
              if(legendEl && chartV1){
                try{
                  var total = dataV1.reduce(function(s, it){ return s + (it.value||0); }, 0);
                  var html = "<ul class='doughnut-legend'>" + dataV1.map(function(it){
                    var pct = total ? Math.round((it.value/total)*100) : 0;
                    return "<li><span class='swatch' style='background:"+it.color+"'></span><b>"+it.label+"</b> — "+it.value+" ("+pct+"%)</li>";
                  }).join('') + "</ul>";
                  legendEl.innerHTML = html;
                }catch(_e){}
              }
            } else {
              // v2+ / v3 path - Dynamic data
              var isV3 = major >= 3;
              var data = {
                labels: companyData.map(function(item) { return item.name; }),
                datasets:[{ 
                  data: companyData.map(function(item) { return item.value; }), 
                  backgroundColor: colors 
                }]
              };
              var opts = isV3 ? {
                maintainAspectRatio:false,
                plugins:{ legend:{ position:'bottom' } },
                cutout:'60%'
              } : {
                maintainAspectRatio:false,
                legend:{ position:'bottom' },
                cutoutPercentage:60
              };
              new Chart(ctx3, { type:'doughnut', data:data, options:opts });
            }
          }catch(e){ /* ignore */ }
        });
      }
    }catch(e){}
    // Simple table filter bound to #globalSearch
    try{
      var input = document.getElementById('globalSearch');
      var table = document.querySelector('.hrp-table tbody');
      if(input && table){
        input.addEventListener('input', function(){
          var q = (input.value || '').toLowerCase();
          table.querySelectorAll('tr').forEach(function(tr){
            var txt = tr.textContent.toLowerCase();
            tr.style.display = txt.indexOf(q) > -1 ? '' : 'none';
          });
        });
      }
      var applyBtn = document.querySelector('.hrp-btn.hrp-btn-primary');
      if(applyBtn){
        applyBtn.addEventListener('click', function(){
          // Hook for date range apply; integrate with backend later
        });
      }
    }catch(e){}
  })();
</script>
<script>
  // Flag to prevent duplicate note loading
  var notesLoaded = false;
  
  // System Notes (first NOTES tab) - Pagination variables
  var systemNotesCurrentPage = 1;
  var systemNotesPerPage = 4;
  var systemNotesTotalPages = 1;
  var systemNotesData = [];

  // Load system notes from server
  function loadSystemNotes(page) {
    page = page || 1;
    systemNotesCurrentPage = page;
    
    fetch('{{ route("employee.notes.get") }}?type=system&page=' + page + '&limit=' + systemNotesPerPage, {
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
      if (data.success) {
        systemNotesData = data.notes;
        systemNotesTotalPages = data.pages || 1;
        displaySystemNotes(data.notes);
        updateSystemNotesPager();
      }
    })
    .catch(function(error) {
      console.error('Error loading system notes:', error);
    });
  }

  // Display system notes in the grid with beautiful design
  function displaySystemNotes(notes) {
    var container = document.getElementById('systemNotesGrid');
    if (!container) return;
    
    if (!notes || notes.length === 0) {
      container.innerHTML = '<div style="text-align: center; padding: 30px; color: #9ca3af; font-size: 13px; background: #f9fafb; border-radius: 12px; border: 2px dashed #e5e7eb;">📝 No notes yet. Add your first note above!</div>';
      return;
    }
    
    var html = '';
    notes.forEach(function(note) {
      html += 
        '<div class="note-card" data-note-id="' + note.id + '" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); transition: all 0.2s ease;">' +
          '<div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px;">' +
            '<div style="flex: 1;">' +
              '<div style="font-size: 14px; color: #1e293b; line-height: 1.6; font-weight: 500;">' + escapeHtml(note.text) + '</div>' +
              '<div style="display: flex; align-items: center; gap: 6px; margin-top: 10px; font-size: 11px; color: #94a3b8;">' +
                '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>' +
                '<span>' + note.date + '</span>' +
              '</div>' +
            '</div>' +
            '<div style="display: flex; gap: 6px; flex-shrink: 0;">' +
              '<button onclick="editSystemNote(' + note.id + ')" style="width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; border: 1px solid #bfdbfe; color: #2563eb; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;" title="Edit note" onmouseover="this.style.background=\'#2563eb\'; this.style.color=\'white\';" onmouseout="this.style.background=\'#eff6ff\'; this.style.color=\'#2563eb\';">' +
                '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>' +
              '</button>' +
              '<button onclick="deleteSystemNote(' + note.id + ')" style="width: 32px; height: 32px; border-radius: 8px; background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;" title="Delete note" onmouseover="this.style.background=\'#dc2626\'; this.style.color=\'white\';" onmouseout="this.style.background=\'#fef2f2\'; this.style.color=\'#dc2626\';">' +
                '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>' +
              '</button>' +
            '</div>' +
          '</div>' +
        '</div>';
    });
    
    container.innerHTML = html;
  }
  
  // Edit system note
  function editSystemNote(noteId) {
    // Find current text
    var noteCard = document.querySelector('.note-card[data-note-id="' + noteId + '"]');
    var currentText = '';
    if (noteCard) {
      var textEl = noteCard.querySelector('div[style*="font-size: 14px"]');
      if (textEl) currentText = textEl.textContent;
    }
    
    var newText = prompt('Edit note:', currentText);
    if (newText && newText.trim() && newText.trim() !== currentText) {
      var csrfToken = document.querySelector('meta[name="csrf-token"]');
      if (!csrfToken) {
        alert('Error: CSRF token not found.');
        return;
      }
      
      fetch('{{ url("/api/admin-notes") }}/' + noteId, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrfToken.content
        },
        body: JSON.stringify({ text: newText.trim() })
      })
      .then(function(r) { return r.json(); })
      .then(function(data) {
        if (data.success) {
          loadSystemNotes(systemNotesCurrentPage);
          if (window.toastr) toastr.success('Note updated!');
        } else {
          alert('Error: ' + (data.message || 'Failed to update'));
        }
      })
      .catch(function(e) { console.error(e); alert('Error updating note'); });
    }
  }

  // Update pagination display
  function updateSystemNotesPager() {
    var pagerInfo = document.getElementById('pagerInfo');
    if (pagerInfo) {
      pagerInfo.textContent = 'Page ' + systemNotesCurrentPage + ' of ' + systemNotesTotalPages;
    }
    
    // Update prev/next button states
    var prevBtn = document.querySelector('#notesPager .prev');
    var nextBtn = document.querySelector('#notesPager .next');
    
    if (prevBtn) {
      prevBtn.style.opacity = systemNotesCurrentPage <= 1 ? '0.5' : '1';
      prevBtn.style.pointerEvents = systemNotesCurrentPage <= 1 ? 'none' : 'auto';
    }
    if (nextBtn) {
      nextBtn.style.opacity = systemNotesCurrentPage >= systemNotesTotalPages ? '0.5' : '1';
      nextBtn.style.pointerEvents = systemNotesCurrentPage >= systemNotesTotalPages ? 'none' : 'auto';
    }
  }

  // Change page
  function changeSystemNotesPage(direction) {
    var newPage = systemNotesCurrentPage + direction;
    if (newPage >= 1 && newPage <= systemNotesTotalPages) {
      loadSystemNotes(newPage);
    }
  }

  // Delete system note (admin can delete any note)
  function deleteSystemNote(noteId) {
    if (!confirm('Are you sure you want to delete this note?')) {
      return;
    }
    
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
      alert('Error: CSRF token not found. Please refresh the page.');
      return;
    }
    
    // Use admin route to delete any note
    fetch('{{ url("/api/admin-notes") }}/' + noteId, {
      method: 'DELETE',
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken.content
      }
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
      if (data.success) {
        // Remove the note card from DOM
        var noteCard = document.querySelector('.note-card[data-note-id="' + noteId + '"]');
        if (noteCard) {
          noteCard.remove();
        }
        // Reload notes to update pagination
        loadSystemNotes(systemNotesCurrentPage);
        if (window.toastr) {
          toastr.success('Note deleted successfully!');
        } else {
          alert('Note deleted successfully!');
        }
      } else {
        alert('Error: ' + (data.message || 'Failed to delete note'));
      }
    })
    .catch(function(error) {
      console.error('Error deleting note:', error);
      alert('Error deleting note');
    });
  }

  // Helper function to escape HTML
  function escapeHtml(text) {
    var div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  // Define all note functions globally (outside try-catch)
  function displayAdminNotes(notes) {
    var container = document.getElementById('adminNotesDisplay');
    if (!container) return;
    
    if (notes.length === 0) {
      container.innerHTML = '<p style="color: #9ca3af; font-size: 13px;">No notes created yet</p>';
      return;
    }
    
    var html = '';
    notes.forEach(function(note) {
      html += `
        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
          <div style="font-size: 13px; color: #374151; line-height: 1.6; margin-bottom: 12px;">${note.text}</div>
          <div style="display: flex; justify-content: space-between; align-items: center; font-size: 11px; color: #9ca3af; margin-bottom: 12px;">
            <span>Employee ID: ${note.employee_id}</span>
            <span>${note.date}</span>
          </div>
          <div style="display: flex; gap: 8px;">
            <button onclick="editAdminNote(${note.id})" style="flex: 1; padding: 6px 12px; background: #3b82f6; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 600;">Edit</button>
            <button onclick="deleteAdminNote(${note.id})" style="flex: 1; padding: 6px 12px; background: #ef4444; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 600;">Delete</button>
          </div>
        </div>
      `;
    });
    
    container.innerHTML = html;
  }

  // Edit note text
  function editAdminNoteText(noteId) {
    // Find the current note text
    var noteCard = document.querySelector('.emp-note-card');
    var currentText = '';
    
    // Try to get current text from the displayed notes
    var allNoteCards = document.querySelectorAll('.emp-note-card');
    allNoteCards.forEach(function(card) {
      var deleteBtn = card.querySelector('button[onclick*="deleteAdminNote(' + noteId + ')"]');
      if (deleteBtn) {
        var textEl = card.querySelector('.emp-note-text');
        if (textEl) {
          currentText = textEl.textContent;
        }
      }
    });
    
    var newText = prompt('Edit note text:', currentText);
    if (newText && newText.trim()) {
      var csrfToken = document.querySelector('meta[name="csrf-token"]');
      if (!csrfToken) {
        alert('Error: CSRF token not found. Please refresh the page.');
        return;
      }
      
      fetch('{{ url("/api/admin-notes") }}/' + noteId, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrfToken.content
        },
        body: JSON.stringify({ text: newText.trim() })
      })
      .then(function(response) { return response.json(); })
      .then(function(data) {
        if (data.success) {
          loadAdminEmpNotes();
          if (window.toastr) {
            toastr.success('Note text updated successfully!');
          } else {
            alert('Note text updated successfully!');
          }
        } else {
          alert('Error: ' + (data.message || 'Failed to update note'));
        }
      })
      .catch(function(error) {
        console.error('Error:', error);
        alert('Error updating note');
      });
    }
  }

  // Edit note employees (add/remove)
  var editingNoteId = null;
  
  function editAdminNoteEmployees(noteId) {
    editingNoteId = noteId;
    
    // Fetch current note data
    fetch('{{ route("employee.notes.get") }}?type=employee&limit=500', {
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
      if (data.success && data.notes) {
        // Find the specific note
        var currentNote = data.notes.find(function(n) { return n.id == noteId; });
        if (!currentNote) {
          alert('Note not found');
          return;
        }
        
        var currentAssignees = currentNote.assignees || [];
        
        // Clear previous selections
        selectedUsers = [];
        
        // Open modal for editing
        var modal = document.getElementById('employeeModal');
        modal.style.display = 'flex';
        
        // Pre-select current employees based on names
        var checkboxes = document.querySelectorAll('.employee-card input[type="checkbox"]');
        checkboxes.forEach(function(cb) {
          var userId = cb.value;
          var card = cb.closest('.employee-card');
          var userName = card ? card.getAttribute('data-name') : '';
          
          // Check if this employee's name is in the assignees
          var isSelected = currentAssignees.some(function(assigneeName) {
            return assigneeName === userName;
          });
          
          cb.checked = isSelected;
          if (card) {
            card.classList.toggle('selected', isSelected);
          }
          
          // Add to selectedUsers if selected
          if (isSelected) {
            var userPhoto = allUsers.find(function(u) { return u.id == userId; });
            selectedUsers.push({
              id: userId,
              name: userName,
              photo: userPhoto ? userPhoto.photo : '{{ asset("new_theme/dist/img/avatar.png") }}'
            });
          }
        });
        
        updateSelectedCount();
        
        // Change modal title to indicate editing
        var modalTitle = modal.querySelector('.modal-header h3 span');
        if (modalTitle) {
          modalTitle.textContent = 'Edit Assigned Employees';
        }
        
        // Change confirm button text
        var confirmBtn = document.getElementById('btnConfirmSelection');
        if (confirmBtn) {
          confirmBtn.textContent = '✓ Update Employees';
        }
      }
    })
    .catch(function(error) {
      console.error('Error:', error);
      alert('Error loading note data');
    });
  }

  // Update note employees
  function updateNoteEmployees() {
    if (!editingNoteId) {
      alert('No note selected for editing');
      return;
    }
    
    if (selectedUsers.length === 0) {
      alert('Please select at least one employee!');
      return;
    }
    
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
      alert('Error: CSRF token not found. Please refresh the page.');
      return;
    }
    
    fetch('{{ url("/api/admin-notes") }}/' + editingNoteId + '/employees', {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken.content
      },
      body: JSON.stringify({
        assignees: selectedUsers.map(function(u) { return parseInt(u.id, 10); })
      })
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
      if (data.success) {
        closeModal();
        editingNoteId = null;
        selectedUsers = [];
        updateChipsDisplay();
        loadAdminEmpNotes();
        
        // Reset modal title and button
        resetModalForCreate();
        
        if (window.toastr) {
          toastr.success('Note employees updated successfully!');
        } else {
          alert('Note employees updated successfully!');
        }
      } else {
        alert('Error: ' + (data.message || 'Failed to update employees'));
      }
    })
    .catch(function(error) {
      console.error('Error:', error);
      alert('Error updating employees');
    });
  }
  
  // Reset modal for creating new notes
  function resetModalForCreate() {
    var modal = document.getElementById('employeeModal');
    var modalTitle = modal ? modal.querySelector('.modal-header h3 span') : null;
    if (modalTitle) {
      modalTitle.textContent = 'Select Employees to Assign';
    }
    var confirmBtn = document.getElementById('btnConfirmSelection');
    if (confirmBtn) {
      confirmBtn.textContent = '✓ Confirm Selection';
    }
    editingNoteId = null;
  }

  function deleteAdminNote(noteId) {
    if (!confirm('Are you sure you want to delete this note? This action cannot be undone.')) {
      return;
    }
    
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
      alert('Error: CSRF token not found. Please refresh the page.');
      return;
    }
    
    fetch('{{ url("/api/admin-notes") }}/' + noteId, {
      method: 'DELETE',
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken.content
      }
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
      if (data.success) {
        loadAdminEmpNotes();
        if (window.toastr) {
          toastr.success('Note deleted successfully!');
        } else {
          alert('Note deleted successfully!');
        }
      } else {
        alert('Error: ' + (data.message || 'Failed to delete note'));
      }
    })
    .catch(function(error) {
      console.error('Error:', error);
      alert('Error deleting note');
    });
  }



  // Load admin emp notes (for admin dashboard)
  function loadAdminEmpNotes() {
    fetch('{{ route("employee.notes.get") }}?type=employee&limit=500', {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
      if (data.success) {
        displayAdminEmpNotes(data.notes);
      }
    })
    .catch(function(error) {
      console.error('Error loading notes:', error);
    });
  }

  // Display admin emp notes with beautiful design
  function displayAdminEmpNotes(notes) {
    var container = document.getElementById('adminEmpNotesList');
    if (!container) return;
    
    // Clear container
    container.innerHTML = '';
    
    if (!notes || notes.length === 0) {
      container.innerHTML = '<div style="text-align: center; padding: 40px; color: #9ca3af; font-size: 13px; background: #f9fafb; border-radius: 12px; border: 2px dashed #e5e7eb;">📋 No employee notes created yet</div>';
      return;
    }
    
    // Display notes with beautiful design
    notes.forEach(function(note) {
      // Build assignees chips with gradient background
      var assigneesHtml = '';
      var assigneesList = note.assignees || [];
      
      // Handle if assignees is a string (JSON)
      if (typeof assigneesList === 'string') {
        try {
          assigneesList = JSON.parse(assigneesList);
        } catch(e) {
          assigneesList = [];
        }
      }
      
      if (Array.isArray(assigneesList) && assigneesList.length > 0) {
        assigneesList.forEach(function(assignee) {
          assigneesHtml += '<span style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 14px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border-radius: 20px; font-size: 12px; font-weight: 600; margin-right: 8px; margin-bottom: 8px; box-shadow: 0 2px 6px rgba(59,130,246,0.3);"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>' + escapeHtml(assignee) + '</span>';
        });
      } else {
        assigneesHtml = '<span style="display: inline-flex; align-items: center; padding: 6px 14px; background: #f1f5f9; color: #64748b; border-radius: 20px; font-size: 12px; font-weight: 500;">No assignees</span>';
      }
      
      var noteDate = note.date || 'No date';
      
      var noteHtml = 
        '<div class="emp-note-card" data-note-id="' + note.id + '" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border: 1px solid #e2e8f0; border-left: 4px solid #3b82f6; border-radius: 12px; padding: 18px 18px 18px 20px; margin-bottom: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.06); transition: all 0.25s ease;">' +
          '<div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px;">' +
            '<div style="flex: 1; min-width: 0;">' +
              '<div style="font-size: 15px; color: #1e293b; line-height: 1.7; font-weight: 500; margin-bottom: 14px; font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif;">' + escapeHtml(note.text || '') + '</div>' +
              '<div style="margin-bottom: 14px;">' +
                '<div style="font-size: 11px; color: #64748b; margin-bottom: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px;">👥 Assigned to:</div>' +
                '<div style="display: flex; flex-wrap: wrap; gap: 6px;">' + assigneesHtml + '</div>' +
              '</div>' +
              '<div style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: #64748b; padding-top: 12px; border-top: 1px solid #f1f5f9;">' +
                '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>' +
                '<span style="font-weight: 500;">' + noteDate + '</span>' +
              '</div>' +
            '</div>' +
            '<div style="display: flex; flex-direction: column; gap: 8px; flex-shrink: 0;">' +
              '<button onclick="editAdminNoteText(' + note.id + ')" style="width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #bfdbfe; color: #2563eb; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(37,99,235,0.1);" title="Edit note">' +
                '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>' +
              '</button>' +
              '<button onclick="deleteAdminNote(' + note.id + ')" style="width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border: 1px solid #fecaca; color: #dc2626; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(220,38,38,0.1);" title="Delete note">' +
                '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>' +
              '</button>' +
            '</div>' +
          '</div>' +
        '</div>';
      
      container.innerHTML += noteHtml;
    });
  }

  (function(){
    try{
      // Helpers that work per-card (so class name changes won't break)
      function initNotesPagerFor(panes){
        var grid = panes.notes && panes.notes.querySelector('.notes-grid');
        var pager = document.getElementById('notesPager');
        if(!grid || !pager) return;
        var items = Array.prototype.slice.call(grid.children);
        var per = 2; var pages = Math.max(1, Math.ceil(items.length/per));
        var prev = pager.querySelector('.prev');
        var next = pager.querySelector('.next');
        pager.innerHTML = '';
        if(prev) pager.appendChild(prev);
        for(var i=0;i<pages;i++){ var s=document.createElement('span'); s.className='num'+(i===0?' active':''); s.textContent=(i+1).toString().padStart(2,'0'); s.dataset.page=i; pager.appendChild(s);}        
        if(next) pager.appendChild(next);
        var current = 0;
        function show(p){ current = Math.max(0, Math.min(p, pages-1));
          items.forEach(function(el,idx){ el.style.display=(Math.floor(idx/per)===current)?'':'none'; });
          pager.querySelectorAll('.num').forEach(function(n){ n.classList.toggle('active', Number(n.dataset.page)===current); }); }
        pager.addEventListener('click', function(e){
          var tNum = e.target.closest('.num');
          if(tNum){ show(Number(tNum.dataset.page)); return; }
          if(e.target.closest('.prev')){ show(current-1); return; }
          if(e.target.closest('.next')){ show(current+1); return; }
        });
        show(0);
      }
      function initEmpPagerFor(panes){
        var list = panes.emp && panes.emp.querySelector('.notes-list');
        var pager = panes.emp && panes.emp.querySelector('.pager-num');
        if(!list || !pager) return;
        var items = Array.prototype.slice.call(list.children);
        var per = 3; var pages = Math.max(1, Math.ceil(items.length/per));
        var prev = pager.querySelector('.prev');
        pager.innerHTML = '';
        if(prev) pager.appendChild(prev);
        for(var i=0;i<pages;i++){ var s=document.createElement('span'); s.className='num'+(i===0?' active':''); s.textContent=(i+1).toString().padStart(2,'0'); s.dataset.page=i; pager.appendChild(s);}        
        function show(p){ items.forEach(function(el,idx){ el.style.display=(Math.floor(idx/per)===p)?'':'none'; });
          pager.querySelectorAll('.num').forEach(function(n){ n.classList.toggle('active', Number(n.dataset.page)===p); }); }
        pager.addEventListener('click', function(e){ var t=e.target.closest('.num'); if(!t) return; show(Number(t.dataset.page)); });
        show(0);
      }

      // Delegated tab switcher (resilient to class/name changes)
      function getPanesForCard(card){
        return {
          notes: card.querySelector('#tab-notes'),
          admin: card.querySelector('#tab-admin'),
          emp: card.querySelector('#tab-emp')
        };
      }
      function activateInCard(card, key){
        var tabs = card.querySelectorAll('.tabbar .tab');
        var panes = getPanesForCard(card);
        tabs.forEach(function(t){ t.classList.toggle('active', t.getAttribute('data-tab')===key); });
        Object.keys(panes).forEach(function(k){ if(panes[k]){ if(k===key){ panes[k].removeAttribute('hidden'); panes[k].classList.add('show'); } else { panes[k].setAttribute('hidden','hidden'); panes[k].classList.remove('show'); } } });
      }
      document.addEventListener('click', function(e){
        var tab = e.target.closest('.tabbar .tab');
        if(!tab) return;
        e.preventDefault();
        var card = tab.closest('.hrp-card');
        if(!card) return;
        var key = tab.getAttribute('data-tab');
        if(!key) return;
        activateInCard(card, key);
        var panes = getPanesForCard(card);
        if(panes.notes || panes.admin || panes.emp){
          initNotesPagerFor(panes);
          initEmpPagerFor(panes);
        }
        // Load admin emp notes when emp tab is clicked
        if(key === 'emp'){
          loadAdminEmpNotes();
        }
      });
      // Initial activation for notes card on load
      var notesCard = document.querySelector('.hrp-card #tab-notes');
      if(notesCard){
        var cardEl = notesCard.closest('.hrp-card');
        if(cardEl){
          activateInCard(cardEl, 'notes');
          var panes0 = getPanesForCard(cardEl);
          initNotesPagerFor(panes0);
          initEmpPagerFor(panes0);
        }
      }

      // Admin: Employee Selection Modal
      var selectedUsers = [];
      var allUsers = @json($users ?? []);
      var modal = document.getElementById('employeeModal');
      var chipsPanel = document.getElementById('adminChips');
      
      console.log('Admin notes initialized. Users available:', allUsers.length);
      
      function updateChipsDisplay() {
        if (!chipsPanel) return;
        
        if (selectedUsers.length === 0) {
          chipsPanel.innerHTML = '<span id="emptyChipsMessage" style="color: #94a3b8; font-size: 13px; font-style: italic;">No employees assigned yet</span>';
        } else {
          chipsPanel.innerHTML = '';
          selectedUsers.forEach(function(user, idx) {
            var chip = document.createElement('div');
            chip.style.cssText = 'display: inline-flex; align-items: center; gap: 8px; padding: 8px 12px; background: #dbeafe; color: #1e40af; border-radius: 8px; font-size: 13px; font-weight: 500; border: 1px solid #bfdbfe;';
            chip.innerHTML = '<img src="' + user.photo + '" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;" onerror="this.src=\'{{ asset('new_theme/dist/img/avatar.png') }}\'">' +
              '<span>' + user.name + '</span>' +
              '<button type="button" style="background: none; border: none; color: #1e40af; cursor: pointer; padding: 0; margin-left: 4px; font-size: 18px; line-height: 1; font-weight: 700;" data-idx="' + idx + '">×</button>';
            chipsPanel.appendChild(chip);
          });
          
          // Add remove handlers
          chipsPanel.querySelectorAll('button').forEach(function(btn) {
            btn.addEventListener('click', function() {
              var idx = parseInt(this.getAttribute('data-idx'));
              selectedUsers.splice(idx, 1);
              updateChipsDisplay();
              updateModalCheckboxes();
            });
          });
        }
      }
      
      function updateModalCheckboxes() {
        var checkboxes = document.querySelectorAll('.employee-card input[type="checkbox"]');
        checkboxes.forEach(function(cb) {
          var isSelected = selectedUsers.some(function(u) { return u.id == cb.value; });
          cb.checked = isSelected;
          var card = cb.closest('.employee-card');
          if (card) {
            card.classList.toggle('selected', isSelected);
          }
        });
        updateSelectedCount();
      }
      
      function updateSelectedCount() {
        var countEl = document.getElementById('selectedCount');
        if (countEl) {
          countEl.textContent = selectedUsers.length;
        }
        var confirmBtn = document.getElementById('btnConfirmSelection');
        if (confirmBtn) {
          confirmBtn.disabled = selectedUsers.length === 0;
        }
      }
      
      // Open modal
      var btnOpenModal = document.getElementById('btnOpenEmployeeModal');
      if (btnOpenModal) {
        btnOpenModal.addEventListener('click', function() {
          modal.style.display = 'flex';
          updateModalCheckboxes();
        });
      }
      
      // Close modal
      function closeModal() {
        modal.style.display = 'none';
        // Reset modal for create mode when closed
        resetModalForCreate();
      }
      
      document.getElementById('btnCloseModal').addEventListener('click', closeModal);
      document.getElementById('btnCancelModal').addEventListener('click', function() {
        closeModal();
        // Clear selections when canceling
        if (editingNoteId) {
          selectedUsers = [];
          updateModalCheckboxes();
        }
      });
      document.getElementById('modalOverlay').addEventListener('click', closeModal);
      
      // Employee card click
      document.querySelectorAll('.employee-card').forEach(function(card) {
        card.addEventListener('click', function(e) {
          if (e.target.tagName === 'INPUT') return;
          var checkbox = this.querySelector('input[type="checkbox"]');
          checkbox.checked = !checkbox.checked;
          checkbox.dispatchEvent(new Event('change'));
        });
      });
      
      // Checkbox change
      document.querySelectorAll('.employee-card input[type="checkbox"]').forEach(function(cb) {
        cb.addEventListener('change', function() {
          var card = this.closest('.employee-card');
          var userId = this.value;
          var userName = card.getAttribute('data-name');
          var userPhoto = allUsers.find(function(u) { return u.id == userId; })?.photo || '{{ asset('new_theme/dist/img/avatar.png') }}';
          
          if (this.checked) {
            if (!selectedUsers.some(function(u) { return u.id == userId; })) {
              selectedUsers.push({ id: userId, name: userName, photo: userPhoto });
            }
            card.classList.add('selected');
          } else {
            selectedUsers = selectedUsers.filter(function(u) { return u.id != userId; });
            card.classList.remove('selected');
          }
          updateSelectedCount();
        });
      });
      
      // Search employees
      var searchInput = document.getElementById('employeeSearch');
      if (searchInput) {
        searchInput.addEventListener('input', function() {
          var query = this.value.toLowerCase();
          document.querySelectorAll('.employee-card').forEach(function(card) {
            var name = card.getAttribute('data-name').toLowerCase();
            card.style.display = name.includes(query) ? '' : 'none';
          });
        });
      }
      
      // Confirm selection - handles both create and edit modes
      document.getElementById('btnConfirmSelection').addEventListener('click', function() {
        if (editingNoteId) {
          // We're editing an existing note's employees
          updateNoteEmployees();
        } else {
          // We're creating a new note - just update chips and close modal
          updateChipsDisplay();
          closeModal();
        }
      });
      
      // Save admin note handler
      var saveBtn = document.getElementById('btnSaveAdminNote');
      console.log('Save button found:', !!saveBtn);
      if (saveBtn) {
        saveBtn.addEventListener('click', function() {
          console.log('Save button clicked');
          var noteText = document.getElementById('adminNoteText');
          if (!noteText || !noteText.value.trim()) {
            alert('Please enter a note!');
            return;
          }
          
          if (selectedUsers.length === 0) {
            alert('Please assign at least one employee!');
            return;
          }
          
          // Disable button and show loading state
          var originalText = saveBtn.innerHTML;
          saveBtn.disabled = true;
          saveBtn.innerHTML = '⏳ Saving...';
          
          var csrfToken = document.querySelector('meta[name="csrf-token"]');
          if (!csrfToken) {
            alert('Error: CSRF token not found. Please refresh the page.');
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalText;
            return;
          }
          
          var requestData = {
            text: noteText.value.trim(),
            assignees: selectedUsers.map(function(u) { return parseInt(u.id, 10); })
          };
          
          console.log('Sending admin note:', requestData);
          
          // Send to backend via AJAX
          fetch('{{ route("admin.notes.store") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': csrfToken.content
            },
            body: JSON.stringify(requestData)
          })
          .then(function(response) {
            console.log('Response status:', response.status);
            if (!response.ok) {
              return response.text().then(function(text) {
                console.error('Error response:', text);
                throw new Error('HTTP ' + response.status + ': ' + text);
              });
            }
            return response.json();
          })
          .then(function(data) {
            console.log('Response data:', data);
            if (data.success) {
              alert(data.message || 'Admin note saved successfully! Employees will see this on their dashboard.');
              noteText.value = '';
              selectedUsers = [];
              updateChipsDisplay();
              
              // Display created notes
              if (data.notes && data.notes.length > 0) {
                displayAdminNotes(data.notes);
              }
              
              // Reload employee notes in both tabs
              if (typeof loadEmployeeNotes === 'function') loadEmployeeNotes();
              if (typeof loadAdminEmpNotes === 'function') loadAdminEmpNotes();
            } else {
              alert('Error: ' + (data.message || 'Failed to save note'));
            }
          })
          .catch(function(error) {
            console.error('Error saving admin note:', error);
            alert('Error: ' + error.message);
          })
          .finally(function() {
            // Re-enable button
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalText;
          });
        });
      }

      // Note functions are now defined globally above

      // Handler for "Add New Notes" button (first NOTES tab - system notes)
      var notesSendBtn = document.querySelector('.notes-send');
      console.log('Notes send button found:', !!notesSendBtn);
      if (notesSendBtn) {
        notesSendBtn.addEventListener('click', function() {
          var textarea = document.getElementById('systemNoteText');
          
          if (!textarea || !textarea.value.trim()) {
            alert('Please enter a note!');
            return;
          }
          
          var noteText = textarea.value.trim();
          var originalHtml = this.innerHTML;
          this.disabled = true;
          this.innerHTML = '⏳';
          
          var csrfToken = document.querySelector('meta[name="csrf-token"]');
          if (!csrfToken) {
            alert('Error: CSRF token not found. Please refresh the page.');
            this.disabled = false;
            this.innerHTML = originalHtml;
            return;
          }
          
          var self = this;
          
          // Send to backend - store as system note
          fetch('{{ route("employee.notes.store") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': csrfToken.content
            },
            body: JSON.stringify({
              note_text: noteText,
              note_type: 'notes'  // 'notes' = system type
            })
          })
          .then(function(response) {
            if (!response.ok) {
              return response.text().then(function(text) {
                throw new Error('HTTP ' + response.status + ': ' + text);
              });
            }
            return response.json();
          })
          .then(function(data) {
            if (data.success) {
              textarea.value = '';
              // Reload system notes to show the new note
              loadSystemNotes(1);
              if (window.toastr) {
                toastr.success('Note saved successfully!');
              } else {
                alert('Note saved successfully!');
              }
            } else {
              alert('Error: ' + (data.message || 'Failed to save note'));
            }
          })
          .catch(function(error) {
            console.error('Error saving note:', error);
            alert('Error: ' + error.message);
          })
          .finally(function() {
            self.disabled = false;
            self.innerHTML = originalHtml;
          });
        });
      }

      // Load notes on page load (only once)
      document.addEventListener('DOMContentLoaded', function() {
        if (!notesLoaded) {
          notesLoaded = true;
          // Load system notes for first NOTES tab
          loadSystemNotes(1);
          // Load employee notes for EMP. NOTES tab
          loadEmployeeNotes();
        }
      });
    }catch(e){
      console.error('Dashboard script error:', e);
    }
  })();
</script>
@endpush
