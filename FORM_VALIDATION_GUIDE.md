# Form Validation & Error Handling Guide

## Global Error Styles Added
✅ Added comprehensive error styling to `public/new_theme/css/hrportal.css`

## Standard Error Handling Pattern

### For All Input Fields
```blade
<input 
  class="Rectangle-29 @error('field_name') is-invalid @enderror" 
  name="field_name" 
  value="{{ old('field_name') }}"
  placeholder="Enter value"
>
@error('field_name')
  <small class="hrp-error">{{ $message }}</small>
@enderror
```

### For Select Dropdowns
```blade
<select 
  class="Rectangle-29-select @error('field_name') is-invalid @enderror" 
  name="field_name"
>
  <option value="">Select Option</option>
  <option value="value1" {{ old('field_name') == 'value1' ? 'selected' : '' }}>Option 1</option>
</select>
@error('field_name')
  <small class="hrp-error">{{ $message }}</small>
@enderror
```

### For Textareas
```blade
<textarea 
  class="Rectangle-29 Rectangle-29-textarea @error('field_name') is-invalid @enderror" 
  name="field_name"
  placeholder="Enter text"
>{{ old('field_name') }}</textarea>
@error('field_name')
  <small class="hrp-error">{{ $message }}</small>
@enderror
```

### For File Uploads
```blade
<div class="upload-pill Rectangle-29 @error('field_name') is-invalid @enderror">
  <div class="choose">Choose File</div>
  <div class="filename" id="fileName">No File Chosen</div>
  <input type="file" name="field_name" id="fileInput">
</div>
@error('field_name')
  <small class="hrp-error">{{ $message }}</small>
@enderror
```

## Forms Already Updated ✅

1. **Inquiries**
   - ✅ `resources/views/inquiries/create.blade.php` - All fields have error handling
   - ✅ `resources/views/inquiries/edit.blade.php` - All fields have error handling

2. **Quotations**
   - ✅ `resources/views/quotations/create.blade.php` - Most fields have error handling
   - ✅ `resources/views/quotations/edit.blade.php` - Most fields have error handling

3. **Companies**
   - ✅ `resources/views/companies/create.blade.php` - All fields have error handling
   - ✅ `resources/views/companies/edit.blade.php` - All fields have error handling

4. **Employees**
   - ✅ `resources/views/hr/employees/create.blade.php` - PAN No has validation
   - ✅ `resources/views/hr/employees/edit.blade.php` - PAN No has validation

5. **Performas**
   - ✅ `resources/views/performas/create.blade.php` - GST No has validation
   - ✅ `resources/views/performas/edit.blade.php` - GST No has validation

## CSS Classes Reference

### Error Highlighting Classes
- `.is-invalid` - Adds red border and error icon to invalid fields
- `.hrp-error` - Styles error message text in red

### Input Classes
- `.Rectangle-29` - Standard input field
- `.Rectangle-29-select` - Select dropdown
- `.Rectangle-29-textarea` - Textarea field
- `.upload-pill` - File upload component

## Validation Rules Examples

### Common Field Validations

**Required Field:**
```php
'field_name' => 'required'
```

**Email:**
```php
'email' => 'required|email'
```

**Phone Number (10 digits):**
```php
'phone' => 'required|digits:10'
```

**PAN Number (10 characters):**
```php
'pan_no' => 'nullable|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'
```

**GST Number (15 characters):**
```php
'gst_no' => 'nullable|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/'
```

**Date:**
```php
'date_field' => 'required|date'
```

**File Upload:**
```php
'file_field' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120'
```

## Quick Checklist for Each Form

- [ ] All input fields have `@error('field_name') is-invalid @enderror` class
- [ ] All fields have `@error('field_name')<small class="hrp-error">{{ $message }}</small>@enderror` below them
- [ ] All fields use `old('field_name')` to preserve values on validation error
- [ ] Select dropdowns have `old('field_name') == 'value' ? 'selected' : ''` for each option
- [ ] Required fields are marked with `<span class="text-red-500">*</span>` in label
- [ ] Form has proper validation rules in the controller
- [ ] Error styles section exists in the view (if not using global styles)

## Testing Validation

1. Submit form with empty required fields
2. Check that red borders appear on invalid fields
3. Check that error messages appear below fields
4. Check that valid values are preserved after validation error
5. Check that error disappears when field is corrected

## Notes

- Global error styles are now in `public/new_theme/css/hrportal.css`
- No need to add error styles in individual views anymore
- All forms will automatically use the global error styling
- Make sure to clear browser cache after CSS updates
