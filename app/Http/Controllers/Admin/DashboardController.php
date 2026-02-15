<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use App\Models\Pelanggan;
use App\Models\Sewa;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'total_motor'     => Motor::count(),
            'motor_tersedia'  => Motor::where('status', 'tersedia')->count(),
            'motor_disewa'    => Motor::where('status', 'disewa')->count(),
            'total_pelanggan' => Pelanggan::count(),
            'total_sewa'      => Sewa::count(),
            'sewa_aktif'      => Sewa::where('status', 'aktif')->count(),
            'pendapatan_hari_ini' => Sewa::whereDate('tanggal_sewa', today())
                ->where('status_pembayaran', 'lunas')
                ->sum('total_harga'),
        ]);
    }
}
