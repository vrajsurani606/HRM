# Profile Photo Update Examples

## Example 1: Header User Dropdown

### BEFORE (Old Code):
```blade
@php
  $user = auth()->user();
  $employee = \App\Models\Employee::where('email', $user->email)->first();
  $photoUrl = $employee && $employee->photo_path 
    ? storage_asset($employee->photo_path) 
    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=3b82f6&color=fff&size=64';
@endphp
<img class="hrp-avatar" src="{{ $photoUrl }}" alt="user"/>
```

### AFTER (New Code - Option 1: Using Component):
```blade
<x-avatar 
    :src="auth()->user()->profile_photo_url" 
    :name="auth()->user()->name" 
    size="40px"
    class="hrp-avatar"
/>
```

### AFTER (New Code - Option 2: Using Helper):
```blade
<img class="hrp-avatar" src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}">
```

---

## Example 2: Employee List

### BEFORE:
```blade
@foreach($employees as $employee)
    <div class="employee-card">
        @if($employee->photo_path)
            <img src="{{ storage_asset($employee->photo_path) }}" alt="{{ $employee->name }}">
        @else
            <div class="avatar-placeholder">{{ substr($employee->name, 0, 1) }}</div>
        @endif
        <h3>{{ $employee->name }}</h3>
    </div>
@endforeach
```

### AFTER:
```blade
@foreach($employees as $employee)
    <div class="employee-card">
        <x-profile-avatar :employee="$employee" size="lg" />
        <h3>{{ $employee->name }}</h3>
    </div>
@endforeach
```

---

## Example 3: Dashboard Cards

### BEFORE:
```blade
<div class="user-info">
    @php
        $photo = $user->photo_path ? storage_asset($user->photo_path) : asset('default-avatar.png');
    @endphp
    <img src="{{ $photo }}" onerror="this.src='{{ asset('default-avatar.png') }}'">
    <span>{{ $user->name }}</span>
</div>
```

### AFTER:
```blade
<div class="user-info">
    <x-profile-avatar :user="$user" size="md" :showName="true" />
</div>
```

---

## Example 4: Table with Photos

### BEFORE:
```blade
<table>
    @foreach($employees as $employee)
        <tr>
            <td>
                @if($employee->photo_path)
                    <img src="{{ storage_asset($employee->photo_path) }}" style="width: 32px; height: 32px; border-radius: 50%;">
                @else
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: #ccc; display: flex; align-items: center; justify-content: center;">
                        {{ substr($employee->name, 0, 1) }}
                    </div>
                @endif
            </td>
            <td>{{ $employee->name }}</td>
        </tr>
    @endforeach
</table>
```

### AFTER:
```blade
<table>
    @foreach($employees as $employee)
        <tr>
            <td>
                <x-avatar :src="$employee->profile_photo_url" :name="$employee->name" size="32px" />
            </td>
            <td>{{ $employee->name }}</td>
        </tr>
    @endforeach
</table>
```

---

## Example 5: Profile Page

### BEFORE:
```blade
<div class="profile-header">
    @php
        $employee = auth()->user()->employee;
        $photo = $employee && $employee->photo_path ? storage_asset($employee->photo_path) : null;
    @endphp
    <img src="{{ $photo ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=f59e0b&color=fff&size=200' }}" 
         style="width:100%;height:100%;object-fit:cover" 
         alt="{{ auth()->user()->name }}">
</div>
```

### AFTER:
```blade
<div class="profile-header">
    <x-profile-avatar :user="auth()->user()" size="3xl" rounded="lg" />
</div>
```

---

## Example 6: JavaScript/AJAX

### BEFORE:
```javascript
function displayUser(user) {
    let photoUrl = user.photo_path 
        ? `/storage/${user.photo_path}` 
        : '/default-avatar.png';
    
    return `<img src="${photoUrl}" alt="${user.name}">`;
}
```

### AFTER:
```javascript
function displayUser(user) {
    // Use the profile_photo_url from API response
    let photoUrl = user.profile_photo_url || 
        `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=3b82f6&color=fff`;
    
    return `<img src="${photoUrl}" alt="${user.name}" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=3b82f6&color=fff'">`;
}
```

---

## Quick Migration Checklist

1. ✅ Replace all `storage_asset($model->photo_path)` with `$model->profile_photo_url`
2. ✅ Replace manual fallback logic with components or helpers
3. ✅ Use `<x-profile-avatar>` for Tailwind-based views
4. ✅ Use `<x-avatar>` for inline-style views
5. ✅ Update API responses to include `profile_photo_url`
6. ✅ Test with users/employees that have no photo
7. ✅ Clear view cache: `php artisan view:clear`

---

## Benefits of New System

- ✅ **Consistent**: Same look across entire application
- ✅ **Maintainable**: Change once, updates everywhere
- ✅ **Reliable**: Automatic fallback handling
- ✅ **Accessible**: Proper alt text and error handling
- ✅ **Flexible**: Multiple sizes and styles
- ✅ **Clean**: Less code, easier to read
