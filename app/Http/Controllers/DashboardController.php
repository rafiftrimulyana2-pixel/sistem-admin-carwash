<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. KOTAK 1 & TABEL BAWAH: Ambil antrean unit dari database yang belum selesai
        $antreanAktif = \App\Models\Reservation::where('step', '<', 7)->get();

        // 2. KOTAK 2: Hitung jumlah layanan selesai (LUNAS/READY) khusus HARI INI
        $layananSelesai = \App\Models\Reservation::where('step', 7)->count();

        // 3. KOTAK 3: Total pelanggan unik dari tabel transaksi
        $totalPelanggan = \App\Models\Reservation::count();

        // 4. KOTAK 4: Total uang masuk (omzet) dari transaksi hari ini
        $omzetHariIni = \App\Models\Transaksi::whereDate('created_at', \Carbon\Carbon::today()) ->sum('total_bayar');

        // 5. LONCENG NOTIFIKASI: Fallback stok bahan kritis (Bila model Stok sudah ada)
        $stokKritis = \App\Models\Bahan::where('stok', '<=', 5)->get();

        // Mengirimkan semua data nyata (dimulai dari 0 jika database kosong)
        return view('dashboard', compact(
            'antreanAktif',
            'layananSelesai',
            'totalPelanggan',
            'omzetHariIni',
            'stokKritis'
        ));
    }
}
