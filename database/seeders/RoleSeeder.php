<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $allPermissions = Permission::where('guard_name', 'web')->pluck('name')->toArray();

        // Define role-specific permissions
        $roles = [
            // Super Admin - Full access to everything
            'super-admin' => [
                'description' => 'Super Administrator with full access',
                'dashboard_type' => 'admin',
                'permissions' => $allPermissions,
            ],

            // Admin - Full access to everything (same as super-admin)
            'admin' => [
                'description' => 'Administrator with most access',
                'dashboard_type' => 'admin',
                'permissions' => $allPermissions,
            ],

            // HR - Employee management, payroll, attendance, leads, events, reports
            'hr' => [
                'description' => 'HR Manager with employee and payroll access',
                'dashboard_type' => 'hr',
                'permissions' => [
                    // Dashboard
                    'Dashboard.view dashboard',
                    'Dashboard.manage dashboard',
                    
                    // Employees Management - Full access
                    'Employees Management.view employee',
                    'Employees Management.create employee',
                    'Employees Management.edit employee',
                    'Employees Management.delete employee',
                    'Employees Management.manage employee',
                    'Employees Management.letters',
                    'Employees Management.letters create',
                    'Employees Management.letters view',
                    'Employees Management.letters edit',
                    'Employees Management.letters delete',
                    'Employees Management.letters print',
                    'Employees Management.digital card',
                    'Employees Management.digital card create',
                    'Employees Management.digital card edit',
                    'Employees Management.digital card delete',
                    
                    // Leads Management - Full access
                    'Leads Management.view lead',
                    'Leads Management.create lead',
                    'Leads Management.edit lead',
                    'Leads Management.delete lead',
                    'Leads Management.manage lead',
                    'Leads Management.print lead',
                    'Leads Management.convert lead',
                    'Leads Management.offer letter',
                    'Leads Management.view resume',
                    
                    // Payroll Management - Full access
                    'Payroll Management.view payroll',
                    'Payroll Management.create payroll',
                    'Payroll Management.edit payroll',
                    'Payroll Management.delete payroll',
                    'Payroll Management.manage payroll',
                    'Payroll Management.export payroll',
                    'Payroll Management.print payroll',
                    'Payroll Management.bulk generate payroll',
                    
                    // Attendance Management - Full access
                    'Attendance Management.check in',
                    'Attendance Management.check out',
                    'Attendance Management.view attendance',
                    'Attendance Management.create attendance',
                    'Attendance Management.edit attendance',
                    'Attendance Management.delete attendance',
                    'Attendance Management.view attendance report',
                    'Attendance Management.export attendance report',
                    
                    // Leave Management - Full access
                    'Leave Management.view leave',
                    'Leave Management.create leave',
                    'Leave Management.edit leave',
                    'Leave Management.delete leave',
                    'Leave Management.manage leave',
                    'Leave Management.approve leave',
                    'Leave Management.reject leave',
                    'Leave Management.view own leave',
                    'Leave Management.cancel leave',
                    
                    // Leave Approval Management - Full access
                    'Leave Approval Management.view leave approval',
                    'Leave Approval Management.create leave approval',
                    'Leave Approval Management.edit leave approval',
                    'Leave Approval Management.delete leave approval',
                    'Leave Approval Management.approve leave',
                    'Leave Approval Management.reject leave',
                    
                    // Company Holidays Management - Full access
                    'Company Holidays Management.view holiday',
                    'Company Holidays Management.create holiday',
                    'Company Holidays Management.edit holiday',
                    'Company Holidays Management.delete holiday',
                    'Company Holidays Management.manage holiday',
                    
                    // Events Management - Full access
                    'Events Management.view event',
                    'Events Management.create event',
                    'Events Management.edit event',
                    'Events Management.delete event',
                    'Events Management.manage event',
                    'Events Management.upload event image',
                    'Events Management.download event image',
                    'Events Management.view event image',
                    'Events Management.delete event image',
                    
                    // Profile Management
                    'Profile Management.view profile',
                    'Profile Management.edit profile',
                    'Profile Management.update profile',
                    'Profile Management.update bank details',
                    'Profile Management.view own profile',
                    'Profile Management.edit own profile',
                    'Profile Management.view own payroll',
                    'Profile Management.view own attendance',
                    'Profile Management.view own documents',
                    'Profile Management.view own bank details',
                    
                    // Reports Management
                    'Reports Management.view report',
                    'Reports Management.create report',
                    'Reports Management.edit report',
                    'Reports Management.manage report',
                    
                    // Rules Management
                    'Rules Management.view rules',
                    'Rules Management.manage rules',
                    
                    // Tickets Management - Full access for HR
                    'Tickets Management.manage ticket',
                    'Tickets Management.view ticket',
                    'Tickets Management.create ticket',
                    'Tickets Management.edit ticket',
                    'Tickets Management.delete ticket',
                    'Tickets Management.export ticket',
                    'Tickets Management.print ticket',
                    'Tickets Management.assign ticket',
                    'Tickets Management.reassign ticket',
                    'Tickets Management.change status',
                    'Tickets Management.change priority',
                    'Tickets Management.view comments',
                    'Tickets Management.create comment',
                    
                    // Users Management - View only
                    'Users Management.view user',
                    
                    // Roles Management - View only
                    'Roles Management.view role',
                ],
            ],

            // Employee - Limited access to own data and basic features
            'employee' => [
                'description' => 'Regular employee with limited access',
                'restrict_to_own_data' => true,
                'dashboard_type' => 'employee',
                'permissions' => [
                    // Dashboard
                    'Dashboard.view dashboard',
                    
                    // Profile Management - Own profile only
                    'Profile Management.view own profile',
                    'Profile Management.edit own profile',
                    'Profile Management.view own payroll',
                    'Profile Management.view own attendance',
                    'Profile Management.view own documents',
                    'Profile Management.view own bank details',
                    
                    // Attendance - Check in/out only
                    'Attendance Management.check in',
                    'Attendance Management.check out',
                    
                    // Leave Management - Own leave only
                    'Leave Management.view own leave',
                    'Leave Management.create leave',
                    'Leave Management.cancel leave',
                    
                    // Leave Approval - View own leave requests and create new
                    'Leave Approval Management.view leave approval',
                    'Leave Approval Management.create leave approval',
                    
                    // Company Holidays - View only
                    'Company Holidays Management.view holiday',
                    
                    // Events - View only
                    'Events Management.view event',
                    'Events Management.view event image',
                    
                    // Tickets Management - Employee access (assigned tickets only)
                    'Tickets Management.view ticket',
                    'Tickets Management.create ticket',
                    'Tickets Management.view comments',
                    'Tickets Management.create comment',
                    'Tickets Management.view attachments',
                    'Tickets Management.upload attachment',
                    'Tickets Management.download attachment',
                    'Tickets Management.complete ticket',
                    'Tickets Management.print ticket',
                    
                    // Projects - View assigned projects and tasks
                    'Projects Management.view project',
                    'Projects Management.view tasks',
                    'Projects Management.edit task',
                    'Projects Management.complete task',
                    'Projects Management.view comments',
                    'Projects Management.create comment',
                    'Projects Management.view attachments',
                    'Projects Management.upload attachment',
                    'Projects Management.download attachment',
                    
                    // Rules - View company rules
                    'Rules Management.view rules',
                ],
            ],

            // Receptionist - Inquiry management, basic company view, events
            'receptionist' => [
                'description' => 'Receptionist with inquiry and basic access',
                'dashboard_type' => 'receptionist',
                'permissions' => [
                    // Dashboard
                    'Dashboard.view dashboard',
                    
                    // Profile Management - Own profile
                    'Profile Management.view own profile',
                    'Profile Management.edit own profile',
                    'Profile Management.view own payroll',
                    'Profile Management.view own attendance',
                    'Profile Management.view own documents',
                    'Profile Management.view own bank details',
                    
                    // Attendance - Check in/out only
                    'Attendance Management.check in',
                    'Attendance Management.check out',
                    
                    // Leave Management - Own leave only
                    'Leave Management.view own leave',
                    'Leave Management.create leave',
                    'Leave Management.cancel leave',
                    
                    // Leave Approval - View own leave requests and create new
                    'Leave Approval Management.view leave approval',
                    'Leave Approval Management.create leave approval',
                    
                    // Company Holidays - View only
                    'Company Holidays Management.view holiday',
                    
                    // Inquiries Management - Full access
                    'Inquiries Management.view inquiry',
                    'Inquiries Management.create inquiry',
                    'Inquiries Management.edit inquiry',
                    'Inquiries Management.delete inquiry',
                    'Inquiries Management.manage inquiry',
                    'Inquiries Management.follow up',
                    'Inquiries Management.follow up create',
                    'Inquiries Management.follow up confirm',
                    'Inquiries Management.export inquiry',
                    
                    // Quotations - View and create
                    'Quotations Management.view quotation',
                    'Quotations Management.create quotation',
                    'Quotations Management.edit quotation',
                    'Quotations Management.follow up',
                    'Quotations Management.follow up create',
                    'Quotations Management.print quotation',
                    'Quotations Management.download quotation',
                    
                    // Companies - View only
                    'Companies Management.view company',
                    
                    // Events - View only
                    'Events Management.view event',
                    'Events Management.view event image',
                    
                    // Tickets Management - Receptionist access
                    'Tickets Management.view ticket',
                    'Tickets Management.create ticket',
                    'Tickets Management.edit ticket',
                    'Tickets Management.view comments',
                    'Tickets Management.create comment',
                    'Tickets Management.view attachments',
                    'Tickets Management.upload attachment',
                    'Tickets Management.download attachment',
                    'Tickets Management.print ticket',
                    
                    // Rules - View
                    'Rules Management.view rules',
                ],
            ],

            // Customer - Very limited access, mainly tickets and own projects
            'customer' => [
                'description' => 'Customer with very limited access',
                'restrict_to_own_data' => true,
                'dashboard_type' => 'customer',
                'permissions' => [
                    // Dashboard
                    'Dashboard.view dashboard',
                    
                    // Profile Management - Own profile only
                    'Profile Management.view own profile',
                    'Profile Management.edit own profile',
                    
                    // Tickets Management - Customer access (own tickets only)
                    'Tickets Management.view ticket',
                    'Tickets Management.create ticket',
                    'Tickets Management.edit ticket',
                    'Tickets Management.view comments',
                    'Tickets Management.create comment',
                    'Tickets Management.view attachments',
                    'Tickets Management.upload attachment',
                    'Tickets Management.download attachment',
                    'Tickets Management.close ticket',
                    'Tickets Management.print ticket',
                    
                    // Quotations - View own quotations
                    'Quotations Management.view quotation',
                    'Quotations Management.download quotation',
                    
                    // Proformas - View own
                    'Proformas Management.view proforma',
                    'Proformas Management.print proforma',
                    
                    // Invoices - View own
                    'Invoices Management.view invoice',
                    'Invoices Management.print invoice',
                    
                    // Receipts - View own
                    'Receipts Management.view receipt',
                    'Receipts Management.print receipt',
                ],
            ],
        ];

        foreach ($roles as $roleName => $roleData) {
            $role = Role::firstOrCreate(
                ['name' => $roleName, 'guard_name' => 'web'],
                [
                    'description' => $roleData['description'],
                    'restrict_to_own_data' => $roleData['restrict_to_own_data'] ?? false,
                    'dashboard_type' => $roleData['dashboard_type'] ?? 'admin',
                ]
            );
            
            // Update settings if role already exists
            $role->update([
                'restrict_to_own_data' => $roleData['restrict_to_own_data'] ?? false,
                'dashboard_type' => $roleData['dashboard_type'] ?? 'admin',
            ]);
            
            // Filter permissions to only include existing ones
            $validPermissions = array_intersect($roleData['permissions'], $allPermissions);
            $role->syncPermissions($validPermissions);
            
            $this->command->info("Role '{$roleName}' created with " . count($validPermissions) . " permissions.");
        }
    }
}
