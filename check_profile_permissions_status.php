<?php

/**
 * Quick Status Check for Profile Permissions
 * Run this to see the current state without making changes
 * 
 * Run with: php check_profile_permissions_status.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║     Profile Permissions - Status Check                    ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Check 1: Profile Permissions in Database
echo "1. Profile Permissions in Database:\n";
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

$existCount = 0;
foreach ($profilePermissions as $permName) {
    $exists = Permission::where('name', $permName)->exists();
    if ($exists) {
        echo "  ✓ {$permName}\n";
        $existCount++;
    } else {
        echo "  ✗ {$permName} - MISSING!\n";
    }
}

echo "\n  Status: {$existCount}/7 permissions exist\n";

if ($existCount < 7) {
    echo "  ⚠️  ACTION REQUIRED: Run setup script to create missing permissions\n";
}

echo "\n";

// Check 2: Roles and Their Profile Permissions
echo "2. Roles and Profile Permissions:\n";
echo "─────────────────────────────────────────────────\n";

$roles = Role::with('permissions')->get();

if ($roles->isEmpty()) {
    echo "  ⚠️  No roles found in database!\n\n";
} else {
    foreach ($roles as $role) {
        $profilePerms = $role->permissions->filter(function($perm) {
            return strpos($perm->name, 'Profile Management.') === 0;
        });
        
        $count = $profilePerms->count();
        $hasBasic = $profilePerms->contains('name', 'Profile Management.view own profile') &&
                    $profilePerms->contains('name', 'Profile Management.edit own profile');
        
        $status = $hasBasic ? '✓' : '✗';
        
        echo "  {$status} {$role->name} (ID: {$role->id}): {$count} profile permissions\n";
        
        if ($count > 0) {
            foreach ($profilePerms as $perm) {
                $shortName = str_replace('Profile Management.', '', $perm->name);
                echo "      • {$shortName}\n";
            }
        } else {
            echo "      ⚠️  No profile permissions assigned!\n";
        }
        echo "\n";
    }
}

// Check 3: Summary
echo "3. Summary:\n";
echo "─────────────────────────────────────────────────\n";

$totalRoles = $roles->count();
$rolesWithProfile = $roles->filter(function($role) {
    return $role->permissions->filter(function($perm) {
        return strpos($perm->name, 'Profile Management.') === 0;
    })->count() > 0;
})->count();

$rolesWithBasic = $roles->filter(function($role) {
    $profilePerms = $role->permissions->filter(function($perm) {
        return strpos($perm->name, 'Profile Management.') === 0;
    });
    return $profilePerms->contains('name', 'Profile Management.view own profile') &&
           $profilePerms->contains('name', 'Profile Management.edit own profile');
})->count();

echo "  Total Roles: {$totalRoles}\n";
echo "  Roles with Profile Permissions: {$rolesWithProfile}\n";
echo "  Roles with Basic Access (view own + edit own): {$rolesWithBasic}\n\n";

// Check 4: Recommendations
echo "4. Recommendations:\n";
echo "─────────────────────────────────────────────────\n";

if ($existCount < 7) {
    echo "  ⚠️  CRITICAL: Missing profile permissions in database\n";
    echo "     → Run: php setup_profile_permissions_complete.php\n\n";
} elseif ($rolesWithBasic < $totalRoles) {
    echo "  ⚠️  WARNING: Some roles don't have basic profile access\n";
    echo "     → Run: php setup_profile_permissions_complete.php\n\n";
} else {
    echo "  ✓ All checks passed!\n";
    echo "  ✓ All roles have appropriate profile permissions\n";
    echo "  ✓ Users should be able to access their profiles\n\n";
}

// Check 5: Test URLs
echo "5. Test URLs:\n";
echo "─────────────────────────────────────────────────\n";
echo "  Roles Management: http://localhost/GitVraj/HrPortal/roles\n";
echo "  Edit Role 4:      http://localhost/GitVraj/HrPortal/roles/4/edit\n";
echo "  User Profile:     http://localhost/GitVraj/HrPortal/profile\n\n";

echo "═══════════════════════════════════════════════════════════\n";
echo "Status check completed!\n";

if ($existCount === 7 && $rolesWithBasic === $totalRoles) {
    echo "✅ Everything looks good!\n";
} else {
    echo "⚠️  Action required - run the setup script\n";
}

echo "═══════════════════════════════════════════════════════════\n";
