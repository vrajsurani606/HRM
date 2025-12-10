<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            // First: Create permissions and roles
            PermissionSeeder::class,
            RoleSeeder::class,
            
            // Then: Create users and employees
            EmployeeSeeder::class,
            UserSeeder::class,
            
            // Finally: Create other data
            ProjectStageSeeder::class,
            TicketSeeder::class,
            MaterialSeeder::class,
            ProjectSeeder::class,
            CompanyHolidaySeeder::class,
        ]);
    }
}
