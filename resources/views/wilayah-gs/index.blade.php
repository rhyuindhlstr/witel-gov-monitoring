@extends('layouts.gs')

@section('title', 'Wilayah')  {{-- Tambahkan baris ini --}}

@section('content')
...


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

<div class="container-fluid">

    {{-- HEADER MERAH --}}
    <div class="card mb-4 shadow"
         style="background:linear-gradient(90deg,#b30000,#ff1a1a);color:white;border:none;border-radius:12px;">
        <div class="card-body">
            <h4 class="fw-bold mb-1">Data Wilayah</h4>
            <small>Pengelolaan wilayah Government Service</small>
        </div>
    </div>

    {{-- ACTION --}}
    <div class="mb-3 text-end">
        <a href="{{ route('data-wilayah-gs.create') }}" class="btn btn-danger shadow-sm" style="border-radius: 8px;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Wilayah
        </a>
    </div>

    {{-- TABLE --}}
    <div class="table-card">
        <div class="table-wrapper">
            <table class="table-enterprise">
                <thead>
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th>Nama Wilayah</th>
                        <th>Keterangan</th>
                        <th width="80" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wilayahs as $w)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $w->nama_wilayah }}</td>
                        <td class="text-muted">{{ $w->keterangan ?? '-' }}</td>
                        <td class="text-end">
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-sm btn-light border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius: 12px;">
                                    {{-- DETAIL --}}
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                                           href="{{ route('data-wilayah-gs.show',$w->id) }}">
                                            <i class="bi bi-eye text-primary"></i> Detail
                                        </a>
                                    </li>
                                    {{-- EDIT --}}
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                                           href="{{ route('data-wilayah-gs.edit',$w->id) }}">
                                            <i class="bi bi-pencil text-warning"></i> Edit
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    {{-- HAPUS --}}
                                    <li>
                                        <form method="POST"
                                              action="{{ route('data-wilayah-gs.destroy',$w->id) }}"
                                              class="form-delete-wilayah">
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
                        <td colspan="4" class="text-center text-muted py-5">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-inbox display-6 mb-3 text-secondary opacity-50"></i>
                                <span>Belum ada data wilayah</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>


<script>
document.querySelectorAll('.form-delete-wilayah').forEach(form => {
    form.addEventListener('submit', function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Hapus wilayah?',
            text: 'Data wilayah akan dihapus permanen',
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
