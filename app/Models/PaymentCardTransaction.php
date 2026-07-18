<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['payment_card_id', 'transaksi_id', 'type', 'amount', 'saldo_before', 'saldo_after', 'description'])]
class PaymentCardTransaction extends Model
{
    // Relationship to payment card
    public function paymentCard()
    {
        return $this->belongsTo(PaymentCard::class, 'payment_card_id');
    }

    // Relationship to transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
}
