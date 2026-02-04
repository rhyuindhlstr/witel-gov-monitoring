<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WilayahGS extends Model
{
    protected $table = 'wilayah_g_s';

    protected $fillable = [
        'nama_wilayah',
        'keterangan',
    ];

    public function peluangProyekGS()
    {
        return $this->hasMany(PeluangProyekGS::class, 'wilayah_id');
    }
}
