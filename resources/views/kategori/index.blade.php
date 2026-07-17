@extends('layouts.app')

@section('title','Kategori')
@section('page-title','Kategori')

@section('content')

<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
        <h3 class="text-lg md:text-xl font-semibold text-gray-900">Daftar Kategori</h3>
        <p class="text-sm text-gray-600 mt-1">Kelola kategori produk Anda</p>
    </div>
    <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" 
            class="inline-block px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 text-center text-sm md:text-base">
        + Tambah Kategori
    </button>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Kategori</p>
        <h3 class="text-3xl md:text-4xl font-bold text-gray-900">0</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Kategori Aktif</p>
        <h3 class="text-3xl md:text-4xl font-bold text-green-600">0</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Kategori Nonaktif</p>
        <h3 class="text-3xl md:text-4xl font-bold text-gray-600">0</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Produk</p>
        <h3 class="text-3xl md:text-4xl font-bold text-orange-600">0</h3>
    </div>
</div>

<!-- Grid Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-orange-300 transition-all duration-200">
        <div class="text-center py-12 text-gray-500">
            <p class="text-sm">Belum ada kategori. <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="text-orange-600 font-medium hover:text-orange-700">Tambah kategori baru</button></p>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div id="modalTambah" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg md:text-xl font-bold text-gray-900">Tambah Kategori</h3>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm" placeholder="Masukkan nama kategori">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm" rows="3" placeholder="Masukkan deskripsi"></textarea>
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
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" 
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
