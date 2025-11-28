# 🔐 Complete Permissions Structure - HR Portal

## 📋 Overview
This document defines all permissions for the HR Portal system. Each module has specific permissions for different actions.

---

## 🎯 Permission Naming Convention

**Format**: `Module Name.action`

**Actions**:
- `view` - View/Read access (list, show)
- `create` - Create new records
- `edit` - Update existing records
- `delete` - Delete records
- `manage` - Full access (all CRUD operations)
- `approve` - Approve/Reject actions
- `export` - Export data
- `print` - Print documents

---

## 📊 Complete Permissions List

### 1. **Dashboard Module**
| Permission | Description | Actions |
|------------|-------------|---------|
| `Dashboard.view` | View dashboard | View statistics, charts, widgets |
| `Dashboard.view-kpi` | View KPI statistics | View employee count, projects, tasks, attendance |
| `Dashboard.view-notifications` | View notifications | View pending leaves, tickets, absences |
| `Dashboard.view-inquiries` | View recent inquiries | View inquiry list on dashboard |
| `Dashboard.view-tickets` | View recent tickets | View ticket list on dashboard |
| `Dashboard.view-charts` | View charts | View company charts and analytics |
| `Dashboard.view-notes` | View notes | View system and employee notes |
| `Dashboard.manage-notes` | Manage notes | Create, edit, delete notes |

---

### 2. **HRM (Human Resource Management)**

#### 2.1 Hiring/Recruitment
| Permission | Description | Actions |
|------------|-------------|---------|
| `Hiring.view` | View hiring leads | List all hiring leads, view details |
| `Hiring.create` | Create hiring lead | Add new hiring lead |
| `Hiring.edit` | Edit hiring lead | Update hiring lead details |
| `Hiring.delete` | Delete hiring lead | Remove hiring lead |
| `Hiring.manage` | Full hiring management | All CRUD operations |
| `Hiring.print` | Print hiring documents | Print offer letters, resumes |
| `Hiring.convert` | Convert lead to employee | Convert hiring lead to employee |
| `Hiring.offer-letter` | Manage offer letters | Create, edit, view offer letters |

#### 2.2 Employees
| Permission | Description | Actions |
|------------|-------------|---------|
| `Employees.view` | View employees | List all employees, view profiles |
| `Employees.create` | Create employee | Add new employee |
| `Employees.edit` | Edit employee | Update employee details |
| `Employees.delete` | Delete employee | Remove employee |
| `Employees.manage` | Full employee management | All CRUD operations |
| `Employees.letters` | Manage employee letters | Create, view, print letters |
| `Employees.letters-create` | Create employee letters | Generate new letters |
| `Employees.letters-view` | View employee letters | View letter details |
| `Employees.letters-print` | Print employee letters | Print/Download letters |
| `Employees.letters-generate-number` | Generate letter numbers | Auto-generate letter reference numbers |
| `Employees.digital-card` | Manage digital cards | Create, edit, view digital ID cards |
| `Employees.digital-card-create` | Create digital card | Generate new digital ID card |
| `Employees.digital-card-edit` | Edit digital card | Update digital ID card |
| `Employees.digital-card-quick-edit` | Quick edit digital card | Quick update card details |
| `Employees.digital-card-delete` | Delete digital card | Remove digital ID card |
| `Employees.export` | Export employee data | Export to Excel/PDF |

**Employee Letter Types**:
- Experience Certificate
- Salary Certificate
- Relieving Letter
- Appointment Letter
- Promotion Letter
- Transfer Letter
- Warning Letter
- Termination Letter

---

### 3. **Inquiry Management**
| Permission | Description | Actions |
|------------|-------------|---------|
| `Inquiries.view` | View inquiries | List all inquiries, view details |
| `Inquiries.create` | Create inquiry | Add new inquiry |
| `Inquiries.edit` | Edit inquiry | Update inquiry details |
| `Inquiries.delete` | Delete inquiry | Remove inquiry |
| `Inquiries.manage` | Full inquiry management | All CRUD operations |
| `Inquiries.follow-up` | Manage follow-ups | Add, view follow-ups |
| `Inquiries.follow-up-create` | Create follow-up | Add new follow-up entry |
| `Inquiries.follow-up-confirm` | Confirm follow-up | Mark follow-up as confirmed |
| `Inquiries.export` | Export inquiry data | Export to Excel/PDF |

