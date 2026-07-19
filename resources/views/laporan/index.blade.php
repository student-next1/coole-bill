@extends('layouts.app')

@section('title','Laporan')
@section('page-title','Laporan')

@section('content')

<!-- Header Section -->
<div class="mb-8">
    <h3 class="text-lg md:text-xl font-semibold text-gray-900">Laporan Penjualan</h3>
    <p class="text-sm text-gray-600 mt-1">Analisis dan laporan bisnis Anda</p>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
    <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Awal</label>
            <input type="date" 
                   name="start_date" 
                   value="{{ $startDate->format('Y-m-d') }}"
                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
            <input type="date" 
                   name="end_date" 
                   value="{{ $endDate->format('Y-m-d') }}"
                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors font-medium">
            Filter
        </button>
        <a href="{{ route('laporan.index') }}" class="px-6 py-2 bg-slate-200 text-gray-900 rounded-lg hover:bg-slate-300 transition-colors font-medium">
            Reset
        </a>
    </form>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Penjualan</p>
        <h3 class="text-3xl font-bold text-gray-900 mb-2">Rp{{ number_format($totalPenjualan, 0, ',', '.') }}</h3>
        <p class="text-xs text-gray-500">{{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Jumlah Transaksi</p>
        <h3 class="text-3xl font-bold text-orange-600">{{ $jumlahTransaksi }}</h3>
        <p class="text-xs text-gray-500">transaksi berhasil</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Rata-rata Transaksi</p>
        <h3 class="text-3xl font-bold text-blue-600">Rp{{ number_format($rataRata, 0, ',', '.') }}</h3>
        <p class="text-xs text-gray-500">per transaksi</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Metode Pembayaran</p>
        <h3 class="text-3xl font-bold text-green-600">{{ $paymentMethods->count() }}</h3>
        <p class="text-xs text-gray-500">jenis pembayaran</p>
    </div>
</div>

<!-- Grafik Penjualan (Chart) -->
@if($jumlahTransaksi > 0)
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-900 mb-6">Grafik Penjualan (30 Hari Terakhir)</h3>
    <div style="position: relative; height: 300px;">
        <canvas id="salesChart"></canvas>
    </div>
</div>

<!-- Payment Methods Breakdown -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Payment Methods Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Metode Pembayaran</h3>
        <div style="position: relative; height: 250px;">
            <canvas id="paymentChart"></canvas>
        </div>
    </div>

    <!-- Top Products -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Produk Terlaris</h3>
        <div class="space-y-4">
            @forelse($topProducts as $idx => $produk)
                <div class="flex items-center justify-between pb-4 border-b border-slate-200 last:border-b-0">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-sm font-bold text-orange-600">
                            {{ $idx + 1 }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $produk->nama_produk }}</p>
                            <p class="text-xs text-gray-500">{{ $produk->details_count }} penjualan</p>
                        </div>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada penjualan produk</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Laporan Detail Transaksi -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-200">
        <h3 class="text-lg font-semibold text-gray-900">Riwayat Transaksi</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode Transaksi</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Kasir</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">Metode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">Items</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($transaksis as $transaksi)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $transaksi->kode_transaksi }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 hidden sm:table-cell">{{ $transaksi->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-orange-600">Rp{{ number_format($transaksi->total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm hidden md:table-cell">
                            <span class="px-2 py-1 rounded text-xs font-medium {{ $transaksi->metode_pembayaran === 'tunai' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                {{ ucfirst(str_replace('_', ' ', $transaksi->metode_pembayaran)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm hidden lg:table-cell">
                            <span class="inline-block px-2 py-1 bg-slate-100 text-gray-700 rounded text-xs font-medium">
                                {{ $transaksi->details->count() }} item
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 hidden lg:table-cell">{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <p class="text-sm">Belum ada transaksi dalam periode ini</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@else
<!-- Empty State -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
    <div class="mb-4">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 rounded-full mb-4">
            <span class="text-3xl">📊</span>
        </div>
    </div>
    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Data Laporan</h3>
    <p class="text-gray-600 mb-4">Mulai buat transaksi untuk melihat laporan penjualan Anda</p>
    <a href="{{ route('transaksi.create') }}" class="inline-flex px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-semibold rounded-lg hover:shadow-lg transition-all duration-200">
        ➕ Buat Transaksi Baru
    </a>
</div>
@endif

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
@if($jumlahTransaksi > 0)
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Penjualan Harian',
                data: {!! json_encode($dailySales) !!},
                borderColor: '#ea580c',
                backgroundColor: 'rgba(234, 88, 12, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#ea580c',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        font: { size: 12, weight: 'bold' },
                        color: '#374151'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // Payment Methods Chart
    const paymentCtx = document.getElementById('paymentChart').getContext('2d');
    new Chart(paymentCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($paymentMethods->map(fn($m) => ucfirst(str_replace('_', ' ', $m->metode_pembayaran)))->toArray()) !!},
            datasets: [{
                data: {!! json_encode($paymentMethods->pluck('count')->toArray()) !!},
                backgroundColor: [
                    '#ea580c',
                    '#3b82f6',
                    '#10b981',
                    '#f59e0b',
                    '#8b5cf6'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 12 },
                        padding: 15,
                        color: '#374151'
                    }
                }
            }
        }
    });
@endif
</script>

@endsection
