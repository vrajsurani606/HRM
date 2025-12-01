# Quick Start: User-Company Linking

## ✅ What Was Fixed

Customer users can now see their company's data (projects, quotations, invoices) in the dashboard by properly linking users to companies.

## 🚀 Quick Commands

### Check if a user is linked:
```bash
php check_user_company.php <user_id>
```
Example:
```bash
php check_user_company.php 26
```

### Auto-link all users by email:
```bash
php artisan users:link-companies --auto
```

### Show all user linkage status:
```bash
php artisan users:link-companies --show
```

### Link specific user to company:
```bash
php artisan users:link-companies --user=<user_id> --company=<company_id>
```
Example:
```bash
php artisan users:link-companies --user=26 --company=9
```

## 📊 Current Status

### ✅ Successfully Linked (10 users):
- **kuldip (Company)** → Chitri Enlarge (1 project, 2 quotations, 2 invoices)
- Mejia and Meadows Co → Mejia and Meadows Co
- fdsafdf asfdsfdafdasfd → fdsafdf asfdsfdafdasfd
- dsgfsg → sdfaffdssd
- test → test
- Vraj surani → mahima
- dhruvi → dhruvi
- ashish (Company) → ashish fashion
- test (Company) → shaloni
- jignasha jethavatest (Company) → geolab

### ⚠️ Unlinked (7 users):
Need manual linking if they require company access

## 🔧 How It Works

1. **Database**: Added `company_id` column to `users` table
2. **Models**: User belongs to Company, Company has many Users
3. **Dashboard**: Filters data by user's company_id
4. **Data Mapping**:
   - Projects: `projects.company_id = user.company_id`
   - Quotations: `quotations.customer_id = user.company_id`
   - Invoices: `invoices.company_name = company.company_name`

## 📝 For Developers

### When creating new customer users:
```php
$user = User::create([
    'name' => 'Customer Name',
    'email' => 'customer@example.com',
    'password' => bcrypt('password'),
    'company_id' => $companyId, // Important!
]);
```

### To get user's company data:
```php
$user = auth()->user();
$company = $user->company;
$projects = $company->projects;
```

## 🎯 Testing

Login as kuldip (kuldip1234@gmail.com) to see the customer dashboard with:
- Company name in welcome banner
- 1 active project
- 2 quotations
- 2 invoices

## 📚 Documentation

- Full guide: `USER_COMPANY_LINKING_GUIDE.md`
- Implementation details: `CUSTOMER_DASHBOARD_FIX_SUMMARY.md`

## ⚡ Quick Troubleshooting

**User sees no projects?**
```bash
php check_user_company.php <user_id>
```
If not linked, run:
```bash
php artisan users:link-companies --user=<user_id> --company=<company_id>
```

**Need to see all companies?**
```bash
php artisan tinker --execute="DB::table('companies')->select('id', 'company_name')->get()->each(fn(\$c) => print(\$c->id . ' - ' . \$c->company_name . PHP_EOL));"
```

## ✨ Benefits

- ✅ Proper data isolation between companies
- ✅ Accurate project/quotation/invoice display
- ✅ Multiple users can belong to same company
- ✅ Easy to manage and maintain
- ✅ Secure and scalable
