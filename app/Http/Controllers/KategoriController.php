<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('categorys.index', compact('kategoris'));
    }

    public function create()
    {
        return view('categorys.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'required',
        ]);

        Kategori::create($request->all());

        return redirect()->route(Auth::user()->type == 'admin' ? 'admin/categorys' : 'petugas/categorys')
            ->with('success', 'Kategori created successfully.');
    }

    public function edit(Kategori $kategori)
    {
        return view('categorys.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'required',
        ]);

        $kategori->update($request->all());

        return redirect()->route(Auth::user()->type == 'admin' ? 'admin/categorys' : 'petugas/categorys')
            ->with('success', 'Kategori updated successfully.');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()->route(Auth::user()->type == 'admin' ? 'admin/categorys' : 'petugas/categorys')
            ->with('success', 'Kategori deleted successfully.');
    }
}
