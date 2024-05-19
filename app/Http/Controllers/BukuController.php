<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Pengarang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::all();
        return view('books.index', compact('bukus'));
    }

    public function create()
    {
        $penerbits = Penerbit::all();
        $pengarangs = Pengarang::all();
        $kategoris = Kategori::all();

        return view('books.create', compact('penerbits', 'pengarangs', 'kategoris'));
    }

    public function store(Request $request) : RedirectResponse
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:3000',
            'judul' => 'required',
            'pengarang_id' => 'required',
            'penerbit_id' => 'required',
            'tahun_terbit' => 'required',
            'kategori_id' => 'required',
        ]);

        $image = $request->file('image');
        $image->storeAs('public/bukus', $image->hashName());

        Buku::create([
            'image' => $image->hashName(),
            'judul' => $request->judul,
            'pengarang_id' => $request->pengarang_id,
            'penerbit_id' => $request->penerbit_id,
            'tahun_terbit' => $request->tahun_terbit,
            'kategori_id' => $request->kategori_id
        ]);

        return redirect()->route('admin/books')
            ->with('success', 'Buku created successfully.');
    }

    public function edit(Buku $buku)
    {
        $penerbits = Penerbit::all();
        $pengarangs = Pengarang::all();
        $kategoris = Kategori::all();
    
        return view('books.edit', compact('buku', 'penerbits', 'pengarangs', 'kategoris'));
    }

    public function update(Request $request, $id) : RedirectResponse
    {
        $this->validate($request, [
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:30000',
            'judul' => 'required',
            'pengarang_id' => 'required',
            'penerbit_id' => 'required',
            'tahun_terbit' => 'required',
            'kategori_id' => 'required',
        ]);

        $buku = Buku::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/bukus', $image->hashName());
            Storage::delete('public/bukus/'.$buku->image);

            $buku->update([
                'image' => $image->hashName(),
                'judul' => $request->judul,
                'pengarang_id' => $request->pengarang_id,
                'penerbit_id' => $request->penerbit_id,
                'tahun_terbit' => $request->tahun_terbit,
                'kategori_id' => $request->kategori_id
            ]);
        } else {
            $buku->update([
                'judul' => $request->judul,
                'pengarang_id' => $request->pengarang_id,
                'penerbit_id' => $request->penerbit_id,
                'tahun_terbit' => $request->tahun_terbit,
                'kategori_id' => $request->kategori_id
            ]);
        }

        return redirect()->route('books/books')
            ->with('success', 'Buku updated successfully');
    }

    public function destroy(Buku $buku)
    {
        Storage::delete('public/bukus/'.$buku->image);
        $buku->delete();

        return redirect()->route('admin/books')
            ->with('success', 'Buku deleted successfully');
    }
}
