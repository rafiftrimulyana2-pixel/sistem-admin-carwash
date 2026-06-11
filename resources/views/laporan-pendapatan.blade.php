@extends('layouts.workspace')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    /* Menggunakan tanda bintang (*) agar font Inter merata sampai ke area sidebar */
    * { font-family: 'Inter', sans-serif; }

    /* Custom scrollbar tipis bawaan laporan kamu tetap utuh */
    .report-scroll-clean::-webkit-scrollbar {
        width: 5px !important;
        height: 5px !important;
    }
    .report-scroll-clean::-webkit-scrollbar-track {
        background: #f1f5f9 !important;
    }
    .report-scroll-clean::-webkit-scrollbar-thumb {
        background: #c7d2fe !important;
        border-radius: 10px !important;
    }
</style>

<div class="w-full h-[calc(100vh-2px)] bg-[#f4f7fb] flex flex-col overflow-hidden select-none antialiased text-slate-700">

    <div class="w-full bg-blue-600 border-b border-blue-700 px-6 py-3.5 flex justify-between items-center flex-shrink-0 shadow-md shadow-slate-900/10 z-20">
        <div>
            <h1 class="text-white text-sm font-extrabold uppercase tracking-tight">LAPORAN KEUANGAN & PENDAPATAN</h1>
            <p class="text-blue-100 text-[9px] font-bold uppercase tracking-wider mt-0.5">Analisis Grafik Omset, Aliran Kas Masuk, &amp; Rekapitulasi Pembayaran Pelanggan Terkonfirmasi</p>
        </div>
        <div class="bg-white/10 border border-white/20 px-3 py-1.5 rounded-xl text-white text-[10px] font-bold uppercase tracking-wide">
            Periode Utama: <span id="live-tahun-dunia" class="text-amber-300 font-black">2026</span>
        </div>
    </div>

    <div class="w-full flex-1 flex flex-col p-4 gap-3.5 overflow-hidden">
        <div class="w-full bg-white border border-slate-200 rounded-xl p-3 shadow-sm flex flex-col lg:flex-row gap-4 justify-between items-center flex-shrink-0">
            <div class="flex items-center gap-2">
                <div class="h-2 w-2 rounded-full bg-blue-600 animate-pulse"></div>
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Sistem Penyelarasan &amp; Sinkronisasi Aliran Kas Masuk Pemilik Perusahaan</span>
            </div>

            <div class="flex flex-wrap items-center gap-4">
                <div class="bg-slate-50 border border-slate-200/80 rounded-xl px-3 py-1.5 flex items-center gap-3 shadow-inner">
                    <div class="flex flex-col">
                        <span class="text-[7.5px] font-black text-slate-400 uppercase tracking-wider">Hasil Terdata</span>
                        <span id="realtime-sum-nominal" class="text-[9.5px] font-black text-emerald-600">Rp 0</span>
                    </div>

                    <div class="h-6 w-px bg-slate-200"></div>
                    <div class="flex flex-col">
                        <span class="text-[7.5px] font-black text-slate-400 uppercase tracking-wider">Volume Transaksi</span>
                        <span id="realtime-sum-qty" class="text-[9.5px] font-black text-blue-600">0 Data</span>
                    </div>
                </div>

                <div class="flex items-center gap-1.5">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Bulan:</span>
                    <select id="filter-bulan" onchange="onFilterBulanTahunLaporanChange()" class="bg-slate-50 border border-slate-200 text-slate-800 text-[9px] font-bold p-2 rounded-lg focus:outline-none cursor-pointer shadow-inner">
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
                    <select id="filter-tahun" onchange="onFilterBulanTahunLaporanChange()" class="bg-slate-50 border border-slate-200 text-slate-800 text-[9px] font-bold p-2 rounded-lg focus:outline-none cursor-pointer shadow-inner">
                        <option value="ALL">Semua Tahun</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex flex-1 gap-5 overflow-hidden">
            <div class="w-[40%] h-full flex flex-col gap-3.5 overflow-y-auto report-scroll-clean flex-shrink-0 pr-1">
                <div class="bg-blue-600 text-white rounded-xl p-6 border border-blue-500 flex justify-between items-center flex-shrink-0 shadow-md">
                    <div>
                        <span class="block text-[10px] font-black text-blue-100 uppercase tracking-[0.12em]">Total Omset Pendapatan</span>
                        <span id="stat-total-omset" class="block text-xl font-black tracking-tight mt-1">Rp 0</span>
                    </div>

                    <div class="bg-white p-2 rounded-xl text-blue-600 shadow-md flex items-center justify-center flex-shrink-0 ml-4 border border-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7">
                            <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/>
                        </svg>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm flex flex-col flex-1 min-h-[250px]">
                    <span class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.15em] text-center mb-6">
                        Analisis Akumulasi Distribusi Aliran Metode Pembayaran
                    </span>

                    <div class="flex-1 flex items-end justify-around h-full border-b border-slate-100 pb-2 gap-6 px-2">
                        <div class="flex flex-col items-center w-full h-full justify-end relative group">
                            <span id="val-cash" class="text-[8.5px] font-black text-blue-600 mb-1.5 transition-all duration-300">Rp 0</span>
                            <div class="w-full bg-slate-50 rounded-t-lg h-full flex flex-col justify-end overflow-hidden border border-slate-100/50">
                                <div id="bar-cash" class="w-full bg-gradient-to-t from-blue-600 via-blue-500 to-blue-400 rounded-t-md transition-all duration-700 ease-out shadow-[0_-2px_8px_rgba(37,99,235,0.2)]" style="height: 0%;"></div>
                            </div>
                        </div>

                        <div class="flex flex-col items-center w-full h-full justify-end relative group">
                            <span id="val-qris" class="text-[8.5px] font-black text-indigo-600 mb-1.5 transition-all duration-300">Rp 0</span>
                            <div class="w-full bg-slate-50 rounded-t-lg h-full flex flex-col justify-end overflow-hidden border border-slate-100/50">
                                <div id="bar-qris" class="w-full bg-gradient-to-t from-indigo-600 via-indigo-500 to-indigo-400 rounded-t-md transition-all duration-700 ease-out shadow-[0_-2px_8px_rgba(79,70,229,0.2)]" style="height: 0%;"></div>
                            </div>
                        </div>

                        <div class="flex flex-col items-center w-full h-full justify-end relative group">
                            <span id="val-transfer" class="text-[8.5px] font-black text-purple-600 mb-1.5 transition-all duration-300">Rp 0</span>
                            <div class="w-full bg-slate-50 rounded-t-lg h-full flex flex-col justify-end overflow-hidden border border-slate-100/50">
                                <div id="bar-transfer" class="w-full bg-gradient-to-t from-purple-600 via-purple-500 to-purple-400 rounded-t-md transition-all duration-700 ease-out shadow-[0_-2px_8px_rgba(147,51,234,0.2)]" style="height: 0%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-around text-[8px] font-black uppercase text-slate-400 tracking-wider mt-3">
                        <span class="w-16 text-center border-t-2 border-blue-500/20 pt-1.5">Cash</span>
                        <span class="w-16 text-center border-t-2 border-indigo-500/20 pt-1.5">QRIS</span>
                        <span class="w-16 text-center border-t-2 border-purple-500/20 pt-1.5">Transfer</span>
                    </div>
                </div>
            </div>

            <div class="w-[60%] h-full bg-white border border-slate-200 rounded-xl overflow-y-auto report-scroll-clean shadow-sm">
                <table class="w-full border-collapse text-left table-fixed">
                    <thead class="sticky top-0 z-10 bg-blue-600 border-b border-blue-700 shadow-sm text-white text-[8.5px] font-black uppercase tracking-wider">
                        <tr>
                            <th class="p-2.5 text-center w-[6%]">No.</th>
                            <th class="p-2.5 w-[15%]">Tanggal</th>
                            <th class="p-2.5 w-[18%]">Nomor Plate</th>
                            <th class="p-2.5 text-center w-[33%]">Nama Customer</th>
                            <th class="p-2.5 text-center w-[14%]">Metode Bayar</th>
                            <th class="p-2.5 text-right w-[14%] pr-4">Nominal</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-laporan-body" class="divide-y divide-slate-100 text-[8.5px] font-bold text-slate-700">
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
    // Membaca database transaksi riel Laravel terikat dari controller kasir kamu
    const arrayDatabaseKeuangan = @json($dataFinance ?? []) || [];
    function formatRupiah(angka) {
        if (angka === null || angka === undefined || isNaN(angka)) angka = 0;
        return "Rp " + Number(angka).toLocaleString('id-ID');
    }

    function updateGrafikDanStatistik(dataTerfilter) {
        let totalOmset = 0;
        let totalCash = 0;
        let totalQris = 0;
        let totalTransfer = 0;
        dataTerfilter.forEach(row => {
            let nominalValue = row.nominal ? Number(row.nominal) : 0;
            totalOmset += nominalValue;

            // Standardisasi filter pencocokan huruf besar metode kasir
            let mtd = row.metode ? row.metode.toUpperCase() : "TUNAI";
            if (mtd === "TUNAI" || mtd === "CASH") {
                totalCash += nominalValue;
            } else if (mtd === "QRIS") {
                totalQris += nominalValue;
            } else if (mtd === "TRANSFER" || mtd === "BANK") {
                totalTransfer += nominalValue;
            }
        });

        const omsetEl = document.getElementById('stat-total-omset');
        if (omsetEl) omsetEl.innerText = formatRupiah(totalOmset);

        document.getElementById('realtime-sum-nominal').innerText = formatRupiah(totalOmset);
        document.getElementById('realtime-sum-qty').innerText = dataTerfilter.length + " Data";
        document.getElementById('val-cash').innerText = formatRupiah(totalCash);
        document.getElementById('val-qris').innerText = formatRupiah(totalQris);
        document.getElementById('val-transfer').innerText = formatRupiah(totalTransfer);

        let maxNominal = Math.max(totalCash, totalQris, totalTransfer, 1);
        const barCash = document.getElementById('bar-cash');
        if (barCash) barCash.style.height = dataTerfilter.length > 0 ? ((totalCash / maxNominal) * 100) + "%" : "0%";
        const barQris = document.getElementById('bar-qris');
        if (barQris) barQris.style.height = dataTerfilter.length > 0 ? ((totalQris / maxNominal) * 100) + "%" : "0%";
        const barTransfer = document.getElementById('bar-transfer');
        if (barTransfer) barTransfer.style.height = dataTerfilter.length > 0 ? ((totalTransfer / maxNominal) * 100) + "%" : "0%";
    }
    function renderTabelLaporanKeuangan(dataToRender) {
        const tbody = document.getElementById('tabel-laporan-body');
        if (!tbody) return;
        tbody.innerHTML = "";
        if (!dataToRender || dataToRender.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="p-8 text-center text-slate-400 font-medium italic text-[8.5px]">
                        👋 Belum ada data pendapatan terkonfirmasi pada periode filter ini, Chief. Tampilan dikunci 0.
                    </td>
                </tr>
            `;
            updateGrafikDanStatistik([]);
            return;
        }
        dataToRender.forEach((row, index) => {
            let tr = document.createElement('tr');
            tr.className = "hover:bg-slate-50/60 transition-colors duration-150 h-[36px]";

            // 1. Nomor
            let tdNo = document.createElement('td');
            tdNo.className = "p-2 text-center text-slate-400 font-medium";
            tdNo.innerText = index + 1;
            tr.appendChild(tdNo);

            // 2. Tanggal Transaksi
            let tdTgl = document.createElement('td');
            tdTgl.className = "p-2 text-slate-500 font-semibold";
            tdTgl.innerText = `${row.tgl}/${row.bln}/${row.thn}`;
            tr.appendChild(tdTgl);

            // 3. Plat Nomor
            let tdNopol = document.createElement('td');
            tdNopol.className = "p-2 text-slate-900 font-black tracking-wide uppercase";
            tdNopol.innerText = row.nopol || '-';
            tr.appendChild(tdNopol);

            // 4. Nama Pelanggan
            let tdNama = document.createElement('td');
            tdNama.className = "p-2 text-left text-slate-800 truncate font-bold pl-4";
            tdNama.innerText = row.nama || '-';
            tr.appendChild(tdNama);

            // 5. Metode Bayar
            let tdMetode = document.createElement('td');
            tdMetode.className = "p-2 text-center text-blue-600 font-black uppercase";
            tdMetode.innerText = (row.metode === "TUNAI" || row.metode === "CASH") ? "CASH" : row.metode;
            tr.appendChild(tdMetode);

            // 6. Nominal Rupiah
            let tdNominal = document.createElement('td');
            tdNominal.className = "p-2 text-right text-slate-900 font-black pr-4";
            tdNominal.innerText = formatRupiah(row.nominal);
            tr.appendChild(tdNominal);
            tbody.appendChild(tr);
        });
        updateGrafikDanStatistik(dataToRender);
    }
    function onFilterBulanTahunLaporanChange() {
        const blnFilter = document.getElementById('filter-bulan') ? document.getElementById('filter-bulan').value : "ALL";
        const thnFilter = document.getElementById('filter-tahun') ? document.getElementById('filter-tahun').value : "ALL";
        const hasilPenyaringanLaporan = arrayDatabaseKeuangan.filter(item => {
            const matchBulan = (blnFilter === "ALL") || (item.bln === blnFilter);
            const matchTahun = (thnFilter === "ALL") || (item.thn === thnFilter);
            return matchBulan && matchTahun;
        });
        renderTabelLaporanKeuangan(hasilPenyaringanLaporan);
    }
    document.addEventListener("DOMContentLoaded", () => {
        const tahunDuniaNyata = new Date().getFullYear();
        const liveTahunEl = document.getElementById('live-tahun-dunia');
        if (liveTahunEl) liveTahunEl.innerText = tahunDuniaNyata;
        onFilterBulanTahunLaporanChange();
    });
</script>

@endsection
