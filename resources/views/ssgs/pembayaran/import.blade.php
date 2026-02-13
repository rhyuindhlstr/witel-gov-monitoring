@extends('layouts.app')

@section('title', 'Import Pembayaran')
@section('page-title', 'Import Pembayaran')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.ssgs') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('pembayaran.index') }}">Data Pembayaran</a></li>
    <li class="breadcrumb-item active">Import</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-file-earmark-excel text-success me-2"></i>
                    Import Data Pembayaran dari Excel
                </h5>
            </div>
            <div class="card-body">
                @if (session('import_errors'))
                    <div class="alert alert-danger">
                        <strong>Terdapat beberapa kesalahan pada file Excel Anda:</strong>
                        <ul class="mt-2 mb-0">
                            @foreach (session('import_errors') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('ssgs.pembayaran.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Pilih File Excel (.xlsx, .xls) <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-upload me-2"></i>Import Data
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
                <h6 class="card-title"><i class="bi bi-info-circle text-danger me-2"></i>Petunjuk Format Excel</h6>
                <p class="small">Pastikan file Excel Anda memiliki header pada baris pertama dengan nama kolom berikut:</p>
                <ul class="small list-unstyled">
                    <li><i class="bi bi-check-circle-fill text-success me-2"></i><strong>pelanggan_id</strong> <span class="text-muted">(Wajib, ID Pelanggan)</span></li>
                    <li><i class="bi bi-check-circle-fill text-success me-2"></i><strong>tanggal_pembayaran</strong> <span class="text-muted">(Wajib, Format Tanggal)</span></li>
                    <li><i class="bi bi-check-circle-fill text-success me-2"></i><strong>nominal</strong> <span class="text-muted">(Wajib, Angka saja)</span></li>
                    <li><i class="bi bi-check-circle-fill text-success me-2"></i><strong>status_pembayaran</strong> <span class="text-muted">(Opsional: lancar/tertunda)</span></li>
                    <li><i class="bi bi-check-circle-fill text-success me-2"></i><strong>keterangan</strong> <span class="text-muted">(Opsional)</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection