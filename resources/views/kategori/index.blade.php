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
    <a href="{{ route('kategori.create') }}" 
       class="inline-block px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 text-center text-sm md:text-base">
        + Tambah Kategori
    </a>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Kategori</p>
        <h3 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $kategoris->count() }}</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Kategori Aktif</p>
        <h3 class="text-3xl md:text-4xl font-bold text-green-600">{{ $kategoris->count() }}</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Produk</p>
        <h3 class="text-3xl md:text-4xl font-bold text-orange-600">{{ $kategoris->sum('produks_count') }}</h3>
    </div>
</div>

<!-- Grid Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
    @forelse($kategoris as $kategori)
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-orange-300 transition-all duration-200">
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <h4 class="text-lg font-semibold text-gray-900">{{ $kategori->nama_kategori }}</h4>
                    <p class="text-xs text-gray-500 mt-1">{{ $kategori->produks_count }} produk</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-4">{{ $kategori->deskripsi ?? 'Tanpa deskripsi' }}</p>
            <div class="flex gap-2 pt-4 border-t border-slate-200">
                <a href="{{ route('kategori.edit', $kategori->id) }}" 
                   class="flex-1 px-3 py-2 text-sm font-medium text-blue-600 hover:bg-blue-50 rounded-lg transition-colors text-center">
                    Edit
                </a>
                <button type="button" 
                        onclick="confirmDelete('{{ route('kategori.destroy', $kategori->id) }}')"
                        class="flex-1 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                    Hapus
                </button>
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="bg-slate-50 rounded-xl border border-slate-200 p-12 text-center text-gray-500">
                <p class="text-sm">Belum ada kategori. <a href="{{ route('kategori.create') }}" class="text-orange-600 font-medium hover:text-orange-700">Tambah kategori baru</a></p>
            </div>
        </div>
    @endforelse
</div>

<script>
    function confirmDelete(url) {
        if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

@endsection
