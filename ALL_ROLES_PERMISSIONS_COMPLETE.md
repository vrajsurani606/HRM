# Complete Roles & Permissions Guide

## Overview

Complete guide for all three configured roles: Customer, HR, and Employee.

---

## Quick Comparison

| Role | Permissions | Primary Use | Access Level |
|------|-------------|-------------|--------------|
| **Customer** | 24 | External clients viewing projects/docs | Read-Only + Limited |
| **HR** | 66 | Internal HR managing employees | Full CRUD |
| **Employee** | 23 | Internal staff working on projects | Own Data + Assigned |

---

## 1. Customer Role (24 Permissions)

### Purpose:
External users (clients/companies) who need to view their projects, tickets, and financial documents.

### Sidebar Menu:
```
✅ Dashboard
✅ Projects
✅ Tickets
```

### What They Can Do:
- View their company's projects
- Click projects to see details
- Add comments to projects
- Download project attachments
- Create support tickets
- View quotations, invoices, receipts
- Print financial documents

### What They Cannot Do:
- Create/edit/delete projects
- Access HR modules
- View other companies' data
- Manage employees
- Access admin functions

### Data Scope:
- **Filter:** `company_id = user.company_id`
- Only see their company's data

---

## 2. HR Role (66 Permissions)

### Purpose:
Internal HR staff who manage employees, attendance, payroll, and recruitment.

### Sidebar Menu:
```
✅ Dashboard
✅ Employees Management
✅ Hiring Leads
✅ Payroll Management
✅ Attendance Management
✅ Events Management
✅ Ticket Support System
✅ Reports
✅ Rules & Regulations
```

### What They Can Do:
- Full CRUD on employees
- Mark and manage attendance
- Generate and manage payroll
- Approve/reject leave requests
- Manage hiring leads
- Generate offer letters
- Create and manage events
- Assign and manage tickets
- Generate HR reports
- View company rules

### What They Cannot Do:
- Create/edit projects
- Create/edit quotations
- Create/edit invoices
- Manage companies
- Manage users/roles

### Data Scope:
- **Filter:** None (sees all HR data)
- Access to all employees and HR records

---

## 3. Employee Role (23 Permissions)

### Purpose:
Internal staff who work on assigned projects and need to view their own attendance.

### Sidebar Menu:
```
✅ Dashboard
✅ Project & Task Management
✅ Ticket Support System
✅ Events
✅ Rules & Regulations
```

### What They Can Do:
- View employee dashboard
- View assigned projects
- Add comments to projects
- Complete project tasks
- Download project attachments
- Create support tickets
- View own attendance
- View company events
- View company rules

### What They Cannot Do:
- Create/edit/delete projects
- View all projects (only assigned)
- Mark own attendance
- View other employees' data
- Access HR modules
- Access financial modules
- Manage users/roles

### Data Scope:
- **Filter:** `employee_id = user.employee.id` (for attendance)
- **Filter:** Project membership (for projects)
- Only see their own data and assigned projects

---

## Detailed Permission Breakdown

### Dashboard Access

| Role | Permission | Dashboard Type |
|------|------------|----------------|
| Customer | ✅ | Customer Dashboard (KPIs, Projects, Docs) |
| HR | ✅ | HR Dashboard (Employees, Leaves, Attendance) |
| Employee | ✅ | Employee Dashboard (Own Attendance, Projects) |

### Projects Management

| Permission | Customer | HR | Employee |
|------------|----------|-----|----------|
| View project | ✅ Company | ❌ | ✅ Assigned |
| Create project | ❌ | ❌ | ❌ |
| Edit project | ❌ | ❌ | ❌ |
| Delete project | ❌ | ❌ | ❌ |
| Project overview | ✅ | ❌ | ✅ |
| View tasks | ✅ | ❌ | ✅ |
| Complete task | ❌ | ❌ | ✅ |
| View members | ✅ | ❌ | ✅ |
| View comments | ✅ | ❌ | ✅ |
| Create comment | ✅ | ❌ | ✅ |
| View attachments | ✅ | ❌ | ✅ |
| Download attachment | ✅ | ❌ | ✅ |

### Tickets Management

| Permission | Customer | HR | Employee |
|------------|----------|-----|----------|
| View ticket | ✅ Own | ✅ All | ✅ Own |
| Create ticket | ✅ | ✅ | ✅ |
| Edit ticket | ✅ Own | ✅ | ✅ Own |
| Delete ticket | ❌ | ❌ | ❌ |
| Assign ticket | ❌ | ✅ | ❌ |
| Change status | ❌ | ✅ | ❌ |
| Change priority | ❌ | ✅ | ❌ |
| View comments | ✅ | ✅ | ✅ |
| Create comment | ✅ | ✅ | ✅ |
| Upload attachment | ✅ | ✅ | ✅ |
| Download attachment | ✅ | ✅ | ✅ |

### Employees Management

| Permission | Customer | HR | Employee |
|------------|----------|-----|----------|
| View employee | ❌ | ✅ All | ❌ |
| Create employee | ❌ | ✅ | ❌ |
| Edit employee | ❌ | ✅ | ❌ |
| Delete employee | ❌ | ✅ | ❌ |
| Employee letters | ❌ | ✅ | ❌ |
| Digital cards | ❌ | ✅ | ❌ |

