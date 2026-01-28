@extends('layouts.app')

@section('title', 'Data Kunjungan')
@section('page-title', 'Data Kunjungan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Data Kunjungan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-check text-danger me-2"></i>
                        Daftar Kunjungan
                    </h5>
                    <a href="{{ route('kunjungan.create') }}" class="btn btn-telkom">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Kunjungan
                    </a>
                </div>
                
                <!-- Filter Form -->
                <form method="GET" action="{{ route('kunjungan.index') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Pelanggan</label>
                            <select name="pelanggan_id" class="form-select">
                                <option value="">Semua Pelanggan</option>
                                @foreach($pelanggans as $p)
                                    <option value="{{ $p->id }}" {{ request('pelanggan_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_pelanggan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Petugas</label>
                            <select name="user_id" class="form-select">
                                <option value="">Semua Petugas</option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                                        {{ $u->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-telkom">
                                <i class="bi bi-search me-2"></i>Filter
                            </button>
                            <a href="{{ route('kunjungan.index') }}" class="btn btn-outline-secondary">
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
                                <th>TANGGAL</th>
                                <th>PELANGGAN</th>
                                <th>TUJUAN</th>
                                <th>PETUGAS</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kunjungans as $index => $kunjungan)
                                <tr>
                                    <td>{{ $kunjungans->firstItem() + $index }}</td>
                                    <td>{{ $kunjungan->tanggal_kunjungan->format('d M Y') }}</td>
                                    <td>
                                        <strong>{{ $kunjungan->pelanggan->nama_pelanggan }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $kunjungan->pelanggan->nama_pic }}</small>
                                    </td>
                                    <td>{{ Str::limit($kunjungan->tujuan, 50) }}</td>
                                    <td>{{ $kunjungan->user->name }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('kunjungan.show', $kunjungan->id) }}" class="btn btn-outline-danger" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('kunjungan.edit', $kunjungan->id) }}" class="btn btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Hapus" 
                                                    onclick="if(confirm('Yakin ingin menghapus data kunjungan ini?')) { document.getElementById('delete-{{ $kunjungan->id }}').submit(); }">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-{{ $kunjungan->id }}" action="{{ route('kunjungan.destroy', $kunjungan->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="bi bi-inbox display-4 text-muted d-block mb-2"></i>
                                        <p class="text-muted">Tidak ada data kunjungan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $kunjungans->firstItem() ?? 0 }} - {{ $kunjungans->lastItem() ?? 0 }} dari {{ $kunjungans->total() }} data
                    </div>
                    <div>
                        {{ $kunjungans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
