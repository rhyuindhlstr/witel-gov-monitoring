<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PembayaranPelanggan;
use App\Models\Pelanggan;
use App\Models\Wilayah;
use App\Models\WilayahGS;
use App\Models\PeluangProyekGS;
use App\Models\AktivitasMarketing;
use App\Models\KunjunganPelanggan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // ── 1. User Management Stats ──
        $totalUsers  = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalSSGS   = User::where('role', 'ssgs')->count();
        $totalGS     = User::where('role', 'gs')->count();
        $totalWilayah = Wilayah::count();

        // ── 2. Date range (for label/display only) ──
        $startDate = Carbon::parse($request->input('start_date', now()->subDays(30)->format('Y-m-d')))->startOfDay();
        $endDate   = Carbon::parse($request->input('end_date',   now()->format('Y-m-d')))->endOfDay();

        // ── 3. SSGS — All-time stats (matching HomeController) ──
        $totalSales    = PembayaranPelanggan::count();
        $totalRevenue  = PembayaranPelanggan::where('status_pembayaran', 'lancar')->sum('nominal');

        $newCustomers  = Pelanggan::whereBetween('created_at', [$startDate, $endDate])->count();
        $periodDays    = max(1, $startDate->diffInDays($endDate));
        $prevStart     = $startDate->copy()->subDays($periodDays);
        $prevEnd       = $startDate->copy()->subDay();
        $lastPeriodCustomers = Pelanggan::whereBetween('created_at', [$prevStart, $prevEnd])->count();
        $customerGrowth = $lastPeriodCustomers > 0
            ? (($newCustomers - $lastPeriodCustomers) / $lastPeriodCustomers) * 100 : 100;

        // Payment status counts — all-time
        $totalLancar   = PembayaranPelanggan::where('status_pembayaran', 'lancar')->count();
        $totalTertunda = PembayaranPelanggan::where('status_pembayaran', 'tertunda')
            ->where(fn($q) => $q->whereNull('tanggal_jatuh_tempo')->orWhere('tanggal_jatuh_tempo', '>=', now()))->count();
        $totalOverdue  = PembayaranPelanggan::where('status_pembayaran', 'tertunda')
            ->whereNotNull('tanggal_jatuh_tempo')->where('tanggal_jatuh_tempo', '<', now())->count();
        $totalAllPayments = $totalLancar + $totalTertunda + $totalOverdue;
        $pendingPayments  = $totalTertunda; // for legacy compat

        // Nominal amounts for progress bars
        $amountLancar   = (float) PembayaranPelanggan::where('status_pembayaran', 'lancar')->sum('nominal');
        $amountTertunda = (float) PembayaranPelanggan::where('status_pembayaran', 'tertunda')
            ->where(fn($q) => $q->whereNull('tanggal_jatuh_tempo')->orWhere('tanggal_jatuh_tempo', '>=', now()))->sum('nominal');
        $amountOverdue  = (float) PembayaranPelanggan::where('status_pembayaran', 'tertunda')
            ->whereNotNull('tanggal_jatuh_tempo')->where('tanggal_jatuh_tempo', '<', now())->sum('nominal');
        $amountTotal    = ($amountLancar + $amountTertunda + $amountOverdue) ?: 1;

        // ── 4. SSGS Performance Overview — yearly (matching HomeController) ──
        $latestDataYear = (int) (PembayaranPelanggan::selectRaw('YEAR(tanggal_pembayaran) as yr')
            ->whereNotNull('tanggal_pembayaran')->orderByRaw('yr DESC')->value('yr') ?? now()->year);
        $perfYear  = (int) $request->input('perf_year', $latestDataYear);
        $perfMonth = (int) $request->input('perf_month', now()->month);

        $actualByMonth   = PembayaranPelanggan::selectRaw('MONTH(tanggal_pembayaran) as m, SUM(nominal) as total')
            ->where('status_pembayaran', 'lancar')->whereYear('tanggal_pembayaran', $perfYear)
            ->groupBy('m')->pluck('total', 'm')->all();
        $expectedByMonth = PembayaranPelanggan::selectRaw('MONTH(tanggal_pembayaran) as m, SUM(nominal) as total')
            ->whereYear('tanggal_pembayaran', $perfYear)->groupBy('m')->pluck('total', 'm')->all();

        $perfLabels   = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $perfActual   = array_map(fn($i) => (float)($actualByMonth[$i]   ?? 0), range(1, 12));
        $perfExpected = array_map(fn($i) => (float)($expectedByMonth[$i] ?? 0), range(1, 12));
        $revenueChartData = $perfActual; // legacy alias

        // ── 5. SSGS — Interaksi distribution via KunjunganPelanggan (all-time) ──
        $interaksiVisit    = KunjunganPelanggan::where('metode', 'visit')->count();
        $interaksiCall     = KunjunganPelanggan::where('metode', 'call')->count();
        $interaksiWhatsapp = KunjunganPelanggan::where('metode', 'whatsapp')->count();
        $totalInteraksi    = $interaksiVisit + $interaksiCall + $interaksiWhatsapp;

        // ── 6. SSGS — Recent Payments (all-time last 5) ──
        $recentPayments = PembayaranPelanggan::with('pelanggan')
            ->latest('tanggal_pembayaran')->take(5)->get();

        // ── 7. GS Stats — mirrors HomeGSController exactly ──
        $gsStatusCount = PeluangProyekGS::selectRaw('status_proyek, COUNT(*) as total')
            ->groupBy('status_proyek')->pluck('total', 'status_proyek');

        $gsWin           = $gsStatusCount['WIN']            ?? 0;
        $gsProspect      = $gsStatusCount['PROSPECT']       ?? 0;
        $gsKegiatanValid = $gsStatusCount['KEGIATAN_VALID'] ?? 0;
        $gsLose          = $gsStatusCount['LOSE']           ?? 0;
        $gsCancel        = $gsStatusCount['CANCEL']         ?? 0;
        $gsTotalProyek   = $gsWin + $gsProspect + $gsKegiatanValid + $gsLose + $gsCancel;

        $gsAktif    = PeluangProyekGS::whereNotIn('status_proyek', ['WIN','LOSE','CANCEL'])->count();
        $gsSelesai  = PeluangProyekGS::whereIn('status_proyek',  ['WIN','LOSE','CANCEL'])->count();

        // GS Chart Wilayah (vertical bar)
        $gsPeluangWilayah = WilayahGS::withCount('peluangProyekGS')->get();
        $gsChartWilayah   = $gsPeluangWilayah->pluck('peluang_proyek_g_s_count', 'nama_wilayah');

        // GS Chart Nilai — doughnut: Total Proyek vs Proyek Terealisasi
        $gsChartNilai = [
            'estimasi'        => PeluangProyekGS::sum('nilai_estimasi'),
            'realisasi'       => PeluangProyekGS::sum('nilai_realisasi'),
            'count_total'     => PeluangProyekGS::count(),
            'count_realisasi' => PeluangProyekGS::where('nilai_realisasi', '>', 0)->count(),
        ];

        // GS Financial Overview card (Estimasi vs Realisasi + Achievement %)
        $gsFinancialData = [
            'estimasi'     => $gsChartNilai['estimasi'],
            'realisasi'    => $gsChartNilai['realisasi'],
            'total_proyek' => $gsChartNilai['count_total'],
            'percentage'   => $gsChartNilai['estimasi'] > 0
                ? ($gsChartNilai['realisasi'] / $gsChartNilai['estimasi']) * 100 : 0,
            'has_trend'    => false,
            'trend_value'  => 0,
            'trend_label'  => 'semua waktu',
        ];

        // GS Top 5 AM Leaderboard
        $gsTopAMs = PeluangProyekGS::selectRaw("nama_am, COUNT(*) as total_proyek, SUM(CASE WHEN status_proyek='WIN' THEN 1 ELSE 0 END) as total_win")
            ->whereNotNull('nama_am')->where('nama_am', '!=', '')
            ->groupBy('nama_am')->orderByDesc('total_win')->orderByDesc('total_proyek')
            ->limit(5)->get();

        // GS Aktivitas Terbaru (today)
        $gsAktivitasTerbaru = AktivitasMarketing::with(['peluang.wilayah', 'peluang'])
            ->whereDate('tanggal', Carbon::today())->latest()->limit(10)->get();

        return view('admin.dashboard', compact(
            // User stats
            'totalUsers', 'totalAdmins', 'totalSSGS', 'totalGS', 'totalWilayah',
            // SSGS stats
            'totalSales', 'totalRevenue', 'pendingPayments', 'newCustomers', 'customerGrowth',
            'totalLancar', 'totalTertunda', 'totalOverdue', 'totalAllPayments',
            'amountLancar', 'amountTertunda', 'amountOverdue', 'amountTotal',
            // SSGS chart
            'perfLabels', 'perfActual', 'perfExpected', 'perfYear', 'perfMonth',
            'revenueChartData',
            // SSGS interaksi
            'interaksiVisit', 'interaksiCall', 'interaksiWhatsapp', 'totalInteraksi',
            // Recent
            'recentPayments', 'startDate', 'endDate',
            // GS stats
            'gsWin', 'gsProspect', 'gsKegiatanValid', 'gsLose', 'gsCancel', 'gsTotalProyek',
            'gsAktif', 'gsSelesai',
            'gsChartWilayah', 'gsChartNilai', 'gsPeluangWilayah',
            'gsFinancialData', 'gsTopAMs', 'gsAktivitasTerbaru'
        ));
    }
}
