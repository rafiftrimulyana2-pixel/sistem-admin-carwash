<?php

namespace App\Http\Controllers;

use App\Models\Booking; // Pastikan Model ini sudah ada
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        // Ambil semua data dari tabel bookings
        $bookings = Booking::all();

        // Kirim data ke view 'booking-calendar'
        return view('booking-calendar', compact('bookings'));
    }
    public function verify($id)
    {
    $booking = Booking::find($id);
    $booking->status = 'confirmed'; // Booking diterima
    $booking->progress_status = 'sedang_dikerjakan'; // Masuk ke tabel Status Progress
    $booking->save();
    return response()->json(['success' => true]);
    }
    public function updateStatus(Request $request, $id) {
    $booking = Booking::findOrFail($id);
    $booking->status = 'confirmed'; // Booking diterima
    $booking->progress_status = 'antrean'; // Masuk ke antrean progres
    $booking->save();
    return response()->json(['success' => true]);
    }
}
