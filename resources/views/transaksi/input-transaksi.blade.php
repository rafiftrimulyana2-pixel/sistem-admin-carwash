@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    /* 1. Pengaturan Dasar */
    * { font-family: 'Inter', sans-serif; }
    .kasir-scope { font-weight: 700 !important; }

    /* 2. Pengaturan Pop-up (Tetap ada) */
    .animate-popup { animation: popIn 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
    @keyframes popIn { 0% { transform: scale(0.9); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }

    /* 3. Pengaturan Scrollbar (Diringkas agar efisien) */
    .custom-scroll::-webkit-scrollbar { width: 6px; }
    .custom-scroll::-webkit-scrollbar-track { background: #f1f5f9; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* 4. Pengaturan "Jebol" Scroll (PENTING)
       Kita gunakan ini agar halaman bisa geser tanpa terikat tinggi layar */
    html, body, main, .flex-1 {
        overflow: auto !important;
        height: auto !important;
        max-height: none !important;

        /* Paksa agar layout master tidak memotong konten */
        .overflow-hidden { overflow: visible !important; }
    }
    /* Tambahkan ini untuk sinkronisasi scrollbar */
    .custom-scroll::-webkit-scrollbar {
        width: 5px !important;
        height: 5px !important;
    }
    .custom-scroll::-webkit-scrollbar-track {
        background: #f1f5f9 !important;
    }
    .custom-scroll::-webkit-scrollbar-thumb {
        background: #c7d2fe !important; /* Biru muda keabu-abuan agar serasi */
        border-radius: 10px !important;
    }

    /* Menghilangkan efek warna merah/pink saat ada error validasi */
    input:invalid,
    input:focus:invalid {
        border-color: #e2e8f0; /* Kembali ke warna border slate-200 */
        box-shadow: none;      /* Menghilangkan shadow merah/pink */
    }

    /* Opsional: Menghilangkan ikon error default di browser */
    input::-webkit-credentials-auto-fill-button {
        visibility: hidden;
        display: none !important;
    }
</style>

<div class="w-full min-h-screen bg-[#f4f7fb] pb-16 flex-col items-center">

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

{{-- AREA KONTEN UTAMA --}}
<div class="w-full pb-16 px-4">
    <div class="max-w-5xl mx-auto"><form id="main-form-transaksi" class="mt-4">
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

{{-- BAGIAN 3: TABEL TRANSAKSI (Sesuai permintaan Anda) --}}
<div class="bg-white border border-slate-200 rounded-xl shadow-sm mt-8 overflow-hidden">
    {{-- Header Tabel --}}
    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
        <div class="p-1.5 rounded-lg bg-blue-600 text-white font-black text-[9px] px-2">03</div>
        <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-700">Daftar Transaksi Hari Ini</h3>
    </div>

    <table class="w-full text-left border-collapse text-[10px]">
        <thead class="bg-blue-600 text-white font-black">
            <tr>
                <th class="p-3 text-center">No</th>
                <th class="p-3 text-center">Nama</th>
                <th class="p-3 text-center">Plat</th>
                <th class="p-3 text-center">Metode</th>
                <th class="p-3 text-center">Waktu Masuk</th> <th class="p-3 text-right">Nominal</th>
                <th class="p-3 text-center">Status</th>
            </tr>
        </thead>
        <tbody id="tabel-transaksi-input" class="divide-y divide-slate-100 font-bold text-slate-700">
            @forelse(($transaksiHariIni ?? []) as $index => $t)
                <tr class="hover:bg-slate-50 transition-all">
                    <td class="p-3 text-center">{{ $index + 1 }}</td>
                    <td class="p-3 text-center">{{ $t->nama_pelanggan }}</td>
                    <td class="p-3 text-center uppercase">{{ $t->plat_nomor }}</td>
                    <td class="p-3 text-center text-blue-600 uppercase">{{ $t->metode_bayar ?? 'CASH' }}</td>
                    <td class="p-3 text-center font-bold text-slate-500">
                        {{ \Carbon\Carbon::parse($t->created_at)->format('H:i') }}
                    </td>
                    <td class="p-3 text-right">Rp {{ number_format($t->total_bayar) }}</td>
                    <td class="p-3 text-center">
                        <span class="inline-block px-3 py-1 bg-emerald-500 text-white font-black text-[9px] uppercase rounded-lg shadow-[0_2px_4px_rgba(0,0,0,0.15)]">
                            SELESAI
                        </span>
                    </td>
                </tr>
            @empty
                <tr id="empty-row">
                    <td colspan="7" class="p-8 text-center text-slate-400 italic">Belum ada transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

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
        let nilaiKembali = kembali >= 0 ? kembali : 0;
        document.getElementById('uang-kembali').value = "Rp " + Number(nilaiKembali).toLocaleString('id-ID');
    }
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

            // 3. Jika berhasil, update tabel DAN jalankan animasi pop-up
            if (result.success) {
                // A. Update Tabel
                console.log("Data berhasil diterima:", formData.get('nama_pelanggan'));
                const emptyRow = document.getElementById('empty-row');
                if (emptyRow) emptyRow.remove();

                const tbody = document.getElementById('tabel-transaksi-input');
                const newRow = document.createElement('tr'); // Tambahkan baris ini!
                newRow.innerHTML = `
                    <td class="p-3 text-center">-</td>
                    <td class="p-3 text-center">${formData.get('nama_pelanggan')}</td>
                    <td class="p-3 text-center uppercase">${formData.get('plat_nomor')}</td>
                    <td class="p-3 text-center text-blue-600">CASH</td>
                    <td class="p-3 text-center font-bold text-slate-500">${new Date().getHours()}:${new Date().getMinutes()}</td>
                    <td class="p-3 text-right">Rp ${Number(formData.get('total_bayar')).toLocaleString('id-ID')}</td>
                    <td class="p-3 text-center">
                        <span class="inline-block px-3 py-1 bg-emerald-400 text-white rounded-lg shadow-[0_2px_4px_rgba(0,0,0,0.15)] font-black text-[8px] uppercase">
                            SELESAI
                        </span>
                    </td>
                `;
                tbody.appendChild(newRow);

                // B. Jalankan Pop-up
                const popup = document.getElementById('popup-sukses');
                const content = document.getElementById('popup-content');

                popup.classList.remove('hidden');
                popup.classList.add('flex');
                setTimeout(() => {
                    content.classList.replace('scale-95', 'scale-100');
                    content.classList.replace('opacity-0', 'opacity-100');
                }, 50);

                form.reset();
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
        setTimeout(() => { window.location.reload(); }, 300);
    }
</script>
@endsection