---

### 4. **Quotation Management**
| Permission | Description | Actions |
|------------|-------------|---------|
| `Quotations.view` | View quotations | List all quotations, view details |
| `Quotations.create` | Create quotation | Add new quotation |
| `Quotations.create-from-inquiry` | Create from inquiry | Convert inquiry to quotation |
| `Quotations.edit` | Edit quotation | Update quotation details |
| `Quotations.delete` | Delete quotation | Remove quotation |
| `Quotations.manage` | Full quotation management | All CRUD operations |
| `Quotations.follow-up` | Manage follow-ups | Add, view follow-ups |
| `Quotations.follow-up-create` | Create follow-up | Add new follow-up entry |
| `Quotations.follow-up-confirm` | Confirm follow-up | Mark follow-up as confirmed |
| `Quotations.export` | Export quotation data | Export to Excel/PDF |
| `Quotations.print` | Print quotation | Print/Download quotation |
| `Quotations.download` | Download quotation | Download quotation PDF |
| `Quotations.contract` | Generate contracts | Generate contract PDF/PNG |
| `Quotations.contract-pdf` | Generate contract PDF | Generate contract as PDF |
| `Quotations.contract-png` | Generate contract PNG | Generate contract as PNG |
| `Quotations.contract-file` | View contract file | View generated contract file |
| `Quotations.template-list` | View templates | View quotation templates |
| `Quotations.create-proforma` | Create proforma | Convert quotation to proforma |
| `Quotations.company-details` | View company details | Get company details for quotation |

---

### 5. **Company Management**
| Permission | Description | Actions |
|------------|-------------|---------|
| `Companies.view` | View companies | List all companies, view details |
| `Companies.create` | Create company | Add new company |
| `Companies.edit` | Edit company | Update company details |
| `Companies.delete` | Delete company | Remove company |
| `Companies.manage` | Full company management | All CRUD operations |
| `Companies.documents` | View company documents | View uploaded documents |
| `Companies.export` | Export company data | Export to Excel/PDF |

---

### 6. **Invoice Management**

#### 6.1 Proforma Invoices
| Permission | Description | Actions |
|------------|-------------|---------|
| `Proformas.view` | View proformas | List all proformas, view details |
| `Proformas.create` | Create proforma | Add new proforma |
| `Proformas.edit` | Edit proforma | Update proforma details |
| `Proformas.delete` | Delete proforma | Remove proforma |
| `Proformas.manage` | Full proforma management | All CRUD operations |
| `Proformas.print` | Print proforma | Print/Download proforma |
| `Proformas.convert` | Convert to tax invoice | Convert proforma to tax invoice |
| `Proformas.convert-form` | View convert form | View conversion form |

#### 6.2 Tax Invoices
| Permission | Description | Actions |
|------------|-------------|---------|
| `Invoices.view` | View tax invoices | List all invoices, view details |
| `Invoices.edit` | Edit tax invoice | Update invoice details |
| `Invoices.delete` | Delete tax invoice | Remove invoice |
| `Invoices.manage` | Full invoice management | All operations |
| `Invoices.print` | Print invoice | Print/Download invoice |

#### 6.3 Receipts
| Permission | Description | Actions |
|------------|-------------|---------|
| `Receipts.view` | View receipts | List all receipts, view details |
| `Receipts.create` | Create receipt | Add new receipt |
| `Receipts.edit` | Edit receipt | Update receipt details |
| `Receipts.delete` | Delete receipt | Remove receipt |
| `Receipts.manage` | Full receipt management | All CRUD operations |
| `Receipts.print` | Print receipt | Print/Download receipt |

