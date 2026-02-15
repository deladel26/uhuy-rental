@extends('layouts.ini')

@section('title', 'Data Pelanggan')

@section('content')
    <div class="container mx-auto px-4 py-6">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Data Pelanggan</h2>
                <p class="text-gray-500 text-sm">Riwayat dan informasi pelanggan</p>
            </div>
        </div>

        {{-- Search --}}
        <form method="GET" class="mb-6">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama, no HP, atau NIK..."
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1f2937]">
            </div>
        </form>

        {{-- Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

            @forelse($pelanggans as $pelanggan)
                @php
                    $totalSewa = $pelanggan->sewas->count();
                    $aktif = $pelanggan->sewas->where('status', 'aktif')->count();
                    $terlambat = $pelanggan->sewas->where('status', 'terlambat')->count();
                    $totalPengeluaran = $pelanggan->sewas->sum('total_harga');

                    $ktp = $pelanggan->dokumenPelanggan
                        ->where('jenis_dokumen', 'KTP')
                        ->sortByDesc('uploaded_at')
                        ->first();
                @endphp

                <div class="relative bg-white rounded-xl border border-gray-200 p-5 hover:shadow-lg transition">

                    {{-- Status Badge --}}
                    @if ($aktif > 0)
                        <span class="absolute top-4 right-4 px-3 py-1 text-xs bg-amber-100 text-amber-700 rounded-full">
                            Sedang Sewa
                        </span>
                    @endif

                    <h4 class="text-lg font-bold text-gray-800">{{ $pelanggan->nama }}</h4>
                    <p class="text-sm text-gray-500">{{ $pelanggan->no_hp }}</p>
                    <p class="text-xs text-gray-400 mb-3">NIK: {{ $pelanggan->no_ktp }}</p>

                    {{-- KTP Preview --}}
                    @if ($ktp && $ktp->file_path)
                        <img src="{{ asset('storage/' . $ktp->file_path) }}"
                            class="w-full h-28 object-cover rounded-lg mb-3 border">
                    @endif

                    {{-- Stats --}}
                    <div class="text-sm text-gray-600 space-y-1 mb-4">
                        <p>Total Sewa: <strong>{{ $totalSewa }}</strong></p>
                        <p>Pernah Terlambat: <strong>{{ $terlambat }}</strong></p>
                        <p>Total Pengeluaran:
                            <strong>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong>
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-2">
                        <a href="{{ route('petugas.pelanggans.show', $pelanggan->id) }}"
                            class="flex-1 text-center px-3 py-2 bg-[#1f2937] bg-opacity-10 text-[#1f2937] rounded-lg text-sm font-semibold">
                            Detail
                        </a>

                        <form action="{{ route('petugas.pelanggans.destroy', $pelanggan->id) }}" method="POST"
                            onsubmit="return confirm('Yakin hapus pelanggan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-semibold">
                                Hapus
                            </button>
                        </form>
                    </div>

                </div>

            @empty
                <div class="col-span-full text-center py-10 text-gray-500">
                    Belum ada data pelanggan.
                </div>
            @endforelse

        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $pelanggans->withQueryString()->links() }}
        </div>

    </div>
@endsection

