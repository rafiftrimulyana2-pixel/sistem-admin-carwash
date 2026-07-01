@extends('customer.layout')
@section('content')
<div class="h-screen flex flex-col bg-blue-600 font-['Inter',sans-serif] overflow-hidden">

    <!-- HEADER: Dibuat sebagai wadah tunggal agar logo bisa di tengah -->
    <div class="h-1/3 flex flex-col items-center justify-center relative">
        <!-- Logo di tengah area biru dengan margin bawah yang cukup -->
        <div class="bg-white p-5 rounded-full shadow-lg z-20 mb-4">
            <svg class="w-12 h-12 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
        </div>

        <!-- Gelombang ditempatkan di posisi absolute paling bawah -->
        <svg class="absolute bottom-0 w-full h-16 text-white" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path fill="currentColor" d="M0,192L48,186.7C96,181,192,171,288,181.3C384,192,480,224,576,224C672,224,768,192,864,186.7C960,181,1056,203,1152,213.3C1248,224,1344,224,1392,224L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>

    <!-- CONTAINER PUTIH: Sisa ruang layar -->
    <div class="bg-white flex-grow px-8 pt-2 pb-6 flex flex-col">
        <!-- Konten form tetap sama... -->
        <div class="text-center mb-4">
            <h1 class="text-3xl font-black text-blue-600 leading-tight drop-shadow-[0_2px_2px_rgba(0,0,0,0.15)]">Selamat Datang</h1>
            <p class="text-blue-500 font-bold text-sm mt-0.5">Silakan masuk untuk melanjutkan</p>
        </div>

        <form method="POST" action="{{ route('customer.login.process') }}" class="space-y-4">
            @csrf

            <div class="space-y-1">
                <label class="text-[10px] font-bold text-slate-700 uppercase ml-1">EMAIL / NO. HP</label>
                <div class="relative">
                    <input type="text" name="email" class="w-full p-4 pl-4 bg-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-blue-500 font-medium text-slate-800 text-sm" placeholder="Contoh: user@mail.com" required>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-bold text-slate-700 uppercase ml-1">KATA SANDI</label>
                <div class="relative">
                    <input type="password" name="password" class="w-full p-4 pl-4 bg-slate-100 rounded-2xl outline-none focus:ring-2 focus:ring-blue-500 font-medium text-slate-800 text-sm" placeholder="••••••••" required>
                </div>
                <div class="text-right mt-1">
                    <a href="#" class="text-[11px] font-black text-blue-600 underline">Lupa Kata Sandi?</a>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-black text-sm shadow-lg shadow-blue-200 active:scale-[0.98] transition-all mt-2">
                MASUK SEKARANG
            </button>
        </form>

        <!-- Teks bawah ukuran sedang -->
        <p class="text-center mt-6 text-sm font-bold text-slate-700">
            Belum punya akun? <a href="/registrasi" class="text-blue-600 font-black underline text-sm">Daftar sekarang</a>
        </p>
    </div>
</div>
@endsection
