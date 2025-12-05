<?php
/**
 * Script to add sample calendar data for testing the employee dashboard calendar
 * Run this from the command line: php add_sample_calendar_data.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

echo "=== Adding Sample Calendar Data for Testing ===\n\n";

// Get the first employee or create sample data for all employees
$employees = Employee::take(5)->get();

if ($employees->isEmpty()) {
    echo "No employees found. Please create employees first.\n";
    exit;
}

$currentMonth = now()->month;
$currentYear = now()->year;

echo "Adding data for " . now()->format('F Y') . "\n\n";

foreach ($employees as $employee) {
    echo "Processing: {$employee->name} (ID: {$employee->id})\n";
    
    // Add sample attendance records for current month
    // Valid statuses: present, absent, half_day, leave
    $attendanceStatuses = ['present', 'present', 'present', 'present', 'present', 'half_day', 'absent', 'leave'];
    
    // Add attendance for past days of current month
    for ($day = 1; $day <= now()->day; $day++) {
        $date = Carbon::create($currentYear, $currentMonth, $day);
        
        // Skip weekends (Saturday = 6, Sunday = 0)
        if ($date->dayOfWeek == 0 || $date->dayOfWeek == 6) {
            continue;
        }
        
        // Check if attendance already exists
        $exists = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $date)
            ->exists();
        
        if (!$exists) {
            // Random status with higher probability of present
            $status = $attendanceStatuses[array_rand($attendanceStatuses)];
            
            // Generate check-in and check-out times
            $checkIn = $date->copy()->setTime(rand(8, 10), rand(0, 59), 0);
            $checkOut = null;
            
            if ($status !== 'absent' && $status !== 'leave') {
                if ($status === 'half_day') {
                    $checkOut = $date->copy()->setTime(rand(12, 14), rand(0, 59), 0);
                } else {
                    $checkOut = $date->copy()->setTime(rand(17, 19), rand(0, 59), 0);
                }
            }
            
            Attendance::create([
                'employee_id' => $employee->id,
                'date' => $date->format('Y-m-d'),
                'check_in' => $checkIn->format('Y-m-d H:i:s'),
                'check_out' => $checkOut ? $checkOut->format('Y-m-d H:i:s') : null,
                'status' => $status,
            ]);
            
            echo "  - Added attendance for {$date->format('d M')}: {$status}\n";
        }
    }
}

// Add sample leaves for some employees
echo "\n--- Adding Sample Leaves ---\n";

$leaveTypes = ['sick', 'casual', 'annual', 'personal'];

// Add a leave for the first employee (current week)
$firstEmployee = $employees->first();
$leaveStart = now()->addDays(2);
$leaveEnd = now()->addDays(4);

$existingLeave = Leave::where('employee_id', $firstEmployee->id)
    ->where('start_date', '<=', $leaveEnd)
    ->where('end_date', '>=', $leaveStart)
    ->exists();

if (!$existingLeave) {
    Leave::create([
        'employee_id' => $firstEmployee->id,
        'leave_type' => 'sick',
        'start_date' => $leaveStart->format('Y-m-d'),
        'end_date' => $leaveEnd->format('Y-m-d'),
        'total_days' => 3,
        'reason' => 'Medical appointment and recovery',
        'status' => 'approved',
        'is_paid' => true,
    ]);
    echo "Added sick leave for {$firstEmployee->name}: {$leaveStart->format('d M')} - {$leaveEnd->format('d M')}\n";
}

// Add another leave for second employee
if ($employees->count() > 1) {
    $secondEmployee = $employees->skip(1)->first();
    $leaveStart2 = now()->addDays(5);
    $leaveEnd2 = now()->addDays(7);
    
    $existingLeave2 = Leave::where('employee_id', $secondEmployee->id)
        ->where('start_date', '<=', $leaveEnd2)
        ->where('end_date', '>=', $leaveStart2)
        ->exists();
    
    if (!$existingLeave2) {
        Leave::create([
            'employee_id' => $secondEmployee->id,
            'leave_type' => 'casual',
            'start_date' => $leaveStart2->format('Y-m-d'),
            'end_date' => $leaveEnd2->format('Y-m-d'),
            'total_days' => 3,
            'reason' => 'Family function',
            'status' => 'approved',
            'is_paid' => true,
        ]);
        echo "Added casual leave for {$secondEmployee->name}: {$leaveStart2->format('d M')} - {$leaveEnd2->format('d M')}\n";
    }
}

// Update some employee birthdays to current month for testing
echo "\n--- Updating Birthdays for Current Month ---\n";

$birthdayDays = [5, 12, 18, 25]; // Days in current month for birthdays

foreach ($employees->take(4) as $index => $employee) {
    if (isset($birthdayDays[$index])) {
        $birthdayDay = $birthdayDays[$index];
        
        // Set birthday to current month (keeping a reasonable birth year)
        $birthYear = now()->year - rand(25, 40);
        $newDob = Carbon::create($birthYear, $currentMonth, $birthdayDay);
        
        $employee->update(['date_of_birth' => $newDob->format('Y-m-d')]);
        echo "Updated {$employee->name}'s birthday to: {$newDob->format('d M Y')}\n";
    }
}

echo "\n=== Sample Data Added Successfully! ===\n";
echo "Now login as an employee and check the dashboard calendar.\n";
