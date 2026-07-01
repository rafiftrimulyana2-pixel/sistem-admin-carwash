<x-guest-layout>
    <!-- Memaksa layout menjebol keluar menjadi Full Screen yang rapi -->
    <div class="fixed inset-0 min-h-screen flex bg-slate-50 font-sans z-[9999]">

        <!-- ========================================== -->
        <!-- SISI KIRI: ILUSTRASI VEKTOR & BRANDING (55%) -->
        <!-- ========================================== -->
        <div class="hidden lg:flex lg:w-[55%] h-full bg-gradient-to-tr from-blue-700 via-blue-600 to-indigo-600 relative items-center p-16 overflow-hidden">

            <!-- Efek Ilustrasi Cahaya Abstrak Glow Bulat -->
            <div class="absolute -top-20 -left-20 w-[500px] h-[500px] bg-blue-500 rounded-full mix-blend-screen filter blur-3xl opacity-40 animate-pulse"></div>
            <div class="absolute -bottom-40 -right-20 w-[600px] h-[600px] bg-indigo-500 rounded-full mix-blend-screen filter blur-3xl opacity-30"></div>

            <!-- Pola Garis Grid Tipis Terintegrasi -->
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff08_1px,transparent_1px),linear-gradient(to_bottom,#ffffff08_1px,transparent_1px)] bg-[size:32px_32px]"></div>

            <!-- Representasi Ilustrasi Vektor Dasbor Data Menggunakan SVG Elemen -->
            <div class="absolute right-0 top-12 bottom-12 w-1/2 opacity-25 flex flex-col justify-between pointer-events-none">
                <div class="w-32 h-20 bg-white/10 border border-white/20 rounded-2xl backdrop-blur-sm p-3 transform -rotate-12 translate-x-10 shadow-lg">
                    <div class="w-8 h-2 bg-white/40 rounded-full mb-2"></div>
                    <div class="w-16 h-3 bg-white/60 rounded-full"></div>
                </div>
                <div class="w-40 h-28 bg-white/10 border border-white/20 rounded-2xl backdrop-blur-sm p-4 transform rotate-6 translate-x-6 shadow-xl">
                    <div class="flex gap-1 mb-3"><div class="w-2 h-2 rounded-full bg-rose-400"></div><div class="w-2 h-2 rounded-full bg-amber-400"></div><div class="w-2 h-2 rounded-full bg-emerald-400"></div></div>
                    <div class="w-full h-2 bg-white/30 rounded-full mb-1.5"></div>
                    <div class="w-3/4 h-2 bg-white/30 rounded-full"></div>
                </div>
                <div class="w-28 h-20 bg-white/10 border border-white/20 rounded-2xl backdrop-blur-sm p-3 transform -rotate-6 translate-x-12 shadow-lg">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/40 flex items-center justify-center mb-1"><i data-lucide="bar-chart-3" class="w-5 h-5 text-white/80"></i></div>
                </div>
            </div>

            <!-- Konten Utama Info Sistem Kasir -->
            <div class="relative z-10 max-w-lg">
                <span class="bg-blue-500/30 backdrop-blur-md text-blue-200 border border-white/10 text-[10px] font-black uppercase tracking-[0.2em] px-4 py-1.5 rounded-full">
                    Sistem Kasir Utama
                </span>
                <h1 class="text-4xl font-black text-white tracking-tight uppercase leading-tight mt-6 mb-4">
                    Kinerja Cepat,<br><span class="text-blue-200">Manajemen Akurat.</span>
                </h1>
                <!-- Teks sudah diubah agar sesuai dengan cakupan aplikasi operasional carwash kamu -->
                <p class="text-blue-100/70 text-sm font-semibold leading-relaxed">
                    Kelola antrean kendaraan pelanggan, pantau efisiensi status cuci mekanik, serta kendalikan alur operasional harian secara real-time dalam satu dashboard terintegrasi.
                </p>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- SISI KANAN: FORM LOGIN PREMIUM (45%)       -->
        <!-- ========================================== -->
        <div class="w-full lg:w-[45%] h-full flex flex-col justify-center items-center p-8 sm:p-16 bg-white relative z-10 shadow-2xl border-l border-slate-50">
            <div class="w-full max-w-md space-y-6 flex flex-col items-center">

                <!-- Logo & Judul Utama - SEKARANG FIX DI TENGAH (CENTER) -->
                <div class="text-center flex flex-col items-center w-full">

                    <!-- CONTAINER LOGO DINAMIS (Mudah Diganti Perusahaan) -->
                    <!-- Jika nanti admin punya file logo.png sendiri, kamu cukup menghapus tag <i> di bawah -->
                    <!-- lalu ganti menjadi: <img src="jalur-gambar/logo.png" class="w-full h-full object-contain"> -->
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center shadow-lg shadow-blue-100 mb-4 border-4 border-white ring-1 ring-slate-100 overflow-hidden transition-all duration-300 hover:scale-105">
                        <!-- Icon Tameng Sementara Sesuai Request -->
                        <i data-lucide="shield-check" class="w-7 h-7 text-white"></i>
                    </div>

                    <h2 class="text-2xl font-black text-slate-800 tracking-tight uppercase">Carwash Central</h2>
                    <p class="text-slate-400 text-xs font-bold mt-1">Silakan masuk menggunakan akun admin atau kasir.</p>
                </div>

                <!-- Session Status (Notifikasi Error bawaan Laravel) -->
                <x-auth-session-status class="w-full mb-2 text-center" :status="session('status')" />

                <!-- Form Login Konten Utama -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4 w-full">
                    @csrf

                    <!-- Email Address -->
                    <div class="space-y-1.5">
                        <x-input-label for="email" :value="__('Email')" class="text-xs font-black uppercase tracking-wider text-slate-700 pl-1" />
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </span>
                            <x-text-input id="email" class="block w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-50 transition-all duration-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@carwash.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-center" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-1.5">
                        <x-input-label for="password" :value="__('Password')" class="text-xs font-black uppercase tracking-wider text-slate-700 pl-1" />
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <i data-lucide="lock" class="w-4 h-4"></i>
                            </span>
                            <x-text-input id="password" class="block w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-50 transition-all duration-200"
                                            type="password"
                                            name="password"
                                            required autocomplete="current-password" placeholder="••••••••" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-center" />
                    </div>

                    <!-- Tombol Log In Modern (Inter-Bold Premium + Efek Bayangan Hidup) -->
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black text-sm py-3.5 px-4 rounded-xl shadow-lg shadow-blue-200 hover:shadow-xl hover:shadow-blue-300 active:scale-[0.99] transition-all duration-200 uppercase tracking-widest flex items-center justify-center gap-2">
                        <span>LOG IN</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>

                    <!-- Jendela Akses Lupa Password - KINI LEBIH HIDUP DI TENGAH -->
                    <div class="text-center pt-1">
                        @if (Route::has('password.request'))
                            <a class="text-xs font-bold text-slate-400 hover:text-blue-600 transition-colors duration-150 ease-in-out" href="{{ route('password.request') }}">
                                Forgot your password?
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Watermark Dokumen Perusahaan - SEKARANG FIX DI TENGAH BAWAH -->
            <div class="absolute bottom-6 text-[10px] text-gray-400 font-bold tracking-wide text-center w-full">
                &copy; 2026 Sistem Manajemen Bengkel & Reservasi
            </div>
        </div>

    </div>
</x-guest-layout>

<!-- Pemanggilan library ikon Lucide secara real-time -->
<script src="https://unpkg.com/lucide@latest"></script>
<script> lucide.createIcons(); </script>
