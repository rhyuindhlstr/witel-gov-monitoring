@extends('layouts.app')

@section('title', 'Detail Kunjungan')
@section('page-title', 'Detail Kunjungan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('kunjungan.index') }}">Data Kunjungan</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-calendar-check text-danger me-2"></i>
                    Detail Kunjungan
                </h5>
                <div class="btn-group">
                    <a href="{{ route('kunjungan.edit', $kunjungan->id) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Tanggal Kunjungan</label>
                        <p class="fw-semibold">{{ $kunjungan->tanggal_kunjungan->format('d F Y') }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Petugas</label>
                        <p class="fw-semibold">{{ $kunjungan->user->name }}</p>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="text-muted small">Pelanggan</label>
                        <p class="fw-semibold">
                            {{ $kunjungan->pelanggan->nama_pelanggan }}
                            <br>
                            <small class="text-muted">PIC: {{ $kunjungan->pelanggan->nama_pic }}</small>
                            <br>
                            <small class="text-muted">Wilayah: {{ $kunjungan->pelanggan->wilayah->nama_wilayah ?? '-' }}</small>
                        </p>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="text-muted small">Tujuan Kunjungan</label>
                        <p class="fw-semibold">{{ $kunjungan->tujuan }}</p>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="text-muted small">Hasil Kunjungan</label>
                        <div class="border rounded p-3 bg-light">
                            <p class="mb-0">{{ $kunjungan->hasil_kunjungan }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-building text-danger me-2"></i>
                    Informasi Pelanggan
                </h6>
                <hr>
                <p class="small mb-1"><strong>{{ $kunjungan->pelanggan->nama_pelanggan }}</strong></p>
                <p class="small mb-1">{{ $kunjungan->pelanggan->alamat }}</p>
                <p class="small mb-1">{{ $kunjungan->pelanggan->no_telepon }}</p>
                <a href="{{ route('pelanggan.show', $kunjungan->pelanggan->id) }}" class="btn btn-sm btn-outline-danger mt-2">
                    <i class="bi bi-eye me-1"></i>Detail Pelanggan
                </a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-clock-history text-info me-2"></i>
                    Timestamp
                </h6>
                <p class="small text-muted mb-1">Dibuat: {{ $kunjungan->created_at->format('d M Y H:i') }}</p>
                <p class="small text-muted mb-0">Diupdate: {{ $kunjungan->updated_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
