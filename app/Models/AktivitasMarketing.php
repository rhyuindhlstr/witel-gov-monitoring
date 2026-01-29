<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitasMarketing extends Model
{
    use HasFactory;

    protected $table = 'aktivitas_marketing';

    protected $fillable = [
        'peluang_proyek_gs_id',
        'tanggal',
        'jenis_aktivitas',
        'hasil',
        'keterangan',
    ];

    public function peluang()
    {
        return $this->belongsTo(PeluangProyekGS::class, 'peluang_proyek_gs_id');
    }
}
