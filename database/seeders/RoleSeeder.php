<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin role
        Role::firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Admin user dengan akses penuh ke sistem']
        );

        // Create user role
        Role::firstOrCreate(
            ['name' => 'user'],
            ['description' => 'User biasa, tidak dapat membuat user baru']
        );
    }
}
