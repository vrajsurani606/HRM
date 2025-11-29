# Pagination and Sorting Implementation

## Overview
I have successfully implemented proper pagination with 10 entries per page by default and added sorting functionality to all data index pages in your Laravel application.

## Changes Made

### 1. Controllers Updated
All the following controllers have been updated with:
- Default pagination of 10 entries per page (changed from 25)
- Sorting functionality with validation
- Proper query parameter handling

**Updated Controllers:**
- `app/Http/Controllers/Receipt/ReceiptController.php`
- `app/Http/Controllers/Invoice/InvoiceController.php`
- `app/Http/Controllers/Quotation/QuotationController.php`
- `app/Http/Controllers/Performa/PerformaController.php`
- `app/Http/Controllers/Inquiry/InquiryController.php`
- `app/Http/Controllers/Company/CompanyController.php`
- `app/Http/Controllers/PayrollController.php`
- `app/Http/Controllers/HR/HiringController.php`

### 2. Sorting Implementation
Each controller now includes:
```php
// Handle sorting
$sortBy = $request->get('sort', 'created_at');
$sortDirection = $request->get('direction', 'desc');

// Validate sort column
$allowedSorts = ['column1', 'column2', ...];
if (!in_array($sortBy, $allowedSorts)) {
    $sortBy = 'created_at';
}

// Validate sort direction
if (!in_array($sortDirection, ['asc', 'desc'])) {
    $sortDirection = 'desc';
}

$query->orderBy($sortBy, $sortDirection);
```

### 3. Views Updated
All index views have been updated with:
- Sortable table headers with visual indicators (↑/↓)
- Proper pagination controls with entries selector
- Consistent footer pagination section

**Updated Views:**
- `resources/views/receipts/index.blade.php`
- `resources/views/invoices/index.blade.php`
- `resources/views/quotations/index.blade.php`
- `resources/views/performas/index.blade.php`
- `resources/views/inquiries/index.blade.php`

### 4. Reusable Component
Created a reusable Blade component for sortable headers:
- `resources/views/components/sortable-header.blade.php`

Usage:
```blade
<th><x-sortable-header column="unique_code" title="Receipt No" /></th>
```

### 5. Pagination Features
- **Default entries per page**: 10 (changed from 25)
- **Entries selector**: Users can choose 10, 25, 50, or 100 entries per page
- **Proper query parameter handling**: All filters and sorting parameters are preserved during pagination
- **Consistent pagination UI**: Uses the existing `vendor.pagination.jv` template

### 6. Sortable Columns by Module

**Receipts:**
- Receipt No (unique_code)
- Receipt Date (receipt_date)
- Invoice Type (invoice_type)
- Company Name (company_name)
- Received Amount (received_amount)

**Invoices:**
- Invoice No (unique_code)
- Invoice Date (invoice_date)
- Invoice Type (invoice_type)
- Bill To (company_name)
- Total Tax (total_tax_amount)
- Total Amount (final_amount)

**Quotations:**
- Code (unique_code)
- Company Name (company_name)
- Update (updated_at)
- Next Update (tentative_complete_date)
- Status (status)

**Performas:**
- Proforma No (unique_code)
- Proforma Date (proforma_date)
- Bill To (company_name)
- Grand Total (sub_total)
- Total Amount (final_amount)

**Inquiries:**
- Code (unique_code)
- Inquiry Date (inquiry_date)
- Company Name (company_name)
- Person Name (contact_name)
- Industry Type (industry_type)

**Companies:**
- Company Name (company_name)
- GST No (gst_no)
- Contact Person (contact_person_name)
- Contact Mobile (contact_person_mobile)
- Email (company_email)
- Code (unique_code)

**Payroll:**
- Month (month)
- Year (year)
- Status (status)
- Basic Salary (basic_salary)
- Total Salary (total_salary)

**Hiring:**
- Person Name (person_name)
- Mobile No (mobile_no)
- Position (position)
- Gender (gender)
- Experience (experience_count)

## Features
1. **Click to Sort**: Click on any sortable column header to sort
2. **Visual Indicators**: Arrow indicators (↑/↓) show current sort direction
3. **Toggle Direction**: Click the same header again to reverse sort direction
4. **Persistent Filters**: All search filters are maintained during sorting and pagination
5. **Validation**: Only allowed columns can be sorted, preventing SQL injection
6. **Default Sorting**: Falls back to 'created_at' desc if invalid sort parameters are provided

## Usage
Users can now:
1. Click on any sortable column header to sort by that column
2. Click again to reverse the sort direction
3. Use the entries selector to change how many records are displayed per page
4. Navigate through pages while maintaining their sort preferences and filters

All existing functionality (search, filters, etc.) continues to work as before, with the added benefit of sorting and improved pagination.