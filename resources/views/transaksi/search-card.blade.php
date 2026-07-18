@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-4 md:p-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">🆔 Pilih Kartu Pembayaran</h1>
            <p class="text-sm text-gray-600 mt-2">Cari berdasarkan username atau ID kartu</p>
        </div>

        <!-- Search Box -->
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-6">
            <div class="space-y-3">
                <div class="flex gap-2">
                    <input type="text" 
                           id="searchCard" 
                           placeholder="Ketik username atau ID kartu..."
                           class="flex-1 px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm"
                           autocomplete="off">
                    <button onclick="searchCards()" 
                            class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all duration-200">
                        🔍 Cari
                    </button>
                </div>
                <p class="text-xs text-gray-500">💡 Tips: Cari dengan username (contoh: user123) atau ID kartu (contoh: CARD-xxx)</p>
            </div>
        </div>

        <!-- Cards List -->
        <div id="cardsList" class="space-y-4">
            <!-- Loading indicator -->
            <div class="bg-white rounded-xl shadow p-6 text-center text-gray-600">
                <p class="text-sm">Ketik untuk mencari kartu...</p>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('transaksi.create') }}" 
               class="inline-block px-6 py-3 bg-gray-200 text-gray-900 font-semibold rounded-lg hover:bg-gray-300 transition-all duration-200">
                ↩️ Kembali
            </a>
        </div>
    </div>
</div>

<script>
    // Search cards via AJAX
    async function searchCards() {
        const query = document.getElementById('searchCard').value.trim();
        
        if (!query || query.length < 1) {
            alert('Masukkan kata kunci pencarian!');
            return;
        }

        try {
            const response = await fetch('{{ route("transaksi.find-card") }}?search=' + encodeURIComponent(query));
            const data = await response.json();

            if (data.success) {
                displayCards(data.cards);
            } else {
                alert('Error: ' + data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mencari kartu');
        }
    }

    // Display search results
    function displayCards(cards) {
        const cardsList = document.getElementById('cardsList');
        
        if (cards.length === 0) {
            cardsList.innerHTML = `
                <div class="bg-white rounded-xl shadow p-6 text-center">
                    <p class="text-gray-600 text-sm">❌ Kartu tidak ditemukan</p>
                </div>
            `;
            return;
        }

        cardsList.innerHTML = cards.map(card => `
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-200">
                <div class="p-6">
                    <!-- Card Header -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 pb-4 border-b-2 border-gray-200">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Nama Pemilik</p>
                            <p class="text-lg font-bold text-gray-900">${card.holder_name || '-'}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Username</p>
                            <p class="text-lg font-mono text-blue-600 font-bold">${card.username}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Saldo</p>
                            <p class="text-lg font-bold text-green-600">Rp${parseInt(card.saldo).toLocaleString('id-ID')}</p>
                        </div>
                    </div>

                    <!-- Card Code / ID -->
                    <div class="p-4 bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg mb-4">
                        <p class="text-white text-xs font-semibold opacity-75">KARTU ID</p>
                        <p class="text-white text-sm font-mono font-bold break-all">${card.card_code}</p>
                    </div>

                    <!-- Barcode -->
                    <div class="grid grid-cols-2 gap-4 text-sm mb-4 pb-4 border-b-2 border-gray-200">
                        <div>
                            <p class="text-gray-600 text-xs font-semibold uppercase mb-1">Barcode</p>
                            <p class="font-mono text-gray-900 text-xs break-all">${maskId(card.barcode_data)}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-xs font-semibold uppercase mb-1">Status</p>
                            <p class="font-semibold ${card.status === 'active' ? 'text-green-600' : 'text-red-600'}">
                                ${card.status === 'active' ? '✓ Aktif' : '✗ Nonaktif'}
                            </p>
                        </div>
                    </div>

                    <!-- Select Button -->
                    <button type="button" 
                            onclick="selectCard(${card.id})"
                            class="w-full px-4 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 active:bg-green-800 transition-all duration-200">
                        ✓ Gunakan Kartu Ini
                    </button>
                </div>
            </div>
        `).join('');
    }

    // Select card and proceed to invoice
    function selectCard(cardId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("transaksi.select-card") }}';
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
        
        form.innerHTML = `
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="card_id" value="${cardId}">
        `;
        
        document.body.appendChild(form);
        form.submit();
    }

    // Mask ID number
    function maskId(id) {
        const str = id.toString();
        if (str.length <= 6) return str;
        return str.substring(0, 3) + '...' + str.substring(str.length - 3);
    }

    // Allow Enter to search
    document.getElementById('searchCard').addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            searchCards();
        }
    });
</script>
@endsection
