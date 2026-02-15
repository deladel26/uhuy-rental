<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggan::with(['sewas', 'dokumenPelanggan']);

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('no_hp', 'like', '%' . $request->search . '%')
                    ->orWhere('no_ktp', 'like', '%' . $request->search . '%');
            });
        }

        $pelanggans = $query->latest()->paginate(9);

        return view('petugas.pelanggans.index', compact('pelanggans'));
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::with([
            'sewas.motor',
            'dokumenPelanggan'
        ])->findOrFail($id);

        return view('petugas.pelanggans.show', compact('pelanggan'));
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        if ($pelanggan->sewas()->exists()) {
            return back()->with('error', 'Pelanggan tidak bisa dihapus karena memiliki riwayat transaksi.');
        }

        $pelanggan->delete();

        return back()->with('success', 'Pelanggan berhasil dihapus.');
    }
}
