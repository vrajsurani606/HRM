@props([
    'title' => 'No records found',
    'message' => 'Try adjusting your filters or create a new record',
    'icon' => 'inbox'
])

@push('styles')
<link rel="stylesheet" href="{{ asset('css/empty-state.css') }}">
@endpush

<div class="empty-state-grid-container" style="grid-column: 1 / -1; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 100px 20px; background: #fafafa; border-radius: 8px; min-height: 450px; width: 100%; margin: 0 auto;">
    @if($icon === 'inbox')
    <svg class="empty-state-grid-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 80px; height: 80px; color: #d1d5db; margin: 0 auto 20px; display: block;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
    </svg>
    @elseif($icon === 'search')
    <svg class="empty-state-grid-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 80px; height: 80px; color: #d1d5db; margin: 0 auto 20px; display: block;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
    </svg>
    @endif
    
    <div class="empty-state-grid-title" style="font-size: 22px; font-weight: 600; color: #374151; margin: 0 0 12px; line-height: 1.4; text-align: center;">{{ $title }}</div>
    <div class="empty-state-grid-message" style="font-size: 16px; color: #6b7280; margin: 0 auto; max-width: 550px; line-height: 1.6; text-align: center;">{{ $message }}</div>
    
    @if(isset($slot) && !empty(trim($slot)))
    <div class="empty-state-grid-slot" style="margin-top: 24px; text-align: center;">
        {{ $slot }}
    </div>
    @endif
</div>
