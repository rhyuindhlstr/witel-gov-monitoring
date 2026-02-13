<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = [
        'nama_pelanggan',
        'nama_pic',
        'alamat',
        'no_telepon',
        'email',
        'wilayah_id',
        'keterangan'
    ];

    // Relationships
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function kunjungan()
    {
        return $this->hasMany(KunjunganPelanggan::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(PembayaranPelanggan::class);
    }

    // Business Methods
    public function getTotalOutstanding()
    {
        return $this->pembayaran()
                    ->where('status_pembayaran', 'tertunda')
                    ->sum('nominal');
    }

    public function getTotalPaid()
    {
        return $this->pembayaran()
                    ->where('status_pembayaran', 'lancar')
                    ->sum('nominal');
    }

    public function getLastVisitDate()
    {
        $lastVisit = $this->kunjungan()
                          ->orderBy('tanggal_kunjungan', 'desc')
                          ->first();
        
        return $lastVisit ? $lastVisit->tanggal_kunjungan : null;
    }

    public function getVisitCount()
    {
        return $this->kunjungan()->count();
    }

    public function getPaymentStatus()
    {
        $overdue = $this->pembayaran()
                        ->where('status_pembayaran', 'tertunda')
                        ->where('tanggal_jatuh_tempo', '<', now())
                        ->count();
        
        if ($overdue > 0) {
            return 'overdue';
        }
        
        $outstanding = $this->getTotalOutstanding();
        if ($outstanding > 0) {
            return 'outstanding';
        }
        
        return 'clean';
    }

    // Scopes
    public function scopeWithOverduePayments($query)
    {
        return $query->whereHas('pembayaran', function ($q) {
            $q->where('status_pembayaran', 'tertunda')
              ->where('tanggal_jatuh_tempo', '<', now());
        });
    }

    public function scopeActiveCustomers($query)
    {
        return $query->whereHas('kunjungan', function ($q) {
            $q->where('tanggal_kunjungan', '>=', now()->subMonths(3));
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('nama_pelanggan', 'like', "%{$search}%")
                     ->orWhere('nama_pic', 'like', "%{$search}%")
                     ->orWhere('no_telepon', 'like', "%{$search}%");
    }
}
