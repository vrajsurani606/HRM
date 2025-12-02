@extends('layouts.macos')

@section('page_title', 'Receptionist Dashboard')

@push('styles')
<style>
  .hrp-content { background: #f7f4f1 !important; }
  
  /* Receptionist KPI Cards */
  .rec-kpi-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }
  
  .rec-kpi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
  }
  
  .rec-kpi-card.purple::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }
  .rec-kpi-card.blue::before { background: linear-gradient(90deg, #3b82f6, #2563eb); }
  .rec-kpi-card.green::before { background: linear-gradient(90deg, #10b981, #059669); }
  .rec-kpi-card.orange::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
  .rec-kpi-card.pink::before { background: linear-gradient(90deg, #ec4899, #db2777); }
  .rec-kpi-card.cyan::before { background: linear-gradient(90deg, #06b6d4, #0891b2); }
  
  .rec-kpi-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
  }
  
  .rec-kpi-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
  }
  
  .rec-kpi-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .rec-kpi-card.purple .rec-kpi-icon { background: linear-gradient(135deg, #ede9fe, #ddd6fe); color: #6b21a8; }
  .rec-kpi-card.blue .rec-kpi-icon { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1e40af; }
  .rec-kpi-card.green .rec-kpi-icon { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; }
  .rec-kpi-card.orange .rec-kpi-icon { background: linear-gradient(135deg, #fed7aa, #fdba74); color: #92400e; }
  .rec-kpi-card.pink .rec-kpi-icon { background: linear-gradient(135deg, #fce7f3, #fbcfe8); color: #9f1239; }
  .rec-kpi-card.cyan .rec-kpi-icon { background: linear-gradient(135deg, #cffafe, #a5f3fc); color: #164e63; }
  
  .rec-kpi-value {
    font-size: 36px;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 8px;
    font-family: 'Visby', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  }
  
  .rec-kpi-card.purple .rec-kpi-value { color: #6b21a8; }
  .rec-kpi-card.blue .rec-kpi-value { color: #1e40af; }
  .rec-kpi-card.green .rec-kpi-value { color: #065f46; }
  .rec-kpi-card.orange .rec-kpi-value { color: #92400e; }
  .rec-kpi-card.pink .rec-kpi-value { color: #9f1239; }
  .rec-kpi-card.cyan .rec-kpi-value { color: #164e63; }
  
  .rec-kpi-label {
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  /* Inquiry Card */
  .rec-inquiry-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  }
  
  .rec-inquiry-header {
    background: #414141;
    color: white;
    padding: 16px 24px;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .rec-inquiry-item {
    padding: 20px 24px;
    border-bottom: 1px solid #e2e8f0;
    transition: background 0.2s;
  }
  
  .rec-inquiry-item:hover { background: #f8fafc; }
  .rec-inquiry-item:last-child { border-bottom: none; }
  
  .rec-inquiry-top {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 8px;
  }
  
  .rec-inquiry-company {
    font-size: 15px;
    font-weight: 600;
    color: #0f172a;
  }
  
  .rec-inquiry-badge {
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
  }
  
  .rec-inquiry-badge.new { background: #dbeafe; color: #1e40af; }
  .rec-inquiry-badge.pending { background: #fed7aa; color: #92400e; }
  .rec-inquiry-badge.follow_up { background: #fef3c7; color: #92400e; }
  .rec-inquiry-badge.converted { background: #d1fae5; color: #065f46; }
  
  .rec-inquiry-details {
    font-size: 13px;
    color: #64748b;
    line-height: 1.6;
  }
  
  /* Follow-up Card */
  .rec-followup-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  }
  
  .rec-followup-header {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  
  .rec-followup-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    border-radius: 12px;
    margin-bottom: 12px;
    background: #f8fafc;
    border-left: 4px solid #f59e0b;
    transition: all 0.2s;
  }
  
  .rec-followup-item:hover {
    background: #f1f5f9;
    transform: translateX(4px);
  }
  
  .rec-followup-time {
    background: linear-gradient(135deg, #fed7aa, #fdba74);
    color: #92400e;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    min-width: 80px;
    text-align: center;
  }
  
  .rec-followup-info {
    flex: 1;
  }
  
  .rec-followup-company {
    font-size: 14px;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 4px;
  }
  
  .rec-followup-person {
    font-size: 13px;
    color: #64748b;
  }
  
  /* Chart Card */
  .rec-chart-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  }
  
  .rec-chart-header {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 20px;
  }
  
  .rec-chart-bar {
    margin-bottom: 16px;
  }
  
  .rec-chart-label {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-size: 13px;
  }
  
  .rec-chart-label-text {
    font-weight: 600;
    color: #475569;
  }
  
  .rec-chart-label-value {
    font-weight: 700;
    color: #0f172a;
  }
  
  .rec-chart-progress {
    height: 8px;
    background: #e2e8f0;
    border-radius: 4px;
    overflow: hidden;
  }
  
  .rec-chart-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #8b5cf6, #7c3aed);
    border-radius: 4px;
    transition: width 0.3s ease;
  }
</style>
@endpush


@section('content')
<div class="hrp-grid" style="padding:14px">
  <!-- KPI Cards Row 1 -->
  <div class="hrp-col-3">
    <div class="rec-kpi-card purple">
      <div class="rec-kpi-header">
        <div class="rec-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21 15C21 15.5304 20.7893 16.0391 20.4142 16.4142C20.0391 16.7893 19.5304 17 19 17H7L3 21V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="rec-kpi-value">{{ $stats['today_inquiries'] }}</div>
      <div class="rec-kpi-label">Today's Inquiries</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="rec-kpi-card orange">
      <div class="rec-kpi-header">
        <div class="rec-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="rec-kpi-value">{{ $stats['pending_inquiries'] }}</div>
      <div class="rec-kpi-label">Pending Inquiries</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="rec-kpi-card blue">
      <div class="rec-kpi-header">
        <div class="rec-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="rec-kpi-value">{{ $stats['visitors_today'] }}</div>
      <div class="rec-kpi-label">Visitors Today</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="rec-kpi-card green">
      <div class="rec-kpi-header">
        <div class="rec-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 11L12 14L22 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M21 12V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="rec-kpi-value">{{ $stats['active_tickets'] }}</div>
      <div class="rec-kpi-label">Active Tickets</div>
    </div>
  </div>


  <!-- KPI Cards Row 2 -->
  <div class="hrp-col-3">
    <div class="rec-kpi-card pink">
      <div class="rec-kpi-header">
        <div class="rec-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="rec-kpi-value">{{ $stats['appointments_today'] }}</div>
      <div class="rec-kpi-label">Appointments Today</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="rec-kpi-card cyan">
      <div class="rec-kpi-header">
        <div class="rec-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22 16.92V19.92C22.0011 20.1985 21.9441 20.4742 21.8325 20.7293C21.7209 20.9845 21.5573 21.2136 21.3521 21.4019C21.1468 21.5901 20.9046 21.7335 20.6407 21.8227C20.3769 21.9119 20.0974 21.9451 19.82 21.92C16.7428 21.5856 13.787 20.5341 11.19 18.85C8.77382 17.3147 6.72533 15.2662 5.18999 12.85C3.49997 10.2412 2.44824 7.27099 2.11999 4.18C2.095 3.90347 2.12787 3.62476 2.21649 3.36162C2.30512 3.09849 2.44756 2.85669 2.63476 2.65162C2.82196 2.44655 3.0498 2.28271 3.30379 2.17052C3.55777 2.05833 3.83233 2.00026 4.10999 2H7.10999C7.5953 1.99522 8.06579 2.16708 8.43376 2.48353C8.80173 2.79999 9.04207 3.23945 9.10999 3.72C9.23662 4.68007 9.47144 5.62273 9.80999 6.53C9.94454 6.88792 9.97366 7.27691 9.8939 7.65088C9.81415 8.02485 9.62886 8.36811 9.35999 8.64L8.08999 9.91C9.51355 12.4135 11.5864 14.4864 14.09 15.91L15.36 14.64C15.6319 14.3711 15.9751 14.1858 16.3491 14.1061C16.7231 14.0263 17.1121 14.0555 17.47 14.19C18.3773 14.5286 19.3199 14.7634 20.28 14.89C20.7658 14.9585 21.2094 15.2032 21.5265 15.5775C21.8437 15.9518 22.0122 16.4296 22 16.92Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="rec-kpi-value">{{ $stats['calls_today'] }}</div>
      <div class="rec-kpi-label">Calls Handled</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="rec-kpi-card purple">
      <div class="rec-kpi-header">
        <div class="rec-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 8V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 16H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="rec-kpi-value">{{ $stats['follow_up_today'] }}</div>
      <div class="rec-kpi-label">Follow-ups Today</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="rec-kpi-card blue">
      <div class="rec-kpi-header">
        <div class="rec-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21 15C21 15.5304 20.7893 16.0391 20.4142 16.4142C20.0391 16.7893 19.5304 17 19 17H7L3 21V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="rec-kpi-value">{{ $stats['total_inquiries_month'] }}</div>
      <div class="rec-kpi-label">Inquiries (Month)</div>
    </div>
  </div>


  <!-- Recent Inquiries -->
  <div class="hrp-col-8">
    <div class="rec-inquiry-card">
      <div class="rec-inquiry-header">
        📞 Recent Inquiries
      </div>
      <div>
        @forelse($recentInquiries as $inquiry)
          <div class="rec-inquiry-item">
            <div class="rec-inquiry-top">
              <div class="rec-inquiry-company">{{ $inquiry['company'] }}</div>
              <span class="rec-inquiry-badge {{ $inquiry['status'] }}">{{ ucfirst($inquiry['status']) }}</span>
            </div>
            <div class="rec-inquiry-details">
              <strong>{{ $inquiry['person'] }}</strong> • {{ $inquiry['phone'] }}<br>
              Next Follow-up: {{ $inquiry['next_followup'] }} • {{ $inquiry['time'] }}
            </div>
          </div>
        @empty
          <div class="rec-inquiry-item">
            <div class="rec-inquiry-company">No inquiries yet</div>
            <div class="rec-inquiry-details">Start adding inquiries to see them here</div>
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <!-- Today's Follow-ups -->
  <div class="hrp-col-4">
    <div class="rec-followup-card">
      <div class="rec-followup-header">
        ⏰ Today's Follow-ups
      </div>
      @forelse($todayFollowUps as $followup)
        <div class="rec-followup-item">
          <div class="rec-followup-time">{{ $followup['time'] }}</div>
          <div class="rec-followup-info">
            <div class="rec-followup-company">{{ $followup['company'] }}</div>
            <div class="rec-followup-person">{{ $followup['person'] }} • {{ $followup['phone'] }}</div>
          </div>
        </div>
      @empty
        <div class="rec-followup-item">
          <div class="rec-followup-info">
            <div class="rec-followup-company">No follow-ups scheduled</div>
            <div class="rec-followup-person">All clear for today!</div>
          </div>
        </div>
      @endforelse
    </div>
  </div>

  <!-- Inquiry Trends -->
  <div class="hrp-col-12">
    <div class="rec-chart-card">
      <div class="rec-chart-header">📊 Inquiry Trends (Last 7 Days)</div>
      @php
        $maxCount = max(array_column($inquiryTrends, 'count')) ?: 1;
      @endphp
      @foreach($inquiryTrends as $trend)
        <div class="rec-chart-bar">
          <div class="rec-chart-label">
            <span class="rec-chart-label-text">{{ $trend['date'] }}</span>
            <span class="rec-chart-label-value">{{ $trend['count'] }}</span>
          </div>
          <div class="rec-chart-progress">
            <div class="rec-chart-progress-bar" style="width: {{ ($trend['count'] / $maxCount) * 100 }}%"></div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
