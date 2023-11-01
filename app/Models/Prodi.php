<?php

namespace App\Models;

use App\Traits\StatusPeriodeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    use StatusPeriodeTrait;

    protected $fillable = [
        'nama', 'kode', 'fakultas', 'jenjang'
    ];

    public function profil()
    {
        return $this->hasOne(Profil::class, 'kode', 'kode')->with('akreditasi_rincian');
    }

    public function faculty()
    {
        return $this->hasOne(Faculty::class, 'code', 'fakultas');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'id', 'account');
    }

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'kode_prodi', 'kode');
    }

    public function status_mahasiswa()
    {
        return $this->hasMany(StatusMahasiswa::class, 'kode_prodi', 'kode');
    }

    public function dosen()
    {
        return $this->hasMany(DosenTetapProdi::class, 'kode', 'kode');
    }

    public function isian()
    {
        return $this->hasMany(IsianPengaturan::class, 'kode_prodi', 'kode');
    }

    public function publikasi()
    {
        return $this->hasMany(Publikasi::class, 'kode_prodi', 'kode');
    }

    public function penelitian()
    {
        return $this->hasMany(Penelitian::class, 'kode_prodi', 'kode');
    }

    public function pengabdian()
    {
        return $this->hasMany(Pengabdian::class, 'kode_prodi', 'kode');
    }

    public function kerjasama()
    {
        return $this->hasMany(Kerjasama::class, 'kode_prodi', 'kode');
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'kode_prodi', 'kode');
    }

    public function matakuliah()
    {
        return $this->hasMany(MataKuliah::class, 'kode_prodi', 'kode');
    }

    public function jadwal()
    {
        return $this->hasMany(JadwalKuliah::class, 'kode_prodi', 'kode');
    }

    public function tabel_instrumen()
    {
        return $this->hasMany(InstrumenAkreditasiSelected::class, 'kode_prodi', 'kode');
    }

    public function tugas_akhir()
    {
        return $this->hasMany(PembimbingTugasAkhir::class, 'kode_prodi', 'kode');
    }

    public function rekap() {
        return $this->hasMany(RekapProdi::class, 'kode_prodi', 'kode');
    }

    public function dosen_homebase()
    {
        return $this->hasMany(DosenHomebase::class, 'homebase', 'kode');
    }

    
}
