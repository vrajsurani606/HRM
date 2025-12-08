@props([
    'colspan' => '10',
    'title' => 'No records found',
    'message' => 'Try adjusting your filters or create a new record',
    'icon' => 'inbox'
])

@push('styles')
<link rel="stylesheet" href="{{ asset('css/empty-state.css') }}">
<style>
    .empty-state-cell {
        padding: 0 !important;
        border: none !important;
        text-align: center !important;
        display: table-cell !important;
        vertical-align: middle !important;
    }
    .empty-state-inner {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        padding: 80px 20px !important;
        background: #fafafa !important;
        min-height: 400px !important;
        width: 100% !important;
        margin: 0 auto !important;
        position: relative !important;
        left: 0 !important;
        right: 0 !important;
    }
</style>
@endpush

<tr>
    <td colspan="{{ $colspan }}" class="empty-state-cell">
        <div class="empty-state-inner">
            @if($icon === 'inbox')
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 72px; height: 72px; color: #d1d5db; margin: 0 auto 20px; display: block;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            @elseif($icon === 'search')
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 72px; height: 72px; color: #d1d5db; margin: 0 auto 20px; display: block;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            @endif
            
            <div style="font-size: 20px; font-weight: 600; color: #374151; margin: 0 0 12px; line-height: 1.4; text-align: center; width: 100%;">{{ $title }}</div>
            <div style="font-size: 15px; color: #6b7280; margin: 0 auto; max-width: 500px; line-height: 1.6; text-align: center; width: 100%;">{{ $message }}</div>
            
            @if(isset($slot) && !empty(trim($slot)))
            <div style="margin-top: 20px; text-align: center; width: 100%;">
                {{ $slot }}
            </div>
            @endif
        </div>
    </td>
</tr>
