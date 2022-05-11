<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasTeknisi extends Model
{
    protected $table = "tugas_teknisi";

    protected $fillable = ['pelanggan_id', 'kategori_jasa_id', 'detail', 'karyawan_id', 'jam_mulai', 'tanggal_mulai', 'jam_selesai', 'tanggal_selesai', 'foto', 'status'];

    protected $hidden = ['created_at', 'updated_at'];

    public function pelanggan() {
        return $this->hasOne(Pelanggan::class, 'id', 'pelanggan_id');
    }
    public function kategorijasa() {
        return $this->hasOne(KategoriJasa::class, 'id', 'kategori_jasa_id');
    }
    public function karyawan() {
        return $this->hasOne(User::class, 'id', 'karyawan_id');
    }
}
