@extends('layouts.app')

@section('title','Edit Produk')
@section('page-title','Edit Produk')

@section('content')

<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h3 class="text-2xl font-semibold text-gray-900">Edit Produk</h3>
        <p class="text-sm text-gray-600 mt-2">Perbarui informasi produk di bawah</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-8">
        <form action="{{ route('produk.update', $produk->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Kode Produk -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Kode Produk <span class="text-red-500">*</span></label>
                <input type="text" 
                       name="kode_produk" 
                       placeholder="Misal: PROD001"
                       value="{{ old('kode_produk', $produk->kode_produk) }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('kode_produk') border-red-500 @enderror">
                @error('kode_produk')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Produk -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" 
                       name="nama_produk" 
                       placeholder="Misal: Kopi Espresso"
                       value="{{ old('nama_produk', $produk->nama_produk) }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('nama_produk') border-red-500 @enderror">
                @error('nama_produk')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Kategori <span class="text-red-500">*</span></label>
                <div class="flex gap-2">
                    <select name="kategori_id" 
                            id="kategori_id"
                            class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('kategori_id') border-red-500 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" @selected($produk->kategori_id == $kat->id)>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                    <button type="button" 
                            onclick="openAddCategoryModal()"
                            class="px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 text-sm whitespace-nowrap">
                        + Baru
                    </button>
                </div>
                @error('kategori_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" 
                           name="harga" 
                           placeholder="0"
                           value="{{ old('harga', $produk->harga) }}"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('harga') border-red-500 @enderror"
                           min="0">
                    @error('harga')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Stok <span class="text-red-500">*</span></label>
                    <input type="number" 
                           name="stok" 
                           placeholder="0"
                           value="{{ old('stok', $produk->stok) }}"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('stok') border-red-500 @enderror"
                           min="0">
                    @error('stok')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Deskripsi</label>
                <textarea name="deskripsi" 
                          placeholder="Deskripsi produk (opsional)"
                          rows="4"
                          class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4 border-t border-slate-200">
                <a href="{{ route('produk.index') }}" 
                   class="flex-1 px-4 py-2 border border-slate-300 text-gray-900 font-medium rounded-lg hover:bg-slate-50 transition-colors text-center text-sm">
                    Batal
                </a>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 text-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div id="addCategoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg max-w-sm w-full">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-gray-900">Tambah Kategori Baru</h3>
        </div>
        <form id="addCategoryForm" class="p-6">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-900 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" 
                       id="nama_kategori_input"
                       placeholder="Misal: Minuman Panas"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-900 mb-2">Deskripsi (Opsional)</label>
                <input type="text" 
                       id="deskripsi_kategori_input"
                       placeholder="Deskripsi kategori"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" 
                        onclick="closeAddCategoryModal()"
                        class="flex-1 px-4 py-2 border border-slate-300 text-gray-900 font-medium rounded-lg hover:bg-slate-50 transition-colors text-sm">
                    Batal
                </button>
                <button type="button" 
                        onclick="submitCategory()"
                        class="flex-1 px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 text-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddCategoryModal() {
        document.getElementById('addCategoryModal').classList.remove('hidden');
    }

    function closeAddCategoryModal() {
        document.getElementById('addCategoryModal').classList.add('hidden');
        document.getElementById('nama_kategori_input').value = '';
        document.getElementById('deskripsi_kategori_input').value = '';
    }

    function submitCategory() {
        const nama_kategori = document.getElementById('nama_kategori_input').value.trim();
        const deskripsi = document.getElementById('deskripsi_kategori_input').value.trim();

        if (!nama_kategori) {
            alert('Nama kategori tidak boleh kosong');
            return;
        }

        fetch('{{ route('kategori.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({
                nama_kategori: nama_kategori,
                deskripsi: deskripsi
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload kategori dropdown
                fetch('{{ route('kategori.index') }}')
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const kategoris = Array.from(doc.querySelectorAll('select option')).map(opt => ({
                            id: opt.value,
                            nama: opt.textContent
                        }));
                        
                        const select = document.getElementById('kategori_id');
                        select.innerHTML = '<option value="">-- Pilih Kategori --</option>';
                        kategoris.forEach(kat => {
                            if (kat.id && kat.id !== '') {
                                const option = document.createElement('option');
                                option.value = kat.id;
                                option.textContent = kat.nama;
                                select.appendChild(option);
                            }
                        });
                    });
                
                closeAddCategoryModal();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('addCategoryModal').classList.contains('hidden')) {
            closeAddCategoryModal();
        }
    });
</script>

@endsection
