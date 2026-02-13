@extends('layouts.gs')

@section('title', 'Peluang Proyek GS')

@section('content')

<style>
    .table-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-top: 24px;
        border: 1px solid #f1f3f5;
    }
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }
    .table-enterprise {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }
    .table-enterprise thead th {
        background-color: rgba(227,6,19,0.08);
        color: #b30000;
        font-weight: 600;
        font-size: 14px;
        height: 56px;
        padding: 0 20px;
        border-bottom: 1px solid #f1f3f5;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        white-space: nowrap;
    }
    .table-enterprise tbody tr {
        height: 56px;
        border-bottom: 1px solid #f8f9fa;
        transition: background-color 0.15s ease;
    }
    .table-enterprise tbody tr:nth-child(even) {
        background-color: #fafafa;
    }
    .table-enterprise tbody tr:hover {
        background-color: #f1f3f5;
    }
    .table-enterprise td {
        padding: 0 20px;
        vertical-align: middle;
        font-size: 14px;
        color: #343a40;
    }
</style>

{{-- HEADER --}}
<div class="card mb-4 shadow"
     style="background:linear-gradient(90deg,#b30000,#ff1a1a);color:white;border:none;border-radius:12px;">
    <div class="card-body">
        <h4 class="fw-bold mb-1">Data Peluang Proyek GS</h4>
        <small>
            Monitoring dan pengelolaan peluang proyek Government Service
        </small>
    </div>
</div>

{{-- ACTION + FILTER --}}
<div class="filter-card">
    <div class="filter-card-body">
        <form id="filterForm" method="GET" action="{{ route('peluang-gs.index') }}">
            <div class="filter-action-wrapper">
                
                {{-- FILTER GROUP (LEFT) --}}
                <div class="filter-group">
                    {{-- Status --}}
                    <div>
                        <label class="form-label-dashboard">Status Proyek</label>
                        <select name="status" class="form-control-dashboard" onchange="handleFilter(this)">
                            <option value="">Semua Status</option>
                            @foreach(['PROSPECT','KEGIATAN_VALID','WIN','LOSE','CANCEL'] as $s)
                                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                                    {{ str_replace('_', ' ', $s) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Wilayah --}}
                    <div>
                        <label class="form-label-dashboard">Wilayah</label>
                        <select name="wilayah" class="form-control-dashboard" onchange="handleFilter(this)">
                            <option value="">Semua Wilayah</option>
                            @foreach($wilayahs as $w)
                                <option value="{{ $w->id }}" {{ request('wilayah') == $w->id ? 'selected' : '' }}>
                                    {{ $w->nama_wilayah }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tahun --}}
                    <div>
                        <label class="form-label-dashboard">Tahun</label>
                        <select name="tahun" class="form-control-dashboard" onchange="handleFilter(this)">
                            <option value="">Semua Tahun</option>
                            @foreach($peluang->pluck('start_pelaksanaan')->filter()->map(fn($d)=>date('Y',strtotime($d)))->unique() as $t)
                                <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>
                                    {{ $t }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- ACTION BUTTON GROUP (RIGHT) --}}
                <div class="action-group">
                    {{-- Import --}}
                    <a href="{{ route('peluang-gs.import.form') }}" class="btn-dashboard btn-dashboard-success">
                        <i class="bi bi-file-earmark-spreadsheet"></i> 
                        <span class="d-none d-sm-inline">Import</span>
                    </a>

                    {{-- Export --}}
                    <a href="{{ route('peluang-gs.export') }}" class="btn-dashboard btn-dashboard-outline">
                        <i class="bi bi-download"></i> 
                        <span class="d-none d-sm-inline">Export</span>
                    </a>

                    {{-- Tambah (Primary) --}}
                    <a href="{{ route('peluang-gs.create') }}" class="btn-dashboard btn-dashboard-primary">
                        <i class="bi bi-plus-lg"></i> 
                        <span>Tambah Peluang</span>
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- ALERT SUCCESS UPDATE --}}
@if(session('success_update'))
<div id="alert-success"
     class="alert alert-success alert-dismissible fade show shadow"
     role="alert"
     style="font-weight:600">
    ✅ {{ session('success_update') }}
</div>

<script>
    setTimeout(() => {
        const alertBox = document.getElementById('alert-success');
        if(alertBox){
            alertBox.classList.remove('show');
            alertBox.classList.add('hide');
            setTimeout(() => alertBox.remove(), 500);
        }
    }, 20000); // 20 DETIK
</script>
@endif

