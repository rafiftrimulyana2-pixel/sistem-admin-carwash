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
        'total_bayar'     => 45000,                         // Sementara dipatok dulu harganya
        'status'          => 'antri',
        ]);

    // 3. Balikkan ke halaman form dengan notifikasi sukses
    return redirect()->back()->with('success', 'Transaksi berhasil tersimpan!');
    }
}
