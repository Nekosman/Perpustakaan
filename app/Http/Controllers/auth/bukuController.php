<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\buku;
use App\Models\kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class bukuController extends Controller
{
    public function getBooksData(){
        $data = Buku::all();
        return response([
            'message' => "Succes Get Data",
            'data' => $data
        ], 200);
    }

    public function getBooksName($judul = ""){
        $data = Buku::where('judul', 'LIKE', '%'.$judul.'%')->get();
        return response([
            'message' => "Succes Get Data",
            'data' => $data
        ], 200);
    }

    public function storeBooksData(Request $request) 
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:3000',
            'judul' => 'required',
            'pengarang_id' => 'required',
            'penerbit_id' => 'required',
            'tahun_terbit' => 'required|date',
            'stock' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $image = $request->file('image');
        $image->storeAs('public/bukus', $image->hashName());

        $buku = Buku::create([
            'image' => $image->hashName(),
            'judul' => $request->judul,
            'pengarang_id' => $request->pengarang_id,
            'penerbit_id' => $request->penerbit_id,
            'tahun_terbit' => $request->tahun_terbit,
            'stock' => $request->stock,
            'kategori_id' => $request->kategori_id
        ]);

        return response()->json([
            'message' => "Success Store Data",
            'data' => $buku
        ], 201);
    }
}
