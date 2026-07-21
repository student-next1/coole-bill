@extends('layouts.app')

@section('title','Riwayat Transaksi')
@section('page-title','Riwayat Transaksi')

@section('content')

<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
        <h3 class="text-lg md:text-xl font-semibold text-gray-900">Riwayat Transaksi</h3>
        <p class="text-sm text-gray-600 mt-1">Lihat semua transaksi yang telah dilakukan</p>
    </div>
    <a href="{{ route('transaksi.create') }}" 
       class="inline-block px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 text-center text-sm md:text-base">
        + Transaksi Baru
    </a>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Transaksi</p>
        <h3 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $transaksis->total() }}</h3>
        @if(request('search') || request('metode'))
        <p class="text-xs text-orange-600 mt-2 font-medium">📊 Hasil filter</p>
        @endif
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Penjualan</p>
        <h3 class="text-3xl md:text-4xl font-bold text-orange-600">Rp{{ number_format($transaksis->sum('total'), 0, ',', '.') }}</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Rata-rata Transaksi</p>
        <h3 class="text-3xl md:text-4xl font-bold text-blue-600">Rp{{ $transaksis->count() > 0 ? number_format($transaksis->sum('total') / $transaksis->count(), 0, ',', '.') : 0 }}</h3>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6 mb-8">
    <form method="GET" action="{{ route('transaksi.index') }}" class="flex flex-col md:flex-row gap-4">
        <input type="text" 
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari kode transaksi..." 
               class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
        <select name="metode" 
                class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
            <option value="">Semua Metode</option>
            <option value="tunai" @selected(request('metode') === 'tunai')>Tunai</option>
            <option value="kartu_id" @selected(request('metode') === 'kartu_id')>Kartu ID</option>
        </select>
        <div class="flex gap-2">
            <button type="submit" 
                    class="px-6 py-2 bg-orange-600 rounded-lg hover:bg-orange-700 transition-colors text-sm font-medium" style="color: #ffffff !important;">
                🔍 Cari
            </button>
            @if(request('search') || request('metode'))
            <a href="{{ route('transaksi.index') }}" 
               class="px-4 py-2 font-medium rounded-lg hover:bg-slate-300 transition-colors text-sm text-center" style="background-color: #e2e8f0 !important; color: #1e293b !important;">
                Reset
            </a>
            @endif
            @if(Auth::user()->role === 'admin')
            <button type="button"
                    onclick="if(confirm('Apakah Anda yakin ingin menghapus semua riwayat transaksi? Tindakan ini tidak dapat dibatalkan.')) { deleteAllTransactions(); }"
                    class="px-4 py-2 bg-red-600 rounded-lg hover:bg-red-700 transition-colors text-sm font-medium" style="color: #ffffff !important;">
                🗑️ Hapus Semua
            </button>
            @endif
        </div>
    </form>
</div>

