@extends('layouts.app')

@section('title','Tambah Kategori')
@section('page-title','Tambah Kategori')

@section('content')

<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h3 class="text-2xl font-semibold text-gray-900">Tambah Kategori Baru</h3>
        <p class="text-sm text-gray-600 mt-2">Isi form di bawah untuk menambahkan kategori produk baru</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-8">
        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf

            <!-- Nama Kategori -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" 
                       name="nama_kategori" 
                       placeholder="Misal: Minuman Panas"
                       value="{{ old('nama_kategori') }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('nama_kategori') border-red-500 @enderror">
                @error('nama_kategori')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Deskripsi</label>
                <textarea name="deskripsi" 
                          placeholder="Deskripsi kategori (opsional)"
                          rows="4"
                          class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">{{ old('deskripsi') }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4 border-t border-slate-200">
                <a href="{{ route('kategori.index') }}" 
                   class="flex-1 px-4 py-2 border border-slate-300 text-gray-900 font-medium rounded-lg hover:bg-slate-50 transition-colors text-center text-sm">
                    Batal
                </a>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 text-sm">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
