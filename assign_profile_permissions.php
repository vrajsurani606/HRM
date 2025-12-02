<?php

/**
 * Script to assign profile permissions to existing roles
 * Run this with: php assign_profile_permissions.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "Assigning profile permissions to roles...\n\n";

// Define profile permissions
$profilePermissions = [
    'Profile Management.view profile',
    'Profile Management.edit profile',
    'Profile Management.update profile',
    'Profile Management.update bank details',
    'Profile Management.delete profile',
    'Profile Management.view own profile',
    'Profile Management.edit own profile',
];

// Ensure all permissions exist
foreach ($profilePermissions as $permissionName) {
    Permission::firstOrCreate([
        'name' => $permissionName,
        'guard_name' => 'web',
    ]);
    echo "✓ Permission created/verified: {$permissionName}\n";
}

echo "\n";

// Get all roles from database
$allRoles = Role::all();

echo "Found " . $allRoles->count() . " roles in the system\n\n";

// Define role-specific permissions
$rolePermissions = [
    'super-admin' => [
        'Profile Management.view profile',
        'Profile Management.edit profile',
        'Profile Management.update profile',
        'Profile Management.update bank details',
        'Profile Management.delete profile',
        'Profile Management.view own profile',
        'Profile Management.edit own profile',
    ],
    'admin' => [
        'Profile Management.view profile',
        'Profile Management.edit profile',
        'Profile Management.update profile',
        'Profile Management.update bank details',
        'Profile Management.view own profile',
        'Profile Management.edit own profile',
    ],
    'hr' => [
        'Profile Management.view own profile',
        'Profile Management.edit own profile',
        'Profile Management.update bank details',
    ],
];

// Default permissions for all other roles (employee, receptionist, customer, etc.)
$defaultPermissions = [
    'Profile Management.view own profile',
    'Profile Management.edit own profile',
];

$updated = 0;
$skipped = 0;

// Process all roles
foreach ($allRoles as $role) {
    $roleName = $role->name;
    
    // Determine which permissions to assign
    if (isset($rolePermissions[$roleName])) {
        // Use specific permissions for this role
        $permissions = $rolePermissions[$roleName];
        $permissionType = 'specific';
    } else {
        // Use default permissions for all other roles
        $permissions = $defaultPermissions;
        $permissionType = 'default';
    }
    
    // Get existing permissions
    $existingPermissions = $role->permissions->pluck('name')->toArray();
    
    // Add new permissions without removing existing ones
    $newPermissions = array_unique(array_merge($existingPermissions, $permissions));
    
    $role->syncPermissions($newPermissions);
    
    echo "✓ Updated role: {$roleName} ({$permissionType} - added " . count($permissions) . " profile permissions)\n";
    $updated++;
}

echo "\n";
echo "========================================\n";
echo "Summary:\n";
echo "  Roles Updated: {$updated}\n";
echo "  Roles Skipped: {$skipped}\n";
echo "========================================\n";
echo "\nProfile permissions have been assigned successfully!\n";
echo "All users can now view and edit their own profiles.\n";
echo "Admins and Super Admins can manage all profiles.\n";
