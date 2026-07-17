@extends('layouts.app')

@section('title','Kelola User')
@section('page-title','Kelola User')

@section('content')

<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
        <h3 class="text-lg md:text-xl font-semibold text-gray-900">Daftar User</h3>
        <p class="text-sm text-gray-600 mt-1">Kelola akses dan pengguna sistem</p>
    </div>
    <button onclick="document.getElementById('modalTambahUser').classList.remove('hidden')" 
            class="inline-block px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 text-center text-sm md:text-base">
        + Tambah User
    </button>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total User</p>
        <h3 class="text-3xl md:text-4xl font-bold text-gray-900">0</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Admin</p>
        <h3 class="text-3xl md:text-4xl font-bold text-purple-600">0</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Kasir</p>
        <h3 class="text-3xl md:text-4xl font-bold text-blue-600">0</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">User Aktif</p>
        <h3 class="text-3xl md:text-4xl font-bold text-green-600">0</h3>
    </div>
</div>

<!-- Table Section -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    
    <!-- Search Bar -->
    <div class="p-4 md:p-6 border-b border-slate-200">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" 
                       placeholder="Cari user..." 
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
            </div>
            <select class="px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                <option>Semua Role</option>
                <option>Admin</option>
                <option>Kasir</option>
            </select>
            <select class="px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                <option>Semua Status</option>
                <option>Aktif</option>
                <option>Nonaktif</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Email</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">Terdaftar</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-4 md:px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <tr>
                    <td colspan="6" class="px-4 md:px-6 py-12 text-center text-gray-500">
                        <p class="text-sm">Belum ada user. <button onclick="document.getElementById('modalTambahUser').classList.remove('hidden')" class="text-orange-600 font-medium hover:text-orange-700">Tambah user baru</button></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<!-- Modal Tambah User -->
<div id="modalTambahUser" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg md:text-xl font-bold text-gray-900">Tambah User Baru</h3>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm" placeholder="Masukkan nama lengkap">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm" placeholder="user@email.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm" placeholder="••••••••">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                <select class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                    <option>Kasir</option>
                    <option>Admin</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                    <option>Aktif</option>
                    <option>Nonaktif</option>
                </select>
            </div>
        </div>
        <div class="p-6 border-t border-slate-200 flex items-center gap-3">
            <button onclick="document.getElementById('modalTambahUser').classList.add('hidden')" 
                    class="flex-1 px-4 py-2 border border-slate-300 text-gray-700 rounded-lg hover:bg-slate-50 transition-colors duration-150 text-sm">
                Batal
            </button>
            <button class="flex-1 px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white rounded-lg hover:shadow-lg transition-all duration-150 text-sm">
                Simpan
            </button>
        </div>
    </div>
</div>

@endsection
