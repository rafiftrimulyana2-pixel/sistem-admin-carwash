@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    /* Kita kunci font Inter secara merata agar area sidebar luar ikut rapi & serasi */
    * {
        font-family: 'Inter', sans-serif;
    }

    /* Pembungkus riwayat kamu dipersempit skopnya agar HANYA menebalkan isi konten tengah saja, tidak meluber merusak sidebar */
    .riwayat-scope, .riwayat-scope :not(nav, aside, .sidebar, [class*="sidebar"]) {
        font-weight: 700 !important;
    }

    /* Custom scrollbar internal tipis dan sangat bersih bawaan asli kamu tetap utuh 100% */
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

<div class="riwayat-scope w-full h-[calc(100vh-2px)] bg-[#f4f7fb] flex flex-col overflow-hidden select-none antialiased text-slate-700">
    <div class="w-full bg-blue-600 border-b border-blue-700 px-6 py-3.5 flex justify-between items-center flex-shrink-0 shadow-md shadow-slate-900/10 z-20">
        <div>
            <h1 class="text-white text-sm font-black uppercase tracking-tight">DATA ARSIP RIWAYAT SERVIS CARWASH</h1>
            <p class="text-blue-100 text-[9px] font-bold uppercase tracking-wider mt-0.5">Manajemen Track Record Pemesanan, Status Kerja, &amp; Arsip Transaksi Selesai</p>
        </div>
        <div class="bg-white/10 border border-white/20 px-3 py-1.5 rounded-xl text-white text-[10px] font-black uppercase tracking-wide">
            Data Ditemukan: <span id="live-counter-data" class="text-amber-300 font-black">0 Data</span>
        </div>
    </div>

    <div class="w-full flex-1 flex flex-col p-4 gap-3.5 overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3.5 flex-shrink-0">
            <div class="bg-white rounded-xl p-4 flex justify-between items-center shadow-md shadow-slate-400/10">
                <div>
                    <span class="block text-[9px] font-black text-slate-400 uppercase tracking-wider">Total Pendapatan</span>
                    <span id="card-total-rupiah" class="block text-base font-black text-slate-800 tracking-tight mt-1">Rp 0</span>
                </div>
                <div class="bg-blue-600 p-2.5 rounded-xl text-white flex items-center justify-center flex-shrink-0 filter drop-shadow-[0_4px_6px_rgba(37,99,235,0.4)]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-xl p-4 flex justify-between items-center shadow-md shadow-slate-400/10">
                <div>
                    <span class="block text-[9px] font-black text-slate-400 uppercase tracking-wider">Mobil Terarsip</span>
                    <span id="card-qty-selesai" class="block text-base font-black text-slate-800 tracking-tight mt-1">0 Kendaraan</span>
                </div>
                <div class="bg-emerald-600 p-2.5 rounded-xl text-white flex items-center justify-center flex-shrink-0 filter drop-shadow-[0_4px_6px_rgba(16,185,129,0.4)]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-xl p-4 flex justify-between items-center shadow-md shadow-slate-400/10">
                <div>
                    <span class="block text-[9px] font-black text-slate-400 uppercase tracking-wider">Metode Tunai / Cash</span>
                    <span id="card-qty-approved" class="block text-base font-black text-slate-800 tracking-tight mt-1">0 Transaksi</span>
                </div>
                <div class="bg-amber-500 p-2.5 rounded-xl text-white flex items-center justify-center flex-shrink-0 filter drop-shadow-[0_4px_6px_rgba(245,158,11,0.4)]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-xl p-4 flex justify-between items-center shadow-md shadow-slate-400/10">
                <div>
                    <span class="block text-[9px] font-black text-slate-400 uppercase tracking-wider">Rata-rata / Nota</span>
                    <span id="card-total-average" class="block text-base font-black text-slate-800 tracking-tight mt-1">Rp 0</span>
                </div>
                <div class="bg-purple-600 p-2.5 rounded-xl text-white flex items-center justify-center flex-shrink-0 filter drop-shadow-[0_4px_6px_rgba(147,51,234,0.4)]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="w-full flex-1 bg-white rounded-xl flex flex-col overflow-hidden shadow-sm">
            <div class="w-full px-4 py-3 bg-white flex flex-col lg:flex-row justify-between items-center gap-4 flex-shrink-0">
                <div class="relative w-full sm:w-72">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </span>
                    <input type="text" id="search-input" oninput="onFilterRiwayatEngineChange()" placeholder="Cari nomor polisi atau nama customer..." class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-[10px] pl-9 pr-3 py-2 rounded-xl focus:outline-none focus:border-blue-500 shadow-inner placeholder:text-slate-400/80">
                </div>

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

            <div class="flex-1 overflow-y-auto report-scroll-clean bg-white">
                <table class="w-full border-collapse text-left table-fixed border-hidden">
                    <thead class="sticky top-0 z-10 bg-blue-600 text-white text-[8.5px] font-black uppercase tracking-wider shadow-sm">
                                <tr>
                                    <th class="p-3 text-center w-[5%]">No.</th>
                                    <th class="p-3 text-center w-[15%]">Nomor Polisi</th>
                                    <th class="p-3 text-center w-[22%]">Nama Customer</th>
                                    <th class="p-3 text-center w-[20%]">Tipe / Model Mobil</th>
                                    <th class="p-3 text-center w-[18%]">Paket &amp; Detail Kerja</th>
                                    <th class="p-3 text-center w-[10%]">Total Biaya</th>
                                    <th class="p-3 text-center w-[10%]">Status Nota</th>
                                </tr>
                            </thead>
                        <tbody id="tabel-riwayat-body" class="divide-y divide-slate-100 text-[8.5px] text-slate-700">
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
    // PERBAIKAN SINKRONISASI: Membaca array finance rilis Laravel hasil parsing controller kasir kamu
    const arrayDatabaseKeuangan = @json($dataFinance ?? []) || [];

    function formatRupiah(angka) {
        if (angka === null || angka === undefined || isNaN(angka)) angka = 0;
        return "Rp " + Number(angka).toLocaleString('id-ID');
    }

    function initTanggalDropdown() {
        const selectTgl = document.getElementById('filter-tanggal');
        if(!selectTgl) return;
        for (let i = 1; i <= 31; i++) {
            let val = i < 10 ? "0" + i : "" + i;
            let opt = document.createElement('option');
            opt.value = val; opt.innerText = val;
            selectTgl.appendChild(opt);
        }
    }

    function resetCardStatistikKeNol() {
        document.getElementById('live-counter-data').innerText = "0 Data";
        document.getElementById('card-total-rupiah').innerText = "Rp 0";
        document.getElementById('card-qty-selesai').innerText = "0 Kendaraan";
        document.getElementById('card-qty-approved').innerText = "0 Transaksi";
        document.getElementById('card-total-average').innerText = "Rp 0";
    }

    function updateCardStatistikRealtime(dataTerfilter) {
    let totalServis = dataTerfilter.length;
    let totalRupiah = 0;
    let qtyTunai = 0;

    dataTerfilter.forEach(row => {
        // Bersihkan data nominal agar selalu menjadi angka murni
        let rawNominal = row.nominal;
        let nominalValue = 0;

        if (typeof rawNominal === 'string') {
            // Menghapus semua karakter selain angka
            nominalValue = parseFloat(rawNominal.replace(/[^0-9]/g, '')) || 0;
        } else {
            nominalValue = parseFloat(rawNominal) || 0;
        }

        totalRupiah += nominalValue;

        // Cek metode pembayaran
        let mtd = row.metode ? row.metode.toUpperCase() : "TUNAI";
        if (mtd === 'TUNAI' || mtd === 'CASH') {
            qtyTunai++;
        }
    });

    console.log("Total Terhitung:", totalRupiah);

    // Update elemen HTML
    document.getElementById('card-total-rupiah').innerText = formatRupiah(totalRupiah);
    document.getElementById('live-counter-data').innerText = totalServis + " Data";
    document.getElementById('card-qty-selesai').innerText = totalServis + " Kendaraan";
    document.getElementById('card-qty-approved').innerText = qtyTunai + " Transaksi";

    let rataRata = totalServis > 0 ? (totalRupiah / totalServis) : 0;
    document.getElementById('card-total-average').innerText = formatRupiah(rataRata);
    }

    function renderTabelRiwayatServis(dataToRender) {
        const tbody = document.getElementById('tabel-riwayat-body');
        if (!dataToRender || dataToRender.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="p-8 text-center text-slate-400 font-medium italic text-[8.5px]">
                        👋 Belum ada arsip log riwayat servis terkonfirmasi dari sistem kasir/admin.
                    </td>
                </tr>
            `;
            resetCardStatistikKeNol(); return;
        }

        dataToRender.forEach((row, index) => {
            let tr = document.createElement('tr');
            tr.className = "hover:bg-slate-50/70 transition-colors duration-150 h-[44px]";

            // 1. Nomor urut
            let tdNo = document.createElement('td');
            tdNo.className = "p-2 text-center text-slate-400 font-medium";
            tdNo.innerText = index + 1;
            tr.appendChild(tdNo);

            // 2. Plat nomor kendaraan
            let tdNopol = document.createElement('td');
            tdNopol.className = "p-2 text-center text-slate-900 font-black tracking-wide uppercase";
            tdNopol.innerText = row.nopol;
            tr.appendChild(tdNopol);

            // 3. Nama Pemilik
            let tdNama = document.createElement('td');
            tdNama.className = "p-2 text-center text-slate-800 truncate font-bold";
            tdNama.innerText = row.nama;
            tr.appendChild(tdNama);

            // 4. PERBAIKAN FATAL: Memanggil jenis paket mobil kiriman controller secara lurus tanpa bias
            let tdJenis = document.createElement('td');
            tdJenis.className = "p-2 text-center text-slate-600 uppercase truncate font-semibold";
            tdJenis.innerText = row.kategori || "REGULER WASH";
            tr.appendChild(tdJenis);

            // 5. Metode Bayar
            let tdPaket = document.createElement('td');
            tdPaket.className = "p-2 text-center flex flex-col justify-center h-[44px]";
            tdPaket.innerHTML = `
                <span class="text-blue-600 font-black uppercase text-[8px] tracking-wide leading-none">${row.metode || 'TUNAI'}</span>
                <span class="text-slate-400 font-medium text-[7px] mt-0.5 leading-none">Paid Verified</span>
            `;
            tr.appendChild(tdPaket);

            // 6. Subtotal Nominal Pembayaran
            let tdNominal = document.createElement('td');
            tdNominal.className = "p-2 text-right text-slate-900 font-black pr-6";
            tdNominal.innerText = formatRupiah(row.nominal);
            tr.appendChild(tdNominal);

            // 7. Status Nota Lunas Modern
            let tdStatus = document.createElement('td');
            tdStatus.className = "p-2 text-center";
            tdStatus.innerHTML = `
                <div class="flex justify-center">
                    <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded text-[7.5px] font-black uppercase tracking-wider whitespace-nowrap">
                        LUNAS
                    </span>
                </div>
            `;
            tr.appendChild(tdStatus);

            tbody.appendChild(tr);
        });

        updateCardStatistikRealtime(dataToRender);
    }

    function onFilterRiwayatEngineChange() {
        const tglFilter = document.getElementById('filter-tanggal').value;
        const blnFilter = document.getElementById('filter-bulan').value;
        const thnFilter = document.getElementById('filter-tahun').value;
        const searchVal = document.getElementById('search-input').value.toLowerCase().trim();

        const hasilPenyaringanRiwayat = arrayDatabaseKeuangan.filter(item => {
            const matchTanggal = (tglFilter === "ALL") || (item.tgl === tglFilter);
            const matchBulan = (blnFilter === "ALL") || (item.bln === blnFilter);
            const matchTahun = (thnFilter === "ALL") || (item.thn === thnFilter);

            const matchSearch = (searchVal === "") ||
                                (item.nama && item.nama.toLowerCase().includes(searchVal)) ||
                                (item.nopol && item.nopol.toLowerCase().includes(searchVal));

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
