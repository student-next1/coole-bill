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
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Tipe</th>
                        <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase hidden sm:table-cell">Deskripsi</th>
                        <th class="px-4 md:px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase">Jumlah</th>
                        <th class="px-4 md:px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase hidden md:table-cell">Saldo Sebelum</th>
                        <th class="px-4 md:px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase hidden md:table-cell">Saldo Sesudah</th>
                        <th class="px-4 md:px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase hidden lg:table-cell">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($transactions as $tx)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 md:px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $tx->type === 'purchase' ? 'bg-red-100 text-red-700' : ($tx->type === 'topup' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700') }}">
                                    {{ ucfirst($tx->type) }}
                                </span>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-sm text-gray-600 hidden sm:table-cell">
                                @if($tx->transaksi_id)
                                    <span class="font-mono">TRX-{{ $tx->transaksi_id }}</span>
                                @else
                                    {{ $tx->description ?? '-' }}
                                @endif
                            </td>
                            <td class="px-4 md:px-6 py-4 text-sm font-bold text-right {{ $tx->type === 'purchase' ? 'text-red-600' : 'text-green-600' }}">
                                {{ $tx->type === 'purchase' ? '-' : '+' }}Rp{{ number_format($tx->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-4 md:px-6 py-4 text-sm text-gray-600 text-right hidden md:table-cell">
                                Rp{{ number_format($tx->saldo_before, 0, ',', '.') }}
                            </td>
                            <td class="px-4 md:px-6 py-4 text-sm text-gray-600 text-right hidden md:table-cell">
                                Rp{{ number_format($tx->saldo_after, 0, ',', '.') }}
                            </td>
                            <td class="px-4 md:px-6 py-4 text-sm text-gray-600 hidden lg:table-cell">
                                {{ $tx->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 md:px-6 py-12 text-center text-gray-500">
                                <p class="text-sm">Belum ada transaksi</p>
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

@endsection
