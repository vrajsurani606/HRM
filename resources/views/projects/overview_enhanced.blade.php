@extends('layouts.macos')
@section('page_title', 'Project Overview')
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.css">
<style>
/* Project Overview Styles */
.project-overview {
  padding: 20px;
  background: #f9fafb;
  min-height: 100vh;
}

.overview-header {
  background: white;
  border-radius: 12px;
  padding: 24px;
  margin-bottom: 24px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.overview-title {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 16px;
}

.overview-title h1 {
  font-size: 28px;
  font-weight: 700;
  color: #1f2937;
  margin: 0;
}

.overview-actions {
  display: flex;
  gap: 12px;
}

.overview-btn {
  padding: 10px 20px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  border: none;
}

.overview-btn-primary {
  background: #3b82f6;
  color: white;
}

.overview-btn-primary:hover {
  background: #2563eb;
}

.overview-btn-secondary {
  background: white;
  color: #6b7280;
  border: 1px solid #e5e7eb;
}

.overview-btn-secondary:hover {
  background: #f9fafb;
}

.overview-meta {
  display: flex;
  gap: 32px;
  flex-wrap: wrap;
}

.meta-item {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #6b7280;
  font-size: 14px;
}

.meta-item svg {
  color: #9ca3af;
}

.meta-value {
  font-weight: 600;
  color: #1f2937;
}

/* Stats Cards */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 20px;
  margin-bottom: 24px;
}

.stat-card {
  background: white;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  transition: transform 0.2s;
}

.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
}

.stat-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 12px;
}

