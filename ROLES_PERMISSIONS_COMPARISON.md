# Roles & Permissions Comparison

## Overview

Complete comparison of permissions for Customer and HR roles.

---

## Customer Role (24 Permissions)

### Purpose:
External users (clients/companies) who need to view their projects, tickets, and financial documents.

### Access Level: **Read-Only + Limited Actions**

### Modules Accessible:
| Module | Permissions | Actions |
|--------|-------------|---------|
| **Dashboard** | 1 | View dashboard |
| **Projects** | 9 | View, comment, download |
| **Tickets** | 8 | Create, edit, comment, attach |
| **Quotations** | 3 | View, print, download |
| **Invoices** | 2 | View, print |
| **Receipts** | 2 | View, print |

### Sidebar Menu:
```
✅ Dashboard
✅ Projects
✅ Tickets
❌ Employees
❌ Payroll
❌ Attendance
❌ Everything else
```

### Use Case:
- Company owners viewing their projects
- Clients checking project progress
- Customers viewing invoices and quotations
- External users submitting support tickets

---

## HR Role (66 Permissions)

### Purpose:
Internal HR staff who manage employees, attendance, payroll, and recruitment.

### Access Level: **Full CRUD + Management**

### Modules Accessible:
| Module | Permissions | Actions |
|--------|-------------|---------|
| **Dashboard** | 1 | View HR dashboard |
| **Employees** | 15 | Full CRUD + Letters + Digital Cards |
| **Attendance** | 5 | Full CRUD |
| **Payroll** | 8 | Full CRUD + Export + Bulk Generate |
| **Leads** | 9 | Full CRUD + Convert + Offer Letters |
| **Events** | 9 | Full CRUD + Image Management |
| **Tickets** | 15 | Full management + Assign + Status |
| **Reports** | 3 | View, Create, Manage |
| **Rules** | 1 | View |

### Sidebar Menu:
```
✅ Dashboard
✅ Employees
✅ Hiring Leads
✅ Payroll
✅ Attendance
✅ Events
✅ Tickets
✅ Reports
✅ Rules
❌ Inquiries
❌ Quotations
❌ Companies
❌ Projects
❌ Invoices
```

### Use Case:
- HR managers managing employee lifecycle
- Attendance tracking and management
- Payroll generation and distribution
- Recruitment and hiring
- Employee event organization
- HR ticket support

---

## Side-by-Side Comparison

| Feature | Customer | HR |
|---------|----------|-----|
| **Total Permissions** | 24 | 66 |
| **Dashboard** | ✅ Customer | ✅ HR |
| **Employees** | ❌ | ✅ Full CRUD |
| **Attendance** | ❌ | ✅ Full CRUD |
| **Payroll** | ❌ | ✅ Full CRUD |
| **Leads** | ❌ | ✅ Full CRUD |
| **Events** | ❌ | ✅ Full CRUD |
| **Projects** | ✅ View + Comment | ❌ |
| **Tickets** | ✅ Create + Edit | ✅ Full Management |
| **Quotations** | ✅ View Only | ❌ |
| **Invoices** | ✅ View Only | ❌ |
| **Receipts** | ✅ View Only | ❌ |
| **Companies** | ❌ | ❌ |
| **Users** | ❌ | ❌ |
| **Roles** | ❌ | ❌ |
| **Reports** | ❌ | ✅ View + Create |
| **Rules** | ❌ | ✅ View |

---

## Permission Details

### Customer Can:
✅ View their company's projects
✅ Click projects to see details
✅ Add comments to projects
✅ Download project attachments
✅ Create support tickets
✅ Edit their own tickets
✅ Add comments to tickets
✅ Upload/download ticket files
✅ View quotations
✅ Print/download quotations
✅ View invoices
✅ Print invoices
✅ View receipts
✅ Print receipts

### Customer Cannot:
❌ Create/edit/delete projects
❌ Add/remove project members
❌ Delete project comments
❌ Create/edit quotations
❌ Create/edit invoices
❌ View other companies' data
❌ Access HR modules
❌ Manage employees
❌ View/manage payroll
❌ Access admin functions

### HR Can:
✅ View all employees
✅ Add/edit/delete employees
✅ Generate employee letters
✅ Create digital cards
✅ Mark attendance
✅ Edit attendance records
✅ Generate payroll
✅ Bulk generate payroll
✅ Export payroll data
✅ View/manage hiring leads
✅ Convert leads to employees
✅ Generate offer letters
✅ Create/manage events
✅ Upload event photos
✅ View all tickets
✅ Assign tickets to employees
✅ Change ticket status/priority
✅ Generate HR reports
✅ View company rules

### HR Cannot:
❌ Create/edit projects
❌ Manage project tasks
❌ Create/edit quotations
❌ Create/edit invoices
❌ Manage companies
❌ Create/edit inquiries
❌ Manage users (except employees)
❌ Manage roles
❌ Access financial modules

---

## Data Access

### Customer:
- **Scope:** Only their company's data
- **Filter:** `company_id = user.company_id`
- **Projects:** Only projects for their company
- **Tickets:** Only their own tickets
- **Quotations:** Only their company's quotations
- **Invoices:** Only their company's invoices

### HR:
- **Scope:** All employees and HR data
- **Filter:** No company filter (sees all)
- **Employees:** All employees in the system
- **Attendance:** All attendance records
- **Payroll:** All payroll records
- **Leads:** All hiring leads
- **Events:** All company events

---

## Security Levels

### Customer:
- **Level:** External User
- **Trust:** Low (read-only for sensitive data)
- **Access:** Limited to their company
- **Actions:** View + Comment + Create Tickets
- **Financial:** Read-only

### HR:
- **Level:** Internal Staff
- **Trust:** High (full CRUD for HR data)
- **Access:** All HR-related data
- **Actions:** Full CRUD + Management
- **Financial:** No access

---

## Use Cases

### Customer Role:
1. **Company Owner** - View projects and invoices
2. **Client** - Track project progress
3. **External Partner** - View quotations and documents
4. **Customer** - Submit support tickets

### HR Role:
1. **HR Manager** - Manage all HR functions
2. **HR Executive** - Handle employee records
3. **Payroll Officer** - Generate payroll
4. **Recruitment Manager** - Manage hiring
5. **HR Admin** - Organize events and handle tickets

---

## Assignment

### Customer Role:
- **Auto-assigned** when creating company
- **Users:** Company and employee users
- **Count:** 15+ users

### HR Role:
- **Manually assigned** to HR staff
- **Users:** HR department employees
- **Count:** As needed

---

## Commands

### Assign Customer Permissions:
```bash
php assign_customer_permissions.php
```

### Assign HR Permissions:
```bash
php assign_hr_permissions.php
```

### Assign Role to User:
```bash
php artisan tinker
>>> $user = User::find(1);
>>> $user->assignRole('customer'); // or 'hr'
```

### Check User Roles:
```bash
php artisan tinker
>>> $user = User::find(1);
>>> $user->roles->pluck('name');
```

### Check Role Permissions:
```bash
php artisan tinker
>>> $role = Role::where('name', 'customer')->first();
>>> $role->permissions->pluck('name');
```

---

## Summary

| Metric | Customer | HR |
|--------|----------|-----|
| **Permissions** | 24 | 66 |
| **Access Type** | External | Internal |
| **Data Scope** | Company-specific | All HR data |
| **CRUD Level** | Read + Limited | Full CRUD |
| **Primary Use** | View projects/docs | Manage employees |
| **Security** | High isolation | High trust |

Both roles are now fully configured with appropriate permissions for their respective use cases!
