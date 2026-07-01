<?php

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $data = $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:customers',
            'no_hp' => 'required',
            'no_plat' => 'required',
            'password' => 'required'
        ]);

        $data['password'] = Hash::make($data['password']);
        Customer::create($data);

    return redirect('/')->with('success', 'Berhasil Daftar!');
    }

    public function login(Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (auth()->guard('customer')->attempt($credentials)) {
        return redirect('/beranda');
    }

    return back()->withErrors(['email' => 'Email atau password salah!']);
    }

    public function logout(Request $request)
    {
        auth()->guard('customer')->logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
