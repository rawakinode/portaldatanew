<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenelitiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penelitians', function (Blueprint $table) {
            $table->id();
            $table->string('ids')->unique();
            $table->integer('kode_prodi');
            $table->integer('tahun');
            $table->string('judul');
            $table->string('tema');
            $table->string('rujukan_tema')->nullable();
            $table->string('integrasi_pembelajaran')->nullable();
            $table->json('dosen');
            $table->json('mahasiswa')->nullable();
            $table->enum('sumber_dana',[ 
                'mandiri',
                'perguruan tinggi',
                'nasional',
                'internasional',
            ]);
            $table->bigInteger('jumlah_dana');
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
        Schema::dropIfExists('penelitians');
    }
}
