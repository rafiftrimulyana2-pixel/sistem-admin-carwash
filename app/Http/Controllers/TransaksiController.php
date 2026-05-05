<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function create()
    {
        // Memanggil file resources/views/transaksi/create.blade.php
        return view('transaksi.create');
    }
}
