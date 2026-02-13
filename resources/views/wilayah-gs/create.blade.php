@extends('layouts.gs')

@section('content')
<div class="container-fluid">

    <div class="card mb-4 border-0 shadow-sm"
         style="background: linear-gradient(90deg,#b30000,#ff1a1a); color:white;">
        <div class="card-body">
            <h4 class="fw-bold mb-1">Tambah Wilayah</h4>
            <small>Input data wilayah Government Service</small>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('data-wilayah-gs.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Wilayah</label>
                    <input type="text" name="nama_wilayah"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan"
                              class="form-control" rows="3"></textarea>
                </div>

                <div class="text-end">
                    <a href="{{ route('data-wilayah-gs.index') }}"
                       class="btn btn-secondary">Batal</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
