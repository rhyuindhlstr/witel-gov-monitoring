@extends('layouts.app')

@section('title', 'Data Interaksi')
@section('page-title', 'Data Interaksi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.ssgs') }}">Home</a></li>
    <li class="breadcrumb-item active">Data Interaksi</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-check text-danger me-2"></i>
                        Daftar Interaksi
                    </h5>
                    <a href="{{ route('kunjungan.create') }}" class="btn btn-telkom">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Interaksi
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
                            <label class="form-label">Metode</label>
                            <select name="metode" class="form-select">
                                <option value="">Semua Metode</option>
                                <option value="visit" {{ request('metode') == 'visit' ? 'selected' : '' }}>Visit</option>
                                <option value="call" {{ request('metode') == 'call' ? 'selected' : '' }}>Call</option>
                                <option value="whatsapp" {{ request('metode') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                            </select>
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
                                <th>METODE</th>
                                <th>PELANGGAN</th>
                                <th>TUJUAN</th>
                                <th>PETUGAS</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($delayedPayments as $payment)
                                    <tr>
                                        <td class="text-center">
                                            <i class="bi bi-exclamation-circle text-danger" title="Pembayaran Tertunda"></i>
                                        </td>
                                        <td>
                                            <span class="text-danger fw-bold">{{ $payment->tanggal_jatuh_tempo ? $payment->tanggal_jatuh_tempo->format('d M Y') : '-' }}</span>
                                            <div class="small text-muted">Jatuh Tempo</div>
                                        </td>
                                        <td class="text-center text-muted">-</td>
                                        <td>
                                            <strong>{{ $payment->pelanggan->nama_pelanggan }}</strong>
                                            <div class="text-muted small">{{ $payment->pelanggan->nama_pic }}</div>
                                            <div class="text-danger small mt-1">
                                                <i class="bi bi-cash-coin me-1"></i>Tagihan: {{ $payment->formatted_nominal }}
                                            </div>
                                        </td>
                                        <td class="text-center text-muted">-</td>
                                        <td class="text-center text-muted">-</td>
                                        <td class="text-center">
                                            <a href="{{ route('kunjungan.create', ['pelanggan_id' => $payment->pelanggan_id]) }}" 
                                               class="btn btn-outline-danger btn-sm" 
                                               title="Buat Interaksi / Follow Up">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            @forelse($kunjungans as $index => $kunjungan)
                                <tr>
                                    <td>{{ $kunjungans->firstItem() + $index }}</td>
                                    <td>{{ $kunjungan->tanggal_kunjungan->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $kunjungan->metode_badge }}">
                                            <i class="bi {{ $kunjungan->metode_icon }} me-1"></i>
                                            {{ ucfirst($kunjungan->metode) }}
                                        </span>
                                    </td>
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
                                                    onclick="if(confirm('Yakin ingin menghapus data interaksi ini?')) { document.getElementById('delete-{{ $kunjungan->id }}').submit(); }">
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
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-inbox display-4 text-muted d-block mb-2"></i>
                                        <p class="text-muted">Tidak ada data interaksi</p>
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
