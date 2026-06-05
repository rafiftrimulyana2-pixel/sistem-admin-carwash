@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    /* Mengunci seluruh elemen teks halaman internal menggunakan font Inter & Bold */
    .kasir-scope, .kasir-scope * {
        font-family: 'Inter', sans-serif !important;
        font-weight: 700 !important;
    }
    /* Sembunyikan scrollbar default pada area form internal */
    .form-scroll-clean::-webkit-scrollbar {
        display: none !important;
        width: 0px !important;
    }
    .form-scroll-clean {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    /* Animasi Pop-Up Sukses */
    @keyframes popIn {
        0% { transform: scale(0.9) translate(-50%, -50%); opacity: 0; }
        100% { transform: scale(1) translate(-50%, -50%); opacity: 1; }
    }
    .animate-popup {
        animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
</style>

<div class="kasir-scope w-full h-[calc(100vh-2px)] bg-[#f8fafc] flex flex-col overflow-hidden select-none antialiased text-slate-700">

    <form action="{{ route('input.transaksi') }}" method="POST" id="main-form-transaksi" class="w-full flex-1 flex flex-col overflow-hidden">
        @csrf
        <input type="hidden" name="paket_nama" id="form-paket-nama" value="">
        <input type="hidden" name="paket_harga" id="form-paket-harga" value="0">
        <input type="hidden" name="metode_pembayaran" id="form-metode-pembayaran" value="CASH">
        <input type="hidden" name="total_akhir_nominal" id="form-total-nominal" value="0">

        <div class="w-full bg-blue-600 border-b border-blue-700 px-6 py-4 flex justify-between items-center flex-shrink-0 shadow-md">
            <div>
                <h1 class="text-white text-sm font-black uppercase tracking-tight">REGISTRASI &amp; DOKUMENTASI ORDER BARU</h1>
                <p class="text-blue-100 text-[9px] font-bold uppercase tracking-wider mt-0.5">Sistem Pencatatan Pembayaran &amp; Transaksi Pelanggan Realtime</p>
            </div>
            <div class="flex items-center gap-2 bg-white/10 border border-white/20 px-3 py-1.5 rounded-xl">
                <div class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></div>
                <span class="text-[10px] font-black text-white uppercase tracking-wide">
                    Shift Kerja: <span id="live-shift-kerja" class="text-amber-300">Memuat Jadwal...</span>
                </span>
            </div>
        </div>

        <div class="w-full flex-1 flex overflow-hidden">

            <div class="w-[60%] h-full p-5 flex flex-col gap-4 overflow-y-auto form-scroll-clean border-r border-slate-100">

                <div class="bg-white rounded-xl border border-slate-100 p-4 flex flex-col gap-3 shadow-md shadow-slate-900/5">
                    <div class="flex items-center gap-2 border-b border-slate-50 pb-2">
                        <div class="p-1 rounded-md bg-blue-600 text-white font-black text-[10px] px-1.5 shadow-sm shadow-blue-200">01</div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-tight">Informasi Identitas Pelanggan</h3>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Nomor Polisi Kendaraan *</label>
                            <input type="text" name="nomor_polisi" id="input-nopol" required placeholder="Contoh: B 1234 ABC"
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-extrabold text-slate-900 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:bg-white uppercase tracking-wide transition-all shadow-inner">
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Tipe / Model Mobil *</label>
                            <input type="text" name="tipe_mobil" id="input-mobil" required placeholder="Contoh: Avanza, Fortuner, Scoopy, NMAX"
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:bg-white transition-all shadow-inner">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-1">
                        <div class="flex flex-col gap-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Nama Pelanggan / Owner *</label>
                            <input type="text" name="nama_customer" id="input-nama" required placeholder="Masukkan nama pemilik"
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:bg-white transition-all shadow-inner">
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Nomor WhatsApp (Kirim Nota) *</label>
                            <input type="number" name="nomor_wa" id="input-wa" required placeholder="Contoh: 0812xxxxxxxx"
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:bg-white transition-all shadow-inner">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-100 p-4 flex flex-col gap-3 shadow-md shadow-slate-900/5">
                    <div class="flex items-center gap-2 border-b border-slate-50 pb-2">
                        <div class="p-1 rounded-md bg-blue-600 text-white font-black text-[10px] px-1.5 shadow-sm shadow-blue-200">02</div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-tight">Pilihan Paket Cuci &amp; Ukuran Kendaraan</h3>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div id="card-reguler" onclick="toggleSelectionPaket('SMALL VEHICLE', 45000, 'card-reguler')" class="bg-white border border-slate-200 rounded-xl p-3 flex flex-col justify-between gap-3 cursor-pointer shadow-sm select-none transition-colors duration-150">
                            <div>
                                <span id="text-title-reguler" class="block text-[10px] font-black text-blue-600 uppercase tracking-wider">SMALL VEHICLE</span>
                                <span id="text-desc-reguler" class="block text-[8px] text-slate-400 font-medium mt-0.5">Cuci hidrolik untuk Motor, atau Mobil kecil sekelas Agya, Brio, dan Hatchback.</span>
                            </div>
                            <span id="text-price-reguler" class="block text-xs font-black text-slate-800 mt-2">Rp 45.000</span>
                        </div>

                        <div id="card-premium" onclick="toggleSelectionPaket('MEDIUM VEHICLE', 55000, 'card-premium')" class="bg-white border border-slate-200 rounded-xl p-3 flex flex-col justify-between gap-3 cursor-pointer shadow-sm select-none transition-colors duration-150">
                            <div>
                                <span id="text-title-premium" class="block text-[10px] font-black text-purple-600 uppercase tracking-wider">MEDIUM VEHICLE</span>
                                <span id="text-desc-premium" class="block text-[8px] text-slate-400 font-medium mt-0.5">Cuci hidrolik standar untuk Mobil ukuran sedang sekelas Avanza, Xpander, Mobilio, Sedan.</span>
                            </div>
                            <span id="text-price-premium" class="block text-xs font-black text-slate-800 mt-2">Rp 55.000</span>
                        </div>

                        <div id="card-coating" onclick="toggleSelectionPaket('LARGE VEHICLE / SUV', 65000, 'card-coating')" class="bg-white border border-slate-200 rounded-xl p-3 flex flex-col justify-between gap-3 cursor-pointer shadow-sm select-none transition-colors duration-150">
                            <div>
                                <span id="text-title-coating" class="block text-[10px] font-black text-amber-600 uppercase tracking-wider">LARGE CAR / SUV</span>
                                <span id="text-desc-coating" class="block text-[8px] text-slate-400 font-medium mt-0.5">Cuci hidrolik besar khusus untuk tipe SUV/MPV Bongsor seperti Fortuner, Pajero, Alphard.</span>
                            </div>
                            <span id="text-price-coating" class="block text-xs font-black text-slate-800 mt-2">Rp 65.000</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-100 p-4 flex flex-col gap-3 shadow-md shadow-slate-900/5">
                    <div class="flex items-center gap-2 border-b border-slate-50 pb-2">
                        <div class="p-1 rounded-md bg-blue-600 text-white font-black text-[10px] px-1.5 shadow-sm shadow-blue-200">03</div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-tight">Layanan Tambahan Opsional (Retail Add-ons)</h3>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center justify-between border border-slate-100 bg-slate-50/50 rounded-lg p-2.5 cursor-pointer hover:bg-slate-50 transition-all select-none">
                            <div class="flex items-center gap-2.5">
                                <input type="checkbox" name="addons[]" value="EKSTRA VACUUM" data-harga="20000" onchange="hitungTransaksiRealtime()" class="rounded text-blue-600 focus:ring-0 h-3.5 w-3.5">
                                <span class="text-[10px] font-bold text-slate-700 uppercase">Ekstra Vacuum Debu Karpet</span>
                            </div>
                            <span class="text-[10px] font-black text-slate-900">Rp 20.000</span>
                        </label>

                        <label class="flex items-center justify-between border border-slate-100 bg-slate-50/50 rounded-lg p-2.5 cursor-pointer hover:bg-slate-50 transition-all select-none">
                            <div class="flex items-center gap-2.5">
                                <input type="checkbox" name="addons[]" value="SEMIR BAN PREMIUM" data-harga="10000" onchange="hitungTransaksiRealtime()" class="rounded text-blue-600 focus:ring-0 h-3.5 w-3.5">
                                <span class="text-[10px] font-bold text-slate-700 uppercase">Semir Ban Premium Proteksi Glossy</span>
                            </div>
                            <span class="text-[10px] font-black text-slate-900">Rp 10.000</span>
                        </label>

                        <label class="flex items-center justify-between border border-slate-100 bg-slate-50/50 rounded-lg p-2.5 cursor-pointer hover:bg-slate-50 transition-all select-none">
                            <div class="flex items-center gap-2.5">
                                <input type="checkbox" name="addons[]" value="CUCI MESIN / RANGKA" data-harga="30000" onchange="hitungTransaksiRealtime()" class="rounded text-blue-600 focus:ring-0 h-3.5 w-3.5">
                                <span class="text-[10px] font-bold text-slate-700 uppercase">Pembersihan Kerak Mesin &amp; Rangka</span>
                            </div>
                            <span class="text-[10px] font-black text-slate-900">Rp 30.000</span>
                        </label>

                        <label class="flex items-center justify-between border border-slate-100 bg-slate-50/50 rounded-lg p-2.5 cursor-pointer hover:bg-slate-50 transition-all select-none">
                            <div class="flex items-center gap-2.5">
                                <input type="checkbox" name="addons[]" value="POLES LIQUID WAX" data-harga="40000" onchange="hitungTransaksiRealtime()" class="rounded text-blue-600 focus:ring-0 h-3.5 w-3.5">
                                <span class="text-[10px] font-bold text-slate-700 uppercase">Poles Kilap Body Wax Ekstra</span>
                            </div>
                            <span class="text-[10px] font-black text-slate-900">Rp 40.000</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="w-[40%] h-full bg-white p-5 flex flex-col justify-between overflow-hidden">

                <div class="flex flex-col gap-3 overflow-hidden flex-1">
                    <div class="w-full bg-blue-600 text-white px-3 py-2.5 rounded-lg shadow-md shadow-blue-100 flex items-center justify-center gap-2 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        <h3 class="text-xs font-black tracking-wider uppercase text-center">REKAPITULASI BERKAS PENYELARASAN KASIR</h3>
                    </div>

                    <div class="w-full border border-dashed border-slate-200 rounded-xl p-4 bg-slate-50 flex flex-col overflow-y-auto form-scroll-clean max-h-[160px]">
                        <div class="flex justify-between items-center border-b border-slate-200 pb-2 flex-shrink-0">
                            <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Item Transaksi</span>
                            <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Subtotal</span>
                        </div>

                        <div id="nota-item-container" class="flex flex-col gap-2 my-2 text-[10px] font-bold text-slate-800">
                            <div class="text-slate-400 font-medium text-center py-4 italic">Belum ada paket/layanan yang dipilih</div>
                        </div>

                        <div class="border-t border-slate-200 pt-2 flex flex-col gap-1 text-[9px] font-bold text-slate-500 flex-shrink-0">
                            <div class="flex justify-between items-center">
                                <span>PPN Operasional (11%)</span>
                                <span id="nota-pajak">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1.5 flex-shrink-0">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Metode Pembayaran Kasir</label>
                        <div class="grid grid-cols-3 gap-2">
                            <button type="button" onclick="setMetode('CASH', this)" class="btn-metode border-2 border-blue-600 bg-blue-50/50 text-blue-600 font-black text-[9px] py-2 rounded-lg flex items-center justify-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="2"/></svg>
                                CASH
                            </button>
                            <button type="button" onclick="setMetode('TRANSFER', this)" class="btn-metode border border-slate-200 text-slate-600 font-bold text-[9px] py-2 rounded-lg flex items-center justify-center gap-1.5 hover:bg-slate-50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/></svg>
                                BANK
                            </button>
                            <button type="button" onclick="setMetode('QRIS', this)" class="btn-metode border border-slate-200 text-slate-600 font-bold text-[9px] py-2 rounded-lg flex items-center justify-center gap-1.5 hover:bg-slate-50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M7 7h4v4H7zm8 0h2v2h-2zm0 6h2v2h-2zm-8 2h4v4H7zm8 2h2v2h-2z"/></svg>
                                QRIS
                            </button>
                        </div>
                    </div>

                    <div class="flex-1 overflow-hidden flex flex-col justify-center min-h-[90px]">

                        <div id="panel-pembayaran-cash" class="bg-slate-50 border border-slate-200 rounded-xl p-3 flex flex-col gap-2 shadow-inner">
                            <label class="text-[8.5px] font-black text-slate-400 uppercase tracking-wider">Input Nominal Uang Tunai Diterima Admin</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" id="cash-input-bayar" oninput="hitungKembalianTunai()" placeholder="Masukkan jumlah uang..." class="w-full bg-white border border-slate-200 rounded-lg px-2 py-1.5 text-xs font-bold text-slate-900 focus:outline-none focus:border-blue-600 shadow-inner">
                                <div class="flex items-center justify-between px-2 py-1 bg-white border border-slate-200 rounded-lg">
                                    <span class="text-[7.5px] font-black text-slate-400 uppercase">Kembali:</span>
                                    <span id="cash-text-kembalian" class="text-[10px] font-black text-blue-600">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <div id="panel-pembayaran-bank" class="hidden bg-slate-50 border border-slate-200 rounded-xl p-3 flex flex-col gap-1.5 shadow-inner text-center">
                            <div class="text-[8px] font-black text-blue-600 bg-blue-50 border border-blue-200 py-1 rounded-md uppercase tracking-wider">📡 KONEKSI GATEWAY BANK AKTIF</div>
                            <span class="text-[8.5px] font-medium text-slate-400 mt-1">Sistem Standby Memantau Rekening Perusahaan Untuk Aliran Dana Masuk Nyata.</span>
                        </div>

                        <div id="panel-pembayaran-qris" class="hidden bg-slate-50 border border-slate-200 rounded-xl p-2.5 flex items-center gap-3 shadow-inner">
                            <div class="w-14 h-14 bg-white border border-slate-200 p-1 rounded-lg flex-shrink-0 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-slate-800"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><path d="M7 7h.01M17 7h.01M7 17h.01M17 17h.01M10 10h4v4h-4z"/></svg>
                            </div>
                            <div class="flex-1 flex flex-col">
                                <span class="text-[9px] font-black text-slate-800 uppercase tracking-tight">QRIS DINAMIS OTOMATIS</span>
                                <span class="text-[7.5px] font-medium text-slate-400 mt-0.5 leading-tight">Barcode menyesuaikan nilai transaksi akhir secara aman dan real-time.</span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="flex flex-col gap-3 border-t border-slate-200 pt-3 flex-shrink-0">
                    <div class="flex justify-between items-center bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">TOTAL AKHIR (IDR)</span>
                        <span id="nota-total" class="text-lg font-black text-blue-600 tracking-tight">Rp 0</span>
                    </div>

                    <button type="button" onclick="eksekusiSimpanTransaksi()" class="w-full bg-blue-600 text-white font-black text-xs py-3.5 rounded-xl uppercase tracking-wider shadow-lg shadow-blue-600/20 hover:bg-blue-700 active:scale-[0.99] transition-all flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        KONFIRMASI PEMBAYARAN &amp; GENERATE JURNAL ARSIP
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="popup-sukses" class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 bg-white border border-slate-100 p-6 rounded-2xl shadow-xl flex flex-col items-center gap-3 w-[320px] animate-popup">
    <div class="h-12 w-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
        </svg>
    </div>
    <div class="text-center">
        <h4 class="text-xs font-black text-slate-900 uppercase tracking-tight">Transaksi Berhasil!</h4>
        <p class="text-[10px] text-slate-400 font-medium mt-1">Data dikirim dan terintegrasi penuh ke modul Riwayat &amp; Laporan Omset.</p>
    </div>
</div>

<div id="popup-overlay" class="hidden fixed inset-0 bg-slate-950/40 z-40 transition-all"></div>

<script>
    let metodeTerpilih = "CASH";
    let paketTerpilihNama = "";
    let paketTerpilihHarga = 0;
    let globalTotalAkhir = 0;

    function formatRupiah(angka) {
        return "Rp " + angka.toLocaleString('id-ID');
    }

    function hitungShiftKerjaPerusahaan() {
        const jamSekarang = new Date().getHours();
        let teksShift = "Shift Malam (Selesai)";

        if (jamSekarang >= 6 && jamSekarang < 14) {
            teksShift = "Shift Pagi (Aktif)";
        } else if (jamSekarang >= 14 && jamSekarang < 22) {
            teksShift = "Shift Sore (Aktif)";
        }

        const elShift = document.getElementById('live-shift-kerja');
        if(elShift) elShift.innerText = teksShift;
    }

    function setMetode(metode, element) {
        metodeTerpilih = metode;
        document.getElementById('form-metode-pembayaran').value = metode;

        document.querySelectorAll('.btn-metode').forEach(btn => {
            btn.classList.remove('border-2', 'border-blue-600', 'bg-blue-50/50', 'text-blue-600');
            btn.classList.add('border-slate-200', 'text-slate-600');
        });
        element.classList.remove('border-slate-200', 'text-slate-600');
        element.classList.add('border-2', 'border-blue-600', 'bg-blue-50/50', 'text-blue-600');

        document.getElementById('panel-pembayaran-cash').classList.add('hidden');
        document.getElementById('panel-pembayaran-bank').classList.add('hidden');
        document.getElementById('panel-pembayaran-qris').classList.add('hidden');

        if(metode === 'CASH') document.getElementById('panel-pembayaran-cash').classList.remove('hidden');
        else if(metode === 'TRANSFER') document.getElementById('panel-pembayaran-bank').classList.remove('hidden');
        else if(metode === 'QRIS') document.getElementById('panel-pembayaran-qris').classList.remove('hidden');
    }

    // TOGGLE SELEKSI UTAMA - MERUBAH KARTU JADI BIRU SOLID DAN TEKS JADI PUTIH BERSIH SECARA DINAMIS
    function toggleSelectionPaket(namaPaket, hargaPaket, idCard) {
        const targetCard = document.getElementById(idCard);

        // Reset semua style kartu ke default pabrik (Putih & warna font asli)
        resetCardStyle('card-reguler', 'text-blue-600', 'text-slate-400', 'text-slate-800');
        resetCardStyle('card-premium', 'text-purple-600', 'text-slate-400', 'text-slate-800');
        resetCardStyle('card-coating', 'text-amber-600', 'text-slate-400', 'text-slate-800');

        if (paketTerpilihNama === namaPaket) {
            paketTerpilihNama = "";
            paketTerpilihHarga = 0;
            targetCard.classList.remove('paket-active');
        } else {
            paketTerpilihNama = namaPaket;
            paketTerpilihHarga = hargaPaket;
            targetCard.classList.add('paket-active');

            // Set kartu aktif menjadi Biru Solid dan ubah seluruh teks di dalamnya menjadi putih bersih
            targetCard.className = "bg-blue-600 border-2 border-blue-600 rounded-xl p-3 flex flex-col justify-between gap-3 cursor-pointer shadow-sm select-none transition-colors duration-150 text-white";

            if(idCard === 'card-reguler') {
                document.getElementById('text-title-reguler').className = "block text-[10px] font-black uppercase tracking-wider text-white";
                document.getElementById('text-desc-reguler').className = "block text-[8px] font-bold mt-0.5 text-blue-100";
                document.getElementById('text-price-reguler').className = "block text-xs font-black mt-2 text-white";
            } else if(idCard === 'card-premium') {
                document.getElementById('text-title-premium').className = "block text-[10px] font-black uppercase tracking-wider text-white";
                document.getElementById('text-desc-premium').className = "block text-[8px] font-bold mt-0.5 text-blue-100";
                document.getElementById('text-price-premium').className = "block text-xs font-black mt-2 text-white";
            } else if(idCard === 'card-coating') {
                document.getElementById('text-title-coating').className = "block text-[10px] font-black uppercase tracking-wider text-white";
                document.getElementById('text-desc-coating').className = "block text-[8px] font-bold mt-0.5 text-blue-100";
                document.getElementById('text-price-coating').className = "block text-xs font-black mt-2 text-white";
            }
        }

        document.getElementById('form-paket-nama').value = paketTerpilihNama;
        document.getElementById('form-paket-harga').value = paketTerpilihHarga;

        hitungTransaksiRealtime();
    }

    // Fungsi pembantu untuk mengembalikan tampilan kartu yang tidak terpilih ke posisi normal semula
    function resetCardStyle(idCard, colorTitle, colorDesc, colorPrice) {
        const card = document.getElementById(idCard);
        card.className = "bg-white border border-slate-200 rounded-xl p-3 flex flex-col justify-between gap-3 cursor-pointer shadow-sm select-none transition-colors duration-150";

        if(idCard === 'card-reguler') {
            document.getElementById('text-title-reguler').className = `block text-[10px] font-black uppercase tracking-wider ${colorTitle}`;
            document.getElementById('text-desc-reguler').className = `block text-[8px] font-medium mt-0.5 ${colorDesc}`;
            document.getElementById('text-price-reguler').className = `block text-xs font-black mt-2 ${colorPrice}`;
        } else if(idCard === 'card-premium') {
            document.getElementById('text-title-premium').className = `block text-[10px] font-black uppercase tracking-wider ${colorTitle}`;
            document.getElementById('text-desc-premium').className = `block text-[8px] font-medium mt-0.5 ${colorDesc}`;
            document.getElementById('text-price-premium').className = `block text-xs font-black mt-2 ${colorPrice}`;
        } else if(idCard === 'card-coating') {
            document.getElementById('text-title-coating').className = `block text-[10px] font-black uppercase tracking-wider ${colorTitle}`;
            document.getElementById('text-desc-coating').className = `block text-[8px] font-medium mt-0.5 ${colorDesc}`;
            document.getElementById('text-price-coating').className = `block text-xs font-black mt-2 ${colorPrice}`;
        }
    }

    function hitungTransaksiRealtime() {
        const container = document.getElementById('nota-item-container');
        container.innerHTML = "";

        let subtotal = 0;
        let adaItem = false;

        if (paketTerpilihNama !== "") {
            adaItem = true;
            subtotal += paketTerpilihHarga;
            container.innerHTML += `
                <div class="flex justify-between items-center text-slate-900 font-extrabold uppercase flex-shrink-0">
                    <span>${paketTerpilihNama}</span>
                    <span>${formatRupiah(paketTerpilihHarga)}</span>
                </div>
            `;
        }

        const addonsTerpilih = document.querySelectorAll('input[name="addons[]"]:checked');
        addonsTerpilih.forEach(addon => {
            adaItem = true;
            subtotal += parseInt(addon.getAttribute('data-harga'));
            container.innerHTML += `
                <div class="flex justify-between items-center text-slate-500 font-medium pl-2 flex-shrink-0">
                    <span>+ ${addon.value}</span>
                    <span>${formatRupiah(parseInt(addon.getAttribute('data-harga')))}</span>
                </div>
            `;
        });

        if (!adaItem) {
            container.innerHTML = `<div class="text-slate-400 font-medium text-center py-4 italic">Belum ada paket/layanan yang dipilih</div>`;
            document.getElementById('nota-pajak').innerText = "Rp 0";
            document.getElementById('nota-total').innerText = "Rp 0";
            globalTotalAkhir = 0;
            document.getElementById('form-total-nominal').value = 0;
            hitungKembalianTunai();
            return;
        }

        let pajak = Math.round(subtotal * 0.11);
        globalTotalAkhir = subtotal + pajak;
        document.getElementById('form-total-nominal').value = globalTotalAkhir;

        document.getElementById('nota-pajak').innerText = formatRupiah(pajak);
        document.getElementById('nota-total').innerText = formatRupiah(globalTotalAkhir);

        hitungKembalianTunai();
    }

    function hitungKembalianTunai() {
        const uangBayar = parseInt(document.getElementById('cash-input-bayar').value) || 0;
        const txtKembali = document.getElementById('cash-text-kembalian');
        if (!txtKembali) return;

        if (uangBayar < globalTotalAkhir || globalTotalAkhir === 0) {
            txtKembali.innerText = "Rp 0";
            txtKembali.className = "text-[10px] font-black text-slate-400";
        } else {
            let kembalian = uangBayar - globalTotalAkhir;
            txtKembali.innerText = formatRupiah(kembalian);
            txtKembali.className = "text-[10px] font-black text-emerald-600";
        }
    }

    function eksekusiSimpanTransaksi() {
        const nopol = document.getElementById('input-nopol').value;
        const mobil = document.getElementById('input-mobil').value;
        const nama = document.getElementById('input-nama').value;
        const wa = document.getElementById('input-wa').value;

        if (!nopol || !mobil || !nama || !wa) {
            alert("Harap isi semua informasi Identitas Pelanggan terlebih dahulu, Chief!");
            return;
        }
        if (paketTerpilihNama === "") {
            alert("Pilih salah satu Paket Cuci Utama terlebih dahulu, Chief!");
            return;
        }

        if (metodeTerpilih === 'CASH') {
            const uangBayar = parseInt(document.getElementById('cash-input-bayar').value) || 0;
            if (uangBayar < globalTotalAkhir) {
                alert("Nominal uang cash yang diterima kurang dari total biaya transaksi, Chief!");
                return;
            }
        }

        document.getElementById('popup-sukses').classList.remove('hidden');
        document.getElementById('popup-overlay').classList.remove('hidden');

        setTimeout(() => {
            document.getElementById('main-form-transaksi').submit();
        }, 2000);
    }

    document.addEventListener("DOMContentLoaded", () => {
        hitungShiftKerjaPerusahaan();
    });
</script>
@endsection
