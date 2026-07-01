@extends('customer.layout')

@section('content')
<div class="min-h-screen bg-slate-50 font-['Inter',sans-serif] pb-24">

    <!-- Bagian Atas: Gradient Hero -->
    <div class="bg-gradient-to-br from-indigo-600 to-blue-700 p-8 rounded-b-[40px] text-white shadow-xl">
        <!-- Profile & Notification -->
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center font-bold">
                    {{ substr(auth()->guard('customer')->user()->nama, 0, 1) }}
                </div>
                <div>
                    <p class="text-indigo-200 text-xs">Selamat Datang</p>
                    <h3 class="font-bold text-lg">{{ auth()->guard('customer')->user()->nama }}</h3>
                </div>
            </div>
            <button class="bg-white/20 p-2 rounded-full">🔔</button>
        </div>

        <!-- Hero Card (Ganti Saldo dengan Status Booking) -->
        <div class="bg-white/10 backdrop-blur-md p-6 rounded-3xl border border-white/20">
            <p class="text-indigo-100 text-sm">Status Mobil Anda</p>
            <h2 class="text-3xl font-black mt-1">Sedang Dicuci</h2>
            <div class="flex gap-4 mt-6">
                <button class="flex-1 bg-white text-indigo-600 py-3 rounded-2xl font-black text-sm">Booking Baru</button>
                <button class="flex-1 bg-indigo-500 text-white py-3 rounded-2xl font-black text-sm">Lihat Detail</button>
            </div>
        </div>
    </div>

    <!-- Bagian Tengah: Menu Favorit -->
    <div class="p-6">
        <h4 class="font-bold text-slate-800 mb-4">Layanan Favorit</h4>
        <div class="grid grid-cols-4 gap-3">
            <div class="flex flex-col items-center gap-2">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-sm">🧼</div>
                <span class="text-[10px] font-bold text-slate-600">Cuci</span>
            </div>
            <div class="flex flex-col items-center gap-2">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-sm">✨</div>
                <span class="text-[10px] font-bold text-slate-600">Wax</span>
            </div>
            <div class="flex flex-col items-center gap-2">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-sm">🛠️</div>
                <span class="text-[10px] font-bold text-slate-600">Detailing</span>
            </div>
            <div class="flex flex-col items-center gap-2">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-sm">⚙️</div>
                <span class="text-[10px] font-bold text-slate-600">Lainnya</span>
            </div>
        </div>
    </div>

    <!-- Bagian Bawah: Riwayat -->
    <div class="px-6">
        <div class="flex justify-between items-center mb-4">
            <h4 class="font-bold text-slate-800">Riwayat Terakhir</h4>
            <a href="#" class="text-indigo-600 text-xs font-bold">Lihat Semua</a>
        </div>

        <div class="bg-white p-4 rounded-2xl flex items-center justify-between shadow-sm mb-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-50 rounded-full flex items-center justify-center">✅</div>
                <div>
                    <p class="text-xs font-bold">Cuci Premium</p>
                    <p class="text-[10px] text-slate-400">Hari ini, 09:30</p>
                </div>
            </div>
            <p class="text-xs font-bold text-indigo-600">+Rp 75.000</p>
        </div>
    </div>
</div>
@endsection
