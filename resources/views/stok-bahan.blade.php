@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    /* Kunci Font Inter */
    * { font-family: 'Inter', sans-serif !important; }

    /* Layout Utama agar tidak berantakan */
    .gudang-main-container {
        background-color: #f4f7fb !important;
        min-height: 100vh;
    }

    /* Penjebolan kuncian viewport tinggi agar seluruh halaman bisa digeser alami ke bawah */
    html, body {
        overflow: auto !important;
        overflow-y: auto !important;
        height: auto !important;
        background-color: #f4f7fb !important;
    }
    main, .flex-1, [class*="max-h-screen"], [class*="overflow-hidden"] {
        overflow: auto !important;
        overflow-y: auto !important;
        height: auto !important;
        max-height: none !important;
    }

    /* Sembunyikan scrollbar bawaan browser luar agar tetap clean & estetik */
    .viewport-scroller::-webkit-scrollbar { display: none !important; }
    .viewport-scroller { -ms-overflow-style: none; scrollbar-width: none; }

    /* Kustomisasi scrollbar internal tipis untuk area tabel dan log */
    .tabel-scroll-gudang::-webkit-scrollbar {
        width: 6px !important;
        height: 6px !important;
    }
    .tabel-scroll-gudang::-webkit-scrollbar-track {
        background: #f1f5f9 !important;
        border-radius: 8px !important;
    }
    .tabel-scroll-gudang::-webkit-scrollbar-thumb {
        background: #cbd5e1 !important;
        border-radius: 8px !important;
    }
    .tabel-scroll-gudang::-webkit-scrollbar-thumb:hover {
        background: #2563eb !important;
    }

    /* Efek bayangan hitam abu-abu tipis lembut khas dashboard utama */
    .dashboard-smooth-shadow {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03);
    }

    .row-hover-effect:hover {
        background-color: #f8fafc !important;
    }

    .btn-interaktif {
        transition: all 0.2s ease;
    }
    .btn-interaktif:hover {
        transform: translateY(-1px);
    }
</style>

