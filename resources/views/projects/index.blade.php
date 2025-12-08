@extends('layouts.macos')
@section('page_title', 'Projects')
@push('styles')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="{{ asset('new_theme/css/kanban.css') }}">
<style>
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
.member-card:hover {
  border-color: #267bf5 !important;
  background: #f0f9ff !important;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(38, 123, 245, 0.15) !important;
}

/* Modal and Date Input Fixes */
.modal-overlay {
  z-index: 9999 !important;
}

.modal-content {
  position: relative;
  z-index: 10000 !important;
}

/* jQuery UI Datepicker z-index fix for modals */
.ui-datepicker {
  z-index: 10001 !important;
}

/* Form Input Styling */
.form-group {
  margin-bottom: 16px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: #374151;
  font-size: 14px;
}

.form-input {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 14px;
  color: #1f2937;
  background: white;
  transition: all 0.2s;
}

.form-input:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-input::placeholder {
  color: #9ca3af;
}

/* Date Picker Styling (same as inquiry form) */
.date-picker-modal {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 12px center;
  padding-right: 40px !important;
  cursor: pointer !important;
}

/* Due Date Styles */
.card-date {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 11px;
  font-weight: 600;
  padding: 4px 8px;
  border-radius: 12px;
  background: #f3f4f6;
  color: #6b7280;
}

.card-date svg {
  flex-shrink: 0;
}

.card-date.overdue {
  background: #fee2e2;
  color: #dc2626;
}

.card-date.urgent {
  background: #fef3c7;
  color: #f59e0b;
}

.card-date.completed {
  background: #dcfce7;
  color: #16a34a;
}

.overdue-badge, .urgent-badge {
  font-size: 10px;
  padding: 2px 6px;
  border-radius: 8px;
  margin-left: 4px;
}

.overdue-badge {
  background: #dc2626;
  color: white;
}

.urgent-badge {
  background: #f59e0b;
  color: white;
}

/* View Toggle Buttons */
.view-toggle-group {
  display: flex;
  gap: 4px;
  background: #f3f4f6;
  padding: 4px;
  border-radius: 8px;
}

