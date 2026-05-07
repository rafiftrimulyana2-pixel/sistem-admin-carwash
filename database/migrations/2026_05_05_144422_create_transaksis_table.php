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
            $table->string('nama_pelanggan');                                               // Untuk Nama Pemilik
            $table->string('plat_nomor');                                                   // Untuk Plat Nomor
            $table->string('jenis_kendaraan');                                              // Untuk kategori (Mobil/Motor)
            $table->string('paket_cuci');                                                   // Untuk pilihan paket layanan
            $table->decimal('total_bayar', 10, 2);                                          // Untuk menyimpan harga (misal: 45000)
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
