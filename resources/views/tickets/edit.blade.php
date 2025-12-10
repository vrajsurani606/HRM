@extends('layouts.macos')

@section('page_title', 'Edit Ticket - #' . ($ticket->ticket_no ?? $ticket->id))

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const saveBtn = document.querySelector('.btn-save');
    
    form.addEventListener('submit', function(e) {
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite;"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Saving...';
    });
});
</script>
<style>
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
@endpush

@push('styles')
<style>
    .edit-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 24px;
    }
    
    .edit-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .edit-title h1 {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .edit-title h1 svg {
        color: #3b82f6;
    }
    
    .edit-subtitle {
        font-size: 14px;
        color: #64748b;
    }
    
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .btn-back:hover {
        background: #e2e8f0;
        color: #1e293b;
    }
    
    .edit-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .card-header {
        padding: 20px 24px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }
    
    .card-header h2 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .card-body {
        padding: 24px;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .form-group.full-width {
        grid-column: span 2;
    }
    
    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .form-label .required {
        color: #ef4444;
    }
    
    .form-input,
    .form-select,
    .form-textarea {
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        color: #1e293b;
        background: #f8fafc;
        transition: all 0.2s;
        width: 100%;
    }
    
    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #3b82f6;
        background: white;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
    
    .form-textarea {
        min-height: 150px;
        resize: vertical;
    }
    
    .form-select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 18px;
        padding-right: 44px;
    }
    
    .status-options {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 8px;
    }
    
    .status-option {
        position: relative;
    }
    
    .status-option input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .status-option label {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 12px 8px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 11px;
        font-weight: 600;
        text-align: center;
    }
    
    .status-option input:checked + label {
        border-color: #3b82f6;
        background: #eff6ff;
    }
    
    .status-option label .icon {
        font-size: 20px;
        margin-bottom: 4px;
    }
    
    .priority-options {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
    }
    
    .priority-option {
        position: relative;
    }
    
    .priority-option input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .priority-option label {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 12px 8px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 12px;
        font-weight: 600;
    }
    
    .priority-option.low label { border-color: #d1fae5; background: #f0fdf4; }
    .priority-option.medium label { border-color: #dbeafe; background: #eff6ff; }
    .priority-option.high label { border-color: #fed7aa; background: #fff7ed; }
    .priority-option.urgent label { border-color: #fecaca; background: #fef2f2; }
    
    .priority-option input:checked + label {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .priority-option.low input:checked + label { border-color: #10b981; background: #d1fae5; }
    .priority-option.medium input:checked + label { border-color: #3b82f6; background: #dbeafe; }
    .priority-option.high input:checked + label { border-color: #f97316; background: #fed7aa; }
    .priority-option.urgent input:checked + label { border-color: #ef4444; background: #fecaca; }
    
    .card-footer {
        padding: 20px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }
    
    .btn-cancel {
        padding: 12px 24px;
        background: white;
        color: #64748b;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-cancel:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }
    
    .btn-save {
        padding: 12px 32px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }
    
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-group.full-width {
            grid-column: span 1;
        }
        .status-options {
            grid-template-columns: repeat(3, 1fr);
        }
        .priority-options {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endpush

@section('content')
<div class="edit-container">
    @if(session('success'))
    <div style="background: #d1fae5; border: 2px solid #10b981; color: #065f46; padding: 16px 20px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span style="font-weight: 600;">{{ session('success') }}</span>
    </div>
    @endif
    
    @if($errors->any())
    <div style="background: #fee2e2; border: 2px solid #ef4444; color: #991b1b; padding: 16px 20px; border-radius: 12px; margin-bottom: 20px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span style="font-weight: 600;">Please fix the following errors:</span>
        </div>
        <ul style="margin: 0; padding-left: 32px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <div class="edit-header">
        <div class="edit-title">
            <h1>
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit Ticket
            </h1>
            <div class="edit-subtitle">Ticket #{{ $ticket->ticket_no ?? $ticket->id }} • {{ $ticket->title ?? $ticket->subject }}</div>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('tickets.index') }}" class="btn-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                All Tickets
            </a>
            <a href="{{ route('tickets.show', $ticket) }}" class="btn-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                View Ticket
            </a>
        </div>
    </div>
    
    <div class="edit-card">
        <div class="card-header">
            <h2>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
                Ticket Information
            </h2>
        </div>
        
        <form action="{{ route('tickets.update', $ticket) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label class="form-label">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7V4h16v3M9 20h6M12 4v16"/></svg>
                            Title <span class="required">*</span>
                        </label>
                        <input type="text" name="title" class="form-input" value="{{ old('title', $ticket->title ?? $ticket->subject) }}" required placeholder="Enter ticket title">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Customer
                        </label>
                        <input type="text" name="customer" class="form-input" value="{{ old('customer', $ticket->customer) }}" placeholder="Customer name">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            Company
                        </label>
                        <input type="text" name="company" class="form-input" value="{{ old('company', $ticket->company) }}" placeholder="Company name">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                            Category
                        </label>
                        <select name="ticket_type" class="form-select">
                            <option value="">Select a category</option>
                            <option value="Technical Support" {{ old('ticket_type', $ticket->ticket_type) == 'Technical Support' ? 'selected' : '' }}>Technical Support</option>
                            <option value="Billing" {{ old('ticket_type', $ticket->ticket_type) == 'Billing' ? 'selected' : '' }}>Billing</option>
                            <option value="Feature Request" {{ old('ticket_type', $ticket->ticket_type) == 'Feature Request' ? 'selected' : '' }}>Feature Request</option>
                            <option value="Bug Report" {{ old('ticket_type', $ticket->ticket_type) == 'Bug Report' ? 'selected' : '' }}>Bug Report</option>
                            <option value="General Inquiry" {{ old('ticket_type', $ticket->ticket_type) == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                            <option value="AMC Renewal" {{ old('ticket_type', $ticket->ticket_type) == 'AMC Renewal' ? 'selected' : '' }}>AMC Renewal</option>
                            <option value="Other" {{ old('ticket_type', $ticket->ticket_type) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    
                    @if(auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr'))
                    <div class="form-group">
                        <label class="form-label">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Assign to Employee
                        </label>
                        <select name="assigned_to" class="form-select">
                            <option value="">Not Assigned</option>
                            @foreach(\App\Models\Employee::orderBy('name')->get() as $emp)
                                <option value="{{ $emp->id }}" {{ old('assigned_to', $ticket->assigned_to) == $emp->id ? 'selected' : '' }}>
                                    {{ $emp->name }} - {{ $emp->position ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    
                    @if(auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr'))
                    <div class="form-group full-width">
                        <label class="form-label">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            Ticket Status
                        </label>
                        <div class="status-options">
                            <div class="status-option">
                                <input type="radio" name="status" id="status_open" value="open" {{ old('status', $ticket->status) == 'open' ? 'checked' : '' }}>
                                <label for="status_open"><span class="icon">🔓</span>Open</label>
                            </div>
                            <div class="status-option">
                                <input type="radio" name="status" id="status_assigned" value="assigned" {{ old('status', $ticket->status) == 'assigned' ? 'checked' : '' }}>
                                <label for="status_assigned"><span class="icon">👤</span>Assigned</label>
                            </div>
                            <div class="status-option">
                                <input type="radio" name="status" id="status_progress" value="in_progress" {{ old('status', $ticket->status) == 'in_progress' ? 'checked' : '' }}>
                                <label for="status_progress"><span class="icon">🔄</span>In Progress</label>
                            </div>
                            <div class="status-option">
                                <input type="radio" name="status" id="status_completed" value="completed" {{ old('status', $ticket->status) == 'completed' ? 'checked' : '' }}>
                                <label for="status_completed"><span class="icon">✓</span>Completed</label>
                            </div>
                            <div class="status-option">
                                <input type="radio" name="status" id="status_resolved" value="resolved" {{ old('status', $ticket->status) == 'resolved' ? 'checked' : '' }}>
                                <label for="status_resolved"><span class="icon">✅</span>Resolved</label>
                            </div>
                            <div class="status-option">
                                <input type="radio" name="status" id="status_closed" value="closed" {{ old('status', $ticket->status) == 'closed' ? 'checked' : '' }}>
                                <label for="status_closed"><span class="icon">🔒</span>Closed</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group full-width">
                        <label class="form-label">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                            Work Status
                        </label>
                        <div class="priority-options">
                            <div class="priority-option low">
                                <input type="radio" name="work_status" id="work_not_assigned" value="not_assigned" {{ old('work_status', $ticket->work_status) == 'not_assigned' ? 'checked' : '' }}>
                                <label for="work_not_assigned">⚪ Not Assigned</label>
                            </div>
                            <div class="priority-option normal">
                                <input type="radio" name="work_status" id="work_in_progress" value="in_progress" {{ old('work_status', $ticket->work_status) == 'in_progress' ? 'checked' : '' }}>
                                <label for="work_in_progress">🔵 In Progress</label>
                            </div>
                            <div class="priority-option high">
                                <input type="radio" name="work_status" id="work_on_hold" value="on_hold" {{ old('work_status', $ticket->work_status) == 'on_hold' ? 'checked' : '' }}>
                                <label for="work_on_hold">🟡 On Hold</label>
                            </div>
                            <div class="priority-option urgent">
                                <input type="radio" name="work_status" id="work_completed" value="completed" {{ old('work_status', $ticket->work_status) == 'completed' ? 'checked' : '' }}>
                                <label for="work_completed">🟢 Completed</label>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @php
                        // Map "normal" to "medium" for backward compatibility
                        $currentPriority = old('priority', $ticket->priority ?? 'medium');
                        if ($currentPriority === 'normal') $currentPriority = 'medium';
                    @endphp
                    <div class="form-group full-width">
                        <label class="form-label">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            Priority
                        </label>
                        <div class="priority-options">
                            <div class="priority-option low">
                                <input type="radio" name="priority" id="priority_low" value="low" {{ $currentPriority == 'low' ? 'checked' : '' }}>
                                <label for="priority_low">🟢 Low</label>
                            </div>
                            <div class="priority-option medium">
                                <input type="radio" name="priority" id="priority_medium" value="medium" {{ $currentPriority == 'medium' ? 'checked' : '' }}>
                                <label for="priority_medium">🔵 Medium</label>
                            </div>
                            <div class="priority-option high">
                                <input type="radio" name="priority" id="priority_high" value="high" {{ $currentPriority == 'high' ? 'checked' : '' }}>
                                <label for="priority_high">🟠 High</label>
                            </div>
                            <div class="priority-option urgent">
                                <input type="radio" name="priority" id="priority_urgent" value="urgent" {{ $currentPriority == 'urgent' ? 'checked' : '' }}>
                                <label for="priority_urgent">🔴 Urgent</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group full-width">
                        <label class="form-label">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            Description <span class="required">*</span>
                        </label>
                        <textarea name="description" class="form-textarea" required placeholder="Describe the issue in detail...">{{ old('description', $ticket->description) }}</textarea>
                    </div>
                    
                    @if($ticket->attachments && count($ticket->attachments) > 0)
                    <div class="form-group full-width">
                        <label class="form-label">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                            Current Attachments ({{ count($ticket->attachments) }})
                        </label>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; margin-top: 8px;">
                            @foreach($ticket->attachments as $index => $attachment)
                                @php
                                    $extension = pathinfo($attachment, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                    $fileName = basename($attachment);
                                @endphp
                                <div style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; background: white;">
                                    @if($isImage)
                                        <a href="{{ storage_asset($attachment) }}" target="_blank" style="display: block;">
                                            <img src="{{ storage_asset($attachment) }}" alt="Attachment {{ $index + 1 }}" style="width: 100%; height: 100px; object-fit: cover;">
                                        </a>
                                    @else
                                        <div style="height: 100px; display: flex; align-items: center; justify-content: center; background: #f8fafc;">
                                            <span style="font-size: 32px;">📄</span>
                                        </div>
                                    @endif
                                    <div style="padding: 8px; font-size: 11px; color: #64748b; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $fileName }}">
                                        {{ $fileName }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    @if($ticket->resolution_notes || in_array($ticket->status, ['completed', 'resolved', 'closed']))
                    <div class="form-group full-width">
                        <label class="form-label">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                            Resolution Notes
                        </label>
                        <textarea name="resolution_notes" class="form-textarea" style="min-height: 100px;" placeholder="How was this issue resolved?">{{ old('resolution_notes', $ticket->resolution_notes) }}</textarea>
                        @if($ticket->completed_at)
                        <small style="color: #64748b; font-size: 12px; margin-top: 4px; display: block;">
                            Completed by {{ $ticket->completedBy->name ?? 'Unknown' }} on {{ $ticket->completed_at->format('M d, Y h:i A') }}
                        </small>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="card-footer">
                <a href="{{ route('tickets.show', $ticket) }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-save">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('tickets.index') }}">Tickets</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('tickets.show', $ticket) }}">Ticket #{{ $ticket->ticket_no ?? $ticket->id }}</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">Edit</span>
@endsection
