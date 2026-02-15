@extends('layouts.ini')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Flatpickr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/confirmDate/confirmDate.css">

    <style>
        .modern-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .modern-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .card-header-modern {
            background: linear-gradient(135deg, #1f2937 0%, #334155 100%);
            color: white;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            border: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-header-modern i {
            font-size: 1.3rem;
        }

        .form-label-modern {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-control-modern,
        .form-select-modern {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control-modern:focus,
        .form-select-modern:focus {
            border-color: #1f2937;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1);
            outline: none;
        }

        .total-price-box {
            background: linear-gradient(135deg, #1f2937 0%, #334155 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.3);
        }

        .total-price-label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }

        .total-price-value {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .info-box {
            background: linear-gradient(135deg, #1f2937 0%, #334155 100%);
            color: white;
            padding: 1rem 1.25rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .info-box i {
            font-size: 1.5rem;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, #1f2937 0%, #334155 100%);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.4);
            color: white;
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.4);
            background: linear-gradient(135deg, #334155 0%, #475569 100%);
        }

        .btn-primary-modern:disabled {
            background: #d1d5db;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-secondary-modern {
            background: white;
            border: 2px solid #e5e7eb;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            color: #6b7280;
            transition: all 0.3s ease;
        }

        .btn-secondary-modern:hover {
            background: #f9fafb;
            border-color: #d1d5db;
            transform: translateY(-2px);
        }

        .page-header {
            background: linear-gradient(135deg, #1f2937 0%, #334155 100%);
            color: white;
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.3);
        }

        .page-header h4 {
            margin: 0;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .file-upload-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-upload-input {
            position: absolute;
            font-size: 100px;
            opacity: 0;
            right: 0;
            top: 0;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem;
            background: #f9fafb;
            border: 2px dashed #d1d5db;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #6b7280;
            font-weight: 500;
        }

        .file-upload-label:hover {
            background: #f3f4f6;
            border-color: #1f2937;
            color: #1f2937;
        }

        /* Availability Alert Styles */
        .availability-alert {
            margin-top: 1rem;
            padding: 1rem 1.25rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideDown 0.3s ease;
        }

        .availability-alert-success {
            background: #ecfdf5;
            border: 2px solid #10b981;
        }

        .availability-alert-error {
            background: #fef2f2;
            border: 2px solid #ef4444;
        }

        .availability-alert i {
            font-size: 1.5rem;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Flatpickr Custom Styles */
        .flatpickr-calendar {
            border-radius: 12px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
            border: none !important;
        }

        .flatpickr-day.selected {
            background: #1f2937 !important;
            border-color: #1f2937 !important;
        }

        .flatpickr-day.selected:hover {
            background: #334155 !important;
            border-color: #334155 !important;
        }

        .flatpickr-day:hover {
            background: #f3f4f6 !important;
            border-color: #1f2937 !important;
        }

        .flatpickr-day.today {
            border-color: #1f2937 !important;
        }

        .flatpickr-day.disabled {
            color: #e5e7eb !important;
            background: #f9fafb !important;
            cursor: not-allowed !important;
        }

        .flatpickr-months .flatpickr-month {
            background: #1f2937 !important;
            color: white !important;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months {
            background: #1f2937 !important;
        }

        .flatpickr-weekdays {
            background: #f9fafb !important;
        }

        .loading-indicator {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid #f3f4f6;
            border-radius: 50%;
            border-top-color: #1f2937;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 1.5rem;
            }

            .total-price-value {
                font-size: 1.5rem;
            }

            .card-header-modern {
                font-size: 1rem;
            }
        }
    </style>

    <div class="container py-4">
        <!-- Page Header -->
        <div class="page-header">
            <h4>
                <i class="bi bi-plus-circle-fill"></i>
                Tambah Transaksi Sewa Motor
            </h4>
            <p class="mb-0 mt-2" style="opacity: 0.9;">Lengkapi formulir di bawah untuk membuat transaksi sewa baru</p>
        </div>

        <form action="{{ route('petugas.sewas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ================= DATA PELANGGAN ================= --}}
            <div class="modern-card mb-4">
                <div class="card-header-modern">
                    <i class="bi bi-person-fill"></i>
                    <span>Data Pelanggan</span>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="form-label-modern">Jenis Pelanggan *</label>
                        <select id="jenis_pelanggan" name="jenis_pelanggan"
                            class="form-select form-select-modern @error('jenis_pelanggan') is-invalid @enderror" required>
                            <option value="baru" {{ old('jenis_pelanggan', 'baru') == 'baru' ? 'selected' : '' }}>
                                Pelanggan Baru
                            </option>
                            <option value="lama" {{ old('jenis_pelanggan') == 'lama' ? 'selected' : '' }}>
                                Pelanggan Lama
                            </option>
                        </select>
                        @error('jenis_pelanggan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4" id="pelanggan-lama-wrapper" style="display: none;">
                        <label class="form-label-modern">Pilih Pelanggan Lama *</label>
                        <select id="pelanggan_id" name="pelanggan_id"
                            class="form-select form-select-modern @error('pelanggan_id') is-invalid @enderror">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach ($pelanggans as $pelanggan)
                                <option value="{{ $pelanggan->id }}" data-nama="{{ $pelanggan->nama }}"
                                    data-ktp="{{ $pelanggan->no_ktp }}" data-hp="{{ $pelanggan->no_hp }}"
                                    data-alamat="{{ $pelanggan->alamat }}"
                                    {{ old('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
                                    {{ $pelanggan->nama }} - {{ $pelanggan->no_ktp }}
                                </option>
                            @endforeach
                        </select>
                        @error('pelanggan_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="pelanggan-baru-wrapper">
                        <div class="mb-4">
                            <label class="form-label-modern">Nama Pelanggan *</label>
                            <input type="text" name="nama_pelanggan"
                                class="form-control form-control-modern @error('nama_pelanggan') is-invalid @enderror"
                                placeholder="Masukkan nama lengkap pelanggan" value="{{ old('nama_pelanggan') }}" required>
                            @error('nama_pelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label-modern">No KTP *</label>
                            <input type="text" name="no_ktp"
                                class="form-control form-control-modern @error('no_ktp') is-invalid @enderror"
                                placeholder="Masukkan 16 digit nomor KTP" maxlength="16" value="{{ old('no_ktp') }}"
                                required>
                            @error('no_ktp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Contoh: 5171234567890001</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-modern">No HP *</label>
                            <input type="text" name="no_hp"
                                class="form-control form-control-modern @error('no_hp') is-invalid @enderror"
                                placeholder="contoh: 081234567890" value="{{ old('no_hp') }}" required>
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label-modern">Alamat *</label>
                            <textarea name="alamat" class="form-control form-control-modern @error('alamat') is-invalid @enderror" rows="3"
                                placeholder="Masukkan alamat lengkap pelanggan" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label class="form-label-modern">Foto KTP (Opsional)</label>
                            <div class="file-upload-wrapper">
                                <input type="file" name="foto_ktp" id="foto_ktp"
                                    class="file-upload-input form-control-modern @error('foto_ktp') is-invalid @enderror"
                                    accept="image/*">
                                <label for="foto_ktp" class="file-upload-label">
                                    <i class="bi bi-cloud-upload-fill"></i>
                                    <span id="file-name">Pilih file atau seret ke sini</span>
                                </label>
                            </div>
                            @error('foto_ktp')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= DATA MOTOR ================= --}}
            <div class="modern-card mb-4">
                <div class="card-header-modern">
                    <i class="bi bi-scooter"></i>
                    <span>Data Motor</span>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="form-label-modern">
                            Pilih Motor *
                            <span id="motor-loading" class="loading-indicator ms-2" style="display: none;"></span>
                        </label>
                        <select id="motor_id" name="motor_id"
                            class="form-select form-select-modern @error('motor_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Motor yang Tersedia --</option>
                            @foreach ($motors as $motor)
                                <option value="{{ $motor->id }}" data-harga="{{ $motor->harga_sewa }}"
                                    data-merk="{{ $motor->merk }}"
                                    {{ old('motor_id') == $motor->id ? 'selected' : '' }}>
                                    {{ $motor->plat_nomor }} - {{ $motor->merk }}
                                    (Rp {{ number_format($motor->harga_sewa, 0, ',', '.') }}/hari)
                                </option>
                            @endforeach
                        </select>
                        @error('motor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted mt-2 d-block">
                            <i class="bi bi-info-circle"></i>
                            Tanggal yang sudah disewa akan diblokir otomatis di kalender
                        </small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-cash-coin"></i>
                                <div>
                                    <div style="font-size: 0.85rem; opacity: 0.9;">Harga Sewa / Hari</div>
                                    <div style="font-size: 1.25rem; font-weight: 700;" id="harga_motor">Rp 0</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= DETAIL SEWA ================= --}}
            <div class="modern-card mb-4">
                <div class="card-header-modern">
                    <i class="bi bi-calendar-check-fill"></i>
                    <span>Detail Sewa</span>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label-modern">Tanggal Sewa *</label>
                            <input type="text" id="tanggal_sewa" name="tanggal_sewa"
                                class="form-control form-control-modern @error('tanggal_sewa') is-invalid @enderror"
                                placeholder="Pilih tanggal sewa" value="{{ old('tanggal_sewa') }}" required readonly>
                            @error('tanggal_sewa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label-modern">Tanggal Kembali *</label>
                            <input type="text" id="tanggal_kembali_rencana" name="tanggal_kembali_rencana"
                                class="form-control form-control-modern @error('tanggal_kembali_rencana') is-invalid @enderror"
                                placeholder="Pilih tanggal kembali" value="{{ old('tanggal_kembali_rencana') }}" required
                                readonly>
                            @error('tanggal_kembali_rencana')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-modern">Lama Sewa</label>
                            <input type="text" id="lama_sewa" class="form-control form-control-modern" readonly
                                value="0 Hari" style="background: #f9fafb; font-weight: 600;">
                        </div>
                    </div>

                    {{-- Container untuk availability alert --}}
                    <div id="availability-container"></div>

                    <div class="row mb-4">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label-modern">Status Pembayaran *</label>
                            <select name="status_pembayaran"
                                class="form-select form-select-modern @error('status_pembayaran') is-invalid @enderror"
                                required>
                                <option value="belum" {{ old('status_pembayaran') == 'belum' ? 'selected' : '' }}>Belum
                                    Lunas</option>
                                <option value="lunas" {{ old('status_pembayaran') == 'lunas' ? 'selected' : '' }}>Lunas
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-8">
                            <label class="form-label-modern">Total Harga</label>
                            <div class="total-price-box">
                                <div class="total-price-label">Total yang harus dibayar</div>
                                <div class="total-price-value" id="total_harga_display">Rp 0</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label-modern">Catatan (Opsional)</label>
                        <textarea name="catatan" class="form-control form-control-modern" rows="3"
                            placeholder="Tambahkan catatan jika diperlukan">{{ old('catatan') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ================= BUTTON ================= --}}
            <div class="d-flex gap-3 flex-wrap">
                <button type="submit" class="btn btn-primary-modern" id="submit-button">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Simpan Transaksi
                </button>
                <a href="{{ route('petugas.sewas.index') }}" class="btn btn-secondary-modern">
                    <i class="bi bi-x-circle me-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>

    {{-- Flatpickr JS --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

    {{-- ================= SCRIPT INTEGRATED WITH FLATPICKR ================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const motorSelect = document.getElementById('motor_id');
            const hargaInput = document.getElementById('harga_motor');
            const fileInput = document.getElementById('foto_ktp');
            const fileName = document.getElementById('file-name');
            const submitButton = document.getElementById('submit-button');
            const availabilityContainer = document.getElementById('availability-container');
            const lamaSewaInput = document.getElementById('lama_sewa');
            const totalDisplay = document.getElementById('total_harga_display');
            const motorLoading = document.getElementById('motor-loading');
            const jenisPelanggan = document.getElementById('jenis_pelanggan');
            const pelangganLamaWrapper = document.getElementById('pelanggan-lama-wrapper');
            const pelangganBaruWrapper = document.getElementById('pelanggan-baru-wrapper');
            const pelangganSelect = document.getElementById('pelanggan_id');

            let availabilityAlert = null;
            let flatpickrSewa = null;
            let flatpickrKembali = null;
            let blockedDates = [];

            function setRequired(container, isRequired) {
                if (!container) return;

                const fields = container.querySelectorAll('input, textarea, select');
                fields.forEach((field) => {
                    if (isRequired) {
                        field.setAttribute('required', 'required');
                    } else {
                        field.removeAttribute('required');
                    }
                });
            }

            function fillPelangganBaruFromSelect() {
                if (!pelangganSelect) return;

                const selectedOption = pelangganSelect.options[pelangganSelect.selectedIndex];
                if (!selectedOption || !selectedOption.value) return;

                const nama = document.querySelector('input[name="nama_pelanggan"]');
                const ktp = document.querySelector('input[name="no_ktp"]');
                const hp = document.querySelector('input[name="no_hp"]');
                const alamat = document.querySelector('textarea[name="alamat"]');

                if (nama) nama.value = selectedOption.getAttribute('data-nama') || '';
                if (ktp) ktp.value = selectedOption.getAttribute('data-ktp') || '';
                if (hp) hp.value = selectedOption.getAttribute('data-hp') || '';
                if (alamat) alamat.value = selectedOption.getAttribute('data-alamat') || '';
            }

            function toggleJenisPelanggan() {
                const isPelangganLama = jenisPelanggan?.value === 'lama';

                if (pelangganLamaWrapper) {
                    pelangganLamaWrapper.style.display = isPelangganLama ? 'block' : 'none';
                }

                if (pelangganBaruWrapper) {
                    pelangganBaruWrapper.style.display = isPelangganLama ? 'none' : 'block';
                }

                setRequired(pelangganLamaWrapper, isPelangganLama);
                setRequired(pelangganBaruWrapper, !isPelangganLama);

                if (isPelangganLama) {
                    fillPelangganBaruFromSelect();
                } else if (pelangganSelect) {
                    pelangganSelect.value = '';
                }
            }

            // ========== FILE UPLOAD HANDLER ==========
            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        fileName.textContent = this.files[0].name;
                    } else {
                        fileName.textContent = 'Pilih file atau seret ke sini';
                    }
                });
            }

            // ========== INITIALIZE FLATPICKR ==========
            function initFlatpickr() {
                // Flatpickr untuk Tanggal Sewa
                flatpickrSewa = flatpickr("#tanggal_sewa", {
                    locale: "id",
                    dateFormat: "Y-m-d",
                    minDate: "today",
                    disable: blockedDates,
                    onChange: function(selectedDates, dateStr, instance) {
                        // Reset tanggal kembali jika tanggal sewa berubah
                        if (flatpickrKembali) {
                            flatpickrKembali.clear();
                            flatpickrKembali.set('minDate', dateStr);
                            flatpickrKembali.set('disable', getBlockedDatesForReturn(dateStr));
                        }
                        hitungTotal();
                    }
                });

                // Flatpickr untuk Tanggal Kembali
                flatpickrKembali = flatpickr("#tanggal_kembali_rencana", {
                    locale: "id",
                    dateFormat: "Y-m-d",
                    minDate: "today",
                    disable: [],
                    onChange: function(selectedDates, dateStr, instance) {
                        hitungTotal();
                        checkAvailability();
                    }
                });
            }

            // ========== GET BLOCKED DATES FROM SERVER ==========
            async function loadBlockedDates(motorId) {
                if (!motorId) {
                    blockedDates = [];
                    if (flatpickrSewa) {
                        flatpickrSewa.set('disable', []);
                    }
                    return;
                }

                try {
                    motorLoading.style.display = 'inline-block';

                    const response = await fetch(`/petugas/sewas/blocked-dates/${motorId}`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        blockedDates = data.blocked_dates;

                        // Update flatpickr dengan tanggal yang diblokir
                        if (flatpickrSewa) {
                            flatpickrSewa.set('disable', blockedDates);
                            flatpickrSewa.clear();
                        }

                        if (flatpickrKembali) {
                            flatpickrKembali.set('disable', []);
                            flatpickrKembali.clear();
                        }

                        // Show info jika ada tanggal yang diblokir
                        if (blockedDates.length > 0) {
                            showInfo(
                                `${blockedDates.length} periode tanggal sudah disewa dan diblokir di kalender`
                            );
                        }
                    }

                } catch (error) {
                    console.error('Error loading blocked dates:', error);
                } finally {
                    motorLoading.style.display = 'none';
                }
            }

            // ========== GET BLOCKED DATES FOR RETURN DATE ==========
            function getBlockedDatesForReturn(startDate) {
                // Filter hanya tanggal yang berada setelah start date
                return blockedDates.filter(range => {
                    if (typeof range === 'object' && range.from) {
                        return new Date(range.from) > new Date(startDate);
                    }
                    return new Date(range) > new Date(startDate);
                });
            }

            // ========== AVAILABILITY CHECKING ==========
            async function checkAvailability() {
                const motorId = motorSelect?.value;
                const tanggalSewaValue = document.getElementById('tanggal_sewa')?.value;
                const tanggalKembaliValue = document.getElementById('tanggal_kembali_rencana')?.value;

                // Validasi input
                if (!motorId || !tanggalSewaValue || !tanggalKembaliValue) {
                    removeAvailabilityAlert();
                    return;
                }

                try {
                    // Disable submit button sementara
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.innerHTML =
                            '<i class="bi bi-hourglass-split me-2"></i>Mengecek ketersediaan...';
                    }

                    // Call API
                    const response = await fetch('{{ route('petugas.sewas.check-availability') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            motor_id: motorId,
                            tanggal_sewa: tanggalSewaValue,
                            tanggal_kembali_rencana: tanggalKembaliValue
                        })
                    });

                    const data = await response.json();

                    // Tampilkan hasil
                    showAvailabilityAlert(data.available, data.message);

                    // Enable/disable submit button
                    if (submitButton) {
                        submitButton.disabled = !data.available;
                        if (data.available) {
                            submitButton.innerHTML =
                                '<i class="bi bi-check-circle-fill me-2"></i>Simpan Transaksi';
                        } else {
                            submitButton.innerHTML =
                                '<i class="bi bi-x-circle-fill me-2"></i>Motor Tidak Tersedia';
                        }
                    }

                } catch (error) {
                    console.error('Error checking availability:', error);
                    showAvailabilityAlert(false, 'Gagal mengecek ketersediaan motor. Silakan coba lagi.');

                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>Simpan Transaksi';
                    }
                }
            }

            // ========== SHOW AVAILABILITY ALERT ==========
            function showAvailabilityAlert(isAvailable, message) {
                removeAvailabilityAlert();

                availabilityAlert = document.createElement('div');
                availabilityAlert.className = `availability-alert ${
                    isAvailable ? 'availability-alert-success' : 'availability-alert-error'
                }`;

                availabilityAlert.innerHTML = `
                    <i class="bi ${isAvailable ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'}" 
                       style="color: ${isAvailable ? '#10b981' : '#ef4444'}"></i>
                    <div class="flex-1">
                        <p class="mb-0 fw-semibold" style="color: ${isAvailable ? '#065f46' : '#991b1b'}">
                            ${message}
                        </p>
                        ${!isAvailable ? '<p class="mb-0 mt-1 small" style="color: #991b1b">Silakan pilih motor lain atau ubah tanggal sewa</p>' : ''}
                    </div>
                `;

                availabilityContainer.appendChild(availabilityAlert);
            }

            // ========== SHOW INFO ==========
            function showInfo(message) {
                const info = document.createElement('div');
                info.className = 'alert alert-info mt-2';
                info.innerHTML = `<i class="bi bi-info-circle me-2"></i>${message}`;
                info.style.fontSize = '0.85rem';

                const motorContainer = motorSelect.parentElement;
                const existingInfo = motorContainer.querySelector('.alert-info');
                if (existingInfo) {
                    existingInfo.remove();
                }
                motorContainer.appendChild(info);

                // Auto remove after 5 seconds
                setTimeout(() => info.remove(), 5000);
            }

            // ========== REMOVE AVAILABILITY ALERT ==========
            function removeAvailabilityAlert() {
                if (availabilityAlert) {
                    availabilityAlert.remove();
                    availabilityAlert = null;
                }
            }

            // ========== HITUNG TOTAL HARGA ==========
            function hitungTotal() {
                const selectedOption = motorSelect.options[motorSelect.selectedIndex];
                const hargaPerHari = parseInt(selectedOption?.getAttribute('data-harga')) || 0;

                // Update harga motor display
                if (hargaPerHari > 0) {
                    hargaInput.textContent = 'Rp ' + hargaPerHari.toLocaleString('id-ID');
                } else {
                    hargaInput.textContent = 'Rp 0';
                }

                const tanggalSewaValue = document.getElementById('tanggal_sewa')?.value;
                const tanggalKembaliValue = document.getElementById('tanggal_kembali_rencana')?.value;

                if (!tanggalSewaValue || !tanggalKembaliValue) {
                    lamaSewaInput.value = '0 Hari';
                    totalDisplay.textContent = 'Rp 0';
                    return;
                }

                const tglSewa = new Date(tanggalSewaValue);
                const tglKembali = new Date(tanggalKembaliValue);

                let diffTime = tglKembali - tglSewa;
                let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                if (diffDays < 1) diffDays = 1;

                const total = diffDays * hargaPerHari;

                lamaSewaInput.value = diffDays + ' Hari';
                totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
            }

            // ========== EVENT LISTENERS ==========
            motorSelect.addEventListener('change', function() {
                hitungTotal();
                loadBlockedDates(this.value);
            });

            if (jenisPelanggan) {
                jenisPelanggan.addEventListener('change', toggleJenisPelanggan);
            }

            if (pelangganSelect) {
                pelangganSelect.addEventListener('change', fillPelangganBaruFromSelect);
            }

            // ========== INITIALIZE ==========
            initFlatpickr();
            toggleJenisPelanggan();
            fillPelangganBaruFromSelect();
        });
    </script>
@endsection

