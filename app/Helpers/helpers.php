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
