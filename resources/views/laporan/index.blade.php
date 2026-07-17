@extends('layouts.app')

@section('title','Laporan')
@section('page-title','Laporan')

@section('content')

<!-- Header Section -->
<div class="mb-8">
    <h3 class="text-lg md:text-xl font-semibold text-gray-900">Laporan Penjualan</h3>
    <p class="text-sm text-gray-600 mt-1">Analisis dan laporan bisnis Anda</p>
</div>

<!-- Period Selection -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6 mb-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <label class="block text-xs md:text-sm font-medium text-gray-700 mb-2">Periode</label>
            <select class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                <option>Hari Ini</option>
                <option>Minggu Ini</option>
                <option>Bulan Ini</option>
                <option>Tahun Ini</option>
                <option>Custom</option>
            </select>
        </div>
        <div>
            <label class="block text-xs md:text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
            <input type="date" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
        </div>
        <div>
            <label class="block text-xs md:text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
            <input type="date" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
        </div>
        <div class="flex items-end gap-2">
            <button class="flex-1 px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white rounded-lg hover:shadow-lg transition-all duration-150 text-sm">
                Tampilkan
            </button>
            <button class="px-4 py-2 border border-slate-300 text-gray-700 rounded-lg hover:bg-slate-50 transition-colors duration-150 text-sm">
                Export
            </button>
        </div>
    </div>
</div>

<!-- Overview Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
    
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Penjualan</p>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">Rp0</h3>
        <p class="text-xs text-gray-500 mt-2">Belum ada data</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Transaksi</p>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">0</h3>
        <p class="text-xs text-gray-500 mt-2">Belum ada data</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Rata-rata</p>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">Rp0</h3>
        <p class="text-xs text-gray-500 mt-2">Per transaksi</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Produk Terjual</p>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">0</h3>
        <p class="text-xs text-gray-500 mt-2">Total item</p>
    </div>

</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    
    <!-- Sales Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Grafik Penjualan</h3>
        <div class="h-64 flex items-center justify-center bg-slate-50 rounded-lg">
            <p class="text-gray-500 text-sm">Data tidak tersedia</p>
        </div>
    </div>

    <!-- Category Distribution -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Kategori</h3>
        <div class="h-64 flex items-center justify-center bg-slate-50 rounded-lg">
            <p class="text-gray-500 text-sm">Data tidak tersedia</p>
        </div>
    </div>

</div>

<!-- Top Products -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Best Selling Products -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Produk Terlaris</h3>
        <div class="py-12 text-center text-gray-500">
            <p class="text-sm">Belum ada data transaksi</p>
        </div>
    </div>

    <!-- Payment Methods -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Metode Pembayaran</h3>
        <div class="py-12 text-center text-gray-500">
            <p class="text-sm">Belum ada data transaksi</p>
        </div>
    </div>

</div>

@endsection
