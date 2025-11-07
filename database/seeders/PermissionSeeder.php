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
        $modules = [
            'dashboard' => ['view'],
            'employees' => ['view','create','edit','delete'],
            'hiring' => ['view','create','edit','delete'],
            'inquiries' => ['view','create','edit','delete'],
            'quotations' => ['view','create','edit','delete'],
            'companies' => ['view','create','edit','delete'],
            'projects' => ['view','create','edit','delete'],
            'performas' => ['view','create','edit','delete'],
            'invoices' => ['view'],
            'receipts' => ['view','create','edit','delete'],
            'vouchers' => ['view','create','edit','delete'],
            'tickets' => ['view','create','edit','delete'],
            'attendance' => ['view'],
            'leave_approval' => ['view','edit'],
            'events' => ['view','create','edit','delete'],
            'roles' => ['view','create','edit','delete'],
            'settings' => ['view','edit'],
        ];

        $permissions = [];
        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                $permissions[] = $module.'.'.$action;
            }
        }

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->syncPermissions($permissions);

        // Assign first user as Admin (adjust as needed)
        if ($user = User::query()->first()) {
            $user->assignRole($admin);
        }
    }
}
