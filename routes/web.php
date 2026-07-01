<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StatusProgressController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\BookingController;

    // Rute Halaman Depan Awalan Website
    Route::get('/', function () { return view('welcome'); });

    // Semua Rute yang Terproteksi Login (Middleware Auth)
    Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Rute Manajemen Profil User Admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Rute Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 3. Rute Customer (Tempatkan di sini, tidak perlu middleware auth ganda)
    Route::get('/customer/beranda', function () {
        return view('customer.beranda');
    })->name('customer.beranda');

    // 4. Rute Transaksi & Progress (Rute yang sudah berelasi)
    Route::get('/status-progres', [StatusProgressController::class, 'index'])->name('status-progress.index');
    Route::post('/api/update-status-mobil/{id}', [StatusProgressController::class, 'updateStatus'])->name('status.update');

    // 5. Rute Booking & Jadwal
    Route::get('/booking-calendar', [BookingController::class, 'index'])->name('booking.calendar');
    Route::post('/booking/verify/{id}', [BookingController::class, 'verify']);
    Route::get('/jadwal-mekanik', function () { return view('jadwal-mekanik'); })->name('jadwal.mekanik');
    Route::post('/submit-booking', [ReservationController::class, 'storeCustomerBooking'])->name('api.booking.store');

    // 6. Rute Transaksi (View & Store)
    Route::get('/input-transaksi', [TransaksiController::class, 'create'])->name('input.transaksi.view');
    Route::post('/input-transaksi', [TransaksiController::class, 'store'])->name('input.transaksi.store');
    Route::get('/input-transaksi/{id}', [TransaksiController::class, 'createFromBooking'])->name('input.transaksi.booking');

    // 7. Rute Stok Bahan
    Route::get('/stok-bahan', function () { return view('stok-bahan'); })->name('stok.bahan');

    // 8. Rute Riwayat Servis
    Route::get('/riwayat-servis', [TransaksiController::class, 'riwayat'])->name('riwayat.servis');

    // 9. Rute Laporan Pendapatan
    Route::get('/laporan-pendapatan', [TransaksiController::class, 'laporan'])->name('laporan.pendapatan');

    // 10. Rute Tambahan untuk Tombol Export Excel
    Route::get('/laporan-pendapatan/export', function () {
        return "Sistem Export Excel sedang dipersiapkan.";
    })->name('laporan.pendapatan.export');

});

// Memanggil Sistem Autentikasi Bawaan Laravel (Login / Register)
require __DIR__.'/auth.php';
