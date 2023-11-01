<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumenAkreditasi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function instrumen_terpilih()
    {
        return $this->hasOne(InstrumenAkreditasiSelected::class, 'slug', 'slug');
    }
}
