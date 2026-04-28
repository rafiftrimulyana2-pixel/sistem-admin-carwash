<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl p-8 mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                <p class="text-gray-500 mt-1">Sistem Manajemen Bengkel & Reservasi sudah siap digunakan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-blue-600 p-6 rounded-3xl shadow-lg shadow-blue-200">
                    <p class="text-blue-100 text-sm font-bold uppercase tracking-wider">Antrian Hari Ini</p>
                    <h4 class="text-white text-4xl font-black mt-2">12</h4>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <p class="text-gray-400 text-sm font-bold uppercase tracking-wider">Mobil Selesai</p>
                    <h4 class="text-gray-800 text-4xl font-black mt-2">8</h4>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <p class="text-gray-400 text-sm font-bold uppercase tracking-wider">Total Pendapatan</p>
                    <h4 class="text-gray-800 text-4xl font-black mt-2">Rp 450k</h4>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
