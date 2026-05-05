<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    // Sesuaikan nama tabel jika bukan 'bahans'
    protected $table = 'bahans';

    protected $fillable = [
        'nama_bahan',
        'stok',
        // tambahkan kolom lain jika ada
    ];
}
