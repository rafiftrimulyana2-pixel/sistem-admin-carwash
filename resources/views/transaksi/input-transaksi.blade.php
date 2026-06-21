@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    /* Kunci font Inter merata agar presisi dengan sidebar luar */
    * { font-family: 'Inter', sans-serif; }

    .kasir-scope, .kasir-scope :not(nav, aside, .sidebar, [class*="sidebar"]) {
        font-weight: 700 !important;
    }

    /* Sembunyikan scrollbar pada area form internal */
    .form-scroll-clean::-webkit-scrollbar { display: none !important; width: 0px !important; }
    .form-scroll-clean { -ms-overflow-style: none; scrollbar-width: none; }

    /* Animasi Pop-Up Sukses */
    @keyframes popIn {
        0% { transform: scale(0.9) translate(-50%, -50%); opacity: 0; }
        100% { transform: scale(1) translate(-50%, -50%); opacity: 1; }
    }
    .animate-popup {
        animation: popIn 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
</style>

<div class="kasir-scope w-full h-[calc(100vh-2px)] bg-[#f4f7fb] flex flex-col overflow-hidden select-none antialiased text-slate-700">

    <form id="main-form-transaksi" class="w-full flex-1 flex flex-col overflow-hidden">
        @csrf
        <input type="hidden" name="paket_cuci" id="form-paket-nama" value="">
        <input type="hidden" name="metode_bayar" id="form-metode-pembayaran" value="TUNAI">
        <input type="hidden" name="total_bayar" id="form-total-nominal" value="0">

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

                <div class="bg-white rounded-xl border border-slate-100 p-4 flex flex-col gap-3 shadow-sm">
                    <div class="flex items-center gap-2 border-b border-slate-50 pb-2">
                        <div class="p-1 rounded-md bg-blue-600 text-white font-black text-[10px] px-1.5 shadow-sm">01</div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-tight">Informasi Identitas Pelanggan</h3>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Nomor Polisi Kendaraan *</label>
                            <input type="text" name="plat_nomor" id="input-nopol" required placeholder="Contoh: B 1234 ABC"
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-extrabold text-slate-900 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:bg-white uppercase tracking-wide transition-all shadow-inner">
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Tipe / Model Mobil *</label>
                            <input type="text" name="jenis_kendaraan" id="input-mobil" required placeholder="Contoh: Avanza, Fortuner, Brio"
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:bg-white transition-all shadow-inner">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-1">
                        <div class="flex flex-col gap-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Nama Pelanggan / Owner *</label>
                            <input type="text" name="nama_pelanggan" id="input-nama" required placeholder="Masukkan nama pemilik"
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:bg-white transition-all shadow-inner">
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Nomor WhatsApp *</label>
                            <input type="number" name="no_hp" id="input-wa" required placeholder="Contoh: 0812xxxxxxxx"
                                class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:bg-white transition-all shadow-inner">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-100 p-4 flex flex-col gap-3 shadow-sm">
                    <div class="flex items-center gap-2 border-b border-slate-50 pb-2">
                        <div class="p-1 rounded-md bg-blue-600 text-white font-black text-[10px] px-1.5 shadow-sm">02</div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-tight">Pilihan Paket Cuci Utama</h3>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div id="card-reguler" onclick="toggleSelectionPaket('Small Vehicle', 45000, 'card-reguler')" class="bg-white border border-slate-200 rounded-xl p-3 flex flex-col justify-between gap-3 cursor-pointer shadow-sm select-none transition-colors duration-150">
                            <div>
                                <span id="text-title-reguler" class="block text-[10px] font-black text-blue-600 uppercase tracking-wider">SMALL VEHICLE</span>
                                <span id="text-desc-reguler" class="block text-[8px] text-slate-400 font-medium mt-0.5">Motor, Agya, Brio, Hatchback, dll.</span>
                            </div>
                            <span id="text-price-reguler" class="block text-xs font-black text-slate-800 mt-2">Rp 45.000</span>
                        </div>

                        <div id="card-premium" onclick="toggleSelectionPaket('Medium Vehicle', 55000, 'card-premium')" class="bg-white border border-slate-200 rounded-xl p-3 flex flex-col justify-between gap-3 cursor-pointer shadow-sm select-none transition-colors duration-150">
                            <div>
                                <span id="text-title-premium" class="block text-[10px] font-black text-purple-600 uppercase tracking-wider">MEDIUM VEHICLE</span>
                                <span id="text-desc-premium" class="block text-[8px] text-slate-400 font-medium mt-0.5">Avanza, Xpander, Mobilio, Sedan, dll.</span>
                            </div>
                            <span id="text-price-premium" class="block text-xs font-black text-slate-800 mt-2">Rp 55.000</span>
                        </div>

                        <div id="card-coating" onclick="toggleSelectionPaket('Premium Wash', 65000, 'card-coating')" class="bg-white border border-slate-200 rounded-xl p-3 flex flex-col justify-between gap-3 cursor-pointer shadow-sm select-none transition-colors duration-150">
                            <div>
                                <span id="text-title-coating" class="block text-[10px] font-black text-amber-600 uppercase tracking-wider">PREMIUM WASH</span>
                                <span id="text-desc-coating" class="block text-[8px] text-slate-400 font-medium mt-0.5">Fortuner, Pajero, Alphard, SUV Besar, dll.</span>
                            </div>
                            <span id="text-price-coating" class="block text-xs font-black text-slate-800 mt-2">Rp 65.000</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-100 p-4 flex flex-col gap-3 shadow-sm">
                    <div class="flex items-center gap-2 border-b border-slate-50 pb-2">
                        <div class="p-1 rounded-md bg-blue-600 text-white font-black text-[10px] px-1.5 shadow-sm">03</div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-tight">Layanan Tambahan Opsional (Super Lengkap)</h3>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center justify-between border border-slate-100 bg-slate-50/50 rounded-lg p-2.5 cursor-pointer hover:bg-slate-50 transition-all select-none">
                            <div class="flex items-center gap-2.5">
                                <input type="checkbox" name="addons[]" value="EKSTRA VACUUM" data-harga="20000" onchange="hitungTransaksiRealtime()" class="rounded text-blue-600 focus:ring-0 h-3.5 w-3.5">
                                <span class="text-[10px] font-bold text-slate-700 uppercase">Ekstra Vacuum Interior</span>
                            </div>
                            <span class="text-[10px] font-black text-slate-900">Rp 20.000</span>
                        </label>

                        <label class="flex items-center justify-between border border-slate-100 bg-slate-50/50 rounded-lg p-2.5 cursor-pointer hover:bg-slate-50 transition-all select-none">
                            <div class="flex items-center gap-2.5">
                                <input type="checkbox" name="addons[]" value="SEMIR BAN" data-harga="10000" onchange="hitungTransaksiRealtime()" class="rounded text-blue-600 focus:ring-0 h-3.5 w-3.5">
                                <span class="text-[10px] font-bold text-slate-700 uppercase">Semir Ban Premium</span>
                            </div>
                            <span class="text-[10px] font-black text-slate-900">Rp 10.000</span>
                        </label>

                        <label class="flex items-center justify-between border border-slate-100 bg-slate-50/50 rounded-lg p-2.5 cursor-pointer hover:bg-slate-50 transition-all select-none">
                            <div class="flex items-center gap-2.5">
                                <input type="checkbox" name="addons[]" value="CUCI MESIN" data-harga="30000" onchange="hitungTransaksiRealtime()" class="rounded text-blue-600 focus:ring-0 h-3.5 w-3.5">
                                <span class="text-[10px] font-bold text-slate-700 uppercase">Pembersihan Rangka Mesin</span>
                            </div>
                            <span class="text-[10px] font-black text-slate-900">Rp 30.000</span>
                        </label>

                        <label class="flex items-center justify-between border border-slate-100 bg-slate-50/50 rounded-lg p-2.5 cursor-pointer hover:bg-slate-50 transition-all select-none">
                            <div class="flex items-center gap-2.5">
                                <input type="checkbox" name="addons[]" value="LIQUID WAX" data-harga="40000" onchange="hitungTransaksiRealtime()" class="rounded text-blue-600 focus:ring-0 h-3.5 w-3.5">
                                <span class="text-[10px] font-bold text-slate-700 uppercase">Poles Kilap Liquid Wax</span>
                            </div>
                            <span class="text-[10px] font-black text-slate-900">Rp 40.000</span>
                        </label>

                        <label class="flex items-center justify-between border border-slate-100 bg-slate-50/50 rounded-lg p-2.5 cursor-pointer hover:bg-slate-50 transition-all select-none">
                            <div class="flex items-center gap-2.5">
                                <input type="checkbox" name="addons[]" value="FOGGING INTERIOR" data-harga="50000" onchange="hitungTransaksiRealtime()" class="rounded text-blue-600 focus:ring-0 h-3.5 w-3.5">
                                <span class="text-[10px] font-bold text-slate-700 uppercase">Fogging Anti Bakteri</span>
                            </div>
                            <span class="text-[10px] font-black text-slate-900">Rp 50.000</span>
                        </label>

                        <label class="flex items-center justify-between border border-slate-100 bg-slate-50/50 rounded-lg p-2.5 cursor-pointer hover:bg-slate-50 transition-all select-none">
                            <div class="flex items-center gap-2.5">
                                <input type="checkbox" name="addons[]" value="GLASS DETAILING" data-harga="75000" onchange="hitungTransaksiRealtime()" class="rounded text-blue-600 focus:ring-0 h-3.5 w-3.5">
                                <span class="text-[10px] font-bold text-slate-700 uppercase">Pembersihan Jamur Kaca</span>
                            </div>
                            <span class="text-[10px] font-black text-slate-900">Rp 75.000</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="w-[40%] h-full bg-white p-5 flex flex-col justify-between overflow-hidden">
                <div class="flex flex-col gap-3 overflow-hidden flex-1">
                    <div class="w-full bg-blue-600 text-white px-3 py-2.5 rounded-lg shadow-sm flex items-center justify-center gap-2 flex-shrink-0">
                        <i data-lucide="receipt" class="w-4 h-4 text-white"></i>
                        <h3 class="text-xs font-black tracking-wider uppercase text-center">REKAPITULASI NOTA KASIR</h3>
                    </div>

                    <div class="w-full border border-dashed border-slate-200 rounded-xl p-4 bg-slate-50 flex flex-col overflow-y-auto form-scroll-clean max-h-[160px]">
                        <div class="flex justify-between items-center border-b border-slate-200 pb-2 flex-shrink-0">
                            <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Item Transaksi</span>
                            <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest">Subtotal</span>
                        </div>
                        <div id="nota-item-container" class="flex flex-col gap-2 my-2 text-[10px] font-bold text-slate-800">
                            <div class="text-slate-400 font-medium text-center py-4 italic">Belum ada paket yang dipilih</div>
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
                            <button type="button" onclick="setMetode('TUNAI', this)" class="btn-metode border-2 border-blue-600 bg-blue-50/50 text-blue-600 font-black text-[9px] py-2 rounded-lg flex items-center justify-center gap-1.5">TUNAI</button>
                            <button type="button" onclick="setMetode('TRANSFER', this)" class="btn-metode border border-slate-200 text-slate-600 font-bold text-[9px] py-2 rounded-lg flex items-center justify-center gap-1.5 hover:bg-slate-50">TRANSFER</button>
                            <button type="button" onclick="setMetode('QRIS', this)" class="btn-metode border border-slate-200 text-slate-600 font-bold text-[9px] py-2 rounded-lg flex items-center justify-center gap-1.5 hover:bg-slate-50">QRIS</button>
                        </div>
                    </div>

                    <div class="flex-1 overflow-hidden flex flex-col justify-center min-h-[90px]">
                        <div id="panel-pembayaran-cash" class="bg-slate-50 border border-slate-200 rounded-xl p-3 flex flex-col gap-2 shadow-inner">
                            <label class="text-[8.5px] font-black text-slate-400 uppercase tracking-wider">Input Uang Tunai Diterima</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" id="cash-input-bayar" oninput="hitungKembalianTunai()" placeholder="Masukkan uang..." class="w-full bg-white border border-slate-200 rounded-lg px-2 py-1.5 text-xs font-bold text-slate-900 focus:outline-none focus:border-blue-600">
                                <div class="flex items-center justify-between px-2 py-1 bg-white border border-slate-200 rounded-lg">
                                    <span class="text-[7.5px] font-black text-slate-400 uppercase">Kembali:</span>
                                    <span id="cash-text-kembalian" class="text-[10px] font-black text-blue-600">Rp 0</span>
                                </div>
                            </div>
                        </div>
                        <div id="panel-pembayaran-bank" class="hidden bg-slate-50 border border-slate-200 rounded-xl p-3 text-center"><span class="text-[8.5px] font-medium text-slate-400">Gateway Bank Terkoneksi.</span></div>
                        <div id="panel-pembayaran-qris" class="hidden bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-center"><span class="text-[8.5px] font-medium text-slate-400">QRIS Dinamis Otomatis Standby.</span></div>
                    </div>
                </div>

                <div class="flex flex-col gap-3 border-t border-slate-200 pt-3 flex-shrink-0">
                    <div class="flex justify-between items-center bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">TOTAL AKHIR (IDR)</span>
                        <span id="nota-total" class="text-lg font-black text-blue-600 tracking-tight">Rp 0</span>
                    </div>

                    {{-- PERBAIKAN: Kalimat diperpendek, penempatan pas, memakai mesin Lucide Icon --}}
                    <button type="button" onclick="eksekusiSimpanTransaksi()" class="w-full bg-blue-600 text-white font-black text-xs py-3.5 rounded-xl uppercase tracking-wider shadow-lg hover:bg-blue-700 active:scale-[0.99] transition-all flex justify-center items-center gap-2">
                        <i data-lucide="printer" class="w-4 h-4 text-white"></i>
                        PROSES &amp; CETAK NOTA KASIR
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="popup-sukses" class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 bg-white border border-slate-100 p-6 rounded-2xl shadow-xl flex flex-col items-center gap-3 w-[320px] animate-popup">
    <div class="h-12 w-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
    </div>
    <div class="text-center">
        <h4 class="text-xs font-black text-slate-900 uppercase tracking-tight">Transaksi Berhasil!</h4>
        <p class="text-[10px] text-slate-400 font-medium mt-1">Data masuk database. Form siap diisi kembali secara otomatis.</p>
    </div>
</div>
<div id="popup-overlay" class="hidden fixed inset-0 bg-slate-950/40 z-40"></div>

<script>
    let metodeTerpilih = "TUNAI";
    let paketTerpilihNama = "";
    let paketTerpilihHarga = 0;
    let globalTotalAkhir = 0;

    function formatRupiah(angka) { return "Rp " + angka.toLocaleString('id-ID'); }

    function hitungShiftKerjaPerusahaan() {
        const jamSekarang = new Date().getHours();
        let teksShift = "Shift Malam (Selesai)";
        if (jamSekarang >= 6 && jamSekarang < 14) teksShift = "Shift Pagi (Aktif)";
        else if (jamSekarang >= 14 && jamSekarang < 22) teksShift = "Shift Sore (Aktif)";
        document.getElementById('live-shift-kerja').innerText = teksShift;
    }

    function setMetode(metode, element) {
        metodeTerpilih = metode;
        document.getElementById('form-metode-pembayaran').value = metode;
        document.querySelectorAll('.btn-metode').forEach(btn => {
            btn.className = "btn-metode border border-slate-200 text-slate-600 font-bold text-[9px] py-2 rounded-lg flex items-center justify-center gap-1.5 hover:bg-slate-50";
        });
        element.className = "btn-metode border-2 border-blue-600 bg-blue-50/50 text-blue-600 font-black text-[9px] py-2 rounded-lg flex items-center justify-center gap-1.5";

        document.getElementById('panel-pembayaran-cash').classList.add('hidden');
        document.getElementById('panel-pembayaran-bank').classList.add('hidden');
        document.getElementById('panel-pembayaran-qris').classList.add('hidden');

        if(metode === 'TUNAI') document.getElementById('panel-pembayaran-cash').classList.remove('hidden');
        else if(metode === 'TRANSFER') document.getElementById('panel-pembayaran-bank').classList.remove('hidden');
        else if(metode === 'QRIS') document.getElementById('panel-pembayaran-qris').classList.remove('hidden');
    }

    function toggleSelectionPaket(namaPaket, hargaPaket, idCard) {
        const targetCard = document.getElementById(idCard);
        resetCardStyle('card-reguler', 'text-blue-600', 'text-slate-400', 'text-slate-800');
        resetCardStyle('card-premium', 'text-purple-600', 'text-slate-400', 'text-slate-800');
        resetCardStyle('card-coating', 'text-amber-600', 'text-slate-400', 'text-slate-800');

        if (paketTerpilihNama === namaPaket) {
            paketTerpilihNama = ""; paketTerpilihHarga = 0;
        } else {
            paketTerpilihNama = namaPaket; paketTerpilihHarga = hargaPaket;
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
        hitungTransaksiRealtime();
    }

    function resetCardStyle(idCard, colorTitle, colorDesc, colorPrice) {
        document.getElementById(idCard).className = "bg-white border border-slate-200 rounded-xl p-3 flex flex-col justify-between gap-3 cursor-pointer shadow-sm select-none transition-colors duration-150";
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
            adaItem = true; subtotal += paketTerpilihHarga;
            container.innerHTML += `<div class="flex justify-between items-center text-slate-900 font-extrabold uppercase"><span>${paketTerpilihNama}</span><span>${formatRupiah(paketTerpilihHarga)}</span></div>`;
        }

        document.querySelectorAll('input[name="addons[]"]:checked').forEach(addon => {
            adaItem = true; subtotal += parseInt(addon.getAttribute('data-harga'));
            container.innerHTML += `<div class="flex justify-between items-center text-slate-500 font-medium pl-2"><span>+ ${addon.value}</span><span>${formatRupiah(parseInt(addon.getAttribute('data-harga')))}</span></div>`;
        });

        if (!adaItem) {
            container.innerHTML = `<div class="text-slate-400 font-medium text-center py-4 italic">Belum ada paket yang dipilih</div>`;
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
        if (uangBayar < globalTotalAkhir || globalTotalAkhir === 0) {
            txtKembali.innerText = "Rp 0"; txtKembali.className = "text-[10px] font-black text-slate-400";
        } else {
            txtKembali.innerText = formatRupiah(uangBayar - globalTotalAkhir);
            txtKembali.className = "text-[10px] font-black text-emerald-600";
        }
    }

    /* ==========================================================================
       TEKNOLOGI BARU: Mengirim data via AJAX Fetch agar form bisa dipakai berkali-kali
       tanpa merusak halaman / tanpa stuck loading putih.
       ========================================================================== */
    function eksekusiSimpanTransaksi() {
    const form = document.getElementById('main-form-transaksi');

    // 1. Validasi Total Akhir
    if (globalTotalAkhir <= 0) {
        alert("Total transaksi masih Rp 0. Pilih paket terlebih dahulu, Chief!");
        return;
    }

    // 2. Validasi Identitas Pelanggan (Semua kolom wajib diisi)
    const nopol = document.getElementById('input-nopol').value;
    const mobil = document.getElementById('input-mobil').value;
    const nama = document.getElementById('input-nama').value;
    const wa = document.getElementById('input-wa').value;

    if (!nopol || !mobil || !nama || !wa) {
        alert("Mohon lengkapi semua data identitas pelanggan, Chief!");
        return;
    }

    // 3. Validasi Pembayaran Tunai
    const uangBayar = parseInt(document.getElementById('cash-input-bayar').value) || 0;
    if (metodeTerpilih === 'TUNAI' && uangBayar < globalTotalAkhir) {
        alert("Nominal uang cash (" + formatRupiah(uangBayar) + ") kurang dari total biaya (" + formatRupiah(globalTotalAkhir) + ")!");
        return;
    }

    // 4. Proses Pengiriman Data
    document.getElementById('popup-sukses').classList.remove('hidden');
    document.getElementById('popup-overlay').classList.remove('hidden');

    let dataFormulir = new FormData(form);

    fetch("{{ route('input.transaksi') }}", {
    method: 'POST',
    body: dataFormulir,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
    }
})
.then(response => response.json()) // Langsung ambil JSON
.then(data => {
    if (data.success) {
        // BERHASIL: Jalankan logika reset form kamu di sini
        document.getElementById('popup-sukses').classList.remove('hidden');
        document.getElementById('popup-overlay').classList.remove('hidden');

        setTimeout(() => {
            document.getElementById('popup-sukses').classList.add('hidden');
            document.getElementById('popup-overlay').classList.add('hidden');

            // Reset form...
            form.reset();
            // ... (lanjutkan reset variabel lainnya)
            hitungTransaksiRealtime();
        }, 1500);
    } else {
        // GAGAL VALIDASI: Tampilkan pesan dari server
        alert("Gagal: " + data.message);
    }
})
.catch(error => {
    // Hanya muncul jika koneksi putus atau server mati
    console.error('Error:', error);
    alert("Koneksi ke server terputus. Pastikan server Laravel aktif.");
});
}
    document.addEventListener("DOMContentLoaded", () => {
        hitungShiftKerjaPerusahaan();
        if(typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
@endsection
