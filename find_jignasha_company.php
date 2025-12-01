<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

// Find the user
$user = DB::table('users')->where('email', 'abccompany510@example.com')->first();

if (!$user) {
    echo "User not found\n";
    exit(1);
}

echo "User: {$user->name} (ID: {$user->id})\n";
echo "Email: {$user->email}\n";
echo "Current Company ID: " . ($user->company_id ?? 'NULL') . "\n\n";

// Find companies that might match
echo "Looking for matching companies...\n\n";

// Check if there's a company with similar name
$companies = DB::table('companies')
    ->where('company_name', 'like', '%jignasha%')
    ->orWhere('company_name', 'like', '%jethava%')
    ->orWhere('company_name', 'like', '%abc%')
    ->orWhere('company_email', 'like', '%abccompany%')
    ->get();

if ($companies->isEmpty()) {
    echo "No matching companies found. Showing all companies:\n";
    $companies = DB::table('companies')->select('id', 'company_name', 'company_email')->get();
}

foreach ($companies as $company) {
    echo "  [{$company->id}] {$company->company_name} ({$company->company_email})\n";
}

// Check if there's a company with email matching pattern
$emailPrefix = explode('@', $user->email)[0]; // abccompany510
$matchingCompany = DB::table('companies')
    ->where('company_email', 'like', $emailPrefix . '%')
    ->first();

if ($matchingCompany) {
    echo "\n✓ Found matching company by email pattern:\n";
    echo "  Company: {$matchingCompany->company_name} (ID: {$matchingCompany->id})\n";
    echo "  Email: {$matchingCompany->company_email}\n\n";
    
    echo "Linking user {$user->id} to company {$matchingCompany->id}...\n";
    DB::table('users')->where('id', $user->id)->update(['company_id' => $matchingCompany->id]);
    echo "✓ Successfully linked!\n";
} else {
    echo "\nNo automatic match found. Please link manually.\n";
}
