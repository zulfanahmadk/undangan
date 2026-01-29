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
        // Mengubah array menjadi asosiatif agar bisa menyimpan nama dan nomor WhatsApp
        $guests = [
            ['name' => 'John Doe', 'whatsapp' => '6281234567890'],
            ['name' => 'Jane Smith', 'whatsapp' => '6281234567891'],
            ['name' => 'Ali Rahman', 'whatsapp' => '6281234567892'],
            ['name' => 'Siti Nurhaliza', 'whatsapp' => '6281234567893'],
            ['name' => 'Budi Santoso', 'whatsapp' => '6281234567894'],
        ];

        foreach ($guests as $guest) {
            Guest::create([
                'name'     => $guest['name'],
                'slug'     => Str::slug($guest['name']),
                'whatsapp' => $guest['whatsapp'], // Menambahkan input ke field whatsapp
            ]);
        }
    }
}