.view-toggle-btn {
  padding: 8px 12px;
  background: transparent;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.view-toggle-btn:hover {
  background: #e5e7eb;
}

.view-toggle-btn.active {
  background: white;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.view-toggle-btn svg {
  color: #6b7280;
}

.view-toggle-btn.active svg {
  color: #3b82f6;
}

/* Grid View Styles */
.projects-grid-view {
  display: none;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
  padding: 20px;
}

.projects-grid-view.active {
  display: grid;
}

.project-grid-card {
  background: white;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  transition: all 0.3s;
  cursor: pointer;
}

.project-grid-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
}

.project-grid-header {
  display: flex;
  justify-content: space-between;
  align-items: start;
  margin-bottom: 12px;
}

.project-grid-title {
  font-size: 16px;
  font-weight: 600;
  color: #1f2937;
  margin: 0;
}

.project-grid-stage {
  font-size: 11px;
  padding: 4px 8px;
  border-radius: 12px;
  font-weight: 500;
}

.project-grid-description {
  font-size: 13px;
  color: #6b7280;
  margin-bottom: 16px;
  line-height: 1.5;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.project-grid-meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 12px;
  border-top: 1px solid #f3f4f6;
}

.project-grid-progress {
  flex: 1;
  margin-right: 12px;
}

.project-grid-progress-text {
  font-size: 11px;
  color: #6b7280;
  margin-bottom: 4px;
}

.project-grid-progress-bar {
  height: 6px;
  background: #f3f4f6;
  border-radius: 3px;
  overflow: hidden;
}

.project-grid-progress-fill {
  height: 100%;
  background: #10b981;
  border-radius: 3px;
  transition: width 0.3s;
}

.project-grid-actions {
  display: flex;
  gap: 8px;
}

.project-grid-action-btn {
  padding: 8px;
  border: 1px solid #e5e7eb;
  background: white;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
}

.project-grid-action-btn.btn-view {
  border-color: #3b82f6;
  background: #eff6ff;
}

.project-grid-action-btn.btn-view svg {
  color: #3b82f6;
}

.project-grid-action-btn.btn-view:hover {
  background: #3b82f6;
}

.project-grid-action-btn.btn-view:hover svg {
  color: white;
}

.project-grid-action-btn.btn-edit {
  border-color: #f59e0b;
  background: #fffbeb;
}

.project-grid-action-btn.btn-edit svg {
  color: #f59e0b;
}

.project-grid-action-btn.btn-edit:hover {
  background: #f59e0b;
}

.project-grid-action-btn.btn-edit:hover svg {
  color: white;
}

.project-grid-action-btn.btn-delete {
  border-color: #ef4444;
  background: #fef2f2;
}

.project-grid-action-btn.btn-delete svg {
  color: #ef4444;
}

.project-grid-action-btn.btn-delete:hover {
  background: #ef4444;
}

.project-grid-action-btn.btn-delete:hover svg {
  color: white;
}

.project-grid-action-btn.btn-overview {
  border-color: #8b5cf6;
  background: #f5f3ff;
}

.project-grid-action-btn.btn-overview svg {
  color: #8b5cf6;
}

.project-grid-action-btn.btn-overview:hover {
  background: #8b5cf6;
}

.project-grid-action-btn.btn-overview:hover svg {
  color: white;
}

/* List View Styles */
.projects-list-view {
  display: none;
  padding: 20px;
}

.projects-list-view.active {
  display: block;
}

.projects-table {
  width: 100%;
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.projects-table table {
  width: 100%;
  border-collapse: collapse;
}

.projects-table thead {
  background: #f9fafb;
  border-bottom: 2px solid #e5e7eb;
}

.projects-table th {
  padding: 12px 16px;
  text-align: left;
  font-size: 12px;
  font-weight: 600;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.projects-table td {
  padding: 16px;
  border-bottom: 1px solid #f3f4f6;
  font-size: 14px;
  color: #1f2937;
}

.projects-table tbody tr {
  transition: background 0.2s;
}

.projects-table tbody tr:hover {
  background: #f9fafb;
}

.project-list-name {
  font-weight: 600;
  color: #1f2937;
  cursor: pointer;
}

.project-list-name:hover {
  color: #3b82f6;
}

.project-list-stage-badge {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: 500;
}

.project-list-progress {
  display: flex;
  align-items: center;
  gap: 8px;
}

.project-list-progress-bar {
  flex: 1;
  height: 6px;
  background: #f3f4f6;
  border-radius: 3px;
  overflow: hidden;
  max-width: 100px;
}

.project-list-progress-fill {
  height: 100%;
  background: #10b981;
  border-radius: 3px;
}

.project-list-progress-text {
  font-size: 12px;
  color: #6b7280;
  min-width: 45px;
}

.project-list-actions {
  display: flex;
  gap: 8px;
}

.project-list-action-btn {
  padding: 8px;
  border: 1px solid #e5e7eb;
  background: white;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
}

.project-list-action-btn.btn-view {
  border-color: #3b82f6;
  background: #eff6ff;
}

.project-list-action-btn.btn-view svg {
  color: #3b82f6;
}

.project-list-action-btn.btn-view:hover {
  background: #3b82f6;
}

.project-list-action-btn.btn-view:hover svg {
  color: white;
}

.project-list-action-btn.btn-edit {
  border-color: #f59e0b;
  background: #fffbeb;
}

.project-list-action-btn.btn-edit svg {
  color: #f59e0b;
}

.project-list-action-btn.btn-edit:hover {
  background: #f59e0b;
}

.project-list-action-btn.btn-edit:hover svg {
  color: white;
}

.project-list-action-btn.btn-delete {
  border-color: #ef4444;
  background: #fef2f2;
}

.project-list-action-btn.btn-delete svg {
  color: #ef4444;
}

.project-list-action-btn.btn-delete:hover {
  background: #ef4444;
}

.project-list-action-btn.btn-delete:hover svg {
  color: white;
}

.project-list-action-btn.btn-overview {
  border-color: #8b5cf6;
  background: #f5f3ff;
}

.project-list-action-btn.btn-overview svg {
  color: #8b5cf6;
}

.project-list-action-btn.btn-overview:hover {
  background: #8b5cf6;
}

.project-list-action-btn.btn-overview:hover svg {
  color: white;
}

/* Hide kanban board when other views are active */
.kanban-board.hidden {
  display: none;
}
</style>
@endpush
@section('content')
<div class="hrp-content">
  <!-- Header with search and controls -->
  <div class="kanban-header">
    <div class="search-container">
      <input type="text" class="kanban-search live-search" placeholder="Type to search..">
    </div>
    <div class="header-controls">
      <!-- View Toggle Buttons -->
      <div class="view-toggle-group">
        <button class="view-toggle-btn active" data-view="kanban" title="Kanban View">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="18" rx="1"></rect>
            <rect x="14" y="3" width="7" height="10" rx="1"></rect>
          </svg>
        </button>
        <button class="view-toggle-btn" data-view="grid" title="Grid View">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7" rx="1"></rect>
            <rect x="14" y="3" width="7" height="7" rx="1"></rect>
            <rect x="3" y="14" width="7" height="7" rx="1"></rect>
            <rect x="14" y="14" width="7" height="7" rx="1"></rect>
          </svg>
        </button>
        <button class="view-toggle-btn" data-view="list" title="List View">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="8" y1="6" x2="21" y2="6"></line>
            <line x1="8" y1="12" x2="21" y2="12"></line>
            <line x1="8" y1="18" x2="21" y2="18"></line>
            <line x1="3" y1="6" x2="3.01" y2="6"></line>
            <line x1="3" y1="12" x2="3.01" y2="12"></line>
            <line x1="3" y1="18" x2="3.01" y2="18"></line>
          </svg>
        </button>
      </div>
      @can('Projects Management.manage project')
        <button class="create-stage-btn" onclick="window.location.href='{{ route('project-stages.index') }}'" title="Manage Project Stages" style="background: #6b7280;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="3"></circle>
            <path d="M12 1v6m0 6v6"></path>
          </svg>
          Stages
        </button>
      @endcan
      @can('Projects Management.create project')
        <button class="create-stage-btn" onclick="openProjectModal()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
            <line x1="12" y1="5" x2="12" y2="19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <line x1="5" y1="12" x2="19" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
          Create Project
        </button>
      @endcan
    </div>
  </div>

  <!-- Kanban Board -->
  <div class="kanban-board">
    @foreach($stages as $stage)
    <div class="kanban-column" style="background: {{ $stage->color }}" data-stage-id="{{ $stage->id }}">
      <div class="column-header">
        <div class="column-title">
          <span>{{ $stage->name }}</span>
        </div>
        @can('Projects Management.create project')
          <button class="add-card-btn" onclick="openProjectModal({{ $stage->id }})">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
              <line x1="12" y1="5" x2="12" y2="19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <line x1="5" y1="12" x2="19" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </button>
        @endcan
      </div>
      <div class="kanban-cards" data-stage-id="{{ $stage->id }}">
        @foreach($stage->projects as $project)
        <div class="kanban-card clickable-card" draggable="true" data-project-id="{{ $project->id }}">
          <div class="card-header">
            <h3>{{ $project->name }}</h3>
            @if($project->due_date)
              @php
                $now = now();
                $dueDate = \Carbon\Carbon::parse($project->due_date);
                $daysLeft = (int) $now->diffInDays($dueDate, false);
                $isOverdue = $daysLeft < 0;
                $isUrgent = $daysLeft >= 0 && $daysLeft <= 3;
                $isCompleted = $project->status === 'completed';
                $absDays = abs($daysLeft);
                $dayText = $absDays === 1 ? 'day' : 'days';
              @endphp
              <span class="card-date {{ $isCompleted ? 'completed' : ($isOverdue ? 'overdue' : ($isUrgent ? 'urgent' : '')) }}">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="12" r="10"></circle>
                  <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                {{ $project->due_date->format('d M') }}
                @if($isOverdue && !$isCompleted)
                  <span class="overdue-badge">{{ $absDays }} {{ $dayText }} overdue</span>
                @elseif($isUrgent && !$isCompleted)
                  <span class="urgent-badge">{{ $daysLeft }} {{ $dayText }} left</span>
                @endif
              </span>
            @endif
          </div>
          <div class="card-meta">
            <div class="card-stats">
              <span class="stat-item">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" fill="none"/>
                  <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none"/>
                </svg>
              </span>
              <span class="stat-item">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                  <path d="M9 11H5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2h-4" stroke="currentColor" stroke-width="2" fill="none"/>
                  <polyline points="9,11 12,14 15,11" stroke="currentColor" stroke-width="2" fill="none"/>
                  <line x1="12" y1="2" x2="12" y2="14" stroke="currentColor" stroke-width="2"/>
                </svg>
              </span>
              <span class="task-count">{{ $project->completed_tasks }}/{{ $project->total_tasks }}</span>
            </div>
            <div class="card-avatars">
              @php
                $colors = ['#4F46E5', '#059669', '#DC2626', '#F59E0B', '#8B5CF6', '#EC4899', '#14B8A6', '#F97316'];
                $displayLimit = 3;
              @endphp
              @if($project->members->count() > 0)
                @foreach($project->members->take($displayLimit) as $index => $member)
                  @php
                    $initials = strtoupper(substr($member->name, 0, 1));
                    if (str_word_count($member->name) > 1) {
                      $words = explode(' ', $member->name);
                      $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                    }
                    $bgColor = $colors[$index % count($colors)];
                  @endphp
                  <div class="avatar" style="background: {{ $bgColor }};" title="{{ $member->name }}">{{ $initials }}</div>
                @endforeach
                @if($project->members->count() > $displayLimit)
                  <div class="avatar" style="background: #6B7280;" title="{{ $project->members->count() - $displayLimit }} more members">+{{ $project->members->count() - $displayLimit }}</div>
                @endif
              @else
                <div class="avatar" style="background: #9CA3AF;" title="No members assigned">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                  </svg>
                </div>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endforeach
  </div>

  <!-- Grid View -->
  <div class="projects-grid-view">
    @foreach($stages as $stage)
      @foreach($stage->projects as $project)
      <div class="project-grid-card" onclick="viewProject({{ $project->id }}, event)">
        <div class="project-grid-header">
          <h3 class="project-grid-title">{{ $project->name }}</h3>
          <span class="project-grid-stage" style="background: {{ $stage->color }}; color: #000;">
            {{ $stage->name }}
          </span>
        </div>
        
        @if($project->description)
        <p class="project-grid-description">{{ $project->description }}</p>
        @endif
        
        <div class="project-grid-meta">
          <div class="project-grid-progress">
            <div class="project-grid-progress-text">
              {{ $project->completed_tasks }}/{{ $project->total_tasks }} Tasks
            </div>
            <div class="project-grid-progress-bar">
              <div class="project-grid-progress-fill" style="width: {{ $project->progress }}%"></div>
            </div>
          </div>
          
          <div class="project-grid-actions" onclick="event.stopPropagation()">
            @can('Projects Management.view project')
              <button class="project-grid-action-btn btn-view" onclick="viewProject({{ $project->id }}, event)" title="View Project">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                  <circle cx="12" cy="12" r="3"></circle>
                </svg>
              </button>
            @endcan
            @can('Projects Management.edit project')
              <button class="project-grid-action-btn btn-edit" onclick="editProject({{ $project->id }})" title="Edit Project">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
              </button>
            @endcan
            @can('Projects Management.view project')
              <button class="project-grid-action-btn btn-overview" onclick="window.location.href='{{ url('/projects') }}/{{ $project->id }}/overview'" title="Project Overview">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="3" width="7" height="7"></rect>
                  <rect x="14" y="3" width="7" height="7"></rect>
                  <rect x="14" y="14" width="7" height="7"></rect>
                  <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
              </button>
            @endcan
            @can('Projects Management.delete project')
              <button class="project-grid-action-btn btn-delete" onclick="deleteProject({{ $project->id }})" title="Delete Project">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polyline points="3 6 5 6 21 6"></polyline>
                  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
              </button>
            @endcan
          </div>
        </div>
      </div>
      @endforeach
    @endforeach
  </div>

  <!-- List View -->
  <div class="projects-list-view">
    <div class="projects-table">
      <table>
        <thead>
          <tr>
            <th>Project Name</th>
            <th>Company</th>
            <th>Stage</th>
            <th>Progress</th>
            <th>Due Date</th>
            <th>Priority</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($stages as $stage)
            @foreach($stage->projects as $project)
            <tr>
              <td>
                <span class="project-list-name" onclick="viewProject({{ $project->id }}, event)">
                  {{ $project->name }}
                </span>
              </td>
              <td>{{ $project->company->company_name ?? 'N/A' }}</td>
              <td>
                <span class="project-list-stage-badge" style="background: {{ $stage->color }}; color: #000;">
                  {{ $stage->name }}
                </span>
              </td>
              <td>
                <div class="project-list-progress">
                  <div class="project-list-progress-bar">
                    <div class="project-list-progress-fill" style="width: {{ $project->progress }}%"></div>
                  </div>
                  <span class="project-list-progress-text">{{ $project->progress }}%</span>
                </div>
              </td>
              <td>{{ $project->due_date ? $project->due_date->format('M d, Y') : 'N/A' }}</td>
              <td>
                <span style="color: {{ $project->priority === 'high' ? '#ef4444' : ($project->priority === 'medium' ? '#f59e0b' : '#10b981') }}; font-weight: 500; text-transform: capitalize;">
                  {{ $project->priority ?? 'medium' }}
                </span>
              </td>
              <td>
                <div class="project-list-actions">
                  @can('Projects Management.view project')
                    <button class="project-list-action-btn btn-view" onclick="viewProject({{ $project->id }}, event)" title="View Project">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                      </svg>
                    </button>
                  @endcan
                  @can('Projects Management.edit project')
                    <button class="project-list-action-btn btn-edit" onclick="editProject({{ $project->id }})" title="Edit Project">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                      </svg>
                    </button>
                  @endcan
                  @can('Projects Management.view project')
                    <button class="project-list-action-btn btn-overview" onclick="window.location.href='{{ url('/projects') }}/{{ $project->id }}/overview'" title="Project Overview">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                      </svg>
                    </button>
                  @endcan
                  @can('Projects Management.delete project')
                    <button class="project-list-action-btn btn-delete" onclick="deleteProject({{ $project->id }})" title="Delete Project">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                      </svg>
                    </button>
                  @endcan
                </div>
              </td>
            </tr>
            @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Create Stage Modal -->
  <div id="stageModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Create New Stage</h3>
        <button onclick="closeStageModal()" class="close-btn">&times;</button>
      </div>
      <form id="stageForm">
        @csrf
        <div class="form-group">
          <label for="stageName">Stage Name</label>
          <input type="text" id="stageName" name="name" class="form-input" placeholder="Enter stage name" required>
        </div>
        <div class="form-group">
          <label for="stageColor">Choose Stage Color</label>
          <div class="color-input-wrapper">
            <div class="color-preview" id="colorPreview" style="background-color: #6b7280;" onclick="document.getElementById('stageColor').click()"></div>
            <input type="color" id="stageColor" name="color" class="color-input" value="#6b7280" required>
            <input type="text" id="colorText" class="color-text" value="#6B7280" readonly>
          </div>
          <div class="color-presets">
            <div class="color-preset" style="background: linear-gradient(135deg, #d3b5df, #c084fc);" onclick="setColor('#d3b5df')" title="Purple"></div>
            <div class="color-preset" style="background: linear-gradient(135deg, #ebc58f, #f59e0b);" onclick="setColor('#ebc58f')" title="Orange"></div>
            <div class="color-preset" style="background: linear-gradient(135deg, #b9f3fc, #3b82f6);" onclick="setColor('#b9f3fc')" title="Blue"></div>
            <div class="color-preset" style="background: linear-gradient(135deg, #abd1a5, #10b981);" onclick="setColor('#abd1a5')" title="Green"></div>
            <div class="color-preset" style="background: linear-gradient(135deg, #fca5a5, #ef4444);" onclick="setColor('#fca5a5')" title="Red"></div>
            <div class="color-preset" style="background: linear-gradient(135deg, #fde68a, #f59e0b);" onclick="setColor('#fde68a')" title="Yellow"></div>
            <div class="color-preset" style="background: linear-gradient(135deg, #c7d2fe, #6366f1);" onclick="setColor('#c7d2fe')" title="Indigo"></div>
            <div class="color-preset" style="background: linear-gradient(135deg, #fed7d7, #f87171);" onclick="setColor('#fed7d7')" title="Pink"></div>
          </div>
        </div>
        <div class="form-actions">
          <button type="button" onclick="closeStageModal()" class="btn-cancel">Cancel</button>
          <button type="submit" class="btn-create">Create Stage</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Create Project Modal -->
  <div id="projectModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 600px;">
      <div class="modal-header">
        <h3>Create New Project</h3>
        <button onclick="closeProjectModal()" class="close-btn">&times;</button>
      </div>
      <form id="projectForm">
        @csrf
        <input type="hidden" id="projectStageId" name="stage_id">
        
        <div class="form-group">
          <label for="projectName">Project Name <span style="color: red;">*</span></label>
          <input type="text" id="projectName" name="name" class="form-input" placeholder="Enter project name" required>
        </div>

        <div class="form-group">
          <label for="projectStage">Project Stage <span style="color: red;">*</span></label>
          <select id="projectStage" name="stage_id" class="form-input" required>
            <option value="">-- Select Stage --</option>
            @foreach($stages as $stage)
              <option value="{{ $stage->id }}">{{ $stage->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="projectCompany">Select Company</label>
          <select id="projectCompany" name="company_id" class="form-input">
            <option value="">-- Select Company --</option>
            @foreach($companies as $company)
              <option value="{{ $company->id }}">{{ $company->company_name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="projectDescription">Description</label>
          <textarea id="projectDescription" name="description" class="form-input" rows="3" placeholder="Enter project description"></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
          <div class="form-group">
            <label for="projectStartDate">Start Date</label>
            <input type="text" id="projectStartDate" name="start_date" class="form-input date-picker-modal" placeholder="dd/mm/yyyy" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="projectDueDate">Due Date (Deadline)</label>
            <input type="text" id="projectDueDate" name="due_date" class="form-input date-picker-modal" placeholder="dd/mm/yyyy" autocomplete="off">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
          <div class="form-group">
            <label for="projectPriority">Priority</label>
            <select id="projectPriority" name="priority" class="form-input">
              <option value="low">Low</option>
              <option value="medium" selected>Medium</option>
              <option value="high">High</option>
            </select>
          </div>

          <div class="form-group">
            <label for="projectStatus">Status</label>
            <select id="projectStatus" name="status" class="form-input">
              <option value="active" selected>Active</option>
              <option value="on_hold">On Hold</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="projectBudget">Budget</label>
          <input type="number" id="projectBudget" name="budget" class="form-input" placeholder="0.00" step="0.01" min="0">
        </div>

        <div class="form-actions">
          <button type="button" onclick="closeProjectModal()" class="btn-cancel">Cancel</button>
          <button type="submit" class="btn-create">Create Project</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Project Modal -->
  <div id="editProjectModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 600px;">
      <div class="modal-header">
        <h3>Edit Project</h3>
        <button onclick="closeEditProjectModal()" class="close-btn">&times;</button>
      </div>
      <form id="editProjectForm">
        @csrf
        @method('PATCH')
        <input type="hidden" id="editProjectId" name="project_id">
        
        <div class="form-group">
          <label for="editProjectName">Project Name <span style="color: red;">*</span></label>
          <input type="text" id="editProjectName" name="name" class="form-input" placeholder="Enter project name" required>
        </div>

        <div class="form-group">
          <label for="editProjectCompany">Select Company</label>
          <select id="editProjectCompany" name="company_id" class="form-input">
            <option value="">-- Select Company --</option>
            @foreach($companies as $company)
              <option value="{{ $company->id }}">{{ $company->company_name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="editProjectDescription">Description</label>
          <textarea id="editProjectDescription" name="description" class="form-input" rows="3" placeholder="Enter project description"></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
          <div class="form-group">
            <label for="editProjectStartDate">Start Date</label>
            <input type="text" id="editProjectStartDate" name="start_date" class="form-input date-picker-modal" placeholder="dd/mm/yyyy" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="editProjectDueDate">Due Date (Deadline)</label>
            <input type="text" id="editProjectDueDate" name="due_date" class="form-input date-picker-modal" placeholder="dd/mm/yyyy" autocomplete="off">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
          <div class="form-group">
            <label for="editProjectPriority">Priority</label>
            <select id="editProjectPriority" name="priority" class="form-input">
              <option value="low">Low</option>
              <option value="medium">Medium</option>
              <option value="high">High</option>
            </select>
          </div>

          <div class="form-group">
            <label for="editProjectStatus">Status</label>
            <select id="editProjectStatus" name="status" class="form-input">
              <option value="active">Active</option>
              <option value="on_hold">On Hold</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="editProjectBudget">Budget</label>
          <input type="number" id="editProjectBudget" name="budget" class="form-input" placeholder="0.00" step="0.01" min="0">
        </div>

        <div class="form-actions">
          <button type="button" onclick="closeEditProjectModal()" class="btn-cancel">Cancel</button>
          <button type="submit" class="btn-create">Update Project</button>
        </div>
      </form>
    </div>
  </div>

  <!-- View Project Modal -->
  <div id="viewProjectModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 1400px; width: 95%; max-height: 90vh; overflow-y: auto; border-radius: 16px; padding: 0; background: white;">
      <!-- Stage Badge -->
      <div style="padding: 14px 20px; border-bottom: 1px solid #f0f0f0;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
          <div style="display: flex; align-items: center; gap: 6px;">
            <span style="color: #d4a574; font-size: 14px;">📋</span>
            <span id="viewProjectStage" style="color: #000; font-size: 13px;"></span>
          </div>
          <button onclick="closeViewProjectModal()" style="background: none; border: none; cursor: pointer; color: #9ca3af; font-size: 20px; line-height: 1; padding: 0; width: 20px; height: 20px;">&times;</button>
        </div>
      </div>

      <!-- Project Content - Two Column Layout -->
      <div style="display: grid; grid-template-columns: 1fr 400px; gap: 0; height: calc(90vh - 60px);">
        
        <!-- LEFT COLUMN - Tasks -->
        <div style="padding: 20px 24px 24px; overflow-y: auto; border-right: 1px solid #e5e7eb;">
        <!-- Title -->
        <div style="margin-bottom: 16px;">
          <h2 id="viewProjectTitle" style="font-size: 24px; font-weight: 600; margin: 0; color: #000;"></h2>
        </div>
        
        <!-- Action Buttons -->
        <div style="display: flex; gap: 8px; margin-bottom: 16px; flex-wrap: wrap; align-items: center;">
          <button onclick="toggleAddTaskBox()" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 13px; background: white; border: 1px solid #e5e7eb; border-radius: 5px; cursor: pointer; font-size: 13px; color: #000; transition: all 0.2s;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <line x1="12" y1="5" x2="12" y2="19"></line>
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add Task
          </button>
          
          <button id="dueDateButton" onclick="openProjectDueDatePicker()" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 13px; background: white; border: 1px solid #e5e7eb; border-radius: 5px; cursor: pointer; font-size: 13px; color: #000; transition: all 0.2s;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='white'">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"></circle>
              <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <span id="dueDateText">Due Date</span>
          </button>
          <button onclick="openMaterialsModalInKanban()" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 13px; background: white; border: 1px solid #e5e7eb; border-radius: 5px; cursor: pointer; font-size: 13px; color: #000; transition: all 0.2s;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 11l3 3L22 4"></path>
              <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
            </svg>
            Auto Assign
          </button>
          <!-- <button  style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 13px; background: #10b981; border: none; border-radius: 5px; cursor: pointer; font-size: 13px; color: white; transition: all 0.2s; font-weight: 600;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 11l3 3L22 4"></path>
              <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
            </svg>
            Assign Materials
          </button> -->
          
          <!-- Members Section (inline, no border) -->
          <div style="display: flex; align-items: center; gap: 8px; padding: 0;">
            <span style="color: #000; font-size: 13px; font-weight: 500;">Members</span>
            <div id="projectMembersAvatars" style="display: flex; align-items: center; gap: 4px;">
              <!-- Member avatars will be added here -->
            </div>
          </div>
          
         
        </div>

        <!-- Company Selector -->
        <div style="margin-bottom: 20px;">
          <select id="viewProjectCompany" style="width: 50%; padding: 9px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background: #fafafa; color: #000; font-size: 13px; cursor: pointer; outline: none;">
            <option>Select Your Company</option>
          </select>
        </div>

        <!-- Description Section -->
        <div style="margin-bottom: 20px;">
          <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 10px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="3" y1="6" x2="21" y2="6"></line>
              <line x1="3" y1="12" x2="21" y2="12"></line>
              <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
            <h3 style="margin: 0; font-size: 15px; font-weight: 600; color: #000;">Description</h3>
          </div>
          <textarea id="viewProjectDescription" placeholder="Enter About Whole Project Description" style="width: 100%; background: #fafafa; border: 1px solid #e5e7eb; border-radius: 6px; padding: 14px; min-height: 100px; color: #000; font-size: 13px; line-height: 1.5; font-family: inherit; resize: vertical; outline: none;"></textarea>
        </div>

        <!-- Tasks Section -->
        <div>
          <!-- Add Task Form (Hidden by default) -->
          <div id="addTaskBox" style="display: none; margin-bottom: 16px; background: #fafafa; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px;">
            <div style="margin-bottom: 12px;">
              <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #000;">Task Name</label>
              <input type="text" id="newTaskTitle" placeholder="Enter task name..." style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background: white; color: #000; font-size: 13px; outline: none;">
            </div>
            <div style="margin-bottom: 12px;">
              <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #000;">Description</label>
              <textarea id="newTaskDescription" placeholder="Task details (optional)..." style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background: white; color: #000; font-size: 13px; outline: none; min-height: 60px; resize: vertical;"></textarea>
            </div>
            <div style="margin-bottom: 12px;">
              <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #000;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                  <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Assign To Employee
              </label>
              <select id="newTaskAssignedTo" style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background: white; color: #000; font-size: 13px; outline: none;">
                <option value="">Select Employee (Optional)</option>
              </select>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
              <div>
                <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #000;">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                  </svg>
                  Due Date
                </label>
                <input type="date" id="newTaskDueDate" style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background: white; color: #000; font-size: 13px; outline: none;">
              </div>
              <div>
                <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #000;">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                  </svg>
                  Due Time
                </label>
                <input type="time" id="newTaskDueTime" style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background: white; color: #000; font-size: 13px; outline: none;">
              </div>
            </div>
            <div style="display: flex; gap: 8px; justify-content: flex-end;">
              <button onclick="cancelAddTask()" style="padding: 8px 16px; background: white; border: 1px solid #e5e7eb; border-radius: 6px; cursor: pointer; font-size: 13px; color: #000; font-weight: 500;">Cancel</button>
              <button onclick="saveNewTask()" style="padding: 8px 16px; background: #10b981; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; color: white; font-weight: 600;">Add Task</button>
            </div>
          </div>

          <!-- Tasks Container -->
          <div id="tasksContainer">
            <!-- Tasks will be added here dynamically -->
          </div>
        </div>
        </div>
        <!-- End LEFT COLUMN -->
        
        <!-- RIGHT COLUMN - Group Chat -->
        <div style="display: flex; flex-direction: column; background: #f9fafb;">
          <!-- Chat Header -->
          <div style="padding: 20px; border-bottom: 1px solid #e5e7eb; background: white;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
              <div style="display: flex; align-items: center; gap: 10px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #000;">Group Chat</h3>
              </div>
            </div>
          </div>
          
          <!-- Chat Messages -->
          <div id="chatMessages" style="flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 16px;">
            <!-- Messages will be added here -->
            <div style="text-align: center; padding: 20px; color: #9ca3af; font-size: 13px;">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5" style="margin: 0 auto 10px;">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
              </svg>
              <p style="margin: 0;">Start a conversation with your team</p>
            </div>
          </div>
          
          <!-- Chat Input -->
          <div style="padding: 16px; background: white; border-top: 1px solid #e5e7eb;">
            <div style="display: flex; gap: 8px; margin-bottom: 10px;">
              <button onclick="formatText('bold')" title="Bold" style="padding: 6px 10px; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 13px; transition: all 0.2s;">B</button>
              <button onclick="formatText('italic')" title="Italic" style="padding: 6px 10px; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 4px; cursor: pointer; font-style: italic; font-size: 13px; transition: all 0.2s;">I</button>
              <button onclick="formatText('underline')" title="Underline" style="padding: 6px 10px; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 4px; cursor: pointer; text-decoration: underline; font-size: 13px; transition: all 0.2s;">U</button>
              <button onclick="insertEmoji('👍')" title="Thumbs up" style="padding: 6px 10px; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 4px; cursor: pointer; font-size: 13px; transition: all 0.2s;">👍</button>
              <button onclick="insertEmoji('❤️')" title="Heart" style="padding: 6px 10px; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 4px; cursor: pointer; font-size: 13px; transition: all 0.2s;">❤️</button>
              <button onclick="insertEmoji('🎉')" title="Party" style="padding: 6px 10px; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 4px; cursor: pointer; font-size: 13px; transition: all 0.2s;">🎉</button>
            </div>
            <div style="display: flex; gap: 8px;">
              <textarea id="chatInput" placeholder="Type a message..." style="flex: 1; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background: white; color: #000; font-size: 13px; outline: none; resize: none; min-height: 60px; font-family: inherit;" onkeypress="if(event.key === 'Enter' && !event.shiftKey) { event.preventDefault(); sendChatMessage(); }"></textarea>
              <button onclick="sendChatMessage()" style="padding: 10px 20px; background: #10b981; border: none; border-radius: 6px; cursor: pointer; color: white; font-weight: 600; font-size: 13px; align-self: flex-end; transition: all 0.2s;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="22" y1="2" x2="11" y2="13"></line>
                  <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
              </button>
            </div>
          </div>
        </div>
        <!-- End RIGHT COLUMN -->
        
      </div>
    </div>
  </div>

  <!-- Add Member Modal -->
  <div id="addMemberModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 10001; align-items: center; justify-content: center;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px);" onclick="closeAddMemberModal()"></div>
    <div style="position: relative; background: white; border-radius: 16px; width: 90%; max-width: 800px; max-height: 85vh; display: flex; flex-direction: column; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); animation: modalSlideIn 0.3s ease-out;">
      <div style="display: flex; align-items: center; justify-content: space-between; padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
        <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 8px;">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
          </svg>
          <span>Select Team Member</span>
        </h3>
        <button onclick="closeAddMemberModal()" style="background: none; border: none; font-size: 32px; color: #94a3b8; cursor: pointer; padding: 0; line-height: 1; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 4px; transition: all 0.2s ease;">×</button>
      </div>
      
      <div style="padding: 16px; border-bottom: 1px solid #e2e8f0;">
        <input type="text" id="memberSearch" placeholder="🔍 Search employees by name..." style="width: 100%; padding: 10px 16px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px;">
      </div>

      <div style="flex: 1; overflow-y: auto; padding: 20px;">
        <div id="memberGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 16px;">
          <!-- Employee cards will be added here -->
        </div>
      </div>

      <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 24px; border-top: 1px solid #e2e8f0; background: #f8fafc;">
        <div style="display: flex; align-items: center; gap: 12px;">
          <div style="font-size: 14px; color: #64748b;">
            <span id="selectedMemberCount" style="font-weight: 600; color: #267bf5;">0</span> member(s) selected
          </div>
          <select id="memberRole" style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; background: white; color: #1e293b; font-size: 13px; font-weight: 500;">
            <option value="member">Member</option>
            <option value="lead">Lead</option>
            <option value="viewer">Viewer</option>
          </select>
        </div>
        <div style="display: flex; gap: 10px;">
          <button onclick="closeAddMemberModal()" style="padding: 10px 20px; background: white; border: 1px solid #cbd5e1; border-radius: 8px; cursor: pointer; font-size: 14px; color: #64748b; font-weight: 500; transition: all 0.2s;">Cancel</button>
          <button onclick="addSelectedMembers()" style="padding: 10px 20px; background: #267bf5; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; color: white; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;">
            <span>✓</span> Add Members
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
// Set base URL for materials API
window.appBaseUrl = '{{ url('') }}';
console.log('Base URL set to:', window.appBaseUrl);
</script>
<script src="{{ asset('js/project-materials.js') }}?v={{ now()->timestamp }}"></script>
<script>
// Initialize jQuery datepicker with dd/mm/yyyy format (same as inquiry)
$(document).ready(function() {
    $('.date-picker-modal').datepicker({
        dateFormat: 'dd/mm/yy', // In jQuery UI, 'yy' means 4-digit year
        changeMonth: true,
        changeYear: true,
        yearRange: '-10:+10',
        showButtonPanel: true,
        beforeShow: function(input, inst) {
            setTimeout(function() {
                inst.dpDiv.css({
                    marginTop: '2px',
                    marginLeft: '0px',
                    zIndex: 10001
                });
            }, 0);
        }
    });
    
    // Set minimum date for due_date based on start_date in Create Modal
    $('#projectStartDate').on('change', function() {
        var startDate = $(this).datepicker('getDate');
        if (startDate) {
            $('#projectDueDate').datepicker('option', 'minDate', startDate);
        }
    });
    
    // Set minimum date for due_date based on start_date in Edit Modal
    $('#editProjectStartDate').on('change', function() {
        var startDate = $(this).datepicker('getDate');
        if (startDate) {
            $('#editProjectDueDate').datepicker('option', 'minDate', startDate);
        }
    });
});

let draggedElement = null;

// View Switching functionality
document.addEventListener('DOMContentLoaded', function() {
    initializeViewSwitching();
    initializeDragAndDrop();
    loadEmployeesForTasks();
});

function initializeViewSwitching() {
    const viewButtons = document.querySelectorAll('.view-toggle-btn');
    const kanbanView = document.querySelector('.kanban-board');
    const gridView = document.querySelector('.projects-grid-view');
    const listView = document.querySelector('.projects-list-view');
    
    // Load saved view preference
    const savedView = localStorage.getItem('projectView') || 'kanban';
    switchView(savedView);
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const view = this.dataset.view;
            switchView(view);
            localStorage.setItem('projectView', view);
        });
    });
    
    function switchView(view) {
        // Update button states
        viewButtons.forEach(btn => {
            btn.classList.toggle('active', btn.dataset.view === view);
        });
        
        // Show/hide views
        kanbanView.classList.toggle('hidden', view !== 'kanban');
        gridView.classList.toggle('active', view === 'grid');
        listView.classList.toggle('active', view === 'list');
    }
}

// Drag and Drop functionality
document.addEventListener('DOMContentLoaded', function() {
    initializeDragAndDrop();
});

function initializeDragAndDrop() {
    const cards = document.querySelectorAll('.kanban-card');
    const columns = document.querySelectorAll('.kanban-cards');
    let isDragging = false;
    let clickStartTime = 0;
    let clickStartX = 0;
    let clickStartY = 0;

    cards.forEach(card => {
        // Set draggable attribute
        card.setAttribute('draggable', 'true');
        card.style.cursor = 'grab';

        // Track mousedown for click detection
        card.addEventListener('mousedown', function(e) {
            clickStartTime = Date.now();
            clickStartX = e.clientX;
            clickStartY = e.clientY;
        });

        // Dragstart event
        card.addEventListener('dragstart', function(e) {
            isDragging = true;
            draggedElement = this;
            
            // Visual feedback
            setTimeout(() => {
                this.style.opacity = '0.4';
                this.classList.add('dragging');
            }, 0);
            
            // Set drag data
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', this.dataset.projectId);
            
            console.log('Drag started for project:', this.dataset.projectId);
        });

        // Dragend event
        card.addEventListener('dragend', function(e) {
            this.style.opacity = '1';
            this.classList.remove('dragging');
            
            // Clear all column highlights
            columns.forEach(col => {
                col.style.backgroundColor = '';
            });
            
            console.log('Drag ended');
            
            // Reset dragging state after a delay
            setTimeout(() => {
                isDragging = false;
                draggedElement = null;
            }, 50);
        });

        // Click event for opening modal
        card.addEventListener('click', function(e) {
            const clickDuration = Date.now() - clickStartTime;
            const moveX = Math.abs(e.clientX - clickStartX);
            const moveY = Math.abs(e.clientY - clickStartY);
            
            // Only open modal if it was a quick click with minimal movement
            if (!isDragging && clickDuration < 250 && moveX < 5 && moveY < 5) {
                const projectId = this.dataset.projectId;
                if (projectId) {
                    e.preventDefault();
                    e.stopPropagation();
                    viewProject(projectId, e);
                }
            }
        });
    });

    // Setup drop zones
    columns.forEach(column => {
        // Dragover - must prevent default to allow drop
        column.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (draggedElement) {
                e.dataTransfer.dropEffect = 'move';
                this.style.backgroundColor = 'rgba(255,255,255,0.2)';
            }
        });

        // Dragenter
        column.addEventListener('dragenter', function(e) {
            e.preventDefault();
            if (draggedElement) {
                this.style.backgroundColor = 'rgba(255,255,255,0.2)';
            }
        });

        // Dragleave
        column.addEventListener('dragleave', function(e) {
            // Check if we're actually leaving the column
            const rect = this.getBoundingClientRect();
            if (e.clientX < rect.left || e.clientX >= rect.right ||
                e.clientY < rect.top || e.clientY >= rect.bottom) {
                this.style.backgroundColor = '';
            }
        });

        // Drop event
        column.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            this.style.backgroundColor = '';
            
            if (draggedElement) {
                const projectId = draggedElement.dataset.projectId;
                const newStageId = this.dataset.stageId;
                const oldColumn = draggedElement.closest('.kanban-cards');
                const oldStageId = oldColumn ? oldColumn.dataset.stageId : null;
                
                console.log('DROP EVENT - Project:', projectId, 'Old Stage:', oldStageId, 'New Stage:', newStageId);
                
                // Move the card to the new column
                if (oldStageId !== newStageId) {
                    this.appendChild(draggedElement);
                    draggedElement.style.opacity = '1';
                    
                    // Update backend
                    updateProjectStage(projectId, newStageId);
                    
                    console.log('Card moved successfully!');
                } else {
                    console.log('Same column, no move needed');
                }
            }
        });
    });

    // Also add drop listeners to the column containers
    document.querySelectorAll('.kanban-column').forEach(column => {
        column.addEventListener('dragover', function(e) {
            e.preventDefault();
        });
        
        column.addEventListener('drop', function(e) {
            e.preventDefault();
            // Find the cards container within this column
            const cardsContainer = this.querySelector('.kanban-cards');
            if (cardsContainer && draggedElement) {
                const projectId = draggedElement.dataset.projectId;
                const newStageId = cardsContainer.dataset.stageId;
                const oldColumn = draggedElement.closest('.kanban-cards');
                const oldStageId = oldColumn ? oldColumn.dataset.stageId : null;
                
                if (oldStageId !== newStageId) {
                    cardsContainer.appendChild(draggedElement);
                    draggedElement.style.opacity = '1';
                    updateProjectStage(projectId, newStageId);
                }
            }
        });
    });

    // Color picker functionality
    const colorInput = document.getElementById('stageColor');
    const colorPreview = document.getElementById('colorPreview');
    const colorText = document.getElementById('colorText');

    if (colorInput && colorPreview && colorText) {
        colorInput.addEventListener('input', function() {
            const color = this.value;
            colorPreview.style.backgroundColor = color;
            colorText.value = color.toUpperCase();
        });
    }
}

function updateProjectStage(projectId, stageId) {
    console.log('🔄 Updating project', projectId, 'to stage', stageId);
    
    fetch('{{ url("/projects") }}/' + projectId + '/stage', {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ stage_id: stageId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('✅ Project stage updated successfully');
        } else {
            console.error('❌ Failed to update project stage:', data);
            toastr.error('Failed to update project. Please refresh the page.');
        }
    })
    .catch(error => {
        console.error('❌ Error updating project:', error);
        toastr.error('Error updating project. Please check your connection.');
    });
}

