@extends('layouts.gs')

@section('content')

{{-- HEADER --}}
<div class="card mb-4 shadow"
     style="background:linear-gradient(90deg,#b30000,#ff1a1a);color:white">
    <div class="card-body">
        <h4 class="fw-bold mb-1">Selamat Datang, Tim Marketing!</h4>
        <small>Monitoring penjualan Government Telkom Witel Lampung–Bengkulu</small>
    </div>
</div>

{{-- STATUS CARD --}}
<div class="row g-3 mb-3">
    @php
        $colors = [
            'WIN' => 'success',
            'PROSPECT' => 'primary',
            'KEGIATAN_VALID' => 'purple',
            'LOSE' => 'danger',
            'CANCEL' => 'dark'
        ];
    @endphp

    @foreach ($colors as $status => $color)
        <div class="col-md-2">
            <div class="card text-white bg-{{ $color }} shadow-sm">
                <div class="card-body text-center">
                    <small>{{ $status }}</small>
                    <h4 class="fw-bold">{{ $statusCount[$status] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- TOTAL --}}

{{-- WILAYAH & CHART --}}
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header fw-semibold">
                Peluang Proyek per Wilayah
            </div>
            <div class="card-body">
                @foreach ($peluangWilayah as $w)
                    <div class="mb-2">
                        <small class="fw-semibold">{{ $w->nama_wilayah }}</small>
                        <div class="progress">
                            <div class="progress-bar bg-danger"
                                 style="width: {{ $w->peluang_proyek_g_s_count * 20 }}%">
                                {{ $w->peluang_proyek_g_s_count }} Proyek
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header fw-semibold">
                Nilai Estimasi vs Realisasi
            </div>
            <div class="card-body">
                <canvas id="chartNilai"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- AGENDA --}}
<div class="card shadow-sm">
    <div class="card-header fw-semibold">
        Agenda Aktivitas Marketing
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-danger">
                <tr>
                    <th>Tanggal</th>
                    <th>Aktivitas</th>
                    <th>Satker</th>
                    <th>Nama GC</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($aktivitasTerbaru as $a)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('Y-m-d') }}</td>
                        <td>
                            @php
                                $badgeColor = match(strtoupper($a->jenis_aktivitas)) {
                                    'PRESENTASI', 'VISIT', 'CALL', 'MEETING' => 'info',
                                    'NEGOSIASI', 'DEAL' => 'success',
                                    'LOSE', 'CANCEL' => 'danger',
                                    default => 'primary',
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeColor }}">
                                {{ strtoupper($a->jenis_aktivitas) }}
                            </span>
                        </td>
                        <td>{{ $a->peluang->satker ?? '-' }}</td>
                        <td>{{ $a->peluang->nama_gc ?? '-' }}</td>
                        <td>{{ $a->keterangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">
                            Tidak ada agenda hari ini
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('styles')
<style>
.bg-purple {
    background:#6f42c1;
}
</style>
@endpush

@push('scripts')
<script>
new Chart(document.getElementById('chartNilai'),{
    type:'line',
    data:{
        labels:['Estimasi','Realisasi'],
        datasets:[{
            data:[
                {{ $chartNilai['estimasi'] }},
                {{ $chartNilai['realisasi'] }}
            ],
            borderColor:'#e30613', // CHANGED TO RED
            backgroundColor:'rgba(227, 6, 19, 0.1)', // CHANGED TO LIGHT RED
            tension:.4,
            fill:true
        }]
    },
    options:{
        plugins:{legend:{display:false}},
        scales:{
            y:{
                ticks:{
                    callback:v=>'Rp '+v.toLocaleString('id-ID')
                }
            }
        }
    }
});
</script>
@endpush
