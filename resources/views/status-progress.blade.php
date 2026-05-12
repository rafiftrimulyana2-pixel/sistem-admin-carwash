<x-app-layout>
    <div class="flex min-h-screen bg-slate-50">
        <aside class="fixed h-screen">
            @include('layouts.navigation')
        </aside>

        <main class="flex-1 ml-64 p-10">
            <div class="mb-10">
                <h1 class="text-3xl font-black text-slate-800 uppercase italic tracking-tighter">Status Progres Unit</h1>
                <div class="w-20 h-2 bg-blue-600 mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($antreanAktif as $item)
                <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.05)] transition-all hover:scale-[1.02]">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-3 py-1 rounded-lg uppercase italic">{{ $item->plat_nomor }}</span>
                            <h3 class="text-2xl font-black text-slate-800 uppercase mt-4 italic">{{ $item->nama_pelanggan }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                            <i class="fas fa-sync-alt {{ $item->progres > 0 ? 'fa-spin' : '' }}"></i>
                        </div>
                    </div>

                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-6 italic">Layanan: {{ $item->jenis_paket }}</p>

                    <div class="space-y-3">
                        <div class="flex justify-between text-[10px] font-black text-slate-400 uppercase italic">
                            <span>Progress</span>
                            <span class="text-blue-600">{{ $item->progres }}%</span>
                        </div>
                        <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-600 rounded-full shadow-[0_0_10px_rgba(37,99,235,0.4)]" style="width: {{ $item->progres }}%"></div>
                        </div>
                    </div>

                    <p class="mt-6 text-[10px] font-black text-slate-400 uppercase italic">{{ $item->status }}</p>
                </div>
                @endforeach
            </div>
        </main>
    </div>
</x-app-layout>
