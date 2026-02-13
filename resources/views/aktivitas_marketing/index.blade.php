@extends('layouts.gs')

@section('title', 'Aktivitas Marketing')

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
        position: sticky;
        top: 0;
        z-index: 10;
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

    /* Mobile Card Layout */
    @media (max-width: 768px) {
        .table-enterprise thead { display: none; }
        .table-enterprise tbody tr {
            display: block;
            margin-bottom: 16px;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        .table-enterprise tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border: none;
            border-bottom: 1px solid #f8f9fa;
        }
        .table-enterprise tbody td:last-child { border-bottom: none; }
        .table-enterprise tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            font-size: 12px;
            color: #6c757d;
            margin-right: 16px;
        }
        .table-enterprise tbody td .text-end { text-align: right !important; }
    }
</style>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="card mb-4 shadow"
         style="background:linear-gradient(90deg,#b30000,#ff1a1a);color:white;border:none;border-radius:12px;">
        <div class="card-body">
            <h4 class="fw-bold mb-1">Data Aktivitas Marketing</h4>
            <small>Riwayat aktivitas marketing pada peluang proyek GS</small>
        </div>
    </div>

    {{-- ACTION --}}
    <div class="text-end mb-3">
        {{-- Search Form --}}
        <form action="{{ route('aktivitas-marketing.index') }}" method="GET" class="d-inline-block me-2">
            <div class="input-group">
                <input type="text" name="search" class="form-control form-control-sm" 
                       placeholder="Cari Nama AM..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary btn-sm" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>

        <a href="{{ route('aktivitas-marketing.create') }}"
           class="btn btn-danger shadow-sm" style="border-radius: 8px;">
           <i class="bi bi-plus-lg me-1"></i> Tambah Aktivitas
        </a>
    </div>

    {{-- TABLE --}}
    <div class="table-card">
        <div class="table-wrapper">
            <table class="table-enterprise">
                <thead>
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th>Tanggal</th>
                        <th>Wilayah</th>
                        <th>ID AM</th>
                        <th>Nama AM</th>
                        <th>Judul Proyek</th>
                        <th>Jenis Aktivitas</th>
                        <th>Keterangan Kegiatan</th>
                        <th width="70" class="text-end">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($aktivitas as $i => $a)
                    <tr>
                        <td class="text-center" data-label="No">{{ $i+1 }}</td>
                        <td data-label="Tanggal">{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</td>
                        <td data-label="Wilayah">{{ optional($a->peluang->wilayah)->nama_wilayah ?? '-' }}</td>
                        
                        <td data-label="ID AM" class="font-monospace text-muted" style="font-size: 0.9em;">
                            {{ $a->peluang->id_am ?? '-' }}
                        </td>
                        <td data-label="Nama AM" class="fw-medium text-primary">
                            {{ $a->peluang->nama_am ?? '-' }}
                        </td>

                        <td data-label="Judul Proyek" class="fw-bold">{{ $a->peluang->judul_proyek ?? '-' }}</td>

                        <td class="text-center" data-label="Jenis Aktivitas">
                            <span class="badge bg-info text-dark">
                                {{ $a->jenis_aktivitas }}
                            </span>
                        </td>

                        <td data-label="Keterangan" style="max-width: 250px;">
                            <div class="text-truncate" title="{{ $a->keterangan ?? $a->hasil }}">
                                {{ $a->keterangan ?? $a->hasil ?? '-' }}
                            </div>
                        </td>

                        {{-- AKSI --}}
                        <td class="text-end" data-label="Aksi">
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-light btn-sm border-0 bg-transparent"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical text-muted"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius: 12px;">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                                           href="{{ route('aktivitas-marketing.show', $a->id) }}">
                                            <i class="bi bi-eye text-primary"></i> Detail
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                                           href="{{ route('aktivitas-marketing.edit', $a->id) }}">
                                            <i class="bi bi-pencil text-warning"></i> Edit
                                        </a>
                                    </li>

                                    <li><hr class="dropdown-divider my-1"></li>

                                    <li>
                                        <form action="{{ route('aktivitas-marketing.destroy', $a->id) }}"
                                              method="POST"
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
                        <td colspan="7" class="text-center text-muted py-5">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-inbox display-6 mb-3 text-secondary opacity-50"></i>
                                <span>Belum ada aktivitas marketing</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

{{-- SWEETALERT --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Yakin hapus data?',
            text: 'Data aktivitas marketing akan dihapus permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
