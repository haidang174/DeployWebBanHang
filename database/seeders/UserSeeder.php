<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Regular users
        User::create([
            'name' => 'Nguyễn Văn A',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Trần Thị B',
            'email' => 'user2@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Lê Văn C',
            'email' => 'user3@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Phạm Thị D',
            'email' => 'user4@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'google_id' => '123456789',
            'email_verified_at' => now(),
        ]);

        // Tạo thêm 10 users random
        User::factory()->count(10)->create();
    }
}