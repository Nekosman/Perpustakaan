<?php

namespace App\Http\Controllers;

use App\Models\buku;
use App\Models\Pinjam;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function create($id)
    {
        $buku = Buku::findOrFail($id);
        $peminjaman = Pinjam::where('buku', $id)
                            ->where('user', Auth::id())
                            ->where('status', 'dikembalikan')
                            ->first();

        if (!$peminjaman) {
            return redirect()->back()->with('error', 'Anda belum mengembalikan buku ini.');
        }

        return view('ratings.create', compact('buku'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review' => 'nullable|string|max:1000',
        ]);

        Rating::create([
            'buku_id' => $id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->route('books.show', $id)->with('success', 'Rating dan review berhasil disimpan.');
    }
}