// Color preset function
function setColor(color) {
    const colorInput = document.getElementById('stageColor');
    const colorPreview = document.getElementById('colorPreview');
    const colorText = document.getElementById('colorText');
    
    colorInput.value = color;
    colorPreview.style.backgroundColor = color;
    colorText.value = color.toUpperCase();
}

// Modal functions
function openStageModal() {
    document.getElementById('stageModal').style.display = 'flex';
    // Reset form
    document.getElementById('stageName').value = '';
    setColor('#6b7280');
}

function closeStageModal() {
    document.getElementById('stageModal').style.display = 'none';
}

// Stage creation
document.getElementById('stageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ route("project-stages.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        closeStageModal();
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('Error creating stage. Please try again.');
    });
});

// Project Modal Functions
function openProjectModal(stageId) {
    document.getElementById('projectStageId').value = stageId;
    document.getElementById('projectModal').style.display = 'flex';
    // Reset form
    document.getElementById('projectForm').reset();
    document.getElementById('projectStageId').value = stageId;
}

function closeProjectModal() {
    document.getElementById('projectModal').style.display = 'none';
}

// Project creation
document.getElementById('projectForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    // Convert dates from dd/mm/yyyy to yyyy-mm-dd
    if (data.start_date) {
        const parts = data.start_date.split('/');
        if (parts.length === 3) {
            data.start_date = parts[2] + '-' + parts[1] + '-' + parts[0];
        }
    }
    if (data.due_date) {
        const parts = data.due_date.split('/');
        if (parts.length === 3) {
            data.due_date = parts[2] + '-' + parts[1] + '-' + parts[0];
        }
    }
    
    fetch('{{ route("projects.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            closeProjectModal();
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('Error creating project. Please try again.');
    });
});

