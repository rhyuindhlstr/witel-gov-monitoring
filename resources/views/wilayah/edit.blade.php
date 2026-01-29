@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="card mb-4 border-0 shadow-sm"
         style="background: linear-gradient(90deg,#b30000,#ff1a1a); color:white;">
        <div class="card-body">
            <h4 class="fw-bold mb-1">Edit Wilayah</h4>
            <small>Perbarui data wilayah</small>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('wilayah.update',$wilayah->id) }}">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Wilayah</label>
                    <input type="text" name="nama_wilayah"
                           value="{{ $wilayah->nama_wilayah }}"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan"
                              class="form-control"
                              rows="3">{{ $wilayah->keterangan }}</textarea>
                </div>

                <div class="text-end">
                    <a href="{{ route('wilayah.index') }}"
                       class="btn btn-secondary">Batal</a>
                    <button class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
