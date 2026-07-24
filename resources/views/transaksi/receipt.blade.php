<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $transaksi->kode_transaksi }}</title>
    @vite('resources/css/app.css')
    <style>
        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }
            
            .no-print {
                display: none !important;
            }
            
            .print-container {
                max-width: 80mm;
                margin: 0 auto;
                padding: 0;
            }
            
            #receipt {
                box-shadow: none !important;
                border: none !important;
                padding: 10mm 5mm !important;
                background: white !important;
            }
            
            @page {
                size: 80mm auto;
                margin: 0;
            }
            
            * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        
        /* Screen Styles */
        @media screen {
            body {
                background: linear-gradient(to bottom right, rgb(249, 250, 251), rgb(229, 231, 235));
                min-height: 100vh;
                padding: 2rem 1rem;
            }
            
            .print-container {
                max-width: 32rem;
                margin: 0 auto;
            }
        }
    </style>
</head>
<body>

<div class="print-container">
    <!-- Receipt Container -->
    <div id="receipt" class="bg-white rounded-xl shadow-lg p-6 md:p-8">
        <!-- Header -->
        <div class="text-center mb-8 pb-6 border-b-2 border-dotted border-slate-300">
            <div class="flex items-center justify-center gap-2 mb-3">
                <div class="px-3 py-1.5 rounded flex items-center justify-center" style="background-color: #000000 !important;">
                    <span class="font-black text-sm" style="color: #FFFFFF !important;">COOL</span>
                </div>
                <div class="px-3 py-1.5 rounded flex items-center justify-center" style="background-color: #FFFFFF !important; border: 1px solid #E5E7EB;">
                    <span class="font-black text-sm" style="color: #EA580C !important;">E-BILL</span>
                </div>
            </div>
            <h1 class="text-2xl font-black text-gray-900">STRUK PEMBAYARAN</h1>
            <p class="text-xs text-gray-600 mt-2">Smart POS System</p>
        </div>

        <!-- Transaction Info -->
        <div class="mb-6 space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-600">Kode Transaksi</span>
                <span class="font-mono font-bold text-gray-900">{{ $transaksi->kode_transaksi }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Tanggal</span>
                <span class="font-semibold text-gray-900">{{ $transaksi->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Kasir</span>
                <span class="font-semibold text-gray-900">{{ $transaksi->user->name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Metode</span>
                <span class="font-semibold">
                    @if($transaksi->metode_pembayaran === 'tunai')
                        <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-700">Tunai</span>
                    @elseif($transaksi->metode_pembayaran === 'kartu_id')
                        <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">Kartu ID</span>
                    @endif
                </span>
            </div>
            @if($transaksi->paymentCard)
            <div class="flex justify-between text-xs">
                <span class="text-gray-600">Pemegang Kartu</span>
                <span class="font-semibold text-gray-900">{{ $transaksi->paymentCard->holder_name }}</span>
            </div>
            @endif
        </div>

        <!-- Items Divider -->
        <div class="mb-4 pb-4 border-b-2 border-dotted border-slate-300"></div>

        <!-- Items List -->
        <div class="mb-6">
            <div class="text-sm mb-3">
                <div class="flex justify-between font-semibold text-gray-900 mb-2 pb-2 border-b border-slate-200">
                    <span>Produk</span>
                    <div class="flex gap-4">
                        <span class="w-8 text-right">Qty</span>
                        <span class="w-20 text-right">Harga</span>
                    </div>
                </div>
                @foreach($transaksi->details as $detail)
                <div class="flex justify-between mb-2">
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">{{ $detail->produk->nama_produk }}</p>
                        <p class="text-xs text-gray-600">Rp{{ number_format($detail->harga, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex gap-4">
                        <span class="w-8 text-right text-gray-900">{{ $detail->qty }}</span>
                        <span class="w-20 text-right font-semibold text-gray-900">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Summary Divider -->
        <div class="mb-4 pb-4 border-b-2 border-dotted border-slate-300"></div>

        <!-- Summary -->
        <div class="mb-6 space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-600">Subtotal</span>
                <span class="font-semibold text-gray-900">Rp{{ number_format($transaksi->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-lg font-bold pt-2 border-t-2 border-slate-300">
                <span class="text-gray-900">TOTAL</span>
                <span class="text-orange-600">Rp{{ number_format($transaksi->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer Divider -->
        <div class="mb-6 pb-6 border-b-2 border-dotted border-slate-300"></div>

        <!-- Footer -->
        <div class="text-center space-y-3 text-xs text-gray-600">
            <p class="font-semibold">Terima Kasih Telah Berbelanja</p>
            <p>Mohon simpan struk ini sebagai bukti pembayaran</p>
            <p class="text-gray-400">{{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>

    <!-- Action Buttons - Hidden on Print -->
    <div class="mt-6 flex gap-3 no-print">
        <button onclick="window.print()" 
                class="flex-1 px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-semibold rounded-lg hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Cetak Struk
        </button>
        <a href="{{ route('transaksi.create') }}" 
           class="flex-1 px-6 py-3 bg-gray-200 text-gray-900 font-semibold rounded-lg hover:bg-gray-300 transition-all duration-200 text-center">
            Transaksi Baru
        </a>
        <a href="{{ route('transaksi.index') }}" 
           class="flex-1 px-6 py-3 border border-slate-300 text-gray-900 font-semibold rounded-lg hover:bg-slate-50 transition-all duration-200 text-center">
            Lihat Riwayat
        </a>
    </div>
</div>

</body>
</html>