---

### 7. **Payroll Management**
| Permission | Description | Actions |
|------------|-------------|---------|
| `Payroll.view` | View payroll | List all payroll records, view details |
| `Payroll.create` | Create payroll | Generate new payroll |
| `Payroll.edit` | Edit payroll | Update payroll details |
| `Payroll.delete` | Delete payroll | Remove payroll record |
| `Payroll.manage` | Full payroll management | All CRUD operations |
| `Payroll.print` | Print payslip | Print/Download payslip |
| `Payroll.export` | Export payroll data | Export to Excel/PDF |
| `Payroll.get-employee-salary` | Get employee salary | Fetch employee salary details for auto-fill |

---

### 8. **Project & Task Management**
| Permission | Description | Actions |
|------------|-------------|---------|
| `Projects.view` | View projects | List all projects, view details |
| `Projects.create` | Create project | Add new project |
| `Projects.edit` | Edit project | Update project details |
| `Projects.delete` | Delete project | Remove project |
| `Projects.manage` | Full project management | All CRUD operations |
| `Projects.stages` | Manage project stages | Create, edit stages |
| `Projects.stages-create` | Create project stage | Add new stage |
| `Projects.stages-update` | Update project stage | Move project to different stage |
| `Projects.tasks` | Manage tasks | Create, edit, delete tasks |
| `Projects.tasks-view` | View tasks | View project tasks |
| `Projects.tasks-create` | Create task | Add new task |
| `Projects.tasks-edit` | Edit task | Update task details |
| `Projects.tasks-delete` | Delete task | Remove task |
| `Projects.subtasks` | Manage subtasks | Create, edit, delete subtasks |
| `Projects.comments` | Manage comments | Add, view comments |
| `Projects.comments-view` | View comments | View project comments |
| `Projects.comments-create` | Create comment | Add new comment |
| `Projects.members` | Manage team members | Add, remove members |
| `Projects.members-view` | View members | View project members |
| `Projects.members-add` | Add member | Add member to project |
| `Projects.members-remove` | Remove member | Remove member from project |
| `Projects.members-available` | View available users | View users not in project |

---

### 9. **Ticket Support System**
| Permission | Description | Actions |
|------------|-------------|---------|
| `Tickets.view` | View tickets | List all tickets, view details |
| `Tickets.view-all` | View all tickets | View tickets from all users |
| `Tickets.view-own` | View own tickets | View only own tickets |
| `Tickets.create` | Create ticket | Add new ticket |
| `Tickets.edit` | Edit ticket | Update ticket details |
| `Tickets.delete` | Delete ticket | Remove ticket |
| `Tickets.manage` | Full ticket management | All CRUD operations |
| `Tickets.assign` | Assign tickets | Assign tickets to users |
| `Tickets.resolve` | Resolve tickets | Mark tickets as resolved |
| `Tickets.change-status` | Change status | Update ticket status |
| `Tickets.change-priority` | Change priority | Update ticket priority |

---

### 10. **Attendance Management**

#### 10.1 Attendance
| Permission | Description | Actions |
|------------|-------------|---------|
| `Attendance.view` | View attendance | View own attendance |
| `Attendance.view-all` | View all attendance | View all employees' attendance |
| `Attendance.check-in` | Check in | Mark attendance check-in |
| `Attendance.check-out` | Check out | Mark attendance check-out |
| `Attendance.check-status` | Check status | Check current attendance status |
| `Attendance.history` | View history | View attendance history |
| `Attendance.report` | View reports | View attendance reports |
| `Attendance.report-generate` | Generate reports | Generate attendance reports |
| `Attendance.report-export` | Export reports | Export attendance reports |
| `Attendance.manage` | Manage attendance | Edit, delete attendance records |
| `Attendance.edit` | Edit attendance | Update attendance records |
| `Attendance.delete` | Delete attendance | Remove attendance records |
| `Attendance.export` | Export attendance | Export attendance data |

