<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Carbon\Carbon;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Transaksi 1
        $transaksi1 = Transaksi::create([
            'kode_transaksi' => 'TRX001',
            'user_id' => 1,
            'subtotal' => 25000,
            'pajak' => 2500,
            'total' => 27500,
            'metode_pembayaran' => 'tunai',
            'status' => 'sukses',
            'created_at' => Carbon::now()->subHours(3)
        ]);

        TransaksiDetail::create([
            'transaksi_id' => $transaksi1->id,
            'produk_id' => 1, // Nasi Goreng
            'jumlah' => 1,
            'harga' => 15000,
            'subtotal' => 15000
        ]);

        TransaksiDetail::create([
            'transaksi_id' => $transaksi1->id,
            'produk_id' => 4, // Es Teh Manis
            'jumlah' => 2,
            'harga' => 5000,
            'subtotal' => 10000
        ]);

        // Transaksi 2
        $transaksi2 = Transaksi::create([
            'kode_transaksi' => 'TRX002',
            'user_id' => 1,
            'subtotal' => 125000,
            'pajak' => 12500,
            'total' => 137500,
            'metode_pembayaran' => 'transfer',
            'status' => 'sukses',
            'created_at' => Carbon::now()->subHours(2)
        ]);

        TransaksiDetail::create([
            'transaksi_id' => $transaksi2->id,
            'produk_id' => 10, // Cake Coklat
            'jumlah' => 5,
            'harga' => 25000,
            'subtotal' => 125000
        ]);

        // Transaksi 3
        $transaksi3 = Transaksi::create([
            'kode_transaksi' => 'TRX003',
            'user_id' => 1,
            'subtotal' => 30000,
            'pajak' => 3000,
            'total' => 33000,
            'metode_pembayaran' => 'tunai',
            'status' => 'pending',
            'created_at' => Carbon::now()->subHour()
        ]);

        TransaksiDetail::create([
            'transaksi_id' => $transaksi3->id,
            'produk_id' => 2, // Mie Ayam
            'jumlah' => 2,
            'harga' => 12000,
            'subtotal' => 24000
        ]);

        TransaksiDetail::create([
            'transaksi_id' => $transaksi3->id,
            'produk_id' => 6, // Jus Jeruk
            'jumlah' => 1,
            'harga' => 12000,
            'subtotal' => 12000
        ]);

        // Transaksi 4-10 (data tambahan untuk laporan)
        for ($i = 4; $i <= 10; $i++) {
            $subtotal = rand(20000, 100000);
            $pajak = $subtotal * 0.1;
            $total = $subtotal + $pajak;

            $transaksi = Transaksi::create([
                'kode_transaksi' => 'TRX' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'user_id' => 1,
                'subtotal' => $subtotal,
                'pajak' => $pajak,
                'total' => $total,
                'metode_pembayaran' => ['tunai', 'transfer', 'e-wallet', 'kartu'][rand(0, 3)],
                'status' => 'sukses',
                'created_at' => Carbon::now()->subHours(rand(1, 24))
            ]);

            // Random produk untuk setiap transaksi
            $jumlahItem = rand(1, 3);
            for ($j = 0; $j < $jumlahItem; $j++) {
                $produkId = rand(1, 12);
                $harga = [15000, 12000, 10000, 5000, 8000, 12000, 8000, 10000, 10000, 25000, 8000, 15000][$produkId - 1];
                $qty = rand(1, 3);

                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $produkId,
                    'jumlah' => $qty,
                    'harga' => $harga,
                    'subtotal' => $harga * $qty
                ]);
            }
        }
    }
}
