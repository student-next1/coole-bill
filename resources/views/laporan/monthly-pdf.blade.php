<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Bulanan - {{ $month->format('F Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #ea580c;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #ea580c;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .stat-box {
            display: table-cell;
            width: 33.33%;
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .stat-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #ea580c;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #ea580c;
            border-bottom: 2px solid #ea580c;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        table td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .payment-method {
            display: inline-block;
            padding: 4px 8px;
            background-color: #f0f0f0;
            border-radius: 3px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENJUALAN BULANAN</h1>
        <p><strong>{{ $month->format('F Y') }}</strong></p>
        <p>{{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>
        <p style="font-size: 10px; color: #999;">Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-label">Total Penjualan</div>
            <div class="stat-value">Rp{{ number_format($totalPenjualan, 0, ',', '.') }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Jumlah Transaksi</div>
            <div class="stat-value">{{ $jumlahTransaksi }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Rata-rata Transaksi</div>
            <div class="stat-value">Rp{{ number_format($rataRata, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Top 10 Produk Terlaris</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 60%;">Nama Produk</th>
                    <th style="width: 20%;" class="text-center">Jumlah Terjual</th>
                    <th style="width: 15%;" class="text-right">Harga</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topProducts as $idx => $produk)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td>{{ $produk->nama }}</td>
                    <td class="text-center">{{ $produk->transaksi_details_count }}</td>
                    <td class="text-right">Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center" style="color: #999;">Belum ada data produk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Metode Pembayaran</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 50%;">Metode Pembayaran</th>
                    <th style="width: 25%;" class="text-center">Jumlah Transaksi</th>
                    <th style="width: 25%;" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentMethods as $method)
                <tr>
                    <td>{{ ucfirst(str_replace('_', ' ', $method->metode_pembayaran)) }}</td>
                    <td class="text-center">{{ $method->count }}</td>
                    <td class="text-right">Rp{{ number_format($method->total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Riwayat Transaksi (10 Terbaru)</div>
        <table>
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Kasir</th>
                    <th class="text-right">Total</th>
                    <th class="text-center">Metode</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis->take(10) as $transaksi)
                <tr>
                    <td>{{ $transaksi->kode_transaksi }}</td>
                    <td>{{ $transaksi->user->name ?? '-' }}</td>
                    <td class="text-right"><strong>Rp{{ number_format($transaksi->total, 0, ',', '.') }}</strong></td>
                    <td class="text-center">
                        <span class="payment-method">{{ ucfirst(str_replace('_', ' ', $transaksi->metode_pembayaran)) }}</span>
                    </td>
                    <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center" style="color: #999;">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p><strong>Coole-Bill POS System</strong></p>
        <p>Laporan ini dibuat secara otomatis oleh sistem</p>
    </div>
</body>
</html>
