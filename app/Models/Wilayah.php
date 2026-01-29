<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_wilayah',
        'keterangan',
        'code',
    ];

    // relasi ke peluang (opsional, tapi penting buat dashboard)
    public function peluangProyekGS()
    {
        return $this->hasMany(PeluangProyekGS::class);
    }
}
