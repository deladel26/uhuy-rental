<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Petugas\SewaController as PetugasSewa;
use App\Http\Controllers\Petugas\PelangganController as PetugasPelanggan;
use App\Http\Controllers\Admin\MotorController as AdminMotor;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\LaporanKeuanganController as AdminLaporanKeuangan;
use App\Http\Controllers\Admin\PetugasController as AdminPetugas;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;



Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'status', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    Route::get('/laporan-keuangan', [AdminLaporanKeuangan::class, 'index'])->name('admin.laporan-keuangan.index');
    Route::resource('petugas', AdminPetugas::class)
        ->except(['show'])
        ->parameters(['petugas' => 'petugas'])
        ->names('admin.petugas');
    Route::resource('motors', AdminMotor::class);

});

/*
|--------------------------------------------------------------------------
| PETUGAS ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'status', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {
        
    Route::get('/dashboard', [PetugasDashboard::class, 'index'])->name('dashboard');
        
  
        
    Route::post('/pelanggans/{pelanggan}/upload-dokumen',
        [PetugasPelanggan::class, 'uploadDokumen']
    )->name('pelanggans.uploadDokumen');
        // custom route untuk menyelesaikan sewa

        // Routes yang sudah ada
        Route::resource('sewas', PetugasSewa::class);

        // ROUTE BARU: Check availability motor
        Route::post('sewas/check-availability', [PetugasSewa::class, 'checkAvailability'])
            ->name('sewas.check-availability');

        // ROUTE BARU: Get blocked dates untuk Flatpickr
        Route::get('sewas/blocked-dates/{motor}', [PetugasSewa::class, 'getBlockedDates'])
        ->name('sewas.blocked-dates');

        // ROUTE BARU: Finish sewa (jika belum ada)
        Route::post('sewas/{sewa}/finish', [PetugasSewa::class, 'finish'])
            ->name('sewas.finish');

        Route::resource('pelanggans', PetugasPelanggan::class)->only(['index', 'show', 'destroy']);
    });
// Route::middleware(['auth', 'status', 'role:petugas'])->prefix('petugas')->group(function () {
//     Route::get('/dashboard', [PetugasDashboard::class, 'index'])->name('petugas.dashboard');
//     Route::resource('sewas', PetugasSewa::class);
//     Route::resource('pelanggans', PetugasPelanggan::class);

//     // Upload dokumen pelanggan
//     Route::post(
//         '/pelanggans/{pelanggan}/upload-dokumen',
//         [PetugasPelanggan::class, 'uploadDokumen']
//     )->name('pelanggans.uploadDokumen');
    
// });
require __DIR__.'/auth.php';
