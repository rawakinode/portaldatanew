<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subpengaturan;
use App\Traits\StatusPeriodeTrait;

class Pengaturan extends Model
{
    use StatusPeriodeTrait;

    protected $fillable = [
        'urutan', 'nama', 'tahun'
    ];

    public function sub_pengaturan()
    {
        $roles = $this->cekRolesByCodeDatabase();
        return $this->hasMany(Subpengaturan::class)->whereRole($roles)->orderBy('urutan', 'ASC')->with('isian');
    }

    public function subpengaturan()
    {
        return $this->hasMany(Subpengaturan::class);
    }

}
