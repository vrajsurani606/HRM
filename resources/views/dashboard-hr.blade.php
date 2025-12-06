@extends('layouts.macos')

@section('page_title', 'HR Dashboard')

@push('styles')
<style>
  .hrp-content { background: #f7f4f1 !important; }
  
  /* HR KPI Cards */
  .hr-kpi-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    height: 100%;
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
  .hr-kpi-card.purple::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }
  .hr-kpi-card.cyan::before { background: linear-gradient(90deg, #06b6d4, #0891b2); }
  
  .hr-kpi-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
  }
  
  .hr-kpi-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
  }
  
  .hr-kpi-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
  }

  .hr-kpi-card.primary .hr-kpi-icon { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1e40af; }
  .hr-kpi-card.success .hr-kpi-icon { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; }
  .hr-kpi-card.warning .hr-kpi-icon { background: linear-gradient(135deg, #fed7aa, #fdba74); color: #92400e; }
  .hr-kpi-card.danger .hr-kpi-icon { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; }
  .hr-kpi-card.purple .hr-kpi-icon { background: linear-gradient(135deg, #ede9fe, #ddd6fe); color: #5b21b6; }
  .hr-kpi-card.cyan .hr-kpi-icon { background: linear-gradient(135deg, #cffafe, #a5f3fc); color: #0e7490; }
  
  .hr-kpi-value {
    font-size: 32px;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 6px;
    font-family: 'Visby', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  }
  
  .hr-kpi-card.primary .hr-kpi-value { color: #1e40af; }
  .hr-kpi-card.success .hr-kpi-value { color: #065f46; }
  .hr-kpi-card.warning .hr-kpi-value { color: #92400e; }
  .hr-kpi-card.danger .hr-kpi-value { color: #991b1b; }
  .hr-kpi-card.purple .hr-kpi-value { color: #5b21b6; }
  .hr-kpi-card.cyan .hr-kpi-value { color: #0e7490; }
  
  .hr-kpi-label {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .hr-kpi-sub {
    font-size: 11px;
    color: #94a3b8;
    margin-top: 4px;
  }

  /* Section Cards */
  .hr-section-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    height: 100%;
  }
  
  .hr-section-header {
    background: #414141;
    color: white;
    padding: 14px 20px;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  
  .hr-section-body {
    padding: 0;
    max-height: 320px;
    overflow-y: auto;
  }

  /* Leave Request Items */
  .hr-leave-item {
    padding: 14px 20px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: background 0.2s;
  }
  
  .hr-leave-item:hover { background: #f8fafc; }
  .hr-leave-item:last-child { border-bottom: none; }
  
  .hr-leave-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
  }
  
  .hr-leave-info { flex: 1; }
  
  .hr-leave-employee {
    font-size: 14px;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 2px;
  }
  
  .hr-leave-details {
    font-size: 12px;
    color: #64748b;
  }
  
  .hr-leave-badge {
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
  }
  
  .hr-leave-badge.pending { background: #fed7aa; color: #92400e; }
  .hr-leave-badge.approved { background: #d1fae5; color: #065f46; }
  .hr-leave-badge.rejected { background: #fee2e2; color: #991b1b; }

  /* Birthday & Anniversary Cards */
  .hr-person-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 20px;
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.2s;
  }
  
  .hr-person-item:hover {
    background: #f8fafc;
    transform: translateX(4px);
  }
  
  .hr-person-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e2e8f0;
  }
  
  .hr-person-info { flex: 1; }
  
  .hr-person-name {
    font-size: 14px;
    font-weight: 600;
    color: #0f172a;
  }
  
  .hr-person-sub {
    font-size: 12px;
    color: #64748b;
  }
  
  .hr-person-badge {
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
  }
  
  .hr-person-badge.birthday {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
  }
  
  .hr-person-badge.anniversary {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
  }

  /* Chart Card */
  .hr-chart-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    height: 100%;
  }
  
  .hr-chart-header {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  
  .hr-chart-bar { margin-bottom: 12px; }
  
  .hr-chart-label {
    display: flex;
    justify-content: space-between;
    margin-bottom: 6px;
    font-size: 12px;
  }
  
  .hr-chart-label-text { font-weight: 600; color: #475569; }
  .hr-chart-label-value { font-weight: 700; color: #0f172a; }
  
  .hr-chart-progress {
    height: 8px;
    background: #e2e8f0;
    border-radius: 4px;
    overflow: hidden;
  }
  
  .hr-chart-progress-bar {
    height: 100%;
    border-radius: 4px;
    transition: width 0.5s ease;
  }
  
  .hr-chart-progress-bar.blue { background: linear-gradient(90deg, #3b82f6, #2563eb); }
  .hr-chart-progress-bar.green { background: linear-gradient(90deg, #10b981, #059669); }
  .hr-chart-progress-bar.orange { background: linear-gradient(90deg, #f59e0b, #d97706); }
  .hr-chart-progress-bar.purple { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }

  /* Ticket Items */
  .hr-ticket-item {
    padding: 12px 20px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 12px;
  }
  
  .hr-ticket-item:hover { background: #f8fafc; }
  
  .hr-ticket-id {
    font-size: 11px;
    font-weight: 700;
    color: #3b82f6;
    background: #dbeafe;
    padding: 4px 8px;
    border-radius: 4px;
  }
  
  .hr-ticket-info { flex: 1; }
  
  .hr-ticket-subject {
    font-size: 13px;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px;
  }
  
  .hr-ticket-meta {
    font-size: 11px;
    color: #64748b;
  }
  
  .hr-ticket-status {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
  }
  
  .hr-ticket-status.open { background: #dbeafe; color: #1e40af; }
  .hr-ticket-status.pending { background: #fed7aa; color: #92400e; }
  .hr-ticket-status.in_progress { background: #cffafe; color: #0e7490; }
  .hr-ticket-status.closed { background: #d1fae5; color: #065f46; }

  /* Project Items */
  .hr-project-item {
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
  }
  
  .hr-project-item:hover { background: #f8fafc; }
  
  .hr-project-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
  }
  
  .hr-project-name {
    font-size: 13px;
    font-weight: 600;
    color: #0f172a;
  }
  
  .hr-project-company {
    font-size: 11px;
    color: #64748b;
  }
  
  .hr-project-priority {
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
  }
  
  .hr-project-priority.high { background: #fee2e2; color: #991b1b; }
  .hr-project-priority.normal { background: #dbeafe; color: #1e40af; }
  .hr-project-priority.low { background: #d1fae5; color: #065f46; }
  
  .hr-project-progress {
    height: 6px;
    background: #e2e8f0;
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 6px;
  }
  
  .hr-project-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #10b981, #059669);
    border-radius: 3px;
    transition: width 0.5s ease;
  }
  
  .hr-project-meta {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: #64748b;
  }
  
  .hr-project-overdue { color: #dc2626; font-weight: 600; }

  /* Activity Feed */
  .hr-activity-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 20px;
    border-bottom: 1px solid #f1f5f9;
  }
  
  .hr-activity-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
  }
  
  .hr-activity-content { flex: 1; }
  
  .hr-activity-text {
    font-size: 13px;
    color: #0f172a;
    margin-bottom: 2px;
  }
  
  .hr-activity-time {
    font-size: 11px;
    color: #94a3b8;
  }

  /* Attendance Breakdown */
  .hr-attendance-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    padding: 16px;
  }
  
  .hr-attendance-stat {
    text-align: center;
    padding: 12px;
    border-radius: 10px;
    background: #f8fafc;
  }
  
  .hr-attendance-stat-value {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 4px;
  }
  
  .hr-attendance-stat-label {
    font-size: 11px;
    color: #64748b;
    text-transform: uppercase;
  }
  
  .hr-attendance-stat.present .hr-attendance-stat-value { color: #059669; }
  .hr-attendance-stat.late .hr-attendance-stat-value { color: #d97706; }
  .hr-attendance-stat.absent .hr-attendance-stat-value { color: #dc2626; }
  .hr-attendance-stat.leave .hr-attendance-stat-value { color: #2563eb; }
  .hr-attendance-stat.half .hr-attendance-stat-value { color: #7c3aed; }
  .hr-attendance-stat.early .hr-attendance-stat-value { color: #0891b2; }

  /* Hiring Trend Mini Chart */
  .hr-hiring-chart {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    height: 80px;
    padding: 16px 20px;
  }
  
  .hr-hiring-bar {
    flex: 1;
    background: linear-gradient(180deg, #3b82f6, #2563eb);
    border-radius: 4px 4px 0 0;
    min-height: 8px;
    position: relative;
    transition: height 0.3s ease;
  }
  
  .hr-hiring-bar:hover {
    background: linear-gradient(180deg, #2563eb, #1d4ed8);
  }
  
  .hr-hiring-bar-label {
    position: absolute;
    bottom: -20px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 10px;
    color: #64748b;
  }
  
  .hr-hiring-bar-value {
    position: absolute;
    top: -18px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 11px;
    font-weight: 700;
    color: #1e40af;
  }

  /* Empty State */
  .hr-empty-state {
    padding: 30px 20px;
    text-align: center;
    color: #94a3b8;
  }
  
  .hr-empty-state-icon {
    font-size: 32px;
    margin-bottom: 8px;
  }
  
  .hr-empty-state-text {
    font-size: 13px;
  }

  /* Action Buttons */
  .hr-action-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-size: 14px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
  }
  
  .hr-action-btn.approve {
    background: #d1fae5;
    color: #059669;
  }
  
  .hr-action-btn.approve:hover {
    background: #059669;
    color: white;
    transform: scale(1.1);
  }
  
  .hr-action-btn.reject {
    background: #fee2e2;
    color: #dc2626;
  }
  
  .hr-action-btn.reject:hover {
    background: #dc2626;
    color: white;
    transform: scale(1.1);
  }

  /* Recent Leave History */
  .hr-leave-history-item {
    padding: 10px 16px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12px;
  }
  
  .hr-leave-history-item:last-child { border-bottom: none; }
  
  .hr-leave-history-avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    object-fit: cover;
  }

</style>
@endpush

@section('content')
<div class="hrp-grid" style="padding:14px">
  
  <!-- Row 1: Main KPI Cards -->
  <div class="hrp-col-3">
    <div class="hr-kpi-card primary">
      <div class="hr-kpi-header">
        <div class="hr-kpi-icon">👥</div>
      </div>
      <div class="hr-kpi-value">{{ $stats['total_employees'] }}</div>
      <div class="hr-kpi-label">Total Employees</div>
      <div class="hr-kpi-sub">{{ $stats['active_employees'] }} active</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="hr-kpi-card success">
      <div class="hr-kpi-header">
        <div class="hr-kpi-icon">✅</div>
      </div>
      <div class="hr-kpi-value">{{ $stats['present_today'] }}</div>
      <div class="hr-kpi-label">Present Today</div>
      <div class="hr-kpi-sub">{{ $stats['attendance_rate'] }}% attendance rate</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="hr-kpi-card warning">
      <div class="hr-kpi-header">
        <div class="hr-kpi-icon">📋</div>
      </div>
      <div class="hr-kpi-value">{{ $stats['pending_leaves'] }}</div>
      <div class="hr-kpi-label">Pending Leaves</div>
      <div class="hr-kpi-sub">{{ $stats['on_leave_today'] }} on leave today</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="hr-kpi-card danger">
      <div class="hr-kpi-header">
        <div class="hr-kpi-icon">❌</div>
      </div>
      <div class="hr-kpi-value">{{ $stats['absent_today'] }}</div>
      <div class="hr-kpi-label">Absent Today</div>
      <div class="hr-kpi-sub">{{ $stats['late_today'] }} late arrivals</div>
    </div>
  </div>

  <!-- Row 2: Secondary KPI Cards -->
  <div class="hrp-col-3">
    <div class="hr-kpi-card success">
      <div class="hr-kpi-header">
        <div class="hr-kpi-icon">🆕</div>
      </div>
      <div class="hr-kpi-value">{{ $stats['new_hires'] }}</div>
      <div class="hr-kpi-label">New Hires</div>
      <div class="hr-kpi-sub">This month</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="hr-kpi-card purple">
      <div class="hr-kpi-header">
        <div class="hr-kpi-icon">🎫</div>
      </div>
      <div class="hr-kpi-value">{{ $stats['open_tickets'] }}</div>
      <div class="hr-kpi-label">Open Tickets</div>
      <div class="hr-kpi-sub">Needs attention</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="hr-kpi-card cyan">
      <div class="hr-kpi-header">
        <div class="hr-kpi-icon">📁</div>
      </div>
      <div class="hr-kpi-value">{{ $stats['active_projects'] }}</div>
      <div class="hr-kpi-label">Active Projects</div>
      <div class="hr-kpi-sub">{{ $stats['total_projects'] }} total</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="hr-kpi-card primary">
      <div class="hr-kpi-header">
        <div class="hr-kpi-icon">💰</div>
      </div>
      <div class="hr-kpi-value">₹{{ number_format($stats['monthly_payroll'] / 1000, 0) }}K</div>
      <div class="hr-kpi-label">Monthly Payroll</div>
      <div class="hr-kpi-sub">{{ $stats['paid_employees'] }} employees paid</div>
    </div>
  </div>

  <!-- Row 3: Recent Leave Requests & Today's Attendance -->
  <div class="hrp-col-8">
    <div class="hr-section-card">
      <div class="hr-section-header">
        🏖️ Recent Leave Requests
        @if($stats['pending_leaves'] > 0)
          <span style="background:#f59e0b;color:#fff;padding:2px 8px;border-radius:10px;font-size:11px;margin-left:auto;">{{ $stats['pending_leaves'] }} pending</span>
        @endif
        <a href="{{ url('/leave-approval') }}" style="color:#fff;font-size:11px;margin-left:12px;text-decoration:none;opacity:0.8;">View All →</a>
      </div>
      <div class="hr-section-body">
        @forelse($recentLeaves as $leave)
          <div class="hr-leave-item">
            <img src="{{ $leave['photo'] }}" alt="{{ $leave['employee'] }}" class="hr-leave-avatar">
            <div class="hr-leave-info">
              <div class="hr-leave-employee">{{ $leave['employee'] }}</div>
              <div class="hr-leave-details">
                {{ $leave['type'] }} • {{ $leave['from'] }} - {{ $leave['to'] }} ({{ $leave['days'] }} {{ $leave['days'] == 1 ? 'day' : 'days' }})
              </div>
            </div>
            <span class="hr-leave-badge {{ $leave['status'] }}">{{ ucfirst($leave['status']) }}</span>
          </div>
        @empty
          <div class="hr-empty-state">
            <div class="hr-empty-state-icon">✅</div>
            <div class="hr-empty-state-text">No recent leave requests</div>
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <div class="hrp-col-4">
    <div class="hr-section-card">
      <div class="hr-section-header">
        📊 Today's Attendance
      </div>
      <div class="hr-attendance-grid">
        <div class="hr-attendance-stat present">
          <div class="hr-attendance-stat-value">{{ $attendanceBreakdown['present'] }}</div>
          <div class="hr-attendance-stat-label">Present</div>
        </div>
        <div class="hr-attendance-stat late">
          <div class="hr-attendance-stat-value">{{ $attendanceBreakdown['late'] }}</div>
          <div class="hr-attendance-stat-label">Late</div>
        </div>
        <div class="hr-attendance-stat absent">
          <div class="hr-attendance-stat-value">{{ $attendanceBreakdown['absent'] }}</div>
          <div class="hr-attendance-stat-label">Absent</div>
        </div>
        <div class="hr-attendance-stat leave">
          <div class="hr-attendance-stat-value">{{ $attendanceBreakdown['on_leave'] }}</div>
          <div class="hr-attendance-stat-label">On Leave</div>
        </div>
        <div class="hr-attendance-stat half">
          <div class="hr-attendance-stat-value">{{ $attendanceBreakdown['half_day'] }}</div>
          <div class="hr-attendance-stat-label">Half Day</div>
        </div>
        <div class="hr-attendance-stat early">
          <div class="hr-attendance-stat-value">{{ $attendanceBreakdown['early_leave'] }}</div>
          <div class="hr-attendance-stat-label">Early Leave</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Row 4: Birthdays & Work Anniversaries -->
  <div class="hrp-col-6">
    <div class="hr-section-card">
      <div class="hr-section-header">
        🎂 Upcoming Birthdays
      </div>
      <div class="hr-section-body">
        @forelse($upcomingBirthdays as $birthday)
          <div class="hr-person-item">
            <img src="{{ $birthday['photo'] }}" alt="{{ $birthday['name'] }}" class="hr-person-avatar">
            <div class="hr-person-info">
              <div class="hr-person-name">{{ $birthday['name'] }}</div>
              <div class="hr-person-sub">{{ $birthday['position'] }} • {{ $birthday['date'] }}</div>
            </div>
            <span class="hr-person-badge birthday">{{ $birthday['days_until'] }}d</span>
          </div>
        @empty
          <div class="hr-empty-state">
            <div class="hr-empty-state-icon">🎈</div>
            <div class="hr-empty-state-text">No upcoming birthdays</div>
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <div class="hrp-col-6">
    <div class="hr-section-card">
      <div class="hr-section-header">
        🏆 Work Anniversaries This Month
      </div>
      <div class="hr-section-body">
        @forelse($workAnniversaries as $anniversary)
          <div class="hr-person-item">
            <img src="{{ $anniversary['photo'] }}" alt="{{ $anniversary['name'] }}" class="hr-person-avatar">
            <div class="hr-person-info">
              <div class="hr-person-name">{{ $anniversary['name'] }}</div>
              <div class="hr-person-sub">{{ $anniversary['position'] }} • {{ $anniversary['date'] }}</div>
            </div>
            <span class="hr-person-badge anniversary">{{ $anniversary['years'] }} yrs</span>
          </div>
        @empty
          <div class="hr-empty-state">
            <div class="hr-empty-state-icon">🎉</div>
            <div class="hr-empty-state-text">No anniversaries this month</div>
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <!-- Row 5: Department Stats & Attendance Trends -->
  <div class="hrp-col-6">
    <div class="hr-chart-card">
      <div class="hr-chart-header">📊 Team Distribution</div>
      @php $colors = ['blue', 'green', 'orange', 'purple', 'blue']; @endphp
      @forelse($departmentStats as $idx => $dept)
        <div class="hr-chart-bar">
          <div class="hr-chart-label">
            <span class="hr-chart-label-text">{{ $dept->department ?? 'Other' }}</span>
            <span class="hr-chart-label-value">{{ $dept->count }}</span>
          </div>
          <div class="hr-chart-progress">
            <div class="hr-chart-progress-bar {{ $colors[$idx % count($colors)] }}" style="width: {{ $stats['total_employees'] > 0 ? ($dept->count / $stats['total_employees']) * 100 : 0 }}%"></div>
          </div>
        </div>
      @empty
        <div class="hr-empty-state">
          <div class="hr-empty-state-icon">📈</div>
          <div class="hr-empty-state-text">No department data available</div>
        </div>
      @endforelse
    </div>
  </div>

  <div class="hrp-col-6">
    <div class="hr-chart-card">
      <div class="hr-chart-header">📈 Attendance Trends (Last 7 Days)</div>
      @foreach($attendanceTrends as $trend)
        <div class="hr-chart-bar">
          <div class="hr-chart-label">
            <span class="hr-chart-label-text">{{ $trend['date'] }} ({{ $trend['full_date'] }})</span>
            <span class="hr-chart-label-value">{{ $trend['percentage'] }}%</span>
          </div>
          <div class="hr-chart-progress">
            <div class="hr-chart-progress-bar green" style="width: {{ $trend['percentage'] }}%"></div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <!-- Row 6: Recent Tickets & Active Projects -->
  <div class="hrp-col-6">
    <div class="hr-section-card">
      <div class="hr-section-header">
        🎫 Recent Tickets
      </div>
      <div class="hr-section-body">
        @forelse($recentTickets as $ticket)
          <div class="hr-ticket-item">
            <span class="hr-ticket-id">{{ $ticket['ticket_no'] }}</span>
            <div class="hr-ticket-info">
              <div class="hr-ticket-subject">{{ $ticket['subject'] }}</div>
              <div class="hr-ticket-meta">{{ $ticket['customer'] }} • {{ $ticket['assigned_to'] }}</div>
            </div>
            <span class="hr-ticket-status {{ str_replace(' ', '_', $ticket['status']) }}">{{ $ticket['status'] }}</span>
          </div>
        @empty
          <div class="hr-empty-state">
            <div class="hr-empty-state-icon">🎫</div>
            <div class="hr-empty-state-text">No recent tickets</div>
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <div class="hrp-col-6">
    <div class="hr-section-card">
      <div class="hr-section-header">
        📁 Active Projects
      </div>
      <div class="hr-section-body">
        @forelse($projectsList as $project)
          <div class="hr-project-item">
            <div class="hr-project-header">
              <div>
                <div class="hr-project-name">{{ $project['name'] }}</div>
                <div class="hr-project-company">{{ $project['company'] }}</div>
              </div>
              <span class="hr-project-priority {{ $project['priority'] }}">{{ $project['priority'] }}</span>
            </div>
            <div class="hr-project-progress">
              <div class="hr-project-progress-bar" style="width: {{ $project['progress'] }}%"></div>
            </div>
            <div class="hr-project-meta">
              <span>{{ $project['progress'] }}% complete</span>
              <span class="{{ $project['is_overdue'] ? 'hr-project-overdue' : '' }}">
                {{ $project['is_overdue'] ? '⚠️ ' : '' }}{{ $project['due_date'] }}
              </span>
            </div>
          </div>
        @empty
          <div class="hr-empty-state">
            <div class="hr-empty-state-icon">📂</div>
            <div class="hr-empty-state-text">No active projects</div>
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <!-- Row 7: Hiring Trend & Leave Type Distribution -->
  <div class="hrp-col-6">
    <div class="hr-chart-card">
      <div class="hr-chart-header">📈 Hiring Trend (Last 6 Months)</div>
      @php 
        $maxHires = collect($hiringTrend)->max('count') ?: 1;
      @endphp
      <div class="hr-hiring-chart">
        @foreach($hiringTrend as $month)
          <div class="hr-hiring-bar" style="height: {{ $maxHires > 0 ? ($month['count'] / $maxHires) * 100 : 10 }}%">
            <span class="hr-hiring-bar-value">{{ $month['count'] }}</span>
            <span class="hr-hiring-bar-label">{{ $month['month'] }}</span>
          </div>
        @endforeach
      </div>
      <div style="height: 30px;"></div>
    </div>
  </div>

  <div class="hrp-col-6">
    <div class="hr-chart-card">
      <div class="hr-chart-header">🏖️ Leave Type Distribution (This Year)</div>
      @php 
        $totalLeaves = $leaveTypeStats->sum('count') ?: 1;
        $leaveColors = ['blue', 'green', 'orange', 'purple'];
      @endphp
      @forelse($leaveTypeStats as $idx => $leaveType)
        <div class="hr-chart-bar">
          <div class="hr-chart-label">
            <span class="hr-chart-label-text">{{ $leaveType['type'] }}</span>
            <span class="hr-chart-label-value">{{ $leaveType['count'] }}</span>
          </div>
          <div class="hr-chart-progress">
            <div class="hr-chart-progress-bar {{ $leaveColors[$idx % count($leaveColors)] }}" style="width: {{ ($leaveType['count'] / $totalLeaves) * 100 }}%"></div>
          </div>
        </div>
      @empty
        <div class="hr-empty-state">
          <div class="hr-empty-state-icon">📊</div>
          <div class="hr-empty-state-text">No leave data available</div>
        </div>
      @endforelse
    </div>
  </div>

  <!-- Row 8: Recent Activities -->
  <div class="hrp-col-12">
    <div class="hr-section-card">
      <div class="hr-section-header">
        ⚡ Recent Activities
      </div>
      <div class="hr-section-body" style="display: flex; flex-wrap: wrap;">
        @forelse($recentActivities as $activity)
          <div class="hr-activity-item" style="flex: 0 0 50%; box-sizing: border-box;">
            <div class="hr-activity-icon">{{ $activity['icon'] }}</div>
            <div class="hr-activity-content">
              <div class="hr-activity-text">{{ $activity['title'] }}</div>
              <div class="hr-activity-time">{{ $activity['time'] }}</div>
            </div>
          </div>
        @empty
          <div class="hr-empty-state" style="width: 100%;">
            <div class="hr-empty-state-icon">📝</div>
            <div class="hr-empty-state-text">No recent activities</div>
          </div>
        @endforelse
      </div>
    </div>
  </div>

</div>
@endsection
