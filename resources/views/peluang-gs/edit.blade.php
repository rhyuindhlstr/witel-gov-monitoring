@extends('layouts.gs')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="card mb-4 shadow"
         style="background:linear-gradient(90deg,#b30000,#ff1a1a);color:white">
        <div class="card-body">
            <h4 class="fw-bold mb-1">Edit Peluang Proyek GS</h4>
            <small>Perbarui data peluang proyek Government Service</small>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

<form id="form-edit"
      action="{{ route('peluang-gs.update', $peluang_g->id) }}"
      method="POST">
@csrf
@method('PUT')

<div class="row g-3">

{{-- WILAYAH --}}
<div class="col-md-4">
<label class="form-label">Wilayah</label>
<select name="wilayah_id" class="form-select" required>
@foreach($wilayahs as $w)
<option value="{{ $w->id }}" {{ $peluang_g->wilayah_id==$w->id?'selected':'' }}>
{{ $w->nama_wilayah }}
</option>
@endforeach
</select>
</div>

<div class="col-md-4">
<label>ID AM</label>
<input name="id_am" class="form-control" value="{{ $peluang_g->id_am }}">
</div>

<div class="col-md-4">
<label>Nama AM</label>
<input name="nama_am" class="form-control" value="{{ $peluang_g->nama_am }}">
</div>

<div class="col-md-6">
<label>Nama GC</label>
<input name="nama_gc" class="form-control" value="{{ $peluang_g->nama_gc }}">
</div>

<div class="col-md-6">
<label>Satker</label>
<input name="satker" class="form-control" value="{{ $peluang_g->satker }}">
</div>

<div class="col-md-12">
<label>Judul Proyek</label>
<input name="judul_proyek" class="form-control" required value="{{ $peluang_g->judul_proyek }}">
</div>

<div class="col-md-6">
<label>Jenis Layanan</label>
<input name="jenis_layanan" class="form-control" value="{{ $peluang_g->jenis_layanan }}">
</div>

<div class="col-md-6">
<label>Jenis Proyek</label>
<input name="jenis_proyek" class="form-control" value="{{ $peluang_g->jenis_proyek }}">
</div>

<div class="col-md-4">
<label>Nilai Estimasi</label>
<input name="nilai_estimasi" class="form-control" value="{{ $peluang_g->nilai_estimasi }}">
</div>

<div class="col-md-4">
<label>Nilai Realisasi</label>
<input name="nilai_realisasi" class="form-control" value="{{ $peluang_g->nilai_realisasi }}">
</div>

<div class="col-md-4">
<label>Nilai Scaling</label>
<input name="nilai_scaling" class="form-control" value="{{ $peluang_g->nilai_scaling }}">
</div>

<div class="col-md-6">
<label>Status MYTens</label>
<select name="status_mytens" class="form-select">
@foreach(['F0','F1','F2','F3','F4','F5'] as $s)
<option value="{{ $s }}" {{ $peluang_g->status_mytens==$s?'selected':'' }}>{{ $s }}</option>
@endforeach
</select>
</div>

<div class="col-md-6">
<label>Status Proyek</label>
<select name="status_proyek" class="form-select">
@foreach(['PROSPECT','KEGIATAN_VALID','WIN','LOSE','CANCEL'] as $s)
<option value="{{ $s }}" {{ $peluang_g->status_proyek==$s?'selected':'' }}>{{ $s }}</option>
@endforeach
</select>
</div>

<div class="col-md-6">
<label>Mekanisme Pengadaan</label>
<input name="mekanisme_pengadaan" class="form-control" value="{{ $peluang_g->mekanisme_pengadaan }}">
</div>

<div class="col-md-3">
<label>Start</label>
<input type="date" name="start_pelaksanaan" class="form-control" value="{{ $peluang_g->start_pelaksanaan }}">
</div>

<div class="col-md-3">
<label>End</label>
<input type="date" name="end_pelaksanaan" class="form-control" value="{{ $peluang_g->end_pelaksanaan }}">
</div>

<div class="col-md-12">
<label>Keterangan</label>
<textarea name="keterangan" class="form-control">{{ $peluang_g->keterangan }}</textarea>
</div>

</div>

<div class="mt-4 text-end">
<a href="{{ route('peluang-gs.index') }}" class="btn btn-secondary">Batal</a>
<button type="submit" class="btn btn-primary">Update</button>
</div>

</form>
</div>
</div>
</div>

{{-- SWEETALERT --}}
<script>
document.addEventListener('DOMContentLoaded', function(){

const form = document.getElementById('form-edit');

form.addEventListener('submit', function(e){
e.preventDefault();

Swal.fire({
title: 'Simpan perubahan?',
text: 'Data peluang proyek akan diperbarui',
icon: 'warning',
showCancelButton: true,
confirmButtonText: 'Ya, Update',
cancelButtonText: 'Batal'
}).then((result)=>{
if(result.isConfirmed){
form.submit();
}
});

});

});
</script>
@endsection
