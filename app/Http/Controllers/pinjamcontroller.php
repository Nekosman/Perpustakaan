<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Member;
use App\Models\Penerbit;
use App\Models\Pengarang;
use App\Models\Pinjam;
use Illuminate\Http\Request;

class PinjamController extends Controller
{
    public function input()
    {
        $member = Member::all();
        $buku = Buku::all();
        return view('input_pinjam', compact('member', 'buku'));
    }

    public function kirim(Request $request)
    {
        $validateData = $request->validate([
            'id_buku' => 'required',
            'id_member' => 'required',
            'tanggal_peminjaman' => 'required',
            'tanggal_pengembalian' => 'required',
            'jenis' => 'required'
        ]);

        $id_member = $request->id_member;
        $data = Member::find($id_member);
        $nama_member = $data->nama; // Perbaiki variabel ini
        $id_buku = $request->id_buku;
        $item = Buku::find($id_buku);
        $judul_buku = $item->judul; // Jika judul buku disimpan dalam kolom 'judul'

        Pinjam::create([
            'id_buku' => $validateData['id_buku'],
            'id_member' => $validateData['id_member'],
            'nama_member' => $nama_member, // Perbaiki penulisan variabel
            'judul_buku' => $judul_buku,
            'tanggal_peminjaman' => $validateData['tanggal_peminjaman'],
            'tanggal_pengembalian' => $validateData['tanggal_pengembalian'],
            'jenis' => $validateData['jenis'],
        ]);
        return redirect('tampil_pinjam')->with('status', 'Data peminjaman berhasil dimasukkan');
    }

    public function tampil()
    {
        $model = new Pinjam;
        $data = $model->all();
        return view('tampil_pinjam', ['data' => $data]);
    }

    public function delete($id_buku)
    {
        $model = Pinjam::find($id_buku);
        $model->delete();
        return redirect('tampil_pinjam')->with('status-deleted', 'Data peminjaman telah dihapus');
    }

    public function edit($id)
    {
        $member = Member::all();
        $buku = Buku::all();
        $model = Pinjam::find($id);
        return view('peminjam.edit', [
            'post' => $model,
            'member' => $member,
            'buku' => $buku,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'id_buku' => 'required',
            'id_member' => 'required',
            'tanggal_peminjaman' => 'required',
            'tanggal_pengembalian' => 'required',
            'jenis' => 'required',
        ]);

        $model = Pinjam::find($id); // Perbaiki pengambilan instance model
        $id_member = $request->id_member;
        $data = Member::find($id_member);
        $nama_member = $data->nama;
        $id_buku = $request->id_buku;
        $item = Buku::find($id_buku);
        $judul_buku = $item->judul;

        $model->update([
            'id_buku' => $validateData['id_buku'],
            'id_member' => $validateData['id_member'],
            'nama_member' => $nama_member,
            'judul_buku' => $judul_buku,
            'tanggal_peminjaman' => $validateData['tanggal_peminjaman'],
            'tanggal_pengembalian' => $validateData['tanggal_pengembalian'],
            'jenis' => $validateData['jenis'],
        ]);
        return redirect('tampil_pinjam')->with('status', 'Data peminjaman telah diupdate');
    }
}
