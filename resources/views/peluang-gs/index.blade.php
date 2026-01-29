@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<div class="card mb-4 shadow"
     style="background:linear-gradient(90deg,#b30000,#ff1a1a);color:white">
    <div class="card-body">
        <h4 class="fw-bold mb-1">Data Peluang Proyek GS</h4>
        <small>
            Monitoring dan pengelolaan peluang proyek Government Service
        </small>
    </div>
</div>

{{-- ACTION + FILTER --}}
<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">

            {{-- FILTER STATUS --}}
            <div class="col-md-3">
                <label class="form-label">Status Proyek</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    @foreach(['PROSPECT','KEGIATAN_VALID','WIN','LOSE','CANCEL'] as $s)
                        <option value="{{ $s }}"
                            {{ request('status') == $s ? 'selected' : '' }}>
                            {{ $s }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- FILTER WILAYAH --}}
            <div class="col-md-3">
                <label class="form-label">Wilayah</label>
                <select name="wilayah" class="form-select">
                    <option value="">Semua</option>
                    @foreach($peluang->pluck('wilayah')->unique('id') as $w)
                        @if($w)
                            <option value="{{ $w->id }}"
                                {{ request('wilayah') == $w->id ? 'selected' : '' }}>
                                {{ $w->nama_wilayah }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            {{-- FILTER TAHUN --}}
            <div class="col-md-2">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select">
                    <option value="">Semua</option>
                    @foreach($peluang->pluck('start_pelaksanaan')->filter()->map(fn($d)=>date('Y',strtotime($d)))->unique() as $t)
                        <option value="{{ $t }}"
                            {{ request('tahun') == $t ? 'selected' : '' }}>
                            {{ $t }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- BUTTON --}}
            <div class="col-md-4 text-end">
                <button class="btn btn-outline-secondary me-2">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <a href="{{ route('peluang-gs.create') }}" class="btn btn-primary">
                    + Tambah Peluang
                </a>
                <a href="{{ route('peluang-gs.export') }}" class="btn btn-success ms-1">
                    Export Excel
                </a>
            </div>
        </form>
    </div>
</div>


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
<div class="card shadow-sm">
    <div class="card-body p-0 table-responsive" style="max-height:70vh">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-danger text-center sticky-top">
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

            <tbody>
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
                                'WIN' => 'success',
                                'LOSE','CANCEL' => 'danger',
                                'KEGIATAN_VALID' => 'primary',
                                default => 'warning'
                            };
                        @endphp
                        <span class="badge bg-{{ $badge }}">
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
                    <td class="text-center">

<div class="dropdown">
    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
        <i class="bi bi-three-dots-vertical"></i>
    </button>

    <ul class="dropdown-menu dropdown-menu-end shadow">

        {{-- DETAIL --}}
        <li>
            <a class="dropdown-item d-flex align-items-center gap-2"
               href="{{ route('peluang-gs.show',$item->id) }}">
                <i class="bi bi-eye"></i> Detail
            </a>
        </li>

        {{-- EDIT --}}
        <li>
            <a class="dropdown-item d-flex align-items-center gap-2"
               href="{{ route('peluang-gs.edit',$item->id) }}">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </li>

        <li><hr class="dropdown-divider"></li>

        {{-- HAPUS --}}
        <li>
            <form method="POST"
                  action="{{ route('peluang-gs.destroy',$item->id) }}"
                  class="form-delete">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="dropdown-item text-danger d-flex align-items-center gap-2">
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
</script>

@endsection
