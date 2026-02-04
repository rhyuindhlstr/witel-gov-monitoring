@extends('layouts.app')

@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.ssgs') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('pembayaran.index') }}">Data Pembayaran</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        @if($pembayaran->isOverdue())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Pembayaran Overdue!</strong> Terlambat <strong>{{ $pembayaran->days_overdue }} hari</strong> dari tanggal jatuh tempo.
        </div>
        @endif
        
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-cash-coin text-danger me-2"></i>
                    Detail Pembayaran
                </h5>
                <div class="btn-group">
                    <a href="{{ route('pembayaran.edit', $pembayaran->id) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Tanggal Pembayaran</label>
                        <p class="fw-semibold">{{ $pembayaran->tanggal_pembayaran->format('d F Y') }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Tanggal Jatuh Tempo</label>
                        <p class="fw-semibold">
                            {{ $pembayaran->tanggal_jatuh_tempo ? $pembayaran->tanggal_jatuh_tempo->format('d F Y') : '-' }}
                            @if($pembayaran->isOverdue())
                                <br><span class="badge bg-danger">Overdue {{ $pembayaran->days_overdue }} hari</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="text-muted small">Pelanggan</label>
                        <p class="fw-semibold">
                            {{ $pembayaran->pelanggan->nama_pelanggan }}
                            <br>
                            <small class="text-muted">PIC: {{ $pembayaran->pelanggan->nama_pic }}</small>
                            <br>
                            <small class="text-muted">Wilayah: {{ $pembayaran->pelanggan->wilayah->nama_wilayah ?? '-' }}</small>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Nominal</label>
                        <p class="fw-semibold fs-4 text-success">{{ $pembayaran->formatted_nominal }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Status</label>
                        <p>
                            <span class="badge bg-{{ $pembayaran->status_badge_color }} fs-6">
                                {{ ucfirst($pembayaran->status_pembayaran) }}
                            </span>
                        </p>
                    </div>
                    @if($pembayaran->keterangan)
                    <div class="col-12 mb-3">
                        <label class="text-muted small">Keterangan</label>
                        <div class="border rounded p-3 bg-light">
                            <p class="mb-0">{{ $pembayaran->keterangan }}</p>
                        </div>
                    </div>
                    @endif
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
                <p class="small mb-1"><strong>{{ $pembayaran->pelanggan->nama_pelanggan }}</strong></p>
                <p class="small mb-1">{{ $pembayaran->pelanggan->alamat }}</p>
                <p class="small mb-1">{{ $pembayaran->pelanggan->no_telepon }}</p>
                <a href="{{ route('pelanggan.show', $pembayaran->pelanggan->id) }}" class="btn btn-sm btn-outline-danger mt-2">
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
                <p class="small text-muted mb-1">Dibuat: {{ $pembayaran->created_at->format('d M Y H:i') }}</p>
                <p class="small text-muted mb-0">Diupdate: {{ $pembayaran->updated_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
