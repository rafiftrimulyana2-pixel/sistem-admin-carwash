@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    * { font-family: 'Inter', sans-serif !important; }
    .custom-scroll::-webkit-scrollbar { width: 5px; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>

<div class="booking-scope w-full h-[calc(100vh-2px)] bg-[#f4f7fb] flex flex-col overflow-hidden text-slate-700">
    <div class="w-full bg-blue-600 border-b border-blue-700 px-6 py-3.5 flex justify-between items-center shadow-md z-20"><div>
        <h1 class="text-white text-sm font-black uppercase tracking-tight">SISTEM MANAJEMEN BOOKING KALENDER</h1>
            <p class="text-blue-100 text-[9px] font-bold uppercase tracking-wider mt-0.5">Penjadwalan Customer, Monitoring Slot, & Validasi Ketersediaan Jadwal</p>
                        </div>
                        </div>
                    <div class="flex-1 overflow-y-auto p-5 custom-scroll bg-[#f4f7fb]">
                <div class="grid grid-cols-12 gap-8 max-w-[1600px] mx-auto">
            <div class="col-span-8">
        <div class="bg-white rounded-[2rem] border border-slate-200 overflow-hidden">

        <!-- HEADER -->
        <div class="px-6 pt-6 pb-1">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-4">
                    <!-- Ikon Mengambang -->
                    <div class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <i data-lucide="calendar-days" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <!-- Teks Biru -->
                        <h2 class="text-[11px] font-black uppercase tracking-[0.2em] text-blue-600">Sistem Penjadwalan & Operasional</h2>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Kelola slot harian customer dengan integrasi database realtime</p>
                    </div>
                </div>

                <!-- Filter JUNI 2026 Biru & Rapat -->
                <div class="flex items-center gap-2 bg-blue-600 text-white border border-blue-600 p-1 rounded-xl shadow-sm">
                    <button class="p-1.5 hover:bg-blue-50 rounded-lg transition-all"><i data-lucide="chevron-left" class="w-4 h-4"></i></button>
                    <!-- Teks di tengah & sejajar -->
                    <span class="text-[9px] font-black uppercase tracking-widest text-center w-20">JUNI 2026</span>
                    <button class="p-1.5 hover:bg-blue-50 rounded-lg transition-all"><i data-lucide="chevron-right" class="w-4 h-4"></i></button>
                </div>
            </div>
        </div>

        <div class="w-full h-1 bg-blue-600"></div>
            <div class="px-8 pt-6 pb-8">
                <div class="grid grid-cols-7 gap-3 mb-4">
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $d)
                        <div class="text-[9px] font-black {{ $d=='Minggu' ? 'text-rose-500' : 'text-slate-400' }} uppercase text-center pb-2">{{$d}}</div>
                    @endforeach
                </div>
                    <div class="grid grid-cols-7 gap-3" id="calendar-grid">
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-4 space-y-6">

    <!-- Card Ringkasan: Statis dan rata (tanpa shadow mengambang) -->
    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-8 rounded-[2rem] text-white">
        <div class="flex items-center gap-3 mb-6">

            <!-- Ikon tetap di kotak putih -->
            <div class="p-2 bg-white rounded-xl">
                <i data-lucide="bar-chart-3" class="w-5 h-5 text-blue-600"></i>
                </div>
            <h3 class="font-black text-sm uppercase tracking-widest">Ringkasan Operasional</h3>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Kotak Putih: Teks Biru -->
            <div class="bg-white p-5 rounded-2xl border border-blue-100">
                <p class="text-[9px] uppercase font-black mb-1 text-blue-400">Slot Tersedia</p>
                <h4 id="stat-avail" class="text-2xl font-black text-blue-600">15</h4>
                <p class="text-[8px] mt-1 italic text-blue-300">Update realtime</p>
            </div>

            <!-- Kotak Putih: Teks Biru -->
            <div class="bg-white p-5 rounded-2xl border border-blue-100">
                <p class="text-[9px] uppercase font-black mb-1 text-blue-400">Booking Aktif</p>
                <h4 id="stat-active" class="text-2xl font-black text-blue-600">0</h4>
                <p class="text-[8px] mt-1 italic text-blue-300">Perlu konfirmasi</p>
            </div>
        </div>
    </div>

    <!-- KONTEN LIST BOOKING -->
    <div class="bg-white p-8 rounded-[2rem] shadow-[0_10px_30px_-10px_rgba(0,0,0,0.1)] border border-slate-100">
        <div class="flex flex-col items-center justify-center gap-3 mb-8">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl shadow-inner"><i data-lucide="clipboard-list" class="w-5 h-5"></i></div>
            <h3 class="font-black text-[10px] uppercase tracking-[0.2em] text-slate-800">List Booking Terbaru</h3>
        </div>
        <div id="booking-list" class="space-y-4 max-h-[300px] overflow-y-auto custom-scroll"></div>
    </div>

    <!-- MODAL VERIFIKASI LENGKAP -->
    <div id="modal-verifikasi" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center z-50 p-2">
        <div class="bg-white p-6 rounded-[2rem] w-[450px] shadow-2xl space-y-2">
            <h3 class="font-black text-slate-800 text-center uppercase tracking-widest text-sm border-b pb-3 flex items-center justify-center gap-2">
                <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i> Form Data Pemesanan
            </h3>

            <div id="modal-body" class="space-y-3 text-[10px] text-slate-600 font-bold bg-slate-50 p-3 rounded-2xl">
                <div class="flex items-center gap-3"><i data-lucide="user" class="w-4 h-4 text-blue-600"></i> <span id="m-name">Nama: -</span></div>
                <div class="flex items-center gap-3"><i data-lucide="map-pin" class="w-4 h-4 text-blue-600"></i> <span id="m-loc">Alamat: -</span></div>
                <div class="flex items-center gap-3"><i data-lucide="phone" class="w-4 h-4 text-blue-600"></i> <span id="m-wa">WhatsApp: -</span></div>
                <div class="flex items-center gap-3"><i data-lucide="barcode" class="w-4 h-4 text-blue-600"></i> <span id="m-code">Kode: -</span></div>
                <div class="flex items-center gap-3"><i data-lucide="car" class="w-4 h-4 text-blue-600"></i> <span id="m-car">Mobil: -</span></div>
                <div class="flex items-center gap-3"><i data-lucide="zap" class="w-4 h-4 text-blue-600"></i> <span id="m-serv">Layanan: -</span></div>
                <div class="flex items-center gap-3 border-t pt-3 mt-2"><i data-lucide="credit-card" class="w-4 h-4 text-emerald-600"></i> <span id="m-price" class="text-emerald-600">Harga: -</span></div>
            </div>

            <textarea id="catatan-tolak" class="w-full p-3 border-2 border-slate-200 rounded-xl text-xs font-bold hidden focus:border-blue-500 outline-none" placeholder="Tulis alasan penolakan..."></textarea>
                <div class="flex gap-2 mt-6">
                    <button id="btn-terima" class="flex-1 py-3 bg-blue-600 text-white font-black rounded-xl text-[10px] hover:bg-blue-700 shadow-lg transition-all">KONFIRMASI</button>
                <button id="btn-tolak" class="flex-1 py-3 bg-slate-100 text-slate-700 font-black rounded-xl text-[10px] hover:bg-rose-500 hover:text-white transition-all">TOLAK PEMESANAN</button>
            </div>

