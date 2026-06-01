@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    body {
        font-family: 'Inter', sans-serif;
    }
    .progress-list-scroll::-webkit-scrollbar {
        width: 5px !important;
        height: 5px !important;
    }
    .progress-list-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .progress-list-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1 !important;
        border-radius: 10px !important;
    }
    .figma-shadow-card {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.01), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
    }
    .live-row-card {
        transition: all 0.2s ease;
    }

    /* 📊 TRANSISI HALUS (SLOW MO MOTION) UNTUK 4 KOTAK BESAR DI BAWAH */
    .slow-motion-box {
        transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1) !important;
    }
    .slow-motion-box:hover {
        transform: translateY(-4px) scale(1.01);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.04), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
    }

    /* 🎨 WARNA KHAS BULATAN PROGRES STABIL */
    .glow-dot-1 { border-color: #94a3b8 !important; background-color: #94a3b8 !important; }
    .glow-dot-2 { box-shadow: 0 0 10px rgba(245, 158, 11, 0.4); border-color: #f59e0b !important; background-color: #f59e0b !important; }
    .glow-dot-3 { box-shadow: 0 0 10px rgba(37, 99, 235, 0.4); border-color: #2563eb !important; background-color: #2563eb !important; }
    .glow-dot-4 { box-shadow: 0 0 10px rgba(16, 185, 129, 0.4); border-color: #10b981 !important; background-color: #10b981 !important; }

    @keyframes popIn {
        from { opacity: 0; transform: scale(0.95) translateY(5px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .animate-dropdown {
        animation: popIn 0.15s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const tumpukanMenuSidebar = document.querySelectorAll('aside a, nav a, sidebar a, .sidebar-link');
        tumpukanMenuSidebar.forEach(menu => {
            if (menu.textContent.toLowerCase().includes('progress') || menu.textContent.toLowerCase().includes('status')) {
                menu.removeAttribute('class');
                menu.className = "flex items-center gap-3 px-4 py-3 text-blue-600 transition-all font-bold bg-blue-50/60 rounded-xl";
            }
        });
    });
</script>

<div class="w-full h-[calc(100vh-2px)] bg-[#f8fafc] flex flex-col overflow-hidden select-none antialiased text-slate-700">

    <div class="w-full bg-gradient-to-r from-[#1e40af] via-[#4338ca] to-[#5b21b6] px-6 py-4 min-h-[70px] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 flex-shrink-0 shadow-sm">
        <div class="space-y-0.5">
            <h1 class="text-white text-sm font-black uppercase tracking-wider">STATUS PROGRESS KENDARAAN</h1>
            <p class="text-indigo-200 text-[9px] font-bold uppercase tracking-widest">REAL-TIME MONITORING WORKSHOP STATUS SYSTEM</p>
        </div>

        <div class="flex items-center gap-2 bg-white/10 p-1.5 rounded-xl border border-white/20 flex-shrink-0">
            <span class="text-[9px] font-black text-indigo-100 uppercase tracking-widest pl-1">Tanggal Kerja:</span>
            <select id="filter-tanggal-kerja" onchange="jalankanSistemFilterProgresKombinasi()" class="bg-slate-900/40 text-white border-none text-[9px] font-black p-1.5 rounded-lg focus:outline-none cursor-pointer">
                <option value="KOSONG" class="text-slate-800">-- Ambil Data Awal (0 Unit) --</option>
                <option value="22-05-2026" class="text-slate-800">Sinkronisasi Input Kasir (22 Mei 2026)</option>
            </select>
        </div>
    </div>

    <div class="w-full flex-1 flex flex-col p-4 gap-3.5 overflow-hidden">

        <div class="w-full flex flex-col sm:flex-row gap-3 justify-between items-center flex-shrink-0">
            <div class="flex items-center bg-white p-1 rounded-xl border border-slate-200 shadow-sm gap-1">
                <button type="button" onclick="setKategoriTab('ALL', this)" class="tab-btn bg-blue-600 text-white font-extrabold text-[9px] px-4 py-2 rounded-lg uppercase tracking-wide transition-all shadow-sm">
                    Semua Unit
                </button>
                <button type="button" onclick="setKategoriTab('PROSES', this)" class="tab-btn text-slate-500 hover:text-slate-900 font-bold text-[9px] px-4 py-2 rounded-lg uppercase tracking-wide transition-all">
                    Sedang Dicuci
                </button>
                <button type="button" onclick="setKategoriTab('READY', this)" class="tab-btn text-slate-500 hover:text-slate-900 font-bold text-[9px] px-4 py-2 rounded-lg uppercase tracking-wide transition-all">
                    Selesai
                </button>
            </div>

            <div class="w-full sm:w-64 relative">
                <input type="text" id="search-plat-nama" onkeyup="jalankanSistemFilterProgresKombinasi()" placeholder="Cari Plat Nomor / Nama..."
                    class="w-full bg-white border border-slate-200 rounded-xl pl-3 pr-8 py-2 text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 transition-all shadow-sm">
                <span class="absolute right-3 top-2.5 text-slate-400 text-xs">🔍</span>
            </div>
        </div>

        <div id="progress-list-wrapper" class="w-full flex-1 flex flex-col gap-2.5 overflow-y-auto progress-list-scroll pr-1">

        </div>
            <div class="grid grid-cols-4 gap-4 flex-shrink-0">
                <div class="slow-motion-box bg-orange-500 text-white border border-orange-600 rounded-2xl p-3.5 shadow-md flex items-center gap-4 cursor-pointer">
                    <div class="p-2.5 bg-white/20 text-white rounded-xl flex-shrink-0 shadow-inner">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>

                <div>
                    <span class="block text-[8px] font-bold text-orange-100 uppercase tracking-wider">Estimasi Waktu Tunggu</span>
                    <span id="stat-estimasi" class="block text-xs font-black text-white mt-0.5">0 Menit</span>
                </div>
            </div>

            <div class="slow-motion-box bg-amber-500 text-white border border-amber-600 rounded-2xl p-3.5 shadow-md flex items-center gap-4 cursor-pointer">
                <div class="p-2.5 bg-white/20 text-white rounded-xl flex-shrink-0 shadow-inner">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
                <div>
                    <span class="block text-[8px] font-bold text-amber-100 uppercase tracking-wider">Sedang DiPencucian</span>
                    <span id="stat-cuci" class="block text-xs font-black text-white mt-0.5">0 Unit</span>
                </div>
            </div>

            <div class="slow-motion-box bg-blue-600 text-white border border-blue-700 rounded-2xl p-3.5 shadow-md flex items-center gap-4 cursor-pointer">
                <div class="p-2.5 bg-white/20 text-white rounded-xl flex-shrink-0 shadow-inner">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" /></svg>
                </div>
                <div>
                    <span class="block text-[8px] font-bold text-blue-100 uppercase tracking-wider">Proses Pengeringan</span>
                    <span id="stat-kering" class="block text-xs font-black text-white mt-0.5">0 Unit</span>
                </div>
            </div>

            <div class="slow-motion-box bg-emerald-600 text-white border border-emerald-700 rounded-2xl p-3.5 shadow-md flex items-center gap-4 cursor-pointer">
                <div class="p-2.5 bg-white/20 text-white rounded-xl flex-shrink-0 shadow-inner">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <span class="block text-[8px] font-bold text-emerald-100 uppercase tracking-wider">Tersedia Slot Mobil</span>
                    <span id="stat-slot" class="block text-xs font-black text-white mt-0.5">0 Slot</span>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    let currentTabKategori = "ALL";
    const kapasitasMaksimalSlot = 5;

    let arrayDatabaseProgresWorkshop = [
        { id: 1, tgl: "22-05-2026", nopol: "B 1234 ABC", nama: "Rafliansyah", mobil: "HONDA HR-V", paket: "FULL WASH + WAX", masuk: "12:15 WIB", step: 3, persen: 75, badgeColor: "bg-blue-100 text-blue-700", labelBadge: "PENGERINGAN" },
        { id: 2, tgl: "22-05-2026", nopol: "F 999 SS", nama: "Siti Aminah", mobil: "TOYOTA FORTUNER", paket: "PREMIUM WAX TREATMENT", masuk: "12:30 WIB", step: 2, persen: 30, badgeColor: "bg-amber-100 text-amber-700", labelBadge: "PENCUCIAN" },
        { id: 3, tgl: "22-05-2026", nopol: "B 2026 RFV", nama: "Hendra Wijaya", mobil: "MITSUBISHI PAJERO", paket: "REGULER WASH", masuk: "13:10 WIB", step: 1, persen: 5, badgeColor: "bg-slate-100 text-slate-700", labelBadge: "ANTREAN" }
    ];

    function setKategoriTab(kategori, element) {
        currentTabKategori = kategori;
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.className = "tab-btn text-slate-500 hover:text-slate-900 font-bold text-[9px] px-4 py-2 rounded-lg uppercase tracking-wide transition-all";
        });
        element.className = "tab-btn bg-blue-600 text-white font-extrabold text-[9px] px-4 py-2 rounded-lg uppercase tracking-wide transition-all shadow-sm";
        jalankanSistemFilterProgresKombinasi();
    }

    function kalkulasiFooterStatistik(dataTerfilter) {
        let totalAntrean = 0;
        let totalCuci = 0;
        let totalKering = 0;

        dataTerfilter.forEach(row => {
            if (row.step === 1) totalAntrean++;
            if (row.step === 2) totalCuci++;
            if (row.step === 3) totalKering++;
        });

        let sisaSlot = kapasitasMaksimalSlot - dataTerfilter.filter(item => item.step < 4).length;

        document.getElementById('stat-estimasi').innerText = dataTerfilter.length > 0 ? (totalAntrean * 15 + totalCuci * 25) + " Menit" : "0 Menit";
        document.getElementById('stat-cuci').innerText = totalCuci + " Unit";
        document.getElementById('stat-kering').innerText = totalKering + " Unit";
        document.getElementById('stat-slot').innerText = dataTerfilter.length > 0 ? sisaSlot + " Slot" : "0 Slot";
    }

    function eksekusiGantiProgresManual(idMobil, stepBaru) {
        let index = arrayDatabaseProgresWorkshop.findIndex(item => item.id === idMobil);
        if (index === -1) return;

        if (stepBaru === 1) {
            arrayDatabaseProgresWorkshop[index].step = 1;
            arrayDatabaseProgresWorkshop[index].persen = 5;
            arrayDatabaseProgresWorkshop[index].labelBadge = "ANTREAN";
            arrayDatabaseProgresWorkshop[index].badgeColor = "bg-slate-100 text-slate-700";
        } else if (stepBaru === 2) {
            arrayDatabaseProgresWorkshop[index].step = 2;
            arrayDatabaseProgresWorkshop[index].persen = 30;
            arrayDatabaseProgresWorkshop[index].labelBadge = "PENCUCIAN";
            arrayDatabaseProgresWorkshop[index].badgeColor = "bg-amber-100 text-amber-700";
        } else if (stepBaru === 3) {
            arrayDatabaseProgresWorkshop[index].step = 3;
            arrayDatabaseProgresWorkshop[index].persen = 75;
            arrayDatabaseProgresWorkshop[index].labelBadge = "PENGERINGAN";
            arrayDatabaseProgresWorkshop[index].badgeColor = "bg-blue-100 text-blue-700";
        } else if (stepBaru === 4) {
            arrayDatabaseProgresWorkshop[index].step = 4;
            arrayDatabaseProgresWorkshop[index].persen = 100;
            arrayDatabaseProgresWorkshop[index].labelBadge = "FINISH (READY)";
            arrayDatabaseProgresWorkshop[index].badgeColor = "bg-emerald-100 text-emerald-700";
        }

        document.querySelectorAll('.dropdown-menu-box').forEach(el => el.classList.add('hidden'));
        jalankanSistemFilterProgresKombinasi();
    }

    function toggleDropdownMenuBox(idBox) {
        const target = document.getElementById(idBox);
        const kondisiSekarang = target.classList.contains('hidden');
        document.querySelectorAll('.dropdown-menu-box').forEach(el => el.classList.add('hidden'));
        if (kondisiSekarang) target.classList.remove('hidden');
    }

    function renderLiveProgressBoard(dataToRender) {
        const wrapper = document.getElementById('progress-list-wrapper');
        wrapper.innerHTML = "";

        if (dataToRender.length === 0) {
            wrapper.innerHTML = `
                <div class="flex flex-col items-center justify-center p-12 text-center bg-white border border-slate-200 rounded-2xl flex-1 my-auto text-slate-400 font-medium italic shadow-sm">
                    <span class="text-2xl mb-1">📋</span>
                    <span class="text-[10px]">Belum ada unit pengerjaan aktif dari kasir pada periode ini, Chief.</span>
                </div>
            `;
            kalkulasiFooterStatistik([]);
            return;
        }

        dataToRender.forEach(row => {
            const s1Class = row.step === 1 ? 'glow-dot-1 text-white font-black text-xs' : (row.step >= 1 ? 'bg-slate-400 border-slate-400 text-white font-black text-xs' : 'bg-white border-slate-200 text-slate-400 text-xs');
            const s2Class = row.step === 2 ? 'glow-dot-2 text-white font-black text-xs' : (row.step >= 2 ? 'bg-amber-500 border-amber-500 text-white font-black text-xs' : 'bg-white border-slate-200 text-slate-400 text-xs');
            const s3Class = row.step === 3 ? 'glow-dot-3 text-white font-black text-xs' : (row.step >= 3 ? 'bg-blue-600 border-blue-600 text-white font-black text-xs' : 'bg-white border-slate-200 text-slate-400 text-xs');
            const s4Class = row.step === 4 ? 'glow-dot-4 text-white font-black text-xs' : (row.step >= 4 ? 'bg-emerald-500 border-emerald-500 text-white font-black text-xs' : 'bg-white border-slate-200 text-slate-400 text-xs');

            const line1 = row.step >= 2 ? 'bg-amber-500' : 'bg-slate-200';
            const line2 = row.step >= 3 ? 'bg-blue-600' : 'bg-slate-200';
            const line3 = row.step >= 4 ? 'bg-emerald-500' : 'bg-slate-200';

            let colorPersenClass = "text-slate-800";
            if (row.step === 1) colorPersenClass = "text-slate-400";
            if (row.step === 2) colorPersenClass = "text-amber-500";
            if (row.step === 3) colorPersenClass = "text-blue-600";
            if (row.step === 4) colorPersenClass = "text-emerald-500";

            let rowHtml = `
                <div class="live-row-card bg-white border border-slate-200 rounded-2xl px-4 py-3 shadow-sm flex items-center justify-between gap-1 flex-shrink-0 relative">

                    <div class="flex items-center gap-3 w-[30%] flex-shrink-0">
                        <div class="p-2.5 bg-blue-600 border border-blue-700 rounded-xl text-white flex-shrink-0 shadow-[0_4px_10px_rgba(0,0,0,0.15)]">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                                <circle cx="7" cy="17" r="2" />
                                <circle cx="17" cy="17" r="2" />
                            </svg>
                        </div>
                        <div class="flex flex-col gap-0.5 truncate">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="text-xs font-extrabold text-slate-700 tracking-tight">${row.nama}</span>
                                <span class="${row.badgeColor} text-[6.5px] font-black px-1 py-0.5 rounded uppercase tracking-wide shadow-sm">${row.labelBadge}</span>
                            </div>
                            <div class="text-[9px] font-extrabold text-slate-500 uppercase tracking-wide mt-0.5">
                                ${row.mobil} <span class="text-slate-300 font-bold">|</span> <span class="text-blue-600 font-black">${row.nopol}</span>
                            </div>
                            <div class="flex items-center gap-2 text-[8px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">
                                <span class="bg-slate-50 border border-slate-100 px-1 py-0.5 rounded text-slate-500 font-extrabold">${row.paket}</span>
                                <span>⏱️ ${row.masuk}</span>
                            </div>
                        </div>

                    </div>

                    <div class="w-[58%] flex items-center justify-center px-1 flex-shrink-0">
                        <div class="w-full flex items-center relative">
                            <div class="flex flex-col items-center z-10 relative">
                                <div class="h-7 w-7 rounded-full border-2 ${s1Class} flex items-center justify-center shadow-sm transition-all duration-300">
                                    ${row.step >= 1 && row.step !== 1 ? '✓' : '1'}
                                </div>
                                <span class="text-[7px] font-black text-slate-400 uppercase tracking-wider mt-1.5 absolute top-6 whitespace-nowrap">Antrean</span>
                            </div>
                            <div class="flex-1 h-[3px] ${line1} transition-all duration-500 mx-1"></div>

                            <div class="flex flex-col items-center z-10 relative">
                                <div class="h-7 w-7 rounded-full border-2 ${s2Class} flex items-center justify-center shadow-sm transition-all duration-300">
                                    ${row.step >= 2 && row.step !== 2 ? '✓' : '2'}
                                </div>
                                <span class="text-[7px] font-black text-slate-400 uppercase tracking-wider mt-1.5 absolute top-6 whitespace-nowrap">Cuci</span>
                            </div>
                            <div class="flex-1 h-[3px] ${line2} transition-all duration-500 mx-1"></div>

                            <div class="flex flex-col items-center z-10 relative">
                                <div class="h-7 w-7 rounded-full border-2 ${s3Class} flex items-center justify-center shadow-sm transition-all duration-300">
                                    ${row.step >= 3 && row.step !== 3 ? '✓' : '3'}
                                </div>
                                <span class="text-[7px] font-black text-slate-400 uppercase tracking-wider mt-1.5 absolute top-6 whitespace-nowrap">Kering</span>
                            </div>
                            <div class="flex-1 h-[3px] ${line3} transition-all duration-500 mx-1"></div>

                            <div class="flex flex-col items-center z-10 relative">
                                <div class="h-7 w-7 rounded-full border-2 ${s4Class} flex items-center justify-center shadow-sm transition-all duration-300">
                                    ${row.step >= 4 && row.step !== 4 ? '✓' : '4'}
                                </div>
                                <span class="text-[7px] font-black text-slate-400 uppercase tracking-wider mt-1.5 absolute top-6 whitespace-nowrap">Finish</span>
                            </div>
                        </div>
                    </div>

                    <div class="w-[12%] flex items-center justify-start pl-4 gap-3 relative flex-shrink-0">
                        <div class="text-left">
                            <span class="block text-xl font-black tracking-tighter leading-none ${colorPersenClass}">${row.persen}%</span>
                            <span class="text-[7px] font-bold text-slate-400 uppercase tracking-wider mt-0.5 block">SELESAI</span>
                        </div>

                        <div class="relative">
                            <button type="button" onclick="toggleDropdownMenuBox('dropdown-box-id-${row.id}')" class="text-slate-400 hover:text-slate-800 transition-all font-black p-1.5 text-base rounded-lg hover:bg-slate-100 focus:outline-none">⋮</button>

                            <div id="dropdown-box-id-${row.id}" class="dropdown-menu-box hidden absolute right-0 mt-1 w-40 bg-white border border-slate-200 rounded-xl shadow-xl z-50 py-1.5 animate-dropdown">
                                <div class="px-2.5 py-1 text-[7px] font-black text-slate-400 uppercase tracking-wider border-b border-slate-100">Ubah Progres Kerja</div>
                                <button type="button" onclick="eksekusiGantiProgresManual(${row.id}, 1)" class="w-full text-left px-3 py-1.5 text-[9px] font-bold text-slate-600 hover:bg-slate-50 flex items-center gap-1.5">⭕ Antrean</button>
                                <button type="button" onclick="eksekusiGantiProgresManual(${row.id}, 2)" class="w-full text-left px-3 py-1.5 text-[9px] font-bold text-slate-600 hover:bg-slate-50 flex items-center gap-1.5 text-amber-500">⏳ Masuk Ruang Cuci</button>
                                <button type="button" onclick="eksekusiGantiProgresManual(${row.id}, 3)" class="w-full text-left px-3 py-1.5 text-[9px] font-bold text-slate-600 hover:bg-slate-50 flex items-center gap-1.5 text-blue-600">💨 Mulai Keringkan</button>
                                <button type="button" onclick="eksekusiGantiProgresManual(${row.id}, 4)" class="w-full text-left px-3 py-1.5 text-[9px] font-bold text-slate-600 hover:bg-emerald-50 flex items-center gap-1.5 text-emerald-500">✨ Selesai (Ready)</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            wrapper.innerHTML += rowHtml;
        });

        kalkulasiFooterStatistik(dataToRender);
    }

    function jalankanSistemFilterProgresKombinasi() {
        const waktuKerja = document.getElementById('filter-tanggal-kerja').value;
        const searchKeyword = document.getElementById('search-plat-nama').value.toLowerCase();

        if (waktuKerja === "KOSONG") {
            renderLiveProgressBoard([]);
            return;
        }

        const dataTerfilter = arrayDatabaseProgresWorkshop.filter(item => {
            const matchWaktu = (item.tgl === waktuKerja);
            const matchKeyword = item.nopol.toLowerCase().includes(searchKeyword) || item.nama.toLowerCase().includes(searchKeyword) || item.mobil.toLowerCase().includes(searchKeyword);

            let matchTab = true;
            if (currentTabKategori === "PROSES") matchTab = (item.step === 2 || item.step === 3);
            if (currentTabKategori === "READY") matchTab = (item.step === 4);

            return matchWaktu && matchKeyword && matchTab;
        });

        renderLiveProgressBoard(dataTerfilter);
    }

    window.addEventListener('click', function(e) {
        if (!e.target.matches('button')) {
            document.querySelectorAll('.dropdown-menu-box').forEach(el => el.classList.add('hidden'));
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
        jalankanSistemFilterProgresKombinasi();
    });
</script>
@endsection
