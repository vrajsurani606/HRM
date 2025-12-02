<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "=== Assigning Default Permissions to Employee Role ===\n\n";

// Find or create Employee role
$employeeRole = Role::firstOrCreate(
    ['name' => 'employee', 'guard_name' => 'web'],
    ['description' => 'Employee with access to their own data, attendance, and assigned projects']
);

echo "Employee Role: {$employeeRole->name} (ID: {$employeeRole->id})\n\n";

// Define permissions that employees should have
$employeePermissions = [
    // Dashboard
    'Dashboard.view dashboard',
    
    // Projects - View projects they're assigned to
    'Projects Management.view project',
    'Projects Management.project overview',
    'Projects Management.view tasks',
    'Projects Management.view members',
    'Projects Management.view comments',
    'Projects Management.create comment',
    'Projects Management.view attachments',
    'Projects Management.download attachment',
    'Projects Management.complete task',
    
    // Tickets - Create and view their own tickets
    'Tickets Management.view ticket',
    'Tickets Management.create ticket',
    'Tickets Management.edit ticket',
    'Tickets Management.view comments',
    'Tickets Management.create comment',
    'Tickets Management.view attachments',
    'Tickets Management.upload attachment',
    'Tickets Management.download attachment',
    
    // Attendance - View their own attendance
    'Attendance Management.view attendance',
    
    // Events - View company events
    'Events Management.view event',
    'Events Management.view event image',
    'Events Management.download event image',
    
    // Rules - View company rules
    'Rules Management.view rules',
];

echo "Assigning permissions:\n";

$assignedCount = 0;
$alreadyAssignedCount = 0;
$notFoundCount = 0;

foreach ($employeePermissions as $permissionName) {
    $permission = Permission::where('name', $permissionName)->first();
    
    if ($permission) {
        if (!$employeeRole->hasPermissionTo($permission)) {
            $employeeRole->givePermissionTo($permission);
            echo "  ✓ {$permissionName}\n";
            $assignedCount++;
        } else {
            echo "  - {$permissionName} (already assigned)\n";
            $alreadyAssignedCount++;
        }
    } else {
        echo "  ✗ {$permissionName} (permission not found)\n";
        $notFoundCount++;
    }
}

echo "\n=== Summary ===\n";
echo "Newly assigned: {$assignedCount}\n";
echo "Already assigned: {$alreadyAssignedCount}\n";
echo "Not found: {$notFoundCount}\n";

// Show all current permissions grouped by module
echo "\n=== All Employee Role Permissions (Grouped by Module) ===\n";
$allPermissions = $employeeRole->permissions()->pluck('name')->toArray();
sort($allPermissions);

// Group permissions by module
$groupedPermissions = [];
foreach ($allPermissions as $perm) {
    $parts = explode('.', $perm);
    $module = $parts[0] ?? 'Other';
    if (!isset($groupedPermissions[$module])) {
        $groupedPermissions[$module] = [];
    }
    $groupedPermissions[$module][] = $perm;
}

foreach ($groupedPermissions as $module => $perms) {
    echo "\n{$module} (" . count($perms) . "):\n";
    foreach ($perms as $perm) {
        echo "  • {$perm}\n";
    }
}

echo "\n=== Total Permissions: " . count($allPermissions) . " ===\n";
echo "\nDone!\n";
