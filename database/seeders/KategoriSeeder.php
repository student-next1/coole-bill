<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Makanan',
                'deskripsi' => 'Berbagai jenis makanan',
                'status' => 'aktif'
            ],
            [
                'nama_kategori' => 'Minuman',
                'deskripsi' => 'Berbagai jenis minuman',
                'status' => 'aktif'
            ],
            [
                'nama_kategori' => 'Snack',
                'deskripsi' => 'Berbagai jenis snack dan cemilan',
                'status' => 'aktif'
            ],
            [
                'nama_kategori' => 'Dessert',
                'deskripsi' => 'Berbagai jenis makanan penutup',
                'status' => 'aktif'
            ],
            [
                'nama_kategori' => 'Lain-lain',
                'deskripsi' => 'Produk lainnya',
                'status' => 'nonaktif'
            ],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
