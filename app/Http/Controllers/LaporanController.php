<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Get transactions with filters
        $startDate = $request->query('start_date') ? Carbon::parse($request->query('start_date')) : Carbon::now()->subDays(30);
        $endDate = $request->query('end_date') ? Carbon::parse($request->query('end_date')) : Carbon::now();

        // Get all transactions in date range
        $transaksis = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->with('details.produk', 'user', 'paymentCard')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate totals
        $totalPenjualan = $transaksis->sum('total');
        $jumlahTransaksi = $transaksis->count();
        $rataRata = $jumlahTransaksi > 0 ? $totalPenjualan / $jumlahTransaksi : 0;

        // Get daily sales data for chart (last 30 days)
        $dailySales = [];
        $labels = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $daysSales = Transaksi::whereDate('created_at', $date)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total');
            
            $dailySales[] = $daysSales;
            $labels[] = $date->format('d M');
        }

        // Get top 5 products
        $topProducts = Produk::withCount(['transaksiDetails' => function ($query) {
            $query->whereHas('transaksi', function ($q) {
                $q->whereBetween('created_at', [
                    Carbon::now()->subDays(30),
                    Carbon::now()
                ]);
            });
        }])
        ->orderBy('transaksi_details_count', 'desc')
        ->take(5)
        ->get();

        // Get payment methods breakdown
        $paymentMethods = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('metode_pembayaran')
            ->selectRaw('metode_pembayaran, COUNT(*) as count, SUM(total) as total')
            ->get();

        return view('laporan.index', compact(
            'transaksis',
            'totalPenjualan',
            'jumlahTransaksi',
            'rataRata',
            'dailySales',
            'labels',
            'topProducts',
            'paymentMethods',
            'startDate',
            'endDate'
        ));
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->query('start_date') ? Carbon::parse($request->query('start_date')) : Carbon::now()->subDays(30);
        $endDate = $request->query('end_date') ? Carbon::parse($request->query('end_date')) : Carbon::now();

        $transaksis = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->with('details.produk', 'user', 'paymentCard')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPenjualan = $transaksis->sum('total');
        $jumlahTransaksi = $transaksis->count();
        $rataRata = $jumlahTransaksi > 0 ? $totalPenjualan / $jumlahTransaksi : 0;

        $pdf = Pdf::loadView('laporan.pdf', compact(
            'transaksis',
            'totalPenjualan',
            'jumlahTransaksi',
            'rataRata',
            'startDate',
            'endDate'
        ));

        return $pdf->download('laporan-penjualan-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportCsv(Request $request)
    {
        $startDate = $request->query('start_date') ? Carbon::parse($request->query('start_date')) : Carbon::now()->subDays(30);
        $endDate = $request->query('end_date') ? Carbon::parse($request->query('end_date')) : Carbon::now();

        $transaksis = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->with('details.produk', 'user', 'paymentCard')
            ->orderBy('created_at', 'desc')
            ->get();

        $fileName = 'laporan-penjualan-' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($transaksis) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, ['Kode Transaksi', 'Kasir', 'Total', 'Metode Pembayaran', 'Kartu Pembayaran', 'Jumlah Item', 'Waktu']);

            // Data
            foreach ($transaksis as $transaksi) {
                fputcsv($file, [
                    $transaksi->kode_transaksi,
                    $transaksi->user->name ?? '-',
                    $transaksi->total,
                    ucfirst(str_replace('_', ' ', $transaksi->metode_pembayaran)),
                    $transaksi->paymentCard->nomor_kartu ?? '-',
                    $transaksi->details->count(),
                    $transaksi->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Laporan Bulanan
     */
    public function monthly(Request $request)
    {
        $month = $request->query('month') ? Carbon::parse($request->query('month')) : Carbon::now();
        $startDate = $month->copy()->startOfMonth();
        $endDate = $month->copy()->endOfMonth();

        // Get all transactions in month
        $transaksis = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->with('details.produk', 'user', 'paymentCard')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate totals
        $totalPenjualan = $transaksis->sum('total');
        $jumlahTransaksi = $transaksis->count();
        $rataRata = $jumlahTransaksi > 0 ? $totalPenjualan / $jumlahTransaksi : 0;

        // Daily sales for the month
        $dailySales = [];
        $labels = [];
        $daysInMonth = $month->daysInMonth;
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = $month->copy()->setDay($day);
            $daysSales = Transaksi::whereDate('created_at', $date)->sum('total');
            
            $dailySales[] = $daysSales;
            $labels[] = $date->format('d');
        }

        // Top products in month
        $topProducts = Produk::withCount(['transaksiDetails' => function ($query) use ($startDate, $endDate) {
            $query->whereHas('transaksi', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }])
        ->withSum(['transaksiDetails as total_sales' => function ($query) use ($startDate, $endDate) {
            $query->whereHas('transaksi', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }], 'subtotal')
        ->having('transaksi_details_count', '>', 0)
        ->orderBy('transaksi_details_count', 'desc')
        ->take(10)
        ->get();

        // Payment methods breakdown
        $paymentMethods = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('metode_pembayaran')
            ->selectRaw('metode_pembayaran, COUNT(*) as count, SUM(total) as total')
            ->get();

        // Daily statistics
        $dailyStats = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = $month->copy()->setDay($day);
            $dayTransactions = Transaksi::whereDate('created_at', $date)->get();
            
            $dailyStats[] = [
                'date' => $date->format('d M Y'),
                'count' => $dayTransactions->count(),
                'total' => $dayTransactions->sum('total'),
            ];
        }

        return view('laporan.monthly', compact(
            'transaksis',
            'totalPenjualan',
            'jumlahTransaksi',
            'rataRata',
            'dailySales',
            'labels',
            'topProducts',
            'paymentMethods',
            'dailyStats',
            'month',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Laporan Tahunan
     */
    public function yearly(Request $request)
    {
        $year = $request->query('year') ? Carbon::parse($request->query('year')) : Carbon::now();
        $startDate = $year->copy()->startOfYear();
        $endDate = $year->copy()->endOfYear();

        // Get all transactions in year
        $transaksis = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->with('details.produk', 'user', 'paymentCard')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate totals
        $totalPenjualan = $transaksis->sum('total');
        $jumlahTransaksi = $transaksis->count();
        $rataRata = $jumlahTransaksi > 0 ? $totalPenjualan / $jumlahTransaksi : 0;

        // Monthly sales for the year
        $monthlySales = [];
        $labels = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $date = $year->copy()->setMonth($month);
            $monthSales = Transaksi::whereYear('created_at', $year->year)
                ->whereMonth('created_at', $month)
                ->sum('total');
            
            $monthlySales[] = $monthSales;
            $labels[] = $date->format('M');
        }

        // Top products in year
        $topProducts = Produk::withCount(['transaksiDetails' => function ($query) use ($startDate, $endDate) {
            $query->whereHas('transaksi', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }])
        ->withSum(['transaksiDetails as total_sales' => function ($query) use ($startDate, $endDate) {
            $query->whereHas('transaksi', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }], 'subtotal')
        ->having('transaksi_details_count', '>', 0)
        ->orderBy('transaksi_details_count', 'desc')
        ->take(10)
        ->get();

        // Payment methods breakdown
        $paymentMethods = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('metode_pembayaran')
            ->selectRaw('metode_pembayaran, COUNT(*) as count, SUM(total) as total')
            ->get();

        // Monthly statistics
        $monthlyStats = [];
        for ($month = 1; $month <= 12; $month++) {
            $date = $year->copy()->setMonth($month);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();
            $monthTransactions = Transaksi::whereBetween('created_at', [$monthStart, $monthEnd])->get();
            
            $monthlyStats[] = [
                'month' => $date->format('F Y'),
                'count' => $monthTransactions->count(),
                'total' => $monthTransactions->sum('total'),
            ];
        }

        // Quarter statistics
        $quarterStats = [];
        for ($quarter = 1; $quarter <= 4; $quarter++) {
            $quarterStart = $year->copy()->setMonth(($quarter - 1) * 3 + 1)->startOfMonth();
            $quarterEnd = $year->copy()->setMonth($quarter * 3)->endOfMonth();
            $quarterTransactions = Transaksi::whereBetween('created_at', [$quarterStart, $quarterEnd])->get();
            
            $quarterStats[] = [
                'quarter' => "Q{$quarter} {$year->year}",
                'count' => $quarterTransactions->count(),
                'total' => $quarterTransactions->sum('total'),
            ];
        }

        return view('laporan.yearly', compact(
            'transaksis',
            'totalPenjualan',
            'jumlahTransaksi',
            'rataRata',
            'monthlySales',
            'labels',
            'topProducts',
            'paymentMethods',
            'monthlyStats',
            'quarterStats',
            'year',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Export Monthly Report PDF
     */
    public function exportMonthlyPdf(Request $request)
    {
        $month = $request->query('month') ? Carbon::parse($request->query('month')) : Carbon::now();
        $startDate = $month->copy()->startOfMonth();
        $endDate = $month->copy()->endOfMonth();

        $transaksis = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->with('details.produk', 'user', 'paymentCard')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPenjualan = $transaksis->sum('total');
        $jumlahTransaksi = $transaksis->count();
        $rataRata = $jumlahTransaksi > 0 ? $totalPenjualan / $jumlahTransaksi : 0;

        // Top products
        $topProducts = Produk::withCount(['transaksiDetails' => function ($query) use ($startDate, $endDate) {
            $query->whereHas('transaksi', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }])
        ->having('transaksi_details_count', '>', 0)
        ->orderBy('transaksi_details_count', 'desc')
        ->take(10)
        ->get();

        $paymentMethods = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('metode_pembayaran')
            ->selectRaw('metode_pembayaran, COUNT(*) as count, SUM(total) as total')
            ->get();

        $pdf = Pdf::loadView('laporan.monthly-pdf', compact(
            'transaksis',
            'totalPenjualan',
            'jumlahTransaksi',
            'rataRata',
            'topProducts',
            'paymentMethods',
            'month',
            'startDate',
            'endDate'
        ));

        return $pdf->download('laporan-bulanan-' . $month->format('Y-m') . '.pdf');
    }

    /**
     * Export Monthly Report CSV
     */
    public function exportMonthlyCsv(Request $request)
    {
        $month = $request->query('month') ? Carbon::parse($request->query('month')) : Carbon::now();
        $startDate = $month->copy()->startOfMonth();
        $endDate = $month->copy()->endOfMonth();

        $transaksis = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->with('details.produk', 'user', 'paymentCard')
            ->orderBy('created_at', 'desc')
            ->get();

        $fileName = 'laporan-bulanan-' . $month->format('Y-m') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($transaksis, $month) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['Laporan Penjualan Bulanan - ' . $month->format('F Y')]);
            fputcsv($file, []);
            fputcsv($file, ['Kode Transaksi', 'Kasir', 'Total', 'Metode Pembayaran', 'Kartu Pembayaran', 'Jumlah Item', 'Waktu']);

            // Data
            foreach ($transaksis as $transaksi) {
                fputcsv($file, [
                    $transaksi->kode_transaksi,
                    $transaksi->user->name ?? '-',
                    $transaksi->total,
                    ucfirst(str_replace('_', ' ', $transaksi->metode_pembayaran)),
                    $transaksi->paymentCard->nomor_kartu ?? '-',
                    $transaksi->details->count(),
                    $transaksi->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export Yearly Report PDF
     */
    public function exportYearlyPdf(Request $request)
    {
        $year = $request->query('year') ? Carbon::parse($request->query('year')) : Carbon::now();
        $startDate = $year->copy()->startOfYear();
        $endDate = $year->copy()->endOfYear();

        $transaksis = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->with('details.produk', 'user', 'paymentCard')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPenjualan = $transaksis->sum('total');
        $jumlahTransaksi = $transaksis->count();
        $rataRata = $jumlahTransaksi > 0 ? $totalPenjualan / $jumlahTransaksi : 0;

        // Top products
        $topProducts = Produk::withCount(['transaksiDetails' => function ($query) use ($startDate, $endDate) {
            $query->whereHas('transaksi', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }])
        ->having('transaksi_details_count', '>', 0)
        ->orderBy('transaksi_details_count', 'desc')
        ->take(10)
        ->get();

        $paymentMethods = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('metode_pembayaran')
            ->selectRaw('metode_pembayaran, COUNT(*) as count, SUM(total) as total')
            ->get();

        // Monthly statistics
        $monthlyStats = [];
        for ($month = 1; $month <= 12; $month++) {
            $date = $year->copy()->setMonth($month);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();
            $monthTransactions = Transaksi::whereBetween('created_at', [$monthStart, $monthEnd])->get();
            
            $monthlyStats[] = [
                'month' => $date->format('F'),
                'count' => $monthTransactions->count(),
                'total' => $monthTransactions->sum('total'),
            ];
        }

        $pdf = Pdf::loadView('laporan.yearly-pdf', compact(
            'transaksis',
            'totalPenjualan',
            'jumlahTransaksi',
            'rataRata',
            'topProducts',
            'paymentMethods',
            'monthlyStats',
            'year',
            'startDate',
            'endDate'
        ));

        return $pdf->download('laporan-tahunan-' . $year->format('Y') . '.pdf');
    }

    /**
     * Export Yearly Report CSV
     */
    public function exportYearlyCsv(Request $request)
    {
        $year = $request->query('year') ? Carbon::parse($request->query('year')) : Carbon::now();
        $startDate = $year->copy()->startOfYear();
        $endDate = $year->copy()->endOfYear();

        $transaksis = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->with('details.produk', 'user', 'paymentCard')
            ->orderBy('created_at', 'desc')
            ->get();

        $fileName = 'laporan-tahunan-' . $year->format('Y') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($transaksis, $year) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['Laporan Penjualan Tahunan - ' . $year->format('Y')]);
            fputcsv($file, []);
            fputcsv($file, ['Kode Transaksi', 'Kasir', 'Total', 'Metode Pembayaran', 'Kartu Pembayaran', 'Jumlah Item', 'Waktu']);

            // Data
            foreach ($transaksis as $transaksi) {
                fputcsv($file, [
                    $transaksi->kode_transaksi,
                    $transaksi->user->name ?? '-',
                    $transaksi->total,
                    ucfirst(str_replace('_', ' ', $transaksi->metode_pembayaran)),
                    $transaksi->paymentCard->nomor_kartu ?? '-',
                    $transaksi->details->count(),
                    $transaksi->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
