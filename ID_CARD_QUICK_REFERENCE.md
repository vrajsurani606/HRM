# Employee ID Card System - Quick Reference

## 🚀 Quick Start

### 1. Basic ID Card Display
```blade
<!-- In any Blade template -->
<x-employee-id-card :employee="$employee" />
```

### 2. Direct Routes
```
GET /employees/{id}/id-card          # Full professional view
GET /employees/{id}/id-card/compact  # Mobile-optimized view  
GET /employees/{id}/id-card/pdf      # Download PDF
GET /id-cards/showcase               # Demo page
```

### 3. Controller Usage
```php
use App\Http\Controllers\HR\DigitalCardController;

// Show ID card
return app(DigitalCardController::class)->showIdCard($employee);

// Generate PDF
return app(DigitalCardController::class)->downloadIdCardPdf($employee);
```

## 🎨 Component Variations

### Standard Card (350×220px)
```blade
<x-employee-id-card :employee="$employee" />
```

### Compact Card (300×180px)
```blade
<x-employee-id-card :employee="$employee" size="compact" />
```

### Mini Card (250×150px)
```blade
<x-employee-id-card :employee="$employee" size="mini" />
```

### Without Actions
```blade
<x-employee-id-card :employee="$employee" :showActions="false" />
```

### Without QR Code
```blade
<x-employee-id-card :employee="$employee" :showQr="false" />
```

### Minimal Info
```blade
<x-employee-id-card 
    :employee="$employee" 
    size="mini" 
    :showQr="false" 
    :showDetails="false" 
    :showActions="false" 
/>
```

## 🔧 Customization

### Colors (CSS Custom Properties)
```css
:root {
    --primary-color: #2563eb;    /* Main brand color */
    --accent-color: #0ea5e9;     /* Accent/gradient color */
    --success-color: #10b981;    /* Success actions */
    --gray-800: #1f2937;         /* Text color */
}
```

### Company Branding
```php
// config/app.php
'name' => 'Your Company Name',
```

### Card Dimensions
```css
:root {
    --card-width: 350px;   /* Standard width */
    --card-height: 220px;  /* Standard height */
}
```

## 📱 Responsive Breakpoints

```css
/* Desktop: Full features */
@media (min-width: 768px) { /* Standard view */ }

/* Tablet: Compact layout */
@media (max-width: 768px) { /* Adjusted spacing */ }

/* Mobile: Stacked layout */
@media (max-width: 640px) { /* Mobile optimized */ }
```

## 🖨️ Export Options

### PDF Export
- **Dimensions:** 85.6×54mm (ISO/IEC 7810 ID-1)
- **DPI:** 300 for print quality
- **Format:** Landscape orientation

### Image Export
- **Format:** PNG with transparency
- **Resolution:** 3x scale (1050×660px)
- **Quality:** High for printing

### Print Styles
- Removes UI elements
- Optimizes for B&W printing
- Proper page breaks

## 🔐 Security & Permissions

### Required Permissions
```php
// Check in controller
auth()->user()->can('Employees Management.view employee')
```

### Access Control
```blade
@can('Employees Management.view employee')
    <x-employee-id-card :employee="$employee" />
@endcan
```

## 🎯 Integration Points

### Employee Dropdown Menu
```blade
@can('Employees Management.view employee')
    <a href="{{ route('employees.id-card.show', $employee) }}">
        <i class="fas fa-id-card"></i> ID Card
    </a>
@endcan
```

### Employee Profile Page
```blade
<div class="id-card-section">
    <h3>Employee ID Card</h3>
    <x-employee-id-card :employee="$employee" size="compact" />
    
    <div class="actions mt-4">
        <a href="{{ route('employees.id-card.show', $employee) }}" class="btn btn-primary">
            View Full Card
        </a>
        <a href="{{ route('employees.id-card.pdf', $employee) }}" class="btn btn-success">
            Download PDF
        </a>
    </div>
</div>
```

