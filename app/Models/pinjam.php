<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    use HasFactory;

    protected $table = 'peminjam';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'id_buku',
        'id_member',
        'tanggal_peminjaman', // tambahkan koma di sini
        'tanggal_pengembalian', // tambahkan koma di sini
        'jenis', // tambahkan koma di sini
    ];
}
