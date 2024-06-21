<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class buku extends Model
{
    use HasFactory;
    protected $table = 'bukus';
    protected $fillable = [
        'image',
        'judul',
        'penerbit_id',
        'pengarang_id',
        'tahun_terbit',
        'kategori_id',
        'stock'
    ];

    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'penerbit_id');
    }

    public function pengarang()
    {
        return $this->belongsTo(Pengarang::class, 'pengarang_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    public function pinjaman()
    {
        return $this->hasOne(Pinjam::class, 'buku')->where('user', Auth::id())->latest();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }


}
