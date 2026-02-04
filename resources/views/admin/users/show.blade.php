@extends('layouts.admin')

@section('title', 'Detail User')
@section('page-title', 'Detail User')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Manajemen User</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-center">Detail Informasi User</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Nama Lengkap</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @elseif($user->role === 'marketing ssgs')
                                    <span class="badge bg-info">Marketing SSGS</span>
                                @elseif($user->role === 'marketing gs')
                                    <span class="badge bg-success">Marketing GS</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($user->role) }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Nomor Telepon</th>
                            <td>{{ $user->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Terdaftar Sejak</th>
                            <td>{{ $user->created_at->isoFormat('D MMMM Y HH:mm') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>{{ $user->updated_at->isoFormat('D MMMM Y HH:mm') }}</td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection