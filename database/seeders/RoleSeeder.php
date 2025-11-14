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

        $roles = [
            'super-admin' => [
                'description' => 'Super Administrator with full access',
                'permissions' => $allPermissions,
            ],
            'admin' => [
                'description' => 'Administrator with most access',
                'permissions' => $allPermissions,
            ],
            'hr' => [
                'description' => 'HR Manager with employee and payroll access',
                'permissions' => [],
            ],
            'employee' => [
                'description' => 'Regular employee with limited access',
                'permissions' => [],
            ],
            'receptionist' => [
                'description' => 'Receptionist with inquiry and basic access',
                'permissions' => [],
            ],
            'customer' => [
                'description' => 'Customer with very limited access',
                'permissions' => [],
            ],
        ];

        foreach ($roles as $roleName => $roleData) {
            $role = Role::firstOrCreate(
                ['name' => $roleName, 'guard_name' => 'web'],
                ['description' => $roleData['description']]
            );
            $role->syncPermissions($roleData['permissions']);
        }
    }
}