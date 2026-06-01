@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    body {
        font-family: 'Inter', sans-serif;
    }
    /* Menghilangkan scrollbar default pada area form internal */
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
    /* Gaya visual ketika paket terpilih (Figma Border Highlight) */
    .paket-active {
        border-color: #4338ca !important;
        background-color: rgb(238 242 255 / 0.4) !important;
    }
</style>

<div class="w-full h-[calc(100vh-2px)] bg-[#f8fafc] flex flex-col overflow-hidden select-none antialiased text-slate-700">

    <div class="w-full bg-gradient-to-r from-[#1e40af] via-[#4338ca] to-[#5b21b6] px-6 py-4 flex justify-between items-center flex-shrink-0 shadow-md">
        <div>
            <h1 class="text-white text-sm font-extrabold uppercase tracking-tight">KASIR INPUT TRANSAKSI BARU</h1>
            <p class="text-indigo-200 text-[9px] font-bold uppercase tracking-wider mt-0.5">Sistem Pencatatan Pembayaran & Transaksi Pelanggan Realtime</p>
        </div>
        <div class="flex items-center gap-2 bg-white/10 border border-white/20 px-3 py-1.5 rounded-xl">
            <div class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></div>
            <span class="text-[10px] font-bold text-white uppercase">KASIR: ADMIN OPERASIONAL</span>
        </div>
    </div>

    <div class="w-full flex-1 flex overflow-hidden">

        <div class="w-[60%] h-full p-5 flex flex-col gap-4 overflow-y-auto form-scroll-clean border-r border-slate-200">

            <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm p-4 flex flex-col gap-3">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-2">
                    <div class="p-1 rounded-md bg-[#4338ca] text-white font-bold text-[10px] px-1.5">01</div>
                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-tight">Informasi Identitas Pelanggan</h3>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Nomor Polisi Kendaraan *</label>
                        <input type="text" id="input-nopol" required placeholder="Contoh: B 1234 ABC"
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-extrabold text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#4338ca] focus:bg-white uppercase tracking-wide transition-all shadow-inner">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Tipe / Model Mobil *</label>
                        <input type="text" id="input-mobil" required placeholder="Contoh: Avanza Veloz, Fortuner VRZ"
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#4338ca] focus:bg-white transition-all shadow-inner">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-1">
                    <div class="flex flex-col gap-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Nama Pelanggan / Owner *</label>
                        <input type="text" id="input-nama" required placeholder="Masukkan nama pemilik"
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#4338ca] focus:bg-white transition-all shadow-inner">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Nomor WhatsApp (Kirim Nota) *</label>
                        <input type="number" id="input-wa" required placeholder="Contoh: 0812xxxxxxxx"
                            class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#4338ca] focus:bg-white transition-all shadow-inner">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm p-4 flex flex-col gap-3">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-2">
                    <div class="p-1 rounded-md bg-[#4338ca] text-white font-bold text-[10px] px-1.5">02</div>
                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-tight">Pilihan Paket Cuci & Treatment Utama</h3>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div id="card-reguler" onclick="toggleSelectionPaket('REGULER WASH', 50000, 'card-reguler')" class="border border-slate-200 rounded-xl p-3 flex flex-col justify-between gap-3 cursor-pointer hover:border-[#4338ca] hover:bg-indigo-50/20 transition-all">
                        <div>
                            <span class="block text-[10px] font-black text-blue-600 uppercase tracking-wider">REGULER WASH</span>
                            <span class="block text-[8px] text-slate-400 font-medium mt-0.5">Cuci salju + vacuum interior standar + semir ban.</span>
                        </div>
                        <span class="block text-xs font-black text-slate-900 mt-2">Rp 50.000</span>
                    </div>

                    <div id="card-premium" onclick="toggleSelectionPaket('PREMIUM WAX', 120000, 'card-premium')" class="border border-slate-200 rounded-xl p-3 flex flex-col justify-between gap-3 cursor-pointer hover:border-[#4338ca] hover:bg-indigo-50/20 transition-all">
                        <div>
                            <span class="block text-[10px] font-black text-purple-600 uppercase tracking-wider">PREMIUM WAX</span>
                            <span class="block text-[8px] text-slate-400 font-medium mt-0.5">Cuci reguler + poles wax body pelindung cat premium.</span>
                        </div>
                        <span class="block text-xs font-black text-slate-900 mt-2">Rp 120.000</span>
                    </div>

                    <div id="card-coating" onclick="toggleSelectionPaket('ULTIMATE COATING', 350000, 'card-coating')" class="border border-slate-200 rounded-xl p-3 flex flex-col justify-between gap-3 cursor-pointer hover:border-[#4338ca] hover:bg-indigo-50/20 transition-all">
                        <div>
                            <span class="block text-[10px] font-black text-amber-600 uppercase tracking-wider">ULTIMATE COATING</span>
                            <span class="block text-[8px] text-slate-400 font-medium mt-0.5">Detailing kolong + poles jamur kaca + nano coating.</span>
                        </div>
                        <span class="block text-xs font-black text-slate-900 mt-2">Rp 350.000</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm p-4 flex flex-col gap-3">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-2">
                    <div class="p-1 rounded-md bg-[#4338ca] text-white font-bold text-[10px] px-1.5">03</div>
                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-tight">Layanan Tambahan Opsional (Add-ons)</h3>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center justify-between border border-slate-100 bg-slate-50/50 rounded-lg p-2.5 cursor-pointer hover:bg-slate-50 transition-all">
                        <div class="flex items-center gap-2.5">
                            <input type="checkbox" name="addons" value="JAMUR KACA DEPAN" data-harga="45000" onchange="hitungTransaksiRealtime()" class="rounded text-[#4338ca] focus:ring-0 h-3.5 w-3.5">
                            <span class="text-[10px] font-bold text-slate-700 uppercase">Pembersihan Jamur Kaca Depan</span>
                        </div>
                        <span class="text-[10px] font-black text-slate-900">Rp 45.000</span>
                    </label>

                    <label class="flex items-center justify-between border border-slate-100 bg-slate-50/50 rounded-lg p-2.5 cursor-pointer hover:bg-slate-50 transition-all">
                        <div class="flex items-center gap-2.5">
                            <input type="checkbox" name="addons" value="ENGINE DETAILING" data-harga="75000" onchange="hitungTransaksiRealtime()" class="rounded text-[#4338ca] focus:ring-0 h-3.5 w-3.5">
                            <span class="text-[10px] font-bold text-slate-700 uppercase">Engine Detailing (Ruang Mesin)</span>
                        </div>
                        <span class="text-[10px] font-black text-slate-900">Rp 75.000</span>
                    </label>

                    <label class="flex items-center justify-between border border-slate-100 bg-slate-50/50 rounded-lg p-2.5 cursor-pointer hover:bg-slate-50 transition-all">
                        <div class="flex items-center gap-2.5">
                            <input type="checkbox" name="addons" value="FOGGING INTERIOR" data-harga="60000" onchange="hitungTransaksiRealtime()" class="rounded text-[#4338ca] focus:ring-0 h-3.5 w-3.5">
                            <span class="text-[10px] font-bold text-slate-700 uppercase">Fogging Interior Anti Bakteri</span>
                        </div>
                        <span class="text-[10px] font-black text-slate-900">Rp 60.000</span>
                    </label>

                    <label class="flex items-center justify-between border border-slate-100 bg-slate-50/50 rounded-lg p-2.5 cursor-pointer hover:bg-slate-50 transition-all">
                        <div class="flex items-center gap-2.5">
                            <input type="checkbox" name="addons" value="EKSTRA VACUUM" data-harga="25000" onchange="hitungTransaksiRealtime()" class="rounded text-[#4338ca] focus:ring-0 h-3.5 w-3.5">
                            <span class="text-[10px] font-bold text-slate-700 uppercase">Ekstra Vacuum Karpet Beludru</span>
                        </div>
                        <span class="text-[10px] font-black text-slate-900">Rp 25.000</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="w-[40%] h-full bg-white p-5 flex flex-col justify-between overflow-hidden">

            <div class="flex flex-col gap-3 overflow-hidden flex-1">
                <div class="flex items-center gap-2 bg-gradient-to-r from-[#4338ca] to-[#5b21b6] text-white px-3 py-2.5 rounded-lg shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <h3 class="text-xs font-black tracking-wider uppercase">Ringkasan Faktur / Kasir Nota</h3>
                </div>

                <div class="w-full border border-dashed border-slate-300 rounded-xl p-4 bg-slate-50 flex flex-col overflow-y-auto form-scroll-clean max-h-[280px]">
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
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Metode Pembayaran Kasir</label>
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" onclick="setMetode('TUNAI', this)" class="btn-metode border-2 border-[#4338ca] bg-indigo-50/50 text-[#4338ca] font-extrabold text-[9px] py-2 rounded-lg flex items-center justify-center gap-1.5">
                            💵 TUNAI
                        </button>
                        <button type="button" onclick="setMetode('TRANSFER', this)" class="btn-metode border border-slate-200 text-slate-600 font-bold text-[9px] py-2 rounded-lg flex items-center justify-center gap-1.5 hover:bg-slate-50">
                            🏦 BANK
                        </button>
                        <button type="button" onclick="setMetode('QRIS', this)" class="btn-metode border border-slate-200 text-slate-600 font-bold text-[9px] py-2 rounded-lg flex items-center justify-center gap-1.5 hover:bg-slate-50">
                            📱 QRIS
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-3 border-t border-slate-200 pt-3 flex-shrink-0">
                <div class="flex justify-between items-center bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">TOTAL AKHIR (IDR)</span>
                    <span id="nota-total" class="text-lg font-black text-blue-700 tracking-tight">Rp 0</span>
                </div>

                <button type="button" onclick="eksekusiSimpanTransaksi()" class="w-full bg-gradient-to-r from-[#1e40af] to-[#4338ca] text-white font-extrabold text-xs py-3.5 rounded-xl uppercase tracking-wider shadow-md hover:brightness-110 active:scale-[0.99] transition-all flex justify-center items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" stroke-dasharray="50" stroke-dashoffset="0" />
                    </svg>
                    PROSES TRANSAKSI & CETAK NOTA KASIR
                </button>
            </div>
        </div>
    </div>
</div>

<div id="popup-sukses" class="hidden fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 bg-white border border-slate-200 p-6 rounded-2xl shadow-2xl flex flex-col items-center gap-3 w-[320px] animate-popup">
    <div class="h-12 w-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
        </svg>
    </div>
    <div class="text-center">
        <h4 class="text-xs font-black text-slate-900 uppercase tracking-tight">Transaksi Berhasil!</h4>
        <p class="text-[10px] text-slate-400 font-medium mt-1">Data telah disimpan ke sistem database & WhatsApp nota terkirim.</p>
    </div>
</div>

<div id="popup-overlay" class="hidden fixed inset-0 bg-slate-950/40 z-40 transition-all"></div>


<script>
    let metodeTerpilih = "TUNAI";

    // Variabel state penampung paket terpilih secara realtime
    let paketTerpilihNama = "";
    let paketTerpilihHarga = 0;

    function formatRupiah(angka) {
        return "Rp " + angka.toLocaleString('id-ID');
    }

    function setMetode(metode, element) {
        metodeTerpilih = metode;
        document.querySelectorAll('.btn-metode').forEach(btn => {
            btn.classList.remove('border-2', 'border-[#4338ca]', 'bg-indigo-50/50', 'text-[#4338ca]');
            btn.classList.add('border-slate-200', 'text-slate-600');
        });
        element.classList.remove('border-slate-200', 'text-slate-600');
        element.classList.add('border-2', 'border-[#4338ca]', 'bg-indigo-50/50', 'text-[#4338ca]');
    }

    // 🔥 LOGIKA SAKELAR TOGGLE UTAMA: Bisa klik 2 kali pada paket yang sama untuk membatalkan pilihan!
    function toggleSelectionPaket(namaPaket, hargaPaket, idCard) {
        const targetCard = document.getElementById(idCard);

        if (paketTerpilihNama === namaPaket) {
            // KLIK KEDUA KALINYA (BATALKAN): Jika paket yang diklik sama, kosongkan data
            paketTerpilihNama = "";
            paketTerpilihHarga = 0;
            targetCard.classList.remove('paket-active');
        } else {
            // KLIK PERTAMA KALI (MEMILIH): Bersihkan semua highlight kartu lain dulu, lalu pilih ini
            document.getElementById('card-reguler').classList.remove('paket-active');
            document.getElementById('card-premium').classList.remove('paket-active');
            document.getElementById('card-coating').classList.remove('paket-active');

            paketTerpilihNama = namaPaket;
            paketTerpilihHarga = hargaPaket;
            targetCard.classList.add('paket-active');
        }

        // Panggil sistem kalkulasi realtime untuk merender nota
        hitungTransaksiRealtime();
    }

    function hitungTransaksiRealtime() {
        const container = document.getElementById('nota-item-container');
        container.innerHTML = "";

        let subtotal = 0;
        let adaItem = false;

        // 1. Render Paket Jika Ada Terpilih
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

        // 2. Render Tambahan Add-ons Terpilih
        const addonsTerpilih = document.querySelectorAll('input[name="addons"]:checked');
        addonsTerpilih.forEach(addon => {
            adaItem = true;
            const namaAddon = addon.value;
            const hargaAddon = parseInt(addon.getAttribute('data-harga'));
            subtotal += hargaAddon;

            container.innerHTML += `
                <div class="flex justify-between items-center text-slate-500 font-medium pl-2 flex-shrink-0">
                    <span>+ ${namaAddon}</span>
                    <span>${formatRupiah(hargaAddon)}</span>
                </div>
            `;
        });

        if (!adaItem) {
            container.innerHTML = `<div class="text-slate-400 font-medium text-center py-4 italic">Belum ada paket/layanan yang dipilih</div>`;
            document.getElementById('nota-pajak').innerText = "Rp 0";
            document.getElementById('nota-total').innerText = "Rp 0";
            return;
        }

        // 3. Kalkulasi Pajak PPN 11% & Total Akhir
        let pajak = Math.round(subtotal * 0.11);
        let totalAkhir = subtotal + pajak;

        document.getElementById('nota-pajak').innerText = formatRupiah(pajak);
        document.getElementById('nota-total').innerText = formatRupiah(totalAkhir);
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

        // Tampilkan Pop-Up Sukses & Overlay Latar Belakang
        document.getElementById('popup-sukses').classList.remove('hidden');
        document.getElementById('popup-overlay').classList.remove('hidden');

        // Sembunyikan kembali Pop-Up setelah 2 detik, lalu RESET FORM OTOMATIS
        setTimeout(() => {
            document.getElementById('popup-sukses').classList.add('hidden');
            document.getElementById('popup-overlay').classList.add('hidden');

            // TRIGGER RESET FORM: Bersih total agar bisa mendata berkali-kali tanpa refresh halaman!
            document.getElementById('input-nopol').value = "";
            document.getElementById('input-mobil').value = "";
            document.getElementById('input-nama').value = "";
            document.getElementById('input-wa').value = "";

            // Atur ulang state paket dan hilangkan highlight-nya
            paketTerpilihNama = "";
            paketTerpilihHarga = 0;
            document.getElementById('card-reguler').classList.remove('paket-active');
            document.getElementById('card-premium').classList.remove('paket-active');
            document.getElementById('card-coating').classList.remove('paket-active');

            // Uncheck semua add-ons
            document.querySelectorAll('input[name="addons"]:checked').forEach(addon => addon.checked = false);

            // Kembalikan kertas nota ke posisi awal
            hitungTransaksiRealtime();
        }, 2000);
    }
</script>
@endsection
