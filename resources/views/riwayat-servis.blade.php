@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght=400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    /* Mengubah seluruh elemen teks di halaman internal menggunakan font Inter & Bold */
    .riwayat-scope, .riwayat-scope * {
        font-family: 'Inter', sans-serif !important;
        font-weight: 700 !important;
    }
    /* Custom scrollbar internal tipis dan sangat bersih saat data menumpuk */
    .report-scroll-clean::-webkit-scrollbar {
        width: 5px !important;
        height: 5px !important;
    }
    .report-scroll-clean::-webkit-scrollbar-track {
        background: #f8fafc !important;
    }
    .report-scroll-clean::-webkit-scrollbar-thumb {
        background: #cbd5e1 !important;
        border-radius: 10px !important;
    }
</style>

<!-- CONTAINER UTAMA DASHBOARD RIWAYAT SERVIS -->
<div class="riwayat-scope w-full h-[calc(100vh-2px)] bg-[#f8fafc] flex flex-col overflow-hidden select-none antialiased text-slate-700">

    <!-- HEADER UTAMA - WARNA BIRU SOLID SIDEBAR (BG-BLUE-600) & TANPA ICON DEKAT TEKS -->
    <div class="w-full bg-blue-600 border-b border-blue-700 px-6 py-3.5 flex justify-between items-center flex-shrink-0 shadow-md shadow-slate-900/10 z-20">
        <div>
            <h1 class="text-white text-sm font-black uppercase tracking-tight">DATA ARSIP RIWAYAT SERVIS CARWASH</h1>
            <p class="text-blue-100 text-[9px] font-bold uppercase tracking-wider mt-0.5">Manajemen Track Record Pemesanan, Status Kerja, &amp; Arsip Transaksi Selesai</p>
        </div>
        <div class="bg-white/10 border border-white/20 px-3 py-1.5 rounded-xl text-white text-[10px] font-black uppercase tracking-wide">
            Data Ditemukan: <span id="live-counter-data" class="text-amber-300 font-black">0 Data</span>
        </div>
    </div>

    <!-- AREA GRID DATA & SINKRONISASI -->
    <div class="w-full flex-1 flex flex-col p-4 gap-3.5 overflow-hidden">

        <!-- 📊 4 KOTAK CARD METRIK UTAMA - KONDISI AWAL RILIS WEBSITE 0 BERSIH DENGAN BAYANGAN ABU-ABU TIPIS -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3.5 flex-shrink-0">

            <!-- CARD 1: TOTAL PENDAPATAN -->
            <div class="bg-white border border-slate-100 rounded-xl p-4 flex justify-between items-center shadow-md shadow-slate-900/5">
                <div>
                    <span class="block text-[9px] font-black text-slate-400 uppercase tracking-wider">Total Pendapatan</span>
                    <span id="card-total-rupiah" class="block text-base font-black text-slate-800 tracking-tight mt-1">Rp 0</span>
                </div>
                <!-- Kotak Ikon Mengambang dengan Efek Bayangan Berwarna (Drop Shadow) -->
                <div class="bg-blue-600 p-2.5 rounded-xl text-white flex items-center justify-center flex-shrink-0 filter drop-shadow-[0_4px_6px_rgba(37,99,235,0.4)]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
            </div>

            <!-- CARD 2: MOBIL SELESAI -->
            <div class="bg-white border border-slate-100 rounded-xl p-4 flex justify-between items-center shadow-md shadow-slate-900/5">
                <div>
                    <span class="block text-[9px] font-black text-slate-400 uppercase tracking-wider">Mobil Selesai</span>
                    <span id="card-qty-selesai" class="block text-base font-black text-slate-800 tracking-tight mt-1">0 Kendaraan</span>
                </div>
                <!-- Kotak Ikon Mengambang dengan Efek Bayangan Berwarna (Drop Shadow) -->
                <div class="bg-emerald-600 p-2.5 rounded-xl text-white flex items-center justify-center flex-shrink-0 filter drop-shadow-[0_4px_6px_rgba(16,185,129,0.4)]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </div>
            </div>

            <!-- CARD 3: SERVIS DISETUJUI -->
            <div class="bg-white border border-slate-100 rounded-xl p-4 flex justify-between items-center shadow-md shadow-slate-900/5">
                <div>
                    <span class="block text-[9px] font-black text-slate-400 uppercase tracking-wider">Servis Disetujui</span>
                    <span id="card-qty-approved" class="block text-base font-black text-slate-800 tracking-tight mt-1">0 Kendaraan</span>
                </div>
                <!-- Kotak Ikon Mengambang dengan Efek Bayangan Berwarna (Drop Shadow) -->
                <div class="bg-amber-500 p-2.5 rounded-xl text-white flex items-center justify-center flex-shrink-0 filter drop-shadow-[0_4px_6px_rgba(245,158,11,0.4)]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
            </div>

            <!-- CARD 4: RATA-RATA / PAKET -->
            <div class="bg-white border border-slate-100 rounded-xl p-4 flex justify-between items-center shadow-md shadow-slate-900/5">
                <div>
                    <span class="block text-[9px] font-black text-slate-400 uppercase tracking-wider">Rata-rata / Paket</span>
                    <span id="card-total-average" class="block text-base font-black text-slate-800 tracking-tight mt-1">Rp 0</span>
                </div>
                <!-- Kotak Ikon Mengambang dengan Efek Bayangan Berwarna (Drop Shadow) -->
                <div class="bg-purple-600 p-2.5 rounded-xl text-white flex items-center justify-center flex-shrink-0 filter drop-shadow-[0_4px_6px_rgba(147,51,234,0.4)]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                    </svg>
                </div>
            </div>

        </div>

        <!-- 📦 WADAH UTAMA FILTER & TABEL YANG MENYATU TOTAL -->
        <div class="w-full flex-1 bg-white border border-slate-200 rounded-xl flex flex-col overflow-hidden shadow-sm">

            <!-- ACTION BAR INTERNAL -->
            <div class="w-full px-4 py-3 border-b border-slate-100 bg-white flex flex-col lg:flex-row justify-between items-center gap-4 flex-shrink-0">

                <!-- Kolom Pencarian Kaca Pembesar Minimalis Berkepanjangan -->
                <div class="relative w-full sm:w-72">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </span>
                    <input type="text" id="search-input" oninput="onFilterRiwayatEngineChange()" placeholder="Cari nomor polisi atau nama customer..." class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[10px] pl-9 pr-3 py-2 rounded-xl focus:outline-none focus:border-blue-500 shadow-inner placeholder:text-slate-400/80">
                </div>

                <!-- Parameter Filter Waktu Real-Time -->
                <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto justify-end">
                    <div class="flex items-center gap-1.5">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Tanggal:</span>
                        <select id="filter-tanggal" onchange="onFilterRiwayatEngineChange()" class="bg-slate-50 border border-slate-200 text-slate-800 text-[9px] px-2 py-1.5 rounded-lg focus:outline-none cursor-pointer shadow-inner">
                            <option value="ALL">Semua Tanggal</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-1.5">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Bulan:</span>
                        <select id="filter-bulan" onchange="onFilterRiwayatEngineChange()" class="bg-slate-50 border border-slate-200 text-slate-800 text-[9px] px-2 py-1.5 rounded-lg focus:outline-none cursor-pointer shadow-inner">
                            <option value="ALL">Semua Bulan</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-1.5">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Tahun:</span>
                        <select id="filter-tahun" onchange="onFilterRiwayatEngineChange()" class="bg-slate-50 border border-slate-200 text-slate-800 text-[9px] px-2 py-1.5 rounded-lg focus:outline-none cursor-pointer shadow-inner">
                            <option value="ALL">Semua Tahun</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- AREA DATA TABEL SCROLL DOWN COMPACT -->
            <div class="flex-1 overflow-y-auto report-scroll-clean bg-white">
                <table class="w-full border-collapse text-left table-fixed border-hidden">
                    <thead class="sticky top-0 z-10 bg-blue-600 text-white text-[8.5px] font-black uppercase tracking-wider shadow-sm">
                        <tr>
                            <th class="p-2.5 text-center w-[5%]">No.</th>
                            <th class="p-2.5 text-center w-[12%]">Nomor Polisi</th>
                            <th class="p-2.5 text-center w-[22%]">Nama Customer</th>
                            <th class="p-2.5 text-center w-[22%]">Tipe / Model Mobil</th>
                            <th class="p-2.5 text-center w-[17%]">Paket &amp; Detail Kerja</th>
                            <th class="p-2.5 text-center w-[11%]">Total Biaya</th>
                            <th class="p-2.5 text-center w-[11%]">Status Kerja</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-riwayat-body" class="divide-y divide-slate-100 text-[8.5px] text-slate-700">
                        <!-- Di-inject oleh Javascript secara realtime -->
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- ==========================================
     LOGIKA FILTER ENGINE & LIVE SYNC SCRIPT (JS)
     ========================================== -->
