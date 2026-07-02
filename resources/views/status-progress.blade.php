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
</style>

<div class="w-full min-h-screen bg-[#f4f7fb] flex flex-col">
    <div class="w-full bg-blue-600 px-6 py-4 flex justify-between items-center shadow-lg shrink-0">
        <div class="space-y-0.5">
            <h1 class="text-white text-xs font-black uppercase tracking-widest">Status Progress Kendaraan</h1>
            <p class="text-blue-100 text-[8px] font-bold uppercase tracking-widest">Real-time monitoring workshop status system</p>
        </div>
        <div class="text-right">
            <span class="block text-[8px] text-blue-200 font-black uppercase">Tanggal Kerja</span>
            <span class="text-[10px] text-white font-bold">{{ date('d M Y') }}</span>
        </div>
    </div>

    <div class="max-w-5xl mx-auto p-6 pb-20">

    <div class="mb-6">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">STATUS PROGRES CUCI MOBIL</h1>
        <p class="text-slate-500 font-bold mt-1">Pantau perkembangan pengerjaan kendaraan Anda secara real-time</p>
    </div>

    @foreach($bookings as $booking)
    <div class="bg-white rounded-[32px] p-8 shadow-sm border border-slate-100 mb-6">
        <div class="flex justify-between items-start mb-10">
            <div>
                <h2 class="text-2xl font-black">Toyota Avanza Putih</h2>
                <p class="text-slate-500 font-bold">Plate: B 1234 ABC</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('detail.pesanan', $booking->id) }}" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-black hover:bg-blue-700 transition">Detail Pesanan</a>
                <button class="border border-slate-300 px-6 py-3 rounded-2xl font-black">Bantuan</button>
            </div>
        </div>
        @endforeach

        <div class="flex overflow-x-auto progress-list-scroll">
            @php
                $steps = [
                    1 => ['label' => 'Pendaftaran', 'sub' => 'Confirmed', 'color' => 'bg-green-500', 'icon' => 'file-text'],
                    2 => ['label' => 'Pra-Cuci', 'sub' => 'Sedang Dicuci', 'color' => 'bg-blue-500', 'icon' => 'refresh-cw'],
                    3 => ['label' => 'Pembersihan', 'sub' => 'Interior', 'color' => 'bg-yellow-400', 'icon' => 'spray-can'],
                    4 => ['label' => 'Waxing/Kilap', 'sub' => 'Waxing', 'color' => 'bg-yellow-500', 'icon' => 'sparkles'],
                    5 => ['label' => 'Pengeringan', 'sub' => 'Drying', 'color' => 'bg-orange-500', 'icon' => 'wind'],
                    6 => ['label' => 'Inspeksi', 'sub' => 'Inspection', 'color' => 'bg-orange-600', 'icon' => 'search'],
                    7 => ['label' => 'Selesai', 'sub' => 'Done', 'color' => 'bg-green-600', 'icon' => 'check-circle'],
                ];
            @endphp

            @foreach($steps as $i => $s)
            <div class="flex flex-col items-center min-w-[120px]">
                <div class="w-14 h-14 rounded-full flex items-center justify-center text-white {{ $s['color'] }} shadow-lg">
                    <i data-lucide="{{ $s['icon'] }}" class="w-6 h-6"></i>
                </div>
                <span class="text-[11px] font-black mt-3">{{ $i }}. {{ $s['label'] }}</span>
                <span class="text-[9px] font-bold text-slate-400 uppercase">{{ $s['sub'] }}</span>
            </div>
            @if($i < 7) <div class="h-0.5 w-full bg-slate-200 mt-7 mx-2"></div> @endif
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-slate-900 rounded-[32px] h-[300px] overflow-hidden relative">
            <img src="{{ asset('storage/' . $booking->foto_mobil) }}" class="w-full h-full object-cover opacity-80" alt="Foto Mobil">
            <div class="absolute bottom-6 left-6 text-white">
                <p class="text-xs font-bold uppercase opacity-70">Lokasi</p>
                <p class="font-black text-lg">Bay 3 - Pencucian Otomatis</p>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-[32px] p-8 shadow-sm">
            <h3 class="font-black text-lg mb-6">Ringkasan Pesanan</h3>
            <div class="space-y-4">
                <div class="flex justify-between"><span class="text-slate-500">Layanan:</span> <span class="font-bold">{{ $booking->layanan }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Biaya:</span> <span class="font-bold text-blue-600">Rp {{ number_format($booking->biaya) }}</span></div>
                <div class="pt-4 border-t"><span class="text-slate-500">Detail Pengerjaan:</span><p class="font-bold mt-1">{{ $booking->deskripsi }}</p></div>
                <div class="pt-4 border-t"><span class="text-slate-500">Petugas:</span> <p class="font-bold">{{ $booking->petugas }}</p></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Di status-progress.blade.php
    setInterval(() => {
        fetch('/api/get-antrean-update') // Buat route ini untuk ambil JSON data terbaru
        .then(response => response.json())
        .then(data => {
            // Update DOM tabel antrean di sini secara otomatis
        });
    }, 5000); // Cek setiap 5 detik

    let currentTabKategori = "ALL";
    const kapasitasMaksimalSlot = 5;
    let arrayDatabaseProgresWorkshop = @json($antreanAktif ?? []).map(item => {
        let step = item.status === 'READY' ? 4 : (item.status === 'PENGERINGAN' ? 3 : (item.status === 'PENCUCIAN' ? 2 : 1));

        // AMBIL WAKTU DARI DATABASE
        let waktu = new Date(item.created_at);
        let jamMasuk = waktu.getHours().toString().padStart(2, '0') + ':' + waktu.getMinutes().toString().padStart(2, '0');

        return {
        id: item.id,
        nopol: item.plat_nomor,
        nama: item.nama_pelanggan,
        mobil: item.jenis_kendaraan ?? 'MOBIL',
        step,
        persen: step * 25,
        waktu: jamMasuk
    };
    });

    function setKategoriTab(k, el) {
        currentTabKategori = k;
        document.querySelectorAll('.tab-btn').forEach(b => b.className = "tab-btn text-slate-500 px-4 py-1.5 rounded-lg text-[10px] font-bold uppercase");
        el.className = "tab-btn bg-blue-600 text-white px-4 py-1.5 rounded-lg text-[10px] font-black uppercase shadow-sm";
        jalankanSistemFilterProgresKombinasi();
    }

    function jalankanSistemFilterProgresKombinasi() {
        const search = document.getElementById('search-plat-nama').value.toLowerCase();
        const filtered = arrayDatabaseProgresWorkshop.filter(i => {
            const mS = i.nopol.toLowerCase().includes(search) || i.nama.toLowerCase().includes(search);
            const mT = (currentTabKategori === 'ALL') || (currentTabKategori === 'PROSES' && (i.step === 2 || i.step === 3)) || (currentTabKategori === 'READY' && i.step === 4);
            return mS && mT;
        });
        renderLiveProgressBoard(filtered);
    }

    function renderLiveProgressBoard(dataToRender) {
    const wrapper = document.getElementById('progress-list-wrapper');
    wrapper.innerHTML = "";

    dataToRender.forEach(i => {
            wrapper.innerHTML += `
                <div class="bg-white p-4 rounded-xl border border-slate-200 flex justify-between items-center shadow-sm">
                    <div>
                        <h3 class="font-black text-slate-800">${i.nama}</h3>
                        <p class="text-[9px] text-slate-400 font-bold uppercase">Masuk: ${i.waktu}</p>
                    </div>
                    </div>
            `;
        });

    // TARUH KODE STATISTIK DI SINI:
    let unitAktif = arrayDatabaseProgresWorkshop.filter(i => i.step < 4).length;
    document.getElementById('stat-estimasi').innerText = (arrayDatabaseProgresWorkshop.filter(r=>r.step===1).length * 15) + " Menit";
    document.getElementById('stat-cuci').innerText = arrayDatabaseProgresWorkshop.filter(r=>r.step===2).length + " Unit";
    document.getElementById('stat-kering').innerText = arrayDatabaseProgresWorkshop.filter(r=>r.step===3).length + " Unit";
    document.getElementById('stat-slot').innerText = Math.max(0, kapasitasMaksimalSlot - unitAktif) + " Slot";
    }

    lucide.createIcons();

    document.addEventListener("DOMContentLoaded", jalankanSistemFilterProgresKombinasi);
</script>
@endsection
