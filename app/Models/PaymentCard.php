<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['card_code', 'barcode_data', 'username', 'saldo', 'status', 'holder_name', 'notes'])]
class PaymentCard extends Model
{
    // Relationship to transactions
    public function transactions()
    {
        return $this->hasMany(PaymentCardTransaction::class, 'payment_card_id');
    }

    // Relationship to transaksis (POS transactions paid with this card)
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'payment_card_id');
    }

    // Helper: Generate unique card code
    public static function generateCardCode()
    {
        $timestamp = date('YmdHis');
        $random = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
        return "CARD-{$timestamp}-{$random}";
    }

    // Helper: Check saldo available
    public function hasEnoughBalance($amount)
    {
        return $this->saldo >= $amount && $this->status === 'active';
    }

    // Helper: Deduct balance
    public function deductBalance($amount, $transaksiId = null, $description = null)
    {
        $saldobefore = $this->saldo;
        $this->saldo -= $amount;
        $this->save();

        PaymentCardTransaction::create([
            'payment_card_id' => $this->id,
            'transaksi_id' => $transaksiId,
            'type' => 'purchase',
            'amount' => $amount,
            'saldo_before' => $saldobefore,
            'saldo_after' => $this->saldo,
            'description' => $description,
        ]);

        return true;
    }

    // Helper: Add balance (topup)
    public function addBalance($amount, $description = null)
    {
        $saldobefore = $this->saldo;
        $this->saldo += $amount;
        $this->save();

        PaymentCardTransaction::create([
            'payment_card_id' => $this->id,
            'type' => 'topup',
            'amount' => $amount,
            'saldo_before' => $saldobefore,
            'saldo_after' => $this->saldo,
            'description' => $description,
        ]);

        return true;
    }
}
