@extends('layouts.macos')
@section('page_title', 'Project Overview')

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('projects.index') }}">Projects</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current" id="breadcrumbProjectName">Project Overview</span>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/project-overview-clean.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.css">
<style>
.project-overview-container { padding: 0; background: #f9fafb; }
.project-header-section { background: #ffffffff; padding: 25px 40px; margin-bottom: 2px; }
.project-header-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 16px; }
.project-title-area h1 { font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 12px 0; }
.project-meta-badges { display: flex; gap: 16px; flex-wrap: wrap; }
.meta-badge-item { display: flex; align-items: center; gap: 8px; padding: 6px 14px; background: #e5e7eb; border-radius: 6px; font-size: 13px; color: #1f2937; font-weight: 600; }
.project-actions-btns { display: flex; gap: 10px; }
.btn-project-action { padding: 10px 20px; border-radius: 6px; font-size: 14px; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s; }
.btn-back { background: white; color: #4b5563; border: 1px solid #d1d5db; }
.btn-back:hover { background: #f9fafb; }
.btn-edit-project { background: #10b981; color: white; }
.btn-edit-project:hover { background: #059669; }
.progress-section { display: flex; justify-content: center; padding: 30px 0 20px 0; }
.progress-circle-wrapper { position: relative; width: 140px; height: 140px; }
.progress-circle-wrapper svg { transform: rotate(-90deg); }
.progress-bg-circle { fill: none; stroke: #e5e7eb; stroke-width: 10; }
.progress-fill-circle { fill: none; stroke: #3b82f6; stroke-width: 10; stroke-linecap: round; transition: stroke-dashoffset 0.6s ease; }
.progress-text-center { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; }
.progress-percentage { font-size: 32px; font-weight: 700; color: #1f2937; display: block; line-height: 1; }
.progress-label-text { font-size: 12px; color: #6b7280; display: block; margin-top: 6px; font-weight: 600; }
.stats-grid-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; background: #ffffffff; margin-bottom: 2px; }
.stat-card-item { background: #f9fafb; padding: 25px 30px; display: flex; flex-direction: column; align-items: center; text-align: center; }
.stat-icon-box { width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; }
.stat-icon-box.blue { background: #eff6ff; color: #3b82f6; }
.stat-icon-box.green { background: #f0fdf4; color: #10b981; }
.stat-icon-box.orange { background: #fff7ed; color: #f59e0b; }
.stat-icon-box.purple { background: #f5f3ff; color: #8b5cf6; }
.stat-icon-box.red { background: #fef2f2; color: #ef4444; }
.stat-value-text { font-size: 32px; font-weight: 700; color: #1f2937; margin-bottom: 6px; line-height: 1; }
.stat-label-text { font-size: 14px; color: #000; font-weight: 600; margin-bottom: 4px; }
.stat-sublabel-text { font-size: 12px; color: #6b7280; font-weight: 400; }
.tabs-container-section { background: #f9fafb; padding: 0; }
.tabs-nav-bar { display: flex; background: #ffffffff; padding: 0; overflow-x: auto; border-bottom: 2px solid #d1d5db; }
.tab-nav-button { padding: 16px 32px; font-size: 14px; font-weight: 600; color: #000; background: #ffffffff; border: none; cursor: pointer; transition: all 0.2s; white-space: nowrap; border-bottom: 3px solid transparent; }
.tab-nav-button:hover { background: #ccd8ebff; }
.tab-nav-button.active { background: #ffffffff; color: #000000ff; border-bottom-color: #3b82f6; font-weight: bold;}
.tab-content-area { padding: 30px 40px; display: none; background: #f9fafb; }
.tab-content-area.active { display: block; }
.charts-grid-layout { display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 20px; margin-bottom: 20px; }
.chart-card-box { background: white; border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
.chart-header-title { margin-bottom: 20px; }
.chart-title-text { font-size: 16px; font-weight: 700; color: #1f2937; margin: 0 0 4px 0; }
.chart-subtitle-text { font-size: 13px; color: #6b7280; margin: 0; font-weight: 400; }
.chart-canvas-container { position: relative; height: 320px; }
.task-list-container { display: flex; flex-direction: column; gap: 12px; }
.task-item-row { display: flex; align-items: center; gap: 14px; padding: 16px 20px; background: white; border-radius: 8px; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
.task-item-row:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.12); }
.task-checkbox-input { width: 20px; height: 20px; cursor: pointer; appearance: none; -webkit-appearance: none; border: 2px solid #d1d5db; border-radius: 4px; background: white; position: relative; transition: all 0.2s; }
.task-checkbox-input:checked { border-color: var(--completed-color, #10b981); background: var(--completed-color, #10b981); }
.task-checkbox-input:checked::after { content: '✓'; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 12px; font-weight: bold; }
.task-info-content { flex: 1; }
.task-title-text { font-size: 14px; font-weight: 600; color: #1f2937; margin: 0 0 4px 0; }
.task-meta-text { font-size: 12px; color: #6b7280; }
.task-actions-buttons { display: flex; gap: 8px; }
.task-action-btn { padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s; border: 1px solid #d1d5db; background: white; color: #4b5563; }
.task-action-btn:hover { border-color: #3b82f6; color: #3b82f6; background: #eff6ff; }
.task-action-btn.delete-btn { color: #ef4444; border-color: #fecaca; }
.task-action-btn.delete-btn:hover { background: #fef2f2; border-color: #ef4444; }
.team-grid-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
.team-card-item { background: white; border-radius: 8px; padding: 20px; text-align: center; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
.team-card-item:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.12); transform: translateY(-2px); }
.team-avatar-circle { width: 70px; height: 70px; border-radius: 50%; background: #3b82f6; color: white; display: flex; align-items: center; justify-content: center; font-size: 26px; font-weight: 700; margin: 0 auto 14px; }
.team-name-text { font-size: 15px; font-weight: 600; color: #1f2937; margin: 0 0 6px 0; }
.team-role-text { font-size: 13px; color: #6b7280; margin: 0; font-weight: 400; }
/* Group Chat Styles - Modern Bubble Design */
.chat-container { display: flex; flex-direction: column; gap: 12px; padding: 20px; background: #f8fafc; border-radius: 12px; max-height: 500px; overflow-y: auto; }
.chat-message { display: flex; align-items: flex-end; gap: 10px; max-width: 85%; }
.chat-message.sent { align-self: flex-end; flex-direction: row-reverse; }
.chat-message.received { align-self: flex-start; }
.chat-avatar { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: white; flex-shrink: 0; }
.chat-bubble { padding: 12px 16px; border-radius: 18px; font-size: 14px; line-height: 1.5; color: #1f2937; position: relative; }
.chat-message.received .chat-bubble { border-bottom-left-radius: 4px; }
.chat-message.sent .chat-bubble { border-bottom-right-radius: 4px; background: #dcfce7 !important; }
.chat-time { font-size: 11px; color: #9ca3af; margin-top: 4px; text-align: right; }
.chat-sender-name { font-size: 12px; font-weight: 600; margin-bottom: 4px; color: inherit; opacity: 0.8; }
.chat-input-container { display: flex; align-items: flex-end; gap: 12px; padding: 16px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-top: 16px; }
.chat-input { flex: 1; padding: 12px 16px; border: 1px solid #e5e7eb; border-radius: 24px; font-size: 14px; resize: none; min-height: 44px; max-height: 120px; outline: none; transition: border-color 0.2s; }
.chat-input:focus { border-color: #3b82f6; }
.chat-input::placeholder { color: #9ca3af; }
.chat-send-btn { width: 44px; height: 44px; border-radius: 50%; background: #3b82f6; color: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s; flex-shrink: 0; }
.chat-send-btn:hover { background: #2563eb; }
.chat-send-btn:disabled { background: #d1d5db; cursor: not-allowed; }
.chat-toolbar { display: flex; gap: 8px; padding: 8px 0; }
.chat-toolbar-btn { padding: 6px 10px; background: transparent; border: none; cursor: pointer; font-size: 16px; color: #6b7280; border-radius: 4px; }
.chat-toolbar-btn:hover { background: #f3f4f6; }
@media (max-width: 768px) { .stats-grid-container { grid-template-columns: 1fr; } .charts-grid-layout { grid-template-columns: 1fr; } .project-header-top { flex-direction: column; align-items: flex-start; } }

/* Custom SweetAlert Styles */
.custom-swal-popup {
  border-radius: 16px !important;
  box-shadow: 0 20px 60px rgba(0,0,0,0.2) !important;
  border: 1px solid #e5e7eb !important;
}
.custom-swal-confirm {
  padding: 12px 28px !important;
  font-size: 14px !important;
  font-weight: 700 !important;
  border-radius: 8px !important;
  box-shadow: 0 4px 12px rgba(59,130,246,0.3) !important;
  transition: all 0.2s ease !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  letter-spacing: 0.2px !important;
}
.custom-swal-confirm:hover {
  transform: translateY(-2px) !important;
  box-shadow: 0 6px 16px rgba(59,130,246,0.4) !important;
}
.custom-swal-cancel {
  padding: 12px 28px !important;
  font-size: 14px !important;
  font-weight: 700 !important;
  border-radius: 8px !important;
  transition: all 0.2s ease !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  letter-spacing: 0.2px !important;
  border: 2px solid #d1d5db !important;
}
.custom-swal-cancel:hover {
  background: #f3f4f6 !important;
  border-color: #9ca3af !important;
}
.swal2-input:focus {
  border-color: #3b82f6 !important;
  box-shadow: 0 0 0 3px rgba(59,130,246,0.1) !important;
  outline: none !important;
}
.swal2-select:focus {
  border-color: #3b82f6 !important;
  box-shadow: 0 0 0 3px rgba(59,130,246,0.1) !important;
  outline: none !important;
}
.swal2-title {
  padding: 0 !important;
  margin-bottom: 20px !important;
}
.swal2-html-container {
  margin: 0 !important;
  padding: 0 !important;
}
.swal2-actions {
  margin-top: 24px !important;
  gap: 12px !important;
}
.swal2-validation-message {
  background: #fef2f2 !important;
  color: #991b1b !important;
  border: 1px solid #fecaca !important;
  border-radius: 6px !important;
  padding: 10px 14px !important;
  font-size: 13px !important;
  font-weight: 600 !important;
  margin-top: 12px !important;
}

/* Material Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
}

.modal-content {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: modalSlideIn 0.3s ease;
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
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 2px solid #e5e7eb;
}

.modal-header h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.close-btn {
    background: none;
    border: none;
    font-size: 28px;
    color: #6b7280;
    cursor: pointer;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    transition: all 0.2s;
}

.close-btn:hover {
    background: #f3f4f6;
    color: #1f2937;
}

.form-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
}

.btn-cancel {
    padding: 10px 20px;
    background: white;
    color: #4b5563;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-cancel:hover {
    background: #f9fafb;
}

.btn-create {
    padding: 10px 20px;
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-create:hover {
    background: #2563eb;
}
</style>
@endpush

@section('content')
<div class="project-overview-container">
  <div class="project-header-section">
    <div class="project-header-top">
      <div class="project-title-area">
        <h1 id="projectName">Loading...</h1>
        <div class="project-meta-badges">
          <div class="meta-badge-item">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span id="projectCompany">Company</span>
          </div>
          <div class="meta-badge-item">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
              <line x1="16" y1="2" x2="16" y2="6"></line>
              <line x1="8" y1="2" x2="8" y2="6"></line>
              <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <span id="projectStartDate">Start: -</span>
          </div>
          <div class="meta-badge-item" id="dueDateBadge" onclick="openDueDatePicker()" style="cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#dbeafe'; this.style.borderColor='#3b82f6';" onmouseout="this.style.background='#e5e7eb'; this.style.borderColor='transparent';">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"></circle>
              <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <span id="projectDueDate">Due: Click to set</span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="opacity: 0.5;">
              <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
          </div>
        </div>
      </div>
      <div class="project-actions-btns">
        <button class="btn-project-action btn-back" onclick="window.location.href='{{ route('projects.index') }}'">Back</button>
        <button class="btn-project-action btn-edit-project" onclick="window.location.href='{{ route('projects.index') }}'">Edit Project</button>
      </div>
    </div>
    <!-- Main Progress Bar -->
    <div class="main-progress-section">
      <div class="main-progress-header">
        <span class="main-progress-label">Overall Project Progress</span>
        <span class="main-progress-value" id="mainProgressPercentage">0%</span>
      </div>
      <div class="main-progress-track">
        <div class="main-progress-fill" id="mainProgressBar" style="width: 0%">
          <div class="progress-shine"></div>
        </div>
      </div>
      <div class="main-progress-info">
        <span id="mainProgressTasks">0 of 0 tasks completed</span>
      </div>
    </div>
  </div>

  <div class="stats-grid-container">
    <div class="stat-card-item">
      <div class="stat-icon-box blue">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
      </div>
      <div class="stat-value-text" id="statTotalTasks">0</div>
      <div class="stat-label-text">Total Tasks</div>
      <div class="stat-sublabel-text" id="statTasksCompleted">0 completed</div>
    </div>
    <div class="stat-card-item">
      <div class="stat-icon-box orange">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
      </div>
      <div class="stat-value-text" id="statMembers">0</div>
      <div class="stat-label-text">Team Members</div>
      <div class="stat-sublabel-text">Active members</div>
    </div>
    <div class="stat-card-item">
      <div class="stat-icon-box purple">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
      </div>
      <div class="stat-value-text" id="statComments">0</div>
      <div class="stat-label-text">Comments</div>
      <div class="stat-sublabel-text">Total discussions</div>
    </div>
  </div>

  <div class="tabs-container-section">
    <div class="tabs-nav-bar">
      <button class="tab-nav-button active" onclick="switchTab('overview')">Overview</button>
      <button class="tab-nav-button" onclick="switchTab('tasks')">Tasks</button>
      <button class="tab-nav-button" onclick="switchTab('team')">Team</button>
      <button class="tab-nav-button" id="commentsTabBtn" onclick="switchTab('comments')" style="display: none;">Comments</button>
      <button class="tab-nav-button" onclick="switchTab('files')">Files</button>
    </div>

    <div class="tab-content-area active" id="tab-overview">
      <!-- Quick Actions -->
      <div class="quick-actions-bar">
        <button class="action-btn primary" onclick="addNewTask()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
          </svg>
          Add Task
        </button>
        <button class="action-btn primary" onclick="openMaterialsModal(projectId)" style="background: #10b981;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 11l3 3L22 4"></path>
            <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
          </svg>
          Assign Materials
        </button>
        <button class="action-btn secondary" onclick="window.location.href='{{ route('projects.index') }}'">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
          </svg>
          Edit Project
        </button>
      </div>

      <!-- Project Details Grid -->
      <div class="project-details-grid">
        <div class="detail-card">
          <div class="detail-label">Status</div>
          <div class="detail-value" id="detailStatus">Active</div>
        </div>
        <div class="detail-card">
          <div class="detail-label">Priority</div>
          <div class="detail-value" id="detailPriority">Medium</div>
        </div>
        <div class="detail-card">
          <div class="detail-label">Start Date</div>
          <div class="detail-value" id="detailStartDate">-</div>
        </div>
        <div class="detail-card">
          <div class="detail-label">Due Date</div>
          <div class="detail-value" id="detailDueDate">-</div>
        </div>
        <div class="detail-card">
          <div class="detail-label">Company</div>
          <div class="detail-value" id="detailCompany">-</div>
        </div>
      </div>

      <!-- Progress Bars -->
      <div class="progress-bars-section">
        <h3 class="section-title">Progress Tracking</h3>
        
        <div class="progress-bar-item">
          <div class="progress-bar-header">
            <span class="progress-bar-label">Overall Completion</span>
            <span class="progress-bar-value" id="overallProgress">0%</span>
          </div>
          <div class="progress-bar-track">
            <div class="progress-bar-fill" id="overallProgressBar" style="width: 0%"></div>
          </div>
        </div>

        <div class="progress-bar-item">
          <div class="progress-bar-header">
            <span class="progress-bar-label">Tasks Completed</span>
            <span class="progress-bar-value" id="tasksProgress">0/0</span>
          </div>
          <div class="progress-bar-track">
            <div class="progress-bar-fill bg-green" id="tasksProgressBar" style="width: 0%"></div>
          </div>
        </div>

        <div class="progress-bar-item">
          <div class="progress-bar-header">
            <span class="progress-bar-label">Time Elapsed</span>
            <span class="progress-bar-value" id="timeProgress">0%</span>
          </div>
          <div class="progress-bar-track">
            <div class="progress-bar-fill bg-purple" id="timeProgressBar" style="width: 0%"></div>
          </div>
        </div>
      </div>

      <!-- Description -->
      <div class="description-section">
        <h3 class="section-title">Description</h3>
        <div class="description-content" id="projectDescription">
          <p style="color: #9ca3af; font-style: italic;">No description</p>
        </div>
      </div>

      <!-- Quick Stats -->
      <div class="quick-stats-grid">
        <div class="quick-stat-card">
          <div class="quick-stat-icon blue">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
            </svg>
          </div>
          <div class="quick-stat-info">
            <div class="quick-stat-value" id="quickTotalTasks">0</div>
            <div class="quick-stat-label">Total Tasks</div>
          </div>
        </div>

        <div class="quick-stat-card">
          <div class="quick-stat-icon green">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="9 11 12 14 22 4"></polyline>
              <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
            </svg>
          </div>
          <div class="quick-stat-info">
            <div class="quick-stat-value" id="quickCompletedTasks">0</div>
            <div class="quick-stat-label">Completed</div>
          </div>
        </div>

        <div class="quick-stat-card">
          <div class="quick-stat-icon orange">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
            </svg>
          </div>
          <div class="quick-stat-info">
            <div class="quick-stat-value" id="quickTeamMembers">0</div>
            <div class="quick-stat-label">Team Members</div>
          </div>
        </div>

        <div class="quick-stat-card">
          <div class="quick-stat-icon purple">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
          </div>
          <div class="quick-stat-info">
            <div class="quick-stat-value" id="quickComments">0</div>
            <div class="quick-stat-label">Comments</div>
          </div>
        </div>
      </div>
    </div>

    <div class="tab-content-area" id="tab-tasks">
      <div class="tab-header-actions">
        <button class="action-btn primary" onclick="addNewTask()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
          </svg>
          Add New Task
        </button>
      </div>
      <div class="task-list-container" id="taskList">
        <p style="text-align: center; color: #6b7280; padding: 40px;">Loading tasks...</p>
      </div>
    </div>

    <div class="tab-content-area" id="tab-team">
      <div class="tab-header-actions">
        <button class="action-btn primary" onclick="addNewMember()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="8.5" cy="7" r="4"></circle>
            <line x1="20" y1="8" x2="20" y2="14"></line>
            <line x1="23" y1="11" x2="17" y2="11"></line>
          </svg>
          Add Member
        </button>
      </div>
      <div class="team-grid-container" id="teamGrid">
        <p style="text-align: center; color: #6b7280; padding: 40px;">Loading team members...</p>
      </div>
    </div>

    <div class="tab-content-area" id="tab-comments">
      <div class="chat-container" id="commentList">
        <p style="text-align: center; color: #6b7280; padding: 40px;">Loading chat...</p>
      </div>
      <div class="chat-input-container" id="commentForm">
        <textarea class="chat-input" id="commentMessage" placeholder="Type here to discuss with the team..." rows="1" onkeydown="if(event.key==='Enter' && !event.shiftKey){event.preventDefault();postComment();}"></textarea>
        <button class="chat-send-btn" onclick="postComment()" title="Send">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="22" y1="2" x2="11" y2="13"></line>
            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
          </svg>
        </button>
      </div>
      <div class="chat-toolbar">
        <button class="chat-toolbar-btn" title="Bold" onclick="formatChatText('bold')"><b>B</b></button>
        <button class="chat-toolbar-btn" title="Italic" onclick="formatChatText('italic')"><i>I</i></button>
        <button class="chat-toolbar-btn" title="Strikethrough" onclick="formatChatText('strikethrough')"><s>S</s></button>
        <button class="chat-toolbar-btn" title="Insert Emoji" onclick="insertChatEmoji('❤️')">❤️</button>
        <button class="chat-toolbar-btn" title="Insert Emoji" onclick="insertChatEmoji('👍')">👍</button>
      </div>
    </div>

    <div class="tab-content-area" id="tab-files">
      <div class="tab-header-actions">
        <button class="action-btn primary" onclick="document.getElementById('fileUploadInput').click()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="17 8 12 3 7 8"></polyline>
            <line x1="12" y1="3" x2="12" y2="15"></line>
          </svg>
          Upload Files
        </button>
        <input type="file" id="fileUploadInput" multiple style="display: none;" onchange="uploadFiles(this.files)">
      </div>
      
      <div id="filesList" class="files-grid-container">
        <div style="text-align: center; padding: 60px 20px; grid-column: 1/-1;">
          <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, #eff6ff, #dbeafe); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2">
              <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
              <polyline points="13 2 13 9 20 9"></polyline>
            </svg>
          </div>
          <h3 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0 0 8px 0;">No Files Yet</h3>
          <p style="font-size: 14px; color: #6b7280; margin: 0 0 16px 0;">Upload project files and documents</p>
          <button class="action-btn secondary" onclick="document.getElementById('fileUploadInput').click()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
              <polyline points="17 8 12 3 7 8"></polyline>
              <line x1="12" y1="3" x2="12" y2="15"></line>
            </svg>
            Choose Files
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="{{ asset('js/project-tasks.js') }}?v={{ time() }}"></script>
<script>
const projectId = {{ $id }};
let projectData = null;
let tasksData = [];
let membersData = [];
let commentsData = [];
let canAccessChat = false;

// Current user info for task completion tracking
const currentUser = {
    id: {{ auth()->id() }},
    name: "{{ auth()->user()->name }}",
    chat_color: "{{ auth()->user()->chat_color ?? '#10b981' }}"
};

async function loadProjectData() {
    try {
        console.log('Loading project data for ID:', projectId);
        
        if (!projectId) {
            throw new Error('No project ID provided');
        }
        
        const response = await fetch(`{{ url('/projects') }}/${projectId}`, {
            headers: { 
                'X-Requested-With': 'XMLHttpRequest', 
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });
        
        console.log('Response status:', response.status);
        
        if (!response.ok) {
            const errorText = await response.text();
            console.error('Response error:', errorText);
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        console.log('Project data received:', data);
        
        if (data.success && data.project) {
            projectData = data.project;
            canAccessChat = data.can_access_chat || false;
            
            // Show/hide comments tab based on membership
            const commentsTabBtn = document.getElementById('commentsTabBtn');
            if (commentsTabBtn) {
                if (canAccessChat) {
                    commentsTabBtn.style.display = 'block';
                } else {
                    commentsTabBtn.style.display = 'none';
                }
            }
            
            updateProjectInfo();
            
            // Load comments only if user has access
            if (canAccessChat) {
                await Promise.all([loadTasks(), loadTeamMembers(), loadComments()]);
            } else {
                await Promise.all([loadTasks(), loadTeamMembers()]);
            }
        } else {
            throw new Error('Invalid response format: ' + JSON.stringify(data));
        }
    } catch (error) {
        console.error('Error loading project:', error);
        if (typeof toastr !== 'undefined') {
            toastr.error('Error loading project: ' + error.message);
        }
        // Show error on page
        document.getElementById('projectName').textContent = 'Error Loading Project';
        document.getElementById('mainProgressTasks').textContent = 'Failed to load project data';
    }
}

async function loadTasks() {
    try {
        console.log('Loading tasks...');
        const response = await fetch(`{{ url('/projects') }}/${projectId}/tasks`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        const data = await response.json();
        console.log('Tasks data:', data);
        console.log('Number of tasks loaded:', data.tasks ? data.tasks.length : 0);
        if (data.success) {
            tasksData = data.tasks || [];
            console.log('Tasks stored in tasksData:', tasksData.length);
            renderTasks();
            // Update progress after loading tasks
            updateProgressDisplay();
        }
    } catch (error) {
        console.error('Error loading tasks:', error);
        document.getElementById('taskList').innerHTML = '<p style="text-align: center; color: #ef4444; padding: 40px;">Failed to load tasks: ' + error.message + '</p>';
    }
}

async function loadTeamMembers() {
    try {
        console.log('Loading team members...');
        const response = await fetch(`{{ url('/projects') }}/${projectId}/members`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        const data = await response.json();
        console.log('Members data:', data);
        if (data.success) {
            membersData = data.members || [];
            renderTeamMembers();
        }
    } catch (error) {
        console.error('Error loading members:', error);
        document.getElementById('teamGrid').innerHTML = '<p style="text-align: center; color: #ef4444; padding: 40px;">Failed to load team: ' + error.message + '</p>';
    }
}

async function loadComments() {
    try {
        console.log('Loading comments...');
        const response = await fetch(`{{ url('/projects') }}/${projectId}/comments`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        const data = await response.json();
        console.log('Comments data:', data);
        
        if (data.success) {
            commentsData = data.comments || [];
            renderComments();
        } else if (response.status === 403) {
            // Access denied - user is not a member
            document.getElementById('commentList').innerHTML = `
                <div style="text-align: center; padding: 60px 20px;">
                    <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, #fef2f2, #fee2e2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0 0 8px 0;">Access Restricted</h3>
                    <p style="font-size: 14px; color: #6b7280; margin: 0;">Only project members can view and post comments</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error loading comments:', error);
        document.getElementById('commentList').innerHTML = '<p style="text-align: center; color: #ef4444; padding: 40px;">Failed to load comments: ' + error.message + '</p>';
    }
}

function renderTasks() {
    const container = document.getElementById('taskList');
    if (tasksData.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 60px 20px;">
                <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, #eff6ff, #dbeafe); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                </div>
                <h3 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0 0 8px 0;">No Tasks Yet</h3>
                <p style="font-size: 14px; color: #6b7280; margin: 0;">Create your first task to get started with this project</p>
            </div>
        `;
        return;
    }
    let html = '';
    tasksData.forEach(task => {
        const isCompleted = task.is_completed;
        
        // Get completed by user's color for checkbox
        const completedByUser = task.completed_by_user;
        const completedColor = completedByUser && completedByUser.chat_color ? completedByUser.chat_color : '#10b981';
        const completedByName = completedByUser ? completedByUser.name : '';
        
        // Check if task is overdue
        let isOverdue = false;
        let dueDateTime = 'No due date';
        let dueDateStyle = '';
        
        if (task.due_date && !isCompleted) {
            const now = new Date();
            let dueDate = new Date(task.due_date);
            
            // If time is specified, include it in comparison
            if (task.due_time) {
                const [hours, minutes] = task.due_time.split(':');
                dueDate.setHours(parseInt(hours), parseInt(minutes), 0);
            } else {
                // If no time, set to end of day
                dueDate.setHours(23, 59, 59);
            }
            
            isOverdue = now > dueDate;
            
            // Format date
            const dateObj = new Date(task.due_date);
            const formattedDate = dateObj.toLocaleDateString('en-GB', { 
                day: '2-digit', 
                month: 'short', 
                year: 'numeric' 
            });
            
            if (task.due_time) {
                const [hours, minutes] = task.due_time.split(':');
                const hour = parseInt(hours);
                const ampm = hour >= 12 ? 'PM' : 'AM';
                const hour12 = hour % 12 || 12;
                dueDateTime = `${formattedDate} at ${hour12}:${minutes} ${ampm}`;
            } else {
                dueDateTime = formattedDate;
            }
            
            // Add overdue indicator
            if (isOverdue) {
                dueDateTime = `⚠️ OVERDUE - ${dueDateTime}`;
                dueDateStyle = 'color: #dc2626; font-weight: 700;';
            }
        }
        
        html += `<div class="task-item-row" style="background: ${isCompleted ? '#f0fdf4' : 'white'};">
            <input type="checkbox" class="task-checkbox-input" ${isCompleted ? 'checked' : ''} style="--completed-color: ${completedColor};" onchange="toggleTask(${task.id}, this.checked)" title="${isCompleted && completedByName ? 'Completed by ' + completedByName : ''}">
            <div class="task-info-content">
                <h4 class="task-title-text" style="${isCompleted ? 'text-decoration: line-through; opacity: 0.6;' : ''}">${escapeHtml(task.title)}</h4>
                ${task.description ? `<p class="task-meta-text" style="margin-bottom: 4px;">${escapeHtml(task.description)}</p>` : ''}
                <p class="task-meta-text">
                    ${isCompleted && completedByName ? `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="${completedColor}" stroke-width="2" style="vertical-align: middle; margin-right: 4px;"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg><strong style="color: ${completedColor};">Done by:</strong> <span style="color: ${completedColor}; font-weight: 600;">${escapeHtml(completedByName)}</span><span style="margin: 0 8px;">•</span>` : ''}
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="${isOverdue ? '#dc2626' : 'currentColor'}" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <strong style="${dueDateStyle}">Due:</strong> <span style="${dueDateStyle}">${dueDateTime}</span>
                </p>
            </div>
            <div class="task-actions-buttons">
                <button class="task-action-btn" onclick="editTask(${task.id})">Edit</button>
                <button class="task-action-btn delete-btn" onclick="deleteTask(${task.id})">Delete</button>
            </div>
        </div>`;
    });
    container.innerHTML = html;
}

function renderTeamMembers() {
    const container = document.getElementById('teamGrid');
    if (membersData.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 60px 20px; grid-column: 1/-1;">
                <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, #fff7ed, #ffedd5); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <h3 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0 0 8px 0;">No Team Members</h3>
                <p style="font-size: 14px; color: #6b7280; margin: 0;">Add team members to collaborate on this project</p>
            </div>
        `;
        return;
    }
    let html = '';
    membersData.forEach(member => {
        const initials = member.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        // Use user's chat_color from database, fallback to random color
        const chatColor = member.chat_color || ['#6366f1', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6', '#ef4444', '#06b6d4', '#84cc16'][member.id % 8];
        
        // Check for photo from employee data
        const photoPath = member.employee && member.employee.photo_path 
            ? `{{ url('storage') }}/${member.employee.photo_path}`
            : null;
        
        // Build avatar content - photo with colored ring or initials on colored background
        let avatarContent = '';
        if (photoPath) {
            // Photo with colored ring effect
            avatarContent = `<div style="width: 60px; height: 60px; border-radius: 50%; overflow: hidden; border: 2px solid white;">
                <img src="${photoPath}" alt="${escapeHtml(member.name)}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.parentElement.innerHTML='<div style=\\'width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:22px;\\'>${initials}</div>';">
            </div>`;
        } else {
            // Initials on colored background
            avatarContent = `<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 26px;">${initials}</div>`;
        }
        
        html += `<div class="team-card-item">
            <div class="team-avatar-circle" style="background: ${chatColor}; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.12);">${avatarContent}</div>
            <h4 class="team-name-text">${escapeHtml(member.name)}</h4>
            <p class="team-role-text">${member.pivot?.role || 'Member'}</p>
        </div>`;
    });
    container.innerHTML = html;
}

function renderComments() {
    const container = document.getElementById('commentList');
    const commentForm = document.getElementById('commentForm');
    const chatToolbar = document.querySelector('.chat-toolbar');
    const currentUserId = {{ auth()->id() }};
    
    // Hide comment form if user doesn't have access
    if (commentForm) {
        commentForm.style.display = canAccessChat ? 'flex' : 'none';
    }
    if (chatToolbar) {
        chatToolbar.style.display = canAccessChat ? 'flex' : 'none';
    }
    
    if (commentsData.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 60px 20px;">
                <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, #f5f3ff, #ede9fe); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                </div>
                <h3 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0 0 8px 0;">No Messages Yet</h3>
                <p style="font-size: 14px; color: #6b7280; margin: 0;">${canAccessChat ? 'Start the conversation with your team!' : 'Only project members can view chat'}</p>
            </div>
        `;
        return;
    }
    
    // Color mapping - converts user's chat_color to bubble background/text
    const colorToBubble = {
        '#6366f1': { bg: '#e0e7ff', text: '#3730a3' },  // Indigo
        '#10b981': { bg: '#dcfce7', text: '#166534' },  // Green
        '#f59e0b': { bg: '#fef3c7', text: '#92400e' },  // Yellow/Amber
        '#ec4899': { bg: '#fce7f3', text: '#9d174d' },  // Pink
        '#8b5cf6': { bg: '#ede9fe', text: '#5b21b6' },  // Purple
        '#ef4444': { bg: '#fee2e2', text: '#b91c1c' },  // Red
        '#06b6d4': { bg: '#cffafe', text: '#0e7490' },  // Cyan
        '#84cc16': { bg: '#ecfccb', text: '#4d7c0f' },  // Lime
        '#f97316': { bg: '#ffedd5', text: '#c2410c' },  // Orange
        '#14b8a6': { bg: '#ccfbf1', text: '#0f766e' },  // Teal
        '#a855f7': { bg: '#f3e8ff', text: '#7c3aed' },  // Violet
        '#3b82f6': { bg: '#dbeafe', text: '#1e40af' },  // Blue
        '#eab308': { bg: '#fef9c3', text: '#a16207' },  // Yellow
        '#e11d48': { bg: '#ffe4e6', text: '#be123c' },  // Rose
        '#0ea5e9': { bg: '#e0f2fe', text: '#0369a1' },  // Sky
    };
    
    let html = '';
    commentsData.forEach(comment => {
        const isSent = comment.user_id === currentUserId;
        const initials = comment.user?.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2) || 'U';
        
        // Use user's assigned chat_color from database
        const userColor = comment.user?.chat_color || '#6366f1';
        const avatarColor = userColor;
        const bubbleColor = colorToBubble[userColor] || { bg: '#e0e7ff', text: '#3730a3' };
        
        const timeStr = new Date(comment.created_at).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        const dateStr = new Date(comment.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        
        html += `
        <div class="chat-message ${isSent ? 'sent' : 'received'}">
            <div class="chat-avatar" style="background: ${avatarColor};">${initials}</div>
            <div>
                <div class="chat-sender-name" style="color: ${avatarColor};">${escapeHtml(comment.user?.name || 'User')}</div>
                <div class="chat-bubble" style="background: ${bubbleColor.bg}; color: ${bubbleColor.text};">
                    ${parseMarkdown(comment.message)}
                </div>
                <div class="chat-time">${dateStr}, ${timeStr}</div>
            </div>
        </div>`;
    });
    container.innerHTML = html;
    
    // Scroll to bottom
    container.scrollTop = container.scrollHeight;
}

// Parse markdown formatting (bold, italic, strikethrough)
function parseMarkdown(text) {
    if (!text) return '';
    let escaped = escapeHtml(text);
    // Bold: **text**
    escaped = escaped.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
    // Italic: *text*
    escaped = escaped.replace(/\*(.+?)\*/g, '<em>$1</em>');
    // Strikethrough: ~~text~~
    escaped = escaped.replace(/~~(.+?)~~/g, '<del>$1</del>');
    // Underline: __text__
    escaped = escaped.replace(/__(.+?)__/g, '<u>$1</u>');
    return escaped;
}

// Chat text formatting functions
function formatChatText(format) {
    const input = document.getElementById('commentMessage');
    const start = input.selectionStart;
    const end = input.selectionEnd;
    const selectedText = input.value.substring(start, end);
    
    let prefix = '', suffix = '';
    switch(format) {
        case 'bold':
            prefix = suffix = '**';
            break;
        case 'italic':
            prefix = suffix = '*';
            break;
        case 'strikethrough':
            prefix = suffix = '~~';
            break;
    }
    
    if (selectedText) {
        // Wrap selected text
        input.value = input.value.substring(0, start) + prefix + selectedText + suffix + input.value.substring(end);
        input.setSelectionRange(start + prefix.length, end + prefix.length);
    } else {
        // Insert markers at cursor position
        input.value = input.value.substring(0, start) + prefix + suffix + input.value.substring(end);
        input.setSelectionRange(start + prefix.length, start + prefix.length);
    }
    input.focus();
}

function insertChatEmoji(emoji) {
    const input = document.getElementById('commentMessage');
    const start = input.selectionStart;
    input.value = input.value.substring(0, start) + emoji + input.value.substring(input.selectionEnd);
    input.setSelectionRange(start + emoji.length, start + emoji.length);
    input.focus();
}

async function postComment() {
    const message = document.getElementById('commentMessage').value.trim();
    if (!message) return;
    
    if (!canAccessChat) {
        if (typeof toastr !== 'undefined') {
            toastr.error('Only project members can post comments');
        }
        return;
    }
    
    try {
        const response = await fetch(`{{ url('/projects') }}/${projectId}/comments`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ message })
        });
        
        if (response.ok) {
            document.getElementById('commentMessage').value = '';
            await loadComments();
            // Scroll chat to bottom after new message
            const chatContainer = document.getElementById('commentList');
            if (chatContainer) chatContainer.scrollTop = chatContainer.scrollHeight;
        } else if (response.status === 403) {
            const data = await response.json();
            if (typeof toastr !== 'undefined') {
                toastr.error(data.message || 'Access denied. Only project members can post comments.');
            }
        } else {
            if (typeof toastr !== 'undefined') toastr.error('Failed to post comment');
        }
    } catch (error) {
        console.error('Error:', error);
        if (typeof toastr !== 'undefined') toastr.error('Error posting comment');
    }
}

async function toggleTask(taskId, isCompleted) {
    try {
        const response = await fetch(`{{ url('/projects') }}/${projectId}/tasks/${taskId}`, {
            method: 'PUT',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ is_completed: isCompleted })
        });
        if (response.ok) {
            const data = await response.json();
            // Update task in local data with completed_by_user info
            const task = tasksData.find(t => t.id === taskId);
            if (task) {
                task.is_completed = isCompleted;
                // Use response data or current user info for immediate UI update
                task.completed_by_user = isCompleted ? (data.task?.completed_by_user || currentUser) : null;
            }
            
            // Update progress immediately
            updateProgressDisplay();
            
            // Re-render tasks
            renderTasks();
            
            if (typeof toastr !== 'undefined') {
                toastr.success(isCompleted ? 'Task completed!' : 'Task reopened');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        if (typeof toastr !== 'undefined') toastr.error('Failed to update task');
    }
}

// Function to update progress display
function updateProgressDisplay() {
    const totalTasks = tasksData.length;
    const completedTasks = tasksData.filter(t => t.is_completed).length;
    const progress = totalTasks > 0 ? Math.round((completedTasks / totalTasks) * 100) : 0;
    
    // Update main progress bar
    const updateElement = (id, value) => {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
    };
    
    updateElement('mainProgressPercentage', progress + '%');
    const mainBar = document.getElementById('mainProgressBar');
    if (mainBar) {
        mainBar.style.width = progress + '%';
    }
    updateElement('mainProgressTasks', completedTasks + ' of ' + totalTasks + ' tasks completed');
    
    // Update stats cards
    updateElement('statTotalTasks', totalTasks);
    updateElement('statTasksCompleted', completedTasks + ' completed');
    
    // Update overview tab progress bars
    updateElement('overallProgress', progress + '%');
    const overallBar = document.getElementById('overallProgressBar');
    if (overallBar) overallBar.style.width = progress + '%';
    
    updateElement('tasksProgress', completedTasks + '/' + totalTasks);
    const tasksBar = document.getElementById('tasksProgressBar');
    if (tasksBar) tasksBar.style.width = progress + '%';
    
    // Update quick stats
    updateElement('quickTotalTasks', totalTasks);
    updateElement('quickCompletedTasks', completedTasks);
}

function addNewTask() {
    if (typeof Swal === 'undefined') return;
    Swal.fire({
        title: '<div style="display: flex; align-items: center; gap: 12px; justify-content: center;"><div style="width: 48px; height: 48px; background: linear-gradient(135deg, #eff6ff, #dbeafe); border-radius: 12px; display: flex; align-items: center; justify-content: center;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg></div><strong style="color: #111827; font-size: 26px; font-weight: 700; letter-spacing: -0.5px;">Add New Task</strong></div>',
        html: `
            <div style="text-align: left; padding: 16px 8px;">
                <div style="background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%); border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 20px;">
                    <div style="margin-bottom: 24px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 10px; letter-spacing: 0.2px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Task Title <span style="color: #ef4444; margin-left: 2px;">*</span>
                        </label>
                        <input id="taskTitle" class="swal2-input" placeholder="e.g., Design homepage mockup" 
                               style="width: 100%; margin: 0; padding: 14px 16px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-weight: 500; transition: all 0.2s; background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
                               onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='0 1px 2px rgba(0,0,0,0.05)'">
                    </div>
                    <div style="margin-bottom: 8px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 10px; letter-spacing: 0.2px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            Due Date
                        </label>
                        <input id="taskDueDate" type="date" class="swal2-input" 
                               style="width: 100%; margin: 0; padding: 14px 16px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-weight: 500; transition: all 0.2s; background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
                               onfocus="this.style.borderColor='#10b981'; this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.1)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='0 1px 2px rgba(0,0,0,0.05)'">
                    </div>
                </div>
                <div style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-radius: 8px; padding: 12px 16px; display: flex; align-items: start; gap: 10px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" style="flex-shrink: 0; margin-top: 2px;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <p style="margin: 0; font-size: 13px; color: #1e40af; line-height: 1.5; font-weight: 500;">
                        Tasks help you track project progress. You can mark them complete when done.
                    </p>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 6px;"><polyline points="20 6 9 17 4 12"></polyline></svg> Create Task',
        cancelButtonText: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 6px;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> Cancel',
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        width: '580px',
        padding: '32px 24px 24px 24px',
        customClass: {
            popup: 'custom-swal-popup',
            confirmButton: 'custom-swal-confirm',
            cancelButton: 'custom-swal-cancel'
        },
        didOpen: () => {
            // Auto-focus on title input
            document.getElementById('taskTitle').focus();
        },
        preConfirm: () => {
            const title = document.getElementById('taskTitle').value.trim();
            if (!title) {
                Swal.showValidationMessage('⚠️ Please enter a task title');
                return false;
            }
            return {
                title: title,
                due_date: document.getElementById('taskDueDate').value
            };
        }
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const response = await fetch(`{{ url('/projects') }}/${projectId}/tasks`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(result.value)
                });
                
                if (response.ok) {
                    const data = await response.json();
                    if (data.success && data.task) {
                        // Add new task to local data
                        tasksData.push(data.task);
                        // Update progress and render
                        updateProgressDisplay();
                        renderTasks();
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Task Created!',
                        text: 'Your task has been added successfully',
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: { popup: 'custom-swal-popup' }
                    });
                } else {
                    toastr.error('Failed to create task');
                }
            } catch (error) {
                console.error('Error:', error);
                toastr.error('Error creating task');
            }
        }
    });
}

function editTask(taskId) {
    const task = tasksData.find(t => t.id === taskId);
    if (!task || typeof Swal === 'undefined') return;
    Swal.fire({
        title: 'Edit Task',
        html: `
            <input id="taskTitle" class="swal2-input" placeholder="Task title" value="${escapeHtml(task.title)}" style="margin-bottom: 10px;">
            <input id="taskDueDate" class="swal2-input" type="date" value="${task.due_date || ''}">
        `,
        showCancelButton: true,
        confirmButtonText: 'Update',
        preConfirm: () => ({ title: document.getElementById('taskTitle').value, due_date: document.getElementById('taskDueDate').value })
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const response = await fetch(`{{ url('/projects') }}/${projectId}/tasks/${taskId}`, {
                    method: 'PUT',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(result.value)
                });
                if (response.ok) {
                    toastr.success('Task updated');
                    await loadTasks();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    });
}

async function deleteTask(taskId) {
    if (typeof Swal === 'undefined') return;
    const result = await Swal.fire({
        title: 'Delete Task?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Delete'
    });
    if (result.isConfirmed) {
        try {
            const response = await fetch(`{{ url('/projects') }}/${projectId}/tasks/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            if (response.ok) {
                // Remove task from local data
                const index = tasksData.findIndex(t => t.id === taskId);
                if (index > -1) {
                    tasksData.splice(index, 1);
                }
                // Update progress and render
                updateProgressDisplay();
                renderTasks();
                toastr.success('Task deleted');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
}

function updateProjectInfo() {
    // Helper function to safely update elements
    const updateElement = (id, value) => {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
    };
    
    // Format dates to show only date (not time)
    const formatDate = (dateStr) => {
        if (!dateStr) return 'Not set';
        const date = new Date(dateStr);
        return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
    };
    
    document.getElementById('projectName').textContent = projectData.name || 'Project';
    document.getElementById('breadcrumbProjectName').textContent = projectData.name || 'Project Overview';
    document.getElementById('projectCompany').textContent = projectData.company?.company_name || 'No Company';
    document.getElementById('projectStartDate').textContent = 'Start: ' + formatDate(projectData.start_date);
    document.getElementById('projectDueDate').textContent = 'Due: ' + formatDate(projectData.due_date);
    
    const totalTasks = tasksData.length;
    const completedTasks = tasksData.filter(t => t.is_completed).length;
    const progress = totalTasks > 0 ? Math.round((completedTasks / totalTasks) * 100) : 0;
    
    // Update main progress bar
    updateElement('mainProgressPercentage', progress + '%');
    const mainBar = document.getElementById('mainProgressBar');
    if (mainBar) mainBar.style.width = progress + '%';
    updateElement('mainProgressTasks', completedTasks + ' of ' + totalTasks + ' tasks completed');
    
    // Update stats cards
    updateElement('statTotalTasks', totalTasks);
    updateElement('statTasksCompleted', completedTasks + ' completed');
    updateElement('statMembers', membersData.length);
    updateElement('statComments', commentsData.length);
    
    if (projectData.due_date) {
        const dueDate = new Date(projectData.due_date);
        const today = new Date();
        const daysLeft = Math.ceil((dueDate - today) / (1000 * 60 * 60 * 24));
        updateElement('statDaysLeft', daysLeft > 0 ? daysLeft : '0');
    } else {
        updateElement('statDaysLeft', '-');
    }
    
    updateElement('detailStatus', (projectData.status || 'active').toUpperCase());
    updateElement('detailPriority', (projectData.priority || 'medium').toUpperCase());
    updateElement('detailStartDate', formatDate(projectData.start_date));
    updateElement('detailDueDate', formatDate(projectData.due_date));
    updateElement('detailCompany', projectData.company?.company_name || '-');
    
    // Update progress bars
    updateElement('overallProgress', progress + '%');
    const overallBar = document.getElementById('overallProgressBar');
    if (overallBar) overallBar.style.width = progress + '%';
    
    updateElement('tasksProgress', completedTasks + '/' + totalTasks);
    const tasksBar = document.getElementById('tasksProgressBar');
    if (tasksBar) tasksBar.style.width = progress + '%';
    
    // Calculate time progress
    if (projectData.start_date && projectData.due_date) {
        const start = new Date(projectData.start_date);
        const end = new Date(projectData.due_date);
        const today = new Date();
        const totalDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
        const elapsedDays = Math.ceil((today - start) / (1000 * 60 * 60 * 24));
        const timeProgress = totalDays > 0 ? Math.min(Math.round((elapsedDays / totalDays) * 100), 100) : 0;
        updateElement('timeProgress', timeProgress + '%');
        const timeBar = document.getElementById('timeProgressBar');
        if (timeBar) timeBar.style.width = timeProgress + '%';
    }
    
    // Update description
    const descEl = document.getElementById('projectDescription');
    if (descEl && projectData.description) {
        descEl.innerHTML = '<p>' + escapeHtml(projectData.description) + '</p>';
    }
    
    // Update quick stats
    updateElement('quickTotalTasks', totalTasks);
    updateElement('quickCompletedTasks', completedTasks);
    updateElement('quickTeamMembers', membersData.length);
    updateElement('quickComments', commentsData.length);
}

function switchTab(tabName) {
    document.querySelectorAll('.tab-nav-button').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    document.querySelectorAll('.tab-content-area').forEach(content => content.classList.remove('active'));
    document.getElementById(`tab-${tabName}`).classList.add('active');
}

let selectedMembersForAdd = [];

async function addNewMember() {
    if (typeof Swal === 'undefined') {
        console.error('SweetAlert2 not loaded');
        return;
    }
    
    try {
        selectedMembersForAdd = [];
        
        // Show loading state
        Swal.fire({
            title: 'Loading...',
            text: 'Fetching available employees',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => { Swal.showLoading(); }
        });
        
        // Fetch available users
        const response = await fetch(`{{ url('/projects') }}/${projectId}/available-users`, {
            headers: { 
                'X-Requested-With': 'XMLHttpRequest', 
                'Accept': 'application/json' 
            }
        });
        
        if (!response.ok) {
            throw new Error('Failed to fetch users');
        }
        
        const data = await response.json();
        console.log('Available users:', data);
        
        if (!data.success || !data.users || data.users.length === 0) {
            Swal.fire({
                icon: 'info',
                title: 'No Employees Available',
                text: 'All employees are already members of this project',
                confirmButtonColor: '#3b82f6',
                customClass: { popup: 'custom-swal-popup' }
            });
            return;
        }
        
        // Build employee cards grid
        const employeeCards = data.users.map(user => {
            // Use user's chat_color from database, fallback to random color
            const chatColor = user.chat_color || ['#6366f1', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6', '#ef4444', '#06b6d4', '#84cc16'][user.id % 8];
            const initial = user.name.charAt(0).toUpperCase();
            
            // Determine avatar display (photo or initial) - photo_path comes directly from API
            const photoPath = user.photo_path ? `{{ url('storage') }}/${user.photo_path}` : null;
            
            // Build avatar - photo with colored ring or initials on colored background
            let avatarContent = '';
            if (photoPath) {
                avatarContent = `<div style="width: 54px; height: 54px; border-radius: 50%; overflow: hidden; border: 2px solid white;">
                    <img src="${photoPath}" alt="${escapeHtml(user.name)}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.parentElement.innerHTML='<div style=\\'width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:20px;\\'>${initial}</div>';">
                </div>`;
            } else {
                avatarContent = `<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: 700;">${initial}</div>`;
            }
            
            // Position badge
            const positionBadge = user.position ? `<div style="font-size: 11px; color: #64748b; background: #f1f5f9; padding: 2px 8px; border-radius: 4px; display: inline-block; margin-top: 4px;">${escapeHtml(user.position)}</div>` : '';
            
            return `
                <div class="employee-select-card" data-id="${user.id}" data-name="${escapeHtml(user.name.toLowerCase())}" 
                     style="background: white; border: 2px solid #e2e8f0; border-radius: 12px; padding: 16px; text-align: center; cursor: pointer; transition: all 0.2s;"
                     onclick="toggleEmployeeSelection(${user.id}, '${escapeHtml(user.name)}', this)">
                    <div style="position: relative; display: inline-block;">
                        <div style="width: 64px; height: 64px; border-radius: 50%; background: ${chatColor}; margin: 0 auto 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.12); overflow: hidden; display: flex; align-items: center; justify-content: center;">
                            ${avatarContent}
                        </div>
                        <input type="checkbox" class="employee-checkbox" 
                               style="position: absolute; top: -4px; right: -4px; width: 20px; height: 20px; cursor: pointer; accent-color: #267bf5;">
                    </div>
                    <div style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 4px;">${escapeHtml(user.name)}</div>
                    ${user.code ? `<div style="font-size: 11px; color: #94a3b8; margin-bottom: 4px;">${escapeHtml(user.code)}</div>` : ''}
                    ${positionBadge}
                </div>
            `;
        }).join('');
        
        // Show the add member modal
        const result = await Swal.fire({
            title: '<div style="display: flex; align-items: center; gap: 12px; justify-content: center;"><div style="width: 48px; height: 48px; background: linear-gradient(135deg, #fff7ed, #ffedd5); border-radius: 12px; display: flex; align-items: center; justify-content: center;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></div><strong style="color: #111827; font-size: 26px; font-weight: 700; letter-spacing: -0.5px;">Select Team Members</strong></div>',
            html: `
                <div style="text-align: left;">
                    <div style="padding: 16px; border-bottom: 1px solid #e2e8f0; margin: -20px -24px 20px -24px;">
                        <input type="text" id="employeeSearch" placeholder="🔍 Search employees by name..." 
                               style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; transition: all 0.2s;"
                               onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)'"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'"
                               oninput="filterEmployeeCards(this.value)">
                    </div>
                    
                    <div id="employeeGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 16px; max-height: 400px; overflow-y: auto; padding: 4px;">
                        ${employeeCards}
                    </div>
                    
                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="font-size: 14px; color: #64748b;">
                                <span id="selectedCount" style="font-weight: 700; color: #267bf5; font-size: 18px;">0</span> 
                                <span style="font-weight: 500;">member(s) selected</span>
                            </div>
                        </div>
                        <div>
                            <label style="font-size: 13px; font-weight: 600; color: #64748b; margin-right: 8px;">Role:</label>
                            <select id="memberRole" style="padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 6px; background: white; color: #1e293b; font-size: 13px; font-weight: 600; cursor: pointer;">
                                <option value="member">Member</option>
                                <option value="lead">Lead</option>
                                <option value="viewer">Viewer</option>
                            </select>
                        </div>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 6px;"><polyline points="20 6 9 17 4 12"></polyline></svg> Add Selected Members',
            cancelButtonText: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 6px;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> Cancel',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            width: '800px',
            padding: '32px 24px 24px 24px',
            customClass: {
                popup: 'custom-swal-popup',
                confirmButton: 'custom-swal-confirm',
                cancelButton: 'custom-swal-cancel'
            },
            didOpen: () => {
                setTimeout(() => document.getElementById('employeeSearch').focus(), 100);
            },
            preConfirm: () => {
                if (selectedMembersForAdd.length === 0) {
                    Swal.showValidationMessage('⚠️ Please select at least one employee');
                    return false;
                }
                const role = document.getElementById('memberRole').value;
                return { members: selectedMembersForAdd, role: role };
            }
        });
        
        if (result.isConfirmed && result.value) {
            // Add all selected members
            let addedCount = 0;
            let failedCount = 0;
            
            for (const member of result.value.members) {
                try {
                    const addResponse = await fetch(`{{ url('/projects') }}/${projectId}/members`, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ user_id: member.id, role: result.value.role })
                    });
                    
                    if (addResponse.ok) {
                        addedCount++;
                    } else {
                        failedCount++;
                    }
                } catch (error) {
                    console.error('Error adding member:', error);
                    failedCount++;
                }
            }
            
            await loadTeamMembers();
            // Update member count
            const updateElement = (id, value) => {
                const el = document.getElementById(id);
                if (el) el.textContent = value;
            };
            updateElement('statMembers', membersData.length);
            updateElement('quickTeamMembers', membersData.length);
            
            if (addedCount > 0) {
                Swal.fire({
                    icon: 'success',
                    title: 'Members Added!',
                    text: `Successfully added ${addedCount} team member(s)${failedCount > 0 ? `. Failed to add ${failedCount} member(s).` : ''}`,
                    timer: 2500,
                    showConfirmButton: false,
                    customClass: { popup: 'custom-swal-popup' }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Failed to add members',
                    confirmButtonColor: '#ef4444',
                    customClass: { popup: 'custom-swal-popup' }
                });
            }
        }
    } catch (error) {
        console.error('Error in addNewMember:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to load available employees: ' + error.message,
            confirmButtonColor: '#ef4444',
            customClass: { popup: 'custom-swal-popup' }
        });
    }
}

function toggleEmployeeSelection(userId, userName, cardElement) {
    const checkbox = cardElement.querySelector('.employee-checkbox');
    checkbox.checked = !checkbox.checked;
    
    if (checkbox.checked) {
        if (!selectedMembersForAdd.find(m => m.id === userId)) {
            selectedMembersForAdd.push({ id: userId, name: userName });
        }
        cardElement.style.borderColor = '#267bf5';
        cardElement.style.background = '#f0f9ff';
        cardElement.style.transform = 'translateY(-2px)';
        cardElement.style.boxShadow = '0 4px 12px rgba(38, 123, 245, 0.15)';
    } else {
        selectedMembersForAdd = selectedMembersForAdd.filter(m => m.id !== userId);
        cardElement.style.borderColor = '#e2e8f0';
        cardElement.style.background = 'white';
        cardElement.style.transform = 'translateY(0)';
        cardElement.style.boxShadow = 'none';
    }
    
    document.getElementById('selectedCount').textContent = selectedMembersForAdd.length;
}

function filterEmployeeCards(searchTerm) {
    const term = searchTerm.toLowerCase();
    const cards = document.querySelectorAll('.employee-select-card');
    
    cards.forEach(card => {
        const name = card.dataset.name;
        if (name.includes(term)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

function uploadFiles(files) {
    if (!files || files.length === 0) return;
    
    const formData = new FormData();
    for (let i = 0; i < files.length; i++) {
        formData.append('files[]', files[i]);
    }
    
    // Show loading
    if (typeof toastr !== 'undefined') {
        toastr.info('Uploading files...');
    }
    
    fetch(`{{ url('/projects') }}/${projectId}/files`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (typeof toastr !== 'undefined') {
                toastr.success('Files uploaded successfully');
            }
            loadFiles();
        } else {
            if (typeof toastr !== 'undefined') {
                toastr.error('Failed to upload files');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (typeof toastr !== 'undefined') {
            toastr.error('Error uploading files');
        }
    });
    
    // Reset input
    document.getElementById('fileUploadInput').value = '';
}

function loadFiles() {
    // Placeholder for loading files
    // This would fetch files from the server
    const container = document.getElementById('filesList');
    container.innerHTML = `
        <div style="text-align: center; padding: 60px 20px; grid-column: 1/-1;">
            <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, #eff6ff, #dbeafe); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                    <polyline points="13 2 13 9 20 9"></polyline>
                </svg>
            </div>
            <h3 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0 0 8px 0;">Files uploaded!</h3>
            <p style="font-size: 14px; color: #6b7280; margin: 0;">File management coming soon</p>
        </div>
    `;
}

function escapeHtml(text) {
    const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
    return text.replace(/[&<>"']/g, m => map[m]);
}

// Function to open due date picker
async function openDueDatePicker() {
    const currentDueDate = projectData?.due_date || '';
    
    const { value: dueDate } = await Swal.fire({
        title: 'Set Project Deadline',
        html: `
            <div style="text-align: left; margin-top: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">Due Date:</label>
                <input type="date" id="swalDueDate" class="swal2-input" value="${currentDueDate}" 
                       style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; margin: 0;">
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Save',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        customClass: {
            popup: 'swal2-popup-custom',
            confirmButton: 'swal2-confirm-custom',
            cancelButton: 'swal2-cancel-custom'
        },
        didOpen: () => {
            document.getElementById('swalDueDate').focus();
        },
        preConfirm: () => {
            const dueDate = document.getElementById('swalDueDate').value;
            if (!dueDate) {
                Swal.showValidationMessage('Please select a due date');
                return false;
            }
            return dueDate;
        }
    });

    if (dueDate) {
        try {
            const response = await fetch(`{{ url('/projects') }}/${projectId}`, {
                method: 'PUT',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ due_date: dueDate })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // Update local project data
                if (projectData) {
                    projectData.due_date = dueDate;
                }
                
                // Update the display
                const dueDateElement = document.getElementById('projectDueDate');
                if (dueDateElement) {
                    const formattedDate = new Date(dueDate).toLocaleDateString('en-US', { 
                        year: 'numeric', 
                        month: 'short', 
                        day: 'numeric' 
                    });
                    dueDateElement.textContent = 'Due: ' + formattedDate;
                }
                
                if (typeof toastr !== 'undefined') {
                    toastr.success('Project deadline updated successfully');
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Project deadline updated successfully',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            } else {
                throw new Error(data.message || 'Failed to update deadline');
            }
        } catch (error) {
            console.error('Error updating deadline:', error);
            if (typeof toastr !== 'undefined') {
                toastr.error('Failed to update project deadline');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update project deadline',
                    confirmButtonColor: '#ef4444'
                });
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('=== PROJECT OVERVIEW INITIALIZED ===');
    console.log('Project ID:', projectId);
    console.log('API URL:', `{{ url('/projects') }}/${projectId}`);
    
    // Verify project ID exists
    if (!projectId || projectId === 'undefined') {
        console.error('ERROR: No project ID provided!');
        document.getElementById('projectName').textContent = 'Error: No Project ID';
        document.getElementById('mainProgressTasks').textContent = 'Invalid project';
        return;
    }
    
    // Show loading state
    document.getElementById('projectName').textContent = 'Loading...';
    document.getElementById('mainProgressTasks').textContent = 'Loading project data...';
    
    // Load project data
    console.log('Starting to load project data...');
    loadProjectData();
});
</script>

<!-- Material Assignment System -->
<script>
    // Set base URL for API calls
    window.appBaseUrl = '{{ url('/') }}';
</script>
<script src="{{ asset('js/project-materials.js') }}"></script>

@endpush
@endsection
