# Ticket Attachment Feature - Complete Implementation Guide

## Overview
Complete ticket system with attachment support for both tickets and comments. Includes role-based visibility controls and file management.

---

## Feature Components

### 1. Database Structure

#### Tickets Table
- `attachment` - Stores ticket attachment file path
- Migration: `2025_12_08_122631_add_missing_fields_to_tickets_table.php`

#### Ticket Comments Table
- `attachment` - Stores comment attachment file path
- Migration: `2025_12_09_164230_add_attachment_to_ticket_comments_table.php`

### 2. File Storage
- **Location**: `storage/app/public/ticket_attachments/`
- **Symlink**: `public/storage` → `storage/app/public`
- **Supported formats**: Images, PDFs, Documents, Archives
- **Max size**: 10MB (configurable in controller)

---

## Implementation Flow

### A. Ticket Creation with Attachment

**File**: `app/Http/Controllers/TicketController.php`

```php
// Validation
$validated = $request->validate([
    'attachment' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,zip'
]);

// File Upload
if ($request->hasFile('attachment')) {
    $file = $request->file('attachment');
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('ticket_attachments', $filename, 'public');
    $ticket->attachment = $path;
}
```

**View**: `resources/views/tickets/create.blade.php`
- File input with icon
- Format and size restrictions displayed
- Preview support for images

### B. Comment with Attachment

**File**: `app/Http/Controllers/TicketController.php` → `addComment()`

```php
// Validation
$validated = $request->validate([
    'comment' => 'required|string',
    'attachment' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,zip'
]);

// File Upload
if ($request->hasFile('attachment')) {
    $file = $request->file('attachment');
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('ticket_attachments', $filename, 'public');
    $ticketComment->attachment = $path;
}
```

**View**: `resources/views/tickets/show.blade.php`
- Comment form with attachment input
- Real-time file preview
- Attachment display in comment thread

### C. Attachment Display

**File**: `resources/views/tickets/partials/comment.blade.php`

Features:
- Image preview with lightbox
- PDF inline viewer
- Document download links
- File type icons
- Responsive design

---

## Role-Based Visibility

### Customer Role Restrictions

**Tickets Index** (`resources/views/tickets/index.blade.php`):
```blade
@if(!auth()->user()->hasRole('customer'))
    <!-- Assigned To Column -->
    <th>Assigned To</th>
@endif

@if(!auth()->user()->hasRole('customer'))
    <!-- Customer Column -->
    <th>Customer</th>
@endif
```

**What Customers See**:
- ✅ Their own tickets only
- ✅ Ticket details and comments
- ✅ Attachments (theirs and employee responses)
- ❌ Assigned employee information
- ❌ Other customer information
- ❌ Internal notes (if implemented)

**What Employees/Admins See**:
- ✅ All tickets
- ✅ Customer information
- ✅ Assigned employee details
- ✅ Full ticket history
- ✅ All attachments

---

## Routes

**File**: `routes/web.php`

```php
Route::middleware(['auth'])->group(function () {
    // Ticket Management
    Route::resource('tickets', TicketController::class);
    
    // Comment with Attachment
    Route::post('tickets/{ticket}/comments', [TicketController::class, 'addComment'])
        ->name('tickets.comments.store');
    
    // Attachment Download
    Route::get('tickets/attachment/{filename}', [TicketController::class, 'downloadAttachment'])
        ->name('tickets.attachment.download');
});
```

---

## File Helper Function

**File**: `app/Helpers/helpers.php`

```php
if (!function_exists('storage_asset')) {
    function storage_asset($path) {
        return asset('storage/' . $path);
    }
}
```

Usage in views:
```blade
<img src="{{ storage_asset($ticket->attachment) }}" alt="Attachment">
```

---

## Security Features

### 1. File Validation
- Type checking (MIME types)
- Size limits (10MB default)
- Extension whitelist
- Malicious file prevention

### 2. Access Control
- Authentication required
- Role-based permissions
- Owner verification for customers
- Secure file paths

### 3. Storage Security
- Files stored outside public root
- Symlink for controlled access
- Unique filenames (timestamp prefix)
- No direct URL access

---

## Testing Checklist

### Ticket Attachments
- [ ] Upload image to new ticket
- [ ] Upload PDF to new ticket
- [ ] Upload document to new ticket
- [ ] Verify file size limit (>10MB should fail)
- [ ] Verify invalid file type rejection
- [ ] View attachment in ticket details
- [ ] Download attachment

### Comment Attachments
- [ ] Add comment with image
- [ ] Add comment with PDF
- [ ] Add comment without attachment
- [ ] Multiple comments with attachments
- [ ] View all attachments in thread
- [ ] Download comment attachments

