<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Linking Users to Companies ===\n\n";

// Get all companies
$companies = DB::table('companies')->select('id', 'company_name', 'company_email')->get();
echo "Found " . $companies->count() . " companies:\n";
foreach ($companies as $company) {
    echo "  {$company->id} - {$company->company_name} ({$company->company_email})\n";
}

echo "\n";

// Get all customer users
$customerUsers = DB::table('users')
    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
    ->where('roles.name', 'customer')
    ->orWhere('roles.name', 'client')
    ->orWhere('roles.name', 'company')
    ->select('users.id', 'users.name', 'users.email', 'users.company_id')
    ->distinct()
    ->get();

echo "Found " . $customerUsers->count() . " customer users:\n";
foreach ($customerUsers as $user) {
    $companyStatus = $user->company_id ? "Linked to Company ID: {$user->company_id}" : "NOT LINKED";
    echo "  {$user->id} - {$user->name} ({$user->email}) - {$companyStatus}\n";
}

echo "\n=== Link Users to Companies ===\n";
echo "Enter user ID and company ID to link (format: user_id,company_id)\n";
echo "Or type 'auto' to auto-link by email matching\n";
echo "Or type 'done' to finish\n\n";

while (true) {
    echo "> ";
    $input = trim(fgets(STDIN));
    
    if ($input === 'done') {
        break;
    }
    
    if ($input === 'auto') {
        echo "Auto-linking users to companies by email...\n";
        $linked = 0;
        
        foreach ($customerUsers as $user) {
            if ($user->company_id) {
                echo "  User {$user->id} ({$user->name}) already linked to company {$user->company_id}\n";
                continue;
            }
            
            // Try to find company by email
            $company = $companies->first(function($c) use ($user) {
                return strtolower($c->company_email) === strtolower($user->email);
            });
            
            if ($company) {
                DB::table('users')->where('id', $user->id)->update(['company_id' => $company->id]);
                echo "  ✓ Linked user {$user->id} ({$user->name}) to company {$company->id} ({$company->company_name})\n";
                $linked++;
            } else {
                echo "  ✗ No matching company found for user {$user->id} ({$user->name} - {$user->email})\n";
            }
        }
        
        echo "\nAuto-linked {$linked} users\n\n";
        continue;
    }
    
    $parts = explode(',', $input);
    if (count($parts) !== 2) {
        echo "Invalid format. Use: user_id,company_id\n";
        continue;
    }
    
    $userId = trim($parts[0]);
    $companyId = trim($parts[1]);
    
    // Validate user exists
    $user = DB::table('users')->where('id', $userId)->first();
    if (!$user) {
        echo "User ID {$userId} not found\n";
        continue;
    }
    
    // Validate company exists
    $company = DB::table('companies')->where('id', $companyId)->first();
    if (!$company) {
        echo "Company ID {$companyId} not found\n";
        continue;
    }
    
    // Link user to company
    DB::table('users')->where('id', $userId)->update(['company_id' => $companyId]);
    echo "✓ Linked user {$userId} ({$user->name}) to company {$companyId} ({$company->company_name})\n\n";
}

echo "\n=== Final Status ===\n";
$customerUsers = DB::table('users')
    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
    ->where('roles.name', 'customer')
    ->orWhere('roles.name', 'client')
    ->orWhere('roles.name', 'company')
    ->select('users.id', 'users.name', 'users.email', 'users.company_id')
    ->distinct()
    ->get();

foreach ($customerUsers as $user) {
    if ($user->company_id) {
        $company = DB::table('companies')->where('id', $user->company_id)->first();
        echo "  ✓ {$user->name} ({$user->email}) → {$company->company_name}\n";
    } else {
        echo "  ✗ {$user->name} ({$user->email}) → NOT LINKED\n";
    }
}

echo "\nDone!\n";
