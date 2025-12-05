<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$email = 'dipeshbhai@company.com';

// Find user
$user = \App\Models\User::where('email', $email)->first();
if (!$user) {
    echo "User not found with email: $email\n";
    exit;
}

echo "=== USER INFO ===\n";
echo "User ID: " . $user->id . "\n";
echo "User Email: " . $user->email . "\n";
echo "User Name: " . $user->name . "\n";
echo "User Roles: " . $user->getRoleNames()->implode(', ') . "\n";

// Check if admin
$isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
echo "Is Admin: " . ($isAdmin ? 'YES' : 'NO') . "\n";

// Find employee record
echo "\n=== EMPLOYEE RECORD ===\n";
$empByUserId = \App\Models\Employee::where('user_id', $user->id)->first();
$empByEmail = \App\Models\Employee::where('email', $user->email)->first();

if ($empByUserId) {
    echo "Employee found by user_id:\n";
    echo "  Employee ID: " . $empByUserId->id . "\n";
    echo "  Employee Name: " . $empByUserId->name . "\n";
    echo "  Employee Email: " . $empByUserId->email . "\n";
} else {
    echo "No employee found by user_id\n";
}

if ($empByEmail) {
    echo "Employee found by email:\n";
    echo "  Employee ID: " . $empByEmail->id . "\n";
    echo "  Employee Name: " . $empByEmail->name . "\n";
} else {
    echo "No employee found by email\n";
}

// Check tickets assigned to this employee
echo "\n=== TICKETS ===\n";
$employee = $empByUserId ?? $empByEmail;
if ($employee) {
    $assignedTickets = \App\Models\Ticket::where('assigned_to', $employee->id)->get();
    echo "Tickets assigned to employee ID " . $employee->id . ": " . $assignedTickets->count() . "\n";
    foreach ($assignedTickets as $ticket) {
        echo "  - Ticket #" . $ticket->id . ": " . $ticket->title . "\n";
    }
} else {
    echo "No employee record - cannot check assigned tickets\n";
}

// Show all tickets and their assigned_to values
echo "\n=== ALL TICKETS (first 10) ===\n";
$allTickets = \App\Models\Ticket::take(10)->get();
foreach ($allTickets as $ticket) {
    echo "Ticket #" . $ticket->id . " - assigned_to: " . ($ticket->assigned_to ?? 'NULL') . " - " . ($ticket->title ?? $ticket->subject) . "\n";
}

// Check permissions
echo "\n=== USER PERMISSIONS ===\n";
$permissions = $user->getAllPermissions()->pluck('name');
echo "Total permissions: " . $permissions->count() . "\n";
$ticketPermissions = $permissions->filter(function($p) { return str_contains(strtolower($p), 'ticket'); });
echo "Ticket-related permissions:\n";
foreach ($ticketPermissions as $p) {
    echo "  - $p\n";
}

// Simulate the query
echo "\n=== SIMULATING TICKET QUERY ===\n";
$isAdmin = $user->hasRole('super-admin') || $user->hasRole('hr') || $user->hasRole('admin');
echo "isAdmin: " . ($isAdmin ? 'YES' : 'NO') . "\n";

$employeeRecord = \App\Models\Employee::where('user_id', $user->id)->orWhere('email', $user->email)->first();
$isEmployee = $user->hasRole('employee') || $user->hasRole('Employee') || $employeeRecord;
echo "isEmployee: " . ($isEmployee ? 'YES' : 'NO') . "\n";
echo "employeeRecord: " . ($employeeRecord ? 'ID=' . $employeeRecord->id : 'NULL') . "\n";

$isCustomer = $user->hasRole('customer') && $user->company_id;
echo "isCustomer: " . ($isCustomer ? 'YES' : 'NO') . "\n";

if (!$isAdmin) {
    if ($isCustomer) {
        echo "Filter: Customer filter applied\n";
    } elseif ($isEmployee && $employeeRecord) {
        echo "Filter: Employee filter applied - assigned_to = " . $employeeRecord->id . "\n";
        $count = \App\Models\Ticket::where('assigned_to', $employeeRecord->id)->count();
        echo "Tickets matching filter: $count\n";
    } else {
        echo "Filter: No tickets (assigned_to = -1)\n";
    }
} else {
    echo "Filter: NONE (admin sees all)\n";
}
