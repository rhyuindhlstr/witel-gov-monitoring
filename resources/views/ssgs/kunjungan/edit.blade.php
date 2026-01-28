@extends('layouts.app')

@section('title', 'Edit Kunjungan')
@section('page-title', 'Edit Kunjungan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('kunjungan.index') }}">Data Kunjungan</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-pencil text-warning me-2"></i>
                    Form Edit Kunjungan
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('kunjungan.update', $kunjungan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="pelanggan_id" class="form-label">Pelanggan <span class="text-danger">*</span></label>
                        <select class="form-select @error('pelanggan_id') is-invalid @enderror" id="pelanggan_id" name="pelanggan_id" required>
                            <option value="">Pilih Pelanggan</option>
                            @foreach($pelanggans as $p)
                                <option value="{{ $p->id }}" {{ old('pelanggan_id', $kunjungan->pelanggan_id) == $p->id ? 'selected' : '' }}>
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
                               id="tanggal_kunjungan" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', $kunjungan->tanggal_kunjungan->format('Y-m-d')) }}" required>
                        @error('tanggal_kunjungan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="tujuan" class="form-label">Tujuan Kunjungan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('tujuan') is-invalid @enderror" 
                               id="tujuan" name="tujuan" value="{{ old('tujuan', $kunjungan->tujuan) }}" required>
                        @error('tujuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="hasil_kunjungan" class="form-label">Hasil Kunjungan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('hasil_kunjungan') is-invalid @enderror" 
                                  id="hasil_kunjungan" name="hasil_kunjungan" rows="4" required>{{ old('hasil_kunjungan', $kunjungan->hasil_kunjungan) }}</textarea>
                        @error('hasil_kunjungan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-telkom">
                            <i class="bi bi-save me-2"></i>Update
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
                    <i class="bi bi-person text-info me-2"></i>
                    Petugas
                </h6>
                <p class="mb-0"><strong>{{ $kunjungan->user->name }}</strong></p>
                <hr>
                <p class="small text-muted mb-1">Dibuat: {{ $kunjungan->created_at->format('d M Y H:i') }}</p>
                <p class="small text-muted mb-0">Diupdate: {{ $kunjungan->updated_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
