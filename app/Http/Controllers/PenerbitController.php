<?php

namespace App\Http\Controllers;

use App\Models\penerbit;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    public function index()
    {
        $penerbits = Penerbit::all();
        return view('publisher.index', compact('penerbits'));
    }

    public function create()
    {
        return view('publisher.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_penerbit' => 'required',
            'alamat' => 'required'
        ]);

       Penerbit::create($request->all());

       return redirect()-> route('admin/publishers')->with('success', 'penerbit Created successfully');
    }

    public function edit(Penerbit $penerbit)
    {
        return view('publisher.edit', compact('penerbit'));
    }

    public function update(Request $request, Penerbit $penerbit)
    {
        $request->validate([
            'nama_penerbit' => 'required',
            'alamat' => 'required',
        ]);

        $penerbit->update($request->all());

        return redirect()->route('admin/publishers')
            ->with('success', 'penerbit updated successfully.');
    }

    public function destroy(Penerbit $penerbit)
    {
        $penerbit->delete();

        return redirect()->route('admin/publishers')
            ->with('success', 'Kategori deleted successfully.');
    }
    
}