### Dashboard Widget
```blade
<div class="dashboard-widget">
    <h4>Recent Employees</h4>
    @foreach($recentEmployees as $employee)
        <x-employee-id-card :employee="$employee" size="mini" :showActions="false" />
    @endforeach
</div>
```

## 🔍 QR Code Implementation

### QR Data Format
```javascript
// Links to employee profile
const qrData = "{{ route('employees.show', $employee) }}";
```

### Custom QR Data
```php
// In controller, pass custom data
$qrData = json_encode([
    'employee_id' => $employee->id,
    'name' => $employee->name,
    'department' => $employee->department,
    'verification_url' => route('employees.show', $employee)
]);
```

### QR Code Fallbacks
1. **Primary:** QRCode.js library
2. **Secondary:** Google Charts API
3. **Fallback:** Employee code text

## 🛠️ Troubleshooting

### Common Issues

**QR Code Not Showing:**
```javascript
// Check browser console for errors
// Verify QRCode.js library loading
// Test with fallback URL
```

**PDF Generation Fails:**
```php
// Check DomPDF installation
composer require barryvdh/laravel-dompdf

// Publish config
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

**Images Not Loading:**
```bash
# Create storage symlink
php artisan storage:link

# Check file permissions
chmod -R 755 storage/
```

**Styling Issues:**
```html
<!-- Ensure CSS libraries are loaded -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
```

## 📊 Performance Tips

### Optimize Images
```php
// Resize employee photos
$image = Image::make($photo)->fit(200, 200);
```

### Cache QR Codes
```php
// Cache generated QR codes
Cache::remember("qr_code_{$employee->id}", 3600, function() use ($employee) {
    return $this->generateQRCode($employee);
});
```

### Lazy Loading
```blade
<img src="{{ $photoUrl }}" loading="lazy" alt="{{ $employee->name }}">
```

## 🧪 Testing

### Unit Tests
```php
// Test ID card generation
public function test_id_card_generation()
{
    $employee = Employee::factory()->create();
    $response = $this->get(route('employees.id-card.show', $employee));
    $response->assertStatus(200);
}
```

### Feature Tests
```php
// Test PDF download
public function test_pdf_download()
{
    $employee = Employee::factory()->create();
    $response = $this->get(route('employees.id-card.pdf', $employee));
    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/pdf');
}
```

## 📈 Analytics & Monitoring

### Track Usage
```php
// Log ID card views
Log::info('ID card viewed', [
    'employee_id' => $employee->id,
    'user_id' => auth()->id(),
    'type' => 'view'
]);
```

### Monitor Performance
```php
// Track generation time
$start = microtime(true);
// ... generate ID card
$duration = microtime(true) - $start;
Log::info('ID card generated', ['duration' => $duration]);
```

## 🔄 Bulk Operations

### Generate Multiple Cards
```php
public function bulkGenerate(Request $request)
{
    $employeeIds = $request->input('employee_ids');
    $employees = Employee::whereIn('id', $employeeIds)->get();
    
    $zip = new ZipArchive();
    $zipFileName = 'employee_id_cards_' . date('Y-m-d') . '.zip';
    
    foreach ($employees as $employee) {
        $pdf = $this->generatePDF($employee);
        $zip->addFromString($employee->name . '_ID_Card.pdf', $pdf);
    }
    
    return response()->download($zipFileName);
}
```

## 🌐 API Integration

### REST API Endpoints
```php
// API routes
Route::get('/api/employees/{employee}/id-card', function (Employee $employee) {
    return response()->json([
        'employee' => $employee->only(['id', 'name', 'email', 'position']),
        'qr_code' => route('employees.show', $employee),
        'card_urls' => [
            'view' => route('employees.id-card.show', $employee),
            'compact' => route('employees.id-card.compact', $employee),
            'pdf' => route('employees.id-card.pdf', $employee)
        ]
    ]);
});
```

---

## 📞 Support

For issues or questions:
1. Check the full documentation: `EMPLOYEE_ID_CARD_SYSTEM.md`
2. Run the installation script: `php install-id-card-system.php`
3. Test with the showcase page: `/id-cards/showcase`

**Quick Test URL:** `/id-cards/showcase`