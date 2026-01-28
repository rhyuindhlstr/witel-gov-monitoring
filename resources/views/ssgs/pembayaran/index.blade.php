@extends('layouts.app')

@section('title', 'Data Pembayaran')
@section('page-title', 'Data Pembayaran')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Data Pembayaran</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-cash-coin text-danger me-2"></i>
                        Daftar Pembayaran
                    </h5>
                    <a href="{{ route('pembayaran.create') }}" class="btn btn-telkom">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Pembayaran
                    </a>
                </div>
                
                <!-- Filter Form -->
                <form method="GET" action="{{ route('pembayaran.index') }}" class="mb-4">
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
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="lancar" {{ request('status') == 'lancar' ? 'selected' : '' }}>Lancar</option>
                                <option value="tertunda" {{ request('status') == 'tertunda' ? 'selected' : '' }}>Tertunda</option>
                                <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
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
                        <div class="col-12">
                            <button type="submit" class="btn btn-telkom">
                                <i class="bi bi-search me-2"></i>Filter
                            </button>
                            <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary">
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
                                <th>NOMINAL</th>
                                <th>JATUH TEMPO</th>
                                <th>STATUS</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembayarans as $index => $pembayaran)
                                <tr>
                                    <td>{{ $pembayarans->firstItem() + $index }}</td>
                                    <td>{{ $pembayaran->tanggal_pembayaran->format('d M Y') }}</td>
                                    <td>
                                        <strong>{{ $pembayaran->pelanggan->nama_pelanggan }}</strong>
                                    </td>
                                    <td>{{ $pembayaran->formatted_nominal }}</td>
                                    <td>
                                        {{ $pembayaran->tanggal_jatuh_tempo ? $pembayaran->tanggal_jatuh_tempo->format('d M Y') : '-' }}
                                        @if($pembayaran->isOverdue())
                                            <br><small class="text-danger"><i class="bi bi-exclamation-triangle"></i> {{ $pembayaran->days_overdue }} hari</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $pembayaran->status_badge_color }}">
                                            {{ ucfirst($pembayaran->status_pembayaran) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('pembayaran.show', $pembayaran->id) }}" class="btn btn-outline-danger" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('pembayaran.edit', $pembayaran->id) }}" class="btn btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Hapus" 
                                                    onclick="if(confirm('Yakin ingin menghapus data pembayaran ini?')) { document.getElementById('delete-{{ $pembayaran->id }}').submit(); }">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-{{ $pembayaran->id }}" action="{{ route('pembayaran.destroy', $pembayaran->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-inbox display-4 text-muted d-block mb-2"></i>
                                        <p class="text-muted">Tidak ada data pembayaran</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $pembayarans->firstItem() ?? 0 }} - {{ $pembayarans->lastItem() ?? 0 }} dari {{ $pembayarans->total() }} data
                    </div>
                    <div>
                        {{ $pembayarans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
