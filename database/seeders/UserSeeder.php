<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
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
                'role' => 'super-admin',
                'position' => 'Super Administrator'
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'mobile_no' => '1234567891',
                'address' => 'Admin Address',
                'role' => 'admin',
                'position' => 'Administrator'
            ],
            [
                'name' => 'HR Manager',
                'email' => 'hr@example.com',
                'password' => Hash::make('password'),
                'mobile_no' => '1234567892',
                'address' => 'HR Address',
                'role' => 'hr',
                'position' => 'HR Manager'
            ],
            [
                'name' => 'Employee User',
                'email' => 'employee@example.com',
                'password' => Hash::make('password'),
                'mobile_no' => '1234567893',
                'address' => 'Employee Address',
                'role' => 'employee',
                'position' => 'Employee'
            ],
            [
                'name' => 'Receptionist',
                'email' => 'receptionist@example.com',
                'password' => Hash::make('password'),
                'mobile_no' => '1234567894',
                'address' => 'Reception Address',
                'role' => 'receptionist',
                'position' => 'Receptionist'
            ],
            [
                'name' => 'Customer User',
                'email' => 'customer@example.com',
                'password' => Hash::make('password'),
                'mobile_no' => '1234567895',
                'address' => 'Customer Address',
                'role' => 'customer',
                'position' => 'Customer'
            ]
        ];

        foreach ($users as $userData) {
            $role = $userData['role'];
            $position = $userData['position'];
            unset($userData['role'], $userData['position']);
            
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
            
            $user->assignRole($role);
            
            // Create employee record if it doesn't exist (except for customers)
            if ($role !== 'customer') {
                Employee::firstOrCreate(
                    ['email' => $user->email],
                    [
                        'code' => Employee::nextCode(),
                        'name' => $user->name,
                        'email' => $user->email,
                        'mobile_no' => $user->mobile_no,
                        'address' => $user->address,
                        'position' => $position,
                        'gender' => 'male',
                        'status' => 'active',
                        'joining_date' => now(),
                        'user_id' => $user->id,
                    ]
                );
            }
        }
    }
}