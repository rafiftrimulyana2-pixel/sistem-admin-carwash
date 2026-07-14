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
                <p class="text-blue-100 text-[9px] font-bold uppercase tracking-wider mt-0.5">Analisis Grafik Omset, Aliran Kas Masuk, &amp; Rekapitulasi Pembayaran Pelanggan Terkonfirmasi</p></div>
                <div class="bg-white/10 border border-white/20 px-3 py-1.5 rounded-xl text-white text-[10px] font-bold uppercase tracking-wide">
            Periode Utama: <span id="live-tahun-dunia" class="text-amber-300 font-black">2026</span>
        </div>
    </div>

    <div class="w-full flex-1 flex flex-col p-4 gap-3.5 overflow-hidden">
        <div class="w-full bg-white border border-slate-200 rounded-xl p-3 shadow-sm flex flex-col lg:flex-row gap-4 justify-between items-center flex-shrink-0">
            <div class="flex items-center gap-2">
                <div class="h-2 w-2 rounded-full bg-blue-600 animate-pulse"></div>
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Sistem Rekapitulasi Kas Perusahaan</span>
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

                <!-- 1. Fitur-fitur -->
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

                <!-- TOMBOL INPUT PENGELUARAN DITAMBAHKAN DI SINI -->
                <button onclick="bukaModalPengeluaran()" class="bg-rose-600 hover:bg-rose-700 text-white px-3 py-1.5 rounded-lg text-[9px] font-black uppercase shadow-md transition-all">
                    + Input Pengeluaran
                </button>
            </div>
        </div>

        <!-- 2. BARIS STATISTIK (Grid 2 Kolom) -->
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-blue-600 text-white rounded-2xl p-6 flex justify-between items-center shadow-lg shadow-blue-200">
                <div>
                    <span class="block text-[10px] font-black text-blue-100 uppercase tracking-[0.12em]">Total Pendapatan</span>
                    <span id="stat-total-omset" class="block text-2xl font-black mt-1">Rp 0</span>
                </div>

                <div class="bg-white p-2 rounded-xl text-blue-600 shadow-md flex items-center justify-center flex-shrink-0 ml-4 border border-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7">
                    <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/>
                </svg>
            </div>
        </div>

        <div class="bg-rose-600 text-white rounded-2xl p-6 flex justify-between items-center shadow-lg shadow-rose-600/20">
            <div>
                <span class="block text-[10px] font-black text-rose-100 uppercase tracking-[0.12em]">Total Pengeluaran</span>
                <span id="stat-laba-bersih" class="block text-2xl font-black mt-1">Rp 0</span>
            </div>
                <div class="bg-white p-2 rounded-xl text-rose-600 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <polyline points="19 12 12 19 5 12"></polyline>
                    </svg>
                </div>
            </div>
        </div>

        <div class="w-full h-full bg-white border border-slate-200 rounded-xl shadow-sm flex flex-col overflow-hidden">

            <!-- BARU: HEADER FILTER, PENCARIAN, DAN EXPORT -->
            <div class="p-4 border-b border-slate-100 bg-white flex items-center justify-between gap-4">

                <!-- Pencarian -->
                <div class="relative w-full max-w-xs">
                    <input type="text" id="search-input" oninput="onFilterBulanTahunLaporanChange()"
                        placeholder="Cari customer atau nopol..."
                        class="w-full bg-slate-50 text-[9px] font-bold p-2.5 pl-8 rounded-lg border border-slate-200 focus:outline-none">
                    <svg class="w-3 h-3 absolute left-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>

                <!-- Tombol Export -->
                <button onclick="exportToPDF()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-[9px] font-black uppercase shadow-md transition-all">
                    Export PDF
                </button>
            </div>

            <div class="flex-1 overflow-y-auto report-scroll-clean">
                <table id="tabel-laporan-utama" class="w-full border-collapse text-left table-fixed">
                    <thead class="sticky top-0 z-10 bg-blue-600 border-b border-blue-700 shadow-sm text-white text-[8.5px] font-black uppercase tracking-wider">
                            <tr>
                                <th class="p-3 text-center w-[6%]">No.</th>
                                <th class="p-3 w-[15%]">Tanggal</th>
                                <th class="p-3 w-[18%]">Nomor Plate</th>
                                <th class="p-3 text-center w-[25%]">Nama Customer</th>
                                <th class="p-3 text-center w-[15%]">Metode</th>
                                <th class="p-3 text-right w-[15%]">Nominal</th>
                                <th class="p-3 text-center w-[10%]">Status</th> </tr>
                            </thead>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Pengeluaran (Pop-up) -->
        <div id="modal-pengeluaran" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-2xl w-96 shadow-2xl">
                <h3 class="text-sm font-black uppercase mb-4">Input Pengeluaran Baru</h3>
                    <input type="number" id="input-nominal" placeholder="Jumlah Nominal (Rp)" class="w-full p-2 mb-3 border rounded-lg text-sm">
                    <input type="text" id="input-keterangan" placeholder="Keterangan Pengeluaran..." class="w-full p-2 mb-4 border rounded-lg text-sm">
                <div class="flex gap-2 justify-end">
                    <button onclick="tutupModalPengeluaran()" class="px-4 py-2 bg-slate-200 rounded-lg text-xs font-bold">Batal</button>
                    <button onclick="simpanPengeluaran()" class="px-4 py-2 bg-rose-600 text-white rounded-lg text-xs font-bold">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Library PDF di atas script utama -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

