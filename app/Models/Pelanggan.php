<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = "pelanggan";

    protected $fillable = ['nama', 'no_telp', 'alamat', 'email'];

    protected $hidden = ['created_at', 'updated_at'];
}
