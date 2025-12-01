@extends('layouts.macos')

@section('page_title', 'HR Dashboard')

@push('styles')
<style>
  /* HR Dashboard Styles */
  .hrp-content {
    background: #f7f4f1 !important;
  }
  
  /* HR KPI Cards */
  .hr-kpi-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }
  
  .hr-kpi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
  }
  
  .hr-kpi-card.primary::before { background: linear-gradient(90deg, #3b82f6, #2563eb); }
  .hr-kpi-card.success::before { background: linear-gradient(90deg, #10b981, #059669); }
  .hr-kpi-card.warning::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
  .hr-kpi-card.danger::before { background: linear-gradient(90deg, #ef4444, #dc2626); }
  
  .hr-kpi-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
  }
  
  .hr-kpi-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
  }
  
  .hr-kpi-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .hr-kpi-card.primary .hr-kpi-icon {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
  }
  
  .hr-kpi-card.success .hr-kpi-icon {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
  }
  
  .hr-kpi-card.warning .hr-kpi-icon {
    background: linear-gradient(135deg, #fed7aa, #fdba74);
    color: #92400e;
  }
  
  .hr-kpi-card.danger .hr-kpi-icon {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
  }
  
  .hr-kpi-value {
    font-size: 36px;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 8px;
    font-family: 'Visby', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  }
  
  .hr-kpi-card.primary .hr-kpi-value { color: #1e40af; }
  .hr-kpi-card.success .hr-kpi-value { color: #065f46; }
  .hr-kpi-card.warning .hr-kpi-value { color: #92400e; }
  .hr-kpi-card.danger .hr-kpi-value { color: #991b1b; }
  
  .hr-kpi-label {
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .hr-kpi-trend {
    font-size: 12px;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  
  .hr-kpi-trend.up {
    background: #d1fae5;
    color: #065f46;
  }
  
  .hr-kpi-trend.down {
    background: #fee2e2;
    color: #991b1b;
  }
  
  /* Leave Requests Table */
  .hr-leave-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  }
  
  .hr-leave-header {
    background: #414141;
    color: white;
    padding: 16px 24px;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .hr-leave-body {
    padding: 0;
  }
  
  .hr-leave-item {
    padding: 20px 24px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: background 0.2s;
  }
  
  .hr-leave-item:hover {
    background: #f8fafc;
  }
  
  .hr-leave-item:last-child {
    border-bottom: none;
  }
  
  .hr-leave-info {
    flex: 1;
  }
  
  .hr-leave-employee {
    font-size: 15px;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 4px;
  }
  
  .hr-leave-details {
    font-size: 13px;
    color: #64748b;
  }
  
  .hr-leave-badge {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
  }
  
  .hr-leave-badge.pending {
    background: #fed7aa;
    color: #92400e;
  }
  
  .hr-leave-badge.approved {
    background: #d1fae5;
    color: #065f46;
  }
  
  .hr-leave-badge.rejected {
    background: #fee2e2;
    color: #991b1b;
  }
  
  /* Birthday Card */
  .hr-birthday-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  }
  
  .hr-birthday-header {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  
  .hr-birthday-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 12px;
    margin-bottom: 12px;
    background: #f8fafc;
    transition: all 0.2s;
  }
  
  .hr-birthday-item:hover {
    background: #f1f5f9;
    transform: translateX(4px);
  }
  
  .hr-birthday-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e2e8f0;
  }
  
  .hr-birthday-info {
    flex: 1;
  }
  
  .hr-birthday-name {
    font-size: 14px;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 2px;
  }
  
  .hr-birthday-date {
    font-size: 12px;
    color: #64748b;
  }
  
  .hr-birthday-badge {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
  }
  
  /* Chart Card */
  .hr-chart-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  }
  
  .hr-chart-header {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 20px;
  }
  
  .hr-chart-bar {
    margin-bottom: 16px;
  }
  
  .hr-chart-label {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-size: 13px;
  }
  
  .hr-chart-label-text {
    font-weight: 600;
    color: #475569;
  }
  
  .hr-chart-label-value {
    font-weight: 700;
    color: #0f172a;
  }
  
  .hr-chart-progress {
    height: 8px;
    background: #e2e8f0;
    border-radius: 4px;
    overflow: hidden;
  }
  
  .hr-chart-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #3b82f6, #2563eb);
    border-radius: 4px;
    transition: width 0.3s ease;
  }
</style>
@endpush

@section('content')
<div class="hrp-grid" style="padding:14px">
  <!-- KPI Cards Row 1 -->
  <div class="hrp-col-3">
    <div class="hr-kpi-card primary">
      <div class="hr-kpi-header">
        <div class="hr-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="hr-kpi-value">{{ $stats['total_employees'] }}</div>
      <div class="hr-kpi-label">Total Employees</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="hr-kpi-card success">
      <div class="hr-kpi-header">
        <div class="hr-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.7088 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18455 2.99721 7.13631 4.39828 5.49706C5.79935 3.85781 7.69279 2.71537 9.79619 2.24013C11.8996 1.7649 14.1003 1.98232 16.07 2.85999" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M22 4L12 14.01L9 11.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="hr-kpi-value">{{ $stats['present_today'] }}</div>
      <div class="hr-kpi-label">Present Today</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="hr-kpi-card warning">
      <div class="hr-kpi-header">
        <div class="hr-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 8V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 16H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="hr-kpi-value">{{ $stats['pending_leaves'] }}</div>
      <div class="hr-kpi-label">Pending Leaves</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="hr-kpi-card danger">
      <div class="hr-kpi-header">
        <div class="hr-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="hr-kpi-value">{{ $stats['absent_today'] }}</div>
      <div class="hr-kpi-label">Absent Today</div>
    </div>
  </div>

  <!-- KPI Cards Row 2 -->
  <div class="hrp-col-3">
    <div class="hr-kpi-card success">
      <div class="hr-kpi-header">
        <div class="hr-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 21V19C16 17.9391 15.5786 16.9217 14.8284 16.1716C14.0783 15.4214 13.0609 15 12 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M8.5 11C10.7091 11 12.5 9.20914 12.5 7C12.5 4.79086 10.7091 3 8.5 3C6.29086 3 4.5 4.79086 4.5 7C4.5 9.20914 6.29086 11 8.5 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M20 8V14M17 11H23" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="hr-kpi-value">{{ $stats['new_hires'] }}</div>
      <div class="hr-kpi-label">New Hires (Month)</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="hr-kpi-card primary">
      <div class="hr-kpi-header">
        <div class="hr-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="hr-kpi-value">{{ $stats['attendance_rate'] }}%</div>
      <div class="hr-kpi-label">Attendance Rate</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="hr-kpi-card warning">
      <div class="hr-kpi-header">
        <div class="hr-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="hr-kpi-value">{{ $stats['on_leave_today'] }}</div>
      <div class="hr-kpi-label">On Leave Today</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="hr-kpi-card success">
      <div class="hr-kpi-header">
        <div class="hr-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="hr-kpi-value">{{ $stats['active_employees'] }}</div>
      <div class="hr-kpi-label">Active Employees</div>
    </div>
  </div>

  <!-- Recent Leave Requests -->
  <div class="hrp-col-8">
    <div class="hr-leave-card">
      <div class="hr-leave-header">
        📋 Recent Leave Requests
      </div>
      <div class="hr-leave-body">
        @forelse($recentLeaves as $leave)
          <div class="hr-leave-item">
            <div class="hr-leave-info">
              <div class="hr-leave-employee">{{ $leave['employee'] }}</div>
              <div class="hr-leave-details">
                {{ $leave['type'] }} • {{ $leave['from'] }} - {{ $leave['to'] }} ({{ $leave['days'] }} days)
              </div>
            </div>
            <span class="hr-leave-badge {{ $leave['status'] }}">{{ ucfirst($leave['status']) }}</span>
          </div>
        @empty
          <div class="hr-leave-item">
            <div class="hr-leave-info">
              <div class="hr-leave-employee">No leave requests</div>
              <div class="hr-leave-details">All caught up!</div>
            </div>
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <!-- Upcoming Birthdays -->
  <div class="hrp-col-4">
    <div class="hr-birthday-card">
      <div class="hr-birthday-header">
        🎂 Upcoming Birthdays
      </div>
      @forelse($upcomingBirthdays as $birthday)
        <div class="hr-birthday-item">
          <img src="{{ $birthday['photo'] }}" alt="{{ $birthday['name'] }}" class="hr-birthday-avatar">
          <div class="hr-birthday-info">
            <div class="hr-birthday-name">{{ $birthday['name'] }}</div>
            <div class="hr-birthday-date">{{ $birthday['date'] }}</div>
          </div>
          <span class="hr-birthday-badge">{{ $birthday['days_until'] }}d</span>
        </div>
      @empty
        <div class="hr-birthday-item">
          <div class="hr-birthday-info">
            <div class="hr-birthday-name">No upcoming birthdays</div>
            <div class="hr-birthday-date">Next 30 days</div>
          </div>
        </div>
      @endforelse
    </div>
  </div>

  <!-- Department Stats -->
  <div class="hrp-col-6">
    <div class="hr-chart-card">
      <div class="hr-chart-header">📊 Department Distribution</div>
      @forelse($departmentStats as $dept)
        <div class="hr-chart-bar">
          <div class="hr-chart-label">
            <span class="hr-chart-label-text">{{ $dept->department }}</span>
            <span class="hr-chart-label-value">{{ $dept->count }}</span>
          </div>
          <div class="hr-chart-progress">
            <div class="hr-chart-progress-bar" style="width: {{ ($dept->count / $stats['total_employees']) * 100 }}%"></div>
          </div>
        </div>
      @empty
        <p style="color: #64748b; text-align: center; padding: 20px;">No department data available</p>
      @endforelse
    </div>
  </div>

  <!-- Attendance Trends -->
  <div class="hrp-col-6">
    <div class="hr-chart-card">
      <div class="hr-chart-header">📈 Attendance Trends (Last 7 Days)</div>
      @foreach($attendanceTrends as $trend)
        <div class="hr-chart-bar">
          <div class="hr-chart-label">
            <span class="hr-chart-label-text">{{ $trend['date'] }}</span>
            <span class="hr-chart-label-value">{{ $trend['percentage'] }}%</span>
          </div>
          <div class="hr-chart-progress">
            <div class="hr-chart-progress-bar" style="width: {{ $trend['percentage'] }}%"></div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
