@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="card mb-4 shadow-sm bg-danger text-white">
        <div class="card-body">
            <h4 class="fw-bold mb-1">Tambah Aktivitas Marketing</h4>
            <small>Input aktivitas marketing proyek GS</small>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST"
                  action="{{ route('aktivitas-marketing.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Peluang Proyek</label>
                    <select name="peluang_proyek_gs_id"
                            class="form-select" required>
                        <option value="">-- Pilih Proyek --</option>
                        @foreach($peluang as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->judul_proyek }} ({{ $p->wilayah->nama_wilayah }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal"
                               class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Jenis Aktivitas</label>
                        <input type="text" name="jenis_aktivitas"
                               class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Hasil</label>
                        <input type="text" name="hasil"
                               class="form-control">
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan"
                              class="form-control" rows="3"></textarea>
                </div>

                <div class="mt-4 text-end">
                    <a href="{{ route('aktivitas-marketing.index') }}"
                       class="btn btn-secondary">Batal</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
