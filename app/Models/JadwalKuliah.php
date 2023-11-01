<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function mata_kuliah()
    {
        return $this->hasOne(MataKuliah::class, 'kode', 'kode_mk');
    }

    public function dosen_pengajar()
    {
        return $this->hasMany(JadwalPengajar::class, 'jadwal_kuliah_id', 'id')->orderBy('dosen_ke', 'DESC');
    }
    
}
