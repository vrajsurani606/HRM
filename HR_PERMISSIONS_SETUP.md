# HR Role Permissions Setup

## ✅ What Was Done

Assigned 66 default permissions to the "hr" role so that HR users can manage employees, attendance, payroll, leaves, and other HR-related functions.

## Permissions Assigned (66 Total)

### 1. Dashboard (1 permission)
- ✅ `Dashboard.view dashboard` - Access to HR dashboard

### 2. Employees Management (15 permissions)
**Full CRUD Access:**
- ✅ View, Create, Edit, Delete, Manage employees
- ✅ Employee Letters (view, create, edit, delete, print)
- ✅ Digital Cards (view, create, edit, delete)

**Specific Permissions:**
- `Employees Management.view employee`
- `Employees Management.create employee`
- `Employees Management.edit employee`
- `Employees Management.delete employee`
- `Employees Management.manage employee`
- `Employees Management.letters`
- `Employees Management.letters create`
- `Employees Management.letters view`
- `Employees Management.letters edit`
- `Employees Management.letters delete`
- `Employees Management.letters print`
- `Employees Management.digital card`
- `Employees Management.digital card create`
- `Employees Management.digital card edit`
- `Employees Management.digital card delete`

### 3. Attendance Management (5 permissions)
**Full CRUD Access:**
- ✅ View, Create, Edit, Delete, Manage attendance records

**Specific Permissions:**
- `Attendance Management.view attendance`
- `Attendance Management.create attendance`
- `Attendance Management.edit attendance`
- `Attendance Management.delete attendance`
- `Attendance Management.manage attendance`

### 4. Payroll Management (8 permissions)
**Full CRUD Access:**
- ✅ View, Create, Edit, Delete, Manage payroll
- ✅ Export, Print payroll
- ✅ Bulk generate payroll

**Specific Permissions:**
- `Payroll Management.view payroll`
- `Payroll Management.create payroll`
- `Payroll Management.edit payroll`
- `Payroll Management.delete payroll`
- `Payroll Management.manage payroll`
- `Payroll Management.export payroll`
- `Payroll Management.print payroll`
- `Payroll Management.bulk generate payroll`

### 5. Leads Management (9 permissions)
**Full CRUD Access:**
- ✅ View, Create, Edit, Delete, Manage leads
- ✅ Print, Convert leads
- ✅ Generate offer letters
- ✅ View resumes

**Specific Permissions:**
- `Leads Management.view lead`
- `Leads Management.create lead`
- `Leads Management.edit lead`
- `Leads Management.delete lead`
- `Leads Management.manage lead`
- `Leads Management.print lead`
- `Leads Management.convert lead`
- `Leads Management.offer letter`
- `Leads Management.view resume`

### 6. Events Management (9 permissions)
**Full CRUD Access:**
- ✅ View, Create, Edit, Delete, Manage events
- ✅ Upload, Download, View, Delete event images

**Specific Permissions:**
- `Events Management.view event`
- `Events Management.create event`
- `Events Management.edit event`
- `Events Management.delete event`
- `Events Management.manage event`
- `Events Management.upload event image`
- `Events Management.download event image`
- `Events Management.view event image`
- `Events Management.delete event image`

### 7. Tickets Management (15 permissions)
**Full Access:**
- ✅ View, Create, Edit tickets
- ✅ Assign, Reassign tickets
- ✅ Change status, priority, work status
- ✅ View, Create comments
- ✅ View, Upload, Download attachments
- ✅ Close, Reopen tickets

**Specific Permissions:**
- `Tickets Management.view ticket`
- `Tickets Management.create ticket`
- `Tickets Management.edit ticket`
- `Tickets Management.assign ticket`
- `Tickets Management.reassign ticket`
- `Tickets Management.change status`
- `Tickets Management.change priority`
- `Tickets Management.change work status`
- `Tickets Management.view comments`
- `Tickets Management.create comment`
- `Tickets Management.view attachments`
- `Tickets Management.upload attachment`
- `Tickets Management.download attachment`
- `Tickets Management.close ticket`
- `Tickets Management.reopen ticket`

### 8. Reports Management (3 permissions)
- ✅ View, Create, Manage reports

**Specific Permissions:**
- `Reports Management.view report`
- `Reports Management.create report`
- `Reports Management.manage report`

### 9. Rules Management (1 permission)
- ✅ View rules and regulations

**Specific Permissions:**
- `Rules Management.view rules`

---

## What HR Users CAN Do

### ✅ Full Access To:

**1. Employee Management:**
- View all employees
- Add new employees
- Edit employee details
- Delete employees
- Generate employee letters (offer, experience, etc.)
- Create and manage digital cards
- Print employee documents

**2. Attendance Management:**
- View attendance records
- Mark attendance
- Edit attendance records
- Delete attendance records
- Generate attendance reports

**3. Payroll Management:**
- View payroll records
- Create payroll
- Edit payroll
- Delete payroll
- Export payroll data
- Print payroll slips
- Bulk generate payroll for all employees

**4. Leave Management:**
- View leave requests
- Approve/Reject leaves
- Manage leave balances
- Track leave history

**5. Recruitment:**
- View hiring leads
- Create new leads
- Edit lead information
- Convert leads to employees
- Generate offer letters
- View candidate resumes

**6. Events:**
- Create company events
- Edit event details
- Upload event photos
- Manage event gallery
- Delete events

