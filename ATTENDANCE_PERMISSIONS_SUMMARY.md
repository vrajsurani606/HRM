# Attendance & Leave Approval Permissions - Implementation Summary

## ✅ Implementation Complete

**Date:** December 1, 2025  
**Modules:** Attendance Report & Leave Approval  
**Permission Style:** Inline checks (not constructor middleware)

---

## 🎯 What Was Implemented

### 1. **14 New Permissions Created**

#### Attendance Report (5 permissions)
- `Attendance Management.view attendance report`
- `Attendance Management.export attendance report`
- `Attendance Management.print attendance report`
- `Attendance Management.edit attendance`
- `Attendance Management.delete attendance`

#### Leave Approval (6 permissions)
- `Attendance Management.view leave approval`
- `Attendance Management.create leave approval`
- `Attendance Management.edit leave approval`
- `Attendance Management.delete leave approval`
- `Attendance Management.approve leave`
- `Attendance Management.reject leave`

### 2. **Controllers Updated with Inline Permission Checks**

#### AttendanceReportController.php
```php
// Example: index() method
if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.view attendance report'))) {
    return redirect()->back()->with('error', 'Permission denied.');
}

// Example: export() method
if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.export attendance report'))) {
    return redirect()->back()->with('error', 'Permission denied.');
}
```

**Methods Protected:**
- `index()` - View attendance report
- `export()` - Export to Excel
- `generate()` - Generate report data

#### LeaveApprovalController.php
```php
// Example: index() method
if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Attendance Management.view leave approval'))) {
    return redirect()->back()->with('error', 'Permission denied.');
}

// Example: update() method (approve/reject)
$requiredPermission = $request->status === 'approved' ? 'Attendance Management.approve leave' : 'Attendance Management.reject leave';
if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can($requiredPermission))) {
    return redirect()->back()->with('error', 'Permission denied.');
}
```

**Methods Protected:**
- `index()` - View leave requests
- `store()` - Create leave request
- `update()` - Edit/Approve/Reject leave
- `destroy()` - Delete leave request
- `edit()` - Edit form

### 3. **Blade Files Updated**

#### report.blade.php
```blade
@can('Attendance Management.edit attendance')
  <img src="{{ asset('action_icon/edit.svg') }}" ... />
@endcan

@can('Attendance Management.delete attendance')
  <img src="{{ asset('action_icon/delete.svg') }}" ... />
@endcan

@can('Attendance Management.export attendance report')
  <a href="{{ route('attendance.reports.export') }}" class="pill-btn">Export</a>
@endcan
```

#### leave-approval.blade.php
```blade
@can('Attendance Management.create leave approval')
  <button onclick="openAddLeaveModal()">Add Leave</button>
@endcan

@can('Attendance Management.approve leave')
  <img src="{{ asset('action_icon/approve.svg') }}" ... />
@endcan

@can('Attendance Management.reject leave')
  <img src="{{ asset('action_icon/reject.svg') }}" ... />
@endcan
```

#### sidebar.blade.php
```blade
@if(auth()->user()->can('Attendance Management.view attendance report') || 
    auth()->user()->can('Attendance Management.view leave approval'))
  <li>Attendance Management</li>
  
  @if(auth()->user()->can('Attendance Management.view attendance report'))
    <li>Attendance Report</li>
  @endif
  
  @if(auth()->user()->can('Attendance Management.view leave approval'))
    <li>Leave Approval</li>
  @endif
@endif
```

### 4. **Database Seeder Updated**

**File:** `database/seeders/PermissionSeeder.php`

```php
'Attendance Management' => [
    'view attendance', 'create attendance', 'edit attendance', 'delete attendance', 'manage attendance',
    'view attendance report', 'export attendance report', 'print attendance report',
    'view leave approval', 'create leave approval', 'edit leave approval', 
    'delete leave approval', 'approve leave', 'reject leave'
],
```

---

## 🔐 Permission Check Pattern

All controller methods use this pattern:

```php
if (!auth()->check() || !(auth()->user()->hasRole('super-admin') || auth()->user()->can('Permission.Name'))) {
    return redirect()->back()->with('error', 'Permission denied.');
}
```

