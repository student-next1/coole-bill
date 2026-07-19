<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $kategori_id = $request->query('kategori_id');
        $perPage = 10;
        
        // Build query
        $query = Produk::with('kategori')->orderBy('created_at', 'desc');
        
        // Filter by kategori jika ada
        if ($kategori_id) {
            $query->where('kategori_id', $kategori_id);
        }
        
        // Get all kategoris for filter dropdown
        $kategoris = Kategori::orderBy('nama_kategori', 'asc')->get();
        
        // Paginate results
        $produks = $query->paginate($perPage);
        
        return view('produk.index', compact('produks', 'kategoris', 'kategori_id'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_produk' => 'required|unique:produks',
            'kode_barcode' => 'nullable|unique:produks',
            'nama_produk' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/produk'), $filename);
            $validated['foto'] = $filename;
        }

        Produk::create($validated);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all();
        return view('produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $validated = $request->validate([
            'kode_produk' => 'required|unique:produks,kode_produk,' . $id,
            'kode_barcode' => 'nullable|unique:produks,kode_barcode,' . $id,
            'nama_produk' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto if exists
            if ($produk->foto && file_exists(public_path('uploads/produk/' . $produk->foto))) {
                unlink(public_path('uploads/produk/' . $produk->foto));
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/produk'), $filename);
            $validated['foto'] = $filename;
        }

        $produk->update($validated);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        
        // Delete foto if exists
        if ($produk->foto && file_exists(public_path('uploads/produk/' . $produk->foto))) {
            unlink(public_path('uploads/produk/' . $produk->foto));
        }
        
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }
}
