@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="card mb-4 shadow"
         style="background:linear-gradient(90deg,#b30000,#ff1a1a);color:white">
        <div class="card-body">
            <h4 class="fw-bold mb-1">Data Aktivitas Marketing</h4>
            <small>Riwayat aktivitas marketing pada peluang proyek GS</small>
        </div>
    </div>

    {{-- ACTION --}}
    <div class="text-end mb-3">
        <a href="{{ route('aktivitas-marketing.create') }}"
           class="btn btn-primary">
           + Tambah Aktivitas
        </a>
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-danger text-center">
                    <tr>
                        <th width="50">No</th>
                        <th>Tanggal</th>
                        <th>Wilayah</th>
                        <th>Judul Proyek</th>
                        <th>Jenis Aktivitas</th>
                        <th>Hasil</th>
                        <th width="70">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($aktivitas as $i => $a)
                    <tr>
                        <td class="text-center">{{ $i+1 }}</td>
                        <td>{{ $a->tanggal }}</td>
                        <td>{{ optional($a->peluang->wilayah)->nama_wilayah ?? '-' }}</td>
                        <td>{{ $a->peluang->judul_proyek ?? '-' }}</td>

                        <td class="text-center">
                            <span class="badge bg-info text-dark">
                                {{ $a->jenis_aktivitas }}
                            </span>
                        </td>

                        <td class="text-center">
                            <span class="badge 
                                {{ $a->hasil === 'win' ? 'bg-success' : 'bg-secondary' }}">
                                {{ strtoupper($a->hasil) }}
                            </span>
                        </td>

                        {{-- AKSI --}}
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route('aktivitas-marketing.show', $a->id) }}">
                                            <i class="bi bi-eye me-1"></i> Detail
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route('aktivitas-marketing.edit', $a->id) }}">
                                            <i class="bi bi-pencil me-1"></i> Edit
                                        </a>
                                    </li>

                                    <li>
                                        <form action="{{ route('aktivitas-marketing.destroy', $a->id) }}"
                                              method="POST"
                                              class="form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="dropdown-item text-danger">
                                                <i class="bi bi-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada aktivitas marketing
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
