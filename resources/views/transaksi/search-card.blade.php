@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-4 md:p-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">🆔 Cari Kartu ID</h1>
            <p class="text-sm text-gray-600 mt-2">Pilih kartu untuk pembayaran</p>
        </div>

        <!-- Search Box -->
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-6">
            <div class="flex gap-2">
                <input type="text" 
                       id="searchCard" 
                       placeholder="Cari berdasarkan nama, nomor kartu, atau nomor ID..."
                       class="flex-1 px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm">
                <button onclick="searchCards()" 
                        class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all duration-200">
                    🔍 Cari
                </button>
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
                <div class="p-6 cursor-pointer" onclick="selectCard(${card.id})">
                    <!-- Card Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Nama Pemilik</p>
                            <p class="text-lg font-bold text-gray-900">${card.holder_name}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Username</p>
                            <p class="text-lg font-mono text-gray-900">${card.username}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">Saldo</p>
                            <p class="text-lg font-bold text-green-600">Rp${parseInt(card.saldo).toLocaleString('id-ID')}</p>
                        </div>
                    </div>

                    <!-- Card Number -->
                    <div class="p-3 bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg mb-4">
                        <p class="text-white text-sm font-mono">${maskCardNumber(card.barcode_data)}</p>
                    </div>

                    <!-- Card Details -->
                    <div class="grid grid-cols-2 gap-4 text-sm border-t pt-4">
                        <div>
                            <p class="text-gray-600 text-xs">Barcode</p>
                            <p class="font-semibold text-gray-900">${maskId(card.barcode_data)}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-xs">Status</p>
                            <p class="font-semibold ${card.status === 'active' ? 'text-green-600' : 'text-red-600'}">
                                ${card.status === 'active' ? '✓ Aktif' : '✗ Nonaktif'}
                            </p>
                        </div>
                    </div>

                    <!-- Select Button -->
                    <div class="mt-4 pt-4 border-t">
                        <button type="button" 
                                onclick="event.stopPropagation(); selectCard(${card.id})"
                                class="w-full px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all duration-200 text-sm">
                            ✓ Pilih Kartu Ini
                        </button>
                    </div>
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

    // Mask card number (show last 4 digits)
    function maskCardNumber(number) {
        const str = number.toString();
        const lastFour = str.slice(-4);
        return '•••• •••• •••• ' + lastFour;
    }

    // Mask ID number
    function maskId(id) {
        const str = id.toString();
        if (str.length <= 4) return str;
        const lastFour = str.slice(-4);
        return '••••••' + lastFour;
    }

    // Allow Enter to search
    document.getElementById('searchCard').addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            searchCards();
        }
    });
</script>
@endsection
