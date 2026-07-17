@extends('layouts.app')

@section('title','Produk')
@section('page-title','Produk')

@section('content')

<!-- Header Section -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h3 class="text-lg font-semibold text-gray-900">Daftar Produk</h3>
        <p class="text-sm text-gray-600 mt-1">Kelola semua produk toko Anda</p>
    </div>
    <a href="{{ route('produk.create') }}" 
       class="px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200">
        + Tambah Produk
    </a>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Produk</p>
        <h3 class="text-3xl font-bold text-gray-900">120</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Stok Rendah</p>
        <h3 class="text-3xl font-bold text-orange-600">8</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Produk Aktif</p>
        <h3 class="text-3xl font-bold text-green-600">112</h3>
    </div>
</div>

<!-- Table Section -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    
    <!-- Search Bar -->
    <div class="p-6 border-b border-slate-200">
        <div class="flex items-center gap-4">
            <div class="flex-1">
                <input type="text" 
                       placeholder="Cari produk..." 
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>
            <select class="px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                <option>Semua Kategori</option>
                <option>Makanan</option>
                <option>Minuman</option>
                <option>Snack</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <tr class="hover:bg-slate-50 transition-colors duration-150">
                    <td class="px-6 py-4 text-sm text-gray-900">PRD001</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">Nasi Goreng</div>
                        <div class="text-sm text-gray-500">Nasi goreng spesial</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">Makanan</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">Rp15.000</td>
                    <td class="px-6 py-4 text-sm text-gray-600">50</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Aktif</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button class="px-3 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-150">Edit</button>
                            <button class="px-3 py-1 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-150">Hapus</button>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors duration-150">
                    <td class="px-6 py-4 text-sm text-gray-900">PRD002</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">Es Teh Manis</div>
                        <div class="text-sm text-gray-500">Teh manis dingin</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">Minuman</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">Rp5.000</td>
                    <td class="px-6 py-4 text-sm text-orange-600 font-medium">5</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Aktif</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button class="px-3 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-150">Edit</button>
                            <button class="px-3 py-1 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-150">Hapus</button>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors duration-150">
                    <td class="px-6 py-4 text-sm text-gray-900">PRD003</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">Mie Ayam</div>
                        <div class="text-sm text-gray-500">Mie ayam bakso</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">Makanan</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">Rp12.000</td>
                    <td class="px-6 py-4 text-sm text-gray-600">30</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">Nonaktif</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button class="px-3 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-150">Edit</button>
                            <button class="px-3 py-1 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-150">Hapus</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-slate-200 flex items-center justify-between">
        <p class="text-sm text-gray-600">Menampilkan 1-3 dari 120 produk</p>
        <div class="flex items-center gap-2">
            <button class="px-4 py-2 text-sm border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-150">Previous</button>
            <button class="px-4 py-2 text-sm bg-orange-600 text-white rounded-lg">1</button>
            <button class="px-4 py-2 text-sm border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-150">2</button>
            <button class="px-4 py-2 text-sm border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-150">3</button>
            <button class="px-4 py-2 text-sm border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-150">Next</button>
        </div>
    </div>

</div>

@endsection
