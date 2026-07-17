<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return view('kategori.index');
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        // Logic untuk menyimpan kategori
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        return view('kategori.edit');
    }

    public function update(Request $request, $id)
    {
        // Logic untuk update kategori
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        // Logic untuk hapus kategori
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
