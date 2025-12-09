# Mobile Number Helper - Quick Reference

## 🚀 Quick Start

### Display Mobile Numbers (with +91)
```blade
{{ display_mobile($variable->mobile_no) }}
```

### Form Input Fields (strip +91)
```blade
<input value="{{ strip_country_code($model->mobile_no) }}" />
```

That's it! Display shows +91, inputs show only 10 digits.

---

## 📖 Common Patterns

### Basic Display
```blade
{{ display_mobile($user->mobile_no) }}
{{ display_mobile($company->contact_person_mobile) }}
{{ display_mobile($inquiry->company_phone) }}
```

### With Fallback
```blade
{{ display_mobile($user->mobile_no) ?? 'N/A' }}
{{ display_mobile($user->mobile_no) ?: 'Not provided' }}
```

### In Conditionals
```blade
@if($invoice->mobile_no)
    <p>Mobile: {{ display_mobile($invoice->mobile_no) }}</p>
@endif
```

### In String Concatenation
```blade
{{ $person->name }} • {{ display_mobile($person->mobile) }}
```

### In Input Fields (Readonly)
```blade
<input value="{{ display_mobile($quotation->contact_number_1) }}" readonly />
```

### In Tables
```blade
<td>{{ display_mobile($company->contact_person_mobile) }}</td>
```

---

## 🎯 What Gets Formatted

### Input → Output
- `9876543210` → `+919876543210`
- `919876543210` → `+919876543210`
- `+919876543210` → `+919876543210`
- `+91 9876543210` → `+919876543210`
- `91-9876-543210` → `+919876543210`
- `null` → `''` (empty string)
- `12345` → `12345` (invalid, returned as-is)

---

## 🔍 Where It's Already Applied

✅ All these modules already use the helper:
- Companies
- Invoices
- Proformas
- Quotations
- Inquiries
- Users
- Employees
- Hiring
- Dashboards
- Receipts
- Digital Cards

---

## 🛠️ Advanced Usage

### Without + Symbol
```php
format_mobile_number('9876543210', false) // Returns: 919876543210
```

### In Controllers
```php
// For API responses
return response()->json([
    'mobile' => display_mobile($user->mobile_no)
]);
```

---

## ⚡ Remember

1. **Use `display_mobile()`** in views - it's simpler
2. **No database changes** - formatting is display-only
3. **Works with null** - returns empty string safely
4. **Handles any format** - strips spaces, dashes, etc.
5. **Already applied** - 35+ views already updated

---

## 🐛 Troubleshooting

### Not working?
```bash
php artisan view:clear
php artisan config:clear
composer dump-autoload
```

### Need to check implementation?
Look at these example files:
- `resources/views/companies/index.blade.php`
- `resources/views/invoices/show.blade.php`
- `resources/views/users/show.blade.php`

---

**Helper Location:** `app/Helpers/helpers.php`
**Function Names:** `display_mobile()` or `format_mobile_number()`
