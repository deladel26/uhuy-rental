@extends('layouts.ini')

@section('title', 'Data Sewa')

@section('content')
    <style>
        .ktp-preview-overlay {
            background: rgba(0, 0, 0, 0);
            transition: background-color 0.2s ease;
        }

        .ktp-preview-icon {
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .group:hover .ktp-preview-overlay {
            background: rgba(0, 0, 0, 0.28);
        }

        .group:hover .ktp-preview-icon {
            opacity: 1;
        }
    </style>

    <div class="container mx-auto px-4 py-6">

        {{-- Alert Messages --}}
        @if (session('success'))
            <div class="mb-4 rounded-xl bg-green-50 border border-green-200 p-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-600"></i>
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.parentElement.remove()"
                    class="text-green-600 hover:text-green-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-xl bg-red-50 border border-red-200 p-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-exclamation-circle text-red-600"></i>
                    <span class="text-red-800 font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.parentElement.remove()"
                    class="text-red-600 hover:text-red-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Data Transaksi Sewa</h2>
                <p class="text-gray-500 mt-1">Kelola transaksi penyewaan motor</p>
            </div>
            <a href="{{ route('petugas.sewas.create') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-[#1f2937] 
                text-white font-semibold rounded-xl hover:bg-[#334155] 
                transform hover:-translate-y-0.5 transition-all duration-200 shadow-lg">
                <i class="fas fa-plus"></i>
                <span>Transaksi Baru</span>
            </a>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl bg-[#1f2937] 
                        flex items-center justify-center text-white text-xl">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Transaksi</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $sewas->count() }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl  bg-[#1f2937]
                        flex items-center justify-center text-white text-xl">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Sedang Aktif</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $sewas->whereIn('status', ['aktif', 'disewa'])->count() }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl  bg-[#1f2937] 
                        flex items-center justify-center text-white text-xl">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Selesai</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $sewas->where('status', 'selesai')->count() }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl  bg-[#1f2937]
                        flex items-center justify-center text-white text-xl">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Terlambat</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $sewas->where('status', 'terlambat')->count() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="searchInput"
                            class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl 
                            focus:outline-none focus:ring-2 focus:ring-[#1f2937] focus:border-transparent"
                            placeholder="Cari nama pelanggan atau plat nomor...">
                    </div>
                </div>
                <div>
                    <select id="statusFilter"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl 
                        focus:outline-none focus:ring-2 focus:ring-[#1f2937] focus:border-transparent">
                        <option value="aktif_terlambat" selected>Aktif + Terlambat (Default)</option>
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="selesai">Selesai</option>
                        <option value="terlambat">Terlambat</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Grid Transaksi --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="sewaGrid">
            @forelse($sewas as $sewa)
                @php
                    $dokumenKTP = $sewa->pelanggan
                        ?->dokumenPelanggan()
                        ->where('jenis_dokumen', 'KTP')
                        ->orderByDesc('uploaded_at') // âœ… pakai orderByDesc (bukan sortByDesc)
                        ->first();
                @endphp
                <div class="sewa-item relative bg-white rounded-xl border border-gray-200 overflow-hidden 
                    hover:shadow-xl transition-all duration-200 hover:-translate-y-1"
                    data-status="{{ $sewa->status }}"
                    data-search="{{ strtolower($sewa->pelanggan->nama . ' ' . $sewa->motor->plat_nomor) }}">

                    {{-- Status Badge --}}
                    <div class="absolute top-4 right-4 z-10">
                        @if (in_array($sewa->status, ['aktif', 'disewa']))
                            <span
                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-100 text-amber-800 
                                text-xs font-semibold rounded-full">
                                <i class="fas fa-clock"></i> {{ ucfirst($sewa->status) }}
                            </span>
                        @elseif($sewa->status == 'selesai')
                            <span
                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-100 text-green-800 
                                text-xs font-semibold rounded-full">
                                <i class="fas fa-check-circle"></i> Selesai
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 text-red-800 
                                text-xs font-semibold rounded-full">
                                <i class="fas fa-exclamation-triangle"></i> Terlambat
                            </span>
                        @endif
                    </div>

                    {{-- Header Card --}}
                    <div class="bg-[#1f2937] bg-opacity-10 p-5 border-b border-gray-200">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-14 h-14 bg-white rounded-xl flex items-center justify-center 
                                text-[#1f2937] text-2xl shadow-sm">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-800">{{ $sewa->motor->plat_nomor }}</h4>
                                <p class="text-sm text-gray-500">{{ $sewa->motor->merk }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Info Detail --}}
                    <div class="p-5 space-y-4">
                        {{-- Customer Info --}}
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center text-[#1f2937]">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-500 font-medium">Pelanggan</p>
                                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $sewa->pelanggan->nama }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center text-[#1f2937]">
                                    <i class="fas fa-phone text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 font-medium">No. HP</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $sewa->pelanggan->no_hp }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Foto KTP - FIX --}}
                        @if ($dokumenKTP && $dokumenKTP->file_path)
                            <div class="pt-3 border-t border-gray-100">
                                <div class="flex items-center gap-3 mb-2">
                                    <div
                                        class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center text-[#1f2937]">
                                        <i class="fas fa-id-card text-sm"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-500 font-medium">Foto KTP</p>
                                    </div>
                                </div>
                                <div class="mt-2 relative group cursor-pointer"
                                    onclick="showKTPModal('{{ asset('storage/' . $dokumenKTP->file_path) }}', '{{ $sewa->pelanggan->nama }}')">
                                    <img src="{{ asset('storage/' . $dokumenKTP->file_path) }}"
                                        alt="KTP {{ $sewa->pelanggan->nama }}"
                                        class="w-full h-32 object-cover rounded-lg border-2 border-gray-200 hover:border-[#1f2937] transition-all duration-200">
                                    <div
                                        class="ktp-preview-overlay absolute inset-0 rounded-lg flex items-center justify-center">
                                        <i
                                            class="ktp-preview-icon fas fa-search-plus text-white text-2xl"></i>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Dates --}}
                        <div class="pt-3 border-t border-gray-100 space-y-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center text-[#1f2937]">
                                    <i class="fas fa-calendar-alt text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 font-medium">Tanggal Sewa</p>
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ \Carbon\Carbon::parse($sewa->tanggal_sewa)->format('d M Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center text-[#1f2937]">
                                    <i class="fas fa-calendar-check text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 font-medium">Tanggal Kembali</p>
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ \Carbon\Carbon::parse($sewa->tanggal_kembali_rencana)->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Price --}}
                        @if (isset($sewa->total_harga))
                            <div
                                class="bg-[#1f2937] bg-opacity-10 rounded-xl p-4 
                                flex items-center justify-between">
                                <span class="text-sm text-gray-600 font-medium">Total Harga</span>
                                <span class="text-lg font-bold text-[#1f2937]">
                                    Rp {{ number_format($sewa->total_harga, 0, ',', '.') }}
                                </span>
                            </div>
                        @endif

                        {{-- Actions --}}
                        <div class="flex gap-2 pt-2">
                            <a href="{{ route('petugas.sewas.show', $sewa->id) }}"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 
                                bg-[#1f2937] bg-opacity-10 text-[#1f2937] font-semibold rounded-lg 
                                hover:bg-opacity-20 transition-colors duration-200">
                                <i class="fas fa-eye text-sm"></i>
                                <span>Detail</span>
                            </a>

                            @if (in_array($sewa->status, ['aktif', 'disewa']))
                                <button type="button"
                                    onclick="openFinishModal({{ $sewa->id }}, '{{ $sewa->tanggal_kembali_rencana }}', {{ $sewa->harga_per_hari }})"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 
                                    bg-green-50 text-green-600 font-semibold rounded-lg 
                                    hover:bg-green-100 transition-colors duration-200">
                                    <i class="fas fa-check text-sm"></i>
                                    <span>Selesaikan</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
                        <i class="fas fa-file-invoice text-6xl text-gray-300 mb-4"></i>
                        <h4 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Transaksi</h4>
                        <p class="text-gray-500">Klik tombol "Transaksi Baru" untuk menambahkan transaksi sewa</p>
                    </div>
                </div>
            @endforelse

            @if ($sewas->count() > 0)
                <div id="filteredEmptyState" class="hidden col-span-full">
                    <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                        <h4 class="text-xl font-semibold text-gray-800 mb-2">Belum ada data tersedia</h4>
                    </div>
                </div>
            @endif
        </div>

    </div>

    {{-- Modal Preview KTP --}}
    <div id="ktpModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity" onclick="closeKTPModal()"></div>

        {{-- Modal Container --}}
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-4xl w-full transform transition-all">

                {{-- Header --}}
                <div class="bg-[#1f2937] bg-opacity-10 px-6 py-4 border-b border-gray-200 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h5 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-id-card text-[#1f2937]"></i>
                            <span id="ktpModalTitle">Foto KTP</span>
                        </h5>
                        <button type="button" onclick="closeKTPModal()"
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                {{-- Image Content --}}
                <div class="p-6">
                    <img id="ktpModalImage" src="" alt="KTP" class="w-full h-auto rounded-lg shadow-lg">
                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-2xl flex justify-end gap-3">
                    <button type="button" onclick="closeKTPModal()"
                        class="px-6 py-2.5 bg-gray-200 text-gray-700 font-semibold rounded-xl 
                        hover:bg-gray-300 transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>Tutup
                    </button>
                    <a id="downloadKTP" href="" download
                        class="px-6 py-2.5 bg-[#1f2937] text-white font-semibold rounded-xl 
                        hover:bg-[#334155] transition-colors duration-200">
                        <i class="fas fa-download mr-2"></i>Download
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Selesaikan Sewa --}}
    <div id="finishModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeFinishModal()"></div>

        {{-- Modal Container --}}
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full transform transition-all">

                {{-- Header --}}
                <div class="bg-[#1f2937] bg-opacity-10 px-6 py-5 border-b border-gray-200 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h5 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-check-circle text-[#1f2937]"></i>
                            Selesaikan Transaksi Sewa
                        </h5>
                        <button type="button" onclick="closeFinishModal()"
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                {{-- Form --}}
                <form id="finishForm" method="POST">
                    @csrf
                    <div class="p-6 space-y-4">

                        {{-- Tanggal Kembali Real --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar-day text-[#1f2937] mr-1"></i>
                                Tanggal Kembali Real
                            </label>
                            <input type="date" id="tanggal_kembali_real" name="tanggal_kembali_real" required
                                onchange="calculateDenda()"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl 
                                focus:outline-none focus:ring-2 focus:ring-[#1f2937] focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1.5">
                                Tanggal kembali rencana: <span id="tanggal_rencana_text" class="font-semibold"></span>
                            </p>
                        </div>

                        {{-- Denda Terlambat --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-exclamation-triangle text-amber-600 mr-1"></i>
                                Denda Keterlambatan
                            </label>
                            <input type="number" id="denda_terlambat" name="denda_terlambat" value="0" readonly
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 
                                text-gray-700 font-semibold">
                            <p class="text-xs text-gray-500 mt-1.5">
                                Otomatis terhitung dari keterlambatan (Rp 50.000/hari)
                            </p>
                        </div>

                        {{-- Denda Kerusakan --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-wrench text-red-600 mr-1"></i>
                                Denda Kerusakan Motor
                            </label>
                            <input type="number" id="denda_kerusakan" name="denda_kerusakan" value="0"
                                min="0" placeholder="Masukkan nominal jika ada kerusakan"
                                onchange="calculateTotal()"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl 
                                focus:outline-none focus:ring-2 focus:ring-[#1f2937] focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1.5">
                                Kosongkan jika tidak ada kerusakan
                            </p>
                        </div>

                        {{-- Total Denda --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calculator text-[#1f2937] mr-1"></i>
                                Total Denda
                            </label>
                            <div
                                class="bg-[#1f2937] bg-opacity-10 border border-[#1f2937] border-opacity-30 rounded-xl p-4">
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
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl 
                                focus:outline-none focus:ring-2 focus:ring-[#1f2937] focus:border-transparent">
                                <option value="">Pilih Status</option>
                                <option value="lunas">Lunas</option>
                                <option value="belum">Belum Lunas</option>
                            </select>
                        </div>

                        {{-- Warning --}}
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-3">
                            <i class="fas fa-info-circle text-amber-600 text-lg mt-0.5"></i>
                            <p class="text-sm text-amber-800">
                                Pastikan semua data sudah benar sebelum menyelesaikan transaksi.
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
                            <i class="fas fa-check mr-2"></i>Selesaikan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentSewaId = null;
        let tanggalRencana = null;
        let hargaPerHari = 0;
        const DENDA_PER_HARI = 50000;

        // KTP Modal Functions
        function showKTPModal(imageUrl, namaPelanggan) {
            document.getElementById('ktpModalImage').src = imageUrl;
            document.getElementById('ktpModalTitle').textContent = `Foto KTP - ${namaPelanggan}`;
            document.getElementById('downloadKTP').href = imageUrl;
            document.getElementById('ktpModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeKTPModal() {
            document.getElementById('ktpModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function openFinishModal(sewaId, tanggalKembaliRencana, hargaSewa) {
            currentSewaId = sewaId;
            tanggalRencana = tanggalKembaliRencana;
            hargaPerHari = hargaSewa;

            // Set form action
            document.getElementById('finishForm').action = `/petugas/sewas/${sewaId}/finish`;

            // Set tanggal rencana text
            const tanggalRencanaFormatted = new Date(tanggalKembaliRencana).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            document.getElementById('tanggal_rencana_text').textContent = tanggalRencanaFormatted;

            // Set tanggal kembali real to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal_kembali_real').value = today;

            // Reset form
            document.getElementById('denda_kerusakan').value = 0;
            document.getElementById('status_pembayaran').value = '';

            // Calculate initial denda
            calculateDenda();

            // Show modal
            document.getElementById('finishModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeFinishModal() {
            document.getElementById('finishModal').classList.add('hidden');
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

        // Filter functions
        document.getElementById('searchInput').addEventListener('keyup', filterSewa);
        document.getElementById('statusFilter').addEventListener('change', filterSewa);

        function filterSewa() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const statusValue = document.getElementById('statusFilter').value;
            const items = document.querySelectorAll('.sewa-item');
            const filteredEmptyState = document.getElementById('filteredEmptyState');
            let visibleCount = 0;

            items.forEach(item => {
                const searchText = item.getAttribute('data-search');
                const status = item.getAttribute('data-status');

                const matchSearch = searchText.includes(searchValue);
                let matchStatus = !statusValue || status === statusValue;

                if (statusValue === 'aktif') {
                    matchStatus = status === 'aktif' || status === 'disewa';
                }
                if (statusValue === 'aktif_terlambat') {
                    matchStatus = status === 'aktif' || status === 'disewa' || status === 'terlambat';
                }

                if (matchSearch && matchStatus) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (filteredEmptyState) {
                filteredEmptyState.classList.toggle('hidden', visibleCount > 0);
            }
        }
        filterSewa();

        // Close modal on ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeFinishModal();
                closeKTPModal();
            }
        });
    </script>
@endsection

