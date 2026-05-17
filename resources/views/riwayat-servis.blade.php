@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@700;800&display=swap" rel="stylesheet">

<style>
    /* 1. Bersihkan Header Dashboard Bawaan */
    header, .top-navigation, #header-dashboard, [class*="CARWASH-CENTRAL"] {
        display: none !important;
    }

    .font-800 { font-weight: 800; }
    .font-700 { font-weight: 700; }

    /* Container utama agar mengikuti scroll dashboard */
    .archive-wrapper {
        padding: 30px 40px;
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
        min-height: 100vh;
    }

    /* Styling Input Filter */
    .filter-box {
        background: white;
        border: 1px solid #e2e8f0;
        padding: 10px 15px;
        font-size: 11px;
        font-weight: 700;
        border-radius: 12px;
        outline: none;
    }
</style>
<div class="bg-[#2563eb] min-h-[160px] px-10 flex items-center justify-between w-full relative overflow-hidden shadow-[0_15px_50px_rgba(0,0,0,0.25)]"
     style="margin-top: -30px; margin-left: -40px; width: calc(100% + 80px); border-radius: 0px !important;">

    <div class="absolute top-0 right-0 w-1/4 h-full bg-white/5 -skew-x-12 translate-x-10"></div>
    <div class="absolute bottom-0 left-0 w-full h-1.5 bg-black/10"></div>

    <div class="relative z-10 flex flex-col justify-center h-full pt-4">

        <div class="flex flex-col mb-4">
            <h1 class="text-xl font-800 text-white uppercase tracking-tight leading-none"
                style="font-family: 'Inter', sans-serif;">
                Riwayat Servis
            </h1>
            <p class="text-[9px] font-700 text-blue-100 uppercase tracking-[0.2em] mt-1.5 opacity-70"
               style="font-family: 'Inter', sans-serif;">
                Database & Arsip Aktivitas Pelanggan
            </p>
        </div>

        <div class="flex items-center gap-5 border-t border-white/20 pt-4">
            <div class="flex flex-col pr-5 border-r border-white/10">
                <span class="text-[8px] font-800 text-blue-200 uppercase tracking-widest mb-0.5">Unit</span>
                <div class="flex items-baseline gap-1">
                    <span class="text-lg font-800 text-white leading-none tracking-tighter">{{ $totalUnits ?? 0 }}</span>
                    <span class="text-[7px] font-800 text-blue-300 uppercase opacity-60">Selesai</span>
                </div>
            </div>

            <div class="flex flex-col pr-5 border-r border-white/10">
                <span class="text-[8px] font-800 text-blue-200 uppercase tracking-widest mb-0.5">Total Omzet</span>
                <span class="text-lg font-800 text-white leading-none tracking-tighter">
                    Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
                </span>
            </div>

            <div class="flex flex-col pr-5 border-r border-white/10">
                <span class="text-[8px] font-800 text-blue-200 uppercase tracking-widest mb-0.5">Server</span>
                <div class="flex items-center gap-1.5">
                    <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_8px_rgba(52,211,153,0.5)]"></div>
                    <span class="text-[9px] font-800 text-white uppercase">Online</span>
                </div>
            </div>

            <div class="flex flex-col">
                <span class="text-[8px] font-800 text-blue-200 uppercase tracking-widest mb-0.5">Aktivitas</span>
                <span class="text-[9px] font-800 text-white uppercase tracking-tighter opacity-80">Sistem Berjalan</span>
            </div>
        </div>
    </div>

    <div class="relative z-10 pr-10 flex items-center h-full pt-4">
        <div class="bg-white/10 backdrop-blur-md p-[1px] shadow-[0_15px_30px_rgba(0,0,0,0.3)]">
            <div class="bg-white px-5 py-3 flex flex-col items-center" style="border-radius: 0px !important;">
                <div class="flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span id="live-date" class="text-[9px] font-800 text-slate-700 tracking-widest uppercase">
                        {{ date('l, d F Y') }}
                    </span>
                </div>
                <div class="w-full h-[1px] bg-slate-100 my-1.5"></div>
                <span id="live-time" class="text-[10px] font-800 text-blue-600 tracking-[0.3em]">00:00:00</span>
            </div>
        </div>
    </div>
