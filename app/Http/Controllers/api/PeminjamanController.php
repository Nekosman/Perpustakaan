<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\buku;
use App\Models\Pinjam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $data = Pinjam::whereNotNull('status')
                      ->orWhereIn('status', ['disetujui', 'batalkan', 'tolak'])
                      ->get();
        return response()->json(['data' => $data], 200);
    }

    private function checkActiveLoans()
    {
        return Pinjam::where('user', Auth::user()->id)
            ->whereIn('status', ['disetujui'])
            ->orWhereNull('status')
            ->count();
    }

    public function store(Request $request, $id)
    {
        // Cek jumlah peminjaman aktif pengguna
        $BukuBatas = $this->checkActiveLoans();

        if ($BukuBatas >= 5) {
            return response()->json(['error' => 'Anda tidak dapat meminjam lebih dari 5 buku sekaligus.'], 403);
        }

        // Membatasi peminjaman 1 akun 1 buku dengan status 'disetujui'
        $BukuBatas = Pinjam::where('user', Auth::user()->id)
            ->where('buku', $id)
            ->where('status', 'pengajuan')
            ->first();

        if ($BukuBatas) {
            return response()->json(['error' => 'Anda sudah meminjam buku ini.'], 403);
        }

        // Cek ketersediaan stok buku
        $cek = DB::table('bukus')->where('id', $id)->where('stock', '>', 0)->count();
        if ($cek > 0) {
            DB::table('peminjaman')->insert([
                'buku' => $id,
                'user' => Auth::user()->id,
                'denda' => 0,
                'tangal_peminjaman' => null,
                'pengajuan' => Carbon::now(),
                'tanggal_pengembalian' => null,
                'status' => 'pengajuan'
            ]);

            return response()->json(['success' => 'Anda berhasil meminjam'], 200);
        } else {
            return response()->json(['error' => 'Buku Tidak Tersedia'], 404);
        }
    }

    public function accept($id)
    {
        $peminjaman = Pinjam::findOrFail($id);

        // Cek ketersediaan stok buku sebelum mengurangi
        $buku = DB::table('bukus')->where('id', $peminjaman->buku)->first();
        if ($buku->stock > 0) {
            // Update status peminjaman
            $peminjaman->status = 'disetujui';
            $peminjaman->tangal_peminjaman = Carbon::now()->toDateString();
            $peminjaman->tanggal_pengembalian = Carbon::now()->addDays(10);
            $peminjaman->save();

            // Kurangi stok buku
            $stock_baru = $buku->stock - 1;
            DB::table('bukus')->where('id', $peminjaman->buku)->update(['stock' => $stock_baru]);

            return response()->json(['success' => 'Peminjaman disetujui'], 200);
        } else {
            return response()->json(['error' => 'Stok buku tidak mencukupi'], 404);
        }
    }

    public function remove($id)
    {
        $peminjaman = Pinjam::findOrFail($id);
        $peminjaman->status = 'batalkan';
        $peminjaman->save();

        return response()->json(['error' => 'Peminjaman Dibatalkan'], 200);
    }

    public function tolak($id)
    {
        $item = Pinjam::find($id);

        if (!$item) {
            return response()->json(['error' => 'Peminjaman tidak ditemukan'], 404);
        }

        $item->status = 'tolak';
        $item->save();

        return response()->json(['error' => 'Peminjaman ditolak'], 200);
    }

    public function batal($id)
    {
        $item = Pinjam::find($id);

        if (!$item) {
            return response()->json(['error' => 'Peminjaman tidak ditemukan'], 404);
        }

        if ($item->status !== 'pengajuan') {
            return response()->json(['error' => 'Peminjaman hanya dapat dibatalkan jika statusnya pengajuan'], 403);
        }

        $id_buku = $item->buku;
        $buku = buku::find($id_buku);

        if (!$buku) {
            return response()->json(['error' => 'Buku tidak ditemukan'], 404);
        }

        $buku->stock += 1;
        $buku->save();

        $item->status = 'batal';
        $item->save();

        return response()->json(['success' => 'Peminjaman Dibatalkan'], 200);
    }

    public function peminjamanUser()
    {
        $data = Pinjam::with(['userss', 'bukus'])->where('user', Auth::user()->id)->get();
        return response()->json(['data' => $data], 200);
    }

    public function kembali($id)
    {
        $peminjaman = Pinjam::find($id);

        if (!$peminjaman) {
            return response()->json(['error' => 'Peminjaman tidak ditemukan'], 404);
        }

        if ($peminjaman->status !== 'disetujui') {
            return response()->json(['error' => 'Hanya peminjaman yang disetujui yang dapat dikembalikan'], 403);
        }

        $peminjaman->status = 'menunggu persetujuan';
        $peminjaman->tanggal_pengembalian = Carbon::now();
        $peminjaman->save();

        return response()->json(['success' => 'Pengembalian buku sedang menunggu persetujuan'], 200);
    }

    public function approveReturn($id)
    {
        $peminjaman = Pinjam::find($id);

        if (!$peminjaman) {
            return response()->json(['error' => 'Peminjaman tidak ditemukan'], 404);
        }

        if ($peminjaman->status !== 'menunggu persetujuan') {
            return response()->json(['error' => 'Hanya pengembalian yang menunggu persetujuan yang dapat disetujui'], 403);
        }

        $id_buku = $peminjaman->buku;
        $buku = Buku::find($id_buku);

        if (!$buku) {
            return response()->json(['error' => 'Buku tidak ditemukan'], 404);
        }

        $buku->stock += 1;
        $buku->save();

        $peminjaman->status = 'dikembalikan';
        $peminjaman->save();

        return response()->json(['success' => 'Pengembalian buku berhasil disetujui'], 200);
    }
}
