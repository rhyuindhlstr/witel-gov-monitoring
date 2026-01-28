@extends('layouts.app')

@section('title', 'Detail Pelanggan')
@section('page-title', 'Detail Pelanggan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Data Pelanggan</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-building text-danger me-2"></i>
                    {{ $pelanggan->nama_pelanggan }}
                </h5>
                <div class="btn-group">
                    <a href="{{ route('pelanggan.edit', $pelanggan->id) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Nama PIC</label>
                        <p class="fw-semibold">{{ $pelanggan->nama_pic }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Wilayah</label>
                        <p><span class="badge bg-secondary">{{ $pelanggan->wilayah->nama_wilayah ?? '-' }}</span></p>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="text-muted small">Alamat</label>
                        <p class="fw-semibold">{{ $pelanggan->alamat }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">No. Telepon</label>
                        <p class="fw-semibold">{{ $pelanggan->no_telepon }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Email</label>
                        <p class="fw-semibold">{{ $pelanggan->email ?? '-' }}</p>
                    </div>
                    @if($pelanggan->keterangan)
                    <div class="col-12 mb-3">
                        <label class="text-muted small">Keterangan</label>
                        <p>{{ $pelanggan->keterangan }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#kunjungan">
                            <i class="bi bi-calendar-check me-1"></i>Kunjungan ({{ $pelanggan->kunjungan->count() }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#pembayaran">
                            <i class="bi bi-cash-coin me-1"></i>Pembayaran ({{ $pelanggan->pembayaran->count() }})
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="kunjungan">
                        <a href="{{ route('kunjungan.create', ['pelanggan_id' => $pelanggan->id]) }}" class="btn btn-sm btn-telkom mb-3">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Kunjungan
                        </a>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Tujuan</th>
                                        <th>Petugas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pelanggan->kunjungan()->latest()->take(5)->get() as $kunj)
                                    <tr>
                                        <td>{{ $kunj->tanggal_kunjungan->format('d M Y') }}</td>
                                        <td>{{ Str::limit($kunj->tujuan, 40) }}</td>
                                        <td>{{ $kunj->user->name }}</td>
                                        <td>
                                            <a href="{{ route('kunjungan.show', $kunj->id) }}" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada kunjungan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pembayaran">
                        <a href="{{ route('pembayaran.create', ['pelanggan_id' => $pelanggan->id]) }}" class="btn btn-sm btn-telkom mb-3">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Pembayaran
                        </a>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nominal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pelanggan->pembayaran()->latest()->take(5)->get() as $pay)
                                    <tr>
                                        <td>{{ $pay->tanggal_pembayaran->format('d M Y') }}</td>
                                        <td>{{ $pay->formatted_nominal }}</td>
                                        <td>
                                            <span class="badge bg-{{ $pay->status_badge_color }}">{{ ucfirst($pay->status_pembayaran) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('pembayaran.show', $pay->id) }}" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada pembayaran</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-bar-chart text-danger me-2"></i>Statistik</h6>
                <hr>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small text-muted">Total Kunjungan</span>
                        <strong>{{ $stats['total_kunjungan'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small text-muted">Kunjungan Terakhir</span>
                        <strong>{{ $stats['last_visit'] ? $stats['last_visit']->format('d M Y') : '-' }}</strong>
                    </div>
                </div>
                <hr>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small text-muted">Outstanding</span>
                        <strong class="text-warning">Rp {{ number_format($stats['total_outstanding'], 0, ',', '.') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small text-muted">Total Dibayar</span>
                        <strong class="text-success">Rp {{ number_format($stats['total_paid'], 0, ',', '.') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small text-muted">Payment Status</span>
                        <span class="badge bg-{{ $stats['payment_status'] == 'clean' ? 'success' : ($stats['payment_status'] == 'overdue' ? 'danger' : 'warning') }}">
                            {{ ucfirst($stats['payment_status']) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
