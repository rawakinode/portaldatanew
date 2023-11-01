<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembimbingTugasAkhir extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function dosen_homebase()
    {
        return $this->hasOne(DosenHomebase::class, 'nidn', 'nidn');
    }
}
