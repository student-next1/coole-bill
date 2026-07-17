@extends('layouts.app')

@section('title','Transaksi')
@section('page-title','Transaksi')

@section('content')

<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
        <h3 class="text-lg md:text-xl font-semibold text-gray-900">Riwayat Transaksi</h3>
        <p class="text-sm text-gray-600 mt-1">Kelola dan pantau semua transaksi</p>
    </div>
    <a href="{{ route('transaksi.create') }}" 
       class="inline-block px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 text-center text-sm md:text-base">
        + Transaksi Baru
    </a>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Transaksi Hari Ini</p>
        <h3 class="text-3xl md:text-4xl font-bold text-gray-900">0</h3>
        <p class="text-xs text-gray-500 mt-2">Belum ada transaksi</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Pendapatan Hari Ini</p>
        <h3 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-orange-600 to-orange-500 bg-clip-text text-transparent">Rp0</h3>
        <p class="text-xs text-gray-500 mt-2">Hari ini</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Rata-rata Transaksi</p>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-900">Rp0</h3>
        <p class="text-xs text-gray-500 mt-2">Per transaksi</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Transaksi Sukses</p>
        <h3 class="text-3xl md:text-4xl font-bold text-green-600">0</h3>
        <p class="text-xs text-gray-500 mt-2">Semua berhasil</p>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6 mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <label class="block text-xs md:text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
            <input type="date" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
        </div>
        <div>
            <label class="block text-xs md:text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
            <input type="date" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
        </div>
        <div>
            <label class="block text-xs md:text-sm font-medium text-gray-700 mb-2">Status</label>
            <select class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                <option>Semua Status</option>
                <option>Sukses</option>
                <option>Pending</option>
                <option>Batal</option>
            </select>
        </div>
        <div class="flex items-end">
            <button class="w-full px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white rounded-lg hover:shadow-lg transition-all duration-150 text-sm md:text-base">
                Filter
            </button>
        </div>
    </div>
</div>

<!-- Table Section -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID Transaksi</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Tanggal</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">Kasir</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-4 md:px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <tr>
                    <td colspan="6" class="px-4 md:px-6 py-12 text-center text-gray-500">
                        <p class="text-sm">Belum ada transaksi. <a href="{{ route('transaksi.create') }}" class="text-orange-600 font-medium hover:text-orange-700">Buat transaksi baru</a></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

@endsection
