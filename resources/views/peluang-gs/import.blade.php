@extends('layouts.gs')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="card mb-4 shadow"
         style="background:linear-gradient(90deg,#b30000,#ff1a1a);color:white">
        <div class="card-body">
            <h4 class="fw-bold mb-1">Import Data Peluang Proyek GS</h4>
            <small>Upload file Excel untuk menambahkan data peluang proyek secara massal</small>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('peluang-gs.import') }}" method="POST" enctype="multipart/form-data" class="p-3">
                @csrf
                <div class="mb-4">
                    <label for="file" class="form-label fw-bold">Pilih File Excel (.xlsx, .xls)</label>
                    <input type="file" name="file" class="form-control" required accept=".xlsx, .xls, .csv">
                    <div class="form-text text-muted">Pastikan header kolom sesuai dengan database (wilayah_id, judul_proyek, dll).</div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('peluang-gs.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Import Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
