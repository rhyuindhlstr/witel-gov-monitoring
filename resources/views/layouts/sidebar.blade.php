<li class="nav-item">
    <a href="{{ route('dashboard.gs') }}" class="nav-link {{ request()->routeIs('dashboard.gs') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('/peluang-gs') }}" class="nav-link {{ request()->is('peluang-gs*') ? 'active' : '' }}">
        <i class="bi bi-briefcase"></i> Peluang Proyek
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('/aktivitas-marketing') }}" class="nav-link {{ request()->is('aktivitas-marketing*') ? 'active' : '' }}">
        <i class="bi bi-people"></i> Aktivitas Marketing
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="bi bi-file-earmark-bar-graph"></i> Laporan
    </a>
</li>
