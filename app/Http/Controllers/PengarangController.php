<?php

namespace App\Http\Controllers;

use App\Models\penerbit;
use Illuminate\Http\Request;

use App\Models\pengarang;
use Illuminate\Support\Facades\Auth;

class PengarangController extends Controller
{
    public function index()
    {
        $pengarangs = Pengarang::all();
        return view('pengarang.index', compact('pengarangs'));
    }

    public function create()
    {
        return view('pengarang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_penulis' => 'required',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
        ]);

        Pengarang::create($request->all());

        return redirect()->route(Auth::user()->type== 'admin' ? 'admin/authors' : 'petugas/authors')
            ->with('success', 'Kategori created successfully.');
    }

    public function edit(pengarang $pengarang)
    {
        return view('pengarang.edit', compact('pengarang'));
    }

    public function update(Request $request, Pengarang $pengarang)
    {
        $request->validate([
            'nama_penulis' => 'required',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
        ]);

        $pengarang->update($request->all());

        return redirect()->route(Auth::user()->type== 'admin' ? 'admin/authors' : 'petugas/authors')
            ->with('success', 'pengarang updated successfully.');
    }

    public function destroy(Pengarang $pengarang)
    {
        $pengarang->delete();

        return redirect()->route(Auth::user()->type== 'admin' ? 'admin/authors' : 'petugas/authors')
            ->with('success', 'Penerbit deleted successfully.');
    }
}
