<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukApiController extends Controller
{
    /**
     * Get all products
     */
    public function index(Request $request)
    {
        $query = Produk::with('kategori');

        // Filter by kategori
        if ($request->has('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Search by name or barcode
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        // Filter by stock status
        if ($request->has('low_stock') && $request->low_stock == 'true') {
            $query->where('stok', '<=', 5);
        }

        $produks = $query->orderBy('nama', 'asc')->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'message' => 'Data produk berhasil diambil',
            'data' => $produks->items(),
            'meta' => [
                'current_page' => $produks->currentPage(),
                'last_page' => $produks->lastPage(),
                'per_page' => $produks->perPage(),
                'total' => $produks->total(),
            ]
        ], 200);
    }

    /**
     * Get single product
     */
    public function show($id)
    {
        $produk = Produk::with('kategori')->find($id);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data produk berhasil diambil',
            'data' => $produk
        ], 200);
    }

    /**
     * Create new product
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'barcode' => 'nullable|string|unique:produks,barcode',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $produk = Produk::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan',
            'data' => $produk->load('kategori')
        ], 201);
    }

    /**
     * Update product
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|required|string|max:255',
            'kategori_id' => 'sometimes|required|exists:kategoris,id',
            'harga' => 'sometimes|required|numeric|min:0',
            'stok' => 'sometimes|required|integer|min:0',
            'barcode' => 'nullable|string|unique:produks,barcode,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $produk->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diupdate',
            'data' => $produk->load('kategori')
        ], 200);
    }

    /**
     * Delete product
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        $produk->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus'
        ], 200);
    }
}
