<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('========================================');
        $this->info('Create Admin User');
        $this->info('========================================');
        $this->newLine();

        $name = $this->ask('Nama admin');
        
        $email = $this->ask('Email admin');
        
        if (User::where('email', $email)->exists()) {
            $this->error("Email '$email' sudah terdaftar!");
            return 1;
        }

        $password = $this->secret('Password (minimal 6 karakter)');
        $passwordConfirm = $this->secret('Konfirmasi password');

        if ($password !== $passwordConfirm) {
            $this->error('Password tidak cocok!');
            return 1;
        }

        if (strlen($password) < 6) {
            $this->error('Password harus minimal 6 karakter!');
            return 1;
        }

        try {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $this->newLine();
            $this->info('✓ Admin user berhasil dibuat!');
            $this->newLine();
            $this->table(
                ['Field', 'Value'],
                [
                    ['Nama', $name],
                    ['Email', $email],
                ]
            );
            $this->newLine();
            $this->info('Anda sekarang dapat login dengan email dan password di atas.');

            return 0;
        } catch (\Exception $e) {
            $this->error('Gagal membuat admin user: ' . $e->getMessage());
            return 1;
        }
    }
}
