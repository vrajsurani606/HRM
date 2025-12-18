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

/* Date-time picker animation */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-5px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Subtask datetime badge styles */
.subtask-datetime-display {
  transition: all 0.2s ease;
}
.subtask-datetime-display:hover {
  transform: translateY(-1px);
}

/* Date/time input styling for picker */
#subtask-datetime-picker input[type="date"],
#subtask-datetime-picker input[type="time"] {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  color: #000000 !important;
  -webkit-text-fill-color: #000000 !important;
}
#subtask-datetime-picker input[type="date"]::-webkit-datetime-edit,
#subtask-datetime-picker input[type="time"]::-webkit-datetime-edit {
  color: #000000 !important;
}
#subtask-datetime-picker input[type="date"]::-webkit-datetime-edit-fields-wrapper,
#subtask-datetime-picker input[type="time"]::-webkit-datetime-edit-fields-wrapper {
  color: #000000 !important;
}
#subtask-datetime-picker input[type="date"]::-webkit-datetime-edit-text,
#subtask-datetime-picker input[type="time"]::-webkit-datetime-edit-text {
  color: #6b7280 !important;
}
#subtask-datetime-picker input[type="date"]::-webkit-datetime-edit-month-field,
#subtask-datetime-picker input[type="date"]::-webkit-datetime-edit-day-field,
#subtask-datetime-picker input[type="date"]::-webkit-datetime-edit-year-field,
#subtask-datetime-picker input[type="time"]::-webkit-datetime-edit-hour-field,
#subtask-datetime-picker input[type="time"]::-webkit-datetime-edit-minute-field,
#subtask-datetime-picker input[type="time"]::-webkit-datetime-edit-ampm-field {
  color: #000000 !important;
  font-weight: 600;
}
#subtask-datetime-picker input[type="date"]::-webkit-calendar-picker-indicator,
#subtask-datetime-picker input[type="time"]::-webkit-calendar-picker-indicator {
  cursor: pointer;
  opacity: 0.7;
  transition: opacity 0.2s;
  filter: invert(0.3);
}
#subtask-datetime-picker input[type="date"]::-webkit-calendar-picker-indicator:hover,
#subtask-datetime-picker input[type="time"]::-webkit-calendar-picker-indicator:hover {
  opacity: 1;
}

/* Chat animations */
@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes newMessagePop {
  0% {
    opacity: 0;
    transform: translateY(20px) scale(0.9);
  }
  50% {
    transform: translateY(-5px) scale(1.02);
  }
  100% {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

@keyframes typingBounce {
  0%, 80%, 100% {
    transform: scale(0.6);
    opacity: 0.5;
  }
  40% {
    transform: scale(1);
    opacity: 1;
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
  z-index: 2147483646 !important;
  position: fixed !important;
  top: 0 !important;
  left: 0 !important;
  right: 0 !important;
  bottom: 0 !important;
  align-items: center !important;
  justify-content: center !important;
  background: rgba(0, 0, 0, 0.5) !important;
  padding: 20px !important;
  overflow: hidden !important;
}

.modal-overlay[style*="display: flex"],
.modal-overlay.show {
  display: flex !important;
}

.modal-content {
  position: relative;
  z-index: 2147483647 !important;
  margin: auto !important;
  display: flex;
  flex-direction: column;
}

/* View Project Modal specific styles */
#viewProjectModal .modal-content {
  max-height: 90vh !important;
  overflow: visible !important;
}

/* Allow tooltip overflow for member avatars */
#projectMembersAvatars {
  overflow: visible !important;
  position: relative;
  z-index: 10;
}

/* Ensure avatar wrapper allows tooltip overflow */
#projectMembersAvatars .avatar-wrapper {
  position: relative;
  overflow: visible !important;
}

/* Member tooltip styling */
#member-tooltip {
  position: absolute;
  bottom: 100%;
  left: 50%;
  transform: translateX(-50%);
  margin-bottom: 8px;
  z-index: 999999;
  pointer-events: none;
}

/* Custom tooltip - styles applied via JavaScript for reliability */

/* jQuery UI Datepicker z-index fix for modals */
.ui-datepicker {
  z-index: 2147483650 !important;
}

