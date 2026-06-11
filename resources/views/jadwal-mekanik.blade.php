@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    /* Kunci font Inter secara merata di seluruh area konten */
    * {
        font-family: 'Inter', sans-serif;
    }

    /* BENTENG UTAMA: Menjebol Total Kuncian Layar Master Agar Halaman BISA BERGESER */
    html, body {
        overflow: auto !important;
        overflow-y: auto !important;
        height: auto !important;
    }

    /* Menjebol kuncian container pembungkus kanan milik Laravel master layout */
    main, .flex-1, [class*="max-h-screen"], [class*="overflow-hidden"] {
        overflow: auto !important;
        overflow-y: auto !important;
        height: auto !important;
        max-height: none !important;
    }

    /* Sembunyikan scrollbar bawaan browser luar agar tetap clean & estetik */
    .viewport-scroller::-webkit-scrollbar {
        display: none !important;
    }
    .viewport-scroller {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    /* KUSTOM SCROLLBAR INTERNAL UNTUK TABEL MEKANIK */
    .tabel-scroll-karyawan::-webkit-scrollbar {
        width: 6px !important;
        height: 6px !important;
    }
    .tabel-scroll-karyawan::-webkit-scrollbar-track {
        background: #f1f5f9 !important;
        border-radius: 8px !important;
    }
    .tabel-scroll-karyawan::-webkit-scrollbar-thumb {
        background: #cbd5e1 !important;
        border-radius: 8px !important;
    }
    .tabel-scroll-karyawan::-webkit-scrollbar-thumb:hover {
        background: #94a3b8 !important;
    }

    .calendar-day { transition: all .2s ease; }
    .calendar-day:hover { transform: scale(1.08); }
    .action-btn { transition: all 0.2s ease; }
    .action-btn:hover { transform: translateY(-2px); }
    .kasir-scope { font-weight: 700 !important; }
</style>

<div class="kasir-scope w-full h-auto min-h-screen bg-[#f4f7fb] viewport-scroller select-none antialiased text-slate-700 pb-16">

    {{-- HEADER UTAMA --}}
    <div class="w-full bg-blue-600 px-6 py-4 flex justify-between items-center shadow-md flex-shrink-0">
        <div class="space-y-1">
            <h1 class="text-white text-sm font-black uppercase tracking-[0.1em]">
                SISTEM JADWAL MANAJEMEN MEKANIK
            </h1>
            <p class="text-blue-100 text-[9px] font-bold uppercase tracking-wider opacity-90">
                Monitoring Real-Time Jadwal Kerja Mekanik, Shift Workshop, &amp; Operational Status
            </p>
        </div>

        <div class="flex items-center gap-3 flex-shrink-0">
            <div class="bg-white/10 border border-white/10 px-4 py-2 rounded-xl text-white text-[10px] font-black uppercase tracking-widest shadow-inner">
                Hari Kerja: <span id="tanggalRealtime" class="text-amber-300 font-black"></span>
            </div>

            <div class="bg-white px-4 py-2 rounded-xl text-blue-600 text-[10px] font-black uppercase tracking-widest flex items-center gap-2 shadow-sm border border-blue-50">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Sistem Online
            </div>
        </div>
    </div>

    {{-- GRID UTAMA --}}
    <div class="p-5 grid grid-cols-12 gap-5">

        {{-- AREA KIRI: FILTER & DATA KARYAWAN MEKANIK (COL-9) --}}
        <div class="col-span-9 space-y-5">

            {{-- FILTER PANEL --}}
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
                <div class="mb-4">
                    <h2 class="text-xs font-black text-slate-800 uppercase tracking-wider">
                        Pengaturan Kontrol Monitoring Shift
                    </h2>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-1">
                        Sistem penyaringan data operasional kehadiran mekanik workshop
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Filter Pembagian Shift</label>
                        <select id="filterShift" class="w-full h-10 px-3 rounded-xl border border-slate-200 text-[10px] font-black tracking-wide text-slate-700 outline-none bg-slate-50 focus:border-blue-600 focus:bg-white cursor-pointer shadow-inner">
                            <option value="all">Semua Shift Kerja</option>
                            <option value="Pagi">Shift Pagi (08:00 - 16:00)</option>
                            <option value="Siang">Shift Siang (13:00 - 21:00)</option>
                            <option value="Malam">Shift Malam (21:00 - 05:00)</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Status Kehadiran Absensi</label>
                        <select id="filterStatus" class="w-full h-10 px-3 rounded-xl border border-slate-200 text-[10px] font-black tracking-wide text-slate-700 outline-none bg-slate-50 focus:border-blue-600 focus:bg-white cursor-pointer shadow-inner">
                            <option value="all">Semua Status Presensi</option>
                            <option value="Hadir">Hadir Bekerja</option>
                            <option value="Izin">Izin / Sakit</option>
                            <option value="Libur">Selesai Tugas / Libur</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- WADAH TABEL UTAMA (DATA KARYAWAN MEKANIK) --}}
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm flex flex-col">
                <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center bg-white">
                    <div class="space-y-0.5">
                        <h2 class="text-xs font-black text-slate-800 uppercase tracking-wider">Data Kontrol Alokasi Karyawan Mekanik</h2>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Pemantauan realtime status penugasan divisi mekanik lapangan</p>
                    </div>

                    <div class="flex gap-2">
                        <div class="px-3 py-1.5 rounded-xl bg-blue-600 text-white text-[9px] font-black uppercase tracking-widest shadow-sm">
                            <span id="stat-total-aktif" class="font-black text-amber-300">0</span> Karyawan Terdaftar
                        </div>
                        <div class="px-3 py-1.5 rounded-xl bg-emerald-500 text-white text-[9px] font-black uppercase tracking-widest shadow-sm">
                            <span id="stat-total-hadir" class="font-black text-white">0</span> Standby Hadir
                        </div>
                    </div>
                </div>

                <div class="bg-blue-600 text-white border-b border-blue-700">
                    <div class="flex items-center text-center text-[9px] font-black uppercase tracking-wider py-3.5 px-4">
                        <div class="w-[6%] border-r border-white/10">No.</div>
                        <div class="w-[22%] border-r border-white/10 text-left pl-4">Nama Lengkap</div>
                        <div class="w-[22%] border-r border-white/10 text-left pl-4">Spesialisasi Keahlian</div>
                        <div class="w-[12%] border-r border-white/10">Shift Kerja</div>
                        <div class="w-[14%] border-r border-white/10">Jam Operasional</div>
                        <div class="w-[12%] border-r border-white/10">Status</div>
                        <div class="w-[12%]">Aksi</div>
                    </div>
                </div>

                {{-- AREA BARIS TABEL SCROLL BERGULIR --}}
                <div id="tableData" class="max-h-[360px] overflow-y-auto bg-white divide-y divide-slate-100 tabel-scroll-karyawan">
                    </div>
            </div>
        </div>

        {{-- AREA KANAN: KALENDER & MONITOR TIMELINE (COL-3) --}}
        <div class="col-span-3 space-y-5">

            {{-- KALENDER BOX --}}
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                <div class="bg-blue-600 px-4 py-3 flex justify-between items-center border-b border-blue-700">
                    <div>
                        <h2 class="text-white text-[10px] font-black uppercase tracking-wider">Kalender Internal</h2>
                        <p class="text-blue-100 text-[8px] font-bold uppercase tracking-widest opacity-80">Workshop Time Calendar</p>
                    </div>
                    <div class="text-white text-sm">📅</div>
                </div>

                <div class="p-4 bg-white">
                    <div class="flex justify-between items-center mb-4">
                        <button id="prevMonth" type="button" class="w-7 h-7 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-black flex items-center justify-center border border-slate-100 focus:outline-none">←</button>
                        <h3 id="monthYear" class="text-[10px] font-black uppercase tracking-widest text-slate-700"></h3>
                        <button id="nextMonth" type="button" class="w-7 h-7 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-black flex items-center justify-center border border-slate-100 focus:outline-none">→</button>
                    </div>

                    <div class="grid grid-cols-7 gap-1 text-center text-[8px] font-black text-slate-400 mb-2 tracking-wide">
                        <div>MIN</div><div>SEN</div><div>SEL</div><div>RAB</div><div>KAM</div><div>JUM</div><div>SAB</div>
                    </div>
                    <div id="calendarDays" class="grid grid-cols-7 gap-1 text-center"></div>
                </div>
            </div>

            {{-- TIMELINE AKTIVITAS OPERASIONAL --}}
            <div class="bg-blue-600 border border-blue-700 rounded-2xl overflow-hidden shadow-sm">
                <div class="px-4 py-3.5 border-b border-blue-700 flex justify-between items-center">
                    <div>
                        <h2 class="text-[10px] font-black text-white uppercase tracking-wider">Aktivitas Sistem</h2>
                        <p class="text-[8px] text-blue-100 font-bold uppercase tracking-widest opacity-80">Monitoring Log Realtime</p>
                    </div>
                    <div class="flex items-center gap-1.5 text-[8px] font-black text-white uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> LIVE
                    </div>
                </div>

                <div class="p-4 space-y-3 bg-blue-600">
                    <div class="bg-white/10 border border-white/10 rounded-xl p-3 hover:translate-x-1 transition-transform duration-200 cursor-pointer">
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-black text-white uppercase tracking-tight">Sinkronisasi Rilis</span>
                            <span class="text-[8px] text-blue-100 font-medium">System</span>
                        </div>
                        <p class="text-[9px] text-blue-100 font-medium mt-1 leading-relaxed opacity-90">Sistem berhasil memuat struktur data penyesuaian personil mekanik baru.</p>
                    </div>

                    <div class="bg-white/10 border border-white/10 rounded-xl p-3 hover:translate-x-1 transition-transform duration-200 cursor-pointer">
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-black text-white uppercase tracking-tight">Shift Pemantauan</span>
                            <span class="text-[8px] text-amber-300 font-black">Live</span>
                        </div>
                        <p class="text-[9px] text-blue-100 font-medium mt-1 leading-relaxed opacity-90">Sistem mendeteksi pembagian jam operasional bengkel berjalan normal.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    let arrayDatabaseMekanik = [
        { id: 1, nama: "Dani Ardiansyah", keahlian: "Engine Specialist", shift: "Pagi", jam: "08:00 - 16:00", status: "Hadir" },
        { id: 2, nama: "Kevin Sanjaya", keahlian: "Body Repair & Wax", shift: "Siang", jam: "13:00 - 21:00", status: "Hadir" },
        { id: 3, nama: "Marda Wijaya", keahlian: "Electrical Specialist", shift: "Malam", jam: "21:00 - 05:00", status: "Izin" },
        { id: 4, nama: "Rizky Ramadhan", keahlian: "Hydraulic Washer", shift: "Pagi", jam: "08:00 - 16:00", status: "Hadir" },
        { id: 5, nama: "Ahmad Subarjo", keahlian: "Interior Detailing", shift: "Pagi", jam: "08:00 - 16:00", status: "Hadir" },
        { id: 6, nama: "Fendi Pradana", keahlian: "Coating Specialist", shift: "Siang", jam: "13:00 - 21:00", status: "Hadir" },
        { id: 7, nama: "Hendra Lesmana", keahlian: "Glass Specialist", shift: "Malam", jam: "21:00 - 05:00", status: "Hadir" },
        { id: 8, nama: "Bagus Setiawan", keahlian: "Undercarriage Washer", shift: "Siang", jam: "13:00 - 21:00", status: "Libur" },
        { id: 9, nama: "Taufik Hidayat", keahlian: "Brake Specialist", shift: "Pagi", jam: "08:00 - 16:00", status: "Hadir" },
        { id: 10, nama: "Guntur Triyono", keahlian: "AC Detailing", shift: "Malam", jam: "21:00 - 05:00", status: "Hadir" }
    ];

    function updateTanggalRealtime() {
        const sekarang = new Date();
        const opsi = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('tanggalRealtime').innerText = sekarang.toLocaleDateString('id-ID', opsi);
    }

    function renderTabelMekanik(dataToRender) {
        const tableBody = document.getElementById('tableData');
        if(!tableBody) return;
        tableBody.innerHTML = '';

        dataToRender.forEach((row, index) => {
            let statusColor = "bg-green-100 text-green-700 border-green-200";
            if(row.status === 'Izin') statusColor = "bg-amber-100 text-amber-700 border-amber-200";
            if(row.status === 'Libur') statusColor = "bg-slate-100 text-slate-600 border-slate-200";

            let rowHtml = `
                <div class="flex items-center text-center text-[10px] font-black tracking-wide border-b border-slate-100 bg-white hover:bg-slate-50/80 transition-colors py-3.5 px-4">
                    <div class="w-[6%] text-slate-400 font-bold">${index + 1}</div>
                    <div class="w-[22%] text-slate-800 text-left pl-4 font-black uppercase tracking-wide truncate">${row.nama}</div>
                    <div class="w-[22%] text-blue-600 uppercase text-[9px] font-black text-left pl-4 tracking-wider truncate">${row.keahlian}</div>
                    <div class="w-[12%] text-indigo-600 font-black uppercase tracking-widest">${row.shift}</div>
                    <div class="w-[14%] text-slate-500 font-bold tracking-tight">${row.jam}</div>
                    <div class="w-[12%] flex justify-center">
                        <span class="px-2 py-0.5 border rounded-md ${statusColor} text-[7.5px] font-black uppercase tracking-widest shadow-sm">${row.status}</span>
                    </div>

                    {{-- REVISI PANEL SIMBOL AKSI: Dipisah menjadi dua tombol mandiri sesuai kegunaan masing-masing --}}
                    <div class="w-[12%] flex justify-center gap-2">
                        <button type="button" onclick="aksiUbahKehadiranSaja(${row.id}, '${row.nama}')" title="Ubah Kehadiran Karyawan" class="action-btn w-6 h-6 rounded-lg bg-blue-600 flex items-center justify-center text-white text-[9px] font-bold shadow-md shadow-blue-100 active:scale-90">✎</button>

                        <button type="button" onclick="aksiUbahShiftSaja(${row.id}, '${row.nama}')" title="Ubah Shift Kerja" class="action-btn w-6 h-6 rounded-lg bg-amber-500 hover:bg-amber-600 flex items-center justify-center text-white text-[11px] font-black shadow-md shadow-amber-100 active:scale-90">!</button>
                    </div>
                </div>`;
            tableBody.innerHTML += rowHtml;
        });

        let th = 0;
        arrayDatabaseMekanik.forEach(m => { if(m.status === 'Hadir') th++; });
        document.getElementById('stat-total-aktif').innerText = arrayDatabaseMekanik.length;
        document.getElementById('stat-total-hadir').innerText = th;
    }

    function jalankanSistemFilterMekanikKombinasi() {
        const shiftVal = document.getElementById('filterShift').value;
        const statusVal = document.getElementById('filterStatus').value;

        const dataTerfilter = arrayDatabaseMekanik.filter(item => {
            const matchShift = (shiftVal === 'all') || (item.shift === shiftVal);
            const matchStatus = (statusVal === 'all') || (item.status === statusVal);
            return matchShift && matchStatus;
        });

        renderTabelMekanik(dataTerfilter);
    }

    /* ==========================================================================
       AKSI 1: KHUSUS MENGUBAH KEHADIRAN (TOMBOL PENSIL ✎)
       ========================================================================== */
    function aksiUbahKehadiranSaja(idMekanik, namaMekanik) {
        let index = arrayDatabaseMekanik.findIndex(item => item.id === idMekanik);
        if(index === -1) return;

        const promptAbsen = prompt(`MANAJEMEN ABSENSI KARYAWAN\nNama: ${namaMekanik}\n\nKetik Status Kehadiran Baru (Hadir / Izin / Libur):`, arrayDatabaseMekanik[index].status);
        if (promptAbsen) {
            let resAbsen = promptAbsen.trim();
            resAbsen = resAbsen.charAt(0).toUpperCase() + resAbsen.slice(1).toLowerCase();
            if (resAbsen === "Hadir" || resAbsen === "Izin" || resAbsen === "Libur") {
                arrayDatabaseMekanik[index].status = resAbsen;
                jalankanSistemFilterMekanikKombinasi(); // Sinkronisasi live
            } else {
                alert("Gagal memperbarui! Gunakan kata: Hadir, Izin, atau Libur.");
            }
        }
    }

    /* ==========================================================================
       AKSI 2: KHUSUS MENGUBAH SHIFT KERJA (TOMBOL TANDA SERU !)
       ========================================================================== */
    function aksiUbahShiftSaja(idMekanik, namaMekanik) {
        let index = arrayDatabaseMekanik.findIndex(item => item.id === idMekanik);
        if(index === -1) return;

        const promptShift = prompt(`MANAJEMEN SHIFT OPERASIONAL KARYAWAN\nNama: ${namaMekanik}\n\nKetik Shift Kerja Baru (Pagi / Siang / Malam):`, arrayDatabaseMekanik[index].shift);
        if (promptShift) {
            let resShift = promptShift.trim();
            resShift = resShift.charAt(0).toUpperCase() + resShift.slice(1).toLowerCase();

            if (resShift === "Pagi" || resShift === "Siang" || resShift === "Malam") {
                arrayDatabaseMekanik[index].shift = resShift;

                // Jam otomatis menyesuaikan shift baru
                if (resShift === "Pagi") arrayDatabaseMekanik[index].jam = "08:00 - 16:00";
                else if (resShift === "Siang") arrayDatabaseMekanik[index].jam = "13:00 - 21:00";
                else if (resShift === "Malam") arrayDatabaseMekanik[index].jam = "21:00 - 05:00";

                jalankanSistemFilterMekanikKombinasi(); // Sinkronisasi live
            } else {
                alert("Gagal memperbarui! Gunakan kata: Pagi, Siang, atau Malam.");
            }
        }
    }

    document.getElementById('filterShift').addEventListener('change', jalankanSistemFilterMekanikKombinasi);
    document.getElementById('filterStatus').addEventListener('change', jalankanSistemFilterMekanikKombinasi);

    // KALENDER ENGINE
    const monthYear = document.getElementById('monthYear');
    const calendarDays = document.getElementById('calendarDays');
    let currentDate = new Date();

    function renderCalendar() {
        calendarDays.innerHTML = '';
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();
        const monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        monthYear.innerText = `${monthNames[month]} ${year}`;

        for(let i = 0; i < firstDay; i++) {
            calendarDays.appendChild(document.createElement('div'));
        }

        for(let day = 1; day <= lastDate; day++) {
            const date = new Date(year, month, day);
            const isSunday = date.getDay() === 0;
            const today = new Date();
            const isToday = day === today.getDate() && month === today.getMonth() && year === today.getFullYear();

            const dayDiv = document.createElement('div');
            dayDiv.className = `calendar-day h-6 flex items-center justify-center rounded-lg text-[9px] font-black cursor-pointer shadow-sm
                ${isToday ? 'bg-blue-600 text-white shadow-md' : ''}
                ${isSunday ? 'bg-red-100 text-red-700 font-extrabold' : ''}
                ${!isToday && !isSunday ? 'bg-white border border-slate-100 text-slate-700 hover:bg-slate-50' : ''}`;

            dayDiv.innerText = day;
            calendarDays.appendChild(dayDiv);
        }
    }

    document.getElementById('prevMonth').addEventListener('click', () => { currentDate.setMonth(currentDate.getMonth() - 1); renderCalendar(); });
    document.getElementById('nextMonth').addEventListener('click', () => { currentDate.setMonth(currentDate.getMonth() + 1); renderCalendar(); });

    document.addEventListener("DOMContentLoaded", () => {
        updateTanggalRealtime();
        renderCalendar();
        jalankanSistemFilterMekanikKombinasi();
    });
</script>
@endsection
