<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController; // BARU: Memanggil jembatan Dashboard Controller
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StatusProgressController;
use App\Http\Controllers\ReservationController;

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
    Route::get('/status-progres', function () { return view('status-progress'); })->name('status-progress.index');
    Route::get('/booking-calendar', function () { return view('booking-calendar'); })->name('booking.calendar');
    Route::get('/jadwal-mekanik', function () { return view('jadwal-mekanik'); })->name('jadwal.mekanik');
    Route::get('/stok-bahan', function () { return view('stok-bahan'); })->name('stok.bahan');

    // 1. Rute untuk menampilkan halaman (Tetap GET)
    Route::get('/input-transaksi', [TransaksiController::class, 'create'])->name('input.transaksi.view');

    // 2. Rute untuk memproses data dari form (Harus POST)
    Route::post('/input-transaksi', [TransaksiController::class, 'store'])->name('input.transaksi');

    // 🌟 KHUSUS RIWAYAT SERVIS AWAL RILIS: Mengambil data riel kosong dari database transaksi kasir
    Route::get('/riwayat-servis', function () {
        // Mengambil semua data dari database dan mengurutkannya dari yang terbaru
        $dataFinance = \App\Models\Transaksi::orderBy('created_at', 'desc')->get();

        return view('riwayat-servis', compact('dataFinance'));
    })->name('riwayat.servis');

    // 🔥 JALUR LAPORAN PENDAPATAN: Mengarah ke fungsi laporan() di TransaksiController
    Route::get('/laporan-pendapatan', [TransaksiController::class, 'laporan'])->name('laporan.pendapatan');

    // Rute Tambahan untuk Tombol Export Excel
    Route::get('/laporan-pendapatan/export', function () {
        return "Sistem Export Excel sedang dipersiapkan.";
    })->name('laporan.pendapatan.export');
});

// Memanggil Sistem Autentikasi Bawaan Laravel (Login / Register)
require __DIR__.'/auth.php';
