<?php

/**
 * Script to create employee records for existing users who don't have them
 * Run this with: php create_missing_employee_records.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Employee;

echo "Creating missing employee records...\n\n";

$users = User::all();
$created = 0;
$skipped = 0;

foreach ($users as $user) {
    // Skip if employee record already exists
    if (Employee::where('email', $user->email)->exists()) {
        echo "✓ Employee record already exists for: {$user->email}\n";
        $skipped++;
        continue;
    }
    
    // Skip customers
    if ($user->hasRole('customer')) {
        echo "⊘ Skipping customer: {$user->email}\n";
        $skipped++;
        continue;
    }
    
    // Determine position based on role
    $position = 'Employee';
    if ($user->hasRole('super-admin')) {
        $position = 'Super Administrator';
    } elseif ($user->hasRole('admin')) {
        $position = 'Administrator';
    } elseif ($user->hasRole('hr')) {
        $position = 'HR Manager';
    } elseif ($user->hasRole('receptionist')) {
        $position = 'Receptionist';
    }
    
    // Create employee record
    $employee = Employee::create([
        'code' => Employee::nextCode(),
        'name' => $user->name,
        'email' => $user->email,
        'mobile_no' => $user->mobile_no,
        'address' => $user->address,
        'position' => $position,
        'gender' => 'male',
        'status' => 'active',
        'joining_date' => now(),
        'user_id' => $user->id,
    ]);
    
    echo "✓ Created employee record for: {$user->email} (Code: {$employee->code})\n";
    $created++;
}

echo "\n";
echo "========================================\n";
echo "Summary:\n";
echo "  Created: {$created}\n";
echo "  Skipped: {$skipped}\n";
echo "  Total:   " . ($created + $skipped) . "\n";
echo "========================================\n";
