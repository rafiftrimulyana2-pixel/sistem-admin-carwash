@extends('customer.layout')
@section('content')
<div class="min-h-screen bg-slate-50 flex items-center justify-center p-4 font-['Inter',sans-serif]">

    <div class="w-full max-w-[400px] bg-white rounded-[32px] p-8 shadow-sm border border-slate-100">

        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Daftar Akun</h1>
                <p class="text-slate-500 text-sm">Buat akun untuk booking cuci mobil</p>
            </div>
            <div class="bg-indigo-100 p-3 rounded-2xl">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
        </div>

        <form method="POST" action="{{ route('customer.register.process') }}" class="space-y-4">
            @csrf

            <div class="space-y-4">
                <input type="text" name="nama" placeholder="Nama Lengkap" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm" required>

                <input type="email" name="email" placeholder="Alamat Email" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm" required>

                <div class="grid grid-cols-2 gap-3">
                    <input type="text" name="no_hp" placeholder="No. Telepon" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm" required>
                    <input type="text" name="no_plat" placeholder="No. Plat Mobil" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm" required>
                </div>

                <input type="password" name="password" placeholder="Password" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm" required>
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm" required>
            </div>

            <label class="flex items-center gap-2 text-xs text-slate-500 mt-2">
                <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500" required>
                <span>Saya setuju dengan Syarat & Ketentuan</span>
            </label>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-2xl font-bold shadow-lg shadow-indigo-200 transition-all active:scale-[0.98]">
                Daftar
            </button>
        </form>

        <p class="text-center mt-6 text-sm text-slate-500">
            Sudah punya akun? <a href="/" class="text-indigo-600 font-bold hover:underline">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection
