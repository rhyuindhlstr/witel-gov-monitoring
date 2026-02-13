@extends('layouts.gs')
@section('content')
<div class="container-fluid">

<div class="card mb-4 shadow"
style="background:linear-gradient(90deg,#b30000,#ff1a1a);color:white">
<div class="card-body">
<h4 class="fw-bold">Detail Aktivitas Marketing</h4>
</div>
</div>

<div class="card shadow-sm">
<table class="table table-bordered mb-0">

<tr>
<th width="25%">Tanggal</th>
<td>{{ $aktivitas_marketing->tanggal }}</td>
</tr>

<tr>
<th>Wilayah</th>
<td>{{ optional($aktivitas_marketing->peluang->wilayah)->nama_wilayah ?? '-' }}</td>
</tr>

<tr>
<th>Judul Proyek</th>
<td>{{ $aktivitas_marketing->peluang->judul_proyek ?? '-' }}</td>
</tr>

<tr>
<th>ID AM</th>
<td>{{ $aktivitas_marketing->peluang->id_am ?? '-' }}</td>
</tr>

<tr>
<th>Nama AM</th>
<td>{{ $aktivitas_marketing->peluang->nama_am ?? '-' }}</td>
</tr>

<tr>
<th>Jenis Aktivitas</th>
<td>{{ $aktivitas_marketing->jenis_aktivitas }}</td>
</tr>

<tr>
<th>Keterangan Kegiatan</th>
<td>{{ $aktivitas_marketing->hasil }}</td>
</tr>

<tr>
<th>Keterangan</th>
<td>{{ $aktivitas_marketing->keterangan ?? '-' }}</td>
</tr>

</table>

<div class="p-3 text-end bg-light">
<a href="{{ route('aktivitas-marketing.index') }}" class="btn btn-secondary">
Kembali
</a>

<a href="{{ route('aktivitas-marketing.edit',$aktivitas_marketing->id) }}"
class="btn btn-warning">
Edit
</a>
</div>

</div>
</div>
@endsection
