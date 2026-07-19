@extends('layouts.app')

@section('title','Detail Kartu')
@section('page-title','Detail Kartu')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h3 class="text-2xl font-semibold text-gray-900">Detail Kartu Pembayaran</h3>
            <p class="text-sm text-gray-600 mt-1">{{ $card->holder_name }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('payment-cards.edit', $card) }}" 
               class="px-4 py-2 border border-slate-300 text-gray-900 font-medium rounded-lg hover:bg-slate-50 transition-colors text-sm">
                Edit
            </a>
            <button onclick="window.print()" 
                    class="px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all text-sm">
                Cetak Kartu
            </button>
        </div>
    </div>

    <!-- Card Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Left: Info -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kartu</h4>
            
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Kode Kartu</p>
                    <p class="text-sm font-mono font-bold text-gray-900">{{ $card->card_code }}</p>
                </div>
                
                <div>
                    <p class="text-xs text-gray-600 mb-1">Nama Pemilik</p>
                    <p class="text-sm font-medium text-gray-900">{{ $card->holder_name }}</p>
                </div>
                
                <div>
                    <p class="text-xs text-gray-600 mb-1">Username</p>
                    <p class="text-sm font-medium text-gray-900">{{ $card->username ?? '-' }}</p>
                </div>
                
                <div>
                    <p class="text-xs text-gray-600 mb-1">Saldo Tersedia</p>
                    <p class="text-2xl font-bold text-orange-600">Rp{{ number_format($card->saldo, 0, ',', '.') }}</p>
                </div>
                
                <div>
                    <p class="text-xs text-gray-600 mb-1">Status</p>
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $card->status === 'active' ? 'bg-green-100 text-green-700' : ($card->status === 'inactive' ? 'bg-gray-100 text-gray-700' : 'bg-red-100 text-red-700') }}">
                        {{ ucfirst($card->status) }}
                    </span>
                </div>

                <div>
                    <p class="text-xs text-gray-600 mb-1">Catatan</p>
                    <p class="text-sm text-gray-900">{{ $card->notes ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-600 mb-1">Dibuat</p>
                    <p class="text-sm text-gray-900">{{ $card->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 pt-6 border-t border-slate-200 space-y-2">
                <a href="{{ route('payment-cards.topup', $card) }}" 
                   class="block w-full px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors text-center text-sm">
                    + Topup Saldo
                </a>
                <a href="{{ route('payment-cards.transactions', $card) }}" 
                   class="block w-full px-4 py-2 border border-slate-300 text-gray-900 font-medium rounded-lg hover:bg-slate-50 transition-colors text-center text-sm">
                    Lihat Riwayat
                </a>
            </div>
        </div>

        <!-- Right: Barcode Card Design -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 print:shadow-none print:border-0">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">Kartu Pembayaran (Untuk Dicetak)</h4>
            
            <!-- Printable Card -->
            <div id="cardToPrint" class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 text-white min-h-64 flex flex-col justify-between print:page-break-inside-avoid" style="width: 100%; aspect-ratio: 85.6 / 53.98; max-width: 100%;">
                
                <!-- Header -->
                <div class="text-center border-b border-orange-400 pb-3">
                    <p class="text-lg font-bold">COOLE-BILL</p>
                    <p class="text-xs opacity-90">PAYMENT CARD</p>
                </div>

                <!-- Holder Name -->
<div class="text-center my-2">
                    <p class="text-sm font-semibold">{{ $card->holder_name }}</p>
                    @if($card->username)
                        <p class="text-xs opacity-90">{{ '@' . $card->username }}</p>
                    @endif
                </div>

                <!-- Barcode Area -->
                <div class="flex justify-center bg-white rounded p-2 my-2">
                    <svg class="w-full" style="height: 50px;" viewBox="0 0 200 50">
                        {{ $card->card_code }}
                    </svg>
                </div>

                <!-- Card Code -->
                <div class="text-center text-xs">
                    <p class="font-mono font-bold">{{ $card->card_code }}</p>
                </div>

                <!-- Footer -->
                <div class="text-center border-t border-orange-400 pt-2 text-xs">
                    <p class="opacity-90">Scan kartu untuk pembayaran</p>
                </div>

            </div>

            <!-- Print Note -->
            <p class="text-xs text-gray-600 mt-4 text-center">
                Klik "Cetak Kartu" untuk mencetak kartu dalam ukuran standar (85.6 x 53.98 mm)
            </p>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h4 class="text-lg font-semibold text-gray-900 mb-4">Transaksi Terakhir</h4>
        
        @if($card->transactions->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Tipe</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Jumlah</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Saldo Sebelum</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Saldo Sesudah</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($card->transactions as $tx)
                            <tr>
                                <td class="px-4 py-2 text-sm">
                                    <span class="px-2 py-1 rounded text-xs font-medium {{ $tx->type === 'purchase' ? 'bg-red-100 text-red-700' : ($tx->type === 'topup' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700') }}">
                                        {{ ucfirst($tx->type) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm font-medium">Rp{{ number_format($tx->amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">Rp{{ number_format($tx->saldo_before, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">Rp{{ number_format($tx->saldo_after, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ $tx->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <a href="{{ route('payment-cards.transactions', $card) }}" class="text-orange-600 hover:text-orange-700 text-sm font-medium mt-4 inline-block">
                Lihat semua transaksi →
            </a>
        @else
            <p class="text-sm text-gray-600 text-center py-8">Belum ada transaksi</p>
        @endif
    </div>
</div>

<!-- Print Styles -->
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #cardToPrint, #cardToPrint * {
            visibility: visible;
        }
        #cardToPrint {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
        }
        .print\:page-break-inside-avoid {
            page-break-inside: avoid;
        }
    }
</style>

@endsection
