@props([
    'user' => null,
    'employee' => null,
    'name' => null,
    'size' => 'md',
    'showName' => false,
    'class' => '',
])

@php
    // Determine which model to use
    $model = $employee ?? $user;
    $displayName = $name ?? ($model->name ?? 'User');
    
    // Clean the name - remove anything in parentheses and special characters
    $cleanName = preg_replace('/\s*\([^)]*\)/', '', $displayName);
    $cleanName = preg_replace('/[^a-zA-Z\s]/', '', $cleanName);
    $cleanName = trim($cleanName);
    
    // Get initials (first letter of first and last name)
    $words = array_filter(explode(' ', $cleanName));
    $words = array_values($words);
    
    if (count($words) >= 2) {
        $initials = strtoupper(substr($words[0], 0, 1) . substr($words[count($words) - 1], 0, 1));
    } elseif (count($words) == 1 && strlen($words[0]) >= 2) {
        $initials = strtoupper(substr($words[0], 0, 2));
    } else {
        $initials = strtoupper(substr($displayName, 0, 1)) . strtoupper(substr($displayName, 1, 1));
    }
    
    $initials = substr($initials, 0, 2);
    if (strlen($initials) < 2) {
        $initials = str_pad($initials, 2, $initials);
    }
    
    // Check if has photo
    $hasPhoto = false;
    $photoUrl = null;
    if ($employee && !empty($employee->photo_path)) {
        $hasPhoto = true;
        $photoUrl = storage_asset($employee->photo_path);
    } elseif ($user && !empty($user->photo_path)) {
        $hasPhoto = true;
        $photoUrl = storage_asset($user->photo_path);
    }
    
    // Get chat_color from user
    $chatColor = null;
    if ($user && !empty($user->chat_color)) {
        $chatColor = $user->chat_color;
    } elseif ($employee && $employee->user && !empty($employee->user->chat_color)) {
        $chatColor = $employee->user->chat_color;
    }
    
    // Fallback color
    if (!$chatColor) {
        $fallbackColors = ['#6366f1', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6', '#ef4444', '#06b6d4', '#84cc16'];
        $colorIndex = $model ? (($model->id ?? 0) % count($fallbackColors)) : 0;
        $chatColor = $fallbackColors[$colorIndex];
    }
    
    // Size configurations
    $sizes = [
        'xs' => ['size' => 24, 'font' => 9, 'border' => 2],
        'sm' => ['size' => 32, 'font' => 11, 'border' => 2],
        'md' => ['size' => 40, 'font' => 14, 'border' => 2],
        'lg' => ['size' => 48, 'font' => 16, 'border' => 3],
        'xl' => ['size' => 56, 'font' => 18, 'border' => 3],
        '2xl' => ['size' => 72, 'font' => 24, 'border' => 3],
        '3xl' => ['size' => 96, 'font' => 32, 'border' => 4],
    ];
    $config = $sizes[$size] ?? $sizes['md'];
    $avatarSize = $config['size'];
    $fontSize = $config['font'];
    $borderWidth = $config['border'];
    $innerSize = $avatarSize - ($borderWidth * 2);
@endphp

<div class="{{ $class }}" style="display:inline-flex;align-items:center;gap:8px;">
    @if($hasPhoto)
        {{-- Photo with colored border ring - using border instead of padding --}}
        <div style="width:{{ $avatarSize }}px;height:{{ $avatarSize }}px;min-width:{{ $avatarSize }}px;min-height:{{ $avatarSize }}px;border-radius:50%;border:{{ $borderWidth }}px solid {{ $chatColor }};box-sizing:border-box;flex-shrink:0;overflow:hidden;background:#f3f4f6;">
            <img 
                src="{{ $photoUrl }}" 
                alt="{{ $displayName }}"
                style="width:100%;height:100%;object-fit:cover;display:block;border-radius:50%;"
                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
            >
            <div style="width:100%;height:100%;background:{{ $chatColor }};color:#fff;font-weight:700;font-size:{{ $fontSize }}px;display:none;align-items:center;justify-content:center;text-transform:uppercase;letter-spacing:0.5px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">{{ $initials }}</div>
        </div>
    @else
        {{-- Initials on colored background --}}
        <div style="width:{{ $avatarSize }}px;height:{{ $avatarSize }}px;min-width:{{ $avatarSize }}px;min-height:{{ $avatarSize }}px;border-radius:50%;background:{{ $chatColor }};color:#fff;font-weight:700;font-size:{{ $fontSize }}px;display:flex;align-items:center;justify-content:center;flex-shrink:0;text-transform:uppercase;letter-spacing:0.5px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;box-sizing:border-box;">{{ $initials }}</div>
    @endif
    
    @if($showName)
        <span style="font-weight:500;color:#374151;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;">{{ $displayName }}</span>
    @endif
</div>
