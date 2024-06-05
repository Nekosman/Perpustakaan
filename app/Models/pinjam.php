<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    public function bukus()
    {
        return $this->belongsTo('App\Models\buku','buku');
    }

    public function userss()
    {
        return $this->belongsTo('App\Models\User','user');
    }

}
