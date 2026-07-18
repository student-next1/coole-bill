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
        // Change enum to accept both old and new values
        DB::statement("ALTER TABLE transaksis MODIFY metode_pembayaran ENUM('tunai', 'kartu_id', 'transfer', 'e-wallet', 'kartu') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE transaksis MODIFY metode_pembayaran ENUM('tunai', 'transfer', 'e-wallet', 'kartu') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL");
    }
};