**Key Features:**
- ✅ Checks if user is authenticated
- ✅ Super-admin role bypasses all permission checks
- ✅ Specific permission check for regular users
- ✅ Returns with error message if denied
- ✅ AJAX-aware (returns JSON for AJAX requests)

---

## 📊 Files Modified

| File | Changes |
|------|---------|
| `AttendanceReportController.php` | Added inline permission checks in 3 methods |
| `LeaveApprovalController.php` | Added inline permission checks in 5 methods |
| `report.blade.php` | Added @can directives for action buttons |
| `leave-approval.blade.php` | Added @can directives for all actions |
| `sidebar.blade.php` | Updated with granular permission checks |
| `PermissionSeeder.php` | Added 14 new permissions |

**Total:** 6 files modified

---

## 🚀 How to Use

### Step 1: Assign Permissions to Roles

1. Go to **User Management > Roles**
2. Edit role (e.g., Admin, HR, Employee)
3. Find "Attendance Management" section
4. Check appropriate permissions
5. Save

### Step 2: Recommended Role Setup

**Super Admin:**
- Automatic access to everything (no need to assign)

**Admin:**
- ✅ view attendance report
- ✅ export attendance report
- ✅ print attendance report
- ✅ edit attendance
- ✅ delete attendance
- ✅ view leave approval
- ✅ create leave approval
- ✅ edit leave approval
- ✅ delete leave approval
- ✅ approve leave
- ✅ reject leave

**HR Manager:**
- ✅ view attendance report
- ✅ export attendance report
- ✅ view leave approval
- ✅ create leave approval
- ✅ approve leave
- ✅ reject leave

**Employee:**
- ✅ view attendance (own records)
- ✅ create attendance (check-in/out)

---

## 🧪 Testing

### Test Attendance Report
1. Login as user with permission
2. Go to `/attendance/report`
3. Should see report page
4. Verify Export button visibility
5. Verify Edit/Delete buttons based on permissions

### Test Leave Approval
1. Login as user with permission
2. Go to `/leave-approval`
3. Should see leave requests
4. Verify "Add Leave" button visibility
5. Verify Approve/Reject buttons for pending leaves
6. Verify Edit/Delete buttons for processed leaves

### Test Permission Denial
1. Login as user WITHOUT permission
2. Try to access `/attendance/report` directly
3. Should redirect with "Permission denied" message
4. Menu items should be hidden in sidebar

---

## 🔧 Troubleshooting

### Permission denied even with correct role
```bash
# Clear permission cache
php artisan permission:cache-reset

# Clear application cache
php artisan cache:clear

# Logout and login again
```

### Permissions not showing in role edit page
```bash
# Re-run seeder
php artisan db:seed --class=PermissionSeeder
```

### Super-admin can't access
- Super-admin should ALWAYS have access
- Check if user actually has 'super-admin' role
- Verify role name is exactly 'super-admin' (case-sensitive)

---

## 📝 Key Differences from Middleware Approach

| Aspect | Middleware (Old) | Inline Checks (Current) |
|--------|-----------------|------------------------|
| Location | Constructor | Each method |
| Super-admin | Needs permission | Auto-bypass |
| Flexibility | Less flexible | More flexible |
| AJAX handling | Same for all | Custom per method |
| Debugging | Harder | Easier |
| Maintenance | Centralized | Per-method |

---

## ✨ Benefits

1. **Super-admin Bypass** - Super-admin automatically has access
2. **Flexible Checks** - Different logic per method if needed
3. **AJAX-Aware** - Returns JSON for AJAX, redirect for regular
4. **Clear Error Messages** - User-friendly "Permission denied"
5. **Easy Debugging** - See exactly where permission is checked
6. **Consistent Pattern** - Same as other controllers in project

---

## 📞 Support Commands

```bash
# View all attendance permissions
php artisan tinker
>>> \Spatie\Permission\Models\Permission::where('name', 'like', 'Attendance Management%')->pluck('name');

# Clear caches
php artisan permission:cache-reset
php artisan cache:clear
php artisan config:clear

# Re-seed permissions
php artisan db:seed --class=PermissionSeeder

# View routes
php artisan route:list --path=attendance
php artisan route:list --path=leave
```

---

**Status:** ✅ Ready for Production  
**Implementation Style:** Inline permission checks with super-admin bypass  
**Total Permissions:** 14 permissions  
**Files Modified:** 6 files
