<x-guest-layout>
    <div class="fixed inset-0 min-h-screen flex flex-col justify-center items-center bg-gradient-to-tr from-blue-700 via-blue-600 to-indigo-600 font-sans z-[9999] p-4 overflow-hidden">

        <div class="absolute -top-20 -left-20 w-[500px] h-[500px] bg-blue-500 rounded-full mix-blend-screen filter blur-3xl opacity-40 animate-pulse"></div>
        <div class="absolute -bottom-40 -right-20 w-[600px] h-[600px] bg-indigo-500 rounded-full mix-blend-screen filter blur-3xl opacity-30"></div>

        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff05_1px,transparent_1px),linear-gradient(to_bottom,#ffffff05_1px,transparent_1px)] bg-[size:32px_32px]"></div>

        <div class="w-full max-w-md bg-white p-8 sm:p-10 rounded-3xl shadow-[0_25px_60px_rgba(15,23,42,0.22)] border border-slate-100/80 relative z-10 flex flex-col items-center">

            <div class="text-center flex flex-col items-center w-full">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-blue-600/30 border-2 border-white ring-4 ring-blue-50/50 transition-transform duration-300 hover:scale-105">
                    <i data-lucide="key-round" class="w-7 h-7 text-white drop-shadow-sm"></i>
                </div>

                <h2 class="text-2xl font-black text-slate-800 tracking-tight uppercase">Reset Password</h2>
                <p class="text-slate-400 text-xs font-bold mt-2 leading-relaxed text-center px-3">
                    Lupa kata sandi? Masukkan alamat email Anda di bawah dan kami akan mengirimkan tautan pemulihan akun yang baru.
                </p>
            </div>

            <x-auth-session-status class="w-full mb-1 text-center text-xs font-bold text-emerald-600 bg-emerald-50/80 py-3 rounded-xl border border-emerald-100" :status="session('status')" />

            <form method="POST" action="{{ route('password.request') }}" class="space-y-4 w-full pt-2">
                @csrf

                <div class="space-y-1.5 text-left">
                    <x-input-label for="email" :value="__('Email')" class="text-xs font-black uppercase tracking-wider text-slate-700 pl-1" />
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </span>
                        <x-text-input id="email" class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-50 transition-all duration-200" type="email" name="email" :value="old('email')" required autofocus placeholder="admin@carwash.com" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-center" />
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black text-xs py-4 px-4 rounded-xl shadow-lg shadow-blue-200 hover:shadow-xl hover:shadow-blue-300 active:scale-[0.99] transition-all duration-200 uppercase tracking-widest flex items-center justify-center gap-2">
                    <span>Email Password Reset Link</span>
                    <i data-lucide="send" class="w-3.5 h-3.5"></i>
                </button>
            </form>

            <div class="text-center pt-2 flex justify-center w-full">
                <a class="text-xs font-black text-blue-600 hover:text-blue-700 transition-colors duration-150 flex items-center gap-1.5 hover:underline" href="{{ route('login') }}">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>KEMBALI KE HALAMAN MASUK</span>
                </a>
            </div>
        </div>

        <div class="absolute bottom-6 text-[10px] text-blue-200/60 font-bold tracking-wide text-center w-full">
            &copy; 2026 Sistem Manajemen Bengkel & Reservasi
        </div>
    </div>
</x-guest-layout>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
