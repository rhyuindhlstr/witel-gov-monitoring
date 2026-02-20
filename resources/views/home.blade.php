@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header (Overview & Actions) -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 font-weight-bold text-dark mb-0">Overview</h2>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm btn-white border bg-white text-muted shadow-sm d-flex align-items-center" id="dateRangePicker">
                <span class="me-2" id="dateRangeText">{{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</span>
                <i class="bi bi-calendar"></i>
            </button>
            <div class="dropdown">
                <button class="btn btn-sm btn-white border bg-white text-muted shadow-sm dropdown-toggle" type="button" id="periodFilter" data-bs-toggle="dropdown">
                    Last 30 days
                </button>
                <ul class="dropdown-menu" id="periodFilterMenu">
                    <li><a class="dropdown-item" href="#" data-days="7">Last 7 days</a></li>
                    <li><a class="dropdown-item active" href="#" data-days="30">Last 30 days</a></li>
                    <li><a class="dropdown-item" href="#" data-days="60">Last 60 days</a></li>
                    <li><a class="dropdown-item" href="#" data-days="90">Last 90 days</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" data-days="custom">Custom Range</a></li>
                </ul>
            </div>
            <button class="btn btn-sm btn-white border bg-white text-muted shadow-sm" id="exportBtn">
                <i class="bi bi-download me-1"></i> Export
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    
    <!-- SALES STATS -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="h5 font-weight-bold text-dark mb-0">Sales Performance</h5>
    </div>

    <div class="row mb-4">
        <!-- Total Sales -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 text-white bg-danger" style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-uppercase small fw-bold text-white-50">Total Transaksi</div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-cart-fill text-white"></i>
                        </div>
                    </div>
                    <div class="h2 mb-0 fw-bold">{{ $totalSales }}</div>
                    <div class="mt-2 small text-white-50">
                        <i class="bi bi-arrow-up-short"></i> Data Terupdate
                    </div>
                </div>
            </div>
        </div>

        <!-- New Customers -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-uppercase small fw-bold text-muted">Pelanggan Baru</div>
                        <div class="bg-dark text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <div class="h2 mb-0 fw-bold me-2">{{ $newCustomers }}</div>
                        <div class="small {{ $customerGrowth >= 0 ? 'text-success' : 'text-danger' }}">
                            @if($customerGrowth >= 0)
                                <i class="bi bi-arrow-up-short"></i> {{ number_format($customerGrowth, 1) }}%
                            @else
                                <i class="bi bi-arrow-down-short"></i> {{ number_format(abs($customerGrowth), 1) }}%
                            @endif
                            <span class="text-muted">vs bulan lalu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Payments (Returns) -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-uppercase small fw-bold text-muted">Tagihan Tertunda</div>
                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                    <div class="h2 mb-0 fw-bold">{{ $pendingPayments }}</div>
                    <div class="mt-2 small text-muted">Perlu tindak lanjut</div>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-uppercase small fw-bold text-muted">Total Pendapatan</div>
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                    <div class="h2 mb-0 fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    <div class="mt-2 small text-muted">Total akumulasi</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Performance Chart — left col, full height -->
        <div class="col-xl-8 col-lg-7 d-flex flex-column mb-4 mb-lg-0">
            <div class="card shadow-sm flex-fill" style="border-radius: 16px;">
                <div class="card-header py-3 px-4 bg-white border-bottom-0" style="border-radius: 16px 16px 0 0;">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <h6 class="m-0 fw-bold text-dark">Performance Overview</h6>
                            <div class="d-flex gap-2">
                                <span class="d-flex align-items-center gap-1 small fw-semibold" style="color:#EF4444;">
                                    <span style="width:22px;height:3px;background:#EF4444;border-radius:2px;display:inline-block;"></span> Aktual
                                </span>
                                <span class="d-flex align-items-center gap-1 small fw-semibold" style="color:#94a3b8;">
                                    <span style="width:22px;height:3px;background:#94a3b8;border-radius:2px;display:inline-block;border:1px dashed #94a3b8;"></span> Ekspektasi
                                </span>
                            </div>
                        </div>
                        <form method="GET" action="{{ route('dashboard.ssgs') }}" id="perfFilterForm" class="d-flex align-items-center gap-2">
                            @foreach(request()->except(['perf_period','perf_year','perf_month']) as $k => $v)
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endforeach
                            <input type="hidden" name="perf_period" value="year">
                            <label class="small text-muted fw-semibold mb-0">Tahun:</label>
                            <select name="perf_year" class="form-select form-select-sm border-0 shadow-sm fw-semibold"
                                    style="width:85px;border-radius:10px;" onchange="this.form.submit()">
                                @for($y = now()->year; $y >= now()->year - 4; $y--)
                                    <option value="{{ $y }}" {{ $perfYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </form>
                    </div>
                </div>
                <div class="card-body px-4 pb-4 d-flex align-items-stretch" style="min-height:300px;">
                    <canvas id="performanceChart" style="width:100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Right column: Status Pembayaran (top) + Distribusi Metode (bottom) -->
        <div class="col-xl-4 col-lg-5 d-flex flex-column gap-4">

            <!-- Status Pembayaran -->
            <div class="card shadow-sm flex-fill" style="border-radius:16px;">
                <div class="card-header py-3 px-4 bg-white border-bottom-0 d-flex align-items-center justify-content-between" style="border-radius:16px 16px 0 0;">
                    <h6 class="m-0 fw-bold text-dark">Status Pembayaran</h6>
                    <span class="badge rounded-pill text-bg-light fw-semibold" style="font-size:.75rem;">{{ $totalAllPayments }} transaksi</span>
                </div>
                <div class="card-body px-4 pb-4 pt-2">
                    @php
                        $fmtRp = function($v) {
                            if ($v >= 1000000000) return 'Rp '.number_format($v/1000000000,1).' M';
                            if ($v >= 1000000)    return 'Rp '.number_format($v/1000000,1).' Jt';
                            if ($v >= 1000)       return 'Rp '.number_format($v/1000,0).' K';
                            return 'Rp '.number_format($v,0);
                        };
                        $bars = [
                            ['label'=>'Overdue',  'color'=>'#EF4444', 'amount'=>$amountOverdue,  'count'=>$totalOverdue,  'pct'=>round($amountOverdue/$amountTotal*100)],
                            ['label'=>'Tertunda', 'color'=>'#F59E0B', 'amount'=>$amountTertunda, 'count'=>$totalTertunda, 'pct'=>round($amountTertunda/$amountTotal*100)],
                            ['label'=>'Lunas',    'color'=>'#22c55e', 'amount'=>$amountLancar,   'count'=>$totalLancar,   'pct'=>round($amountLancar/$amountTotal*100)],
                        ];
                    @endphp
                    @foreach($bars as $bar)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-baseline mb-1">
                            <span class="fw-semibold text-dark" style="font-size:.875rem;">{{ $bar['label'] }}</span>
                            <span class="text-muted small">{{ $fmtRp($bar['amount']) }}</span>
                        </div>
                        <div style="height:10px;background:#f1f5f9;border-radius:999px;overflow:hidden;">
                            <div style="height:100%;width:{{ max($bar['pct'],2) }}%;border-radius:999px;background:linear-gradient(90deg,{{ $bar['color'] }} 0%,{{ $bar['color'] }}aa 100%);transition:width .6s ease;"></div>
                        </div>
                        <div class="text-muted mt-1" style="font-size:.72rem;">{{ $bar['count'] }} transaksi &nbsp;·&nbsp; {{ $bar['pct'] }}%</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Distribusi Metode Interaksi -->
            <div class="card shadow-sm flex-fill" style="border-radius:16px;">
                <div class="card-header bg-white border-bottom-0 py-3 px-4 d-flex justify-content-between align-items-center" style="border-radius:16px 16px 0 0;">
                    <h6 class="m-0 fw-bold text-dark">Distribusi Metode Interaksi</h6>
                    <span class="badge rounded-pill text-bg-light border fw-semibold" style="font-size:.73rem; color:#374151;">Semua waktu</span>
                </div>
                <div class="card-body px-4 pb-4 pt-1">
                    @php
                        $totalM = max($totalInteraksi, 1);
                        $metodes = [
                            ['label' => 'Visit',    'color' => '#6366f1', 'value' => $interaksiVisit],
                            ['label' => 'Call',     'color' => '#0ea5e9', 'value' => $interaksiCall],
                            ['label' => 'WhatsApp', 'color' => '#22c55e', 'value' => $interaksiWhatsapp],
                        ];
                    @endphp
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-fill" style="min-width:0;">
                            @foreach($metodes as $m)
                            <div class="d-flex align-items-center justify-content-between py-2" style="border-bottom:1px solid #f1f5f9;">
                                <div class="d-flex align-items-center gap-2">
                                    <span style="width:11px;height:11px;border-radius:50%;background:{{ $m['color'] }};display:inline-block;flex-shrink:0;"></span>
                                    <span class="fw-semibold" style="font-size:.85rem;color:#374151;">{{ $m['label'] }}</span>
                                </div>
                                <span class="fw-bold" style="font-size:.85rem;color:#374151;">
                                    {{ $totalM > 0 ? number_format($m['value']/$totalM*100, 0) : 0 }}%
                                </span>
                            </div>
                            @endforeach
                            <div class="d-flex align-items-center justify-content-between pt-2">
                                <span class="small text-muted">Total Interaksi</span>
                                <span class="fw-bold small">{{ $totalInteraksi }}</span>
                            </div>
                        </div>
                        <div style="width:120px;height:120px;flex-shrink:0;">
                            <canvas id="interaksiDonutChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Recent Payments --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm" style="border-radius:16px;">
                <div class="card-header py-3 px-4 bg-white border-bottom-0 d-flex align-items-center justify-content-between" style="border-radius:16px 16px 0 0;">
                    <h6 class="m-0 fw-bold text-dark">Pembayaran Terakhir</h6>
                    <span class="badge rounded-pill text-bg-light border fw-semibold" style="font-size:.73rem; color:#374151;">5 transaksi terbaru</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 ps-4">ID</th>
                                    <th class="border-0">Tanggal</th>
                                    <th class="border-0">Pelanggan</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0 text-end pe-4">Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPayments as $payment)
                                <tr>
                                    <td class="ps-4">#{{ $payment->id }}</td>
                                    <td>{{ $payment->tanggal_pembayaran->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2 bg-light rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:35px;height:35px;color:#6c757d;">
                                                {{ strtoupper(substr($payment->pelanggan->nama_pelanggan, 0, 1)) }}
                                            </div>
                                            <span class="fw-bold text-dark">{{ $payment->pelanggan->nama_pelanggan }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $payment->status_badge_color }} bg-opacity-10 text-{{ $payment->status_badge_color }}">
                                            {{ ucfirst($payment->status_pembayaran) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4 fw-bold">Rp {{ number_format($payment->nominal, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-4">Belum ada data pembayaran</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
@php
    $perfVisitArr    = $monthlyInteraksi['visit']    ?? array_fill(0, 12, 0);
    $perfCallArr     = $monthlyInteraksi['call']     ?? array_fill(0, 12, 0);
    $perfWhatsappArr = $monthlyInteraksi['whatsapp'] ?? array_fill(0, 12, 0);
@endphp

        // Performance Chart — Actual vs Expected Revenue
        const perfLabels   = @json($perfLabels);
        const perfActual   = @json($perfActual);
        const perfExpected = @json($perfExpected);

        const ctx = document.getElementById('performanceChart').getContext('2d');

        const gradRed = ctx.createLinearGradient(0, 0, 0, 280);
        gradRed.addColorStop(0, 'rgba(239,68,68,0.15)');
        gradRed.addColorStop(1, 'rgba(239,68,68,0)');

        const gradGray = ctx.createLinearGradient(0, 0, 0, 280);
        gradGray.addColorStop(0, 'rgba(148,163,184,0.12)');
        gradGray.addColorStop(1, 'rgba(148,163,184,0)');

        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: perfLabels,
                datasets: [
                    {
                        label: 'Revenue Aktual',
                        data: perfActual,
                        borderColor: '#EF4444',
                        backgroundColor: gradRed,
                        pointRadius: 4,
                        pointHoverRadius: 8,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#EF4444',
                        pointBorderWidth: 2,
                        tension: 0.45,
                        fill: true,
                        borderWidth: 2.5,
                    },
                    {
                        label: 'Revenue Ekspektasi',
                        data: perfExpected,
                        borderColor: '#94a3b8',
                        backgroundColor: gradGray,
                        pointRadius: 4,
                        pointHoverRadius: 8,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#94a3b8',
                        pointBorderWidth: 2,
                        borderDash: [6, 4],
                        tension: 0.45,
                        fill: true,
                        borderWidth: 2,
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#1e293b',
                        bodyColor: '#475569',
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        padding: 12,
                        boxPadding: 5,
                        cornerRadius: 10,
                        callbacks: {
                            label: function(c) {
                                const v = c.raw;
                                const fmt = v >= 1000000 ? 'Rp '+(v/1000000).toFixed(1)+' Jt'
                                          : v >= 1000    ? 'Rp '+(v/1000).toFixed(0)+' K'
                                          : 'Rp '+v;
                                return ' ' + c.dataset.label + ': ' + fmt;
                            },
                            afterBody: function(items) {
                                const a = items[0]?.raw ?? 0;
                                const e = items[1]?.raw ?? 0;
                                if (e > 0 && a < e) {
                                    const gap = e - a;
                                    const pct = ((gap/e)*100).toFixed(1);
                                    const fmtGap = gap >= 1000000 ? 'Rp '+(gap/1000000).toFixed(1)+' Jt'
                                                 : gap >= 1000    ? 'Rp '+(gap/1000).toFixed(0)+' K'
                                                 : 'Rp '+gap;
                                    return [' ─────────────────', ' Gap: ' + fmtGap + ' ('+pct+'%)'];
                                }
                                return [];
                            }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#94a3b8', maxRotation: 0 } },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9', borderDash: [4,4] },
                        ticks: {
                            color: '#64748b',
                            callback: v => v >= 1000000 ? 'Rp '+(v/1000000).toFixed(0)+'M'
                                        : v >= 1000    ? 'Rp '+(v/1000).toFixed(0)+'K'
                                        : 'Rp '+v
                        }
                    }
                }
            }
        });

    });

    // Dashboard Filter Controls
    document.addEventListener('DOMContentLoaded', function() {
        const dateRangePicker = document.getElementById('dateRangePicker');
        const dateRangeText = document.getElementById('dateRangeText');
        const periodFilterBtn = document.getElementById('periodFilter');
        const exportBtn = document.getElementById('exportBtn');
        
        // Date Range Picker Click
        if (dateRangePicker) {
            dateRangePicker.addEventListener('click', function() {
                // Create date picker modal
                const modal = document.createElement('div');
                modal.className = 'modal fade';
                modal.innerHTML = `
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Select Date Range</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="startDate">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="endDate">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-telkom" id="applyDateRange">Apply</button>
                            </div>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
                
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
                
                // Set default dates from backend
                const currentStartDate = '{{ $startDate->format("Y-m-d") }}';
                const currentEndDate = '{{ $endDate->format("Y-m-d") }}';
                document.getElementById('startDate').value = currentStartDate;
                document.getElementById('endDate').value = currentEndDate;
                
                // Apply button
                document.getElementById('applyDateRange').addEventListener('click', function() {
                    const startDate = new Date(document.getElementById('startDate').value);
                    const endDate = new Date(document.getElementById('endDate').value);
                    
                    const options = { day: '2-digit', month: 'short', year: 'numeric' };
                    const startStr = startDate.toLocaleDateString('en-GB', options);
                    const endStr = endDate.toLocaleDateString('en-GB', options);
                    
                    dateRangeText.textContent = `${startStr} - ${endStr}`;
                    periodFilterBtn.textContent = 'Custom Range';
                    
                    bsModal.hide();
                    modal.remove();
                    
                    // Trigger filter event
                    filterDashboardData(startDate, endDate);
                });
                
                modal.addEventListener('hidden.bs.modal', function() {
                    modal.remove();
                });
            });
        }
        
        // Period Filter Dropdown
        const periodItems = document.querySelectorAll('#periodFilterMenu .dropdown-item');
        periodItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all items
                periodItems.forEach(i => i.classList.remove('active'));
                // Add active class to clicked item
                this.classList.add('active');
                
                const days = this.getAttribute('data-days');
                const text = this.textContent;
                
                if (days === 'custom') {
                    // Trigger date picker
                    dateRangePicker.click();
                } else {
                    const daysNum = parseInt(days);
                    const endDate = new Date();
                    const startDate = new Date();
                    startDate.setDate(startDate.getDate() - daysNum);
                    
                    const options = { day: '2-digit', month: 'short', year: 'numeric' };
                    const startStr = startDate.toLocaleDateString('en-GB', options);
                    const endStr = endDate.toLocaleDateString('en-GB', options);
                    
                    dateRangeText.textContent = `${startStr} - ${endStr}`;
                    periodFilterBtn.textContent = text;
                    
                    // Trigger filter event
                    filterDashboardData(startDate, endDate);
                }
            });
        });
        
        // Export Button
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                exportDashboardToCSV();
            });
        }
    });
    
    // Filter dashboard data - reload page with date parameters
    function filterDashboardData(startDate, endDate) {
        // Format dates as YYYY-MM-DD for URL parameters
        const startDateStr = startDate.toISOString().split('T')[0];
        const endDateStr = endDate.toISOString().split('T')[0];
        
        // Build URL with date parameters
        const url = new URL(window.location.href);
        url.searchParams.set('start_date', startDateStr);
        url.searchParams.set('end_date', endDateStr);
        
        // Reload page with new parameters
        window.location.href = url.toString();
    }
    
    // Export dashboard to CSV
    function exportDashboardToCSV() {
        const table = document.querySelector('table');
        if (!table) {
            alert('No table found to export');
            return;
        }
        
        let csv = [];
        const rows = table.querySelectorAll('tr');
        
        for (let i = 0; i < rows.length; i++) {
            const row = [];
            const cols = rows[i].querySelectorAll('td, th');
            
            for (let j = 0; j < cols.length; j++) {
                // Clean the text and escape quotes
                let text = cols[j].innerText.replace(/"/g, '""');
                row.push('"' + text + '"');
            }
            
            csv.push(row.join(','));
        }
        
        // Download CSV
        const csvContent = csv.join('\n');
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        
        const filename = 'dashboard_export_' + new Date().toISOString().slice(0, 10) + '.csv';
        link.setAttribute('href', url);
        link.setAttribute('download', filename);
        link.style.visibility = 'hidden';
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Show success message
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed';
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 250px;';
        alertDiv.innerHTML = `
            <i class="bi bi-check-circle me-2"></i>
            Dashboard data exported successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertDiv);
        
        setTimeout(function() {
            alertDiv.remove();
        }, 3000);
    }
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // === Donut Distribusi Metode ===
    const donutCtx = document.getElementById('interaksiDonutChart').getContext('2d');
    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Visit', 'Call', 'WhatsApp'],
            datasets: [{
                data: [{{ $interaksiVisit }}, {{ $interaksiCall }}, {{ $interaksiWhatsapp }}],
                backgroundColor: ['#6366f1', '#0ea5e9', '#22c55e'],
                hoverBackgroundColor: ['#4f46e5', '#0284c7', '#16a34a'],
                borderWidth: 4,
                borderColor: '#fff'
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#fff', bodyColor: '#1e293b', titleColor: '#1e293b',
                    borderColor: '#e2e8f0', borderWidth: 1, padding: 10
                }
            },
            cutout: '68%'
        }
    });
});
</script>
@endpush
