<?php
// Test conversion form loading
require_once 'vendor/autoload.php';

use App\Models\HiringLead;
use App\Models\Employee;

try {
    // Test if we can find a hiring lead
    $lead = HiringLead::find(1);
    echo "Lead found: " . ($lead ? $lead->person_name : 'Not found') . "\n";
    
    // Test nextCode generation
    $nextCode = Employee::nextCode();
    echo "Next code: " . $nextCode . "\n";
    
    echo "Test passed!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}