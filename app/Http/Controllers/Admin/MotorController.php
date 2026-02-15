<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use Illuminate\Http\Request;

class MotorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $motors = Motor::orderBy('id', 'desc')->paginate(10);

        return view('admin.motors.index', compact('motors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.motors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor'  => 'required|unique:motors,plat_nomor',
            'merk'        => 'required|string|max:50',
            'tahun'       => 'nullable|digits:4',
            'warna'       => 'nullable|string|max:30',
            'harga_sewa'  => 'required|numeric|min:0',
            'status'      => 'required|in:tersedia,disewa,servis',
            'kondisi'     => 'nullable|string|max:50',
        ]);

        Motor::create([
            'plat_nomor' => $request->plat_nomor,
            'merk'       => $request->merk,
            'tahun'      => $request->tahun,
            'warna'      => $request->warna,
            'harga_sewa' => $request->harga_sewa,
            'status'     => $request->status,
            'kondisi'    => $request->kondisi,
        ]);

        return redirect()
            ->route('motors.index')
            ->with('success', 'Data motor berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Motor $motor)
    {
        return view('admin.motors.edit', compact('motor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Motor $motor)
    {
        $request->validate([
            'plat_nomor'  => 'required|unique:motors,plat_nomor,' . $motor->id,
            'merk'        => 'required|string|max:50',
            'tahun'       => 'nullable|digits:4',
            'warna'       => 'nullable|string|max:30',
            'harga_sewa'  => 'required|numeric|min:0',
            'status'      => 'required|in:tersedia,disewa,servis',
            'kondisi'     => 'nullable|string|max:50',
        ]);

        $motor->update([
            'plat_nomor' => $request->plat_nomor,
            'merk'       => $request->merk,
            'tahun'      => $request->tahun,
            'warna'      => $request->warna,
            'harga_sewa' => $request->harga_sewa,
            'status'     => $request->status,
            'kondisi'    => $request->kondisi,
        ]);

        return redirect()
            ->route('motors.index')
            ->with('success', 'Data motor berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Motor $motor)
    {
        // Cegah hapus jika motor sedang disewa
        if ($motor->status === 'disewa') {
            return redirect()
                ->back()
                ->with('error', 'Motor sedang disewa, tidak bisa dihapus.');
        }

        $motor->delete();

        return redirect()
            ->route('motors.index')
            ->with('success', 'Data motor berhasil dihapus.');
    }
}
