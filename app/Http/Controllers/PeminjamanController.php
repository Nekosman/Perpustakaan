<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Pinjam;

class PeminjamanController extends Controller
{

    

    public function index()
{
    $title = 'Halaman Peminjaman Buku';
    $data = Pinjam::whereNotNull('status')
                  ->orWhereIn('status', ['disetujui', 'batalkan', 'tolak'])
                  ->get();
    return view('pinjam.index', compact('title', 'data'));
}

    private function checkActiveLoans()
    {
        return Pinjam::where('user', Auth::user()->id)
            ->whereIn('status', ['disetujui'])
            ->orWhereNull('status')
            ->count();
    }

    public function store($id)
    {
        // if (!Auth::check()) {
        //     return redirect()->route('account.login')->with('error', 'Anda harus login untuk meminjam buku');
        // }
    
        // Cek jumlah peminjaman aktif pengguna
        $BukuBatas = $this->checkActiveLoans();
    
        if ($BukuBatas >= 5) {
            return redirect()->back()->with('gagal', 'Anda tidak dapat meminjam lebih dari 5 buku sekaligus.');
        }
    
        // Membatasi peminjaman 1 akun 1 buku dengan status 'disetujui'
        $BukuBatas = Pinjam::where('user', Auth::user()->id)
            ->where('buku', $id)
            ->where('status', 'disetujui')
            ->first();
    
        if ($BukuBatas) {
            return redirect()->back()->with('gagal', 'Anda sudah meminjam buku ini.');
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
            return redirect()->back()->with('success', 'Anda berhasil meminjam');
        } else {
            return redirect()->back()->with('gagal', 'Buku Tidak Tersedia');
        }
    }
    


public function accept($id)
{
    $peminjaman = Pinjam::findOrFail($id);
    $peminjaman->status = 'disetujui';
    $peminjaman->tangal_peminjaman = Carbon::now()->toDateString();
    $peminjaman->tanggal_pengembalian = Carbon::now()->addDays(10);
    $peminjaman->save();

    return redirect()->back()->with('success', 'Peminjaman disetujui');
}

    public function remove($id)
    {
        $peminjaman = Pinjam::findOrFail($id);
        $peminjaman->status = 'batalkan';
        $peminjaman->save();

        return redirect()->back()->with('error', 'Peminjaman Dibatalkan');
    }

    public function tolak($id)
{
    $item = Pinjam::find($id);

    if (!$item) {
        return redirect()->back()->with('error', 'Peminjaman tidak ditemukan');
    }

    $id_buku = $item->buku;

    $buku = Buku::find($id_buku);

    if (!$buku) {
        return redirect()->back()->with('error', 'Buku tidak ditemukan');
    }

    $buku->stock += 1;
    $buku->save();

    $item->status = 'tolak';
    $item->save();

    return redirect()->back()->with('error', 'Peminjaman ditolak');
}


public function batal($id)
{
    $item = Pinjam::find($id);

    if (!$item) {
        return redirect()->back()->with('error', 'Peminjaman tidak ditemukan');
    }

    // Hanya izinkan pembatalan jika status peminjaman adalah 'pengajuan'
    if ($item->status !== 'pengajuan') {
        return redirect()->back()->with('error', 'Peminjaman hanya dapat dibatalkan jika statusnya pengajuan');
    }

    $id_buku = $item->buku;

    $buku = Buku::find($id_buku);

    if (!$buku) {
        return redirect()->back()->with('error', 'Buku tidak ditemukan');
    }

    $buku->stock += 1;
    $buku->save();

    $item->status = 'batal';
    $item->save();

    return redirect()->back()->with('success', 'Peminjaman Dibatalkan');
}


    public function PeminjamanUser()
    {
        $data = Pinjam::with(['userss', 'bukus'])->where('user',  (Auth::user()->id))->get();
        // dd($data);
        return view('pinjam.peminjaman_user', ['data' => $data]);
    }

    public function kembali($id)
    {
        $peminjaman = Pinjam::find($id);
    
        if (!$peminjaman) {
            return redirect()->back()->with('error', 'Peminjaman tidak ditemukan');
        }
    
        if ($peminjaman->status !== 'disetujui') {
            return redirect()->back()->with('error', 'Hanya peminjaman yang disetujui yang dapat dikembalikan');
        }
    
        $id_buku = $peminjaman->buku;
        $buku = Buku::find($id_buku);
    
        if (!$buku) {
            return redirect()->back()->with('error', 'Buku tidak ditemukan');
        }
    
        $buku->stock += 1;
        $buku->save();
    
        $peminjaman->status = 'dikembalikan';
        $peminjaman->tanggal_pengembalian = Carbon::now();
        $peminjaman->save();
    
        return redirect()->back()->with('success', 'Buku berhasil dikembalikan');
    }

    
    
}