.stat-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.stat-icon.blue { background: #eff6ff; color: #3b82f6; }
.stat-icon.green { background: #f0fdf4; color: #10b981; }
.stat-icon.orange { background: #fff7ed; color: #f59e0b; }
.stat-icon.purple { background: #f5f3ff; color: #8b5cf6; }

.stat-value {
  font-size: 32px;
  font-weight: 700;
  color: #1f2937;
  margin-bottom: 4px;
}

.stat-label {
  font-size: 14px;
  color: #6b7280;
}

.stat-change {
  font-size: 12px;
  font-weight: 600;
  padding: 4px 8px;
  border-radius: 12px;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

.stat-change.positive {
  background: #f0fdf4;
  color: #10b981;
}

.stat-change.negative {
  background: #fef2f2;
  color: #ef4444;
}

/* Tabs */
.overview-tabs {
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  margin-bottom: 24px;
}

.tab-nav {
  display: flex;
  border-bottom: 2px solid #f3f4f6;
  padding: 0 24px;
  overflow-x: auto;
}

.tab-btn {
  padding: 16px 24px;
  font-size: 14px;
  font-weight: 600;
  color: #6b7280;
  background: none;
  border: none;
  border-bottom: 3px solid transparent;
  cursor: pointer;
  transition: all 0.2s;
  white-space: nowrap;
}

.tab-btn:hover {
  color: #3b82f6;
}

.tab-btn.active {
  color: #3b82f6;
  border-bottom-color: #3b82f6;
}

.tab-content {
  padding: 24px;
  display: none;
}

.tab-content.active {
  display: block;
}

/* Charts */
.charts-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
  gap: 20px;
  margin-bottom: 24px;
}

.chart-card {
  background: white;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.chart-header {
  margin-bottom: 16px;
}

.chart-title {
  font-size: 16px;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 4px 0;
}

.chart-subtitle {
  font-size: 13px;
  color: #6b7280;
  margin: 0;
}

.chart-container {
  position: relative;
  height: 300px;
}

/* Timeline */
.timeline {
  position: relative;
  padding-left: 32px;
}

.timeline::before {
  content: '';
  position: absolute;
  left: 8px;
  top: 0;
  bottom: 0;
  width: 2px;
  background: #e5e7eb;
}

.timeline-item {
  position: relative;
  padding-bottom: 24px;
}

.timeline-dot {
  position: absolute;
  left: -28px;
  top: 4px;
  width: 16px;
  height: 16px;
  border-radius: 50%;
  border: 3px solid white;
  box-shadow: 0 0 0 2px #3b82f6;
  background: #3b82f6;
}

.timeline-content {
  background: #f9fafb;
  padding: 12px 16px;
  border-radius: 8px;
}

.timeline-title {
  font-size: 14px;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 4px 0;
}

.timeline-desc {
  font-size: 13px;
  color: #6b7280;
  margin: 0 0 8px 0;
}

.timeline-meta {
  font-size: 12px;
  color: #9ca3af;
}

/* Team Members */
.team-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 16px;
}

.team-card {
  background: #f9fafb;
  border-radius: 12px;
  padding: 16px;
  text-align: center;
  transition: all 0.2s;
}

.team-card:hover {
  background: white;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.team-avatar {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  background: #3b82f6;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  font-weight: 600;
  margin: 0 auto 12px;
}

.team-name {
  font-size: 14px;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 4px 0;
}

.team-role {
  font-size: 12px;
  color: #6b7280;
  margin: 0;
}

/* Files */
.files-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.file-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px;
  background: #f9fafb;
  border-radius: 8px;
  transition: all 0.2s;
}

.file-item:hover {
  background: white;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.file-icon {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #eff6ff;
  color: #3b82f6;
}

.file-info {
  flex: 1;
}

.file-name {
  font-size: 14px;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 4px 0;
}

.file-meta {
  font-size: 12px;
  color: #6b7280;
}

.file-actions {
  display: flex;
  gap: 8px;
}

.file-btn {
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
  border: 1px solid #e5e7eb;
  background: white;
  color: #6b7280;
}

.file-btn:hover {
  border-color: #3b82f6;
  color: #3b82f6;
}

/* Responsive */
@media (max-width: 768px) {
  .stats-grid {
    grid-template-columns: 1fr;
  }
  
  .charts-grid {
    grid-template-columns: 1fr;
  }
  
  .overview-title {
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
  }
}
</style>
@endpush

@section('content')
<div class="project-overview">
  <!-- Header -->
  <div class="overview-header">
    <div class="overview-title">
      <div>
        <h1 id="projectName">Loading...</h1>
        <div class="overview-meta">
          <div class="meta-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
              <line x1="16" y1="2" x2="16" y2="6"></line>
              <line x1="8" y1="2" x2="8" y2="6"></line>
              <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <span>Due: <span class="meta-value" id="projectDueDate">-</span></span>
          </div>
          <div class="meta-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span><span class="meta-value" id="projectMembers">0</span> Members</span>
          </div>
          <div class="meta-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
            </svg>
            <span>Status: <span class="meta-value" id="projectStatus">-</span></span>
          </div>
        </div>
      </div>
      <div class="overview-actions">
        <button class="overview-btn overview-btn-secondary" onclick="window.location.href='{{ route('projects.index') }}'">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
          </svg>
          Back to Projects
        </button>
        <button class="overview-btn overview-btn-primary" onclick="window.location.href='{{ route('projects.index') }}'">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
          </svg>
          Edit Project
        </button>
      </div>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-header">
        <div class="stat-icon blue">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
          </svg>
        </div>
        <div class="stat-change positive">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
            <polyline points="18 15 12 9 6 15"></polyline>
          </svg>
          12%
        </div>
      </div>
      <div class="stat-value" id="statProgress">0%</div>
      <div class="stat-label">Overall Progress</div>
    </div>

    <div class="stat-card">
      <div class="stat-header">
        <div class="stat-icon green">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="9 11 12 14 22 4"></polyline>
            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
          </svg>
        </div>
      </div>
      <div class="stat-value" id="statTasks">0/0</div>
      <div class="stat-label">Tasks Completed</div>
    </div>

    <div class="stat-card">
      <div class="stat-header">
        <div class="stat-icon orange">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <polyline points="12 6 12 12 16 14"></polyline>
          </svg>
        </div>
      </div>
      <div class="stat-value" id="statDaysLeft">-</div>
      <div class="stat-label">Days Remaining</div>
    </div>

    <div class="stat-card">
      <div class="stat-header">
        <div class="stat-icon purple">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
          </svg>
        </div>
      </div>
      <div class="stat-value" id="statBudget">$0</div>
      <div class="stat-label">Budget</div>
    </div>
  </div>

  <!-- Tabs -->
  <div class="overview-tabs">
    <div class="tab-nav">
      <button class="tab-btn active" onclick="switchTab('overview')">Overview</button>
      <button class="tab-btn" onclick="switchTab('tasks')">Tasks</button>
      <button class="tab-btn" onclick="switchTab('team')">Team</button>
      <button class="tab-btn" onclick="switchTab('timeline')">Timeline</button>
      <button class="tab-btn" onclick="switchTab('files')">Files</button>
      <button class="tab-btn" onclick="switchTab('analytics')">Analytics</button>
    </div>

    <!-- Overview Tab -->
    <div class="tab-content active" id="tab-overview">
      <div class="charts-grid">
        <div class="chart-card">
          <div class="chart-header">
            <h3 class="chart-title">Task Progress</h3>
            <p class="chart-subtitle">Completion status by category</p>
          </div>
          <div class="chart-container">
            <canvas id="taskProgressChart"></canvas>
          </div>
        </div>

        <div class="chart-card">
          <div class="chart-header">
            <h3 class="chart-title">Time Tracking</h3>
            <p class="chart-subtitle">Hours spent per week</p>
          </div>
          <div class="chart-container">
            <canvas id="timeTrackingChart"></canvas>
          </div>
        </div>
      </div>

      <div class="chart-card">
        <div class="chart-header">
          <h3 class="chart-title">Project Timeline</h3>
          <p class="chart-subtitle">Milestones and deadlines</p>
        </div>
        <div class="chart-container">
          <canvas id="timelineChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Tasks Tab -->
    <div class="tab-content" id="tab-tasks">
      <div id="tasksContent">
        <p style="text-align: center; color: #6b7280; padding: 40px;">Loading tasks...</p>
      </div>
    </div>

    <!-- Team Tab -->
    <div class="tab-content" id="tab-team">
      <div class="team-grid" id="teamContent">
        <p style="text-align: center; color: #6b7280; padding: 40px;">Loading team members...</p>
      </div>
    </div>

    <!-- Timeline Tab -->
    <div class="tab-content" id="tab-timeline">
      <div class="timeline" id="timelineContent">
        <div class="timeline-item">
          <div class="timeline-dot"></div>
          <div class="timeline-content">
            <h4 class="timeline-title">Project Created</h4>
            <p class="timeline-desc">Project was initialized and team members were assigned</p>
            <div class="timeline-meta">2 days ago • by Admin</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Files Tab -->
    <div class="tab-content" id="tab-files">
      <div class="files-list" id="filesContent">
        <div class="file-item">
          <div class="file-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
              <polyline points="13 2 13 9 20 9"></polyline>
            </svg>
          </div>
          <div class="file-info">
            <h4 class="file-name">Project Requirements.pdf</h4>
            <div class="file-meta">2.4 MB • Uploaded 2 days ago</div>
          </div>
          <div class="file-actions">
            <button class="file-btn">Download</button>
            <button class="file-btn">View</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Analytics Tab -->
    <div class="tab-content" id="tab-analytics">
      <div class="charts-grid">
        <div class="chart-card">
          <div class="chart-header">
            <h3 class="chart-title">Task Distribution</h3>
            <p class="chart-subtitle">By team member</p>
          </div>
          <div class="chart-container">
            <canvas id="taskDistributionChart"></canvas>
          </div>
        </div>

        <div class="chart-card">
          <div class="chart-header">
            <h3 class="chart-title">Velocity Chart</h3>
            <p class="chart-subtitle">Tasks completed per sprint</p>
          </div>
          <div class="chart-container">
            <canvas id="velocityChart"></canvas>
          </div>
        </div>
      </div>

      <div class="chart-card">
        <div class="chart-header">
          <h3 class="chart-title">Burndown Chart</h3>
          <p class="chart-subtitle">Remaining work over time</p>
        </div>
        <div class="chart-container">
          <canvas id="burndownChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="{{ asset('js/project-overview.js') }}"></script>
@endpush
@endsection
