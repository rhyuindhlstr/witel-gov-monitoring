@extends('layouts.app')

@section('title', 'Tambah Pembayaran')
@section('page-title', 'Tambah Pembayaran')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('pembayaran.index') }}">Data Pembayaran</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-plus-circle text-danger me-2"></i>
                    Form Tambah Pembayaran
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pembayaran.store') }}" method="POST">
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
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_pembayaran') is-invalid @enderror" 
                                   id="tanggal_pembayaran" name="tanggal_pembayaran" value="{{ old('tanggal_pembayaran', date('Y-m-d')) }}" required>
                            @error('tanggal_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Tanggal jatuh tempo akan diset otomatis ke tanggal 20</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nominal" class="form-label">Nominal <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('nominal') is-invalid @enderror" 
                                   id="nominal" name="nominal" value="{{ old('nominal') }}" step="1000" min="0" required>
                            @error('nominal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status_pembayaran" class="form-label">Status Pembayaran <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_pembayaran') is-invalid @enderror" id="status_pembayaran" name="status_pembayaran" required>
                            <option value="">Pilih Status</option>
                            <option value="lancar" {{ old('status_pembayaran') == 'lancar' ? 'selected' : '' }}>Lancar</option>
                            <option value="tertunda" {{ old('status_pembayaran') == 'tertunda' ? 'selected' : '' }}>Tertunda</option>
                        </select>
                        @error('status_pembayaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                  id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-telkom">
                            <i class="bi bi-save me-2"></i>Simpan
                        </button>
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">
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
                    <i class="bi bi-info-circle text-danger me-2"></i>
                    Informasi
                </h6>
                <ul class="small mb-0">
                    <li><strong>Lancar:</strong> Pembayaran dilakukan sebelum/pada tanggal jatuh tempo</li>
                    <li><strong>Tertunda:</strong> Pembayaran belum dilakukan setelah jatuh tempo</li>
                    <li class="text-muted mt-2">Tanggal jatuh tempo otomatis diset ke tanggal 20 setiap bulan</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
