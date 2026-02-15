<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $bulanInput = $request->input('bulan', (string) now()->month);
        $bulanAngka = filter_var($bulanInput, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1, 'max_range' => 12],
        ]);
        $bulan = $bulanInput === 'semua' ? 'semua' : ($bulanAngka !== false ? (string) $bulanAngka : (string) now()->month);
        $tahun = (int) $request->input('tahun', now()->year);
        $statusPembayaran = $request->input('status_pembayaran', '');

        $baseQuery = Sewa::query()
            ->whereYear('tanggal_sewa', $tahun);

        if ($bulan !== 'semua') {
            $baseQuery->whereMonth('tanggal_sewa', (int) $bulan);
        }

        if (in_array($statusPembayaran, ['lunas', 'belum'], true)) {
            $baseQuery->where('status_pembayaran', $statusPembayaran);
        }

        $totalNominalExpr = DB::raw('total_harga + COALESCE(denda, 0)');

        $totalTransaksi = (clone $baseQuery)->count();
        $totalPendapatanBruto = (clone $baseQuery)->sum($totalNominalExpr);
        $totalPendapatanLunas = (clone $baseQuery)
            ->where('status_pembayaran', 'lunas')
            ->sum($totalNominalExpr);
        $totalPiutang = (clone $baseQuery)
            ->where('status_pembayaran', 'belum')
            ->sum($totalNominalExpr);
        $totalDenda = (clone $baseQuery)->sum('denda');

        $transaksis = (clone $baseQuery)
            ->with(['pelanggan:id,nama', 'motor:id,merk,plat_nomor'])
            ->orderByDesc('tanggal_sewa')
            ->get();

        $tahunTersedia = Sewa::query()
            ->selectRaw('YEAR(tanggal_sewa) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        if ($tahunTersedia->isEmpty()) {
            $tahunTersedia = collect([now()->year]);
        }

        return view('admin.laporan-keuangan.index', compact(
            'bulan',
            'tahun',
            'statusPembayaran',
            'totalTransaksi',
            'totalPendapatanBruto',
            'totalPendapatanLunas',
            'totalPiutang',
            'totalDenda',
            'transaksis',
            'tahunTersedia'
        ));
    }
}
