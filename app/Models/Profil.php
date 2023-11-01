<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    protected $guarded = ['id'];

    public function akreditasi_rincian()
    {
        return $this->hasOne(Akreditasi::class, 'code', 'akreditasi');
    }

    public function prodi() {
        return $this->hasOne(Prodi::class, 'kode', 'kode');
    }
}
