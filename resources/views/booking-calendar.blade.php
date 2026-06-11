@extends('layouts.workspace')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">

<style>
    /* ==========================================================================
       1. ANTIDOTE SAKTI: Mengunci Font & Memulihkan Layout Sidebar Workspace
       ========================================================================== */
    /* Kita kunci font Inter secara merata agar area sidebar luar ikut rapi & serasi */
    * {
        font-family: 'Inter', sans-serif;
    }

    /* Membatasi aturan scrollbar ini agar hanya bekerja di area konten kanan, tidak meluber merusak sidebar */
    .kalender-right-panel, .kalender-right-panel * {
        scrollbar-width: auto !important;
    }
    .kalender-right-panel::-webkit-scrollbar {
        display: block !important;
        width: 8px !important;
    }

    /* 2. PEMBERSIHAN BANNER: Memotong card putih besar bawaan template master di atas */
    .dashboard-container > div:first-child:not(.w-full),
    header, div:has(p:contains("PUSAT KENDALI")) {
        display: none !important;
    }

    /* 3. LAYOUT MENYATU: Menghapus padding pembungkus agar tabel mepet mentok ke tepi */
    .dashboard-container {
        padding: 0px !important;
        margin: 0px !important;
        max-width: 100% !important;
        width: 100% !important;
    }

    /* ==========================================================================
       4. WORKSPACE MATRIX CONTROL: Mengunci scrollbar agar hanya ada di bawah tabel
       ========================================================================== */
    /* Mengunci halaman kanan agar diam tegak, melimpahkan scrollbar hanya ke area horizontal */
    .kalender-right-panel {
        width: 100% !important;
        overflow-x: hidden !important;
        overflow-y: hidden !important;
    }

    /* Custom Scrollbar horizontal (geser kanan) super tipis di bawah tabel */
    .table-horizontal-scroll::-webkit-scrollbar {
        height: 6px !important;
        display: block !important;
    }
    .table-horizontal-scroll::-webkit-scrollbar-track {
        background: #f1f5f9 !important;
    }
    .table-horizontal-scroll::-webkit-scrollbar-thumb {
        background: #1e40af !important; /* Biru Safir Solid */
        border-radius: 10px !important;
    }

    /* FIGMA HOVER MOTION: Gerakan Pop-up micro pada kartu booking dengan warna super hidup */
    .live-booking-card {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .live-booking-card:hover {
        transform: translateY(-3px) scale(1.015);
        cursor: pointer;
        filter: brightness(1.1) contrast(1.02);
        box-shadow: 0 15px 20px -5px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="kalender-right-panel bg-[#f8fafc] text-slate-700 antialiased select-none flex flex-col">

    <div class="w-full bg-white border-b border-slate-200 px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 flex-shrink-0">
        <div>
            <h1 class="text-slate-900 text-sm font-extrabold uppercase tracking-tight" style="font-family: 'Inter', sans-serif;">WORKSPACE ORDER CALENDAR</h1>
            <p class="text-slate-400 text-[9px] font-bold uppercase tracking-wider" style="font-family: 'Inter', sans-serif;">Sistem Pemesanan & Alokasi Antrean Customer</p>
        </div>

        <div class="flex items-center gap-3 flex-wrap sm:flex-nowrap">

            <div class="flex items-center gap-2 bg-amber-50 border border-amber-200 text-amber-800 px-3.5 py-2 rounded-xl shadow-sm">
                <span class="flex h-1.5 w-1.5 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-amber-500"></span>
                </span>
                <span class="text-[9px] font-bold tracking-wide uppercase" style="font-family: 'Inter', sans-serif;">🔔 Pengingat: 2 Booking Baru Menunggu Verifikasi Kasir</span>
            </div>

            <div class="flex items-center bg-slate-100 rounded-lg border border-slate-200 p-0.5 shadow-inner">
                <select id="select-bulan-tahun" onchange="filterBulanTahunSistem()" class="bg-transparent text-slate-800 text-[10px] font-bold px-2 py-1.5 focus:outline-none cursor-pointer" style="font-family: 'Inter', sans-serif;">
                    <option value="05-2026">Mei 2026</option>
                    <option value="06-2026">Juni 2026</option>
                    <option value="07-2026">Juli 2026</option>
                </select>
            </div>
        </div>
    </div>

        <div class="w-full overflow-x-auto table-horizontal-scroll bg-white">

            <table class="w-full border-collapse table-fixed min-w-[1700px]">

                <thead class="sticky top-0 z-20 bg-[#1e40af] border-b border-blue-900 shadow-md">
                    <tr>
                        <th class="sticky left-0 z-30 bg-[#172554] p-3.5 text-center text-[10px] font-black text-blue-200 uppercase tracking-wider w-[140px]" style="font-family: 'Inter', sans-serif;">
                            Hari / Tanggal
                        </th>
                        <th class="p-3.5 border-r border-blue-800/40 text-center text-[10px] font-bold text-white tracking-wider" style="font-family: 'Inter', sans-serif;">08:00 WIB</th>
                        <th class="p-3.5 border-r border-blue-800/40 text-center text-[10px] font-bold text-white tracking-wider" style="font-family: 'Inter', sans-serif;">09:00 WIB</th>
                        <th class="p-3.5 border-r border-blue-800/40 text-center text-[10px] font-bold text-white tracking-wider" style="font-family: 'Inter', sans-serif;">10:00 WIB</th>
                        <th class="p-3.5 border-r border-blue-800/40 text-center text-[10px] font-bold text-white tracking-wider" style="font-family: 'Inter', sans-serif;">11:00 WIB</th>
                        <th class="p-3.5 border-r border-red-900/40 text-center text-[10px] font-bold text-red-100 bg-[#b91c1c]" style="font-family: 'Inter', sans-serif;">12:00 WIB <span class="text-[8px] font-normal block text-red-200">(Istirahat)</span></th>
                        <th class="p-3.5 border-r border-blue-800/40 text-center text-[10px] font-bold text-white tracking-wider" style="font-family: 'Inter', sans-serif;">13:00 WIB</th>
                        <th class="p-3.5 border-r border-blue-800/40 text-center text-[10px] font-bold text-white tracking-wider" style="font-family: 'Inter', sans-serif;">14:00 WIB</th>
                        <th class="p-3.5 border-r border-blue-800/40 text-center text-[10px] font-bold text-white tracking-wider" style="font-family: 'Inter', sans-serif;">15:00 WIB</th>
                        <th class="p-3.5 border-r border-blue-800/40 text-center text-[10px] font-bold text-white tracking-wider" style="font-family: 'Inter', sans-serif;">16:00 WIB</th>
                        <th class="p-3.5 border-r border-blue-800/40 text-center text-[10px] font-bold text-white tracking-wider" style="font-family: 'Inter', sans-serif;">17:00 WIB</th>
                    </tr>
                </thead>

                <tbody id="tabel-operasional-body" class="divide-y divide-slate-100">

                    </tbody>
            </table>
        </div>
    </div>
</div>

<script>

    // 📝 DATA SOURCE: Pemilik perusahaan bebas mengubah, menambah, atau menghapus jadwal, jam, hari libur nyata di sini nanti!
    const arrayJadwalCarwash = [
        { hari: "Senin", tanggal: "18 Mei 2026", tipe: "buka", slots: {
            "08:00": { nopol: "B 1111 AAA", nama: "Doni", mobil: "Avanza", status: "QUEUE", gradient: "from-[#2563eb] to-[#1d4ed8]" },
            "10:00": { nopol: "B 8888 BOSS", nama: "Kevin", mobil: "Alphard", status: "COATING", gradient: "from-[#7c3aed] to-[#6d28d9]" }
        }},
        { hari: "Selasa", tanggal: "19 Mei 2026", tipe: "buka", slots: {
            "09:00": { nopol: "B 2026 RFV", nama: "Hendra", mobil: "Fortuner", status: "PROGRESS", gradient: "from-[#059669] to-[#047857]" }
        }},
        { hari: "Rabu", tanggal: "20 Mei 2026", tipe: "libur", pesan: "🛑 WORKSHOP TUTUP — LIBUR NASIONAL / MAINTENANCE COMPRESSOR PUSAT" }, // Merah Menyala Terang Sesuai Dunia Nyata
        { hari: "Kamis", tanggal: "21 Mei 2026", tipe: "buka", slots: {
            "10:00": { nopol: "D 1411 XYZ", nama: "Ibu Rina", mobil: "Civic", status: "QUEUE", gradient: "from-[#2563eb] to-[#1d4ed8]" }
        }},
        { hari: "Jumat", tanggal: "22 Mei 2026", tipe: "buka", slots: {} },
        { hari: "Sabtu", tanggal: "23 Mei 2026", tipe: "buka", slots: {} },
        { hari: "Minggu", tanggal: "24 Mei 2026", tipe: "libur", pesan: "🛑 WORKSHOP TUTUP — LIBUR OPERASIONAL AKHIR PEKAN" } // Merah Menyala Terang Sesuai Dunia Nyata
    ];

    function prosesRenderMatrix() {
        const tbody = document.getElementById('tabel-operasional-body');
        tbody.innerHTML = "";

        arrayJadwalCarwash.forEach(row => {
            let tr = document.createElement('tr');
            tr.className = "h-[75px]";

            // 1. Render Kolom Sisi Kiri Hari & Tanggal (Sticky di kiri saat tabel digeser ke kanan)
            let tdHari = document.createElement('td');
            tdHari.className = `sticky left-0 z-10 p-2 text-center border-r border-slate-200 flex flex-col justify-center h-[75px] ${row.tipe === 'libur' ? 'bg-red-600 text-white font-black shadow-md' : 'bg-slate-50 text-slate-900 font-bold'}`;
            tdHari.innerHTML = `<span class="text-[11px] tracking-tight" style="font-family: 'Inter', sans-serif; font-weight: 700;">${row.hari}</span><span class="text-[8px] ${row.tipe === 'libur' ? 'text-red-100' : 'text-slate-400'} font-bold mt-0.5" style="font-family: 'Inter', sans-serif;">${row.tanggal}</span>`;
            tr.appendChild(tdHari);

            // Kondisi Khusus Hari Libur Nyata (Warna Dipermerah Pekat Mengunci ke Sisi Tepi Sesuai Request Dunia Nyata)
            if (row.tipe === "libur") {
                let tdLibur = document.createElement('td');
                tdLibur.colSpan = 10;
                tdLibur.className = "p-2 text-center bg-red-600 text-white border-b border-red-700 font-extrabold";
                tdLibur.innerHTML = `<div class="text-[10px] tracking-widest uppercase" style="font-family: 'Inter', sans-serif;">${row.pesan}</div>`;
                tr.appendChild(tdLibur);
                tbody.appendChild(tr);
                return;
            }

            // 2. Render Lajur Kolom Waktu Jam Berjejer ke Kanan
            const jamKerja = ["08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00"];
            jamKerja.forEach(jam => {
                let tdSlot = document.createElement('td');
                tdSlot.className = `p-1 border-r border-slate-100 text-center text-[9px] font-bold relative ${jam === "12:00" ? "bg-red-600/20 border-l border-r border-red-200" : ""}`;

                if (jam === "12:00") {
                    // Penanda Waktu Istirahat Merah Pekat Tegas Sesuai Dunia Nyata
                    tdSlot.innerHTML = `<span class="text-red-700 text-[8px] tracking-wider font-black uppercase" style="font-family: 'Inter', sans-serif;">❌ ISTIRAHAT</span>`;
                } else if (row.slots[jam]) {
                    // Kotak Bookingan Pelanggan: Teks Lebih Kecil (Sedang-Kecil Pas), Warna Gradasi Super Hidup Menyala
                    let data = row.slots[jam];
                    tdSlot.innerHTML = `
                        <div class="live-booking-card bg-gradient-to-r ${data.gradient} text-white rounded-lg p-1.5 text-left h-full flex flex-col justify-between shadow-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-[9px] font-bold tracking-tight" style="font-family: 'Inter', sans-serif;">${data.nopol}</span>
                                <span class="text-[7px] bg-white/25 px-1 py-0.2 rounded font-black tracking-wide" style="font-family: 'Inter', sans-serif;">${data.status}</span>
                            </div>
                            <div class="text-[8px] font-medium opacity-95 truncate mt-0.5" style="font-family: 'Inter', sans-serif;">${data.nama} — ${data.mobil}</div>
                        </div>
                    `;
                } else {
                    tdSlot.innerHTML = `<span class="text-slate-200 font-normal">-</span>`;
                }
                tr.appendChild(tdSlot);
            });

            tbody.appendChild(tr);
        });
    }

    // Penanganan Filter Sistem Kalender Mengikuti Tahun Aktif
    function filterBulanTahunSistem() {
        const valuePilihan = document.getElementById('select-bulan-tahun').value;
        console.log("Sistem memuat matriks data kalender untuk tahun aktif periode: " + valuePilihan);
        prosesRenderMatrix();
    }

    document.addEventListener("DOMContentLoaded", prosesRenderMatrix);
</script>

@endsection
