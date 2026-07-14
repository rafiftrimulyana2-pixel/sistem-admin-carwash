<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    // Laravel akan otomatis mengisi created_at dan updated_at
    protected $fillable = ['keterangan', 'nominal', 'kategori'];
}
