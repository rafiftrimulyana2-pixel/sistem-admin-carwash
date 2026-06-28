@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    * { font-family: 'Inter', sans-serif; }
    .kasir-scope { font-weight: 700 !important; }
    .form-scroll-clean::-webkit-scrollbar { display: none !important; }
    .animate-popup { animation: popIn 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
    @keyframes popIn { 0% { transform: scale(0.9); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
</style>

{{-- HEADER DENGAN GAYA PERSIS RIWAYAT SERVIS --}}
<div class="w-full bg-blue-600 border-b border-blue-700 shadow-md shadow-slate-900/10 z-20 mb-1">
    <div class="max-w-5xl mx-auto px-6 py-3.5 flex justify-between items-center">
        <div class="flex flex-col gap-0.5">
            {{-- Teks judul dengan tracking yang lebih longgar agar tidak mepet --}}
            <h1 class="text-white text-sm font-black uppercase tracking-widest leading-tight">
                REGISTRASI & DOKUMENTASI ORDER BARU
            </h1>
            <p class="text-blue-100 text-[9px] font-bold uppercase tracking-wider mt-0.5">
                Sistem Pencatatan Pembayaran & Transaksi Pelanggan Realtime
            </p>
        </div>

        <div class="bg-white/10 border border-white/20 px-3 py-1.5 rounded-xl text-white text-[10px] font-black uppercase tracking-wide">
            Shift Kerja: <span id="live-shift-kerja" class="text-amber-300 font-black">Aktif</span>
        </div>
    </div>
</div>

<div class="flex-1 overflow-y-auto p-4 form-scroll-clean bg-[#f4f7fb]">
    <form id="main-form-transaksi" class="max-w-5xl mx-auto">
        @csrf

        {{-- BAGIAN 1: IDENTITAS --}}
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <div class="flex items-center gap-2 mb-5 border-b border-slate-100 pb-3">
                <div class="p-1.5 rounded-lg bg-blue-600 text-white font-black text-[9px] px-2">01</div>
                <h3 class="text-[10px] font-black text-slate-800 uppercase tracking-widest">Informasi Identitas Pelanggan</h3>
            </div>

            <div class="grid grid-cols-2 gap-4">
                @foreach(['plat_nomor' => 'Nomor Polisi Kendaraan', 'jenis_kendaraan' => 'Tipe / Model Mobil', 'nama_pelanggan' => 'Nama Pelanggan', 'no_hp' => 'Nomor WhatsApp'] as $name => $label)
    <div class="flex flex-col gap-1.5">
        <label class="text-[8px] font-black text-slate-400 uppercase tracking-wider">{{ $label }} *</label>
        {{-- Atribut name di sini menggunakan $name dari array di atas --}}
        <input type="{{ $name == 'no_hp' ? 'number' : 'text' }}"
               name="{{ $name }}"
               required
               placeholder="Contoh input..."
               class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-[10px] font-bold text-slate-800 focus:outline-none focus:border-blue-500 shadow-inner transition-all">
    </div>
@endforeach
            </div>
        </div>

        {{-- BAGIAN 2: KALKULATOR (Ditambahkan mt-6 agar berjarak dengan bagian 1) --}}
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm mt-6">
            <div class="flex items-center gap-2 mb-5 border-b border-slate-100 pb-3">
                <div class="p-1.5 rounded-lg bg-blue-600 text-white font-black text-[9px] px-2">02</div>
                <h3 class="text-[10px] font-black text-slate-800 uppercase tracking-widest">Kalkulator Pembayaran</h3>
            </div>

            <div class="grid grid-cols-3 gap-4">
    <div>
        <label class="text-[8px] font-black text-slate-400 uppercase tracking-wider">Total Tagihan (Rp)</label>
        {{-- Tambahkan name="total_bayar" agar terbaca controller --}}
        <input type="number" name="total_bayar" id="total-tagihan" oninput="hitungKembalian()" class="w-full h-10 bg-slate-50 border border-slate-200 rounded-lg px-3 text-[10px] font-black text-blue-600 outline-none shadow-inner">
    </div>
    <div>
        <label class="text-[8px] font-black text-slate-400 uppercase tracking-wider">Uang Diterima (Rp)</label>
        <input type="number" id="uang-diterima" oninput="hitungKembalian()" class="w-full h-10 bg-white border-2 border-blue-600 rounded-lg px-3 text-[10px] font-black text-slate-900 outline-none shadow-inner">
    </div>
    <div>
        <label class="text-[8px] font-black text-slate-400 uppercase tracking-wider">Kembalian (Rp)</label>
        <input type="text" id="uang-kembali" readonly class="w-full h-10 bg-emerald-50 border border-emerald-100 rounded-lg px-3 text-[10px] font-black text-emerald-700 shadow-inner">
    </div>
</div>

<button type="button" onclick="prosesTransaksi()" class="w-full mt-5 h-10 bg-blue-600 text-white font-black rounded-lg hover:bg-blue-700 transition-all text-[9px] uppercase tracking-widest shadow-lg">
    PROSES TRANSAKSI
</button>
    </form>
</div>

<div id="popup-sukses" class="fixed inset-0 hidden items-center justify-center z-[100] p-4">
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-slate-900/30 backdrop-blur-sm transition-opacity duration-500"></div>

    {{-- Konten Pop-up --}}
    <div class="relative bg-white p-8 rounded-[2.5rem] shadow-[0_25px_50px_-12px_rgba(16,185,129,0.3)] w-full max-w-[320px] transform transition-all duration-500 scale-95 opacity-0 border border-emerald-50" id="popup-content">

        {{-- Ikon Animasi Hijau Hidup --}}
        <div class="relative w-20 h-20 mx-auto mb-6">
            <div class="absolute inset-0 bg-emerald-500/20 rounded-full animate-ping"></div>
            <div class="w-full h-full bg-emerald-500 rounded-full flex items-center justify-center shadow-lg shadow-emerald-500/40">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <div class="text-center">
            {{-- Teks Berhasil Hijau --}}
            <h2 class="text-2xl font-black text-emerald-600 uppercase tracking-[0.2em] mb-2">Success!</h2>

            {{-- Teks Bawah yang lebih friendly --}}
            <p class="text-[11px] font-bold text-slate-500 uppercase tracking-[0.1em] mb-8 leading-relaxed">
                Data pembayaran telah berhasil tersimpan <br> ke dalam sistem pusat.
            </p>

            {{-- Tombol Biru Hidup dengan Shadow Glow --}}
            <button onclick="tutupPopup()" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] transition-all hover:shadow-[0_10px_20px_-5px_rgba(37,99,235,0.6)] active:scale-95">
                Lanjutkan Input
            </button>
        </div>
    </div>
</div>

<script>
    function hitungKembalian() {
    let tagihan = document.getElementById('total-tagihan').value;
    let diterima = document.getElementById('uang-diterima').value;
    let kembali = diterima - tagihan;

    // Menampilkan angka dengan format Rupiah di input kembalian
    let nilaiKembali = kembali >= 0 ? kembali : 0;
    document.getElementById('uang-kembali').value = "Rp " + Number(nilaiKembali).toLocaleString('id-ID');
    }

    // GABUNGKAN SEMUA LOGIKA DI SINI
    async function prosesTransaksi() {
        // 1. Ambil data dari form
        const form = document.getElementById('main-form-transaksi');
        const formData = new FormData(form);

        try {
            // 2. Kirim ke Server
            const response = await fetch("{{ route('input.transaksi.store') }}", {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });

            const result = await response.json();

            // 3. Jika berhasil, jalankan animasi pop-up
            if (result.success) {
                const popup = document.getElementById('popup-sukses');
                const content = document.getElementById('popup-content');

                popup.classList.remove('hidden');
                popup.classList.add('flex');

                // Trigger animasi halus
                setTimeout(() => {
                    content.classList.replace('scale-95', 'scale-100');
                    content.classList.replace('opacity-0', 'opacity-100');
                }, 50);
            } else {
                alert("Gagal: " + (result.message || "Data tidak lengkap"));
            }
        } catch (error) {
            console.error("Error:", error);
            alert("Terjadi kesalahan sistem, periksa database.");
        }
    }

    function tutupPopup() {
        const content = document.getElementById('popup-content');
        content.classList.replace('scale-100', 'scale-95');
        content.classList.replace('opacity-100', 'opacity-0');

        setTimeout(() => {
            window.location.reload();
        }, 300);
    }
</script>
@endsection
