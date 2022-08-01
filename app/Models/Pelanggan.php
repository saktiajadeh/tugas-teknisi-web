<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TugasTeknisi;

class Pelanggan extends Model
{
    protected $table = "pelanggan";

    protected $fillable = ['nama', 'no_telp', 'alamat', 'email'];

    protected $hidden = ['created_at', 'updated_at'];

    public function tugasteknisi() {
        return $this->hasMany(TugasTeknisi::class, 'pelanggan_id', 'id');
    }
}
