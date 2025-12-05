# Profile Management Permissions Implementation

## Overview
This document describes the implementation of role-based permissions for the Profile Management module, following the same pattern as Events Management and other modules in the system.

## Permissions Added

### Profile Management Module Permissions
The following permissions have been added to the system:

1. **view profile** - View any user's profile (Admin/Super Admin)
2. **edit profile** - Edit any user's profile (Admin/Super Admin)
3. **update profile** - Update any user's profile (Admin/Super Admin)
4. **update bank details** - Update bank account information (Admin/Super Admin/HR)
5. **delete profile** - Delete user profiles (Super Admin only)
6. **view own profile** - View own profile (All users)
7. **edit own profile** - Edit own profile (All users)

## Permission Structure
Following the existing pattern in the system:
```
Module Name: Profile Management
Permission Format: Profile Management.{action}
Example: Profile Management.view own profile
```

## Role Assignments

### Super Admin
- All profile permissions (full access)
- Can view, edit, update, and delete any profile
- Can manage bank details for all users

### Admin
- View, edit, and update any profile
- Can manage bank details for all users
- Cannot delete profiles

### HR
- View and edit own profile
- Can update bank details (for payroll purposes)

### Employee
- View and edit own profile only
- Cannot access other users' profiles

### Receptionist
- View and edit own profile only
- Cannot access other users' profiles

### Customer
- View and edit own profile only
- Cannot access other users' profiles

## Implementation Details

### 1. Permission Seeder (database/seeders/PermissionSeeder.php)
Added Profile Management module to the permissions array:
```php
'Profile Management' => [
    'view profile', 
    'edit profile', 
    'update profile', 
    'update bank details', 
    'delete profile', 
    'view own profile', 
    'edit own profile'
],
```

### 2. ProfileController (app/Http/Controllers/ProfileController.php)
Added permission checks to all methods:

**edit() method:**
```php
if (!$request->user()->can('Profile Management.view own profile') && 
    !$request->user()->can('Profile Management.view profile')) {
    abort(403, 'Unauthorized access to profile.');
}
```

**update() method:**
```php
if (!$request->user()->can('Profile Management.edit own profile') && 
    !$request->user()->can('Profile Management.edit profile')) {
    abort(403, 'Unauthorized to update profile.');
}
```

**updateBank() method:**
```php
if (!$request->user()->can('Profile Management.update bank details') && 
    !$request->user()->can('Profile Management.edit own profile')) {
    abort(403, 'Unauthorized to update bank details.');
}
```

**destroy() method:**
```php
if (!$request->user()->can('Profile Management.delete profile')) {
    abort(403, 'Unauthorized to delete profile.');
}
```

### 3. Profile View (resources/views/profile/edit.blade.php)
Added permission-based UI controls:

**Permission Check Variable:**
```php
@php
  $canEdit = auth()->user()->can('Profile Management.edit own profile') || 
             auth()->user()->can('Profile Management.edit profile');
@endphp
```

**Conditional Form Fields:**
- Photo upload field only shown if user has edit permission
- All input fields become readonly if user lacks edit permission
- Save button hidden if user lacks edit permission
- Warning message shown if user cannot edit

### 4. Bank Details Partial (resources/views/profile/partials/bank-details.blade.php)
Added permission check to Edit button:
```php
@if($employee && (auth()->user()->can('Profile Management.update bank details') || 
                  auth()->user()->can('Profile Management.edit own profile')))
  <button type="button" id="editBankBtn" onclick="toggleBankEdit()">
    Edit Details
  </button>
@endif
```

## Installation & Setup

### Step 1: Run Permission Seeder
```bash
php artisan db:seed --class=PermissionSeeder
```

### Step 2: Assign Permissions to Existing Roles

**Option A - Quick Assignment (Recommended):**
```bash
php sync_all_profile_permissions.php
```

**Option B - Original Script:**
```bash
php assign_profile_permissions.php
```

Both scripts will:
- Create all profile permissions if they don't exist
- Assign appropriate permissions to each role
- Preserve existing permissions (non-destructive)
- **Automatically assign default permissions to ALL roles** (including employee, receptionist, customer, and any custom roles)

**Default Permissions for All Roles:**
- Profile Management.view own profile
- Profile Management.edit own profile

**Special Permissions:**
- Super Admin & Admin: Full profile management access
- HR: Own profile + bank details management

### Step 3: Verify Permissions
Check the roles page at: `http://localhost/GitVraj/HrPortal/roles`

You should see "Profile Management" module with all permissions listed.

## Testing

### Test Cases

1. **Super Admin**
   - ✓ Can view profile page
   - ✓ Can edit all fields
   - ✓ Can update bank details
   - ✓ Can upload photos

2. **Admin**
   - ✓ Can view profile page
   - ✓ Can edit all fields
   - ✓ Can update bank details
   - ✓ Can upload photos

3. **HR**
   - ✓ Can view own profile
   - ✓ Can edit own profile
   - ✓ Can update bank details

4. **Employee**
   - ✓ Can view own profile
   - ✓ Can edit own profile
   - ✗ Cannot access other profiles

5. **Receptionist**
   - ✓ Can view own profile
   - ✓ Can edit own profile
   - ✗ Cannot access other profiles

6. **Customer**
   - ✓ Can view own profile
   - ✓ Can edit own profile
   - ✗ Cannot access other profiles

### Test Without Permissions
To test the permission system:
1. Remove profile permissions from a test role
2. Login as a user with that role
3. Navigate to `/profile`
4. Verify that:
   - 403 error is shown if no view permission
   - Fields are readonly if no edit permission
   - Save button is hidden if no edit permission
   - Warning message is displayed

## UI Behavior

### With Edit Permission
- All form fields are editable
- Photo upload field is visible
- Save button is displayed
- Bank details can be edited

### Without Edit Permission
- All form fields are readonly
- Photo upload field is hidden
- Save button is hidden
- Warning message displayed: "⚠️ You don't have permission to edit your profile. Contact your administrator."
- Bank details edit button is hidden

## Security Features

1. **Controller-Level Protection**: All controller methods check permissions before processing
2. **View-Level Protection**: UI elements are hidden/disabled based on permissions
3. **Double Validation**: Both backend and frontend enforce permissions
4. **Graceful Degradation**: Users without edit permission can still view their profile
5. **Clear Feedback**: Users are informed when they lack permissions

## Consistency with Existing Modules

This implementation follows the exact same pattern as:
- Events Management
- Employees Management
- Attendance Management
- Tickets Management
- Projects Management

All modules use:
- Same permission naming convention: `Module Name.action`
- Same controller-level permission checks
- Same view-level permission checks
- Same role-based access control

## Files Modified

1. `database/seeders/PermissionSeeder.php` - Added profile permissions
2. `app/Http/Controllers/ProfileController.php` - Added permission checks
3. `resources/views/profile/edit.blade.php` - Added UI permission controls
4. `resources/views/profile/partials/bank-details.blade.php` - Added bank edit permission check

## Files Created

1. `assign_profile_permissions.php` - Script to assign permissions to roles
2. `PROFILE_PERMISSIONS_IMPLEMENTATION.md` - This documentation

## Next Steps

1. Run the permission assignment script
2. Test with different user roles
3. Verify all permission checks work correctly
4. Update any custom roles with appropriate profile permissions

## Support

If you encounter any issues:
1. Check that permissions are seeded: `php artisan db:seed --class=PermissionSeeder`
2. Verify role assignments: Check `/roles` page
3. Clear cache: `php artisan cache:clear`
4. Check user's actual permissions: Use the roles management interface
