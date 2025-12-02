<?php

/**
 * Setup Attendance Check-In/Out Permissions
 * Run this with: php setup_attendance_permissions.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Artisan;

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║     Attendance Check-In/Out Permissions Setup             ║\n";
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

// Step 2: Create Attendance Permissions
echo "Step 2: Creating Attendance Permissions...\n";
echo "─────────────────────────────────────────────────\n";

$attendancePermissions = [
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

foreach ($attendancePermissions as $permissionName) {
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
echo "Step 3: Assigning Permissions to Roles...\n";
echo "─────────────────────────────────────────────────\n";

$allRoles = Role::all();

// Define role-specific permissions
$rolePermissionMap = [
    'super-admin' => [
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
        'Attendance Management.view attendance',
        'Attendance Management.create attendance',
        'Attendance Management.edit attendance',
        'Attendance Management.manage attendance',
        'Attendance Management.check in',
        'Attendance Management.check out',
        'Attendance Management.view own attendance',
    ],
];

// Default permissions for all other roles (employee, receptionist, customer)
$defaultPermissions = [
    'Attendance Management.check in',
    'Attendance Management.check out',
    'Attendance Management.view own attendance',
];

$updated = 0;

foreach ($allRoles as $role) {
    $roleName = $role->name;
    
    // Determine which permissions to assign
    if (isset($rolePermissionMap[$roleName])) {
        $permissions = $rolePermissionMap[$roleName];
        $type = 'SPECIFIC';
    } else {
        $permissions = $defaultPermissions;
        $type = 'DEFAULT';
    }
    
    // Get existing permissions
    $existingPermissions = $role->permissions->pluck('name')->toArray();
    
    // Filter to only attendance permissions
    $existingAttendancePerms = array_filter($existingPermissions, function($perm) {
        return strpos($perm, 'Attendance Management.') === 0;
    });
    
    // Merge with existing non-attendance permissions
    $otherPermissions = array_filter($existingPermissions, function($perm) {
        return strpos($perm, 'Attendance Management.') !== 0;
    });
    
    $allPermissions = array_unique(array_merge($otherPermissions, $permissions));
    $role->syncPermissions($allPermissions);
    
    echo "  ✓ {$roleName} - {$type} (" . count($permissions) . " attendance permissions)\n";
    $updated++;
}

echo "\n";

// Step 4: Verification
echo "Step 4: Verifying Setup...\n";
echo "─────────────────────────────────────────────────\n";

foreach ($allRoles as $role) {
    $roleName = $role->name;
    $attendancePerms = $role->permissions->filter(function($perm) {
        return strpos($perm->name, 'Attendance Management.') === 0;
    });
    
    $hasCheckIn = $attendancePerms->contains('name', 'Attendance Management.check in');
    $hasCheckOut = $attendancePerms->contains('name', 'Attendance Management.check out');
    
    if ($hasCheckIn && $hasCheckOut) {
        echo "  ✓ {$roleName}: Can check in/out ✓\n";
    } else {
        echo "  ⚠️  {$roleName}: Missing check-in/out permissions!\n";
    }
}

echo "\n";

// Step 5: Summary
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║                    SETUP COMPLETE                          ║\n";
echo "╠════════════════════════════════════════════════════════════╣\n";
echo "║  Total Roles Updated:    " . str_pad($updated, 33) . "║\n";
echo "║  Permissions Created:    " . str_pad($createdCount, 33) . "║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

echo "Permission Breakdown:\n";
echo "─────────────────────────────────────────────────\n";
echo "  Super Admin & Admin:\n";
echo "    ✓ Full attendance management\n";
echo "    ✓ Can check in/out\n";
echo "    ✓ Can view all attendance\n\n";

echo "  HR:\n";
echo "    ✓ Can manage attendance\n";
echo "    ✓ Can check in/out\n";
echo "    ✓ Can view all attendance\n\n";

echo "  All Other Roles (Employee, Receptionist, Customer):\n";
echo "    ✓ Can check in\n";
echo "    ✓ Can check out\n";
echo "    ✓ Can view own attendance\n\n";

echo "✅ SUCCESS! Attendance check-in/out is now protected with permissions.\n";
echo "   All users can check in/out at: http://localhost/GitVraj/HrPortal/attendance/check\n\n";
