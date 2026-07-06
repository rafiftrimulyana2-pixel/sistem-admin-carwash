<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer; 
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi input dari Flutter
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Cari customer berdasarkan email
        $customer = Customer::where('email', $request->email)->first();

        // 3. Cek password
        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        // 4. Jika sukses, kirim balik data customer dalam format JSON
        return response()->json([
            'message' => 'Login Berhasil',
            'data' => $customer
        ], 200);
    }
}
