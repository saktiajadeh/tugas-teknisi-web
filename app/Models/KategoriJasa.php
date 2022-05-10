<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriJasa extends Model
{
    protected $table = "kategori_jasa";

    protected $fillable = ['nama'];

    protected $hidden = ['created_at', 'updated_at'];
}