// View Project Function
function viewProject(projectId, event) {
    console.log('viewProject called with ID:', projectId);
    
    // Set current project ID for member management
    currentProjectId = projectId;
    
    // Prevent drag event from triggering
    if (event) {
        event.stopPropagation();
        event.preventDefault();
    }
    
    // Show modal immediately
    const modal = document.getElementById('viewProjectModal');
    modal.style.display = 'flex';
    
    const url = '{{ url("/projects") }}/' + projectId;
    console.log('Fetching URL:', url);
    
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Response status:', response.status);
        
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Error response:', text);
                throw new Error(`HTTP ${response.status}: ${text}`);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (!data || !data.success || !data.project) {
            throw new Error('Invalid response format');
        }
        
        const project = data.project;
        console.log('Project data:', project);
        
        // Store due date globally for the date picker
        window.currentProjectDueDate = project.due_date || '';
        
        // Update modal content
        document.getElementById('viewProjectTitle').textContent = project.name;
        document.getElementById('viewProjectStage').textContent = project.stage ? project.stage.name : 'No Stage';
        
        // Update due date button
        if (project.due_date) {
            const formattedDate = new Date(project.due_date).toLocaleDateString('en-GB', { 
                day: '2-digit', 
                month: 'short'
            });
            document.getElementById('dueDateText').textContent = formattedDate;
            document.getElementById('dueDateButton').style.background = '#dcfce7';
            document.getElementById('dueDateButton').style.borderColor = '#bbf7d0';
            document.getElementById('dueDateButton').style.color = '#166534';
        } else {
            document.getElementById('dueDateText').textContent = 'Due Date';
            document.getElementById('dueDateButton').style.background = 'white';
            document.getElementById('dueDateButton').style.borderColor = '#e5e7eb';
            document.getElementById('dueDateButton').style.color = '#000';
        }
            
        // Update company selector with all companies
        const companySelect = document.getElementById('viewProjectCompany');
        let companyOptions = '<option value="">Select Your Company</option>';
        @foreach($companies as $comp)
            companyOptions += '<option value="{{ $comp->id }}" ' + (project.company_id == {{ $comp->id }} ? 'selected' : '') + '>{{ $comp->company_name }}</option>';
        @endforeach
        companySelect.innerHTML = companyOptions;
        companySelect.style.color = project.company_id ? '#000' : '#9ca3af';
        
        // Update description textarea
        const descTextarea = document.getElementById('viewProjectDescription');
        descTextarea.value = project.description || '';
        if (project.description) {
            descTextarea.style.color = '#000';
        } else {
            descTextarea.style.color = '#9ca3af';
        }
        
        // Save description on blur
        descTextarea.onblur = function() {
            saveProjectDescription(project.id, this.value);
        };
        
        // Save company on change
        companySelect.onchange = function() {
            saveProjectCompany(project.id, this.value);
        };
        
        // Load project members
        loadProjectMembers(project.id);
        
        // Load tasks for this project
        loadProjectTasks(project.id);
        
        // Load comments for this project
        loadComments(project.id);
        
        // Modal is already shown
    })
    .catch(error => {
        console.error('Error loading project:', error);
        console.error('Error stack:', error.stack);
        
        // Show error message
        toastr.error('Error loading project: ' + error.message);
        closeViewProjectModal();
    });
}

function closeViewProjectModal() {
    document.getElementById('viewProjectModal').style.display = 'none';
}

// Save project description
function saveProjectDescription(projectId, description) {
    fetch('{{ url("/projects") }}/' + projectId, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ description: description })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Description saved');
    })
    .catch(error => console.error('Error saving description:', error));
}

// Save project company
function saveProjectCompany(projectId, companyId) {
    fetch('{{ url("/projects") }}/' + projectId, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ company_id: companyId })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Company saved');
    })
    .catch(error => console.error('Error saving company:', error));
}

// Add member to project
function addProjectMember() {
    // For now, show a simple prompt. You can replace this with a proper modal later
    const memberName = prompt('Enter member name or initials:');
    if (memberName && memberName.trim()) {
        const initial = memberName.trim().charAt(0).toUpperCase();
        const membersContainer = document.getElementById('projectMembersAvatars');
        const memberColors = ['#4F46E5', '#059669', '#DC2626', '#F59E0B', '#8B5CF6', '#EC4899', '#14B8A6'];
        const currentMembers = membersContainer.querySelectorAll('div').length;
        const color = memberColors[currentMembers % memberColors.length];
        
        // Find the + button and insert before it
        const addButton = membersContainer.querySelector('button');
        const newMember = document.createElement('div');
        newMember.style.cssText = `width: 32px; height: 32px; border-radius: 50%; background: ${color}; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: 600; border: 2px solid white; margin-left: -10px; cursor: pointer;`;
        newMember.textContent = initial;
        newMember.title = memberName;
        
        membersContainer.insertBefore(newMember, addButton);
        
        // Here you would typically make an AJAX call to save the member to the database
        console.log('Member added:', memberName);
    }
}

// Task Management Functions
let currentProjectId = null;
let taskCounter = 0;
let employeesListForTasks = [];
let tasksDataStore = {}; // Store task data for editing

// Load employees list for task assignment
async function loadEmployeesForTasks() {
    try {
        const response = await fetch('{{ route("projects.employees.list") }}', {
            headers: { 
                'X-Requested-With': 'XMLHttpRequest', 
                'Accept': 'application/json' 
            }
        });
        const data = await response.json();
        if (data.success && data.employees) {
            employeesListForTasks = data.employees;
            // Populate the select dropdown
            const select = document.getElementById('newTaskAssignedTo');
            if (select) {
                select.innerHTML = '<option value="">Select Employee (Optional)</option>';
                data.employees.forEach(emp => {
                    const option = document.createElement('option');
                    option.value = emp.id;
                    option.textContent = emp.name;
                    select.appendChild(option);
                });
            }
        }
    } catch (error) {
        console.error('Error loading employees:', error);
    }
}

function toggleAddTaskBox() {
    const addTaskBox = document.getElementById('addTaskBox');
    const isHidden = addTaskBox.style.display === 'none';
    
    if (isHidden) {
        addTaskBox.style.display = 'block';
        document.getElementById('newTaskTitle').focus();
    } else {
        addTaskBox.style.display = 'none';
    }
}

function cancelAddTask() {
    document.getElementById('addTaskBox').style.display = 'none';
    document.getElementById('newTaskTitle').value = '';
    document.getElementById('newTaskDescription').value = '';
    document.getElementById('newTaskAssignedTo').value = '';
    document.getElementById('newTaskDueDate').value = '';
    document.getElementById('newTaskDueTime').value = '';
}

