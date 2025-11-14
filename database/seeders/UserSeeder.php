<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@hrportal.com',
                'password' => Hash::make('password'),
                'mobile_no' => '1234567890',
                'address' => 'Admin Address',
                'role' => 'super-admin'
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'mobile_no' => '1234567891',
                'address' => 'Admin Address',
                'role' => 'admin'
            ],
            [
                'name' => 'HR Manager',
                'email' => 'hr@example.com',
                'password' => Hash::make('password'),
                'mobile_no' => '1234567892',
                'address' => 'HR Address',
                'role' => 'hr'
            ],
            [
                'name' => 'Employee User',
                'email' => 'employee@example.com',
                'password' => Hash::make('password'),
                'mobile_no' => '1234567893',
                'address' => 'Employee Address',
                'role' => 'employee'
            ],
            [
                'name' => 'Receptionist',
                'email' => 'receptionist@example.com',
                'password' => Hash::make('password'),
                'mobile_no' => '1234567894',
                'address' => 'Reception Address',
                'role' => 'receptionist'
            ],
            [
                'name' => 'Customer User',
                'email' => 'customer@example.com',
                'password' => Hash::make('password'),
                'mobile_no' => '1234567895',
                'address' => 'Customer Address',
                'role' => 'customer'
            ]
        ];

        foreach ($users as $userData) {
            $role = $userData['role'];
            unset($userData['role']);
            
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
            
            $user->assignRole($role);
        }
    }
}