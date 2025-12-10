@extends('layouts.macos')

@section('page_title', 'Ticket #' . ($ticket->ticket_no ?? $ticket->id))

@push('styles')
<style>
    * { box-sizing: border-box; }
    
    /* Hide menu toggle button on ticket page */
    .hrp-menu-toggle {
        display: none !important;
    }
    
    .ticket-wrapper {
     
        padding: 20px;
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 20px;
    }
    
    @media (max-width: 1024px) {
        .ticket-wrapper {
            grid-template-columns: 1fr;
        }
    }
    
    .ticket-main {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .ticket-header {
        padding: 24px;
        border-bottom: 1px solid #e5e7eb;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }
    
    .ticket-header-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 12px;
    }
    
    .ticket-title {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 8px 0;
        line-height: 1.3;
    }
    
    .ticket-id {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
    }
    
    .ticket-badges {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .badge-open { background: #fef3c7; color: #92400e; }
    .badge-needs_approval { background: #fed7aa; color: #9a3412; }
    .badge-in_progress { background: #dbeafe; color: #1e40af; }
    .badge-resolved { background: #d1fae5; color: #065f46; }
    .badge-closed { background: #e2e8f0; color: #475569; }
    
    .badge-low { background: #d1fae5; color: #065f46; }
    .badge-normal { background: #dbeafe; color: #1e40af; }
    .badge-high { background: #fed7aa; color: #9a3412; }
    .badge-urgent { background: #fee2e2; color: #991b1b; }
    
    .ticket-actions-header {
        display: flex;
        gap: 8px;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-secondary {
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    
    .btn-secondary:hover {
        background: #f8fafc;
        color: #0f172a;
    }
    
    .btn-primary {
        background: #3b82f6;
        color: white;
    }
    
    .btn-primary:hover {
        background: #2563eb;
        color: white;
    }
    
    .ticket-description {
        padding: 24px;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .section-title {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .description-text {
        background: #f8fafc;
        border-radius: 8px;
        padding: 16px;
        font-size: 14px;
        line-height: 1.7;
        color: #475569;
        white-space: pre-wrap;
        word-wrap: break-word;
    }
    
    .comments-section {
        padding: 24px;
    }
    
    .comments-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 24px;
        max-height: 500px;
        overflow-y: auto;
    }
    
    .comment {
        display: flex;
        gap: 12px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
    }
    
    .comment-internal {
        background: #fafafa;
        border: 1px solid #e0e0e0;
        border-left: 3px solid #9e9e9e;
    }
    
    .comment-internal .comment-avatar {
        background: linear-gradient(135deg, #757575, #616161);
    }
    
    .comment-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
    }
    
    .comment-content {
        flex: 1;
    }
    
    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }
    
    .comment-author {
        font-weight: 600;
        color: #0f172a;
        font-size: 14px;
    }
    
    .comment-time {
        font-size: 12px;
        color: #64748b;
    }
    
    .comment-text {
        font-size: 14px;
        line-height: 1.6;
        color: #475569;
        white-space: pre-wrap;
        word-wrap: break-word;
    }
    
    .comment-form {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 16px;
    }
    
    .form-group {
        margin-bottom: 12px;
    }
    
    .form-textarea {
        width: 100%;
        min-height: 100px;
        padding: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        resize: vertical;
        transition: all 0.2s;
    }
    
    .form-textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .form-checkbox {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #475569;
        margin-bottom: 12px;
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-end;
    }
    
    .ticket-sidebar {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        padding: 20px;
        height: fit-content;
        position: sticky;
        top: 20px;
    }
    
    .sidebar-section {
        margin-bottom: 24px;
        padding-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .sidebar-section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .sidebar-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    
    .sidebar-value {
        font-size: 14px;
        color: #0f172a;
        font-weight: 500;
    }
    
    .empty-comments {
        text-align: center;
        padding: 40px 20px;
        color: #94a3b8;
    }
    
    .empty-comments svg {
        width: 48px;
        height: 48px;
        margin-bottom: 12px;
        opacity: 0.5;
    }
    
    .internal-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 8px;
        background: #f5f5f5;
        color: #757575;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
@endpush

@section('content')
<div class="ticket-wrapper">
    <!-- Main Content -->
    <div class="ticket-main">
        <!-- Header -->
        <div class="ticket-header">
            <div class="ticket-header-top">
                <div>
                    <h1 class="ticket-title">{{ $ticket->title ?? $ticket->subject ?? 'Ticket Details' }}</h1>
                    <div class="ticket-id">Ticket #{{ $ticket->ticket_no ?? $ticket->id }} • Created {{ $ticket->created_at ? $ticket->created_at->format('M d, Y \a\t h:i A') : 'N/A' }}</div>
                </div>
                <div class="ticket-actions-header">
                    <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                        Back
                    </a>
                    @if($isAdmin || auth()->user()->hasRole('customer'))
                    <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-primary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </a>
                    @endif
                    @if(auth()->user()->hasRole('customer') && $ticket->status === 'resolved')
                    <button onclick="closeTicket({{ $ticket->id }})" class="btn" style="background: #10b981; color: white;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 6L9 17l-5-5"/>
                        </svg>
                        Close Ticket
                    </button>
                    @endif
                </div>
            </div>
            <div class="ticket-badges">
                <span class="badge badge-{{ $ticket->status ?? 'open' }}">
                    {{ str_replace('_', ' ', ucfirst($ticket->status ?? 'open')) }}
                </span>
                @if($ticket->priority)
                <span class="badge badge-{{ $ticket->priority }}">
                    {{ ucfirst($ticket->priority) }} Priority
                </span>
                @endif
            </div>
        </div>
        
        <!-- Description -->
        <div class="ticket-description">
            <div class="section-title">Description</div>
            <div class="description-text">{{ $ticket->description ?? 'No description provided.' }}</div>
            
            @if($ticket->attachment)
            <div style="margin-top: 20px; padding: 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px; color: #64748b; font-size: 13px; font-weight: 600;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/>
                    </svg>
                    <span>Ticket Attachment</span>
                </div>
                @php
                    $extension = pathinfo($ticket->attachment, PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    $isPdf = strtolower($extension) === 'pdf';
                @endphp
                
                @if($isImage)
                    <div style="margin-top: 12px;">
                        <a href="{{ storage_asset($ticket->attachment) }}" target="_blank" style="display: inline-block;">
                            <img src="{{ storage_asset($ticket->attachment) }}" alt="Ticket Attachment" style="max-width: 100%; max-height: 400px; border-radius: 8px; border: 2px solid #e5e7eb; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                        </a>
                    </div>
                @elseif($isPdf)
                    <div style="margin-top: 12px;">
                        <embed src="{{ storage_asset($ticket->attachment) }}" type="application/pdf" style="width: 100%; height: 500px; border-radius: 8px; border: 2px solid #e5e7eb;">
                    </div>
                @else
                    <div style="margin-top: 12px;">
                        <a href="{{ storage_asset($ticket->attachment) }}" download style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; background: white; border: 1px solid #e5e7eb; border-radius: 8px; color: #3b82f6; text-decoration: none; font-weight: 500; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'; this.style.borderColor='#3b82f6'" onmouseout="this.style.background='white'; this.style.borderColor='#e5e7eb'">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="7 10 12 15 17 10"/>
                                <line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                            <span>Download {{ basename($ticket->attachment) }}</span>
                        </a>
                    </div>
                @endif
            </div>
            @endif
        </div>
        
        <!-- Comments Section -->
        <div class="comments-section">
            @if($isAdmin)
            <!-- Tab Navigation (Admin Only) -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #e5e7eb;">
                <div style="display: flex; gap: 8px;">
                    <button class="tab-btn active" data-tab="external" style="padding: 12px 20px; border: none; background: none; font-weight: 600; color: #64748b; cursor: pointer; border-bottom: 3px solid transparent; transition: all 0.2s;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 6px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Customer Chat
                    </button>
                    <button class="tab-btn" data-tab="internal" style="padding: 12px 20px; border: none; background: none; font-weight: 600; color: #64748b; cursor: pointer; border-bottom: 3px solid transparent; transition: all 0.2s;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: middle; margin-right: 6px;"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
                        Internal Notes
                    </button>
                </div>
                <button onclick="location.reload()" style="padding: 8px 16px; border: 1px solid #e5e7eb; background: white; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 600; color: #64748b; display: flex; align-items: center; gap: 6px; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'" title="Refresh to see new messages">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/>
                    </svg>
                    Refresh
                </button>
            </div>
            @elseif($isEmployee)
            <!-- Employee: Internal Notes Only -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <div class="section-title" style="margin: 0;">Internal Notes</div>
                <button onclick="location.reload()" style="padding: 8px 16px; border: 1px solid #e5e7eb; background: white; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 600; color: #64748b; display: flex; align-items: center; gap: 6px; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'" title="Refresh to see new messages">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/>
                    </svg>
                    Refresh
                </button>
            </div>
            @else
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <div class="section-title" style="margin: 0;">Comments & Discussion</div>
                <button onclick="location.reload()" style="padding: 8px 16px; border: 1px solid #e5e7eb; background: white; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 600; color: #64748b; display: flex; align-items: center; gap: 6px; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'" title="Refresh to see new messages">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/>
                    </svg>
                    Refresh
                </button>
            </div>
            @endif
            
            <!-- External Comments Tab (Admin Only) -->
            @if($isAdmin)
            <div class="tab-content" id="external-tab">
                <div class="comments-list" id="externalCommentsList">
                    @php
                        $externalComments = $ticket->comments->where('is_internal', false);
                    @endphp
                    @forelse($externalComments as $comment)
                        @include('tickets.partials.comment', ['comment' => $comment, 'isAdmin' => $isAdmin])
                    @empty
                        <div class="empty-comments">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                            </svg>
                            <p>No customer messages yet. Start the conversation!</p>
                        </div>
                    @endforelse
                </div>
                
                <!-- External Comment Form -->
                <div class="comment-form">
                    <form class="comment-form-inner" data-type="external" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <textarea 
                                name="comment" 
                                class="form-textarea" 
                                placeholder="Write a message to the customer..." 
                                required
                            ></textarea>
                        </div>
                        <div class="form-group" style="margin-top: 12px;">
                            <label for="external-attachment" style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 500; color: #64748b; transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/>
                                </svg>
                                Attach File (Image/PDF)
                            </label>
                            <input type="file" id="external-attachment" name="attachment" accept="image/*,.pdf" style="display: none;" onchange="showFileName(this, 'external-file-name')">
                            <div id="external-file-name" style="margin-top: 8px; font-size: 13px; color: #64748b;"></div>
                        </div>
                        <input type="hidden" name="is_internal" value="0">
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                                Send to Customer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
            
            <!-- Internal Comments Tab (Admin & Employee) -->
            @if($isAdmin || $isEmployee)
            <div class="tab-content" id="internal-tab" style="{{ $isEmployee ? '' : 'display: none;' }}">
                <div class="comments-list" id="internalCommentsList">
                    @php
                        $internalComments = $ticket->comments->where('is_internal', true);
                    @endphp
                    
                    {{-- Completion Data Display --}}
                    @if(($ticket->status === 'completed' || $ticket->status === 'resolved') && ($ticket->resolution_notes || $ticket->completion_images))
                    <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 2px solid #10b981; border-radius: 12px; padding: 20px; margin-bottom: 16px; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.1);">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 18px;">
                                ✓
                            </div>
                            <div style="flex: 1;">
                                <div style="font-weight: 700; color: #065f46; font-size: 16px; margin-bottom: 2px;">
                                    Ticket Completed
                                </div>
                                <div style="font-size: 13px; color: #047857;">
                                    @if($ticket->completedBy)
                                        By {{ $ticket->completedBy->name }} • 
                                    @endif
                                    {{ $ticket->completed_at ? $ticket->completed_at->format('M d, Y \a\t h:i A') : 'Recently' }}
                                </div>
                            </div>
                            @if($isAdmin && $ticket->status === 'completed')
                            <button 
                                onclick="editCompletionDataFromShow({{ $ticket->id }})" 
                                style="padding: 8px 16px; background: #f59e0b; color: white; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s;"
                                onmouseover="this.style.background='#d97706'"
                                onmouseout="this.style.background='#f59e0b'"
                                title="Edit completion details"
                            >
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                                Edit
                            </button>
                            @endif
                        </div>
                        
                        @if($ticket->resolution_notes)
                        <div style="margin-bottom: 16px;">
                            <div style="font-weight: 600; color: #065f46; font-size: 13px; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                    <polyline points="10 9 9 9 8 9"/>
                                </svg>
                                Resolution Notes
                            </div>
                            <div style="background: white; border: 1px solid #bbf7d0; border-radius: 8px; padding: 14px; font-size: 14px; color: #1e293b; line-height: 1.6; white-space: pre-wrap; word-wrap: break-word;">{{ $ticket->resolution_notes }}</div>
                        </div>
                        @endif
                        
                        @if($ticket->completion_images && count($ticket->completion_images) > 0)
                        <div>
                            <div style="font-weight: 600; color: #065f46; font-size: 13px; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                                Completion Images ({{ count($ticket->completion_images) }})
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px;">
                                @foreach($ticket->completion_images as $index => $image)
                                <div style="position: relative; border-radius: 10px; overflow: hidden; border: 2px solid #bbf7d0; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" 
                                     onclick="window.open('{{ storage_asset($image) }}', '_blank')" 
                                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(16, 185, 129, 0.2)'"
                                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'"
                                     title="Click to view full size">
                                    <img src="{{ storage_asset($image) }}" style="width: 100%; height: 120px; object-fit: cover; display: block;">
                                    <div style="position: absolute; bottom: 4px; right: 4px; background: rgba(0,0,0,0.7); color: white; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 600;">
                                        #{{ $index + 1 }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div style="margin-top: 8px; font-size: 12px; color: #047857; font-style: italic; text-align: center;">
                                💡 Click any image to view full size in new tab
                            </div>
                        </div>
                        @endif
                        
                        @if($ticket->status === 'resolved' && $ticket->confirmed_at)
                        <div style="margin-top: 16px; padding-top: 16px; border-top: 2px solid #bbf7d0;">
                            <div style="display: flex; align-items: center; gap: 8px; color: #065f46; font-size: 13px; font-weight: 600;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                                Confirmed by Admin on {{ $ticket->confirmed_at->format('M d, Y \a\t h:i A') }}
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                    
                    @forelse($internalComments as $comment)
                        @include('tickets.partials.comment', ['comment' => $comment, 'isAdmin' => $isAdmin])
                    @empty
                        <div class="empty-comments">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                            </svg>
                            <p>No internal notes yet. Add private notes for your team!</p>
                        </div>
                    @endforelse
                </div>
                
                <!-- Internal Comment Form -->
                <div class="comment-form" style="background: #fafafa; border: 1px solid #e0e0e0;">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px; color: #616161; font-size: 13px; font-weight: 600;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        Internal Note (Not visible to customer)
                    </div>
                    <form class="comment-form-inner" data-type="internal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <textarea 
                                name="comment" 
                                class="form-textarea" 
                                placeholder="Write an internal note for your team..." 
                                required
                                style="background: white;"
                            ></textarea>
                        </div>
                        <div class="form-group" style="margin-top: 12px;">
                            <label for="internal-attachment" style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: white; border: 1px solid #e0e0e0; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 500; color: #616161; transition: all 0.2s;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='white'">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/>
                                </svg>
                                Attach File (Image/PDF)
                            </label>
                            <input type="file" id="internal-attachment" name="attachment" accept="image/*,.pdf" style="display: none;" onchange="showFileName(this, 'internal-file-name')">
                            <div id="internal-file-name" style="margin-top: 8px; font-size: 13px; color: #616161;"></div>
                        </div>
                        <input type="hidden" name="is_internal" value="1">
                        <div class="form-actions">
                            <button type="submit" class="btn" style="background: #757575; color: white;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                                Add Internal Note
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
            
            <!-- Customer Comments Section (External Messages Only) -->
            @if(!$isAdmin && !$isEmployee)
            <div class="tab-content" id="customer-comments">
                <div class="comments-list" id="customerCommentsList">
                    @php
                        $customerComments = $ticket->comments->where('is_internal', false);
                    @endphp
                    @forelse($customerComments as $comment)
                        @include('tickets.partials.comment', ['comment' => $comment, 'isAdmin' => false])
                    @empty
                        <div class="empty-comments">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                            </svg>
                            <p>No messages yet. Start the conversation with our support team!</p>
                        </div>
                    @endforelse
                </div>
                
                <!-- Customer Comment Form -->
                <div class="comment-form">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px; padding: 12px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 16v-4M12 8h.01"/>
                        </svg>
                        <span style="font-size: 13px; color: #1e40af; font-weight: 500;">Your messages are visible to our support team</span>
                    </div>
                    <form class="comment-form-inner" data-type="external" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <textarea 
                                name="comment" 
                                class="form-textarea" 
                                placeholder="Write your message to our support team..." 
                                required
                                style="background: white;"
                            ></textarea>
                        </div>
                        <div class="form-group" style="margin-top: 12px;">
                            <label for="customer-attachment" style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 500; color: #64748b; transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/>
                                </svg>
                                Attach File (Image/PDF)
                            </label>
                            <input type="file" id="customer-attachment" name="attachment" accept="image/*,.pdf" style="display: none;" onchange="showFileName(this, 'customer-file-name')">
                            <div id="customer-file-name" style="margin-top: 8px; font-size: 13px; color: #64748b;"></div>
                        </div>
                        <input type="hidden" name="is_internal" value="0">
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="ticket-sidebar">
        <div class="sidebar-section">
            <div class="sidebar-label">Customer</div>
            <div class="sidebar-value">{{ $ticket->customer ?? '—' }}</div>
        </div>
        
        <div class="sidebar-section">
            <div class="sidebar-label">Company</div>
            <div class="sidebar-value">{{ $ticket->company ?? '—' }}</div>
        </div>
        
        <div class="sidebar-section">
            <div class="sidebar-label">Category</div>
            <div class="sidebar-value">{{ $ticket->ticket_type ?? $ticket->category ?? 'General' }}</div>
        </div>
        
        @if(!auth()->user()->hasRole('customer'))
        <div class="sidebar-section">
            <div class="sidebar-label">Assigned To</div>
            @if($ticket->assignedEmployee)
                <div style="display: flex; align-items: flex-start; gap: 12px; margin-top: 12px; padding: 12px; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                    @if($ticket->assignedEmployee->photo_path)
                        <img src="{{ storage_asset($ticket->assignedEmployee->photo_path) }}" alt="{{ $ticket->assignedEmployee->name }}" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb; flex-shrink: 0;">
                    @else
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 18px; flex-shrink: 0;">
                            {{ strtoupper(substr($ticket->assignedEmployee->name, 0, 1)) }}
                        </div>
                    @endif
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-weight: 600; color: #0f172a; font-size: 15px; margin-bottom: 6px;">
                            {{ $ticket->assignedEmployee->name }}
                        </div>
                        @if($ticket->assignedEmployee->position)
                            <div style="font-size: 12px; color: #64748b; margin-bottom: 4px; display: flex; align-items: center; gap: 4px;">
                                <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24" style="flex-shrink: 0;">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                                <span>{{ $ticket->assignedEmployee->position }}</span>
                            </div>
                        @endif
                        @if($ticket->assignedEmployee->email)
                            <div style="font-size: 12px; color: #64748b; margin-bottom: 4px; display: flex; align-items: center; gap: 4px; word-break: break-all;">
                                <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24" style="flex-shrink: 0;">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                                <span>{{ $ticket->assignedEmployee->email }}</span>
                            </div>
                        @endif
                        @if($ticket->assignedEmployee->phone)
                            <div style="font-size: 12px; color: #64748b; display: flex; align-items: center; gap: 4px;">
                                <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24" style="flex-shrink: 0;">
                                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                </svg>
                                <span>{{ $ticket->assignedEmployee->phone }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="sidebar-value" style="color: #9ca3af; font-style: italic;">Not assigned yet</div>
            @endif
        </div>
        @endif
        
        <div class="sidebar-section">
            <div class="sidebar-label">Work Status</div>
            <div class="sidebar-value">{{ str_replace('_', ' ', ucfirst($ticket->work_status ?? 'Not Started')) }}</div>
        </div>
        
        <div class="sidebar-section">
            <div class="sidebar-label">Created</div>
            <div class="sidebar-value">{{ $ticket->created_at ? $ticket->created_at->format('M d, Y') : 'N/A' }}</div>
        </div>
        
        <div class="sidebar-section">
            <div class="sidebar-label">Last Updated</div>
            <div class="sidebar-value">{{ $ticket->updated_at ? $ticket->updated_at->diffForHumans() : 'N/A' }}</div>
        </div>
        
        @if($ticket->status === 'completed' || $ticket->status === 'resolved')
        <div class="sidebar-section" style="border-top: 2px solid #e5e7eb; padding-top: 24px;">
            <div class="sidebar-label" style="color: #10b981; font-size: 13px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align: middle; margin-right: 4px;">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
                Completion Status
            </div>
            <div class="sidebar-value" style="margin-top: 12px;">
                @if($ticket->completed_at)
                    <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">
                        <strong>Completed:</strong> {{ $ticket->completed_at->format('M d, Y h:i A') }}
                    </div>
                @endif
                @if($ticket->completedBy)
                    <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">
                        <strong>By:</strong> {{ $ticket->completedBy->name }}
                    </div>
                @endif
                @if($ticket->confirmed_at)
                    <div style="font-size: 13px; color: #10b981; margin-bottom: 8px;">
                        <strong>✓ Confirmed:</strong> {{ $ticket->confirmed_at->format('M d, Y h:i A') }}
                    </div>
                @endif
            </div>
        </div>
        
        @if($ticket->resolution_notes || $ticket->completion_images)
        <div class="sidebar-section">
            <div class="sidebar-label" style="color: #3b82f6;">
                📋 Completion Details
            </div>
            
            @if($ticket->resolution_notes)
            <div style="margin-top: 12px;">
                <div style="font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px;">Resolution Notes:</div>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px; font-size: 13px; color: #475569; line-height: 1.5; white-space: pre-wrap; word-wrap: break-word;">{{ $ticket->resolution_notes }}</div>
            </div>
            @endif
            
            @if($ticket->completion_images && count($ticket->completion_images) > 0)
            <div style="margin-top: 12px;">
                <div style="font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px;">Completion Images ({{ count($ticket->completion_images) }}):</div>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px;">
                    @foreach($ticket->completion_images as $image)
                    <div style="position: relative; border-radius: 8px; overflow: hidden; border: 2px solid #e2e8f0; cursor: pointer;" onclick="window.open('{{ storage_asset($image) }}', '_blank')" title="Click to view full size">
                        <img src="{{ storage_asset($image) }}" style="width: 100%; height: 80px; object-fit: cover; display: block;">
                    </div>
                    @endforeach
                </div>
                <div style="margin-top: 6px; font-size: 11px; color: #94a3b8; font-style: italic;">Click images to view full size</div>
            </div>
            @endif
        </div>
        @endif
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Tab switching
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const tab = this.dataset.tab;
        
        // Update active tab button
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('active');
            b.style.color = '#64748b';
            b.style.borderBottomColor = 'transparent';
        });
        this.classList.add('active');
        this.style.color = '#0f172a';
        this.style.borderBottomColor = tab === 'internal' ? '#f97316' : '#3b82f6';
        
        // Show/hide tab content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.style.display = 'none';
        });
        document.getElementById(tab + '-tab').style.display = 'block';
    });
});

// Handle Enter key to send (Shift+Enter for new line)
document.querySelectorAll('.comment-form-inner textarea').forEach(textarea => {
    textarea.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            const form = this.closest('form');
            if (this.value.trim()) {
                form.dispatchEvent(new Event('submit'));
            }
        }
    });
});

// Handle comment form submissions
document.querySelectorAll('.comment-form-inner').forEach(form => {
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        const isInternal = formData.get('is_internal') === '1';
        const type = this.dataset.type;
        const textarea = this.querySelector('textarea');
        
        // Manually add file if it exists (for hidden file inputs)
        const fileInput = this.querySelector('input[type="file"]');
        console.log('File input found:', fileInput ? 'YES' : 'NO');
        console.log('File input ID:', fileInput?.id);
        console.log('Files in input:', fileInput?.files?.length || 0);
        
        if (fileInput && fileInput.files && fileInput.files.length > 0) {
            formData.set('attachment', fileInput.files[0]);
            console.log('✅ File added to FormData:', fileInput.files[0].name, fileInput.files[0].size, 'bytes');
        } else {
            console.log('❌ No file selected in input');
        }
        
        // Debug: Show all FormData
        console.log('=== FormData Contents ===');
        for (let pair of formData.entries()) {
            if (pair[1] instanceof File) {
                console.log(pair[0] + ':', 'File -', pair[1].name, pair[1].size, 'bytes');
            } else {
                console.log(pair[0] + ':', pair[1]);
            }
        }
        console.log('========================');
        
        // Don't submit if empty
        if (!textarea.value.trim()) {
            return;
        }
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite;"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> Sending...';
        
        try {
            const response = await fetch('{{ route("tickets.addComment", $ticket->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Determine which list to update
                let listId;
                if (isInternal) {
                    listId = 'internalCommentsList';
                } else {
                    // Check if customer or admin view
                    listId = document.getElementById('externalCommentsList') ? 'externalCommentsList' : 'customerCommentsList';
                }
                
                const commentsList = document.getElementById(listId);
                
                if (!commentsList) {
                    console.error('Comments list not found:', listId);
                    alert('Comment added successfully! Please refresh the page to see it.');
                    location.reload();
                    return;
                }
                
                // Remove empty state if exists
                const emptyState = commentsList.querySelector('.empty-comments');
                if (emptyState) {
                    emptyState.remove();
                }
                
                // Add new comment to list with fade-in animation
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data.html;
                const newComment = tempDiv.firstElementChild;
                newComment.style.opacity = '0';
                newComment.style.transform = 'translateY(10px)';
                newComment.style.transition = 'all 0.3s ease';
                
                commentsList.appendChild(newComment);
                
                // Trigger animation
                setTimeout(() => {
                    newComment.style.opacity = '1';
                    newComment.style.transform = 'translateY(0)';
                }, 10);
                
                // Scroll to new comment smoothly
                setTimeout(() => {
                    commentsList.scrollTo({
                        top: commentsList.scrollHeight,
                        behavior: 'smooth'
                    });
                }, 100);
                
                // Reset form
                textarea.value = '';
                textarea.style.height = 'auto';
                
                // Clear file input if exists
                const fileInput = this.querySelector('input[type="file"]');
                if (fileInput) {
                    fileInput.value = '';
                    const fileNameDiv = this.querySelector('[id$="-file-name"]');
                    if (fileNameDiv) {
                        fileNameDiv.innerHTML = '';
                    }
                }
                
                // Show subtle success indicator
                const successMsg = document.createElement('div');
                successMsg.textContent = isInternal ? '✓ Internal note added' : '✓ Message sent';
                successMsg.style.cssText = 'position: fixed; bottom: 20px; right: 20px; background: #10b981; color: white; padding: 12px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); z-index: 9999; animation: slideIn 0.3s ease;';
                document.body.appendChild(successMsg);
                
                setTimeout(() => {
                    successMsg.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => successMsg.remove(), 300);
                }, 2000);
            } else {
                alert(data.message || 'Failed to add comment');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while adding the comment');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });
});

// Auto-resize textarea
document.querySelectorAll('.comment-form-inner textarea').forEach(textarea => {
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});

// Initialize first tab as active
document.querySelector('.tab-btn.active')?.click();

// Edit completion data from show page (for admins)
function editCompletionDataFromShow(ticketId) {
    // Redirect to tickets index with edit modal
    window.location.href = '{{ route("tickets.index") }}?edit_completion=' + ticketId;
}

// Customer: Close ticket
function closeTicket(ticketId) {
    if (typeof Swal === 'undefined') {
        const feedback = prompt('Optional: Please provide feedback about the resolution (optional):');
        performCloseTicket(ticketId, feedback || '');
        return;
    }
    
    Swal.fire({
        title: '<strong style="color: #1e293b; font-size: 22px;">✓ Close This Ticket?</strong>',
        html: `
            <div style="text-align: left; padding: 0 10px;">
                <p style="color: #64748b; font-size: 14px; margin-bottom: 16px;">
                    Are you satisfied with the resolution? Closing this ticket will mark it as complete.
                </p>
                
                <label style="display: block; font-weight: 600; color: #475569; font-size: 13px; margin-bottom: 6px;">
                    💬 Feedback (Optional)
                </label>
                <textarea 
                    id="customer_feedback" 
                    class="swal2-textarea" 
                    placeholder="Share your experience or any additional comments..." 
                    style="width: 100%; min-height: 100px; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; font-family: inherit; resize: vertical;"
                ></textarea>
                
                <p style="color: #94a3b8; font-size: 12px; margin-top: 8px; font-style: italic;">
                    💡 Your feedback helps us improve our service
                </p>
            </div>
        `,
        icon: null,
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<span style="display: flex; align-items: center; gap: 6px;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg> Yes, Close Ticket</span>',
        cancelButtonText: 'Cancel',
        width: '550px',
        padding: '2rem',
        customClass: {
            popup: 'close-ticket-popup',
            confirmButton: 'close-confirm-btn',
            cancelButton: 'close-cancel-btn'
        },
        didOpen: () => {
            const style = document.createElement('style');
            style.textContent = `
                .close-ticket-popup {
                    border-radius: 16px !important;
                    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15) !important;
                }
                .close-confirm-btn, .close-cancel-btn {
                    padding: 12px 24px !important;
                    border-radius: 10px !important;
                    font-weight: 600 !important;
                    font-size: 14px !important;
                }
                .swal2-textarea:focus {
                    border-color: #10b981 !important;
                    outline: none !important;
                    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
                }
            `;
            document.head.appendChild(style);
            
            document.getElementById('customer_feedback').focus();
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const feedback = document.getElementById('customer_feedback').value.trim();
            performCloseTicket(ticketId, feedback);
        }
    });
}

function performCloseTicket(ticketId, feedback) {
    const formData = new FormData();
    formData.append('feedback', feedback);
    
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Closing...',
            text: 'Please wait',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }
    
    fetch(`{{ url('tickets') }}/${ticketId}/close`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Ticket Closed!', 
                    text: data.message || 'Thank you for your feedback!', 
                    timer: 2000, 
                    showConfirmButton: false 
                });
            } else {
                alert('Ticket closed successfully!');
            }
            setTimeout(() => location.reload(), 1500);
        } else {
            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Failed to close ticket' });
            } else {
                alert('Error: ' + (data.message || 'Failed to close ticket'));
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (typeof Swal !== 'undefined') {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to close ticket' });
        } else {
            alert('Error closing ticket');
        }
    });
}

// Show selected filename
function showFileName(input, targetId) {
    const target = document.getElementById(targetId);
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB
        const fileType = file.type.includes('image') ? '🖼️ Image' : '📄 PDF';
        target.innerHTML = `
            <div style="display: flex; align-items: center; gap: 8px; padding: 8px 12px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 6px;">
                <span style="font-weight: 600; color: #15803d;">${fileType}:</span>
                <span style="color: #166534;">${file.name}</span>
                <span style="color: #86efac; font-size: 12px;">(${fileSize} MB)</span>
                <button type="button" onclick="clearFile('${input.id}', '${targetId}')" style="margin-left: auto; background: none; border: none; color: #dc2626; cursor: pointer; font-size: 18px; line-height: 1;" title="Remove file">×</button>
            </div>
        `;
    } else {
        target.innerHTML = '';
    }
}

// Clear selected file
function clearFile(inputId, targetId) {
    const input = document.getElementById(inputId);
    const target = document.getElementById(targetId);
    input.value = '';
    target.innerHTML = '';
}
</script>

<style>
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
</style>
@endpush

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('tickets.index') }}">Tickets</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">#{{ $ticket->ticket_no ?? $ticket->id }}</span>
@endsection
