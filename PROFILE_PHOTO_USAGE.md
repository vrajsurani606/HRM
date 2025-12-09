# Profile Photo Display - Usage Guide

This system provides a comprehensive solution for displaying user and employee profile photos with automatic fallback to default avatars.

## Features

- ✅ Dynamic profile photo loading from storage
- ✅ Automatic fallback to initials-based avatars
- ✅ Consistent styling across the application
- ✅ Support for both Employee and User models
- ✅ Multiple display sizes and styles
- ✅ Error handling with graceful degradation

---

## Helper Functions

### 1. `get_profile_photo($model, $name = null)`
Returns the profile photo URL or default avatar.

```php
// For Employee
$photoUrl = get_profile_photo($employee);

// For User
$photoUrl = get_profile_photo($user);

// With custom name
$photoUrl = get_profile_photo($employee, 'John Doe');
```

### 2. `get_default_avatar($name, $background, $color, $size)`
Generates a default avatar using UI Avatars service.

```php
$avatar = get_default_avatar('John Doe');
$avatar = get_default_avatar('Jane Smith', '3b82f6', 'ffffff', 200);
```

### 3. `get_user_initials($name)`
Extracts initials from a name.

```php
$initials = get_user_initials('John Doe'); // Returns: JD
$initials = get_user_initials('Alice'); // Returns: A
```

### 4. `profile_photo_or_initials($model, $name = null)`
Returns array with photo data or initials for custom rendering.

```php
$data = profile_photo_or_initials($employee);
// Returns: ['type' => 'photo|initials', 'content' => '...', 'name' => '...', 'initials' => '...']
```

---

## Model Accessors

Both `Employee` and `User` models now have convenient accessors:

```php
// Get profile photo URL
$employee->profile_photo_url

// Get initials
$employee->initials
$user->initials
```

---

## Blade Components

### 1. Profile Avatar Component (Recommended)

Full-featured component with Tailwind CSS classes.

```blade
{{-- Basic usage --}}
<x-profile-avatar :employee="$employee" />
<x-profile-avatar :user="$user" />

{{-- With custom size --}}
<x-profile-avatar :employee="$employee" size="lg" />
<x-profile-avatar :user="$user" size="2xl" />

{{-- Size options: xs, sm, md, lg, xl, 2xl, 3xl, or custom like "40" --}}

{{-- With name display --}}
<x-profile-avatar :employee="$employee" :showName="true" />

{{-- Custom rounded corners --}}
<x-profile-avatar :employee="$employee" rounded="lg" />
{{-- Options: full, lg, md, sm, none --}}

{{-- With custom classes --}}
<x-profile-avatar :employee="$employee" class="shadow-lg border-2 border-white" />

{{-- Override name --}}
<x-profile-avatar :employee="$employee" name="Custom Name" />
```

### 2. Simple Avatar Component

Inline-style component for non-Tailwind contexts.

```blade
{{-- Basic usage --}}
<x-avatar :src="$employee->profile_photo_url" :name="$employee->name" />

{{-- Custom size --}}
<x-avatar :src="$user->profile_photo_url" :name="$user->name" size="60px" />

{{-- Square avatar --}}
<x-avatar :src="$employee->profile_photo_url" :name="$employee->name" rounded="8px" />

{{-- Without photo (initials only) --}}
<x-avatar :name="$employee->name" />
```

---

## Usage Examples

### In Employee List

```blade
@foreach($employees as $employee)
    <div class="flex items-center gap-3">
        <x-profile-avatar :employee="$employee" size="md" />
        <div>
            <h4>{{ $employee->name }}</h4>
            <p>{{ $employee->position }}</p>
        </div>
    </div>
@endforeach
```

### In User Dropdown

```blade
<div class="user-menu">
    <x-profile-avatar :user="auth()->user()" size="sm" :showName="true" />
</div>
```

### In Dashboard Cards

```blade
<div class="team-member-card">
    <x-profile-avatar :employee="$employee" size="xl" rounded="lg" />
    <h3>{{ $employee->name }}</h3>
</div>
```

### Custom HTML with Helper

```blade
@php
    $profileData = profile_photo_or_initials($employee);
@endphp

<div class="custom-avatar">
    @if($profileData['type'] === 'photo')
        <img src="{{ $profileData['content'] }}" alt="{{ $profileData['name'] }}">
    @else
        <div class="initials-circle">{{ $profileData['initials'] }}</div>
    @endif
</div>
```

### In Tables

```blade
<table>
    @foreach($employees as $employee)
        <tr>
            <td>
                <div class="flex items-center gap-2">
                    <x-avatar 
                        :src="$employee->profile_photo_url" 
                        :name="$employee->name" 
                        size="32px" 
                    />
                    <span>{{ $employee->name }}</span>
                </div>
            </td>
        </tr>
    @endforeach
</table>
```

### In JavaScript/AJAX Responses

```javascript
// When receiving employee data from API
const avatarHtml = `
    <img 
        src="${employee.profile_photo_url}" 
        alt="${employee.name}"
        onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(employee.name)}&background=3b82f6&color=fff'"
    >
`;
```

---

## Migration Guide

### Old Code:
```blade
<img src="{{ $employee->photo_path ? storage_asset($employee->photo_path) : asset('default-avatar.png') }}" alt="{{ $employee->name }}">
```

### New Code (Option 1 - Component):
```blade
<x-profile-avatar :employee="$employee" />
```

### New Code (Option 2 - Helper):
```blade
<img src="{{ $employee->profile_photo_url }}" alt="{{ $employee->name }}">
```

---

## Customization

### Change Default Avatar Colors

Edit `app/Helpers/helpers.php`:

```php
function get_default_avatar($name = null, $background = 'your-color', $color = 'ffffff', $size = 200)
```

### Change Gradient Colors in Component

Edit `resources/views/components/profile-avatar.blade.php`:

```php
$colors = [
    'from-your-color-500 to-your-color-600',
    // Add more colors
];
```

---

## Best Practices

1. **Always use components** for consistency
2. **Use appropriate sizes** for context (sm for lists, lg for profiles)
3. **Include alt text** for accessibility
4. **Test with missing photos** to ensure fallback works
5. **Use model accessors** (`$employee->profile_photo_url`) for cleaner code

---

## Troubleshooting

### Photos not loading?
- Check storage link: `php artisan storage:link`
- Verify photo_path in database
- Check file permissions

### Initials not showing?
- Ensure name field is not null
- Check helper function is loaded

### Component not found?
- Clear view cache: `php artisan view:clear`
- Check component file exists in `resources/views/components/`

---

## Support

For issues or questions, refer to the helper functions in `app/Helpers/helpers.php` and component files in `resources/views/components/`.
