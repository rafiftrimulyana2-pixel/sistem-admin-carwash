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
        Hallo, Selamat Beraktivitas Rafif!
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
        <div class="bg-white rounded-[24px] p-6 border border-gray-100 shadow-lg shadow-slate-400/20 transition-all duration-300">
    <div class="flex flex-col gap-4">
        <div class="flex justify-between items-start">
            <div class="w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-blue-600/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>

            <div class="flex flex-col items-end">
                <span class="text-[7px] font-black text-blue-600 bg-blue-50 px-2 py-1 rounded-md uppercase tracking-widest mb-1">Status</span>
                <div class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>
                    <span class="text-[9px] font-bold text-blue-500 uppercase italic">Terpantau</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col items-start pl-1">
            <h3 class="text-3xl font-black text-slate-800 leading-none tracking-tighter">
                {{ count($antreanAktif ?? []) }}
            </h3>
            <p class="text-[11px] font-bold text-slate-400 uppercase mt-2 tracking-wide">
                Antrean Unit Berjalan
            </p>
        </div>
    </div>
</div>

        <!-- KOTAK 2: TOTAL SELESAI -->
        <div class="bg-white rounded-[24px] p-6 border border-gray-100 shadow-lg shadow-slate-400/20 transition-all duration-300">
    <div class="flex flex-col gap-4">
        <div class="flex justify-between items-start">
            <div class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <div class="flex flex-col items-end">
                <span class="text-[7px] font-black text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md uppercase tracking-widest mb-1">Target Hari Ini</span>
                <div class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                    <span class="text-[9px] font-bold text-slate-400 uppercase italic tracking-widest italic">Selesai</span>
                </div>

            </div>
        </div>

        <div class="flex flex-col items-start pl-1">
            <h3 class="text-3xl font-black text-slate-800 leading-none tracking-tighter">
                {{ $layananSelesai }}
            </h3>
            <p class="text-[11px] font-bold text-slate-400 uppercase mt-2 tracking-wide">
                Layanan Unit Selesai
            </p>
        </div>
    </div>
</div>
        <!-- KOTAK 3: TOTAL PELANGGAN -->
        <div class="bg-white rounded-[24px] p-6 border border-gray-100 shadow-lg shadow-slate-400/20 transition-all duration-300">
    <div class="flex flex-col gap-4">
        <div class="flex justify-between items-start">
            <div class="w-12 h-12 bg-violet-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-violet-600/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>

            <div class="flex flex-col items-end">
                <span class="text-[7px] font-black text-violet-600 bg-violet-50 px-2 py-1 rounded-md uppercase tracking-widest mb-1">Data</span>
                <div class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-violet-500 rounded-full"></span>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest italic">Customer</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col items-start pl-1">
            <h3 class="text-3xl font-black text-slate-800 leading-none tracking-tighter">
                {{ $totalPelanggan }}
            </h3>
            <p class="text-[11px] font-bold text-slate-400 uppercase mt-2 tracking-wide">
                Total Pelanggan
            </p>
        </div>
    </div>
