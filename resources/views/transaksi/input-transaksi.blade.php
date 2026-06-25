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
                        <input type="{{ $name == 'no_hp' ? 'number' : 'text' }}" name="{{ $name }}" required placeholder="Contoh input..."
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
                    <input type="number" id="total-tagihan" oninput="hitungKembalian()" class="w-full h-10 bg-slate-50 border border-slate-200 rounded-lg px-3 text-[10px] font-black text-blue-600 outline-none shadow-inner">
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
        </div>
    </form>
</div>

{{-- POP-UP SUKSES --}}
<div id="popup-sukses" class="fixed inset-0 bg-slate-900/50 hidden items-center justify-center z-50">
    <div class="bg-white p-10 rounded-3xl animate-popup text-center shadow-2xl">
        <div class="text-6xl mb-4">✅</div>
        <h2 class="text-xl font-black uppercase text-slate-800">Transaksi Berhasil!</h2>
        <p class="text-xs font-bold text-slate-400 mb-8">Data sudah tersimpan ke sistem.</p>
        <button onclick="tutupPopup()" class="w-full py-4 bg-blue-600 text-white rounded-xl font-black text-xs uppercase">LANJUTKAN INPUT</button>
    </div>
</div>

<script>
    function hitungKembalian() {
        let tagihan = document.getElementById('total-tagihan').value;
        let diterima = document.getElementById('uang-diterima').value;
        let kembali = diterima - tagihan;
        document.getElementById('uang-kembali').value = kembali >= 0 ? kembali : 0;
    }
    function prosesTransaksi() {
        document.getElementById('popup-sukses').classList.remove('hidden');
        document.getElementById('popup-sukses').classList.add('flex');
    }
    function tutupPopup() {
        document.getElementById('popup-sukses').classList.add('hidden');
        document.getElementById('main-form-transaksi').reset();
        document.getElementById('uang-kembali').value = "";
    }
</script>
@endsection
