<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentCardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

route::get('/login',[BerandaController::class,'login'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/dashboard', function () {
    return view('dashboard.index');
// })->middleware('auth')
})->name('dashboard');

// Produk Routes
Route::prefix('produk')->middleware('auth')->group(function () {
    Route::get('/', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
});

// Kategori Routes
Route::prefix('kategori')->middleware('auth')->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
});

// Transaksi Routes
Route::prefix('transaksi')->middleware('auth')->group(function () {
    Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/select-payment', [TransaksiController::class, 'selectPaymentMethod'])->name('transaksi.select-payment');
    Route::get('/select-card', [TransaksiController::class, 'selectCard'])->name('transaksi.select-card');
    Route::get('/find-card', [TransaksiController::class, 'findCard'])->name('transaksi.find-card');
    Route::get('/confirm-payment/{cardId}', [TransaksiController::class, 'confirmPayment'])->name('transaksi.confirm-payment');
    Route::get('/receipt/{id}', [TransaksiController::class, 'receipt'])->name('transaksi.receipt');
    Route::post('/', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::post('/delete-all', [TransaksiController::class, 'deleteAll'])->name('transaksi.delete-all')->middleware('auth');
});

// Laporan Routes
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index')->middleware('auth');

// User Management Routes (Admin only)
Route::prefix('users')->middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Payment Cards Routes
Route::prefix('payment-cards')->middleware('auth')->group(function () {
    Route::get('/', [PaymentCardController::class, 'index'])->name('payment-cards.index');
    Route::get('/create', [PaymentCardController::class, 'create'])->name('payment-cards.create');
    Route::post('/', [PaymentCardController::class, 'store'])->name('payment-cards.store');
    Route::get('/{id}', [PaymentCardController::class, 'show'])->name('payment-cards.show');
    Route::get('/{id}/edit', [PaymentCardController::class, 'edit'])->name('payment-cards.edit');
    Route::put('/{id}', [PaymentCardController::class, 'update'])->name('payment-cards.update');
    Route::delete('/{id}', [PaymentCardController::class, 'destroy'])->name('payment-cards.destroy');
    Route::get('/{id}/topup', [PaymentCardController::class, 'topup'])->name('payment-cards.topup');
    Route::post('/{id}/topup', [PaymentCardController::class, 'doTopup'])->name('payment-cards.do-topup');
    Route::get('/{id}/transactions', [PaymentCardController::class, 'transactions'])->name('payment-cards.transactions');
    Route::get('/search/card', [PaymentCardController::class, 'search'])->name('payment-cards.search');
});

Route::post('/logout', function () {
    Auth::logout();
    // $request->session()->invalidate();
    // $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

?>
