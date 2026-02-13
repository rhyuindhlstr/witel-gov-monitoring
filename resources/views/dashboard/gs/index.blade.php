@extends('layouts.gs')

@section('title', 'Executive Dashboard')

@section('content')

{{-- HEADER --}}
<div class="card mb-4 shadow-sm border-0"
     style="background:linear-gradient(90deg,#b30000,#ff1a1a);color:white">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">Selamat Datang, Tim Marketing!</h4>
            <small>Monitoring Sales Government Telkom Witel Lampung–Bengkulu</small>
        </div>
        
        {{-- GLOBAL FILTER --}}
        <form action="{{ route('dashboard.gs') }}" method="GET" class="d-flex gap-2">
            <select name="filter_month" class="form-select form-select-sm" onchange="this.form.submit()" style="width:auto; cursor:pointer;">
                <option value="">Semua Bulan</option>
                @foreach(range(1,12) as $m)
                    <option value="{{ $m }}" {{ request('filter_month') == $m ? 'selected' : '' }}>
                        {{ date('M', mktime(0, 0, 0, $m, 10)) }}
                    </option>
                @endforeach
            </select>
            <select name="filter_year" class="form-select form-select-sm" onchange="this.form.submit()" style="width:auto; cursor:pointer;">
                <option value="">Semua Tahun</option>
                @foreach($availableYears as $y)
                    <option value="{{ $y }}" {{ request('filter_year') == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
</div>

{{-- STATUS CARD --}}
<div class="row row-cols-2 row-cols-md-3 row-cols-xl-5 g-3 mb-4">
    @php
        $statuses = [
            'WIN' => [
                'label' => 'WIN',
                'icon' => 'bi-trophy-fill',
                'gradient' => 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)',
                'shadow' => '0 4px 15px rgba(56, 239, 125, 0.4)'
            ],
            'PROSPECT' => [
                'label' => 'PROSPECT',
                'icon' => 'bi-binoculars-fill',
                'gradient' => 'linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%)',
                'shadow' => '0 4px 15px rgba(0, 210, 255, 0.4)'
            ],
            'KEGIATAN_VALID' => [
                'label' => 'KEGIATAN VALID',
                'icon' => 'bi-check-circle-fill',
                'gradient' => 'linear-gradient(135deg, #8E2DE2 0%, #4A00E0 100%)',
                'shadow' => '0 4px 15px rgba(74, 0, 224, 0.4)'
            ],
            'LOSE' => [
                'label' => 'LOSE',
                'icon' => 'bi-x-circle-fill',
                'gradient' => 'linear-gradient(135deg, #cb2d3e 0%, #ef473a 100%)',
                'shadow' => '0 4px 15px rgba(239, 71, 58, 0.4)'
            ],
            'CANCEL' => [
                'label' => 'CANCEL',
                'icon' => 'bi-slash-circle-fill',
                'gradient' => 'linear-gradient(135deg, #232526 0%, #414345 100%)',
                'shadow' => '0 4px 15px rgba(65, 67, 69, 0.4)'
            ]
        ];
    @endphp

    @foreach ($statuses as $key => $config)
        <div class="col">
            <div class="card text-white border-0 status-card h-100" style="background: {{ $config['gradient'] }}; box-shadow: {{ $config['shadow'] }};">
                <div class="card-body text-center position-relative overflow-hidden d-flex flex-column justify-content-center align-items-center p-3">
                    {{-- Background Icon --}}
                    <i class="{{ $config['icon'] }} status-icon-bg"></i>
                    
                    <div class="mb-2 p-2 rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; backdrop-filter: blur(4px);">
                        <i class="{{ $config['icon'] }} fs-5"></i>
                    </div>
                    
                    <small class="text-uppercase fw-bold opacity-90" style="font-size: 0.7rem; letter-spacing: 1px;">{{ $config['label'] }}</small>
                    <h3 class="fw-bold mb-0 mt-1">{{ $statusCount[$key] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- MAIN CONTENT GRID --}}
<div class="row g-4 mb-4">
    
    {{-- LEFT COLUMN: FINANCIAL & CHARTS (8/12) --}}
    <div class="col-xl-8">
        
        {{-- FINANCIAL PERFORMANCE OVERVIEW --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">Performance Overview</h5>
                        <small class="text-muted">Ringkasan finansial proyek berdasarkan estimasi vs realisasi</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                            <i class="bi bi-calendar-check me-1"></i> 
                            {{ request('filter_year') ?: date('Y') }}
                        </span>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-5 border-end">
                        <div class="mb-4">
                            <small class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 1px;">Total Estimasi</small>
                            <h3 class="fw-bold text-dark mb-0">Rp {{ number_format($financialData['estimasi'], 0, ',', '.') }}</h3>
                        </div>
                        <div>
                            <small class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 1px;">Total Realisasi</small>
                            <h3 class="fw-bold text-success mb-0">Rp {{ number_format($financialData['realisasi'], 0, ',', '.') }}</h3>
                        </div>
                    </div>
                    <div class="col-md-7 ps-md-5">
                        <div class="d-flex justify-content-between align-items-end mb-2">
                            <span class="fw-bold text-dark">Achievement Rate</span>
                            <span class="fw-bold {{ $financialData['percentage'] >= 100 ? 'text-success' : 'text-primary' }} fs-4">
                                {{ number_format($financialData['percentage'], 1) }}%
                            </span>
                        </div>
                        <div class="progress mb-3" style="height: 10px; border-radius: 20px; background-color: #f1f3f5;">
                            <div class="progress-bar {{ $financialData['percentage'] >= 100 ? 'bg-success' : 'bg-primary' }}" 
                                 role="progressbar" 
                                 style="width: {{ min($financialData['percentage'], 100) }}%; border-radius: 20px;">
                            </div>
                        </div>
                        @if($financialData['has_trend'])
                            <div class="d-flex align-items-center mt-3">
                                @php $isPositive = $financialData['trend_value'] >= 0; @endphp
                                <span class="badge rounded-pill {{ $isPositive ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $isPositive ? 'text-success' : 'text-danger' }} px-2 py-1 me-2">
                                    <i class="bi {{ $isPositive ? 'bi-arrow-up-short' : 'bi-arrow-down-short' }}"></i>
                                    {{ number_format(abs($financialData['trend_value']), 1) }}%
                                </span>
                                <small class="text-muted">{{ $financialData['trend_label'] }}</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- CHARTS ROW --}}
        <div class="row g-4">
            {{-- WILAYAH CHART --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h6 class="fw-bold mb-0">Sebaran Proyek per Wilayah</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div style="height: 250px; position: relative;">
                            <canvas id="chartWilayah"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PIE CHART --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h6 class="fw-bold mb-0">Proporsi Status Proyek</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div style="height: 250px; position: relative;">
                            <canvas id="chartNilai"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT COLUMN: LEADERBOARD (4/12) --}}
    <div class="col-xl-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-3">
                <h5 class="fw-bold mb-0" style="font-family: 'Inter', sans-serif; color: #2d3436;">Top 5 Account Manager</h5>
                <small class="text-muted">Berdasarkan Proyek WIN & Total Proyek</small>
            </div>
            <div class="card-body px-4 pb-4">
                @foreach($topAMs as $index => $am)
                    @php
                        $rank = $index + 1;
                        // Visual Ranking Colors
                        $badgeBg = match($rank) {
                            1 => '#d1e7dd', // Soft Green
                            2 => '#cfe2ff', // Soft Blue
                            3 => '#e0cffc', // Soft Purple
                            default => '#f8f9fa' // Neutral Gray
                        };
                        $badgeColor = match($rank) {
                            1 => '#0f5132',
                            2 => '#084298',
                            3 => '#3d0a91',
                            default => '#6c757d'
                        };
                        // Progress Bar Calculation
                        $percentage = $chartNilai['count_total'] > 0 ? ($am->total_proyek / $chartNilai['count_total']) * 100 : 0;
                    @endphp
                    
                    <div class="d-flex align-items-center mb-3" style="{{ !$loop->last ? 'border-bottom: 1px solid #f1f3f5; padding-bottom: 12px;' : '' }}">
                        {{-- RANK BADGE --}}
                        <div class="d-flex align-items-center justify-content-center rounded-circle me-3 flex-shrink-0" 
                             style="width: 32px; height: 32px; background-color: {{ $badgeBg }}; color: {{ $badgeColor }}; font-weight: bold; font-size: 14px;">
                            {{ $rank }}
                        </div>
                        
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-dark" style="font-size: 14px;">{{ $am->nama_am }}</span>
                                <div class="text-end">
                                    <span class="fw-bold text-dark" style="font-size: 15px;">{{ $am->total_proyek }}</span>
                                    <small class="text-muted ms-1" style="font-size: 11px;">Proyek</small>
                                    @if($am->total_win > 0)
                                        <span class="badge bg-success ms-2" style="font-size: 10px; padding: 3px 6px;">{{ $am->total_win }} WIN</span>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- MINI PROGRESS BAR --}}
                            <div class="progress" style="height: 6px; background-color: #f8f9fa; border-radius: 10px;">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: {{ $percentage }}%; background-color: var(--telkom-red); border-radius: 10px;" 
                                     aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- AGENDA --}}
