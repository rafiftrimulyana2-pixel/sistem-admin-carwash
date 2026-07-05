<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation; // Gunakan model Booking agar sinkron dengan kalender

class StatusProgressController extends Controller
{
    public function index()
    {
        // 1. Data untuk kartu (Hanya yang belum selesai agar data berpindah saat selesai)
        $bookings = \App\Models\Reservation::where('step', '<', 7)
                    ->orderBy('created_at', 'asc')
                    ->get();

        // Definisikan $steps di sini agar bisa dipakai di Blade
        $steps = [
            ['label'=>'Daftar', 'icon'=>'clipboard-list'],
            ['label'=>'Pre-Wash', 'icon'=>'droplets'],
            ['label'=>'Cuci', 'icon'=>'waves'],
            ['label'=>'Wax/Poles', 'icon'=>'sparkles'],
            ['label'=>'Pengeringan', 'icon'=>'wind'],
            ['label'=>'Inspeksi', 'icon'=>'search'],
            ['label'=>'Selesai', 'icon'=>'check-circle']
        ];

        // 3. Menghitung statistik berdasarkan database
        $totalOrder = \App\Models\Reservation::where('step', '<', 7)->count();
        $sedangCuci = \App\Models\Reservation::where('step', 2)->count();
        $antrean = \App\Models\Reservation::where('step', 1)->count();
        $selesai = \App\Models\Reservation::where('step', 7)->count();

        return view('status-progress', compact('bookings', 'totalOrder', 'sedangCuci', 'antrean', 'selesai', 'steps'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['step' => 'required|integer']);

        $booking = \App\Models\Reservation::findOrFail($id);
        $booking->step = $request->step;

        // Opsional: set status teks berdasarkan step
        $booking->status = ($request->step == 7) ? 'Selesai' : 'Proses';
        $booking->save();

        return response()->json(['success' => true]);
    }
}
