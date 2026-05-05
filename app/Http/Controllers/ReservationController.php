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
    // Mengambil data antrean yang masih berstatus 'proses'
    $antreanAktif = Reservation::where('status', 'proses')->count();

    // Mengambil jumlah layanan yang selesai khusus hari ini
    $layananSelesai = Reservation::where('status', 'selesai')
                        ->whereDate('updated_at', Carbon::today())
                        ->count();

    // Mengambil total pelanggan (User dengan role customer)
    $totalPelanggan = User::where('role', 'customer')->count();

    // Menjumlahkan total bayar dari layanan yang selesai hari ini
    $omzetHariIni = Reservation::where('status', 'selesai')
                        ->whereDate('updated_at', Carbon::today())
                        ->sum('total_bayar');

    // Mengirimkan semua data di atas ke file view dashboard
    return view('dashboard', compact(
        'antreanAktif',
        'layananSelesai',
        'totalPelanggan',
        'omzetHariIni'
    ));
    }
}
