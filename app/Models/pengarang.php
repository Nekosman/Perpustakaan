<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengarang extends Model
{
    use HasFactory;

    protected $table = 'pengarangs';

    protected $guarded = ['id'];

    protected $fillable = ['nama_penulis', 
                            'tgl_lahir', 
                            'jenis_kelamin', ];

    public static function genderOptions()
    {
        return[
            'L' => 'Laki-laki',
            'P' => 'Wanita',
        ];
    }
}
