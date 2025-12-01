# Customer Role Permissions Setup

## ✅ What Was Done

Assigned default permissions to the "customer" role so that customer users can access necessary modules in the sidebar and perform essential actions.

## Permissions Assigned (24 Total)

### 1. Dashboard (1 permission)
- ✅ `Dashboard.view dashboard` - Access to customer dashboard

### 2. Projects Management (9 permissions)
- ✅ `Projects Management.view project` - View projects
- ✅ `Projects Management.project overview` - View project overview page
- ✅ `Projects Management.view tasks` - View project tasks
- ✅ `Projects Management.view members` - View project members
- ✅ `Projects Management.view comments` - View project comments
- ✅ `Projects Management.create comment` - Add comments to projects
- ✅ `Projects Management.view attachments` - View project attachments
- ✅ `Projects Management.download attachment` - Download project files

### 3. Tickets Management (8 permissions)
- ✅ `Tickets Management.view ticket` - View tickets
- ✅ `Tickets Management.create ticket` - Create new tickets
- ✅ `Tickets Management.edit ticket` - Edit their own tickets
- ✅ `Tickets Management.view comments` - View ticket comments
- ✅ `Tickets Management.create comment` - Add comments to tickets
- ✅ `Tickets Management.view attachments` - View ticket attachments
- ✅ `Tickets Management.upload attachment` - Upload files to tickets
- ✅ `Tickets Management.download attachment` - Download ticket files

### 4. Quotations Management (3 permissions)
- ✅ `Quotations Management.view quotation` - View quotations
- ✅ `Quotations Management.download quotation` - Download quotation files
- ✅ `Quotations Management.print quotation` - Print quotations

### 5. Invoices Management (2 permissions)
- ✅ `Invoices Management.view invoice` - View invoices
- ✅ `Invoices Management.print invoice` - Print invoices

### 6. Receipts Management (2 permissions)
- ✅ `Receipts Management.view receipt` - View receipts
- ✅ `Receipts Management.print receipt` - Print receipts

## What Customers CAN Do

### ✅ Allowed Actions:
1. **View Dashboard** - See their company dashboard with KPIs
2. **View Projects** - See all projects for their company
3. **Click Projects** - Navigate to project overview
4. **View Project Details** - Tasks, members, comments, attachments
5. **Comment on Projects** - Add comments to project discussions
6. **Download Project Files** - Download project attachments
7. **Create Tickets** - Submit support tickets
8. **View & Edit Tickets** - Manage their own tickets
9. **Comment on Tickets** - Add comments to ticket discussions
10. **Upload/Download Ticket Files** - Attach files to tickets
11. **View Quotations** - See quotations for their company
12. **Print/Download Quotations** - Get quotation documents
13. **View Invoices** - See invoices for their company
14. **Print Invoices** - Get invoice documents
15. **View Receipts** - See payment receipts
16. **Print Receipts** - Get receipt documents

### ❌ NOT Allowed (Security):
- Create/Edit/Delete Projects
- Add/Remove Project Members
- Delete Project Comments
- Create/Edit/Delete Quotations
- Create/Edit/Delete Invoices
- Create/Edit/Delete Receipts
- View Other Companies' Data
- Access HR/Payroll/Attendance modules
- Manage Users/Roles
- Access Admin Functions

## Sidebar Visibility

With these permissions, customers will see these menu items:

```
📊 Dashboard
📁 Projects
🎫 Tickets
📄 Quotations (view only)
🧾 Invoices (view only)
🧾 Receipts (view only)
```

They will NOT see:
- Employees
- Leads
- Payroll
- Attendance
- Users
- Roles
- Companies
- Events
- Reports
- Rules

## How It Works

### Automatic Assignment:
1. **When creating a company** → Users get "customer" role
2. **Customer role** → Has 24 default permissions
3. **Permissions** → Control sidebar visibility and access
4. **Data filtering** → Users only see their company's data

### Permission Check Flow:
```
User Login
  ↓
Has "customer" role?
  ↓
Check permissions
  ↓
Show/Hide sidebar items
  ↓
Filter data by company_id
```

## Testing

### Test Customer Access:

1. **Login as customer:**
   - Email: `abccompany510@example.com`
   - Or: `kuldip1234@gmail.com`

2. **Check Sidebar:**
   - Should see: Dashboard, Projects, Tickets, Quotations, Invoices, Receipts
   - Should NOT see: Employees, Payroll, Attendance, etc.

3. **Test Actions:**
   - ✅ Click Projects → See project list
   - ✅ Click project → See project overview
   - ✅ Add comment to project
   - ✅ Create ticket
   - ✅ View quotations
   - ✅ Print invoice

## Files Modified

1. **Created:** `assign_customer_permissions.php`
   - Script to assign permissions to customer role
   - Can be run anytime to update permissions

2. **Existing:** `app/Http/Controllers/Company/CompanyController.php`
   - Already assigns "customer" role to new users
   - No changes needed - permissions apply automatically

## Commands

### Assign permissions to customer role:
```bash
php assign_customer_permissions.php
```

### Check customer role permissions:
```bash
php artisan tinker
>>> $role = Spatie\Permission\Models\Role::where('name', 'customer')->first();
>>> $role->permissions->pluck('name');
```

### Assign customer role to a user:
```bash
php artisan tinker
>>> $user = User::find(28);
>>> $user->assignRole('customer');
```

## Current Status

### ✅ Customer Role Setup:
- **Role ID:** 6
- **Role Name:** customer
- **Total Permissions:** 24
- **Users with Role:** 15+ (all company and employee users)

### ✅ All Customer Users Have Access To:
- Dashboard ✓
- Projects (view, comment) ✓
- Tickets (create, edit, comment) ✓
- Quotations (view, print) ✓
- Invoices (view, print) ✓
- Receipts (view, print) ✓

## Security Features

1. **Data Isolation** - Users only see their company's data (via `company_id`)
2. **Read-Only Access** - Can view but not modify critical data (quotations, invoices)
3. **Limited Actions** - Can comment but not delete
4. **No Admin Access** - Cannot access HR, payroll, or admin functions
5. **Audit Trail** - All actions are logged

## Benefits

1. **Self-Service** - Customers can view their data without admin help
2. **Transparency** - See project progress, invoices, receipts
3. **Communication** - Can comment on projects and create tickets
4. **Secure** - Only see their own company's data
5. **Professional** - Clean, organized interface

## Summary

✅ **24 permissions assigned** to customer role
✅ **All customer users** have access to necessary modules
✅ **Sidebar shows** relevant menu items
✅ **Data filtered** by company_id
✅ **Secure** - Read-only for financial documents
✅ **Interactive** - Can comment and create tickets

Customers can now access all necessary modules while maintaining security and data isolation!
