@props([
    'src' => null,
    'name' => 'User',
    'size' => '40px',
    'rounded' => '50%',
    'class' => '',
    'color' => null,
    'user' => null,
    'employee' => null,
])

@php
    $initials = get_user_initials($name);
    
    // Get chat_color from user/employee or use provided color
    $bgColor = $color;
    if (!$bgColor && $user && !empty($user->chat_color)) {
        $bgColor = $user->chat_color;
    } elseif (!$bgColor && $employee && $employee->user && !empty($employee->user->chat_color)) {
        $bgColor = $employee->user->chat_color;
    }
    
    // Fallback to random color based on name if no chat_color
    if (!$bgColor) {
        $colors = ['#6366f1', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6', '#ef4444', '#06b6d4', '#84cc16'];
        $colorIndex = crc32($name) % count($colors);
        $bgColor = $colors[$colorIndex];
    }
    
    // Calculate inner size for ring effect (85% of outer)
    $sizeNum = (int) filter_var($size, FILTER_SANITIZE_NUMBER_INT);
    $innerSize = round($sizeNum * 0.85) . 'px';
    $fontSize = round($sizeNum / 2.5) . 'px';
@endphp

<div 
    class="{{ $class }}" 
    style="width: {{ $size }}; height: {{ $size }}; border-radius: {{ $rounded }}; background: {{ $bgColor }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"
>
    @if($src)
        {{-- Photo with colored ring --}}
        <div style="width: {{ $innerSize }}; height: {{ $innerSize }}; border-radius: {{ $rounded }}; overflow: hidden; border: 2px solid white;">
            <img 
                src="{{ $src }}" 
                alt="{{ $name }}"
                style="width: 100%; height: 100%; object-fit: cover;"
                onerror="this.parentElement.outerHTML='<div style=\'width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:{{ $fontSize }};\'>{{ $initials }}</div>';"
            >
        </div>
    @else
        {{-- Initials on colored background --}}
        <div 
            style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: {{ $fontSize }};"
        >
            {{ $initials }}
        </div>
    @endif
</div>
