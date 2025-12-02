# Employee Role Permissions Setup

## ✅ What Was Done

Assigned 23 default permissions to the "employee" role so that employees can access their dashboard, view attendance, work on assigned projects, and create support tickets.

## Permissions Assigned (23 Total)

### 1. Dashboard (1 permission)
- ✅ `Dashboard.view dashboard` - Access to employee dashboard

### 2. Projects Management (9 permissions)
**View & Participate:**
- ✅ View projects they're assigned to
- ✅ View project overview
- ✅ View tasks, members, comments, attachments
- ✅ Create comments
- ✅ Download attachments
- ✅ Complete tasks

**Specific Permissions:**
- `Projects Management.view project`
- `Projects Management.project overview`
- `Projects Management.view tasks`
- `Projects Management.view members`
- `Projects Management.view comments`
- `Projects Management.create comment`
- `Projects Management.view attachments`
- `Projects Management.download attachment`
- `Projects Management.complete task`

### 3. Tickets Management (8 permissions)
**Create & Manage Own Tickets:**
- ✅ View tickets
- ✅ Create tickets
- ✅ Edit their own tickets
- ✅ View, create comments
- ✅ View, upload, download attachments

**Specific Permissions:**
- `Tickets Management.view ticket`
- `Tickets Management.create ticket`
- `Tickets Management.edit ticket`
- `Tickets Management.view comments`
- `Tickets Management.create comment`
- `Tickets Management.view attachments`
- `Tickets Management.upload attachment`
- `Tickets Management.download attachment`

### 4. Attendance Management (1 permission)
**View Own Attendance:**
- ✅ View their own attendance records

**Specific Permissions:**
- `Attendance Management.view attendance`

### 5. Events Management (3 permissions)
**View Company Events:**
- ✅ View events
- ✅ View event images
- ✅ Download event images

**Specific Permissions:**
- `Events Management.view event`
- `Events Management.view event image`
- `Events Management.download event image`

### 6. Rules Management (1 permission)
**View Company Rules:**
- ✅ View rules and regulations

**Specific Permissions:**
- `Rules Management.view rules`

---

## What Employees CAN Do

### ✅ Allowed Actions:

**1. Dashboard:**
- View their employee dashboard
- See attendance stats (present days, absent days, working hours)
- View active projects count
- See late entries and early exits
- View upcoming birthdays
- Check personal notes

**2. Projects:**
- View projects they're assigned to
- Click projects to see overview
- View project tasks
- View project members
- View project comments
- Add comments to projects
- Download project attachments
- Mark tasks as complete

**3. Tickets:**
- Create support tickets
- View their own tickets
- Edit their own tickets
- Add comments to tickets
- Upload files to tickets
- Download ticket attachments

**4. Attendance:**
- View their own attendance records
- Check present/absent days
- View working hours
- See late entries and early exits

**5. Events:**
- View company events
- See event details
- View event photos
- Download event images

**6. Rules:**
- View company rules and regulations
- Read company policies

---

## What Employees CANNOT Do

### ❌ Restricted Actions:

**Projects:**
- Cannot create/edit/delete projects
- Cannot add/remove project members
- Cannot delete project comments
- Cannot delete tasks
- Cannot upload project attachments

**Tickets:**
- Cannot assign tickets to others
- Cannot change ticket status (only HR/Admin)
- Cannot change ticket priority
- Cannot delete tickets
- Cannot view other employees' tickets

**Attendance:**
- Cannot mark their own attendance
- Cannot edit attendance records
- Cannot view other employees' attendance

**HR Functions:**
- Cannot view other employees' data
- Cannot manage payroll
- Cannot approve leaves
- Cannot manage hiring leads

**Financial:**
- Cannot view quotations
- Cannot view invoices
- Cannot view receipts
- Cannot manage companies

**Admin:**
- Cannot manage users
- Cannot manage roles
- Cannot access admin functions

---

## Sidebar Visibility

### ✅ Employees WILL See:
```
📊 Dashboard
📁 Project & Task Management
🎫 Ticket Support System
🎉 Events
📜 Rules & Regulations
```

### ❌ Employees WILL NOT See:
```
👥 Employees Management
📞 Hiring Leads
💰 Payroll Management
⏰ Attendance Management (full module)
📋 Inquiries
📄 Quotations
🏢 Companies
🧾 Invoices
🧾 Receipts
📊 Reports
👤 Users Management
🔐 Roles Management
```

---

## Employee Dashboard Features

### KPI Cards (6):
1. **Present Days** - Days present this month
2. **Absent Days** - Days absent this month
3. **Working Hours** - Total hours worked this month
4. **Active Projects** - Projects currently assigned to
5. **Late Entries** - Number of late arrivals
6. **Early Exits** - Number of early departures

### Sections:
1. **Attendance Calendar** - Monthly calendar with attendance status
2. **Upcoming Birthdays** - Colleagues' birthdays this month
3. **Personal Notes** - Employee's own notes and tasks

