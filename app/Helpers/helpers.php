<?php

if (!function_exists('storage_asset')) {
    /**
     * Generate a URL for a file stored in the public storage directory.
     * This helper handles the correct path for subdirectory installations.
     *
     * @param string $path
     * @return string
     */
    function storage_asset($path)
    {
        return asset('public/storage/' . ltrim($path, '/'));
    }
}

if (!function_exists('user_has_permission')) {
    /**
     * Check if user has permission (from role OR direct assignment)
     * This is a helper that combines both role-based and user-specific permissions
     *
     * @param string $permission
     * @param \App\Models\User|null $user
     * @return bool
     */
    function user_has_permission($permission, $user = null)
    {
        $user = $user ?? auth()->user();
        
        if (!$user) {
            return false;
        }
        
        // Spatie's hasPermissionTo already checks both role and direct permissions
        return $user->hasPermissionTo($permission);
    }
}

if (!function_exists('format_mobile_number')) {
    /**
     * Format mobile number with +91 country code
     * Handles various input formats and returns consistent output
     *
     * @param string|null $mobile
     * @param bool $withPlus Include + symbol (default: true)
     * @return string|null
     */
    function format_mobile_number($mobile, $withPlus = true)
    {
        if (empty($mobile)) {
            return null;
        }
        
        // Remove all non-numeric characters
        $mobile = preg_replace('/[^0-9]/', '', $mobile);
        
        // If already has country code (91), remove it
        if (strlen($mobile) > 10 && substr($mobile, 0, 2) === '91') {
            $mobile = substr($mobile, 2);
        }
        
        // Ensure it's a 10-digit number
        if (strlen($mobile) !== 10) {
            return $mobile; // Return as-is if not valid 10-digit number
        }
        
        // Format with country code
        return ($withPlus ? '+' : '') . '91' . $mobile;
    }
}

if (!function_exists('display_mobile')) {
    /**
     * Display formatted mobile number (alias for format_mobile_number)
     * Use this in Blade views for consistent display
     *
     * @param string|null $mobile
     * @return string
     */
    function display_mobile($mobile)
    {
        return format_mobile_number($mobile) ?? $mobile ?? '';
    }
}
if (!function_exists('strip_country_code')) {
    /**
     * Strip country code from mobile number for form inputs
     * Returns only the 10-digit number
     *
     * @param string|null $mobile
     * @return string|null
     */
    function strip_country_code($mobile)
    {
        if (empty($mobile)) {
            return null;
        }
        
        // Remove all non-numeric characters
        $mobile = preg_replace('/[^0-9]/', '', $mobile);
        
        // If has country code (91), remove it
        if (strlen($mobile) > 10 && substr($mobile, 0, 2) === '91') {
            $mobile = substr($mobile, 2);
        }
        
        return $mobile;
    }
}

if (!function_exists('user_has_any_action_permission')) {
    /**
     * Check if user has any action permissions (view, edit, delete) for a module
     * This is used to conditionally show/hide the Actions column in tables
     *
     * @param string $modulePrefix - e.g., 'Users Management', 'Roles Management'
     * @param array $actions - e.g., ['view', 'edit', 'delete']
     * @param \App\Models\User|null $user
     * @return bool
     */
    function user_has_any_action_permission($modulePrefix, $actions = ['view', 'edit', 'delete'], $user = null)
    {
        $user = $user ?? auth()->user();
        
        if (!$user) {
            return false;
        }
        
        // Check if user has any of the specified action permissions
        foreach ($actions as $action) {
            $permission = $modulePrefix . '.' . $action;
            if ($user->can($permission)) {
                return true;
            }
        }
        
        return false;
    }
}

if (!function_exists('get_profile_photo')) {
    /**
     * Get profile photo URL for Employee or User with fallback to default
     * 
     * @param \App\Models\Employee|\App\Models\User|null $model
     * @param string|null $name - Name for generating initials avatar
     * @return string
     */
    function get_profile_photo($model, $name = null)
    {
        if (!$model) {
            return get_default_avatar($name);
        }
        
        // Check if model has photo_path
        if (!empty($model->photo_path)) {
            return storage_asset($model->photo_path);
        }
        
        // Fallback to default avatar with name
        $displayName = $name ?? $model->name ?? 'User';
        return get_default_avatar($displayName);
    }
}

