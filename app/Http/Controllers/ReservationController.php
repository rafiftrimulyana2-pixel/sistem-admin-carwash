<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index()
    {
        // 1. Ambil DATA LENGKAP untuk Tabel (Bukan cuma angka)
        $antreanAktif = Reservation::where('status', 'PENCUCIAN')->orderBy('created_at', 'asc')->get();

        // 2. Hitung jumlah untuk angka di Kotak Statistik (Opsional, tapi bagus untuk tampilan)
        $jumlahAntrean = $antreanAktif->count();

        // 3. Ambil data statistik lainnya (Biarkan seperti yang kamu punya)
        $layananSelesai = Reservation::where('status', 'selesai')
            ->whereDate('updated_at', Carbon::today())
            ->count();

        $totalPelanggan = User::where('role', 'customer')->count();

        $omzetHariIni = Reservation::where('status', 'selesai')
            ->whereDate('updated_at', Carbon::today())
            ->sum('total_bayar');

        // 4. Kirimkan semua data ke dashboard
        return view('dashboard', compact(
            'antreanAktif',
            'layananSelesai',
            'totalPelanggan',
            'omzetHariIni'
        ));
    }

    public function statusProgress()
    {
        // Mengambil semua transaksi untuk dikelola di halaman progres
        $semuaTransaksi = \App\Models\Transaksi::latest()->get();

        return view('status_progress.index', compact('semuaTransaksi'));
    }

    // Tambahkan fungsi ini untuk menerima booking dari HP/Web Customer
    public function storeCustomerBooking(Request $request) {
        $data = $request->validate([
            'nama_pelanggan' => 'required',
            'plat_nomor'     => 'required',
            'total_bayar'    => 'required'
        ]);

        $data['status'] = 'PENDING'; // Status baru agar masuk list booking admin
        Reservation::create($data);

        return response()->json(['message' => 'Booking diterima!']);
    }

    public function apiGetReservations() {
    return response()->json(Reservation::all());
    }
}
