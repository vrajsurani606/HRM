# Payment Terms Setup Guide

## Issue Fixed: Duplicate Proforma Creation

The system has been updated to prevent duplicate proforma creation from the same template. Here's what was implemented:

### 1. Duplicate Prevention Logic
- Added validation in `PerformaController@store` to check if a proforma already exists for the same `quotation_id` and `template_index`
- Updated template list view to properly track proformas by `template_index` instead of just `type_of_billing`
- Added proforma code display in template list when proforma exists

### 2. Proper Payment Terms Structure

To ensure your payment terms work correctly, set up quotations with these terms:

#### Recommended Payment Terms Structure:
1. **40% ON INSTALLATION** - 40% completion
2. **40% COMPLETION** - 40% completion  
3. **10% ADVANCE** - 10% completion
4. **10% RETENTION** - 10% completion

### 3. How to Set Up Payment Terms in Quotation

When creating/editing a quotation:

1. Go to the "Payment Terms" section (Services 2)
2. Add 4 rows with the following:

| Description | Completion % | Completion Terms | Amount |
|-------------|--------------|------------------|---------|
| ON INSTALLATION | 40 | ON INSTALLATION | (calculated) |
| COMPLETION | 40 | COMPLETION | (calculated) |
| ADVANCE | 10 | ADVANCE | (calculated) |
| RETENTION | 10 | RETENTION | (calculated) |

### 4. Template List Behavior

- Each payment term creates a separate template in the template list
- Once a proforma is generated for a template, the "+" button is replaced with view/edit buttons
- The system prevents creating duplicate proformas for the same template
- Proforma code is displayed next to existing proformas

### 5. Fixed Issues

✅ **Duplicate Proforma Prevention**: System now checks `template_index` to prevent duplicates
✅ **Proper Template Tracking**: Each template is uniquely identified by its index
✅ **Better User Experience**: Clear indication of which proformas exist
✅ **Redirect After Creation**: Returns to template list after successful proforma creation

### 6. Usage Instructions

1. Create a quotation with proper payment terms (as shown above)
2. Go to Template List from the quotation
3. Click "+" to generate proforma for each term
4. System prevents creating duplicate proformas
5. View/edit existing proformas using the action buttons

### 7. Error Messages

If you try to create a duplicate proforma, you'll see:
```
A proforma for this template has already been created. Proforma Code: CMS/PROF/XXXX
```

This ensures data integrity and prevents confusion with multiple proformas for the same payment term.