#### 10.2 Leave Management
| Permission | Description | Actions |
|------------|-------------|---------|
| `Leaves.view` | View leaves | View own leave requests |
| `Leaves.view-all` | View all leaves | View all employees' leave requests |
| `Leaves.create` | Create leave | Submit leave request |
| `Leaves.edit` | Edit leave | Update leave request |
| `Leaves.delete` | Delete leave | Cancel leave request |
| `Leaves.manage` | Manage all leaves | View all leave requests |
| `Leaves.approve` | Approve leaves | Approve leave requests |
| `Leaves.reject` | Reject leaves | Reject leave requests |
| `Leaves.balance` | View leave balance | View leave balance |
| `Leaves.balance-view-all` | View all balances | View all employees' leave balances |
| `Leaves.balance-employee` | View employee balance | View specific employee's leave balance |
| `Leaves.paid-balance` | View paid leave balance | View paid leave balance |

#### 10.3 Company Holidays
| Permission | Description | Actions |
|------------|-------------|---------|
| `Holidays.view` | View holidays | View company holidays |
| `Holidays.create` | Create holiday | Add new holiday |
| `Holidays.edit` | Edit holiday | Update holiday details |
| `Holidays.delete` | Delete holiday | Remove holiday |
| `Holidays.manage` | Full holiday management | All CRUD operations |

---

### 11. **Events Management**
| Permission | Description | Actions |
|------------|-------------|---------|
| `Events.view` | View events | List all events, view details |
| `Events.create` | Create event | Add new event |
| `Events.edit` | Edit event | Update event details |
| `Events.delete` | Delete event | Remove event |
| `Events.manage` | Full event management | All CRUD operations |
| `Events.media` | Manage media | Upload, delete images/videos |
| `Events.upload-images` | Upload images | Upload event images |
| `Events.upload-videos` | Upload videos | Upload event videos |
| `Events.upload-media` | Upload media | Upload images and videos |
| `Events.delete-images` | Delete images | Remove event images |
| `Events.delete-videos` | Delete videos | Remove event videos |
| `Events.view-images` | View images | View/Open event images |
| `Events.view-videos` | View videos | View/Open event videos |
| `Events.download-images` | Download images | Download event images |
| `Events.download-videos` | Download videos | Download event videos |

---

### 12. **User Management**
| Permission | Description | Actions |
|------------|-------------|---------|
| `Users.view` | View users | List all users, view details |
| `Users.create` | Create user | Add new user |
| `Users.edit` | Edit user | Update user details |
| `Users.delete` | Delete user | Remove user |
| `Users.manage` | Full user management | All CRUD operations |

---

### 13. **Role & Permission Management**
| Permission | Description | Actions |
|------------|-------------|---------|
| `Roles.view` | View roles | List all roles, view details |
| `Roles.create` | Create role | Add new role |
| `Roles.edit` | Edit role | Update role details |
| `Roles.delete` | Delete role | Remove role |
| `Roles.manage` | Full role management | All CRUD operations |
| `Roles.assign-permissions` | Assign permissions | Assign permissions to roles |

---

### 14. **Settings**
| Permission | Description | Actions |
|------------|-------------|---------|
| `Settings.view` | View settings | View system settings |
| `Settings.edit` | Edit settings | Update system settings |
| `Settings.manage` | Full settings management | All settings operations |

---

### 15. **Rules & Regulations**
| Permission | Description | Actions |
|------------|-------------|---------|
| `Rules.view` | View rules | View company rules & regulations |
| `Rules.edit` | Edit rules | Update rules & regulations |
| `Rules.manage` | Manage rules | Full rules management |
| `Rules.download` | Download rules | Download rules PDF |

---

### 16. **Profile Management**
| Permission | Description | Actions |
|------------|-------------|---------|
| `Profile.view` | View own profile | View own profile details |
| `Profile.edit` | Edit own profile | Update own profile |
| `Profile.bank-details` | Edit bank details | Update bank information |
| `Profile.delete` | Delete account | Delete own account |

---

