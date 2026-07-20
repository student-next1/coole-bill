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
        <h3 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $produks->total() }}</h3>
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
    
    <!-- Filter Bar -->
    <div class="p-4 md:p-6 border-b border-slate-200">
        <form method="GET" action="{{ route('produk.index') }}" class="flex flex-col md:flex-row md:items-end gap-4">
            <!-- Search -->
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Produk</label>
                <input type="text" 
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari berdasarkan nama atau kode..." 
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
            </div>
            
            <!-- Filter Kategori -->
            <div class="md:min-w-64">
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Kategori</label>
                <select name="kategori_id" 
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" @selected($kategori_id == $kat->id)>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2">
                <button type="submit" 
                        class="px-6 py-2 bg-orange-600 font-medium rounded-lg hover:bg-orange-700 transition-colors text-sm" style="color: #ffffff !important;">
                    Cari
                </button>
                @if(request('search') || request('kategori_id'))
                <a href="{{ route('produk.index') }}" 
                   class="px-4 py-2 font-medium rounded-lg hover:bg-slate-300 transition-colors text-sm text-center" style="background-color: #e2e8f0 !important; color: #1e293b !important;">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-16">Foto</th>
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
                        <!-- Foto Thumbnail -->
                        <td class="px-4 md:px-6 py-4">
                            @if($produk->foto)
                                <img src="{{ asset('storage/' . $produk->foto) }}" 
                                     alt="{{ $produk->nama_produk }}" 
                                     class="w-10 h-10 object-cover rounded-lg border border-slate-200">
                            @else
                                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center border border-slate-200">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 md:px-6 py-4 text-sm font-medium text-gray-900">{{ $produk->kode_produk }}</td>
                        <td class="px-4 md:px-6 py-4 text-sm text-gray-900">{{ $produk->nama_produk }}</td>
                        <td class="px-4 md:px-6 py-4 text-sm text-gray-600 hidden sm:table-cell">
                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                {{ $produk->kategori->nama_kategori ?? '-' }}
                            </span>
                        </td>
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
                        <td colspan="8" class="px-4 md:px-6 py-12 text-center text-gray-500">
                            <p class="text-sm">Tidak ada produk yang sesuai. <a href="{{ route('produk.create') }}" class="text-orange-600 font-medium hover:text-orange-700">Tambah produk baru</a></p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($produks->hasPages())
    <div class="px-4 md:px-6 py-4 border-t border-slate-200 bg-slate-50">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Pagination Info -->
            <div class="text-sm text-gray-600">
                Menampilkan <span class="font-semibold">{{ $produks->firstItem() }}</span> hingga 
                <span class="font-semibold">{{ $produks->lastItem() }}</span> dari 
                <span class="font-semibold">{{ $produks->total() }}</span> produk
            </div>

            <!-- Pagination Links -->
            <div class="flex justify-center md:justify-end">
                {{ $produks->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
    @endif

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
