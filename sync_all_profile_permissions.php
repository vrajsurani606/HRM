<?php

/**
 * Comprehensive script to sync profile permissions for ALL roles
 * This ensures every role in the system has appropriate profile access
 * Run this with: php sync_all_profile_permissions.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║     Profile Permissions Sync - All Roles                   ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Step 1: Create all profile permissions
echo "Step 1: Creating/Verifying Profile Permissions...\n";
echo "─────────────────────────────────────────────────\n";

$profilePermissions = [
    'Profile Management.view profile',
    'Profile Management.edit profile',
    'Profile Management.update profile',
    'Profile Management.update bank details',
    'Profile Management.delete profile',
    'Profile Management.view own profile',
    'Profile Management.edit own profile',
];

foreach ($profilePermissions as $permissionName) {
    $permission = Permission::firstOrCreate([
        'name' => $permissionName,
        'guard_name' => 'web',
    ]);
    echo "  ✓ {$permissionName}\n";
}

echo "\n";

// Step 2: Get all roles
echo "Step 2: Loading All Roles...\n";
echo "─────────────────────────────────────────────────\n";

$allRoles = Role::all();
echo "  Found {$allRoles->count()} roles in the system\n\n";

// Step 3: Define permission mappings
echo "Step 3: Assigning Permissions by Role Type...\n";
echo "─────────────────────────────────────────────────\n";

$rolePermissionMap = [
    // Super Admin - Full access to everything
    'super-admin' => [
        'Profile Management.view profile',
        'Profile Management.edit profile',
        'Profile Management.update profile',
        'Profile Management.update bank details',
        'Profile Management.delete profile',
        'Profile Management.view own profile',
        'Profile Management.edit own profile',
    ],
    
    // Admin - Can manage all profiles except delete
    'admin' => [
        'Profile Management.view profile',
        'Profile Management.edit profile',
        'Profile Management.update profile',
        'Profile Management.update bank details',
        'Profile Management.view own profile',
        'Profile Management.edit own profile',
    ],
    
    // HR - Can manage own profile and bank details (for payroll)
    'hr' => [
        'Profile Management.view own profile',
        'Profile Management.edit own profile',
        'Profile Management.update bank details',
    ],
];

// Default permissions for all other roles
$defaultPermissions = [
    'Profile Management.view own profile',
    'Profile Management.edit own profile',
];

// Step 4: Process each role
$stats = [
    'updated' => 0,
    'specific' => 0,
    'default' => 0,
    'unchanged' => 0,
];

foreach ($allRoles as $role) {
    $roleName = $role->name;
    
    // Determine which permissions to assign
    if (isset($rolePermissionMap[$roleName])) {
        $permissions = $rolePermissionMap[$roleName];
        $type = 'SPECIFIC';
        $stats['specific']++;
    } else {
        $permissions = $defaultPermissions;
        $type = 'DEFAULT';
        $stats['default']++;
    }
    
    // Get existing permissions
    $existingPermissions = $role->permissions->pluck('name')->toArray();
    
    // Filter to only profile permissions
    $existingProfilePerms = array_filter($existingPermissions, function($perm) {
        return strpos($perm, 'Profile Management.') === 0;
    });
    
    // Check if update is needed
    $newProfilePerms = $permissions;
    sort($existingProfilePerms);
    sort($newProfilePerms);
    
    if ($existingProfilePerms === $newProfilePerms) {
        echo "  ⊙ {$roleName} - Already up to date ({$type})\n";
        $stats['unchanged']++;
    } else {
        // Merge with existing non-profile permissions
        $otherPermissions = array_filter($existingPermissions, function($perm) {
            return strpos($perm, 'Profile Management.') !== 0;
        });
        
        $allPermissions = array_unique(array_merge($otherPermissions, $permissions));
        $role->syncPermissions($allPermissions);
        
        $addedCount = count($permissions) - count($existingProfilePerms);
        echo "  ✓ {$roleName} - Updated ({$type}, +{$addedCount} permissions)\n";
        $stats['updated']++;
    }
}

echo "\n";

// Step 5: Summary
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║                    SUMMARY REPORT                          ║\n";
echo "╠════════════════════════════════════════════════════════════╣\n";
echo "║  Total Roles Processed:  " . str_pad($allRoles->count(), 33) . "║\n";
echo "║  Roles Updated:          " . str_pad($stats['updated'], 33) . "║\n";
echo "║  Roles Unchanged:        " . str_pad($stats['unchanged'], 33) . "║\n";
echo "║                                                            ║\n";
echo "║  Specific Permissions:   " . str_pad($stats['specific'], 33) . "║\n";
echo "║  Default Permissions:    " . str_pad($stats['default'], 33) . "║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Step 6: Permission breakdown
echo "Permission Breakdown:\n";
echo "─────────────────────────────────────────────────\n";
echo "  Super Admin & Admin:\n";
echo "    ✓ Can view/edit ANY user's profile\n";
echo "    ✓ Can update bank details for anyone\n";
echo "    ✓ Super Admin can delete profiles\n\n";

echo "  HR:\n";
echo "    ✓ Can view/edit own profile\n";
echo "    ✓ Can update bank details (for payroll)\n\n";

echo "  All Other Roles (Employee, Receptionist, Customer, etc.):\n";
echo "    ✓ Can view own profile\n";
echo "    ✓ Can edit own profile\n";
echo "    ✗ Cannot access other users' profiles\n\n";

echo "✅ Profile permissions sync completed successfully!\n";
echo "   All users can now access their profile page.\n\n";