### 17. **Maintenance & System**
| Permission | Description | Actions |
|------------|-------------|---------|
| `System.clear-cache` | Clear cache | Clear application cache |
| `System.maintenance` | Maintenance mode | Enable/disable maintenance mode |
| `System.view-logs` | View logs | View system logs |
| `System.backup` | Backup system | Create system backup |
| `System.restore` | Restore system | Restore from backup |

---

## 🎭 Predefined Roles

### 1. **Super Admin**
**Permissions**: ALL
- Full access to entire system
- Can manage all modules
- Can create/edit/delete any data

### 2. **Admin**
**Permissions**: Most permissions except system-critical ones
- Full access to most modules
- Cannot delete users or roles
- Cannot modify system settings

### 3. **HR Manager**
**Permissions**:
- `Employees.*` (Full employee management)
- `Hiring.*` (Full hiring management)
- `Attendance.*` (Full attendance management)
- `Leaves.approve` (Approve/reject leaves)
- `Payroll.*` (Full payroll management)
- `Events.*` (Full event management)
- `Dashboard.view`

### 4. **Project Manager**
**Permissions**:
- `Projects.*` (Full project management)
- `Tasks.*` (Full task management)
- `Tickets.*` (Full ticket management)
- `Dashboard.view`

### 5. **Accountant**
**Permissions**:
- `Invoices.*` (Full invoice management)
- `Proformas.*` (Full proforma management)
- `Receipts.*` (Full receipt management)
- `Quotations.view` (View quotations)
- `Companies.view` (View companies)
- `Dashboard.view`

### 6. **Sales Manager**
**Permissions**:
- `Inquiries.*` (Full inquiry management)
- `Quotations.*` (Full quotation management)
- `Companies.*` (Full company management)
- `Dashboard.view`

### 7. **Employee**
**Permissions**:
- `Dashboard.view`
- `Profile.*` (Own profile management)
- `Attendance.view` (View own attendance)
- `Attendance.check-in` (Check in)
- `Attendance.check-out` (Check out)
- `Leaves.view` (View own leaves)
- `Leaves.create` (Submit leave request)
- `Leaves.edit` (Edit own leave)
- `Leaves.delete` (Cancel own leave)
- `Holidays.view` (View holidays)
- `Events.view` (View events)
- `Rules.view` (View rules)
- `Tickets.create` (Create ticket)
- `Tickets.view` (View own tickets)

### 8. **Team Lead**
**Permissions**:
- All Employee permissions +
- `Projects.view` (View projects)
- `Projects.tasks` (Manage tasks)
- `Projects.comments` (Add comments)
- `Tickets.assign` (Assign tickets)
- `Attendance.report` (View team attendance)

---

## 🔒 Permission Implementation Guide

### In Controllers
```php
// Check single permission
if (!auth()->user()->can('Employees.create')) {
    abort(403, 'Unauthorized action.');
}

// Check multiple permissions (any)
if (!auth()->user()->canAny(['Employees.edit', 'Employees.manage'])) {
    abort(403);
}

// Check multiple permissions (all)
if (!auth()->user()->can(['Employees.edit', 'Employees.view'])) {
    abort(403);
}
```

### In Blade Views
```blade
{{-- Show element if user has permission --}}
@can('Employees.create')
    <a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee</a>
@endcan

{{-- Show element if user has any permission --}}
@canany(['Employees.edit', 'Employees.manage'])
    <button class="btn btn-warning">Edit</button>
@endcanany

{{-- Hide element if user doesn't have permission --}}
@cannot('Employees.delete')
    <p>You cannot delete employees</p>
@endcannot
```

### In Routes
```php
// Single permission
Route::get('/employees/create', [EmployeeController::class, 'create'])
    ->middleware('can:Employees.create');

// Multiple permissions
Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])
    ->middleware('can:Employees.delete,Employees.manage');
```

---

## 📝 Action Button Permissions

### Common Action Buttons

