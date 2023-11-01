<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkreditasiRekapUniversitas extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Mengaktifkan timestamps
    public $timestamps = true;
}
