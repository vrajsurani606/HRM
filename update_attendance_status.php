<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;

echo "Updating attendance statuses...\n";

$employees = Employee::take(3)->get();

foreach ($employees as $index => $employee) {
    echo "Employee: {$employee->name}\n";
    
    // Update some entries to late
    $updated = Attendance::where('employee_id', $employee->id)
        ->where('status', 'present')
        ->limit(1)
        ->update(['status' => 'late']);
    
    if ($updated) {
        echo "  - Updated 1 entry to 'late'\n";
    }
    
    // Update some entries to early_leave
    $updated2 = Attendance::where('employee_id', $employee->id)
        ->where('status', 'present')
        ->limit(1)
        ->update(['status' => 'early_leave']);
    
    if ($updated2) {
        echo "  - Updated 1 entry to 'early_leave'\n";
    }
}

echo "\nDone! Check the calendar now.\n";
