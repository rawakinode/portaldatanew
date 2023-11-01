<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $guarded = [
        'id'
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode', 'kode');
    }

    public function pembimbing(){
        
        return $this->hasMany(PembimbingTugasAkhir::class, 'nidn', 'nidn');
    }
}
