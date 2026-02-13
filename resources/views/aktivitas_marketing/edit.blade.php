@extends('layouts.gs')
@section('content')
<div class="container-fluid">

<div class="card mb-4 shadow"
style="background:linear-gradient(90deg,#b30000,#ff1a1a);color:white">
<div class="card-body">
<h4>Edit Aktivitas Marketing</h4>
</div>
</div>

<form id="formUpdate"
method="POST"
action="{{ route('aktivitas-marketing.update',$aktivitas_marketing->id) }}">
@csrf
@method('PUT')

<div class="card shadow-sm p-4">

<label>Peluang Proyek</label>
<select name="peluang_proyek_gs_id" class="form-select mb-3">
@foreach($peluang as $p)
<option value="{{ $p->id }}"
@if($p->id==$aktivitas_marketing->peluang_proyek_gs_id) selected @endif>
{{ $p->judul_proyek }}
</option>
@endforeach
</select>

<div class="row">
<div class="col-md-6 mb-3">
<label>ID AM</label>
<input type="text" class="form-control bg-light" value="{{ $aktivitas_marketing->peluang->id_am ?? '-' }}" readonly>
</div>
<div class="col-md-6 mb-3">
<label>Nama AM</label>
<input type="text" class="form-control bg-light" value="{{ $aktivitas_marketing->peluang->nama_am ?? '-' }}" readonly>
</div>
</div>

<label>Tanggal</label>
<input type="date" name="tanggal" class="form-control mb-3"
value="{{ $aktivitas_marketing->tanggal }}">

<label>Jenis Aktivitas</label>
<input type="text" name="jenis_aktivitas" class="form-control mb-3"
value="{{ $aktivitas_marketing->jenis_aktivitas }}">

<label>Keterangan Kegiatan</label>
<input type="text" name="hasil" class="form-control mb-3"
value="{{ $aktivitas_marketing->hasil }}">

<label>Keterangan</label>
<textarea name="keterangan" class="form-control mb-3">{{ $aktivitas_marketing->keterangan }}</textarea>

<div class="text-end">
<a href="{{ route('aktivitas-marketing.index') }}" class="btn btn-secondary">
Batal
</a>
<button type="submit" class="btn btn-primary">
Update
</button>
</div>

</div>
</form>

</div>

{{-- SWEETALERT UPDATE --}}
<script>
document.getElementById('formUpdate').addEventListener('submit',function(e){
e.preventDefault();

Swal.fire({
title:'Update data?',
icon:'question',
showCancelButton:true,
confirmButtonText:'Ya, update'
}).then((r)=>{
if(r.isConfirmed) this.submit();
});
});
</script>

@endsection
