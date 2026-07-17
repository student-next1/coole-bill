<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Logic untuk menyimpan user
        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        return view('users.edit');
    }

    public function update(Request $request, $id)
    {
        // Logic untuk update user
        return redirect()->route('users.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        // Logic untuk hapus user
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}
