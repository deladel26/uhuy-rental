@extends('layouts.ini')

@section('title', 'Kelola Petugas')

@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="hero-panel mb-4">
            <div class="hero-content">
                <span class="chip-label"><i class="fas fa-user-shield me-2"></i>Admin Control</span>
                <h2 class="hero-title mb-1">Kelola Petugas</h2>
                <p class="hero-subtitle mb-0">Atur akun petugas, pantau aktivitas, dan kontrol status operasional.</p>
            </div>
            <a href="{{ route('admin.petugas.create') }}" class="btn-modern btn-modern-light">
                <i class="fas fa-user-plus me-2"></i>Tambah Petugas
            </a>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="metric-card">
                    <span class="metric-icon icon-primary"><i class="fas fa-users"></i></span>
                    <div>
                        <p class="metric-label mb-1">Total Petugas</p>
                        <h5 class="metric-value mb-0">{{ $totalPetugas }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="metric-card">
                    <span class="metric-icon icon-success"><i class="fas fa-user-check"></i></span>
                    <div>
                        <p class="metric-label mb-1">Status Aktif</p>
                        <h5 class="metric-value mb-0">{{ $totalAktif }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="metric-card">
                    <span class="metric-icon icon-danger"><i class="fas fa-user-slash"></i></span>
                    <div>
                        <p class="metric-label mb-1">Status Non-Aktif</p>
                        <h5 class="metric-value mb-0">{{ $totalNonAktif }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <form method="GET" class="panel-card panel-filter mb-4">
            <div class="row g-2 align-items-center">
                <div class="col-12 col-lg-8">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="q" value="{{ $q }}" class="search-input"
                            placeholder="Cari nama, username, atau email">
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ $status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="non-aktif" {{ $status === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
                <div class="col-12 col-lg-1 d-grid">
                    <button type="submit" class="btn-modern btn-modern-dark">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>
        </form>

        <div class="panel-card overflow-hidden">
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Total Sewa</th>
                            <th>Dibuat</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($petugas as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="avatar-initial">{{ strtoupper(substr($item->name, 0, 1)) }}</span>
                                        <span class="fw-semibold">{{ $item->name }}</span>
                                    </div>
                                </td>
                                <td><code class="text-dark">{{ $item->username }}</code></td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    <span
                                        class="badge rounded-pill {{ $item->status === 'aktif' ? 'text-bg-success' : 'text-bg-secondary' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>{{ $item->sewas_count }}</td>
                                <td>{{ optional($item->created_at)->format('d M Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.petugas.edit', $item->id) }}"
                                        class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="fas fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.petugas.destroy', $item->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus akun petugas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">Belum ada data petugas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($petugas->hasPages())
                <div class="px-3 py-3 border-top">
                    {{ $petugas->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .hero-panel {
            background: linear-gradient(120deg, #0f172a 0%, #1f2937 100%);
            color: #fff;
            border-radius: 18px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.25);
        }

        .chip-label {
            display: inline-flex;
            align-items: center;
            padding: .35rem .8rem;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.14);
            font-size: .75rem;
            margin-bottom: .8rem;
        }

        .hero-title {
            font-size: 1.7rem;
            font-weight: 700;
            letter-spacing: .2px;
        }

        .hero-subtitle {
            color: #cbd5e1;
            font-size: .92rem;
        }

        .btn-modern {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 12px;
            padding: .6rem 1rem;
            font-weight: 600;
            text-decoration: none;
            min-height: 42px;
        }

        .btn-modern-light {
            background: rgba(255, 255, 255, 0.13);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        .btn-modern-light:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.2);
        }

        .btn-modern-dark {
            background: linear-gradient(135deg, #0f172a, #374151);
            color: #fff;
        }

        .btn-modern-dark:hover {
            color: #fff;
            opacity: .95;
        }

        .panel-card {
            background: #fff;
            border: 1px solid #dbe4ef;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
        }

        .panel-filter {
            padding: .9rem;
        }

        .metric-card {
            background: #fff;
            border: 1px solid #dbe4ef;
            border-radius: 16px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: .85rem;
            height: 100%;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
        }

        .metric-icon {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .icon-primary {
            background: #e2e8f0;
            color: #1e293b;
        }

        .icon-success {
            background: #dcfce7;
            color: #166534;
        }

        .icon-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .metric-label {
            color: #64748b;
            font-size: .85rem;
        }

        .metric-value {
            color: #0f172a;
            font-weight: 700;
        }

        .search-box {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .search-input {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 11px;
            padding: .6rem .85rem .6rem 2.2rem;
        }

        .avatar-initial {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: .78rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #334155, #0f172a);
        }

        .table-modern th {
            color: #64748b;
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .3px;
            border-bottom-color: #e5edf6;
            padding-top: .85rem;
            padding-bottom: .85rem;
        }

        .table-modern td {
            border-bottom-color: #eff4f9;
            color: #1e293b;
        }

        @media (max-width: 768px) {
            .hero-panel {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endsection
