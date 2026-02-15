@extends('layouts.ini')

@section('title', 'Edit Transaksi Sewa')

@section('content')
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('sewas.index') }}" class="btn-back me-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="page-title mb-1">Edit Transaksi Sewa</h2>
                <p class="page-subtitle">Perbarui data transaksi sewa {{ $sewa->motor->plat_nomor }}</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="form-card">
                    <form action="{{ route('sewas.update', $sewa->id) }}" method="POST" id="sewaForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Section 1: Data Pelanggan -->
                            <div class="col-12 mb-4">
                                <div class="section-header">
                                    <i class="fas fa-user-circle"></i>
                                    <h5>Data Pelanggan</h5>
                                </div>
                            </div>

                            <!-- Pelanggan -->
                            <div class="col-md-6 mb-4">
                                <label for="pelanggan_id" class="form-label">
                                    <i class="fas fa-user me-2"></i>Pilih Pelanggan
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('pelanggan_id') is-invalid @enderror" id="pelanggan_id"
                                    name="pelanggan_id" required>
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach ($pelanggans as $pelanggan)
                                        <option value="{{ $pelanggan->id }}" data-hp="{{ $pelanggan->no_hp }}"
                                            data-alamat="{{ $pelanggan->alamat }}"
                                            {{ old('pelanggan_id', $sewa->pelanggan_id) == $pelanggan->id ? 'selected' : '' }}>
                                            {{ $pelanggan->nama }} - {{ $pelanggan->no_hp }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pelanggan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Info Pelanggan Display -->
                            <div class="col-md-6 mb-4">
                                <div class="info-display" id="pelangganInfo">
                                    <div class="info-item">
                                        <i class="fas fa-phone"></i>
                                        <div>
                                            <p class="info-label">No. HP</p>
                                            <p class="info-value" id="displayHP">{{ $sewa->pelanggan->no_hp }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <div>
                                            <p class="info-label">Alamat</p>
                                            <p class="info-value" id="displayAlamat">{{ $sewa->pelanggan->alamat }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="col-12 mb-4">
                                <hr class="section-divider">
                            </div>

                            <!-- Section 2: Data Motor -->
                            <div class="col-12 mb-4">
                                <div class="section-header">
                                    <i class="fas fa-motorcycle"></i>
                                    <h5>Data Motor</h5>
                                </div>
                            </div>

                            <!-- Motor -->
                            <div class="col-md-6 mb-4">
                                <label for="motor_id" class="form-label">
                                    <i class="fas fa-motorcycle me-2"></i>Pilih Motor
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('motor_id') is-invalid @enderror" id="motor_id"
                                    name="motor_id" required>
                                    <option value="">-- Pilih Motor --</option>
                                    @foreach ($motors as $motor)
                                        <option value="{{ $motor->id }}" data-merk="{{ $motor->merk }}"
                                            data-warna="{{ $motor->warna }}" data-harga="{{ $motor->harga_sewa }}"
                                            {{ old('motor_id', $sewa->motor_id) == $motor->id ? 'selected' : '' }}>
                                            {{ $motor->plat_nomor }} - {{ $motor->merk }} ({{ $motor->warna }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('motor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Info Motor Display -->
                            <div class="col-md-6 mb-4">
                                <div class="info-display" id="motorInfo">
                                    <div class="info-item">
                                        <i class="fas fa-tag"></i>
                                        <div>
                                            <p class="info-label">Merk & Warna</p>
                                            <p class="info-value" id="displayMerkWarna">{{ $sewa->motor->merk }} -
                                                {{ $sewa->motor->warna }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <div>
                                            <p class="info-label">Harga Sewa/Hari</p>
                                            <p class="info-value" id="displayHarga">Rp
                                                {{ number_format($sewa->motor->harga_sewa, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="col-12 mb-4">
                                <hr class="section-divider">
                            </div>

                            <!-- Section 3: Detail Sewa -->
                            <div class="col-12 mb-4">
                                <div class="section-header">
                                    <i class="fas fa-calendar-alt"></i>
                                    <h5>Detail Sewa</h5>
                                </div>
                            </div>

                            <!-- Tanggal Sewa -->
                            <div class="col-md-4 mb-4">
                                <label for="tanggal_sewa" class="form-label">
                                    <i class="fas fa-calendar-alt me-2"></i>Tanggal Sewa
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-input @error('tanggal_sewa') is-invalid @enderror"
                                    id="tanggal_sewa" name="tanggal_sewa"
                                    value="{{ old('tanggal_sewa', $sewa->tanggal_sewa) }}" required>
                                @error('tanggal_sewa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Kembali -->
                            <div class="col-md-4 mb-4">
                                <label for="tanggal_kembali" class="form-label">
                                    <i class="fas fa-calendar-check me-2"></i>Tanggal Kembali
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-input @error('tanggal_kembali') is-invalid @enderror"
                                    id="tanggal_kembali" name="tanggal_kembali"
                                    value="{{ old('tanggal_kembali', $sewa->tanggal_kembali) }}" required>
                                @error('tanggal_kembali')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Lama Sewa (Auto Calculate) -->
                            <div class="col-md-4 mb-4">
                                <label class="form-label">
                                    <i class="fas fa-clock me-2"></i>Lama Sewa
                                </label>
                                <div class="info-box">
                                    <span
                                        id="lamaSewa">{{ \Carbon\Carbon::parse($sewa->tanggal_sewa)->diffInDays(\Carbon\Carbon::parse($sewa->tanggal_kembali)) + 1 }}</span>
                                    Hari
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-4">
                                <label for="status" class="form-label">
                                    <i class="fas fa-info-circle me-2"></i>Status
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="aktif"
                                        {{ old('status', $sewa->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="selesai"
                                        {{ old('status', $sewa->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="terlambat"
                                        {{ old('status', $sewa->status) == 'terlambat' ? 'selected' : '' }}>Terlambat
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Total Harga (Auto Calculate) -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    <i class="fas fa-calculator me-2"></i>Total Harga
                                </label>
                                <div class="total-price-box">
                                    <span class="currency">Rp</span>
                                    <span id="totalHarga">{{ number_format($sewa->total_harga ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <input type="hidden" name="total_harga" id="total_harga_input"
                                    value="{{ $sewa->total_harga ?? 0 }}">
                            </div>

                            <!-- Catatan -->
                            <div class="col-12 mb-4">
                                <label for="catatan" class="form-label">
                                    <i class="fas fa-sticky-note me-2"></i>Catatan (Opsional)
                                </label>
                                <textarea class="form-input @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3"
                                    placeholder="Tambahkan catatan jika diperlukan">{{ old('catatan', $sewa->catatan) }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 mt-3">
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save me-2"></i>Update Transaksi
                            </button>
                            <a href="{{ route('sewas.index') }}" class="btn-cancel">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

    <style>
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .page-subtitle {
            font-size: 0.9rem;
            color: #64748b;
            margin: 0;
        }

        .btn-back {
            width: 44px;
            height: 44px;
            background: white;
            border: 1px solid #e8ecf1;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: #1f2937;
            color: white;
            border-color: #1f2937;
            transform: translateX(-2px);
        }

        .form-card {
            background: white;
            border-radius: 16px;
            padding: 35px;
            border: 1px solid #e8ecf1;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
            border-radius: 10px;
            border: 1px solid #e0e7ff;
        }

        .section-header i {
            font-size: 1.3rem;
            color: #1f2937;
        }

        .section-header h5 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
        }

        .section-divider {
            border: none;
            height: 1px;
            background: #e8ecf1;
            margin: 0;
        }

        .form-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
            display: block;
        }

        .form-label i {
            color: #1f2937;
        }

        .text-danger {
            color: #ef4444;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e8ecf1;
            border-radius: 10px;
            font-size: 0.95rem;
            color: #1e293b;
            background: #f8fafc;
            transition: all 0.3s ease;
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: #1f2937;
            background: white;
            box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.1);
        }

        textarea.form-input {
            resize: vertical;
            font-family: inherit;
        }

        .info-display {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
            border: 1px solid #e0e7ff;
            border-radius: 10px;
            padding: 16px;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-item i {
            width: 36px;
            height: 36px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1f2937;
            font-size: 0.9rem;
        }

        .info-label {
            font-size: 0.75rem;
            color: #64748b;
            margin: 0 0 2px 0;
            font-weight: 500;
        }

        .info-value {
            font-size: 0.9rem;
            color: #1e293b;
            margin: 0;
            font-weight: 600;
        }

        .info-box {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
            border: 1px solid #e0e7ff;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            color: #1f2937;
            text-align: center;
        }

        .total-price-box {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 16px 20px;
            border-radius: 10px;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-align: center;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        }

        .total-price-box .currency {
            font-size: 1rem;
            opacity: 0.9;
        }

        .is-invalid {
            border-color: #ef4444;
        }

        .invalid-feedback {
            display: block;
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 6px;
        }

        .btn-submit {
            flex: 1;
            padding: 14px 24px;
            background: linear-gradient(135deg, #1f2937 0%, #334155 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.35);
        }

        .btn-cancel {
            flex: 1;
            padding: 14px 24px;
            background: #f8fafc;
            border: 1px solid #e8ecf1;
            border-radius: 10px;
            color: #64748b;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #ef4444;
            color: white;
            border-color: #ef4444;
        }

        @media (max-width: 768px) {
            .form-card {
                padding: 25px;
            }
        }
    </style>

    <script>
        // Update Pelanggan Info
        document.getElementById('pelanggan_id').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const hp = selected.getAttribute('data-hp') || '-';
            const alamat = selected.getAttribute('data-alamat') || '-';

            document.getElementById('displayHP').textContent = hp;
            document.getElementById('displayAlamat').textContent = alamat;
        });

        // Update Motor Info
        document.getElementById('motor_id').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const merk = selected.getAttribute('data-merk') || '';
            const warna = selected.getAttribute('data-warna') || '';
            const harga = selected.getAttribute('data-harga') || 0;

            document.getElementById('displayMerkWarna').textContent = merk && warna ? `${merk} - ${warna}` : '-';
            document.getElementById('displayHarga').textContent = harga > 0 ?
                `Rp ${parseInt(harga).toLocaleString('id-ID')}` : '-';

            calculateTotal();
        });

        // Calculate Lama Sewa & Total
        document.getElementById('tanggal_sewa').addEventListener('change', calculateTotal);
        document.getElementById('tanggal_kembali').addEventListener('change', calculateTotal);

        function calculateTotal() {
            const tanggalSewa = new Date(document.getElementById('tanggal_sewa').value);
            const tanggalKembali = new Date(document.getElementById('tanggal_kembali').value);
            const motorSelect = document.getElementById('motor_id');
            const harga = parseInt(motorSelect.options[motorSelect.selectedIndex].getAttribute('data-harga')) || 0;

            if (tanggalSewa && tanggalKembali && tanggalKembali >= tanggalSewa) {
                const diffTime = Math.abs(tanggalKembali - tanggalSewa);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) || 1;

                document.getElementById('lamaSewa').textContent = diffDays;

                if (harga > 0) {
                    const total = diffDays * harga;
                    document.getElementById('totalHarga').textContent = total.toLocaleString('id-ID');
                    document.getElementById('total_harga_input').value = total;
                }
            } else {
                document.getElementById('lamaSewa').textContent = '0';
                document.getElementById('totalHarga').textContent = '0';
                document.getElementById('total_harga_input').value = '0';
            }
        }

        // Trigger calculation on page load
        window.addEventListener('load', calculateTotal);
    </script>
@endsection

