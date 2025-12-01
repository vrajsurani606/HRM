# User-Company Linking Guide

## Overview
This system allows customer/company users to be linked to their respective companies, enabling proper data filtering in dashboards and throughout the application.

## Database Structure

### Users Table
- Added `company_id` column (nullable, foreign key to companies table)
- Links users directly to their company

### Relationships
- **User Model**: `belongsTo(Company::class)`
- **Company Model**: `hasMany(User::class)` and `hasMany(Project::class)`

## Linking Users to Companies

### Method 1: Artisan Command (Recommended)

#### Auto-link by email matching:
```bash
php artisan users:link-companies --auto
```
This automatically links users to companies where the user's email matches the company's email.

#### Show current linkage status:
```bash
php artisan users:link-companies --show
```

#### Link specific user to company:
```bash
php artisan users:link-companies --user=26 --company=9
```

#### Interactive mode:
```bash
php artisan users:link-companies
```

### Method 2: Manual PHP Script
Run the `link_users_to_companies.php` script:
```bash
php link_users_to_companies.php
```

### Method 3: Programmatically
```php
$user = User::find($userId);
$user->company_id = $companyId;
$user->save();
```

## Dashboard Behavior

### Customer Dashboard
When a customer user logs in:
1. System retrieves their `company_id` from the users table
2. Filters all data (projects, quotations, invoices) by this company_id
3. Shows only data relevant to their company

### Projects Display
- **Linked Users**: See only projects where `project.company_id = user.company_id`
- **Unlinked Users**: See no projects (company_id is null)

## Current Status

### Linked Users (10):
- Mejia and Meadows Co → Mejia and Meadows Co
- fdsafdf asfdsfdafdasfd → fdsafdf asfdsfdafdasfd
- dsgfsg → sdfaffdssd
- test → test
- Vraj surani → mahima
- dhruvi → dhruvi
- ashish (Company) → ashish fashion
- test (Company) → shaloni
- jignasha jethavatest (Company) → geolab
- **kuldip (Company) → Chitri Enlarge** ✓

### Unlinked Users (7):
These users need manual linking as their email doesn't match any company email:
- Customer User (customer@example.com)
- test (test582@example.com)
- testing123 (testing123386@example.com)
- testing5 (testing5249@example.com)
- ashish (Employee) (ashishfashionemp637@example.com)
- test (Employee) (shaloniemp476@example.com)
- kuldip (Employee) (chitrienlargeemp490@example.com)

## Best Practices

1. **When creating a new company user**: Set the `company_id` during user creation
2. **Regular audits**: Run `php artisan users:link-companies --show` to check linkage status
3. **Employee users**: Employee role users don't need company linking (they use employee records)
4. **Multiple users per company**: Multiple users can be linked to the same company

## Troubleshooting

### User sees no projects
- Check if user has `company_id` set: `php artisan users:link-companies --show`
- Verify projects exist for that company: Check `projects` table where `company_id = X`
- Link the user: `php artisan users:link-companies --user=X --company=Y`

### Projects not showing after linking
- Clear cache: `php artisan cache:clear`
- Verify the project's `company_id` matches the user's `company_id`

## Migration History

1. **2025_11_29_054423**: Added company_id to users table (later removed)
2. **2025_11_29_062913**: Removed company_id from users table
3. **2025_12_01_000000**: Re-added company_id to users table (current implementation)

## Files Modified

- `database/migrations/2025_12_01_000000_add_company_id_to_users_table.php`
- `app/Models/User.php` - Added company relationship and fillable field
- `app/Models/Company.php` - Added users and projects relationships
- `app/Http/Controllers/DashboardController.php` - Updated customerDashboard() method
- `app/Console/Commands/LinkUsersToCompanies.php` - New command for linking
- `link_users_to_companies.php` - Standalone script for linking

## Example Usage

```php
// In controller or anywhere
$user = auth()->user();

if ($user->company_id) {
    // Get user's company
    $company = $user->company;
    
    // Get company's projects
    $projects = $company->projects;
    
    // Or directly
    $projects = Project::where('company_id', $user->company_id)->get();
}
```
