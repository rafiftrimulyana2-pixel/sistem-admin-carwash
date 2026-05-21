@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@700;800&display=swap" rel="stylesheet">

<style>
    /* Sembunyikan Header Bawaan Dashboard */
    header, .top-navigation, #header-dashboard { display: none !important; }

    /* Lock Viewport: Halaman pas di layar (No Scroll) */
    .admin-viewport {
        height: 100vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        background-color: #ffffff;
    }

    /* Sidebar tetap bisa di-scroll */
    .sidebar-container { overflow-y: auto; }

    .font-800 { font-weight: 800; }
    .font-700 { font-weight: 700; }

    /* Bentuk Kotak Sempurna */
    .sharp-box { border-radius: 0px !important; }

    /* Hilangkan panah di input angka */
    input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
</style>

<div class="admin-viewport" style="font-family: 'Inter', sans-serif;">

    <div class="w-full bg-gradient-to-r from-indigo-600 to-blue-500 px-10 py-5 border-b-4 border-blue-800 shadow-md">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-5">
                <div class="p-2 border-2 border-white/30 sharp-box">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <div>
                    <h1 class="text-lg font-800 text-white uppercase italic tracking-tighter">Registrasi Unit Carwash</h1>
                    <p class="text-[9px] font-700 text-blue-100 uppercase tracking-[0.4em] opacity-70">Sistem Input Antrean Digital</p>
                </div>
            </div>

            <div class="bg-black/20 px-5 py-2 border border-white/10 sharp-box flex items-center gap-3">
                <span class="text-[10px] font-800 text-emerald-400 uppercase tracking-widest italic animate-pulse">Ready to Input</span>
                <div class="w-2.5 h-2.5 bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,1)]"></div>
            </div>
        </div>
    </div>

    <div class="flex-grow flex items-center justify-center px-10">
        <div class="w-full max-w-6xl bg-white border-2 border-slate-200 p-10 sharp-box shadow-[20px_20px_0px_rgba(0,0,0,0.03)]">

            <form id="transaksiForm" action="#" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-12 gap-y-10">

                    <div class="space-y-3">
                        <label class="text-[11px] font-800 text-slate-400 uppercase tracking-widest">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" class="w-full px-4 py-3 bg-slate-50 border-b-2 border-slate-300 sharp-box outline-none font-700 text-sm focus:border-blue-600 transition-all" placeholder="Masukkan nama..." required>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[11px] font-800 text-slate-400 uppercase tracking-widest">Nomor Plat</label>
                        <input type="text" name="plat_nomor" class="w-full px-4 py-3 bg-slate-50 border-b-2 border-slate-300 sharp-box outline-none font-700 text-sm uppercase" placeholder="B 1234 ABC" required>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[11px] font-800 text-slate-400 uppercase tracking-widest">Jam Masuk</label>
                        <input type="time" name="jam_masuk" value="{{ date('H:i') }}" class="w-full px-4 py-3 bg-slate-50 border-b-2 border-slate-300 sharp-box outline-none font-700 text-sm cursor-pointer" required>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[11px] font-800 text-slate-400 uppercase tracking-widest">Kategori Unit</label>
                        <select name="jenis_kendaraan" class="w-full px-4 py-3 bg-slate-50 border-b-2 border-slate-300 sharp-box outline-none font-700 text-sm cursor-pointer">
                            <option value="Mobil">🚗 Mobil</option>
                            <option value="Motor">🏍️ Motor</option>
                        </select>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[11px] font-800 text-slate-400 uppercase tracking-widest">Paket Layanan</label>
                        <select name="paket_cuci" class="w-full px-4 py-3 bg-slate-50 border-b-2 border-slate-300 sharp-box outline-none font-700 text-sm cursor-pointer">
                            <option value="Cuci Salju">Cuci Salju</option>
                            <option value="Cuci Wax">Cuci Wax</option>
                            <option value="Full Service">Full Service</option>
                        </select>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[11px] font-800 text-blue-600 uppercase tracking-widest italic">Total Pembayaran</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3 font-800 text-blue-600 text-[11px]">Rp</span>
                            <input type="number" name="total_bayar" class="w-full pl-12 pr-4 py-3 bg-blue-50 border-b-2 border-blue-600 sharp-box outline-none font-800 text-lg text-slate-800" placeholder="0" required>
                        </div>
                    </div>
                </div>

                <div class="mt-12 flex items-center justify-end gap-5">
                    <button type="reset" class="px-8 py-3 bg-slate-100 hover:bg-slate-200 text-slate-500 font-800 text-[10px] uppercase sharp-box tracking-widest transition-all">
                        Reset Form
                    </button>
                    <button type="submit" class="px-14 py-4 bg-blue-600 hover:bg-blue-700 text-white font-800 uppercase italic tracking-[0.2em] text-[11px] sharp-box shadow-xl shadow-blue-200 transition-all active:scale-95">
                        Simpan Transaksi & Lanjut →
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('transaksiForm').addEventListener('submit', function(e) {
        // Reset otomatis agar admin bisa input terus tanpa pindah halaman/scroll
        setTimeout(() => {
            this.reset();
            document.getElementsByName('nama_pelanggan')[0].focus();
        }, 500);
    });
</script>
@endsection
