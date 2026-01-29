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
    <div class="row">
        <!-- Performance Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-dark">Performance Overview</h6>
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
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-dark">Status Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2" style="height: 250px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="me-2">
                            <i class="bi bi-circle-fill text-danger"></i> Lancar
                        </span>
                        <span class="me-2">
                            <i class="bi bi-circle-fill text-warning"></i> Tertunda
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="card shadow-sm mb-4">
        <div class="card-header py-3 bg-white border-bottom-0">
            <h6 class="m-0 font-weight-bold text-dark">Pembayaran Terakhir</h6>
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
                                    <div class="avatar-sm me-2 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; color: #6c757d; font-weight: bold;">
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
                            <td class="text-end pe-4 fw-bold">
                                Rp {{ number_format($payment->nominal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Belum ada data pembayaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Performance Chart
        const ctx = document.getElementById('performanceChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue',
                    data: @json($chartData),
                    backgroundColor: '#EF4444',
                    borderRadius: 4,
                    barThickness: 20
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#2C3E50',
                        bodyColor: '#2C3E50',
                        borderColor: '#E9ECEF',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            borderDash: [2, 2],
                            color: '#e9ecef'
                        },
                        ticks: {
                            callback: function(value, index, values) {
                                if (value >= 1000000) return 'Rp ' + (value/1000000).toFixed(0) + 'M';
                                if (value >= 1000) return 'Rp ' + (value/1000).toFixed(0) + 'K';
                                return 'Rp ' + value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Status Chart
        const pendingCount = {{ $pendingPayments }};
        const totalCount = {{ $totalSales }}; // proxy total transactions
        // Prevent negative success count if pending > total which shouldn't happen but fallback
        const successCount = Math.max(0, totalCount - pendingCount);

        const ctx2 = document.getElementById('statusChart').getContext('2d');
        const myPieChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Lancar', 'Tertunda'],
                datasets: [{
                    data: [successCount, pendingCount],
                    backgroundColor: ['#EF4444', '#ffc107'],
                    hoverBackgroundColor: ['#DC2626', '#ffca2c'],
                    borderWidth: 0
                }],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        bodyColor: '#2C3E50',
                        borderColor: '#E9ECEF',
                        borderWidth: 1,
                        padding: 10
                    }
                },
                cutout: '75%',
            },
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
@endpush
