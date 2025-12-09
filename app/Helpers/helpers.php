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
