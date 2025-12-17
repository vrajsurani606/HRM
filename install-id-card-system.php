<?php

/**
 * Employee ID Card System Installation Script
 * 
 * This script helps set up the Employee ID Card system in your Laravel HRM application.
 * Run this script after copying all the files to ensure proper setup.
 */

echo "🆔 Employee ID Card System Installation\n";
echo "=====================================\n\n";

// Check Laravel environment
if (!function_exists('app')) {
    echo "❌ Error: This script must be run in a Laravel environment.\n";
    echo "Please run: php artisan tinker\n";
    echo "Then paste this script content.\n";
    exit(1);
}

echo "✅ Laravel environment detected\n";

// Check required models
$requiredModels = [
    'App\Models\Employee',
    'App\Models\DigitalCard',
    'App\Models\User'
];

foreach ($requiredModels as $model) {
    if (class_exists($model)) {
        echo "✅ Model found: {$model}\n";
    } else {
        echo "❌ Missing model: {$model}\n";
    }
}

// Check required views
$requiredViews = [
    'hr.employees.id-card-professional',
    'hr.employees.id-card-compact',
    'hr.employees.id-card-pdf',
    'components.employee-id-card'
];

foreach ($requiredViews as $view) {
    if (view()->exists($view)) {
        echo "✅ View found: {$view}\n";
    } else {
        echo "❌ Missing view: {$view}\n";
    }
}

// Check routes
echo "\n📋 Route Configuration:\n";
echo "Add these routes to your routes/web.php file:\n\n";

$routeCode = <<<'PHP'
// Employee ID Card routes (add inside employees prefix group)
Route::get('/id-card', [\App\Http\Controllers\HR\DigitalCardController::class, 'showIdCard'])
    ->name('employees.id-card.show');
Route::get('/id-card/compact', [\App\Http\Controllers\HR\DigitalCardController::class, 'showCompactIdCard'])
    ->name('employees.id-card.compact');
Route::get('/id-card/pdf', [\App\Http\Controllers\HR\DigitalCardController::class, 'downloadIdCardPdf'])
    ->name('employees.id-card.pdf');

// ID Card Showcase (add outside employees group)
Route::get('id-cards/showcase', [\App\Http\Controllers\HR\DigitalCardController::class, 'showcase'])
    ->name('id-cards.showcase');
PHP;

echo $routeCode . "\n\n";

// Check controller methods
echo "🎛️  Controller Methods:\n";
$controllerClass = 'App\Http\Controllers\HR\DigitalCardController';

if (class_exists($controllerClass)) {
    echo "✅ Controller found: {$controllerClass}\n";
    
    $requiredMethods = ['showIdCard', 'showCompactIdCard', 'downloadIdCardPdf', 'showcase'];
    $reflection = new ReflectionClass($controllerClass);
    
    foreach ($requiredMethods as $method) {
        if ($reflection->hasMethod($method)) {
            echo "✅ Method found: {$method}\n";
        } else {
            echo "❌ Missing method: {$method}\n";
        }
    }
} else {
    echo "❌ Controller not found: {$controllerClass}\n";
}

// Check dependencies
echo "\n📦 Dependencies Check:\n";

$requiredPackages = [
    'barryvdh/laravel-dompdf' => 'PDF generation',
    'intervention/image' => 'Image processing (optional)',
];

foreach ($requiredPackages as $package => $description) {
    $composerFile = base_path('composer.json');
    if (file_exists($composerFile)) {
        $composer = json_decode(file_get_contents($composerFile), true);
        $allPackages = array_merge(
            $composer['require'] ?? [],
            $composer['require-dev'] ?? []
        );
        
        if (isset($allPackages[$package])) {
            echo "✅ Package installed: {$package} ({$description})\n";
        } else {
            echo "⚠️  Package missing: {$package} ({$description})\n";
            echo "   Install with: composer require {$package}\n";
        }
    }
}

// Check permissions
echo "\n🔐 Permissions Setup:\n";
echo "Ensure these permissions exist in your role system:\n";
echo "- Employees Management.view employee\n";
echo "- Employees Management.edit employee\n";
echo "- Employees Management.digital card\n";

// Storage setup
echo "\n💾 Storage Setup:\n";
$storagePath = storage_path('app/public');
if (is_dir($storagePath)) {
    echo "✅ Storage directory exists: {$storagePath}\n";
    
    if (is_link(public_path('storage'))) {
        echo "✅ Storage symlink exists\n";
    } else {
        echo "⚠️  Storage symlink missing\n";
        echo "   Run: php artisan storage:link\n";
    }
} else {
    echo "❌ Storage directory missing: {$storagePath}\n";
}

// Test data
echo "\n🧪 Test Data:\n";
$employeeCount = \App\Models\Employee::count();
echo "Employee records: {$employeeCount}\n";

if ($employeeCount > 0) {
    echo "✅ Test data available\n";
    $sampleEmployee = \App\Models\Employee::first();
    echo "Sample employee: {$sampleEmployee->name} (ID: {$sampleEmployee->id})\n";
} else {
    echo "⚠️  No employee records found\n";
    echo "Create some test employees to test the ID card system\n";
}

// Configuration recommendations
echo "\n⚙️  Configuration Recommendations:\n";
echo "1. Update config/app.php 'name' for company branding\n";
echo "2. Configure PDF settings in config/dompdf.php (if using DomPDF)\n";
echo "3. Set up proper file permissions for storage\n";
echo "4. Configure queue system for bulk operations (optional)\n";
echo "5. Set up CDN for external libraries in production\n";

// Next steps
echo "\n🚀 Next Steps:\n";
echo "1. Test the ID card system: /id-cards/showcase\n";
echo "2. Generate a sample ID card for an employee\n";
echo "3. Test PDF export functionality\n";
echo "4. Customize branding and colors\n";
echo "5. Add ID card links to your employee interface\n";

// URLs to test
if ($employeeCount > 0) {
    $sampleEmployee = \App\Models\Employee::first();
    echo "\n🔗 Test URLs:\n";
    echo "- Showcase: " . route('id-cards.showcase') . "\n";
    echo "- Sample ID Card: " . route('employees.id-card.show', $sampleEmployee) . "\n";
    echo "- Compact View: " . route('employees.id-card.compact', $sampleEmployee) . "\n";
    echo "- PDF Download: " . route('employees.id-card.pdf', $sampleEmployee) . "\n";
}

echo "\n✨ Installation check complete!\n";
echo "Review any missing items above and test the system.\n";
echo "For detailed documentation, see EMPLOYEE_ID_CARD_SYSTEM.md\n";

?>