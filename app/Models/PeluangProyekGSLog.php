<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeluangProyekGSLog extends Model
{
    protected $table = 'peluang_proyek_gs_logs';

    protected $fillable = [
        'peluang_proyek_gs_id',
        'user_id',
        'aksi',
        'data_lama',
        'data_baru',
    ];

    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array',
    ];

    public function peluang()
    {
        return $this->belongsTo(PeluangProyekGS::class);
    }
}
