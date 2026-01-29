<?php

namespace App\Http\Controllers;

use App\Models\PeluangProyekGS;
use App\Models\AktivitasMarketing;
use App\Models\WilayahGS;

class HomeGSController extends Controller
{
    public function index()
    {
        /* ===============================
         * CARD STATUS PROYEK
         * =============================== */
        $statusCount = PeluangProyekGS::selectRaw(
                'status_proyek, COUNT(*) as total'
            )
            ->groupBy('status_proyek')
            ->pluck('total', 'status_proyek');

        /* ===============================
         * TOTAL PROYEK
         * =============================== */
        $totalAktif = PeluangProyekGS::whereNotIn(
            'status_proyek',
            ['WIN', 'LOSE', 'CANCEL']
        )->count();

        $totalSelesai = PeluangProyekGS::whereIn(
            'status_proyek',
            ['WIN', 'LOSE', 'CANCEL']
        )->count();

        /* ===============================
         * AKTIVITAS MARKETING TERBARU
         * =============================== */
        $aktivitasTerbaru = AktivitasMarketing::with([
                'peluang.wilayah'
            ])
            ->whereDate('tanggal', \Carbon\Carbon::today())
            ->latest()
            ->limit(5)
            ->get();

        /* ===============================
         * PELUANG PROYEK PER WILAYAH
         * =============================== */
        $peluangWilayah = WilayahGS::withCount('peluangProyekGS')->get();

        /* ===============================
         * CHART WILAYAH (FIX ERROR)
         * dipakai di blade → $chartWilayah
         * =============================== */
        $chartWilayah = $peluangWilayah->pluck(
            'peluang_proyek_g_s_count',
            'nama_wilayah'
        );

        /* ===============================
         * CHART NILAI
         * =============================== */
        $chartNilai = [
            'estimasi'  => PeluangProyekGS::sum('nilai_estimasi'),
            'realisasi' => PeluangProyekGS::sum('nilai_realisasi'),
        ];

        return view('dashboard.gs.index', compact(
            'statusCount',
            'totalAktif',
            'totalSelesai',
            'aktivitasTerbaru',
            'peluangWilayah',
            'chartWilayah',
            'chartNilai'
        ));
    }
}
