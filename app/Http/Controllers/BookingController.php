<?php

namespace App\Http\Controllers;
use App\Models\Reservation;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        // Ambil semua booking yang statusnya masih PENDING
        $bookings = \App\Models\Reservation::where('status', 'PENDING')->get()->map(function($b) {
        return [
            'id'       => $b->id,
            'name'     => $b->nama_pelanggan,
            'car'      => $b->jenis_kendaraan ?? 'Mobil',
            'time'     => \Carbon\Carbon::parse($b->created_at)->format('H:i'),
            'location' => $b->lokasi_customer ?? 'Lokasi tidak tersedia',
            'wa'       => $b->no_hp,
            'code'     => 'BKG-' . $b->id,
            'service'  => $b->jenis_paket,
            'price'    => number_format($b->total_bayar, 0, ',', '.'),
            'color'    => 'bg-blue-600',
            'initials' => substr($b->nama_pelanggan, 0, 2)
            ];
        });

        // Kirim data ke view 'booking-calendar'
        return view('booking-calendar', compact('bookings'));
    }

    public function verify($id)
    {
    // Gunakan Reservation
    $booking = \App\Models\Reservation::findOrFail($id);

    // Ubah status ke PENCUCIAN agar otomatis muncul di Dashboard
    $booking->update([
        'status' => 'PENCUCIAN',
        'step'   => 1
    ]);

    return response()->json(['success' => true]);
    }
    
}
