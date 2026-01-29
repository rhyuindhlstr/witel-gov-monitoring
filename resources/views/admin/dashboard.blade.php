@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

    {{-- 1. USER MANAGEMENT STATS --}}
    <h5 class="fw-bold text-dark mb-3 text-uppercase small ls-1">User Statistics</h5>
    <div class="row g-4 mb-5">
        {{-- Wilayah --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-danger text-white me-3">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $totalWilayah }}</h3>
                        <small class="text-muted">Wilayah</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total User --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-info text-white me-3">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $totalUsers }}</h3>
                        <small class="text-muted">Total User</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Admin --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-warning text-white me-3">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $totalAdmins }}</h3>
                        <small class="text-muted">Admin</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- SSGS & GS Combined --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-success text-white me-3">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div>
                        <div class="d-flex gap-2">
                            <div class="text-center">
                                <h4 class="fw-bold mb-0">{{ $totalSSGS }}</h4>
                                <small class="text-muted" style="font-size: 0.7em;">SSGS</small>
                            </div>
                            <div class="vr"></div>
                            <div class="text-center">
                                <h4 class="fw-bold mb-0">{{ $totalGS }}</h4>
                                <small class="text-muted" style="font-size: 0.7em;">GS</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. SSGS BUSINESS STATS --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0 text-uppercase small ls-1">SSGS Performance</h5>
        <div class="text-muted small">
            <i class="far fa-calendar-alt me-1"></i> Data Range:
            <strong>{{ $startDate->format('d M Y') }}</strong> - <strong>{{ $endDate->format('d M Y') }}</strong>
        </div>
    </div>

    <div class="row g-4 mb-4">
        {{-- Total Revenue --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 border-start border-4 border-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-uppercase small fw-bold text-muted">Total Pendapatan</div>
                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                    <div class="h3 mb-0 fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    <div class="mt-2 small text-muted">Total akumulasi periode ini</div>
                </div>
            </div>
        </div>

        {{-- Transactions --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-uppercase small fw-bold text-muted">Total Transaksi</div>
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                    <div class="h3 mb-0 fw-bold">{{ $totalSales }}</div>
                    <div class="mt-2 small text-success">
                        <i class="fas fa-check-circle me-1"></i> Transaksi tercatat
                    </div>
                </div>
            </div>
        </div>

        {{-- New Customers --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-uppercase small fw-bold text-muted">Pelanggan Baru</div>
                        <div class="bg-info bg-opacity-10 text-info rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-user-plus"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <div class="h3 mb-0 fw-bold me-2">{{ $newCustomers }}</div>
                        <div class="small {{ $customerGrowth >= 0 ? 'text-success' : 'text-danger' }}">
                            @if($customerGrowth >= 0)
                                <i class="fas fa-arrow-up"></i> {{ number_format($customerGrowth, 1) }}%
                            @else
                                <i class="fas fa-arrow-down"></i> {{ number_format(abs($customerGrowth), 1) }}%
                            @endif
                        </div>
                    </div>
                    <div class="mt-2 small text-muted">vs periode sebelumnya</div>
                </div>
            </div>
        </div>

        {{-- Pending Payments --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-uppercase small fw-bold text-muted">Tagihan Tertunda</div>
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="h3 mb-0 fw-bold">{{ $pendingPayments }}</div>
                    <div class="mt-2 small text-danger fw-bold">
                        Perlu tindak lanjut
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. CHARTS --}}
    <div class="row mb-4">
        <!-- Performance Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm mb-4 h-100">
                <div class="card-header py-3 bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-dark">Revenue Overview</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 320px;">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Donut Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-sm mb-4 h-100">
                <div class="card-header py-3 bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-dark">Status Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2" style="height: 250px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="me-3">
                            <i class="fas fa-circle text-danger"></i> Lancar
                        </span>
                        <span class="me-3">
                            <i class="fas fa-circle text-warning"></i> Tertunda
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. RECENT TRANSACTIONS --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header py-3 bg-white border-bottom-0">
            <h6 class="m-0 font-weight-bold text-dark">Pembayaran Terakhir</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPayments as $payment)
                            <tr>
                                <td class="ps-4">#{{ $payment->id }}</td>
                                <td>{{ $payment->tanggal_pembayaran->format('d M Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-2"
                                            style="width: 30px; height: 30px; font-weight: bold; font-size: 0.8rem;">
                                            {{ strtoupper(substr($payment->pelanggan->nama_pelanggan, 0, 1)) }}
                                        </div>
                                        <span class="fw-bold">{{ $payment->pelanggan->nama_pelanggan }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-{{ $payment->status_badge_color }} bg-opacity-10 text-{{ $payment->status_badge_color }}">
                                        {{ ucfirst($payment->status_pembayaran) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4 fw-bold">
                                    Rp {{ number_format($payment->nominal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada data pembayaran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Performance Chart
            const ctx = document.getElementById('performanceChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Revenue',
                        data: @json($revenueChartData),
                        backgroundColor: '#e30613',
                        borderRadius: 4,
                        barThickness: 20
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#2C3E50',
                            bodyColor: '#2C3E50',
                            borderColor: '#E9ECEF',
                            borderWidth: 1,
                            padding: 10,
                            displayColors: false,
                            callbacks: {
                                label: function (context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 2], color: '#e9ecef' },
                            ticks: {
                                callback: function (value) {
                                    if (value >= 1000000000) return 'Rp ' + (value / 1000000000).toFixed(1) + 'M';
                                    if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(0) + 'jt';
                                    return value;
                                }
                            }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });

            // Status Chart
            const pendingCount = {{ $pendingPayments }};
            const totalCount = {{ $totalSales }};
            const successCount = Math.max(0, totalCount - pendingCount);

            const ctx2 = document.getElementById('statusChart').getContext('2d');
            const myPieChart = new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['Lancar', 'Tertunda'],
                    datasets: [{
                        data: [successCount, pendingCount],
                        backgroundColor: ['#e30613', '#ffc107'],
                        hoverBackgroundColor: ['#b90510', '#e0a800'],
                        borderWidth: 0
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#fff',
                            bodyColor: '#2C3E50',
                            borderColor: '#E9ECEF',
                            borderWidth: 1
                        }
                    },
                    cutout: '75%',
                },
            });
        });
    </script>
@endpush