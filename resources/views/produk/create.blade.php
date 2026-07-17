@extends('layouts.app')

@section('title','Tambah Produk')
@section('page-title','Tambah Produk')

@section('content')

<div class="max-w-4xl">

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('produk.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 text-sm text-gray-600 hover:text-orange-600 transition-colors duration-150">
            ← Kembali ke Daftar Produk
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
        
        <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Produk</h3>

        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">

                <!-- Kode Produk & Nama Produk -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kode Produk *</label>
                        <input type="text" 
                               name="kode_produk" 
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" 
                               placeholder="PRD001"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk *</label>
                        <input type="text" 
                               name="nama_produk" 
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" 
                               placeholder="Nasi Goreng Spesial"
                               required>
                    </div>
                </div>

                <!-- Kategori & Harga -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                        <select name="kategori" 
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                required>
                            <option value="">Pilih Kategori</option>
                            <option>Makanan</option>
                            <option>Minuman</option>
                            <option>Snack</option>
                            <option>Dessert</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga *</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2 text-gray-600">Rp</span>
                            <input type="number" 
                                   name="harga" 
                                   class="w-full pl-12 pr-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                   placeholder="15000"
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Stok & Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stok *</label>
                        <input type="number" 
                               name="stok" 
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" 
                               placeholder="50"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select name="status" 
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                required>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" 
                              rows="4" 
                              class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" 
                              placeholder="Masukkan deskripsi produk..."></textarea>
                </div>

                <!-- Gambar Produk -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk</label>
                    <input type="file" 
                           name="gambar" 
                           accept="image/*"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 2MB</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-4 pt-6 border-t border-slate-200">
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200">
                        Simpan Produk
                    </button>
                    <a href="{{ route('produk.index') }}" 
                       class="px-6 py-3 border border-slate-300 text-gray-700 font-medium rounded-lg hover:bg-slate-50 transition-colors duration-150">
                        Batal
                    </a>
                </div>

            </div>

        </form>

    </div>

</div>

@endsection
