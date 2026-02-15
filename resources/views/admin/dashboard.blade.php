@extends('layouts.ini')

@section('title', 'Dashboard Admin')

@section('content')
    @php
        $totalMotor = (int) ($total_motor ?? 0);
        $motorTersedia = (int) ($motor_tersedia ?? 0);
        $motorDisewa = (int) ($motor_disewa ?? 0);
        $totalPelanggan = (int) ($total_pelanggan ?? 0);
        $totalSewa = (int) ($total_sewa ?? 0);
        $sewaAktif = (int) ($sewa_aktif ?? 0);
        $pendapatanHariIni = (float) ($pendapatan_hari_ini ?? 0);

        $persenTersedia = $totalMotor > 0 ? round(($motorTersedia / $totalMotor) * 100) : 0;
        $persenDisewa = $totalMotor > 0 ? round(($motorDisewa / $totalMotor) * 100) : 0;
        $persenSewaAktif = $totalSewa > 0 ? round(($sewaAktif / $totalSewa) * 100) : 0;
    @endphp

    <div class="admin-dash">
        <section class="dash-hero mb-4">
            <div>
                <span class="hero-chip"><i class="fas fa-shield-halved me-2"></i>Admin Dashboard</span>
                <h2 class="hero-title mb-1">Pusat Kontrol Rental Motor</h2>
                <p class="hero-subtitle mb-0">Pantau performa bisnis dan operasional harian dalam satu layar.</p>
            </div>
            <div class="hero-income">
                <small>Pendapatan Hari Ini</small>
                <h4 class="mb-0">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h4>
            </div>
        </section>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-6 col-xl-3">
                <div class="metric-card">
                    <div class="metric-icon icon-slate"><i class="fas fa-motorcycle"></i></div>
                    <div>
                        <p class="metric-label mb-1">Total Motor</p>
                        <h4 class="metric-value mb-0">{{ $totalMotor }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="metric-card">
                    <div class="metric-icon icon-blue"><i class="fas fa-circle-check"></i></div>
                    <div>
                        <p class="metric-label mb-1">Motor Tersedia</p>
                        <h4 class="metric-value mb-0">{{ $motorTersedia }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="metric-card">
                    <div class="metric-icon icon-amber"><i class="fas fa-receipt"></i></div>
                    <div>
                        <p class="metric-label mb-1">Total Sewa</p>
                        <h4 class="metric-value mb-0">{{ $totalSewa }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="metric-card">
                    <div class="metric-icon icon-emerald"><i class="fas fa-users"></i></div>
                    <div>
                        <p class="metric-label mb-1">Total Pelanggan</p>
                        <h4 class="metric-value mb-0">{{ $totalPelanggan }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12 col-xl-7">
                <div class="panel-card h-100">
                    <div class="panel-header">
                        <h6 class="mb-0">Ringkasan Operasional</h6>
                        <span class="badge rounded-pill text-bg-dark px-3 py-2">Real-Time</span>
                    </div>

                    <div class="summary-item">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Motor Tersedia</span>
                            <strong>{{ $motorTersedia }} ({{ $persenTersedia }}%)</strong>
                        </div>
                        <div class="progress modern-progress">
                            <div class="progress-bar bg-slate" style="width: {{ $persenTersedia }}%"></div>
                        </div>
                    </div>

                    <div class="summary-item">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Motor Disewa</span>
                            <strong>{{ $motorDisewa }} ({{ $persenDisewa }}%)</strong>
                        </div>
                        <div class="progress modern-progress">
                            <div class="progress-bar bg-blue" style="width: {{ $persenDisewa }}%"></div>
                        </div>
                    </div>

                    <div class="summary-item mb-0">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Sewa Aktif</span>
                            <strong>{{ $sewaAktif }} ({{ $persenSewaAktif }}%)</strong>
                        </div>
                        <div class="progress modern-progress">
                            <div class="progress-bar bg-amber" style="width: {{ $persenSewaAktif }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-5">
                <div class="panel-card h-100">
                    <h6 class="mb-3">Aksi Cepat</h6>
                    <div class="quick-grid">
                        <a href="{{ route('motors.create') }}" class="quick-action">
                            <i class="fas fa-plus-circle"></i>
                            <span>Tambah Motor</span>
                        </a>
                        <a href="{{ route('admin.laporan-keuangan.index') }}" class="quick-action">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Laporan Keuangan</span>
                        </a>
                        <a href="{{ route('admin.petugas.index') }}" class="quick-action">
                            <i class="fas fa-users-cog"></i>
                            <span>Kelola Petugas</span>
                        </a>
                        <a href="{{ route('motors.index') }}" class="quick-action">
                            <i class="fas fa-list-check"></i>
                            <span>Data Motor</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .dash-hero {
            background: linear-gradient(130deg, #0f172a 0%, #1f2937 55%, #334155 100%);
            border-radius: 18px;
            color: #fff;
            padding: 1.4rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 14px 32px rgba(15, 23, 42, 0.22);
        }

        .hero-chip {
            display: inline-flex;
            align-items: center;
            padding: .35rem .8rem;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.22);
            background: rgba(255, 255, 255, 0.12);
            font-size: .78rem;
            margin-bottom: .7rem;
        }

        .hero-title {
            font-size: 1.65rem;
            font-weight: 700;
        }

        .hero-subtitle {
            color: #dbe5f0;
            font-size: .93rem;
        }

        .hero-income {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            padding: .8rem 1rem;
            text-align: right;
            min-width: 220px;
        }

        .hero-income small {
            color: #dbe5f0;
            font-size: .78rem;
        }

        .metric-card {
            background: #fff;
            border: 1px solid #dbe4ef;
            border-radius: 16px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: .8rem;
            height: 100%;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.05);
        }

        .metric-icon {
            width: 44px;
            height: 44px;
            border-radius: 13px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .icon-slate {
            background: #e2e8f0;
            color: #1e293b;
        }

        .icon-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .icon-amber {
            background: #fef3c7;
            color: #92400e;
        }

        .icon-emerald {
            background: #dcfce7;
            color: #166534;
        }

        .metric-label {
            font-size: .83rem;
            color: #64748b;
        }

        .metric-value {
            color: #0f172a;
            font-weight: 700;
        }

        .panel-card {
            background: #fff;
            border: 1px solid #dbe4ef;
            border-radius: 16px;
            padding: 1.1rem;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.05);
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: .9rem;
        }

        .summary-item {
            margin-bottom: 1rem;
        }

        .summary-item span {
            color: #64748b;
            font-size: .9rem;
        }

        .summary-item strong {
            color: #0f172a;
            font-size: .9rem;
        }

        .modern-progress {
            height: 9px;
            background: #e2e8f0;
            border-radius: 999px;
        }

        .modern-progress .progress-bar {
            border-radius: 999px;
        }

        .bg-slate {
            background: linear-gradient(135deg, #334155, #0f172a);
        }

        .bg-blue {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
        }

        .bg-amber {
            background: linear-gradient(135deg, #f59e0b, #b45309);
        }

        .quick-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .7rem;
        }

        .quick-action {
            border: 1px solid #dbe4ef;
            background: #f8fafc;
            border-radius: 12px;
            min-height: 86px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            text-decoration: none;
            color: #1f2937;
            font-weight: 600;
            font-size: .85rem;
            transition: all .2s ease;
        }

        .quick-action i {
            font-size: 1.1rem;
            color: #0f172a;
        }

        .quick-action:hover {
            background: #0f172a;
            border-color: #0f172a;
            color: #fff;
            transform: translateY(-2px);
        }

        .quick-action:hover i {
            color: #fff;
        }

        @media (max-width: 768px) {
            .dash-hero {
                flex-direction: column;
                align-items: flex-start;
            }

            .hero-income {
                width: 100%;
                min-width: 0;
                text-align: left;
            }
        }
    </style>
@endsection
