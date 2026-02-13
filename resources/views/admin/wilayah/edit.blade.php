@extends('layouts.admin')

@section('title', 'Edit Wilayah')
@section('page-title', 'Edit Wilayah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('wilayah.index') }}">Data Wilayah</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-center">Form Edit Wilayah</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('wilayah.update', $wilayah) }}" method="POST">
                        @csrf
                        @method('PUT')


                        <div class="mb-3">
                            <label for="nama_wilayah" class="form-label">Nama Wilayah</label>
            <input type="text" class="form-control" id="nama_wilayah" name="nama_wilayah" value="{{ $wilayah->nama_wilayah }}" required>
                            @error('nama_wilayah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">Kode Wilayah (Opsional)</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                                name="code" value="{{ old('code', $wilayah->code) }}">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('wilayah.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-telkom">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection