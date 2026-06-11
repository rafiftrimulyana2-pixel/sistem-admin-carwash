<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Carwash Central System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700,800&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* ==========================================================================
           BENTENG PERTAHANAN: Mengunci Ruang Layar Agar Tidak Ada Gerakan Kedip/Refres
           ========================================================================== */
        html {
            scrollbar-gutter: stable border-box !important;
            overflow-y: scroll !important; /* Memaksa area scrollbar tetap terkunci sejak awal */
        }
        body {
            overflow: hidden !important;
            height: 100vh !important;
        }

        .font-inter-black { font-family: 'Inter', sans-serif; font-weight: 900; }
        .font-inter-bold { font-family: 'Inter', sans-serif; font-weight: 700; }
    </style>

    {{-- Alpine.js dibersihkan agar dipanggil 1 kali saja --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">

        <aside class="w-64 h-full flex-shrink-0 border-r bg-white overflow-y-auto">
            @include('layouts.navigation')
        </aside>

        <main class="flex-1 h-screen max-h-screen overflow-hidden bg-[#f8fafc] flex flex-col">
            <div class="w-full h-full p-0">
                @yield('content')
            </div>
        </main>

    </div>

    <script>
        function openProfileModal() {
            document.getElementById('profileModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        function closeProfileModal() {
            document.getElementById('profileModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    </script>
</body>
</html>
