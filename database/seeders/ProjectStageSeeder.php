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
        $projects = [
            ['name' => 'MVTY Dham Web', 'stage_id' => 1, 'due_date' => '2025-12-17', 'total_tasks' => 4, 'completed_tasks' => 0],
            ['name' => 'MVTY Dham Web', 'stage_id' => 2, 'total_tasks' => 4, 'completed_tasks' => 0],
            ['name' => 'NABL Software', 'stage_id' => 2, 'total_tasks' => 22, 'completed_tasks' => 5],
            ['name' => 'Social Media POST', 'stage_id' => 2, 'total_tasks' => 22, 'completed_tasks' => 5],
            ['name' => 'Social Media POST', 'stage_id' => 2, 'total_tasks' => 22, 'completed_tasks' => 5],
            ['name' => 'MVTY Dham Web', 'stage_id' => 3, 'total_tasks' => 4, 'completed_tasks' => 0],
            ['name' => 'Chitri Software', 'stage_id' => 3, 'total_tasks' => 22, 'completed_tasks' => 5],
            ['name' => 'Om Her Bhole App', 'stage_id' => 3, 'total_tasks' => 17, 'completed_tasks' => 12],
            ['name' => 'MVTY Dham App', 'stage_id' => 4, 'total_tasks' => 4, 'completed_tasks' => 4],
        ];

        foreach ($projects as $project) {
            Project::firstOrCreate($project);
        }
    }
}