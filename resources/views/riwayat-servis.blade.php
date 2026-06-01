@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    body {
        font-family: 'Inter', sans-serif;
    }
    /* Menghilangkan scrollbar default browser pada area tabel internal, diganti garis tipis elegan */
    .table-scroll-clean::-webkit-scrollbar {
        width: 5px !important;
        height: 5px !important;
    }
    .table-scroll-clean::-webkit-scrollbar-track {
        background: #f1f5f9 !important;
    }
    .table-scroll-clean::-webkit-scrollbar-thumb {
        background: #c7d2fe !important; /* Warna ungu indigo lembut */
        border-radius: 10px !important;
    }
    .row-hover-effect {
        transition: all 0.12s ease;
    }
    .row-hover-effect:hover {
        background-color: #f1f5f9 !important;
    }
</style>

<div class="w-full h-[calc(100vh-2px)] bg-[#f8fafc] flex flex-col overflow-hidden select-none antialiased text-slate-700">

    <div class="w-full bg-gradient-to-r from-[#1e40af] via-[#4338ca] to-[#5b21b6] px-6 py-3.5 flex justify-between items-center flex-shrink-0 shadow-md">
        <div>
            <h1 class="text-white text-sm font-extrabold uppercase tracking-tight">DATA ARSIP RIWAYAT SERVIS CARWASH</h1>
            <p class="text-indigo-200 text-[9px] font-bold uppercase tracking-wider mt-0.5">Manajemen Track Record Pemesanan, Status Kerja, & Arsip Transaksi Selesai</p>
        </div>
        <div class="bg-white/10 border border-white/20 px-3 py-1.5 rounded-xl flex items-center gap-2">
            <span class="text-[9px] font-bold text-indigo-100 uppercase tracking-wider">Data Ditemukan:</span>
            <span id="total-records-badge" class="text-xs font-black text-white bg-indigo-600 px-2 py-0.5 rounded-md">0 Data</span>
        </div>
    </div>

    <div class="w-full flex-1 flex flex-col p-4 gap-3.5 overflow-hidden">

        <div class="grid grid-cols-4 gap-3.5 flex-shrink-0">
            <div class="bg-white border border-slate-200 rounded-xl p-3 shadow-sm flex items-center justify-between">
                <div>
                    <span class="block text-[8px] font-bold text-slate-400 uppercase tracking-wider">Total Pendapatan</span>
                    <span id="stat-pendapatan" class="block text-sm font-black text-slate-900 mt-0.5">Rp 0</span>
                </div>
                <div class="text-[9px] font-extrabold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">💰 INCOME</div>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-3 shadow-sm flex items-center justify-between">
                <div>
                    <span class="block text-[8px] font-bold text-slate-400 uppercase tracking-wider">Mobil Selesai</span>
                    <span id="stat-selesai" class="block text-sm font-black text-slate-900 mt-0.5">0 Kendaraan</span>
                </div>
                <div class="text-[9px] font-extrabold text-blue-600 bg-blue-50 px-2 py-1 rounded-md">✅ DONE</div>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-3 shadow-sm flex items-center justify-between">
                <div>
                    <span class="block text-[8px] font-bold text-slate-400 uppercase tracking-wider">Servis Disetujui</span>
                    <span id="stat-disetujui" class="block text-sm font-black text-slate-900 mt-0.5">0 Kendaraan</span>
                </div>
                <div class="text-[9px] font-extrabold text-amber-600 bg-amber-50 px-2 py-1 rounded-md">📦 APPROVED</div>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-3 shadow-sm flex items-center justify-between">
                <div>
                    <span class="block text-[8px] font-bold text-slate-400 uppercase tracking-wider">Rata-rata / Paket</span>
                    <span id="stat-rata" class="block text-sm font-black text-slate-900 mt-0.5">Rp 0</span>
                </div>
                <div class="text-[9px] font-extrabold text-purple-600 bg-purple-50 px-2 py-1 rounded-md">📊 AVERAGE</div>
            </div>
        </div>

        <div class="w-full bg-white border border-slate-200 rounded-xl p-3 shadow-sm flex flex-col sm:flex-row gap-4 justify-between items-center flex-shrink-0">

            <div class="flex items-center gap-2 w-full sm:w-1/4">
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider flex-shrink-0">Cari:</span>
                <input type="text" id="pencarian-live" onkeyup="jalankanFilterSistemKombinasi()" placeholder="Nopol atau Nama..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-lg p-2 text-xs font-bold text-slate-800 focus:outline-none focus:border-[#4338ca] focus:bg-white transition-all shadow-inner">
            </div>

            <div class="flex items-center gap-3 flex-wrap sm:flex-nowrap">

                <div class="flex items-center gap-1.5">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Tanggal:</span>
                    <select id="filter-tanggal" onchange="jalankanFilterSistemKombinasi()" class="bg-slate-50 border border-slate-200 text-slate-800 text-[9px] font-bold p-2 rounded-lg focus:outline-none cursor-pointer shadow-inner">
                        <option value="ALL">Semua Tanggal</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                    </select>
                </div>

                <div class="flex items-center gap-1.5">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Bulan:</span>
                    <select id="filter-bulan" onchange="jalankanFilterSistemKombinasi()" class="bg-slate-50 border border-slate-200 text-slate-800 text-[9px] font-bold p-2 rounded-lg focus:outline-none cursor-pointer shadow-inner">
                        <option value="ALL">Semua Bulan</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                    </select>
                </div>

                <div class="flex items-center gap-1.5">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Tahun:</span>
                    <select id="filter-tahun" onchange="jalankanFilterSistemKombinasi()" class="bg-slate-50 border border-slate-200 text-slate-800 text-[9px] font-bold p-2 rounded-lg focus:outline-none cursor-pointer shadow-inner">
                        <option value="ALL">Semua Tahun</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="w-full flex-1 bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden flex flex-col">
            <div class="w-full flex-1 overflow-y-auto table-scroll-clean">

                <table class="w-full border-collapse text-left table-fixed">
                    <thead class="sticky top-0 z-10 bg-[#1e40af] border-b border-blue-900 shadow-sm text-white text-[9px] font-black uppercase tracking-wider">
                        <tr>
                            <th class="p-3 text-center w-[5%]">No</th>
                            <th class="p-3 w-[15%]">Nomor Polisi</th>
                            <th class="p-3 w-[22%]">Nama Customer</th>
                            <th class="p-3 w-[20%]">Tipe / Model Mobil</th>
                            <th class="p-3 w-[23%]">Paket & Detail Kerja Selesai</th>
                            <th class="p-3 text-right w-[15%]">Total Biaya</th>
                            <th class="p-3 text-center w-[12%]">Status Kerja</th>
                        </tr>
                    </thead>

                    <tbody id="tabel-riwayat-body" class="divide-y divide-slate-100 text-[11px] font-bold text-slate-800">

                        </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
    // 📝 MASTER DATABASE ARSIP: Data Pelanggan Baru Yang Otomatis Muncul Jika Tanggal & Bulan Sesuai
    const arrayDatabaseRiwayat = [
        { tgl: "22", bln: "05", thn: "2026", nopol: "B 1111 AAA", nama: "Doni Perdana Kusuma Atmaja", mobil: "Toyota Avanza Veloz Luxury", paket: "PREMIUM WAX", addons: ["Engine Detailing"], total: 216450, proses_kerja: "SELESAI WAX" },
        { tgl: "22", bln: "05", thn: "2026", nopol: "B 8888 BOSS", nama: "Kevin Sanjaya", mobil: "Toyota Alphard G-Edition", paket: "ULTIMATE COATING", addons: ["Jamur Kaca Depan", "Fogging Interior"], total: 505050, proses_kerja: "SELESAI COATING" },
        { tgl: "23", bln: "05", thn: "2026", nopol: "B 2026 RFV", nama: "Hendra Wijaya Sukses", mobil: "Mitsubishi Fortuner VRZ TRD", paket: "REGULER WASH", addons: [], total: 55500, proses_kerja: "SELESAI CUCI" },
        { tgl: "24", bln: "05", thn: "2026", nopol: "D 1411 XYZ", nama: "Ibu Rina Mariana", mobil: "Honda Civic Turbo Dual-VTEC", paket: "PREMIUM WAX", addons: ["Ekstra Vacuum"], total: 160950, proses_kerja: "SELESAI WAX" }
    ];

    function formatRupiah(angka) {
        return "Rp " + angka.toLocaleString('id-ID');
    }

    // 🔥 ENGINE HITUNG STATISTIK OTOMATIS: Mengubah isi kotak menjadi 0 jika data kosong
    function kalkulasiKotakSainsRealtime(dataTerfilter) {
        let totalPendapatan = 0;
        let totalSelesai = dataTerfilter.length;
        let totalDisetujui = dataTerfilter.length; // Menghitung track record terkonfirmasi kasir

        dataTerfilter.forEach(row => {
            totalPendapatan += row.total;
        });

        let rataRata = totalSelesai > 0 ? Math.round(totalPendapatan / totalSelesai) : 0;

        // Render Angka ke Tampilan Grid Kotak Atas
        document.getElementById('stat-pendapatan').innerText = formatRupiah(totalPendapatan);
        document.getElementById('stat-selesai').innerText = totalSelesai + " Kendaraan";
        document.getElementById('stat-disetujui').innerText = totalDisetujui + " Kendaraan";
        document.getElementById('stat-rata').innerText = formatRupiah(rataRata);
    }

    function renderTabelRiwayat(dataToRender) {
        const tbody = document.getElementById('tabel-riwayat-body');
        tbody.innerHTML = "";

        // Update Badge Informasi Baris
        document.getElementById('total-records-badge').innerText = dataToRender.length + " Data";

        // Kondisi Pabrikasi Awal: Jika data 0, tampilkan layar kosong bersih seperti maumu!
        if (dataToRender.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="p-10 text-center text-slate-400 font-medium italic">
                        👋 Belum ada data riwayat servis terarsip pada periode tanggal ini, Chief.
                    </td>
                </tr>
            `;
            kalkulasiKotakSainsRealtime([]);
            return;
        }

        dataToRender.forEach((row, index) => {
            let tr = document.createElement('tr');
            tr.className = "row-hover-effect bg-white border-b border-slate-100 min-h-[50px]";

            // 1. Nomor
            let tdNo = document.createElement('td');
            tdNo.className = "p-3 text-center text-slate-400 font-medium";
            tdNo.innerText = index + 1;
            tr.appendChild(tdNo);

            // 2. Nomor Polisi
            let tdNopol = document.createElement('td');
            tdNopol.className = "p-3 font-extrabold text-slate-900 uppercase tracking-wide";
            tdNopol.innerText = row.nopol;
            tr.appendChild(tdNopol);

            // 3. Nama Customer (Anti-Himpit Kolom)
            let tdNama = document.createElement('td');
            tdNama.className = "p-3 text-slate-700 whitespace-normal break-words leading-tight";
            tdNama.innerText = row.nama;
            tr.appendChild(tdNama);

            // 4. Model Mobil
            let tdMobil = document.createElement('td');
            tdMobil.className = "p-3 text-slate-600 font-medium whitespace-normal break-words leading-tight";
            tdMobil.innerText = row.mobil;
            tr.appendChild(tdMobil);

            // 5. Paket & Detail Kerja Selesai Sesuai Pilihan Admin Kasir
            let tdPaket = document.createElement('td');
            tdPaket.className = "p-3 flex flex-col justify-center gap-0.5 whitespace-normal break-words";
            let txtAddons = row.addons.length > 0 ? `<span class="text-[8px] text-slate-400 font-medium leading-tight">+ ${row.addons.join(', ')}</span>` : '';
            tdPaket.innerHTML = `<span class="text-[9px] font-black text-blue-700 leading-none uppercase">${row.paket}</span>${txtAddons}`;
            tr.appendChild(tdPaket);

            // 6. Total Biaya
            let tdTotal = document.createElement('td');
            tdTotal.className = "p-3 text-right font-extrabold text-slate-900";
            tdTotal.innerText = formatRupiah(row.total);
            tr.appendChild(tdTotal);

            // 7. Status Kerja Nyata: Menampilkan Tahapan Selesai Kerja Workshop Dinamis
            let tdStatus = document.createElement('td');
            tdStatus.className = "p-3 text-center";
            tdStatus.innerHTML = `<span class="inline-block bg-indigo-50 border border-indigo-200 text-[#4338ca] text-[8px] font-black px-1.5 py-0.5 rounded-md uppercase tracking-wider shadow-sm">✨ ${row.proses_kerja}</span>`;
            tr.appendChild(tdStatus);

            tbody.appendChild(tr);
        });

        // Jalankan mesin hitung kotak atas
        kalkulasiKotakSainsRealtime(dataToRender);
    }

    // 🔥 CORE MULTI-FILTER COMBINATION ENGINE: Menyaring Nama, Tanggal, Bulan & Tahun Sekaligus Tanpa Reload!
    function jalankanFilterSistemKombinasi() {
        const keyword = document.getElementById('pencarian-live').value.toLowerCase();
        const tglFilter = document.getElementById('filter-tanggal').value;
        const blnFilter = document.getElementById('filter-bulan').value;
        const thnFilter = document.getElementById('filter-tahun').value;

        const hasilPenyaringanMatang = arrayDatabaseRiwayat.filter(item => {
            const matchKeyword = item.nopol.toLowerCase().includes(keyword) || item.nama.toLowerCase().includes(keyword) || item.mobil.toLowerCase().includes(keyword);
            const matchTanggal = (tglFilter === "ALL") || (item.tgl === tglFilter);
            const matchBulan = (blnFilter === "ALL") || (item.bln === blnFilter);
            const matchTahun = (thnFilter === "ALL") || (item.thn === thnFilter);

            return matchKeyword && matchTanggal && matchBulan && matchTahun;
        });

        renderTabelRiwayat(hasilPenyaringanMatang);
    }

    // 🚀 INIT RUN: Pertama kali dibuka website diset kosong (Atau panggil filter global)
    document.addEventListener("DOMContentLoaded", () => {
        // Kita set filter default ke "ALL" agar kasir bisa melihat simulasi,
        // ganti ke variabel tanggal kosong jika ingin murni 0 dari hari pertama rilis web.
        renderTabelRiwayat(arrayDatabaseRiwayat);
    });
</script>

@endsection
