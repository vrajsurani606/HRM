<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "=== Assigning Default Permissions to HR Role ===\n\n";

// Find or create HR role
$hrRole = Role::firstOrCreate(
    ['name' => 'hr', 'guard_name' => 'web'],
    ['description' => 'HR Manager with employee, attendance, payroll, and leave management access']
);

echo "HR Role: {$hrRole->name} (ID: {$hrRole->id})\n\n";

// Define permissions that HR should have
$hrPermissions = [
    // Dashboard
    'Dashboard.view dashboard',
    
    // Employees Management - Full Access
    'Employees Management.view employee',
    'Employees Management.create employee',
    'Employees Management.edit employee',
    'Employees Management.delete employee',
    'Employees Management.manage employee',
    'Employees Management.letters',
    'Employees Management.letters create',
    'Employees Management.letters view',
    'Employees Management.letters edit',
    'Employees Management.letters delete',
    'Employees Management.letters print',
    'Employees Management.digital card',
    'Employees Management.digital card create',
    'Employees Management.digital card edit',
    'Employees Management.digital card delete',
    
    // Attendance Management - Full Access
    'Attendance Management.view attendance',
    'Attendance Management.create attendance',
    'Attendance Management.edit attendance',
    'Attendance Management.delete attendance',
    'Attendance Management.manage attendance',
    
    // Payroll Management - Full Access
    'Payroll Management.view payroll',
    'Payroll Management.create payroll',
    'Payroll Management.edit payroll',
    'Payroll Management.delete payroll',
    'Payroll Management.manage payroll',
    'Payroll Management.export payroll',
    'Payroll Management.print payroll',
    'Payroll Management.bulk generate payroll',
    
    // Leads Management - View and Manage
    'Leads Management.view lead',
    'Leads Management.create lead',
    'Leads Management.edit lead',
    'Leads Management.delete lead',
    'Leads Management.manage lead',
    'Leads Management.print lead',
    'Leads Management.convert lead',
    'Leads Management.offer letter',
    'Leads Management.view resume',
    
    // Events Management - View and Manage
    'Events Management.view event',
    'Events Management.create event',
    'Events Management.edit event',
    'Events Management.delete event',
    'Events Management.manage event',
    'Events Management.upload event image',
    'Events Management.download event image',
    'Events Management.view event image',
    'Events Management.delete event image',
    
    // Tickets Management - View and Respond
    'Tickets Management.view ticket',
    'Tickets Management.create ticket',
    'Tickets Management.edit ticket',
    'Tickets Management.assign ticket',
    'Tickets Management.reassign ticket',
    'Tickets Management.change status',
    'Tickets Management.change priority',
    'Tickets Management.change work status',
    'Tickets Management.view comments',
    'Tickets Management.create comment',
    'Tickets Management.view attachments',
    'Tickets Management.upload attachment',
    'Tickets Management.download attachment',
    'Tickets Management.close ticket',
    'Tickets Management.reopen ticket',
    
    // Reports Management - View Reports
    'Reports Management.view report',
    'Reports Management.create report',
    'Reports Management.manage report',
    
    // Rules Management - View Rules
    'Rules Management.view rules',
];

echo "Assigning permissions:\n";

$assignedCount = 0;
$alreadyAssignedCount = 0;
$notFoundCount = 0;

foreach ($hrPermissions as $permissionName) {
    $permission = Permission::where('name', $permissionName)->first();
    
    if ($permission) {
        if (!$hrRole->hasPermissionTo($permission)) {
            $hrRole->givePermissionTo($permission);
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
echo "\n=== All HR Role Permissions (Grouped by Module) ===\n";
$allPermissions = $hrRole->permissions()->pluck('name')->toArray();
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
