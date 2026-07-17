<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produks = [
            // Makanan
            [
                'kode_produk' => 'PRD001',
                'nama_produk' => 'Nasi Goreng',
                'kategori_id' => 1,
                'harga' => 15000,
                'stok' => 50,
                'deskripsi' => 'Nasi goreng spesial dengan telur',
                'status' => 'aktif'
            ],
            [
                'kode_produk' => 'PRD002',
                'nama_produk' => 'Mie Ayam',
                'kategori_id' => 1,
                'harga' => 12000,
                'stok' => 30,
                'deskripsi' => 'Mie ayam bakso',
                'status' => 'aktif'
            ],
            [
                'kode_produk' => 'PRD003',
                'nama_produk' => 'Nasi Uduk',
                'kategori_id' => 1,
                'harga' => 10000,
                'stok' => 40,
                'deskripsi' => 'Nasi uduk komplit',
                'status' => 'aktif'
            ],
            
            // Minuman
            [
                'kode_produk' => 'PRD004',
                'nama_produk' => 'Es Teh Manis',
                'kategori_id' => 2,
                'harga' => 5000,
                'stok' => 100,
                'deskripsi' => 'Teh manis dingin',
                'status' => 'aktif'
            ],
            [
                'kode_produk' => 'PRD005',
                'nama_produk' => 'Kopi Hitam',
                'kategori_id' => 2,
                'harga' => 8000,
                'stok' => 80,
                'deskripsi' => 'Kopi hitam original',
                'status' => 'aktif'
            ],
            [
                'kode_produk' => 'PRD006',
                'nama_produk' => 'Jus Jeruk',
                'kategori_id' => 2,
                'harga' => 12000,
                'stok' => 60,
                'deskripsi' => 'Jus jeruk segar',
                'status' => 'aktif'
            ],
            
            // Snack
            [
                'kode_produk' => 'PRD007',
                'nama_produk' => 'Pisang Goreng',
                'kategori_id' => 3,
                'harga' => 8000,
                'stok' => 35,
                'deskripsi' => 'Pisang goreng crispy',
                'status' => 'aktif'
            ],
            [
                'kode_produk' => 'PRD008',
                'nama_produk' => 'Kentang Goreng',
                'kategori_id' => 3,
                'harga' => 10000,
                'stok' => 40,
                'deskripsi' => 'Kentang goreng dengan saus',
                'status' => 'aktif'
            ],
            [
                'kode_produk' => 'PRD009',
                'nama_produk' => 'Popcorn',
                'kategori_id' => 3,
                'harga' => 10000,
                'stok' => 40,
                'deskripsi' => 'Popcorn caramel',
                'status' => 'aktif'
            ],
            
            // Dessert
            [
                'kode_produk' => 'PRD010',
                'nama_produk' => 'Cake Coklat',
                'kategori_id' => 4,
                'harga' => 25000,
                'stok' => 15,
                'deskripsi' => 'Cake coklat lembut',
                'status' => 'aktif'
            ],
            [
                'kode_produk' => 'PRD011',
                'nama_produk' => 'Puding',
                'kategori_id' => 4,
                'harga' => 8000,
                'stok' => 25,
                'deskripsi' => 'Puding vanilla',
                'status' => 'aktif'
            ],
            [
                'kode_produk' => 'PRD012',
                'nama_produk' => 'Es Krim',
                'kategori_id' => 4,
                'harga' => 15000,
                'stok' => 30,
                'deskripsi' => 'Es krim berbagai rasa',
                'status' => 'aktif'
            ],
        ];

        foreach ($produks as $produk) {
            Produk::create($produk);
        }
    }
}
