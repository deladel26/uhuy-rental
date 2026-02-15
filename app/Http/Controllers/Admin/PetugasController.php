<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        $status = $request->input('status', '');

        $petugasQuery = User::query()->where('role', 'petugas');

        if ($q !== '') {
            $petugasQuery->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('username', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if (in_array($status, ['aktif', 'non-aktif'], true)) {
            $petugasQuery->where('status', $status);
        }

        $petugas = $petugasQuery
            ->withCount('sewas')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $statsBase = User::query()->where('role', 'petugas');

        $totalPetugas = (clone $statsBase)->count();
        $totalAktif = (clone $statsBase)->where('status', 'aktif')->count();
        $totalNonAktif = (clone $statsBase)->where('status', 'non-aktif')->count();

        return view('admin.petugas.index', compact(
            'petugas',
            'q',
            'status',
            'totalPetugas',
            'totalAktif',
            'totalNonAktif'
        ));
    }

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('users', 'username')],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'status' => ['required', Rule::in(['aktif', 'non-aktif'])],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'status' => $validated['status'],
            'role' => 'petugas',
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil ditambahkan.');
    }

    public function edit(User $petugas)
    {
        if ($petugas->role !== 'petugas') {
            abort(404);
        }

        return view('admin.petugas.edit', compact('petugas'));
    }

    public function update(Request $request, User $petugas)
    {
        if ($petugas->role !== 'petugas') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('users', 'username')->ignore($petugas->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($petugas->id)],
            'status' => ['required', Rule::in(['aktif', 'non-aktif'])],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $payload = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'status' => $validated['status'],
        ];

        if (!empty($validated['password'])) {
            $payload['password'] = Hash::make($validated['password']);
        }

        $petugas->update($payload);

        return redirect()
            ->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil diperbarui.');
    }

    public function destroy(User $petugas)
    {
        if ($petugas->role !== 'petugas') {
            abort(404);
        }

        if ($petugas->sewas()->exists()) {
            return back()->with('error', 'Petugas memiliki riwayat transaksi sewa, tidak bisa dihapus.');
        }

        $petugas->delete();

        return redirect()
            ->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil dihapus.');
    }
}