/* Custom colored checkbox for task completion */
.task-checkbox {
  width: 18px;
  height: 18px;
  cursor: pointer;
  flex-shrink: 0;
  appearance: none;
  -webkit-appearance: none;
  border: 2px solid #d1d5db;
  border-radius: 4px;
  background: white;
  position: relative;
  transition: all 0.2s;
}
.task-checkbox:checked {
  border-color: var(--completed-color, #10b981);
  background: var(--completed-color, #10b981);
}
.task-checkbox:checked::after {
  content: '✓';
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
  font-size: 11px;
  font-weight: bold;
}
.subtask-checkbox {
  width: 16px;
  height: 16px;
  cursor: pointer;
  flex-shrink: 0;
  appearance: none;
  -webkit-appearance: none;
  border: 2px solid #d1d5db;
  border-radius: 3px;
  background: white;
  position: relative;
  transition: all 0.2s;
}
.subtask-checkbox:checked {
  border-color: var(--completed-color, #10b981);
  background: var(--completed-color, #10b981);
}
.subtask-checkbox:checked::after {
  content: '✓';
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
  font-size: 10px;
  font-weight: bold;
}

/* Completed-by avatar shown next to checkbox */
.completed-by-avatar {
  width: 22px;
  height: 22px;
  min-width: 22px;
  min-height: 22px;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 9px;
  font-weight: 700;
  color: white;
  flex-shrink: 0;
  position: relative;
  overflow: hidden;
  box-sizing: border-box;
  cursor: pointer;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.completed-by-avatar:hover {
  transform: scale(1.15);
  box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
.completed-by-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  border-radius: 50%;
}
.completed-by-avatar .avatar-fallback {
  width: 100%;
  height: 100%;
  display: none;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  color: white;
  text-transform: uppercase;
  border-radius: 50%;
}
.completed-by-avatar[data-tooltip] {
  position: relative;
}
.completed-by-avatar[data-tooltip]:hover::after {
  content: attr(data-tooltip);
  position: absolute;
  bottom: calc(100% + 10px);
  left: 50%;
  transform: translateX(-50%);
  background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
  color: white;
  padding: 8px 14px;
  border-radius: 8px;
  font-size: 11px;
  font-weight: 500;
  white-space: nowrap;
  z-index: 99999;
  box-shadow: 0 4px 16px rgba(0,0,0,0.3);
  pointer-events: none;
}
.completed-by-avatar[data-tooltip]:hover::before {
  content: '';
  position: absolute;
  bottom: calc(100% + 5px);
  left: 50%;
  transform: translateX(-50%);
  border: 6px solid transparent;
  border-top-color: #1f2937;
  z-index: 99999;
  pointer-events: none;
}
.subtask-completed-avatar {
  width: 20px;
  height: 20px;
  min-width: 20px;
  min-height: 20px;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 8px;
  font-weight: 700;
  color: white;
  flex-shrink: 0;
  position: relative;
  overflow: hidden;
  box-sizing: border-box;
  cursor: pointer;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.subtask-completed-avatar:hover {
  transform: scale(1.15);
  box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
.subtask-completed-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  border-radius: 50%;
}
.subtask-completed-avatar .avatar-fallback {
  width: 100%;
  height: 100%;
  display: none;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  color: white;
  text-transform: uppercase;
  border-radius: 50%;
}
.subtask-completed-avatar[data-tooltip] {
  position: relative;
}
.subtask-completed-avatar[data-tooltip]:hover::after {
  content: attr(data-tooltip);
  position: absolute;
  bottom: calc(100% + 10px);
  left: 50%;
  transform: translateX(-50%);
  background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
  color: white;
  padding: 8px 14px;
  border-radius: 8px;
  font-size: 11px;
  font-weight: 500;
  white-space: nowrap;
  z-index: 99999;
  box-shadow: 0 4px 16px rgba(0,0,0,0.3);
  pointer-events: none;
}
.subtask-completed-avatar[data-tooltip]:hover::before {
  content: '';
  position: absolute;
  bottom: calc(100% + 5px);
  left: 50%;
  transform: translateX(-50%);
  border: 6px solid transparent;
  border-top-color: #1f2937;
  z-index: 99999;
  pointer-events: none;
}
/* Checkbox wrapper for proper alignment */
.checkbox-avatar-wrapper {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  flex-shrink: 0;
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
  padding: 0 12px 12px;
}

.projects-list-view.active {
  display: block;
  overflow:auto;
}

/* Fix scroll when list/grid view is active - match Companies behavior */
.hrp-content.list-view-active,
.hrp-content.grid-view-active {
  height: auto !important;
  min-height: auto !important;
  overflow-y: auto !important;
  overflow-x: hidden !important;
}

/* Hide kanban board when list/grid view is active */
.hrp-content.list-view-active .kanban-board,
.hrp-content.grid-view-active .kanban-board {
  display: none !important;
}

/* Grid view styles */
.projects-grid-view {
  padding: 12px 12px 20px;
}

.projects-grid-view.active {
  min-height: auto;
  overflow: auto;
}

/* Action icons in list view */
.action-icons {
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.action-icon {
  width: 20px;
  height: 20px;
  cursor: pointer;
  transition: transform 0.2s;
}

.action-icon:hover {
  transform: scale(1.1);
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

/* Sortable Table Headers */
.sortable {
  cursor: pointer;
  user-select: none;
  position: relative;
  white-space: nowrap;
}

.sortable:hover {
  background: #f3f4f6;
}

.sort-icon {
  display: inline-flex;
  align-items: center;
  margin-left: 4px;
  opacity: 0.4;
  vertical-align: middle;
}

.sortable:hover .sort-icon {
  opacity: 0.7;
}

.sortable.asc .sort-icon,
.sortable.desc .sort-icon {
  opacity: 1;
  color: #3b82f6;
}

.sortable.asc .sort-icon svg path:last-child {
  opacity: 0.3;
}

.sortable.desc .sort-icon svg path:first-child {
  opacity: 0.3;
}
</style>
@endpush
@section('content')
<div class="hrp-content">
  <!-- Filters -->
  <div class="jv-filter" id="projectFilters">
    <select class="filter-pill" id="filterStage" onchange="applyProjectFilters()">
      <option value="">All Stages</option>
      @foreach($stages as $stage)
        <option value="{{ $stage->id }}">{{ $stage->name }}</option>
      @endforeach
    </select>

    <select class="filter-pill" id="filterStatus" onchange="applyProjectFilters()">
      <option value="">All Status</option>
      <option value="active">Active</option>
      <option value="on_hold">On Hold</option>
      <option value="completed">Completed</option>
      <option value="cancelled">Cancelled</option>
    </select>

    <select class="filter-pill" id="filterPriority" onchange="applyProjectFilters()">
      <option value="">All Priority</option>
      <option value="low">Low</option>
      <option value="medium">Medium</option>
      <option value="high">High</option>
    </select>

    <select class="filter-pill" id="filterCompany" onchange="applyProjectFilters()">
      <option value="">All Companies</option>
      @foreach($companies as $company)
        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
      @endforeach
    </select>

    <button type="button" class="filter-search" onclick="resetProjectFilters()" title="Reset Filters">
      <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
      </svg>
    </button>

    <div class="filter-right">
      <input type="text" id="projectSearch" class="filter-pill live-search" placeholder="Search projects..." onkeyup="applyProjectFilters()">

      <!-- View Toggle Buttons -->
      <div class="view-toggle-group">
        <button class="view-toggle-btn active" data-view="kanban" title="Kanban View">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="18" rx="1"></rect>
            <rect x="14" y="3" width="7" height="10" rx="1"></rect>
          </svg>
        </button>
        {{-- Grid View Hidden
        <button class="view-toggle-btn" data-view="grid" title="Grid View">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7" rx="1"></rect>
            <rect x="14" y="3" width="7" height="7" rx="1"></rect>
            <rect x="3" y="14" width="7" height="7" rx="1"></rect>
            <rect x="14" y="14" width="7" height="7" rx="1"></rect>
          </svg>
        </button>
        --}}
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
        <button type="button" class="pill-btn" onclick="window.location.href='{{ route('project-stages.index') }}'" title="Manage Project Stages" style="background: #6b7280; color: white;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="3"></circle>
            <path d="M12 1v6m0 6v6"></path>
          </svg>
          Stages
        </button>
      @endcan
      @can('Projects Management.create project')
        <button type="button" class="pill-btn pill-success" onclick="openProjectModal()">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
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
          <button class="add-card-btn" onclick="toggleInlineAddCard({{ $stage->id }})">
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
              @if($project->total_tasks > 0)
              <span class="task-count">{{ $project->completed_tasks }}/{{ $project->total_tasks }}</span>
              @endif
            </div>
            <div class="card-avatars">
              @php
                $displayLimit = 3;
                $fallbackColors = ['#6366f1', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6', '#ef4444', '#06b6d4', '#84cc16'];
              @endphp
              @if($project->members->count() > 0)
                @foreach($project->members->take($displayLimit) as $index => $member)
                  @php
                    $initials = get_user_initials($member->name);
                    // Use member's chat_color, fallback to random color
                    $userColor = $member->chat_color ?? $fallbackColors[$member->id % count($fallbackColors)];
                    
                    // Get employee for this user to check for photo
                    $employee = \App\Models\Employee::where('user_id', $member->id)->first();
                    $hasPhoto = $employee && !empty($employee->photo_path);
                  @endphp
                  <div class="avatar" data-tooltip="{{ $member->name }}" style="background: {{ $hasPhoto ? '#f3f4f6' : $userColor }}; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.12); border: 2px solid {{ $userColor }};">
                    @if($hasPhoto)
                      <img src="{{ storage_asset($employee->photo_path) }}" alt="{{ $member->name }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="var p=this.parentElement; this.style.display='none'; p.style.background='{{ $userColor }}'; p.innerHTML='{{ $initials }}';">
                    @else
                      {{ $initials }}
                    @endif
                  </div>
                @endforeach
                @if($project->members->count() > $displayLimit)
                  <div class="avatar" data-tooltip="{{ $project->members->count() - $displayLimit }} more members" style="background: #6B7280;">+{{ $project->members->count() - $displayLimit }}</div>
                @endif
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <!-- Inline Add Card Form (Trello Style) - Outside kanban-cards for proper positioning -->
      @can('Projects Management.create project')
      <div class="inline-add-card-form" id="inlineAddCard-{{ $stage->id }}" style="display: none; margin: 0 20px 12px;">
        <div class="inline-card-input-wrapper">
          <textarea 
            class="inline-card-title-input" 
            id="inlineCardTitle-{{ $stage->id }}" 
            placeholder="Enter a title for this project..."
            rows="2"
            onkeydown="handleInlineCardKeydown(event, {{ $stage->id }})"
          ></textarea>
        </div>
        <div class="inline-card-actions">
          <button type="button" class="inline-add-btn" onclick="submitInlineCard({{ $stage->id }})">
            Add project
          </button>
          <button type="button" class="inline-close-btn" onclick="closeInlineAddCard({{ $stage->id }})">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </button>
        </div>
      </div>

      <!-- Add Card Button (Trello Style) - Outside kanban-cards for proper positioning -->
      <button class="inline-add-card-trigger" id="addCardTrigger-{{ $stage->id }}" onclick="toggleInlineAddCard({{ $stage->id }})" style="margin: 0 20px 12px; width: calc(100% - 40px);">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="12" y1="5" x2="12" y2="19"></line>
          <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        Add a project
      </button>
      @endcan
    </div>
    @endforeach
  </div>

  {{-- Grid View Hidden
  <div class="projects-grid-view">
    @forelse($projects as $project)
      <div class="project-grid-card" onclick="viewProject({{ $project->id }}, event)">
        <div class="project-grid-header">
          <h3 class="project-grid-title">{{ $project->name }}</h3>
          <span class="project-grid-stage" style="background: {{ $project->stage->color ?? '#f3f4f6' }}; color: #000;">
            {{ $project->stage->name ?? 'No Stage' }}
          </span>
        </div>
        
        @if($project->description)
        <p class="project-grid-description">{{ $project->description }}</p>
        @endif
        
        <div class="project-grid-meta">
          @if($project->total_tasks > 0)
          <div class="project-grid-progress">
            <div class="project-grid-progress-text">
              {{ $project->completed_tasks }}/{{ $project->total_tasks }} Tasks
            </div>
            <div class="project-grid-progress-bar">
              <div class="project-grid-progress-fill" style="width: {{ $project->progress }}%"></div>
            </div>
          </div>
          @endif
          
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
    @empty
      <div class="text-center py-3" style="grid-column: 1/-1;">No projects found</div>
    @endforelse
  </div>
  --}}

  <!-- List View -->
  <div class="projects-list-view">
    <div class="JV-datatble striped-surface striped-surface--full table-wrap pad-none">
      <table id="projectListTable">
        <thead>
          <tr>
            <th style="width: 120px;">Actions</th>
            <th class="sortable" data-sort="srno" data-type="number" style="cursor: pointer;">
              Sr.No.
              <span class="sort-icon">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M7 10l5-5 5 5M7 14l5 5 5-5"/>
                </svg>
              </span>
            </th>
            <th class="sortable" data-sort="name" data-type="string" style="cursor: pointer;">
              Project Name
              <span class="sort-icon">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M7 10l5-5 5 5M7 14l5 5 5-5"/>
                </svg>
              </span>
            </th>
            <th class="sortable" data-sort="company" data-type="string" style="cursor: pointer;">
              Company
              <span class="sort-icon">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M7 10l5-5 5 5M7 14l5 5 5-5"/>
                </svg>
              </span>
            </th>
            <th class="sortable" data-sort="stage" data-type="string" style="cursor: pointer;">
              Stage
              <span class="sort-icon">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M7 10l5-5 5 5M7 14l5 5 5-5"/>
                </svg>
              </span>
            </th>
            <th class="sortable" data-sort="progress" data-type="number" style="cursor: pointer;">
              Progress
              <span class="sort-icon">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M7 10l5-5 5 5M7 14l5 5 5-5"/>
                </svg>
              </span>
            </th>
            <th class="sortable" data-sort="duedate" data-type="date" style="cursor: pointer;">
              Due Date
              <span class="sort-icon">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M7 10l5-5 5 5M7 14l5 5 5-5"/>
                </svg>
              </span>
            </th>
            <th class="sortable" data-sort="priority" data-type="priority" style="cursor: pointer;">
              Priority
              <span class="sort-icon">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M7 10l5-5 5 5M7 14l5 5 5-5"/>
                </svg>
              </span>
            </th>
          </tr>
        </thead>
        <tbody>
          @forelse($projects as $index => $project)
            <tr data-project-id="{{ $project->id }}" 
                data-srno="{{ $index + 1 }}"
                data-name="{{ strtolower($project->name) }}"
                data-company="{{ strtolower($project->company->company_name ?? '') }}"
                data-stage="{{ strtolower($project->stage->name ?? '') }}"
                data-progress="{{ $project->progress }}"
                data-duedate="{{ $project->due_date ? $project->due_date->format('Y-m-d') : '9999-12-31' }}"
                data-priority="{{ $project->priority ?? 'medium' }}">
              <td>
                <div class="action-icons">
                  @can('Projects Management.view project')
                    <img src="{{ asset('action_icon/view.svg') }}" alt="View" class="action-icon" onclick="viewProject({{ $project->id }}, event)" title="View Project" style="cursor:pointer;">
                  @endcan
                  @can('Projects Management.edit project')
                    <img src="{{ asset('action_icon/edit.svg') }}" alt="Edit" class="action-icon" onclick="editProject({{ $project->id }})" title="Edit Project" style="cursor:pointer;">
                  @endcan
                  {{-- Overview Button Hidden
                  @can('Projects Management.view project')
                    <a href="{{ url('/projects') }}/{{ $project->id }}/overview" title="Project Overview">
                      <img src="{{ asset('action_icon/view_temp_list.svg') }}" alt="Overview" class="action-icon">
                    </a>
                  @endcan
                  --}}
                  @can('Projects Management.delete project')
                    <img src="{{ asset('action_icon/delete.svg') }}" alt="Delete" class="action-icon" onclick="deleteProject({{ $project->id }})" title="Delete Project" style="cursor:pointer;">
                  @endcan
                </div>
              </td>
              <td class="srno-cell">{{ $index + 1 }}</td>
              <td>
                <span class="project-list-name" onclick="viewProject({{ $project->id }}, event)">
                  {{ $project->name }}
                </span>
              </td>
              <td>{{ $project->company->company_name ?? 'N/A' }}</td>
              <td>
                <span class="project-list-stage-badge" style="background: {{ $project->stage->color ?? '#f3f4f6' }}; color: #000;">
                  {{ $project->stage->name ?? 'No Stage' }}
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
              <td>{{ $project->due_date ? $project->due_date->format('d M, Y') : 'N/A' }}</td>
              <td>
                <span style="color: {{ $project->priority === 'high' ? '#ef4444' : ($project->priority === 'medium' ? '#f59e0b' : '#10b981') }}; font-weight: 500; text-transform: capitalize;">
                  {{ $project->priority ?? 'medium' }}
                </span>
              </td>
            </tr>
          @empty
            <x-empty-state 
                colspan="8" 
                title="No projects found" 
                message="Create a new project to get started"
            />
          @endforelse
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

        <div class="form-actions">
          <button type="button" onclick="closeEditProjectModal()" class="btn-cancel">Cancel</button>
          <button type="submit" class="btn-create">Update Project</button>
        </div>
      </form>
    </div>
  </div>

  <!-- View Project Modal -->
  <div id="viewProjectModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 1400px; width: 95%; max-height: 90vh; overflow: hidden; border-radius: 16px; padding: 0; background: white; margin: 40px auto;">
      <!-- Stage Badge -->
      <div style="padding: 14px 20px; border-bottom: 1px solid #f0f0f0; flex-shrink: 0;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
          <div style="display: flex; align-items: center; gap: 6px;">
            <span style="color: #d4a574; font-size: 14px;">📋</span>
            <span id="viewProjectStage" style="color: #000; font-size: 13px;"></span>
          </div>
          <button onclick="closeViewProjectModal()" style="background: none; border: none; cursor: pointer; color: #9ca3af; font-size: 20px; line-height: 1; padding: 0; width: 20px; height: 20px;">&times;</button>
        </div>
      </div>

      <!-- Project Content - Two Column Layout -->
      <div style="display: grid; grid-template-columns: 1fr 380px; gap: 0; height: calc(90vh - 80px); overflow: hidden;">
        
        <!-- LEFT COLUMN - Tasks -->
        <div style="padding: 20px 24px 24px; overflow-y: auto; overflow-x: hidden; border-right: 1px solid #e5e7eb; max-height: 100%;">
        <!-- Title -->
        <div style="margin-bottom: 16px;">
          <h2 id="viewProjectTitle" style="font-size: 24px; font-weight: 600; margin: 0; color: #000;"></h2>
        </div>
        
        <!-- Action Buttons -->
        <div style="display: flex; gap: 8px; margin-bottom: 16px; flex-wrap: wrap; align-items: stretch; overflow: visible;">
          
          
          @if(!auth()->user()->hasRole('employee'))
          <button id="dueDateButton" onclick="openProjectDueDatePicker()" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: white; border: 1px solid #e5e7eb; border-radius: 6px; cursor: pointer; font-size: 13px; color: #000; transition: all 0.2s; height: 38px; box-sizing: border-box;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='white'">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"></circle>
              <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <span id="dueDateText">Due Date</span>
          </button>
          @else
          <div id="dueDateButton" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 13px; color: #6b7280; height: 38px; box-sizing: border-box;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"></circle>
              <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <span id="dueDateText">Due Date</span>
          </div>
          @endif

          @can('Projects Management.create task')
          <button onclick="toggleAddTaskBox()" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: white; border: 1px solid #e5e7eb; border-radius: 6px; cursor: pointer; font-size: 13px; color: #000; transition: all 0.2s; height: 38px; box-sizing: border-box;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <line x1="12" y1="5" x2="12" y2="19"></line>
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Manual
          </button>
          
          <button onclick="openMaterialsModalInKanban()" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: white; border: 1px solid #e5e7eb; border-radius: 6px; cursor: pointer; font-size: 13px; color: #000; transition: all 0.2s; height: 38px; box-sizing: border-box;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 11l3 3L22 4"></path>
              <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
            </svg>
            Auto
          </button>
          @endcan
          
          <!-- Members Section -->
          <div style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 14px; background: white; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 13px; color: #000; height: 38px; box-sizing: border-box; overflow: visible; position: relative;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span style="font-weight: 500;">Members</span>
            <div id="projectMembersAvatars" style="display: flex; align-items: center; gap: 4px; overflow: visible;">
              <!-- Member avatars will be added here -->
            </div>
          </div>
          
         
        </div>

        <!-- Company Selector -->
        <div style="margin-bottom: 20px;">
          <select id="viewProjectCompany" style="width: 50%; padding: 9px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background: {{ auth()->user()->hasRole('employee') ? '#f3f4f6' : '#fafafa' }}; color: {{ auth()->user()->hasRole('employee') ? '#6b7280' : '#000' }}; font-size: 13px; cursor: {{ auth()->user()->hasRole('employee') ? 'not-allowed' : 'pointer' }}; outline: none;" {{ auth()->user()->hasRole('employee') ? 'disabled' : '' }}>
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
          <textarea id="viewProjectDescription" placeholder="{{ auth()->user()->hasRole('employee') ? 'Project description' : 'Enter About Whole Project Description' }}" style="width: 100%; background: {{ auth()->user()->hasRole('employee') ? '#f3f4f6' : '#fafafa' }}; border: 1px solid #e5e7eb; border-radius: 6px; padding: 14px; min-height: 100px; color: {{ auth()->user()->hasRole('employee') ? '#6b7280' : '#000' }}; font-size: 13px; line-height: 1.5; font-family: inherit; resize: {{ auth()->user()->hasRole('employee') ? 'none' : 'vertical' }}; outline: none; cursor: {{ auth()->user()->hasRole('employee') ? 'not-allowed' : 'text' }};" {{ auth()->user()->hasRole('employee') ? 'readonly' : '' }}></textarea>
        </div>

        <!-- Tasks Section -->
        <div>
          @can('Projects Management.create task')
          <!-- Add Task Form (Hidden by default) -->
          <div id="addTaskBox" style="display: none; margin-bottom: 16px; background: #fafafa; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px;">
            <div style="margin-bottom: 12px;">
              <label style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #000;">Task Name</label>
              <input type="text" id="newTaskTitle" placeholder="Enter task name..." style="width: 100%; padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 6px; background: white; color: #000; font-size: 13px; outline: none;">
            </div>
            <!-- Tasks are visible to all project members - no assignment needed -->
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
          @endcan

          <!-- Tasks Container -->
          <div id="tasksContainer">
            <!-- Tasks will be added here dynamically -->
          </div>
        </div>
        </div>
        <!-- End LEFT COLUMN -->
        
        <!-- RIGHT COLUMN - Group Chat -->
        <div style="display: flex; flex-direction: column; background: #f8fafc; height: 100%; overflow: hidden;">
          <!-- Chat Header -->
          <div style="padding: 16px 20px; border-bottom: 1px solid #e5e7eb; background: white; flex-shrink: 0;">
            <div style="display: flex; align-items: center; gap: 10px;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
              </svg>
              <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1f2937;">Group Chat</h3>
            </div>
          </div>
          
          <!-- Chat Messages Container -->
          <div id="chatMessages" style="flex: 1; padding: 16px; overflow-y: auto; display: flex; flex-direction: column; gap: 12px; min-height: 0;">
            <!-- Empty State -->
            <div id="chatEmptyState" style="text-align: center; padding: 40px 20px;">
              <div style="width: 70px; height: 70px; margin: 0 auto 16px; background: linear-gradient(135deg, #f5f3ff, #ede9fe); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2">
                  <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
              </div>
              <h4 style="margin: 0 0 6px 0; font-size: 15px; font-weight: 600; color: #1f2937;">No Messages Yet</h4>
              <p style="margin: 0; font-size: 13px; color: #6b7280;">Start the conversation with your team!</p>
            </div>
          </div>
          
          <!-- Chat Input Area -->
          <div style="padding: 12px 16px; background: white; border-top: 1px solid #e5e7eb; flex-shrink: 0;">
            <div style="display: flex; align-items: flex-end; gap: 10px;">
              <textarea id="chatInput" placeholder="Type here to discuss with the team..." rows="1" style="flex: 1; padding: 12px 16px; border: 1px solid #e5e7eb; border-radius: 24px; background: #f9fafb; color: #1f2937; font-size: 14px; outline: none; resize: none; min-height: 44px; max-height: 100px; font-family: inherit; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e5e7eb'" oninput="handleChatTyping()" onkeypress="if(event.key === 'Enter' && !event.shiftKey) { event.preventDefault(); sendChatMessage(); }"></textarea>
              <button onclick="sendChatMessage()" style="width: 44px; height: 44px; border-radius: 50%; background: #3b82f6; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s; flex-shrink: 0;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                  <line x1="22" y1="2" x2="11" y2="13"></line>
                  <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
              </button>
            </div>
            <div style="display: flex; gap: 6px; padding-top: 10px;">
              <button onclick="formatText('bold')" title="Bold" style="padding: 5px 10px; background: transparent; border: none; cursor: pointer; font-weight: bold; font-size: 14px; color: #6b7280; border-radius: 4px;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">B</button>
              <button onclick="formatText('italic')" title="Italic" style="padding: 5px 10px; background: transparent; border: none; cursor: pointer; font-style: italic; font-size: 14px; color: #6b7280; border-radius: 4px;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">I</button>
              <button onclick="formatText('strikethrough')" title="Strikethrough" style="padding: 5px 10px; background: transparent; border: none; cursor: pointer; text-decoration: line-through; font-size: 14px; color: #6b7280; border-radius: 4px;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">S</button>
              <span style="width: 1px; background: #e5e7eb; margin: 0 4px;"></span>
              <button onclick="insertEmoji('👍')" title="Thumbs up" style="padding: 5px 8px; background: transparent; border: none; cursor: pointer; font-size: 14px; border-radius: 4px;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">👍</button>
              <button onclick="insertEmoji('❤️')" title="Heart" style="padding: 5px 8px; background: transparent; border: none; cursor: pointer; font-size: 14px; border-radius: 4px;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">❤️</button>
              <button onclick="insertEmoji('🎉')" title="Party" style="padding: 5px 8px; background: transparent; border: none; cursor: pointer; font-size: 14px; border-radius: 4px;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">🎉</button>
            </div>
          </div>
        </div>
        <!-- End RIGHT COLUMN -->
        
      </div>
    </div>
  </div>

  <!-- Add Member Modal -->
  <div id="addMemberModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 2147483648; align-items: center; justify-content: center;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px); z-index: 2147483648;" onclick="closeAddMemberModal()"></div>
    <div style="position: relative; background: white; border-radius: 16px; width: 90%; max-width: 800px; max-height: 85vh; display: flex; flex-direction: column; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); animation: modalSlideIn 0.3s ease-out; z-index: 2147483649;">
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
    initializeAvatarTooltips();
});

// Custom tooltip for avatars - positioned directly above the avatar
function initializeAvatarTooltips() {
    // Create tooltip element if not exists
    let tooltip = document.getElementById('avatar-tooltip');
    if (!tooltip) {
        tooltip = document.createElement('div');
        tooltip.id = 'avatar-tooltip';
        tooltip.className = 'avatar-tooltip';
        tooltip.style.cssText = 'position:fixed;display:none;padding:6px 12px;background:#1f2937;color:#fff;font-size:12px;font-weight:500;white-space:nowrap;border-radius:6px;z-index:2147483647;box-shadow:0 4px 12px rgba(0,0,0,0.3);pointer-events:none;';
        document.body.appendChild(tooltip);
        
        // Add arrow
        const arrow = document.createElement('div');
        arrow.style.cssText = 'position:absolute;top:100%;left:50%;transform:translateX(-50%);border:6px solid transparent;border-top-color:#1f2937;';
        tooltip.appendChild(arrow);
    }
    
    let currentAvatar = null;
    
    // Function to position tooltip
    function positionTooltip() {
        if (!currentAvatar) return;
        
        const rect = currentAvatar.getBoundingClientRect();
        const tooltipWidth = tooltip.offsetWidth;
        const tooltipHeight = tooltip.offsetHeight;
        
        // Position directly above the avatar
        let left = rect.left + (rect.width / 2) - (tooltipWidth / 2);
        let top = rect.top - tooltipHeight - 8;
        
        // Keep within viewport
        if (left < 5) left = 5;
        if (left + tooltipWidth > window.innerWidth - 5) left = window.innerWidth - tooltipWidth - 5;
        if (top < 5) top = rect.bottom + 8; // Show below if no space above
        
        tooltip.style.left = left + 'px';
        tooltip.style.top = top + 'px';
    }
    
    // Show tooltip
    function showTooltip(avatar) {
        const text = avatar.getAttribute('data-tooltip');
        if (!text) return;
        
        currentAvatar = avatar;
        tooltip.childNodes[0].textContent = text;
        tooltip.style.display = 'block';
        
        // Position after display
        setTimeout(positionTooltip, 0);
    }
    
    // Hide tooltip
    function hideTooltip() {
        tooltip.style.display = 'none';
        currentAvatar = null;
    }
    
    // Event listeners using capture phase
    document.addEventListener('mouseenter', function(e) {
        const avatar = e.target;
        if (avatar.hasAttribute && avatar.hasAttribute('data-tooltip')) {
            if (avatar.closest('#projectMembersAvatars') || avatar.closest('.card-avatars')) {
                showTooltip(avatar);
            }
        }
    }, true);
    
    document.addEventListener('mouseleave', function(e) {
        const avatar = e.target;
        if (avatar.hasAttribute && avatar.hasAttribute('data-tooltip')) {
            if (avatar.closest('#projectMembersAvatars') || avatar.closest('.card-avatars')) {
                hideTooltip();
            }
        }
    }, true);
}

function initializeViewSwitching() {
    const viewButtons = document.querySelectorAll('.view-toggle-btn');
    const kanbanView = document.querySelector('.kanban-board');
    const gridView = document.querySelector('.projects-grid-view');
    const listView = document.querySelector('.projects-list-view');
    
    // Load saved view preference - default to kanban if grid is hidden
    let savedView = localStorage.getItem('projectView') || 'kanban';
    // If grid view is hidden and saved view is grid, switch to kanban
    if (!gridView && savedView === 'grid') {
        savedView = 'kanban';
        localStorage.setItem('projectView', 'kanban');
    }
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
        
        // Show/hide views - add null checks
        if (kanbanView) kanbanView.classList.toggle('hidden', view !== 'kanban');
        if (gridView) gridView.classList.toggle('active', view === 'grid');
        if (listView) listView.classList.toggle('active', view === 'list');
        
        // Fix overflow for list/grid views (enable vertical scroll)
        const hrpContent = document.querySelector('.hrp-content');
        if (hrpContent) {
            hrpContent.classList.remove('list-view-active', 'grid-view-active');
            if (view === 'list') {
                hrpContent.classList.add('list-view-active');
            } else if (view === 'grid') {
                hrpContent.classList.add('grid-view-active');
            }
        }
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

    // Clean up any stale drop indicators on initialization
    document.querySelectorAll('.drop-indicator').forEach(indicator => indicator.remove());

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
            
            // Clear all column highlights and remove all drop indicators
            columns.forEach(col => {
                col.style.backgroundColor = '';
                const indicator = col.querySelector('.drop-indicator');
                if (indicator) indicator.remove();
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
        // Dragover - must prevent default to allow drop and show drop indicator
        column.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (draggedElement) {
                e.dataTransfer.dropEffect = 'move';
                this.style.backgroundColor = 'rgba(255,255,255,0.2)';
                
                // Find the card we're hovering over to show drop position
                const cards = [...this.querySelectorAll('.kanban-card:not(.dragging)')];
                const afterElement = getDragAfterElement(this, e.clientY);
                
                // Remove existing drop indicator
                const existingIndicator = this.querySelector('.drop-indicator');
                if (existingIndicator) existingIndicator.remove();
                
                // Add drop indicator
                const indicator = document.createElement('div');
                indicator.className = 'drop-indicator';
                indicator.style.cssText = 'height: 3px; background: #3b82f6; border-radius: 2px; margin: 8px 0;';
                
                if (afterElement) {
                    this.insertBefore(indicator, afterElement);
                } else {
                    this.appendChild(indicator);
                }
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
                // Remove drop indicator
                const indicator = this.querySelector('.drop-indicator');
                if (indicator) indicator.remove();
            }
        });

        // Drop event
        column.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            this.style.backgroundColor = '';
            
            // Remove drop indicator
            const indicator = this.querySelector('.drop-indicator');
            if (indicator) indicator.remove();
            
            if (draggedElement) {
                const projectId = draggedElement.dataset.projectId;
                const newStageId = this.dataset.stageId;
                const oldColumn = draggedElement.closest('.kanban-cards');
                const oldStageId = oldColumn ? oldColumn.dataset.stageId : null;
                
                console.log('DROP EVENT - Project:', projectId, 'Old Stage:', oldStageId, 'New Stage:', newStageId);
                
                // Find the correct position to insert
                const afterElement = getDragAfterElement(this, e.clientY);
                
                // Move the card to the correct position
                if (afterElement) {
                    this.insertBefore(draggedElement, afterElement);
                } else {
                    this.appendChild(draggedElement);
                }
                draggedElement.style.opacity = '1';
                
                // Update backend if stage changed
                if (oldStageId !== newStageId) {
                    updateProjectStage(projectId, newStageId);
                    console.log('Card moved to new stage!');
                }
                
                // Always save positions after drop (for reordering within same column or after stage change)
                saveColumnPositions(this);
            }
        });
    });
    
    // Helper function to find the element after which to insert
    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.kanban-card:not(.dragging)')];
        
        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }

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
                
                // Find the correct position to insert
                const afterElement = getDragAfterElement(cardsContainer, e.clientY);
                
                if (afterElement) {
                    cardsContainer.insertBefore(draggedElement, afterElement);
                } else {
                    cardsContainer.appendChild(draggedElement);
                }
                draggedElement.style.opacity = '1';
                
                if (oldStageId !== newStageId) {
                    updateProjectStage(projectId, newStageId);
                }
                
                // Save positions after drop
                saveColumnPositions(cardsContainer);
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

// Save project positions within a column
function saveColumnPositions(column) {
    const cards = column.querySelectorAll('.kanban-card');
    const positions = [];
    
    cards.forEach((card, index) => {
        const projectId = card.dataset.projectId;
        if (projectId) {
            positions.push({
                id: parseInt(projectId),
                position: index
            });
        }
    });
    
    if (positions.length === 0) return;
    
    console.log('💾 Saving positions:', positions);
    
    fetch('{{ route("projects.update-positions") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ positions: positions })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('✅ Positions saved successfully');
        } else {
            console.error('❌ Failed to save positions:', data);
        }
    })
    .catch(error => {
        console.error('❌ Error saving positions:', error);
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

// Project Modal Functions - Removed duplicate, using the one at the end of file

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
        
        // Save description on blur (only for non-employees)
        if (!isEmployee) {
            descTextarea.onblur = function() {
                saveProjectDescription(project.id, this.value);
            };
        }
        
        // Save company on change (only for non-employees)
        if (!isEmployee) {
            companySelect.onchange = function() {
                saveProjectCompany(project.id, this.value);
            };
        }
        
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

// Current user info for task completion tracking
@php
    $currentAuthUser = auth()->user();
    $currentUserPhotoPath = '';
    
    // Try to get photo from employee relationship
    if ($currentAuthUser->employee && $currentAuthUser->employee->photo_path) {
        $currentUserPhotoPath = storage_asset($currentAuthUser->employee->photo_path);
    }
    // Fallback: Try to find employee by matching user_id
    elseif (!$currentAuthUser->employee) {
        $employeeByUserId = \App\Models\Employee::where('user_id', $currentAuthUser->id)->first();
        if ($employeeByUserId && $employeeByUserId->photo_path) {
            $currentUserPhotoPath = storage_asset($employeeByUserId->photo_path);
        }
    }
@endphp
const currentUser = {
    id: {{ auth()->id() }},
    name: "{{ $currentAuthUser->name }}",
    chat_color: "{{ $currentAuthUser->chat_color ?? '#10b981' }}",
    photo_path: "{{ $currentUserPhotoPath }}"
};

// Permission flags for task management
const canCreateTask = {{ auth()->user()->can('Projects Management.create task') ? 'true' : 'false' }};
const canEditTask = {{ auth()->user()->can('Projects Management.edit task') ? 'true' : 'false' }};
const canDeleteTask = {{ auth()->user()->can('Projects Management.delete task') ? 'true' : 'false' }};
const canManageMembers = {{ auth()->user()->can('Projects Management.edit project') ? 'true' : 'false' }};
// Only employees cannot uncheck completed tasks - all other roles can uncheck
const canUncheckTask = {{ !auth()->user()->hasRole('employee') ? 'true' : 'false' }};
// Employee cannot edit project details (deadline, description, company)
const isEmployee = {{ auth()->user()->hasRole('employee') ? 'true' : 'false' }};
const canEditProjectDetails = {{ auth()->user()->can('Projects Management.edit project') ? 'true' : 'false' }};

// Helper function to show confirmation dialog
function showConfirmDialog(title, message, confirmText = 'Confirm', cancelText = 'Cancel') {
    return new Promise((resolve) => {
        // Create modal overlay
        const overlay = document.createElement('div');
        overlay.style.cssText = 'position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 999999;';
        
        // Create modal content
        overlay.innerHTML = `
            <div style="background: white; border-radius: 12px; padding: 24px; max-width: 400px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: modalSlideIn 0.2s ease-out;">
                <h3 style="margin: 0 0 12px 0; font-size: 18px; font-weight: 600; color: #1f2937;">${title}</h3>
                <p style="margin: 0 0 24px 0; font-size: 14px; color: #6b7280; line-height: 1.5;">${message}</p>
                <div style="display: flex; gap: 12px; justify-content: flex-end;">
                    <button id="confirmDialogCancel" style="padding: 10px 20px; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 500; color: #374151; transition: all 0.2s;">${cancelText}</button>
                    <button id="confirmDialogConfirm" style="padding: 10px 20px; background: #10b981; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600; color: white; transition: all 0.2s;">${confirmText}</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(overlay);
        
        // Handle button clicks
        overlay.querySelector('#confirmDialogConfirm').onclick = () => {
            document.body.removeChild(overlay);
            resolve(true);
        };
        
        overlay.querySelector('#confirmDialogCancel').onclick = () => {
            document.body.removeChild(overlay);
            resolve(false);
        };
        
        // Close on overlay click
        overlay.onclick = (e) => {
            if (e.target === overlay) {
                document.body.removeChild(overlay);
                resolve(false);
            }
        };
    });
}

// Helper function to get initials from name
function getInitials(name) {
    if (!name) return '?';
    // Clean name - remove anything in parentheses and special characters
    let cleanName = name.replace(/\s*\([^)]*\)/g, '').replace(/[^a-zA-Z\s]/g, '').trim();
    const parts = cleanName.split(' ').filter(p => p.length > 0);
    if (parts.length >= 2) {
        return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
    }
    if (parts.length === 1 && parts[0].length >= 2) {
        return parts[0].substring(0, 2).toUpperCase();
    }
    return name.substring(0, 2).toUpperCase();
}

// Helper function to create avatar HTML for completed tasks/subtasks
// Now accepts extra info: completedAt (datetime string), dueDate, dueTime
function createCompletedAvatar(userName, userColor, photoPath, isSubtask = false, completedAt = null, dueDate = null, dueTime = null) {
    const initials = getInitials(userName);
    const avatarClass = isSubtask ? 'subtask-completed-avatar' : 'completed-by-avatar';
    const fontSize = isSubtask ? 8 : 9;
    const size = isSubtask ? 20 : 22;
    const borderWidth = 2;
    
    // Build tooltip content
    let tooltipLines = [`✓ Done by ${userName}`];
    
    // Add completion date/time if available
    if (completedAt) {
        const completedDate = new Date(completedAt);
        const formattedCompletedDate = completedDate.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
        const formattedCompletedTime = completedDate.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit', hour12: true });
        tooltipLines.push(`📅 ${formattedCompletedDate} at ${formattedCompletedTime}`);
    }
    
    // Add due date/time if available
    if (dueDate) {
        let formattedDueDate = dueDate;
        // Try to parse if it's a date string
        try {
            const dueDateObj = new Date(dueDate);
            if (!isNaN(dueDateObj.getTime())) {
                formattedDueDate = dueDateObj.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            }
        } catch(e) {}
        let dueText = `⏰ Due: ${formattedDueDate}`;
        if (dueTime) {
            const [hours, minutes] = dueTime.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const hour12 = hour % 12 || 12;
            dueText += ` at ${hour12}:${minutes} ${ampm}`;
        }
        tooltipLines.push(dueText);
    }
    
    const tooltipText = tooltipLines.join(' | ');
    
    // Check if photoPath is valid (not empty string, null, or undefined)
    const hasPhoto = photoPath && photoPath.trim() !== '';
    
    if (hasPhoto) {
        // Photo with colored border ring - image displayed with fallback to initials
        return `<div class="${avatarClass}" data-tooltip="${tooltipText}" title="${userName}" style="border: ${borderWidth}px solid ${userColor}; background: #f3f4f6; width: ${size}px; height: ${size}px;">
            <img src="${photoPath}" alt="${userName}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="avatar-fallback" style="display: none; width: 100%; height: 100%; background: ${userColor}; font-size: ${fontSize}px; align-items: center; justify-content: center; color: white; font-weight: 700; border-radius: 50%;">${initials}</div>
        </div>`;
    } else {
        // Initials on colored background
        return `<div class="${avatarClass}" data-tooltip="${tooltipText}" title="${userName}" style="background: ${userColor}; width: ${size}px; height: ${size}px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: ${fontSize}px;">${initials}</div>`;
    }
}

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
    
    // Build delete button based on permission
    const deleteButtonHTML = canDeleteTask ? `
        <button onclick="deleteTask('${taskId}')" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #fee2e2; border: 1px solid #fecaca; border-radius: 6px; cursor: pointer; transition: all 0.2s;" title="Delete task">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            </svg>
        </button>` : '';
    
    const taskHTML = `
        <div id="${taskId}" style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; margin-bottom: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <!-- Task Header -->
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <div class="checkbox-avatar-wrapper">
                    <input type="checkbox" class="task-checkbox" onchange="toggleTaskComplete('${taskId}')">
                </div>
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div class="task-title" style="font-size: 15px; font-weight: 600; color: #000;">${taskTitle}</div>
                        ${deleteButtonHTML}
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
                
                ${canCreateTask ? `
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
                ` : ''}
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
        body: (() => {
            const dueDateVal = document.getElementById('newTaskDueDate').value;
            const dueTimeVal = document.getElementById('newTaskDueTime').value;
            return JSON.stringify({
                title: taskTitle,
                description: null,
                due_date: dueDateVal && dueDateVal.trim() !== '' ? dueDateVal : null,
                due_time: dueTimeVal && dueTimeVal.trim() !== '' ? dueTimeVal : null,
                parent_id: null
            });
        })()
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
    let checkbox = taskElement.querySelector('input.task-checkbox');
    const existingAvatar = taskElement.querySelector('.completed-by-avatar');
    const titleElement = taskElement.querySelector('.task-title');
    
    // Determine current state from checkbox
    const isCompleted = checkbox ? checkbox.checked : false;
    
    // If trying to uncheck (mark as not done), check permission
    if (!isCompleted && !canUncheckTask) {
        checkbox.checked = true; // Revert the checkbox
        toastr.warning('Only admin or authorized users can unmark completed tasks.');
        return;
    }
    
    // Show confirmation popup when marking as done
    if (isCompleted) {
        const confirmed = await showConfirmDialog('Mark as Done', 'Are you sure you want to mark this task as done?', 'Mark Done', 'Cancel');
        if (!confirmed) {
            checkbox.checked = false; // Revert the checkbox
            return;
        }
    }
    
    // Update UI immediately with user's color
    if (isCompleted) {
        titleElement.style.textDecoration = 'line-through';
        titleElement.style.color = '#9ca3af';
        taskElement.style.background = '#f0fdf4';
        checkbox.style.setProperty('--completed-color', currentUser.chat_color);
        
        // Add avatar next to checkbox inside the wrapper
        if (!existingAvatar) {
            const avatarHTML = createCompletedAvatar(currentUser.name, currentUser.chat_color, currentUser.photo_path, false);
            // Insert into wrapper div
            const wrapper = checkbox.closest('.checkbox-avatar-wrapper');
            if (wrapper) {
                wrapper.insertAdjacentHTML('beforeend', avatarHTML);
            } else {
                checkbox.insertAdjacentHTML('afterend', avatarHTML);
            }
        }
    } else {
        titleElement.style.textDecoration = 'none';
        titleElement.style.color = '#000';
        taskElement.style.background = 'white';
        checkbox.style.removeProperty('--completed-color');
        
        // Remove avatar if exists
        if (existingAvatar) {
            existingAvatar.remove();
        }
        
        // If unchecking the main task, automatically uncheck all subtasks
        const subtasksContainer = document.getElementById(taskId + '-subtasks');
        if (subtasksContainer) {
            const subtaskElements = subtasksContainer.querySelectorAll(':scope > [id^="' + taskId + '-sub-"]');
            
            // Uncheck all subtasks
            for (const subtaskElement of subtaskElements) {
                const subtaskCheckbox = subtaskElement.querySelector('input.subtask-checkbox');
                const existingSubtaskAvatar = subtaskElement.querySelector('.subtask-completed-avatar');
                const doneByInfo = subtaskElement.querySelector('.subtask-done-by');
                
                // Skip if already unchecked
                if (subtaskCheckbox && !subtaskCheckbox.checked) continue;
                
                if (subtaskCheckbox) {
                    const subtaskId = subtaskElement.id;
                    
                    // Update subtask UI - remove completed styling
                    const textElement = subtaskElement.querySelector('.subtask-text');
                    if (textElement) {
                        textElement.style.textDecoration = 'none';
                        textElement.style.color = '#374151';
                    }
                    subtaskElement.style.borderLeftColor = '#e5e7eb';
                    subtaskCheckbox.checked = false;
                    subtaskCheckbox.style.removeProperty('--completed-color');
                    
                    // Remove avatar if exists
                    if (existingSubtaskAvatar) {
                        existingSubtaskAvatar.remove();
                    }
                    
                    // Remove "Done by" info if exists
                    if (doneByInfo) {
                        doneByInfo.remove();
                    }
                    
                    // Save subtask to database (uncheck)
                    const subtaskDbId = subtaskId.split('-sub-')[1];
                    fetch(`{{ url('/projects') }}/${currentProjectId}/tasks/${subtaskDbId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ is_completed: false })
                    }).catch(err => console.error('Error updating subtask:', err));
                }
            }
        }
    }
    
    // If checking the main task, automatically check all subtasks
    if (isCompleted) {
        const subtasksContainer = document.getElementById(taskId + '-subtasks');
        const subtaskElements = subtasksContainer.querySelectorAll(':scope > [id^="' + taskId + '-sub-"]');
        
        // Check all subtasks
        for (const subtaskElement of subtaskElements) {
            const subtaskCheckbox = subtaskElement.querySelector('input.subtask-checkbox');
            const existingSubtaskAvatar = subtaskElement.querySelector('.subtask-completed-avatar');
            
            // Skip if already completed
            if (subtaskCheckbox && subtaskCheckbox.checked) continue;
            
            if (subtaskCheckbox) {
                const subtaskId = subtaskElement.id;
                
                // Update subtask UI
                const textElement = subtaskElement.querySelector('.subtask-text');
                if (textElement) {
                    textElement.style.textDecoration = 'line-through';
                    textElement.style.color = '#9ca3af';
                }
                subtaskElement.style.borderLeftColor = currentUser.chat_color;
                subtaskCheckbox.checked = true;
                subtaskCheckbox.style.setProperty('--completed-color', currentUser.chat_color);
                
                // Add avatar next to checkbox inside wrapper with current time
                if (!existingSubtaskAvatar) {
                    const completedAt = new Date().toISOString();
                    const dueDateSpan = subtaskElement.querySelector(`[id$="-date"]`);
                    const dueDate = dueDateSpan && dueDateSpan.textContent ? dueDateSpan.textContent : null;
                    const avatarHTML = createCompletedAvatar(currentUser.name, currentUser.chat_color, currentUser.photo_path, true, completedAt, dueDate, null);
                    // Insert into wrapper div
                    const wrapper = subtaskCheckbox.closest('.checkbox-avatar-wrapper');
                    if (wrapper) {
                        wrapper.insertAdjacentHTML('beforeend', avatarHTML);
                    } else {
                        subtaskCheckbox.insertAdjacentHTML('afterend', avatarHTML);
                    }
                }
                
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
        
        // Handle conflict - someone else already completed this task
        if (response.status === 409 && data.conflict) {
            // Revert checkbox
            checkbox.checked = !isCompleted;
            titleElement.style.textDecoration = 'none';
            titleElement.style.color = '#000';
            taskElement.style.background = 'white';
            
            // Show conflict popup
            Swal.fire({
                title: '<span style="color: #dc2626;">⚠️ Task Already Completed</span>',
                html: `
                    <div style="text-align: center; padding: 10px 0;">
                        <p style="font-size: 15px; color: #374151; margin-bottom: 15px;">${data.message}</p>
                        <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px; padding: 12px; margin-top: 10px;">
                            <p style="font-size: 13px; color: #92400e; margin: 0;">
                                <strong>Completed by:</strong> ${data.completed_by.name}<br>
                                <strong>At:</strong> ${data.completed_by.completed_at}
                            </p>
                        </div>
                    </div>
                `,
                icon: 'warning',
                confirmButtonText: 'OK, Refresh Tasks',
                confirmButtonColor: '#3b82f6',
                customClass: {
                    popup: 'custom-swal-popup',
                    confirmButton: 'custom-swal-confirm'
                }
            }).then(() => {
                // Refresh tasks to get latest status
                if (typeof loadProjectTasks === 'function') {
                    loadProjectTasks(currentProjectId);
                } else {
                    location.reload();
                }
            });
            return;
        }
        
        if (data.success) {
            // Update task progress bar
            updateTaskProgress(taskId);
            // Update the kanban card task count
            updateKanbanCardTaskCount();
            if (typeof toastr !== 'undefined') {
                toastr.success(isCompleted ? 'Task and all subtasks marked as done!' : 'Task and all subtasks reopened!');
            }
        } else {
            // Revert checkbox on error
            checkbox.checked = !isCompleted;
            titleElement.style.textDecoration = 'none';
            titleElement.style.color = '#000';
            taskElement.style.background = 'white';
            if (typeof toastr !== 'undefined') {
                toastr.error(data.message || 'Failed to update task');
            }
        }
    } catch (error) {
        console.error('Error updating task:', error);
        // Revert checkbox on error
        checkbox.checked = !isCompleted;
        titleElement.style.textDecoration = 'none';
        titleElement.style.color = '#000';
        taskElement.style.background = 'white';
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

// Show date-time picker popup for subtask
function showSubtaskDateTimePicker(subtaskId) {
    // Remove any existing picker
    const existingPicker = document.getElementById('subtask-datetime-picker');
    if (existingPicker) existingPicker.remove();
    
    // Get current values
    const dateValue = document.getElementById(subtaskId + '-date-value')?.value || '';
    const timeValue = document.getElementById(subtaskId + '-time-value')?.value || '';
    
    // Get button position for popup placement
    const subtaskElement = document.getElementById(subtaskId);
    const rect = subtaskElement.getBoundingClientRect();
    
    // Calculate position - ensure popup stays within viewport
    let top = rect.bottom + 8;
    let left = rect.left;
    
    // Adjust if too close to bottom
    if (top + 200 > window.innerHeight) {
        top = rect.top - 200;
    }
    
    // Adjust if too close to right
    if (left + 320 > window.innerWidth) {
        left = window.innerWidth - 330;
    }
    
    // Create picker popup
    const picker = document.createElement('div');
    picker.id = 'subtask-datetime-picker';
    picker.style.cssText = `
        position: fixed;
        top: ${top}px;
        left: ${left}px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.25), 0 0 0 1px rgba(0,0,0,0.05);
        padding: 20px;
        z-index: 10000;
        min-width: 320px;
        animation: fadeIn 0.2s ease;
    `;
    
    picker.innerHTML = `
        <div style="margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <div>
                    <div style="font-weight: 700; color: #111827; font-size: 15px;">Set Due Date & Time</div>
                    <div style="font-size: 11px; color: #6b7280;">Schedule when this subtask is due</div>
                </div>
            </div>
            <button onclick="closeSubtaskDateTimePicker()" style="width: 28px; height: 28px; background: #f3f4f6; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div style="display: flex; gap: 12px; margin-bottom: 16px;">
            <div style="flex: 1;">
                <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: #374151; margin-bottom: 6px; font-weight: 600;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    Date
                </label>
                <input type="date" id="subtask-picker-date" value="${dateValue}" style="width: 100%; padding: 10px 12px; border: 2px solid #d1d5db; border-radius: 10px; font-size: 14px; font-weight: 600; color: #000000; outline: none; transition: all 0.2s; background: white;" onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.15)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
            </div>
            <div style="flex: 1;">
                <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: #374151; margin-bottom: 6px; font-weight: 600;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 6v6l4 2"></path>
                    </svg>
                    Time
                </label>
                <input type="time" id="subtask-picker-time" value="${timeValue}" style="width: 100%; padding: 10px 12px; border: 2px solid #d1d5db; border-radius: 10px; font-size: 14px; font-weight: 600; color: #000000; outline: none; transition: all 0.2s; background: white;" onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.15)'" onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
            </div>
        </div>
        <div style="display: flex; gap: 10px; justify-content: flex-end; padding-top: 12px; border-top: 1px solid #f3f4f6;">
            <button onclick="clearSubtaskDateTime('${subtaskId}')" style="padding: 10px 16px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; font-size: 13px; cursor: pointer; color: #dc2626; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#fef2f2'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
                Clear
            </button>
            <button onclick="saveSubtaskDateTime('${subtaskId}')" style="padding: 10px 20px; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); border: none; border-radius: 8px; font-size: 13px; cursor: pointer; color: white; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(99,102,241,0.3);" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(99,102,241,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(99,102,241,0.3)'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                Save
            </button>
        </div>
    `;
    
    document.body.appendChild(picker);
    
    // Close on click outside
    setTimeout(() => {
        document.addEventListener('click', closePickerOnClickOutside);
    }, 100);
}

function closePickerOnClickOutside(e) {
    const picker = document.getElementById('subtask-datetime-picker');
    if (picker && !picker.contains(e.target) && !e.target.closest('[onclick*="showSubtaskDateTimePicker"]')) {
        closeSubtaskDateTimePicker();
    }
}

function closeSubtaskDateTimePicker() {
    const picker = document.getElementById('subtask-datetime-picker');
    if (picker) picker.remove();
    document.removeEventListener('click', closePickerOnClickOutside);
}

function clearSubtaskDateTime(subtaskId) {
    // Extract subtask ID (format: task-123-sub-456)
    const parts = subtaskId.split('-sub-');
    const subtaskDbId = parts[1];
    
    // Save to database with null values
    fetch(`{{ url('/projects') }}/${currentProjectId}/tasks/${subtaskDbId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            due_date: null,
            due_time: null
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update hidden inputs
            const dateInput = document.getElementById(subtaskId + '-date-value');
            const timeInput = document.getElementById(subtaskId + '-time-value');
            if (dateInput) dateInput.value = '';
            if (timeInput) timeInput.value = '';
            
            // Update display
            const display = document.getElementById(subtaskId + '-datetime');
            if (display) {
                display.textContent = '';
                display.style.display = 'none';
            }
            
            closeSubtaskDateTimePicker();
            toastr.success('Due date cleared');
        }
    })
    .catch(error => {
        console.error('Error clearing date:', error);
        toastr.error('Failed to clear date');
    });
}

function saveSubtaskDateTime(subtaskId) {
    const dateInput = document.getElementById('subtask-picker-date');
    const timeInput = document.getElementById('subtask-picker-time');
    
    const dateValue = dateInput?.value || '';
    const timeValue = timeInput?.value || '';
    
    if (!dateValue) {
        toastr.warning('Please select a date');
        return;
    }
    
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
            due_date: dateValue,
            due_time: timeValue || null
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update hidden inputs
            const hiddenDate = document.getElementById(subtaskId + '-date-value');
            const hiddenTime = document.getElementById(subtaskId + '-time-value');
            if (hiddenDate) hiddenDate.value = dateValue;
            if (hiddenTime) hiddenTime.value = timeValue;
            
            // Format display
            const date = new Date(dateValue);
            let displayText = date.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
            
            if (timeValue) {
                const [hours, minutes] = timeValue.split(':');
                const hour = parseInt(hours);
                const ampm = hour >= 12 ? 'PM' : 'AM';
                const hour12 = hour % 12 || 12;
                displayText += ` at ${hour12}:${minutes} ${ampm}`;
            }
            
            // Check if overdue (compare with current date/time)
            const now = new Date();
            let dueDateTime = new Date(dateValue);
            if (timeValue) {
                const [h, m] = timeValue.split(':');
                dueDateTime.setHours(parseInt(h), parseInt(m), 0, 0);
            } else {
                dueDateTime.setHours(23, 59, 59, 999);
            }
            
            // Check if subtask is completed
            const subtaskEl = document.getElementById(subtaskId);
            const checkbox = subtaskEl?.querySelector('.subtask-checkbox');
            const isCompleted = checkbox?.checked || false;
            const isOverdue = !isCompleted && now > dueDateTime;
            
            // Set colors based on overdue status
            const badgeBg = isOverdue ? 'linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%)' : 'linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%)';
            const badgeBorder = isOverdue ? '#fecaca' : '#bae6fd';
            const badgeColor = isOverdue ? '#dc2626' : '#0369a1';
            const hoverBg = isOverdue ? 'linear-gradient(135deg, #fee2e2 0%, #fecaca 100%)' : 'linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%)';
            const hoverBorder = isOverdue ? '#fca5a5' : '#7dd3fc';
            
            // Update display with styled badge
            const display = document.getElementById(subtaskId + '-datetime');
            if (display) {
                display.innerHTML = `
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    ${displayText}
                `;
                display.style.cssText = `display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; background: ${badgeBg}; border: 1px solid ${badgeBorder}; border-radius: 20px; font-size: 11px; color: ${badgeColor}; font-weight: 600; flex-shrink: 0; white-space: nowrap; cursor: pointer; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);`;
                display.dataset.overdue = isOverdue;
                if (isOverdue) {
                    display.classList.add('overdue');
                } else {
                    display.classList.remove('overdue');
                }
                display.onmouseover = function() { this.style.background = isOverdue ? 'linear-gradient(135deg, #fee2e2 0%, #fecaca 100%)' : 'linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%)'; this.style.borderColor = isOverdue ? '#fca5a5' : '#7dd3fc'; };
                display.onmouseout = function() { this.style.background = isOverdue ? 'linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%)' : 'linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%)'; this.style.borderColor = isOverdue ? '#fecaca' : '#bae6fd'; };
            }
            
            closeSubtaskDateTimePicker();
            toastr.success('Due date & time saved');
        }
    })
    .catch(error => {
        console.error('Error saving date:', error);
        toastr.error('Failed to save date');
    });
}

// Legacy function for backward compatibility
function toggleSubtaskDate(subtaskId) {
    showSubtaskDateTimePicker(subtaskId);
}

function saveSubtaskDate(subtaskId) {
    // This function is now replaced by saveSubtaskDateTime
    // Kept for backward compatibility
    saveSubtaskDateTime(subtaskId);
}

function saveSubtask(taskId) {
    const subtaskInput = document.getElementById(taskId + '-subtask-input');
    const subtaskTitle = subtaskInput.value.trim();
    
    if (!subtaskTitle) {
        toastr.warning('Please enter a subtask');
        return;
    }
    
    const subtaskId = taskId + '-sub-' + Date.now();
    
    // Build timing button based on permission
    const timingButtonHTML = canEditTask ? `
        <button onclick="toggleSubtaskDate('${subtaskId}')" style="display: flex; align-items: center; justify-content: center; background: none; border: none; cursor: pointer; padding: 0; flex-shrink: 0;" title="Add due date">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M12 6v6l4 2"></path>
            </svg>
        </button>` : '';
    
    // Build delete button based on permission
    const deleteButtonHTML = canDeleteTask ? `
        <button onclick="deleteSubtask('${subtaskId}', '${taskId}')" style="display: flex; align-items: center; justify-content: center; width: 26px; height: 26px; background: #fee2e2; border: 1px solid #fecaca; border-radius: 5px; cursor: pointer; flex-shrink: 0; transition: all 0.2s;" title="Delete subtask">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            </svg>
        </button>` : '';
    
    const subtaskHTML = `
        <div id="${subtaskId}" style="display: flex; align-items: center; gap: 8px; padding: 10px 12px; border-left: 3px solid #e5e7eb; margin-bottom: 6px; transition: all 0.2s;">
            ${timingButtonHTML}
            <div class="checkbox-avatar-wrapper">
                <input type="checkbox" class="subtask-checkbox" onchange="toggleSubtaskComplete('${subtaskId}', '${taskId}')">
            </div>
            <span class="subtask-text" style="font-size: 13px; color: #000; flex: 1;">${subtaskTitle}</span>
            <span id="${subtaskId}-date" style="font-size: 12px; color: #6b7280; flex-shrink: 0; display: none;"></span>
            <input type="date" id="${subtaskId}-date-input" style="position: absolute; opacity: 0; pointer-events: none;" onchange="saveSubtaskDate('${subtaskId}')">
            ${deleteButtonHTML}
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
    let checkbox = subtaskElement.querySelector('input.subtask-checkbox');
    const textElement = subtaskElement.querySelector('.subtask-text');
    
    // Determine current state from checkbox
    const isCompleted = checkbox ? checkbox.checked : false;
    
    // If trying to uncheck (mark as not done), check permission
    if (!isCompleted && !canUncheckTask) {
        checkbox.checked = true; // Revert the checkbox
        toastr.warning('Only admin or authorized users can unmark completed tasks.');
        return;
    }
    
    // Show confirmation popup when marking as done
    if (isCompleted) {
        const confirmed = await showConfirmDialog('Mark as Done', 'Are you sure you want to mark this subtask as done?', 'Mark Done', 'Cancel');
        if (!confirmed) {
            checkbox.checked = false; // Revert the checkbox
            return;
        }
    }
    
    // Update UI immediately with user's color
    if (isCompleted) {
        textElement.style.textDecoration = 'line-through';
        textElement.style.color = '#9ca3af';
        subtaskElement.style.borderLeftColor = currentUser.chat_color;
        checkbox.style.setProperty('--completed-color', currentUser.chat_color);
        
        const completedAt = new Date();
        const formattedDate = completedAt.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
        const formattedTime = completedAt.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit', hour12: true });
        
        // Add "Done by" info - insert into the flex container (right side)
        const existingDoneBy = subtaskElement.querySelector('.subtask-done-by');
        if (!existingDoneBy) {
            const initials = getInitials(currentUser.name);
            const hasPhoto = currentUser.photo_path && currentUser.photo_path.trim() !== '';
            
            // Create profile avatar
            let avatarHTML = '';
            if (hasPhoto) {
                avatarHTML = `<div style="width: 20px; height: 20px; min-width: 20px; border-radius: 50%; overflow: hidden; border: 2px solid ${currentUser.chat_color}; background: #f3f4f6; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                    <img src="${currentUser.photo_path}" alt="${currentUser.name}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div style="display: none; width: 100%; height: 100%; background: ${currentUser.chat_color}; align-items: center; justify-content: center; color: white; font-size: 8px; font-weight: 700;">${initials}</div>
                </div>`;
            } else {
                avatarHTML = `<div style="width: 20px; height: 20px; min-width: 20px; border-radius: 50%; background: ${currentUser.chat_color}; display: flex; align-items: center; justify-content: center; color: white; font-size: 8px; font-weight: 700; flex-shrink: 0;">${initials}</div>`;
            }
            
            const doneByHTML = `<span class="subtask-done-by" style="display: inline-flex; align-items: center; gap: 6px; font-size: 11px; color: ${currentUser.chat_color}; font-weight: 600; white-space: nowrap;">
                ${avatarHTML}
                <span>Done by ${currentUser.name}</span>
                <span style="color: #6b7280; font-weight: 400;">· ${formattedDate} at ${formattedTime}</span>
            </span>`;
            
            // Find the flex container (div after subtask-text) and prepend the done-by info
            const flexContainer = textElement.nextElementSibling;
            if (flexContainer && flexContainer.tagName === 'DIV') {
                flexContainer.insertAdjacentHTML('afterbegin', doneByHTML);
            } else {
                textElement.insertAdjacentHTML('afterend', doneByHTML);
            }
        }
    } else {
        textElement.style.textDecoration = 'none';
        textElement.style.color = '#000';
        subtaskElement.style.borderLeftColor = '#e5e7eb';
        checkbox.style.removeProperty('--completed-color');
        
        // Remove "Done by" info
        const doneByEl = subtaskElement.querySelector('.subtask-done-by');
        if (doneByEl) doneByEl.remove();
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
            
            // Check if all subtasks are now completed (check both checkboxes and avatars)
            const subtasksContainer = document.getElementById(taskId + '-subtasks');
            // Select only direct child subtask container divs
            const subtaskElements = subtasksContainer.querySelectorAll(':scope > [id^="' + taskId + '-sub-"]');
            const allCompleted = Array.from(subtaskElements).every(el => {
                const checkbox = el.querySelector('input.subtask-checkbox');
                const avatar = el.querySelector('.subtask-completed-avatar');
                const doneBy = el.querySelector('.subtask-done-by');
                return avatar !== null || doneBy !== null || (checkbox && checkbox.checked);
            });
            
            // If all subtasks are completed, automatically check the main task
            if (allCompleted && subtaskElements.length > 0) {
                const taskElement = document.getElementById(taskId);
                const mainTaskCheckbox = taskElement.querySelector('input.task-checkbox');
                const existingMainAvatar = taskElement.querySelector('.completed-by-avatar');
                
                // Only update if not already completed
                if (mainTaskCheckbox && !mainTaskCheckbox.checked) {
                    // Update main task UI
                    const titleElement = taskElement.querySelector('.task-title');
                    titleElement.style.textDecoration = 'line-through';
                    titleElement.style.color = '#9ca3af';
                    taskElement.style.background = '#f0fdf4';
                    mainTaskCheckbox.checked = true;
                    mainTaskCheckbox.style.setProperty('--completed-color', currentUser.chat_color);
                    
                    // Add avatar next to checkbox inside wrapper
                    if (!existingMainAvatar) {
                        const avatarHTML = createCompletedAvatar(currentUser.name, currentUser.chat_color, currentUser.photo_path, false);
                        // Insert into wrapper div
                        const wrapper = mainTaskCheckbox.closest('.checkbox-avatar-wrapper');
                        if (wrapper) {
                            wrapper.insertAdjacentHTML('beforeend', avatarHTML);
                        } else {
                            mainTaskCheckbox.insertAdjacentHTML('afterend', avatarHTML);
                        }
                    }
                    
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
                const mainTaskCheckbox = taskElement.querySelector('input.task-checkbox');
                const existingMainAvatar = taskElement.querySelector('.completed-by-avatar');
                
                // If main task is completed, uncheck it
                if (mainTaskCheckbox && mainTaskCheckbox.checked) {
                    mainTaskCheckbox.checked = false;
                    mainTaskCheckbox.style.removeProperty('--completed-color');
                    
                    // Remove avatar if exists
                    if (existingMainAvatar) {
                        existingMainAvatar.remove();
                    }
                    
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
    // Select only subtask container divs - they have the subtask-checkbox inside
    // This ensures we only count actual subtask elements, not datetime spans or hidden inputs
    const subtaskElements = subtasksContainer.querySelectorAll(':scope > [id^="' + taskId + '-sub-"]');
    const total = subtaskElements.length;
    
    // Count completed subtasks (either has avatar/done-by section or checked checkbox)
    const completed = Array.from(subtaskElements).filter(el => {
        const avatar = el.querySelector('.subtask-completed-avatar');
        const doneBySection = el.querySelector('.subtask-done-by');
        const checkbox = el.querySelector('input.subtask-checkbox');
        return avatar !== null || doneBySection !== null || (checkbox && checkbox.checked);
    }).length;
    
    let percentage = 0;
    
    // If there are subtasks, calculate based on subtask completion
    if (total > 0) {
        percentage = Math.round((completed / total) * 100);
    } else {
        // If no subtasks, check if the main task itself is completed
        const taskElement = document.getElementById(taskId);
        const mainTaskAvatar = taskElement.querySelector('.completed-by-avatar');
        const mainTaskCheckbox = taskElement.querySelector('input.task-checkbox');
        percentage = mainTaskAvatar !== null || (mainTaskCheckbox && mainTaskCheckbox.checked) ? 100 : 0;
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
    
    // Count ALL task elements (main tasks + subtasks)
    // Main tasks have class task-checkbox, subtasks have class subtask-checkbox
    let totalTasks = 0;
    let completedTasks = 0;
    
    // Count main tasks by finding elements with task-checkbox
    const mainTaskCheckboxes = tasksContainer.querySelectorAll('input.task-checkbox');
    mainTaskCheckboxes.forEach(checkbox => {
        totalTasks++;
        const taskElement = checkbox.closest('[id^="task-"]');
        const avatar = taskElement ? taskElement.querySelector('.completed-by-avatar') : null;
        if (avatar !== null || checkbox.checked) {
            completedTasks++;
        }
    });
    
    // Count subtasks by finding elements with subtask-checkbox
    const subtaskCheckboxes = tasksContainer.querySelectorAll('input.subtask-checkbox');
    subtaskCheckboxes.forEach(checkbox => {
        totalTasks++;
        const subtaskElement = checkbox.closest('[id*="-sub-"]');
        const avatar = subtaskElement ? subtaskElement.querySelector('.subtask-completed-avatar') : null;
        const doneBySection = subtaskElement ? subtaskElement.querySelector('.subtask-done-by') : null;
        if (avatar !== null || doneBySection !== null || checkbox.checked) {
            completedTasks++;
        }
    });
    
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
    
    // Reset task status tracking when loading new project
    lastKnownTaskStatus = {};
    
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
            
            // Render each task and initialize status tracking
            data.tasks.forEach(task => {
                renderTaskFromDB(task);
                
                // Initialize last known status for conflict detection
                lastKnownTaskStatus[task.id] = {
                    is_completed: task.is_completed,
                    completed_by: task.completed_by,
                    completed_by_name: task.completed_by_user ? task.completed_by_user.name : null,
                    completed_at: task.completed_at
                };
                
                // Also track subtasks
                if (task.subtasks) {
                    task.subtasks.forEach(subtask => {
                        lastKnownTaskStatus[subtask.id] = {
                            is_completed: subtask.is_completed,
                            completed_by: subtask.completed_by,
                            completed_by_name: subtask.completed_by_user ? subtask.completed_by_user.name : null,
                            completed_at: subtask.completed_at
                        };
                    });
                }
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
    
    // Add time info and description if available
    if (task.due_date || task.description || task.completed_by_user) {
        const taskElement = document.getElementById(taskId);
        const titleDiv = taskElement.querySelector('.task-title');
        let infoHTML = '';
        
        if (task.description) {
            infoHTML += `<div style="font-size: 13px; color: #6b7280; margin-top: 4px;">${task.description}</div>`;
        }
        
        if (task.due_date || (task.is_completed && task.completed_by_user)) {
            infoHTML += '<div style="display: flex; gap: 12px; margin-top: 6px; font-size: 12px; color: #6b7280;">';
            
            // Show who completed the task with profile picture
            if (task.is_completed && task.completed_by_user) {
                const completedColor = task.completed_by_user.chat_color || '#10b981';
                const userName = task.completed_by_user.name;
                const userPhoto = task.completed_by_user.photo_path;
                const initials = getInitials(userName);
                
                let miniAvatarHTML = '';
                if (userPhoto && userPhoto.trim() !== '') {
                    miniAvatarHTML = `<div style="width: 18px; height: 18px; min-width: 18px; border-radius: 50%; overflow: hidden; border: 2px solid ${completedColor}; background: #f3f4f6; flex-shrink: 0;">
                        <img src="${userPhoto}" alt="${userName}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div style="display: none; width: 100%; height: 100%; background: ${completedColor}; align-items: center; justify-content: center; color: white; font-size: 7px; font-weight: 700;">${initials}</div>
                    </div>`;
                } else {
                    miniAvatarHTML = `<div style="width: 18px; height: 18px; min-width: 18px; border-radius: 50%; background: ${completedColor}; display: flex; align-items: center; justify-content: center; color: white; font-size: 7px; font-weight: 700; flex-shrink: 0;">${initials}</div>`;
                }
                
                infoHTML += `
                    <span style="display: inline-flex; align-items: center; gap: 5px; color: ${completedColor}; font-weight: 600;">
                        ${miniAvatarHTML}
                        Done by ${userName}
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
    
    // Set task completion state with user's avatar next to checkbox
    if (task.is_completed) {
        const taskElement = document.getElementById(taskId);
        const checkbox = taskElement.querySelector('input[type="checkbox"]');
        const titleElement = taskElement.querySelector('.task-title');
        const completedByUser = task.completed_by_user;
        const completedColor = completedByUser && completedByUser.chat_color ? completedByUser.chat_color : '#10b981';
        
        // Check the checkbox and set color
        checkbox.checked = true;
        checkbox.style.setProperty('--completed-color', completedColor);
        
        // Add avatar next to checkbox
        if (completedByUser) {
            const avatarHTML = createCompletedAvatar(completedByUser.name, completedColor, completedByUser.photo_path, false);
            // Insert into wrapper div
            const wrapper = checkbox.closest('.checkbox-avatar-wrapper');
            if (wrapper) {
                wrapper.insertAdjacentHTML('beforeend', avatarHTML);
            } else {
                checkbox.insertAdjacentHTML('afterend', avatarHTML);
            }
        }
        
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
    const subtaskHTML = createSubtaskHTML(subtaskId, taskId, subtask.title, subtask.due_date, subtask.is_completed, subtask.completed_by_user, subtask.completed_at, subtask.due_time);
    document.getElementById(taskId + '-subtasks').insertAdjacentHTML('beforeend', subtaskHTML);
    
    // Update progress without triggering toggle
    updateTaskProgress(taskId);
}

// Helper function to create task HTML
function createTaskHTML(taskId, title) {
    // Build action buttons based on permissions
    let actionButtons = '';
    if (canEditTask) {
        actionButtons += `
            <button onclick="editTaskInKanban('${taskId}')" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #fef3c7; border: 1px solid #fde68a; border-radius: 6px; cursor: pointer; transition: all 0.2s;" title="Edit task">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
            </button>`;
    }
    if (canDeleteTask) {
        actionButtons += `
            <button onclick="deleteTask('${taskId}')" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #fee2e2; border: 1px solid #fecaca; border-radius: 6px; cursor: pointer; transition: all 0.2s;" title="Delete task">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
            </button>`;
    }
    
    return `
        <div id="${taskId}" style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; margin-bottom: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <div class="checkbox-avatar-wrapper">
                    <input type="checkbox" class="task-checkbox" onchange="toggleTaskComplete('${taskId}')">
                </div>
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div class="task-title" style="font-size: 15px; font-weight: 600; color: #000;">${title}</div>
                        <div style="display: flex; gap: 8px;">
                            ${actionButtons}
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
                ${canCreateTask ? `
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
                ` : ''}
            </div>
        </div>
    `;
}

// Helper function to create subtask HTML
function createSubtaskHTML(subtaskId, taskId, title, dueDate, isCompleted, completedByUser = null, completedAt = null, dueTime = null) {
    // Convert isCompleted to boolean (handles 1, "1", true, etc.)
    const completed = Boolean(isCompleted) || isCompleted === 1 || isCompleted === '1' || isCompleted === true;
    
    // Format date and time display
    let dateTimeDisplay = '';
    let isOverdue = false;
    
    if (dueDate) {
        const date = new Date(dueDate);
        dateTimeDisplay = date.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
        if (dueTime) {
            // Format time as 12-hour with AM/PM
            const [hours, minutes] = dueTime.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const hour12 = hour % 12 || 12;
            dateTimeDisplay += ` at ${hour12}:${minutes} ${ampm}`;
        }
        
        // Build due datetime for comparison
        let dueDateTime = new Date(dueDate);
        if (dueTime) {
            const [h, m] = dueTime.split(':');
            dueDateTime.setHours(parseInt(h), parseInt(m), 0, 0);
        } else {
            dueDateTime.setHours(23, 59, 59, 999);
        }
        
        // Check if overdue:
        // - If NOT completed: compare with current time
        // - If completed: compare with completion time (was it completed late?)
        if (!completed) {
            const now = new Date();
            isOverdue = now > dueDateTime;
        } else if (completedAt) {
            // Task is completed - check if it was completed AFTER the due date (late completion)
            const completedDateTime = new Date(completedAt);
            isOverdue = completedDateTime > dueDateTime;
        }
    }
    const completedColor = completedByUser && completedByUser.chat_color ? completedByUser.chat_color : '#10b981';
    
    // Build timing button based on permission (clock icon for date & time)
    let timingButton = '';
    if (canEditTask) {
        timingButton = `
            <button onclick="showSubtaskDateTimePicker('${subtaskId}')" style="display: flex; align-items: center; justify-content: center; background: none; border: none; cursor: pointer; padding: 0; flex-shrink: 0;" title="Set due date & time">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 6v6l4 2"></path>
                </svg>
            </button>`;
    }
    
    // Build delete button based on permission
    let deleteButton = '';
    if (canDeleteTask) {
        deleteButton = `
            <button onclick="deleteSubtask('${subtaskId}', '${taskId}')" style="display: flex; align-items: center; justify-content: center; width: 26px; height: 26px; background: #fee2e2; border: 1px solid #fecaca; border-radius: 5px; cursor: pointer; flex-shrink: 0; transition: all 0.2s;" title="Delete subtask">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
            </button>`;
    }
    
    // Build checkbox
    let checkboxHTML = `<input type="checkbox" class="subtask-checkbox" ${completed ? 'checked' : ''} style="--completed-color: ${completedColor};" onchange="toggleSubtaskComplete('${subtaskId}', '${taskId}')">`;
    
    // Build "Done by" info for completed subtasks with profile picture (single avatar only)
    let doneByHTML = '';
    if (completed && completedByUser) {
        const initials = getInitials(completedByUser.name);
        const hasPhoto = completedByUser.photo_path && completedByUser.photo_path.trim() !== '';
        
        // Create profile avatar for "Done by" section
        let avatarHTML = '';
        if (hasPhoto) {
            avatarHTML = `<div style="width: 20px; height: 20px; min-width: 20px; border-radius: 50%; overflow: hidden; border: 2px solid ${completedColor}; background: #f3f4f6; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                <img src="${completedByUser.photo_path}" alt="${completedByUser.name}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div style="display: none; width: 100%; height: 100%; background: ${completedColor}; align-items: center; justify-content: center; color: white; font-size: 8px; font-weight: 700;">${initials}</div>
            </div>`;
        } else {
            avatarHTML = `<div style="width: 20px; height: 20px; min-width: 20px; border-radius: 50%; background: ${completedColor}; display: flex; align-items: center; justify-content: center; color: white; font-size: 8px; font-weight: 700; flex-shrink: 0;">${initials}</div>`;
        }
        
        // Format completion date/time
        let dateTimeHTML = '';
        if (completedAt) {
            const completedDate = new Date(completedAt);
            const formattedDate = completedDate.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            const formattedTime = completedDate.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit', hour12: true });
            dateTimeHTML = `<span style="color: #6b7280; font-weight: 400;">· ${formattedDate} at ${formattedTime}</span>`;
        }
        
        doneByHTML = `<span class="subtask-done-by" style="display: inline-flex; align-items: center; gap: 6px; font-size: 11px; color: ${completedColor}; font-weight: 600; white-space: nowrap; margin-left: 4px;">
            ${avatarHTML}
            <span>Done by ${completedByUser.name}</span>
            ${dateTimeHTML}
        </span>`;
    }
    
    // Build datetime badge with nice styling (red for overdue, blue for normal)
    let dateTimeBadge = '';
    if (dateTimeDisplay) {
        // Overdue styling: red gradient, red border, red text
        // Normal styling: blue gradient, blue border, blue text
        const badgeBg = isOverdue ? 'linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%)' : 'linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%)';
        const badgeBorder = isOverdue ? '#fecaca' : '#bae6fd';
        const badgeColor = isOverdue ? '#dc2626' : '#0369a1';
        const hoverBg = isOverdue ? 'linear-gradient(135deg, #fee2e2 0%, #fecaca 100%)' : 'linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%)';
        const hoverBorder = isOverdue ? '#fca5a5' : '#7dd3fc';
        
        dateTimeBadge = `
            <span id="${subtaskId}-datetime" class="subtask-datetime-display ${isOverdue ? 'overdue' : ''}" data-overdue="${isOverdue}" style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; background: ${badgeBg}; border: 1px solid ${badgeBorder}; border-radius: 20px; font-size: 11px; color: ${badgeColor}; font-weight: 600; flex-shrink: 0; white-space: nowrap; cursor: ${canEditTask ? 'pointer' : 'default'}; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" ${canEditTask ? `onclick="showSubtaskDateTimePicker('${subtaskId}')" onmouseover="this.style.background='${hoverBg}'; this.style.borderColor='${hoverBorder}'" onmouseout="this.style.background='${badgeBg}'; this.style.borderColor='${badgeBorder}'"` : ''}>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                ${dateTimeDisplay}
            </span>`;
    } else {
        dateTimeBadge = `<span id="${subtaskId}-datetime" class="subtask-datetime-display" style="display: none;"></span>`;
    }
    
    return `
        <div id="${subtaskId}" style="display: flex; align-items: center; gap: 8px; padding: 10px 12px; border-left: 3px solid ${completed ? completedColor : '#e5e7eb'}; margin-bottom: 6px; transition: all 0.2s;">
            ${timingButton}
            <div class="checkbox-avatar-wrapper" style="display: flex; align-items: center;">
                ${checkboxHTML}
            </div>
            <span class="subtask-text" style="font-size: 13px; color: ${completed ? '#9ca3af' : '#000'}; ${completed ? 'text-decoration: line-through;' : ''}">${title}</span>
            <div style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; min-width: 0;">
                ${doneByHTML}
            </div>
            ${dateTimeBadge}
            <input type="hidden" id="${subtaskId}-date-value" value="${dueDate || ''}">
            <input type="hidden" id="${subtaskId}-time-value" value="${dueTime || ''}">
            ${deleteButton}
        </div>
    `;
}

// Group Chat Functions - Real-time polling
let chatPollingInterval = null;
let lastMessageId = 0;
let typingTimeout = null;
let isTyping = false;
let typingUsers = new Map(); // Track who is typing

// Start polling for new messages
function startChatPolling() {
    // Clear any existing interval
    stopChatPolling();
    
    // Poll every 1.5 seconds for real-time updates (messages, typing, task status)
    chatPollingInterval = setInterval(() => {
        if (currentProjectId) {
            pollNewMessages();
            pollTypingStatus();
            pollTasksStatus(); // Poll for task status changes - live sync across users
        }
    }, 1500);
    
    console.log('Chat and task polling started');
}

// Track last known task status to detect changes
let lastKnownTaskStatus = {};

// Poll for task status changes (real-time conflict detection)
function pollTasksStatus() {
    if (!currentProjectId) return;
    
    fetch(`{{ url('/projects') }}/${currentProjectId}/tasks-status`, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.tasks) {
            data.tasks.forEach(task => {
                // Determine if this is a main task or subtask based on parent_id
                const isSubtask = task.parent_id !== null;
                let elementId;
                
                if (isSubtask) {
                    // Find the parent task element to construct subtask ID
                    elementId = 'task-' + task.parent_id + '-sub-' + task.id;
                } else {
                    elementId = 'task-' + task.id;
                }
                
                const taskElement = document.getElementById(elementId);
                
                // Check if task status changed by someone else
                if (lastKnownTaskStatus[task.id] !== undefined) {
                    const wasCompleted = lastKnownTaskStatus[task.id].is_completed;
                    const wasCompletedBy = lastKnownTaskStatus[task.id].completed_by;
                    
                    // If task was just completed by someone else
                    if (!wasCompleted && task.is_completed && task.completed_by != {{ auth()->id() }}) {
                        // Show notification popup (only for main tasks to avoid spam)
                        if (!isSubtask) {
                            showTaskCompletedByOtherPopup(task);
                        }
                        
                        // Update UI to reflect the change
                        if (taskElement) {
                            if (isSubtask) {
                                updateSubtaskUIAsCompleted(elementId, task);
                            } else {
                                updateTaskUIAsCompleted(elementId, task);
                            }
                        }
                    }
                    // If task was uncompleted by someone else
                    else if (wasCompleted && !task.is_completed && wasCompletedBy != {{ auth()->id() }}) {
                        // Show notification (only for main tasks)
                        if (!isSubtask) {
                            toastr.info(`Task was reopened by ${task.completed_by_name || 'another user'}`);
                        }
                        
                        // Update UI to reflect the change
                        if (taskElement) {
                            if (isSubtask) {
                                updateSubtaskUIAsNotCompleted(elementId, task.parent_id);
                            } else {
                                updateTaskUIAsNotCompleted(elementId);
                            }
                        }
                    }
                }
                
                // Update last known status
                lastKnownTaskStatus[task.id] = {
                    is_completed: task.is_completed,
                    completed_by: task.completed_by,
                    completed_by_name: task.completed_by_name,
                    completed_at: task.completed_at,
                    completed_by_user: task.completed_by_user
                };
            });
        }
    })
    .catch(error => console.error('Error polling task status:', error));
}

// Show popup when another user completes a task
function showTaskCompletedByOtherPopup(task) {
    Swal.fire({
        title: '<span style="color: #10b981;">✅ Task Completed</span>',
        html: `
            <div style="text-align: center; padding: 10px 0;">
                <p style="font-size: 15px; color: #374151; margin-bottom: 15px;">
                    <strong>${task.completed_by_name}</strong> just completed a task!
                </p>
                <div style="background: #ecfdf5; border: 1px solid #10b981; border-radius: 8px; padding: 12px; margin-top: 10px;">
                    <p style="font-size: 13px; color: #065f46; margin: 0;">
                        <strong>Completed at:</strong> ${task.completed_at}
                    </p>
                </div>
            </div>
        `,
        icon: 'info',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true
    });
}

// Update task UI as completed (when another user completes it)
function updateTaskUIAsCompleted(taskId, task) {
    const taskElement = document.getElementById(taskId);
    if (!taskElement) return;
    
    const checkbox = taskElement.querySelector('input.task-checkbox');
    const titleElement = taskElement.querySelector('.task-title');
    const existingAvatar = taskElement.querySelector('.completed-by-avatar');
    
    // Get user info from task
    const completedByUser = task.completed_by_user;
    const completedColor = completedByUser && completedByUser.chat_color ? completedByUser.chat_color : '#10b981';
    
    if (checkbox) {
        checkbox.checked = true;
        checkbox.style.setProperty('--completed-color', completedColor);
    }
    if (titleElement) {
        titleElement.style.textDecoration = 'line-through';
        titleElement.style.color = '#9ca3af';
    }
    taskElement.style.background = '#f0fdf4';
    
    // Add avatar next to checkbox if not already present
    if (!existingAvatar && completedByUser) {
        const avatarHTML = createCompletedAvatar(
            completedByUser.name, 
            completedColor, 
            completedByUser.photo_path, 
            false
        );
        const wrapper = checkbox ? checkbox.closest('.checkbox-avatar-wrapper') : null;
        if (wrapper) {
            wrapper.insertAdjacentHTML('beforeend', avatarHTML);
        } else if (checkbox) {
            checkbox.insertAdjacentHTML('afterend', avatarHTML);
        }
    }
    
    // Update progress
    updateTaskProgress(taskId);
    updateKanbanCardTaskCount();
}

// Update task UI as not completed (when another user reopens it)
function updateTaskUIAsNotCompleted(taskId) {
    const taskElement = document.getElementById(taskId);
    if (!taskElement) return;
    
    const checkbox = taskElement.querySelector('input.task-checkbox');
    const titleElement = taskElement.querySelector('.task-title');
    const existingAvatar = taskElement.querySelector('.completed-by-avatar');
    
    if (checkbox) {
        checkbox.checked = false;
        checkbox.style.removeProperty('--completed-color');
    }
    if (titleElement) {
        titleElement.style.textDecoration = 'none';
        titleElement.style.color = '#000';
    }
    taskElement.style.background = 'white';
    if (existingAvatar) existingAvatar.remove();
    
    // Update progress
    updateTaskProgress(taskId);
    updateKanbanCardTaskCount();
}

// Update subtask UI as completed (when another user completes it)
function updateSubtaskUIAsCompleted(subtaskId, task) {
    const subtaskElement = document.getElementById(subtaskId);
    if (!subtaskElement) return;
    
    const checkbox = subtaskElement.querySelector('input.subtask-checkbox');
    const textElement = subtaskElement.querySelector('.subtask-text');
    const existingAvatar = subtaskElement.querySelector('.subtask-completed-avatar');
    
    // Get user info from task
    const completedByUser = task.completed_by_user;
    const completedColor = completedByUser && completedByUser.chat_color ? completedByUser.chat_color : '#10b981';
    
    if (checkbox) {
        checkbox.checked = true;
        checkbox.style.setProperty('--completed-color', completedColor);
    }
    if (textElement) {
        textElement.style.textDecoration = 'line-through';
        textElement.style.color = '#9ca3af';
    }
    subtaskElement.style.borderLeftColor = completedColor;
    
    // Add avatar next to checkbox if not already present
    if (!existingAvatar && completedByUser) {
        const avatarHTML = createCompletedAvatar(
            completedByUser.name, 
            completedColor, 
            completedByUser.photo_path, 
            true // isSubtask
        );
        const wrapper = checkbox ? checkbox.closest('.checkbox-avatar-wrapper') : null;
        if (wrapper) {
            wrapper.insertAdjacentHTML('beforeend', avatarHTML);
        } else if (checkbox) {
            checkbox.insertAdjacentHTML('afterend', avatarHTML);
        }
    }
    
    // Update parent task progress
    const parentTaskId = subtaskId.split('-sub-')[0];
    updateTaskProgress(parentTaskId);
    updateKanbanCardTaskCount();
}

// Update subtask UI as not completed (when another user reopens it)
function updateSubtaskUIAsNotCompleted(subtaskId, parentId) {
    const subtaskElement = document.getElementById(subtaskId);
    if (!subtaskElement) return;
    
    const checkbox = subtaskElement.querySelector('input.subtask-checkbox');
    const textElement = subtaskElement.querySelector('.subtask-text');
    const existingAvatar = subtaskElement.querySelector('.subtask-completed-avatar');
    const doneByInfo = subtaskElement.querySelector('.subtask-done-by');
    
    if (checkbox) {
        checkbox.checked = false;
        checkbox.style.removeProperty('--completed-color');
    }
    if (textElement) {
        textElement.style.textDecoration = 'none';
        textElement.style.color = '#374151';
    }
    subtaskElement.style.borderLeftColor = '#e5e7eb';
    if (existingAvatar) existingAvatar.remove();
    if (doneByInfo) doneByInfo.remove();
    
    // Update parent task progress
    const parentTaskId = 'task-' + parentId;
    updateTaskProgress(parentTaskId);
    updateKanbanCardTaskCount();
}

// Stop polling
function stopChatPolling() {
    if (chatPollingInterval) {
        clearInterval(chatPollingInterval);
        chatPollingInterval = null;
        console.log('Chat polling stopped');
    }
}

// Poll for new messages only (not full reload)
function pollNewMessages() {
    if (!currentProjectId) return;
    
    fetch(`{{ url('/projects') }}/${currentProjectId}/comments/poll?last_id=${lastMessageId}`, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.comments && data.comments.length > 0) {
            const chatMessages = document.getElementById('chatMessages');
            const emptyState = document.getElementById('chatEmptyState');
            
            // Hide empty state
            if (emptyState) emptyState.style.display = 'none';
            
            // Add only new messages
            data.comments.forEach(comment => {
                // Check if message already exists
                if (!document.querySelector(`[data-message-id="${comment.id}"]`)) {
                    addMessageToChat(comment, true);
                    if (comment.id > lastMessageId) {
                        lastMessageId = comment.id;
                    }
                }
            });
        }
    })
    .catch(error => console.error('Error polling messages:', error));
}

// Poll typing status
function pollTypingStatus() {
    if (!currentProjectId) return;
    
    fetch(`{{ url('/projects') }}/${currentProjectId}/typing`, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateTypingIndicator(data.typing_users || []);
        }
    })
    .catch(error => {}); // Silently fail for typing status
}

