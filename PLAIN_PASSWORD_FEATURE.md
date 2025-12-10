# Plain Password Storage Feature

## Overview
This feature allows administrators to view plain text passwords for users and employees. This is useful for administrative purposes and password recovery.

## Security Notice
⚠️ **Important**: Plain passwords are stored in the database and should only be accessible to super-admin users. Ensure proper access controls are in place.

## Features Implemented

### 1. Database Changes
- Added `plain_password` column to `users` table
- Added `plain_password` column to `employees` table
- Migration file: `2025_12_09_171824_add_plain_password_to_users_and_employees_tables.php`

### 2. Model Updates
- Updated `User` model to include `plain_password` in fillable fields
- Updated `Employee` model to include `plain_password` in fillable fields

### 3. Controller Updates

#### UserController
- Stores plain password when creating new users
- Updates plain password when changing user passwords

#### EmployeeController
- Stores plain password when creating new employees
- Stores plain password when converting leads to employees
- Updates plain password when changing employee passwords
- Syncs plain password with associated user account

### 4. System Password Views

#### Routes
- `/system-passwords` - View all user passwords
- `/system-passwords/employees` - View all employee passwords
- `/system-passwords/companies` - View all company passwords

#### Features
- Search functionality
- Password visibility toggle (show/hide)
- Copy to clipboard functionality
- Pagination support
- Admin-only access (super-admin role required)

### 5. User & Employee Views

#### User Show Page (`users/show.blade.php`)
- Displays plain password field (admin only)
- Toggle visibility button
- Copy to clipboard button

#### User Edit Page (`users/edit.blade.php`)
- Shows current plain password below password field (admin only)

#### Employee Show Page (`hr/employees/show.blade.php`)
- Displays plain password in Personal Information tab (admin only)
- Toggle visibility button
- Copy to clipboard button

#### Employee Edit Page (`hr/employees/edit.blade.php`)
- Shows current plain password below password field (admin only)

## Usage

### For Administrators

1. **View All Passwords**
   - Navigate to `/system-passwords` for user passwords
   - Navigate to `/system-passwords/employees` for employee passwords
   - Navigate to `/system-passwords/companies` for company passwords

2. **Search Passwords**
   - Use the search bar to find specific users/employees by name, email, or code

3. **View/Copy Passwords**
   - Click the eye icon to show/hide password
   - Click the copy icon to copy password to clipboard

4. **View in User/Employee Details**
   - Open any user or employee detail page
   - Password field will be visible (admin only)
   - Edit page shows current password for reference

## Access Control

- Only users with `super-admin` role can view plain passwords
- Regular users and employees cannot see plain passwords
- Password fields are hidden for non-admin users

## Migration

To apply the database changes:

```bash
php artisan migrate
```

## Notes

- Existing users/employees without plain passwords will show "Not stored"
- New users/employees will have their passwords stored automatically
- When updating passwords, the plain password is also updated
- Default password for employees is "password123" if not specified

## Files Modified

### Controllers
- `app/Http/Controllers/UserController.php`
- `app/Http/Controllers/HR/EmployeeController.php`
- `app/Http/Controllers/SystemPasswordController.php` (new)

### Models
- `app/Models/User.php`
- `app/Models/Employee.php`

### Views
- `resources/views/system-passwords/index.blade.php` (new)
- `resources/views/system-passwords/employees.blade.php` (updated)
- `resources/views/system-passwords/companies.blade.php` (new)
- `resources/views/users/show.blade.php`
- `resources/views/users/edit.blade.php`
- `resources/views/hr/employees/show.blade.php`
- `resources/views/hr/employees/edit.blade.php`

### Routes
- `routes/web.php` (added system-passwords routes)

### Migrations
- `database/migrations/2025_12_09_171824_add_plain_password_to_users_and_employees_tables.php`
