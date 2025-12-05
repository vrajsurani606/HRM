<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Define modules and their permissions
        $modules = [
            'Events Management' => ['view event', 'create event', 'edit event', 'delete event', 'manage event',
            'upload event image', 'download event image', 'view event image', 'delete event image'],
            'Employees Management' => ['view employee', 'create employee', 'edit employee', 'delete employee', 'manage employee',
            'letters', 'letters create', 'letters view', 'letters edit', 'letters delete', 'letters print', 
            'digital card', 'digital card create', 'digital card edit', 'digital card delete'],
            'Leads Management' => ['view lead', 'create lead', 'edit lead', 'delete lead', 'manage lead', 
            'print lead', 'convert lead', 'offer letter', 'view resume'],
            'Payroll Management' => ['view payroll', 'create payroll', 'edit payroll', 'delete payroll', 'manage payroll',
            'export payroll', 'print payroll', 'bulk generate payroll'],
            'Attendance Management' => ['view attendance', 'create attendance', 'edit attendance', 'delete attendance', 'manage attendance', 'check in', 'check out', 'view own attendance'],
            'Users Management' => ['view user', 'create user', 'edit user', 'delete user', 'manage user'],
            'Roles Management' => ['view role', 'create role', 'edit role', 'delete role', 'manage role'],
            'Dashboard' => ['view dashboard', 'manage dashboard'],
            'Profile Management' => ['view profile', 'edit profile', 'update profile', 'update bank details', 'delete profile', 'view own profile', 'edit own profile', 'view own payroll', 'view own attendance', 'view own documents', 'view own bank details', 'upload documents'],
            'Inquiries Management' => ['view inquiry', 'create inquiry', 'edit inquiry', 'delete inquiry', 'manage inquiry',
            'follow up', 'follow up create', 'follow up confirm', 'export inquiry'],
            'Quotations Management' => ['view quotation', 'create quotation', 'edit quotation', 'delete quotation', 'manage quotation',
            'follow up', 'follow up create', 'follow up confirm', 'export quotation', 'download quotation', 'print quotation',
            'create proforma', 'template list', 'contract generate', 'convert to company'],
            'Companies Management' => ['view company', 'create company', 'edit company', 'delete company', 'manage company',
            'export company', 'view documents', 'upload documents'],
            'Proformas Management' => ['view proforma', 'create proforma', 'edit proforma', 'delete proforma', 'manage proforma',
            'export proforma', 'print proforma', 'convert proforma'],
            'Invoices Management' => ['view invoice', 'edit invoice', 'delete invoice', 'manage invoice',
            'export invoice', 'print invoice'],
            'Receipts Management' => ['view receipt', 'create receipt', 'edit receipt', 'delete receipt', 'manage receipt',
            'export receipt', 'print receipt'],
            'Projects Management' => ['view project', 'create project', 'edit project', 'delete project', 'manage project',
            'export project', 'print project', 'project overview',
            'manage stages', 'create stage', 'edit stage', 'delete stage',
            'view tasks', 'create task', 'edit task', 'delete task', 'complete task',
            'view members', 'add member', 'remove member', 'edit member role',
            'view comments', 'create comment', 'edit comment', 'delete comment',
            'view attachments', 'upload attachment', 'download attachment', 'delete attachment'],
            'Tickets Management' => ['view ticket', 'create ticket', 'edit ticket', 'delete ticket', 'manage ticket',
            'export ticket', 'print ticket', 'assign ticket', 'reassign ticket',
            'change status', 'change priority', 'change work status',
            'view comments', 'create comment', 'edit comment', 'delete comment',
            'view attachments', 'upload attachment', 'download attachment', 'delete attachment',
            'view history', 'close ticket', 'reopen ticket'],
            'Reports Management' => ['view report', 'create report', 'edit report', 'delete report', 'manage report'],
            'Rules Management' => ['view rules', 'manage rules'],
        ];

        // Create permissions
        $permissions = [];
        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                $permissionName = $module . '.' . $action;
                $permissions[] = $permissionName;
                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                ]);
            }
        }

        // // Create roles
        // $roles = [
        //     'super-admin' => [
        //         'description' => 'Super Administrator with full access',
        //         'permissions' => $permissions // All permissions
        //     ],
        //     'admin' => [
        //         'description' => 'Administrator with most access',
        //         'permissions' => [
        //             'dashboard.view', 'dashboard.manage',
        //             'employees.view', 'employees.create', 'employees.edit', 'employees.delete', 'employees.manage',
        //             'leads.view', 'leads.create', 'leads.edit', 'leads.delete', 'leads.manage',
        //             'payroll.view', 'payroll.create', 'payroll.edit', 'payroll.manage',
        //             'attendance.view', 'attendance.create', 'attendance.edit', 'attendance.manage',
        //             'events.view', 'events.create', 'events.edit', 'events.delete', 'events.manage',
        //             // Human-readable event permissions
        //             'view event', 'create event', 'edit event', 'delete event', 'manage event',
        //             'upload event image', 'download event image', 'view event image', 'delete event image',
        //             'inquiries.view', 'inquiries.create', 'inquiries.edit', 'inquiries.delete', 'inquiries.manage',
        //             'quotations.view', 'quotations.create', 'quotations.edit', 'quotations.delete', 'quotations.manage',
        //             'companies.view', 'companies.create', 'companies.edit', 'companies.delete', 'companies.manage',
        //             'projects.view', 'projects.create', 'projects.edit', 'projects.delete', 'projects.manage',
        //             'tickets.view', 'tickets.create', 'tickets.edit', 'tickets.delete', 'tickets.manage',
        //             'reports.view', 'reports.create', 'reports.edit', 'reports.manage',
        //             'users.view', 'users.create', 'users.edit', 'users.manage',
        //         ]
        //     ],
        //     'hr' => [
        //         'description' => 'HR Manager with employee and payroll access',
        //         'permissions' => [
        //             'dashboard.view',
        //             'employees.view', 'employees.create', 'employees.edit', 'employees.delete', 'employees.manage',
        //             'leads.view', 'leads.create', 'leads.edit', 'leads.delete', 'leads.manage',
        //             'payroll.view', 'payroll.create', 'payroll.edit', 'payroll.manage',
        //             'attendance.view', 'attendance.create', 'attendance.edit', 'attendance.manage',
        //             'events.view', 'events.create', 'events.edit', 'events.manage',
        //             // Human-readable event permissions
        //             'view event', 'create event', 'edit event', 'manage event',
        //             'upload event image', 'download event image', 'view event image',
        //             'reports.view', 'reports.create', 'reports.manage',
        //         ]
        //     ],
        //     'employee' => [
        //         'description' => 'Regular employee with limited access',
        //         'permissions' => [
        //             'dashboard.view',
        //             'attendance.view', 'attendance.create',
        //             'events.view', 'view event',
        //             'tickets.view', 'tickets.create',
        //         ]
        //     ],
        //     'receptionist' => [
        //         'description' => 'Receptionist with inquiry and basic access',
        //         'permissions' => [
        //             'dashboard.view',
        //             'inquiries.view', 'inquiries.create', 'inquiries.edit', 'inquiries.manage',
        //             'events.view', 'view event',
        //             'tickets.view', 'tickets.create',
        //             'companies.view',
        //         ]
        //     ],
        //     'customer' => [
        //         'description' => 'Customer with very limited access',
        //         'permissions' => [
        //             'dashboard.view',
        //             'tickets.view', 'tickets.create',
        //             'events.view', 'view event',
        //         ]
        //     ]
        // ];

        // // Create roles and assign permissions
        // foreach ($roles as $roleName => $roleData) {
        //     $role = Role::firstOrCreate(
        //         ['name' => $roleName],
        //         ['description' => $roleData['description']]
        //     );
        //     $role->syncPermissions($roleData['permissions']);
        // }

        // // Create default super admin user if no users exist
        // if (User::count() === 0) {
        //     $superAdmin = User::create([
        //         'name' => 'Super Admin',
        //         'email' => 'admin@hrportal.com',
        //         'password' => bcrypt('password'),
        //     ]);
        //     $superAdmin->assignRole('super-admin');
        // }
    }
}
