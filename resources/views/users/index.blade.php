@extends('layouts.app')

@section('title','Kelola User')
@section('page-title','Kelola User')

@section('content')

<!-- Header Section -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h3 class="text-lg font-semibold text-gray-900">Daftar User</h3>
        <p class="text-sm text-gray-600 mt-1">Kelola akses dan pengguna sistem</p>
    </div>
    <button onclick="document.getElementById('modalTambahUser').classList.remove('hidden')" 
            class="px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200">
        + Tambah User
    </button>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total User</p>
        <h3 class="text-3xl font-bold text-gray-900">15</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Admin</p>
        <h3 class="text-3xl font-bold text-purple-600">3</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Kasir</p>
        <h3 class="text-3xl font-bold text-blue-600">12</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">User Aktif</p>
        <h3 class="text-3xl font-bold text-green-600">14</h3>
    </div>
</div>

<!-- Table Section -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    
    <!-- Search Bar -->
    <div class="p-6 border-b border-slate-200">
        <div class="flex items-center gap-4">
            <div class="flex-1">
                <input type="text" 
                       placeholder="Cari user..." 
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>
            <select class="px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                <option>Semua Role</option>
                <option>Admin</option>
                <option>Kasir</option>
            </select>
            <select class="px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                <option>Semua Status</option>
                <option>Aktif</option>
                <option>Nonaktif</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Terdaftar</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <tr class="hover:bg-slate-50 transition-colors duration-150">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold">
                                A
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">Admin User</div>
                                <div class="text-sm text-gray-500">ID: USR001</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">admin@coolbill.com</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold text-purple-700 bg-purple-100 rounded-full">Admin</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">12 Jan 2024</td>
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
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold">
                                B
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">Budi Santoso</div>
                                <div class="text-sm text-gray-500">ID: USR002</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">budi@coolbill.com</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">Kasir</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">15 Feb 2024</td>
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
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold">
                                S
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">Siti Nurhaliza</div>
                                <div class="text-sm text-gray-500">ID: USR003</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">siti@coolbill.com</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">Kasir</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">20 Mar 2024</td>
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
        <p class="text-sm text-gray-600">Menampilkan 1-3 dari 15 user</p>
        <div class="flex items-center gap-2">
            <button class="px-4 py-2 text-sm border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-150">Previous</button>
            <button class="px-4 py-2 text-sm bg-orange-600 text-white rounded-lg">1</button>
            <button class="px-4 py-2 text-sm border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-150">2</button>
            <button class="px-4 py-2 text-sm border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-150">Next</button>
        </div>
    </div>

</div>

<!-- Modal Tambah User -->
<div id="modalTambahUser" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-xl font-bold text-gray-900">Tambah User Baru</h3>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Masukkan nama lengkap">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="user@email.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="••••••••">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                <select class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option>Kasir</option>
                    <option>Admin</option>
                </select>
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
            <button onclick="document.getElementById('modalTambahUser').classList.add('hidden')" 
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
