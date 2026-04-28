<nav class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <div class="flex items-center">
                <div class="shrink-0 flex items-center font-black text-blue-600 text-2xl tracking-tighter">
                    CARWASH<span class="text-gray-800">MODERN</span>
                </div>
            </div>

            <div class="flex items-center ml-6">
                <div class="text-right mr-6">
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Admin Aktif</p>
                    <p class="text-sm font-black text-gray-800">{{ Auth::user()->name }}</p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest transition duration-200">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
