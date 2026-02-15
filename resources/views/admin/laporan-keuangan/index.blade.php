@extends('layouts.ini')

@section('title', 'Laporan Keuangan')

@section('content')
    @php
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
        $labelPeriodeBulan = $bulan === 'semua' ? 'Semua Bulan' : ($namaBulan[(int) $bulan] ?? $bulan);
    @endphp

    <style>
        .finance-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #fff;
            border-radius: 18px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            border: 0;
            box-shadow: 0 16px 32px rgba(15, 23, 42, 0.24);
        }

        .finance-hero::after {
            content: '';
            position: absolute;
            top: -40px;
            right: -30px;
            width: 180px;
            height: 180px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2), transparent 70%);
        }

        .finance-chip {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.22);
            color: #e2e8f0;
            padding: .4rem .75rem;
            border-radius: 999px;
            font-size: .8rem;
            font-weight: 500;
        }

        .finance-filter-card {
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .finance-filter-card .form-label {
            font-size: .85rem;
            color: #475569;
            font-weight: 600;
        }

        .finance-filter-card .form-select {
            border-radius: 10px;
            border-color: #cbd5e1;
        }

        .finance-filter-card .btn-filter {
            border-radius: 10px;
            font-weight: 600;
            background: linear-gradient(135deg, #0f172a, #334155);
            border: 0;
        }

        .finance-stat-card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .finance-stat-card .icon-wrap {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            margin-bottom: .75rem;
        }

        .bg-soft-primary {
            background: #e0e7ff;
            color: #3730a3;
        }

        .bg-soft-success {
            background: #dcfce7;
            color: #166534;
        }

        .bg-soft-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .bg-soft-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .finance-table-card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .finance-table-card .table thead th {
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 700;
            padding-top: .9rem;
            padding-bottom: .9rem;
        }

        .finance-table-card .table tbody td {
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-size: .92rem;
            vertical-align: middle;
        }

        .finance-table-card .table tbody tr:last-child td {
            border-bottom: 0;
        }
    </style>

    <div class="row g-3 mb-4">
        <div class="col-12 col-xl-8">
            <div class="finance-hero h-100">
                <span class="finance-chip mb-3"><i class="fas fa-calendar-alt"></i> Periode Aktif</span>
                <h5 class="fw-bold mb-1">Laporan Keuangan</h5>
                <p class="mb-0 text-light">
                    Ringkasan transaksi sewa periode {{ $labelPeriodeBulan }} {{ $tahun }}.
                </p>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <form method="GET" action="{{ route('admin.laporan-keuangan.index') }}" class="card finance-filter-card h-100">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="fas fa-filter me-1"></i>Filter Data</h6>
                    <div class="row g-2">
                        <div class="col-12">
                            <label for="bulan" class="form-label mb-1">Bulan</label>
                            <select name="bulan" id="bulan" class="form-select">
                                <option value="semua" {{ $bulan === 'semua' ? 'selected' : '' }}>Semua Bulan</option>
                                @foreach ($namaBulan as $nomor => $label)
                                    <option value="{{ $nomor }}" {{ (string) $bulan === (string) $nomor ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="tahun" class="form-label mb-1">Tahun</label>
                            <select name="tahun" id="tahun" class="form-select">
                                @foreach ($tahunTersedia as $itemTahun)
                                    <option value="{{ $itemTahun }}" {{ (int) $tahun === (int) $itemTahun ? 'selected' : '' }}>
                                        {{ $itemTahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="status_pembayaran" class="form-label mb-1">Status Pembayaran</label>
                            <select name="status_pembayaran" id="status_pembayaran" class="form-select">
                                <option value="" {{ $statusPembayaran === '' ? 'selected' : '' }}>Semua</option>
                                <option value="lunas" {{ $statusPembayaran === 'lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="belum" {{ $statusPembayaran === 'belum' ? 'selected' : '' }}>Belum</option>
                            </select>
                        </div>
                        <div class="col-12 d-grid mt-2">
                            <button type="submit" class="btn btn-dark btn-filter">Terapkan Filter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card finance-stat-card h-100">
                <div class="card-body">
                    <div class="icon-wrap bg-soft-primary"><i class="fas fa-receipt"></i></div>
                    <div class="text-muted small mb-1">Total Transaksi</div>
                    <div class="h4 mb-0">{{ $totalTransaksi }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card finance-stat-card h-100">
                <div class="card-body">
                    <div class="icon-wrap bg-soft-warning"><i class="fas fa-wallet"></i></div>
                    <div class="text-muted small mb-1">Pendapatan Bruto</div>
                    <div class="h5 mb-0">Rp {{ number_format($totalPendapatanBruto, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card finance-stat-card h-100">
                <div class="card-body">
                    <div class="icon-wrap bg-soft-success"><i class="fas fa-circle-check"></i></div>
                    <div class="text-muted small mb-1">Pendapatan Lunas</div>
                    <div class="h5 mb-0 text-success">Rp {{ number_format($totalPendapatanLunas, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card finance-stat-card h-100">
                <div class="card-body">
                    <div class="icon-wrap bg-soft-danger"><i class="fas fa-hourglass-half"></i></div>
                    <div class="text-muted small mb-1">Piutang (Belum Lunas)</div>
                    <div class="h5 mb-0 text-danger">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card finance-stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1"><i class="fas fa-triangle-exclamation text-warning me-1"></i>Total Denda Periode</h6>
                        <p class="text-muted mb-0">Akumulasi denda dari seluruh transaksi pada filter aktif.</p>
                    </div>
                    <div class="h5 mb-0 text-warning">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card finance-table-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Detail Transaksi</h5>
                <span class="badge rounded-pill text-bg-dark px-3 py-2">{{ $transaksis->count() }} data</span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Motor</th>
                            <th>Status Sewa</th>
                            <th>Status Bayar</th>
                            <th class="text-end">Total</th>
                            <th class="text-end">Denda</th>
                            <th class="text-end">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $trx)
                            @php
                                $denda = $trx->denda ?? 0;
                                $nominal = ($trx->total_harga ?? 0) + $denda;
                            @endphp
                            <tr>
                                <td>{{ optional($trx->tanggal_sewa)->format('d M Y') }}</td>
                                <td>{{ $trx->pelanggan->nama ?? '-' }}</td>
                                <td>{{ $trx->motor->merk ?? '-' }} ({{ $trx->motor->plat_nomor ?? '-' }})</td>
                                <td>
                                    <span class="badge {{ $trx->status === 'selesai' ? 'text-bg-success' : ($trx->status === 'batal' ? 'text-bg-danger' : 'text-bg-warning') }}">
                                        {{ ucfirst($trx->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $trx->status_pembayaran === 'lunas' ? 'text-bg-primary' : 'text-bg-secondary' }}">
                                        {{ ucfirst($trx->status_pembayaran) }}
                                    </span>
                                </td>
                                <td class="text-end">Rp {{ number_format($trx->total_harga ?? 0, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($denda, 0, ',', '.') }}</td>
                                <td class="text-end fw-semibold">Rp {{ number_format($nominal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">Belum ada data transaksi pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