// Update typing indicator UI
function updateTypingIndicator(users) {
    const indicator = document.getElementById('typingIndicator');
    if (!indicator) return;
    
    // Filter out current user
    const currentUserId = {{ auth()->id() }};
    const otherUsers = users.filter(u => u.id !== currentUserId);
    
    if (otherUsers.length === 0) {
        indicator.style.display = 'none';
        return;
    }
    
    indicator.style.display = 'flex';
    const names = otherUsers.map(u => u.name.split(' ')[0]).join(', ');
    const text = otherUsers.length === 1 
        ? `${names} is typing...` 
        : `${names} are typing...`;
    
    indicator.querySelector('.typing-text').textContent = text;
}

// Send typing status
function sendTypingStatus(isTyping) {
    if (!currentProjectId) return;
    
    fetch(`{{ url('/projects') }}/${currentProjectId}/typing`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ is_typing: isTyping })
    }).catch(error => {}); // Silently fail
}

// Handle typing in chat input
function handleChatTyping() {
    if (!isTyping) {
        isTyping = true;
        sendTypingStatus(true);
    }
    
    // Clear existing timeout
    if (typingTimeout) {
        clearTimeout(typingTimeout);
    }
    
    // Stop typing after 2 seconds of inactivity
    typingTimeout = setTimeout(() => {
        isTyping = false;
        sendTypingStatus(false);
    }, 2000);
}

