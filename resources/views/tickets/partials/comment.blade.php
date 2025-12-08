<div class="comment {{ $comment->is_internal ? 'comment-internal' : '' }}">
    <div class="comment-avatar">
        {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
    </div>
    <div class="comment-content">
        <div class="comment-header">
            <div>
                <span class="comment-author">{{ $comment->user->name ?? 'Unknown User' }}</span>
                @if($comment->is_internal)
                    <span class="internal-badge">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
                        Internal
                    </span>
                @endif
            </div>
            <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
        </div>
        <div class="comment-text">{{ $comment->comment }}</div>
    </div>
</div>