#### View Button
```blade
@can('ModuleName.view')
    <a href="{{ route('module.show', $id) }}" class="btn btn-info">
        <i class="fa fa-eye"></i> View
    </a>
@endcan
```

#### Edit Button
```blade
@can('ModuleName.edit')
    <a href="{{ route('module.edit', $id) }}" class="btn btn-warning">
        <i class="fa fa-edit"></i> Edit
    </a>
@endcan
```

#### Delete Button
```blade
@can('ModuleName.delete')
    <form action="{{ route('module.destroy', $id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
            <i class="fa fa-trash"></i> Delete
        </button>
    </form>
@endcan
```

#### Create Button
```blade
@can('ModuleName.create')
    <a href="{{ route('module.create') }}" class="btn btn-success">
        <i class="fa fa-plus"></i> Create New
    </a>
@endcan
```

#### Export Button
```blade
@can('ModuleName.export')
    <a href="{{ route('module.export') }}" class="btn btn-primary">
        <i class="fa fa-download"></i> Export
    </a>
@endcan
```

#### Print Button
```blade
@can('ModuleName.print')
    <a href="{{ route('module.print', $id) }}" class="btn btn-secondary" target="_blank">
        <i class="fa fa-print"></i> Print
    </a>
@endcan
```

#### Approve Button
```blade
@can('ModuleName.approve')
    <button type="button" class="btn btn-success" onclick="approve({{ $id }})">
        <i class="fa fa-check"></i> Approve
    </button>
@endcan
```

#### Reject Button
```blade
@can('ModuleName.approve')
    <button type="button" class="btn btn-danger" onclick="reject({{ $id }})">
        <i class="fa fa-times"></i> Reject
    </button>
@endcan
```

---

## 📊 Permission Matrix

| Module | View | Create | Edit | Delete | Manage | Special |
|--------|------|--------|------|--------|--------|---------|
| Dashboard | ✅ | ❌ | ❌ | ❌ | ❌ | - |
| Employees | ✅ | ✅ | ✅ | ✅ | ✅ | Letters, Digital Card |
| Hiring | ✅ | ✅ | ✅ | ✅ | ✅ | Convert, Offer Letter |
| Inquiries | ✅ | ✅ | ✅ | ✅ | ✅ | Follow-up, Export |
| Quotations | ✅ | ✅ | ✅ | ✅ | ✅ | Print, Contract, Proforma |
| Companies | ✅ | ✅ | ✅ | ✅ | ✅ | Documents, Export |
| Proformas | ✅ | ✅ | ✅ | ✅ | ✅ | Print, Convert |
| Invoices | ✅ | ❌ | ✅ | ✅ | ✅ | Print |
| Receipts | ✅ | ✅ | ✅ | ✅ | ✅ | Print |
| Payroll | ✅ | ✅ | ✅ | ✅ | ✅ | Print, Export |
| Projects | ✅ | ✅ | ✅ | ✅ | ✅ | Tasks, Members, Comments |
| Tickets | ✅ | ✅ | ✅ | ✅ | ✅ | Assign, Resolve |
| Attendance | ✅ | ✅ | ✅ | ✅ | ✅ | Check-in, Check-out, Report |
| Leaves | ✅ | ✅ | ✅ | ✅ | ✅ | Approve, Balance |
| Holidays | ✅ | ✅ | ✅ | ✅ | ✅ | - |
| Events | ✅ | ✅ | ✅ | ✅ | ✅ | Media |
| Users | ✅ | ✅ | ✅ | ✅ | ✅ | - |
| Roles | ✅ | ✅ | ✅ | ✅ | ✅ | Assign Permissions |
| Settings | ✅ | ❌ | ✅ | ❌ | ✅ | - |
| Rules | ✅ | ❌ | ✅ | ❌ | ✅ | - |

---

## 🚀 Implementation Steps

