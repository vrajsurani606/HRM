<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Linking Employee Users to Companies ===\n\n";

// Find employee users that are not linked
$employeeUsers = DB::table('users')
    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
    ->where('roles.name', 'customer')
    ->where('users.name', 'like', '%(Employee)%')
    ->whereNull('users.company_id')
    ->select('users.id', 'users.name', 'users.email')
    ->get();

echo "Found " . $employeeUsers->count() . " unlinked employee users\n\n";

$linked = 0;

foreach ($employeeUsers as $user) {
    echo "Processing: {$user->name} ({$user->email})\n";
    
    // Extract company identifier from email
    // Format: companyname + "emp" + number + "@example.com"
    // Example: chitrienlargeemp490@example.com → chitrienlarge
    
    $emailPrefix = explode('@', $user->email)[0];
    
    // Remove "emp" and numbers from the end
    $companyPrefix = preg_replace('/emp\d+$/', '', $emailPrefix);
    
    echo "  Looking for company with email like: {$companyPrefix}%\n";
    
    // Find matching company
    $company = DB::table('companies')
        ->where('company_email', 'like', $companyPrefix . '%')
        ->first();
    
    if ($company) {
        DB::table('users')->where('id', $user->id)->update(['company_id' => $company->id]);
        echo "  ✓ Linked to: {$company->company_name} (ID: {$company->id})\n";
        $linked++;
    } else {
        echo "  ✗ No matching company found\n";
    }
    
    echo "\n";
}

echo "=== Summary ===\n";
echo "Linked: {$linked} employee users\n";
