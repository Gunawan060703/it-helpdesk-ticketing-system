<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'username' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@hotelloccal.com',
            'password' => Hash::make('admin123'),
            'full_name' => 'Administrator',
            'department' => 'IT Department',
            'phone' => '081234567890',
            'role' => 'admin',
            'status' => 'active'
        ]);

        User::create([
            'username' => 'it_support',
            'name' => 'IT Support',
            'email' => 'itsupport@hotelloccal.com',
            'password' => Hash::make('itsupport123'),
            'full_name' => 'IT Support Team',
            'department' => 'IT Department',
            'phone' => '081234567891',
            'role' => 'admin',
            'status' => 'active'
        ]);

        User::create([
            'username' => 'john_doe',
            'name' => 'John',
            'email' => 'john@hotelloccal.com',
            'password' => Hash::make('user123'),
            'full_name' => 'John Doe',
            'department' => 'Front Office',
            'phone' => '081234567892',
            'role' => 'user',
            'status' => 'active'
        ]);

        User::create([
            'username' => 'jane_smith',
            'name' => 'Jane',
            'email' => 'jane@hotelloccal.com',
            'password' => Hash::make('user123'),
            'full_name' => 'Jane Smith',
            'department' => 'Housekeeping',
            'phone' => '081234567893',
            'role' => 'user',
            'status' => 'active'
        ]);

        User::create([
            'username' => 'budi_santoso',
            'name' => 'Budi',
            'email' => 'budi@hotelloccal.com',
            'password' => Hash::make('user123'),
            'full_name' => 'Budi Santoso',
            'department' => 'F&B Service',
            'phone' => '081234567894',
            'role' => 'user',
            'status' => 'active'
        ]);
    }
}