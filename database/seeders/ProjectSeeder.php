<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if projects table exists
        if (!DB::getSchemaBuilder()->hasTable('projects')) {
            // Create projects table
            DB::statement("
                CREATE TABLE IF NOT EXISTS projects (
                    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    description TEXT NULL,
                    company_id BIGINT UNSIGNED NULL,
                    status VARCHAR(50) DEFAULT 'active',
                    progress INT DEFAULT 0,
                    start_date DATE NULL,
                    end_date DATE NULL,
                    budget DECIMAL(15,2) NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    INDEX idx_company_id (company_id),
                    INDEX idx_status (status)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            
            $this->command->info('Projects table created successfully!');
        }

        // Get first company or create one
        $company = DB::table('companies')->first();
        
        if (!$company) {
            // Create a company with all required fields
            $companyId = DB::table('companies')->insertGetId([
                'company_name' => 'Demo Customer Company',
                'company_address' => '123 Business Street, Tech Park',
                'state' => 'Gujarat',
                'city' => 'Ahmedabad',
                'contact_person_name' => 'Demo Contact',
                'contact_person_mobile' => '9876543210',
                'company_email' => 'demo@company.com',
                'company_type' => 'Private Limited',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            $this->command->info('Company created!');
        } else {
            $companyId = $company->id;
            $this->command->info('Using existing company ID: ' . $companyId);
        }

        // Check which columns exist in projects table
        $columns = DB::getSchemaBuilder()->getColumnListing('projects');
        $hasProgress = in_array('progress', $columns);
        $hasBudget = in_array('budget', $columns);
        
        // Sample projects data
        $projectsData = [
            [
                'name' => 'Website Redesign & Development',
                'description' => 'Complete redesign and development of corporate website with modern UI/UX, responsive design, and CMS integration.',
                'company_id' => $companyId,
                'stage_id' => 1,
                'status' => 'in_progress',
                'progress' => 65,
                'start_date' => Carbon::now()->subDays(30)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(30)->format('Y-m-d'),
                'budget' => 25000.00,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => now()
            ],
            [
                'name' => 'Mobile App Development',
                'description' => 'Native iOS and Android mobile application with real-time features, push notifications, and cloud integration.',
                'company_id' => $companyId,
                'stage_id' => 1,
                'status' => 'active',
                'progress' => 40,
                'start_date' => Carbon::now()->subDays(15)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(75)->format('Y-m-d'),
                'budget' => 45000.00,
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => now()
            ],
            [
                'name' => 'Cloud Infrastructure Migration',
                'description' => 'Migration of existing infrastructure to AWS cloud with improved scalability, security, and performance optimization.',
                'company_id' => $companyId,
                'stage_id' => 1,
                'status' => 'active',
                'progress' => 25,
                'start_date' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(50)->format('Y-m-d'),
                'budget' => 35000.00,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => now()
            ],
            [
                'name' => 'E-commerce Platform Integration',
                'description' => 'Integration of advanced e-commerce features including payment gateway, inventory management, and analytics dashboard.',
                'company_id' => $companyId,
                'stage_id' => 1,
                'status' => 'in_progress',
                'progress' => 80,
                'start_date' => Carbon::now()->subDays(45)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(15)->format('Y-m-d'),
                'budget' => 30000.00,
                'created_at' => Carbon::now()->subDays(45),
                'updated_at' => now()
            ]
        ];
        
        // Filter projects data based on available columns
        $projects = [];
        foreach ($projectsData as $project) {
            $filteredProject = [];
            foreach ($project as $key => $value) {
                if (in_array($key, $columns)) {
                    $filteredProject[$key] = $value;
                }
            }
            $projects[] = $filteredProject;
        }

        // Insert projects
        foreach ($projects as $project) {
            // Check if project already exists
            $exists = DB::table('projects')
                ->where('name', $project['name'])
                ->where('company_id', $companyId)
                ->exists();
            
            if (!$exists) {
                DB::table('projects')->insert($project);
                $this->command->info("Created project: {$project['name']}");
            } else {
                $this->command->info("Project already exists: {$project['name']}");
            }
        }

        $this->command->info('✓ Project seeder completed successfully!');
        $this->command->info('✓ 4 sample projects created for customer@example.com');
    }
}
