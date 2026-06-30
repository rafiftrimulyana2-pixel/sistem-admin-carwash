<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController; // BARU: Memanggil jembatan Dashboard Controller
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StatusProgressController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\BookingController;

    // Rute Halaman Depan Awalan Website
    Route::get('/', function () { return view('welcome'); });

    // Semua Rute yang Terproteksi Login (Middleware Auth)
    Route::middleware(['auth', 'verified'])->group(function () {

    // Rute Manajemen Profil User Admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================================================
    // PERBAIKAN UTAMA: Jalur Menu Dashboard Dialihkan ke DashboardController@index
    // ==========================================================================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Semua Rute Menu Utama & Transaksi Dashboard Carwash Nyata
    Route::get('/status-progres', [StatusProgressController::class, 'index'])->name('status-progress.index');

    Route::get('/booking-calendar', [BookingController::class, 'index'])->name('booking.calendar');
    Route::post('/booking/verify/{id}', [BookingController::class, 'verify']);

    Route::get('/jadwal-mekanik', function () { return view('jadwal-mekanik'); })->name('jadwal.mekanik');

    Route::get('/stok-bahan', function () { return view('stok-bahan'); })->name('stok.bahan');

    // Tambahkan di dalam route group middleware auth
    Route::post('/submit-booking', [ReservationController::class, 'storeCustomerBooking'])->name('api.booking.store');

    // Tambahkan baris ini di dalam group middleware 'auth'
    Route::post('/api/update-status-mobil/{id}', [StatusProgressController::class, 'updateStatus'])->name('status.update');

    // 1. Rute untuk menampilkan halaman (Tetap GET)
    Route::get('/input-transaksi', [TransaksiController::class, 'create'])->name('input.transaksi.view');

    // 2. Rute untuk memproses data dari form (Harus POST)
    Route::post('/input-transaksi', [TransaksiController::class, 'store'])->name('input.transaksi.store');

    // 🌟 KHUSUS RIWAYAT SERVIS AWAL RILIS: Mengambil data riel kosong dari database transaksi kasir
    Route::get('/riwayat-servis', [TransaksiController::class, 'riwayat'])->name('riwayat.servis');

    // 🔥 JALUR LAPORAN PENDAPATAN: Mengarah ke fungsi laporan() di TransaksiController
    Route::get('/laporan-pendapatan', [TransaksiController::class, 'laporan'])->name('laporan.pendapatan');

    // Ini adalah "pintu" baru untuk membawa data dari kalender ke form transaksi
    Route::get('/input-transaksi/{id}', [TransaksiController::class, 'createFromBooking'])->name('input.transaksi.booking');

    // Rute Tambahan untuk Tombol Export Excel
    Route::get('/laporan-pendapatan/export', function () {
        return "Sistem Export Excel sedang dipersiapkan.";
    })->name('laporan.pendapatan.export');
});

// Memanggil Sistem Autentikasi Bawaan Laravel (Login / Register)
require __DIR__.'/auth.php';
