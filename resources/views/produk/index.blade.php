@extends('layouts.app')

@section('title','Produk')
@section('page-title','Produk')

@section('content')

<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
        <h3 class="text-lg md:text-xl font-semibold text-gray-900">Daftar Produk</h3>
        <p class="text-sm text-gray-600 mt-1">Kelola semua produk toko Anda</p>
    </div>
    <a href="{{ route('produk.create') }}" 
       class="inline-block px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 text-center text-sm md:text-base">
        + Tambah Produk
    </a>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Produk</p>
        <h3 class="text-3xl md:text-4xl font-bold text-gray-900">0</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Stok Rendah</p>
        <h3 class="text-3xl md:text-4xl font-bold text-orange-600">0</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Produk Aktif</p>
        <h3 class="text-3xl md:text-4xl font-bold text-green-600">0</h3>
    </div>
</div>

<!-- Table Section -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    
    <!-- Search Bar -->
    <div class="p-4 md:p-6 border-b border-slate-200">
        <div class="flex flex-col md:flex-row md:items-end gap-4">
            <div class="flex-1">
                <input type="text" 
                       placeholder="Cari produk..." 
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
            </div>
            <select class="px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                <option>Semua Kategori</option>
                <option>Makanan</option>
                <option>Minuman</option>
                <option>Snack</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Produk</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Kategori</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">Stok</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">Status</th>
                    <th class="px-4 md:px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <tr>
                    <td colspan="7" class="px-4 md:px-6 py-12 text-center text-gray-500">
                        <p class="text-sm">Belum ada produk. <a href="{{ route('produk.create') }}" class="text-orange-600 font-medium hover:text-orange-700">Tambah produk baru</a></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

@endsection
