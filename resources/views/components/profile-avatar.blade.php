@props([
    'user' => null,
    'employee' => null,
    'name' => null,
    'size' => '40',
    'rounded' => 'full',
    'showName' => false,
    'class' => '',
])

@php
    // Determine which model to use
    $model = $employee ?? $user;
    $displayName = $name ?? ($model->name ?? 'User');
    
    // Get profile data
    $profileData = profile_photo_or_initials($model, $displayName);
    
    // Size classes
    $sizeClass = match($size) {
        'xs' => 'w-6 h-6 text-xs',
        'sm' => 'w-8 h-8 text-sm',
        'md' => 'w-10 h-10 text-base',
        'lg' => 'w-12 h-12 text-lg',
        'xl' => 'w-16 h-16 text-xl',
        '2xl' => 'w-20 h-20 text-2xl',
        '3xl' => 'w-24 h-24 text-3xl',
        default => "w-{$size} h-{$size}"
    };
    
    // Rounded classes
    $roundedClass = match($rounded) {
        'full' => 'rounded-full',
        'lg' => 'rounded-lg',
        'md' => 'rounded-md',
        'sm' => 'rounded-sm',
        'none' => 'rounded-none',
        default => $rounded
    };
    
    // Random gradient colors for initials
    $colors = [
        'from-blue-500 to-blue-600',
        'from-green-500 to-green-600',
        'from-purple-500 to-purple-600',
        'from-pink-500 to-pink-600',
        'from-indigo-500 to-indigo-600',
        'from-red-500 to-red-600',
        'from-yellow-500 to-yellow-600',
        'from-teal-500 to-teal-600',
    ];
    $colorIndex = $model ? ($model->id ?? 0) % count($colors) : 0;
    $gradientColor = $colors[$colorIndex];
@endphp

<div class="inline-flex items-center gap-2 {{ $class }}">
    <div class="relative {{ $sizeClass }} {{ $roundedClass }} overflow-hidden flex-shrink-0 shadow-sm">
        @if($profileData['type'] === 'photo')
            <img 
                src="{{ $profileData['content'] }}" 
                alt="{{ $profileData['name'] }}"
                class="w-full h-full object-cover"
                onerror="this.onerror=null; this.src='{{ get_default_avatar($profileData['name']) }}';"
            >
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br {{ $gradientColor }} text-white font-bold">
                {{ $profileData['initials'] }}
            </div>
        @endif
    </div>
    
    @if($showName)
        <span class="font-medium text-gray-700">{{ $profileData['name'] }}</span>
    @endif
</div>
