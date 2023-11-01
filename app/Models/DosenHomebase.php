<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenHomebase extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function prodi_homebase()
    {
        return $this->belongsTo(Prodi::class, 'homebase', 'kode');
    }

    public function dosen_prodi()
    {
        return $this->hasMany(DosenTetapProdi::class, 'nidn', 'nidn');
    }

    public function mahasiswa_bimbingan()
    {
        return $this->belongsTo(PembimbingTugasAkhir::class, 'nidn', 'nidn');
    }


}
