<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates admin and user accounts for testing
     */
    public function run(): void
    {
        // Ensure roles exist first
        $adminRole = Role::where('name', 'admin')->firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Admin user dengan akses penuh ke sistem']
        );

        $userRole = Role::where('name', 'user')->firstOrCreate(
            ['name' => 'user'],
            ['description' => 'User biasa, tidak dapat membuat user baru']
        );

        // Create admin user if not exists
        $adminUser = User::where('email', 'admin@example.com')->first();

        if (!$adminUser) {
            $adminUser = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]);

            // Assign admin role
            $adminUser->roles()->attach($adminRole->id);
        }

        // Create test user if not exists
        $testUser = User::where('email', 'user@example.com')->first();

        if (!$testUser) {
            $testUser = User::create([
                'name' => 'Test User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            // Assign user role
            $testUser->roles()->attach($userRole->id);
        }
    }
}
