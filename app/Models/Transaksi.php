<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'subtotal',
        'pajak',
        'total',
        'metode_pembayaran',
        'payment_card_id',
        'status'
    ];

    // Relasi ke User (Kasir)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Transaksi Detail
    public function details()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }

    // Relation to payment card
    public function paymentCard()
    {
        return $this->belongsTo(PaymentCard::class, 'payment_card_id');
    }
}
