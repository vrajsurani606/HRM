<?php

namespace Database\Seeders;

use App\Models\ProjectStage;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectStageSeeder extends Seeder
{
    public function run(): void
    {
        $stages = [
            ['name' => 'Upcoming', 'color' => '#d3b5df', 'order' => 1],
            ['name' => 'In Processing', 'color' => '#ebc58f', 'order' => 2],
            ['name' => 'In Review', 'color' => '#b9f3fc', 'order' => 3],
            ['name' => 'Completed', 'color' => '#abd1a5', 'order' => 4],
        ];

        foreach ($stages as $stage) {
            ProjectStage::firstOrCreate($stage);
        }

        // Sample projects
        
    }
}