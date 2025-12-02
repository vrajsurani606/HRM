# Tickets Permissions - Blade Files Update

## ✅ Update Complete

**Date:** December 1, 2025  
**Module:** Tickets Management  
**Files Updated:** 2 blade files  
**Pattern:** Updated from `@can` to `@if(hasRole || can)` with super-admin bypass

---

## 🎯 What Was Updated

### File: `resources/views/tickets/index.blade.php`

All permission checks updated to include super-admin bypass:

#### 1. **Add Ticket Button**
```blade
@if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.create ticket'))
  <button onclick="openAddTicketModal()">Add Ticket</button>
@endif
```

#### 2. **Action Buttons (View, Edit, Delete)**
```blade
@if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.view ticket'))
  <img src="view.svg" onclick="viewTicket(id)">
@endif

@if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.edit ticket'))
  <img src="edit.svg" onclick="editTicket(id)">
@endif

@if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.delete ticket'))
  <img src="delete.svg" onclick="deleteTicket(id)">
@endif
```

#### 3. **Assign Employee Button**
```blade
@if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.assign ticket'))
  <button onclick="assignTicket(id)">Assign Employee</button>
@endif
```

#### 4. **Reassign Button**
```blade
@if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.reassign ticket'))
  <button onclick="assignTicket(id)">Reassign</button>
@endif
```

#### 5. **Modal Form Fields**

**Ticket Status Field:**
```blade
@if(auth()->user()->hasRole('super-admin') || 
    auth()->user()->can('Tickets Management.change status') || 
    auth()->user()->can('Tickets Management.create ticket'))
  <select name="status">...</select>
@endif
```

**Work Status Field:**
```blade
@if(auth()->user()->hasRole('super-admin') || 
    auth()->user()->can('Tickets Management.change work status') || 
    auth()->user()->can('Tickets Management.create ticket'))
  <select name="work_status">...</select>
@endif
```

**Assign Employee Field:**
```blade
@if(auth()->user()->hasRole('super-admin') || 
    auth()->user()->can('Tickets Management.assign ticket') || 
    auth()->user()->can('Tickets Management.reassign ticket') || 
    auth()->user()->can('Tickets Management.create ticket'))
  <select name="assigned_to">...</select>
@endif
```

---

## 📊 Permissions Used

| Permission | Description | Used In |
|------------|-------------|---------|
| `Tickets Management.view ticket` | View ticket details | View button |
| `Tickets Management.create ticket` | Create new ticket | Add button, form fields |
| `Tickets Management.edit ticket` | Edit ticket | Edit button |
| `Tickets Management.delete ticket` | Delete ticket | Delete button |
| `Tickets Management.assign ticket` | Assign ticket to employee | Assign button, form field |
| `Tickets Management.reassign ticket` | Reassign ticket | Reassign button, form field |
| `Tickets Management.change status` | Change ticket status | Status field in form |
| `Tickets Management.change work status` | Change work status | Work status field in form |

---

## 🔄 Changes Made

### Before (Old Pattern):
```blade
@can('Tickets Management.create ticket')
  <button>Add Ticket</button>
@endcan
```

### After (New Pattern):
```blade
@if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Tickets Management.create ticket'))
  <button>Add Ticket</button>
@endif
```

---

## ✨ Key Features

✅ **Super-admin bypass** - Super-admin sees all buttons and fields  
✅ **Permission-based visibility** - Regular users see only what they can access  
✅ **Consistent pattern** - Same as other modules (Attendance, Leave, Rules)  
✅ **Granular control** - Each button/field controlled separately  
✅ **Clean UI** - No confusing errors, just hidden elements

---

## 🧪 Testing Checklist

### Test as Super-Admin
- [ ] All action buttons visible (View, Edit, Delete)
- [ ] "Add Ticket" button visible
- [ ] "Assign Employee" button visible
- [ ] "Reassign" button visible
- [ ] All form fields visible in modal
- [ ] No permission errors

### Test as Admin (with all permissions)
- [ ] All action buttons visible
- [ ] "Add Ticket" button visible
- [ ] "Assign Employee" button visible
- [ ] "Reassign" button visible
- [ ] All form fields visible
- [ ] No permission errors

### Test as User (with limited permissions)
- [ ] Only assigned buttons visible
- [ ] Form fields visible based on permissions
- [ ] No permission errors

### Test as User (without permissions)
- [ ] No action buttons visible
- [ ] "Add Ticket" button hidden
- [ ] Assign buttons hidden
- [ ] Limited form fields visible
- [ ] No permission errors

---

## 📝 Summary

**Files Updated:** 2 files
- ✅ `resources/views/tickets/index.blade.php`
- ✅ `resources/views/tickets/create.blade.php` (verified, no changes needed)

**Permission Checks Updated:** 8 locations
- ✅ Add Ticket button
- ✅ View button
- ✅ Edit button
- ✅ Delete button
- ✅ Assign button
- ✅ Reassign button
- ✅ Status field
- ✅ Work status field
- ✅ Assign employee field

**Pattern Used:** `@if(auth()->user()->hasRole('super-admin') || auth()->user()->can('Permission'))`

**Status:** ✅ Complete and Consistent with Other Modules

---

## 🎯 Benefits

1. **Consistency** - Same pattern as Attendance, Leave, and Rules modules
2. **Super-admin Access** - Super-admin automatically sees everything
3. **Clean UI** - Users only see what they can use
4. **Security** - Multiple layers of protection
5. **Maintainability** - Easy to understand and modify

---

**Last Updated:** December 1, 2025  
**Implementation Style:** Inline permission checks with super-admin bypass  
**Module:** Tickets Management  
**Status:** ✅ Complete