### Step 1: Create Permissions in Database
```php
// Run this in a seeder or tinker
$permissions = [
    // Dashboard
    'Dashboard.view',
    
    // Employees
    'Employees.view',
    'Employees.create',
    'Employees.edit',
    'Employees.delete',
    'Employees.manage',
    'Employees.letters',
    'Employees.digital-card',
    'Employees.export',
    
    // ... (add all permissions from the list above)
];

foreach ($permissions as $permission) {
    Permission::create(['name' => $permission]);
}
```

### Step 2: Assign Permissions to Roles
```php
$hrManager = Role::findByName('HR Manager');
$hrManager->givePermissionTo([
    'Employees.manage',
    'Hiring.manage',
    'Attendance.manage',
    'Leaves.approve',
    'Payroll.manage',
    // ... etc
]);
```

### Step 3: Protect Routes
```php
// In routes/web.php
Route::middleware(['auth', 'can:Employees.create'])->group(function () {
    Route::get('/employees/create', [EmployeeController::class, 'create']);
});
```

### Step 4: Protect Controllers
```php
// In Controller
public function __construct()
{
    $this->middleware('can:Employees.view')->only(['index', 'show']);
    $this->middleware('can:Employees.create')->only(['create', 'store']);
    $this->middleware('can:Employees.edit')->only(['edit', 'update']);
    $this->middleware('can:Employees.delete')->only(['destroy']);
}
```

### Step 5: Protect Views
```blade
@can('Employees.create')
    <a href="{{ route('employees.create') }}">Add Employee</a>
@endcan
```

---

## ✅ Testing Checklist

- [ ] All permissions created in database
- [ ] Roles assigned proper permissions
- [ ] Routes protected with middleware
- [ ] Controllers check permissions
- [ ] Views hide/show based on permissions
- [ ] Action buttons respect permissions
- [ ] Sidebar menu items respect permissions
- [ ] API endpoints protected
- [ ] Proper error messages for unauthorized access
- [ ] Audit log for permission changes

---

## 📜 Complete Permission List (Alphabetical)

### A
- `Attendance.check-in`
- `Attendance.check-out`
- `Attendance.check-status`
- `Attendance.delete`
- `Attendance.edit`
- `Attendance.export`
- `Attendance.history`
- `Attendance.manage`
- `Attendance.report`
- `Attendance.report-export`
- `Attendance.report-generate`
- `Attendance.view`
- `Attendance.view-all`

### C
- `Companies.create`
- `Companies.delete`
- `Companies.documents`
- `Companies.edit`
- `Companies.export`
- `Companies.manage`
- `Companies.view`

### D
- `Dashboard.manage-notes`
- `Dashboard.view`
- `Dashboard.view-charts`
- `Dashboard.view-inquiries`
- `Dashboard.view-kpi`
- `Dashboard.view-notes`
- `Dashboard.view-notifications`
- `Dashboard.view-tickets`

### E
- `Employees.create`
- `Employees.delete`
- `Employees.digital-card`
- `Employees.digital-card-create`
- `Employees.digital-card-delete`
- `Employees.digital-card-edit`
- `Employees.digital-card-quick-edit`
- `Employees.edit`
- `Employees.export`
- `Employees.letters`
- `Employees.letters-create`
- `Employees.letters-generate-number`
- `Employees.letters-print`
- `Employees.letters-view`
- `Employees.manage`
- `Employees.view`
- `Events.create`
- `Events.delete`
- `Events.delete-images`
- `Events.delete-videos`
- `Events.download-images`
- `Events.download-videos`
- `Events.edit`
- `Events.manage`
- `Events.media`
- `Events.upload-images`
- `Events.upload-media`
- `Events.upload-videos`
- `Events.view`
- `Events.view-images`
- `Events.view-videos`

### H
- `Hiring.convert`
- `Hiring.create`
- `Hiring.delete`
- `Hiring.edit`
- `Hiring.manage`
- `Hiring.offer-letter`
- `Hiring.print`
- `Hiring.view`
- `Holidays.create`
- `Holidays.delete`
- `Holidays.edit`
- `Holidays.manage`
- `Holidays.view`

