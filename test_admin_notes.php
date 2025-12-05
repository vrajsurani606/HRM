<?php

/**
 * Admin Notes System - Quick Test Script
 * Run this to verify everything is working
 */

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║         ADMIN NOTES SYSTEM - VERIFICATION TEST                ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Test 1: Check if route file exists
echo "Test 1: Checking routes/web.php...\n";
if (file_exists('routes/web.php')) {
    $routeContent = file_get_contents('routes/web.php');
    if (strpos($routeContent, '/api/admin-notes') !== false) {
        echo "✅ Route /api/admin-notes found in routes/web.php\n";
    } else {
        echo "❌ Route /api/admin-notes NOT found in routes/web.php\n";
    }
} else {
    echo "❌ routes/web.php not found\n";
}

// Test 2: Check if controller method exists
echo "\nTest 2: Checking DashboardController.php...\n";
if (file_exists('app/Http/Controllers/DashboardController.php')) {
    $controllerContent = file_get_contents('app/Http/Controllers/DashboardController.php');
    if (strpos($controllerContent, 'public function storeAdminNote') !== false) {
        echo "✅ Method storeAdminNote() found in DashboardController\n";
    } else {
        echo "❌ Method storeAdminNote() NOT found in DashboardController\n";
    }
} else {
    echo "❌ DashboardController.php not found\n";
}

// Test 3: Check if migration file exists
echo "\nTest 3: Checking migration file...\n";
if (file_exists('database/migrations/2025_12_02_000000_create_notes_table.php')) {
    echo "✅ Migration file found\n";
} else {
    echo "❌ Migration file NOT found\n";
}

// Test 4: Check if dashboard view has AJAX code
echo "\nTest 4: Checking dashboard.blade.php...\n";
if (file_exists('resources/views/dashboard.blade.php')) {
    $dashboardContent = file_get_contents('resources/views/dashboard.blade.php');
    if (strpos($dashboardContent, '/api/admin-notes') !== false) {
        echo "✅ AJAX code for /api/admin-notes found in dashboard.blade.php\n";
    } else {
        echo "❌ AJAX code for /api/admin-notes NOT found in dashboard.blade.php\n";
    }
} else {
    echo "❌ dashboard.blade.php not found\n";
}

// Test 5: Check database connection
echo "\nTest 5: Checking database...\n";
try {
    // This would require Laravel to be loaded, so we'll skip for now
    echo "⚠️  Database check requires Laravel environment\n";
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
}

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║                    NEXT STEPS                                  ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "1. Run migrations:\n";
echo "   php artisan migrate\n\n";

echo "2. Clear cache:\n";
echo "   php artisan cache:clear\n";
echo "   php artisan route:clear\n\n";

echo "3. Test the endpoint:\n";
echo "   - Go to http://localhost/GitVraj/HrPortal/dashboard\n";
echo "   - Click 'ADMIN NOTES' tab\n";
echo "   - Enter note text\n";
echo "   - Select employees\n";
echo "   - Click 'Save Admin Note'\n\n";

echo "4. Check browser console (F12) for errors\n\n";

echo "5. If still having issues, check:\n";
echo "   - storage/logs/laravel.log\n";
echo "   - Browser Network tab (F12)\n";
echo "   - Database: SELECT * FROM notes;\n\n";

echo "✅ Test complete!\n";
?>
