@extends('layouts.app')

@section('title','Kategori')
@section('page-title','Kategori')

@section('content')

<!-- Header Section -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h3 class="text-lg font-semibold text-gray-900">Daftar Kategori</h3>
        <p class="text-sm text-gray-600 mt-1">Kelola kategori produk Anda</p>
    </div>
    <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" 
            class="px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200">
        + Tambah Kategori
    </button>
</div>

<!-- Stats Card -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Kategori</p>
        <h3 class="text-3xl font-bold text-gray-900">12</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Kategori Aktif</p>
        <h3 class="text-3xl font-bold text-green-600">10</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Kategori Nonaktif</p>
        <h3 class="text-3xl font-bold text-gray-600">2</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Produk</p>
        <h3 class="text-3xl font-bold text-orange-600">120</h3>
    </div>
</div>

<!-- Grid Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    <!-- Kategori Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-orange-300 transition-all duration-200">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center">
                <span class="text-2xl">🍔</span>
            </div>
            <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Aktif</span>
        </div>
        <h4 class="text-lg font-bold text-gray-900 mb-2">Makanan</h4>
        <p class="text-sm text-gray-600 mb-4">45 Produk</p>
        <div class="flex items-center gap-2">
            <button class="flex-1 px-4 py-2 text-sm text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors duration-150">Edit</button>
            <button class="flex-1 px-4 py-2 text-sm text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors duration-150">Hapus</button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-orange-300 transition-all duration-200">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                <span class="text-2xl">🥤</span>
            </div>
            <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Aktif</span>
        </div>
        <h4 class="text-lg font-bold text-gray-900 mb-2">Minuman</h4>
        <p class="text-sm text-gray-600 mb-4">35 Produk</p>
        <div class="flex items-center gap-2">
            <button class="flex-1 px-4 py-2 text-sm text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors duration-150">Edit</button>
            <button class="flex-1 px-4 py-2 text-sm text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors duration-150">Hapus</button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-orange-300 transition-all duration-200">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-purple-200 rounded-lg flex items-center justify-center">
                <span class="text-2xl">🍿</span>
            </div>
            <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Aktif</span>
        </div>
        <h4 class="text-lg font-bold text-gray-900 mb-2">Snack</h4>
        <p class="text-sm text-gray-600 mb-4">25 Produk</p>
        <div class="flex items-center gap-2">
            <button class="flex-1 px-4 py-2 text-sm text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors duration-150">Edit</button>
            <button class="flex-1 px-4 py-2 text-sm text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors duration-150">Hapus</button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-orange-300 transition-all duration-200">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center">
                <span class="text-2xl">🍰</span>
            </div>
            <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Aktif</span>
        </div>
        <h4 class="text-lg font-bold text-gray-900 mb-2">Dessert</h4>
        <p class="text-sm text-gray-600 mb-4">15 Produk</p>
        <div class="flex items-center gap-2">
            <button class="flex-1 px-4 py-2 text-sm text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors duration-150">Edit</button>
            <button class="flex-1 px-4 py-2 text-sm text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors duration-150">Hapus</button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-orange-300 transition-all duration-200">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                <span class="text-2xl">📦</span>
            </div>
            <span class="px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">Nonaktif</span>
        </div>
        <h4 class="text-lg font-bold text-gray-900 mb-2">Lain-lain</h4>
        <p class="text-sm text-gray-600 mb-4">0 Produk</p>
        <div class="flex items-center gap-2">
            <button class="flex-1 px-4 py-2 text-sm text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors duration-150">Edit</button>
            <button class="flex-1 px-4 py-2 text-sm text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors duration-150">Hapus</button>
        </div>
    </div>

</div>

<!-- Modal Tambah Kategori -->
<div id="modalTambah" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-xl font-bold text-gray-900">Tambah Kategori</h3>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Masukkan nama kategori">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" rows="3" placeholder="Masukkan deskripsi"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option>Aktif</option>
                    <option>Nonaktif</option>
                </select>
            </div>
        </div>
        <div class="p-6 border-t border-slate-200 flex items-center gap-3">
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" 
                    class="flex-1 px-4 py-2 border border-slate-300 text-gray-700 rounded-lg hover:bg-slate-50 transition-colors duration-150">
                Batal
            </button>
            <button class="flex-1 px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white rounded-lg hover:shadow-lg transition-all duration-150">
                Simpan
            </button>
        </div>
    </div>
</div>

@endsection
