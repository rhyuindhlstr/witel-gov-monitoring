@extends('layouts.app')

@section('title', 'Data Pelanggan')
@section('page-title', 'Data Pelanggan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.ssgs') }}">Home</a></li>
    <li class="breadcrumb-item active">Data Pelanggan</li>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-building text-danger me-2"></i>
                        Daftar Pelanggan
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('pelanggan.export') }}" class="btn btn-outline-danger">
                            <i class="bi bi-download me-1"></i>Export
                        </a>
                        <a href="{{ route('pelanggan.create') }}" class="btn btn-telkom">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Pelanggan
                        </a>
                    </div>
                </div>
                
                <!-- Filter Form -->
                <form method="GET" action="{{ route('pelanggan.index') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Wilayah</label>
                            <select name="wilayah_id" class="form-select">
                                <option value="">Semua Wilayah</option>
                                @foreach($wilayahs as $wilayah)
                                    <option value="{{ $wilayah->id }}" {{ request('wilayah_id') == $wilayah->id ? 'selected' : '' }}>
                                        {{ $wilayah->nama_wilayah }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pencarian</label>
                            <input type="text" name="search" class="form-control" placeholder="Nama pelanggan, PIC, atau telepon..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Filter Overdue</label>
                            <select name="overdue" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="1" {{ request('overdue') == '1' ? 'selected' : '' }}>Hanya Overdue</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-telkom">
                                <i class="bi bi-search me-2"></i>Filter
                            </button>
                            <a href="{{ route('pelanggan.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
                
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NAMA PELANGGAN</th>
                                <th>PIC</th>
                                <th>WILAYAH</th>
                                <th>TELEPON</th>
                                <th>EMAIL</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pelanggans as $index => $pelanggan)
                                <tr>
                                    <td>{{ $pelanggans->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $pelanggan->nama_pelanggan }}</strong>
                                    </td>
                                    <td>{{ $pelanggan->nama_pic }}</td>
                                    <td>
                                        @if($pelanggan->wilayah)
                                            <span class="badge bg-secondary">{{ $pelanggan->wilayah->nama_wilayah }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $pelanggan->no_telepon }}</td>
                                    <td>{{ $pelanggan->email ?? '-' }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('pelanggan.show', $pelanggan->id) }}" class="btn btn-outline-danger" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('pelanggan.edit', $pelanggan->id) }}" class="btn btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Hapus" 
                                                    onclick="if(confirm('Yakin ingin menghapus data pelanggan ini?')) { document.getElementById('delete-{{ $pelanggan->id }}').submit(); }">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-{{ $pelanggan->id }}" action="{{ route('pelanggan.destroy', $pelanggan->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-inbox display-4 text-muted d-block mb-2"></i>
                                        <p class="text-muted">Tidak ada data pelanggan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $pelanggans->firstItem() ?? 0 }} - {{ $pelanggans->lastItem() ?? 0 }} dari {{ $pelanggans->total() }} data
                    </div>
                    <div>
                        {{ $pelanggans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
