<?php

namespace App\Console\Commands;

use App\Models\Guest;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GetGuestLink extends Command
{
    protected $signature = 'guest:link {name : Nama tamu}';

    protected $description = 'Dapatkan link undangan untuk tamu';

    public function handle()
    {
        $name = $this->argument('name');

        $guest = Guest::where('name', $name)
            ->orWhere('slug', Str::slug($name))
            ->first();

        if (!$guest) {
            $this->error("Tamu '{$name}' tidak ditemukan.");
            $this->info('Daftar tamu:');

            Guest::all()->each(function ($g) {
                $this->line("  - {$g->name} ({$g->slug})");
            });

            return 1;
        }

        $baseUrl = config('app.url');
        $link = "{$baseUrl}?to={$guest->slug}";

        $this->info("✓ Link undangan untuk {$guest->name}:");
        $this->line('');
        $this->line("<fg=green>{$link}</>");
        $this->line('');

        return 0;
    }
}