function saveNewTask() {
    const taskTitle = document.getElementById('newTaskTitle').value.trim();
    if (!taskTitle) {
        return; // Just return if empty, no alert
    }
    
    taskCounter++;
    const taskId = 'task-' + taskCounter;
    
    const taskHTML = `
        <div id="${taskId}" style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; margin-bottom: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <!-- Task Header -->
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <input type="checkbox" onchange="toggleTaskComplete('${taskId}')" style="width: 18px; height: 18px; cursor: pointer; flex-shrink: 0;">
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div class="task-title" style="font-size: 15px; font-weight: 600; color: #000;">${taskTitle}</div>
                        <button onclick="deleteTask('${taskId}')" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #fee2e2; border: 1px solid #fecaca; border-radius: 6px; cursor: pointer; transition: all 0.2s;" title="Delete task">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div style="margin-left: 30px; margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span id="${taskId}-progress-text" style="font-size: 13px; font-weight: 600; color: #000; min-width: 35px;">0%</span>
                    <div style="flex: 1; height: 8px; background: #e5e7eb; border-radius: 10px; overflow: hidden;">
                        <div id="${taskId}-progress-bar" style="height: 100%; width: 0%; background: linear-gradient(90deg, #10b981, #059669); transition: width 0.3s ease;"></div>
                    </div>
                </div>
            </div>
            
            <!-- Collapsible Subtasks Section -->
            <div style="margin-left: 30px;">
                <button onclick="toggleSubtasksSection('${taskId}')" style="display: flex; align-items: center; gap: 8px; padding: 6px 0; background: none; border: none; cursor: pointer; margin-bottom: 12px; color: #000; font-size: 13px; font-weight: 500;">
                    <svg id="${taskId}-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transition: transform 0.2s;">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span id="${taskId}-subtask-count">0 subtasks</span>
                </button>
                
                <!-- Subtasks Container -->
                <div id="${taskId}-subtasks" style="display: none; margin-bottom: 12px;">
                    <!-- Subtasks will be added here -->
                </div>
                
                <!-- Add Subtask Box (Hidden) -->
                <div id="${taskId}-subtask-box" style="display: none; margin-bottom: 12px;">
                    <input type="text" id="${taskId}-subtask-input" placeholder="Enter subtask name..." style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background: white; color: #000; font-size: 13px; outline: none; margin-bottom: 10px;">
                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                        <button onclick="cancelAddSubtask('${taskId}')" style="padding: 8px 16px; background: white; border: 1px solid #e5e7eb; border-radius: 6px; cursor: pointer; font-size: 13px; color: #000; font-weight: 500;">Cancel</button>
                        <button onclick="saveSubtask('${taskId}')" style="padding: 8px 16px; background: #10b981; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; color: white; font-weight: 600;">Add</button>
                    </div>
                </div>
                
                <!-- Add Item Button -->
                <button onclick="toggleAddSubtask('${taskId}')" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 6px; cursor: pointer; font-size: 13px; color: #000; transition: all 0.2s; font-weight: 500;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add an item
                </button>
            </div>
                    
                    <!-- Subtasks Container -->
                    <div id="${taskId}-subtasks" style="margin-bottom: 10px;">
                        <!-- Subtasks will be added here -->
                    </div>
                    
                    <!-- Add Subtask Box (Hidden) -->
                    <div id="${taskId}-subtask-box" style="display: none; margin-bottom: 10px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 5px; padding: 10px;">
                        <input type="text" id="${taskId}-subtask-input" placeholder="Enter subtask..." style="width: 100%; padding: 8px 10px; border: 1px solid #e5e7eb; border-radius: 4px; background: white; color: #000; font-size: 12px; outline: none; margin-bottom: 8px;" onkeypress="if(event.key === 'Enter') saveSubtask('${taskId}')">
                        <div style="display: flex; gap: 6px; justify-content: flex-end;">
                            <button onclick="cancelAddSubtask('${taskId}')" style="padding: 5px 12px; background: white; border: 1px solid #e5e7eb; border-radius: 4px; cursor: pointer; font-size: 12px; color: #000;">Cancel</button>
                            <button onclick="saveSubtask('${taskId}')" style="padding: 5px 12px; background: #10b981; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; color: white; font-weight: 600;">Add</button>
                        </div>
                    </div>
                    
                    <!-- Add More Button -->
                    <button onclick="toggleAddSubtask('${taskId}')" style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 5px; cursor: pointer; font-size: 12px; color: #000; transition: all 0.2s;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add more
                    </button>
                </div>
            </div>
        </div>
    `;
    
    // Save to database
    if (!currentProjectId) {
        toastr.warning('Please open a project first');
        return;
    }
    
    fetch(`{{ url('/projects') }}/${currentProjectId}/tasks`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            title: taskTitle,
            description: document.getElementById('newTaskDescription').value.trim(),
            assigned_to: document.getElementById('newTaskAssignedTo').value || null,
            due_date: document.getElementById('newTaskDueDate').value || null,
            due_time: document.getElementById('newTaskDueTime').value || null,
            parent_id: null
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.task) {
            // Use the database ID
            const dbTaskId = 'task-' + data.task.id;
            const updatedHTML = taskHTML.replace(new RegExp(taskId, 'g'), dbTaskId);
            document.getElementById('tasksContainer').insertAdjacentHTML('beforeend', updatedHTML);
            
            // Clear all inputs and hide the form
            document.getElementById('newTaskTitle').value = '';
            document.getElementById('newTaskDescription').value = '';
            document.getElementById('newTaskAssignedTo').value = '';
            document.getElementById('newTaskDueDate').value = '';
            document.getElementById('newTaskDueTime').value = '';
            document.getElementById('addTaskBox').style.display = 'none';
        } else {
            toastr.error('Failed to save task');
        }
    })
    .catch(error => {
        console.error('Error saving task:', error);
        toastr.error('Error saving task. Please try again.');
    });
}

