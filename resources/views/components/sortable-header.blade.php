@props(['column', 'title'])

@php
    $currentSort = request('sort');
    $currentDirection = request('direction', 'desc');
    $newDirection = ($currentSort == $column && $currentDirection == 'asc') ? 'desc' : 'asc';
    
    $queryParams = request()->query();
    $queryParams['sort'] = $column;
    $queryParams['direction'] = $newDirection;
    
    $url = request()->url() . '?' . http_build_query($queryParams);
@endphp

<a href="{{ $url }}" 
   style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 4px;">
    {{ $title }}
    @if($currentSort == $column)
        <span style="font-size: 12px;">{{ $currentDirection == 'asc' ? '↑' : '↓' }}</span>
    @endif
</a>