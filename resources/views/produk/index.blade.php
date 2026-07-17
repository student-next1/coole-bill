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
        <h3 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $produks->count() }}</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Stok Rendah</p>
        <h3 class="text-3xl md:text-4xl font-bold text-orange-600">{{ $produks->where('stok', '<', 10)->count() }}</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Nilai Stok</p>
        <h3 class="text-3xl md:text-4xl font-bold text-green-600">Rp{{ number_format($produks->sum(fn($p) => $p->harga * $p->stok), 0, ',', '.') }}</h3>
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
                @forelse($produks as $produk)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 md:px-6 py-4 text-sm font-medium text-gray-900">{{ $produk->kode_produk }}</td>
                        <td class="px-4 md:px-6 py-4 text-sm text-gray-900">{{ $produk->nama_produk }}</td>
                        <td class="px-4 md:px-6 py-4 text-sm text-gray-600 hidden sm:table-cell">{{ $produk->kategori->nama_kategori ?? '-' }}</td>
                        <td class="px-4 md:px-6 py-4 text-sm font-medium text-orange-600">Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td class="px-4 md:px-6 py-4 text-sm hidden md:table-cell">
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $produk->stok < 10 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                {{ $produk->stok }} unit
                            </span>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-sm hidden lg:table-cell">
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Aktif</span>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('produk.edit', $produk->id) }}" 
                                   class="text-blue-600 hover:text-blue-700 text-xs md:text-sm font-medium">Edit</a>
                                <button type="button" 
                                        onclick="confirmDelete('{{ route('produk.destroy', $produk->id) }}')"
                                        class="text-red-600 hover:text-red-700 text-xs md:text-sm font-medium">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 md:px-6 py-12 text-center text-gray-500">
                            <p class="text-sm">Belum ada produk. <a href="{{ route('produk.create') }}" class="text-orange-600 font-medium hover:text-orange-700">Tambah produk baru</a></p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
    function confirmDelete(url) {
        if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
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
