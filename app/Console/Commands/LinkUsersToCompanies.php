<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Company;

class LinkUsersToCompanies extends Command
{
    protected $signature = 'users:link-companies 
                            {--user= : Specific user ID to link}
                            {--company= : Specific company ID to link to}
                            {--auto : Auto-link users to companies by email matching}
                            {--show : Show current linkage status}';

    protected $description = 'Link customer users to their companies';

    public function handle()
    {
        if ($this->option('show')) {
            return $this->showStatus();
        }

        if ($this->option('auto')) {
            return $this->autoLink();
        }

        $userId = $this->option('user');
        $companyId = $this->option('company');

        if ($userId && $companyId) {
            return $this->linkUserToCompany($userId, $companyId);
        }

        // Interactive mode
        return $this->interactiveLink();
    }

    private function showStatus()
    {
        $this->info('=== User-Company Linkage Status ===');
        $this->newLine();

        // Get users with customer or company role (only existing roles)
        $customerUsers = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['customer', 'company']);
        })->get();

        $linked = 0;
        $notLinked = 0;

        foreach ($customerUsers as $user) {
            if ($user->company_id) {
                $company = Company::find($user->company_id);
                $this->line("✓ {$user->name} ({$user->email}) → " . ($company ? $company->company_name : "Company ID {$user->company_id}"));
                $linked++;
            } else {
                $this->line("✗ {$user->name} ({$user->email}) → NOT LINKED");
                $notLinked++;
            }
        }

        $this->newLine();
        $this->info("Linked: {$linked} | Not Linked: {$notLinked}");

        return 0;
    }

    private function autoLink()
    {
        $this->info('Auto-linking users to companies by email...');
        $this->newLine();

        // Get users with customer or company role (only existing roles)
        $customerUsers = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['customer', 'company']);
        })->whereNull('company_id')->get();

        $linked = 0;

        foreach ($customerUsers as $user) {
            // Try to find company by email
            $company = Company::where('company_email', $user->email)->first();

            if ($company) {
                $user->company_id = $company->id;
                $user->save();
                $this->line("✓ Linked {$user->name} ({$user->email}) to {$company->company_name}");
                $linked++;
            } else {
                $this->line("✗ No matching company found for {$user->name} ({$user->email})");
            }
        }

        $this->newLine();
        $this->info("Auto-linked {$linked} users");

        return 0;
    }

    private function linkUserToCompany($userId, $companyId)
    {
        $user = User::find($userId);
        if (!$user) {
            $this->error("User ID {$userId} not found");
            return 1;
        }

        $company = Company::find($companyId);
        if (!$company) {
            $this->error("Company ID {$companyId} not found");
            return 1;
        }

        $user->company_id = $companyId;
        $user->save();

        $this->info("✓ Linked {$user->name} to {$company->company_name}");

        return 0;
    }

    private function interactiveLink()
    {
        $this->info('=== Interactive User-Company Linking ===');
        $this->newLine();

        // Show companies
        $companies = Company::select('id', 'company_name', 'company_email')->get();
        $this->info('Available Companies:');
        foreach ($companies as $company) {
            $this->line("  {$company->id} - {$company->company_name} ({$company->company_email})");
        }
        $this->newLine();

        // Show unlinked users
        $customerUsers = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['customer', 'company']);
        })->whereNull('company_id')->get();

        if ($customerUsers->isEmpty()) {
            $this->info('All customer users are already linked to companies!');
            return 0;
        }

        $this->info('Unlinked Customer Users:');
        foreach ($customerUsers as $user) {
            $this->line("  {$user->id} - {$user->name} ({$user->email})");
        }
        $this->newLine();

        // Ask for linking
        foreach ($customerUsers as $user) {
            $companyId = $this->ask("Link user {$user->id} ({$user->name}) to company ID (or 'skip')");

            if (strtolower($companyId) === 'skip') {
                continue;
            }

            $company = Company::find($companyId);
            if (!$company) {
                $this->error("Company ID {$companyId} not found. Skipping.");
                continue;
            }

            $user->company_id = $companyId;
            $user->save();
            $this->info("✓ Linked {$user->name} to {$company->company_name}");
        }

        return 0;
    }
}