---

## Data Access Scope

### What Employees Can See:

**Projects:**
- Only projects they're assigned to as members
- Cannot see all company projects
- Filtered by project membership

**Tickets:**
- Only their own tickets
- Cannot see other employees' tickets
- Filtered by ticket creator

**Attendance:**
- Only their own attendance records
- Cannot see other employees' attendance
- Filtered by employee_id

**Events:**
- All company events (public)
- No filtering needed

**Rules:**
- All company rules (public)
- No filtering needed

---

## Testing

### Test Employee Access:

1. **Create Employee User:**
```bash
php artisan tinker
>>> $user = User::create(['name' => 'John Doe', 'email' => 'john@example.com', 'password' => bcrypt('password')]);
>>> $user->assignRole('employee');
```

2. **Login as Employee:**
   - Email: `john@example.com`
   - Password: `password`

3. **Check Sidebar:**
   - Should see: Dashboard, Projects, Tickets, Events, Rules
   - Should NOT see: Employees, Payroll, Attendance, HR modules

4. **Test Actions:**
   - ✅ View employee dashboard
   - ✅ View assigned projects
   - ✅ Add comment to project
   - ✅ Mark task as complete
   - ✅ Create support ticket
   - ✅ View own attendance
   - ✅ View company events

---

## Commands

### Assign permissions to Employee role:
```bash
php assign_employee_permissions.php
```

### Check Employee role permissions:
```bash
php artisan tinker
>>> $role = Spatie\Permission\Models\Role::where('name', 'employee')->first();
>>> $role->permissions->pluck('name');
```

### Assign Employee role to a user:
```bash
php artisan tinker
>>> $user = User::find(1);
>>> $user->assignRole('employee');
```

---

## Current Status

### ✅ Employee Role Setup:
- **Role ID:** 4
- **Role Name:** employee
- **Total Permissions:** 23
- **Description:** Employee with access to their own data, attendance, and assigned projects

### ✅ Permission Breakdown:
- **Dashboard:** 1 permission (View)
- **Projects:** 9 permissions (View + Comment + Complete Tasks)
- **Tickets:** 8 permissions (Create + Edit + Comment)
- **Attendance:** 1 permission (View own)
- **Events:** 3 permissions (View + Download images)
- **Rules:** 1 permission (View)

---

## Security Features

1. **Data Isolation** - Only see their own data
2. **Project Membership** - Only see assigned projects
3. **Ticket Ownership** - Only see their own tickets
4. **Attendance Privacy** - Only see their own attendance
5. **No Admin Access** - Cannot access HR or admin functions
6. **Read-Only Financial** - No access to financial modules

---

## Benefits

1. **Self-Service** - View own attendance and projects
2. **Collaboration** - Comment on projects and complete tasks
3. **Support** - Create and manage support tickets
4. **Transparency** - See project progress and team members
5. **Engagement** - View company events and rules
6. **Privacy** - Only see their own data

---

## Use Cases

### Typical Employee Actions:

**Morning:**
1. Login to dashboard
2. Check attendance status
3. View assigned projects
4. Check project tasks

**During Work:**
1. Work on project tasks
2. Mark tasks as complete
3. Add comments to projects
4. Download project files

**Support Needed:**
1. Create support ticket
2. Describe issue
3. Upload screenshots
4. Track ticket status

**End of Day:**
1. Check attendance hours
2. Review completed tasks
3. Add notes for tomorrow

---

## Comparison with Other Roles

| Feature | Employee (23) | Customer (24) | HR (66) |
|---------|---------------|---------------|---------|
| **Dashboard** | ✅ Employee | ✅ Customer | ✅ HR |
| **Projects** | ✅ Assigned | ✅ Company | ❌ |
| **Tickets** | ✅ Own | ✅ Own | ✅ All |
| **Attendance** | ✅ Own | ❌ | ✅ All |
| **Events** | ✅ View | ❌ | ✅ Manage |
| **Rules** | ✅ View | ❌ | ✅ View |
| **Employees** | ❌ | ❌ | ✅ Manage |
| **Payroll** | ❌ | ❌ | ✅ Manage |
| **Quotations** | ❌ | ✅ View | ❌ |
| **Invoices** | ❌ | ✅ View | ❌ |

---

## Files Created

1. **assign_employee_permissions.php** - Script to assign Employee permissions
2. **EMPLOYEE_PERMISSIONS_SETUP.md** - This documentation

---

## Summary

✅ **23 permissions assigned** to Employee role
✅ **Access to own data** - Dashboard, attendance, assigned projects
✅ **Collaboration enabled** - Comment on projects, complete tasks
✅ **Support system** - Create and manage tickets
✅ **Company engagement** - View events and rules
✅ **Sidebar shows** relevant menu items
✅ **Secure** - Data isolated to employee's own records

Employees can now access their dashboard, work on assigned projects, create support tickets, and view their attendance records!
