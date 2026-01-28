@extends('layouts.app')

@section('title', 'Tambah Kunjungan')
@section('page-title', 'Tambah Kunjungan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('kunjungan.index') }}">Data Kunjungan</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-plus-circle text-danger me-2"></i>
                    Form Tambah Kunjungan
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('kunjungan.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="pelanggan_id" class="form-label">Pelanggan <span class="text-danger">*</span></label>
                        <select class="form-select @error('pelanggan_id') is-invalid @enderror" id="pelanggan_id" name="pelanggan_id" required>
                            <option value="">Pilih Pelanggan</option>
                            @foreach($pelanggans as $p)
                                <option value="{{ $p->id }}" {{ (old('pelanggan_id') ?? $selectedPelanggan?->id) == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_pelanggan }} - {{ $p->nama_pic }}
                                </option>
                            @endforeach
                        </select>
                        @error('pelanggan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_kunjungan') is-invalid @enderror" 
                               id="tanggal_kunjungan" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" required>
                        @error('tanggal_kunjungan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="tujuan" class="form-label">Tujuan Kunjungan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('tujuan') is-invalid @enderror" 
                               id="tujuan" name="tujuan" value="{{ old('tujuan') }}" 
                               placeholder="Contoh: Follow-up pembayaran tagihan bulan Januari 2026" required>
                        @error('tujuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="hasil_kunjungan" class="form-label">Hasil Kunjungan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('hasil_kunjungan') is-invalid @enderror" 
                                  id="hasil_kunjungan" name="hasil_kunjungan" rows="4" required>{{ old('hasil_kunjungan') }}</textarea>
                        <small class="text-muted">Deskripsikan hasil pertemuan, komitmen customer, dan tindak lanjut yang diperlukan</small>
                        @error('hasil_kunjungan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <small>Petugas akan tercatat otomatis sebagai <strong>{{ Auth::user()->name }}</strong></small>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-telkom">
                            <i class="bi bi-save me-2"></i>Simpan
                        </button>
                        <a href="{{ route('kunjungan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-lightbulb text-warning me-2"></i>
                    Tips Pengisian
                </h6>
                <ul class="small mb-0">
                    <li>Pilih pelanggan yang dikunjungi</li>
                    <li>Catat tanggal kunjungan secara akurat</li>
                    <li>Jelaskan tujuan kunjungan dengan jelas</li>
                    <li>Dokumentasikan hasil dengan detail:
                        <ul>
                            <li>Komitmen bayar customer</li>
                            <li>Request perpanjangan tempo</li>
                            <li>Ancaman/proses pemutusan</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
