<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StatusProgressController;

Route::get('/', function () { return view('welcome'); });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Semua rute dashboard di sini agar aman
    Route::get('/dashboard', function () { return view('dashboard', ['layananSelesai' => 0,'totalPelanggan' => 0,'antreanAktif' => collect([]),]);})->name('dashboard');
    Route::get('/status-progres', function () { return view('status-progress'); })->name('status-progress.index');
    Route::get('/booking-calendar', function () { return view('booking-calendar'); })->name('booking.calendar');
    Route::get('/input-transaksi', function () { return view('input-transaksi'); })->name('input.transaksi');
    Route::get('/riwayat-servis', function () { return view('riwayat-servis'); })->name('riwayat.servis');
    Route::get('/jadwal-mekanik', function () { return view('jadwal-mekanik'); })->name('jadwal.mekanik');
    Route::get('/stok-bahan', function () { return view('stok-bahan'); })->name('stok.bahan');
    Route::get('/laporan-pendapatan', function () { return view('laporan-pendapatan'); })->name('laporan.pendapatan');
});

require __DIR__.'/auth.php';