</div>

<script>
    function updateDateTime() {
        const now = new Date();
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };

        document.getElementById('live-date').innerText = now.toLocaleDateString('en-GB', dateOptions);
        document.getElementById('live-time').innerText = now.toLocaleTimeString('en-GB', timeOptions);
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <!-- Header -->
        <header class="bg-white border-b border-slate-200 px-8 py-5 flex items-center justify-between sticky top-0 z-10">
            <div>
                <h2 class="text-slate-800 font-extrabold text-xl">Riwayat Servis</h2>
                <p class="text-xs text-slate-400 font-medium tracking-wide uppercase">Laporan Seluruh Aktivitas Layanan</p>
            </div>
            <div class="flex items-center space-x-6">
                <div class="hidden lg:flex items-center space-x-2 bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200">
                    <i data-lucide="calendar-days" class="w-4 h-4 text-slate-500"></i>
                    <span class="text-xs font-bold text-slate-600">15 Mei 2026</span>
                </div>
                <div class="flex items-center space-x-3 border-l pl-6 border-slate-200">
                    <div class="text-right">
                        <p class="text-sm font-bold">Admin Bengkel</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Administrator</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg shadow-blue-200">A</div>
                </div>
            </div>
        </header>

        <div class="p-8">
            <!-- Filter Section -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm mb-8">
                <div class="flex flex-wrap lg:flex-nowrap items-end gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label class="text-[10px] font-bold text-slate-400 uppercase mb-2 block tracking-widest">Cari Transaksi</label>
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 w-4 h-4"></i>
                            <input type="text" placeholder="ID, Nama, atau No. Plat..." class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                        </div>
                    </div>
                    <div class="w-full lg:w-48">
                        <label class="text-[10px] font-bold text-slate-400 uppercase mb-2 block tracking-widest">Rentang Tanggal</label>
                        <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all cursor-pointer">
                            <option>Hari Ini</option>
                            <option>7 Hari Terakhir</option>
                            <option>30 Hari Terakhir</option>
                            <option>Pilih Manual...</option>
                        </select>
                    </div>
                    <div class="w-full lg:w-48">
                        <label class="text-[10px] font-bold text-slate-400 uppercase mb-2 block tracking-widest">Kategori Layanan</label>
                        <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all cursor-pointer">
                            <option>Semua Layanan</option>
                            <option>Regular Wash</option>
                            <option>Premium Detailing</option>
                            <option>Full Wash + Wax</option>
                        </select>
                    </div>
                    <div class="flex space-x-2">
                        <button class="bg-blue-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all flex items-center">
                            <i data-lucide="filter" class="w-4 h-4 mr-2"></i> Filter
                        </button>
                        <button class="bg-slate-800 text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-slate-200 hover:bg-slate-900 transition-all flex items-center">
                            <i data-lucide="download" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-200">
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">ID Transaksi</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Waktu & Tanggal</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pelanggan</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Layanan</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Total Bayar</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @php
                                $history = [
                                    ['id' => 'INV-2024-001', 'date' => '15 Mei 2026', 'time' => '10:30', 'name' => 'Rafliansyah', 'car' => 'Honda HR-V (B 1234 ABC)', 'service' => 'Full Wash + Wax', 'price' => 150000, 'status' => 'Lunas'],
                                    ['id' => 'INV-2024-002', 'date' => '15 Mei 2026', 'time' => '09:15', 'name' => 'Siti Aminah', 'car' => 'Toyota Fortuner (F 999 SS)', 'service' => 'Premium Detailing', 'price' => 450000, 'status' => 'Lunas'],
                                    ['id' => 'INV-2024-003', 'date' => '14 Mei 2026', 'time' => '16:45', 'name' => 'Andi Wijaya', 'car' => 'Mitsubishi Pajero (B 777 RFS)', 'service' => 'Regular Wash', 'price' => 50000, 'status' => 'Lunas'],
                                    ['id' => 'INV-2024-004', 'date' => '14 Mei 2026', 'time' => '14:20', 'name' => 'Budi Santoso', 'car' => 'Yamaha XMAX (D 4455 XY)', 'service' => 'Full Wash', 'price' => 35000, 'status' => 'Menunggu'],
                                    ['id' => 'INV-2024-005', 'date' => '14 Mei 2026', 'time' => '11:05', 'name' => 'Rina Kartika', 'car' => 'Mazda CX-5 (L 1234 ZZ)', 'service' => 'Premium Detailing', 'price' => 550000, 'status' => 'Lunas'],
                                    ['id' => 'INV-2024-006', 'date' => '13 Mei 2026', 'time' => '13:10', 'name' => 'Dedi Setiadi', 'car' => 'Honda Brio (B 2024 OK)', 'service' => 'Regular Wash', 'price' => 50000, 'status' => 'Lunas'],
                                ];
                            @endphp

                            @foreach($history as $item)
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="px-6 py-4">
                                    <span class="text-xs font-black text-slate-700">#{{ $item['id'] }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-xs font-bold text-slate-700">{{ $item['date'] }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $item['time'] }} WIB</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-800">{{ $item['name'] }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium uppercase tracking-tight">{{ $item['car'] }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-tight">{{ $item['service'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <p class="text-sm font-black text-blue-600">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase
                                        {{ $item['status'] == 'Lunas' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }}">
                                        {{ $item['status'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button class="p-2 bg-slate-50 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Detail">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </button>
                                        <button class="p-2 bg-slate-50 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Cetak Struk">
                                            <i data-lucide="printer" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-200 flex flex-wrap items-center justify-between gap-4">
                    <p class="text-xs text-slate-500 font-medium">Menampilkan <span class="font-bold">6</span> dari <span class="font-bold">124</span> transaksi</p>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-400 hover:text-blue-600 transition-colors disabled:opacity-50">
                            <i data-lucide="chevron-left" class="w-4 h-4"></i>
                        </button>
                        <button class="px-3 py-1.5 rounded-lg border border-blue-600 bg-blue-600 text-white font-bold text-xs">1</button>
                        <button class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 font-bold text-xs hover:bg-slate-50">2</button>
                        <button class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 font-bold text-xs hover:bg-slate-50">3</button>
                        <button class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-400 hover:text-blue-600 transition-colors">
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Summary Summary Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <div class="bg-blue-600 rounded-2xl p-6 text-white shadow-xl shadow-blue-100 relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-xs font-bold uppercase opacity-80 mb-1">Total Pendapatan Hari Ini</p>
                        <h3 class="text-2xl font-black">Rp 1.250.000</h3>
                        <p class="text-[10px] mt-4 font-medium flex items-center">
                            <i data-lucide="trending-up" class="w-3 h-3 mr-1"></i> Naik 12% dari kemarin
                        </p>
                    </div>
                    <i data-lucide="wallet" class="absolute -right-4 -bottom-4 w-32 h-32 text-white opacity-10 group-hover:scale-110 transition-transform"></i>
                </div>
                <div class="bg-slate-800 rounded-2xl p-6 text-white shadow-xl shadow-slate-200 relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-xs font-bold uppercase opacity-80 mb-1">Unit Selesai (Bulan Ini)</p>
                        <h3 class="text-2xl font-black">482 Unit</h3>
                        <p class="text-[10px] mt-4 font-medium flex items-center">
                            <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i> Target tercapai 85%
                        </p>
                    </div>
                    <i data-lucide="car" class="absolute -right-4 -bottom-4 w-32 h-32 text-white opacity-10 group-hover:scale-110 transition-transform"></i>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
</body>
@endsection
