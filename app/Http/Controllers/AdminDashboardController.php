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
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard with full statistics.
     */
    public function index(Request $request)
    {
        // --- 1. User Management Stats (Admin Specific) ---
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalSSGS = User::where('role', 'ssgs')->count();
        $totalGS = User::where('role', 'gs')->count();
        $totalWilayah = Wilayah::count();

        // --- 2. SSGS Business Logic (Ported from HomeController) ---

        // Get date range or default to last 30 days
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        // Sales (Transactions)
        $totalSales = PembayaranPelanggan::whereBetween('tanggal_pembayaran', [$startDate, $endDate])->count();

        // Revenue
        $totalRevenue = PembayaranPelanggan::whereBetween('tanggal_pembayaran', [$startDate, $endDate])->sum('nominal');

        // Pending Payments
        $pendingPayments = PembayaranPelanggan::where('status_pembayaran', 'tertunda')
            ->whereBetween('tanggal_pembayaran', [$startDate, $endDate])
            ->count();

        // New Customers
        $newCustomers = Pelanggan::whereBetween('created_at', [$startDate, $endDate])->count();

        // Customer Growth Calculation
        $periodDays = $startDate->diffInDays($endDate);
        if ($periodDays == 0)
            $periodDays = 1; // Prevent zero division if somehow start=end

        $prevStart = $startDate->copy()->subDays($periodDays);
        $prevEnd = $startDate->copy()->subDay();

        $lastPeriodCustomers = Pelanggan::whereBetween('created_at', [$prevStart, $prevEnd])->count();
        $customerGrowth = $lastPeriodCustomers > 0
            ? (($newCustomers - $lastPeriodCustomers) / $lastPeriodCustomers) * 100
            : 100;

        // --- 3. GS Performance Stats (New) ---
        $gsWin = PeluangProyekGS::where('status_proyek', 'WIN')->count();
        $gsProspect = PeluangProyekGS::where('status_proyek', 'PROSPECT')->count();
        $gsKegiatanValid = PeluangProyekGS::where('status_proyek', 'KEGIATAN_VALID')->count();
        $gsLose = PeluangProyekGS::where('status_proyek', 'LOSE')->count();
        $gsCancel = PeluangProyekGS::where('status_proyek', 'CANCEL')->count();

        // GS Charts Data
        $gsPeluangWilayah = WilayahGS::withCount('peluangProyekGS')->get();
        $gsChartWilayah = $gsPeluangWilayah->pluck('peluang_proyek_g_s_count', 'nama_wilayah');
        
        $gsChartNilai = [
            'estimasi'  => PeluangProyekGS::sum('nilai_estimasi'),
            'realisasi' => PeluangProyekGS::sum('nilai_realisasi'),
        ];

        // GS Aktivitas Marketing Terbaru
        $gsAktivitasTerbaru = AktivitasMarketing::with(['peluang'])
            ->whereDate('tanggal', Carbon::today())
            ->latest('tanggal')
            ->limit(5)
            ->get();

        // Monthly Revenue Chart
        $driver = DB::connection()->getDriverName();
        $monthExpression = $driver === 'sqlite'
            ? 'CAST(strftime("%m", tanggal_pembayaran) AS INTEGER)'
            : 'MONTH(tanggal_pembayaran)';

        $monthlyRevenue = PembayaranPelanggan::selectRaw("SUM(nominal) as total, $monthExpression as month")
            ->whereBetween('tanggal_pembayaran', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->all();

        $revenueChartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenueChartData[] = $monthlyRevenue[$i] ?? 0;
        }

        // Recent Payments
        $recentPayments = PembayaranPelanggan::with('pelanggan')
            ->whereBetween('tanggal_pembayaran', [$startDate, $endDate])
            ->latest('tanggal_pembayaran')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'totalSSGS',
            'totalGS',
            'totalWilayah',
            'totalSales',
            'totalRevenue',
            'pendingPayments',
            'newCustomers',
            'customerGrowth',
            'revenueChartData',
            'recentPayments',
            'startDate',
            'endDate',
            'gsWin',
            'gsProspect',
            'gsKegiatanValid',
            'gsLose',
            'gsCancel',
            'gsChartWilayah',
            'gsChartNilai',
            'gsAktivitasTerbaru'
        ));
    }
}
