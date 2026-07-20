<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Carwash Central System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700,800,900&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        html { scrollbar-gutter: stable border-box !important; overflow-y: scroll !important; }
        body { overflow: hidden !important; height: 100vh !important; font-family: 'Inter', sans-serif; }
        .font-inter-black { font-weight: 900; }
        .font-inter-bold { font-weight: 700; }
    </style>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar Navigasi -->
        <aside class="w-64 h-full flex-shrink-0 border-r bg-white overflow-y-auto">
            @include('layouts.navigation')
        </aside>

        <!-- Area Konten Utama Workspace -->
        <main class="flex-1 h-screen max-h-screen overflow-hidden bg-[#f8fafc] flex flex-col">
            <div class="w-full h-full p-0">
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

                        <!-- Custom Dropzone Input File (Tanpa teks "Choose file") -->
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Fungsi Kontrol Modal Profil Modern
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
