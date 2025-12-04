<?php
/**
 * Add test data for calendar events
 * Run: php add_calendar_test_data.php
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Employee;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

echo "=== Adding Calendar Test Data ===\n\n";

// Get current month
$currentMonth = now()->month;
$currentYear = now()->year;

// 1. Update some employees with birthdays in current month
echo "1. Setting birthdays for current month...\n";
$employees = Employee::take(5)->get();
$day = 5;
foreach ($employees as $emp) {
    $birthday = Carbon::create(1990, $currentMonth, $day);
    $emp->date_of_birth = $birthday;
    $emp->save();
    echo "   - {$emp->name}: Birthday set to {$birthday->format('M d')}\n";
    $day += 5;
}

// 2. Update some employees with joining dates for work anniversaries
echo "\n2. Setting joining dates for work anniversaries...\n";
$employees = Employee::skip(2)->take(3)->get();
$day = 8;
foreach ($employees as $emp) {
    // Set joining date to same month but 1-3 years ago
    $yearsAgo = rand(1, 3);
    $joiningDate = Carbon::create($currentYear - $yearsAgo, $currentMonth, $day);
    $emp->joining_date = $joiningDate;
    $emp->save();
    echo "   - {$emp->name}: Joined on {$joiningDate->format('M d, Y')} ({$yearsAgo} year(s) ago)\n";
    $day += 7;
}

// 3. Add some leaves with different statuses
echo "\n3. Adding leave requests...\n";

// Check if leaves table exists
if (!DB::getSchemaBuilder()->hasTable('leaves')) {
    echo "   Leaves table doesn't exist. Skipping leave data.\n";
} else {
    $employees = Employee::take(6)->get();
    
    // Approved leave
    if (isset($employees[0])) {
        $leave = Leave::create([
            'employee_id' => $employees[0]->id,
            'leave_type' => 'annual',
            'start_date' => Carbon::create($currentYear, $currentMonth, 10),
            'end_date' => Carbon::create($currentYear, $currentMonth, 12),
            'reason' => 'Family vacation',
            'status' => 'approved'
        ]);
        echo "   - {$employees[0]->name}: Approved leave (10th-12th)\n";
    }
    
    // Pending leave
    if (isset($employees[1])) {
        $leave = Leave::create([
            'employee_id' => $employees[1]->id,
            'leave_type' => 'sick',
            'start_date' => Carbon::create($currentYear, $currentMonth, 15),
            'end_date' => Carbon::create($currentYear, $currentMonth, 16),
            'reason' => 'Medical appointment',
            'status' => 'pending'
        ]);
        echo "   - {$employees[1]->name}: Pending leave (15th-16th)\n";
    }
    
    // Rejected leave
    if (isset($employees[2])) {
        $leave = Leave::create([
            'employee_id' => $employees[2]->id,
            'leave_type' => 'casual',
            'start_date' => Carbon::create($currentYear, $currentMonth, 20),
            'end_date' => Carbon::create($currentYear, $currentMonth, 20),
            'reason' => 'Personal work',
            'status' => 'rejected'
        ]);
        echo "   - {$employees[2]->name}: Rejected leave (20th)\n";
    }
    
    // Another approved leave
    if (isset($employees[3])) {
        $leave = Leave::create([
            'employee_id' => $employees[3]->id,
            'leave_type' => 'annual',
            'start_date' => Carbon::create($currentYear, $currentMonth, 5),
            'end_date' => Carbon::create($currentYear, $currentMonth, 5),
            'reason' => 'Personal day',
            'status' => 'approved'
        ]);
        echo "   - {$employees[3]->name}: Approved leave (5th)\n";
    }
    
    // Multiple events on same day
    if (isset($employees[4])) {
        $leave = Leave::create([
            'employee_id' => $employees[4]->id,
            'leave_type' => 'sick',
            'start_date' => Carbon::create($currentYear, $currentMonth, 5),
            'end_date' => Carbon::create($currentYear, $currentMonth, 6),
            'reason' => 'Not feeling well',
            'status' => 'pending'
        ]);
        echo "   - {$employees[4]->name}: Pending leave (5th-6th) - same day as birthday!\n";
    }
}

echo "\n=== Calendar Test Data Added Successfully! ===\n";
echo "\nNow refresh the employee dashboard to see:\n";
echo "- Birthdays (teal color)\n";
echo "- Work Anniversaries (orange color)\n";
echo "- Approved Leaves (green color)\n";
echo "- Pending Leaves (yellow/amber color)\n";
echo "- Rejected Leaves (red color)\n";
echo "- '+X more' popup when more than 3 events on a day\n";