if (!function_exists('get_default_avatar')) {
    /**
     * Generate default avatar URL using UI Avatars service
     * 
     * @param string|null $name
     * @param string $background - Hex color without #
     * @param string $color - Hex color without #
     * @param int $size - Avatar size in pixels
     * @return string
     */
    function get_default_avatar($name = null, $background = '3b82f6', $color = 'ffffff', $size = 200)
    {
        $name = $name ?? 'User';
        return 'https://ui-avatars.com/api/?name=' . urlencode($name) 
               . '&background=' . $background 
               . '&color=' . $color 
               . '&size=' . $size
               . '&bold=true';
    }
}

if (!function_exists('get_user_initials')) {
    /**
     * Get user initials from name (first letter of first and last name)
     * 
     * @param string|null $name
     * @return string
     */
    function get_user_initials($name = null)
    {
        if (!$name) {
            return 'U';
        }
        
        $words = explode(' ', trim($name));
        
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[count($words) - 1], 0, 1));
        }
        
        return strtoupper(substr($name, 0, 1));
    }
}

if (!function_exists('profile_photo_or_initials')) {
    /**
     * Get profile photo HTML or initials div for display
     * Returns array with 'type' (photo|initials), 'content' (url or initials), 'name'
     * 
     * @param \App\Models\Employee|\App\Models\User|null $model
     * @param string|null $name
     * @return array
     */
    function profile_photo_or_initials($model, $name = null)
    {
        $displayName = $name ?? ($model->name ?? 'User');
        
        if ($model && !empty($model->photo_path)) {
            return [
                'type' => 'photo',
                'content' => storage_asset($model->photo_path),
                'name' => $displayName,
                'initials' => get_user_initials($displayName)
            ];
        }
        
        return [
            'type' => 'initials',
            'content' => get_user_initials($displayName),
            'name' => $displayName,
            'initials' => get_user_initials($displayName)
        ];
    }
}
    

if (!function_exists('user_restricted_to_own_data')) {
    /**
     * Check if the current user's role restricts them to only see their own data
     * 
     * @param \App\Models\User|null $user
     * @return bool
     */
    function user_restricted_to_own_data($user = null)
    {
        $user = $user ?? auth()->user();
        
        if (!$user) {
            return true; // No user = restrict by default
        }
        
        // Super-admin and admin always see all data
        if ($user->hasRole(['super-admin', 'admin'])) {
            return false;
        }
        
        // Check if any of user's roles have restrict_to_own_data enabled
        foreach ($user->roles as $role) {
            if ($role->restrict_to_own_data) {
                return true;
            }
        }
        
        return false;
    }
}

if (!function_exists('get_auth_employee')) {
    /**
     * Get the employee record linked to the authenticated user
     * 
     * @param \App\Models\User|null $user
     * @return \App\Models\Employee|null
     */
    function get_auth_employee($user = null)
    {
        $user = $user ?? auth()->user();
        
        if (!$user) {
            return null;
        }
        
        return \App\Models\Employee::where('user_id', $user->id)->first();
    }
}


if (!function_exists('get_user_dashboard_type')) {
    /**
     * Get the dashboard type for the current user based on their role's dashboard_type setting
     * 
     * @param \App\Models\User|null $user
     * @return string - admin, employee, customer, hr, receptionist
     */
    function get_user_dashboard_type($user = null)
    {
        $user = $user ?? auth()->user();
        
        if (!$user) {
            return 'admin'; // Default for guests
        }
        
        // Super-admin and admin always get admin dashboard
        if ($user->hasRole(['super-admin', 'admin'])) {
            return 'admin';
        }
        
        // Check user's roles for dashboard_type setting
        foreach ($user->roles as $role) {
            if (!empty($role->dashboard_type)) {
                return $role->dashboard_type;
            }
        }
        
        // Default to admin dashboard if no specific type set
        return 'admin';
    }
}
