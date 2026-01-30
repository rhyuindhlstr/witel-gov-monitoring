<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JatuhTempoNotification extends Notification
{
    use Queueable;

    public $pembayaran;

    /**
     * Create a new notification instance.
     */
    public function __construct($pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $days = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($this->pembayaran->tanggal_jatuh_tempo), false);
        $daysText = $days == 0 ? 'HARI INI' : ($days > 0 ? "dalam {$days} hari" : "lewat {$days} hari");

        return [
            'type' => 'warning',
            'icon' => 'bi-exclamation-circle-fill',
            'title' => 'Jatuh Tempo Pembayaran',
            'message' => "Tagihan {$this->pembayaran->pelanggan->nama_pelanggan} sebesar Rp " . number_format($this->pembayaran->nominal, 0, ',', '.') . " jatuh tempo {$daysText}.",
            'action_url' => route('pembayaran.show', $this->pembayaran->id),
        ];
    }
}