<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-0">Agenda Aktivitas Marketing</h5>
            <small class="text-muted">Jadwal dan log aktivitas terbaru</small>
        </div>
        <a href="{{ route('aktivitas-marketing.index') }}" class="btn btn-sm btn-light text-primary fw-bold">Lihat Semua</a>
    </div>
    <div class="card-body p-0 mt-2">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                <tr>
                    <th class="ps-4 py-3" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">No</th>
                    <th class="py-3" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Tanggal</th>
                    <th class="py-3" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Wilayah</th>
                    <th class="py-3" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">ID AM</th>
                    <th class="py-3" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Nama AM</th>
                    <th class="py-3" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Judul Proyek</th>
                    <th class="py-3" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Jenis</th>
                    <th class="pe-4 py-3" style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($aktivitasTerbaru as $a)
                    <tr>
                        <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                        <td class="fw-medium">{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</td>
                        <td>{{ $a->peluang->wilayah->nama_wilayah ?? '-' }}</td>
                        <td class="font-monospace small text-muted">{{ $a->peluang->id_am ?? '-' }}</td>
                        <td class="text-primary fw-medium">{{ $a->peluang->nama_am ?? '-' }}</td>
                        <td class="fw-bold text-dark">{{ $a->peluang->judul_proyek ?? '-' }}</td>
                        <td>
                            @php
                                $badgeColor = match(strtoupper($a->jenis_aktivitas)) {
                                    'PRESENTASI', 'VISIT', 'CALL', 'MEETING' => 'info',
                                    'NEGOSIASI', 'DEAL' => 'success',
                                    'LOSE', 'CANCEL' => 'danger',
                                    default => 'primary',
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeColor }} bg-opacity-10 text-{{ $badgeColor }} border border-{{ $badgeColor }} rounded-pill px-3">
                                {{ strtoupper($a->jenis_aktivitas) }}
                            </span>
                        </td>
                        <td class="pe-4 text-muted text-truncate" style="max-width: 200px;" title="{{ $a->hasil ?? '-' }}">
                            {{ $a->hasil ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-3">
                            Tidak ada agenda hari ini
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.bg-purple {
    background:#6f42c1;
}

/* Status Card Animation & Style */
.status-card {
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}
.status-card:hover {
    transform: translateY(-8px) scale(1.02);
    z-index: 2;
}
.status-icon-bg {
    position: absolute;
    right: -10px;
    bottom: -10px;
    font-size: 4.5rem;
    opacity: 0.15;
    transform: rotate(-15deg);
    transition: all 0.3s ease;
}
.status-card:hover .status-icon-bg {
    transform: rotate(0deg) scale(1.1);
    opacity: 0.25;
}
</style>
@endpush

@push('scripts')
<script>
// Chart Wilayah (Bar Chart)
// Mapping Nama Wilayah -> ID untuk Drill Down
const wilayahMap = {!! json_encode($peluangWilayah->pluck('id', 'nama_wilayah')) !!};

var ctxWilayah = document.getElementById("chartWilayah");
new Chart(ctxWilayah, {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartWilayah->keys()) !!},
        datasets: [{
            label: 'Jumlah Proyek',
            data: {!! json_encode($chartWilayah->values()) !!},
            backgroundColor: '#e30613',
            borderRadius: 4,
            barThickness: 20
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
            x: { grid: { display: false } }
        },
        onHover: (event, chartElement) => {
            event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
        },
        onClick: (event, elements) => {
            if (elements.length > 0) {
                const index = elements[0].index;
                const label = event.chart.data.labels[index];
                const wilayahId = wilayahMap[label];
                if (wilayahId) {
                    window.location.href = "{{ route('peluang-gs.index') }}?wilayah=" + wilayahId;
                }
            }
        }
    }
});

// Chart Pie (Realisasi)
var ctx = document.getElementById("chartNilai");
new Chart(ctx, {
    type: 'doughnut', // Changed to Doughnut for modern look
    data:{
        labels: ['Total Proyek', 'Proyek Terealisasi'],
        datasets:[{
            data:[
                {{ $chartNilai['count_total'] }},
                {{ $chartNilai['count_realisasi'] }}
            ],
            backgroundColor: ['#e9ecef', '#198754'], // Gray for total, Green for realized
            hoverBackgroundColor: ['#dee2e6', '#157347'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
            cutout: '70%',
        }],
    },
    options:{
        maintainAspectRatio: false,
        plugins:{
            legend: {
                display: true,
                position: 'bottom',
                labels: { usePointStyle: true, padding: 20 }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let label = context.label || '';
                        if (label) {
                            label += ': ';
                        }
                        return label + context.raw + ' Proyek';
                    }
                }
            }
        }
    }
});
</script>
@endpush
