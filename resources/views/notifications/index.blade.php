@extends('layouts.app')

@section('title', 'Notifications')
@section('page-title', 'Notifications')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.ssgs') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Notifications</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-dark">All Notifications</h6>
                <form action="{{ route('notifications.markRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-light text-danger fw-bold">
                        <i class="bi bi-check2-all me-1"></i> Mark all as read
                    </button>
                </form>
            </div>
            
            <div class="list-group list-group-flush">
                @forelse($notifications as $notification)
                    <a href="{{ $notification['action_url'] }}" class="list-group-item list-group-item-action px-4 py-3 {{ !$notification['read'] ? 'bg-light' : '' }}">
                        <div class="d-flex align-items-start">
                            <div class="bg-{{ $notification['type'] }} bg-opacity-10 text-{{ $notification['type'] }} rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                <i class="bi {{ $notification['icon'] }} fs-5"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0 text-dark fw-bold">{{ $notification['title'] }}</h6>
                                    <small class="text-muted">{{ $notification['time'] }}</small>
                                </div>
                                <p class="mb-0 text-secondary">{{ $notification['message'] }}</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-5">
                        <div class="text-muted mb-3">
                            <i class="bi bi-bell-slash fs-1"></i>
                        </div>
                        <p class="h5 text-muted">No notifications found</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
