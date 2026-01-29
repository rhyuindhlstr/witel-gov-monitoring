@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="card mb-4 border-0 shadow-sm"
         style="background: linear-gradient(90deg,#b30000,#ff1a1a); color:white;">
        <div class="card-body">
            <h4 class="fw-bold mb-1">Detail Wilayah</h4>
            <small>Informasi lengkap wilayah</small>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>Nama Wilayah:</strong> {{ $wilayah->nama_wilayah }}</p>
            <p><strong>Keterangan:</strong> {{ $wilayah->keterangan ?? '-' }}</p>

            <a href="{{ route('wilayah.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </div>

</div>
@endsection
