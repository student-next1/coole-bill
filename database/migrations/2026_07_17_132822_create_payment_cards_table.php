<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_cards', function (Blueprint $table) {
            $table->id();
            $table->string('card_code')->unique(); // Format: CARD-XXXXXX atau custom format
            $table->string('barcode_data'); // Data untuk barcode (biasanya sama dengan card_code)
            $table->string('username')->nullable()->unique();
            $table->decimal('saldo', 15, 2)->default(0);
            $table->enum('status', ['active', 'inactive', 'blocked'])->default('active');
            $table->string('holder_name')->nullable(); // Nama pemilik kartu
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['card_code', 'username']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_cards');
    }
};
