<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function create()
    {
        $transaksiTerbaru = \App\Models\Transaksi::latest()->paginate(5);
        // Sesuaikan path view dengan lokasi file kamu
        return view('transaksi.input-transaksi', compact('transaksiTerbaru'));
    }

    public function store(Request $request)
    {
        try {
    // 1. Validasi data input kasir
    // Pastikan total_bayar juga divalidasi agar tidak kosong/0
    $validator = \Validator::make($request->all(), [
        'nama_pelanggan'  => 'required|string|max:255',
        'plat_nomor'      => 'required|string|max:20',
        'jenis_kendaraan' => 'required|string|max:100',
        'paket_cuci'      => 'required|string',
        'total_bayar'     => 'required|numeric|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => 'Data tidak lengkap!'], 422);
    }

    // 2. Simpan ke database nyata
    // Kita langsung menggunakan $request->total_bayar yang sudah dihitung oleh JS
    Transaksi::create([
        'nama_pelanggan'  => $request->nama_pelanggan,
        'plat_nomor'      => $request->plat_nomor,
        'jenis_kendaraan' => $request->jenis_kendaraan,
        'paket_cuci'      => $request->paket_cuci,
        'total_bayar'     => $request->total_bayar,
        'status'          => 'ANTRIAN',
    ]);

    // 3. Memberikan respon JSON agar bisa ditangkap oleh fetch() di JavaScript
    return response()->json(['success' => true, 'message' => 'Transaksi berhasil tersimpan!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Server Error: ' . $e->getMessage()], 500);
        }
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
