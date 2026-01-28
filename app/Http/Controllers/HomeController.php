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

        // 1. Total Sales (Count of payments within date range)
        $totalSales = \App\Models\PembayaranPelanggan::whereBetween('tanggal_pembayaran', [$startDate, $endDate])
            ->count();

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

        // 3. Pending Payments (within date range)
        $pendingPayments = \App\Models\PembayaranPelanggan::where('status_pembayaran', 'tertunda')
            ->whereBetween('tanggal_pembayaran', [$startDate, $endDate])
            ->count();

        // 4. Total Revenue (within date range)
        $totalRevenue = \App\Models\PembayaranPelanggan::whereBetween('tanggal_pembayaran', [$startDate, $endDate])
            ->sum('nominal');

        // 5. Monthly Revenue for Chart (within date range)
        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $monthExpression = $driver === 'sqlite'
            ? 'CAST(strftime("%m", tanggal_pembayaran) AS INTEGER)'
            : 'MONTH(tanggal_pembayaran)';

        $monthlyRevenue = \App\Models\PembayaranPelanggan::selectRaw("SUM(nominal) as total, $monthExpression as month")
            ->whereBetween('tanggal_pembayaran', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->all();

        // Fill missing months with 0
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyRevenue[$i] ?? 0;
        }

        // 6. Recent Orders (Recent Payments within date range)
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
            'endDate'
        ));
    }
}
