<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ProjectStage;

echo "Debugging Kanban Board Members Display\n";
echo "========================================\n\n";

// Simulate what the controller does
$stages = ProjectStage::with(['projects.company', 'projects.members'])->orderBy('order')->get();

foreach ($stages as $stage) {
    echo "STAGE: {$stage->name}\n";
    echo str_repeat('-', 60) . "\n";
    
    foreach ($stage->projects as $project) {
        echo "  Project: {$project->name}\n";
        echo "  Members loaded: " . ($project->relationLoaded('members') ? 'YES' : 'NO') . "\n";
        echo "  Members count: {$project->members->count()}\n";
        
        if ($project->members->count() > 0) {
            echo "  Display (first 3):\n";
            $colors = ['#4F46E5', '#059669', '#DC2626', '#F59E0B', '#8B5CF6', '#EC4899', '#14B8A6', '#F97316'];
            $displayLimit = 3;
            
            foreach ($project->members->take($displayLimit) as $index => $member) {
                $initials = strtoupper(substr($member->name, 0, 1));
                if (str_word_count($member->name) > 1) {
                    $words = explode(' ', $member->name);
                    $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                }
                $bgColor = $colors[$index % count($colors)];
                echo "    [{$initials}] {$member->name} (Color: {$bgColor})\n";
            }
            
            if ($project->members->count() > $displayLimit) {
                $extra = $project->members->count() - $displayLimit;
                echo "    [+{$extra}] {$extra} more members\n";
            }
        } else {
            echo "  Display: [User Icon] No members assigned\n";
        }
        echo "\n";
    }
    echo "\n";
}

echo "Debug complete!\n";
