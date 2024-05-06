<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penerbit extends Model
{
    use HasFactory;

    protected $table = 'penerbits';

    protected $guarded = ['id'];

    protected $fillable = [
        'nama_penerbit',
        'alamat',
    ];

    public function books()
    {
        return $this->hasMany(buku::class);
    }
}
