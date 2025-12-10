<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Employee Ticket Debug ===\n\n";

// Get all employees
$employees = \App\Models\Employee::all();
echo "Total Employees: " . $employees->count() . "\n\n";

foreach ($employees as $emp) {
    echo "Employee ID: {$emp->id}\n";
    echo "Name: {$emp->name}\n";
    echo "Email: {$emp->email}\n";
    echo "User ID: " . ($emp->user_id ?? 'NULL') . "\n";
    
    // Find tickets assigned to this employee
    $tickets = \App\Models\Ticket::where('assigned_to', $emp->id)->get();
    echo "Assigned Tickets: " . $tickets->count() . "\n";
    
    if ($tickets->count() > 0) {
        foreach ($tickets as $ticket) {
            echo "  - Ticket #{$ticket->id}: {$ticket->title}\n";
        }
    }
    
    echo str_repeat("-", 60) . "\n";
}
