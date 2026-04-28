<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-b from-blue-700 to-blue-900">

            <div class="mb-6 transform hover:scale-110 transition duration-500">
                <div class="bg-white p-2 rounded-full shadow-2xl overflow-hidden w-24 h-24 flex items-center justify-center">
                    <img src="{{ asset('img/logo-perusahaan.png') }}" alt="Logo" class="w-full h-auto">
                </div>
            </div>

            <h1 class="text-white text-2xl font-bold mb-4 tracking-wider">CARWASH <span class="text-blue-300">MODERN</span></h1>

            <div class="w-full sm:max-w-md mt-2 px-8 py-10 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border-t-4 border-blue-500">
                {{ $slot }}
            </div>

            <p class="mt-6 text-blue-200 text-xs">© 2026 Sistem Manajemen Bengkel & Reservasi</p>
        </div>
    </body>
</html>
