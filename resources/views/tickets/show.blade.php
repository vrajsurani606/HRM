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
        background: #fef3c7;
        border-color: #fbbf24;
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
        padding: 2px 8px;
        background: #fbbf24;
        color: #78350f;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
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
        </div>
        
        <!-- Comments Section -->
        <div class="comments-section">
            <div class="section-title">Comments & Discussion</div>
            
            <div class="comments-list" id="commentsList">
                @forelse($ticket->comments as $comment)
                    @if(!$comment->is_internal || $isAdmin)
                        @include('tickets.partials.comment', ['comment' => $comment, 'isAdmin' => $isAdmin])
                    @endif
                @empty
                    <div class="empty-comments">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        <p>No comments yet. Start the conversation!</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Add Comment Form -->
            <div class="comment-form">
                <form id="commentForm">
                    @csrf
                    <div class="form-group">
                        <textarea 
                            name="comment" 
                            id="commentText" 
                            class="form-textarea" 
                            placeholder="Write your comment here..." 
                            required
                        ></textarea>
                    </div>
                    @if($isAdmin)
                    <div class="form-checkbox">
                        <input type="checkbox" name="is_internal" id="isInternal" value="1">
                        <label for="isInternal">Internal note (only visible to staff)</label>
                    </div>
                    @endif
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                            Send Comment
                        </button>
                    </div>
                </form>
            </div>
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
        
        <div class="sidebar-section">
            <div class="sidebar-label">Assigned To</div>
            <div class="sidebar-value">{{ $ticket->assignedEmployee->name ?? 'Not Assigned' }}</div>
        </div>
        
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
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('commentForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> Sending...';
    
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
            // Remove empty state if exists
            const emptyState = document.querySelector('.empty-comments');
            if (emptyState) {
                emptyState.remove();
            }
            
            // Add new comment to list
            const commentsList = document.getElementById('commentsList');
            commentsList.insertAdjacentHTML('beforeend', data.html);
            
            // Scroll to new comment
            commentsList.scrollTop = commentsList.scrollHeight;
            
            // Reset form
            document.getElementById('commentText').value = '';
            const internalCheckbox = document.getElementById('isInternal');
            if (internalCheckbox) {
                internalCheckbox.checked = false;
            }
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
</script>
@endpush

@section('breadcrumb')
  <a class="hrp-bc-home" href="{{ route('dashboard') }}">Dashboard</a>
  <span class="hrp-bc-sep">›</span>
  <a href="{{ route('tickets.index') }}">Tickets</a>
  <span class="hrp-bc-sep">›</span>
  <span class="hrp-bc-current">#{{ $ticket->ticket_no ?? $ticket->id }}</span>
@endsection
