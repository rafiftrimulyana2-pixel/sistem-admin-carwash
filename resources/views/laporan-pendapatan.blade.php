@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght text-slate-700;400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    body {
        font-family: 'Inter', sans-serif;
    }
    /* Custom scrollbar tipis untuk area scroll internal (Tabel & Panel) */
    .report-scroll-clean::-webkit-scrollbar {
        width: 5px !important;
        height: 5px !important;
    }
    .report-scroll-clean::-webkit-scrollbar-track {
        background: #f1f5f9 !important;
    }
    .report-scroll-clean::-webkit-scrollbar-thumb {
        background: #c7d2fe !important; /* Warna ungu indigo lembut */
        border-radius: 10px !important;
        
    }
</style>

<div class="w-full h-[calc(100vh-2px)] bg-[#f8fafc] flex flex-col overflow-hidden select-none antialiased text-slate-700">

    <div class="w-full bg-gradient-to-r from-[#1e40af] via-[#4338ca] to-[#5b21b6] px-6 py-3.5 flex justify-between items-center flex-shrink-0 shadow-md">
        <div>
            <h1 class="text-white text-sm font-extrabold uppercase tracking-tight">LAPORAN KEUANGAN & PENDAPATAN</h1>
            <p class="text-indigo-200 text-[9px] font-bold uppercase tracking-wider mt-0.5">Analisis Grafik Omset, Aliran Kas Masuk, & Rekapitulasi Pembayaran Pelanggan Terkonfirmasi</p>
        </div>
        <div class="bg-white/10 border border-white/20 px-3 py-1.5 rounded-xl text-white text-[10px] font-bold uppercase tracking-wide">
            Periode Aktif Keuangan: <span id="live-tahun-dunia" class="text-amber-300 font-black">----</span>
        </div>
    </div>

    <div class="w-full flex-1 flex flex-col p-4 gap-3.5 overflow-hidden">

        <div class="w-full bg-white border border-slate-200 rounded-xl p-3 shadow-sm flex flex-col sm:flex-row gap-4 justify-between items-center flex-shrink-0">
            <div class="flex items-center gap-2">
                <div class="h-2 w-2 rounded-full bg-blue-600 animate-pulse"></div>
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Sistem Penyelarasan Omset Pemilik Perusahaan</span>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1.5">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Bulan:</span>
                    <select id="filter-bulan" onchange="onFilterBulanTahunLaporanChange()" class="bg-slate-50 border border-slate-200 text-slate-800 text-[9px] font-bold p-2 rounded-lg focus:outline-none cursor-pointer shadow-inner">
                        <option value="ALL">Semua Bulan</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                    </select>
                </div>

                <div class="flex items-center gap-1.5">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Tahun:</span>
                    <select id="filter-tahun" onchange="onFilterBulanTahunLaporanChange()" class="bg-slate-50 border border-slate-200 text-slate-800 text-[9px] font-bold p-2 rounded-lg focus:outline-none cursor-pointer shadow-inner">
                        <option value="ALL">Semua Tahun</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="w-full flex-1 flex gap-4 overflow-hidden">

            <div class="w-[40%] h-full flex flex-col gap-3.5 overflow-y-auto report-scroll-clean flex-shrink-0">

                <div class="bg-gradient-to-br from-[#1e40af] to-[#4338ca] text-white rounded-xl p-4 shadow-md border border-blue-800 flex justify-between items-center flex-shrink-0">
                    <div>
                        <span class="block text-[9px] font-bold text-blue-200 uppercase tracking-wider">Total Omset Pemilik Perusahaan</span>
                        <span id="stat-total-omset" class="block text-xl font-black tracking-tight mt-1">Rp 0</span>
                        <span class="block text-[8px] text-emerald-300 font-bold uppercase mt-1">✓ Sinkron Otomatis Dari Sistem Kasir</span>
                    </div>
                    <div class="text-2xl">💰</div>
                </div>

                <div class="grid grid-cols-2 gap-3 flex-shrink-0">
                    <div class="bg-white border border-slate-200 rounded-xl p-3 shadow-sm flex flex-col gap-1">
                        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-wider">Metode Tunai (Cash)</span>
                        <span id="stat-total-tunai" class="text-xs font-black text-slate-900">Rp 0</span>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-xl p-3 shadow-sm flex flex-col gap-1">
                        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-wider">Non-Tunai (Bank/QRIS)</span>
                        <span id="stat-total-nontunai" class="text-xs font-black text-slate-900">Rp 0</span>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex-1 flex flex-col gap-3 min-h-[200px]">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Grafik Distribusi Paket Kebanggaan</span>

                    <div class="flex-1 flex items-end justify-around gap-4 pt-4 border-b border-slate-200 px-2">
                        <div class="flex flex-col items-center gap-1.5 w-1/3">
                            <div id="bar-reguler" class="w-full bg-blue-600 rounded-t-md transition-all duration-500 shadow-sm" style="height: 0%"></div>
                            <span class="text-[8px] font-bold text-slate-500 uppercase tracking-tight">Reguler</span>
                        </div>
                        <div class="flex flex-col items-center gap-1.5 w-1/3">
                            <div id="bar-premium" class="w-full bg-purple-600 rounded-t-md transition-all duration-500 shadow-sm" style="height: 0%"></div>
                            <span class="text-[8px] font-bold text-slate-500 uppercase tracking-tight">Premium</span>
                        </div>
                        <div class="flex flex-col items-center gap-1.5 w-1/3">
                            <div id="bar-coating" class="w-full bg-amber-500 rounded-t-md transition-all duration-500 shadow-sm" style="height: 0%"></div>
                            <span class="text-[8px] font-bold text-slate-500 uppercase tracking-tight">Coating</span>
                        </div>
                    </div>

            </div>
        </div>

            <div class="w-[60%] h-full bg-white border border-slate-200 rounded-xl shadow-sm overflow-auto report-scroll-clean">

                <table class="w-full border-collapse text-left table-fixed min-w-[800px]">
                    <thead class="sticky top-0 z-10 bg-[#1e40af] border-b border-blue-900 shadow-sm text-white text-[9px] font-black uppercase tracking-wider">
                        <tr>
                            <th class="p-2.5 text-center w-[7%]">No</th>
                            <th class="p-2.5 w-[20%]">Tanggal</th>
                            <th class="p-2.5 w-[23%]">Nomor Polisi</th>
                            <th class="p-2.5 w-[25%]">Nama Customer / Owner</th>
                            <th class="p-2.5 w-[25%]">Metode Bayar</th>
                            <th class="p-2.5 text-right w-[20%]">Nominal Bersih</th>
                        </tr>
                    </thead>

                    <tbody id="tabel-laporan-body" class="divide-y divide-slate-100 text-[10px] font-bold text-slate-800">

                        </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


