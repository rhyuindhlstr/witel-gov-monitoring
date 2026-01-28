@extends('layouts.admin')

@section('title', 'Data Wilayah')
@section('page-title', 'Data Wilayah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Wilayah</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Daftar Wilayah</span>
            <a href="{{ route('admin.wilayah.create') }}" class="btn btn-sm btn-telkom">
                <i class="fas fa-plus me-1"></i> Tambah Wilayah
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Wilayah</th>
                            <th>Kode</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wilayahs as $index => $wilayah)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $wilayah->name }}</td>
                                <td>
                                    @if($wilayah->code)
                                        <span class="badge bg-secondary">{{ $wilayah->code }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.wilayah.edit', $wilayah) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.wilayah.destroy', $wilayah) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus wilayah ini?');"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="fas fa-info-circle me-2"></i> Belum ada data wilayah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection