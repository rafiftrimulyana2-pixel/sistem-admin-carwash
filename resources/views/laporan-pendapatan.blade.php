@extends('layouts.app')

@section('dynamic-title', '')
@section('dynamic-subtitle', '')
@section('dynamic-actions', '')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">

<style>
    /* ==========================================================================
       PRODUCTION DESIGN SYSTEM: CONTROL LAYOUT & ANTI-SCROLLBAR
       ========================================================================== */
    .workspace-container {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
        min-height: 100vh;
        padding: 0px !important;
        margin: 0px !important;
        color: #0f172a;
        box-sizing: border-box;
        position: relative;
        width: 100% !important; /* Memaksa penuh 100% ke kanan & kiri */
        max-width: none !important; /* Menghapus batasan 1200px yang bikin di tengah */
    }

    /* Pemaksaan Karakter Tulisan Inter-Bold di Seluruh Penjuru Komponen UI */
    .workspace-container *,
    .workspace-container h1,
    .workspace-container h2,
    .workspace-container p,
    .workspace-container span,
    .workspace-container label,
    .workspace-container select,
    .workspace-container input,
    .workspace-container button,
    .workspace-container th,
    .workspace-container td {
        font-family: 'Inter', sans-serif !important;
        font-weight: 700 !important;
        letter-spacing: -0.3px;
    }

    /* KUNCI MATI DOUBLE SCROLLBAR FISIK KANAN DAN BAWAH */
    html, body, main, .workspace-container, #app, .content-wrapper {
        overflow-x: hidden !important;
        scrollbar-width: none !important;
    }
    html::-webkit-scrollbar, body::-webkit-scrollbar, main::-webkit-scrollbar, .workspace-container::-webkit-scrollbar {
        width: 0px !important;
        height: 0px !important;
        display: none !important;
    }

    /* ==========================================================================
       HEADER BG: STRUKTUR PENEMBUS TEPI SISI MONITOR (PAS & MENYATU NOL CELAH)
       ========================================================================== */
    .header-bg {
        background: linear-gradient(135deg, #624bff 0%, #4f39e3 100%) !important;
        height: 220px !important;
        padding: 45px 48px !important;

        /* TRIK KUNCI: Tarik paksa keluar dari kotak tengah bawaan template */
        position: relative !important;
        margin-left: -32px !important;  /* Menarik ke pojok kiri */
        margin-right: -32px !important; /* Menarik ke pojok kanan */
        margin-top: -32px !important;   /* Menempelkan ke atas */
        width: calc(100% + 64px) !important; /* Memaksa lebar melebihi batas tengah */

        /* Batas tumpukan dengan card bawah */
        margin-bottom: -110px !important;

        /* Lengkungan sudut bawah modern */
        border-bottom-left-radius: 40px !important;
        border-bottom-right-radius: 40px !important;
        box-shadow: 0 10px 25px -5px rgba(98, 75, 255, 0.3) !important;
        z-index: 10 !important;
        box-sizing: border-box;
    }

    /* INPUT PENCARIAN ATAS PUTIH BERSIH DENGAN TEKS KETIKAN GELAP JELAS */
    .header-search-white {
        background-color: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        color: #0f172a !important;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05) !important;
    }
    .header-search-white::placeholder {
        color: #94a3b8 !important;
    }

    /* ==========================================================================
       4 KOTAK METRIK ATAS: BULAT IDEAL (16PX) & BAYANGAN HITAM ABU-ABU GAGAH
       ========================================================================== */
    .metric-floating-card {
        background-color: #ffffff;
        border-radius: 16px !important;
        border: 1px solid #e2e8f0;
        /* Efek bayangan hitam abu-abu tebal mengambang nyata */
        box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.12), 0 10px 10px -5px rgba(15, 23, 42, 0.06) !important;
    }

    /* ==========================================================================
       KOTAK PANJANG BAWAH (GRAFIK & FILTER-TABEL): FLAT SOLID ABU-ABU TANPA SHADOW
       ========================================================================== */
    .flat-grey-stretched-card {
        background-color: #f1f5f9 !important; /* Warna abu-abu solid */
        border-radius: 8px !important; /* Kotak tegas sudut kecil */
        border: 1px solid #cbd5e1;
        box-shadow: none !important; /* Tidak mengambang & tidak ada bayangan apapun */

        /* Memaksa sisi kotak bergeser melebarkan diri menjorok ke pojok kiri-kanan */
        margin-left: -24px !important;
        margin-right: -24px !important;
        width: calc(100% + 48px) !important;
        box-sizing: border-box;
        overflow: hidden;
    }

    /* TOMBOL BIRU FLAT (HOVER BARU MENGAMBANG SLOW MOTION) */
    .btn-blue-interactive {
        background-color: #2563eb !important;
        color: #ffffff !important;
        border-radius: 8px !important;
        transform: translateY(0px) !important;
        box-shadow: none !important; /* Diam tanpa bayangan */
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1) !important; /* Transisi lambat santai */
    }
    .btn-blue-interactive:hover {
        background-color: #1d4ed8 !important;
        transform: translateY(-3px) !important; /* Efek melayang naik secara perlahan */
        box-shadow: 0 10px 20px -4px rgba(37, 99, 235, 0.4) !important; /* Bayangan hitam abu-abu keluar */
    }
</style>

    <div class="header-bg">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_-20%,rgba(255,255,255,0.1),transparent_60%)] pointer-events-none"></div>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-20 w-full pb-6">

            <div class="flex flex-col">
                <p class="text-white/60 text-[9px] font-bold uppercase tracking-[0.25em] mb-1.5">
                    Sistem Otomasi Pembukuan Kasir
                </p>
                <h1 class="text-white text-2xl font-black tracking-tight leading-none uppercase" style="font-weight: 900 !important; font-size: 1.65rem !important;">
                    Ringkasan Neraca Finansial
                </h1>
                <div class="flex items-center gap-2 mt-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_#34d399] animate-pulse"></span>
                    <p class="text-white/90 text-[10px] font-semibold tracking-wide uppercase">
                        Monitoring Arus Kas Real-Time Tanpa Jeda
                    </p>
                </div>
            </div>

            <form method="GET" action="{{ route('laporan.pendapatan') }}" class="flex items-center gap-2 w-full md:w-auto flex-1 md:max-w-sm md:justify-end">
                <div class="relative w-full">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data transaksi..." class="w-full text-xs font-semibold py-2.5 pl-9 pr-4 header-search-white outline-none">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </form>

        </div>
    </div> <div style="padding: 0px 24px; position: relative; z-index: 20;">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 w-full mt-8 relative z-30" style="margin-left: -16px !important; margin-right: -16px !important; width: calc(100% + 32px) !important; box-sizing: border-box;">

            <div class="metric-floating-card flex flex-col justify-between h-40 w-full p-6 bg-white" style="border-radius: 16px !important;">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 bg-blue-600 text-white flex items-center justify-center rounded-xl"
                         style="box-shadow: 0 8px 20px rgba(37, 99, 235, 0.6) !important;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-3-5h6"/>
                        </svg>
                    </div>
                    <span class="text-[10px] bg-emerald-50 text-emerald-600 px-2 py-0.5 rounded-full font-black">▲ 12.5%</span>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 uppercase tracking-widest font-black mb-0.5">Total Pendapatan</p>
                    <p class="text-xl font-black text-slate-800 tracking-tight">Rp 0</p>
                </div>
            </div>

            <div class="metric-floating-card flex flex-col justify-between h-40 w-full p-6 bg-white" style="border-radius: 16px !important;">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 bg-emerald-500 text-white flex items-center justify-center rounded-xl"
                         style="box-shadow: 0 8px 20px rgba(16, 185, 129, 0.6) !important;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <span class="text-[10px] bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-black">● Live</span>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider font-black mb-0.5">Total Transaksi</p>
                    <p class="text-xl font-black text-slate-800 tracking-tight">0 Transaksi</p>
                </div>
            </div>

            <div class="metric-floating-card flex flex-col justify-between h-40 w-full p-6 bg-white" style="border-radius: 16px !important;">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 bg-purple-600 text-white flex items-center justify-center rounded-xl"
                         style="box-shadow: 0 8px 20px rgba(147, 51, 234, 0.6) !important;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 17l6-6 4 4 6-10M20 5h-4m4 0v4"/>
                        </svg>
                    </div>
                    <span class="text-[10px] bg-emerald-50 text-emerald-600 px-2 py-0.5 rounded-full font-black">▲ 4.2%</span>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider font-black mb-0.5">Rata-Rata Transaksi</p>
                    <p class="text-xl font-black text-slate-800 tracking-tight">Rp 0</p>
                </div>
            </div>

            <div class="metric-floating-card flex flex-col justify-between h-40 w-full p-6 bg-white" style="border-radius: 16px !important;">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 bg-orange-500 text-white flex items-center justify-center rounded-xl"
                         style="box-shadow: 0 8px 20px rgba(249, 115, 22, 0.6) !important;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9"/>
                            <circle cx="12" cy="12" r="5"/>
                            <circle cx="12" cy="12" r="1" fill="currentColor"/>
                        </svg>
                    </div>
                    <span class="text-[10px] bg-orange-50 text-orange-600 px-2 py-0.5 rounded-full font-black">0%</span>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider font-black mb-0.5">Target Bulanan</p>
                    <p class="text-xl font-black text-slate-800 tracking-tight">0%</p>
                </div>
            </div>

        </div> <div class="flat-grey-stretched-card my-12 p-6">
            <div class="flex flex-col gap-1 mb-6">
                <h2 class="text-slate-800 text-base font-black tracking-tight uppercase">
                    Filter Parameter Laporan Pendapatan
                </h2>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                    Rekapitulasi Pendapatan Harian Terbaru
                </p>
            </div>

            <div class="p-6 w-full">
                <div class="flex flex-col mb-5">
                    <h2 class="text-slate-800 text-sm font-black uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter Parameter Laporan Pendapatan
                    </h2>
                    <p class="text-slate-500 text-[11px] font-medium pl-6">
                        Tentukan jangkauan tanggal analisis performa kas masuk
                    </p>
                </div>

                <form method="GET" action="{{ route('laporan.pendapatan') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end w-full">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-slate-600 text-[10px] font-black uppercase tracking-wider">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ request('start_date', date('Y-m-d')) }}" class="w-full bg-white text-xs border border-slate-300 rounded px-3 py-2.5 text-slate-700 outline-none focus:border-blue-500 transition-all">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-slate-600 text-[10px] font-black uppercase tracking-wider">Status Transaksi</label>
                        <select name="status_transaksi" class="w-full bg-white text-xs border border-slate-300 rounded px-3 py-2.5 text-slate-700 outline-none focus:border-blue-500 cursor-pointer transition-all">
                            <option value="">Semua Status</option>
                            <option value="success">Selesai (Success)</option>
                            <option value="process">Proses</option>
                            <option value="canceled">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-slate-600 text-[10px] font-black uppercase tracking-wider">Paket Layanan</label>
                        <select name="paket" class="w-full bg-white text-xs border border-slate-200 rounded px-3 py-2.5 text-slate-700 outline-none focus:border-blue-500 cursor-pointer transition-all">
                            <option value="">Semua Paket</option>
                            <option value="reguler">Cuci Regular</option>
                            <option value="premium">Cuci Premium (Wax)</option>
                            <option value="coating">Ceramic Coating</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-black uppercase py-3 rounded shadow shadow-blue-500/5 transition-all">
                            CARI DATA TRANSAKSI
                        </button>
                    </div>
                </form>
            </div>

            <div class="border-t border-slate-300/70 w-full"></div>

            <div class="p-6 w-full">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-5">
                    <div class="flex flex-col">
                        <h2 class="text-slate-800 text-sm font-black uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Rekapitulasi Pendapatan Harian Terbaru
                        </h2>
                        <p class="text-slate-500 text-[11px] font-medium pl-6">
                            Data komparasi rincian omzet harian berdasarkan invoice terbit
                        </p>
                    </div>
                    <button type="button" onclick="alert('Sistem sedang menyiapkan berkas PDF Laporan Pendapatan...')" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black uppercase py-2.5 px-4 rounded shadow transition-all flex items-center justify-center gap-2 md:w-auto w-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h6z"></path></svg>
                        CETAK PDF LAPORAN
                    </button>
                </div>

                <div class="w-full border border-slate-300 bg-white rounded overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-100 border-b border-slate-300">
                                <th class="text-[10px] uppercase font-black tracking-wider text-slate-600 p-4 w-16">No</th>
                                <th class="text-[10px] uppercase font-black tracking-wider text-slate-600 p-4">Tanggal Transaksi</th>
                                <th class="text-[10px] uppercase font-black tracking-wider text-slate-600 p-4">Total Unit</th>
                                <th class="text-[10px] uppercase font-black tracking-wider text-slate-600 p-4">Layanan Terlaris</th>
                                <th class="text-[10px] uppercase font-black tracking-wider text-slate-600 p-4">Kasir Closing</th>
                                <th class="text-[10px] uppercase font-black tracking-wider text-slate-600 p-4 text-right pr-6">Total Omzet Bersih</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 text-slate-600 bg-white">
                            <tr class="hover:bg-slate-50/50 transition-all">
                                <td colspan="6" class="p-12 text-center text-slate-400 font-bold text-xs uppercase tracking-wide">
                                    <svg class="w-8 h-8 text-slate-200 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Belum Ada Rekaman Data Transaksi Finansial Bengkel Yang Masuk.
                                </td>
                            </tr>
                            <tr class="bg-slate-50 border-t border-slate-300 text-slate-800">
                                <td colspan="2" class="p-4 pl-6 text-left">
                                    <button type="button" onclick="alert('Membuka panel riwayat arsip transaksi finansial pusat...')" class="btn-blue-interactive text-[10px] py-2.5 px-4 font-black tracking-wide uppercase flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Lihat Seluruh Data
                                    </button>
                                </td>
                                <td colspan="3" class="p-4 text-right uppercase tracking-wider text-[10px] text-slate-400 font-black pr-4">
                                    Total Akumulasi Pendapatan Bersih :
                                </td>
                                <td class="p-4 text-right pr-6 text-base text-emerald-600 font-black">
                                    Rp 0
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
