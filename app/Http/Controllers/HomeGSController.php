<?php

namespace App\Http\Controllers;

use App\Models\PeluangProyekGS;
use App\Models\AktivitasMarketing;
use App\Models\WilayahGS;
use Illuminate\Http\Request;

class HomeGSController extends Controller
{
    public function index(Request $request)
    {
        /* ===============================
         * BASE QUERY FILTER
         * =============================== */
        $filterYear = $request->filter_year;
        $filterMonth = $request->filter_month;

        /* ===============================
         * CARD STATUS PROYEK
         * =============================== */
        $statusCount = PeluangProyekGS::selectRaw('status_proyek, COUNT(*) as total')
            ->when($filterYear, fn($q) => $q->whereYear('tanggal_input', $filterYear))
            ->when($filterMonth, fn($q) => $q->whereMonth('tanggal_input', $filterMonth))
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
                'peluang.wilayah',
                'peluang'
            ])
            ->when($filterYear, fn($q) => $q->whereYear('tanggal', $filterYear))
            ->when($filterMonth, fn($q) => $q->whereMonth('tanggal', $filterMonth))
            ->when(!$filterYear && !$filterMonth, fn($q) => $q->whereDate('tanggal', \Carbon\Carbon::today()))
            ->latest()
            ->limit(5)
            ->get();

        /* ===============================
         * PELUANG PROYEK PER WILAYAH
         * =============================== */
        $peluangWilayah = WilayahGS::withCount(['peluangProyekGS' => function($q) use ($filterYear, $filterMonth) {
            $q->when($filterYear, fn($sq) => $sq->whereYear('tanggal_input', $filterYear))
              ->when($filterMonth, fn($sq) => $sq->whereMonth('tanggal_input', $filterMonth));
        }])->get();

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
        $queryChart = PeluangProyekGS::query();

        // Filter Tahun & Bulan untuk Chart
        if ($request->filled('filter_year')) {
            $queryChart->whereYear('tanggal_input', $request->filter_year);
        }
        if ($request->filled('filter_month')) {
            $queryChart->whereMonth('tanggal_input', $request->filter_month);
        }

        $chartNilai = [
            'estimasi'        => (clone $queryChart)->sum('nilai_estimasi'),
            'realisasi'       => (clone $queryChart)->sum('nilai_realisasi'),
            'count_total'     => (clone $queryChart)->count(),
            'count_realisasi' => (clone $queryChart)
                ->where('nilai_realisasi', '>', 0)
                ->count(),
        ];

        /* ===============================
         * FINANCIAL HIGHLIGHTS (NEW)
         * =============================== */
        $financialData = [
            'estimasi'     => $chartNilai['estimasi'],
            'realisasi'    => $chartNilai['realisasi'],
            'total_proyek' => $chartNilai['count_total'],
            'percentage'   => $chartNilai['estimasi'] > 0 ? ($chartNilai['realisasi'] / $chartNilai['estimasi']) * 100 : 0,
            'trend_value'  => 0,
            'trend_label'  => 'dibanding periode lalu',
            'has_trend'    => false
        ];

        // Calculate Trend (Previous Period Logic)
        $prevQuery = PeluangProyekGS::query();
        $calcTrend = false;

        if ($request->filled('filter_year') && $request->filled('filter_month')) {
            $currDate = \Carbon\Carbon::createFromDate($request->filter_year, $request->filter_month, 1);
            $prevDate = $currDate->copy()->subMonth();
            $prevQuery->whereYear('tanggal_input', $prevDate->year)->whereMonth('tanggal_input', $prevDate->month);
            $financialData['trend_label'] = 'dibanding bulan lalu';
            $calcTrend = true;
        } elseif ($request->filled('filter_year')) {
            $prevQuery->whereYear('tanggal_input', $request->filter_year - 1);
            $financialData['trend_label'] = 'dibanding tahun lalu';
            $calcTrend = true;
        }

        if ($calcTrend) {
            $prevEstimasi = (clone $prevQuery)->sum('nilai_estimasi');
            $prevRealisasi = (clone $prevQuery)->sum('nilai_realisasi');
            $prevPercentage = $prevEstimasi > 0 ? ($prevRealisasi / $prevEstimasi) * 100 : 0;
            $financialData['trend_value'] = $financialData['percentage'] - $prevPercentage;
            $financialData['has_trend'] = true;
        }

        /* ===============================
         * TOP 5 AM (NEW)
         * =============================== */
        $queryTopAM = PeluangProyekGS::selectRaw("nama_am, COUNT(*) as total_proyek, SUM(CASE WHEN status_proyek = 'WIN' THEN 1 ELSE 0 END) as total_win")
            ->whereNotNull('nama_am')
            ->where('nama_am', '!=', '');

        if ($request->filled('filter_year')) {
            $queryTopAM->whereYear('tanggal_input', $request->filter_year);
        }
        if ($request->filled('filter_month')) {
            $queryTopAM->whereMonth('tanggal_input', $request->filter_month);
        }

        $topAMs = $queryTopAM->groupBy('nama_am')
            ->orderByDesc('total_win')
            ->orderByDesc('total_proyek')
            ->limit(5)
            ->get();

        // Data Tahun untuk Filter
        $availableYears = PeluangProyekGS::selectRaw('YEAR(tanggal_input) as year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('dashboard.gs.index', compact(
            'statusCount',
            'totalAktif',
            'totalSelesai',
            'aktivitasTerbaru',
            'peluangWilayah',
            'chartWilayah',
            'chartNilai',
            'availableYears',
            'topAMs',
            'financialData'
        ));
    }
}
