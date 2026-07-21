@extends('layouts.app')

@section('title','Riwayat Transaksi')
@section('page-title','Riwayat Transaksi')

@section('content')

<div class="max-w-5xl mx-auto">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('payment-cards.show', $card) }}" 
           class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="font-medium">Kembali</span>
        </a>
    </div>

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h3 class="text-2xl font-semibold text-gray-900">Riwayat Transaksi Kartu</h3>
            <p class="text-sm text-gray-600 mt-1">{{ $card->holder_name }} ({{ $card->card_code }})</p>
        </div>
    </div>

    <!-- Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
            <p class="text-sm font-medium text-gray-600 mb-2">Saldo Saat Ini</p>
            <h3 class="text-3xl font-bold text-orange-600">Rp{{ number_format($card->saldo, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
            <p class="text-sm font-medium text-gray-600 mb-2">Total Transaksi</p>
            <h3 class="text-3xl font-bold text-gray-900">{{ $transactions->total() }}</h3>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
            <p class="text-sm font-medium text-gray-600 mb-2">Total Pengeluaran</p>
            <h3 class="text-3xl font-bold text-red-600">
                Rp{{ number_format($transactions->where('type', 'purchase')->sum('amount'), 0, ',', '.') }}
            </h3>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <!-- Filter & Export -->
        <div class="p-4 bg-slate-50 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <label class="text-xs font-semibold text-gray-600">Filter:</label>
                <select id="filterType" onchange="filterTransactions()" class="px-3 py-1 border border-slate-300 rounded text-xs focus:ring-2 focus:ring-orange-500">
                    <option value="all">Semua</option>
                    <option value="topup">Top-up</option>
                    <option value="purchase">Pembelian</option>
                </select>
            </div>
            <div class="text-xs text-gray-600">
                <span class="font-semibold">Total Transaksi:</span> <span id="txCount">{{ $transactions->total() }}</span>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                        <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Tipe</th>
                        <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Deskripsi</th>
                        <th class="px-4 md:px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase">Jumlah</th>
                        <th class="px-4 md:px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase hidden md:table-cell">Saldo Sebelum</th>
                        <th class="px-4 md:px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase hidden md:table-cell">Saldo Sesudah</th>
                        <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200" id="transactionTableBody">
                    @forelse($transactions as $idx => $tx)
                        <tr class="hover:bg-slate-50 transition-colors transaction-row" data-type="{{ $tx->type }}">
                            <td class="px-4 md:px-6 py-4 text-sm font-semibold text-gray-600">
                                {{ $transactions->firstItem() + $idx }}
                            </td>
                            <td class="px-4 md:px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $tx->type === 'purchase' ? 'bg-red-100 text-red-700' : ($tx->type === 'topup' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700') }}">
                                    {{ $tx->type === 'purchase' ? '🛒 Pembelian' : ($tx->type === 'topup' ? '💰 Top-up' : ucfirst($tx->type)) }}
                                </span>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-sm text-gray-700">
                                @if($tx->transaksi_id)
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono font-bold">TRX-{{ str_pad($tx->transaksi_id, 5, '0', STR_PAD_LEFT) }}</span>
                                        <a href="{{ route('transaksi.index') }}?search=TRX-{{ $tx->transaksi_id }}" 
                                           target="_blank"
                                           class="text-xs text-blue-600 hover:text-blue-800 underline">
                                            Lihat Detail
                                        </a>
                                    </div>
                                @else
                                    <span class="text-gray-600">{{ $tx->description ?? '-' }}</span>
                                @endif
                                @if($tx->description && $tx->transaksi_id)
                                    <p class="text-xs text-gray-500 mt-1">{{ $tx->description }}</p>
                                @endif
                            </td>
                            <td class="px-4 md:px-6 py-4 text-sm font-bold text-right">
                                <span class="{{ $tx->type === 'purchase' ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $tx->type === 'purchase' ? '-' : '+' }}Rp{{ number_format($tx->amount, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-sm text-gray-600 text-right hidden md:table-cell">
                                <span class="font-mono">Rp{{ number_format($tx->saldo_before, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-sm font-semibold text-right hidden md:table-cell">
                                <span class="font-mono {{ $tx->saldo_after > $tx->saldo_before ? 'text-green-600' : 'text-red-600' }}">
                                    Rp{{ number_format($tx->saldo_after, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-sm text-gray-700">
                                <div>
                                    <p class="font-semibold">{{ $tx->created_at->format('d/m/Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $tx->created_at->format('H:i:s') }}</p>
                                    <p class="text-xs text-gray-400">{{ $tx->created_at->diffForHumans() }}</p>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyRow">
                            <td colspan="7" class="px-4 md:px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-3">
                                    <span class="text-4xl">📭</span>
                                    <p class="text-sm font-semibold">Belum ada transaksi</p>
                                    <p class="text-xs">Transaksi akan muncul di sini setelah melakukan top-up atau pembayaran</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($transactions->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $transactions->links() }}
        </div>
    @endif
</div>

<script>
function filterTransactions() {
    const filterValue = document.getElementById('filterType').value;
    const rows = document.querySelectorAll('.transaction-row');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const type = row.getAttribute('data-type');
        if (filterValue === 'all' || type === filterValue) {
            row.classList.remove('hidden');
            visibleCount++;
        } else {
            row.classList.add('hidden');
        }
    });
    
    // Update count
    document.getElementById('txCount').textContent = visibleCount;
    
    // Show/hide empty message
    const emptyRow = document.getElementById('emptyRow');
    if (emptyRow) {
        if (visibleCount === 0) {
            emptyRow.classList.remove('hidden');
        } else {
            emptyRow.classList.add('hidden');
        }
    }
}
</script>

@endsection