function loadComments(projectId) {
    // Reset last message ID when loading new project
    lastMessageId = 0;
    
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
            const emptyState = document.getElementById('chatEmptyState');
            
            if (data.comments.length > 0) {
                // Hide empty state and clear container
                if (emptyState) emptyState.style.display = 'none';
                chatMessages.innerHTML = '';
                
                // Add typing indicator container
                const typingIndicatorHTML = `
                    <div id="typingIndicator" style="display: none; align-items: center; gap: 8px; padding: 8px 12px; color: #6b7280; font-size: 13px;">
                        <div class="typing-dots" style="display: flex; gap: 3px;">
                            <span style="width: 6px; height: 6px; background: #9ca3af; border-radius: 50%; animation: typingBounce 1.4s infinite ease-in-out both; animation-delay: 0s;"></span>
                            <span style="width: 6px; height: 6px; background: #9ca3af; border-radius: 50%; animation: typingBounce 1.4s infinite ease-in-out both; animation-delay: 0.2s;"></span>
                            <span style="width: 6px; height: 6px; background: #9ca3af; border-radius: 50%; animation: typingBounce 1.4s infinite ease-in-out both; animation-delay: 0.4s;"></span>
                        </div>
                        <span class="typing-text"></span>
                    </div>
                `;
                
                data.comments.forEach(comment => {
                    addMessageToChat(comment);
                    if (comment.id > lastMessageId) {
                        lastMessageId = comment.id;
                    }
                });
                
                // Add typing indicator at the end
                chatMessages.insertAdjacentHTML('beforeend', typingIndicatorHTML);
                
                // Scroll to bottom
                chatMessages.scrollTop = chatMessages.scrollHeight;
            } else {
                // Show empty state
                if (emptyState) emptyState.style.display = 'block';
            }
            
            // Start polling for new messages
            startChatPolling();
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
                // Add typing indicator
                const typingIndicatorHTML = `
                    <div id="typingIndicator" style="display: none; align-items: center; gap: 8px; padding: 8px 12px; color: #6b7280; font-size: 13px;">
                        <div class="typing-dots" style="display: flex; gap: 3px;">
                            <span style="width: 6px; height: 6px; background: #9ca3af; border-radius: 50%; animation: typingBounce 1.4s infinite ease-in-out both; animation-delay: 0s;"></span>
                            <span style="width: 6px; height: 6px; background: #9ca3af; border-radius: 50%; animation: typingBounce 1.4s infinite ease-in-out both; animation-delay: 0.2s;"></span>
                            <span style="width: 6px; height: 6px; background: #9ca3af; border-radius: 50%; animation: typingBounce 1.4s infinite ease-in-out both; animation-delay: 0.4s;"></span>
                        </div>
                        <span class="typing-text"></span>
                    </div>
                `;
                chatMessages.insertAdjacentHTML('beforeend', typingIndicatorHTML);
            }
            
            addMessageToChat(data.comment);
            input.value = '';
            
            // Update lastMessageId
            if (data.comment.id > lastMessageId) {
                lastMessageId = data.comment.id;
            }
            
            // Stop typing indicator
            isTyping = false;
            sendTypingStatus(false);
            
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

