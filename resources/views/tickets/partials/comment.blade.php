<div class="comment {{ $comment->is_internal ? 'comment-internal' : '' }}">
    <div class="comment-avatar" style="overflow: hidden;">
        @php
            $photoPath = null;
            $userName = $comment->user->name ?? 'Unknown User';
            
            // Try to get employee photo first
            if ($comment->user) {
                $employee = \App\Models\Employee::where('user_id', $comment->user->id)->first();
                if (!$employee) {
                    $employee = \App\Models\Employee::where('email', $comment->user->email)->first();
                }
                if ($employee && $employee->photo_path) {
                    $photoPath = $employee->photo_path;
                }
            }
            
            // Fallback to user photo if no employee photo
            if (!$photoPath && $comment->user && isset($comment->user->photo_path)) {
                $photoPath = $comment->user->photo_path;
            }
            
            // Check if company user has photo
            if (!$photoPath && $comment->user && $comment->user->company_id) {
                $company = $comment->user->company;
                if ($company && isset($company->logo)) {
                    $photoPath = $company->logo;
                }
            }
        @endphp
        
        @if($photoPath)
            <img src="{{ storage_asset($photoPath) }}" alt="{{ $userName }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'; this.parentElement.innerHTML='{{ strtoupper(substr($userName, 0, 1)) }}';">
        @else
            {{ strtoupper(substr($userName, 0, 1)) }}
        @endif
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
