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
            EmployeeSeeder::class,
            ProjectStageSeeder::class,
            TicketSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            MaterialSeeder::class,
            ProjectSeeder::class,
            ProjectStageSeeder::class,
            CompanyHolidaySeeder::class,

        ]);
    }
}
