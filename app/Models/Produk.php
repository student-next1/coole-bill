<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'kategori_id',
        'harga',
        'stok',
        'deskripsi',
        'gambar',
        'status'
    ];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Relasi ke Transaksi Detail
    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class, 'produk_id');
    }
}
