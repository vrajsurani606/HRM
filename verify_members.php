<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Project;

echo "Verifying Project Members are Loading\n";
echo "======================================\n\n";

$projects = Project::with('members')->get();

foreach ($projects as $project) {
    echo "Project: {$project->name}\n";
    echo "  Members Count: {$project->members->count()}\n";
    
    if ($project->members->count() > 0) {
        echo "  Members:\n";
        foreach ($project->members as $member) {
            $initials = strtoupper(substr($member->name, 0, 1));
            if (str_word_count($member->name) > 1) {
                $words = explode(' ', $member->name);
                $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
            }
            echo "    - {$member->name} [{$initials}]\n";
        }
    } else {
        echo "  No members assigned\n";
    }
    echo "\n";
}

echo "Verification complete!\n";
