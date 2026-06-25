<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    // Halaman Input
    public function create() { return view('transaksi.input-transaksi'); }

    // Proses Simpan
    public function store(Request $request) {
    $data = $request->validate([
        'nama_pelanggan'  => 'required',
        'plat_nomor'      => 'required',
        'jenis_kendaraan' => 'required',
        'total_bayar'     => 'required|numeric',
    ]);

    // Tambahkan default agar tidak kosong
    $data['paket_cuci'] = 'REGULER WASH';
    $data['status'] = 'LUNAS'; // Sesuaikan statusnya

    Transaksi::create($data);
    return response()->json(['success' => true]);
    }

    // Update fungsi riwayat() di TransaksiController.php
    public function riwayat() {
    $dataFinance = Transaksi::orderBy('created_at', 'desc')->get()->map(function($item) {
        return [
            'nopol'   => $item->plat_nomor, // Pastikan ini sesuai
            'nama'    => $item->nama_pelanggan,
            'kategori'=> $item->paket_cuci,
            'nominal' => $item->total_bayar,
            'metode'  => 'TUNAI'
        ];
    });
    return view('riwayat-servis', compact('dataFinance'));
    }

    public function laporan()
    {
    // Ambil data dan pastikan relasinya lengkap
    $semuaTransaksi = Transaksi::orderBy('created_at', 'desc')->get();

    $dataFinance = $semuaTransaksi->map(function($item) {
        return [
            'tgl'      => date('d', strtotime($item->created_at)),
            'bln'      => date('m', strtotime($item->created_at)),
            'thn'      => date('Y', strtotime($item->created_at)),
            'nopol'    => $item->plat_nomor,
            'nama'     => $item->nama_pelanggan,
            'metode'   => 'TUNAI', // Sesuai kolom di JS
            'nominal'  => (int)$item->total_bayar,
        ];
    });

    return view('laporan-pendapatan', compact('dataFinance'));
    }
}