<script>

    // Membaca database transaksi riel Laravel terikat dari controller kasir kamu
    const dataFinance = @json($dataFinance ?? []);
    const dataExpenses = @json($dataExpenses ?? []);
    let   arrayDatabaseKeuangan = dataFinance.concat(dataExpenses);

    function bukaModalPengeluaran() { document.getElementById('modal-pengeluaran').classList.remove('hidden'); }
    function tutupModalPengeluaran() { document.getElementById('modal-pengeluaran').classList.add('hidden'); }

    function formatRupiah(angka) {
        if (angka === null || angka === undefined || isNaN(angka)) angka = 0;
        return "Rp " + Number(angka).toLocaleString('id-ID');
    }

    function simpanPengeluaran() {

        // 1. Ambil data dari input modal (pastikan ID input di HTML Anda sesuai)
        let nominal = parseFloat(document.getElementById('input-nominal').value) || 0;
        let keterangan = document.getElementById('input-keterangan').value;

        // 2. Tambahkan data ke array utama
        arrayDatabaseKeuangan.push({
            tgl: new Date().getDate().toString().padStart(2, '0'),
            bln: (new Date().getMonth() + 1).toString().padStart(2, '0'),
            thn: new Date().getFullYear().toString(),
            nopol: "-",
            nama: keterangan,
            metode: "TUNAI",
            nominal: nominal,
            type: 'OUT' // Ini kunci utama agar laba bersih berkurang
        });

        // 3. Refresh tabel dan statistik
        onFilterBulanTahunLaporanChange();
        tutupModalPengeluaran();
        document.getElementById('input-nominal').value = '';
        document.getElementById('input-keterangan').value = '';
    }

    function updateGrafikDanStatistik(dataTerfilter) {
        let totalOmset = 0;   // Uang Masuk
        let totalKeluar = 0;  // Uang Keluar
        let totalCash = 0;
        let totalQris = 0;
        let totalTransfer = 0;

            dataTerfilter.forEach(row => {
            let nominalValue = row.nominal ? Number(row.nominal) : 0;

            // Logika pemisahan IN dan OUT
            if (row.type === 'IN') {
                totalOmset += nominalValue;
                let mtd = row.metode ? row.metode.toUpperCase() : "TUNAI";
            if (mtd === "TUNAI" || mtd === "CASH") totalCash += nominalValue;
                else if (mtd === "QRIS") totalQris += nominalValue;
                else if (mtd === "TRANSFER" || mtd === "BANK") totalTransfer += nominalValue;
            } else {
                totalKeluar += nominalValue;
            }
        });

        // Hitung Laba Bersih
        let labaBersih = totalOmset - totalKeluar;

        document.getElementById('stat-total-omset').innerText = formatRupiah(totalOmset);
        document.getElementById('stat-laba-bersih').innerText = formatRupiah(labaBersih);

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
            tr.className = (row.type === 'OUT' ? "bg-rose-50/30" : "hover:bg-slate-50/60") + " transition-colors duration-150 h-[36px]";

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
            tdNama.className = "p-2 text-center text-slate-800 font-bold pl-4";
            tdNama.innerText = row.nama || '-';
            tr.appendChild(tdNama);

            // 5. Metode Bayar
            let tdMetode = document.createElement('td');
            tdMetode.className = "p-2 text-center text-blue-600 font-black uppercase";
            tdMetode.innerText = (row.metode === "TUNAI" || row.metode === "CASH") ? "CASH" : row.metode;
            tr.appendChild(tdMetode);

            // 6. Nominal Rupiah
            let tdNominal = document.createElement('td');
            tdNominal.className = "p-2 text-right font-black pr-4 " + (row.type === 'OUT' ? "text-rose-600" : "text-slate-900");
            tdNominal.innerText = (row.type === 'OUT' ? "- " : "") + formatRupiah(row.nominal);
            tr.appendChild(tdNominal);

            // 7. Status Progres
            let tdStatus = document.createElement('td');
            tdStatus.className = "p-2 text-center";
            if (row.type === 'OUT') {
                // Jika pengeluaran, statusnya bisa dikosongkan atau diberi label "KELUAR"
                tdStatus.innerHTML = `<span class="px-2 py-0.5 bg-rose-100 text-rose-700 rounded text-[7px] font-black uppercase">KELUAR</span>`;
            } else {
                // Jika pendapatan, tetap LUNAS
                tdStatus.innerHTML = `<span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded text-[7px] font-black uppercase">LUNAS</span>`;
            }
            tr.appendChild(tdStatus);

            tbody.appendChild(tr);
        });

        updateGrafikDanStatistik(dataToRender);
    }

    function onFilterBulanTahunLaporanChange() {
        const searchVal = document.getElementById('search-input').value.toLowerCase();
        const bln = document.getElementById('filter-bulan').value;
        const thn = document.getElementById('filter-tahun').value;

        const hasilPenyaringan = arrayDatabaseKeuangan.filter(item => {
            const matchBulan = (bln === "ALL" || item.bln === bln);
            const matchTahun = (thn === "ALL" || item.thn === thn);
            const matchSearch = (searchVal === "" ||
                                (item.nama && item.nama.toLowerCase().includes(searchVal)) ||
                                (item.nopol && item.nopol.toLowerCase().includes(searchVal)));
            return matchBulan && matchTahun && matchSearch;
        });

        renderTabelLaporanKeuangan(hasilPenyaringan);
    }

    function exportToPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

    // Ambil data yang sedang tampil di tabel
    const bulan = document.getElementById("filter-bulan").options[document.getElementById("filter-bulan").selectedIndex].text;
    const tahun = document.getElementById("filter-tahun").value;

    doc.text("Laporan Keuangan " + bulan + " " + tahun, 14, 15);

    // AutoTable menarik data langsung dari tabel HTML
    doc.autoTable({
        html: '#tabel-laporan-utama',
        startY: 25,
        theme: 'striped',
        styles: { fontSize: 8 }
    });

    doc.save('Laporan_Keuangan_' + bulan + '_' + tahun + '.pdf');
    }

    document.addEventListener("DOMContentLoaded", () => {
        const tahunDuniaNyata = new Date().getFullYear();
        const liveTahunEl = document.getElementById('live-tahun-dunia');
        if (liveTahunEl) liveTahunEl.innerText = tahunDuniaNyata;
        onFilterBulanTahunLaporanChange();
    });

</script>
@endsection
