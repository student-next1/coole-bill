<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ProdukApiController;
use App\Http\Controllers\Api\KategoriApiController;
use App\Http\Controllers\Api\TransaksiApiController;
use App\Http\Controllers\Api\UserApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::prefix('v1')->group(function () {
    // Authentication
    Route::post('/login', [AuthApiController::class, 'login']);
});

// Protected routes (require authentication)
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    
    // Auth routes
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/me', [AuthApiController::class, 'me']);

    // Products routes
    Route::get('/products', [ProdukApiController::class, 'index']);
    Route::get('/products/{id}', [ProdukApiController::class, 'show']);
    Route::post('/products', [ProdukApiController::class, 'store']);
    Route::put('/products/{id}', [ProdukApiController::class, 'update']);
    Route::patch('/products/{id}', [ProdukApiController::class, 'update']);
    Route::delete('/products/{id}', [ProdukApiController::class, 'destroy']);

    // Categories routes
    Route::get('/categories', [KategoriApiController::class, 'index']);
    Route::get('/categories/{id}', [KategoriApiController::class, 'show']);
    Route::post('/categories', [KategoriApiController::class, 'store']);
    Route::put('/categories/{id}', [KategoriApiController::class, 'update']);
    Route::patch('/categories/{id}', [KategoriApiController::class, 'update']);
    Route::delete('/categories/{id}', [KategoriApiController::class, 'destroy']);

    // Transactions routes
    Route::get('/transactions', [TransaksiApiController::class, 'index']);
    Route::get('/transactions/{id}', [TransaksiApiController::class, 'show']);
    Route::post('/transactions', [TransaksiApiController::class, 'store']);
    Route::get('/transactions/statistics/summary', [TransaksiApiController::class, 'statistics']);

    // Users routes (Admin only for create, update, delete)
    Route::get('/users', [UserApiController::class, 'index']);
    Route::get('/users/{id}', [UserApiController::class, 'show']);
    Route::post('/users', [UserApiController::class, 'store']);
    Route::put('/users/{id}', [UserApiController::class, 'update']);
    Route::patch('/users/{id}', [UserApiController::class, 'update']);
    Route::delete('/users/{id}', [UserApiController::class, 'destroy']);
});

// Fallback for undefined routes
Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Endpoint tidak ditemukan'
    ], 404);
});
