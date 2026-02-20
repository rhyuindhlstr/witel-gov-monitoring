@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

    {{-- ════════════════════════════════════════════
         1. USER STATS
    ════════════════════════════════════════════ --}}
    <p class="text-uppercase small fw-bold text-muted ls-1 mb-3">User Statistics</p>
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100" style="border-radius:16px;">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white bg-danger" style="width:48px;height:48px;flex-shrink:0;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <div class="h3 fw-bold mb-0">{{ $totalWilayah }}</div>
                        <small class="text-muted">Wilayah</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100" style="border-radius:16px;">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width:48px;height:48px;flex-shrink:0;background:#0ea5e9;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <div class="h3 fw-bold mb-0">{{ $totalUsers }}</div>
                        <small class="text-muted">Total User</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100" style="border-radius:16px;">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width:48px;height:48px;flex-shrink:0;background:#f59e0b;">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div>
                        <div class="h3 fw-bold mb-0">{{ $totalAdmins }}</div>
                        <small class="text-muted">Admin</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100" style="border-radius:16px;">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white bg-success" style="width:48px;height:48px;flex-shrink:0;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="text-center">
                            <a href="{{ route('dashboard.ssgs') }}" class="text-decoration-none text-dark">
                                <div class="h4 fw-bold mb-0">{{ $totalSSGS }}</div>
                                <small class="text-muted" style="font-size:.7em;">SSGS</small>
                            </a>
                        </div>
                        <div class="vr"></div>
                        <div class="text-center">
                            <a href="{{ route('dashboard.gs') }}" class="text-decoration-none text-dark">
                                <div class="h4 fw-bold mb-0">{{ $totalGS }}</div>
                                <small class="text-muted" style="font-size:.7em;">GS</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════
         2. SSGS PERFORMANCE STATS
    ════════════════════════════════════════════ --}}
    <p class="text-uppercase small fw-bold text-muted ls-1 mb-3">SSGS Performance</p>
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 text-white" style="border-radius:16px;background:linear-gradient(135deg,#EF4444 0%,#DC2626 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-uppercase small fw-bold text-white-50">Total Transaksi</div>
                        <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                            <i class="bi bi-cart-fill text-white"></i>
                        </div>
                    </div>
                    <div class="h2 mb-0 fw-bold">{{ $totalSales }}</div>
                    <div class="mt-2 small text-white-50">Semua waktu</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100" style="border-radius:16px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-uppercase small fw-bold text-muted">Pelanggan Baru</div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-dark text-white" style="width:40px;height:40px;">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline gap-2">
                        <div class="h2 mb-0 fw-bold">{{ $newCustomers }}</div>
                        <div class="small {{ $customerGrowth >= 0 ? 'text-success' : 'text-danger' }}">
                            @if($customerGrowth >= 0)
                                <i class="bi bi-arrow-up-short"></i>{{ number_format($customerGrowth,1) }}%
                            @else
                                <i class="bi bi-arrow-down-short"></i>{{ number_format(abs($customerGrowth),1) }}%
                            @endif
                            <span class="text-muted">vs bulan lalu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100" style="border-radius:16px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-uppercase small fw-bold text-muted">Tagihan Tertunda</div>
                        <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                    <div class="h2 mb-0 fw-bold">{{ $pendingPayments }}</div>
                    <div class="mt-2 small text-muted">Perlu tindak lanjut</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100" style="border-radius:16px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="text-uppercase small fw-bold text-muted">Total Pendapatan</div>
                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                    <div class="h2 mb-0 fw-bold">Rp {{ number_format($totalRevenue,0,',','.') }}</div>
                    <div class="mt-2 small text-muted">Semua waktu (lunas)</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════
         3. GS PERFORMANCE STATS
    ════════════════════════════════════════════ --}}
    <p class="text-uppercase small fw-bold text-muted ls-1 mb-3">GS Performance</p>
    <div class="row g-3 mb-5">
        @php
            $gsCards = [
                ['label'=>'WIN',           'color'=>'#22c55e', 'val'=>$gsWin],
                ['label'=>'PROSPECT',      'color'=>'#3b82f6', 'val'=>$gsProspect],
                ['label'=>'KEGIATAN VALID','color'=>'#6f42c1', 'val'=>$gsKegiatanValid],
                ['label'=>'LOSE',          'color'=>'#EF4444', 'val'=>$gsLose],
                ['label'=>'CANCEL',        'color'=>'#374151', 'val'=>$gsCancel],
            ];
        @endphp
        @foreach($gsCards as $card)
        <div class="col">
            <div class="card shadow-sm border-0 h-100 text-white text-center" style="border-radius:16px;background:{{ $card['color'] }};">
                <div class="card-body p-3">
                    <div class="small fw-bold text-uppercase mb-1 text-white-50">{{ $card['label'] }}</div>
                    <h3 class="fw-bold mb-0">{{ $card['val'] }}</h3>
                    @if($gsTotalProyek > 0)
                    <div class="mt-1" style="font-size:.75rem;opacity:.8;">{{ round($card['val']/$gsTotalProyek*100) }}%</div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ════════════════════════════════════════════
         4. SSGS CHARTS ROW (matches SSGS dashboard)
    ════════════════════════════════════════════ --}}
    <p class="text-uppercase small fw-bold text-muted ls-1 mb-3">SSGS — Revenue Overview</p>
    <div class="row mb-4">
        {{-- Left: Performance Line Chart --}}
        <div class="col-xl-8 col-lg-7 d-flex flex-column mb-4 mb-lg-0">
            <div class="card shadow-sm flex-fill" style="border-radius:16px;">
                <div class="card-header py-3 px-4 bg-white border-bottom-0" style="border-radius:16px 16px 0 0;">
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
                        <form method="GET" action="{{ route('dashboard') }}" class="d-flex align-items-center gap-2">
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

        {{-- Right: Status Pembayaran + Distribusi Metode --}}
        <div class="col-xl-4 col-lg-5 d-flex flex-column gap-4">
            {{-- Status Pembayaran --}}
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

            {{-- Distribusi Metode Interaksi --}}
            <div class="card shadow-sm flex-fill" style="border-radius:16px;">
                <div class="card-header bg-white border-bottom-0 py-3 px-4 d-flex justify-content-between align-items-center" style="border-radius:16px 16px 0 0;">
                    <h6 class="m-0 fw-bold text-dark">Distribusi Metode Interaksi</h6>
                    <span class="badge rounded-pill text-bg-light border fw-semibold" style="font-size:.73rem;color:#374151;">Semua waktu</span>
                </div>
                <div class="card-body px-4 pb-4 pt-1">
                    @php
                        $totalM = max($totalInteraksi, 1);
                        $metodes = [
                            ['label'=>'Visit',    'color'=>'#6366f1', 'value'=>$interaksiVisit],
                            ['label'=>'Call',     'color'=>'#0ea5e9', 'value'=>$interaksiCall],
                            ['label'=>'WhatsApp', 'color'=>'#22c55e', 'value'=>$interaksiWhatsapp],
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
                                    {{ $totalM > 0 ? number_format($m['value']/$totalM*100,0) : 0 }}%
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

    {{-- ════════════════════════════════════════════
         5. GS — Financial Performance Overview
    ════════════════════════════════════════════ --}}
    <p class="text-uppercase small fw-bold text-muted ls-1 mb-3">GS — Project Analytics</p>

    {{-- Financial Overview Card --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h5 class="fw-bold text-dark mb-1">Performance Overview GS</h5>
                    <small class="text-muted">Ringkasan finansial proyek berdasarkan estimasi vs realisasi (semua waktu)</small>
                </div>
                <div class="d-flex gap-2">
                    <span class="badge rounded-pill text-bg-light border px-3 py-2">
                        <i class="bi bi-check2-circle me-1 text-success"></i>
                        {{ $gsAktif }} Aktif &nbsp;·&nbsp; {{ $gsSelesai }} Selesai
                    </span>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-5 border-end">
                    <div class="mb-4">
                        <small class="text-uppercase text-muted fw-bold" style="font-size:11px;letter-spacing:1px;">Total Estimasi</small>
                        <h3 class="fw-bold text-dark mb-0">Rp {{ number_format($gsFinancialData['estimasi'],0,',','.') }}</h3>
                    </div>
                    <div>
                        <small class="text-uppercase text-muted fw-bold" style="font-size:11px;letter-spacing:1px;">Total Realisasi</small>
                        <h3 class="fw-bold text-success mb-0">Rp {{ number_format($gsFinancialData['realisasi'],0,',','.') }}</h3>
                    </div>
                </div>
                <div class="col-md-7 ps-md-5">
                    <div class="d-flex justify-content-between align-items-end mb-2">
                        <span class="fw-bold text-dark">Achievement Rate</span>
                        <span class="fw-bold fs-4 {{ $gsFinancialData['percentage'] >= 100 ? 'text-success' : 'text-primary' }}">
                            {{ number_format($gsFinancialData['percentage'],1) }}%
                        </span>
                    </div>
                    <div class="progress mb-3" style="height:10px;border-radius:20px;background:#f1f3f5;">
                        <div class="progress-bar {{ $gsFinancialData['percentage'] >= 100 ? 'bg-success' : 'bg-primary' }}"
                             style="width:{{ min($gsFinancialData['percentage'],100) }}%;border-radius:20px;"></div>
                    </div>
                    <small class="text-muted">Berdasarkan {{ $gsFinancialData['total_proyek'] }} total proyek terdaftar</small>
                </div>
            </div>
        </div>
    </div>

    {{-- GS Charts: Wilayah + Proporsi Status + Top 5 AM --}}
    <div class="row g-4 mb-4">
        {{-- Left col (col-xl-8): Wilayah Bar + Proporsi Doughnut --}}
        <div class="col-xl-8">
            <div class="row g-4">
                {{-- Sebaran Proyek per Wilayah (vertical bar — same as GS dashboard) --}}
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h6 class="fw-bold mb-0">Sebaran Proyek per Wilayah</h6>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <div style="height:250px;position:relative;">
                                <canvas id="gsWilayahChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Proporsi Status Proyek (doughnut — same as GS dashboard) --}}
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h6 class="fw-bold mb-0">Proporsi Status Proyek</h6>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <div style="height:250px;position:relative;">
                                <canvas id="gsNilaiChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right col (col-xl-4): Top 5 AM Leaderboard --}}
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-3">
                    <h5 class="fw-bold mb-0" style="color:#2d3436;">Top 5 Account Manager</h5>
                    <small class="text-muted">Berdasarkan Proyek WIN & Total Proyek</small>
                </div>
                <div class="card-body px-4 pb-4">
                    @foreach($gsTopAMs as $index => $am)
                    @php
                        $rank = $index + 1;
                        $badgeBg    = match($rank) { 1=>'#d1e7dd', 2=>'#cfe2ff', 3=>'#e0cffc', default=>'#f8f9fa' };
                        $badgeColor = match($rank) { 1=>'#0f5132', 2=>'#084298', 3=>'#3d0a91', default=>'#6c757d' };
                        $pct = $gsChartNilai['count_total'] > 0 ? ($am->total_proyek / $gsChartNilai['count_total']) * 100 : 0;
                    @endphp
                    <div class="d-flex align-items-center mb-3" style="{{ !$loop->last ? 'border-bottom:1px solid #f1f3f5;padding-bottom:12px;' : '' }}">
                        <div class="d-flex align-items-center justify-content-center rounded-circle me-3 flex-shrink-0"
                             style="width:32px;height:32px;background:{{ $badgeBg }};color:{{ $badgeColor }};font-weight:bold;font-size:14px;">
                            {{ $rank }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-dark" style="font-size:14px;">{{ $am->nama_am }}</span>
                                <div class="text-end">
                                    <span class="fw-bold text-dark" style="font-size:15px;">{{ $am->total_proyek }}</span>
                                    <small class="text-muted ms-1" style="font-size:11px;">Proyek</small>
                                    @if($am->total_win > 0)
                                        <span class="badge bg-success ms-2" style="font-size:10px;padding:3px 6px;">{{ $am->total_win }} WIN</span>
                                    @endif
                                </div>
                            </div>
                            <div class="progress" style="height:6px;background:#f8f9fa;border-radius:10px;">
                                <div class="progress-bar" style="width:{{ $pct }}%;background:#e30613;border-radius:10px;"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @if($gsTopAMs->isEmpty())
                        <p class="text-muted text-center small mt-3">Belum ada data AM</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════
         6. GS AGENDA AKTIVITAS
    ════════════════════════════════════════════ --}}
    <div class="card shadow-sm mb-4" style="border-radius:16px;">
        <div class="card-header py-3 px-4 bg-white border-bottom-0 d-flex align-items-center justify-content-between" style="border-radius:16px 16px 0 0;">
            <h6 class="m-0 fw-bold text-dark">Agenda Aktivitas Marketing GS — Hari Ini</h6>
            <span class="badge rounded-pill text-bg-light border fw-semibold" style="font-size:.73rem;color:#374151;">{{ now()->format('d M Y') }}</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 ps-4">Tanggal</th>
                            <th class="border-0">Aktivitas</th>
                            <th class="border-0">Satker</th>
                            <th class="border-0">Nama GC</th>
                            <th class="border-0">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gsAktivitasTerbaru as $aktivitas)
                        <tr>
                            <td class="ps-4">{{ \Carbon\Carbon::parse($aktivitas->tanggal)->format('d M Y') }}</td>
                            <td>
                                @php
                                    $bc = match(strtoupper($aktivitas->jenis_aktivitas)) {
                                        'PRESENTASI','VISIT','CALL','MEETING' => 'info',
                                        'NEGOSIASI','DEAL'                   => 'success',
                                        'LOSE','CANCEL'                      => 'danger',
                                        default                              => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $bc }} text-uppercase">{{ $aktivitas->jenis_aktivitas }}</span>
                            </td>
                            <td>{{ $aktivitas->peluang->satker ?? '-' }}</td>
                            <td>{{ $aktivitas->peluang->nama_gc ?? '-' }}</td>
                            <td>{{ $aktivitas->keterangan }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted">Tidak ada agenda hari ini</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════
         7. RECENT SSGS PAYMENTS
    ════════════════════════════════════════════ --}}
    <div class="card shadow-sm mb-4" style="border-radius:16px;">
        <div class="card-header py-3 px-4 bg-white border-bottom-0 d-flex align-items-center justify-content-between" style="border-radius:16px 16px 0 0;">
            <h6 class="m-0 fw-bold text-dark">Pembayaran Terakhir (SSGS)</h6>
            <span class="badge rounded-pill text-bg-light border fw-semibold" style="font-size:.73rem;color:#374151;">5 transaksi terbaru</span>
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
                                        {{ strtoupper(substr($payment->pelanggan->nama_pelanggan,0,1)) }}
                                    </div>
                                    <span class="fw-bold text-dark">{{ $payment->pelanggan->nama_pelanggan }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $payment->status_badge_color }} bg-opacity-10 text-{{ $payment->status_badge_color }}">
                                    {{ ucfirst($payment->status_pembayaran) }}
                                </span>
                            </td>
                            <td class="text-end pe-4 fw-bold">Rp {{ number_format($payment->nominal,0,',','.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data pembayaran</td></tr>
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
document.addEventListener('DOMContentLoaded', function () {

    // ── SSGS Performance Line Chart ──
    const perfLabels   = @json($perfLabels);
    const perfActual   = @json($perfActual);
    const perfExpected = @json($perfExpected);

    const ctx = document.getElementById('performanceChart').getContext('2d');
    const gradRed  = ctx.createLinearGradient(0,0,0,280);
    gradRed.addColorStop(0,'rgba(239,68,68,0.15)'); gradRed.addColorStop(1,'rgba(239,68,68,0)');
    const gradGray = ctx.createLinearGradient(0,0,0,280);
    gradGray.addColorStop(0,'rgba(148,163,184,0.12)'); gradGray.addColorStop(1,'rgba(148,163,184,0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: perfLabels,
            datasets: [
                {
                    label: 'Revenue Aktual',
                    data: perfActual,
                    borderColor:'#EF4444', backgroundColor: gradRed,
                    pointRadius:4, pointHoverRadius:8,
                    pointBackgroundColor:'#fff', pointBorderColor:'#EF4444', pointBorderWidth:2,
                    tension:0.45, fill:true, borderWidth:2.5,
                },
                {
                    label: 'Revenue Ekspektasi',
                    data: perfExpected,
                    borderColor:'#94a3b8', backgroundColor: gradGray,
                    pointRadius:4, pointHoverRadius:8,
                    pointBackgroundColor:'#fff', pointBorderColor:'#94a3b8', pointBorderWidth:2,
                    borderDash:[6,4], tension:0.45, fill:true, borderWidth:2,
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            interaction: { mode:'index', intersect:false },
            plugins: {
                legend: { display:false },
                tooltip: {
                    backgroundColor:'#fff', titleColor:'#1e293b', bodyColor:'#475569',
                    borderColor:'#e2e8f0', borderWidth:1, padding:12, boxPadding:5, cornerRadius:10,
                    callbacks: {
                        label: function(c) {
                            const v = c.raw;
                            const fmt = v>=1000000 ? 'Rp '+(v/1000000).toFixed(1)+' Jt'
                                      : v>=1000    ? 'Rp '+(v/1000).toFixed(0)+' K' : 'Rp '+v;
                            return ' '+c.dataset.label+': '+fmt;
                        },
                        afterBody: function(items) {
                            const a = items[0]?.raw ?? 0, e = items[1]?.raw ?? 0;
                            if (e>0 && a<e) {
                                const gap=e-a, pct=((gap/e)*100).toFixed(1);
                                const fg = gap>=1000000?'Rp '+(gap/1000000).toFixed(1)+' Jt':gap>=1000?'Rp '+(gap/1000).toFixed(0)+' K':'Rp '+gap;
                                return [' ─────────────────',' Gap: '+fg+' ('+pct+'%)'];
                            }
                            return [];
                        }
                    }
                }
            },
            scales: {
                x: { grid:{display:false}, ticks:{color:'#94a3b8',maxRotation:0} },
                y: {
                    beginAtZero:true,
                    grid:{color:'#f1f5f9',borderDash:[4,4]},
                    ticks:{color:'#64748b',callback:v=>v>=1000000?'Rp '+(v/1000000).toFixed(0)+'M':v>=1000?'Rp '+(v/1000).toFixed(0)+'K':'Rp '+v}
                }
            }
        }
    });

    // ── SSGS Distribusi Metode Donut ──
    const donutCtx = document.getElementById('interaksiDonutChart').getContext('2d');
    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Visit','Call','WhatsApp'],
            datasets:[{
                data:[{{ $interaksiVisit }},{{ $interaksiCall }},{{ $interaksiWhatsapp }}],
                backgroundColor:['#6366f1','#0ea5e9','#22c55e'],
                hoverBackgroundColor:['#4f46e5','#0284c7','#16a34a'],
                borderWidth:4, borderColor:'#fff'
            }]
        },
        options: {
            maintainAspectRatio:false,
            plugins:{
                legend:{display:false},
                tooltip:{backgroundColor:'#fff',bodyColor:'#1e293b',titleColor:'#1e293b',borderColor:'#e2e8f0',borderWidth:1,padding:10}
            },
            cutout:'68%'
        }
    });


    // ── GS Sebaran Proyek per Wilayah (Vertical Bar — same as GS dashboard) ──
    const wilayahCtx = document.getElementById('gsWilayahChart').getContext('2d');
    new Chart(wilayahCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($gsChartWilayah->keys()) !!},
            datasets:[{
                label: 'Jumlah Proyek',
                data: {!! json_encode($gsChartWilayah->values()) !!},
                backgroundColor: '#e30613',
                borderRadius: 4,
                barThickness: 20
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2,4] } },
                x: { grid: { display: false } }
            }
        }
    });

    // ── GS Proporsi Status Proyek (Doughnut — same as GS dashboard) ──
    const nilaiCtx = document.getElementById('gsNilaiChart').getContext('2d');
    new Chart(nilaiCtx, {
        type: 'doughnut',
        data: {
            labels: ['Total Proyek', 'Proyek Terealisasi'],
            datasets:[{
                data: [{{ $gsChartNilai['count_total'] }}, {{ $gsChartNilai['count_realisasi'] }}],
                backgroundColor: ['#e9ecef', '#198754'],
                hoverBackgroundColor: ['#dee2e6', '#157347'],
                hoverBorderColor: 'rgba(234,236,244,1)',
                cutout: '70%'
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'bottom', labels: { usePointStyle: true, padding: 20 } },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            return (ctx.label || '') + ': ' + ctx.raw + ' Proyek';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush