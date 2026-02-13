<div class="dropdown">
    <a href="#" class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
        <div class="me-2 text-end d-none d-md-block">
            <div class="fw-bold text-dark" style="font-size: 14px;">{{ Auth::user()->name }}</div>
            <div class="text-muted" style="font-size: 11px;">{{ Auth::user()->email }}</div>
        </div>
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e30613&color=ffffff" 
             alt="Avatar" class="rounded-circle shadow-sm" width="40" height="40">
    </a>

    <div class="dropdown-menu dropdown-menu-end profile-popover p-0 border-0 shadow-lg" style="margin-top: 12px;">
        
        {{-- HEADER --}}
        <div class="profile-header">
            <div class="d-flex align-items-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e30613&color=ffffff" 
                     class="rounded-circle me-3" width="48" height="48">
                <div>
                    <h6 class="fw-bold mb-0 text-dark">{{ Auth::user()->name }}</h6>
                    <small class="text-muted" style="font-size: 12px;">{{ Auth::user()->email }}</small>
                </div>
            </div>
        </div>

        <div class="popover-divider"></div>

        {{-- LOGOUT ACTION --}}
        <div class="logout-action">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .profile-popover {
        min-width: 280px;
        border-radius: 16px;
        overflow: hidden;
        animation: fadeIn 0.2s ease;
    }

    .profile-header {
        padding: 20px;
        background-color: #fff;
    }

    .popover-divider {
        height: 1px;
        background-color: #f1f3f5;
        margin: 0;
    }

    .logout-action {
        padding: 8px;
    }

    .btn-logout {
        width: 100%;
        height: 44px;
        padding: 0 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        border-radius: 10px;
        color: #e30613;
        background: transparent;
        border: none;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-logout:hover {
        background-color: rgba(227, 6, 19, 0.05);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>