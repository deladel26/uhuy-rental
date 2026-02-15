@extends('layouts.ini')

@section('title', 'Edit Petugas')

@section('content')
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div class="d-flex align-items-center">
                <a href="{{ route('admin.petugas.index') }}" class="btn-back me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="page-title mb-1">Edit Petugas</h2>
                    <p class="page-subtitle mb-0">Perbarui data akun {{ $petugas->name }}.</p>
                </div>
            </div>
            <span class="chip-info"><i class="fas fa-user-gear me-2"></i>ID #{{ $petugas->id }}</span>
        </div>

        <div class="row g-3">
            <div class="col-12 col-xl-4">
                <div class="info-card h-100">
                    <h6 class="fw-bold">Catatan Edit</h6>
                    <ul class="small text-secondary ps-3 mb-0">
                        <li>Password boleh dikosongkan jika tidak diganti.</li>
                        <li>Perubahan status langsung mempengaruhi akses login.</li>
                        <li>Pastikan email dan username tetap unik.</li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-xl-8">
                <div class="form-card">
                    <form method="POST" action="{{ route('admin.petugas.update', $petugas->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $petugas->name) }}"
                                    class="form-control modern-input @error('name') is-invalid @enderror" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" value="{{ old('username', $petugas->username) }}"
                                    class="form-control modern-input @error('username') is-invalid @enderror" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $petugas->email) }}"
                                    class="form-control modern-input @error('email') is-invalid @enderror" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select modern-input @error('status') is-invalid @enderror"
                                    required>
                                    <option value="aktif" {{ old('status', $petugas->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="non-aktif" {{ old('status', $petugas->status) === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Password Baru (opsional)</label>
                                <input type="password" name="password"
                                    class="form-control modern-input @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control modern-input">
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4 flex-wrap">
                            <button type="submit" class="btn-modern btn-modern-dark px-4">Update</button>
                            <a href="{{ route('admin.petugas.index') }}" class="btn-modern btn-modern-muted px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .page-title {
            color: #0f172a;
            font-size: 1.6rem;
            font-weight: 700;
        }

        .page-subtitle {
            color: #64748b;
            font-size: .9rem;
        }

        .chip-info {
            background: #e2e8f0;
            border-radius: 999px;
            color: #334155;
            padding: .45rem .85rem;
            font-size: .8rem;
            font-weight: 600;
        }

        .btn-back {
            width: 42px;
            height: 42px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            text-decoration: none;
            background: #fff;
        }

        .btn-back:hover {
            background: #0f172a;
            color: #fff;
            border-color: #0f172a;
        }

        .info-card {
            background: linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%);
            border: 1px solid #dbe4ef;
            border-radius: 16px;
            padding: 1.2rem;
        }

        .form-card {
            background: #fff;
            border: 1px solid #dbe4ef;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
        }

        .modern-input {
            border-radius: 11px;
            border-color: #cbd5e1;
            min-height: 44px;
        }

        .modern-input:focus {
            border-color: #0f172a;
            box-shadow: 0 0 0 .2rem rgba(15, 23, 42, 0.1);
        }

        .btn-modern {
            min-height: 44px;
            border-radius: 11px;
            border: 0;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-modern-dark {
            background: linear-gradient(135deg, #0f172a, #374151);
            color: #fff;
        }

        .btn-modern-dark:hover {
            color: #fff;
            opacity: .95;
        }

        .btn-modern-muted {
            background: #e2e8f0;
            color: #334155;
        }

        .btn-modern-muted:hover {
            color: #111827;
            background: #cbd5e1;
        }
    </style>
@endsection
