<?php

namespace App\Models;

use App\Traits\StatusPeriodeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subpengaturan extends Model
{
    use StatusPeriodeTrait;

    protected $fillable = [
        'urutan', 'tipe', 'pengaturan_id', 'role', 'judul', 'berkas'
    ];

    public function isian()
    {
        $kodeprodi = auth()->user()->prodi['kode'];
        return $this->hasOne(IsianPengaturan::class)->where('kode_prodi',$kodeprodi);
    }

    public function pengaturan()
    {
        return $this->belongsTo(Pengaturan::class);
    }

    public function isian_by_prodi()
    {
        return $this->hasOne(IsianPengaturan::class);
    }
}