<div class="gudang-scope-master w-full h-auto min-h-screen bg-[#f4f7fb] viewport-scroller select-none antialiased text-slate-700 pb-20">

    {{-- HEADER GUDANG: WARNA BIRU CERAH SINKRON MENU SIDEBAR KAMU --}}
    <header class="w-full bg-blue-600 px-6 py-5 flex items-center justify-between shadow-md flex-shrink-0">
        <div class="flex flex-col space-y-1">
            <h1 class="text-white text-sm font-black uppercase tracking-[0.05em] leading-none">
                SISTEM MANAJEMEN STOK LOGISTIK GUDANG
            </h1>
            <p class="text-[9px] text-blue-100 font-bold uppercase tracking-wider opacity-90">
                Monitoring Inventaris Bahan Aktif, Logistik Gudang &amp; Distribusi Operasional Realtime
            </p>
        </div>

        <div class="flex items-center gap-4 flex-shrink-0">
            <div class="bg-white/10 border border-white/10 px-4 py-2 rounded-xl text-white text-[10px] font-black uppercase tracking-widest shadow-inner">
                Log Hari: <span id="realtime-date-badge" class="text-amber-300 font-black"></span>
            </div>
            <div class="bg-white px-4 py-2 rounded-xl text-blue-600 text-[10px] font-black uppercase tracking-widest flex items-center gap-2 shadow-sm border border-blue-50">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Gudang Online
            </div>
        </div>
    </header>

    <div class="p-6 flex flex-col gap-6">

        {{-- 📊 AREA 5 KOTAK CARD METRIK ATAS (TEKS INTER BOLD, BEBAS GARIS WARNA, PAKAI SHADOW LEMBUT) --}}
        <div class="grid grid-cols-5 gap-5">
            <div class="bg-white rounded-2xl p-5 dashboard-smooth-shadow border-none flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center shrink-0 shadow-lg shadow-blue-100 filter drop-shadow-[0_4px_6px_rgba(37,99,235,0.25)]">
                    <i data-lucide="wallet" class="w-5 h-5 text-white"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[9px] uppercase tracking-widest font-black text-slate-400">Total Nilai Aset</p>
                    <h4 id="stat-total-value" class="text-[14px] font-black text-blue-600 tracking-tight mt-1 truncate">Rp 0</h4>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 dashboard-smooth-shadow border-none flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-500 flex items-center justify-center shrink-0 shadow-lg shadow-blue-100 filter drop-shadow-[0_4px_6px_rgba(59,130,246,0.25)]">
                    <i data-lucide="boxes" class="w-5 h-5 text-white"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[9px] uppercase tracking-widest font-black text-slate-400">Total Sisa Stok</p>
                    <h4 id="stat-total-stock" class="text-[14px] font-black text-blue-500 tracking-tight mt-1">0 Unit</h4>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 dashboard-smooth-shadow border-none flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-500 flex items-center justify-center shrink-0 shadow-lg shadow-rose-100 filter drop-shadow-[0_4px_6px_rgba(244,63,94,0.25)]">
                    <i data-lucide="package-x" class="w-5 h-5 text-white"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[9px] uppercase tracking-widest font-black text-slate-400">Stok Habis</p>
                    <h4 id="stat-empty-items" class="text-[14px] font-black text-rose-600 mt-1">0 Item</h4>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 dashboard-smooth-shadow border-none flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500 flex items-center justify-center shrink-0 shadow-lg shadow-amber-100 filter drop-shadow-[0_4px_6px_rgba(245,158,11,0.25)]">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-white"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[9px] uppercase tracking-widest font-black text-slate-400">Stok Menipis</p>
                    <h4 id="stat-low-items" class="text-[14px] font-black text-amber-500 mt-1">0 Item</h4>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 dashboard-smooth-shadow border-none flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500 flex items-center justify-center shrink-0 shadow-lg shadow-emerald-100 filter drop-shadow-[0_4px_6px_rgba(16,185,129,0.25)]">
                    <i data-lucide="flask-conical" class="w-5 h-5 text-white"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[9px] uppercase tracking-widest font-black text-slate-400">Total Jenis</p>
                    <h4 id="stat-jenis-count" class="text-[14px] font-black text-emerald-600 mt-1">0 Jenis</h4>
                </div>
            </div>
        </div>

        {{-- 🔍 WADAH FITUR ATAS - MODEL BORDER TEGAS --}}
        <div class="bg-white p-4 rounded-2xl border border-slate-200 flex flex-wrap lg:flex-nowrap items-end gap-4 shadow-sm">
            <div class="flex-1 min-w-[200px] flex flex-col gap-1">
                <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider block">Cari Bahan Baku / Kode SKU</label>
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3.5 top-3.5 text-slate-400 w-4 h-4"></i>
                    <input type="text" id="search-input" onkeyup="jalankanSistemSaringGudang()" placeholder="Ketik nama cairan, brand, atau kode SKU..." class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2 text-xs font-bold text-slate-800 outline-none h-10 focus:border-blue-600 focus:bg-white shadow-inner transition-all">
                </div>
            </div>
            <div class="w-full lg:w-52 flex flex-col gap-1">
                <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider block">Kategori Rak</label>
                <select id="category-filter" onchange="jalankanSistemSaringGudang()" class="w-full h-10 bg-slate-50 border border-slate-200 rounded-xl px-3 text-xs font-black text-slate-700 outline-none cursor-pointer focus:border-blue-600 shadow-inner">
                    <option value="">Semua Kategori</option>
                    <option value="Shampoo & Sabun">Shampoo &amp; Sabun</option>
                    <option value="Wax & Polish">Wax &amp; Polish</option>
                    <option value="Peralatan & Lap">Peralatan &amp; Lap</option>
                    <option value="Pewangi">Pewangi</option>
                    <option value="Cairan Khusus">Cairan Khusus</option>
                </select>
            </div>
            <div class="w-full lg:w-52 flex flex-col gap-1">
                <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider block">Status Ukuran Stok</label>
                <select id="status-filter" onchange="jalankanSistemSaringGudang()" class="w-full h-10 bg-slate-50 border border-slate-200 rounded-xl px-3 text-xs font-black text-slate-700 outline-none cursor-pointer focus:border-blue-600 shadow-inner">
                    <option value="">Semua Status</option>
                    <option value="Aman">Tersedia (Aman)</option>
                    <option value="Menipis">Stok Menipis</option>
                    <option value="Habis">Habis (0 Item)</option>
                </select>
            </div>
            <div class="flex space-x-2 w-full lg:w-auto flex-shrink-0">
                <button type="button" onclick="kosongkanTotalDatabaseGudang()" class="btn-interaktif bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 px-5 h-10 rounded-xl text-xs font-black uppercase tracking-wider flex items-center justify-center">
                    <i data-lucide="trash" class="w-3.5 h-3.5 mr-1.5"></i> KOSONGKAN
                </button>
                <button type="button" onclick="bukaTutupModalBarang(true)" class="btn-interaktif bg-blue-600 hover:bg-blue-700 text-white px-5 h-10 rounded-xl text-xs font-black uppercase tracking-wider shadow-md shadow-blue-100 flex items-center justify-center border border-blue-700">
                    <i data-lucide="plus" class="w-3.5 h-3.5 mr-1.5"></i> TAMBAH STOK
                </button>
            </div>
        </div>

        {{-- 📦 WORKSPACE INVENTARIS: FLEXBOX PROPORSI KUNCI --}}
        <div class="w-full flex flex-col lg:flex-row gap-6 items-start">

            <div class="w-full lg:w-[62%] bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col flex-shrink-0">
                <div class="p-4 border-b border-slate-200 flex justify-between items-center bg-white flex-shrink-0">
                    <h3 class="font-black text-slate-800 text-xs flex items-center uppercase tracking-wider">
                        <i data-lucide="clipboard-list" class="w-4 h-4 mr-2 text-blue-600"></i> Stok Bahan Gudang
                    </h3>
                    <span id="row-count-badge" class="bg-blue-50 text-blue-600 text-[10px] font-black px-3 py-1 rounded-md uppercase border border-slate-200">0 Item</span>
                </div>

                {{-- DOUBLE SCROLLBAR AREA --}}
                <div class="overflow-x-auto overflow-y-auto max-h-[400px] text-slate-700 custom-scrollbar tabel-scroll-gudang">
                    <table class="w-full text-left table-fixed min-w-[900px] border-collapse">
                        {{-- REVISI TOTAL PENEMPATAN TEKS: Semua Th-Thead dibuat rata kiri (text-left pl-4) agar sejajar lurus vertikal dengan data di bawahnya --}}
                        <thead class="sticky top-0 z-10 bg-blue-600 text-white font-black text-[9px] uppercase tracking-widest shadow-md">
                            <tr>
                                <th class="px-4 py-4 w-[65px] text-center border-r border-blue-700">Ikon</th>
                                <th class="px-4 py-4 w-[240px] text-left pl-4 border-r border-blue-700">Item Bahan &amp; SKU</th>
                                <th class="px-4 py-4 w-[160px] text-left pl-4 border-r border-blue-700">Kategori Rak</th>
                                <th class="px-4 py-4 w-[120px] text-left pl-4 border-r border-blue-700">Volume Sisa</th>
                                <th class="px-4 py-4 w-[150px] text-left pl-4 border-r border-blue-700">Harga Aset</th>
                                <th class="px-4 py-4 w-[105px] text-center border-r border-blue-700">Status</th>
                                <th class="px-4 py-4 w-[110px] text-center">Kelola</th>
                            </tr>
                        </thead>
                        <tbody id="stock-table-body" class="divide-y divide-slate-200 text-[10.5px] font-black tracking-wide text-slate-700 bg-white align-middle">
                            </tbody>
                    </table>
                </div>
            </div>

            <div class="w-full lg:w-[38%] flex flex-col gap-4 overflow-hidden flex-shrink-0">
                <div class="bg-white p-1.5 rounded-2xl border border-slate-200 flex space-x-1 flex-shrink-0 shadow-sm">
                    <button type="button" onclick="pindahSubTabOperasional('logs')" id="tab-btn-logs" class="flex-1 py-2 text-center text-[10px] font-black rounded-xl bg-blue-600 text-white transition-all uppercase tracking-wider">Mutasi Stok</button>
                    <button type="button" onclick="pindahSubTabOperasional('suppliers')" id="tab-btn-suppliers" class="flex-1 py-2 text-center text-[10px] font-black rounded-xl text-slate-500 hover:bg-slate-50 transition-all uppercase tracking-wider">Supplier</button>
                    <button type="button" onclick="pindahSubTabOperasional('dilution')" id="tab-btn-dilution" class="flex-1 py-2 text-center text-[10px] font-black rounded-xl text-slate-500 hover:bg-slate-50 transition-all uppercase tracking-wider">Kalkulator Dilusi</button>
                </div>

                <div id="panel-logs" class="panel-content bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col h-[350px] overflow-hidden">
                    <h3 class="font-black text-slate-800 text-xs mb-4 flex items-center shrink-0 uppercase tracking-wider">
                        <i data-lucide="history" class="w-4 h-4 mr-2 text-blue-600"></i> Log Mutasi Gudang
                    </h3>

                    {{-- REVISI TIMELINE SANGAT RAPI PER BARIS CARD --}}
                    <div id="logs-container" class="relative pl-6 border-l-2 border-blue-100 space-y-4 overflow-y-auto flex-1 custom-scrollbar pr-1 text-xs">
                    </div>
                </div>

                <div id="panel-suppliers" class="panel-content hidden bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col h-[350px] overflow-hidden">
                    <h3 class="font-black text-slate-800 text-xs mb-4 flex items-center shrink-0 uppercase tracking-wider">
                        <i data-lucide="truck" class="w-4 h-4 mr-2 text-blue-600"></i> Daftar Mitra Supplier
                    </h3>
                    <div id="suppliers-container" class="space-y-3 overflow-y-auto flex-1 custom-scrollbar pr-1 text-xs">
                    </div>
                </div>

                <div id="panel-dilution" class="panel-content hidden bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col h-[350px] overflow-hidden">
                    <h3 class="font-black text-slate-800 text-xs mb-1 flex items-center shrink-0 uppercase tracking-wider">
                        <i data-lucide="calculator" class="w-4 h-4 mr-2 text-blue-600"></i> Calculator Dilusi
                    </h3>
                    <p class="text-[8px] text-slate-400 font-black uppercase tracking-widest mb-4">Formula takaran air &amp; HPP pemakaian bahan baku</p>

                    <div class="space-y-3 flex-1 overflow-y-auto custom-scrollbar pr-1 text-xs">
                        <div class="flex flex-col gap-1">
                            <label class="text-[8.5px] font-black text-slate-400 uppercase tracking-wider">Pilih Cairan Biang</label>
                            <select id="calc-material" onchange="eksekusiHitungDilusiPusat()" class="w-full bg-slate-50 border border-slate-200 h-10 px-3 rounded-xl text-xs font-bold outline-none focus:border-blue-600 shadow-inner cursor-pointer text-slate-800"></select>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex flex-col gap-1">
                                <label class="text-[8.5px] font-black text-slate-400 uppercase mb-1.5 block tracking-wider">Rasio Sabun</label>
                                <input type="number" id="calc-ratio-soap" value="1" class="w-full bg-slate-100 border border-slate-200 h-9 px-3 rounded-xl text-xs font-bold outline-none shadow-inner" readonly>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-[8.5px] font-black text-slate-400 uppercase mb-1.5 block tracking-wider">Rasio Air (1 : ...)</label>
                                <input type="number" id="calc-ratio-water" value="4" min="1" oninput="eksekusiHitungDilusiPusat()" class="w-full bg-white border border-slate-200 h-9 px-3 rounded-xl text-xs font-bold outline-none shadow-inner focus:border-blue-600">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-[8.5px] font-black text-slate-400 uppercase mb-1.5 block tracking-wider">Target Hasil Campuran (Liter)</label>
                            <input type="number" id="calc-total-volume" value="10" min="1" oninput="eksekusiHitungDilusiPusat()" class="w-full bg-white border border-slate-200 h-9 px-3 rounded-xl text-xs font-bold outline-none shadow-inner focus:border-blue-600">
                        </div>

                        <div class="bg-blue-600 text-white p-4 space-y-2.5 text-[10px] font-black rounded-2xl border border-blue-700 shadow-inner">
                            <div class="flex justify-between uppercase tracking-wide">
                                <span>Biang Diperlukan:</span>
                                <span id="calc-res-pure" class="text-white text-xs font-black">0 Liter</span>
                            </div>
                            <div class="flex justify-between uppercase tracking-wide border-t border-blue-500 pt-1.5">
                                <span class="text-amber-300 font-black">HPP / Liter Hasil:</span>
                                <span id="calc-res-cost" class="text-amber-300 text-xs font-black">Rp 0</span>
                            </div>
                            <div class="flex justify-between uppercase tracking-widest border-t border-blue-500 pt-2">
                                <span class="text-white font-black">Estimasi HPP / Mobil:</span>
                                <span id="calc-res-per-unit" class="text-amber-300 text-sm font-black">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- MODAL BOX TAMBAH BARANG --}}
