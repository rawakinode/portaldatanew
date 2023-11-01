<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKerjasamasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kerjasamas', function (Blueprint $table) {
            $table->id();
            $table->string('ids')->unique();
            $table->integer('kode_prodi');
            $table->integer('tahun');
            $table->string('nama');
            $table->string('judul');
            $table->string('output');
            $table->string('durasi', 100);
            $table->enum('bidang',[ 
                'pendidikan',
                'penelitian',
                'pengabdian kepada masyarakat',
                'pengembangan kelembagaan',
            ])->nullable();
            $table->enum('tingkat',[ 
                'internasional',
                'nasional',
                'lokal',
            ])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kerjasamas');
    }
}
