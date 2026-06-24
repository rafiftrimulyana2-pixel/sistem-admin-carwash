@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    * { font-family: 'Inter', sans-serif; }
    .progress-list-scroll::-webkit-scrollbar { width: 5px; }
    .progress-list-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .float-shadow { transition: all 0.3s ease; }
    .float-shadow:hover { transform: translateY(-5px); box-shadow: 0 10px 20px -5px rgba(0,0,0,0.2); }
</style>

<div class="w-full h-screen bg-[#f8fafc] flex flex-col overflow-hidden text-slate-700">
    <div class="w-full bg-blue-600 px-6 py-4 flex justify-between items-center shadow-lg shrink-0">
        <div class="space-y-0.5">
            <h1 class="text-white text-xs font-black uppercase tracking-widest">Status Progress Kendaraan</h1>
            <p class="text-blue-100 text-[8px] font-bold uppercase tracking-widest">Real-time monitoring workshop status system</p>
        </div>
        <div class="text-right">
            <span class="block text-[8px] text-blue-200 font-black uppercase">Tanggal Kerja</span>
            <span class="text-[10px] text-white font-bold">{{ date('d M Y') }}</span>
        </div>
    </div>

    <div class="flex-1 flex flex-col p-6 gap-6 overflow-hidden">
        <div class="flex justify-between items-center shrink-0">
            <div class="flex bg-white p-1 rounded-xl border border-slate-200 shadow-sm gap-1">
                <button onclick="setKategoriTab('ALL', this)" class="tab-btn bg-blue-600 text-white px-4 py-1.5 rounded-lg text-[10px] font-black uppercase transition-all">Semua Unit</button>
                <button onclick="setKategoriTab('PROSES', this)" class="tab-btn text-slate-500 px-4 py-1.5 rounded-lg text-[10px] font-bold uppercase transition-all">Sedang Dicuci</button>
                <button onclick="setKategoriTab('READY', this)" class="tab-btn text-slate-500 px-4 py-1.5 rounded-lg text-[10px] font-bold uppercase transition-all">Selesai</button>
            </div>
            <input type="text" id="search-plat-nama" onkeyup="jalankanSistemFilterProgresKombinasi()" placeholder="Cari Plat Nomor / Nama..." class="bg-white border border-slate-200 rounded-xl px-4 py-2 text-xs font-bold w-64 shadow-sm focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        <div id="progress-list-wrapper" class="flex-1 overflow-y-auto space-y-3 pr-2"></div>

        <div class="grid grid-cols-4 gap-4 shrink-0">
    <div class="float-shadow bg-orange-500 text-white border border-orange-600 rounded-2xl p-3.5 shadow-md flex items-center gap-4 cursor-pointer">
        <div class="p-2.5 bg-white/20 text-white rounded-xl shadow-inner">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <div>
            <span class="block text-[8px] font-bold text-orange-100 uppercase tracking-wider">Estimasi Waktu Tunggu</span>
            <span id="stat-estimasi" class="block text-xs font-black text-white mt-0.5">0 Menit</span>
        </div>
    </div>

    <div class="float-shadow bg-amber-500 text-white border border-amber-600 rounded-2xl p-3.5 shadow-md flex items-center gap-4 cursor-pointer">
        <div class="p-2.5 bg-white/20 text-white rounded-xl shadow-inner">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
        </div>
        <div>
            <span class="block text-[8px] font-bold text-amber-100 uppercase tracking-wider">Sedang DiPencucian</span>
            <span id="stat-cuci" class="block text-xs font-black text-white mt-0.5">0 Unit</span>
        </div>
    </div>

    <div class="float-shadow bg-blue-600 text-white border border-blue-700 rounded-2xl p-3.5 shadow-md flex items-center gap-4 cursor-pointer">
        <div class="p-2.5 bg-white/20 text-white rounded-xl shadow-inner">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" /></svg>
        </div>
        <div>
            <span class="block text-[8px] font-bold text-blue-100 uppercase tracking-wider">Proses Pengeringan</span>
            <span id="stat-kering" class="block text-xs font-black text-white mt-0.5">0 Unit</span>
        </div>
    </div>

    <div class="float-shadow bg-emerald-600 text-white border border-emerald-700 rounded-2xl p-3.5 shadow-md flex items-center gap-4 cursor-pointer">
        <div class="p-2.5 bg-white/20 text-white rounded-xl shadow-inner">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <div>
            <span class="block text-[8px] font-bold text-emerald-100 uppercase tracking-wider">Tersedia Slot Mobil</span>
            <span id="stat-slot" class="block text-xs font-black text-white mt-0.5">0 Slot</span>
        </div>
    </div>
</div>

<script>
    let currentTabKategori = "ALL";
    const kapasitasMaksimalSlot = 5;
    let arrayDatabaseProgresWorkshop = @json($antreanAktif ?? []).map(item => {
        let step = item.status === 'READY' ? 4 : (item.status === 'PENGERINGAN' ? 3 : (item.status === 'PENCUCIAN' ? 2 : 1));
        return { id: item.id, nopol: item.plat_nomor, nama: item.nama_pelanggan, mobil: item.jenis_kendaraan ?? 'MOBIL', step, persen: step * 25 };
    });

    function setKategoriTab(k, el) {
        currentTabKategori = k;
        document.querySelectorAll('.tab-btn').forEach(b => b.className = "tab-btn text-slate-500 px-4 py-1.5 rounded-lg text-[10px] font-bold uppercase");
        el.className = "tab-btn bg-blue-600 text-white px-4 py-1.5 rounded-lg text-[10px] font-black uppercase shadow-sm";
        jalankanSistemFilterProgresKombinasi();
    }

    function jalankanSistemFilterProgresKombinasi() {
        const search = document.getElementById('search-plat-nama').value.toLowerCase();
        const filtered = arrayDatabaseProgresWorkshop.filter(i => {
            const mS = i.nopol.toLowerCase().includes(search) || i.nama.toLowerCase().includes(search);
            const mT = (currentTabKategori === 'ALL') || (currentTabKategori === 'PROSES' && (i.step === 2 || i.step === 3)) || (currentTabKategori === 'READY' && i.step === 4);
            return mS && mT;
        });
        renderLiveProgressBoard(filtered);
    }

    function renderLiveProgressBoard(dataToRender) {
    const wrapper = document.getElementById('progress-list-wrapper');
    wrapper.innerHTML = "";

    // ... (kode loop render kartu mobil Anda) ...

    // TARUH KODE STATISTIK DI SINI:
    let unitAktif = arrayDatabaseProgresWorkshop.filter(i => i.step < 4).length;
    document.getElementById('stat-estimasi').innerText = (arrayDatabaseProgresWorkshop.filter(r=>r.step===1).length * 15) + " Menit";
    document.getElementById('stat-cuci').innerText = arrayDatabaseProgresWorkshop.filter(r=>r.step===2).length + " Unit";
    document.getElementById('stat-kering').innerText = arrayDatabaseProgresWorkshop.filter(r=>r.step===3).length + " Unit";
    document.getElementById('stat-slot').innerText = Math.max(0, kapasitasMaksimalSlot - unitAktif) + " Slot";
    }

    document.addEventListener("DOMContentLoaded", jalankanSistemFilterProgresKombinasi);
</script>
@endsection
