<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->string('plat_nomor');
            $table->string('jenis_kendaraan'); // Mobil/Motor
            $table->string('paket_cuci'); // Reguler/Premium/Full Service
            $table->decimal('total_bayar', 10, 2);
            $table->enum('status', ['antri', 'proses', 'selesai'])->default('antri');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
