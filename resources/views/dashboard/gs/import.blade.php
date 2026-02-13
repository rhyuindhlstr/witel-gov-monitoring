@extends('layouts.ssgs') {{-- Sesuaikan dengan layout SSGS Anda --}}

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Import Data Pembayaran</h6>
        </div>
        <div class="card-body">
            @if (session('import_errors'))
                <div class="alert alert-danger">
                    <strong>Terdapat beberapa kesalahan pada file Excel Anda:</strong>
                    <ul class="mt-2">
                        @foreach (session('import_errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="alert alert-info">
                <p class="mb-0">
                    Silakan unggah file Excel (.xlsx atau .xls) dengan format kolom berikut (baris pertama adalah header):
                </p>
                <ul class="mb-0">
                    <li><strong>pelanggan_id</strong>: ID dari pelanggan yang sudah ada di sistem.</li>
                    <li><strong>tanggal_pembayaran</strong>: Tanggal pembayaran (format tanggal Excel).</li>
                    <li><strong>nominal</strong>: Jumlah pembayaran (hanya angka, tanpa format Rupiah).</li>
                    <li><strong>status_pembayaran</strong>: Status (opsional, contoh: lunas, tertunda, dibatalkan).</li>
                    <li><strong>keterangan</strong>: Keterangan tambahan (opsional).</li>
                </ul>
            </div>

            <hr>

            <form action="{{ route('ssgs.pembayaran.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file">Pilih File Excel</label>
                    <input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file" name="file" required>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Import Data</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection