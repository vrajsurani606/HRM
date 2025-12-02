<?php

/**
 * Complete Setup - Profile + Attendance Permissions
 * This ensures all users can access profile and attendance features
 * Run this with: php setup_all_permissions_complete.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Artisan;

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║     Complete Permissions Setup - Profile + Attendance     ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Step 1: Run Permission Seeder
echo "Step 1: Running Permission Seeder...\n";
echo "─────────────────────────────────────────────────\n";

try {
    Artisan::call('db:seed', ['--class' => 'PermissionSeeder', '--force' => true]);
    echo "  ✓ Permission seeder executed successfully\n\n";
} catch (\Exception $e) {
    echo "  ⚠️  Seeder error (continuing): " . $e->getMessage() . "\n\n";
}

// Step 2: Create All Required Permissions
echo "Step 2: Creating All Required Permissions...\n";
echo "─────────────────────────────────────────────────\n";

$allPermissions = [
    // Profile Management
    'Profile Management.view profile',
    'Profile Management.edit profile',
    'Profile Management.update profile',
    'Profile Management.update bank details',
    'Profile Management.delete profile',
    'Profile Management.view own profile',
    'Profile Management.edit own profile',
    
    // Attendance Management
    'Attendance Management.view attendance',
    'Attendance Management.create attendance',
    'Attendance Management.edit attendance',
    'Attendance Management.delete attendance',
    'Attendance Management.manage attendance',
    'Attendance Management.check in',
    'Attendance Management.check out',
    'Attendance Management.view own attendance',
];

$createdCount = 0;
$existingCount = 0;

foreach ($allPermissions as $permissionName) {
    $permission = Permission::firstOrCreate([
        'name' => $permissionName,
        'guard_name' => 'web',
    ]);
    
    if ($permission->wasRecentlyCreated) {
        echo "  ✓ Created: {$permissionName}\n";
        $createdCount++;
    } else {
        $existingCount++;
    }
}

echo "\n  Summary: {$createdCount} created, {$existingCount} already existed\n\n";

// Step 3: Load All Roles
echo "Step 3: Assigning Permissions to All Roles...\n";
echo "─────────────────────────────────────────────────\n";

$allRoles = Role::all();

// Define role-specific permissions
$rolePermissionMap = [
    'super-admin' => [
        // Profile - Full access
        'Profile Management.view profile',
        'Profile Management.edit profile',
        'Profile Management.update profile',
        'Profile Management.update bank details',
        'Profile Management.delete profile',
        'Profile Management.view own profile',
        'Profile Management.edit own profile',
        
        // Attendance - Full access
        'Attendance Management.view attendance',
        'Attendance Management.create attendance',
        'Attendance Management.edit attendance',
        'Attendance Management.delete attendance',
        'Attendance Management.manage attendance',
        'Attendance Management.check in',
        'Attendance Management.check out',
        'Attendance Management.view own attendance',
    ],
    'admin' => [
        // Profile - Full access (no delete)
        'Profile Management.view profile',
        'Profile Management.edit profile',
        'Profile Management.update profile',
        'Profile Management.update bank details',
        'Profile Management.view own profile',
        'Profile Management.edit own profile',
        
        // Attendance - Full access
        'Attendance Management.view attendance',
        'Attendance Management.create attendance',
        'Attendance Management.edit attendance',
        'Attendance Management.delete attendance',
        'Attendance Management.manage attendance',
        'Attendance Management.check in',
        'Attendance Management.check out',
        'Attendance Management.view own attendance',
    ],
    'hr' => [
        // Profile - Own + bank + tabs
        'Profile Management.view own profile',
        'Profile Management.edit own profile',
        'Profile Management.update bank details',
        'Profile Management.view own payroll',
        'Profile Management.view own attendance',
        'Profile Management.view own documents',
        'Profile Management.view own bank details',
        
        // Attendance - Manage + own
        'Attendance Management.view attendance',
        'Attendance Management.create attendance',
        'Attendance Management.edit attendance',
        'Attendance Management.manage attendance',
        'Attendance Management.check in',
        'Attendance Management.check out',
        'Attendance Management.view own attendance',
    ],
    'receptionist' => [
        // Profile - Own + tabs
        'Profile Management.view own profile',
        'Profile Management.edit own profile',
        'Profile Management.view own payroll',
        'Profile Management.view own attendance',
        'Profile Management.view own documents',
        'Profile Management.view own bank details',
        
        // Attendance - Own
        'Attendance Management.check in',
        'Attendance Management.check out',
        'Attendance Management.view own attendance',
        
        // Dashboard
        'Dashboard.view dashboard',
        
        // Inquiries - Full access (front desk handles inquiries)
        'Inquiries Management.view inquiry',
        'Inquiries Management.create inquiry',
        'Inquiries Management.edit inquiry',
        'Inquiries Management.manage inquiry',
        'Inquiries Management.follow up',
        'Inquiries Management.follow up create',
        'Inquiries Management.follow up confirm',
        'Inquiries Management.export inquiry',
        
        // Companies - View only
        'Companies Management.view company',
        
        // Events - View
        'Events Management.view event',
        
        // Tickets - Create and view
        'Tickets Management.view ticket',
        'Tickets Management.create ticket',
    ],
];

// Default permissions for employee-type roles (employee, etc.)
$employeePermissions = [
    // Profile - Own + tabs
    'Profile Management.view own profile',
    'Profile Management.edit own profile',
    'Profile Management.view own payroll',
    'Profile Management.view own attendance',
    'Profile Management.view own documents',
    'Profile Management.view own bank details',
    
    // Attendance - Own only
    'Attendance Management.check in',
    'Attendance Management.check out',
    'Attendance Management.view own attendance',
];

// Default permissions for customer-type roles (customers don't need attendance)
$customerPermissions = [
    // Profile - Own only (no tabs)
    'Profile Management.view own profile',
    'Profile Management.edit own profile',
];

$updated = 0;

foreach ($allRoles as $role) {
    $roleName = $role->name;
    
    // Determine which permissions to assign
    if (isset($rolePermissionMap[$roleName])) {
        $permissions = $rolePermissionMap[$roleName];
        $type = 'SPECIFIC';
    } elseif (strtolower($roleName) === 'customer' || strpos(strtolower($roleName), 'customer') !== false) {
        // Customers get profile only, no attendance
        $permissions = $customerPermissions;
        $type = 'CUSTOMER';
    } else {
        // All other roles (employee, receptionist, etc.) get full default
        $permissions = $employeePermissions;
        $type = 'EMPLOYEE';
    }
    
    // Get existing permissions
    $existingPermissions = $role->permissions->pluck('name')->toArray();
    
    // Filter to only profile and attendance permissions
    $existingRelevantPerms = array_filter($existingPermissions, function($perm) {
        return strpos($perm, 'Profile Management.') === 0 || 
               strpos($perm, 'Attendance Management.') === 0;
    });
    
    // Merge with existing non-profile/attendance permissions
    $otherPermissions = array_filter($existingPermissions, function($perm) {
        return strpos($perm, 'Profile Management.') !== 0 && 
               strpos($perm, 'Attendance Management.') !== 0;
    });
    
    $allPermissions = array_unique(array_merge($otherPermissions, $permissions));
    $role->syncPermissions($allPermissions);
    
    echo "  ✓ {$roleName} - {$type} (" . count($permissions) . " permissions)\n";
    $updated++;
}

echo "\n";

// Step 4: Verification
echo "Step 4: Verifying Setup...\n";
echo "─────────────────────────────────────────────────\n";

$allGood = true;

foreach ($allRoles as $role) {
    $roleName = $role->name;
    $perms = $role->permissions->pluck('name');
    
    $hasProfileView = $perms->contains('Profile Management.view own profile');
    $hasProfileEdit = $perms->contains('Profile Management.edit own profile');
    $hasCheckIn = $perms->contains('Attendance Management.check in');
    $hasCheckOut = $perms->contains('Attendance Management.check out');
    
    $isCustomer = (strtolower($roleName) === 'customer' || strpos(strtolower($roleName), 'customer') !== false);
    
    if ($isCustomer) {
        // Customers only need profile permissions
        if ($hasProfileView && $hasProfileEdit) {
            echo "  ✓ {$roleName}: Profile access ✓ (customer - no attendance needed)\n";
        } else {
            echo "  ✗ {$roleName}: Missing profile permissions!\n";
            $allGood = false;
        }
    } else {
        // Non-customers need profile + attendance
        if ($hasProfileView && $hasProfileEdit && $hasCheckIn && $hasCheckOut) {
            echo "  ✓ {$roleName}: Profile + Attendance ✓\n";
        } else {
            echo "  ✗ {$roleName}: Missing essential permissions!\n";
            $allGood = false;
        }
    }
}

echo "\n";

// Step 5: Summary
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║                    SETUP COMPLETE                          ║\n";
echo "╠════════════════════════════════════════════════════════════╣\n";
echo "║  Total Roles Updated:    " . str_pad($updated, 33) . "║\n";
echo "║  Permissions Created:    " . str_pad($createdCount, 33) . "║\n";
echo "║  Verification:           " . str_pad($allGood ? '✓ PASSED' : '✗ FAILED', 33) . "║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

echo "What Each Role Can Do:\n";
echo "─────────────────────────────────────────────────\n";
echo "  Super Admin & Admin:\n";
echo "    ✓ Full profile management\n";
echo "    ✓ Full attendance management\n";
echo "    ✓ Can check in/out\n";
echo "    ✓ IN/OUT button visible in header\n\n";

echo "  HR:\n";
echo "    ✓ Can manage own profile + bank details\n";
echo "    ✓ Can manage attendance for all\n";
echo "    ✓ Can check in/out\n";
echo "    ✓ IN/OUT button visible in header\n\n";

echo "  Receptionist:\n";
echo "    ✓ Can view/edit own profile\n";
echo "    ✓ Can check in/out\n";
echo "    ✓ Full access to Inquiries (create, edit, follow up)\n";
echo "    ✓ Can view Companies\n";
echo "    ✓ Can create Tickets\n";
echo "    ✓ IN/OUT button visible in header\n\n";

echo "  Employee Role:\n";
echo "    ✓ Can view/edit own profile\n";
echo "    ✓ Can check in/out\n";
echo "    ✓ Can view own attendance\n";
echo "    ✓ IN/OUT button visible in header\n\n";

echo "  Customer Role:\n";
echo "    ✓ Can view/edit own profile\n";
echo "    ✗ No attendance access (customers don't check in/out)\n";
echo "    ✗ IN/OUT button hidden in header\n\n";

if ($allGood) {
    echo "✅ SUCCESS! All permissions are set up correctly.\n";
    echo "   • All users can access their profile\n";
    echo "   • Employees can check in/out (IN/OUT button visible)\n";
    echo "   • Customers have profile access only (no attendance)\n\n";
} else {
    echo "⚠️  WARNING! Some roles may not have correct permissions.\n";
    echo "   Please check the roles page and verify manually.\n\n";
}

echo "Test URLs:\n";
echo "─────────────────────────────────────────────────\n";
echo "  Profile:     http://localhost/GitVraj/HrPortal/profile\n";
echo "  Attendance:  http://localhost/GitVraj/HrPortal/attendance/check\n";
echo "  Roles:       http://localhost/GitVraj/HrPortal/roles\n\n";
