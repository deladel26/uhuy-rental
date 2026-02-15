@extends('layouts.ini')

@section('title', 'Tambah Motor')

@section('content')
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('motors.index') }}" class="btn-back me-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="page-title mb-1">Tambah Motor Baru</h2>
                <p class="page-subtitle">Lengkapi form untuk menambahkan motor baru</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-card">
                    <form action="{{ route('motors.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <!-- Plat Nomor -->
                            <div class="col-md-6 mb-4">
                                <label for="plat_nomor" class="form-label">
                                    <i class="fas fa-id-card me-2"></i>Plat Nomor
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-input @error('plat_nomor') is-invalid @enderror"
                                    id="plat_nomor" name="plat_nomor" value="{{ old('plat_nomor') }}"
                                    placeholder="Contoh: B 1234 XYZ" required>
                                @error('plat_nomor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Merk -->
                            <div class="col-md-6 mb-4">
                                <label for="merk" class="form-label">
                                    <i class="fas fa-motorcycle me-2"></i>Merk Motor
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-input @error('merk') is-invalid @enderror" id="merk"
                                    name="merk" value="{{ old('merk') }}" placeholder="Contoh: Honda Beat" required>
                                @error('merk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tahun -->
                            <div class="col-md-6 mb-4">
                                <label for="tahun" class="form-label">
                                    <i class="fas fa-calendar me-2"></i>Tahun
                                </label>
                                <input type="number" class="form-input @error('tahun') is-invalid @enderror" id="tahun"
                                    name="tahun" value="{{ old('tahun') }}" placeholder="Contoh: 2023" min="1900"
                                    max="{{ date('Y') + 1 }}">
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Warna -->
                            <div class="col-md-6 mb-4">
                                <label for="warna" class="form-label">
                                    <i class="fas fa-palette me-2"></i>Warna
                                </label>
                                <input type="text" class="form-input @error('warna') is-invalid @enderror" id="warna"
                                    name="warna" value="{{ old('warna') }}" placeholder="Contoh: Merah">
                                @error('warna')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Harga Sewa -->
                            <div class="col-md-6 mb-4">
                                <label for="harga_sewa" class="form-label">
                                    <i class="fas fa-money-bill-wave me-2"></i>Harga Sewa per Hari
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group-custom">
                                    <span class="input-prefix">Rp</span>
                                    <input type="number" class="form-input ps-5 @error('harga_sewa') is-invalid @enderror"
                                        id="harga_sewa" name="harga_sewa" value="{{ old('harga_sewa') }}"
                                        placeholder="50000" min="0" required>
                                </div>
                                @error('harga_sewa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                    <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia
                                    </option>
                                    <option value="disewa" {{ old('status') == 'disewa' ? 'selected' : '' }}>Disewa
                                    </option>
                                    <option value="servis" {{ old('status') == 'servis' ? 'selected' : '' }}>Servis
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kondisi -->
                            <div class="col-12 mb-4">
                                <label for="kondisi" class="form-label">
                                    <i class="fas fa-star me-2"></i>Kondisi
                                </label>
                                <select class="form-select @error('kondisi') is-invalid @enderror" id="kondisi"
                                    name="kondisi">
                                    <option value="">Pilih Kondisi</option>
                                    <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="sedang" {{ old('kondisi') == 'sedang' ? 'selected' : '' }}>Sedang
                                    </option>
                                    <option value="perlu_perbaikan"
                                        {{ old('kondisi') == 'perlu_perbaikan' ? 'selected' : '' }}>Perlu Perbaikan
                                    </option>
                                </select>
                                @error('kondisi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 mt-2">
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save me-2"></i>Simpan Motor
                            </button>
                            <a href="{{ route('motors.index') }}" class="btn-cancel">
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

        .form-input::placeholder {
            color: #94a3b8;
        }

        .input-group-custom {
            position: relative;
        }

        .input-prefix {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-weight: 600;
            z-index: 5;
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
@endsection

