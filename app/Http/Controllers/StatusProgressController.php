<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusProgressController extends Controller
{
    public function index()
    {
        // Data contoh agar tampilan tidak kosong
        $antreanAktif = [
            (object)[
                'nama_pelanggan' => 'Budi Santoso',
                'plat_nomor' => 'B 1234 ABC',
                'jenis_paket' => 'Premium Wash',
                'progres' => 75,
                'status' => 'Sedang Dikerjakan'
            ],
            (object)[
                'nama_pelanggan' => 'Andi Wijaya',
                'plat_nomor' => 'D 8899 XYZ',
                'jenis_paket' => 'Regular Wash',
                'progres' => 30,
                'status' => 'Menunggu Antrean'
            ]
        ];

        return view('status-progress', compact('antreanAktif'));
    }
}
