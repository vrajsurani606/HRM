<div class="comment {{ $comment->is_internal ? 'comment-internal' : '' }}">
    <div class="comment-avatar" style="overflow: hidden;">
        @php
            $userName = $comment->user->name ?? 'Unknown User';
            $employee = null;
            
            // Try to get employee
            if ($comment->user) {
                $employee = \App\Models\Employee::where('user_id', $comment->user->id)->first();
                if (!$employee) {
                    $employee = \App\Models\Employee::where('email', $comment->user->email)->first();
                }
            }
            
            $photoUrl = $employee ? $employee->profile_photo_url : ($comment->user ? $comment->user->profile_photo_url : get_default_avatar($userName));
        @endphp
        
        <img src="{{ $photoUrl }}" alt="{{ $userName }}" style="width: 100%; height: 100%; object-fit: cover;">
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
        
        @if($comment->attachment_path)
            <div class="comment-attachment" style="margin-top: 12px;">
                @if($comment->isImage())
                    <a href="{{ $comment->attachment_url }}" target="_blank" style="display: inline-block; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; max-width: 300px;">
                        <img src="{{ $comment->attachment_url }}" alt="{{ $comment->attachment_name }}" style="width: 100%; height: auto; display: block;">
                    </a>
                    <div style="margin-top: 6px; font-size: 12px; color: #64748b; display: flex; align-items: center; gap: 4px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink: 0;">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <span>{{ $comment->attachment_name }}</span>
                    </div>
                @elseif($comment->isPdf())
                    <a href="{{ $comment->attachment_url }}" target="_blank" style="display: inline-flex; align-items: center; gap: 10px; padding: 12px 16px; background: #fef3f2; border: 1px solid #fecaca; border-radius: 8px; text-decoration: none; color: #dc2626; font-size: 14px; font-weight: 500; transition: all 0.2s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#fef3f2'">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                        </svg>
                        <div>
                            <div style="font-weight: 600;">{{ $comment->attachment_name }}</div>
                            <div style="font-size: 12px; color: #991b1b; margin-top: 2px;">Click to view PDF</div>
                        </div>
                    </a>
                @else
                    <a href="{{ $comment->attachment_url }}" target="_blank" style="display: inline-flex; align-items: center; gap: 10px; padding: 12px 16px; background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 8px; text-decoration: none; color: #0f172a; font-size: 14px; font-weight: 500; transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/>
                        </svg>
                        <div>
                            <div style="font-weight: 600;">{{ $comment->attachment_name }}</div>
                            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">Click to download</div>
                        </div>
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
