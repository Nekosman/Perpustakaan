<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Pinjam;

class PeminjamanController extends Controller
{
    private function checkActiveLoans()
    {
        return Pinjam::where('user', Auth::user()->id)
                     ->whereIn('status', ['disetujui'])
                     ->orWhereNull('status')
                     ->count();
    }

    public function store($id)
    {
        // Cek jumlah peminjaman aktif pengguna
        $BukuBatas = $this->checkActiveLoans();
    
        if ($BukuBatas >= 5) {
            return response()->json(['gagal' => 'Anda tidak dapat meminjam lebih dari 5 buku sekaligus.'], 403);
        }
    
        // Membatasi peminjaman 1 akun 1 buku dengan status 'disetujui'
        $BukuBatas = Pinjam::where('user', Auth::user()->id)
                           ->where('buku', $id)
                           ->where('status', 'disetujui')
                           ->first();
    
        if ($BukuBatas) {
            return response()->json(['gagal' => 'Anda sudah meminjam buku ini.'], 403);
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
                'status' => 'pengajuan' // Set status here
            ]);
    
            $buku = DB::table('bukus')->where('id', $id)->first();
            $stock_baru = $buku->stock - 1;
    
            DB::table('bukus')->where('id', $id)->update(['stock' => $stock_baru]);
            return response()->json(['success' => 'Anda berhasil meminjam']);
        } else {
            return response()->json(['gagal' => 'Buku Tidak Tersedia'], 404);
        }
    }

    public function batal($id)
    {
        $item = Pinjam::find($id);

        if (!$item) {
            return response()->json(['error' => 'Peminjaman tidak ditemukan'], 404);
        }

        // Hanya izinkan pembatalan jika status peminjaman adalah 'pengajuan'
        if ($item->status !== 'pengajuan') {
            return response()->json(['error' => 'Peminjaman hanya dapat dibatalkan jika statusnya pengajuan'], 403);
        }

        $id_buku = $item->buku;
        $buku = Buku::find($id_buku);

        if (!$buku) {
            return response()->json(['error' => 'Buku tidak ditemukan'], 404);
        }

        $buku->stock += 1;
        $buku->save();

        $item->status = 'batal';
        $item->save();

        return response()->json(['success' => 'Peminjaman Dibatalkan']);
    }

    public function peminjamanUser()
    {
        $data = Pinjam::with(['userss', 'bukus'])->where('user', Auth::user()->id)->get();
        return response()->json(['data' => $data]);
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
    
        $id_buku = $peminjaman->buku;
        $buku = Buku::find($id_buku);
    
        if (!$buku) {
            return response()->json(['error' => 'Buku tidak ditemukan'], 404);
        }
    
        $buku->stock += 1;
        $buku->save();
    
        $peminjaman->status = 'dikembalikan';
        $peminjaman->tanggal_pengembalian = Carbon::now();
        $peminjaman->save();
    
        return response()->json(['success' => 'Buku berhasil dikembalikan']);
    }
}
