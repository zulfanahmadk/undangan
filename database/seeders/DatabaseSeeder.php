<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles first
        $this->call(RoleSeeder::class);

        // Get admin role
        $adminRole = Role::where('name', 'admin')->first();

        // Create test admin user if not exists
        $adminUser = User::where('email', 'test@example.com')->first();
        if (!$adminUser) {
            $adminUser = User::create([
                'name' => 'Test Admin',
                'email' => 'test@example.com',
                'password' => Hash::make('password'), // Password: "password"
                'email_verified_at' => now(),
            ]);

            // Attach admin role
            if ($adminRole) {
                $adminUser->roles()->attach($adminRole->id);
            }
        }

        // Create additional test user
        $testUser = User::where('email', 'user@example.com')->first();
        if (!$testUser) {
            $userRole = Role::where('name', 'user')->first();
            $testUser = User::create([
                'name' => 'Test User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'), // Password: "password"
                'email_verified_at' => now(),
            ]);

            // Attach user role
            if ($userRole) {
                $testUser->roles()->attach($userRole->id);
            }
        }

        $this->call(GuestSeeder::class);
    }
}
