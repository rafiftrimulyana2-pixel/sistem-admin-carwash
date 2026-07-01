<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StatusProgressController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;

    // ---------------------------------------------------------------------------------------------------------------------- //

    // --- JALUR ADMIN (Akses melalui sistem-admin-carwash.test) --- //
    Route::domain('sistem-admin-carwash.test')->group(function () {

    // Rute Halaman Depan Awalan Website
    Route::get('/', function () { return view('welcome'); });

    // Semua Rute yang Terproteksi Login (Middleware Auth) seperti (Dashboard, Transaksi, Laporan, dll)
    Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Rute Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Manajemen Profil User Admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Rute Booking Kalendar (Rute yang sudah berelasi)
    Route::get('/booking-calendar', [BookingController::class, 'index'])->name('booking.calendar');
    Route::post('/booking/verify/{id}', [BookingController::class, 'verify']);

    // 3. Rute Status Progress (Rute yang sudah berelasi)
    Route::get('/status-progres', [StatusProgressController::class, 'index'])->name('status-progress.index');
    Route::post('/api/update-status-mobil/{id}', [StatusProgressController::class, 'updateStatus'])->name('status.update');

    // 4. Rute Transaksi (Booking & Store) - (Rute yang sudah berelasi)
    Route::get('/input-transaksi', [TransaksiController::class, 'create'])->name('input.transaksi.view');
    Route::post('/input-transaksi', [TransaksiController::class, 'store'])->name('input.transaksi.store');
    Route::get('/input-transaksi/{id}', [TransaksiController::class, 'createFromBooking'])->name('input.transaksi.booking');

    // 5. Rute Stok Bahan
    Route::get('/stok-bahan', function () { return view('stok-bahan'); })->name('stok.bahan');

    // 6. Rute Riwayat Servis
    Route::get('/riwayat-servis', [TransaksiController::class, 'riwayat'])->name('riwayat.servis');

    // 7. Rute Laporan Pendapatan (Tombol Penyimpanan Data Ke Dalam Excel)
    Route::get('/laporan-pendapatan', [TransaksiController::class, 'laporan'])->name('laporan.pendapatan');
    Route::get('/laporan-pendapatan/export', function () {return "Sistem Export Excel sedang dipersiapkan."; })->name('laporan.pendapatan.export');

    // 8. Rute Booking & Jadwal (Rute yang sudah berelasi)
    Route::get('/jadwal-mekanik', function () { return view('jadwal-mekanik'); })->name('jadwal.mekanik');
    Route::post('/submit-booking', [ReservationController::class, 'storeCustomerBooking'])->name('api.booking.store');
    });
});

    // ---------------------------------------------------------------------------------------------------------------------- //

    // --- JALUR CUSTOMER (Akses melalui customer.sistem-admin-carwash.test) ---
    Route::domain('customer.sistem-admin-carwash.test')->group(function () {

    // 1. Tampilan awal (Login)
    Route::get('/', function () { return view('customer.login'); })->name('login');

    // 2. Tampilan Registrasi
    Route::get('/registrasi', [CustomerController::class, 'showRegister'])->name('registrasi');

    // 3. Rute POST untuk memproses login
    Route::post('/login-process', [CustomerController::class, 'login'])->name('customer.login.process');

    // 4. PERBAIKAN: Arahkan ke CustomerController yang baru dibuat
    Route::post('/register-process', [CustomerController::class, 'registerProcess'])->name('customer.register.process');

    Route::post('/logout', [CustomerController::class, 'logout'])->name('customer.logout');

    // Setelah login, masuk ke beranda customer
    Route::middleware(['auth:customer'])->group(function () {

    // 1. Rute Beranda Customer
    Route::get('/beranda', function () {
        return view('customer.beranda');
            })->name('customer.beranda');
    });
});

    // Memanggil Sistem Autentikasi Bawaan Laravel (Login / Register)
    require __DIR__.'/auth.php';
