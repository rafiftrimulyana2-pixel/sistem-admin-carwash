<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">

    <!-- Sidebar (Baris 19-22) -->
    <aside class="w-64 h-full flex-shrink-0 border-r bg-white overflow-y-auto">
        @include('layouts.navigation')
    </aside>

    <!-- Main Content -->
    <main class="flex-1 h-full overflow-y-auto bg-[#fcfcfd] scroll-smooth flex flex-col">

        <header class="bg-white border-b border-gray-100 py-3 px-8 flex justify-between items-center sticky top-0 z-50">
    <!-- Bagian Kiri: Judul Baru dengan Warna Biru -->
    <div class="flex flex-col justify-center">
        <!-- Teks dirubah menjadi 'Carwash Central System' dengan warna Blue-600 -->
        <h2 class="font-inter-black text-blue-600 text-sm uppercase tracking-tight leading-none">
            Carwash Central System
        </h2>
        <p class="text-[10px] text-gray-400 font-inter-bold uppercase tracking-widest mt-1">
            Pusat Kendali Operasional
        </p>
    </div>

    <!-- Bagian Kanan: Notifikasi & Profil -->
    <div class="flex items-center space-x-5">
        <!-- Lonceng Pengingat -->
        <button title="Notifikasi Aktivitas" class="relative p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 border-2 border-white rounded-full"></span>
        </button>

        <!-- Profil Admin -->
        <div class="flex items-center space-x-3 cursor-pointer group">
            <div class="flex flex-col text-right">
                <span class="text-[11px] font-inter-black text-gray-700 leading-none group-hover:text-blue-600 transition-colors">{{ Auth::user()->name }}</span>
                <span class="text-[8px] font-inter-bold text-gray-400 uppercase tracking-tighter mt-1">Administrator</span>
            </div>

            <div class="relative">
                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-blue-600 to-blue-400 border-2 border-white shadow-md flex items-center justify-center text-white text-[10px] font-inter-black uppercase">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </div>
    </div>
</header>

        <div class="p-4">
            @yield('content')
        </div>
    </main>
</div>
</body>
