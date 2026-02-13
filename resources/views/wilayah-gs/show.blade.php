@extends('layouts.gs')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="card mb-4 shadow"
         style="background:linear-gradient(90deg,#b30000,#ff1a1a);color:white">
        <div class="card-body">
            <h4 class="fw-bold mb-1">Detail Wilayah</h4>
            <small>Informasi lengkap wilayah Government Service</small>
        </div>
    </div>

    {{-- DETAIL TABLE --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0 align-middle">
                <tbody>
                    <tr>
                        <th width="25%" class="bg-light ps-4">Nama Wilayah</th>
                        <td class="fw-bold">{{ $wilayah->nama_wilayah }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light ps-4">Keterangan</th>
                        <td>{{ $wilayah->keterangan ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- ACTION --}}
        <div class="card-footer text-end bg-light">
            <a href="{{ route('data-wilayah-gs.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <a href="{{ route('data-wilayah-gs.edit', $wilayah->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
        </div>
    </div>

</div>
@endsection
