<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
   protected $fillable = [
        'nama_pelanggan',
        'plat_nomor',
        'jenis_paket',
        'status',
        'total_bayar',
        'layanan',
        'biaya',
        'deskripsi',
        'petugas',
        'step',
    ];
}
