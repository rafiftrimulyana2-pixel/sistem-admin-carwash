@extends('layouts.workspace')

@section('content')
<style>
    .monitor-area {
        background-color: #f1f5f9;
        padding: 30px;
        font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
    }

    /* HEADER: BIRU DASHBOARD & KOTAK SIKU */
    .header-box-premium {
        background-color: #2563eb;
        padding: 25px 35px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 20px 40px rgba(0,0,0,0.25); /* Bayangan Hitam Abu Deep */
        margin-bottom: 40px;
        border-radius: 0px !important;
    }

    /* GRID: 4 KOLOM RAPAT */
    .grid-mekanik-sistem {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
    }

    /* KARTU MEKANIK */
    .card-mekanik-premium {
        background: white;
        border: 1px solid #e2e8f0;
        position: relative;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        border-radius: 0px !important;
    }

    .line-indicator {
        position: absolute;
        top: 0;
        left: 0;
        width: 6px;
        height: 100%;
    }

    /* BADGE STATUS */
    .badge-status-siku {
        font-size: 8px;
        font-weight: 800;
        padding: 4px 10px;
        text-transform: uppercase;
        border: 1px solid;
    }

    /* INFO BOX TUGAS */
    .box-info-tugas-rapat {
        background: #f8fafc;
        padding: 12px;
        border: 1px solid #f1f5f9;
        margin: 15px 0;
    }

    /* TYPOGRAPHY */
    .font-tebal { font-weight: 800; text-transform: uppercase; margin: 0; }
    .font-kecil { font-weight: 700; font-size: 8px; text-transform: uppercase; color: #94a3b8; }

    /* TOMBOL */
    .btn-siku-hitam {
        width: 100%;
        padding: 12px;
        background: #0f172a;
        color: white;
        font-weight: 800;
        font-size: 10px;
        text-transform: uppercase;
        border: none;
        cursor: pointer;
        letter-spacing: 1px;
    }
</style>

<div class="monitor-area">

    <div class="header-box-premium">
        <div>
            <h1 class="font-tebal" style="color: white; font-size: 22px; font-style: italic;">Personnel Monitoring</h1>
            <p class="font-kecil" style="color: #bfdbfe; font-size: 10px; letter-spacing: 3px; margin-top: 5px;">
                DATABASE AKTIVITAS & JADWAL AKTIF MEKANIK
            </p>
        </div>
        <div style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); padding: 10px 25px; text-align: center;">
            <span id="date-live" class="font-tebal" style="color: white; font-size: 10px;">FRIDAY, 15 MAY 2026</span>
            <div style="height: 1px; background: rgba(255,255,255,0.2); margin: 5px 0;"></div>
            <span id="time-live" class="font-tebal" style="color: #93c5fd; font-size: 13px;">10:45:00 AM</span>
        </div>
    </div>

    <div class="grid-mekanik-sistem">

        <div class="card-mekanik-premium">
            <div class="line-indicator" style="background: #10b981;"></div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <h3 class="font-tebal" style="font-size: 13px; color: #1e293b;">Ahmad Subarjo</h3>
                    <p style="color: #2563eb; font-weight: 700; font-size: 8px; margin-top: 4px;">ID: MKN-001</p>
                </div>
                <span class="badge-status-siku" style="background: #ecfdf5; color: #059669; border-color: #d1fae5;">Available</span>
            </div>

            <div style="margin-top: 20px;">
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 8px;">
                    <span class="font-kecil">Spesialis:</span>
                    <span class="font-tebal" style="font-size: 9px;">INTERIOR TECH</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span class="font-kecil">Shift:</span>
                    <span class="font-tebal" style="font-size: 9px;">PAGI (08:00)</span>
                </div>
            </div>
            <button class="btn-siku-hitam" style="margin-top: 20px;">Assign Unit</button>
        </div>

        <div class="card-mekanik-premium">
            <div class="line-indicator" style="background: #f59e0b;"></div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <h3 class="font-tebal" style="font-size: 13px; color: #1e293b;">Rian Hidayat</h3>
                    <p style="color: #2563eb; font-weight: 700; font-size: 8px; margin-top: 4px;">ID: MKN-002</p>
                </div>
                <span class="badge-status-siku" style="background: #fffbeb; color: #d97706; border-color: #fef3c7;">On Duty</span>
            </div>

            <div class="box-info-tugas-rapat">
                <div style="display: flex; justify-content: space-between;">
                    <span class="font-kecil">Plat Unit:</span>
                    <span class="font-tebal" style="font-size: 9px; font-style: italic;">B 1234 XYZ</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-top: 6px;">
                    <span class="font-kecil">Destinasi:</span>
                    <span class="font-tebal" style="font-size: 9px; color: #2563eb;">CENTRAL PARK</span>
                </div>
            </div>

            <div style="margin-top: 10px;">
                <div style="display: flex; justify-content: space-between;">
                    <span class="font-kecil">Progress:</span>
                    <span class="font-tebal" style="font-size: 9px; color: #d97706;">75%</span>
                </div>
                <div style="width: 100%; height: 4px; background: #f1f5f9; margin-top: 5px;">
                    <div style="width: 75%; height: 100%; background: #f59e0b;"></div>
                </div>
            </div>
            <button class="btn-siku-hitam" style="background: #94a3b8; cursor: not-allowed; margin-top: 15px;">In Progress</button>
        </div>

        <div style="border: 3px dashed #cbd5e1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 25px; background: #f8fafc; cursor: pointer;">
            <div style="width: 35px; height: 35px; background: white; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #cbd5e1; font-size: 20px;">+</div>
            <span class="font-kecil" style="margin-top: 10px;">Tambah Personil</span>
        </div>

    </div>
</div>

<script>
    function updateClockLive() {
        const d = new Date();
        document.getElementById('time-live').innerText = d.toLocaleTimeString('en-US', { hour12: true });
        document.getElementById('date-live').innerText = d.toLocaleDateString('en-GB', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }).toUpperCase();
    }
    setInterval(updateClockLive, 1000);
    updateClockLive();
</script>
@endsection
