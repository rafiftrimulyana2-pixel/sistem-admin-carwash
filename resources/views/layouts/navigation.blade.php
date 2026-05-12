<aside class="w-54 bg-white border-r border-gray-100 min-h-screen flex flex-col shadow-sm">

    <!-- Logo Section -->
    <div class="p-6 flex items-center justify-center border-b border-gray-20">
        <div class="font-black text-blue-600 text-lg tracking-tighter uppercase">
            Admin<span class="text-gray-800"></span>
        </div>
    </div>

    <div class="flex-1 px-4 py-6 space-y-6 overflow-y-auto custom-scrollbar">

        <!-- KATEGORI: MENU UTAMA -->
        <div>
            <p class="px-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-3">Menu Utama</p>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-500' }} group flex items-center px-4 py-3 rounded-xl transition-all duration-300">
                    <svg class="w-5 h-5 mr-3 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="text-sm">Dashboard</span>
                </a>
                <a href="{{ route('status-progress.index') }}" class="{{ request()->routeIs('status.progres') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50' }} group flex items-center px-4 py-3 rounded-2xl transition-all duration-300">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <span class="text-sm">Status Progress</span>
                </a>
                <a href="{{ route('booking.calendar') }}" class="{{ request()->routeIs('booking.calendar') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50' }} group flex items-center px-4 py-3 rounded-2xl transition-all duration-300">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="text-sm">Booking Calendar</span>
                </a>
            </div>
        </div>

        <!-- KATEGORI: TRANSAKSI -->
        <div>
            <p class="px-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-3">Transaksi</p>
            <div class="space-y-1">
                <a href="{{ route('input.transaksi') }}" class="{{ request()->routeIs('input.transaksi') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50' }} group flex items-center px-4 py-3 rounded-2xl transition-all duration-300">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-sm">Input Transaksi</span>
                </a>
                <a href="{{ route('riwayat.servis') }}" class="{{ request()->routeIs('riwayat.servis') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50' }} group flex items-center px-4 py-3 rounded-2xl transition-all duration-300">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-sm">Riwayat Servis</span>
                </a>
                <a href="{{ route('laporan.pendapatan') }}" class="{{ request()->routeIs('laporan.pendapatan') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50' }} group flex items-center px-4 py-3 rounded-2xl transition-all duration-300">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span class="text-sm">Laporan Pendapatan</span>
                </a>
            </div>
        </div>

        <!-- KATEGORI: MANAJEMEN -->
        <div>
            <p class="px-4 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-3">Manajemen</p>
            <div class="space-y-1">
                <a href="{{ route('jadwal.mekanik') }}" class="{{ request()->routeIs('jadwal.mekanik') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50' }} group flex items-center px-4 py-3 rounded-2xl transition-all duration-300">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="text-sm">Jadwal Mekanik</span>
                </a>
                <a href="{{ route('stok.bahan') }}" class="{{ request()->routeIs('stok.bahan') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:bg-slate-50' }} group flex items-center px-4 py-3 rounded-2xl transition-all duration-300">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span class="text-sm">Stok Bahan</span>
                </a>
            </div>
        </div>

    </div>
</aside>
