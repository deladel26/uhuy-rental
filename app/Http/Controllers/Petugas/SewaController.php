<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Sewa;
use App\Models\Motor;
use App\Models\Pelanggan;
use App\Models\DokumenPelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SewaController extends Controller
{
    public function index()
    {
        $sewas = Sewa::with([
            'motor',
            'pelanggan.dokumenPelanggan' 
        ])
            ->orderBy('tanggal_sewa', 'desc')
            ->get();

        return view('petugas.sewas.index', compact('sewas'));
    }

    public function create()
    {
        $motors = Motor::where('status', 'tersedia')->get();
        $pelanggans = Pelanggan::orderBy('nama')->get();

        return view('petugas.sewas.create', compact('motors', 'pelanggans'));
    }

    /**
     * METHOD: Cek ketersediaan motor untuk periode tertentu
     * Digunakan via AJAX dari form create
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'motor_id' => 'required|exists:motors,id',
            'tanggal_sewa' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_sewa',
        ]);

        $motorId = $request->motor_id;
        $tanggalMulai = Carbon::parse($request->tanggal_sewa);
        $tanggalSelesai = Carbon::parse($request->tanggal_kembali_rencana);

        $isAvailable = $this->isMotorAvailable($motorId, $tanggalMulai, $tanggalSelesai);

        return response()->json([
            'available' => $isAvailable,
            'message' => $isAvailable
                ? 'Motor tersedia untuk periode ini'
                : 'Motor sudah disewa pada periode ini'
        ]);
    }

    /**
     * HELPER METHOD: Cek apakah motor tersedia di periode tertentu
     */
    private function isMotorAvailable($motorId, $tanggalMulai, $tanggalSelesai, $excludeSewaId = null)
    {
        // Cek apakah ada sewa aktif yang overlap dengan periode yang diminta
        $query = Sewa::where('motor_id', $motorId)
            ->where('status', 'aktif') // Hanya cek sewa yang masih aktif
            ->where(function ($q) use ($tanggalMulai, $tanggalSelesai) {
                // Logika overlap checking:
                // Sewa dianggap overlap jika:
                // 1. Tanggal sewa baru dimulai di tengah-tengah sewa existing
                // 2. Tanggal sewa baru berakhir di tengah-tengah sewa existing  
                // 3. Tanggal sewa baru mencakup keseluruhan sewa existing
                $q->where(function ($q2) use ($tanggalMulai, $tanggalSelesai) {
                    // Case 1: Sewa baru mulai sebelum sewa lama selesai
                    $q2->whereBetween('tanggal_sewa', [$tanggalMulai, $tanggalSelesai])
                        ->orWhereBetween('tanggal_kembali_rencana', [$tanggalMulai, $tanggalSelesai]);
                })
                    ->orWhere(function ($q2) use ($tanggalMulai, $tanggalSelesai) {
                        // Case 2: Sewa lama berada di tengah-tengah sewa baru
                        $q2->where('tanggal_sewa', '<=', $tanggalMulai)
                            ->where('tanggal_kembali_rencana', '>=', $tanggalSelesai);
                    });
            });

        // Exclude sewa tertentu jika ada (untuk update)
        if ($excludeSewaId) {
            $query->where('id', '!=', $excludeSewaId);
        }

        return $query->count() === 0;
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_pelanggan' => 'required|in:baru,lama',
            'pelanggan_id' => 'required_if:jenis_pelanggan,lama|nullable|exists:pelanggans,id',
            'no_ktp' => 'required_if:jenis_pelanggan,baru|nullable|string|max:16',
            'nama_pelanggan' => 'required_if:jenis_pelanggan,baru|nullable|string|max:255',
            'no_hp' => 'required_if:jenis_pelanggan,baru|nullable|string|max:20',
            'alamat' => 'required_if:jenis_pelanggan,baru|nullable|string',
            'foto_ktp' => 'nullable|file|image|mimes:jpg,jpeg,png|max:2048',
            'motor_id' => 'required|exists:motors,id',
            'tanggal_sewa' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_sewa',
            'status_pembayaran' => 'required|in:belum,lunas',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Ambil pelanggan sesuai jenis yang dipilih
            if ($request->jenis_pelanggan === 'lama') {
                $pelanggan = Pelanggan::findOrFail($request->pelanggan_id);
            } else {
                $pelanggan = Pelanggan::firstOrCreate(
                    ['no_ktp' => $request->no_ktp],
                    [
                        'nama'   => $request->nama_pelanggan,
                        'no_hp'  => $request->no_hp,
                        'alamat' => $request->alamat,
                    ]
                );
            }

            // 2. Lock motor dan cek ketersediaan
            $motor = Motor::lockForUpdate()->findOrFail($request->motor_id);

            // PERUBAHAN PENTING: Cek ketersediaan berdasarkan TANGGAL, bukan STATUS
            $tanggal_sewa = Carbon::parse($request->tanggal_sewa);
            $tanggal_kembali = Carbon::parse($request->tanggal_kembali_rencana);

            if (!$this->isMotorAvailable($motor->id, $tanggal_sewa, $tanggal_kembali)) {
                abort(400, 'Motor sudah disewa pada periode yang dipilih. Silakan pilih tanggal lain.');
            }

            // 3. Hitung harga
            $lama_hari = max(1, $tanggal_sewa->diffInDays($tanggal_kembali));
            $total_harga = $lama_hari * $motor->harga_sewa;

            // 4. Buat transaksi sewa
            $sewa = Sewa::create([
                'motor_id'     => $motor->id,
                'pelanggan_id' => $pelanggan->id,
                'user_id'      => auth()->id(),

                'tanggal_sewa'            => $tanggal_sewa,
                'tanggal_kembali_rencana' => $tanggal_kembali,

                'harga_per_hari' => $motor->harga_sewa,
                'total_harga'    => $total_harga,
                'denda'          => 0,

                'status'            => 'aktif',
                'status_pembayaran' => $request->status_pembayaran,
            ]);

            // 5. Upload dokumen KTP jika ada
            if ($request->hasFile('foto_ktp')) {
                $path = $request->file('foto_ktp')->store('dokumen_ktp', 'public');

                $sewa->dokumenPelanggan()->create([
                    'pelanggan_id' => $sewa->pelanggan_id,
                    'jenis_dokumen' => 'KTP',
                    'file_path'    => $path,
                    'uploaded_at' => now(),
                ]);
            }

            // 6. PERUBAHAN: Update status motor HANYA jika sewa dimulai HARI INI
            if ($tanggal_sewa->isToday()) {
                $motor->update(['status' => 'disewa']);
            } else {
                // Jika sewa untuk masa depan, status tetap 'tersedia'
                // Tapi motor tidak bisa disewa untuk tanggal yang sama
                $motor->update(['status' => 'tersedia']);
            }
        });

        return redirect()
            ->route('petugas.sewas.index')
            ->with('success', 'Transaksi sewa berhasil dibuat.');
    }

    public function show(Sewa $sewa)
    {
        // PERUBAHAN: Eager load dokumen pelanggan untuk detail view
        $sewa->load(['motor', 'pelanggan', 'dokumenPelanggan']);

        return view('petugas.sewas.show', compact('sewa'));
    }

    public function finish(Request $request, Sewa $sewa)
    {
        $request->validate([
            'tanggal_kembali_real' => 'required|date',
            'denda_terlambat' => 'nullable|numeric|min:0',
            'denda_kerusakan' => 'nullable|numeric|min:0',
            'denda' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:lunas,belum',
        ]);

        DB::transaction(function () use ($request, $sewa) {
            // Parse tanggal
            $tanggalKembaliReal = Carbon::parse($request->tanggal_kembali_real);
            $tanggalKembaliRencana = Carbon::parse($sewa->tanggal_kembali_rencana);

            // Hitung keterlambatan (jika ada)
            $hariTerlambat = 0;
            if ($tanggalKembaliReal->greaterThan($tanggalKembaliRencana)) {
                $hariTerlambat = $tanggalKembaliReal->diffInDays($tanggalKembaliRencana);
            }

            // Total denda = denda terlambat + denda kerusakan
            $totalDenda = $request->denda ?? 0;

            // Update sewa
            $sewa->update([
                'tanggal_kembali_real' => $tanggalKembaliReal,
                'denda' => $totalDenda,
                'status' => 'selesai',
                'status_pembayaran' => $request->status_pembayaran,
            ]);

            // PERUBAHAN: Update status motor dengan logika lebih pintar
            // Cek apakah ada sewa aktif lain untuk motor ini
            $hasOtherActiveSewa = Sewa::where('motor_id', $sewa->motor_id)
                ->where('id', '!=', $sewa->id)
                ->where('status', 'aktif')
                ->where('tanggal_sewa', '<=', now())
                ->where('tanggal_kembali_rencana', '>=', now())
                ->exists();

            // Jika tidak ada sewa aktif lain, motor jadi tersedia
            if (!$hasOtherActiveSewa) {
                $sewa->motor->update(['status' => 'tersedia']);
            }
            // Jika masih ada sewa aktif lain, status tetap 'disewa'
        });

        return redirect()
            ->route('petugas.sewas.index')
            ->with('success', 'Transaksi berhasil diselesaikan. Total denda: Rp ' . number_format($request->denda, 0, ',', '.'));
    }

    public function destroy(Sewa $sewa)
    {
        if ($sewa->status === 'aktif') {
            DB::transaction(function () use ($sewa) {
                $sewa->update(['status' => 'batal']);

                // PERUBAHAN: Cek apakah ada sewa aktif lain sebelum ubah status motor
                $hasOtherActiveSewa = Sewa::where('motor_id', $sewa->motor_id)
                    ->where('id', '!=', $sewa->id)
                    ->where('status', 'aktif')
                    ->where('tanggal_sewa', '<=', now())
                    ->where('tanggal_kembali_rencana', '>=', now())
                    ->exists();

                if (!$hasOtherActiveSewa) {
                    $sewa->motor->update(['status' => 'tersedia']);
                }
            });

            return back()->with('success', 'Transaksi sewa dibatalkan.');
        }

        return back()->with('error', 'Transaksi selesai tidak bisa dihapus.');
    }

    /**
     * METHOD BARU: Update status motor secara otomatis via cron/scheduler
     * Jalankan setiap hari untuk update status motor
     */
    public function updateMotorStatuses()
    {
        $today = Carbon::today();

        // 1. Set motor jadi 'disewa' jika ada sewa yang mulai hari ini
        $sewasMulaiHariIni = Sewa::where('status', 'aktif')
            ->whereDate('tanggal_sewa', $today)
            ->get();

        foreach ($sewasMulaiHariIni as $sewa) {
            $sewa->motor->update(['status' => 'disewa']);
        }

        // 2. Set motor jadi 'tersedia' jika tidak ada sewa aktif
        $motors = Motor::all();
        foreach ($motors as $motor) {
            $hasActiveSewa = Sewa::where('motor_id', $motor->id)
                ->where('status', 'aktif')
                ->where('tanggal_sewa', '<=', $today)
                ->where('tanggal_kembali_rencana', '>=', $today)
                ->exists();

            if (!$hasActiveSewa && $motor->status === 'disewa') {
                $motor->update(['status' => 'tersedia']);
            }
        }

        return response()->json(['message' => 'Motor statuses updated successfully']);
    }

    // TAMBAHKAN METHOD INI DI SewaController.php

    /**
     * Get blocked dates untuk motor tertentu
     * Digunakan oleh Flatpickr untuk disable tanggal yang sudah disewa
     */
    public function getBlockedDates($motorId)
    {
        try {
            // Ambil semua sewa aktif untuk motor ini
            $sewasAktif = Sewa::where('motor_id', $motorId)
                ->where('status', 'aktif')
                ->select('tanggal_sewa', 'tanggal_kembali_rencana')
                ->get();

            $blockedDates = [];

            foreach ($sewasAktif as $sewa) {
                $startDate = Carbon::parse($sewa->tanggal_sewa);
                $endDate = Carbon::parse($sewa->tanggal_kembali_rencana);

                // Format untuk Flatpickr: array of date ranges
                $blockedDates[] = [
                    'from' => $startDate->format('Y-m-d'),
                    'to' => $endDate->format('Y-m-d')
                ];
            }

            return response()->json([
                'success' => true,
                'blocked_dates' => $blockedDates,
                'message' => count($blockedDates) > 0
                    ? count($blockedDates) . ' periode tanggal sudah disewa'
                    : 'Semua tanggal tersedia'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'blocked_dates' => [],
                'message' => 'Gagal memuat tanggal yang diblokir'
            ], 500);
        }
    }
}
