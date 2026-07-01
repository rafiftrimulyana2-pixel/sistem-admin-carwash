<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;// Pastikan Anda menggunakan model User atau buat model Customer

class CustomerController extends Controller
{
    // Fungsi untuk menampilkan form registrasi
    public function showRegister()
    {
        return view('customer.registrasi'); // Sesuaikan dengan nama file view Anda
    }

    // Fungsi untuk memproses data yang dikirim dari form
    public function registerProcess(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|max:255|unique:customers,email',
            'no_hp' => 'required|string|max:20',
            'no_plat' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed', // 'confirmed' artinya akan mengecek field 'password_confirmation'
        ]);

        // 2. Simpan ke database
        Customer::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp'    => $request->no_hp,
            'no_plat'  => $request->no_plat,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password), // Password di-hash (enkripsi) agar aman
        ]);

        // 3. Arahkan kembali ke halaman login dengan pesan sukses
        return redirect('/')->with('success', 'Akun berhasil dibuat! Silakan masuk.');
    }

    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
        ]);

        // 2. Coba proses login (asumsi menggunakan guard 'customer')
        if (Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate();

        return redirect()->intended('/beranda');
    }

    return back()->withErrors([
        'email' => 'Email atau Password salah.',
        ]);
    }
}