function addMessageToChat(comment, isNewMessage = false) {
    const chatMessages = document.getElementById('chatMessages');
    const currentUserId = {{ auth()->id() }};
    
    // Hide empty state
    const emptyState = document.getElementById('chatEmptyState');
    if (emptyState) emptyState.style.display = 'none';
    
    // Color mapping - converts hex color to bubble background/text
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
    
    const userName = comment.user ? comment.user.name : 'User';
    const userId = comment.user ? comment.user.id : 0;
    const isSent = userId === currentUserId;
    const messageId = comment.id || 0;
    
    // Use user's assigned chat_color from database
    const userColor = comment.user?.chat_color || '#6366f1';
    const avatarColor = userColor;
    const bubbleColor = colorToBubble[userColor] || { bg: '#e0e7ff', text: '#3730a3' };
    
    // Get initials (2 letters)
    const initials = userName.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2) || 'U';
    
    // Format time
    let timeDisplay = 'Just now';
    let dateDisplay = '';
    if (comment.created_at) {
        const date = new Date(comment.created_at);
        timeDisplay = date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        dateDisplay = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    }
    
    // Check for user photo
    const userPhoto = comment.user?.photo_path || null;
    
    // Create avatar HTML - photo or initials
    let avatarHTML = '';
    if (userPhoto) {
        avatarHTML = `<div style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid ${avatarColor}; overflow: hidden; flex-shrink: 0; background: #f3f4f6;">
            <img src="${userPhoto}" alt="${escapeHtml(userName)}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div style="display: none; width: 100%; height: 100%; background: ${avatarColor}; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 13px;">${initials}</div>
        </div>`;
    } else {
        avatarHTML = `<div style="width: 36px; height: 36px; border-radius: 50%; background: ${avatarColor}; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 13px; flex-shrink: 0;">${initials}</div>`;
    }
    
    // Animation for new messages from others
    const animationStyle = isNewMessage && !isSent ? 'animation: newMessagePop 0.4s ease-out;' : 'animation: slideIn 0.3s ease-out;';
    
    const messageHTML = `
        <div data-message-id="${messageId}" style="display: flex; align-items: flex-end; gap: 10px; max-width: 85%; ${isSent ? 'align-self: flex-end; flex-direction: row-reverse;' : 'align-self: flex-start;'} ${animationStyle}">
            ${avatarHTML}
            <div>
                <div style="font-size: 12px; font-weight: 600; margin-bottom: 4px; color: ${avatarColor};">${escapeHtml(userName)}</div>
                <div style="padding: 12px 16px; border-radius: 18px; ${isSent ? 'border-bottom-right-radius: 4px;' : 'border-bottom-left-radius: 4px;'} background: ${bubbleColor.bg}; color: ${bubbleColor.text};">
                    <p style="margin: 0; font-size: 14px; line-height: 1.5; white-space: pre-wrap;">${parseMarkdown(comment.message)}</p>
                </div>
                <div style="font-size: 11px; color: #9ca3af; margin-top: 4px; text-align: ${isSent ? 'right' : 'left'};">${dateDisplay}, ${timeDisplay}</div>
            </div>
        </div>
    `;
    
    // Insert before typing indicator if it exists
    const typingIndicator = document.getElementById('typingIndicator');
    if (typingIndicator) {
        typingIndicator.insertAdjacentHTML('beforebegin', messageHTML);
    } else {
        chatMessages.insertAdjacentHTML('beforeend', messageHTML);
    }
    
    // Scroll to bottom
    chatMessages.scrollTop = chatMessages.scrollHeight;
    
    // Play notification sound for new messages from others
    if (isNewMessage && !isSent) {
        playNotificationSound();
    }
}