<script>
    // Membaca database transaksi riel Laravel terikat dari controller
    const arrayDatabaseKeuangan = @json($dataFinance) || [];

    function formatRupiah(angka) {
        if (angka === null || angka === undefined || isNaN(angka)) {
            angka = 0;
        }
        return "Rp " + Number(angka).toLocaleString('id-ID');
    }

    function initTanggalDropdown() {
        const selectTgl = document.getElementById('filter-tanggal');
        if(!selectTgl) return;
        for (let i = 1; i <= 31; i++) {
            let val = i < 10 ? "0" + i : "" + i;
            let opt = document.createElement('option');
            opt.value = val;
            opt.innerText = val;
            selectTgl.appendChild(opt);
        }
    }

    function resetCardStatistikKeNol() {
        document.getElementById('live-counter-data').innerText = "0 Data";
        document.getElementById('card-total-rupiah').innerText = "Rp 0";
        document.getElementById('card-qty-selesai').innerText = "0 Kendaraan";
        document.getElementById('card-qty-approved').innerText = "0 Kendaraan";
        document.getElementById('card-total-average').innerText = "Rp 0";
    }

    function updateCardStatistikRealtime(dataTerfilter) {
        let totalServis = dataTerfilter.length;
        if (totalServis === 0) {
            resetCardStatistikKeNol();
            return;
        }

        let totalRupiah = 0;
        let qtySelesai = 0;
        let qtyApproved = 0;

        dataTerfilter.forEach(row => {
            let nominalAman = row.nominal ? Number(row.nominal) : 0;
            totalRupiah += nominalAman;
            qtySelesai++;
            qtyApproved++;
        });

        let rataRata = totalServis > 0 ? Math.round(totalRupiah / totalServis) : 0;

        document.getElementById('live-counter-data').innerText = totalServis + " Data";
        document.getElementById('card-total-rupiah').innerText = formatRupiah(totalRupiah);
        document.getElementById('card-qty-selesai').innerText = qtySelesai + " Kendaraan";
        document.getElementById('card-qty-approved').innerText = qtyApproved + " Kendaraan";
        document.getElementById('card-total-average').innerText = formatRupiah(rataRata);
    }

    function renderTabelRiwayatServis(dataToRender) {
        const tbody = document.getElementById('tabel-riwayat-body');
        if (!tbody) return;
        tbody.innerHTML = "";

        // JIKA BELUM ADA DATA INPUTAN YANG MASUK SAMA SEKALI
        if (!dataToRender || dataToRender.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="p-8 text-center text-slate-400 font-medium italic text-[8.5px]">
                        👋 Belum ada arsip log riwayat servis terkonfirmasi dari sistem kasir/admin. Tampilan dashboard dikunci 0.
                    </td>
                </tr>
            `;
            resetCardStatistikKeNol();
            return;
        }

        // JIKA ADMIN SUDAH MENGINPUT DATA TRANSAKSI CUSTOMER, MAKA OTOMATIS BERUBAH REALTIME
        dataToRender.forEach((row, index) => {
            let tr = document.createElement('tr');
            tr.className = "hover:bg-slate-50/70 transition-colors duration-150 h-[44px]";

            let tdNo = document.createElement('td');
            tdNo.className = "p-2 text-center text-slate-400 font-medium";
            tdNo.innerText = index + 1;
            tr.appendChild(tdNo);

            let tdNopol = document.createElement('td');
            tdNopol.className = "p-2 text-center text-slate-900 font-black tracking-wide uppercase";
            tdNopol.innerText = row.nopol;
            tr.appendChild(tdNopol);

            let tdNama = document.createElement('td');
            tdNama.className = "p-2 text-left text-slate-800 truncate pl-4";
            tdNama.innerText = row.nama;
            tr.appendChild(tdNama);

            let tdJenis = document.createElement('td');
            tdJenis.className = "p-2 text-left text-slate-600 uppercase truncate pl-4";
            tdJenis.innerText = row.jenis || "KENDARAAN";
            tr.appendChild(tdJenis);

            let tdPaket = document.createElement('td');
            tdPaket.className = "p-2 text-left flex flex-col justify-center h-[44px] pl-4";
            let subDetail = (row.kategori && row.kategori.toLowerCase().includes('coating')) ? "Glass & Inside Clean" : "Engine & Inside Vacuum";
            tdPaket.innerHTML = `
                <span class="text-blue-600 font-black uppercase text-[8px] tracking-wide leading-none">${row.kategori || 'STANDARD'}</span>
                <span class="text-slate-400 font-medium text-[7px] mt-0.5 leading-none">+ ${subDetail}</span>
            `;
            tr.appendChild(tdPaket);

            let tdNominal = document.createElement('td');
            tdNominal.className = "p-2 text-right text-slate-900 font-black pr-6";
            tdNominal.innerText = formatRupiah(row.nominal);
            tr.appendChild(tdNominal);

            let tdStatus = document.createElement('td');
            tdStatus.className = "p-2 text-center px-4";

            let colorProgress = "bg-blue-600";
            let widthProgress = "w-[75%]";
            let textProgress = "Progres Cuci";

            if (row.kategori && row.kategori.toLowerCase().includes('coating')) {
                colorProgress = "bg-purple-600";
                widthProgress = "w-[90%]";
                textProgress = "Tahap Coating";
            } else if (row.kategori && row.kategori.toLowerCase().includes('wax')) {
                colorProgress = "bg-indigo-600";
                widthProgress = "w-[85%]";
                textProgress = "Finishing Wax";
            }

            tdStatus.innerHTML = `
                <div class="w-full flex flex-col items-center gap-1">
                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden border border-slate-200/50">
                        <div class="h-full ${colorProgress} ${widthProgress} rounded-full"></div>
                    </div>
                    <span class="text-[6.5px] uppercase font-black tracking-wider text-slate-400 block">${textProgress}</span>
                </div>
            `;
            tr.appendChild(tdStatus);

            tbody.appendChild(tr);
        });

        updateCardStatistikRealtime(dataToRender);
    }

    // 🔥 SEARCH FILTER ENGINE NYATA: Mendeteksi kecocokan kode / teks nopol maupun nama customer secara langsung
    function onFilterRiwayatEngineChange() {
        const tglFilter = document.getElementById('filter-tanggal').value;
        const blnFilter = document.getElementById('filter-bulan').value;
        const thnFilter = document.getElementById('filter-tahun').value;
        const searchVal = document.getElementById('search-input').value.toLowerCase().trim();

        const hasilPenyaringanRiwayat = arrayDatabaseKeuangan.filter(item => {
            const matchTanggal = (tglFilter === "ALL") || (item.tgl === tglFilter);
            const matchBulan = (blnFilter === "ALL") || (item.bln === blnFilter);
            const matchTahun = (thnFilter === "ALL") || (item.thn === thnFilter);

            // Mencocokkan inputan admin ke kolom Nama, Nomor Polisi, maupun Jenis Mobil
            const matchSearch = (searchVal === "") ||
                                (item.nama && item.nama.toLowerCase().includes(searchVal)) ||
                                (item.nopol && item.nopol.toLowerCase().includes(searchVal)) ||
                                (item.jenis && item.jenis.toLowerCase().includes(searchVal));

            return matchTanggal && matchBulan && matchTahun && matchSearch;
        });

        renderTabelRiwayatServis(hasilPenyaringanRiwayat);
    }

    document.addEventListener("DOMContentLoaded", () => {
        initTanggalDropdown();
        onFilterRiwayatEngineChange();
    });
</script>
@endsection