</div>

        <!-- KOTAK 4: PENDAPATAN -->
        <div class="bg-white rounded-[24px] p-6 border border-gray-100 shadow-lg shadow-slate-400/20 transition-all duration-300">
    <div class="flex flex-col gap-4">
        <div class="flex justify-between items-start">
            <div class="w-12 h-12 bg-orange-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <div class="flex flex-col items-end">
                <span class="text-[7px] font-black text-orange-600 bg-orange-50 px-2 py-1 rounded-md uppercase tracking-widest mb-1">Keuangan</span>
                <div class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span>
                    <span class="text-[9px] font-bold text-slate-400 uppercase italic tracking-widest">Revenue</span>
                </div>

            </div>
        </div>

        <div class="flex flex-col items-start pl-1 mt-auto">
            <h3 class="text-2xl font-black text-slate-800 leading-none tracking-tighter">
                Rp {{ number_format($omzetHariIni ?? 0, 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase mt-3 tracking-wide leading-tight">
                        Omzet Pendapatan Hari Ini
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- GRID BAWAH: Antrian & Informasi (items-start agar card kanan tidak melar) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6 pb-10 items-stretch px-8">

    <!-- 1. DAFTAR ANTRIAN UNIT (KIRI) - REVISI TABEL VIBRANT -->
    <div class="lg:col-span-2 flex flex-col">
        <div class="bg-white border-2 border-slate-100 flex flex-col h-full overflow-hidden rounded-xl">

        <div class="px-7 py-6 border-b border-slate-100 flex justify-between items-center bg-white">
            <div class="flex items-center gap-4">
                <div class="w-1.5 h-9 bg-blue-600 rounded-full"></div>
                    <div class="flex flex-col justify-center gap-0.5">
                        <h4 class="text-slate-800 font-bold uppercase tracking-widest text-[12px] leading-none">
                        Daftar Antrean Unit
                    </h4>
                        <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wider leading-none mt-1">
                        Monitoring Antrean Pelanggan Real-time
                    </p>
                </div>
            </div>

            @php $jumlah = $antreanAktif->count(); @endphp
            <div class="flex items-center gap-3 px-5 py-2 rounded-lg transition-all duration-500 {{ $jumlah > 0 ? 'bg-emerald-500' : 'bg-blue-600' }}">
                <div class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75 bg-white"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-white"></span>
                </div>
                <span class="text-[10px] font-black uppercase tracking-wider text-white">
                    {{ $jumlah }} UNIT TERPANTAU
                </span>
            </div>
        </div>

        <div class="grid grid-cols-[2fr_1.2fr_1.5fr_1fr] gap-4 px-8 py-3 bg-blue-600">
    <div class="text-[10px] font-bold text-white uppercase tracking-widest">Pelanggan</div>
    <div class="text-[10px] font-bold text-white uppercase tracking-widest text-center border-l border-blue-400/50">Kendaraan</div>
    <div class="text-[10px] font-bold text-white uppercase tracking-widest text-center border-l border-blue-400/50">Kategori Layanan</div>
    <div class="text-[10px] font-bold text-white uppercase tracking-widest text-right border-l border-blue-400/50">Status</div>
</div>

<div class="flex-1 overflow-y-hidden bg-white min-h-[450px]">
    @forelse($antreanAktif as $row)
        <div class="grid grid-cols-[2fr_1.2fr_1.5fr_1fr] gap-4 px-8 py-5 border-b border-slate-50 hover:bg-slate-50 transition-colors duration-300 items-center">

            <div class="flex flex-col gap-0.5">
                <span class="text-[12px] font-bold text-slate-700 leading-tight">{{ $row->nama_pelanggan }}</span>
                <span class="text-[9px] text-slate-400 font-medium uppercase">{{ $row->no_hp ?? '-' }}</span>
            </div>

            <div class="flex justify-center items-center">
                <span class="text-[11px] font-black text-blue-600 bg-blue-50 px-3 py-1 rounded-md italic tracking-wider border border-blue-100">
                    {{ $row->plat_nomor }}
                </span>
            </div>

            <div class="flex flex-col items-center justify-center">
                <span class="text-[11px] text-slate-600 font-bold uppercase leading-tight">
                    {{ $row->jenis_paket }}
                </span>
                <span class="text-[8px] text-blue-500 font-black uppercase italic tracking-tighter">Premium Service</span>
            </div>

            <div class="flex justify-end items-center">
                <span class="px-3 py-1 bg-blue-600 text-white text-[9px] font-black uppercase rounded-md italic tracking-widest">
                    {{ $row->status }}
                </span>
            </div>
        </div>
        @empty
            <div class="h-full flex flex-col items-center justify-center py-24 px-10">
                <div class="mb-6 text-slate-200">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                    <h2 class="text-xl font-bold text-slate-700 uppercase tracking-tight mb-2 italic">Belum Ada Pelanggan</h2>
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-widest text-center max-w-xs leading-relaxed">
                        Sistem sedang stand-by menunggu data pelanggan baru dari admin untuk ditampilkan di monitor.
                    </p>
                </div>
            @endforelse
        </div>

        <div class="px-7 py-6 bg-white border-t border-slate-50 mt-auto">
            <a href="{{ route('status-progress.index') }}"
                class="flex items-center justify-center w-full py-4 bg-blue-600 rounded-xl transition-all duration-500 hover:bg-blue-700 hover:-translate-y-1 shadow-lg shadow-blue-200/50 hover:shadow-slate-400/60">
                <span class="text-white text-[12px] font-bold uppercase tracking-widest">
                    Kelola Seluruh Antrean →
                </span>
            </a>
        </div>
    </div>
</div>

<div class="lg:col-span-1 flex flex-col">
    <div class="bg-white border-2 border-slate-100 flex flex-col h-full overflow-hidden rounded-xl">
        <div class="bg-slate-50 px-6 py-5 border-b border-slate-100 flex justify-between items-center">
            <div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Live Monitor</span>
                <h4 class="text-slate-800 font-bold uppercase text-[12px] mt-1">Slot Booking</h4>
            </div>
            <div class="text-right">
                <p id="real-time" class="text-blue-600 font-black text-[14px]">--:--:--</p>
                <p id="system-status" class="text-[9px] font-bold text-slate-400 uppercase">Checking...</p>
            </div>
        </div>
    <div class="p-6 border-t-4 border-t-blue-600 flex-1 overflow-y-hidden">

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

<script>
    function updateClock() {
        const now = new Date();

        // 1. Update Jam (HH:MM:SS)
        const timeString = now.getHours().toString().padStart(2, '0') + ':' +
                           now.getMinutes().toString().padStart(2, '0') + ':' +
                           now.getSeconds().toString().padStart(2, '0');

        const timeElement = document.getElementById('real-time');
        if(timeElement) timeElement.innerText = timeString;

        // 2. Update Tanggal (Contoh: 07 May 2026)
        const options = { day: '2-digit', month: 'long', year: 'numeric' };
        const dateElement = document.getElementById('real-date');
        if(dateElement) dateElement.innerText = now.toLocaleDateString('en-GB', options);

        // 3. Logic System Status
        const hour = now.getHours();
        const sText = document.getElementById('system-status');
        const sDot = document.getElementById('status-dot');

        if (sText && sDot) {
            if (hour >= 8 && hour < 21) {
                sText.innerText = "System Open";
                sText.className = "text-[9px] font-black uppercase tracking-wider text-green-600";
                sDot.className = "w-2 h-2 rounded-full bg-green-500 animate-pulse";
            } else {
                sText.innerText = "System Closed";
                sText.className = "text-[9px] font-black uppercase tracking-wider text-red-600";
                sDot.className = "w-2 h-2 rounded-full bg-red-500";
            }
        }
    }

    setInterval(updateClock, 1000);
    updateClock();
</script>

@endsection
