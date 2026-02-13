@extends('layouts.gs')

@section('content')
<div class="container-fluid">

    {{-- HEADER MERAH --}}
    <div class="card mb-4 border-0 shadow-sm"
         style="background: linear-gradient(90deg,#b30000,#ff1a1a); color:white;">
        <div class="card-body">
            <h4 class="fw-bold mb-1">Data Wilayah</h4>
            <small>Pengelolaan wilayah Government Service</small>
        </div>
    </div>

    {{-- ACTION --}}
    <div class="mb-3 text-end">
        <a href="{{ route('wilayah.create') }}" class="btn btn-primary">
            + Tambah Wilayah
        </a>
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-danger text-center">
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Wilayah</th>
                        <th>Keterangan</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wilayahs as $w)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $w->nama_wilayah }}</td>
                        <td>{{ $w->keterangan ?? '-' }}</td>
                        <td class="text-center">

<div class="dropdown">
    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
        <i class="bi bi-three-dots-vertical"></i>
    </button>

    <ul class="dropdown-menu dropdown-menu-end shadow">

        {{-- DETAIL --}}
        <li>
            <a class="dropdown-item d-flex align-items-center gap-2"
               href="{{ route('wilayah.show',$w->id) }}">
                <i class="bi bi-eye"></i> Detail
            </a>
        </li>

        {{-- EDIT --}}
        <li>
            <a class="dropdown-item d-flex align-items-center gap-2"
               href="{{ route('wilayah.edit',$w->id) }}">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </li>

        <li><hr class="dropdown-divider"></li>

        {{-- HAPUS --}}
        <li>
            <form method="POST"
                  action="{{ route('wilayah.destroy',$w->id) }}"
                  class="form-delete-wilayah">
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
                        <td colspan="4" class="text-center text-muted py-4">
                            Data kosong
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
