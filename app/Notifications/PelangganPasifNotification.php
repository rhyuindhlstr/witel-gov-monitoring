<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PelangganPasifNotification extends Notification
{
    use Queueable;

    public $pelanggan;
    public $days;

    /**
     * Create a new notification instance.
     */
    public function __construct($pelanggan, $days)
    {
        $this->pelanggan = $pelanggan;
        $this->days = $days;
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
            'type' => 'danger',
            'icon' => 'bi-bell-fill',
            'title' => 'Alert Pelanggan Pasif',
            'message' => "{$this->pelanggan->nama_pelanggan} belum dikunjungi dalam {$this->days} hari terakhir.",
            'action_url' => route('pelanggan.show', $this->pelanggan->id),
        ];
    }
}
