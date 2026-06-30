<?php

namespace App\Http\Controllers;

use App\Models\Booking; // Pastikan Model ini sudah ada
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        // Ambil semua booking yang statusnya masih PENDING
        $bookings = \App\Models\Reservation::where('status', 'PENDING')->get();

        // Kirim data ke view 'booking-calendar'
        return view('booking-calendar', compact('bookings'));
    }

    public function verify($id)
    {
    // Gunakan Reservation
    $booking = \App\Models\Reservation::findOrFail($id);

    // Ubah status ke PENCUCIAN agar otomatis muncul di Dashboard
    $booking->status = 'PENCUCIAN';
    $booking->save();

    return response()->json(['success' => true]);
    }

    public function updateStatus(Request $request, $id) {
    // Gunakan model Reservation
    $reservation = \App\Models\Reservation::findOrFail($id);

    // Cukup update kolom status saja
    $reservation->status = $request->status;
    $reservation->save();

    return response()->json(['success' => true]);
    }
}