// Play notification sound for new messages
function playNotificationSound() {
    try {
        // Create a simple beep sound using Web Audio API
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        oscillator.frequency.value = 800;
        oscillator.type = 'sine';
        gainNode.gain.value = 0.1;
        
        oscillator.start();
        oscillator.stop(audioContext.currentTime + 0.1);
    } catch (e) {
        // Silently fail if audio not supported
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
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
        case 'underline':
            prefix = suffix = '__';
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

// ========================================
// TRELLO-STYLE INLINE ADD CARD FUNCTIONS
// ========================================

// Toggle inline add card form
function toggleInlineAddCard(stageId) {
    // Close all other inline forms first
    document.querySelectorAll('.inline-add-card-form').forEach(form => {
        form.style.display = 'none';
    });
    document.querySelectorAll('.inline-add-card-trigger').forEach(trigger => {
        trigger.style.display = 'flex';
    });
    
    const form = document.getElementById(`inlineAddCard-${stageId}`);
    const trigger = document.getElementById(`addCardTrigger-${stageId}`);
    const input = document.getElementById(`inlineCardTitle-${stageId}`);
    
    if (form && trigger) {
        form.style.display = 'block';
        trigger.style.display = 'none';
        
        // Scroll the form into view
        setTimeout(() => {
            form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            if (input) {
                input.focus();
                input.value = '';
            }
        }, 50);
    }
}

// Close inline add card form
function closeInlineAddCard(stageId) {
    const form = document.getElementById(`inlineAddCard-${stageId}`);
    const trigger = document.getElementById(`addCardTrigger-${stageId}`);
    const input = document.getElementById(`inlineCardTitle-${stageId}`);
    
    if (form && trigger) {
        form.style.display = 'none';
        trigger.style.display = 'flex';
        if (input) input.value = '';
    }
}

// Handle keyboard events in inline card input
function handleInlineCardKeydown(event, stageId) {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        submitInlineCard(stageId);
    } else if (event.key === 'Escape') {
        closeInlineAddCard(stageId);
    }
}

// Submit inline card (create project)
function submitInlineCard(stageId) {
    const input = document.getElementById(`inlineCardTitle-${stageId}`);
    const title = input ? input.value.trim() : '';
    
    if (!title) {
        input.focus();
        toastr.warning('Please enter a project name');
        return;
    }
    
    // Show loading state
    const addBtn = document.querySelector(`#inlineAddCard-${stageId} .inline-add-btn`);
    const originalText = addBtn.textContent;
    addBtn.textContent = 'Adding...';
    addBtn.disabled = true;
    
    // Create project via AJAX
    fetch('{{ route("projects.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            name: title,
            stage_id: stageId,
            priority: 'medium',
            status: 'active'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            toastr.success('Project created successfully!');
            // Reload page to show new project
            setTimeout(() => {
                window.location.reload();
            }, 500);
        } else {
            toastr.error(data.message || 'Failed to create project');
            addBtn.textContent = originalText;
            addBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('Failed to create project');
        addBtn.textContent = originalText;
        addBtn.disabled = false;
    });
}

