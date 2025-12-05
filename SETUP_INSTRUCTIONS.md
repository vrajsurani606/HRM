# Profile Permissions Setup - Quick Instructions

## Problem
Profile Management permissions are not showing at: `http://localhost/GitVraj/HrPortal/roles/4/edit`

## Solution - Run This Command

### Windows (Easy Way)
Double-click: **`RUN_THIS_SETUP_PROFILE.bat`**

### Command Line (Any OS)
```bash
php setup_profile_permissions_complete.php
```

## What This Does

1. ✅ Runs the permission seeder
2. ✅ Creates all 7 profile permissions
3. ✅ Assigns permissions to ALL roles automatically
4. ✅ Verifies everything is working
5. ✅ Shows detailed report

## Expected Output

```
╔════════════════════════════════════════════════════════════╗
║     Profile Permissions - Complete Setup                  ║
╚════════════════════════════════════════════════════════════╝

Step 1: Running Permission Seeder...
  ✓ Permission seeder executed successfully

Step 2: Verifying Profile Permissions...
  ✓ Created: Profile Management.view profile
  ✓ Created: Profile Management.edit profile
  ...

Step 3: Loading All Roles...
  Found 6 roles in the system:
    • super-admin
    • admin
    • hr
    • employee
    • receptionist
    • customer

Step 4: Assigning Profile Permissions to Roles...
  ✓ super-admin - SPECIFIC (7 profile permissions)
  ✓ admin - SPECIFIC (6 profile permissions)
  ✓ hr - SPECIFIC (3 profile permissions)
  ✓ employee - DEFAULT (2 profile permissions)
  ✓ receptionist - DEFAULT (2 profile permissions)
  ✓ customer - DEFAULT (2 profile permissions)

╔════════════════════════════════════════════════════════════╗
║                    SETUP COMPLETE                          ║
╠════════════════════════════════════════════════════════════╣
║  Total Roles:            6                                 ║
║  Roles Updated:          6                                 ║
║  Verification:           ✓ PASSED                          ║
╚════════════════════════════════════════════════════════════╝

✅ SUCCESS! Profile permissions are now set up correctly.
```

## After Running

1. **Refresh the roles page:** `http://localhost/GitVraj/HrPortal/roles/4/edit`
2. **Look for:** "Profile Management" section
3. **You should see:** 7 permissions listed
4. **Test profile:** `http://localhost/GitVraj/HrPortal/profile`

## Check Status (Without Making Changes)

To see current status without making changes:
```bash
php check_profile_permissions_status.php
```

## What You'll See in Roles Page

After running the setup, when you edit any role, you'll see:

```
Profile Management
├─ View Profile
├─ Edit Profile
├─ Update Profile
├─ Update Bank Details
├─ Delete Profile
├─ View Own Profile
└─ Edit Own Profile
```

## Permission Assignments

| Role | Permissions |
|------|-------------|
| Super Admin | All 7 permissions |
| Admin | 6 permissions (no delete) |
| HR | 3 permissions (own + bank) |
| Employee | 2 permissions (view own, edit own) |
| Receptionist | 2 permissions (view own, edit own) |
| Customer | 2 permissions (view own, edit own) |

## Troubleshooting

### Issue: Permissions still not showing
**Solution:**
1. Clear browser cache
2. Refresh the page (Ctrl+F5)
3. Check database: Run `php check_profile_permissions_status.php`

### Issue: Script errors
**Solution:**
1. Make sure you're in the project root directory
2. Check PHP version (should be 8.1+)
3. Verify database connection

### Issue: Role 4 doesn't exist
**Solution:**
- Use any role ID that exists in your system
- Check available roles at: `http://localhost/GitVraj/HrPortal/roles`

## Files Created

- ✅ `setup_profile_permissions_complete.php` - Main setup script
- ✅ `check_profile_permissions_status.php` - Status checker
- ✅ `RUN_THIS_SETUP_PROFILE.bat` - Windows batch file
- ✅ `SETUP_INSTRUCTIONS.md` - This file

## Need Help?

1. Run status check: `php check_profile_permissions_status.php`
2. Check the detailed documentation files
3. Verify database connection is working
4. Make sure Spatie Permission package is installed

---

**Quick Start:** Just run `RUN_THIS_SETUP_PROFILE.bat` (Windows) or `php setup_profile_permissions_complete.php` (any OS)
