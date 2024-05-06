<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $guarded = ['id'];

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];
    public function books()
    {
        return $this->hasMany(buku::class);
    }
}
