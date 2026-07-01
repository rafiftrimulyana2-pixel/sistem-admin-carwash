<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex flex-col items-center min-h-screen">
    <div class="w-full max-w-[400px] bg-white min-h-screen shadow-2xl relative pb-24">
        @yield('content')
    </div>

    <nav class="fixed bottom-0 left-0 right-0 w-full max-w-[400px] mx-auto bg-white border-t border-slate-200 flex justify-around p-3 shadow-[0_-5px_15px_rgba(0,0,0,0.05)] z-[999]">
    <a href="/beranda" class="flex flex-col items-center text-indigo-600">
        <span class="text-xl">🏠</span>
        <span class="text-[10px] font-bold">Beranda</span>
    </a>
    <a href="/riwayat" class="flex flex-col items-center text-slate-400">
        <span class="text-xl">📜</span>
        <span class="text-[10px] font-bold">Riwayat</span>
    </a>
    <a href="/booking" class="flex flex-col items-center justify-center -mt-6 bg-indigo-600 w-14 h-14 rounded-full border-4 border-slate-50 shadow-lg">
        <span class="text-xl text-white">📅</span>
    </a>
    <a href="/status-progres" class="flex flex-col items-center text-slate-400">
        <span class="text-xl">🚗</span>
        <span class="text-[10px] font-bold">Status</span>
    </a>
    <a href="/profile" class="flex flex-col items-center text-slate-400">
        <span class="text-xl">👤</span>
        <span class="text-[10px] font-bold">Profil</span>
    </a>
</nav>
</body>
</html>
