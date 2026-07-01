<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Penting agar bisa login
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama', 'email', 'no_hp', 'no_plat', 'password',
    ];

    protected $hidden = [
        'password',
    ];
}
