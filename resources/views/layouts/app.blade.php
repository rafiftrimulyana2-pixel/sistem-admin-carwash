<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Carwash Central System</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700,800&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .font-inter-black { font-family: 'Inter', sans-serif; font-weight: 900; }
        .font-inter-bold { font-family: 'Inter', sans-serif; font-weight: 700; }
    </style>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 h-full flex-shrink-0 border-r bg-white overflow-y-auto">
            @include('layouts.navigation')
        </aside>

        <!-- Main Content -->
        <main class="flex-1 h-full overflow-y-auto bg-[#fcfcfd] scroll-smooth flex flex-col">
            <header class="bg-white border-b border-gray-100 py-3 px-8 flex justify-between items-center sticky top-0 z-50">
                <div class="flex flex-col justify-center">
                    <h2 class="font-inter-black text-blue-600 text-sm uppercase tracking-tight leading-none">
                        Carwash Central System
                    </h2>
                    <p class="text-[10px] text-gray-400 font-inter-bold uppercase tracking-widest mt-1">
                        Pusat Kendali Operasional
                    </p>
                </div>

        <!-- Notifikasi Lonceng -->
        <div class="flex items-center space-x-5">
            <div class="relative inline-block text-left" x-data="{ open: false }">
                <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-blue-600 transition-all focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>

                    <!-- Bulatan Merah: Hanya muncul jika ada stok kritis -->
                    @if(isset($stokKritis) && $stokKritis->count() > 0)
                    <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 border-2 border-white rounded-full animate-pulse"></span>
                    @endif
                </button>

                <!-- Dropdown Notifikasi -->
                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-[999]"
                    style="display: none;">
                        <div class="p-4 border-b border-gray-50 bg-gray-50/50">
                    <h4 class="text-[10px] font-inter-black text-gray-700 uppercase tracking-widest">Pusat Notifikasi</h4>
                </div>
                <div class="max-h-60 overflow-y-auto">
                    @forelse($stokKritis as $item)
                        <div class="p-4 border-b border-gray-50 hover:bg-blue-50/30 transition-colors flex items-start space-x-3">
                            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-inter-bold text-gray-800 uppercase">{{ $item->nama_bahan }} Hampir Habis!</p>
                                <p class="text-[9px] text-gray-500 mt-0.5">Sisa stok: <span class="text-red-500 font-bold">{{ $item->stok }}</span>. Segera lakukan pengadaan.</p>
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center">
                            <p class="text-[10px] text-gray-400 font-inter-bold uppercase tracking-widest">Tidak ada peringatan</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Profil Admin (Pemicu Modal) -->
        <div onclick="openProfileModal()" class="flex items-center space-x-3 cursor-pointer group">
            <div class="flex flex-col text-right">
                <span class="text-[11px] font-inter-black text-gray-700 group-hover:text-blue-600 transition-colors">{{ Auth::user()->name }}</span>
                <span class="text-[8px] font-inter-bold text-gray-400 uppercase mt-1">Administrator</span>
            </div>
                <div class="relative w-9 h-9">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full rounded-full object-cover border-2 border-white shadow-md group-hover:border-blue-500 transition-all">
                            @else
                                <div class="w-full h-full rounded-full bg-gradient-to-tr from-blue-600 to-blue-400 border-2 border-white shadow-md flex items-center justify-center text-white font-inter-bold text-[11px]">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black/20 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Isi Dashboard -->
            <div class="p-4">
                @yield('content')
                    </div>
                </main>
            </div>

            {{-- MODAL PROFIL ADMIN (Desain Modern Figma Style Terbaru) --}}
            <div id="profileModal" class="fixed inset-0 hidden" style="z-index: 9999;">

            <!-- Overlay Gelap dengan Blur Halus -->
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-md transition-opacity" onclick="closeProfileModal()"></div>

            <!-- Container Utama -->
            <div class="fixed inset-0 flex items-center justify-center p-4 pointer-events-none">

                <!-- Kotak Modal -->
                <div class="bg-white w-full max-w-[400px] rounded-[2rem] shadow-[0_25px_60px_-15px_rgba(0,0,0,0.3)] overflow-hidden pointer-events-auto border border-slate-100 transform transition-all">

                    <!-- Header: Gradasi Biru Halus & Elegan -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-7 text-white text-center relative">
                        <h3 class="font-inter-black text-[11px] uppercase tracking-[0.25em]">Update Profil Admin</h3>
                        <p class="text-[9px] text-blue-100 uppercase tracking-widest mt-1 opacity-80">Carwash Central System</p>

                        <button type="button" onclick="closeProfileModal()" class="absolute top-5 right-6 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Body Modal -->
                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-8 flex flex-col items-center">
                        @csrf
                        @method('patch')

                        <!-- Icon / Ilustrasi Avatar Box -->
                        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-5 shadow-inner border border-blue-100/50">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                        </div>

                        <div class="w-full space-y-3 mb-8 text-center">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Pilih Foto Profil Baru</label>

                            <!-- Custom Dropzone Input File -->
                            <label class="relative flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-slate-200 hover:border-blue-500 rounded-2xl bg-slate-50/50 hover:bg-blue-50/30 transition-all cursor-pointer group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 px-4">
                                    <svg class="w-8 h-8 mb-2 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="text-[10px] font-black text-slate-600 group-hover:text-blue-600 uppercase tracking-wide">Klik atau seret foto ke sini</p>
                                    <p class="text-[8px] text-slate-400 mt-1 uppercase">PNG, JPG, atau JPEG (Maks. 2MB)</p>
                                </div>
                                <input type="file" name="avatar" accept="image/*" required class="hidden" onchange="previewFileName(this)" />
                            </label>
                            <span id="file-name-display" class="text-[9px] font-bold text-blue-600 uppercase tracking-wide block mt-1"></span>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="w-full space-y-2.5">
                            <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-[10px] font-black shadow-lg shadow-blue-500/30 transition-all uppercase tracking-[0.2em] active:scale-95">
                                Simpan Perubahan
                            </button>

                            <button type="button" onclick="closeProfileModal()" class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-[10px] font-black transition-all uppercase tracking-[0.2em]">
                                Batalkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<!-- SCRIPT PENDUKUNG MODAL -->
<script>
    function openProfileModal() {
        document.getElementById('profileModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeProfileModal() {
        document.getElementById('profileModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    function previewFileName(input) {
        const display = document.getElementById('file-name-display');
        if (input.files && input.files[0]) {
            display.innerText = "File terpilih: " + input.files[0].name;
        } else {
            display.innerText = "";
        }
    }
</script>

</body>
</html>
