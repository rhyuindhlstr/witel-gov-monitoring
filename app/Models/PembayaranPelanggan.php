<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranPelanggan extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'tanggal_pembayaran',
        'tanggal_jatuh_tempo',
        'nominal',
        'status_pembayaran',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'nominal' => 'decimal:2'
    ];

    // Relationships
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // Accessors
    public function getFormattedNominalAttribute()
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }

    // Business Methods
    public function isOverdue()
    {
        return $this->status_pembayaran === 'tertunda' 
               && $this->tanggal_jatuh_tempo 
               && $this->tanggal_jatuh_tempo->isPast();
    }

    public function getStatusBadgeColorAttribute()
    {
        if ($this->isOverdue()) {
            return 'danger';
        }
        
        return $this->status_pembayaran === 'lancar' ? 'success' : 'warning';
    }

    public function getDaysOverdueAttribute()
    {
        if (!$this->isOverdue()) {
            return 0;
        }
        
        return (int) abs(now()->diffInDays($this->tanggal_jatuh_tempo, false));
    }

    // Scopes
    public function scopeTertunda($query)
    {
        return $query->where('status_pembayaran', 'tertunda');
    }

    public function scopeLancar($query)
    {
        return $query->where('status_pembayaran', 'lancar');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status_pembayaran', 'tertunda')
                     ->where('tanggal_jatuh_tempo', '<', now());
    }

    public function scopeByPelanggan($query, $pelangganId)
    {
        return $query->where('pelanggan_id', $pelangganId);
    }

    public function scopeByDateRange($query, $start, $end)
    {
        return $query->whereBetween('tanggal_pembayaran', [$start, $end]);
    }

    public function scopeUpcoming($query, $days = 7)
    {
        return $query->where('status_pembayaran', 'tertunda')
                     ->whereBetween('tanggal_jatuh_tempo', [now(), now()->addDays($days)]);
    }
}
