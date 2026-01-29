<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            // Change status column from string to integer
            // 1 = Sudah Dikirim, 2 = Belum Dikirim
            DB::statement('ALTER TABLE guests MODIFY status INT DEFAULT 2');
        });

        // Convert existing string values to integers
        DB::table('guests')
            ->where('status', 'Sudah Kirim Undangan')
            ->update(['status' => 1]);

        DB::table('guests')
            ->where('status', 'Belum Dikirim')
            ->update(['status' => 2]);

        // Set remaining null values to 2 (default)
        DB::table('guests')
            ->whereNull('status')
            ->update(['status' => 2]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            DB::statement('ALTER TABLE guests MODIFY status VARCHAR(255) DEFAULT "Belum Dikirim"');
        });
    }
};
