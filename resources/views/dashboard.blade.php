@extends('layouts.workspace')

@section('content')
{{-- Memanggil font Inter & script Alpine.js khusus untuk dropdown lonceng halaman dashboard --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>

<style>
    /* Mengunci font Inter secara merata agar area sidebar luar ikut rapi, serasi, dan presisi */
    * {
        font-family: 'Inter', sans-serif;
    }

    body { font-family: 'Inter', sans-serif; background-color: #fcfcfd; }
    .font-inter-bold { font-weight: 700; }
    .font-inter-black { font-weight: 800; }

    /* Container Adjustment menempel rapi pada sidebar workspace baru */
    .dashboard-container { margin: -12px -12px 0 -12px; }

    /* Header Biru Melengkung (Ukuran Sedang) Asli Milikmu Tetap Utuh */
    .header-bg {
        background: linear-gradient(135deg, #624bff 0%, #4f39e3 100%);
        height: 220px;
        padding: 40px 30px;
        margin-bottom: -100px;
        border-bottom-left-radius: 40px;
        border-bottom-right-radius: 40px;
        box-shadow: 0 10px 25px -5px rgba(98, 75, 255, 0.3);
    }

    /* Modern Figma Style Card Asli Milikmu Tetap Utuh */
    .figma-card {
        background: white;
        border-radius: 24px;
        padding: 24px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    .figma-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.1); }
</style>

{{-- Pembungkus area konten utama agar mendukung scroll terisolasi yang rapi di sebelah kanan sidebar --}}
<div class="w-full h-[calc(100vh-2px)] bg-[#f4f7fb] overflow-y-auto hide-scroll flex flex-col">
    <div class="dashboard-container flex flex-col flex-1">

        <header class="bg-white border-b border-gray-100 py-3 px-8 flex justify-between items-center sticky top-0 z-50 flex-shrink-0 w-full">
            <div class="flex flex-col justify-center">
                <h2 class="font-inter-black text-blue-600 text-sm uppercase tracking-tight leading-none">
                    Carwash Central System
                </h2>
                <p class="text-[10px] text-gray-400 font-inter-bold uppercase tracking-widest mt-1">
                    Pusat Kendali Operasional
                </p>
            </div>

            <div class="flex items-center space-x-5">
                <div class="relative inline-block text-left" x-data="{ open: false }">
                    <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-blue-600 transition-all focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>

                        @if(isset($stokKritis) && $stokKritis->count() > 0)
                        <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 border-2 border-white rounded-full animate-pulse"></span>
                        @endif
                    </button>

                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-[999]" style="display: none;">
                        <div class="p-4 border-b border-gray-50 bg-gray-50/50">
                            <h4 class="text-[10px] font-inter-black text-gray-700 uppercase tracking-widest">Pusat Notifikasi</h4>
                        </div>
                        <div class="max-h-60 overflow-y-auto">
                            @forelse($stokKritis ?? [] as $item)
                                <div class="p-4 border-b border-gray-50 hover:bg-blue-50/30 transition-colors flex items-start space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-inter-bold text-gray-800 uppercase truncate max-w-[180px]">{{ $item->nama_bahan }} Hampir Habis!</p>
                                        <p class="text-[9px] text-gray-500 mt-0.5">Sisa stok: <span class="text-red-500 font-bold">{{ $item->stok }}</span>.</p>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center">
                                    <p class="text-[10px] text-gray-400 font-inter-bold uppercase tracking-widest">Tidak ada peringatan</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div onclick="openProfileModal()" class="flex items-center space-x-3 cursor-pointer group">
                    <div class="flex flex-col text-right">
                        <span class="text-[11px] font-inter-black text-gray-700 group-hover:text-blue-600 transition-colors">{{ Auth::user()->name }}</span>
                        <span class="text-[8px] font-inter-bold text-gray-400 uppercase mt-1">Administrator</span>
                    </div>
                    <div class="relative w-9 h-9">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full rounded-full object-cover border-2 border-white shadow-md group-hover:border-blue-500 transition-all">
                        @else
                            <div class="w-full h-full rounded-full bg-gradient-to-tr from-blue-600 to-blue-400 border-2 border-white shadow-md flex items-center justify-center text-white font-inter-bold text-[11px]">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <div class="header-bg flex justify-between items-start flex-shrink-0">
            <div>
                <p class="text-white/70 text-[10px] font-inter-bold uppercase tracking-[0.3em] mb-2">
                    Command Center Monitoring
                </p>
                <h1 class="text-white text-2xl font-inter-black tracking-tight leading-none uppercase">
                    Hallo, Selamat Beraktivitas Rafif!
                </h1>
            </div>
            <div class="flex gap-3">
                {{-- REVISI REAL: Tombol Update Data memuat ulang halaman secara halus untuk sinkronisasi database --}}
                <button onclick="window.location.reload();" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white px-4 py-2 rounded-xl font-inter-bold text-[10px] backdrop-blur-md uppercase tracking-widest transition flex items-center gap-1.5 active:scale-95">
                    🔄 Update Data
                </button>
                {{-- REVISI REAL: Tombol + Unit Baru mengarah langsung ke Halaman Kasir input transaksi --}}
                <a href="{{ route('input.transaksi.view') }}" class="bg-white text-[#624bff] px-6 py-2 rounded-xl font-inter-bold text-[10px] shadow-xl hover:scale-105 transition-all uppercase tracking-widest flex items-center justify-center">
                    + Unit Baru
                </a>
            </div>
        </div>

        <div class="px-8 flex-1">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

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
                            <p class="text-[11px] font-bold text-slate-400 uppercase mt-2 tracking-wide">Antrean Unit Berjalan</p>
                        </div>
                    </div>
                </div>

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
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest italic">Selesai</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-start pl-1">
                            <h3 class="text-3xl font-black text-slate-800 leading-none tracking-tighter">
                                {{ $layananSelesai ?? 0 }}
                            </h3>
                            <p class="text-[11px] font-bold text-slate-400 uppercase mt-2 tracking-wide">Layanan Unit Selesai</p>
                        </div>
                    </div>
                </div>

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
                                {{ $totalPelanggan ?? 0 }}
                            </h3>
                            <p class="text-[11px] font-bold text-slate-400 uppercase mt-2 tracking-wide">Total Pelanggan</p>
                        </div>
                    </div>
                </div>

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
                            <p class="text-[11px] font-bold text-slate-400 uppercase mt-3 tracking-wide leading-tight">Omzet Pendapatan Hari Ini</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6 pb-10 items-stretch">
                <div class="lg:col-span-2 flex flex-col h-full">
                    <div class="bg-white border border-slate-200 flex flex-col h-full overflow-hidden rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)]">

                        {{-- HEADER TABLE --}}
                        <div class="px-7 py-6 border-b border-slate-100 flex justify-between items-center bg-white">
                            <div class="flex items-center gap-4">
                                <div class="w-1.5 h-9 bg-blue-600 rounded-full shadow-[0_0_10px_rgba(37,99,235,0.4)]"></div>
                                <div>
                                    <h4 class="text-slate-800 font-black uppercase tracking-widest text-[12px]">Daftar Antrean Unit</h4>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">Monitoring Antrean Pelanggan Real-time</p>
                                </div>
                            </div>

                            {{-- INDIKATOR UNIT --}}
                            <div class="flex items-center gap-2.5 px-4 py-2 rounded-xl border border-slate-100 bg-slate-50 shadow-inner">
                                <div class="relative flex h-3 w-3">
                                    <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-500 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-700">
                                    {{ count($antreanAktif) }} <span class="text-slate-400">Unit Terpantau</span>
                                </span>
                            </div>
                        </div>

                        {{-- TABEL (Menggunakan Table agar benar-benar sejajar) --}}
                        <div class="overflow-x-auto flex-1 custom-scroll">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-blue-600 text-white font-black uppercase tracking-widest text-[9px]">
                                    <tr>
                                        <th class="p-4 text-center">No</th>
                                        <th class="p-4 text-center">Nama Pelanggan</th>
                                        <th class="p-4 text-center">Plat Nomor</th>
                                        <th class="p-4 text-center">Layanan</th>
                                        <th class="p-4 text-center">Waktu Masuk</th>
                                        <th class="p-4 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($antreanAktif as $index => $row)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="p-4 text-center text-[11px] font-black text-slate-400">{{ $index + 1 }}</td>
                                        <td class="p-4 text-center text-[12px] font-bold text-slate-700">{{ $row->nama_pelanggan }}</td>
                                        <td class="p-4 text-center">
                                            <span class="px-3 py-1 bg-slate-100 text-blue-700 font-black text-[11px] rounded-lg italic border border-slate-200 shadow-sm">
                                                {{ $row->plat_nomor }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-center text-[11px] font-bold text-slate-600 uppercase">{{ $row->jenis_paket }}</td>
                                        <td class="p-4 text-center text-[11px] font-black text-slate-500 tracking-widest">
                                            {{ \Carbon\Carbon::parse($row->created_at)->format('H:i') }}
                                        </td>
                                        <td class="p-4 text-center">
                                            <span class="inline-block px-4 py-1.5 bg-emerald-500 text-white font-black text-[9px] uppercase tracking-widest rounded-lg shadow-[0_2px_4px_rgba(0,0,0,0.15)]">
                                                {{ $row->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="6" class="p-10 text-center text-slate-400 font-bold italic">Belum ada antrean aktif</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- FOOTER TOMBOL --}}
                        <div class="px-7 py-6 bg-white border-t border-slate-50 mt-auto">
                            <a href="{{ route('status-progress.index') }}" class="flex items-center justify-center w-full py-4 bg-blue-600 rounded-xl hover:bg-blue-700 shadow-lg transition-all">
                                <span class="text-white text-[12px] font-bold uppercase tracking-widest">Kelola Seluruh Antrean →</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 flex flex-col">
                    <div class="bg-white border-2 border-slate-100 flex flex-col h-full overflow-hidden rounded-xl shadow-sm">
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
                                <div class="relative overflow-hidden bg-gradient-to-r from-blue-500 to-blue-400 p-4 rounded-2xl shadow-md group hover:scale-[1.02] transition-all cursor-pointer">
                                    <div class="absolute -right-4 -top-4 opacity-10"><svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path></svg></div>
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

                                <div class="relative overflow-hidden bg-gradient-to-r from-orange-500 to-amber-400 p-4 rounded-2xl shadow-md group hover:scale-[1.02] transition-all cursor-pointer">
                                    <div class="absolute -right-4 -top-4 opacity-10"><svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v2a1 1 0 102 0V5zm-4 2a1 1 0 10-1.414-1.414L4.172 5.004A1 1 0 102.758 6.418L4.172 7.832A1 1 0 005.586 6.418L4.172 5.004zM5 10a1 1 0 100-2H3a1 1 0 000 2h2zm2 4.586A1 1 0 016.414 16L5.004 14.586A1 1 0 016.418 13.172L7.832 14.586A1 1 0 016.418 16zM11 15a1 1 0 10-2 0v2a1 1 0 102 0v-2zm4.586-2A1 1 0 0116 13.586L14.586 15a1 1 0 01-1.414-1.414L14.586 13.586zM17 10a1 1 0 100-2h-2a1 1 0 100 2h2zm-2.414-4.586A1 1 0 1116 4.172L14.586 2.758A1 1 0 1116 1.344L17.414 2.758A1 1 0 1116 4.172z" clip-rule="evenodd"></path></svg></div>
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

                                <div class="relative overflow-hidden bg-gradient-to-r from-indigo-700 to-purple-600 p-4 rounded-2xl shadow-md group hover:scale-[1.02] transition-all cursor-pointer">
                                    <div class="absolute -right-4 -top-4 opacity-20"><svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg></div>
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

                            <div class="mt-6 p-4 rounded-2xl bg-gradient-to-br from-gray-900 to-gray-800 border-b-4 border-b-blue-600 shadow-xl relative overflow-hidden">
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
                                        <h2 class="text-3xl font-inter-black text-white leading-none">
                                            {{ max(0, 15 - count($antreanAktif)) }}
                                        </h2>
                                        <p class="text-[9px] font-inter-black text-blue-400 uppercase mt-1">Sisa Unit</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- MODAL PROFIL ADMIN EKSKLUSIF --}}
<div id="profileModal" class="fixed inset-0 hidden" style="z-index: 9999;">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeProfileModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4 pointer-events-none">
        <div class="bg-white w-full max-w-[380px] rounded-[2.5rem] shadow-2xl overflow-hidden pointer-events-auto border border-white">
            <div class="bg-gradient-to-br from-blue-600 via-blue-500 to-cyan-400 p-8 text-white text-center relative">
                <h3 class="font-inter-black text-[12px] uppercase tracking-[0.3em] drop-shadow-md">Update Profil Admin</h3>
                <button type="button" onclick="closeProfileModal()" class="absolute top-5 right-6 text-white/70 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-10 flex flex-col items-center text-center">
                @csrf
                @method('patch')
                <div class="w-20 h-20 bg-gradient-to-tr from-blue-100 to-blue-50 rounded-3xl flex items-center justify-center mb-6 shadow-inner">
                    <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </div>
                <div class="w-full space-y-5 mb-10">
                    <input type="file" name="avatar" accept="image/*" required class="w-full text-[10px] text-gray-500 border-2 border-dashed border-blue-100 p-4 rounded-2xl hover:border-blue-400 hover:bg-blue-50/50 transition-all cursor-pointer text-center" />
                </div>
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-2xl text-[10px] font-inter-bold shadow-md uppercase tracking-[0.2em]">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT SINKRONISASI JAM REAL-TIME --}}
<script>
    // Memperbarui halaman secara otomatis setiap 30 detik
    // sehingga waktu masuk terbaru akan langsung muncul di daftar
    setInterval(() => {
        window.location.reload();
    }, 30000);

    // Skrip ini akan otomatis update jika ada data baru
    function refreshData() {
        // Anda bisa menggunakan AJAX/Fetch di sini untuk memperbarui tabel setiap 30 detik
        // tanpa harus me-reload halaman
    }
    setInterval(refreshData, 30000);

    function openProfileModal() { document.getElementById('profileModal').classList.remove('hidden'); }
    function closeProfileModal() { document.getElementById('profileModal').classList.add('hidden'); }

    function updateClock() {
        const now = new Date();
        const timeString = now.getHours().toString().padStart(2, '0') + ':' +
                           now.getMinutes().toString().padStart(2, '0') + ':' +
                           now.getSeconds().toString().padStart(2, '0');

        const timeElement = document.getElementById('real-time');
        if(timeElement) timeElement.innerText = timeString;

        const options = { day: '2-digit', month: 'long', year: 'numeric' };
        const dateElement = document.getElementById('real-date');
        if(dateElement) dateElement.innerText = now.toLocaleDateString('en-GB', options);

        const hour = now.getHours();
        const sText = document.getElementById('system-status');
        const sDot = document.getElementById('status-dot');

        if (sText && sDot) {
            if (hour >= 8 && hour < 21) {
                sText.innerText = "System Open";
                sText.className = "text-[9px] font-black uppercase tracking-wider text-green-600";
            } else {
                sText.innerText = "System Closed";
                sText.className = "text-[9px] font-black uppercase tracking-wider text-red-600";
            }
        }
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection
