<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function create()
    {
        return view('transaksi.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi data input kasir
        $request->validate([
            'nama_pelanggan'    => 'required',
            'plat_nomor'        => 'required',
            'jenis_kendaraan'   => 'required',
            'paket_cuci'        => 'required',
        ]);

        // 2. Simpan ke database nyata
        Transaksi::create([
            'nama_pelanggan'  => $request->nama_pelanggan,
            'plat_nomor'      => $request->plat_nomor,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'paket_cuci'      => $request->paket_cuci,
            'total_bayar'     => $request->paket_cuci == 'Premium Wash' ? 60000 : 45000, // Harga dinamis berdasarkan paket
            'status'          => 'ANTRIAN', // Default status awal saat masuk kasir
        ]);

        // 3. Kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Transaksi berhasil tersimpan! Data berelasi otomatis ke seluruh sistem.');
    }

    public function laporan()
    {
        // Mengambil seluruh data transaksi untuk laporan pendapatan
        $semuaTransaksi = Transaksi::orderBy('created_at', 'desc')->get();

        // Mapping data agar terbaca sempurna oleh grafik Javascript Laporan Pendapatan kamu
        $dataFinance = $semuaTransaksi->map(function($item) {
            return [
                'tgl'      => date('d', strtotime($item->created_at)),
                'bln'      => date('m', strtotime($item->created_at)),
                'thn'      => date('Y', strtotime($item->created_at)),
                'nopol'    => $item->plat_nomor,
                'nama'     => $item->nama_pelanggan,
                'metode'   => $item->metode_bayar ?? 'TUNAI',
                'nominal'  => (int)$item->total_bayar,
                'kategori' => $item->paket_cuci
            ];
        });

        return view('laporan-pendapatan', compact('dataFinance'));
    }
}