### Role-Based Access
- [ ] Customer sees only their tickets
- [ ] Customer cannot see "Assigned To" column
- [ ] Customer cannot see "Customer" column
- [ ] Employee sees all tickets
- [ ] Admin sees all tickets with full details
- [ ] Customer can view/download their attachments

### Edge Cases
- [ ] Ticket without attachment
- [ ] Comment without attachment
- [ ] Multiple attachments in same ticket
- [ ] Large file handling
- [ ] Special characters in filename
- [ ] Concurrent uploads

---

## Troubleshooting

### Issue: Attachments not displaying

**Solution**:
```bash
# Create storage symlink
php artisan storage:link

# Check permissions
chmod -R 775 storage/app/public/ticket_attachments
```

### Issue: File upload fails

**Check**:
1. PHP `upload_max_filesize` in php.ini
2. PHP `post_max_size` in php.ini
3. Storage directory permissions
4. Disk space availability

### Issue: Customer sees wrong columns

**Fix**: Verify role check in view
```blade
@if(!auth()->user()->hasRole('customer'))
    <!-- Hidden content -->
@endif
```

---

## Quick Command Reference

### For Similar Column Visibility Issues:

```
Hide [COLUMN_NAME] column from [ROLE_NAME] role in [VIEW_FILE]:
1. Wrap column header with @if(!auth()->user()->hasRole('[ROLE_NAME]'))
2. Wrap column data cell with same condition
3. Close with @endif after </td>
4. Test with [ROLE_NAME] user login
```

### For Attachment Feature Issues:

```
Debug ticket attachment feature:
1. Check storage symlink: php artisan storage:link
2. Verify migration ran: check tickets/ticket_comments tables
3. Check file permissions: storage/app/public/ticket_attachments
4. Test upload with small file first
5. Check browser console for JS errors
6. Verify routes are registered: php artisan route:list | grep ticket
```

### For Role-Based Visibility:

```
Hide UI element from [ROLE]:
- Single element: @if(!auth()->user()->hasRole('[ROLE]')) ... @endif
- Multiple roles: @if(!auth()->user()->hasAnyRole(['role1', 'role2'])) ... @endif
- Show only to role: @if(auth()->user()->hasRole('[ROLE]')) ... @endif
- Check permission: @can('permission-name') ... @endcan
```

---

## File Structure Summary

```
app/
├── Http/Controllers/
│   └── TicketController.php          # Main ticket logic
├── Models/
│   ├── Ticket.php                    # Ticket model
│   └── TicketComment.php             # Comment model
└── Helpers/
    └── helpers.php                   # storage_asset() helper

database/migrations/
├── 2025_12_08_122631_add_missing_fields_to_tickets_table.php
└── 2025_12_09_164230_add_attachment_to_ticket_comments_table.php

resources/views/tickets/
├── index.blade.php                   # Ticket list (role-based columns)
├── create.blade.php                  # Create ticket with attachment
├── show.blade.php                    # Ticket details + comments
└── partials/
    └── comment.blade.php             # Comment display with attachment

storage/app/public/
└── ticket_attachments/               # Uploaded files

public/
└── storage/                          # Symlink to storage/app/public
```

---

## Quick Fix Commands

### Reset Storage
```bash
php artisan storage:link
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Clear Cache
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
```

### Database Refresh
```bash
php artisan migrate:fresh --seed
```

### Check Routes
```bash
php artisan route:list | grep ticket
```

---

## Future Enhancements

### Potential Improvements:
1. **Multiple Attachments**: Allow multiple files per ticket/comment
2. **File Preview**: Better preview for more file types
3. **Drag & Drop**: Drag and drop file upload
4. **Image Compression**: Auto-compress large images
5. **Attachment Gallery**: Grid view of all attachments
6. **Version Control**: Track attachment versions
7. **Virus Scanning**: Integrate antivirus for uploads
8. **Cloud Storage**: S3/Azure integration for large files

---

## Support

### Common Questions:

**Q: Can I change the file size limit?**
A: Yes, modify validation in `TicketController.php`:
```php
'attachment' => 'nullable|file|max:20480' // 20MB
```

**Q: How to add more file types?**
A: Update MIME types in validation:
```php
'attachment' => 'nullable|file|mimes:jpg,png,pdf,doc,docx,xls,xlsx,zip,rar'
```

**Q: Can customers see employee attachments?**
A: Yes, customers see all attachments in their tickets (including employee responses).

**Q: How to delete old attachments?**
A: Create a cleanup command:
```php
php artisan make:command CleanOldAttachments
```

---

## Version History

- **v1.0** - Initial implementation with basic attachment support
- **v1.1** - Added comment attachments
- **v1.2** - Role-based column visibility for customers
- **v1.3** - Enhanced file preview and download

---

**Last Updated**: December 9, 2025
**Maintained By**: Development Team
**Status**: ✅ Production Ready
