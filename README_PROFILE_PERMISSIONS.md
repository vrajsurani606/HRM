# Profile Permissions - Complete Implementation Guide

## 🎯 Overview

This implementation adds comprehensive role-based permissions to the Profile Management module, ensuring that **ALL users** (including employees, receptionists, customers, and any custom roles) can access and edit their own profiles while maintaining proper access control.

## ⚡ Quick Start

### One-Command Setup
```bash
# Step 1: Seed permissions
php artisan db:seed --class=PermissionSeeder

# Step 2: Assign to all roles (automatic)
php sync_all_profile_permissions.php

# Done! ✅
```

That's it! All roles now have appropriate profile access.

## 📚 Documentation Files

| File | Purpose | When to Use |
|------|---------|-------------|
| `README_PROFILE_PERMISSIONS.md` | **This file** - Start here | Overview and quick start |
| `PROFILE_SETUP_COMPLETE.md` | Complete implementation details | Full understanding |
| `PROFILE_PERMISSIONS_QUICK_REFERENCE.md` | Quick reference card | Daily reference |
| `PROFILE_PERMISSIONS_SUMMARY.md` | Executive summary | Quick overview |
| `PROFILE_PERMISSIONS_IMPLEMENTATION.md` | Technical details | Deep dive |
| `PROFILE_PERMISSIONS_DIAGRAM.txt` | Visual diagrams | Visual learners |

## 🎁 What You Get

### ✅ Automatic Default Permissions
Every role in your system automatically receives:
- View own profile
- Edit own profile

This includes:
- Employee ✓
- Receptionist ✓
- Customer ✓
- Any custom roles ✓
- Future roles ✓

### ✅ Special Permissions
- **Super Admin:** Full access + delete capability
- **Admin:** Full access to all profiles
- **HR:** Own profile + bank details management

### ✅ Security Features
- Controller-level permission checks
- View-level UI controls
- Graceful permission denial
- Clear user feedback

### ✅ User Experience
- Editable fields for authorized users
- Readonly fields for unauthorized users
- Hidden buttons when no permission
- Warning messages when appropriate

## 🔧 Scripts Provided

### `sync_all_profile_permissions.php` (Recommended)
**Purpose:** Comprehensive permission sync for all roles

**Features:**
- ✅ Creates all permissions
- ✅ Finds ALL roles automatically
- ✅ Assigns default permissions to every role
- ✅ Assigns special permissions to admin/hr
- ✅ Preserves existing permissions
- ✅ Shows detailed report

**Usage:**
```bash
php sync_all_profile_permissions.php
```

**Output:**
```
╔════════════════════════════════════════════════════════════╗
║     Profile Permissions Sync - All Roles                   ║
╚════════════════════════════════════════════════════════════╝

Step 1: Creating/Verifying Profile Permissions...
  ✓ Profile Management.view profile
  ✓ Profile Management.edit profile
  ...

Step 2: Loading All Roles...
  Found 6 roles in the system

Step 3: Assigning Permissions by Role Type...
  ✓ super-admin - Updated (SPECIFIC, +7 permissions)
  ✓ admin - Updated (SPECIFIC, +6 permissions)
  ✓ hr - Updated (SPECIFIC, +3 permissions)
  ✓ employee - Updated (DEFAULT, +2 permissions)
  ✓ receptionist - Updated (DEFAULT, +2 permissions)
  ✓ customer - Updated (DEFAULT, +2 permissions)

╔════════════════════════════════════════════════════════════╗
║                    SUMMARY REPORT                          ║
╠════════════════════════════════════════════════════════════╣
║  Total Roles Processed:  6                                 ║
║  Roles Updated:          6                                 ║
║  Roles Unchanged:        0                                 ║
╚════════════════════════════════════════════════════════════╝

✅ Profile permissions sync completed successfully!
```

### `assign_profile_permissions.php` (Alternative)
**Purpose:** Original permission assignment script

**Usage:**
```bash
php assign_profile_permissions.php
```

Both scripts are safe to run multiple times.

## 📊 Permission Structure

### All 7 Permissions

```
Profile Management.view profile          → View any user's profile
Profile Management.edit profile          → Edit any user's profile
Profile Management.update profile        → Update any user's profile
Profile Management.update bank details   → Update bank information
Profile Management.delete profile        → Delete profiles
Profile Management.view own profile      → View own profile (DEFAULT)
Profile Management.edit own profile      → Edit own profile (DEFAULT)
```

### Role Assignments

