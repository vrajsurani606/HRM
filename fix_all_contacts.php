<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Fixing contact numbers in quotations table...\n\n";

$fields = ['contact_number_1', 'contact_number_2', 'contact_number_3'];
$totalFixed = 0;

foreach ($fields as $field) {
    echo "Processing {$field}...\n";
    
    $quotations = DB::table('quotations')
        ->whereNotNull($field)
        ->where($field, '!=', '')
        ->get(['id', $field]);
    
    $fixed = 0;
    
    foreach ($quotations as $quotation) {
        $value = $quotation->$field;
        
        // Skip if already has country code
        if (preg_match('/^\+\d/', $value)) {
            continue;
        }
        
        // Extract only digits
        $digits = preg_replace('/\D/', '', $value);
        
        // Skip if not 10 digits
        if (strlen($digits) != 10) {
            echo "  ID {$quotation->id}: Skipped (not 10 digits: {$digits})\n";
            continue;
        }
        
        // Add +91 prefix
        $newValue = '+91' . $digits;
        
        DB::table('quotations')
            ->where('id', $quotation->id)
            ->update([$field => $newValue]);
        
        echo "  ID {$quotation->id}: {$value} -> {$newValue}\n";
        $fixed++;
    }
    
    echo "  Fixed {$fixed} records for {$field}\n\n";
    $totalFixed += $fixed;
}

echo "Total fixed: {$totalFixed}\n";
echo "Done!\n";
