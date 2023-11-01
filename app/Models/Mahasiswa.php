<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $guarded = ['id'];

    public function status_mahasiswa()
    {
        return $this->hasOne(StatusMahasiswa::class, 'mahasiswa_id', 'id');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode');
    }

    public function tracer()
    {
        return $this->hasMany(TracerStudy::class, 'nim', 'nim');
    }

    public function pengguna_lulusan()
    {
        return $this->hasMany(PenggunaLulusan::class, 'nim', 'nim');
    }

}
