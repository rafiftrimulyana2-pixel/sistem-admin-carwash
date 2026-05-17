@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@700;800&display=swap" rel="stylesheet">

<div class="p-8 bg-slate-50 min-h-screen" style="font-family: 'Inter', sans-serif;">

    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
        <div>
            <h1 class="text-2xl font-800 text-slate-800 tracking-tighter uppercase italic">Status Progress</h1>
            <p class="text-[11px] font-700 text-slate-400 uppercase tracking-[0.2em]">Monitoring Antrean Real-Time</p>
        </div>

        <div class="flex items-center gap-3">
            <div class="flex bg-white p-1 rounded-xl shadow-sm border border-slate-200">
                <button class="px-6 py-2 bg-blue-600 text-white text-[11px] font-800 rounded-lg uppercase tracking-wider transition-all">Semua Unit</button>
                <button class="px-6 py-2 text-slate-400 text-[11px] font-800 hover:text-blue-600 rounded-lg uppercase tracking-wider transition-all">Sedang Dicuci</button>
                <button class="px-6 py-2 text-slate-400 text-[11px] font-800 hover:text-blue-600 rounded-lg uppercase tracking-wider transition-all">Selesai</button>
            </div>

            <div class="relative">
                <input type="text" placeholder="Cari Plat Nomor..." class="pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-700 outline-none focus:border-blue-500 w-64 shadow-sm">
                <svg class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="space-y-6 max-w-6xl">

        <div class="bg-white p-8 rounded-[30px] shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center">
                    <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                </div>

                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h3 class="text-xl font-800 text-slate-800">Rafliansyah</h3>
                        <span class="px-3 py-1 bg-blue-100 text-blue-600 text-[9px] font-800 uppercase tracking-widest rounded-md">PENGERINGAN</span>
                    </div>
                    <p class="text-slate-500 font-700 text-sm italic mb-2 tracking-tight uppercase">Honda HR-V <span class="text-slate-300">|</span> B 1234 ABC</p>
                    <div class="flex gap-2">
                        <span class="px-3 py-1 bg-slate-100 text-slate-400 text-[10px] font-800 rounded-md">FULL WASH + WAX</span>
                        <span class="flex items-center gap-1 text-slate-400 text-[10px] font-700"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> MASUK: 12:15 WIB</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-center gap-4">
                <div class="flex items-center">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white shadow-lg shadow-blue-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-[9px] font-800 text-blue-600 mt-2 uppercase tracking-tighter">Antrean</span>
                    </div>
                    <div class="w-16 h-1 bg-blue-600 rounded-full -mt-5 mx-1"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white shadow-lg shadow-blue-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-[9px] font-800 text-blue-600 mt-2 uppercase tracking-tighter">Cuci</span>
                    </div>
                    <div class="w-16 h-1 bg-blue-600 rounded-full -mt-5 mx-1"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white shadow-lg shadow-blue-200 border-4 border-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-[9px] font-800 text-blue-600 mt-2 uppercase tracking-tighter">Kering</span>
                    </div>
                    <div class="w-16 h-1 bg-slate-200 rounded-full -mt-5 mx-1"></div>
                    <div class="flex flex-col items-center opacity-30">
                        <div class="w-10 h-10 bg-white border-2 border-slate-200 rounded-full flex items-center justify-center">
                            <span class="text-slate-400 font-800 text-xs">4</span>
                        </div>
                        <span class="text-[9px] font-800 text-slate-400 mt-2 uppercase tracking-tighter">Finish</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-8">
                <div class="text-right">
                    <h4 class="text-3xl font-800 text-blue-600 leading-none">75%</h4>
                    <p class="text-[10px] font-800 text-slate-400 uppercase mt-1">Selesai</p>
                </div>
                <button class="text-slate-300 hover:text-slate-600"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 10a2 2 0 110 4 2 2 0 010-4zm0-6a2 2 0 110 4 2 2 0 010-4zm0 12a2 2 0 110 4 2 2 0 010-4z"></path></svg></button>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[30px] shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-slate-100 flex items-center justify-between opacity-90 hover:opacity-100 transition-all">
            <div class="flex items-center gap-8">
                <div class="w-20 h-20 bg-emerald-50 rounded-2xl flex items-center justify-center">
                    <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                </div>
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h3 class="text-xl font-800 text-slate-800">Siti Aminah</h3>
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-600 text-[9px] font-800 uppercase tracking-widest rounded-md">PENCUCIAN</span>
                    </div>
                    <p class="text-slate-500 font-700 text-sm italic mb-2 tracking-tight uppercase">Toyota Fortuner <span class="text-slate-300">|</span> F 999 SS</p>
                    <div class="flex gap-2">
                        <span class="px-3 py-1 bg-slate-100 text-slate-400 text-[10px] font-800 rounded-md">PREMIUM DETAILING</span>
                        <span class="flex items-center gap-1 text-slate-400 text-[10px] font-700"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> MASUK: 12:30 WIB</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-center gap-4">
                <div class="flex items-center">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-[9px] font-800 text-blue-600 mt-2 uppercase">Antrean</span>
                    </div>
                    <div class="w-16 h-1 bg-slate-200 rounded-full -mt-5 mx-1 overflow-hidden">
                        <div class="w-1/2 h-full bg-blue-600"></div>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-white border-2 border-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-800 text-xs italic">2</span>
                        </div>
                        <span class="text-[9px] font-800 text-slate-400 mt-2 uppercase">Cuci</span>
                    </div>
                    <div class="w-16 h-1 bg-slate-200 rounded-full -mt-5 mx-1"></div>
                    <div class="flex flex-col items-center opacity-30">
                        <div class="w-10 h-10 bg-white border-2 border-slate-200 rounded-full flex items-center justify-center">
                            <span class="text-slate-400 font-800 text-xs italic">3</span>
                        </div>
                        <span class="text-[9px] font-800 text-slate-400 mt-2 uppercase">Kering</span>
                    </div>
                    <div class="w-16 h-1 bg-slate-200 rounded-full -mt-5 mx-1"></div>
                    <div class="flex flex-col items-center opacity-30">
                        <div class="w-10 h-10 bg-white border-2 border-slate-200 rounded-full flex items-center justify-center">
                            <span class="text-slate-400 font-800 text-xs italic">4</span>
                        </div>
                        <span class="text-[9px] font-800 text-slate-400 mt-2 uppercase">Finish</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-8">
                <div class="text-right">
                    <h4 class="text-3xl font-800 text-blue-600 leading-none">30%</h4>
                    <p class="text-[10px] font-800 text-slate-400 uppercase mt-1">Selesai</p>
                </div>
                <button class="text-slate-300 hover:text-slate-600"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 10a2 2 0 110 4 2 2 0 010-4zm0-6a2 2 0 110 4 2 2 0 010-4zm0 12a2 2 0 110 4 2 2 0 010-4z"></path></svg></button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12 max-w-6xl">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
            <div>
                <p class="text-[10px] font-800 text-slate-400 uppercase tracking-wider">Estimasi Antrean</p>
                <h5 class="text-xl font-800 text-slate-800 italic">15 Menit</h5>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-100 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-cyan-50 text-cyan-500 rounded-2xl flex items-center justify-center"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg></div>
            <div>
                <p class="text-[10px] font-800 text-slate-400 uppercase tracking-wider">Sedang Dicuci</p>
                <h5 class="text-xl font-800 text-slate-800 italic">02 Unit</h5>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-100 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg></div>
            <div>
                <p class="text-[10px] font-800 text-slate-400 uppercase tracking-wider">Pengeringan</p>
                <h5 class="text-xl font-800 text-slate-800 italic">01 Unit</h5>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-100 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
            <div>
                <p class="text-[10px] font-800 text-slate-400 uppercase tracking-wider">Tersedia Slot</p>
                <h5 class="text-xl font-800 text-slate-800 italic">03 Slot</h5>
            </div>
        </div>
    </div>
</div>

<style>
    .font-800 { font-weight: 800; }
    .font-700 { font-weight: 700; }
</style>
@endsection
