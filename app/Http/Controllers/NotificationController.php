<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the notifications.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // For now, we are using static dummy data consistent with the dropdown
        $notifications = [
            [
                'type' => 'warning',
                'icon' => 'bi-exclamation-circle-fill',
                'title' => 'Jatuh Tempo Pembayaran',
                'message' => 'Tagihan Dinas Pendidikan akan jatuh tempo dalam 3 hari (25 Jan 2026).',
                'time' => '2 hours ago',
                'read' => false,
                'action_url' => route('pembayaran.show', 1),
            ],
            [
                'type' => 'primary',
                'icon' => 'bi-calendar-event-fill',
                'title' => 'Jadwal Kunjungan',
                'message' => 'Anda memiliki jadwal kunjungan ke Dinas Kesehatan pukul 10:00 WIB.',
                'time' => '5 hours ago',
                'read' => false,
                'action_url' => route('kunjungan.show', 1),
            ],
            [
                'type' => 'success',
                'icon' => 'bi-check-circle-fill',
                'title' => 'Pembayaran Diterima',
                'message' => 'Pembayaran dari Dinas PU sebesar Rp 50.000.000 telah lunas.',
                'time' => '1 day ago',
                'read' => false,
                'action_url' => route('pembayaran.show', 1),
            ],
            [
                'type' => 'danger',
                'icon' => 'bi-bell-fill',
                'title' => 'Alert Pelanggan Pasif',
                'message' => 'Dinas Perhubungan belum dikunjungi dalam 30 hari terakhir.',
                'time' => '2 days ago',
                'read' => false,
                'action_url' => route('pelanggan.show', 1),
            ],
        ];

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead()
    {
        // In a real app, we would update the database here.
        // For now, we'll set a session variable to hide the badge.
        session(['notifications_read' => true]);

        return back()->with('success', 'All notifications marked as read.');
    }
}
