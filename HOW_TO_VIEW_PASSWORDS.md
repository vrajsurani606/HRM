# How to View User & Employee Passwords

## Quick Access

### For Users:
1. Go to **Users** page (`/users`)
2. Click the **"View All Passwords"** button (yellow button with key icon)
3. This takes you to `/system-passwords` where you can see all user passwords

### For Employees:
1. Go to **Employees** page (`/employees`)
2. Click the **"Passwords"** button (yellow button with key icon)
3. This takes you to `/system-passwords/employees` where you can see all employee passwords

### For Companies:
1. Navigate directly to `/system-passwords/companies`
2. Or use the navigation buttons on any system-passwords page

## Important Notes

### Why Some Passwords Show "Not stored"?

**Existing users/employees** (created before December 9, 2025) will show "Not stored" because:
- They were created before the `plain_password` feature was added
- The migration only adds the database column, it doesn't populate existing passwords

### How to Store Passwords for Existing Users/Employees?

You have 3 options:

#### Option 1: Update Their Password (Recommended)
1. Go to the user/employee edit page
2. Enter a new password
3. Save
4. The plain password will now be stored and visible

#### Option 2: Create New Users/Employees
- Any NEW user or employee created after the migration will automatically have their password stored

#### Option 3: Keep Using Default Passwords
- For employees, if no password was set during creation, the default is "password123"
- You can document this separately

## Where Passwords Are Displayed

### 1. System Passwords Pages (Admin Only)
- `/system-passwords` - All users
- `/system-passwords/employees` - All employees  
- `/system-passwords/companies` - All companies

Features:
- Search functionality
- Show/hide password toggle
- Copy to clipboard
- Pagination

### 2. Individual User/Employee Pages (Admin Only)

#### User Show Page
- Password field appears below "Joined" field
- Only visible if user has `plain_password` stored
- Toggle visibility and copy buttons included

#### User Edit Page
- Current password shown below password input field
- Helps admin know what the current password is before changing

#### Employee Show Page
- Password field in "Personal Information" tab
- Only visible if employee has `plain_password` stored
- Toggle visibility and copy buttons included

#### Employee Edit Page
- Current password shown below password input field

## Security

- **Only super-admin users can view passwords**
- Regular users and employees cannot see passwords
- Password fields are completely hidden for non-admin users

## Testing

To test the feature:

1. **Create a new user:**
   ```
   - Go to Users > Create User
   - Fill in details with password: "test123"
   - Save
   - Go to System Passwords page
   - You should see "test123" for this user
   ```

2. **Update an existing user:**
   ```
   - Go to Users > Edit any user
   - Change password to "newpass456"
   - Save
   - Go to System Passwords page
   - You should see "newpass456" for this user
   ```

3. **View in user details:**
   ```
   - Go to Users > View any user (with stored password)
   - Scroll to password field
   - Click eye icon to show/hide
   - Click copy icon to copy to clipboard
   ```

## Direct URLs

- Users Passwords: `http://localhost/system-passwords`
- Employee Passwords: `http://localhost/system-passwords/employees`
- Company Passwords: `http://localhost/system-passwords/companies`

## Troubleshooting

### "Not stored" appears for all users
- This is normal for existing users
- Update their passwords to store them

### Password field doesn't appear in user/employee show page
- Check if you're logged in as super-admin
- Check if the user/employee has `plain_password` in database
- Run: `SELECT id, name, plain_password FROM users;` to verify

### "Permission denied" error
- Only super-admin role can access system passwords
- Check your role: `SELECT * FROM model_has_roles WHERE model_id = YOUR_USER_ID;`

## Database Check

To see which users have passwords stored:

```sql
-- Check users
SELECT id, name, email, 
       CASE WHEN plain_password IS NULL THEN 'Not stored' ELSE 'Stored' END as password_status
FROM users;

-- Check employees  
SELECT id, name, email,
       CASE WHEN plain_password IS NULL THEN 'Not stored' ELSE 'Stored' END as password_status
FROM employees;
```
