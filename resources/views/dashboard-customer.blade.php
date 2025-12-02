@extends('layouts.macos')

@section('page_title', 'Customer Dashboard')

@push('styles')
<style>
  .hrp-content { background: #f7f4f1 !important; }
  
  /* Customer KPI Cards */
  .cust-kpi-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }
  
  .cust-kpi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
  }
  
  .cust-kpi-card.indigo::before { background: linear-gradient(90deg, #6366f1, #4f46e5); }
  .cust-kpi-card.emerald::before { background: linear-gradient(90deg, #10b981, #059669); }
  .cust-kpi-card.amber::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
  .cust-kpi-card.rose::before { background: linear-gradient(90deg, #f43f5e, #e11d48); }
  .cust-kpi-card.sky::before { background: linear-gradient(90deg, #0ea5e9, #0284c7); }
  .cust-kpi-card.violet::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }
  .cust-kpi-card.teal::before { background: linear-gradient(90deg, #14b8a6, #0d9488); }
  .cust-kpi-card.fuchsia::before { background: linear-gradient(90deg, #d946ef, #c026d3); }
  
  .cust-kpi-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
  }
  
  .cust-kpi-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
  }
  
  .cust-kpi-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .cust-kpi-card.indigo .cust-kpi-icon { background: linear-gradient(135deg, #e0e7ff, #c7d2fe); color: #3730a3; }
  .cust-kpi-card.emerald .cust-kpi-icon { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; }
  .cust-kpi-card.amber .cust-kpi-icon { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; }
  .cust-kpi-card.rose .cust-kpi-icon { background: linear-gradient(135deg, #ffe4e6, #fecdd3); color: #9f1239; }
  .cust-kpi-card.sky .cust-kpi-icon { background: linear-gradient(135deg, #e0f2fe, #bae6fd); color: #075985; }
  .cust-kpi-card.violet .cust-kpi-icon { background: linear-gradient(135deg, #ede9fe, #ddd6fe); color: #5b21b6; }
  .cust-kpi-card.teal .cust-kpi-icon { background: linear-gradient(135deg, #ccfbf1, #99f6e4); color: #115e59; }
  .cust-kpi-card.fuchsia .cust-kpi-icon { background: linear-gradient(135deg, #fae8ff, #f5d0fe); color: #86198f; }
  
  .cust-kpi-value {
    font-size: 36px;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 8px;
    font-family: 'Visby', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  }
  
  .cust-kpi-card.indigo .cust-kpi-value { color: #3730a3; }
  .cust-kpi-card.emerald .cust-kpi-value { color: #065f46; }
  .cust-kpi-card.amber .cust-kpi-value { color: #92400e; }
  .cust-kpi-card.rose .cust-kpi-value { color: #9f1239; }
  .cust-kpi-card.sky .cust-kpi-value { color: #075985; }
  .cust-kpi-card.violet .cust-kpi-value { color: #5b21b6; }
  .cust-kpi-card.teal .cust-kpi-value { color: #115e59; }
  .cust-kpi-card.fuchsia .cust-kpi-value { color: #86198f; }
  
  .cust-kpi-label {
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  /* Document Card */
  .cust-doc-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  }
  
  .cust-doc-header {
    background: #414141;
    color: white;
    padding: 16px 24px;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .cust-doc-item {
    padding: 20px 24px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: background 0.2s;
  }
  
  .cust-doc-item:hover { background: #f8fafc; }
  .cust-doc-item:last-child { border-bottom: none; }
  
  .cust-doc-info {
    flex: 1;
  }
  
  .cust-doc-number {
    font-size: 15px;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 4px;
  }
  
  .cust-doc-details {
    font-size: 13px;
    color: #64748b;
  }
  
  .cust-doc-amount {
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
    margin-right: 16px;
  }
  
  .cust-doc-badge {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
  }
  
  .cust-doc-badge.pending { background: #fef3c7; color: #92400e; }
  .cust-doc-badge.sent { background: #dbeafe; color: #1e40af; }
  .cust-doc-badge.approved { background: #d1fae5; color: #065f46; }
  .cust-doc-badge.paid { background: #d1fae5; color: #065f46; }
  .cust-doc-badge.overdue { background: #fee2e2; color: #991b1b; }
  .cust-doc-badge.rejected { background: #fee2e2; color: #991b1b; }
  
  /* Project Card */
  .cust-project-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border-left: 4px solid #6366f1;
    position: relative;
  }
  
  .cust-project-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.2);
    border-left-color: #4f46e5;
  }
  
  .cust-project-card:active {
    transform: translateY(-2px);
  }
  
  .cust-project-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 12px;
  }
  
  .cust-project-name {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
  }
  
  .cust-project-status {
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    background: #d1fae5;
    color: #065f46;
  }
  
  .cust-project-dates {
    font-size: 13px;
    color: #64748b;
    margin-bottom: 12px;
  }
  
  .cust-project-progress {
    margin-top: 12px;
  }
  
  .cust-progress-label {
    display: flex;
    justify-content: space-between;
    margin-bottom: 6px;
    font-size: 12px;
    font-weight: 600;
    color: #475569;
  }
  
  .cust-progress-bar {
    height: 8px;
    background: #e2e8f0;
    border-radius: 4px;
    overflow: hidden;
  }
  
  .cust-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #6366f1, #4f46e5);
    border-radius: 4px;
    transition: width 0.3s ease;
  }
</style>
@endpush


@section('content')
<div class="hrp-grid" style="padding:14px">
  <!-- Welcome Banner -->
  @if($company)
  <div class="hrp-col-12">
    <div style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border-radius: 16px; padding: 32px; color: white; box-shadow: 0 4px 16px rgba(99, 102, 241, 0.3);">
      <h2 style="font-size: 28px; font-weight: 700; margin: 0 0 8px 0;">Welcome back, {{ auth()->user()->name }}!</h2>
      <p style="font-size: 16px; opacity: 0.9; margin: 0;">{{ $company->company_name }} - Here's an overview of your account and recent activity</p>
    </div>
  </div>
  @else
  <div class="hrp-col-12">
    <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 16px; padding: 32px; color: white; box-shadow: 0 4px 16px rgba(245, 158, 11, 0.3);">
      <h2 style="font-size: 28px; font-weight: 700; margin: 0 0 8px 0;">⚠️ Account Not Linked</h2>
      <p style="font-size: 16px; opacity: 0.9; margin: 0;">Your account is not linked to a company. Please contact the administrator to link your account to view your projects, quotations, and invoices.</p>
    </div>
  </div>
  @endif

  <!-- KPI Cards Row 1 -->
  <div class="hrp-col-3">
    <div class="cust-kpi-card indigo">
      <div class="cust-kpi-header">
        <div class="cust-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M14 2V8H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M16 13H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M16 17H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M10 9H9H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="cust-kpi-value">{{ $stats['total_quotations'] }}</div>
      <div class="cust-kpi-label">Total Quotations</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="cust-kpi-card amber">
      <div class="cust-kpi-header">
        <div class="cust-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="cust-kpi-value">{{ $stats['pending_quotations'] }}</div>
      <div class="cust-kpi-label">Pending Quotations</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="cust-kpi-card sky">
      <div class="cust-kpi-header">
        <div class="cust-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M14 2V8H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 18V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M9 15L12 12L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="cust-kpi-value">{{ $stats['total_invoices'] }}</div>
      <div class="cust-kpi-label">Total Invoices</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="cust-kpi-card rose">
      <div class="cust-kpi-header">
        <div class="cust-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 1V23" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M17 5H9.5C8.57174 5 7.6815 5.36875 7.02513 6.02513C6.36875 6.6815 6 7.57174 6 8.5C6 9.42826 6.36875 10.3185 7.02513 10.9749C7.6815 11.6313 8.57174 12 9.5 12H14.5C15.4283 12 16.3185 12.3687 16.9749 13.0251C17.6313 13.6815 18 14.5717 18 15.5C18 16.4283 17.6313 17.3185 16.9749 17.9749C16.3185 18.6313 15.4283 19 14.5 19H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="cust-kpi-value">{{ $stats['pending_payments'] }}</div>
      <div class="cust-kpi-label">Pending Payments</div>
    </div>
  </div>


  <!-- KPI Cards Row 2 -->
  <div class="hrp-col-3">
    <div class="cust-kpi-card emerald">
      <div class="cust-kpi-header">
        <div class="cust-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22 19C22 19.5304 21.7893 20.0391 21.4142 20.4142C21.0391 20.7893 20.5304 21 20 21H4C3.46957 21 2.96086 20.7893 2.58579 20.4142C2.21071 20.0391 2 19.5304 2 19V5C2 4.46957 2.21071 3.96086 2.58579 3.58579C2.96086 3.21071 3.46957 3 4 3H9L11 6H20C20.5304 6 21.0391 6.21071 21.4142 6.58579C21.7893 6.96086 22 7.46957 22 8V19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="cust-kpi-value">{{ $stats['total_projects'] }}</div>
      <div class="cust-kpi-label">Total Projects</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="cust-kpi-card violet">
      <div class="cust-kpi-header">
        <div class="cust-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 11L12 14L22 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M21 12V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="cust-kpi-value">{{ $stats['active_projects'] }}</div>
      <div class="cust-kpi-label">Active Projects</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="cust-kpi-card teal">
      <div class="cust-kpi-header">
        <div class="cust-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21 15C21 15.5304 20.7893 16.0391 20.4142 16.4142C20.0391 16.7893 19.5304 17 19 17H7L3 21V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="cust-kpi-value">{{ $stats['open_tickets'] }}</div>
      <div class="cust-kpi-label">Open Tickets</div>
    </div>
  </div>

  <div class="hrp-col-3">
    <div class="cust-kpi-card fuchsia">
      <div class="cust-kpi-header">
        <div class="cust-kpi-icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <line x1="12" y1="1" x2="12" y2="23" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M17 5H9.5C8.57174 5 7.6815 5.36875 7.02513 6.02513C6.36875 6.6815 6 7.57174 6 8.5C6 9.42826 6.36875 10.3185 7.02513 10.9749C7.6815 11.6313 8.57174 12 9.5 12H14.5C15.4283 12 16.3185 12.3687 16.9749 13.0251C17.6313 13.6815 18 14.5717 18 15.5C18 16.4283 17.6313 17.3185 16.9749 17.9749C16.3185 18.6313 15.4283 19 14.5 19H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
      <div class="cust-kpi-value">${{ $stats['total_spent'] }}</div>
      <div class="cust-kpi-label">Total Spent</div>
    </div>
  </div>

  <!-- Recent Quotations -->
  <div class="hrp-col-6">
    <div class="cust-doc-card">
      <div class="cust-doc-header">
        📄 Recent Quotations
      </div>
      <div>
        @forelse($recentQuotations as $quot)
          <div class="cust-doc-item">
            <div class="cust-doc-info">
              <div class="cust-doc-number">{{ $quot['number'] }}</div>
              <div class="cust-doc-details">{{ $quot['date'] }} • Valid until: {{ $quot['valid_until'] }}</div>
            </div>
            <div class="cust-doc-amount">${{ $quot['amount'] }}</div>
            <span class="cust-doc-badge {{ $quot['status'] }}">{{ ucfirst($quot['status']) }}</span>
          </div>
        @empty
          <div class="cust-doc-item">
            <div class="cust-doc-info">
              <div class="cust-doc-number">No quotations yet</div>
              <div class="cust-doc-details">Your quotations will appear here</div>
            </div>
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <!-- Recent Invoices -->
  <div class="hrp-col-6">
    <div class="cust-doc-card">
      <div class="cust-doc-header">
        💰 Recent Invoices
      </div>
      <div>
        @forelse($recentInvoices as $inv)
          <div class="cust-doc-item">
            <div class="cust-doc-info">
              <div class="cust-doc-number">{{ $inv['number'] }}</div>
              <div class="cust-doc-details">{{ $inv['date'] }} • Due: {{ $inv['due_date'] }}</div>
            </div>
            <div class="cust-doc-amount">${{ $inv['amount'] }}</div>
            <span class="cust-doc-badge {{ $inv['status'] }}">{{ ucfirst($inv['status']) }}</span>
          </div>
        @empty
          <div class="cust-doc-item">
            <div class="cust-doc-info">
              <div class="cust-doc-number">No invoices yet</div>
              <div class="cust-doc-details">Your invoices will appear here</div>
            </div>
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <!-- Active Projects -->
  <div class="hrp-col-12">
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); margin-bottom: 12px;">
      <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0 0 20px 0;">🚀 Active Projects</h3>
      <div class="hrp-grid">
        @forelse($activeProjectsList as $project)
          <div class="hrp-col-6">
            <a href="{{ route('projects.overview', $project['id']) }}" style="text-decoration: none; color: inherit; display: block;">
              <div class="cust-project-card" style="cursor: pointer; transition: all 0.3s ease;">
                <div class="cust-project-header">
                  <div class="cust-project-name">{{ $project['name'] }}</div>
                  <span class="cust-project-status">{{ ucfirst($project['status']) }}</span>
                </div>
                <div class="cust-project-dates">
                  📅 {{ $project['start_date'] }} → {{ $project['end_date'] }}
                </div>
                <div class="cust-project-progress">
                  <div class="cust-progress-label">
                    <span>Progress</span>
                    <span>{{ $project['progress'] }}%</span>
                  </div>
                  <div class="cust-progress-bar">
                    <div class="cust-progress-fill" style="width: {{ $project['progress'] }}%"></div>
                  </div>
                </div>
                <div style="margin-top: 12px; text-align: right; color: #6366f1; font-size: 13px; font-weight: 600;">
                  View Details →
                </div>
              </div>
            </a>
          </div>
        @empty
          <div class="hrp-col-12">
            <p style="text-align: center; color: #64748b; padding: 40px 0;">No active projects at the moment</p>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection
