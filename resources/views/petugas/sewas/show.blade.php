@extends('layouts.ini')

@section('title', 'Detail Transaksi Sewa')

@section('content')
    <div class="container mx-auto px-4 py-6">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('petugas.sewas.index') }}"
                        class="w-10 h-10 rounded-xl bg-gray-100 hover:bg-gray-200 
                        flex items-center justify-center transition-colors duration-200">
                        <i class="fas fa-arrow-left text-gray-600"></i>
                    </a>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Detail Transaksi Sewa</h2>
                        <p class="text-gray-500 mt-1">ID Transaksi: #{{ $sewa->id }}</p>
                    </div>
                </div>
            </div>

            {{-- Status Badges --}}
            <div class="flex flex-wrap gap-3">
                @if ($sewa->status == 'aktif')
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 bg-amber-100 text-amber-800 
                        text-sm font-semibold rounded-xl">
                        <i class="fas fa-clock"></i> Sedang Disewa
                    </span>
                @elseif($sewa->status == 'selesai')
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-800 
                        text-sm font-semibold rounded-xl">
                        <i class="fas fa-check-circle"></i> Selesai
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-100 text-red-800 
                        text-sm font-semibold rounded-xl">
                        <i class="fas fa-ban"></i> Dibatalkan
                    </span>
                @endif

                @if ($sewa->status_pembayaran == 'lunas')
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-800 
                        text-sm font-semibold rounded-xl">
                        <i class="fas fa-money-bill-wave"></i> Lunas
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 bg-orange-100 text-orange-800 
                        text-sm font-semibold rounded-xl">
                        <i class="fas fa-exclamation-triangle"></i> Belum Lunas
                    </span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            {{-- Informasi Motor --}}
            <div class="lg:col-span-1">
                <div
                    class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <div class="bg-gradient-to-r from-[#1f2937] to-[#334155] text-white px-5 py-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <i class="fas fa-motorcycle text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold">Informasi Motor</h3>
                    </div>
                    <div class="p-5">
                        @if ($sewa->motor->foto)
                            <div class="mb-4 rounded-xl overflow-hidden">
                                <img src="{{ asset('storage/' . $sewa->motor->foto) }}" alt="{{ $sewa->motor->nama }}"
                                    class="w-full h-48 object-cover">
                            </div>
                        @endif

                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500">Nama Motor</span>
                                <span class="font-semibold text-gray-800">{{ $sewa->motor->nama }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500">Plat Nomor</span>
                                <span
                                    class="font-semibold text-[#1f2937] bg-[#1f2937] bg-opacity-10 px-3 py-1 rounded-lg">{{ $sewa->motor->plat_nomor }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500">Merk</span>
                                <span class="font-medium text-gray-700">{{ $sewa->motor->merk }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500">Tahun</span>
                                <span class="font-medium text-gray-700">{{ $sewa->motor->tahun }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                <span class="text-sm text-gray-500">Warna</span>
                                <span class="font-medium text-gray-700">{{ $sewa->motor->warna }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-sm text-gray-500">Harga/Hari</span>
                                <span class="text-lg font-bold text-[#1f2937]">Rp
                                    {{ number_format($sewa->harga_per_hari, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informasi Pelanggan & Waktu --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Informasi Pelanggan --}}
                <div
                    class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <div class="bg-gradient-to-r from-[#1f2937] to-[#334155] text-white px-5 py-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold">Informasi Pelanggan</h3>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-gray-500 font-medium uppercase tracking-wider">Nama
                                    Lengkap</label>
                                <p class="text-gray-800 font-semibold mt-1">{{ $sewa->pelanggan->nama }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 font-medium uppercase tracking-wider">No. KTP</label>
                                <p class="text-gray-800 font-semibold mt-1">{{ $sewa->pelanggan->no_ktp }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 font-medium uppercase tracking-wider">No. HP</label>
                                <a href="tel:{{ $sewa->pelanggan->no_hp }}"
                                    class="text-[#1f2937] hover:text-[#334155] font-semibold mt-1 inline-flex items-center gap-2">
                                    <i class="fas fa-phone"></i>
                                    {{ $sewa->pelanggan->no_hp }}
                                </a>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 font-medium uppercase tracking-wider">Alamat</label>
                                <p class="text-gray-800 mt-1">{{ $sewa->pelanggan->alamat }}</p>
                            </div>
                        </div>

                        @if ($sewa->dokumenPelanggan && $sewa->dokumenPelanggan->count() > 0)
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <label class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-2 block">Dokumen
                                    Identitas</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($sewa->dokumenPelanggan as $dokumen)
                                        <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 
                                            text-gray-700 rounded-lg transition-colors duration-200">
                                            <i class="fas fa-file-image text-[#1f2937]"></i>
                                            <span class="font-medium">{{ $dokumen->jenis_dokumen }}</span>
                                            <i class="fas fa-external-link-alt text-xs"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Informasi Waktu Sewa --}}
                <div
                    class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <div class="bg-gradient-to-r from-[#1f2937] to-[#334155] text-white px-5 py-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold">Informasi Waktu Sewa</h3>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <label class="text-xs text-gray-500 font-medium uppercase tracking-wider">Tanggal
                                    Sewa</label>
                                <p class="text-gray-800 font-semibold mt-1">
                                    <i class="fas fa-calendar text-[#1f2937] mr-2"></i>
                                    {{ \Carbon\Carbon::parse($sewa->tanggal_sewa)->format('d F Y') }}
                                </p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <label class="text-xs text-gray-500 font-medium uppercase tracking-wider">Kembali
                                    (Rencana)</label>
                                <p class="text-gray-800 font-semibold mt-1">
                                    <i class="fas fa-calendar-check text-[#1f2937] mr-2"></i>
                                    {{ \Carbon\Carbon::parse($sewa->tanggal_kembali_rencana)->format('d F Y') }}
                                </p>
                            </div>

                            @if ($sewa->tanggal_kembali_real)
                                <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                                    <label class="text-xs text-green-600 font-medium uppercase tracking-wider">Kembali
                                        (Aktual)</label>
                                    <p class="text-green-800 font-semibold mt-1">
                                        <i class="fas fa-calendar-check text-green-600 mr-2"></i>
                                        {{ \Carbon\Carbon::parse($sewa->tanggal_kembali_real)->format('d F Y') }}
                                    </p>
                                </div>

                                @php
                                    $keterlambatan = \Carbon\Carbon::parse($sewa->tanggal_kembali_rencana)->diffInDays(
                                        \Carbon\Carbon::parse($sewa->tanggal_kembali_real),
                                        false,
                                    );
                                @endphp

                                <div
                                    class="rounded-xl p-4 border {{ $keterlambatan > 0 ? 'bg-red-50 border-red-200' : 'bg-green-50 border-green-200' }}">
                                    <label
                                        class="text-xs font-medium uppercase tracking-wider {{ $keterlambatan > 0 ? 'text-red-600' : 'text-green-600' }}">Status
                                        Keterlambatan</label>
                                    @if ($keterlambatan > 0)
                                        <p class="text-red-800 font-bold mt-1">
                                            <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                                            Terlambat {{ $keterlambatan }} Hari
                                        </p>
                                    @elseif($keterlambatan < 0)
                                        <p class="text-green-800 font-bold mt-1">
                                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                            Lebih Awal {{ abs($keterlambatan) }} Hari
                                        </p>
                                    @else
                                        <p class="text-green-800 font-bold mt-1">
                                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                            Tepat Waktu
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div
                            class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center bg-[#1f2937] bg-opacity-10 rounded-xl p-4">
                            <span class="text-gray-700 font-medium">Lama Sewa</span>
                            <span class="text-2xl font-bold text-[#1f2937]">
                                @if ($sewa->tanggal_kembali_real)
                                    {{ \Carbon\Carbon::parse($sewa->tanggal_sewa)->diffInDays(\Carbon\Carbon::parse($sewa->tanggal_kembali_real)) }}
                                @else
                                    {{ \Carbon\Carbon::parse($sewa->tanggal_sewa)->diffInDays(\Carbon\Carbon::parse($sewa->tanggal_kembali_rencana)) }}
                                @endif
                                Hari
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ringkasan Pembayaran --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="lg:col-span-2">
                <div
                    class="bg-gradient-to-br from-[#1f2937] to-[#334155] rounded-xl border border-[#1f2937] 
                    overflow-hidden shadow-lg">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                                <i class="fas fa-money-bill-wave text-white text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white">Ringkasan Pembayaran</h3>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b border-white/20">
                                <span class="text-white text-opacity-90">Harga Sewa per Hari</span>
                                <span class="text-white font-semibold">Rp
                                    {{ number_format($sewa->harga_per_hari, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-white/20">
                                <span class="text-white text-opacity-90">Durasi Sewa</span>
                                <span class="text-white font-semibold">
                                    @if ($sewa->tanggal_kembali_real)
                                        {{ \Carbon\Carbon::parse($sewa->tanggal_sewa)->diffInDays(\Carbon\Carbon::parse($sewa->tanggal_kembali_real)) }}
                                    @else
                                        {{ \Carbon\Carbon::parse($sewa->tanggal_sewa)->diffInDays(\Carbon\Carbon::parse($sewa->tanggal_kembali_rencana)) }}
                                    @endif
                                    Hari
                                </span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-white/20">
                                <span class="text-white text-opacity-90">Subtotal Sewa</span>
                                <span class="text-white font-semibold">Rp
                                    {{ number_format($sewa->total_harga, 0, ',', '.') }}</span>
                            </div>
                            @if ($sewa->denda > 0)
                                <div class="flex justify-between items-center pb-3 border-b border-white/20">
                                    <span class="text-white text-opacity-90">Total Denda</span>
                                    <span class="text-red-200 font-semibold">+ Rp
                                        {{ number_format($sewa->denda, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between items-center pt-2 bg-white bg-opacity-10 rounded-xl p-4 mt-4">
                                <span class="text-xl text-white font-bold">Grand Total</span>
                                <span class="text-3xl text-white font-bold">Rp
                                    {{ number_format($sewa->total_harga + $sewa->denda, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informasi Petugas --}}
            <div class="lg:col-span-1">
                <div
                    class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-200 h-full">
                    <div class="bg-gradient-to-r from-gray-700 to-gray-800 text-white px-5 py-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <i class="fas fa-user-tie text-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold">Info Petugas</h3>
                    </div>
                    <div class="p-5 space-y-4">
                        <div>
                            <label class="text-xs text-gray-500 font-medium uppercase tracking-wider">Nama Petugas</label>
                            <p class="text-gray-800 font-semibold mt-1">{{ $sewa->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 font-medium uppercase tracking-wider">Email</label>
                            <p class="text-gray-600 mt-1 text-sm">{{ $sewa->user->email ?? 'N/A' }}</p>
                        </div>
                        <div class="pt-3 border-t border-gray-100">
                            <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                                <i class="fas fa-clock"></i>
                                <span>Dibuat: {{ $sewa->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <i class="fas fa-sync"></i>
                                <span>Update: {{ $sewa->updated_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        @if ($sewa->status === 'aktif')
            <div class="flex flex-wrap gap-3">
                <button type="button" onclick="openFinishModal()"
                    class="flex-1 md:flex-initial inline-flex items-center justify-center gap-2 px-6 py-3 
                    bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl 
                    hover:from-green-600 hover:to-green-700 transform hover:-translate-y-0.5 
                    transition-all duration-200 shadow-lg shadow-green-500/30">
                    <i class="fas fa-check-circle"></i>
                    <span>Selesaikan Transaksi</span>
                </button>

                <form action="{{ route('petugas.sewas.destroy', $sewa->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin membatalkan transaksi ini? Motor akan kembali tersedia.')"
                    class="flex-1 md:flex-initial">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 
                        bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl 
                        hover:from-red-600 hover:to-red-700 transform hover:-translate-y-0.5 
                        transition-all duration-200 shadow-lg shadow-red-500/30">
                        <i class="fas fa-ban"></i>
                        <span>Batalkan Transaksi</span>
                    </button>
                </form>
            </div>
        @endif
    </div>

    {{-- Modal Selesaikan Transaksi --}}
    @if ($sewa->status === 'aktif')
        <div id="finishModal"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
            <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl">
                <form action="{{ route('petugas.sewas.finish', $sewa->id) }}" method="POST" id="finishForm">
                    @csrf
                    @method('PUT')

                    {{-- Header --}}
                    <div
                        class="bg-gradient-to-r from-[#1f2937] to-[#334155] text-white px-6 py-5 flex items-center justify-between rounded-t-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                                <i class="fas fa-check-circle text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">Selesaikan Transaksi</h3>
                                <p class="text-white text-opacity-90 text-sm">Lengkapi data pengembalian motor</p>
                            </div>
                        </div>
                        <button type="button" onclick="closeFinishModal()"
                            class="w-10 h-10 rounded-xl bg-white/20 hover:bg-white/30 
                            flex items-center justify-center transition-colors duration-200">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    {{-- Body --}}
                    <div class="p-6 space-y-5">
                        {{-- Info Alert --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-3">
                            <i class="fas fa-info-circle text-blue-600 text-lg mt-0.5"></i>
                            <div class="text-sm text-blue-800">
                                <p class="font-semibold mb-1">Informasi Penting:</p>
                                <p>Motor akan dikembalikan ke status "tersedia" dan transaksi akan diselesaikan.</p>
                            </div>
                        </div>

                        {{-- Tanggal Kembali --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar-alt text-[#1f2937] mr-1"></i>
                                Tanggal Kembali (Aktual)
                            </label>
                            <input type="date" id="tanggal_kembali_real" name="tanggal_kembali_real"
                                value="{{ date('Y-m-d') }}" required onchange="calculateDenda()"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl 
                                focus:outline-none focus:ring-2 focus:ring-[#1f2937] focus:border-transparent
                                transition-all duration-200">
                            <p class="mt-2 text-xs text-gray-500 bg-gray-50 rounded-lg p-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Tanggal rencana:
                                <span
                                    class="font-semibold text-gray-700">{{ \Carbon\Carbon::parse($sewa->tanggal_kembali_rencana)->format('d F Y') }}</span>
                            </p>
                        </div>

                        {{-- Denda Section --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-clock text-amber-600 mr-1"></i>
                                    Denda Keterlambatan
                                </label>
                                <input type="number" id="denda_terlambat" name="denda_terlambat" value="0"
                                    readonly min="0"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-50
                                    text-gray-700 font-semibold">
                                <p class="mt-1 text-xs text-gray-500">Otomatis: Rp 50.000/hari</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-wrench text-red-600 mr-1"></i>
                                    Denda Kerusakan
                                </label>
                                <input type="number" id="denda_kerusakan" name="denda_kerusakan" value="0"
                                    min="0" step="1000" oninput="calculateTotal()"
                                    placeholder="Masukkan nominal"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl 
                                    focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                                    transition-all duration-200">
                                <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ada</p>
                            </div>
                        </div>

                        {{-- Total Denda --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calculator text-[#1f2937] mr-1"></i>
                                Total Denda
                            </label>
                            <div
                                class="bg-[#1f2937] bg-opacity-10 border-2 border-[#1f2937] border-opacity-30 rounded-xl p-4">
                                <h5 class="text-2xl font-bold text-[#1f2937]" id="total_denda_display">Rp 0</h5>
                            </div>
                            <input type="hidden" id="total_denda" name="denda">
                        </div>

                        {{-- Status Pembayaran --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-money-bill-wave text-green-600 mr-1"></i>
                                Status Pembayaran
                            </label>
                            <select id="status_pembayaran" name="status_pembayaran" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl 
                                focus:outline-none focus:ring-2 focus:ring-[#1f2937] focus:border-transparent
                                transition-all duration-200">
                                <option value="">Pilih Status Pembayaran</option>
                                <option value="lunas">Lunas</option>
                                <option value="belum">Belum Lunas</option>
                            </select>
                        </div>

                        {{-- Warning --}}
                        <div class="bg-amber-50 border-2 border-amber-200 rounded-xl p-4 flex items-start gap-3">
                            <i class="fas fa-exclamation-triangle text-amber-600 text-lg mt-0.5"></i>
                            <p class="text-sm text-amber-800">
                                <span class="font-semibold">Perhatian!</span> Pastikan semua data sudah benar sebelum
                                menyelesaikan transaksi. Tindakan ini tidak dapat dibatalkan.
                            </p>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-2xl flex gap-3">
                        <button type="button" onclick="closeFinishModal()"
                            class="flex-1 px-4 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl 
                            hover:bg-gray-300 transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 
                            text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 
                            transition-all duration-200 shadow-lg shadow-green-500/30">
                            <i class="fas fa-check mr-2"></i>Selesaikan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            const tanggalRencana = "{{ $sewa->tanggal_kembali_rencana }}";
            const DENDA_PER_HARI = 50000;

            function openFinishModal() {
                document.getElementById('finishModal').classList.remove('hidden');
                document.getElementById('finishModal').classList.add('flex');
                document.body.style.overflow = 'hidden';
                calculateDenda();
            }

            function closeFinishModal() {
                document.getElementById('finishModal').classList.add('hidden');
                document.getElementById('finishModal').classList.remove('flex');
                document.body.style.overflow = 'auto';
            }

            function calculateDenda() {
                const tanggalKembaliReal = document.getElementById('tanggal_kembali_real').value;

                if (!tanggalKembaliReal || !tanggalRencana) {
                    return;
                }

                const dateReal = new Date(tanggalKembaliReal);
                const dateRencana = new Date(tanggalRencana);

                const diffTime = dateReal - dateRencana;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                let dendaTerlambat = 0;
                if (diffDays > 0) {
                    dendaTerlambat = diffDays * DENDA_PER_HARI;
                }

                document.getElementById('denda_terlambat').value = dendaTerlambat;

                calculateTotal();
            }

            function calculateTotal() {
                const dendaTerlambat = parseInt(document.getElementById('denda_terlambat').value) || 0;
                const dendaKerusakan = parseInt(document.getElementById('denda_kerusakan').value) || 0;

                const totalDenda = dendaTerlambat + dendaKerusakan;

                document.getElementById('total_denda').value = totalDenda;
                document.getElementById('total_denda_display').textContent =
                    'Rp ' + totalDenda.toLocaleString('id-ID');
            }

            // Close modal on ESC key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeFinishModal();
                }
            });

            // Auto calculate on load
            document.addEventListener('DOMContentLoaded', function() {
                calculateDenda();
            });
        </script>
    @endif
@endsection

