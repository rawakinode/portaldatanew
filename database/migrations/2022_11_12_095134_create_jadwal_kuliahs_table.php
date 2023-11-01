<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalKuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kode_prodi');
            $table->string('kode_mk');
            $table->integer('tahun');
            $table->integer('semester');
            $table->string('kelas');
            $table->string('ruang');
            $table->integer('hari');
            $table->string('jam_mulai')->nullable();
            $table->string('jam_selesai')->nullable();
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
        Schema::dropIfExists('jadwal_kuliahs');
    }
}
