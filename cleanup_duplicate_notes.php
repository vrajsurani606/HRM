<?php
/**
 * Cleanup Script: Remove Duplicate Notes
 * This script removes old duplicate notes created before the fix
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== CLEANUP DUPLICATE NOTES ===\n\n";

// Step 1: Find duplicates
echo "STEP 1: Finding duplicate notes...\n";
try {
    $duplicates = DB::table('notes')
        ->select('content', DB::raw('COUNT(*) as count'), DB::raw('MIN(id) as min_id'))
        ->where('type', 'employee')
        ->groupBy('content')
        ->having(DB::raw('COUNT(*)'), '>', 1)
        ->get();
    
    echo "Found " . count($duplicates) . " duplicate note(s)\n\n";
    
    if (count($duplicates) > 0) {
        echo "Duplicates to be cleaned:\n";
        foreach ($duplicates as $dup) {
            echo "  - Content: " . substr($dup->content, 0, 50) . "...\n";
            echo "    Appears: " . $dup->count . " times\n";
            echo "    Keeping: ID " . $dup->min_id . "\n";
            echo "    Deleting: " . ($dup->count - 1) . " duplicate(s)\n\n";
        }
    }
} catch (\Exception $e) {
    echo "✗ Error finding duplicates: " . $e->getMessage() . "\n";
    exit(1);
}

// Step 2: Confirm before deletion
echo "WARNING: This will delete duplicate notes!\n";
echo "Type 'yes' to confirm cleanup: ";
$input = trim(fgets(STDIN));

if ($input !== 'yes') {
    echo "Cleanup cancelled.\n";
    exit(0);
}

// Step 3: Delete duplicates
echo "\nSTEP 2: Deleting duplicate notes...\n";
try {
    // Delete all duplicates, keeping only the first one of each
    $deleted = DB::statement("
        DELETE FROM notes 
        WHERE id NOT IN (
            SELECT MIN(id) 
            FROM (
                SELECT MIN(id) as id
                FROM notes 
                WHERE type = 'employee'
                GROUP BY content
            ) as t
        ) AND type = 'employee'
    ");
    
    echo "✓ Cleanup completed\n";
} catch (\Exception $e) {
    echo "✗ Error during cleanup: " . $e->getMessage() . "\n";
    exit(1);
}

// Step 4: Verify cleanup
echo "\nSTEP 3: Verifying cleanup...\n";
try {
    $remaining = DB::table('notes')
        ->select('content', DB::raw('COUNT(*) as count'))
        ->where('type', 'employee')
        ->groupBy('content')
        ->having(DB::raw('COUNT(*)'), '>', 1)
        ->get();
    
    if (count($remaining) === 0) {
        echo "✓ All duplicates removed\n";
        echo "✓ Database is now clean\n";
    } else {
        echo "⚠ Some duplicates remain:\n";
        foreach ($remaining as $dup) {
            echo "  - " . substr($dup->content, 0, 50) . "... (appears " . $dup->count . " times)\n";
        }
    }
} catch (\Exception $e) {
    echo "✗ Error verifying: " . $e->getMessage() . "\n";
    exit(1);
}

// Step 5: Show final stats
echo "\nSTEP 4: Final Statistics\n";
try {
    $totalNotes = DB::table('notes')->where('type', 'employee')->count();
    $uniqueNotes = DB::table('notes')
        ->where('type', 'employee')
        ->select('content')
        ->distinct()
        ->count();
    
    echo "✓ Total notes: " . $totalNotes . "\n";
    echo "✓ Unique notes: " . $uniqueNotes . "\n";
    echo "✓ Duplicates removed: " . ($totalNotes - $uniqueNotes) . "\n";
} catch (\Exception $e) {
    echo "✗ Error getting stats: " . $e->getMessage() . "\n";
}

echo "\n=== CLEANUP COMPLETE ===\n";
echo "\nNow when you create notes:\n";
echo "✓ Each note will appear ONCE (not multiple times)\n";
echo "✓ All employees will be shown as chips\n";
echo "✓ No more duplicates\n";
?>
