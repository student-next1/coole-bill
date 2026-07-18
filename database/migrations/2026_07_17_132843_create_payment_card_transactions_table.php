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
        Schema::create('payment_card_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_card_id')->constrained('payment_cards')->onDelete('cascade');
            $table->foreignId('transaksi_id')->nullable()->constrained('transaksis')->onDelete('set null');
            $table->enum('type', ['purchase', 'topup', 'refund', 'adjustment'])->default('purchase');
            $table->decimal('amount', 15, 2);
            $table->decimal('saldo_before', 15, 2);
            $table->decimal('saldo_after', 15, 2);
            $table->string('description')->nullable();
            $table->timestamps();

            $table->index(['payment_card_id', 'created_at']);
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_card_transactions');
    }
};