<div id="add-stock-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden">
    <div class="bg-white border border-slate-200 shadow-2xl p-6 w-[450px] rounded-2xl animate-pop text-slate-700">
        <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-900 mb-4 flex items-center">
            <i data-lucide="package-plus" class="w-5 h-5 mr-2 text-blue-600"></i> Input Registrasi Bahan Baku Baru
        </h3>
        <form id="form-tambah-item" onsubmit="eksekusiSimpanBarangBaru(event)" class="space-y-4 text-xs font-black">
            <div>
                <label class="block font-black text-slate-400 uppercase text-[9px] mb-1.5 tracking-wider">Nama Lengkap Material Item</label>
                <input type="text" id="input-name" required placeholder="Contoh: Premium Snow Foam Berry V3" class="w-full border border-slate-200 px-3 py-2.5 rounded-xl font-bold outline-none focus:border-blue-600 shadow-inner bg-slate-50 focus:bg-white">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-black text-slate-400 uppercase text-[9px] mb-1.5 tracking-wider">Kode SKU Produk</label>
                    <input type="text" id="input-sku" required placeholder="Contoh: SKU-SHM-007" class="w-full border border-slate-200 px-3 py-2.5 rounded-xl font-bold outline-none focus:border-blue-600 shadow-inner bg-slate-50 focus:bg-white uppercase">
                </div>
                <div>
                    <label class="block font-black text-slate-400 uppercase text-[9px] mb-1.5 tracking-wider">Kategori Grup</label>
                    <select id="input-cat" required class="w-full border border-slate-200 h-10 px-3 rounded-xl font-black outline-none focus:border-blue-600 bg-white shadow-inner cursor-pointer text-slate-700">
                        <option value="Shampoo & Sabun">Shampoo &amp; Sabun</option>
                        <option value="Wax & Polish">Wax &amp; Polish</option>
                        <option value="Peralatan & Lap">Peralatan &amp; Lap</option>
                        <option value="Pewangi">Pewangi</option>
                        <option value="Cairan Khusus">Cairan Khusus</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block font-black text-slate-400 uppercase text-[9px] mb-1.5 tracking-wider">Vol Masuk</label>
                    <input type="number" id="input-qty" required value="10" min="1" class="w-full border border-slate-200 px-3 py-2.5 rounded-xl font-black outline-none shadow-inner bg-white">
                </div>
                <div>
                    <label class="block font-black text-slate-400 uppercase text-[9px] mb-1.5 tracking-wider">Satuan Ukuran</label>
                    <input type="text" id="input-unit" required value="Jerigen" class="w-full border border-slate-200 px-3 py-2.5 rounded-xl font-bold outline-none shadow-inner bg-slate-50 focus:bg-white">
                </div>
                <div>
                    <label class="block font-black text-slate-400 uppercase text-[9px] mb-1.5 tracking-wider">Lokasi Blok Rak</label>
                    <input type="text" id="input-rack" required value="Rak A-3" class="w-full border border-slate-200 px-3 py-2.5 rounded-xl font-bold outline-none shadow-inner bg-slate-50 focus:bg-white">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-black text-slate-400 uppercase text-[9px] mb-1.5 tracking-wider">Harga Unit Beli (Rp)</label>
                    <input type="number" id="input-price" required value="200000" min="0" class="w-full border border-slate-200 px-3 py-2.5 rounded-xl font-black outline-none shadow-inner bg-white">
                </div>
                <div>
                    <label class="block font-black text-slate-400 uppercase text-[9px] mb-1.5 tracking-wider">Brand Chemical</label>
                    <input type="text" id="input-brand" required value="Meguiars" class="w-full border border-slate-200 px-3 py-2.5 rounded-xl font-bold outline-none shadow-inner bg-slate-50 focus:bg-white">
                </div>
            </div>
            <div>
                <label class="block font-black text-slate-400 uppercase text-[9px] mb-1.5 tracking-wider">Nama Perusahaan Supplier</label>
                <input type="text" id="input-supplier" required value="PT Kimia Bersih Sejahtera" class="w-full border border-slate-200 px-3 py-2.5 rounded-xl font-bold outline-none shadow-inner bg-slate-50 focus:bg-white">
            </div>
            <div class="flex justify-end space-x-2 pt-3">
                <button type="button" onclick="bukaTutupModalBarang(false)" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 font-black uppercase tracking-wider rounded-xl transition-all">Batal</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 font-black uppercase tracking-wider rounded-xl shadow-md shadow-blue-100 transition-all border border-blue-700">Simpan Bahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    let databaseKatalogBahan = [
        { sku: "SKU-SHM-001", name: "Premium Snow Foam Shampoo Ultra", brand: "Meguiars", category: "Shampoo & Sabun", location: "Rak A-1", qty: 12, maxQty: 20, unit: "Jerigen", price: 250000, supplier: "PT Kimia Bersih Sejahtera" },
        { sku: "SKU-WAX-002", name: "Gold Class Carnauba Liquid Wax", brand: "Meguiars", category: "Wax & Polish", location: "Rak B-3", qty: 4, maxQty: 15, unit: "Botol", price: 340000, supplier: "CV Kilap Mandiri Utama" }
    ];

    let logsMutasiGudang = [
        { item: "Premium Snow Foam Shampoo Ultra", tipe: "Stok Masuk", qty: "+12 Jerigen", tgl: "Baru saja" },
        { item: "Gold Class Carnauba Liquid Wax", tipe: "Stok Masuk", qty: "+4 Botol", tgl: "Baru saja" }
    ];

    function initSistemGudangUtama() {
        const d = new Date();
        const opsi = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
        document.getElementById('realtime-date-badge').innerText = d.toLocaleDateString('id-ID', opsi);
        eksekusiRenderTotalDashboard();
    }

    function kosongkanTotalDatabaseGudang() {
        if(confirm("Apakah Anda yakin ingin mengosongkan seluruh database stok bahan gudang ke 0?")) {
            databaseKatalogBahan = [];
            logsMutasiGudang = [];
            eksekusiRenderTotalDashboard();
        }
    }

    function eksekusiRenderTotalDashboard(dataToRender = databaseKatalogBahan) {
        const tbody = document.getElementById('stock-table-body');
        tbody.innerHTML = '';

        if(dataToRender.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="p-16 text-center text-slate-400 font-bold italic text-[10px] tracking-wide uppercase border-none bg-white">
                        📋 Belum ada katalog inventaris bahan baku aktif yang didata di gudang, Chief.
                    </td>
                </tr>`;
            document.getElementById('row-count-badge').innerText = "0 Item";
            resetPanelMetrikKeNol();
            return;
        }

        dataToRender.forEach((item, index) => {
            let statusBadge = item.qty === 0 ? '<span class="bg-rose-100 text-rose-600 px-2 py-0.5 text-[7.5px] font-black uppercase tracking-wider border rounded-md border-rose-200 shadow-sm">HABIS</span>' : (item.qty <= 5 ? '<span class="bg-amber-100 text-amber-600 px-2 py-0.5 text-[7.5px] font-black uppercase tracking-wider border rounded-md border-amber-200 shadow-sm">MENIPIS</span>' : '<span class="bg-emerald-100 text-emerald-600 px-2 py-0.5 text-[7.5px] font-black uppercase tracking-wider border rounded-md border-emerald-200 shadow-sm">AMAN</span>');

            const pct = Math.min(100, Math.round((item.qty / item.maxQty) * 100));
            let pctColor = 'bg-blue-600 shadow-[0_0_6px_rgba(37,99,235,0.2)]';
            if (pct <= 20) pctColor = 'bg-rose-500';
            else if (pct <= 50) pctColor = 'bg-amber-500';

            const assetValue = item.qty * item.price;
            let iconText = item.category.includes('Shampoo') ? '🧴' : (item.category.includes('Wax') ? '✨' : '📦');

            {{-- REVISI UTAMA PENEMPATAN TEKS: Mengunci seluruh cell data (td) lurus rata kiri pl-4 agar sejajar penuh dengan judul head tabel atas --}}
            tbody.innerHTML += `
                <tr class="row-hover border-b border-slate-200 h-[55px] row-hover-effect bg-white">
                    <td class="p-2 text-center align-middle">
                        <div class="w-8 h-8 bg-blue-50 border border-blue-200 flex items-center justify-center mx-auto rounded-xl font-bold text-base shadow-inner">${iconText}</div>
                    </td>
                    <td class="px-4 py-2 border-none text-left pl-4 leading-normal align-middle">
                        <span class="text-[8.5px] text-blue-600 font-black block tracking-widest uppercase leading-none">SKU: ${item.sku}</span>
                        <span class="text-[11px] font-black text-slate-800 uppercase block mt-1.5 leading-none tracking-wide truncate max-w-[210px]">${item.name}</span>
                        <span class="text-[7.5px] font-black bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded border border-slate-200 inline-block mt-1 uppercase tracking-wider">${item.brand}</span>
                    </td>
                    <td class="px-4 py-2 border-none text-left pl-4 leading-normal align-middle">
                        <span class="font-black text-slate-700 block uppercase tracking-wide text-[9.5px]">${item.category}</span>
                        <span class="text-[8.5px] text-slate-400 font-black uppercase block mt-1.5 tracking-wider">📍 Lokasi: ${item.location}</span>
                    </td>
                    <td class="px-4 py-2 text-left pl-4 font-black text-slate-800 text-xs border-none align-middle">${item.qty} ${item.unit}</td>
                    <td class="px-4 py-2 text-left pl-4 pr-6 leading-normal align-middle">
                        <span class="text-[8px] font-bold text-slate-400 block uppercase tracking-wide">Beli: Rp ${item.price.toLocaleString('id-ID')}</span>
                        <span class="text-[11px] font-black text-blue-600 block mt-1 tracking-tight">Rp ${assetValue.toLocaleString('id-ID')}</span>
                    </td>
                    <td class="p-2 text-center align-middle">${statusBadge}</td>
                    <td class="p-2 text-center align-middle">
                        <div class="flex justify-center gap-1.5">
                            <button type="button" onclick="ubahAngkaStokManual('${item.sku}', 1)" class="btn-interaktif w-6 h-6 bg-blue-600 text-white rounded-lg flex items-center justify-center text-xs font-black shadow-sm">+</button>
                            <button type="button" onclick="ubahAngkaStokManual('${item.sku}', -1)" class="btn-interaktif w-6 h-6 bg-slate-100 text-slate-700 rounded-lg flex items-center justify-center text-xs font-black border border-slate-300 shadow-sm">-</button>
                            <button type="button" onclick="eksekusiHapusBahanPusat('${item.sku}')" class="action-btn w-6 h-6 bg-rose-50 text-rose-500 hover:bg-rose-600 hover:text-white rounded-lg flex items-center justify-center text-[11px] font-bold border border-rose-200 transition-colors shadow-sm"><i data-lucide="trash-2" class="w-3 h-3"></i></button>
                        </div>
                    </td>
                </tr>`;
        });

        document.getElementById('row-count-badge').innerText = `${dataToRender.length} Item`;
        renderSubBarsPanel();
        renderSubSuppliersPanel();
        kalkulasiFormulaFiveCardsMetriks();
        syncDropdownKalkulatorDilusi();

        if(typeof lucide !== 'undefined') lucide.createIcons();
    }

    function resetPanelMetrikKeNol() {
        document.getElementById('stat-total-value').innerText = "Rp 0";
        document.getElementById('stat-total-stock').innerText = "0 Unit";
        document.getElementById('stat-empty-items').innerText = "0 Item";
        document.getElementById('stat-low-items').innerText = "0 Item";
        document.getElementById('stat-jenis-count').innerText = "0 Jenis";
        document.getElementById('logs-container').innerHTML = '<div class="text-slate-400 italic text-[9px] py-6 text-center uppercase tracking-widest font-black opacity-80">Data Mutasi Kosong</div>';
        document.getElementById('suppliers-container').innerHTML = '<div class="text-slate-400 italic text-[9px] py-6 text-center uppercase tracking-widest font-black opacity-80">Data Supplier Kosong</div>';
        document.getElementById('calc-material').innerHTML = '';
        document.getElementById('calc-res-pure').innerText = "0 Liter";
        document.getElementById('calc-res-cost').innerText = "Rp 0";
        document.getElementById('calc-res-per-unit').innerText = "Rp 0";
    }

    function renderSubBarsPanel() {
        const container = document.getElementById('logs-container');
        if (!container) return;
        if(logsMutasiGudang.length === 0) {
            container.innerHTML = '<div class="text-slate-400 italic text-[9px] py-12 text-center uppercase tracking-widest font-black">Data Mutasi Kosong</div>';
            return;
        }
        container.innerHTML = "";
        logsMutasiGudang.forEach(log => {
            container.innerHTML += `
                <div class="relative flex flex-col justify-start items-start bg-slate-50 p-3 rounded-xl border border-slate-200 shadow-inner">
                    <div class="absolute -left-[31.5px] top-4 w-2.5 h-2.5 rounded-full border-2 border-white bg-blue-600 shadow-md"></div>
                    <div class="w-full flex justify-between items-start">
                        <span class="text-[11px] font-black text-slate-800 uppercase tracking-wide truncate max-w-[180px]">${log.item}</span>
                        <span class="text-[8px] bg-blue-600 text-white px-2 py-0.5 rounded font-black uppercase tracking-wider">${log.qty}</span>
                    </div>
                    <div class="w-full flex justify-between items-center text-[8.5px] font-black uppercase mt-2 tracking-wider">
                        <span class="text-slate-500">Aksi: ${log.tipe}</span>
                        <span class="text-slate-400">${log.tgl}</span>
                    </div>
                </div>`;
        });
    }

    function renderSubSuppliersPanel() {
        const container = document.getElementById('suppliers-container');
        if (!container) return;
        if(databaseKatalogBahan.length === 0) {
            container.innerHTML = '<div class="text-slate-400 italic text-[9px] py-12 text-center uppercase tracking-widest font-black">Data Supplier Kosong</div>';
            return;
        }
        container.innerHTML = "";
        const map = {};
        databaseKatalogBahan.forEach(s => {
            if(!map[s.supplier]) map[s.supplier] = { name: s.supplier || 'Vendor Utama', items: [] };
            if(!map[s.supplier].items.includes(s.category)) map[s.supplier].items.push(s.category);
        });
        Object.values(map).forEach(sup => {
            container.innerHTML += `
                <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1 shadow-inner">
                    <span class="text-[10px] font-black text-slate-800 uppercase tracking-wide block truncate">${sup.name}</span>
                    <p class="text-[8.5px] font-bold text-slate-400 uppercase leading-none">Hotline: 0812-3456-XXXX</p>
                    <p class="text-[8.5px] font-black text-slate-600 uppercase mt-1 leading-normal tracking-wide">Suplai: ${sup.items.join(', ')}</p>
                </div>`;
        });
    }

    function kalkulasiFormulaFiveCardsMetriks() {
        if(databaseKatalogBahan.length === 0) return;
        let totalAsset = 0, totalStokUnit = 0, habis = 0, menipis = 0;
        databaseKatalogBahan.forEach(s => {
            totalAsset += (s.qty * s.price); totalStokUnit += s.qty;
            if (s.qty === 0) habis++; else if (s.qty <= 5) menipis++;
        });
        document.getElementById('stat-total-value').innerText = `Rp ${totalAsset.toLocaleString('id-ID')}`;
        document.getElementById('stat-total-stock').innerText = `${totalStokUnit} Unit`;
        document.getElementById('stat-empty-items').innerText = `${habis} Item`;
        document.getElementById('stat-low-items').innerText = `${menipis} Item`;
        document.getElementById('stat-jenis-count').innerText = `${databaseKatalogBahan.length} Jenis`;
    }

    function jalankanSistemSaringGudang() {
        const key = document.getElementById('search-input').value.toLowerCase().trim();
        const cat = document.getElementById('category-filter').value;
        const status = document.getElementById('status-filter').value;
        const filtered = databaseKatalogBahan.filter(s => {
            const matchKey = s.name.toLowerCase().includes(key) || s.sku.toLowerCase().includes(key) || s.brand.toLowerCase().includes(key);
            const matchCat = cat === '' || s.category === cat;
            let currentStatus = s.qty === 0 ? 'Habis' : (s.qty <= 5 ? 'Menipis' : 'Aman');
            const matchStatus = status === '' || currentStatus === status;
            return matchKey && matchCat && matchStatus;
        });
        eksekusiRenderTotalDashboard(filtered);
    }

    function resetTotalFilterGudang() {
        document.getElementById('search-input').value = '';
        document.getElementById('category-filter').value = '';
        document.getElementById('status-filter').value = '';
        eksekusiRenderTotalDashboard(databaseKatalogBahan);
    }

    function eksekusiSimpanBarangBaru(event) {
        event.preventDefault();
        const name = document.getElementById('input-name').value.trim();
        const sku = document.getElementById('input-sku').value.trim().toUpperCase();
        const category = document.getElementById('input-cat').value;
        const qty = parseInt(document.getElementById('input-qty').value);
        const unit = document.getElementById('input-unit').value.trim();
        const rack = document.getElementById('input-rack').value.trim();
        const price = parseInt(document.getElementById('input-price').value);
        const brand = document.getElementById('input-brand').value.trim();
        const supplier = document.getElementById('input-supplier').value.trim();

        databaseKatalogBahan.unshift({
            sku: sku, name: name, brand: brand, category: category, location: rack,
            qty: qty, maxQty: qty * 2, unit: unit, price: price, supplier: supplier
        });

        logsMutasiGudang.unshift({ item: name, tipe: "Stok Masuk", qty: `+${qty} ${unit}`, tgl: "Baru saja" });
        eksekusiRenderTotalDashboard();
        document.getElementById('form-tambah-item').reset();
        bukaTutupModalBarang(false);
    }

    function syncDropdownKalkulatorDilusi() {
        const select = document.getElementById('calc-material');
        if (!select) return; select.innerHTML = '';
        let count = 0;
        databaseKatalogBahan.forEach(s => {
            if(s.category.includes('Shampoo') || s.category.includes('Cairan') || s.category.includes('Pewangi')) {
                select.innerHTML += `<option value="${s.sku}">[${s.brand}] ${s.name}</option>`;
                count++;
            }
        });
        if(count > 0) eksekusiHitungDilusiPusat();
    }

    function eksekusiHitungDilusiPusat() {
        const selectMaterial = document.getElementById('calc-material');
        if (!selectMaterial || selectMaterial.value === "") return;
        const sku = selectMaterial.value;
        const airRatio = parseFloat(document.getElementById('calc-ratio-water').value) || 4;
        const targetTotal = parseFloat(document.getElementById('calc-total-volume').value) || 10;
        const item = databaseKatalogBahan.find(s => s.sku === sku);
        if (!item) return;

        const bagianBiang = targetTotal / (1 + airRatio);
        document.getElementById('calc-res-pure').innerText = bagianBiang.toFixed(2) + " Liter";

        const hppPerLiter = (bagianBiang * item.price) / targetTotal / Math.max(1, item.qty);
        document.getElementById('calc-res-cost').innerText = "Rp " + Math.round(hppPerLiter).toLocaleString('id-ID');

        const hppPerMobil = hppPerLiter * 0.35;
        document.getElementById('calc-res-per-unit').innerText = "Rp " + Math.round(hppPerMobil).toLocaleString('id-ID');
    }

    function ubahAngkaStokManual(sku, change) {
        let item = databaseKatalogBahan.find(s => s.sku === sku);
        if (!item) return;
        const newQty = Math.max(0, Math.min(item.maxQty || 100, item.qty + change));
        if (item.qty === newQty) return;
        item.qty = newQty;

        logsMutasiGudang.unshift({
            item: item.name,
            tipe: change > 0 ? "Tambah Manual" : "Pakai Manual",
            qty: (change > 0 ? "+" : "-") + "1 " + item.unit,
            tgl: "Baru saja"
        });
        eksekusiRenderTotalDashboard();
    }

    function eksekusiHapusBahanPusat(sku) {
        const idx = databaseKatalogBahan.findIndex(s => s.sku === sku);
        if(idx !== -1) {
            let nameItem = databaseKatalogBahan[idx].name;
            databaseKatalogBahan.splice(idx, 1);
            logsMutasiGudang.unshift({ item: nameItem, tipe: "Hapus Katalog", qty: "Permanen", tgl: "Baru saja" });
            eksekusiRenderTotalDashboard();
        }
    }

    function pindahSubTabOperasional(tabId) {
        document.querySelectorAll('.panel-content').forEach(p => p.classList.add('hidden'));
        document.getElementById(`panel-${tabId}`).classList.remove('hidden');
        document.querySelectorAll('[id^="tab-btn-"]').forEach(btn => {
            btn.className = "flex-1 py-2 text-center text-[10px] font-extrabold rounded-lg text-slate-500 hover:bg-slate-50 transition-all uppercase tracking-wider";
        });
        document.getElementById(`tab-btn-${tabId}`).className = "flex-1 py-2 text-center text-[10px] font-extrabold rounded-xl bg-blue-600 text-white transition-all uppercase tracking-wider";
    }

    function bukaTutupModalBarang(status) {
        const modal = document.getElementById('add-stock-modal');
        status ? modal.classList.remove('hidden') : modal.classList.add('hidden');
    }

    document.addEventListener("DOMContentLoaded", () => {
        initSistemGudangUtama();
    });
</script>
@endsection
