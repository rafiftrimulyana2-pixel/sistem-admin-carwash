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
    Route::get('/input-transaksi', function () { return view('transaksi.input-transaksi'); })->name('input.transaksi');
    Route::get('/riwayat-servis', function () { return view('riwayat-servis'); })->name('riwayat.servis');
    Route::get('/jadwal-mekanik', function () { return view('jadwal-mekanik'); })->name('jadwal.mekanik');
    Route::get('/stok-bahan', function () { return view('stok-bahan'); })->name('stok.bahan');

    // Rute Final Laporan Pendapatan (Aman Tanpa Ketergantungan Model Database)
    Route::get('/laporan-pendapatan', function (\Illuminate\Http\Request $request) {
    // 1. Ambil data tanggal dari filter browser (jika ada)
    $startDate = $request->input('start_date', date('Y-m-01'));
    $endDate = $request->input('end_date', date('Y-m-d'));
    $paket = $request->input('paket');
    $pembayaran = $request->input('pembayaran');

    // 2. Data simulasi transaksi Carwash Premium untuk Perusahaan
    $semuaData = collect([
        (object)[
            'kode_invoice' => 'INV-202605001',
            'created_at' => now()->parse('2026-05-15 10:14:00'),
            'nomor_polisi' => 'B 1234 ABC',
            'tipe_mobil' => 'Fortuner (SUV)',
            'paket_cuci' => 'premium',
            'metode_bayar' => 'QRIS',
            'total_bayar' => 150000
        ],
        (object)[
            'kode_invoice' => 'INV-202605002',
            'created_at' => now()->parse('2026-05-15 11:30:00'),
            'nomor_polisi' => 'D 9988 XYZ',
            'tipe_mobil' => 'Honda Jazz (Hatchback)',
            'paket_cuci' => 'reguler',
            'metode_bayar' => 'CASH',
            'total_bayar' => 60000
        ],
        (object)[
            'kode_invoice' => 'INV-202605003',
            'created_at' => now()->parse('2026-05-15 14:05:00'),
            'nomor_polisi' => 'B 8888 SSS',
            'tipe_mobil' => 'Alphard (MPV)',
            'paket_cuci' => 'coating',
            'metode_bayar' => 'TRANSFER',
            'total_bayar' => 2500000
        ],
    ]);

    // 3. Filter data secara otomatis berdasarkan input user di browser
    $filteredData = $semuaData->filter(function ($item) use ($paket, $pembayaran) {
        if ($paket && $item->paket_cuci !== $paket) return false;
        if ($pembayaran && strtolower($item->metode_bayar) !== strtolower($pembayaran)) return false;
        return true;
    });

    // 4. Hitung akumulasi angka metrik untuk kotak bagian atas
    $totalPendapatan = $filteredData->sum('total_bayar');
    $totalUnit = $filteredData->count();
    $rataRata = $totalUnit > 0 ? $totalPendapatan / $totalUnit : 0;

    // 5. Kirim data ke file template blade
    return view('laporan-pendapatan', [
        'semuaTransaksi' => $filteredData,
        'totalPendapatan' => $totalPendapatan,
        'totalUnit' => $totalUnit,
        'rataRata' => $rataRata,
        'startDate' => $startDate,
        'endDate' => $endDate
    ]);
})->name('laporan.pendapatan');

// Rute Pengaman Tambahan untuk tombol Export Excel
Route::get('/laporan-pendapatan/export', function () {
    return "Sistem Export Excel sedang dipersiapkan.";
})->name('laporan.pendapatan.export');
});

require __DIR__.'/auth.php';
