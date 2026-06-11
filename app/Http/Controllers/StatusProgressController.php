<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi; // Menembak ke database yang sama

class StatusProgressController extends Controller
{
    public function index()
    {
        // Ambil data kendaraan yang statusnya masih antri atau sedang dicuci
        // Dimulai dari kosong (0) sebelum kasir menginput data
        $antreanAktif = Transaksi::where('status', '!=', 'READY')
            ->where('status', '!=', 'FINISH')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('status-progress', compact('antreanAktif'));
    }
}
