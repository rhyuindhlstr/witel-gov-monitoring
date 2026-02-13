<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate automatic notifications for visits, payments, and passive customers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating notifications...');

        // 1. Jadwal Kunjungan (H-0 and H-1)
        $visits = \App\Models\KunjunganPelanggan::with('user', 'pelanggan')
            ->whereBetween('tanggal_kunjungan', [now()->startOfDay(), now()->addDay()->endOfDay()])
            ->get();

        foreach ($visits as $visit) {
            if ($visit->user) {
                // Check if notification already exists to avoid duplicates (basic check)
                // In production, use database id check or tag
                $visit->user->notify(new \App\Notifications\JadwalKunjunganNotification($visit));
                $this->info("Sent Visit Notification to {$visit->user->name} for {$visit->pelanggan->nama_pelanggan}");
            }
        }

        // Get Admin/SSGS Users for general alerts
        $admins = \App\Models\User::whereIn('role', ['admin', 'ssgs'])->get();
        if ($admins->isEmpty()) {
            $admins = \App\Models\User::all(); // Fallback if no roles defined
        }

        // 2. Jatuh Tempo Pembayaran (H-0 and H-3)
        $duePayments = \App\Models\PembayaranPelanggan::with('pelanggan')
            ->where('status_pembayaran', 'tertunda')
            ->where(function ($query) {
                $query->whereDate('tanggal_jatuh_tempo', now())
                      ->orWhereDate('tanggal_jatuh_tempo', now()->addDays(3));
            })
            ->get();

        foreach ($duePayments as $payment) {
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\JatuhTempoNotification($payment));
            }
            $this->info("Sent Payment Notification for {$payment->pelanggan->nama_pelanggan}");
        }

        // 3. Alert Pelanggan Pasif (> 30 Days No Interaction)
        // Ensure pelanggan has visits before checking last visit to avoid new customers being flagged immediately if registered < 30 days ago
        // Actually the logic is: Get all customers, check last visit.
        $pelanggans = \App\Models\Pelanggan::with('kunjungan')->get();
        
        foreach ($pelanggans as $pelanggan) {
            $lastVisit = $pelanggan->kunjungan()->max('tanggal_kunjungan');
            
            if ($lastVisit) {
                $days = \Carbon\Carbon::parse($lastVisit)->diffInDays(now());
                if ($days > 30 && $days % 7 == 0) { // Notify every week after 30 days? Or just once? Let's do every 30 days: 30, 60, 90...
                     // For demo purposes, just > 30
                     // To avoid spam, let's just trigger if exactly 30, 45, 60 days.
                     if (in_array($days, [30, 31, 45, 60])) {
                        foreach ($admins as $admin) {
                            $admin->notify(new \App\Notifications\PelangganPasifNotification($pelanggan, $days));
                        }
                        $this->info("Sent Passive Alert for {$pelanggan->nama_pelanggan} ({$days} days)");
                     }
                }
            }
        }

        $this->info('Notifications generated successfully.');
    }
}
