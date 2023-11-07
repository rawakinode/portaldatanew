<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortalMahasiswaAktif extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode');
    }

    public function faculty()
    {
        return $this->hasOne(Faculty::class, 'code', 'fakultas');
    }

}
