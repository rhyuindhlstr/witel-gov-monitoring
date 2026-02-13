@extends('layouts.gs')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="card mb-4 shadow"
         style="background:linear-gradient(90deg,#b30000,#ff1a1a);color:white">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">Detail Peluang Proyek GS</h4>
                <small>Informasi lengkap peluang proyek Government Service</small>
            </div>
            {{-- EXPORT PDF --}}
            <a href="{{ route('peluang-gs.pdf', $peluang_g->id) }}"
               class="btn btn-dark">
                🖨 Export PDF
            </a>
        </div>
    </div>

    {{-- DETAIL TABLE --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body p-0">

            <table class="table table-bordered table-striped mb-0 align-middle">
                <tbody>

                    <tr>
                        <th width="25%">Wilayah</th>
                        <td>{{ optional($peluang_g->wilayah)->nama_wilayah ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>ID AM</th>
                        <td>{{ $peluang_g->id_am ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Nama AM</th>
                        <td>{{ $peluang_g->nama_am ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Nama GC</th>
                        <td>{{ $peluang_g->nama_gc ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Satker</th>
                        <td>{{ $peluang_g->satker ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Judul Proyek</th>
                        <td class="fw-semibold">{{ $peluang_g->judul_proyek }}</td>
                    </tr>

                    <tr>
                        <th>Jenis Proyek</th>
                        <td>{{ $peluang_g->jenis_proyek ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Status Proyek</th>
                        <td>
                            <span class="badge
                                @if($peluang_g->status_proyek == 'WIN') bg-success
                                @elseif($peluang_g->status_proyek == 'PROSPECT') bg-primary
                                @elseif($peluang_g->status_proyek == 'KEGIATAN_VALID') bg-info
                                @elseif($peluang_g->status_proyek == 'LOSE') bg-danger
                                @else bg-secondary
                                @endif">
                                {{ $peluang_g->status_proyek }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Status MYTens</th>
                        <td>
                            <span class="badge bg-dark">
                                {{ $peluang_g->status_mytens ?? '-' }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Nilai Estimasi</th>
                        <td>Rp {{ number_format($peluang_g->nilai_estimasi ?? 0, 0, ',', '.') }}</td>
                    </tr>

                    <tr>
                        <th>Nilai Realisasi</th>
                        <td>Rp {{ number_format($peluang_g->nilai_realisasi ?? 0, 0, ',', '.') }}</td>
                    </tr>

                    <tr>
                        <th>Nilai Scaling</th>
                        <td>Rp {{ number_format($peluang_g->nilai_scaling ?? 0, 0, ',', '.') }}</td>
                    </tr>

                    <tr>
                        <th>Mekanisme Pengadaan</th>
                        <td>{{ $peluang_g->mekanisme_pengadaan ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Start Pelaksanaan</th>
                        <td>{{ $peluang_g->start_pelaksanaan ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>End Pelaksanaan</th>
                        <td>{{ $peluang_g->end_pelaksanaan ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $peluang_g->keterangan ?? '-' }}</td>
                    </tr>

                </tbody>
            </table>

        </div>

        {{-- ACTION --}}
        <div class="card-footer text-end bg-light">
            <a href="{{ route('peluang-gs.index') }}" class="btn btn-secondary">
                Kembali
            </a>
            <a href="{{ route('peluang-gs.edit', $peluang_g->id) }}" class="btn btn-warning">
                Edit
            </a>
        </div>
    </div>

    {{-- AUDIT TRAIL --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <strong>🧾 Riwayat Perubahan (Audit Trail)</strong>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Aksi</th>
                        <th>User</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <span class="badge
                                @if($log->aksi == 'CREATE') bg-success
                                @elseif($log->aksi == 'UPDATE') bg-warning text-dark
                                @else bg-danger
                                @endif">
                                {{ $log->aksi }}
                            </span>
                        </td>
                        <td>{{ $log->user->name ?? '-' }}</td>
                        <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">
                            Belum ada riwayat perubahan
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
