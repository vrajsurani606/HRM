<?php

/**
 * Add "upload documents" permission to Profile Management
 * Run this script: php add_upload_documents_permission.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

try {
    // Create the permission
    $permission = Permission::firstOrCreate([
        'name' => 'Profile Management.upload documents',
        'guard_name' => 'web',
    ]);

    echo "✓ Permission 'Profile Management.upload documents' created/verified\n";

    // Assign to super-admin role
    $superAdmin = Role::where('name', 'super-admin')->first();
    if ($superAdmin) {
        $superAdmin->givePermissionTo($permission);
        echo "✓ Permission assigned to super-admin role\n";
    }

    // Assign to employee role (so employees can upload their own documents)
    $employee = Role::where('name', 'employee')->first();
    if ($employee) {
        $employee->givePermissionTo($permission);
        echo "✓ Permission assigned to employee role\n";
    }

    // Assign to hr role
    $hr = Role::where('name', 'hr')->first();
    if ($hr) {
        $hr->givePermissionTo($permission);
        echo "✓ Permission assigned to hr role\n";
    }

    echo "\n✓ Upload documents permission setup complete!\n";

} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