{{-- TABLE --}}
<div class="table-card">
    <div class="table-wrapper">
        <table class="table-enterprise">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Wilayah</th>
                    <th>ID AM</th>
                    <th>Nama AM</th>
                    <th>Nama GC</th>
                    <th>Satker</th>
                    <th>Judul Proyek</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>MYTens</th>
                    <th>Estimasi</th>
                    <th>Realisasi</th>
                    <th>Scaling</th>
                    <th>Pengadaan</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody id="realDataBody">
            @forelse ($peluang as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->wilayah->nama_wilayah ?? '-' }}</td>
                    <td>{{ $item->id_am }}</td>
                    <td>{{ $item->nama_am }}</td>
                    <td>{{ $item->nama_gc }}</td>
                    <td>{{ $item->satker }}</td>
                    <td class="fw-semibold">{{ $item->judul_proyek }}</td>
                    <td>{{ $item->jenis_proyek }}</td>

                    {{-- STATUS BADGE DINAMIS --}}
                    <td class="text-center">
                        @php
                            $badge = match($item->status_proyek){
                                'WIN' => 'badge-status-win',
                                'LOSE' => 'badge-status-lose',
                                'CANCEL' => 'badge-status-cancel',
                                'KEGIATAN_VALID' => 'badge-status-kegiatan',
                                default => 'badge-status-prospect'
                            };
                        @endphp
                        <span class="badge-status {{ $badge }}">
                            {{ $item->status_proyek }}
                        </span>
                    </td>

                    <td class="text-center">
                        <span class="badge bg-info text-dark">
                            {{ $item->status_mytens }}
                        </span>
                    </td>

                    <td class="text-end">Rp {{ number_format($item->nilai_estimasi,0,',','.') }}</td>
                    <td class="text-end">
                        {{ $item->nilai_realisasi ? 'Rp '.number_format($item->nilai_realisasi,0,',','.') : '-' }}
                    </td>
                    <td class="text-end">
                        {{ $item->nilai_scaling ? 'Rp '.number_format($item->nilai_scaling,0,',','.') : '-' }}
                    </td>

                    <td>{{ $item->mekanisme_pengadaan }}</td>
                    <td class="text-center">{{ $item->start_pelaksanaan }}</td>
                    <td class="text-center">{{ $item->end_pelaksanaan }}</td>

                    {{-- AKSI --}}
                    <td class="text-end">
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-sm btn-light border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical text-muted"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius: 12px;">
                                {{-- DETAIL --}}
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                                       href="{{ route('peluang-gs.show',$item->id) }}">
                                        <i class="bi bi-eye text-primary"></i> Detail
                                    </a>
                                </li>
                                {{-- EDIT --}}
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                                       href="{{ route('peluang-gs.edit',$item->id) }}">
                                        <i class="bi bi-pencil text-warning"></i> Edit
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                {{-- HAPUS --}}
                                <li>
                                    <form method="POST"
                                          action="{{ route('peluang-gs.destroy',$item->id) }}"
                                          class="form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="dropdown-item text-danger d-flex align-items-center gap-2 py-2">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="17" class="text-center py-4 text-muted">
                        Belum ada data peluang proyek
                    </td>
                </tr>
            @endforelse
            </tbody>

            {{-- SKELETON LOADING BODY --}}
            <tbody id="skeletonBody" style="display: none;">
                @for($i=0; $i<8; $i++)
                    <tr>
                        @for($j=0; $j<17; $j++)
                            <td><div class="skeleton-bar" style="width: {{ rand(50, 90) }}%;"></div></td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>


@if(session('success_update'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: 'Data peluang proyek berhasil diperbarui',
    timer: 2500,
    showConfirmButton: false
});
</script>
@endif
<script>
document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Hapus data?',
            text: 'Data ini akan dihapus permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result)=>{
            if(result.isConfirmed){
                this.submit();
            }
        });

    });
});

function handleFilter(selectElement) {
    document.getElementById('realDataBody').style.display = 'none';
    document.getElementById('skeletonBody').style.display = 'table-row-group';
    selectElement.form.submit();
}
</script>

@endsection