| Role | Permissions Count | Access Level |
|------|-------------------|--------------|
| Super Admin | 7 | Full access + delete |
| Admin | 6 | Full access (no delete) |
| HR | 3 | Own profile + bank |
| Employee | 2 | Own profile only |
| Receptionist | 2 | Own profile only |
| Customer | 2 | Own profile only |
| Custom Roles | 2 | Own profile only |

## 🧪 Testing

### Test Checklist

- [ ] Run setup commands
- [ ] Login as employee → Access `/profile` → Should work ✓
- [ ] Login as admin → Access `/profile` → Should work ✓
- [ ] Login as HR → Access `/profile` → Should work ✓
- [ ] Login as customer → Access `/profile` → Should work ✓
- [ ] Check `/roles` page → Profile Management module visible ✓
- [ ] Verify employee has 2 permissions ✓
- [ ] Verify admin has 6 permissions ✓

### Expected Behavior

**Employee accessing profile:**
```
✓ Page loads
✓ Can see all fields
✓ Can edit all fields
✓ Can save changes
✓ Can update bank details (if HR gave permission)
✗ Cannot access other users' profiles
```

**Admin accessing profile:**
```
✓ Page loads
✓ Can see all fields
✓ Can edit all fields
✓ Can save changes
✓ Can update bank details
✓ Can access other users' profiles (if implemented)
```

## 🔍 Troubleshooting

### Issue: Employee can't access profile
**Solution:**
```bash
php sync_all_profile_permissions.php
```

### Issue: Fields are readonly
**Check:** User has "edit own profile" permission
```bash
# Re-run sync
php sync_all_profile_permissions.php
```

### Issue: New role doesn't work
**Solution:** Sync script handles all roles automatically
```bash
php sync_all_profile_permissions.php
```

### Issue: Permissions not showing
**Solution:**
```bash
# Seed first, then sync
php artisan db:seed --class=PermissionSeeder
php sync_all_profile_permissions.php
```

## 📁 Modified Files

### Backend
- `database/seeders/PermissionSeeder.php` - Added profile permissions
- `app/Http/Controllers/ProfileController.php` - Added permission checks

### Frontend
- `resources/views/profile/edit.blade.php` - Added UI controls
- `resources/views/profile/partials/bank-details.blade.php` - Added bank permission check

### Scripts
- `sync_all_profile_permissions.php` - Comprehensive sync (NEW)
- `assign_profile_permissions.php` - Original assignment script

### Documentation
- Multiple markdown files for reference

## 🎓 Best Practices

### DO ✅
- Run sync script after creating new roles
- Test with different user roles
- Use the sync script for updates
- Check the roles page to verify

### DON'T ❌
- Manually assign "view own profile" and "edit own profile"
- Remove default permissions from roles
- Skip testing after changes
- Forget to seed permissions first

## 🚀 Deployment

### Production Deployment
```bash
# On production server
php artisan db:seed --class=PermissionSeeder
php sync_all_profile_permissions.php

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Rollback (if needed)
The scripts preserve existing permissions, so rollback is safe. Simply:
1. Remove profile permissions from roles via admin panel
2. Or restore database backup

## 📞 Support

### Common Questions

**Q: Do I need to run this for every new role?**
A: No! The sync script automatically handles ALL roles, including new ones.

**Q: Will this affect existing permissions?**
A: No, the script preserves all existing permissions and only adds profile permissions.

**Q: Can I customize permissions per role?**
A: Yes, use the admin panel at `/roles` to customize any role.

**Q: What if I have custom roles?**
A: They automatically get default permissions (view own, edit own).

## ✨ Features

- ✅ Automatic role detection
- ✅ Default permissions for all roles
- ✅ Special permissions for admin/hr
- ✅ Preserves existing permissions
- ✅ Safe to run multiple times
- ✅ Detailed reporting
- ✅ Zero manual configuration
- ✅ Production ready

## 🎉 Success!

After running the setup, you should have:
- ✅ All roles with profile access
- ✅ Employees can edit their profiles
- ✅ Admins can manage all profiles
- ✅ HR can manage bank details
- ✅ Proper permission checks everywhere
- ✅ Clean, maintainable code

## 📖 Further Reading

- `PROFILE_SETUP_COMPLETE.md` - Complete implementation details
- `PROFILE_PERMISSIONS_QUICK_REFERENCE.md` - Quick reference card
- `PROFILE_PERMISSIONS_DIAGRAM.txt` - Visual diagrams

---

**Version:** 1.0  
**Status:** ✅ Production Ready  
**Last Updated:** December 2024  
**Compatibility:** Laravel 12.x, Spatie Permission 6.x

---

**Need Help?** Check the troubleshooting section or review the detailed documentation files.
