<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "=== Assigning Default Permissions to Customer Role ===\n\n";

// Find or create customer role
$customerRole = Role::firstOrCreate(
    ['name' => 'customer', 'guard_name' => 'web'],
    ['description' => 'Customer with limited access to their own data']
);

echo "Customer Role: {$customerRole->name} (ID: {$customerRole->id})\n\n";

// Define permissions that customers should have
$customerPermissions = [
    // Dashboard
    'Dashboard.view dashboard',
    
    // Projects - View only their company's projects
    'Projects Management.view project',
    'Projects Management.project overview',
    'Projects Management.view tasks',
    'Projects Management.view members',
    'Projects Management.view comments',
    'Projects Management.create comment',
    'Projects Management.view attachments',
    'Projects Management.download attachment',
    
    // Tickets - Create and view their own tickets
    'Tickets Management.view ticket',
    'Tickets Management.create ticket',
    'Tickets Management.edit ticket',
    'Tickets Management.view comments',
    'Tickets Management.create comment',
    'Tickets Management.view attachments',
    'Tickets Management.upload attachment',
    'Tickets Management.download attachment',
    
    // Quotations - View their company's quotations
    'Quotations Management.view quotation',
    'Quotations Management.download quotation',
    'Quotations Management.print quotation',
    
    // Invoices - View their company's invoices
    'Invoices Management.view invoice',
    'Invoices Management.print invoice',
    
    // Receipts - View their company's receipts
    'Receipts Management.view receipt',
    'Receipts Management.print receipt',
];

echo "Assigning permissions:\n";

$assignedCount = 0;
$notFoundCount = 0;

foreach ($customerPermissions as $permissionName) {
    $permission = Permission::where('name', $permissionName)->first();
    
    if ($permission) {
        if (!$customerRole->hasPermissionTo($permission)) {
            $customerRole->givePermissionTo($permission);
            echo "  ✓ {$permissionName}\n";
            $assignedCount++;
        } else {
            echo "  - {$permissionName} (already assigned)\n";
        }
    } else {
        echo "  ✗ {$permissionName} (permission not found)\n";
        $notFoundCount++;
    }
}

echo "\n=== Summary ===\n";
echo "Newly assigned: {$assignedCount}\n";
echo "Already assigned: " . (count($customerPermissions) - $assignedCount - $notFoundCount) . "\n";
echo "Not found: {$notFoundCount}\n";

// Show all current permissions
echo "\n=== All Customer Role Permissions ===\n";
$allPermissions = $customerRole->permissions()->pluck('name')->toArray();
sort($allPermissions);

foreach ($allPermissions as $perm) {
    echo "  • {$perm}\n";
}

echo "\nTotal permissions: " . count($allPermissions) . "\n";
echo "\nDone!\n";
