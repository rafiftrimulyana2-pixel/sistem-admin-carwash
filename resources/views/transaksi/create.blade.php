<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Unit - Carwash System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-black { font-weight: 900; }
        .font-bold { font-weight: 700; }
        /* Animasi halus untuk hover */
        .hover-card:hover { transform: translateY(-5px); transition: all 0.3s ease; }
    </style>
</head>
<body class="bg-white antialiased min-h-screen flex flex-col">

    <!-- 1. HEADER: Warna Hidup dengan Gradasi Hidup -->
    <div class="relative w-full bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-700 pt-16 pb-40 overflow-hidden shrink-0">

        <!-- Ornamen Cahaya agar Terlihat Hidup -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 blur-[100px] rounded-full"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-cyan-400/20 blur-[80px] rounded-full"></div>

        <div class="relative z-10 max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="text-white text-4xl md:text-5xl font-black tracking-tight leading-none">Pendaftaran Unit</h2>
                <div class="flex items-center space-x-3 mt-4">
                    <span class="h-1 w-10 bg-cyan-300 rounded-full"></span>
                    <p class="text-[12px] font-bold text-blue-50 uppercase tracking-[0.4em]">Sistem Manajemen Carwash</p>
                </div>
            </div>

            <a href="/dashboard" class="inline-flex items-center px-6 py-3 bg-white/10 backdrop-blur-lg border border-white/20 text-white rounded-2xl text-[11px] font-bold uppercase tracking-widest hover:bg-white hover:text-blue-600 transition-all duration-300 shadow-xl">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>

        <!-- Ombak Variatif -->
        <div class="absolute bottom-0 left-0 w-full leading-[0]">
            <svg viewBox="0 0 1440 200" class="w-full h-auto fill-white">
                <path d="M0,128L48,122.7C96,117,192,107,288,112C384,117,480,139,576,144C672,149,768,139,864,128C960,117,1056,107,1152,101.3C1248,96,1344,96,1392,96L1440,96L1440,200L1392,200C1344,200,1248,200,1152,200C1056,200,960,200,864,200C768,200,672,200,576,200C480,200,384,200,288,200C192,200,96,200,48,200L0,200Z"></path>
            </svg>
        </div>
    </div>

    <!-- MAIN CARD -->
        <div class="glass-card overflow-hidden">
            <!-- Aksen Garis Atas -->
            <div class="h-2 w-full bg-gradient-to-r from-cyan-400 via-blue-500 to-indigo-600"></div>

            <div class="p-10">
                <!-- GRID HORIZONTAL: Agar tidak memanjang ke bawah -->
                <div class="flex flex-wrap lg:flex-nowrap gap-10">

                    <!-- SEKSI DATA PELANGGAN (Kiri) -->
                    <div class="w-full lg:w-1/2 space-y-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-1.5 h-6 bg-blue-600 rounded-full shadow-lg shadow-blue-500/50"></div>
                            <h4 class="text-[11px] font-black text-slate-800 uppercase tracking-widest">Informasi Pelanggan</h4>
                        </div>

                        <div class="grid grid-cols-1 gap-5">
                            <div class="relative">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest absolute -top-2 left-4 bg-white px-2 z-10">Nama Pemilik</label>
                                <input type="text" placeholder="Masukkan nama lengkap..."
                                    class="w-full px-5 py-4 border-2 border-slate-100 rounded-[20px] text-sm font-bold text-slate-700 outline-none focus:border-blue-600 transition-all">
                            </div>

                            <div class="relative">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest absolute -top-2 left-4 bg-white px-2 z-10">Nomor Plat Kendaraan</label>
                                <input type="text" placeholder="B 1234 ABC"
                                    class="w-full px-5 py-4 border-2 border-slate-100 rounded-[20px] text-sm font-bold text-slate-700 outline-none focus:border-blue-600 transition-all uppercase tracking-widest">
                                <span class="absolute right-5 top-1/2 -translate-y-1/2 text-[8px] font-black text-blue-600 opacity-40">POLRI</span>
                            </div>
                        </div>
                    </div>

                    <!-- SEKSI LAYANAN (Kanan) -->
                    <div class="w-full lg:w-1/2 space-y-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-1.5 h-6 bg-blue-600 rounded-full shadow-lg shadow-blue-500/50"></div>
                            <h4 class="text-[11px] font-black text-slate-800 uppercase tracking-widest">Pilihan Layanan</h4>
                        </div>

                        <div class="grid grid-cols-1 gap-5">
                            <!-- Radio Button Horizontal -->
                            <div class="flex p-1.5 bg-slate-100 rounded-[22px] border border-slate-200">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="unit" class="peer hidden" checked>
                                    <div class="py-3 text-center rounded-[18px] text-[10px] font-black text-slate-500 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:shadow-lg transition-all uppercase tracking-widest">Mobil</div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="unit" class="peer hidden">
                                    <div class="py-3 text-center rounded-[18px] text-[10px] font-black text-slate-500 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:shadow-lg transition-all uppercase tracking-widest">Motor</div>
                                </label>
                            </div>

                            <div class="relative">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest absolute -top-2 left-4 bg-white px-2 z-10">Jenis Paket</label>
                                <select class="w-full px-5 py-4 border-2 border-slate-100 rounded-[20px] text-sm font-bold text-slate-700 outline-none cursor-pointer focus:border-blue-600 appearance-none bg-white">
                                    <option>Reguler (Cuci + Pengeringan)</option>
                                    <option>Premium (Wax + Polish)</option>
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FOOTER TOTAL & SIMPAN -->
                <div class="mt-12 flex items-center justify-between border-t border-slate-100 pt-8">
                    <div class="flex items-center gap-6">
                        <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100 flex items-center gap-4">
                            <div>
                                <p class="text-[8px] font-black text-blue-400 uppercase tracking-widest">Total Bayar</p>
                                <h3 class="text-3xl font-black text-blue-600 mt-1 leading-none">Rp 45.000</h3>
                            </div>
                            <div class="w-px h-10 bg-blue-200"></div>
                            <span class="text-[8px] font-black text-emerald-500 uppercase tracking-widest">Status: Ready</span>
                        </div>
                    </div>

                    <button class="px-12 py-5 bg-blue-600 text-white rounded-[24px] font-black text-[11px] uppercase tracking-[0.2em] shadow-2xl shadow-blue-500/40 hover:-translate-y-1 active:scale-95 transition-all">
                        Simpan Transaksi
                    </button>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
