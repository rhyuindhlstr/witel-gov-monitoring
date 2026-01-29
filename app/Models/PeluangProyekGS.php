<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PeluangProyekGSLog;


class PeluangProyekGS extends Model
{
    use HasFactory;

    protected $table = 'peluang_proyek_gs';

    protected $fillable = [
        'wilayah_id',
        'id_am',
        'nama_am',
        'nama_gc',
        'satker',
        'judul_proyek',
        'jenis_layanan',
        'jenis_proyek',
        'nilai_estimasi',
        'nilai_realisasi',
        'nilai_scaling',
        'status_mytens',
        'status_proyek',
        'mekanisme_pengadaan',
        'start_pelaksanaan',
        'end_pelaksanaan',
        'keterangan',
        'tanggal_input',
    ];

    /* ===============================
     * RELATION
     * =============================== */

    public function wilayah()
    {
        return $this->belongsTo(
            \App\Models\WilayahGS::class,
            'wilayah_id'
        );
    }

    public function aktivitasMarketing()
    {
        return $this->hasMany(
            \App\Models\AktivitasMarketing::class,
            'peluang_proyek_gs_id'
        );
    }


    public function logs()
{
    return $this->hasMany(PeluangProyekGSLog::class);
}

}