### Attendance Management

| Permission | Customer | HR | Employee |
|------------|----------|-----|----------|
| View attendance | ❌ | ✅ All | ✅ Own |
| Create attendance | ❌ | ✅ | ❌ |
| Edit attendance | ❌ | ✅ | ❌ |
| Delete attendance | ❌ | ✅ | ❌ |

### Payroll Management

| Permission | Customer | HR | Employee |
|------------|----------|-----|----------|
| View payroll | ❌ | ✅ | ❌ |
| Create payroll | ❌ | ✅ | ❌ |
| Edit payroll | ❌ | ✅ | ❌ |
| Export payroll | ❌ | ✅ | ❌ |
| Bulk generate | ❌ | ✅ | ❌ |

### Events Management

| Permission | Customer | HR | Employee |
|------------|----------|-----|----------|
| View event | ❌ | ✅ | ✅ |
| Create event | ❌ | ✅ | ❌ |
| Edit event | ❌ | ✅ | ❌ |
| Delete event | ❌ | ✅ | ❌ |
| View images | ❌ | ✅ | ✅ |
| Upload images | ❌ | ✅ | ❌ |
| Download images | ❌ | ✅ | ✅ |

### Financial Documents

| Permission | Customer | HR | Employee |
|------------|----------|-----|----------|
| View quotations | ✅ Company | ❌ | ❌ |
| View invoices | ✅ Company | ❌ | ❌ |
| View receipts | ✅ Company | ❌ | ❌ |
| Print documents | ✅ | ❌ | ❌ |

### Other Modules

| Module | Customer | HR | Employee |
|--------|----------|-----|----------|
| Leads | ❌ | ✅ Full | ❌ |
| Reports | ❌ | ✅ | ❌ |
| Rules | ❌ | ✅ View | ✅ View |
| Companies | ❌ | ❌ | ❌ |
| Users | ❌ | ❌ | ❌ |
| Roles | ❌ | ❌ | ❌ |

---

## Assignment Methods

### Customer Role:
**Auto-assigned** when creating company:
```php
// In CompanyController::store()
$user = User::create([...]);
$user->assignRole('customer');
$user->company_id = $company->id;
```

### HR Role:
**Manually assigned** to HR staff:
```bash
php artisan tinker
>>> $user = User::find(1);
>>> $user->assignRole('hr');
```

### Employee Role:
**Manually assigned** to employees:
```bash
php artisan tinker
>>> $user = User::find(1);
>>> $user->assignRole('employee');
```

---

## Commands Reference

### Assign Permissions:
```bash
# Customer
php assign_customer_permissions.php

# HR
php assign_hr_permissions.php

# Employee
php assign_employee_permissions.php
```

### Check Role Permissions:
```bash
php artisan tinker
>>> $role = Role::where('name', 'customer')->first();
>>> $role->permissions->pluck('name');
```

### Assign Role to User:
```bash
php artisan tinker
>>> $user = User::find(1);
>>> $user->assignRole('customer'); // or 'hr' or 'employee'
```

### Check User Roles:
```bash
php artisan tinker
>>> $user = User::find(1);
>>> $user->roles->pluck('name');
```

---

## Security Matrix

| Feature | Customer | HR | Employee |
|---------|----------|-----|----------|
| **Access Type** | External | Internal | Internal |
| **Data Scope** | Company | All HR | Own + Assigned |
| **CRUD Level** | Read + Limited | Full CRUD | Read + Comment |
| **Trust Level** | Low | High | Medium |
| **Isolation** | High | None | High |

---

## Use Case Scenarios

### Customer Scenario:
```
1. Company owner logs in
2. Views dashboard with KPIs
3. Clicks on active project
4. Sees project progress
5. Adds comment to project
6. Views latest invoice
7. Prints invoice
8. Creates support ticket
```

### HR Scenario:
```
1. HR manager logs in
2. Views HR dashboard
3. Approves leave request
4. Marks attendance for absent employee
5. Generates monthly payroll
6. Reviews hiring lead
7. Generates offer letter
8. Creates company event
9. Assigns support ticket
```

### Employee Scenario:
```
1. Employee logs in
2. Views employee dashboard
3. Checks attendance status
4. Views assigned project
5. Marks task as complete
6. Adds comment to project
7. Downloads project file
8. Creates support ticket
9. Views company event
```

---

## Summary Statistics

| Metric | Customer | HR | Employee |
|--------|----------|-----|----------|
| **Total Permissions** | 24 | 66 | 23 |
| **Modules Access** | 6 | 9 | 6 |
| **CRUD Operations** | Limited | Full | Limited |
| **Data Visibility** | Company | All HR | Own |
| **Primary Function** | View Projects/Docs | Manage HR | Work on Projects |

---

## All Roles Configured! ✅

✅ **Customer Role** - 24 permissions (External clients)
✅ **HR Role** - 66 permissions (HR management)
✅ **Employee Role** - 23 permissions (Internal staff)

All three roles are now fully configured with appropriate permissions for their respective use cases!