@push('styles')
<style>
    /* Design Tokens */
    :root {
        --ds-primary: #e30613;
        --ds-primary-dark: #b90510;
        --ds-success: #198754;
        --ds-success-dark: #146c43;
        --ds-gray-200: #e9ecef;
        --ds-gray-600: #6c757d;
        --ds-gray-800: #343a40;
        --ds-radius-md: 10px;
        --ds-radius-lg: 16px;
        --ds-shadow-sm: 0 2px 8px rgba(0,0,0,0.05);
        --ds-shadow-primary: 0 4px 12px rgba(227,6,19,0.25);
    }

    /* Filter Card */
    .filter-card {
        border: none;
        border-radius: var(--ds-radius-lg);
        box-shadow: var(--ds-shadow-sm);
        background: var(--color-bg-card);
        margin-bottom: 24px;
    }
    .filter-card-body { padding: 24px; }

    /* Layout Wrapper */
    .filter-action-wrapper {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 24px;
        align-items: end;
    }

    /* Filter Group */
    .filter-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 16px;
        width: 100%;
    }

    /* Form Control Dashboard */
    .form-label-dashboard {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--ds-gray-600);
        margin-bottom: 6px;
        display: block;
    }
    .form-control-dashboard {
        display: block;
        width: 100%;
        height: 44px;
        padding: 0 16px;
        font-size: 14px;
        font-weight: 500;
        color: var(--ds-gray-800);
        background-color: var(--color-bg-card);
        border: 1px solid var(--color-border);
        border-radius: 8px;
        transition: all 0.2s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 12px 10px;
    }
    [data-theme="dark"] .form-control-dashboard {
        color: var(--color-text-primary);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23f9fafb' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
    }

    .form-control-dashboard:focus {
        border-color: var(--ds-primary);
        outline: 0;
        box-shadow: 0 0 0 3px rgba(227, 6, 19, 0.1);
    }

    /* Action Group */
    .action-group {
        display: flex;
        gap: 12px;
        align-items: center;
        justify-content: flex-end;
        flex-wrap: wrap;
        height: 100%;
        padding-bottom: 1px;
    }

    /* Button Dashboard */
    .btn-dashboard {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 44px;
        padding: 0 20px;
        font-size: 14px;
        font-weight: 600;
        border-radius: var(--ds-radius-md);
        border: 1px solid transparent;
        transition: all 0.2s ease;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-dashboard:active { transform: scale(0.98); }

    .btn-dashboard-primary { background: var(--ds-primary); color: #fff; box-shadow: var(--ds-shadow-primary); }
    .btn-dashboard-primary:hover { background: var(--ds-primary-dark); color: #fff; transform: translateY(-1px); }

    .btn-dashboard-success { background: var(--ds-success); color: #fff; }
    .btn-dashboard-success:hover { background: var(--ds-success-dark); color: #fff; transform: translateY(-1px); }

    .btn-dashboard-outline { background: var(--color-bg-card); border-color: var(--color-border); color: var(--color-text-primary); }
    .btn-dashboard-outline:hover { background: var(--color-hover); border-color: var(--color-border); color: var(--color-text-primary); }

    /* Responsive */
    @media (max-width: 992px) {
        .filter-action-wrapper { grid-template-columns: 1fr; gap: 20px; }
        .action-group { justify-content: flex-start; width: 100%; }
    }
    @media (max-width: 576px) {
        .filter-group { grid-template-columns: 1fr; }
        .action-group { flex-direction: column; width: 100%; }
        .btn-dashboard { width: 100%; }
    }

    /* Status Badges */
    .badge-status {
        padding: 6px 10px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.3px;
        display: inline-block;
        min-width: 80px;
    }
    .badge-status-win { background: #d1e7dd; color: #0f5132; }
    .badge-status-lose { background: #f8d7da; color: #842029; }
    .badge-status-cancel { background: #e2e3e5; color: #41464b; }
    .badge-status-prospect { background: #cfe2ff; color: #084298; }
    .badge-status-kegiatan { background: #e0cffc; color: #3d0a91; }

    /* Skeleton Animation */
    .skeleton-bar {
        height: 16px;
        width: 100%;
        background: #e9ecef;
        border-radius: 4px;
        position: relative;
        overflow: hidden;
    }
    .skeleton-bar::after {
        content: "";
        position: absolute;
        top: 0; right: 0; bottom: 0; left: 0;
        transform: translateX(-100%);
        background-image: linear-gradient(90deg, rgba(255,255,255,0) 0, rgba(255,255,255,0.5) 20%, rgba(255,255,255,0.8) 60%, rgba(255,255,255,0));
        animation: shimmer 1.5s infinite;
    }
    [data-theme="dark"] .skeleton-bar {
        background: #374151;
    }
    [data-theme="dark"] .skeleton-bar::after {
        background-image: linear-gradient(90deg, rgba(255,255,255,0) 0, rgba(255,255,255,0.05) 20%, rgba(255,255,255,0.1) 60%, rgba(255,255,255,0));
    }
    @keyframes shimmer {
        100% { transform: translateX(100%); }
    }
</style>
@endpush
