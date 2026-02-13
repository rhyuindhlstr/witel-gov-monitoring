@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'My Profile')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.ssgs') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Profile</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center text-white rounded-circle shadow-sm"
                            style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: bold; background-color: var(--telkom-red);">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>

                    <h3 class="font-weight-bold text-dark mb-1">{{ $user->name }}</h3>
                    <p class="text-muted mb-4">{{ strtoupper(str_replace('_', ' ', $user->role)) }}</p>

                    <div class="text-start px-md-5">
                        <div class="mb-4">
                            <label class="small text-uppercase text-muted font-weight-bold mb-1">Full Name</label>
                            <div class="p-3 bg-light rounded border border-light text-dark fw-medium">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="small text-uppercase text-muted font-weight-bold mb-1">Email Address</label>
                            <div class="p-3 bg-light rounded border border-light text-dark fw-medium">
                                {{ $user->email }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="small text-uppercase text-muted font-weight-bold mb-1">Password</label>
                            <div class="p-3 bg-light rounded border border-light text-dark fw-medium font-monospace">
                                &bullet;&bullet;&bullet;&bullet;&bullet;&bullet;&bullet;&bullet;
                            </div>
                        </div>

                        <div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
                            <i class="bi bi-exclamation-triangle-fill fs-5 me-3"></i>
                            <div class="small">
                                This account is managed by the administrator. To update your information or password, please
                                contact IT Support.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection