@php
    $user = Auth::user();
@endphp

<div class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-logo" style="justify-content: center;">
            <img src="{{ asset('logo.png') }}" alt="Uhuy Rental Logo"
                style="width: 100%; height: auto; max-width: 120px; filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.15));">
        </a>
    </div>

    <div class="user-badge">
        <p>Login sebagai : </p>
        <strong><i class="fas fa-user-circle me-2"></i>{{ $user->role }}</strong>
    </div>

    <ul class="nav flex-column">

        {{-- DASHBOARD SECTION --}}
        @if ($user->role === 'admin')
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard Admin</span>
                </a>
            </li>
        @endif

        @if ($user->role === 'petugas')
            <li class="nav-item">
                <a href="{{ route('petugas.dashboard') }}"
                    class="nav-link {{ Request::routeIs('petugas.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i>
                    <span>Dashboard Petugas</span>
                </a>
            </li>
        @endif

        {{-- ADMIN MENU --}}
        @if ($user->role === 'admin')
            <div class="nav-section-title">Manajemen</div>

            <li class="nav-item">
                <a href="{{ route('motors.index') }}"
                    class="nav-link {{ Request::routeIs('motors.index') ? 'active' : '' }}">
                    <i class="fas fa-motorcycle"></i>
                    <span>Data Motor</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.laporan-keuangan.index') }}"
                    class="nav-link {{ Request::routeIs('admin.laporan-keuangan.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Laporan Keuangan</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.petugas.index') }}"
                    class="nav-link {{ Request::routeIs('admin.petugas.*') ? 'active' : '' }}">
                    <i class="fas fa-users-cog"></i>
                    <span>Kelola Petugas</span>
                </a>
            </li>
        @endif

        {{-- PETUGAS MENU --}}
        @if ($user->role === 'petugas')
            <div class="nav-section-title">Operasional</div>

            <li class="nav-item">
                <a href="{{ route('petugas.sewas.index') }}"
                    class="nav-link {{ Request::routeIs('petugas.sewas.index') ? 'active' : '' }}">
                    <i class="fas fa-receipt"></i>
                    <span>Transaksi Sewa</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('petugas.pelanggans.index') }}"
                    class="nav-link {{ Request::routeIs('petugas.pelanggans.index') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Data Pelanggan</span>
                </a>
            </li>
        @endif

        <hr>

        {{-- LOGOUT --}}
        <li class="nav-item mt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </li>

    </ul>
</div>
