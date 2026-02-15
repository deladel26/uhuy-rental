@extends('layouts.ini')
@section('title', 'Data Motor')

@section('content')
    <div class="container-fluid">

        <!-- Alert Messages -->
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

        <!-- Page Header -->
        <div class="hero-panel mb-4">
            <div class="hero-content">
                <span class="hero-chip"><i class="fas fa-warehouse me-2"></i>Fleet Management</span>
                <h2 class="page-title mb-1">Data Motor</h2>
                <p class="page-subtitle mb-0">Kelola armada rental dengan tampilan yang lebih cepat dibaca dan mudah
                    difilter.</p>
            </div>
            <a href="{{ route('motors.create') }}" class="btn-add">
                <i class="fas fa-plus me-2"></i> Tambah Motor
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="stat-icon bg-success">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Total Motor</p>
                        <h3 class="stat-value">{{ $motors->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Tersedia</p>
                        <h3 class="stat-value">{{ $motors->where('status', 'tersedia')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="stat-icon bg-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Disewa</p>
                        <h3 class="stat-value">{{ $motors->where('status', 'disewa')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="stat-icon bg-danger">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Servis</p>
                        <h3 class="stat-value">{{ $motors->where('status', 'servis')->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="filter-card mb-4">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" class="search-input"
                            placeholder="Cari plat nomor, merk, warna...">
                    </div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <select class="filter-select" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="disewa">Disewa</option>
                        <option value="servis">Servis</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="filter-select" id="kondisiFilter">
                        <option value="">Semua Kondisi</option>
                        <option value="baik">Baik</option>
                        <option value="sedang">Sedang</option>
                        <option value="perlu_perbaikan">Perlu Perbaikan</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Motor Cards Grid -->
        <div class="row" id="motorGrid">
            @forelse($motors as $motor)
                <div class="col-md-6 col-lg-4 col-xl-3 mb-4 motor-item" data-status="{{ $motor->status }}"
                    data-kondisi="{{ $motor->kondisi }}"
                    data-search="{{ strtolower($motor->plat_nomor . ' ' . $motor->merk . ' ' . $motor->warna) }}">
                    <div class="motor-card">

                        <!-- Motor Image/Icon with Status -->
                        <div class="motor-image-wrapper">
                            <div class="motor-image">
                                <i class="fas fa-motorcycle"></i>
                            </div>
                            <div class="motor-status-badge">
                                @if ($motor->status == 'tersedia')
                                    <span class="badge-status badge-available">
                                        <i class="fas fa-check-circle"></i> Tersedia
                                    </span>
                                @elseif($motor->status == 'disewa')
                                    <span class="badge-status badge-rented">
                                        <i class="fas fa-clock"></i> Disewa
                                    </span>
                                @else
                                    <span class="badge-status badge-servis">
                                        <i class="fas fa-tools"></i> Servis
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Motor Info -->
                        <div class="motor-info">
                            <div class="motor-header">
                                <h4 class="motor-plat">{{ $motor->plat_nomor }}</h4>
                                <p class="motor-merk">{{ $motor->merk }}</p>
                            </div>

                            <div class="motor-details">
                                <div class="detail-row">
                                    <div class="detail-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>{{ $motor->tahun }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-palette"></i>
                                        <span>{{ ucfirst($motor->warna) }}</span>
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-item full-width">
                                        <i class="fas fa-star"></i>
                                        <span>Kondisi: {{ ucfirst(str_replace('_', ' ', $motor->kondisi)) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="motor-price">
                                <div class="price-content">
                                    <span class="price-value">Rp
                                        {{ number_format($motor->harga_sewa, 0, ',', '.') }}</span>
                                    <span class="price-period">/hari</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="motor-actions">
                                <a href="{{ route('motors.edit', $motor->id) }}" class="btn-action btn-edit"
                                    title="Edit Motor">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('motors.destroy', $motor->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus motor ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Hapus Motor">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-motorcycle"></i>
                        <h4>Belum Ada Data Motor</h4>
                        <p>Klik tombol "Tambah Motor" untuk menambahkan data motor baru</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>

    <style>
        .page-title {
            font-size: 1.9rem;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
        }

        .page-subtitle {
            font-size: 0.95rem;
            color: #cbd5e1;
        }

        .hero-panel {
            background: linear-gradient(130deg, #0f172a 0%, #1f2937 55%, #334155 100%);
            border-radius: 20px;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 16px 32px rgba(15, 23, 42, 0.28);
        }

        .hero-chip {
            display: inline-flex;
            align-items: center;
            font-size: .8rem;
            color: #e2e8f0;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 999px;
            padding: .35rem .8rem;
            margin-bottom: .8rem;
        }

        .btn-add {
            background: linear-gradient(135deg, #1f2937 0%, #b89d7e 100%);
            border: 0;
            color: white;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(184, 157, 126, 0.35);
            text-decoration: none;
            display: inline-block;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(184, 157, 126, 0.42);
            color: white;
        }

        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #dbe4ef;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.1);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            flex-shrink: 0;
        }

        .stat-icon.bg-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .stat-icon.bg-primary {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        }

        .stat-icon.bg-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .stat-icon.bg-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        .stat-content {
            flex: 1;
            min-width: 0;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #64748b;
            margin: 0 0 4px 0;
            font-weight: 500;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            line-height: 1;
        }

        /* Filter Card */
        .filter-card {
            background: white;
            border-radius: 16px;
            padding: 16px;
            border: 1px solid #dbe4ef;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
        }

        .search-box {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            z-index: 1;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 45px;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            font-size: 0.95rem;
            background: #f8fafc;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #0f172a;
            background: white;
            box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.08);
        }

        .filter-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            font-size: 0.95rem;
            background: #f8fafc;
            color: #1e293b;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-select:focus {
            outline: none;
            border-color: #0f172a;
            background: white;
            box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.08);
        }

        /* Motor Cards - IMPROVED */
        .motor-card {
            background: white;
            border-radius: 18px;
            border: 1px solid #dbe4ef;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
        }

        .motor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.14);
            border-color: #1f2937;
        }

        .motor-image-wrapper {
            position: relative;
            background:
                radial-gradient(circle at 10% 20%, rgba(255, 255, 255, 0.22), transparent 40%),
                linear-gradient(140deg, #1f2937 0%, #334155 70%, #475569 100%);
            padding: 32px 20px;
        }

        .motor-image {
            text-align: center;
        }

        .motor-image i {
            font-size: 4rem;
            color: white;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .motor-status-badge {
            position: absolute;
            top: 12px;
            right: 12px;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .badge-available {
            background: rgba(209, 250, 229, 0.95);
            color: #065f46;
        }

        .badge-rented {
            background: rgba(254, 243, 199, 0.95);
            color: #92400e;
        }

        .badge-servis {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
        }

        .motor-info {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .motor-header {
            margin-bottom: 16px;
        }

        .motor-plat {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 4px 0;
            letter-spacing: 0.5px;
        }

        .motor-merk {
            font-size: 0.9rem;
            color: #64748b;
            margin: 0;
            font-weight: 500;
        }

        .motor-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        .detail-row {
            display: flex;
            gap: 12px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: #475569;
            flex: 1;
            background: #f8fafc;
            padding: 8px 10px;
            border-radius: 8px;
        }

        .detail-item.full-width {
            flex: 1 1 100%;
        }

        .detail-item i {
            width: 14px;
            color: #94a3b8;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .detail-item span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .motor-price {
            background: linear-gradient(135deg, #fffaf2 0%, #fef3c7 100%);
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 16px;
            border: 1px solid #fde68a;
        }

        .price-content {
            display: flex;
            align-items: baseline;
            gap: 4px;
            justify-content: center;
        }

        .price-value {
            font-size: 1.3rem;
            font-weight: 700;
            color: #92400e;
            line-height: 1;
        }

        .price-period {
            font-size: 0.85rem;
            color: #92400e;
            font-weight: 500;
        }

        .motor-actions {
            display: flex;
            gap: 8px;
            margin-top: auto;
        }

        .btn-action {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-edit {
            background: #f8fafc;
            color: #0f172a;
            border: 1px solid #cbd5e1;
        }

        .btn-edit:hover {
            background: #0f172a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.3);
        }

        .btn-delete {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .btn-delete:hover {
            background: #dc2626;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 20px;
            border: 2px dashed #dbe4ef;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
        }

        .empty-state i {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 16px;
        }

        .empty-state h4 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .empty-state p {
            color: #64748b;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-panel {
                flex-direction: column;
                align-items: flex-start;
            }

            .motor-plat {
                font-size: 1.1rem;
            }

            .price-value {
                font-size: 1.1rem;
            }

            .motor-image i {
                font-size: 3rem;
            }

            .btn-action {
                padding: 10px;
                font-size: 0.9rem;
            }
        }
    </style>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', filterMotors);
        document.getElementById('statusFilter').addEventListener('change', filterMotors);
        document.getElementById('kondisiFilter').addEventListener('change', filterMotors);

        function filterMotors() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const statusValue = document.getElementById('statusFilter').value;
            const kondisiValue = document.getElementById('kondisiFilter').value;
            const motorItems = document.querySelectorAll('.motor-item');

            motorItems.forEach(item => {
                const searchText = item.getAttribute('data-search');
                const status = item.getAttribute('data-status');
                const kondisi = item.getAttribute('data-kondisi');

                const matchSearch = searchText.includes(searchValue);
                const matchStatus = !statusValue || status === statusValue;
                const matchKondisi = !kondisiValue || kondisi === kondisiValue;

                if (matchSearch && matchStatus && matchKondisi) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>
@endsection