### I
- `Inquiries.create`
- `Inquiries.delete`
- `Inquiries.edit`
- `Inquiries.export`
- `Inquiries.follow-up`
- `Inquiries.follow-up-confirm`
- `Inquiries.follow-up-create`
- `Inquiries.manage`
- `Inquiries.view`
- `Invoices.delete`
- `Invoices.edit`
- `Invoices.manage`
- `Invoices.print`
- `Invoices.view`

### L
- `Leaves.approve`
- `Leaves.balance`
- `Leaves.balance-employee`
- `Leaves.balance-view-all`
- `Leaves.create`
- `Leaves.delete`
- `Leaves.edit`
- `Leaves.manage`
- `Leaves.paid-balance`
- `Leaves.reject`
- `Leaves.view`
- `Leaves.view-all`

### P
- `Payroll.create`
- `Payroll.delete`
- `Payroll.edit`
- `Payroll.export`
- `Payroll.get-employee-salary`
- `Payroll.manage`
- `Payroll.print`
- `Payroll.view`
- `Profile.bank-details`
- `Profile.delete`
- `Profile.edit`
- `Profile.view`
- `Proformas.convert`
- `Proformas.convert-form`
- `Proformas.create`
- `Proformas.delete`
- `Proformas.edit`
- `Proformas.manage`
- `Proformas.print`
- `Proformas.view`
- `Projects.comments`
- `Projects.comments-create`
- `Projects.comments-view`
- `Projects.create`
- `Projects.delete`
- `Projects.edit`
- `Projects.manage`
- `Projects.members`
- `Projects.members-add`
- `Projects.members-available`
- `Projects.members-remove`
- `Projects.members-view`
- `Projects.stages`
- `Projects.stages-create`
- `Projects.stages-update`
- `Projects.subtasks`
- `Projects.tasks`
- `Projects.tasks-create`
- `Projects.tasks-delete`
- `Projects.tasks-edit`
- `Projects.tasks-view`
- `Projects.view`

### Q
- `Quotations.company-details`
- `Quotations.contract`
- `Quotations.contract-file`
- `Quotations.contract-pdf`
- `Quotations.contract-png`
- `Quotations.create`
- `Quotations.create-from-inquiry`
- `Quotations.create-proforma`
- `Quotations.delete`
- `Quotations.download`
- `Quotations.edit`
- `Quotations.export`
- `Quotations.follow-up`
- `Quotations.follow-up-confirm`
- `Quotations.follow-up-create`
- `Quotations.manage`
- `Quotations.print`
- `Quotations.template-list`
- `Quotations.view`

### R
- `Receipts.create`
- `Receipts.delete`
- `Receipts.edit`
- `Receipts.manage`
- `Receipts.print`
- `Receipts.view`
- `Roles.assign-permissions`
- `Roles.create`
- `Roles.delete`
- `Roles.edit`
- `Roles.manage`
- `Roles.view`
- `Rules.download`
- `Rules.edit`
- `Rules.manage`
- `Rules.view`

### S
- `Settings.edit`
- `Settings.manage`
- `Settings.view`
- `System.backup`
- `System.clear-cache`
- `System.maintenance`
- `System.restore`
- `System.view-logs`

### T
- `Tickets.assign`
- `Tickets.change-priority`
- `Tickets.change-status`
- `Tickets.create`
- `Tickets.delete`
- `Tickets.edit`
- `Tickets.manage`
- `Tickets.resolve`
- `Tickets.view`
- `Tickets.view-all`
- `Tickets.view-own`

### U
- `Users.create`
- `Users.delete`
- `Users.edit`
- `Users.manage`
- `Users.view`

---

## 📊 Statistics

**Total Permissions**: 200+
**Total Modules**: 20
**Total Actions**: 
- View: 25+
- Create: 20+
- Edit: 20+
- Delete: 18+
- Manage: 20+
- Special Actions: 97+

---

**Last Updated**: November 24, 2025
**Status**: ✅ Complete & Ready for Implementation
**Version**: 2.0
