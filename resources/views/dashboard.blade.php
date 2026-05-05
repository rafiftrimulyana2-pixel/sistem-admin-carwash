@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');

    body { font-family: 'Inter', sans-serif; background-color: #fcfcfd; }
    .font-inter-bold { font-weight: 700; }
    .font-inter-black { font-weight: 800; }

    /* Container Adjustment */
    .dashboard-container { margin: -25px -25px 0 -25px; }

    /* Header Biru Melengkung (Ukuran Sedang) */
    .header-bg {
        background: linear-gradient(135deg, #624bff 0%, #4f39e3 100%);
        height: 220px;
        padding: 40px 30px;
        margin-bottom: -110px;
        border-bottom-left-radius: 40px;
        border-bottom-right-radius: 40px;
        box-shadow: 0 10px 25px -5px rgba(98, 75, 255, 0.3);
    }

    /* Modern Figma Style Card */
    .figma-card {
        background: white;
        border-radius: 24px;
        padding: 24px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    .figma-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.1); }

    /* Icon Glow Effects */
    .icon-box {
        width: 48px; height: 48px;
        border-radius: 16px;
        display: flex; items-center; justify-content: center;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
    }
    .icon-blue { background: #eef2ff; color: #6366f1; }
    .icon-green { background: #f0fdf4; color: #22c55e; }
    .icon-purple { background: #f5f3ff; color: #8b5cf6; }
    .icon-orange { background: #fff7ed; color: #f97316; }

    /* Empty State Glow */
    .empty-pulse {
        width: 8px; h-8px; background: #e2e8f0; border-radius: 50%;
    }
</style>

<div class="dashboard-container">
    <!-- Header Vibrant -->
    <div class="header-bg flex justify-between items-start">
        <div class="div">
    <!-- Teks atas: Dirubah jadi lebih taktis -->
    <p class="text-white/70 text-[10px] font-inter-bold uppercase tracking-[0.3em] mb-2">
        Command Center Monitoring
    </p>

    <!-- Judul Utama: Sapaan yang lebih "Cowok" & Ukuran sedang (text-2xl) -->
    <h1 class="text-white text-2xl font-inter-black tracking-tight leading-none uppercase">
        Halo, Selamat Beraktivitas Chief!
    </h1>
    </div>
        <div class="flex gap-3">
            <button class="bg-white/10 hover:bg-white/20 border border-white/20 text-white px-4 py-2 rounded-xl font-inter-bold text-[10px] backdrop-blur-md uppercase tracking-widest transition">Update Data</button>
            <button class="bg-white text-[#624bff] px-6 py-2 rounded-xl font-inter-bold text-[10px] shadow-xl hover:scale-105 transition-all uppercase tracking-widest">+ Unit Baru</button>
        </div>
    </div>

    <div class="px-8">
    <!-- Grid 4 Kolom: Rapi dan Sejajar -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

        <!-- KOTAK 1: ANTRIAN UNIT -->
        <div onclick="this.classList.add('scale-95'); setTimeout(() => this.classList.remove('scale-95'), 150)"
             class="bg-white rounded-[24px] p-5 border border-gray-100 shadow-sm cursor-pointer transition-all duration-500 hover:shadow-2xl hover:shadow-blue-200 hover:-translate-y-2 group h-[155px] flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <!-- Kotak Icon Hidup (Warna Solid & Glow) -->
                <div class="w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center shadow-[0_8px_20px_rgba(37,99,235,0.4)] group-hover:scale-110 transition-transform duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-[7px] font-inter-black text-blue-600 bg-blue-50 px-2 py-1 rounded-md uppercase tracking-widest mb-1">Status</span>
                    <div class="flex items-center space-x-1">
                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>
                        <span class="text-[8px] font-inter-bold text-blue-500 uppercase italic">Terpantau</span>
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-4xl font-inter-black text-slate-800 leading-none tracking-tighter">{{ count($antreanAktif ?? []) }}</h3>
                <p class="text-[10px] font-inter-bold text-slate-400 uppercase mt-1 tracking-widest">Antrian Unit Berjalan</p>
            </div>
        </div>

        <!-- KOTAK 2: TOTAL SELESAI -->
        <div onclick="this.classList.add('scale-95'); setTimeout(() => this.classList.remove('scale-95'), 150)"
             class="bg-white rounded-[24px] p-5 border border-gray-100 shadow-sm cursor-pointer transition-all duration-500 hover:shadow-2xl hover:shadow-emerald-200 hover:-translate-y-2 group h-[155px] flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-[0_8px_20px_rgba(16,185,129,0.4)] group-hover:scale-110 transition-transform duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-[7px] font-inter-black text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md uppercase tracking-widest">Target Hari Ini</span>
            </div>
            <div>
                <h3 class="text-4xl font-inter-black text-slate-800 leading-none tracking-tighter">{{ $layananSelesai }}</h3>
                <p class="text-[10px] font-inter-bold text-slate-400 uppercase mt-1 tracking-widest">Layanan Unit Selesai</p>
            </div>
        </div>

        <!-- KOTAK 3: TOTAL PELANGGAN -->
        <div onclick="this.classList.add('scale-95'); setTimeout(() => this.classList.remove('scale-95'), 150)"
             class="bg-white rounded-[24px] p-5 border border-gray-100 shadow-sm cursor-pointer transition-all duration-500 hover:shadow-2xl hover:shadow-violet-200 hover:-translate-y-2 group h-[155px] flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-violet-600 text-white rounded-2xl flex items-center justify-center shadow-[0_8px_20px_rgba(124,58,237,0.4)] group-hover:scale-110 transition-transform duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <span class="text-[7px] font-inter-black text-violet-600 bg-violet-50 px-2 py-1 rounded-md uppercase tracking-widest">Customer</span>
            </div>
            <div>
                <h3 class="text-4xl font-inter-black text-slate-800 leading-none tracking-tighter">{{ $totalPelanggan }}</h3>
                <p class="text-[10px] font-inter-bold text-slate-400 uppercase mt-1 tracking-widest">Total Pelanggan</p>
            </div>
        </div>

        <!-- KOTAK 4: PENDAPATAN -->
        <div onclick="this.classList.add('scale-95'); setTimeout(() => this.classList.remove('scale-95'), 150)"
             class="bg-white rounded-[24px] p-5 border border-gray-100 shadow-sm cursor-pointer transition-all duration-500 hover:shadow-2xl hover:shadow-orange-200 hover:-translate-y-2 group h-[155px] flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-orange-500 text-white rounded-2xl flex items-center justify-center shadow-[0_8px_20px_rgba(249,115,22,0.4)] group-hover:scale-110 transition-transform duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-[7px] font-inter-black text-orange-600 bg-orange-50 px-2 py-1 rounded-md uppercase tracking-widest">Keuangan</span>
            </div>
            <div>
                <h3 class="text-2xl font-inter-black text-slate-800 leading-none tracking-tighter">Rp {{ number_format($omzetHariIni, 0, ',', '.') }}</h3>
                <p class="text-[10px] font-inter-bold text-slate-400 uppercase mt-1 tracking-widest">Omzet Pendapatan Hari Ini</p>
                    </div>
             </div>

         </div>
    </div>

    <!-- GRID BAWAH: Antrian & Informasi (items-start agar card kanan tidak melar) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6 pb-10 items-start">

    <!-- 1. DAFTAR ANTRIAN UNIT (KIRI) - REVISI TABEL VIBRANT -->
    <div class="lg:col-span-2 bg-white rounded-[30px] border border-gray-100 shadow-sm overflow-hidden flex flex-col h-[420px] transition-all duration-300 hover:shadow-xl">
        <!-- Header Tabel -->
        <div class="px-7 py-5 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
            <div class="flex items-center space-x-3">
                <div class="w-1.5 h-6 bg-blue-600 rounded-full"></div>
                <h4 class="text-[11px] font-inter-bold text-gray-800 uppercase tracking-widest">Daftar Antrean Unit</h4>
            </div>
            <span class="text-[9px] font-inter-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full uppercase italic tracking-wider">
                0 Unit Terpantau
            </span>
        </div>

    <!-- Area Tabel -->
    <div class="flex-1 overflow-y-auto p-4">
        <table class="w-full text-left border-separate border-spacing-y-2">
            <thead>
                <tr class="text-[9px] font-inter-bold text-slate-400 uppercase tracking-[0.2em]">
                    <th class="px-4 pb-2">Pelanggan</th>
                    <th class="px-4 pb-2">Plat Nomor</th>
                    <th class="px-4 pb-2">Paket</th>
                    <th class="px-4 pb-2 text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($antreanAktif ?? [] as $row)
                <tr class="group hover:bg-blue-50/50 transition-all duration-300">
                    <td class="px-4 py-3 bg-gray-50/50 group-hover:bg-transparent rounded-l-xl">
                        <p class="text-[10px] font-inter-black text-slate-700 uppercase leading-none">{{ $row->nama_pelanggan }}</p>
                    </td>
                    <td class="px-4 py-3 bg-gray-50/50 group-hover:bg-transparent">
                        <span class="text-[10px] font-inter-bold text-blue-600 tracking-wider">{{ $row->plat_nomor }}</span>
                    </td>
                    <td class="px-4 py-3 bg-gray-50/50 group-hover:bg-transparent">
                        <span class="text-[9px] font-inter-bold text-slate-500 uppercase">{{ $row->jenis_paket }}</span>
                    </td>
                    <td class="px-4 py-3 bg-gray-50/50 group-hover:bg-transparent rounded-r-xl text-center">
                        <span class="px-2 py-1 {{ $row->status == 'proses' ? 'bg-orange-100 text-orange-600' : 'bg-blue-100 text-blue-600' }} rounded-md text-[8px] font-inter-black uppercase tracking-tighter">
                            {{ $row->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-20 text-center opacity-30 italic text-[10px] font-inter-bold uppercase tracking-widest text-gray-500">
                        Belum ada unit yang terdaftar
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

        <!-- SLOT BOOKING (DESAIN VIBRANT 3 SHIFT) -->
        <div class="figma-card h-auto p-6 shadow-xl border-t-4 border-t-blue-600">
    <div class="flex justify-between items-center mb-6 border-b border-gray-50 pb-4">
        <div>
            <h4 class="text-[10px] font-inter-black text-gray-800 uppercase tracking-[0.2em]">Slot Booking</h4>
            <p class="text-[8px] font-inter-bold text-gray-400 uppercase italic">Update: {{ date('H:i') }} WIB</p>
        </div>
        <div class="text-right">
            <p class="text-[11px] font-inter-black text-blue-600 uppercase">{{ date('d M Y') }}</p>
            <div class="flex items-center justify-end mt-1">
                <span class="w-2 h-2 bg-green-500 rounded-full mr-1 animate-ping"></span>
                <span class="text-[8px] font-inter-bold text-green-500 uppercase">System Open</span>
            </div>
        </div>
    </div>

    <div class="space-y-3">
        <!-- Shift Pagi (Biru Cerah) -->
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-500 to-blue-400 p-4 rounded-2xl shadow-md group hover:scale-[1.02] transition-all cursor-pointer">
            <div class="absolute -right-4 -top-4 opacity-10 group-hover:rotate-12 transition-transform">
                <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="flex justify-between items-center relative z-10">
                <div class="flex items-center space-x-3 text-white">
                    <div class="p-2 bg-white/20 rounded-xl backdrop-blur-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1m9-9h-1M4 11H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707"></path></svg>
                    </div>
                    <div>
                        <p class="text-[8px] font-inter-black uppercase text-blue-50 leading-none mb-1">Morning Shift</p>
                        <p class="text-[10px] font-inter-black">08:00 - 12:00 WIB</p>
                    </div>
                </div>
                <span class="text-[8px] font-inter-black text-blue-600 bg-white px-2.5 py-1 rounded-lg uppercase italic shadow-sm">Available</span>
            </div>
        </div>

        <!-- Shift Sore (Oranye Matahari) -->
        <div class="relative overflow-hidden bg-gradient-to-r from-orange-500 to-amber-400 p-4 rounded-2xl shadow-md group hover:scale-[1.02] transition-all cursor-pointer">
            <div class="absolute -right-4 -top-4 opacity-10 group-hover:rotate-12 transition-transform">
                <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v2a1 1 0 102 0V5zm-4 2a1 1 0 10-1.414-1.414L4.172 5.004A1 1 0 102.758 6.418L4.172 7.832A1 1 0 005.586 6.418L4.172 5.004zM5 10a1 1 0 100-2H3a1 1 0 000 2h2zm2 4.586A1 1 0 016.414 16L5.004 14.586A1 1 0 016.418 13.172L7.832 14.586A1 1 0 016.418 16zM11 15a1 1 0 10-2 0v2a1 1 0 102 0v-2zm4.586-2A1 1 0 0116 13.586L14.586 15a1 1 0 01-1.414-1.414L14.586 13.586zM17 10a1 1 0 100-2h-2a1 1 0 100 2h2zm-2.414-4.586A1 1 0 1116 4.172L14.586 2.758A1 1 0 1116 1.344L17.414 2.758A1 1 0 1116 4.172z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="flex justify-between items-center relative z-10">
                <div class="flex items-center space-x-3 text-white">
                    <div class="p-2 bg-white/20 rounded-xl backdrop-blur-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1m9-9h-1M4 11H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707"></path></svg>
                    </div>
                    <div>
                        <p class="text-[8px] font-inter-black uppercase text-orange-50 leading-none mb-1">Afternoon Shift</p>
                        <p class="text-[10px] font-inter-black">13:00 - 17:00 WIB</p>
                    </div>
                </div>
                <span class="text-[8px] font-inter-black text-orange-600 bg-white px-2.5 py-1 rounded-lg uppercase italic shadow-sm">Available</span>
            </div>
        </div>

        <!-- Shift Malam (Ungu Gelap/Deep Blue) -->
        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-700 to-purple-600 p-4 rounded-2xl shadow-md group hover:scale-[1.02] transition-all cursor-pointer">
            <div class="absolute -right-4 -top-4 opacity-20 group-hover:rotate-12 transition-transform">
                <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            </div>
            <div class="flex justify-between items-center relative z-10">
                <div class="flex items-center space-x-3 text-white">
                    <div class="p-2 bg-white/10 rounded-xl backdrop-blur-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[8px] font-inter-black uppercase text-indigo-100 leading-none mb-1">Night Shift</p>
                        <p class="text-[10px] font-inter-black">18:00 - 21:00 WIB</p>
                    </div>
                </div>
                <span class="text-[8px] font-inter-black text-indigo-700 bg-white px-2.5 py-1 rounded-lg uppercase italic shadow-sm">Available</span>
            </div>
        </div>
    </div>

    <!-- TOTAL SLOT (Warna Hidup & Bold) -->
    <div class="mt-6 p-4 rounded-2xl bg-gradient-to-br from-gray-900 to-gray-800 border-b-4 border-b-blue-600 shadow-xl relative overflow-hidden">
        <div class="absolute right-0 bottom-0 opacity-10">
            <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
        </div>
        <div class="flex justify-between items-center relative z-10">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/50">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <p class="text-[9px] font-inter-black text-blue-400 uppercase tracking-widest leading-none mb-1">Kapasitas Slot</p>
                    <p class="text-xs font-inter-black text-white uppercase italic">Siap Melayani</p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-3xl font-inter-black text-white leading-none">15</h2>
                <p class="text-[9px] font-inter-black text-blue-400 uppercase mt-1">Sisa Unit</p>
                      </div>
                </div>
             </div>
        </div>
    </div>
</div>
@endsection
