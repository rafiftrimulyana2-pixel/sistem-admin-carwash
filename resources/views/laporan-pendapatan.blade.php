@extends('layouts.app')

@section('content')
<div class="p-8">
    <div class="mb-10 text-left">
        <p class="text-[10px] font-bold text-blue-600 uppercase tracking-[0.4em] mb-2 italic">Financial Summary</p>
        <h1 class="text-3xl font-black text-slate-800 uppercase italic tracking-tighter">Laporan Pendapatan</h1>
        <div class="w-16 h-2 bg-blue-600 mt-4 rounded-full shadow-lg shadow-blue-600/20"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 text-left">
        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm transition-all hover:shadow-md">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest italic">Total Pendapatan</span>
            <h2 class="text-4xl font-black text-slate-800 italic mt-2">Rp 0</h2>
        </div>

        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm transition-all hover:shadow-md">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest italic">Unit Selesai</span>
            <h2 class="text-4xl font-black text-slate-800 italic mt-2">0 <span class="text-lg text-slate-300 font-normal">Unit</span></h2>
        </div>
    </div>

    <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="py-24 text-center">
            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-200 border border-slate-100">
                <i class="fas fa-chart-line text-2xl"></i>
            </div>
            <p class="text-[11px] font-bold text-slate-300 uppercase tracking-[0.2em] italic">Belum ada pendapatan terdaftar</p>
        </div>
    </div>
</div>
@endsection
