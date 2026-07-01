<x-guest-layout>
    <div class="min-h-screen bg-slate-50 flex items-center justify-center p-4">
        <div class="w-full max-w-[360px] bg-white rounded-[32px] p-8 shadow-2xl">

            <div class="text-center mb-8">
                <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg shadow-blue-200 mb-4">
                    <i data-lucide="user-plus" class="w-7 h-7 text-white"></i>
                </div>
                <h2 class="text-2xl font-black text-slate-800">Daftar Akun</h2>
                <p class="text-slate-400 text-xs font-bold mt-1">Lengkapi data untuk booking cuci mobil.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase text-slate-600 pl-1">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-sm font-semibold" placeholder="Budi Santoso" required>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase text-slate-600 pl-1">Email</label>
                    <input type="email" name="email" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-sm font-semibold" placeholder="budi@email.com" required>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase text-slate-600 pl-1">Password</label>
                    <input type="password" name="password" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-sm font-semibold" placeholder="••••••••" required>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-black text-sm py-3.5 rounded-xl shadow-lg mt-4 active:scale-[0.98] transition-all">
                    DAFTAR SEKARANG
                </button>
            </form>

            <p class="text-center text-slate-400 text-[10px] font-bold mt-6">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 underline">Login</a>
            </p>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>lucide.createIcons();</script>
</x-guest-layout>
