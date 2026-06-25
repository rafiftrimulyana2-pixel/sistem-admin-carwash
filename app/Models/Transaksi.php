<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelanggan',
        'plat_nomor',
        'jenis_kendaraan',
        'total_bayar',
        'status',
        'paket_cuci',
    ];
}