async function toggleTaskComplete(taskId) {
    const taskElement = document.getElementById(taskId);
    const checkbox = taskElement.querySelector('input[type="checkbox"]');
    const titleElement = taskElement.querySelector('.task-title');
    const isCompleted = checkbox.checked;
    
    // Update UI immediately
    if (isCompleted) {
        titleElement.style.textDecoration = 'line-through';
        titleElement.style.color = '#9ca3af';
        taskElement.style.background = '#f0fdf4';
    } else {
        titleElement.style.textDecoration = 'none';
        titleElement.style.color = '#000';
        taskElement.style.background = 'white';
    }
    
    // If checking the main task, automatically check all subtasks
    if (isCompleted) {
        const subtasksContainer = document.getElementById(taskId + '-subtasks');
        const subtaskCheckboxes = subtasksContainer.querySelectorAll('input[type="checkbox"]');
        
        // Check all subtasks
        for (const subtaskCheckbox of subtaskCheckboxes) {
            if (!subtaskCheckbox.checked) {
                subtaskCheckbox.checked = true;
                const subtaskElement = subtaskCheckbox.closest('[id^="' + taskId + '-sub-"]');
                if (subtaskElement) {
                    const subtaskId = subtaskElement.id;
                    // Update subtask UI
                    const textElement = subtaskElement.querySelector('.subtask-text');
                    if (textElement) {
                        textElement.style.textDecoration = 'line-through';
                        textElement.style.color = '#9ca3af';
                    }
                    subtaskElement.style.borderLeftColor = '#10b981';
                    
                    // Save subtask to database
                    const subtaskDbId = subtaskId.split('-sub-')[1];
                    await fetch(`{{ url('/projects') }}/${currentProjectId}/tasks/${subtaskDbId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ is_completed: true })
                    }).catch(err => console.error('Error updating subtask:', err));
                }
            }
        }
    }
    
    // Extract task database ID from taskId (format: task-123)
    const taskDbId = taskId.split('-')[1];
    
    // Save main task to database
    try {
        const response = await fetch(`{{ url('/projects') }}/${currentProjectId}/tasks/${taskDbId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                is_completed: isCompleted
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Update task progress bar
            updateTaskProgress(taskId);
            // Update the kanban card task count
            updateKanbanCardTaskCount();
            if (typeof toastr !== 'undefined') {
                toastr.success(isCompleted ? 'Task and all subtasks completed!' : 'Task reopened');
            }
        } else {
            // Revert checkbox on error
            checkbox.checked = !isCompleted;
            if (typeof toastr !== 'undefined') {
                toastr.error('Failed to update task');
            }
        }
    } catch (error) {
        console.error('Error updating task:', error);
        // Revert checkbox on error
        checkbox.checked = !isCompleted;
        if (typeof toastr !== 'undefined') {
            toastr.error('Failed to update task');
        }
    }
}

function toggleAddSubtask(taskId) {
    const subtaskBox = document.getElementById(taskId + '-subtask-box');
    const isHidden = subtaskBox.style.display === 'none';
    subtaskBox.style.display = isHidden ? 'block' : 'none';
    if (isHidden) {
        document.getElementById(taskId + '-subtask-input').focus();
    }
}

function cancelAddSubtask(taskId) {
    document.getElementById(taskId + '-subtask-box').style.display = 'none';
    document.getElementById(taskId + '-subtask-input').value = '';
}

function toggleSubtaskDate(subtaskId) {
    const dateInput = document.getElementById(subtaskId + '-date-input');
    if (dateInput) {
        dateInput.showPicker ? dateInput.showPicker() : dateInput.click();
    }
}

function saveSubtaskDate(subtaskId) {
    const dateInput = document.getElementById(subtaskId + '-date-input');
    const dateDisplay = document.getElementById(subtaskId + '-date');
    
    if (dateInput.value) {
        // Extract subtask ID (format: task-123-sub-456)
        const parts = subtaskId.split('-sub-');
        const subtaskDbId = parts[1];
        
        // Save to database
        fetch(`{{ url('/projects') }}/${currentProjectId}/tasks/${subtaskDbId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                due_date: dateInput.value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const date = new Date(dateInput.value);
                const formatted = date.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
                dateDisplay.textContent = formatted;
                dateDisplay.style.display = 'block';
            }
        })
        .catch(error => console.error('Error saving date:', error));
    } else {
        dateDisplay.style.display = 'none';
    }
}

function saveSubtask(taskId) {
    const subtaskInput = document.getElementById(taskId + '-subtask-input');
    const subtaskTitle = subtaskInput.value.trim();
    
    if (!subtaskTitle) {
        toastr.warning('Please enter a subtask');
        return;
    }
    
    const subtaskId = taskId + '-sub-' + Date.now();
    const subtaskHTML = `
        <div id="${subtaskId}" style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-left: 3px solid #e5e7eb; margin-bottom: 6px; transition: all 0.2s;">
            <button onclick="toggleSubtaskDate('${subtaskId}')" style="display: flex; align-items: center; justify-content: center; background: none; border: none; cursor: pointer; padding: 0; flex-shrink: 0;" title="Add due date">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 6v6l4 2"></path>
                </svg>
            </button>
            <input type="checkbox" onchange="toggleSubtaskComplete('${subtaskId}', '${taskId}')" style="width: 16px; height: 16px; cursor: pointer; flex-shrink: 0;">
            <span class="subtask-text" style="font-size: 13px; color: #000; flex: 1;">${subtaskTitle}</span>
            <span id="${subtaskId}-date" style="font-size: 12px; color: #6b7280; flex-shrink: 0; display: none;"></span>
            <input type="date" id="${subtaskId}-date-input" style="position: absolute; opacity: 0; pointer-events: none;" onchange="saveSubtaskDate('${subtaskId}')">
            <button onclick="deleteSubtask('${subtaskId}', '${taskId}')" style="display: flex; align-items: center; justify-content: center; width: 26px; height: 26px; background: #fee2e2; border: 1px solid #fecaca; border-radius: 5px; cursor: pointer; flex-shrink: 0; transition: all 0.2s;" title="Delete subtask">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
            </button>
        </div>
    `;
    
    // Extract parent task ID from taskId (format: task-123)
    const parentTaskId = taskId.replace('task-', '');
    
    // Save to database
    if (!currentProjectId) {
        toastr.warning('Please open a project first');
        return;
    }
    
    fetch(`{{ url('/projects') }}/${currentProjectId}/tasks`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            title: subtaskTitle,
            parent_id: parentTaskId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.task) {
            // Use the database ID
            const dbSubtaskId = taskId + '-sub-' + data.task.id;
            const updatedHTML = subtaskHTML.replace(new RegExp(subtaskId, 'g'), dbSubtaskId);
            document.getElementById(taskId + '-subtasks').insertAdjacentHTML('beforeend', updatedHTML);
            
            // Show subtasks section if hidden
            const subtasksContainer = document.getElementById(taskId + '-subtasks');
            const arrow = document.getElementById(taskId + '-arrow');
            if (subtasksContainer.style.display === 'none') {
                subtasksContainer.style.display = 'block';
                arrow.style.transform = 'rotate(90deg)';
            }
            
            updateTaskProgress(taskId);
            cancelAddSubtask(taskId);
        } else {
            toastr.error('Failed to save subtask');
        }
    })
    .catch(error => {
        console.error('Error saving subtask:', error);
        toastr.error('Error saving subtask. Please try again.');
    });
}

async function toggleSubtaskComplete(subtaskId, taskId) {
    const subtaskElement = document.getElementById(subtaskId);
    const checkbox = subtaskElement.querySelector('input[type="checkbox"]');
    const textElement = subtaskElement.querySelector('.subtask-text');
    
    const isCompleted = checkbox.checked;
    
    // Update UI immediately
    if (isCompleted) {
        textElement.style.textDecoration = 'line-through';
        textElement.style.color = '#9ca3af';
        subtaskElement.style.borderLeftColor = '#10b981';
    } else {
        textElement.style.textDecoration = 'none';
        textElement.style.color = '#000';
        subtaskElement.style.borderLeftColor = '#e5e7eb';
    }
    
    // Save to database
    const parts = subtaskId.split('-sub-');
    const subtaskDbId = parts[1];
    
    try {
        const response = await fetch(`{{ url('/projects') }}/${currentProjectId}/tasks/${subtaskDbId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                is_completed: isCompleted
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Update progress
            updateTaskProgress(taskId);
            
            // Check if all subtasks are now completed
            const subtasksContainer = document.getElementById(taskId + '-subtasks');
            const allSubtaskCheckboxes = subtasksContainer.querySelectorAll('input[type="checkbox"]');
            const allCompleted = Array.from(allSubtaskCheckboxes).every(cb => cb.checked);
            
            // If all subtasks are completed, automatically check the main task
            if (allCompleted && allSubtaskCheckboxes.length > 0) {
                const taskElement = document.getElementById(taskId);
                const mainTaskCheckbox = taskElement.querySelector('input[type="checkbox"]');
                
                if (mainTaskCheckbox && !mainTaskCheckbox.checked) {
                    mainTaskCheckbox.checked = true;
                    
                    // Update main task UI
                    const titleElement = taskElement.querySelector('.task-title');
                    titleElement.style.textDecoration = 'line-through';
                    titleElement.style.color = '#9ca3af';
                    taskElement.style.background = '#f0fdf4';
                    
                    // Save main task to database
                    const taskDbId = taskId.split('-')[1];
                    await fetch(`{{ url('/projects') }}/${currentProjectId}/tasks/${taskDbId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ is_completed: true })
                    }).catch(err => console.error('Error updating main task:', err));
                    
                    if (typeof toastr !== 'undefined') {
                        toastr.success('All subtasks completed! Task marked as complete.');
                    }
                }
            }
            
            // If unchecking a subtask, uncheck the main task too
            if (!isCompleted) {
                const taskElement = document.getElementById(taskId);
                const mainTaskCheckbox = taskElement.querySelector('input[type="checkbox"]');
                
                if (mainTaskCheckbox && mainTaskCheckbox.checked) {
                    mainTaskCheckbox.checked = false;
                    
                    // Update main task UI
                    const titleElement = taskElement.querySelector('.task-title');
                    titleElement.style.textDecoration = 'none';
                    titleElement.style.color = '#000';
                    taskElement.style.background = 'white';
                    
                    // Save main task to database
                    const taskDbId = taskId.split('-')[1];
                    await fetch(`{{ url('/projects') }}/${currentProjectId}/tasks/${taskDbId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ is_completed: false })
                    }).catch(err => console.error('Error updating main task:', err));
                }
            }
            
            // Update kanban card
            updateKanbanCardTaskCount();
        } else {
            // Revert on error
            checkbox.checked = !isCompleted;
            toggleSubtaskComplete(subtaskId, taskId);
        }
    } catch (error) {
        console.error('Error saving completion:', error);
        // Revert on error
        checkbox.checked = !isCompleted;
    }
}

function toggleSubtasksSection(taskId) {
    const subtasksContainer = document.getElementById(taskId + '-subtasks');
    const arrow = document.getElementById(taskId + '-arrow');
    const isHidden = subtasksContainer.style.display === 'none';
    
    if (isHidden) {
        subtasksContainer.style.display = 'block';
        arrow.style.transform = 'rotate(90deg)';
    } else {
        subtasksContainer.style.display = 'none';
        arrow.style.transform = 'rotate(0deg)';
    }
}

function updateTaskProgress(taskId) {
    const subtasksContainer = document.getElementById(taskId + '-subtasks');
    const checkboxes = subtasksContainer.querySelectorAll('input[type="checkbox"]');
    const total = checkboxes.length;
    const completed = Array.from(checkboxes).filter(cb => cb.checked).length;
    
    let percentage = 0;
    
    // If there are subtasks, calculate based on subtask completion
    if (total > 0) {
        percentage = Math.round((completed / total) * 100);
    } else {
        // If no subtasks, check if the main task itself is completed
        const taskElement = document.getElementById(taskId);
        const mainTaskCheckbox = taskElement.querySelector('input[type="checkbox"]');
        percentage = mainTaskCheckbox && mainTaskCheckbox.checked ? 100 : 0;
    }
    
    document.getElementById(taskId + '-progress-text').textContent = percentage + '%';
    document.getElementById(taskId + '-progress-bar').style.width = percentage + '%';
    
    // Update subtask count
    document.getElementById(taskId + '-subtask-count').textContent = total + ' subtask' + (total !== 1 ? 's' : '');
}

// Update kanban card task count after task completion changes
function updateKanbanCardTaskCount() {
    if (!currentProjectId) return;
    
    // Count all tasks and completed tasks in the modal
    const tasksContainer = document.getElementById('tasksContainer');
    if (!tasksContainer) return;
    
    const allTaskCheckboxes = tasksContainer.querySelectorAll('input[type="checkbox"]');
    const totalTasks = allTaskCheckboxes.length;
    const completedTasks = Array.from(allTaskCheckboxes).filter(cb => cb.checked).length;
    
    // Update the kanban card
    const kanbanCard = document.querySelector(`.kanban-card[data-project-id="${currentProjectId}"]`);
    if (kanbanCard) {
        const taskCountElement = kanbanCard.querySelector('.task-count');
        if (taskCountElement) {
            taskCountElement.textContent = `${completedTasks}/${totalTasks}`;
        }
    }
}

// Edit task in kanban view
function editTaskInKanban(taskId) {
    const task = tasksDataStore[taskId];
    if (!task) {
        toastr.error('Task data not found');
        return;
    }
    
    const taskDbId = taskId.replace('task-', '');
    
    // Build employees options
    let employeesOptions = '<option value="">Select Employee (Optional)</option>';
    employeesListForTasks.forEach(emp => {
        const selected = task.assigned_to == emp.id ? 'selected' : '';
        employeesOptions += `<option value="${emp.id}" ${selected}>${emp.name}</option>`;
    });
    
    Swal.fire({
        title: 'Edit Task',
        html: `
            <div style="text-align: left;">
                <div style="margin-bottom: 16px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #000;">Task Name</label>
                    <input type="text" id="editTaskTitle" value="${task.title || ''}" placeholder="Enter task name..." style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background: white; color: #000; font-size: 13px; outline: none;">
                </div>
                <div style="margin-bottom: 16px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #000;">Description</label>
                    <textarea id="editTaskDescription" placeholder="Task details..." style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background: white; color: #000; font-size: 13px; outline: none; min-height: 60px; resize: vertical;">${task.description || ''}</textarea>
                </div>
                <div style="margin-bottom: 16px;">
                    <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #000;">Assign To Employee</label>
                    <select id="editTaskAssignedTo" style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background: white; color: #000; font-size: 13px; outline: none;">
                        ${employeesOptions}
                    </select>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #000;">Due Date</label>
                        <input type="date" id="editTaskDueDate" value="${task.due_date || ''}" style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background: white; color: #000; font-size: 13px; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #000;">Due Time</label>
                        <input type="time" id="editTaskDueTime" value="${task.due_time || ''}" style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background: white; color: #000; font-size: 13px; outline: none;">
                    </div>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Update Task',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#f59e0b',
        cancelButtonColor: '#6b7280',
        width: '600px',
        preConfirm: () => {
            const title = document.getElementById('editTaskTitle').value.trim();
            if (!title) {
                Swal.showValidationMessage('Please enter a task title');
                return false;
            }
            return {
                title: title,
                description: document.getElementById('editTaskDescription').value.trim(),
                assigned_to: document.getElementById('editTaskAssignedTo').value || null,
                due_date: document.getElementById('editTaskDueDate').value || null,
                due_time: document.getElementById('editTaskDueTime').value || null
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Update task via API
            fetch(`{{ url('/projects') }}/${currentProjectId}/tasks/${taskDbId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(result.value)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success('Task updated successfully');
                    // Reload tasks to show updated data
                    loadProjectTasks(currentProjectId);
                } else {
                    toastr.error('Failed to update task');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('Error updating task');
            });
        }
    });
}

// Delete task function
function deleteTask(taskId) {
    Swal.fire({
        title: 'Delete Task?',
        text: "This action cannot be undone",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        customClass: { popup: 'perfect-swal-popup' }
    }).then((result) => {
        if (result.isConfirmed) {
            const taskDbId = taskId.replace('task-', '');
            
            fetch(`{{ url('/projects') }}/${currentProjectId}/tasks/${taskDbId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const taskElement = document.getElementById(taskId);
                    taskElement.style.transition = 'opacity 0.3s, transform 0.3s';
                    taskElement.style.opacity = '0';
                    taskElement.style.transform = 'translateX(-20px)';
                    
                    setTimeout(() => {
                        taskElement.remove();
                        toastr.success('Task deleted successfully');
                    }, 300);
                } else {
                    toastr.error('Failed to delete task');
                }
            })
            .catch(error => {
                console.error('Error deleting task:', error);
                toastr.error('Error deleting task');
            });
        }
    });
}

// Delete subtask function
function deleteSubtask(subtaskId, taskId) {
    const parts = subtaskId.split('-sub-');
    const subtaskDbId = parts[1];
    
    fetch(`{{ url('/projects') }}/${currentProjectId}/tasks/${subtaskDbId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const subtaskElement = document.getElementById(subtaskId);
            subtaskElement.style.transition = 'opacity 0.2s, transform 0.2s';
            subtaskElement.style.opacity = '0';
            subtaskElement.style.transform = 'translateX(-10px)';
            
            setTimeout(() => {
                subtaskElement.remove();
                updateTaskProgress(taskId);
            }, 200);
        } else {
            toastr.error('Failed to delete subtask');
        }
    })
    .catch(error => {
        console.error('Error deleting subtask:', error);
        toastr.error('Error deleting subtask');
    });
}

// Load tasks from database
function loadProjectTasks(projectId) {
    currentProjectId = projectId;
    
    fetch(`{{ url('/projects') }}/${projectId}/tasks`, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.tasks) {
            // Clear existing tasks
            document.getElementById('tasksContainer').innerHTML = '';
            taskCounter = 0;
            
            // Render each task
            data.tasks.forEach(task => {
                renderTaskFromDB(task);
            });
        }
    })
    .catch(error => console.error('Error loading tasks:', error));
}

// Render task from database
function renderTaskFromDB(task) {
    taskCounter++;
    const taskId = 'task-' + task.id;
    
    // Store task data for editing
    tasksDataStore[taskId] = task;
    
    const taskHTML = createTaskHTML(taskId, task.title);
    document.getElementById('tasksContainer').insertAdjacentHTML('beforeend', taskHTML);
    
    // Add employee and time info if available
    if (task.assigned_employee || task.due_date || task.description) {
        const taskElement = document.getElementById(taskId);
        const titleDiv = taskElement.querySelector('.task-title');
        let infoHTML = '';
        
        if (task.description) {
            infoHTML += `<div style="font-size: 13px; color: #6b7280; margin-top: 4px;">${task.description}</div>`;
        }
        
        if (task.assigned_employee || task.due_date) {
            infoHTML += '<div style="display: flex; gap: 12px; margin-top: 6px; font-size: 12px; color: #6b7280;">';
            
            if (task.assigned_employee) {
                infoHTML += `
                    <span style="display: inline-flex; align-items: center; gap: 4px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        ${task.assigned_employee.name}
                    </span>
                `;
            }
            
            if (task.due_date) {
                // Check if task is overdue
                let isOverdue = false;
                const now = new Date();
                let dueDate = new Date(task.due_date);
                
                if (!task.is_completed) {
                    // If time is specified, include it in comparison
                    if (task.due_time) {
                        const [hours, minutes] = task.due_time.split(':');
                        dueDate.setHours(parseInt(hours), parseInt(minutes), 0);
                    } else {
                        // If no time, set to end of day
                        dueDate.setHours(23, 59, 59);
                    }
                    
                    isOverdue = now > dueDate;
                }
                
                // Format date in user-friendly way
                const dateObj = new Date(task.due_date);
                const formattedDate = dateObj.toLocaleDateString('en-GB', { 
                    day: '2-digit', 
                    month: 'short', 
                    year: 'numeric' 
                });
                
                let dueText = formattedDate;
                if (task.due_time) {
                    // Convert 24-hour to 12-hour format
                    const [hours, minutes] = task.due_time.split(':');
                    const hour = parseInt(hours);
                    const ampm = hour >= 12 ? 'PM' : 'AM';
                    const hour12 = hour % 12 || 12;
                    dueText = `${formattedDate} at ${hour12}:${minutes} ${ampm}`;
                }
                
                // Add overdue indicator
                if (isOverdue) {
                    dueText = `⚠️ OVERDUE - ${dueText}`;
                }
                
                const overdueStyle = isOverdue ? 'color: #dc2626; font-weight: 700; background: #fee2e2; padding: 2px 6px; border-radius: 4px;' : '';
                const iconColor = isOverdue ? '#dc2626' : 'currentColor';
                
                infoHTML += `
                    <span style="display: inline-flex; align-items: center; gap: 4px; ${overdueStyle}">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="${iconColor}" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        ${dueText}
                    </span>
                `;
            }
            
            infoHTML += '</div>';
        }
        
        titleDiv.insertAdjacentHTML('afterend', infoHTML);
    }
    
    // Set task completion state
    if (task.is_completed) {
        const taskElement = document.getElementById(taskId);
        const checkbox = taskElement.querySelector('input[type="checkbox"]');
        const titleElement = taskElement.querySelector('.task-title');
        checkbox.checked = true;
        titleElement.style.textDecoration = 'line-through';
        titleElement.style.color = '#9ca3af';
        taskElement.style.background = '#f0fdf4';
    }
    
    // Render subtasks
    if (task.subtasks && task.subtasks.length > 0) {
        task.subtasks.forEach(subtask => {
            renderSubtaskFromDB(taskId, subtask);
        });
        
        // Show subtasks section
        const subtasksContainer = document.getElementById(taskId + '-subtasks');
        const arrow = document.getElementById(taskId + '-arrow');
        subtasksContainer.style.display = 'block';
        arrow.style.transform = 'rotate(90deg)';
    }
    
    // Update progress
    updateTaskProgress(taskId);
}

// Render subtask from database
function renderSubtaskFromDB(taskId, subtask) {
    const subtaskId = taskId + '-sub-' + subtask.id;
    const subtaskHTML = createSubtaskHTML(subtaskId, taskId, subtask.title, subtask.due_date, subtask.is_completed);
    document.getElementById(taskId + '-subtasks').insertAdjacentHTML('beforeend', subtaskHTML);
    
    // Set completion state
    if (subtask.is_completed) {
        const checkbox = document.getElementById(subtaskId).querySelector('input[type="checkbox"]');
        checkbox.checked = true;
        toggleSubtaskComplete(subtaskId, taskId);
    }
}

// Helper function to create task HTML
function createTaskHTML(taskId, title) {
    return `
        <div id="${taskId}" style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; margin-bottom: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <input type="checkbox" onchange="toggleTaskComplete('${taskId}')" style="width: 18px; height: 18px; cursor: pointer; flex-shrink: 0;">
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div class="task-title" style="font-size: 15px; font-weight: 600; color: #000;">${title}</div>
                        <div style="display: flex; gap: 8px;">
                            <button onclick="editTaskInKanban('${taskId}')" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #fef3c7; border: 1px solid #fde68a; border-radius: 6px; cursor: pointer; transition: all 0.2s;" title="Edit task">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </button>
                            <button onclick="deleteTask('${taskId}')" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #fee2e2; border: 1px solid #fecaca; border-radius: 6px; cursor: pointer; transition: all 0.2s;" title="Delete task">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-left: 30px; margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span id="${taskId}-progress-text" style="font-size: 13px; font-weight: 600; color: #000; min-width: 35px;">0%</span>
                    <div style="flex: 1; height: 8px; background: #e5e7eb; border-radius: 10px; overflow: hidden;">
                        <div id="${taskId}-progress-bar" style="height: 100%; width: 0%; background: linear-gradient(90deg, #10b981, #059669); transition: width 0.3s ease;"></div>
                    </div>
                </div>
            </div>
            <div style="margin-left: 30px;">
                <button onclick="toggleSubtasksSection('${taskId}')" style="display: flex; align-items: center; gap: 8px; padding: 6px 0; background: none; border: none; cursor: pointer; margin-bottom: 12px; color: #000; font-size: 13px; font-weight: 500;">
                    <svg id="${taskId}-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transition: transform 0.2s;">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span id="${taskId}-subtask-count">0 subtasks</span>
                </button>
                <div id="${taskId}-subtasks" style="display: none; margin-bottom: 12px;"></div>
                <div id="${taskId}-subtask-box" style="display: none; margin-bottom: 12px;">
                    <input type="text" id="${taskId}-subtask-input" placeholder="Enter subtask name..." style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background: white; color: #000; font-size: 13px; outline: none; margin-bottom: 10px;">
                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                        <button onclick="cancelAddSubtask('${taskId}')" style="padding: 8px 16px; background: white; border: 1px solid #e5e7eb; border-radius: 6px; cursor: pointer; font-size: 13px; color: #000; font-weight: 500;">Cancel</button>
                        <button onclick="saveSubtask('${taskId}')" style="padding: 8px 16px; background: #10b981; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; color: white; font-weight: 600;">Add</button>
                    </div>
                </div>
                <button onclick="toggleAddSubtask('${taskId}')" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 6px; cursor: pointer; font-size: 13px; color: #000; transition: all 0.2s; font-weight: 500;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add an item
                </button>
            </div>
        </div>
    `;
}

// Helper function to create subtask HTML
function createSubtaskHTML(subtaskId, taskId, title, dueDate, isCompleted) {
    const dateDisplay = dueDate ? new Date(dueDate).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }) : '';
    
    return `
        <div id="${subtaskId}" style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-left: 3px solid #e5e7eb; margin-bottom: 6px; transition: all 0.2s;">
            <button onclick="toggleSubtaskDate('${subtaskId}')" style="display: flex; align-items: center; justify-content: center; background: none; border: none; cursor: pointer; padding: 0; flex-shrink: 0;" title="Add due date">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 6v6l4 2"></path>
                </svg>
            </button>
            <input type="checkbox" onchange="toggleSubtaskComplete('${subtaskId}', '${taskId}')" style="width: 16px; height: 16px; cursor: pointer; flex-shrink: 0;">
            <span class="subtask-text" style="font-size: 13px; color: #000; flex: 1;">${title}</span>
            <span id="${subtaskId}-date" style="font-size: 12px; color: #6b7280; flex-shrink: 0; ${dateDisplay ? '' : 'display: none;'}">${dateDisplay}</span>
            <input type="date" id="${subtaskId}-date-input" style="position: absolute; opacity: 0; pointer-events: none;" onchange="saveSubtaskDate('${subtaskId}')">
            <button onclick="deleteSubtask('${subtaskId}', '${taskId}')" style="display: flex; align-items: center; justify-content: center; width: 26px; height: 26px; background: #fee2e2; border: 1px solid #fecaca; border-radius: 5px; cursor: pointer; flex-shrink: 0; transition: all 0.2s;" title="Delete subtask">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
            </button>
        </div>
    `;
}

