<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function create()
    {
        // Memanggil file resources/views/transaksi/create.blade.php
        return view('transaksi.create');
    }

    public function store(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'nama_pelanggan'    => 'required',
            'plat_nomor'        => 'required',
            'jenis_kendaraan'   => 'required',
            'paket_cuci'        => 'required',
        ]);

        // 2. Simpan ke Database menggunakan Model Transaksi
        \App\Models\Transaksi::create([
            'nama_pelanggan'  => $request->nama_pelanggan,
            'plat_nomor'      => $request->plat_nomor,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'paket_cuci'      => $request->paket_cuci,
            'total_bayar'     => 45000, // Sementara dipatok dulu harganya
            'status'          => 'antri',
        ]);

        // 3. Balikkan ke halaman form dengan notifikasi sukses
        return redirect()->back()->with('success', 'Transaksi berhasil tersimpan!');
    }

    // 🔥 TAMBAHKAN FUNGSI INI DI BAGIAN BAWAH CONTROLLER KAMU 🔥
    public function laporan()
    {
        // 1. Ambil data transaksi dari database yang statusnya sudah selesai/terkonfirmasi
        // (Atau bisa pakai Transaksi::all() jika ingin menampilkan semua status)
        $semuaTransaksi = Transaksi::orderBy('created_at', 'desc')->get();

        // 2. Selaraskan nama kolom database kamu dengan variabel yang diminta oleh JavaScript Laporan
        $dataFinance = $semuaTransaksi->map(function($item) {
            return [
                'tgl'      => date('d', strtotime($item->created_at)),
                'bln'      => date('m', strtotime($item->created_at)),
                'thn'      => date('Y', strtotime($item->created_at)),
                'nopol'    => $item->plat_nomor,       // Menyesuaikan kolom 'plat_nomor' milikmu
                'nama'     => $item->nama_pelanggan,   // Menyesuaikan kolom 'nama_pelanggan' milikmu
                'metode'   => $item->metode_bayar ?? 'TUNAI', // Jika belum ada kolom metode di form, default ke TUNAI dulu
                'nominal'  => (int)$item->total_bayar, // Menyesuaikan kolom 'total_bayar' milikmu (Rp 45.000)
                'kategori' => $item->paket_cuci        // Menyesuaikan kolom 'paket_cuci' (reguler/premium/coating) untuk grafik
            ];
        });

        // 3. Panggil file blade laporan pendapatan sambil melempar data asli ($dataFinance)
        return view('laporan-pendapatan', compact('dataFinance'));
    }
}
