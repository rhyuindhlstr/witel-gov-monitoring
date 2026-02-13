@extends('layouts.gs')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="card mb-4 shadow"
         style="background:linear-gradient(90deg,#b30000,#ff1a1a);color:white">
        <div class="card-body">
            <h4 class="fw-bold mb-1">Tambah Peluang Proyek GS</h4>
            <small>Input data peluang proyek Government Service</small>
        </div>
    </div>

    {{-- FORM --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('peluang-gs.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- WILAYAH --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Wilayah</label>
                        <select name="wilayah_id" class="form-select" required>
                            <option value="">-- Pilih Wilayah --</option>
                            @foreach($wilayahs as $w)
                                <option value="{{ $w->id }}"
                                    {{ old('wilayah_id') == $w->id ? 'selected' : '' }}>
                                    {{ $w->nama_wilayah }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ID AM --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">ID AM</label>
                        <input type="text" name="id_am" class="form-control"
                               value="{{ old('id_am') }}"
                               placeholder="G26-345678" required>
                    </div>

                    {{-- NAMA AM --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nama AM</label>
                        <input type="text" name="nama_am" class="form-control"
                               value="{{ old('nama_am') }}" required>
                    </div>

                    {{-- NAMA GC --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama GC</label>
                        <input type="text" name="nama_gc" class="form-control"
                               value="{{ old('nama_gc') }}" required>
                    </div>

                    {{-- SATKER --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Satker</label>
                        <input type="text" name="satker" class="form-control"
                               value="{{ old('satker') }}" required>
                    </div>

                    {{-- JUDUL PROYEK --}}
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Judul Proyek</label>
                        <input type="text" name="judul_proyek" class="form-control"
                               value="{{ old('judul_proyek') }}" required>
                    </div>

                    {{-- LAYANAN --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Layanan</label>
                        <input type="text" name="jenis_layanan" class="form-control"
                               value="{{ old('jenis_layanan') }}" required>
                    </div>

                    {{-- JENIS PROYEK --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Proyek</label>
                        <select name="jenis_proyek" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="SUSTAIN" {{ old('jenis_proyek')=='SUSTAIN'?'selected':'' }}>SUSTAIN</option>
                            <option value="SCALING" {{ old('jenis_proyek')=='SCALING'?'selected':'' }}>SCALING</option>
                        </select>
                    </div>

                    {{-- NILAI --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nilai Estimasi</label>
                        <input type="number" name="nilai_estimasi" class="form-control"
                               value="{{ old('nilai_estimasi') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nilai Realisasi</label>
                        <input type="number" name="nilai_realisasi" class="form-control"
                               value="{{ old('nilai_realisasi') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nilai Scaling</label>
                        <input type="number" name="nilai_scaling" class="form-control"
                               value="{{ old('nilai_scaling') }}">
                    </div>

                    {{-- STATUS MYTENS --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status MYTens</label>
                        <select name="status_mytens" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            @foreach(['F0','F1','F2','F3','F4','F5'] as $s)
                                <option value="{{ $s }}"
                                    {{ old('status_mytens')==$s?'selected':'' }}>
                                    {{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- STATUS PROYEK --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status Proyek</label>
                        <select name="status_proyek" class="form-select" required>
                            @foreach(['PROSPECT','KEGIATAN_VALID','WIN','LOSE','CANCEL'] as $st)
                                <option value="{{ $st }}"
                                    {{ old('status_proyek',$st)=='PROSPECT' && $st=='PROSPECT' ? 'selected' : '' }}>
                                    {{ $st }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- MEKANISME --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Mekanisme Pengadaan</label>
                        <input type="text" name="mekanisme_pengadaan" class="form-control"
                               value="{{ old('mekanisme_pengadaan') }}">
                    </div>

                    {{-- WAKTU --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Start Pelaksanaan</label>
                        <input type="date" name="start_pelaksanaan" class="form-control"
                               value="{{ old('start_pelaksanaan') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">End Pelaksanaan</label>
                        <input type="date" name="end_pelaksanaan" class="form-control"
                               value="{{ old('end_pelaksanaan') }}">
                    </div>

                    {{-- KETERANGAN --}}
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                    </div>

                </div>

                {{-- ACTION --}}
                <div class="mt-4 text-end">
                    <a href="{{ route('peluang-gs.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
