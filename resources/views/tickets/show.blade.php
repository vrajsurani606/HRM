@extends('layouts.macos')

@section('page_title', 'Ticket Details - #' . ($ticket->ticket_no ?? $ticket->id))

@push('styles')
<style>
    .ticket-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 24px;
    }
    
    .ticket-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .ticket-title-section h1 {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px 0;
    }
    
    .ticket-id {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }
    
    .ticket-actions {
        display: flex;
        gap: 12px;
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
    
    .btn-edit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: #3b82f6;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .btn-edit:hover {
        background: #2563eb;
        color: white;
    }
    
    .ticket-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .ticket-status-bar {
        padding: 16px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }
    
    .status-bar-open { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); }
    .status-bar-pending { background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%); }
    .status-bar-in_progress { background: linear-gradient(135deg, #dbeafe 0%, #93c5fd 100%); }
    .status-bar-resolved { background: linear-gradient(135deg, #d1fae5 0%, #6ee7b7 100%); }
    .status-bar-closed { background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-open { background: #fbbf24; color: #78350f; }
    .status-pending { background: #f97316; color: white; }
    .status-in_progress { background: #3b82f6; color: white; }
    .status-resolved { background: #10b981; color: white; }
    .status-closed { background: #6b7280; color: white; }
    
    .priority-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    
    .priority-low { background: #d1fae5; color: #065f46; }
    .priority-normal { background: #dbeafe; color: #1e40af; }
    .priority-high { background: #fed7aa; color: #9a3412; }
    .priority-urgent { background: #fee2e2; color: #991b1b; }
    
    .ticket-body {
        padding: 24px;
    }
    
    .ticket-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
        padding-bottom: 24px;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    
    .meta-label {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .meta-value {
        font-size: 15px;
        color: #1e293b;
        font-weight: 500;
    }
    
    .ticket-description {
        margin-bottom: 24px;
    }
    
    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .description-content {
        background: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        font-size: 14px;
        line-height: 1.7;
        color: #475569;
        white-space: pre-wrap;
    }
    
    .ticket-footer {
        padding: 20px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }
    
    .footer-info {
        font-size: 13px;
        color: #64748b;
    }
    
    .footer-info strong {
        color: #475569;
    }
</style>
@endpush

@section('content')
<div class="ticket-container">
    <div class="ticket-header">
        <div class="ticket-title-section">
            <h1>{{ $ticket->title ?? $ticket->subject ?? 'Ticket Details' }}</h1>
            <div class="ticket-id">Ticket #{{ $ticket->ticket_no ?? $ticket->id }} • Created {{ $ticket->created_at ? $ticket->created_at->format('M d, Y \a\t h:i A') : 'N/A' }}</div>
        </div>
        <div class="ticket-actions">
            <a href="{{ route('tickets.index') }}" class="btn-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Back to List
            </a>
            <a href="{{ route('tickets.edit', $ticket) }}" class="btn-edit">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit Ticket
            </a>
        </div>
    </div>
    
    <div class="ticket-card">
        <div class="ticket-status-bar status-bar-{{ $ticket->status ?? 'open' }}">
            <div>
                <span class="status-badge status-{{ $ticket->status ?? 'open' }}">
                    @if(($ticket->status ?? 'open') === 'open')
                        🔓 Open
                    @elseif($ticket->status === 'pending')
                        ⏳ Pending
                    @elseif($ticket->status === 'in_progress')
                        🔄 In Progress
                    @elseif($ticket->status === 'resolved')
                        ✅ Resolved
                    @elseif($ticket->status === 'closed')
                        🔒 Closed
                    @else
                        {{ ucfirst($ticket->status ?? 'Open') }}
                    @endif
                </span>
            </div>
            <div>
                <span class="priority-badge priority-{{ $ticket->priority ?? 'normal' }}">
                    @if(($ticket->priority ?? 'normal') === 'low')
                        🟢 Low Priority
                    @elseif($ticket->priority === 'normal')
                        🔵 Normal Priority
                    @elseif($ticket->priority === 'high')
                        🟠 High Priority
                    @elseif($ticket->priority === 'urgent')
                        🔴 Urgent Priority
                    @else
                        {{ ucfirst($ticket->priority ?? 'Normal') }} Priority
                    @endif
                </span>
            </div>
        </div>
        
        <div class="ticket-body">
            <div class="ticket-meta">
                <div class="meta-item">
                    <span class="meta-label">Customer</span>
                    <span class="meta-value">{{ $ticket->customer ?? '—' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Company</span>
                    <span class="meta-value">{{ $ticket->company ?? '—' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Category</span>
                    <span class="meta-value">{{ $ticket->ticket_type ?? $ticket->category ?? 'General' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Assigned To</span>
                    <span class="meta-value">{{ $ticket->assignedEmployee->name ?? 'Not Assigned' }}</span>
                </div>
            </div>
            
            <div class="ticket-description">
                <div class="section-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Description
                </div>
                <div class="description-content">{{ $ticket->description ?? 'No description provided.' }}</div>
            </div>
        </div>
        
        <div class="ticket-footer">
            <div class="footer-info">
                <strong>Created:</strong> {{ $ticket->created_at ? $ticket->created_at->format('M d, Y h:i A') : 'N/A' }}
            </div>
            <div class="footer-info">
                <strong>Last Updated:</strong> {{ $ticket->updated_at ? $ticket->updated_at->format('M d, Y h:i A') : 'N/A' }}
            </div>
        </div>
    </div>
</div>
@endsection