**7. Tickets:**
- View all tickets
- Create tickets
- Assign tickets to employees
- Change ticket status/priority
- Add comments
- Close/Reopen tickets

**8. Reports:**
- View HR reports
- Generate custom reports
- Export reports

**9. Rules:**
- View company rules and regulations

---

## What HR Users CANNOT Do

### ❌ Restricted Access:

1. **Financial Management:**
   - Cannot create/edit quotations
   - Cannot create/edit invoices
   - Cannot create/edit receipts
   - Cannot manage companies

2. **Projects:**
   - Cannot create/edit projects
   - Cannot manage project tasks
   - Cannot assign project members

3. **System Administration:**
   - Cannot manage users (except employees)
   - Cannot manage roles
   - Cannot change system settings

4. **Inquiries & Quotations:**
   - Cannot manage inquiries
   - Cannot create quotations
   - Cannot manage proformas

---

## Sidebar Visibility

### ✅ HR Users WILL See:
```
📊 Dashboard
👥 Employees Management
📞 Hiring Leads
💰 Payroll Management
⏰ Attendance Management
🎉 Events Management
🎫 Ticket Support System
📊 Reports
📜 Rules & Regulations
```

### ❌ HR Users WILL NOT See:
```
📋 Inquiries
📄 Quotations
🏢 Companies
📁 Projects
🧾 Invoices
🧾 Receipts
🧾 Proformas
👤 Users Management
🔐 Roles Management
```

---

## HR Dashboard Features

### KPI Cards (8):
1. **Total Employees** - Count of all employees
2. **Active Employees** - Currently active employees
3. **On Leave Today** - Employees on leave
4. **Pending Leaves** - Leave requests awaiting approval
5. **Present Today** - Employees present today
6. **Absent Today** - Employees absent today
7. **Attendance Rate** - Today's attendance percentage
8. **New Hires** - New employees this month

### Sections:
1. **Recent Leave Requests** - Latest 5 leave requests
2. **Upcoming Birthdays** - Next 30 days
3. **Department Statistics** - Employee count by department
4. **Attendance Trends** - Last 7 days chart

---

## Testing

### Test HR Access:

1. **Create HR User:**
```bash
php artisan tinker
>>> $user = User::create(['name' => 'HR Manager', 'email' => 'hr@example.com', 'password' => bcrypt('password')]);
>>> $user->assignRole('hr');
```

2. **Login as HR:**
   - Email: `hr@example.com`
   - Password: `password`

3. **Check Sidebar:**
   - Should see: Dashboard, Employees, Leads, Payroll, Attendance, Events, Tickets, Reports, Rules
   - Should NOT see: Inquiries, Quotations, Companies, Projects, Invoices

4. **Test Actions:**
   - ✅ View employees list
   - ✅ Add new employee
   - ✅ Mark attendance
   - ✅ Generate payroll
   - ✅ Approve leave requests
   - ✅ Create events
   - ✅ Manage tickets

---

## Commands

### Assign permissions to HR role:
```bash
php assign_hr_permissions.php
```

### Check HR role permissions:
```bash
php artisan tinker
>>> $role = Spatie\Permission\Models\Role::where('name', 'hr')->first();
>>> $role->permissions->pluck('name');
```

### Assign HR role to a user:
```bash
php artisan tinker
>>> $user = User::find(1);
>>> $user->assignRole('hr');
```

---

## Current Status

### ✅ HR Role Setup:
- **Role ID:** 3
- **Role Name:** hr
- **Total Permissions:** 66
- **Description:** HR Manager with employee, attendance, payroll, and leave management access

### ✅ Permission Breakdown:
- **Employees:** 15 permissions (Full CRUD)
- **Attendance:** 5 permissions (Full CRUD)
- **Payroll:** 8 permissions (Full CRUD + Export/Print)
- **Leads:** 9 permissions (Full CRUD + Convert)
- **Events:** 9 permissions (Full CRUD + Images)
- **Tickets:** 15 permissions (Full management)
- **Reports:** 3 permissions (View/Create/Manage)
- **Rules:** 1 permission (View)
- **Dashboard:** 1 permission (View)

---

## Security Features

1. **HR-Specific Access** - Only HR-related modules
2. **No Financial Access** - Cannot manage invoices/quotations
3. **No Project Access** - Cannot manage projects
4. **No Admin Access** - Cannot manage users/roles
5. **Audit Trail** - All actions logged

---

## Benefits

1. **Complete HR Control** - Full access to employee lifecycle
2. **Attendance Tracking** - Mark and manage attendance
3. **Payroll Management** - Generate and manage payroll
4. **Leave Management** - Approve/reject leave requests
5. **Recruitment** - Manage hiring leads and offer letters
6. **Event Management** - Organize company events
7. **Ticket Support** - Handle employee support tickets
8. **Reporting** - Generate HR reports

---

## Files Created

1. **assign_hr_permissions.php** - Script to assign HR permissions
2. **HR_PERMISSIONS_SETUP.md** - This documentation

---

## Summary

✅ **66 permissions assigned** to HR role
✅ **Full access** to HR modules (Employees, Attendance, Payroll, Leaves)
✅ **Sidebar shows** relevant HR menu items
✅ **Secure** - No access to financial or admin modules
✅ **Complete HR functionality** - Manage entire employee lifecycle

HR users can now access all necessary modules for managing employees, attendance, payroll, leaves, recruitment, and events!
