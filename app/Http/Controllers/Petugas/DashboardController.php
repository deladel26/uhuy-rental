<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Sewa;
use App\Models\Motor;
use App\Models\Pelanggan;

class DashboardController extends Controller
{
    public function index()
    {
        $transaksiTerbaru = Sewa::with(['motor', 'pelanggan'])
            ->latest('tanggal_sewa')
            ->limit(5)
            ->get();

        return view('petugas.dashboard', [
            'sewa_aktif' => Sewa::where('status', 'aktif')->count(),
            'motor_tersedia' => Motor::where('status', 'tersedia')->count(),
            'motor_disewa' => Motor::where('status', 'disewa')->count(),
            'sewa_hari_ini' => Sewa::whereDate('tanggal_sewa', today())->count(),
            'total_pelanggan' => Pelanggan::count(),
            'pendapatan_hari_ini' => Sewa::whereDate('tanggal_sewa', today())
                ->where('status_pembayaran', 'lunas')
                ->sum('total_harga'),
            'sewa_jatuh_tempo' => Sewa::where('status', 'aktif')
                ->whereDate('tanggal_kembali_rencana', '<=', today())
                ->count(),
            'transaksi_terbaru' => $transaksiTerbaru,
        ]);
    }
}