// Close inline forms when clicking outside
document.addEventListener('click', function(event) {
    const isInsideForm = event.target.closest('.inline-add-card-form');
    const isAddButton = event.target.closest('.add-card-btn');
    const isTrigger = event.target.closest('.inline-add-card-trigger');
    
    if (!isInsideForm && !isAddButton && !isTrigger) {
        document.querySelectorAll('.inline-add-card-form').forEach(form => {
            const stageId = form.id.replace('inlineAddCard-', '');
            closeInlineAddCard(stageId);
        });
    }
});

// Open Project Modal (for header button with full options)
function openProjectModal(stageId = null) {
    document.getElementById('projectForm').reset();
    if (stageId) {
        document.getElementById('projectStage').value = stageId;
    }
    document.getElementById('projectModal').style.display = 'flex';
    
    // Focus on title input
    setTimeout(() => {
        document.getElementById('projectName').focus();
    }, 100);
}

// Close Project Modal
function closeProjectModal() {
    document.getElementById('projectModal').style.display = 'none';
    document.getElementById('projectForm').reset();
}

// Close View Project Modal
function closeViewProjectModal() {
    document.getElementById('viewProjectModal').style.display = 'none';
    // Stop chat polling when modal is closed
    stopChatPolling();
    // Clear typing status
    if (currentProjectId) {
        sendTypingStatus(false);
    }
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
    // Employees cannot edit project deadline
    if (isEmployee) {
        toastr.warning('You do not have permission to edit project deadline');
        return;
    }
    
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
        
        // Get employee photo or use initials - photo_path comes directly from API
        const photoPath = user.photo_path ? `{{ url('public/storage') }}/${user.photo_path}` : null;
        const initials = user.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        const avatarColors = ['#4F46E5', '#059669', '#DC2626', '#F59E0B', '#8B5CF6', '#EC4899', '#14B8A6', '#F97316'];
        const avatarColor = avatarColors[user.id % avatarColors.length];
        const defaultAvatar = `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=${avatarColor.substring(1)}&color=fff&size=80&bold=true`;
        
        card.innerHTML = `
            <div style="position: absolute; top: 8px; right: 8px;">
                <input type="checkbox" style="width: 20px; height: 20px; cursor: pointer; accent-color: #267bf5;">
            </div>
            <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; margin-bottom: 12px; border: 3px solid #e2e8f0; transition: border-color 0.2s ease; background: ${photoPath ? 'white' : avatarColor}; display: flex; align-items: center; justify-content: center;">
                ${photoPath 
                    ? `<img src="${photoPath}" alt="${user.name}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='${defaultAvatar}';">`
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
    const fallbackColors = ['#4F46E5', '#059669', '#DC2626', '#F59E0B', '#8B5CF6', '#EC4899', '#14B8A6'];
    const currentMembers = membersContainer.querySelectorAll('.avatar-wrapper').length;
    
    // Use member's chat_color if available, otherwise fallback
    const userColor = member.chat_color || fallbackColors[member.id % fallbackColors.length];
    const initials = member.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
    
    // Remove the + button temporarily
    const addButton = membersContainer.querySelector('button');
    if (addButton) {
        addButton.remove();
    }
    
    // Create wrapper for avatar
    const avatarWrapper = document.createElement('div');
    avatarWrapper.className = 'avatar-wrapper';
    avatarWrapper.style.cssText = `position: relative; margin-left: ${currentMembers > 0 ? '-8px' : '0'};`;
    
    // Check for photo
    let photoPath = null;
    if (member.employee && member.employee.photo_path) {
        photoPath = `{{ url('storage') }}/${member.employee.photo_path}`;
    } else if (member.photo_path) {
        photoPath = `{{ url('storage') }}/${member.photo_path}`;
    }
    
    // Add new member avatar with user's unique color as border
    const avatar = document.createElement('div');
    avatar.className = 'avatar';
    avatar.style.cssText = `width: 32px; height: 32px; border-radius: 50%; background: ${photoPath ? '#f3f4f6' : userColor}; display: flex; align-items: center; justify-content: center; color: white; font-size: 11px; font-weight: 600; border: 2px solid ${userColor}; cursor: pointer; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.12); margin-left: 0;`;
    // Don't set data-tooltip here - we use JavaScript tooltip instead to avoid duplicate tooltips
    avatar.dataset.userId = member.id;
    
    // Set avatar content (photo or initials)
    if (photoPath) {
        const img = document.createElement('img');
        img.src = photoPath;
        img.alt = member.name;
        img.style.cssText = 'width: 100%; height: 100%; object-fit: cover;';
        img.onerror = function() {
            avatar.style.background = userColor;
            avatar.innerHTML = initials;
        };
        avatar.appendChild(img);
    } else {
        avatar.textContent = initials;
    }
    
    // Add tooltip and remove button on hover
    avatarWrapper.addEventListener('mouseenter', function(e) {
        // Show tooltip with member name
        showMemberTooltip(e, member.name, avatarWrapper);
        
        // Add remove button
        const removeBtn = document.createElement('div');
        removeBtn.className = 'member-remove-btn';
        removeBtn.style.cssText = 'position: absolute; top: -5px; right: -5px; width: 18px; height: 18px; background: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 2px solid white; z-index: 10;';
        removeBtn.innerHTML = '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
        removeBtn.onclick = (e) => {
            e.stopPropagation();
            removeMember(member.id, avatarWrapper);
        };
        avatarWrapper.appendChild(removeBtn);
    });
    
    avatarWrapper.addEventListener('mouseleave', function() {
        // Hide tooltip
        hideMemberTooltip();
        
        // Remove button
        const removeBtn = avatarWrapper.querySelector('.member-remove-btn');
        if (removeBtn) removeBtn.remove();
    });
    
    avatarWrapper.appendChild(avatar);
    membersContainer.appendChild(avatarWrapper);
    
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
            
            const fallbackColors = ['#4F46E5', '#059669', '#DC2626', '#F59E0B', '#8B5CF6', '#EC4899', '#14B8A6'];
            
            data.members.forEach((member, index) => {
                // Use member's chat_color if available, otherwise fallback to array color
                const userColor = member.chat_color || fallbackColors[member.id % fallbackColors.length];
                const initials = member.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
                
                // Check for photo from employee data - use full URL from server
                let photoPath = null;
                if (member.photo_path) {
                    photoPath = member.photo_path;
                } else if (member.employee && member.employee.photo_path) {
                    photoPath = member.employee.photo_path;
                }
                
                // Create wrapper for avatar
                const avatarWrapper = document.createElement('div');
                avatarWrapper.style.cssText = `position: relative; margin-left: ${index > 0 ? '-8px' : '0'};`;
                
                // Create avatar circle with user's unique color as border
                const avatar = document.createElement('div');
                avatar.className = 'avatar';
                avatar.style.cssText = `width: 32px; height: 32px; border-radius: 50%; background: ${photoPath ? '#f3f4f6' : userColor}; display: flex; align-items: center; justify-content: center; color: white; font-size: 11px; font-weight: 600; border: 2px solid ${userColor}; cursor: pointer; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.12); margin-left: 0;`;
                // Don't set data-tooltip here - we use JavaScript tooltip instead to avoid duplicate tooltips
                avatar.dataset.userId = member.id;
                
                // Set avatar content (photo or initials)
                if (photoPath) {
                    const img = document.createElement('img');
                    img.src = photoPath;
                    img.alt = member.name;
                    img.style.cssText = 'width: 100%; height: 100%; object-fit: cover;';
                    img.onerror = function() {
                        // On error, show initials with user color background
                        avatar.style.background = userColor;
                        avatar.innerHTML = initials;
                    };
                    avatar.appendChild(img);
                } else {
                    avatar.textContent = initials;
                }
                
                // Add tooltip on hover (and remove button only if user has permission)
                avatarWrapper.addEventListener('mouseenter', function(e) {
                    // Show tooltip with member name
                    showMemberTooltip(e, member.name, avatarWrapper);
                    
                    // Add remove button only if user has permission to manage members
                    if (canManageMembers) {
                        const removeBtn = document.createElement('div');
                        removeBtn.className = 'member-remove-btn';
                        removeBtn.style.cssText = 'position: absolute; top: -5px; right: -5px; width: 18px; height: 18px; background: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 2px solid white; z-index: 10;';
                        removeBtn.innerHTML = '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
                        removeBtn.onclick = (e) => {
                            e.stopPropagation();
                            removeMember(member.id, avatarWrapper);
                        };
                        avatarWrapper.appendChild(removeBtn);
                    }
                });
                
                avatarWrapper.addEventListener('mouseleave', function() {
                    // Hide tooltip
                    hideMemberTooltip();
                    
                    // Remove button if exists
                    const removeBtn = avatarWrapper.querySelector('.member-remove-btn');
                    if (removeBtn) removeBtn.remove();
                });
                
                avatarWrapper.appendChild(avatar);
                membersContainer.appendChild(avatarWrapper);
            });
            
            // Add + button only if user has permission to manage members
            if (canManageMembers) {
                const addButton = document.createElement('button');
                addButton.onclick = openAddMemberModal;
                addButton.style.cssText = 'width: 32px; height: 32px; border-radius: 50%; background: #f3f4f6; display: flex; align-items: center; justify-content: center; border: 2px dashed #d1d5db; cursor: pointer; margin-left: 6px; transition: all 0.2s;';
                addButton.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>';
                
                // Add tooltip for add button
                addButton.addEventListener('mouseenter', function(e) {
                    showMemberTooltip(e, 'Add Member', addButton);
                });
                addButton.addEventListener('mouseleave', hideMemberTooltip);
                
                membersContainer.appendChild(addButton);
            }
            
            // If no members and no permission to add, show a message
            if (data.members.length === 0 && !canManageMembers) {
                const noMembersText = document.createElement('span');
                noMembersText.style.cssText = 'color: #9ca3af; font-size: 12px; font-style: italic;';
                noMembersText.textContent = 'No members assigned';
                membersContainer.appendChild(noMembersText);
            }
        }
    })
    .catch(error => {
        console.error('Error loading members:', error);
    });
}

// Tooltip functions for member avatars
function showMemberTooltip(event, text, element) {
    // Remove any existing tooltip
    hideMemberTooltip();
    
    // Create tooltip container - position absolute relative to the avatar wrapper
    const tooltipContainer = document.createElement('div');
    tooltipContainer.id = 'member-tooltip';
    tooltipContainer.style.cssText = `
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        margin-bottom: 8px;
        z-index: 999999;
        pointer-events: none;
    `;
    
    // Create tooltip text element
    const tooltip = document.createElement('div');
    tooltip.textContent = text;
    tooltip.style.cssText = `
        padding: 6px 12px;
        background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        color: white;
        font-size: 11px;
        font-weight: 500;
        white-space: nowrap;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        max-width: 200px;
        text-overflow: ellipsis;
        overflow: hidden;
    `;
    
    // Create arrow element
    const arrow = document.createElement('div');
    arrow.style.cssText = `
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #374151;
        margin: 0 auto;
    `;
    
    tooltipContainer.appendChild(tooltip);
    tooltipContainer.appendChild(arrow);
    
    // Append tooltip to the element itself (avatar wrapper) for correct positioning
    element.style.position = 'relative';
    element.appendChild(tooltipContainer);
}

function hideMemberTooltip() {
    const tooltips = document.querySelectorAll('#member-tooltip');
    tooltips.forEach(tooltip => tooltip.remove());
}

// Project Filter Functions
function applyProjectFilters() {
    const stageFilter = document.getElementById('filterStage').value;
    const statusFilter = document.getElementById('filterStatus').value;
    const priorityFilter = document.getElementById('filterPriority').value;
    const companyFilter = document.getElementById('filterCompany').value;
    const searchQuery = document.getElementById('projectSearch').value.toLowerCase();
    
    // Filter Kanban Cards
    const kanbanCards = document.querySelectorAll('.kanban-card');
    kanbanCards.forEach(card => {
        const projectId = card.dataset.projectId;
        const projectData = getProjectData(projectId);
        
        if (!projectData) {
            card.style.display = '';
            return;
        }
        
        let show = true;
        
        // Stage filter (for kanban, cards are already in their stage columns)
        if (stageFilter && projectData.stage_id != stageFilter) {
            show = false;
        }
        
        // Status filter
        if (statusFilter && projectData.status !== statusFilter) {
            show = false;
        }
        
        // Priority filter
        if (priorityFilter && projectData.priority !== priorityFilter) {
            show = false;
        }
        
        // Company filter
        if (companyFilter && projectData.company_id != companyFilter) {
            show = false;
        }
        
        // Search filter
        if (searchQuery) {
            const name = (projectData.name || '').toLowerCase();
            const description = (projectData.description || '').toLowerCase();
            const companyName = (projectData.company_name || '').toLowerCase();
            if (!name.includes(searchQuery) && !description.includes(searchQuery) && !companyName.includes(searchQuery)) {
                show = false;
            }
        }
        
        card.style.display = show ? '' : 'none';
    });
    
    // Filter Grid Cards
    const gridCards = document.querySelectorAll('.project-grid-card');
    gridCards.forEach(card => {
        const projectId = card.getAttribute('onclick')?.match(/viewProject\((\d+)/)?.[1];
        const projectData = getProjectData(projectId);
        
        if (!projectData) {
            card.style.display = '';
            return;
        }
        
        let show = true;
        
        if (stageFilter && projectData.stage_id != stageFilter) show = false;
        if (statusFilter && projectData.status !== statusFilter) show = false;
        if (priorityFilter && projectData.priority !== priorityFilter) show = false;
        if (companyFilter && projectData.company_id != companyFilter) show = false;
        
        if (searchQuery) {
            const name = (projectData.name || '').toLowerCase();
            const description = (projectData.description || '').toLowerCase();
            const companyName = (projectData.company_name || '').toLowerCase();
            if (!name.includes(searchQuery) && !description.includes(searchQuery) && !companyName.includes(searchQuery)) {
                show = false;
            }
        }
        
        card.style.display = show ? '' : 'none';
    });
    
    // Filter List View Rows
    const listRows = document.querySelectorAll('.projects-list-view tbody tr');
    listRows.forEach(row => {
        const projectId = row.dataset.projectId;
        const projectData = getProjectData(projectId);
        
        if (!projectData) {
            row.style.display = '';
            return;
        }
        
        let show = true;
        
        if (stageFilter && projectData.stage_id != stageFilter) show = false;
        if (statusFilter && projectData.status !== statusFilter) show = false;
        if (priorityFilter && projectData.priority !== priorityFilter) show = false;
        if (companyFilter && projectData.company_id != companyFilter) show = false;
        
        if (searchQuery) {
            const name = (projectData.name || '').toLowerCase();
            const description = (projectData.description || '').toLowerCase();
            const companyName = (projectData.company_name || '').toLowerCase();
            if (!name.includes(searchQuery) && !description.includes(searchQuery) && !companyName.includes(searchQuery)) {
                show = false;
            }
        }
        
        row.style.display = show ? '' : 'none';
    });
    
    // Show/hide kanban columns based on stage filter
    const kanbanColumns = document.querySelectorAll('.kanban-column');
    kanbanColumns.forEach(column => {
        const columnStageId = column.dataset.stageId;
        if (stageFilter) {
            column.style.display = columnStageId == stageFilter ? '' : 'none';
        } else {
            column.style.display = '';
        }
    });
}

function resetProjectFilters() {
    document.getElementById('filterStage').value = '';
    document.getElementById('filterStatus').value = '';
    document.getElementById('filterPriority').value = '';
    document.getElementById('filterCompany').value = '';
    document.getElementById('projectSearch').value = '';
    applyProjectFilters();
}

// Store project data for filtering
const projectsData = {
    @foreach($projects as $project)
    '{{ $project->id }}': {
        id: {{ $project->id }},
        name: @json($project->name),
        description: @json($project->description ?? ''),
        stage_id: {{ $project->stage_id ?? 'null' }},
        status: @json($project->status ?? 'active'),
        priority: @json($project->priority ?? 'medium'),
        company_id: {{ $project->company_id ?? 'null' }},
        company_name: @json($project->company->company_name ?? '')
    },
    @endforeach
};

function getProjectData(projectId) {
    return projectsData[projectId] || null;
}

// Table Sorting Functions
let currentSort = { column: null, direction: 'asc' };

function initTableSorting() {
    const table = document.getElementById('projectListTable');
    if (!table) return;
    
    const headers = table.querySelectorAll('th.sortable');
    
    headers.forEach(header => {
        header.addEventListener('click', function() {
            const sortKey = this.dataset.sort;
            const sortType = this.dataset.type;
            
            // Toggle direction
            if (currentSort.column === sortKey) {
                currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
            } else {
                currentSort.column = sortKey;
                currentSort.direction = 'asc';
            }
            
            // Update header classes
            headers.forEach(h => h.classList.remove('asc', 'desc'));
            this.classList.add(currentSort.direction);
            
            // Sort the table
            sortTable(table, sortKey, sortType, currentSort.direction);
        });
    });
}

function sortTable(table, sortKey, sortType, direction) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr[data-project-id]'));
    
    const priorityOrder = { 'high': 3, 'medium': 2, 'low': 1 };
    
    rows.sort((a, b) => {
        let aVal = a.dataset[sortKey] || '';
        let bVal = b.dataset[sortKey] || '';
        
        let comparison = 0;
        
        switch(sortType) {
            case 'number':
                aVal = parseFloat(aVal) || 0;
                bVal = parseFloat(bVal) || 0;
                comparison = aVal - bVal;
                break;
            case 'date':
                aVal = aVal || '9999-12-31';
                bVal = bVal || '9999-12-31';
                comparison = aVal.localeCompare(bVal);
                break;
            case 'priority':
                aVal = priorityOrder[aVal] || 0;
                bVal = priorityOrder[bVal] || 0;
                comparison = aVal - bVal;
                break;
            default: // string
                comparison = aVal.localeCompare(bVal);
        }
        
        return direction === 'asc' ? comparison : -comparison;
    });
    
    // Re-append rows in sorted order
    rows.forEach((row, index) => {
        tbody.appendChild(row);
        // Update Sr.No.
        const srnoCell = row.querySelector('.srno-cell');
        if (srnoCell) {
            srnoCell.textContent = index + 1;
        }
    });
}

// Initialize sorting on page load
document.addEventListener('DOMContentLoaded', function() {
    initTableSorting();
});
</script>
@endpush

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Projects</span>
@endsection

@endsection




















