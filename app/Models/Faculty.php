<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = [
        'code', 'name', 'singkatan'
    ];

    public function prodi()
    {
        return $this->hasMany(Prodi::class, 'fakultas', 'code');
    }

}
