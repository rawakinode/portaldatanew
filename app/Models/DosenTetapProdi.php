<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenTetapProdi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function dosen_prodi()
    {
        return $this->belongsTo(DosenHomebase::class, 'nidn', 'nidn');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode', 'kode');
    }

    public function pembimbing()
    {
        return $this->hasMany(PembimbingTugasAkhir::class, 'nidn', 'nidn');
    }
    
}
