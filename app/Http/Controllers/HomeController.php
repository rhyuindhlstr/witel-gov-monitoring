<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Get date range from request or default to last 30 days
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        // Convert to Carbon instances for easier manipulation
        $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
        $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();

        // 1. Total Sales (ALL TIME count of all payments)
        $totalSales = \App\Models\PembayaranPelanggan::count();

        // 2. New Customers (within date range)
        $newCustomers = \App\Models\Pelanggan::whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Calculate growth compared to previous period
        $periodDays = $startDate->diffInDays($endDate);
        $previousStartDate = $startDate->copy()->subDays($periodDays);
        $previousEndDate = $startDate->copy()->subDay();

        $lastPeriodCustomers = \App\Models\Pelanggan::whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->count();
        $customerGrowth = $lastPeriodCustomers > 0 ? (($newCustomers - $lastPeriodCustomers) / $lastPeriodCustomers) * 100 : 100;

        // 3. Pending Payments (ALL TIME - tertunda not yet overdue)
        $pendingPayments = \App\Models\PembayaranPelanggan::where('status_pembayaran', 'tertunda')
            ->where(function($q) { $q->whereNull('tanggal_jatuh_tempo')->orWhere('tanggal_jatuh_tempo', '>=', now()); })
            ->count();

        // Payment status breakdown (all time for the donut/progress bars)
        $totalLancar   = \App\Models\PembayaranPelanggan::where('status_pembayaran', 'lancar')->count();
        $totalTertunda = \App\Models\PembayaranPelanggan::where('status_pembayaran', 'tertunda')
            ->where(function($q) { $q->whereNull('tanggal_jatuh_tempo')->orWhere('tanggal_jatuh_tempo', '>=', now()); })
            ->count();
        $totalOverdue  = \App\Models\PembayaranPelanggan::where('status_pembayaran', 'tertunda')
            ->whereNotNull('tanggal_jatuh_tempo')->where('tanggal_jatuh_tempo', '<', now())
            ->count();
        $totalAllPayments = $totalLancar + $totalTertunda + $totalOverdue;

        // Nominal amounts per status
        $amountLancar   = (float) \App\Models\PembayaranPelanggan::where('status_pembayaran', 'lancar')->sum('nominal');
        $amountTertunda = (float) \App\Models\PembayaranPelanggan::where('status_pembayaran', 'tertunda')
            ->where(function($q) { $q->whereNull('tanggal_jatuh_tempo')->orWhere('tanggal_jatuh_tempo', '>=', now()); })
            ->sum('nominal');
        $amountOverdue  = (float) \App\Models\PembayaranPelanggan::where('status_pembayaran', 'tertunda')
            ->whereNotNull('tanggal_jatuh_tempo')->where('tanggal_jatuh_tempo', '<', now())
            ->sum('nominal');
        $amountTotal    = ($amountLancar + $amountTertunda + $amountOverdue) ?: 1; // fixed precedence


        // Interaction (Kunjungan) Statistics
        $totalInteraksi = \App\Models\KunjunganPelanggan::count();
        $interaksiByMetode = \App\Models\KunjunganPelanggan::selectRaw('metode, COUNT(*) as total')
            ->groupBy('metode')
            ->pluck('total', 'metode')
            ->toArray();
        $interaksiVisit    = $interaksiByMetode['visit']    ?? 0;
        $interaksiCall     = $interaksiByMetode['call']     ?? 0;
        $interaksiWhatsapp = $interaksiByMetode['whatsapp'] ?? 0;

        // Monthly interaction trend (last 6 months)
        $monthExprKunj = $driver ?? (\Illuminate\Support\Facades\DB::connection()->getDriverName() === 'sqlite'
            ? 'CAST(strftime("%m", tanggal_kunjungan) AS INTEGER)'
            : 'MONTH(tanggal_kunjungan)');
        $monthlyInteraksi = [];
        foreach (['visit', 'call', 'whatsapp'] as $m) {
            $rows = \App\Models\KunjunganPelanggan::selectRaw("COUNT(*) as total, MONTH(tanggal_kunjungan) as month")
                ->where('metode', $m)
                ->whereYear('tanggal_kunjungan', now()->year)
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();
            $series = [];
            for ($i = 1; $i <= 12; $i++) {
                $series[] = $rows[$i] ?? 0;
            }
            $monthlyInteraksi[$m] = $series;
        }

        // 4. Total Revenue (ALL TIME - actual received, lancar only)
        $totalRevenue = \App\Models\PembayaranPelanggan::where('status_pembayaran', 'lancar')
            ->sum('nominal');

        // ── Performance Overview: Actual vs Expected Revenue ──────────────────
        $perfPeriod = $request->input('perf_period', 'year'); // year | month | week
        // Default to the most recent year that has data
        $latestDataYear = (int) (\App\Models\PembayaranPelanggan::selectRaw('YEAR(tanggal_pembayaran) as yr')
            ->whereNotNull('tanggal_pembayaran')
            ->orderByRaw('yr DESC')
            ->value('yr') ?? now()->year);
        $perfYear   = (int) $request->input('perf_year', $latestDataYear);
        $perfMonth  = (int) $request->input('perf_month', now()->month);
        $driver     = \Illuminate\Support\Facades\DB::connection()->getDriverName();

        if ($perfPeriod === 'year') {
            // Group by month for selected year
            $perfLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            $groupExpr  = $driver === 'sqlite' ? 'CAST(strftime("%m", tanggal_pembayaran) AS INTEGER)' : 'MONTH(tanggal_pembayaran)';
            $groupKey   = 'month';
            $count      = 12;
            $baseQuery  = fn($q) => $q->whereYear('tanggal_pembayaran', $perfYear);

        } elseif ($perfPeriod === 'month') {
            // Group by day for selected year-month
            $daysInMonth = \Carbon\Carbon::createFromDate($perfYear, $perfMonth, 1)->daysInMonth;
            $perfLabels  = array_map(fn($d) => (string)$d, range(1, $daysInMonth));
            $groupExpr   = $driver === 'sqlite' ? 'CAST(strftime("%d", tanggal_pembayaran) AS INTEGER)' : 'DAY(tanggal_pembayaran)';
            $groupKey    = 'day';
            $count       = $daysInMonth;
            $baseQuery   = fn($q) => $q->whereYear('tanggal_pembayaran', $perfYear)->whereMonth('tanggal_pembayaran', $perfMonth);

        } else {
            // Week: Mon-Sun of current week
            $weekStart = \Carbon\Carbon::now()->startOfWeek();
            $dayNames  = ['Sen','Sel','Rab','Kam','Jum','Sab','Min'];
            $perfLabels = array_map(fn($i) => $dayNames[$i].' '.$weekStart->copy()->addDays($i)->format('d/m'), range(0, 6));
            $groupExpr  = $driver === 'sqlite' ? 'CAST(strftime("%w", tanggal_pembayaran) AS INTEGER)' : 'DAYOFWEEK(tanggal_pembayaran)';
            $groupKey   = 'dow';
            $count      = 7;
            $baseQuery  = fn($q) => $q->whereBetween('tanggal_pembayaran', [$weekStart->startOfDay(), $weekStart->copy()->endOfWeek()->endOfDay()]);
        }

        // Actual Revenue = payments with status 'lancar'
        $actualRows = \App\Models\PembayaranPelanggan::selectRaw("SUM(nominal) as total, $groupExpr as $groupKey")
            ->where('status_pembayaran', 'lancar')
            ->when(true, $baseQuery)
            ->groupBy($groupKey)
            ->pluck('total', $groupKey)
            ->toArray();

        // Expected Revenue = ALL payments (lancar + tertunda) → what revenue would be if all paid
        $expectedRows = \App\Models\PembayaranPelanggan::selectRaw("SUM(nominal) as total, $groupExpr as $groupKey")
            ->when(true, $baseQuery)
            ->groupBy($groupKey)
            ->pluck('total', $groupKey)
            ->toArray();

        $perfActual   = [];
        $perfExpected = [];
        for ($i = 1; $i <= $count; $i++) {
            $perfActual[]   = (float) ($actualRows[$i]   ?? 0);
            $perfExpected[] = (float) ($expectedRows[$i] ?? 0);
        }

        // Legacy chartData kept for compatibility
        $chartData = $perfActual;

        // ── Monthly Interaction Trend (for Statistik Interaksi section) ───────
        $monthlyInteraksi = [];
        foreach (['visit', 'call', 'whatsapp'] as $m) {
            $rows = \App\Models\KunjunganPelanggan::selectRaw("COUNT(*) as total, MONTH(tanggal_kunjungan) as month")
                ->where('metode', $m)
                ->whereYear('tanggal_kunjungan', now()->year)
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();
            $series = [];
            for ($i = 1; $i <= 12; $i++) {
                $series[] = $rows[$i] ?? 0;
            }
            $monthlyInteraksi[$m] = $series;
        }

        // 6. Recent Payments
        $recentPayments = \App\Models\PembayaranPelanggan::with('pelanggan')
            ->whereBetween('tanggal_pembayaran', [$startDate, $endDate])
            ->latest('tanggal_pembayaran')
            ->take(5)
            ->get();

        return view('home', compact(
            'totalSales',
            'newCustomers',
            'customerGrowth',
            'pendingPayments',
            'totalRevenue',
            'chartData',
            'recentPayments',
            'startDate',
            'endDate',
            'totalLancar',
            'totalTertunda',
            'totalOverdue',
            'totalAllPayments',
            'totalInteraksi',
            'interaksiVisit',
            'interaksiCall',
            'interaksiWhatsapp',
            'monthlyInteraksi',
            'perfPeriod',
            'perfYear',
            'perfMonth',
            'perfLabels',
            'perfActual',
            'perfExpected',
            'amountLancar',
            'amountTertunda',
            'amountOverdue',
            'amountTotal'
        ));
    }
}