<script>
    // 📝 DATABASE FINANCE ARSIP: Data tersimpan aman, hanya dipanggil jika lolos seleksi filter
    const arrayDatabaseKeuangan = [
        { tgl: "22", bln: "05", thn: "2026", nopol: "B 1111 AAA", nama: "Doni Perdana Kusuma Atmaja", metode: "TUNAI", nominal: 216450, kategori: "premium" },
        { tgl: "22", bln: "05", thn: "2026", nopol: "B 8888 BOSS", nama: "Kevin Sanjaya", metode: "QRIS", nominal: 505050, kategori: "coating" },
        { tgl: "23", bln: "05", thn: "2026", nopol: "B 2026 RFV", nama: "Hendra Wijaya Sukses", metode: "TUNAI", nominal: 55500, kategori: "reguler" },
        { tgl: "24", bln: "05", thn: "2026", nopol: "D 1411 XYZ", nama: "Ibu Rina Mariana", metode: "TRANSFER", nominal: 160950, kategori: "premium" }
    ];

    function formatRupiah(angka) {
        return "Rp " + angka.toLocaleString('id-ID');
    }

    // 🔥 LOGIKA UTAMA HITUNG OMSET & DINAMIKA GRAFIK BAR (BISA MENJADI 0 BERSIH)
    function updateGrafikDanStatistik(dataTerfilter) {
        let totalOmset = 0;
        let totalTunai = 0;
        let totalNonTunai = 0;

        let countReguler = 0;
        let countPremium = 0;
        let countCoating = 0;

        dataTerfilter.forEach(row => {
            totalOmset += row.nominal;
            if (row.metode === "TUNAI") {
                totalTunai += row.nominal;
            } else {
                totalNonTunai += row.nominal;
            }

            if (row.kategori === "reguler") countReguler++;
            if (row.kategori === "premium") countPremium++;
            if (row.kategori === "coating") countCoating++;
        });

        // Terapkan angka nominal rupiah ke 3 kotak keuangan
        document.getElementById('stat-total-omset').innerText = formatRupiah(totalOmset);
        document.getElementById('stat-total-tunai').innerText = formatRupiah(totalTunai);
        document.getElementById('stat-total-nontunai').innerText = formatRupiah(totalNonTunai);

        // Hitung Tinggi Persentase Grafik Secara Akurat
        let maxCount = Math.max(countReguler, countPremium, countCoating, 1);

        // Atur tinggi Bar secara visual instan
        document.getElementById('bar-reguler').style.height = dataTerfilter.length > 0 ? ((countReguler / maxCount) * 100) + "%" : "0%";
        document.getElementById('bar-premium').style.height = dataTerfilter.length > 0 ? ((countPremium / maxCount) * 100) + "%" : "0%";
        document.getElementById('bar-coating').style.height = dataTerfilter.length > 0 ? ((countCoating / maxCount) * 100) + "%" : "0%";
    }

    // FUNCTION RENDER BARIS DATA TABEL
    function renderTabelLaporanKeuangan(dataToRender) {
        const tbody = document.getElementById('tabel-laporan-body');
        tbody.innerHTML = "";

        // Kondisi Awal Pembuatan: Jika data kosong total rilis web, berikan status 0 murni
        if (dataToRender.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="p-8 text-center text-slate-400 font-medium italic">
                        👋 Belum ada aliran data pendapatan terkonfirmasi pada periode ini, Chief.
                    </td>
                </tr>
            `;
            updateGrafikDanStatistik([]); // Paksa semua grafik & nominal atas rontok menjadi 0
            return;
        }

        dataToRender.forEach((row, index) => {
            let tr = document.createElement('tr');
            tr.className = "bg-white border-b border-slate-100 hover:bg-slate-50 transition-all h-[45px]";

            // 1. Nomor
            let tdNo = document.createElement('td');
            tdNo.className = "p-2.5 text-center text-slate-400 font-medium";
            tdNo.innerText = index + 1;
            tr.appendChild(tdNo);

            // 2. Tanggal Lengkap
            let tdTgl = document.createElement('td');
            tdTgl.className = "p-2.5 text-slate-500 font-medium";
            tdTgl.innerText = `${row.tgl}/${row.bln}/${row.thn}`;
            tr.appendChild(tdTgl);

            // 3. Nomor Polisi (Inter-Bold)
            let tdNopol = document.createElement('td');
            tdNopol.className = "p-2.5 font-extrabold text-slate-900 uppercase tracking-wide";
            tdNopol.innerText = row.nopol;
            tr.appendChild(tdNopol);

            // 4. Nama Customer / Owner (Anti-Himpit, rapi bungkus bawah)
            let tdNama = document.createElement('td');
            tdNama.className = "p-2.5 text-slate-700 whitespace-normal break-words leading-tight";
            tdNama.innerText = row.nama;
            tr.appendChild(tdNama);

            // 5. Metode Pembayaran Badge
            let tdMetode = document.createElement('td');
            tdMetode.className = "p-2.5";
            if (row.metode === "TUNAI") {
                tdMetode.innerHTML = `<span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-[8px] font-black px-1.5 py-0.5 rounded-md uppercase">💵 CASH</span>`;
            } else {
                tdMetode.innerHTML = `<span class="bg-blue-50 text-blue-700 border border-blue-200 text-[8px] font-black px-1.5 py-0.5 rounded-md uppercase">💳 ${row.metode}</span>`;
            }
            tr.appendChild(tdMetode);

            // 6. Nominal Omset Bersih
            let tdNominal = document.createElement('td');
            tdNominal.className = "p-2.5 text-right font-black text-slate-900";
            tdNominal.innerText = formatRupiah(row.nominal);
            tr.appendChild(tdNominal);

            tbody.appendChild(tr);
        });

        updateGrafikDanStatistik(dataToRender);
    }

    // 🔥 CORE COMBINATION FILTER
    function onFilterBulanTahunLaporanChange() {
        const blnFilter = document.getElementById('filter-bulan').value;
        const thnFilter = document.getElementById('filter-tahun').value;

        const hasilPenyaringanLaporan = arrayDatabaseKeuangan.filter(item => {
            const matchBulan = (blnFilter === "ALL") || (item.bln === blnFilter);
            const matchTahun = (thnFilter === "ALL") || (item.thn === thnFilter);
            return matchBulan && matchTahun;
        });

        renderTabelLaporanKeuangan(hasilPenyaringanLaporan);
    }

    // 🚀 ACTION RUN STATE
    document.addEventListener("DOMContentLoaded", () => {
        // 1. Ambil Tahun Dunia Nyata secara Otomatis menggunakan Object Date JavaScript
        const tahunDuniaNyata = new Date().getFullYear(); // Hasil otomatis: 2026
        document.getElementById('live-tahun-dunia').innerText = tahunDuniaNyata;

        // 2. Jalankan filter awal kosong murni (Membuat tahun 2026/2027 bernilai 0 saat pertama dibuka)
        onFilterBulanTahunLaporanChange();
    });
</script>
@endsection
