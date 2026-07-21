@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-4 md:p-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Pilih Kartu Pembayaran</h1>
            <p class="text-sm text-gray-600 mt-2">Scan barcode atau cari kartu yang ingin digunakan untuk pembayaran</p>
            
            <!-- Total Payment Info -->
            <div class="mt-4 p-4 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl text-white">
                <p class="text-sm opacity-90">Total Pembayaran:</p>
                <p class="text-3xl font-bold">Rp{{ number_format(session('total', 0), 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Search Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-6">
            <div class="space-y-4">
                <!-- Barcode Scanner Mode -->
                <div class="flex items-center gap-3 mb-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="barcodeMode" class="w-5 h-5 text-orange-600 rounded focus:ring-orange-500">
                        <span class="text-sm font-semibold text-gray-700">Mode Scan Barcode (tekan Enter untuk scan cepat)</span>
                    </label>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Kartu</label>
                    <div class="flex gap-2">
                        <input type="text" 
                               id="searchInput" 
                               placeholder="Scan barcode atau ketik username / ID kartu..."
                               class="flex-1 px-4 py-3 border-2 border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base font-mono"
                               autocomplete="off"
                               autofocus>
                        <button onclick="searchCards()" 
                                class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all duration-200">
                            Cari
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Tekan Enter untuk search otomatis</p>
                </div>
                
                <!-- Quick Tips -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <p class="text-xs text-blue-900 font-semibold mb-1">Tips Pencarian:</p>
                    <ul class="text-xs text-blue-800 space-y-1">
                        <li>Scan barcode kartu langsung dengan scanner</li>
                        <li>Ketik username (contoh: user123)</li>
                        <li>Ketik ID kartu atau nama pemilik</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div id="loadingIndicator" class="hidden bg-white rounded-xl shadow p-6 text-center mb-6">
            <div class="flex items-center justify-center gap-3">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-orange-600"></div>
                <p class="text-gray-600">Mencari kartu...</p>
            </div>
        </div>

        <!-- Search Results -->
        <div id="cardsList" class="space-y-3 mb-6">
            <div class="bg-white rounded-xl shadow p-6 text-center text-gray-600">
                <p class="text-sm">Mulai dengan scan barcode atau mengetik username / ID kartu di atas</p>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('transaksi.create') }}" 
               class="inline-block px-6 py-3 bg-gray-200 text-gray-900 font-semibold rounded-lg hover:bg-gray-300 transition-all duration-200">
                Kembali
            </a>
        </div>
    </div>
</div>

<script>
    const totalPayment = {{ session('total', 0) }};
    
    // Search cards via AJAX
    async function searchCards() {
        const query = document.getElementById('searchInput').value.trim();
        
        if (!query || query.length < 1) {
            alert('Masukkan barcode, username atau ID kartu!');
            return;
        }

        // Show loading
        document.getElementById('loadingIndicator').classList.remove('hidden');
        document.getElementById('cardsList').classList.add('opacity-50');

        try {
            const response = await fetch('{{ route("transaksi.find-card") }}?search=' + encodeURIComponent(query));
            const data = await response.json();

            // Hide loading
            document.getElementById('loadingIndicator').classList.add('hidden');
            document.getElementById('cardsList').classList.remove('opacity-50');

            if (data.success && data.cards.length > 0) {
                displayCards(data.cards);
            } else {
                displayNoResults(query);
            }
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('loadingIndicator').classList.add('hidden');
            document.getElementById('cardsList').classList.remove('opacity-50');
            alert('Terjadi kesalahan saat mencari kartu');
        }
    }

    // Display search results
    function displayCards(cards) {
        const cardsList = document.getElementById('cardsList');
        
        cardsList.innerHTML = cards.map(card => {
            const hasEnoughBalance = parseFloat(card.saldo) >= totalPayment;
            const isActive = card.status === 'active';
            const canUse = hasEnoughBalance && isActive;
            
            return `
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-200 ${!canUse ? 'opacity-75' : ''}">
                <div class="p-6">
                    <!-- Validation Status -->
                    ${!canUse ? `
                    <div class="mb-4 p-3 ${!isActive ? 'bg-red-100 border border-red-300' : 'bg-yellow-100 border border-yellow-300'} rounded-lg">
                        <p class="text-sm font-bold ${!isActive ? 'text-red-800' : 'text-yellow-800'}">
                            ${!isActive ? 'Kartu Tidak Aktif' : 'Saldo Tidak Mencukupi'}
                        </p>
                        ${!hasEnoughBalance ? `
                        <p class="text-xs ${!isActive ? 'text-red-700' : 'text-yellow-700'} mt-1">
                            Kurang: Rp${(totalPayment - parseFloat(card.saldo)).toLocaleString('id-ID')}
                        </p>
                        ` : ''}
                    </div>
                    ` : ''}
                    
                    <!-- Card Header Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 pb-4 border-b-2 border-gray-200">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">👤 Nama Pemilik</p>
                            <p class="text-lg font-bold text-gray-900">${card.holder_name || '-'}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">📧 Username</p>
                            <p class="text-lg font-mono text-blue-600 font-bold">${card.username}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase mb-1">💰 Saldo</p>
                            <p class="text-lg font-bold ${hasEnoughBalance ? 'text-green-600' : 'text-red-600'}">
                                Rp${parseInt(card.saldo).toLocaleString('id-ID')}
                            </p>
                        </div>
                    </div>

                    <!-- Card Code Display -->
                    <div class="p-4 bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg mb-4">
                        <p class="text-white text-xs font-semibold opacity-75">CARD ID</p>
                        <p class="text-white text-sm font-mono font-bold break-all">${card.card_code || 'N/A'}</p>
                    </div>

                    <!-- Barcode Display -->
                    <div class="grid grid-cols-2 gap-4 text-sm mb-4 pb-4 border-b-2 border-gray-200">
                        <div>
                            <p class="text-gray-600 text-xs font-semibold uppercase mb-1">🔐 Barcode</p>
                            <p class="font-mono text-gray-900 text-xs break-all">${maskValue(card.barcode_data)}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-xs font-semibold uppercase mb-1">✓ Status</p>
                            <p class="font-semibold ${card.status === 'active' ? 'text-green-600' : 'text-red-600'}">
                                ${card.status === 'active' ? 'Aktif' : 'Nonaktif'}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Balance Validation -->
                    <div class="mb-4 p-3 ${hasEnoughBalance ? 'bg-green-100 border border-green-300' : 'bg-red-100 border border-red-300'} rounded-lg">
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="font-semibold ${hasEnoughBalance ? 'text-green-800' : 'text-red-800'}">Total Belanja:</span>
                            <span class="font-bold ${hasEnoughBalance ? 'text-green-900' : 'text-red-900'}">Rp${totalPayment.toLocaleString('id-ID')}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-semibold ${hasEnoughBalance ? 'text-green-800' : 'text-red-800'}">Saldo Tersisa:</span>
                            <span class="font-bold ${hasEnoughBalance ? 'text-green-900' : 'text-red-900'}">
                                Rp${(parseFloat(card.saldo) - totalPayment).toLocaleString('id-ID')}
                            </span>
                        </div>
                    </div>

                    <!-- Select Button -->
                    <button type="button" 
                            onclick="selectCard(${card.id}, ${hasEnoughBalance}, ${isActive})"
                            ${!canUse ? 'disabled' : ''}
                            class="w-full px-4 py-3 ${canUse ? 'bg-green-600 hover:bg-green-700 active:bg-green-800' : 'bg-gray-400 cursor-not-allowed'} text-white font-bold rounded-lg transition-all duration-200">
                        ${canUse ? 'Gunakan Kartu Ini' : 'Tidak Dapat Digunakan'}
                    </button>
                </div>
            </div>
        `}).join('');
    }

    // Display no results
    function displayNoResults(query) {
        document.getElementById('cardsList').innerHTML = `
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <p class="text-gray-600 text-sm mb-2">Kartu tidak ditemukan</p>
                <p class="text-gray-500 text-xs">Pencarian: "<strong>${query}</strong>"</p>
                <p class="text-gray-500 text-xs mt-2">Coba cari dengan barcode, username atau ID kartu lain</p>
            </div>
        `;
    }

    // Select card and proceed to invoice
    function selectCard(cardId, hasEnoughBalance, isActive) {
        if (!hasEnoughBalance) {
            alert('Saldo kartu tidak mencukupi!\n\nSilakan pilih kartu lain atau lakukan top-up terlebih dahulu.');
            return;
        }
        
        if (!isActive) {
            alert('Kartu tidak aktif!\n\nSilakan pilih kartu lain.');
            return;
        }
        
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

    // Mask sensitive data
    function maskValue(value) {
        const str = value.toString();
        if (str.length <= 6) return str;
        return str.substring(0, 3) + '...' + str.substring(str.length - 3);
    }

    // Allow Enter to search
    document.getElementById('searchInput').addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            searchCards();
        }
    });
    
    // Barcode mode: auto-submit after 500ms of no typing
    let barcodeTimeout;
    document.getElementById('searchInput').addEventListener('input', (e) => {
        const barcodeMode = document.getElementById('barcodeMode').checked;
        
        if (barcodeMode && e.target.value.length > 3) {
            clearTimeout(barcodeTimeout);
            barcodeTimeout = setTimeout(() => {
                searchCards();
            }, 500);
        }
    });

    // Auto-focus on search input
    window.addEventListener('load', () => {
        document.getElementById('searchInput').focus();
    });
</script>
@endsection