// Group Chat Functions
function loadComments(projectId) {
    fetch(`{{ url('/projects') }}/${projectId}/comments`, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.comments) {
            const chatMessages = document.getElementById('chatMessages');
            
            // Clear placeholder if messages exist
            if (data.comments.length > 0) {
                chatMessages.innerHTML = '';
                
                data.comments.forEach(comment => {
                    addMessageToChat(comment);
                });
            }
            
            // Scroll to bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    })
    .catch(error => console.error('Error loading chat:', error));
}

function sendChatMessage() {
    console.log('sendChatMessage called');
    
    const input = document.getElementById('chatInput');
    if (!input) {
        console.error('Chat input not found');
        toastr.error('Chat input not found');
        return;
    }
    
    const message = input.value.trim();
    console.log('Message:', message);
    
    if (!message) {
        console.log('Empty message, returning');
        return;
    }
    
    if (!currentProjectId) {
        console.error('No project ID');
        toastr.warning('Please open a project first');
        return;
    }
    
    console.log('Sending to project:', currentProjectId);
    
    const url = `{{ url('/projects') }}/${currentProjectId}/comments`;
    console.log('URL:', url);
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found');
        toastr.error('CSRF token missing. Please refresh the page.');
        return;
    }
    
    console.log('Sending request...');
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            message: message
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Error response:', text);
                throw new Error(`HTTP ${response.status}: ${text}`);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.success && data.comment) {
            // Clear placeholder on first message
            const chatMessages = document.getElementById('chatMessages');
            const placeholder = chatMessages.querySelector('[style*="text-align: center"]');
            if (placeholder) {
                chatMessages.innerHTML = '';
            }
            
            addMessageToChat(data.comment);
            input.value = '';
            
            // Scroll to bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
            console.log('Message sent successfully');
        } else {
            console.error('Invalid response format:', data);
            toastr.error('Failed to send message');
        }
    })
    .catch(error => {
        console.error('Error sending message:', error);
        toastr.error('Error sending message: ' + error.message);
    });
}

function addMessageToChat(comment) {
    const chatMessages = document.getElementById('chatMessages');
    const colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#06b6d4', '#f97316'];
    
    // Use consistent color for same user
    const userName = comment.user ? comment.user.name : 'User';
    const userId = comment.user ? comment.user.id : 0;
    const color = colors[userId % colors.length];
    const userInitial = userName.charAt(0).toUpperCase();
    
    // Format time
    let timeDisplay = 'Just now';
    if (comment.created_at) {
        const date = new Date(comment.created_at);
        const now = new Date();
        const diffMs = now - date;
        const diffMins = Math.floor(diffMs / 60000);
        
        if (diffMins < 1) timeDisplay = 'Just now';
        else if (diffMins < 60) timeDisplay = `${diffMins}m ago`;
        else if (diffMins < 1440) timeDisplay = `${Math.floor(diffMins / 60)}h ago`;
        else timeDisplay = date.toLocaleDateString();
    }
    
    const messageHTML = `
        <div style="display: flex; gap: 12px; animation: slideIn 0.3s ease-out;">
            <div style="width: 36px; height: 36px; border-radius: 50%; background: ${color}; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px; flex-shrink: 0;">
                ${userInitial}
            </div>
            <div style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                    <span style="font-weight: 600; font-size: 13px; color: #000;">${userName}</span>
                    <span style="font-size: 11px; color: #9ca3af;">${timeDisplay}</span>
                </div>
                <div style="background: white; padding: 10px 14px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    <p style="margin: 0; font-size: 13px; color: #000; line-height: 1.5; white-space: pre-wrap;">${escapeHtml(comment.message)}</p>
                </div>
            </div>
        </div>
    `;
    
    chatMessages.insertAdjacentHTML('beforeend', messageHTML);
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function insertEmoji(emoji) {
    const input = document.getElementById('chatInput');
    const start = input.selectionStart;
    const end = input.selectionEnd;
    const text = input.value;
    
    input.value = text.substring(0, start) + emoji + text.substring(end);
    input.focus();
    input.selectionStart = input.selectionEnd = start + emoji.length;
}

function formatText(format) {
    const input = document.getElementById('chatInput');
    const start = input.selectionStart;
    const end = input.selectionEnd;
    const selectedText = input.value.substring(start, end);
    
    if (!selectedText) return;
    
    let formattedText = selectedText;
    switch(format) {
        case 'bold':
            formattedText = `**${selectedText}**`;
            break;
        case 'italic':
            formattedText = `*${selectedText}*`;
            break;
        case 'underline':
            formattedText = `__${selectedText}__`;
            break;
    }
    
    input.value = input.value.substring(0, start) + formattedText + input.value.substring(end);
    input.focus();
}

// Edit Project Function
function editProject(projectId) {
    // Load project data
    fetch(`{{ url('/projects') }}/${projectId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.project) {
            const project = data.project;
            
            // Convert dates from yyyy-mm-dd to dd/mm/yyyy
            let startDate = project.start_date || '';
            if (startDate) {
                const parts = startDate.split('-');
                if (parts.length === 3) {
                    startDate = parts[2] + '/' + parts[1] + '/' + parts[0];
                }
            }
            
            let dueDate = project.due_date || '';
            if (dueDate) {
                const parts = dueDate.split('-');
                if (parts.length === 3) {
                    dueDate = parts[2] + '/' + parts[1] + '/' + parts[0];
                }
            }
            
            // Fill form fields
            document.getElementById('editProjectId').value = project.id;
            document.getElementById('editProjectName').value = project.name || '';
            document.getElementById('editProjectDescription').value = project.description || '';
            document.getElementById('editProjectCompany').value = project.company_id || '';
            document.getElementById('editProjectStartDate').value = startDate;
            document.getElementById('editProjectDueDate').value = dueDate;
            document.getElementById('editProjectPriority').value = project.priority || 'medium';
            document.getElementById('editProjectStatus').value = project.status || 'active';
            document.getElementById('editProjectBudget').value = project.budget || '';
            
            // Show modal
            document.getElementById('editProjectModal').style.display = 'flex';
        }
    })
    .catch(error => {
        console.error('Error loading project:', error);
        toastr.error('Error loading project data');
    });
}

function closeEditProjectModal() {
    document.getElementById('editProjectModal').style.display = 'none';
    document.getElementById('editProjectForm').reset();
}

// Handle edit form submission
document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editProjectForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const projectId = document.getElementById('editProjectId').value;
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            
            // Convert dates from dd/mm/yyyy to yyyy-mm-dd
            if (data.start_date) {
                const parts = data.start_date.split('/');
                if (parts.length === 3) {
                    data.start_date = parts[2] + '-' + parts[1] + '-' + parts[0];
                }
            }
            if (data.due_date) {
                const parts = data.due_date.split('/');
                if (parts.length === 3) {
                    data.due_date = parts[2] + '-' + parts[1] + '-' + parts[0];
                }
            }
            
            fetch(`{{ url('/projects') }}/${projectId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success('Project updated successfully!');
                    closeEditProjectModal();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    toastr.error(data.message || 'Failed to update project');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('Error updating project');
            });
        });
    }
});

// Open Project Modal
function openProjectModal(stageId = null) {
    document.getElementById('projectForm').reset();
    if (stageId) {
        document.getElementById('projectStage').value = stageId;
    }
    document.getElementById('projectModal').style.display = 'flex';
}

// Close Project Modal
function closeProjectModal() {
    document.getElementById('projectModal').style.display = 'none';
    document.getElementById('projectForm').reset();
}

// Close View Project Modal
function closeViewProjectModal() {
    document.getElementById('viewProjectModal').style.display = 'none';
}

// Open Materials Modal in Kanban View
function openMaterialsModalInKanban() {
    console.log('🔵 openMaterialsModalInKanban called');
    console.log('Current Project ID:', currentProjectId);
    
    if (!currentProjectId) {
        console.error('❌ No project ID set');
        toastr.error('Please open a project first');
        return;
    }
    
    // Check if openMaterialsModal function exists (from project-materials.js)
    console.log('Checking if openMaterialsModal exists:', typeof openMaterialsModal);
    
    if (typeof openMaterialsModal === 'function') {
        console.log('✅ Calling openMaterialsModal with ID:', currentProjectId);
        openMaterialsModal(currentProjectId);
    } else {
        console.error('❌ openMaterialsModal function not found, redirecting...');
        // Fallback: redirect to overview page
        window.location.href = `{{ url('/projects') }}/${currentProjectId}/overview`;
    }
}

