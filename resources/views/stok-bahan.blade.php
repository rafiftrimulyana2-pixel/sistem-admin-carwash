@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    body { font-family: 'Inter', sans-serif; }

    /* Mengunci monitor agar monitor utama bersih bebas dari scrollbar ganda luar browser */
    .workspace-lock-scroll {
        height: calc(100vh - 2px);
        overflow: hidden;
    }

    /* Custom scrollbar halus untuk area tabel luas dan panel mutasi */
    .wide-scroll-clean::-webkit-scrollbar {
        width: 5px !important;
        height: 5px !important;
    }
    .wide-scroll-clean::-webkit-scrollbar-track { background: transparent; }
    .wide-scroll-clean::-webkit-scrollbar-thumb {
        background: #2563eb !important; /* Diperhidup dengan Biru Safir Solid */
        border-radius: 10px !important;
    }

    /* Custom scrollbar vertikal untuk panel kanan utility */
    .vertical-scroll-clean::-webkit-scrollbar {
        width: 4px !important;
    }
    .vertical-scroll-clean::-webkit-scrollbar-track { background: transparent; }
    .vertical-scroll-clean::-webkit-scrollbar-thumb {
        background: #cbd5e1 !important;
        border-radius: 10px !important;
    }

    .row-hover-effect {
        transition: background-color 0.15s ease;
    }
    .row-hover-effect:hover {
        background-color: #f8fafc !important;
    }

    @keyframes slideIn {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-pop { animation: slideIn 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>

<div class="w-full h-[calc(100vh-2px)] bg-[#f8fafc] flex flex-col overflow-hidden select-none antialiased text-slate-700">

    <!-- HEADER ESTETIK: Sesuai Layout Foto Bawaanmu, Warna Diperhidup Gradasi Ungu Indigo Premium -->
    <header class="bg-gradient-to-r from-[#1e40af] via-[#4338ca] to-[#6d28d9] border-b border-slate-200/20 px-8 py-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 flex-shrink-0 z-10 shadow-md">
        <div>
            <h2 class="text-white font-black text-xl tracking-tight uppercase">MANAJEMEN STOK BAHAN & INVENTARIS</h2>
            <p class="text-indigo-200 text-[10px] font-bold uppercase tracking-widest mt-1">Sistem Logistik, Analisis Finansial Aset & Formula Dilusi Workshop</p>
        </div>
        <div class="flex items-center space-x-4 flex-shrink-0">
            <div class="flex items-center space-x-2 bg-white/10 text-white px-4 py-2 rounded-xl border border-white/20 shadow-inner">
                <i data-lucide="calendar" class="w-4 h-4 text-indigo-200"></i>
                <span id="realtime-date-badge" class="text-xs font-black tracking-tight">Memuat Tanggal...</span>
            </div>
            <div class="flex items-center space-x-3 border-l pl-4 border-white/20">
                <div class="text-right">
                    <p class="text-xs font-black text-white leading-none">Logistics Admin</p>
                    <p class="text-[8px] text-indigo-200 font-bold uppercase tracking-wider mt-1">Central Warehouse</p>
                </div>
                <div class="w-9 h-9 bg-white text-blue-700 rounded-xl flex items-center justify-center font-black shadow-md">L</div>
            </div>
        </div>
    </header>

    <div class="w-full flex-1 flex flex-col p-5 gap-4 overflow-hidden">

        <!-- 5 KOTAK STATISTIK SIKU: Kotak siku biasa, ukuran sedang, warna hidup menyala, otomatis sinkron murni -->
        <div class="grid grid-cols-5 gap-4 flex-shrink-0">
            <!-- Kotak 1: Total Nilai Aset -->
            <div class="bg-white p-4.5 rounded-none border-l-4 border-l-blue-600 border-y border-r border-slate-200 shadow-sm flex items-center space-x-3.5">
                <div class="w-10 h-10 bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 shadow-inner">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[8.5px] text-slate-400 font-black uppercase tracking-wider">Total Nilai Aset Stok</p>
                    <h4 id="stat-total-value" class="text-xs font-black text-slate-900 mt-0.5">Rp 0</h4>
                </div>
            </div>
            <!-- Kotak 2: Total Sisa Stok -->
            <div class="bg-white p-4.5 rounded-none border-l-4 border-l-sky-500 border-y border-r border-slate-200 shadow-sm flex items-center space-x-3.5">
                <div class="w-10 h-10 bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 shadow-inner">
                    <i data-lucide="boxes" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[8.5px] text-slate-400 font-black uppercase tracking-wider">Total Sisa Stok</p>
                    <h4 id="stat-total-stock" class="text-xs font-black text-slate-900 mt-0.5">0 Unit</h4>
                </div>
            </div>
            <!-- Kotak 3: Stok Habis -->
            <div class="bg-white p-4.5 rounded-none border-l-4 border-l-rose-600 border-y border-r border-slate-200 shadow-sm flex items-center space-x-3.5">
                <div class="w-10 h-10 bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 shadow-inner">
                    <i data-lucide="package-x" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[8.5px] text-slate-400 font-black uppercase tracking-wider">Stok Habis</p>
                    <h4 id="stat-empty-items" class="text-xs font-black text-rose-600 mt-0.5">0 Item</h4>
                </div>
            </div>
            <!-- Kotak 4: Stok Menipis -->
            <div class="bg-white p-4.5 rounded-none border-l-4 border-l-amber-500 border-y border-r border-slate-200 shadow-sm flex items-center space-x-3.5">
                <div class="w-10 h-10 bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 shadow-inner">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[8.5px] text-slate-400 font-black uppercase tracking-wider">Stok Menipis</p>
                    <h4 id="stat-low-items" class="text-xs font-black text-amber-600 mt-0.5">0 Item</h4>
                </div>
            </div>
            <!-- Kotak 5: Total Jumlah Bahan -->
            <div class="bg-white p-4.5 rounded-none border-l-4 border-l-emerald-500 border-y border-r border-slate-200 shadow-sm flex items-center space-x-3.5">
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 shadow-inner">
                    <i data-lucide="beaker" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[8.5px] text-slate-400 font-black uppercase tracking-wider">Total Jumlah Bahan</p>
                    <h4 id="stat-jenis-count" class="text-xs font-black text-slate-900 mt-0.5">0 Jenis</h4>
                </div>
            </div>
        </div>

        <!-- FILTER ACTION BAR -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex-shrink-0">
            <div class="flex flex-wrap md:flex-nowrap items-end gap-3.5">
                <div class="flex-1 min-w-[200px]">
                    <label class="text-[8px] font-bold text-slate-400 uppercase mb-1.5 block tracking-wider">Cari Bahan / Kode SKU</label>
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-3 top-2.5 text-slate-400 w-4 h-4"></i>
                        <input type="text" id="search-input" onkeyup="jalankanSistemSaringGudang()" placeholder="Ketik nama bahan, brand, atau kode SKU..." class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-4 py-2 text-xs font-bold text-slate-800 focus:border-blue-600 outline-none transition-all shadow-inner">
                    </div>
                </div>
                <div class="w-full md:w-44">
                    <label class="text-[8px] font-bold text-slate-400 uppercase mb-2 block tracking-wider">Kategori Bahan</label>
                    <select id="category-filter" onchange="jalankanSistemSaringGudang()" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold outline-none cursor-pointer focus:border-blue-600 shadow-inner">
                        <option value="">Semua Kategori</option>
                        <option value="Shampoo & Sabun">Shampoo & Sabun</option>
                        <option value="Wax & Polish">Wax & Polish</option>
                        <option value="Peralatan & Lap">Peralatan & Lap</option>
                        <option value="Pewangi">Pewangi</option>
                        <option value="Cairan Khusus">Cairan Khusus</option>
                    </select>
                </div>
                <div class="w-full md:w-44">
                    <label class="text-[8px] font-bold text-slate-400 uppercase mb-2 block tracking-wider">Status Ukuran Stok</label>
                    <select id="status-filter" onchange="jalankanSistemSaringGudang()" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold outline-none cursor-pointer focus:border-blue-600 shadow-inner">
                        <option value="">Semua Status</option>
                        <option value="Aman">Tersedia (Aman)</option>
                        <option value="Menipis">Stok Menipis</option>
                        <option value="Habis">Habis (0 Item)</option>
                    </select>
                </div>
                <div class="flex space-x-2 w-full md:w-auto">
                    <button type="button" onclick="resetTotalFilterGudang()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl text-xs font-black transition-all flex items-center justify-center shrink-0">
                        <i data-lucide="sliders-horizontal" class="w-3.5 h-3.5 mr-1.5"></i> RESET
                    </button>
                    <button type="button" onclick="bukaTutupModalBarang(true)" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-black shadow-md shadow-blue-100 transition-all flex items-center justify-center shrink-0">
                        <i data-lucide="plus" class="w-3.5 h-3.5 mr-1.5"></i> TAMBAH STOK
                    </button>
                </div>
            </div>
        </div>

        <!-- MAIN VIEW WORKSPACE SPLIT HUB (62% Kiri, 38% Kanan Sejajar Sempurna Sesuai Struktur Foto 2) -->
        <div class="w-full flex-1 flex gap-4 overflow-hidden min-h-0">

            <!-- 📁 SISI KIRI: TABEL PERSEDIAAN BAHAN (62% LEBAR, KOLOM LUAS PENEMPATAN SEDANG) -->
            <div class="w-[62%] h-full bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">
                <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-white flex-shrink-0">
                    <h3 class="font-black text-slate-800 text-xs flex items-center uppercase tracking-tight">
                        <i data-lucide="clipboard-list" class="w-4.5 h-4.5 mr-1.5 text-blue-600"></i> Tabel Rincian Data Ringkasan Persediaan Bahan Gudang Utama Carwash
                    </h3>
                    <span id="row-count-badge" class="bg-blue-50 text-blue-600 text-[10px] font-black px-2.5 py-0.5 rounded-full">0 Item</span>
                </div>

                <div class="flex-1 overflow-auto wide-scroll-clean">
                    <table class="w-full text-left table-fixed min-w-[950px] border-collapse">
                        <thead class="sticky top-0 z-10 bg-slate-50 shadow-sm">
                            <tr class="text-[9px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                <th class="px-5 py-3 w-[75px] text-center">Ikon</th>
                                <th class="px-5 py-3 w-[260px]">Nama Item Bahan Baku / Kode SKU</th>
                                <th class="px-4 py-3 w-[180px]">Kategori Ruang Rak</th>
                                <th class="px-4 py-3 w-[150px] text-center">Volume Wadah Aktif</th>
                                <th class="px-4 py-3 w-[170px] text-right">Harga Satuan Beli</th>
                                <th class="px-4 py-3 w-[130px] text-center">Status Sisa Gudang</th>
                                <th class="px-4 py-3 w-[100px] text-center">Kelola</th>
                            </tr>
                        </thead>
                        <tbody id="stock-table-body" class="divide-y divide-slate-100 text-[11px] font-bold text-slate-800">
                            <!-- JS AUTO INJECTION DATA -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ⏳ SISI KANAN: PANELS UTILITY (38% LEBAR LAPANG & TATA LETAK RAPI) -->
            <div class="w-[38%] h-full flex flex-col gap-3 overflow-hidden">
                <div class="bg-white p-1.5 rounded-xl border border-slate-200/80 flex space-x-1 flex-shrink-0 shadow-sm">
                    <button type="button" onclick="pindahSubTabOperasional('logs')" id="tab-btn-logs" class="flex-1 py-1.5 text-center text-[10px] font-black rounded-lg bg-blue-600 text-white transition-all">Mutasi Stok</button>
                    <button type="button" onclick="pindahSubTabOperasional('suppliers')" id="tab-btn-suppliers" class="flex-1 py-1.5 text-center text-[10px] font-black rounded-lg text-slate-500 hover:bg-slate-50 transition-all">Supplier</button>
                    <button type="button" onclick="pindahSubTabOperasional('dilution')" id="tab-btn-dilution" class="flex-1 py-1.5 text-center text-[10px] font-black rounded-lg text-slate-500 hover:bg-slate-50 transition-all">Kalkulator Dilusi</button>
                </div>

                <!-- TAB A: LOG MUTASI STOK -->
                <div id="panel-logs" class="panel-content bg-white p-4.5 rounded-2xl border border-slate-200 shadow-sm flex flex-col flex-1 overflow-hidden">
                    <h3 class="font-black text-slate-800 text-xs mb-3 flex items-center shrink-0 uppercase tracking-tight">
                        <i data-lucide="history" class="w-4.5 h-4.5 mr-1.5 text-indigo-500"></i> Catatan Historis Log Mutasi Alur Keluar Masuk Stok
                    </h3>
                    <div id="logs-container" class="relative pl-5 border-l border-slate-100 space-y-4 overflow-y-auto flex-1 vertical-scroll-clean pr-1 text-xs">
                        <!-- SUNTIK DATA LOGS -->
                    </div>
                </div>

                <!-- TAB B: REKANAN SUPPLIER -->
                <div id="panel-suppliers" class="panel-content hidden bg-white p-4.5 rounded-2xl border border-slate-200 shadow-sm flex flex-col flex-1 overflow-hidden">
                    <h3 class="font-black text-slate-800 text-xs mb-3 flex items-center shrink-0 uppercase tracking-tight">
                        <i data-lucide="truck" class="w-4.5 h-4.5 mr-1.5 text-emerald-600"></i> Daftar Rekanan Vendor & Mitra Supplier Utama
                    </h3>
                    <div id="suppliers-container" class="space-y-3 overflow-y-auto flex-1 vertical-scroll-clean pr-1 text-xs">
                        <!-- SUNTIK DATA SUPPLIER -->
                    </div>
                </div>

                <!-- TAB C: KALKULATOR DILUSI -->
                <div id="panel-dilution" class="panel-content hidden bg-white p-4.5 rounded-2xl border border-slate-200 shadow-sm flex flex-col flex-1 overflow-hidden">
                    <h3 class="font-black text-slate-800 text-xs mb-0.5 flex items-center shrink-0 uppercase tracking-tight">
                        <i data-lucide="calculator" class="w-4.5 h-4.5 mr-1.5 text-blue-600"></i> Alat Hitung Formula Rasio Dilusi Campuran
                    </h3>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider mb-3">Formula Takaran Air & Estimasi HPP Bahan Per Unit Mobil</p>

                    <div class="space-y-3 flex-1 overflow-y-auto vertical-scroll-clean pr-1 text-xs">
                        <div>
                            <label class="text-[8.5px] font-black text-slate-400 uppercase mb-1 block">Pilih Cairan Biang Aktif</label>
                            <select id="calc-material" onchange="eksekusiHitungDilusiPusat()" class="w-full bg-slate-50 border border-slate-200 rounded-none p-2 text-xs font-bold outline-none focus:border-blue-600 shadow-inner cursor-pointer text-slate-800"></select>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[8.5px] font-black text-slate-400 uppercase mb-1 block">Rasio Sabun</label>
                                <input type="number" id="calc-ratio-soap" value="1" class="w-full bg-slate-50 border border-slate-200 rounded-none p-1.5 text-xs font-black outline-none shadow-inner" readonly>
                            </div>
                            <div>
                                <label class="text-[8.5px] font-black text-slate-400 uppercase mb-1 block">Rasio Air (1 : ...)</label>
                                <input type="number" id="calc-ratio-water" value="4" min="1" oninput="eksekusiHitungDilusiPusat()" class="w-full bg-white border border-slate-200 rounded-none p-1.5 text-xs font-black outline-none shadow-inner">
                            </div>
                        </div>
                        <div>
                            <label class="text-[8.5px] font-black text-slate-400 uppercase mb-1 block">Target Volume Hasil Dilusi (Liter)</label>
                            <input type="number" id="calc-total-volume" value="10" min="1" oninput="eksekusiHitungDilusiPusat()" class="w-full bg-slate-50 border border-slate-200 rounded-none p-1.5 text-xs font-black outline-none shadow-inner">
                        </div>

                        <!-- Hasil Rumus Dilusi Berwarna Hidup Super Vibrant Neon Style -->
                        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white p-3.5 space-y-2 text-[11px] shadow-md border border-white/10">
                            <div class="flex justify-between font-bold">
                                <span class="text-blue-100">Biang Sabun Diperlukan:</span>
                                <span id="calc-res-pure" class="font-black text-white">0 Liter</span>
                            </div>
                            <div class="flex justify-between font-bold border-t border-white/10 pt-1.5">
                                <span class="text-emerald-300 font-black">HPP Harga Cairan / Liter:</span>
                                <span id="calc-res-cost" class="font-black text-emerald-300">Rp 0</span>
                            </div>
                            <div class="flex justify-between text-xs font-bold border-t border-white/10 pt-2">
                                <span class="text-white font-black tracking-wide">Estimasi HPP Pemakaian / Mobil:</span>
                                <span id="calc-res-per-unit" class="font-black text-amber-300 text-sm">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- ======================= MODAL POPUP: FORM TAMBAH STOK BARU ======================= -->
<div id="add-stock-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden">
    <div class="bg-white border border-slate-200 shadow-2xl p-6 w-[440px] rounded-none animate-pop text-slate-700">
        <h3 class="text-xs font-black uppercase tracking-wider text-slate-900 mb-4 flex items-center">
            <i data-lucide="package-plus" class="w-4.5 h-4.5 mr-2 text-blue-600"></i> Input Form Registrasi Tambah Stok Bahan Baru
        </h3>
        <form id="form-tambah-item" onsubmit="eksekusiSimpanBarangBaru(event)" class="space-y-3.5 text-xs font-bold">
            <div>
                <label class="block font-black text-slate-400 uppercase text-[8.5px] mb-1">Nama Lengkap Material Item</label>
                <input type="text" id="input-name" required placeholder="Premium Snow Foam Berry V3" class="w-full border border-slate-200 p-2.5 rounded-none font-bold outline-none focus:border-blue-600 shadow-inner">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-black text-slate-400 uppercase text-[8.5px] mb-1">Kode SKU Produk</label>
                    <input type="text" id="input-sku" required placeholder="SKU-SHM-007" class="w-full border border-slate-200 p-2.5 rounded-none font-bold outline-none focus:border-blue-600 shadow-inner">
                </div>
                <div>
                    <label class="block font-black text-slate-400 uppercase text-[8.5px] mb-1">Kategori Grup</label>
                    <select id="input-cat" required class="w-full border border-slate-200 p-2.5 rounded-none font-bold outline-none focus:border-blue-600 bg-white shadow-inner cursor-pointer text-slate-800">
                        <option value="Shampoo & Sabun">Shampoo & Sabun</option>
                        <option value="Wax & Polish">Wax & Polish</option>
                        <option value="Peralatan & Lap">Peralatan & Lap</option>
                        <option value="Pewangi">Pewangi</option>
                        <option value="Cairan Khusus">Cairan Khusus</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <div>
                    <label class="block font-black text-slate-400 uppercase text-[8.5px] mb-1">Vol Masuk</label>
                    <input type="number" id="input-qty" required value="10" min="1" class="w-full border border-slate-200 p-2.5 rounded-none font-black outline-none shadow-inner">
                </div>
                <div>
                    <label class="block font-black text-slate-400 uppercase text-[8.5px] mb-1">Satuan Ukuran</label>
                    <input type="text" id="input-unit" required value="Jerigen" class="w-full border border-slate-200 p-2.5 rounded-none font-bold outline-none shadow-inner">
                </div>
                <div>
                    <label class="block font-black text-slate-400 uppercase text-[8.5px] mb-1">Lokasi Blok Rak</label>
                    <input type="text" id="input-rack" required value="Rak A-3" class="w-full border border-slate-200 p-2.5 rounded-none font-bold outline-none shadow-inner">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-black text-slate-400 uppercase text-[8.5px] mb-1">Harga Unit (Rp)</label>
                    <input type="number" id="input-price" required value="200000" min="0" class="w-full border border-slate-200 p-2.5 rounded-none font-black outline-none shadow-inner">
                </div>
                <div>
                    <label class="block font-black text-slate-400 uppercase text-[8.5px] mb-1">Brand Vendor</label>
                    <input type="text" id="input-brand" required value="Meguiars" class="w-full border border-slate-200 p-2.5 rounded-none font-bold outline-none shadow-inner">
                </div>
            </div>
            <div>
                <label class="block font-black text-slate-400 uppercase text-[8.5px] mb-1">Nama Perusahaan Supplier</label>
                <input type="text" id="input-supplier" required value="PT Kimia Bersih Sejahtera" class="w-full border border-slate-200 p-2.5 rounded-none font-bold outline-none shadow-inner">
            </div>
            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" onclick="bukaTutupModalBarang(false)" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 font-black uppercase tracking-wider rounded-none">Batal</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 font-black uppercase tracking-wider rounded-none shadow-md">Simpan Bahan</button>
            </div>
        </form>
    </div>
</div>

<div id="toast-container" class="fixed bottom-6 right-6 z-50 flex flex-col gap-2 pointer-events-none"></div>

<!-- ======================= LIVE ENGINE SINKRONISASI REAL-TIME JAVASCRIPT ======================= -->
<script>
    let databaseKatalogBahan = [
        { sku: 'SKU-SHM-001', name: 'Premium Snow Foam V2', brand: 'Meguiars', category: 'Shampoo & Sabun', location: 'Rak A-1', qty: 12, maxQty: 25, unit: 'Jerigen', price: 250000, icon: 'droplet' },
        { sku: 'SKU-WAX-002', name: 'Hi-Gloss Carnauba Paste Wax', brand: 'Turtle Wax', category: 'Wax & Polish', location: 'Rak B-3', qty: 3, maxQty: 10, unit: 'Botol', price: 185000, icon: 'sparkles' },
        { sku: 'SKU-FRG-004', name: 'Vanilla Air Perfume Spray', brand: 'Little Trees', category: 'Pewangi', location: 'Rak D-2', qty: 0, maxQty: 15, unit: 'Botol', price: 85000, icon: 'wind' },
        { sku: 'SKU-APC-005', name: 'Heavy Duty Engine Degreaser', brand: 'Sonax', category: 'Cairan Khusus', location: 'Rak A-2', qty: 6, maxQty: 15, unit: 'Jerigen', price: 320000, icon: 'flask-conical' },
        { sku: 'SKU-GLS-006', name: 'Crystal Clear Glass Concentrate', brand: 'Stoner Care', category: 'Cairan Khusus', location: 'Rak B-1', qty: 4, maxQty: 12, unit: 'Botol', price: 125000, icon: 'beaker' }
    ];

    let logsMutasiGudang = [
        { waktu: '10 mnt lalu', item: 'Premium Snow Foam V2', tipe: 'Tambah Stok', qty: '+5 Jerigen', warna: 'text-emerald-600 bg-emerald-50', operator: 'Admin Kasir' },
        { waktu: '2 jam lalu', item: 'Hi-Gloss Carnauba Paste Wax', tipe: 'Usage Gudang', qty: '-1 Botol', warna: 'text-rose-600 bg-rose-50', operator: 'Mekanik Ahmad' }
    ];

    function initSistemGudangUtama() {
        const d = new Date();
        const opsi = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
        document.getElementById('realtime-date-badge').innerText = d.toLocaleDateString('id-ID', opsi);

        eksekusiRenderTotalDashboard();
    }

    function eksekusiRenderTotalDashboard(dataToRender = databaseKatalogBahan) {
        const tbody = document.getElementById('stock-table-body');
        tbody.innerHTML = '';

        dataToRender.forEach(item => {
            let statusBadge = item.qty === 0 ? '<span class="bg-rose-500 text-white px-2 py-0.5 text-[9px] font-black uppercase tracking-wider rounded-none">HABIS</span>' : (item.qty <= 5 ? '<span class="bg-amber-500 text-white px-2 py-0.5 text-[9px] font-black uppercase tracking-wider rounded-none">MENIPIS</span>' : '<span class="bg-emerald-600 text-white px-2 py-0.5 text-[9px] font-black uppercase tracking-wider rounded-none">AMAN</span>');

            const pct = Math.min(100, Math.round((item.qty / item.maxQty) * 100));
            let pctColor = 'bg-gradient-to-r from-blue-500 to-indigo-600 shadow-[0_0_6px_rgba(59,130,246,0.5)]';
            if (pct <= 20) pctColor = 'bg-gradient-to-r from-rose-500 to-red-600 shadow-[0_0_6px_rgba(244,63,94,0.5)]';
            else if (pct <= 50) pctColor = 'bg-gradient-to-r from-amber-400 to-orange-500 shadow-[0_0_6px_rgba(251,191,36,0.5)]';

            const assetValue = item.qty * item.price;

            // FIX: MENGGUNAKAN TEKNIK SVG INJECTION KANDUNGAN HARDCODED - 100% TIDAK BISA HILANG DI BROWSER
            let svgIcon = '';
            if (item.category.includes('Shampoo')) {
                svgIcon = `<svg class="w-5 h-5 text-blue-600 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.105-6 11.5-6 11.5s-6-4.395-6-11.5a6 6 0 0112 0z"/></svg>`;
            } else if (item.category.includes('Wax')) {
                svgIcon = `<svg class="w-5 h-5 text-amber-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4M4 19h4m12-12v4m-2-2h4m-5 9v4m-2-2h4m-4-6l-1.5 2.5L10 15l2.5 1.5L14 14l1.5-2.5L14 9l-2.5-1.5L10 9z"/></svg>`;
            } else if (item.category.includes('Pewangi')) {
                svgIcon = `<svg class="w-5 h-5 text-sky-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>`;
            } else {
                svgIcon = `<svg class="w-5 h-5 text-purple-600 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>`;
            }

            tbody.innerHTML += `
                <tr class="row-hover-effect border-none">
                    <td class="p-3 text-center border-none">
                        <div class="w-9 h-9 bg-slate-50 border border-slate-100 flex items-center justify-center mx-auto rounded-none">
                            ${svgIcon}
                        </div>
                    </td>
                    <td class="p-3 border-none">
                        <span class="text-[9px] text-slate-400 font-black block leading-none">SKU-ID: ${item.sku}</span>
                        <span class="text-xs font-black text-slate-800 uppercase block mt-1.5 leading-none">${item.name}</span>
                        <span class="text-[7.5px] font-black bg-slate-100 text-slate-500 px-1 py-0.5 rounded inline-block mt-1">${item.brand}</span>
                    </td>
                    <td class="p-3 border-none leading-none">
                        <span class="font-black text-slate-700 block">${item.category}</span>
                        <span class="text-[9px] text-slate-400 uppercase block mt-1.5">📍 Rak: ${item.location}</span>
                    </td>
                    <td class="p-3 text-center font-black text-slate-900 border-none text-xs">
                        <div class="w-24 mx-auto flex flex-col gap-1">
                            <div class="flex justify-between text-[8px] text-slate-400 font-black">
                                <span>${item.qty}/${item.maxQty}</span>
                                <span>${item.unit}</span>
                            </div>
                            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden shadow-inner">
                                <div class="${pctColor} h-full transition-all duration-300" style="width: ${pct}%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="p-3 text-right font-black border-none leading-none">
                        <span class="text-[8.5px] font-bold text-slate-400 block">Beli: Rp ${item.price.toLocaleString('id-ID')}</span>
                        <span class="text-xs font-black text-blue-600 block mt-1.5">Rp ${assetValue.toLocaleString('id-ID')}</span>
                    </td>
                    <td class="p-3 text-center border-none">${statusBadge}</td>
                    <td class="p-3 text-center border-none relative">
                        <div class="flex justify-center gap-1">
                            <button type="button" onclick="ubahAngkaStokManual('${item.sku}', 1)" class="p-1 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 rounded-md transition-colors"><i data-lucide="plus" class="w-3.5 h-3.5"></i></button>
                            <button type="button" onclick="ubahAngkaStokManual('${item.sku}', -1)" class="p-1 bg-slate-100 hover:bg-rose-50 hover:text-rose-600 rounded-md transition-colors"><i data-lucide="minus" class="w-3.5 h-3.5"></i></button>
                            <button type="button" onclick="eksekusiHapusBahanPusat('${item.sku}')" class="p-1 bg-slate-100 hover:bg-rose-200 text-slate-400 hover:text-rose-600 rounded-md transition-colors"><i data-lucide="trash-2" class="w-3.5 h-3.5"></i></button>
                        </div>
                    </td>
                </tr>
            `;
        });

        document.getElementById('row-count-badge').innerText = `${dataToRender.length} Item`;

        renderSubLogsPanel();
        renderSubSuppliersPanel();
        kalkulasiFormulaFiveCardsMetriks();
        syncDropdownKalkulatorDilusi();

        lucide.createIcons();
    }

    function renderSubLogsPanel() {
        const container = document.getElementById('logs-container');
        container.innerHTML = "";
        logsMutasiGudang.forEach(log => {
            container.innerHTML += `
                <div class="relative pl-1">
                    <div class="absolute -left-[24.5px] top-1 w-2.5 h-2.5 rounded-full border-2 border-white bg-blue-600 shadow-sm"></div>
                    <div class="text-xs">
                        <h4 class="text-xs font-black text-slate-800 leading-none uppercase">${log.item}</h4>
                        <p class="text-[8.5px] font-black uppercase mt-1 text-slate-500">${log.tipe} (${log.qty})</p>
                        <div class="flex justify-between items-center text-[7.5px] font-bold text-slate-400 mt-1 uppercase">
                            <span>PIC: <span class="text-slate-600">${log.operator}</span></span>
                            <span>${log.waktu}</span>
                        </div>
                    </div>
                </div>
            `;
        });
    }

    function renderSubSuppliersPanel() {
        const container = document.getElementById('suppliers-container');
        container.innerHTML = "";
        const map = {};
        databaseKatalogBahan.forEach(s => {
            if(!map[s.supplier]) map[s.supplier] = { name: s.supplier, items: [] };
            if(!map[s.supplier].items.includes(s.category)) map[s.supplier].items.push(s.category);
        });
        Object.values(map).forEach(sup => {
            container.innerHTML += `
                <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl space-y-1 text-xs">
                    <span class="text-xs font-black text-slate-800 uppercase tracking-tight block">${sup.name}</span>
                    <p class="text-[8.5px] font-bold text-slate-400 uppercase leading-none">Hotline: 0812-3456-7890</p>
                    <p class="text-[8px] font-black text-slate-600 uppercase mt-1 leading-normal">Kategori: ${sup.items.join(', ')}</p>
                </div>
            `;
        });
    }

    function kalkulasiFormulaFiveCardsMetriks() {
        let totalAsset = 0, totalStokUnit = 0, habis = 0, menipis = 0;
        databaseKatalogBahan.forEach(s => {
            totalAsset += (s.qty * s.price);
            totalStokUnit += s.qty;
            if (s.qty === 0) {
                habis++; // CRITICAL FIX: Menghapus total bugs reference crash!
            } else if (s.qty <= 5) {
                menipis++;
            }
        });

        document.getElementById('stat-total-value').innerText = `Rp ${totalAsset.toLocaleString('id-ID')}`;
        document.getElementById('stat-total-stock').innerText = `${totalStokUnit} Unit`;
        document.getElementById('stat-empty-items').innerText = `${habis} Item`;
        document.getElementById('stat-low-items').innerText = `${menipis} Item`;
        document.getElementById('stat-jenis-count').innerText = `${databaseKatalogBahan.length} Jenis`;
    }

    function jalankanSistemSaringGudang() {
        const key = document.getElementById('search-input').value.toLowerCase();
        const cat = document.getElementById('category-filter').value;
        const status = document.getElementById('status-filter').value;

        const filtered = databaseKatalogBahan.filter(s => {
            const matchKey = s.name.toLowerCase().includes(key) || s.sku.toLowerCase().includes(key) || s.brand.toLowerCase().includes(key);
            const matchCat = cat === '' || s.category === cat;
            const matchStatus = status === '' || hitungStatusSisa(s.qty, 5) === status;
            return matchKey && matchCat && matchStatus;
        });
        eksekusiRenderTotalDashboard(filtered);
    }

    function resetTotalFilterGudang() {
        document.getElementById('search-input').value = '';
        document.getElementById('category-filter').value = '';
        document.getElementById('status-filter').value = '';
        eksekusiRenderTotalDashboard();
    }

    function eksekusiSimpanBarangBaru(event) {
        event.preventDefault();
        const name = document.getElementById('input-name').value.trim();
        const sku = document.getElementById('input-sku').value.trim();
        const category = document.getElementById('input-cat').value;
        const qty = parseInt(document.getElementById('input-qty').value);
        const unit = document.getElementById('input-unit').value.trim();
        const rack = document.getElementById('input-rack').value.trim();
        const price = parseInt(document.getElementById('input-price').value);
        const brand = document.getElementById('input-brand').value.trim();
        const supplier = document.getElementById('input-supplier').value.trim();

        databaseKatalogBahan.unshift({
            sku: sku, name: name, brand: brand, category: category, location: rack,
            qty: qty, maxQty: qty * 2, unit: unit, price: price, supplier: supplier, icon: 'beaker'
        });

        logsMutasiGudang.unshift({ waktu: 'Baru Saja', item: name, tipe: 'Tambah Stok', qty: `+${qty} ${unit}`, operator: 'Kasir Pusat' });
        eksekusiRenderTotalDashboard();
        document.getElementById('form-tambah-item').reset();
        bukaTutupModalBarang(false);
    }

    function syncDropdownKalkulatorDilusi() {
        const select = document.getElementById('calc-material');
        if (!select) return; select.innerHTML = '';
        databaseKatalogBahan.forEach(s => {
            if(s.category.includes('Shampoo') || s.category.includes('Cairan')) {
                select.innerHTML += `<option value="${s.sku}">[${s.brand}] ${s.name}</option>`;
            }
        });
        eksekusiHitungDilusiPusat();
    }

    function eksekusiHitungDilusiPusat() {
        const sku = document.getElementById('calc-material').value;
        const airRatio = parseFloat(document.getElementById('dilusi-air').value) || 4;
        const targetTotal = parseFloat(document.getElementById('dilusi-target').value) || 10;
        const item = databaseKatalogBahan.find(s => s.sku === sku);
        if (!item) return;

        const bagianBiang = targetTotal / (1 + airRatio);
        document.getElementById('calc-res-pure').innerText = bagianBiang.toFixed(2) + " Liter";
        const hppPerMobil = ((bagianBiang / 5) * item.price / targetTotal) * 0.25;
        document.getElementById('calc-res-per-unit').innerText = "Rp " + Math.round(hppPerMobil).toLocaleString('id-ID');
    }

    function ubahAngkaStokManual(sku, change) {
        let item = databaseKatalogBahan.find(s => s.sku === sku);
        if (!item) return;
        const newQty = Math.max(0, Math.min(item.maxQty || 100, item.qty + change));
        if (item.qty === newQty) return;
        item.qty = newQty;
        logsMutasiGudang.unshift({ waktu: 'Baru Saja', item: item.name, tipe: change > 0 ? 'Tambah Stok' : 'Usage Gudang', qty: (change > 0 ? '+' : '') + change + ' ' + item.unit, operator: 'Warehouse Staff' });
        eksekusiRenderTotalDashboard();
    }

    function eksekusiHapusBahanPusat(sku) {
        const idx = databaseKatalogBahan.findIndex(s => s.sku === sku);
        if(idx !== -1) { databaseKatalogBahan.splice(idx, 1); eksekusiRenderTotalDashboard(); }
    }

    function hitungStatusSisa(qty, min) {
        if (qty === 0) return 'Habis';
        if (qty <= min) return 'Menipis';
        return 'Aman';
    }

    function pindahSubTabOperasional(tabId) {
        document.querySelectorAll('.panel-content').forEach(p => p.classList.add('hidden'));
        document.getElementById(`panel-${tabId}`).classList.remove('hidden');
        document.querySelectorAll('[id^="tab-btn-"]').forEach(btn => {
            btn.className = "flex-1 py-1.5 text-center text-[10px] font-black rounded-lg text-slate-500 hover:bg-slate-50 transition-all";
        });
        document.getElementById(`tab-btn-${tabId}`).className = "flex-1 py-1.5 text-center text-[10px] font-black rounded-lg bg-blue-600 text-white transition-all";
    }

    function pindahSubTabUtility(tabId) {
        pindahSubTabOperasional(tabId);
    }

    function bukaTutupModalBarang(status) {
        const modal = document.getElementById('add-stock-modal');
        if (status) modal.classList.remove('hidden'); else modal.classList.add('hidden');
    }

    document.addEventListener("DOMContentLoaded", initSistemGudangUtama);
</script>
@endsection
