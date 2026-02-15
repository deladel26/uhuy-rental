@extends('layouts.ini')

@section('title', 'Dashboard Petugas')

@section('content')
    @php
        $stats = [
            ['label' => 'Sewa Aktif', 'value' => $sewa_aktif ?? 0, 'icon' => 'fa-circle-check', 'accent' => 'success'],
            ['label' => 'Motor Tersedia', 'value' => $motor_tersedia ?? 0, 'icon' => 'fa-motorcycle', 'accent' => 'primary'],
            ['label' => 'Sewa Hari Ini', 'value' => $sewa_hari_ini ?? 0, 'icon' => 'fa-calendar-day', 'accent' => 'warning'],
            ['label' => 'Jatuh Tempo/Keterlambatan', 'value' => $sewa_jatuh_tempo ?? 0, 'icon' => 'fa-clock', 'accent' => 'danger'],
            ['label' => 'Motor Disewa', 'value' => $motor_disewa ?? 0, 'icon' => 'fa-key', 'accent' => 'secondary'],
            ['label' => 'Total Pelanggan', 'value' => $total_pelanggan ?? 0, 'icon' => 'fa-users', 'accent' => 'info'],
        ];

        $statusClass = [
            'aktif' => 'status-chip status-chip-success',
            'selesai' => 'status-chip status-chip-primary',
            'terlambat' => 'status-chip status-chip-danger',
        ];
    @endphp

    <style>
        .petugas-dashboard {
            --ink: #0f172a;
            --muted: #64748b;
            --surface: #ffffff;
            --line: #e2e8f0;
            --primary: #0ea5e9;
            --soft-primary: #e0f2fe;
        }

        .hero-card {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 20px;
            padding: 28px;
            background: linear-gradient(140deg, #0f172a 0%, #1e293b 55%, #334155 100%);
            color: #fff;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.2);
        }

        .hero-card::after {
            content: "";
            position: absolute;
            width: 240px;
            height: 240px;
            right: -40px;
            top: -90px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.4) 0%, rgba(14, 165, 233, 0) 70%);
        }

        .hero-title {
            font-size: clamp(1.35rem, 2vw, 1.85rem);
            font-weight: 700;
            margin-bottom: 8px;
        }

        .hero-subtitle {
            margin-bottom: 18px;
            color: rgba(255, 255, 255, 0.8);
        }

        .hero-metric {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border-radius: 12px;
            padding: 10px 14px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(4px);
            font-weight: 600;
            font-size: 0.95rem;
            margin-right: 8px;
            margin-bottom: 8px;
        }

        .mini-income-card {
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 22px;
            height: 100%;
            background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        }

        .mini-income-card h6 {
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
            margin-bottom: 12px;
        }

        .income-value {
            font-size: clamp(1.35rem, 2vw, 1.75rem);
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 8px;
        }

        .stat-card {
            border: 1px solid var(--line);
            border-radius: 16px;
            background: var(--surface);
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.04);
            padding: 16px;
            height: 100%;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.09);
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            font-size: 1rem;
            color: #fff;
        }

        .stat-label {
            color: var(--muted);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 1.75rem;
            line-height: 1.1;
            font-weight: 700;
            color: var(--ink);
        }

        .bg-accent-success {
            background: linear-gradient(135deg, #22c55e, #16a34a);
        }

        .bg-accent-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }

        .bg-accent-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .bg-accent-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .bg-accent-secondary {
            background: linear-gradient(135deg, #64748b, #475569);
        }

        .bg-accent-info {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
        }

        .transactions-card {
            border: 1px solid var(--line);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.06);
            background: #fff;
        }

        .transactions-header {
            border-bottom: 1px solid var(--line);
            padding: 16px 20px;
        }

        .transactions-title {
            margin: 0;
            font-weight: 700;
            color: var(--ink);
        }

        .table-modern thead th {
            background: #f8fafc;
            color: var(--muted);
            font-size: 0.8rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            font-weight: 700;
            border-bottom: 1px solid var(--line);
            padding: 14px 20px;
        }

        .table-modern td {
            border-color: #f1f5f9;
            color: #1e293b;
            font-weight: 500;
            padding: 16px 20px;
            vertical-align: middle;
        }

        .status-chip {
            display: inline-block;
            border-radius: 999px;
            padding: 0.35rem 0.8rem;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .status-chip-success {
            color: #15803d;
            background: #dcfce7;
        }

        .status-chip-primary {
            color: #1d4ed8;
            background: #dbeafe;
        }

        .status-chip-danger {
            color: #b91c1c;
            background: #fee2e2;
        }

        .status-chip-default {
            color: #475569;
            background: #e2e8f0;
        }

        .empty-state {
            padding: 34px 16px;
            color: var(--muted);
            text-align: center;
            font-weight: 500;
        }

        @media (max-width: 991.98px) {
            .hero-card {
                margin-bottom: 14px;
            }
        }
    </style>

    <div class="petugas-dashboard">
        <div class="row g-3 mb-4">
            <div class="col-12 col-xl-8">
                <div class="hero-card h-100">
                    <h2 class="hero-title">Ringkasan Operasional Hari Ini</h2>
                    <p class="hero-subtitle">Pantau aktivitas sewa, ketersediaan unit, dan transaksi terbaru dalam satu layar.</p>
                    <span class="hero-metric">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ $sewa_aktif ?? 0 }} sewa aktif
                    </span>
                    <span class="hero-metric">
                        <i class="fa-solid fa-motorcycle"></i>
                        {{ $motor_tersedia ?? 0 }} unit tersedia
                    </span>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="mini-income-card">
                    <h6>Pendapatan Hari Ini</h6>
                    <div class="income-value">Rp {{ number_format($pendapatan_hari_ini ?? 0, 0, ',', '.') }}</div>
                    <div class="text-muted">Nilai total transaksi yang dibuat hari ini.</div>
                    <a href="{{ route('petugas.sewas.create') }}" class="btn btn-dark btn-sm mt-3">
                        <i class="fa-solid fa-plus me-1"></i> Buat Sewa Baru
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            @foreach ($stats as $item)
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="stat-card">
                        <div class="stat-top">
                            <div class="stat-label">{{ $item['label'] }}</div>
                            <div class="stat-icon bg-accent-{{ $item['accent'] }}">
                                <i class="fa-solid {{ $item['icon'] }}"></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $item['value'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="transactions-card">
            <div class="transactions-header d-flex justify-content-between align-items-center gap-2">
                <h5 class="transactions-title">Transaksi Terbaru</h5>
                <a href="{{ route('petugas.sewas.index') }}" class="btn btn-sm btn-outline-dark">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-modern table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Motor</th>
                            <th>Status</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi_terbaru as $sewa)
                            <tr>
                                <td>{{ optional($sewa->tanggal_sewa)->format('d M Y') }}</td>
                                <td>{{ $sewa->pelanggan->nama ?? '-' }}</td>
                                <td>{{ $sewa->motor->merk ?? '-' }}</td>
                                <td>
                                    <span class="{{ $statusClass[$sewa->status] ?? 'status-chip status-chip-default' }}">
                                        {{ ucfirst($sewa->status) }}
                                    </span>
                                </td>
                                <td class="text-end fw-semibold">Rp {{ number_format($sewa->total_harga ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">Belum ada transaksi terbaru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
