<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaksi; // Kita fokuskan hanya menggunakan satu jantung model: Transaksi
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. KOTAK 1 & TABEL BAWAH: Ambil antrean unit dari database yang belum selesai
        $antreanAktif = Transaksi::whereNotIn('status', ['READY', 'FINISH'])
            ->orderBy('created_at', 'asc')
            ->get();

        // 2. KOTAK 2: Hitung jumlah layanan selesai (LUNAS/READY) khusus HARI INI
        $layananSelesai = Transaksi::whereDate('created_at', Carbon::today())
            ->where(function($query) {
                $query->where('status', 'READY')->orWhere('status', 'FINISH');
            })->count();

        // 3. KOTAK 3: Total pelanggan unik dari tabel transaksi
        $totalPelanggan = Transaksi::distinct('nama_pelanggan')->count('nama_pelanggan');

        // 4. KOTAK 4: Total uang masuk (omzet) dari transaksi hari ini
        $omzetHariIni = Transaksi::whereDate('created_at', Carbon::today())
            ->sum('total_bayar');

        // 5. LONCENG NOTIFIKASI: Fallback stok bahan kritis (Bila model Stok sudah ada)
        $stokKritis = class_exists('\App\Models\Stok')
            ? \App\Models\Stok::where('stok', '<=', 5)->get()
            : collect([]);

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
