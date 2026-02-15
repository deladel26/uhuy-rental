@extends('layouts.ini')

@section('title', 'Detail Pelanggan')

@section('content')
    <div class="container mx-auto px-4 py-6">

        <h2 class="text-2xl font-bold mb-4">{{ $pelanggan->nama }}</h2>

        <div class="bg-white rounded-xl border p-6 mb-6">
            <p><strong>No HP:</strong> {{ $pelanggan->no_hp }}</p>
            <p><strong>NIK:</strong> {{ $pelanggan->no_ktp }}</p>
            <p><strong>Alamat:</strong> {{ $pelanggan->alamat }}</p>
        </div>

        <h3 class="text-xl font-semibold mb-3">Riwayat Sewa</h3>

        <div class="space-y-3">
            @foreach ($pelanggan->sewas as $sewa)
                <div class="bg-white border rounded-lg p-4 flex justify-between">
                    <div>
                        <p class="font-semibold">{{ $sewa->motor->plat_nomor }}</p>
                        <p class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($sewa->tanggal_sewa)->format('d M Y') }}
                        </p>
                    </div>
                    <span
                        class="px-3 py-1 text-xs rounded-full
                @if ($sewa->status == 'aktif') bg-amber-100 text-amber-700
                @elseif($sewa->status == 'selesai') bg-green-100 text-green-700
                @else bg-red-100 text-red-700 @endif">
                        {{ ucfirst($sewa->status) }}
                    </span>
                </div>
            @endforeach
        </div>

    </div>
@endsection
