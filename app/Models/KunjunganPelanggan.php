<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KunjunganPelanggan extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'user_id',
        'metode', // visit, call, whatsapp
        'tanggal_kunjungan',
        'tujuan',
        'hasil_kunjungan'
    ];

    public function getMetodeBadgeAttribute()
    {
        return match($this->metode) {
            'visit' => 'primary',
            'call' => 'info',
            'whatsapp' => 'success',
            default => 'secondary'
        };
    }

    public function getMetodeIconAttribute()
    {
        return match($this->metode) {
            'visit' => 'bi-geo-alt',
            'call' => 'bi-telephone',
            'whatsapp' => 'bi-whatsapp',
            default => 'bi-circle'
        };
    }

    protected $casts = [
        'tanggal_kunjungan' => 'date'
    ];

    // Relationships
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeByPelanggan($query, $pelangganId)
    {
        return $query->where('pelanggan_id', $pelangganId);
    }

    public function scopeByDateRange($query, $start, $end)
    {
        return $query->whereBetween('tanggal_kunjungan', [$start, $end]);
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('tanggal_kunjungan', 'desc')->limit($limit);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
