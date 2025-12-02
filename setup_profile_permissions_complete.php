<?php

/**
 * Complete Profile Permissions Setup Script
 * This script will:
 * 1. Seed all permissions (including Profile Management)
 * 2. Assign profile permissions to all roles
 * 3. Verify the setup
 * 
 * Run this with: php setup_profile_permissions_complete.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Artisan;

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║     Profile Permissions - Complete Setup                  ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Step 1: Run Permission Seeder
echo "Step 1: Running Permission Seeder...\n";
echo "─────────────────────────────────────────────────\n";

try {
    Artisan::call('db:seed', ['--class' => 'PermissionSeeder', '--force' => true]);
    echo "  ✓ Permission seeder executed successfully\n";
    echo "  " . Artisan::output();
} catch (\Exception $e) {
    echo "  ✗ Error running seeder: " . $e->getMessage() . "\n";
    echo "  Continuing with manual permission creation...\n";
}

echo "\n";

// Step 2: Verify Profile Permissions Exist
echo "Step 2: Verifying Profile Permissions...\n";
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

$createdCount = 0;
$existingCount = 0;

foreach ($profilePermissions as $permissionName) {
    $permission = Permission::firstOrCreate([
        'name' => $permissionName,
        'guard_name' => 'web',
    ]);
    
    if ($permission->wasRecentlyCreated) {
        echo "  ✓ Created: {$permissionName}\n";
        $createdCount++;
    } else {
        echo "  ✓ Exists: {$permissionName}\n";
        $existingCount++;
    }
}

echo "\n  Summary: {$createdCount} created, {$existingCount} already existed\n\n";

// Step 3: Load All Roles
echo "Step 3: Loading All Roles...\n";
echo "─────────────────────────────────────────────────\n";

$allRoles = Role::all();
echo "  Found {$allRoles->count()} roles in the system:\n";
foreach ($allRoles as $role) {
    echo "    • {$role->name}\n";
}
echo "\n";

// Step 4: Assign Permissions to Roles
echo "Step 4: Assigning Profile Permissions to Roles...\n";
echo "─────────────────────────────────────────────────\n";

$rolePermissionMap = [
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

$defaultPermissions = [
    'Profile Management.view own profile',
    'Profile Management.edit own profile',
];

$stats = [
    'updated' => 0,
    'unchanged' => 0,
    'specific' => 0,
    'default' => 0,
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
    
    // Merge with existing non-profile permissions
    $otherPermissions = array_filter($existingPermissions, function($perm) {
        return strpos($perm, 'Profile Management.') !== 0;
    });
    
    $allPermissions = array_unique(array_merge($otherPermissions, $permissions));
    $role->syncPermissions($allPermissions);
    
    $addedCount = count($permissions);
    echo "  ✓ {$roleName} - {$type} ({$addedCount} profile permissions)\n";
    $stats['updated']++;
}

echo "\n";

// Step 5: Verification
echo "Step 5: Verifying Setup...\n";
echo "─────────────────────────────────────────────────\n";

$verificationPassed = true;

foreach ($allRoles as $role) {
    $roleName = $role->name;
    $profilePerms = $role->permissions->filter(function($perm) {
        return strpos($perm->name, 'Profile Management.') === 0;
    });
    
    $hasViewOwn = $profilePerms->contains('name', 'Profile Management.view own profile');
    $hasEditOwn = $profilePerms->contains('name', 'Profile Management.edit own profile');
    
    if ($hasViewOwn && $hasEditOwn) {
        echo "  ✓ {$roleName}: {$profilePerms->count()} profile permissions ✓\n";
    } else {
        echo "  ✗ {$roleName}: Missing required permissions!\n";
        $verificationPassed = false;
    }
}

echo "\n";

// Step 6: Summary Report
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║                    SETUP COMPLETE                          ║\n";
echo "╠════════════════════════════════════════════════════════════╣\n";
echo "║  Total Roles:            " . str_pad($allRoles->count(), 33) . "║\n";
echo "║  Roles Updated:          " . str_pad($stats['updated'], 33) . "║\n";
echo "║  Specific Permissions:   " . str_pad($stats['specific'], 33) . "║\n";
echo "║  Default Permissions:    " . str_pad($stats['default'], 33) . "║\n";
echo "║                                                            ║\n";
echo "║  Verification:           " . str_pad($verificationPassed ? '✓ PASSED' : '✗ FAILED', 33) . "║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Step 7: Next Steps
echo "Next Steps:\n";
echo "─────────────────────────────────────────────────\n";
echo "1. Visit: http://localhost/GitVraj/HrPortal/roles\n";
echo "2. Click 'Edit' on any role (e.g., role ID 4)\n";
echo "3. Look for 'Profile Management' section\n";
echo "4. Verify permissions are visible and assigned\n";
echo "5. Test profile access: http://localhost/GitVraj/HrPortal/profile\n\n";

echo "Permission Breakdown:\n";
echo "─────────────────────────────────────────────────\n";
echo "  Super Admin & Admin:\n";
echo "    ✓ Can view/edit ANY user's profile\n";
echo "    ✓ Can update bank details for anyone\n";
echo "    ✓ Super Admin can delete profiles\n\n";

echo "  HR:\n";
echo "    ✓ Can view/edit own profile\n";
echo "    ✓ Can update bank details\n\n";

echo "  All Other Roles:\n";
echo "    ✓ Can view own profile\n";
echo "    ✓ Can edit own profile\n\n";

if ($verificationPassed) {
    echo "✅ SUCCESS! Profile permissions are now set up correctly.\n";
    echo "   All users can access their profile page.\n\n";
} else {
    echo "⚠️  WARNING! Some roles may not have correct permissions.\n";
    echo "   Please check the roles page and verify manually.\n\n";
}

// Step 8: Database Check
echo "Database Verification:\n";
echo "─────────────────────────────────────────────────\n";

$totalProfilePerms = Permission::where('name', 'like', 'Profile Management.%')->count();
echo "  Profile Permissions in DB: {$totalProfilePerms}/7\n";

if ($totalProfilePerms === 7) {
    echo "  ✓ All profile permissions exist in database\n";
} else {
    echo "  ⚠️  Expected 7 permissions, found {$totalProfilePerms}\n";
}

echo "\n";
echo "Setup script completed!\n";
echo "═══════════════════════════════════════════════════════════\n";
