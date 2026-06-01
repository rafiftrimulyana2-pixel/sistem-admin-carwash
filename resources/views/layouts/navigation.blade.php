<aside class="w-64 bg-white border-r border-slate-100 h-screen flex flex-col shadow-sm fixed left-0 top-0">

    <!-- Logo Section - Tetap Diam -->
    <div class="p-8 border-b border-slate-50 flex items-center justify-center shrink-0">
        <div class="font-black text-blue-600 text-lg tracking-tighter uppercase flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-blue-200 shadow-lg">
                <i data-lucide="shield-check" class="w-5 h-5 text-white"></i>
            </div>
            <span class="text-slate-800">ADMIN</span>
        </div>
    </div>

    <!-- Container Menu - Scrollable tapi tanpa scrollbar -->
    <div class="flex-1 px-4 py-6 space-y-8 overflow-y-auto no-scrollbar">

        <!-- KATEGORI MENU -->
        <div>
            <p class="px-4 text-[9px] font-black uppercase tracking-[0.2em] text-slate-300 mb-3">Menu Utama</p>
            <div class="space-y-1">
                @foreach([
                    ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard'],
                    ['route' => 'status-progress.index', 'label' => 'Status Progress', 'icon' => 'loader-2'],
                    ['route' => 'booking.calendar', 'label' => 'Booking Calendar', 'icon' => 'calendar-days']
                ] as $menu)
                <a href="{{ route($menu['route']) }}" class="{{ request()->routeIs($menu['route']) ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-500 hover:bg-blue-50' }} flex items-center px-4 py-3 rounded-xl transition-all duration-200">
                    <i data-lucide="{{ $menu['icon'] }}" class="w-5 h-5 mr-3"></i>
                    <span class="text-xs font-bold">{{ $menu['label'] }}</span>
                </a>
                @endforeach
            </div>
        </div>

        <!-- TRANSAKSI -->
        <div>
            <p class="px-4 text-[9px] font-black uppercase tracking-[0.2em] text-slate-300 mb-3">Transaksi</p>
            <div class="space-y-1">
                @foreach([
                    ['route' => 'input.transaksi', 'label' => 'Input Transaksi', 'icon' => 'credit-card'],
                    ['route' => 'riwayat.servis', 'label' => 'Riwayat Servis', 'icon' => 'history'],
                    ['route' => 'laporan.pendapatan', 'label' => 'Laporan Pendapatan', 'icon' => 'pie-chart']
                ] as $menu)
                <a href="{{ route($menu['route']) }}" class="{{ request()->routeIs($menu['route']) ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-500 hover:bg-blue-50' }} flex items-center px-4 py-3 rounded-xl transition-all duration-200">
                    <i data-lucide="{{ $menu['icon'] }}" class="w-5 h-5 mr-3"></i>
                    <span class="text-xs font-bold">{{ $menu['label'] }}</span>
                </a>
                @endforeach
            </div>
        </div>

        <!-- MANAJEMEN -->
        <div>
            <p class="px-4 text-[9px] font-black uppercase tracking-[0.2em] text-slate-300 mb-3">Manajemen</p>
            <div class="space-y-1">
                @foreach([
                    ['route' => 'jadwal.mekanik', 'label' => 'Jadwal Mekanik', 'icon' => 'users'],
                    ['route' => 'stok.bahan', 'label' => 'Stok Bahan', 'icon' => 'package']
                ] as $menu)
                <a href="{{ route($menu['route']) }}" class="{{ request()->routeIs($menu['route']) ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-500 hover:bg-blue-50' }} flex items-center px-4 py-3 rounded-xl transition-all duration-200">
                    <i data-lucide="{{ $menu['icon'] }}" class="w-5 h-5 mr-3"></i>
                    <span class="text-xs font-bold">{{ $menu['label'] }}</span>
                </a>
                @endforeach
            </div>
        </div>

    </div>
</aside>

<style>
    /* Hapus scrollbar di mana pun ia muncul */
    * {
        scrollbar-width: none !important;
    }
    *::-webkit-scrollbar {
        display: none !important;
    }

    /* Kunci layar utama agar tidak ada scrollbar browser */
    html, body {
        overflow: hidden !important;
        height: 100vh !important;
    }
</style>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
