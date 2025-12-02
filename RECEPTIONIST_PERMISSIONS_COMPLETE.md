# Receptionist Role - Default Permissions

## ✅ Complete Permission Set

The Receptionist role now has **18 permissions** specifically tailored for front-desk operations.

### 📊 Permission Breakdown

#### Profile Management (2 permissions)
- ✅ `Profile Management.view own profile`
- ✅ `Profile Management.edit own profile`

#### Attendance Management (3 permissions)
- ✅ `Attendance Management.check in`
- ✅ `Attendance Management.check out`
- ✅ `Attendance Management.view own attendance`

#### Dashboard (1 permission)
- ✅ `Dashboard.view dashboard`

#### Inquiries Management (8 permissions) - **FULL ACCESS**
- ✅ `Inquiries Management.view inquiry`
- ✅ `Inquiries Management.create inquiry`
- ✅ `Inquiries Management.edit inquiry`
- ✅ `Inquiries Management.manage inquiry`
- ✅ `Inquiries Management.follow up`
- ✅ `Inquiries Management.follow up create`
- ✅ `Inquiries Management.follow up confirm`
- ✅ `Inquiries Management.export inquiry`

#### Companies Management (1 permission)
- ✅ `Companies Management.view company`

#### Events Management (1 permission)
- ✅ `Events Management.view event`

#### Tickets Management (2 permissions)
- ✅ `Tickets Management.view ticket`
- ✅ `Tickets Management.create ticket`

**Total: 18 permissions**

## 🎯 What Receptionist Can Do

### ✅ Full Access
1. **Inquiries** - Complete management
   - Create new inquiries
   - Edit existing inquiries
   - Follow up with clients
   - Export inquiry data
   - Manage inquiry workflow

### ✅ Own Access
2. **Profile** - View and edit own profile
3. **Attendance** - Check in/out and view own records

### ✅ View Access
4. **Companies** - View company information
5. **Events** - View company events
6. **Dashboard** - Access dashboard

### ✅ Create Access
7. **Tickets** - Create and view support tickets

## 🚫 What Receptionist Cannot Do

### ❌ No Access To:
- Payroll management
- Employee management (create/edit employees)
- User management
- Role management
- Quotations management
- Invoices/Receipts management
- Projects management
- Delete operations (except own inquiries)

## 📋 Comparison with Other Roles

| Feature | Super Admin | Admin | HR | Receptionist | Employee | Customer |
|---------|:-----------:|:-----:|:--:|:------------:|:--------:|:--------:|
| **Profile (Own)** | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Attendance (Own)** | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| **Dashboard** | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Inquiries (Full)** | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ |
| **Companies (View)** | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ |
| **Tickets (Create)** | ✅ | ✅ | ❌ | ✅ | ✅ | ✅ |
| **Events (View)** | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Employees** | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Payroll** | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Quotations** | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |

## 🎨 Receptionist User Experience

### Header Navigation
```
┌─────────────────────────────────────────────┐
│ [☰] Dashboard  [IN/OUT]  [Profile]         │
└─────────────────────────────────────────────┘
```

### Sidebar Menu (Visible Items)
```
📊 Dashboard
📋 Inquiries Management ← Full Access
🏢 Company Information (View)
📅 Events (View)
🎫 Tickets (Create/View)
👤 Profile
```

### Sidebar Menu (Hidden Items)
```
❌ HRM (Employees/Leads)
❌ Quotation Management
❌ Invoice Management
❌ Payroll Management
❌ Projects & Tasks
❌ Attendance Management (except own)
❌ Users & Roles
```

## 🔒 Security & Access Control

### What Receptionist Sees
- ✅ Dashboard with relevant metrics
- ✅ Inquiries section (full CRUD)
- ✅ Companies list (read-only)
- ✅ Events calendar (read-only)
- ✅ Ticket creation form
- ✅ Own profile page
- ✅ IN/OUT button in header

### What Receptionist Doesn't See
- ❌ Employee management pages
- ❌ Payroll pages
- ❌ Quotation pages
- ❌ Invoice pages
- ❌ Project management pages
- ❌ User/Role management pages
- ❌ Other employees' attendance

## 💼 Business Logic

### Why These Permissions?

**Receptionists typically:**
1. **Handle Inquiries** - First point of contact
   - Answer phone calls
   - Respond to emails
   - Create inquiry records
   - Follow up with potential clients

2. **Manage Front Desk** - Reception duties
   - Greet visitors
   - Check in/out themselves
   - View company information
   - Create support tickets

3. **Limited Access** - Security
   - Don't need payroll access
   - Don't manage employees
   - Don't handle invoices
   - Don't manage projects

## 🧪 Testing Receptionist Access

### Test 1: Inquiries (Should Work)
1. Login as receptionist
2. Go to Inquiries
3. Should see: ✅ Full access
4. Can: Create, Edit, Follow up, Export

### Test 2: Companies (Should Work - View Only)
1. Go to Companies
2. Should see: ✅ Company list
3. Cannot: Create, Edit, Delete

### Test 3: Payroll (Should Fail)
1. Try to access Payroll
2. Should see: ❌ 403 Forbidden or menu hidden

### Test 4: Attendance Check-In (Should Work)
1. Click IN/OUT button
2. Should see: ✅ Check-in page
3. Can: Check in/out

### Test 5: Profile (Should Work)
1. Go to Profile
2. Should see: ✅ Own profile
3. Can: Edit own information

## 📊 Permission Count Comparison

| Role | Total Permissions | Profile | Attendance | Special Access |
|------|:-----------------:|:-------:|:----------:|:---------------|
| Super Admin | ~100+ | Full | Full | Everything |
| Admin | ~90+ | Full | Full | Almost Everything |
| HR | ~50+ | Own+Bank | Manage | Employees, Payroll |
| **Receptionist** | **18** | Own | Own | **Inquiries (Full)** |
| Employee | 5 | Own | Own | Basic |
| Customer | 2 | Own | None | Minimal |

## ✨ Key Features

1. ✅ **Inquiry Management** - Full CRUD access
2. ✅ **Front Desk Operations** - View companies, events
3. ✅ **Self-Service** - Own profile and attendance
4. ✅ **Support** - Create tickets
5. ✅ **Dashboard** - View relevant metrics
6. ✅ **IN/OUT Button** - Visible in header

## 🚀 Setup & Verification

### Apply Permissions
```bash
php setup_all_permissions_complete.php
```

### Verify Receptionist Permissions
Visit: `http://localhost/GitVraj/HrPortal/roles/5/edit`

Should see 18 permissions checked:
```
✓ Profile Management (2)
✓ Attendance Management (3)
✓ Dashboard (1)
✓ Inquiries Management (8)
✓ Companies Management (1)
✓ Events Management (1)
✓ Tickets Management (2)
```

### Test as Receptionist
1. Login as receptionist user
2. Check sidebar menu
3. Verify access to Inquiries
4. Verify IN/OUT button visible
5. Test creating an inquiry

## 📝 Summary

The Receptionist role is now configured with **18 carefully selected permissions** that enable:

✅ **Full inquiry management** (primary responsibility)  
✅ **Own profile and attendance** (self-service)  
✅ **View company data** (reference information)  
✅ **Create tickets** (support function)  
✅ **Dashboard access** (overview)  

❌ **No access to** sensitive areas (payroll, employees, invoices)

**Perfect for front-desk operations!** 🎉
