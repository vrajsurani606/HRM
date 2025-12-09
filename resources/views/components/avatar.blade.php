@props([
    'src' => null,
    'name' => 'User',
    'size' => '40px',
    'rounded' => '50%',
    'class' => '',
])

@php
    $initials = get_user_initials($name);
    $colors = ['#4F46E5', '#059669', '#DC2626', '#F59E0B', '#8B5CF6', '#EC4899', '#14B8A6', '#F97316'];
    $colorIndex = crc32($name) % count($colors);
    $bgColor = $colors[$colorIndex];
@endphp

<div 
    class="{{ $class }}" 
    style="width: {{ $size }}; height: {{ $size }}; border-radius: {{ $rounded }}; overflow: hidden; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"
>
    @if($src)
        <img 
            src="{{ $src }}" 
            alt="{{ $name }}"
            style="width: 100%; height: 100%; object-fit: cover;"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
        >
        <div 
            style="width: 100%; height: 100%; background: {{ $bgColor }}; color: white; font-weight: 700; font-size: calc({{ $size }} / 2.5); display: none; align-items: center; justify-content: center;"
        >
            {{ $initials }}
        </div>
    @else
        <div 
            style="width: 100%; height: 100%; background: {{ $bgColor }}; color: white; font-weight: 700; font-size: calc({{ $size }} / 2.5); display: flex; align-items: center; justify-content: center;"
        >
            {{ $initials }}
        </div>
    @endif
</div>
