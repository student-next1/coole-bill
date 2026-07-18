@extends('layouts.app')

@section('title','Kartu Pembayaran')
@section('page-title','Kartu Pembayaran')

@section('content')

<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
        <h3 class="text-lg md:text-xl font-semibold text-gray-900">Kelola Kartu Pembayaran</h3>
        <p class="text-sm text-gray-600 mt-1">Lihat, buat, dan kelola kartu pembayaran pelanggan</p>
    </div>
    <a href="{{ route('payment-cards.create') }}" 
       class="inline-block px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 text-center text-sm md:text-base">
        + Buat Kartu Baru
    </a>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Kartu</p>
        <h3 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $stats['total_cards'] }}</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Kartu Aktif</p>
        <h3 class="text-3xl md:text-4xl font-bold text-green-600">{{ $stats['active_cards'] }}</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Saldo</p>
        <h3 class="text-3xl md:text-4xl font-bold text-orange-600">Rp{{ number_format($stats['total_saldo'], 0, ',', '.') }}</h3>
    </div>
</div>

<!-- Search -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6 mb-8">
    <input type="text" 
           id="searchCard"
           placeholder="Cari kartu berdasarkan kode, username, atau nama..." 
           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kode Kartu</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase hidden sm:table-cell">Username</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Saldo</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase hidden lg:table-cell">Status</th>
                    <th class="px-4 md:px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($cards as $card)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 md:px-6 py-4 text-sm font-mono font-bold text-gray-900">{{ $card->card_code }}</td>
                        <td class="px-4 md:px-6 py-4 text-sm text-gray-600 hidden sm:table-cell">{{ $card->username ?? '-' }}</td>
                        <td class="px-4 md:px-6 py-4 text-sm text-gray-900">{{ $card->holder_name }}</td>
                        <td class="px-4 md:px-6 py-4 text-sm font-bold text-orange-600">Rp{{ number_format($card->saldo, 0, ',', '.') }}</td>
                        <td class="px-4 md:px-6 py-4 text-sm hidden lg:table-cell">
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $card->status === 'active' ? 'bg-green-100 text-green-700' : ($card->status === 'inactive' ? 'bg-gray-100 text-gray-700' : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($card->status) }}
                            </span>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-center">
                            <div class="flex justify-center gap-2 flex-wrap">
                                <a href="{{ route('payment-cards.show', $card) }}" 
                                   class="text-blue-600 hover:text-blue-700 text-xs md:text-sm font-medium">Lihat</a>
                                <a href="{{ route('payment-cards.topup', $card) }}" 
                                   class="text-green-600 hover:text-green-700 text-xs md:text-sm font-medium">Topup</a>
                                <a href="{{ route('payment-cards.edit', $card) }}" 
                                   class="text-orange-600 hover:text-orange-700 text-xs md:text-sm font-medium">Edit</a>
                                <button type="button" 
                                        onclick="confirmDelete('{{ route('payment-cards.destroy', $card) }}')"
                                        class="text-red-600 hover:text-red-700 text-xs md:text-sm font-medium">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 md:px-6 py-12 text-center text-gray-500">
                            <p class="text-sm">Belum ada kartu pembayaran. <a href="{{ route('payment-cards.create') }}" class="text-orange-600 font-medium hover:text-orange-700">Buat kartu baru</a></p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($cards->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $cards->links() }}
    </div>
@endif

<script>
    function confirmDelete(url) {
        if (confirm('Apakah Anda yakin ingin menghapus kartu ini?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }

    document.getElementById('searchCard').addEventListener('input', function(e) {
        const rows = document.querySelectorAll('tbody tr');
        const search = e.target.value.toLowerCase();
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(search) ? '' : 'none';
        });
    });
</script>

@endsection
