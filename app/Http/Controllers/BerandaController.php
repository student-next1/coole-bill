<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\PaymentCard;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function dashboard(){
        // Get statistics
        $totalProduk = Produk::count();
        $totalKategori = Kategori::count();
        $stokRendah = Produk::where('stok', '<', 10)->count();
        
        // Today's transactions
        $transaksiHariIni = Transaksi::whereDate('created_at', Carbon::today())->count();
        $pendapatanHariIni = Transaksi::whereDate('created_at', Carbon::today())->sum('total');
        
        // This week transactions
        $transaksiMingguIni = Transaksi::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        
        // Total payment cards
        $totalKartu = PaymentCard::count();
        
        // Recent transactions (last 5)
        $transaksiTerbaru = Transaksi::with(['user', 'paymentCard'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Top selling products (this month)
        $produkTerlaris = DB::table('transaksi_details')
            ->join('produks', 'transaksi_details.produk_id', '=', 'produks.id')
            ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
            ->whereMonth('transaksis.created_at', Carbon::now()->month)
            ->select('produks.nama_produk', DB::raw('SUM(transaksi_details.qty) as total_qty'))
            ->groupBy('produks.id', 'produks.nama_produk')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();
        
        // Low stock products
        $produkStokRendah = Produk::where('stok', '<', 10)
            ->orderBy('stok', 'asc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalProduk',
            'totalKategori',
            'stokRendah',
            'transaksiHariIni',
            'pendapatanHariIni',
            'transaksiMingguIni',
            'totalKartu',
            'transaksiTerbaru',
            'produkTerlaris',
            'produkStokRendah'
        ));
    }
}
