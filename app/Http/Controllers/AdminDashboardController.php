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

        // ── 7. GS Performance Stats ──
        $gsWin           = PeluangProyekGS::where('status_proyek', 'WIN')->count();
        $gsProspect      = PeluangProyekGS::where('status_proyek', 'PROSPECT')->count();
        $gsKegiatanValid = PeluangProyekGS::where('status_proyek', 'KEGIATAN_VALID')->count();
        $gsLose          = PeluangProyekGS::where('status_proyek', 'LOSE')->count();
        $gsCancel        = PeluangProyekGS::where('status_proyek', 'CANCEL')->count();
        $gsTotalProyek   = $gsWin + $gsProspect + $gsKegiatanValid + $gsLose + $gsCancel;

        // GS Charts
        $gsPeluangWilayah = WilayahGS::withCount('peluangProyekGS')->get();
        $gsChartWilayah   = $gsPeluangWilayah->pluck('peluang_proyek_g_s_count', 'nama_wilayah');
        $gsChartNilai     = [
            'estimasi'  => PeluangProyekGS::sum('nilai_estimasi'),
            'realisasi' => PeluangProyekGS::sum('nilai_realisasi'),
        ];

        // GS Aktivitas Terbaru (today)
        $gsAktivitasTerbaru = AktivitasMarketing::with(['peluang'])
            ->whereDate('tanggal', Carbon::today())->latest('tanggal')->limit(10)->get();

        // GS Win Rate per bulan (untuk chart trend GS)
        $gsMonthlyWin = PeluangProyekGS::selectRaw('MONTH(created_at) as m, COUNT(*) as total')
            ->where('status_proyek', 'WIN')->whereYear('created_at', now()->year)
            ->groupBy('m')->pluck('total', 'm')->all();
        $gsWinTrend = array_map(fn($i) => (int)($gsMonthlyWin[$i] ?? 0), range(1, 12));

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
            'gsChartWilayah', 'gsChartNilai', 'gsAktivitasTerbaru', 'gsWinTrend'
        ));
    }
}
