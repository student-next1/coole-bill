<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        return view('produk.index');
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        // Logic untuk menyimpan produk
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        return view('produk.edit');
    }

    public function update(Request $request, $id)
    {
        // Logic untuk update produk
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        // Logic untuk hapus produk
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }
}
