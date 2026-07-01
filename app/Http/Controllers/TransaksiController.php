<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Reservation;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    // Update fungsi create di TransaksiController.php
    public function create() {
    // Ambil transaksi hari ini dari database
    $transaksiHariIni = Transaksi::whereDate('created_at', today())->get();

    // Kirim data ke view
    return view('transaksi.input-transaksi', compact('transaksiHariIni'));
    }

    // Proses Simpan
    public function store(Request $request) {

    // 1. Validasi
    $data = $request->validate([
        'nama_pelanggan'  => 'required',
        'plat_nomor'      => 'required',
        'jenis_kendaraan' => 'required',
        'total_bayar'     => 'required|integer',
        'no_hp'           => 'required'
    ]);

    // 2. Simpan ke tabel TRANSAKSIS (Hanya simpan data yang valid)
    $data['paket_cuci'] = 'REGULER WASH';
    $data['status'] = 'SELESAI';

    Transaksi::create($data);

    // 3. Simpan ke tabel RESERVATIONS (Gunakan data yang tadi divalidasi)
    \App\Models\Reservation::create([
        'nama_pelanggan'  => $data['nama_pelanggan'],
        'plat_nomor'      => $data['plat_nomor'],
        'no_hp'           => $data['no_hp'],
        'jenis_paket'     => 'REGULER WASH',
        'status'          => 'PENCUCIAN',
        'total_bayar'     => $data['total_bayar'],
        'created_at'      => now() // Ini yang akan jadi "Waktu Masuk"
    ]);

    return response()->json(['success' => true]);
    }

    // Update fungsi riwayat() di TransaksiController.php
    public function riwayat() {
    $dataFinance = \App\Models\Transaksi::orderBy('created_at', 'desc')->get()->map(function($item) {
        return [
            'tgl' => date('d', strtotime($item->created_at)), // e.g., "01"
            'bln' => date('m', strtotime($item->created_at)), // e.g., "06"
            'thn' => date('Y', strtotime($item->created_at)), // e.g., "2026"
            'nopol'    => $item->plat_nomor,
            'nama'     => $item->nama_pelanggan,
            'kategori' => $item->paket_cuci, // Harus ada agar tidak undefined
            'metode'   => 'TUNAI',          // Harus ada agar tidak undefined
            'nominal'  => (int)$item->total_bayar, // INI YANG DIBACA JS
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
            'nopol'    => $item->plat_nomor ?? '-',
            'nama'     => $item->nama_pelanggan ?? '-',
            'metode'   => 'TUNAI', // Sesuai kolom di JS
            'nominal'  => (int)$item->total_bayar,
        ];
    });

    return view('laporan-pendapatan', compact('dataFinance'));
    }

    public function createFromBooking($id) {
    $booking = Reservation::findOrFail($id);
    // Kirim data booking ke view agar form terisi otomatis
    return view('transaksi.input-transaksi', compact('booking'));
    }

    public function konfirmasiBooking(Request $request, $id) {
    $booking = \App\Models\Reservation::findOrFail($id);

    if ($request->action == 'terima') {
        // 1. Update status booking menjadi PENCUCIAN (agar masuk ke Progress)
        $booking->update(['status' => 'PENCUCIAN']);

        // 2. Data ini nantinya ditarik oleh sistem input transaksi
        return response()->json(['success' => true, 'message' => 'Booking diterima!']);
    } else {
        // Logika Tolak
        $booking->update(['status' => 'DITOLAK']);
        // Kirim notifikasi ke customer (bisa via WA API atau catatan di sistem)
        return response()->json(['success' => true, 'message' => 'Booking ditolak.']);
        }
    }
}
