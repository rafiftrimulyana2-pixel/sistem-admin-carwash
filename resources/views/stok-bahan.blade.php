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
                SISTEM MANAJEMEN STOK GUDANG
            </h1>
            <p class="text-[9px] text-blue-100 font-bold uppercase tracking-wider opacity-90">
                Inventory Management System
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

    <div class="p-5 flex flex-col gap-5">

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

        <div class="bg-white rounded-2xl border shadow-lg shadow-slate-100/10 overflow-hidden">

        {{-- AREA FILTER LENGKAP --}}
        <div class="p-6 grid grid-cols-4 gap-4 items-end">
            <div class="col-span-1">
            <label class="text-[9px] font-black text-slate-400 uppercase mb-1 block">Cari Bahan/SKU</label>
            <div class="relative flex items-center">
                <i data-lucide="search" class="absolute left-3 w-4 h-4 text-slate-400"></i>

                <input type="text" id="search-input" onkeyup="render()" placeholder="Cari..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-xs font-bold h-10 outline-none focus:border-blue-600 shadow-inner">
            </div>
        </div>

        <div class="col-span-1">
            <label class="text-[9px] font-black text-slate-400 uppercase mb-1 block">Kategori</label>
            <select id="cat-filter" onchange="render()" class="w-full h-10 bg-slate-50 border border-slate-200 rounded-xl px-3 text-xs font-black outline-none shadow-inner focus:border-blue-600">
                <option value="">Semua Kategori</option>
                <option value="Shampoo & Sabun">Shampoo & Sabun</option>
                <option value="Wax & Polish">Wax & Polish</option>
            </select>
        </div>

        <div class="col-span-1">
            <label class="text-[9px] font-black text-slate-400 uppercase mb-1 block">Status Stok</label>
            <select id="stat-filter" onchange="render()" class="w-full h-10 bg-slate-50 border border-slate-200 rounded-xl px-3 text-xs font-black outline-none shadow-inner focus:border-blue-600">
                <option value="">Semua Status</option>
                <option value="AMAN">Aman</option>
                <option value="MENIPIS">Menipis</option>
                <option value="HABIS">Habis</option>
            </select>
        </div>

        <button onclick="bukaModal(true)" class="btn-action bg-blue-600 text-white px-6 h-10 rounded-xl text-xs font-black uppercase shadow-lg shadow-blue-500/30 transition-all hover:bg-blue-700 active:scale-95 flex items-center justify-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            TAMBAH STOK
        </button>
    </div>

    {{-- TABEL DENGAN GRADIENT & DESAIN HIDUP --}}
    <div class="max-h-[400px] overflow-y-auto custom-scrollbar">
        <table class="w-full text-center border-collapse">
            <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white font-black text-[9px] uppercase sticky top-0 shadow-md z-10">
                <tr>
                    <th class="p-4">Icon</th><th class="p-4">Nama Bahan</th><th class="p-4">Kategori</th>
                    <th class="p-4">Stok</th><th class="p-4">Harga</th><th class="p-4">Status</th><th class="p-4">Aksi</th>
                </tr>
            </thead>
            <tbody id="stock-body" class="text-slate-700 font-bold text-xs divide-y divide-slate-100"></tbody>
        </table>
    </div>

    {{-- MODAL DENGAN GRADIENT --}}
    <div id="modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center z-50">
        <div class="bg-white p-8 w-[400px] rounded-3xl shadow-2xl border border-slate-100 transform transition-all">
            <h3 class="font-black text-center mb-6 flex items-center justify-center gap-2 text-blue-600">
                <i data-lucide="package-plus"></i> INPUT BAHAN BARU
            </h3>
            <form id="form-item" class="space-y-4">
                <div class="relative"><i data-lucide="package" class="absolute left-3 top-3.5 w-4 h-4 text-slate-400"></i><input type="text" id="in-name" required placeholder="Nama Bahan" class="w-full border p-3 pl-10 rounded-xl bg-slate-50 outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div class="relative"><i data-lucide="tags" class="absolute left-3 top-3.5 w-4 h-4 text-slate-400"></i><input type="text" id="in-cat" required placeholder="Kategori" class="w-full border p-3 pl-10 rounded-xl bg-slate-50 outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div class="grid grid-cols-2 gap-3">
                    <input type="number" id="in-qty" required placeholder="Stok" class="w-full border p-3 rounded-xl bg-slate-50 outline-none">
                    <input type="number" id="in-price" required placeholder="Harga" class="w-full border p-3 rounded-xl bg-slate-50 outline-none">
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="button" onclick="bukaModal(false)" class="flex-1 bg-slate-100 hover:bg-slate-200 py-3 rounded-xl font-black transition-all">BATAL</button>
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-3 rounded-xl font-black shadow-lg shadow-blue-500/30 transition-all">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>

<script>
    let db = [];

    // Fungsi utama untuk menampilkan data dan memperbarui tampilan
    function render() {
        const key = document.getElementById('search-input').value.toLowerCase();
        const cat = document.getElementById('cat-filter').value;
        const stat = document.getElementById('stat-filter').value;
        const body = document.getElementById('stock-body');

        let data = db.filter(i => i.name.toLowerCase().includes(key));
        if(cat) data = data.filter(i => i.category === cat);
        if(stat) data = data.filter(i => getStatus(i.qty) === stat);
        if(data.length === 0) {
            body.innerHTML = `<tr><td colspan="7" class="p-10 text-slate-400 italic">
                <i data-lucide="database" class="w-10 h-10 mx-auto mb-2 opacity-50"></i>
                Data stok belum tersedia, silakan tambahkan bahan baru.
            </td></tr>`;
        } else {
            body.innerHTML = data.map(i => `
                <tr class="border-b hover:bg-slate-50">
                    <td class="p-4 text-lg">📦</td>
                    <td class="p-4">${i.name}</td>
                    <td class="p-4">${i.category}</td>
                    <td class="p-4">${i.qty}</td>
                    <td class="p-4">Rp ${i.price.toLocaleString()}</td>
                    <td class="p-4"><span class="px-2 py-1 rounded text-[9px] font-black ${getColor(i.qty)}">${getStatus(i.qty)}</span></td>
                    <td class="p-4 flex justify-center gap-2">
                        <button onclick="ubahStok(${i.id}, 1)" class="bg-blue-600 text-white w-7 h-7 rounded font-black">+</button>
                        <button onclick="ubahStok(${i.id}, -1)" class="bg-slate-200 w-7 h-7 rounded font-black">-</button>
                        <button onclick="hapus(${i.id})" class="text-rose-500"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                    </td>
                </tr>`).join('');
        }
        updateMetrik(); lucide.createIcons();
    }

    // Fungsi status dan warna
    function getStatus(q) { return q === 0 ? 'HABIS' : (q <= 5 ? 'MENIPIS' : 'AMAN'); }
    function getColor(q) { return q === 0 ? 'text-rose-600 bg-rose-100' : (q <= 5 ? 'text-amber-600 bg-amber-100' : 'text-emerald-600 bg-emerald-100'); }

    // Fungsi untuk menambah atau mengurangi stok secara real-time
    function ubahStok(id, val) {
        let item = db.find(x => x.id == id);
        if(item) {
            item.qty = Math.max(0, item.qty + val); // Mencegah angka jadi negatif
            render(); // Update tampilan tabel dan metrik
        }
    }

    // Fungsi hapus data
    function hapus(id) {
        db = db.filter(i => i.id != id);
        render();
    }

    // Fungsi buka tutup modal
    function bukaModal(s) { document.getElementById('modal').classList.toggle('hidden', !s); }

    // Menangani form tambah barang
    document.getElementById('form-item').onsubmit = (e) => {
        e.preventDefault();
        db.push({
            id: Date.now(),
            name: document.getElementById('in-name').value,
            category: document.getElementById('in-cat').value,
            qty: parseInt(document.getElementById('in-qty').value),
            price: parseInt(document.getElementById('in-price').value)
        });
        render(); bukaModal(false); e.target.reset();
    };

    // Update metrik di 5 kotak atas
    function updateMetrik() {
        document.getElementById('stat-total-value').innerText = `Rp ${db.reduce((a,b)=>a+(b.qty*b.price),0).toLocaleString()}`;
        document.getElementById('stat-total-stock').innerText = `${db.reduce((a,b)=>a+b.qty,0)} Unit`;
        document.getElementById('stat-empty-items').innerText = `${db.filter(i=>i.qty==0).length} Item`;
        document.getElementById('stat-low-items').innerText = `${db.filter(i=>i.qty>0 && i.qty<=5).length} Item`;
        document.getElementById('stat-jenis-count').innerText = `${db.length} Jenis`;
    }

    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById('realtime-date-badge').innerText = new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
        render();
    });
</script>
@endsection