<!-- Table Section -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode Transaksi</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Kasir</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">Metode</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">Pembayaran</th>
                    <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">Waktu</th>
                    <th class="px-4 md:px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($transaksis as $transaksi)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 md:px-6 py-4 text-sm font-medium text-gray-900">{{ $transaksi->kode_transaksi }}</td>
                        <td class="px-4 md:px-6 py-4 text-sm text-gray-600 hidden sm:table-cell">{{ $transaksi->user->name ?? '-' }}</td>
                        <td class="px-4 md:px-6 py-4 text-sm font-bold text-orange-600">Rp{{ number_format($transaksi->total, 0, ',', '.') }}</td>
                        <td class="px-4 md:px-6 py-4 text-sm hidden md:table-cell">
                            <span class="px-2 py-1 rounded text-xs font-medium {{ $transaksi->metode_pembayaran === 'tunai' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                {{ ucfirst(str_replace('_', ' ', $transaksi->metode_pembayaran)) }}
                            </span>
                        </td>
                        <td class="px-4 md:px-6 py-4 text-sm hidden lg:table-cell">
                            @if($transaksi->payment_card_id)
                                <div class="text-xs">
                                    <p class="font-medium text-gray-900">{{ $transaksi->paymentCard->holder_name }}</p>
                                    <p class="text-gray-600">{{ $transaksi->paymentCard->card_code }}</p>
                                </div>
                            @else
                                <span class="text-gray-600">-</span>
                            @endif
                        </td>
                        <td class="px-4 md:px-6 py-4 text-sm text-gray-600 hidden lg:table-cell">{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 md:px-6 py-4 text-center">
                            <button type="button"
                                    onclick="showDetail({{ $transaksi->id }}, '{{ $transaksi->kode_transaksi }}', 'Rp{{ number_format($transaksi->total, 0, ',', '.') }}', '{{ $transaksi->details->count() }}', '{{ $transaksi->created_at->format('d/m/Y H:i') }}', '{{ $transaksi->paymentCard->holder_name ?? '-' }}')"
                                    class="text-blue-600 hover:text-blue-700 text-xs md:text-sm font-medium">
                                Detail
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 md:px-6 py-12 text-center text-gray-500">
                            <p class="text-sm">Belum ada transaksi. <a href="{{ route('transaksi.create') }}" class="text-orange-600 font-medium hover:text-orange-700">Buat transaksi baru</a></p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($transaksis->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $transaksis->appends(request()->query())->links() }}
    </div>
@endif

<!-- Detail Modal -->
<div id="detailModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg font-bold text-gray-900">Detail Transaksi</h3>
        </div>
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Kode Transaksi</p>
                    <p id="detailCode" class="text-sm font-medium text-gray-900">-</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">Total</p>
                    <p id="detailTotal" class="text-sm font-medium text-orange-600">-</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">Jumlah Item</p>
                    <p id="detailItems" class="text-sm font-medium text-gray-900">-</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">Waktu</p>
                    <p id="detailTime" class="text-sm font-medium text-gray-900">-</p>
                </div>
            </div>
            <div id="detailPaymentDiv" class="hidden border-t border-slate-200 pt-4">
                <p class="text-xs text-gray-600 mb-2">Pembayaran Kartu</p>
                <p id="detailPayment" class="text-sm font-medium text-gray-900">-</p>
            </div>
        </div>
        <div class="p-6 border-t border-slate-200 flex gap-3">
            <button type="button" 
                    onclick="printReceipt()"
                    class="flex-1 px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 text-sm">
                🖨️ Cetak Struk
            </button>
            <button type="button" 
                    onclick="closeDetail()"
                    class="flex-1 px-6 py-2 bg-gray-200 text-gray-900 font-medium rounded-lg hover:bg-gray-300 transition-all duration-200 text-sm">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    let currentTransaksiId = null;

    function showDetail(id, code, total, items, time, paymentCard) {
        currentTransaksiId = id;
        document.getElementById('detailCode').textContent = code;
        document.getElementById('detailTotal').textContent = total;
        document.getElementById('detailItems').textContent = items;
        document.getElementById('detailTime').textContent = time;
        
        // Show payment card info if available
        const paymentDiv = document.getElementById('detailPaymentDiv');
        if (paymentCard && paymentCard !== '-') {
            document.getElementById('detailPayment').textContent = paymentCard;
            paymentDiv.classList.remove('hidden');
        } else {
            paymentDiv.classList.add('hidden');
        }
        
        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeDetail() {
        document.getElementById('detailModal').classList.add('hidden');
        currentTransaksiId = null;
    }

    function printReceipt() {
        if (currentTransaksiId) {
            // Open receipt page in new window for printing
            window.open(`/transaksi/receipt/${currentTransaksiId}`, '_blank', 'width=400,height=600');
        }
    }

    function deleteAllTransactions() {
        fetch('{{ route("transaksi.delete-all") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Semua riwayat transaksi telah dihapus');
                location.reload();
            } else {
                alert('Gagal menghapus: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error);
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('detailModal').classList.contains('hidden')) {
            closeDetail();
        }
    });
</script>

@endsection
