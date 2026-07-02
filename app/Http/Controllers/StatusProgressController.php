<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; // Gunakan model Booking agar sinkron dengan kalender

class StatusProgressController extends Controller
{
    public function index()
    {
        // Mengambil booking yang sudah diverifikasi ('confirmed') atau sedang dalam proses (PENCUCIAN, PENGERINGAN, dll)
        $bookings = \App\Models\Reservation::whereIn('status', ['antrean', 'proses', 'PENCUCIAN'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('status-progress', compact('bookings'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $booking = \App\Models\Reservation::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        return response()->json(['success' => true, 'message' => 'Status berhasil diupdate']);
    }
}
