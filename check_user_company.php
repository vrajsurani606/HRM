<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

if ($argc < 2) {
    echo "Usage: php check_user_company.php <user_id>\n";
    echo "Example: php check_user_company.php 26\n";
    exit(1);
}

$userId = $argv[1];

echo "=== User-Company Linkage Check ===\n\n";

// Get user
$user = DB::table('users')->where('id', $userId)->first();

if (!$user) {
    echo "❌ User ID {$userId} not found\n";
    exit(1);
}

echo "User Information:\n";
echo "  ID: {$user->id}\n";
echo "  Name: {$user->name}\n";
echo "  Email: {$user->email}\n";
echo "  Company ID: " . ($user->company_id ?? 'NULL (NOT LINKED)') . "\n";
echo "\n";

// Get user roles
$roles = DB::table('model_has_roles')
    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
    ->where('model_has_roles.model_id', $userId)
    ->where('model_has_roles.model_type', 'App\\Models\\User')
    ->pluck('roles.name')
    ->toArray();

echo "Roles: " . (empty($roles) ? 'None' : implode(', ', $roles)) . "\n";
echo "\n";

if ($user->company_id) {
    // Get company
    $company = DB::table('companies')->where('id', $user->company_id)->first();
    
    if ($company) {
        echo "✅ Linked Company:\n";
        echo "  ID: {$company->id}\n";
        echo "  Name: {$company->company_name}\n";
        echo "  Email: {$company->company_email}\n";
        echo "\n";
        
        // Get company's projects
        $projects = DB::table('projects')
            ->where('company_id', $company->id)
            ->get();
        
        echo "Company Projects ({$projects->count()}):\n";
        if ($projects->isEmpty()) {
            echo "  No projects found for this company\n";
        } else {
            foreach ($projects as $project) {
                $status = $project->status ?? 'unknown';
                $statusIcon = in_array($status, ['active', 'in_progress']) ? '🟢' : '🔵';
                echo "  {$statusIcon} [{$project->id}] {$project->name} - Status: {$status}\n";
            }
        }
        echo "\n";
        
        // Get company's quotations (using customer_id)
        try {
            $quotations = DB::table('quotations')
                ->where('customer_id', $company->id)
                ->count();
            echo "Company Quotations: {$quotations}\n";
        } catch (\Exception $e) {
            echo "Company Quotations: Unable to fetch (table may not exist)\n";
        }
        
        // Get company's invoices (using company_name)
        try {
            $invoices = DB::table('invoices')
                ->where('company_name', $company->company_name)
                ->count();
            echo "Company Invoices: {$invoices}\n";
        } catch (\Exception $e) {
            echo "Company Invoices: Unable to fetch (table may not exist)\n";
        }
        
    } else {
        echo "⚠️ Company ID {$user->company_id} not found in database\n";
    }
} else {
    echo "❌ User is NOT linked to any company\n";
    echo "\nTo link this user to a company, run:\n";
    echo "  php artisan users:link-companies --user={$userId} --company=<company_id>\n";
    echo "\nOr use auto-link:\n";
    echo "  php artisan users:link-companies --auto\n";
    echo "\nAvailable companies:\n";
    
    $companies = DB::table('companies')
        ->select('id', 'company_name', 'company_email')
        ->orderBy('company_name')
        ->get();
    
    foreach ($companies as $company) {
        echo "  [{$company->id}] {$company->company_name} ({$company->company_email})\n";
    }
}

echo "\n=== Check Complete ===\n";
