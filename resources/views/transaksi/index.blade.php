@extends('layouts.app')

@section('title','Transaksi')
@section('page-title','Transaksi')

@section('content')

<!-- Header Section -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h3 class="text-lg font-semibold text-gray-900">Riwayat Transaksi</h3>
        <p class="text-sm text-gray-600 mt-1">Kelola dan pantau semua transaksi</p>
    </div>
    <a href="{{ route('transaksi.create') }}" 
       class="px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200">
        + Transaksi Baru
    </a>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Transaksi Hari Ini</p>
        <h3 class="text-3xl font-bold text-gray-900">25</h3>
        <p class="text-xs text-green-600 font-medium mt-2">↑ 15% dari kemarin</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Pendapatan Hari Ini</p>
        <h3 class="text-2xl font-bold bg-gradient-to-r from-orange-600 to-orange-500 bg-clip-text text-transparent">Rp2.5M</h3>
        <p class="text-xs text-green-600 font-medium mt-2">↑ 12% dari kemarin</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Rata-rata Transaksi</p>
        <h3 class="text-2xl font-bold text-gray-900">Rp100K</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Transaksi Sukses</p>
        <h3 class="text-3xl font-bold text-green-600">24</h3>
        <p class="text-xs text-gray-500 mt-2">1 pending</p>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
            <input type="date" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
            <input type="date" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                <option>Semua Status</option>
                <option>Sukses</option>
                <option>Pending</option>
                <option>Batal</option>
            </select>
        </div>
        <div class="flex items-end">
            <button class="w-full px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white rounded-lg hover:shadow-lg transition-all duration-150">
                Filter
            </button>
        </div>
    </div>
</div>

<!-- Table Section -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID Transaksi</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kasir</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Items</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pembayaran</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <tr class="hover:bg-slate-50 transition-colors duration-150">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">TRX001</td>
                    <td class="px-6 py-4 text-sm text-gray-600">17 Jul 2026, 14:30</td>
                    <td class="px-6 py-4 text-sm text-gray-600">Admin User</td>
                    <td class="px-6 py-4 text-sm text-gray-600">3 items</td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp45.000</td>
                    <td class="px-6 py-4 text-sm text-gray-600">Tunai</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Sukses</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button class="px-3 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-150">Detail</button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors duration-150">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">TRX002</td>
                    <td class="px-6 py-4 text-sm text-gray-600">17 Jul 2026, 14:15</td>
                    <td class="px-6 py-4 text-sm text-gray-600">Admin User</td>
                    <td class="px-6 py-4 text-sm text-gray-600">5 items</td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp125.000</td>
                    <td class="px-6 py-4 text-sm text-gray-600">Transfer</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Sukses</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button class="px-3 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-150">Detail</button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors duration-150">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">TRX003</td>
                    <td class="px-6 py-4 text-sm text-gray-600">17 Jul 2026, 14:00</td>
                    <td class="px-6 py-4 text-sm text-gray-600">Admin User</td>
                    <td class="px-6 py-4 text-sm text-gray-600">2 items</td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp30.000</td>
                    <td class="px-6 py-4 text-sm text-gray-600">Tunai</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">Pending</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button class="px-3 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-150">Detail</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-slate-200 flex items-center justify-between">
        <p class="text-sm text-gray-600">Menampilkan 1-3 dari 25 transaksi</p>
        <div class="flex items-center gap-2">
            <button class="px-4 py-2 text-sm border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-150">Previous</button>
            <button class="px-4 py-2 text-sm bg-orange-600 text-white rounded-lg">1</button>
            <button class="px-4 py-2 text-sm border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-150">2</button>
            <button class="px-4 py-2 text-sm border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-150">Next</button>
        </div>
    </div>

</div>

@endsection
