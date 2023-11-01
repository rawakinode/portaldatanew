<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publikasi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'nim', 'penulis_nidn');
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'nidn', 'penulis_nidn');
    }
}
