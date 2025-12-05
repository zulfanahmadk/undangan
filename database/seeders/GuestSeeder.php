<?php

namespace Database\Seeders;

use App\Models\Guest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guests = [
            'John Doe',
            'Jane Smith',
            'Ali Rahman',
            'Siti Nurhaliza',
            'Budi Santoso',
        ];

        foreach ($guests as $name) {
            Guest::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}
