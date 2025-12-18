# Employee ID Card System - Complete Guide

## Overview
A comprehensive ID card management system with multiple design styles, default card selection, and easy access from employee profiles.

## Features

### 1. Multiple ID Card Styles
- **Simple** - Clean and minimal design
- **Modern** - Gradient design with 3D effects and animations
- **Professional** - Corporate design with professional typography
- **Creative** - Multiple stunning designs with glassmorphism effects
- **Futuristic** - Cyberpunk-inspired with neon effects

### 2. Default Active Card System
- Each employee can have a default "active" ID card style
- The active style is stored in the session
- Quick access to the active card from employee profile

### 3. Easy Access Points

#### From Employee Profile Page
1. **Quick Action Buttons** (Top Header)
   - "View ID Card" - Opens the active ID card in a new tab
   - "Choose Style" - Opens the style selector

2. **ID Card Tab**
   - Preview of the current active card
   - Quick actions (View, Print, Download)
   - Gallery of all available styles

#### Direct Routes
- `/id-cards/{employee}/active` - View active ID card
- `/id-cards/{employee}/select-style` - Choose ID card style
- `/id-cards/{employee}/simple` - View simple style
- `/id-cards/{employee}/modern` - View modern style
- `/id-cards/{employee}/professional` - View professional style
- `/id-cards/{employee}/creative` - View creative style
- `/id-cards/{employee}/futuristic` - View futuristic style

## Usage

### For Employees
1. Navigate to your employee profile
2. Click "View ID Card" button in the header OR click the "ID Card" tab
3. Your default active ID card will be displayed
4. Click "Choose Style" to change the design

### For HR/Admin
1. Go to any employee's profile page
2. Access ID card through:
   - Quick action buttons in header
   - ID Card tab
3. Select preferred style for the employee
4. Print or download as PDF

### Changing Active Style
1. Click "Choose Style" button
2. Browse available designs
3. Click on any design to preview
4. The selected style becomes the new active card

## Routes Reference

### Main Routes
```
GET  /id-cards/{employee}/active          - View active ID card (default)
GET  /id-cards/{employee}/select-style    - Style selector page
POST /id-cards/{employee}/set-active/{style} - Set active style (API)
```

### Style-Specific Routes
```
GET  /id-cards/{employee}/simple          - Simple ID card
GET  /id-cards/{employee}/modern          - Modern ID card
GET  /id-cards/{employee}/professional    - Professional ID card
GET  /id-cards/{employee}/creative        - Creative ID card
GET  /id-cards/{employee}/futuristic      - Futuristic ID card
```

### Actions
```
GET  /id-cards/{employee}/print           - Print active card
GET  /id-cards/{employee}/download        - Download active card as PDF
GET  /id-cards/showcase                   - View all styles showcase
```

### Legacy Routes (Redirects)
```
GET  /employees/{employee}/id-card        - Redirects to active card
GET  /employees/{employee}/id-card/pdf    - Redirects to download
GET  /test-id-card/{employee}             - Redirects to professional
GET  /simple-id-card/{employee}           - Redirects to simple
GET  /creative-id-card/{employee}         - Redirects to creative
GET  /futuristic-id-card/{employee}       - Redirects to futuristic
```

## Technical Details

### Controller Methods
**DigitalCardController.php**
- `showActiveCard()` - Display the active ID card
- `selectStyle()` - Show style selector page
- `setActiveStyle()` - Set active style (AJAX)
- `showSimpleCard()` - Display simple style
- `showModernCard()` - Display modern style
- `showProfessionalCard()` - Display professional style
- `showCreativeCard()` - Display creative style
- `showFuturisticCard()` - Display futuristic style
- `printActiveCard()` - Print active card
- `downloadActiveCard()` - Download active card as PDF

### Session Storage
Active style is stored in session:
```php
session(['id_card_style_' . $employee->id => $style]);
```

Default style: `simple`

### Views
- `resources/views/hr/employees/id-card-simple.blade.php`
- `resources/views/hr/employees/id-card-modern.blade.php`
- `resources/views/hr/employees/id-card-professional.blade.php`
- `resources/views/hr/employees/id-card-creative.blade.php`
- `resources/views/hr/employees/id-card-futuristic.blade.php`
- `resources/views/hr/employees/id-card-selector.blade.php`

## Customization

### Adding New Styles
1. Create new blade view: `resources/views/hr/employees/id-card-{style}.blade.php`
2. Add route in `routes/web.php`:
   ```php
   Route::get('{employee}/{style}', [DigitalCardController::class, 'show{Style}Card'])->name('id-cards.{style}');
   ```
3. Add method in `DigitalCardController.php`:
   ```php
   public function show{Style}Card(Employee $employee) {
       return view('hr.employees.id-card-{style}', [
           'employee' => $employee,
           'page_title' => '{Style} ID Card - ' . $employee->name,
       ]);
   }
   ```
4. Update `$validStyles` array in `setActiveStyle()` method
5. Add to style selector page

### Styling Guidelines
- Use inline styles for print compatibility
- Include print-specific CSS with `@media print`
- Set `print-color-adjust: exact` for color printing
- Standard ID card size: 85.6mm x 54mm (credit card size)
- Include QR code for verification
- Display essential info: Name, ID, Position, Photo, Contact

## Print Settings
For best results when printing:
1. Enable "Background graphics" in print settings
2. Set color mode to "Color" (not Black & White)
3. Use landscape orientation for horizontal cards
4. Set margins to minimum
5. Paper size: A4 or Letter

## Security
- All routes require authentication
- Permission check: `Employees Management.view employee` or `super-admin` role
- QR codes link to employee profile for verification

## Future Enhancements
- [ ] Database storage for active style preference
- [ ] Bulk ID card generation for multiple employees
- [ ] Custom company logo upload
- [ ] Expiry date on ID cards
- [ ] Digital signature integration
- [ ] NFC/RFID integration
- [ ] Mobile app for ID card display

## Support
For issues or questions, contact the development team.

---
**Last Updated:** December 18, 2025
**Version:** 1.0.0
