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
                <div class="p-1.5 rounded-lg bg-emerald-600 text-white font-black text-[9px] px-2">02</div>
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

{{-- POP-UP SUKSES MODERN --}}
<div id="popup-sukses" class="fixed inset-0 hidden items-center justify-center z-[100] backdrop-blur-sm bg-slate-900/40 transition-all duration-300">
    <div class="bg-white p-8 rounded-[2rem] shadow-[0_20px_50px_-12px_rgba(0,0,0,0.25)] border border-slate-100 animate-in zoom-in-95 fade-in duration-300 text-center max-w-xs w-full">

        {{-- Ikon Animasi --}}
        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-[bounce_1s_ease-in-out]">
            <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h2 class="text-lg font-black uppercase tracking-widest text-slate-800 mb-2">Transaksi Selesai!</h2>
        <p class="text-[11px] font-bold text-slate-400 mb-8 uppercase tracking-wider">Data telah terarsip ke sistem pusat.</p>

        <button onclick="tutupPopup()" class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-blue-600/20 transition-all active:scale-95">
            Lanjutkan Input
        </button>
    </div>
</div>

<script>
    function hitungKembalian() {
        let tagihan = document.getElementById('total-tagihan').value;
        let diterima = document.getElementById('uang-diterima').value;
        let kembali = diterima - tagihan;
        document.getElementById('uang-kembali').value = kembali >= 0 ? kembali : 0;
    }

    async function prosesTransaksi() {
        // 1. Ambil data dari form
        const form = document.getElementById('main-form-transaksi');
        const formData = new FormData(form);

        // 2. Kirim data ke Controller menggunakan fetch
        try {
            const response = await fetch("{{ route('input.transaksi.store') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const result = await response.json();

            // 3. Hanya munculkan popup JIKA server berhasil menyimpan data
            if (result.success) {
                document.getElementById('popup-sukses').classList.remove('hidden');
                document.getElementById('popup-sukses').classList.add('flex');
            } else {
                alert("Gagal menyimpan data: " + (result.message || "Terjadi kesalahan"));
            }
        } catch (error) {
            console.error("Error:", error);
            alert("Terjadi kesalahan sistem, pastikan koneksi database aman.");
        }
    }

    function tutupPopup() {
        // Reload agar data baru langsung masuk ke Dashboard/Riwayat
        window.location.reload();
    }
</script>
@endsection
