<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class member extends Model
{
    use HasFactory;

    protected $primaryKey = 'ktp';

    public $incrementing = false;

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];
    public function member()
    {
        return $this->hasMany(member::class, 'foreign key');
    }
}