<script>
    // Mengambil data dari Laravel langsung ke JS
    let bookings = @json($bookings);

    function renderList() {
        const listContainer = document.getElementById('booking-list');
        listContainer.innerHTML = bookings.map(b => `
            <div class="p-4 bg-white ...">
                <p>${b.nama_pelanggan}</p> <button onclick="bukaModal(${b.id})">Verifikasi</button>
            </div>
        `).join('');
    }

    function renderList() {
        const listContainer = document.getElementById('booking-list');
        listContainer.innerHTML = bookings.map(b => `
            <div class="p-4 bg-white rounded-2xl border border-slate-100">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl ${b.color} text-white flex items-center justify-center font-black text-xs">${b.initials}</div>
                    <div class="flex-1">
                        <p class="text-[11px] font-black text-slate-800 uppercase">${b.name}</p>
                        <p class="text-[9px] font-bold text-slate-400">${b.car} - ${b.time}</p>
                    </div>
                </div>
                <!-- Tombol Biru Konsisten -->
                <button onclick="bukaModal(${b.id})" class="w-full mt-4 py-2 bg-blue-600 text-white text-[9px] font-black rounded-xl uppercase hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20">
                    Verifikasi Data
                </button>
            </div>
        `).join('');
        lucide.createIcons();
    }

    // Fungsi untuk memanggil modal dengan data lengkap
    function bukaModal(id) {
        let b = bookings.find(x => x.id === id);
        let modal = document.getElementById('modal-verifikasi');
        let catatanArea = document.getElementById('catatan-tolak');
        let btnTolak = document.getElementById('btn-tolak');

        // Reset state modal
        catatanArea.classList.add('hidden');
        btnTolak.innerText = "TOLAK PEMESANAN";

        // Mengisi data ke elemen modal
        document.getElementById('m-name').innerText = "Nama: " + b.name;
        document.getElementById('m-loc').innerText = "Alamat: " + b.location;
        document.getElementById('m-wa').innerText = "WhatsApp: " + b.wa;
        document.getElementById('m-code').innerText = "Kode: " + b.code;
        document.getElementById('m-car').innerText = "Mobil: " + b.car;
        document.getElementById('m-serv').innerText = "Layanan: " + b.service;
        document.getElementById('m-price').innerText = "Harga: " + b.price;

        document.getElementById('btn-terima').onclick = () => aksi(id, 'Diterima');
        document.getElementById('btn-tolak').onclick = () => {
            // Jika textarea masih hidden, maka munculkan
            if (catatanArea.classList.contains('hidden')) {
                catatanArea.classList.remove('hidden');
                btnTolak.innerText = "KIRIM PENOLAKAN"; // Tombol berubah fungsi
                catatanArea.focus();
            } else {
                // Jika sudah terlihat, berarti Admin sudah menulis dan menekan tombol kirim
                if(catatanArea.value.trim() === "") {
                    alert("Mohon tuliskan alasan penolakan!");
                    return;
                }
                aksi(id, 'Ditolak', catatanArea.value);
            }
        };

        modal.classList.remove('hidden');
        lucide.createIcons();
    }

    let currentMonth = new Date();

    // Fungsi Update Navigasi
    function changeMonth(offset) {
        currentMonth.setMonth(currentMonth.getMonth() + offset);
        document.getElementById('month-display').innerText = currentMonth.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' }).toUpperCase();
        renderSystem();
    }

    // Fungsi Aksi Selesai
    async function aksi(id, status, pesan = "") {
        if (status === 'Diterima') {
            try {
                const response = await fetch(`/verify-booking/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                });

                if (response.ok) {
                    // Setelah status diubah di database, arahkan ke halaman transaksi
                    // dengan membawa ID booking agar form terisi otomatis
                    window.location.href = `/input-transaksi/booking/${id}`;
                }
            } catch (e) {
                alert("Gagal memproses booking.");
            }
        } else {
            // Logika Tolak
            console.log("Menolak booking:", pesan);
            alert("Booking ditolak: " + pesan);
            location.reload();
        }
    }

    // 3. Fungsi Render Kalender
    function renderSystem() {
        const grid = document.getElementById('calendar-grid');
        if (!grid) return;
        grid.innerHTML = Array.from({length: 30}, (_, i) => i + 1).map(d => `
            <div class="h-28 p-3 rounded-2xl border bg-slate-50 flex flex-col justify-between">
                <span class="text-xs font-black text-slate-600">${d}</span>
                <span class="text-[8px] font-black uppercase text-emerald-500">OPEN</span>
            </div>
        `).join('');
    }

    // Render List (Contoh jika ada data)
        document.getElementById('booking-list').innerHTML = `
            <div class="p-4 border rounded-2xl">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center font-black text-[10px]">BS</div>
                    <div>
                        <p class="text-[10px] font-black">BUDI SANTOSO</p>
                        <p class="text-[8px] text-slate-400">Toyota Avanza - 09:00</p>
                    </div>
                </div>
                <button class="w-full mt-3 py-2 bg-blue-600 text-white text-[9px] font-black rounded-lg">VERIFIKASI DATA</button>
            </div>
        `;

        // PENTING: Panggil ini agar ikon muncul kembali
        lucide.createIcons();

    // 4. GABUNGKAN KEDUA FUNGSI SAAT HALAMAN DIMUAT
    document.addEventListener("DOMContentLoaded", () => {
        renderSystem(); // Render Kalender
        renderList();   // Render Daftar Booking
        lucide.createIcons(); // Inisialisasi ikon
    });
</script>
@endsection
