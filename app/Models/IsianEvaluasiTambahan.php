<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsianEvaluasiTambahan extends Model
{
    protected $fillable = [
        'subpengaturan_id', 'kode_prodi', 'tahun', 'verifikasi', 'judul', 'alasan','tanggal',
        'dokumen1', 'dokumen2', 'dokumen3', 'dokumen4', 'komentar'
    ];
}
