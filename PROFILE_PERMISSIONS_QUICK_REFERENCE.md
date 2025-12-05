# Profile Permissions - Quick Reference Card

## 🚀 One Command Setup

```bash
php sync_all_profile_permissions.php
```

This single command:
- ✅ Creates all profile permissions
- ✅ Assigns permissions to ALL roles automatically
- ✅ Gives default access to employee, receptionist, customer, and any custom roles
- ✅ Preserves existing permissions
- ✅ Shows detailed report

---

## 📋 What Each Role Can Do

### 🔴 Super Admin
```
✓ View ANY user's profile
✓ Edit ANY user's profile
✓ Update ANY user's bank details
✓ Delete profiles
✓ View/edit own profile
```

### 🟠 Admin
```
✓ View ANY user's profile
✓ Edit ANY user's profile
✓ Update ANY user's bank details
✗ Cannot delete profiles
✓ View/edit own profile
```

### 🟡 HR
```
✗ Cannot view other profiles
✗ Cannot edit other profiles
✓ Update bank details (for payroll)
✓ View/edit own profile
```

### 🟢 Employee / Receptionist / Customer / Any Other Role
```
✗ Cannot view other profiles
✗ Cannot edit other profiles
✗ Cannot update bank details
✓ View own profile
✓ Edit own profile
```

---

## 🎯 Default Permissions (Auto-Assigned to ALL Roles)

Every role in the system automatically gets:
1. **Profile Management.view own profile**
2. **Profile Management.edit own profile**

This means:
- ✅ All employees can access `/profile`
- ✅ All employees can update their personal information
- ✅ No manual configuration needed for new roles

---

## 🔧 Manual Permission Assignment

If you need to customize permissions for a specific role:

1. Go to: `http://localhost/GitVraj/HrPortal/roles`
2. Click "Edit" on the role
3. Find "Profile Management" section
4. Check/uncheck desired permissions
5. Save

---

## 📊 Permission List

| Permission | Description | Default Roles |
|------------|-------------|---------------|
| `view profile` | View any user's profile | Super Admin, Admin |
| `edit profile` | Edit any user's profile | Super Admin, Admin |
| `update profile` | Update any user's profile | Super Admin, Admin |
| `update bank details` | Update bank information | Super Admin, Admin, HR |
| `delete profile` | Delete user profiles | Super Admin only |
| `view own profile` | View own profile | **ALL ROLES** |
| `edit own profile` | Edit own profile | **ALL ROLES** |

---

## 🧪 Testing

### Test as Employee:
```
1. Login as employee user
2. Go to /profile
3. Should see: ✓ Profile page loads
4. Should see: ✓ All fields are editable
5. Should see: ✓ Save button visible
6. Should NOT see: ✗ Other users' profiles
```

### Test as Admin:
```
1. Login as admin user
2. Go to /profile
3. Should see: ✓ Profile page loads
4. Should see: ✓ All fields are editable
5. Should see: ✓ Bank details editable
6. Can access: ✓ Other users' profiles (if implemented)
```

### Test Without Permissions:
```
1. Remove profile permissions from a test role
2. Login as that user
3. Go to /profile
4. Should see: ✗ 403 Forbidden error
```

---

## 🔍 Troubleshooting

### Problem: User can't access profile page
**Solution:**
```bash
php sync_all_profile_permissions.php
```

### Problem: Fields are readonly
**Check:** User has "edit own profile" permission
```bash
# Re-run sync script
php sync_all_profile_permissions.php
```

### Problem: New role doesn't have profile access
**Solution:** The sync script automatically handles ALL roles
```bash
php sync_all_profile_permissions.php
```

### Problem: Permissions not showing in roles page
**Solution:** Seed permissions first
```bash
php artisan db:seed --class=PermissionSeeder
php sync_all_profile_permissions.php
```

---

## 📝 Notes

- **Automatic:** All roles get default profile access automatically
- **Safe:** Scripts preserve existing permissions
- **Flexible:** Can customize per role via admin interface
- **Consistent:** Follows same pattern as Events Management
- **Tested:** Works with employee, receptionist, customer, and custom roles

---

## 🎓 Best Practices

1. **Always run sync script after:**
   - Creating new roles
   - Seeding permissions
   - System updates

2. **Don't manually assign** "view own profile" and "edit own profile"
   - The script does this automatically for ALL roles

3. **Only customize** special permissions:
   - view profile (for admins)
   - edit profile (for admins)
   - update bank details (for HR/admins)
   - delete profile (for super admin only)

4. **Test with different roles** after making changes

---

## ✅ Verification Checklist

After running the sync script:

- [ ] Visit `/roles` page
- [ ] Check "Profile Management" module exists
- [ ] Verify super-admin has all 7 permissions
- [ ] Verify admin has 6 permissions (no delete)
- [ ] Verify hr has 3 permissions
- [ ] Verify employee has 2 permissions (view own, edit own)
- [ ] Verify receptionist has 2 permissions (view own, edit own)
- [ ] Verify customer has 2 permissions (view own, edit own)
- [ ] Test login as employee → can access `/profile`
- [ ] Test login as admin → can access `/profile` with full edit

---

**Last Updated:** December 2024
**Version:** 1.0
**Status:** ✅ Production Ready
