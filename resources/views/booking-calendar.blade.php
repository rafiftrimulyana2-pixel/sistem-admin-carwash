@extends('layouts.workspace')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    * { font-family: 'Inter', sans-serif; }
    table { width: 100%; min-width: 1800px; border-collapse: collapse; table-layout: fixed; }
    td, th { border: 1px solid #e2e8f0; padding: 12px; }

    .btn-istirahat {
        transition: all 0.3s ease;
        background: #ef4444; color: white;
        padding: 6px 10px; font-weight: 800; font-size: 8px;
        box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.3);
        display: block; width: 100%;
    }
    .btn-istirahat:hover { transform: translateY(-2px); box-shadow: 0 6px 12px rgba(220, 38, 38, 0.5); }

    /* Ikon yang terlihat menyatu (bukan stiker) */
    .icon-natural { stroke-width: 1.5; opacity: 0.9; }
    .rotate-180 { transform: rotate(180deg); }
</style>

<div class="h-screen flex flex-col bg-slate-50">
    <div class="bg-blue-600 px-6 py-4 flex justify-between items-center shadow-md shrink-0">
        <h1 class="text-white text-sm font-black uppercase tracking-widest">JADWAL OPERASIONAL</h1>

        <div id="filter-wrapper" class="relative flex items-center bg-white/10 border border-white/20 rounded hover:bg-white/20 transition-all cursor-pointer">
            <div class="flex items-center gap-2 px-3 py-1.5" onclick="toggleFilter()">
                <i data-lucide="calendar" class="icon-natural w-3 h-3 text-amber-300"></i>

                <span id="filter-text" class="text-[9px] font-bold text-white uppercase tracking-wider">JUNI 2026</span>

                <i id="chevron-icon" data-lucide="chevron-down" class="icon-natural w-3 h-3 text-white transition-transform duration-300"></i>
            </div>
            <select id="filter-bulan" onchange="updateFilter(this)" class="absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer">
            </select>
        </div>
    </div>

    <div class="flex-grow overflow-auto p-0">
        <div class="bg-white border border-slate-200">
            <table>
                <thead class="bg-slate-100 sticky top-0 z-10">
                    <tr>
                        <th class="p-4 text-[10px] font-black uppercase text-center w-[120px] border-r">HARI / TGL</th>
                        @foreach(range(8, 23) as $jam)
                            <th class="p-4 text-[10px] font-black uppercase text-center w-[90px] border-r">{{ sprintf('%02d', $jam) }}:00</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody id="tabel-jadwal" class="divide-y divide-slate-100"></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    /* --- KONFIGURASI FILTER --- */
    const chevron = document.getElementById('chevron-icon');
    const filterText = document.getElementById('filter-text');
    let isOpen = false;

    function toggleFilter() {
        isOpen = !isOpen;
        // Rotasi ikon panah
        if (chevron) chevron.classList.toggle('rotate-180', isOpen);
    }

    function updateFilter(select) {
        filterText.innerText = select.options[select.selectedIndex].text;
        toggleFilter();
        renderMatrix();
    }

    function initFilter() {
        const select = document.getElementById('filter-bulan');
        const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        months.forEach((m, i) => {
            select.innerHTML += `<option value="${i+1}">${m.toUpperCase()} 2026</option>`;
        });
    }

    /* --- FUNGSI RENDER JADWAL --- */
    function renderMatrix() {
        const tbody = document.getElementById('tabel-jadwal');
        tbody.innerHTML = "";
        const jamKerja = Array.from({length: 16}, (_, i) => i + 8);

        for(let i=0; i<30; i++) {
            let d = new Date(2026, 5, i + 1);
            let row = document.createElement('tr');
            row.innerHTML = `<td class="p-4 font-black text-[10px] text-slate-800 bg-white border-r text-center uppercase">${d.toLocaleDateString('id-ID', { weekday: 'short' })}, ${d.getDate()}</td>`;

            jamKerja.forEach(jam => {
                let cell = document.createElement('td');
                cell.className = "border-r border-slate-100 p-2 text-center";
                // Contoh logika: jika ada booking, panggil fungsi verifikasi saat diklik
                cell.innerHTML = (jam === 12) ? `<button class="btn-istirahat">ISTIRAHAT</button>` : `<div class="h-9 w-full hover:bg-blue-50 cursor-pointer" onclick="verifikasiBooking(1, 'Contoh Customer', 'B 1234 ABC')"></div>`;
                row.appendChild(cell);
            });
            tbody.appendChild(row);
        }
    }

    /* --- FUNGSI VERIFIKASI (SWEETALERT2) --- */
    function verifikasiBooking(id, nama, nopol) {
        Swal.fire({
            title: 'Verifikasi Booking',
            html: `Terima booking dari <b>${nama}</b><br>Plat: <b>${nopol}</b>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Terima & Masukkan Antrean'
        }).then((result) => {
            if (result.isConfirmed) {
                // Pastikan route ini sesuai dengan routes/web.php Anda
                fetch(`/booking/verify/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(res => res.json())
                .then(data => {
                    Swal.fire('Berhasil!', 'Data sudah masuk ke Status Progress.', 'success');
                    renderMatrix();
                })
                .catch(err => {
                    Swal.fire('Error', 'Gagal memproses verifikasi.', 'error');
                });
            }
        });
    }

    /* --- INITIALIZATION --- */
    document.addEventListener("DOMContentLoaded", () => {
        initFilter();
        renderMatrix();
        lucide.createIcons();
    });
</script>
@endsection
