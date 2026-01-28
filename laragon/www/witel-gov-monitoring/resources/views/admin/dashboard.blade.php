@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

    {{-- Statistik --}}
    <div class="row g-4 mb-4">

        {{-- Wilayah --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-danger text-white me-3">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">{{ App\Models\Wilayah::count() }}</h3>
                        <small class="text-muted">Wilayah</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total User --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-info text-white me-3">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">{{ App\Models\User::count() }}</h3>
                        <small class="text-muted">Total User</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Admin --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-warning text-white me-3">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">
                            {{ App\Models\User::where('role', 'admin')->count() }}
                        </h3>
                        <small class="text-muted">Admin</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Marketing SSGS --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-info text-white me-3">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">
                            {{ App\Models\User::where('role', 'marketing ssgs')->count() }}
                        </h3>
                        <small class="text-muted">Marketing SSGS</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Marketing GS --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-success text-white me-3">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">
                            {{ App\Models\User::where('role', 'marketing gs')->count() }}
                        </h3>
                        <small class="text-muted">Marketing GS</small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Informasi Sistem --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-semibold">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    Informasi Sistem
                </div>
                <div class="card-body">

                    <h5 class="fw-bold mb-2">
                        Selamat Datang di Sistem Monitoring Aktivitas Sales Government
                    </h5>
                    <p class="text-muted mb-3">
                        Telkom Witel Lampung – Bengkulu<br>
                        Sistem informasi internal untuk tim <strong>Government Service</strong> & <strong>SSGS</strong>.
                    </p>

                    <hr>

                    {{-- Info User --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Nama</strong></p>
                            <p class="text-muted">{{ auth()->user()->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Role</strong></p>
                            <span class="badge bg-primary text-uppercase">
                                {{ auth()->user()->role }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 mt-3"><strong>Email</strong></p>
                            <p class="text-muted">{{ auth()->user()->email }}</p>
                        </div>
                        @if(auth()->user()->phone)
                            <div class="col-md-6">
                                <p class="mb-1 mt-3"><strong>Telepon</strong></p>
                                <p class="text-muted">{{ auth()->user()->phone }}</p>
                            </div>
                        @endif
                    </div>

                    {{-- Alert Role --}}
                    @if(auth()->user()->role === 'admin')
                        <div class="alert alert-info d-flex align-items-center mb-0">
                            <i class="fas fa-user-shield fa-lg me-3"></i>
                            <div>
                                <strong>Akses Admin</strong><br>
                                Anda memiliki hak penuh untuk mengelola data wilayah dan manajemen user.
                            </div>
                        </div>
                    @else
                        <div class="alert alert-success d-flex align-items-center mb-0">
                            <i class="fas fa-user-tie fa-lg me-3"></i>
                            <div>
                                <strong>Tim Marketing</strong><br>
                                Anda dapat mengelola data Sales Government dan SSGS.
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection