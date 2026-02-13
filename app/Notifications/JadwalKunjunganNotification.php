<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JadwalKunjunganNotification extends Notification
{
    use Queueable;

    public $kunjungan;

    /**
     * Create a new notification instance.
     */
    public function __construct($kunjungan)
    {
        $this->kunjungan = $kunjungan;
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
        return [
            'type' => 'primary',
            'icon' => 'bi-calendar-event-fill',
            'title' => 'Jadwal Kunjungan',
            'message' => "Anda memiliki jadwal {$this->kunjungan->metode} ke {$this->kunjungan->pelanggan->nama_pelanggan} pada " . \Carbon\Carbon::parse($this->kunjungan->tanggal_kunjungan)->format('d M Y'),
            'action_url' => route('kunjungan.show', $this->kunjungan->id),
        ];
    }
}
