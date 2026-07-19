<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
}