// Open Due Date Picker for View Project Modal
function openProjectDueDatePicker() {
    if (!currentProjectId) {
        toastr.error('No project selected');
        return;
    }
    
    // Get current due date from the button or fetch from server
    const dueDateText = document.getElementById('dueDateText').textContent;
    let currentDueDate = '';
    
    // Try to get from window.currentProjectDueDate if it exists
    if (window.currentProjectDueDate) {
        currentDueDate = window.currentProjectDueDate;
    }
    
    Swal.fire({
        title: 'Set Project Deadline',
        html: `
            <div style="text-align: left; margin-top: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">Due Date:</label>
                <input type="date" id="swalProjectDueDate" class="swal2-input" value="${currentDueDate}" 
                       style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; margin: 0;">
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Save',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        customClass: {
            popup: 'perfect-swal-popup'
        },
        didOpen: () => {
            document.getElementById('swalProjectDueDate').focus();
        },
        preConfirm: () => {
            const dueDate = document.getElementById('swalProjectDueDate').value;
            if (!dueDate) {
                Swal.showValidationMessage('Please select a due date');
                return false;
            }
            return { due_date: dueDate };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            updateCurrentProjectDueDate(result.value.due_date);
        }
    });
}

// Update Current Project Due Date
async function updateCurrentProjectDueDate(dueDate) {
    if (!currentProjectId) {
        toastr.error('No project selected');
        return;
    }
    
    try {
        const response = await fetch(`{{ url('/projects') }}/${currentProjectId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ due_date: dueDate })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Update the button text
            const formattedDate = new Date(dueDate).toLocaleDateString('en-GB', { 
                day: '2-digit', 
                month: 'short'
            });
            document.getElementById('dueDateText').textContent = formattedDate;
            
            // Update the global due date variable
            window.currentProjectDueDate = dueDate;
            
            // Update button styling to show it's set
            const dueDateButton = document.getElementById('dueDateButton');
            if (dueDateButton) {
                dueDateButton.style.background = '#dcfce7';
                dueDateButton.style.borderColor = '#bbf7d0';
                dueDateButton.style.color = '#166534';
            }
            
            // Show success message
            toastr.success('Project deadline updated successfully');
            
            // Update the kanban card if visible
            const card = document.querySelector(`.kanban-card[data-project-id="${currentProjectId}"]`);
            if (card) {
                // Reload the page to reflect changes in kanban view
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        } else {
            throw new Error(data.message || 'Failed to update due date');
        }
    } catch (error) {
        console.error('Error updating due date:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Failed to update project deadline',
            confirmButtonColor: '#ef4444'
        });
    }
}

// Delete Project Function
function deleteProject(projectId) {
    Swal.fire({
        title: 'Delete Project?',
        text: "This will delete all tasks, comments, and members associated with this project!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        customClass: { popup: 'perfect-swal-popup' }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`{{ url('/projects') }}/${projectId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success('Project deleted successfully!');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    toastr.error('Failed to delete project');
                }
            })
            .catch(error => {
                console.error('Error deleting project:', error);
                toastr.error('Error deleting project');
            });
        }
    });
}

// Close modals on outside click
window.onclick = function(event) {
    if (event.target.classList.contains('modal-overlay')) {
        event.target.style.display = 'none';
    }
}

// Member Management Functions
let selectedMembers = [];

function openAddMemberModal() {
    if (!currentProjectId) {
        toastr.warning('Please select a project first');
        return;
    }
    
    selectedMembers = [];
    updateSelectedCount();
    
    // Load available users
    fetch(`{{ url('/projects') }}/${currentProjectId}/available-users`, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            renderMemberCards(data.users);
            document.getElementById('addMemberModal').style.display = 'flex';
            
            // Setup search
            document.getElementById('memberSearch').oninput = function() {
                filterMemberCards(this.value, data.users);
            };
        }
    })
    .catch(error => {
        console.error('Error loading users:', error);
        toastr.error('Failed to load users');
    });
}

function renderMemberCards(users) {
    const grid = document.getElementById('memberGrid');
    grid.innerHTML = '';
    
    users.forEach(user => {
        const card = document.createElement('div');
        card.className = 'member-card';
        card.dataset.id = user.id;
        card.dataset.name = user.name.toLowerCase();
        card.style.cssText = 'position: relative; display: flex; flex-direction: column; align-items: center; padding: 16px; border: 2px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.2s ease; background: white;';
        
        // Get employee photo or use initials
        const photoPath = user.employee && user.employee.photo_path 
            ? `{{ asset('storage') }}/${user.employee.photo_path}`
            : null;
        const initials = user.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        const avatarColors = ['#4F46E5', '#059669', '#DC2626', '#F59E0B', '#8B5CF6', '#EC4899'];
        const avatarColor = avatarColors[user.id % avatarColors.length];
        
        card.innerHTML = `
            <div style="position: absolute; top: 8px; right: 8px;">
                <input type="checkbox" style="width: 20px; height: 20px; cursor: pointer; accent-color: #267bf5;">
            </div>
            <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; margin-bottom: 12px; border: 3px solid #e2e8f0; transition: border-color 0.2s ease; background: ${photoPath ? 'white' : avatarColor}; display: flex; align-items: center; justify-content: center;">
                ${photoPath 
                    ? `<img src="${photoPath}" alt="${user.name}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'; this.parentElement.innerHTML='<span style=\\'color: white; font-size: 28px; font-weight: 700;\\'>${initials}</span>';">`
                    : `<span style="color: white; font-size: 28px; font-weight: 700;">${initials}</span>`
                }
            </div>
            <div style="font-size: 13px; font-weight: 600; color: #1e293b; text-align: center;">${user.name}</div>
            <div style="font-size: 11px; color: #64748b; text-align: center; margin-top: 4px;">${user.position || user.email}</div>
        `;
        
        const checkbox = card.querySelector('input[type="checkbox"]');
        
        card.onclick = function(e) {
            if (e.target !== checkbox) {
                checkbox.checked = !checkbox.checked;
            }
            toggleMemberSelection(user.id, user, card, checkbox.checked);
        };
        
        checkbox.onchange = function() {
            toggleMemberSelection(user.id, user, card, this.checked);
        };
        
        grid.appendChild(card);
    });
}

function toggleMemberSelection(userId, user, card, isSelected) {
    if (isSelected) {
        if (!selectedMembers.find(m => m.id === userId)) {
            selectedMembers.push(user);
        }
        card.style.borderColor = '#267bf5';
        card.style.background = '#dbeafe';
        card.style.boxShadow = '0 0 0 3px rgba(38, 123, 245, 0.1)';
        card.querySelector('div[style*="border-radius: 50%"]').style.borderColor = '#267bf5';
    } else {
        selectedMembers = selectedMembers.filter(m => m.id !== userId);
        card.style.borderColor = '#e2e8f0';
        card.style.background = 'white';
        card.style.boxShadow = 'none';
        card.querySelector('div[style*="border-radius: 50%"]').style.borderColor = '#e2e8f0';
    }
    updateSelectedCount();
}

function updateSelectedCount() {
    document.getElementById('selectedMemberCount').textContent = selectedMembers.length;
}

function filterMemberCards(searchTerm, users) {
    const term = searchTerm.toLowerCase();
    const cards = document.querySelectorAll('.member-card');
    
    cards.forEach(card => {
        const name = card.dataset.name;
        if (name.includes(term)) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

function closeAddMemberModal() {
    document.getElementById('addMemberModal').style.display = 'none';
    document.getElementById('memberRole').value = 'member';
    document.getElementById('memberSearch').value = '';
    selectedMembers = [];
}

function addSelectedMembers() {
    if (selectedMembers.length === 0) {
        toastr.warning('Please select at least one employee');
        return;
    }
    
    const role = document.getElementById('memberRole').value;
    let addedCount = 0;
    let failedCount = 0;
    
    // Add members one by one
    const promises = selectedMembers.map(user => {
        return fetch(`{{ url('/projects') }}/${currentProjectId}/members`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ user_id: user.id, role: role })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                addMemberAvatar(data.member);
                addedCount++;
            } else {
                failedCount++;
            }
        })
        .catch(error => {
            console.error('Error adding member:', error);
            failedCount++;
        });
    });
    
    Promise.all(promises).then(() => {
        closeAddMemberModal();
        if (addedCount > 0 && failedCount === 0) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: `Successfully added ${addedCount} member${addedCount > 1 ? 's' : ''}!`,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                loadProjectMembers();
            });
        } else if (addedCount > 0 && failedCount > 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Partially Successful',
                html: `Added ${addedCount} member${addedCount > 1 ? 's' : ''}<br>Failed to add ${failedCount} member${failedCount > 1 ? 's' : ''}`,
                confirmButtonColor: '#3b82f6'
            }).then(() => {
                loadProjectMembers();
            });
        } else if (failedCount > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: `Failed to add ${failedCount} member${failedCount > 1 ? 's' : ''}`,
                confirmButtonColor: '#ef4444'
            });
        }
    });
}

function addMemberAvatar(member) {
    const membersContainer = document.getElementById('projectMembersAvatars');
    const memberColors = ['#4F46E5', '#059669', '#DC2626', '#F59E0B', '#8B5CF6', '#EC4899', '#14B8A6'];
    const currentMembers = membersContainer.querySelectorAll('div').length;
    const color = memberColors[currentMembers % memberColors.length];
    const initial = member.name.charAt(0).toUpperCase();
    
    // Remove the + button temporarily
    const addButton = membersContainer.querySelector('button');
    if (addButton) {
        addButton.remove();
    }
    
    // Add new member avatar
    const avatar = document.createElement('div');
    avatar.style.cssText = `width: 32px; height: 32px; border-radius: 50%; background: ${color}; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: 600; border: 2px solid white; margin-left: ${currentMembers > 0 ? '-10px' : '0'}; cursor: pointer; position: relative;`;
    avatar.title = member.name;
    avatar.dataset.userId = member.id;
    avatar.innerHTML = initial;
    
    // Add remove button on hover
    avatar.addEventListener('mouseenter', function() {
        const removeBtn = document.createElement('div');
        removeBtn.style.cssText = 'position: absolute; top: -5px; right: -5px; width: 18px; height: 18px; background: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 2px solid white;';
        removeBtn.innerHTML = '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
        removeBtn.onclick = (e) => {
            e.stopPropagation();
            removeMember(member.id, avatar);
        };
        avatar.appendChild(removeBtn);
    });
    
    avatar.addEventListener('mouseleave', function() {
        const removeBtn = avatar.querySelector('div');
        if (removeBtn) removeBtn.remove();
    });
    
    membersContainer.appendChild(avatar);
    
    // Re-add the + button
    if (addButton) {
        membersContainer.appendChild(addButton);
    }
}

function removeMember(userId, avatarElement) {
    Swal.fire({
        title: 'Remove Member?',
        text: "This member will be removed from the project",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, remove',
        cancelButtonText: 'Cancel',
        customClass: { popup: 'perfect-swal-popup' }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`{{ url('/projects') }}/${currentProjectId}/members/${userId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    avatarElement.remove();
                    toastr.success('Member removed successfully!');
                } else {
                    toastr.error('Failed to remove member');
                }
            })
            .catch(error => {
                console.error('Error removing member:', error);
                toastr.error('Failed to remove member');
            });
        }
    });
}

function loadProjectMembers(projectId) {
    fetch(`{{ url('/projects') }}/${projectId}/members`, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const membersContainer = document.getElementById('projectMembersAvatars');
            membersContainer.innerHTML = '';
            
            const memberColors = ['#4F46E5', '#059669', '#DC2626', '#F59E0B', '#8B5CF6', '#EC4899', '#14B8A6'];
            
            data.members.forEach((member, index) => {
                const color = memberColors[index % memberColors.length];
                const initial = member.name.charAt(0).toUpperCase();
                
                const avatar = document.createElement('div');
                avatar.style.cssText = `width: 32px; height: 32px; border-radius: 50%; background: ${color}; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: 600; border: 2px solid white; margin-left: ${index > 0 ? '-10px' : '0'}; cursor: pointer; position: relative;`;
                avatar.title = member.name;
                avatar.dataset.userId = member.id;
                avatar.innerHTML = initial;
                
                // Add remove button on hover
                avatar.addEventListener('mouseenter', function() {
                    const removeBtn = document.createElement('div');
                    removeBtn.style.cssText = 'position: absolute; top: -5px; right: -5px; width: 18px; height: 18px; background: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 2px solid white;';
                    removeBtn.innerHTML = '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
                    removeBtn.onclick = (e) => {
                        e.stopPropagation();
                        removeMember(member.id, avatar);
                    };
                    avatar.appendChild(removeBtn);
                });
                
                avatar.addEventListener('mouseleave', function() {
                    const removeBtn = avatar.querySelector('div');
                    if (removeBtn) removeBtn.remove();
                });
                
                membersContainer.appendChild(avatar);
            });
            
            // Add + button
            const addButton = document.createElement('button');
            addButton.onclick = openAddMemberModal;
            addButton.style.cssText = 'width: 32px; height: 32px; border-radius: 50%; background: #f3f4f6; display: flex; align-items: center; justify-content: center; border: 1px solid #d1d5db; cursor: pointer; margin-left: 6px; transition: all 0.2s;';
            addButton.title = 'Add Member';
            addButton.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>';
            membersContainer.appendChild(addButton);
        }
    })
    .catch(error => {
        console.error('Error loading members:', error);
    });
}
</script>
@endpush
@endsection




















