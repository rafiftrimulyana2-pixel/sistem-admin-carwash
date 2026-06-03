@extends('layouts.workspace')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    *{
        font-family: 'Inter', sans-serif;
    }

    body{
        overflow: hidden;
    }

    .hide-scroll::-webkit-scrollbar{
        display: none;
    }

    .hide-scroll{
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .calendar-day{
        transition: all .2s ease;
    }

    .calendar-day:hover{
        transform: scale(1.08);
    }

    .action-btn{
        transition: .2s ease;
    }

    .action-btn:hover{
        transform: translateY(-1px);
    }
</style>

<div class="w-full h-[calc(100vh-2px)] bg-[#f4f7fb] overflow-y-auto hide-scroll">

    {{-- HEADER --}}
    <div class="w-full bg-gradient-to-r from-[#1e40af] via-[#3157d5] to-[#4338ca] px-6 py-3 flex justify-between items-center shadow-md">
        <div>
            <h1 class="text-white text-[18px] font-extrabold uppercase tracking-wide">
                SISTEM JADWAL MEKANIK
            </h1>

            <p class="text-blue-100 text-[10px] mt-0.5 tracking-wide">
                Monitoring realtime jadwal kerja mekanik, shift bengkel, dan aktivitas operasional harian.
            </p>
        </div>

        <div class="flex items-center gap-2">

            <div class="bg-white/10 border border-white/10 px-3 py-1.5 rounded-lg text-white text-[10px] font-semibold">
                Hari :
                <span id="tanggalRealtime"></span>
            </div>

            <div class="bg-white border border-white px-3 py-1.5 rounded-lg text-blue-600 text-[10px] font-bold flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                Sistem Online
            </div>
        </div>
    </div>

    <div class="p-4 grid grid-cols-12 gap-4">

        {{-- LEFT --}}
        <div class="col-span-9 space-y-4">

            {{-- FILTER --}}
            <div class="bg-white border border-blue-100 rounded-xl p-4">

                <div class="flex justify-between items-center mb-4">

                    <div>
                        <h2 class="text-[15px] font-bold text-[#1e3a8a]">
                            Pengaturan Monitoring
                        </h2>

                        <p class="text-[10px] text-slate-500">
                            Sistem filter monitoring jadwal mekanik realtime.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-5 gap-3">

                    <div>
                        <label class="text-[10px] font-semibold text-slate-600">
                            Filter Shift
                        </label>

                        <select id="filterShift"
                            class="w-full h-10 px-3 rounded-lg border border-slate-200 text-[11px] outline-none">

                            <option value="all">Semua Shift</option>
                            <option value="Pagi">Shift Pagi</option>
                            <option value="Siang">Shift Siang</option>
                            <option value="Malam">Shift Malam</option>

                        </select>
                    </div>

                    <div>
                        <label class="text-[10px] font-semibold text-slate-600">
                            Status Kehadiran
                        </label>

                        <select id="filterStatus"
                            class="w-full h-10 px-3 rounded-lg border border-slate-200 text-[11px] outline-none">

                            <option value="all">Semua Status</option>
                            <option value="Hadir">Hadir</option>
                            <option value="Izin">Izin</option>
                            <option value="Libur">Libur</option>

                        </select>
                    </div>
                    <div>
                </div>
            </div>
        </div>

            {{-- TABEL --}}
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">

                <div class="px-4 py-3 border-b border-slate-200 flex justify-between items-center">

                    <div>
                        <h2 class="text-[20px] font-bold text-[#1e3a8a]">
                            Data Jadwal Mekanik
                        </h2>

                        <p class="text-[10px] text-slate-500">
                            Pemantauan realtime data mekanik bengkel.
                        </p>
                    </div>

                    <div class="flex gap-2">

                        <div
                            class="px-3 py-1 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-[10px] font-semibold">
                            18 Mekanik Aktif
                        </div>

                        <div
                            class="px-3 py-1 rounded-lg bg-gradient-to-r from-green-500 to-emerald-600 text-white text-[10px] font-semibold">
                            14 Hadir
                        </div>

                    </div>

                </div>

                <div class="bg-gradient-to-r from-[#1e40af] to-[#3157d5] text-white">

                    <div class="grid grid-cols-7 text-center text-[10px] font-semibold">

                        <div class="py-3 border-r border-white/10">NO</div>
                        <div class="py-3 border-r border-white/10">NAMA MEKANIK</div>
                        <div class="py-3 border-r border-white/10">KEAHLIAN</div>
                        <div class="py-3 border-r border-white/10">SHIFT</div>
                        <div class="py-3 border-r border-white/10">JAM KERJA</div>
                        <div class="py-3 border-r border-white/10">STATUS</div>
                        <div class="py-3">AKSI</div>

                    </div>

                </div>

                <div id="tableData"
                    class="max-h-[520px] overflow-y-auto hide-scroll">

                    {{-- ROW --}}
                    <div data-shift="Pagi" data-status="Hadir"
                        class="grid grid-cols-7 items-center text-center text-[11px] border-b border-slate-100 bg-white">

                        <div class="py-3">1</div>

                        <div class="py-3 font-semibold text-slate-700">
                            Dani Ardiansyah
                        </div>

                        <div class="py-3 text-blue-700">
                            Engine Specialist
                        </div>

                        <div class="py-3 text-amber-600 font-semibold">
                            Pagi
                        </div>

                        <div class="py-3">
                            08:00 - 16:00
                        </div>

                        <div class="py-3">
                            <span class="px-2 py-1 rounded-md bg-green-100 text-green-700 text-[10px] font-semibold">
                                Hadir
                            </span>
                        </div>

                        <div class="py-3 flex justify-center gap-2">

                            <button onclick="aturData('Dani Ardiansyah')"
                                class="action-btn w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white">

                                ✎

                            </button>

                            <button onclick="detailData('Dani Ardiansyah')"
                                class="action-btn w-8 h-8 rounded-lg bg-slate-200 flex items-center justify-center text-slate-700">

                                ⓘ

                            </button>

                        </div>

                    </div>

                    {{-- ROW --}}
                    <div data-shift="Siang" data-status="Hadir"
                        class="grid grid-cols-7 items-center text-center text-[11px] border-b border-slate-100 bg-[#fcfdff]">

                        <div class="py-3">2</div>

                        <div class="py-3 font-semibold text-slate-700">
                            Kevin Sanjaya
                        </div>

                        <div class="py-3 text-blue-700">
                            Body Repair
                        </div>

                        <div class="py-3 text-orange-600 font-semibold">
                            Siang
                        </div>

                        <div class="py-3">
                            13:00 - 21:00
                        </div>

                        <div class="py-3">
                            <span class="px-2 py-1 rounded-md bg-green-100 text-green-700 text-[10px] font-semibold">
                                Hadir
                            </span>
                        </div>

                        <div class="py-3 flex justify-center gap-2">

                            <button onclick="aturData('Kevin Sanjaya')"
                                class="action-btn w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white">

                                ✎

                            </button>

                            <button onclick="detailData('Kevin Sanjaya')"
                                class="action-btn w-8 h-8 rounded-lg bg-slate-200 flex items-center justify-center text-slate-700">

                                ⓘ

                            </button>

                        </div>

                    </div>

                    {{-- ROW --}}
                    <div data-shift="Malam" data-status="Izin"
                        class="grid grid-cols-7 items-center text-center text-[11px] border-b border-slate-100 bg-white">

                        <div class="py-3">3</div>

                        <div class="py-3 font-semibold text-slate-700">
                            Marda Wijaya
                        </div>

                        <div class="py-3 text-blue-700">
                            Kelistrikan
                        </div>

                        <div class="py-3 text-indigo-600 font-semibold">
                            Malam
                        </div>

                        <div class="py-3">
                            21:00 - 05:00
                        </div>

                        <div class="py-3">
                            <span class="px-2 py-1 rounded-md bg-yellow-100 text-yellow-700 text-[10px] font-semibold">
                                Izin
                            </span>
                        </div>

                        <div class="py-3 flex justify-center gap-2">

                            <button onclick="aturData('Marda Wijaya')"
                                class="action-btn w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white">

                                ✎

                            </button>

                            <button onclick="detailData('Marda Wijaya')"
                                class="action-btn w-8 h-8 rounded-lg bg-slate-200 flex items-center justify-center text-slate-700">

                                ⓘ

                            </button>

                        </div>

                    </div>

                    {{-- TAMBAHAN --}}
                    @for($i = 4; $i <= 15; $i++)
                    <div data-shift="Pagi" data-status="Hadir"
                        class="grid grid-cols-7 items-center text-center text-[11px] border-b border-slate-100 bg-[#fcfdff]">

                        <div class="py-3">{{ $i }}</div>

                        <div class="py-3 font-semibold text-slate-700">
                            Mekanik {{ $i }}
                        </div>

                        <div class="py-3 text-blue-700">
                            General Service
                        </div>

                        <div class="py-3 text-amber-600 font-semibold">
                            Pagi
                        </div>

                        <div class="py-3">
                            08:00 - 16:00
                        </div>

                        <div class="py-3">
                            <span class="px-2 py-1 rounded-md bg-green-100 text-green-700 text-[10px] font-semibold">
                                Hadir
                            </span>
                        </div>

                        <div class="py-3 flex justify-center gap-2">

                            <button onclick="aturData('Mekanik {{ $i }}')"
                                class="action-btn w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white">

                                ✎

                            </button>

                            <button onclick="detailData('Mekanik {{ $i }}')"
                                class="action-btn w-8 h-8 rounded-lg bg-slate-200 flex items-center justify-center text-slate-700">

                                ⓘ

                            </button>

                        </div>

                    </div>
                    @endfor

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="col-span-3 space-y-4">

            {{-- KALENDAR --}}
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

                <div class="bg-gradient-to-r from-[#1e40af] to-[#3157d5] px-4 py-3 flex justify-between items-center">

                    <div>

                        <h2 class="text-white text-[14px] font-bold">
                            Kalendar
                        </h2>

                        <p class="text-blue-100 text-[10px]">
                            Kalender realtime bengkel
                        </p>

                    </div>

                    <div class="text-white text-lg">
                        📅
                    </div>

                </div>

                <div class="p-4">

                    <div class="flex justify-between items-center mb-4">

                        <button id="prevMonth"
                            class="w-8 h-8 rounded-md bg-red-100 text-red-700 text-sm">
                            ←
                        </button>

                        <h3 id="monthYear"
                            class="text-[13px] font-bold text-slate-700">
                        </h3>

                        <button id="nextMonth"
                            class="w-8 h-8 rounded-md bg-blue-100 text-blue-700 text-sm">
                            →
                        </button>

                    </div>

                    <div class="grid grid-cols-7 gap-2 text-center text-[10px] font-bold text-slate-500 mb-3">

                        <div>MIN</div>
                        <div>SEN</div>
                        <div>SEL</div>
                        <div>RAB</div>
                        <div>KAM</div>
                        <div>JUM</div>
                        <div>SAB</div>

                    </div>

                    <div id="calendarDays"
                        class="grid grid-cols-7 gap-2 text-center">
                    </div>

                </div>

            </div>

            {{-- AKTIVITAS --}}
<div class="bg-gradient-to-br from-[#1e40af] via-[#3157d5] to-[#4338ca] rounded-2xl overflow-hidden shadow-md">

    <div class="px-4 py-3 border-b border-white/10 flex justify-between items-center">

        <div>

            <h2 class="text-[14px] font-bold text-white">
                Aktivitas Sistem
            </h2>

            <p class="text-[10px] text-blue-100 mt-1">
                Monitoring aktivitas jadwal bengkel realtime
            </p>

        </div>

        <div class="flex items-center gap-2 text-[10px] font-semibold text-white">

            <span class="w-2 h-2 rounded-full bg-green-300 animate-pulse"></span>
            ONLINE

        </div>

    </div>

    <div class="p-4 space-y-3">

        <div
            class="bg-white/10 border border-white/10 rounded-xl p-3 hover:translate-x-1 duration-300">

            <div class="flex justify-between items-center">

                <span class="text-[11px] font-semibold text-white">
                    Jadwal Diperbarui
                </span>

                <span class="text-[10px] text-blue-100">
                    1 Menit
                </span>

            </div>

            <p class="text-[10px] text-blue-100 mt-2 leading-relaxed">
                Admin melakukan sinkronisasi jadwal mekanik realtime.
            </p>

        </div>

        <div
            class="bg-white/10 border border-white/10 rounded-xl p-3 hover:translate-x-1 duration-300">

            <div class="flex justify-between items-center">

                <span class="text-[11px] font-semibold text-white">
                    Shift Malam Aktif
                </span>

                <span class="text-[10px] text-blue-100">
                    Live
                </span>

            </div>

            <p class="text-[10px] text-blue-100 mt-2 leading-relaxed">
                Sistem mendeteksi mekanik shift malam sedang aktif bekerja.
            </p>

        </div>

    </div>

</div>

<script>

    function sinkronSistem(){

        alert(
            'Sistem berhasil melakukan sinkronisasi data jadwal, kalender, tabel, dan monitoring realtime.'
        );

    }

    function ubahJadwal(nama){

        const jadwalBaru = prompt(
            'Masukkan jadwal baru untuk ' + nama,
            '08:00 - 16:00'
        );

        if(jadwalBaru){

            alert(
                'Jadwal kerja mekanik berhasil diperbarui menjadi : ' + jadwalBaru
            );

        }

    }

</script>

<script>

    // realtime tanggal atas
    function updateTanggalRealtime(){

        const sekarang = new Date();

        const opsi = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };

        document.getElementById('tanggalRealtime').innerHTML =
            sekarang.toLocaleDateString('id-ID', opsi);

    }

    updateTanggalRealtime();

    // filter shift + status
    const filterShift = document.getElementById('filterShift');
    const filterStatus = document.getElementById('filterStatus');

    function filterTable(){

        const shift = filterShift.value;
        const status = filterStatus.value;

        const rows = document.querySelectorAll('#tableData > div');

        rows.forEach(row => {

            const rowShift = row.dataset.shift;
            const rowStatus = row.dataset.status;

            let show = true;

            if(shift !== 'all' && rowShift !== shift){
                show = false;
            }

            if(status !== 'all' && rowStatus !== status){
                show = false;
            }

            row.style.display = show ? 'grid' : 'none';

        });

    }

    filterShift.addEventListener('change', filterTable);
    filterStatus.addEventListener('change', filterTable);

    // aksi
    function aturData(nama){
        alert('Mengatur jadwal mekanik : ' + nama);
    }

    function detailData(nama){
        alert('Melihat detail data mekanik : ' + nama);
    }

    // kalender realtime
    const monthYear = document.getElementById('monthYear');
    const calendarDays = document.getElementById('calendarDays');

    let currentDate = new Date();

    function renderCalendar(){

        calendarDays.innerHTML = '';

        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();

        const monthNames = [
            'Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember'
        ];

        monthYear.innerHTML = `${monthNames[month]} ${year}`;

        for(let i = 0; i < firstDay; i++){

            const empty = document.createElement('div');
            calendarDays.appendChild(empty);

        }

        for(let day = 1; day <= lastDate; day++){

            const date = new Date(year, month, day);

            const isSunday = date.getDay() === 0;

            const today = new Date();

            const isToday =
                day === today.getDate() &&
                month === today.getMonth() &&
                year === today.getFullYear();

            const dayDiv = document.createElement('div');

            dayDiv.className =
                `calendar-day h-10 flex items-center justify-center rounded-lg text-[11px] font-semibold cursor-pointer
                ${isToday ? 'bg-blue-600 text-white' : ''}
                ${isSunday ? 'bg-red-100 text-red-700' : ''}
                ${!isToday && !isSunday ? 'bg-white border border-slate-200 text-slate-700' : ''}
                `;

            dayDiv.innerHTML = day;

            calendarDays.appendChild(dayDiv);

        }

    }

    renderCalendar();

    document.getElementById('prevMonth').addEventListener('click', () => {

        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();

    });

    document.getElementById('nextMonth').addEventListener('click', () => {

        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();

    });

</script>
@endsection
