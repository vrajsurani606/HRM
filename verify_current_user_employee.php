<?php

/**
 * Verify current user has employee record
 * This helps debug attendance check-in issues
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Employee;

echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║     User-Employee Verification Report                     ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

echo "Checking all users and their employee records...\n";
echo "─────────────────────────────────────────────────\n\n";

$users = User::with('roles')->get();
$stats = [
    'total' => $users->count(),
    'with_employee' => 0,
    'without_employee' => 0,
    'customers' => 0,
];

foreach ($users as $user) {
    $employee = Employee::where('email', $user->email)->first();
    $hasEmployee = $employee !== null;
    $isCustomer = $user->hasRole('customer');
    
    if ($isCustomer) {
        $stats['customers']++;
        $status = '👤 CUSTOMER';
        $icon = '⊘';
    } elseif ($hasEmployee) {
        $stats['with_employee']++;
        $status = "✓ Employee: {$employee->code}";
        $icon = '✓';
    } else {
        $stats['without_employee']++;
        $status = '✗ NO EMPLOYEE RECORD';
        $icon = '✗';
    }
    
    $roles = $user->roles->pluck('name')->join(', ');
    
    echo "{$icon} {$user->email}\n";
    echo "   Role: {$roles}\n";
    echo "   Status: {$status}\n";
    
    if (!$hasEmployee && !$isCustomer) {
        echo "   ⚠️  WARNING: This user cannot check in/out!\n";
    }
    
    echo "\n";
}

echo "═══════════════════════════════════════════════════════════\n";
echo "Summary:\n";
echo "─────────────────────────────────────────────────\n";
echo "  Total Users:              {$stats['total']}\n";
echo "  With Employee Records:    {$stats['with_employee']}\n";
echo "  Without Employee Records: {$stats['without_employee']}\n";
echo "  Customers (skipped):      {$stats['customers']}\n";
echo "═══════════════════════════════════════════════════════════\n\n";

if ($stats['without_employee'] > 0) {
    echo "⚠️  WARNING: {$stats['without_employee']} non-customer users don't have employee records!\n";
    echo "   These users will get 'Employee profile not found' error.\n";
    echo "   Run: php create_missing_employee_records.php\n\n";
} else {
    echo "✅ All non-customer users have employee records!\n";
    echo "   Attendance check-in should work for everyone.\n\n";
}

echo "Test attendance check-in at:\n";
echo "http://localhost/GitVraj/HrPortal/attendance/check\n\n";
