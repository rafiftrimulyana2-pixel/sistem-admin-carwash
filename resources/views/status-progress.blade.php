@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    * { font-family: 'Inter', sans-serif; }
    .progress-list-scroll::-webkit-scrollbar { width: 5px; }
    .progress-list-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .float-shadow { transition: all 0.3s ease; }
    .float-shadow:hover { transform: translateY(-5px); box-shadow: 0 10px 20px -5px rgba(0,0,0,0.2); }

    html, body, main, .flex-1 {
    overflow: auto !important;
    height: auto !important;
    max-height: none !important;
    }

    /* CSS untuk scrollbar tipis yang rapi */
    .custom-scroll::-webkit-scrollbar { height: 6px; }
    .custom-scroll::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>

<div class="w-full min-h-screen bg-[#f4f7fb] flex flex-col select-none antialiased text-slate-700">
    <div class="w-full bg-blue-600 border-b border-blue-700 px-6 py-3.5 flex justify-between items-center flex-shrink-0 shadow-md shadow-slate-900/10 z-20">
        <div class="space-y-0.5">
            <h1 class="text-white text-sm font-extrabold uppercase tracking-tight">Status Progress Kendaraan</h1>
            <p class="text-blue-100 text-[9px] font-bold uppercase tracking-wider mt-0.5">Monitoring semua unit yang sedang dalam pengerjaan</p>
        </div>
        <div class="bg-white/10 border border-white/20 px-3 py-1.5 rounded-xl text-white text-[10px] font-bold uppercase tracking-wide">
            TOTAL UNIT: {{ $bookings->count() }}
        </div>
    </div>

    <div class="w-full p-6 min-h-screen">

    <!-- 1. Statistik Bar (Warna Putih, Mengambang, Bayangan Tipis) -->
    <div class="grid grid-cols-4 gap-6 mb-8">
        @php
            $stats = [
                ['Total Order', $totalOrder ?? 0 , 'text-blue-500', 'box'],
                ['Pencucian', $sedangCuci ?? 0 , 'text-amber-500', 'waves'],
                ['Antrean', $antrean ?? 0 , 'text-rose-500', 'clock'],
                ['Selesai', $selesai ?? 0, 'text-emerald-500', 'check-circle']
            ];
        @endphp
        @foreach($stats as $stat)
        <div class="bg-white p-5 rounded-2xl text-center shadow-[0_4px_15px_-3px_rgba(0,0,0,0.05)] border border-slate-100 flex flex-col items-center gap-2 hover:-translate-y-1 transition-transform">
            <i data-lucide="{{ $stat[3] }}" class="w-8 h-8 {{ $stat[2] }}"></i>
            <h2 class="text-2xl font-black text-slate-800">{{ $stat[1] }}</h2>
            <p class="text-[10px] uppercase font-bold text-slate-400">{{ $stat[0] }}</p>
        </div>
        @endforeach
    </div>

    <!-- 2. Live Progress Tracker Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 min-h-[500px]">
        @forelse($bookings as $booking)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-[0_4px_15px_-3px_rgba(0,0,0,0.05)] overflow-hidden flex flex-col">

            <!-- Header Tiket Bokingan & Waktu Masuk -->
            <div class="bg-blue-600 px-5 py-3 text-white flex justify-between items-center">
                <span class="text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                    <i data-lucide="ticket" class="w-3 h-3"></i> TICKET: #BKG-{{ $booking->id }}
                </span>
                <span class="text-[9px] font-bold opacity-80 uppercase">
                    Masuk: {{ \Carbon\Carbon::parse($booking->created_at)->format('H:i') }} WIB
                </span>
            </div>

            <!-- Konten Kartu Data Customer -->
            <div class="p-5 flex-1">
                <!-- Info Utama -->
                <div class="flex gap-4 mb-4">
                    <div class="w-16 h-16 bg-slate-50 rounded-xl flex items-center justify-center border border-slate-200 shrink-0">
                        <i data-lucide="car-front" class="w-8 h-8 text-slate-400"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <h3 class="font-black text-sm text-slate-800">{{ $booking->nama_pelanggan }}</h3>
                            <span class="px-2 py-1 rounded text-[9px] font-black uppercase {{ ($booking->step ?? 1) >= 7 ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $booking->status ?? 'Proses' }}
                            </span>
                        </div>
                            <p class="text-[10px] font-bold text-slate-500 uppercase">{{ $booking->plat_nomor }} | {{ $booking->jenis_kendaraan ?? 'Tipe Mobil' }}</p>
                            <p class="text-[10px] font-black text-blue-600 mt-1 uppercase">Layanan: {{ $booking->jenis_paket }}</p>
                            <p class="text-[10px] font-bold text-blue-200 uppercase">
                            WA: <span class="text-white">{{ $booking->no_hp ?? '-' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Tombol Cek Lokasi -->
                <a href="https://www.google.com/maps/search/?api=1&query={{ $booking->lokasi_customer }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2 bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200 rounded-lg text-[10px] font-black uppercase mb-6 transition">
                    <i data-lucide="map-pin" class="w-3 h-3 text-rose-500"></i> Cek Lokasi Realtime Customer
                </a>

                <!-- Progress Bar Utama & Stepper 7 Tahap (Bisa di-Scroll Kanan) -->
                <div class="mb-6">
                    <div class="flex justify-between text-[10px] font-black mb-2 px-1 uppercase">
                        <span class="text-slate-400">Tahapan Progress</span>
                        <span class="text-blue-600">{{ $booking->persen ?? 0 }}%</span>
                    </div>

                    <!-- Container Scroll Horizontal -->
                    <div class="flex overflow-x-auto gap-4 custom-scroll pb-4 relative">
                        <!-- Garis penghubung di belakang -->
                        <div class="absolute top-6 left-6 h-0.5 bg-slate-200 -z-0" style="width: 500px;"></div>

                        @php
                            $steps = [
                                ['label'=>'Daftar', 'icon'=>'clipboard-list'],
                                ['label'=>'Pre-Wash', 'icon'=>'droplets'],
                                ['label'=>'Cuci', 'icon'=>'waves'],
                                ['label'=>'Wax/Poles', 'icon'=>'sparkles'],
                                ['label'=>'Pengeringan', 'icon'=>'wind'],
                                ['label'=>'Inspeksi', 'icon'=>'search'],
                                ['label'=>'Selesai', 'icon'=>'check-circle']
                            ];
                        @endphp

                        @foreach($steps as $idx => $s)
                        <div class="flex flex-col items-center shrink-0 w-16 relative z-10">
                            <!-- Bulatan dengan Icon -->
                            <div class="w-12 h-12 rounded-full {{ $idx+1 < ($booking->step ?? 1) ? 'bg-emerald-500 border-none' : ($idx+1 == ($booking->step ?? 1) ? 'bg-blue-600 border-none' : 'bg-white border-2 border-slate-200') }} flex items-center justify-center shadow-md transition-colors z-10">
                                <i data-lucide="{{ $s['icon'] }}" class="w-5 h-5 {{ $idx+1 > ($booking->step ?? 1) ? 'text-slate-400' : 'text-white' }}"></i>
                            </div>
                            <span class="text-[9px] mt-2 font-bold {{ $idx+1 <= ($booking->step ?? 1) ? 'text-slate-800' : 'text-slate-400' }} uppercase text-center">{{ $s['label'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Admin Control: Pengubah Status -->
                <div class="border-t border-slate-100 pt-4">
                    <p class="text-[9px] font-black text-slate-400 uppercase mb-2">Admin Control: Seting Tahap Progres</p>
                    <div class="flex gap-2">
                        <select id="select-step-{{ $booking->id }}" class="flex-1 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-[10px] font-black text-slate-700 outline-none focus:border-blue-500 transition uppercase">
                            @foreach($steps as $idx => $s)
                            <option value="{{ $idx + 1 }}" {{ ($booking->step ?? 1) == $idx + 1 ? 'selected' : '' }}>
                                {{ $idx + 1 }}. {{ $s['label'] }}
                            </option>
                            @endforeach
                        </select>
                        <button onclick="updateStatusProgress({{ $booking->id }})" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-[10px] font-black hover:bg-blue-700 transition uppercase flex gap-1 items-center">
                            <i data-lucide="save" class="w-3 h-3"></i> Terapkan
                        </button>
                    </div>
                </div>

                </div>
                    </div>
                        @empty
                            <div class="w-full flex items-center justify-center p-5 bg-white rounded-2xl border border-dashed border-slate-300 shadow-sm">
                                <div class="text-center">
                                    <i data-lucide="inbox" class="w-5 h-5 text-slate-300 mb-2 mx-auto"></i>
                                    <p class="text-slate-400 font-bold uppercase text-[10px]">Belum ada unit yang sedang dalam pengerjaan</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

<script>
   function updateStatusProgress(id) {
        const selectedStep = document.getElementById(`select-step-${id}`).value;
        const selectElement = document.getElementById(`select-step-${id}`);
        const stepName = selectElement.options[selectElement.selectedIndex].text;

        // Mengirim data ke server menggunakan fetch
        fetch(`/update-status/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ step: selectedStep })
        })
        .then(response => response.json())
        .then(data => {
            alert(`SUKSES!\nStatus Progres tiket #${id} berhasil dirubah ke: ${stepName}`);
            window.location.reload(); // Refresh otomatis agar perubahan warna muncul
        })
        .catch(error => {
            alert("Terjadi kesalahan saat menyimpan data.");
        });
    }

    lucide.createIcons();
</script>

@endsection
